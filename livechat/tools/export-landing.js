// Xuất landing page thành 1 file HTML duy nhất (ảnh nhúng sẵn) để xem thử hoặc gửi cho người khác.
//   node tools/export-landing.js                 → bản xem thử (form mô phỏng, chat tự động chạy trên trình duyệt)
//   node tools/export-landing.js https://chat.x  → bản thật, form và khung chat gửi về server chat đó
const fs = require('fs');
const path = require('path');
const config = require('../config');

const api = (process.argv[2] || '').replace(/\/$/, '');
const pub = path.join(__dirname, '..', 'public');
let html = fs.readFileSync(path.join(pub, 'landing.html'), 'utf8');

// Nhúng ảnh dạng data URI
html = html.replace(/'img\/([\w.-]+\.(?:jpe?g|png|webp))'/g, (m, f) => {
  if (!fs.existsSync(path.join(pub, 'img', f))) return m;
  const ext = path.extname(f).slice(1).replace('jpg', 'jpeg');
  return `'data:image/${ext};base64,${fs.readFileSync(path.join(pub, 'img', f)).toString('base64')}'`;
});

const { hotline, zalo } = config.project;
html = html
  .replace("const PREVIEW = false;", `const PREVIEW = ${api ? 'false' : 'true'};`)
  .replace("const FALLBACK_CONTACT = { hotline: '0904 567 009', zalo: '0904567009' };", `const FALLBACK_CONTACT = ${JSON.stringify({ hotline, zalo })};`)
  .replace("const API_BASE = '';", `const API_BASE = ${JSON.stringify(api)};`);

// Kịch bản chat cho chế độ cục bộ: chat tự chạy trên trình duyệt khi không có server (hoặc server lỗi)
const chatCfg = {
  project: config.project,
  welcome: config.welcome,
  zaloTransfer: config.zaloTransfer,
  leadThanks: config.leadThanks,
  fallback: config.fallback,
  proactive: config.proactive,
  intents: config.intents.map(({ label, keywords, steps, browse }) => ({ label, keywords, steps, browse })),
};
const cfgTag = `<script>window.CASAMIA_CHAT_CONFIG = ${JSON.stringify(chatCfg).replace(/</g, '\\u003c')};</script>`;
const widgetTag = html.match(/<script src="\/widget\.js"([^>]*)><\/script>/);
if (!widgetTag) throw new Error('Không tìm thấy thẻ widget.js trong landing.html');
const attrs = widgetTag[1].replace(/\s*async/, '');
if (api) {
  // Bản thật: chat kết nối server, nếu server lỗi thì tự chuyển sang chế độ cục bộ
  html = html.replace(widgetTag[0], () => `${cfgTag}\n<script src="${api}/widget.js"${attrs} async></script>`);
} else {
  // Bản xem thử: nhúng thẳng widget, chạy chế độ cục bộ
  const widgetJs = fs.readFileSync(path.join(pub, 'widget.js'), 'utf8').replace(/<\/script/gi, '<\\/script');
  html = html.replace(widgetTag[0], () => `${cfgTag}\n<script${attrs} data-mode="local">\n${widgetJs}\n</script>`);
}

const out = path.join(__dirname, '..', 'dist', api ? 'casamia-balanca-landing.html' : 'casamia-balanca-landing-xem-thu.html');
fs.mkdirSync(path.dirname(out), { recursive: true });
fs.writeFileSync(out, html);
console.log(`Đã xuất: ${out} (${(fs.statSync(out).size / 1024).toFixed(0)} KB)`);
