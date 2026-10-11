/*! CRM Hoàng Hiệp – mã theo dõi. Nhúng vào mọi website/landing page:
    <script src="https://CRM_CUA_BAN/track.js" data-key="SITE_KEY" async></script>
  Tự động: ghi lượt xem, click Zalo / Gọi điện / Messenger / SMS, và gửi form có ô số điện thoại về CRM.
  Nút bấm đặc biệt (không phải link): thêm thuộc tính data-crm-click="zalo|phone|messenger|sms".
  Gửi khách thủ công: window.crmLead({name, phone, email, message}) */
(function () {
  var el = document.currentScript || document.querySelector('script[data-key][src*="track.js"]');
  if (!el) return;
  var key = el.getAttribute('data-key');
  if (!key) return;
  var base = new URL(el.src).origin;
  var gas = /script\.google(usercontent)?\.com/.test(el.src); // chạy bằng Google Apps Script
  var endpoint = gas ? el.src.split('?')[0] : null;
  var W = window, D = document;

  function store(k, v) { try { if (v === undefined) return localStorage.getItem(k); localStorage.setItem(k, v); } catch (e) { return null; } }
  var vid = store('crm_vid');
  if (!vid) { vid = (W.crypto && crypto.randomUUID ? crypto.randomUUID() : String(Date.now()) + Math.random().toString(16).slice(2)); store('crm_vid', vid); }

  // UTM: giữ nguồn đầu tiên (first-touch), không bị ghi đè khi khách quay lại
  var q = new URLSearchParams(location.search), utm = {};
  ['utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term'].forEach(function (k) { if (q.get(k)) utm[k] = q.get(k); });
  if (!utm.utm_source && q.get('gclid')) { utm.utm_source = 'google'; utm.utm_medium = 'cpc'; }
  if (!utm.utm_source && q.get('fbclid')) { utm.utm_source = 'facebook'; utm.utm_medium = 'paid'; }
  try {
    var saved = JSON.parse(store('crm_utm') || 'null');
    if (!saved || !saved.utm_source) { if (utm.utm_source || document.referrer) store('crm_utm', JSON.stringify({ utm: utm, ref: document.referrer })); saved = { utm: utm, ref: document.referrer }; }
    utm = Object.keys(utm).length ? utm : saved.utm || {};
    var firstRef = saved.ref || document.referrer;
  } catch (e) { var firstRef = document.referrer; }

  function payload(extra) {
    var o = { key: key, vid: vid, url: location.href, referrer: firstRef || document.referrer };
    for (var k in utm) o[k] = utm[k];
    for (var j in extra) o[j] = extra[j];
    return JSON.stringify(o);
  }
  function post(path, extra) {
    extra = extra || {};
    if (gas) extra.action = path === '/api/lead' ? 'lead' : 'track';
    var body = payload(extra), url = gas ? endpoint : base + path;
    try { if (navigator.sendBeacon && navigator.sendBeacon(url, new Blob([body], { type: 'text/plain' }))) return; } catch (e) {}
    try { fetch(url, { method: 'POST', body: body, keepalive: true, mode: gas ? 'no-cors' : 'cors', headers: { 'Content-Type': 'text/plain' } }); } catch (e) {}
  }

  post('/api/track', { type: 'pageview' });

  function channelOf(a) {
    var forced = a.getAttribute && a.getAttribute('data-crm-click');
    if (forced) return forced;
    var h = (a.getAttribute && a.getAttribute('href') || '').toLowerCase();
    if (/^tel:/.test(h)) return 'phone';
    if (/^sms:/.test(h)) return 'sms';
    if (/(^|\/\/|\.)zalo\.me|zaloapp\.com|chat\.zalo\.me/.test(h)) return 'zalo';
    if (/(^|\/\/)m\.me\/|messenger\.com|fb\.com\/msg|facebook\.com\/messages/.test(h)) return 'messenger';
    return null;
  }
  var lastClick = {};
  D.addEventListener('click', function (e) {
    var n = e.target;
    while (n && n !== D) {
      if (n.nodeType === 1 && (n.hasAttribute('data-crm-click') || n.tagName === 'A')) {
        var ch = channelOf(n);
        if (ch) {
          var t = Date.now();
          if (!lastClick[ch] || t - lastClick[ch] > 1500) { lastClick[ch] = t; post('/api/track', { type: 'click', channel: ch }); }
          return;
        }
      }
      n = n.parentNode;
    }
  }, true);

  // Form: tự bắt form có ô số điện thoại
  var sent = {};
  function sendLead(d) {
    if (!d.phone) return;
    var digits = String(d.phone).replace(/\D/g, '');
    if (digits.length < 9 || (sent[digits] && Date.now() - sent[digits] < 5000)) return;
    sent[digits] = Date.now();
    post('/api/lead', d);
  }
  D.addEventListener('submit', function (e) {
    var f = e.target; if (!f || !f.querySelectorAll) return;
    var d = {};
    f.querySelectorAll('input,textarea,select').forEach(function (i) {
      var s = ((i.name || '') + ' ' + (i.id || '') + ' ' + (i.getAttribute('placeholder') || '')).toLowerCase();
      if (i.type === 'password' || i.type === 'hidden' && !/phone|tel/.test(s)) return;
      if (!d.phone && (i.type === 'tel' || /phone|sdt|sđt|tel|dien.?thoai|điện.?thoại|số/.test(s))) d.phone = i.value;
      else if (!d.email && (i.type === 'email' || /mail/.test(s))) d.email = i.value;
      else if (!d.name && /name|ten|tên|họ/.test(s)) d.name = i.value;
      else if (!d.message && (i.tagName === 'TEXTAREA' || /note|message|noi.?dung|nội.?dung|ghi.?chú|loi.?nhan/.test(s))) d.message = i.value;
    });
    sendLead(d);
  }, true);

  W.crmLead = sendLead;
})();
