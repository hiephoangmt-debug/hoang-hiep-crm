/**
 * CHIA KHÁCH CHO SALE QUA TELEGRAM – chạy trên Google Apps Script (không cần máy chủ)
 *
 * Luồng:
 *  1. Mỗi phút đọc khách mới (nguồn Website) trong Sheet "CRM Hoàng Hiệp".
 *  2. Giao lần lượt cho sale đang làm, ít khách nhất. Tin chỉ có số đã che + nút "Nhận khách".
 *  3. 30 phút không nhận → thu hồi, giao bạn khác.
 *     Nhận rồi 2 giờ không báo cáo → thu hồi, giao bạn khác.
 *     3 ngày chưa chuyển đổi (hẹn gặp / khách nóng / đã chốt) → thu hồi, giao bạn khác.
 *     Mọi hạn chỉ tính trong giờ làm việc 7h–21h (từ 21h tới 7h sáng hôm sau không tính).
 *  4. Mỗi tối gửi báo cáo cho quản lý.
 *  5. Data telesale / dự án khác: dán vào tab "NhapData" (nguyên dòng thô cũng được) (hoặc các tab Sheet "DATA CHẠY GOOGLE") → bot tự chia
 *     như khách thường, nhưng xoay vòng RIÊNG và giới hạn RIÊNG: không làm mất lượt, không chặn khách FourS / Saphia.
 *     Data telesale KHÔNG thu hồi tự động: giao ai người đó giữ (quản lý vẫn chia lại được bằng nút / /xoa).
 *  6. Nhánh: khách mới về = nhánh 1, chia lần lượt từng sale. Khách đã có người chăm mà bị thu hồi (3 ngày chưa chuyển đổi…)
 *     hoặc quản lý chia lại (sale báo không nhu cầu nhưng quản lý thấy có) = nhánh 2, 3… chia theo vòng riêng,
 *     KHÔNG làm mất lượt khách mới (nhánh 1) của sale.
 * Thêm: nhắc trước hạn · khách quay lại về đúng người đang chăm · không ôm quá 5 khách chưa báo cáo ·
 *       bị thu hồi 3 lần/ngày thì tự tạm dừng · đóng khách phải ghi lý do và quản lý duyệt ·
 *       khách nóng 2 ngày nhắc, 7 ngày im lặng thì thu hồi · /xoa sale nghỉ việc · xếp hạng tuần.
 * Riêng tư: sale chỉ thấy số đầy đủ sau khi bấm Nhận; bị thu hồi thì tin cũ bị xoá số;
 *           sale không biết khách bị thu hồi từ ai hay chuyển cho ai.
 * Mọi thao tác ghi vào tab "NhatKy".
 *
 * Cài đặt: xem HUONG_DAN.md cùng thư mục.
 */

/* ======================= CẤU HÌNH (sửa trong tab CauHinh) ======================= */
var MAC_DINH = {
  CRM_SHEET_ID: '',          // ID Sheet "CRM Hoàng Hiệp" (đoạn giữa /d/…/edit trong link)
  CRM_TAB: 'Khách hàng',
  LOC_TRANG: 'sun-saphia-residence.com/ads', // chỉ chia khách đến từ tên miền này (cột Trang phát sinh lead / Website); nhiều tên miền cách nhau dấu phẩy; để trống = mọi trang
  GIO_BAT_DAU: 7,            // giờ làm việc (giờ Việt Nam); từ 21h tới 7h sáng hôm sau không tính hạn
  GIO_KET_THUC: 21,
  HAN_NHAN_PHUT: 30,
  HAN_BAO_CAO_PHUT: 120,
  HAN_CHUYEN_DOI_NGAY: 3,
  SO_LUOT_TOI_DA: 4,         // chuyển quá số lượt này thì giao cho quản lý
  GIO_BAO_CAO_TOI: 21,
  NHAC_NHAN_PHUT: 20,        // nhắc "còn 10 phút để nhận"
  NHAC_BAO_CAO_PHUT: 90,     // nhắc "còn 30 phút để báo cáo"
  NHAC_CHUYEN_DOI_NGAY: 2,   // nhắc "còn 1 ngày để chuyển đổi"
  TOI_DA_CHUA_BAO_CAO: 5,    // đang giữ từ ngần này khách chưa báo cáo thì tạm không giao thêm
  THU_HOI_TU_DUNG: 3,        // bị thu hồi vì không nhận ngần này lần trong 1 ngày thì tự tạm dừng
  NONG_NHAC_NGAY: 2,         // khách nóng/hẹn gặp: 2 ngày chưa cập nhật thì nhắc
  NONG_THU_HOI_NGAY: 7,      // khách nóng/hẹn gặp: 7 ngày im lặng thì thu hồi
  GIA_HAN_NGAY: 1,           // sale xin gia hạn hạn chuyển đổi: cộng thêm ngần này ngày
  SO_LAN_GIA_HAN: 1,         // mỗi khách được xin gia hạn tối đa ngần này lần
  NGUON_KHAC_SHEET_ID: '',   // ID Sheet "DATA CHẠY GOOGLE" (khách dự án khác); để trống = không chia dự án khác
  NGUON_KHAC_TAB: '',        // chỉ đọc các tab này (cách nhau dấu phẩy); để trống = mọi tab dự án
  TOI_DA_CHUA_BAO_CAO_KHAC: 3, // data telesale: mỗi sale giữ tối đa ngần này khách chưa báo cáo, xong mới giao tiếp
  SO_THU: '0904567009',       // số dùng để thử (cách nhau dấu chấm phẩy ; để Sheet không hiểu thành số): bot không chia; đang giữ thì tự huỷ và trả lượt
  DU_AN_CHIA: 'saphia,shaphia', // khách cũ (đã có trong CRM) gửi lại từ web mà "Dự án quan tâm" có chữ này cũng được chia
  CHIA_TAY: 'fours',          // khách có chữ này (trang / nhu cầu / nguồn) KHÔNG tự chia: bot gửi quản lý kèm nút tên sale để chọn người nhận; để trống = tự chia hết
  NHOM_RIENG: 'fours,saphia', // khách có chữ này (trang / nhu cầu / nguồn) tính lượt FourS–Saphia; còn lại là dự án khác
  TU_CHIA: 0,                // 1 = khách mới từ web / DATA CHẠY GOOGLE tự chia; 0 = chỉ báo quản lý, bấm "Chia khách này" hoặc /them mới chia
  TELESALE_SHEET_ID: '',     // file báo cáo telesale (tab "Data 01", "Data 02"…): ai báo cáo hết số đang giữ thì tự cấp thêm; để trống = tắt
  TELESALE_THEM: 1,          // mỗi lần giao ngần này số (1 = chia từng số: gọi xong, báo cáo xong mới giao số tiếp)
  TELESALE_GIO_HAN: 17,      // hạn báo cáo: giờ này trong ngày được giao (giao sát giờ cộng 30–60 phút; sau giờ này / Chủ nhật thì sang ngày làm việc sau)
  SLIDE_CDT: 'https://www.sun-saphia-residence.com/trinh-chieu',    // lệnh /tailieu – slide dự án theo tài liệu chủ đầu tư (gửi khách được)
  SLIDE_NOI_BO: 'https://www.sun-saphia-residence.com/dao-tao-sale' // lệnh /tailieu – slide nội bộ đào tạo sale (không gửi khách)
};

var BC = {  // nút báo cáo của sale
  goi:   'Đã gọi, đang tư vấn',
  knm:   'Không nghe máy',
  hen:   'Hẹn gặp / xem dự án',
  nong:  'Khách nóng',
  cd:    'Đã chốt',
  khong: 'Không tiềm năng'
};
var CHUYEN_DOI = {hen: 1, nong: 1, cd: 1};   // báo cáo nào được tính là đã chuyển đổi (dừng hạn 3 ngày)

var T_KHACH = ['id', 'luc_vao', 'ten', 'sdt', 'nhu_cau', 'nguon', 'trang', 'trang_thai', 'nguoi_giu', 'ten_sale', 'msg_id',
  'luc_giao', 'luc_nhan', 'luc_bao_cao', 'bao_cao', 'so_bao_cao', 'da_qua', 'so_luot', 'ghi_chu', 'nhac', 'ly_do_dong', 'so_lan_gui', 'gia_han', 'nhom', 'nhanh'];
/* 3 vòng xoay riêng: luc_giao_cuoi = khách FourS/Saphia mới về (nhánh 1) · luc_giao_lai = khách chia lại (nhánh 2, 3…)
   · luc_giao_khac = data telesale / dự án khác */
var T_SALE = ['chat_id', 'ten', 'username', 'trang_thai', 'luc_giao_cuoi', 'them_luc', 'luc_giao_khac', 'luc_giao_lai'];
var T_NK = ['thoi_gian', 'nguoi', 'hanh_dong', 'khach', 'chi_tiet'];
var HD_NHAP = '⬇️ Dán data từ dòng 2 trở xuống (copy nguyên dòng từ tab dự án cũng được, hoặc: Tên | SĐT | Dự án | Ghi chú). Bot chia xong tự chuyển dòng sang tab DaChia.';
var T_DACHIA = ['Kết quả', 'Lúc xử lý', 'Dữ liệu gốc →'];

/* Trạng thái khách: cho_nhan → da_nhan → dang_cham | chuyen_doi → chot ; cho_ly_do → cho_duyet_dong → dong ;
   cho_giao (đội đang quá tải, chờ chia) ; cho_quan_ly (hết sale) */
var DANG_GIU = /^(cho_nhan|da_nhan|dang_cham|chuyen_doi|cho_ly_do|cho_duyet_dong)$/;
var CHUA_BAO_CAO = /^(cho_nhan|da_nhan)$/;

/* ======================= TIỆN ÍCH ======================= */
function P() { return PropertiesService.getScriptProperties(); }
function cfg(k) {
  var m = tabMap_('CauHinh');
  return m.hasOwnProperty(k) && m[k] !== '' ? m[k] : MAC_DINH[k];
}
function num(k) { return Number(cfg(k)); }
function nowD() { return new Date(); }
function ms(d) { return d instanceof Date ? d.getTime() : (d ? new Date(d).getTime() : 0); }
function vnHour(t) { var d = new Date(t + 7 * 3600000); return d.getUTCHours() + d.getUTCMinutes() / 60; }
function vnDay(t) { var d = new Date(t + 7 * 3600000); return d.getUTCFullYear() + '-' + (d.getUTCMonth() + 1) + '-' + d.getUTCDate(); }
function fmt(t) { var d = new Date(ms(t) + 7 * 3600000); function z(n) { return (n < 10 ? '0' : '') + n; } return z(d.getUTCHours()) + ':' + z(d.getUTCMinutes()) + ' ' + z(d.getUTCDate()) + '/' + z(d.getUTCMonth() + 1); }
function trongGio(t) { var h = vnHour(t); return h >= num('GIO_BAT_DAU') && h < num('GIO_KET_THUC'); }
/* Số phút làm việc giữa 2 thời điểm (bỏ qua ngoài giờ) */
function phutLamViec(a, b) {
  a = ms(a); b = ms(b); if (!a || b <= a) return 0;
  var off = 7 * 3600000, gs = num('GIO_BAT_DAU') * 3600000, ge = num('GIO_KET_THUC') * 3600000, tong = 0;
  for (var day = Math.floor((a + off) / 86400000); ; day++) {
    var d0 = day * 86400000 - off; if (d0 > b) break;
    var x = Math.max(a, d0 + gs), y = Math.min(b, d0 + ge); if (y > x) tong += y - x;
  }
  return Math.floor(tong / 60000);
}
/* Thời điểm đủ "phut" phút làm việc tính từ a (bỏ qua 21h–7h) */
function hanLuc(a, phut) {
  a = ms(a); var off = 7 * 3600000, gs = num('GIO_BAT_DAU') * 3600000, ge = num('GIO_KET_THUC') * 3600000, con = phut * 60000;
  for (var day = Math.floor((a + off) / 86400000); day < Math.floor((a + off) / 86400000) + 400; day++) {
    var d0 = day * 86400000 - off, x = Math.max(a, d0 + gs), y = d0 + ge;
    if (y > x) { if (y - x >= con) return x + con; con -= y - x; }
  }
  return a;
}
/* Giờ hạn của khách theo trạng thái hiện tại */
function han_(k) {
  if (laKhac_(k)) return null;   // data telesale / dự án khác: không có hạn, không thu hồi
  var st = k.trang_thai, ngay = phutMotNgay();
  if (st === 'cho_nhan') return {viec: 'bấm Nhận', luc: hanLuc(k.luc_giao, num('HAN_NHAN_PHUT'))};
  if (st === 'da_nhan') return {viec: 'báo cáo', luc: hanLuc(k.luc_nhan, num('HAN_BAO_CAO_PHUT'))};
  if (st === 'dang_cham') return {viec: 'lên Hẹn gặp / Khách nóng / Đã chốt', luc: hanLuc(k.luc_nhan, hanCD_(k))};
  if (st === 'chuyen_doi') return {viec: 'cập nhật báo cáo', luc: hanLuc(k.luc_bao_cao || k.luc_nhan, num('NONG_THU_HOI_NGAY') * ngay)};
  if (st === 'cho_ly_do') return {viec: 'gõ lý do đóng', luc: hanLuc(k.luc_bao_cao, num('HAN_BAO_CAO_PHUT'))};
  return null;
}
function dongHan_(k) { var h = han_(k); return h ? '⏱ Hạn ' + h.viec + ': <b>trước ' + fmt(h.luc) + '</b>. Sau thời gian trên sẽ bị thu hồi.' : ''; }
/* Số phút làm việc để chuyển đổi, đã cộng phần gia hạn */
function hanCD_(k) { return (num('HAN_CHUYEN_DOI_NGAY') + Number(k.gia_han || 0) * num('GIA_HAN_NGAY')) * phutMotNgay(); }
function conGiaHan_(k) { return Number(k.gia_han || 0) < num('SO_LAN_GIA_HAN'); }
function nutGiaHan_(k) { return conGiaHan_(k) ? [[{text: '⏳ Xin gia hạn ' + num('GIA_HAN_NGAY') + ' ngày', callback_data: 'gh:' + k.id}]] : null; }
function phutMotNgay() { return (num('GIO_KET_THUC') - num('GIO_BAT_DAU')) * 60; }
function che(sdt) { sdt = String(sdt || ''); return sdt.length >= 8 ? sdt.slice(0, 4) + ' ••• ' + sdt.slice(-3) : '•••'; }
function esc(s) { return String(s == null ? '' : s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;'); }
function dsCfg_(k) { return String(cfg(k) || '').toLowerCase().split(',').map(function (x) { return x.trim(); }).filter(String); }
function laKhac_(k) { return k.nhom === 'khac'; }
/* Số thử: tách theo mọi ký tự không phải số (dấu phẩy, chấm phẩy, khoảng trắng…) */
function laSoThu_(sdt) { sdt = normPhone(sdt); return !!sdt && String(cfg('SO_THU') || '').split(/[^\d+]+/).some(function (x) { return x && normPhone(x) === sdt; }); }
/* Khách thuộc nhóm FourS/Saphia nếu trang, nhu cầu hoặc nguồn có chữ trong NHOM_RIENG */
function laNhomRieng_(chu) { chu = String(chu || '').toLowerCase().replace(/\s+/g, ''); return dsCfg_('NHOM_RIENG').some(function (x) { return chu.indexOf(x.replace(/\s+/g, '')) > -1; }); }
function normPhone(p) { p = String(p == null ? '' : p).replace(/\D/g, ''); if (p.indexOf('84') === 0 && p.length === 11) p = '0' + p.slice(2); if (p.length === 9) p = '0' + p; return p; }

/* ======================= SHEET ======================= */
function ss_() { return SpreadsheetApp.getActiveSpreadsheet(); }
function tab_(name, head) {
  var sh = ss_().getSheetByName(name);
  if (!sh) {
    sh = ss_().insertSheet(name);
    if (head) { sh.getRange(1, 1, 1, head.length).setValues([head]); sh.setFrozenRows(1); }
  }
  return sh;
}
function rows_(name, head) {
  var sh = tab_(name, head), n = sh.getLastRow(), list = [];
  if (n > 1) sh.getRange(2, 1, n - 1, head.length).getValues().forEach(function (r, i) {
    var o = {_r: i + 2}; head.forEach(function (h, j) { o[h] = r[j]; });
    if (o.hasOwnProperty('sdt')) o.sdt = normPhone(o.sdt);   // Sheet hay tự bỏ số 0 đầu
    list.push(o);
  });
  return list;
}
function save_(name, head, o) {
  /* ' giữ nguyên chữ: số 0 đầu của SĐT; danh sách mã sale "123,456" (Sheet tiếng Việt hiểu dấu phẩy là số thập phân) */
  var sh = tab_(name, head), v = [head.map(function (h) { return o[h] == null ? '' : ((h === 'sdt' || h === 'da_qua') && o[h] !== '' ? "'" + o[h] : o[h]); })];
  if (o._r) sh.getRange(o._r, 1, 1, head.length).setValues(v);
  else { sh.appendRow(v[0]); o._r = sh.getLastRow(); }
}
/* Tab CauHinh chỉ đọc 1 lần mỗi lần chạy (trước đây đọc hàng trăm lần → bot chạy lâu, Google tạm dừng vì quá hạn mức 90 phút/ngày) */
var CH_NHO_ = null;
function tabMap_(name) {
  if (name === 'CauHinh' && CH_NHO_) return CH_NHO_;
  var sh = tab_(name, ['khoa', 'gia_tri', 'ghi_chu']), n = sh.getLastRow(), m = {};
  if (n > 1) sh.getRange(2, 1, n - 1, 2).getValues().forEach(function (r) { if (r[0]) m[String(r[0]).trim()] = r[1]; });
  if (name === 'CauHinh') CH_NHO_ = m;
  return m;
}
/* Chữ bắt đầu bằng = + - @ thì Sheet hiểu là công thức (#ERROR!): thêm dấu ' để giữ nguyên chữ */
function chu_(x) { x = x == null ? '' : x; return typeof x === 'string' && /^[=+\-@]/.test(x) ? "'" + x : x; }
function log_(nguoi, hd, khach, ct) { tab_('NhatKy', T_NK).appendRow([nowD(), chu_(nguoi), chu_(hd), chu_(khach), chu_(ct)]); }

/* ======================= TELEGRAM ======================= */
function tg_(method, payload) {
  var token = P().getProperty('BOT_TOKEN'); if (!token) throw new Error('Chưa có BOT_TOKEN');
  var r = UrlFetchApp.fetch('https://api.telegram.org/bot' + token + '/' + method, {
    method: 'post', contentType: 'application/json', muteHttpExceptions: true, payload: JSON.stringify(payload || {})
  });
  try { return JSON.parse(r.getContentText()); } catch (e) { return {ok: false}; }
}
function gui_(chat, text, nut, im) {
  var p = {chat_id: chat, text: text, parse_mode: 'HTML', disable_web_page_preview: true, protect_content: true};
  if (nut) p.reply_markup = {inline_keyboard: nut};
  if (im) p.disable_notification = true;
  var r = tg_('sendMessage', p); return r && r.ok ? r.result.message_id : '';
}
function sua_(chat, msgId, text, nut) {
  if (!msgId) return;
  var p = {chat_id: chat, message_id: Number(msgId), text: text, parse_mode: 'HTML', disable_web_page_preview: true};
  p.reply_markup = {inline_keyboard: nut || []};
  tg_('editMessageText', p);
}
function nhac_(k, text, nut) {
  var p = {chat_id: k.nguoi_giu, text: text, parse_mode: 'HTML', protect_content: true};
  if (nut) p.reply_markup = {inline_keyboard: nut};
  if (k.msg_id) p.reply_to_message_id = Number(k.msg_id);
  tg_('sendMessage', p);
}
/* Lệnh /tailieu: 2 nhóm slide – chủ đầu tư (gửi khách được) và nội bộ (chỉ đội sale) */
function taiLieu_(chat) {
  var cdt = cfg('SLIDE_CDT'), nb = cfg('SLIDE_NOI_BO'), nut = [];
  if (cdt) nut.push([{text: '📊 Slide chủ đầu tư (gửi khách)', url: cdt}]);
  if (nb) nut.push([{text: '🔒 Slide nội bộ (đào tạo sale)', url: nb}]);
  gui_(chat, '<b>📁 Tài liệu Sun Saphia</b>\n\n'
    + '📊 <b>Slide chủ đầu tư</b> – thị trường, sản phẩm, giá tham khảo, dòng tiền, bản đồ giá thuê. Gửi link cho khách được.\n\n'
    + '🔒 <b>Slide nội bộ</b> – kịch bản tư vấn, 3 khách mẫu, xử lý từ chối, tin nhắn Zalo mẫu. <b>Không gửi khách.</b> Lần đầu mở: nhập tên và số Zalo của bạn.\n\n'
    + 'Trong trang: bấm ▶ Trình chiếu để chiếu toàn màn hình, ⬇ Tải về để lưu PDF.', nut.length ? nut : null);
}
function coNhac_(k, f) { return String(k.nhac || '').split(',').indexOf(f) > -1; }
function datNhac_(k, f) { var l = String(k.nhac || '').split(',').filter(String); if (l.indexOf(f) < 0) l.push(f); k.nhac = l.join(','); }
function boNhac_(k, f) { k.nhac = String(k.nhac || '').split(',').filter(function (x) { return x && x !== f; }).join(','); }
function quanLy_() { return P().getProperty('QUAN_LY_ID'); }
function baoQL_(text, nut) { var q = quanLy_(); if (q) gui_(q, text, nut); }

/* ======================= CÀI ĐẶT ======================= */
/* Dán 2 thứ vào giữa dấu nháy rồi chạy hàm caiDat (quản lý nhắn bot 1 tin bất kỳ trước khi chạy lần đầu) */
var BOT_TOKEN_DAN_VAO_DAY = 'DÁN_MÃ_BOT_CHIA_KHÁCH_VÀO_ĐÂY';
var LINK_SHEET_CRM_DAN_VAO_DAY = 'DÁN_LINK_SHEET_CRM_HOÀNG_HIỆP_VÀO_ĐÂY';
function caiDat() {
  CH_NHO_ = null;
  if (BOT_TOKEN_DAN_VAO_DAY.indexOf('DÁN_') !== 0) P().setProperty('BOT_TOKEN', BOT_TOKEN_DAN_VAO_DAY);
  if (!P().getProperty('BOT_TOKEN')) throw new Error('Chưa dán mã bot vào dòng BOT_TOKEN_DAN_VAO_DAY');
  tg_('deleteWebhook', {});
  var me = tg_('getMe', {}); if (!me.ok) throw new Error('Mã bot chưa đúng, copy lại từ BotFather');
  /* Đổi sang bot mới: bỏ vị trí đọc tin của bot cũ */
  if (P().getProperty('BOT_ID') && P().getProperty('BOT_ID') !== String(me.result.id)) P().deleteProperty('OFFSET');
  P().setProperty('BOT_ID', String(me.result.id));
  /* Lần đầu: người nhắn bot gần nhất là quản lý. Chạy lại: giữ nguyên quản lý cũ. */
  if (!quanLy_()) {
    var r = tg_('getUpdates', {timeout: 0});
    var msgs = (r.result || []).filter(function (u) { return u.message && u.message.chat; });
    if (!msgs.length) throw new Error('Quản lý mở bot @' + me.result.username + ' trên Telegram, bấm Start, nhắn 1 tin rồi chạy lại');
    var last = msgs[msgs.length - 1];
    P().setProperty('QUAN_LY_ID', String(last.message.chat.id));
    P().setProperty('OFFSET', String(last.update_id + 1));
  }
  var sh = tab_('CauHinh', ['khoa', 'gia_tri', 'ghi_chu']);
  if (sh.getLastRow() < 2) Object.keys(MAC_DINH).forEach(function (k) { sh.appendRow([k, MAC_DINH[k], '']); });
  [['Sale', T_SALE], ['Khach', T_KHACH], ['NhatKy', T_NK]].forEach(function (x) { tab_(x[0], x[1]).getRange(1, 1, 1, x[1].length).setValues([x[1]]); });
  var hc = tabMap_('CauHinh'); Object.keys(MAC_DINH).forEach(function (k) { if (!hc.hasOwnProperty(k)) sh.appendRow([k, MAC_DINH[k], '']); });
  if (LINK_SHEET_CRM_DAN_VAO_DAY.indexOf('DÁN_') !== 0) {
    var m = LINK_SHEET_CRM_DAN_VAO_DAY.match(/\/d\/([a-zA-Z0-9_-]+)/), crmId = m ? m[1] : LINK_SHEET_CRM_DAN_VAO_DAY.trim();
    var rowsCH = sh.getRange(2, 1, sh.getLastRow() - 1, 1).getValues();
    for (var i = 0; i < rowsCH.length; i++) if (rowsCH[i][0] === 'CRM_SHEET_ID') sh.getRange(i + 2, 2).setValue(crmId);
  }
  CH_NHO_ = null;   // vừa ghi CauHinh: đọc lại
  if (!cfg('CRM_SHEET_ID')) throw new Error('Chưa dán link Sheet CRM vào dòng LINK_SHEET_CRM_DAN_VAO_DAY');
  try { SpreadsheetApp.openById(cfg('CRM_SHEET_ID')).getSheetByName(cfg('CRM_TAB')).getLastRow(); }
  catch (e) { throw new Error('Không mở được Sheet CRM hoặc tab "' + cfg('CRM_TAB') + '". Kiểm tra link và dùng đúng tài khoản Google đang giữ Sheet CRM.'); }
  if (!P().getProperty('DA_XEM')) ghiNhanKhachCu_();
  ScriptApp.getProjectTriggers().forEach(function (t) { ScriptApp.deleteTrigger(t); });
  ScriptApp.newTrigger('chayMoiPhut').timeBased().everyMinutes(1).create();
  ScriptApp.newTrigger('baoCaoToi').timeBased().atHour(num('GIO_BAO_CAO_TOI')).nearMinute(10).everyDays(1).inTimezone('Asia/Ho_Chi_Minh').create();
  ScriptApp.newTrigger('baoCaoTuan').timeBased().onWeekDay(ScriptApp.WeekDay.MONDAY).atHour(8).nearMinute(5).inTimezone('Asia/Ho_Chi_Minh').create();
  P().setProperty('BOT_USERNAME', me.result.username || '');
  var daGui = gui_(quanLy_(), '✅ Bot chia khách đã chạy. Anh là <b>quản lý</b>.\nSale nhắn bot: <code>/dangky Tên</code> để xin vào đội, anh bấm Duyệt.\nLệnh: /sale · /baocao · /tuan · /tam Tên · /mo Tên · /xoa Tên');
  log_('hệ thống', 'cài đặt', '', 'quản lý ' + quanLy_() + ' · bot @' + me.result.username);
  kiemTra(daGui ? 'đã gửi tin cài đặt' : '');
}

/* Danh sách lệnh hiện ra khi gõ dấu / trong Telegram: sale thấy lệnh sale, quản lý thấy lệnh quản lý */
function datLenh_() {
  var sale = [{command: 'khach', description: 'Khách đang giữ và giờ hạn'}, {command: 'giahan', description: 'Xin thêm 1 ngày: /giahan K12'},
    {command: 'nghi', description: 'Tạm ngưng nhận khách'}, {command: 'lam', description: 'Nhận khách trở lại'}, {command: 'dangky', description: 'Xin vào đội: /dangky Tên'}];
  var ql = [{command: 'them', description: 'Thêm khách: /them Số Tên - nhu cầu'}, {command: 'themkhac', description: 'Khách dự án khác (không tính lượt FourS/Saphia)'}, {command: 'huy', description: 'Huỷ khách thử, trả lượt: /huy K39'}, {command: 'chialai', description: 'Chia lại khách sang nhánh 2, 3…: /chialai K12'}, {command: 'sale', description: 'Danh sách đội'},
    {command: 'baocao', description: 'Báo cáo hôm nay'}, {command: 'tuan', description: 'Xếp hạng 7 ngày'}, {command: 'tam', description: 'Tạm dừng sale: /tam Tên'},
    {command: 'mo', description: 'Mở lại / duyệt sale: /mo Tên'}, {command: 'xoa', description: 'Sale nghỉ việc: /xoa Tên'}];
  var a = tg_('setMyCommands', {commands: sale});
  var b = quanLy_() ? tg_('setMyCommands', {commands: ql, scope: {type: 'chat', chat_id: Number(quanLy_())}}) : {ok: true};
  return a.ok && b.ok;
}

/* Chạy hàm này khi bot không trả lời: ghi tình trạng vào tab NhatKy (không ghi mã bot) */
function kiemTra(daGui) {
  var me = tg_('getMe', {}), ql = quanLy_(), kq = [];
  kq.push(me.ok ? 'bot @' + me.result.username + ' (link t.me/' + me.result.username + ')' : 'MÃ BOT SAI: ' + (me.description || 'không gọi được Telegram'));
  if (me.ok && ql) {
    var r = daGui ? {ok: true} : tg_('sendMessage', {chat_id: ql, text: '🔎 Kiểm tra bot: quản lý nhận được tin này là bot nhắn được cho anh.', protect_content: true});
    kq.push(r.ok ? 'nhắn quản lý ' + ql + ': OK' : 'KHÔNG nhắn được quản lý ' + ql + ': ' + (r.description || '') + ' → quản lý mở t.me/' + me.result.username + ' bấm Start');
  } else if (!ql) kq.push('chưa có quản lý');
  if (me.ok) kq.push(datLenh_() ? 'danh sách lệnh: đã cài' : 'danh sách lệnh: LỖI');
  var tr = ScriptApp.getProjectTriggers().map(function (t) { return t.getHandlerFunction(); });
  kq.push('trình kích hoạt: ' + (tr.length ? tr.join(', ') : 'KHÔNG CÓ → chạy caiDat'));
  if (me.ok) { var w = tg_('getWebhookInfo', {}); if (w.ok && w.result.url) kq.push('ĐANG CÓ WEBHOOK (bot khác đang dùng mã này): ' + w.result.url); if (w.ok) kq.push('tin chờ đọc: ' + (w.result.pending_update_count || 0)); }
  log_('hệ thống', 'kiểm tra', '', kq.join(' · '));
  return kq.join('\n');
}
/* Khách đã có sẵn trong CRM lúc cài đặt: đánh dấu đã xem, không chia lại */
function ghiNhanKhachCu_() {
  var seen = {}; layKhachCRM_().forEach(function (k) { seen[k.sdt] = Math.max(seen[k.sdt] || 0, k.so_lan); });
  P().setProperty('DA_XEM', JSON.stringify(seen));
}

/* ======================= VÒNG CHẠY MỖI PHÚT ======================= */
function chayMoiPhut() {
  var lock = LockService.getScriptLock(); if (!lock.tryLock(20000)) return;
  CH_NHO_ = null;   // đọc lại CauHinh mới nhất cho lần chạy này
  /* Nút bấm của sale được xử lý trước và xen giữa các việc nặng, để không phải chờ chia data xong */
  var bd = Date.now();
  try { capNhatTieuDe_(); xuLyTinNhan_(); nhanKhachMoi_(); xuLyTinNhan_(); nhapData_(bd + 25000); xuLyTinNhan_(); try { capTelesale_(); } catch (e) {} xuLyTinNhan_(); kiemTraHan_(); xuLyTinNhan_(); }
  finally { lock.releaseLock(); }
}

/* ======================= DATA TELESALE: CẤP THEO ĐỢT =======================
   File báo cáo riêng (không đụng lượt FourS/Saphia). Dòng 9 trở xuống: A Dự án | B SĐT | C Nhân sự | D Tình trạng | E Giao lúc | F Hạn.
   Bạn nào báo cáo hết số đang giữ (cột D đã điền) thì cấp thêm số tiếp theo trong kho (dòng chưa có tên), giữ đúng thứ tự.
   Chưa gọi xong thì không cấp thêm. Không thu hồi: khách nét bạn đó giữ luôn. */
function hanTele_(t) {
  var G = num('TELESALE_GIO_HAN'), d = new Date(t + 7 * 3600000), h = vnHour(t);
  function luc(x) { return Date.UTC(x.getUTCFullYear(), x.getUTCMonth(), x.getUTCDate(), G) - 7 * 3600000; }
  if (d.getUTCDay() === 0 || h >= G) {
    do { d = new Date(d.getTime() + 86400000); } while (d.getUTCDay() === 0);
    return luc(d);
  }
  var con = G - h;
  return luc(d) + (con < 1 ? 60 : con < 1.5 ? 30 : 0) * 60000;
}
var TT_TELE = ['Không nghe máy', 'Thuê bao / sai số', 'Gọi lại sau', 'Đã gọi – đang tư vấn', 'Quan tâm – đã gửi thông tin', 'Hẹn gặp / xem dự án', 'Không nhu cầu', 'Môi giới'];
function teleId_() { var id = String(cfg('TELESALE_SHEET_ID') || '').trim(), m = id.match(/\/d\/([a-zA-Z0-9_-]+)/); return m ? m[1] : id; }
function chuanTen_(x) { return String(x || '').toLowerCase().replace(/\s+/g, ' ').trim(); }
function nutTele_(tab, dong) {
  var n = TT_TELE.map(function (t, i) { return {text: t, callback_data: 'ts:' + tab + ':' + dong + ':' + i}; }), o = [];
  for (var i = 0; i < n.length; i += 2) o.push(n.slice(i, i + 2));
  return o;
}
function capTelesale_() {
  var id = teleId_(); if (!id) return;
  if (!trongGio(Date.now())) return;   // ngoài giờ làm việc không giao
  var ss; try { ss = SpreadsheetApp.openById(id); } catch (e) { return; }
  var bang = [], con = {}, kho = [];
  ss.getSheets().forEach(function (sh) {
    if (!/^data\s*\d+/i.test(sh.getName())) return;
    var n = sh.getLastRow(); if (n < 9) return;
    var v = sh.getRange(9, 1, n - 8, 6).getValues(), b = {sh: sh, v: v, doi: false}; bang.push(b);
    v.forEach(function (r, i) {
      var ten = String(r[2] || '').trim();
      if (ten) { con[ten] = (con[ten] || 0) + (String(r[3] || '').trim() ? 0 : 1); }
      else if (String(r[1] || '').replace(/\D/g, '').length >= 9) kho.push({b: b, i: i});
    });
  });
  /* 1. Ai đã báo cáo hết số đang giữ thì giao số tiếp trong kho (đúng thứ tự) */
  var xong = Object.keys(con).filter(function (t) { return con[t] === 0; });
  for (var i = xong.length - 1; i > 0; i--) { var j = Math.floor(Math.random() * (i + 1)), x = xong[i]; xong[i] = xong[j]; xong[j] = x; }
  var bay = Date.now(), han = hanTele_(bay), soThem = Math.max(1, num('TELESALE_THEM'));
  xong.forEach(function (ten) {
    var lay = kho.splice(0, soThem); if (!lay.length) return;
    lay.forEach(function (o) { var r = o.b.v[o.i]; r[2] = ten; r[4] = new Date(bay); r[5] = new Date(han); o.b.doi = true; });
    log_(ten, 'Giao data telesale', lay.length === 1 ? normPhone(lay[0].b.v[lay[0].i][1]) : '', lay.length + ' số, hạn ' + fmt(han));
  });
  bang.forEach(function (b) {
    if (!b.doi) return;
    b.sh.getRange(9, 3, b.v.length, 1).setValues(b.v.map(function (r) { return [r[2]]; }));
    b.sh.getRange(9, 5, b.v.length, 2).setValues(b.v.map(function (r) { return [r[4], r[5]]; }));
  });
  /* 2. Số đang giữ chưa báo cáo mà chưa nhắn sale thì nhắn kèm nút báo cáo (bấm là ghi thẳng vào file) */
  var daGui = JSON.parse(P().getProperty('TELESALE_DA_GUI') || '{}'), conGui = {}, sales = rows_('Sale', T_SALE);
  bang.forEach(function (b) {
    var tab = b.sh.getName();
    b.v.forEach(function (r, i) {
      var ten = String(r[2] || '').trim(); if (!ten || String(r[3] || '').trim()) return;
      var k = tab + '!' + (i + 9) + '!' + chuanTen_(ten);
      if (daGui[k]) { conGui[k] = 1; return; }
      var s = sales.filter(function (x) { return chuanTen_(x.ten) === chuanTen_(ten); })[0]; if (!s || !s.chat_id) return;
      var hn = r[5] instanceof Date ? r[5].getTime() : 0;
      gui_(s.chat_id, '📞 <b>Data telesale – số của bạn</b>\n📱 <b>' + esc(normPhone(r[1])) + '</b> · ' + esc(String(r[0] || '').trim()) + (hn ? '\n⏱ Hạn báo cáo: <b>trước ' + fmt(hn) + '</b>' : '') +
        '\nGọi xong bấm tình trạng bên dưới, bot tự ghi báo cáo và giao số tiếp.', nutTele_(tab, i + 9));
      conGui[k] = 1;
    });
  });
  P().setProperty('TELESALE_DA_GUI', JSON.stringify(conGui));
  if (!kho.length && !P().getProperty('TELESALE_HET')) {
    P().setProperty('TELESALE_HET', '1');
    baoQL_('📞 <b>Data telesale</b>: kho đã giao hết.\nDán thêm số vào cuối tab Data (để trống cột Nhân sự) là bot tự giao tiếp.');
  }
  if (kho.length) P().deleteProperty('TELESALE_HET');
}
/* Sale bấm nút tình trạng trên Telegram: ghi vào cột D file telesale rồi giao số tiếp ngay */
function bamTele_(q, parts, tl) {
  var s = timSale_(String(q.from.id)), tt = TT_TELE[Number(parts[3])], dong = Number(parts[2]);
  if (!s || !tt || !dong) return tl('Không hợp lệ');
  var ss; try { ss = SpreadsheetApp.openById(teleId_()); } catch (e) { return tl('Không mở được file'); }
  var sh = ss.getSheetByName(parts[1]); if (!sh) return tl('Không thấy tab ' + parts[1]);
  var r = sh.getRange(dong, 1, 1, 4).getValues()[0], sdt = esc(normPhone(r[1]));
  if (chuanTen_(r[2]) !== chuanTen_(s.ten)) { sua_(q.message.chat.id, q.message.message_id, '📱 ' + sdt + ' – số này không còn giao cho bạn.'); return tl('Số này không còn của bạn'); }
  if (String(r[3] || '').trim()) { sua_(q.message.chat.id, q.message.message_id, '📱 <b>' + sdt + '</b>\n✅ Đã báo cáo: <b>' + esc(r[3]) + '</b>'); return tl('Đã báo cáo rồi'); }
  sh.getRange(dong, 4).setValue(tt);
  sua_(q.message.chat.id, q.message.message_id, '📱 <b>' + sdt + '</b>\n✅ Đã báo cáo: <b>' + esc(tt) + '</b>');
  log_(s.ten, 'Báo cáo telesale', normPhone(r[1]), tt);
  tl('Đã ghi báo cáo');
  capTelesale_();
}

/* Bản cũ chưa có cột mới (nhom, luc_giao_khac): ghi thêm tiêu đề 1 lần */
function capNhatTieuDe_() {
  if (P().getProperty('TIEU_DE') === '6') return;
  /* Ghi link mở thẳng trình soạn code vào tab CauHinh (để lần sau dán code mới từ điện thoại) */
  var ch = tab_('CauHinh', ['khoa', 'gia_tri', 'ghi_chu']), link = 'https://script.google.com/d/' + ScriptApp.getScriptId() + '/edit';
  if (!tabMap_('CauHinh').hasOwnProperty('LINK_CODE')) { ch.appendRow(['LINK_CODE', link, 'Bấm để mở thẳng Apps Script, dán code mới']); CH_NHO_ = null; }
  [['Sale', T_SALE], ['Khach', T_KHACH], ['DaChia', T_DACHIA]].forEach(function (x) { tab_(x[0], x[1]).getRange(1, 1, 1, x[1].length).setValues([x[1]]); });
  var nd = tab_('NhapData'); if (!nd.getLastRow()) nd.getRange(1, 1).setValue(HD_NHAP);
  P().setProperty('TIEU_DE', '6');
}

/* --- khách mới từ CRM --- */
function layKhachCRM_() {
  var id = cfg('CRM_SHEET_ID'); if (!id) return [];
  var sh = SpreadsheetApp.openById(id).getSheetByName(cfg('CRM_TAB')); if (!sh) return [];
  var n = sh.getLastRow(); if (n < 2) return [];
  var w = Math.min(47, sh.getLastColumn()), loc = dsCfg_('LOC_TRANG'), da = dsCfg_('DU_AN_CHIA');
  return sh.getRange(2, 1, n - 1, w).getValues().map(function (r) {
    var gc = String(r[21] || ''), j = gc.lastIndexOf('| Gửi lại');   // khách gửi lại: lấy nội dung lần gửi mới nhất
    return {sdt: normPhone(r[3]), ten: String(r[2] || ''), luc: r[1], web: String(r[5] || ''), utm: [r[6], r[7]].filter(String).join(' / '),
      ghi_chu: (j > -1 ? gc.slice(j + 2) : gc).slice(0, 300), loai: String(r[39] || ''), trang: String(r[40] || ''), du_an: String(r[41] || ''),
      so_lan: Number(r[9]) || 1, gui_lai: String(r[46] || '')};
  }).filter(function (k) {
    if (k.sdt.length !== 10 || laSoThu_(k.sdt)) return false;
    var chu = (k.trang + ' ' + k.web).toLowerCase(), duAn = k.du_an.toLowerCase();
    /* 1. khách để số trên web, trang thuộc LOC_TRANG */
    if (k.loai === 'Website' && (!loc.length || loc.some(function (x) { return chu.indexOf(x) > -1; }))) return true;
    /* 2. khách cũ (dự án khác / data nhập) vừa gửi lại từ web, CRM đổi "Dự án quan tâm" sang dự án được chia */
    return !!k.gui_lai && da.some(function (x) { return duAn.indexOf(x) > -1; });
  });
}
function nhanKhachMoi_() {
  var seen = JSON.parse(P().getProperty('DA_XEM') || '{}'), moi = [], lai = [], doi = false, ds = layKhachCRM_();
  /* Lần đầu chạy luật mới (thêm khách cũ gửi lại): ghi nhận các dòng đang có, không chia */
  if (P().getProperty('CRM_LUAT') !== '2') {
    ds.forEach(function (k) { seen[k.sdt] = Math.max(Number(seen[k.sdt] || 0), k.so_lan); });
    P().setProperty('DA_XEM', JSON.stringify(seen)); P().setProperty('CRM_LUAT', '2'); ds = [];
  }
  ds.forEach(function (k) {
    var cu = Number(seen[k.sdt] || 0);
    if (!cu) { seen[k.sdt] = k.so_lan; moi.push(k); doi = true; }
    else if (k.so_lan > cu) { seen[k.sdt] = k.so_lan; lai.push(k); doi = true; }
  });
  if (doi) P().setProperty('DA_XEM', JSON.stringify(seen));
  /* Dự án khác: dòng mới trong Sheet DATA CHẠY GOOGLE; 1 số gửi form nhiều lần liền chỉ tính 1 khách */
  var khac = layKhachKhac_(), soMoi = {};
  moi.forEach(function (c) { soMoi[c.sdt] = c; });
  khac.forEach(function (c) {
    var cu = soMoi[c.sdt];
    if (!cu) { soMoi[c.sdt] = c; moi.push(c); doi = true; }
    else if (cu.nhom === 'khac' && c.ghi_chu && String(cu.ghi_chu).indexOf(c.ghi_chu) < 0) cu.ghi_chu = [cu.ghi_chu, c.ghi_chu].filter(String).join(' · ').slice(0, 200);
  });
  if (!doi) return;
  /* Khách cũ gửi lại: về đúng người đang chăm, không chia mới */
  var tatCa = rows_('Khach', T_KHACH);
  lai.forEach(function (c) {
    var k = tatCa.filter(function (x) { return x.sdt === c.sdt; }).pop();
    if (k && (DANG_GIU.test(k.trang_thai) || k.trang_thai === 'chot') && k.nguoi_giu) {
      k.so_lan_gui = c.so_lan; save_('Khach', T_KHACH, k);
      nhac_(k, '🔁 <b>Khách ' + esc(k.id) + ' vừa liên hệ lại</b> trên web' + (c.ghi_chu ? ' (' + esc(c.ghi_chu.slice(0, 120)) + ')' : '') + '. Liên hệ ngay giúp nhé.');
      log_(k.ten_sale, 'khách quay lại', k.id, 'lần ' + c.so_lan);
    } else if (k && /cho_quan_ly|cho_giao/.test(k.trang_thai)) {
      baoQL_('🔁 Khách ' + esc(k.id) + ' (đang chờ chia) vừa liên hệ lại.');
    } else moi.push(c);
  });
  if (!moi.length) return;
  var dem = Number(P().getProperty('DEM') || 0);
  moi = moi.filter(function (c) {
    var k = tatCa.filter(function (x) { return x.sdt === c.sdt && (DANG_GIU.test(x.trang_thai) || x.trang_thai === 'chot') && x.nguoi_giu; }).pop();
    if (!k) return true;
    nhac_(k, '🔁 <b>Khách ' + esc(k.id) + ' vừa để lại thông tin</b> trên web' + (c.ghi_chu ? ' (' + esc(c.ghi_chu.slice(0, 120)) + ')' : '') + '. Liên hệ ngay giúp nhé.');
    log_(k.ten_sale, 'khách quay lại', k.id, 'web'); return false;
  });
  /* Không tự chia: báo quản lý từng khách kèm nút, bấm mới chia */
  if (!Number(cfg('TU_CHIA'))) {
    var cho = JSON.parse(P().getProperty('CHO_THEM') || '{}');
    moi.forEach(function (c) {
      var nc = [c.du_an, c.ghi_chu].filter(String).join(' · ');
      cho[c.sdt] = {ten: String(c.ten || '').slice(0, 60), nc: nc.slice(0, 200), nguon: String(c.utm || c.web || '').slice(0, 100), trang: String(c.trang || '').slice(0, 200), nhom: c.nhom || '', luc: Date.now()};
      baoQL_('🆕 <b>Khách mới đổ về – chưa chia</b>' + (c.nhom === 'khac' ? ' (dự án khác)' : '') + '\n👤 ' + esc(c.ten || '(không tên)') + ' · 📱 ' + esc(c.sdt) +
        (nc ? '\n📝 ' + esc(nc.slice(0, 150)) : '') + (c.trang ? '\n🌐 ' + esc(String(c.trang).slice(0, 80)) : '') +
        '\nBấm nút để chia, hoặc gõ /them.', [[{text: '➕ Chia khách này', callback_data: 'tm:' + c.sdt}]]);
      log_('hệ thống', 'khách mới chờ quản lý chia', '', che(c.sdt));
    });
    var ks = Object.keys(cho).sort(function (a, b) { return cho[b].luc - cho[a].luc; });
    ks.slice(40).forEach(function (k) { delete cho[k]; });
    P().setProperty('CHO_THEM', JSON.stringify(cho));
    return;
  }
  moi.forEach(function (c) {
    dem++;
    var k = {id: 'K' + dem, luc_vao: nowD(), ten: c.ten, sdt: c.sdt, nhu_cau: [c.du_an, c.ghi_chu].filter(String).join(' · '),
      nguon: c.utm || c.web, trang: c.trang, trang_thai: 'moi', da_qua: '', so_luot: 0, so_bao_cao: 0, nhom: c.nhom || ''};
    save_('Khach', T_KHACH, k); log_('hệ thống', 'khách mới', k.id, che(k.sdt));
    giao_(k);
  });
  P().setProperty('DEM', String(dem));
}
/* --- khách dự án khác: các tab trong Sheet DATA CHẠY GOOGLE ---
   Mỗi tab 1 dự án, mỗi dòng 1 lần gửi form: cột A giờ, cột B tên, các cột sau lẫn lộn SĐT / email / ghi chú / link trang.
   Chỉ đọc dòng mới thêm (nhớ số dòng đã đọc của từng tab). Lần đầu hoặc tab mới: chỉ ghi nhận, không chia data cũ. */
var TAB_HE_THONG = /^(TONG_HOP|UPLOAD_|CRM_|SAN_PHAM)/i;
function layKhachKhac_() {
  var id = String(cfg('NGUON_KHAC_SHEET_ID') || '').trim(); if (!id) return [];
  /* Quét 16 tab tốn thời gian: 5 phút mới quét 1 lần */
  var lucQuet = Number(P().getProperty('LUC_QUET_KHAC') || 0); if (Date.now() - lucQuet < 5 * 60000) return [];
  P().setProperty('LUC_QUET_KHAC', String(Date.now()));
  var m = id.match(/\/d\/([a-zA-Z0-9_-]+)/); if (m) id = m[1];
  var ss; try { ss = SpreadsheetApp.openById(id); } catch (e) { return []; }
  var chon = dsCfg_('NGUON_KHAC_TAB'), dauTien = !P().getProperty('DA_XEM_KHAC');
  var mark = JSON.parse(P().getProperty('DA_XEM_KHAC') || '{}'), ra = [], doi = dauTien;
  ss.getSheets().forEach(function (sh) {
    var ten = sh.getName();
    if (chon.length ? chon.indexOf(ten.toLowerCase().trim()) < 0 : TAB_HE_THONG.test(ten)) return;
    var n = sh.getLastRow(), cu = mark[ten];
    if (dauTien || cu == null || n < cu) { mark[ten] = n; doi = true; return; }
    if (n === cu) return;
    var w = Math.max(1, Math.min(12, sh.getLastColumn()));
    sh.getRange(cu + 1, 1, n - cu, w).getValues().forEach(function (r) { var c = docDongKhac_(r, ten); if (c) ra.push(c); });
    mark[ten] = n; doi = true;
  });
  if (doi) P().setProperty('DA_XEM_KHAC', JSON.stringify(mark));
  return ra;
}
function docDongKhac_(r, tab) {
  var sdt = '', url = '', ghi = [], nguon = '';
  for (var i = 2; i < r.length; i++) {
    var x = String(r[i] == null ? '' : r[i]).trim(); if (!x) continue;
    var p = normPhone(x);
    if (!sdt && /^[\d\s.+\-()]+$/.test(x) && /^0[1-9]\d{8}$/.test(p)) sdt = p;
    else if (/^https?:\/\//i.test(x)) { if (!url) url = x; }
    else if (x.indexOf('@') > -1) continue;
    else if (/^[a-z0-9.-]+\.(com|vn|net|org|ai)$/i.test(x)) nguon = x;
    else ghi.push(x);
  }
  if (!sdt) return null;
  /* Khách FourS / Saphia đã có đường riêng (CRM, /them): bỏ qua để không chia trùng */
  if (laNhomRieng_(tab + ' ' + url)) return null;
  if (!nguon && url) {
    var u = url.match(/[?&]utm_source=([^&#]+)/i);
    nguon = u ? decodeURIComponent(u[1]) : (/[?&](gclid|gad_source|gbraid|wbraid)=/i.test(url) ? 'Google Ads' : (/[?&]fbclid=/i.test(url) ? 'Facebook' : 'Website'));
  }
  return {sdt: sdt, ten: String(r[1] || '').trim().slice(0, 60), du_an: 'Dự án: ' + tab, ghi_chu: ghi.join(' · ').slice(0, 200),
    utm: nguon, web: url, trang: url.split('?')[0].slice(0, 200), nhom: 'khac', so_lan: 1};
}

/* --- tab NhapData: quản lý dán data, bot chia dần ---
   Dán kiểu gì cũng được: copy nguyên dòng thô từ tab dự án (giờ | tên | email/SĐT lẫn lộn | link web | IP | FORM…)
   hoặc gọn: Tên | SĐT | Dự án | Ghi chú. Bot tự tìm SĐT, tên, dự án (theo link web), ghi chú.
   Xử lý xong dòng nào thì chuyển dòng đó sang tab DaChia kèm kết quả. Mỗi phút tối đa 10 dòng / 25 giây.
   Khách chia kiểu dự án khác: vòng riêng, giới hạn riêng, không ảnh hưởng FourS / Saphia. */
var TEN_DU_AN = {'sun-danangdowntown': 'Downtown', 'sun-spanatower': 'Spana Tower', 'cora-tower': 'Cora Tower', 'fpt-city': 'FPT City',
  'filmore-danang': 'Filmore', 'legend-city-danang': 'Legend City', 'peninsula-danang': 'Peninsula', 'masteri-riveradanang': 'Masteri',
  'mia-plaza': 'Mia Plaza', 'hiyori-aquatower': 'Hiyori', 'estuarydanang': 'Estuary', 'fusiondanang': 'Fusion', 'sun-fours-tower': 'FourS Tower',
  'sun-saphia-residence': 'Sun Saphia'};
function duAnTuLink_(url) {
  var d = String(url).replace(/^https?:\/\/(www\.)?/i, '').split(/[\/?#]/)[0].toLowerCase(); if (!d) return '';
  var g = d.replace(/\.(com|vn|net|org)(\.vn)?$/, ''); return TEN_DU_AN[g] || d;
}
function docDongNhap_(r) {
  var sdt = '', ten = '', url = '', ghi = [];
  r.forEach(function (o) {
    if (o instanceof Date) return;
    var x = String(o == null ? '' : o).trim(); if (!x) return;
    if (/^\d{4}-\d{1,2}-\d{1,2}([ T]\d{1,2}:\d{2}(:\d{2})?)?$/.test(x) || /^\d{1,2}\/\d{1,2}\/\d{2,4}( \d{1,2}:\d{2}(:\d{2})?)?$/.test(x)) return;  // ngày giờ
    if (/^\d{1,3}(\.\d{1,3}){3}$/.test(x) || /^FORM\d*$/i.test(x) || x.indexOf('@') > -1) return;                       // IP, mã form, email
    if (/^https?:\/\//i.test(x)) { if (!url) url = x; return; }
    if (/^[a-z0-9.-]+\.(com|vn|net|org|ai)$/i.test(x)) return;                                                         // chatgpt.com…
    var p = normPhone(x);
    if (/^[\d\s.+\-()']+$/.test(x) && /^0[1-9]\d{8}$/.test(p)) { if (!sdt) sdt = p; return; }
    if (!ten) ten = x; else if (ghi.indexOf(x) < 0) ghi.push(x);
  });
  var da = url ? duAnTuLink_(url) : '';
  if (!da && ghi.length && ghi[0].length <= 30) da = ghi.shift();   // kiểu gọn: cột thứ 3 là dự án
  return {sdt: sdt, ten: ten.slice(0, 60), du_an: da, ghi_chu: ghi.join(' · ').slice(0, 200)};
}
function nhapData_(han) {
  han = han || Date.now() + 25000;   // mỗi phút chỉ chia data tối đa ~25 giây, phần còn lại để phút sau
  var sh = tab_('NhapData'), n = sh.getLastRow(); if (!n) { sh.getRange(1, 1).setValue(HD_NHAP); return; }
  var w = Math.max(1, Math.min(26, sh.getLastColumn())), v = sh.getRange(1, 1, n, w).getValues();
  var dc = tab_('DaChia', T_DACHIA), xong = [], tatCa = null, lam = 0, dem = Number(P().getProperty('DEM') || 0);
  for (var i = 0; i < v.length && lam < 10 && Date.now() < han; i++) {
    var r = v[i];
    if (lam && lam % 3 === 0) xuLyTinNhan_();   // xen kẽ xử lý nút bấm
    if (!r.some(function (x) { return String(x).trim(); }) || String(r[0]).indexOf('⬇️') === 0) continue;
    lam++; tatCa = tatCa || rows_('Khach', T_KHACH);
    var c = docDongNhap_(r), kq;
    if (!c.sdt) kq = '❌ Không thấy số điện thoại hợp lệ';
    else {
      var cu = tatCa.filter(function (x) { return x.sdt === c.sdt && (DANG_GIU.test(x.trang_thai) || /chot|cho_giao|cho_quan_ly/.test(x.trang_thai)); }).pop();
      if (cu) kq = '⚠️ Trùng ' + cu.id + (cu.ten_sale ? ' – ' + cu.ten_sale + ' đang giữ' : ' (đang chờ giao)') + ', không chia';
      else {
        dem++; P().setProperty('DEM', String(dem));
        var k = {id: 'K' + dem, luc_vao: nowD(), ten: c.ten, sdt: c.sdt, nhu_cau: [c.du_an ? 'Dự án: ' + c.du_an : '', c.ghi_chu].filter(String).join(' · ').slice(0, 200),
          nguon: 'Data telesale', trang: '', trang_thai: 'moi', da_qua: '', so_luot: 0, so_bao_cao: 0, nhom: 'khac'};
        save_('Khach', T_KHACH, k); log_('quản lý', 'nhập data', k.id, che(c.sdt)); tatCa.push(k);
        giao_(k);
        kq = '✅ ' + k.id + (k.trang_thai === 'cho_nhan' ? ' → ' + k.ten_sale : k.trang_thai === 'cho_giao' ? ' chờ giao (sale đang đủ khách, tự giao khi có người báo cáo)' : ' chuyển quản lý');
      }
    }
    dc.appendRow([kq, nowD()].concat(r.map(function (x) { return typeof x === 'string' && /^0\d{8,}$/.test(x) ? "'" + x : x; })));
    xong.push(i + 1);
  }
  for (var j = xong.length - 1; j >= 0; j--) sh.deleteRow(xong[j]);
  if (!sh.getLastRow()) sh.getRange(1, 1).setValue(HD_NHAP);
}

/* Thêm khách bằng tay để thử: themKhachThu() */
/* Quản lý thêm khách bằng tay.
   Mỗi dòng có số = 1 khách ("Số Tên - nhu cầu"). Dòng không có số ngay dưới = chi tiết của khách đó
   (dán nguyên tin báo khách: "Quan tâm:", "Nguồn:", "Trang:" được đọc riêng; dòng tiêu đề, giờ bị bỏ qua). */
var SO_RE = /(\+?84|0)[\d .\-]{8,13}\d/;
function sachChu_(x) { return String(x || '').replace(/[\u{1F000}-\u{1FAFF}\u{2600}-\u{27BF}\u{2B00}-\u{2BFF}\u{FE0F}\u{200D}]/gu, ' ').replace(/Mở Zalo/gi, ' ').replace(/\s+/g, ' ').replace(/^[\s\-–—·•:,|/]+|[\s\-–—·•:,|/]+$/g, '').trim(); }
/* /them: khách FourS/Saphia (hoặc không ghi trang) · /themkhac: khách dự án khác (xoay vòng riêng) */
function themKhachTay_(txt, ep) {
  var dong = String(txt || '').split(/\n+/).map(function (x) { return x.trim(); }).filter(String);
  if (!dong.length) return 'Gõ: <code>/them 0905123456 Tên khách - nhu cầu</code>\nNhiều khách: mỗi khách 1 dòng ngay dưới chữ /them. Dán nguyên tin báo khách cũng được.\nKhách dự án khác (không tính lượt FourS/Saphia): <code>/themkhac 0905123456 Tên - Downtown</code>';
  var ds = [], kq = [];
  dong.forEach(function (d) {
    var m = d.match(SO_RE), sdt = m ? normPhone(m[0]) : '';
    if (m && sdt.length === 10) {
      var ten, nc = '';
      var truoc = sachChu_(d.slice(0, d.indexOf(m[0]))), sau = d.slice(d.indexOf(m[0]) + m[0].length), k2 = sau.indexOf(' - ');
      ten = sachChu_(k2 > -1 ? sau.slice(0, k2) : sau) || truoc; nc = k2 > -1 ? sachChu_(sau.slice(k2 + 3)) : '';
      ds.push({sdt: sdt, ten: ten, nc: nc ? [nc] : [], nguon: '', trang: ''}); return;
    }
    var c = ds[ds.length - 1], x = sachChu_(d);
    if (!c) { if (m || /\d{6,}/.test(d)) kq.push('❌ Không thấy số hợp lệ: ' + esc(d.slice(0, 60))); return; }
    var kv = x.match(/^(Quan tâm|Nhu cầu|Ghi chú|Dự án|Nguồn|Trang|Web|Tên|Họ tên|Ngân sách)\s*:\s*(.*)$/i);
    if (kv) {
      var key = kv[1].toLowerCase();
      if (key === 'nguồn') c.nguon = kv[2]; else if (key === 'trang' || key === 'web') c.trang = kv[2];
      else if ((key === 'tên' || key === 'họ tên') && !c.ten) c.ten = kv[2]; else c.nc.push(kv[2]);
    } else if (x && !/^\d{1,2}:\d{2}(:\d{2})?\s+\d{1,2}\/\d{1,2}(\/\d{2,4})?$/.test(x)) c.nc.push(x);
  });
  var tatCa = rows_('Khach', T_KHACH), dem = Number(P().getProperty('DEM') || 0);
  ds.forEach(function (c) {
    var cu = tatCa.filter(function (x) { return x.sdt === c.sdt && (DANG_GIU.test(x.trang_thai) || /chot|cho_giao|cho_quan_ly/.test(x.trang_thai)); }).pop();
    if (cu) { kq.push('⚠️ ' + esc(che(c.sdt)) + ' đã có: ' + esc(cu.id) + (cu.ten_sale ? ' – ' + esc(cu.ten_sale) : '') + ' (' + esc(cu.trang_thai) + '), không thêm.'); return; }
    dem++; P().setProperty('DEM', String(dem));
    var nhom = ep === 'khac' ? 'khac' : (c.trang && !laNhomRieng_(c.trang + ' ' + c.nc.join(' ') + ' ' + c.nguon) ? 'khac' : '');
    var k = {id: 'K' + dem, luc_vao: nowD(), ten: c.ten.slice(0, 60), sdt: c.sdt, nhu_cau: c.nc.join(' · ').slice(0, 200), nguon: (c.nguon || 'quản lý thêm').slice(0, 100), trang: c.trang.slice(0, 200), trang_thai: 'moi', da_qua: '', so_luot: 0, so_bao_cao: 0, nhom: nhom};
    save_('Khach', T_KHACH, k); log_('quản lý', 'thêm khách', k.id, che(c.sdt)); tatCa.push(k);
    giao_(k);
    kq.push('✅ ' + esc(k.id) + ' ' + esc(che(c.sdt)) + (k.ten ? ' – ' + esc(k.ten) : '') + ': ' + (laKhac_(k) ? '(dự án khác) ' : '') + (k.trang_thai === 'cho_nhan' ? 'đã giao ' + esc(k.ten_sale) : k.trang_thai === 'cho_giao' ? 'đội đang bận, chờ giao' : 'chưa có sale nhận'));
  });
  if (!ds.length && !kq.length) kq.push('❌ Không thấy số điện thoại nào.');
  return '<b>Thêm khách</b>\n' + kq.join('\n');
}
function themKhachThu() { var k = {id: 'T' + Date.now() % 100000, luc_vao: nowD(), ten: 'Khách thử', sdt: '0900000000', nhu_cau: 'Thử hệ thống', nguon: 'thử', trang_thai: 'moi', da_qua: '', so_luot: 0, so_bao_cao: 0}; save_('Khach', T_KHACH, k); giao_(k); }

/* --- giao khách --- */
function salesDangLam_() { return rows_('Sale', T_SALE).filter(function (s) { return s.trang_thai === 'lam'; }); }
function dangGiu_(chat, re, nhom) {
  re = re || DANG_GIU;
  return rows_('Khach', T_KHACH).filter(function (k) { return String(k.nguoi_giu) === String(chat) && re.test(k.trang_thai) && (nhom == null || laKhac_(k) === (nhom === 'khac')); }).length;
}
/* Tin cho sale: không ghi ai giữ trước, không ghi giờ khách vào → sale không biết khách bị thu hồi từ ai */
function tinKhach_(k, day) {
  return '🔥 <b>KHÁCH ' + esc(k.id) + '</b>' + (k.ten ? ' – ' + esc(k.ten) : '') + '\n📞 ' + (day ? '<b>' + esc(k.sdt) + '</b> · <a href="https://zalo.me/' + esc(k.sdt) + '">Mở Zalo</a>' : esc(che(k.sdt)))
    + (k.nhu_cau ? '\n• Quan tâm: ' + esc(k.nhu_cau) : '') + (k.nguon ? '\n• Nguồn: ' + esc(k.nguon) : '') + '\n• Giao lúc: ' + fmt(k.luc_giao || k.luc_vao);
}
function nutBaoCao_(id) {
  return [[{text: '📞 ' + BC.goi, callback_data: 'b:' + id + ':goi'}, {text: '🔕 ' + BC.knm, callback_data: 'b:' + id + ':knm'}],
    [{text: '📅 ' + BC.hen, callback_data: 'b:' + id + ':hen'}, {text: '🔥 ' + BC.nong, callback_data: 'b:' + id + ':nong'}],
    [{text: '✅ ' + BC.cd, callback_data: 'b:' + id + ':cd'}, {text: '🚫 ' + BC.khong, callback_data: 'b:' + id + ':khong'}]];
}
/* Khách chia tay (mặc định: FourS): quản lý tự chọn sale */
function laChiaTay_(k) { var chu = [k.trang, k.nhu_cau, k.nguon].join(' ').toLowerCase().replace(/\s+/g, ''); return dsCfg_('CHIA_TAY').some(function (x) { x = x.replace(/\s+/g, ''); return x && chu.indexOf(x) > -1; }); }
function nutChonSale_(k) {
  var hang = [], dong = [];
  salesDangLam_().forEach(function (s) { dong.push({text: '👉 ' + String(s.ten).slice(0, 24), callback_data: 'gt:' + k.id + ':' + s.chat_id}); if (dong.length === 2) { hang.push(dong); dong = []; } });
  if (dong.length) hang.push(dong);
  return hang;
}
function choQuanLyChon_(k, lyDo) {
  k.trang_thai = 'cho_quan_ly'; k.nguoi_giu = ''; k.ten_sale = ''; save_('Khach', T_KHACH, k);
  var nut = nutChonSale_(k);
  baoQL_('🧑‍💼 <b>Khách FourS chờ anh chọn sale</b>' + (lyDo ? ' (' + esc(lyDo) + ')' : '') + ':\n' + tinKhach_(k, true) + (nut.length ? '\n\nBấm tên sale để giao:' : '\n\n⚠️ Chưa có sale nào đang làm.'), nut);
  log_('hệ thống', 'chờ quản lý chọn sale', k.id, lyDo || 'khách FourS');
}
/* Quản lý bấm chọn sale: giao thẳng cho người đó (không xét vòng, không xét lượt) */
function giaoTay_(k, s) {
  var t = nowD(), dem = trongGio(ms(t));
  k.trang_thai = 'cho_nhan'; k.nguoi_giu = String(s.chat_id); k.ten_sale = s.ten; k.luc_giao = t; k.luc_nhan = ''; k.luc_bao_cao = ''; k.bao_cao = ''; k.nhac = ''; k.ly_do_dong = ''; k.gia_han = 0;
  k.so_luot = Number(k.so_luot || 0) + 1;
  k.msg_id = gui_(s.chat_id, tinKhach_(k, false) + '\n• Quản lý giao trực tiếp\n\n' + dongHan_(k) + (dem ? '' : '\n(Ngoài giờ ' + num('GIO_BAT_DAU') + 'h–' + num('GIO_KET_THUC') + 'h không tính.)'),
    [[{text: '✅ Nhận khách', callback_data: 'n:' + k.id}]], !dem);
  save_('Khach', T_KHACH, k);
  s.luc_giao_cuoi = t; save_('Sale', T_SALE, s);
  log_(s.ten, 'được giao', k.id, 'lượt ' + k.so_luot + ' · quản lý chọn');
}
function giao_(k) {
  if (laChiaTay_(k) && !laKhac_(k)) { choQuanLyChon_(k, Number(k.so_luot) ? 'sale trước chưa nhận / bị thu hồi' : ''); return; }
  var qua = String(k.da_qua || '').split(',').filter(String), dangLam = salesDangLam_();
  var ung = dangLam.filter(function (s) { return qua.indexOf(String(s.chat_id)) < 0; });
  if (!ung.length || Number(k.so_luot) >= num('SO_LUOT_TOI_DA')) {
    k.trang_thai = 'cho_quan_ly'; k.nguoi_giu = ''; k.ten_sale = ''; save_('Khach', T_KHACH, k);
    baoQL_('⚠️ Không còn sale nhận ' + esc(k.id) + ', anh xử lý giúp:\n' + tinKhach_(k, true), [[{text: '🔁 Chia lại từ đầu', callback_data: 'cl:' + k.id}]]);
    log_('hệ thống', 'chuyển quản lý', k.id, 'hết sale / quá lượt'); return;
  }
  /* 2 nhóm tách hẳn: FourS/Saphia và dự án khác (data telesale). Chỉ đếm khách cùng nhóm, chỉ xét lượt cùng nhóm,
     nên data telesale không làm mất lượt và không chặn khách FourS/Saphia */
  var khac = laKhac_(k), lai = !khac && Number(k.nhanh || 1) >= 2, all = rows_('Khach', T_KHACH);
  var cot = khac ? 'luc_giao_khac' : (lai ? 'luc_giao_lai' : 'luc_giao_cuoi');
  function demGiu(chat, re) { return all.filter(function (x) { return x.id !== k.id && String(x.nguoi_giu) === String(chat) && re.test(x.trang_thai) && laKhac_(x) === khac; }).length; }
  /* Không ôm khách: ai đang có quá nhiều khách chưa báo cáo (cùng nhóm) thì tạm bỏ qua */
  var tran = num(khac ? 'TOI_DA_CHUA_BAO_CAO_KHAC' : 'TOI_DA_CHUA_BAO_CAO');
  var ranh = ung.filter(function (s) { return demGiu(s.chat_id, CHUA_BAO_CAO) < tran; });
  if (!ranh.length) {
    var cho = k.trang_thai === 'cho_giao'; k.trang_thai = 'cho_giao'; k.nguoi_giu = ''; k.ten_sale = ''; save_('Khach', T_KHACH, k);
    if (!cho && !khac) { baoQL_('⏳ Đội đang giữ nhiều khách chưa báo cáo, khách ' + esc(k.id) + ' đang chờ, sẽ tự giao khi có người rảnh.'); log_('hệ thống', 'chờ giao', k.id, 'đội quá tải'); }
    return;
  }
  ung = ranh;
  /* FourS/Saphia: chia theo VÒNG. Mỗi vòng mỗi sale nhận 1 khách; người nhận kế tiếp bốc ngẫu nhiên trong số
     người chưa nhận ở vòng đó. Ai cũng nhận xong thì sang vòng mới và báo quản lý.
     Nhánh 1 (khách mới) và nhánh 2+ (chia lại) có 2 vòng riêng, không ảnh hưởng nhau.
     Data telesale: ưu tiên người đang giữ ít khách hơn rồi tới người lâu chưa được giao. */
  var s, vongMoi = 0;
  if (khac) {
    ung.forEach(function (x, i) { x._giu = demGiu(x.chat_id, DANG_GIU); x._tt = i; });
    ung.sort(function (a, b) { return a._giu - b._giu || ms(a[cot]) - ms(b[cot]) || a._tt - b._tt; });
    s = ung[0];
  } else {
    var key = lai ? 'VONG_LAI' : 'VONG_MOI', vg = layVong_(key, dangLam);
    var chua = function (x) { return vg.da.indexOf(String(x.chat_id)) < 0; };
    var pool = ung.filter(chua), tinh = true;
    if (!pool.length) {
      /* Người chưa nhận vòng này mà chỉ bị loại riêng với khách này (đã từng giữ) → vòng chưa xong, giao thêm cho người khác */
      var conCho = dangLam.filter(function (x) { return chua(x) && demGiu(x.chat_id, CHUA_BAO_CAO) < tran; });
      if (conCho.length) tinh = false;
      else { vg.so = Number(vg.so || 1) + 1; vg.da = []; vongMoi = vg.so; }
      pool = ung;
    }
    s = pool[Math.floor(Math.random() * pool.length)];
    if (tinh) vg.da.push(String(s.chat_id));
    k._vong = vg.so;
    P().setProperty(key, JSON.stringify(vg));
    if (vongMoi) {
      baoQL_('🔄 Bắt đầu <b>vòng ' + vongMoi + '</b> ' + (lai ? 'chia lại (nhánh 2+)' : 'chia khách mới') + ': cả đội đã nhận đủ 1 khách vòng ' + (vongMoi - 1) + '.');
      log_('hệ thống', 'sang vòng mới', '', (lai ? 'chia lại' : 'khách mới') + ' · vòng ' + vongMoi);
    }
  }
  var t = nowD(), dem = trongGio(ms(t));
  k.trang_thai = 'cho_nhan'; k.nguoi_giu = String(s.chat_id); k.ten_sale = s.ten; k.luc_giao = t; k.luc_nhan = ''; k.luc_bao_cao = ''; k.bao_cao = ''; k.nhac = ''; k.ly_do_dong = ''; k.gia_han = 0;
  k.so_luot = Number(k.so_luot || 0) + 1;
  k.msg_id = gui_(s.chat_id, tinKhach_(k, false) + (k._vong ? '\n• Vòng: ' + k._vong + (lai ? ' (chia lại)' : '') : '') + '\n\n' + (khac ? '📌 Data telesale: khách giao cho bạn giữ, không bị thu hồi. Bấm Nhận để xem số.' : dongHan_(k)) + (dem || khac ? '' : '\n(Ngoài giờ ' + num('GIO_BAT_DAU') + 'h–' + num('GIO_KET_THUC') + 'h không tính.)'),
    [[{text: '✅ Nhận khách', callback_data: 'n:' + k.id}]], !dem);
  save_('Khach', T_KHACH, k);
  s[cot] = t; save_('Sale', T_SALE, s);
  log_(s.ten, 'được giao', k.id, 'lượt ' + k.so_luot + (khac ? ' · dự án khác' : ' · nhánh ' + Number(k.nhanh || 1) + ' · vòng ' + k._vong));
}
/* Vòng chia hiện tại. Lần đầu chạy bản chia theo vòng: dựng lại vòng khách mới từ nhật ký
   (các lần "được giao … lượt 1" của khách FourS/Saphia) để không tính lại người đã nhận. */
function layVong_(key, dangLam) {
  var luu = P().getProperty(key); if (luu) return JSON.parse(luu);
  var vg = {so: 1, da: []};
  if (key === 'VONG_MOI') {
    var chinh = {}, theoTen = {}, lam = dangLam.map(function (x) { return String(x.chat_id); });
    rows_('Khach', T_KHACH).forEach(function (k) { if (!laKhac_(k)) chinh[k.id] = 1; });
    rows_('Sale', T_SALE).forEach(function (x) { theoTen[x.ten] = String(x.chat_id); });
    rows_('NhatKy', T_NK).forEach(function (r) {
      if (r.hanh_dong !== 'được giao' || !chinh[r.khach] || !/^lượt 1(\D|$)/.test(r.chi_tiet) || /nhánh [2-9]/.test(r.chi_tiet)) return;
      var id = theoTen[r.nguoi]; if (!id || vg.da.indexOf(id) > -1) return;
      vg.da.push(id);
      if (lam.length && lam.every(function (x) { return vg.da.indexOf(x) > -1; })) { vg.so++; vg.da = []; }
    });
    log_('hệ thống', 'dựng vòng', '', 'khách mới vòng ' + vg.so + ', đã nhận: ' + vg.da.length + ' người');
  }
  P().setProperty(key, JSON.stringify(vg));
  return vg;
}
/* Khách thử (số trong SO_THU hoặc quản lý gõ /huy): đóng khách, báo sale, trả lại lượt vòng cho mọi người đã bị giao khách này */
function huyKhachThu_(k) {
  /* Ai đã được giao khách này, ở vòng nào: đọc từ nhật ký (cột da_qua có thể đã bị Sheet làm hỏng) */
  var theoTen = {}, tra = {VONG_MOI: [], VONG_LAI: []}, ai = [];
  rows_('Sale', T_SALE).forEach(function (x) { theoTen[x.ten] = String(x.chat_id); });
  rows_('NhatKy', T_NK).forEach(function (r) {
    if (r.khach !== k.id || r.hanh_dong !== 'được giao' || /dự án khác/.test(r.chi_tiet)) return;
    var id = theoTen[r.nguoi]; if (!id) return;
    tra[/nhánh [2-9]/.test(r.chi_tiet) ? 'VONG_LAI' : 'VONG_MOI'].push(id);
    if (ai.indexOf(id) < 0) ai.push(id);
  });
  if (k.nguoi_giu && ai.indexOf(String(k.nguoi_giu)) < 0) ai.push(String(k.nguoi_giu));
  ['VONG_MOI', 'VONG_LAI'].forEach(function (key) {
    if (!tra[key].length) return;
    var vg = layVong_(key, salesDangLam_());
    vg.da = vg.da.filter(function (x) { return tra[key].indexOf(String(x)) < 0; });
    P().setProperty(key, JSON.stringify(vg));
  });
  if (k.nguoi_giu && DANG_GIU.test(k.trang_thai)) {
    P().deleteProperty('LYDO_' + k.nguoi_giu);
    sua_(k.nguoi_giu, k.msg_id, '🧪 <b>Khách ' + esc(k.id) + '</b> là số thử của quản lý, đã huỷ. Bạn không bị mất lượt chia.');
  }
  k.trang_thai = 'dong'; k.ly_do_dong = 'Khách thử – huỷ, trả lượt'; save_('Khach', T_KHACH, k);
  var ten = ai.map(function (id) { var x = timSale_(id); return x ? x.ten : id; }).join(', ');
  log_('quản lý', 'huỷ khách thử', k.id, 'trả lượt: ' + (ten || 'không ai'));
  baoQL_('🧪 Đã huỷ khách thử ' + esc(k.id) + ' (' + esc(che(k.sdt)) + ')' + (ten ? ', trả lại lượt cho: ' + esc(ten) : '') + '.');
  return ten;
}
function sangNhanhMoi_(k) { if (!laKhac_(k)) { k.nhanh = Number(k.nhanh || 1) + 1; k.so_luot = 0; } }
/* Quản lý chia lại 1 khách (kể cả khách đã đóng): sang nhánh tiếp theo */
function chiaLai_(kc) {
  if (kc.nguoi_giu && DANG_GIU.test(kc.trang_thai)) { P().deleteProperty('LYDO_' + kc.nguoi_giu); thuHoi_(kc, 'quản lý chia lại'); }
  else { kc.da_qua = ''; sangNhanhMoi_(kc); giao_(kc); }
  log_('quản lý', 'chia lại', kc.id, laKhac_(kc) ? 'dự án khác' : 'nhánh ' + Number(kc.nhanh || 1));
}
function thuHoi_(k, lyDo) {
  sua_(k.nguoi_giu, k.msg_id, '⛔ <b>Khách ' + esc(k.id) + ' đã được thu hồi</b> (' + esc(lyDo) + ').\nSố điện thoại đã ẩn.');
  log_(k.ten_sale, 'thu hồi', k.id, lyDo);
  if (/^không bấm nhận/.test(lyDo)) {
    var hom = vnDay(Date.now()), ten = k.ten_sale, thu = maKhachThu_();
    var lan = rows_('NhatKy', T_NK).filter(function (r) { return r.nguoi === ten && r.hanh_dong === 'thu hồi' && /^không bấm nhận/.test(r.chi_tiet) && vnDay(ms(r.thoi_gian)) === hom && !thu[r.khach]; }).length;
    var sl = timSale_(k.nguoi_giu);
    if (sl && sl.trang_thai === 'lam' && lan >= num('THU_HOI_TU_DUNG')) {
      sl.trang_thai = 'nghi'; save_('Sale', T_SALE, sl); log_('hệ thống', 'tự tạm dừng', '', sl.ten + ' bị thu hồi ' + lan + ' lần hôm nay');
      gui_(sl.chat_id, '⏸ Bạn bị thu hồi ' + lan + ' khách hôm nay vì không bấm nhận kịp, bot tạm dừng chia khách cho bạn. Báo quản lý để được mở lại.');
      baoQL_('⏸ Tự tạm dừng <b>' + esc(sl.ten) + '</b>: bị thu hồi ' + lan + ' lần hôm nay vì không nhận. Gõ <code>/mo ' + esc(sl.ten) + '</code> để mở lại.');
    }
  }
  var qua = String(k.da_qua || '').split(',').filter(String); qua.push(String(k.nguoi_giu)); k.da_qua = qua.join(',');
  /* Sale đã nhận và chăm rồi mới bị thu hồi → khách sang nhánh tiếp theo (vòng chia lại riêng).
     Chưa bấm nhận đã bị thu hồi → vẫn nhánh cũ, giao người tới lượt kế tiếp của nhánh đó. */
  if (k.trang_thai !== 'cho_nhan') sangNhanhMoi_(k);
  baoQL_('🔁 Thu hồi ' + esc(k.id) + ' từ <b>' + esc(k.ten_sale) + '</b>: ' + esc(lyDo) + '. Đang giao bạn khác.');
  giao_(k);
}

/* --- kiểm tra hạn --- */
function kiemTraHan_() {
  var now = Date.now(), ngay = phutMotNgay(), khacDay = false;
  rows_('Khach', T_KHACH).forEach(function (k) {
    var st = k.trang_thai, p;
    /* Số thử: đang giữ / chờ chia → huỷ; đã bị đóng như khách thường (chưa trả lượt) → vẫn trả lượt 1 lần */
    if ((DANG_GIU.test(st) || /cho_giao|cho_quan_ly/.test(st) || (st === 'dong' && !/^Khách thử/.test(k.ly_do_dong))) && laSoThu_(k.sdt)) { huyKhachThu_(k); return; }
    if (st === 'cho_giao') {
      if (laKhac_(k) && khacDay) return;   // data telesale chờ nhiều: hết người rảnh thì để phút sau
      giao_(k); if (laKhac_(k) && k.trang_thai === 'cho_giao') khacDay = true; return;
    }
    if (laKhac_(k)) return;   // data telesale / dự án khác: giao ai người đó giữ, không thu hồi tự động
    if (st === 'cho_nhan') {
      p = phutLamViec(k.luc_giao, now);
      if (p >= num('HAN_NHAN_PHUT')) thuHoi_(k, 'không bấm nhận trong ' + num('HAN_NHAN_PHUT') + ' phút');
      else if (p >= num('NHAC_NHAN_PHUT') && !coNhac_(k, 'n')) { datNhac_(k, 'n'); save_('Khach', T_KHACH, k); nhac_(k, '⏰ Còn ' + (num('HAN_NHAN_PHUT') - p) + ' phút để bấm <b>Nhận khách ' + esc(k.id) + '</b>.\n' + dongHan_(k)); }
    } else if (st === 'da_nhan') {
      p = phutLamViec(k.luc_nhan, now);
      if (p >= num('HAN_BAO_CAO_PHUT')) thuHoi_(k, 'nhận nhưng không báo cáo trong ' + Math.round(num('HAN_BAO_CAO_PHUT') / 60) + ' giờ');
      else if (p >= num('NHAC_BAO_CAO_PHUT') && !coNhac_(k, 'b')) { datNhac_(k, 'b'); save_('Khach', T_KHACH, k); nhac_(k, '⏰ <b>Báo cáo khách ' + esc(k.id) + ' để cập nhật</b> (bấm 1 nút báo cáo), còn ' + (num('HAN_BAO_CAO_PHUT') - p) + ' phút.\n' + dongHan_(k)); }
    } else if (st === 'dang_cham') {
      p = phutLamViec(k.luc_nhan, now);
      var hcd = hanCD_(k), truoc = (num('HAN_CHUYEN_DOI_NGAY') - num('NHAC_CHUYEN_DOI_NGAY')) * ngay;
      if (p >= hcd) thuHoi_(k, (Number(k.gia_han) ? 'hết hạn chuyển đổi (đã gia hạn)' : num('HAN_CHUYEN_DOI_NGAY') + ' ngày chưa chuyển đổi'));
      else if (p >= hcd - truoc && !coNhac_(k, 'c')) { datNhac_(k, 'c'); save_('Khach', T_KHACH, k); nhac_(k, '⏰ <b>Báo cáo khách ' + esc(k.id) + ' để cập nhật</b>: còn khoảng ' + Math.round(truoc / ngay) + ' ngày để lên Hẹn gặp / Khách nóng / Đã chốt.\n' + dongHan_(k) + (conGiaHan_(k) ? '\nCần thêm thời gian? Bấm nút dưới hoặc gõ <code>/giahan ' + esc(k.id) + '</code> (được 1 lần, trước giờ hạn).' : ''), nutGiaHan_(k)); }
    } else if (st === 'chuyen_doi') {
      p = phutLamViec(k.luc_bao_cao || k.luc_nhan, now);
      if (p >= num('NONG_THU_HOI_NGAY') * ngay) thuHoi_(k, 'khách nóng ' + num('NONG_THU_HOI_NGAY') + ' ngày không cập nhật');
      else if (p >= num('NONG_NHAC_NGAY') * ngay && !coNhac_(k, 'h')) { datNhac_(k, 'h'); save_('Khach', T_KHACH, k); nhac_(k, '⏰ <b>Báo cáo khách ' + esc(k.id) + ' để cập nhật</b> (' + esc(k.bao_cao) + ', đã ' + num('NONG_NHAC_NGAY') + ' ngày chưa cập nhật).\n' + dongHan_(k)); }
    } else if (st === 'cho_ly_do') {
      if (phutLamViec(k.luc_bao_cao, now) >= num('HAN_BAO_CAO_PHUT')) { P().deleteProperty('LYDO_' + k.nguoi_giu); thuHoi_(k, 'không ghi lý do đóng khách'); }
    }
  });
}

/* ======================= TIN NHẮN & NÚT BẤM ======================= */
function xuLyTinNhan_() {
  var off = Number(P().getProperty('OFFSET') || 0);
  var r = tg_('getUpdates', {offset: off, timeout: 0, allowed_updates: ['message', 'callback_query']});
  if (!r.ok) return;
  (r.result || []).forEach(function (u) {
    off = u.update_id + 1; P().setProperty('OFFSET', String(off));
    try { if (u.callback_query) bam_(u.callback_query); else if (u.message && u.message.text) lenh_(u.message); }
    catch (e) { console.error(e); }
  });
}
function timSale_(chat) { var l = rows_('Sale', T_SALE).filter(function (s) { return String(s.chat_id) === String(chat); }); return l[0]; }
function timKhach_(id) { var l = rows_('Khach', T_KHACH).filter(function (k) { return k.id === id; }); return l[0]; }

function lenh_(m) {
  var chat = String(m.chat.id), t = m.text.trim(), la = chat === String(quanLy_()), s = timSale_(chat);
  var c = t.split(/\s+/)[0].toLowerCase().replace(/@.*/, ''), arg = t.replace(/^\S+\s*/, '').trim();
  if (c === '/dangky' || (c === '/start' && !la && !s)) {
    if (s && s.trang_thai !== 'tu_choi') { gui_(chat, s.trang_thai === 'cho_duyet' ? 'Đang chờ quản lý duyệt ạ.' : 'Anh/Chị đã ở trong đội rồi ạ.'); return; }
    var ten = arg || [m.from.first_name, m.from.last_name].filter(Boolean).join(' ');
    s = s || {chat_id: chat}; s.ten = ten; s.username = m.from.username || ''; s.trang_thai = 'cho_duyet'; s.them_luc = nowD(); save_('Sale', T_SALE, s);
    gui_(chat, 'Đã gửi yêu cầu vào đội, chờ quản lý duyệt ạ.');
    baoQL_('👤 <b>' + esc(ten) + '</b>' + (s.username ? ' (@' + esc(s.username) + ')' : '') + ' xin vào đội chia khách.', [[{text: '✅ Duyệt', callback_data: 'dy:' + chat}, {text: '❌ Từ chối', callback_data: 'tc:' + chat}]]);
    return;
  }
  if (la) {
    if (c === '/tuan') { gui_(chat, baoCaoTuan_(Date.now())); return; }
    if (c === '/xoa') {
      var xs = rows_('Sale', T_SALE).filter(function (z) { return arg && String(z.ten).toLowerCase().indexOf(arg.toLowerCase()) > -1 && z.trang_thai !== 'nghi_viec'; });
      if (xs.length !== 1) { gui_(chat, xs.length ? 'Có nhiều sale trùng tên "' + esc(arg) + '", gõ đầy đủ hơn.' : 'Không tìm thấy sale "' + esc(arg) + '".'); return; }
      var xv = xs[0]; xv.trang_thai = 'nghi_viec'; save_('Sale', T_SALE, xv); log_('quản lý', 'xoá sale (nghỉ việc)', '', xv.ten);
      var giu = rows_('Khach', T_KHACH).filter(function (k) { return String(k.nguoi_giu) === String(xv.chat_id) && (DANG_GIU.test(k.trang_thai) || k.trang_thai === 'chot'); });
      giu.forEach(function (k) { thuHoi_(k, 'sale nghỉ việc'); });
      gui_(xv.chat_id, 'Tài khoản của bạn đã được gỡ khỏi đội chia khách. Cảm ơn bạn.');
      gui_(chat, '🗑 Đã gỡ ' + esc(xv.ten) + ', thu hồi và chia lại ' + giu.length + ' khách người đó đang giữ.'); return;
    }
    if (c === '/them' || c === '/themkhac') { gui_(chat, themKhachTay_(t.replace(/^\S+[ \t]*/, ''), c === '/themkhac' ? 'khac' : '')); return; }
    if (c === '/sale') { gui_(chat, danhSachSale_()); return; }
    if (c === '/tailieu') { taiLieu_(chat); return; }
    if (c === '/huy') {
      var hk = arg ? timKhach_(arg.toUpperCase().split(/\s+/)[0]) : null;
      if (!hk) { gui_(chat, 'Gõ: <code>/huy K39</code> – huỷ khách thử, trả lại lượt cho sale đã bị giao. Số thử dùng thường xuyên thì thêm vào dòng SO_THU trong tab CauHinh.'); return; }
      if (hk.trang_thai === 'chot') { gui_(chat, 'Khách ' + esc(hk.id) + ' đã chốt, không huỷ.'); return; }
      if (/^Khách thử/.test(hk.ly_do_dong)) { gui_(chat, 'Khách ' + esc(hk.id) + ' đã huỷ và trả lượt rồi.'); return; }
      huyKhachThu_(hk); return;
    }
    if (c === '/chialai') {
      var ids = arg.toUpperCase().split(/[\s,]+/).filter(String), out = [];
      if (!ids.length) { gui_(chat, 'Gõ: <code>/chialai K12</code> (nhiều khách: <code>/chialai K12 K15</code>). Khách sang nhánh tiếp theo, chia vòng riêng, không mất lượt khách mới của sale.'); return; }
      ids.forEach(function (id) {
        var kx = timKhach_(id); if (!kx) { out.push('❌ Không thấy ' + esc(id)); return; }
        chiaLai_(kx);
        out.push('🔁 ' + esc(kx.id) + (laKhac_(kx) ? '' : ' nhánh ' + Number(kx.nhanh || 1)) + ': ' + (kx.trang_thai === 'cho_nhan' ? 'giao ' + esc(kx.ten_sale) : kx.trang_thai === 'cho_giao' ? 'chờ giao' : 'chuyển quản lý (hết sale)'));
      });
      gui_(chat, out.join('\n')); return;
    }
    if (c === '/baocao') { gui_(chat, baoCao_(Date.now())); return; }
    if (c === '/tam' || c === '/mo') {
      var x = rows_('Sale', T_SALE).filter(function (z) { return String(z.ten).toLowerCase().indexOf(arg.toLowerCase()) > -1 && arg; })[0];
      if (!x) { gui_(chat, 'Không tìm thấy sale "' + esc(arg) + '".'); return; }
      x.trang_thai = c === '/tam' ? 'nghi' : 'lam'; save_('Sale', T_SALE, x); log_('quản lý', c === '/tam' ? 'tạm dừng' : 'mở lại', '', x.ten);
      gui_(chat, (c === '/tam' ? '⏸ Tạm dừng chia cho ' : '▶️ Mở lại chia cho ') + esc(x.ten)); return;
    }
    gui_(chat, 'Lệnh quản lý: /them Số Tên - nhu cầu · /themkhac (dự án khác) · /chialai Mã · /huy Mã (khách thử) · /sale · /baocao · /tuan · /tam Tên · /mo Tên · /xoa Tên · /tailieu (slide)'); return;
  }
  if (!s || /cho_duyet|tu_choi|nghi_viec/.test(s.trang_thai)) { gui_(chat, 'Nhắn <code>/dangky Tên của bạn</code> để xin vào đội chia khách.'); return; }
  /* Đang chờ ghi lý do đóng khách: tin tiếp theo (không phải lệnh) là lý do */
  var choLd = P().getProperty('LYDO_' + chat);
  if (choLd && c.charAt(0) !== '/') {
    var kd = timKhach_(choLd);
    if (kd && String(kd.nguoi_giu) === chat && kd.trang_thai === 'cho_ly_do') {
      P().deleteProperty('LYDO_' + chat);
      kd.ly_do_dong = t.slice(0, 300); kd.trang_thai = 'cho_duyet_dong'; kd.luc_bao_cao = nowD(); save_('Khach', T_KHACH, kd); log_(kd.ten_sale, 'xin đóng khách', kd.id, kd.ly_do_dong);
      gui_(chat, '📝 Đã gửi lý do, chờ quản lý duyệt đóng khách ' + esc(kd.id) + '.');
      baoQL_('🚫 <b>' + esc(kd.ten_sale) + '</b> xin đóng khách ' + esc(kd.id) + ' (' + esc(che(kd.sdt)) + ').\nLý do: ' + esc(kd.ly_do_dong), [[{text: '✅ Đồng ý đóng', callback_data: 'dd:' + kd.id}, {text: '🔁 Chia lại', callback_data: 'cl:' + kd.id}]]);
      return;
    }
    P().deleteProperty('LYDO_' + chat);
  }
  if (c === '/tailieu') { taiLieu_(chat); return; }
  if (c === '/nghi') { s.trang_thai = 'nghi'; save_('Sale', T_SALE, s); log_(s.ten, 'tự nghỉ'); gui_(chat, '⏸ Đã tạm dừng nhận khách. Nhắn /lam để nhận lại.'); return; }
  if (c === '/lam') { s.trang_thai = 'lam'; save_('Sale', T_SALE, s); log_(s.ten, 'đi làm'); gui_(chat, '▶️ Đã bật nhận khách.'); return; }
  if (c === '/giahan') {
    var dc = rows_('Khach', T_KHACH).filter(function (k) { return String(k.nguoi_giu) === chat && k.trang_thai === 'dang_cham'; });
    var kg = arg ? timKhach_(arg.toUpperCase()) : (dc.length === 1 ? dc[0] : null);
    if (!kg) { gui_(chat, arg ? 'Không thấy khách ' + esc(arg) + '.' : (dc.length ? 'Gõ kèm mã khách, ví dụ <code>/giahan ' + esc(dc[0].id) + '</code>. Khách đang chờ chuyển đổi: ' + dc.map(function (k) { return esc(k.id); }).join(', ') : 'Bạn không có khách nào cần gia hạn.')); return; }
    gui_(chat, giaHan_(kg, chat)); return;
  }
  if (c === '/khach') {
    var l = rows_('Khach', T_KHACH).filter(function (k) { return String(k.nguoi_giu) === chat && DANG_GIU.test(k.trang_thai) && k.trang_thai !== 'cho_nhan'; });
    gui_(chat, l.length ? '<b>Khách bạn đang giữ</b>\n' + l.map(function (k) { var h = han_(k); return '• ' + esc(k.id) + ' ' + esc(k.sdt) + ' – ' + esc(k.bao_cao || 'chưa báo cáo') + (h ? '\n   ⏱ ' + h.viec + ' trước <b>' + fmt(h.luc) + '</b>' : '') + (k.trang_thai === 'dang_cham' && conGiaHan_(k) ? ' · gia hạn: <code>/giahan ' + esc(k.id) + '</code>' : ''); }).join('\n') + '\n\nSau thời gian trên sẽ bị thu hồi.' : 'Bạn chưa giữ khách nào.'); return;
  }
  gui_(chat, 'Lệnh: /khach (khách đang giữ) · /giahan Mã (xin thêm ' + num('GIA_HAN_NGAY') + ' ngày) · /tailieu (slide chủ đầu tư, slide nội bộ) · /nghi · /lam');
}

function bam_(q) {
  var chat = String(q.from.id), d = q.data || '', parts = d.split(':'), ok = '';
  function tl(t) { tg_('answerCallbackQuery', {callback_query_id: q.id, text: t || ''}); }
  if (parts[0] === 'dy' || parts[0] === 'tc') {
    if (chat !== String(quanLy_())) return tl('Chỉ quản lý được duyệt');
    var s = timSale_(parts[1]); if (!s) return tl('Không thấy');
    if (s.trang_thai !== 'cho_duyet') { sua_(q.message.chat.id, q.message.message_id, (s.trang_thai === 'tu_choi' ? '❌ Đã từ chối ' : '✅ Đã duyệt ') + esc(s.ten)); return tl('Đã xử lý rồi'); }
    s.trang_thai = parts[0] === 'dy' ? 'lam' : 'tu_choi'; save_('Sale', T_SALE, s); log_('quản lý', parts[0] === 'dy' ? 'duyệt sale' : 'từ chối sale', '', s.ten);
    gui_(s.chat_id, parts[0] === 'dy' ? '✅ Quản lý đã duyệt. Bạn sẽ nhận khách lần lượt. Lệnh: /khach · /tailieu · /nghi · /lam' : 'Yêu cầu vào đội chưa được duyệt.');
    sua_(q.message.chat.id, q.message.message_id, (parts[0] === 'dy' ? '✅ Đã duyệt ' : '❌ Đã từ chối ') + esc(s.ten));
    return tl('Xong');
  }
  if (parts[0] === 'ts') return bamTele_(q, parts, tl);
  if (parts[0] === 'tm') {
    if (chat !== String(quanLy_())) return tl('Chỉ quản lý');
    var cho = JSON.parse(P().getProperty('CHO_THEM') || '{}'), c = cho[parts[1]];
    if (!c) { sua_(q.message.chat.id, q.message.message_id, '✅ Khách ' + esc(parts[1]) + ' đã xử lý rồi.'); return tl('Đã xử lý rồi'); }
    delete cho[parts[1]]; P().setProperty('CHO_THEM', JSON.stringify(cho));
    var dongThem = parts[1] + ' ' + (c.ten || '') + (c.nc ? ' - ' + c.nc.replace(/\s+-\s+/g, ' · ') : '') + (c.nguon ? '\nNguồn: ' + c.nguon : '') + (c.trang ? '\nTrang: ' + c.trang : '');
    sua_(q.message.chat.id, q.message.message_id, themKhachTay_(dongThem, c.nhom === 'khac' ? 'khac' : ''));
    return tl('Đã chia');
  }
  if (parts[0] === 'dd') {
    if (chat !== String(quanLy_())) return tl('Chỉ quản lý');
    var kdd = timKhach_(parts[1]); if (!kdd || kdd.trang_thai !== 'cho_duyet_dong') return tl('Không còn chờ duyệt');
    kdd.trang_thai = 'dong'; save_('Khach', T_KHACH, kdd); log_('quản lý', 'duyệt đóng khách', kdd.id, kdd.ly_do_dong);
    sua_(kdd.nguoi_giu, kdd.msg_id, tinKhach_(kdd, true) + '\n\n🚫 Đã đóng khách (quản lý duyệt). Lý do: ' + esc(kdd.ly_do_dong));
    sua_(q.message.chat.id, q.message.message_id, '✅ Đã đóng khách ' + esc(kdd.id) + ' của ' + esc(kdd.ten_sale) + '. Lý do: ' + esc(kdd.ly_do_dong));
    return tl('Đã đóng');
  }
  if (parts[0] === 'gt') {
    if (chat !== String(quanLy_())) return tl('Chỉ quản lý');
    var kg = timKhach_(parts[1]), sg = timSale_(parts[2]); if (!kg || !sg) return tl('Không thấy');
    if (kg.trang_thai === 'chot' || kg.trang_thai === 'dong') return tl('Khách đã ' + (kg.trang_thai === 'chot' ? 'chốt' : 'đóng'));
    if (kg.nguoi_giu && DANG_GIU.test(kg.trang_thai)) {
      if (String(kg.nguoi_giu) === String(sg.chat_id)) return tl(sg.ten + ' đang giữ khách này rồi');
      sua_(kg.nguoi_giu, kg.msg_id, '⛔ <b>Khách ' + esc(kg.id) + '</b> đã được quản lý chuyển cho người khác.\nSố điện thoại đã ẩn.'); log_(kg.ten_sale, 'thu hồi', kg.id, 'quản lý chuyển sale');
    }
    giaoTay_(kg, sg);
    sua_(q.message.chat.id, q.message.message_id, '✅ Đã giao khách ' + esc(kg.id) + (kg.ten ? ' – ' + esc(kg.ten) : '') + ' cho <b>' + esc(sg.ten) + '</b> lúc ' + fmt(kg.luc_giao) + '.', nutChonSale_(kg));
    return tl('Đã giao ' + sg.ten);
  }
  if (parts[0] === 'cl') {
    if (chat !== String(quanLy_())) return tl('Chỉ quản lý');
    var kc = timKhach_(parts[1]); if (!kc) return tl('Không thấy');
    chiaLai_(kc); sua_(q.message.chat.id, q.message.message_id, '🔁 Đã chia lại ' + esc(kc.id) + (laKhac_(kc) ? '' : ' (nhánh ' + Number(kc.nhanh || 1) + ')') + (kc.ten_sale ? ' → ' + esc(kc.ten_sale) : ''));
    return tl('Đã chia lại');
  }
  var k = timKhach_(parts[1]);
  if (!k || String(k.nguoi_giu) !== chat) return tl('Khách này không còn giao cho bạn');
  if (parts[0] === 'n') {
    if (k.trang_thai !== 'cho_nhan') return tl('Đã nhận rồi');
    k.trang_thai = 'da_nhan'; k.luc_nhan = nowD(); save_('Khach', T_KHACH, k); log_(k.ten_sale, 'nhận khách', k.id, 'xem số');
    sua_(chat, k.msg_id, tinKhach_(k, true) + '\n\n✅ Bạn đã nhận. Báo cáo khách này để cập nhật.' + (laKhac_(k) ? '' : '\n' + dongHan_(k) + '\n(Hạn chuyển đổi: trước ' + fmt(hanLuc(k.luc_nhan, num('HAN_CHUYEN_DOI_NGAY') * phutMotNgay())) + ' · chỉ tính ' + num('GIO_BAT_DAU') + 'h–' + num('GIO_KET_THUC') + 'h)'), nutBaoCao_(k.id));
    return tl('Đã nhận khách');
  }
  if (parts[0] === 'b' && BC[parts[2]]) {
    var code = parts[2];
    k.luc_bao_cao = nowD(); k.bao_cao = BC[code]; k.so_bao_cao = Number(k.so_bao_cao || 0) + 1;
    boNhac_(k, 'h');
    if (code === 'khong') {
      k.trang_thai = 'cho_ly_do'; save_('Khach', T_KHACH, k); log_(k.ten_sale, 'báo cáo', k.id, BC[code]);
      P().setProperty('LYDO_' + chat, k.id);
      sua_(chat, k.msg_id, tinKhach_(k, true) + '\n\n✍️ Gõ <b>1 dòng lý do</b> khách không tiềm năng (ví dụ: không có nhu cầu, chỉ tham khảo, tài chính chưa phù hợp, đã mua dự án khác, sai số, môi giới…). Quản lý duyệt mới đóng hẳn.');
      return tl('Gõ lý do giúp nhé');
    }
    if (code === 'cd') k.trang_thai = 'chot';
    else if (CHUYEN_DOI[code]) k.trang_thai = 'chuyen_doi';
    else if (k.trang_thai !== 'chuyen_doi') k.trang_thai = 'dang_cham';
    save_('Khach', T_KHACH, k); log_(k.ten_sale, 'báo cáo', k.id, BC[code]);
    var xong = k.trang_thai === 'chot';
    sua_(chat, k.msg_id, tinKhach_(k, true) + '\n\n📝 Báo cáo mới nhất: <b>' + esc(BC[code]) + '</b> (' + fmt(k.luc_bao_cao) + ')' + (xong ? '' : '\n' + dongHan_(k)), xong ? [] : nutBaoCao_(k.id));
    if (code === 'cd') baoQL_('🎉 <b>' + esc(k.ten_sale) + '</b> đã chốt khách ' + esc(k.id) + '.');
    return tl('Đã ghi báo cáo');
  }
  if (parts[0] === 'gh') { var kq = giaHan_(k, chat); gui_(chat, kq); return tl(kq.replace(/<[^>]+>/g, '').slice(0, 190)); }
  tl('');
}

/* Sale xin gia hạn hạn chuyển đổi: tự duyệt, mỗi khách tối đa SO_LAN_GIA_HAN lần, báo quản lý */
function giaHan_(k, chat) {
  if (String(k.nguoi_giu) !== String(chat)) return 'Khách này không còn giao cho bạn.';
  if (k.trang_thai === 'chuyen_doi' || k.trang_thai === 'chot') return 'Khách ' + esc(k.id) + ' đã chuyển đổi, không cần gia hạn.';
  if (k.trang_thai !== 'dang_cham') return 'Chỉ gia hạn được hạn chuyển đổi ' + num('HAN_CHUYEN_DOI_NGAY') + ' ngày (sau khi đã báo cáo khách).';
  if (!conGiaHan_(k)) return 'Khách ' + esc(k.id) + ' đã gia hạn rồi, không gia hạn thêm được.\n' + dongHan_(k);
  k.gia_han = Number(k.gia_han || 0) + 1; boNhac_(k, 'c'); save_('Khach', T_KHACH, k);
  var h = han_(k); log_(k.ten_sale, 'gia hạn', k.id, '+' + num('GIA_HAN_NGAY') + ' ngày, hạn mới ' + fmt(h.luc));
  sua_(chat, k.msg_id, tinKhach_(k, true) + '\n\n📝 Báo cáo mới nhất: <b>' + esc(k.bao_cao) + '</b>' + (k.luc_bao_cao ? ' (' + fmt(k.luc_bao_cao) + ')' : '') + '\n⏳ Đã gia hạn ' + num('GIA_HAN_NGAY') + ' ngày.\n' + dongHan_(k), nutBaoCao_(k.id));
  baoQL_('⏳ <b>' + esc(k.ten_sale) + '</b> gia hạn khách ' + esc(k.id) + ' thêm ' + num('GIA_HAN_NGAY') + ' ngày. Hạn chuyển đổi mới: ' + fmt(h.luc) + '.');
  return '⏳ Đã gia hạn khách ' + esc(k.id) + ' thêm ' + num('GIA_HAN_NGAY') + ' ngày.\n' + dongHan_(k);
}

/* ======================= BÁO CÁO ======================= */
function danhSachSale_() {
  var l = rows_('Sale', T_SALE).filter(function (s) { return s.trang_thai !== 'tu_choi'; });
  if (!l.length) return 'Chưa có sale nào. Sale nhắn bot /dangky Tên để xin vào đội.';
  var vg = layVong_('VONG_MOI', salesDangLam_());
  return '<b>Đội chia khách</b> · khách mới đang ở <b>vòng ' + vg.so + '</b>\n' + l.map(function (s) { return (s.trang_thai === 'lam' ? '▶️ ' : s.trang_thai === 'nghi' ? '⏸ ' : '⏳ ') + esc(s.ten) + (s.trang_thai === 'lam' ? (vg.da.indexOf(String(s.chat_id)) > -1 ? ' ✔ đã nhận vòng này' : ' · chưa nhận vòng này') : '') + ' – đang giữ ' + dangGiu_(s.chat_id, null, '') + (dangGiu_(s.chat_id, null, 'khac') ? ' (+' + dangGiu_(s.chat_id, null, 'khac') + ' dự án khác)' : ''); }).join('\n');
}
/* Khách thử (số trong SO_THU hoặc đã huỷ là khách thử): không tính vào báo cáo, xếp hạng, luật tự tạm dừng */
function laKhachThu_(k) { return /^Khách thử/.test(String(k.ly_do_dong || '')) || laSoThu_(k.sdt); }
function maKhachThu_() { var m = {}; rows_('Khach', T_KHACH).forEach(function (k) { if (laKhachThu_(k)) m[k.id] = 1; }); return m; }
function baoCao_(t) {
  var thu = maKhachThu_(), hom = vnDay(t), nk = rows_('NhatKy', T_NK).filter(function (r) { return vnDay(ms(r.thoi_gian)) === hom && !thu[r.khach]; });
  var kh = rows_('Khach', T_KHACH).filter(function (k) { return !thu[k.id]; }), moi = kh.filter(function (k) { return vnDay(ms(k.luc_vao)) === hom; }).length;
  var by = {};
  nk.forEach(function (r) { var n = r.nguoi; if (!n || n === 'hệ thống' || n === 'quản lý') return; by[n] = by[n] || {giao: 0, nhan: 0, thu: 0, bc: 0}; if (r.hanh_dong === 'được giao') by[n].giao++; if (r.hanh_dong === 'nhận khách') by[n].nhan++; if (r.hanh_dong === 'thu hồi') by[n].thu++; if (r.hanh_dong === 'báo cáo') by[n].bc++; });
  var chot = {}, cd = {};
  kh.forEach(function (k) { if (k.ten_sale) { if (k.trang_thai === 'chot') chot[k.ten_sale] = (chot[k.ten_sale] || 0) + 1; if (/chuyen_doi|chot/.test(k.trang_thai)) cd[k.ten_sale] = (cd[k.ten_sale] || 0) + 1; } });
  var dong = kh.filter(function (k) { return /cho_nhan|da_nhan/.test(k.trang_thai); }).length, ql = kh.filter(function (k) { return k.trang_thai === 'cho_quan_ly'; }).length;
  var L = ['📊 <b>Báo cáo chia khách ' + hom.split('-').reverse().join('/') + '</b>', 'Khách mới: <b>' + moi + '</b> · đang chờ nhận/báo cáo: ' + dong + (ql ? ' · ⚠️ chờ quản lý: ' + ql : ''), ''];
  Object.keys(by).forEach(function (n) { var b = by[n]; L.push('• <b>' + esc(n) + '</b>: giao ' + b.giao + ', nhận ' + b.nhan + ', báo cáo ' + b.bc + ', bị thu hồi ' + b.thu + ', chuyển đổi (tổng) ' + (cd[n] || 0) + ', chốt ' + (chot[n] || 0)); });
  if (L.length === 3) L.push('Hôm nay chưa có hoạt động.');
  return L.join('\n');
}
function baoCaoToi() { baoQL_(baoCao_(Date.now())); }
/* Xếp hạng 7 ngày gần nhất: tỷ lệ nhận đúng hạn, báo cáo đúng hạn, chuyển đổi, chốt */
function baoCaoTuan_(t) {
  var tu = t - 7 * 86400000, by = {}, thu = maKhachThu_();
  var nk = rows_('NhatKy', T_NK).filter(function (r) { return ms(r.thoi_gian) >= tu && ms(r.thoi_gian) <= t && !thu[r.khach]; });
  nk.forEach(function (r) {
    var n = r.nguoi; if (!n || n === 'hệ thống' || n === 'quản lý') return;
    var b = by[n] = by[n] || {giao: 0, nhan: 0, khongNhan: 0, khongBc: 0, cd: 0, chot: 0};
    if (r.hanh_dong === 'được giao') b.giao++;
    if (r.hanh_dong === 'nhận khách') b.nhan++;
    if (r.hanh_dong === 'thu hồi' && /^không bấm nhận/.test(r.chi_tiet)) b.khongNhan++;
    if (r.hanh_dong === 'thu hồi' && /không báo cáo/.test(r.chi_tiet)) b.khongBc++;
    if (r.hanh_dong === 'báo cáo' && (r.chi_tiet === BC.hen || r.chi_tiet === BC.nong)) b.cd++;
    if (r.hanh_dong === 'báo cáo' && r.chi_tiet === BC.cd) { b.chot++; b.cd++; }
  });
  function pc(a, b) { return b ? Math.round(a * 100 / b) + '%' : '–'; }
  var ds = Object.keys(by).map(function (n) { var b = by[n]; b.ten = n; b.rNhan = b.giao ? b.nhan / b.giao : 0; b.rCd = b.nhan ? b.cd / b.nhan : 0; return b; });
  ds.sort(function (a, b) { return b.chot - a.chot || b.rCd - a.rCd || b.rNhan - a.rNhan; });
  var L = ['🏆 <b>Xếp hạng 7 ngày qua</b> (đến ' + fmt(t) + ')', ''];
  ds.forEach(function (b, i) {
    L.push((i + 1) + '. <b>' + esc(b.ten) + '</b> – chốt ' + b.chot + ' · chuyển đổi ' + pc(b.cd, b.nhan) + ' · nhận đúng hạn ' + pc(b.nhan, b.giao) + ' (' + b.nhan + '/' + b.giao + ')'
      + (b.khongBc ? ' · ' + b.khongBc + ' lần không báo cáo' : ''));
  });
  if (!ds.length) L.push('Tuần qua chưa có hoạt động.');
  return L.join('\n');
}
function baoCaoTuan() { baoQL_(baoCaoTuan_(Date.now())); }
