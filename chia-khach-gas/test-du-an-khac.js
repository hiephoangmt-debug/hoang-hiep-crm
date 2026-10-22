const vm=require('vm'),fs=require('fs');
const code=fs.readFileSync(__dirname+'/ChiaKhach.gs','utf8').replace("var BOT_TOKEN_DAN_VAO_DAY = 'DÁN_MÃ_BOT_CHIA_KHÁCH_VÀO_ĐÂY';","var BOT_TOKEN_DAN_VAO_DAY = 'TEST123';").replace("var LINK_SHEET_CRM_DAN_VAO_DAY = 'DÁN_LINK_SHEET_CRM_HOÀNG_HIỆP_VÀO_ĐÂY';","var LINK_SHEET_CRM_DAN_VAO_DAY = 'https://docs.google.com/spreadsheets/d/crm-id/edit#gid=0';");
let NOW=Date.UTC(2026,9,20,2,0); // 9:00 VN
const RD=Date; class FD extends RD{constructor(...a){a.length?super(...a):super(NOW)} static now(){return NOW}}
const gs=x=>typeof x==='string'&&x[0]==="'"?x.slice(1):(typeof x==='string'&&/^0\d{8,}$/.test(x)?Number(x):x); // giống Google Sheet
function Sheet(name){this.name=name;this.d=[];}
Sheet.prototype={getLastRow(){return this.d.length},getLastColumn(){return Math.max(0,...this.d.map(r=>r.length))},
 setFrozenRows(){},hideSheet(){},
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
 ScriptApp:{WeekDay:{MONDAY:'MONDAY'},getProjectTriggers:()=>[{getHandlerFunction:()=>'chayMoiPhut'}],deleteTrigger(){},newTrigger:()=>{const c={timeBased:()=>c,everyMinutes:()=>c,atHour:()=>c,nearMinute:()=>c,everyDays:()=>c,onWeekDay:()=>c,inTimezone:()=>c,create:()=>c};return c}},
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
// Sheet DATA CHẠY GOOGLE: tab dự án + tab hệ thống
const dt=data.insertSheet('Dowtown'), cora=data.insertSheet('CORA TOWER'), th=data.insertSheet('UPLOAD_META'), fs4=data.insertSheet('FourS cũ');
dt.appendRow(['2025-09-11 08:51:36','Cũ Downtown','981131391','Hà Nội','https://www.sun-danangdowntown.com/?gclid=x']);
th.appendRow(['x','y','0905999888']);
const dRow=(sh,...c)=>sh.appendRow(c);
msg(900,'chào','QuanLy'); vm.runInContext('caiDat()',ctx);
vm.runInContext("(function(){var sh=tab_('CauHinh');var v=sh.getRange(2,1,sh.getLastRow()-1,1).getValues();for(var i=0;i<v.length;i++)if(v[i][0]==='NGUON_KHAC_SHEET_ID')sh.getRange(i+2,2).setValue('https://docs.google.com/spreadsheets/d/data-id/edit');})()",ctx);
ok(active.s['CauHinh'].d.some(r=>r[0]==='NHOM_RIENG'),'CauHinh có khoá mới NHOM_RIENG / NGUON_KHAC_*');
msg(1,'/dangky An','An');msg(2,'/dangky Bình','Binh');msg(3,'/dangky Cường','Cuong');run();
click(900,'dy:1');click(900,'dy:2');click(900,'dy:3');run();
run(); ok(!sent.some(s=>/KHÁCH K/.test(s.text)),'data cũ trong DATA CHẠY GOOGLE không bị chia khi bật lần đầu');
ok(active.s['Sale'].d[0].includes('luc_giao_khac')&&active.s['Khach'].d[0].includes('nhom'),'tiêu đề cột mới được thêm');
const S=id=>vm.runInContext(`timSale_('${id}')`,ctx);
const ms=x=>x?new RD(x).getTime():0;
// 3 khách Saphia lần lượt: An, Bình, Cường (vòng FourS/Saphia)
const order=[];
for(const [i,p] of ['0901000001','0901000002','0901000003'].entries()){adv(1);crmRow(p,'S'+i);run();const k=K('K'+(i+1));order.push(k.nguoi_giu);click(k.nguoi_giu,'n:'+k.id);run();click(k.nguoi_giu,'b:'+k.id+':hen');run();}
ok(new Set(order).size===3,'3 khách Saphia chia đều 3 sale: '+order.join(','));
const lgc={};['1','2','3'].forEach(c=>lgc[c]=ms(S(c).luc_giao_cuoi));
// 2 khách Downtown mới (cùng 1 khách gửi form 2 lần) + 1 Cora + 1 dòng có tab FourS + 1 dòng tab hệ thống
adv(1);
dRow(dt,'2026-10-22 13:00:00','Hùng','hung@gmail.com','912345678','https://www.sun-danangdowntown.com/?gad_source=1&gclid=abc');
dRow(dt,'2026-10-22 13:00:40','Hùng','912345678','CĂN 1PN (47,4 m2)','https://www.sun-danangdowntown.com/?gad_source=1&gclid=abc');
dRow(cora,'2026-10-22 13:01:00','Lan','0935111222','https://cora-tower.com/?utm_source=chatgpt.com','chatgpt.com');
dRow(fs4,'2026-10-22 13:01:00','F','0935333444','https://www.sun-fours-tower.com/');
dRow(th,'a','b','0935555666');
run();
const kd=vm.runInContext("rows_('Khach',T_KHACH).filter(function(k){return k.nhom==='khac'})",ctx);
ok(kd.length===2,'2 khách dự án khác được tạo (Hùng gửi 2 lần = 1 khách; bỏ tab FourS và tab hệ thống): '+kd.map(k=>k.ten).join(','));
const hung=kd.find(k=>k.ten==='Hùng');
ok(hung&&hung.sdt==='0912345678'&&/Dowtown · CĂN 1PN/.test(hung.nhu_cau)&&hung.nguon==='Google Ads','khách Downtown: số thêm 0, dự án, nguồn Google Ads ('+(hung&&hung.nhu_cau)+')');
ok(kd.every(k=>k.trang_thai==='cho_nhan'),'khách dự án khác được giao, chờ nhận');
ok(/Dự án: Dowtown/.test(sent.filter(s=>new RegExp('KHÁCH '+hung.id).test(s.text)).pop().text),'tin giao ghi rõ dự án');
ok(['1','2','3'].every(c=>ms(S(c).luc_giao_cuoi)===lgc[c]),'chia dự án khác KHÔNG đổi lượt FourS/Saphia (luc_giao_cuoi giữ nguyên)');
ok(kd.every(k=>S(k.nguoi_giu).luc_giao_khac),'lượt dự án khác ghi riêng vào luc_giao_khac');
ok(kd[0].nguoi_giu!==kd[1].nguoi_giu,'2 khách dự án khác chia cho 2 người khác nhau');
// khách Saphia tiếp theo vẫn về đúng người đầu vòng FourS/Saphia (An/order[0])
adv(1);crmRow('0901000004','S4');run();
ok(K('K'+(3+kd.length+1)).nguoi_giu===order[0],'khách Saphia thứ 4 vẫn về người đầu vòng ('+order[0]+'), không bị lệch bởi khách dự án khác');
// khách dự án khác gửi lại khi đang có người giữ: báo người giữ, không tạo mới
const holder=hung.nguoi_giu; adv(1); dRow(dt,'2026-10-22 14:00:00','Hùng','0912345678','https://www.sun-danangdowntown.com/'); run();
ok(vm.runInContext("rows_('Khach',T_KHACH).filter(function(k){return k.sdt==='0912345678'}).length",ctx)===1&&/vừa để lại thông tin/.test(lastTo(holder).text),'khách dự án khác gửi lại: báo người đang giữ, không chia trùng');
// /them có trang dự án khác → nhóm khác ; /them không trang → nhóm FourS/Saphia ; /themkhac → khác
msg(900,'/them 0977000001 A - 2PN\nTrang: https://www.sun-danangdowntown.com/');msg(900,'/them 0977000002 B - F2');msg(900,'/themkhac 0977000003 C - Spana');run();
const nh=p=>vm.runInContext(`rows_('Khach',T_KHACH).filter(function(k){return k.sdt==='${p}'})[0].nhom`,ctx);
ok(nh('0977000001')==='khac'&&nh('0977000002')===''&&nh('0977000003')==='khac','/them tự nhận nhóm theo trang; /themkhac luôn là dự án khác');
// /sale hiển thị tách
msg(900,'/sale');run(); ok(/dự án khác/.test(lastTo(900).text),'/sale tách số khách dự án khác');
// thêm tab mới sau này: không đổ data cũ của tab đó
const nt=data.insertSheet('Tab mới');dRow(nt,'x','Old','0944000111','https://abc.com');run();
ok(!vm.runInContext("rows_('Khach',T_KHACH).some(function(k){return k.sdt==='0944000111'})",ctx),'tab mới thêm sau: data có sẵn không bị chia');
dRow(nt,'x','New','0944000222','https://abc.com');run();
ok(vm.runInContext("rows_('Khach',T_KHACH).some(function(k){return k.sdt==='0944000222'&&k.nhom==='khac'})",ctx),'tab mới: dòng thêm sau được chia');
console.log('\nTỔNG LỖI: '+fails);process.exit(fails?1:0);
