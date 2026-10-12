// Chạy Code.gs trong môi trường giả lập SpreadsheetApp để kiểm tra logic (không cần Google).
import assert from 'node:assert/strict';
import fs from 'node:fs';
import vm from 'node:vm';
import path from 'node:path';
import { fileURLToPath } from 'node:url';
const here = path.dirname(fileURLToPath(import.meta.url));

class Sheet {
  constructor(name, header) { this.name = name; this.rows = [header]; }
  getName() { return this.name; }
  getLastRow() { return this.rows.length; }
  appendRow(r) { this.rows.push(r.slice()); }
  getRange(r, c, nr = 1, nc = 1) {
    const s = this;
    return {
      getValues: () => Array.from({ length: nr }, (_, i) => Array.from({ length: nc }, (_, j) => (s.rows[r - 1 + i] || [])[c - 1 + j] ?? '')),
      getValue: () => (s.rows[r - 1] || [])[c - 1] ?? '',
      setValues: (v) => v.forEach((row, i) => row.forEach((x, j) => { (s.rows[r - 1 + i] ||= [])[c - 1 + j] = x; })),
      setValue: (x) => { (s.rows[r - 1] ||= [])[c - 1] = x; },
      getSheet: () => s, getColumn: () => c, getRow: () => r,
    };
  }
}
const sheets = {
  'Khách hàng': new Sheet('Khách hàng', []),
  'Hoạt động': new Sheet('Hoạt động', []),
  'Website': new Sheet('Website', ['Tên', 'Domain', 'Mã']),
  'Lượt bấm': new Sheet('Lượt bấm', []),
};
sheets.Website.appendRow(['Landing A', 'a.com', 'testkey12345']);
const out = (o) => ({ setMimeType() { return { body: o }; } });
const ctx = vm.createContext({
  SpreadsheetApp: { getActiveSpreadsheet: () => ({ getSheetByName: (n) => sheets[n] }), getUi: () => ({}) },
  CacheService: { getScriptCache: () => ({ get: () => null, put() {} }) },
  LockService: { getScriptLock: () => ({ waitLock() {}, releaseLock() {} }) },
  ContentService: { createTextOutput: (b) => ({ body: b, setMimeType(m) { this.mime = m; return this; } }), MimeType: { JSON: 'json', JAVASCRIPT: 'js' } },
  ScriptApp: { getService: () => ({ getUrl: () => 'https://script.google.com/macros/s/X/exec' }) },
  console,
});
vm.runInContext(fs.readFileSync(path.join(here, 'Code.gs'), 'utf8'), ctx);
const post = (body, parameter = {}) => JSON.parse(ctx.doPost({ postData: { contents: typeof body === 'string' ? body : JSON.stringify(body) }, parameter }).body);

assert.equal(post({ key: 'wrong', type: 'pageview' }).error, 'Mã website không hợp lệ');
assert.equal(post({ key: 'testkey12345', action: 'track', type: 'pageview', vid: 'v1', url: 'https://a.com', utm_source: 'facebook', utm_campaign: 'sale' }).ok, true);
assert.equal(post({ key: 'testkey12345', action: 'track', type: 'click', channel: 'zalo', vid: 'v1' }).ok, true);
assert.equal(sheets['Hoạt động'].rows.length, 3); // dòng tiêu đề + 2 sự kiện
assert.equal(sheets['Hoạt động'].rows[2][4], 'zalo');
// lượt bấm đi vào tab Lượt bấm kèm công thức cảnh báo; lượt xem thì không
assert.equal(sheets['Lượt bấm'].rows.length, 2);
const ck = sheets['Lượt bấm'].rows[1];
assert.equal(ck[3], 'zalo'); assert.equal(ck[8], false); assert.match(ck[7], /COUNTIF\('Khách hàng'!\$I:\$I,\$B2\)/); assert.match(ck[10], /CHƯA XỬ LÝ/);

// form: tạo khách mới, SĐT giữ số 0, tên bắt đầu bằng "=" bị vô hiệu hoá
let r = post({ key: 'testkey12345', action: 'lead', vid: 'v1', name: '=IMPORTXML("x")', phone: '+84 912 345 678', utm_source: 'facebook', utm_campaign: 'sale', message: 'cần 2PN' });
assert.deepEqual([r.ok, r.new], [true, true]);
const lead = sheets['Khách hàng'].rows[1];
assert.equal(lead[3], '0912345678'); assert.equal(lead[2][0], "'"); assert.equal(lead[5], 'Landing A');
assert.match(lead[10], /COUNTIFS\(.*\$I2,/); assert.match(lead[17], /\$O2<>TRUE/);
assert.equal(lead[18], 'Mới'); assert.equal(lead[14], false);

// gửi lại cùng SĐT -> không tạo dòng mới, tăng số lần gửi
r = post({ key: 'testkey12345', action: 'lead', phone: '0912345678', name: 'Nam', email: 'a@b.c' });
assert.equal(r.new, false); assert.equal(sheets['Khách hàng'].rows.length, 2); assert.equal(sheets['Khách hàng'].rows[1][9], 2);

// webhook form-encoded (key trong ?key=, trường trong parameter)
r = JSON.parse(ctx.doPost({ postData: { contents: 'phone=0988111222&name=B' }, parameter: { key: 'testkey12345', phone: '0988111222', name: 'B' } }).body);
assert.equal(r.new, true); assert.equal(sheets['Khách hàng'].rows[2][3], '0988111222'); assert.equal(sheets['Khách hàng'].rows[2][10].includes('$I3'), true);

assert.equal(post({ key: 'testkey12345', action: 'lead', phone: '12' }).error, 'Số điện thoại không hợp lệ');
assert.equal(post('not json at all').error, 'Mã website không hợp lệ');

// tick "Đã gọi" -> ghi giờ và đổi trạng thái
const sh = sheets['Khách hàng'];
sh.getRange(2, 15).setValue(true);
ctx.onEdit({ range: sh.getRange(2, 15) });
assert.equal(typeof sh.rows[1][16].getTime, 'function'); assert.equal(sh.rows[1][18], 'Đã liên hệ');

// doGet trả về mã theo dõi, có nhận diện Google
const js = ctx.doGet({ parameter: { js: '1' } }); assert.equal(js.mime, 'js'); assert.match(js.body, /script\\.google/); assert.match(js.body, /action/);
console.log('OK – Code.gs đạt mọi test');
