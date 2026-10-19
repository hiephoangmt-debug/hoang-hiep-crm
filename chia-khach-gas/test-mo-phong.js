const vm=require('vm'),fs=require('fs');
const code=fs.readFileSync(__dirname+'/ChiaKhach.gs','utf8').replace("var BOT_TOKEN_DAN_VAO_DAY = 'DÁN_MÃ_BOT_CHIA_KHÁCH_VÀO_ĐÂY';","var BOT_TOKEN_DAN_VAO_DAY = 'TEST123';");
let NOW=Date.UTC(2026,9,20,2,0); // 9:00 VN
const RD=Date; class FD extends RD{constructor(...a){a.length?super(...a):super(NOW)} static now(){return NOW}}
function Sheet(name){this.name=name;this.d=[];}
Sheet.prototype={getLastRow(){return this.d.length},getLastColumn(){return Math.max(0,...this.d.map(r=>r.length))},
 setFrozenRows(){},hideSheet(){},
 appendRow(r){this.d.push(r.slice())},
 getRange(r,c,nr=1,nc=1){const sh=this;return{getValues(){const o=[];for(let i=0;i<nr;i++){const row=sh.d[r-1+i]||[];const x=[];for(let j=0;j<nc;j++)x.push(row[c-1+j]===undefined?'':row[c-1+j]);o.push(x);}return o},
  setValues(v){v.forEach((row,i)=>{sh.d[r-1+i]=sh.d[r-1+i]||[];row.forEach((x,j)=>sh.d[r-1+i][c-1+j]=x)});return this},setValue(x){this.setValues([[x]])},setNumberFormat(){return this}}}};
function SS(){this.s={};}SS.prototype={getSheetByName(n){return this.s[n]||null},insertSheet(n){return this.s[n]=new Sheet(n)}};
const active=new SS(), crm=new SS(); const kh=crm.insertSheet('Khách hàng'); kh.appendRow(Array(46).fill('h'));
function crmRow(phone,name){const r=Array(46).fill('');r[1]=new FD();r[2]=name;r[3]=phone;r[5]='sun-saphia-residence.com';r[6]='google';r[39]='Website';r[40]='https://www.sun-saphia-residence.com/ads';r[41]='Sun Saphia Residence';kh.appendRow(r);}
crmRow('0911111111','Cũ');
const props={};let upd=[],uid=1,mid=100;const sent=[],edits=[];
function U(o){upd.push(Object.assign({update_id:uid++},o));}
function msg(chat,text,first){U({message:{chat:{id:chat},from:{id:chat,first_name:first||'X'},text}});}
function click(chat,data){const m=sent.filter(s=>s.reply_markup&&JSON.stringify(s.reply_markup).includes('"'+data+'"')).pop();U({callback_query:{id:'q'+uid,from:{id:chat},data,message:{chat:{id:chat},message_id:m?m.mid:0}}});}
const ctx={Date:FD,console,JSON,Math,String,Number,Object,Array,
 SpreadsheetApp:{getActiveSpreadsheet:()=>active,openById:()=>crm},
 PropertiesService:{getScriptProperties:()=>({getProperty:k=>props[k]===undefined?null:props[k],setProperty:(k,v)=>props[k]=String(v)})},
 LockService:{getScriptLock:()=>({tryLock:()=>true,releaseLock(){}})},
 ScriptApp:{getProjectTriggers:()=>[],deleteTrigger(){},newTrigger:()=>{const c={timeBased:()=>c,everyMinutes:()=>c,atHour:()=>c,nearMinute:()=>c,everyDays:()=>c,inTimezone:()=>c,create:()=>c};return c}},
 UrlFetchApp:{fetch(u,o){const m=u.split('/').pop(),p=JSON.parse(o.payload||'{}');let res={ok:true,result:true};
  if(m==='getUpdates'){const off=p.offset||0;res={ok:true,result:upd.filter(x=>x.update_id>=off)};}
  else if(m==='sendMessage'){mid++;sent.push(Object.assign({mid},p));res={ok:true,result:{message_id:mid}};}
  else if(m==='editMessageText'){edits.push(p);}
  return{getContentText:()=>JSON.stringify(res)};}}};
vm.createContext(ctx);vm.runInContext(code,ctx);
let fails=0;const ok=(c,m)=>{console.log((c?'  ✅ ':'  ❌ ')+m);if(!c)fails++};
const run=()=>vm.runInContext('chayMoiPhut()',ctx);
const adv=min=>{NOW+=min*60000;};
const K=id=>vm.runInContext(`timKhach_('${id}')`,ctx);
const to=chat=>sent.filter(s=>String(s.chat_id)===String(chat));
const lastTo=chat=>to(chat).pop()||{text:''};
// cài đặt
msg(900,'chào','QuanLy'); vm.runInContext('caiDat()',ctx); active.s['CauHinh'].d.forEach(r=>{if(r[0]==='CRM_SHEET_ID')r[1]='crm-id';}); vm.runInContext('ghiNhanKhachCu_()',ctx);
ok(props.QUAN_LY_ID==='900','quản lý được ghi nhận'); ok(/Bot chia khách đã chạy/.test(lastTo(900).text),'quản lý nhận tin cài đặt');
// sale đăng ký + duyệt
msg(1,'/dangky An','An');msg(2,'/dangky Bình','Binh');msg(3,'/dangky Cường','Cuong');run();
ok(to(900).filter(s=>/xin vào đội chia khách/.test(s.text)).length===3,'quản lý nhận 3 yêu cầu duyệt');
click(900,'dy:1');click(900,'dy:2');click(900,'dy:3');run();
ok(/đã duyệt/.test(lastTo(1).text),'sale An được báo đã duyệt');
// khách cũ không chia
run(); ok(!sent.some(s=>/0911/.test(s.text)||/KHÁCH K/.test(s.text)),'khách có sẵn lúc cài đặt không bị chia');
// khách mới 9h
crmRow('0905123456','Minh'); run();
let k=K('K1'); ok(k&&k.trang_thai==='cho_nhan','khách mới K1 được giao, chờ nhận ('+(k&&k.ten_sale)+')');
const first=k.nguoi_giu; const m1=lastTo(first).text; ok(/0905 ••• 456/.test(m1)&&!/0905123456/.test(m1),'tin giao chỉ có số đã che');
// sale khác bấm nhận -> bị chặn
const other=['1','2','3'].find(x=>x!==first); click(other,'n:K1'); run(); ok(K('K1').nguoi_giu===first&&K('K1').trang_thai==='cho_nhan','sale khác bấm không được');
// 29 phút chưa thu hồi, 31 phút thu hồi
adv(29);run(); ok(K('K1').nguoi_giu===first,'29 phút: chưa thu hồi');
adv(2);run(); k=K('K1'); ok(k.nguoi_giu!==first&&k.trang_thai==='cho_nhan','31 phút không nhận: thu hồi, giao '+k.ten_sale);
ok(edits.some(e=>String(e.chat_id)===first&&/đã được thu hồi/.test(e.text)&&!/0905/.test(e.text)),'tin cũ của sale trước bị sửa, ẩn số');
ok(to(900).some(s=>/Thu hồi K1/.test(s.text)),'quản lý được báo thu hồi');
const m2=lastTo(k.nguoi_giu).text; ok(!/An|lượt|thu hồi|Vào lúc/.test(m2)&&/Giao lúc/.test(m2),'sale nhận lượt sau không biết thu hồi từ ai (tin như khách mới)');
ok(!edits.filter(e=>String(e.chat_id)===first).some(e=>/Bình|Cường/.test(e.text)),'sale bị thu hồi không biết khách chuyển cho ai');
// sale 2 nhận -> thấy số; 2h không báo cáo -> thu hồi
const second=k.nguoi_giu; click(second,'n:K1'); run(); k=K('K1');
ok(k.trang_thai==='da_nhan'&&edits.some(e=>String(e.chat_id)===second&&/0905123456/.test(e.text)),'bấm nhận: thấy số đầy đủ + nút báo cáo');
adv(119);run(); ok(K('K1').nguoi_giu===second,'1h59 chưa báo cáo: chưa thu hồi');
adv(2);run(); k=K('K1'); const third=k.nguoi_giu; ok(third!==second&&third!==first,'2 giờ không báo cáo: thu hồi, giao '+k.ten_sale);
// sale 3 nhận + báo cáo "đã gọi" ; 3 ngày làm việc chưa chuyển đổi -> hết sale -> quản lý
click(third,'n:K1');run(); click(third,'b:K1:goi'); run(); ok(K('K1').trang_thai==='dang_cham'&&K('K1').bao_cao==='Đã gọi, đang tư vấn','báo cáo được ghi');
adv(60*24*2);run(); ok(K('K1').nguoi_giu===third,'2 ngày lịch: chưa thu hồi');
adv(60*24*1+60);run(); k=K('K1'); ok(k.trang_thai==='cho_quan_ly','3 ngày làm việc chưa chuyển đổi: thu hồi, hết sale → quản lý');
ok(to(900).some(s=>/Không còn sale nhận K1/.test(s.text)&&/0905123456/.test(s.text)),'quản lý nhận khách kèm số + nút chia lại');
// ban đêm: khách lúc 20:50, sáng 7:15 chưa thu hồi, 7:21 thu hồi
NOW=Date.UTC(2026,9,26,13,50); crmRow('0977000111','Đêm'); run(); k=K('K2'); const n1=k.nguoi_giu;
ok(k.trang_thai==='cho_nhan','khách 20:50 được giao ('+k.ten_sale+')');
NOW=Date.UTC(2026,9,27,0,15); run(); ok(K('K2').nguoi_giu===n1,'7:15 sáng hôm sau (10+15 phút làm việc): chưa thu hồi');
NOW=Date.UTC(2026,9,27,0,21); run(); ok(K('K2').nguoi_giu!==n1,'7:21: đủ 30 phút làm việc → thu hồi');
// khách lúc 23h: tin gửi im lặng
NOW=Date.UTC(2026,9,27,16,0); crmRow('0966000222','Khuya'); run(); const mk=sent.filter(s=>/KHÁCH K3/.test(s.text)).pop(); ok(mk&&mk.disable_notification===true&&/tính từ 7h/.test(mk.text),'khách 23h: gửi im lặng, hạn tính từ 7h');
// chuyển đổi dừng hạn
NOW=Date.UTC(2026,9,28,1,0); k=K('K3'); click(k.nguoi_giu,'n:K3'); run(); click(k.nguoi_giu,'b:K3:hen'); run(); adv(60*24*10); run(); ok(K('K3').trang_thai==='chuyen_doi'&&K('K3').nguoi_giu===k.nguoi_giu,'hẹn gặp = chuyển đổi: 10 ngày không thu hồi');
click(k.nguoi_giu,'b:K3:cd'); run(); ok(K('K3').trang_thai==='chot'&&to(900).some(s=>/đã chốt khách K3/.test(s.text)),'chốt: quản lý được báo');
// lệnh
msg(900,'/sale');msg(900,'/baocao');msg(1,'/khach');msg(77,'hello');run();
ok(/Đội chia khách/.test(to(900).slice(-2)[0].text),'/sale liệt kê đội');ok(/Báo cáo chia khách/.test(to(900).slice(-1)[0].text),'/baocao có báo cáo');
ok(/dangky/.test(lastTo(77).text),'người lạ được hướng dẫn đăng ký');
ok(sent.every(s=>s.protect_content===true),'mọi tin bật chặn chuyển tiếp/lưu');
console.log('\n'+to(900).slice(-1)[0].text.replace(/<[^>]+>/g,''));
console.log('\nTỔNG LỖI: '+fails);process.exit(fails?1:0);
