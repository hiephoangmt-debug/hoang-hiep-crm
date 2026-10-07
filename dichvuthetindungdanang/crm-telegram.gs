/**
 * Tele.gs – BÁO VỀ TELEGRAM cho "CRM Thẻ Tín Dụng".
 * Tạo file mới tên Tele trong Apps Script, dán toàn bộ file này vào. KHÔNG sửa gì khác trong Mã.gs
 * ngoài 1–2 dòng gọi hàm (xem hướng dẫn).
 */
var TELE_TOKEN = 'DAN_TOKEN_BOT_VAO_DAY';   // lấy từ @BotFather
var TELE_CHAT_ID = 'DAN_CHAT_ID_VAO_DAY';   // chạy hàm layChatId để lấy

/** Gọi trong notifyNewLead_(lead) – khách để lại số (form / chat web) */
function teleLead_(lead) {
  teleSend_([
    '🔔 KHÁCH MỚI từ ' + (lead.nguon || 'website'),
    '👤 ' + (lead.ten || '(chưa có tên)'),
    '📱 ' + lead.sdt + '  ·  Zalo: https://zalo.me/' + lead.sdt,
    lead.dich_vu ? '📝 ' + lead.dich_vu : '',
    lead.ghi_chu ? '💬 ' + lead.ghi_chu : '',
    '🕒 ' + lead.thoi_gian
  ].filter(String).join('\n'));
}

/** Gọi trong logClick_(d) – khách bấm nút Gọi / Zalo (chưa có số) */
function teleClick_(d) {
  teleSend_((d.loai === 'goi' ? '📞 Khách bấm GỌI' : '💬 Khách bấm ZALO') + ' trên ' + (d.nguon || 'website')
    + (d.dich_vu ? '\n' + d.dich_vu : ''));
}

function teleSend_(text) {
  try {
    UrlFetchApp.fetch('https://api.telegram.org/bot' + TELE_TOKEN + '/sendMessage', {
      method: 'post', contentType: 'application/json', muteHttpExceptions: true,
      payload: JSON.stringify({ chat_id: TELE_CHAT_ID, text: text, disable_web_page_preview: true })
    });
  } catch (err) {} // lỗi Telegram không làm hỏng việc lưu khách vào CRM
}

/** Chạy 1 lần (sau khi đã bấm Start / nhắn "hi" cho bot) → xem Nhật ký thực thi để lấy chat_id */
function layChatId() {
  var r = UrlFetchApp.fetch('https://api.telegram.org/bot' + TELE_TOKEN + '/getUpdates', { muteHttpExceptions: true });
  var res = JSON.parse(r.getContentText()).result || [];
  if (!res.length) { Logger.log('Chưa thấy tin nhắn – mở bot, bấm Start / gửi "hi" rồi chạy lại.'); return; }
  res.forEach(function (u) {
    var c = (u.message || u.channel_post || {}).chat;
    if (c) Logger.log('chat_id = ' + c.id + '  (' + (c.title || c.first_name || '') + ')');
  });
}

/** Chạy thử → Telegram nhận tin mẫu */
function thuTele() {
  teleLead_({ ten: 'Khách thử', sdt: '0909000000', dich_vu: 'Chat web – Rút tiền thẻ tín dụng – VPBank – 10 – 50 triệu',
    ghi_chu: '', nguon: 'the-tin-dung-da-nang.com', thoi_gian: Utilities.formatDate(new Date(), 'Asia/Ho_Chi_Minh', 'dd/MM/yyyy HH:mm') });
}
