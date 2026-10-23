/**
 * CHAT AI THÔNG MINH (Claude) – tự trả lời khách khi tư vấn viên chưa vào.
 * Cài khoá (chọn 1 cách):
 *  - Telegram: nhắn riêng cho bot  /aikey sk-ant-...  (bot tự xoá tin chứa khoá). /ai xem trạng thái, /ai tat, /ai bat.
 *  - Hoặc: Cài đặt dự án (bánh răng) → Thuộc tính tập lệnh → thêm ANTHROPIC_API_KEY = khoá API.
 * KHÔNG dán khoá vào code. Lời dặn và kiến thức dự án nằm trong KienThuc.gs.
 */
const AI_MODEL = 'claude-opus-5-5';
const AI_DAILY_LIMIT = 400;        // tối đa số câu AI trả lời mỗi ngày (giữ chi phí)
const AI_PER_VISITOR = 25;         // tối đa mỗi khách mỗi ngày

function aiReply_(b) {
  const props = PropertiesService.getScriptProperties();
  const key = props.getProperty('ANTHROPIC_API_KEY');
  if (!key || props.getProperty('AI_OFF')) return null;
  const cache = CacheService.getScriptCache();
  const day = Utilities.formatDate(new Date(), 'Asia/Ho_Chi_Minh', 'yyyyMMdd');
  const total = Number(cache.get('ai_' + day) || 0), mine = Number(cache.get('ai_' + day + b.v) || 0);
  if (total >= AI_DAILY_LIMIT || mine >= AI_PER_VISITOR) return null;
  cache.put('ai_' + day, String(total + 1), 21600);
  cache.put('ai_' + day + b.v, String(mine + 1), 21600);

  const messages = aiMessages_(b.history, b.hasPhone);
  if (!messages) return null;
  const res = UrlFetchApp.fetch('https://api.anthropic.com/v1/messages', {
    method: 'post', contentType: 'application/json', muteHttpExceptions: true,
    headers: { 'x-api-key': key, 'anthropic-version': '2023-06-01', 'anthropic-beta': 'server-side-fallback-2026-07-01' },
    payload: JSON.stringify({
      model: AI_MODEL,
      max_tokens: 4000,
      output_config: { effort: 'low' },
      fallbacks: 'default',
      system: [{ type: 'text', text: AI_SYSTEM, cache_control: { type: 'ephemeral' } }],
      messages: messages,
    }),
  });
  if (res.getResponseCode() !== 200) { console.warn('Claude API ' + res.getResponseCode() + ': ' + res.getContentText().slice(0, 500)); return null; }
  return aiParse_(JSON.parse(res.getContentText()));
}

// Lịch sử chat của widget → tin nhắn cho Claude (khách = user, tư vấn/bot = assistant, xen kẽ, bắt đầu bằng user)
function aiMessages_(history, hasPhone) {
  const list = (Array.isArray(history) ? history : []).slice(-14);
  const out = [];
  list.forEach(function (m) {
    const role = m && m.from === 'visitor' ? 'user' : 'assistant';
    const text = clean_(m && m.text, 1000);
    if (!text) return;
    const last = out[out.length - 1];
    if (last && last.role === role) last.content += '\n' + text; else out.push({ role: role, content: text });
  });
  if (!out.length || out[out.length - 1].role !== 'user') return null;
  if (out[0].role === 'assistant') out.unshift({ role: 'user', content: '(Khách mở khung chat)' });
  out[out.length - 1].content += hasPhone ? '\n\n[Ghi chú hệ thống: khách đã để lại số điện thoại, không xin lại.]' : '';
  return out;
}

// Lấy chữ trả lời; thẻ [ZALO]/[FORM] → nút trên khung chat. Từ chối hoặc lỗi → null (dùng kịch bản soạn sẵn).
function aiParse_(r) {
  if (!r || r.stop_reason === 'refusal') return null;
  let text = (r.content || []).filter(function (c) { return c.type === 'text'; }).map(function (c) { return c.text; }).join('').trim();
  if (!text) return null;
  const zalo = /\[ZALO\]/i.test(text), form = /\[FORM\]/i.test(text);
  text = text.replace(/\s*\[(ZALO|FORM)\]\s*/gi, ' ').replace(/\*\*/g, '').trim();
  return { text: text, action: zalo ? 'zalo' : (form ? 'form' : '') };
}

// ---------- Điều khiển chat AI từ Telegram ----------
//  /aikey sk-ant-...  lưu khoá (chỉ trong chat riêng với bot)   /ai  trạng thái   /ai tat · /ai bat  tắt/bật
function aiCommand_(chatId, msg) {
  const props = PropertiesService.getScriptProperties();
  const say = function (text) { tg_('sendMessage', { chat_id: chatId, text: text }); };
  const t = msg.text.trim();
  if (/^\/aikey/i.test(t)) {
    tg_('deleteMessage', { chat_id: chatId, message_id: msg.message_id }); // không để khoá nằm lại trong Telegram
    if (msg.chat.type !== 'private') return say('⚠️ Vì an toàn, chỉ gửi khoá trong chat RIÊNG với bot (không gửi trong nhóm). Nên xoá khoá này trên platform.claude.com và tạo khoá mới.');
    const key = (t.match(/^\/aikey(?:@\w+)?\s+(\S+)/i) || [])[1] || '';
    if (!/^sk-ant-/.test(key)) return say('Gửi theo dạng:\n/aikey sk-ant-...\n(khoá lấy ở platform.claude.com → Settings → API keys)');
    const r = UrlFetchApp.fetch('https://api.anthropic.com/v1/models?limit=1', {
      headers: { 'x-api-key': key, 'anthropic-version': '2023-06-01' }, muteHttpExceptions: true,
    });
    if (r.getResponseCode() !== 200) return say('❌ Khoá không dùng được (mã lỗi ' + r.getResponseCode() + '). Kiểm tra lại trên platform.claude.com rồi gửi lại.');
    props.setProperty('ANTHROPIC_API_KEY', key);
    props.deleteProperty('AI_OFF');
    return say('✅ Đã lưu khoá …' + key.slice(-4) + ', chat AI đã BẬT. Tin chứa khoá đã được xoá khỏi Telegram.\nNhớ nạp tiền (Settings → Billing) để AI trả lời được. Gõ /ai để xem trạng thái.');
  }
  const arg = ((t.match(/^\/ai(?:@\w+)?\s+(\S+)/i) || [])[1] || '').toLowerCase();
  if (/^(tat|tắt|off)$/.test(arg)) { props.setProperty('AI_OFF', '1'); return say('⏸ Đã TẮT chat AI. Khung chat dùng kịch bản soạn sẵn. Gõ /ai bat để bật lại.'); }
  if (/^(bat|bật|on)$/.test(arg)) {
    if (!props.getProperty('ANTHROPIC_API_KEY')) return say('Chưa có khoá. Nhắn riêng cho bot: /aikey sk-ant-...');
    props.deleteProperty('AI_OFF'); return say('▶️ Đã BẬT chat AI.');
  }
  const key = props.getProperty('ANTHROPIC_API_KEY');
  const day = Utilities.formatDate(new Date(), 'Asia/Ho_Chi_Minh', 'yyyyMMdd');
  const used = Number(CacheService.getScriptCache().get('ai_' + day) || 0);
  say('🧠 CHAT AI: ' + (!key ? 'chưa có khoá' : props.getProperty('AI_OFF') ? 'đang TẮT' : 'đang BẬT') +
    (key ? '\nKhoá: …' + key.slice(-4) : '') + '\nHôm nay đã trả lời: ' + used + '/' + AI_DAILY_LIMIT + ' câu' +
    '\n\nLệnh: /ai tat · /ai bat · /aikey sk-ant-... (gửi riêng cho bot)');
}
