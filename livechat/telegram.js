// Thông báo live chat qua Telegram + trả lời khách ngay trong Telegram.
//   TELEGRAM_BOT_TOKEN : mã bot lấy từ @BotFather
//   TELEGRAM_CHAT_ID   : chat ID nhận thông báo (nhiều người: cách nhau dấu phẩy, nhóm: số âm)
//   PUBLIC_URL         : địa chỉ server chat, dùng để tạo link mở hội thoại
const API = process.env.TELEGRAM_API_BASE || 'https://api.telegram.org';
const TOKEN = process.env.TELEGRAM_BOT_TOKEN || '';
const CHAT_IDS = (process.env.TELEGRAM_CHAT_ID || '').split(',').map(s => s.trim()).filter(Boolean);
const PUBLIC_URL = (process.env.PUBLIC_URL || '').replace(/\/$/, '');

const enabled = Boolean(TOKEN);
const msgToConv = new Map(); // `${chatId}:${messageId}` -> conversationId
const lastNotified = new Map(); // conversationId -> thời điểm báo gần nhất
const QUIET_MS = 60 * 1000; // gộp tin: cùng khách nhắn liên tục chỉ báo 1 lần/phút
let replyHandler = () => {};

const esc = s => String(s ?? '').replace(/[&<>]/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;' }[c]));

async function call(method, body) {
  const r = await fetch(`${API}/bot${TOKEN}/${method}`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(body),
  });
  const data = await r.json();
  if (!data.ok) throw new Error(data.description || method + ' lỗi');
  return data.result;
}

async function broadcast(conv, html) {
  if (!enabled || !CHAT_IDS.length) return;
  const link = PUBLIC_URL ? `\n\n<a href="${PUBLIC_URL}/agent.html#${conv.id}">Mở hội thoại</a>` : '';
  const hint = '\n<i>↩️ Reply tin này để trả lời khách · gõ /zalo để chuyển Zalo</i>';
  for (const chatId of CHAT_IDS) {
    try {
      const m = await call('sendMessage', { chat_id: chatId, text: html + link + hint, parse_mode: 'HTML', disable_web_page_preview: true });
      msgToConv.set(`${chatId}:${m.message_id}`, conv.id);
      if (msgToConv.size > 5000) msgToConv.delete(msgToConv.keys().next().value);
    } catch (e) {
      console.error('Telegram gửi lỗi:', e.message);
    }
  }
}

function who(conv) {
  const l = conv.lead || {};
  return l.name || l.phone ? `${esc(l.name || 'Khách')}${l.phone ? ' – ' + esc(l.phone) : ''}` : `Khách #${conv.id.slice(0, 6)}`;
}

// Hội thoại gần nhất, tách từng lượt Khách / Tư vấn, mỗi lượt cách nhau 1 dòng trống.
function transcript(conv, max = 8) {
  const LABEL = { visitor: '🙋 <b>KHÁCH</b>', agent: '💼 <b>TƯ VẤN</b>', auto: '🤖 <b>TƯ VẤN (tự động)</b>' };
  const groups = [];
  for (const m of (conv.messages || []).slice(-max)) {
    if (m.from === 'system') { groups.push({ note: m.text }); continue; }
    const who = m.from === 'visitor' ? 'visitor' : m.auto ? 'auto' : 'agent';
    const text = m.text.length > 300 ? m.text.slice(0, 300) + '…' : m.text;
    const g = groups[groups.length - 1];
    if (g && g.who === who) g.lines.push(text);
    else groups.push({ who, lines: [text] });
  }
  const out = groups.map(g => g.note ? `<i>${esc(g.note)}</i>` : `${LABEL[g.who]}\n${g.lines.map(esc).join('\n')}`).join('\n\n');
  return out.length > 3000 ? '…' + out.slice(-3000) : out;
}

function notifyMessage(conv, text, { isNew, agentsOnline }) {
  const recent = Date.now() - (lastNotified.get(conv.id) || 0) < QUIET_MS;
  if (!isNew && recent) return;
  lastNotified.set(conv.id, Date.now());
  const title = isNew ? '🔔 <b>KHÁCH MỚI VÀO CHAT</b>' : '💬 <b>Tin nhắn mới</b>';
  const status = agentsOnline ? '' : '\n⚠️ Chưa có tư vấn viên trực tuyến – chat đang tự trả lời';
  const page = isNew && conv.page ? `\n🌐 ${esc(conv.page)}` : '';
  broadcast(conv, `${title}\n👤 ${who(conv)}${page}${status}\n──────────\n\n${transcript(conv)}`);
}

function notifyBrowse(conv, topic, seconds, question) {
  broadcast(conv,
    `👀 <b>KHÁCH ĐANG ĐỌC KỸ: ${esc(topic.toUpperCase())}</b>\n👤 ${who(conv)} · dừng ${seconds} giây` +
    (conv.page ? `\n🌐 ${esc(conv.page)}` : '') +
    `\n──────────\n\n🤖 <b>TƯ VẤN (tự động)</b> đã hỏi:\n${esc(question)}`);
}

function notifyLead(conv) {
  const l = conv.lead;
  broadcast(conv,
    `🔥 <b>CÓ SỐ ĐIỆN THOẠI KHÁCH</b>\n👤 ${esc(l.name || '(chưa có tên)')}\n📞 <b>${esc(l.phone)}</b>` +
    `\n\nGọi lại ngay: tel:${esc(l.phone)}`);
}

// Nhận tin trả lời từ Telegram (long polling, không cần mở cổng/webhook).
async function poll() {
  let offset = 0;
  for (;;) {
    try {
      const updates = await call('getUpdates', { offset, timeout: 50, allowed_updates: ['message'] });
      for (const u of updates) {
        offset = u.update_id + 1;
        handle(u.message);
      }
    } catch (e) {
      console.error('Telegram nhận tin lỗi:', e.message);
      await new Promise(r => setTimeout(r, 5000));
    }
  }
}

function handle(msg) {
  if (!msg?.text) return;
  const chatId = String(msg.chat.id);
  if (!CHAT_IDS.includes(chatId)) {
    // Giúp lấy chat ID khi cài đặt.
    return call('sendMessage', { chat_id: chatId, text: `Chat ID của bạn là: ${chatId}\nĐặt TELEGRAM_CHAT_ID=${chatId} trên server để nhận thông báo.` }).catch(() => {});
  }
  if (msg.text.startsWith('/start')) {
    return call('sendMessage', { chat_id: chatId, text: '✅ Đã kết nối live chat Casamia Balanca. Thông báo khách mới sẽ gửi về đây.' }).catch(() => {});
  }
  const convId = msg.reply_to_message && msgToConv.get(`${chatId}:${msg.reply_to_message.message_id}`);
  if (!convId) {
    return call('sendMessage', { chat_id: chatId, text: '↩️ Hãy bấm "Reply" vào tin thông báo của khách để trả lời đúng người.', reply_to_message_id: msg.message_id }).catch(() => {});
  }
  const isZalo = /^\/zalo\b/i.test(msg.text.trim());
  const ok = replyHandler(convId, isZalo ? '' : msg.text, isZalo ? 'zalo' : undefined);
  call('sendMessage', {
    chat_id: chatId,
    text: ok ? (isZalo ? '✅ Đã gửi lời mời Zalo cho khách' : '✅ Đã gửi cho khách') : '❌ Không tìm thấy hội thoại',
    reply_to_message_id: msg.message_id,
  }).then(m => ok && msgToConv.set(`${chatId}:${m.message_id}`, convId)).catch(() => {});
  // Reply tiếp vào chính tin của mình cũng được.
  msgToConv.set(`${chatId}:${msg.message_id}`, convId);
}

function start(onReply) {
  if (!enabled) return;
  replyHandler = onReply;
  poll();
  console.log(`  • Telegram: bật (${CHAT_IDS.length ? CHAT_IDS.length + ' người nhận' : 'chưa có TELEGRAM_CHAT_ID – nhắn bot để lấy ID'})`);
}

module.exports = { start, notifyMessage, notifyLead, notifyBrowse };
