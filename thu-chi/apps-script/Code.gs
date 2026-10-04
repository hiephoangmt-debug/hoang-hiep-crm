/**
 * Thu Chi Mẹ Vân – máy chủ đồng bộ chạy trên Google Apps Script.
 * Hướng dẫn: thu-chi/HUONG-DAN-DONG-BO.md
 *
 * Chỉ cần dán file này vào Code.gs của Apps Script (gắn với 1 Google Sheet) rồi
 * Triển khai → Ứng dụng web. Giao diện app được tự tải từ GitHub (APP_URL).
 * Mã bảo mật: lần Kết nối đầu tiên trong app, mã được nhập sẽ trở thành mã bảo mật.
 */

// Địa chỉ giao diện app (file index.html trên GitHub)
const APP_URL = 'https://raw.githubusercontent.com/hiephoangmt-debug/hoang-hiep-crm/claude/quirky-knuth-tncnth/thu-chi/index.html';

const SHEET_DATA = '_data';        // sheet ẩn chứa toàn bộ dữ liệu (JSON)
const SHEET_SO = 'Sổ thu chi';     // bản xem dạng bảng, tự cập nhật sau mỗi lần lưu
const SHEET_THANG = 'Tổng hợp tháng';
const CHUNK = 40000;               // mỗi ô Google Sheet chứa tối đa 50.000 ký tự

/** Quên mã / muốn đổi mã: chạy hàm này, lần Kết nối tiếp theo trong app sẽ đặt mã mới. */
function xoaMaBaoMat() {
  PropertiesService.getScriptProperties().deleteProperty('SYNC_KEY');
  Logger.log('Đã xóa mã bảo mật. Mở app → Cài đặt → Kết nối với mã mới.');
}

function doGet(e) {
  const p = (e && e.parameter) || {};
  if (p.action) return handle_(p.action, p);
  if (p.capnhat) CacheService.getScriptCache().remove('app_html'); // mở link kèm ?capnhat=1 để lấy bản mới ngay
  const t = appTemplate_();
  t.syncUrl = ScriptApp.getService().getUrl();
  return t.evaluate()
    .setTitle('Thu Chi Mẹ Vân')
    .addMetaTag('viewport', 'width=device-width, initial-scale=1')
    .setXFrameOptionsMode(HtmlService.XFrameOptionsMode.ALLOWALL);
}

/** Chạy hàm này nếu muốn app lấy bản mới nhất từ GitHub ngay lập tức. */
function capNhatApp() {
  CacheService.getScriptCache().remove('app_html');
  Logger.log('Đã xóa bản lưu tạm. Tải lại trang app để dùng bản mới nhất.');
}

// Lấy giao diện app: ưu tiên bản trên GitHub (lưu tạm 10 phút), nếu lỗi thì dùng file HTML "Index" (nếu có)
function appTemplate_() {
  const cache = CacheService.getScriptCache();
  let html = cache.get('app_html');
  if (!html) {
    try {
      const r = UrlFetchApp.fetch(APP_URL, { muteHttpExceptions: true });
      if (r.getResponseCode() === 200) {
        html = r.getContentText('UTF-8');
        try { cache.put('app_html', html, 600); } catch (e) {} // lưu tạm 10 phút
      }
    } catch (e) {}
  }
  if (html) return HtmlService.createTemplate(html);
  return HtmlService.createTemplateFromFile('Index');
}

function doPost(e) {
  let body = {};
  try { body = JSON.parse(e.postData.contents); } catch (err) {}
  return handle_(body.action, body);
}

function handle_(action, p) {
  const props = PropertiesService.getScriptProperties();
  let key = props.getProperty('SYNC_KEY');
  if (!key) {
    // Lần kết nối đầu tiên: mã người dùng nhập trở thành mã bảo mật
    const k = String(p.key || '');
    if (k.length < 6) return json_({ ok: false, error: 'Lần đầu kết nối: hãy đặt mã bảo mật từ 6 ký tự trở lên' });
    props.setProperty('SYNC_KEY', k);
    key = k;
  }
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
