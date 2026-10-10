// Sinh các trang HTML tĩnh vào public/. Chạy: node src/build.mjs
import { mkdirSync, writeFileSync } from "node:fs";
import { dirname, join } from "node:path";
import { fileURLToPath } from "node:url";
import { site, investor, plazas, zones } from "./data.mjs";

const OUT = join(dirname(fileURLToPath(import.meta.url)), "..", "public");
const esc = (s = "") => String(s).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;");
const url = (path) => site.domain + "/" + path;
const pages = [];

/* ================= PARTIALS ================= */

const nav = () => `
  <header class="site-header" id="top">
    <div class="container nav">
      <a href="/" class="brand" aria-label="${site.name} – trang chủ">
        <svg width="34" height="34" viewBox="0 0 40 40" aria-hidden="true"><rect width="40" height="40" rx="10" fill="currentColor"/><path d="M11 29V15l9-5 9 5v14h-6v-8h-6v8z" fill="#f5c26b"/></svg>
        <span><strong>FPT City</strong><small>Đà Nẵng</small></span>
      </a>
      <button class="nav-toggle" aria-expanded="false" aria-controls="menu" aria-label="Mở menu"><span></span><span></span><span></span></button>
      <nav id="menu" class="menu" aria-label="Menu chính">
        <a href="/">Trang chủ</a>
        <div class="dropdown">
          <a href="/dat-nen-fpt-city/" class="dd-toggle">Đất nền</a>
          <div class="dd-menu">
            <a href="/dat-nen-fpt-city/">Tổng quan đất nền FPT City</a>
            ${zones.map((z) => `<a href="/dat-nen-fpt-city/${z.slug}/">Phân khu ${z.code}</a>`).join("")}
          </div>
        </div>
        <div class="dropdown">
          <a href="/can-ho-fpt-plaza/" class="dd-toggle">Căn hộ FPT Plaza</a>
          <div class="dd-menu">
            <a href="/can-ho-fpt-plaza/">Tổng quan căn hộ FPT Plaza</a>
            ${plazas.map((p) => `<a href="/${p.slug}/">${p.name} <em>${esc(p.statusLabel.split(" · ")[0])}</em></a>`).join("")}
          </div>
        </div>
        <a href="/#tien-ich">Tiện ích</a>
        <a href="#dang-ky" class="btn btn-gold btn-sm" data-open-form>Nhận bảng giá</a>
      </nav>
    </div>
  </header>`;

const heroBg = () => `
      <div class="hero-bg" aria-hidden="true">
        <svg viewBox="0 0 1440 700" preserveAspectRatio="xMidYMax slice">
          <defs>
            <linearGradient id="sky" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#06281e"/><stop offset=".6" stop-color="#0d4a37"/><stop offset="1" stop-color="#1a6b52"/></linearGradient>
            <linearGradient id="tw" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#e9f3ef" stop-opacity=".95"/><stop offset="1" stop-color="#9cc7b7" stop-opacity=".75"/></linearGradient>
            <linearGradient id="sea" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#2e8a8f"/><stop offset="1" stop-color="#0b3d2e"/></linearGradient>
            <pattern id="win" width="20" height="30" patternUnits="userSpaceOnUse"><rect width="14" height="6" x="3" y="12" fill="#0d4a37" opacity=".35"/></pattern>
          </defs>
          <rect width="1440" height="700" fill="url(#sky)"/>
          <circle cx="1180" cy="170" r="70" fill="#f5c26b" opacity=".85"/>
          <g fill="url(#tw)" opacity=".35"><rect x="80" y="330" width="90" height="300"/><rect x="190" y="280" width="70" height="350"/><rect x="1240" y="310" width="100" height="320"/><rect x="1350" y="360" width="70" height="270"/></g>
          <g fill="url(#tw)"><rect x="760" y="150" width="150" height="480" rx="4"/><rect x="930" y="210" width="130" height="420" rx="4"/><rect x="620" y="250" width="120" height="380" rx="4"/></g>
          <g fill="url(#win)"><rect x="770" y="160" width="130" height="440"/><rect x="940" y="220" width="110" height="380"/><rect x="630" y="260" width="100" height="340"/></g>
          <path d="M0 610 C 240 580 480 640 720 615 S 1200 585 1440 610 V700 H0z" fill="url(#sea)"/>
          <g fill="#2f7d5d"><circle cx="560" cy="615" r="28"/><circle cx="1110" cy="612" r="34"/><circle cx="300" cy="620" r="24"/></g>
        </svg>
      </div>`;

const leadForm = (source, { email = false, needs = ["Mua để ở", "Đầu tư cho thuê", "Tìm hiểu thêm"], button = "Gửi tôi link tài liệu ngay", dark = false } = {}) => `
          <form class="lead-form" novalidate data-source="${source}">
            <label class="field"><span>Họ và tên *</span><input name="name" autocomplete="name" required placeholder="Nguyễn Văn A"></label>
            <label class="field"><span>Số điện thoại / Zalo *</span><input name="phone" type="tel" inputmode="tel" autocomplete="tel" required placeholder="09xx xxx xxx"></label>
            ${email ? `<label class="field"><span>Email (nhận link tài liệu)</span><input name="email" type="email" autocomplete="email" placeholder="ban@email.com"></label>` : ""}
            <label class="field"><span>Nhu cầu</span><select name="need">${needs.map((n) => `<option>${esc(n)}</option>`).join("")}</select></label>
            <input type="text" name="website" class="hp" tabindex="-1" autocomplete="off" aria-hidden="true">
            <button type="submit" class="btn btn-gold btn-block${dark ? " btn-lg" : ""}">${esc(button)}</button>
            <p class="form-note">🔒 Bảo mật thông tin · Link Google Drive hiển thị ngay sau khi gửi</p>
          </form>`;

const hero = ({ eyebrow, h1, lead, points, cta, formTitle, docs, badge = "Đang nhận đăng ký", needs, stats }) => `
    <section class="hero">${heroBg()}
      <div class="container hero-grid">
        <div class="hero-copy reveal">
          <p class="eyebrow">${eyebrow}</p>
          <h1>${h1}</h1>
          <p class="lead">${lead}</p>
          <ul class="hero-points">${points.map((p) => `<li>${p}</li>`).join("")}</ul>
          <div class="hero-cta">
            <a href="#dang-ky" class="btn btn-gold btn-lg" data-open-form>
              <svg width="20" height="20" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M12 16l-5-5h3V4h4v7h3zm-7 2h14v2H5z"/></svg>
              ${esc(cta)}
            </a>
            <a href="#tong-quan" class="btn btn-ghost btn-lg">Xem thông tin</a>
          </div>
          <p class="micro">🔒 Miễn phí · Gửi link Google Drive ngay sau khi đăng ký · Không spam</p>
        </div>
        <aside class="hero-card reveal" aria-labelledby="hero-form-title">
          <div class="badge-hot">${esc(badge)}</div>
          <h2 id="hero-form-title">${esc(formTitle)}</h2>
          <ul class="doc-list">${docs.map((d) => `<li>${d}</li>`).join("")}</ul>
          ${leadForm("hero", { needs })}
        </aside>
      </div>
      ${stats ? `<div class="container stats reveal">${stats.map(([b, s]) => `<div><b>${b}</b><span>${s}</span></div>`).join("")}</div>` : ""}
    </section>`;

const breadcrumbs = (items) => `
    <nav class="breadcrumbs container" aria-label="Breadcrumb">
      ${items.map(([name, path], i) => (i < items.length - 1 ? `<a href="/${path}">${esc(name)}</a><span>›</span>` : `<span aria-current="page">${esc(name)}</span>`)).join("")}
    </nav>`;

const specCard = (title, specs, note) => `
        <div class="spec-card reveal">
          <h3>${esc(title)}</h3>
          <dl class="spec">${specs.map(([k, v]) => `<div><dt>${esc(k)}</dt><dd>${esc(v)}</dd></div>`).join("")}</dl>
          ${note ? `<p class="footnote">${esc(note)}</p>` : ""}
        </div>`;

const location = (heading = "Kết nối trọn vẹn phía Nam Đà Nẵng – giữa sông, biển và trung tâm") => `
    <section id="vi-tri" class="section section-tint">
      <div class="container">
        <div class="section-head reveal">
          <p class="eyebrow dark">Vị trí</p>
          <h2 class="title">${heading}</h2>
          <p>Khu đô thị FPT City nằm phía Nam Đà Nẵng, hạ tầng đồng bộ, kết nối nhanh về trung tâm thành phố, sân bay, dải biển Non Nước và phố cổ Hội An.</p>
        </div>
        <div class="two-col align-center">
          <div class="map-wrap reveal">
            <iframe title="Bản đồ khu đô thị FPT City Đà Nẵng" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps?q=FPT+City+Da+Nang&amp;output=embed"></iframe>
          </div>
          <ul class="distance reveal">
            <li><span>Đại học FPT &amp; FPT Complex</span><b>Trong khu đô thị</b></li>
            <li><span>Biển Tân Trà – Non Nước</span><b>~5 phút</b></li>
            <li><span>Danh thắng Ngũ Hành Sơn</span><b>~10 phút</b></li>
            <li><span>Trung tâm TP. Đà Nẵng</span><b>~15–20 phút</b></li>
            <li><span>Sân bay quốc tế Đà Nẵng</span><b>~20 phút</b></li>
            <li><span>Phố cổ Hội An</span><b>~20 phút</b></li>
          </ul>
        </div>
        <p class="footnote center">Thời gian di chuyển ước tính bằng ô tô, tham khảo.</p>
      </div>
    </section>`;

const amenities = () => `
    <section id="tien-ich" class="section">
      <div class="container">
        <div class="section-head reveal">
          <p class="eyebrow dark">Tiện ích FPT City</p>
          <h2 class="title">Hệ sinh thái sống – học – làm việc chuẩn đô thị công nghệ</h2>
        </div>
        <div class="grid-cards">
          <article class="card reveal"><div class="ico">🎓</div><h3>Giáo dục liên cấp</h3><p>Hệ thống trường FPT từ phổ thông đến Đại học FPT ngay trong khu đô thị.</p></article>
          <article class="card reveal"><div class="ico">🏢</div><h3>FPT Complex</h3><p>Tổ hợp văn phòng công nghệ quy tụ hàng nghìn kỹ sư – nguồn khách thuê ổn định.</p></article>
          <article class="card reveal"><div class="ico">🌳</div><h3>Công viên &amp; mảng xanh</h3><p>Cây xanh, kênh sinh thái, đường dạo bộ và sân thể thao ngoài trời.</p></article>
          <article class="card reveal"><div class="ico">🏊</div><h3>Tiện ích nội khu</h3><p>Hồ bơi, phòng gym, khu vui chơi trẻ em tại các tòa FPT Plaza.</p></article>
          <article class="card reveal"><div class="ico">🛒</div><h3>Thương mại – dịch vụ</h3><p>Shophouse, siêu thị, cà phê, nhà hàng phục vụ nhu cầu hằng ngày.</p></article>
          <article class="card reveal"><div class="ico">🛡️</div><h3>Đô thị thông minh</h3><p>Định hướng vận hành công nghệ của Tập đoàn FPT.</p></article>
        </div>
      </div>
    </section>`;

const ctaSection = ({ heading, intro, steps, formTitle, needs }) => `
    <section id="chinh-sach" class="section">
      <div class="container two-col align-center">
        <div class="reveal">
          <p class="eyebrow dark">Tài liệu &amp; chính sách</p>
          <h2 class="title">${heading}</h2>
          <p>${intro}</p>
          <ol class="steps">${steps.map((s) => `<li>${s}</li>`).join("")}</ol>
        </div>
        <div class="cta-box reveal" id="dang-ky">
          <p class="countdown-label" data-countdown-label hidden>Ưu đãi đăng ký sớm còn</p>
          <div class="countdown" data-countdown hidden aria-live="polite">
            <div><b data-d>00</b><span>Ngày</span></div><div><b data-h>00</b><span>Giờ</span></div><div><b data-m>00</b><span>Phút</span></div><div><b data-s>00</b><span>Giây</span></div>
          </div>
          <h3>${esc(formTitle)}</h3>
          ${leadForm("cta", { email: true, needs, button: "Nhận link Google Drive", dark: true })}
        </div>
      </div>
    </section>`;

const faqSection = (title, faq) => `
    <section id="faq" class="section section-tint">
      <div class="container narrow">
        <div class="section-head reveal">
          <p class="eyebrow dark">Hỏi đáp</p>
          <h2 class="title">${esc(title)}</h2>
        </div>
        <div class="faq">${faq.map(([q, a], i) => `<details class="reveal"${i === 0 ? " open" : ""}><summary>${esc(q)}</summary><p>${esc(a)}</p></details>`).join("")}</div>
      </div>
    </section>`;

const plazaCards = (exclude) => `
        <div class="grid-projects">
          ${plazas.filter((p) => p.slug !== exclude).map((p) => `
          <a class="project reveal" href="/${p.slug}/">
            <span class="status status-${p.status}">${esc(p.statusLabel)}</span>
            <h3>${p.name}</h3>
            <p>${esc(p.specs.slice(0, 2).map((s) => s[1]).join(" · "))}</p>
            <span class="more">Xem chi tiết →</span>
          </a>`).join("")}
        </div>`;

const zoneCards = (exclude) => `
        <div class="grid-projects zones">
          ${zones.filter((z) => z.slug !== exclude).map((z) => `
          <a class="project reveal" href="/dat-nen-fpt-city/${z.slug}/">
            <span class="zone-code">${z.code}</span>
            <h3>Phân khu ${z.code}</h3>
            <p>${esc(z.traits[0])}</p>
            <span class="more">Xem giỏ hàng →</span>
          </a>`).join("")}
        </div>`;

const related = (heading, inner) => `
    <section class="section">
      <div class="container">
        <div class="section-head reveal"><p class="eyebrow dark">Khám phá thêm</p><h2 class="title">${heading}</h2></div>
        ${inner}
      </div>
    </section>`;

const finalCta = (h, p, btn) => `
    <section class="final-cta">
      <div class="container final-inner reveal">
        <div><h2>${h}</h2><p>${p}</p></div>
        <a href="#dang-ky" class="btn btn-gold btn-lg" data-open-form>${esc(btn)}</a>
      </div>
    </section>`;

const footer = () => `
  <footer class="site-footer">
    <div class="container footer-grid">
      <div>
        <p class="brand-foot">${site.name}</p>
        <p>Trang thông tin &amp; tư vấn bất động sản khu đô thị FPT City Đà Nẵng: đất nền và căn hộ FPT Plaza.</p>
        <p class="disclaimer">Thông tin, hình ảnh minh họa và số liệu mang tính tham khảo, có thể thay đổi theo công bố chính thức của chủ đầu tư. Website do đơn vị tư vấn – phân phối vận hành, không phải trang chính thức của Tập đoàn FPT.</p>
      </div>
      <div>
        <p class="foot-title">Đất nền FPT City</p>
        <ul class="foot-links"><li><a href="/dat-nen-fpt-city/">Tổng quan đất nền</a></li>${zones.map((z) => `<li><a href="/dat-nen-fpt-city/${z.slug}/">Phân khu ${z.code}</a></li>`).join("")}</ul>
      </div>
      <div>
        <p class="foot-title">Căn hộ FPT Plaza</p>
        <ul class="foot-links"><li><a href="/can-ho-fpt-plaza/">Tổng quan căn hộ</a></li>${plazas.map((p) => `<li><a href="/${p.slug}/">${p.name}</a></li>`).join("")}</ul>
      </div>
      <div>
        <p class="foot-title">Liên hệ tư vấn</p>
        <p>Hotline: <a href="tel:" data-hotline-link><span data-hotline></span></a></p>
        <p>Zalo: <a href="#" data-zalo-link target="_blank" rel="noopener">Chat ngay</a></p>
        <p>Email: <a href="mailto:" data-email-link><span data-email></span></a></p>
      </div>
    </div>
    <p class="copy">© <span data-year></span> fpt-city.com</p>
  </footer>
  <div class="floating">
    <a href="tel:" class="fab fab-call" data-hotline-link aria-label="Gọi hotline">📞</a>
    <a href="#" class="fab fab-zalo" data-zalo-link target="_blank" rel="noopener" aria-label="Chat Zalo">Zalo</a>
  </div>
  <div class="mobile-bar">
    <a href="tel:" data-hotline-link>📞 Gọi ngay</a>
    <button data-open-form>📥 Nhận bảng giá</button>
  </div>`;

const modal = (title, needs) => `
  <dialog class="modal" id="lead-modal" aria-labelledby="modal-title">
    <button class="modal-close" aria-label="Đóng" data-close>×</button>
    <div class="modal-body">
      <p class="eyebrow dark">Miễn phí · Gửi ngay</p>
      <h2 id="modal-title">${esc(title)}</h2>
      <p class="muted">Bảng giá · Mặt bằng · Brochure · Chính sách – qua link Google Drive.</p>
      ${leadForm("popup", { needs, button: "Gửi tôi link tài liệu" })}
    </div>
    <div class="modal-success" hidden>
      <div class="check">✓</div>
      <h2>Cảm ơn <span data-success-name></span>!</h2>
      <p>Tài liệu đã sẵn sàng. Chuyên viên sẽ liên hệ trong ít phút để gửi bảng giá mới nhất.</p>
      <a class="btn btn-gold btn-lg btn-block" data-drive-link target="_blank" rel="noopener">📂 Mở thư mục Google Drive</a>
      <p class="muted small">Bạn có thể mở lại link này bất cứ lúc nào trên trang.</p>
    </div>
  </dialog>`;

function layout({ path, title, description, keywords, project, drive, crumbs, schema = [], body, modalTitle, needs }) {
  const canonical = url(path);
  const graph = [
    { "@type": "WebSite", "@id": site.domain + "/#website", url: site.domain + "/", name: site.name, inLanguage: "vi-VN" },
    ...(crumbs ? [{ "@type": "BreadcrumbList", itemListElement: crumbs.map(([name, p], i) => ({ "@type": "ListItem", position: i + 1, name, item: url(p) })) }] : []),
    ...schema,
  ];
  pages.push(path);
  return `<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>${esc(title)}</title>
  <meta name="description" content="${esc(description)}">
  <meta name="keywords" content="${esc(keywords)}">
  <meta name="robots" content="index, follow, max-image-preview:large">
  <link rel="canonical" href="${canonical}">
  <meta name="theme-color" content="#0b3d2e">
  <meta property="og:type" content="website">
  <meta property="og:locale" content="vi_VN">
  <meta property="og:site_name" content="${site.name}">
  <meta property="og:title" content="${esc(title)}">
  <meta property="og:description" content="${esc(description)}">
  <meta property="og:url" content="${canonical}">
  <meta property="og:image" content="${site.domain}/assets/img/og-cover.png">
  <meta name="twitter:card" content="summary_large_image">
  <link rel="icon" href="/assets/img/favicon.svg" type="image/svg+xml">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/style.css">
  <script type="application/ld+json">${JSON.stringify({ "@context": "https://schema.org", "@graph": graph })}</script>
</head>
<body data-project="${esc(project)}" data-drive="${esc(drive || site.drive)}">
  <a class="skip-link" href="#main">Bỏ qua tới nội dung</a>
${nav()}
  <main id="main">
${body}
  </main>
${footer()}
${modal(modalTitle, needs)}
  <script src="/assets/js/main.js" defer></script>
</body>
</html>
`;
}

const faqSchema = (faq) => ({ "@type": "FAQPage", mainEntity: faq.map(([q, a]) => ({ "@type": "Question", name: q, acceptedAnswer: { "@type": "Answer", text: a } })) });
const placeSchema = (name, description, path) => ({
  "@type": "Place", "@id": url(path) + "#place", name, description,
  address: { "@type": "PostalAddress", streetAddress: "Khu đô thị FPT City", addressLocality: "Ngũ Hành Sơn", addressRegion: "Đà Nẵng", addressCountry: "VN" },
});

function write(path, html) {
  const file = join(OUT, path, "index.html");
  mkdirSync(dirname(file), { recursive: true });
  writeFileSync(file, html);
}

/* ================= PAGES ================= */

// ---- Trang chủ ----
{
  const faq = [
    ["Khu đô thị FPT City Đà Nẵng rộng bao nhiêu?", "FPT City Đà Nẵng có tổng diện tích hơn 181 ha phía Nam thành phố, tổng vốn đầu tư dự kiến khoảng 952 triệu USD."],
    ["Chủ đầu tư FPT City là ai?", investor + "."],
    ["FPT City có những sản phẩm nào?", "Đất nền theo các phân khu V1, V2, V3, V4, V5, V6…, nhà phố, biệt thự và chuỗi căn hộ FPT Plaza 1, 2, 3, 4, 5."],
    ["Nên mua đất nền hay căn hộ FPT Plaza?", "Đất nền phù hợp nhu cầu xây nhà riêng, tích lũy dài hạn; căn hộ FPT Plaza có tổng tiền thấp hơn, tiện ích sẵn, dễ cho thuê. Để lại thông tin để được tư vấn theo ngân sách."],
  ];
  write("", layout({
    path: "",
    title: "FPT City Đà Nẵng – Đất nền & căn hộ FPT Plaza 1, 2, 3, 4, 5 | Bảng giá 2026",
    description: "Thông tin khu đô thị FPT City Đà Nẵng 181 ha: đất nền phân khu V1–V6, căn hộ FPT Plaza 1, 2, 3, 4, 5. Nhận bảng giá, bản đồ phân lô, mặt bằng căn hộ qua link Google Drive.",
    keywords: "FPT City Đà Nẵng, đất nền FPT City, căn hộ FPT Plaza, FPT Plaza 1, FPT Plaza 2, FPT Plaza 3, FPT Plaza 4, FPT Plaza 5, đất FPT Đà Nẵng, giá đất FPT City",
    project: "FPT City",
    modalTitle: "Nhận trọn bộ tài liệu FPT City",
    needs: ["Đất nền FPT City", "Căn hộ FPT Plaza", "Tư vấn theo ngân sách"],
    schema: [placeSchema("Khu đô thị FPT City Đà Nẵng", "Khu đô thị công nghệ hơn 181 ha phía Nam Đà Nẵng do " + investor + " phát triển.", ""), faqSchema(faq)],
    body: `${hero({
      eyebrow: "Khu đô thị công nghệ phía Nam Đà Nẵng",
      h1: `<span class="accent">FPT City</span> Đà Nẵng`,
      lead: "Khu đô thị hơn 181 ha của Tập đoàn FPT – nơi hội tụ Đại học FPT, FPT Complex, đất nền sổ đỏ và chuỗi căn hộ FPT Plaza. Nhận <strong>bảng giá, bản đồ phân lô &amp; mặt bằng căn hộ</strong> mới nhất.",
      points: ["Chủ đầu tư: Công ty CP Đô thị FPT Đà Nẵng", "Đất nền phân khu V1 – V6 · Căn hộ FPT Plaza 1 – 5", "Cập nhật giỏ hàng & giá hằng tuần"],
      cta: "Tải trọn bộ tài liệu FPT City",
      formTitle: "Nhận tài liệu FPT City",
      docs: ["🗺️ Bản đồ phân lô đất nền V1 – V6", "📄 Bảng giá căn hộ FPT Plaza 1 – 5", "📐 Mặt bằng & layout căn hộ", "🎁 Chính sách, ưu đãi, hỗ trợ vay"],
      needs: ["Đất nền FPT City", "Căn hộ FPT Plaza", "Tư vấn theo ngân sách"],
      stats: [["181+ ha", "Quy mô khu đô thị"], ["~952 tr USD", "Tổng vốn đầu tư dự kiến"], ["5", "Tòa căn hộ FPT Plaza"], ["~5'", "Đến biển Non Nước"]],
    })}
    <section id="tong-quan" class="section">
      <div class="container two-col">
        <div class="reveal">
          <p class="eyebrow dark">Tổng quan</p>
          <h2 class="title">Đô thị công nghệ FPT City – sống, học tập và làm việc trong một</h2>
          <p><strong>FPT City Đà Nẵng</strong> được quy hoạch đồng bộ với khuôn viên Đại học FPT, khu công viên phần mềm, khu nhà ở và hệ thống hạ tầng, cây xanh, dịch vụ công cộng. Cộng đồng cư dân trẻ, trí thức cùng hàng nghìn kỹ sư, sinh viên tạo nhu cầu ở và thuê lớn quanh năm.</p>
          <p>Hai dòng sản phẩm chính: <a href="/dat-nen-fpt-city/">đất nền FPT City</a> theo các phân khu V1 – V6 và chuỗi <a href="/can-ho-fpt-plaza/">căn hộ FPT Plaza</a> từ Plaza 1 đến Plaza 5.</p>
        </div>
        ${specCard("Thông tin khu đô thị", [["Tên dự án", "Khu đô thị FPT City Đà Nẵng"], ["Chủ đầu tư", investor], ["Quy mô", "Hơn 181 ha"], ["Vốn đầu tư", "Khoảng 952 triệu USD (dự kiến)"], ["Vị trí", "Phía Nam TP. Đà Nẵng (khu Ngũ Hành Sơn cũ)"], ["Sản phẩm", "Đất nền, nhà phố, biệt thự, căn hộ FPT Plaza"]])}
      </div>
    </section>
    <section class="section section-dark">
      <div class="container">
        <div class="section-head reveal"><p class="eyebrow">Sản phẩm</p><h2 class="title light">Chọn dòng sản phẩm phù hợp với bạn</h2></div>
        <div class="grid-split">
          <a class="split reveal" href="/dat-nen-fpt-city/">
            <span class="split-ico">🗺️</span><h3>Đất nền FPT City</h3>
            <p>Lô đất sổ đỏ trong các phân khu V1, V2, V3, V4, V5, V6 – xây nhà ở, biệt thự, nhà cho thuê.</p>
            <span class="chips">${zones.map((z) => `<em>${z.code}</em>`).join("")}</span>
            <span class="btn btn-gold">Xem đất nền →</span>
          </a>
          <a class="split reveal" href="/can-ho-fpt-plaza/">
            <span class="split-ico">🏙️</span><h3>Căn hộ FPT Plaza</h3>
            <p>Từ căn đã bàn giao (Plaza 1, 2) đến dự án đang mở bán (Plaza 4) và sắp mở bán (Plaza 5).</p>
            <span class="chips">${plazas.map((p) => `<em>${p.name.replace("FPT ", "")}</em>`).join("")}</span>
            <span class="btn btn-gold">Xem căn hộ →</span>
          </a>
        </div>
      </div>
    </section>
    ${related("Chuỗi căn hộ FPT Plaza 1 – 5", plazaCards())}
    ${location()}
    ${amenities()}
    ${ctaSection({
      heading: "Nhận bảng giá FPT City – đất nền &amp; căn hộ trong 1 link",
      intro: "Để lại thông tin, bạn nhận ngay thư mục Google Drive gồm:",
      steps: ["<b>Bản đồ phân lô</b> các phân khu V1 – V6 và giỏ hàng đất nền.", "<b>Bảng giá, mặt bằng</b> căn hộ FPT Plaza 1 – 5.", "<b>Chính sách</b> thanh toán, hỗ trợ vay ngân hàng.", "<b>Tư vấn 1:1</b> chọn sản phẩm theo ngân sách."],
      formTitle: "Nhận tài liệu FPT City",
      needs: ["Đất nền FPT City", "Căn hộ FPT Plaza", "Tư vấn theo ngân sách"],
    })}
    ${faqSection("Câu hỏi thường gặp về FPT City Đà Nẵng", faq)}
    ${finalCta("Sở hữu bất động sản tại đô thị công nghệ FPT City", "Một phút đăng ký – nhận trọn bộ tài liệu qua Google Drive.", "Nhận tài liệu miễn phí")}`,
  }));
}

// ---- Tổng quan đất nền ----
{
  const path = "dat-nen-fpt-city/";
  const crumbs = [["Trang chủ", ""], ["Đất nền FPT City", path]];
  const faq = [
    ["Đất nền FPT City có sổ đỏ chưa?", "Phần lớn các lô đất nền tại FPT City đã có sổ đỏ từng lô. Mỗi lô cần kiểm tra pháp lý cụ thể trước khi giao dịch – chuyên viên sẽ gửi kèm thông tin khi tư vấn."],
    ["Giá đất nền FPT City bao nhiêu?", "Giá thay đổi theo phân khu, vị trí, hướng và mặt tiền đường. Đăng ký để nhận giỏ hàng cập nhật theo từng phân khu V1 – V6."],
    ["Phân khu nào phù hợp xây nhà cho thuê?", "Các phân khu gần Đại học FPT và FPT Complex (như V2, V6) có nhu cầu thuê cao từ sinh viên, kỹ sư."],
  ];
  write(path, layout({
    path, crumbs,
    title: "Đất nền FPT City Đà Nẵng – Bảng giá đất phân khu V1, V2, V3, V4, V5, V6",
    description: "Đất nền FPT City Đà Nẵng: bản đồ phân lô, giỏ hàng & giá đất các phân khu V1, V2, V3, V4, V5, V6. Sổ đỏ từng lô. Nhận bảng giá đất FPT qua link Google Drive.",
    keywords: "đất nền FPT City, đất FPT Đà Nẵng, giá đất FPT City, bản đồ phân lô FPT City, đất FPT City V1, V2, V3, V4, V5, V6",
    project: "Đất nền FPT City",
    modalTitle: "Nhận giỏ hàng đất nền FPT City",
    needs: zones.map((z) => "Phân khu " + z.code).concat("Chưa xác định"),
    schema: [faqSchema(faq)],
    body: `${breadcrumbs(crumbs)}${hero({
      eyebrow: "Đất nền sổ đỏ · FPT City Đà Nẵng",
      h1: `Đất nền <span class="accent">FPT City</span> Đà Nẵng`,
      lead: "Lô đất sổ đỏ trong khu đô thị công nghệ hơn 181 ha, hạ tầng hoàn thiện. Nhận <strong>bản đồ phân lô &amp; giỏ hàng</strong> các phân khu V1 – V6 cập nhật hằng tuần.",
      points: ["Sổ đỏ từng lô, hạ tầng hoàn thiện", "Đa dạng diện tích: ~90 m² đến biệt thự 350+ m²", "Giỏ hàng chính chủ, cập nhật hằng tuần"],
      cta: "Nhận bản đồ phân lô & giỏ hàng",
      formTitle: "Nhận giỏ hàng đất nền FPT City",
      docs: ["🗺️ Bản đồ phân lô V1 – V6", "📄 Giỏ hàng & giá từng lô", "📑 Thông tin pháp lý", "📞 Hỗ trợ xem đất thực tế"],
      needs: zones.map((z) => "Phân khu " + z.code).concat("Chưa xác định"),
    })}
    <section id="tong-quan" class="section">
      <div class="container">
        <div class="section-head reveal"><p class="eyebrow dark">Các phân khu</p><h2 class="title">Đất nền FPT City theo phân khu</h2><p>Mỗi phân khu có đặc điểm vị trí và diện tích lô khác nhau. Chọn phân khu để xem chi tiết và nhận giỏ hàng.</p></div>
        ${zoneCards()}
      </div>
    </section>
    ${location("Đất nền FPT City – vị trí kết nối phía Nam Đà Nẵng")}
    ${ctaSection({
      heading: "Nhận bảng giá đất nền FPT City mới nhất",
      intro: "Giá đất FPT City biến động theo từng lô. Đăng ký để nhận:",
      steps: ["<b>Bản đồ phân lô</b> chi tiết từng phân khu.", "<b>Giỏ hàng</b> lô đang bán, giá và hướng.", "<b>Thông tin pháp lý</b> sổ đỏ từng lô.", "<b>Lịch xem đất</b> thực tế cùng chuyên viên."],
      formTitle: "Nhận giỏ hàng đất nền",
      needs: zones.map((z) => "Phân khu " + z.code).concat("Chưa xác định"),
    })}
    ${faqSection("Hỏi đáp về đất nền FPT City", faq)}
    ${related("Căn hộ FPT Plaza trong cùng khu đô thị", plazaCards())}
    ${finalCta("Chọn được lô đất ưng ý tại FPT City", "Nhận giỏ hàng các phân khu V1 – V6 qua Google Drive.", "Nhận giỏ hàng ngay")}`,
  }));
}

// ---- Từng phân khu ----
for (const z of zones) {
  const path = `dat-nen-fpt-city/${z.slug}/`;
  const crumbs = [["Trang chủ", ""], ["Đất nền FPT City", "dat-nen-fpt-city/"], ["Phân khu " + z.code, path]];
  const faq = [
    [`Đất phân khu ${z.code} FPT City giá bao nhiêu?`, `Giá đất phân khu ${z.code} thay đổi theo vị trí lô, hướng và mặt tiền đường. Đăng ký để nhận giỏ hàng ${z.code} cập nhật mới nhất.`],
    [`Đất ${z.code} FPT City có sổ đỏ không?`, "Các lô trong khu đô thị FPT City được cấp sổ đỏ từng lô; mỗi lô sẽ được kiểm tra pháp lý cụ thể trước khi giao dịch."],
    [`Có thể xem đất ${z.code} thực tế không?`, "Có. Để lại số điện thoại để chuyên viên hẹn lịch dẫn xem đất."],
  ];
  write(path, layout({
    path, crumbs, title: z.title, description: z.description, keywords: z.keywords,
    project: "Đất nền FPT City " + z.code, drive: z.drive,
    modalTitle: `Nhận giỏ hàng đất phân khu ${z.code}`,
    needs: ["Mua để ở / xây nhà", "Đầu tư", "Xây nhà cho thuê"],
    schema: [placeSchema(`Đất nền FPT City phân khu ${z.code}`, z.description, path), faqSchema(faq)],
    body: `${breadcrumbs(crumbs)}${hero({
      eyebrow: "Đất nền FPT City Đà Nẵng",
      h1: `Đất nền FPT City <span class="accent">phân khu ${z.code}</span>`,
      lead: esc(z.lead) + ` Nhận <strong>giỏ hàng &amp; bản đồ phân lô ${z.code}</strong> mới nhất.`,
      points: z.traits.slice(0, 3).map(esc),
      cta: `Nhận giỏ hàng phân khu ${z.code}`,
      formTitle: `Giỏ hàng đất ${z.code} FPT City`,
      docs: [`🗺️ Bản đồ phân lô ${z.code}`, "📄 Danh sách lô đang bán & giá", "📑 Pháp lý từng lô", "📞 Hẹn lịch xem đất"],
      needs: ["Mua để ở / xây nhà", "Đầu tư", "Xây nhà cho thuê"],
    })}
    <section id="tong-quan" class="section">
      <div class="container two-col">
        <div class="reveal">
          <p class="eyebrow dark">Phân khu ${z.code}</p>
          <h2 class="title">Vì sao chọn đất FPT City ${z.code}?</h2>
          <ul class="check-list">${z.traits.map((t) => `<li>${esc(t)}</li>`).join("")}</ul>
          <a href="#dang-ky" class="btn btn-primary" data-open-form>Xem lô đang bán ${z.code}</a>
        </div>
        ${specCard(`Thông tin phân khu ${z.code}`, [["Dự án", "Khu đô thị FPT City Đà Nẵng"], ["Phân khu", z.code], ["Chủ đầu tư", investor], ["Loại hình", "Đất nền, nhà phố, biệt thự"], ["Pháp lý", "Sổ đỏ từng lô"], ["Giá", "Theo giỏ hàng cập nhật"]], "Đặc điểm lô mang tính tham khảo; chi tiết từng lô có trong giỏ hàng.")}
      </div>
    </section>
    ${location(`Vị trí đất FPT City phân khu ${z.code}`)}
    ${ctaSection({
      heading: `Nhận bảng giá đất phân khu ${z.code}`,
      intro: `Giỏ hàng ${z.code} thay đổi liên tục. Đăng ký để nhận:`,
      steps: [`<b>Bản đồ phân lô</b> phân khu ${z.code}.`, "<b>Danh sách lô</b> đang bán, diện tích, hướng, giá.", "<b>Pháp lý</b> từng lô.", "<b>Lịch xem đất</b> cùng chuyên viên."],
      formTitle: `Nhận giỏ hàng ${z.code}`,
      needs: ["Mua để ở / xây nhà", "Đầu tư", "Xây nhà cho thuê"],
    })}
    ${faqSection(`Hỏi đáp đất FPT City phân khu ${z.code}`, faq)}
    ${related("Các phân khu đất nền khác", zoneCards(z.slug))}
    ${finalCta(`Đừng bỏ lỡ lô đẹp phân khu ${z.code}`, "Nhận giỏ hàng qua Google Drive chỉ trong 1 phút.", "Nhận giỏ hàng")}`,
  }));
}

// ---- Tổng quan căn hộ FPT Plaza ----
{
  const path = "can-ho-fpt-plaza/";
  const crumbs = [["Trang chủ", ""], ["Căn hộ FPT Plaza", path]];
  const faq = [
    ["Chuỗi căn hộ FPT Plaza gồm những tòa nào?", "Gồm FPT Plaza 1, FPT Plaza 2 (đã bàn giao), FPT Plaza 3, FPT Plaza 4 (đang mở bán) và FPT Plaza 5 (sắp mở bán), tất cả trong khu đô thị FPT City Đà Nẵng."],
    ["Nên mua căn hộ FPT Plaza nào?", "Cần ở ngay: chọn chuyển nhượng FPT Plaza 1, 2. Muốn thanh toán giãn theo tiến độ: FPT Plaza 4. Muốn giá đợt đầu: đăng ký FPT Plaza 5."],
  ];
  write(path, layout({
    path, crumbs,
    title: "Căn hộ FPT Plaza Đà Nẵng – So sánh FPT Plaza 1, 2, 3, 4, 5 | Bảng giá",
    description: "So sánh căn hộ FPT Plaza 1, 2, 3, 4, 5 tại FPT City Đà Nẵng: quy mô, số căn, tình trạng, tiến độ. Nhận bảng giá và mặt bằng căn hộ FPT Plaza qua Google Drive.",
    keywords: "căn hộ FPT Plaza, chung cư FPT Đà Nẵng, FPT Plaza 1, FPT Plaza 2, FPT Plaza 3, FPT Plaza 4, FPT Plaza 5, giá căn hộ FPT Plaza",
    project: "Căn hộ FPT Plaza",
    modalTitle: "Nhận bảng giá căn hộ FPT Plaza",
    needs: plazas.map((p) => p.name).concat("Chưa xác định"),
    schema: [faqSchema(faq)],
    body: `${breadcrumbs(crumbs)}${hero({
      eyebrow: "Chuỗi căn hộ FPT City Đà Nẵng",
      h1: `Căn hộ <span class="accent">FPT Plaza</span> Đà Nẵng`,
      lead: "Từ căn hộ đã bàn giao đến dự án sắp mở bán – chọn đúng tòa theo nhu cầu ở hoặc đầu tư. Nhận <strong>bảng giá &amp; mặt bằng FPT Plaza 1 – 5</strong>.",
      points: ["5 tòa căn hộ trong cùng khu đô thị FPT City", "Căn 1PN – 3PN và căn diện tích lớn", "Sơ cấp từ chủ đầu tư & chuyển nhượng"],
      cta: "Nhận bảng giá FPT Plaza 1 – 5",
      formTitle: "Nhận bảng giá căn hộ FPT Plaza",
      docs: ["📄 Bảng giá từng tòa", "📐 Mặt bằng & layout căn hộ", "🔄 Giỏ hàng chuyển nhượng", "🎁 Chính sách thanh toán, vay"],
      needs: plazas.map((p) => p.name).concat("Chưa xác định"),
    })}
    <section id="tong-quan" class="section">
      <div class="container">
        <div class="section-head reveal"><p class="eyebrow dark">So sánh</p><h2 class="title">So sánh nhanh FPT Plaza 1, 2, 3, 4, 5</h2></div>
        <div class="table-wrap reveal">
          <table class="compare">
            <thead><tr><th>Dự án</th><th>Quy mô</th><th>Số căn</th><th>Tình trạng</th><th></th></tr></thead>
            <tbody>${plazas.map((p) => {
              const g = (k) => (p.specs.find((s) => s[0] === k) || [, "—"])[1];
              return `<tr><th scope="row">${p.name}</th><td>${esc(g("Quy mô"))}</td><td>${esc(g("Số căn hộ"))}</td><td><span class="status status-${p.status}">${esc(p.statusLabel)}</span></td><td><a href="/${p.slug}/">Chi tiết →</a></td></tr>`;
            }).join("")}</tbody>
          </table>
        </div>
        <p class="footnote">Số liệu tổng hợp, mang tính tham khảo; FPT Plaza 5 là số liệu dự kiến.</p>
      </div>
    </section>
    ${related("Xem chi tiết từng tòa", plazaCards())}
    ${location("Căn hộ FPT Plaza – vị trí kết nối phía Nam Đà Nẵng")}
    ${amenities()}
    ${ctaSection({
      heading: "Nhận bảng giá căn hộ FPT Plaza",
      intro: "Để lại thông tin để nhận thư mục Google Drive gồm:",
      steps: ["<b>Bảng giá</b> FPT Plaza 3, 4 và giỏ hàng chuyển nhượng Plaza 1, 2.", "<b>Mặt bằng</b> tầng điển hình & layout căn hộ.", "<b>Thông tin FPT Plaza 5</b> ngay khi có.", "<b>Tư vấn 1:1</b> chọn tòa, chọn căn."],
      formTitle: "Nhận bảng giá FPT Plaza",
      needs: plazas.map((p) => p.name).concat("Chưa xác định"),
    })}
    ${faqSection("Hỏi đáp về căn hộ FPT Plaza", faq)}
    ${finalCta("Chọn căn hộ FPT Plaza phù hợp với bạn", "Nhận bảng giá cả 5 tòa trong 1 link Google Drive.", "Nhận bảng giá")}`,
  }));
}

// ---- Từng tòa FPT Plaza ----
for (const p of plazas) {
  const path = `${p.slug}/`;
  const crumbs = [["Trang chủ", ""], ["Căn hộ FPT Plaza", "can-ho-fpt-plaza/"], [p.name, path]];
  const needs = ["Mua để ở", "Đầu tư cho thuê", "Tìm hiểu thêm"];
  const resale = p.status === "resale";
  write(path, layout({
    path, crumbs, title: p.title, description: p.description, keywords: p.keywords,
    project: p.name, drive: p.drive,
    modalTitle: p.cta, needs,
    schema: [{ ...placeSchema("Căn hộ " + p.name, p.description, path), "@type": "ApartmentComplex" }, faqSchema(p.faq)],
    body: `${breadcrumbs(crumbs)}${hero({
      eyebrow: `Khu đô thị FPT City Đà Nẵng · ${esc(p.statusLabel)}`,
      h1: `Căn hộ <span class="accent">${p.name}</span> Đà Nẵng`,
      lead: esc(p.lead),
      points: p.highlights.slice(0, 3).map(esc),
      cta: p.cta,
      formTitle: resale ? `Giỏ hàng ${p.name}` : `Nhận tài liệu ${p.name}`,
      badge: p.statusLabel.split(" · ").pop(),
      docs: resale
        ? ["🔄 Giỏ hàng căn chuyển nhượng", "📄 Giá theo tầng, hướng", "📐 Mặt bằng căn hộ", "📞 Hẹn lịch xem nhà"]
        : ["📄 Bảng giá & tiến độ thanh toán", "📐 Mặt bằng tầng & layout căn", "🎁 Chính sách ưu đãi", "🖼️ Brochure, phối cảnh, pháp lý"],
      needs,
    })}
    <section id="tong-quan" class="section">
      <div class="container two-col">
        <div class="reveal">
          <p class="eyebrow dark">Tổng quan ${p.name}</p>
          <h2 class="title">Điểm nổi bật căn hộ ${p.name}</h2>
          <p>${esc(p.lead)} Chủ đầu tư: ${esc(investor)}.</p>
          <ul class="check-list">${p.highlights.map((h) => `<li>${esc(h)}</li>`).join("")}</ul>
          <a href="#dang-ky" class="btn btn-primary" data-open-form>${esc(p.cta)}</a>
        </div>
        ${specCard(`Thông tin ${p.name}`, [["Dự án", "Căn hộ " + p.name], ["Chủ đầu tư", "Công ty CP Đô thị FPT Đà Nẵng"], ["Vị trí", "Khu đô thị FPT City, Đà Nẵng"], ...p.specs], p.note)}
      </div>
    </section>
    <section id="mat-bang" class="section section-dark">
      <div class="container">
        <div class="section-head reveal">
          <p class="eyebrow">Mặt bằng căn hộ</p>
          <h2 class="title light">Mặt bằng ${p.name} – loại căn &amp; diện tích</h2>
          <p>Diện tích tham khảo. Layout chi tiết có trong bộ tài liệu Google Drive.</p>
        </div>
        <div class="grid-plans">${p.units.map(([type, area], i) => `
          <article class="plan${i === 1 ? " featured" : ""} reveal">
            ${i === 1 ? '<span class="tag">Được quan tâm nhất</span>' : ""}
            <div class="plan-img" aria-hidden="true"><svg viewBox="0 0 120 80"><rect x="4" y="4" width="112" height="72" fill="none" stroke="currentColor" stroke-width="2"/>${Array.from({ length: Math.min(i + 1, 3) }, (_, k) => `<line x1="${4 + (112 / (Math.min(i + 1, 3) + 1)) * (k + 1)}" y1="4" x2="${4 + (112 / (Math.min(i + 1, 3) + 1)) * (k + 1)}" y2="44" stroke="currentColor" stroke-width="2"/>`).join("")}<line x1="4" y1="44" x2="116" y2="44" stroke="currentColor" stroke-width="2"/></svg></div>
            <h3>Căn ${esc(type)}</h3><p class="area">${esc(area)}</p>
            <button class="btn ${i === 1 ? "btn-gold" : "btn-outline-light"} btn-block" data-open-form>Xem layout &amp; giá ${esc(type)}</button>
          </article>`).join("")}
        </div>
      </div>
    </section>
    ${location(`Vị trí ${p.name} – trong lõi khu đô thị FPT City`)}
    ${amenities()}
    ${ctaSection({
      heading: resale ? `Giá chuyển nhượng ${p.name} mới nhất` : `Bảng giá ${p.name} – đăng ký sớm, lợi thế lớn`,
      intro: "Đăng ký hôm nay, bạn nhận được:",
      steps: resale
        ? ["<b>Link Google Drive</b> giỏ hàng căn đang chuyển nhượng.", "<b>Giá theo tầng, hướng</b>, tình trạng nội thất.", "<b>Hỗ trợ pháp lý</b> sang tên, vay ngân hàng.", "<b>Lịch xem nhà</b> thực tế."]
        : ["<b>Link Google Drive</b> brochure, mặt bằng, bảng giá.", "<b>Báo giá đầu tiên</b> khi có đợt mở bán mới.", "<b>Ưu tiên chọn căn đẹp</b> – tầng cao, view biển, view sông.", "<b>Tư vấn 1:1</b> phương án tài chính, dòng tiền cho thuê."],
      formTitle: p.cta, needs,
    })}
    ${faqSection(`Câu hỏi thường gặp về ${p.name}`, p.faq)}
    ${related("Các tòa FPT Plaza khác", plazaCards(p.slug))}
    ${finalCta(resale ? `Tìm căn ${p.name} ưng ý ngay hôm nay` : `Đừng bỏ lỡ căn hộ ${p.name} đẹp nhất`, "Một phút đăng ký – nhận ngay tài liệu qua Google Drive.", "Nhận tài liệu miễn phí")}`,
  }));
}

/* ================= SITEMAP & ROBOTS ================= */
writeFileSync(join(OUT, "sitemap.xml"), `<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
${pages.map((p) => `  <url><loc>${url(p)}</loc><lastmod>${site.updated}</lastmod><changefreq>weekly</changefreq><priority>${p === "" ? "1.0" : p.split("/").length > 2 ? "0.7" : "0.9"}</priority></url>`).join("\n")}
</urlset>
`);
writeFileSync(join(OUT, "robots.txt"), `User-agent: *\nAllow: /\n\nSitemap: ${site.domain}/sitemap.xml\n`);
console.log(`Đã tạo ${pages.length} trang vào public/`);
