// Xuất landing page thành 1 file HTML duy nhất (ảnh nhúng sẵn) để xem thử hoặc gửi cho người khác.
//   node tools/export-landing.js                 → bản xem thử (form mô phỏng, chat tự động chạy trên trình duyệt)
//   node tools/export-landing.js https://chat.x  → bản thật, form và khung chat gửi về server chat đó
//   node tools/export-landing.js --gas https://script.google.com/macros/s/…/exec
//                                                → bản thật miễn phí qua Google: lead vào Google Sheet, báo Telegram,
//                                                  thêm --ai để chat AI trả lời câu tự gõ (mặc định: chat kịch bản)
const fs = require('fs');
const path = require('path');
const config = require('../config');

// Tham số: [URL server chat] hoặc --gas <URL Apps Script /exec> (phương án miễn phí qua Google)
const argv = process.argv.slice(2);
const gi = argv.indexOf('--gas');
const gas = gi >= 0 ? (argv[gi + 1] || '') : '';
if (gi >= 0 && !/^https?:\/\/.+/.test(gas)) throw new Error('Thiếu URL sau --gas');
const api = (gi >= 0 || !/^https?:\/\//.test(argv[0] || '') ? '' : argv[0]).replace(/\/$/, '');
const pub = path.join(__dirname, '..', 'public');
let html = fs.readFileSync(path.join(pub, 'landing.html'), 'utf8');

// Ảnh: mặc định nhúng dạng data URI (1 file chạy mọi nơi).
// --img-base <URL>: dùng link ảnh trên CDN (khuyên dùng cho LadiPage, trang nhẹ, LadiPage giữ được ảnh).
const ib = process.argv.indexOf('--img-base');
const imgBase = ib >= 0 ? String(process.argv[ib + 1] || '').replace(/\/?$/, '/') : '';
html = html.replace(/(['"])img\/([\w.-]+\.(?:jpe?g|png|webp))\1/g, (m, q, f) => {
  if (!fs.existsSync(path.join(pub, 'img', f))) return m;
  if (imgBase) return q + imgBase + f + q;
  const ext = path.extname(f).slice(1).replace('jpg', 'jpeg');
  return `${q}data:image/${ext};base64,${fs.readFileSync(path.join(pub, 'img', f)).toString('base64')}${q}`;
});

const { hotline, zalo } = config.project;
html = html
  .replace("const PREVIEW = false;", `const PREVIEW = ${api || gas ? 'false' : 'true'};`)
  .replace("const GAS_URL = '';", `const GAS_URL = ${JSON.stringify(gas)};`)
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
  gas: gas || undefined,
  ai: gas && argv.includes('--ai') ? true : undefined, // chat AI qua Google (AI.gs): thêm --ai để bật; mặc định chat kịch bản
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
  // Bản Google / xem thử: dùng khung chat nằm sẵn trong trang (mục #hoi-ngay), không nhúng nút chat nổi
  // (nút nổi từng không hiện trên một số điện thoại; khung trong trang chạy cùng mã với form nên luôn hiện).
  html = html.replace(widgetTag[0], () => cfgTag);
}

const out = path.join(__dirname, '..', 'dist', api || gas ? 'casamia-balanca-landing.html' : 'casamia-balanca-landing-xem-thu.html');
fs.mkdirSync(path.dirname(out), { recursive: true });
fs.writeFileSync(out, html);
console.log(`Đã xuất: ${out} (${(fs.statSync(out).size / 1024).toFixed(0)} KB)`);
