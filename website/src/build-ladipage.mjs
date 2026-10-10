// Dựng bộ trang HTML cho LadiPage (kéo-thả sửa được) từ cùng dữ liệu với website.
// Chạy: node src/build-ladipage.mjs  →  website/ladipage/<slug>.html + manifest.json
// Tuân thủ luật LadiPage v2: tabs, form, accordion (details) – không dùng widget JS khác.
import { mkdirSync, writeFileSync, readFileSync } from "node:fs";
import { dirname, join } from "node:path";
import { fileURLToPath } from "node:url";
import { site, investor, plazas, zones } from "./data.mjs";
import * as fp4 from "./fpt-plaza-4-units.mjs";

const HERE = dirname(fileURLToPath(import.meta.url));
const OUT = join(HERE, "..", "ladipage");
const CSS = readFileSync(join(HERE, "ladipage.css"), "utf8");
const BASE = "https://www.fpt-city.com";
const IMG = "https://raw.githubusercontent.com/hiephoangmt-debug/hoang-hiep-crm/5051b81aefcfec407044094b96b5dfc7fdd47de8/website/public/assets/img/fpt-plaza-4";
const HOTLINE = site.agent.phone, TEL = HOTLINE.replace(/\s/g, ""), ZALO = TEL;
const esc = (s = "") => String(s).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;");
const nf = (n) => String(n).replace(".", ",");
const vn = (n) => String(n).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
const pad = (n) => String(n).padStart(2, "0");
const pathOf = (slug) => ({ home: "/", land: "/dat-nen-fpt-city", apt: "/can-ho-fpt-plaza" }[slug] || (slug.startsWith("phan-khu") ? "/dat-nen-fpt-city/" + slug : "/" + slug));
const link = (slug) => BASE + (pathOf(slug) === "/" ? "/" : pathOf(slug));

const BUDGET_APT = ["Dưới 2 tỷ", "2 – 3 tỷ", "3 – 4 tỷ", "4 – 6 tỷ", "Trên 6 tỷ"];
const BUDGET_LAND = ["Dưới 3 tỷ", "3 – 5 tỷ", "5 – 8 tỷ", "Trên 8 tỷ"];

/* ---------- Lời kêu gọi hành động (gợi tò mò, trung thực: không đếm ngược giả, không "chỉ còn X căn") ---------- */
const HOOKS = {
  "fpt-plaza-1": { cta: "Xem giỏ hàng chuyển nhượng hôm nay", ghost: "Xem loại căn", title: "Căn nào vừa tầm ngân sách của bạn?", btn: "Gửi tôi 3 căn phù hợp nhất", band: "Căn FPT Plaza 1 bạn đang ngắm, giá thực tế là bao nhiêu?", bandBtn: "Hỏi giá căn bạn quan tâm", docs: ["🔄 Giỏ hàng căn đang chuyển nhượng", "💰 Giá theo tầng, hướng, nội thất", "📐 Mặt bằng căn hộ", "🏠 Lịch xem nhà thực tế"] },
  "fpt-plaza-2": { cta: "Xem căn tầng cao đang chuyển nhượng", ghost: "Xem loại căn", title: "Căn 2PN – 3PN nào hợp với gia đình bạn?", btn: "Gửi tôi 3 căn phù hợp nhất", band: "Nhìn thấy sông và biển từ căn nào? Hỏi mã căn để biết.", bandBtn: "Nhận giỏ hàng FPT Plaza 2", docs: ["🔄 Giỏ hàng căn đang chuyển nhượng", "💰 Giá theo tầng & hướng", "📐 Mặt bằng 2PN – 3PN", "🏠 Lịch xem nhà thực tế"] },
  "fpt-plaza-3": { cta: "Xem lịch bàn giao & giá FPT Plaza 3", ghost: "Xem loại căn", title: "Sắp nhận nhà: căn nào còn hợp với bạn?", btn: "Gửi tôi bảng giá & lịch bàn giao", band: "Sắp bàn giao rồi, bạn đã biết căn nào phù hợp chưa?", bandBtn: "Nhận bảng giá FPT Plaza 3", docs: ["📅 Lịch bàn giao cập nhật", "💰 Bảng giá & chính sách", "📐 Mặt bằng tòa E & W", "🏦 Phương án vay ngân hàng"] },
  "fpt-plaza-4": { cta: "Xem căn hợp ngân sách – nhận 3 gợi ý", ghost: "Xem mặt bằng 5 tầng", title: "Căn nào hợp ngân sách của bạn?", btn: "Gửi tôi 3 căn phù hợp nhất", band: "Bạn đang ngắm căn nào? Gõ mã căn, nhận giá đúng căn đó.", bandBtn: "Hỏi giá theo mã căn", docs: ["💰 Bảng giá theo tầng, hướng", "📐 Mặt bằng 5 tầng & layout căn", "🎁 Chính sách thanh toán, vay", "🧮 Bảng tính dòng tiền cho thuê"] },
  "fpt-plaza-5": { cta: "Là người đầu tiên biết giá FPT Plaza 5", ghost: "Xem thông tin dự kiến", title: "Báo tôi ngay khi FPT Plaza 5 có giá", btn: "Đăng ký nhận giá đầu tiên", band: "FPT Plaza 5 chưa công bố giá. Bạn muốn biết trước người khác?", bandBtn: "Đăng ký nhận giá đầu tiên", docs: ["🔔 Báo giá ngay khi có thông tin", "📐 Mặt bằng & loại căn dự kiến", "🆚 So sánh với FPT Plaza 4", "🎯 Ưu tiên chọn căn đẹp"] },
};
const ZONE_HOOK = (z) => ({ cta: `Xem lô phân khu ${z.code} vừa tầm giá của bạn`, ghost: "Xem đặc điểm khu", title: `Lô nào ở ${z.code} vừa ngân sách của bạn?`, btn: "Gửi tôi 3 lô phù hợp nhất", band: `Lô ${z.code} nào đang ra giá tốt? Gửi ngân sách để biết.`, bandBtn: `Nhận giỏ hàng phân khu ${z.code}`, docs: [`🗺️ Bản đồ phân lô ${z.code}`, "📄 Lô đang bán & giá", "📑 Pháp lý từng lô", "🚗 Hẹn lịch xem đất"] });

/* ---------- Khối HTML dùng chung ---------- */
const nav = () => `
<div class="topbar"><div class="wrap">
  <a class="brand" href="${BASE}/">FPT City<small>Đà Nẵng</small></a>
  <a href="${link("land")}">Đất nền</a>
  <a href="${link("apt")}">Căn hộ FPT Plaza</a>
  <a href="${link("fpt-plaza-4")}">FPT Plaza 4</a>
  <a href="${link("fpt-plaza-5")}">FPT Plaza 5</a>
  <a href="${site.agent.url}">${esc(site.agent.name)}</a>
  <a class="cta" href="#dang-ky">Nhận bảng giá</a>
</div></div>`;

const form = (id, { button, budget, extra, hidden }) => `
<form>
  <label for="${id}-name">Họ và tên</label>
  <input id="${id}-name" name="name" type="text" placeholder="Nguyễn Văn A">
  <label for="${id}-phone">Số điện thoại / Zalo</label>
  <input id="${id}-phone" name="phone" type="tel" placeholder="09xx xxx xxx">
  ${budget ? `<label for="${id}-budget">Ngân sách dự kiến</label>
  <select id="${id}-budget" name="budget"><option value="" disabled selected>Chọn mức ngân sách</option>${budget.map((b) => `<option>${esc(b)}</option>`).join("")}</select>` : ""}
  ${extra ? `<label for="${id}-code">${esc(extra.label)}</label><input id="${id}-code" name="unit" type="text" placeholder="${esc(extra.ph)}">` : ""}
  <button class="btn" type="submit">${esc(button)}</button>
  <p class="note">Hoặc gọi ngay <a href="tel:${TEL}">${HOTLINE}</a> · Chuyên viên gửi qua Zalo / điện thoại</p>
</form>`;

const hero = ({ crumbs, eyebrow, h1, lead, points, cta, ghost, ghostHref, formTitle, docs, formHtml, stats }) => `
<header class="hero">
  <div class="wrap hero-grid">
    <div>
      ${crumbs ? `<p class="crumbs">${crumbs}</p>` : ""}
      <p class="eyebrow" style="color:var(--orange)">${eyebrow}</p>
      <h1>${h1}</h1>
      <p class="lead">${lead}</p>
      <ul class="points">${points.map((p) => `<li>${esc(p)}</li>`).join("")}</ul>
      <div class="cta-row"><a class="btn" href="#dang-ky">${esc(cta)}</a><a class="btn btn-ghost" href="${ghostHref}">${esc(ghost)}</a></div>
    </div>
    <div class="card">
      <h2>${esc(formTitle)}</h2>
      <ul class="docs">${docs.map((d) => `<li>${esc(d)}</li>`).join("")}</ul>
      ${formHtml}
    </div>
  </div>
  ${stats ? `<div class="wrap stats">${stats.map(([b, s]) => `<div class="stat"><b>${esc(b)}</b><span>${esc(s)}</span></div>`).join("")}</div>` : ""}
</header>`;

const specCard = (title, rows, note) => `
<div class="spec"><h3>${esc(title)}</h3>
${rows.map(([k, v]) => `<div class="row"><span>${esc(k)}</span><b>${esc(v)}</b></div>`).join("")}
${note ? `<p class="small" style="margin-top:12px">${esc(note)}</p>` : ""}</div>`;

const head = (h) => `
<div style="text-align:center;max-width:780px;margin:0 auto 32px"><p class="eyebrow">${esc(h.eyebrow)}</p><h2 class="title">${esc(h.title)}</h2>${h.sub ? `<p style="color:var(--muted)">${h.sub}</p>` : ""}</div>`;

const distances = () => `
<section id="vi-tri" class="tint"><div class="wrap two">
  <div><p class="eyebrow">Vị trí</p><h2 class="title">Phía Nam Đà Nẵng, giữa sông, biển và trung tâm</h2>
  <p>Khu đô thị FPT City nằm phía Nam Đà Nẵng, hạ tầng đồng bộ, kết nối nhanh về trung tâm thành phố, sân bay, biển Non Nước và phố cổ Hội An.</p>
  <a class="btn" href="https://www.google.com/maps?q=FPT+City+Da+Nang">📍 Xem bản đồ FPT City</a></div>
  <ul class="dist">
    <li><span>Đại học FPT &amp; FPT Complex</span><b>Trong khu đô thị</b></li><li><span>Biển Tân Trà – Non Nước</span><b>~5 phút</b></li>
    <li><span>Danh thắng Ngũ Hành Sơn</span><b>~10 phút</b></li><li><span>Trung tâm TP. Đà Nẵng</span><b>~15–20 phút</b></li>
    <li><span>Sân bay quốc tế Đà Nẵng</span><b>~20 phút</b></li><li><span>Phố cổ Hội An</span><b>~20 phút</b></li>
  </ul></div></section>`;

const amenities = () => `
<section><div class="wrap">${head({ eyebrow: "Tiện ích", title: "Hệ sinh thái sống, học và làm việc trong một khu đô thị" })}
<div class="amen">
  <div><h3>🎓 Giáo dục liên cấp</h3><p>Hệ thống trường FPT từ phổ thông đến Đại học FPT ngay trong khu đô thị.</p></div>
  <div><h3>🏢 FPT Complex</h3><p>Tổ hợp văn phòng công nghệ hàng nghìn kỹ sư, nguồn khách thuê ổn định.</p></div>
  <div><h3>🌳 Công viên &amp; kênh sinh thái</h3><p>Cây xanh, đường dạo bộ, sân thể thao ngoài trời.</p></div>
  <div><h3>🏊 Hồ bơi &amp; gym</h3><p>Tiện ích nội khu tại các tòa FPT Plaza.</p></div>
  <div><h3>🛒 Thương mại – dịch vụ</h3><p>Shophouse, siêu thị, cà phê, nhà hàng phục vụ nhu cầu hằng ngày.</p></div>
  <div><h3>🛡️ Đô thị thông minh</h3><p>Định hướng vận hành công nghệ của Tập đoàn FPT.</p></div>
</div></div></section>`;

const faqSection = (title, faq) => `
<section id="faq"><div class="wrap">${head({ eyebrow: "Hỏi đáp", title })}
<div class="faq">${faq.map(([q, a]) => `<details><summary>${esc(q)}</summary><p>${esc(a)}</p></details>`).join("")}</div></div></section>`;

const ctaSection = ({ title, intro, steps, formHtml, formTitle }) => `
<section id="dang-ky" class="tint"><div class="wrap two">
  <div><p class="eyebrow">Bảng giá &amp; tài liệu</p><h2 class="title">${esc(title)}</h2><p>${intro}</p>
  <ol class="steps">${steps.map((s) => `<li>${s}</li>`).join("")}</ol></div>
  <div class="cta-box"><h3>${esc(formTitle)}</h3>${formHtml}</div></div></section>`;

const band = (text, btn) => `<section class="hook"><div class="wrap"><div><h2>${esc(text)}</h2></div><a class="btn" href="#dang-ky">${esc(btn)}</a></div></section>`;

const tile = (href, pill, title, text, go) => `<a class="tile" href="${href}">${pill}<h3>${esc(title)}</h3><p>${esc(text)}</p><span class="go">${esc(go)} →</span></a>`;
const plazaPill = (p) => `<span class="pill ${p.status === "upcoming" ? "up" : p.status === "resale" ? "re" : "on"}">${esc(p.statusLabel)}</span>`;
const plazaTiles = (except) => `<div class="grid-auto">${plazas.filter((p) => p.slug !== except).map((p) => tile(link(p.slug), plazaPill(p), p.name, p.specs.slice(0, 2).map((s) => s[1]).join(" · "), "Xem " + p.name)).join("")}</div>`;
const zoneTiles = (except) => `<div class="grid-auto">${zones.filter((z) => z.slug !== except).map((z) => tile(link(z.slug), `<span class="code">${z.code}</span>`, "Phân khu " + z.code, z.traits[0], "Xem lô " + z.code)).join("")}</div>`;
const gotoSec = (title, inner, eyebrow = "Khám phá thêm") => `<section><div class="wrap">${head({ eyebrow, title })}${inner}</div></section>`;

const footer = () => `
<footer><div class="wrap">
  <p><b style="color:#fff">FPT City Đà Nẵng · Căn hộ FPT Plaza &amp; đất nền</b></p>
  <p>Tư vấn &amp; phân phối: <a href="${site.agent.url}"><b>${esc(site.agent.name)}</b> – hoanghiepmt.com</a> · Hotline <a href="tel:${TEL}">${HOTLINE}</a></p>
  <p style="font-size:12px;opacity:.65">Thông tin, hình ảnh và số liệu mang tính tham khảo, có thể thay đổi theo công bố chính thức của chủ đầu tư (${esc(investor)}). Website do đơn vị tư vấn – phân phối vận hành, không phải trang chính thức của Tập đoàn FPT.</p>
</div></footer>
<div class="fabs"><a class="fab fab-zalo" href="https://zalo.me/${ZALO}">Zalo</a><a class="fab fab-call" href="tel:${TEL}">📞</a></div>`;

const TABS_JS = `<script>
document.querySelectorAll('[role="tablist"]').forEach(function (list) {
  var tabs = list.querySelectorAll('[role="tab"]');
  tabs.forEach(function (tab) {
    tab.addEventListener('click', function () {
      tabs.forEach(function (t) {
        var on = t === tab;
        t.setAttribute('aria-selected', on ? 'true' : 'false');
        var panel = document.getElementById(t.getAttribute('aria-controls'));
        if (panel) panel.hidden = !on;
      });
    });
  });
});
</script>`;

const page = ({ slug, title, description, keywords, body, tabs }) => `<!doctype html>
<html lang="vi">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="ladipage-rules" content="v2">
<title>${esc(title)}</title>
<meta name="description" content="${esc(description)}">
<meta name="keywords" content="${esc(keywords)}">
<link rel="canonical" href="${link(slug)}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
<style>
${CSS}</style>
</head>
<body>
${nav()}
${body}
${footer()}
${tabs ? TABS_JS : ""}
</body>
</html>
`;

/* ---------- Nội dung riêng FPT Plaza 4: mặt bằng tầng (tabs), bảng căn, layout ---------- */
const sortNo = (a, b) => parseInt(a, 10) - parseInt(b, 10) || a.localeCompare(b);
function unitTable(f, b) {
  const label = f.from === f.to ? pad(f.from) : "X";
  const rows = Object.entries(f[b]).sort((x, y) => sortNo(x[0], y[0]))
    .map(([no, [type, area]]) => `<tr><th scope="row">${b}-${label}.${no}</th><td>${esc(fp4.typeLabel[type] || type)}</td><td>${nf(area)}${type.startsWith("DUP") ? "*" : ""}</td></tr>`).join("");
  return `<div><h4>Khối ${b === "N" ? "N (Bắc)" : "S (Nam)"} · ${Object.keys(f[b]).length} căn</h4><div class="tbl-scroll"><table><thead><tr><th>Mã căn</th><th>Loại</th><th>m²</th></tr></thead><tbody>${rows}</tbody></table></div></div>`;
}
function floorplanBlock(p) {
  const ranges = fp4.typeRanges();
  const tabs = fp4.floors.map((f, i) => `<button role="tab" aria-selected="${i === 0}" aria-controls="tang-${f.id}">${esc(f.label.replace(" (điển hình)", ""))}</button>`).join("");
  const panels = fp4.floors.map((f, i) => `<div role="tabpanel" id="tang-${f.id}"${i ? " hidden" : ""}><div class="plan-inner">
    <img src="${IMG}/mat-bang-fpt-plaza-4-tang-${f.img.replace("tang-", "")}.webp" alt="Mặt bằng ${esc(f.label.toLowerCase())} ${p.name} Đà Nẵng" width="2382" height="1685">
    <p>${esc(f.note)}</p>
    <div class="two-tables">${unitTable(f, "N")}${unitTable(f, "S")}</div>
    ${f.id === "19" || f.id === "20" ? '<p class="small">* Diện tích Duplex hiển thị theo từng tầng (19 hoặc 20); tổng diện tích căn là cộng hai tầng.</p>' : ""}
  </div></div>`).join("");
  const summary = fp4.typeOrder.filter((t) => ranges[t]).map((t) => {
    const [a, b, n] = ranges[t];
    return `<tr><th scope="row">${esc(fp4.typeLabel[t])}</th><td>${a === b ? nf(a) : nf(a) + " – " + nf(b)} m²${t.startsWith("DUP") ? " (tổng 2 tầng)" : ""}</td><td>${vn(n)}</td></tr>`;
  }).join("");
  const lays = fp4.layouts.map((l) => `<div class="lay"><img src="${IMG}/layout/layout-fpt-plaza-4-${l.img}-sm.webp" alt="Layout căn ${esc(fp4.layoutCodes(l))} FPT Plaza 4 – ${esc(l.label)} ${nf(l.area)} m²" width="520" height="735"><div><b>${esc(fp4.layoutCodes(l))}</b><span>${esc(l.label)} · ${nf(l.area)} m²</span></div></div>`).join("");
  return `
<section id="mat-bang" class="tint"><div class="wrap">
  ${head({ eyebrow: "Mặt bằng tầng", title: "Mặt bằng tầng FPT Plaza 4 & mã căn", sub: `Hai khối N (Bắc) và S (Nam), ${vn(fp4.totalUnits())} căn từ tầng 3 đến tầng 20. Mã căn dạng <b>Khối-Tầng.Số</b>, ví dụ N-07.12 là khối N, tầng 7, căn số 12.` })}
  <div class="plans"><div role="tablist" class="tablist" aria-label="Chọn tầng">${tabs}</div><div>${panels}</div></div>
  <div class="hint"><b>Đang ngắm một căn cụ thể?</b> Ghi mã căn (VD: N-12.12) vào ô “Mã căn đang quan tâm” ở form bên dưới, chuyên viên gửi giá đúng căn đó, kèm các căn cùng loại để bạn so sánh.</div>
  <div class="tbl"><table><thead><tr><th>Loại căn</th><th>Diện tích</th><th>Số căn (tầng 3–20)</th></tr></thead><tbody>${summary}</tbody></table></div>
  <p class="small" style="margin-top:10px">Số liệu từ mặt bằng tầng của chủ đầu tư, chỉ để tham khảo; thông số chính thức theo hợp đồng mua bán. Tổng dự án 1.395 căn theo công bố.</p>
</div></section>
<section id="layout"><div class="wrap">
  ${head({ eyebrow: "Layout căn hộ", title: "Layout căn hộ mẫu FPT Plaza 4", sub: "Bố trí nội thất tham khảo từng căn. Nhận trọn bộ layout trong tài liệu dự án." })}
  <div class="layouts">${lays}</div>
</div></section>`;
}

/* ---------- Gợi ý "phù hợp với ai" ---------- */
const AUDIENCE = {
  resale: [["🏠 Ở ngay", "Căn đã bàn giao, có cư dân sinh sống, xem nhà thực tế trước khi quyết định."], ["💼 Cho thuê", "Gần FPT Complex và Đại học FPT: nhu cầu thuê từ kỹ sư, giảng viên, sinh viên."], ["📈 Giữ tài sản", "Vị trí trong khu đô thị đã hình thành, hạ tầng và tiện ích vận hành sẵn."]],
  primary: [["🏠 Ở thực", "Căn 1PN–3PN, hướng và tầng đa dạng cho gia đình trẻ."], ["💼 Cho thuê", "Căn 2PN diện tích vừa phải dễ cho thuê khu vực FPT Complex."], ["📈 Đầu tư", "Thanh toán theo tiến độ, có thể vay ngân hàng; chọn tầng cao, căn góc."]],
  upcoming: [["🔔 Biết giá sớm", "Đăng ký để nhận bảng giá ngay khi chủ đầu tư công bố."], ["🎯 Chọn căn đẹp", "Ưu tiên tư vấn tầng cao, hướng đẹp khi mở bán."], ["🆚 So sánh trước", "Xem FPT Plaza 4 (đang mở bán) để hình dung mặt bằng giá và loại căn."]],
};
const COMPARE = (except) => `<div class="tbl"><table><thead><tr><th>Dự án</th><th>Quy mô</th><th>Tình trạng</th><th></th></tr></thead><tbody>${plazas.map((p) => {
  const sp = (k) => (p.specs.find((s) => s[0] === k) || [, "—"])[1];
  return `<tr><th scope="row">${p.slug === except ? esc(p.name) + " (đang xem)" : esc(p.name)}</th><td>${esc(sp("Quy mô"))} · ${esc(sp("Số căn hộ"))}</td><td>${esc(p.statusLabel)}</td><td>${p.slug === except ? "" : `<a href="${link(p.slug)}">Xem →</a>`}</td></tr>`;
}).join("")}</tbody></table></div>`;

/* ================= DỰNG TỪNG TRANG ================= */
const pages = [];
const add = (p) => { pages.push(p); };

// --- Căn hộ FPT Plaza 1..5
for (const p of plazas) {
  const H = HOOKS[p.slug];
  const isFp4 = p.slug === "fpt-plaza-4";
  const fHero = form("h", { button: H.btn, budget: BUDGET_APT, extra: isFp4 ? { label: "Mã căn đang quan tâm (nếu có)", ph: "VD: N-12.12" } : null });
  const fCta = form("c", { button: H.btn, budget: BUDGET_APT, extra: isFp4 ? { label: "Mã căn đang quan tâm (nếu có)", ph: "VD: N-12.12" } : null });
  const unitsSection = isFp4 ? floorplanBlock(p) : `
<section id="mat-bang" class="tint"><div class="wrap">
  ${head({ eyebrow: "Loại căn", title: `Loại căn & diện tích ${p.name}`, sub: "Diện tích tham khảo. Layout chi tiết có trong bộ tài liệu dự án." })}
  <div class="grid-auto">${p.units.map(([t, a]) => `<div class="tile"><span class="pill">${esc(t)}</span><h3>${esc(a)}</h3><p>Căn ${esc(t)} tại ${esc(p.name)}</p><a class="go" href="#dang-ky">Xem giá & layout →</a></div>`).join("")}</div>
</div></section>`;
  add({
    slug: p.slug, name: p.name, title: p.title, description: p.description, keywords: p.keywords, tabs: isFp4,
    body: `
${hero({
      crumbs: `<a href="${BASE}/">Trang chủ</a> › <a href="${link("apt")}">Căn hộ FPT Plaza</a> › ${esc(p.name)}`,
      eyebrow: `Khu đô thị FPT City Đà Nẵng · ${esc(p.statusLabel)}`, h1: `Căn hộ <span>${p.name}</span> Đà Nẵng`, lead: esc(p.lead), points: p.highlights.slice(0, 3),
      cta: H.cta, ghost: H.ghost, ghostHref: "#mat-bang", formTitle: H.title, docs: H.docs, formHtml: fHero, stats: p.stats,
    })}
<section id="tong-quan"><div class="wrap two">
  <div><p class="eyebrow">Tổng quan ${esc(p.name)}</p><h2 class="title">Điểm nổi bật căn hộ ${esc(p.name)}</h2>
  <p>${esc(p.lead)} Chủ đầu tư: ${esc(investor)}.</p>
  <ul class="checks">${p.highlights.map((h) => `<li>${esc(h)}</li>`).join("")}</ul>
  <a class="btn" href="#dang-ky">${esc(H.cta)}</a>
  ${p.progressUrl ? `<p style="margin-top:14px"><a href="${esc(p.progressUrl)}">📷 Xem tiến độ &amp; hình ảnh thực tế →</a></p>` : ""}</div>
  ${specCard(`Thông tin ${p.name}`, [["Dự án", "Căn hộ " + p.name], ["Chủ đầu tư", "Công ty CP Đô thị FPT Đà Nẵng"], ["Vị trí", "Khu đô thị FPT City, Đà Nẵng"], ...p.specs], p.note)}
</div></section>
${unitsSection}
<section><div class="wrap">${head({ eyebrow: "Phù hợp với ai", title: `${p.name} dành cho nhu cầu nào?` })}
  <div class="amen">${AUDIENCE[p.status].map(([t, d]) => `<div><h3>${t}</h3><p>${esc(d)}</p></div>`).join("")}</div></div></section>
${band(H.band, H.bandBtn)}
<section class="tint"><div class="wrap">${head({ eyebrow: "So sánh", title: "FPT Plaza 1, 2, 3, 4, 5: khác nhau thế nào?" })}${COMPARE(p.slug)}</div></section>
${distances()}
${amenities()}
${ctaSection({
      title: p.status === "resale" ? `Giá chuyển nhượng ${p.name} hôm nay` : p.status === "upcoming" ? "Đăng ký nhận giá FPT Plaza 5 đầu tiên" : `Bảng giá ${p.name}: xem trước khi chọn căn`,
      intro: "Để lại thông tin, bạn nhận được:", formTitle: H.title, formHtml: fCta,
      steps: p.status === "resale"
        ? ["<b>Giỏ hàng căn đang chuyển nhượng</b>, giá theo tầng, hướng, nội thất.", "<b>3 căn gợi ý</b> theo ngân sách bạn chọn.", "<b>Hỗ trợ pháp lý</b> sang tên, phương án vay.", "<b>Lịch xem nhà</b> thực tế cùng chuyên viên."]
        : p.status === "upcoming"
          ? ["<b>Báo giá ngay</b> khi chủ đầu tư công bố.", "<b>Mặt bằng & loại căn</b> dự kiến để bạn so sánh sớm.", "<b>Ưu tiên tư vấn</b> tầng đẹp, hướng đẹp khi mở bán.", "<b>So sánh với FPT Plaza 4</b> để hình dung mức giá."]
          : ["<b>Bảng giá chi tiết</b> theo tầng, hướng, loại căn.", "<b>3 căn gợi ý</b> theo ngân sách bạn chọn.", "<b>Chính sách thanh toán</b> theo tiến độ, hỗ trợ vay ngân hàng.", "<b>Bảng tính dòng tiền cho thuê</b> để bạn tự cân nhắc."],
    })}
${faqSection(`Câu hỏi thường gặp về ${p.name}`, p.faq)}
${gotoSec("Các tòa FPT Plaza khác", plazaTiles(p.slug))}
${band(`Đừng để câu hỏi "giá bao nhiêu?" còn bỏ ngỏ`, H.bandBtn)}`,
  });
}

// --- Đất nền từng phân khu
for (const z of zones) {
  const H = ZONE_HOOK(z);
  const faq = [
    [`Đất phân khu ${z.code} FPT City giá bao nhiêu?`, `Giá đất phân khu ${z.code} thay đổi theo vị trí lô, hướng và mặt tiền đường. Gửi ngân sách để nhận 3 lô phù hợp kèm giá cập nhật.`],
    [`Đất ${z.code} FPT City có sổ đỏ không?`, "Các lô trong khu đô thị FPT City được cấp sổ đỏ từng lô; mỗi lô được kiểm tra pháp lý cụ thể trước khi giao dịch."],
    [`Có thể xem đất ${z.code} thực tế không?`, "Có. Để lại số điện thoại để chuyên viên hẹn lịch dẫn xem đất."],
    [`Lô ${z.code} phù hợp xây nhà ở hay cho thuê?`, `${z.lead} Chuyên viên sẽ tư vấn lô cụ thể theo mục đích của bạn.`],
  ];
  add({
    slug: z.slug, name: "Đất nền " + z.code, title: z.title, description: z.description, keywords: z.keywords,
    body: `
${hero({
      crumbs: `<a href="${BASE}/">Trang chủ</a> › <a href="${link("land")}">Đất nền FPT City</a> › Phân khu ${z.code}`,
      eyebrow: "Đất nền sổ đỏ · FPT City Đà Nẵng", h1: `Đất nền FPT City <span>phân khu ${z.code}</span>`, lead: esc(z.lead), points: z.traits.slice(0, 3),
      cta: H.cta, ghost: H.ghost, ghostHref: "#tong-quan", formTitle: H.title, docs: H.docs, formHtml: form("h", { button: H.btn, budget: BUDGET_LAND }),
      stats: [[z.code, "Phân khu"], ["181+ ha", "Quy mô FPT City"], ["Sổ đỏ", "Pháp lý từng lô"], ["~5'", "Đến biển Non Nước"]],
    })}
<section id="tong-quan"><div class="wrap two">
  <div><p class="eyebrow">Phân khu ${z.code}</p><h2 class="title">Vì sao nhiều người chọn đất FPT City ${z.code}?</h2>
  <ul class="checks">${z.traits.map((t) => `<li>${esc(t)}</li>`).join("")}</ul>
  <a class="btn" href="#dang-ky">${esc(H.cta)}</a></div>
  ${specCard(`Thông tin phân khu ${z.code}`, [["Dự án", "Khu đô thị FPT City Đà Nẵng"], ["Phân khu", z.code], ["Chủ đầu tư", "Công ty CP Đô thị FPT Đà Nẵng"], ["Loại hình", "Đất nền, nhà phố, biệt thự"], ["Pháp lý", "Sổ đỏ từng lô"], ["Giá", "Theo giỏ hàng cập nhật"]], "Đặc điểm lô mang tính tham khảo; chi tiết từng lô có trong giỏ hàng.")}
</div></section>
<section class="tint"><div class="wrap">${head({ eyebrow: "Bạn nên chọn lô thế nào?", title: "3 câu hỏi giúp chọn đúng lô" })}
  <div class="amen">
    <div><h3>1. Xây để ở hay cho thuê?</h3><p>Ở lâu dài thì ưu tiên hướng, lộ giới và vị trí yên tĩnh; cho thuê thì ưu tiên gần Đại học FPT và FPT Complex.</p></div>
    <div><h3>2. Ngân sách bao nhiêu?</h3><p>Gửi ngân sách vào form, chuyên viên lọc sẵn lô vừa tầm giá thay vì bạn phải xem cả giỏ hàng.</p></div>
    <div><h3>3. Cần sổ và xây ngay?</h3><p>Mỗi lô được kiểm tra pháp lý riêng; chuyên viên báo tình trạng sổ và điều kiện xây dựng từng lô.</p></div>
  </div></div></section>
${band(H.band, H.bandBtn)}
${distances()}
${amenities()}
${ctaSection({
      title: `Nhận giỏ hàng đất phân khu ${z.code} theo tầm giá của bạn`, intro: `Giỏ hàng ${z.code} thay đổi liên tục. Đăng ký để nhận:`, formTitle: H.title, formHtml: form("c", { button: H.btn, budget: BUDGET_LAND }),
      steps: [`<b>3 lô gợi ý</b> vừa ngân sách bạn chọn.`, `<b>Bản đồ phân lô</b> phân khu ${z.code}.`, "<b>Pháp lý</b> từng lô.", "<b>Lịch xem đất</b> thực tế cùng chuyên viên."],
    })}
${faqSection(`Hỏi đáp đất FPT City phân khu ${z.code}`, faq)}
${gotoSec("Các phân khu đất nền khác", zoneTiles(z.slug))}
${gotoSec("Căn hộ FPT Plaza trong cùng khu đô thị", plazaTiles(""), "Có thể bạn quan tâm")}
${band(`Lô ${z.code} bạn ưng nằm ở đâu trên bản đồ?`, H.bandBtn)}`,
  });
}

// --- Trang tổng quan: đất nền
{
  const faq = [
    ["Đất nền FPT City có sổ đỏ chưa?", "Phần lớn các lô đất nền tại FPT City có sổ đỏ từng lô. Mỗi lô cần kiểm tra pháp lý cụ thể trước khi giao dịch; chuyên viên gửi kèm thông tin khi tư vấn."],
    ["Giá đất nền FPT City bao nhiêu?", "Giá thay đổi theo phân khu, vị trí, hướng và mặt tiền đường. Gửi ngân sách để nhận giỏ hàng phù hợp, cập nhật theo từng phân khu."],
    ["Phân khu nào phù hợp xây nhà cho thuê?", "Các phân khu gần Đại học FPT và FPT Complex (như V2, V6) có nhu cầu thuê cao từ sinh viên, kỹ sư."],
    ["Ngoài V1–V6, FPT City còn phân khu nào?", "Khu đô thị còn các phân khu khác ngoài V1–V6. Để lại thông tin, chuyên viên gửi bản đồ phân khu và giỏ hàng đầy đủ."],
  ];
  add({
    slug: "land", name: "Đất nền FPT City", tabs: false,
    title: "Đất nền FPT City Đà Nẵng – Bảng giá đất phân khu V1, V2, V3, V4, V5, V6",
    description: "Đất nền FPT City Đà Nẵng: bản đồ phân lô, giỏ hàng và giá đất các phân khu V1, V2, V3, V4, V5, V6. Sổ đỏ từng lô. Gửi ngân sách, nhận 3 lô phù hợp.",
    keywords: "đất nền FPT City, đất FPT Đà Nẵng, giá đất FPT City, bản đồ phân lô FPT City, đất FPT City V1, V2, V3, V4, V5, V6",
    body: `
${hero({
      crumbs: `<a href="${BASE}/">Trang chủ</a> › Đất nền FPT City`, eyebrow: "Đất nền sổ đỏ · FPT City Đà Nẵng", h1: `Đất nền <span>FPT City</span> Đà Nẵng`,
      lead: "Lô đất sổ đỏ trong khu đô thị công nghệ hơn 181 ha, hạ tầng hoàn thiện. Bạn nói ngân sách, chúng tôi lọc sẵn lô phù hợp trong các phân khu V1 – V6.",
      points: ["Sổ đỏ từng lô, hạ tầng hoàn thiện", "Lô ~90 m² đến biệt thự 350+ m²", "Giỏ hàng chính chủ, cập nhật hằng tuần"],
      cta: "Gửi ngân sách, nhận 3 lô phù hợp", ghost: "Xem các phân khu", ghostHref: "#tong-quan", formTitle: "Lô nào vừa ngân sách của bạn?",
      docs: ["🗺️ Bản đồ phân lô V1 – V6", "📄 Lô đang bán & giá từng lô", "📑 Thông tin pháp lý", "🚗 Hẹn lịch xem đất"],
      formHtml: form("h", { button: "Gửi tôi 3 lô phù hợp nhất", budget: BUDGET_LAND }),
      stats: [["181+ ha", "Quy mô FPT City"], ["V1 – V6", "Phân khu đất nền"], ["90–350 m²", "Diện tích lô phổ biến"], ["Sổ đỏ", "Pháp lý từng lô"]],
    })}
<section id="tong-quan"><div class="wrap">${head({ eyebrow: "Các phân khu", title: "Đất nền FPT City theo phân khu", sub: "Mỗi phân khu có vị trí và kích thước lô khác nhau. Chọn phân khu để xem chi tiết." })}${zoneTiles("")}</div></section>
<section class="tint"><div class="wrap">${head({ eyebrow: "So sánh nhanh", title: "Phân khu nào hợp với bạn?" })}
<div class="tbl"><table><thead><tr><th>Phân khu</th><th>Đặc điểm nổi bật</th><th></th></tr></thead><tbody>${zones.map((z) => `<tr><th scope="row">${z.code}</th><td>${esc(z.traits.slice(0, 2).join(" · "))}</td><td><a href="${link(z.slug)}">Xem →</a></td></tr>`).join("")}</tbody></table></div></div></section>
${band("Phân khu nào đang có lô vừa tầm giá của bạn? Gửi ngân sách để biết.", "Nhận giỏ hàng theo ngân sách")}
${distances()}
${amenities()}
${ctaSection({ title: "Nhận giỏ hàng đất nền FPT City theo tầm giá", intro: "Giá đất khác nhau theo từng lô. Đăng ký để nhận:", formTitle: "Lô nào vừa ngân sách của bạn?", formHtml: form("c", { button: "Gửi tôi 3 lô phù hợp nhất", budget: BUDGET_LAND }), steps: ["<b>3 lô gợi ý</b> vừa ngân sách bạn chọn.", "<b>Bản đồ phân lô</b> chi tiết từng phân khu.", "<b>Thông tin pháp lý</b> sổ đỏ từng lô.", "<b>Lịch xem đất</b> cùng chuyên viên."] })}
${faqSection("Hỏi đáp về đất nền FPT City", faq)}
${gotoSec("Căn hộ FPT Plaza trong cùng khu đô thị", plazaTiles(""), "Có thể bạn quan tâm")}
${band("Lô đất ưng ý nằm ở phân khu nào? Hỏi để biết.", "Nhận giỏ hàng ngay")}`,
  });
}

// --- Trang tổng quan: căn hộ
{
  const faq = [
    ["Chuỗi căn hộ FPT Plaza gồm những tòa nào?", "FPT Plaza 1, 2 (đã bàn giao), FPT Plaza 3 (sắp bàn giao), FPT Plaza 4 (đang mở bán) và FPT Plaza 5 (sắp mở bán), đều trong khu đô thị FPT City Đà Nẵng."],
    ["Nên mua căn hộ FPT Plaza nào?", "Cần ở ngay: chọn chuyển nhượng FPT Plaza 1, 2. Muốn nhận nhà sớm: FPT Plaza 3. Muốn thanh toán giãn theo tiến độ: FPT Plaza 4. Muốn biết giá sớm: đăng ký FPT Plaza 5."],
    ["Giá căn hộ FPT Plaza hiện nay thế nào?", "Giá khác nhau theo tòa, tầng, hướng và đợt chính sách. Gửi ngân sách để nhận 3 căn phù hợp kèm giá cập nhật."],
  ];
  add({
    slug: "apt", name: "Căn hộ FPT Plaza", tabs: false,
    title: "Căn hộ FPT Plaza Đà Nẵng – So sánh FPT Plaza 1, 2, 3, 4, 5 | Bảng giá",
    description: "So sánh căn hộ FPT Plaza 1, 2, 3, 4, 5 tại FPT City Đà Nẵng: quy mô, số căn, tình trạng, tiến độ. Gửi ngân sách, nhận 3 căn phù hợp kèm bảng giá.",
    keywords: "căn hộ FPT Plaza, chung cư FPT Đà Nẵng, FPT Plaza 1, FPT Plaza 2, FPT Plaza 3, FPT Plaza 4, FPT Plaza 5, giá căn hộ FPT Plaza",
    body: `
${hero({
      crumbs: `<a href="${BASE}/">Trang chủ</a> › Căn hộ FPT Plaza`, eyebrow: "Chuỗi căn hộ FPT City Đà Nẵng", h1: `Căn hộ <span>FPT Plaza</span> Đà Nẵng`,
      lead: "Từ căn đã bàn giao đến dự án sắp mở bán: tòa nào hợp với bạn? Nói ngân sách, chúng tôi gợi ý 3 căn phù hợp nhất trong cả 5 tòa.",
      points: ["5 tòa căn hộ trong cùng khu đô thị FPT City", "Căn 1PN – 3PN và căn Duplex diện tích lớn", "Sơ cấp từ chủ đầu tư & chuyển nhượng"],
      cta: "Tòa nào hợp ngân sách của tôi?", ghost: "So sánh 5 tòa", ghostHref: "#tong-quan", formTitle: "Gửi ngân sách, nhận 3 căn gợi ý",
      docs: ["💰 Bảng giá từng tòa", "📐 Mặt bằng & layout căn hộ", "🔄 Giỏ hàng chuyển nhượng", "🏦 Phương án vay ngân hàng"],
      formHtml: form("h", { button: "Gửi tôi 3 căn phù hợp nhất", budget: BUDGET_APT }),
      stats: [["5", "Tòa FPT Plaza"], ["2", "Tòa đã bàn giao"], ["1.395", "Căn tại FPT Plaza 4"], ["181+ ha", "Khu đô thị FPT City"]],
    })}
<section id="tong-quan"><div class="wrap">${head({ eyebrow: "So sánh", title: "So sánh nhanh FPT Plaza 1, 2, 3, 4, 5" })}${COMPARE("")}
<p class="small" style="margin-top:10px">Số liệu tổng hợp, mang tính tham khảo; FPT Plaza 5 là số liệu dự kiến.</p></div></section>
${gotoSec("Xem chi tiết từng tòa", plazaTiles(""), "Chọn tòa")}
${band("Một câu hỏi: ngân sách của bạn đang nằm ở tòa nào?", "Nhận 3 căn gợi ý")}
${distances()}
${amenities()}
${ctaSection({ title: "Nhận bảng giá căn hộ FPT Plaza theo ngân sách", intro: "Để lại thông tin để nhận:", formTitle: "Gửi ngân sách, nhận 3 căn gợi ý", formHtml: form("c", { button: "Gửi tôi 3 căn phù hợp nhất", budget: BUDGET_APT }), steps: ["<b>3 căn gợi ý</b> theo ngân sách bạn chọn.", "<b>Bảng giá</b> FPT Plaza 3, 4 và giỏ hàng chuyển nhượng Plaza 1, 2.", "<b>Mặt bằng</b> tầng điển hình & layout căn hộ.", "<b>Thông tin FPT Plaza 5</b> ngay khi có."] })}
${faqSection("Hỏi đáp về căn hộ FPT Plaza", faq)}
${band("Đã đến lúc biết căn nào phù hợp với bạn.", "Nhận 3 căn gợi ý")}`,
  });
}

// --- Trang chủ
{
  const faq = [
    ["Khu đô thị FPT City Đà Nẵng rộng bao nhiêu?", "FPT City Đà Nẵng có tổng diện tích hơn 181 ha phía Nam thành phố, tổng vốn đầu tư dự kiến khoảng 952 triệu USD."],
    ["Chủ đầu tư FPT City là ai?", investor + "."],
    ["FPT City có những sản phẩm nào?", "Đất nền theo các phân khu V1 – V6, nhà phố, biệt thự và chuỗi căn hộ FPT Plaza 1, 2, 3, 4, 5."],
    ["Nên mua đất nền hay căn hộ FPT Plaza?", "Đất nền phù hợp nhu cầu xây nhà riêng, tích lũy dài hạn; căn hộ có tổng tiền thấp hơn, tiện ích sẵn, dễ cho thuê. Gửi ngân sách để được gợi ý theo nhu cầu."],
  ];
  add({
    slug: "home", name: "FPT City Đà Nẵng – Trang chủ", tabs: false,
    title: "FPT City Đà Nẵng – Đất nền & căn hộ FPT Plaza 1, 2, 3, 4, 5 | Bảng giá 2026",
    description: "Khu đô thị FPT City Đà Nẵng 181 ha: đất nền phân khu V1–V6, căn hộ FPT Plaza 1, 2, 3, 4, 5. Gửi ngân sách, nhận 3 gợi ý phù hợp kèm bảng giá và mặt bằng.",
    keywords: "FPT City Đà Nẵng, đất nền FPT City, căn hộ FPT Plaza, FPT Plaza 1, FPT Plaza 2, FPT Plaza 3, FPT Plaza 4, FPT Plaza 5, đất FPT Đà Nẵng, giá đất FPT City",
    body: `
${hero({
      eyebrow: "Khu đô thị công nghệ phía Nam Đà Nẵng", h1: `<span>FPT City</span> Đà Nẵng`,
      lead: "Khu đô thị hơn 181 ha của Tập đoàn FPT: Đại học FPT, FPT Complex, đất nền sổ đỏ và chuỗi căn hộ FPT Plaza. Ngân sách của bạn đang hợp với sản phẩm nào?",
      points: ["Chủ đầu tư: Công ty CP Đô thị FPT Đà Nẵng", "Đất nền V1–V6 · Căn hộ FPT Plaza 1–5", "Giỏ hàng & giá cập nhật hằng tuần"],
      cta: "Tìm sản phẩm hợp ngân sách của tôi", ghost: "Khám phá dự án", ghostHref: "#san-pham", formTitle: "Ngân sách của bạn hợp với sản phẩm nào?",
      docs: ["🗺️ Bản đồ phân lô đất nền V1–V6", "💰 Bảng giá căn hộ FPT Plaza 1–5", "📐 Mặt bằng & layout căn hộ", "🏦 Chính sách, hỗ trợ vay"],
      formHtml: form("h", { button: "Gửi tôi 3 gợi ý phù hợp nhất", budget: ["Dưới 2 tỷ", "2 – 4 tỷ", "4 – 6 tỷ", "6 – 10 tỷ", "Trên 10 tỷ"] }),
      stats: [["181+ ha", "Quy mô khu đô thị"], ["~952 tr USD", "Tổng vốn đầu tư dự kiến"], ["5", "Tòa căn hộ FPT Plaza"], ["~5'", "Đến biển Non Nước"]],
    })}
<section id="tong-quan"><div class="wrap two">
  <div><p class="eyebrow">Tổng quan</p><h2 class="title">Đô thị công nghệ FPT City: sống, học tập và làm việc trong một</h2>
  <p><b>FPT City Đà Nẵng</b> được quy hoạch đồng bộ với khuôn viên Đại học FPT, khu công viên phần mềm, khu nhà ở, hạ tầng, cây xanh và dịch vụ công cộng. Hàng nghìn kỹ sư và sinh viên tạo nhu cầu ở và thuê lớn quanh năm.</p>
  <p>Hai dòng sản phẩm chính: <a href="${link("land")}">đất nền FPT City</a> theo phân khu V1 – V6 và chuỗi <a href="${link("apt")}">căn hộ FPT Plaza</a> từ Plaza 1 đến Plaza 5.</p></div>
  ${specCard("Thông tin khu đô thị", [["Tên dự án", "Khu đô thị FPT City Đà Nẵng"], ["Chủ đầu tư", investor], ["Quy mô", "Hơn 181 ha"], ["Vốn đầu tư", "Khoảng 952 triệu USD (dự kiến)"], ["Vị trí", "Phía Nam TP. Đà Nẵng"], ["Sản phẩm", "Đất nền, nhà phố, biệt thự, căn hộ FPT Plaza"]])}
</div></section>
<section id="san-pham" class="dark"><div class="wrap"><div style="text-align:center;margin-bottom:28px"><p class="eyebrow">Sản phẩm</p><h2 class="title">Bạn đang tìm nhà để ở hay lô đất để xây?</h2></div>
  <div class="grid2">
    <a class="tile" href="${link("land")}"><span class="pill">V1 · V2 · V3 · V4 · V5 · V6</span><h3>Đất nền FPT City</h3><p>Lô đất sổ đỏ để xây nhà ở, biệt thự, nhà cho thuê. Gửi ngân sách, nhận 3 lô phù hợp.</p><span class="go">Xem đất nền →</span></a>
    <a class="tile" href="${link("apt")}"><span class="pill">Plaza 1 · 2 · 3 · 4 · 5</span><h3>Căn hộ FPT Plaza</h3><p>Từ căn đã bàn giao đến dự án sắp mở bán. Tòa nào hợp với ngân sách của bạn?</p><span class="go">Xem căn hộ →</span></a>
  </div></div></section>
${gotoSec("Chuỗi căn hộ FPT Plaza 1 – 5", plazaTiles(""), "Căn hộ")}
${gotoSec("Đất nền theo phân khu V1 – V6", zoneTiles(""), "Đất nền")}
${band("Bạn đã biết ngân sách của mình mua được gì ở FPT City chưa?", "Nhận 3 gợi ý phù hợp")}
${distances()}
${amenities()}
${ctaSection({ title: "Nhận bảng giá FPT City: đất nền & căn hộ trong một lần", intro: "Để lại thông tin, bạn nhận được:", formTitle: "Ngân sách của bạn hợp với sản phẩm nào?", formHtml: form("c", { button: "Gửi tôi 3 gợi ý phù hợp nhất", budget: ["Dưới 2 tỷ", "2 – 4 tỷ", "4 – 6 tỷ", "6 – 10 tỷ", "Trên 10 tỷ"] }), steps: ["<b>3 gợi ý</b> theo ngân sách (đất nền hoặc căn hộ).", "<b>Bản đồ phân lô</b> V1 – V6 và giỏ hàng đất nền.", "<b>Bảng giá & mặt bằng</b> căn hộ FPT Plaza 1 – 5.", "<b>Chính sách</b> thanh toán, hỗ trợ vay ngân hàng."] })}
${faqSection("Câu hỏi thường gặp về FPT City Đà Nẵng", faq)}
${band("Một phút để biết FPT City có gì phù hợp với bạn.", "Nhận 3 gợi ý phù hợp")}`,
  });
}

/* ---------- Ghi file + manifest ---------- */
mkdirSync(OUT, { recursive: true });
const manifest = pages.map((p) => ({ slug: p.slug, name: p.name, path: pathOf(p.slug), file: `${p.slug}.html`, title: p.title }));
for (const p of pages) writeFileSync(join(OUT, `${p.slug}.html`), page(p));
writeFileSync(join(OUT, "manifest.json"), JSON.stringify(manifest, null, 2) + "\n");
console.log(`Đã dựng ${pages.length} trang LadiPage vào ladipage/`);
