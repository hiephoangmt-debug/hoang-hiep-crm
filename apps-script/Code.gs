/**
 * Báo cáo Marketing tuần – bản Google Apps Script.
 * Giao diện (Index.html) chạy trên trình duyệt; các hàm dưới đây đọc/ghi Google Drive
 * bằng chính tài khoản của người triển khai, nên không cần OAuth Client ID.
 */
var PPTX_MIME = 'application/vnd.openxmlformats-officedocument.presentationml.presentation';

/** ?page=baocao: trang tạo báo cáo từ Drive; mặc định: CRM. */
function doGet(e) {
  var q = (e && e.parameter) || {};
  var page = q.page || 'crm';
  if (page === 'huongdan') {
    // Trang hướng dẫn: nút "Mở CRM" trỏ về đúng link /exec của bản triển khai này
    var html = HtmlService.createHtmlOutputFromFile('HuongDan').getContent()
      .split('__APP_URL__').join(ScriptApp.getService().getUrl());
    return HtmlService.createHtmlOutput(html)
      .setTitle('Hướng dẫn cập nhật báo cáo')
      .addMetaTag('viewport', 'width=device-width, initial-scale=1');
  }
  if (page === 'bc') {
    // Báo cáo dạng trang web (link có mã riêng của từng báo cáo, ai có link đều xem được)
    return HtmlService.createHtmlOutputFromFile('BaoCaoWeb')
      .setTitle('Báo cáo Marketing tuần')
      .addMetaTag('viewport', 'width=device-width, initial-scale=1');
  }
  var report = page === 'baocao';
  return HtmlService.createHtmlOutputFromFile(report ? 'Index' : 'Crm')
    .setTitle(report ? 'Báo cáo Marketing' : 'CRM Báo cáo Marketing')
    .addMetaTag('viewport', 'width=device-width, initial-scale=1');
}

function exportBlob_(url) {
  var res = UrlFetchApp.fetch(url, {
    headers: { Authorization: 'Bearer ' + ScriptApp.getOAuthToken() },
    muteHttpExceptions: true,
  });
  if (res.getResponseCode() !== 200) {
    throw new Error('Không xuất được file (' + res.getResponseCode() + '): ' + url);
  }
  return res.getBlob();
}

/** Tải file theo ID; Google Sheets/Slides được xuất sang xlsx/pptx. Trả về base64. */
/** Chỉ người đã đăng nhập CRM (nhân sự đã khai) hoặc chủ ứng dụng mới đọc được dữ liệu / file. */
function crmRequireUser_(token) {
  if (!crmMe_(token).role) throw new Error('Bạn chưa đăng nhập CRM (đăng nhập bằng Gmail đã khai ở Danh mục › Nhân sự).');
}

function downloadFile(id, token) {
  crmRequireUser_(token);
  var f;
  try {
    f = DriveApp.getFileById(id);
  } catch (e) {
    throw new Error('Không mở được file ' + id + ' – kiểm tra link và quyền truy cập.');
  }
  var mt = f.getMimeType();
  var blob;
  if (mt === MimeType.GOOGLE_SHEETS) {
    blob = exportBlob_('https://docs.google.com/spreadsheets/d/' + id + '/export?format=xlsx');
  } else if (mt === MimeType.GOOGLE_SLIDES) {
    blob = exportBlob_('https://docs.google.com/presentation/d/' + id + '/export/pptx');
  } else {
    blob = f.getBlob();
  }
  return {
    meta: { id: id, name: f.getName(), mimeType: mt },
    b64: Utilities.base64Encode(blob.getBytes()),
    type: blob.getContentType() || mt,
  };
}

/** Liệt kê đệ quy mọi file trong thư mục; path = tên các thư mục cha (gồm thư mục gốc). */
function listTree(folderId, token) {
  crmRequireUser_(token);
  var root;
  try {
    root = DriveApp.getFolderById(folderId);
  } catch (e) {
    throw new Error('Không mở được thư mục ' + folderId + ' – kiểm tra link và quyền truy cập.');
  }
  var out = [];
  // Thêm tên thư mục cha (vd. tên nhân sự) vào đường dẫn để nhận diện ảnh của ai
  var prefix = [];
  try {
    var parents = root.getParents();
    if (parents.hasNext()) {
      var par = parents.next();
      if (par.getId() !== DriveApp.getRootFolder().getId()) prefix.push(par.getName());
    }
  } catch (e) { /* không có quyền xem thư mục cha */ }
  (function walk(folder, path) {
    var files = folder.getFiles();
    while (files.hasNext()) {
      var f = files.next();
      // người tải lên (chủ file) + ngày tải: để nhận ảnh của ai, tuần nào khi nhân viên tải thẳng lên Drive qua link
      var owner = '';
      try { owner = f.getOwner().getEmail(); } catch (e) { /* Drive dùng chung */ }
      out.push({ id: f.getId(), name: f.getName(), mimeType: f.getMimeType(), path: path, owner: owner,
        created: crmFileDay_(f) });
    }
    var subs = folder.getFolders();
    while (subs.hasNext()) {
      var s = subs.next();
      walk(s, path.concat([s.getName()]));
    }
  })(root, prefix.concat([root.getName()]));
  return out;
}

function crmFileDay_(f) {
  try { return Utilities.formatDate(f.getDateCreated(), Session.getScriptTimeZone(), 'yyyy-MM-dd'); } catch (e) { return ''; }
}

/** Bật "Bất kỳ ai có đường liên kết đều xem được" (bỏ qua nếu tổ chức chặn chia sẻ ra ngoài). */
function shareByLink_(file) {
  try { file.setSharing(DriveApp.Access.ANYONE_WITH_LINK, DriveApp.Permission.VIEW); }
  catch (e) {
    try { file.setSharing(DriveApp.Access.DOMAIN_WITH_LINK, DriveApp.Permission.VIEW); } catch (e2) { /* giữ quyền mặc định */ }
  }
  return file;
}

/** Tạo lại báo cáo: bỏ file PDF/PPTX cũ vào thùng rác (chỉ file báo cáo "Bao_cao_…" không còn dòng BaoCao nào dùng). */
function crmTrashReportFiles_(urls) {
  var inUse = JSON.stringify(crmRows_('BaoCao'));
  var n = 0;
  [].concat(urls || []).forEach(function (u) {
    var m = /\/d\/([\w-]{15,})/.exec(u || '');
    if (!m || inUse.indexOf(m[1]) >= 0) return;
    try {
      var f = DriveApp.getFileById(m[1]);
      if (/^Bao_cao_/.test(f.getName())) { f.setTrashed(true); n++; }
    } catch (e) { /* đã xoá */ }
  });
  return n;
}

/** File báo cáo cũ (link replaceUrl) còn dùng được để ghi đè – giữ nguyên link đã gửi. */
function reportFileToReplace_(replaceUrl) {
  var m = /\/d\/([\w-]{15,})/.exec(replaceUrl || '');
  if (!m) return null;
  try {
    var f = DriveApp.getFileById(m[1]);
    return !f.isTrashed() && /^Bao_cao_/.test(f.getName()) ? f : null;
  } catch (e) { return null; }
}
/** Ghi nội dung mới vào file Drive có sẵn (link không đổi). */
function overwriteFile_(file, bytes, mime) {
  var res = UrlFetchApp.fetch('https://www.googleapis.com/upload/drive/v3/files/' + file.getId() + '?uploadType=media&supportsAllDrives=true', {
    method: 'patch', contentType: mime, payload: bytes,
    headers: { Authorization: 'Bearer ' + ScriptApp.getOAuthToken() }, muteHttpExceptions: true,
  });
  return res.getResponseCode() === 200;
}

/**
 * File lớn gửi từng mảnh (điện thoại / mạng yếu hay lỗi "NetworkError" khi gửi cả file một lần):
 * mỗi mảnh base64 lưu tạm thành file văn bản trên Drive, trả về ID để ghép lại ở bước lưu.
 */
var UPLOAD_TMP = '_bcmkt_tmp_';
function uploadPart(token, b64) {
  crmRequireAdmin_(token);
  var f = DriveApp.getRootFolder().createFile(Utilities.newBlob(String(b64 || ''), 'text/plain', UPLOAD_TMP + Date.now() + '.txt'));
  return f.getId();
}
/** Dữ liệu gửi lên: chuỗi base64, hoặc {parts:[ID mảnh]} – ghép lại rồi bỏ các mảnh vào thùng rác. */
function uploadBytes_(data) {
  if (typeof data === 'string') return Utilities.base64Decode(data);
  var b64 = (data && data.parts || []).map(function (id) {
    var f = DriveApp.getFileById(id);
    if (f.getName().indexOf(UPLOAD_TMP) !== 0) throw new Error('Mảnh tải lên không hợp lệ.');
    var t = f.getBlob().getDataAsString();
    f.setTrashed(true);
    return t;
  }).join('');
  return Utilities.base64Decode(b64);
}
/** Thư mục lưu: thư mục báo cáo của dự án (trống = My Drive), thêm thư mục con theo tháng nếu có (tự tạo). */
function reportFolder_(folderId, sub) {
  var folder = folderId ? DriveApp.getFolderById(folderId) : DriveApp.getRootFolder();
  if (!sub) return folder;
  var it = folder.getFoldersByName(sub);
  return it.hasNext() ? it.next() : folder.createFolder(sub);
}

/** Lưu PPTX báo cáo vào Drive (thư mục chỉ định hoặc My Drive), trả về link. share = bật xem qua link.
 *  data: base64 hoặc {parts} (xem uploadPart). sub: thư mục con (vd "Tháng 10-2026").
 *  replaceUrl: link file báo cáo cũ của cùng kỳ/dự án – ghi đè vào đó để link đã gửi vẫn mở được bản mới. */
function saveReport(data, name, folderId, share, replaceUrl, token, sub) {
  crmRequireAdmin_(token);
  var bytes = uploadBytes_(data);
  var old = reportFileToReplace_(replaceUrl);
  if (old && overwriteFile_(old, bytes, PPTX_MIME)) {
    if (share) shareByLink_(old);
    return old.getUrl();
  }
  var file = reportFolder_(folderId, sub).createFile(Utilities.newBlob(bytes, PPTX_MIME, name));
  if (share) shareByLink_(file);
  return file.getUrl();
}

/**
 * Chuyển PPTX báo cáo sang PDF: tải lên Drive dạng Google Slides tạm, xuất PDF, xoá bản tạm.
 * Lưu PDF vào thư mục chỉ định (hoặc My Drive). Trả về {url, b64}.
 */
/** Tải PPTX lên Drive dưới dạng Google Slides (tạm) – trả ID file Slides. */
function pptxToSlides_(bytes, name) {
  var boundary = 'bcmkt' + Date.now();
  var meta = JSON.stringify({ name: name.replace(/\.pptx$/i, '') + ' (tạm)', mimeType: 'application/vnd.google-apps.presentation' });
  var head = Utilities.newBlob('--' + boundary + '\r\nContent-Type: application/json; charset=UTF-8\r\n\r\n' + meta +
    '\r\n--' + boundary + '\r\nContent-Type: ' + PPTX_MIME + '\r\n\r\n').getBytes();
  var tail = Utilities.newBlob('\r\n--' + boundary + '--').getBytes();
  var payload = head.concat(bytes).concat(tail);
  var res = UrlFetchApp.fetch('https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart&supportsAllDrives=true', {
    method: 'post',
    contentType: 'multipart/related; boundary=' + boundary,
    payload: payload,
    headers: { Authorization: 'Bearer ' + ScriptApp.getOAuthToken() },
    muteHttpExceptions: true,
  });
  if (res.getResponseCode() !== 200) {
    throw new Error('Không chuyển được sang Google Slides (' + res.getResponseCode() + '): ' + res.getContentText().slice(0, 200));
  }
  return JSON.parse(res.getContentText()).id;
}

/** Chuyển PPTX đã lưu trên Drive (link pptxUrl) sang PDF – không phải gửi lại cả file từ máy. */
function convertSavedToPdf(pptxUrl, name, folderId, share, replaceUrl, token, sub) {
  crmRequireAdmin_(token);
  var m = /\/d\/([\w-]{15,})/.exec(pptxUrl || '');
  if (!m) throw new Error('Chưa có file PPTX để chuyển PDF.');
  return pdfFromBytes_(DriveApp.getFileById(m[1]).getBlob().getBytes(), name, folderId, share, replaceUrl, sub);
}
function convertToPdf(data, name, folderId, share, replaceUrl, token, sub) {
  crmRequireAdmin_(token);
  return pdfFromBytes_(uploadBytes_(data), name, folderId, share, replaceUrl, sub);
}
function pdfFromBytes_(bytes, name, folderId, share, replaceUrl, sub) {
  var tmpId = pptxToSlides_(bytes, name);
  try {
    var pdf = exportBlob_('https://docs.google.com/presentation/d/' + tmpId + '/export/pdf')
      .setName(name.replace(/\.pptx$/i, '') + '.pdf');
    var old = reportFileToReplace_(replaceUrl);
    if (old && overwriteFile_(old, pdf.getBytes(), 'application/pdf')) {
      if (share) shareByLink_(old);
      return { url: old.getUrl(), b64: share ? '' : Utilities.base64Encode(pdf.getBytes()) };
    }
    var file = reportFolder_(folderId, sub).createFile(pdf);
    if (share) shareByLink_(file);
    return { url: file.getUrl(), b64: share ? '' : Utilities.base64Encode(pdf.getBytes()) };
  } finally {
    DriveApp.getFileById(tmpId).setTrashed(true);
  }
}

/**
 * Trang hướng dẫn: PDF của file PPTX mẫu (các slide hướng dẫn chụp nghiệm thu).
 * Chuyển một lần rồi giữ trong Drive của bạn (không chia sẻ); mẫu đổi thì tự chuyển lại.
 */
function crmGuideDeck() {
  var tplId = '';
  try {
    crmRows_('DuAn').some(function (p) {
      var m = /\/d\/([\w-]{15,})/.exec(p.mauPptx || '') || /[?&]id=([\w-]{15,})/.exec(p.mauPptx || '') || /^([\w-]{15,})$/.exec(p.mauPptx || '');
      tplId = m ? m[1] : '';
      return !!tplId;
    });
  } catch (e) { /* chưa có CRM: dùng mẫu mặc định */ }
  tplId = tplId || DEFAULT_TEMPLATE;
  var tpl = DriveApp.getFileById(tplId);
  var key = tplId + '|' + tpl.getLastUpdated().getTime();
  var props = PropertiesService.getScriptProperties();
  var cached = props.getProperty('GUIDE_PDF_ID');
  if (cached && props.getProperty('GUIDE_PDF_KEY') === key) {
    try {
      var f0 = DriveApp.getFileById(cached);
      if (!f0.isTrashed()) return { b64: Utilities.base64Encode(f0.getBlob().getBytes()), name: tpl.getName() };
    } catch (e) { /* đã xoá: tạo lại */ }
  }
  var isSlides = tpl.getMimeType() === MimeType.GOOGLE_SLIDES;
  var slidesId = isSlides ? tplId : pptxToSlides_(tpl.getBlob().getBytes(), tpl.getName());
  var pdf;
  try {
    pdf = exportBlob_('https://docs.google.com/presentation/d/' + slidesId + '/export/pdf')
      .setName('Hướng dẫn nghiệm thu (tự tạo từ mẫu – không xoá).pdf');
  } finally {
    if (!isSlides) DriveApp.getFileById(slidesId).setTrashed(true);
  }
  if (cached) { try { DriveApp.getFileById(cached).setTrashed(true); } catch (e) { /* bỏ qua */ } }
  var file = DriveApp.getRootFolder().createFile(pdf);
  props.setProperty('GUIDE_PDF_ID', file.getId());
  props.setProperty('GUIDE_PDF_KEY', key);
  return { b64: Utilities.base64Encode(pdf.getBytes()), name: tpl.getName() };
}

// =====================================================================
// CRM: dữ liệu lưu trong Google Sheet "CRM Báo cáo Marketing" (tự tạo).
// Mỗi bảng một trang tính; hàng 1 là tiêu đề, cột A là ID.
// =====================================================================
var CRM_TABLES = {
  DuAn: [['id', 'ID'], ['ten', 'Tên dự án'], ['khoa', 'Tên thư mục dự án trên Drive'], ['chienDich', 'Tên chiến dịch (tiêu đề báo cáo)'],
    ['mauPptx', 'Link PPTX mẫu'], ['thuMucChungTu', 'Thư mục chứng từ'], ['thuMucBaoCao', 'Thư mục lưu báo cáo'],
    ['nguonSoLieu', 'Google Sheet số liệu (để nhập)'], ['logo', 'Đơn vị / Logo (TATILAND / TATI INVEST)']],
  NhanSu: [['id', 'ID'], ['ten', 'Tên'], ['email', 'Email'], ['trangThai', 'Trạng thái'],
    ['vaiTro', 'Vai trò (Nhân viên / Quản trị)'], ['dienThoai', 'Điện thoại'], ['hoTen', 'Họ tên đầy đủ']],
  TaiKhoan: [['id', 'ID'], ['maTaiKhoan', 'ID tài khoản QC'], ['ten', 'Tên tài khoản'], ['nenTang', 'Nền tảng'], ['nhanSu', 'Nhân sự']],
  SoLieu: [['id', 'ID'], ['tuan', 'Tuần (thứ 2)'], ['duAn', 'Dự án'], ['nhanSu', 'Nhân sự'], ['nenTang', 'Nền tảng'],
    ['taiKhoan', 'ID tài khoản QC'], ['chienDich', 'Chiến dịch'], ['chiPhi', 'Chi phí thực chạy'], ['chiPhiPhi', 'Chi phí gồm phí nền tảng'],
    ['lead', 'Lead'], ['hienThi', 'Hiển thị'], ['tiepCan', 'Tiếp cận'], ['luotNhap', 'Lượt nhấp'], ['luotXem', 'Lượt xem'],
    ['mql', 'MQL'], ['sql', 'SQL'], ['deal', 'DEAL'], ['ghiChu', 'Ghi chú'], ['nguon', 'Nguồn'], ['nguoiTao', 'Người tạo'], ['ngayTao', 'Ngày tạo']],
  ChungTu: [['id', 'ID'], ['tuan', 'Tuần (thứ 2)'], ['duAn', 'Dự án'], ['nhanSu', 'Nhân sự'], ['nenTang', 'Nền tảng'], ['loai', 'Loại'],
    ['fileId', 'File ID'], ['tenFile', 'Tên file'], ['url', 'Link'], ['nguoiTao', 'Người tạo'], ['ngayTao', 'Ngày tạo'],
    ['hash', 'Mã nội dung (chống trùng)'], ['soTien', 'Số tiền hoá đơn (gồm VAT)'], ['vat', 'VAT %']],
  BaoCao: [['id', 'ID'], ['tuan', 'Tuần (thứ 2)'], ['duAn', 'Dự án'], ['trangThai', 'Trạng thái'], ['pdfUrl', 'PDF'], ['pptxUrl', 'PPTX'],
    ['tomTat', 'Tóm tắt'], ['nguoiTao', 'Người tạo'], ['ngayTao', 'Ngày tạo'], ['webKey', 'Mã link báo cáo web']],
};
var CRM_TEXT_COLS = ['id', 'tuan', 'taiKhoan', 'maTaiKhoan', 'fileId', 'ngayTao', 'hash'];
var EVIDENCE_ROOT = '146YOZUIiLizOl0waxcqAPw4uzY_jvmzt';
var DEFAULT_TEMPLATE = '10S0gG5T_o1WOqqkvUiFdwdhauqoa9mA6';
var CRM_SEED = {
  DuAn: [
    { ten: 'Casamia', khoa: 'Casamia', chienDich: 'CASAMIA BALANCA HOI AN-TATI INVEST ĐỢT 1',
      mauPptx: 'https://drive.google.com/file/d/10S0gG5T_o1WOqqkvUiFdwdhauqoa9mA6/view',
      thuMucChungTu: 'https://drive.google.com/drive/folders/' + EVIDENCE_ROOT,
      nguonSoLieu: 'https://docs.google.com/spreadsheets/d/1R_mmNKG_XA6qZrKmzuEAO79OA1Z-xe8jdg63ItufgnU/edit', logo: 'TATI INVEST' },
    { ten: 'Sun', khoa: 'Sun', chienDich: 'SUN GROUP ĐÀ NẴNG - TATI INVEST',
      mauPptx: 'https://drive.google.com/file/d/10S0gG5T_o1WOqqkvUiFdwdhauqoa9mA6/view',
      thuMucChungTu: 'https://drive.google.com/drive/folders/' + EVIDENCE_ROOT,
      nguonSoLieu: 'https://docs.google.com/spreadsheets/d/1K1nmmwasaN7kRrKUrqoMPSOFoGhawIZMF2OEiYaQ2iU/edit', logo: 'TATILAND' },
  ],
  NhanSu: [{ ten: 'Mỹ Linh' }, { ten: 'Phan Hạnh' }, { ten: 'Anh Tài' }, { ten: 'Ngà Ngô' }],
  TaiKhoan: [
    { maTaiKhoan: '1091790822198238', nenTang: 'Facebook', nhanSu: 'Mỹ Linh' },
    { maTaiKhoan: '391127499725110', nenTang: 'Facebook', nhanSu: 'Phan Hạnh' },
    { maTaiKhoan: '739157991258993', nenTang: 'Facebook', nhanSu: 'Anh Tài' },
    { maTaiKhoan: '741161304397896', nenTang: 'Facebook', nhanSu: 'Ngà Ngô' },
  ],
};

function crmBook_() {
  var props = PropertiesService.getScriptProperties();
  var id = props.getProperty('CRM_SHEET_ID');
  var ss = null;
  if (id) {
    try { ss = SpreadsheetApp.openById(id); } catch (e) { ss = null; }
  }
  if (!ss) {
    ss = SpreadsheetApp.create('CRM Báo cáo Marketing');
    props.setProperty('CRM_SHEET_ID', ss.getId());
  }
  return ss;
}

function crmSheet_(name) {
  if (!CRM_TABLES[name]) throw new Error('Bảng không hợp lệ: ' + name);
  var ss = crmBook_();
  var sh = ss.getSheetByName(name);
  if (!sh) {
    var cols = CRM_TABLES[name];
    sh = ss.insertSheet(name);
    sh.getRange(1, 1, 1, cols.length).setValues([cols.map(function (c) { return c[1]; })]).setFontWeight('bold');
    sh.setFrozenRows(1);
    // giữ dạng chữ cho ID/ngày để Sheets không tự đổi thành số/ngày
    cols.forEach(function (c, i) {
      if (CRM_TEXT_COLS.indexOf(c[0]) >= 0) sh.getRange(1, i + 1, sh.getMaxRows(), 1).setNumberFormat('@');
    });
    var blank = ss.getSheetByName('Sheet1') || ss.getSheetByName('Trang tính1');
    if (blank && ss.getSheets().length > 1) ss.deleteSheet(blank);
  } else {
    // bảng đã có từ phiên bản trước: bổ sung tiêu đề cột mới (cột mới luôn thêm ở cuối)
    var cols2 = CRM_TABLES[name];
    var head = sh.getRange(1, 1, 1, cols2.length).getValues()[0];
    if (head[cols2.length - 1] === '') {
      sh.getRange(1, 1, 1, cols2.length).setValues([cols2.map(function (c) { return c[1]; })]);
    }
  }
  return sh;
}

function crmCell_(v) {
  if (v instanceof Date) return Utilities.formatDate(v, Session.getScriptTimeZone(), 'yyyy-MM-dd');
  return v;
}

/**
 * Mã tuần chuẩn (ngày bắt đầu tuần). Từ 10/10/2026 tuần chạy thứ 7 → thứ 6, nên mọi ngày từ 10/10 được quy về thứ 7 đầu tuần
 * (vd "2026-10-12" do bản cũ tính theo thứ 2 -> "2026-10-10"). Tuần trước đó giữ nguyên; tháng ("2026-10") / "all" giữ nguyên.
 */
function crmWeekKey_(iso) {
  iso = String(iso || '');
  if (!/^\d{4}-\d{2}-\d{2}$/.test(iso) || iso < '2026-10-10') return iso;
  var p = iso.split('-').map(Number), d = new Date(p[0], p[1] - 1, p[2]);
  d.setDate(d.getDate() - (d.getDay() + 1) % 7);
  return d.getFullYear() + '-' + ('0' + (d.getMonth() + 1)).slice(-2) + '-' + ('0' + d.getDate()).slice(-2);
}
var CRM_WEEK_TABLES = ['SoLieu', 'ChungTu', 'BaoCao'];

function crmRows_(name) {
  var keys = CRM_TABLES[name].map(function (c) { return c[0]; });
  var vals = crmSheet_(name).getDataRange().getValues();
  var week = CRM_WEEK_TABLES.indexOf(name) >= 0;
  return vals.slice(1).filter(function (r) { return r[0] !== ''; }).map(function (r) {
    var o = {};
    keys.forEach(function (k, i) { o[k] = r[i] === undefined ? '' : crmCell_(r[i]); });
    if (week) o.tuan = crmWeekKey_(o.tuan);
    return o;
  });
}

/** Ghi lại mã tuần chuẩn vào sheet nếu còn dòng kiểu cũ (vd tuần "2026-10-12" nhập bằng bản cũ). */
function crmFixWeeks_() {
  CRM_WEEK_TABLES.forEach(function (t) {
    var col = CRM_TABLES[t].map(function (c) { return c[0]; }).indexOf('tuan');
    var raw = crmSheet_(t).getDataRange().getValues().slice(1).filter(function (r) { return r[0] !== ''; });
    if (raw.some(function (r) { return String(crmCell_(r[col])) !== crmWeekKey_(crmCell_(r[col])); })) crmWriteAll_(t, crmRows_(t));
  });
}

function crmWriteAll_(name, rows) {
  var keys = CRM_TABLES[name].map(function (c) { return c[0]; });
  var sh = crmSheet_(name);
  var last = sh.getLastRow();
  if (last > 1) sh.getRange(2, 1, last - 1, keys.length).clearContent();
  if (rows.length) {
    sh.getRange(2, 1, rows.length, keys.length).setValues(rows.map(function (o) {
      return keys.map(function (k) { return o[k] === undefined || o[k] === null ? '' : o[k]; });
    }));
  }
}

var CRM_ACTOR = ''; // email người đăng nhập (ghi vào cột "Người tạo")
function crmUser_() {
  if (CRM_ACTOR) return CRM_ACTOR;
  try { return Session.getActiveUser().getEmail() || Session.getEffectiveUser().getEmail() || ''; } catch (e) { return ''; }
}

function crmStamp_(o) {
  if (!o.id) o.id = Utilities.getUuid().replace(/-/g, '').slice(0, 10);
  if (o.tuan) o.tuan = crmWeekKey_(o.tuan);
  if (!o.ngayTao) {
    o.ngayTao = Utilities.formatDate(new Date(), Session.getScriptTimeZone(), 'yyyy-MM-dd HH:mm');
  }
  if (!o.nguoiTao) o.nguoiTao = crmUser_();
  return o;
}

function crmWithLock_(fn) {
  var lock = LockService.getScriptLock();
  lock.waitLock(20000);
  try { return fn(); } finally { lock.releaseLock(); }
}

/** Lần đầu: tạo bảng + dữ liệu mẫu; trả về mọi bảng cho giao diện. */
function crmBootstrap(token) {
  crmWithLock_(function () {
    Object.keys(CRM_SEED).forEach(function (t) {
      if (!crmRows_(t).length) crmWriteAll_(t, CRM_SEED[t].map(function (o) { return crmStamp_(JSON.parse(JSON.stringify(o))); }));
    });
    // bổ sung logo cho dự án mẫu đã tạo ở phiên bản trước
    var projects = crmRows_('DuAn'), changed = false;
    projects.forEach(function (p) {
      var seed = CRM_SEED.DuAn.filter(function (x) { return x.ten === p.ten; })[0];
      if (seed && !p.logo && seed.logo) { p.logo = seed.logo; changed = true; }
    });
    if (changed) crmWriteAll_('DuAn', projects);
    crmFixWeeks_();
  });
  var me = crmMe_(token);
  var out = { schema: CRM_TABLES, sheetUrl: me.role === 'admin' ? crmBook_().getUrl() : '', user: crmUser_(), me: me };
  try { out.appUrl = ScriptApp.getService().getUrl(); } catch (e) { out.appUrl = ''; }
  // chưa đăng nhập: không trả dữ liệu (trang chỉ hiện ô đăng nhập)
  Object.keys(CRM_TABLES).forEach(function (t) { out[t] = me.role ? crmPublic_(t, crmRows_(t)) : []; });
  return out;
}

/** Tạo sẵn thư mục dự án trong các thư mục kênh – gọi ngầm sau khi CRM đã mở (không làm chậm lúc tải). */
function crmPrepareFolders(token) {
  if (crmMe_(token).role !== 'admin') return false;
  crmEnsureEvidenceFolders_();
  return true;
}

function crmList(name, token) {
  crmRequireUser_(token);
  return crmPublic_(name, crmRows_(name));
}

// =====================================================================
// PHÂN QUYỀN
// - Quản trị: chủ ứng dụng (tài khoản Google triển khai) hoặc nhân sự có vai trò "Quản trị" đăng nhập bằng PIN.
// - Nhân viên: đăng nhập bằng tên + PIN (đặt ở Danh mục › Nhân sự); chỉ thêm/sửa/xoá số liệu và chứng từ
//   của CHÍNH MÌNH (cột Nhân sự = tên mình). Danh mục, nhập từ Sheet, báo cáo, chia sẻ: chỉ quản trị.
// Trang chỉ gọi được crmCall(token, hàm, tham số); các hàm ghi dữ liệu đều có đuôi "_" (không gọi trực tiếp được).
// =====================================================================
function crmPublic_(table, rows) {
  return rows;
}

// Đăng nhập bằng email: nhập email (đã khai ở Danh mục › Nhân sự) -> app gửi mã 6 số vào email đó -> nhập mã.
// Chủ ứng dụng (tài khoản Google triển khai) tự là quản trị, không cần mã.
function crmSecret_() {
  var props = PropertiesService.getScriptProperties();
  var k = props.getProperty('CRM_SECRET');
  if (!k) { k = Utilities.getUuid() + Utilities.getUuid(); props.setProperty('CRM_SECRET', k); }
  return k;
}
function crmSign_(email) {
  var raw = Utilities.computeHmacSha256Signature('mail|' + email, crmSecret_());
  return Utilities.base64EncodeWebSafe(raw).replace(/=+$/, '');
}
function crmIsOwner_() {
  try {
    var a = Session.getActiveUser().getEmail(), e = Session.getEffectiveUser().getEmail();
    return !!a && a === e;
  } catch (err) { return false; }
}
/** Các email của một nhân sự (một người có thể khai nhiều Gmail, cách nhau bằng dấu phẩy). */
function crmEmails_(n) {
  return String(n.email || '').toLowerCase().split(/[\s,;|]+/).filter(function (e) { return /@/.test(e); });
}
function crmStaffByEmail_(email) {
  email = String(email || '').trim().toLowerCase();
  if (!email) return null;
  return crmRows_('NhanSu').filter(function (n) {
    return n.trangThai !== 'Nghỉ' && crmEmails_(n).indexOf(email) >= 0;
  })[0] || null;
}
/** Người đang dùng: {name, email, role: 'admin'|'staff'|'', owner} */
function crmMe_(token) {
  if (crmIsOwner_()) return { name: '', email: crmUser_(), role: 'admin', owner: true };
  var t = String(token || ''), i = t.lastIndexOf('.');
  if (i < 1) return { name: '', role: '' };
  var email = '';
  try { email = Utilities.newBlob(Utilities.base64DecodeWebSafe(t.slice(0, i))).getDataAsString(); } catch (e) { return { name: '', role: '' }; }
  var ns = crmStaffByEmail_(email);
  if (!ns || crmSign_(email.trim().toLowerCase()) !== t.slice(i + 1)) return { name: '', role: '' };
  return { name: ns.ten, email: email, role: /quan tri|quản trị|admin/i.test(String(ns.vaiTro || '')) ? 'admin' : 'staff' };
}
/**
 * Đăng nhập bằng Gmail đã được quản trị khai ở Danh mục › Nhân sự – không cần mã/mật khẩu.
 * (Muốn bắt buộc mã gửi qua email: đặt thuộc tính dự án CRM_LOGIN_CODE = on.)
 */
function crmLoginEmail(email) {
  email = String(email || '').trim().toLowerCase();
  var ns = crmStaffByEmail_(email);
  if (!ns) throw new Error('Email ' + email + ' chưa có trong danh sách nhân sự – nhờ quản trị thêm email của bạn ở Danh mục › Nhân sự.');
  if (PropertiesService.getScriptProperties().getProperty('CRM_LOGIN_CODE') === 'on') {
    crmSendCode(email);
    return { needCode: true, name: ns.ten };
  }
  var token = Utilities.base64EncodeWebSafe(Utilities.newBlob(email).getBytes()).replace(/=+$/, '') + '.' + crmSign_(email);
  return { token: token, me: crmMe_(token) };
}

/** Bước 1: gửi mã đăng nhập vào email (email phải có trong Danh mục › Nhân sự). */
function crmSendCode(email) {
  email = String(email || '').trim().toLowerCase();
  var ns = crmStaffByEmail_(email);
  if (!ns) throw new Error('Email ' + email + ' chưa có trong danh sách nhân sự – nhờ quản trị thêm email của bạn ở Danh mục › Nhân sự.');
  var cache = CacheService.getScriptCache();
  var code = String(Math.floor(100000 + Math.random() * 900000));
  cache.put('code:' + email, code, 600);
  cache.remove('try:' + email);
  MailApp.sendEmail(email, 'Mã đăng nhập CRM Báo cáo Marketing: ' + code,
    'Chào ' + ns.ten + ',\n\nMã đăng nhập CRM Báo cáo Marketing của bạn là: ' + code + '\n(Mã có hiệu lực 10 phút.)\n\nNếu bạn không yêu cầu, hãy bỏ qua email này.');
  return { name: ns.ten };
}
/** Bước 2: nhập mã -> token (lưu ở trình duyệt; đổi email / cho nghỉ là token hết hiệu lực). */
function crmLoginCode(email, code) {
  email = String(email || '').trim().toLowerCase();
  var cache = CacheService.getScriptCache();
  var tries = Number(cache.get('try:' + email) || 0);
  if (tries >= 5) throw new Error('Nhập sai quá nhiều lần – bấm "Gửi mã" để nhận mã mới.');
  var real = cache.get('code:' + email);
  if (!real) throw new Error('Mã đã hết hạn – bấm "Gửi mã" để nhận mã mới.');
  if (String(code || '').replace(/\D/g, '') !== real) { cache.put('try:' + email, String(tries + 1), 600); throw new Error('Sai mã.'); }
  cache.remove('code:' + email);
  var ns = crmStaffByEmail_(email);
  if (!ns) throw new Error('Email không còn trong danh sách nhân sự.');
  var token = Utilities.base64EncodeWebSafe(Utilities.newBlob(email).getBytes()).replace(/=+$/, '') + '.' + crmSign_(email);
  return { token: token, me: crmMe_(token) };
}

// ---------------------------------------------------------------------
// Báo cáo web: dữ liệu + ảnh theo mã link (webKey) của báo cáo
// ---------------------------------------------------------------------
function crmWebReport_(k) {
  k = String(k || '');
  var bc = k.length >= 16 && crmRows_('BaoCao').filter(function (r) { return r.webKey === k; })[0];
  if (!bc) throw new Error('Link báo cáo không đúng hoặc đã bị thay. Nhờ quản trị gửi lại link mới.');
  return bc;
}
/** Tháng của một tuần = tháng chứa ngày giữa tuần (ngày thứ 4 kể từ ngày bắt đầu; tuần vắt qua 2 tháng chỉ tính 1 lần). "2026-09-28" -> "2026-10" */
function crmWeekMonth_(iso) {
  var p = String(iso).split('-').map(Number), d = new Date(p[0], p[1] - 1, p[2] + 3);
  return d.getFullYear() + '-' + ('0' + (d.getMonth() + 1)).slice(-2);
}
/** Kỳ báo cáo theo mã: tuần "2026-10-05", tháng "2026-10", toàn chiến dịch "all". */
function crmReportScope_(key, allWeeks) {
  key = String(key);
  allWeeks = allWeeks.slice().sort();
  if (/^\d{4}-\d{2}-\d{2}$/.test(key)) {
    // tuần trước = tuần có số liệu ngay trước (từ 10/10/2026 tuần đổi sang thứ 7 – thứ 6 nên không luôn là -7 ngày)
    var before = allWeeks.filter(function (w) { return w < key; });
    var p = key.split('-').map(Number), d = new Date(p[0], p[1] - 1, p[2] - 7);
    var prev = before.length ? before[before.length - 1]
      : d.getFullYear() + '-' + ('0' + (d.getMonth() + 1)).slice(-2) + '-' + ('0' + d.getDate()).slice(-2);
    return { ky: 'tuan', weeks: [key], prevWeeks: [prev] };
  }
  if (/^\d{4}-\d{2}$/.test(key)) {
    var y = +key.slice(0, 4), m = +key.slice(5, 7) - 1;
    var pm = (m === 0 ? y - 1 : y) + '-' + ('0' + (m === 0 ? 12 : m)).slice(-2);
    return { ky: 'thang', weeks: allWeeks.filter(function (w) { return crmWeekMonth_(w) === key; }),
      prevWeeks: allWeeks.filter(function (w) { return crmWeekMonth_(w) === pm; }) };
  }
  return { ky: 'all', weeks: allWeeks, prevWeeks: [] };
}
function crmWebReport(k) {
  var bc = crmWebReport_(k);
  var pj = crmRows_('DuAn').filter(function (p) { return p.ten === bc.duAn; })[0] || {};
  var pick = function (r, keys) { var o = {}; keys.forEach(function (x) { o[x] = r[x]; }); return o; };
  var cols = ['tuan', 'nhanSu', 'nenTang', 'taiKhoan', 'chienDich', 'chiPhi', 'chiPhiPhi', 'lead', 'mql', 'sql', 'deal', 'hienThi', 'tiepCan', 'luotNhap', 'luotXem', 'nguon'];
  var rows = crmRows_('SoLieu').filter(function (r) { return r.duAn === bc.duAn && r.tuan; });
  var sc = crmReportScope_(bc.tuan, Object.keys(rows.reduce(function (o, r) { o[r.tuan] = 1; return o; }, {})));
  var last = sc.weeks[sc.weeks.length - 1] || String(bc.tuan);
  var soLieu = rows.filter(function (r) { return String(r.tuan) <= last; }).map(function (r) { return pick(r, cols); });
  // ảnh nghiệm thu chỉ có ở báo cáo tuần (báo cáo tháng / toàn chiến dịch là bản tổng hợp số)
  var chungTu = sc.ky !== 'tuan' ? [] : crmRows_('ChungTu').filter(function (r) { return r.duAn === bc.duAn && String(r.tuan) === String(bc.tuan); })
    .map(function (r) { return pick(r, ['id', 'nhanSu', 'nenTang', 'loai', 'tenFile', 'soTien', 'vat']); });
  return {
    duAn: bc.duAn, tuan: bc.tuan, trangThai: bc.trangThai, ngayTao: bc.ngayTao, pdfUrl: bc.pdfUrl, pptxUrl: bc.pptxUrl,
    ky: sc.ky, weeks: sc.weeks, prevWeeks: sc.prevWeeks,
    chienDich: pj.chienDich || '', logo: pj.logo || '',
    nhanSu: crmRows_('NhanSu').filter(function (n) { return n.trangThai !== 'Nghỉ'; }).map(function (n) { return n.ten; }),
    // họ tên đầy đủ để hiện trong báo cáo (không đưa email / điện thoại ra link báo cáo)
    hoTen: crmRows_('NhanSu').reduce(function (o, n) { if (n.hoTen && n.hoTen !== n.ten) o[n.ten] = n.hoTen; return o; }, {}),
    soLieu: soLieu, chungTu: chungTu,
  };
}
/** Ảnh / PDF chứng từ của báo cáo (chỉ chứng từ thuộc đúng dự án + tuần của link). */
function crmWebImage(k, id) {
  var bc = crmWebReport_(k);
  var c = crmRows_('ChungTu').filter(function (r) { return r.id === id && r.duAn === bc.duAn && String(r.tuan) === String(bc.tuan); })[0];
  if (!c) throw new Error('Không có chứng từ này trong báo cáo.');
  var blob = DriveApp.getFileById(c.fileId).getBlob();
  return { b64: Utilities.base64Encode(blob.getBytes()), type: blob.getContentType() };
}

/** Tạo báo cáo: chỉ chủ ứng dụng hoặc quản trị. */
function crmRequireAdmin_(token) {
  if (crmMe_(token).role !== 'admin') throw new Error('Chỉ quản trị mới tạo được báo cáo.');
}

var CRM_ADMIN_ONLY = ['crmImportEntries_', 'crmShareSheet_', 'crmTrashReportFiles_'];
var CRM_CALLS = {
  crmSave: crmSave_, crmSaveMany: crmSaveMany_, crmDelete: crmDelete_, crmImportEntries: crmImportEntries_,
  crmUploadEvidence: crmUploadEvidence_, crmCopyEvidence: crmCopyEvidence_, crmWriteSheet: crmWriteSheet_,
  crmShareSheet: crmShareSheet_, crmTrashReportFiles: crmTrashReportFiles_,
};
var CRM_STAFF_TABLES = ['SoLieu', 'ChungTu', 'TaiKhoan'];

/** Cổng duy nhất để ghi dữ liệu: kiểm tra quyền rồi mới gọi hàm thật. */
function crmCall(token, fn, args) {
  var f = CRM_CALLS[fn];
  if (!f) throw new Error('Không có thao tác ' + fn);
  args = args || [];
  var me = crmMe_(token);
  if (!me.role) throw new Error('Bạn chưa đăng nhập (đăng nhập bằng email).');
  if (me.email) CRM_ACTOR = me.email;
  if (me.role === 'admin') return f.apply(null, args);
  var deny = function (why) { throw new Error('Không có quyền: ' + why + ' Chỉ quản trị mới làm được.'); };
  if (CRM_ADMIN_ONLY.indexOf(fn + '_') >= 0) deny('thao tác này dành cho quản trị.');
  var mine = function (o, what) { if (String(o.nhanSu || '') !== me.name) deny(what + ' của "' + (o.nhanSu || 'chưa gán') + '" – bạn chỉ sửa được dữ liệu của chính mình.'); };
  var checkRows = function (table, list) {
    if (CRM_STAFF_TABLES.indexOf(table) < 0) deny('sửa ' + table + '.');
    var rows = crmRows_(table), byId = {};
    rows.forEach(function (r) { byId[r.id] = r; });
    list.forEach(function (o) {
      var old = o.id && byId[o.id];
      if (old) mine(old, 'dòng');
      if (table === 'TaiKhoan' && old) deny('sửa tài khoản đã có trong Danh mục.');
      if (o.nhanSu !== undefined || !old) mine(o.nhanSu === undefined && old ? old : o, 'dòng');
    });
  };
  if (fn === 'crmSave') checkRows(args[0], [args[1]]);
  else if (fn === 'crmSaveMany') checkRows(args[0], args[1] || []);
  else if (fn === 'crmDelete') {
    if (['SoLieu', 'ChungTu'].indexOf(args[0]) < 0) deny('xoá ' + args[0] + '.');
    var ids = [].concat(args[1]), rows = crmRows_(args[0]);
    rows.filter(function (r) { return ids.indexOf(r.id) >= 0; }).forEach(function (r) { mine(r, 'xoá dòng'); });
  } else if (fn === 'crmUploadEvidence') mine(args[0] || {}, 'tải chứng từ');
  else if (fn === 'crmCopyEvidence') {
    var src = crmRows_('ChungTu').filter(function (r) { return r.id === args[0]; })[0];
    if (src) mine(src, 'chép chứng từ');
  } else if (fn === 'crmWriteSheet') (args[2] || []).forEach(function (it) { mine(it, 'ghi Google Sheet'); });
  return f.apply(null, args);
}

/** Thêm/sửa nhiều dòng (theo id). */
function crmSaveMany_(name, list) {
  return crmWithLock_(function () {
    var rows = crmRows_(name);
    var idx = {};
    rows.forEach(function (r, i) { idx[r.id] = i; });
    var saved = list.map(function (o) {
      // chứng từ: một file Drive / một nội dung ảnh chỉ lưu một lần cho mỗi dự án + tuần
      var same = !o.id && name === 'ChungTu' && crmSameEvidence_(rows, o);
      if (same) return same;
      crmStamp_(o);
      if (idx[o.id] !== undefined) rows[idx[o.id]] = Object.assign(rows[idx[o.id]], o);
      else { idx[o.id] = rows.length; rows.push(o); }
      return rows[idx[o.id]];
    });
    crmWriteAll_(name, rows);
    return saved;
  });
}

function crmSameEvidence_(rows, o) {
  return rows.filter(function (r) {
    return (o.fileId && r.fileId === o.fileId) ||
      (o.hash && r.hash === o.hash && r.duAn === o.duAn && String(r.tuan) === String(o.tuan) &&
        String(r.nhanSu || '') === String(o.nhanSu || '')); // hoá đơn chung: mỗi nhân sự giữ một bản
  })[0];
}

function crmSave_(name, o) {
  return crmSaveMany_(name, [o])[0];
}

function crmDelete_(name, ids) {
  ids = [].concat(ids);
  return crmWithLock_(function () {
    var rows = crmRows_(name);
    var keep = rows.filter(function (r) { return ids.indexOf(r.id) < 0; });
    if (name === 'ChungTu') {
      var still = keep.map(function (r) { return r.fileId; });
      // chỉ bỏ file vào thùng rác khi không còn dòng nào khác dùng file đó
      rows.filter(function (r) { return ids.indexOf(r.id) >= 0 && r.fileId && still.indexOf(r.fileId) < 0; }).forEach(function (r) {
        try { DriveApp.getFileById(r.fileId).setTrashed(true); } catch (e) { /* đã xoá */ }
      });
    }
    crmWriteAll_(name, keep);
    return rows.length - keep.length;
  });
}

// ---------------------------------------------------------------------
// Ghi số đọc từ ảnh vào Google Sheet số liệu của dự án (mẫu "Thời gian | Facebook | Tiktok | Zalo | Google").
// Chỉ ghi vào ô trống (không công thức) hoặc ô do chính app đã ghi trước đó (có ghi chú SHEET_NOTE).
// ---------------------------------------------------------------------
var SHEET_NOTE = 'Tự điền từ ảnh nghiệm thu (CRM).';
var SHEET_PLATFORMS = ['Facebook', 'Tiktok', 'Zalo', 'Google', 'Đăng tin'];
/** Kênh có thư mục chứng từ riêng (thư mục "Kênh đăng tin" = kênh Đăng tin). */
var EVIDENCE_CHANNELS = SHEET_PLATFORMS;
var SHEET_METRICS = [['chi phi thuc chay (+', 'chiPhiPhi'], ['chi phi thuc chay', 'chiPhi'], ['id tai khoan', 'taiKhoan'],
  ['lead', 'lead'], ['impressions', 'hienThi'], ['reach', 'tiepCan'], ['luot nhap', 'luotNhap'], ['luot xem', 'luotXem']];

function crmPlain_(s) {
  return String(s == null ? '' : s).normalize('NFD').replace(/[̀-ͯ]/g, '').replace(/đ/g, 'd').replace(/Đ/g, 'D')
    .toLowerCase().replace(/\s+/g, ' ').trim();
}
// ID tài khoản: dãy số dài; Google Ads viết 851-117-7492 -> 8511177492
function crmDigits_(s) { return (String(s || '').replace(/(\d)[-\s](?=\d)/g, '$1').match(/\d{6,}/) || [''])[0]; }

/** Nhãn tuần "05/10 - 11/10" có chứa ngày thứ 2 isoMonday (yyyy-mm-dd) không. */
/** Nhãn tuần trong sheet bắt đầu đúng ngày iso ("10/10 - 16/10" với "2026-10-10"). */
function crmLabelStartsAt_(label, iso) {
  var m = /^(\d{1,2})\/(\d{1,2})\s*-/.exec(String(label || '').trim());
  var p = String(iso).split('-').map(Number);
  return !!m && +m[1] === p[2] && +m[2] === p[1];
}
function crmLabelHasWeek_(label, isoMonday) {
  var m = /^(\d{1,2})\/(\d{1,2})\s*-\s*(\d{1,2})\/(\d{1,2})/.exec(String(label || '').trim());
  if (!m) return false;
  var p = isoMonday.split('-').map(Number), y = p[0];
  var t = Date.UTC(y, p[1] - 1, p[2]);
  var a = Date.UTC(y, +m[2] - 1, +m[1]), b = Date.UTC(+m[4] < +m[2] ? y + 1 : y, +m[4] - 1, +m[3]);
  if (a > t + 200 * 864e5) a = Date.UTC(y - 1, +m[2] - 1, +m[1]); // tuần cuối năm trước
  return a <= t && t <= b;
}

/** Chèn một dòng trống vào cuối khối tuần (rows = chỉ số dòng 0-based của tuần), giữ công thức theo dòng trên. Trả chỉ số dòng mới. */
function crmInsertWeekRow_(sh, rows, vals, forms, notes) {
  var last = rows[rows.length - 1], width = vals[last].length;
  var src = sh.getRange(last + 1, 1, 1, width).getFormulasR1C1()[0];
  sh.insertRowAfter(last + 1);
  src.forEach(function (f, j) { if (f) sh.getRange(last + 2, j + 1).setFormulaR1C1(f); });
  var at = last + 1;
  vals.splice(at, 0, src.map(function () { return ''; }));
  forms.splice(at, 0, src.map(function (f) { return f ? f : ''; }));
  notes.splice(at, 0, src.map(function () { return ''; }));
  rows.push(at);
  return at;
}

/**
 * items: [{nenTang, taiKhoan, nhanSu, chiPhi, lead, luotXem, ...}] – tổng theo tài khoản/kênh của tuần.
 * Trả {written, kept, noRow, sheetUrl}.
 */
/**
 * File số liệu của dự án. Nếu link trong Danh mục là file Excel (.xlsx) mà cùng thư mục đã có bản
 * Google Trang tính cùng tên (Tệp › Lưu dưới dạng Google Trang tính) thì dùng bản đó và cập nhật Danh mục.
 * Trả {file, url, switched}.
 */
function crmSheetFile_(duAn) {
  var project = crmRows_('DuAn').filter(function (p) { return p.ten === duAn; })[0];
  if (!project) throw new Error('Không có dự án ' + duAn);
  var m = /\/d\/([\w-]{15,})/.exec(project.nguonSoLieu || '');
  if (!m) throw new Error('Dự án ' + duAn + ' chưa có link Google Sheet số liệu (tab Danh mục).');
  var file = DriveApp.getFileById(m[1]);
  if (file.getMimeType() === MimeType.GOOGLE_SHEETS) return { file: file, url: project.nguonSoLieu, switched: false };
  var base = file.getName().replace(/\.(xlsx|xls|csv)$/i, '');
  var best = null;
  var parents = file.getParents();
  while (parents.hasNext()) {
    var it = parents.next().getFilesByType(MimeType.GOOGLE_SHEETS);
    while (it.hasNext()) {
      var g = it.next();
      if (g.getName() === base && !g.isTrashed() && (!best || g.getLastUpdated() > best.getLastUpdated())) best = g;
    }
  }
  if (!best) return { file: file, url: project.nguonSoLieu, switched: false };
  var url = 'https://docs.google.com/spreadsheets/d/' + best.getId() + '/edit';
  crmSaveMany_('DuAn', [{ id: project.id, nguonSoLieu: url }]);
  return { file: best, url: url, switched: true };
}

/** Cho trang: link file số liệu đang dùng (đã tự chuyển sang bản Google Trang tính nếu có). */
function crmSheetSource(duAn, token) {
  crmRequireUser_(token);
  var r = crmSheetFile_(duAn);
  return { id: r.file.getId(), url: r.url, switched: r.switched, isSheet: r.file.getMimeType() === MimeType.GOOGLE_SHEETS };
}

function crmWriteSheet_(duAn, tuan, items) {
  var src = crmSheetFile_(duAn);
  if (src.file.getMimeType() !== MimeType.GOOGLE_SHEETS) {
    throw new Error('File số liệu của ' + duAn + ' là file Excel (.xlsx), app không ghi vào được. Mở file › Tệp › Lưu dưới dạng Google Trang tính (để cùng thư mục, giữ nguyên tên) – app tự chuyển sang bản đó.');
  }
  return crmWithLock_(function () {
    var ss = SpreadsheetApp.openById(src.file.getId());
    var sh = ss.getSheets()[0];
    var rng = sh.getDataRange();
    var vals = rng.getValues(), forms = rng.getFormulas(), notes = rng.getNotes();
    var hdr = -1;
    for (var i = 0; i < vals.length && hdr < 0; i++) {
      if (vals[i].filter(function (c) { return SHEET_PLATFORMS.indexOf(String(c).trim()) >= 0; }).length >= 2) hdr = i;
    }
    if (hdr < 0) throw new Error('Không tìm thấy dòng tiêu đề Facebook/Tiktok/Zalo/Google trong sheet của ' + duAn + '.');
    var starts = [];
    vals[hdr].forEach(function (c, j) { if (SHEET_PLATFORMS.indexOf(String(c).trim()) >= 0) starts.push([String(c).trim(), j]); });
    var cols = {};
    starts.forEach(function (st, k) {
      var end = Math.min(k + 1 < starts.length ? starts[k + 1][1] : st[1] + 11, st[1] + 12), mm = {};
      for (var j = st[1]; j < end; j++) {
        var h = crmPlain_(vals[hdr + 1][j]);
        for (var q = 0; q < SHEET_METRICS.length; q++) {
          if (h.indexOf(SHEET_METRICS[q][0]) === 0 && !(SHEET_METRICS[q][1] in mm)) { mm[SHEET_METRICS[q][1]] = j; break; }
        }
      }
      cols[st[0]] = mm;
    });
    // các dòng của tuần: từ dòng có nhãn tuần tới nhãn tuần kế tiếp / dòng TỔNG
    // ưu tiên nhãn bắt đầu đúng ngày đầu tuần (tuần 05/10 – 11/10 cũ và 10/10 – 16/10 mới cùng chứa ngày 10/10)
    var rows = [];
    [true, false].forEach(function (exact) {
      if (rows.length) return;
      var inWeek = false;
      for (var r = hdr + 2; r < vals.length; r++) {
        var lab = String(vals[r][0] || '').trim();
        if (crmPlain_(lab).indexOf('tong') === 0) break;
        if (/^\d{1,2}\/\d{1,2}\s*-\s*\d{1,2}\/\d{1,2}/.test(lab)) { if (inWeek) break; inWeek = exact ? crmLabelStartsAt_(lab, tuan) : crmLabelHasWeek_(lab, tuan); }
        if (inWeek) rows.push(r);
      }
    });
    if (!rows.length) throw new Error('Sheet của ' + duAn + ' không có dòng tuần chứa ngày ' + tuan + '.');
    var res = { written: 0, kept: 0, noRow: [], sheetUrl: ss.getUrl(), source: src.switched ? src.url : '' };
    var mine = function (r, c) { return String(notes[r][c] || '').indexOf(SHEET_NOTE) === 0; };
    var free = function (r, c) { return c != null && !forms[r][c] && (vals[r][c] === '' || vals[r][c] === null || mine(r, c)); };
    var used = {};
    items.forEach(function (it) {
      var plat = SHEET_PLATFORMS.filter(function (p) { return crmPlain_(p) === crmPlain_(it.nenTang); })[0];
      var c = plat && cols[plat];
      if (!c || c.taiKhoan == null) { res.noRow.push(it.nenTang + ' ' + (it.nhanSu || it.taiKhoan)); return; }
      var id = crmDigits_(it.taiKhoan), name = crmPlain_(it.nhanSu);
      var cell = function (r) { return String(vals[r][c.taiKhoan] || ''); };
      var row = rows.filter(function (r) { return id && crmDigits_(cell(r)) === id; })[0];
      if (row == null && !id && name) row = rows.filter(function (r) { return crmPlain_(cell(r)).indexOf(name) >= 0; })[0];
      if (row == null && id && name) {
        // dòng app đã ghi trước đó chỉ có tên (chưa biết ID): dùng lại và thêm ID vào nhãn
        row = rows.filter(function (r) { return crmPlain_(cell(r)) === name && mine(r, c.taiKhoan); })[0];
        if (row != null) {
          var lb = (it.nhanSu + ' ' + id).trim();
          sh.getRange(row + 1, c.taiKhoan + 1).setValue(lb).setNote(SHEET_NOTE); vals[row][c.taiKhoan] = lb;
        }
      }
      if (row == null && it.clear) return; // không có dòng của tài khoản này: không có gì để xoá
      if (row == null) {
        row = rows.filter(function (r) {
          return !used[plat + r] && !cell(r).trim() && ['chiPhi', 'chiPhiPhi', 'lead'].every(function (k) { return c[k] == null || forms[r][c[k]] || vals[r][c[k]] === '' || vals[r][c[k]] === null; });
        })[0];
        if (row == null) {
          // khối tuần đã hết dòng trống: chèn thêm một dòng ngay sau dòng cuối của tuần (chép công thức của dòng trên)
          try { row = crmInsertWeekRow_(sh, rows, vals, forms, notes); } catch (e) { row = null; }
          if (row == null) { res.noRow.push(plat + ' ' + (it.nhanSu || it.taiKhoan)); return; }
          res.added = (res.added || 0) + 1;
        }
        var label = ((it.nhanSu ? it.nhanSu + ' ' : '') + (id || '')).trim();
        if (label) { sh.getRange(row + 1, c.taiKhoan + 1).setValue(label).setNote(SHEET_NOTE); vals[row][c.taiKhoan] = label; }
      }
      used[plat + row] = true;
      if (it.clear) {
        // xoá các ô app đã ghi cho tài khoản này (dòng số liệu từ ảnh đã bị xoá trong app)
        ['taiKhoan', 'chiPhi', 'chiPhiPhi', 'lead', 'hienThi', 'tiepCan', 'luotNhap', 'luotXem'].forEach(function (k) {
          if (c[k] != null && mine(row, c[k])) { sh.getRange(row + 1, c[k] + 1).setValue('').setNote(''); res.written++; }
        });
        return;
      }
      ['chiPhi', 'chiPhiPhi', 'lead', 'hienThi', 'tiepCan', 'luotNhap', 'luotXem'].forEach(function (k) {
        var v = it[k];
        if (v === '' || v == null || c[k] == null) return;
        if (!free(row, c[k])) { res.kept++; return; }
        sh.getRange(row + 1, c[k] + 1).setValue(Number(v)).setNote(SHEET_NOTE);
        res.written++;
      });
    });
    return res;
  });
}

/**
 * Cho nhân sự (đang làm, có email ở tab Danh mục) quyền sửa Google Sheet số liệu của dự án.
 * Google gửi email báo cho người được thêm. Trả {added, already, noEmail, url}.
 */
function crmShareSheet_(duAn) {
  var f = crmSheetFile_(duAn).file;
  var have = f.getEditors().map(function (u) { return String(u.getEmail()).toLowerCase(); });
  try { have.push(String(f.getOwner().getEmail()).toLowerCase()); } catch (e) { /* file trong Drive dùng chung */ }
  var staff = crmRows_('NhanSu').filter(function (n) { return n.trangThai !== 'Nghỉ'; });
  var withMail = staff.filter(function (n) { return crmEmails_(n).length; });
  var emails = [].concat.apply([], withMail.map(crmEmails_));
  var add = emails.filter(function (e, i) { return emails.indexOf(e) === i && have.indexOf(e) < 0; });
  if (add.length) f.addEditors(add);
  return {
    added: add, already: emails.length - add.length, url: f.getUrl(),
    noEmail: staff.filter(function (n) { return withMail.indexOf(n) < 0; }).map(function (n) { return n.ten; }),
  };
}

/** Nhập số liệu từ Google Sheet: thay các dòng nguồn "sheet" của dự án trong những tuần được nhập. */
function crmImportEntries_(duAn, weeks, list) {
  weeks = [].concat(weeks || []).map(crmWeekKey_);
  return crmWithLock_(function () {
    var rows = crmRows_('SoLieu').filter(function (r) {
      return !(r.duAn === duAn && r.nguon === 'sheet' && weeks.indexOf(r.tuan) >= 0);
    });
    list.forEach(function (o) { o.nguon = 'sheet'; rows.push(crmStamp_(o)); });
    crmWriteAll_('SoLieu', rows);
    return list.length;
  });
}

function crmFolderId_(link) {
  var m = /\/folders\/([\w-]{15,})/.exec(link || '') || /^([\w-]{15,})$/.exec(link || '');
  return m ? m[1] : '';
}

function crmSub_(parent, name) {
  var it = parent.getFoldersByName(name);
  return it.hasNext() ? it.next() : parent.createFolder(name);
}

/** "2026-10-05" -> "5/10-11/10" (tên thư mục tuần). */
function crmWeekFolder_(iso) {
  var p = String(iso).split('-').map(Number);
  var a = new Date(p[0], p[1] - 1, p[2]);
  var b = new Date(p[0], p[1] - 1, p[2] + 6);
  return a.getDate() + '/' + (a.getMonth() + 1) + '-' + b.getDate() + '/' + (b.getMonth() + 1);
}

/**
 * Thư mục chứng từ chia theo kênh: tạo sẵn thư mục dự án trong mỗi kênh (Facebook/Sun, Facebook/Casamia, …)
 * để nhân viên mở link Drive và thả ảnh vào đúng chỗ. Làm tối đa 6 giờ một lần.
 */
function crmEnsureEvidenceFolders_() {
  var cache = CacheService.getScriptCache();
  if (cache.get('evFolders')) return;
  crmRows_('DuAn').forEach(function (p) {
    var id = crmFolderId_(p.thuMucChungTu);
    if (!id) return;
    var root = DriveApp.getFolderById(id);
    EVIDENCE_CHANNELS.forEach(function (ch) {
      var f = crmSubFind_(root, ch);
      if (f && crmEvidenceLevels_(root, p, '').project && !crmSubFind_(f, p.khoa || p.ten)) f.createFolder(p.khoa || p.ten);
    });
  });
  cache.put('evFolders', '1', 21600);
}
/** Thư mục con trùng tên không phân biệt hoa thường / dấu ("Tiktok" = "TikTok"). */
function crmSubFind_(parent, name) {
  var bare = function (x) { return crmPlain_(x).replace(/^kenh /, ''); };
  var want = bare(name), it = parent.getFolders();
  while (it.hasNext()) { var f = it.next(); if (bare(f.getName()) === want) return f; }
  return null;
}
/**
 * Thư mục lưu một chứng từ.
 * - Thư mục chứng từ có sẵn thư mục con theo kênh (vd "Khối Collection" › Facebook / Google / Tiktok / Zalo / Kênh đăng tin):
 *   <Kênh>/<Tuần>/<Dự án>/<Nhân sự>
 * - Không có: kiểu cũ <Nhân sự>/<Dự án>/<Tuần>.
 */
function crmEvidenceFolder_(project, meta) {
  var root = DriveApp.getFolderById(crmFolderId_(project.thuMucChungTu) || EVIDENCE_ROOT);
  var lv = crmEvidenceLevels_(root, project, meta.tuan);
  var byChannel = SHEET_PLATFORMS.some(function (p) { return crmSubFind_(root, p); });
  var f = root;
  if (byChannel) {
    // <Kênh>[/<Tuần>][/<Dự án>]/<Nhân sự>
    f = crmSubFind_(root, meta.nenTang || 'Facebook') || crmSub_(root, meta.nenTang === 'Đăng tin' ? 'Kênh đăng tin' : meta.nenTang || 'Khác');
    if (lv.week) f = crmSub_(f, crmWeekFolder_(meta.tuan));
    if (lv.project) f = crmSub_(f, project.khoa || project.ten);
    return crmSub_(f, meta.nhanSu || 'Chưa gán');
  }
  f = crmSub_(f, meta.nhanSu || 'Chưa gán');
  if (lv.project) f = crmSub_(f, project.khoa || project.ten);
  return lv.week ? crmSub_(f, crmWeekFolder_(meta.tuan)) : f;
}
/**
 * Có cần thư mục con Tuần / Dự án không:
 * - thư mục chứng từ riêng của dự án (vd "Sun FourS Tower ( F2)") -> không cần thư mục Dự án
 * - thư mục đó (hoặc thư mục cha) đã là thư mục của đúng tuần (vd "Tuần 3 ( 17.10.2026 - 23.10.2026)") -> không cần thư mục Tuần
 */
function crmEvidenceLevels_(root, project, tuan) {
  var id = root.getId();
  var own = crmRows_('DuAn').filter(function (p) { return crmFolderId_(p.thuMucChungTu) === id; }).length <= 1;
  var names = [root.getName()];
  try { var ps = root.getParents(); if (ps.hasNext()) names.push(ps.next().getName()); } catch (e) { /* không xem được thư mục cha */ }
  var t = String(tuan || '').split('-').map(Number);
  var sameWeek = !!tuan && names.some(function (n) {
    var m = /(\d{1,2})[\/.](\d{1,2})(?:[\/.]\d{4})?\s*[-–—]\s*(\d{1,2})[\/.](\d{1,2})/.exec(n || '');
    return m && +m[1] === t[2] && +m[2] === t[1];
  });
  return { project: !own, week: !sameWeek };
}

/** Lưu ảnh chứng từ vào Thư mục chứng từ/Nhân sự/Dự án/Tuần và ghi vào bảng ChungTu. */
/**
 * Dùng chứng từ của dự án khác cho dự án duAn (ví dụ hoá đơn chung của Sun và Casamia):
 * chép file vào <Nhân sự>/<Dự án>/<Tuần> của dự án đích và thêm dòng ChungTu. Đã có thì trả dòng cũ.
 */
function crmCopyEvidence_(id, duAn) {
  var src = crmRows_('ChungTu').filter(function (r) { return r.id === id; })[0];
  if (!src) throw new Error('Không tìm thấy chứng từ ' + id);
  var project = crmRows_('DuAn').filter(function (p) { return p.ten === duAn; })[0];
  if (!project) throw new Error('Không có dự án ' + duAn);
  var meta = { tuan: src.tuan, duAn: duAn, nhanSu: src.nhanSu, nenTang: src.nenTang, loai: src.loai, tenFile: src.tenFile, hash: src.hash,
    soTien: src.soTien, vat: src.vat };
  if (meta.hash) {
    var same = crmSameEvidence_(crmRows_('ChungTu'), meta);
    if (same) return same;
  }
  var folder = crmEvidenceFolder_(project, meta);
  var file = DriveApp.getFileById(src.fileId).makeCopy(src.tenFile, folder);
  return crmSave_('ChungTu', {
    tuan: meta.tuan, duAn: duAn, nhanSu: meta.nhanSu, nenTang: meta.nenTang, loai: meta.loai,
    fileId: file.getId(), tenFile: meta.tenFile, url: file.getUrl(), hash: meta.hash || '',
    soTien: meta.soTien || '', vat: meta.vat != null ? meta.vat : '',
  });
}

function crmUploadEvidence_(meta, b64) {
  var project = crmRows_('DuAn').filter(function (p) { return p.ten === meta.duAn; })[0];
  if (!project) throw new Error('Không có dự án ' + meta.duAn);
  if (meta.hash) {
    var same = crmSameEvidence_(crmRows_('ChungTu'), meta);
    if (same) return same; // ảnh này đã lưu rồi: không tạo file trùng trên Drive
  }
  var folder = crmEvidenceFolder_(project, meta);
  var file = folder.createFile(Utilities.newBlob(Utilities.base64Decode(b64), meta.mime || 'image/png', meta.tenFile));
  return crmSave_('ChungTu', {
    tuan: meta.tuan, duAn: meta.duAn, nhanSu: meta.nhanSu, nenTang: meta.nenTang, loai: meta.loai,
    fileId: file.getId(), tenFile: meta.tenFile, url: file.getUrl(), hash: meta.hash || '',
    soTien: meta.soTien || '', vat: meta.vat != null ? meta.vat : '',
  });
}
