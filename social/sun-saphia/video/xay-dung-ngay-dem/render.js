/* Dựng khung hình: node render.js <thư-mục-ra> <từ-khung> <đến-khung> [w h]   (30 hình/giây) */
const { chromium } = require('playwright'); const cp = require('child_process'); const fs = require('fs'); const path = require('path');
const ROOT = path.resolve(__dirname, '../../../..');
const THREE_DIR = process.env.THREE_DIR;   // gói three@0.128 (build/three.min.js, examples/js/controls/OrbitControls.js)
const [out, f0, f1, W = 1080, H = 1920] = process.argv.slice(2); fs.mkdirSync(out, { recursive: true });
const OPT = JSON.parse(fs.readFileSync(path.join(__dirname, 'opt.json'), 'utf8'));
(async () => {
  const b = await chromium.launch({ args: ['--use-gl=swiftshader', '--enable-webgl', '--ignore-gpu-blocklist'] });
  const p = await b.newPage({ viewport: { width: +W, height: +H } });
  p.on('pageerror', e => console.error('pageerror', e.message));
  await p.addInitScript(() => { const r = window.requestAnimationFrame.bind(window); window.requestAnimationFrame = f => window.__noRAF ? 0 : r(f); });
  await p.route(/three\.min\.js|OrbitControls\.js/, r => r.fulfill({ status: 200, contentType: 'application/javascript', body: fs.readFileSync(/Orbit/.test(r.request().url()) ? THREE_DIR + '/examples/js/controls/OrbitControls.js' : THREE_DIR + '/build/three.min.js') }));
  await p.route(/hoang-hiep-crm[@\/][0-9a-f]{40}\//, r => { const m = /hoang-hiep-crm[@\/]([0-9a-f]{40})\/([^?]+)/.exec(r.request().url());
    try { return r.fulfill({ status: 200, body: cp.execFileSync('git', ['-C', ROOT, 'show', m[1] + ':' + decodeURIComponent(m[2])], { maxBuffer: 1e8 }), headers: { 'access-control-allow-origin': '*' } }); } catch (e) { return r.fulfill({ status: 404, body: '' }); } });
  await p.route(/fonts\.|githack|zalo/, r => r.fulfill({ status: 200, body: '' }));
  /* cài scene.js vào bên trong hàm chính của trang mô hình (biến của mô hình nằm trong hàm đóng) */
  let html = fs.readFileSync(ROOT + '/projects/sun-saphia/4d/sun-saphia-4d.html', 'utf8');
  const a = html.indexOf('<script>\n(function(){'), e = html.indexOf('</script>', a), k = html.lastIndexOf('})();', e);
  html = html.slice(0, k) + 'window.__XD_INIT=function(){' + fs.readFileSync(path.join(__dirname, 'scene.js'), 'utf8') + '};\n' + html.slice(k);
  const tmp = path.join(out, '_mo-hinh.html'); fs.writeFileSync(tmp, html);
  await p.goto('file://' + tmp, { waitUntil: 'load' });
  await p.waitForFunction(() => window.__XD_INIT, null, { timeout: 60000 });
  await p.waitForTimeout(3000);
  await p.evaluate(() => window.__XD_INIT());
  const LIST = process.env.FRAMES ? process.env.FRAMES.split(',').map(Number) : Array.from({ length: +f1 - +f0 }, (_, k) => +f0 + k);
  for (const i of LIST) {
    const d = await p.evaluate(([t, o]) => XD.frame(t, o), [i / 30, OPT]);
    fs.writeFileSync(path.join(out, 'f' + String(i).padStart(5, '0') + '.jpg'), Buffer.from(d.split(',')[1], 'base64'));
  }
  await b.close();
})();
