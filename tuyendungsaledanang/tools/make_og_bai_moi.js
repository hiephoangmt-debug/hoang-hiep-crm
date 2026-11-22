// Tạo ảnh og-<slug>.jpg 1200x630 cho các bài trong bai-src/. Chạy: node tools/make_og_bai_moi.js [slug ...]
const {chromium}=require('playwright');const fs=require('fs');const path=require('path');
const ROOT=path.dirname(__dirname);const IMG=path.join(ROOT,'img');
const b64=f=>'data:image/jpeg;base64,'+fs.readFileSync(path.join(IMG,f)).toString('base64');
const photo=b64('hoang-hiep-walk-wide.jpg');
const esc=s=>s.replace(/[&<>"]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]));
const extra=JSON.parse(fs.readFileSync(path.join(ROOT,'bai-src','og-extra.json'),'utf8'));
const all=fs.readdirSync(path.join(ROOT,'bai-src')).filter(f=>f.endsWith('.html')).map(f=>f.slice(0,-5)).concat(Object.keys(extra));
const slugs=process.argv.slice(2).length?process.argv.slice(2):all;
(async()=>{const br=await chromium.launch({executablePath:'/opt/pw-browsers/chromium'});
const p=await br.newPage({viewport:{width:1200,height:630}});
for(const s of slugs){
 const m=extra[s]||JSON.parse(fs.readFileSync(path.join(ROOT,'bai-src',s+'.html'),'utf8').match(/<!--META\s*(\{[\s\S]*?\})\s*META-->/)[1]);
 const h=`<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@600;700;800;900&display=swap" rel="stylesheet">
<style>*{margin:0;box-sizing:border-box}body{font-family:"Be Vietnam Pro",sans-serif}
.c{width:1200px;height:630px;background:linear-gradient(100deg,#13214f 0%,#1B2D6B 60%,#22388a 100%);position:relative;overflow:hidden;color:#fff}
.ph{position:absolute;right:0;top:0;height:630px;width:620px;object-fit:cover;object-position:62% 30%;-webkit-mask-image:linear-gradient(90deg,transparent 0%,#000 40%)}
.t{position:absolute;left:64px;top:64px;width:700px}
.tag{display:inline-block;background:#f47c20;font-weight:800;font-size:24px;padding:6px 18px;border-radius:999px}
h1{font-size:64px;line-height:1.1;font-weight:900;margin:26px 0 0;text-wrap:balance}
.f{position:absolute;left:64px;bottom:52px;font-size:26px;font-weight:700;color:#ffb37a}
.f b{color:#fff}</style>
<div class="c"><img class="ph" src="${photo}"><div class="t"><span class="tag">${esc(m.tag)}</span><h1>${esc(m.og_line)}</h1></div>
<div class="f"><b>Hoàng Hiệp</b> · tuyendungsaledanang.com</div></div>`;
 await p.setContent(h,{waitUntil:'networkidle'}).catch(()=>{});await p.waitForTimeout(400);
 await p.screenshot({path:path.join(IMG,'og-'+s+'.jpg'),type:'jpeg',quality:88});console.log('og',s);}
await br.close();})();
