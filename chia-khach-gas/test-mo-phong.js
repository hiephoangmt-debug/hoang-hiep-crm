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
function SS(){this.s={};}SS.prototype={getSheetByName(n){return this.s[n]||null},insertSheet(n){return this.s[n]=new Sheet(n)}};
const active=new SS(), crm=new SS(); const kh=crm.insertSheet('Khách hàng'); kh.appendRow(Array(46).fill('h'));
function crmRow(phone,name,lan){const r=Array(46).fill('');r[1]=new FD();r[2]=name;r[3]=phone;r[9]=lan||1;r[5]='sun-saphia-residence.com';r[6]='google';r[39]='Website';r[40]='https://www.sun-saphia-residence.com/ads';r[41]='Sun Saphia Residence';kh.appendRow(r);}
crmRow('0911111111','Cũ');
const props={};let BOTID=111;let upd=[],uid=1,mid=100;const sent=[],edits=[];
function U(o){upd.push(Object.assign({update_id:uid++},o));}
function msg(chat,text,first){U({message:{chat:{id:chat},from:{id:chat,first_name:first||'X'},text}});}
function click(chat,data){const m=sent.filter(s=>s.reply_markup&&JSON.stringify(s.reply_markup).includes('"'+data+'"')).pop();U({callback_query:{id:'q'+uid,from:{id:chat},data,message:{chat:{id:chat},message_id:m?m.mid:0}}});}
const ctx={Date:FD,console,JSON,Math,String,Number,Object,Array,
 SpreadsheetApp:{getActiveSpreadsheet:()=>active,openById:()=>crm},
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
// cài đặt
msg(900,'chào','QuanLy'); vm.runInContext('caiDat()',ctx);
ok(active.s['CauHinh'].d.some(r=>r[0]==='CRM_SHEET_ID'&&r[1]==='crm-id'),'caiDat lấy ID từ link Sheet CRM');
msg(5,'chào','Người khác'); vm.runInContext('caiDat()',ctx); ok(props.QUAN_LY_ID==='900','chạy lại caiDat không đổi quản lý');
ok(props.QUAN_LY_ID==='900','quản lý được ghi nhận'); ok(/Bot chia khách đã chạy/.test(lastTo(900).text),'quản lý nhận tin cài đặt');
// sale đăng ký + duyệt
msg(1,'/dangky An','An');msg(2,'/dangky Bình','Binh');msg(3,'/dangky Cường','Cuong');run();
ok(to(900).filter(s=>/xin vào đội chia khách/.test(s.text)).length===3,'quản lý nhận 3 yêu cầu duyệt');
click(900,'dy:1');click(900,'dy:2');click(900,'dy:3');run();
ok(/đã duyệt/.test(lastTo(1).text),'sale An được báo đã duyệt');
click(900,'dy:1');click(900,'dy:1');run(); ok(to(1).filter(s=>/đã duyệt/.test(s.text)).length===1,'bấm Duyệt nhiều lần: sale chỉ nhận 1 tin, nhật ký ghi 1 lần');
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
const m2=lastTo(k.nguoi_giu).text; ok(!/An|lượt|đã được thu hồi|Vào lúc/.test(m2)&&/Giao lúc/.test(m2),'sale nhận lượt sau không biết thu hồi từ ai (tin như khách mới)');
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
NOW=Date.UTC(2026,9,27,16,0); crmRow('0966000222','Khuya'); run(); const mk=sent.filter(s=>/KHÁCH K3/.test(s.text)).pop(); ok(mk&&mk.disable_notification===true&&/trước 07:30 28\/10/.test(mk.text),'khách 23h: gửi im lặng, hạn nhận 07:30 sáng hôm sau');
// chuyển đổi dừng hạn
NOW=Date.UTC(2026,9,28,1,0); k=K('K3'); click(k.nguoi_giu,'n:K3'); run(); click(k.nguoi_giu,'b:K3:hen'); run(); advW(14*60*6); run(); ok(K('K3').trang_thai==='chuyen_doi'&&K('K3').nguoi_giu===k.nguoi_giu,'hẹn gặp = chuyển đổi: qua hạn 3 ngày vẫn không thu hồi (6 ngày làm việc)');
click(k.nguoi_giu,'b:K3:cd'); run(); ok(K('K3').trang_thai==='chot'&&to(900).some(s=>/đã chốt khách K3/.test(s.text)),'chốt: quản lý được báo');

// ===== 8 LUẬT MỚI =====
const nhacTo=(chat,re)=>sent.some(s=>String(s.chat_id)===String(chat)&&re.test(s.text));
NOW=Date.UTC(2026,10,2,2,0); // thứ Hai 9h
crmRow('0933000001','Nhắc'); run(); let r=K('K4'); const h4=r.nguoi_giu;
adv(21); run(); ok(nhacTo(h4,/Còn 9 phút để bấm/),'1. nhắc trước khi thu hồi (phút 21: còn 9 phút)');
ok(sent.some(x=>/KHÁCH K4/.test(x.text)&&/Hạn bấm Nhận: <b>trước 09:30 02\/11<\/b>. Sau thời gian trên sẽ bị thu hồi/.test(x.text)),'tin giao ghi giờ hạn cụ thể (09:30)');
click(h4,'n:K4'); run(); ok(edits.some(e=>/Báo cáo khách này để cập nhật/.test(e.text)&&/Hạn báo cáo: <b>trước 11:21 02\/11/.test(e.text)),'nhận xong: ghi hạn báo cáo cụ thể (11:21)');
adv(91); run(); ok(nhacTo(h4,/Báo cáo khách K4 để cập nhật/)&&nhacTo(h4,/Sau thời gian trên sẽ bị thu hồi/),'1. nhắc báo cáo ở phút 91, ghi giờ hạn');
click(h4,'b:K4:goi'); run(); advW(14*60*2-91+5); run(); ok(nhacTo(h4,/K4 để cập nhật<\/b>: còn khoảng 1 ngày/),'1. nhắc ngày thứ 2 chưa chuyển đổi');
// 2. khách quay lại
const before=sent.length; crmRow('0933000001','Nhắc',2); run();
ok(nhacTo(h4,/Khách K4 vừa liên hệ lại/)&&!sent.slice(before).some(s=>/KHÁCH K5/.test(s.text)),'2. khách gửi lại → báo đúng người đang chăm, không chia mới');
// 6. khách nóng
click(h4,'b:K4:nong'); run(); advW(14*60*2+5); run(); ok(nhacTo(h4,/2 ngày chưa cập nhật/),'6. khách nóng 2 ngày chưa cập nhật → nhắc');
advW(14*60*5+5); run(); ok(K('K4').nguoi_giu!==h4,'6. khách nóng 7 ngày im lặng → thu hồi');
// 5. đóng khách cần lý do + duyệt
r=K('K4'); const h5=r.nguoi_giu; click(h5,'n:K4'); run(); click(h5,'b:K4:khong'); run(); ok(K('K4').trang_thai==='cho_ly_do','5. bấm Không nhu cầu → phải gõ lý do');
msg(h5,'Đã mua dự án khác'); run(); ok(K('K4').trang_thai==='cho_duyet_dong'&&to(900).some(s=>/xin đóng khách K4/.test(s.text)&&/Đã mua dự án khác/.test(s.text)),'5. lý do gửi quản lý duyệt');
click(900,'dd:K4'); run(); ok(K('K4').trang_thai==='dong','5. quản lý duyệt → đóng');
// 3. không ôm quá 5 khách chưa báo cáo
vm.runInContext("rows_('Sale',T_SALE).forEach(function(s){if(s.chat_id!='1'){s.trang_thai='nghi';save_('Sale',T_SALE,s);}else{s.trang_thai='lam';save_('Sale',T_SALE,s);}})",ctx);
for(let i=0;i<6;i++) crmRow('09440000'+(10+i),'Tải '+i); run();
const ks=vm.runInContext("rows_('Khach',T_KHACH).filter(function(k){return /^09440000/.test(k.sdt)}).map(function(k){return k.trang_thai+'|'+k.nguoi_giu})",ctx);
ok(ks.filter(x=>x==='cho_nhan|1').length===5&&ks.filter(x=>x.startsWith('cho_giao')).length===1,'3. đang giữ 5 khách chưa báo cáo → khách thứ 6 chờ ('+ks.join(' ')+')');
const k6=vm.runInContext("rows_('Khach',T_KHACH).filter(function(k){return k.trang_thai==='cho_giao'})[0].id",ctx);
const k1st=vm.runInContext("rows_('Khach',T_KHACH).filter(function(k){return k.trang_thai==='cho_nhan'&&k.nguoi_giu=='1'})[0].id",ctx);
click('1','n:'+k1st); run(); click('1','b:'+k1st+':goi'); run(); run(); ok(K(k6).trang_thai==='cho_nhan'&&K(k6).nguoi_giu==='1','3. báo cáo bớt 1 khách → khách đang chờ tự được giao');
// 4. bị thu hồi 3 lần/ngày → tự tạm dừng
vm.runInContext("rows_('Sale',T_SALE).forEach(function(s){s.trang_thai='lam';save_('Sale',T_SALE,s);})",ctx);
adv(31); run(); const s1=vm.runInContext("timSale_('1').trang_thai",ctx); ok(s1==='nghi'&&to(900).some(x=>/Tự tạm dừng/.test(x.text)),'4. bị thu hồi ≥3 lần/ngày vì không nhận → tự tạm dừng, báo quản lý');
// 7. /xoa
const giu2=vm.runInContext("rows_('Khach',T_KHACH).filter(function(k){return k.nguoi_giu=='2'&&DANG_GIU.test(k.trang_thai)}).length",ctx);
msg(900,'/xoa Bình'); run(); const con=vm.runInContext("rows_('Khach',T_KHACH).filter(function(k){return k.nguoi_giu=='2'&&DANG_GIU.test(k.trang_thai)}).length",ctx);
ok(vm.runInContext("timSale_('2').trang_thai",ctx)==='nghi_viec'&&con===0&&/Đã gỡ Bình/.test(lastTo(900).text),'7. /xoa: gỡ sale, thu hồi '+giu2+' khách đang giữ');
msg(2,'/khach'); run(); ok(/dangky/.test(lastTo(2).text),'7. sale đã gỡ không xem được khách');
// /khach có hạn
msg('1','/khach'); run(); ok(/trước <b>/.test(lastTo('1').text)&&/Sau thời gian trên sẽ bị thu hồi/.test(lastTo('1').text),'/khach liệt kê giờ hạn từng khách');
// 8. xếp hạng tuần
msg(900,'/tuan'); run(); ok(/Xếp hạng 7 ngày qua/.test(lastTo(900).text)&&/nhận đúng hạn/.test(lastTo(900).text),'8. /tuan: xếp hạng tuần');
console.log('\n'+lastTo(900).text.replace(/<[^>]+>/g,''));
// gia hạn chuyển đổi
{NOW=Date.UTC(2026,10,9,2,0); vm.runInContext("rows_('Sale',T_SALE).forEach(function(s){s.trang_thai=s.chat_id=='2'?'nghi_viec':'lam';save_('Sale',T_SALE,s);})",ctx);
 crmRow('0955000777','Gia hạn'); run(); const id=vm.runInContext("rows_('Khach',T_KHACH).filter(function(k){return k.sdt==='0955000777'})[0].id",ctx); let g=K(id); const hg=g.nguoi_giu;
 msg(hg,'/giahan '+id); run(); ok(/Chỉ gia hạn được hạn chuyển đổi/.test(lastTo(hg).text),'gia hạn: chưa nhận/báo cáo thì không gia hạn được');
 click(hg,'n:'+id); run(); click(hg,'b:'+id+':goi'); run();
 advW(14*60*2+5); run(); const nh=sent.filter(s=>String(s.chat_id)===hg&&/còn khoảng 1 ngày/.test(s.text)&&s.text.includes(id)).pop();
 ok(nh&&JSON.stringify(nh.reply_markup||{}).includes('gh:'+id),'gia hạn: tin nhắc ngày 2 có nút Xin gia hạn');
 click(hg,'gh:'+id); run(); ok(Number(K(id).gia_han)===1&&/Đã gia hạn khách/.test(lastTo(hg).text)&&to(900).some(s=>/gia hạn khách/.test(s.text)&&s.text.includes(id)),'gia hạn: bấm nút → +1 ngày, quản lý được báo');
 msg(hg,'/giahan '+id); run(); ok(/đã gia hạn rồi/.test(lastTo(hg).text),'gia hạn: chỉ được 1 lần');
 advW(14*60*1); run(); ok(K(id).nguoi_giu===hg,'gia hạn: qua mốc 3 ngày cũ vẫn chưa thu hồi');
 ok(sent.filter(s=>String(s.chat_id)===hg&&/còn khoảng 1 ngày/.test(s.text)&&s.text.includes(id)).length===2,'gia hạn: nhắc lại trước hạn mới 1 ngày');
 advW(14*60*1); run(); g=K(id); ok(g.nguoi_giu!==hg&&edits.some(e=>String(e.chat_id)===hg&&/đã được thu hồi/.test(e.text)&&e.text.includes(id)),'gia hạn: hết ngày gia hạn mà chưa chuyển đổi → thu hồi');}
// quản lý thêm khách bằng tay
{vm.runInContext("rows_('Sale',T_SALE).forEach(function(s){s.trang_thai=s.chat_id=='2'?'nghi_viec':'lam';save_('Sale',T_SALE,s);})",ctx);
 const b0=vm.runInContext("rows_('Khach',T_KHACH).length",ctx);
 msg(900,'/them 0912 345 678 Chị Hoa - căn 2PN, xem cuối tuần\n+84 913 000 111 Anh Nam\nabc\n0912345678 trùng'); run();
 const added=vm.runInContext("rows_('Khach',T_KHACH).slice("+b0+")",ctx);
 ok(added.length===2&&added[0].sdt==='0912345678'&&added[0].ten==='Chị Hoa'&&added[0].nhu_cau==='căn 2PN, xem cuối tuần'&&added[1].sdt==='0913000111'&&added[1].ten==='Anh Nam','/them: thêm 2 khách, đúng tên, số, nhu cầu');
 ok(added.every(k=>k.trang_thai==='cho_nhan'&&k.nguon==='quản lý thêm'),'/them: khách được giao ngay cho sale');
 const rep=lastTo(900).text; ok(/đã có/.test(rep)&&(rep.match(/✅/g)||[]).length===2&&added[1].nhu_cau==='abc','/them: báo số trùng; dòng không có số thành ghi chú của khách trên');
 msg(900,'/them abc 123'); run(); ok(/Không thấy số/.test(lastTo(900).text),'/them không có số: báo lỗi');
 ok(sent.some(s=>/KHÁCH /.test(s.text)&&/0912 ••• 678/.test(s.text)&&!/0912345678/.test(s.text)),'/them: sale chỉ thấy số đã che');
 msg(900,'/them'); run(); ok(/Gõ: /.test(lastTo(900).text),'/them trống: hướng dẫn cách gõ');
 const h=added[0].nguoi_giu; crmRow('0912345678','Hoa web'); run();
 ok(vm.runInContext("rows_('Khach',T_KHACH).filter(function(k){return k.sdt==='0912345678'}).length",ctx)===1&&nhacTo(h,/vừa để lại thông tin/),'/them rồi khách tự điền web: không chia trùng, báo người đang giữ');}
// dán nguyên tin báo khách
{const b0=vm.runInContext("rows_('Khach',T_KHACH).length",ctx);
 msg(900,'/them 🔥 KHÁCH MỚI ĐỂ LẠI SỐ\n📞 0395652778 – Đinh Nữ Mai Sương · Mở Zalo\n• Quan tâm: ADS – form cuối trang\n• Nguồn: google / f2 / Google Ads\n• Trang: https://www.sun-fours-tower.com/toa-f2-ads\n🕒 22:20:15 20/10/2026'); run();
 const a=vm.runInContext("rows_('Khach',T_KHACH).slice("+b0+")",ctx);
 ok(a.length===1&&a[0].ten==='Đinh Nữ Mai Sương'&&a[0].nhu_cau==='ADS – form cuối trang'&&a[0].nguon==='google / f2 / Google Ads'&&a[0].trang==='https://www.sun-fours-tower.com/toa-f2-ads','/them dán nguyên tin báo: 1 khách, đúng tên/nhu cầu/nguồn/trang ('+JSON.stringify(a[0]&&[a[0].ten,a[0].nhu_cau,a[0].nguon])+')');
 ok(!/❌/.test(lastTo(900).text),'/them dán nguyên tin báo: không báo lỗi dòng phụ');}
// lọc tên miền: chỉ sun-saphia-residence.com
{const b0=vm.runInContext("rows_('Khach',T_KHACH).length",ctx);
 const r1=Array(46).fill('');r1[1]=new FD();r1[2]='Cora';r1[3]='0988777666';r1[5]='www.cora-tower.com';r1[9]=1;r1[39]='Website';r1[40]='https://www.cora-tower.com/';r1[41]='Cora Tower';kh.appendRow(r1);
 const r2=Array(46).fill('');r2[1]=new FD();r2[2]='Shaphia';r2[3]='0988777555';r2[5]='www.sun-shaphiaresidence.com';r2[9]=1;r2[39]='Website';r2[40]='https://www.sun-shaphiaresidence.com/';r2[41]='Sun Saphia Residence';kh.appendRow(r2);
 const r3=Array(46).fill('');r3[1]=new FD();r3[2]='Ads';r3[3]='0988777444';r3[5]='www.sun-saphia-residence.com';r3[9]=1;r3[39]='Website';r3[40]='https://www.sun-saphia-residence.com/ads';r3[41]='Sun Saphia Residence';kh.appendRow(r3);
 const r4=Array(46).fill('');r4[1]=new FD();r4[2]='Trang chủ';r4[3]='0988777333';r4[5]='www.sun-saphia-residence.com';r4[9]=1;r4[39]='Website';r4[40]='https://www.sun-saphia-residence.com/';r4[41]='Sun Saphia Residence';kh.appendRow(r4);
 run(); const added=vm.runInContext("rows_('Khach',T_KHACH).slice("+b0+").map(function(k){return k.sdt})",ctx);
 ok(added.length===1&&added[0]==='0988777444','chỉ chia khách trang /ads, bỏ qua trang chủ, sun-shaphiaresidence.com và dự án khác ('+added.join(',')+')');}
// lệnh
msg(900,'/sale');msg(900,'/baocao');msg(1,'/khach');msg(77,'hello');run();
ok(/Đội chia khách/.test(to(900).slice(-2)[0].text),'/sale liệt kê đội');ok(/Báo cáo chia khách/.test(to(900).slice(-1)[0].text),'/baocao có báo cáo');
ok(/dangky/.test(lastTo(77).text),'người lạ được hướng dẫn đăng ký');
ok(sent.every(s=>s.protect_content===true),'mọi tin bật chặn chuyển tiếp/lưu');
console.log('\n'+to(900).slice(-1)[0].text.replace(/<[^>]+>/g,''));
// đổi sang bot mới: chạy lại caiDat → giữ quản lý, bỏ OFFSET cũ
{const offOld=props.OFFSET; vm.runInContext('caiDat()',ctx); ok(props.OFFSET===offOld,'chạy lại caiDat cùng bot: giữ vị trí đọc tin');
 BOTID=222; vm.runInContext('caiDat()',ctx); ok(props.OFFSET===undefined&&props.QUAN_LY_ID==='900'&&props.BOT_ID==='222','đổi bot mới: giữ quản lý, đọc tin bot mới từ đầu');}
console.log('\nTỔNG LỖI: '+fails);process.exit(fails?1:0);
