// Cách dùng:
//   node render.mjs still out.jpg "cam=108.25,16.02,15,50,0"   -> chụp 1 góc camera bất kỳ
//   node render.mjs frames 0,120,300                           -> chụp các khung hình cụ thể vào out/frames
//   node render.mjs video out/video.mp4 [from] [to]             -> xuất video
import http from 'node:http';
import fs from 'node:fs';
import path from 'node:path';
import { spawn } from 'node:child_process';
import { chromium } from 'playwright-core';

const ROOT = path.resolve('public');
const TYPES = { '.html': 'text/html; charset=utf-8', '.js': 'text/javascript', '.css': 'text/css', '.json': 'application/json', '.geojson': 'application/json', '.woff2': 'font/woff2', '.png': 'image/png', '.jpg': 'image/jpeg' };
const server = http.createServer((req, res) => {
  const p = path.join(ROOT, decodeURIComponent(req.url.split('?')[0]));
  if (!p.startsWith(ROOT) || !fs.existsSync(p) || fs.statSync(p).isDirectory()) { res.writeHead(404); return res.end(); }
  res.writeHead(200, { 'Content-Type': TYPES[path.extname(p)] || 'application/octet-stream' });
  fs.createReadStream(p).pipe(res);
}).listen(0);
const port = server.address().port;

const [mode, out = 'out/x.jpg', a3, a4] = process.argv.slice(2);
const browser = await chromium.launch({
  executablePath: process.env.CHROME || '/opt/pw-browsers/chromium-1194/chrome-linux/chrome',
  args: ['--use-gl=angle', '--use-angle=swiftshader', '--enable-unsafe-swiftshader', '--ignore-gpu-blocklist', '--disable-dev-shm-usage'],
});
const page = await browser.newPage({ viewport: { width: 1080, height: 1920 }, deviceScaleFactor: 1 });
page.on('console', m => { if (m.type() === 'error' || m.type() === 'warning') console.log('[page]', m.text()); });
page.on('pageerror', e => console.log('[pageerror]', e.message));
const q = '?' + [mode === 'still' ? a3 : '', process.env.QS || ''].filter(Boolean).join('&');
await page.goto(`http://localhost:${port}/${process.env.MAIN || 'index.html'}${q}`);
await page.waitForFunction('window.READY === true', null, { timeout: 180000 });
const stage = await page.$('#stage');
fs.mkdirSync(path.dirname(out), { recursive: true });

if (mode === 'still') {
  await page.evaluate(() => window.renderFrame(0));
  await stage.screenshot({ path: out, type: 'jpeg', quality: 90 });
} else if (mode === 'frames') {
  fs.mkdirSync('out/frames', { recursive: true });
  for (const f of out.split(',').map(Number)) {
    await page.evaluate(async f => { for (let i = Math.max(0, f - 1); i <= f; i++) await window.renderFrame(i); }, f);
    await stage.screenshot({ path: `out/frames/f${String(f).padStart(4, '0')}.jpg`, type: 'jpeg', quality: 88 });
    console.log('frame', f);
  }
} else if (mode === 'video') {
  const total = await page.evaluate(() => window.TOTAL);
  const from = Number(a3 || 0), to = Number(a4 || total);
  const ff = spawn('ffmpeg', ['-y', '-loglevel', 'error', '-f', 'image2pipe', '-framerate', '30', '-c:v', 'mjpeg', '-i', '-',
    '-c:v', 'libx264', '-preset', 'slow', '-crf', '17', '-pix_fmt', 'yuv420p', '-movflags', '+faststart', out], { stdio: ['pipe', 'inherit', 'inherit'] });
  const t0 = Date.now();
  for (let f = from; f < to; f++) {
    await page.evaluate(f => window.renderFrame(f), f);
    const buf = await stage.screenshot({ type: 'jpeg', quality: 95 });
    if (!ff.stdin.write(buf)) await new Promise(r => ff.stdin.once('drain', r));
    if (f % 30 === 0) console.log(`frame ${f}/${to}  ${((Date.now() - t0) / 1000 / (f - from + 1)).toFixed(2)}s/frame`);
  }
  ff.stdin.end();
  await new Promise(r => ff.on('close', r));
  console.log('done', out, ((Date.now() - t0) / 1000).toFixed(0) + 's');
}
await browser.close();
server.close();
