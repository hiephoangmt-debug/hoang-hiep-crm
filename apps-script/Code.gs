/**
 * Báo cáo Marketing tuần – bản Google Apps Script.
 * Giao diện (Index.html) chạy trên trình duyệt; các hàm dưới đây đọc/ghi Google Drive
 * bằng chính tài khoản của người triển khai, nên không cần OAuth Client ID.
 */
var PPTX_MIME = 'application/vnd.openxmlformats-officedocument.presentationml.presentation';

function doGet() {
  return HtmlService.createHtmlOutputFromFile('Index')
    .setTitle('Báo cáo Marketing')
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
  })(root, [root.getName()]);
  return out;
}

/** Lưu PPTX báo cáo vào Drive (thư mục chỉ định hoặc My Drive), trả về link. */
function saveReport(b64, name, folderId) {
  var blob = Utilities.newBlob(Utilities.base64Decode(b64), PPTX_MIME, name);
  var folder = folderId ? DriveApp.getFolderById(folderId) : DriveApp.getRootFolder();
  return folder.createFile(blob).getUrl();
}

/**
 * Chuyển PPTX báo cáo sang PDF: tải lên Drive dạng Google Slides tạm, xuất PDF, xoá bản tạm.
 * Lưu PDF vào thư mục chỉ định (hoặc My Drive). Trả về {url, b64}.
 */
function convertToPdf(b64, name, folderId) {
  var boundary = 'bcmkt' + Date.now();
  var meta = JSON.stringify({ name: name.replace(/\.pptx$/i, '') + ' (tạm)', mimeType: 'application/vnd.google-apps.presentation' });
  var head = Utilities.newBlob('--' + boundary + '\r\nContent-Type: application/json; charset=UTF-8\r\n\r\n' + meta +
    '\r\n--' + boundary + '\r\nContent-Type: ' + PPTX_MIME + '\r\n\r\n').getBytes();
  var tail = Utilities.newBlob('\r\n--' + boundary + '--').getBytes();
  var payload = head.concat(Utilities.base64Decode(b64)).concat(tail);
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
  var tmpId = JSON.parse(res.getContentText()).id;
  try {
    var pdf = exportBlob_('https://docs.google.com/presentation/d/' + tmpId + '/export/pdf')
      .setName(name.replace(/\.pptx$/i, '') + '.pdf');
    var folder = folderId ? DriveApp.getFolderById(folderId) : DriveApp.getRootFolder();
    var file = folder.createFile(pdf);
    return { url: file.getUrl(), b64: Utilities.base64Encode(pdf.getBytes()) };
  } finally {
    DriveApp.getFileById(tmpId).setTrashed(true);
  }
}
