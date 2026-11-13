// Xuất ảnh quảng cáo từ ads/creatives.html → ads/out/*.png
//   node ads/render-ads.js
// Cần Playwright (playwright-core) và Chromium.
const path = require('path');
const fs = require('fs');

let chromium;
try { ({ chromium } = require('playwright-core')); } catch { ({ chromium } = require('playwright')); }

(async () => {
  const out = path.join(__dirname, 'out');
  fs.mkdirSync(out, { recursive: true });
  const browser = await chromium.launch({ executablePath: process.env.CHROMIUM_PATH || undefined });
  const page = await browser.newPage({ viewport: { width: 1200, height: 2000 } });
  await page.goto('file://' + path.join(__dirname, 'creatives.html'));
  await page.evaluate(() => document.fonts.ready);
  await page.waitForTimeout(500);
  const ids = await page.$$eval('.ad', els => els.map(e => e.id));
  for (const id of ids) {
    const file = path.join(out, `casamia-${id}.png`);
    await page.locator('#' + id).screenshot({ path: file });
    console.log('Đã xuất', path.relative(process.cwd(), file));
  }
  await browser.close();
})();
