// Mô hình dữ liệu mặt bằng + lịch sử hoàn tác + lưu tự động
export const uid = () => Math.random().toString(36).slice(2, 10);

export const FLOOR_TYPES = {
  herringbone: 'Gỗ xương cá',
  herringboneLight: 'Xương cá sồi sáng',
  wood: 'Sàn gỗ',
  oak: 'Gỗ sồi sáng',
  walnut: 'Gỗ óc chó',
  darkTile: 'Gạch xám đậm',
  encaustic: 'Gạch bông',
  polished: 'Bê tông mài',
  tile: 'Gạch men',
  marble: 'Đá marble',
  carpet: 'Thảm',
  concrete: 'Bê tông',
  terracotta: 'Gạch đỏ',
  grass: 'Cỏ (sân)',
};
export const FLOOR_COLORS_2D = {
  wood: '#e6cfa9', oak: '#efdcbc', tile: '#dfe7ec', marble: '#f1efe9', carpet: '#d9d1c7',
  concrete: '#cfcfcf', terracotta: '#e3b49a', grass: '#bfe0a8', herringbone: '#d9b48c', herringboneLight: '#ead2b2',
  walnut: '#c8a081', darkTile: '#a9adb3', encaustic: '#cfe0d6', polished: '#dcdad5',
};

export function emptyPlan() {
  return { version: 1, walls: [], openings: [], rooms: [], furniture: [], settings: { wallHeight: 2.8, wallThickness: 0.2, style: 'luxury', palette: {} } };
}

const W = (ax, ay, bx, by, thickness = 0.22) => ({ id: uid(), a: { x: ax, y: ay }, b: { x: bx, y: by }, thickness });

export function samplePlan() {
  const p = emptyPlan();
  const top = W(0, 0, 11, 0), right = W(11, 0, 11, 8.4), bottom = W(11, 8.4, 0, 8.4), left = W(0, 8.4, 0, 0);
  const w5 = W(4, 0, 4, 4, 0.12), w6 = W(6.2, 0, 6.2, 4, 0.12), w7 = W(4, 2.4, 6.2, 2.4, 0.12);
  const w8 = W(0, 4, 4, 4, 0.12), w9 = W(6.2, 4, 11, 4, 0.12);
  p.walls = [top, right, bottom, left, w5, w6, w7, w8, w9];
  const O = (wall, type, t, width, height, sill = 0, extra = {}) => ({ id: uid(), wallId: wall.id, type, t, width, height, sill, ...extra });
  p.openings = [
    O(top, 'window', 2 / 11, 1.4, 1.3, 0.9),
    O(top, 'window', 8.6 / 11, 1.6, 1.3, 0.9),
    O(top, 'window', 5.1 / 11, 0.6, 0.6, 1.6),
    O(right, 'window', 6.2 / 8.4, 1.4, 1.1, 1.0),
    O(bottom, 'door', 0.8 / 11, 1.0, 2.2, 0, { flip: false }),
    O(bottom, 'window', 8 / 11, 1.8, 1.4, 0.8),
    O(left, 'slide', (8.4 - 6.2) / 8.4, 2.4, 2.4, 0),
    O(left, 'window', (8.4 - 2) / 8.4, 1.2, 1.3, 0.9),
    O(w5, 'door', 0.8, 0.85, 2.1, 0, { flip: true }),
    O(w6, 'door', 0.8, 0.85, 2.1, 0, { flip: false, swingOut: true }),
    O(w7, 'door', 0.5, 0.75, 2.1, 0, { flip: true }),
  ];
  const R = (name, floor, pts) => ({ id: uid(), name, floor, points: pts.map(([x, y]) => ({ x, y })) });
  p.rooms = [
    R('Phòng ngủ master', 'wood', [[0, 0], [4, 0], [4, 4], [0, 4]]),
    R('Phòng tắm', 'tile', [[4, 0], [6.2, 0], [6.2, 2.4], [4, 2.4]]),
    R('Phòng ngủ 2', 'oak', [[6.2, 0], [11, 0], [11, 4], [6.2, 4]]),
    R('Phòng khách', 'marble', [[0, 4], [4, 4], [4, 2.4], [6.2, 2.4], [6.2, 8.4], [0, 8.4]]),
    R('Bếp & phòng ăn', 'tile', [[6.2, 4], [11, 4], [11, 8.4], [6.2, 8.4]]),
  ];
  const F = (type, x, y, rot = 0, extra = {}) => ({ id: uid(), type, x, y, rot, ...extra });
  p.furniture = [
    F('bed', 2, 1.16), F('nightstand', 0.62, 0.33), F('nightstand', 3.38, 0.33), F('wardrobe', 0.42, 2.9, 270),
    F('rug', 2, 2.6, 0, { w: 2.0, d: 1.2 }), F('plant', 3.6, 3.55),
    F('toilet', 4.45, 0.46), F('vanity', 5.6, 0.37), F('shower', 5.6, 1.62, 0, { w: 0.85, d: 0.85 }),
    F('bedSingle', 8.6, 1.13, 0, { w: 1.6 }), F('nightstand', 7.5, 0.33), F('wardrobe', 10.0, 3.6, 180, { w: 1.6 }),
    F('desk', 10.58, 1.4, 90), F('officeChair', 10.05, 1.4, 270),
    F('sofa', 2.6, 7.8, 180), F('coffeeTable', 2.6, 6.55), F('tvStand', 2.6, 4.3), F('rug', 2.6, 6.45),
    F('armchair', 4.75, 6.5, 90), F('plant', 0.45, 7.9), F('floorLamp', 4.6, 7.85), F('bookshelf', 5.95, 6.3, 90, { w: 1.2 }),
    F('kitchen', 8.1, 4.41), F('fridge', 10.47, 4.47), F('diningTable', 8.6, 6.5),
    F('chair', 8.15, 5.82), F('chair', 9.05, 5.82), F('chair', 8.15, 7.18, 180), F('chair', 9.05, 7.18, 180),
    F('plant', 6.55, 8.0),
  ];
  return p;
}

/** Căn hộ 2PN + lô-gia, bố cục theo ảnh phối cảnh mẫu */
export function luxuryPlan() {
  const p = emptyPlan();
  const top = W(0, 0, 11, 0, 0.25), right = W(11, 0, 11, 8.6, 0.25), bottom = W(11, 8.6, 0, 8.6, 0.25), left = W(0, 8.6, 0, 0, 0.25);
  const w1 = W(0, 3.2, 4, 3.2, 0.12), w2 = W(4, 0, 4, 3.6, 0.12), w3 = W(6, 0, 6, 4.6, 0.15), w4 = W(4, 3.6, 6, 3.6, 0.12);
  const w5 = W(6, 4.6, 11, 4.6, 0.15), w6 = W(3, 3.2, 3, 5.2, 0.12), w7 = W(0, 5.2, 3, 5.2, 0.12), w8 = W(9.2, 4.6, 9.2, 8.6, 0.15);
  p.walls = [top, right, bottom, left, w1, w2, w3, w4, w5, w6, w7, w8];
  const O = (wall, type, t, width, height, sill = 0, extra = {}) => ({ id: uid(), wallId: wall.id, type, t, width, height, sill, ...extra });
  p.openings = [
    O(top, 'window', 2 / 11, 2.4, 1.9, 0.5),
    O(top, 'window', 5 / 11, 0.6, 0.6, 1.7),
    O(top, 'window', 8.4 / 11, 2.8, 2.1, 0.35),
    O(right, 'slide', 2.3 / 8.6, 2.6, 2.3, 0),
    O(right, 'window', 6.6 / 8.6, 2.8, 1.5, 0.95),
    O(bottom, 'door', (11 - 1.6) / 11, 1.0, 2.2, 0),
    O(w1, 'door', 3.5 / 4, 0.8, 2.1, 0, { flip: true }),
    O(w3, 'door', 4.1 / 4.6, 0.85, 2.1, 0, { flip: true, swingOut: true }),
    O(w4, 'door', 0.5, 0.7, 2.1, 0),
    O(w6, 'door', 0.55, 0.7, 2.1, 0, { swingOut: true }),
    O(w8, 'slide', 0.5, 2.4, 2.3, 0),
  ];
  const R = (name, floor, pts) => ({ id: uid(), name, floor, points: pts.map(([x, y]) => ({ x, y })) });
  p.rooms = [
    R('Phòng ngủ 2', 'herringbone', [[0, 0], [4, 0], [4, 3.2], [0, 3.2]]),
    R('Phòng tắm master', 'darkTile', [[4, 0], [6, 0], [6, 3.6], [4, 3.6]]),
    R('Phòng ngủ master', 'herringbone', [[6, 0], [11, 0], [11, 4.6], [6, 4.6]]),
    R('Phòng tắm 2', 'darkTile', [[0, 3.2], [3, 3.2], [3, 5.2], [0, 5.2]]),
    R('Phòng khách & bếp', 'marble', [[3, 3.2], [4, 3.2], [4, 3.6], [6, 3.6], [6, 4.6], [9.2, 4.6], [9.2, 8.6], [0, 8.6], [0, 5.2], [3, 5.2]]),
    R('Lô gia', 'darkTile', [[9.2, 4.6], [11, 4.6], [11, 8.6], [9.2, 8.6]]),
  ];
  const F = (type, x, y, rot = 0, extra = {}) => ({ id: uid(), type, x, y, rot, ...extra });
  p.furniture = [
    // Phòng ngủ 2
    F('bedSingle', 1.12, 1.35, 270, { w: 1.6 }), F('nightstand', 0.33, 0.3, 270), F('nightstand', 0.33, 2.4, 270),
    F('wardrobe', 2.5, 2.83, 180, { w: 1.6 }), F('armchair', 3.4, 0.75, 90, { w: 0.75, d: 0.75 }), F('plant', 3.62, 1.75),
    // WC master
    F('shower', 5.5, 0.72, 0, { w: 0.9, d: 1.2 }), F('toilet', 4.4, 1.9, 270), F('vanity', 4.31, 2.9, 270),
    // Phòng ngủ master
    F('rug', 8.0, 1.9, 0, { w: 2.6, d: 3.2 }), F('bed', 7.1, 1.9, 270), F('nightstand', 6.3, 0.7, 270), F('nightstand', 6.3, 3.1, 270),
    F('desk', 10.6, 2.9, 90, { w: 1.1, d: 0.5 }), F('chair', 10.05, 2.9, 270), F('wardrobe', 8.6, 4.22, 180, { w: 2.4 }), F('plant', 6.45, 4.2),
    // WC 2
    F('shower', 0.6, 4.6, 0, { w: 1.0, d: 1.0 }), F('toilet', 1.5, 3.6), F('vanity', 2.35, 3.51),
    // Bếp & ăn
    F('kitchen', 0.41, 6.75, 270, { w: 2.2 }), F('kitchen', 1.75, 5.61, 0, { w: 2.0 }),
    F('diningTable', 3.0, 7.0, 90), F('chair', 2.22, 6.6, 270), F('chair', 2.22, 7.4, 270), F('chair', 3.78, 6.6, 90), F('chair', 3.78, 7.4, 90),
    // Phòng khách
    F('tvStand', 7.6, 4.93, 0, { w: 2.0 }), F('rug', 7.6, 6.9, 0, { w: 3.0, d: 2.3 }), F('sofa', 7.6, 8.03, 180, { w: 2.6 }),
    F('roundTable', 7.6, 6.85), F('armchair', 5.95, 6.6, 270), F('plant', 8.95, 8.2), F('floorLamp', 6.15, 7.95),
    // Lô gia
    F('washer', 10.58, 5.1, 90), F('plant', 10.6, 6.6), F('plant', 10.55, 8.15), F('plant', 9.6, 8.2),
  ];
  return p;
}

export function studioPlan() {
  const p = emptyPlan();
  const a = W(0, 0, 7, 0), b = W(7, 0, 7, 5), c = W(7, 5, 0, 5), d = W(0, 5, 0, 0), e = W(4.8, 0, 4.8, 2.2, 0.12), f = W(4.8, 2.2, 7, 2.2, 0.12);
  p.walls = [a, b, c, d, e, f];
  const O = (wall, type, t, width, height, sill = 0) => ({ id: uid(), wallId: wall.id, type, t, width, height, sill });
  p.openings = [O(c, 'door', 0.2, 0.95, 2.2), O(a, 'window', 0.3, 2.0, 1.4, 0.8), O(d, 'slide', 0.5, 2.2, 2.4), O(f, 'door', 0.5, 0.75, 2.1), O(b, 'window', 0.22, 0.6, 0.6, 1.6)];
  p.rooms = [
    { id: uid(), name: 'Studio', floor: 'oak', points: [{ x: 0, y: 0 }, { x: 4.8, y: 0 }, { x: 4.8, y: 2.2 }, { x: 7, y: 2.2 }, { x: 7, y: 5 }, { x: 0, y: 5 }] },
    { id: uid(), name: 'WC', floor: 'tile', points: [{ x: 4.8, y: 0 }, { x: 7, y: 0 }, { x: 7, y: 2.2 }, { x: 4.8, y: 2.2 }] },
  ];
  const F = (type, x, y, rot = 0, extra = {}) => ({ id: uid(), type, x, y, rot, ...extra });
  p.furniture = [
    F('bed', 1.1, 1.15, 0, { w: 1.6 }), F('sofa', 2.3, 4.45, 180, { w: 1.8 }), F('coffeeTable', 2.3, 3.5, 0, { w: 0.9 }),
    F('kitchen', 6.58, 3.6, 90, { w: 2.4 }), F('toilet', 6.54, 0.5, 90), F('shower', 5.3, 0.55, 0, { w: 0.8, d: 0.8 }),
    F('vanity', 6.62, 1.55, 90, { w: 0.6 }), F('plant', 3.9, 0.45), F('rug', 2.3, 3.5, 0, { w: 1.8, d: 1.3 }),
  ];
  return p;
}

const LS_KEY = 'floorplan3d.plan.v2';
const LS_BG = 'floorplan3d.bg';

export class Store extends EventTarget {
  constructor() {
    super();
    this.undoStack = [];
    this.redoStack = [];
    this.background = null; // {src, x, y, mpp (mét/pixel), opacity, w, h}
    let plan = null;
    try { plan = JSON.parse(localStorage.getItem(LS_KEY) || 'null'); } catch { plan = null; }
    this.plan = plan && plan.walls ? plan : luxuryPlan();
    this.plan.settings = { wallHeight: 2.8, wallThickness: 0.2, style: 'luxury', palette: {}, ...(this.plan.settings || {}) };
    try { this.background = JSON.parse(localStorage.getItem(LS_BG) || 'null'); } catch { this.background = null; }
  }
  checkpoint() {
    this.undoStack.push(JSON.stringify(this.plan));
    if (this.undoStack.length > 150) this.undoStack.shift();
    this.redoStack = [];
  }
  /** Ghi một thay đổi có thể hoàn tác */
  commit(fn) {
    this.checkpoint();
    fn(this.plan);
    this.changed();
  }
  changed(kind = 'plan') {
    this.dispatchEvent(new CustomEvent('change', { detail: kind }));
    clearTimeout(this._saveT);
    this._saveT = setTimeout(() => this.save(), 400);
  }
  save() {
    try { localStorage.setItem(LS_KEY, JSON.stringify(this.plan)); } catch { /* bộ nhớ đầy hoặc bị chặn */ }
    try { localStorage.setItem(LS_BG, JSON.stringify(this.background)); } catch { /* ảnh nền quá lớn */ }
  }
  undo() {
    if (!this.undoStack.length) return;
    this.redoStack.push(JSON.stringify(this.plan));
    this.plan = JSON.parse(this.undoStack.pop());
    this.changed();
  }
  redo() {
    if (!this.redoStack.length) return;
    this.undoStack.push(JSON.stringify(this.plan));
    this.plan = JSON.parse(this.redoStack.pop());
    this.changed();
  }
  load(plan) {
    this.checkpoint();
    this.plan = plan;
    this.changed('load');
  }
  wall(id) { return this.plan.walls.find((w) => w.id === id); }
}
