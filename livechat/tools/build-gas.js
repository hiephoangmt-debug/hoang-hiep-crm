// Tạo lại các file Google Apps Script sau khi sửa code hoặc kiến thức AI:
//   npm run build-gas
//  - google-apps-script/KienThuc.gs : lời dặn + kiến thức dự án cho chat AI (từ ai/prompt.js + ai/kien-thuc.md)
//  - google-apps-script/chia-nho/   : Code.gs chia 3 phần ngắn để dán từng phần nếu dán cả file bị cắt
const fs = require('fs');
const path = require('path');
const config = require('../config');
const { systemPrompt } = require('../ai/prompt');

const dir = path.join(__dirname, '..', 'google-apps-script');
const prompt = systemPrompt(config.project).replace(/\\/g, '\\\\').replace(/`/g, '\\`').replace(/\$\{/g, '\\${');
fs.writeFileSync(path.join(dir, 'KienThuc.gs'),
  '// TỰ TẠO bằng "npm run build-gas" từ livechat/ai/kien-thuc.md và ai/prompt.js – sửa ở đó rồi chạy lại.\n' +
  '// Lời dặn + kiến thức dự án cho chat AI (AI.gs).\n' +
  'const AI_SYSTEM = `' + prompt + '`;\n');

const lines = fs.readFileSync(path.join(dir, 'Code.gs'), 'utf8').replace(/\n$/, '').split('\n');
const at = (mark) => { const i = lines.findIndex((l) => l.startsWith(mark)); if (i < 0) throw new Error('Không thấy ' + mark); return i; };
const cuts = [0, at('// ---------- Từ landing'), at('// ---------- Telegram'), lines.length];
const titles = ['Cấu hình + nhận dữ liệu', 'Xử lý tin nhắn & lead', 'Telegram + cài đặt'];
fs.mkdirSync(path.join(dir, 'chia-nho'), { recursive: true });
titles.forEach((t, i) => {
  const body = lines.slice(cuts[i], cuts[i + 1]);
  fs.writeFileSync(path.join(dir, 'chia-nho', `Phan${i + 1}.gs`), `// ===== PHẦN ${i + 1}/3: ${t} (dán vào file Phan${i + 1}.gs) =====\n` + body.join('\n') + '\n');
  console.log(`Phan${i + 1}.gs: ${body.length + 1} dòng`);
});
console.log('KienThuc.gs: ' + fs.readFileSync(path.join(dir, 'KienThuc.gs'), 'utf8').split('\n').length + ' dòng');
