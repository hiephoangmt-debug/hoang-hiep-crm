// Sinh danh mục sản phẩm mẫu từ dữ liệu website rồi chèn vào Code.gs (giữa 2 dấu SEED).
// Chạy: node crm/tools/gen-seed.mjs   — KHÔNG ghi giá: chủ CRM tự điền cột GIÁ trong tab SAN_PHAM.
import fs from "node:fs";
import { plazas, zones } from "../../website/src/data.mjs";
import { typeRanges, typeLabel } from "../../website/src/fpt-plaza-4-units.mjs";

const STATUS = { "fpt-plaza-1": "Chuyển nhượng", "fpt-plaza-2": "Chuyển nhượng", "fpt-plaza-3": "Đang bán", "fpt-plaza-4": "Đang bán", "fpt-plaza-5": "Sắp mở bán" };
const num = (s) => (String(s).match(/\d+(?:,\d+)?/g) || []).map((x) => +x.replace(",", "."));
const rows = []; // [project, kind, name, code, areaMin, areaMax, status, note, doc]

for (const p of plazas) {
  if (p.slug === "fpt-plaza-4") {
    const r = typeRanges();
    for (const [t, [mn, mx, n]] of Object.entries(r)) {
      rows.push([p.name, t.startsWith("DUP") ? "Duplex" : "Căn hộ", typeLabel[t].replace(/^Căn hộ /, ""), t, mn, mx, STATUS[p.slug], `${n} căn theo mặt bằng`, p.drive || ""]);
    }
  } else {
    for (const [name, area] of p.units) {
      const a = num(area);
      rows.push([p.name, "Căn hộ", name, name.replace(/\s/g, ""), a[0] || "", a.length > 1 ? a[a.length - 1] : "", STATUS[p.slug], /dự kiến|Sắp/i.test(p.statusLabel + p.note) && p.status === "upcoming" ? "Số liệu dự kiến" : "", p.drive || ""]);
    }
  }
}
const ZA = { V1: [200, 350], V2: [100, 100], V3: [100, 100], V5: [90, 105] };
for (const z of zones) rows.push([`Đất nền ${z.code}`, "Đất nền", `Lô phân khu ${z.code}`, z.code, ...(ZA[z.code] || ["", ""]), "Đang bán", "", ""]);

const out = "const SEED_PRODUCTS = " + JSON.stringify(rows) + ";";
const f = new URL("../Code.gs", import.meta.url).pathname;
let src = fs.readFileSync(f, "utf8");
src = src.replace(/\/\/ SEED-BEGIN[\s\S]*?\/\/ SEED-END/, `// SEED-BEGIN (do crm/tools/gen-seed.mjs sinh)\n${out}\n// SEED-END`);
fs.writeFileSync(f, src);
console.log(rows.length, "dòng sản phẩm mẫu");
