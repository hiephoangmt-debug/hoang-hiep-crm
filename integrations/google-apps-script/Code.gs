/**
 * Nhận lead từ website Da Nang Downtown và ghi vào Google Sheet "DATA CHẠY GOOGLE",
 * tab "Dowtown", theo đúng bố cục đang dùng cho lead quảng cáo Google:
 *   A Thời gian | B Họ tên | C Số điện thoại | D Nhu cầu / loại căn / kênh
 *   E Link trang (giữ gclid, utm) | K IP (để trống, Apps Script không đọc được IP) | L Mã form
 * Mã form: WEB-FORM (form chính), WEB-POPUP (popup tài liệu), WEB-CHAT (chat tự động).
 * Đồng thời gửi email báo khách mới.
 *
 * Cài đặt: mở Sheet "DATA CHẠY GOOGLE" > Tiện ích mở rộng > Apps Script, tạo file mới, dán mã này,
 * Triển khai > Tùy chọn triển khai mới > Ứng dụng web (Thực thi với: Tôi, Ai có quyền truy cập: Bất kỳ ai),
 * rồi dán URL /exec vào CONFIG.LEAD_ENDPOINT trong web/assets/site.js.
 * Lưu ý: nếu project Apps Script đã có hàm doPost (script CRM), hãy tạo project Apps Script riêng
 * và giữ SHEET_ID bên dưới thay vì dán chung vào project đó.
 */
const SHEET_ID = '1yvgJAi4LKDZXiWSa_sS02rlQxvhh-nO-4kJ3GmxzxOE';
const TAB_NAME = 'Dowtown';
const NOTIFY_EMAIL = 'hiephoangmt@gmail.com';
const FORM_CODES = { form: 'WEB-FORM', popup: 'WEB-POPUP', chat: 'WEB-CHAT' };

function doPost(e) {
  const lock = LockService.getScriptLock();
  lock.waitLock(10000);
  try {
    const d = JSON.parse(e.postData.contents || '{}');
    const phone = String(d.phone || '').replace(/[^\d+]/g, '');
    if (!/^(\+84|0)\d{9,10}$/.test(phone)) return json({ ok: false, error: 'invalid_phone' });

    const sheet = SpreadsheetApp.openById(SHEET_ID).getSheetByName(TAB_NAME);
    const tz = Session.getScriptTimeZone() || 'Asia/Ho_Chi_Minh';
    const formCode = FORM_CODES[d.via] || 'WEB-FORM';
    const detail = [d.need, d.unit_type, d.channel && ('Nhận qua ' + d.channel)].filter(String).join(' | ');
    const row = new Array(12).fill('');
    row[0] = Utilities.formatDate(new Date(), tz, 'yyyy-MM-dd HH:mm');
    row[1] = clip(d.name, 80);
    row[2] = "'" + phone;                 // giữ số 0 đầu
    row[3] = clip(detail, 200);
    row[4] = clip(d.landing || d.page, 500);
    row[11] = formCode;
    sheet.appendRow(row);

    // Ghi chú chat (nếu có) vào ô D của dòng vừa thêm
    if (d.note) sheet.getRange(sheet.getLastRow(), 4).setNote(clip(d.note, 2000));

    MailApp.sendEmail({
      to: NOTIFY_EMAIL,
      subject: 'Khách mới Downtown: ' + row[1] + ' – ' + phone + ' (' + formCode + ')',
      body: ['Thời gian: ' + row[0], 'Họ tên: ' + row[1], 'SĐT: ' + phone, 'Chi tiết: ' + row[3],
             'Trang: ' + row[4], 'Form: ' + formCode, d.note ? 'Chat: ' + d.note : ''].join('\n')
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
