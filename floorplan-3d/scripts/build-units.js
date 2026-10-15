// Chạy trong trình duyệt (qua scripts/build-units.mjs): dựng mặt bằng 3D các căn mẫu từ ảnh + UNIT_SPECS.
import { detectWalls } from '../src/detect.js';
import { detectRooms } from '../src/autorooms.js';
import { closestOnSegment, wallLength, pointInPolygon, rotatePoint, pointInRotRect } from '../src/geom.js';
import { uid } from '../src/model.js';
import { CATALOG_MAP } from '../src/furniture.js';
import { STYLES, roomKind } from '../src/styles.js';
import { UNIT_SPECS } from './unit-specs.js';

function nearestWall(walls, p, maxD = 0.6) {
  let best = null;
  for (const w of walls) {
    const c = closestOnSegment(p, w.a, w.b);
    if (c.d < maxD && (!best || c.d < best.d)) best = { w, t: c.t, d: c.d };
  }
  return best;
}

/** Căn khai báo tay (mét) – không cần nhận diện ảnh */
function buildManual(spec) {
  const walls = spec.walls.map((w) => ({ id: uid(), a: { x: w.a[0], y: w.a[1] }, b: { x: w.b[0], y: w.b[1] }, thickness: w.t }));
  const openings = spec.openings.map(([wi, type, at, width, extra = {}]) => {
    const w = walls[wi];
    const L = wallLength(w);
    const along = Math.abs(w.b.x - w.a.x) > Math.abs(w.b.y - w.a.y) ? (at - w.a.x) / (w.b.x - w.a.x) : (at - w.a.y) / (w.b.y - w.a.y);
    const def = type === 'window' ? { height: 1.4, sill: 0.9 } : type === 'slide' ? { height: 2.3, sill: 0 } : { height: 2.1, sill: 0 };
    return { id: uid(), wallId: w.id, type, t: along, width: Math.min(width, L - 0.05), ...def, ...extra };
  });
  const style = STYLES[spec.style];
  const rooms = spec.rooms.map(([name, floor, pts]) => ({ id: uid(), name, floor: floor || style.floors[roomKind(name)], points: pts.map(([x, y]) => ({ x, y })) }));
  return { walls, openings, rooms };
}

export async function buildUnit(spec, imgUrl) {
  if (spec.manual) {
    const { walls, openings, rooms } = buildManual(spec);
    const plan = { version: 1, walls, openings, rooms, furniture: [], settings: { wallHeight: 2.8, wallThickness: 0.12, style: spec.style, palette: {} } };
    addFurniture(plan, spec, ([x, y]) => ({ x, y }));
    const area = rooms.reduce((s, r) => { let a = 0; r.points.forEach((p, i) => { const q = r.points[(i + 1) % r.points.length]; a += p.x * q.y - q.x * p.y; }); return s + Math.abs(a) / 2; }, 0);
    return { id: spec.id, name: spec.name, type: spec.type, dims: spec.dims, area: +area.toFixed(1), mpp: 1, mppY: 1, plan };
  }
  const img = new Image();
  img.src = imgUrl;
  await img.decode();
  const [wM, hM] = spec.dims;
  const det = detectWalls(img, null, { targetWidthM: wM, targetHeightM: hM });
  const P = ([x, y]) => ({ x: +(x * det.mpp).toFixed(3), y: +(y * det.mppY).toFixed(3) });
  let walls = det.walls, openings = det.openings;
  const dropWall = (pt) => {
    const n = nearestWall(walls, P(pt), 0.35);
    if (!n) return;
    walls = walls.filter((w) => w !== n.w);
    openings = openings.filter((o) => o.wallId !== n.w.id);
  };
  (spec.remove || []).forEach(dropWall);
  (spec.removeWalls || []).forEach(dropWall);
  for (const [x1, y1, x2, y2] of spec.cut || []) {
    const a = P([x1, y1]), b = P([x2, y2]);
    const n = nearestWall(walls, { x: (a.x + b.x) / 2, y: (a.y + b.y) / 2 }, 0.4);
    if (!n) continue;
    const w = n.w, L = wallLength(w);
    const ta = closestOnSegment(a, w.a, w.b).t, tb = closestOnSegment(b, w.a, w.b).t;
    const [t0, t1] = [Math.min(ta, tb), Math.max(ta, tb)];
    const at = (t) => ({ x: w.a.x + (w.b.x - w.a.x) * t, y: w.a.y + (w.b.y - w.a.y) * t });
    walls = walls.filter((x) => x !== w);
    const pieces = [];
    if (t0 * L > 0.2) pieces.push({ ...w, id: uid(), a: { ...w.a }, b: at(t0), r: [0, t0] });
    if ((1 - t1) * L > 0.2) pieces.push({ ...w, id: uid(), a: at(t1), b: { ...w.b }, r: [t1, 1] });
    for (const o of openings.filter((o) => o.wallId === w.id)) {
      const piece = pieces.find((p) => o.t >= p.r[0] && o.t <= p.r[1]);
      if (piece) { o.wallId = piece.id; o.t = (o.t - piece.r[0]) / (piece.r[1] - piece.r[0]); }
      else openings = openings.filter((x) => x !== o);
    }
    pieces.forEach((p) => { delete p.r; walls.push(p); });
  }
  for (const [x1, y1, x2, y2] of spec.walls || []) walls.push({ id: uid(), a: P([x1, y1]), b: P([x2, y2]), thickness: 0.12 });
  const addOn = (wall, type, width, extra = {}) => {
    const def = type === 'window' ? { height: 1.4, sill: 0.9 } : type === 'slide' ? { height: 2.3, sill: 0 } : { height: 2.1, sill: 0 };
    openings.push({ id: uid(), wallId: wall.id, type, t: 0.5, width: Math.min(width, wallLength(wall) - 0.05), ...def, ...extra });
  };
  for (const [[x1, y1, x2, y2], width, extra] of spec.extraSlides || []) { const w = { id: uid(), a: P([x1, y1]), b: P([x2, y2]), thickness: 0.12 }; walls.push(w); addOn(w, 'slide', width, extra); }
  for (const [[x1, y1, x2, y2], width, extra] of spec.extraWindows || []) { const w = { id: uid(), a: P([x1, y1]), b: P([x2, y2]), thickness: 0.1 }; walls.push(w); addOn(w, 'window', width, extra); }
  for (const pt of spec.removeOpenings || []) {
    const p = P(pt);
    let best = null, bd = 0.5;
    for (const o of openings) {
      const w = walls.find((x) => x.id === o.wallId);
      if (!w) continue;
      const c = { x: w.a.x + (w.b.x - w.a.x) * o.t, y: w.a.y + (w.b.y - w.a.y) * o.t };
      const d = Math.hypot(c.x - p.x, c.y - p.y);
      if (d < bd) { bd = d; best = o; }
    }
    if (best) openings = openings.filter((o) => o !== best);
  }
  // Cửa = một đoạn tường đúng bằng khe cửa (dọc 'v' / ngang 'h'); tường nhận nhầm từ cánh cửa trên đoạn đó bị khoét bỏ
  const place = ([x, y, width, orient], type) => {
    const c = P([x, y]);
    const half = width / 2 + 0.06;
    const a = orient === 'h' ? { x: c.x - half, y: c.y } : { x: c.x, y: c.y - half };
    const b = orient === 'h' ? { x: c.x + half, y: c.y } : { x: c.x, y: c.y + half };
    const lo = orient === 'h' ? a.x : a.y, hi = orient === 'h' ? b.x : b.y;
    for (const w of [...walls]) {
      const horiz = Math.abs(w.a.y - w.b.y) < 0.05, vert = Math.abs(w.a.x - w.b.x) < 0.05;
      if (orient === 'h' ? !horiz || Math.abs(w.a.y - c.y) > 0.22 : !vert || Math.abs(w.a.x - c.x) > 0.22) continue;
      const s0 = orient === 'h' ? Math.min(w.a.x, w.b.x) : Math.min(w.a.y, w.b.y), s1 = orient === 'h' ? Math.max(w.a.x, w.b.x) : Math.max(w.a.y, w.b.y);
      if (s1 <= lo || s0 >= hi) continue;
      walls = walls.filter((x) => x !== w);
      openings = openings.filter((o) => o.wallId !== w.id);
      const mk = (u0, u1) => (orient === 'h' ? { a: { x: u0, y: w.a.y }, b: { x: u1, y: w.a.y } } : { a: { x: w.a.x, y: u0 }, b: { x: w.a.x, y: u1 } });
      if (lo - s0 > 0.15) walls.push({ ...w, id: uid(), ...mk(s0, lo) });
      if (s1 - hi > 0.15) walls.push({ ...w, id: uid(), ...mk(hi, s1) });
    }
    const wall = { id: uid(), a, b, thickness: 0.12 };
    walls.push(wall);
    addOn(wall, type, width);
  };
  (spec.doors || []).forEach((d) => place(d, 'door'));
  (spec.slides || []).forEach((d) => place(d, 'slide'));
  (spec.windows || []).forEach((d) => place(d, 'window'));

  const plan = { version: 1, walls, openings, rooms: [], furniture: [], settings: { wallHeight: 2.8, wallThickness: 0.12, style: spec.style, palette: {} } };
  // Phòng + tên theo chữ trên bản vẽ
  const rooms = detectRooms(plan, { close: spec.close ?? 0.32, outside: (spec.outside || []).map(P) });
  const style = STYLES[spec.style];
  for (const r of rooms) {
    const names = spec.labels.filter(([, x, y]) => pointInPolygon(P([x, y]), r.points)).map(([n]) => n);
    const uniq = [...new Set(names)];
    // "Phòng khách, bếp + ăn & phòng đa năng"
    r.name = !uniq.length ? 'Sảnh' : uniq.length === 1 ? uniq[0] : uniq.slice(0, -1).map((n, i) => (i ? n.toLowerCase() : n)).join(', ') + ' & ' + uniq.at(-1).toLowerCase();
    r.name = spec.rename?.[r.name] || r.name;
    r.floor = style.floors[roomKind(r.name)] || 'marble';
  }
  plan.rooms = rooms;
  addFurniture(plan, spec, P);
  const area = rooms.reduce((s, r) => {
    let a = 0;
    r.points.forEach((p, i) => { const q = r.points[(i + 1) % r.points.length]; a += p.x * q.y - q.x * p.y; });
    return s + Math.abs(a) / 2;
  }, 0);
  return { id: spec.id, name: spec.name, type: spec.type, dims: spec.dims, area: +area.toFixed(1), mpp: det.mpp, mppY: det.mppY, plan };
}

/** Dời đồ chắn lối cửa: dò vùng trước/sau mỗi cửa, đồ nào lấn vào thì trượt dọc theo lưng (sát tường), không được thì thu hẹp / bỏ */
function clearDoorways(plan, unitId = '') {
  const zones = [];
  for (const o of plan.openings) {
    if (o.type === 'window') continue;
    const w = plan.walls.find((x) => x.id === o.wallId);
    if (!w) continue;
    const L = wallLength(w);
    const ux = (w.b.x - w.a.x) / L, uy = (w.b.y - w.a.y) / L, nx = -uy, ny = ux;
    const cx = w.a.x + (w.b.x - w.a.x) * o.t, cy = w.a.y + (w.b.y - w.a.y) * o.t;
    // Phía cánh cửa mở vào (+n, hoặc -n nếu mở ra) cần chừa bằng bề rộng cánh; phía kia và cửa lùa chừa lối đi 0,5 m
    const swing = o.swingOut ? -1 : 1;
    for (const sd of [-1, 1]) {
      const depth = o.type === 'door' && sd === swing ? Math.min(0.95, o.width + 0.05) : 0.5;
      zones.push({ cx: cx + nx * sd * (w.thickness / 2 + depth / 2), cy: cy + ny * sd * (w.thickness / 2 + depth / 2), ux, uy, hw: o.width / 2 + 0.05, hd: depth / 2 });
    }
  }
  const inZone = (p) => zones.some((z) => { const dx = p.x - z.cx, dy = p.y - z.cy; return Math.abs(dx * z.ux + dy * z.uy) < z.hw && Math.abs(-dx * z.uy + dy * z.ux) < z.hd; });
  const size = (f) => ({ w: f.w ?? CATALOG_MAP[f.type]?.w ?? 1, d: f.d ?? CATALOG_MAP[f.type]?.d ?? 1 });
  const samples = (f, x = f.x, y = f.y, w = size(f).w, d = size(f).d) => {
    const out = [], a = (f.rot * Math.PI) / 180;
    for (let i = 0; i <= 4; i++) for (let j = 0; j <= 4; j++) {
      const p = rotatePoint({ x: (i / 4 - 0.5) * w * 0.96, y: (j / 4 - 0.5) * d * 0.96 }, a);
      out.push({ x: x + p.x, y: y + p.y });
    }
    return out;
  };
  const roomOf = (p) => plan.rooms.find((r) => pointInPolygon(p, r.points));
  const solid = plan.furniture.filter((f) => f.type !== 'rug');
  for (const f of solid) {
    if (!samples(f).some(inZone)) continue;
    const room = roomOf(f);
    const a = (f.rot * Math.PI) / 180, ax = Math.cos(a), ay = Math.sin(a);
    const okAt = (x, y, w) => {
      const pts = samples(f, x, y, w);
      if (pts.some(inZone)) return false;
      if (room && !pts.every((p) => pointInPolygon(p, room.points))) return false;
      const z = size(f);
      return !solid.some((g) => g !== f && samples(g).some((p) => pointInRotRect(p, x, y, w, z.d, f.rot)));
    };
    let done = false;
    for (let k = 1; k <= 30 && !done; k++)
      for (const sg of [1, -1]) {
        const x = +(f.x + ax * sg * k * 0.1).toFixed(3), y = +(f.y + ay * sg * k * 0.1).toFixed(3);
        if (okAt(x, y, size(f).w)) { f.x = x; f.y = y; done = true; break; }
      }
    for (let s = 0.9; s >= 0.55 && !done; s -= 0.05) {
      const w = +(size(f).w * s).toFixed(2);
      for (let k = 0; k <= 30 && !done; k++)
        for (const sg of [1, -1]) {
          const x = +(f.x + ax * sg * k * 0.1).toFixed(3), y = +(f.y + ay * sg * k * 0.1).toFixed(3);
          if (okAt(x, y, w)) { f.x = x; f.y = y; f.w = w; done = true; break; }
        }
    }
    // Đồ chính (giường, sofa, tủ, bếp…) không bao giờ bỏ; chỉ đồ nhỏ mới được bỏ khi không còn chỗ
    const small = ['plant', 'chair', 'armchair', 'nightstand', 'roundTable', 'floorLamp', 'officeChair', 'coffeeTable'];
    if (!done && small.includes(f.type)) f.removed = true;
    console.log(`${unitId}: dời ${f.type} @${f.x.toFixed(2)},${f.y.toFixed(2)} (${done ? 'đã dời' : f.removed ? 'bỏ' : 'giữ nguyên – không còn chỗ'})`);
  }
  plan.furniture = plan.furniture.filter((f) => !f.removed);
}

function addFurniture(plan, spec, P) {
  for (const [type, x, y, rot = 0, opt = {}] of spec.furniture) {
    const { nightstands, ...size } = opt;
    const p = P([x, y]);
    plan.furniture.push({ id: uid(), type, x: p.x, y: p.y, rot, ...size });
    if (nightstands) {
      const def = CATALOG_MAP[type];
      const w = size.w ?? def.w, d = size.d ?? def.d;
      for (const s of [-1, 1]) {
        const off = rotatePoint({ x: s * (w / 2 + 0.3), y: -d / 2 + 0.22 }, (rot * Math.PI) / 180);
        plan.furniture.push({ id: uid(), type: 'nightstand', x: +(p.x + off.x).toFixed(3), y: +(p.y + off.y).toFixed(3), rot });
      }
    }
  }
  clearDoorways(plan, spec.id);
}

export { UNIT_SPECS };

/** Căn sân vườn (tầng 3, trên mái khối đế): lấy căn gốc, thêm sân vườn phía lô gia có tường lửng, cỏ, cây, bàn ghế ngoài trời */
export function gardenUnit(base, spec) {
  const plan = JSON.parse(JSON.stringify(base.plan));
  const xs = plan.walls.flatMap((w) => [w.a.x, w.b.x]), ys = plan.walls.flatMap((w) => [w.a.y, w.b.y]);
  const bb = { x0: Math.min(...xs), y0: Math.min(...ys), x1: Math.max(...xs), y1: Math.max(...ys) };
  const lg = plan.rooms.find((r) => /lô gia/i.test(r.name)) || plan.rooms[0];
  const c = { x: lg.points.reduce((s, p) => s + p.x, 0) / lg.points.length, y: lg.points.reduce((s, p) => s + p.y, 0) / lg.points.length };
  const side = Object.entries({ top: c.y - bb.y0, bottom: bb.y1 - c.y, left: c.x - bb.x0, right: bb.x1 - c.x }).sort((a, b) => a[1] - b[1])[0][0];
  const D = spec.garden.depth || 3;
  // Hệ toạ độ cục bộ của sân: u dọc mép mặt tiền, v hướng ra ngoài
  const L = side === 'top' || side === 'bottom' ? bb.x1 - bb.x0 : bb.y1 - bb.y0;
  const P = (u, v) => side === 'top' ? { x: bb.x0 + u, y: bb.y0 - v } : side === 'bottom' ? { x: bb.x0 + u, y: bb.y1 + v } : side === 'left' ? { x: bb.x0 - v, y: bb.y0 + u } : { x: bb.x1 + v, y: bb.y0 + u };
  const wall = (a, b) => plan.walls.push({ id: uid(), a: P(...a), b: P(...b), thickness: 0.12, height: 0.95 });
  wall([0, 0], [0, D]); wall([0, D], [L, D]); wall([L, D], [L, 0]);
  plan.rooms.push({ id: uid(), name: 'Sân vườn', floor: 'grass', points: [P(0, 0), P(L, 0), P(L, D), P(0, D)] });
  const rotOut = { top: 0, bottom: 180, left: 270, right: 90 }[side];
  const add = (type, u, v, rot = 0, extra = {}) => { const p = P(u, v); plan.furniture.push({ id: uid(), type, x: +p.x.toFixed(3), y: +p.y.toFixed(3), rot, ...extra }); };
  // Bồn cây dọc tường lửng phía ngoài và hai đầu
  for (let u = 0.5; u < L - 0.3; u += 1.1) add('plant', u, D - 0.4, 0, { h: 0.9 + ((u * 7) % 3) * 0.25 });
  add('plant', 0.45, D * 0.45); add('plant', L - 0.45, D * 0.45);
  // Bàn trà ngoài trời + 2 ghế bành, thêm ghế nằm nếu sân rộng
  const cu = L * 0.62, cv = D * 0.48;
  add('roundTable', cu, cv, 0, { w: 0.6, d: 0.6 });
  add('armchair', cu - 0.8, cv, (rotOut + 90) % 360, { w: 0.7, d: 0.7 });
  add('armchair', cu + 0.8, cv, (rotOut + 270) % 360, { w: 0.7, d: 0.7 });
  if (L > 7) add('rug', L * 0.25, cv, 0, { w: 1.8, d: 1.4 });
  const dims = side === 'top' || side === 'bottom' ? [base.dims[0], +(base.dims[1] + D).toFixed(2)] : [+(base.dims[0] + D).toFixed(2), base.dims[1]];
  return { ...base, id: spec.id, name: spec.name, type: spec.type, dims, garden: +(L * D).toFixed(1), plan };
}
