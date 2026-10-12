/**
 * CRM Hoàng Hiệp – bản Google Sheets.
 * Dán toàn bộ file này vào Extensions > Apps Script của file "CRM Hoàng Hiệp", rồi Deploy > Web app.
 * File này được sinh từ google/Code.template.gs bằng `node google/build.mjs` – đừng sửa tay trong Code.gs.
 */
var S_LEADS = 'Khách hàng', S_EVENTS = 'Hoạt động', S_SITES = 'Website', S_CLICKS = 'Lượt bấm';
var STATUS_NEW = 'Mới', STATUS_CONTACTED = 'Đã liên hệ';
var TRACK_JS = "/*! CRM Hoàng Hiệp – mã theo dõi. Nhúng vào mọi website/landing page:\n    <script src=\"https://CRM_CUA_BAN/track.js\" data-key=\"SITE_KEY\" async></script>\n  Tự động: ghi lượt xem, click Zalo / Gọi điện / Messenger / SMS, và gửi form có ô số điện thoại về CRM.\n  Nút bấm đặc biệt (không phải link): thêm thuộc tính data-crm-click=\"zalo|phone|messenger|sms\".\n  Gửi khách thủ công: window.crmLead({name, phone, email, message}) */\n(function () {\n  var el = document.currentScript || document.querySelector('script[data-key][src*=\"track.js\"]');\n  if (!el) return;\n  var key = el.getAttribute('data-key');\n  if (!key) return;\n  var base = new URL(el.src).origin;\n  var gas = /script\\.google(usercontent)?\\.com/.test(el.src); // chạy bằng Google Apps Script\n  var endpoint = gas ? el.src.split('?')[0] : null;\n  var W = window, D = document;\n\n  function store(k, v) { try { if (v === undefined) return localStorage.getItem(k); localStorage.setItem(k, v); } catch (e) { return null; } }\n  var vid = store('crm_vid');\n  if (!vid) { vid = (W.crypto && crypto.randomUUID ? crypto.randomUUID() : String(Date.now()) + Math.random().toString(16).slice(2)); store('crm_vid', vid); }\n\n  // UTM: giữ nguồn đầu tiên (first-touch), không bị ghi đè khi khách quay lại\n  var q = new URLSearchParams(location.search), utm = {};\n  ['utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term'].forEach(function (k) { if (q.get(k)) utm[k] = q.get(k); });\n  if (!utm.utm_source && q.get('gclid')) { utm.utm_source = 'google'; utm.utm_medium = 'cpc'; }\n  if (!utm.utm_source && q.get('fbclid')) { utm.utm_source = 'facebook'; utm.utm_medium = 'paid'; }\n  try {\n    var saved = JSON.parse(store('crm_utm') || 'null');\n    if (!saved || !saved.utm_source) { if (utm.utm_source || document.referrer) store('crm_utm', JSON.stringify({ utm: utm, ref: document.referrer })); saved = { utm: utm, ref: document.referrer }; }\n    utm = Object.keys(utm).length ? utm : saved.utm || {};\n    var firstRef = saved.ref || document.referrer;\n  } catch (e) { var firstRef = document.referrer; }\n\n  function payload(extra) {\n    var o = { key: key, vid: vid, url: location.href, referrer: firstRef || document.referrer };\n    for (var k in utm) o[k] = utm[k];\n    for (var j in extra) o[j] = extra[j];\n    return JSON.stringify(o);\n  }\n  function post(path, extra) {\n    extra = extra || {};\n    if (gas) extra.action = path === '/api/lead' ? 'lead' : 'track';\n    var body = payload(extra), url = gas ? endpoint : base + path;\n    try { if (navigator.sendBeacon && navigator.sendBeacon(url, new Blob([body], { type: 'text/plain' }))) return; } catch (e) {}\n    try { fetch(url, { method: 'POST', body: body, keepalive: true, mode: gas ? 'no-cors' : 'cors', headers: { 'Content-Type': 'text/plain' } }); } catch (e) {}\n  }\n\n  post('/api/track', { type: 'pageview' });\n\n  function channelOf(a) {\n    var forced = a.getAttribute && a.getAttribute('data-crm-click');\n    if (forced) return forced;\n    var h = (a.getAttribute && a.getAttribute('href') || '').toLowerCase();\n    if (/^tel:/.test(h)) return 'phone';\n    if (/^sms:/.test(h)) return 'sms';\n    if (/(^|\\/\\/|\\.)zalo\\.me|zaloapp\\.com|chat\\.zalo\\.me/.test(h)) return 'zalo';\n    if (/(^|\\/\\/)m\\.me\\/|messenger\\.com|fb\\.com\\/msg|facebook\\.com\\/messages/.test(h)) return 'messenger';\n    return null;\n  }\n  var lastClick = {};\n  D.addEventListener('click', function (e) {\n    var n = e.target;\n    while (n && n !== D) {\n      if (n.nodeType === 1 && (n.hasAttribute('data-crm-click') || n.tagName === 'A')) {\n        var ch = channelOf(n);\n        if (ch) {\n          var t = Date.now();\n          if (!lastClick[ch] || t - lastClick[ch] > 1500) { lastClick[ch] = t; post('/api/track', { type: 'click', channel: ch }); }\n          return;\n        }\n      }\n      n = n.parentNode;\n    }\n  }, true);\n\n  // Form: tự bắt form có ô số điện thoại\n  var sent = {};\n  function sendLead(d) {\n    if (!d.phone) return;\n    var digits = String(d.phone).replace(/\\D/g, '');\n    if (digits.length < 9 || (sent[digits] && Date.now() - sent[digits] < 5000)) return;\n    sent[digits] = Date.now();\n    post('/api/lead', d);\n  }\n  D.addEventListener('submit', function (e) {\n    var f = e.target; if (!f || !f.querySelectorAll) return;\n    var d = {};\n    f.querySelectorAll('input,textarea,select').forEach(function (i) {\n      var s = ((i.name || '') + ' ' + (i.id || '') + ' ' + (i.getAttribute('placeholder') || '')).toLowerCase();\n      if (i.type === 'password' || i.type === 'hidden' && !/phone|tel/.test(s)) return;\n      if (!d.phone && (i.type === 'tel' || /phone|sdt|sđt|tel|dien.?thoai|điện.?thoại|số/.test(s))) d.phone = i.value;\n      else if (!d.email && (i.type === 'email' || /mail/.test(s))) d.email = i.value;\n      else if (!d.name && /name|ten|tên|họ/.test(s)) d.name = i.value;\n      else if (!d.message && (i.tagName === 'TEXTAREA' || /note|message|noi.?dung|nội.?dung|ghi.?chú|loi.?nhan/.test(s))) d.message = i.value;\n    });\n    sendLead(d);\n  }, true);\n\n  W.crmLead = sendLead;\n})();\n";

function doGet(e) {
  if (e && e.parameter && e.parameter.js) {
    return ContentService.createTextOutput(TRACK_JS).setMimeType(ContentService.MimeType.JAVASCRIPT);
  }
  // Giao diện CRM chỉ phục vụ người đã đăng nhập Google qua bản triển khai "Người dùng truy cập ứng dụng web".
  // Bản triển khai nhận dữ liệu từ website ("Tôi" + "Bất kỳ ai") không bao giờ lộ giao diện này cho khách lạ.
  if (isUiUser_()) {
    return HtmlService.createHtmlOutputFromFile('Crm').setTitle('CRM Hoàng Hiệp')
      .addMetaTag('viewport', 'width=device-width, initial-scale=1');
  }
  return json_({ ok: true, service: 'CRM Hoàng Hiệp' });
}

// Giao diện chỉ dành cho người dùng đăng nhập Google chạy bằng chính quyền của họ:
// (1) email người mở trùng người chạy, hoặc (2) người chạy KHÔNG phải chủ file nhưng đọc được file Sheet.
// Bản triển khai "Tôi" (nhận dữ liệu từ website) luôn chạy bằng chủ file nên khách lạ không bao giờ qua được.
function isUiUser_() {
  try {
    var a = Session.getActiveUser().getEmail(), e = Session.getEffectiveUser().getEmail();
    if (a && a === e) return true;
    if (!e) return false;
    var o = ss_().getOwner();
    return !!o && o.getEmail() !== e;
  } catch (x) { return false; }
}
function requireUi_() {
  if (!isUiUser_()) throw new Error('Không có quyền. Mở bằng link CRM và đăng nhập Gmail đã được chia sẻ file Sheet.');
}
function withLock_(fn) {
  var lock = LockService.getScriptLock();
  lock.waitLock(20000);
  try { return fn(); } finally { lock.releaseLock(); }
}
function iso_(d) { return d && typeof d.getTime === 'function' ? new Date(d.getTime()).toISOString() : ''; }
function phoneStr_(v) { var p = String(v == null ? '' : v); return p.length === 9 ? '0' + p : p; }

// ---- API cho giao diện (google.script.run) ----
function crmLoad() {
  requireUi_();
  var ss = ss_(), out = { user: Session.getActiveUser().getEmail(), now: new Date().toISOString() };
  var sh = ss.getSheetByName(S_LEADS), n = sh.getLastRow();
  var rows = n > 1 ? sh.getRange(2, 1, n - 1, 22).getValues() : [];
  out.leads = rows.filter(function (r) { return r[3]; }).map(function (r) {
    return { id: r[0], at: iso_(r[1]), name: String(r[2] || ''), phone: phoneStr_(r[3]), email: String(r[4] || ''), site: String(r[5] || ''),
      source: String(r[6] || ''), campaign: String(r[7] || ''), vid: String(r[8] || ''), submits: Number(r[9]) || 1,
      zaloClicks: Number(r[10]) || 0, phoneClicks: Number(r[11]) || 0, called: r[14] === true, messaged: r[15] === true,
      contactedAt: iso_(r[16]), status: String(r[18] || 'Mới'), assignee: String(r[19] || ''), value: Number(r[20]) || 0, note: String(r[21] || '') };
  }).reverse();
  var cs = ss.getSheetByName(S_CLICKS), cn = cs ? cs.getLastRow() : 1, start = Math.max(2, cn - 1499);
  var crow = cn > 1 ? cs.getRange(start, 1, cn - start + 1, 11).getValues() : [];
  out.clicks = crow.map(function (r, i) {
    return { row: start + i, at: iso_(r[0]), vid: String(r[1] || ''), site: String(r[2] || ''), channel: String(r[3] || ''), url: String(r[4] || ''),
      source: String(r[5] || ''), campaign: String(r[6] || ''), leftPhone: r[7] === 'Có', checked: r[8] === true, note: String(r[9] || ''), alert: String(r[10] || '') };
  }).filter(function (c) { return c.at; }).reverse();
  var ov = ss.getSheetByName('Tổng quan');
  out.kpis = ov.getRange(7, 1, 9, 2).getDisplayValues().filter(function (r) { return r[0]; });
  out.siteStats = ov.getRange(17, 1, 16, 8).getDisplayValues().filter(function (r, i) { return i === 0 || r[0]; });
  var ws = ss.getSheetByName(S_SITES), wn = ws.getLastRow();
  out.sites = (wn > 1 ? ws.getRange(2, 1, wn - 1, 4).getValues() : []).filter(function (r) { return r[0]; })
    .map(function (r) { return { name: String(r[0]), domain: String(r[1]), key: String(r[2]), snippet: String(r[3] || '') }; });
  var cp = ss.getSheetByName('Chiến dịch');
  out.campaigns = cp.getRange(1, 1, 31, 13).getDisplayValues().filter(function (r, i) { return i === 0 || r[2]; });
  return out;
}

function findLead_(phone) {
  var want = normPhone_(phone), sh = ss_().getSheetByName(S_LEADS), n = sh.getLastRow();
  if (!want || n < 2) throw new Error('Không tìm thấy khách');
  var ph = sh.getRange(2, 4, n - 1, 1).getValues();
  for (var i = 0; i < ph.length; i++) if (normPhone_(phoneStr_(ph[i][0])) === want) return { sh: sh, row: i + 2 };
  throw new Error('Không tìm thấy khách');
}

// Bấm Gọi / Zalo / SMS trong giao diện -> ghi "Đã gọi" / "Đã nhắn", giờ liên hệ đầu tiên, đổi trạng thái Mới -> Đã liên hệ
function crmLog(phone, type) {
  requireUi_();
  if (['call', 'zalo', 'sms'].indexOf(type) < 0) throw new Error('Loại không hợp lệ');
  return withLock_(function () {
    var f = findLead_(phone), sh = f.sh, r = f.row, now = new Date();
    sh.getRange(r, type === 'call' ? 15 : 16).setValue(true);
    var q = sh.getRange(r, 17);
    if (!q.getValue()) q.setValue(now);
    var s = sh.getRange(r, 19);
    if (s.getValue() === STATUS_NEW) s.setValue(STATUS_CONTACTED);
    return { called: sh.getRange(r, 15).getValue() === true, messaged: sh.getRange(r, 16).getValue() === true,
      contactedAt: iso_(q.getValue()), status: String(s.getValue()) };
  });
}

var STATUSES = ['Mới', 'Đã liên hệ', 'Quan tâm', 'Hẹn xem', 'Chốt', 'Mất'];
function crmUpdateLead(phone, f) {
  requireUi_();
  f = f || {};
  if (f.status !== undefined && STATUSES.indexOf(f.status) < 0) throw new Error('Trạng thái không hợp lệ');
  return withLock_(function () {
    var x = findLead_(phone), sh = x.sh, r = x.row;
    if (f.name !== undefined) sh.getRange(r, 3).setValue(str_(f.name, 120));
    if (f.status !== undefined) sh.getRange(r, 19).setValue(f.status);
    if (f.assignee !== undefined) sh.getRange(r, 20).setValue(str_(f.assignee, 80));
    if (f.value !== undefined) sh.getRange(r, 21).setValue(Math.max(0, Number(f.value) || 0));
    if (f.note !== undefined) sh.getRange(r, 22).setValue(str_(f.note, 2000));
    return { ok: true };
  });
}

function crmClickDone(row, vid, done, note) {
  requireUi_();
  return withLock_(function () {
    var sh = ss_().getSheetByName(S_CLICKS);
    row = Number(row);
    if (!sh || row < 2 || String(sh.getRange(row, 2).getValue()) !== String(vid)) throw new Error('Dòng đã thay đổi, hãy tải lại');
    sh.getRange(row, 9).setValue(done === true);
    if (note !== undefined) sh.getRange(row, 10).setValue(str_(note, 300));
    return { ok: true };
  });
}

function crmEvents(vid) {
  requireUi_();
  vid = String(vid || '');
  if (!vid) return [];
  var sh = ss_().getSheetByName(S_EVENTS), n = sh.getLastRow();
  if (n < 2) return [];
  var rows = sh.getRange(2, 1, n - 1, 8).getValues(), out = [];
  for (var i = rows.length - 1; i >= 0 && out.length < 100; i--) {
    var r = rows[i];
    if (String(r[1]) === vid) out.push({ at: iso_(r[0]), site: String(r[2]), type: String(r[3]), channel: String(r[4]), url: String(r[5]), source: String(r[6]), campaign: String(r[7]) });
  }
  return out;
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
  if (type === 'click') { try { logClick_(b, site, ch); } catch (e) { /* thiếu tab Lượt bấm: vẫn giữ sự kiện ở tab Hoạt động */ } }
  return { ok: true };
}

// Mỗi lượt bấm Zalo/Gọi/Messenger là một dòng ở tab "Lượt bấm": đỏ "CHƯA XỬ LÝ" cho tới khi khách để lại SĐT
// (tự nhận ra qua mã người truy cập) hoặc bạn tick "Đã kiểm tra / liên hệ".
function logClick_(b, site, ch) {
  var lock = LockService.getScriptLock();
  lock.waitLock(20000);
  try {
    var sh = ss_().getSheetByName(S_CLICKS);
    if (!sh) return;
    var r = sh.getLastRow() + 1;
    sh.getRange(r, 1, 1, 11).setValues([[
      new Date(), str_(b.vid, 64), site.name, ch, str_(b.url, 300), str_(b.utm_source, 100), str_(b.utm_campaign, 150),
      "=IF(COUNTIF('" + S_LEADS + "'!$I:$I,$B" + r + ")>0,\"Có\",\"Chưa\")",
      false, '',
      '=IF(AND($H' + r + '="Chưa",$I' + r + '<>TRUE),"CHƯA XỬ LÝ","")'
    ]]);
  } finally {
    lock.releaseLock();
  }
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
