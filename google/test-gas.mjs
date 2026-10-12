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
  getMaxColumns() { return 30; }
  appendRow(r) { this.rows.push(r.slice()); }
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
};
sheets.Website.appendRow(['Landing A', 'a.com', 'testkey12345']);
// Ô tick đã dựng sẵn FALSE tới dòng 40 (giống file thật): getLastRow() sẽ sai, mã phải bỏ qua chúng
for (let i = 1; i < 40; i++) { (sheets['Khách hàng'].rows[i] ||= [])[14] = false; (sheets['Lượt bấm'].rows[i] ||= [])[8] = false; }
const out = (o) => ({ setMimeType() { return { body: o }; } });
const ctx = vm.createContext({
  SpreadsheetApp: { getActiveSpreadsheet: () => ({ getSheetByName: (n) => sheets[n], insertSheet: (n) => (sheets[n] = new Sheet(n, [])), getOwner: () => ({ getEmail: () => 'owner@gmail.com' }) }), getUi: () => ({ alert(m) { globalThis.__alert = m; }, showModelessDialog(h, title) { globalThis.__dialog = { h, title }; } }) },
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
assert.equal(dbg.hasKey, true); assert.equal(dbg.hasCrmHtml, true); assert.equal(dbg.version, 'ui-11'); assert.equal(JSON.stringify(dbg).includes(K), false);
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
const ck1 = ctx.crmLoad(K).clicks[0]; assert.equal(ck1.checked, true); assert.equal(ck1.note, 'đã xem Zalo');
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
  assert.equal(lg.logs.length, 2); assert.equal(lg.logs[1].type, 'Gọi điện'); assert.equal(lg.logs[1].next, '2026-10-20');
  assert.equal(lg.logs[0].type, 'Ghi chú'); assert.equal(lg.logs[0].content, "'=SUM(1)");
  assert.ok(lg.moves.length >= 2); assert.equal(lg.moves[0].to, 'Lan Anh'); assert.equal(lg.moves[0].from, 'Minh'); assert.equal(lg.moves[1].to, 'Minh');
  assert.equal(ctx.crmLoad(KK).leads.find((x) => x.phone === lead.phone).next, '2026-10-20');
  assert.throws(() => ctx.crmAddLog('sai', lead.phone, { content: 'x' }), /Không có quyền/);
}
// quân sư AI: cần đúng khoá truy cập, thiếu khoá API thì báo rõ, có khoá thì gọi API
assert.throws(() => ctx.crmAsk('sai-khoa', 'xin chào'), /Không có quyền/);
assert.throws(() => ctx.crmAsk(ctx.crmKey_(), 'xin chào'), /Chưa cài khoá quân sư/);
globalThis.__props.ANTHROPIC_KEY = 'sk-ant-' + 'x'.repeat(30);
assert.equal(ctx.crmAsk(ctx.crmKey_(), 'Soạn tin cho khách', ''), 'Trả lời thử');
assert.equal(globalThis.__fetch.u, 'https://api.anthropic.com/v1/messages');
assert.equal(JSON.parse(globalThis.__fetch.o.payload).messages[0].content, 'Soạn tin cho khách');
assert.throws(() => ctx.crmAsk(ctx.crmKey_(), '  '), /Chưa nhập câu hỏi/);
console.log('OK – Code.gs đạt mọi test');
