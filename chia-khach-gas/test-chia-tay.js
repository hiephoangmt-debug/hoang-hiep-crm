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
// Khách FourS (/them ... FourS): không tự chia, quản lý nhận nút chọn sale
msg(900,'/them 0902223334 Anh Nam - quan tâm FourS F2 2PN'); run();
let k=all().pop();
ok(k&&k.trang_thai==='cho_quan_ly'&&!k.nguoi_giu,'khách FourS không tự chia: chờ quản lý ('+(k&&k.trang_thai)+')');
const tin=sent.filter(s=>String(s.chat_id)==='900'&&/chờ anh chọn sale/.test(s.text)).pop();
ok(tin&&JSON.stringify(tin.reply_markup).includes('gt:'+k.id+':3'),'quản lý nhận tin có nút tên từng sale');
ok(![1,2,3,4,5].some(i=>to(i).some(s=>s.text.includes(k.id))),'chưa sale nào nhận tin khách này');
click(900,'gt:'+k.id+':3'); run(); k=K(k.id);
ok(k.trang_thai==='cho_nhan'&&String(k.nguoi_giu)==='3','bấm Linh: giao Linh');
ok(/KHÁCH K\d+/.test(lastTo(3).text)&&/Quản lý giao trực tiếp/.test(lastTo(3).text),'Linh nhận tin giao khách');
// đổi sang Thu: Linh bị thu hồi, Thu nhận
click(900,'gt:'+k.id+':5'); run(); k=K(k.id);
ok(String(k.nguoi_giu)==='5'&&edits.some(e=>String(e.chat_id)==='3'&&/chuyển cho người khác/.test(e.text)),'chọn lại Thu: Linh bị thu hồi, Thu nhận');
// Thu không bấm nhận 30 phút → quay về quản lý chọn, không tự chia
adv(35); run(); k=K(k.id);
ok(k.trang_thai==='cho_quan_ly','không bấm nhận: quay về quản lý chọn (không tự chia)');
// sale bấm nút gt: không được
click(1,'gt:'+k.id+':1'); run(); k=K(k.id); ok(k.trang_thai==='cho_quan_ly','sale không tự bấm giao được');
// Khách Saphia vẫn tự chia
const r=Array(46).fill('');r[1]=new FD();r[2]='Saphia';r[3]='0907778889';r[9]=1;r[5]='sun-saphia-residence.com';r[6]='google';r[39]='Website';r[40]='https://www.sun-saphia-residence.com/ads';r[41]='Sun Saphia Residence';kh.appendRow(r);
adv(1); run(); const ks=all().filter(x=>x.sdt==='0907778889').pop();
ok(ks&&ks.trang_thai==='cho_nhan'&&ks.nguoi_giu,'khách Saphia vẫn tự chia như cũ');
console.log('\nTỔNG LỖI: '+fails);
