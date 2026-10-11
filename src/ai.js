import { config } from './config.js';
import { STATUS_LABEL } from './reminders.js';

// Gợi ý bằng AI (tuỳ chọn): chỉ bật khi có ANTHROPIC_API_KEY và đã cài @anthropic-ai/sdk
let clientPromise = null;
async function getClient() {
  if (!process.env.ANTHROPIC_API_KEY) return null;
  if (!clientPromise) {
    clientPromise = import('@anthropic-ai/sdk')
      .then(({ default: Anthropic }) => new Anthropic())
      .catch(() => null);
  }
  return clientPromise;
}

export async function aiAvailable() {
  return Boolean(await getClient());
}

const SYSTEM = `Bạn là trợ lý cho một chuyên viên môi giới bất động sản ở Việt Nam.
Nhiệm vụ: gợi ý cách mở lời / câu hỏi / tin nhắn Zalo để gọi hoặc nhắn cho một khách hàng cụ thể.
Yêu cầu:
- Viết tiếng Việt tự nhiên, lịch sự, xưng "em" và gọi khách theo cách xưng hô được cung cấp.
- Dựa vào lịch sử: khách đăng ký trên trang nào, nhu cầu gì, lần liên hệ trước nói gì, ghi chú cá nhân.
- Không bịa giá, chính sách hay thông tin dự án không có trong dữ liệu.
- Đưa ra 3 gợi ý ngắn (mỗi gợi ý 1–3 câu), đánh số, mỗi gợi ý có một dòng tiêu đề ngắn in đậm, cuối cùng là 1 câu hỏi khai thác nên hỏi tiếp.`;

export async function aiSuggest({ customer, inquiries, activities, settings, goal }) {
  const client = await getClient();
  if (!client) {
    const err = new Error('Chưa bật AI: cần đặt ANTHROPIC_API_KEY và chạy "npm install".');
    err.status = 400;
    throw err;
  }
  const lines = [
    `Tên sale: ${settings.sales_name} – công ty ${settings.company}`,
    `Khách: ${customer.name || '(chưa rõ tên)'}; xưng hô: ${customer.salutation || 'anh/chị'}`,
    `Trạng thái: ${STATUS_LABEL[customer.status] || customer.status}; mức độ: ${customer.temperature}`,
    `Nhu cầu: loại ${customer.need_type || '?'}, mục đích ${customer.need_purpose || '?'}, khu vực ${customer.need_area || '?'}, ngân sách ${customer.budget_min ?? '?'}–${customer.budget_max ?? '?'} tỷ, thời điểm ${customer.need_timeline || '?'}`,
    `Ghi chú nhu cầu: ${customer.need_note || ''}`,
    `Ghi chú cá nhân: ${customer.personal_note || ''}`,
    `Lần liên hệ gần nhất: ${customer.last_contact_at || 'chưa liên hệ'}`,
    '',
    'Các lần đăng ký trên web (mới nhất trước):',
    ...inquiries.slice(0, 5).map((i) => `- ${i.created_at} | ${i.source} | ${i.page_url || ''} | dự án: ${i.project || ''} | lời nhắn: ${(i.message || '').slice(0, 300)}`),
    '',
    'Lịch sử chăm sóc (mới nhất trước):',
    ...activities.slice(0, 8).map((a) => `- ${a.created_at} | ${a.type} | ${a.outcome || ''} | ${(a.content || '').slice(0, 300)}`),
    '',
    `Mục tiêu lần liên hệ này: ${goal || 'tự chọn mục tiêu phù hợp nhất với tình trạng khách'}`,
  ];

  const response = await client.beta.messages.create({
    model: config.anthropicModel,
    max_tokens: 4000,
    output_config: { effort: 'low' },
    betas: ['server-side-fallback-2026-07-01'],
    fallbacks: 'default',
    system: SYSTEM,
    messages: [{ role: 'user', content: lines.join('\n') }],
  });
  if (response.stop_reason === 'refusal') {
    const err = new Error('AI từ chối yêu cầu này, hãy dùng kịch bản có sẵn.');
    err.status = 422;
    throw err;
  }
  return response.content.filter((b) => b.type === 'text').map((b) => b.text).join('\n').trim();
}
