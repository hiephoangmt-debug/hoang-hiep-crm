/**
 * QUYỀN XEM LINK RIÊNG (mô hình 4D, chọn căn) – chỉ người được cấp mới mở được.
 * Tab "Quyền xem":  A Họ tên | B Email (hoặc mã truy cập) | C Hết hạn (dd/mm/yyyy) | D Trạng thái (Hoạt động/Khóa) | E Lần mở cuối | F Số lần mở | G Gửi link (tick) | H Đã gửi link
 *  - Cột B là EMAIL: người xem nhập email → hệ thống gửi mã 6 số vào đúng hộp thư đó → nhập mã mới xem được (người khác không mở được).
 *  - Cột B là MÃ (không có @): nhập mã là xem (dùng cho chủ / nội bộ).
 *  - Thu hồi: Trạng thái = Khóa (hoặc xóa dòng) – phiên đang mở cũng bị chặn ở lần mở sau.
 *  - Gửi link qua mail: tick cột G rồi chạy hàm guiLinkQuyenXem (Apps Script → chọn hàm → Chạy).
 * Gọi qua jsonp_ (ChatAI.gs): action = access | access_req | access_otp
 */
var QX_SHEET = 'Quyền xem';
var QX_LINKS = {
  '4D nội bộ': 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/db77ab0f3df33e3f284972356c99e6ff658ca5d7/projects/sun-saphia/4d/sun-saphia-4d.html?crm',
  '4D – mặt bằng tầng': 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/db77ab0f3df33e3f284972356c99e6ff658ca5d7/projects/sun-saphia/4d/sun-saphia-4d.html?crm&plan&f=18',
  'Chọn căn (mặt bằng & 3D từng căn)': 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/79e9fad50d4250d512aa23783767a3b30669b846/projects/sun-saphia/chon-can/chon-can-app.html'
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
    MailApp.sendEmail({ to: email, subject: 'Mã xem mô hình Sun Saphia Residence: ' + otp,
      htmlBody: '<p>Chào ' + (f.row[0] || 'anh/chị') + ',</p><p>Mã xem mô hình 4D / mặt bằng Sun Saphia Residence của anh/chị là:</p>'
        + '<p style="font-size:28px;font-weight:800;letter-spacing:4px;color:#E8460F">' + otp + '</p><p>Mã có hiệu lực 10 phút, chỉ dùng cho email này. Không chuyển mã cho người khác.</p>'
        + '<p>Hoàng Hiệp · 0904 567 009</p>', name: 'Hoàng Hiệp · Sun Saphia' });
    return { sent: true };
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
    var links = Object.keys(QX_LINKS).map(function (k) { return '<li><a href="' + QX_LINKS[k] + '">' + k + '</a></li>'; }).join('');
    MailApp.sendEmail({ to: email, subject: 'Link xem mô hình 4D Sun Saphia Residence (dành riêng cho ' + email + ')',
      htmlBody: '<p>Chào ' + (r[0] || 'anh/chị') + ',</p><p>Hoàng Hiệp gửi anh/chị link xem mô hình 4D, mặt bằng tầng và chọn căn Sun Saphia Residence:</p><ul>' + links + '</ul>'
        + '<p>Khi mở link, anh/chị nhập <b>email này</b> → hệ thống gửi mã 6 số vào hộp thư → nhập mã là xem được (mỗi máy chỉ cần làm 1 lần / 30 ngày). Link chỉ dùng được với email của anh/chị.</p>'
        + '<p>Mọi thông tin là minh họa; thông số chính thức theo công bố và văn bản ký kết của chủ đầu tư.</p><p>Hoàng Hiệp · 0904 567 009 · Zalo 0904 567 009</p>',
      name: 'Hoàng Hiệp · Sun Saphia' });
    sh.getRange(i + 2, 8).setValue(Utilities.formatDate(new Date(), 'Asia/Ho_Chi_Minh', 'dd/MM/yyyy HH:mm')); n++;
  }
  return n;
}
