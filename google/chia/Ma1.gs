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
  if (e && e.parameter && e.parameter.debug) return json_(debugInfo_());
  // Giao diện CRM chỉ phục vụ người có link kèm khoá riêng (?k=...).
  // Khách lạ mở link không có khoá chỉ thấy dòng JSON.
  if (canUi_(e && e.parameter && e.parameter.k)) {
    return HtmlService.createHtmlOutput(crmHtml_()).setTitle('CRM Hoàng Hiệp')
      .addMetaTag('viewport', 'width=device-width, initial-scale=1');
  }
  return json_({ ok: true, service: 'CRM Hoàng Hiệp' });
}

// ?debug=1: cho biết vì sao giao diện hiện hoặc không hiện (chỉ có/không, không lộ khoá hay dữ liệu)
function debugInfo_() {
  var o = { version: 'ui-6', hasKey: crmKey_().length >= 20, canOpenSheet: false, hasCrmHtml: false };
  try { ss_().getSheetByName(S_LEADS).getLastRow(); o.canOpenSheet = true; } catch (x) {}
  try { crmHtml_(); o.hasCrmHtml = true; } catch (x) {}
  return o;
}

// Link CRM có khoá riêng: <URL ứng dụng web>?k=KHOÁ. Khoá lưu trong Script Properties (menu CRM > Link vào CRM).
function crmKey_() { return PropertiesService.getScriptProperties().getProperty('CRM_KEY') || ''; }
function keyOk_(k) { var s = crmKey_(); return s.length >= 20 && String(k || '') === s; }
function canUi_(k) { return keyOk_(k); }
function requireUi_(k) {
  if (!canUi_(k)) throw new Error('Không có quyền. Hãy mở bằng link CRM có khoá (menu CRM > Link vào CRM trong file Sheet).');
}
function withLock_(fn) {
  var lock = LockService.getScriptLock();
  lock.waitLock(20000);
  try { return fn(); } finally { lock.releaseLock(); }
}
// Dòng cuối thật sự có dữ liệu theo một cột khoá. getLastRow() tính cả các ô tick FALSE dựng sẵn nên không dùng được.
function lastDataRow_(sh, col) {
  var n = sh.getMaxRows ? sh.getMaxRows() : sh.getLastRow();
  if (n < 2) return 1;
  var v = sh.getRange(1, col, n, 1).getValues();
  for (var i = v.length - 1; i >= 1; i--) if (v[i][0] !== '' && v[i][0] != null) return i + 1;
  return 1;
}
function iso_(d) { return d && typeof d.getTime === 'function' ? new Date(d.getTime()).toISOString() : ''; }
function phoneStr_(v) { var p = String(v == null ? '' : v); return p.length === 9 ? '0' + p : p; }

// ---- API cho giao diện (google.script.run) ----
function crmLoad(k) {
  requireUi_(k);
  var ss = ss_(), out = { user: '', now: new Date().toISOString() };
  var sh = ss.getSheetByName(S_LEADS), n = lastDataRow_(sh, 2);
  var rows = n > 1 ? sh.getRange(2, 1, n - 1, 22).getValues() : [];
  out.leads = rows.filter(function (r) { return r[3]; }).map(function (r) {
    return { id: r[0], at: iso_(r[1]), name: String(r[2] || ''), phone: phoneStr_(r[3]), email: String(r[4] || ''), site: String(r[5] || ''),
      source: String(r[6] || ''), campaign: String(r[7] || ''), vid: String(r[8] || ''), submits: Number(r[9]) || 1,
      zaloClicks: Number(r[10]) || 0, phoneClicks: Number(r[11]) || 0, called: r[14] === true, messaged: r[15] === true,
      contactedAt: iso_(r[16]), status: String(r[18] || 'Mới'), assignee: String(r[19] || ''), value: Number(r[20]) || 0, note: String(r[21] || '') };
  }).reverse();
  var cs = ss.getSheetByName(S_CLICKS), cn = cs ? lastDataRow_(cs, 1) : 1, start = Math.max(2, cn - 1499);
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
  var want = normPhone_(phone), sh = ss_().getSheetByName(S_LEADS), n = lastDataRow_(sh, 2);
  if (!want || n < 2) throw new Error('Không tìm thấy khách');
  var ph = sh.getRange(2, 4, n - 1, 1).getValues();
  for (var i = 0; i < ph.length; i++) if (normPhone_(phoneStr_(ph[i][0])) === want) return { sh: sh, row: i + 2 };
  throw new Error('Không tìm thấy khách');
}

// Bấm Gọi / Zalo / SMS trong giao diện -> ghi "Đã gọi" / "Đã nhắn", giờ liên hệ đầu tiên, đổi trạng thái Mới -> Đã liên hệ
function crmLog(k, phone, type) {
  requireUi_(k);
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

