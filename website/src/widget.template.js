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
        if (fields && fields.phone) { ss.set("hh_phone", fields.phone); if (fields.name) ss.set("hh_name", fields.name); }
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

    /* Bắt tên + SĐT từ MỌI form trên trang (LadiPage, WordPress, form tự viết…) rồi gửi bản sao về CRM; không chặn form gốc. */
    if (!window.__hhCapture) {
      window.__hhCapture = true;
      var nrm = function (v) {
        var p = String(v || "").replace(/[^\d+]/g, "");
        if (p.indexOf("+84") === 0) p = "0" + p.slice(3); else if (p.indexOf("84") === 0 && p.length === 11) p = "0" + p.slice(2);
        if (/^[35789]\d{8}$/.test(p)) p = "0" + p;
        return /^0(3|5|7|8|9)\d{8}$/.test(p) ? p : "";
      };
      var lbl = function (el) {
        var lb = el.id && document.querySelector("label[for='" + el.id + "']");
        return [el.name, el.id, el.placeholder, el.getAttribute("aria-label"), lb && lb.textContent].join(" ").toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/đ/g, "d");
      };
      var RP = /phone|tel|mobile|sdt|so dien thoai|dien thoai|zalo/, RE = /email|e-mail|mail/, RN = /name|ten|ho ten|fullname|ho va ten/, RS = /password|mat khau|captcha|token|nonce|website|honeypot|_wp|g-recaptcha/;
      document.addEventListener("submit", function (e) {
        try {
          var form = e.target;
          if (!form || form.tagName !== "FORM" || form.hasAttribute("data-hh-ignore")) return;
          var hp = form.querySelector("input[name=website]:not([type=url]), input[name*=honeypot]");
          if (hp && hp.value) return;
          var f = { name: "", phone: "", email: "", need: [] }, fields = form.querySelectorAll("input, select, textarea"), i, j;
          for (i = 0; i < fields.length; i++) {
            var el = fields[i], ty = (el.type || "").toLowerCase(), v = (el.value || "").trim();
            if (!v || /^(hidden|submit|button|file|password)$/.test(ty)) continue;
            if ((ty === "checkbox" || ty === "radio") && !el.checked) continue;
            var l = lbl(el);
            if (RS.test(l)) continue;
            if (!f.phone && (ty === "tel" || RP.test(l)) && nrm(v)) { f.phone = nrm(v); continue; }
            if (!f.email && (ty === "email" || RE.test(l)) && v.indexOf("@") > 0) { f.email = v; continue; }
            if (!f.name && ty !== "checkbox" && ty !== "radio" && el.tagName !== "SELECT" && el.tagName !== "TEXTAREA" && RN.test(l)) { f.name = v; continue; }
            if (v.length <= 300) f.need.push(v);
          }
          if (!f.phone) for (j = 0; j < fields.length; j++) { var pp = nrm(fields[j].value); if (pp && fields[j].type !== "hidden") { f.phone = pp; var raw = fields[j].value.trim(); f.need = f.need.filter(function (x) { return x !== raw; }); break; } }
          if (!f.phone) return;
          var key = "hh_sent_" + f.phone;
          if (Date.now() - (+ss.get(key) || 0) < 600000) return; // chống gửi trùng 10 phút (dùng chung với hh-connect.js)
          ss.set(key, String(Date.now()));
          window.__fc.sendLead({ name: f.name || "Khách web", phone: f.phone, email: f.email, need: f.need.join(" · ").slice(0, 200), source: "connect", project: form.getAttribute("data-hh-project") || PROJECT });
        } catch (err) { /* không để lỗi ảnh hưởng form gốc */ }
      }, true);
    }
    /* Báo về CRM khi khách bấm nút Gọi (tel:) hoặc Zalo – chỉ biết lượt bấm, không biết cuộc gọi có diễn ra. */
    (function () {
      var ssg = function (k) { try { return sessionStorage.getItem(k); } catch (e) { return null; } };
      var sid = ssg("hh_sid");
      if (!sid) { sid = Math.random().toString(36).slice(2, 12); try { sessionStorage.setItem("hh_sid", sid); } catch (e) { /* bỏ qua */ } }
      document.addEventListener("click", function (e) {
        try {
          var path = e.composedPath ? e.composedPath() : [e.target], a = null, i;
          for (i = 0; i < path.length; i++) if (path[i] && path[i].tagName === "A") { a = path[i]; break; }
          if (!a) return;
          var href = (a.getAttribute("href") || "").toLowerCase();
          var kind = /^tel:/.test(href) ? "call" : /zalo\.me|zalo\.vn|^zalo:/.test(href) ? "zalo" : "";
          var ep = window.__fc.CONFIG.leadEndpoint;
          if (!kind || !ep) return;
          var d = { action: "click", kind: kind, sid: sid, project: PROJECT, page: location.href, referrer: document.referrer, name: ssg("hh_name") || "", phone: ssg("hh_phone") || "" };
          var u = utm; for (var k in u) if (u.hasOwnProperty(k)) d[k] = u[k];
          var body = new URLSearchParams(d), ok = false;
          try { ok = navigator.sendBeacon && navigator.sendBeacon(ep, body); } catch (x) { ok = false; }
          if (!ok) { try { fetch(ep, { method: "POST", mode: "no-cors", keepalive: true, body: body }); } catch (x) { /* bỏ qua */ } }
          if (window.dataLayer) window.dataLayer.push({ event: "click_" + kind, project: d.project });
        } catch (err) { /* không ảnh hưởng nút */ }
      }, true);
    })();
/*__CHAT__*/
  }
  if (document.body) mount(); else document.addEventListener("DOMContentLoaded", mount);
})();
