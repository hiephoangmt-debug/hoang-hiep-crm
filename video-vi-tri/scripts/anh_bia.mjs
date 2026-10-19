import http from 'node:http'; import fs from 'node:fs'; import path from 'node:path'; import { chromium } from 'playwright-core';
const ROOT = path.resolve('public'); const T={'.html':'text/html; charset=utf-8','.css':'text/css','.woff2':'font/woff2','.jpg':'image/jpeg'};
const s=http.createServer((q,r)=>{const p=path.join(ROOT,decodeURIComponent(q.url.split('?')[0])); if(!fs.existsSync(p)){r.writeHead(404);return r.end();} r.writeHead(200,{'Content-Type':T[path.extname(p)]||'application/octet-stream'}); fs.createReadStream(p).pipe(r);}).listen(0);
const b=await chromium.launch({executablePath:'/opt/pw-browsers/chromium-1194/chrome-linux/chrome'}); const pg=await b.newPage({viewport:{width:1080,height:1920}});
await pg.goto(`http://localhost:${s.address().port}/cover.html`); await pg.evaluate(()=>document.fonts.ready); await pg.waitForTimeout(300);
await (await pg.$('#c')).screenshot({path:'out/TikTok_cover_SunSaphia.jpg',type:'jpeg',quality:92}); await b.close(); s.close();
