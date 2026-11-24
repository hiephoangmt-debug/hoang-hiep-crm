/**
 * DanangStay – nhận yêu cầu đặt phòng từ landing page, ghi vào Google Sheet
 * và (tùy chọn) báo ngay về Telegram.
 *
 * Cách dùng:
 * 1. Tạo Google Sheet mới → Tiện ích mở rộng → Apps Script → dán toàn bộ file này.
 * 2. (Tùy chọn) điền TELEGRAM_TOKEN và TELEGRAM_CHAT_ID để nhận báo khách mới.
 * 3. Triển khai → Tùy chọn triển khai mới → Loại: Ứng dụng web
 *    → Thực thi dưới dạng: Tôi → Ai có quyền truy cập: Bất kỳ ai → Triển khai.
 * 4. Copy link Web App, dán vào CONFIG.sheetWebhook trong danangstay/index.html.
 */
var TELEGRAM_TOKEN = '';   // token bot Telegram (để trống nếu không dùng)
var TELEGRAM_CHAT_ID = ''; // chat id nhận thông báo
var SHEET_NAME = 'DatPhong';
var COLS = ['time', 'source', 'name', 'phone', 'via', 'checkin', 'checkout', 'nights',
            'guests', 'rooms', 'budget', 'msg', 'lang', 'utm', 'page', 'trang_thai'];

function doPost(e) {
  var d = {};
  try { d = JSON.parse(e.postData.contents); } catch (err) { return out({ ok: false }); }
  // Chặn spam cơ bản: thiếu SĐT hoặc chuỗi quá dài
  var phone = String(d.phone || '').replace(/\D/g, '');
  if (phone.length < 6 || JSON.stringify(d).length > 4000) return out({ ok: false });

  var lock = LockService.getScriptLock();
  lock.waitLock(10000);
  try {
    var ss = SpreadsheetApp.getActiveSpreadsheet();
    var sh = ss.getSheetByName(SHEET_NAME) || ss.insertSheet(SHEET_NAME);
    if (sh.getLastRow() === 0) { sh.appendRow(COLS); sh.setFrozenRows(1); }
    d.time = new Date();
    d.trang_thai = 'Mới';
    sh.appendRow(COLS.map(function (c) { return d[c] === undefined ? '' : safe(d[c]); }));
  } finally { lock.releaseLock(); }

  if (TELEGRAM_TOKEN && TELEGRAM_CHAT_ID) {
    var text = '🆕 DanangStay – ' + (d.source || 'Khách đặt phòng') + '\n' +
      '👤 ' + d.name + ' · ' + d.phone + ' (' + d.via + ', ' + d.lang + ')\n' +
      '📅 ' + d.checkin + ' → ' + d.checkout + ' (' + d.nights + ' đêm)\n' +
      '👥 ' + d.guests + ' khách · ' + d.rooms + ' phòng · 💰 ' + d.budget +
      (d.msg ? '\n📝 ' + d.msg : '');
    UrlFetchApp.fetch('https://api.telegram.org/bot' + TELEGRAM_TOKEN + '/sendMessage', {
      method: 'post', payload: { chat_id: TELEGRAM_CHAT_ID, text: text }, muteHttpExceptions: true
    });
  }
  return out({ ok: true });
}

// Không cho chuỗi bắt đầu bằng = + - @ để tránh chèn công thức vào Sheet
function safe(v) { v = String(v); return /^[=+\-@]/.test(v) ? "'" + v : v; }
function out(o) { return ContentService.createTextOutput(JSON.stringify(o)).setMimeType(ContentService.MimeType.JSON); }
