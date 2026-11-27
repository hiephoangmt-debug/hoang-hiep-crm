const { chromium } = require('playwright');
const fs = require('fs');
(async () => {
  const [,, outDir, fps, from, to] = process.argv;
  const b = await chromium.launch();
  const p = await b.newPage({ viewport: { width: 1080, height: 1920 }, deviceScaleFactor: 1 });
  p.on('pageerror', e => console.error('PAGEERR', e.message));
  await p.goto('file://' + __dirname + '/anim.html');
  await p.waitForFunction('window.READY===true');
  await p.evaluate(async () => { await document.fonts.ready; await Promise.all([...document.querySelectorAll('.bg')].map(d => new Promise(r => { const i = new Image(); i.onload = i.onerror = r; i.src = d.style.backgroundImage.slice(5, -2); }))); });
  const total = await p.evaluate('window.TOTAL');
  fs.mkdirSync(outDir, { recursive: true });
  const F = +fps, n = Math.ceil(total * F);
  const a = from ? +from : 0, z = to ? Math.min(+to, n) : n;
  for (let i = a; i < z; i++) {
    await p.evaluate(t => window.render(t), i / F);
    await p.screenshot({ path: `${outDir}/${String(i).padStart(5, '0')}.jpg`, type: 'jpeg', quality: 88 });
  }
  console.log('total', total, 'frames', n);
  await b.close();
})();
