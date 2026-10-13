// Chạy Code.gs trong môi trường giả lập SpreadsheetApp để kiểm tra logic (không cần Google).
import assert from 'node:assert/strict';
import fs from 'node:fs';
import vm from 'node:vm';
import crypto from 'node:crypto';
import path from 'node:path';
import { fileURLToPath } from 'node:url';
const here = path.dirname(fileURLToPath(import.meta.url));

class Sheet {
  constructor(name, header) { this.name = name; this.rows = [header]; }
  getName() { return this.name; }
  getLastRow() { return this.rows.length; }
  getMaxRows() { return 60; }
  getLastColumn() { return Math.max(1, ...this.rows.map((r) => r.length)); }
  getMaxColumns() { return 60; }
  insertColumnsAfter() {}
  appendRow(r) { this.rows.push(r.slice()); }
  deleteRow(n) { this.rows.splice(n - 1, 1); }
  getRange(r, c, nr = 1, nc = 1) {
    const s = this;
    return {
      getValues: () => Array.from({ length: nr }, (_, i) => Array.from({ length: nc }, (_, j) => (s.rows[r - 1 + i] || [])[c - 1 + j] ?? '')),
      getValue: () => (s.rows[r - 1] || [])[c - 1] ?? '',
      getDisplayValues: () => Array.from({ length: nr }, (_, i) => Array.from({ length: nc }, (_, j) => String((s.rows[r - 1 + i] || [])[c - 1 + j] ?? ''))),
      setValues: (v) => v.forEach((row, i) => row.forEach((x, j) => { (s.rows[r - 1 + i] ||= [])[c - 1 + j] = x; })),
      setValue: (x) => { (s.rows[r - 1] ||= [])[c - 1] = x; },
      setNumberFormat() {},
      getSheet: () => s, getColumn: () => c, getRow: () => r,
    };
  }
}
const sheets = {
  'Khách hàng': new Sheet('Khách hàng', []),
  'Hoạt động': new Sheet('Hoạt động', []),
  'Website': new Sheet('Website', ['Tên', 'Domain', 'Mã']),
  'Lượt bấm': new Sheet('Lượt bấm', []),
  'Tổng quan': new Sheet('Tổng quan', []),
  'Chiến dịch': new Sheet('Chiến dịch', ['Nền tảng', 'Tên', 'utm']),
  'Chi phí': new Sheet('Chi phí', ['Ngày', 'utm', 'Chi phí', 'Hiển thị', 'Click']),
};
sheets.Website.appendRow(['Landing A', 'a.com', 'testkey12345']);
// Ô tick đã dựng sẵn FALSE tới dòng 40 (giống file thật): getLastRow() sẽ sai, mã phải bỏ qua chúng
for (let i = 1; i < 40; i++) { (sheets['Khách hàng'].rows[i] ||= [])[14] = false; (sheets['Lượt bấm'].rows[i] ||= [])[8] = false; }
const out = (o) => ({ setMimeType() { return { body: o }; } });
const ctx = vm.createContext({
  SpreadsheetApp: { openById: (id) => { if (id.startsWith('BAD')) throw new Error('no'); return globalThis.__ext; }, getActiveSpreadsheet: () => ({ getId: () => 'x', getSheetByName: (n) => sheets[n], insertSheet: (n) => (sheets[n] = new Sheet(n, [])), getOwner: () => ({ getEmail: () => 'owner@gmail.com' }) }), getUi: () => ({ alert(m) { globalThis.__alert = m; }, showModelessDialog(h, title) { globalThis.__dialog = { h, title }; } }) },
  UrlFetchApp: { fetch: (u, o) => { globalThis.__fetch = { u, o }; return { getResponseCode: () => 200, getContentText: () => JSON.stringify({ content: [{ text: 'Trả lời thử' }] }) }; } },
  CacheService: { getScriptCache: () => ({ get: () => null, put() {} }) },
  LockService: { getScriptLock: () => ({ waitLock() {}, releaseLock() {} }) },
  ContentService: { createTextOutput: (b) => ({ body: b, setMimeType(m) { this.mime = m; return this; } }), MimeType: { JSON: 'json', JAVASCRIPT: 'js' } },
  Session: { getActiveUser: () => { throw new Error('Session không được dùng'); }, getEffectiveUser: () => { throw new Error('Session không được dùng'); } },
  HtmlService: { createHtmlOutputFromFile: (n) => ({ file: n, setTitle() { return this; }, addMetaTag() { return this; }, getContent: () => fs.readFileSync(path.join(here, fs.existsSync(path.join(here, n + '.html')) ? n + '.html' : 'chia/' + n + '.html'), 'utf8') }), createHtmlOutput: (c) => ({ content: c, setTitle() { return this; }, addMetaTag() { return this; }, setWidth() { return this; }, setHeight() { return this; } }) },
  PropertiesService: { getScriptProperties: () => ({ getProperty: (k) => globalThis.__props?.[k] ?? null, setProperty: (k, v) => { (globalThis.__props ||= {})[k] = v; }, deleteProperty: (k) => { delete globalThis.__props?.[k]; } }) },
  Logger: { log: (m) => (globalThis.__log ||= []).push(m) },
  Utilities: { getUuid: () => crypto.randomUUID(), formatDate: (d) => new Date(d.getTime() + 7 * 3600e3).toISOString().slice(0, 10) },
  ScriptApp: { getService: () => ({ getUrl: () => 'https://script.google.com/macros/s/X/exec' }) },
  console,
});
vm.runInContext(fs.readFileSync(path.join(here, 'Code.gs'), 'utf8'), ctx);
const post = (body, parameter = {}) => JSON.parse(ctx.doPost({ postData: { contents: typeof body === 'string' ? body : JSON.stringify(body) }, parameter }).body);

assert.equal(post({ key: 'wrong', type: 'pageview' }).error, 'Mã website không hợp lệ');
assert.equal(post({ key: 'testkey12345', action: 'track', type: 'pageview', vid: 'v1', url: 'https://a.com', utm_source: 'facebook', utm_campaign: 'sale' }).ok, true);
assert.equal(post({ key: 'testkey12345', action: 'track', type: 'click', channel: 'zalo', vid: 'v1' }).ok, true);
assert.equal(sheets['Hoạt động'].rows.length, 3); // dòng tiêu đề + 2 sự kiện
assert.equal(sheets['Lượt bấm'].rows.length, 40, 'lượt bấm ghi đè vào dòng trống đầu tiên, không ra ngoài bảng');
assert.equal(sheets['Hoạt động'].rows[2][4], 'zalo');
// lượt bấm đi vào tab Lượt bấm kèm công thức cảnh báo; lượt xem thì không
const ck = sheets['Lượt bấm'].rows[1];
assert.equal(ck[3], 'zalo'); assert.equal(ck[8], false); assert.match(ck[7], /COUNTIF\('Khách hàng'!\$I:\$I,\$B2\)/); assert.match(ck[10], /CHƯA XỬ LÝ/);

// form: tạo khách mới, SĐT giữ số 0, tên bắt đầu bằng "=" bị vô hiệu hoá
let r = post({ key: 'testkey12345', action: 'lead', vid: 'v1', name: '=IMPORTXML("x")', phone: '+84 912 345 678', utm_source: 'facebook', utm_campaign: 'sale', message: 'cần 2PN' });
assert.deepEqual([r.ok, r.new], [true, true]);
assert.equal(sheets['Khách hàng'].rows.length, 40, 'khách mới nằm ở dòng 2, không ra ngoài bảng');
const lead = sheets['Khách hàng'].rows[1];
assert.equal(lead[3], '0912345678'); assert.equal(lead[2][0], "'"); assert.equal(lead[5], 'Landing A');
assert.match(lead[10], /COUNTIFS\(.*\$I2,/); assert.match(lead[17], /\$O2<>TRUE/);
assert.equal(lead[18], 'Mới'); assert.equal(lead[14], false);

// gửi lại cùng SĐT -> không tạo dòng mới, tăng số lần gửi
r = post({ key: 'testkey12345', action: 'lead', phone: '0912345678', name: 'Nam', email: 'a@b.c' });
assert.equal(r.new, false); assert.equal(sheets['Khách hàng'].rows.length, 40); assert.equal(sheets['Khách hàng'].rows[1][9], 2);

// webhook form-encoded (key trong ?key=, trường trong parameter)
r = JSON.parse(ctx.doPost({ postData: { contents: 'phone=0988111222&name=B' }, parameter: { key: 'testkey12345', phone: '0988111222', name: 'B' } }).body);
assert.equal(r.new, true); assert.equal(sheets['Khách hàng'].rows[2][3], '0988111222');
assert.equal(sheets['Khách hàng'].rows.length, 40); assert.equal(sheets['Khách hàng'].rows[2][10].includes('$I3'), true);

assert.equal(post({ key: 'testkey12345', action: 'lead', phone: '12' }).error, 'Số điện thoại không hợp lệ');
assert.equal(post('not json at all').error, 'Mã website không hợp lệ');

// tick "Đã gọi" -> ghi giờ và đổi trạng thái
const sh = sheets['Khách hàng'];
sh.getRange(2, 15).setValue(true);
ctx.onEdit({ range: sh.getRange(2, 15) });
assert.equal(typeof sh.rows[1][16].getTime, 'function'); assert.equal(sh.rows[1][18], 'Đã liên hệ');

// doGet trả về mã theo dõi, có nhận diện Google
const js = ctx.doGet({ parameter: { js: '1' } }); assert.equal(js.mime, 'js'); assert.match(js.body, /script\\.google/); assert.match(js.body, /action/);
// ---- giao diện CRM (API cho Crm.html), mở bằng link có khoá ----
const T = sheets['Tổng quan']; for (let i = 0; i < 16; i++) T.rows[i] = [];
T.rows[6] = ['Khách chưa gọi, chưa nhắn', 1]; T.rows[7] = ['Khách để lại SĐT', 2]; T.rows[14] = ['Lượt bấm chưa xử lý', 1];
T.rows[16] = ['Website', 'Truy cập']; T.rows[17] = ['Landing A', 3];
// chưa có khoá / không có khoá: không vào được, doGet chỉ trả JSON
assert.throws(() => ctx.crmLoad(''), /Không có quyền/);
assert.equal(JSON.parse(ctx.doGet({ parameter: {} }).body).ok, true);
// tạo link qua menu: ?k=KHOÁ
sheets['Website'].getRange(2, 7).setValue('https://script.google.com/macros/s/AKfycbTEST/exec');
ctx.showCrmLink();
const link = globalThis.__alert.match(/\?k=([0-9a-f]{32})/); assert.ok(link, 'link có khoá'); const K = link[1];
assert.equal(ctx.crmKey_(), K);
assert.throws(() => ctx.crmLoad('sai-khoa'), /Không có quyền/); assert.throws(() => ctx.crmLog('', '0988111222', 'call'), /Không có quyền/);
assert.equal(ctx.doGet({ parameter: { k: 'sai' } }).file, undefined); assert.ok(ctx.doGet({ parameter: { k: K } }).content.includes('CRM Hoàng Hiệp') && ctx.doGet({ parameter: { k: K } }).content.includes('</html>'));
const dbg = JSON.parse(ctx.doGet({ parameter: { debug: '1' } }).body);
assert.equal(dbg.hasKey, true); assert.equal(dbg.hasCrmHtml, true); assert.equal(dbg.version, 'ui-34'); assert.equal(JSON.stringify(dbg).includes(K), false);
const L = ctx.crmLoad(K);
assert.equal(L.leads.length, 2);
const l0 = L.leads.find((x) => x.phone === '0988111222');
assert.ok(l0 && l0.status === 'Mới' && l0.called === false && l0.site === 'Landing A');
assert.equal(L.kpis.length, 3); assert.equal(L.sites.length, 1); assert.equal(L.clicks.length, 1);
const lg = ctx.crmLog(K, '0988 111 222', 'call');
assert.equal(lg.called, true); assert.equal(lg.status, 'Đã liên hệ'); assert.ok(lg.contactedAt);
assert.throws(() => ctx.crmLog(K, '0900000000', 'call'), /Không tìm thấy/); assert.throws(() => ctx.crmLog(K, '0988111222', 'xyz'), /không hợp lệ/);
ctx.crmUpdateLead(K, '0988111222', { status: 'Chốt', value: 5000000, assignee: 'Hanh', note: 'xem nhà 15/10' });
const l1 = ctx.crmLoad(K).leads.find((x) => x.phone === '0988111222');
assert.deepEqual([l1.status, l1.value, l1.assignee, l1.note], ['Chốt', 5000000, 'Hanh', 'xem nhà 15/10']);
assert.throws(() => ctx.crmUpdateLead(K, '0988111222', { status: 'abc' }), /không hợp lệ/);
const ck0 = ctx.crmLoad(K).clicks[0];
assert.throws(() => ctx.crmClickDone(K, ck0.row, 'sai-vid', true), /thay đổi/);
ctx.crmClickDone(K, ck0.row, ck0.vid, true, 'đã xem Zalo');
const ck1 = ctx.crmLoad(K).clicks[0]; assert.equal(ck1.checked, true); assert.equal(ck1.note, 'đã xem Zalo'); assert.ok(ck1.handledAt, 'ghi giờ xử lý');
ctx.crmClickDone(K, ck0.row, ck0.vid, false); assert.equal(ctx.crmLoad(K).clicks[0].handledAt, ''); ctx.crmClickDone(K, ck0.row, ck0.vid, true, 'đã xem Zalo');
assert.ok(ctx.crmEvents(K, 'v1').length >= 2); assert.equal(ctx.crmEvents(K, '').length, 0);
// đổi link: khoá cũ hết hiệu lực
ctx.resetCrmLink(); const K2 = globalThis.__alert.match(/\?k=([0-9a-f]{32})/)[1];
assert.notEqual(K2, K); assert.throws(() => ctx.crmLoad(K), /Không có quyền/); assert.ok(ctx.crmLoad(K2).leads.length === 2);
// mở giao diện ngay trong file Sheet: khoá được gắn sẵn, không còn dấu hiệu thay thế
ctx.moGiaoDienCRM();
assert.equal(globalThis.__dialog.title, 'CRM Hoàng Hiệp');
assert.ok(globalThis.__dialog.h.content.includes("var KEY = \"" + ctx.crmKey_() + "\""), 'khoá gắn vào giao diện');
assert.equal(globalThis.__dialog.h.content.includes('__KEY__'), false);
assert.equal(ctx.crmDialogKey(), ctx.crmKey_());
// hàm tự kiểm tra
const ret = ctx.kiemTraCRM(); assert.match(ret, /\?k=[0-9a-f]{32}/); assert.ok(globalThis.__log.some((m) => /Đọc dữ liệu OK/.test(m))); assert.ok(globalThis.__log.some((m) => /File giao diện Crm: có/.test(m)));
// hồ sơ mở rộng, nhật ký chăm sóc, lịch sử chuyển giao
{
  const KK = ctx.crmKey_();
  const lead = ctx.crmLoad(KK).leads[0];
  ctx.crmUpdateLead(KK, lead.phone, { next: '2026-10-15', budget: '2,5 tỷ', purpose: 'Đầu tư', product: '2PN FourS Tower', heat: 'Nóng', loan: 'Có', assignee: 'Minh', reason: 'Giao sale mới' });
  ctx.crmUpdateLead(KK, lead.phone, { assignee: 'Lan Anh', reason: 'Minh nghỉ' });
  const l2 = ctx.crmLoad(KK).leads.find((x) => x.phone === lead.phone);
  assert.equal(l2.next, '2026-10-15'); assert.equal(l2.budget, '2,5 tỷ'); assert.equal(l2.heat, 'Nóng'); assert.equal(l2.loan, 'Có'); assert.equal(l2.assignee, 'Lan Anh');
  assert.throws(() => ctx.crmAddLog(KK, lead.phone, { type: 'Gọi điện' }), /Chưa nhập nội dung/);
  ctx.crmAddLog(KK, lead.phone, { type: 'Gọi điện', content: 'Khách hỏi giá', result: 'Hẹn xem', next: '2026-10-20' });
  ctx.crmAddLog(KK, lead.phone, { type: 'Loại lạ', content: '=SUM(1)' });
  const lg = ctx.crmLogs(KK, lead.phone);
  const man = lg.logs.filter((x) => !/^Đổi trạng thái/.test(x.content));
  assert.equal(man.length, 2); assert.equal(man[1].type, 'Gọi điện'); assert.equal(man[1].next, '2026-10-20');
  assert.equal(man[0].type, 'Ghi chú'); assert.equal(man[0].content, "'=SUM(1)");
  assert.ok(lg.moves.length >= 2); assert.equal(lg.moves[0].to, 'Lan Anh'); assert.equal(lg.moves[0].from, 'Minh'); assert.equal(lg.moves[1].to, 'Minh');
  assert.equal(ctx.crmLoad(KK).leads.find((x) => x.phone === lead.phone).next, '2026-10-20');
  assert.throws(() => ctx.crmAddLog('sai', lead.phone, { content: 'x' }), /Không có quyền/);
}
// trạng thái mới + lý do, hồ sơ cá nhân/tài chính mở rộng, tóm tắt từ lịch sử, xem dự án
{
  const KK = ctx.crmKey_();
  const lead = ctx.crmLoad(KK).leads[0];
  assert.throws(() => ctx.crmUpdateLead(KK, lead.phone, { status: 'Không có' }), /Trạng thái không hợp lệ/);
  ctx.crmUpdateLead(KK, lead.phone, { status: 'Tạm dừng', statusReason: 'Khách đi nước ngoài', province: 'Hà Nội', phone2: '0911000111', zalo: 'Đã kết nối', dob: '1985-03-15', job: 'Kinh doanh', bmin: '2 tỷ', bmax: '3 tỷ', equity: '1 tỷ', loanAmt: '1,5 tỷ', buyTime: 'Quý 1/2027', undecided: 'Chờ bán nhà cũ', project: 'Sun FourS Tower', product: 'loại 80m2', district: 'Cầu Giấy', address: '12 Trần Thái Tông' });
  let L = ctx.crmLoad(KK).leads.find((x) => x.phone === lead.phone);
  assert.equal(L.status, 'Tạm dừng'); assert.equal(L.province, 'Hà Nội'); assert.equal(L.dob, '1985-03-15'); assert.equal(L.budget, '2 tỷ – 3 tỷ'); assert.equal(L.bmin, '2 tỷ'); assert.equal(L.equity, '1 tỷ'); assert.equal(L.undecided, 'Chờ bán nhà cũ'); assert.equal(L.district, 'Cầu Giấy'); assert.equal(L.address, '12 Trần Thái Tông'); assert.equal(L.project, 'Sun FourS Tower'); assert.equal(L.product, 'loại 80m2');
  assert.ok(ctx.crmLogs(KK, lead.phone).logs.some((x) => /Tạm dừng.*Khách đi nước ngoài/.test(x.content)));
  const c0 = L.careCount;
  ctx.crmAddLog(KK, lead.phone, { type: 'Nhắn Zalo', content: 'Gửi bảng giá', result: 'Đang cân nhắc', reply: 'Để xem lại', obstacle: 'Giá cao', docs: 'Bảng giá', nextAction: 'Gọi lại thứ 6' });
  L = ctx.crmLoad(KK).leads.find((x) => x.phone === lead.phone);
  assert.equal(L.careCount, c0 + 1); assert.equal(L.careResult, 'Đang cân nhắc'); assert.ok(L.careAt);
  assert.equal(L.viewCount, 0);
  assert.throws(() => ctx.crmAddView(KK, lead.phone, { project: '', at: '2026-10-10' }), /Chưa nhập tên dự án/);
  ctx.crmAddView(KK, lead.phone, { project: 'FourS Tower', at: '2026-10-10', form: 'Trực tiếp', interest: 'Cao', feedback: 'Thích view', obstacle: 'Giá', next: '2026-10-12' });
  ctx.crmAddView(KK, lead.phone, { project: 'Casamia Balanca', at: '2026-10-14', form: 'Tham dự sự kiện', interest: 'Trung bình' });
  L = ctx.crmLoad(KK).leads.find((x) => x.phone === lead.phone);
  assert.equal(L.viewCount, 2); assert.equal(L.viewProject, 'Casamia Balanca'); assert.equal(L.viewAt, '2026-10-14');
  const lv = ctx.crmLogs(KK, lead.phone).views; assert.equal(lv.length, 2); assert.equal(lv[1].project, 'FourS Tower'); assert.equal(lv[1].interest, 'Cao');
  // tạo thủ công: trùng thì không tạo, không tự gộp
  const dup = ctx.crmCreateLead(KK, { name: 'Khác tên', phone: lead.phone.replace(/^0/, '+84') });
  assert.equal(dup.dup, true); assert.equal(dup.lead.phone, lead.phone);
  assert.equal(ctx.crmLoad(KK).leads.find((x) => x.phone === lead.phone).name === 'Khác tên', false);
  const n0 = ctx.crmLoad(KK).leads.length;
  const nw = ctx.crmCreateLead(KK, { name: 'Khách mới', phone: '0977 123 456', province: 'Đà Nẵng', site: 'Tại sự kiện', source: 'sự kiện', bmax: '5 tỷ', status: 'Đang tư vấn' });
  assert.equal(nw.added, true);
  const L2 = ctx.crmLoad(KK).leads.find((x) => x.phone === '0977123456');
  assert.equal(L2.province, 'Đà Nẵng'); assert.equal(L2.status, 'Đang tư vấn'); assert.equal(L2.srcType, 'Nhập thủ công'); assert.equal(L2.source, 'sự kiện'); assert.equal(ctx.crmLoad(KK).leads.length, n0 + 1);
  assert.throws(() => ctx.crmCreateLead(KK, { name: 'x', phone: '123' }), /Số điện thoại không hợp lệ/);
  // nhập danh sách: dòng hợp lệ, trùng, lỗi
  const imp = ctx.crmImport(KK, [{ name: 'A', phone: '0966 000 111', province: 'Hải Phòng' }, { name: 'Trùng', phone: lead.phone }, { name: 'Lỗi', phone: 'abc' }, { name: 'B', phone: '0966000222' }]);
  assert.equal(imp.added, 2); assert.equal(imp.dups.length, 1); assert.equal(imp.dups[0].line, 2); assert.equal(imp.errors.length, 1); assert.equal(imp.errors[0].line, 3);
  assert.equal(ctx.crmLoad(KK).leads.length, n0 + 3);
  assert.throws(() => ctx.crmImport('sai', []), /Không có quyền/);
}
// báo cáo theo khoảng ngày
{
  const KK = ctx.crmKey_();
  const day = (d) => new Date(d + 'T05:00:00Z');
  const ev = sheets['Hoạt động'];
  [['v1', '2026-10-10', 'pageview', 'camp-a'], ['v1', '2026-10-10', 'click', 'camp-a', 'zalo'], ['v2', '2026-10-11', 'pageview', 'camp-a'], ['v3', '2026-10-11', 'pageview', 'camp-b'], ['v4', '2026-09-30', 'pageview', 'camp-a']].forEach(([vid, d, type, utm, ch]) =>
    ev.appendRow([day(d), vid, 'Landing A', type, ch || '', 'https://x', 'google', utm]));
  const cp = sheets['Chi phí'];
  [['2026-10-10', 'camp-a', 300000, 1000, 40], ['2026-10-11', 'camp-a', 200000, 800, 30], ['2026-10-11', 'camp-b', 100000, 500, 5], ['2026-09-29', 'camp-a', 150000, 400, 10]].forEach(([d, u, c, i, k2]) => cp.appendRow([day(d), u, c, i, k2]));
  sheets['Chiến dịch'].appendRow(['Google', 'Chiến dịch A', 'camp-a']);
  const lead = ctx.crmLoad(KK).leads[0];
  const R = ctx.crmReport(KK, '2026-10-10', '2026-10-12');
  assert.equal(R.from, '2026-10-10'); assert.equal(R.to, '2026-10-12'); assert.equal(R.days, 3); assert.equal(R.prev.to, '2026-10-09'); assert.equal(R.prev.from, '2026-10-07');
  const A = R.campaigns.find((c) => c.utm === 'camp-a'), B = R.campaigns.find((c) => c.utm === 'camp-b');
  assert.equal(A.cost, 500000); assert.equal(A.imp, 1800); assert.equal(A.clk, 70); assert.equal(A.visitors, 2); assert.equal(A.zalo, 1); assert.equal(A.name, 'Chiến dịch A'); assert.equal(A.first, '2026-09-29'); assert.equal(A.last, '2026-10-11'); assert.equal(A.activeDays, 2);
  assert.equal(B.cost, 100000); assert.equal(B.name, 'camp-b'); assert.equal(B.visitors, 1);
  assert.equal(R.tot.visitors, 3); assert.equal(R.tot.cost, 600000); assert.equal(R.tot.zalo, 1); assert.equal(R.daily.length, 3); assert.equal(R.daily[0].v, 1); assert.equal(R.daily[1].cost, 300000);
  assert.equal(R.sites.find((x) => x.name === 'Landing A').visitors, 3); assert.equal(typeof R.tot.closed, 'number');
  const R2 = ctx.crmReport(KK, '2026-10-12', '2026-10-10'); assert.equal(R2.from, '2026-10-10');
  assert.equal(ctx.crmReport(KK, '2026-10-01', '2026-10-31').campaigns.find((c) => c.utm === 'camp-a').costPrev, 150000);
  assert.throws(() => ctx.crmReport('sai', '2026-10-10', '2026-10-12'), /Không có quyền/);
  // Hoa hồng / lương
  assert.throws(() => ctx.crmCommLoad('sai'), /Không có quyền/);
  assert.equal(ctx.crmCommLoad(KK).items.length, 0);
  assert.throws(() => ctx.crmCommSave(KK, { month: '' }), /chọn tháng/);
  const c1 = ctx.crmCommSave(KK, { month: '2026-10', type: 'Thưởng GĐKD', unit: 'A21011; A20623', project: 'Sun FourS Tower', total: '13.670.915', prev: 6904503, now: 6766412, net: 6766412, note: '=HYPERLINK("x")' });
  assert.equal(c1.id, 'HH001');
  ctx.crmCommSave(KK, { month: '2026-10', type: 'Lương', net: 15872000 });
  ctx.crmCommSave(KK, { month: '2026-09', type: 'Khong hop le', net: 1000000 });
  let cl = ctx.crmCommLoad(KK);
  assert.equal(cl.items.length, 3); assert.equal(cl.items[0].total, 13670915); assert.equal(cl.items[0].month, '2026-10'); assert.equal(cl.items[2].type, 'Hoa hồng NVKD');
  assert.ok(cl.items[0].note.startsWith("'="), 'chặn công thức');
  assert.equal(cl.mkt['2026-10'], 600000); assert.equal(cl.mkt['2026-09'], 150000);
  ctx.crmCommSave(KK, { row: c1.row, month: '2026-10', type: 'Thưởng GĐKD', net: 7000000 });
  assert.equal(ctx.crmCommLoad(KK).items[0].net, 7000000);
  assert.throws(() => ctx.crmCommSave(KK, { row: 99, month: '2026-10' }), /Không tìm thấy/);
  ctx.crmCommDelete(KK, 3); assert.equal(ctx.crmCommLoad(KK).items.length, 2);
  assert.throws(() => ctx.crmCommDelete(KK, 1), /Không tìm thấy/);
  // Kế hoạch marketing
  assert.equal(ctx.crmCommLoad(KK).plans.length, 0);
  assert.throws(() => ctx.crmPlanSave(KK, { month: '' }), /chọn tháng/);
  const p1 = ctx.crmPlanSave(KK, { month: '2026-10', project: 'Sun FourS Tower', advance: '30.000.000', channels: [{ name: 'Google Ads', budget: '20.000.000', note: 'Search' }, { name: 'Facebook', budget: 10000000 }, { name: '', budget: '' }], tiers: [{ from: 10, to: '', pct: 150 }, { from: 5, to: 9, pct: 50 }, { from: 0, to: 4, pct: 0 }], sold: '' });
  assert.equal(p1.id, 'KH001');
  let pl = ctx.crmPlanLoad ? 0 : ctx.crmCommLoad(KK).plans;
  assert.equal(pl.length, 1); assert.equal(pl[0].budget, 30000000); assert.equal(pl[0].advance, 30000000); assert.equal(pl[0].channels.length, 2);
  assert.equal(pl[0].tiers[0].pct, 100); assert.equal(pl[0].tiers[0].to, ''); assert.equal(pl[0].sold, null); assert.equal(pl[0].month, '2026-10');
  ctx.crmPlanSave(KK, { row: p1.row, month: '2026-10', project: 'X', advance: 1, channels: [], tiers: [], sold: 7, budget: 5000000 });
  pl = ctx.crmCommLoad(KK).plans; assert.equal(pl[0].sold, 7); assert.equal(pl[0].budget, 5000000);
  assert.throws(() => ctx.crmPlanDelete(KK, 1), /Không tìm thấy/);
  ctx.crmPlanDelete(KK, p1.row); assert.equal(ctx.crmCommLoad(KK).plans.length, 0);
}
// quân sư AI: cần đúng khoá truy cập, thiếu khoá API thì báo rõ, có khoá thì gọi API
assert.throws(() => ctx.crmAsk('sai-khoa', 'xin chào'), /Không có quyền/);
assert.throws(() => ctx.crmAsk(ctx.crmKey_(), 'xin chào'), /Chưa cài khoá quân sư/);
globalThis.__props.ANTHROPIC_KEY = 'sk-ant-' + 'x'.repeat(30);
assert.equal(ctx.crmAsk(ctx.crmKey_(), 'Soạn tin cho khách', ''), 'Trả lời thử');
assert.equal(globalThis.__fetch.u, 'https://api.anthropic.com/v1/messages');
assert.equal(JSON.parse(globalThis.__fetch.o.payload).messages[0].content, 'Soạn tin cho khách');
assert.throws(() => ctx.crmAsk(ctx.crmKey_(), '  '), /Chưa nhập câu hỏi/);
{
  const ph = ctx.crmLoad(ctx.crmKey_()).leads.find((x) => x.province === 'Hà Nội').phone;
  ctx.crmAsk(ctx.crmKey_(), 'Phân tích khách', ph);
  const sys = JSON.parse(globalThis.__fetch.o.payload).system;
  assert.ok(sys.includes('FourS Tower') && sys.includes('dự án quan tâm Sun FourS Tower') && sys.includes('Giá cao') && sys.includes('12 Trần Thái Tông, Cầu Giấy, Hà Nội') && sys.includes('2 tỷ'), 'AI nhận hồ sơ, lịch sử chăm sóc, lịch sử xem dự án');
}
// quét ưu đãi
{
  const K2 = ctx.crmKey_(), real = ctx.UrlFetchApp;
  let calls = [];
  ctx.UrlFetchApp = { fetch: (u, o) => { calls.push(u); return u.includes('anthropic') ? { getResponseCode: () => 200, getContentText: () => JSON.stringify({ content: [{ text: 'Đây: {"name":"FourS Tower","highlights":"Chiết khấu 5%","priceFrom":"2.5","priceTo":null,"area":"Đà Nẵng","interest":"căn hộ","target":"Khách 2-4 tỷ","event":{"isEvent":true,"name":"Mở bán F2","when":"20/10/2026","where":"Sàn FourS"},"advice":["Hỏi nhu cầu","Xử lý giá"],"plan":["Gửi tin mời","Nhắc trước 1 ngày"],"messages":[{"style":"Thân mật","text":"Chào {ten}"},{"style":"x","text":""}],"note":""} hết.' }] }) } : { getResponseCode: () => 200, getContentText: () => '<html><title>Dự án A</title><script>x=1</script><body>Giá từ 2,5 tỷ</body></html>' }; } };
  assert.throws(() => ctx.crmScanOffer('sai', 'a'), /Không có quyền/);
  assert.throws(() => ctx.crmScanOffer(K2, '', '', ''), /dán thông điệp/);
  assert.throws(() => ctx.crmScanOffer(K2, '', 'http://169.254.169.254/x'), /không hợp lệ/);
  assert.throws(() => ctx.crmScanOffer(K2, '', 'ftp://x.vn'), /http/);
  assert.throws(() => ctx.crmScanOffer(K2, '', '', 'AAAA', 'image/svg+xml'), /Ảnh/);
  const r = ctx.crmScanOffer(K2, 'Chính sách mới', 'https://foursx.vn/p', 'data:image/jpeg;base64,/9j/AAAA', 'image/jpeg');
  assert.equal(r.name, 'FourS Tower'); assert.equal(r.interest, 'căn hộ'); assert.equal(r.event.isEvent, true); assert.equal(r.event.name, 'Mở bán F2'); assert.equal(r.advice.length, 2); assert.equal(r.plan.length, 2); assert.equal(r.priceFrom, 2.5); assert.equal(r.priceTo, ''); assert.equal(r.messages.length, 1);
  const pl = JSON.parse(globalThis.__fetch ? '{}' : '{}'); void pl;
  assert.ok(calls[0] === 'https://foursx.vn/p' && calls[1].includes('anthropic'));
  ctx.UrlFetchApp = { fetch: (u) => ({ getResponseCode: () => 200, getContentText: () => JSON.stringify({ content: [{ text: '{"project":"FourS","month":"2026-10","kind":"Cá nhân","advance":30000000,"channels":[{"name":"Google Ads","budget":20000000}],"tiers":[{"from":10,"to":null,"pct":100},{"from":0,"to":4,"pct":0}],"note":"ứng 30tr"}' }] }) }) };
  const sp = ctx.crmScanPlan(K2, 'Kế hoạch tháng 10');
  assert.equal(sp.month, '2026-10'); assert.equal(sp.kind, 'Cá nhân'); assert.equal(sp.advance, 30000000); assert.equal(sp.tiers[0].to, ''); assert.equal(sp.tiers[1].pct, 0); assert.equal(sp.channels[0].name, 'Google Ads');
  assert.throws(() => ctx.crmScanPlan('sai', 'a'), /Không có quyền/);
  const pk = ctx.crmPlanSave(K2, { month: '2026-10', kind: 'Cá nhân', docs: [{ title: 'Kế hoạch sàn', url: 'https://drive.google.com/x' }, { title: 'bad', url: 'javascript:alert(1)' }], channels: [], tiers: [] });
  const pp = ctx.crmCommLoad(K2).plans.find((q) => q.row === pk.row);
  assert.equal(pp.kind, 'Cá nhân'); assert.equal(pp.docs.length, 1); assert.equal(pp.docs[0].url, 'https://drive.google.com/x');
  ctx.crmPlanSave(K2, { row: pk.row, month: '2026-10', kind: 'Khác', docs: [], channels: [], tiers: [] });
  assert.equal(ctx.crmCommLoad(K2).plans.find((q) => q.row === pk.row).kind, 'Của sàn');
  ctx.crmPlanDelete(K2, pk.row);
  ctx.UrlFetchApp = { fetch: () => ({ getResponseCode: () => 200, getContentText: () => JSON.stringify({ content: [{ text: '{"contacts":[{"name":"Chị Hải Minh","phone":"+84 912 111 222","note":"khách Tài"},{"name":"Không số","phone":"","note":""},{"name":"","phone":"","note":""}]}' }] }) }) };
  const scn = ctx.crmScanContacts(K2, '', 'AAAA', 'image/jpeg');
  assert.equal(scn.contacts.length, 2); assert.equal(scn.contacts[0].phone, '0912111222'); assert.equal(scn.contacts[1].phone, '');
  assert.throws(() => ctx.crmScanContacts('sai', 'a'), /Không có quyền/);
  ctx.UrlFetchApp = { fetch: () => ({ getResponseCode: () => 200, getContentText: () => JSON.stringify({ content: [{ text: '{"month":"2026-10","salary":"15.872.000","rows":[{"type":"Thưởng GĐKD","unit":"A21011; A20623","total":"13.670.915","prev":"6.904.503","now":"6.766.412","net":"6.766.412"},{"type":"Thưởng TPKD","unit":"SL20620","rate":80,"total":2607591,"now":2086073,"net":""},{"type":"x","unit":"","net":0}]}' }] }) }) };
  const sm = ctx.crmScanComm(K2, 'bảng');
  assert.equal(sm.month, '2026-10'); assert.equal(sm.salary, 15872000); assert.equal(sm.rows.length, 2); assert.equal(sm.rows[0].total, 13670915); assert.equal(sm.rows[1].net, 2086073); assert.equal(sm.rows[1].type, 'Thưởng TPKD');
  assert.throws(() => ctx.crmScanComm('sai', 'a'), /Không có quyền/);
  ctx.UrlFetchApp = { fetch: () => ({ getResponseCode: () => 200, getContentText: () => JSON.stringify({ content: [{ text: '{"conversations":[{"name":"Hoa","phone":"+84912000111","summary":"Hỏi giá","heat":"Ấm"},{"name":"","phone":""},{"name":"Nam","phone":"abc","summary":"x"},{"kind":"contact","label":"Chị Hà - Khách","name":"Cao Huy"}]}' }] }) }) };
  const sz = ctx.crmScanZalo(K2, 'Hoa: giá?');
  assert.equal(sz.conversations.length, 3); assert.equal(sz.conversations[2].kind, 'contact'); assert.equal(sz.conversations[2].label, 'Chị Hà - Khách'); assert.equal(sz.conversations[0].kind, 'chat'); assert.equal(sz.conversations[0].phone, '0912000111'); assert.equal(sz.conversations[1].phone, '');
  assert.throws(() => ctx.crmScanZalo('sai', 'a'), /Không có quyền/);
  ctx.UrlFetchApp = { fetch: () => ({ getResponseCode: () => 200, getContentText: () => JSON.stringify({ content: [{ text: '{"summary":"Khách hỏi giá","need":"2PN 3 tỷ","obstacle":"Giá cao","heat":"Ấm","reason":"hỏi vay","next":"Gửi chính sách","followUp":"2099-01-05","reply":"Để xem lại","message":"Chào anh"}' }] }) }) };
  const sc = ctx.crmScanChat(K2, '', 'Khách: giá bao nhiêu');
  assert.equal(sc.heat, 'Ấm'); assert.equal(sc.message, 'Chào anh'); assert.equal(sc.followUp, '2099-01-05'); assert.equal(sc.reply, 'Để xem lại');
  assert.throws(() => ctx.crmScanChat('sai', '', 'a'), /Không có quyền/);
  ctx.UrlFetchApp = real;
}
// nhập từ Google Sheet khác
{
  const K3 = ctx.crmKey_();
  const tab = new Sheet('SPANA TOWER', []);
  tab.rows = [
    ['2025-08-30 18:04:26', 'My nguyễn', '935777013', 'Căn studio,Căn 1 phòng ngủ', 'https://www.sun-spanatower.com/?gad_source=1&gad_campaignid=22945423918&gclid=Cj0K', '', '', '', '', '', '14.243.49.97', 'FORM15'],
    ['2025-08-31 10:27:44', 'Dũng', 'dung@gmail.com', '905696145', 'https://www.sun-spanatower.com/?utm_source=facebook&utm_campaign=spana-fb', '', '', '', '', '', '1.1.1.1', 'FORM16'],
    ['2025-09-01 08:00:00', 'Không số', 'x@y.z', '', '', ''],
    ['2025-09-02 09:00:00', 'Trùng My', '0935777013', '', '']
  ];
  const skip = new Sheet('TONG_HOP', []); skip.rows = [['a', 'b', 'c']];
  globalThis.__ext = { getId: () => 'x', getName: () => 'DATA CHẠY GOOGLE', getSheets: () => [tab, skip], getSheetByName: (n) => [tab, skip].find((s) => s.name === n) || null };
  const URL = 'https://docs.google.com/spreadsheets/d/1yvgJAi4LKDZXiWSa_sS02rlQxvhh-nO-4kJ3GmxzxOE/edit?usp=sharing';
  assert.throws(() => ctx.crmSheetTabs('sai', URL), /Không có quyền/);
  assert.throws(() => ctx.crmSheetTabs(K3, 'https://evil.com/spreadsheets/d/xxxxxxxxxxxxxxxxxxxxxxxxx'), /Google Sheet/);
  const tb = ctx.crmSheetTabs(K3, URL);
  assert.equal(tb.tabs.length, 1); assert.equal(tb.tabs[0].count, 3); assert.ok(tb.tabs[0].from.startsWith('2025-08'));
  const evBefore = sheets['Hoạt động'].rows.length;
  const im = ctx.crmSheetImport(K3, URL, 'SPANA TOWER', 0, 100);
  assert.equal(im.total, 3); assert.equal(im.added, 2); assert.equal(im.dups.length, 1); assert.equal(im.next, null);
  assert.equal(sheets['Hoạt động'].rows.length, evBefore, 'nhập cũ không ghi sự kiện form');
  const L = ctx.crmLoad(K3).leads, my = L.find((l) => l.phone === '0935777013'), dg = L.find((l) => l.phone === '0905696145');
  assert.ok(my && dg); assert.equal(my.site, 'SPANA TOWER'); assert.equal(my.source, 'google'); assert.equal(my.campaign, 'gads-22945423918'); assert.equal(my.product, 'Căn studio,Căn 1 phòng ngủ'); assert.ok(my.at.startsWith('2025-08-30'));
  assert.equal(dg.source, 'facebook'); assert.equal(dg.campaign, 'spana-fb'); assert.equal(dg.email, 'dung@gmail.com'); assert.equal(dg.srcType, 'Data nhập');
  assert.throws(() => ctx.crmSheetImport(K3, URL, 'KHONG CO', 0, 10), /Không thấy tab/);
  const im1 = ctx.crmImport(K3, [{ name: 'Mới A', phone: '0966000999', project: 'Spana', note: 'n', docUrl: 'https://drive.google.com/a' }, { name: 'Trùng', phone: '0935777013' }]);
  assert.equal(im1.added, 1); assert.equal(im1.dups.length, 1);
  const la = ctx.crmLoad(K3).leads.find((l) => l.phone === '0966000999'); assert.equal(la.project, 'Spana'); assert.equal(la.docUrl, 'https://drive.google.com/a');
  assert.equal(ctx.crmLoad(K3).leads.find((l) => l.phone === '0966000999').srcType, 'Data nhập');
  assert.equal(ctx.crmSilence(K3, ['0935777013', '0905696145', 'x']).n, 2);
  assert.equal(ctx.crmLoad(K3).leads.find((l) => l.phone === '0905696145').srcType, 'Data nhập');
  assert.throws(() => ctx.crmSilence('sai', ['0905696145']), /Không có quyền/);
  const im2 = ctx.crmImport(K3, [{ name: 'Trùng', phone: '0935777013', project: 'Spana Tower' }], true);
  assert.equal(im2.merged, 1); assert.equal(im2.added, 0); assert.equal(ctx.crmLoad(K3).leads.find((l) => l.phone === '0935777013').project, 'Spana Tower');
  // link tài liệu
  ctx.crmUpdateLead(K3, '0935777013', { docUrl: 'https://drive.google.com/x' });
  assert.equal(ctx.crmLoad(K3).leads.find((l) => l.phone === '0935777013').docUrl, 'https://drive.google.com/x');
  ctx.crmUpdateLead(K3, '0935777013', { docUrl: 'javascript:alert(1)' });
  assert.equal(ctx.crmLoad(K3).leads.find((l) => l.phone === '0935777013').docUrl, '');
}
ctx.capQuyenDocSheet();
console.log('OK – Code.gs đạt mọi test');
