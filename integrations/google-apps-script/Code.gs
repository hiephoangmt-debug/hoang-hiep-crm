/**
 * Nhận lead từ website Da Nang Downtown và ghi vào Google Sheet
 * "Leads – Website Da Nang Downtown", đồng thời gửi email báo khách mới.
 *
 * Cài đặt: mở Sheet > Tiện ích mở rộng > Apps Script, dán file này,
 * Triển khai > Tùy chọn triển khai mới > Ứng dụng web
 * (Thực thi với: Tôi, Ai có quyền truy cập: Bất kỳ ai), rồi dán URL /exec
 * vào CONFIG.LEAD_ENDPOINT trong web/assets/site.js.
 */
const SHEET_ID = '1-g4xrH5DJ4Mnxd9ICnDt5Q_K3AqhcRjBW1vG3EsPXvE';
const NOTIFY_EMAIL = 'hiephoangmt@gmail.com';
const HEADERS = ['Thời gian', 'Họ tên', 'Số điện thoại', 'Nhu cầu', 'Loại căn', 'Kênh nhận tài liệu', 'Nguồn (form/chat/popup)', 'Trang', 'Ghi chú chat'];

function doPost(e) {
  const lock = LockService.getScriptLock();
  lock.waitLock(10000);
  try {
    const d = JSON.parse(e.postData.contents || '{}');
    const phone = String(d.phone || '').replace(/[^\d+]/g, '');
    if (!/^(\+84|0)\d{9,10}$/.test(phone)) return json({ ok: false, error: 'invalid_phone' });

    const sheet = SpreadsheetApp.openById(SHEET_ID).getSheets()[0];
    if (sheet.getLastRow() === 0) sheet.appendRow(HEADERS);
    const row = [
      new Date(),
      clip(d.name, 80),
      "'" + phone, // giữ số 0 đầu
      clip(d.need, 60),
      clip(d.unit_type, 60),
      clip(d.channel, 30),
      clip(d.via || d.source, 40),
      clip(d.page, 200),
      clip(d.note, 2000)
    ];
    sheet.appendRow(row);

    MailApp.sendEmail({
      to: NOTIFY_EMAIL,
      subject: 'Khách mới: ' + row[1] + ' – ' + phone + ' (' + row[6] + ')',
      body: HEADERS.map((h, i) => h + ': ' + row[i]).join('\n')
    });
    return json({ ok: true });
  } catch (err) {
    return json({ ok: false, error: String(err) });
  } finally {
    lock.releaseLock();
  }
}

function clip(v, n) {
  const s = String(v == null ? '' : v);
  // Chặn công thức bị chèn vào Sheet
  return (/^[=+\-@]/.test(s) ? "'" + s : s).slice(0, n);
}

function json(obj) {
  return ContentService.createTextOutput(JSON.stringify(obj)).setMimeType(ContentService.MimeType.JSON);
}
