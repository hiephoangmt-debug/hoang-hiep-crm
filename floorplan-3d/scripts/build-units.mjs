// Dựng sẵn các căn mẫu: node scripts/build-units.mjs (cần `npx vite` đang chạy ở cổng 5173 và Playwright)
// Ảnh nguồn: public/units/<id>.webp  →  kết quả: src/units/units.json
import fs from 'fs';
const PW = process.env.PLAYWRIGHT_MODULE || 'playwright';
const { chromium } = await import(PW);
const browser = await chromium.launch();
const page = await browser.newPage();
page.on('console', (m) => console.log('[trình duyệt]', m.text()));
await page.goto('http://localhost:5173/package.json', { waitUntil: 'domcontentloaded' });
const units = await page.evaluate(async () => {
  const { buildUnit, gardenUnit, UNIT_SPECS } = await import('/scripts/build-units.js');
  const out = [];
  for (const s of UNIT_SPECS) out.push(s.garden ? gardenUnit(out.find((u) => u.id === s.garden.base), s) : await buildUnit(s, `/units/${s.id}.webp`));
  return out;
});
fs.mkdirSync('src/units', { recursive: true });
fs.writeFileSync('src/units/units.json', JSON.stringify(units));
for (const u of units) console.log(u.id, u.plan.walls.length, 'tường', u.plan.openings.length, 'cửa', u.plan.rooms.map((r) => r.name).join(' | '), u.area + ' m²');
await browser.close();
