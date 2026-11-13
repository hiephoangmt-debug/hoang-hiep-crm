// Chat AI (Claude) cho server: trả lời câu khách tự gõ khi chưa có tư vấn viên trực tuyến.
// Bật bằng biến môi trường ANTHROPIC_API_KEY. Không có khoá, lỗi hoặc bị từ chối → trả null để dùng kịch bản soạn sẵn.
const Anthropic = require('@anthropic-ai/sdk');
const config = require('./config');
const { systemPrompt } = require('./ai/prompt');

const MODEL = process.env.AI_MODEL || 'claude-opus-5-5';
const DAILY_LIMIT = Number(process.env.AI_DAILY_LIMIT) || 400;
const PER_VISITOR = 25;
const enabled = !!process.env.ANTHROPIC_API_KEY;
const client = enabled ? new Anthropic({ timeout: 30000, maxRetries: 1 }) : null;
const SYSTEM = systemPrompt(config.project);

let day = '', used = 0;
const perVisitor = new Map();
function allow(id) {
  const today = new Date().toISOString().slice(0, 10);
  if (today !== day) { day = today; used = 0; perVisitor.clear(); }
  if (used >= DAILY_LIMIT || (perVisitor.get(id) || 0) >= PER_VISITOR) return false;
  used++; perVisitor.set(id, (perVisitor.get(id) || 0) + 1);
  return true;
}

// Hội thoại → tin nhắn cho Claude: khách = user, tư vấn/bot = assistant, xen kẽ, bắt đầu và kết thúc bằng user.
function toMessages(messages, hasPhone) {
  const out = [];
  for (const m of messages.filter(m => m.from !== 'system').slice(-14)) {
    const role = m.from === 'visitor' ? 'user' : 'assistant';
    const text = String(m.text || '').slice(0, 1000);
    const last = out[out.length - 1];
    if (last && last.role === role) last.content += '\n' + text;
    else out.push({ role, content: text });
  }
  if (!out.length || out[out.length - 1].role !== 'user') return null;
  if (out[0].role === 'assistant') out.unshift({ role: 'user', content: '(Khách mở khung chat)' });
  if (hasPhone) out[out.length - 1].content += '\n\n[Ghi chú hệ thống: khách đã để lại số điện thoại, không xin lại.]';
  return out;
}

async function reply(conv) {
  if (!enabled || !allow(conv.id)) return null;
  const messages = toMessages(conv.messages || [], !!conv.lead?.phone);
  if (!messages) return null;
  try {
    const res = await client.beta.messages.create({
      model: MODEL,
      max_tokens: 4000,
      output_config: { effort: 'low' },
      betas: ['server-side-fallback-2026-07-01'],
      fallbacks: 'default',
      system: [{ type: 'text', text: SYSTEM, cache_control: { type: 'ephemeral' } }],
      messages,
    });
    if (res.stop_reason === 'refusal') return null;
    let text = res.content.filter(b => b.type === 'text').map(b => b.text).join('').trim();
    if (!text) return null;
    const action = /\[ZALO\]/i.test(text) ? 'zalo' : /\[FORM\]/i.test(text) ? 'form' : '';
    text = text.replace(/\s*\[(ZALO|FORM)\]\s*/gi, ' ').replace(/\*\*/g, '').trim();
    return { text, action };
  } catch (err) {
    if (err instanceof Anthropic.APIError) console.warn(`[AI] Lỗi API ${err.status}: ${err.message}`);
    else console.warn('[AI]', err.message);
    return null;
  }
}

module.exports = { enabled, reply, toMessages };
