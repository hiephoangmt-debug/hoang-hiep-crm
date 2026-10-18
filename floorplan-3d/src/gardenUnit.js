// Dựng căn sân vườn từ căn gốc (dùng khi dựng sẵn căn mẫu và khi xem từng mã căn theo diện tích sân của tầng)
import { wallLength, pointInPolygon } from './geom.js';
import { uid } from './model.js';

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
  // spec.garden.notch = [x0, y0, x1, y1] (m, so với góc khung căn): phần khuyết của căn chữ L cũng là sân (vd. căn 29/32 tầng 3)
  const notch = spec.garden.notch && horiz ? spec.garden.notch : null;
  // spec.garden.span = [u0, u1] (m, dọc mép tính từ góc khung căn): sân chỉ chạy một đoạn mép như bản vẽ (vd. căn 28 tầng 3)
  const sp = spec.garden.span, base0 = horiz ? bb.x0 : bb.y0;
  const e0 = sp ? base0 + sp[0] : notch ? bb.x0 + notch[0] : Math.min(...pts.map(along)) - 0.1, e1 = sp ? base0 + sp[1] : Math.max(...pts.map(along)) + 0.1;
  const notchArea = notch ? (notch[2] - notch[0]) * (notch[3] - notch[1]) : 0;
  const o = horiz ? e0 - bb.x0 : e0 - bb.y0;
  const L = e1 - e0;
  // bán kính bo góc ngoài: theo tỉ lệ chiều sâu sân như bản vẽ (spec.garden.radius), mặc định bo trọn
  const gRad = (d) => (spec.garden.radius ? d * spec.garden.radius : Math.min(d, 3));
  // Độ sâu sân tự tính cho diện tích thông thủy sân vườn khớp bảng của chủ đầu tư (spec.garden.area)
  if (spec.garden.area) {
    let L2b = 0;
    if (spec.garden.wrap) {
      const w2 = spec.garden.wrap, hz = w2 === 'top' || w2 === 'bottom';
      const dp = (pt) => w2 === 'top' ? pt.y - bb.y0 : w2 === 'bottom' ? bb.y1 - pt.y : w2 === 'left' ? pt.x - bb.x0 : bb.x1 - pt.x;
      const rp2 = plan.rooms.filter((r) => Math.min(...r.points.map(dp)) < 0.5).flatMap((r) => r.points).map((q) => (hz ? q.x : q.y));
      L2b = Math.max(...rp2) - Math.min(...rp2) + 0.2;
    }
    const area = (d) => notchArea + L * d + (spec.garden.bevel === 'start' ? (d * d) / 2 : 0) + (spec.garden.wrap ? (L2b + d) * d - (1 - Math.PI / 4) * d * d : 0) - (spec.garden.round ? (1 - Math.PI / 4) * gRad(d) ** 2 : 0);
    let lo = 0.8, hi = 8;
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
  // Lan can sân vườn bằng kính (như bản vẽ): gờ bê tông thấp + tấm kính liền suốt chiều dài
  const wall = (a, b) => {
    const w = { id: uid(), a: P(...a), b: P(...b), thickness: 0.12, height: 1.1 };
    plan.walls.push(w);
    const len = wallLength(w);
    if (len > 0.2) plan.openings.push({ id: uid(), wallId: w.id, type: 'window', t: 0.5, width: +(len - 0.02).toFixed(3), sill: 0.15, height: 0.95, glass: true });
  };
  const wrap = spec.garden.wrap; // mặt thứ hai sân ôm quanh (vd. căn góc 3PN: dọc dãy phòng ngủ + mặt lô gia)
  const cornerAtStart = wrap === 'top' || wrap === 'left';
  // Góc căn bo cong (góc kính bo của toà) → bo tròn góc ngoài của sân cùng phía
  const near = (u) => plan.rooms.some((rm) => rm.points.some((q) => Math.hypot(q.x - P(u, 0).x, q.y - P(u, 0).y) < 0.6));
  // bo góc ngoài của sân theo bản vẽ: phía mép sàn lùi vào khu căn giữa (vd. căn 12 bo trái, căn 17 bo phải)
  const roundStart = !wrap && spec.garden.round === 'start', roundEnd = !wrap && spec.garden.round === 'end';
  void near;
  const RR = gRad(D), NA = 8;
  const arcPts = (start) => { const out = []; for (let i = 0; i <= NA; i++) { const t = (i / NA) * Math.PI / 2; out.push(start ? [RR - RR * Math.sin(t), D - RR + RR * Math.cos(t)] : [L - RR + RR * Math.sin(t), D - RR + RR * Math.cos(t)]); } return out; };
  // spec.garden.bevel = 'start': đầu sân cắt chéo 45° loe ra ngoài (mép ngoài dài hơn mép trong một đoạn = chiều sâu sân), như bản vẽ căn 28
  const bevS = !wrap && spec.garden.bevel === 'start';
  if (bevS) wall([0, 0], [-D, D]);
  else if (!(wrap && cornerAtStart)) wall([0, 0], [0, roundStart ? D - RR : D]);
  wall([bevS ? -D : roundStart ? RR : 0, D], [roundEnd ? L - RR : L, D]);
  if (!(wrap && !cornerAtStart)) wall([L, roundEnd ? D - RR : D], [L, 0]);
  const aS = roundStart ? arcPts(true) : null, aE = roundEnd ? arcPts(false) : null;
  for (const a of [aS, aE]) if (a) for (let i = 0; i < NA; i++) wall(a[i], a[i + 1]);
  const gp = [[0, 0], [L, 0], ...(aE ? aE.slice().reverse() : [[L, D]]), ...(aS ? aS.slice().reverse().map((q) => q).reverse() : [[bevS ? -D : 0, D]])];
  if (notch) {
    // ô khuyết: nền cỏ + lan can kính phía ngoài, vài chậu cây
    const Q = (x, y) => ({ x: bb.x0 + x, y: bb.y0 + y });
    plan.rooms.push({ id: uid(), name: 'Ban công sân vườn', floor: 'grass', points: [Q(notch[0], notch[1]), Q(notch[2], notch[1]), Q(notch[2], notch[3]), Q(notch[0], notch[3])] });
    const nw = { id: uid(), a: Q(notch[0], notch[1]), b: Q(notch[0], notch[3]), thickness: 0.12, height: 1.1 };
    plan.walls.push(nw);
    plan.openings.push({ id: uid(), wallId: nw.id, type: 'window', t: 0.5, width: +(notch[3] - notch[1] - 0.02).toFixed(3), sill: 0.15, height: 0.95, glass: true });
    for (const [fx, fy] of [[0.45, 0.6], [0.45, (notch[1] + notch[3]) / 2], [0.45, notch[3] - 0.5]]) plan.furniture.push({ id: uid(), type: 'shrubBed', x: bb.x0 + notch[0] + fx, y: bb.y0 + fy, rot: 90, w: 0.9, d: 0.6 });
  }
  plan.rooms.push({ id: uid(), name: 'Ban công sân vườn', floor: 'grass', points: (aS ? [[0, 0], [L, 0], ...(aE ? aE.slice().reverse() : [[L, D]]), ...aS] : gp).map((q) => P(...q)) });
  const rotOut = { top: 0, bottom: 180, left: 270, right: 90 }[side];
  const add = (type, u, v, rot = 0, extra = {}) => { const p = P(u, v); plan.furniture.push({ id: uid(), type, x: +p.x.toFixed(3), y: +p.y.toFixed(3), rot, ...extra }); };
  const rotU = side === 'top' || side === 'bottom' ? 0 : 90; // xoay để cạnh dài của đồ chạy dọc mép sân
  // Sân vườn kiểu resort: luống cây nhiệt đới + hoa dọc tường lửng, viền sỏi trắng, cây dừa ở góc,
  // sàn gỗ có 2 ghế nằm + dù che, lối đá bước trên cỏ từ cửa nhà ra sàn gỗ
  // sân hẹp: luống cây mỏng hơn, bỏ sàn gỗ / ghế nằm cho khỏi chật
  const bedD = D < 1.6 ? 0.4 : 0.6;
  const sb0 = roundStart ? RR : 0.15, sb1 = roundEnd ? L - RR : L - 0.15;
  add('shrubBed', (sb0 + sb1) / 2, D - bedD / 2 - 0.1, rotU, { w: sb1 - sb0, d: bedD });
  if (D >= 1.6) add('pebbles', (sb0 + sb1) / 2, D - bedD - 0.22, rotU, { w: sb1 - sb0 - 0.9, d: 0.24 });
  // luống cây chạy theo cung bo
  for (const [on, st] of [[roundStart, true], [roundEnd, false]]) if (on) for (let i = 0; i < 5; i++) {
    const t = ((i + 0.5) / 5) * Math.PI / 2, rr = RR - bedD / 2 - 0.1;
    const u = st ? RR - rr * Math.sin(t) : L - RR + rr * Math.sin(t), v = D - RR + rr * Math.cos(t);
    add('shrubBed', u, v, (rotU + (st ? -1 : 1) * (t * 180) / Math.PI + 360) % 360, { w: (Math.PI / 2 * rr) / 5 + 0.06, d: bedD });
  }
  if (D >= 2.0) add('shrubBed', L - 0.36, (D - 0.7) / 2, (rotU + 90) % 360, { w: D - 1.0, d: 0.5 });
  add('palm', roundStart ? RR + 0.5 : 0.6, D - 0.55, 0, { h: D < 1.8 ? 2.4 : 3.0 });
  if (spec.garden.laundry) add('washer', L - 0.55, 0.45, (rotOut + 180) % 360); // ô giặt phơi góc sân như bản vẽ
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
    const rp = plan.rooms.filter((r) => !/sân vườn/i.test(r.name) && Math.min(...r.points.map(dep2)) < 0.5).flatMap((r) => r.points);
    let a0 = Math.min(...rp.map(al2)) - 0.1, a1 = Math.max(...rp.map(al2)) + 0.1;
    // phía dải chính: kéo tới mép ngoài của dải chính
    const mainOuter = side === 'right' || side === 'bottom' ? (h2 ? bb.x1 : bb.y1) + D : (h2 ? bb.x0 : bb.y0) - D;
    if (side === 'right' || side === 'bottom') a1 = mainOuter; else a0 = mainOuter;
    const L2 = a1 - a0;
    const Q = (u, v) => wrap === 'top' ? { x: a0 + u, y: bb.y0 - v } : wrap === 'bottom' ? { x: a0 + u, y: bb.y1 + v } : wrap === 'left' ? { x: bb.x0 - v, y: a0 + u } : { x: bb.x1 + v, y: a0 + u };
    const wall2 = (p0, p1) => {
      const w = { id: uid(), a: Q(...p0), b: Q(...p1), thickness: 0.12, height: 1.1 };
      plan.walls.push(w);
      const len = wallLength(w);
      if (len > 0.2) plan.openings.push({ id: uid(), wallId: w.id, type: 'window', t: 0.5, width: +(len - 0.02).toFixed(3), sill: 0.15, height: 0.95, glass: true });
    };
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
    plan.rooms.push({ id: uid(), name: 'Ban công sân vườn', floor: 'grass', points: poly.map((q) => Q(...q)) });
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
  return { ...base, id: spec.id, name: spec.name, type: spec.type, dims, garden: +(L * D).toFixed(1), gardenSpec: spec.garden, plan };
}
