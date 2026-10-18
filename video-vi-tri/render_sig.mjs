// Render lớp chữ ký trong suốt (sig.html) rồi ghép lên video chính.
//   node render_sig.mjs png 90,1720          -> out/sig_XXXX.png để xem thử
//   node render_sig.mjs mov out/sig.mov      -> lớp phủ có kênh trong suốt (1800 khung)
import http from 'node:http'; import fs from 'node:fs'; import path from 'node:path';
import { spawn } from 'node:child_process'; import { chromium } from 'playwright-core';
const ROOT = path.resolve('public');
const T = { '.html': 'text/html; charset=utf-8', '.css': 'text/css', '.woff2': 'font/woff2', '.png': 'image/png', '.js': 'text/javascript' };
const server = http.createServer((q, r) => { const p = path.join(ROOT, decodeURIComponent(q.url.split('?')[0]));
  if (!p.startsWith(ROOT) || !fs.existsSync(p)) { r.writeHead(404); return r.end(); }
  r.writeHead(200, { 'Content-Type': T[path.extname(p)] || 'application/octet-stream' }); fs.createReadStream(p).pipe(r); }).listen(0);
const [mode, arg] = process.argv.slice(2);
const browser = await chromium.launch({ executablePath: process.env.CHROME || '/opt/pw-browsers/chromium-1194/chrome-linux/chrome' });
const page = await browser.newPage({ viewport: { width: 1080, height: 1920 } });
await page.goto(`http://localhost:${server.address().port}/sig.html`);
await page.waitForFunction('window.READY === true');
const shot = () => page.screenshot({ type: 'png', omitBackground: true });
if (mode === 'png') {
  for (const f of arg.split(',').map(Number)) { await page.evaluate(f => window.renderSig(f), f); fs.writeFileSync(`out/sig_${String(f).padStart(4, '0')}.png`, await shot()); }
} else {
  const ff = spawn('ffmpeg', ['-y', '-loglevel', 'error', '-f', 'image2pipe', '-framerate', '30', '-c:v', 'png', '-i', '-', '-c:v', 'qtrle', '-pix_fmt', 'argb', arg], { stdio: ['pipe', 'inherit', 'inherit'] });
  for (let f = 0; f < 1800; f++) {
    await page.evaluate(f => window.renderSig(f), f);
    const b = await shot(); if (!ff.stdin.write(b)) await new Promise(r => ff.stdin.once('drain', r));
  }
  ff.stdin.end(); await new Promise(r => ff.on('close', r)); console.log('ok', arg);
}
await browser.close(); server.close();
