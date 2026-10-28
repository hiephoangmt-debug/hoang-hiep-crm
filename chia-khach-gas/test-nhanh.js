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

const S=id=>vm.runInContext(`timSale_('${id}')`,ctx);
msg(900,'chào','QuanLy'); vm.runInContext('caiDat()',ctx);
const ten={1:'Hạnh',2:'Tài',3:'Linh',4:'Ngà',5:'Thu'};
for(const i of [1,2,3,4,5]) msg(i,'/dangky '+ten[i],ten[i]); run();
for(const i of [1,2,3,4,5]) click(900,'dy:'+i); run();
const all=()=>vm.runInContext("rows_('Khach',T_KHACH)",ctx);
const giao=()=>all()[all().length-1];
let n=0; const moi=()=>{adv(1);n++;crmRow('090100'+String(n).padStart(4,'0'),'Mới '+n);run();return giao();};
// Nhánh 1: khách mới lần lượt Hạnh, Tài, Linh
const a=[moi(),moi(),moi()].map(k=>k.nguoi_giu);
ok(new Set(a).size===3,'khách mới 1-3 bốc ngẫu nhiên, mỗi người 1 khách: '+a.map(x=>ten[x]).join(','));
// đóng K2, K3 cho gọn (tránh bị thu hồi vì không nhận trong lúc tua 3 ngày)
vm.runInContext("['K2','K3'].forEach(function(id){var k=timKhach_(id);k.trang_thai='dong';save_('Khach',T_KHACH,k);})",ctx);
// K1 (Hạnh) nhận, báo cáo "đã gọi", 3 ngày chưa chuyển đổi → thu hồi → nhánh 2
let k1=K('K1'); const g1=k1.nguoi_giu; click(k1.nguoi_giu,'n:K1'); run(); click(k1.nguoi_giu,'b:K1:goi'); run();
const lgc=()=>[1,2,3,4,5].map(i=>String(S(i).luc_giao_cuoi)).join('|');
const truoc=lgc();
advW(14*60*3+5); run(); k1=K('K1');
ok(Number(k1.nhanh)===2&&k1.trang_thai==='cho_nhan'&&k1.nguoi_giu!==g1,'3 ngày chưa chuyển đổi: thu hồi, sang nhánh 2, giao '+ten[k1.nguoi_giu]);
ok(lgc()===truoc,'chia nhánh 2 KHÔNG đổi lượt khách mới (luc_giao_cuoi giữ nguyên)');
ok(S(k1.nguoi_giu).luc_giao_lai,'lượt nhánh 2 ghi riêng vào luc_giao_lai');
// Khách mới tiếp theo vẫn về Ngà, Thu (người chưa có lượt), rồi quay lại Hạnh
delete props.VONG_MOI; // giả lập vừa dán bản mới: phải dựng lại vòng từ nhật ký
const b=[moi(),moi()].map(k=>k.nguoi_giu), con=['1','2','3','4','5'].filter(x=>!a.includes(x));
ok(b.slice().sort().join()===con.sort().join(),'khách mới 4-5 về đúng 2 người chưa nhận vòng 1: '+b.map(x=>ten[x]).join(',')+' (người nhận nhánh 2 không bị mất lượt khách mới)');
ok(!to(900).some(s=>/vòng 2<\/b> chia khách mới/.test(s.text)),'chưa đủ 5 người thì chưa sang vòng 2');
const b6=moi(); ok(to(900).some(s=>/Bắt đầu <b>vòng 2<\/b> chia khách mới/.test(s.text))&&/Vòng: 2/.test(sent.filter(s=>/KHÁCH K\d+/.test(s.text)).pop().text),'khách mới thứ 6: cả đội đã nhận đủ → sang vòng 2, báo quản lý, tin giao ghi Vòng: 2 ('+ten[b6.nguoi_giu]+')');
msg(900,'/sale');run(); ok(/vòng 2/.test(lastTo(900).text)&&/✔ đã nhận vòng này/.test(lastTo(900).text),'/sale hiện vòng hiện tại và ai đã nhận');
// Khách mới bị thu hồi vì KHÔNG bấm nhận: vẫn nhánh 1
const k6=giao(); adv(31); run(); const k6b=K(k6.id);
ok(Number(k6b.nhanh||1)===1&&k6b.nguoi_giu!==k6.nguoi_giu,'khách mới không bấm nhận 30 phút: giao người tới lượt kế tiếp, vẫn nhánh 1 ('+ten[k6b.nguoi_giu]+')');
// Sale báo không nhu cầu → anh Hiệp bấm Chia lại → nhánh 2
let kx=K('K4'); const g4=kx.nguoi_giu; click(kx.nguoi_giu,'n:K4'); run(); click(kx.nguoi_giu,'b:K4:khong'); run(); msg(Number(kx.nguoi_giu),'khách bảo không có nhu cầu'); run();
const lgc2=lgc(); click(900,'cl:K4'); run(); kx=K('K4');
ok(Number(kx.nhanh)===2&&kx.trang_thai==='cho_nhan'&&kx.nguoi_giu!==g4,'sale báo không nhu cầu, quản lý bấm Chia lại: nhánh 2, giao '+ten[kx.nguoi_giu]);
ok(lgc()===lgc2,'chia lại không đổi lượt khách mới');
// Khách đã đóng, anh Hiệp check có nhu cầu: /chialai K2 → nhánh 2
msg(900,'/chialai K2'); run(); const k2=K('K2');
ok(Number(k2.nhanh)===2&&k2.trang_thai==='cho_nhan'&&/K2 nhánh 2: giao/.test(lastTo(900).text),'/chialai khách đã đóng: nhánh 2 → '+ten[k2.nguoi_giu]);
// Vòng nhánh 2 đi lần lượt, không trùng người cho tới khi hết vòng
const nh2=all().filter(k=>Number(k.nhanh)===2).map(k=>k.nguoi_giu);
ok(new Set(nh2).size===nh2.length,'3 khách nhánh 2 chia cho 3 người khác nhau: '+nh2.map(x=>ten[x]).join(','));
// K1 nhánh 2 lại hết 3 ngày → nhánh 3, không về người đã giữ
k1=K('K1'); click(k1.nguoi_giu,'n:K1'); run(); click(k1.nguoi_giu,'b:K1:goi'); run();
advW(14*60*3+5); run(); k1=K('K1');
ok(Number(k1.nhanh)===3&&!String(k1.da_qua).split(',').includes(k1.nguoi_giu),'nhánh 2 lại 3 ngày chưa chuyển đổi → nhánh 3, giao người chưa từng giữ ('+ten[k1.nguoi_giu]+')');
// /tailieu: sale và quản lý đều nhận 2 nút Slide chủ đầu tư + Slide nội bộ; người lạ thì không
msg(3,'/tailieu');run(); let tl=lastTo(3); const btn=JSON.stringify(tl.reply_markup||{});
ok(/Slide chủ đầu tư/.test(tl.text)&&btn.includes('/trinh-chieu')&&btn.includes('/dao-tao-sale'),'/tailieu (sale): gửi 2 nút Slide chủ đầu tư + Slide nội bộ');
msg(900,'/tailieu');run(); ok(JSON.stringify(lastTo(900).reply_markup||{}).includes('/dao-tao-sale'),'/tailieu (quản lý) cũng nhận');
msg(777,'/tailieu');run(); ok(!/trinh-chieu|dao-tao/.test(JSON.stringify(lastTo(777))),'người chưa vào đội gõ /tailieu: không nhận link');
console.log('\nTỔNG LỖI: '+fails);process.exit(fails?1:0);
