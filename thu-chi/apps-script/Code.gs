/**
 * Thu Chi Mẹ Vân – máy chủ đồng bộ chạy trên Google Apps Script.
 *
 * Cách dùng: xem thu-chi/HUONG-DAN-DONG-BO.md
 *  1. Tạo Google Sheet mới → Tiện ích mở rộng → Apps Script.
 *  2. Dán file này vào Code.gs, tạo thêm file HTML tên "Index" và dán nội dung thu-chi/index.html.
 *  3. Đổi MA_BAO_MAT bên dưới, chạy hàm caiDat() một lần và cấp quyền.
 *  4. Triển khai → Tùy chọn triển khai mới → Ứng dụng web
 *     (Thực thi với tư cách: Tôi, Người có quyền truy cập: Bất kỳ ai).
 */

// ĐỔI mã này thành mã riêng của gia đình (dài, khó đoán), rồi chạy hàm caiDat()
const MA_BAO_MAT = 'doi-ma-nay-thanh-ma-rieng-cua-nha-minh';

const SHEET_DATA = '_data';        // sheet ẩn chứa toàn bộ dữ liệu (JSON)
const SHEET_SO = 'Sổ thu chi';     // bản xem dạng bảng, tự cập nhật sau mỗi lần lưu
const SHEET_THANG = 'Tổng hợp tháng';
const CHUNK = 40000;               // mỗi ô Google Sheet chứa tối đa 50.000 ký tự

/** Chạy 1 lần sau khi dán code: lưu mã bảo mật và tạo các sheet. */
function caiDat() {
  if (!MA_BAO_MAT || MA_BAO_MAT.indexOf('doi-ma-nay') === 0) throw new Error('Hãy đổi MA_BAO_MAT trước khi chạy caiDat()');
  PropertiesService.getScriptProperties().setProperty('SYNC_KEY', MA_BAO_MAT);
  dataSheet_();
  Logger.log('Đã cài đặt xong. Tiếp theo: Triển khai → Tùy chọn triển khai mới → Ứng dụng web.');
}

function doGet(e) {
  const p = (e && e.parameter) || {};
  if (p.action) return handle_(p.action, p);
  const t = HtmlService.createTemplateFromFile('Index');
  t.syncUrl = ScriptApp.getService().getUrl();
  return t.evaluate()
    .setTitle('Thu Chi Mẹ Vân')
    .addMetaTag('viewport', 'width=device-width, initial-scale=1')
    .setXFrameOptionsMode(HtmlService.XFrameOptionsMode.ALLOWALL);
}

function doPost(e) {
  let body = {};
  try { body = JSON.parse(e.postData.contents); } catch (err) {}
  return handle_(body.action, body);
}

function handle_(action, p) {
  const key = PropertiesService.getScriptProperties().getProperty('SYNC_KEY');
  if (!key) return json_({ ok: false, error: 'Chưa chạy hàm caiDat() trong Apps Script' });
  if (String(p.key || '') !== key) return json_({ ok: false, error: 'Sai mã bảo mật' });

  if (action === 'load') return json_({ ok: true, rev: getRev_(), data: readData_() });

  if (action === 'save') {
    const data = p.data;
    if (!data || !Array.isArray(data.tx) || !Array.isArray(data.categories)) return json_({ ok: false, error: 'Dữ liệu không hợp lệ' });
    const lock = LockService.getScriptLock();
    lock.waitLock(20000);
    try {
      const rev = getRev_();
      // Máy khác vừa lưu → báo xung đột để máy này tải lại và gộp dữ liệu
      if (!p.force && Number(p.baseRev) !== rev) return json_({ ok: false, conflict: true, rev: rev });
      writeData_(data);
      setRev_(rev + 1);
      try { writeMirror_(data); } catch (err) { console.error(err); }
      return json_({ ok: true, rev: rev + 1 });
    } finally {
      lock.releaseLock();
    }
  }
  return json_({ ok: false, error: 'Lệnh không hợp lệ' });
}

/* ---------- Lưu trữ ---------- */
function ss_() { return SpreadsheetApp.getActiveSpreadsheet(); }

function dataSheet_() {
  let sh = ss_().getSheetByName(SHEET_DATA);
  if (!sh) { sh = ss_().insertSheet(SHEET_DATA); sh.hideSheet(); }
  return sh;
}
function getRev_() { return Number(PropertiesService.getScriptProperties().getProperty('REV') || 0); }
function setRev_(n) { PropertiesService.getScriptProperties().setProperty('REV', String(n)); }

function readData_() {
  const sh = dataSheet_();
  const n = sh.getLastRow();
  if (!n) return null;
  const txt = sh.getRange(1, 1, n, 1).getValues().map(function (r) { return r[0]; }).join('');
  if (!txt) return null;
  try { return JSON.parse(txt); } catch (e) { return null; }
}

function writeData_(data) {
  const sh = dataSheet_();
  const txt = JSON.stringify(data);
  const rows = [];
  for (let i = 0; i < txt.length; i += CHUNK) rows.push([txt.slice(i, i + CHUNK)]);
  sh.clearContents();
  sh.getRange(1, 1, rows.length, 1).setNumberFormat('@').setValues(rows);
}

/* ---------- Bản xem dạng bảng cho người dùng Google Sheet ---------- */
function writeMirror_(data) {
  const cats = {};
  (data.categories || []).forEach(function (c) { cats[c.id] = c.name; });
  const tx = (data.tx || []).slice().sort(function (a, b) { return a.date < b.date ? 1 : a.date > b.date ? -1 : 0; });

  const so = getOrCreate_(SHEET_SO);
  const rows = tx.map(function (t) {
    const d = t.date.split('-');
    return [new Date(Number(d[0]), Number(d[1]) - 1, Number(d[2])), t.type === 'thu' ? 'Thu' : 'Chi',
      t.group === 'co_dinh' ? 'Cố định' : 'Phát sinh', cats[t.cat] || '', t.desc || '',
      t.type === 'thu' ? t.amount : '', t.type === 'chi' ? t.amount : '', t.note || ''];
  });
  so.clear();
  so.getRange(1, 1, 1, 8).setValues([['Ngày', 'Loại', 'Nhóm', 'Danh mục', 'Diễn giải', 'Thu', 'Chi', 'Ghi chú']])
    .setFontWeight('bold').setBackground('#fff36b');
  if (rows.length) {
    so.getRange(2, 1, rows.length, 8).setValues(rows);
    so.getRange(2, 1, rows.length, 1).setNumberFormat('dd/mm/yyyy');
    so.getRange(2, 6, rows.length, 2).setNumberFormat('#,##0');
  }
  so.setFrozenRows(1);

  const byMonth = {};
  tx.forEach(function (t) {
    const m = t.date.slice(0, 7);
    byMonth[m] = byMonth[m] || { thu: 0, chi: 0 };
    byMonth[m][t.type] += Number(t.amount) || 0;
  });
  const th = getOrCreate_(SHEET_THANG);
  const mRows = Object.keys(byMonth).sort().reverse().map(function (m) {
    const v = byMonth[m];
    return ['T' + Number(m.slice(5)) + '/' + m.slice(0, 4), v.thu, v.chi, v.thu - v.chi];
  });
  th.clear();
  th.getRange(1, 1, 1, 4).setValues([['Tháng', 'Tổng thu', 'Tổng chi', 'Tồn']]).setFontWeight('bold').setBackground('#fff36b');
  if (mRows.length) th.getRange(2, 1, mRows.length, 4).setValues(mRows).offset(0, 1, mRows.length, 3).setNumberFormat('#,##0;(#,##0)');
  th.setFrozenRows(1);
}

function getOrCreate_(name) { return ss_().getSheetByName(name) || ss_().insertSheet(name); }

function json_(o) { return ContentService.createTextOutput(JSON.stringify(o)).setMimeType(ContentService.MimeType.JSON); }
