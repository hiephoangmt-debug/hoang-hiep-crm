/**
 * Tele.gs – BÁO VỀ TELEGRAM cho "CRM Hoàng Hiệp".
 * Cách cài (5 phút):
 *  1. Mở Apps Script của CRM Hoàng Hiệp → bấm dấu + → Tệp lệnh → đặt tên "Tele" → dán toàn bộ file này.
 *  2. Dán token bot (lấy từ @BotFather) vào TELE_TOKEN. Mở bot trên Telegram, bấm Start, gửi "hi".
 *  3. Chọn hàm layChatId → Chạy → xem Nhật ký thực thi, chép số chat_id vào TELE_CHAT_ID.
 *  4. Trong file Code.gs thêm 2 dòng (xem HUONG-DAN-TELEGRAM.md):
 *       - handleTrack_: sau dòng logClick_  →  if (type === 'click') teleClick_(b, site, ch);
 *       - handleLead_:  sau dòng "if (!phone) return ..."  →  teleLead_(b, site, phone);
 *  5. Chạy hàm thuTele để thử, rồi Triển khai → Quản lý bản triển khai → Sửa → Phiên bản mới → Triển khai.
 */
var TELE_TOKEN = 'DAN_TOKEN_BOT_VAO_DAY';
var TELE_CHAT_ID = 'DAN_CHAT_ID_VAO_DAY';

/** Khách để lại số: form trên trang, ô chat tự động có số điện thoại */
function teleLead_(b, site, phone) {
  teleSend_([
    '🔔 KHÁCH MỚI · ' + (site && site.name || 'website'),
    '👤 ' + (b.name || '(chưa có tên)'),
    '📱 ' + phone + '  ·  Zalo: https://zalo.me/' + phone,
    b.nhu_cau ? '🎯 Nhu cầu: ' + b.nhu_cau : '',
    b.loai_can ? '🏠 Loại căn: ' + b.loai_can : '',
    b.ngan_sach ? '💰 Ngân sách: ' + b.ngan_sach : '',
    b.message ? '💬 ' + String(b.message).slice(0, 300) : '',
    (b.utm_source || b.utm_campaign) ? '📣 ' + [b.utm_source, b.utm_campaign].filter(String).join(' / ') : '',
    b.url ? '🔗 ' + String(b.url).slice(0, 200) : '',
    '🕒 ' + teleNow_()
  ].filter(String).join('\n'));
}

/** Khách bấm nút Gọi / Zalo / Messenger (chưa có số – xem tab "Lượt bấm") */
function teleClick_(b, site, ch) {
  var label = { phone: '📞 Khách bấm GỌI', zalo: '💬 Khách bấm ZALO', messenger: '💬 Khách bấm MESSENGER', sms: '✉️ Khách bấm SMS' }[ch];
  if (!label) return;
  teleSend_(label + ' · ' + (site && site.name || 'website')
    + (b.utm_source ? '\n📣 ' + [b.utm_source, b.utm_campaign].filter(String).join(' / ') : '')
    + (b.url ? '\n🔗 ' + String(b.url).slice(0, 200) : '')
    + '\n🕒 ' + teleNow_());
}

/** Bỏ ký tự ẩn / khoảng trắng lẫn vào khi dán token (lỗi "Địa chỉ không khả dụng") */
function teleUrl_(method) {
  var t = String(TELE_TOKEN).replace(/[^0-9A-Za-z:_-]/g, '');
  return 'https://api.telegram.org/bot' + t + '/' + method;
}
function teleChat_() { return String(TELE_CHAT_ID).replace(/[^0-9-]/g, ''); }

function teleSend_(text) {
  try {
    UrlFetchApp.fetch(teleUrl_('sendMessage'), {
      method: 'post', contentType: 'application/json', muteHttpExceptions: true,
      payload: JSON.stringify({ chat_id: teleChat_(), text: text, disable_web_page_preview: true })
    });
  } catch (err) {} // lỗi Telegram không làm hỏng việc lưu khách vào CRM
}

function teleNow_() { return Utilities.formatDate(new Date(), 'Asia/Ho_Chi_Minh', 'dd/MM/yyyy HH:mm'); }

/** Chạy 1 lần sau khi đã bấm Start / gửi "hi" cho bot → xem Nhật ký thực thi để lấy chat_id */
function layChatId() {
  var r = UrlFetchApp.fetch(teleUrl_('getUpdates'), { muteHttpExceptions: true });
  var j = JSON.parse(r.getContentText());
  if (!j.ok) { Logger.log('TOKEN SAI: ' + j.description + ' → dán lại token từ @BotFather'); return; }
  if (!j.result.length) { Logger.log('Token đúng nhưng bot chưa nhận tin. Mở bot trên Telegram, bấm Start, gửi "hi" rồi chạy lại.'); return; }
  j.result.forEach(function (u) {
    var c = (u.message || u.my_chat_member || u.channel_post || {}).chat;
    if (c) Logger.log('chat_id = ' + c.id + '  (' + (c.title || c.first_name || '') + ')');
  });
}

/** Chạy thử → Telegram nhận 2 tin mẫu */
function thuTele() {
  teleLead_({ name: 'Khách thử', nhu_cau: 'Tài sản tạo dòng tiền', loai_can: '2PN', ngan_sach: '3–5 tỷ',
    utm_source: 'google', utm_campaign: 'haiminh', url: 'https://www.cănhộdịchvụhảiminh.com.vn/ads' }, { name: 'Hải Minh Đà Nẵng' }, '0909000000');
  teleClick_({ utm_source: 'google', url: 'https://www.cănhộdịchvụhảiminh.com.vn/ads' }, { name: 'Hải Minh Đà Nẵng' }, 'zalo');
}
