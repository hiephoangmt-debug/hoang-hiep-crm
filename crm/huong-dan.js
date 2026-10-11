/* Trang hướng dẫn: hiện các slide hướng dẫn chụp nghiệm thu lấy từ chính file PPTX mẫu (qua PDF do Apps Script tạo). */
(function () {
  var PDFJS = "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/";
  var status = document.getElementById("deckStatus");
  var say = function (t) { if (status) status.textContent = t; };
  // tiêu đề kênh trong slide viết HOA; ghi chú có thể nhắc nhầm kênh nên chỉ xét chữ HOA
  var CHANNELS = [["fb", /FACEBOOK/], ["tt", /TIKTOK/], ["zl", /ZALO/], ["gg", /GOOGLE/]];
  var KIND_LABEL = { ads: "Chiến dịch", qc: "QC đang chạy", hoadon: "Hoá đơn" };

  function plain(t) {
    return t.normalize("NFD").replace(/[̀-ͯ]/g, "").replace(/đ/g, "d").replace(/Đ/g, "D").toLowerCase();
  }
  function kindOf(t) {
    var p = plain(t);
    if (/hoa don|invoice|ma tham chieu|da thanh toan|chi tiet giao dich/.test(p)) return "hoadon";
    if (/dang hoat dong|quang cao chay/.test(p)) return "qc";
    return "ads";
  }
  function loadScript(src) {
    return new Promise(function (ok, fail) {
      var s = document.createElement("script");
      s.src = src; s.onload = ok; s.onerror = function () { fail(new Error("Không tải được " + src)); };
      document.head.appendChild(s);
    });
  }
  function deck() {
    return new Promise(function (ok, fail) {
      google.script.run.withSuccessHandler(ok).withFailureHandler(fail).crmGuideDeck();
    });
  }
  function toBytes(b64) {
    var s = atob(b64), a = new Uint8Array(s.length);
    for (var i = 0; i < s.length; i++) a[i] = s.charCodeAt(i);
    return a;
  }

  async function run() {
    if (!(window.google && google.script && google.script.run)) {
      say("Mở trang này từ link app (…/exec?page=huongdan) để xem slide mẫu.");
      return;
    }
    var d = await deck();
    if (!window.pdfjsLib) await loadScript(PDFJS + "pdf.min.js");
    pdfjsLib.GlobalWorkerOptions.workerSrc = PDFJS + "pdf.worker.min.js";
    var pdf = await pdfjsLib.getDocument({ data: toBytes(d.b64) }).promise;
    var ch = "", n = 0;
    for (var i = 1; i <= pdf.numPages; i++) {
      var page = await pdf.getPage(i);
      var text = (await page.getTextContent()).items.map(function (x) { return x.str; }).join(" ");
      for (var k = 0; k < CHANNELS.length; k++) if (CHANNELS[k][1].test(text)) { ch = CHANNELS[k][0]; break; }
      // slide hướng dẫn chụp = có ghi chú "Lưu ý … capture" / "Demo"
      if (!ch || !/capture|demo/i.test(plain(text))) continue;
      var box = document.querySelector('.shots[data-ch="' + ch + '"]');
      if (!box) continue;
      say("Đang hiện slide mẫu " + i + "/" + pdf.numPages + "…");
      var vp0 = page.getViewport({ scale: 1 });
      var vp = page.getViewport({ scale: Math.min(2.5, 1400 / vp0.width) });
      var cv = document.createElement("canvas");
      cv.width = Math.round(vp.width); cv.height = Math.round(vp.height);
      await page.render({ canvasContext: cv.getContext("2d"), viewport: vp }).promise;
      var blob = await new Promise(function (ok) { cv.toBlob(ok, "image/jpeg", 0.85); });
      var fig = document.createElement("figure");
      fig.className = "shot";
      fig.innerHTML = '<img alt=""><figcaption><b>' + KIND_LABEL[kindOf(text)] + "</b> · slide " + i + " trong file mẫu – chạm để phóng to</figcaption>";
      fig.querySelector("img").src = URL.createObjectURL(blob);
      box.appendChild(fig);
      n++;
    }
    say(n ? "Slide mẫu lấy từ file báo cáo mẫu " + (d.name || "") + "." : "Không tìm thấy slide hướng dẫn trong file mẫu.");
  }

  document.addEventListener("click", function (e) {
    var z = document.getElementById("zoom");
    if (z) { z.remove(); return; }
    if (e.target.matches(".shot img")) {
      z = document.createElement("div");
      z.id = "zoom";
      z.innerHTML = '<img alt="">';
      z.firstChild.src = e.target.src;
      document.body.appendChild(z);
    }
  });
  run().catch(function (e) { say("Chưa tải được slide mẫu (" + (e && e.message || e) + "). Xem danh sách mục cần chụp bên dưới mỗi kênh."); });
})();
