/**
 * BÁO VỀ TELEGRAM khi có khách chat / để lại số / bấm Gọi – Zalo trên web.
 * DÁN THÊM vào Apps Script CRM đang có (KHÔNG xoá code cũ), xem hướng dẫn trong chat.
 */
var TELE_TOKEN = 'DAN_TOKEN_BOT_VAO_DAY';   // lấy từ @BotFather
var TELE_CHAT_ID = 'DAN_CHAT_ID_VAO_DAY';   // chạy hàm layChatId để lấy

function notifyTele_(e) {
  try {
    var d = {};
    if (e && e.parameter) for (var k in e.parameter) d[k] = e.parameter[k];
    if (e && e.postData && e.postData.contents) {
      try { var j = JSON.parse(e.postData.contents); for (var k2 in j) d[k2] = j[k2]; } catch (x) {}
    }
    if (d.website) return; // bẫy spam
    var title = d.loai === 'goi' ? '📞 Khách bấm GỌI trên web'
              : d.loai === 'zalo' ? '💬 Khách bấm ZALO trên web'
              : '🔔 KHÁCH MỚI để lại thông tin';
    var lines = [title];
    var name = d.name || d.ho_ten || d.full_name, phone = d.phone || d.so_dien_thoai || d.sdt;
    var service = d.service || d.dich_vu || d.message;
    if (name) lines.push('👤 ' + name);
    if (phone) lines.push('📱 ' + phone);
    if (service) lines.push('📝 ' + service);
    if (d.source) lines.push('🌐 ' + d.source + (d.page || ''));
    lines.push('🕒 ' + Utilities.formatDate(new Date(), 'Asia/Ho_Chi_Minh', 'HH:mm dd/MM/yyyy'));
    teleSend_(lines.join('\n'));
  } catch (err) {}
}

function teleSend_(text) {
  UrlFetchApp.fetch('https://api.telegram.org/bot' + TELE_TOKEN + '/sendMessage', {
    method: 'post', contentType: 'application/json', muteHttpExceptions: true,
    payload: JSON.stringify({ chat_id: TELE_CHAT_ID, text: text })
  });
}

/** Chạy 1 lần (sau khi đã nhắn /start cho bot) → xem Nhật ký thực thi để lấy chat_id */
function layChatId() {
  var r = UrlFetchApp.fetch('https://api.telegram.org/bot' + TELE_TOKEN + '/getUpdates', { muteHttpExceptions: true });
  var res = JSON.parse(r.getContentText()).result || [];
  if (!res.length) { Logger.log('Chưa thấy tin nhắn – hãy mở bot trên Telegram, bấm Start / gửi "hi" rồi chạy lại.'); return; }
  res.forEach(function (u) {
    var c = (u.message || u.channel_post || {}).chat;
    if (c) Logger.log('chat_id = ' + c.id + '  (' + (c.title || c.first_name || '') + ')');
  });
}

/** Chạy thử → Telegram nhận tin mẫu */
function thuTele() {
  notifyTele_({ postData: { contents: JSON.stringify({ name: 'Khách thử', phone: '0909000000', service: 'Chat web – Rút tiền thẻ tín dụng – VPBank – 10 – 50 triệu', source: 'the-tin-dung-da-nang.com', page: '/' }) } });
}
