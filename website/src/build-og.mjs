// Ảnh chia sẻ Facebook/Zalo 1200×630 cho 7 trang: ảnh phối cảnh + tên dự án. Chạy: node src/build-og.mjs
import { createRequire } from "node:module";
import { readFileSync, mkdirSync } from "node:fs";
import { execFileSync } from "node:child_process";
import { dirname, join } from "node:path";
import { fileURLToPath } from "node:url";
const HERE = dirname(fileURLToPath(import.meta.url));
const IMG = join(HERE, "..", "public", "assets", "img");
const OUT = join(IMG, "og"); mkdirSync(OUT, { recursive: true });
const req = createRequire("/root/node-tools/node_modules/");
const { chromium } = req("playwright");
const PAGES = [
  ["home", 1, "FPT City Đà Nẵng", "Đất nền V1–V6 & căn hộ FPT Plaza 1–5", "Bảng giá 2026 · 181+ ha"],
  ["land", 2, "Đất nền FPT City", "Phân khu V1 · V2 · V3 · V4 · V5 · V6", "Sổ đỏ từng lô · Lô 90–350 m²"],
  ["fpt-plaza-1", 2, "FPT Plaza 1", "Mua bán · cho thuê · ký gửi", "586 căn · Đã bàn giao"],
  ["fpt-plaza-2", 1, "FPT Plaza 2", "Mua bán · cho thuê · ký gửi", "~700 căn · Đã bàn giao"],
  ["fpt-plaza-3", 2, "FPT Plaza 3", "Đã có sổ · Mua bán, cho thuê", "The Empire & The Wealthe · 837 căn"],
  ["fpt-plaza-4", "fpt-plaza-4/phoi-canh/phoi-canh-fpt-plaza-4-1.webp", "FPT Plaza 4", "Mặt bằng, bảng giá căn hộ mới nhất", "1.395 căn · Đang mở bán"],
  ["fpt-plaza-5", "fpt-plaza-5/phoi-canh/phoi-canh-fpt-plaza-5-1.webp", "FPT Plaza 5", "Sắp mở bán · Nhận đăng ký sớm", "Biết giá trước người khác"],
];
const b = await chromium.launch({ executablePath: "/opt/pw-browsers/chromium_headless_shell-1194/chrome-linux/headless_shell" });
const p = await b.newPage({ viewport: { width: 1200, height: 630 } });
for (const [slug, n, h, sub, tag] of PAGES) {
  const bg = readFileSync(typeof n === "string" ? join(IMG, n) : join(IMG, "phoi-canh", `fpt-city-phoi-canh-tong-the-${n}.webp`)).toString("base64");
  await p.setContent(`<body style="margin:0;width:1200px;height:630px;font-family:'Be Vietnam Pro','Segoe UI',Arial,sans-serif;color:#fff;background:linear-gradient(90deg,rgba(10,22,48,.92),rgba(10,22,48,.55) 60%,rgba(10,22,48,.2)),url(data:image/webp;base64,${bg}) center/cover">
    <div style="padding:70px 64px;display:flex;flex-direction:column;height:630px;box-sizing:border-box">
      <div style="font-size:26px;font-weight:700;letter-spacing:.12em;color:#ff8a1f;text-transform:uppercase">Khu đô thị FPT City Đà Nẵng</div>
      <div style="font-size:84px;font-weight:800;line-height:1.05;margin-top:18px">${h}</div>
      <div style="font-size:38px;font-weight:600;margin-top:14px;max-width:820px">${sub}</div>
      <div style="margin-top:auto;display:flex;gap:16px;align-items:center"><span style="background:#ff8a1f;color:#fff;font-weight:800;font-size:30px;padding:12px 26px;border-radius:999px">${tag}</span><span style="font-size:28px;opacity:.9">Hotline 0904 567 009</span></div>
    </div></body>`);
  await p.screenshot({ path: join(OUT, `og-${slug}.png`) });
}
await b.close();
execFileSync("python3", ["-c", "import sys,glob\nfrom PIL import Image\nfor f in glob.glob(sys.argv[1]+'/og-*.png'):\n    Image.open(f).convert('RGB').save(f[:-4]+'.jpg',quality=85,optimize=True)\n", OUT]);
console.log("og images:", PAGES.length);
