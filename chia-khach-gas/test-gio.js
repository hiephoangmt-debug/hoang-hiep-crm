const vm=require('vm'),fs=require('fs');
const code=fs.readFileSync(__dirname+'/ChiaKhach.gs','utf8').replace('TU_CHIA: 0,','TU_CHIA: 1,').replace("var BOT_TOKEN_DAN_VAO_DAY = 'DÁN_MÃ_BOT_CHIA_KHÁCH_VÀO_ĐÂY';","var BOT_TOKEN_DAN_VAO_DAY = 'TEST123';").replace("var LINK_SHEET_CRM_DAN_VAO_DAY = 'DÁN_LINK_SHEET_CRM_HOÀNG_HIỆP_VÀO_ĐÂY';","var LINK_SHEET_CRM_DAN_VAO_DAY = 'https://docs.google.com/spreadsheets/d/crm-id/edit#gid=0';");
let NOW=Date.UTC(2026,9,20,2,0); // 9:00 VN
const RD=Date; class FD extends RD{constructor(...a){a.length?super(...a):super(NOW)} static now(){return NOW}}
const gs=x=>typeof x==='string'&&x[0]==="'"?x.slice(1):(typeof x==='string'&&/^0\d{8,}$/.test(x)?Number(x):(typeof x==='string'&&/^\d+,\d+$/.test(x)?Number(x.replace(',','.')):x)); // giống Sheet tiếng Việt: "1,2" thành số // giống Google Sheet
function Sheet(name){this.name=name;this.d=[];}
Sheet.prototype={getLastRow(){return this.d.length},getLastColumn(){return Math.max(0,...this.d.map(r=>r.length))},
 setFrozenRows(){},hideSheet(){},deleteRow(r){this.d.splice(r-1,1)},
 appendRow(r){this.d.push(r.map(gs))},
 getRange(r,c,nr=1,nc=1){const sh=this;return{getValues(){const o=[];for(let i=0;i<nr;i++){const row=sh.d[r-1+i]||[];const x=[];for(let j=0;j<nc;j++)x.push(row[c-1+j]===undefined?'':row[c-1+j]);o.push(x);}return o},
  setValues(v){v.forEach((row,i)=>{sh.d[r-1+i]=sh.d[r-1+i]||[];row.forEach((x,j)=>sh.d[r-1+i][c-1+j]=gs(x))});return this},setValue(x){this.setValues([[x]])},setNumberFormat(){return this}}}};
function SS(){this.s={};}SS.prototype={getSheetByName(n){return this.s[n]||null},insertSheet(n){return this.s[n]=new Sheet(n)},getSheets(){return Object.values(this.s)}};Sheet.prototype.getName=function(){return this.name};
const active=new SS(), crm=new SS(), data=new SS(); const kh=crm.insertSheet('Khách hàng'); kh.appendRow(Array(46).fill('h'));
function crmRow(phone,name,lan){const r=Array(46).fill('');r[1]=new FD();r[2]=name;r[3]=phone;r[9]=lan||1;r[5]='sun-saphia-residence.com';r[6]='google';r[39]='Website';r[40]='https://www.sun-saphia-residence.com/ads';r[41]='Sun Saphia Residence';kh.appendRow(r);}
crmRow('0911111111','Cũ');
const props={};let BOTID=111;let upd=[],uid=1,mid=100;const sent=[],edits=[];
function U(o){upd.push(Object.assign({update_id:uid++},o));}
function msg(chat,text,first){U({message:{chat:{id:chat},from:{id:chat,first_name:first||'X'},text}});}
function click(chat,data){const m=sent.filter(s=>s.reply_markup&&JSON.stringify(s.reply_markup).includes('"'+data+'"')).pop();U({callback_query:{id:'q'+uid,from:{id:chat},data,message:{chat:{id:chat},message_id:m?m.mid:0}}});}
const ctx={Date:FD,console,JSON,Math,String,Number,Object,Array,
 SpreadsheetApp:{getActiveSpreadsheet:()=>active,openById:id=>id==='data-id'?data:crm},
 PropertiesService:{getScriptProperties:()=>({getProperty:k=>props[k]===undefined?null:props[k],setProperty:(k,v)=>props[k]=String(v),deleteProperty:k=>{delete props[k]}})},
 LockService:{getScriptLock:()=>({tryLock:()=>true,releaseLock(){}})},
 ScriptApp:{getScriptId:()=>'script-id',WeekDay:{MONDAY:'MONDAY'},getProjectTriggers:()=>[{getHandlerFunction:()=>'chayMoiPhut'}],deleteTrigger(){},newTrigger:()=>{const c={timeBased:()=>c,everyMinutes:()=>c,atHour:()=>c,nearMinute:()=>c,everyDays:()=>c,onWeekDay:()=>c,inTimezone:()=>c,create:()=>c};return c}},
 UrlFetchApp:{fetch(u,o){const m=u.split('/').pop(),p=JSON.parse(o.payload||'{}');let res={ok:true,result:true};
  if(m==='getUpdates'){const off=p.offset||0;res={ok:true,result:upd.filter(x=>x.update_id>=off)};}
  else if(m==='sendMessage'){mid++;sent.push(Object.assign({mid},p));res={ok:true,result:{message_id:mid}};}
  else if(m==='editMessageText'){edits.push(p);}
  else if(m==='getWebhookInfo'){res={ok:true,result:{url:'',pending_update_count:0}};}
  else if(m==='getMe'){res={ok:true,result:{id:BOTID,username:'chia_khach_test_bot'}};}
  return{getContentText:()=>JSON.stringify(res)};}}};
vm.createContext(ctx);vm.runInContext(code,ctx);
let fails=0;const ok=(c,m)=>{console.log((c?'  ✅ ':'  ❌ ')+m);if(!c)fails++};
const run=()=>vm.runInContext('chayMoiPhut()',ctx);
const adv=min=>{NOW+=min*60000;};
const advW=min=>{let w=0;while(w<min){NOW+=60000;const h=(new RD(NOW+7*3600000)).getUTCHours();if(h>=7&&h<21)w++;}}; // tua theo phút làm việc
const K=id=>vm.runInContext(`timKhach_('${id}')`,ctx);
const to=chat=>sent.filter(s=>String(s.chat_id)===String(chat));
const lastTo=chat=>to(chat).pop()||{text:''};
msg(900,'chào','QuanLy'); vm.runInContext('caiDat()',ctx);
msg(1,'/dangky An','An');msg(2,'/dangky Bình','Binh');run();click(900,'dy:1');click(900,'dy:2');run();
const all=()=>vm.runInContext("rows_('Khach',T_KHACH)",ctx);
const setCH=(k,v)=>vm.runInContext("(function(){var sh=tab_('CauHinh');var v=sh.getRange(2,1,sh.getLastRow()-1,1).getValues();for(var i=0;i<v.length;i++)if(v[i][0]==='"+k+"')sh.getRange(i+2,2).setValue("+JSON.stringify(v)+");})()",ctx);
setCH('GIO_BAT_DAU','6:30'); setCH('GIO_KET_THUC','23,5');
const vn=(d,h,m)=>Date.UTC(2026,10,d,h-7,m);
const k=p=>all().find(x=>x.sdt===p);
NOW=vn(19,6,29); crmRow('0905000001','A'); run(); ok(k('0905000001').trang_thai==='cho_giao','6h29: chưa chia, chờ sáng');
ok(to(900).some(x=>/ngoài giờ/.test(x.text)&&/6h30/.test(x.text)),'báo quản lý: sẽ chia lúc 6h30');
NOW=vn(19,6,30); run(); ok(k('0905000001').trang_thai==='cho_nhan','6h30: tự chia');
NOW=vn(19,23,29); crmRow('0905000002','B'); run(); ok(k('0905000002').trang_thai==='cho_nhan','23h29: vẫn chia');
NOW=vn(19,23,30); crmRow('0905000003','C'); run(); ok(k('0905000003').trang_thai==='cho_giao','23h30: dừng chia');
ok(vm.runInContext("phutMotNgay()",ctx)===1020,'1 ngày làm việc = 17 tiếng (6h30–23h30)');
ok(/6h30–23h30/.test(vm.runInContext("gioChu_('GIO_BAT_DAU')+'–'+gioChu_('GIO_KET_THUC')",ctx)),'hiển thị giờ 6h30–23h30');
NOW=vn(20,9,0); run(); const r=kh.d.length; const row=Array(46).fill('');row[1]=new FD();row[2]='Spam';row[3]='0905000004';row[9]=1;row[5]='sun-saphia-residence.com';row[21]='⚠️ NGHI RÁC (số ảo) · Studio';row[39]='Website';row[40]='https://www.sun-saphia-residence.com/ads';row[41]='Sun Saphia Residence';kh.appendRow(row); adv(1); run();
ok(!k('0905000004')&&to(900).some(x=>/nghi rác/i.test(x.text)&&/tm:0905000004/.test(JSON.stringify(x.reply_markup||''))),'số nghi rác: không tự chia, báo quản lý kèm nút');
console.log(fails?'TỔNG LỖI: '+fails:'TỔNG LỖI: 0');
