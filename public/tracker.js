/*!
 * Hoàng Hiệp CRM – tracker gắn vào website (hiephoangmt.com, hoanggiaminh.com, WordPress...).
 * Tự ghi nhận: link trang khách điền form, trang khách vào đầu tiên, nguồn (Google/Facebook/UTM), thời gian.
 * Cách gắn (trước </body>):
 *   <script src="https://CRM-CUA-BAN/tracker.js" data-key="WEBHOOK_KEY" async></script>
 * Gửi thủ công (form tự viết bằng JS):  window.HHCRM.send({ name: '...', phone: '...', message: '...' })
 */
(function () {
  var script = document.currentScript || document.querySelector('script[src*="tracker.js"][data-key]');
  if (!script) return;
  var key = script.getAttribute('data-key');
  var origin = new URL(script.src, location.href).origin;
  var endpoint = origin + '/api/hook/lead?key=' + encodeURIComponent(key);
  var source = script.getAttribute('data-source') || location.hostname.replace(/^www\./, '');
  var STORE = 'hhcrm_touch';
  var TRACK = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term', 'gclid', 'fbclid'];

  function read() {
    try { return JSON.parse(localStorage.getItem(STORE)) || {}; } catch (e) { return {}; }
  }
  function write(v) {
    try { localStorage.setItem(STORE, JSON.stringify(v)); } catch (e) { /* chế độ ẩn danh */ }
  }

  // Ghi nhận lượt vào trang: lần đầu (first touch) + lần gần nhất có nguồn (last touch)
  var params = new URLSearchParams(location.search);
  var touch = read();
  var hasCampaign = TRACK.some(function (k) { return params.get(k); });
  var externalRef = document.referrer && new URL(document.referrer).hostname !== location.hostname ? document.referrer : '';
  var now = new Date().toISOString();
  var visit = { url: location.href, referrer: externalRef, at: now };
  TRACK.forEach(function (k) { if (params.get(k)) visit[k] = params.get(k); });
  if (!touch.first) touch.first = visit;
  if (hasCampaign || externalRef || !touch.last) touch.last = visit;
  touch.pages = (touch.pages || 0) + 1;
  write(touch);

  function payload(extra) {
    var t = read();
    var last = t.last || {};
    var data = {
      url: location.href,
      page_title: document.title,
      referrer: last.referrer || (t.first && t.first.referrer) || '',
      first_landing: t.first ? t.first.url : '',
      first_visit_at: t.first ? t.first.at : '',
      pages_viewed: t.pages || 1,
      source: source,
    };
    TRACK.forEach(function (k) {
      var v = last[k] || (t.first && t.first[k]);
      if (v) data[k] = v;
    });
    for (var k in extra) if (Object.prototype.hasOwnProperty.call(extra, k)) data[k] = extra[k];
    return data;
  }

  function send(extra) {
    var body = JSON.stringify(payload(extra || {}));
    try {
      // text/plain => không cần preflight CORS; keepalive => vẫn gửi khi trang chuyển hướng
      return fetch(endpoint, { method: 'POST', body: body, keepalive: true, headers: { 'content-type': 'text/plain' } });
    } catch (e) {
      if (navigator.sendBeacon) navigator.sendBeacon(endpoint, body);
    }
  }

  var PHONE_RE = /(\+?84|0)[\s.\-]?\d{2,3}[\s.\-]?\d{3}[\s.\-]?\d{3,4}/;
  var lastSent = {};

  document.addEventListener('submit', function (ev) {
    var form = ev.target;
    if (!form || form.tagName !== 'FORM' || form.hasAttribute('data-crm-ignore')) return;
    var fields = {};
    var hasPhone = false;
    Array.prototype.forEach.call(form.elements, function (el) {
      if (!el.name || el.disabled || el.type === 'password' || el.type === 'hidden' && /nonce|token|captcha/i.test(el.name)) return;
      if ((el.type === 'checkbox' || el.type === 'radio') && !el.checked) return;
      if (el.type === 'file' || el.type === 'submit') return;
      var v = String(el.value || '').trim();
      if (!v) return;
      fields[el.name] = fields[el.name] ? fields[el.name] + ', ' + v : v;
      if (el.type === 'tel' || PHONE_RE.test(v)) hasPhone = true;
    });
    if (!hasPhone && !Object.keys(fields).some(function (k) { return /mail/i.test(k); })) return;
    var sig = JSON.stringify(fields);
    if (lastSent[sig] && Date.now() - lastSent[sig] < 10000) return;
    lastSent[sig] = Date.now();
    fields.form_name = form.getAttribute('name') || form.id || form.getAttribute('data-form-name') || '';
    send(fields);
  }, true);

  window.HHCRM = { send: send };
})();
