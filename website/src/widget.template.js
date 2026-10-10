/*!
 * fc-widget.js – cụm nút Chat tự động · Zalo · Gọi (góc dưới bên phải) cho mọi website/landing page.
 * Dán trước </body>:
 *   <script src="…/fc-widget.js" data-endpoint="LINK_/exec_CỦA_CRM" defer></script>
 * Tuỳ chọn: data-hotline, data-zalo, data-project, data-drive, data-ai="false", data-teaser="12" (giây; 0 = tắt), data-site.
 * Giao diện nằm trong Shadow DOM nên không bị CSS của trang làm hỏng. File sinh bởi src/build-widget.mjs.
 */
(function () {
  "use strict";
  var me = document.currentScript;
  if (window.__fcwLoaded) { // nạp lần 2 (VD: thẻ trong HTML + mã tuỳ chỉnh có data-endpoint): chỉ nhận thêm đường dẫn CRM
    var ep0 = me && me.getAttribute("data-endpoint");
    if (ep0) { window.__fcwEndpoint = ep0; if (window.__fc) window.__fc.CONFIG.leadEndpoint = ep0; }
    return;
  }
  window.__fcwLoaded = true;
  var A = function (n, d) { return (me && me.getAttribute("data-" + n)) || d; };
  var C = { endpoint: window.__fcwEndpoint || A("endpoint", ""), hotline: A("hotline", "0904 567 009"), zalo: A("zalo", "0904567009"), ai: A("ai", "true") !== "false", teaser: +A("teaser", "12") || 0, site: A("site", "https://www.fpt-city.com") };
  var KB = /*__KB__*/null;
  var DRIVES = /*__DRIVES__*/{};
  var IMG = /*__IMG__*/"";
  var CSS = /*__CSS__*/"";
  var HTML = /*__HTML__*/"";

  function project() {
    var p = location.pathname.toLowerCase(), m;
    if (A("project", "")) return A("project", "");
    if ((m = p.match(/fpt-plaza-?(\d)/))) return "FPT Plaza " + m[1];
    if ((m = p.match(/phan-khu-v(\d)/))) return "Đất nền FPT City V" + m[1];
    if (/dat-nen/.test(p)) return "Đất nền FPT City";
    if (/fpt-city\.com$/.test(location.hostname)) return "FPT City";
    return location.hostname.replace(/^www\./, "");
  }
  var PROJECT = project();
  var DRIVE = A("drive", "") || DRIVES[PROJECT] || "";
  var tel = C.hotline.replace(/[^\d+]/g, "");

  var ss = {
    get: function (k) { try { return sessionStorage.getItem(k); } catch (e) { return null; } },
    set: function (k, v) { try { sessionStorage.setItem(k, v); } catch (e) { /* bỏ qua */ } },
  };
  var KEYS = ["utm_source", "utm_medium", "utm_campaign", "utm_term", "utm_content", "gclid", "fbclid"];
  var utm = {};
  try { utm = JSON.parse(ss.get("hh_utm") || "{}"); } catch (e) { utm = {}; }
  var qs = new URLSearchParams(location.search);
  KEYS.forEach(function (k) { if (qs.get(k)) utm[k] = qs.get(k); });
  if (!utm.referrer && document.referrer && document.referrer.indexOf(location.hostname) < 0) utm.referrer = document.referrer;
  ss.set("hh_utm", JSON.stringify(utm));

  function getIp() {
    return new Promise(function (resolve) {
      var t = setTimeout(function () { resolve(""); }, 1500);
      try {
        fetch("https://api.ipify.org?format=json").then(function (r) { return r.json(); }).then(function (d) { clearTimeout(t); resolve(d.ip || ""); }).catch(function () { clearTimeout(t); resolve(""); });
      } catch (e) { clearTimeout(t); resolve(""); }
    });
  }
  function track(event, props) {
    try {
      if (window.dataLayer) window.dataLayer.push(Object.assign({ event: event }, props));
      if (window.gtag) window.gtag("event", event, props);
      if (window.fbq && event === "generate_lead") window.fbq("track", "Lead", props);
    } catch (e) { /* bỏ qua */ }
  }
  function fix(h) {
    if (!h) return h;
    if (h.indexOf("/assets/img/") === 0) return IMG + h.slice("/assets/img/".length);
    if (h.charAt(0) === "/") return C.site + h.replace(/\/(?=#|$)/, "");
    return h;
  }

  function mount() {
    document.querySelectorAll(".fabs").forEach(function (e) { e.remove(); }); // bỏ nút Zalo/Gọi tĩnh của trang (widget thay thế)
    setTimeout(function () { document.querySelectorAll(".fabs").forEach(function (e) { e.remove(); }); }, 1500);

    var host = document.createElement("div");
    host.id = "fc-widget";
    document.body.appendChild(host);
    var root = host.attachShadow({ mode: "open" });
    root.innerHTML = "<style>" + CSS + "</style>" + HTML;
    root.querySelectorAll("[data-hotline-link]").forEach(function (a) { a.href = "tel:" + tel; });
    root.querySelectorAll("[data-hotline]").forEach(function (s) { s.textContent = C.hotline; });
    root.querySelectorAll("[data-zalo-link]").forEach(function (a) { a.href = "https://zalo.me/" + C.zalo.replace(/\D/g, ""); });
    window.__fcRoot = root;

    window.__fc = {
      CONFIG: { leadEndpoint: window.__fcwEndpoint || C.endpoint, chatAI: C.ai, chatTeaserSeconds: C.teaser },
      project: PROJECT, hasDrive: /^https:\/\/drive\.google\.com\//.test(DRIVE), drive: DRIVE, kb: KB, fix: fix, track: track,
      openForm: function (unit) {
        var closer = root.querySelector("[data-chat-close]"); if (closer) closer.click();
        var code = (String(unit || "").match(/[NS]-\d{2}\.\d{1,2}A?/) || [])[0];
        var field = document.querySelector('input[name="unit"]');
        if (field && code) field.value = code;
        var target = document.getElementById("dang-ky") || document.querySelector("form");
        if (!target) { window.open("https://zalo.me/" + C.zalo.replace(/\D/g, ""), "_blank"); return; }
        target.scrollIntoView({ behavior: "smooth", block: "center" });
        var first = target.querySelector("input");
        setTimeout(function () { if (first) try { first.focus({ preventScroll: true }); } catch (e) { first.focus(); } }, 700);
      },
      sendLead: function (fields) {
        var data = Object.assign({ email: "", need: "", project: PROJECT, page: location.href, referrer: document.referrer, time: new Date().toISOString() }, utm, fields);
        track("generate_lead", { form: data.source, need: data.need, project: data.project });
        var ep = window.__fc.CONFIG.leadEndpoint;
        if (!ep) return Promise.resolve();
        return getIp().then(function (ip) {
          data.ip = ip;
          var body = new URLSearchParams(data);
          try { if (navigator.sendBeacon && navigator.sendBeacon(ep, body)) return; } catch (e) { /* thử fetch */ }
          return fetch(ep, { method: "POST", mode: "no-cors", keepalive: true, body: body });
        });
      },
    };
/*__CHAT__*/
  }
  if (document.body) mount(); else document.addEventListener("DOMContentLoaded", mount);
})();
