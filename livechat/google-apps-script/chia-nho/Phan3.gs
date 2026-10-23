// ===== PHẦN 3/3: Telegram + cài đặt (dán vào file Phan3.gs) =====
// ---------- Telegram ----------
function tg_(method, body) {
  if (!TELEGRAM_BOT_TOKEN) return null;
  const r = UrlFetchApp.fetch('https://api.telegram.org/bot' + TELEGRAM_BOT_TOKEN + '/' + method, {
    method: 'post', contentType: 'application/json', payload: JSON.stringify(body), muteHttpExceptions: true,
  });
  try { return JSON.parse(r.getContentText()); } catch (e) { return null; }
}
function chatIds_() { return String(TELEGRAM_CHAT_ID).split(',').map(function (s) { return s.trim(); }).filter(String); }

function mapSet_(key, v) { sheet_('Map').appendRow([key, v]); }
function mapGet_(key) {
  const f = sheet_('Map').createTextFinder(key).matchEntireCell(true).findNext();
  return f ? String(f.offset(0, 1).getValue()) : '';
}

function notify_(v, html) {
  const hint = '\n<i>💬 Nhắn thẳng = trả lời khách mới nhất · vuốt trái tin này để trả lời đúng khách · /zalo = mời khách qua Zalo</i>';
  chatIds_().forEach(function (id) {
    const res = tg_('sendMessage', { chat_id: id, text: html + hint, parse_mode: 'HTML', disable_web_page_preview: true });
    if (res && res.ok) mapSet_(id + ':' + res.result.message_id, v);
  });
  // Nhớ khách gần nhất: nhắn không bấm Reply sẽ gửi cho khách này
  const label = String(html).replace(/<[^>]+>/g, '').split('\n').map(function (l) { return l.trim(); }).filter(String).slice(0, 3).join(' · ').slice(0, 120);
  PropertiesService.getScriptProperties().setProperty('last_khach', JSON.stringify({ v: v, t: Date.now(), who: label }));
}

function lastKhach_() {
  try {
    const o = JSON.parse(PropertiesService.getScriptProperties().getProperty('last_khach') || 'null');
    return o && Date.now() - o.t < 12 * 3600 * 1000 ? o : null;
  } catch (e) { return null; }
}

function handleTelegram_(u) {
  const cache = CacheService.getScriptCache();
  if (cache.get('u_' + u.update_id)) return; // bỏ tin lặp
  cache.put('u_' + u.update_id, '1', 21600);
  const msg = u.message;
  if (!msg || !msg.text) return;
  const chatId = String(msg.chat.id);
  if (chatIds_().indexOf(chatId) < 0) {
    tg_('sendMessage', { chat_id: chatId, text: 'Chat ID của bạn là: ' + chatId + '\nĐiền vào TELEGRAM_CHAT_ID trong Apps Script để nhận thông báo.' });
    return;
  }
  if (/^\/start\b/.test(msg.text)) {
    tg_('sendMessage', { chat_id: chatId, text: '✅ Đã kết nối chat Casamia Balanca qua Google. Thông báo khách mới sẽ gửi về đây.' });
    return;
  }
  if (/^\/(ai|aikey)(@\w+)?(\s|$)/i.test(msg.text.trim()) && typeof aiCommand_ === 'function') { aiCommand_(chatId, msg); return; }
  let v = msg.reply_to_message ? mapGet_(chatId + ':' + msg.reply_to_message.message_id) : '';
  let ganNhat = null;
  if (!v) {
    ganNhat = lastKhach_();
    if (!ganNhat) {
      tg_('sendMessage', { chat_id: chatId, text: 'Chưa có khách nào trong 12 giờ qua. Để trả lời khách cũ: chạm giữ (hoặc vuốt sang trái) tin báo của khách đó → Trả lời, rồi gõ nội dung.', reply_to_message_id: msg.message_id });
      return;
    }
    v = ganNhat.v;
  }
  const isZalo = /^\/zalo\b/i.test(msg.text.trim());
  const text = isZalo ? ZALO_INVITE : clean_(msg.text);
  sheet_('TraLoi').appendRow([Utilities.getUuid(), v, text, Date.now(), isZalo ? 'zalo' : '']);
  sheet_('Chat').appendRow([now_(), v, 'Tư vấn', text]);
  mapSet_(chatId + ':' + msg.message_id, v);
  let xacNhan = isZalo ? '✅ Đã gửi lời mời Zalo cho khách' : '✅ Đã gửi cho khách (khách nhận trong vài giây)';
  if (ganNhat) xacNhan += '\n👤 Khách gần nhất: ' + ganNhat.who + '\n(Muốn gửi khách khác: vuốt sang trái tin báo của khách đó rồi nhắn)';
  const ok = tg_('sendMessage', { chat_id: chatId, text: xacNhan, reply_to_message_id: msg.message_id });
  if (ok && ok.ok) mapSet_(chatId + ':' + ok.result.message_id, v);
}

// ---------- Chạy tay 1 lần sau khi triển khai ----------
function caiDatTelegram() {
  if (!TELEGRAM_BOT_TOKEN) throw new Error('Chưa điền TELEGRAM_BOT_TOKEN');
  if (!/\/exec$/.test(WEB_APP_URL)) throw new Error('Chưa điền WEB_APP_URL (URL ứng dụng web, kết thúc bằng /exec)');
  ['Lead', 'Chat', 'TraLoi', 'Map'].forEach(sheet_);
  const r = tg_('setWebhook', { url: WEB_APP_URL, allowed_updates: ['message'], drop_pending_updates: true });
  Logger.log(JSON.stringify(r));
  if (!r || !r.ok) throw new Error('Đặt webhook lỗi: ' + JSON.stringify(r));
  Logger.log('✅ Xong. Nhắn bất kỳ cho bot để lấy chat ID (nếu chưa có), rồi gửi /start.');
}

// Xem tình trạng kết nối Telegram (khi không nhận được tin trả lời)
function kiemTraTelegram() {
  Logger.log(JSON.stringify(tg_('getWebhookInfo', {})));
}
