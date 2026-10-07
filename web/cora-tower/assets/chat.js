// Chat tư vấn tự động Cora Tower – trả lời theo kịch bản, xin SĐT khéo léo
// và gửi khách về FORM_ENDPOINT (xem main.js). Không cần server.
(() => {
  const C = window.CORA || { tel: "0904567009", telText: "0904 567 009", zalo: "https://zalo.me/0904567009" };
  const box = document.getElementById("chat");
  if (!box) return;
  const body = box.querySelector(".chat-body");
  const chips = box.querySelector(".chat-chips");
  const form = box.querySelector(".chat-input");
  const input = form.querySelector("input");
  const teaser = document.querySelector(".chat-teaser");

  const CALL = `<a href="tel:${C.tel}">${C.telText}</a>`;
  const ZALO = `<a href="${C.zalo}" target="_blank" rel="noopener">Zalo ${C.telText}</a>`;
  const state = { started: false, answered: 0, asked: false, lead: null, topic: "", log: [] };

  // ---------------------------------------------------------------- knowledge
  const KB = [
    { id: "greet", k: ["chao", "hello", "hi", "alo", "xin chao", "co ai"],
      a: () => "Dạ em chào anh/chị ạ! Em là trợ lý tư vấn Cora Tower. Anh/chị đang quan tâm căn hộ để ở hay đầu tư, để em gợi ý căn phù hợp nhất ạ?",
      chips: ["Mua để ở", "Đầu tư cho thuê", "Bảng giá"] },
    { id: "price", k: ["gia", "bao nhieu", "bang gia", "tien", "ty", "trieu", "chi phi", "re", "dat"],
      a: () => "Dạ hiện căn 1PN+ (53,8 m² thông thủy) tầng 15 đang khoảng:\n• Tòa A1: 3,2 – 3,85 tỷ\n• Tòa A2: 3,1 – 3,85 tỷ\n(giá trần đã gồm VAT + phí bảo trì, theo chính sách bán hàng).\n\nGiá từng căn chênh theo tầng, hướng và đợt chính sách. Anh/chị để lại SĐT/Zalo, em gửi ngay bảng giá đầy đủ các tầng kèm căn đẹp còn trống nhé ạ?",
      lead: true, chips: ["Căn 1PN+", "Studio", "2PN – 3PN", "Thanh toán"] },
    { id: "1pn", k: ["1pn", "1pn+", "1 pn", "1 pn+", "pn+", "1 phong ngu", "mot phong ngu", "1br", "1 ngu", "1+1", "pn+"],
      a: () => "Dạ 1PN+ là dòng căn chủ lực, chiếm nhiều nhất mỗi sàn:\n• Thông thủy 52,3 – 59,6 m² (phổ biến 53,8 m²)\n• 1 phòng ngủ chính + 1 phòng linh hoạt, logia 1,6 m\n• Giá tầng 15 khoảng 3,1 – 3,85 tỷ/căn\n\nCăn này vừa ở vợ chồng trẻ vừa dễ cho thuê. Anh/chị thích tầng cao hay tầng trung, view sông hay view thành phố ạ?",
      chips: ["Tầng cao", "View sông", "Xem mặt bằng"] },
    { id: "studio", k: ["studio", "stu", "can nho", "1 nguoi", "mot nguoi"],
      a: () => "Dạ Studio rộng 32 – 32,2 m² thông thủy (36,1 m² tim tường), là căn có tổng tiền thấp nhất dự án – rất hợp ở một mình hoặc cho thuê ngắn hạn. Số lượng mỗi sàn có hạn nên căn đẹp đi khá nhanh ạ. Anh/chị cho em xin SĐT/Zalo để em gửi giá Studio từng tầng nhé?",
      lead: true },
    { id: "2pn", k: ["2pn", "2 pn", "2 phong", "hai phong", "2br", "gia dinh", "can goc"],
      a: () => "Dạ căn 2PN rộng 60,6 – 73,4 m² thông thủy, đa số nằm ở góc tòa nên 2 mặt thoáng, rất hợp gia đình nhỏ. Còn 3PN (78,9 m²) mỗi sàn mỗi tòa chỉ có 1 căn ở đầu hồi phía vòng xoay – cực hiếm ạ.\n\nNhà mình mấy người ở để em lọc căn vừa nhất ạ?",
      chips: ["2 – 3 người", "4 người trở lên", "Bảng giá"] },
    { id: "3pn", k: ["3pn", "3 pn", "3 phong", "ba phong", "3br", "rong nhat", "lon nhat"],
      a: () => "Dạ 3PN rộng 78,9 m² thông thủy (85,7 – 86,7 m² tim tường), mỗi tòa mỗi sàn chỉ 1 căn ở đầu hồi hướng vòng xoay – view thoáng nhất tòa. Số lượng rất ít nên thường được giữ chỗ sớm. Anh/chị để lại SĐT, em báo ngay căn 3PN còn trống ạ.",
      lead: true },
    { id: "shop", k: ["shophouse", "khoi de", "kinh doanh", "mat bang thuong mai", "cua hang", "buon ban", "ki ot", "kiot"],
      a: () => "Dạ shophouse nằm tầng 1 khối đế, mặt tiền vòng xoay 29/3 – Nguyễn Phước Lan, kính kịch trần, sở hữu lâu dài. Phía trên là khoảng 1.281 sản phẩm căn hộ nên lượng khách có sẵn. Giá tham khảo khi ra mắt từ ~78 triệu/m².\n\nAnh/chị định tự kinh doanh hay cho thuê ạ? Em gửi giỏ hàng shophouse kèm vị trí từng căn nhé.",
      lead: true, chips: ["Tự kinh doanh", "Cho thuê", "Xem trang shophouse"] },
    { id: "ph", k: ["penthouse", "duplex", "tang 25", "tang thuong", "thong tang", "cao nhat"],
      a: () => "Dạ căn duplex – penthouse nằm tầng 25, trong khối mái màu cam biểu tượng của 2 tòa: thông tầng, trần cao, có sân vườn trên cao và view toàn cảnh sông, thành phố. Số lượng cực kỳ giới hạn nên em chỉ gửi thông tin trực tiếp cho khách quan tâm thật. Anh/chị cho em xin SĐT/Zalo nhé ạ?",
      lead: true },
    { id: "loc", k: ["vi tri", "o dau", "dia chi", "duong", "cho nao", "khu nao", "29/3", "nguyen phuoc lan", "hoa xuan"],
      a: () => "Dạ Cora Tower nằm ngay vòng xoay đường 29/3 giao Nguyễn Phước Lan, trung tâm KĐT Nam Hòa Xuân (Sun Neo City). Từ đây:\n• Qua cầu Hòa Xuân tới MM Mega Market, Cách Mạng Tháng 8\n• Kết nối Lotte Mart, cầu Rồng, trung tâm Đà Nẵng\n• Ra biển qua Hồ Xuân Hương, đi Hội An qua cầu Trung Lương\n\nAnh/chị đang làm việc ở khu nào để em tính quãng đường giúp ạ?",
      chips: ["Đặt lịch xem dự án", "Pháp lý"] },
    { id: "legal", k: ["phap ly", "so hong", "so do", "giay to", "hop dong", "an toan", "uy tin", "giay phep"],
      a: () => "Dạ về pháp lý:\n• Chủ đầu tư Tập đoàn Sun Group\n• Sổ hồng sở hữu lâu dài (theo công bố)\n• Báo chí đưa tin dự án đã đủ điều kiện ký hợp đồng mua bán\n• Thanh toán đợt đầu không quá 30% (gồm cọc), sau theo tiến độ xây dựng\n\nEm có bộ hồ sơ pháp lý và hợp đồng mẫu, anh/chị để lại Zalo em gửi để mình xem kỹ trước nhé ạ.",
      lead: true },
    { id: "cdt", k: ["chu dau tu", "sun group", "sungroup", "ai lam", "cdt"],
      a: () => "Dạ chủ đầu tư là Tập đoàn Sun Group – đơn vị phát triển cả khu đô thị Sun Neo City tại Nam Hòa Xuân. Dự án ra mắt ngày 29/09/2025 với 2 tòa căn hộ mang tên thương mại Cora Tower ạ." },
    { id: "pay", k: ["thanh toan", "tra gop", "vay", "ngan hang", "lai suat", "chinh sach", "uu dai", "chiet khau", "coc", "dat coc", "giu cho"],
      a: () => "Dạ dự án thanh toán theo tiến độ: đợt đầu không quá 30% giá trị hợp đồng (đã gồm cọc), các đợt sau theo tiến độ xây dựng; có ngân hàng hỗ trợ vay. Chiết khấu và ưu đãi thay đổi theo từng đợt bán hàng nên em cần gửi anh/chị bảng chính sách mới nhất ạ.\n\nAnh/chị dự kiến vốn tự có khoảng bao nhiêu để em tính phương án dòng tiền hợp lý nhất?",
      lead: true, chips: ["Dưới 1 tỷ", "1 – 2 tỷ", "Trên 2 tỷ"] },
    { id: "budget", k: ["duoi 1 ty", "1 - 2 ty", "1 – 2 ty", "tren 2 ty", "von"],
      a: () => "Dạ em hiểu rồi ạ. Với mức vốn này em có thể tính sẵn phương án: số tiền đợt đầu, lịch thanh toán và khoản vay (nếu cần) cho căn phù hợp. Anh/chị để lại SĐT/Zalo, em gửi bảng tính chi tiết trong ít phút nhé!",
      lead: true },
    { id: "handover", k: ["ban giao", "khi nao xong", "tien do", "bao gio", "nam nao", "xay den dau", "thi cong"],
      a: () => "Dạ theo thông tin thị trường, bàn giao dự kiến 30/07/2027, tiêu chuẩn hoàn thiện trần, tường, sàn (không gồm nội thất rời). Mốc chính thức theo hợp đồng mua bán. Em có thể cập nhật hình ảnh tiến độ thực tế qua Zalo cho anh/chị ạ.",
      lead: true },
    { id: "amen", k: ["tien ich", "ho boi", "gym", "spa", "tre em", "cong vien", "noi khu"],
      a: () => "Dạ khối đế 2 tòa gồm tầng 1 shophouse thương mại và tầng 2 dịch vụ – tiện ích; tầng 3 là căn hộ sân vườn. Cư dân còn hưởng hệ tiện ích chung của khu đô thị Sun Neo City ven sông ạ. Anh/chị ưu tiên tiện ích nào nhất để em tư vấn căn gần đó?" },
    { id: "view", k: ["huong", "view", "phong thuy", "tuoi", "menh", "ban cong", "tang cao", "tang trung", "view song"],
      a: () => "Dạ mỗi tòa có 28 căn/sàn chia nhiều hướng, các căn phía sông nhìn về sông Cẩm Lệ – sông Hàn, căn phía vòng xoay nhìn trục 29/3. Anh/chị cho em xin năm sinh gia chủ, em lọc căn hợp hướng và gửi qua Zalo kèm giá luôn ạ.",
      lead: true },
    { id: "invest", k: ["dau tu", "cho thue", "loi nhuan", "sinh loi", "tang gia", "luot song", "mua de o", "o that"],
      a: () => "Dạ nếu đầu tư cho thuê, Studio và 1PN+ là dễ khai thác nhất vì tổng tiền vừa phải, nhu cầu thuê quanh Hòa Xuân – Cẩm Lệ cao. Nếu mua để ở, 1PN+ (có phòng linh hoạt) và 2PN góc là lựa chọn được khách hỏi nhiều nhất ạ.\n\nAnh/chị muốn em gửi danh sách căn phù hợp mục tiêu của mình không ạ?",
      lead: true, chips: ["Có, gửi giúp tôi", "Căn 1PN+", "Studio"] },
    { id: "plan", k: ["mat bang", "layout", "so do", "thiet ke", "bo tri", "dien tich"],
      a: () => "Dạ mặt bằng tầng 3A–24 mỗi tòa có 28 căn: Studio 32 m², 1PN+ 52,3 – 59,6 m², 2PN 60,6 – 73,4 m², 3PN 78,9 m² (thông thủy). Anh/chị xem mặt bằng chi tiết ở mục <a href=\"./#mat-bang\">Mặt bằng</a> ạ, cần bản rõ nét từng căn em gửi qua Zalo nhé.",
      go: "./#mat-bang" },
    { id: "visit", k: ["xem nha", "nha mau", "tham quan", "gap", "hen", "lich", "di xem", "sa ban", "van phong"],
      a: () => "Dạ em sắp xếp lịch xem dự án và sa bàn cho anh/chị ngay ạ. Anh/chị cho em xin tên + SĐT và thời gian thuận tiện (sáng/chiều, ngày nào) nhé!",
      lead: true },
    { id: "contact", k: ["so dien thoai", "sdt", "zalo", "lien he", "goi", "hotline", "email", "tu van vien", "nguoi that"],
      a: () => `Dạ anh/chị gọi hoặc nhắn ${ZALO} – chuyên viên Hoàng Hiệp hỗ trợ trực tiếp 24/7 ạ. Hoặc để lại số ở đây, em gọi lại ngay.` },
    { id: "thanks", k: ["cam on", "thanks", "ok", "oke", "duoc roi", "tam biet", "bye"],
      a: () => state.lead ? "Dạ em cảm ơn anh/chị! Chuyên viên sẽ liên hệ sớm ạ. Chúc anh/chị một ngày thật vui 🌿"
        : `Dạ em cảm ơn anh/chị! Khi cần bảng giá hay giữ căn, anh/chị cứ nhắn em hoặc gọi ${CALL} nhé ạ.` },
  ];
  const CHIP_ACTIONS = {
    "Xem mặt bằng": "mat bang", "Xem trang shophouse": () => (location.href = "khoi-de-shophouse.html"),
    "Mua để ở": "mua de o", "Đầu tư cho thuê": "dau tu", "Có, gửi giúp tôi": "gui giup",
    "Tầng cao": "tang cao", "View sông": "view song", "2 – 3 người": "2pn", "4 người trở lên": "3pn",
    "Tự kinh doanh": "kinh doanh gui", "Cho thuê": "cho thue", "Thanh toán": "thanh toan",
    "Đặt lịch xem dự án": "tham quan", "Căn 1PN+": "1pn", "2PN – 3PN": "2pn", "Duplex tầng 25": "duplex",
  };
  const START_CHIPS = ["Bảng giá", "Căn 1PN+", "Shophouse", "Duplex tầng 25", "Vị trí", "Pháp lý", "Thanh toán", "Đặt lịch xem dự án"];

  // ---------------------------------------------------------------- helpers
  const norm = (s) => " " + s.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/đ/g, "d")
    .replace(/[^a-z0-9/+ ]/g, " ").replace(/\s+/g, " ").trim() + " ";
  const esc = (s) => s.replace(/[&<>"]/g, (c) => ({ "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;" }[c]));
  const findPhone = (s) => {
    const m = s.replace(/[\s.\-()]/g, "").match(/(\+?84|0)(3|5|7|8|9)\d{8}/);
    return m ? m[0] : null;
  };
  const scroll = () => (body.scrollTop = body.scrollHeight);

  function add(html, who = "bot") {
    const d = document.createElement("div");
    d.className = `msg ${who}`;
    d.innerHTML = html;
    body.appendChild(d);
    scroll();
    return d;
  }
  function say(html, chipList) {
    const t = add("Đang soạn tin…", "bot typing");
    const delay = Math.min(1400, 450 + html.length * 6);
    setTimeout(() => {
      t.classList.remove("typing");
      t.innerHTML = html;
      scroll();
      state.log.push("Bot: " + html.replace(/<[^>]+>/g, ""));
      setChips(chipList);
    }, delay);
  }
  function setChips(list) {
    chips.innerHTML = "";
    (list || (state.lead ? ["Bảng giá", "Vị trí", "Pháp lý", "Gọi ngay"] : START_CHIPS)).forEach((c) => {
      const b = document.createElement("button");
      b.type = "button";
      b.textContent = c;
      b.onclick = () => handle(c);
      chips.appendChild(b);
    });
  }

  function askPhone() {
    state.asked = true;
    return `\n\n👉 Anh/chị nhập <b>SĐT/Zalo</b> ngay ô bên dưới, em gửi bảng giá + căn đẹp trong 5 phút ạ. Hoặc gọi ${CALL}.`;
  }

  async function captureLead(phone, raw) {
    const name = (raw.replace(/[\d+.\-()\s]{9,}/g, " ").replace(/(sdt|so|cua|em|anh|chi|toi|la|minh|ten|:|,)/gi, " ").trim() || "").slice(0, 60);
    state.lead = phone;
    let sent = false;
    try {
      sent = await window.submitLead?.({ name, phone, interest: state.topic || "Chat tư vấn", source: "chat", note: state.log.slice(-8).join(" | ") });
    } catch { /* ignore network errors – user still gets a call/Zalo fallback */ }
    say(`Dạ em đã ghi nhận số <b>${esc(phone)}</b> ạ! 🎉\nChuyên viên Hoàng Hiệp sẽ gọi/Zalo cho anh/chị trong ít phút để gửi bảng giá và giỏ hàng căn đẹp.${sent ? "" : `\n\nNếu cần gấp, anh/chị nhắn trực tiếp ${ZALO} giúp em nhé.`}`,
      ["Bảng giá", "Vị trí", "Pháp lý", "Gọi ngay"]);
  }

  function handle(text) {
    text = (text || "").trim();
    if (!text) return;
    if (text === "Gọi ngay") { location.href = `tel:${C.tel}`; return; }
    const act = CHIP_ACTIONS[text];
    if (typeof act === "function") { act(); return; }
    add(esc(text), "me");
    state.log.push("Khách: " + text);
    const phone = findPhone(text);
    if (phone) return captureLead(phone, text);

    const q = norm(act || text);
    // Highest keyword match wins
    let best = null, score = 0;
    for (const it of KB) {
      const sc = it.k.reduce((n, k) => n + (q.includes(norm(k)) ? k.length : 0), 0);
      if (sc > score) { best = it; score = sc; }
    }
    if (/gui giup|kinh doanh gui/.test(q)) best = { a: () => "Dạ vâng ạ!", lead: true };
    if (!best) {
      say(state.lead
        ? `Dạ câu này em muốn chuyên viên trả lời thật chính xác cho anh/chị ạ. Anh/chị gọi ${CALL} để được hỗ trợ ngay nhé.`
        : `Dạ câu này em muốn chuyên viên trả lời thật chính xác cho anh/chị ạ. Anh/chị để lại SĐT/Zalo, chuyên viên gọi lại liền – hoặc gọi ${CALL} nhé.`);
      return;
    }
    if (best.id) state.topic = best.id;
    state.answered++;
    let reply = best.a();
    // Ask for the phone at the right moment: on buying-signal topics, or after 2 answers
    if (!state.lead && (best.lead || state.answered >= 2) && (!state.asked || state.answered % 3 === 0)) reply += askPhone();
    say(reply, best.chips);
  }

  // ---------------------------------------------------------------- open / close
  function open() {
    box.hidden = false;
    document.body.classList.add("chat-open");
    if (teaser) teaser.hidden = true;
    if (!state.started) {
      state.started = true;
      const h = new Date().getHours();
      const hi = h < 11 ? "Chào buổi sáng" : h < 14 ? "Chào buổi trưa" : h < 18 ? "Chào buổi chiều" : "Chào buổi tối";
      say(`${hi} anh/chị! 👋 Em là trợ lý tư vấn <b>Cora Tower</b> – 2 tòa căn hộ Sun Group tại vòng xoay 29/3, Đà Nẵng.\n\nCăn 1PN+ hiện chỉ từ khoảng <b>3,1 tỷ</b>. Anh/chị muốn em hỗ trợ thông tin nào ạ?`);
    }
    setTimeout(() => input.focus({ preventScroll: true }), 50);
  }
  const close = () => { box.hidden = true; document.body.classList.remove("chat-open"); };
  document.querySelectorAll("[data-chat-open]").forEach((b) => b.addEventListener("click", open));
  box.querySelector("[data-chat-close]").addEventListener("click", close);
  addEventListener("keydown", (e) => e.key === "Escape" && !box.hidden && close());
  form.addEventListener("submit", (e) => {
    e.preventDefault();
    handle(input.value);
    input.value = "";
  });

  // Teaser bubble after 12s (once per session)
  if (teaser) {
    let seen = false;
    try { seen = sessionStorage.getItem("cora-teaser") === "1"; } catch {}
    if (!seen) setTimeout(() => {
      if (box.hidden && !state.started) teaser.hidden = false;
      try { sessionStorage.setItem("cora-teaser", "1"); } catch {}
    }, 12000);
    teaser.querySelector(".t-x").addEventListener("click", () => (teaser.hidden = true));
  }
})();
