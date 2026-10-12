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
    return HtmlService.createHtmlOutput(crmHtml_().replace(/var KEY = (?:\/\*__KEY__\*\/)?''/, function () { return 'var KEY = ' + JSON.stringify(String(e.parameter.k)); })).setTitle('CRM Hoàng Hiệp')
      .addMetaTag('viewport', 'width=device-width, initial-scale=1');
  }
  return json_({ ok: true, service: 'CRM Hoàng Hiệp' });
}

// ?debug=1: cho biết vì sao giao diện hiện hoặc không hiện (chỉ có/không, không lộ khoá hay dữ liệu)
function debugInfo_() {
  var o = { version: 'ui-10', hasKey: crmKey_().length >= 20, canOpenSheet: false, hasCrmHtml: false };
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
  out.sales = salesList_();
  var ov = ss.getSheetByName('Tổng quan');
  out.kpis = ov.getRange(7, 1, 9, 2).getDisplayValues().filter(function (r) { return r[0]; });
  out.siteStats = ov.getRange(17, 1, 16, 8).getDisplayValues().filter(function (r, i) { return i === 0 || r[0]; });
  var ws = ss.getSheetByName(S_SITES), wn = ws.getLastRow();
  out.sites = (wn > 1 ? ws.getRange(2, 1, wn - 1, 5).getValues() : []).filter(function (r) { return r[0]; })
    .map(function (r) { return { name: String(r[0]), domain: String(r[1]), key: String(r[2]), snippet: String(r[3] || ''), group: String(r[4] || '') }; });
  var cp = ss.getSheetByName('Chiến dịch');
  out.campaigns = cp.getRange(1, 1, 31, 13).getDisplayValues().filter(function (r, i) { return i === 0 || r[2]; });
  return out;
}

// Danh sách sale để giao khách: tab "Sale" (cột A = tên). Tự tạo khi thêm sale đầu tiên.
function salesList_() {
  try {
    var sh = ss_().getSheetByName('Sale');
    if (!sh) return [];
    var n = sh.getLastRow();
    if (n < 2) return [];
    return sh.getRange(2, 1, n - 1, 1).getValues().map(function (r) { return String(r[0] || '').trim(); }).filter(Boolean);
  } catch (e) { return []; }
}
function crmAddSale(k, name) {
  requireUi_(k);
  name = String(name || '').trim().slice(0, 80);
  if (!name) throw new Error('Chưa nhập tên sale');
  return withLock_(function () {
    var ss = ss_(), sh = ss.getSheetByName('Sale');
    if (!sh) { sh = ss.insertSheet('Sale'); sh.getRange(1, 1, 1, 2).setValues([['Tên sale', 'Ghi chú']]); }
    if (salesList_().indexOf(name) < 0) sh.appendRow([str_(name, 80), '']);
    return salesList_();
  });
}

// ---- Quân sư AI: hỏi Claude về cách chăm khách. Khoá API lưu trong Script Properties (menu CRM > Cài khoá quân sư).
var ASK_MODEL = 'claude-sonnet-5-5';
function leadContext_(phone) {
  var f = findLead_(phone), r = f.sh.getRange(f.row, 1, 1, 22).getValues()[0];
  return 'Khách: ' + (r[2] || '(chưa có tên)') + ', SĐT ' + phoneStr_(r[3]) + '. Dự án / website: ' + r[5] + '. Nguồn: ' + (r[6] || 'không rõ') +
    ', chiến dịch: ' + (r[7] || 'không rõ') + '. Gửi form ' + (Number(r[9]) || 1) + ' lần, bấm Zalo ' + (Number(r[10]) || 0) + ' lần, bấm Gọi ' + (Number(r[11]) || 0) +
    ' lần. Đã gọi: ' + (r[14] === true ? 'rồi' : 'chưa') + ', đã nhắn: ' + (r[15] === true ? 'rồi' : 'chưa') + '. Trạng thái: ' + (r[18] || 'Mới') +
    '. Sale phụ trách: ' + (r[19] || 'chưa giao') + '. Ghi chú: ' + (r[21] || 'không có') + '.';
}
function crmAsk(k, question, phone) {
  requireUi_(k);
  question = String(question || '').trim().slice(0, 1500);
  if (!question) throw new Error('Chưa nhập câu hỏi');
  var key = PropertiesService.getScriptProperties().getProperty('ANTHROPIC_KEY') || '';
  if (!key) throw new Error('Chưa cài khoá quân sư. Vào file Sheet, menu CRM > Cài khoá quân sư (AI), dán khoá API vào.');
  var cache = CacheService.getScriptCache(), n = Number(cache.get('ask_n') || 0);
  if (n >= 12) throw new Error('Hỏi hơi nhanh, đợi một phút rồi hỏi tiếp.');
  cache.put('ask_n', String(n + 1), 60);
  var ctx = '';
  if (phone) { try { ctx = '\n\nThông tin khách đang hỏi: ' + leadContext_(phone); } catch (e) {} }
  var res = UrlFetchApp.fetch('https://api.anthropic.com/v1/messages', {
    method: 'post', contentType: 'application/json', muteHttpExceptions: true,
    headers: { 'x-api-key': key, 'anthropic-version': '2023-06-01' },
    payload: JSON.stringify({
      model: ASK_MODEL, max_tokens: 900,
      system: 'Bạn là quân sư bán hàng bất động sản tại Đà Nẵng, tư vấn cho nhân viên sale. Trả lời bằng tiếng Việt, ngắn gọn, thực tế, dễ làm theo ngay. ' +
        'Khi soạn tin nhắn cho khách thì viết sẵn nội dung gửi được luôn, lịch sự, không hứa hẹn sai sự thật, không bịa giá hay chính sách.' + ctx,
      messages: [{ role: 'user', content: question }]
    })
  });
  var code = res.getResponseCode(), body = {};
  try { body = JSON.parse(res.getContentText()); } catch (e) {}
  if (code !== 200) throw new Error('Quân sư lỗi (' + code + '): ' + ((body.error && body.error.message) || 'không rõ nguyên nhân'));
  return (body.content || []).map(function (b) { return b.text || ''; }).join('').trim();
}
function caiKhoaQuanSu() {
  var ui = SpreadsheetApp.getUi();
  var r = ui.prompt('Cài khoá quân sư (AI)', 'Dán khoá API của Anthropic (bắt đầu bằng sk-ant-). Khoá chỉ lưu trong file này, không hiện lại.', ui.ButtonSet.OK_CANCEL);
  if (r.getSelectedButton() !== ui.Button.OK) return;
  var v = String(r.getResponseText() || '').trim();
  if (!/^sk-ant-[\w-]{20,}$/.test(v)) { ui.alert('Khoá không đúng dạng. Hãy dán lại đủ cả khoá.'); return; }
  PropertiesService.getScriptProperties().setProperty('ANTHROPIC_KEY', v);
  ui.alert('Đã cài khoá quân sư. Vào CRM > tab "Hỏi quân sư" để dùng.');
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

var STATUSES = ['Mới', 'Đã liên hệ', 'Quan tâm', 'Hẹn xem', 'Chốt', 'Mất'];
function crmUpdateLead(k, phone, f) {
  requireUi_(k);
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

function crmClickDone(k, row, vid, done, note) {
  requireUi_(k);
  return withLock_(function () {
    var sh = ss_().getSheetByName(S_CLICKS);
    row = Number(row);
    if (!sh || row < 2 || String(sh.getRange(row, 2).getValue()) !== String(vid)) throw new Error('Dòng đã thay đổi, hãy tải lại');
    sh.getRange(row, 9).setValue(done === true);
    if (note !== undefined) sh.getRange(row, 10).setValue(str_(note, 300));
    return { ok: true };
  });
}

function crmEvents(k, vid) {
  requireUi_(k);
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
    var r = lastDataRow_(sh, 1) + 1;
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
    var sh = ss_().getSheetByName(S_LEADS), last = lastDataRow_(sh, 2), row = -1;
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
    .addItem('Mở giao diện CRM (trong file này)', 'moGiaoDienCRM')
    .addItem('Link vào CRM (giao diện web)', 'showCrmLink')
    .addItem('Đổi link CRM (huỷ link cũ)', 'resetCrmLink')
    .addItem('Cài khoá quân sư (AI)', 'caiKhoaQuanSu')
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
  try { crmHtml_(); } catch (e) { hasHtml = false; Logger.log('THIẾU file giao diện tên Crm: ' + e.message); }
  if (hasHtml) Logger.log('File giao diện Crm: có.');
  Logger.log(crmBaseUrl_() ? 'URL ứng dụng web (ô G2): ' + crmBaseUrl_() : 'CHƯA có URL /exec ở ô G2 tab Website. Triển khai > Quản lý bản triển khai > copy URL ứng dụng web, dán vào ô G2.');
  return link;
}

// Giao diện lấy từ file HTML tên Crm (hoặc nằm sẵn trong chuỗi CRM_HTML của bản gộp Code.all.gs).
var CRM_HTML = "<!doctype html>\n<html lang=\"vi\">\n<head>\n<base target=\"_top\">\n<meta charset=\"utf-8\">\n<meta name=\"viewport\" content=\"width=device-width,initial-scale=1\">\n<title>CRM Hoàng Hiệp</title>\n<style>\n:root{--navy9:#0B1F3D;--navy8:#12305C;--navy7:#1B4585;--gold:#D9A441;--gold2:#E9C67C;--goldsoft:#FBF1DC;--bg:#F5F6FA;--card:#fff;--ink:#0F1B33;--mut:#5E6B85;--line:#E3E8F1;--red:#C62828;--redsoft:#FDECEC;--green:#1E8E4F;--greensoft:#E6F5EC;--blue:#0068FF}\n*{box-sizing:border-box}\nhtml{background:var(--bg)}\nbody{margin:0;font:14.5px/1.55 system-ui,-apple-system,\"Segoe UI\",Roboto,sans-serif;color:var(--ink);background:var(--bg);min-height:100vh}\n.fx{position:fixed;inset:0;pointer-events:none;z-index:0;overflow:hidden}\n.skyline{position:absolute;left:0;right:0;bottom:0;height:min(30vh,240px);background:url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 230' fill='rgba(11,31,61,0.06)' stroke='%230B1F3D' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.8'%3E%3Cpath d='M0 188 L70 140 L120 165 L190 100 L250 150 L300 128 L340 188Z'/%3E%3Cpath d='M900 188 L960 150 L1010 172 L1065 128 L1120 168 L1200 140 L1200 188Z'/%3E%3Cpath fill='none' stroke-width='3.6' d='M250 186 C288 104 330 104 360 158 C390 208 432 208 462 158 C492 104 534 104 566 186'/%3E%3Cpath fill='none' d='M250 186 H574'/%3E%3Cpath fill='none' stroke-width='1.2' d='M283 150 V186 M310 118 V186 M338 130 V186 M366 164 V186 M398 192 V186 M428 192 V186 M458 164 V186 M486 130 V186 M514 118 V186 M542 150 V186'/%3E%3Cpath d='M566 182 l30 -26 l10 7 l-14 10 l20 3 l-5 12 l-25 0Z'/%3E%3Cpath fill='none' stroke-width='3' d='M660 186 V70 M700 186 V70 M740 186 V70'/%3E%3Cpath fill='none' stroke-width='1.1' d='M660 70 L612 186 M660 70 L700 186 M700 70 L660 186 M700 70 L740 186 M740 70 L700 186 M740 70 L790 186'/%3E%3Cpath fill='none' stroke-width='3.4' d='M850 188 Q935 128 1020 188'/%3E%3Cpath d='M838 192 C826 160 846 130 876 134 C892 136 894 156 882 166 C872 176 872 184 874 192Z'/%3E%3Cpath d='M1032 192 C1044 160 1024 130 994 134 C978 136 976 156 988 166 C998 176 998 184 996 192Z'/%3E%3Ccircle cx='1100' cy='92' r='58' fill='none'/%3E%3Ccircle cx='1100' cy='92' r='7'/%3E%3Cpath fill='none' stroke-width='1.3' d='M1100 34 V150 M1042 92 H1158 M1059 51 L1141 133 M1141 51 L1059 133'/%3E%3Cpath fill='none' stroke-width='2.6' d='M1070 190 L1100 150 L1130 190'/%3E%3Cpath fill='none' stroke-width='1.4' d='M0 212 q25 -9 50 0 t50 0 t50 0 t50 0 t50 0 t50 0 t50 0 t50 0 t50 0 t50 0 t50 0 t50 0 t50 0 t50 0 t50 0 t50 0 t50 0 t50 0 t50 0 t50 0 t50 0 t50 0 t50 0 t50 0'/%3E%3C/svg%3E\") center bottom/min(1500px,100%) auto no-repeat;opacity:.10}\n@keyframes sheen{to{background-position:200% 0}}\n@keyframes flow{from{background-position:0 2px,0 12px}to{background-position:400px 2px,-300px 12px}}\n@keyframes flow2{from{background-position:0 0,0 14px}to{background-position:-400px 0,300px 14px}}\n@media (prefers-reduced-motion:reduce){header::before,header::after,.waves{animation:none}}\n\nheader{position:sticky;top:0;z-index:5;padding:10px 16px 0;display:flex;gap:6px 12px;align-items:center;flex-wrap:wrap;color:#fff;overflow:hidden;\n  background:linear-gradient(rgba(255,255,255,.06) 1px,transparent 1px) 0 0/30px 30px,linear-gradient(90deg,rgba(255,255,255,.06) 1px,transparent 1px) 0 0/30px 30px,radial-gradient(520px 170px at 92% -40%,rgba(226,179,90,.26),transparent 62%),radial-gradient(420px 160px at 4% 140%,rgba(80,140,230,.22),transparent 62%),linear-gradient(135deg,var(--navy9) 0%,var(--navy8) 100%);\n  box-shadow:0 4px 18px rgba(11,31,61,.22)}\nheader>*{position:relative;z-index:1}\nheader::before{content:\"\";position:absolute;left:0;right:0;bottom:2px;height:30px;z-index:0;pointer-events:none;\n  background:url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 24' fill='none' stroke='rgba(190,215,255,.50)' stroke-width='1.3' stroke-linecap='round'%3E%3Cpath d='M0 12 q25 -7 50 0 t50 0 q25 -7 50 0 t50 0 q25 -7 50 0 t50 0 q25 -7 50 0 t50 0'/%3E%3C/svg%3E\") 0 2px/400px 24px repeat-x,url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 24' fill='none' stroke='rgba(233,198,124,.45)' stroke-width='1.1' stroke-linecap='round'%3E%3Cpath d='M0 12 q25 -5 50 0 t50 0 q25 -5 50 0 t50 0 q25 -5 50 0 t50 0 q25 -5 50 0 t50 0'/%3E%3C/svg%3E\") 0 12px/300px 22px repeat-x;opacity:.55;animation:flow 18s linear infinite}\nheader::after{content:\"\";position:absolute;left:0;right:0;bottom:0;height:2px;background:linear-gradient(90deg,var(--gold),var(--gold2),var(--gold));background-size:200% 100%;animation:sheen 14s linear infinite;z-index:1}\nheader h1{display:flex;align-items:center;gap:10px;margin:0;font-size:17px;font-weight:650;letter-spacing:.5px;color:#fff}\n.logo{flex:none}\n.sp{flex:1}.mut{color:var(--mut)}.small{font-size:12px}\nheader .mut{color:#C5D0E6}\nheader .btn{background:rgba(255,255,255,.08);color:#fff;border:1px solid rgba(255,255,255,.28);padding:6px 12px}\nheader .btn:hover{background:rgba(255,255,255,.18);box-shadow:none}\nnav{display:flex;gap:2px;flex-wrap:wrap;width:100%}\nnav button{border:0;background:none;color:#C5D0E6;padding:9px 14px 12px;font:inherit;cursor:pointer;position:relative;border-radius:8px 8px 0 0;transition:color .2s,background .2s}\nnav button:hover{color:#fff;background:rgba(255,255,255,.07)}\nnav button.on{color:#fff;font-weight:600;background:rgba(255,255,255,.08)}\nnav button.on::after{content:\"\";position:absolute;left:10px;right:10px;bottom:0;height:3px;border-radius:3px 3px 0 0;background:var(--gold)}\nnav .dot{background:#E5484D;color:#fff;border-radius:99px;font-size:11px;font-weight:600;padding:1px 6px;margin-left:5px}\nmain{position:relative;z-index:1;max-width:1100px;margin:0 auto;padding:20px 16px 140px}\n\n.card,.kpi{background:var(--card);color:var(--ink);border:1px solid var(--line);border-radius:14px;padding:15px;margin-bottom:12px;box-shadow:0 1px 2px rgba(11,31,61,.05),0 8px 22px rgba(11,31,61,.06);transition:box-shadow .2s,transform .2s}\n.card:hover,.kpi:hover{box-shadow:0 1px 2px rgba(11,31,61,.06),0 12px 28px rgba(11,31,61,.10)}\n.grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:12px;margin-bottom:12px}\n.grid .kpi{margin:0;padding:14px 16px;position:relative;overflow:hidden}\n.grid .kpi::before{content:\"\";position:absolute;left:0;top:0;bottom:0;width:4px;background:var(--gold)}\n.kpi b{display:block;font-size:28px;line-height:1.15;font-weight:700;color:var(--navy9);letter-spacing:-.4px}.kpi span{display:block;margin-top:2px;font-size:12.5px;color:var(--mut)}\n.kpi.alert{background:var(--redsoft);border-color:#F3C4C2}.kpi.alert::before{background:var(--red)}.kpi.alert b{color:var(--red)}\nbutton,select,input,textarea{font:inherit;color:var(--ink)}\n.btn{border:1px solid var(--line);background:#fff;color:var(--navy9);font-weight:500;padding:7px 14px;border-radius:10px;cursor:pointer;transition:background .15s,box-shadow .15s,transform .15s}\n.btn:hover{background:#F1F4FA;box-shadow:0 2px 8px rgba(11,31,61,.12)}\n.btn.z{background:var(--blue);border-color:var(--blue);color:#fff}.btn.z:hover{background:#0A5BE0}\n.btn.g{background:var(--gold);border-color:var(--gold);color:var(--navy9);font-weight:600}.btn.g:hover{background:#E2B04F}\n.btn.p{background:var(--navy9);border-color:var(--navy9);color:#fff}.btn.p:hover{background:var(--navy8)}\n.btn:disabled{opacity:.5;cursor:default;box-shadow:none}\ninput,select,textarea{padding:8px 11px;border:1px solid #D2DAE8;border-radius:10px;background:#fff}\ninput:focus,select:focus,textarea:focus{outline:2px solid var(--gold2);border-color:var(--gold)}textarea{width:100%}\n.row{display:flex;gap:8px;flex-wrap:wrap;align-items:center;margin-bottom:12px}\n.tag{display:inline-block;padding:2px 10px;border-radius:99px;font-size:12px;font-weight:500;background:#EDF0F6;color:#3A4663;white-space:nowrap}\n.tag.red{background:var(--redsoft);color:var(--red);font-weight:600}.tag.blu{background:#E8EEF9;color:var(--navy7)}.tag.grn{background:var(--greensoft);color:var(--green)}.tag.amb{background:var(--goldsoft);color:#8A5A00}\n.lead{display:grid;grid-template-columns:1fr auto;gap:10px;align-items:center}\n.chips{gap:6px}.chip{border:1px solid var(--line);background:var(--card);color:var(--navy8);font:inherit;padding:5px 12px;border-radius:99px;cursor:pointer}.chip.on{background:var(--navy8);color:#fff;border-color:var(--navy8)}.chip .n{opacity:.7;margin-left:4px}.meta{display:flex;flex-wrap:wrap;gap:4px 16px;color:var(--ink)}.note{margin-top:4px;color:var(--mut)}\n.zl{display:inline-block;margin-left:6px;padding:1px 9px;border-radius:99px;background:#E8F1FF;color:var(--blue);font-size:12px;font-weight:600;text-decoration:none;vertical-align:middle}.zl.on{background:var(--blue);color:#fff}.zl:hover{filter:brightness(.95)}\n.step{color:var(--navy7);font-weight:600;margin-top:4px}.assign{margin-top:6px}.assign select{max-width:220px}\n.lead.todo{border-left:4px solid var(--red)}\n.lead h3{margin:0;font-size:15.5px;font-weight:650;color:var(--navy9)}.acts{display:flex;gap:6px;flex-wrap:wrap}\ntable{width:100%;border-collapse:collapse}th,td{text-align:left;padding:9px 8px;border-bottom:1px solid var(--line);vertical-align:top}\nth{color:var(--navy8);font-size:12px;font-weight:650;letter-spacing:.3px;border-bottom:2px solid var(--gold);white-space:nowrap}tr:hover td{background:#FAFBFE}.tw{overflow-x:auto}\ndialog{border:0;border-radius:18px;padding:0;background:#fff;color:var(--ink);width:min(640px,96vw);max-height:92vh;box-shadow:0 30px 80px rgba(11,31,61,.45)}\ndialog::backdrop{background:rgba(11,31,61,.55);backdrop-filter:blur(3px)}.dlg{padding:18px}.dlg h2{color:var(--navy9)}.tl{list-style:none;margin:0;padding:0}.tl li{padding:6px 0;border-bottom:1px dashed var(--line)}\ncode,pre{background:#F3F5FA;border:1px solid var(--line);border-radius:10px;font-size:12px;color:var(--ink)}pre{padding:10px;overflow:auto;white-space:pre-wrap;word-break:break-all;margin:6px 0}\n#toast{position:fixed;left:50%;bottom:24px;transform:translateX(-50%);background:var(--navy9);border:1px solid rgba(255,255,255,.2);color:#fff;padding:9px 16px;border-radius:12px;display:none;z-index:20;box-shadow:0 10px 30px rgba(11,31,61,.4)}\n#diag{color:var(--red);padding:8px 16px;position:relative;z-index:2}\n.waves{position:absolute;left:0;right:0;bottom:0;height:70px;background:url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 24' fill='none' stroke='rgba(11,31,61,.55)' stroke-width='1.3' stroke-linecap='round'%3E%3Cpath d='M0 12 q25 -8 50 0 t50 0 q25 -8 50 0 t50 0 q25 -8 50 0 t50 0 q25 -8 50 0 t50 0'/%3E%3C/svg%3E\") 0 4px/400px 24px repeat-x,url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 24' fill='none' stroke='rgba(217,164,65,.7)' stroke-width='1.1' stroke-linecap='round'%3E%3Cpath d='M0 12 q25 -6 50 0 t50 0 q25 -6 50 0 t50 0 q25 -6 50 0 t50 0 q25 -6 50 0 t50 0'/%3E%3C/svg%3E\") 0 22px/320px 24px repeat-x,url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 24' fill='none' stroke='rgba(11,31,61,.45)' stroke-width='1.2' stroke-linecap='round'%3E%3Cpath d='M0 12 q25 -9 50 0 t50 0 q25 -9 50 0 t50 0 q25 -9 50 0 t50 0 q25 -9 50 0 t50 0'/%3E%3C/svg%3E\") 0 40px/480px 24px repeat-x;opacity:.16;animation:flow2 22s linear infinite}\n.gbar{position:relative;z-index:1;display:flex;gap:8px;padding:10px 16px 0;max-width:1180px;margin:0 auto;flex-wrap:wrap}\n.gbar button{border:1px solid var(--line);background:var(--card);color:var(--navy8);font:inherit;font-weight:600;padding:6px 16px;border-radius:99px;cursor:pointer;transition:background .2s,color .2s,border-color .2s}\n.gbar button:hover{border-color:var(--gold)}\n.gbar button.on{background:var(--navy8);color:#fff;border-color:var(--navy8)}\n.gbar .n{font-weight:500;opacity:.75;margin-left:6px}\n</style>\n</head>\n<body>\n<div class=\"fx\" aria-hidden=\"true\"><div class=\"skyline\"></div><div class=\"waves\"></div></div>\n<header>\n  <h1><svg class=\"logo\" viewBox=\"0 0 48 32\" width=\"34\" height=\"22\" fill=\"none\" stroke=\"#E2B35A\" stroke-width=\"2.4\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M2 26 C10 6 18 6 24 20 C30 34 38 34 44 14\"/><path d=\"M2 28 H46\"/><path d=\"M44 14 l4 -6 l-1 8Z\" fill=\"#E2B35A\"/></svg>CRM Hoàng Hiệp</h1><span class=\"sp\"></span>\n  <span class=\"mut small\" id=\"who\"></span>\n  <button class=\"btn\" id=\"reload\">Tải lại</button>\n  <nav id=\"nav\">\n    <button data-t=\"home\" class=\"on\">Tổng quan</button>\n    <button data-t=\"leads\">Khách hàng<span class=\"dot\" id=\"dLeads\" hidden></span></button>\n    <button data-t=\"clicks\">Lượt bấm<span class=\"dot\" id=\"dClicks\" hidden></span></button>\n    <button data-t=\"ask\">Hỏi quân sư</button>\n    <button data-t=\"camp\">Chiến dịch</button>\n    <button data-t=\"sites\">Website & mã nhúng</button>\n  </nav>\n</header>\n<div class=\"skyline\" aria-hidden=\"true\"></div>\n<div class=\"gbar\" id=\"gbar\"></div>\n<div id=\"diag\"></div>\n<main id=\"main\"><p class=\"mut\">Đang tải…</p></main>\n<dialog id=\"dlg\"><div class=\"dlg\" id=\"dlgBody\"></div></dialog>\n<div id=\"toast\"></div>\n\n<script>\nwindow.onerror = function (m, s, l) { var d = document.getElementById('diag'); if (d) d.textContent = 'Lỗi trang: ' + m + (l ? ' (dòng ' + l + ')' : ''); };\nvar KEY = /*__KEY__*/'', D = null, tab = 'home', F = { status: 'todo', site: '', q: '', clicks: 'todo', src: '', as: '', sort: 'new' }, G = '';\ntry { G = localStorage.getItem('crm_group') || ''; } catch (e) {}\nvar STATUS = ['Mới', 'Đã liên hệ', 'Quan tâm', 'Hẹn xem', 'Chốt', 'Mất'];\nvar CH = { zalo: 'Zalo', phone: 'Gọi điện', messenger: 'Messenger', sms: 'SMS', other: 'Khác' };\nfunction $(s, r) { return (r || document).querySelector(s); }\nfunction esc(v) { return String(v == null ? '' : v).replace(/[&<>\"']/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '\"': '&quot;', \"'\": '&#39;' }[c]; }); }\nfunction run(fn) {\n  var a = Array.prototype.slice.call(arguments, 1);\n  return new Promise(function (ok, ko) {\n    var r = google.script.run.withSuccessHandler(ok).withFailureHandler(function (e) { ko(new Error(e && e.message ? e.message : String(e))); });\n    r[fn].apply(r, [KEY].concat(a));\n  });\n}\nfunction toast(m) { var t = $('#toast'); t.textContent = m; t.style.display = 'block'; clearTimeout(toast.t); toast.t = setTimeout(function () { t.style.display = 'none'; }, 2800); }\nfunction fail(e) { toast('Lỗi: ' + e.message); }\nfunction fmt(iso) { if (!iso) return ''; var d = new Date(iso); return d.toLocaleString('vi-VN', { hour12: false, day: '2-digit', month: '2-digit', hour: '2-digit', minute: '2-digit' }); }\nfunction ago(iso) { var m = Math.round((Date.now() - new Date(iso).getTime()) / 60000); return m < 1 ? 'vừa xong' : m < 60 ? m + ' phút trước' : m < 1440 ? Math.round(m / 60) + ' giờ trước' : Math.round(m / 1440) + ' ngày trước'; }\nfunction vnd(n) { return Math.round(n || 0).toLocaleString('vi-VN') + 'đ'; }\nvar todo = function (l) { return !l.called && !l.messaged && l.status === 'Mới'; };\nvar GROUPS = ['BĐS', 'Vân'];\nfunction gOf(name) { var s = D && D.sites.filter(function (x) { return x.name === name; })[0]; return s ? String(s.group || '') : ''; }\nfunction inG(name) { return !G || gOf(name) === G; }\nfunction num(v) { return Number(String(v).replace(/[^\\d]/g, '')) || 0; }\nfunction gbar() {\n  if (!D) return;\n  var n = {}, all = D.leads.filter(todo).length;\n  GROUPS.forEach(function (g) { n[g] = D.leads.filter(function (l) { return todo(l) && gOf(l.site) === g; }).length; });\n  $('#gbar').innerHTML = [''].concat(GROUPS).map(function (g) {\n    var k = g ? n[g] : all;\n    return '<button data-g=\"' + esc(g) + '\" class=\"' + (G === g ? 'on' : '') + '\">' + (g || 'Tất cả') + (k ? '<span class=\"n\">' + k + ' chưa liên hệ</span>' : '') + '</button>';\n  }).join('');\n}\n\nfunction ensureKey() {\n  if (KEY) return Promise.resolve();\n  return new Promise(function (ok) { google.script.run.withSuccessHandler(function (k) { KEY = k || ''; ok(); }).withFailureHandler(function () { ok(); }).crmDialogKey(); });\n}\nfunction load() {\n  return ensureKey().then(function () { return run('crmLoad'); }).then(function (d) { D = d; $('#who').textContent = d.user; badges(); render(); }).catch(function (e) { $('#main').innerHTML = '<div class=\"card\">Không tải được dữ liệu: ' + esc(e.message) + '<br><span class=\"mut\">[khoá: ' + (KEY ? 'có' : 'trống') + '] Nếu khoá trống: dán lại cả Mã.gs và Crm.html mới nhất rồi mở menu CRM → Mở giao diện CRM. Mở bằng link web thì dùng menu CRM → Link vào CRM.</span></div>'; });\n}\nfunction badges() {\n  gbar();\n  var a = D.leads.filter(function (l) { return todo(l) && isBds(l.site); }).length, b = D.clicks.filter(function (c) { return c.alert && inG(c.site); }).length;\n  $('#dLeads').textContent = a; $('#dLeads').hidden = !a; $('#dClicks').textContent = b; $('#dClicks').hidden = !b;\n}\n$('#nav').onclick = function (e) { var t = e.target.dataset.t; if (!t) return; tab = t; document.querySelectorAll('#nav button').forEach(function (b) { b.classList.toggle('on', b.dataset.t === t); }); render(); };\n$('#reload').onclick = load;\ndocument.addEventListener('click', function (e) { var a = e.target.closest && e.target.closest('[data-zl]'); if (!a) return; e.preventDefault(); window.open('https://zalo.me/' + a.dataset.zl, '_blank', 'noopener'); });\n$('#gbar').onclick = function (e) { var b = e.target.closest('button'); if (!b) return; G = b.dataset.g; try { localStorage.setItem('crm_group', G); } catch (x) {} badges(); render(); };\n\nfunction render() { if (!D) return; $('#gbar').style.display = tab === 'leads' ? 'none' : ''; ({ home: home, leads: leads, clicks: clicks, ask: ask, camp: camp, sites: sites }[tab])(); }\n\nfunction home() {\n  if (G) return homeGroup();\n  var k = D.kpis.slice(1).map(function (r, i) { var red = (i === 0 || i === 8) && Number(String(r[1]).replace(/\\D/g, '')) > 0; return '<div class=\"kpi ' + (red ? 'alert' : '') + '\"><b>' + esc(r[1]) + '</b><span>' + esc(r[0]) + '</span></div>'; }).join('');\n  var st = D.siteStats, rows = st.slice(1).map(function (r) { return '<tr>' + r.map(function (c, i) { return '<td>' + (i === 0 ? '<b>' + esc(c) + '</b>' : esc(c)) + '</td>'; }).join('') + '</tr>'; }).join('');\n  $('#main').innerHTML = '<p class=\"mut small\">Khoảng thời gian chỉnh ở ô \"Số ngày gần đây\" trong tab Tổng quan của file Sheet.</p><div class=\"grid\">' + k + '</div>' +\n    '<div class=\"card tw\"><b>Theo website</b><table><tr>' + st[0].map(function (h) { return '<th>' + esc(h) + '</th>'; }).join('') + '</tr>' + (rows || '<tr><td class=\"mut\">Chưa có dữ liệu</td></tr>') + '</table></div>';\n}\n\nfunction homeGroup() {\n  var st = D.siteStats, rows = st.slice(1).filter(function (r) { return inG(r[0]); });\n  var sum = function (i) { return rows.reduce(function (a, r) { return a + num(r[i]); }, 0); };\n  var todoN = D.leads.filter(function (l) { return todo(l) && inG(l.site); }).length;\n  var clickTodo = D.clicks.filter(function (c) { return c.alert && inG(c.site); }).length;\n  var cards = [[todoN, 'Khách chưa gọi, chưa nhắn', 1], [sum(5), 'Khách để lại SĐT trong kỳ', 0], [sum(1), 'Người truy cập', 0], [sum(2), 'Lượt bấm Zalo', 0], [sum(3), 'Lượt bấm Gọi điện', 0], [sum(4), 'Lượt bấm Messenger', 0], [clickTodo, 'Lượt bấm chưa xử lý', 1]];\n  var k = cards.map(function (x) { return '<div class=\"kpi ' + (x[2] && x[0] > 0 ? 'alert' : '') + '\"><b>' + x[0] + '</b><span>' + esc(x[1]) + '</span></div>'; }).join('');\n  var body = rows.map(function (r) { return '<tr>' + r.map(function (c, i) { return '<td>' + (i === 0 ? '<b>' + esc(c) + '</b>' : esc(c)) + '</td>'; }).join('') + '</tr>'; }).join('');\n  $('#main').innerHTML = '<p class=\"mut small\">Nhóm ' + esc(G) + ': khoảng thời gian chỉnh ở ô \"Số ngày gần đây\" trong tab Tổng quan của file Sheet.</p><div class=\"grid\">' + k + '</div>' +\n    '<div class=\"card tw\"><b>Theo website (' + esc(G) + ')</b><table><tr>' + st[0].map(function (h) { return '<th>' + esc(h) + '</th>'; }).join('') + '</tr>' + (body || '<tr><td class=\"mut\">Chưa có website trong nhóm này. Điền cột E (Nhóm) ở tab Website.</td></tr>') + '</table></div>';\n}\n\nfunction saleNames(extra) { var a = (D.sales || []).slice(); (extra || []).forEach(function (s) { if (a.indexOf(s) < 0) a.push(s); }); return a; }\nfunction nextStep(l) {\n  if (todo(l)) return 'Việc cần làm: gọi hoặc nhắn Zalo cho khách ngay.';\n  if (!l.assignee && l.status !== 'Chốt' && l.status !== 'Mất') return 'Việc cần làm: chọn sale phụ trách cho khách này.';\n  if (l.status === 'Đã liên hệ') return 'Việc cần làm: hỏi nhu cầu, rồi đổi trạng thái sang Quan tâm hoặc Mất.';\n  if (l.status === 'Quan tâm') return 'Việc cần làm: hẹn khách đi xem nhà.';\n  if (l.status === 'Hẹn xem') return 'Việc cần làm: nhắc lịch hẹn, sau buổi xem cập nhật Chốt hoặc Mất.';\n  return '';\n}\nfunction heat(l) {\n  if (l.status === 'Chốt' || l.status === 'Mất') return null;\n  var age = mins(l.at, new Date().toISOString()) / 1440;\n  var s = (l.zaloClicks || 0) * 2 + (l.phoneClicks || 0) * 2 + Math.max(0, (l.submits || 1) - 1) * 2 + (age < 1 ? 2 : age < 3 ? 1 : 0) + (l.status === 'Quan tâm' || l.status === 'Hẹn xem' ? 3 : 0);\n  return s >= 6 ? ['Nóng', 'red'] : s >= 3 ? ['Ấm', 'amb'] : ['Nguội', ''];\n}\nfunction copyText(s) {\n  var ta = document.createElement('textarea'); ta.value = s; document.body.appendChild(ta); ta.select();\n  try { document.execCommand('copy'); toast('Đã sao chép'); } catch (e) { toast('Không sao chép được, hãy bôi đen và copy'); } document.body.removeChild(ta);\n}\nfunction advisor(phone) {\n  var l = D.leads.filter(function (x) { return x.phone === phone; })[0]; if (!l) return;\n  var ten = !l.name ? 'anh/chị' : /^(anh|chị|chi|cô|co|chú|chu|bác|bac|ông|ong|bà|ba)(\\s|$)/i.test(l.name.trim()) ? l.name.trim() : 'anh/chị ' + l.name.trim(), me = l.assignee || 'tư vấn viên', h = heat(l);\n  var when = todo(l) ? 'Liên hệ ngay, trong 5 đến 15 phút. Khách mới để lại số rất dễ nguội.' :\n    l.status === 'Đã liên hệ' ? 'Nhắn lại sau 1 ngày nếu khách chưa trả lời, rồi thêm 1 lần sau 3 ngày.' :\n    l.status === 'Quan tâm' ? 'Chăm lại sau 2 đến 3 ngày: gửi bảng giá, hình ảnh, chính sách mới.' :\n    l.status === 'Hẹn xem' ? 'Nhắc lịch hẹn trước 1 ngày và sáng hôm hẹn.' : 'Không cần chăm thêm.';\n  var why = [];\n  if (l.zaloClicks) why.push('đã bấm Zalo ' + l.zaloClicks + ' lần'); if (l.phoneClicks) why.push('đã bấm Gọi ' + l.phoneClicks + ' lần'); if (l.submits > 1) why.push('gửi form ' + l.submits + ' lần');\n  var msgs = [\n    ['Tin nhắn đầu tiên (Zalo)', 'Chào ' + ten + ', em là ' + me + ' bên dự án ' + l.site + '. Em thấy ' + ten + ' vừa để lại thông tin quan tâm dự án. ' + 'Anh/chị đang quan tâm loại căn mấy phòng ngủ, và dự kiến ngân sách khoảng bao nhiêu để em gửi đúng bảng giá ạ?'],\n    ['Nhắn lại khi khách chưa trả lời', 'Dạ em nhắn lại ' + ten + ' một chút ạ. Dự án ' + l.site + ' đang có thông tin mới về giá và chính sách, em gửi anh/chị xem thử nhé. Anh/chị tiện nghe máy lúc nào để em gọi tư vấn nhanh 5 phút ạ?'],\n    ['Mời đi xem', 'Dạ em mời ' + ten + ' sắp xếp đi xem thực tế dự án ' + l.site + ' để thấy rõ vị trí và căn hộ. Tuần này ' + ten + ' tiện ngày nào, buổi sáng hay chiều ạ, em đặt lịch và đón anh/chị.']\n  ];\n  var q = ['Anh/chị mua để ở hay đầu tư?', 'Ngân sách dự kiến và hình thức thanh toán (vay hay tiền mặt)?', 'Cần căn mấy phòng ngủ, hướng, tầng?', 'Bao giờ anh/chị có thể đi xem dự án?', 'Anh/chị còn đang xem dự án nào khác không?'];\n  $('#dlgBody').innerHTML = '<h2 style=\"margin:0\">Quân sư · ' + esc(l.name || '(chưa có tên)') + ' · ' + esc(l.phone) + ' ' + zl(l.phone, l) + '</h2>' +\n    '<p class=\"small mut\">' + esc(l.site) + (h ? ' · mức độ <span class=\"tag ' + h[1] + '\">' + h[0] + '</span>' : '') + (why.length ? ' · ' + esc(why.join(', ')) : '') + '</p>' +\n    '<div class=\"card\"><b>Nên làm lúc nào</b><div>' + esc(when) + '</div></div>' +\n    msgs.map(function (m, i) { return '<div class=\"card\"><b>' + m[0] + '</b><div class=\"small\" style=\"margin:6px 0;white-space:pre-wrap\">' + esc(m[1]) + '</div><button class=\"btn\" data-m=\"' + i + '\">Sao chép tin nhắn</button></div>'; }).join('') +\n    '<div class=\"card\"><b>Câu hỏi khi gọi điện</b><ul class=\"small\">' + q.map(function (x) { return '<li>' + esc(x) + '</li>'; }).join('') + '</ul></div>' +\n    '<div class=\"row\"><button class=\"btn z\" id=\"aZ\">Mở Zalo</button><button class=\"btn g\" id=\"aC\">Gọi</button><button class=\"btn\" id=\"aX\">Đóng</button></div>';\n  $('#dlg').showModal();\n  document.querySelectorAll('#dlgBody [data-m]').forEach(function (b) { b.onclick = function () { copyText(msgs[b.dataset.m][1]); }; });\n  $('#aZ').onclick = function () { window.open('https://zalo.me/' + phone, '_blank', 'noopener'); };\n  $('#aC').onclick = function () { window.open('tel:' + phone, '_self'); };\n  $('#aX').onclick = function () { $('#dlg').close(); };\n}\nfunction zl(phone, l) {\n  var hot = l && l.zaloClicks > 0;\n  return '<a href=\"#\" class=\"zl' + (hot ? ' on' : '') + '\" data-zl=\"' + esc(phone) + '\" title=\"' + (hot ? 'Khách đã bấm Zalo trên website' : 'Mở chat Zalo với số này') + '\">Zalo' + (hot ? ' ✓' : '') + '</a>';\n}\nfunction isBds(name) { var g = gOf(name); return !g || g === 'BĐS'; }\nfunction mins(a, b) { return Math.round((new Date(b).getTime() - new Date(a).getTime()) / 60000); }\nfunction dur(m) { return m < 1 ? 'dưới 1 phút' : m < 60 ? m + ' phút' : m < 1440 ? Math.round(m / 60 * 10) / 10 + ' giờ' : Math.round(m / 1440 * 10) / 10 + ' ngày'; }\nfunction leads() {\n  var all = D.leads.filter(function (l) { return isBds(l.site); });\n  var sites = D.sites.filter(function (s) { return isBds(s.name); }).map(function (s) { return s.name; });\n  var srcs = [], ass = [];\n  all.forEach(function (l) { if (l.source && srcs.indexOf(l.source) < 0) srcs.push(l.source); if (l.assignee && ass.indexOf(l.assignee) < 0) ass.push(l.assignee); });\n  var list = all.filter(function (l) {\n    if (F.status === 'todo' && !todo(l)) return false;\n    if (STATUS.indexOf(F.status) >= 0 && l.status !== F.status) return false;\n    if (F.site && l.site !== F.site) return false;\n    if (F.src && l.source !== F.src) return false;\n    if (F.as && (F.as === '__none' ? l.assignee : l.assignee !== F.as)) return false;\n    if (F.q) { var q = F.q.toLowerCase(); if ((l.name + ' ' + l.phone + ' ' + l.email + ' ' + l.note + ' ' + l.campaign).toLowerCase().indexOf(q) < 0) return false; }\n    return true;\n  });\n  list.sort(function (x, y) {\n    if (F.sort === 'old') return new Date(x.at) - new Date(y.at);\n    if (F.sort === 'hot') { var hx = heat(x), hy = heat(y); return (hy ? hy[0] === 'Nóng' ? 2 : hy[0] === 'Ấm' ? 1 : 0 : -1) - (hx ? hx[0] === 'Nóng' ? 2 : hx[0] === 'Ấm' ? 1 : 0 : -1); }\n    if (F.sort === 'val') return (y.value || 0) - (x.value || 0);\n    if (F.sort === 'wait') return (todo(y) - todo(x)) || (new Date(x.at) - new Date(y.at));\n    return new Date(y.at) - new Date(x.at);\n  });\n  var cnt = function (f) { return all.filter(f).length; };\n  var resp = all.filter(function (l) { return l.contactedAt; }).map(function (l) { return mins(l.at, l.contactedAt); }).filter(function (m) { return m >= 0; });\n  var avg = resp.length ? Math.round(resp.reduce(function (p, q) { return p + q; }, 0) / resp.length) : null;\n  var won = all.filter(function (l) { return l.status === 'Chốt'; });\n  var total = won.reduce(function (p, l) { return p + (l.value || 0); }, 0);\n  var kp = [[all.length, 'Tổng khách BĐS', 0], [cnt(todo), 'Chưa gọi, chưa nhắn', 1], [cnt(function (l) { return !todo(l); }), 'Đã liên hệ', 0],\n    [cnt(function (l) { return l.status === 'Quan tâm' || l.status === 'Hẹn xem'; }), 'Quan tâm / Hẹn xem', 0], [won.length, 'Đã chốt', 0], [total ? (total >= 1e9 ? Math.round(total / 1e8) / 10 + ' tỷ' : total >= 1e6 ? Math.round(total / 1e5) / 10 + ' triệu' : vnd(total)) : '-', 'Giá trị đã chốt', 0],\n    [avg === null ? '-' : dur(avg), 'Phản hồi trung bình', 0]];\n  var chips = [['all', 'Tất cả', all.length], ['todo', 'Chưa liên hệ', cnt(todo)]].concat(STATUS.map(function (s) { return [s, s, cnt(function (l) { return l.status === s; })]; }));\n  var opt = function (arr, first) { return '<option value=\"\">' + first + '</option>' + arr.map(function (s) { return '<option>' + esc(s) + '</option>'; }).join(''); };\n  $('#main').innerHTML = '<div class=\"grid\">' + kp.map(function (x) { return '<div class=\"kpi ' + (x[2] && x[0] > 0 ? 'alert' : '') + '\"><b>' + esc(x[0]) + '</b><span>' + x[1] + '</span></div>'; }).join('') + '</div>' +\n    '<div class=\"row chips\">' + chips.map(function (x) { return '<button class=\"chip ' + (F.status === x[0] ? 'on' : '') + '\" data-chip=\"' + esc(x[0]) + '\">' + x[1] + ' <span class=\"n\">' + x[2] + '</span></button>'; }).join('') + '</div>' +\n    '<div class=\"row\"><select id=\"fw\">' + opt(sites, 'Tất cả dự án / website') + '</select><select id=\"fo\">' + opt(srcs, 'Tất cả nguồn') + '</select>' +\n    '<select id=\"fa\"><option value=\"\">Tất cả sale</option><option value=\"__none\">Chưa giao cho sale nào</option>' + saleNames(ass).map(function (s) { return '<option>' + esc(s) + '</option>'; }).join('') + '</select><button class=\"btn\" id=\"addsale\">+ Thêm sale</button>' +\n    '<select id=\"fr\"><option value=\"new\">Mới nhất trước</option><option value=\"old\">Cũ nhất trước</option><option value=\"hot\">Khách nóng trước</option><option value=\"wait\">Chờ lâu nhất trước</option><option value=\"val\">Giá trị cao trước</option></select>' +\n    '<input id=\"fq\" placeholder=\"Tìm tên, SĐT, email, ghi chú\" value=\"' + esc(F.q) + '\"><span class=\"mut\">' + list.length + ' khách</span></div>' +\n    (list.map(function (l) { return leadCard(l); }).join('') || '<div class=\"card mut\">Không có khách nào.</div>');\n  $('#fw').value = F.site; $('#fo').value = F.src; $('#fa').value = F.as; $('#fr').value = F.sort;\n  document.querySelectorAll('[data-chip]').forEach(function (b) { b.onclick = function () { F.status = b.dataset.chip; leads(); }; });\n  $('#fw').onchange = function (e) { F.site = e.target.value; leads(); };\n  $('#fo').onchange = function (e) { F.src = e.target.value; leads(); };\n  $('#fa').onchange = function (e) { F.as = e.target.value; leads(); };\n  $('#fr').onchange = function (e) { F.sort = e.target.value; leads(); };\n  $('#fq').onkeydown = function (e) { if (e.key === 'Enter') { F.q = e.target.value; leads(); } };\n  $('#addsale').onclick = function () {\n    var n = window.prompt('Tên sale cần thêm (ví dụ: Nguyễn Văn A)'); if (!n) return;\n    run('crmAddSale', n).then(function (r) { D.sales = r; toast('Đã thêm sale'); leads(); }).catch(fail);\n  };\n  document.querySelectorAll('[data-as]').forEach(function (s) { s.onchange = function () {\n    var l = D.leads.filter(function (x) { return x.phone === s.dataset.as; })[0], v = s.value;\n    run('crmUpdateLead', s.dataset.as, { assignee: v }).then(function () { l.assignee = v; toast(v ? 'Đã chuyển cho ' + v : 'Đã bỏ giao'); leads(); }).catch(function (e) { s.value = l.assignee || ''; fail(e); }); }; });\n  document.querySelectorAll('[data-open]').forEach(function (b) { b.onclick = function () { openLead(b.dataset.open); }; });\n  document.querySelectorAll('[data-ask]').forEach(function (b) { b.onclick = function () { ASK.phone = b.dataset.ask; ASK.q = ''; ASK.a = ''; tab = 'ask'; document.querySelectorAll('#nav button').forEach(function (x) { x.classList.toggle('on', x.dataset.t === 'ask'); }); render(); }; });\n  document.querySelectorAll('[data-adv]').forEach(function (b) { b.onclick = function () { advisor(b.dataset.adv); }; });\n  document.querySelectorAll('[data-act]').forEach(function (b) { b.onclick = function () { contact(b.dataset.p, b.dataset.act, b); }; });\n}\nfunction leadCard(l) {\n  var wait = todo(l) ? mins(l.at, new Date().toISOString()) : 0;\n  var hh = heat(l), hot = hh ? '<span class=\"tag ' + hh[1] + '\">' + hh[0] + '</span> ' : '';\n  var st = hot + (todo(l) ? '<span class=\"tag red\">CHƯA LIÊN HỆ · chờ ' + dur(wait) + '</span>' : '<span class=\"tag ' + (l.status === 'Chốt' ? 'grn' : l.status === 'Mất' ? '' : 'amb') + '\">' + esc(l.status) + '</span>');\n  var t = (l.zaloClicks ? '<span class=\"tag blu\">Bấm Zalo ×' + l.zaloClicks + '</span> ' : '') + (l.phoneClicks ? '<span class=\"tag blu\">Bấm Gọi ×' + l.phoneClicks + '</span> ' : '') +\n    (l.submits > 1 ? '<span class=\"tag amb\">Gửi form ×' + l.submits + '</span> ' : '') + (l.called ? '<span class=\"tag grn\">Đã gọi</span> ' : '') + (l.messaged ? '<span class=\"tag grn\">Đã nhắn</span> ' : '');\n  var src = [l.source, l.campaign].filter(Boolean).join(' · ');\n  var d = [['Dự án', l.site], ['Nguồn / chiến dịch', src || 'Trực tiếp / chưa rõ'], ['Email', l.email], ['Nhận lúc', fmt(l.at) + ' (' + ago(l.at) + ')'],\n    ['Liên hệ lúc', l.contactedAt ? fmt(l.contactedAt) + ' (sau ' + dur(Math.max(0, mins(l.at, l.contactedAt))) + ')' : ''], ['Giá trị chốt', l.value ? vnd(l.value) : '']]\n    .filter(function (x) { return x[1]; }).map(function (x) { return '<span><span class=\"mut\">' + x[0] + ':</span> ' + esc(x[1]) + '</span>'; }).join('');\n  return '<div class=\"card lead ' + (todo(l) ? 'todo' : '') + '\"><div><h3>' + esc(l.name || '(chưa có tên)') + ' · ' + esc(l.phone) + ' ' + zl(l.phone, l) + '</h3>' +\n    '<div style=\"margin:4px 0\">' + st + ' ' + t + '</div><div class=\"meta small\">' + d + '</div>' + (nextStep(l) ? '<div class=\"small step\">' + nextStep(l) + '</div>' : '') +\n    '<div class=\"small assign\"><span class=\"mut\">Chuyển cho sale:</span> <select data-as=\"' + esc(l.phone) + '\"><option value=\"\">Chưa giao</option>' + saleNames([l.assignee].filter(Boolean)).map(function (s) { return '<option' + (s === l.assignee ? ' selected' : '') + '>' + esc(s) + '</option>'; }).join('') + '</select></div>' + (l.note ? '<div class=\"small note\">' + esc(l.note) + '</div>' : '') + '</div>' +\n    '<div class=\"acts\"><button class=\"btn z\" data-act=\"zalo\" data-p=\"' + esc(l.phone) + '\">Zalo</button><button class=\"btn g\" data-act=\"call\" data-p=\"' + esc(l.phone) + '\">Gọi</button><button class=\"btn\" data-adv=\"' + esc(l.phone) + '\">Quân sư</button><button class=\"btn\" data-ask=\"' + esc(l.phone) + '\">Hỏi AI</button><button class=\"btn\" data-open=\"' + esc(l.phone) + '\">Chi tiết</button></div></div>';\n}\nfunction contact(phone, act, btn) {\n  if (act === 'zalo') window.open('https://zalo.me/' + phone, '_blank', 'noopener'); else window.open('tel:' + phone, '_self');\n  btn.disabled = true;\n  run('crmLog', phone, act).then(function (r) {\n    var l = D.leads.filter(function (x) { return x.phone === phone; })[0];\n    if (l) { l.called = r.called; l.messaged = r.messaged; l.contactedAt = r.contactedAt; l.status = r.status; }\n    badges(); render(); toast('Đã ghi nhận ' + (act === 'call' ? 'đã gọi' : 'đã nhắn'));\n  }).catch(function (e) { btn.disabled = false; fail(e); });\n}\nfunction openLead(phone) {\n  var l = D.leads.filter(function (x) { return x.phone === phone; })[0]; if (!l) return;\n  $('#dlgBody').innerHTML = '<h2 style=\"margin:0\">' + esc(l.name || '(chưa có tên)') + ' · ' + esc(l.phone) + ' ' + zl(l.phone, l) + '</h2><p class=\"mut small\">' + esc(l.site) + ' · ' + esc(l.email) + ' · gửi form ' + l.submits + ' lần · nhận lúc ' + esc(fmt(l.at)) + '</p>' +\n    '<div class=\"row\"><button class=\"btn z\" data-a=\"zalo\">Nhắn Zalo</button><button class=\"btn g\" data-a=\"call\">Gọi</button><button class=\"btn\" data-a=\"sms\">Đã nhắn SMS</button></div>' +\n    '<div class=\"row\"><input id=\"nm\" placeholder=\"Tên\" value=\"' + esc(l.name) + '\"><select id=\"st\">' + STATUS.map(function (s) { return '<option' + (s === l.status ? ' selected' : '') + '>' + s + '</option>'; }).join('') + '</select>' +\n    '<input id=\"as\" placeholder=\"Người phụ trách\" value=\"' + esc(l.assignee) + '\"><input id=\"vl\" type=\"number\" min=\"0\" placeholder=\"Giá trị chốt (VNĐ)\" value=\"' + (l.value || '') + '\"></div>' +\n    '<textarea id=\"nt\" rows=\"3\" placeholder=\"Nhu cầu, ghi chú\">' + esc(l.note) + '</textarea><div class=\"row\" style=\"margin-top:8px\"><button class=\"btn p\" id=\"sv\">Lưu</button><button class=\"btn\" id=\"cl\">Đóng</button></div>' +\n    '<h3>Lịch sử truy cập</h3><ul class=\"tl\" id=\"tl\"><li class=\"mut\">Đang tải…</li></ul>';\n  $('#dlg').showModal();\n  $('#cl').onclick = function () { $('#dlg').close(); };\n  document.querySelectorAll('#dlgBody [data-a]').forEach(function (b) { b.onclick = function () {\n    var a = b.dataset.a; if (a === 'zalo') window.open('https://zalo.me/' + phone, '_blank', 'noopener'); if (a === 'call') window.open('tel:' + phone, '_self');\n    run('crmLog', phone, a).then(function (r) { l.called = r.called; l.messaged = r.messaged; l.contactedAt = r.contactedAt; l.status = r.status; badges(); toast('Đã ghi nhận'); $('#dlg').close(); render(); }).catch(fail); }; });\n  $('#sv').onclick = function () {\n    var f = { name: $('#nm').value, status: $('#st').value, assignee: $('#as').value, value: $('#vl').value, note: $('#nt').value };\n    run('crmUpdateLead', phone, f).then(function () { l.name = f.name; l.status = f.status; l.assignee = f.assignee; l.value = Number(f.value) || 0; l.note = f.note; badges(); $('#dlg').close(); render(); toast('Đã lưu'); }).catch(fail);\n  };\n  run('crmEvents', l.vid).then(function (ev) {\n    $('#tl').innerHTML = ev.map(function (e) { return '<li><span class=\"mut\">' + esc(fmt(e.at)) + '</span> ' + (e.type === 'click' ? 'Bấm <b>' + esc(CH[e.channel] || e.channel) + '</b>' : e.type === 'form' ? 'Gửi form' : 'Xem trang') + ' · <span class=\"mut small\">' + esc(e.url) + '</span></li>'; }).join('') || '<li class=\"mut\">Chưa có</li>';\n  }).catch(function () { $('#tl').innerHTML = '<li class=\"mut\">Không tải được</li>'; });\n}\n\nfunction clicks() {\n  var list = D.clicks.filter(function (c) { return inG(c.site) && (F.clicks === 'all' || c.alert); });\n  $('#main').innerHTML = '<div class=\"card small mut\">Người đã <b>bấm Zalo / Gọi / Messenger</b> trên website. Dòng đỏ là chưa để lại số điện thoại và chưa ai kiểm tra. Đối chiếu giờ bấm với tin nhắn Zalo hoặc cuộc gọi nhỡ trên điện thoại, rồi tick \"Đã kiểm tra\".</div>' +\n    '<div class=\"row\"><select id=\"fc\"><option value=\"todo\">Chưa xử lý</option><option value=\"all\">Tất cả</option></select><span class=\"mut\">' + list.length + ' lượt</span></div>' +\n    '<div class=\"card tw\"><table><tr><th>Lúc</th><th>Website</th><th>Kênh</th><th>Trang</th><th>Nguồn</th><th>SĐT</th><th>Đã kiểm tra</th></tr>' +\n    (list.map(function (c) { return '<tr><td>' + esc(fmt(c.at)) + '<br><span class=\"mut small\">' + esc(ago(c.at)) + '</span></td><td>' + esc(c.site) + '</td><td><span class=\"tag blu\">' + esc(CH[c.channel] || c.channel) + '</span></td><td class=\"small\">' + esc(c.url) + '</td><td class=\"small\">' + esc((c.source + ' ' + c.campaign).trim()) + '</td><td>' + (c.leftPhone ? '<span class=\"tag grn\">Đã để lại</span>' : '<span class=\"tag red\">Chưa</span>') + '</td><td><input type=\"checkbox\" data-ck=\"' + c.row + '\"' + (c.checked ? ' checked' : '') + '></td></tr>'; }).join('') || '<tr><td colspan=\"7\" class=\"mut\">Không có lượt nào.</td></tr>') + '</table></div>';\n  $('#fc').value = F.clicks; $('#fc').onchange = function (e) { F.clicks = e.target.value; clicks(); };\n  document.querySelectorAll('[data-ck]').forEach(function (b) { b.onchange = function () {\n    var c = D.clicks.filter(function (x) { return String(x.row) === b.dataset.ck; })[0];\n    run('crmClickDone', c.row, c.vid, b.checked).then(function () { c.checked = b.checked; c.alert = (!c.leftPhone && !c.checked) ? 'CHƯA XỬ LÝ' : ''; badges(); clicks(); }).catch(function (e) { b.checked = !b.checked; fail(e); }); }; });\n}\n\nvar ASK = { phone: '', q: '', a: '', busy: false };\nfunction ask() {\n  var bds = D.leads.filter(function (l) { return isBds(l.site); });\n  var qs = ['Soạn tin nhắn Zalo đầu tiên cho khách này', 'Khách này nên chăm sóc thế nào trong 3 ngày tới?', 'Khách chê giá cao, tôi nên trả lời sao?', 'Khách hỏi vay ngân hàng, tôi nên nói gì?', 'Soạn tin mời khách đi xem dự án'];\n  $('#main').innerHTML = '<div class=\"card\"><b>Hỏi quân sư</b><p class=\"small mut\">Chọn khách (hoặc để trống), gõ câu hỏi, quân sư soạn câu trả lời và tin nhắn cho bạn. Quân sư là trí tuệ nhân tạo, bạn đọc lại trước khi gửi cho khách.</p>' +\n    '<div class=\"row\"><select id=\"aw\"><option value=\"\">Không chọn khách cụ thể</option>' + bds.map(function (l) { return '<option value=\"' + esc(l.phone) + '\">' + esc((l.name || '(chưa có tên)') + ' · ' + l.phone + ' · ' + l.site) + '</option>'; }).join('') + '</select></div>' +\n    '<div class=\"row chips\">' + qs.map(function (x, i) { return '<button class=\"chip\" data-q=\"' + i + '\">' + esc(x) + '</button>'; }).join('') + '</div>' +\n    '<textarea id=\"aq\" rows=\"3\" placeholder=\"Gõ câu hỏi của bạn\">' + esc(ASK.q) + '</textarea><div class=\"row\" style=\"margin-top:8px\"><button class=\"btn p\" id=\"ago\">Hỏi quân sư</button><span class=\"mut small\" id=\"ast\"></span></div></div>' +\n    '<div class=\"card\" id=\"aout\" ' + (ASK.a ? '' : 'hidden') + '><b>Quân sư trả lời</b><div style=\"white-space:pre-wrap;margin:8px 0\" id=\"atext\">' + esc(ASK.a) + '</div><button class=\"btn\" id=\"acp\">Sao chép câu trả lời</button></div>';\n  $('#aw').value = ASK.phone;\n  document.querySelectorAll('[data-q]').forEach(function (b) { b.onclick = function () { $('#aq').value = qs[b.dataset.q]; }; });\n  $('#aw').onchange = function (e) { ASK.phone = e.target.value; };\n  $('#acp').onclick = function () { copyText(ASK.a); };\n  $('#ago').onclick = function () {\n    var q = $('#aq').value.trim(); if (!q || ASK.busy) return;\n    ASK.q = q; ASK.phone = $('#aw').value; ASK.busy = true; $('#ast').textContent = 'Quân sư đang nghĩ…'; $('#ago').disabled = true;\n    run('crmAsk', q, ASK.phone).then(function (a) { ASK.a = a; ASK.busy = false; ask(); }).catch(function (e) { ASK.busy = false; $('#ago').disabled = false; $('#ast').textContent = ''; fail(e); });\n  };\n}\nfunction camp() {\n  var c = D.campaigns;\n  $('#main').innerHTML = '<div class=\"card tw\"><table><tr>' + c[0].map(function (h) { return '<th>' + esc(h) + '</th>'; }).join('') + '</tr>' +\n    (c.slice(1).map(function (r) { return '<tr>' + r.map(function (x, i) { return '<td>' + (i < 3 ? '<b>' + esc(x) + '</b>' : esc(x)) + '</td>'; }).join('') + '</tr>'; }).join('') || '<tr><td class=\"mut\">Chưa có chiến dịch. Thêm ở tab Chiến dịch của file Sheet.</td></tr>') + '</table></div><p class=\"mut small\">Khai báo chiến dịch và nhập chi phí trong file Sheet (tab Chiến dịch, Chi phí).</p>';\n}\n\nfunction sites() {\n  $('#main').innerHTML = D.sites.filter(function (s) { return inG(s.name); }).map(function (s, i) { return '<div class=\"card\"><b>' + esc(s.name) + '</b> <span class=\"mut\">' + esc(s.domain) + '</span> <span class=\"tag\">mã ' + esc(s.key) + '</span>' +\n    '<pre>' + esc(s.snippet || '(dán URL ứng dụng web vào ô G2 của tab Website để tạo đoạn mã)') + '</pre>' + (s.snippet ? '<button class=\"btn\" data-cp=\"' + i + '\">Sao chép đoạn mã</button>' : '') + '</div>'; }).join('') || '<div class=\"card mut\">Chưa có website.</div>';\n  document.querySelectorAll('[data-cp]').forEach(function (b) { b.onclick = function () {\n    var s = D.sites.filter(function (s) { return inG(s.name); })[b.dataset.cp].snippet, ta = document.createElement('textarea'); ta.value = s; document.body.appendChild(ta); ta.select();\n    try { document.execCommand('copy'); toast('Đã sao chép'); } catch (e) { toast('Không sao chép được, hãy bôi đen và copy'); } document.body.removeChild(ta); }; });\n}\nif (KEY) { load(); }  // mở trong file Sheet: khoá đã được gắn sẵn\nelse { var started = false; setTimeout(function () { if (!started) { started = true; load(); } }, 3000);\n  try { google.script.url.getLocation(function (loc) { var k = ((loc && loc.parameter) || {}).k || ''; if (k.constructor === Array) k = k[0]; KEY = k; if (!started) { started = true; load(); } }); } catch (e) { if (!started) { started = true; load(); } } }\n</script>\n</body>\n</html>\n";
function crmHtml_() { return CRM_HTML || HtmlService.createHtmlOutputFromFile('Crm').getContent(); }

// Mở giao diện CRM ngay trong file Sheet (không cần bản triển khai, dùng quyền của người đang mở file).
function moGiaoDienCRM() {
  var props = PropertiesService.getScriptProperties(), key = crmKey_();
  if (key.length < 20) { key = Utilities.getUuid().replace(/-/g, ''); props.setProperty('CRM_KEY', key); }
  // gắn khoá vào giao diện (chịu được cả bản Crm.html cũ chưa có dấu /*__KEY__*/)
  var html = crmHtml_()
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
