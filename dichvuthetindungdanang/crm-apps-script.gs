/**
 * Nhận dữ liệu từ website (bấm Gọi / Zalo, form) và ghi vào Google Sheet CRM.
 *
 * CÀI ĐẶT (làm 1 lần):
 * 1. Mở Google Sheet CRM → menu Tiện ích mở rộng (Extensions) → Apps Script.
 * 2. Xoá code mẫu, dán toàn bộ file này vào → bấm Lưu.
 * 3. Bấm Triển khai (Deploy) → Tùy chọn triển khai mới (New deployment)
 *    → Loại: Ứng dụng web (Web app)
 *    → Thực thi với tư cách: Tôi (Me)
 *    → Người có quyền truy cập: Bất kỳ ai (Anyone)
 *    → Triển khai → cấp quyền → copy "URL ứng dụng web" (…/exec).
 * 4. Dán URL đó vào biến CRM_URL trong file crm-click-tracking.html, rồi dán đoạn mã đó vào LadiPage.
 *
 * Dữ liệu ghi vào tab "Website" (tự tạo nếu chưa có) – KHÔNG đụng vào các tab đang có.
 */
var SHEET_NAME = 'Website';
var HEADERS = ['Thời gian', 'Loại', 'Họ tên', 'Số điện thoại', 'Dịch vụ / Nút bấm', 'Website', 'Trang'];

function doPost(e) {
  var lock = LockService.getScriptLock();
  lock.tryLock(10000);
  try {
    var d = parseBody_(e);
    if (d.website) return ok_(); // bẫy chống spam (ô ẩn "website" bị điền)
    var loai = d.loai === 'goi' ? 'Bấm Gọi' : d.loai === 'zalo' ? 'Bấm Zalo' : 'Form';
    sheet_().appendRow([
      new Date(),
      loai,
      d.name || d.ho_ten || d.full_name || '',
      String(d.phone || d.so_dien_thoai || d.sdt || '').replace(/^'/, ''),
      d.service || d.dich_vu || d.message || '',
      d.source || '',
      d.page || ''
    ]);
    return ok_();
  } finally {
    lock.releaseLock();
  }
}

function doGet() {
  return ContentService.createTextOutput('CRM web hook đang chạy.');
}

function parseBody_(e) {
  var d = {};
  if (e && e.parameter) for (var k in e.parameter) d[k] = e.parameter[k];
  if (e && e.postData && e.postData.contents) {
    try {
      var j = JSON.parse(e.postData.contents);
      for (var k2 in j) d[k2] = j[k2];
    } catch (err) { /* không phải JSON – đã lấy từ e.parameter */ }
  }
  return d;
}

function sheet_() {
  var ss = SpreadsheetApp.getActiveSpreadsheet();
  var sh = ss.getSheetByName(SHEET_NAME);
  if (!sh) {
    sh = ss.insertSheet(SHEET_NAME);
    sh.appendRow(HEADERS);
    sh.setFrozenRows(1);
    sh.getRange(1, 1, 1, HEADERS.length).setFontWeight('bold');
    sh.getRange('D:D').setNumberFormat('@'); // giữ số 0 đầu số điện thoại
  }
  return sh;
}

function ok_() {
  return ContentService.createTextOutput(JSON.stringify({ ok: true })).setMimeType(ContentService.MimeType.JSON);
}
