const { chromium } = require('/opt/node-tools/node_modules/playwright');
const P='/home/user/hoang-hiep-crm/landing/sun-saphia/chat/pages/';
const SHOT='/tmp/claude-0/-home-user-hoang-hiep-crm/5db8fba1-850e-5bd9-a987-e5055772d2de/scratchpad/t/';
let fails=0; const ok=(c,m)=>{console.log((c?'  ✅ ':'  ❌ ')+m); if(!c) fails++;};
async function setup(browser,opts={}){
  const ctx=await browser.newContext({viewport:opts.vp||{width:1280,height:900}, timezoneId:'Asia/Ho_Chi_Minh'});
  const sent=[]; const errs=[];
  await ctx.route('**/*', async r=>{ const u=r.request().url();
    if(/script\.google\.com|formsubmit\.co/.test(u)){ sent.push({u, body:r.request().postData()||''}); return r.fulfill({status:200,body:'ok'}); }
    if(u.startsWith('file:')) return r.continue();
    return r.abort(); });
  const page=await ctx.newPage();
  page.on('pageerror',e=>errs.push(e.message));
  page.on('console',m=>{ if(m.type()==='error' && !/net::ERR_FAILED|Failed to load resource/.test(m.text())) errs.push(m.text()); });
  if(opts.time) await page.clock.setFixedTime(new Date(opts.time));
  await page.goto('file://'+P+opts.file+(opts.q||''),{waitUntil:'domcontentloaded'});
  await page.waitForTimeout(400);
  return {ctx,page,sent,errs};
}
const kind=s=>/formsubmit/.test(s.u)?'MAIL':/AKfycbyChbG/.test(s.u)?'CRM':'TG';
const J=s=>{try{return JSON.parse(s.body)}catch(e){return {}}};
async function openChat(page){ const has=await page.$('#cb-fab'); if(has && await has.isVisible()) await has.click(); else await page.click('.hhc-l'); await page.waitForTimeout(1500); }
async function send(page,t){ await page.fill('.hhc-i input',t); await page.press('.hhc-i input','Enter'); await page.waitForTimeout(1700); return (await page.$$eval('.hhc-bot',e=>e.map(x=>x.innerText))).slice(-1)[0]||''; }

(async()=>{ const b=await chromium.launch();
 for(const file of ['ads.html','trang-chu.html','shaphia.html']){
  console.log('\n=== '+file+' – hội thoại ban ngày');
  const {ctx,page,sent,errs}=await setup(b,{file,q:'?utm_source=google&utm_campaign=ss-test&gclid=abc',time:'2026-10-19T10:00:00+07:00'});
  await openChat(page);
  const greet=(await page.$$eval('.hhc-bot',e=>e.map(x=>x.innerText)))[0]||''; ok(/trợ lý trả lời nhanh của anh Hoàng Hiệp/.test(greet),'chào: tự giới thiệu là trợ lý trả lời nhanh');
  const T=[
   ['giá bao nhiêu vậy em', r=>/chưa công bố/.test(r) && !/\d+([.,]\d+)?\s*(tỷ|ty)/i.test(r), 'hỏi giá: không nêu giá'],
   ['o dau vay', r=>/Võ Nguyên Giáp/.test(r), 'vị trí (không dấu)'],
   ['phap ly ntn, co sh ko', r=>/pháp lý/i.test(r)&&/chưa công bố/.test(r), 'pháp lý (viết tắt)'],
   ['cho thue dc bn 1 thang', r=>/8–9,5 triệu/.test(r)&&/muaban\.net/.test(r)&&/không (cam kết|phải cam kết)/.test(r), 'cho thuê: số liệu có nguồn, không cam kết'],
   ['đắt quá', r=>/hiểu|cân nhắc|vốn/.test(r), 'chê đắt'],
   ['co lua dao ko vay', r=>/không thu/.test(r), 'nghi lừa đảo'],
   ['em là máy trả lời à', r=>/không phải người thật|trợ lý trả lời nhanh/.test(r), 'hỏi có phải máy'],
   ['xyz qwe abc', r=>/chưa rõ|rõ hơn/.test(r), 'câu lạ lần 1: hỏi lại'],
   ['mnb vcx lkj', r=>/chuyển anh Hiệp/.test(r), 'câu lạ lần 2: chuyển anh Hiệp'],
   ['dm trả lời gì kỳ vậy', r=>/xin lỗi/.test(r), 'văng tục: xin lỗi, chuyển anh Hiệp'],
   ['cho tôi gặp người thật', r=>/báo anh Hiệp/.test(r), 'đòi người thật'],
   ['số tôi 091234', r=>/chưa đúng|gõ lại/.test(r), 'gõ sai số'],
   ['tên tôi là Minh, số 0905 123 456', r=>/0905123456/.test(r)&&/Minh/.test(r), 'gõ số: nhận ngay'],
   ['0905123456', r=>/đã có số/.test(r), 'gõ lại số: không gửi lần 2'],
  ];
  const replies=[];
  for(const [q,chk,label] of T){ const r=await send(page,q); replies.push(r); ok(chk(r), label+'  →  '+r.replace(/\n/g,' | ').slice(0,110)); }
  await page.waitForTimeout(500);
  const leads=sent.filter(s=>!J(s).thong_bao), tb=sent.filter(s=>J(s).thong_bao);
  const c=k=>leads.filter(s=>kind(s)===k).length;
  ok(c('TG')===1&&c('CRM')===1&&c('MAIL')===1, `gửi khách đúng 1 lần mỗi nơi (TG ${c('TG')}, CRM ${c('CRM')}, MAIL ${c('MAIL')})`);
  const chat=tb.filter(s=>/đang chat/.test(J(s).thong_bao)), hum=tb.filter(s=>/NGƯỜI THẬT/.test(J(s).yeu_cau||''));
  ok(chat.length===1,'báo "khách đang chat" 1 lần ('+chat.length+')'); ok(hum.length===1,'báo gấp "người thật" 1 lần ('+hum.length+')');
  const L=J(leads.find(s=>kind(s)==='TG')||{body:'{}'}), CR=J(leads.find(s=>kind(s)==='CRM')||{body:'{}'});
  ok(L.phone==='0905123456'&&L.name==='Minh','Telegram có tên + số');
  ok(L.utm_source==='google'&&L.utm_campaign==='ss-test'&&L.gclid==='abc','có nguồn utm/gclid');
  ok(/đắt quá/.test(L.hoi_thoai||'')&&/Trợ lý:/.test(L.hoi_thoai||''),'có toàn bộ nội dung chat');
  ok(/Pháp lý/.test(L.interest||'')&&/Giá/.test(L.interest||''),'có chủ đề quan tâm: '+L.interest);
  ok(CR.project==='Sun Saphia Residence'&&/^file:/.test(CR.url||''),'CRM có project + link trang');
  const M=(leads.find(s=>kind(s)==='MAIL')||{}).body||''; ok(/_subject=/.test(M)&&/0905123456/.test(M),'email có tiêu đề + số');
  ok(errs.length===0,'không lỗi JS'+(errs.length?': '+errs.join(' ; '):''));
  if(file==='ads.html') await page.screenshot({path:SHOT+'chat-desktop.png'});
  await ctx.close();

  console.log('=== '+file+' – gõ số rồi đóng trang ngay');
  { const s2=await setup(b,{file}); await openChat(s2.page); await s2.page.fill('.hhc-i input','0987654321'); await s2.page.press('.hhc-i input','Enter'); await s2.page.close({runBeforeUnload:true}); await new Promise(r=>setTimeout(r,800));
    const k=s2.sent.filter(s=>!J(s).thong_bao).map(kind).sort().join(','); ok(k==='CRM,MAIL,TG','vẫn gửi đủ 3 nơi khi đóng trang ('+k+')'); await s2.ctx.close(); }

  console.log('=== '+file+' – từng form');
  { const s3=await setup(b,{file}); const forms=await s3.page.$$('form:not(.hhc-i)'); let n=0;
    for(let i=0;i<forms.length;i++){ const f=forms[i]; if(!(await f.$('input[type=tel],[name=phone]'))) continue; n++;
      const before=s3.sent.length; const nm=await f.$('[name=name]'); if(nm) await nm.fill('Khách '+i);
      const tel=await f.$('input[type=tel],[name=phone]'); await tel.fill('12345'); await f.evaluate(x=>x.requestSubmit()); await s3.page.waitForTimeout(200);
      ok(s3.sent.length===before,'form '+(i+1)+': số sai không gửi');
      await tel.fill('09'+String(10000000+i*111111).slice(0,8)); await f.evaluate(x=>x.requestSubmit()); await s3.page.waitForTimeout(400);
      const got=s3.sent.slice(before).map(kind).sort().join(','); const thanks=await f.evaluate(x=>(x.querySelector('.hhc-ok')||{}).textContent||'');
      ok(got==='CRM,MAIL,TG'&&/Cảm ơn/.test(thanks),'form '+(i+1)+': gửi 3 nơi + cảm ơn tại form ('+got+')');
      ok(s3.page.url().startsWith('file://'+P+file),'form '+(i+1)+': không tải lại trang'); }
    // cùng số gửi lại form khác: không gửi lần 2
    if(forms.length>1){ const f=forms[forms.length-1]; const tel=await f.$('input[type=tel],[name=phone]'); if(tel){ const before=s3.sent.length; await f.evaluate(x=>{x.querySelector('[type=submit],button').disabled=false;}); await tel.fill('0910000000'); await f.evaluate(x=>x.requestSubmit()); await s3.page.waitForTimeout(300); ok(s3.sent.length===before,'cùng số gửi lại: không gửi lần 2'); } }
    ok(n>0,'số form có ô điện thoại: '+n); ok(s3.errs.length===0,'không lỗi JS'+(s3.errs.length?': '+s3.errs.join(' ; '):'')); await s3.ctx.close(); }
 }
 console.log('\n=== Sau 21h');
 { const s4=await setup(b,{file:'ads.html',time:'2026-10-19T22:15:00+07:00'}); await openChat(s4.page); const g=(await s4.page.$$eval('.hhc-bot',e=>e.map(x=>x.innerText)))[0]; ok(/8h sáng mai/.test(g),'chào có báo 8h sáng mai');
   const r=await send(s4.page,'0912 345 678'); ok(/8h sáng mai/.test(r),'nhận số có báo 8h sáng mai → '+r.replace(/\n/g,' | ')); await s4.ctx.close(); }
 console.log('\n=== Điện thoại 375px');
 for(const file of ['ads.html','shaphia.html']){ const s5=await setup(b,{file,vp:{width:375,height:812}}); await openChat(s5.page); await send(s5.page,'vị trí ở đâu'); const sw=await s5.page.evaluate(()=>document.documentElement.scrollWidth); ok(sw<=375,file+': không tràn ngang ('+sw+')'); await s5.page.screenshot({path:SHOT+'chat-'+file.replace('.html','')+'-375.png'}); await s5.ctx.close(); }
 console.log('\nTỔNG LỖI: '+fails); await b.close(); process.exit(fails?1:0);
})();
