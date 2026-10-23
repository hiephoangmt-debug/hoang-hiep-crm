/**
 * QUYỀN XEM LINK RIÊNG (mô hình 4D, chọn căn) – chỉ người có mã mới mở được.
 * Tab "Quyền xem" trong Google Sheet CRM:  Họ tên | Mã truy cập | Hết hạn (dd/mm/yyyy, để trống = không hạn) | Trạng thái (Hoạt động / Khóa) | Lần mở cuối | Số lần mở
 * - Cấp quyền: thêm 1 dòng, đặt mã riêng cho người đó (ví dụ: lan2026).
 * - Thu hồi: đổi Trạng thái thành "Khóa" hoặc xóa dòng – lần mở sau sẽ bị chặn.
 * Gọi qua jsonp_ (ChatAI.gs) với action=access.
 */
var QX_SHEET = 'Quyền xem';
function qxSheet_() {
  var ss = SpreadsheetApp.getActive(), sh = ss.getSheetByName(QX_SHEET);
  if (!sh) {
    sh = ss.insertSheet(QX_SHEET);
    sh.getRange(1, 1, 1, 6).setValues([['Họ tên', 'Mã truy cập', 'Hết hạn (dd/mm/yyyy)', 'Trạng thái', 'Lần mở cuối', 'Số lần mở']]).setFontWeight('bold');
    sh.setFrozenRows(1);
  }
  return sh;
}
function qxDate_(v) {
  if (v instanceof Date) return v;
  var m = String(v || '').trim().match(/^(\d{1,2})[\/.-](\d{1,2})[\/.-](\d{4})$/);
  return m ? new Date(+m[3], +m[2] - 1, +m[1], 23, 59, 59) : null;
}
function checkAccess_(p) {
  var code = String(p.code || '').trim().toLowerCase();
  if (!code || code.length < 4) return { access: false };
  var sh = qxSheet_(), last = sh.getLastRow();
  if (last < 2) return { access: false };
  var rows = sh.getRange(2, 1, last - 1, 6).getValues(), now = new Date();
  for (var i = 0; i < rows.length; i++) {
    var r = rows[i];
    if (String(r[1]).trim().toLowerCase() !== code) continue;
    if (/khóa|khoa|lock/i.test(String(r[3]))) return { access: false, reason: 'locked' };
    var exp = qxDate_(r[2]);
    if (exp && exp < now) return { access: false, reason: 'expired' };
    sh.getRange(i + 2, 5, 1, 2).setValues([[Utilities.formatDate(now, 'Asia/Ho_Chi_Minh', 'dd/MM/yyyy HH:mm') + (p.page ? ' · ' + String(p.page).slice(0, 40) : ''), (+r[5] || 0) + 1]]);
    return { access: true, name: String(r[0] || '') };
  }
  return { access: false };
}
