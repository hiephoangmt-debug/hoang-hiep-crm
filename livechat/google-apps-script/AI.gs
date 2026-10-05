/**
 * CHAT AI THÔNG MINH (Claude) – tự trả lời khách khi tư vấn viên chưa vào.
 * Cài: Cài đặt dự án (bánh răng) → Thuộc tính tập lệnh → thêm ANTHROPIC_API_KEY = khoá API (sk-ant-...).
 * KHÔNG dán khoá vào code. Lời dặn và kiến thức dự án nằm trong KienThuc.gs.
 */
const AI_MODEL = 'claude-opus-5-5';
const AI_DAILY_LIMIT = 400;        // tối đa số câu AI trả lời mỗi ngày (giữ chi phí)
const AI_PER_VISITOR = 25;         // tối đa mỗi khách mỗi ngày

function aiReply_(b) {
  const key = PropertiesService.getScriptProperties().getProperty('ANTHROPIC_API_KEY');
  if (!key) return null;
  const cache = CacheService.getScriptCache();
  const day = Utilities.formatDate(new Date(), 'Asia/Ho_Chi_Minh', 'yyyyMMdd');
  const total = Number(cache.get('ai_' + day) || 0), mine = Number(cache.get('ai_' + day + b.v) || 0);
  if (total >= AI_DAILY_LIMIT || mine >= AI_PER_VISITOR) return null;
  cache.put('ai_' + day, String(total + 1), 21600 * 4);
  cache.put('ai_' + day + b.v, String(mine + 1), 21600 * 4);

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
