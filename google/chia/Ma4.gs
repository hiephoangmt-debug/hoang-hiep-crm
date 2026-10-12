// ---- Menu CRM ----
function onOpen() {
  SpreadsheetApp.getUi().createMenu('CRM')
    .addItem('Mở giao diện CRM (trong file này)', 'moGiaoDienCRM')
    .addItem('Link vào CRM (giao diện web)', 'showCrmLink')
    .addItem('Đổi link CRM (huỷ link cũ)', 'resetCrmLink')
    .addItem('Xem mã nhúng cho các website', 'showEmbed')
    .addItem('Tạo mã website ngẫu nhiên', 'newSiteKey')
    .addToUi();
}

function webAppUrl_() { return ScriptApp.getService().getUrl(); }

function showEmbed() {
  var url = webAppUrl_();
  if (!url) { SpreadsheetApp.getUi().alert('Chưa triển khai. Vào Triển khai > Tùy chọn triển khai mới > Ứng dụng web.'); return; }
  var sh = ss_().getSheetByName(S_SITES), n = sh.getLastRow(), out = [];
  if (n > 1) sh.getRange(2, 1, n - 1, 3).getValues().forEach(function (r) {
    if (r[0] && String(r[2]).length >= 8) out.push(r[0] + ':\n<script src="' + url + '?js=1" data-key="' + r[2] + '" async></script>');
  });
  SpreadsheetApp.getUi().alert('Dán vào <head> của từng landing page:\n\n' + (out.join('\n\n') || 'Chưa có website ở tab Website.') +
    '\n\nWebhook form (POST): ' + url + '?key=MÃ_WEBSITE');
}

function newSiteKey() {
  var chars = 'abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789', k = '';
  for (var i = 0; i < 12; i++) k += chars.charAt(Math.floor(Math.random() * chars.length));
  var sh = ss_().getSheetByName(S_SITES), r = Math.max(sh.getLastRow() + 1, 2);
  sh.getRange(r, 3).setValue(k);
  SpreadsheetApp.getUi().alert('Đã tạo mã ' + k + ' ở dòng ' + r + ' của tab Website. Điền tên website vào cột A.');
}

function crmBaseUrl_() {
  // URL ứng dụng web (kết thúc /exec) nằm ở ô G2 của tab Website; getUrl() trong trình soạn thảo chỉ trả địa chỉ thử /dev.
  try {
    var g = String(ss_().getSheetByName(S_SITES).getRange(2, 7).getValue() || '').trim();
    if (/^https:\/\/script\.google\.com\/macros\/s\/[^\/?\s]+\/exec$/.test(g)) return g;
  } catch (x) {}
  try { var u = ScriptApp.getService().getUrl(); if (/\/exec$/.test(u)) return u; } catch (x) {}
  return '';
}
function crmLinkText_() {
  var props = PropertiesService.getScriptProperties(), key = crmKey_();
  if (key.length < 20) { key = Utilities.getUuid().replace(/-/g, ''); props.setProperty('CRM_KEY', key); }
  var base = crmBaseUrl_();
  return (base || 'URL_UNG_DUNG_WEB') + '?k=' + key;
}
function showCrmLink() {
  var link = crmLinkText_();
  SpreadsheetApp.getUi().alert('Link vào CRM (giữ kín, ai có link là xem và sửa được khách hàng):\n\n' + link +
    (/\/exec\?k=/.test(link) ? '' : '\n\nChưa có URL ứng dụng web: dán URL (kết thúc /exec) vào ô G2 của tab Website rồi chạy lại menu này.') +
    '\n\nMở link này trên máy tính hoặc điện thoại. Lưu vào dấu trang để dùng hằng ngày.');
}
function resetCrmLink() {
  PropertiesService.getScriptProperties().deleteProperty('CRM_KEY');
  showCrmLink();
}

// Chạy hàm này trong Apps Script (chọn kiemTraCRM > Chạy): in link CRM và kiểm tra giao diện có chạy được không.
function kiemTraCRM() {
  var link = crmLinkText_(), key = crmKey_();
  Logger.log('LINK CRM: ' + link);
  try {
    var d = crmLoad(key);
    Logger.log('Đọc dữ liệu OK: ' + d.leads.length + ' khách, ' + d.clicks.length + ' lượt bấm, ' + d.sites.length + ' website.');
  } catch (e) {
    Logger.log('LỖI khi đọc dữ liệu: ' + e.message);
  }
  var hasHtml = true;
  try { HtmlService.createHtmlOutputFromFile('Crm'); } catch (e) { hasHtml = false; Logger.log('THIẾU file giao diện tên Crm: ' + e.message); }
  if (hasHtml) Logger.log('File giao diện Crm: có.');
  Logger.log(crmBaseUrl_() ? 'URL ứng dụng web (ô G2): ' + crmBaseUrl_() : 'CHƯA có URL /exec ở ô G2 tab Website. Triển khai > Quản lý bản triển khai > copy URL ứng dụng web, dán vào ô G2.');
  return link;
}

// Mở giao diện CRM ngay trong file Sheet (không cần bản triển khai, dùng quyền của người đang mở file).
function moGiaoDienCRM() {
  var props = PropertiesService.getScriptProperties(), key = crmKey_();
  if (key.length < 20) { key = Utilities.getUuid().replace(/-/g, ''); props.setProperty('CRM_KEY', key); }
  // gắn khoá vào giao diện (chịu được cả bản Crm.html cũ chưa có dấu /*__KEY__*/)
  var html = HtmlService.createHtmlOutputFromFile('Crm').getContent()
    .replace(/var KEY = (?:\/\*__KEY__\*\/)?''/, 'var KEY = ' + JSON.stringify(key));
  SpreadsheetApp.getUi().showModelessDialog(HtmlService.createHtmlOutput(html).setWidth(1180).setHeight(780), 'CRM Hoàng Hiệp');
}

// Giao diện mở trong file Sheet gọi hàm này để lấy khoá nếu chưa được gắn sẵn. Chỉ trang giao diện mới gọi được
// (google.script.run), mà trang chỉ được phục vụ cho người có khoá hoặc đang mở file Sheet.
function crmDialogKey() {
  var props = PropertiesService.getScriptProperties(), key = crmKey_();
  if (key.length < 20) { key = Utilities.getUuid().replace(/-/g, ''); props.setProperty('CRM_KEY', key); }
  return key;
}

