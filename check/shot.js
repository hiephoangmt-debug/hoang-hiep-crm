const { chromium } = require('playwright');
(async()=>{const b=await chromium.launch();
for (const [w,h,n] of [[390,844,'mobile'],[1366,800,'desktop']]) {
 const p=await b.newPage({viewport:{width:w,height:h}}); const errs=[]; p.on('pageerror',e=>errs.push('JS: '+e.message)); p.on('console',m=>{if(m.type()==='error')errs.push('console: '+m.text())}); p.on('requestfailed',r=>errs.push('fail: '+r.url().slice(0,120)+' '+(r.failure()||{}).errorText));
 const res=await p.goto('https://www.sun-fours-tower.com/toa-f2-ads',{waitUntil:'load',timeout:60000}).catch(e=>{errs.push('goto: '+e.message);return null});
 await p.waitForTimeout(6000);
 console.log('==',n,'status',res&&res.status(),'title',await p.title().catch(()=>''),'height',await p.evaluate(()=>document.body.scrollHeight).catch(()=>0));
 console.log('text:',(await p.evaluate(()=>document.body.innerText.slice(0,300)).catch(()=>'')).replace(/\s+/g,' '));
 errs.slice(0,15).forEach(e=>console.log(e));
 await p.screenshot({path:'check/'+n+'.png'}); }
await b.close();})();
