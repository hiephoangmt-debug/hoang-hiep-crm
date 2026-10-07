// Cấu hình: thay bằng URL nhận lead thật (Google Apps Script, webhook CRM, LadiWork...)
const FORM_ENDPOINT = "";

document.querySelectorAll("form.lead").forEach((form) => {
  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    const msg = form.querySelector(".form-msg");
    const data = Object.fromEntries(new FormData(form));
    data.page = location.pathname;
    data.time = new Date().toISOString();

    if (!/^(0|\+84)\d{9,10}$/.test((data.phone || "").replace(/\s/g, ""))) {
      msg.textContent = "Vui lòng nhập số điện thoại hợp lệ.";
      return;
    }

    try {
      if (FORM_ENDPOINT) {
        await fetch(FORM_ENDPOINT, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(data),
        });
      }
      msg.textContent = "Cảm ơn anh/chị! Chuyên viên sẽ liên hệ trong ít phút.";
      form.reset();
    } catch {
      msg.textContent = "Gửi chưa thành công, vui lòng gọi hotline.";
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
  }, { threshold: 0.15 });
  document.querySelectorAll(".reveal,[data-count]").forEach((el) => io.observe(el));
} else {
  document.querySelectorAll(".reveal").forEach((el) => el.classList.add("in"));
}

// Simple lightbox for the gallery
const lb = document.querySelector(".lightbox");
if (lb) {
  const img = lb.querySelector("img");
  document.querySelectorAll(".gallery a").forEach((a) =>
    a.addEventListener("click", (e) => {
      e.preventDefault();
      img.src = a.href;
      img.alt = a.querySelector("img").alt;
      lb.classList.add("open");
    })
  );
  const close = () => lb.classList.remove("open");
  lb.addEventListener("click", (e) => e.target !== img && close());
  addEventListener("keydown", (e) => e.key === "Escape" && close());
}
