/* Báo cáo Marketing tuần – dạng trang web (mở bằng link ?page=bc&k=<mã>).
 * Dữ liệu lấy từ crmWebReport(k); ảnh nghiệm thu tải qua crmWebImage(k, id) (người xem không cần quyền Drive). */
(function () {
  "use strict";
  const $ = (id) => document.getElementById(id);
  const esc = (s) => String(s == null ? "" : s).replace(/[&<>"]/g, (c) => ({ "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;" }[c]));
  const num = (v) => { if (typeof v === "number") return v; const n = Number(String(v || "").replace(/\./g, "").replace(",", ".")); return isFinite(n) ? n : 0; };
  const fmt = (n) => Math.round(n || 0).toLocaleString("vi-VN");
  const fmt1 = (n) => (n || 0).toLocaleString("vi-VN", { maximumFractionDigits: 2 });
  const PLATS = ["Facebook", "Tiktok", "Zalo", "Google", "Đăng tin"];
  const PLAB = { Facebook: "Facebook", Tiktok: "TikTok", Zalo: "Zalo", Google: "Google Ads", "Đăng tin": "Đăng tin" };
  const PCOL = { Facebook: "var(--fb)", Tiktok: "var(--tt)", Zalo: "var(--zl)", Google: "var(--gg)", "Đăng tin": "var(--dt)" };
  const KIND = { ads: "Chiến dịch", qc: "QC đang chạy", hoadon: "Hoá đơn" };
  // ảnh nghiệm thu bắt buộc theo kênh (hoá đơn bắt buộc, trừ Đăng tin: ảnh chi tiết giao dịch)
  const NEED = { Facebook: ["ads", "qc", "hoadon"], Tiktok: ["ads", "qc", "hoadon"], Zalo: ["ads", "qc", "hoadon"], Google: ["ads", "hoadon"], "Đăng tin": ["ads"] };
  /** Ô ảnh nghiệm thu của một ảnh: Google không có ô "QC đang chạy", Đăng tin chỉ một ô; hoá đơn là ảnh thêm (không bắt buộc). */
  const slotOf = (p, loai) => (p === "Đăng tin" || (p === "Google" && loai === "qc") ? "ads" : loai);
  const pad = (n) => String(n).padStart(2, "0");
  const parseIso = (s) => { const [y, m, d] = String(s).split("-").map(Number); return new Date(y, m - 1, d); };
  const isoOf = (d) => `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}`;
  const addDays = (iso, k) => { const d = parseIso(iso); d.setDate(d.getDate() + k); return isoOf(d); };
  const wkLabel = (iso, year) => { const a = parseIso(iso), b = parseIso(addDays(iso, 6));
    return `${pad(a.getDate())}/${pad(a.getMonth() + 1)} – ${pad(b.getDate())}/${pad(b.getMonth() + 1)}${year ? "/" + b.getFullYear() : ""}`; };

  let K = "", D = null;
  const run = (fn, ...args) => new Promise((ok, fail) => google.script.run.withSuccessHandler(ok).withFailureHandler((e) => fail(new Error(e && e.message ? e.message : String(e))))[fn](...args));

  /** Số nhập tay / từ Sheet thay cho số đọc từ ảnh của cùng người · tuần (giống CRM). */
  function effective(rows) {
    const solid = new Set(rows.filter((r) => r.nguon !== "anh").map((r) => r.tuan + "|" + r.nhanSu));
    return rows.filter((r) => r.nguon !== "anh" || !solid.has(r.tuan + "|" + r.nhanSu));
  }
  function sum(rows) {
    const t = { cost: 0, fee: 0, lead: 0, imp: 0, reach: 0, click: 0, view: 0, mql: 0, sql: 0, deal: 0 };
    rows.forEach((r) => {
      t.cost += num(r.chiPhi); t.fee += num(r.chiPhiPhi) || num(r.chiPhi); t.lead += num(r.lead);
      t.imp += num(r.hienThi); t.reach += num(r.tiepCan); t.click += num(r.luotNhap); t.view += num(r.luotXem);
      t.mql += num(r.mql); t.sql += num(r.sql); t.deal += num(r.deal);
    });
    t.cpl = t.lead ? t.fee / t.lead : 0; t.ctr = t.imp ? (t.click / t.imp) * 100 : 0; t.cpm = t.imp ? (t.cost / t.imp) * 1000 : 0;
    return t;
  }
  let PREV = "tuần trước"; // "tháng trước" ở báo cáo tháng
  const delta = (cur, prev) => {
    if (PREV === "") return `<small>&nbsp;</small>`;
    if (!prev) return `<small>${PREV}: –</small>`;
    const pc = ((cur - prev) / prev) * 100, up = pc >= 0;
    return `<small>${up ? "▲" : "▼"} ${fmt1(Math.abs(pc))}% so với ${PREV} (${fmt(prev)})</small>`;
  };
  /** Kỳ báo cáo: tuần / tháng (tuần thuộc tháng chứa ngày thứ 5) / toàn chiến dịch. */
  function periodOf(d) {
    const ky = d.ky || "tuan", weeks = (d.weeks && d.weeks.length ? d.weeks : [d.tuan]).slice().sort();
    const span = `${wkLabel(weeks[0], true).split(" – ")[0]}/${parseIso(weeks[0]).getFullYear()} – ${wkLabel(weeks[weeks.length - 1], true).split(" – ")[1]}`;
    if (ky === "thang") { const [y, m] = String(d.tuan).split("-"); return { ky, weeks, name: `Tháng ${+m}/${y}`, html: `Tháng <b>${+m}/${y}</b> (${span}, ${weeks.length} tuần)`, prev: "tháng trước" }; }
    if (ky === "all") return { ky, weeks, name: "Toàn chiến dịch", html: `Toàn chiến dịch <b>${span}</b> (${weeks.length} tuần)`, prev: "" };
    return { ky, weeks, name: `tuần ${wkLabel(d.tuan)}`, html: `Tuần <b>${wkLabel(d.tuan, true)}</b>`, prev: "tuần trước" };
  }
  /** Báo cáo nhiều tuần: gộp các dòng cùng kênh + tài khoản. */
  function groupRows(rows) {
    const g = new Map();
    rows.forEach((r) => {
      const k = (r.nenTang || "Facebook") + "|" + (r.taiKhoan || "");
      const o = g.get(k) || { nenTang: r.nenTang || "Facebook", taiKhoan: r.taiKhoan, cd: new Set(), chiPhi: 0, chiPhiPhi: 0, lead: 0, hienThi: 0, luotNhap: 0 };
      if (r.chienDich) o.cd.add(r.chienDich);
      o.chiPhi += num(r.chiPhi); o.chiPhiPhi += num(r.chiPhiPhi) || num(r.chiPhi); o.lead += num(r.lead);
      o.hienThi += num(r.hienThi); o.luotNhap += num(r.luotNhap);
      g.set(k, o);
    });
    return Array.from(g.values()).map((o) => Object.assign(o, { chienDich: Array.from(o.cd).join(", ") }));
  }

  // ------------------------------------------------------------ biểu đồ (SVG thuần, có chú thích khi rê/chạm)
  const tip = () => $("tip");
  function bindTips(root) {
    root.querySelectorAll("[data-tip]").forEach((el) => {
      const show = (e) => {
        const box = el.closest(".chart").getBoundingClientRect(), t = tip();
        t.textContent = el.getAttribute("data-tip");
        const p = e.touches ? e.touches[0] : e;
        t.style.left = (p.clientX + window.scrollX) + "px"; t.style.top = (p.clientY + window.scrollY - 6) + "px";
        t.style.opacity = 1;
        void box;
      };
      el.addEventListener("mousemove", show); el.addEventListener("touchstart", show, { passive: true });
      el.addEventListener("mouseleave", () => (tip().style.opacity = 0));
    });
    tip().style.position = "absolute";
  }
  /** Thanh ngang: items [{label, value, color, note}] – nhãn trực tiếp, không cần chú giải. */
  function hbars(items, unit, W) {
    const rowH = 46, left = Math.min(110, W * 0.28), right = Math.min(120, W * 0.32), max = Math.max(1, ...items.map((x) => x.value));
    const H = items.length * rowH + 6;
    const bars = items.map((x, i) => {
      const y = i * rowH + 8, w = Math.max(2, ((W - left - right) * x.value) / max);
      return `<text x="0" y="${y + 13}">${esc(x.label)}</text>
        <rect x="${left}" y="${y + 2}" width="${w}" height="16" rx="4" fill="${x.color}" data-tip="${esc(x.label)}: ${fmt(x.value)}${unit}${x.note ? " · " + esc(x.note) : ""}"></rect>
        <text class="val" x="${left + w + 8}" y="${y + 15}">${fmt(x.value)}${unit}</text>
        ${x.note ? `<text x="${left}" y="${y + 31}" font-size="11">${esc(x.note)}</text>` : ""}`;
    }).join("");
    return `<div class="chart"><svg width="${W}" height="${H}" viewBox="0 0 ${W} ${H}" role="img">${bars}</svg></div>`;
  }
  /** Thanh ngang xếp chồng theo kênh cho từng nhân sự (có chú giải + tổng ở đầu thanh). */
  function stacked(rowsBy, names, W) {
    const rowH = 34, left = Math.min(110, W * 0.28), right = Math.min(110, W * 0.3);
    const tot = names.map((n) => PLATS.reduce((a, p) => a + (rowsBy[n][p] || 0), 0));
    const max = Math.max(1, ...tot), H = names.length * rowH + 6;
    const used = PLATS.filter((p) => names.some((n) => rowsBy[n][p]));
    const legend = used.length > 1 ? `<div class="legend">${used.map((p) => `<span><i style="background:${PCOL[p]}"></i>${PLAB[p]}</span>`).join("")}</div>` : "";
    const g = names.map((n, i) => {
      const y = i * rowH + 8;
      let x = left;
      const segs = used.map((p) => {
        const v = rowsBy[n][p] || 0;
        if (!v) return "";
        const w = Math.max(2, ((W - left - right) * v) / max);
        const s = `<rect x="${x}" y="${y + 2}" width="${Math.max(1, w - 2)}" height="16" rx="4" fill="${PCOL[p]}" data-tip="${esc(n)} · ${PLAB[p]}: ${fmt(v)} đ"></rect>`;
        x += w;
        return s;
      }).join("");
      return `<text x="0" y="${y + 13}">${esc(n)}</text>${segs}<text class="val" x="${x + 6}" y="${y + 15}">${fmt(tot[i])} đ</text>`;
    }).join("");
    return `${legend}<div class="chart"><svg width="${W}" height="${H}" viewBox="0 0 ${W} ${H}" role="img">${g}</svg></div>`;
  }
  /** Cột theo tuần (một chỉ số, tuần đang báo cáo tô đậm). */
  function columns(points, unit, color, W) {
    const H = 200, bottom = 26, top = 22, max = Math.max(1, ...points.map((p) => p.value));
    const n = points.length, slot = W / n, bw = Math.min(46, slot * 0.55);
    const cols = points.map((p, i) => {
      const h = ((H - bottom - top) * p.value) / max, x = i * slot + (slot - bw) / 2, y = H - bottom - h;
      return `<rect x="${x}" y="${y}" width="${bw}" height="${Math.max(h, p.value ? 2 : 0)}" rx="4" fill="${color}" opacity="${p.cur ? 1 : 0.45}" data-tip="Tuần ${esc(p.label)}: ${fmt(p.value)}${unit}"></rect>
        ${(n <= 6 ? p.cur || i === n - 2 : slot >= 70 || i === n - 1) ? `<text class="val" x="${x + bw / 2}" y="${y - 6}" text-anchor="middle">${fmt(p.value)}</text>` : ""}
        ${slot >= 44 || i % Math.ceil(44 / slot) === 0 ? `<text x="${x + bw / 2}" y="${H - 8}" text-anchor="middle">${esc(p.short)}</text>` : ""}`;
    }).join("");
    return `<div class="chart"><svg width="${W}" height="${H}" viewBox="0 0 ${W} ${H}" role="img"><line class="axis" x1="0" x2="${W}" y1="${H - bottom}" y2="${H - bottom}"></line>${cols}</svg></div>`;
  }

  // ------------------------------------------------------------ dựng trang
  function render() {
    const all = effective(D.soLieu);
    const per = periodOf(D), range = per.ky !== "tuan";
    PREV = per.prev;
    const inW = new Set(per.weeks), inP = new Set(D.prevWeeks || [addDays(D.tuan, -7)]);
    const W = all.filter((r) => inW.has(r.tuan));
    const P = all.filter((r) => inP.has(r.tuan));
    const t = sum(W), tp = sum(P);
    const brand = String(D.logo || "");
    const logo = (window.TATI_LOGOS || {})[brand];
    const order = D.nhanSu || [];
    const ev = D.chungTu || [];
    const staff = Array.from(new Set(W.map((r) => r.nhanSu).concat(ev.map((c) => c.nhanSu)).filter(Boolean)))
      .sort((a, b) => (order.indexOf(a) + 1 || 99) - (order.indexOf(b) + 1 || 99));
    const platsRun = PLATS.filter((p) => W.some((r) => (r.nenTang || "Facebook") === p && (num(r.chiPhi) || num(r.lead))));

    // nghiệm thu: mỗi người × kênh đã chạy × loại ảnh bắt buộc
    const need = [];
    if (!range) staff.forEach((s) => {
      PLATS.forEach((p) => {
        const ran = W.some((r) => r.nhanSu === s && (r.nenTang || "Facebook") === p) || ev.some((c) => c.nhanSu === s && c.nenTang === p);
        if (!ran) return;
        NEED[p].forEach((k) => {
          const got = ev.filter((c) => c.nhanSu === s && c.nenTang === p && slotOf(p, c.loai) === k);
          need.push({ s, p, k, got });
        });
      });
    });
    const okN = need.filter((x) => x.got.length).length;

    const header = `<header class="top">
      ${logo ? `<span class="bm"><img src="${logo.src}" alt="${esc(brand)}" width="${logo.w}" height="${logo.h}"></span>` : ""}
      <div class="title"><h1>${esc(D.chienDich || "Báo cáo Marketing")}</h1>
        <p>Dự án <b>${esc(D.duAn)}</b> · ${per.html} · <span class="badge${D.trangThai === "Đã duyệt" ? " ok" : ""}">${esc(D.trangThai || "Nháp")}</span></p></div>
      <div class="actions">${D.pdfUrl ? `<a class="btn" href="${esc(D.pdfUrl)}" target="_blank" rel="noopener">Mở PDF</a>` : ""}
        <button type="button" class="btn solid" onclick="window.print()">In / Lưu PDF</button></div>
    </header>`;

    const tiles = `<div class="tiles">
      <div class="tile"><span>Chi phí (gồm phí nền tảng)</span><b>${fmt(t.fee)} đ</b>${delta(t.fee, tp.fee)}</div>
      <div class="tile"><span>Ngân sách thực chạy</span><b>${fmt(t.cost)} đ</b>${delta(t.cost, tp.cost)}</div>
      <div class="tile"><span>Lead</span><b>${fmt(t.lead)}</b>${delta(t.lead, tp.lead)}</div>
      <div class="tile"><span>Chi phí / lead</span><b>${t.lead ? fmt(t.cpl) + " đ" : "–"}</b>${t.lead && tp.lead ? delta(t.cpl, tp.cpl) : "<small>&nbsp;</small>"}</div>
      ${range ? `<div class="tile"><span>Số tuần có số liệu</span><b>${new Set(W.map((r) => r.tuan)).size}</b><small>${staff.length} nhân sự</small></div>`
        : `<div class="tile"><span>Nghiệm thu</span><b>${okN}/${need.length}</b><small class="${okN === need.length ? "ok-t" : "miss-t"}">${okN === need.length ? "Đủ ảnh nghiệm thu" : need.length - okN + " trang còn thiếu ảnh"}</small></div>`}
    </div>`;

    // biểu đồ
    const byPlat = platsRun.map((p) => { const s = sum(W.filter((r) => (r.nenTang || "Facebook") === p));
      return { label: PLAB[p], value: s.fee, color: PCOL[p], note: `${fmt(s.lead)} lead · ${t.fee ? fmt1((s.fee / t.fee) * 100) : 0}%` }; });
    const rowsBy = {};
    staff.forEach((s) => { rowsBy[s] = {}; PLATS.forEach((p) => { rowsBy[s][p] = sum(W.filter((r) => r.nhanSu === s && (r.nenTang || "Facebook") === p)).fee; }); });
    const weeks = range ? per.weeks.filter((w) => all.some((r) => r.tuan === w))
      : Array.from(new Set(all.map((r) => r.tuan))).filter((w) => w <= D.tuan).sort().slice(-6);
    const trendC = weeks.map((w) => ({ label: wkLabel(w), short: wkLabel(w).split(" – ")[0], value: sum(all.filter((r) => r.tuan === w)).fee, cur: range || w === D.tuan }));
    const trendL = weeks.map((w) => ({ label: wkLabel(w), short: wkLabel(w).split(" – ")[0], value: sum(all.filter((r) => r.tuan === w)).lead, cur: range || w === D.tuan }));
    // biểu đồ vẽ sau khi có khung (theo bề rộng thật để chữ không bị co nhỏ)
    const staffWith = staff.filter((s) => PLATS.some((p) => rowsBy[s][p]));
    const CH = {
      plat: (W) => (byPlat.length ? hbars(byPlat, " đ", W) : `<p class="muted">Chưa có số liệu.</p>`),
      staff: (W) => (staffWith.length ? stacked(rowsBy, staffWith, W) : `<p class="muted">Chưa có số liệu.</p>`),
      cost: (W) => columns(trendC, " đ", "var(--fb)", W),
      lead: (W) => columns(trendL, " lead", "var(--zl)", W),
    };
    const charts = `<div class="grid2">
      <section class="card"><h2>Chi phí theo kênh</h2><div data-chart="plat"></div></section>
      <section class="card"><h2>Chi phí theo nhân sự</h2><div data-chart="staff"></div></section>
      ${weeks.length > 1 ? `<section class="card"><h2>Chi phí ${range ? "từng tuần" : "các tuần gần đây"}</h2><div data-chart="cost"></div></section>
      <section class="card"><h2>Lead ${range ? "từng tuần" : "các tuần gần đây"}</h2><div data-chart="lead"></div></section>` : ""}
    </div>`;

    // bảng theo kênh
    const tr = (label, s, dot) => `<tr><td>${dot ? `<span class="dot" style="background:${dot}"></span>` : ""}${esc(label)}</td><td>${fmt(s.cost)}</td><td>${fmt(s.fee)}</td><td>${fmt(s.lead)}</td><td>${s.lead ? fmt(s.cpl) : "–"}</td>
      <td>${s.imp ? fmt(s.imp) : "–"}</td><td>${s.reach ? fmt(s.reach) : "–"}</td><td>${s.click ? fmt(s.click) : "–"}</td><td>${s.imp && s.click ? fmt1(s.ctr) + "%" : "–"}</td><td>${s.imp ? fmt(s.cpm) : "–"}</td></tr>`;
    const head = `<tr><th>Kênh</th><th>Ngân sách thực chạy</th><th>Chi phí (+phí)</th><th>Lead</th><th>Chi phí/lead</th><th>Hiển thị</th><th>Tiếp cận</th><th>Lượt nhấp</th><th>CTR</th><th>CPM</th></tr>`;
    const table = `<section class="card"><h2>Tổng hợp theo kênh</h2><div class="wrap"><table><thead>${head}</thead><tbody>
      ${platsRun.map((p) => tr(PLAB[p], sum(W.filter((r) => (r.nenTang || "Facebook") === p)), PCOL[p])).join("")}
      <tr class="total">${tr("Tổng", t).replace(/^<tr>|<\/tr>$/g, "")}</tr></tbody></table></div></section>`;

    // từng nhân sự
    const people = staff.map((s) => {
      const R0 = W.filter((r) => r.nhanSu === s), st = sum(R0), R = range ? groupRows(R0) : R0;
      const ps = PLATS.filter((p) => R.some((r) => (r.nenTang || "Facebook") === p) || ev.some((c) => c.nhanSu === s && c.nenTang === p));
      const rowsT = R.length ? `<div class="wrap"><table><thead><tr><th>Kênh</th><th>ID tài khoản</th><th>Chiến dịch</th><th>Chi phí</th><th>Chi phí (+phí)</th><th>Lead</th><th>Hiển thị</th><th>Nhấp</th></tr></thead><tbody>
        ${R.map((r) => `<tr><td><span class="dot" style="background:${PCOL[r.nenTang || "Facebook"]}"></span>${PLAB[r.nenTang || "Facebook"]}</td><td>${esc(r.taiKhoan || "–")}</td><td class="l">${esc(r.chienDich || "")}</td>
          <td>${fmt(num(r.chiPhi))}</td><td>${fmt(num(r.chiPhiPhi) || num(r.chiPhi))}</td><td>${fmt(num(r.lead))}</td><td>${num(r.hienThi) ? fmt(num(r.hienThi)) : "–"}</td><td>${num(r.luotNhap) ? fmt(num(r.luotNhap)) : "–"}</td></tr>`).join("")}
        </tbody></table></div>` : `<p class="muted">Chưa có số liệu.</p>`;
      const shot = (k) => (c) => `<figure class="shot"><div class="ph" data-img="${esc(c.id)}" data-pdf="${/\.pdf$/i.test(c.tenFile || "") ? 1 : ""}">Đang tải ảnh…</div>
            <figcaption><b>${KIND[c.loai] || KIND[k]}</b>${c.soTien ? ` · ${fmt(num(c.soTien))} đ${c.vat !== "" && c.vat != null ? " (VAT " + esc(c.vat) + "%)" : ""}` : ""}<br>${esc(c.tenFile)}</figcaption></figure>`;
      const chans = range ? "" : ps.map((p) => {
        const slots = NEED[p].map((k) => {
          const got = ev.filter((c) => c.nhanSu === s && c.nenTang === p && slotOf(p, c.loai) === k);
          if (!got.length) return `<figure class="shot miss"><div class="ph">CHƯA CÓ ẢNH<br>${KIND[k]}</div></figure>`;
          return got.map(shot(k)).join("");
        }).join("") + ev.filter((c) => c.nhanSu === s && c.nenTang === p && !NEED[p].includes(slotOf(p, c.loai))).map(shot("hoadon")).join("");
        return `<div class="chan"><div class="chan-h"><span class="dot" style="background:${PCOL[p]}"></span>${PLAB[p]}</div><div class="shots">${slots}</div></div>`;
      }).join("");
      return `<section class="card staff" style="border-top-color:${PCOL[ps[0] || "Facebook"]}">
        <div class="staff-head"><h2>${esc((D.hoTen || {})[s] || s)}</h2>
          <span class="kp">Chi phí (+phí) <b>${fmt(st.fee)} đ</b></span><span class="kp">Lead <b>${fmt(st.lead)}</b></span>
          <span class="kp">Chi phí/lead <b>${st.lead ? fmt(st.cpl) + " đ" : "–"}</b></span></div>
        ${rowsT}${chans}</section>`;
    }).join("");

    const chk = need.length ? `<section class="card"><h2>Kiểm tra nghiệm thu</h2><div class="chk">
      ${need.map((x) => `<div><span class="dot" style="background:${PCOL[x.p]}"></span>${esc(x.s)} · ${PLAB[x.p]} · ${KIND[x.k]}<br>
        ${x.got.length ? `<span class="ok-t">Đủ (${x.got.length} ảnh)</span>` : `<span class="miss-t">Thiếu ảnh</span>`}</div>`).join("")}</div></section>` : "";

    $("report").innerHTML = header + tiles + charts + table + people + chk +
      `<footer>Cập nhật ${esc(D.ngayTao || "")} · Số liệu: nhập tay / Google Sheet ưu tiên hơn số đọc từ ảnh. Rê chuột hoặc chạm vào thanh biểu đồ để xem số.</footer>`;
    $("state").hidden = true;
    $("report").hidden = false;
    document.title = `${D.duAn} · ${per.name} – Báo cáo Marketing`;
    const draw = () => {
      document.querySelectorAll("[data-chart]").forEach((el) => { el.innerHTML = CH[el.dataset.chart](Math.max(260, el.clientWidth)); });
      bindTips($("report"));
    };
    draw();
    let rt = 0;
    window.addEventListener("resize", () => { clearTimeout(rt); rt = setTimeout(draw, 150); });
    lazyImages();
  }

  // ------------------------------------------------------------ ảnh nghiệm thu (tải dần, PDF hiện trang đầu)
  const PDFJS = "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/";
  let pdfReady = null;
  const loadPdf = () => pdfReady || (pdfReady = new Promise((ok, fail) => {
    const s = document.createElement("script"); s.src = PDFJS + "pdf.min.js";
    s.onload = () => { window.pdfjsLib.GlobalWorkerOptions.workerSrc = PDFJS + "pdf.worker.min.js"; ok(window.pdfjsLib); };
    s.onerror = () => fail(new Error("Không tải được bộ đọc PDF")); document.head.appendChild(s);
  }));
  const bytes = (b64) => { const s = atob(b64), a = new Uint8Array(s.length); for (let i = 0; i < s.length; i++) a[i] = s.charCodeAt(i); return a; };
  async function fill(el) {
    try {
      const r = await run("crmWebImage", K, el.dataset.img);
      let url;
      if (el.dataset.pdf || /pdf/.test(r.type)) {
        const lib = await loadPdf();
        const doc = await lib.getDocument({ data: bytes(r.b64) }).promise, page = await doc.getPage(1);
        const vp0 = page.getViewport({ scale: 1 }), vp = page.getViewport({ scale: Math.min(2, 1100 / vp0.width) });
        const c = document.createElement("canvas"); c.width = vp.width; c.height = vp.height;
        await page.render({ canvasContext: c.getContext("2d"), viewport: vp }).promise;
        url = c.toDataURL("image/jpeg", 0.85);
      } else url = URL.createObjectURL(new Blob([bytes(r.b64)], { type: r.type }));
      el.innerHTML = `<img alt="" src="${url}">`;
    } catch (e) { el.textContent = "Không tải được ảnh"; }
  }
  function lazyImages() {
    const els = Array.from(document.querySelectorAll("[data-img]"));
    const queue = [];
    let busy = 0;
    const next = () => { while (busy < 3 && queue.length) { const el = queue.shift(); busy++; fill(el).finally(() => { busy--; next(); }); } };
    const io = "IntersectionObserver" in window ? new IntersectionObserver((ents) => ents.forEach((en) => {
      if (en.isIntersecting) { io.unobserve(en.target); queue.push(en.target); next(); }
    }), { rootMargin: "400px" }) : null;
    els.forEach((el) => (io ? io.observe(el) : (queue.push(el), next())));
    // in: tải hết ảnh trước khi in
    window.addEventListener("beforeprint", () => els.forEach((el) => { if (!el.querySelector("img") && !queue.includes(el)) { queue.push(el); } next(); }));
  }
  document.addEventListener("click", (e) => {
    const z = $("zoom");
    if (z) { z.remove(); return; }
    const img = e.target.closest(".shot img");
    if (img) { const d = document.createElement("div"); d.id = "zoom"; d.innerHTML = `<img alt="" src="${img.src}">`; document.body.appendChild(d); }
  });

  async function start() {
    try {
      K = await new Promise((res) => { try { google.script.url.getLocation((l) => res((l.parameter || {}).k || "")); } catch (_) { res(""); } setTimeout(() => res(""), 3000); });
      if (!K) throw new Error("Link báo cáo thiếu mã. Nhờ quản trị gửi lại link.");
      D = await run("crmWebReport", K);
      render();
    } catch (e) { $("state").textContent = e.message; }
  }
  window.BaoCaoWeb = { effective, sum, render: (d) => { D = d; render(); } };
  if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", start); else start();
})();
