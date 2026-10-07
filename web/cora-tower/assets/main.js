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
