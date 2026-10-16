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
  // Mặt gắn sân = cạnh ngoài có lan can của lô gia (mặt tiền); không có thì lấy cạnh gần lô gia nhất
  const nearSide = (pt) => Object.entries({ top: pt.y - bb.y0, bottom: bb.y1 - pt.y, left: pt.x - bb.x0, right: bb.x1 - pt.x }).sort((a, b) => a[1] - b[1])[0];
  const score = { top: 0, bottom: 0, left: 0, right: 0 };
  for (const op of plan.openings) {
    if (op.type !== 'window' || (op.sill || 0) > 0.1 || op.height > 1.3) continue;
    const w = plan.walls.find((x) => x.id === op.wallId);
    if (!w) continue;
    const pt = { x: w.a.x + (w.b.x - w.a.x) * op.t, y: w.a.y + (w.b.y - w.a.y) * op.t };
    const [sd, dist] = nearSide(pt);
    if (dist < 0.4) score[sd] += op.width;
  }
  const best = Object.entries(score).sort((a, b) => b[1] - a[1])[0];
  const side = spec.garden.side || (best[1] > 0 ? best[0] : nearSide(c)[0]);
  let D = spec.garden.depth || 3;
  // Hệ toạ độ cục bộ của sân: u dọc mép mặt tiền, v hướng ra ngoài
  const onEdge = (pt) => side === 'top' ? Math.abs(pt.y - bb.y0) < 0.35 : side === 'bottom' ? Math.abs(pt.y - bb.y1) < 0.35 : side === 'left' ? Math.abs(pt.x - bb.x0) < 0.35 : Math.abs(pt.x - bb.x1) < 0.35;
  // Sân chỉ chạy dọc đoạn tường thật của căn ở mặt đó (căn chữ L không bị sân thò ra ngoài phần khuyết)
  const horiz = side === 'top' || side === 'bottom';
  const along = (pt) => (horiz ? pt.x : pt.y);
  const depthOf = (pt) => side === 'top' ? pt.y - bb.y0 : side === 'bottom' ? bb.y1 - pt.y : side === 'left' ? pt.x - bb.x0 : bb.x1 - pt.x;
  // các phòng chạm mép đó (tính cả góc kính bo cong) → khoảng chạy dọc mép của chúng
  const edgeRooms = plan.rooms.filter((r) => Math.min(...r.points.map(depthOf)) < 0.5);
  const pts = edgeRooms.flatMap((r) => r.points);
  const e0 = Math.min(...pts.map(along)) - 0.1, e1 = Math.max(...pts.map(along)) + 0.1;
  const o = horiz ? e0 - bb.x0 : e0 - bb.y0;
  const L = e1 - e0;
  // Độ sâu sân tự tính cho diện tích thông thủy sân vườn khớp bảng của chủ đầu tư (spec.garden.area)
  if (spec.garden.area) {
    let L2b = 0;
    if (spec.garden.wrap) {
      const w2 = spec.garden.wrap, hz = w2 === 'top' || w2 === 'bottom';
      const dp = (pt) => w2 === 'top' ? pt.y - bb.y0 : w2 === 'bottom' ? bb.y1 - pt.y : w2 === 'left' ? pt.x - bb.x0 : bb.x1 - pt.x;
      const rp2 = plan.rooms.filter((r) => Math.min(...r.points.map(dp)) < 0.5).flatMap((r) => r.points).map((q) => (hz ? q.x : q.y));
      L2b = Math.max(...rp2) - Math.min(...rp2) + 0.2;
    }
    const area = (d) => L * d + (spec.garden.wrap ? (L2b + d) * d - (1 - Math.PI / 4) * d * d : 0);
    let lo = 0.8, hi = 4.5;
    for (let i = 0; i < 40; i++) { const m = (lo + hi) / 2; if (area(m) > spec.garden.area) hi = m; else lo = m; }
    D = +lo.toFixed(2);
  }
  const P = (u, v) => side === 'top' ? { x: bb.x0 + o + u, y: bb.y0 - v } : side === 'bottom' ? { x: bb.x0 + o + u, y: bb.y1 + v } : side === 'left' ? { x: bb.x0 - v, y: bb.y0 + o + u } : { x: bb.x1 + v, y: bb.y0 + o + u };
  // Bỏ tường + lan can giữa lô gia và sân vườn: lô gia thông thẳng ra sân (không còn hàng thanh rào)
  const inward = { top: [0, 0.3], bottom: [0, -0.3], left: [0.3, 0], right: [-0.3, 0] }[side];
  const lgPoly = lg.points;
  const drop = new Set(plan.walls.filter((w) => {
    if (!onEdge(w.a) || !onEdge(w.b)) return false;
    const m = { x: (w.a.x + w.b.x) / 2 + inward[0], y: (w.a.y + w.b.y) / 2 + inward[1] };
    return pointInPolygon(m, lgPoly);
  }).map((w) => w.id));
  plan.walls = plan.walls.filter((w) => !drop.has(w.id));
  plan.openings = plan.openings.filter((o) => !drop.has(o.wallId));
  // Tường mép dài liền cả phòng khác: chỉ khoét đoạn lan can trước lô gia thành lối thông trống
  for (const o of plan.openings) {
    const w = plan.walls.find((x) => x.id === o.wallId);
    if (!w || !onEdge(w.a) || !onEdge(w.b) || o.type !== 'window' || (o.sill || 0) > 0.1 || o.height > 1.3) continue;
    const m = { x: w.a.x + (w.b.x - w.a.x) * o.t + inward[0], y: w.a.y + (w.b.y - w.a.y) * o.t + inward[1] };
    if (pointInPolygon(m, lgPoly)) { o.gap = true; o.sill = 0; o.height = 2.8; }
  }
  const wall = (a, b) => plan.walls.push({ id: uid(), a: P(...a), b: P(...b), thickness: 0.12, height: 0.95 });
  const wrap = spec.garden.wrap; // mặt thứ hai sân ôm quanh (vd. căn góc 3PN: dọc dãy phòng ngủ + mặt lô gia)
  const cornerAtStart = wrap === 'top' || wrap === 'left';
  if (!(wrap && cornerAtStart)) wall([0, 0], [0, D]);
  wall([0, D], [L, D]);
  if (!(wrap && !cornerAtStart)) wall([L, D], [L, 0]);
  plan.rooms.push({ id: uid(), name: 'Sân vườn', floor: 'grass', points: [P(0, 0), P(L, 0), P(L, D), P(0, D)] });
  const rotOut = { top: 0, bottom: 180, left: 270, right: 90 }[side];
  const add = (type, u, v, rot = 0, extra = {}) => { const p = P(u, v); plan.furniture.push({ id: uid(), type, x: +p.x.toFixed(3), y: +p.y.toFixed(3), rot, ...extra }); };
  const rotU = side === 'top' || side === 'bottom' ? 0 : 90; // xoay để cạnh dài của đồ chạy dọc mép sân
  // Sân vườn kiểu resort: luống cây nhiệt đới + hoa dọc tường lửng, viền sỏi trắng, cây dừa ở góc,
  // sàn gỗ có 2 ghế nằm + dù che, lối đá bước trên cỏ từ cửa nhà ra sàn gỗ
  // sân hẹp: luống cây mỏng hơn, bỏ sàn gỗ / ghế nằm cho khỏi chật
  const bedD = D < 1.6 ? 0.4 : 0.6;
  add('shrubBed', L / 2, D - bedD / 2 - 0.1, rotU, { w: L - 0.3, d: bedD });
  if (D >= 1.6) add('pebbles', L / 2, D - bedD - 0.22, rotU, { w: L - 1.2, d: 0.24 });
  if (D >= 2.0) add('shrubBed', L - 0.36, (D - 0.7) / 2, (rotU + 90) % 360, { w: D - 1.0, d: 0.5 });
  add('palm', 0.6, D - 0.55, 0, { h: D < 1.8 ? 2.4 : 3.0 });
  let dw = 0;
  if (D >= 2.3) {
    dw = Math.min(2.9, L * 0.45); const dd = D - 1.05;
    add('deck', 0.1 + dw / 2, 0.15 + dd / 2, rotU, { w: dw, d: dd });
    add('lounger', 0.1 + dw * 0.3, 0.15 + dd / 2, (rotOut + 180) % 360, { w: 0.68, d: Math.min(1.8, dd - 0.1) });
    add('lounger', 0.1 + dw * 0.72, 0.15 + dd / 2, (rotOut + 180) % 360, { w: 0.68, d: Math.min(1.8, dd - 0.1) });
    add('shrubBed', L - 0.36, D - 0.4, rotU, { w: 0.6, d: 0.6 });
  } else if (D >= 1.7 && L > 3 && !spec.garden.wrap) {
    // sân vừa: bộ bàn trà nhỏ 2 ghế
    add('roundTable', 1.6, (D - bedD) / 2, 0, { w: 0.55, d: 0.55 });
    for (const [du, r] of [[-0.55, 90], [0.55, 270]]) add('chair', 1.6 + du, (D - bedD) / 2, (r + rotOut) % 360, { color: '#cbb894' });
    dw = 2.3;
  }
  let k = 0;
  if (D >= 1.3) for (let u = dw + 0.55; u < L - 0.9; u += 0.52) add('steppingStone', u, Math.min(0.45, (D - bedD) / 2) + (k++ % 2 ? 0.05 : -0.05), rotU, { w: 0.46, d: 0.36 });
  if (wrap) {
    // Dải sân thứ hai: chạy dọc mép 'wrap', kéo dài qua ô góc để nối liền với dải chính
    const h2 = wrap === 'top' || wrap === 'bottom';
    const al2 = (pt) => (h2 ? pt.x : pt.y);
    const dep2 = (pt) => wrap === 'top' ? pt.y - bb.y0 : wrap === 'bottom' ? bb.y1 - pt.y : wrap === 'left' ? pt.x - bb.x0 : bb.x1 - pt.x;
    const rp = plan.rooms.filter((r) => r.name !== 'Sân vườn' && Math.min(...r.points.map(dep2)) < 0.5).flatMap((r) => r.points);
    let a0 = Math.min(...rp.map(al2)) - 0.1, a1 = Math.max(...rp.map(al2)) + 0.1;
    // phía dải chính: kéo tới mép ngoài của dải chính
    const mainOuter = side === 'right' || side === 'bottom' ? (h2 ? bb.x1 : bb.y1) + D : (h2 ? bb.x0 : bb.y0) - D;
    if (side === 'right' || side === 'bottom') a1 = mainOuter; else a0 = mainOuter;
    const L2 = a1 - a0;
    const Q = (u, v) => wrap === 'top' ? { x: a0 + u, y: bb.y0 - v } : wrap === 'bottom' ? { x: a0 + u, y: bb.y1 + v } : wrap === 'left' ? { x: bb.x0 - v, y: a0 + u } : { x: bb.x1 + v, y: a0 + u };
    const wall2 = (p0, p1) => plan.walls.push({ id: uid(), a: Q(...p0), b: Q(...p1), thickness: 0.12, height: 0.95 });
    const farAtStart = side === 'right' || side === 'bottom';
    if (farAtStart) wall2([0, 0], [0, D]); else wall2([L2, D], [L2, 0]);
    // Góc ngoài nơi hai dải gặp nhau: bo tròn bán kính = độ sâu sân (như góc kính bo của toà)
    const R = D, N = 10;
    const arc = [];
    for (let i = 0; i <= N; i++) {
      const t = (i / N) * Math.PI / 2;
      arc.push(farAtStart ? [L2 - R + R * Math.sin(t), R * Math.cos(t)] : [R - R * Math.sin(t), R * Math.cos(t)]);
    }
    if (farAtStart) wall2([0, D], [L2 - R, D]); else wall2([R, D], [L2, D]);
    for (let i = 0; i < N; i++) wall2(arc[i], arc[i + 1]);
    const poly = farAtStart ? [[0, 0], [L2, 0], ...arc.slice().reverse(), [0, D]] : [[0, 0], [L2, 0], [L2, D], ...arc];
    plan.rooms.push({ id: uid(), name: 'Sân vườn', floor: 'grass', points: poly.map((q) => Q(...q)) });
    const add2 = (type, u, v, rot = 0, extra = {}) => { const p = Q(u, v); plan.furniture.push({ id: uid(), type, x: +p.x.toFixed(3), y: +p.y.toFixed(3), rot, ...extra }); };
    const rU2 = h2 ? 0 : 90, rOut2 = { top: 0, bottom: 180, left: 270, right: 90 }[wrap];
    // luống hoa dọc lan can ngoài, viền sỏi, ghế nằm, bàn tròn 4 ghế ở ô góc, lối đá
    const sL = L2 - R - 0.2, sC = farAtStart ? sL / 2 + 0.1 : R + sL / 2 + 0.1;
    add2('shrubBed', sC, D - 0.4, rU2, { w: sL, d: 0.6 });
    add2('pebbles', sC, D - 0.82, rU2, { w: sL - 0.9, d: 0.24 });
    // luống hoa + viền sỏi chạy theo cung bo
    const nb = 7;
    for (let i = 0; i < nb; i++) {
      const t = ((i + 0.5) / nb) * Math.PI / 2, deg = (t * 180) / Math.PI;
      const pos = (r) => farAtStart ? [L2 - R + r * Math.sin(t), r * Math.cos(t)] : [R - r * Math.sin(t), r * Math.cos(t)];
      const rot = (rU2 + (farAtStart ? deg : -deg) + 360) % 360;
      add2('shrubBed', ...pos(R - 0.4), rot, { w: (Math.PI / 2 * (R - 0.4)) / nb + 0.06, d: 0.6 });
      add2('pebbles', ...pos(R - 0.82), rot, { w: (Math.PI / 2 * (R - 0.82)) / nb + 0.04, d: 0.24 });
    }
    const far = farAtStart ? 0.9 : L2 - 0.9, cor = farAtStart ? L2 - D / 2 : D / 2;
    add2('palm', far, D - 0.75, 0, { h: 3.2 });
    if (D >= 2.3) for (const k of [0.3, 0.55]) add2('lounger', farAtStart ? L2 * k : L2 * (1 - k), (D - 0.7) / 2 + 0.05, (rOut2 + 180) % 360, { w: 0.68, d: Math.min(1.8, D - 1.0) });
    // bàn tròn 4 ghế đặt giữa ô góc bo, cách luống hoa
    const rr = Math.max(0.9, R - 1.75), tu = farAtStart ? L2 - R + rr * Math.SQRT1_2 : R - rr * Math.SQRT1_2, tv = rr * Math.SQRT1_2;
    add2('roundTable', tu, tv, 0, { w: 0.75, d: 0.75 });
    for (const [du, dv, r] of [[-0.62, 0, 90], [0.62, 0, 270], [0, -0.62, 180], [0, 0.62, 0]]) add2('chair', tu + du, tv + dv, (r + rOut2) % 360, { color: '#cbb894' });
  }
  const dims = side === 'top' || side === 'bottom' ? [base.dims[0], +(base.dims[1] + D).toFixed(2)] : [+(base.dims[0] + D).toFixed(2), base.dims[1]];
  return { ...base, id: spec.id, name: spec.name, type: spec.type, dims, garden: +(L * D).toFixed(1), plan };
}
