const {chromium}=require('playwright');const ds=require('./ds.json');(async()=>{const b=await chromium.launch();const p=await b.newPage({viewport:{width:1080,height:1350}});
for(const n of ds){await p.goto('file://'+__dirname+'/'+n+'.html',{waitUntil:'networkidle'});await p.evaluate(()=>document.fonts.ready);await p.waitForTimeout(200);await p.screenshot({path:__dirname+'/'+n+'.jpg',type:'jpeg',quality:90});}
await b.close();})();
