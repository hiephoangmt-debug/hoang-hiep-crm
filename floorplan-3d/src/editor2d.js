// Trình vẽ mặt bằng 2D trên canvas: vẽ tường/phòng, đặt cửa, kéo thả nội thất, bắt điểm, kích thước.
import { uid, FLOOR_COLORS_2D } from './model.js';
import { CATALOG_MAP, drawFurniture2D } from './furniture.js';
import {
  dist, wallLength, closestOnSegment, openingRange, pointInPolygon, polygonArea, labelPoint,
  pointInRotRect, rotatePoint, planBounds, fmt,
} from './geom.js';

const SNAP = 0.05;
const snapV = (v, s = SNAP) => Math.round(v / s) * s;
const EPS = 1e-3;
const OPENING_DEFAULTS = {
  door: { width: 0.9, height: 2.1, sill: 0 },
  window: { width: 1.2, height: 1.3, sill: 0.9 },
  slide: { width: 2.0, height: 2.3, sill: 0 },
};

export class Editor2D extends EventTarget {
  constructor(canvas, store) {
    super();
    this.canvas = canvas;
    this.ctx = canvas.getContext('2d');
    this.store = store;
    this.view = { scale: 50, ox: 80, oy: 80 };
    this.tool = 'select';
    this.furnitureType = 'sofa';
    this.ghostRot = 0;
    this.selection = null;
    this.hover = null;
    this.chain = null; // các điểm khi vẽ tường liên tiếp
    this.poly = null; // các điểm khi vẽ phòng đa giác
    this.drag = null;
    this.mouse = { x: 0, y: 0, sx: 0, sy: 0, inside: false };
    this.guides = [];
    this.showDims = true;
    this.bgImage = null;
    this.calib = null;
    this.bindEvents();
    new ResizeObserver(() => this.resize()).observe(canvas.parentElement);
    this.resize();
    this.loadBackground();
    store.addEventListener('change', () => this.render());
    requestAnimationFrame(() => this.fit());
  }

  get plan() { return this.store.plan; }

  // ---------------- Toạ độ ----------------
  toWorld(sx, sy) { return { x: (sx - this.view.ox) / this.view.scale, y: (sy - this.view.oy) / this.view.scale }; }
  toScreen(p) { return { x: p.x * this.view.scale + this.view.ox, y: p.y * this.view.scale + this.view.oy }; }
  tol(px = 8) { return px / this.view.scale; }

  resize() {
    const r = this.canvas.parentElement.getBoundingClientRect();
    const dpr = window.devicePixelRatio || 1;
    this.canvas.width = Math.max(1, r.width * dpr);
    this.canvas.height = Math.max(1, r.height * dpr);
    this.canvas.style.width = r.width + 'px';
    this.canvas.style.height = r.height + 'px';
    this.dpr = dpr;
    this.render();
  }

  fit() {
    const b = planBounds(this.plan);
    const r = this.canvas.parentElement.getBoundingClientRect();
    const w = Math.max(b.maxX - b.minX, 2), h = Math.max(b.maxY - b.minY, 2);
    const s = Math.min((r.width - 120) / w, (r.height - 120) / h);
    this.view.scale = Math.max(10, Math.min(200, s));
    this.view.ox = r.width / 2 - ((b.minX + b.maxX) / 2) * this.view.scale;
    this.view.oy = r.height / 2 - ((b.minY + b.maxY) / 2) * this.view.scale;
    this.render();
  }

  zoom(f, sx, sy) {
    const r = this.canvas.getBoundingClientRect();
    sx ??= r.width / 2; sy ??= r.height / 2;
    const before = this.toWorld(sx, sy);
    this.view.scale = Math.max(8, Math.min(400, this.view.scale * f));
    this.view.ox = sx - before.x * this.view.scale;
    this.view.oy = sy - before.y * this.view.scale;
    this.render();
  }

  setTool(tool, extra) {
    this.tool = tool;
    if (tool === 'furniture' && extra) this.furnitureType = extra;
    this.chain = null;
    this.poly = null;
    this.calib = null;
    this.canvas.style.cursor = tool === 'select' ? 'default' : 'crosshair';
    this.dispatchEvent(new CustomEvent('tool', { detail: tool }));
    this.render();
  }

  select(sel) {
    this.selection = sel;
    this.dispatchEvent(new CustomEvent('select', { detail: sel }));
    this.render();
  }

  // ---------------- Ảnh nền ----------------
  loadBackground() {
    const bg = this.store.background;
    if (!bg?.src) { this.bgImage = null; this.render(); return; }
    const img = new Image();
    img.onload = () => { this.bgImage = img; bg.w = img.width; bg.h = img.height; this.render(); };
    img.src = bg.src;
  }

  // ---------------- Bắt điểm ----------------
  endpoints(excludeWallId) {
    const pts = [];
    for (const w of this.plan.walls) if (w.id !== excludeWallId) pts.push(w.a, w.b);
    return pts;
  }

  snapPoint(p, { from = null, exclude = null, alt = false, shift = false } = {}) {
    this.guides = [];
    if (alt) return { x: p.x, y: p.y };
    const tol = this.tol(10);
    // Bắt vào đầu tường
    for (const q of this.endpoints(exclude)) if (dist(p, q) < tol) return { x: q.x, y: q.y, snapped: true };
    let r = { x: snapV(p.x), y: snapV(p.y) };
    // Khoá góc 0/45/90 độ khi vẽ tiếp
    if (from) {
      const dx = p.x - from.x, dy = p.y - from.y;
      const L = Math.hypot(dx, dy);
      const ang = Math.atan2(dy, dx);
      const step = Math.PI / 4;
      const sa = Math.round(ang / step) * step;
      if (shift || Math.abs(sa - ang) < 0.09) {
        const len = snapV(L);
        r = { x: from.x + Math.cos(sa) * len, y: from.y + Math.sin(sa) * len };
        if (Math.abs(Math.cos(sa)) < 1e-6) r.x = from.x;
        if (Math.abs(Math.sin(sa)) < 1e-6) r.y = from.y;
      }
    }
    // Bắt vào thân tường
    for (const w of this.plan.walls) {
      if (w.id === exclude) continue;
      const c = closestOnSegment(r, w.a, w.b);
      if (c.d < this.tol(6)) { r = { x: c.point.x, y: c.point.y }; break; }
    }
    // Đường gióng theo đầu tường khác
    const gt = this.tol(6);
    for (const q of this.endpoints(exclude)) {
      if (Math.abs(r.x - q.x) < gt) { r.x = q.x; this.guides.push({ a: q, b: { x: q.x, y: r.y } }); }
      if (Math.abs(r.y - q.y) < gt) { r.y = q.y; this.guides.push({ a: q, b: { x: r.x, y: q.y } }); }
    }
    return r;
  }

  // ---------------- Kiểm tra trúng ----------------
  hitTest(p) {
    const plan = this.plan;
    const tol = this.tol(7);
    // Tay cầm khi đang chọn
    const sel = this.selection;
    if (sel?.kind === 'wall') {
      const w = this.store.wall(sel.id);
      if (w) for (const end of ['a', 'b']) if (dist(p, w[end]) < this.tol(9)) return { kind: 'wallEnd', id: w.id, end };
    }
    if (sel?.kind === 'furniture') {
      const f = plan.furniture.find((x) => x.id === sel.id);
      if (f && dist(p, this.rotHandle(f)) < this.tol(9)) return { kind: 'rotate', id: f.id };
    }
    if (sel?.kind === 'room') {
      const r = plan.rooms.find((x) => x.id === sel.id);
      if (r) for (let i = 0; i < r.points.length; i++) if (dist(p, r.points[i]) < this.tol(8)) return { kind: 'roomPt', id: r.id, index: i };
    }
    for (const op of plan.openings) {
      const w = this.store.wall(op.wallId);
      if (!w) continue;
      const c = closestOnSegment(p, w.a, w.b);
      const [s, e] = openingRange(w, op);
      const u = c.t * wallLength(w);
      if (c.d < w.thickness / 2 + tol && u >= s - tol && u <= e + tol) return { kind: 'opening', id: op.id };
    }
    for (let i = plan.furniture.length - 1; i >= 0; i--) {
      const f = plan.furniture[i];
      const def = CATALOG_MAP[f.type];
      if (def && def.type !== 'rug' && pointInRotRect(p, f.x, f.y, f.w ?? def.w, f.d ?? def.d, f.rot || 0)) return { kind: 'furniture', id: f.id };
    }
    for (const w of plan.walls) if (closestOnSegment(p, w.a, w.b).d < w.thickness / 2 + tol) return { kind: 'wall', id: w.id };
    for (let i = plan.furniture.length - 1; i >= 0; i--) {
      const f = plan.furniture[i];
      const def = CATALOG_MAP[f.type];
      if (def && pointInRotRect(p, f.x, f.y, f.w ?? def.w, f.d ?? def.d, f.rot || 0)) return { kind: 'furniture', id: f.id };
    }
    for (let i = plan.rooms.length - 1; i >= 0; i--) if (pointInPolygon(p, plan.rooms[i].points)) return { kind: 'room', id: plan.rooms[i].id };
    return null;
  }

  rotHandle(f) {
    const def = CATALOG_MAP[f.type];
    const d = f.d ?? def.d;
    const off = rotatePoint({ x: 0, y: -d / 2 - this.tol(22) }, ((f.rot || 0) * Math.PI) / 180);
    return { x: f.x + off.x, y: f.y + off.y };
  }

  nearestWall(p, maxD = 0.6) {
    let best = null;
    for (const w of this.plan.walls) {
      const c = closestOnSegment(p, w.a, w.b);
      if (c.d < maxD && (!best || c.d < best.d)) best = { wall: w, t: c.t, d: c.d, point: c.point };
    }
    return best;
  }

  /** Các điểm (đầu tường, đỉnh phòng) trùng với p — để kéo khớp nối đi cùng */
  jointsAt(p, skip) {
    const refs = [];
    for (const w of this.plan.walls) for (const end of ['a', 'b']) if (w[end] !== skip && dist(w[end], p) < EPS) refs.push(w[end]);
    for (const r of this.plan.rooms) for (const q of r.points) if (dist(q, p) < 0.02) refs.push(q);
    return refs;
  }

  // ---------------- Sự kiện ----------------
  bindEvents() {
    const c = this.canvas;
    c.addEventListener('contextmenu', (e) => e.preventDefault());
    c.addEventListener('wheel', (e) => {
      e.preventDefault();
      const r = c.getBoundingClientRect();
      this.zoom(Math.exp(-e.deltaY * 0.0015), e.clientX - r.left, e.clientY - r.top);
    }, { passive: false });
    c.addEventListener('pointerdown', (e) => this.onDown(e));
    c.addEventListener('pointermove', (e) => this.onMove(e));
    c.addEventListener('pointerup', (e) => this.onUp(e));
    c.addEventListener('pointerleave', () => { this.mouse.inside = false; this.render(); });
    c.addEventListener('dblclick', () => {
      if (this.tool === 'wall') this.finishChain();
      if (this.tool === 'room' && this.poly) this.finishPoly();
    });
    window.addEventListener('keydown', (e) => this.onKey(e));
    window.addEventListener('keyup', (e) => { if (e.code === 'Space') this.spaceDown = false; });
  }

  pos(e) {
    const r = this.canvas.getBoundingClientRect();
    const sx = e.clientX - r.left, sy = e.clientY - r.top;
    return { sx, sy, ...this.toWorld(sx, sy) };
  }

  onKey(e) {
    if (!this.active || ['INPUT', 'SELECT', 'TEXTAREA'].includes(document.activeElement?.tagName)) return;
    const ctrl = e.ctrlKey || e.metaKey;
    if (ctrl && e.key.toLowerCase() === 'z') { e.preventDefault(); e.shiftKey ? this.store.redo() : this.store.undo(); this.validateSelection(); return; }
    if (ctrl && e.key.toLowerCase() === 'y') { e.preventDefault(); this.store.redo(); this.validateSelection(); return; }
    if (ctrl && e.key.toLowerCase() === 'd') { e.preventDefault(); this.duplicate(); return; }
    if (e.code === 'Space') { this.spaceDown = true; return; }
    if (e.key === 'Escape') {
      if (this.chain || this.poly) { this.chain = null; this.poly = null; this.render(); }
      else if (this.tool !== 'select') this.setTool('select');
      else this.select(null);
    }
    if (e.key === 'Enter') { if (this.chain) this.finishChain(); if (this.poly) this.finishPoly(); }
    if (e.key === 'Delete' || e.key === 'Backspace') { e.preventDefault(); this.deleteSelection(); }
    if (e.key.toLowerCase() === 'r') {
      if (this.tool === 'furniture') { this.ghostRot = (this.ghostRot + 90) % 360; this.render(); }
      else this.rotateSelection(e.shiftKey ? -15 : 90);
    }
    if (e.key.toLowerCase() === 'f' && !ctrl && this.selection?.kind === 'opening') this.flipSelection();
    const shortcuts = { v: 'select', w: 'wall', p: 'room', d: 'door', c: 'window' };
    if (!ctrl && shortcuts[e.key.toLowerCase()] && !(e.key.toLowerCase() === 'f')) this.setTool(shortcuts[e.key.toLowerCase()]);
  }

  onDown(e) {
    const p = this.pos(e);
    this.canvas.setPointerCapture(e.pointerId);
    this.mouse = { ...p, inside: true };
    if (e.button === 1 || e.button === 2 || this.spaceDown) {
      this.drag = { kind: 'pan', sx: p.sx, sy: p.sy, ox: this.view.ox, oy: this.view.oy };
      return;
    }
    const plan = this.plan;
    const H = plan.settings;
    switch (this.tool) {
      case 'wall': {
        const q = this.snapPoint(p, { from: this.chain?.at(-1), alt: e.altKey, shift: e.shiftKey });
        if (!this.chain) { this.chain = [q]; break; }
        const last = this.chain.at(-1);
        if (dist(last, q) < 0.05) { this.finishChain(); break; }
        this.store.commit((pl) => pl.walls.push({ id: uid(), a: { ...last }, b: { ...q }, thickness: H.wallThickness }));
        // Khép kín về điểm đầu => kết thúc
        if (this.chain.length > 1 && dist(q, this.chain[0]) < EPS) { this.chain = null; break; }
        this.chain.push(q);
        break;
      }
      case 'room': {
        const q = this.snapPoint(p, { from: this.poly?.at(-1), alt: e.altKey, shift: e.shiftKey });
        if (this.poly) {
          if (this.poly.length > 2 && dist(q, this.poly[0]) < this.tol(10)) { this.finishPoly(); break; }
          this.poly.push(q);
        } else this.drag = { kind: 'roomRect', start: q, end: q };
        break;
      }
      case 'door': case 'window': case 'slide': {
        const nw = this.nearestWall(p);
        if (!nw) break;
        const def = OPENING_DEFAULTS[this.tool];
        const L = wallLength(nw.wall);
        const t = Math.max(def.width / 2 / L, Math.min(1 - def.width / 2 / L, nw.t));
        const op = { id: uid(), wallId: nw.wall.id, type: this.tool, t, ...def, width: Math.min(def.width, L - 0.1) };
        this.store.commit((pl) => pl.openings.push(op));
        this.select({ kind: 'opening', id: op.id });
        break;
      }
      case 'furniture': {
        const def = CATALOG_MAP[this.furnitureType];
        const f = { id: uid(), type: this.furnitureType, x: snapV(p.x), y: snapV(p.y), rot: this.ghostRot };
        this.autoAgainstWall(f, def);
        this.store.commit((pl) => pl.furniture.push(f));
        this.select({ kind: 'furniture', id: f.id });
        if (!e.shiftKey) this.setTool('select');
        break;
      }
      case 'calibrate': {
        const q = { x: p.x, y: p.y };
        if (!this.calib) this.calib = [q];
        else {
          this.calib.push(q);
          this.dispatchEvent(new CustomEvent('calibrate', { detail: this.calib }));
          this.calib = null;
        }
        break;
      }
      case 'movebg': {
        const bg = this.store.background;
        if (bg) this.drag = { kind: 'bg', start: p, x: bg.x, y: bg.y };
        break;
      }
      default: {
        const hit = this.hitTest(p);
        if (!hit) { this.select(null); this.drag = { kind: 'pan', sx: p.sx, sy: p.sy, ox: this.view.ox, oy: this.view.oy }; break; }
        if (hit.kind === 'wallEnd' || hit.kind === 'rotate' || hit.kind === 'roomPt') { /* giữ lựa chọn */ }
        else this.select({ kind: hit.kind, id: hit.id });
        this.store.checkpoint();
        this.drag = { kind: hit.kind, id: hit.id, start: p, moved: false, ...this.dragInit(hit, p) };
      }
    }
    this.render();
  }

  dragInit(hit, p) {
    const plan = this.plan;
    if (hit.kind === 'wallEnd') {
      const w = this.store.wall(hit.id);
      return { end: hit.end, joints: this.jointsAt(w[hit.end], w[hit.end]) };
    }
    if (hit.kind === 'wall') {
      const w = this.store.wall(hit.id);
      return { a0: { ...w.a }, b0: { ...w.b }, ja: this.jointsAt(w.a, w.a).map((r) => [r, { ...r }]), jb: this.jointsAt(w.b, w.b).map((r) => [r, { ...r }]) };
    }
    if (hit.kind === 'furniture') {
      const f = plan.furniture.find((x) => x.id === hit.id);
      return { off: { x: f.x - p.x, y: f.y - p.y } };
    }
    if (hit.kind === 'room') {
      const r = plan.rooms.find((x) => x.id === hit.id);
      return { pts0: r.points.map((q) => ({ ...q })) };
    }
    if (hit.kind === 'roomPt') return { index: hit.index };
    return {};
  }

  onMove(e) {
    const p = this.pos(e);
    this.mouse = { ...p, inside: true, alt: e.altKey, shift: e.shiftKey };
    const d = this.drag;
    if (!d) {
      if (this.tool === 'select') {
        this.hover = this.hitTest(p);
        this.canvas.style.cursor = this.hover ? (this.hover.kind === 'rotate' ? 'grab' : 'move') : 'default';
      }
      this.render();
      return;
    }
    const plan = this.plan;
    d.moved = true;
    switch (d.kind) {
      case 'pan':
        this.view.ox = d.ox + (p.sx - d.sx);
        this.view.oy = d.oy + (p.sy - d.sy);
        this.render();
        return;
      case 'bg': {
        const bg = this.store.background;
        bg.x = d.x + (p.x - d.start.x);
        bg.y = d.y + (p.y - d.start.y);
        this.render();
        return;
      }
      case 'roomRect':
        d.end = this.snapPoint(p, { alt: e.altKey });
        break;
      case 'wallEnd': {
        const w = this.store.wall(d.id);
        const other = w[d.end === 'a' ? 'b' : 'a'];
        const q = this.snapPoint(p, { from: other, exclude: w.id, alt: e.altKey, shift: e.shiftKey });
        w[d.end].x = q.x; w[d.end].y = q.y;
        d.joints.forEach((r) => { r.x = q.x; r.y = q.y; });
        break;
      }
      case 'wall': {
        const w = this.store.wall(d.id);
        const L = dist(d.a0, d.b0) || 1;
        const nx = -(d.b0.y - d.a0.y) / L, ny = (d.b0.x - d.a0.x) / L;
        let k = (p.x - d.start.x) * nx + (p.y - d.start.y) * ny;
        if (!e.altKey) k = snapV(k);
        w.a.x = d.a0.x + nx * k; w.a.y = d.a0.y + ny * k;
        w.b.x = d.b0.x + nx * k; w.b.y = d.b0.y + ny * k;
        d.ja.forEach(([r, r0]) => { r.x = r0.x + nx * k; r.y = r0.y + ny * k; });
        d.jb.forEach(([r, r0]) => { r.x = r0.x + nx * k; r.y = r0.y + ny * k; });
        break;
      }
      case 'opening': {
        const op = plan.openings.find((o) => o.id === d.id);
        const cur = this.store.wall(op.wallId);
        let nw = this.nearestWall(p, 0.5);
        if (!nw) { const c = closestOnSegment(p, cur.a, cur.b); nw = { wall: cur, t: c.t }; }
        const L = wallLength(nw.wall);
        const half = op.width / 2 / L;
        let t = Math.max(half, Math.min(1 - half, nw.t));
        if (!e.altKey) t = snapV(t * L) / L;
        op.wallId = nw.wall.id;
        op.t = t;
        break;
      }
      case 'furniture': {
        const f = plan.furniture.find((x) => x.id === d.id);
        f.x = p.x + d.off.x; f.y = p.y + d.off.y;
        if (!e.altKey) { f.x = snapV(f.x); f.y = snapV(f.y); this.autoAgainstWall(f, CATALOG_MAP[f.type], true); }
        break;
      }
      case 'rotate': {
        const f = plan.furniture.find((x) => x.id === d.id);
        let a = (Math.atan2(p.y - f.y, p.x - f.x) * 180) / Math.PI + 90;
        if (!e.altKey) a = Math.round(a / 15) * 15;
        f.rot = ((a % 360) + 360) % 360;
        break;
      }
      case 'room': {
        const r = plan.rooms.find((x) => x.id === d.id);
        let dx = p.x - d.start.x, dy = p.y - d.start.y;
        if (!e.altKey) { dx = snapV(dx); dy = snapV(dy); }
        r.points.forEach((q, i) => { q.x = d.pts0[i].x + dx; q.y = d.pts0[i].y + dy; });
        break;
      }
      case 'roomPt': {
        const r = plan.rooms.find((x) => x.id === d.id);
        const q = this.snapPoint(p, { alt: e.altKey });
        r.points[d.index].x = q.x; r.points[d.index].y = q.y;
        break;
      }
    }
    if (d.kind !== 'roomRect') this.store.changed('drag');
    this.render();
  }

  onUp(e) {
    const d = this.drag;
    this.drag = null;
    if (!d) return;
    if (d.kind === 'roomRect') {
      const a = d.start, b = d.end;
      if (Math.abs(a.x - b.x) > 0.3 && Math.abs(a.y - b.y) > 0.3) {
        const x0 = Math.min(a.x, b.x), x1 = Math.max(a.x, b.x), y0 = Math.min(a.y, b.y), y1 = Math.max(a.y, b.y);
        this.addRoom([{ x: x0, y: y0 }, { x: x1, y: y0 }, { x: x1, y: y1 }, { x: x0, y: y1 }]);
      } else {
        // Nhấp đơn: bắt đầu vẽ phòng đa giác
        this.poly = [a];
      }
    } else if (d.kind === 'bg') {
      this.store.save();
    } else if (d.kind !== 'pan') {
      if (!d.moved) this.store.undoStack.pop();
      else this.store.changed('plan');
    }
    this.render();
  }

  finishChain() {
    this.chain = null;
    this.render();
  }

  finishPoly() {
    if (this.poly && this.poly.length >= 3) this.addRoom(this.poly);
    this.poly = null;
    this.render();
  }

  /** Thêm phòng mới, tự tạo tường bao cho các cạnh chưa có tường */
  addRoom(points) {
    const t = this.plan.settings.wallThickness;
    const n = this.plan.rooms.length + 1;
    const room = { id: uid(), name: `Phòng ${n}`, floor: 'wood', points: points.map((p) => ({ x: p.x, y: p.y })) };
    this.store.commit((pl) => {
      pl.rooms.push(room);
      for (let i = 0; i < points.length; i++) {
        const a = points[i], b = points[(i + 1) % points.length];
        if (!this.edgeCovered(a, b)) pl.walls.push({ id: uid(), a: { x: a.x, y: a.y }, b: { x: b.x, y: b.y }, thickness: t });
      }
    });
    this.select({ kind: 'room', id: room.id });
  }

  /** Cạnh a-b đã nằm trọn trên một tường có sẵn chưa */
  edgeCovered(a, b) {
    return this.plan.walls.some((w) => closestOnSegment(a, w.a, w.b).d < 0.02 && closestOnSegment(b, w.a, w.b).d < 0.02);
  }

  /** Đồ sát tường: tự xoay lưng vào tường gần nhất và áp sát */
  autoAgainstWall(f, def, keepRot = false) {
    const backed = ['bed', 'bedSingle', 'wardrobe', 'sofa', 'tvStand', 'kitchen', 'fridge', 'toilet', 'vanity', 'bookshelf', 'desk', 'nightstand', 'washer'];
    if (!backed.includes(f.type)) return;
    const d = f.d ?? def.d;
    const nw = this.nearestWall(f, d / 2 + 0.35);
    if (!nw) return;
    const w = nw.wall;
    const L = wallLength(w);
    const dx = (w.b.x - w.a.x) / L, dy = (w.b.y - w.a.y) / L;
    let nx = -dy, ny = dx;
    if ((f.x - nw.point.x) * nx + (f.y - nw.point.y) * ny < 0) { nx = -nx; ny = -ny; }
    const rot = ((Math.atan2(ny, nx) * 180) / Math.PI - 90 + 360) % 360;
    if (keepRot && Math.abs((((f.rot - rot) % 360) + 540) % 360 - 180) > 1) return;
    f.rot = Math.round(rot * 100) / 100;
    const off = w.thickness / 2 + d / 2 + 0.01;
    f.x = nw.point.x + nx * off;
    f.y = nw.point.y + ny * off;
  }

  validateSelection() {
    const s = this.selection;
    if (!s) return;
    const list = { wall: 'walls', opening: 'openings', room: 'rooms', furniture: 'furniture' }[s.kind];
    if (!list || !this.plan[list].some((x) => x.id === s.id)) this.select(null);
  }

  deleteSelection() {
    const s = this.selection;
    if (!s) return;
    this.store.commit((pl) => {
      if (s.kind === 'wall') { pl.walls = pl.walls.filter((w) => w.id !== s.id); pl.openings = pl.openings.filter((o) => o.wallId !== s.id); }
      if (s.kind === 'opening') pl.openings = pl.openings.filter((o) => o.id !== s.id);
      if (s.kind === 'room') pl.rooms = pl.rooms.filter((r) => r.id !== s.id);
      if (s.kind === 'furniture') pl.furniture = pl.furniture.filter((f) => f.id !== s.id);
    });
    this.select(null);
  }

  rotateSelection(deg) {
    const s = this.selection;
    if (s?.kind !== 'furniture') return;
    this.store.commit((pl) => { const f = pl.furniture.find((x) => x.id === s.id); f.rot = (((f.rot || 0) + deg) % 360 + 360) % 360; });
  }

  flipSelection() {
    const s = this.selection;
    if (s?.kind !== 'opening') return;
    this.store.commit((pl) => {
      const o = pl.openings.find((x) => x.id === s.id);
      // Vòng lặp 4 trạng thái: bản lề trái/phải × mở vào/ra
      if (!o.flip) o.flip = true; else { o.flip = false; o.swingOut = !o.swingOut; }
    });
  }

  duplicate() {
    const s = this.selection;
    if (s?.kind !== 'furniture') return;
    const f = this.plan.furniture.find((x) => x.id === s.id);
    const c = { ...f, id: uid(), x: f.x + 0.3, y: f.y + 0.3 };
    this.store.commit((pl) => pl.furniture.push(c));
    this.select({ kind: 'furniture', id: c.id });
  }

  // ---------------- Vẽ ----------------
  render() {
    if (this._raf) return;
    this._raf = requestAnimationFrame(() => { this._raf = 0; this.draw(); });
  }

  draw() {
    const ctx = this.ctx, plan = this.plan, s = this.view.scale;
    const W = this.canvas.width / this.dpr, H = this.canvas.height / this.dpr;
    ctx.setTransform(this.dpr, 0, 0, this.dpr, 0, 0);
    ctx.fillStyle = '#fbfbf8';
    ctx.fillRect(0, 0, W, H);

    ctx.save();
    ctx.translate(this.view.ox, this.view.oy);
    ctx.scale(s, s);
    const px = 1 / s;

    // Ảnh nền
    const bg = this.store.background;
    if (this.bgImage && bg) {
      ctx.globalAlpha = bg.opacity ?? 0.5;
      ctx.drawImage(this.bgImage, bg.x, bg.y, this.bgImage.width * bg.mpp, this.bgImage.height * (bg.mppY ?? bg.mpp));
      ctx.globalAlpha = 1;
    }

    // Lưới
    const tl = this.toWorld(0, 0), br = this.toWorld(W, H);
    const minor = s > 60 ? 0.1 : s > 25 ? 0.5 : 1;
    ctx.lineWidth = px;
    for (const [step, color] of [[minor, '#eef0f2'], [1, '#dde1e5'], [5, '#c9ced4']]) {
      if (step === minor && step === 1) continue;
      ctx.strokeStyle = color;
      ctx.beginPath();
      for (let x = Math.floor(tl.x / step) * step; x <= br.x; x += step) { ctx.moveTo(x, tl.y); ctx.lineTo(x, br.y); }
      for (let y = Math.floor(tl.y / step) * step; y <= br.y; y += step) { ctx.moveTo(tl.x, y); ctx.lineTo(br.x, y); }
      ctx.stroke();
    }

    // Phòng
    for (const r of plan.rooms) {
      if (r.points.length < 3) continue;
      ctx.beginPath();
      r.points.forEach((p, i) => (i ? ctx.lineTo(p.x, p.y) : ctx.moveTo(p.x, p.y)));
      ctx.closePath();
      ctx.fillStyle = FLOOR_COLORS_2D[r.floor] || '#eee';
      ctx.fill();
      if (r.floor === 'tile' || r.floor === 'terracotta' || r.floor === 'marble') {
        ctx.save(); ctx.clip();
        ctx.strokeStyle = 'rgba(0,0,0,0.06)';
        const step = r.floor === 'marble' ? 0.8 : r.floor === 'tile' ? 0.6 : 0.4;
        const xs = r.points.map((q) => q.x), ys = r.points.map((q) => q.y);
        ctx.beginPath();
        for (let x = Math.min(...xs); x < Math.max(...xs); x += step) { ctx.moveTo(x, Math.min(...ys)); ctx.lineTo(x, Math.max(...ys)); }
        for (let y = Math.min(...ys); y < Math.max(...ys); y += step) { ctx.moveTo(Math.min(...xs), y); ctx.lineTo(Math.max(...xs), y); }
        ctx.stroke(); ctx.restore();
      } else if (r.floor === 'wood' || r.floor === 'oak') {
        ctx.save(); ctx.clip();
        ctx.strokeStyle = 'rgba(120,80,40,0.08)';
        const xs = r.points.map((q) => q.x), ys = r.points.map((q) => q.y);
        ctx.beginPath();
        for (let y = Math.min(...ys); y < Math.max(...ys); y += 0.18) { ctx.moveTo(Math.min(...xs), y); ctx.lineTo(Math.max(...xs), y); }
        ctx.stroke(); ctx.restore();
      }
    }

    // Nội thất (thảm trước, đồ khác sau)
    const furn = [...plan.furniture].sort((a, b) => (a.type === 'rug' ? -1 : 0) - (b.type === 'rug' ? -1 : 0));
    for (const f of furn) {
      ctx.save();
      ctx.translate(f.x, f.y);
      ctx.rotate(((f.rot || 0) * Math.PI) / 180);
      drawFurniture2D(ctx, f, s);
      ctx.restore();
    }

    // Tường
    ctx.lineCap = 'square';
    for (const w of plan.walls) {
      ctx.strokeStyle = '#2b2d31';
      ctx.lineWidth = w.thickness;
      ctx.beginPath(); ctx.moveTo(w.a.x, w.a.y); ctx.lineTo(w.b.x, w.b.y); ctx.stroke();
    }
    ctx.lineCap = 'butt';

    // Cửa
    for (const op of plan.openings) {
      const w = this.store.wall(op.wallId);
      if (!w) continue;
      this.drawOpening(ctx, w, op, px);
    }

    // Kích thước tường
    if (this.showDims) for (const w of plan.walls) this.drawWallDim(ctx, w, px, false);

    // Nhãn phòng
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    for (const r of plan.rooms) {
      if (r.points.length < 3) continue;
      const lp = labelPoint(r.points);
      const fs = Math.max(11, Math.min(15, s * 0.28)) * px;
      ctx.font = `600 ${fs}px Inter, system-ui, sans-serif`;
      const name = r.name || '';
      const area = `${fmt(polygonArea(r.points), 1)} m²`;
      const tw = Math.max(ctx.measureText(name).width, ctx.measureText(area).width) + 10 * px;
      ctx.fillStyle = 'rgba(255,255,255,0.82)';
      ctx.beginPath(); ctx.roundRect(lp.x - tw / 2, lp.y - fs * 1.25, tw, fs * 2.5, 4 * px); ctx.fill();
      ctx.fillStyle = '#1f2937';
      ctx.fillText(name, lp.x, lp.y - fs * 0.5);
      ctx.font = `${fs * 0.88}px Inter, system-ui, sans-serif`;
      ctx.fillStyle = '#6b7280';
      ctx.fillText(area, lp.x, lp.y + fs * 0.65);
    }

    this.drawSelection(ctx, px);
    this.drawToolPreview(ctx, px);

    // Đường gióng
    if (this.guides.length && (this.drag || this.chain || this.poly || this.tool !== 'select')) {
      ctx.strokeStyle = '#ec4899';
      ctx.setLineDash([4 * px, 4 * px]);
      ctx.lineWidth = px;
      for (const g of this.guides) { ctx.beginPath(); ctx.moveTo(g.a.x, g.a.y); ctx.lineTo(g.b.x, g.b.y); ctx.stroke(); }
      ctx.setLineDash([]);
    }
    ctx.restore();

    // Thước tỉ lệ
    this.drawScaleBar(ctx, W, H);
  }

  drawOpening(ctx, w, op, px, highlight = false) {
    const L = wallLength(w);
    const dx = (w.b.x - w.a.x) / L, dy = (w.b.y - w.a.y) / L;
    const nx = -dy, ny = dx;
    const [s, e] = openingRange(w, op);
    const P = (u, v = 0) => ({ x: w.a.x + dx * u + nx * v, y: w.a.y + dy * u + ny * v });
    const t = w.thickness / 2;
    // Xoá phần tường tại ô cửa
    ctx.fillStyle = highlight ? 'rgba(59,130,246,0.25)' : '#fbfbf8';
    ctx.beginPath();
    [P(s, -t - px), P(e, -t - px), P(e, t + px), P(s, t + px)].forEach((p, i) => (i ? ctx.lineTo(p.x, p.y) : ctx.moveTo(p.x, p.y)));
    ctx.closePath(); ctx.fill();
    ctx.strokeStyle = '#2b2d31';
    ctx.lineWidth = 1.2 * px;
    const line = (a, b) => { ctx.beginPath(); ctx.moveTo(a.x, a.y); ctx.lineTo(b.x, b.y); ctx.stroke(); };
    line(P(s, -t), P(s, t)); line(P(e, -t), P(e, t));
    if (op.type === 'window') {
      ctx.strokeStyle = '#2563eb';
      line(P(s, -t), P(e, -t)); line(P(s, t), P(e, t));
      ctx.lineWidth = 2 * px; line(P(s, 0), P(e, 0));
    } else if (op.type === 'slide') {
      ctx.strokeStyle = '#2563eb';
      ctx.lineWidth = 2 * px;
      const m = (s + e) / 2;
      line(P(s, -t * 0.35), P(m + 0.05, -t * 0.35)); line(P(m - 0.05, t * 0.35), P(e, t * 0.35));
    } else {
      const side = op.swingOut ? -1 : 1;
      const width = e - s;
      const hingeU = op.flip ? e : s;
      const hinge = P(hingeU, side * t);
      const leafEnd = P(hingeU, side * (t + width));
      ctx.strokeStyle = '#8b5a36';
      ctx.lineWidth = 2.5 * px;
      line(hinge, leafEnd);
      ctx.lineWidth = 1 * px;
      ctx.setLineDash([3 * px, 2 * px]);
      ctx.beginPath();
      const a0 = Math.atan2(leafEnd.y - hinge.y, leafEnd.x - hinge.x);
      const closed = P(op.flip ? s : e, side * t);
      const a1 = Math.atan2(closed.y - hinge.y, closed.x - hinge.x);
      let da = a1 - a0;
      while (da > Math.PI) da -= 2 * Math.PI;
      while (da < -Math.PI) da += 2 * Math.PI;
      ctx.arc(hinge.x, hinge.y, width, a0, a1, da < 0);
      ctx.stroke();
      ctx.setLineDash([]);
    }
  }

  drawWallDim(ctx, w, px, strong) {
    const L = wallLength(w);
    if (L < 0.3) return;
    const s = this.view.scale;
    if (!strong && L * s < 45) return;
    const dx = (w.b.x - w.a.x) / L, dy = (w.b.y - w.a.y) / L;
    // Đặt kích thước ra phía ngoài (xa tâm nhà)
    const b = planBounds(this.plan);
    const c = { x: (b.minX + b.maxX) / 2, y: (b.minY + b.maxY) / 2 };
    let nx = -dy, ny = dx;
    const mid = { x: (w.a.x + w.b.x) / 2, y: (w.a.y + w.b.y) / 2 };
    if ((mid.x - c.x) * nx + (mid.y - c.y) * ny < 0) { nx = -nx; ny = -ny; }
    const off = w.thickness / 2 + 14 * px;
    const a = { x: w.a.x + nx * off, y: w.a.y + ny * off }, bb = { x: w.b.x + nx * off, y: w.b.y + ny * off };
    ctx.strokeStyle = strong ? '#2563eb' : '#9ca3af';
    ctx.fillStyle = strong ? '#2563eb' : '#6b7280';
    ctx.lineWidth = px;
    ctx.beginPath(); ctx.moveTo(a.x, a.y); ctx.lineTo(bb.x, bb.y);
    for (const p of [a, bb]) { ctx.moveTo(p.x - nx * 4 * px + dx * 3 * px, p.y - ny * 4 * px + dy * 3 * px); ctx.lineTo(p.x + nx * 4 * px - dx * 3 * px, p.y + ny * 4 * px - dy * 3 * px); }
    ctx.stroke();
    ctx.save();
    ctx.translate((a.x + bb.x) / 2, (a.y + bb.y) / 2);
    let ang = Math.atan2(dy, dx);
    if (ang > Math.PI / 2 || ang < -Math.PI / 2) ang += Math.PI;
    ctx.rotate(ang);
    ctx.font = `${(strong ? 12 : 10.5) * px}px Inter, system-ui, sans-serif`;
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    const text = `${fmt(L, 2)} m`;
    const tw = ctx.measureText(text).width + 6 * px;
    ctx.fillStyle = '#fbfbf8';
    ctx.fillRect(-tw / 2, -7 * px, tw, 14 * px);
    ctx.fillStyle = strong ? '#2563eb' : '#6b7280';
    ctx.fillText(text, 0, 0);
    ctx.restore();
  }

  drawSelection(ctx, px) {
    const plan = this.plan;
    const items = [];
    if (this.hover && this.tool === 'select' && !this.drag) items.push([this.hover, 'hover']);
    if (this.selection) items.push([this.selection, 'sel']);
    for (const [sel, mode] of items) {
      const color = mode === 'sel' ? '#3b82f6' : 'rgba(59,130,246,0.45)';
      ctx.strokeStyle = color;
      ctx.lineWidth = 2 * px;
      if (sel.kind === 'wall' || sel.kind === 'wallEnd') {
        const w = this.store.wall(sel.id);
        if (!w) continue;
        ctx.lineCap = 'square';
        ctx.strokeStyle = mode === 'sel' ? 'rgba(59,130,246,0.85)' : 'rgba(59,130,246,0.35)';
        ctx.lineWidth = w.thickness;
        ctx.beginPath(); ctx.moveTo(w.a.x, w.a.y); ctx.lineTo(w.b.x, w.b.y); ctx.stroke();
        ctx.lineCap = 'butt';
        for (const op of plan.openings.filter((o) => o.wallId === w.id)) this.drawOpening(ctx, w, op, px);
        if (mode === 'sel') {
          this.drawWallDim(ctx, w, px, true);
          for (const p of [w.a, w.b]) { ctx.fillStyle = '#fff'; ctx.strokeStyle = '#3b82f6'; ctx.lineWidth = 2 * px; ctx.beginPath(); ctx.arc(p.x, p.y, 6 * px, 0, Math.PI * 2); ctx.fill(); ctx.stroke(); }
        }
      } else if (sel.kind === 'opening') {
        const op = plan.openings.find((o) => o.id === sel.id);
        const w = op && this.store.wall(op.wallId);
        if (w) this.drawOpening(ctx, w, op, px, true);
        if (w && mode === 'sel') this.drawOpeningDims(ctx, w, op, px);
      } else if (sel.kind === 'furniture' || sel.kind === 'rotate') {
        const f = plan.furniture.find((x) => x.id === sel.id);
        if (!f) continue;
        const def = CATALOG_MAP[f.type];
        const w = f.w ?? def.w, d = f.d ?? def.d;
        ctx.save();
        ctx.translate(f.x, f.y);
        ctx.rotate(((f.rot || 0) * Math.PI) / 180);
        ctx.strokeRect(-w / 2 - 2 * px, -d / 2 - 2 * px, w + 4 * px, d + 4 * px);
        if (mode === 'sel') {
          ctx.beginPath(); ctx.moveTo(0, -d / 2 - 2 * px); ctx.lineTo(0, -d / 2 - 22 * px); ctx.stroke();
          ctx.fillStyle = '#fff'; ctx.beginPath(); ctx.arc(0, -d / 2 - 22 * px, 6 * px, 0, Math.PI * 2); ctx.fill(); ctx.stroke();
          // Mũi tên hướng mặt trước
          ctx.fillStyle = '#3b82f6';
          ctx.beginPath(); ctx.moveTo(-6 * px, d / 2 + 6 * px); ctx.lineTo(6 * px, d / 2 + 6 * px); ctx.lineTo(0, d / 2 + 13 * px); ctx.closePath(); ctx.fill();
        }
        ctx.restore();
      } else if (sel.kind === 'room' || sel.kind === 'roomPt') {
        const r = plan.rooms.find((x) => x.id === sel.id);
        if (!r) continue;
        ctx.setLineDash([6 * px, 4 * px]);
        ctx.beginPath();
        r.points.forEach((p, i) => (i ? ctx.lineTo(p.x, p.y) : ctx.moveTo(p.x, p.y)));
        ctx.closePath(); ctx.stroke();
        ctx.setLineDash([]);
        if (mode === 'sel') for (const p of r.points) { ctx.fillStyle = '#fff'; ctx.beginPath(); ctx.rect(p.x - 4 * px, p.y - 4 * px, 8 * px, 8 * px); ctx.fill(); ctx.stroke(); }
      }
    }
  }

  drawOpeningDims(ctx, w, op, px) {
    const L = wallLength(w);
    const [s, e] = openingRange(w, op);
    const dx = (w.b.x - w.a.x) / L, dy = (w.b.y - w.a.y) / L;
    ctx.fillStyle = '#2563eb';
    ctx.font = `${11 * px}px Inter, system-ui, sans-serif`;
    ctx.textAlign = 'center';
    const m = { x: w.a.x + dx * (s + e) / 2, y: w.a.y + dy * (s + e) / 2 };
    ctx.fillText(`${fmt(op.width, 2)} m`, m.x - dy * (w.thickness / 2 + 26 * px), m.y + dx * (w.thickness / 2 + 26 * px));
  }

  drawToolPreview(ctx, px) {
    const m = this.mouse;
    if (!m.inside && !this.drag) return;
    const p = { x: m.x, y: m.y };
    ctx.lineWidth = 2 * px;
    if (this.tool === 'wall') {
      const q = this.snapPoint(p, { from: this.chain?.at(-1), alt: m.alt, shift: m.shift });
      if (this.chain) {
        const a = this.chain.at(-1);
        ctx.strokeStyle = 'rgba(37,99,235,0.6)';
        ctx.lineWidth = this.plan.settings.wallThickness;
        ctx.lineCap = 'square';
        ctx.beginPath(); ctx.moveTo(a.x, a.y); ctx.lineTo(q.x, q.y); ctx.stroke();
        ctx.lineCap = 'butt';
        this.drawWallDim(ctx, { a, b: q, thickness: this.plan.settings.wallThickness }, px, true);
      }
      this.drawCursor(ctx, q, px);
    } else if (this.tool === 'room') {
      if (this.drag?.kind === 'roomRect') {
        const a = this.drag.start, b = this.drag.end;
        ctx.fillStyle = 'rgba(59,130,246,0.12)';
        ctx.strokeStyle = '#2563eb';
        ctx.fillRect(a.x, a.y, b.x - a.x, b.y - a.y);
        ctx.strokeRect(a.x, a.y, b.x - a.x, b.y - a.y);
        ctx.fillStyle = '#2563eb';
        ctx.font = `600 ${12 * px}px Inter, system-ui, sans-serif`;
        ctx.textAlign = 'center';
        const W = Math.abs(b.x - a.x), Hh = Math.abs(b.y - a.y);
        ctx.fillText(`${fmt(W, 2)} × ${fmt(Hh, 2)} m  (${fmt(W * Hh, 1)} m²)`, (a.x + b.x) / 2, (a.y + b.y) / 2);
      } else if (this.poly) {
        const q = this.snapPoint(p, { from: this.poly.at(-1), alt: m.alt, shift: m.shift });
        ctx.strokeStyle = '#2563eb';
        ctx.fillStyle = 'rgba(59,130,246,0.12)';
        ctx.beginPath();
        [...this.poly, q].forEach((pt, i) => (i ? ctx.lineTo(pt.x, pt.y) : ctx.moveTo(pt.x, pt.y)));
        ctx.closePath(); ctx.fill(); ctx.stroke();
        for (const pt of this.poly) { ctx.fillStyle = '#2563eb'; ctx.fillRect(pt.x - 3 * px, pt.y - 3 * px, 6 * px, 6 * px); }
        this.drawCursor(ctx, q, px);
      } else this.drawCursor(ctx, this.snapPoint(p, {}), px);
    } else if (['door', 'window', 'slide'].includes(this.tool)) {
      const nw = this.nearestWall(p);
      if (nw) {
        const def = OPENING_DEFAULTS[this.tool];
        const L = wallLength(nw.wall);
        const t = Math.max(def.width / 2 / L, Math.min(1 - def.width / 2 / L, nw.t));
        this.drawOpening(ctx, nw.wall, { ...def, type: this.tool, t, width: Math.min(def.width, L - 0.1) }, px, true);
      }
    } else if (this.tool === 'furniture') {
      const def = CATALOG_MAP[this.furnitureType];
      const f = { type: this.furnitureType, x: snapV(p.x), y: snapV(p.y), rot: this.ghostRot };
      this.autoAgainstWall(f, def);
      ctx.save();
      ctx.globalAlpha = 0.6;
      ctx.translate(f.x, f.y);
      ctx.rotate((f.rot * Math.PI) / 180);
      drawFurniture2D(ctx, f, this.view.scale);
      ctx.restore();
    } else if (this.tool === 'calibrate') {
      ctx.strokeStyle = '#db2777';
      if (this.calib) { ctx.beginPath(); ctx.moveTo(this.calib[0].x, this.calib[0].y); ctx.lineTo(p.x, p.y); ctx.stroke(); }
      this.drawCursor(ctx, p, px, '#db2777');
    }
  }

  drawCursor(ctx, q, px, color = '#2563eb') {
    ctx.strokeStyle = color;
    ctx.lineWidth = 1.5 * px;
    ctx.beginPath();
    ctx.arc(q.x, q.y, 5 * px, 0, Math.PI * 2);
    ctx.moveTo(q.x - 10 * px, q.y); ctx.lineTo(q.x + 10 * px, q.y);
    ctx.moveTo(q.x, q.y - 10 * px); ctx.lineTo(q.x, q.y + 10 * px);
    ctx.stroke();
  }

  drawScaleBar(ctx, W, H) {
    const s = this.view.scale;
    const opts = [0.5, 1, 2, 5, 10, 20];
    const len = opts.find((o) => o * s > 70) || 20;
    const x = 16, y = H - 22;
    ctx.fillStyle = 'rgba(255,255,255,0.85)';
    ctx.fillRect(x - 6, y - 16, len * s + 56, 26);
    ctx.strokeStyle = '#374151';
    ctx.lineWidth = 2;
    ctx.beginPath(); ctx.moveTo(x, y - 4); ctx.lineTo(x, y); ctx.lineTo(x + len * s, y); ctx.lineTo(x + len * s, y - 4); ctx.stroke();
    ctx.fillStyle = '#374151';
    ctx.font = '11px Inter, system-ui, sans-serif';
    ctx.textAlign = 'left';
    ctx.fillText(`${len} m`, x + len * s + 6, y);
  }
}
