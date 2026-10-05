/* ===== CẤU HÌNH LIÊN HỆ – chỉ cần sửa ở đây ===== */
var CONFIG = {
  phone: "0909669325",            // Số điện thoại / Zalo (viết liền)
  phoneText: "0909 669 325",      // Cách hiển thị
  address: "Phục vụ tận nơi toàn TP"
};
/* ================================================= */
(function(){
  var zalo = "https://zalo.me/" + CONFIG.phone, tel = "tel:" + CONFIG.phone;
  document.querySelectorAll("[data-zalo]").forEach(function(a){ a.href = zalo; a.target = "_blank"; a.rel = "noopener";
    a.addEventListener("click", function(){ if (window.gtag) gtag("event","click_zalo"); if (window.fbq) fbq("track","Contact"); }); });
  document.querySelectorAll("[data-tel]").forEach(function(a){ a.href = tel;
    a.addEventListener("click", function(){ if (window.gtag) gtag("event","click_call"); }); });
  document.querySelectorAll("[data-phone-text]").forEach(function(s){ s.textContent = CONFIG.phoneText; });
  document.querySelectorAll("[data-address]").forEach(function(s){ s.textContent = CONFIG.address; });
  var yr = document.getElementById("yr"); if (yr) yr.textContent = new Date().getFullYear();

  // Online status theo giờ mở cửa (giờ Việt Nam, 7h30 – 21h00)
  var vn = new Date(Date.now() + (new Date().getTimezoneOffset() + 420) * 60000), m = vn.getHours() * 60 + vn.getMinutes();
  var pad = function(n){ return (n < 10 ? "0" : "") + n; }, today = vn.getFullYear() + "-" + pad(vn.getMonth() + 1) + "-" + pad(vn.getDate());
  var st = document.getElementById("status");
  if (st && (m < 450 || m >= 1260)) { st.classList.add("off");
    st.lastElementChild.textContent = "Ngoài giờ – nhắn Zalo, sáng 7h30 trả lời ngay"; }

  // Quick quote form -> Zalo
  var due = document.getElementById("dueDate"), dueMsg = document.getElementById("dueMsg");
  if (due) {
  due.min = today;
  due.addEventListener("change", function(){
    if (!due.value) { dueMsg.textContent = ""; return; }
    var d = Math.round((new Date(due.value + "T00:00:00") - new Date(today + "T00:00:00")) / 864e5);
    dueMsg.className = "due " + (d <= 3 ? "urgent" : "ok");
    dueMsg.textContent = d <= 0 ? "⚠️ Đến hạn HÔM NAY – nhắn ngay để kịp xử lý!" : d <= 3 ? "⚠️ Còn " + d + " ngày – nên xử lý sớm để tránh phạt." : "✓ Còn " + d + " ngày – đặt lịch trước để được ưu tiên.";
  });
  document.getElementById("qsend").addEventListener("click", function(){
    var svc = document.querySelector("input[name=svc]:checked").value, amt = document.getElementById("amt").value;
    var txt = "Chào shop, mình cần " + svc.toLowerCase() + " " + document.getElementById("bank").value +
      (amt ? ", số tiền " + amt + " triệu" : "") + (due.value ? ", đến hạn ngày " + due.value.split("-").reverse().join("/") : "") + ". Báo phí giúp mình nhé!";
    try { navigator.clipboard.writeText(txt); document.getElementById("qhint").textContent = "✓ Đã sao chép tin nhắn – dán vào Zalo và gửi nhé!"; } catch (e) {}
    if (window.gtag) gtag("event","quote_zalo"); if (window.fbq) fbq("track","Lead");
    window.open(zalo, "_blank", "noopener");
  });
  }

  // Calculator
  var r = document.getElementById("debt"), f = function(n){ return Math.round(n).toLocaleString("vi-VN") + "đ"; };
  function calc(){ var d = +r.value, i = d * 0.28 * 30 / 365, fee = Math.max(d * 0.05 * 0.05, 99000);
    document.getElementById("debtOut").textContent = f(d);
    document.getElementById("rInt").textContent = f(i);
    document.getElementById("rFee").textContent = f(fee);
    document.getElementById("rTotal").textContent = f(i + fee); }
  if (r) { r.addEventListener("input", calc); calc(); }

  // Reveal on scroll
  if ("IntersectionObserver" in window) {
    var io = new IntersectionObserver(function(es){ es.forEach(function(e){ if (e.isIntersecting){ e.target.classList.add("in"); io.unobserve(e.target); } }); }, {threshold:.12});
    document.querySelectorAll(".reveal").forEach(function(el){ io.observe(el); });
  } else document.querySelectorAll(".reveal").forEach(function(el){ el.classList.add("in"); });
})();
