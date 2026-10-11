// Chạy: node crm/test/ui.test.mjs — mở Index.html bằng Chromium, google.script.run nối tới Code.gs giả lập.
import { createRequire } from 'node:module';
import { readFileSync } from 'node:fs';
import assert from 'node:assert/strict';
import { loadGas } from './gasmock.mjs';
const require = createRequire('/node-tools/node_modules/');
let chromium; try { ({ chromium } = require('playwright')); } catch { ({ chromium } = require('/root/node-tools/node_modules/playwright')); }
const { api, g } = loadGas({});
api.setupCRM();
const pw = g.logs.find(l => l.includes('Mật khẩu')).match(/CRM: (\w+)/)[1];
api.doPost({ parameter: { name: 'Lan Anh', phone: '0905111222', project: 'FPT Plaza 4', need: 'Căn 2PN · 2 – 3 tỷ' } });
const html = readFileSync(new URL('../Index.html', import.meta.url), 'utf8').replace('<head>', `<head><script>
window.google={script:{run:new Proxy({},{get:(_,fn)=>{ if(fn==='withSuccessHandler'||fn==='withFailureHandler') return undefined;
 const mk=(ok,bad)=>new Proxy({},{get:(_,f)=>f==='withSuccessHandler'?(o)=>mk(o,bad):f==='withFailureHandler'?(b)=>mk(ok,b):(...a)=>window.__call(f,JSON.stringify(a)).then(r=>{const v=JSON.parse(r);v.err?bad&&bad(new Error(v.err)):ok&&ok(v.ok)})});
 return undefined}}) }};
window.google.script.run=(function(){const mk=(ok,bad)=>new Proxy({},{get:(_,f)=>f==='withSuccessHandler'?(o)=>mk(o,bad):f==='withFailureHandler'?(b)=>mk(ok,b):(...a)=>window.__call(f,JSON.stringify(a)).then(r=>{const v=JSON.parse(r);v.err?bad&&bad(new Error(v.err)):ok&&ok(v.ok)})});return mk()})();
</script>`);
const exe = '/opt/pw-browsers/chromium_headless_shell-1194/chrome-linux/headless_shell';
const browser = await chromium.launch({ executablePath: exe });
const page = await browser.newPage({ viewport: { width: 1200, height: 900 } });
const errs = []; page.on('pageerror', e => errs.push(e.message));
await page.exposeFunction('__call', (f, args) => { try { return JSON.stringify({ ok: api[f](...JSON.parse(args)) ?? null }); } catch (e) { return JSON.stringify({ err: e.message }); } });
await page.route('**/*', r => r.request().url().startsWith('http://crm.test/') ? r.fulfill({ contentType: 'text/html', body: html }) : r.abort());
await page.goto('http://crm.test/');
await page.fill('input[name=p]', pw); await page.click('#loginForm button[type=submit]');
await page.waitForSelector('#app:not([hidden])');
// việc hôm nay có phương án
await page.waitForSelector('.task .offs');
assert.match(await page.textContent('.task .offs'), /FPT Plaza 4 – 2 PN/);
// drawer: phương án + copy
await page.click('.task [data-open]');
await page.waitForSelector('#dOffers:not([hidden]) .offer');
assert.equal(await page.inputValue('#dBudget'), '2 – 3 tỷ');
assert.match(await page.textContent('#dOffers'), /chưa có giá/);
// sản phẩm: sửa giá
await page.click('#dCancel');
await page.click('.nav-btn[data-view=prods]');
assert.ok((await page.$$('#prodRows tr')).length >= 20);
await page.screenshot({ path: '/tmp/crm-prods.png' });
await page.click('#prodRows tr:has-text("2 PN") >> nth=0');
await page.fill('#prodForm [name=price1]', '2,5'); await page.fill('#prodForm [name=price2]', '3');
await page.click('#prodForm button[type=submit]');
await page.waitForSelector('#prodModal:not([open])', { state: 'attached' });
await page.waitForFunction(() => document.querySelector('#prodRows').textContent.includes('2,5–3'));
// quay lại: có giá trong phương án
await page.click('.nav-btn[data-view=today]');
await page.waitForSelector('.task .offs');
assert.match(await page.textContent('.task .offs'), /2,5–3/);
await page.screenshot({ path: '/tmp/crm-ui.png' });
assert.deepEqual(errs, []);
await browser.close();
console.log('UI TEST PASSED ✔');
