/* =========================================================
   Chat tư vấn tự động – FPT City
   - Trả lời ngay từ kho kiến thức /assets/chat-kb.json (sinh lúc build)
   - Tra mã căn FPT Plaza 4 (VD: N-12.12, S 19.05)
   - Khách gõ SĐT → gửi lead về CRM
   - Tuỳ chọn: câu hỏi khác chuyển cho AI qua CRM (CONFIG.chatAI)
   ========================================================= */
(function () {
  "use strict";
  // Khi nhúng bằng fc-widget.js, giao diện nằm trong Shadow DOM (window.__fcRoot) để không đụng CSS của trang chủ
  const ROOT = window.__fcRoot || document;
  const $ = (s, el = ROOT) => el.querySelector(s);
  const $$ = (s, el = ROOT) => [...el.querySelectorAll(s)];
  const fixHref = (h) => (window.__fc && window.__fc.fix ? window.__fc.fix(h) : h);
  const isExternal = (h) => { try { return new URL(h, location.href).origin !== location.origin; } catch (e) { return false; } };
  const box = $("#chatbox");
  if (!box) return;
  const fc = () => window.__fc || { CONFIG: {}, project: "", hasDrive: false, drive: "", track() {}, sendLead: async () => {}, openForm() {} };
  const ss = {
    get(k) { try { return sessionStorage.getItem(k); } catch (e) { return null; } },
    set(k, v) { try { sessionStorage.setItem(k, v); } catch (e) { /* bỏ qua */ } },
  };
  const log = $("[data-chat-log]", box), chips = $("[data-chat-chips]", box), form = $("[data-chat-form]", box), input = form.q;
  const sid = ss.get("fc_chat_sid") || (() => { const v = Math.random().toString(36).slice(2) + Date.now().toString(36); ss.set("fc_chat_sid", v); return v; })();
  const st = { kb: null, history: [], awaitPhone: false, leadSent: !!ss.get("fc_chat_lead"), aiOff: false, asked: [], ctx: "" };

  /* ---------- Chuẩn hoá tiếng Việt để so khớp ---------- */
  const norm = (s) => String(s || "").toLowerCase().normalize("NFD").replace(/[̀-ͯ]/g, "").replace(/đ/g, "d").replace(/\s+/g, " ").trim();
  // từ ngắn (≤3 ký tự: "gia", "ty", "coc"…) phải khớp nguyên từ để "gia đình" không bị hiểu là hỏi giá
  const has = (t, words) => words.some((w) => (w.length <= 3 ? new RegExp("(^|[^a-z0-9])" + w + "([^a-z0-9]|$)").test(t) : t.includes(w)));
  const nf = (n) => String(n).replace(".", ",");
  const pad = (n) => String(n).padStart(2, "0");

  async function loadKb() {
    if (st.kb) return st.kb;
    if (fc().kb) return (st.kb = fc().kb);
    try { st.kb = await (await fetch("/assets/chat-kb.json", { cache: "force-cache" })).json(); }
    catch (e) { st.kb = { projects: [], zones: [], city: {}, fp4: { floors: [], units: [], types: {} } }; }
    return st.kb;
  }

  /* ---------- Hiển thị tin nhắn (an toàn: chỉ text node, link nội bộ / tel / zalo) ---------- */
  function richText(el, text) {
    const re = /\*\*(.+?)\*\*|\[([^\]]+)\]\(((?:\/|tel:|https:\/\/zalo\.me\/)[^)\s]*)\)/g;
    String(text).split("\n").forEach((line, i) => {
      if (i) el.appendChild(document.createElement("br"));
      let last = 0, m;
      while ((m = re.exec(line))) {
        if (m.index > last) el.appendChild(document.createTextNode(line.slice(last, m.index)));
        if (m[1]) { const b = document.createElement("b"); b.textContent = m[1]; el.appendChild(b); }
        else { const a = document.createElement("a"); a.textContent = m[2]; a.href = fixHref(m[3]); if (isExternal(a.href)) { a.target = "_blank"; a.rel = "noopener"; } el.appendChild(a); }
        last = re.lastIndex;
      }
      if (last < line.length) el.appendChild(document.createTextNode(line.slice(last)));
    });
  }
  function say(who, text, actions) {
    const row = document.createElement("div");
    row.className = "msg " + who;
    const bubble = document.createElement("div");
    bubble.className = "bubble";
    richText(bubble, text);
    row.appendChild(bubble);
    if (actions && actions.length) {
      const wrap = document.createElement("div");
      wrap.className = "msg-actions";
      actions.forEach((a) => {
        const el = document.createElement(a.href ? "a" : "button");
        el.textContent = a.label;
        el.className = a.primary ? "act primary" : "act";
        if (a.href) { el.href = fixHref(a.href); if (isExternal(el.href)) { el.target = "_blank"; el.rel = "noopener"; } }
        else { el.type = "button"; el.onclick = a.onClick; }
        wrap.appendChild(el);
      });
      row.appendChild(wrap);
    }
    log.appendChild(row);
    log.scrollTop = log.scrollHeight;
    st.history.push({ role: who === "me" ? "user" : "assistant", content: String(text).slice(0, 1200) });
    if (st.history.length > 16) st.history = st.history.slice(-16);
  }
  function typing(on) {
    let t = $(".msg.typing", log);
    if (on && !t) { t = document.createElement("div"); t.className = "msg bot typing"; t.innerHTML = '<div class="bubble"><i></i><i></i><i></i></div>'; log.appendChild(t); log.scrollTop = log.scrollHeight; }
    if (!on && t) t.remove();
  }
  function setChips(list) {
    chips.innerHTML = "";
    list.forEach((c) => {
      const b = document.createElement("button");
      b.type = "button"; b.textContent = c;
      b.onclick = () => handle(c);
      chips.appendChild(b);
    });
  }

  /* ---------- Hiểu câu hỏi ---------- */
  const T = {
    hello: ["chao", "hello", "hi ", "alo", "xin chao"],
    price: ["gia", "bao nhieu tien", "ty", "trieu", "chiet khau", "uu dai", "chinh sach ban"],
    plan: ["mat bang", "dien tich", "loai can", "1pn", "2pn", "3pn", "phong ngu", "duplex", "m2", "layout", "can nao", "can goc"],
    progress: ["tien do", "ban giao", "khi nao", "bao gio", "hoan thanh", "mo ban", "xay den dau", "khoi cong", "nhan nha"],
    location: ["vi tri", "o dau", "dia chi", "cach", "bien", "san bay", "trung tam", "duong nao", "ban do"],
    legal: ["phap ly", "so hong", "so do", "hop dong", "so huu", "lau dai"],
    pay: ["thanh toan", "vay", "ngan hang", "lai suat", "tra gop", "dat coc", "coc"],
    amen: ["tien ich", "ho boi", "gym", "truong", "cong vien", "sieu thi", "vuon"],
    human: ["tu van", "chuyen vien", "nhan vien", "sale", "goi lai", "goi cho", "gap", "lien he", "hotline", "zalo"],
    doc: ["tai lieu", "brochure", "drive", "file", "gui cho", "pdf"],
    count: ["bao nhieu can", "so can", "may can", "bao nhieu tang", "may tang", "quy mo"],
  };

  function detectProject(t, kb) {
    const m = t.match(/(?:fpt\s*)?(?:plaza|pl|p)\s*([1-5])\b/) || t.match(/\bfpt\s*([1-5])\b/);
    if (m) return kb.projects.find((p) => p.name.endsWith(" " + m[1]));
    const z = t.match(/\bv\s*([1-9])\b/);
    if (z && (t.includes("dat") || t.includes("phan khu") || t.length < 12)) return { zone: kb.zones.find((x) => x.code === "V" + z[1]) };
    if (t.includes("dat nen") || t.includes("phan khu") || /\bdat\b/.test(t)) return { land: true };
    return null;
  }
  function pageContext(kb) {
    const p = fc().project || "";
    const zp = p.match(/V(\d)/);
    if (zp) return { zone: kb.zones.find((x) => x.code === "V" + zp[1]) };
    if (/đất nền/i.test(p)) return { land: true };
    return kb.projects.find((x) => x.name === p) || null;
  }
  const spec = (p, key) => (p.specs.find((s) => norm(s[0]).includes(norm(key))) || [])[1];

  function unitLookup(text, kb) {
    const m = text.match(/\b([ns])\s*-?\s*(\d{1,2})\s*[.\-\s]\s*(\d{1,2}a?)\b/i);
    if (!m) return null;
    const block = m[1].toUpperCase(), floor = +m[2];
    let no = m[3].toUpperCase(); if (/^\d$/.test(no)) no = "0" + no; if (/^\dA$/.test(no)) no = "0" + no;
    const code = `${block}-${pad(floor)}.${no}`;
    const f = kb.fp4.floors.find((x) => floor >= x.from && floor <= x.to);
    if (!f) return { code, text: `FPT Plaza 4 có căn hộ từ tầng 3 đến tầng 20, mình chưa thấy tầng ${floor}. Bạn kiểm tra lại mã căn giúp mình nhé (dạng N-12.12).` };
    const u = kb.fp4.units.find((x) => x[0] === f.id && x[1] === block && x[2] === no);
    if (!u) return { code, text: `Mình chưa tìm thấy căn **${code}** trên mặt bằng FPT Plaza 4 (lưu ý: không có căn số 13, có căn 12A). Bạn gửi lại mã giúp mình nhé.` };
    const type = kb.fp4.types[u[3]] || u[3];
    let extra = "";
    if (u[3].startsWith("DUP")) {
      const other = kb.fp4.units.find((x) => x[0] === (f.id === "19" ? "20" : "19") && x[1] === block && x[2] === no);
      if (other) extra = `\nĐây là căn **Duplex thông tầng 19–20**, tổng khoảng **${nf((u[4] + other[4]).toFixed(2))} m²** (tầng ${f.id}: ${nf(u[4])} m²).`;
    }
    const lay = (kb.fp4.layouts || []).find((l) => l.units.some(([b, n, from, to]) => b === block && n === no && floor >= from && floor <= to));
    if (lay) extra += `\n📐 [Xem layout căn ${code}](${lay.img})`;
    return { code, unit: `${code} · ${type} · ${nf(u[4])} m²`,
      text: `Căn **${code}** – FPT Plaza 4: **${type}**, diện tích **${nf(u[4])} m²**, khối ${block === "N" ? "N (Bắc)" : "S (Nam)"}, tầng ${floor}.${extra}\nGiá căn này phụ thuộc tầng, hướng và chính sách hiện hành – để lại SĐT/Zalo, chuyên viên gửi giá chính xác cho bạn ngay.` };
  }

  function faqSearch(t, list) {
    const words = t.split(/[^a-z0-9]+/).filter((w) => w.length > 2);
    let best = null, score = 0;
    list.forEach(([q, a]) => {
      const nq = norm(q);
      const sc = words.reduce((s, w) => s + (nq.includes(w) ? (w.length > 4 ? 2 : 1) : 0), 0);
      if (sc > score) { score = sc; best = a; }
    });
    return score >= 4 ? best : null;
  }

  function ruleAnswer(text, kb) {
    const t = " " + norm(text).replace(/\bgia (dinh|han|dung|nhap)\b/g, " ") + " "; // bỏ dấu thì "gia đình" giống "giá": loại các cụm này trước khi nhận diện ý
    const found = detectProject(t, kb);
    const target = found || st.ctx || pageContext(kb);
    if (found) st.ctx = found;
    const p = target && target.name ? target : null;
    const allFaq = kb.projects.flatMap((x) => x.faq);
    const ask = (msg) => { st.awaitPhone = !st.leadSent; return msg + (st.leadSent ? "" : "\n👉 Bạn để lại **SĐT/Zalo** (kèm tên) ngay trong khung chat, chuyên viên gửi ngay cho bạn nhé."); };
    const priceAct = [{ label: "📥 Nhận bảng giá", primary: true, onClick: () => fc().openForm(p ? p.name + " · Bảng giá" : "") }];

    if (has(t, T.hello) && t.length < 20) return { sure: true, text: "Chào bạn 👋 Mình là trợ lý tự động của FPT City. Bạn quan tâm **căn hộ FPT Plaza** hay **đất nền FPT City**? Bạn cũng có thể gõ mã căn (VD: N-12.12) để xem diện tích." };

    if (has(t, T.price)) {
      if (target && target.zone) return { sure: true, text: ask(`Giá đất **phân khu ${target.zone.code}** thay đổi theo từng lô (vị trí, hướng, mặt tiền đường). Mình gửi bạn **giỏ hàng & giá từng lô** mới nhất.`), actions: priceAct };
      if (target && target.land) return { sure: true, text: ask("Giá đất nền FPT City khác nhau theo phân khu V1–V6 và từng lô. Mình gửi bạn **bản đồ phân lô + giỏ hàng** mới nhất."), actions: priceAct };
      if (p) return { sure: true, text: ask(`Giá **${p.name}** thay đổi theo tầng, hướng, loại căn và đợt chính sách (${p.status}). Mình gửi bạn **bảng giá + chính sách thanh toán** mới nhất kèm mặt bằng.`), actions: priceAct };
      return { sure: true, text: ask("Giá phụ thuộc dự án và từng căn. Bạn quan tâm FPT Plaza nào (1, 2, 3, 4, 5) hay đất nền? Mình gửi bảng giá mới nhất."), actions: priceAct };
    }
    if (has(t, T.count) && p) {
      const lines = [spec(p, "quy mô"), spec(p, "số căn"), spec(p, "tầng điển hình")].filter(Boolean);
      if (lines.length) return { sure: true, text: `**${p.name}**: ${lines.join(" · ")}.` };
    }
    if (has(t, T.plan)) {
      if (p) {
        const units = p.units.map(([k, v]) => `• ${k}: ${v}`).join("\n");
        const tip = p.name === "FPT Plaza 4" ? "\nBạn gõ **mã căn** (VD: N-12.12) để xem chính xác, hoặc xem [mặt bằng từng tầng](/fpt-plaza-4/#mat-bang-tang)." : "";
        return { sure: true, text: `Loại căn & diện tích **${p.name}** (tham khảo):\n${units}${tip}`, actions: [{ label: "📐 Nhận mặt bằng chi tiết", primary: true, onClick: () => fc().openForm(p.name + " · Mặt bằng") }] };
      }
      if (target && (target.zone || target.land)) return { sure: true, text: ask("Đất nền FPT City có lô phổ biến ~90–105 m², lô góc và biệt thự 200–350+ m² (tuỳ phân khu). Mình gửi bản đồ phân lô chi tiết.") };
    }
    if (has(t, T.progress) && p) {
      const lines = [spec(p, "khởi công"), spec(p, "thi công"), spec(p, "mở bán"), spec(p, "bàn giao"), spec(p, "tình trạng")].filter(Boolean);
      const f = faqSearch(t, p.faq);
      return { sure: true, text: f || `**${p.name}** – ${p.status}.\n${lines.map((x) => "• " + x).join("\n")}` };
    }
    if (has(t, T.location)) {
      const extra = p && spec(p, "mặt tiền") ? `\n**${p.name}**: ${spec(p, "mặt tiền")}.` : "";
      return { sure: true, text: `📍 ${kb.city.name} – ${kb.city.location}${extra}`, actions: [{ label: "Xem bản đồ", href: (p ? p.url : "/") + "#vi-tri" }] };
    }
    if (has(t, T.amen)) return { sure: true, text: `Tiện ích ${kb.city.name}: ${kb.city.amenities}${p && spec(p, "tiện ích") ? `\n**${p.name}**: ${spec(p, "tiện ích")}.` : ""}` };
    if (has(t, T.legal)) {
      if (target && (target.zone || target.land)) return { sure: true, text: ask("Đất nền FPT City được cấp **sổ đỏ từng lô**; mỗi lô được kiểm tra pháp lý cụ thể trước khi giao dịch.") };
      const f = p && faqSearch(t, p.faq);
      return { sure: true, text: ask(f || "Căn hộ FPT Plaza sở hữu lâu dài với người Việt Nam. Dự án đang bán theo hình thức nhà ở hình thành trong tương lai khi đã được Sở Xây dựng xác nhận đủ điều kiện. Chuyên viên sẽ gửi bạn hồ sơ pháp lý chi tiết.") };
    }
    if (has(t, T.pay)) return { sure: true, text: ask(`${p ? "**" + p.name + "**: " : ""}thanh toán theo tiến độ, có ngân hàng hỗ trợ vay. Chính sách cụ thể (tỷ lệ vay, ân hạn lãi, chiết khấu) thay đổi theo đợt – mình gửi bạn bảng tính dòng tiền chi tiết.`) };
    if (has(t, T.doc)) return { sure: true, text: ask("Bộ tài liệu gồm brochure, mặt bằng, bảng giá và chính sách."), actions: priceAct };
    if (has(t, T.human)) return { sure: true, text: ask(`Bạn có thể gọi ngay hoặc nhắn Zalo cho chuyên viên. Hoặc để lại số, chuyên viên gọi lại trong ít phút.`), actions: [{ label: "📞 Gọi ngay", href: $("[data-hotline-link]")?.href || "tel:" }, { label: "Zalo", href: $("[data-zalo-link]")?.href || "#" }] };
    if (target && target.zone) return { sure: false, text: `**Đất nền FPT City phân khu ${target.zone.code}**: ${target.zone.lead}\n${target.zone.traits.map((x) => "• " + x).join("\n")}`, actions: [{ label: "Xem phân khu " + target.zone.code, href: target.zone.url }] };
    const f = faqSearch(t, p ? p.faq.concat(allFaq) : allFaq);
    if (f) return { sure: false, text: f };
    if (found && p) return { sure: false, text: `**${p.name}** (${p.status}): ${p.lead}`, actions: [{ label: "Xem " + p.name, href: p.url }, { label: "📥 Nhận bảng giá", primary: true, onClick: () => fc().openForm(p.name) }] };
    return null;
  }

  /* ---------- SĐT trong tin nhắn → gửi lead ---------- */
  function extractPhone(text) {
    const m = text.match(/(?:\+?84|0)(?:[\s.\-]?\d){8,10}/);
    if (!m) return null;
    let p = m[0].replace(/[^\d+]/g, "");
    if (p.startsWith("+84")) p = "0" + p.slice(3); else if (p.startsWith("84")) p = "0" + p.slice(2);
    if (!/^0(3|5|7|8|9)\d{8}$/.test(p)) return { invalid: true };
    const STOP = new Set(["sdt", "so", "dt", "zalo", "cua", "toi", "em", "anh", "chi", "minh", "ten", "la", "day", "nhe", "nha", "a", "oi", "goi", "lai", "cho", "nhan", "dien", "thoai", "lien", "he", "qua", "va", "ah", "ạ"]);
    const name = text.replace(m[0], " ").replace(/[^\p{L}\s]/gu, " ").split(/\s+/).filter((w) => w && !STOP.has(norm(w))).join(" ").trim();
    return { phone: p, name: name.length >= 2 && name.length <= 40 ? name : "" };
  }
  async function submitLead(info) {
    const kb = await loadKb();
    const ctx = st.ctx || pageContext(kb);
    const proj = ctx && ctx.name ? ctx.name : ctx && ctx.zone ? "Đất nền FPT City " + ctx.zone.code : ctx && ctx.land ? "Đất nền FPT City" : fc().project || "Website";
    const need = ("Chat: " + st.asked.slice(-3).join(" | ")).slice(0, 200);
    try { await fc().sendLead({ name: info.name || "Khách chat", phone: info.phone, need, project: proj, source: "chat" }); } catch (e) { /* vẫn cảm ơn khách */ }
    st.leadSent = true; st.awaitPhone = false; ss.set("fc_chat_lead", "1");
    const acts = fc().hasDrive ? [{ label: "📂 Mở tài liệu Google Drive", primary: true, href: fc().drive }] : [];
    say("bot", `Cảm ơn ${info.name || "bạn"} 🙏 Mình đã chuyển số **${info.phone}** cho chuyên viên – bạn sẽ được gọi/nhắn Zalo trong ít phút.${fc().hasDrive ? "\nTrong lúc chờ, bạn xem tài liệu dự án tại đây:" : ""}`, acts);
  }

  /* ---------- AI qua CRM (tuỳ chọn) ---------- */
  async function aiAnswer() {
    const C = fc().CONFIG || {};
    if (!C.chatAI || !C.leadEndpoint || st.aiOff) return null;
    try {
      const ctrl = new AbortController();
      const timer = setTimeout(() => ctrl.abort(), 25000);
      const r = await fetch(C.leadEndpoint, {
        method: "POST", signal: ctrl.signal,
        body: new URLSearchParams({ action: "chat", sid, page: location.pathname, project: fc().project || "", history: JSON.stringify(st.history.slice(-12)) }),
      });
      clearTimeout(timer);
      const d = await r.json();
      if (d && d.ok && d.reply) return { text: d.reply };
      if (d && (d.error === "disabled" || d.error === "limit")) st.aiOff = true;
    } catch (e) { /* rơi về trả lời tự động */ }
    return null;
  }

  async function handle(raw) {
    const text = String(raw || "").trim().slice(0, 400);
    if (!text) return;
    say("me", text);
    input.value = "";
    const kb = await loadKb();

    const ph = extractPhone(text);
    if (!ph) st.asked.push(text.slice(0, 80));
    if (ph && ph.invalid) { say("bot", "Số điện thoại có vẻ chưa đúng 🤔 Bạn kiểm tra lại giúp mình (VD: 0905 123 456) nhé."); return; }
    if (ph) { await submitLead(ph); setChips(["Mặt bằng FPT Plaza 4", "Tiến độ bàn giao", "Đất nền FPT City"]); return; }

    const unit = unitLookup(text, kb);
    if (unit) {
      st.ctx = kb.projects.find((p) => p.name === "FPT Plaza 4") || st.ctx;
      st.awaitPhone = !st.leadSent;
      say("bot", unit.text, unit.unit ? [{ label: "💰 Nhận giá căn " + unit.code, primary: true, onClick: () => fc().openForm("FPT Plaza 4 · " + unit.unit) }] : []);
      fc().track("chat_unit", { unit: unit.code });
      return;
    }

    typing(true);
    let ans = ruleAnswer(text, kb);
    if (!ans || !ans.sure) {
      const ai = await aiAnswer();
      if (ai) ans = { text: ai.text, actions: ans && ans.actions };
    }
    await new Promise((r) => setTimeout(r, 350));
    typing(false);
    if (!ans) {
      ans = { text: `Câu này mình cần chuyên viên hỗ trợ thêm 🙏 ${st.leadSent ? "Chuyên viên sẽ liên hệ bạn sớm." : "Bạn để lại **SĐT/Zalo** ngay tại đây, hoặc gọi trực tiếp nhé."}`,
        actions: [{ label: "📞 Gọi ngay", href: $("[data-hotline-link]")?.href || "tel:" }] };
      st.awaitPhone = !st.leadSent;
    }
    say("bot", ans.text, ans.actions);
    fc().track("chat_message", { project: fc().project });
  }

  /* ---------- Mở / đóng ---------- */
  const openBtns = $$("[data-chat-open]");
  const teaser = $("[data-chat-teaser]");
  async function open() {
    box.hidden = false;
    openBtns.forEach((b) => b.setAttribute && b.setAttribute("aria-expanded", "true"));
    if (teaser) teaser.hidden = true;
    const badge = $("[data-chat-badge]"); if (badge) badge.hidden = true;
    ss.set("fc_chat_seen", "1");
    if (!log.children.length) {
      const kb = await loadKb();
      const ctx = pageContext(kb);
      const where = ctx && ctx.name ? `**${ctx.name}**` : ctx && ctx.zone ? `**đất nền phân khu ${ctx.zone.code}**` : "**FPT City Đà Nẵng**";
      say("bot", `Xin chào 👋 Mình là trợ lý tự động, hỗ trợ thông tin ${where} 24/7.\nBạn muốn xem gì? Chọn nhanh bên dưới hoặc gõ câu hỏi / mã căn (VD: **N-12.12**).`);
      const p4 = ctx && ctx.name === "FPT Plaza 4";
      setChips(p4 ? ["Bảng giá FPT Plaza 4", "Loại căn & diện tích", "Căn Duplex", "Khi nào bàn giao?", "Vị trí dự án", "Gặp chuyên viên"]
        : ctx && (ctx.zone || ctx.land) ? ["Giá đất nền", "Pháp lý sổ đỏ", "Vị trí", "Gặp chuyên viên"]
          : ["Bảng giá FPT Plaza 4", "FPT Plaza 5 khi nào mở bán?", "Đất nền FPT City", "Vị trí FPT City", "Gặp chuyên viên"]);
    }
    setTimeout(() => input.focus(), 50);
    fc().track("chat_open", { project: fc().project });
  }
  function close() {
    box.hidden = true;
    openBtns.forEach((b) => b.setAttribute && b.setAttribute("aria-expanded", "false"));
  }
  openBtns.forEach((b) => b.addEventListener("click", () => (box.hidden ? open() : close())));
  $("[data-chat-close]", box).addEventListener("click", close);
  document.addEventListener("keydown", (e) => { if (e.key === "Escape" && !box.hidden) close(); });
  form.addEventListener("submit", (e) => { e.preventDefault(); handle(input.value); });
  if (teaser) $("[data-teaser-close]", teaser).addEventListener("click", (e) => { e.stopPropagation(); teaser.hidden = true; ss.set("fc_chat_seen", "1"); });

  const delay = (fc().CONFIG && fc().CONFIG.chatTeaserSeconds) || 0;
  if (delay > 0 && teaser && !ss.get("fc_chat_seen")) {
    setTimeout(() => { if (box.hidden && !document.querySelector("dialog[open]")) teaser.hidden = false; }, delay * 1000);
  }
  // cho phép mở chat từ nơi khác: <a href="#chat">
  if (location.hash === "#chat") open();

  // dùng cho kiểm thử
  window.__fcChat = { handle, unitLookup: (t) => loadKb().then((kb) => unitLookup(t, kb)), extractPhone };
})();
