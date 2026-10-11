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
function downloadFile(id) {
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
function listTree(folderId) {
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
      out.push({ id: f.getId(), name: f.getName(), mimeType: f.getMimeType(), path: path });
    }
    var subs = folder.getFolders();
    while (subs.hasNext()) {
      var s = subs.next();
      walk(s, path.concat([s.getName()]));
    }
  })(root, prefix.concat([root.getName()]));
  return out;
}

/** Bật "Bất kỳ ai có đường liên kết đều xem được" (bỏ qua nếu tổ chức chặn chia sẻ ra ngoài). */
function shareByLink_(file) {
  try { file.setSharing(DriveApp.Access.ANYONE_WITH_LINK, DriveApp.Permission.VIEW); }
  catch (e) {
    try { file.setSharing(DriveApp.Access.DOMAIN_WITH_LINK, DriveApp.Permission.VIEW); } catch (e2) { /* giữ quyền mặc định */ }
  }
  return file;
}

/** Lưu PPTX báo cáo vào Drive (thư mục chỉ định hoặc My Drive), trả về link. share = bật xem qua link. */
function saveReport(b64, name, folderId, share) {
  var blob = Utilities.newBlob(Utilities.base64Decode(b64), PPTX_MIME, name);
  var folder = folderId ? DriveApp.getFolderById(folderId) : DriveApp.getRootFolder();
  var file = folder.createFile(blob);
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

function convertToPdf(b64, name, folderId, share) {
  var tmpId = pptxToSlides_(Utilities.base64Decode(b64), name);
  try {
    var pdf = exportBlob_('https://docs.google.com/presentation/d/' + tmpId + '/export/pdf')
      .setName(name.replace(/\.pptx$/i, '') + '.pdf');
    var folder = folderId ? DriveApp.getFolderById(folderId) : DriveApp.getRootFolder();
    var file = folder.createFile(pdf);
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
  NhanSu: [['id', 'ID'], ['ten', 'Tên'], ['email', 'Email'], ['trangThai', 'Trạng thái']],
  TaiKhoan: [['id', 'ID'], ['maTaiKhoan', 'ID tài khoản QC'], ['ten', 'Tên tài khoản'], ['nenTang', 'Nền tảng'], ['nhanSu', 'Nhân sự']],
  SoLieu: [['id', 'ID'], ['tuan', 'Tuần (thứ 2)'], ['duAn', 'Dự án'], ['nhanSu', 'Nhân sự'], ['nenTang', 'Nền tảng'],
    ['taiKhoan', 'ID tài khoản QC'], ['chienDich', 'Chiến dịch'], ['chiPhi', 'Chi phí thực chạy'], ['chiPhiPhi', 'Chi phí gồm phí nền tảng'],
    ['lead', 'Lead'], ['hienThi', 'Hiển thị'], ['tiepCan', 'Tiếp cận'], ['luotNhap', 'Lượt nhấp'], ['luotXem', 'Lượt xem'],
    ['mql', 'MQL'], ['sql', 'SQL'], ['deal', 'DEAL'], ['ghiChu', 'Ghi chú'], ['nguon', 'Nguồn'], ['nguoiTao', 'Người tạo'], ['ngayTao', 'Ngày tạo']],
  ChungTu: [['id', 'ID'], ['tuan', 'Tuần (thứ 2)'], ['duAn', 'Dự án'], ['nhanSu', 'Nhân sự'], ['nenTang', 'Nền tảng'], ['loai', 'Loại'],
    ['fileId', 'File ID'], ['tenFile', 'Tên file'], ['url', 'Link'], ['nguoiTao', 'Người tạo'], ['ngayTao', 'Ngày tạo'],
    ['hash', 'Mã nội dung (chống trùng)']],
  BaoCao: [['id', 'ID'], ['tuan', 'Tuần (thứ 2)'], ['duAn', 'Dự án'], ['trangThai', 'Trạng thái'], ['pdfUrl', 'PDF'], ['pptxUrl', 'PPTX'],
    ['tomTat', 'Tóm tắt'], ['nguoiTao', 'Người tạo'], ['ngayTao', 'Ngày tạo']],
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
      nguonSoLieu: 'https://docs.google.com/spreadsheets/d/1UOgRz8-D28PSSZCIYtO0YA5A8EeHrxIP/edit', logo: 'TATILAND' },
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

function crmRows_(name) {
  var keys = CRM_TABLES[name].map(function (c) { return c[0]; });
  var vals = crmSheet_(name).getDataRange().getValues();
  return vals.slice(1).filter(function (r) { return r[0] !== ''; }).map(function (r) {
    var o = {};
    keys.forEach(function (k, i) { o[k] = r[i] === undefined ? '' : crmCell_(r[i]); });
    return o;
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

function crmUser_() {
  try { return Session.getActiveUser().getEmail() || Session.getEffectiveUser().getEmail() || ''; } catch (e) { return ''; }
}

function crmStamp_(o) {
  if (!o.id) o.id = Utilities.getUuid().replace(/-/g, '').slice(0, 10);
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
function crmBootstrap() {
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
  });
  var out = { schema: CRM_TABLES, sheetUrl: crmBook_().getUrl(), user: crmUser_() };
  try { out.appUrl = ScriptApp.getService().getUrl(); } catch (e) { out.appUrl = ''; }
  Object.keys(CRM_TABLES).forEach(function (t) { out[t] = crmRows_(t); });
  return out;
}

function crmList(name) {
  return crmRows_(name);
}

/** Thêm/sửa nhiều dòng (theo id). */
function crmSaveMany(name, list) {
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
      (o.hash && r.hash === o.hash && r.duAn === o.duAn && String(r.tuan) === String(o.tuan));
  })[0];
}

function crmSave(name, o) {
  return crmSaveMany(name, [o])[0];
}

function crmDelete(name, ids) {
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
var SHEET_PLATFORMS = ['Facebook', 'Tiktok', 'Zalo', 'Google'];
var SHEET_METRICS = [['chi phi thuc chay (+', 'chiPhiPhi'], ['chi phi thuc chay', 'chiPhi'], ['id tai khoan', 'taiKhoan'],
  ['lead', 'lead'], ['impressions', 'hienThi'], ['reach', 'tiepCan'], ['luot nhap', 'luotNhap'], ['luot xem', 'luotXem']];

function crmPlain_(s) {
  return String(s == null ? '' : s).normalize('NFD').replace(/[̀-ͯ]/g, '').replace(/đ/g, 'd').replace(/Đ/g, 'D')
    .toLowerCase().replace(/\s+/g, ' ').trim();
}
function crmDigits_(s) { return (String(s || '').match(/\d{6,}/) || [''])[0]; }

/** Nhãn tuần "05/10 - 11/10" có chứa ngày thứ 2 isoMonday (yyyy-mm-dd) không. */
function crmLabelHasWeek_(label, isoMonday) {
  var m = /^(\d{1,2})\/(\d{1,2})\s*-\s*(\d{1,2})\/(\d{1,2})/.exec(String(label || '').trim());
  if (!m) return false;
  var p = isoMonday.split('-').map(Number), y = p[0];
  var t = Date.UTC(y, p[1] - 1, p[2]);
  var a = Date.UTC(y, +m[2] - 1, +m[1]), b = Date.UTC(+m[4] < +m[2] ? y + 1 : y, +m[4] - 1, +m[3]);
  if (a > t + 200 * 864e5) a = Date.UTC(y - 1, +m[2] - 1, +m[1]); // tuần cuối năm trước
  return a <= t && t <= b;
}

/**
 * items: [{nenTang, taiKhoan, nhanSu, chiPhi, lead, luotXem, ...}] – tổng theo tài khoản/kênh của tuần.
 * Trả {written, kept, noRow, sheetUrl}.
 */
function crmWriteSheet(duAn, tuan, items) {
  var project = crmRows_('DuAn').filter(function (p) { return p.ten === duAn; })[0];
  if (!project) throw new Error('Không có dự án ' + duAn);
  var m = /\/d\/([\w-]{15,})/.exec(project.nguonSoLieu || '');
  if (!m) throw new Error('Dự án ' + duAn + ' chưa có link Google Sheet số liệu (tab Danh mục).');
  var file = DriveApp.getFileById(m[1]);
  if (file.getMimeType() !== MimeType.GOOGLE_SHEETS) {
    throw new Error('File số liệu của ' + duAn + ' là file Excel (.xlsx), app không ghi vào được. Mở file › Tệp › Lưu dưới dạng Google Trang tính, rồi dán link mới vào tab Danh mục.');
  }
  return crmWithLock_(function () {
    var ss = SpreadsheetApp.openById(m[1]);
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
    var rows = [], inWeek = false;
    for (var r = hdr + 2; r < vals.length; r++) {
      var lab = String(vals[r][0] || '').trim();
      if (crmPlain_(lab).indexOf('tong') === 0) break;
      if (/^\d{1,2}\/\d{1,2}\s*-\s*\d{1,2}\/\d{1,2}/.test(lab)) { if (inWeek) break; inWeek = crmLabelHasWeek_(lab, tuan); }
      if (inWeek) rows.push(r);
    }
    if (!rows.length) throw new Error('Sheet của ' + duAn + ' không có dòng tuần chứa ngày ' + tuan + '.');
    var res = { written: 0, kept: 0, noRow: [], sheetUrl: ss.getUrl() };
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
      if (row == null) {
        row = rows.filter(function (r) {
          return !used[plat + r] && !cell(r).trim() && ['chiPhi', 'chiPhiPhi', 'lead'].every(function (k) { return c[k] == null || forms[r][c[k]] || vals[r][c[k]] === '' || vals[r][c[k]] === null; });
        })[0];
        if (row == null) { res.noRow.push(plat + ' ' + (it.nhanSu || it.taiKhoan)); return; }
        var label = ((it.nhanSu ? it.nhanSu + ' ' : '') + (id || '')).trim();
        if (label) { sh.getRange(row + 1, c.taiKhoan + 1).setValue(label).setNote(SHEET_NOTE); vals[row][c.taiKhoan] = label; }
      }
      used[plat + row] = true;
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
function crmShareSheet(duAn) {
  var project = crmRows_('DuAn').filter(function (p) { return p.ten === duAn; })[0];
  if (!project) throw new Error('Không có dự án ' + duAn);
  var m = /\/d\/([\w-]{15,})/.exec(project.nguonSoLieu || '');
  if (!m) throw new Error('Dự án ' + duAn + ' chưa có link Google Sheet số liệu (tab Danh mục).');
  var f = DriveApp.getFileById(m[1]);
  var have = f.getEditors().map(function (u) { return String(u.getEmail()).toLowerCase(); });
  try { have.push(String(f.getOwner().getEmail()).toLowerCase()); } catch (e) { /* file trong Drive dùng chung */ }
  var staff = crmRows_('NhanSu').filter(function (n) { return n.trangThai !== 'Nghỉ'; });
  var withMail = staff.filter(function (n) { return /@/.test(n.email || ''); });
  var emails = withMail.map(function (n) { return String(n.email).trim().toLowerCase(); });
  var add = emails.filter(function (e, i) { return emails.indexOf(e) === i && have.indexOf(e) < 0; });
  if (add.length) f.addEditors(add);
  return {
    added: add, already: emails.length - add.length, url: f.getUrl(),
    noEmail: staff.filter(function (n) { return withMail.indexOf(n) < 0; }).map(function (n) { return n.ten; }),
  };
}

/** Nhập số liệu từ Google Sheet: thay các dòng nguồn "sheet" của dự án trong những tuần được nhập. */
function crmImportEntries(duAn, weeks, list) {
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

/** Lưu ảnh chứng từ vào Thư mục chứng từ/Nhân sự/Dự án/Tuần và ghi vào bảng ChungTu. */
function crmUploadEvidence(meta, b64) {
  var project = crmRows_('DuAn').filter(function (p) { return p.ten === meta.duAn; })[0];
  if (!project) throw new Error('Không có dự án ' + meta.duAn);
  if (meta.hash) {
    var same = crmSameEvidence_(crmRows_('ChungTu'), meta);
    if (same) return same; // ảnh này đã lưu rồi: không tạo file trùng trên Drive
  }
  var rootId = crmFolderId_(project.thuMucChungTu) || EVIDENCE_ROOT;
  var folder = crmSub_(crmSub_(crmSub_(DriveApp.getFolderById(rootId), meta.nhanSu || 'Chưa gán'),
    project.khoa || project.ten), crmWeekFolder_(meta.tuan));
  var file = folder.createFile(Utilities.newBlob(Utilities.base64Decode(b64), meta.mime || 'image/png', meta.tenFile));
  return crmSave('ChungTu', {
    tuan: meta.tuan, duAn: meta.duAn, nhanSu: meta.nhanSu, nenTang: meta.nenTang, loai: meta.loai,
    fileId: file.getId(), tenFile: meta.tenFile, url: file.getUrl(), hash: meta.hash || '',
  });
}
