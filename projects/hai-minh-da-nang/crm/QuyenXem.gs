/**
 * QUYỀN XEM LINK RIÊNG (mô hình 4D, chọn căn) – chỉ người được cấp mới mở được.
 * Tab "Quyền xem":  A Họ tên | B Email (hoặc mã truy cập) | C Hết hạn (dd/mm/yyyy) | D Trạng thái (Hoạt động/Khóa) | E Lần mở cuối | F Số lần mở | G Gửi link (tick) | H Đã gửi link
 *  - Cột B là EMAIL: người xem nhập email → hệ thống gửi mã 6 số vào đúng hộp thư đó → nhập mã mới xem được (người khác không mở được).
 *  - Cột B là MÃ (không có @): nhập mã là xem (dùng cho chủ / nội bộ).
 *  - Thu hồi: Trạng thái = Khóa (hoặc xóa dòng) – phiên đang mở cũng bị chặn ở lần mở sau.
 *  - Gửi link đăng nhập vào Gmail: tick cột G → tự gửi (sau khi chạy caiTuDongGuiLink 1 lần), hoặc chạy hàm guiLinkQuyenXem.
 * Gọi qua jsonp_ (ChatAI.gs): action = access | access_req | access_otp
 */
var QX_SHEET = 'Quyền xem';
// Google OAuth Client ID (loại Web) dùng cho nút "Đăng nhập bằng Google" – dán vào đây hoặc đặt Script property GOOGLE_CLIENT_ID
var QX_GOOGLE_CLIENT_ID = '';
var QX_XEM_URL = 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/e1505b5f615d6ae1dd27fe855b929f324abc83e1/projects/sun-saphia/xem/xem-du-an.html';
var QX_LINKS = {
  'Xem dự án (4D + chọn căn + 3D cả tầng, đăng nhập 1 lần)': 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/e1505b5f615d6ae1dd27fe855b929f324abc83e1/projects/sun-saphia/xem/xem-du-an.html',
  '4D nội bộ': 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/381bfeda35d38bba6d5cdcc24d38fd549472c6c7/projects/sun-saphia/4d/sun-saphia-4d.html?crm',
  '4D – mặt bằng tầng': 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/381bfeda35d38bba6d5cdcc24d38fd549472c6c7/projects/sun-saphia/4d/sun-saphia-4d.html?crm&plan&f=18',
  'Chọn căn (mặt bằng & 3D từng căn)': 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/80faf2c22261708be9124fab457099933bd9b105/projects/sun-saphia/chon-can/chon-can-app.html'
};
function qxSheet_() {
  var ss = SpreadsheetApp.getActive(), sh = ss.getSheetByName(QX_SHEET);
  if (!sh) {
    sh = ss.insertSheet(QX_SHEET);
    sh.getRange(1, 1, 1, 8).setValues([['Họ tên', 'Email (hoặc mã truy cập)', 'Hết hạn (dd/mm/yyyy)', 'Trạng thái', 'Lần mở cuối', 'Số lần mở', 'Gửi link (tick)', 'Đã gửi link']]).setFontWeight('bold');
    sh.setFrozenRows(1);
  }
  return sh;
}
function qxDate_(v) {
  if (v instanceof Date) return v;
  var m = String(v || '').trim().match(/^(\d{1,2})[\/.-](\d{1,2})[\/.-](\d{4})$/);
  return m ? new Date(+m[3], +m[2] - 1, +m[1], 23, 59, 59) : null;
}
// tìm dòng còn hiệu lực theo email/mã; trả {i, row} hoặc {reason}
function qxFind_(id) {
  id = String(id || '').trim().toLowerCase();
  if (id.length < 4) return { reason: 'none' };
  var sh = qxSheet_(), last = sh.getLastRow();
  if (last < 2) return { reason: 'none' };
  var rows = sh.getRange(2, 1, last - 1, 6).getValues(), now = new Date();
  for (var i = 0; i < rows.length; i++) {
    if (String(rows[i][1]).trim().toLowerCase() !== id) continue;
    if (/khóa|khoa|lock/i.test(String(rows[i][3]))) return { reason: 'locked' };
    var exp = qxDate_(rows[i][2]);
    if (exp && exp < now) return { reason: 'expired' };
    return { i: i, row: rows[i], sh: sh };
  }
  return { reason: 'none' };
}
function qxTouch_(f, page) {
  var now = new Date();
  f.sh.getRange(f.i + 2, 5, 1, 2).setValues([[Utilities.formatDate(now, 'Asia/Ho_Chi_Minh', 'dd/MM/yyyy HH:mm') + (page ? ' · ' + String(page).slice(0, 40) : ''), (+f.row[5] || 0) + 1]]);
}
// link đăng nhập 1 chạm: tạo phiên 30 ngày gắn với email, gửi vào Gmail của người được cấp
function qxMagicLink_(email) {
  var tok = Utilities.getUuid().replace(/-/g, '');
  PropertiesService.getScriptProperties().setProperty('qx_t_' + tok, JSON.stringify({ e: email, x: Date.now() + 30 * 864e5 }));
  return QX_XEM_URL + '?k=' + encodeURIComponent('t:' + tok);
}
function qxMailLink_(email, name, otp) {
  var url = qxMagicLink_(email);
  MailApp.sendEmail({ to: email, subject: 'Link đăng nhập xem dự án Sun Saphia Residence',
    htmlBody: '<p>Chào ' + (name || 'anh/chị') + ',</p><p>Hoàng Hiệp đã cấp quyền cho <b>' + email + '</b> xem mô hình 4D, mặt bằng từng tầng, chọn căn và 3D cả tầng Sun Saphia Residence.</p>'
      + '<p style="margin:22px 0"><a href="' + url + '" style="background:#FF6A2B;color:#fff;font-weight:800;font-size:17px;padding:14px 26px;border-radius:12px;text-decoration:none;display:inline-block">Bấm để vào xem dự án</a></p>'
      + '<p>Bấm nút là vào thẳng, hoặc mở trang và nhập email này là vào. Máy đã mở sẽ được nhớ. Link đăng nhập dành riêng cho email này, vui lòng không chuyển cho người khác.</p>'
      + (otp ? '<p>Hoặc nhập mã <b style="font-size:20px;letter-spacing:3px;color:#E8460F">' + otp + '</b> trên trang (hiệu lực 10 phút).</p>' : '')
      + '<p>Mọi thông tin là minh họa; thông số chính thức theo công bố và văn bản ký kết của chủ đầu tư.</p><p>Hoàng Hiệp · 0904 567 009 · Zalo 0904 567 009</p>',
    name: 'Hoàng Hiệp · Sun Saphia' });
}
function accessRoute_(p) {
  var props = PropertiesService.getScriptProperties(), cache = CacheService.getScriptCache();
  if (p.action === 'access_req') {                       // bước 1: nhập email → gửi mã 6 số
    var email = String(p.email || '').trim().toLowerCase();
    if (!/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(email)) return { sent: false, reason: 'email' };
    var f = qxFind_(email);
    if (!f.row) return { sent: false, reason: f.reason };
    if (cache.get('qx_wait_' + email)) return { sent: true, wait: true };
    var otp = String(Math.floor(100000 + Math.random() * 900000));
    cache.put('qx_otp_' + email, otp, 600); cache.put('qx_wait_' + email, '1', 45);
    qxMailLink_(email, f.row[0], otp);
    return { sent: true };
  }
  if (p.action === 'access_login') {                     // nhập email đã được cấp (tab "Quyền xem", trạng thái Hoạt động) là vào, nhớ 1 năm trên máy đó
    var le = String(p.email || '').trim().toLowerCase();
    if (!/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(le)) return { access: false, reason: 'email' };
    var fl = qxFind_(le); if (!fl.row) return { access: false, reason: fl.reason };
    var lt = Utilities.getUuid().replace(/-/g, '');
    props.setProperty('qx_t_' + lt, JSON.stringify({ e: le, x: Date.now() + 365 * 864e5 }));
    qxTouch_(fl, (p.page || '') + ' · email');
    return { access: true, name: String(fl.row[0] || ''), token: 't:' + lt };
  }
  if (p.action === 'access_google') {                    // đăng nhập bằng Google: kiểm tra chữ ký Google rồi đối chiếu email với tab "Quyền xem"
    var cid = PropertiesService.getScriptProperties().getProperty('GOOGLE_CLIENT_ID') || QX_GOOGLE_CLIENT_ID;
    var res = UrlFetchApp.fetch('https://oauth2.googleapis.com/tokeninfo?id_token=' + encodeURIComponent(String(p.cred || '')), { muteHttpExceptions: true });
    if (res.getResponseCode() !== 200) return { access: false, reason: 'google' };
    var info = JSON.parse(res.getContentText());
    if (!cid || info.aud !== cid || String(info.email_verified) !== 'true') return { access: false, reason: 'google' };
    var ge = String(info.email || '').toLowerCase(), fg = qxFind_(ge);
    if (!fg.row) return { access: false, reason: fg.reason, email: ge };
    var gt = Utilities.getUuid().replace(/-/g, '');
    props.setProperty('qx_t_' + gt, JSON.stringify({ e: ge, x: Date.now() + 30 * 864e5 }));
    qxTouch_(fg, (p.page || '') + ' · Google');
    return { access: true, name: String(fg.row[0] || info.name || ''), token: 't:' + gt };
  }
  if (p.action === 'access_otp') {                       // bước 2: nhập mã 6 số → cấp phiên 30 ngày
    var em = String(p.email || '').trim().toLowerCase(), code = String(p.otp || '').trim();
    var ok = cache.get('qx_otp_' + em);
    if (!ok || ok !== code) return { access: false, reason: 'otp' };
    cache.remove('qx_otp_' + em);
    var f2 = qxFind_(em); if (!f2.row) return { access: false, reason: f2.reason };
    var tok = Utilities.getUuid().replace(/-/g, '');
    props.setProperty('qx_t_' + tok, JSON.stringify({ e: em, x: Date.now() + 30 * 864e5 }));
    qxTouch_(f2, p.page);
    return { access: true, name: String(f2.row[0] || ''), token: 't:' + tok };
  }
  // action = access: kiểm tra mã tĩnh hoặc phiên đã cấp
  var c = String(p.code || '').trim();
  if (/^t:/.test(c)) {
    var raw = props.getProperty('qx_t_' + c.slice(2)); if (!raw) return { access: false, reason: 'session' };
    var s = JSON.parse(raw); if (s.x < Date.now()) { props.deleteProperty('qx_t_' + c.slice(2)); return { access: false, reason: 'session' }; }
    var f3 = qxFind_(s.e); if (!f3.row) return { access: false, reason: f3.reason };
    qxTouch_(f3, p.page); return { access: true, name: String(f3.row[0] || '') };
  }
  if (c.indexOf('@') >= 0) return { access: false, reason: 'need_otp' };
  var f4 = qxFind_(c); if (!f4.row) return { access: false, reason: f4.reason };
  qxTouch_(f4, p.page); return { access: true, name: String(f4.row[0] || '') };
}
// giữ tương thích bản trước
function checkAccess_(p) { return accessRoute_(p); }

/** Gửi link riêng qua email cho các dòng đã tick cột G (Gửi link) mà chưa gửi. Chạy tay trong Apps Script. */
function guiLinkQuyenXem() {
  var sh = qxSheet_(), last = sh.getLastRow(); if (last < 2) return;
  var rows = sh.getRange(2, 1, last - 1, 8).getValues(), n = 0;
  for (var i = 0; i < rows.length; i++) {
    var r = rows[i], email = String(r[1]).trim();
    if (r[6] !== true || r[7] || email.indexOf('@') < 0 || /khóa|khoa/i.test(String(r[3]))) continue;
    qxMailLink_(email, r[0]);
    sh.getRange(i + 2, 8).setValue(Utilities.formatDate(new Date(), 'Asia/Ho_Chi_Minh', 'dd/MM/yyyy HH:mm')); n++;
  }
  return n;
}

/** Chạy 1 lần: từ đó tick ô cột G (Gửi link) ở tab "Quyền xem" là hệ thống tự gửi link đăng nhập vào Gmail người đó. */
function caiTuDongGuiLink() {
  ScriptApp.getProjectTriggers().forEach(function (t) { if (t.getHandlerFunction() === 'qxOnEdit_') ScriptApp.deleteTrigger(t); });
  ScriptApp.newTrigger('qxOnEdit_').forSpreadsheet(SpreadsheetApp.getActive()).onEdit().create();
}
function qxOnEdit_(e) {
  try { var r = e.range; if (r.getSheet().getName() !== QX_SHEET || r.getColumn() > 7 || r.getLastColumn() < 7) return; guiLinkQuyenXem(); } catch (err) {}
}
