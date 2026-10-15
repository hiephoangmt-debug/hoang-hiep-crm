// Bóc tách khối lượng & dự toán chi phí hoàn thiện nội thất từ mặt bằng.
// Đơn giá tham khảo (VNĐ, vật tư + nhân công, phân khúc trung cấp) – người dùng sửa được.
import { wallLength, polygonArea, pointInPolygon, closestOnSegment } from './geom.js';
import { CATALOG_MAP } from './furniture.js';
import { FLOOR_TYPES } from './model.js';
import { STYLES, resolvePalette } from './styles.js';

export const DEFAULT_PRICES = {
  // Sàn (đ/m²)
  'floor.herringbone': 1150000, 'floor.herringboneLight': 1100000, 'floor.wood': 650000, 'floor.oak': 750000, 'floor.walnut': 950000,
  'floor.tile': 450000, 'floor.darkTile': 520000, 'floor.marble': 1600000, 'floor.carpet': 400000, 'floor.concrete': 250000,
  'floor.polished': 600000, 'floor.terracotta': 420000, 'floor.encaustic': 750000, 'floor.grass': 150000,
  // Hoàn thiện
  paint: 85000, ceiling: 220000, ceilingWet: 260000, skirting: 120000, led: 180000, lamp: 650000, downlight: 180000,
  // Cửa & rèm
  doorMain: 12000000, door: 6500000, doorWc: 4500000, window: 2800000, slide: 3200000, curtain: 450000, slats: 1800000,
  // Nội thất (đ/cái, riêng tủ & thảm theo md / m²)
  'f.bed': 15000000, 'f.bedSingle': 9000000, 'f.nightstand': 2500000, 'f.wardrobe': 7000000, 'f.desk': 4000000, 'f.officeChair': 2500000,
  'f.bookshelf': 4000000, 'f.sofa': 25000000, 'f.armchair': 8000000, 'f.coffeeTable': 4500000, 'f.roundTable': 5500000,
  'f.tvStand': 21000000, 'f.rug': 900000, 'f.floorLamp': 3000000, 'f.plant': 1200000, 'f.kitchen': 12000000, 'f.fridge': 18000000,
  'f.diningTable': 12000000, 'f.chair': 2200000, 'f.washer': 11000000, 'f.toilet': 6500000, 'f.vanity': 7500000, 'f.shower': 12000000,
  'f.bathtub': 22000000, 'f.stairs': 35000000, 'f.car': 0,
};
// Đơn vị tính cho nội thất đặc biệt
const FURN_UNIT = { wardrobe: 'md', kitchen: 'md', bookshelf: 'md', rug: 'm²' };
export const STYLE_FACTOR = { luxury: 1.35, neoclassic: 1.45, indochine: 1.2, japandi: 1.1, scandi: 1.0, industrial: 1.0, minimal: 0.95 };

const isWet = (name = '') => /tắm|wc|vệ sinh|toilet/i.test(name);

export function computeEstimate(plan) {
  const st = plan.settings;
  const prices = { ...DEFAULT_PRICES, ...(st.prices || {}) };
  const pal = resolvePalette(st);
  const H = st.wallHeight || 2.8;
  const rooms = plan.rooms;
  const inside = (p) => rooms.some((r) => pointInPolygon(p, r.points));
  const roomAt = (p) => rooms.find((r) => pointInPolygon(p, r.points));
  const sections = [];
  const row = (key, name, unit, qty, note = '') => ({ key, name, unit, qty: Math.round(qty * 100) / 100, price: prices[key] ?? 0, note });

  // --- A. Sàn ---
  const floorRows = [];
  const byFloor = {};
  for (const r of rooms) {
    const a = polygonArea(r.points);
    (byFloor[r.floor] ||= { area: 0, rooms: [] }).area += a;
    byFloor[r.floor].rooms.push(r.name);
  }
  for (const [f, v] of Object.entries(byFloor)) floorRows.push(row('floor.' + f, `Lát sàn ${FLOOR_TYPES[f] || f}`, 'm²', v.area * 1.05, v.rooms.join(', ') + ' (+5% hao hụt)'));
  sections.push({ title: 'A. Sàn', rows: floorRows });

  // --- B. Tường, trần, chiếu sáng ---
  let paint = 0, skirting = 0;
  const opsBy = new Map();
  plan.openings.forEach((o) => (opsBy.get(o.wallId) || opsBy.set(o.wallId, []).get(o.wallId)).push(o));
  for (const w of plan.walls) {
    const L = wallLength(w);
    if (L < 0.05) continue;
    const nx = -(w.b.y - w.a.y) / L, ny = (w.b.x - w.a.x) / L;
    const m = { x: (w.a.x + w.b.x) / 2, y: (w.a.y + w.b.y) / 2 };
    const sides = (inside({ x: m.x + nx * 0.3, y: m.y + ny * 0.3 }) ? 1 : 0) + (inside({ x: m.x - nx * 0.3, y: m.y - ny * 0.3 }) ? 1 : 0);
    const ops = opsBy.get(w.id) || [];
    const opArea = ops.reduce((s, o) => s + o.width * Math.min(o.height, H - (o.sill || 0)), 0);
    const doorW = ops.filter((o) => o.type !== 'window').reduce((s, o) => s + o.width, 0);
    paint += Math.max(0, (L * (w.height || H) - opArea) * sides);
    skirting += Math.max(0, (L - doorW) * sides);
  }
  const area = rooms.reduce((s, r) => s + polygonArea(r.points), 0);
  const wetArea = rooms.filter((r) => isWet(r.name)).reduce((s, r) => s + polygonArea(r.points), 0);
  let ledLen = 0;
  if (pal.led) for (const r of rooms) for (let i = 0; i < r.points.length; i++) {
    const a = r.points[i], b = r.points[(i + 1) % r.points.length];
    const mid = { x: (a.x + b.x) / 2, y: (a.y + b.y) / 2 };
    if (plan.walls.some((w) => closestOnSegment(mid, w.a, w.b).d < 0.06)) ledLen += Math.hypot(b.x - a.x, b.y - a.y);
  }
  const lampRooms = rooms.filter((r) => polygonArea(r.points) > 1.5).length;
  const finish = [
    row('paint', 'Sơn tường hoàn thiện (bả matit + 1 lót + 2 phủ)', 'm²', paint, 'Đã trừ diện tích cửa'),
    row('ceiling', 'Trần thạch cao phẳng', 'm²', area - wetArea),
    row('ceilingWet', 'Trần thạch cao chống ẩm (WC)', 'm²', wetArea),
    row('skirting', 'Len chân tường', 'md', skirting),
    row('lamp', 'Đèn ốp trần trung tâm', 'cái', lampRooms),
    row('downlight', 'Đèn downlight âm trần', 'cái', Math.ceil(area / 3.5)),
  ];
  if (pal.led) finish.push(row('led', 'Đèn LED hắt khe trần', 'md', ledLen));
  sections.push({ title: 'B. Tường, trần & chiếu sáng', rows: finish.filter((r) => r.qty > 0) });

  // --- C. Cửa & rèm ---
  const doorRows = { doorMain: 0, door: 0, doorWc: 0, window: 0, slide: 0, curtain: 0 };
  for (const o of plan.openings) {
    const w = plan.walls.find((x) => x.id === o.wallId);
    if (!w) continue;
    const L = wallLength(w);
    const nx = -(w.b.y - w.a.y) / L, ny = (w.b.x - w.a.x) / L;
    const c = { x: w.a.x + (w.b.x - w.a.x) * o.t, y: w.a.y + (w.b.y - w.a.y) * o.t };
    const p1 = { x: c.x + nx * 0.3, y: c.y + ny * 0.3 }, p2 = { x: c.x - nx * 0.3, y: c.y - ny * 0.3 };
    const exterior = !inside(p1) || !inside(p2);
    if (o.type === 'door') {
      const wet = [roomAt(p1), roomAt(p2)].some((r) => r && isWet(r.name));
      doorRows[exterior ? 'doorMain' : wet ? 'doorWc' : 'door']++;
    } else {
      doorRows[o.type === 'slide' ? 'slide' : 'window'] += o.width * o.height;
      if (st.curtains !== false && o.height >= 0.9) doorRows.curtain += (o.width + 0.3) * Math.min(H - 0.06, (o.sill || 0) + o.height + 0.25);
    }
  }
  let slatArea = 0;
  if (pal.slats) for (const f of plan.furniture) if (f.type === 'tvStand') slatArea += 2.5 * ((f.w ?? CATALOG_MAP.tvStand.w) + 0.8);
  sections.push({
    title: 'C. Cửa, rèm & ốp trang trí',
    rows: [
      row('doorMain', 'Cửa chính (gỗ chống cháy, khoá điện tử)', 'bộ', doorRows.doorMain),
      row('door', 'Cửa phòng gỗ công nghiệp phủ veneer', 'bộ', doorRows.door),
      row('doorWc', 'Cửa WC nhựa composite chịu nước', 'bộ', doorRows.doorWc),
      row('window', 'Cửa sổ nhôm kính hộp', 'm²', doorRows.window),
      row('slide', 'Cửa kính lùa ra lô-gia/ban công', 'm²', doorRows.slide),
      row('curtain', 'Rèm 2 lớp (voan + vải cản sáng)', 'm²', doorRows.curtain),
      row('slats', 'Vách ốp lam gỗ trang trí sau TV', 'm²', slatArea),
    ].filter((r) => r.qty > 0),
  });

  // --- D. Nội thất theo từng phòng ---
  const groups = new Map();
  for (const f of plan.furniture) {
    const def = CATALOG_MAP[f.type];
    if (!def || f.type === 'car') continue;
    const r = roomAt(f);
    const rn = r?.name || 'Ngoài phòng';
    if (!groups.has(rn)) groups.set(rn, new Map());
    const g = groups.get(rn);
    const unit = FURN_UNIT[f.type] || 'cái';
    const w = f.w ?? def.w, d = f.d ?? def.d;
    const q = unit === 'md' ? w : unit === 'm²' ? w * d : 1;
    const k = f.type + '|' + w + 'x' + d;
    if (!g.has(k)) g.set(k, { ...row('f.' + f.type, `${def.name}${unit === 'cái' ? '' : ''} (${w.toFixed(2)} × ${d.toFixed(2)} m)`, unit, 0), qty: 0 });
    g.get(k).qty = Math.round((g.get(k).qty + q) * 100) / 100;
  }
  const order = rooms.map((r) => r.name);
  for (const [rn, g] of [...groups].sort((a, b) => order.indexOf(a[0]) - order.indexOf(b[0]))) sections.push({ title: `D. Nội thất – ${rn}`, rows: [...g.values()], furniture: true });

  // --- Tổng hợp ---
  const factor = st.styleFactor ?? STYLE_FACTOR[st.style] ?? 1;
  let sub = 0;
  for (const s of sections) {
    s.total = 0;
    for (const r of s.rows) { r.amount = Math.round(r.qty * r.price * factor); s.total += r.amount; }
    sub += s.total;
  }
  const contingency = st.contingency ?? 5, vat = st.vat ?? 8;
  const cont = Math.round((sub * contingency) / 100);
  const tax = Math.round(((sub + cont) * vat) / 100);
  return { sections, factor, sub, contingency, cont, vat, tax, total: sub + cont + tax, area, styleName: STYLES[st.style]?.name || '' };
}

export const vnd = (n) => Math.round(n).toLocaleString('vi-VN');

export function estimateCSV(est) {
  const lines = [['Hạng mục', 'Đơn vị', 'Khối lượng', 'Đơn giá (đ)', 'Thành tiền (đ)', 'Ghi chú']];
  for (const s of est.sections) {
    lines.push([s.title]);
    for (const r of s.rows) lines.push([r.name, r.unit, r.qty, Math.round(r.price * est.factor), r.amount, r.note]);
    lines.push(['Cộng ' + s.title, '', '', '', s.total]);
  }
  lines.push([]);
  lines.push(['Tổng trước dự phòng & thuế', '', '', '', est.sub]);
  lines.push([`Dự phòng phát sinh ${est.contingency}%`, '', '', '', est.cont]);
  lines.push([`Thuế VAT ${est.vat}%`, '', '', '', est.tax]);
  lines.push(['TỔNG CỘNG', '', '', '', est.total]);
  const esc = (v) => (v === undefined ? '' : /[",\n]/.test(String(v)) ? `"${String(v).replace(/"/g, '""')}"` : String(v));
  return '﻿' + lines.map((l) => l.map(esc).join(',')).join('\r\n');
}
