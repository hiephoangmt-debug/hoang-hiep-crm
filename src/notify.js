import { config } from './config.js';

// Báo lead mới qua Telegram (tuỳ chọn) để gọi ngay trong 5 phút
export async function notifyNewLead({ customer, inquiry, isNew }, baseUrl) {
  if (!config.telegramToken || !config.telegramChatId) return;
  const link = baseUrl ? `\n👉 ${baseUrl}/#/customer/${customer.id}` : '';
  const text = [
    isNew ? '🔥 LEAD MỚI' : '🔁 Khách cũ đăng ký lại',
    `👤 ${customer.name || '(không tên)'} – 📞 ${customer.phone || customer.email}`,
    `🌐 ${inquiry.source}${inquiry.page_url ? `\n🔗 ${inquiry.page_url}` : ''}`,
    inquiry.project ? `🏢 ${inquiry.project}` : '',
    inquiry.message ? `💬 ${inquiry.message.slice(0, 400)}` : '',
  ].filter(Boolean).join('\n') + link;
  try {
    await fetch(`https://api.telegram.org/bot${config.telegramToken}/sendMessage`, {
      method: 'POST',
      headers: { 'content-type': 'application/json' },
      body: JSON.stringify({ chat_id: config.telegramChatId, text, disable_web_page_preview: true }),
      signal: AbortSignal.timeout(8000),
    });
  } catch (e) {
    console.error('Telegram lỗi:', e.message);
  }
}
