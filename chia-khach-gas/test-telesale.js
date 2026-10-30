const vm=require('vm'),fs=require('fs');
const code=fs.readFileSync(__dirname+'/ChiaKhach.gs','utf8').replace("var BOT_TOKEN_DAN_VAO_DAY = 'DÁN_MÃ_BOT_CHIA_KHÁCH_VÀO_ĐÂY';","var BOT_TOKEN_DAN_VAO_DAY = 'TEST123';").replace("var LINK_SHEET_CRM_DAN_VAO_DAY = 'DÁN_LINK_SHEET_CRM_HOÀNG_HIỆP_VÀO_ĐÂY';","var LINK_SHEET_CRM_DAN_VAO_DAY = 'https://docs.google.com/spreadsheets/d/crm-id/edit#gid=0';");
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
const active=new SS(), crm=new SS(), data=new SS(), tele=new SS(); const kh=crm.insertSheet('Khách hàng'); kh.appendRow(Array(46).fill('h'));
function crmRow(phone,name,lan){const r=Array(46).fill('');r[1]=new FD();r[2]=name;r[3]=phone;r[9]=lan||1;r[5]='sun-saphia-residence.com';r[6]='google';r[39]='Website';r[40]='https://www.sun-saphia-residence.com/ads';r[41]='Sun Saphia Residence';kh.appendRow(r);}
crmRow('0911111111','Cũ');
const props={};let BOTID=111;let upd=[],uid=1,mid=100;const sent=[],edits=[];
function U(o){upd.push(Object.assign({update_id:uid++},o));}
function msg(chat,text,first){U({message:{chat:{id:chat},from:{id:chat,first_name:first||'X'},text}});}
function click(chat,data){const m=sent.filter(s=>s.reply_markup&&JSON.stringify(s.reply_markup).includes('"'+data+'"')).pop();U({callback_query:{id:'q'+uid,from:{id:chat},data,message:{chat:{id:chat},message_id:m?m.mid:0}}});}
const ctx={Date:FD,console,JSON,Math,String,Number,Object,Array,
 SpreadsheetApp:{getActiveSpreadsheet:()=>active,openById:id=>id==='tele-id'?tele:id==='data-id'?data:crm},
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
const H=t=>vm.runInContext(`fmt(hanTele_(${t}))`,ctx);
const vn=(d,h,m)=>Date.UTC(2026,9,d,h-7,m||0);
ok(H(vn(30,13))==='17:00 30/10','giao 13h → hạn 17h cùng ngày');
ok(H(vn(30,16,0))==='17:30 30/10','giao 16h (còn 1 tiếng) → +30 phút');
ok(H(vn(30,16,20))==='18:00 30/10','giao 16h20 (còn dưới 1 tiếng) → +60 phút');
ok(H(vn(30,18))==='17:00 31/10','giao sau 17h thứ Sáu → 17h thứ Bảy');
ok(H(vn(31,18))==='17:00 02/11','giao sau 17h thứ Bảy → bỏ Chủ nhật, 17h thứ Hai');
ok(H(vn(32,10))==='17:00 02/11','giao Chủ nhật → 17h thứ Hai');
// File telesale
const d1=tele.insertSheet('Data 01'), d2=tele.insertSheet('Data 02'), th2=tele.insertSheet('Tổng hợp');
for(let i=0;i<8;i++){d1.appendRow(['h']);d2.appendRow(['h']);}
const ph=i=>"'+849"+String(10000000+i);
for(let i=0;i<6;i++) d1.appendRow(['Sun Group',ph(i),i<3?'An':'Bình','','x','y']);
for(let i=6;i<30;i++) d2.appendRow(['Sun Group',ph(i),'','','','']);
msg(900,'chào','QuanLy'); vm.runInContext('caiDat()',ctx);
msg(1,'/dangky An','An');msg(2,'/dangky Bình','Binh');run();click(900,'dy:1');click(900,'dy:2');run();
vm.runInContext("(function(){var sh=tab_('CauHinh');var v=sh.getRange(2,1,sh.getLastRow()-1,1).getValues();for(var i=0;i<v.length;i++)if(v[i][0]==='TELESALE_SHEET_ID')sh.getRange(i+2,2).setValue('https://docs.google.com/spreadsheets/d/tele-id/edit');})()",ctx);
const ai=n=>[...d1.d.slice(8),...d2.d.slice(8)].filter(r=>r[2]===n).length;
NOW=vn(20,9); adv(3); run();
ok(ai('An')===3&&ai('Bình')===3,'chưa ai báo cáo → không giao thêm');
d1.d[8][3]='Không nghe máy'; d1.d[9][3]='Hẹn gặp / xem dự án'; adv(1); run();
ok(ai('An')===3,'An mới báo cáo 2/3 → chưa giao');
d1.d[10][3]='Gọi lại sau'; adv(1); run();
ok(ai('An')===4&&ai('Bình')===3,'An báo cáo hết → giao đúng 1 số, Bình chưa xong không được giao');
ok(d2.d[8][2]==='An'&&d2.d[9][2]==='','giao đúng thứ tự từ đầu kho');
ok(d2.d[8][4] instanceof Date && d2.d[8][5] instanceof Date,'ghi giờ giao + hạn');
ok(/0910000006/.test(lastTo(1).text)&&/nutTele|ts:Data 02:9:/.test(JSON.stringify(lastTo(1).reply_markup))&&!/docs.google/.test(lastTo(1).text),'nhắn An số điện thoại kèm nút, không lộ link file');
ok(d1.d[9][2]==='An','khách nét (Hẹn gặp) An giữ luôn');
adv(1); run(); ok(ai('An')===4,'chưa báo cáo số mới → không giao tiếp');
d2.d[8][3]='Không nhu cầu'; adv(1); run(); ok(ai('An')===5&&d2.d[9][2]==='An','báo cáo xong → giao số kế tiếp ngay phút sau');
ok(to(2).some(x=>/0910000003/.test(x.text)&&x.reply_markup),'số đang giữ sẵn (Bình) cũng được nhắn kèm nút báo cáo');
ok(to(1).filter(x=>/0910000006/.test(x.text)).length===1,'không nhắn lặp cùng một số');
click(2,'ts:Data 01:12:5'); click(2,'ts:Data 01:13:6'); click(2,'ts:Data 01:14:0'); run();
ok(d1.d[11][3]==='Hẹn gặp / xem dự án','bấm nút trên Telegram → ghi thẳng vào file');
ok(ai('Bình')===4&&/ts:Data 02:11:/.test(JSON.stringify(lastTo(2).reply_markup)),'báo cáo qua Telegram → giao số tiếp ngay');
ok(edits.some(e=>/Đã báo cáo: <b>Hẹn gặp/.test(e.text)),'tin cũ đổi thành "Đã báo cáo"');
d1.d[12][3]=''; click(1,'ts:Data 01:13:0'); run(); ok(d1.d[12][3]==='','bấm số của người khác → không ghi'); d1.d[12][3]='Không nhu cầu';
NOW=vn(20,22); d2.d[9][3]='Môi giới'; run(); ok(ai('An')===5,'ngoài giờ làm việc không giao');
NOW=vn(21,9); let n=0; while(n++<60){ [...d1.d.slice(8),...d2.d.slice(8)].forEach(r=>{if(r[2]&&!r[3])r[3]='Không nghe máy'}); adv(1); run(); }
ok(ai('An')+ai('Bình')===30,'gọi hết thì giao hết kho');
ok(/kho đã giao hết/.test(lastTo(900).text),'kho hết → báo quản lý 1 lần');
ok(to(900).filter(s=>/kho đã giao hết/.test(s.text)).length===1,'không báo lặp');
ok(!vm.runInContext("rows_('Khach',T_KHACH).length",ctx),'không đụng khách / lượt FourS-Saphia');
console.log(fails?'TỔNG LỖI: '+fails:'TỔNG LỖI: 0');
