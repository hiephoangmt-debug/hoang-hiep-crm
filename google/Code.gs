/**
 * CRM Hoàng Hiệp – bản Google Sheets.
 * Dán toàn bộ file này vào Extensions > Apps Script của file "CRM Hoàng Hiệp", rồi Deploy > Web app.
 * File này được sinh từ google/Code.template.gs bằng `node google/build.mjs` – đừng sửa tay trong Code.gs.
 */
var S_LEADS = 'Khách hàng', S_EVENTS = 'Hoạt động', S_SITES = 'Website', S_CLICKS = 'Lượt bấm';
var STATUS_NEW = 'Mới', STATUS_CONTACTED = 'Đã liên hệ';
var TRACK_JS = "/*! CRM Hoàng Hiệp – mã theo dõi. Nhúng vào mọi website/landing page:\n    <script src=\"https://CRM_CUA_BAN/track.js\" data-key=\"SITE_KEY\" async></script>\n  Tự động: ghi lượt xem, click Zalo / Gọi điện / Messenger / SMS, và gửi form có ô số điện thoại về CRM.\n  Nút bấm đặc biệt (không phải link): thêm thuộc tính data-crm-click=\"zalo|phone|messenger|sms\".\n  Gửi khách thủ công: window.crmLead({name, phone, email, message}) */\n(function () {\n  var el = document.currentScript || document.querySelector('script[data-key][src*=\"track.js\"]');\n  if (!el) return;\n  var key = el.getAttribute('data-key');\n  if (!key) return;\n  var base = new URL(el.src).origin;\n  var gas = /script\\.google(usercontent)?\\.com/.test(el.src); // chạy bằng Google Apps Script\n  var endpoint = gas ? el.src.split('?')[0] : null;\n  var W = window, D = document;\n\n  function store(k, v) { try { if (v === undefined) return localStorage.getItem(k); localStorage.setItem(k, v); } catch (e) { return null; } }\n  var vid = store('crm_vid');\n  if (!vid) { vid = (W.crypto && crypto.randomUUID ? crypto.randomUUID() : String(Date.now()) + Math.random().toString(16).slice(2)); store('crm_vid', vid); }\n\n  // UTM: giữ nguồn đầu tiên (first-touch), không bị ghi đè khi khách quay lại\n  var q = new URLSearchParams(location.search), utm = {};\n  // Link quảng cáo có thể mang hai bộ utm (một trong URL đích, một từ Hậu tố URL của Google Ads). Lấy giá trị cuối cùng: hậu tố luôn nằm sau.\n  ['utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term'].forEach(function (k) { var a = q.getAll(k); if (a.length && a[a.length - 1]) utm[k] = a[a.length - 1]; });\n  if (!utm.utm_source && q.get('gclid')) { utm.utm_source = 'google'; utm.utm_medium = 'cpc'; }\n  if (!utm.utm_source && q.get('fbclid')) { utm.utm_source = 'facebook'; utm.utm_medium = 'paid'; }\n  try {\n    var saved = JSON.parse(store('crm_utm') || 'null');\n    if (!saved || !saved.utm_source) { if (utm.utm_source || document.referrer) store('crm_utm', JSON.stringify({ utm: utm, ref: document.referrer })); saved = { utm: utm, ref: document.referrer }; }\n    utm = Object.keys(utm).length ? utm : saved.utm || {};\n    var firstRef = saved.ref || document.referrer;\n  } catch (e) { var firstRef = document.referrer; }\n\n  function payload(extra) {\n    var o = { key: key, vid: vid, url: location.href, referrer: firstRef || document.referrer };\n    for (var k in utm) o[k] = utm[k];\n    for (var j in extra) o[j] = extra[j];\n    return JSON.stringify(o);\n  }\n  function post(path, extra) {\n    extra = extra || {};\n    if (gas) extra.action = path === '/api/lead' ? 'lead' : 'track';\n    var body = payload(extra), url = gas ? endpoint : base + path;\n    try { if (navigator.sendBeacon && navigator.sendBeacon(url, new Blob([body], { type: 'text/plain' }))) return; } catch (e) {}\n    try { fetch(url, { method: 'POST', body: body, keepalive: true, mode: gas ? 'no-cors' : 'cors', headers: { 'Content-Type': 'text/plain' } }); } catch (e) {}\n  }\n\n  post('/api/track', { type: 'pageview' });\n\n  function channelOf(a) {\n    var forced = a.getAttribute && a.getAttribute('data-crm-click');\n    if (forced) return forced;\n    var h = (a.getAttribute && a.getAttribute('href') || '').toLowerCase();\n    if (/^tel:/.test(h)) return 'phone';\n    if (/^sms:/.test(h)) return 'sms';\n    if (/(^|\\/\\/|\\.)zalo\\.me|zaloapp\\.com|chat\\.zalo\\.me/.test(h)) return 'zalo';\n    if (/(^|\\/\\/)m\\.me\\/|messenger\\.com|fb\\.com\\/msg|facebook\\.com\\/messages/.test(h)) return 'messenger';\n    return null;\n  }\n  var lastClick = {};\n  D.addEventListener('click', function (e) {\n    var n = e.target;\n    while (n && n !== D) {\n      if (n.nodeType === 1 && (n.hasAttribute('data-crm-click') || n.tagName === 'A')) {\n        var ch = channelOf(n);\n        if (ch) {\n          var t = Date.now();\n          if (!lastClick[ch] || t - lastClick[ch] > 1500) { lastClick[ch] = t; post('/api/track', { type: 'click', channel: ch }); }\n          return;\n        }\n      }\n      n = n.parentNode;\n    }\n  }, true);\n\n  // Form: tự bắt form có ô số điện thoại\n  var sent = {};\n  function sendLead(d) {\n    if (!d.phone) return;\n    var digits = String(d.phone).replace(/\\D/g, '');\n    if (digits.length < 9 || (sent[digits] && Date.now() - sent[digits] < 5000)) return;\n    sent[digits] = Date.now();\n    post('/api/lead', d);\n  }\n  D.addEventListener('submit', function (e) {\n    var f = e.target; if (!f || !f.querySelectorAll) return;\n    var d = {};\n    f.querySelectorAll('input,textarea,select').forEach(function (i) {\n      var s = ((i.name || '') + ' ' + (i.id || '') + ' ' + (i.getAttribute('placeholder') || '')).toLowerCase();\n      if (i.type === 'password' || i.type === 'hidden' && !/phone|tel/.test(s)) return;\n      if (!d.phone && (i.type === 'tel' || /phone|sdt|sđt|tel|dien.?thoai|điện.?thoại|số/.test(s))) d.phone = i.value;\n      else if (!d.email && (i.type === 'email' || /mail/.test(s))) d.email = i.value;\n      else if (!d.name && /name|ten|tên|họ/.test(s)) d.name = i.value;\n      else if (!d.message && (i.tagName === 'TEXTAREA' || /note|message|noi.?dung|nội.?dung|ghi.?chú|loi.?nhan/.test(s))) d.message = i.value;\n    });\n    sendLead(d);\n  }, true);\n\n  W.crmLead = sendLead;\n})();\n";

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
  var o = { version: 'ui-37', hasKey: crmKey_().length >= 20, canOpenSheet: false, hasCrmHtml: false };
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

// ---- Cột mở rộng của tab Khách hàng (W..AB): hẹn tiếp theo, ngân sách, mục đích, loại căn, tiềm năng, vay ----
var LEAD_COLS = 45;
var LEAD_HEAD2 = ['SĐT phụ', 'Zalo', 'Tỉnh/thành phố', 'Ngày sinh', 'Nghề nghiệp', 'Ngân sách tối thiểu', 'Ngân sách tối đa', 'Vốn tự có', 'Khoản vay dự kiến', 'Thời điểm dự kiến mua', 'Lý do chưa quyết định', 'Loại nguồn', 'Trang phát sinh lead', 'Dự án quan tâm', 'Quận/huyện, phường/xã', 'Địa chỉ chi tiết', 'Link tài liệu (Drive)'];
function ensureLeadCols_(sh) {
  try {
    var mc = sh.getMaxColumns();
    if (mc < LEAD_COLS) sh.insertColumnsAfter(mc, LEAD_COLS - mc);
    if (!sh.getRange(1, 23).getValue()) {
      sh.getRange(1, 23, 1, 6).setValues([['Hẹn tiếp theo', 'Ngân sách', 'Mục đích mua', 'Loại căn quan tâm', 'Tiềm năng (tự đánh giá)', 'Vay ngân hàng']]);
      sh.getRange(2, 23, Math.max(sh.getMaxRows() - 1, 1), 1).setNumberFormat('@');
    }
    if (sh.getRange(1, 29).getValue() && !sh.getRange(1, 45).getValue()) sh.getRange(1, 45).setValue('Link tài liệu (Drive)');
    if (sh.getRange(1, 29).getValue() && !sh.getRange(1, 42).getValue()) sh.getRange(1, 42, 1, 3).setValues([['Dự án quan tâm', 'Quận/huyện, phường/xã', 'Địa chỉ chi tiết']]);
    if (!sh.getRange(1, 29).getValue()) {
      sh.getRange(1, 29, 1, LEAD_HEAD2.length).setValues([LEAD_HEAD2]);
      sh.getRange(2, 29, Math.max(sh.getMaxRows() - 1, 1), 16).setNumberFormat('@');
    }
  } catch (e) {}
}
// Tab Lượt bấm: thêm cột L "Xử lý lúc" để giữ lịch sử khi một lượt bấm được đánh dấu đã kiểm tra.
function ensureClickCols_(sh) {
  try {
    var mc = sh.getMaxColumns();
    if (mc < 12) sh.insertColumnsAfter(mc, 12 - mc);
    if (!sh.getRange(1, 12).getValue()) sh.getRange(1, 12).setValue('Xử lý lúc');
  } catch (e) {}
}
function ymd_(v) {
  if (v && typeof v.getTime === 'function') return Utilities.formatDate(v, 'Asia/Ho_Chi_Minh', 'yyyy-MM-dd');
  var s = String(v == null ? '' : v).trim();
  return /^\d{4}-\d{2}-\d{2}/.test(s) ? s.slice(0, 10) : '';
}
// Lấy hoặc tạo tab phụ (Nhật ký, Chuyển giao, Xem dự án...) với dòng tiêu đề; tab cũ thiếu cột thì bổ sung.
function tab_(name, header) {
  var ss = ss_(), sh = ss.getSheetByName(name);
  if (!sh) { sh = ss.insertSheet(name); sh.getRange(1, 1, 1, header.length).setValues([header]); return sh; }
  try {
    var mc = sh.getMaxColumns();
    if (mc < header.length) sh.insertColumnsAfter(mc, header.length - mc);
    for (var i = 0; i < header.length; i++) if (!sh.getRange(1, i + 1).getValue()) sh.getRange(1, i + 1).setValue(header[i]);
  } catch (e) {}
  return sh;
}
var LOG_TYPES = ['Gọi điện', 'Nhắn Zalo', 'Gặp mặt', 'Gửi tài liệu', 'Ghi chú', 'Khác'];
var LOG_HEAD = ['Thời gian', 'SĐT', 'Tên khách', 'Người thực hiện', 'Loại', 'Nội dung', 'Kết quả', 'Hẹn tiếp theo', 'Phản hồi của khách', 'Vướng mắc', 'Tài liệu đã gửi', 'Hành động tiếp theo'];
var VIEW_HEAD = ['Ngày xem', 'SĐT', 'Tên khách', 'Dự án', 'Hình thức', 'Sản phẩm quan tâm', 'Người đi cùng', 'Nhận xét sau khi xem', 'Mức quan tâm', 'Ưu điểm', 'Vướng mắc / lý do chưa quyết định', 'Bước tiếp theo', 'Lịch chăm sóc sau xem', 'Người ghi'];
var VIEW_FORMS = ['Trực tiếp', 'Tham dự sự kiện', 'Trực tuyến'];
var MOVE_HEAD = ['Thời gian', 'SĐT', 'Tên khách', 'Từ sale', 'Sang sale', 'Trạng thái lúc chuyển', 'Lý do'];
// Tóm tắt từ lịch sử thật: số lần chăm sóc, lần gần nhất, kết quả gần nhất, dự án đã xem
function summaries_() {
  var out = { care: {}, view: {} }, ss = ss_();
  var rd = function (name, cols, fn) {
    var sh = ss.getSheetByName(name);
    if (!sh) return;
    var n = sh.getLastRow();
    if (n < 2) return;
    var from = Math.max(2, n - 2999);
    try { sh.getRange(from, 1, n - from + 1, cols).getValues().forEach(fn); } catch (e) {}
  };
  rd('Nhật ký', 7, function (r) {
    var p = normPhone_(phoneStr_(String(r[1]).replace(/^'/, ''))); if (!p) return;
    var c = out.care[p] || (out.care[p] = { n: 0, at: '', result: '' }), at = iso_(r[0]);
    c.n++; if (at >= c.at) { c.at = at; c.result = String(r[6] || ''); }
  });
  rd('Xem dự án', 4, function (r) {
    var p = normPhone_(phoneStr_(String(r[1]).replace(/^'/, ''))); if (!p) return;
    var v = out.view[p] || (out.view[p] = { n: 0, at: '', project: '' }), at = ymd_(r[0]);
    v.n++; if (at >= v.at) { v.at = at; v.project = String(r[3] || ''); }
  });
  return out;
}

// ---- API cho giao diện (google.script.run) ----
function crmLoad(k) {
  requireUi_(k);
  var ss = ss_(), out = { user: '', now: new Date().toISOString() };
  var sh = ss.getSheetByName(S_LEADS), n = lastDataRow_(sh, 2);
  ensureLeadCols_(sh);
  var rows = n > 1 ? sh.getRange(2, 1, n - 1, LEAD_COLS).getValues() : [];
  out.leads = rows.filter(function (r) { return r[3]; }).map(function (r) {
    return { id: r[0], at: iso_(r[1]), name: String(r[2] || ''), phone: phoneStr_(r[3]), email: String(r[4] || ''), site: String(r[5] || ''),
      source: String(r[6] || ''), campaign: String(r[7] || ''), vid: String(r[8] || ''), submits: Number(r[9]) || 1,
      zaloClicks: Number(r[10]) || 0, phoneClicks: Number(r[11]) || 0, called: r[14] === true, messaged: r[15] === true,
      contactedAt: iso_(r[16]), status: String(r[18] || 'Mới'), assignee: String(r[19] || ''), value: Number(r[20]) || 0, note: String(r[21] || ''),
      next: ymd_(r[22]), budget: String(r[23] || ''), purpose: String(r[24] || ''), product: String(r[25] || ''), heat: String(r[26] || ''), loan: String(r[27] || ''),
      phone2: String(r[28] || ''), zalo: String(r[29] || ''), province: String(r[30] || ''), dob: ymd_(r[31]), job: String(r[32] || ''), bmin: String(r[33] || ''), bmax: String(r[34] || ''),
      equity: String(r[35] || ''), loanAmt: String(r[36] || ''), buyTime: String(r[37] || ''), undecided: String(r[38] || ''), srcType: String(r[39] || ''), leadUrl: String(r[40] || ''), project: String(r[41] || ''), district: String(r[42] || ''), address: String(r[43] || ''), docUrl: String(r[44] || '') };
  }).reverse();
  var sm = summaries_();
  out.leads.forEach(function (l) {
    var p = normPhone_(l.phone), c = sm.care[p], v = sm.view[p];
    l.careCount = c ? c.n : 0; l.careAt = c ? c.at : ''; l.careResult = c ? c.result : '';
    l.viewCount = v ? v.n : 0; l.viewAt = v ? v.at : ''; l.viewProject = v ? v.project : '';
  });
  var cs = ss.getSheetByName(S_CLICKS), cn = cs ? lastDataRow_(cs, 1) : 1, start = Math.max(2, cn - 1499);
  if (cs) ensureClickCols_(cs);
  var crow = cn > 1 ? cs.getRange(start, 1, cn - start + 1, 12).getValues() : [];
  out.clicks = crow.map(function (r, i) {
    return { row: start + i, at: iso_(r[0]), vid: String(r[1] || ''), site: String(r[2] || ''), channel: String(r[3] || ''), url: String(r[4] || ''),
      source: String(r[5] || ''), campaign: String(r[6] || ''), leftPhone: r[7] === 'Có', checked: r[8] === true, note: String(r[9] || ''), alert: String(r[10] || ''), handledAt: iso_(r[11]) };
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

// ---- Hoa hồng, lương: kế toán gửi theo tháng, nhập tay vào tab "Hoa hồng". Chi phí marketing lấy từ tab "Chi phí".
var COMM_TYPES = ['Hoa hồng NVKD', 'Thưởng TPKD', 'Thưởng GĐKD', 'Lương', 'Thưởng khác'];
var COMM_HEAD = ['Mã', 'Tháng', 'Loại', 'Mã căn', 'Dự án', 'SĐT khách', 'Tổng giá bán', 'Mức %', 'Tổng hoa hồng', 'Đã tính đợt trước', 'Tính đợt này', 'Thực nhận', 'Thuế đã khấu trừ', 'Thuế còn lại', 'Ghi chú', 'Ngày nhập'];
function monthStr_(v) {
  if (v instanceof Date) return Utilities.formatDate(v, 'Asia/Ho_Chi_Minh', 'yyyy-MM').slice(0, 7);
  var m = /^'?(\d{4})-(\d{1,2})/.exec(String(v || '').trim());
  return m ? m[1] + '-' + ('0' + m[2]).slice(-2) : '';
}
function numIn_(v) {
  var t = String(v == null ? '' : v).replace(/[^\d.,\-]/g, '');
  if (/^-?\d{1,3}(\.\d{3})+(,\d+)?$/.test(t)) t = t.replace(/\./g, '').replace(',', '.');      // 13.670.915 hoặc 1.234,5
  else if (/^-?\d{1,3}(,\d{3})+(\.\d+)?$/.test(t)) t = t.replace(/,/g, '');                     // 13,670,915
  else t = t.replace(',', '.');
  var n = Number(t); return isFinite(n) ? Math.round(n * 100) / 100 : 0;
}
function crmCommLoad(k) {
  requireUi_(k);
  var ss = ss_(), sh = tab_('Hoa hồng', COMM_HEAD), n = lastDataRow_(sh, 2);
  var rows = n > 1 ? sh.getRange(2, 1, n - 1, COMM_HEAD.length).getValues() : [];
  var items = [];
  rows.forEach(function (r, i) {
    var mo = monthStr_(r[1]); if (!mo) return;
    items.push({ row: i + 2, id: String(r[0] || ''), month: mo, type: String(r[2] || ''), unit: String(r[3] || ''), project: String(r[4] || ''), phone: phoneStr_(r[5]),
      price: Number(r[6]) || 0, rate: Number(r[7]) || 0, total: Number(r[8]) || 0, prev: Number(r[9]) || 0, now: Number(r[10]) || 0, net: Number(r[11]) || 0,
      taxPaid: Number(r[12]) || 0, taxDue: Number(r[13]) || 0, note: String(r[14] || '') });
  });
  var mkt = {}, cp = ss.getSheetByName('Chi phí'), cn = cp ? cp.getLastRow() : 1;
  if (cn > 1) cp.getRange(2, 1, cn - 1, 3).getValues().forEach(function (r) { var d = ymd_(r[0]); if (d) mkt[d.slice(0, 7)] = (mkt[d.slice(0, 7)] || 0) + (Number(r[2]) || 0); });
  return { items: items, mkt: mkt, types: COMM_TYPES, plans: plansLoad_() };
}
function crmCommSave(k, f) {
  requireUi_(k); f = f || {};
  var mo = monthStr_(f.month); if (!mo) throw new Error('Hãy chọn tháng');
  var type = COMM_TYPES.indexOf(f.type) >= 0 ? f.type : COMM_TYPES[0];
  var phone = f.phone ? normPhone_(f.phone) : '';
  return withLock_(function () {
    var sh = tab_('Hoa hồng', COMM_HEAD), row = Number(f.row) || 0, n = lastDataRow_(sh, 2);
    var net = numIn_(f.net);
    var vals = [mo, type, str_(f.unit, 60), str_(f.project, 120), phone ? "'" + phone : '', numIn_(f.price), numIn_(f.rate), numIn_(f.total), numIn_(f.prev), numIn_(f.now), net,
      numIn_(f.taxPaid), numIn_(f.taxDue), str_(f.note, 500)];
    vals[0] = "'" + mo;
    if (row) {
      if (row < 2 || row > n) throw new Error('Không tìm thấy dòng cần sửa');
      sh.getRange(row, 2, 1, vals.length).setValues([vals]);
      return { ok: true, row: row };
    }
    var id = 'HH' + ('000' + n).slice(-3);
    sh.appendRow([id].concat(vals).concat([new Date()]));
    return { ok: true, row: n + 1, id: id };
  });
}
function crmCommDelete(k, row) {
  requireUi_(k); row = Number(row) || 0;
  return withLock_(function () {
    var sh = tab_('Hoa hồng', COMM_HEAD), n = lastDataRow_(sh, 2);
    if (row < 2 || row > n) throw new Error('Không tìm thấy dòng cần xoá');
    sh.deleteRow(row);
    return { ok: true };
  });
}

// ---- Kế hoạch marketing tháng: chạy kênh nào, ngân sách, tiền ứng trước và các mốc hỗ trợ theo số căn bán được.
var PLAN_HEAD = ['Mã', 'Tháng', 'Dự án', 'Kênh quảng cáo (JSON)', 'Ngân sách kế hoạch', 'Đã ứng trước', 'Mốc hỗ trợ (JSON)', 'Số căn đã bán (nhập tay)', 'Ghi chú', 'Ngày nhập', 'Loại kế hoạch', 'Tài liệu (JSON)'];
var PLAN_KINDS = ['Của sàn', 'Cá nhân'];
function jsonArr_(v) { try { var a = JSON.parse(String(v || '[]')); return Array.isArray(a) ? a : []; } catch (e) { return []; } }
function plansLoad_() {
  var sh = tab_('Kế hoạch MKT', PLAN_HEAD), n = lastDataRow_(sh, 2);
  var rows = n > 1 ? sh.getRange(2, 1, n - 1, PLAN_HEAD.length).getValues() : [], out = [];
  rows.forEach(function (r, i) {
    var mo = monthStr_(r[1]); if (!mo) return;
    out.push({ row: i + 2, id: String(r[0] || ''), month: mo, project: String(r[2] || ''), channels: jsonArr_(r[3]), budget: Number(r[4]) || 0, advance: Number(r[5]) || 0,
      tiers: jsonArr_(r[6]), sold: r[7] === '' || r[7] == null ? null : Number(r[7]) || 0, note: String(r[8] || ''),
      kind: PLAN_KINDS.indexOf(String(r[10] || '')) >= 0 ? String(r[10]) : 'Của sàn', docs: jsonArr_(r[11]) });
  });
  return out;
}
function crmPlanSave(k, f) {
  requireUi_(k); f = f || {};
  var mo = monthStr_(f.month); if (!mo) throw new Error('Hãy chọn tháng');
  var ch = (Array.isArray(f.channels) ? f.channels : []).slice(0, 20).map(function (c) { return { name: str_(c && c.name, 80), budget: numIn_(c && c.budget), note: str_(c && c.note, 150) }; }).filter(function (c) { return c.name || c.budget; });
  var tiers = (Array.isArray(f.tiers) ? f.tiers : []).slice(0, 10).map(function (t) {
    var from = Math.max(0, Math.round(numIn_(t && t.from))), to = t && t.to !== '' && t.to != null ? Math.max(from, Math.round(numIn_(t.to))) : '';
    return { from: from, to: to, pct: Math.min(100, Math.max(0, numIn_(t && t.pct))) };
  });
  var docs = (Array.isArray(f.docs) ? f.docs : []).slice(0, 10).map(function (d) { return { title: str_(d && d.title, 80), url: String((d && d.url) || '').trim().slice(0, 500) }; }).filter(function (d) { return /^https?:\/\//i.test(d.url); });
  var kind = PLAN_KINDS.indexOf(f.kind) >= 0 ? f.kind : PLAN_KINDS[0];
  var budget = ch.reduce(function (a, c) { return a + c.budget; }, 0) || numIn_(f.budget);
  var sold = f.sold === '' || f.sold == null ? '' : Math.max(0, Math.round(numIn_(f.sold)));
  return withLock_(function () {
    var sh = tab_('Kế hoạch MKT', PLAN_HEAD), row = Number(f.row) || 0, n = lastDataRow_(sh, 2);
    var vals = ["'" + mo, str_(f.project, 120), JSON.stringify(ch), budget, numIn_(f.advance), JSON.stringify(tiers), sold, str_(f.note, 500)];
    if (row) {
      if (row < 2 || row > n) throw new Error('Không tìm thấy dòng cần sửa');
      sh.getRange(row, 2, 1, vals.length).setValues([vals]);
      sh.getRange(row, 11, 1, 2).setValues([[kind, JSON.stringify(docs)]]);
      return { ok: true, row: row };
    }
    var id = 'KH' + ('000' + n).slice(-3);
    sh.appendRow([id].concat(vals).concat([new Date(), kind, JSON.stringify(docs)]));
    return { ok: true, row: n + 1, id: id };
  });
}
function crmPlanDelete(k, row) {
  requireUi_(k); row = Number(row) || 0;
  return withLock_(function () {
    var sh = tab_('Kế hoạch MKT', PLAN_HEAD), n = lastDataRow_(sh, 2);
    if (row < 2 || row > n) throw new Error('Không tìm thấy dòng cần xoá');
    sh.deleteRow(row);
    return { ok: true };
  });
}

// ---- Quét ưu đãi: dán thông điệp, link trang hoặc ảnh poster, AI rút tên dự án, chính sách, nhóm khách phù hợp và soạn sẵn các bản tin.
function privateHost_(u) {
  var m = /^https?:\/\/([^\/:?#]+)/i.exec(u); if (!m) return true;
  var h = m[1].toLowerCase();
  return h === 'localhost' || /^\d+\.\d+\.\d+\.\d+$/.test(h) || h.indexOf('[') === 0 || /\.(local|internal)$/.test(h) || h.indexOf('.') < 0;
}
function pageText_(u) {
  u = String(u || '').trim().slice(0, 500);
  if (!/^https?:\/\//i.test(u)) throw new Error('Link phải bắt đầu bằng http:// hoặc https://');
  if (privateHost_(u)) throw new Error('Link không hợp lệ');
  var r = UrlFetchApp.fetch(u, { muteHttpExceptions: true, followRedirects: true });
  if (r.getResponseCode() !== 200) throw new Error('Không mở được link (' + r.getResponseCode() + ')');
  var h = r.getContentText().slice(0, 400000);
  var title = (/<title[^>]*>([^<]*)<\/title>/i.exec(h) || [])[1] || '';
  var desc = (/<meta[^>]+(?:name|property)=["'](?:og:)?description["'][^>]+content=["']([^"']*)["']/i.exec(h) || [])[1] || '';
  var body = h.replace(/<(script|style|noscript)[\s\S]*?<\/\1>/gi, ' ').replace(/<[^>]+>/g, ' ').replace(/&nbsp;/g, ' ').replace(/\s+/g, ' ').trim();
  return (title + '. ' + desc + '. ' + body).slice(0, 6000);
}
function scanAi_(system, intro, text, link, img, mime, maxText) {
  text = String(text || '').trim().slice(0, maxText || 6000); link = String(link || '').trim();
  img = String(img || '').replace(/^data:[^,]*,/, ''); mime = String(mime || 'image/jpeg');
  if (!text && !link && !img) throw new Error('Hãy dán thông điệp, link hoặc chọn ảnh');
  if (img && (img.length > 4500000 || ['image/jpeg', 'image/png', 'image/webp', 'image/gif'].indexOf(mime) < 0)) throw new Error('Ảnh quá lớn hoặc sai định dạng (nhận JPG, PNG, WEBP)');
  var key = PropertiesService.getScriptProperties().getProperty('ANTHROPIC_KEY') || '';
  if (!key) throw new Error('Chưa cài khoá quân sư. Vào file Sheet, menu CRM > Cài khoá quân sư (AI), dán khoá API vào.');
  var cache = CacheService.getScriptCache(), n = Number(cache.get('ask_n') || 0);
  if (n >= 12) throw new Error('Hỏi hơi nhanh, đợi một phút rồi quét tiếp.');
  cache.put('ask_n', String(n + 1), 60);
  var page = link ? pageText_(link) : '';
  var content = [];
  if (img) content.push({ type: 'image', source: { type: 'base64', media_type: mime, data: img } });
  content.push({ type: 'text', text: intro + '\n' + (text ? '\nNội dung dán vào:\n' + text : '') + (page ? '\nNội dung trang ' + link + ':\n' + page : '') + (img ? '\n(Có kèm ảnh ở trên.)' : '') });
  var models = [SCAN_MODEL, ASK_MODEL], lastErr = '';
  for (var mi = 0; mi < models.length; mi++) {
    var res = UrlFetchApp.fetch('https://api.anthropic.com/v1/messages', {
      method: 'post', contentType: 'application/json', muteHttpExceptions: true,
      headers: { 'x-api-key': key, 'anthropic-version': '2023-06-01' },
      payload: JSON.stringify({ model: models[mi], max_tokens: maxText > 6000 ? 4000 : 1800, system: system, messages: [{ role: 'user', content: content }] })
    });
    var code = res.getResponseCode(), body = {};
    try { body = JSON.parse(res.getContentText()); } catch (e) {}
    if (code !== 200) throw new Error('Quân sư lỗi (' + code + '): ' + ((body.error && body.error.message) || 'không rõ nguyên nhân'));
    var txt = (body.content || []).map(function (b) { return b.text || ''; }).join(''), obj = firstJson_(txt);
    if (obj) return obj;
    lastErr = 'chưa đúng dạng';
  }
  throw new Error('Quân sư trả lời ' + lastErr + ', hãy thử quét lại hoặc chụp rõ hơn');
}
// Lấy đối tượng JSON đầu tiên trong câu trả lời, bỏ qua chữ thừa trước và sau; ngoặc nằm trong chuỗi không bị tính.
function firstJson_(txt) {
  var s = String(txt || ''), a = s.indexOf('{');
  while (a >= 0) {
    var depth = 0, inStr = false, esc = false;
    for (var i = a; i < s.length; i++) {
      var ch = s.charAt(i);
      if (inStr) { if (esc) esc = false; else if (ch === '\\') esc = true; else if (ch === '"') inStr = false; continue; }
      if (ch === '"') inStr = true; else if (ch === '{') depth++; else if (ch === '}' && --depth === 0) {
        try { return JSON.parse(s.slice(a, i + 1)); } catch (e) { break; }
      }
    }
    a = s.indexOf('{', a + 1);
  }
  return null;
}
function scanNum_(v) { v = parseFloat(v); return isFinite(v) && v > 0 ? v : ''; }
function crmScanOffer(k, text, link, img, mime) {
  requireUi_(k);
  var o = scanAi_('Bạn là quân sư bán hàng bất động sản tại Đà Nẵng. Đọc nguồn thông tin và chỉ trả về MỘT đối tượng JSON, không thêm chữ nào khác, theo mẫu: ' +
    '{"name":"tên dự án","highlights":"điểm nổi bật và chính sách, 1 đến 3 dòng ngắn, chỉ dùng thông tin có trong nguồn","priceFrom":số tỷ hoặc null,"priceTo":số tỷ hoặc null,"area":"khu vực hoặc tỉnh thành hoặc rỗng",' +
    '"target":"mô tả ngắn nhóm khách phù hợp nhất (ngân sách, mục đích, khu vực)","interest":"loại sản phẩm khách nên quan tâm, ví dụ căn hộ hoặc đất nền hoặc nhà phố, ngắn gọn","event":{"isEvent":true nếu nguồn nói về một sự kiện, lễ mở bán, tham quan, hội thảo, ngược lại false,"name":"tên sự kiện","when":"thời gian ghi trong nguồn","where":"địa điểm ghi trong nguồn"},"advice":["3 đến 5 ý hướng tư vấn khi gọi hoặc nhắn khách về nội dung này, gồm câu hỏi mở và cách xử lý từ chối thường gặp"],"plan":["3 đến 6 bước kế hoạch mời theo thời gian, ví dụ gửi tin mời, nhắc trước sự kiện, gọi xác nhận, chăm sóc sau sự kiện"],"messages":[{"style":"Thân mật","text":"..."},{"style":"Nhấn ưu đãi","text":"..."},{"style":"Khan hiếm","text":"..."}],"note":"điều cần kiểm tra lại hoặc thiếu"}. ' +
    'Nếu là sự kiện thì các bản tin là lời mời tham dự, nêu tên sự kiện, thời gian, địa điểm đúng như nguồn. Trong text dùng {ten} cho cách gọi khách và {sale} cho tên tư vấn viên. Tiếng Việt lịch sự, ngắn 3 đến 6 dòng, có lời kêu gọi hành động. Tuyệt đối không bịa giá, ưu đãi, thời hạn hay số căn không có trong nguồn; thiếu thì để rỗng và ghi vào note. Bản "Khan hiếm" chỉ nhấn khan hiếm nếu nguồn có nói.',
    'Nguồn thông tin về một dự án, chính sách hoặc quỹ căn mới của bên bán.', text, link, img, mime);
  return {
    event: { isEvent: !!(o.event && o.event.isEvent === true), name: str_(o.event && o.event.name, 120), when: str_(o.event && o.event.when, 120), where: str_(o.event && o.event.where, 160) },
    advice: (Array.isArray(o.advice) ? o.advice : []).slice(0, 6).map(function (x) { return str_(x, 300); }).filter(Boolean), plan: (Array.isArray(o.plan) ? o.plan : []).slice(0, 8).map(function (x) { return str_(x, 300); }).filter(Boolean),
    name: str_(o.name, 120), highlights: str_(o.highlights, 600), priceFrom: scanNum_(o.priceFrom), priceTo: scanNum_(o.priceTo), area: str_(o.area, 80), interest: str_(o.interest, 60), target: str_(o.target, 300), note: str_(o.note, 400),
    messages: (Array.isArray(o.messages) ? o.messages : []).slice(0, 4).map(function (m) { return { style: str_(m && m.style, 40), text: str_(m && m.text, 1500) }; }).filter(function (m) { return m.text; })
  };
}
// Phân tích chat Zalo của một khách từ đoạn dán hoặc ảnh chụp màn hình (Zalo cá nhân không có API chính thức để tự lấy lịch sử).
function crmScanChat(k, phone, text, img, mime) {
  requireUi_(k);
  var ctx = ''; if (phone) { try { ctx = '\nThông tin khách trong CRM: ' + leadContext_(phone); } catch (e) {} }
  var o = scanAi_('Bạn là quân sư bán hàng bất động sản. Đọc đoạn chat Zalo giữa sale và khách và chỉ trả về MỘT đối tượng JSON, không thêm chữ nào khác: ' +
    '{"summary":"tóm tắt 2 đến 3 dòng","need":"nhu cầu, ngân sách, khu vực, loại căn khách đã nói","obstacle":"vướng mắc hoặc lo ngại","heat":"Nóng hoặc Ấm hoặc Nguội","reason":"vì sao","next":"bước tiếp theo tối ưu, cụ thể","followUp":"YYYY-MM-DD nếu trong chat có hẹn ngày liên hệ lại hoặc xem nhà, không thì rỗng","reply":"khách đã phản hồi gì gần nhất","message":"tin nhắn mẫu gửi khách được ngay"}. ' +
    'Chỉ dựa trên nội dung chat và thông tin CRM, không bịa giá hay chính sách. Tiếng Việt, ngắn gọn.', 'Hôm nay là ' + ymd_(new Date()) + '. Đây là đoạn chat Zalo cần phân tích.' + ctx, text, '', img, mime);
  var s = function (v, n) { return str_(v, n); };
  var fu = ymd_(o.followUp), today = ymd_(new Date());
  return { summary: s(o.summary, 600), need: s(o.need, 400), obstacle: s(o.obstacle, 400), heat: s(o.heat, 20), reason: s(o.reason, 300), next: s(o.next, 400), reply: s(o.reply, 400), followUp: fu && fu >= today ? fu : '', message: s(o.message, 1000) };
}
// Dán nhiều cuộc chat Zalo cùng lúc (hoặc ảnh chụp danh sách chat): AI tách từng người, CRM chỉ nhận người khớp khách trong hồ sơ.
function crmScanZalo(k, text, img, mime) {
  requireUi_(k);
  var o = scanAi_('Bạn đọc nội dung copy hoặc ảnh chụp từ Zalo (có thể là nhiều cuộc trò chuyện, hoặc danh bạ chỉ có tên và ảnh đại diện) và chỉ trả về MỘT đối tượng JSON, không thêm chữ nào khác: ' +
    '{"conversations":[{"kind":"chat nếu có nội dung trò chuyện, contact nếu chỉ là một dòng danh bạ","label":"phần ghi chú người dùng đặt trong tên danh bạ, ví dụ trong ngoặc, không thì rỗng","name":"tên hiển thị của người đối thoại, không phải của sale","phone":"số điện thoại nếu thấy trong chat, không thì rỗng","summary":"tóm tắt 1 đến 2 dòng","need":"nhu cầu, ngân sách, khu vực, loại căn đã nói","obstacle":"vướng mắc hoặc lo ngại","heat":"Nóng hoặc Ấm hoặc Nguội","next":"bước tiếp theo nên làm"}]}. ' +
    'Mỗi người một mục, tối đa 40 mục với danh bạ và 15 mục với chat. Với danh bạ, name là tên đã bỏ phần ghi chú trong ngoặc và bỏ tiền tố như A, Mrs, Cvkd chỉ khi chắc đó là cách gọi, không thì giữ nguyên tên hiển thị. Chỉ dựa trên nội dung chat, không bịa; thiếu thì để rỗng. Bỏ qua nhóm chat, tin quảng cáo, người không phải khách hàng quan tâm bất động sản.',
    'Đây là nội dung chat Zalo của sale với nhiều người.', text, '', img, mime, 20000);
  var cv = (Array.isArray(o.conversations) ? o.conversations : []).slice(0, 40).map(function (c) {
    return { kind: c && c.kind === 'contact' ? 'contact' : 'chat', label: str_(c && c.label, 150), name: str_(c && c.name, 80), phone: normPhone_(c && c.phone), summary: str_(c && c.summary, 400), need: str_(c && c.need, 300), obstacle: str_(c && c.obstacle, 300), heat: str_(c && c.heat, 20), next: str_(c && c.next, 300) };
  }).filter(function (c) { return c.name || c.phone; });
  return { conversations: cv };
}
// Chụp bảng hoa hồng kế toán gửi: AI đọc từng dòng, trả về các khoản để xem trước rồi lưu vào tab Hoa hồng.
function crmScanComm(k, text, img, mime) {
  requireUi_(k);
  var o = scanAi_('Bạn đọc bảng thu nhập, hoa hồng của nhân viên kinh doanh do kế toán gửi theo tháng (ảnh chụp hoặc chữ dán) và chỉ trả về MỘT đối tượng JSON, không thêm chữ nào khác: ' +
    '{"month":"YYYY-MM của tháng nhận tiền, lấy từ chữ như nhận trong tháng 09/2026, không thấy thì rỗng","salary":số tiền Thu nhập CT từ lương nhận trong tháng hoặc null,' +
    '"rows":[{"type":"Hoa hồng NVKD hoặc Thưởng TPKD hoặc Thưởng GĐKD hoặc Thưởng khác","units":["mọi mã căn nhìn thấy trong dòng"],"unit":"mã căn nối bằng dấu ;","price":"Tổng giá bán hoặc Giá tính hoa hồng","rate":"Mức phí hoa hồng % nếu có (vd 2.0), nếu không có giá thì là tỷ lệ tính thanh toán đợt này","total":"tổng hoa hồng hoặc tổng thưởng của dòng, kể cả khi ghi đợt 1","prev":"đã tính thanh toán đợt trước","now":"tính thanh toán đợt này","net":"hoa hồng hoặc thưởng còn được nhận trong tháng (cột cuối cùng)","taxPaid":"Thuế TNCN đã khấu trừ","taxDue":"Thuế TNCN còn lại phải khấu trừ"}]}. ' +
    'Quy ước: MÃ CĂN là ký hiệu gồm chữ cái và số như SL11611, A21011, S1.12.12A. Mã căn có thể nằm ở cột Mã căn, hoặc nằm giữa dòng ở ô gộp dưới các cột như Giá tính hoa hồng hay Tỷ lệ (ví dụ SL11611; SL112B01; SL12016), khi đó vẫn là mã căn, không phải giá tiền. ' +
    'Cột "Thưởng quản lý kinh doanh" hoặc "Thưởng QL" thì type là Thưởng TPKD (là Thưởng GĐKD nếu chữ ghi giám đốc kinh doanh); cột "Hoa hồng NVKD/Đại lý" thì type là Hoa hồng NVKD. Nếu cả hai cột cùng có số thì tách thành hai mục có cùng mã căn. ' +
    'Nếu bảng có mỗi mã căn một dòng thì mỗi dòng là một mục: price là giá tính phí, total là Tổng hoa hồng NVKD, prev là hoa hồng đã tính thanh toán các đợt trước, now là hoa hồng còn lại tính thanh toán đợt này, và net của dòng cũng là số "còn lại tính thanh toán đợt này". Dòng "Thưởng quản lý kinh doanh" có số riêng và các mã căn ghi trong ô gộp thì là một mục type Thưởng TPKD với total và net bằng số thưởng đó. Ô cuối cùng "hoa hồng, thưởng còn được nhận" nếu là ô gộp chung nhiều dòng thì là tổng sau thuế của cả tháng, KHÔNG gán cho dòng nào. ' +
    'Cột "Tiền thưởng, hoa hồng đã nhận trong tháng" là tổng cả tháng của mọi khoản, KHÔNG dùng làm net của từng dòng. Giảm trừ gia cảnh và thu nhập tính thuế bỏ qua. ' +
    'Mỗi dòng dữ liệu của bảng là một mục trong rows, các số viết bằng chữ số, không kèm đơn vị, ô trống thì để 0. Lương chỉ lấy một lần vào salary, đừng lặp lại trong rows. Tuyệt đối không bịa số.',
    'Đây là bảng hoa hồng, thu nhập kế toán gửi.', text, '', img, mime, 7000);
  var rows = (Array.isArray(o.rows) ? o.rows : []).slice(0, 20).map(function (r) {
    var codes = (Array.isArray(r && r.units) ? r.units : []).map(function (u) { return String(u || '').trim(); }).filter(Boolean);
    var unit = codes.length ? codes.join('; ') : String((r && r.unit) || '').replace(/\s*[,;]\s*/g, '; ');
    return { type: COMM_TYPES.indexOf(r && r.type) >= 0 ? r.type : COMM_TYPES[0], unit: str_(unit, 80), price: numIn_(r && r.price), rate: numIn_(r && r.rate), total: numIn_(r && r.total), prev: numIn_(r && r.prev), now: numIn_(r && r.now),
      net: numIn_(r && r.net) || numIn_(r && r.now), taxPaid: numIn_(r && r.taxPaid), taxDue: numIn_(r && r.taxDue) };
  }).filter(function (r) { return r.net || r.total || r.unit; });
  return { month: monthStr_(o.month), salary: numIn_(o.salary), rows: rows };
}
// Khách nhập từ file/Sheet là data cũ: không hiện trong "Việc hôm nay" và không nhắc gọi. Hàm này chuyển nhóm khách đang chờ sang data nhập.
function crmSilence(k, phones) {
  requireUi_(k);
  phones = (Array.isArray(phones) ? phones : []).slice(0, 500).map(normPhone_).filter(Boolean);
  if (!phones.length) return { n: 0 };
  return withLock_(function () {
    var sh = ss_().getSheetByName(S_LEADS), n = lastDataRow_(sh, 2), want = {}, done = 0;
    ensureLeadCols_(sh);
    phones.forEach(function (p) { want[p] = 1; });
    var ph = n > 1 ? sh.getRange(2, 4, n - 1, 1).getValues() : [];
    for (var i = 0; i < ph.length; i++) if (want[normPhone_(phoneStr_(ph[i][0]))]) { sh.getRange(i + 2, 40).setValue('Data nhập'); done++; }
    return { n: done };
  });
}
// Chụp danh sách liên hệ, bảng khách hoặc ảnh danh bạ: AI đọc tên và số điện thoại nhìn thấy trong ảnh (không đoán số).
function crmScanContacts(k, text, img, mime) {
  requireUi_(k);
  var o = scanAi_('Bạn đọc ảnh chụp hoặc chữ dán có danh sách người liên hệ (danh bạ điện thoại, bảng khách, tin nhắn) và chỉ trả về MỘT đối tượng JSON, không thêm chữ nào khác: ' +
    '{"contacts":[{"name":"tên người, bỏ phần ghi chú trong ngoặc","phone":"số điện thoại nếu nhìn thấy rõ, không thấy thì rỗng","note":"ghi chú đi kèm, ví dụ nội dung trong ngoặc, dự án, mã căn"}]}. ' +
    'Mỗi người một mục, tối đa 60 mục. Tuyệt đối không bịa hay đoán số điện thoại; chỉ ghi số nếu có chữ số hiện rõ trong nguồn.',
    'Đây là danh sách người liên hệ cần nhập vào CRM.', text, '', img, mime, 8000);
  return { contacts: (Array.isArray(o.contacts) ? o.contacts : []).slice(0, 60).map(function (c) {
    return { name: str_(c && c.name, 100), phone: normPhone_(c && c.phone), note: str_(c && c.note, 200) };
  }).filter(function (c) { return c.name || c.phone; }) };
}

// Quét kế hoạch marketing của sàn hoặc cá nhân từ thông điệp, link, ảnh: rút kênh chạy, ngân sách, tiền ứng, mốc hỗ trợ.
function crmScanPlan(k, text, link, img, mime) {
  requireUi_(k);
  var o = scanAi_('Bạn đọc kế hoạch marketing bất động sản (của sàn hoặc cá nhân) và chỉ trả về MỘT đối tượng JSON, không thêm chữ nào khác, theo mẫu: ' +
    '{"project":"dự án hoặc chủ đầu tư","month":"YYYY-MM hoặc rỗng","kind":"Của sàn hoặc Cá nhân hoặc rỗng","advance":số tiền ứng trước bằng đồng hoặc null,"channels":[{"name":"kênh chạy","budget":số đồng,"note":""}],' +
    '"tiers":[{"from":số căn tối thiểu,"to":số căn tối đa hoặc null nếu trở lên,"pct":phần trăm được hỗ trợ từ 0 đến 100}],"note":"điều kiện, thời hạn, điểm cần kiểm tra"}. ' +
    'Quy ước tiers: pct là phần trăm tiền ứng được hỗ trợ, phần còn lại phải hoàn. "Hoàn 100%" nghĩa là pct 0; "hỗ trợ 100%" nghĩa là pct 100. Chỉ dùng số liệu có trong nguồn, thiếu thì để rỗng hoặc null, tuyệt đối không bịa.',
    'Nguồn là kế hoạch marketing hoặc thông báo hỗ trợ chi phí quảng cáo.', text, link, img, mime);
  return {
    project: str_(o.project, 120), month: monthStr_(o.month), kind: PLAN_KINDS.indexOf(o.kind) >= 0 ? o.kind : '', advance: scanNum_(o.advance), note: str_(o.note, 500),
    channels: (Array.isArray(o.channels) ? o.channels : []).slice(0, 20).map(function (c) { return { name: str_(c && c.name, 80), budget: scanNum_(c && c.budget), note: str_(c && c.note, 150) }; }).filter(function (c) { return c.name || c.budget; }),
    tiers: (Array.isArray(o.tiers) ? o.tiers : []).slice(0, 10).map(function (x) { return { from: Math.max(0, Math.round(Number(x && x.from) || 0)), to: x && x.to != null && x.to !== '' ? Math.max(0, Math.round(Number(x.to) || 0)) : '', pct: Math.min(100, Math.max(0, Number(x && x.pct) || 0)) }; })
  };
}

// ---- Quân sư AI: hỏi Claude về cách chăm khách. Khoá API lưu trong Script Properties (menu CRM > Cài khoá quân sư).
var ASK_MODEL = 'claude-sonnet-5-5';
var SCAN_MODEL = 'claude-haiku-5-5';   // quét ảnh, link, chat: cần nhanh và rẻ; đổi thành ASK_MODEL nếu muốn đọc kỹ hơn
function leadContext_(phone) {
  var f = findLead_(phone), sh = f.sh;
  ensureLeadCols_(sh);
  var r = sh.getRange(f.row, 1, 1, LEAD_COLS).getValues()[0], g = function (i) { return String(r[i] || '').trim(); };
  var lines = ['Khách: ' + (g(2) || '(chưa có tên)') + ', SĐT ' + phoneStr_(r[3]) + (g(28) ? ', SĐT phụ ' + g(28) : '') + (g(30) ? ', ' + g(30) : '') + '. Dự án / website phát sinh: ' + g(5) +
    '. Nguồn: ' + (g(6) || 'không rõ') + ', chiến dịch: ' + (g(7) || 'không rõ') + (g(40) ? ', trang: ' + g(40) : '') + '.',
    'Tương tác trên web: gửi form ' + (Number(r[9]) || 1) + ' lần, bấm Zalo ' + (Number(r[10]) || 0) + ' lần, bấm Gọi ' + (Number(r[11]) || 0) + ' lần. Đã gọi: ' + (r[14] === true ? 'rồi' : 'chưa') + ', đã nhắn: ' + (r[15] === true ? 'rồi' : 'chưa') + '.',
    'Trạng thái: ' + (g(18) || 'Mới') + '. Sale phụ trách: ' + (g(19) || 'chưa giao') + '. Hẹn tiếp theo: ' + (ymd_(r[22]) || 'chưa có') + '. Tự đánh giá tiềm năng: ' + (g(26) || 'chưa'),
    'Nhu cầu: dự án quan tâm ' + (g(41) || 'chưa rõ') + ', mục đích ' + (g(24) || 'chưa rõ') + ', loại căn ' + (g(25) || 'chưa rõ') + ', ngân sách ' + (g(33) || '?') + ' đến ' + (g(34) || '?') + ', vốn tự có ' + (g(35) || 'chưa rõ') +
    ', vay ngân hàng ' + (g(27) || 'chưa hỏi') + (g(36) ? ' (' + g(36) + ')' : '') + ', thời điểm dự kiến mua ' + (g(37) || 'chưa rõ') + '. Lý do chưa quyết định: ' + (g(38) || 'chưa rõ') + '.',
    'Địa chỉ: ' + ([g(43), g(42), g(30)].filter(Boolean).join(', ') || 'chưa rõ') + ', nghề nghiệp: ' + (g(32) || 'chưa rõ') + '. Ghi chú chung: ' + (g(21) || 'không có') + '.'];
  var h = crmHistory_(phone);
  if (h.logs.length) lines.push('Lịch sử chăm sóc (mới nhất trước): ' + h.logs.slice(0, 8).map(function (x) { return ymd_(new Date(x.at)) + ' ' + x.type + ': ' + x.content + (x.result ? ' (kết quả: ' + x.result + ')' : '') + (x.reply ? ' khách phản hồi: ' + x.reply : '') + (x.obstacle ? ' vướng mắc: ' + x.obstacle : ''); }).join(' | '));
  else lines.push('Chưa có lịch sử chăm sóc nào được ghi.');
  if (h.views.length) lines.push('Đã xem dự án: ' + h.views.slice(0, 5).map(function (x) { return x.at + ' ' + x.project + ' (quan tâm: ' + (x.interest || '?') + '; nhận xét: ' + (x.feedback || 'không') + '; vướng mắc: ' + (x.obstacle || 'không') + ')'; }).join(' | '));
  else lines.push('Chưa ghi nhận lần xem dự án nào.');
  return lines.join('\n');
}
// Dữ liệu lịch sử dùng chung (không kiểm tra khoá): cho AI và cho giao diện
function crmHistory_(phone) {
  var want = normPhone_(phone), out = { logs: [], views: [] };
  var rd = function (name, cols, map) {
    var sh = ss_().getSheetByName(name), res = [];
    if (!sh) return res;
    var n = sh.getLastRow();
    if (n < 2) return res;
    var rows = sh.getRange(2, 1, n - 1, cols).getValues();
    for (var i = rows.length - 1; i >= 0 && res.length < 50; i--) if (normPhone_(phoneStr_(String(rows[i][1]).replace(/^'/, ''))) === want) res.push(map(rows[i]));
    return res;
  };
  out.logs = rd('Nhật ký', 12, function (r) { return { at: iso_(r[0]), type: String(r[4]), content: String(r[5]), result: String(r[6]), reply: String(r[8] || ''), obstacle: String(r[9] || '') }; });
  out.views = rd('Xem dự án', 14, function (r) { return { at: ymd_(r[0]), project: String(r[3]), interest: String(r[8]), feedback: String(r[7]), obstacle: String(r[10]) }; });
  return out;
}
function crmAsk(k, question, phone) {
  requireUi_(k);
  var cap = Math.min(Number(arguments[3]) || 1500, 8000);   // dán đoạn chat Zalo được dài hơn câu hỏi thường
  question = String(question || '').trim().slice(0, cap);
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
      model: ASK_MODEL, max_tokens: cap > 1500 ? 1400 : 900,
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

var STATUSES = ['Mới', 'Đã liên hệ', 'Đang tư vấn', 'Đang cân nhắc', 'Quan tâm', 'Hẹn xem', 'Đã xem dự án', 'Đang thương lượng', 'Booking', 'Chốt', 'Mất', 'Tạm dừng'];
// Ghi các trường hồ sơ vào dòng khách (dùng chung cho sửa, tạo thủ công và nhập danh sách). Gọi trong withLock_.
function applyFields_(sh, r, f) {
  ensureLeadCols_(sh);
  var set = function (col, v) { sh.getRange(r, col).setValue(v); };
  if (f.name !== undefined) set(3, str_(f.name, 120));
  if (f.email !== undefined) set(5, str_(f.email, 160));
  if (f.status !== undefined) {
    var oldS = String(sh.getRange(r, 19).getValue() || '');
    if (oldS !== f.status) {
      tab_('Nhật ký', LOG_HEAD).appendRow([new Date(), "'" + phoneStr_(sh.getRange(r, 4).getValue()), str_(sh.getRange(r, 3).getValue(), 120), String(sh.getRange(r, 20).getValue() || ''), 'Ghi chú',
        'Đổi trạng thái: ' + (oldS || 'chưa có') + ' → ' + f.status + (f.statusReason ? '. Lý do: ' + str_(f.statusReason, 300) : ''), '', '', '', '', '', '']);
    }
    set(19, f.status);
  }
  if (f.assignee !== undefined) {
    var oldA = String(sh.getRange(r, 20).getValue() || ''), newA = str_(f.assignee, 80);
    if (oldA !== newA) {
      tab_('Chuyển giao', MOVE_HEAD).appendRow([new Date(), "'" + phoneStr_(sh.getRange(r, 4).getValue()), str_(sh.getRange(r, 3).getValue(), 120), oldA, newA, String(sh.getRange(r, 19).getValue() || ''), str_(f.reason, 200)]);
    }
    set(20, newA);
  }
  if (f.value !== undefined) set(21, Math.max(0, Number(f.value) || 0));
  if (f.note !== undefined) set(22, str_(f.note, 2000));
  if (f.next !== undefined) set(23, f.next === '' ? '' : (ymd_(f.next) || ''));
  if (f.bmin !== undefined || f.bmax !== undefined) {
    var lo = f.bmin !== undefined ? str_(f.bmin, 40) : String(sh.getRange(r, 34).getValue() || ''), hi = f.bmax !== undefined ? str_(f.bmax, 40) : String(sh.getRange(r, 35).getValue() || '');
    set(34, lo); set(35, hi);
    set(24, lo && hi ? lo + ' – ' + hi : (lo || hi));
  } else if (f.budget !== undefined) set(24, str_(f.budget, 80));
  if (f.purpose !== undefined) set(25, str_(f.purpose, 40));
  if (f.product !== undefined) set(26, str_(f.product, 120));
  if (f.heat !== undefined) set(27, ['', 'Nóng', 'Ấm', 'Lạnh'].indexOf(f.heat) >= 0 ? f.heat : '');
  if (f.loan !== undefined) set(28, ['', 'Có', 'Không', 'Chưa rõ'].indexOf(f.loan) >= 0 ? f.loan : '');
  var txt = { phone2: [29, 20], zalo: [30, 200], province: [31, 60], dob: [32, 10], job: [33, 80], equity: [36, 60], loanAmt: [37, 60], buyTime: [38, 80], undecided: [39, 500], srcType: [40, 40], project: [42, 120], district: [43, 100], address: [44, 200] };
  for (var k in txt) if (f[k] !== undefined) set(txt[k][0], k === 'dob' ? (ymd_(f[k]) || '') : str_(f[k], txt[k][1]));
  if (f.docUrl !== undefined) set(45, /^https?:\/\//i.test(String(f.docUrl).trim()) ? String(f.docUrl).trim().slice(0, 500) : '');
}
function crmUpdateLead(k, phone, f) {
  requireUi_(k);
  f = f || {};
  if (f.status !== undefined && STATUSES.indexOf(f.status) < 0) throw new Error('Trạng thái không hợp lệ');
  return withLock_(function () {
    var x = findLead_(phone);
    applyFields_(x.sh, x.row, f);
    return { ok: true };
  });
}

// Nhật ký chăm sóc: mỗi lần gọi / nhắn / gặp / gửi tài liệu là một dòng, không bao giờ bị ghi đè.
function crmAddLog(k, phone, f) {
  requireUi_(k);
  f = f || {};
  var type = LOG_TYPES.indexOf(f.type) >= 0 ? f.type : 'Ghi chú';
  var content = str_(f.content, 1500);
  if (!content && !f.result) throw new Error('Chưa nhập nội dung');
  return withLock_(function () {
    var x = findLead_(phone), sh = x.sh, r = x.row;
    ensureLeadCols_(sh);
    var by = String(sh.getRange(r, 20).getValue() || '');
    tab_('Nhật ký', LOG_HEAD).appendRow(
      [new Date(), "'" + phoneStr_(sh.getRange(r, 4).getValue()), str_(sh.getRange(r, 3).getValue(), 120), by, type, content, str_(f.result, 300), ymd_(f.next),
        str_(f.reply, 600), str_(f.obstacle, 600), str_(f.docs, 300), str_(f.nextAction, 300)]);
    if (f.next !== undefined) sh.getRange(r, 23).setValue(ymd_(f.next) || '');
    return { ok: true };
  });
}

// Lịch sử xem dự án: một khách có thể xem nhiều dự án, nhiều lần.
function crmAddView(k, phone, f) {
  requireUi_(k);
  f = f || {};
  var project = str_(f.project, 120);
  if (!project) throw new Error('Chưa nhập tên dự án');
  var day = ymd_(f.at);
  if (!day) throw new Error('Chưa chọn ngày xem');
  return withLock_(function () {
    var x = findLead_(phone), sh = x.sh, r = x.row;
    ensureLeadCols_(sh);
    tab_('Xem dự án', VIEW_HEAD).appendRow([day, "'" + phoneStr_(sh.getRange(r, 4).getValue()), str_(sh.getRange(r, 3).getValue(), 120), project,
      VIEW_FORMS.indexOf(f.form) >= 0 ? f.form : 'Trực tiếp', str_(f.product, 150), str_(f.companions, 150), str_(f.feedback, 800),
      ['Cao', 'Trung bình', 'Thấp'].indexOf(f.interest) >= 0 ? f.interest : '', str_(f.pros, 400), str_(f.obstacle, 500), str_(f.nextStep, 300), ymd_(f.next), String(sh.getRange(r, 20).getValue() || '')]);
    if (f.next) sh.getRange(r, 23).setValue(ymd_(f.next) || '');
    return { ok: true };
  });
}

function crmLogs(k, phone) {
  requireUi_(k);
  var want = normPhone_(phone), out = { logs: [], moves: [], views: [] };
  var read = function (name, cols, map) {
    var sh = ss_().getSheetByName(name);
    if (!sh) return [];
    var n = sh.getLastRow();
    if (n < 2) return [];
    var rows = sh.getRange(2, 1, n - 1, cols).getValues(), res = [];
    for (var i = rows.length - 1; i >= 0 && res.length < 200; i--) if (normPhone_(phoneStr_(String(rows[i][1]).replace(/^'/, ''))) === want) res.push(map(rows[i]));
    return res;
  };
  out.logs = read('Nhật ký', 12, function (r) { return { at: iso_(r[0]), by: String(r[3]), type: String(r[4]), content: String(r[5]), result: String(r[6]), next: ymd_(r[7]), reply: String(r[8] || ''), obstacle: String(r[9] || ''), docs: String(r[10] || ''), nextAction: String(r[11] || '') }; });
  out.moves = read('Chuyển giao', 7, function (r) { return { at: iso_(r[0]), from: String(r[3]), to: String(r[4]), status: String(r[5]), reason: String(r[6]) }; });
  out.views = read('Xem dự án', 14, function (r) { return { at: ymd_(r[0]), project: String(r[3]), form: String(r[4]), product: String(r[5]), companions: String(r[6]), feedback: String(r[7]), interest: String(r[8]), pros: String(r[9]), obstacle: String(r[10]), nextStep: String(r[11]), next: ymd_(r[12]), by: String(r[13]) }; });
  return out;
}

// Tạo khách thủ công. Nếu SĐT đã có: không tạo, không tự gộp. Trả về hồ sơ cũ để bạn xác nhận (mergeBlank = chỉ điền ô còn trống).
function createLead_(f) {
  var phone = normPhone_(f.phone);
  if (!phone) throw new Error('Số điện thoại không hợp lệ');
  var exist = null;
  try { exist = findLead_(phone); } catch (e) {}
  if (exist) {
    var rr = exist.sh.getRange(exist.row, 1, 1, 22).getValues()[0];
    var info = { name: String(rr[2] || ''), phone: phoneStr_(rr[3]), site: String(rr[5] || ''), status: String(rr[18] || 'Mới'), assignee: String(rr[19] || '') };
    if (f.mergeBlank === true) {
      withLock_(function () {
        var sh = exist.sh, r = exist.row, blank = {};
        ensureLeadCols_(sh);
        var cols = { name: 3, email: 5, project: 42, district: 43, address: 44, province: 31, job: 33, phone2: 29, zalo: 30, dob: 32, bmin: 34, bmax: 35, equity: 36, loanAmt: 37, buyTime: 38, product: 26, purpose: 25, loan: 28 };
        for (var key in cols) if (f[key] && !sh.getRange(r, cols[key]).getValue()) blank[key] = f[key];
        applyFields_(sh, r, blank);
      });
      return { merged: true, lead: info };
    }
    return { dup: true, lead: info };
  }
  var site = { key: '', name: str_(f.site, 80) || 'Nhập thủ công' };
  var b = { phone: f.phone, name: f.name, email: f.email, message: f.note, utm_source: str_(f.source, 100) || 'nhập thủ công', utm_campaign: str_(f.campaign, 150), vid: 'manual-' + Utilities.getUuid().slice(0, 8), url: str_(f.url, 300), at: f.at ? new Date(f.at) : null, noEvent: f.noEvent === true };
  if (b.at && isNaN(b.at.getTime())) b.at = null;
  handleLead_(b, site);
  withLock_(function () {
    var x = findLead_(phone), rest = {};
    for (var key in f) if (['phone', 'name', 'email', 'note', 'site', 'source', 'campaign', 'url', 'mergeBlank', 'at', 'noEvent'].indexOf(key) < 0) rest[key] = f[key];
    if (f.status !== undefined && STATUSES.indexOf(f.status) < 0) delete rest.status;
    applyFields_(x.sh, x.row, rest);
  });
  return { added: true, phone: phone };
}
function crmCreateLead(k, f) {
  requireUi_(k);
  return createLead_(f || {});
}
// Nhập hàng loạt: đọc danh sách số hiện có một lần, ghi cả khối bằng một lệnh. Nhanh hơn nhiều so với từng khách một (tránh quá thời gian thực thi).
// list: [{name, phone, email, site, source, campaign, note, product, url, budget, project, province, docUrl, at(Date)}]
function bulkAddLeads_(list, srcType) {
  var rep = { added: 0, dups: [], errors: [] };
  if (!list.length) return rep;
  return withLock_(function () {
    var sh = ss_().getSheetByName(S_LEADS);
    ensureLeadCols_(sh);
    var last = lastDataRow_(sh, 2), have = {}, ph = last > 1 ? sh.getRange(2, 4, last - 1, 1).getValues() : [];
    ph.forEach(function (r, i) { var p = normPhone_(phoneStr_(r[0])); if (p && !have[p]) have[p] = { name: '', row: i + 2 }; });
    var out = [], now = new Date();
    list.forEach(function (r, i) {
      var phone = normPhone_(r.phone);
      if (!phone) { rep.errors.push({ line: i + 1, reason: 'Số điện thoại không hợp lệ', phone: String(r.phone || '') }); return; }
      if (have[phone]) { rep.dups.push({ line: i + 1, phone: phone, name: str_(r.name, 120) }); return; }
      have[phone] = { name: str_(r.name, 120), row: last + 1 + out.length };
      var rowNum = last + 1 + out.length, a = new Array(LEAD_COLS);
      for (var c = 0; c < LEAD_COLS; c++) a[c] = '';
      a[0] = last + out.length; a[1] = (r.at instanceof Date && !isNaN(r.at.getTime())) ? r.at : now; a[2] = str_(r.name, 120); a[3] = phone; a[4] = str_(r.email, 160); a[5] = str_(r.site, 80) || 'Nhập thủ công';
      a[6] = str_(r.source, 100) || 'nhập thủ công'; a[7] = str_(r.campaign, 150); a[8] = ''; a[9] = 1; a[10] = 0; a[11] = 0;
      a[12] = '=HYPERLINK("https://zalo.me/"&$D' + rowNum + ',"Mở Zalo")'; a[13] = '=HYPERLINK("tel:"&$D' + rowNum + ',"Gọi")'; a[14] = false; a[15] = false;
      a[17] = '=IF(AND($O' + rowNum + '<>TRUE,$P' + rowNum + '<>TRUE),"CHƯA LIÊN HỆ","")'; a[18] = STATUS_NEW; a[21] = str_(r.note, 1000);
      a[25] = str_(r.product, 150); a[30] = str_(r.province, 60); a[34] = str_(r.budget, 40); a[39] = srcType || 'Data nhập'; a[40] = str_(r.url, 300); a[41] = str_(r.project, 120);
      a[44] = /^https?:\/\//i.test(String(r.docUrl || '').trim()) ? String(r.docUrl).trim().slice(0, 500) : '';
      out.push(a);
    });
    if (out.length) {
      var need = last + out.length - sh.getMaxRows();
      if (need > 0) { try { sh.insertRowsAfter(sh.getMaxRows(), need + 50); } catch (e) {} }
      var rg = sh.getRange(last + 1, 1, out.length, LEAD_COLS);
      try { sh.getRange(last + 1, 4, out.length, 1).setNumberFormat('@'); sh.getRange(last + 1, 23, out.length, LEAD_COLS - 22).setNumberFormat('@'); } catch (e) {}
      rg.setValues(out);
      rep.added = out.length;
    }
    return rep;
  });
}
// Nhập danh sách dán từ Excel: mỗi dòng {name, phone, province, site, budget, source, note}. Trả báo cáo dòng lỗi và dòng trùng.
function crmImport(k, rows, merge) {
  requireUi_(k);
  rows = rows || [];
  if (rows.length > 500) throw new Error('Tối đa 500 dòng mỗi lần nhập');
  if (merge !== true) return bulkAddLeads_(rows.map(function (r) { return { name: r.name, phone: r.phone, province: r.province, site: r.site, project: r.project, budget: r.budget, source: r.source || 'nhập Excel', note: r.note, docUrl: r.docUrl }; }), 'Data nhập');
  var rep = { added: 0, dups: [], errors: [] };
  rows.forEach(function (r, i) {
    var line = i + 1;
    try {
      var res = createLead_({ name: r.name, phone: r.phone, province: r.province, site: r.site, project: r.project, bmax: r.budget, source: r.source || 'nhập Excel', note: r.note, docUrl: r.docUrl, srcType: 'Data nhập', mergeBlank: merge === true });
      if (res.dup) rep.dups.push({ line: line, phone: res.lead.phone, name: res.lead.name }); else if (res.merged) rep.merged = (rep.merged || 0) + 1; else rep.added++;
    } catch (e) { rep.errors.push({ line: line, reason: String(e.message || e), phone: String(r.phone || '') }); }
  });
  return rep;
}

// ---- Nhập khách từ một Google Sheet khác theo link (mỗi tab là một dự án, dòng là khách để lại thông tin) ----
function sheetId_(url) {
  var m = /^https:\/\/docs\.google\.com\/spreadsheets\/d\/([A-Za-z0-9_-]{20,})/.exec(String(url || '').trim());
  if (!m) throw new Error('Link phải là Google Sheet, dạng https://docs.google.com/spreadsheets/d/...');
  return m[1];
}
function toPhone_(v) {
  var d = String(v == null ? '' : v).replace(/[^\d+]/g, '');
  if (/^\d{9}$/.test(d) && /^[35789]/.test(d)) d = '0' + d;      // ô bị mất số 0 đầu
  return normPhone_(d);
}
function toDate_(v) {
  if (v instanceof Date) return isNaN(v.getTime()) ? null : v;
  var s = String(v || '').trim(), m = /^(\d{4})-(\d{1,2})-(\d{1,2})(?:[ T](\d{1,2}):(\d{2})(?::(\d{2}))?)?/.exec(s);
  if (m) return new Date(+m[1], +m[2] - 1, +m[3], +(m[4] || 0), +(m[5] || 0), +(m[6] || 0));
  m = /^(\d{1,2})\/(\d{1,2})\/(\d{4})(?:\s+(\d{1,2}):(\d{2}))?/.exec(s);
  return m ? new Date(+m[3], +m[2] - 1, +m[1], +(m[4] || 0), +(m[5] || 0)) : null;
}
function urlParams_(u) {
  var o = {}, q = String(u || '').split('?')[1] || '';
  q.split('#')[0].split('&').forEach(function (p) {
    var i = p.indexOf('='); if (i < 1) return;
    try { o[decodeURIComponent(p.slice(0, i))] = decodeURIComponent(p.slice(i + 1).replace(/\+/g, ' ')); } catch (e) {}
  });
  return o;
}
// Hai kiểu tab: có dòng tiêu đề (có cột Số điện thoại) thì ghép theo tên cột; không có thì là dòng form thô: ngày | tên | (email) | điện thoại | loại căn | link trang ...
function parseSheetRows_(values, siteName) {
  var out = []; if (!values || !values.length) return out;
  var head = (values[0] || []).map(function (h) { return String(h || '').trim().toLowerCase(); });
  var hasHead = head.some(function (h) { return /điện thoại|sđt|phone/.test(h); });
  var idx = function (re) { for (var i = 0; i < head.length; i++) if (re.test(head[i])) return i; return -1; };
  var m = hasHead ? { at: idx(/ngày|thời gian/), name: idx(/^(họ )?tên|tên khách/), phone: idx(/điện thoại|sđt|phone/), email: idx(/email/), site: idx(/dự án/), source: idx(/nguồn/), camp: idx(/chiến dịch/), note: idx(/ghi chú/), need: idx(/nhu cầu/), url: idx(/link|url/), bud: idx(/ngân sách/) } : null;
  var g = function (r, i) { return i >= 0 && r[i] != null ? String(r[i]).trim() : ''; };
  for (var i = hasHead ? 1 : 0; i < values.length; i++) {
    var r = values[i]; if (!r || !r.join('')) continue;
    var row;
    if (hasHead) {
      row = { at: toDate_(r[m.at]), name: g(r, m.name), phone: toPhone_(r[m.phone]), email: g(r, m.email), site: g(r, m.site) || siteName, source: g(r, m.source) || 'Google Sheet', campaign: g(r, m.camp), note: g(r, m.note), product: g(r, m.need), url: g(r, m.url), budget: g(r, m.bud) };
    } else {
      var phone = '', email = '', need = '', url = '';
      for (var c = 2; c < Math.min(r.length, 8); c++) {
        var v = String(r[c] == null ? '' : r[c]).trim(); if (!v) continue;
        if (!email && v.indexOf('@') > 0) email = v;
        else if (!phone && /^[\d\s.+\-]{9,14}$/.test(v) && toPhone_(v)) phone = toPhone_(v);
        else if (!url && /^https?:\/\//i.test(v)) url = v;
        else if (!need && /căn|phòng ngủ|studio|pn\b/i.test(v)) need = v;
      }
      var p = urlParams_(url);
      row = { at: toDate_(r[0]), name: String(r[1] || '').trim(), phone: phone, email: email, site: siteName, product: need, url: url, budget: '', note: '',
        source: p.utm_source || (p.gclid || p.gad_source || p.gbraid || p.wbraid ? 'google' : p.fbclid ? 'facebook' : 'website'), campaign: p.utm_campaign || (p.gad_campaignid ? 'gads-' + p.gad_campaignid : '') };
    }
    if (row.phone) out.push(row);
  }
  return out;
}
var SHEET_SKIP = /^(TONG_HOP|UPLOAD_.*|CRM_LOG|SAN_PHAM)$/i;
function openSheet_(url) {
  var id = sheetId_(url);
  try { return SpreadsheetApp.openById(id); } catch (e) { throw new Error('Không mở được Sheet này. Hãy chắc chắn tài khoản chạy CRM có quyền xem file.'); }
}
function siteNameFor_(tab) {
  var ws = ss_().getSheetByName(S_SITES), n = ws ? ws.getLastRow() : 1, want = String(tab).trim().toLowerCase();
  if (n > 1) { var rows = ws.getRange(2, 1, n - 1, 1).getValues(); for (var i = 0; i < rows.length; i++) if (String(rows[i][0]).trim().toLowerCase() === want) return String(rows[i][0]).trim(); }
  return String(tab).trim();
}
function sheetTabRows_(sh) {
  var n = Math.min(sh.getLastRow(), 5000), c = Math.min(sh.getLastColumn(), 26);
  if (n < 1 || c < 1) return [];
  return parseSheetRows_(sh.getRange(1, 1, n, c).getValues(), siteNameFor_(sh.getName()));
}
function crmSheetTabs(k, url) {
  requireUi_(k);
  var ss = openSheet_(url), tabs = [];
  ss.getSheets().forEach(function (sh) {
    var nm = sh.getName(); if (SHEET_SKIP.test(nm)) return;
    var rows = sheetTabRows_(sh), days = rows.map(function (r) { return r.at ? ymd_(r.at) : ''; }).filter(Boolean).sort();
    tabs.push({ name: nm, site: siteNameFor_(nm), count: rows.length, from: days[0] || '', to: days[days.length - 1] || '' });
  });
  return { title: ss.getName(), tabs: tabs };
}
function crmSheetImport(k, url, tab, offset, limit) {
  requireUi_(k);
  offset = Math.max(0, Number(offset) || 0); limit = Math.min(300, Math.max(1, Number(limit) || 300));
  var sh = openSheet_(url).getSheetByName(String(tab || ''));
  if (!sh) throw new Error('Không thấy tab ' + tab);
  var rows = sheetTabRows_(sh), part = rows.slice(offset, offset + limit), r2 = bulkAddLeads_(part.map(function (r) { return { name: r.name, phone: r.phone, email: r.email, site: r.site, source: r.source, campaign: r.campaign, note: r.note, product: r.product, url: r.url, budget: r.budget, at: r.at }; }), 'Data nhập');
  return { total: rows.length, next: offset + limit >= rows.length ? null : offset + limit, added: r2.added, dups: r2.dups, errors: r2.errors.map(function (e) { return { line: offset + e.line, reason: e.reason }; }) };
}

// ---- Báo cáo theo khoảng ngày (Tổng quan, Chiến dịch) ----
function addDays_(day, n) { var p = String(day).split('-'); return ymd_(new Date(Date.UTC(Number(p[0]), Number(p[1]) - 1, Number(p[2]) + n, 12))).slice(0, 10) || ''; }
function daysBetween_(a, b) { var x = String(a).split('-'), y = String(b).split('-'); return Math.round((Date.UTC(+y[0], +y[1] - 1, +y[2]) - Date.UTC(+x[0], +x[1] - 1, +x[2])) / 864e5) + 1; }
function crmReport(k, from, to) {
  requireUi_(k);
  var today = ymd_(new Date());
  to = ymd_(to) || today; from = ymd_(from) || addDays_(to, -29);
  if (from > to) { var sw = from; from = to; to = sw; }
  var n = Math.min(daysBetween_(from, to), 3660), prevTo = addDays_(from, -1), prevFrom = addDays_(from, -n);
  var ss = ss_(), sites = {}, camps = {}, daily = {}, all = {}, tot = { pv: 0, zalo: 0, phone: 0, msg: 0, leads: 0, unc: 0, closed: 0, cost: 0, imp: 0, clk: 0 };
  var S = function (name) { return sites[name] || (sites[name] = { name: name, v: {}, pv: 0, zalo: 0, phone: 0, msg: 0, leads: 0, unc: 0 }); };
  var C = function (u) { return camps[u] || (camps[u] = { utm: u, name: u, platform: '', declared: false, v: {}, pv: 0, zalo: 0, phone: 0, msg: 0, leads: 0, unc: 0, closed: 0, revenue: 0, cost: 0, imp: 0, clk: 0, costPrev: 0, leadsPrev: 0, clkPrev: 0, first: '', last: '', active: {} }); };
  var D = function (day) { return daily[day] || (daily[day] = { v: {}, leads: 0, cost: 0 }); };
  var inR = function (d) { return d && d >= from && d <= to; }, inP = function (d) { return d && d >= prevFrom && d <= prevTo; };
  var evs = ss.getSheetByName(S_EVENTS), en = evs ? evs.getLastRow() : 1;
  if (en > 1) {
    var st = Math.max(2, en - 19999);
    evs.getRange(st, 1, en - st + 1, 8).getValues().forEach(function (r) {
      var day = ymd_(r[0]); if (!inR(day)) return;
      var vid = String(r[1]), type = String(r[3]), ch = String(r[4]), utm = String(r[7] || '').trim(), s = S(String(r[2])), c = utm ? C(utm) : null;
      if (type === 'pageview') { s.pv++; s.v[vid] = 1; all[vid] = 1; tot.pv++; D(day).v[vid] = 1; if (c) { c.pv++; c.v[vid] = 1; } }
      else if (type === 'click') {
        var f = ch === 'zalo' ? 'zalo' : ch === 'phone' ? 'phone' : ch === 'messenger' ? 'msg' : '';
        if (f) { s[f]++; tot[f]++; if (c) c[f]++; }
      }
    });
  }
  var ls = ss.getSheetByName(S_LEADS), ln = ls ? lastDataRow_(ls, 2) : 1;
  if (ln > 1) {
    ls.getRange(2, 1, ln - 1, 22).getValues().forEach(function (r) {
      if (!r[3]) return;
      var day = ymd_(r[1]), utm = String(r[7] || '').trim();
      if (inR(day)) {
        var s = S(String(r[5])), unc = String(r[17]) === 'CHƯA LIÊN HỆ';
        s.leads++; tot.leads++; D(day).leads++; if (unc) { s.unc++; tot.unc++; }
        if (String(r[18]) === 'Chốt') { s.closed++; tot.closed++; }
        if (utm) { var c = C(utm); c.leads++; if (unc) c.unc++; if (String(r[18]) === 'Chốt') { c.closed++; c.revenue += Number(r[20]) || 0; } }
      } else if (inP(day) && utm) C(utm).leadsPrev++;
    });
  }
  var cp = ss.getSheetByName('Chi phí'), cn = cp ? cp.getLastRow() : 1;
  if (cn > 1) {
    cp.getRange(2, 1, cn - 1, 5).getValues().forEach(function (r) {
      var day = ymd_(r[0]), utm = String(r[1] || '').trim(); if (!day || !utm) return;
      var cost = Number(r[2]) || 0, imp = Number(r[3]) || 0, clk = Number(r[4]) || 0, c = C(utm);
      if (cost > 0 || imp > 0) { if (!c.first || day < c.first) c.first = day; if (day > c.last) c.last = day; }
      if (inR(day)) { c.cost += cost; c.imp += imp; c.clk += clk; tot.cost += cost; tot.imp += imp; tot.clk += clk; D(day).cost += cost; if (cost > 0 || imp > 0) c.active[day] = 1; }
      else if (inP(day)) { c.costPrev += cost; c.clkPrev += clk; }
    });
  }
  var cd = ss.getSheetByName('Chiến dịch'), cdn = cd ? cd.getLastRow() : 1;
  if (cdn > 1) cd.getRange(2, 1, cdn - 1, 3).getValues().forEach(function (r) { var u = String(r[2] || '').trim(); if (u) { var c = C(u); c.declared = true; c.platform = String(r[0] || ''); c.name = String(r[1] || u); } });
  var campaigns = Object.keys(camps).map(function (u) { return camps[u]; }).filter(function (c) { return c.declared || c.cost || c.pv || c.leads || c.imp; }).map(function (c) {
    return { utm: c.utm, name: c.name, platform: c.platform, declared: c.declared, visitors: Object.keys(c.v).length, pv: c.pv, zalo: c.zalo, phone: c.phone, msg: c.msg, leads: c.leads, unc: c.unc, closed: c.closed, revenue: c.revenue,
      cost: c.cost, imp: c.imp, clk: c.clk, costPrev: c.costPrev, leadsPrev: c.leadsPrev, clkPrev: c.clkPrev, first: c.first, last: c.last, activeDays: Object.keys(c.active).length };
  }).sort(function (a, b) { return b.cost - a.cost || b.leads - a.leads; });
  var siteArr = Object.keys(sites).map(function (x) { var s = sites[x]; return { name: s.name, visitors: Object.keys(s.v).length, pv: s.pv, zalo: s.zalo, phone: s.phone, msg: s.msg, leads: s.leads, unc: s.unc, closed: s.closed }; })
    .sort(function (a, b) { return b.visitors - a.visitors || b.leads - a.leads; });
  var dayArr = [], d = from, guard = 0;
  while (d <= to && guard++ < 3660) { var x = daily[d] || { v: {}, leads: 0, cost: 0 }; dayArr.push({ day: d, v: Object.keys(x.v).length, leads: x.leads, cost: x.cost }); d = addDays_(d, 1); }
  tot.visitors = Object.keys(all).length;
  return { from: from, to: to, days: n, prev: { from: prevFrom, to: prevTo }, tot: tot, sites: siteArr, campaigns: campaigns, daily: dayArr };
}

function crmClickDone(k, row, vid, done, note) {
  requireUi_(k);
  return withLock_(function () {
    var sh = ss_().getSheetByName(S_CLICKS);
    row = Number(row);
    if (!sh || row < 2 || String(sh.getRange(row, 2).getValue()) !== String(vid)) throw new Error('Dòng đã thay đổi, hãy tải lại');
    ensureClickCols_(sh);
    var was = sh.getRange(row, 9).getValue() === true;
    sh.getRange(row, 9).setValue(done === true);
    if (done === true && !was) sh.getRange(row, 12).setValue(new Date());
    if (done !== true) sh.getRange(row, 12).setValue('');
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
        last, (b.at instanceof Date ? b.at : new Date()), str_(b.name, 120), phone, str_(b.email, 160), site.name,
        str_(b.utm_source, 100), str_(b.utm_campaign, 150), str_(b.vid, 64), 1,
        "=COUNTIFS('" + S_EVENTS + "'!$B:$B,$I" + r + ",'" + S_EVENTS + "'!$D:$D,\"click\",'" + S_EVENTS + "'!$E:$E,\"zalo\")",
        "=COUNTIFS('" + S_EVENTS + "'!$B:$B,$I" + r + ",'" + S_EVENTS + "'!$D:$D,\"click\",'" + S_EVENTS + "'!$E:$E,\"phone\")",
        '=HYPERLINK("https://zalo.me/"&$D' + r + ',"Mở Zalo")',
        '=HYPERLINK("tel:"&$D' + r + ',"Gọi")',
        false, false, '',
        '=IF(AND($O' + r + '<>TRUE,$P' + r + '<>TRUE),"CHƯA LIÊN HỆ","")',
        STATUS_NEW, '', '', str_(b.message, 1000)
      ]]);
      ensureLeadCols_(sh);
      sh.getRange(r, 40).setValue(String(b.vid || '').indexOf('manual-') === 0 ? 'Nhập thủ công' : 'Website');
      sh.getRange(r, 41).setValue(str_(b.url, 300));
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
    if (!b.noEvent) logEvent_(b, site, 'form', '');
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
    .addItem('Cấp quyền đọc Google Sheet khác (để nhập khách)', 'capQuyenDocSheet')
    .addItem('Xem mã nhúng cho các website', 'showEmbed')
    .addItem('Tạo mã website ngẫu nhiên', 'newSiteKey')
    .addToUi();
}

// Chạy một lần để Google hỏi quyền mở Google Sheet khác bằng link (dùng cho nút Nhập từ link Google Sheet).
function capQuyenDocSheet() {
  var id = ss_().getId(), name = SpreadsheetApp.openById(id).getName();
  var msg = 'Đã có quyền đọc Google Sheet. Thử mở file "' + name + '" thành công. Bây giờ dùng được nút Nhập từ link Google Sheet trong CRM.';
  Logger.log(msg);
  try { SpreadsheetApp.getUi().alert(msg); } catch (e) {}
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
var CRM_HTML = /*__CRM_HTML__*/'';
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
