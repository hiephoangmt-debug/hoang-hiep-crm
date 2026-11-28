const { chromium } = require('playwright');
const fs = require('fs');
(async () => {
  const [,, outDir, fps, from, to] = process.argv;
  const b = await chromium.launch({ args: ['--allow-file-access-from-files'] });
  const p = await b.newPage({ viewport: { width: 1080, height: 1920 }, deviceScaleFactor: 1 });
  p.on('pageerror', e => console.error('PAGEERR', e.message));
  p.on('console', m => { if (m.type() === 'error') console.error('CONSOLE', m.text()); });
  await p.goto('file://' + __dirname + '/han2.html');
  await p.waitForFunction('window.READY===true');
  await p.evaluate(() => document.fonts.ready);
  const total = await p.evaluate('window.TOTAL');
  fs.mkdirSync(outDir, { recursive: true });
  const F = +fps, n = Math.ceil(total * F), a = from ? +from : 0, z = to ? Math.min(+to, n) : n;
  for (let i = a; i < z; i++) {
    await p.evaluate(t => window.render(t), i / F);
    await p.screenshot({ path: `${outDir}/${String(i).padStart(5, '0')}.jpg`, type: 'jpeg', quality: 90 });
  }
  console.log('frames', n);
  await b.close();
})();
