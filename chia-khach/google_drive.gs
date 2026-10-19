/**
 * LƯU DỮ LIỆU BOT CHIA KHÁCH LÊN GOOGLE DRIVE
 *
 *  • Tab "Khach"   : mỗi khách 1 dòng, tự cập nhật theo mã khách (trạng thái, người giữ, báo cáo…)
 *  • Tab "NhatKy"  : mọi thao tác (giao, nhận, xem SĐT, báo cáo, thu hồi…) — chỉ thêm, không sửa
 *  • Thư mục Drive "ChiaKhach_SaoLuu": mỗi ngày 1 file sao lưu toàn bộ dữ liệu (giữ 30 file gần nhất)
 *
 * Cách dùng: tạo Google Sheet mới → Tiện ích mở rộng → Apps Script → xoá hết, dán file này
 * → sửa SECRET giống SHEET_SECRET trong .env → Lưu → Triển khai → Tùy chọn triển khai mới
 * → Loại: Ứng dụng web · Thực thi với tư cách: Tôi · Ai có quyền truy cập: Bất kỳ ai
 * → Cho phép quyền → copy URL ứng dụng web dán vào SHEET_WEBHOOK_URL trong .env.
 */
var SECRET = 'doi-thanh-chuoi-bi-mat';
var THU_MUC_SAO_LUU = 'ChiaKhach_SaoLuu';
var GIU_SO_FILE = 30;

var COT_KHACH = ['id', 'ngay_vao', 'ten', 'sdt', 'nhu_cau', 'ngan_sach', 'muc_dich', 'loi_nhan', 'nguon',
  'trang_thai', 'nguoi_giu', 'so_luot', 'da_qua', 'bao_cao_cuoi', 'luc_bao_cao', 'tat_ca_ghi_chu', 'cap_nhat'];
var TIEU_DE_KHACH = ['Mã', 'Ngày vào', 'Tên', 'SĐT', 'Nhu cầu', 'Ngân sách', 'Mục đích', 'Lời nhắn', 'Nguồn',
  'Trạng thái', 'Người giữ', 'Số lượt', 'Đã qua', 'Báo cáo cuối', 'Lúc báo cáo', 'Toàn bộ ghi chú', 'Cập nhật'];
var TIEU_DE_NHAT_KY = ['Thời gian', 'Người', 'Hành động', 'Khách', 'Chi tiết'];

function traVe(o) {
  return ContentService.createTextOutput(JSON.stringify(o)).setMimeType(ContentService.MimeType.JSON);
}

function doGet() {
  return traVe({ ok: true, msg: 'Chia khach dang chay' });
}

function doPost(e) {
  var d;
  try { d = JSON.parse(e.postData.contents); } catch (err) { return traVe({ ok: false, error: 'json' }); }
  if (d.secret !== SECRET) return traVe({ ok: false, error: 'secret' });

  var lock = LockService.getScriptLock();
  lock.waitLock(30000);
  try {
    if (d.loai === 'khach') return traVe(ghiKhach(d.rows || []));
    if (d.loai === 'nhatky') return traVe(ghiNhatKy(d.rows || []));
    if (d.loai === 'saoluu') return traVe(saoLuu(d.ten, d.noi_dung));
    return traVe({ ok: false, error: 'loai' });
  } finally {
    lock.releaseLock();
  }
}

function layTab(ten, tieuDe) {
  var ss = SpreadsheetApp.getActiveSpreadsheet();
  var sh = ss.getSheetByName(ten);
  if (!sh) {
    sh = ss.insertSheet(ten);
    sh.getRange(1, 1, 1, tieuDe.length).setValues([tieuDe]).setFontWeight('bold')
      .setBackground('#0b2545').setFontColor('#ffffff');
    sh.setFrozenRows(1);
  }
  return sh;
}

function ghiKhach(rows) {
  var sh = layTab('Khach', TIEU_DE_KHACH);
  sh.getRange('D:D').setNumberFormat('@'); // giữ số 0 đầu SĐT
  var n = sh.getLastRow() - 1;
  var viTri = {};
  if (n > 0) {
    sh.getRange(2, 1, n, 1).getValues().forEach(function (r, i) { viTri[String(r[0])] = i + 2; });
  }
  var them = [];
  var luc = new Date();
  rows.forEach(function (o) {
    o.cap_nhat = luc;
    var dong = COT_KHACH.map(function (k) { return o[k] === undefined || o[k] === null ? '' : o[k]; });
    var r = viTri[String(o.id)];
    if (r) sh.getRange(r, 1, 1, dong.length).setValues([dong]);
    else them.push(dong);
  });
  if (them.length) sh.getRange(sh.getLastRow() + 1, 1, them.length, COT_KHACH.length).setValues(them);
  return { ok: true, sua: rows.length - them.length, them: them.length };
}

function ghiNhatKy(rows) {
  if (!rows.length) return { ok: true, them: 0 };
  var sh = layTab('NhatKy', TIEU_DE_NHAT_KY);
  var dong = rows.map(function (r) { return [r[0] || '', r[1] || '', r[2] || '', r[3] || '', r[4] || '']; });
  sh.getRange(sh.getLastRow() + 1, 1, dong.length, 5).setValues(dong);
  return { ok: true, them: dong.length };
}

function saoLuu(ten, noiDung) {
  var it = DriveApp.getFoldersByName(THU_MUC_SAO_LUU);
  var thuMuc = it.hasNext() ? it.next() : DriveApp.createFolder(THU_MUC_SAO_LUU);
  thuMuc.createFile(ten || ('chia_khach_' + Date.now() + '.json'), noiDung || '{}', MimeType.PLAIN_TEXT);
  var files = [];
  var fi = thuMuc.getFiles();
  while (fi.hasNext()) files.push(fi.next());
  files.sort(function (a, b) { return b.getDateCreated() - a.getDateCreated(); });
  files.slice(GIU_SO_FILE).forEach(function (f) { f.setTrashed(true); });
  return { ok: true, file: ten };
}
