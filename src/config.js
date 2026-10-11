import fs from 'node:fs';
import path from 'node:path';
import crypto from 'node:crypto';

// Đọc file .env đơn giản (không cần thư viện dotenv)
const envFile = path.resolve(process.cwd(), '.env');
if (fs.existsSync(envFile)) {
  for (const line of fs.readFileSync(envFile, 'utf8').split(/\r?\n/)) {
    const m = line.match(/^\s*([A-Z0-9_]+)\s*=\s*(.*)\s*$/);
    if (m && process.env[m[1]] === undefined) {
      process.env[m[1]] = m[2].replace(/^["']|["']$/g, '');
    }
  }
}

process.env.TZ = process.env.TZ || 'Asia/Ho_Chi_Minh';

export const config = {
  port: Number(process.env.PORT || 3000),
  dbPath: process.env.DB_PATH || path.resolve(process.cwd(), 'data', 'crm.db'),
  adminPassword: process.env.ADMIN_PASSWORD || '',
  sessionSecret: process.env.SESSION_SECRET || crypto.randomBytes(32).toString('hex'),
  // Nếu để trống, key sẽ được tự sinh và lưu trong DB (xem trang Cài đặt)
  webhookKey: process.env.WEBHOOK_KEY || '',
  publicUrl: (process.env.PUBLIC_URL || '').replace(/\/$/, ''),
  telegramToken: process.env.TELEGRAM_BOT_TOKEN || '',
  telegramChatId: process.env.TELEGRAM_CHAT_ID || '',
  anthropicModel: process.env.ANTHROPIC_MODEL || 'claude-opus-5-5',
};
