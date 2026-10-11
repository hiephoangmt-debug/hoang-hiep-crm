/* CRM Báo cáo Marketing – giao diện (chạy trong Google Apps Script, dữ liệu ở Google Sheet).
 * Dùng phần lõi tạo báo cáo của bao-cao-mkt/app.js qua window.BaoCaoMkt. */
(function () {
  "use strict";

  const B = window.BaoCaoMkt;
  const { PLATFORMS, KINDS, fmtInt, gas } = B;
  const PLATFORM_LABEL = { Facebook: "Facebook", Tiktok: "TikTok", Zalo: "Zalo", Google: "Google" };
  const STATUSES = ["Nháp", "Đã nộp", "Đã duyệt"];
  const NUM_FIELDS = ["chiPhi", "chiPhiPhi", "lead", "hienThi", "tiepCan", "luotNhap", "luotXem", "mql", "sql", "deal"];

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
  function weekList() {
    const set = new Set();
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
  function refreshFilters() {
    const weeks = weekList().map((w) => [w, weekLabel(w, true)]);
    const projects = S.DuAn.map((p) => p.ten);
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
      fillSelect($(p + "Project"), projects, p === "rp" ? $(p + "Project").value : $(p + "Project").value || projects[0], p === "rp" ? "Tất cả dự án" : null);
    }
    fillSelect($("enStaff"), staff, $("enStaff").value, "Tất cả nhân sự");
    fillSelect($("evStaff"), staff, $("evStaff").value || staff[0]);
    fillSelect($("fStaff"), staff, $("fStaff").value || staff[0]);
    fillSelect($("fPlatform"), PLATFORMS.map((p) => [p, PLATFORM_LABEL[p]]), $("fPlatform").value || "Facebook");
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
    const rows = effective(S.SoLieu.filter((r) => (!pj || r.duAn === pj) && r.tuan >= from && r.tuan <= to));
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

  // ------------------------------------------------------------ NHẬP SỐ LIỆU
  let editingId = null;
  function entryFilter() {
    const w = $("enWeek").value, pj = $("enProject").value, st = $("enStaff").value;
    return S.SoLieu.filter((r) => r.tuan === w && r.duAn === pj && (!st || r.nhanSu === st));
  }
  function renderEntries() {
    const rows = entryFilter().sort((a, b) => (a.nhanSu + a.nenTang).localeCompare(b.nhanSu + b.nenTang, "vi"));
    const t = sumOf(effective(rows));
    const head = ["Nhân sự", "Kênh", "Tài khoản QC", "Chiến dịch", "Chi phí", "Gồm phí", "Lead", "Hiển thị", "Tiếp cận", "MQL", "SQL", "DEAL", "Nguồn", ""];
    $("enTable").innerHTML = rows.length ? `<table class="data"><thead><tr>${head.map((h) => `<th>${h}</th>`).join("")}</tr></thead><tbody>
      ${rows.map((r) => `<tr class="${r.id === editingId ? "editing" : ""}${isShadowed(r) ? " shadow" : ""}"><td>${esc(r.nhanSu)}</td><td>${esc(PLATFORM_LABEL[r.nenTang] || r.nenTang)}</td>
        <td>${esc(r.taiKhoan)}</td><td>${esc(r.chienDich)}</td><td>${fmtInt(num(r.chiPhi))}</td><td>${fmtInt(num(r.chiPhiPhi))}</td>
        <td>${fmtInt(num(r.lead))}</td><td>${r.hienThi === "" ? "" : fmtInt(num(r.hienThi))}</td><td>${r.tiepCan === "" ? "" : fmtInt(num(r.tiepCan))}</td>
        <td>${esc(r.mql)}</td><td>${esc(r.sql)}</td><td>${esc(r.deal)}</td><td class="muted">${{ sheet: "Sheet", anh: "Ảnh chụp" }[r.nguon] || "Nhập tay"}${isShadowed(r) ? '<br><small class="warn-text">không tính (đã có số sheet/nhập tay)</small>' : ""}</td>
        <td class="act"><button type="button" class="link" data-edit="${esc(r.id)}">Sửa</button><button type="button" class="link danger" data-del="${esc(r.id)}">Xoá</button></td></tr>`).join("")}
      <tr class="total"><td colspan="4">TỔNG (${rows.length} dòng)</td><td>${fmtInt(t.chiPhi)}</td><td>${fmtInt(t.chiPhiPhi)}</td><td>${fmtInt(t.lead)}</td><td>${fmtInt(t.hienThi)}</td><td></td>
        <td>${fmtInt(t.mql)}</td><td>${fmtInt(t.sql)}</td><td>${fmtInt(t.deal)}</td><td colspan="2"></td></tr></tbody></table>`
      : `<p class="muted">Chưa có số liệu cho tuần ${esc(weekLabel($("enWeek").value, true))} · ${esc($("enProject").value)}. Nhập ở form bên trên, hoặc bấm “Nhập từ Google Sheet”.</p>`;
  }
  function clearForm() {
    editingId = null;
    ["fAccount", "fCampaign", "fNote"].concat(NUM_FIELDS.map((f) => "f_" + f)).forEach((id) => ($(id).value = ""));
    if ($("enStaff").value) $("fStaff").value = $("enStaff").value;
    $("fSave").textContent = "Thêm dòng";
    $("fCancel").hidden = true;
  }
  function editEntry(id) {
    const r = S.SoLieu.find((x) => x.id === id);
    if (!r) return;
    editingId = id;
    $("fStaff").value = r.nhanSu; $("fPlatform").value = r.nenTang || "Facebook";
    $("fAccount").value = r.taiKhoan; $("fCampaign").value = r.chienDich; $("fNote").value = r.ghiChu;
    NUM_FIELDS.forEach((f) => ($("f_" + f).value = r[f]));
    $("fSave").textContent = "Lưu thay đổi";
    $("fCancel").hidden = false;
    renderEntries();
    $("entryForm").scrollIntoView({ behavior: "smooth", block: "nearest" });
  }
  async function saveEntry(e) {
    e.preventDefault();
    const o = {
      tuan: $("enWeek").value, duAn: $("enProject").value, nhanSu: $("fStaff").value, nenTang: $("fPlatform").value,
      taiKhoan: $("fAccount").value.trim(), chienDich: $("fCampaign").value.trim(), ghiChu: $("fNote").value.trim(),
    };
    NUM_FIELDS.forEach((f) => { const v = $("f_" + f).value.trim(); o[f] = v === "" ? "" : num(v); });
    if (o.chiPhi === "" && o.lead === "") return toast("Nhập ít nhất chi phí hoặc lead.", "err");
    if (o.chiPhiPhi === "") o.chiPhiPhi = o.chiPhi;
    if (editingId) o.id = editingId; else o.nguon = "tay";
    const saved = await run("Đang lưu", () => gas("crmSave", "SoLieu", o));
    const i = S.SoLieu.findIndex((x) => x.id === saved.id);
    if (i >= 0) S.SoLieu[i] = saved; else S.SoLieu.push(saved);
    // tài khoản mới -> danh mục
    if (o.taiKhoan && !S.TaiKhoan.some((t) => digitsOf(t.maTaiKhoan) === digitsOf(o.taiKhoan) && t.maTaiKhoan)) {
      S.TaiKhoan.push(await gas("crmSave", "TaiKhoan", { maTaiKhoan: o.taiKhoan, nenTang: o.nenTang, nhanSu: o.nhanSu }));
    }
    toast("Đã lưu.", "ok");
    clearForm();
    refreshFilters();
    renderEntries();
  }
  async function deleteEntry(id) {
    const r = S.SoLieu.find((x) => x.id === id);
    if (!r || !confirm(`Xoá dòng ${r.nhanSu} · ${fmtInt(num(r.chiPhi))} đ?`)) return;
    await run("Đang xoá", () => gas("crmDelete", "SoLieu", id));
    S.SoLieu = S.SoLieu.filter((x) => x.id !== id);
    toast("Đã xoá.", "ok");
    renderEntries();
  }

  /** Nhập số liệu từ Google Sheet của dự án (mẫu "BÁO CÁO NGHIỆM THU THÁNG"). */
  async function importSheet() {
    const pj = project($("enProject").value);
    const id = B.parseDriveId(pj.nguonSoLieu);
    if (!id) return toast("Dự án chưa có link Google Sheet số liệu (tab Danh mục).", "err");
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

  // ------------------------------------------------------------ CHỨNG TỪ
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
  function campaignRows(p, i) {
    if (!p.campaigns || !p.campaigns.length) return "";
    return `<div class="camps"><b>Số liệu đọc từ ảnh</b> <small class="muted">(tick dòng thuộc tuần này)</small>
      ${p.campaigns.map((c, j) => `<label class="camp"><input type="checkbox" data-p="${i}" data-c="${j}" data-f="use"${c.use ? " checked" : ""}>
        <span class="cname" title="${esc(c.name)}">${esc(c.name)}</span>
        <input class="cnum" data-p="${i}" data-c="${j}" data-f="spent" value="${fmtInt(c.spent)}" aria-label="Chi tiêu">
        <span class="muted">${c.results != null ? fmtInt(c.results) + " " + (RESULT_LABEL[c.resultType] || "") : ""}</span></label>`).join("")}</div>`;
  }
  function renderEvidence() {
    const w = $("evWeek").value, pj = $("evProject").value;
    const staff = staffNames();
    $("evPending").innerHTML = pending.length ? pending.map((p, i) => `
      <figure class="img"><img src="${p.preview || p.url}" alt="${esc(p.file.name)}">
        <figcaption><span class="fname" title="${esc(p.file.name)}">${esc(p.file.name)}</span>
          ${p.note ? `<small class="muted">${esc(p.note)}</small>` : ""}
          ${campaignRows(p, i)}
          <div class="row"><select data-p="${i}" data-f="nenTang">${PLATFORMS.map((x) => opt(x, PLATFORM_LABEL[x], p.nenTang)).join("")}</select>
          <select data-p="${i}" data-f="loai">${Object.entries(KINDS).map(([k, l]) => opt(k, l, p.loai)).join("")}</select></div>
          <div class="row"><select data-p="${i}" data-f="nhanSu">${staff.map((x) => opt(x, x, p.nhanSu)).join("")}</select>
          <button type="button" class="link danger" data-unpend="${i}">Bỏ</button></div>
        </figcaption></figure>`).join("") : "";
    $("evUpload").hidden = !pending.length;
    const rows = S.ChungTu.filter((r) => r.tuan === w && r.duAn === pj);
    $("evCount").textContent = `${rows.length} ảnh đã lưu`;
    $("evList").innerHTML = rows.length ? rows.map((r) => `
      <figure class="img"><a href="${esc(r.url)}" target="_blank" rel="noopener"><img src="https://drive.google.com/thumbnail?id=${esc(r.fileId)}&sz=w400" alt="${esc(r.tenFile)}" onerror="this.replaceWith(Object.assign(document.createElement('div'),{className:'noimg',textContent:'Mở chứng từ'}))"></a>
        <figcaption><span class="fname" title="${esc(r.tenFile)}">${esc(r.tenFile)}</span>
          <div class="row"><select data-ev="${esc(r.id)}" data-f="nenTang">${PLATFORMS.map((x) => opt(x, PLATFORM_LABEL[x], r.nenTang)).join("")}</select>
          <select data-ev="${esc(r.id)}" data-f="loai">${Object.entries(KINDS).map(([k, l]) => opt(k, l, r.loai)).join("")}</select></div>
          <div class="row"><select data-ev="${esc(r.id)}" data-f="nhanSu">${staff.map((x) => opt(x, x, r.nhanSu)).join("")}</select>
          <button type="button" class="link danger" data-evdel="${esc(r.id)}">Xoá</button></div>
        </figcaption></figure>`).join("") : `<p class="muted">Chưa có ảnh chứng từ cho tuần này.</p>`;
  }
  async function addPending(files) {
    const staff = $("evStaff").value;
    const list = Array.from(files).filter((f) => /^image\//.test(f.type) || B.isPdf(f));
    for (const f of list) {
      const p = { file: f, url: URL.createObjectURL(f), nenTang: "Facebook", loai: B.isPdf(f) ? "hoadon" : "ads", nhanSu: staff, note: "", campaigns: [] };
      if (B.isPdf(f)) {
        try {
          const pages = await B.pdfToImages(f, 1);
          p.preview = URL.createObjectURL(pages[0]);
          p.text = await B.pdfText(f);
        } catch (e) { p.note = "Không đọc được PDF: " + e.message; }
      }
      pending.push(p);
    }
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
      toast("Đã đọc xong. Kiểm tra loại ảnh, nhân sự, số liệu rồi bấm Tải lên.", "ok");
    } catch (e) { toast("Không đọc được chữ trong ảnh: " + e.message, "err"); }
  }
  /** Tài khoản QC duy nhất của nhân sự trên kênh (để gán cho số liệu đọc từ ảnh). */
  function soleAccount(staff, platform) {
    const accs = S.TaiKhoan.filter((t) => t.nhanSu === staff && (!t.nenTang || t.nenTang === platform));
    return accs.length === 1 ? accs[0].maTaiKhoan : "";
  }
  async function uploadPending() {
    const w = $("evWeek").value, pj = $("evProject").value;
    let n = 0, nRows = 0;
    await run("Đang tải ảnh lên Drive", async () => {
      for (const p of pending.slice()) {
        toast(`Đang tải lên ${++n}/${pending.length}: ${p.file.name}`, "busy");
        const rec = await gas("crmUploadEvidence", { tuan: w, duAn: pj, nhanSu: p.nhanSu, nenTang: p.nenTang, loai: p.loai, tenFile: p.file.name, mime: p.file.type },
          await B.blobToB64(p.file));
        S.ChungTu.push(rec);
        const chosen = (p.campaigns || []).filter((c) => c.use && c.spent);
        if (chosen.length) {
          const rows = chosen.map((c) => {
            const prev = S.SoLieu.find((x) => x.nguon === "anh" && x.tuan === w && x.duAn === pj && x.nhanSu === p.nhanSu && x.chienDich === c.name);
            return {
              id: prev ? prev.id : undefined, tuan: w, duAn: pj, nhanSu: p.nhanSu, nenTang: p.nenTang,
              taiKhoan: soleAccount(p.nhanSu, p.nenTang), chienDich: c.name, chiPhi: c.spent, chiPhiPhi: c.spent,
              lead: c.resultType === "lead" ? c.results || 0 : 0, luotXem: c.resultType === "thruplay" ? c.results || "" : "",
              mql: "", sql: "", deal: "", hienThi: "", tiepCan: "", luotNhap: "",
              ghiChu: "Đọc từ ảnh " + p.file.name, nguon: "anh",
            };
          });
          const saved = await gas("crmSaveMany", "SoLieu", rows);
          saved.forEach((r) => { S.SoLieu = S.SoLieu.filter((x) => x.id !== r.id).concat(r); });
          nRows += saved.length;
        }
      }
    });
    pending.forEach((p) => URL.revokeObjectURL(p.url));
    pending = [];
    toast(`Đã lưu ${n} chứng từ vào Drive (Nhân sự/${pj}/${weekLabel(w)})` + (nRows ? ` và ${nRows} dòng số liệu đọc từ ảnh (xem tab Nhập số liệu).` : "."), "ok");
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
  async function buildOne(pjName, w, fmt) {
    const pj = project(pjName);
    const tplId = B.parseDriveId(pj.mauPptx);
    if (!tplId) throw new Error(`Dự án ${pjName} chưa có link PPTX mẫu (tab Danh mục).`);
    const rows = effective(S.SoLieu.filter((r) => r.duAn === pjName && r.tuan <= w));
    if (!rows.some((r) => r.tuan === w)) throw new Error(`${pjName}: chưa có số liệu tuần ${weekLabel(w)}.`);
    if (!tplCache[tplId]) { const t = await gas("downloadFile", tplId); tplCache[tplId] = B.b64ToBlob(t.b64, t.type); }
    const accStaff = new Map(rows.map((r) => [r.taiKhoan || r.nhanSu || "(không rõ)", r.nhanSu]));
    const ev = S.ChungTu.filter((r) => r.duAn === pjName && r.tuan === w);
    const images = [];
    for (const r of ev) {
      toast(`${pjName}: tải ảnh ${images.length + 1}/${ev.length}…`, "busy");
      const f = await gas("downloadFile", r.fileId);
      const file = new File([B.b64ToBlob(f.b64, f.type)], r.tenFile, { type: f.type });
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
      scope: "week", perSlide: 1, dropUnused: true, dropEmptyImageSlides: true,
    });
    const name = `Bao_cao_${pjName.replace(/\s+/g, "_")}_${weekLabel(w).replace(/[\/ ]/g, "")}.pptx`;
    const folder = B.parseDriveId(pj.thuMucBaoCao) || "";
    const b64 = await B.blobToB64(res.blob);
    const out = { tuan: w, duAn: pjName, trangThai: "Nháp", pdfUrl: "", pptxUrl: "",
      tomTat: `${res.slides} slide, ${res.staffCount} nhân sự, ${res.nImg} ảnh` };
    if (fmt !== "pdf") { toast(`${pjName}: lưu PPTX…`, "busy"); out.pptxUrl = await gas("saveReport", b64, name, folder); }
    if (fmt !== "pptx") { toast(`${pjName}: chuyển PDF…`, "busy"); out.pdfUrl = (await gas("convertToPdf", b64, name, folder)).url; }
    const prev = S.BaoCao.find((r) => r.duAn === pjName && r.tuan === w);
    if (prev) out.id = prev.id;
    const saved = await gas("crmSave", "BaoCao", out);
    S.BaoCao = S.BaoCao.filter((r) => r.id !== saved.id).concat(saved);
    return saved;
  }
  async function generateReports() {
    const w = $("rpWeek").value, fmt = $("rpFormat").value;
    const list = $("rpProject").value ? [$("rpProject").value] : S.DuAn.map((p) => p.ten);
    const msgs = [];
    $("rpGo").disabled = true;
    try {
      for (const pj of list) {
        try { const r = await buildOne(pj, w, fmt); msgs.push(`${pj}: ${r.tomTat}`); }
        catch (e) { console.error(e); msgs.push(`${pj}: lỗi – ${e.message}`); }
      }
      toast("Xong. " + msgs.join(" | "), msgs.some((m) => m.includes("lỗi")) ? "err" : "ok");
    } finally { $("rpGo").disabled = false; renderReports(); }
  }
  function renderReports() {
    const rows = S.BaoCao.slice().sort((a, b) => String(b.tuan + b.ngayTao).localeCompare(String(a.tuan + a.ngayTao)));
    $("rpTable").innerHTML = rows.length ? `<table class="data"><thead><tr><th>Tuần</th><th>Dự án</th><th>Trạng thái</th><th>File</th><th>Nội dung</th><th>Người tạo</th><th>Ngày tạo</th></tr></thead><tbody>
      ${rows.map((r) => `<tr><td>${esc(weekLabel(r.tuan, true))}</td><td>${esc(r.duAn)}</td>
        <td><select data-rp="${esc(r.id)}" class="st-${STATUSES.indexOf(r.trangThai)}">${STATUSES.map((s) => opt(s, s, r.trangThai)).join("")}</select></td>
        <td>${r.pdfUrl ? `<a href="${esc(r.pdfUrl)}" target="_blank" rel="noopener">PDF</a>` : ""} ${r.pptxUrl ? `<a href="${esc(r.pptxUrl)}" target="_blank" rel="noopener">PPTX</a>` : ""}</td>
        <td>${esc(r.tomTat)}</td><td class="muted">${esc(r.nguoiTao)}</td><td class="muted">${esc(r.ngayTao)}</td></tr>`).join("")}</tbody></table>`
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
        if (c === "trangThai") return `<select data-ct="${t2}" data-id="${id}" data-f="${c}">${["Đang làm", "Nghỉ"].map((s) => opt(s, s, v || "Đang làm")).join("")}</select>`;
        return `<input data-ct="${t2}" data-id="${id}" data-f="${c}" value="${esc(v)}">`;
      };
      return `<section class="card"><h3>${title}</h3><div class="wrap"><table class="data edit"><thead><tr>${cols.map((c) => `<th>${esc(c[1])}</th>`).join("")}<th></th></tr></thead><tbody>
        ${S[t].map((r) => `<tr>${cols.map((c) => `<td>${cell(t, c[0], r[c[0]], r.id)}</td>`).join("")}
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
    document.querySelectorAll("[data-tab]").forEach((b) => b.addEventListener("click", () => showTab(b.dataset.tab)));
    ["dbProject", "dbFrom", "dbTo"].forEach((id) => $(id).addEventListener("change", renderDashboard));
    ["enWeek", "enProject", "enStaff"].forEach((id) => $(id).addEventListener("change", () => { clearForm(); renderEntries(); }));
    ["evWeek", "evProject"].forEach((id) => $(id).addEventListener("change", renderEvidence));
    $("evStaff").addEventListener("change", () => { pending.forEach((p) => (p.nhanSu = $("evStaff").value)); renderEvidence(); });
    $("entryForm").addEventListener("submit", saveEntry);
    $("fCancel").addEventListener("click", () => { clearForm(); renderEntries(); });
    $("fAccount").addEventListener("change", () => {
      const a = S.TaiKhoan.find((t) => t.maTaiKhoan === $("fAccount").value.trim());
      if (a) { if (a.nhanSu) $("fStaff").value = a.nhanSu; if (a.nenTang) $("fPlatform").value = a.nenTang; }
    });
    $("enImport").addEventListener("click", () => importSheet().catch(() => {}));
    $("enTable").addEventListener("click", (e) => {
      const b = e.target.closest("button");
      if (!b) return;
      if (b.dataset.edit) editEntry(b.dataset.edit);
      if (b.dataset.del) deleteEntry(b.dataset.del).catch(() => {});
    });
    $("evFiles").addEventListener("change", () => { addPending($("evFiles").files); $("evFiles").value = ""; });
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
        else c.spent = Math.round(num(t.value));
        return;
      }
      pending[i][t.dataset.f] = t.value;
    });
    $("evPending").addEventListener("click", (e) => {
      const i = e.target.dataset.unpend;
      if (i == null) return;
      URL.revokeObjectURL(pending[i].url);
      pending.splice(i, 1);
      renderEvidence();
    });
    $("evUpload").addEventListener("click", () => uploadPending().catch(() => {}));
    $("evList").addEventListener("change", async (e) => {
      const id = e.target.dataset.ev;
      if (!id) return;
      const r = S.ChungTu.find((x) => x.id === id);
      r[e.target.dataset.f] = e.target.value;
      await run("Đang lưu", () => gas("crmSave", "ChungTu", { id, [e.target.dataset.f]: e.target.value }));
      toast("Đã lưu.", "ok");
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
        S[t].push(await run("Đang thêm", () => gas("crmSave", t, t === "NhanSu" ? { ten: "Nhân sự mới", trangThai: "Đang làm" } : t === "DuAn" ? { ten: "Dự án mới" } : { nenTang: "Facebook" })));
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
    if (!B.IN_GAS) {
      $("loading").textContent = "Trang CRM cần chạy trong Google Apps Script (xem apps-script/README.md).";
      return;
    }
    try {
      const boot = await gas("crmBootstrap");
      Object.assign(S, boot);
    } catch (e) {
      $("loading").textContent = "Không tải được dữ liệu: " + e.message;
      return;
    }
    $("loading").hidden = true;
    $("app").hidden = false;
    $("who").textContent = S.user || "";
    $("sheetLink").href = S.sheetUrl;
    $("reportLink").href = S.appUrl ? S.appUrl + "?page=baocao" : "#";
    $("rpProjectLink").href = $("reportLink").href;
    bind();
    refreshFilters();
    clearForm();
    let tab = "tong";
    try { tab = localStorage.getItem("crm.tab") || tab; } catch (_) { /* bỏ qua */ }
    showTab(tab);
  }

  window.CrmBaoCao = { weekLabel, isoFromLabel, weeksForReport, S };
  document.addEventListener("DOMContentLoaded", start);
})();
