/*!
 * hh-connect.js – nối form của bất kỳ website nào (hoanghiepmt.com, LadiPage, WordPress…) với Hoàng Hiệp CRM.
 *
 * Dán trước </body>:
 *   <script src="https://fpt-city.com/assets/js/hh-connect.js"
 *           data-endpoint="https://script.google.com/macros/s/XXXX/exec"
 *           data-project="Hoàng Hiệp"            (tên dự án/nguồn ghi vào CRM; mặc định = tên miền)
 *           data-buttons="true"                   (tuỳ chọn: hiện nút Gọi/Zalo bên phải)
 *           data-hotline="0904567009" data-zalo="0904567009" defer></script>
 *
 * Cách hoạt động: khi khách gửi một form có ô số điện thoại, script đọc tên/SĐT/email/nội dung,
 * gửi bản sao về CRM rồi để form gốc chạy bình thường (không chặn, không đổi giao diện).
 */
(function () {
  "use strict";
  var me = document.currentScript || document.querySelector("script[src*='hh-connect']");
  if (!me) return;
  var cfg = {
    endpoint: me.getAttribute("data-endpoint") || "",
    project: me.getAttribute("data-project") || location.hostname.replace(/^www\./, ""),
    buttons: me.getAttribute("data-buttons") === "true",
    hotline: (me.getAttribute("data-hotline") || "").replace(/[^\d+]/g, ""),
    zalo: (me.getAttribute("data-zalo") || "").replace(/[^\d]/g, ""),
  };
  var ss = {
    get: function (k) { try { return sessionStorage.getItem(k); } catch (e) { return null; } },
    set: function (k, v) { try { sessionStorage.setItem(k, v); } catch (e) { /* bỏ qua */ } },
  };

  // Giữ UTM / gclid của lượt truy cập đầu để gắn vào khách dù họ điền form ở trang khác
  var KEYS = ["utm_source", "utm_medium", "utm_campaign", "utm_term", "utm_content", "gclid", "fbclid"];
  var qs = new URLSearchParams(location.search);
  var utm = {};
  try { utm = JSON.parse(ss.get("hh_utm") || "{}"); } catch (e) { utm = {}; }
  KEYS.forEach(function (k) { if (qs.get(k)) utm[k] = qs.get(k); });
  if (!utm.referrer && document.referrer && document.referrer.indexOf(location.hostname) < 0) utm.referrer = document.referrer;
  ss.set("hh_utm", JSON.stringify(utm));

  function normPhone(v) {
    var p = String(v || "").replace(/[^\d+]/g, "");
    if (p.indexOf("+84") === 0) p = "0" + p.slice(3);
    else if (p.indexOf("84") === 0 && p.length === 11) p = "0" + p.slice(2);
    if (/^[35789]\d{8}$/.test(p)) p = "0" + p;
    return /^0(3|5|7|8|9)\d{8}$/.test(p) ? p : "";
  }
  function label(el) {
    var lb = el.id && document.querySelector("label[for='" + el.id + "']");
    return [el.name, el.id, el.placeholder, el.getAttribute("aria-label"), lb && lb.textContent].join(" ").toLowerCase()
      .normalize("NFD").replace(/[̀-ͯ]/g, "").replace(/đ/g, "d");
  }
  var RE = {
    phone: /phone|tel|mobile|sdt|so dien thoai|dien thoai|zalo/,
    email: /email|e-mail|mail/,
    name: /name|ten|ho ten|fullname|ho va ten/,
    skip: /password|mat khau|captcha|token|nonce|website|honeypot|_wp|g-recaptcha/,
  };

  function readForm(form) {
    var out = { name: "", phone: "", email: "", need: [] };
    var fields = form.querySelectorAll("input, select, textarea");
    for (var i = 0; i < fields.length; i++) {
      var el = fields[i], type = (el.type || "").toLowerCase(), val = (el.value || "").trim();
      if (!val || type === "hidden" || type === "submit" || type === "button" || type === "file" || type === "password") continue;
      if ((type === "checkbox" || type === "radio") && !el.checked) continue;
      var l = label(el);
      if (RE.skip.test(l)) continue;
      if (!out.phone && (type === "tel" || RE.phone.test(l)) && normPhone(val)) { out.phone = normPhone(val); continue; }
      if (!out.email && (type === "email" || RE.email.test(l)) && val.indexOf("@") > 0) { out.email = val; continue; }
      if (!out.name && type !== "checkbox" && type !== "radio" && el.tagName !== "SELECT" && el.tagName !== "TEXTAREA" && RE.name.test(l)) { out.name = val; continue; }
      if (val.length <= 300) out.need.push(val);
    }
    // form không đặt tên ô SĐT rõ ràng: thử tìm số hợp lệ trong mọi ô
    if (!out.phone) for (var j = 0; j < fields.length; j++) {
      var p = normPhone(fields[j].value);
      if (p && fields[j].type !== "hidden") { out.phone = p; var raw = fields[j].value.trim(); out.need = out.need.filter(function (v) { return v !== raw; }); break; }
    }
    return out;
  }

  function send(data) {
    if (!cfg.endpoint) { console.warn("[hh-connect] Chưa cấu hình data-endpoint"); return; }
    var body = new URLSearchParams(data);
    var ok = false;
    try { ok = navigator.sendBeacon && navigator.sendBeacon(cfg.endpoint, body); } catch (e) { ok = false; }
    if (!ok) { try { fetch(cfg.endpoint, { method: "POST", mode: "no-cors", keepalive: true, body: body }); } catch (e) { /* bỏ qua */ } }
  }

  document.addEventListener("submit", function (e) {
    var form = e.target;
    if (!form || form.tagName !== "FORM" || form.hasAttribute("data-hh-ignore")) return;
    var hp = form.querySelector("input[name=website]:not([type=url]), input[name*=honeypot]");
    if (hp && hp.value) return;
    var f = readForm(form);
    if (!f.phone) return;
    var key = "hh_sent_" + f.phone;
    var last = +(ss.get(key) || 0);
    if (Date.now() - last < 10 * 60 * 1000) return; // tránh gửi trùng khi form submit nhiều lần
    ss.set(key, String(Date.now()));
    var data = {
      name: f.name || "Khách web", phone: f.phone, email: f.email, need: f.need.join(" · ").slice(0, 200),
      project: form.getAttribute("data-hh-project") || cfg.project,
      source: "connect", page: location.href, referrer: utm.referrer || document.referrer,
      time: new Date().toISOString(),
    };
    KEYS.forEach(function (k) { if (utm[k]) data[k] = utm[k]; });
    send(data);
    if (window.dataLayer) window.dataLayer.push({ event: "generate_lead", form: "hh-connect", project: data.project });
  }, true);

  // Tuỳ chọn: nút Gọi / Zalo cố định bên phải
  if (cfg.buttons && (cfg.hotline || cfg.zalo)) {
    var css = ".hh-fabs{position:fixed;right:16px;bottom:24px;z-index:2147483000;display:grid;gap:10px}" +
      ".hh-fab{width:54px;height:54px;border-radius:50%;display:grid;place-items:center;color:#fff;font:800 13px/1 system-ui,sans-serif;text-decoration:none;box-shadow:0 10px 24px rgba(0,0,0,.25)}" +
      ".hh-call{background:#e4572e;font-size:22px;animation:hhring 1.8s infinite}.hh-zalo{background:#0068ff}" +
      "@keyframes hhring{0%,50%,100%{transform:rotate(0)}10%,30%{transform:rotate(-12deg)}20%,40%{transform:rotate(12deg)}}" +
      "@media (prefers-reduced-motion:reduce){.hh-call{animation:none}}";
    var st = document.createElement("style"); st.textContent = css; document.head.appendChild(st);
    var wrap = document.createElement("div"); wrap.className = "hh-fabs";
    if (cfg.zalo) wrap.innerHTML += '<a class="hh-fab hh-zalo" href="https://zalo.me/' + cfg.zalo + '" target="_blank" rel="noopener" aria-label="Nhắn Zalo">Zalo</a>';
    if (cfg.hotline) wrap.innerHTML += '<a class="hh-fab hh-call" href="tel:' + cfg.hotline + '" aria-label="Gọi hotline">📞</a>';
    document.body.appendChild(wrap);
  }
})();
