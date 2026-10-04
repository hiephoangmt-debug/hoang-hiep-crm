// Xuất landing page thành 1 file HTML duy nhất (ảnh nhúng sẵn) để xem thử hoặc gửi cho người khác.
//   node tools/export-landing.js                 → bản xem thử (form mô phỏng, không gửi đi)
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
  .replace("const API_BASE = '';", `const API_BASE = ${JSON.stringify(api)};`)
  .replace(/<script src="\/widget\.js"/, api ? `<script src="${api}/widget.js"` : '<!-- khung chat cần server --><script data-src="/widget.js"');

const out = path.join(__dirname, '..', 'dist', api ? 'casamia-balanca-landing.html' : 'casamia-balanca-landing-xem-thu.html');
fs.mkdirSync(path.dirname(out), { recursive: true });
fs.writeFileSync(out, html);
console.log(`Đã xuất: ${out} (${(fs.statSync(out).size / 1024).toFixed(0)} KB)`);
