/**
 * Nhận lead từ website Da Nang Downtown (3 trang: Da Nang Downtown, Sun Galaxy Complex, Tháp 408m)
 * và từ webhook form LadiPage, rồi:
 *   1. Ghi vào Google Sheet "DATA CHẠY GOOGLE", tab "Dowtown", theo bố cục đang dùng:
 *        A Thời gian | B Họ tên | C Số điện thoại | D Nhu cầu / loại căn / kênh
 *        E Link trang (giữ gclid, utm) | K IP (để trống) | L Mã form
 *      Mã form: WEB-FORM, WEB-POPUP, WEB-CHAT (website) hoặc mã form LadiPage (FORM431...).
 *   2. Gửi tin báo khách mới về Telegram.
 *   3. Gửi email báo khách mới.
 *
 * Cài đặt:
 *   - Mở Sheet "DATA CHẠY GOOGLE" > Tiện ích mở rộng > Apps Script, tạo file mới, dán mã này.
 *     Nếu project đã có hàm doPost (script CRM), hãy tạo project Apps Script riêng.
 *   - Cài đặt dự án > Thuộc tính tập lệnh, thêm:
 *       TELEGRAM_BOT_TOKEN = token bot lấy từ @BotFather
 *       TELEGRAM_CHAT_ID   = id nhóm/người nhận (nhóm thường là số âm, ví dụ -1001234567890)
 *     Không dán token vào mã nguồn.
 *   - Chạy hàm testTelegram() một lần để cấp quyền và kiểm tra tin nhắn.
 *   - Triển khai > Tùy chọn triển khai mới > Ứng dụng web (Thực thi với: Tôi, Ai có quyền truy cập: Bất kỳ ai).
 *   - Dán URL /exec vào CONFIG.LEAD_ENDPOINT trong web/assets/site.js,
 *     và vào form LadiPage: Lưu data > thêm tài khoản liên kết "API Webhook" với URL /exec.
 */
const SHEET_ID = '1yvgJAi4LKDZXiWSa_sS02rlQxvhh-nO-4kJ3GmxzxOE';
const TAB_NAME = 'Dowtown';
const NOTIFY_EMAIL = 'hiephoangmt@gmail.com';
const FORM_CODES = { form: 'WEB-FORM', popup: 'WEB-POPUP', chat: 'WEB-CHAT' };

function doPost(e) {
  const lock = LockService.getScriptLock();
  lock.waitLock(10000);
  try {
    const d = normalize(readPayload(e));
    if (!/^(\+84|0)\d{9,10}$/.test(d.phone)) return json({ ok: false, error: 'invalid_phone' });

    const tz = Session.getScriptTimeZone() || 'Asia/Ho_Chi_Minh';
    const detail = [d.need, d.unit_type, d.channel && ('Nhận qua ' + d.channel)].filter(String).join(' | ');
    const row = new Array(12).fill('');
    row[0] = Utilities.formatDate(new Date(), tz, 'yyyy-MM-dd HH:mm');
    row[1] = clip(d.name, 80);
    row[2] = "'" + d.phone;               // giữ số 0 đầu
    row[3] = clip(detail, 200);
    row[4] = clip(d.landing || d.page, 500);
    row[11] = d.formCode;

    const sheet = SpreadsheetApp.openById(SHEET_ID).getSheetByName(TAB_NAME);
    sheet.appendRow(row);
    if (d.note) sheet.getRange(sheet.getLastRow(), 4).setNote(clip(d.note, 2000));

    const project = projectOf(d.page || d.landing);
    notifyTelegram([
      '🔔 <b>Khách mới – ' + esc(project) + '</b>',
      '👤 ' + esc(row[1] || 'Chưa có tên'),
      '📞 <a href="tel:' + d.phone + '">' + d.phone + '</a> · <a href="https://zalo.me/' + d.phone.replace(/^\+84/, '0') + '">Zalo</a>',
      detail ? '📝 ' + esc(detail) : '',
      '🧾 ' + esc(d.formCode) + ' · ' + row[0],
      row[4] ? '🔗 ' + esc(String(row[4]).slice(0, 300)) : '',
      d.note ? '💬 ' + esc(String(d.note).slice(-600)) : ''
    ]);

    MailApp.sendEmail({
      to: NOTIFY_EMAIL,
      subject: 'Khách mới ' + project + ': ' + row[1] + ' – ' + d.phone + ' (' + d.formCode + ')',
      body: ['Thời gian: ' + row[0], 'Họ tên: ' + row[1], 'SĐT: ' + d.phone, 'Chi tiết: ' + row[3],
             'Trang: ' + row[4], 'Form: ' + d.formCode, d.note ? 'Chat: ' + d.note : ''].join('\n')
    });
    return json({ ok: true });
  } catch (err) {
    return json({ ok: false, error: String(err) });
  } finally {
    lock.releaseLock();
  }
}

/** Website gửi JSON (text/plain); webhook LadiPage có thể gửi JSON hoặc dạng form. */
function readPayload(e) {
  const body = e && e.postData && e.postData.contents;
  if (body) {
    try { return JSON.parse(body); } catch (err) { /* không phải JSON */ }
  }
  return (e && e.parameter) || {};
}

function normalize(raw) {
  const pick = (...keys) => {
    for (const k of keys) if (raw[k] != null && String(raw[k]).trim() !== '') return String(raw[k]).trim();
    return '';
  };
  let phone = pick('phone', 'so_dien_thoai', 'phone_number', 'sdt').replace(/[^\d+]/g, '');
  if (/^84\d{9,10}$/.test(phone)) phone = '+' + phone;
  const via = pick('via');
  return {
    name: pick('name', 'full_name', 'ho_ten', 'fullname'),
    phone,
    need: pick('need', 'nhu_cau', 'message'),
    unit_type: pick('unit_type', 'loai_can'),
    channel: pick('channel'),
    note: pick('note'),
    page: pick('page', 'url_page', 'link', 'url'),
    landing: pick('landing'),
    formCode: FORM_CODES[via] || pick('form_name', 'form_id', 'form') || 'LADIPAGE'
  };
}

function projectOf(url) {
  const u = String(url || '');
  if (/sun-galaxy-complex/.test(u)) return 'Sun Galaxy Complex';
  if (/thap-69-tang/.test(u)) return 'Tháp 69 tầng (408m)';
  return 'Da Nang Downtown';
}

function notifyTelegram(lines) {
  const props = PropertiesService.getScriptProperties();
  const token = props.getProperty('TELEGRAM_BOT_TOKEN');
  const chatId = props.getProperty('TELEGRAM_CHAT_ID');
  if (!token || !chatId) return;
  try {
    UrlFetchApp.fetch('https://api.telegram.org/bot' + token + '/sendMessage', {
      method: 'post',
      contentType: 'application/json',
      muteHttpExceptions: true,
      payload: JSON.stringify({
        chat_id: chatId,
        text: lines.filter(String).join('\n'),
        parse_mode: 'HTML',
        disable_web_page_preview: true
      })
    });
  } catch (err) {
    console.error('Telegram: ' + err); // không chặn việc ghi lead
  }
}

/** Chạy tay một lần trong trình soạn Apps Script để cấp quyền và thử gửi Telegram. */
function testTelegram() {
  notifyTelegram(['✅ Kết nối Telegram cho website Da Nang Downtown đã hoạt động.']);
}

function esc(s) {
  return String(s).replace(/[&<>]/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;' }[c]));
}

function clip(v, n) {
  const s = String(v == null ? '' : v);
  // Chặn công thức bị chèn vào Sheet
  return (/^[=+\-@]/.test(s) ? "'" + s : s).slice(0, n);
}

function json(obj) {
  return ContentService.createTextOutput(JSON.stringify(obj)).setMimeType(ContentService.MimeType.JSON);
}
