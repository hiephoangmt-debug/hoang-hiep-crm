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
  NONG_THU_HOI_NGAY: 7       // khách nóng/hẹn gặp: 7 ngày im lặng thì thu hồi
};

var BC = {  // nút báo cáo của sale
  goi:   'Đã gọi, đang tư vấn',
  knm:   'Không nghe máy',
  hen:   'Hẹn gặp / xem dự án',
  nong:  'Khách nóng',
  cd:    'Đã chốt',
  khong: 'Không có nhu cầu'
};
var CHUYEN_DOI = {hen: 1, nong: 1, cd: 1};   // báo cáo nào được tính là đã chuyển đổi (dừng hạn 3 ngày)

var T_KHACH = ['id', 'luc_vao', 'ten', 'sdt', 'nhu_cau', 'nguon', 'trang', 'trang_thai', 'nguoi_giu', 'ten_sale', 'msg_id',
  'luc_giao', 'luc_nhan', 'luc_bao_cao', 'bao_cao', 'so_bao_cao', 'da_qua', 'so_luot', 'ghi_chu', 'nhac', 'ly_do_dong', 'so_lan_gui'];
var T_SALE = ['chat_id', 'ten', 'username', 'trang_thai', 'luc_giao_cuoi', 'them_luc'];
var T_NK = ['thoi_gian', 'nguoi', 'hanh_dong', 'khach', 'chi_tiet'];

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
  var st = k.trang_thai, ngay = phutMotNgay();
  if (st === 'cho_nhan') return {viec: 'bấm Nhận', luc: hanLuc(k.luc_giao, num('HAN_NHAN_PHUT'))};
  if (st === 'da_nhan') return {viec: 'báo cáo', luc: hanLuc(k.luc_nhan, num('HAN_BAO_CAO_PHUT'))};
  if (st === 'dang_cham') return {viec: 'lên Hẹn gặp / Khách nóng / Đã chốt', luc: hanLuc(k.luc_nhan, num('HAN_CHUYEN_DOI_NGAY') * ngay)};
  if (st === 'chuyen_doi') return {viec: 'cập nhật báo cáo', luc: hanLuc(k.luc_bao_cao || k.luc_nhan, num('NONG_THU_HOI_NGAY') * ngay)};
  if (st === 'cho_ly_do') return {viec: 'gõ lý do đóng', luc: hanLuc(k.luc_bao_cao, num('HAN_BAO_CAO_PHUT'))};
  return null;
}
function dongHan_(k) { var h = han_(k); return h ? '⏱ Hạn ' + h.viec + ': <b>trước ' + fmt(h.luc) + '</b>. Sau thời gian trên sẽ bị thu hồi.' : ''; }
function phutMotNgay() { return (num('GIO_KET_THUC') - num('GIO_BAT_DAU')) * 60; }
function che(sdt) { sdt = String(sdt || ''); return sdt.length >= 8 ? sdt.slice(0, 4) + ' ••• ' + sdt.slice(-3) : '•••'; }
function esc(s) { return String(s == null ? '' : s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;'); }
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
    var o = {_r: i + 2}; head.forEach(function (h, j) { o[h] = r[j]; }); list.push(o);
  });
  return list;
}
function save_(name, head, o) {
  var sh = tab_(name, head), v = [head.map(function (h) { return o[h] == null ? '' : o[h]; })];
  if (o._r) sh.getRange(o._r, 1, 1, head.length).setValues(v);
  else { sh.appendRow(v[0]); o._r = sh.getLastRow(); }
}
function tabMap_(name) {
  var sh = tab_(name, ['khoa', 'gia_tri', 'ghi_chu']), n = sh.getLastRow(), m = {};
  if (n > 1) sh.getRange(2, 1, n - 1, 2).getValues().forEach(function (r) { if (r[0]) m[String(r[0]).trim()] = r[1]; });
  return m;
}
function log_(nguoi, hd, khach, ct) { tab_('NhatKy', T_NK).appendRow([nowD(), nguoi || '', hd, khach || '', ct || '']); }

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
function nhac_(k, text) {
  var p = {chat_id: k.nguoi_giu, text: text, parse_mode: 'HTML', protect_content: true};
  if (k.msg_id) p.reply_to_message_id = Number(k.msg_id);
  tg_('sendMessage', p);
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
  if (BOT_TOKEN_DAN_VAO_DAY.indexOf('DÁN_') !== 0) P().setProperty('BOT_TOKEN', BOT_TOKEN_DAN_VAO_DAY);
  if (!P().getProperty('BOT_TOKEN')) throw new Error('Chưa dán mã bot vào dòng BOT_TOKEN_DAN_VAO_DAY');
  tg_('deleteWebhook', {});
  var me = tg_('getMe', {}); if (!me.ok) throw new Error('Mã bot chưa đúng, copy lại từ BotFather');
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
  if (!cfg('CRM_SHEET_ID')) throw new Error('Chưa dán link Sheet CRM vào dòng LINK_SHEET_CRM_DAN_VAO_DAY');
  try { SpreadsheetApp.openById(cfg('CRM_SHEET_ID')).getSheetByName(cfg('CRM_TAB')).getLastRow(); }
  catch (e) { throw new Error('Không mở được Sheet CRM hoặc tab "' + cfg('CRM_TAB') + '". Kiểm tra link và dùng đúng tài khoản Google đang giữ Sheet CRM.'); }
  if (!P().getProperty('DA_XEM')) ghiNhanKhachCu_();
  ScriptApp.getProjectTriggers().forEach(function (t) { ScriptApp.deleteTrigger(t); });
  ScriptApp.newTrigger('chayMoiPhut').timeBased().everyMinutes(1).create();
  ScriptApp.newTrigger('baoCaoToi').timeBased().atHour(num('GIO_BAO_CAO_TOI')).nearMinute(10).everyDays(1).inTimezone('Asia/Ho_Chi_Minh').create();
  ScriptApp.newTrigger('baoCaoTuan').timeBased().onWeekDay(ScriptApp.WeekDay.MONDAY).atHour(8).nearMinute(5).inTimezone('Asia/Ho_Chi_Minh').create();
  gui_(quanLy_(), '✅ Bot chia khách đã chạy. Anh là <b>quản lý</b>.\nSale nhắn bot: <code>/dangky Tên</code> để xin vào đội, anh bấm Duyệt.\nLệnh: /sale · /baocao · /tuan · /tam Tên · /mo Tên · /xoa Tên');
  log_('hệ thống', 'cài đặt', '', 'quản lý ' + quanLy_());
}
/* Khách đã có sẵn trong CRM lúc cài đặt: đánh dấu đã xem, không chia lại */
function ghiNhanKhachCu_() {
  var seen = {}; layKhachCRM_().forEach(function (k) { seen[k.sdt] = Math.max(seen[k.sdt] || 0, k.so_lan); });
  P().setProperty('DA_XEM', JSON.stringify(seen));
}

/* ======================= VÒNG CHẠY MỖI PHÚT ======================= */
function chayMoiPhut() {
  var lock = LockService.getScriptLock(); if (!lock.tryLock(20000)) return;
  try { xuLyTinNhan_(); nhanKhachMoi_(); kiemTraHan_(); }
  finally { lock.releaseLock(); }
}

/* --- khách mới từ CRM --- */
function layKhachCRM_() {
  var id = cfg('CRM_SHEET_ID'); if (!id) return [];
  var sh = SpreadsheetApp.openById(id).getSheetByName(cfg('CRM_TAB')); if (!sh) return [];
  var n = sh.getLastRow(); if (n < 2) return [];
  var w = Math.min(46, sh.getLastColumn()), loc = String(cfg('LOC_TRANG') || '').toLowerCase().split(',').map(function (x) { return x.trim(); }).filter(String);
  return sh.getRange(2, 1, n - 1, w).getValues().map(function (r) {
    return {sdt: normPhone(r[3]), ten: String(r[2] || ''), luc: r[1], web: String(r[5] || ''), utm: [r[6], r[7]].filter(String).join(' / '),
      ghi_chu: String(r[21] || '').slice(0, 300), loai: String(r[39] || ''), trang: String(r[40] || ''), du_an: String(r[41] || ''), so_lan: Number(r[9]) || 1};
  }).filter(function (k) {
    var chu = (k.trang + ' ' + k.web).toLowerCase();
    return k.sdt.length === 10 && k.loai === 'Website' && (!loc.length || loc.some(function (x) { return chu.indexOf(x) > -1; }));
  });
}
function nhanKhachMoi_() {
  var seen = JSON.parse(P().getProperty('DA_XEM') || '{}'), moi = [], lai = [], doi = false;
  layKhachCRM_().forEach(function (k) {
    var cu = Number(seen[k.sdt] || 0);
    if (!cu) { seen[k.sdt] = k.so_lan; moi.push(k); doi = true; }
    else if (k.so_lan > cu) { seen[k.sdt] = k.so_lan; lai.push(k); doi = true; }
  });
  if (!doi) return;
  P().setProperty('DA_XEM', JSON.stringify(seen));
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
  moi.forEach(function (c) {
    dem++;
    var k = {id: 'K' + dem, luc_vao: nowD(), ten: c.ten, sdt: c.sdt, nhu_cau: [c.du_an, c.ghi_chu].filter(String).join(' · '),
      nguon: c.utm || c.web, trang: c.trang, trang_thai: 'moi', da_qua: '', so_luot: 0, so_bao_cao: 0};
    save_('Khach', T_KHACH, k); log_('hệ thống', 'khách mới', k.id, che(k.sdt));
    giao_(k);
  });
  P().setProperty('DEM', String(dem));
}
/* Thêm khách bằng tay để thử: themKhachThu() */
function themKhachThu() { var k = {id: 'T' + Date.now() % 100000, luc_vao: nowD(), ten: 'Khách thử', sdt: '0900000000', nhu_cau: 'Thử hệ thống', nguon: 'thử', trang_thai: 'moi', da_qua: '', so_luot: 0, so_bao_cao: 0}; save_('Khach', T_KHACH, k); giao_(k); }

/* --- giao khách --- */
function salesDangLam_() { return rows_('Sale', T_SALE).filter(function (s) { return s.trang_thai === 'lam'; }); }
function dangGiu_(chat, re) { re = re || DANG_GIU; return rows_('Khach', T_KHACH).filter(function (k) { return String(k.nguoi_giu) === String(chat) && re.test(k.trang_thai); }).length; }
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
function giao_(k) {
  var qua = String(k.da_qua || '').split(',').filter(String);
  var ung = salesDangLam_().filter(function (s) { return qua.indexOf(String(s.chat_id)) < 0; });
  if (!ung.length || Number(k.so_luot) >= num('SO_LUOT_TOI_DA')) {
    k.trang_thai = 'cho_quan_ly'; k.nguoi_giu = ''; k.ten_sale = ''; save_('Khach', T_KHACH, k);
    baoQL_('⚠️ Không còn sale nhận ' + esc(k.id) + ', anh xử lý giúp:\n' + tinKhach_(k, true), [[{text: '🔁 Chia lại từ đầu', callback_data: 'cl:' + k.id}]]);
    log_('hệ thống', 'chuyển quản lý', k.id, 'hết sale / quá lượt'); return;
  }
  /* Không ôm khách: ai đang có quá nhiều khách chưa báo cáo thì tạm bỏ qua */
  var ranh = ung.filter(function (s) { return dangGiu_(s.chat_id, CHUA_BAO_CAO) < num('TOI_DA_CHUA_BAO_CAO'); });
  if (!ranh.length) {
    var cho = k.trang_thai === 'cho_giao'; k.trang_thai = 'cho_giao'; k.nguoi_giu = ''; k.ten_sale = ''; save_('Khach', T_KHACH, k);
    if (!cho) { baoQL_('⏳ Đội đang giữ nhiều khách chưa báo cáo, khách ' + esc(k.id) + ' đang chờ, sẽ tự giao khi có người rảnh.'); log_('hệ thống', 'chờ giao', k.id, 'đội quá tải'); }
    return;
  }
  ung = ranh;
  ung.forEach(function (s) { s._giu = dangGiu_(s.chat_id); });
  ung.sort(function (a, b) { return a._giu - b._giu || ms(a.luc_giao_cuoi) - ms(b.luc_giao_cuoi); });
  var s = ung[0], t = nowD(), dem = trongGio(ms(t));
  k.trang_thai = 'cho_nhan'; k.nguoi_giu = String(s.chat_id); k.ten_sale = s.ten; k.luc_giao = t; k.luc_nhan = ''; k.luc_bao_cao = ''; k.bao_cao = ''; k.nhac = ''; k.ly_do_dong = '';
  k.so_luot = Number(k.so_luot || 0) + 1;
  k.msg_id = gui_(s.chat_id, tinKhach_(k, false) + '\n\n' + dongHan_(k) + (dem ? '' : '\n(Ngoài giờ ' + num('GIO_BAT_DAU') + 'h–' + num('GIO_KET_THUC') + 'h không tính.)'),
    [[{text: '✅ Nhận khách', callback_data: 'n:' + k.id}]], !dem);
  save_('Khach', T_KHACH, k);
  s.luc_giao_cuoi = t; save_('Sale', T_SALE, s);
  log_(s.ten, 'được giao', k.id, 'lượt ' + k.so_luot);
}
function thuHoi_(k, lyDo) {
  sua_(k.nguoi_giu, k.msg_id, '⛔ <b>Khách ' + esc(k.id) + ' đã được thu hồi</b> (' + esc(lyDo) + ').\nSố điện thoại đã ẩn.');
  log_(k.ten_sale, 'thu hồi', k.id, lyDo);
  if (/^không bấm nhận/.test(lyDo)) {
    var hom = vnDay(Date.now()), ten = k.ten_sale;
    var lan = rows_('NhatKy', T_NK).filter(function (r) { return r.nguoi === ten && r.hanh_dong === 'thu hồi' && /^không bấm nhận/.test(r.chi_tiet) && vnDay(ms(r.thoi_gian)) === hom; }).length;
    var sl = timSale_(k.nguoi_giu);
    if (sl && sl.trang_thai === 'lam' && lan >= num('THU_HOI_TU_DUNG')) {
      sl.trang_thai = 'nghi'; save_('Sale', T_SALE, sl); log_('hệ thống', 'tự tạm dừng', '', sl.ten + ' bị thu hồi ' + lan + ' lần hôm nay');
      gui_(sl.chat_id, '⏸ Bạn bị thu hồi ' + lan + ' khách hôm nay vì không bấm nhận kịp, bot tạm dừng chia khách cho bạn. Báo quản lý để được mở lại.');
      baoQL_('⏸ Tự tạm dừng <b>' + esc(sl.ten) + '</b>: bị thu hồi ' + lan + ' lần hôm nay vì không nhận. Gõ <code>/mo ' + esc(sl.ten) + '</code> để mở lại.');
    }
  }
  var qua = String(k.da_qua || '').split(',').filter(String); qua.push(String(k.nguoi_giu)); k.da_qua = qua.join(',');
  baoQL_('🔁 Thu hồi ' + esc(k.id) + ' từ <b>' + esc(k.ten_sale) + '</b>: ' + esc(lyDo) + '. Đang giao bạn khác.');
  giao_(k);
}

/* --- kiểm tra hạn --- */
function kiemTraHan_() {
  var now = Date.now(), ngay = phutMotNgay();
  rows_('Khach', T_KHACH).forEach(function (k) {
    var st = k.trang_thai, p;
    if (st === 'cho_giao') { giao_(k); return; }
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
      if (p >= num('HAN_CHUYEN_DOI_NGAY') * ngay) thuHoi_(k, num('HAN_CHUYEN_DOI_NGAY') + ' ngày chưa chuyển đổi');
      else if (p >= num('NHAC_CHUYEN_DOI_NGAY') * ngay && !coNhac_(k, 'c')) { datNhac_(k, 'c'); save_('Khach', T_KHACH, k); nhac_(k, '⏰ <b>Báo cáo khách ' + esc(k.id) + ' để cập nhật</b>: còn khoảng ' + (num('HAN_CHUYEN_DOI_NGAY') - num('NHAC_CHUYEN_DOI_NGAY')) + ' ngày để lên Hẹn gặp / Khách nóng / Đã chốt.\n' + dongHan_(k)); }
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
    if (c === '/sale') { gui_(chat, danhSachSale_()); return; }
    if (c === '/baocao') { gui_(chat, baoCao_(Date.now())); return; }
    if (c === '/tam' || c === '/mo') {
      var x = rows_('Sale', T_SALE).filter(function (z) { return String(z.ten).toLowerCase().indexOf(arg.toLowerCase()) > -1 && arg; })[0];
      if (!x) { gui_(chat, 'Không tìm thấy sale "' + esc(arg) + '".'); return; }
      x.trang_thai = c === '/tam' ? 'nghi' : 'lam'; save_('Sale', T_SALE, x); log_('quản lý', c === '/tam' ? 'tạm dừng' : 'mở lại', '', x.ten);
      gui_(chat, (c === '/tam' ? '⏸ Tạm dừng chia cho ' : '▶️ Mở lại chia cho ') + esc(x.ten)); return;
    }
    gui_(chat, 'Lệnh quản lý: /sale · /baocao · /tuan · /tam Tên · /mo Tên · /xoa Tên'); return;
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
  if (c === '/nghi') { s.trang_thai = 'nghi'; save_('Sale', T_SALE, s); log_(s.ten, 'tự nghỉ'); gui_(chat, '⏸ Đã tạm dừng nhận khách. Nhắn /lam để nhận lại.'); return; }
  if (c === '/lam') { s.trang_thai = 'lam'; save_('Sale', T_SALE, s); log_(s.ten, 'đi làm'); gui_(chat, '▶️ Đã bật nhận khách.'); return; }
  if (c === '/khach') {
    var l = rows_('Khach', T_KHACH).filter(function (k) { return String(k.nguoi_giu) === chat && DANG_GIU.test(k.trang_thai) && k.trang_thai !== 'cho_nhan'; });
    gui_(chat, l.length ? '<b>Khách bạn đang giữ</b>\n' + l.map(function (k) { var h = han_(k); return '• ' + esc(k.id) + ' ' + esc(k.sdt) + ' – ' + esc(k.bao_cao || 'chưa báo cáo') + (h ? '\n   ⏱ ' + h.viec + ' trước <b>' + fmt(h.luc) + '</b>' : ''); }).join('\n') + '\n\nSau thời gian trên sẽ bị thu hồi.' : 'Bạn chưa giữ khách nào.'); return;
  }
  gui_(chat, 'Lệnh: /khach (khách đang giữ) · /nghi · /lam');
}

function bam_(q) {
  var chat = String(q.from.id), d = q.data || '', parts = d.split(':'), ok = '';
  function tl(t) { tg_('answerCallbackQuery', {callback_query_id: q.id, text: t || ''}); }
  if (parts[0] === 'dy' || parts[0] === 'tc') {
    if (chat !== String(quanLy_())) return tl('Chỉ quản lý được duyệt');
    var s = timSale_(parts[1]); if (!s) return tl('Không thấy');
    s.trang_thai = parts[0] === 'dy' ? 'lam' : 'tu_choi'; save_('Sale', T_SALE, s); log_('quản lý', parts[0] === 'dy' ? 'duyệt sale' : 'từ chối sale', '', s.ten);
    gui_(s.chat_id, parts[0] === 'dy' ? '✅ Quản lý đã duyệt. Bạn sẽ nhận khách lần lượt. Lệnh: /khach · /nghi · /lam' : 'Yêu cầu vào đội chưa được duyệt.');
    sua_(q.message.chat.id, q.message.message_id, (parts[0] === 'dy' ? '✅ Đã duyệt ' : '❌ Đã từ chối ') + esc(s.ten));
    return tl('Xong');
  }
  if (parts[0] === 'dd') {
    if (chat !== String(quanLy_())) return tl('Chỉ quản lý');
    var kdd = timKhach_(parts[1]); if (!kdd || kdd.trang_thai !== 'cho_duyet_dong') return tl('Không còn chờ duyệt');
    kdd.trang_thai = 'dong'; save_('Khach', T_KHACH, kdd); log_('quản lý', 'duyệt đóng khách', kdd.id, kdd.ly_do_dong);
    sua_(kdd.nguoi_giu, kdd.msg_id, tinKhach_(kdd, true) + '\n\n🚫 Đã đóng khách (quản lý duyệt). Lý do: ' + esc(kdd.ly_do_dong));
    sua_(q.message.chat.id, q.message.message_id, '✅ Đã đóng khách ' + esc(kdd.id) + ' của ' + esc(kdd.ten_sale) + '. Lý do: ' + esc(kdd.ly_do_dong));
    return tl('Đã đóng');
  }
  if (parts[0] === 'cl') {
    if (chat !== String(quanLy_())) return tl('Chỉ quản lý');
    var kc = timKhach_(parts[1]); if (!kc) return tl('Không thấy');
    if (kc.nguoi_giu && DANG_GIU.test(kc.trang_thai)) { P().deleteProperty('LYDO_' + kc.nguoi_giu); thuHoi_(kc, 'quản lý chia lại'); }
    else { kc.da_qua = ''; kc.so_luot = 0; giao_(kc); }
    log_('quản lý', 'chia lại', kc.id); return tl('Đã chia lại');
  }
  var k = timKhach_(parts[1]);
  if (!k || String(k.nguoi_giu) !== chat) return tl('Khách này không còn giao cho bạn');
  if (parts[0] === 'n') {
    if (k.trang_thai !== 'cho_nhan') return tl('Đã nhận rồi');
    k.trang_thai = 'da_nhan'; k.luc_nhan = nowD(); save_('Khach', T_KHACH, k); log_(k.ten_sale, 'nhận khách', k.id, 'xem số');
    sua_(chat, k.msg_id, tinKhach_(k, true) + '\n\n✅ Bạn đã nhận. Báo cáo khách này để cập nhật.\n' + dongHan_(k) + '\n(Hạn chuyển đổi: trước ' + fmt(hanLuc(k.luc_nhan, num('HAN_CHUYEN_DOI_NGAY') * phutMotNgay())) + ' · chỉ tính ' + num('GIO_BAT_DAU') + 'h–' + num('GIO_KET_THUC') + 'h)', nutBaoCao_(k.id));
    return tl('Đã nhận khách');
  }
  if (parts[0] === 'b' && BC[parts[2]]) {
    var code = parts[2];
    k.luc_bao_cao = nowD(); k.bao_cao = BC[code]; k.so_bao_cao = Number(k.so_bao_cao || 0) + 1;
    boNhac_(k, 'h');
    if (code === 'khong') {
      k.trang_thai = 'cho_ly_do'; save_('Khach', T_KHACH, k); log_(k.ten_sale, 'báo cáo', k.id, BC[code]);
      P().setProperty('LYDO_' + chat, k.id);
      sua_(chat, k.msg_id, tinKhach_(k, true) + '\n\n✍️ Gõ <b>1 dòng lý do</b> khách không có nhu cầu (ví dụ: đã mua dự án khác, sai số…). Quản lý duyệt mới đóng hẳn.');
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
  tl('');
}

/* ======================= BÁO CÁO ======================= */
function danhSachSale_() {
  var l = rows_('Sale', T_SALE).filter(function (s) { return s.trang_thai !== 'tu_choi'; });
  if (!l.length) return 'Chưa có sale nào. Sale nhắn bot /dangky Tên để xin vào đội.';
  return '<b>Đội chia khách</b>\n' + l.map(function (s) { return (s.trang_thai === 'lam' ? '▶️ ' : s.trang_thai === 'nghi' ? '⏸ ' : '⏳ ') + esc(s.ten) + ' – đang giữ ' + dangGiu_(s.chat_id); }).join('\n');
}
function baoCao_(t) {
  var hom = vnDay(t), nk = rows_('NhatKy', T_NK).filter(function (r) { return vnDay(ms(r.thoi_gian)) === hom; });
  var kh = rows_('Khach', T_KHACH), moi = kh.filter(function (k) { return vnDay(ms(k.luc_vao)) === hom; }).length;
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
  var tu = t - 7 * 86400000, by = {};
  var nk = rows_('NhatKy', T_NK).filter(function (r) { return ms(r.thoi_gian) >= tu && ms(r.thoi_gian) <= t; });
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
