/**
 * CRM Hoàng Hiệp – bản Google Sheets.
 * Dán toàn bộ file này vào Extensions > Apps Script của file "CRM Hoàng Hiệp", rồi Deploy > Web app.
 * File này được sinh từ google/Code.template.gs bằng `node google/build.mjs` – đừng sửa tay trong Code.gs.
 */
var S_LEADS = 'Khách hàng', S_EVENTS = 'Hoạt động', S_SITES = 'Website';
var STATUS_NEW = 'Mới', STATUS_CONTACTED = 'Đã liên hệ';
var TRACK_JS = "/*! CRM Hoàng Hiệp – mã theo dõi. Nhúng vào mọi website/landing page:\n    <script src=\"https://CRM_CUA_BAN/track.js\" data-key=\"SITE_KEY\" async></script>\n  Tự động: ghi lượt xem, click Zalo / Gọi điện / Messenger / SMS, và gửi form có ô số điện thoại về CRM.\n  Nút bấm đặc biệt (không phải link): thêm thuộc tính data-crm-click=\"zalo|phone|messenger|sms\".\n  Gửi khách thủ công: window.crmLead({name, phone, email, message}) */\n(function () {\n  var el = document.currentScript || document.querySelector('script[data-key][src*=\"track.js\"]');\n  if (!el) return;\n  var key = el.getAttribute('data-key');\n  if (!key) return;\n  var base = new URL(el.src).origin;\n  var gas = /script\\.google(usercontent)?\\.com/.test(el.src); // chạy bằng Google Apps Script\n  var endpoint = gas ? el.src.split('?')[0] : null;\n  var W = window, D = document;\n\n  function store(k, v) { try { if (v === undefined) return localStorage.getItem(k); localStorage.setItem(k, v); } catch (e) { return null; } }\n  var vid = store('crm_vid');\n  if (!vid) { vid = (W.crypto && crypto.randomUUID ? crypto.randomUUID() : String(Date.now()) + Math.random().toString(16).slice(2)); store('crm_vid', vid); }\n\n  // UTM: giữ nguồn đầu tiên (first-touch), không bị ghi đè khi khách quay lại\n  var q = new URLSearchParams(location.search), utm = {};\n  ['utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term'].forEach(function (k) { if (q.get(k)) utm[k] = q.get(k); });\n  if (!utm.utm_source && q.get('gclid')) { utm.utm_source = 'google'; utm.utm_medium = 'cpc'; }\n  if (!utm.utm_source && q.get('fbclid')) { utm.utm_source = 'facebook'; utm.utm_medium = 'paid'; }\n  try {\n    var saved = JSON.parse(store('crm_utm') || 'null');\n    if (!saved || !saved.utm_source) { if (utm.utm_source || document.referrer) store('crm_utm', JSON.stringify({ utm: utm, ref: document.referrer })); saved = { utm: utm, ref: document.referrer }; }\n    utm = Object.keys(utm).length ? utm : saved.utm || {};\n    var firstRef = saved.ref || document.referrer;\n  } catch (e) { var firstRef = document.referrer; }\n\n  function payload(extra) {\n    var o = { key: key, vid: vid, url: location.href, referrer: firstRef || document.referrer };\n    for (var k in utm) o[k] = utm[k];\n    for (var j in extra) o[j] = extra[j];\n    return JSON.stringify(o);\n  }\n  function post(path, extra) {\n    extra = extra || {};\n    if (gas) extra.action = path === '/api/lead' ? 'lead' : 'track';\n    var body = payload(extra), url = gas ? endpoint : base + path;\n    try { if (navigator.sendBeacon && navigator.sendBeacon(url, new Blob([body], { type: 'text/plain' }))) return; } catch (e) {}\n    try { fetch(url, { method: 'POST', body: body, keepalive: true, mode: gas ? 'no-cors' : 'cors', headers: { 'Content-Type': 'text/plain' } }); } catch (e) {}\n  }\n\n  post('/api/track', { type: 'pageview' });\n\n  function channelOf(a) {\n    var forced = a.getAttribute && a.getAttribute('data-crm-click');\n    if (forced) return forced;\n    var h = (a.getAttribute && a.getAttribute('href') || '').toLowerCase();\n    if (/^tel:/.test(h)) return 'phone';\n    if (/^sms:/.test(h)) return 'sms';\n    if (/(^|\\/\\/|\\.)zalo\\.me|zaloapp\\.com|chat\\.zalo\\.me/.test(h)) return 'zalo';\n    if (/(^|\\/\\/)m\\.me\\/|messenger\\.com|fb\\.com\\/msg|facebook\\.com\\/messages/.test(h)) return 'messenger';\n    return null;\n  }\n  var lastClick = {};\n  D.addEventListener('click', function (e) {\n    var n = e.target;\n    while (n && n !== D) {\n      if (n.nodeType === 1 && (n.hasAttribute('data-crm-click') || n.tagName === 'A')) {\n        var ch = channelOf(n);\n        if (ch) {\n          var t = Date.now();\n          if (!lastClick[ch] || t - lastClick[ch] > 1500) { lastClick[ch] = t; post('/api/track', { type: 'click', channel: ch }); }\n          return;\n        }\n      }\n      n = n.parentNode;\n    }\n  }, true);\n\n  // Form: tự bắt form có ô số điện thoại\n  var sent = {};\n  function sendLead(d) {\n    if (!d.phone) return;\n    var digits = String(d.phone).replace(/\\D/g, '');\n    if (digits.length < 9 || (sent[digits] && Date.now() - sent[digits] < 5000)) return;\n    sent[digits] = Date.now();\n    post('/api/lead', d);\n  }\n  D.addEventListener('submit', function (e) {\n    var f = e.target; if (!f || !f.querySelectorAll) return;\n    var d = {};\n    f.querySelectorAll('input,textarea,select').forEach(function (i) {\n      var s = ((i.name || '') + ' ' + (i.id || '') + ' ' + (i.getAttribute('placeholder') || '')).toLowerCase();\n      if (i.type === 'password' || i.type === 'hidden' && !/phone|tel/.test(s)) return;\n      if (!d.phone && (i.type === 'tel' || /phone|sdt|sđt|tel|dien.?thoai|điện.?thoại|số/.test(s))) d.phone = i.value;\n      else if (!d.email && (i.type === 'email' || /mail/.test(s))) d.email = i.value;\n      else if (!d.name && /name|ten|tên|họ/.test(s)) d.name = i.value;\n      else if (!d.message && (i.tagName === 'TEXTAREA' || /note|message|noi.?dung|nội.?dung|ghi.?chú|loi.?nhan/.test(s))) d.message = i.value;\n    });\n    sendLead(d);\n  }, true);\n\n  W.crmLead = sendLead;\n})();\n";

function doGet(e) {
  if (e && e.parameter && e.parameter.js) {
    return ContentService.createTextOutput(TRACK_JS).setMimeType(ContentService.MimeType.JAVASCRIPT);
  }
  return json_({ ok: true, service: 'CRM Hoàng Hiệp' });
}

function doPost(e) {
  try {
    var b = parseBody_(e);
    var site = findSite_(b.key);
    if (!site) return json_({ error: 'Mã website không hợp lệ' });
    var action = b.action || (b.type === 'pageview' || b.type === 'click' ? 'track' : 'lead');
    if (action === 'track') return json_(handleTrack_(b, site));
    return json_(handleLead_(b, site));
  } catch (err) {
    return json_({ error: String(err && err.message || err) });
  }
}

function json_(o) {
  return ContentService.createTextOutput(JSON.stringify(o)).setMimeType(ContentService.MimeType.JSON);
}

function parseBody_(e) {
  var b = {};
  var raw = e && e.postData && e.postData.contents;
  if (raw) { try { b = JSON.parse(raw); } catch (x) { b = {}; } }
  var p = (e && e.parameter) || {};
  for (var k in p) if (b[k] === undefined) b[k] = p[k];   // form-encoded (webhook) hoặc ?key=...
  return b;
}

function str_(v, max) {
  v = v == null ? '' : String(v).slice(0, max || 300);
  return /^[=+\-@]/.test(v) ? "'" + v : v;               // chống chèn công thức
}

function normPhone_(p) {
  var d = String(p || '').replace(/[^\d+]/g, '');
  if (d.indexOf('+84') === 0) d = '0' + d.slice(3);
  else if (d.indexOf('84') === 0 && d.length >= 11) d = '0' + d.slice(2);
  d = d.replace(/\D/g, '');
  return d.length >= 9 && d.length <= 11 ? d : '';
}

function ss_() { return SpreadsheetApp.getActiveSpreadsheet(); }

// key -> tên website, lấy từ tab Website (cột A tên, C mã), cache 60 giây
function findSite_(key) {
  key = String(key || '').trim();
  if (key.length < 8) return null;
  var cache = CacheService.getScriptCache(), map = null;
  try { map = JSON.parse(cache.get('sites') || 'null'); } catch (x) {}
  if (!map) {
    map = {};
    var sh = ss_().getSheetByName(S_SITES), n = sh.getLastRow();
    if (n > 1) sh.getRange(2, 1, n - 1, 3).getValues().forEach(function (r) {
      var k = String(r[2]).trim(); if (k.length >= 8 && r[0]) map[k] = String(r[0]);
    });
    try { cache.put('sites', JSON.stringify(map), 60); } catch (x) {}
  }
  return map[key] ? { key: key, name: map[key] } : null;
}

function logEvent_(b, site, type, channel) {
  ss_().getSheetByName(S_EVENTS).appendRow([
    new Date(), str_(b.vid, 64), site.name, type, channel || '', str_(b.url, 300),
    str_(b.utm_source, 100), str_(b.utm_campaign, 150)
  ]);
}

function handleTrack_(b, site) {
  var type = b.type === 'click' ? 'click' : b.type === 'pageview' ? 'pageview' : '';
  if (!type) return { error: 'type không hợp lệ' };
  var ch = ['zalo', 'phone', 'messenger', 'sms'].indexOf(b.channel) >= 0 ? b.channel : 'other';
  logEvent_(b, site, type, type === 'click' ? ch : '');
  return { ok: true };
}

function handleLead_(b, site) {
  var phone = normPhone_(b.phone);
  if (!phone) return { error: 'Số điện thoại không hợp lệ' };
  var lock = LockService.getScriptLock();
  lock.waitLock(20000);
  try {
    var sh = ss_().getSheetByName(S_LEADS), last = sh.getLastRow(), row = -1;
    if (last > 1) {
      var phones = sh.getRange(2, 4, last - 1, 1).getValues();
      for (var i = 0; i < phones.length; i++) {
        var p = String(phones[i][0]);
        if (p.length === 9) p = '0' + p;                     // ô bị chuyển thành số
        if (p === phone) { row = i + 2; break; }
      }
    }
    var isNew = row < 0;
    if (isNew) {
      row = last + 1;
      var r = row;
      sh.getRange(r, 1, 1, 22).setValues([[
        last, new Date(), str_(b.name, 120), phone, str_(b.email, 160), site.name,
        str_(b.utm_source, 100), str_(b.utm_campaign, 150), str_(b.vid, 64), 1,
        "=COUNTIFS('" + S_EVENTS + "'!$B:$B,$I" + r + ",'" + S_EVENTS + "'!$D:$D,\"click\",'" + S_EVENTS + "'!$E:$E,\"zalo\")",
        "=COUNTIFS('" + S_EVENTS + "'!$B:$B,$I" + r + ",'" + S_EVENTS + "'!$D:$D,\"click\",'" + S_EVENTS + "'!$E:$E,\"phone\")",
        '=HYPERLINK("https://zalo.me/"&$D' + r + ',"Mở Zalo")',
        '=HYPERLINK("tel:"&$D' + r + ',"Gọi")',
        false, false, '',
        '=IF(AND($O' + r + '<>TRUE,$P' + r + '<>TRUE),"CHƯA LIÊN HỆ","")',
        STATUS_NEW, '', '', str_(b.message, 1000)
      ]]);
    } else {
      var c = sh.getRange(row, 10);
      c.setValue((Number(c.getValue()) || 1) + 1);
      var name = sh.getRange(row, 3), email = sh.getRange(row, 5);
      if (!name.getValue() && b.name) name.setValue(str_(b.name, 120));
      if (!email.getValue() && b.email) email.setValue(str_(b.email, 160));
      if (b.message) {
        var note = sh.getRange(row, 22);
        note.setValue((note.getValue() ? note.getValue() + ' | ' : '') + str_(b.message, 500));
      }
    }
    logEvent_(b, site, 'form', '');
    return { ok: true, new: isNew };
  } finally {
    lock.releaseLock();
  }
}

// Khi tick "Đã gọi" / "Đã nhắn": ghi giờ liên hệ đầu tiên và chuyển trạng thái Mới -> Đã liên hệ
function onEdit(e) {
  var sh = e.range.getSheet();
  if (sh.getName() !== S_LEADS) return;
  var c = e.range.getColumn(), r = e.range.getRow();
  if (r < 2 || (c !== 15 && c !== 16) || e.range.getValue() !== true) return;
  var t = sh.getRange(r, 17);
  if (!t.getValue()) t.setValue(new Date());
  var s = sh.getRange(r, 19);
  if (s.getValue() === STATUS_NEW) s.setValue(STATUS_CONTACTED);
}

// ---- Menu CRM ----
function onOpen() {
  SpreadsheetApp.getUi().createMenu('CRM')
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
