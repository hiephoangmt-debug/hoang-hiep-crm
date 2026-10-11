/* CRM Báo cáo Marketing – giao diện (chạy trong Google Apps Script, dữ liệu ở Google Sheet).
 * Dùng phần lõi tạo báo cáo của bao-cao-mkt/app.js qua window.BaoCaoMkt. */
(function () {
  "use strict";

  const B = window.BaoCaoMkt;
  const { PLATFORMS, KINDS, fmtInt, gas } = B;
  const PLATFORM_LABEL = { Facebook: "Facebook", Tiktok: "TikTok", Zalo: "Zalo", Google: "Google" };
  const STATUSES = ["Nháp", "Đã nộp", "Đã duyệt"];

  const $ = (id) => document.getElementById(id);
  const esc = (s) => String(s == null ? "" : s).replace(/[&<>"]/g, (c) => ({ "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;" }[c]));
  const num = (v) => {
    if (v === "" || v == null) return 0;
    if (typeof v === "number") return v;
    return B.toNum(v);
  };
  const opt = (v, label, cur) => `<option value="${esc(v)}"${String(v) === String(cur) ? " selected" : ""}>${esc(label == null ? v : label)}</option>`;

  // ------------------------------------------------------------ tuần
  const pad = (n) => String(n).padStart(2, "0");
  const isoOf = (d) => `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}`;
  const parseIso = (s) => { const [y, m, d] = String(s).split("-").map(Number); return new Date(y, m - 1, d); };
  const mondayOf = (d) => { const x = new Date(d.getFullYear(), d.getMonth(), d.getDate()); x.setDate(x.getDate() - ((x.getDay() + 6) % 7)); return x; };
  function weekLabel(iso, withYear) {
    const a = parseIso(iso), b = new Date(a);
    b.setDate(a.getDate() + 6);
    return `${pad(a.getDate())}/${pad(a.getMonth() + 1)} - ${pad(b.getDate())}/${pad(b.getMonth() + 1)}` + (withYear ? `/${b.getFullYear()}` : "");
  }
  /** "05/10 - 11/10" + năm -> "2026-10-05" */
  function isoFromLabel(label, year) {
    const m = /^(\d{1,2})\/(\d{1,2})/.exec(label.trim());
    return m ? `${year}-${pad(m[2])}-${pad(m[1])}` : null;
  }
  const extraWeeks = new Set(); // tuần chọn bằng lịch ("Tuần khác…")
  function weekList() {
    const set = new Set(extraWeeks);
    let d = mondayOf(new Date());
    d.setDate(d.getDate() + 7);
    for (let i = 0; i < 20; i++) { set.add(isoOf(d)); d.setDate(d.getDate() - 7); }
    S.SoLieu.forEach((r) => r.tuan && set.add(r.tuan));
    S.ChungTu.forEach((r) => r.tuan && set.add(r.tuan));
    return Array.from(set).sort().reverse();
  }
  const latestDataWeek = () => S.SoLieu.map((r) => r.tuan).sort().pop() || isoOf(mondayOf(new Date()));

  // ------------------------------------------------------------ trạng thái
  const S = { DuAn: [], NhanSu: [], TaiKhoan: [], SoLieu: [], ChungTu: [], BaoCao: [], schema: {}, appUrl: "", sheetUrl: "", user: "" };
  // ------------------------------------------------------------ đơn vị (2 bên: TATILAND / TATI INVEST)
  const BRANDS = Object.keys((window.BAO_CAO_MKT_CONFIG || {}).logos || { TATILAND: 1, "TATI INVEST": 1 });
  const slug = (b) => B.norm(b).replace(/[^a-z0-9]/g, "");
  let brand = "";
  const brandProjects = () => S.DuAn.filter((p) => !brand || !p.logo || p.logo === brand);
  const brandNames = () => brandProjects().map((p) => p.ten);
  const inBrand = (pjName) => brandNames().includes(pjName);
  function brandMark(b) {
    if (!b) return `<span class="bm-all">Tất cả đơn vị</span>`;
    const rest = b.replace(/^TATI\s*/i, "");
    return `<span class="bm"><i class="t1">TA</i><i class="t2">TI</i><i class="t3">${esc(rest)}</i></span>`;
  }
  // Trang hướng dẫn: config.guideUrl nếu có, không thì trang ?page=huongdan của chính ứng dụng
  const guideUrl = () => ((window.BAO_CAO_MKT_CONFIG || {}).guideUrl || "").trim() || (S.appUrl ? S.appUrl + "?page=huongdan" : "#");
  function setBrand(b, quiet) {
    brand = BRANDS.includes(b) ? b : "";
    try { localStorage.setItem("crm.brand", brand); } catch (_) { /* bỏ qua */ }
    document.querySelectorAll("[data-brand]").forEach((x) => x.classList.toggle("on", x.dataset.brand === brand));
    $("brandMark").innerHTML = brandMark(brand);
    document.title = (brand ? brand + " · " : "") + "CRM Báo cáo Marketing";
    const link = S.appUrl ? S.appUrl + (brand ? "?donvi=" + slug(brand) : "") : "";
    $("brandLink").hidden = !link || !brand;
    $("brandLink").dataset.url = link;
    $("guideLink").href = guideUrl();
    if (quiet) return;
    ["dbProject", "enProject", "evProject", "rpProject"].forEach((id) => { if (!inBrand($(id).value)) $(id).value = ""; });
    refreshFilters();
    showTab(document.querySelector("nav button.on") ? document.querySelector("nav button.on").dataset.tab : "tong");
  }

  const staffNames = () => S.NhanSu.filter((n) => n.trangThai !== "Nghỉ").map((n) => n.ten);
  const project = (name) => S.DuAn.find((p) => p.ten === name) || {};
  const digitsOf = (s) => (String(s).match(/\d{6,}/) || [""])[0];
  const accountStaff = (id) => { const a = S.TaiKhoan.find((t) => digitsOf(t.maTaiKhoan) === digitsOf(id) && digitsOf(id)); return a ? a.nhanSu : ""; };

  function toast(msg, kind) {
    const el = $("toast");
    el.textContent = msg;
    el.className = "toast show " + (kind || "");
    clearTimeout(toast.t);
    if (kind !== "busy") toast.t = setTimeout(() => (el.className = "toast"), kind === "err" ? 8000 : 3500);
  }
  async function run(label, fn) {
    toast(label + "…", "busy");
    try { const r = await fn(); return r; } catch (e) { console.error(e); toast("Lỗi: " + e.message, "err"); throw e; }
  }

  async function reload(tables) {
    const list = tables || ["DuAn", "NhanSu", "TaiKhoan", "SoLieu", "ChungTu", "BaoCao"];
    const res = await Promise.all(list.map((t) => gas("crmList", t)));
    list.forEach((t, i) => (S[t] = res[i]));
  }

  // ------------------------------------------------------------ bộ lọc dùng chung
  function fillSelect(el, options, cur, all) {
    el.innerHTML = (all ? opt("", all, cur) : "") + options.map((o) => (Array.isArray(o) ? opt(o[0], o[1], cur) : opt(o, o, cur))).join("");
    if (cur != null && Array.from(el.options).some((o) => o.value === String(cur))) el.value = cur;
  }
  // ------------------------------------------------------------ chọn tuần bất kỳ bằng lịch
  const PICK_WEEK = "__pick";
  const WEEK_SELECTS = /^(en|ev|rp)Week$/;
  // ------------------------------------------------------------ thêm nhân sự mới ngay tại ô chọn tên
  const NEW_STAFF = "__newstaff";
  const newStaffOpt = () => `<option value="${NEW_STAFF}">+ Thêm nhân sự mới…</option>`;
  function bindNewStaff() {
    const isStaffSel = (el) => el.tagName === "SELECT" && Array.from(el.options).some((o) => o.value === NEW_STAFF);
    document.addEventListener("focusin", (e) => { if (isStaffSel(e.target) && e.target.value !== NEW_STAFF) e.target.dataset.keepStaff = e.target.value; }, true);
    document.addEventListener("change", async (e) => {
      const sel = e.target;
      if (!isStaffSel(sel)) return;
      if (sel.value !== NEW_STAFF) { sel.dataset.keepStaff = sel.value; return; }
      e.stopImmediatePropagation();
      sel.value = sel.dataset.keepStaff || "";
      const name = (prompt("Tên nhân sự mới (ví dụ: Hoàng Hiệp):") || "").trim().replace(/\s+/g, " ");
      if (!name) return;
      let found = S.NhanSu.find((n) => B.norm(n.ten) === B.norm(name));
      if (!found) {
        try { found = await run("Đang thêm nhân sự", () => gas("crmSave", "NhanSu", { ten: name, trangThai: "Đang làm" })); }
        catch (_) { return; }
        S.NhanSu.push(found);
        toast(`Đã thêm nhân sự "${found.ten}" (sửa email/trạng thái ở tab Danh mục).`, "ok");
      } else if (found.trangThai === "Nghỉ") {
        found.trangThai = "Đang làm";
        try { await gas("crmSave", "NhanSu", { id: found.id, trangThai: "Đang làm" }); } catch (_) { /* bỏ qua */ }
      }
      refreshFilters();
      if (!Array.from(sel.options).some((o) => o.value === found.ten)) sel.add(new Option(found.ten, found.ten), sel.options.length - 1);
      sel.value = found.ten;
      sel.dataset.keepStaff = found.ten;
      sel.dispatchEvent(new Event("change", { bubbles: true }));
    }, true);
  }
  function bindWeekPicker() {
    const box = $("weekPick"), inp = $("weekPickDate");
    document.addEventListener("focusin", (e) => {
      if (WEEK_SELECTS.test(e.target.id) && e.target.value !== PICK_WEEK) e.target.dataset.keep = e.target.value;
    }, true);
    // chặn trước các xử lý "change" khác: chọn mục "Tuần khác…" thì mở lịch, giữ tuần cũ cho tới khi chọn ngày
    document.addEventListener("change", (e) => {
      const sel = e.target;
      if (!WEEK_SELECTS.test(sel.id)) return;
      if (sel.value !== PICK_WEEK) { sel.dataset.keep = sel.value; return; }
      e.stopImmediatePropagation();
      sel.value = sel.dataset.keep || latestDataWeek();
      box.dataset.for = sel.id;
      inp.value = sel.value;
      box.hidden = false;
      try { inp.showPicker(); } catch (_) { inp.focus(); }
    }, true);
    inp.addEventListener("change", () => {
      if (!inp.value) return;
      const [y, m, d] = inp.value.split("-").map(Number);
      const w = isoOf(mondayOf(new Date(y, m - 1, d)));
      const sel = $(box.dataset.for);
      box.hidden = true;
      extraWeeks.add(w);
      const keep = { en: $("enWeek").value, ev: $("evWeek").value, rp: $("rpWeek").value };
      refreshFilters();
      ["en", "ev", "rp"].forEach((p) => { if ($(p + "Week").id !== sel.id) $(p + "Week").value = keep[p]; });
      sel.value = w;
      sel.dispatchEvent(new Event("change", { bubbles: true }));
    });
    $("weekPickClose").addEventListener("click", () => { box.hidden = true; });
  }
  function refreshFilters() {
    const weeks = weekList().map((w) => [w, weekLabel(w, true)]);
    const projects = brandNames();
    const staff = staffNames();
    // Tổng quan
    const dataWeeks = Array.from(new Set(S.SoLieu.map((r) => r.tuan))).sort();
    const allW = (dataWeeks.length ? dataWeeks : [latestDataWeek()]).map((w) => [w, weekLabel(w, true)]);
    fillSelect($("dbProject"), projects, $("dbProject").value, "Tất cả dự án");
    fillSelect($("dbFrom"), allW, $("dbFrom").value || allW[Math.max(0, allW.length - 4)][0]);
    fillSelect($("dbTo"), allW, $("dbTo").value || allW[allW.length - 1][0]);
    // Nhập số liệu / Chứng từ / Báo cáo
    for (const p of ["en", "ev", "rp"]) {
      fillSelect($(p + "Week"), weeks, $(p + "Week").value || latestDataWeek());
      $(p + "Week").add(new Option("Tuần khác… (chọn ngày trên lịch)", PICK_WEEK));
      fillSelect($(p + "Project"), projects, p === "rp" ? $(p + "Project").value : $(p + "Project").value || projects[0], p === "rp" ? "Tất cả dự án" : null);
    }
    fillSelect($("enStaff"), staff, $("enStaff").value, "Tất cả nhân sự");
    let me = "";
    try { me = localStorage.getItem("crm.me") || ""; } catch (_) { /* bỏ qua */ }
    fillSelect($("evStaff"), staff, $("evStaff").value || (staff.includes(me) ? me : ""), "— Chọn tên bạn —");
    $("evStaff").insertAdjacentHTML("beforeend", newStaffOpt());
    $("evStaff").classList.toggle("warn", !$("evStaff").value);
    $("accList").innerHTML = S.TaiKhoan.map((t) => `<option value="${esc(t.maTaiKhoan)}">${esc((t.nhanSu || "") + " · " + (t.ten || t.nenTang || ""))}</option>`).join("");
  }

  // ------------------------------------------------------------ tab
  function showTab(name) {
    document.querySelectorAll("[data-tab]").forEach((b) => b.classList.toggle("on", b.dataset.tab === name));
    document.querySelectorAll(".panel").forEach((p) => (p.hidden = p.id !== "tab-" + name));
    try { localStorage.setItem("crm.tab", name); } catch (_) { /* bỏ qua */ }
    ({ tong: renderDashboard, nhap: renderEntries, chungtu: renderEvidence, baocao: renderReports, danhmuc: renderCatalog }[name] || (() => {}))();
  }

  /** Số liệu đọc từ ảnh chỉ được tính khi người đó (tuần + dự án) chưa có số từ sheet/nhập tay. */
  function effective(rows) {
    const solid = new Set(rows.filter((r) => r.nguon !== "anh").map((r) => r.tuan + "|" + r.duAn + "|" + r.nhanSu));
    return rows.filter((r) => r.nguon !== "anh" || !solid.has(r.tuan + "|" + r.duAn + "|" + r.nhanSu));
  }
  const isShadowed = (r) => r.nguon === "anh" && S.SoLieu.some((x) => x.nguon !== "anh" && x.tuan === r.tuan && x.duAn === r.duAn && x.nhanSu === r.nhanSu);

  // ------------------------------------------------------------ TỔNG QUAN
  function sumOf(rows) {
    const t = { chiPhi: 0, chiPhiPhi: 0, lead: 0, mql: 0, sql: 0, deal: 0, hienThi: 0 };
    rows.forEach((r) => {
      t.chiPhi += num(r.chiPhi);
      t.chiPhiPhi += num(r.chiPhiPhi) || num(r.chiPhi);
      t.lead += num(r.lead); t.mql += num(r.mql); t.sql += num(r.sql); t.deal += num(r.deal);
      t.hienThi += num(r.hienThi);
    });
    t.cpl = t.lead ? t.chiPhiPhi / t.lead : 0;
    t.accounts = new Set(rows.map((r) => r.taiKhoan).filter(Boolean)).size;
    return t;
  }
  function group(rows, key) {
    const m = new Map();
    rows.forEach((r) => { const k = r[key] || "(chưa gán)"; if (!m.has(k)) m.set(k, []); m.get(k).push(r); });
    return Array.from(m, ([k, rs]) => [k, sumOf(rs)]);
  }
  function barTable(title, rows, labelHead) {
    const max = Math.max(1, ...rows.map(([, t]) => t.chiPhiPhi));
    const total = rows.reduce((s, [, t]) => s + t.chiPhiPhi, 0) || 1;
    return `<section class="card"><h3>${esc(title)}</h3><div class="wrap"><table class="data">
      <thead><tr><th>${esc(labelHead)}</th><th class="barcol">Chi phí (gồm phí)</th><th>Lead</th><th>CPL</th><th>Tỷ trọng</th></tr></thead><tbody>
      ${rows.map(([k, t]) => `<tr><td>${esc(PLATFORM_LABEL[k] || k)}</td>
        <td class="barcol"><div class="hbar"><b>${fmtInt(t.chiPhiPhi)}</b><i><span style="width:${(t.chiPhiPhi / max) * 100}%"></span></i></div></td>
        <td>${fmtInt(t.lead)}</td><td>${t.lead ? fmtInt(t.cpl) : "–"}</td><td>${Math.round((t.chiPhiPhi / total) * 100)}%</td></tr>`).join("")}
      </tbody></table></div></section>`;
  }
  function renderDashboard() {
    const pj = $("dbProject").value, from = $("dbFrom").value, to = $("dbTo").value;
    const rows = effective(S.SoLieu.filter((r) => (pj ? r.duAn === pj : inBrand(r.duAn)) && r.tuan >= from && r.tuan <= to));
    const t = sumOf(rows);
    const tiles = [
      ["Chi phí gồm phí nền tảng", fmtInt(t.chiPhiPhi) + " đ"],
      ["Chi phí thực chạy", fmtInt(t.chiPhi) + " đ"],
      ["Lead", fmtInt(t.lead)],
      ["Chi phí / lead", t.lead ? fmtInt(t.cpl) + " đ" : "–"],
      ["Tài khoản QC", fmtInt(t.accounts)],
    ];
    if (t.mql || t.sql || t.deal) tiles.push(["MQL / SQL / DEAL", `${fmtInt(t.mql)} / ${fmtInt(t.sql)} / ${fmtInt(t.deal)}`]);
    // cột theo tuần
    const byWeek = Array.from(new Set(rows.map((r) => r.tuan))).sort().map((w) => [w, sumOf(rows.filter((r) => r.tuan === w))]);
    const maxW = Math.max(1, ...byWeek.map(([, x]) => x.chiPhiPhi));
    const chart = byWeek.length
      ? `<div class="cols" role="img" aria-label="Chi phí gồm phí theo tuần">${byWeek.map(([w, x]) =>
          `<div class="col" title="${esc(weekLabel(w, true))}: ${fmtInt(x.chiPhiPhi)} đ · ${fmtInt(x.lead)} lead">
             <small>${fmtInt(x.chiPhiPhi / 1e6 * 10) / 10 > 0 ? (x.chiPhiPhi / 1e6).toFixed(1).replace(".", ",") + " tr" : "0"}</small>
             <span style="height:${Math.max(2, (x.chiPhiPhi / maxW) * 100)}%"></span>
             <em>${esc(weekLabel(w).split(" - ")[0])}</em></div>`).join("")}</div>`
      : `<p class="muted">Chưa có số liệu trong khoảng này.</p>`;
    $("dbBody").innerHTML = `
      <div class="tiles">${tiles.map(([k, v]) => `<div class="tile"><span>${esc(k)}</span><b>${esc(v)}</b></div>`).join("")}</div>
      <section class="card"><h3>Chi phí gồm phí theo tuần</h3>${chart}</section>
      <div class="two">
        ${barTable("Theo nhân sự", group(rows, "nhanSu").sort((a, b) => b[1].chiPhiPhi - a[1].chiPhiPhi), "Nhân sự")}
        ${barTable("Theo dự án", group(rows, "duAn"), "Dự án")}
      </div>
      ${barTable("Theo kênh", group(rows, "nenTang"), "Kênh")}`;
  }

  // ------------------------------------------------------------ NHẬP SỐ LIỆU (bảng theo mẫu báo cáo)
  // Cột giống bảng trong file PPTX; Frequency/CTR/CPM tự tính.
  const GRID = [
    ["nhanSu", "Nhân sự", "staff"],
    ["taiKhoan", "ID tài khoản", "acc"],
    ["chiPhi", "Ngân sách thực chạy", "num"],
    ["chiPhiPhi", "Chi phí thực chạy (+ gồm phí nền tảng)", "num"],
    ["lead", "LEAD", "num"],
    ["mql", "MQL (Khách hàng quan tâm)", "num"],
    ["sql", "SQL (Khách hàng tiềm năng)", "num"],
    ["deal", "DEAL", "num"],
    ["hienThi", "Impressions (hiển thị)", "num"],
    ["tiepCan", "Reach (tiếp cận)", "num"],
    ["_freq", "Frequency (tần suất)", "calc"],
    ["luotNhap", "Lượt nhấp", "num"],
    ["_ctr", "CTR", "calc"],
    ["_cpm", "CPM", "calc"],
    ["luotXem", "Lượt xem", "num"],
    ["chienDich", "Chiến dịch / ghi chú", "text"],
  ];
  const drafts = new Map(); // id -> dòng đang sửa (id "new-…" = dòng mới)
  const isNew = (id) => String(id).startsWith("new-");
  function calc(r, key) {
    const imp = num(r.hienThi), reach = num(r.tiepCan), clicks = num(r.luotNhap), cost = num(r.chiPhi);
    if (key === "_freq") return reach ? B.fmtDec(imp / reach) : "";
    if (key === "_ctr") return imp && r.luotNhap !== "" ? B.fmtDec((clicks / imp) * 100) + "%" : "";
    if (key === "_cpm") return imp && cost ? fmtInt((cost / imp) * 1000) : "";
    return "";
  }
  const fmtCell = (v) => (v === "" || v == null ? "" : fmtInt(num(v)));
  function gridRows() {
    const w = $("enWeek").value, pj = $("enProject").value, st = $("enStaff").value;
    const saved = S.SoLieu.filter((r) => r.tuan === w && r.duAn === pj && (!st || r.nhanSu === st))
      .map((r) => drafts.get(r.id) || r);
    const fresh = Array.from(drafts.values()).filter((r) => isNew(r.id) && r.tuan === w && r.duAn === pj);
    return saved.concat(fresh);
  }
  function renderEntries() {
    const src = project($("enProject").value).nguonSoLieu || "";
    $("enSheet").hidden = !src;
    $("enSheet").href = src || "#";
    const rows = gridRows();
    const staff = staffNames();
    const cell = (r, [k, , type]) => {
      const id = esc(r.id);
      if (type === "staff") return `<td><select data-g="${id}" data-f="${k}">${opt("", "(chọn)", r[k])}${staff.map((x) => opt(x, x, r[k])).join("")}${newStaffOpt()}</select></td>`;
      if (type === "acc") return `<td><input data-g="${id}" data-f="${k}" value="${esc(r[k])}" list="accList" class="acc"></td>`;
      if (type === "calc") return `<td class="calc">${calc(r, k)}</td>`;
      if (type === "text") return `<td><input data-g="${id}" data-f="${k}" value="${esc(r[k])}" class="txt"></td>`;
      return `<td><input data-g="${id}" data-f="${k}" value="${fmtCell(r[k])}" inputmode="numeric" class="n"></td>`;
    };
    const totalRow = (rs, label) => {
      const t = { chiPhi: 0, chiPhiPhi: 0, lead: 0, mql: 0, sql: 0, deal: 0, hienThi: 0, tiepCan: 0, luotNhap: 0, luotXem: 0 };
      effective(rs.filter((r) => !isNew(r.id) || drafts.has(r.id))).forEach((r) => Object.keys(t).forEach((k) => (t[k] += num(r[k]))));
      const tr = Object.assign({}, t, { luotNhap: t.luotNhap || "" });
      return `<tr class="total"><td colspan="2">${label}</td>${GRID.slice(2).map(([k, , type]) =>
        `<td class="${type === "calc" ? "calc" : ""}">${type === "calc" ? calc(tr, k) : type === "text" ? "" : fmtInt(t[k])}</td>`).join("")}<td></td></tr>`;
    };
    const sections = PLATFORMS.map((p) => {
      const rs = rows.filter((r) => (r.nenTang || "Facebook") === p);
      const body = rs.map((r) => `<tr class="${drafts.has(r.id) ? "dirty" : ""}${isShadowed(r) ? " shadow" : ""}">
          ${GRID.map((c) => cell(r, c)).join("")}
          <td class="act">${r.nguon === "anh" ? `<small class="muted" title="${esc(r.ghiChu)}">ảnh${isShadowed(r) ? " · không tính" : ""}</small>` : ""}
            <button type="button" class="link danger" data-gdel="${esc(r.id)}" title="Xoá dòng">✕</button></td></tr>`).join("");
      return `<section class="card grid-sec${rs.length ? "" : " empty"}">
        <div class="sec-head"><h3>${PLATFORM_LABEL[p].toUpperCase()}</h3>
          <button type="button" class="ghost small" data-gadd="${p}">+ Thêm tài khoản ${PLATFORM_LABEL[p]}</button></div>
        ${rs.length ? `<div class="wrap"><table class="data sheet"><thead><tr>${GRID.map(([, h]) => `<th>${esc(h)}</th>`).join("")}<th></th></tr></thead>
          <tbody>${body}${rs.length > 1 ? totalRow(rs, "TỔNG " + PLATFORM_LABEL[p]) : ""}</tbody></table></div>` : ""}
      </section>`;
    }).join("");
    const all = effective(rows);
    const t = sumOf(all);
    $("enTable").innerHTML = `
      <div class="tiles">
        <div class="tile"><span>Ngân sách thực chạy</span><b>${fmtInt(t.chiPhi)}</b></div>
        <div class="tile"><span>Chi phí (+ phí nền tảng)</span><b>${fmtInt(t.chiPhiPhi)}</b></div>
        <div class="tile"><span>LEAD</span><b>${fmtInt(t.lead)}</b></div>
        <div class="tile"><span>MQL / SQL / DEAL</span><b>${fmtInt(t.mql)} / ${fmtInt(t.sql)} / ${fmtInt(t.deal)}</b></div>
      </div>${sections}`;
    const n = drafts.size;
    $("enSave").disabled = !n;
    $("enSave").textContent = n ? `Lưu thay đổi (${n} dòng)` : "Đã lưu";
    $("enDiscard").hidden = !n;
  }
  function draftOf(id) {
    if (!drafts.has(id)) drafts.set(id, Object.assign({}, S.SoLieu.find((x) => x.id === id)));
    return drafts.get(id);
  }
  function addRow(platform) {
    const id = "new-" + Math.random().toString(36).slice(2, 9);
    const st = $("enStaff").value || "";
    const acc = st ? soleAccount(st, platform) : "";
    drafts.set(id, {
      id, tuan: $("enWeek").value, duAn: $("enProject").value, nhanSu: st, nenTang: platform, taiKhoan: acc, chienDich: "",
      chiPhi: "", chiPhiPhi: "", lead: "", mql: "", sql: "", deal: "", hienThi: "", tiepCan: "", luotNhap: "", luotXem: "", ghiChu: "", nguon: "tay",
    });
    renderEntries();
    const el = document.querySelector(`[data-g="${id}"][data-f="${st ? "taiKhoan" : "nhanSu"}"]`);
    if (el) el.focus();
  }
  function gridChange(el) {
    const r = draftOf(el.dataset.g), f = el.dataset.f;
    if (GRID.find((c) => c[0] === f)[2] === "num") {
      const v = el.value.trim();
      r[f] = v === "" ? "" : num(v);
      if (f === "chiPhi" && (r.chiPhiPhi === "" || r.chiPhiPhi == null)) r.chiPhiPhi = r[f];
    } else r[f] = el.value.trim();
    if (f === "taiKhoan") {
      const a = S.TaiKhoan.find((t) => digitsOf(t.maTaiKhoan) && digitsOf(t.maTaiKhoan) === digitsOf(r.taiKhoan));
      if (a && a.nhanSu && !r.nhanSu) r.nhanSu = a.nhanSu;
    }
    if (f === "nhanSu" && !r.taiKhoan) r.taiKhoan = soleAccount(r.nhanSu, r.nenTang);
    renderEntries();
  }
  async function saveGrid() {
    const list = Array.from(drafts.values());
    const bad = list.filter((r) => !r.nhanSu);
    if (bad.length) return toast("Chọn nhân sự cho mọi dòng trước khi lưu.", "err");
    const empty = list.filter((r) => isNew(r.id) && !num(r.chiPhi) && !num(r.lead) && !num(r.hienThi));
    empty.forEach((r) => drafts.delete(r.id));
    const toSave = list.filter((r) => !empty.includes(r)).map((r) => {
      const o = Object.assign({}, r);
      if (isNew(o.id)) delete o.id;
      if (o.chiPhiPhi === "" || o.chiPhiPhi == null) o.chiPhiPhi = o.chiPhi;
      return o;
    });
    if (!toSave.length) { renderEntries(); return; }
    const saved = await run("Đang lưu", () => gas("crmSaveMany", "SoLieu", toSave));
    saved.forEach((r) => { S.SoLieu = S.SoLieu.filter((x) => x.id !== r.id).concat(r); });
    // tài khoản mới -> danh mục
    const newAcc = new Map();
    saved.forEach((r) => {
      if (r.taiKhoan && digitsOf(r.taiKhoan) && !S.TaiKhoan.some((t) => digitsOf(t.maTaiKhoan) === digitsOf(r.taiKhoan))) {
        newAcc.set(digitsOf(r.taiKhoan), { maTaiKhoan: r.taiKhoan, nenTang: r.nenTang, nhanSu: r.nhanSu });
      }
    });
    if (newAcc.size) S.TaiKhoan = S.TaiKhoan.concat(await gas("crmSaveMany", "TaiKhoan", Array.from(newAcc.values())));
    drafts.clear();
    toast(`Đã lưu ${saved.length} dòng.`, "ok");
    refreshFilters();
    renderEntries();
  }
  async function deleteRow(id) {
    if (isNew(id)) { drafts.delete(id); renderEntries(); return; }
    const r = S.SoLieu.find((x) => x.id === id);
    if (!r || !confirm(`Xoá dòng ${r.nhanSu} · ${r.taiKhoan || ""} · ${fmtInt(num(r.chiPhi))} đ?`)) return;
    await run("Đang xoá", () => gas("crmDelete", "SoLieu", id));
    S.SoLieu = S.SoLieu.filter((x) => x.id !== id);
    drafts.delete(id);
    toast("Đã xoá.", "ok");
    renderEntries();
  }
  function confirmDiscard() {
    if (!drafts.size) return true;
    if (!confirm(`Có ${drafts.size} dòng chưa lưu. Bỏ các thay đổi này?`)) return false;
    drafts.clear();
    return true;
  }

  /** Nhập số liệu từ Google Sheet của dự án (mẫu "BÁO CÁO NGHIỆM THU THÁNG"). */
  async function importSheet() {
    if (!confirmDiscard()) return;
    const pj = project($("enProject").value);
    if (!B.parseDriveId(pj.nguonSoLieu)) return toast("Dự án chưa có link Google Sheet số liệu (tab Danh mục).", "err");
    let id = B.parseDriveId(pj.nguonSoLieu);
    try { const src = await gas("crmSheetSource", pj.ten); id = src.id; if (src.switched) { pj.nguonSoLieu = src.url; renderEntries(); } } catch (e) { console.error(e); }
    const year = parseIso($("enWeek").value).getFullYear();
    const r = await run("Đang đọc Google Sheet", () => gas("downloadFile", id));
    const wb = XLSX.read(Uint8Array.from(atob(r.b64), (c) => c.charCodeAt(0)), { type: "array" });
    const weeks = B.loadData(wb);
    const list = [], weekIsos = [];
    const known = new Set(staffNames());
    const newStaff = new Set(), newAcc = new Map();
    Object.entries(weeks).forEach(([label, data]) => {
      const iso = isoFromLabel(label, year);
      if (!iso || !PLATFORMS.some((p) => data[p].length)) return;
      weekIsos.push(iso);
      PLATFORMS.forEach((p) => data[p].forEach((rec) => {
        const acc = digitsOf(rec.account) || rec.account;
        const st = accountStaff(acc) || B.staffNameFromAccount(rec.account) || "";
        if (st && !known.has(st)) newStaff.add(st);
        if (digitsOf(acc) && !S.TaiKhoan.some((t) => digitsOf(t.maTaiKhoan) === digitsOf(acc))) newAcc.set(acc, { maTaiKhoan: acc, nenTang: p, nhanSu: st });
        list.push({
          tuan: iso, duAn: pj.ten, nhanSu: st, nenTang: p, taiKhoan: acc, chienDich: "",
          chiPhi: rec.cost, chiPhiPhi: rec.cost_fee || rec.cost, lead: rec.lead, hienThi: rec.impressions || "", tiepCan: rec.reach || "",
          luotNhap: rec.clicks || "", luotXem: rec.views || "", mql: "", sql: "", deal: "", ghiChu: "",
        });
      }));
    });
    if (!list.length) return toast("Sheet không có dòng số liệu nào.", "err");
    if (!confirm(`Nhập ${list.length} dòng (${weekIsos.map((w) => weekLabel(w)).join(", ")}) cho ${pj.ten}?\nCác dòng đã nhập từ sheet trước đó của những tuần này sẽ được thay thế; dòng nhập tay giữ nguyên.`)) return;
    await run("Đang nhập", async () => {
      if (newStaff.size) await gas("crmSaveMany", "NhanSu", Array.from(newStaff).map((ten) => ({ ten })));
      if (newAcc.size) await gas("crmSaveMany", "TaiKhoan", Array.from(newAcc.values()));
      await gas("crmImportEntries", pj.ten, weekIsos, list);
      await reload(["NhanSu", "TaiKhoan", "SoLieu"]);
    });
    toast(`Đã nhập ${list.length} dòng.` + (list.some((x) => !x.nhanSu) ? " Có dòng chưa gán nhân sự – gán tài khoản ở tab Danh mục rồi nhập lại." : ""), "ok");
    refreshFilters();
    renderEntries();
  }

  /** Ghi số đọc từ ảnh (nguồn "anh") của dự án + tuần vào Google Sheet số liệu của dự án: chỉ ô trống / ô app đã ghi. */
  async function pushToSheet(pjName, w) {
    const groups = new Map();
    S.SoLieu.filter((r) => r.nguon === "anh" && r.duAn === pjName && r.tuan === w).forEach((r) => {
      const key = r.nenTang + "|" + (digitsOf(r.taiKhoan) || r.nhanSu);
      const g = groups.get(key) || { nenTang: r.nenTang, taiKhoan: r.taiKhoan || "", nhanSu: r.nhanSu || "", chiPhi: 0, lead: 0, luotXem: "", hienThi: "", tiepCan: "", luotNhap: "" };
      g.chiPhi += num(r.chiPhi);
      g.lead += num(r.lead);
      ["luotXem", "hienThi", "tiepCan", "luotNhap"].forEach((k) => { if (r[k] !== "" && r[k] != null) g[k] = num(g[k]) + num(r[k]); });
      groups.set(key, g);
    });
    if (!groups.size) return null;
    // lead = 0 nghĩa là ảnh không có số lead: để trống ô Lead trong Sheet cho các bạn tự điền
    const res = await gas("crmWriteSheet", pjName, w, Array.from(groups.values()).map((g) => Object.assign(g, { lead: g.lead || "" })));
    if (res && res.source) { project(pjName).nguonSoLieu = res.source; if (!$("tab-nhap").hidden) renderEntries(); }
    return res;
  }
  const pushNote = (res) => !res ? "" : ` Google Sheet: đã điền ${res.written} ô` + (res.kept ? `, giữ nguyên ${res.kept} ô đã có số` : "") +
    (res.noRow.length ? `, hết dòng trống cho ${res.noRow.join(", ")} (thêm dòng trong tuần rồi bấm "Ghi số từ ảnh vào Google Sheet")` : "") + ".";

  // ------------------------------------------------------------ CHỨNG TỪ
  // Hướng dẫn nghiệm thu theo mẫu COLLECTION (slide 8–25): ảnh cần chụp cho từng kênh + các mục phải khoanh
  const REQ = {
    Facebook: {
      ads: "ID tài khoản quảng cáo · Search tên chiến dịch · Tổng số tiền thực chạy · Thời gian chạy (nghiệm thu)",
      qc: "ID tài khoản quảng cáo · Thời gian chạy · Quảng cáo đang hoạt động",
      hoadon: "ID tài khoản quảng cáo · Số mã tham chiếu · Tổng số tiền đã thanh toán (VAT) · Hoá đơn có tên chiến dịch khớp tên trên TKQC",
    },
    Tiktok: {
      ads: "ID tài khoản quảng cáo · Search tên chiến dịch · Tổng số tiền thực chạy · Thời gian chạy (nghiệm thu)",
      qc: "ID tài khoản quảng cáo · Quảng cáo chạy",
      hoadon: "ID tài khoản quảng cáo · Tổng số tiền đã thanh toán (VAT) · Hoá đơn có tên chiến dịch khớp tên trên TKQC",
    },
    Zalo: {
      ads: "Search tên chiến dịch · Tổng số tiền thực chạy · Thời gian chạy (nghiệm thu)",
      qc: "ID tài khoản quảng cáo · Thời gian chạy · Quảng cáo đang hoạt động",
      hoadon: "Tổng số tiền đã thanh toán (VAT) · Hoá đơn có tên chiến dịch khớp tên trên TKQC",
    },
    Google: {
      ads: "ID tài khoản quảng cáo · Search tên chiến dịch · Tổng số tiền thực chạy · Thời gian chạy",
      hoadon: "ID tài khoản quảng cáo · Số mã tham chiếu · Tổng số tiền thực chạy",
    },
  };
  const reqOf = (p, k) => (REQ[p] || {})[k === "qc" && !(REQ[p] || {}).qc ? "ads" : k] || "";
  /** Bảng kiểm nghiệm thu: mỗi nhân sự × kênh đã chạy × loại ảnh bắt buộc -> đã có / thiếu. */
  function renderChecklist() {
    const w = $("evWeek").value, pj = $("evProject").value;
    const data = effective(S.SoLieu.filter((r) => r.tuan === w && r.duAn === pj));
    const ev = S.ChungTu.filter((r) => r.tuan === w && r.duAn === pj);
    const staff = Array.from(new Set(data.map((r) => r.nhanSu).concat(ev.map((r) => r.nhanSu)).filter(Boolean)));
    const order = staffNames();
    staff.sort((a, b) => (order.indexOf(a) + 1 || 99) - (order.indexOf(b) + 1 || 99));
    let missing = 0;
    const rows = [];
    staff.forEach((st) => {
      const plats = PLATFORMS.filter((p) => data.some((r) => r.nhanSu === st && (r.nenTang || "Facebook") === p) || ev.some((r) => r.nhanSu === st && r.nenTang === p));
      plats.forEach((p) => {
        const cells = Object.keys(KINDS).map((k) => {
          if (!REQ[p][k]) {
            const why = `${PLATFORM_LABEL[p]} không cần ảnh “${KINDS[k]}” – mẫu báo cáo chỉ có slide Chiến dịch + Hoá đơn. Ảnh quảng cáo ${PLATFORM_LABEL[p]} (nếu có) được đặt chung vào slide Chiến dịch.`;
            const got = ev.filter((r) => r.nhanSu === st && r.nenTang === p && r.loai === k).length;
            return `<td class="muted" title="${esc(why)}" data-req="${esc(why)}">Không cần${got ? `<br><small>${got} ảnh → tính vào Chiến dịch</small>` : ""}</td>`;
          }
          const n = ev.filter((r) => r.nhanSu === st && r.nenTang === p && (r.loai === k || (k === "ads" && r.loai === "qc" && !REQ[p].qc))).length;
          if (!n) missing++;
          const need = `${st} · ${PLATFORM_LABEL[p]} · ${KINDS[k]} – cần thấy rõ: ${REQ[p][k]}`;
          if (n) return `<td class="ok-cell" title="${esc(REQ[p][k])}" data-req="${esc(need)} (đã có ${n} ảnh)">✓ ${n}</td>`;
          // cùng người, cùng kênh, cùng loại đã có ở dự án khác trong tuần (vd. hoá đơn chung Sun + Casamia) -> lấy sang
          const other = S.ChungTu.filter((r) => r.tuan === w && r.duAn !== pj && r.nhanSu === st && r.nenTang === p && r.loai === k);
          const from = Array.from(new Set(other.map((r) => r.duAn)));
          return `<td class="miss-cell" title="Cần chụp: ${esc(REQ[p][k])}" data-req="${esc(need)}">Thiếu${from.length
            ? `<br><button type="button" class="link small" data-copyev="${esc(other.map((r) => r.id).join(","))}">Lấy từ ${esc(from.join(", "))} (${other.length})</button>` : ""}</td>`;
        }).join("");
        rows.push(`<tr><td>${esc(st)}</td><td>${PLATFORM_LABEL[p]}</td>${cells}</tr>`);
      });
    });
    $("evCheck").innerHTML = rows.length
      ? `<table class="data check"><thead><tr><th>Nhân sự</th><th>Kênh</th>${Object.values(KINDS).map((l) => `<th>${l}</th>`).join("")}</tr></thead><tbody>${rows.join("")}</tbody></table>`
      : `<p class="muted">Chưa có số liệu hoặc ảnh cho tuần này.</p>`;
    $("evCheckSum").textContent = rows.length ? (missing ? `${missing} trang nghiệm thu còn thiếu ảnh` : "Đủ ảnh nghiệm thu") : "";
    $("evCheckSum").className = missing ? "warn-text" : "ok-text";
  }

  let pending = []; // {file, url, nenTang, loai, nhanSu, note, campaigns:[{name, spent, results, resultType, date, use}]}
  const RESULT_LABEL = { lead: "lead", thruplay: "ThruPlay", tuongtac: "tương tác", xem: "lượt xem" };
  /** Ngày "6/10" có nằm trong tuần (iso thứ 2) không. */
  function dateInWeek(dm, iso) {
    if (!dm) return true;
    const [d, m] = dm.split("/").map(Number);
    const a = parseIso(iso);
    for (let i = 0; i < 7; i++) {
      const x = new Date(a); x.setDate(a.getDate() + i);
      if (x.getDate() === d && x.getMonth() + 1 === m) return true;
    }
    return false;
  }
  const STATUS_LABEL = { "dang hoat dong": "đang chạy", "da tam dung": "đã tạm dừng", "da hoan tat": "đã hoàn tất", "dang tat": "đã tắt", "da tat": "đã tắt" };
  function campaignRows(p, i) {
    const add = p.loai === "hoadon" ? "" : `<button type="button" class="link small" data-addcamp="${i}">+ Điền số tay (chiến dịch, chi tiêu, lead)</button>`;
    if (!p.campaigns || !p.campaigns.length) return add ? `<div class="camps">${add}</div>` : "";
    return `<div class="camps"><b>Số liệu của ảnh</b> <small class="muted">(tick dòng có chi tiêu trong tuần này – kể cả chiến dịch đã tắt; sửa số nếu đọc sai)</small>
      ${p.campaigns.map((c, j) => c.manual ? `<label class="camp manual"><input type="checkbox" data-p="${i}" data-c="${j}" data-f="use"${c.use ? " checked" : ""}>
        <input class="cname" data-p="${i}" data-c="${j}" data-f="name" value="${esc(c.name)}" placeholder="Tên chiến dịch" aria-label="Tên chiến dịch">
        <input class="cnum" data-p="${i}" data-c="${j}" data-f="spent" value="${c.spent ? fmtInt(c.spent) : ""}" placeholder="Chi tiêu" inputmode="numeric" aria-label="Chi tiêu">
        <input class="cnum lead" data-p="${i}" data-c="${j}" data-f="results" value="${c.results ? fmtInt(c.results) : ""}" placeholder="Lead" inputmode="numeric" aria-label="Lead">
        <button type="button" class="link danger" data-delcamp="${i}:${j}" title="Bỏ dòng này">×</button></label>`
      : `<label class="camp"><input type="checkbox" data-p="${i}" data-c="${j}" data-f="use"${c.use ? " checked" : ""}>
        <span class="cname" title="${esc(c.name)}">${esc(c.name)}${c.status ? ` <small class="cstatus${/tat|tam dung|hoan tat/.test(c.status) ? " off" : ""}">${esc(STATUS_LABEL[c.status] || c.status)}</small>` : ""}</span>
        <input class="cnum" data-p="${i}" data-c="${j}" data-f="spent" value="${fmtInt(c.spent)}" aria-label="Chi tiêu">
        <span class="muted">${[c.results != null ? fmtInt(c.results) + " " + (RESULT_LABEL[c.resultType] || "") : "", c.clicks != null ? fmtInt(c.clicks) + " nhấp" : "",
          c.impressions != null ? fmtInt(c.impressions) + " hiển thị" : ""].filter(Boolean).join(" · ")}</span></label>`).join("")}
      ${add}</div>`;
  }
  const evSel = new Set(); // ảnh đã lưu đang được tick để xoá nhiều
  function renderEvidence() {
    renderChecklist();
    const w = $("evWeek").value, pj = $("evProject").value;
    const staff = staffNames();
    $("evPending").innerHTML = pending.length ? pending.map((p, i) => `
      <figure class="img"><img src="${p.preview || p.url}" alt="${esc(p.file.name)}">
        <figcaption><span class="fname" title="${esc(p.file.name)}">${esc(p.file.name)}</span>
          ${p.note ? `<small class="muted">${esc(p.note)}</small>` : ""}
          <small class="req">Cần khoanh: ${esc(reqOf(p.nenTang, p.loai))}</small>
          ${campaignRows(p, i)}
          <div class="row"><select data-p="${i}" data-f="nenTang">${PLATFORMS.map((x) => opt(x, PLATFORM_LABEL[x], p.nenTang)).join("")}</select>
          <select data-p="${i}" data-f="loai">${Object.entries(KINDS).map(([k, l]) => opt(k, l, p.loai)).join("")}</select></div>
          <div class="row"><select data-p="${i}" data-f="nhanSu" class="${p.nhanSu ? "" : "warn"}">${opt("", "(chọn nhân sự)", p.nhanSu)}${staff.map((x) => opt(x, x, p.nhanSu)).join("")}${newStaffOpt()}</select>
          <button type="button" class="link danger" data-unpend="${i}">Bỏ</button></div>
        </figcaption></figure>`).join("") : "";
    $("evUpload").hidden = !pending.length;
    const rows = S.ChungTu.filter((r) => r.tuan === w && r.duAn === pj);
    $("evCount").textContent = `${rows.length} ảnh đã lưu`;
    Array.from(evSel).filter((id) => !rows.some((r) => r.id === id)).forEach((id) => evSel.delete(id));
    $("evDelSel").textContent = `Xoá đã chọn (${evSel.size})`;
    $("evDelSel").disabled = !evSel.size;
    $("evList").innerHTML = rows.length ? rows.map((r) => `
      <figure class="img${evSel.has(r.id) ? " sel" : ""}"><label class="pick"><input type="checkbox" data-evsel="${esc(r.id)}"${evSel.has(r.id) ? " checked" : ""}> Chọn</label><a href="${esc(r.url)}" target="_blank" rel="noopener"><img src="https://drive.google.com/thumbnail?id=${esc(r.fileId)}&sz=w400" alt="${esc(r.tenFile)}" onerror="this.replaceWith(Object.assign(document.createElement('div'),{className:'noimg',textContent:'Mở chứng từ'}))"></a>
        <figcaption><span class="fname" title="${esc(r.tenFile)}">${esc(r.tenFile)}</span>
          <div class="row"><select data-ev="${esc(r.id)}" data-f="nenTang">${PLATFORMS.map((x) => opt(x, PLATFORM_LABEL[x], r.nenTang)).join("")}</select>
          <select data-ev="${esc(r.id)}" data-f="loai">${Object.entries(KINDS).map(([k, l]) => opt(k, l, r.loai)).join("")}</select></div>
          <div class="row"><select data-ev="${esc(r.id)}" data-f="nhanSu" class="${r.nhanSu ? "" : "warn"}">${opt("", "(chưa gán nhân sự)", r.nhanSu)}${staff.map((x) => opt(x, x, r.nhanSu)).join("")}${newStaffOpt()}</select>
          <button type="button" class="link danger" data-evdel="${esc(r.id)}">Xoá</button></div>
          ${r.loai !== "hoadon" ? `<button type="button" class="link small" data-evread="${esc(r.id)}">Đọc số từ ảnh này → số liệu + Sheet</button>` : ""}
        </figcaption></figure>`).join("") : `<p class="muted">Chưa có ảnh chứng từ cho tuần này.</p>`;
  }
  async function addPending(files) {
    const staff = $("evStaff").value;
    const list = Array.from(files).filter((f) => /^image\//.test(f.type) || B.isPdf(f));
    // cùng nội dung + cùng nhân sự mới là trùng: hoá đơn chung của nhiều người được lưu cho từng người
    const have = S.ChungTu.filter((r) => r.duAn === $("evProject").value && r.tuan === $("evWeek").value && r.hash);
    const saved = new Set(have.map((r) => r.hash + "|" + r.nhanSu).concat(staff ? [] : have.map((r) => r.hash + "|")));
    let skipped = 0;
    for (const f of list) {
      let hash = "";
      try { hash = await hashOf(f); } catch (_) { /* trình duyệt không hỗ trợ: không chống trùng */ }
      if (hash && (saved.has(hash + "|" + staff) || pending.some((x) => x.hash === hash && x.nhanSu === staff))) { skipped++; continue; }
      const p = { file: f, hash, url: URL.createObjectURL(f), nenTang: "Facebook", loai: B.isPdf(f) ? "hoadon" : "ads", nhanSu: staff, note: "", campaigns: [] };
      if (B.isPdf(f)) {
        try {
          const pages = await B.pdfToImages(f, 1);
          p.preview = URL.createObjectURL(pages[0]);
          p.text = await B.pdfText(f);
        } catch (e) { p.note = "Không đọc được PDF: " + e.message; }
      }
      pending.push(p);
    }
    const skipNote = skipped ? ` Bỏ qua ${skipped} ảnh trùng (đã chọn hoặc đã lưu cho tuần/dự án này).` : "";
    if (skipped && skipped === list.length) { toast(skipNote.trim(), ""); return; }
    renderEvidence();
    const ctx = { staffList: staffNames(), accounts: S.TaiKhoan.map((t) => ({ account: t.maTaiKhoan, staff: t.nhanSu })) };
    const w = $("evWeek").value;
    const apply = (p) => {
      const r = B.classifyText(p.text || "", ctx);
      if (r.kind) p.loai = r.kind;
      if (r.platform) p.nenTang = r.platform;
      if (r.staff && r.by === "id") p.nhanSu = r.staff;
      p.campaigns = p.loai === "hoadon" ? [] : B.extractCampaigns(p.text || "").map((c) => Object.assign(c, { use: dateInWeek(c.date, w) }));
      p.note = "Đọc: " + ([r.kind && KINDS[r.kind], r.account && "TK " + r.account,
        p.campaigns.length && p.campaigns.length + " chiến dịch"].filter(Boolean).join(" · ") || "không nhận ra");
    };
    pending.filter((p) => p.text != null && !p.note).forEach(apply);
    renderEvidence();
    if (!$("evOcr").checked) return;
    try {
      const todo = pending.filter((p) => p.text == null);
      if (todo.length) toast("Đang tải bộ đọc chữ (lần đầu ~15 MB)…", "busy");
      const wk = todo.length ? await B.ocrWorker() : null;
      for (const p of todo) {
        toast(`Đang đọc ảnh ${p.file.name}…`, "busy");
        p.text = (await wk.recognize(p.file)).data.text || "";
        apply(p);
        renderEvidence();
      }
      toast("Đã đọc xong. Kiểm tra loại ảnh, nhân sự, số liệu rồi bấm Tải lên." + skipNote, "ok");
    } catch (e) { toast("Không đọc được chữ trong ảnh: " + e.message, "err"); }
  }
  /** Tài khoản QC duy nhất của nhân sự trên kênh (để gán cho số liệu đọc từ ảnh). */
  function soleAccount(staff, platform) {
    const accs = S.TaiKhoan.filter((t) => t.nhanSu === staff && (!t.nenTang || t.nenTang === platform));
    return accs.length === 1 ? accs[0].maTaiKhoan : "";
  }
  /** Lưu các chiến dịch đã tick (đọc từ ảnh / điền tay) thành dòng số liệu nguồn "anh". Trả số dòng đã lưu. */
  async function saveCampaignRows(campaigns, m) {
    const chosen = (campaigns || []).filter((c) => c.use && (c.spent || (c.manual && c.results)))
      .map((c, k) => (c.name ? c : Object.assign({}, c, { name: "Nhập tay " + (k + 1) + " – " + m.file })));
    if (!chosen.length) return 0;
    const opt0 = (v) => (v != null && v !== "" ? v : "");
    const rows = chosen.map((c) => {
      const prev = S.SoLieu.find((x) => x.nguon === "anh" && x.tuan === m.tuan && x.duAn === m.duAn && x.nhanSu === m.nhanSu && x.chienDich === c.name);
      return {
        id: prev ? prev.id : undefined, tuan: m.tuan, duAn: m.duAn, nhanSu: m.nhanSu, nenTang: m.nenTang,
        taiKhoan: soleAccount(m.nhanSu, m.nenTang), chienDich: c.name, chiPhi: c.spent, chiPhiPhi: c.spent,
        lead: c.resultType === "lead" ? c.results || 0 : 0, luotXem: c.resultType === "thruplay" ? c.results || "" : "",
        mql: "", sql: "", deal: "", hienThi: opt0(c.impressions), tiepCan: opt0(c.reach), luotNhap: opt0(c.clicks),
        ghiChu: (c.manual ? "Nhập tay kèm ảnh " : "Đọc từ ảnh ") + m.file, nguon: "anh",
      };
    });
    const saved = await gas("crmSaveMany", "SoLieu", rows);
    saved.forEach((r) => { S.SoLieu = S.SoLieu.filter((x) => x.id !== r.id).concat(r); });
    return saved.length;
  }
  /** Đọc lại số từ một ảnh đã lưu (ảnh tải lên trước khi app đọc được loại màn hình đó). */
  async function rereadEvidence(id) {
    const r = S.ChungTu.find((x) => x.id === id);
    if (!r) return;
    if (!r.nhanSu) return toast("Chọn nhân sự cho ảnh này trước.", "err");
    const file = await run("Đang tải ảnh", () => evidenceFile(r));
    let text = "";
    try {
      if (B.isPdf(file)) text = await B.pdfText(file);
      else { toast("Đang đọc chữ trong ảnh…", "busy"); text = (await (await B.ocrWorker()).recognize(file)).data.text || ""; }
    } catch (e) { return toast("Không đọc được ảnh: " + e.message, "err"); }
    const camps = B.extractCampaigns(text).map((c) => Object.assign(c, { use: dateInWeek(c.date, r.tuan) }));
    if (!camps.length) return toast(`Không đọc ra số chi tiêu trong ${r.tenFile}. Dùng "+ Điền số tay" khi tải ảnh hoặc nhập ở tab Nhập số liệu.`, "err");
    const list = camps.map((c) => `${c.use ? "☑" : "☐"} ${c.name}: ${fmtInt(c.spent)} đ` + (c.clicks != null ? ` · ${fmtInt(c.clicks)} nhấp` : "") +
      (c.impressions != null ? ` · ${fmtInt(c.impressions)} hiển thị` : "") + (c.results ? ` · ${fmtInt(c.results)} ${RESULT_LABEL[c.resultType] || ""}` : "")).join("\n");
    if (!camps.some((c) => c.use)) camps.forEach((c) => (c.use = true));
    if (!confirm(`Số đọc từ ${r.tenFile} (${r.nhanSu} · ${PLATFORM_LABEL[r.nenTang] || r.nenTang}):\n${list}\n\nLưu vào số liệu tuần ${weekLabel(r.tuan)} và Google Sheet?`)) return;
    const n = await run("Đang lưu số liệu", () => saveCampaignRows(camps.filter((c) => c.use), { tuan: r.tuan, duAn: r.duAn, nhanSu: r.nhanSu, nenTang: r.nenTang, file: r.tenFile }));
    let note = "";
    try { note = pushNote(await pushToSheet(r.duAn, r.tuan)); } catch (e) { note = " Chưa ghi được vào Google Sheet: " + e.message; }
    toast(`Đã lưu ${n} dòng số liệu từ ${r.tenFile}.` + note, "ok");
  }
  async function uploadPending() {
    const w = $("evWeek").value, pj = $("evProject").value;
    const noName = pending.filter((p) => !p.nhanSu).length;
    if (noName) {
      toast(`${noName} ảnh chưa chọn nhân sự. Chọn tên ở ô "Nhân sự" (tên chưa có thì chọn "+ Thêm nhân sự mới…").`, "err");
      return;
    }
    let n = 0, nRows = 0;
    await run("Đang tải ảnh lên Drive", async () => {
      for (const p of pending.slice()) {
        toast(`Đang tải lên ${++n}/${pending.length}: ${p.file.name}`, "busy");
        const rec = await gas("crmUploadEvidence", { tuan: w, duAn: pj, nhanSu: p.nhanSu, nenTang: p.nenTang, loai: p.loai, tenFile: p.file.name, mime: p.file.type, hash: p.hash || "" },
          await B.blobToB64(p.file));
        if (!S.ChungTu.some((x) => x.id === rec.id)) S.ChungTu.push(rec);
        nRows += await saveCampaignRows(p.campaigns, { tuan: w, duAn: pj, nhanSu: p.nhanSu, nenTang: p.nenTang, file: p.file.name });
      }
    });
    pending.forEach((p) => URL.revokeObjectURL(p.url));
    pending = [];
    let sheetNote = "", sheetErr = false;
    if (nRows) {
      toast("Đang ghi số vào Google Sheet của dự án…", "busy");
      try { sheetNote = pushNote(await pushToSheet(pj, w)); }
      catch (e) { sheetNote = " Chưa ghi được vào Google Sheet: " + e.message; sheetErr = true; }
    }
    toast(`Đã lưu ${n} chứng từ vào Drive (Nhân sự/${pj}/${weekLabel(w)})` + (nRows ? ` và ${nRows} dòng số liệu đọc từ ảnh (xem tab Nhập số liệu).` : ".") + sheetNote, sheetErr ? "err" : "ok");
    renderEvidence();
  }

  // ------------------------------------------------------------ BÁO CÁO
  const tplCache = {};
  function weeksForReport(rows) {
    const weeks = {};
    Array.from(new Set(rows.map((r) => r.tuan))).sort().forEach((w) => {
      weeks[weekLabel(w)] = Object.fromEntries(PLATFORMS.map((p) => [p, []]));
    });
    rows.forEach((r) => {
      const p = PLATFORMS.includes(r.nenTang) ? r.nenTang : "Facebook";
      const funnel = [r.mql, r.sql, r.deal].some((v) => v !== "" && v != null);
      weeks[weekLabel(r.tuan)][p].push({
        account: r.taiKhoan || r.nhanSu || "(không rõ)", staff: r.nhanSu,
        cost: num(r.chiPhi), cost_fee: num(r.chiPhiPhi) || num(r.chiPhi), lead: num(r.lead),
        impressions: num(r.hienThi), reach: num(r.tiepCan), clicks: num(r.luotNhap), views: num(r.luotXem),
        mql: num(r.mql), sql: num(r.sql), deal: num(r.deal), hasFunnel: funnel,
      });
    });
    return weeks;
  }
  // ------------------------------------------------------------ ảnh có sẵn trong thư mục chứng từ trên Drive
  // Cấu trúc: Thư mục chứng từ / <Nhân sự> / <Dự án> / <tuần "3/10-9/10"> / ảnh
  const STOPW = ["anh", "chi", "em", "thi", "van", "sun", "casa", "group", "tai khoan"];
  const simpleWords = (x) => " " + B.norm(x).replace(/[^a-z0-9]+/g, " ").trim() + " ";
  /** Nhân sự theo tên file trước ("ngà sun.jpg"), rồi các thư mục từ trong ra ngoài ("Phan Hạnh/Sun/…"). */
  function staffFromPath(path, name) {
    const list = staffNames();
    const match = (seg) => {
      const t = simpleWords(seg);
      const full = list.filter((st) => t.includes(simpleWords(st)));
      if (full.length === 1) return full[0];
      const hits = list.filter((st) => B.norm(st).split(" ").some((x) => x.length >= 3 && !STOPW.includes(x) && t.includes(" " + x + " ")));
      return hits.length === 1 ? hits[0] : "";
    };
    for (const seg of [name.replace(/\.[a-z0-9]+$/i, "")].concat(path.slice().reverse())) {
      const st = match(seg);
      if (st) return st;
    }
    return "";
  }
  /** Thư mục tuần ("3/10-9/10") có giao với tuần báo cáo không; không có thư mục tuần = có. */
  function folderInWeek(path, iso) {
    const a = parseIso(iso), b = new Date(a);
    b.setDate(a.getDate() + 6);
    const dn = (d, m) => m * 31 + d;
    const A = dn(a.getDate(), a.getMonth() + 1), Z = dn(b.getDate(), b.getMonth() + 1);
    return path.map((x) => /^\s*(\d{1,2})\/(\d{1,2})\s*-\s*(\d{1,2})\/(\d{1,2})\s*$/.exec(x)).filter(Boolean)
      .every((m) => dn(+m[1], +m[2]) <= Z && dn(+m[3], +m[4]) >= A);
  }
  /** Ghi các ảnh/PDF mới trong thư mục chứng từ của dự án (tuần w) vào bảng ChungTu – đọc chữ để xếp loại, gán người. */
  async function importDriveEvidence(pjName, w) {
    const pj = project(pjName);
    const root = B.parseDriveId(pj.thuMucChungTu);
    if (!root) return [];
    const key = B.norm(pj.khoa || pj.ten).replace(/[^a-z0-9]/g, "");
    toast(`${pjName}: đang quét thư mục chứng từ trên Drive…`, "busy");
    const files = (await gas("listTree", root)).filter((f) => (/^image\//.test(f.mimeType) || f.mimeType === "application/pdf") &&
      f.path.slice(1).some((seg) => B.norm(seg).replace(/[^a-z0-9]/g, "") === key) &&
      folderInWeek(f.path, w) && !S.ChungTu.some((c) => c.fileId === f.id));
    if (!files.length) return [];
    const ctx = { staffList: staffNames(), accounts: S.TaiKhoan.map((t) => ({ account: t.maTaiKhoan, staff: t.nhanSu })) };
    let wk = null;
    try { wk = await B.ocrWorker(); } catch (_) { /* không đọc được chữ: xếp theo tên file/thư mục */ }
    const rows = [];
    const have = S.ChungTu.filter((r) => r.duAn === pjName && r.tuan === w && r.hash);
    const seen = new Set(have.map((r) => r.hash + "|" + r.nhanSu)), anyHash = new Set(have.map((r) => r.hash));
    let i = 0;
    for (const f of files) {
      toast(`${pjName}: đọc ảnh trên Drive ${++i}/${files.length} – ${f.name}`, "busy");
      let text = "", hash = "";
      try {
        const file = await evidenceFile({ fileId: f.id, tenFile: f.name });
        hash = await hashOf(file);
        text = B.isPdf(file) ? await B.pdfText(file) : wk ? (await wk.recognize(file)).data.text || "" : "";
      } catch (e) { console.error(e); }
      const c = B.classifyText(text, ctx), g = B.guessClass(f.path, f.name);
      const nhanSu = (c.staff && c.by === "id" ? c.staff : "") || staffFromPath(f.path, f.name) || c.staff || "";
      if (hash) {
        // cùng nội dung với ảnh đã có của cùng người (hoặc ảnh chưa rõ người): không lấy
        if (seen.has(hash + "|" + nhanSu) || (!nhanSu && anyHash.has(hash))) continue;
        seen.add(hash + "|" + nhanSu); anyHash.add(hash);
      }
      rows.push({
        tuan: w, duAn: pjName, nenTang: c.platform || g.platform, loai: c.kind || g.kind,
        nhanSu,
        fileId: f.id, tenFile: f.name, url: "https://drive.google.com/file/d/" + f.id + "/view", hash,
      });
    }
    if (!rows.length) return [];
    const saved = await gas("crmSaveMany", "ChungTu", rows);
    S.ChungTu = S.ChungTu.filter((r) => !saved.some((x) => x.id === r.id)).concat(saved);
    return saved;
  }

  // ------------------------------------------------------------ ảnh trùng
  const fileCache = new Map(); // fileId -> File đã tải trong phiên
  async function hashOf(blob) {
    const buf = await crypto.subtle.digest("SHA-256", await blob.arrayBuffer());
    return Array.from(new Uint8Array(buf).slice(0, 12), (b) => b.toString(16).padStart(2, "0")).join("");
  }
  async function evidenceFile(r) {
    if (!fileCache.has(r.fileId)) {
      const f = await gas("downloadFile", r.fileId);
      fileCache.set(r.fileId, new File([B.b64ToBlob(f.b64, f.type)], r.tenFile, { type: f.type }));
    }
    return fileCache.get(r.fileId);
  }
  /** Xoá ảnh trùng của một dự án + tuần (cùng file Drive hoặc cùng nội dung), giữ ảnh đã gán nhân sự / lưu sớm nhất. */
  async function dedupeEvidence(pjName, w) {
    const rows = S.ChungTu.filter((r) => r.duAn === pjName && r.tuan === w && r.fileId);
    const fill = [];
    let i = 0;
    for (const r of rows) {
      i++;
      if (r.hash) continue;
      toast(`${pjName}: kiểm tra ảnh trùng ${i}/${rows.length}…`, "busy");
      try { r.hash = await hashOf(await evidenceFile(r)); fill.push({ id: r.id, hash: r.hash }); } catch (e) { console.error(e); }
    }
    if (fill.length) await gas("crmSaveMany", "ChungTu", fill);
    const dup = findDups(rows, false);
    if (dup.length) {
      await gas("crmDelete", "ChungTu", dup);
      S.ChungTu = S.ChungTu.filter((x) => !dup.includes(x.id));
    }
    return dup.length;
  }

  /** Ảnh nên bỏ trong danh sách đang xem: cùng file Drive, cùng nội dung hoặc cùng tên file; giữ ảnh đã gán nhân sự / lưu sớm nhất. */
  function dupIds(rows) { return findDups(rows, true); }
  /**
   * Trùng = cùng file Drive, hoặc cùng nội dung (và tên file nếu byName) của CÙNG nhân sự – hoá đơn chung của
   * nhiều người được giữ cho từng người; ảnh chưa gán nhân sự thì trùng với mọi ảnh cùng nội dung.
   * Giữ ảnh đã gán nhân sự / lưu sớm nhất.
   */
  function findDups(rows, byName) {
    const order = rows.slice().sort((a, b) => (!a.nhanSu - !b.nhanSu) || String(a.ngayTao).localeCompare(String(b.ngayTao)));
    const seen = new Set(), anyHash = new Set(), dup = [];
    order.forEach((r) => {
      const who = r.nhanSu || "";
      const keys = [r.fileId && "f:" + r.fileId, r.hash && "h:" + r.hash + "|" + who,
        byName && r.tenFile && "n:" + r.nenTang + "|" + who + "|" + String(r.tenFile).trim().toLowerCase()].filter(Boolean);
      if (keys.some((k) => seen.has(k)) || (!who && r.hash && anyHash.has(r.hash))) dup.push(r.id);
      else { keys.forEach((k) => seen.add(k)); if (r.hash) anyHash.add(r.hash); }
    });
    return dup;
  }
  async function buildOne(pjName, w, fmt) {
    const pj = project(pjName);
    const tplId = B.parseDriveId(pj.mauPptx);
    if (!tplId) throw new Error(`Dự án ${pjName} chưa có link PPTX mẫu (tab Danh mục).`);
    const rows = effective(S.SoLieu.filter((r) => r.duAn === pjName && r.tuan <= w));
    if (!rows.some((r) => r.tuan === w)) throw new Error(`${pjName}: chưa có số liệu tuần ${weekLabel(w)}.`);
    if (!tplCache[tplId]) { const t = await gas("downloadFile", tplId); tplCache[tplId] = B.b64ToBlob(t.b64, t.type); }
    const accStaff = new Map(rows.map((r) => [r.taiKhoan || r.nhanSu || "(không rõ)", r.nhanSu]));
    try { await importDriveEvidence(pjName, w); } catch (e) { console.error(e); }
    try { await dedupeEvidence(pjName, w); } catch (e) { console.error(e); }
    const ev = S.ChungTu.filter((r) => r.duAn === pjName && r.tuan === w && r.nhanSu);
    const images = [];
    let i = 0;
    for (const r of ev) {
      toast(`${pjName}: tải ảnh ${++i}/${ev.length}…`, "busy");
      const file = await evidenceFile(r);
      const files = B.isPdf(file) ? await B.pdfToImages(file, 2) : [file];
      files.forEach((x) => images.push({ file: x, platform: r.nenTang, kind: r.loai, staff: r.nhanSu }));
    }
    const weekRows = rows.filter((r) => r.tuan === w);
    const order = staffNames();
    const staffList = Array.from(new Set(weekRows.map((r) => r.nhanSu).concat(ev.map((r) => r.nhanSu)).filter(Boolean)))
      .sort((a, b) => (order.indexOf(a) + 1 || 99) - (order.indexOf(b) + 1 || 99));
    toast(`${pjName}: đang dựng báo cáo…`, "busy");
    const res = await B.buildReport({
      template: await tplCache[tplId].arrayBuffer(), weeks: weeksForReport(rows), week: weekLabel(w),
      year: String(parseIso(w).getFullYear()), campaign: pj.chienDich || "", period: "",
      images, staffList, staffOf: (acc) => accStaff.get(acc) || "",
      scope: "week", perSlide: 1, dropUnused: true, dropEmptyImageSlides: true, placeholderMissing: $("rpKeepMissing").checked,
      logo: pj.logo || "", logos: (window.BAO_CAO_MKT_CONFIG || {}).logos,
    });
    const name = `Bao_cao_${pjName.replace(/\s+/g, "_")}_${weekLabel(w).replace(/[\/ ]/g, "")}.pptx`;
    const folder = B.parseDriveId(pj.thuMucBaoCao) || "";
    const b64 = await B.blobToB64(res.blob);
    const out = { tuan: w, duAn: pjName, trangThai: "Nháp", pdfUrl: "", pptxUrl: "",
      tomTat: `${res.slides} slide, ${res.staffCount} nhân sự, ${res.nImg} ảnh` + (res.missing ? `, thiếu ${res.missing} ảnh nghiệm thu` : "") };
    // tạo lại: ghi đè vào file cũ để link đã gửi nhóm vẫn mở được bản mới
    const prev = S.BaoCao.find((r) => r.duAn === pjName && r.tuan === w);
    if (fmt !== "pdf") { toast(`${pjName}: lưu PPTX…`, "busy"); out.pptxUrl = await gas("saveReport", b64, name, folder, true, prev ? prev.pptxUrl : ""); }
    if (fmt !== "pptx") { toast(`${pjName}: chuyển PDF…`, "busy"); out.pdfUrl = (await gas("convertToPdf", b64, name, folder, true, prev ? prev.pdfUrl : "")).url; }
    if (prev) out.id = prev.id;
    out.ngayTao = nowStamp(); // lần tạo gần nhất (để biết có ảnh/số mới sau đó không)
    const saved = await gas("crmSave", "BaoCao", out);
    S.BaoCao = S.BaoCao.filter((r) => r.id !== saved.id).concat(saved);
    // file cũ không ghi đè được (đã đổi định dạng / bị xoá…): bỏ bản cũ vào thùng rác
    const stale = prev ? [prev.pdfUrl, prev.pptxUrl].filter((u) => u && u !== saved.pdfUrl && u !== saved.pptxUrl) : [];
    if (stale.length) { try { await gas("crmTrashReportFiles", stale); } catch (e) { console.error(e); } }
    return saved;
  }
  async function generateReports() {
    const w = $("rpWeek").value, fmt = $("rpFormat").value;
    const list = $("rpProject").value ? [$("rpProject").value] : brandNames();
    const msgs = [];
    $("rpGo").disabled = true;
    try {
      for (const pj of list) {
        try { const r = await buildOne(pj, w, fmt); msgs.push(`${pj}: ${r.tomTat}`); }
        catch (e) { console.error(e); msgs.push(`${pj}: lỗi – ${e.message}`); }
      }
      toast("Xong. " + msgs.join(" | ") + " – bấm “Chép tin nhắn gửi nhóm” để gửi link.", msgs.some((m) => m.includes("lỗi")) ? "err" : "ok");
    } finally { $("rpGo").disabled = false; renderReports(); }
  }
  /** Tin nhắn gửi nhóm (Zalo…): link PDF/PPTX các báo cáo của tuần. */
  function shareText(rows) {
    if (!rows.length) return "";
    const w = rows[0].tuan;
    return `[Báo cáo] Marketing tuần ${weekLabel(w, true)}` + (brand ? ` – ${brand}` : "") + "\n" +
      rows.map((r) => `• ${r.duAn}: ${r.pdfUrl || r.pptxUrl}`).join("\n");
  }
  async function copyText(text, what) {
    try { await navigator.clipboard.writeText(text); toast("Đã chép " + what + " – dán vào Zalo/Messenger để gửi.", "ok"); }
    catch (_) { prompt("Chép " + what + ":", text); }
  }

  const nowStamp = () => { const d = new Date(); return `${isoOf(d)} ${pad(d.getHours())}:${pad(d.getMinutes())}`; };
  /** Số ảnh / dòng số liệu thêm vào sau lần tạo báo cáo r. */
  function newSince(r) {
    const after = (x) => x.duAn === r.duAn && x.tuan === r.tuan && String(x.ngayTao) > String(r.ngayTao);
    return { anh: S.ChungTu.filter(after).length, so: S.SoLieu.filter(after).length };
  }
  function renderReports() {
    const rows = S.BaoCao.filter((r) => inBrand(r.duAn)).sort((a, b) => String(b.tuan + b.ngayTao).localeCompare(String(a.tuan + a.ngayTao)));
    const wk = S.BaoCao.filter((r) => inBrand(r.duAn) && r.tuan === $("rpWeek").value && (r.pdfUrl || r.pptxUrl));
    $("rpShare").hidden = !wk.length;
    $("rpShare").textContent = wk.length ? `Chép tin nhắn gửi nhóm (${wk.length} báo cáo tuần ${weekLabel($("rpWeek").value)})` : "";
    $("rpTable").innerHTML = rows.length ? `<table class="data"><thead><tr><th>Tuần</th><th>Dự án</th><th>Trạng thái</th><th>File</th><th>Nội dung</th><th>Người tạo</th><th>Ngày tạo</th></tr></thead><tbody>
      ${rows.map((r) => `<tr><td>${esc(weekLabel(r.tuan, true))}</td><td>${esc(r.duAn)}</td>
        <td><select data-rp="${esc(r.id)}" class="st-${STATUSES.indexOf(r.trangThai)}">${STATUSES.map((s) => opt(s, s, r.trangThai)).join("")}</select></td>
        <td>${r.pdfUrl ? `<a href="${esc(r.pdfUrl)}" target="_blank" rel="noopener">PDF</a>` : ""} ${r.pptxUrl ? `<a href="${esc(r.pptxUrl)}" target="_blank" rel="noopener">PPTX</a>` : ""}
          ${r.pdfUrl || r.pptxUrl ? `<button type="button" class="link" data-copy="${esc(r.id)}">Chép link</button>` : ""}</td>
        <td>${esc(r.tomTat)}${(() => { const n = newSince(r); return n.anh || n.so ? `<br><b class="warn-text">Có ${[n.anh && n.anh + " ảnh", n.so && n.so + " dòng số liệu"].filter(Boolean).join(", ")} mới sau lần tạo này – chọn tuần/dự án này và bấm “Tạo báo cáo” để cập nhật.</b>` : ""; })()}</td><td class="muted">${esc(r.nguoiTao)}</td><td class="muted">${esc(r.ngayTao)}</td></tr>`).join("")}</tbody></table>`
      : `<p class="muted">Chưa có báo cáo nào.</p>`;
  }

  // ------------------------------------------------------------ DANH MỤC
  const CATALOG = { DuAn: "Dự án", NhanSu: "Nhân sự", TaiKhoan: "Tài khoản quảng cáo" };
  function renderCatalog() {
    $("ctBody").innerHTML = Object.entries(CATALOG).map(([t, title]) => {
      const cols = (S.schema[t] || []).filter((c) => c[0] !== "id" && c[0] !== "nguoiTao" && c[0] !== "ngayTao");
      const cell = (t2, c, v, id) => {
        if (c === "nhanSu") return `<select data-ct="${t2}" data-id="${id}" data-f="${c}">${opt("", "(chưa gán)", v)}${staffNames().map((s) => opt(s, s, v)).join("")}</select>`;
        if (c === "nenTang") return `<select data-ct="${t2}" data-id="${id}" data-f="${c}">${PLATFORMS.map((p) => opt(p, PLATFORM_LABEL[p], v)).join("")}</select>`;
        if (c === "logo") return `<select data-ct="${t2}" data-id="${id}" data-f="${c}">${opt("", "(theo mẫu)", v)}${Object.keys((window.BAO_CAO_MKT_CONFIG || {}).logos || {}).map((x) => opt(x, x, v)).join("")}</select>`;
        if (c === "trangThai") return `<select data-ct="${t2}" data-id="${id}" data-f="${c}">${["Đang làm", "Nghỉ"].map((s) => opt(s, s, v || "Đang làm")).join("")}</select>`;
        return `<input data-ct="${t2}" data-id="${id}" data-f="${c}" value="${esc(v)}">`;
      };
      return `<section class="card"><h3>${title}</h3><div class="wrap"><table class="data edit"><thead><tr>${cols.map((c) => `<th>${esc(c[1])}</th>`).join("")}<th></th></tr></thead><tbody>
        ${S[t].filter((r) => t !== "DuAn" || !brand || !r.logo || r.logo === brand).map((r) => `<tr>${cols.map((c) => `<td>${cell(t, c[0], r[c[0]], r.id)}</td>`).join("")}
          <td class="act"><button type="button" class="link danger" data-ctdel="${t}" data-id="${esc(r.id)}">Xoá</button></td></tr>`).join("")}
        </tbody></table></div><button type="button" class="ghost small" data-ctadd="${t}">+ Thêm ${title.toLowerCase()}</button></section>`;
    }).join("");
  }
  async function catalogChange(el) {
    const t = el.dataset.ct, id = el.dataset.id, f = el.dataset.f;
    const r = S[t].find((x) => x.id === id);
    if (!r) return;
    r[f] = el.value;
    await run("Đang lưu", () => gas("crmSave", t, { id, [f]: el.value }));
    toast("Đã lưu.", "ok");
    refreshFilters();
  }

  // ------------------------------------------------------------ khởi động
  function bind() {
    document.querySelectorAll("[data-brand]").forEach((b) => b.addEventListener("click", () => setBrand(b.dataset.brand)));
    $("brandLink").addEventListener("click", async () => {
      const url = $("brandLink").dataset.url;
      const text = "Cập nhật báo cáo " + brand + ": " + url + "\nHướng dẫn: " + guideUrl();
      try { await navigator.clipboard.writeText(text); toast("Đã chép link cập nhật báo cáo + link hướng dẫn của " + brand, "ok"); }
      catch (_) { prompt("Link riêng của " + brand + " (kèm hướng dẫn):", text); }
    });
    document.querySelectorAll("[data-tab]").forEach((b) => b.addEventListener("click", () => showTab(b.dataset.tab)));
    ["dbProject", "dbFrom", "dbTo"].forEach((id) => $(id).addEventListener("change", renderDashboard));
    ["enWeek", "enProject", "enStaff"].forEach((id) => {
      const el = $(id);
      el.addEventListener("focus", () => (el.dataset.prev = el.value));
      el.addEventListener("change", () => {
        if (!confirmDiscard()) { el.value = el.dataset.prev; return; }
        el.dataset.prev = el.value;
        renderEntries();
      });
    });
    ["evWeek", "evProject"].forEach((id) => $(id).addEventListener("change", renderEvidence));
    $("evStaff").addEventListener("change", () => {
      const me = $("evStaff").value;
      $("evStaff").classList.toggle("warn", !me);
      try { if (me) localStorage.setItem("crm.me", me); } catch (_) { /* bỏ qua */ }
      pending.forEach((p) => (p.nhanSu = me));
      renderEvidence();
    });
    $("enSave").addEventListener("click", () => saveGrid().catch(() => {}));
    $("enDiscard").addEventListener("click", () => { if (confirmDiscard()) renderEntries(); });
    $("enTable").addEventListener("change", (e) => { if (e.target.dataset.g) gridChange(e.target); });
    $("enTable").addEventListener("keydown", (e) => {
      if (e.key === "Enter" && e.target.dataset.g) { e.preventDefault(); e.target.blur(); }
    });
    window.addEventListener("beforeunload", (e) => { if (drafts.size) { e.preventDefault(); e.returnValue = ""; } });
    $("enImport").addEventListener("click", () => importSheet().catch(() => {}));
    $("enShare").addEventListener("click", async () => {
      const pj = $("enProject").value;
      if (!confirm(`Cho các nhân sự có email (tab Danh mục › Nhân sự) quyền SỬA Google Sheet số liệu của ${pj}?\nGoogle sẽ gửi email báo cho từng người.`)) return;
      try {
        const r = await run("Đang chia sẻ", () => gas("crmShareSheet", pj));
        toast((r.added.length ? `Đã cho quyền sửa: ${r.added.join(", ")}.` : "Không có ai mới cần thêm quyền.") +
          (r.already ? ` ${r.already} người đã có quyền.` : "") +
          (r.noEmail.length ? ` Chưa có email: ${r.noEmail.join(", ")} – thêm email ở tab Danh mục › Nhân sự rồi bấm lại.` : ""), r.noEmail.length ? "" : "ok");
      } catch (_) { /* đã báo */ }
    });
    $("enPush").addEventListener("click", async () => {
      const pj = $("enProject").value, w = $("enWeek").value;
      try {
        const res = await run("Đang ghi vào Google Sheet", () => pushToSheet(pj, w));
        toast(res ? (pushNote(res).trim() || "Đã ghi.") : `Tuần ${weekLabel(w)} của ${pj} chưa có số đọc từ ảnh.`, res ? "ok" : "");
      } catch (_) { /* đã báo */ }
    });
    $("enTable").addEventListener("click", (e) => {
      const b = e.target.closest("button");
      if (!b) return;
      if (b.dataset.gadd) addRow(b.dataset.gadd);
      if (b.dataset.gdel) deleteRow(b.dataset.gdel).catch(() => {});
    });
    $("evFiles").addEventListener("change", () => { addPending($("evFiles").files); $("evFiles").value = ""; });
    // dán ảnh chụp màn hình (Ctrl/Cmd + V) khi đang ở tab Ảnh & chứng từ
    document.addEventListener("paste", (e) => {
      if ($("tab-chungtu").hidden) return;
      const items = Array.from((e.clipboardData && e.clipboardData.items) || []);
      const files = items.filter((it) => it.kind === "file" && (/^image\//.test(it.type) || it.type === "application/pdf")).map((it) => it.getAsFile()).filter(Boolean);
      if (!files.length) return;
      e.preventDefault();
      const stamp = new Date().toTimeString().slice(0, 8).replace(/:/g, "");
      addPending(files.map((f, k) => {
        const ext = f.type === "application/pdf" ? "pdf" : (f.type.split("/")[1] || "png").replace("jpeg", "jpg");
        return new File([f], `anh-dan-${stamp}${files.length > 1 ? "-" + (k + 1) : ""}.${ext}`, { type: f.type });
      }));
    });
    const drop = $("evDrop");
    drop.addEventListener("dragover", (e) => { e.preventDefault(); drop.classList.add("over"); });
    drop.addEventListener("dragleave", () => drop.classList.remove("over"));
    drop.addEventListener("drop", (e) => { e.preventDefault(); drop.classList.remove("over"); addPending(e.dataTransfer.files); });
    $("evPending").addEventListener("change", (e) => {
      const t = e.target, i = t.dataset.p;
      if (i == null) return;
      if (t.dataset.c != null) {
        const c = pending[i].campaigns[t.dataset.c];
        if (t.dataset.f === "use") c.use = t.checked;
        else if (t.dataset.f === "name") c.name = t.value.trim();
        else if (t.dataset.f === "results") c.results = Math.round(num(t.value));
        else c.spent = Math.round(num(t.value));
        if (c.manual && t.dataset.f !== "use") c.use = !!(c.spent || c.results);
        if (c.manual) { const box = t.closest(".camp").querySelector('[data-f="use"]'); if (box) box.checked = c.use; }
        return;
      }
      pending[i][t.dataset.f] = t.value;
      if (t.tagName === "SELECT") renderEvidence();
    });
    $("evPending").addEventListener("click", (e) => {
      const ai = e.target.dataset.addcamp;
      if (ai != null) {
        const p = pending[ai];
        p.campaigns = p.campaigns || [];
        p.campaigns.push({ manual: true, name: "", spent: 0, results: 0, resultType: "lead", use: false });
        renderEvidence();
        const els = document.querySelectorAll(`[data-p="${ai}"][data-f="name"]`);
        if (els.length) els[els.length - 1].focus();
        return;
      }
      const dc = e.target.dataset.delcamp;
      if (dc) { const [a, b] = dc.split(":").map(Number); pending[a].campaigns.splice(b, 1); renderEvidence(); return; }
      const i = e.target.dataset.unpend;
      if (i == null) return;
      URL.revokeObjectURL(pending[i].url);
      pending.splice(i, 1);
      renderEvidence();
    });
    $("evUpload").addEventListener("click", () => uploadPending().catch(() => {}));
    $("evScan").addEventListener("click", async () => {
      $("evScan").disabled = true;
      try {
        const pj = $("evProject").value, w = $("evWeek").value;
        const got = await run("Đang quét", () => importDriveEvidence(pj, w));
        const nDup = await run("Đang kiểm tra ảnh trùng", () => dedupeEvidence(pj, w));
        const noStaff = got.filter((r) => !r.nhanSu && S.ChungTu.includes(r)).length;
        toast((got.length ? `Đã lấy ${got.length} ảnh từ Drive` + (noStaff ? ` – ${noStaff} ảnh chưa gán nhân sự (chọn ở ô Nhân sự, ảnh chưa gán không vào báo cáo).` : ".")
          : "Không có ảnh mới trong thư mục chứng từ cho tuần/dự án này.") + (nDup ? ` Đã xoá ${nDup} ảnh trùng.` : ""), got.length || nDup ? "ok" : "");
        renderEvidence();
      } catch (_) { /* đã báo */ } finally { $("evScan").disabled = false; }
    });
    // chạm vào ô của bảng kiểm (điện thoại không rê chuột được): hiện yêu cầu của ô đó
    $("evCheck").addEventListener("click", async (e) => {
      const btn = e.target.closest("[data-copyev]");
      if (btn) {
        const ids = btn.dataset.copyev.split(","), pj = $("evProject").value;
        btn.disabled = true;
        try {
          for (const id of ids) {
            const rec = await run(`Đang chép ảnh sang ${pj}`, () => gas("crmCopyEvidence", id, pj));
            if (!S.ChungTu.some((x) => x.id === rec.id)) S.ChungTu.push(rec);
          }
          toast(`Đã dùng ${ids.length} ảnh cho ${pj} (bản sao lưu trong thư mục ${pj} trên Drive).`, "ok");
          renderEvidence();
        } catch (_) { btn.disabled = false; }
        return;
      }
      const td = e.target.closest("td[data-req]");
      if (td) toast(td.dataset.req, "");
    });
    $("evDedupe").addEventListener("click", async () => {
      $("evDedupe").disabled = true;
      try {
        const n = await run("Đang kiểm tra ảnh trùng", () => dedupeEvidence($("evProject").value, $("evWeek").value));
        toast(n ? `Đã xoá ${n} ảnh trùng (file thừa chuyển vào thùng rác Drive).` : "Không có ảnh trùng.", "ok");
        renderEvidence();
      } catch (_) { /* đã báo */ } finally { $("evDedupe").disabled = false; }
    });
    $("evList").addEventListener("change", async (e) => {
      const id = e.target.dataset.ev;
      if (!id) return;
      const r = S.ChungTu.find((x) => x.id === id);
      r[e.target.dataset.f] = e.target.value;
      await run("Đang lưu", () => gas("crmSave", "ChungTu", { id, [e.target.dataset.f]: e.target.value }));
      toast("Đã lưu.", "ok");
      renderChecklist();
    });
    const evRows = () => S.ChungTu.filter((r) => r.tuan === $("evWeek").value && r.duAn === $("evProject").value);
    $("evList").addEventListener("change", (e) => {
      const id = e.target.dataset.evsel;
      if (!id) return;
      if (e.target.checked) evSel.add(id); else evSel.delete(id);
      renderEvidence();
    });
    $("evSelAll").addEventListener("click", () => { evRows().forEach((r) => evSel.add(r.id)); renderEvidence(); });
    $("evSelNone").addEventListener("click", () => { evSel.clear(); renderEvidence(); });
    $("evSelDup").addEventListener("click", () => {
      const dup = dupIds(evRows());
      evSel.clear(); dup.forEach((id) => evSel.add(id));
      renderEvidence();
      toast(dup.length ? `Đã chọn ${dup.length} ảnh trùng (cùng file, cùng nội dung hoặc cùng tên). Xem lại rồi bấm "Xoá đã chọn".` : "Không có ảnh trùng.", dup.length ? "ok" : "");
    });
    $("evDelSel").addEventListener("click", async () => {
      const ids = Array.from(evSel);
      if (!ids.length || !confirm(`Xoá ${ids.length} ảnh đã chọn (file chuyển vào thùng rác Drive)?`)) return;
      try { await run("Đang xoá", () => gas("crmDelete", "ChungTu", ids)); } catch (_) { return; }
      S.ChungTu = S.ChungTu.filter((x) => !evSel.has(x.id));
      evSel.clear();
      toast(`Đã xoá ${ids.length} ảnh.`, "ok");
      renderEvidence();
    });
    $("evList").addEventListener("click", (e) => {
      const id = e.target.dataset.evread;
      if (id) rereadEvidence(id).catch(() => {});
    });
    $("evList").addEventListener("click", async (e) => {
      const id = e.target.dataset.evdel;
      if (!id || !confirm("Xoá ảnh này (chuyển vào thùng rác Drive)?")) return;
      await run("Đang xoá", () => gas("crmDelete", "ChungTu", id));
      S.ChungTu = S.ChungTu.filter((x) => x.id !== id);
      toast("Đã xoá.", "ok");
      renderEvidence();
    });
    $("rpGo").addEventListener("click", () => generateReports());
    $("rpWeek").addEventListener("change", renderReports);
    $("rpShare").addEventListener("click", () => {
      const rows = S.BaoCao.filter((r) => inBrand(r.duAn) && r.tuan === $("rpWeek").value && (r.pdfUrl || r.pptxUrl));
      copyText(shareText(rows), "tin nhắn kèm link báo cáo");
    });
    $("rpTable").addEventListener("click", (e) => {
      const id = e.target.dataset.copy;
      if (!id) return;
      const r = S.BaoCao.find((x) => x.id === id);
      copyText(`[Báo cáo] ${r.duAn} tuần ${weekLabel(r.tuan, true)}: ${r.pdfUrl || r.pptxUrl}`, "link báo cáo");
    });
    $("rpTable").addEventListener("change", async (e) => {
      const id = e.target.dataset.rp;
      if (!id) return;
      S.BaoCao.find((x) => x.id === id).trangThai = e.target.value;
      await run("Đang lưu", () => gas("crmSave", "BaoCao", { id, trangThai: e.target.value }));
      toast("Đã cập nhật trạng thái.", "ok");
      renderReports();
    });
    $("ctBody").addEventListener("change", (e) => { if (e.target.dataset.ct) catalogChange(e.target).catch(() => {}); });
    $("ctBody").addEventListener("click", async (e) => {
      const b = e.target.closest("button");
      if (!b) return;
      if (b.dataset.ctadd) {
        const t = b.dataset.ctadd;
        S[t].push(await run("Đang thêm", () => gas("crmSave", t, t === "NhanSu" ? { ten: "Nhân sự mới", trangThai: "Đang làm" } : t === "DuAn" ? { ten: "Dự án mới", logo: brand } : { nenTang: "Facebook" })));
        toast("Đã thêm dòng mới – sửa trực tiếp trong bảng.", "ok");
        renderCatalog();
        refreshFilters();
      }
      if (b.dataset.ctdel) {
        const t = b.dataset.ctdel, id = b.dataset.id;
        if (!confirm("Xoá dòng này khỏi danh mục?")) return;
        await run("Đang xoá", () => gas("crmDelete", t, id));
        S[t] = S[t].filter((x) => x.id !== id);
        renderCatalog();
        refreshFilters();
      }
    });
  }

  async function start() {
    window.__crmStarted = true;
    // giữ nhãn phiên bản "(giao diện vN)" do crm.html ghi, chỉ đổi dòng chữ
    const ver = $("loading").querySelector("small");
    $("loading").textContent = "Đang kết nối máy chủ Google… ";
    if (ver) $("loading").appendChild(ver);
    if (!B.IN_GAS) {
      $("loading").textContent = "Trang CRM cần chạy trong Google Apps Script (xem apps-script/README.md).";
      return;
    }
    const slow = setTimeout(() => {
      $("loading").innerHTML = "Vẫn đang tải… Nếu quá 1 phút:<br>1. Mở link trong <b>cửa sổ ẩn danh</b> và chỉ đăng nhập <b>một</b> tài khoản Google (Apps Script lỗi khi trình duyệt đăng nhập nhiều tài khoản).<br>" +
        "2. Trong Apps Script, mở <b>Lần thực thi</b> (biểu tượng ☰▶ bên trái) xem hàm <code>crmBootstrap</code> có báo lỗi không.";
    }, 25000);
    try {
      const boot = await gas("crmBootstrap");
      clearTimeout(slow);
      Object.assign(S, boot);
    } catch (e) {
      clearTimeout(slow);
      $("loading").textContent = "Không tải được dữ liệu: " + e.message;
      return;
    }
    $("loading").hidden = true;
    $("app").hidden = false;
    $("who").textContent = S.user || "";
    $("sheetLink").href = S.sheetUrl;
    $("reportLink").href = S.appUrl ? S.appUrl + "?page=baocao" : "#";
    $("rpProjectLink").href = $("reportLink").href;
    $("brandSwitch").innerHTML = BRANDS.map((b) => `<button type="button" data-brand="${esc(b)}">${esc(b)}</button>`).join("") +
      `<button type="button" data-brand="">Tất cả</button>`;
    bind();
    bindWeekPicker();
    bindNewStaff();
    let b0 = "";
    try { b0 = localStorage.getItem("crm.brand") || ""; } catch (_) { /* bỏ qua */ }
    const fromUrl = await new Promise((res) => {
      try { google.script.url.getLocation((loc) => res((loc.parameter || {}).donvi || "")); } catch (_) { res(""); }
      setTimeout(() => res(""), 1500);
    });
    if (fromUrl) b0 = BRANDS.find((b) => slug(b) === slug(fromUrl)) || b0;
    setBrand(b0, true);
    refreshFilters();
    let tab = "tong";
    try { tab = localStorage.getItem("crm.tab") || tab; } catch (_) { /* bỏ qua */ }
    showTab(tab);
  }

  window.CrmBaoCao = { weekLabel, isoFromLabel, weeksForReport, S };
  // Apps Script có thể nạp trang sau khi DOMContentLoaded đã qua -> chạy ngay nếu DOM đã sẵn sàng
  if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", start);
  else start();
})();
