// Sinh ảnh minh hoạ (infographic) từ dữ liệu trong data.mjs → public/assets/img/minh-hoa/*.webp
// Chạy: node src/build-illustrations.mjs  (cần Playwright + python3 PIL). Ảnh do mình tự vẽ, không dùng ảnh của bên khác.
import { createRequire } from "node:module";
import { mkdirSync, writeFileSync, existsSync } from "node:fs";
import { execFileSync } from "node:child_process";
import { dirname, join } from "node:path";
import { fileURLToPath } from "node:url";
import { plazas, zones } from "./data.mjs";

const HERE = dirname(fileURLToPath(import.meta.url));
const OUT = join(HERE, "..", "public", "assets", "img", "minh-hoa");
const TMP = process.env.ILLUS_TMP || "/tmp/illus";
mkdirSync(OUT, { recursive: true }); mkdirSync(TMP, { recursive: true });
const req = createRequire(existsSync("/root/node-tools/node_modules/") ? "/root/node-tools/node_modules/" : import.meta.url);
const { chromium } = req("playwright");

const esc = (s) => String(s).replace(/&/g, "&amp;").replace(/</g, "&lt;");
const CSS = `*{box-sizing:border-box;margin:0}body{width:1200px;font-family:"Be Vietnam Pro","Segoe UI",Roboto,Arial,sans-serif;color:#fff;background:linear-gradient(150deg,#0a1630,#16306b);padding:48px 56px 40px}
h1{font-size:50px;line-height:1.15;font-weight:800}h1 b{color:#ff8a1f}.sub{font-size:28px;opacity:.85;margin-top:8px}
.foot{margin-top:26px;font-size:24px;opacity:.7;display:flex;justify-content:space-between}.brand{color:#ff8a1f;font-weight:800;opacity:1}
.row{display:grid;grid-template-columns:230px 1fr;gap:20px;align-items:center;margin-top:18px}.nm{font-size:34px;font-weight:800}
.track{background:rgba(255,255,255,.1);border-radius:16px;height:70px;position:relative;overflow:hidden}.bar{position:absolute;top:0;bottom:0;border-radius:16px;background:linear-gradient(90deg,#ff8a1f,#f26a0f);display:flex;align-items:center;padding-left:20px;font-size:30px;font-weight:800;color:#0a1630;white-space:nowrap}
.bar.alt{background:linear-gradient(90deg,#4a7be0,#2453b3);color:#fff}.tag{position:absolute;right:16px;top:0;bottom:0;display:flex;align-items:center;font-size:26px;opacity:.9}
.chip{display:inline-block;background:rgba(255,255,255,.14);border-radius:999px;padding:8px 20px;font-size:28px;margin:6px 10px 0 0}.chip.o{background:#ff8a1f;color:#0a1630;font-weight:800}`;
const page = (body) => `<!doctype html><meta charset=utf-8><link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;600;800&display=swap" rel=stylesheet><style>${CSS}</style><body>${body}</body>`;
const foot = (note = "") => `<div class="foot"><span>${esc(note)}</span><span class="brand">FPT City Đà Nẵng</span></div>`;
const jobs = [];
const add = (name, html) => jobs.push({ name, html });

// 1. Chuỗi FPT Plaza
const FP = [
  ["FPT Plaza 1", 586, "586 căn · 15 tầng", "Đã bàn giao", "alt"],
  ["FPT Plaza 2", 700, "~700 căn · 25 tầng", "Bàn giao 2023", "alt"],
  ["FPT Plaza 3", 837, "837 căn · 25 tầng", "Bàn giao 2026", ""],
  ["FPT Plaza 4", 1395, "1.395 căn · 20 tầng", "Đang mở bán", ""],
  ["FPT Plaza 5", 830, "~830 căn* · ~25 tầng*", "Sắp mở bán", ""],
];
add("chuoi-fpt-plaza", page(`<h1>Chuỗi căn hộ <b>FPT Plaza 1–5</b></h1><p class="sub">Quy mô từng tòa tại khu đô thị FPT City Đà Nẵng</p>${FP.map(([n, v, t, s, c]) => `<div class="row"><div class="nm">${n}</div><div class="track"><div class="bar ${c}" style="width:${Math.max(38, v / 1395 * 100)}%">${t}</div><div class="tag" style="${v / 1395 > .6 ? "display:none" : ""}">${s}</div></div></div>`).join("")}<div style="margin-top:16px;font-size:26px;opacity:.85">Cam: đang bán / sắp bán · Xanh: đã bàn giao hoặc chuyển nhượng</div>${foot("*Số liệu FPT Plaza 5 là dự kiến, theo công bố chính thức sau")}`));

// 2. Vị trí
const LOC = [["Biển Tân Trà – Non Nước", "~5 phút"], ["Ngũ Hành Sơn", "~10 phút"], ["Trung tâm Đà Nẵng", "~15–20 phút"], ["Sân bay quốc tế", "~20 phút"], ["Phố cổ Hội An", "~20 phút"]];
add("vi-tri-fpt-city", page(`<h1>FPT City <b>nằm ở đâu?</b></h1><p class="sub">Thời gian di chuyển tham khảo từ khu đô thị</p><div style="display:grid;grid-template-columns:330px 1fr;gap:34px;margin-top:26px;align-items:center"><div style="aspect-ratio:1;border-radius:50%;background:radial-gradient(circle,#ff8a1f,#f26a0f);color:#0a1630;display:grid;place-items:center;text-align:center;font-size:42px;font-weight:800;line-height:1.2;padding:30px">FPT City<br><span style="font-size:28px;font-weight:600">Khu đô thị công nghệ<br>181+ ha</span></div><div>${LOC.map(([a, b]) => `<div style="display:flex;justify-content:space-between;align-items:center;background:rgba(255,255,255,.1);border-left:8px solid #ff8a1f;border-radius:14px;padding:16px 24px;margin-bottom:12px;font-size:32px"><span>${a}</span><b style="color:#ff8a1f;white-space:nowrap">${b}</b></div>`).join("")}<div style="font-size:26px;opacity:.85">Ngay trong khu: Đại học FPT &amp; FPT Complex</div></div></div>${foot("Sơ đồ minh hoạ, không theo tỷ lệ · thời gian tham khảo")}`));

// 3. Loại căn từng tòa
const nums = (s) => (String(s).match(/\d+(?:,\d+)?/g) || []).map((x) => +x.replace(",", "."));
for (const p of plazas) {
  const rows = p.units.map(([n, a]) => ({ n, a, v: nums(a), from: /từ/.test(a) }));
  const max = Math.max(...rows.flatMap((r) => r.v)) * 1.12, min = 0;
  add(`loai-can-${p.slug}`, page(`<h1>Loại căn <b>${esc(p.name)}</b></h1><p class="sub">Diện tích tham khảo (m²)</p>${rows.map((r) => {
    const lo = r.v[0], hi = r.v[r.v.length - 1];
    const left = (lo / max * 100) * 0.0, w = r.v.length > 1 ? hi / max * 100 : Math.max(lo / max * 100, 22);
    const label = esc(r.a.replace(/~/g, "").trim()), inside = w > 52;
    return `<div class="row" style="grid-template-columns:270px 1fr"><div class="nm">${esc(r.n)}</div><div class="track"><div class="bar ${r.v.length > 1 ? "" : "alt"}" style="left:${left}%;width:${w}%">${inside ? label : ""}</div>${inside ? "" : `<div style="position:absolute;top:0;bottom:0;left:calc(${w}% + 18px);display:flex;align-items:center;font-size:30px;font-weight:800;white-space:nowrap">${label}</div>`}</div></div>`;
  }).join("")}${foot(p.status === "upcoming" ? "Số liệu dự kiến, theo công bố chính thức của chủ đầu tư" : "Theo tài liệu dự án, thông số chính thức theo hợp đồng")}`));
}

// 4. Đất nền: tổng quan + từng phân khu
const ZA = { V1: [200, 350], V2: [100, 100], V3: [100, 100], V5: [90, 105] };
add("dat-nen-phan-khu", page(`<h1>Đất nền FPT City <b>V1 – V6</b></h1><p class="sub">Diện tích lô phổ biến theo từng phân khu</p>${zones.map((z) => { const a = ZA[z.code]; return `<div class="row" style="grid-template-columns:140px 1fr"><div class="nm">${z.code}</div><div class="track">${a ? `<div class="bar" style="width:${Math.max(30, a[1] / 350 * 100)}%">${a[0] === a[1] ? "~" + a[0] : a[0] + "–" + a[1]} m²</div>` : `<div class="tag" style="left:20px;right:auto">Giỏ hàng cập nhật theo tuần</div>`}</div></div>`; }).join("")}${foot("Diện tích lô phổ biến, mỗi lô cụ thể theo giỏ hàng")}`));
for (const z of zones) {
  const a = ZA[z.code];
  add(`dat-nen-${z.code.toLowerCase()}`, page(`<div style="display:flex;gap:30px;align-items:center"><div style="width:170px;height:170px;border-radius:30px;background:linear-gradient(135deg,#ff8a1f,#f26a0f);color:#0a1630;display:grid;place-items:center;font-size:84px;font-weight:800">${z.code}</div><div><h1>Đất nền FPT City<br><b>phân khu ${z.code}</b></h1></div></div>${a ? `<div style="margin-top:22px"><span class="chip o">Lô phổ biến ${a[0] === a[1] ? "~" + a[0] : a[0] + "–" + a[1]} m²</span></div>` : ""}<div style="margin-top:22px">${z.traits.map((t) => `<div style="display:flex;gap:16px;align-items:center;background:rgba(255,255,255,.1);border-radius:16px;padding:16px 24px;margin-bottom:12px;font-size:32px"><span style="color:#ff8a1f;font-weight:800">✓</span>${esc(t)}</div>`).join("")}</div>${foot("Thông tin tham khảo, lô cụ thể theo giỏ hàng cập nhật")}`));
}

const b = await chromium.launch({ executablePath: "/opt/pw-browsers/chromium_headless_shell-1194/chrome-linux/headless_shell" });
const pg = await b.newPage({ viewport: { width: 1200, height: 700 } });
await pg.route("**/*", (r) => (r.request().url().startsWith("http://i.test/") ? r.fulfill({ contentType: "text/html; charset=utf-8", body: pg._html }) : r.abort())); // không tải font ngoài → dùng font hệ thống
for (const j of jobs) {
  pg._html = j.html;
  await pg.goto("http://i.test/" + j.name);
  await pg.screenshot({ path: join(TMP, j.name + ".png"), fullPage: true });
}
await b.close();
execFileSync("python3", ["-c", `
import sys,glob,os
from PIL import Image
for f in glob.glob(sys.argv[1]+'/*.png'):
    im=Image.open(f).convert('RGB'); n=os.path.basename(f)[:-4]
    im.save(os.path.join(sys.argv[2],n+'.webp'),quality=84,method=6)
    s=im.resize((600,round(im.height*600/im.width)),Image.LANCZOS); s.save(os.path.join(sys.argv[2],n+'-sm.webp'),quality=82,method=6)
    print(n,im.size)
`, TMP, OUT], { stdio: "inherit" });
