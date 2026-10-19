const { chromium } = require('/opt/node-tools/node_modules/playwright');
(async()=>{const b=await chromium.launch();const ctx=await b.newContext();const sent=[],errs=[];
await ctx.route('**/*',r=>{const u=r.request().url(); if(/script\.google|formsubmit/.test(u)){sent.push(u);return r.fulfill({status:200,body:'ok'});} return u.startsWith('file:')?r.continue():r.abort();});
const p=await ctx.newPage(); p.on('pageerror',e=>errs.push(e.message));
await p.goto('file://'+process.cwd()+'/ladi.html'); await p.fill('[name=name]','Lan'); await p.fill('[name=phone]','0123'); await p.click('#BUTTON1'); await p.waitForTimeout(300);
console.log('số sai -> gửi:',sent.length,'(cần 0); LadiPage vẫn chạy:',await p.evaluate(()=>ladiSubmits));
await p.fill('[name=phone]','0935 111 222'); await p.click('#BUTTON1'); await p.evaluate(()=>document.getElementById('lf').requestSubmit()); await p.waitForTimeout(400);
console.log('số đúng -> gửi:',sent.length,'(cần 3)', 'LadiPage xử lý:',await p.evaluate(()=>ladiSubmits),'(cần 3)','cảm ơn:',await p.evaluate(()=>[...document.querySelectorAll('div')].some(d=>/Cảm ơn Lan/.test(d.textContent))),'lỗi JS:',errs.length);
await b.close();})();
