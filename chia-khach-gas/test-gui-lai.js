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


// CRM có sẵn khách cũ dự án khác (Data nhập)
function cu(phone,name,web,duan){const r=Array(47).fill('');r[1]=new FD();r[2]=name;r[3]=phone;r[5]=web;r[9]=1;r[21]='Quan tâm: '+web;r[39]='Data nhập';r[40]='https://www.'+web+'.com/';r[41]=duan;kh.appendRow(r);return kh.d.length;}
const rHiep=cu('0904567009','Ninad','filmore','Filmore'), rY=cu('0912345000','Khách Y','filmore','Filmore'), rZ=cu('0912345111','Khách Z','fours','FourS Tower');
const guiLai=(row,duan,nd)=>{const r=kh.d[row-1];r[9]=Number(r[9])+1;r[41]=duan;r[21]+=' | Gửi lại 00:12 24/10 · Dự án '+duan+' · '+nd;r[46]=new FD().toISOString();};
msg(900,'chào','QuanLy'); vm.runInContext('caiDat()',ctx);
for(const i of [1,2,3]) msg(i,'/dangky S'+i,'S'+i); run(); for(const i of [1,2,3]) click(900,'dy:'+i); run();
const all=()=>vm.runInContext("rows_('Khach',T_KHACH)",ctx);
// Anh Hiệp thử bằng số của mình TRƯỚC khi dán bản mới → lần đầu bản mới chỉ ghi nhận, không chia
guiLai(rHiep,'Saphia Residence','Form ADS – form cuối trang · Loại căn: Studio 30 m²'); delete props.CRM_LUAT; adv(1); run();
ok(!all().some(k=>k.sdt==='0904567009'),'lần đầu chạy luật mới: dòng thử có sẵn (số anh Hiệp) chỉ ghi nhận, không giao sale');
// Khách cũ Filmore quay lại đăng ký trên web Saphia → được chia
guiLai(rY,'Saphia Residence','Chat tư vấn – Studio'); adv(1); run();
const y=all().find(k=>k.sdt==='0912345000');
ok(y&&y.trang_thai==='cho_nhan'&&!laKhacJS(y)&&/Dự án Saphia Residence/.test(y.nhu_cau),'khách cũ dự án khác gửi lại trên web Saphia: được chia như khách Saphia mới ('+(y&&y.ten_sale)+', '+(y&&y.nhu_cau)+')');
function laKhacJS(k){return k.nhom==='khac';}
// Khách cũ gửi lại trên web FourS → không chia (FourS báo nhóm Tele riêng)
guiLai(rZ,'FourS Tower','form đầu trang'); adv(1); run();
ok(!all().some(k=>k.sdt==='0912345111'),'khách gửi lại trên web FourS: không chia (đúng như hiện nay)');
// Anh Hiệp thử lại lần nữa bằng số của mình → lúc này được chia (để kiểm tra đường đi)
guiLai(rHiep,'Saphia Residence','Form ADS'); adv(1); run();
ok(!all().some(k=>k.sdt==='0904567009'),'số anh Hiệp mặc định là số thử (SO_THU): gửi lại cũng không chia');
// Khách Saphia mới hoàn toàn vẫn chia như cũ
crmRow('0905000777','Mới tinh'); adv(1); run();
ok(all().some(k=>k.sdt==='0905000777'&&k.trang_thai==='cho_nhan'),'khách Saphia mới (Website) vẫn chia bình thường');

// ===== Số thử =====
{ const vg=()=>JSON.parse(props.VONG_MOI);
  const truoc=vg().da.slice();
  crmRow('0967273982','Thử'); adv(1); run();
  let kt=all().find(k=>k.sdt==='0967273982'); const g1=kt.nguoi_giu;
  adv(31); run(); kt=all().find(k=>k.sdt==='0967273982'); const g2=kt.nguoi_giu;
  ok(g1!==g2&&vg().da.includes(g2),'trước khi khai báo: số thử bị giao 2 người, cả 2 mất lượt');
  // quản lý thêm số vào SO_THU (tab CauHinh) → bot tự huỷ, trả lượt
  active.s['CauHinh'].appendRow(['SO_THU',"'0904567009; 0967273982",'']); adv(1); run();
  kt=all().find(k=>k.sdt==='0967273982');
  ok(kt.trang_thai==='dong'&&!vg().da.includes(g1)&&!vg().da.includes(g2)&&/trả lượt: .+, .+/.test(vm.runInContext("rows_('NhatKy',T_NK).filter(function(r){return r.hanh_dong==='huỷ khách thử'})[0].chi_tiet",ctx)),'thêm vào SO_THU: tự huỷ khách thử, trả lại lượt cho cả 2 người');
  ok(edits.some(e=>String(e.chat_id)===g2&&/số thử/.test(e.text))&&to(900).some(s=>/Đã huỷ khách thử/.test(s.text)),'báo sale đang giữ và báo quản lý');
  // số thử gửi lại: không chia
  const n0=all().length; const r=kh.d.find(x=>String(x[3]).endsWith('967273982')); r[9]=2; adv(1); run();
  ok(all().length===n0&&!all().some(k=>k.sdt==='0967273982'&&k.trang_thai!=='dong'),'số thử gửi lại: bot bỏ qua, không chia');
  // /huy bằng tay
  crmRow('0977888999','Thử tay'); adv(1); run(); const kh2=all().find(k=>k.sdt==='0977888999'); const g3=kh2.nguoi_giu;
  msg(900,'/huy '+kh2.id); run();
  ok(all().find(k=>k.sdt==='0977888999').trang_thai==='dong'&&!vg().da.includes(g3),'/huy Mã: đóng khách thử, trả lượt');
}
console.log('\nTỔNG LỖI: '+fails);process.exit(fails?1:0);
