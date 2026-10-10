/**
 * Lưu lead từ website FPT City vào Google Sheet.
 * 1. Tạo Google Sheet mới > Tiện ích mở rộng > Apps Script, dán file này.
 * 2. Triển khai > Tùy chọn triển khai mới > Ứng dụng web
 *    - Thực thi với tư cách: Tôi; Người có quyền truy cập: Bất kỳ ai.
 * 3. Copy URL /exec vào CONFIG.leadEndpoint trong assets/js/main.js.
 * (Tùy chọn) Điền NOTIFY_EMAIL để nhận email mỗi khi có khách đăng ký.
 */
const NOTIFY_EMAIL = "";
const FIELDS = ["time", "project", "name", "phone", "email", "need", "source", "page", "referrer",
  "utm_source", "utm_medium", "utm_campaign", "utm_term", "utm_content", "gclid", "fbclid"];

function doPost(e) {
  const lock = LockService.getScriptLock();
  lock.waitLock(10000);
  try {
    const sheet = SpreadsheetApp.getActiveSpreadsheet().getSheetByName("Leads")
      || SpreadsheetApp.getActiveSpreadsheet().insertSheet("Leads");
    if (sheet.getLastRow() === 0) sheet.appendRow(FIELDS);
    const p = e.parameter || {};
    // Chặn công thức (CSV/formula injection)
    const clean = (v) => { v = String(v || "").slice(0, 500); return /^[=+\-@]/.test(v) ? "'" + v : v; };
    sheet.appendRow(FIELDS.map((f) => clean(p[f])));
    if (NOTIFY_EMAIL) {
      MailApp.sendEmail(NOTIFY_EMAIL, "Lead mới " + clean(p.project) + ": " + clean(p.name),
        FIELDS.map((f) => f + ": " + clean(p[f])).join("\n"));
    }
    return ContentService.createTextOutput(JSON.stringify({ ok: true }))
      .setMimeType(ContentService.MimeType.JSON);
  } finally {
    lock.releaseLock();
  }
}
