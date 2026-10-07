// URL nhận khách hàng (Google Apps Script Web App, webhook CRM...).
// Hướng dẫn tạo: tools/cora-tower/google-apps-script.gs
const FORM_ENDPOINT = "";

// Gửi thông tin khách về FORM_ENDPOINT. Dùng chung cho form và chat.
window.submitLead = async (data) => {
  const payload = { ...data, page: location.href, time: new Date().toISOString() };
  if (!FORM_ENDPOINT) return false;
  // text/plain + no-cors: Apps Script nhận được mà không cần CORS preflight
  await fetch(FORM_ENDPOINT, {
    method: "POST",
    mode: "no-cors",
    headers: { "Content-Type": "text/plain;charset=utf-8" },
    body: JSON.stringify(payload),
  });
  return true;
};
window.isPhone = (s) => /^(0|\+?84)(3|5|7|8|9)\d{8}$/.test((s || "").replace(/[\s.\-()]/g, ""));

document.querySelectorAll("form.lead").forEach((form) => {
  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    const msg = form.querySelector(".form-msg");
    const data = Object.fromEntries(new FormData(form));
    if (!isPhone(data.phone)) {
      msg.textContent = "Vui lòng nhập số điện thoại hợp lệ.";
      return;
    }
    try {
      await submitLead({ ...data, source: "form" });
      msg.textContent = "Cảm ơn anh/chị! Chuyên viên sẽ gọi/Zalo lại trong ít phút.";
      form.reset();
    } catch {
      msg.textContent = `Gửi chưa thành công, vui lòng gọi ${window.CORA?.telText || "hotline"}.`;
    }
  });
});

// Header shadow on scroll
const head = document.querySelector(".site-head");
const onScroll = () => head && head.classList.toggle("scrolled", scrollY > 10);
addEventListener("scroll", onScroll, { passive: true });
onScroll();

// Reveal sections + count-up numbers when they enter the viewport
const countUp = (el) => {
  const target = parseFloat(el.dataset.count);
  const fmt = (n) => Math.round(n).toLocaleString("vi-VN");
  const t0 = performance.now();
  const tick = (t) => {
    const p = Math.min(1, (t - t0) / 1400);
    el.textContent = fmt(target * (1 - Math.pow(1 - p, 3))) + (el.dataset.suffix || "");
    if (p < 1) requestAnimationFrame(tick);
  };
  requestAnimationFrame(tick);
};
if ("IntersectionObserver" in window) {
  const io = new IntersectionObserver((entries) => {
    entries.forEach((e) => {
      if (!e.isIntersecting) return;
      e.target.classList.add("in");
      if (e.target.dataset.count) countUp(e.target);
      io.unobserve(e.target);
    });
  }, { threshold: 0.12 });
  document.querySelectorAll(".reveal,[data-count]").forEach((el) => io.observe(el));
} else {
  document.querySelectorAll(".reveal").forEach((el) => el.classList.add("in"));
}

// Floor-plan tabs
document.querySelectorAll(".tabs").forEach((tabs) => {
  const buttons = tabs.querySelectorAll("[data-tab]");
  buttons.forEach((b) =>
    b.addEventListener("click", () => {
      buttons.forEach((x) => {
        x.setAttribute("aria-selected", x === b);
        document.getElementById(x.dataset.tab).hidden = x !== b;
      });
    })
  );
});

// Lightbox for gallery + zoomable images (floor plans etc.)
let lb = document.querySelector(".lightbox");
if (!lb) {
  lb = document.createElement("div");
  lb.className = "lightbox";
  lb.setAttribute("role", "dialog");
  lb.innerHTML = '<button type="button" aria-label="Đóng">×</button><img alt="">';
  document.body.appendChild(lb);
}
const lbImg = lb.querySelector("img");
document.querySelectorAll(".gallery a, a.zoom-link").forEach((a) =>
  a.addEventListener("click", (e) => {
    e.preventDefault();
    lbImg.src = a.href;
    lbImg.alt = a.querySelector("img")?.alt || "";
    lb.classList.add("open");
  })
);
const closeLb = () => lb.classList.remove("open");
lb.addEventListener("click", (e) => e.target !== lbImg && closeLb());
addEventListener("keydown", (e) => e.key === "Escape" && closeLb());
