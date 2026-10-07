/**
 * Nhận khách hàng từ website Cora Tower (form + chat) → ghi Google Sheet + gửi email báo.
 *
 * Cài đặt (5 phút):
 * 1. Tạo Google Sheet mới → Tiện ích mở rộng → Apps Script → dán toàn bộ file này.
 * 2. Bấm Triển khai → Tùy chọn triển khai mới → Loại: Ứng dụng web
 *    - Thực thi với tư cách: Tôi   - Ai có quyền truy cập: Bất kỳ ai
 * 3. Cấp quyền, copy URL dạng https://script.google.com/macros/s/.../exec
 * 4. Dán URL vào FORM_ENDPOINT trong web/cora-tower/assets/main.js rồi đăng lại web.
 */
const NOTIFY_EMAIL = "hiephoangmt@gmail.com";
const SHEET_NAME = "Khach hang";

function doPost(e) {
  const data = JSON.parse(e.postData.contents || "{}");
  const ss = SpreadsheetApp.getActiveSpreadsheet();
  const sheet = ss.getSheetByName(SHEET_NAME) || ss.insertSheet(SHEET_NAME);
  if (sheet.getLastRow() === 0) {
    sheet.appendRow(["Thời gian", "Họ tên", "SĐT/Zalo", "Quan tâm", "Nguồn", "Trang", "Ghi chú hội thoại"]);
  }
  const row = [new Date(), data.name || "", "'" + (data.phone || ""), data.interest || "", data.source || "", data.page || "", data.note || ""];
  sheet.appendRow(row);

  MailApp.sendEmail({
    to: NOTIFY_EMAIL,
    subject: "[Cora Tower] Khách mới: " + (data.phone || "") + " – " + (data.interest || ""),
    body:
      "Họ tên: " + (data.name || "(chưa có)") +
      "\nSĐT/Zalo: " + (data.phone || "") +
      "\nQuan tâm: " + (data.interest || "") +
      "\nNguồn: " + (data.source || "") +
      "\nTrang: " + (data.page || "") +
      "\n\nHội thoại:\n" + (data.note || "").split(" | ").join("\n"),
  });
  return ContentService.createTextOutput("ok");
}
