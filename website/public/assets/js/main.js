/* =========================================================
   CẤU HÌNH – chỉ cần sửa khối này
   ========================================================= */
const CONFIG = {
  // Link Google Drive lấy từ data-drive của từng trang (cấu hình trong src/data.mjs)
  // URL Web App Google Apps Script (xem google-apps-script.gs). Để trống = không lưu lead.
  leadEndpoint: "",
  hotline: "0904 567 009",
  zalo: "0904567009",
  email: "tuvan@fpt-city.com",
  // Hạn ưu đãi thật (ISO, giờ VN). Để trống để ẩn đồng hồ đếm ngược.
  offerEndsAt: "",
  // Tự mở popup sau N giây (0 = tắt)
  popupDelaySeconds: 25,
};

(function () {
  "use strict";
  const $ = (s, el = document) => el.querySelector(s);
  const $$ = (s, el = document) => [...el.querySelectorAll(s)];
  const store = {
    get(k) { try { return localStorage.getItem(k); } catch (e) { return null; } },
    set(k, v) { try { localStorage.setItem(k, v); } catch (e) { /* bỏ qua */ } },
  };

  /* ---------- Thông tin liên hệ ---------- */
  const tel = CONFIG.hotline.replace(/[^\d+]/g, "");
  $$("[data-hotline]").forEach((el) => (el.textContent = CONFIG.hotline));
  $$("[data-hotline-link]").forEach((el) => (el.href = "tel:" + tel));
  $$("[data-zalo-link]").forEach((el) => (el.href = "https://zalo.me/" + CONFIG.zalo));
  $$("[data-email]").forEach((el) => (el.textContent = CONFIG.email));
  $$("[data-email-link]").forEach((el) => (el.href = "mailto:" + CONFIG.email));
  const project = document.body.dataset.project || "";
  $$("[data-drive-link]").forEach((el) => (el.href = document.body.dataset.drive || "#"));
  $$("[data-year]").forEach((el) => (el.textContent = new Date().getFullYear()));

  /* ---------- Header & menu ---------- */
  const header = $(".site-header");
  const onScroll = () => header.classList.toggle("scrolled", window.scrollY > 40);
  onScroll();
  window.addEventListener("scroll", onScroll, { passive: true });

  const toggle = $(".nav-toggle");
  const menu = $("#menu");
  const closeMenu = () => {
    menu.classList.remove("open");
    header.classList.remove("menu-open");
    toggle.setAttribute("aria-expanded", "false");
  };
  toggle.addEventListener("click", () => {
    const open = menu.classList.toggle("open");
    header.classList.toggle("menu-open", open);
    toggle.setAttribute("aria-expanded", String(open));
  });
  // Mobile: chạm lần đầu vào mục có menu con thì mở menu con
  $$(".dd-toggle").forEach((a) =>
    a.addEventListener("click", (e) => {
      const dd = a.parentElement;
      if (window.matchMedia("(max-width: 980px)").matches && !dd.classList.contains("open")) {
        e.preventDefault();
        e.stopImmediatePropagation();
        dd.classList.add("open");
      }
    })
  );
  $$("#menu a").forEach((a) => a.addEventListener("click", closeMenu));

  /* ---------- Hiệu ứng xuất hiện ---------- */
  if ("IntersectionObserver" in window) {
    const io = new IntersectionObserver((entries) => {
      entries.forEach((e) => {
        if (e.isIntersecting) { e.target.classList.add("in"); io.unobserve(e.target); }
      });
    }, { threshold: 0.12 });
    $$(".reveal").forEach((el) => io.observe(el));
  } else {
    $$(".reveal").forEach((el) => el.classList.add("in"));
  }

  /* ---------- Đếm số nổi bật (181+ ha, 1.395, ~952 tr USD…) ---------- */
  const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  const counters = $$(".stats b").map((el) => {
    const m = el.textContent.match(/^([~]?)([\d.]+)(.*)$/);
    if (!m || /^[–/]/.test(m[3])) return null; // bỏ qua "1–3PN", "Q2/2027", chữ
    const target = parseInt(m[2].replace(/\./g, ""), 10);
    if (!target || (target >= 1900 && target <= 2100 && !m[3])) return null; // bỏ qua năm
    return { el, pre: m[1], target, post: m[3], text: el.textContent };
  }).filter(Boolean);
  const fmt = (n) => n.toLocaleString("vi-VN");
  function runCounter(c) {
    const start = performance.now();
    const dur = 1600;
    const step = (t) => {
      const k = Math.min(1, (t - start) / dur);
      const eased = 1 - Math.pow(1 - k, 3);
      c.el.textContent = c.pre + fmt(Math.round(c.target * eased)) + c.post;
      if (k < 1) requestAnimationFrame(step); else c.el.textContent = c.text;
    };
    requestAnimationFrame(step);
  }
  if (counters.length && !reduceMotion && "IntersectionObserver" in window) {
    counters.forEach((c) => (c.el.textContent = c.pre + "0" + c.post));
    const co = new IntersectionObserver((entries) => {
      entries.forEach((e) => {
        if (!e.isIntersecting) return;
        counters.filter((c) => e.target.contains(c.el)).forEach(runCounter);
        co.unobserve(e.target);
      });
    }, { threshold: 0.4 });
    $$(".stats").forEach((s) => co.observe(s));
  }

  /* ---------- Popup ---------- */
  const modal = $("#lead-modal");
  const modalBody = $(".modal-body", modal);
  const modalSuccess = $(".modal-success", modal);
  const canDialog = typeof modal.showModal === "function";

  function showSuccess(name) {
    $("[data-success-name]", modal).textContent = name || "bạn";
    modalBody.hidden = true;
    modalSuccess.hidden = false;
    openModal(true);
  }
  function openModal(keepState) {
    if (!keepState && store.get("fc_lead")) {
      // Khách đã đăng ký: hiển thị lại link tài liệu
      modalBody.hidden = true;
      modalSuccess.hidden = false;
      $("[data-success-name]", modal).textContent = store.get("fc_name") || "bạn";
    } else if (!keepState) {
      modalBody.hidden = false;
      modalSuccess.hidden = true;
    }
    if (canDialog && !modal.open) modal.showModal();
    else if (!canDialog) modal.setAttribute("open", "");
  }
  function closeModal() {
    if (canDialog) modal.close(); else modal.removeAttribute("open");
  }

  $$("[data-open-form]").forEach((el) =>
    el.addEventListener("click", (e) => {
      e.preventDefault();
      const interest = el.getAttribute("data-interest");
      if (interest) {
        const sel = $("select[name=need]", modal);
        const opt = [...sel.options].find((o) => o.text.includes(interest));
        if (opt) sel.value = opt.value;
      }
      closeMenu();
      openModal(false);
      track("open_form", { interest: interest || "" });
    })
  );
  $("[data-close]", modal).addEventListener("click", closeModal);
  modal.addEventListener("click", (e) => { if (e.target === modal) closeModal(); });

  if (CONFIG.popupDelaySeconds > 0 && !store.get("fc_lead") && !sessionFlag()) {
    setTimeout(() => {
      if (!document.querySelector("dialog[open]")) { openModal(false); markSession(); }
    }, CONFIG.popupDelaySeconds * 1000);
  }
  function sessionFlag() { try { return sessionStorage.getItem("fc_popup"); } catch (e) { return null; } }
  function markSession() { try { sessionStorage.setItem("fc_popup", "1"); } catch (e) { /* bỏ qua */ } }

  /* ---------- Form & gửi lead ---------- */
  const params = new URLSearchParams(location.search);
  const utm = {};
  ["utm_source", "utm_medium", "utm_campaign", "utm_term", "utm_content", "gclid", "fbclid"].forEach((k) => {
    if (params.get(k)) utm[k] = params.get(k);
  });

  const PHONE_RE = /^(0|\+84)(3|5|7|8|9)\d{8}$/;

  function setError(input, msg) {
    const field = input.closest(".field");
    let err = $(".err", field);
    if (!msg) { field.classList.remove("invalid"); if (err) err.remove(); return; }
    field.classList.add("invalid");
    if (!err) { err = document.createElement("span"); err.className = "err"; field.appendChild(err); }
    err.textContent = msg;
  }

  function validate(form) {
    let ok = true;
    const name = form.elements.name;
    const phone = form.elements.phone;
    const email = form.elements.email;
    if (name.value.trim().length < 2) { setError(name, "Vui lòng nhập họ tên"); ok = false; } else setError(name);
    const p = phone.value.replace(/[\s.-]/g, "");
    if (!PHONE_RE.test(p)) { setError(phone, "Số điện thoại chưa đúng (VD: 0905 123 456)"); ok = false; } else setError(phone);
    if (email && email.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) { setError(email, "Email chưa đúng"); ok = false; } else if (email) setError(email);
    return ok;
  }

  async function getIp() {
    try {
      const ctrl = new AbortController();
      const t = setTimeout(() => ctrl.abort(), 1500);
      const r = await fetch("https://api.ipify.org?format=json", { signal: ctrl.signal });
      clearTimeout(t);
      return (await r.json()).ip || "";
    } catch (e) { return ""; }
  }

  async function sendLead(data) {
    if (!CONFIG.leadEndpoint) return;
    data.ip = await getIp();
    const body = new URLSearchParams(data);
    // no-cors: Apps Script không trả header CORS, request vẫn được ghi nhận
    await fetch(CONFIG.leadEndpoint, { method: "POST", mode: "no-cors", body });
  }

  $$(".lead-form").forEach((form) => {
    form.addEventListener("submit", async (e) => {
      e.preventDefault();
      if (form.elements.website && form.elements.website.value) return; // honeypot
      if (!validate(form)) return;
      const btn = $("button[type=submit]", form);
      const label = btn.textContent;
      btn.disabled = true;
      btn.textContent = "Đang gửi...";
      const data = {
        name: form.elements.name.value.trim(),
        phone: form.elements.phone.value.replace(/[\s.-]/g, ""),
        email: form.elements.email ? form.elements.email.value.trim() : "",
        need: form.elements.need ? form.elements.need.value : "",
        project,
        source: form.dataset.source || "",
        page: location.href,
        referrer: document.referrer,
        time: new Date().toISOString(),
        ...utm,
      };
      try { await sendLead(data); } catch (err) { console.warn("Không gửi được lead:", err); }
      store.set("fc_lead", "1");
      store.set("fc_name", data.name);
      track("generate_lead", { form: data.source, need: data.need, project });
      btn.disabled = false;
      btn.textContent = label;
      form.reset();
      showSuccess(data.name);
    });
    $$("input", form).forEach((i) => i.addEventListener("input", () => setError(i)));
  });

  /* ---------- Đếm ngược ưu đãi (chỉ khi có hạn thật) ---------- */
  const cd = $("[data-countdown]");
  const end = CONFIG.offerEndsAt ? new Date(CONFIG.offerEndsAt).getTime() : NaN;
  if (cd && !isNaN(end) && end > Date.now()) {
    cd.hidden = false;
    $("[data-countdown-label]").hidden = false;
    const pad = (n) => String(n).padStart(2, "0");
    const tick = () => {
      const diff = Math.max(0, end - Date.now());
      $("[data-d]", cd).textContent = pad(Math.floor(diff / 864e5));
      $("[data-h]", cd).textContent = pad(Math.floor((diff / 36e5) % 24));
      $("[data-m]", cd).textContent = pad(Math.floor((diff / 6e4) % 60));
      $("[data-s]", cd).textContent = pad(Math.floor((diff / 1e3) % 60));
      if (diff === 0) clearInterval(timer);
    };
    tick();
    const timer = setInterval(tick, 1000);
  }

  /* ---------- Tracking (GA4 / GTM / Meta Pixel nếu có) ---------- */
  function track(event, props) {
    if (window.dataLayer) window.dataLayer.push({ event, ...props });
    if (window.gtag) window.gtag("event", event, props);
    if (window.fbq && event === "generate_lead") window.fbq("track", "Lead", props);
  }
})();
