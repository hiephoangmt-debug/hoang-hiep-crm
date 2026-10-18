/**
 * Nhận dữ liệu khách hàng & lịch hẹn từ bot, ghi vào Google Sheet.
 * Cách dùng: mở Google Sheet → Tiện ích mở rộng → Apps Script → dán toàn bộ file này
 * → sửa SECRET cho giống SHEET_SECRET trong .env → Triển khai → Tùy chọn triển khai mới
 * → Loại: Ứng dụng web, Ai có quyền truy cập: Bất kỳ ai → copy link dán vào SHEET_WEBHOOK_URL.
 */
var SECRET = 'doi-thanh-chuoi-bi-mat';

function doPost(e) {
  var d = JSON.parse(e.postData.contents);
  if (d.secret !== SECRET) {
    return ContentService.createTextOutput(JSON.stringify({ ok: false, error: 'secret' }));
  }
  var ss = SpreadsheetApp.getActiveSpreadsheet();
  var name = String(d.loai || 'Data');
  var sh = ss.getSheetByName(name) || ss.insertSheet(name);
  var data = d.du_lieu || {};

  if (sh.getLastRow() === 0) sh.appendRow(['cap_nhat']);
  var header = sh.getRange(1, 1, 1, sh.getLastColumn()).getValues()[0];
  Object.keys(data).forEach(function (k) {
    if (header.indexOf(k) < 0) {
      header.push(k);
      sh.getRange(1, header.length).setValue(k);
    }
  });

  var row = header.map(function (h) {
    return h === 'cap_nhat' ? new Date() : (data[h] === undefined ? '' : data[h]);
  });

  // Bảng KhachHang: cập nhật dòng cũ theo chat_id thay vì thêm trùng
  var idCol = header.indexOf('chat_id');
  if (name === 'KhachHang' && idCol >= 0 && sh.getLastRow() > 1) {
    var ids = sh.getRange(2, idCol + 1, sh.getLastRow() - 1, 1).getValues();
    for (var i = 0; i < ids.length; i++) {
      if (String(ids[i][0]) === String(data.chat_id)) {
        sh.getRange(i + 2, 1, 1, row.length).setValues([row]);
        return ContentService.createTextOutput(JSON.stringify({ ok: true, updated: true }));
      }
    }
  }
  sh.appendRow(row);
  return ContentService.createTextOutput(JSON.stringify({ ok: true }));
}
