// Dữ liệu tòa F2: vị trí 32 căn trên mặt bằng tầng điển hình (đo từ bản vẽ tầng 3/5,
// đơn vị pixel ảnh 2000×1414) và diện tích tim tường / thông thủy theo bảng của chủ đầu tư.
export const PX_TO_M = 0.0515;

// [mã vị trí, x0, y0, x1, y1, tim (m²), thông thủy (m²)] – đo trên ảnh mặt bằng tầng 8–19 (2000×1414),
// cánh phải đối xứng cánh trái qua trục x = 1037,5. Diện tích: theo bảng tầng 5.
const LEFT = [
  ['24', 440, 340, 600, 555, 94.3, 87.0], ['25', 600, 340, 690, 470, 33.7, 30.4], ['26', 690, 340, 810, 535, 65.5, 59.6],
  ['27', 655, 535, 810, 620, 36.8, 32.6], ['28', 655, 620, 810, 740, 46.5, 41.8],
  ['23', 440, 555, 630, 665, 58.1, 53.5], ['22', 440, 665, 630, 780, 58.1, 53.5], ['21', 440, 780, 630, 895, 58.1, 53.5],
  ['20', 440, 895, 630, 975, 37.8, 33.7], ['19', 440, 975, 600, 1135, 70.1, 64.0], ['18', 600, 1010, 690, 1135, 33.7, 30.4],
  ['17', 690, 970, 810, 1135, 52.4, 48.4],
];
const MIRROR = { 24: '05', 25: '03A', 26: '03', 27: '02', 28: '01', 23: '06', 22: '07', 21: '08', 20: '09', 19: '10', 18: '11', 17: '12' };
const RIGHT_AREAS = { '05': [94.5, 86.3], '03A': [33.7, 30.4], '03': [65.5, 59.6], '02': [36.8, 32.6], '01': [46.5, 41.8], '06': [58.4, 53.0], '07': [58.4, 53.0], '08': [58.4, 53.0], '09': [38.2, 33.2], '10': [70.1, 63.7], '11': [33.7, 30.4], '12': [55.4, 51.0] };
const MID = [
  ['29', 810, 635, 921, 848, 61.6, 55.8], ['30', 921, 635, 1037, 848, 67.0, 60.8], ['31', 1037, 635, 1153, 848, 67.0, 60.8], ['32', 1153, 635, 1265, 848, 61.6, 55.8],
  ['16', 810, 882, 921, 1095, 66.3, 61.6], ['15', 921, 882, 1037, 1095, 66.1, 61.1], ['12B', 1037, 882, 1153, 1095, 66.1, 61.1], ['12A', 1153, 882, 1265, 1095, 66.3, 61.6],
];
const MX = (x) => 2075 - x;
const SLOTS_RAW = [
  ...LEFT,
  ...LEFT.map(([k, x0, y0, x1, y1]) => [MIRROR[k], MX(x1), y0, MX(x0), y1, ...RIGHT_AREAS[MIRROR[k]]]),
  ...MID,
];
/**
 * Hướng đặt căn mẫu vào từng vị trí, đối chiếu bản vẽ mặt bằng tầng: [số lần xoay 90° theo chiều kim đồng hồ, lật trái–phải].
 * Cánh phải đối xứng cánh trái; các căn sát nhau thường lật đối xứng qua vách chung (chung hộp WC / bếp).
 */
const ORIENT_LEFT = { 24: [3, 0], 25: [0, 1], 26: [1, 0], 27: [1, 0], 28: [1, 0], 23: [3, 1], 22: [3, 0], 21: [3, 1], 20: [3, 0], 19: [3, 1], 18: [2, 0], 17: [0, 1] };
export const SLOT_ORIENT = {
  ...Object.fromEntries(Object.entries(ORIENT_LEFT).flatMap(([k, [r, m]]) => [[k, { k: r, m: !!m }], [MIRROR[k], { k: (4 - r) % 4, m: !m }]])),
  29: { k: 0, m: false }, 30: { k: 0, m: false }, 31: { k: 0, m: true }, 32: { k: 0, m: true },
  16: { k: 2, m: false }, 15: { k: 2, m: true }, '12B': { k: 2, m: false }, '12A': { k: 2, m: true },
};
/** Góc bo của tòa trùng góc căn (bán kính m) */
export const SLOT_RADII = { 24: { tl: 4.2 }, 26: { tr: 3 }, '03': { tl: 3 }, '05': { tr: 4.2 }, 19: { bl: 4.2 }, 17: { br: 3 }, 12: { bl: 3 }, 10: { br: 4.2 } };
// Khung đặt căn chi tiết khi căn có hình chữ L (rộng hơn ô tô màu)
export const FIT_RECTS = { 24: [440, 340, 628, 555], '05': [MX(628), 340, MX(440), 555], 19: [440, 975, 630, 1135], 10: [MX(630), 975, MX(440), 1135] };
// Hành lang / sảnh thang (để tìm phía cửa vào của từng căn)
export const CORRIDORS = [
  [628, 470, 655, 1010], [628, 470, 690, 535], [630, 970, 690, 1010],
  [MX(655), 470, MX(628), 1010], [MX(690), 470, MX(628), 535], [MX(690), 970, MX(630), 1010],
  [655, 848, MX(655), 882],
];
// Lõi thang & hành lang (không bán)
export const CORES = [
  ...CORRIDORS,
  [655, 740, 810, 848], [655, 882, 810, 970], [MX(810), 740, MX(655), 848], [MX(810), 882, MX(655), 970],
];
// Khối đế thương mại (tầng 1–2)
export const PODIUM = [440, 340, 1635, 1135];

/** Diện tích tầng 8–19 theo bảng của chủ đầu tư (tim, thông thủy) */
const AREAS_8_19 = {
  24: [94.9, 86.3], 25: [33.9, 30.1], 26: [65.4, 58.7], '03': [65.4, 58.7], '03A': [33.9, 30.1], '05': [94.9, 86.3],
  27: [36.8, 32.6], 28: [46.5, 41.8], 29: [61.6, 55.8], 30: [67.0, 60.8], 31: [67.0, 60.8], 32: [61.6, 55.8], '02': [36.8, 32.6], '01': [46.5, 41.8],
  23: [58.4, 53.0], 22: [58.4, 53.0], 21: [58.4, 53.0], '06': [58.4, 53.0], '07': [58.4, 53.0], '08': [58.4, 53.0],
  20: [38.2, 33.2], '09': [38.2, 33.2], 19: [70.5, 63.4], 10: [70.5, 63.2], 18: [33.9, 30.1], 17: [52.3, 47.5],
  16: [67.0, 61.0], 15: [67.0, 61.0], '12B': [67.0, 61.0], '12A': [67.0, 61.0], 12: [55.3, 50.2], 11: [33.9, 30.1],
};
/** Diện tích (tim, thông thủy) của một căn theo tầng */
// Diện tích căn tầng 3 / 3A–7 khác tầng điển hình (các căn giữa)
const AREAS_LOW = {
  '03': { 27: [36.8, 32.9], '02': [36.9, 32.9], 28: [46.5, 32.9], '01': [46.5, 42.3], 30: [59.1, 54.6], 31: [59.1, 54.6], 29: [54.4, 50.1], 32: [54.4, 50.1] },
  mid: { 27: [36.8, 32.6], '02': [36.8, 32.6], 28: [46.5, 41.8], '01': [46.5, 41.8], 30: [67.0, 60.8], 31: [67.0, 60.8], 29: [61.6, 55.8], 32: [61.6, 55.8] },
};
export function areaOf(floor, s) {
  const low = floor === '03' ? AREAS_LOW['03'] : ['03A', '05', '06', '07'].includes(floor) ? AREAS_LOW.mid : null;
  if (low?.[s.slot]) return { tim: low[s.slot][0], tt: low[s.slot][1] };
  const n = parseInt(floor, 10);
  const a = n >= 8 && n <= 19 ? AREAS_8_19[s.slot] : null;
  return a ? { tim: a[0], tt: a[1] } : { tim: s.tim, tt: s.tt };
}

const CX = (440 + 1635) / 2, CY = (340 + 1135) / 2;
const toM = (x, y) => ({ x: (x - CX) * PX_TO_M, y: (y - CY) * PX_TO_M });
export const rectM = ([x0, y0, x1, y1]) => { const a = toM(x0, y0), b = toM(x1, y1); return { x0: a.x, y0: a.y, x1: b.x, y1: b.y }; };


// ---------------- Khối đế: shop tầng 1, thương mại + hồ bơi tầng 2 ----------------
// Tầng 1: đo trên bản vẽ "Mặt bằng tầng 1" (ảnh thu 1600 px, khung ngoài 365,305 → 1245,925), quy về khung khối đế
// (thân tháp mở rộng 3 m mỗi phía). [mã, x0, y0, x1, y1, tim, thông thủy]
const F1_SRC = [365, 305, 1245, 925];
const POD_PX = [440 - 58, 340 - 58, 1635 + 58, 1135 + 58];
const F1 = [
  ['21', 365, 305, 515, 395, 65.3, 60.3], ['20', 365, 395, 515, 480, 70.8, 64.8], ['22', 515, 305, 585, 480, 64.2, 58.4], ['23', 585, 305, 665, 610, 139.6, 129.7],
  ['19', 365, 480, 585, 560, 99.5, 92.4], ['18', 365, 560, 585, 610, 56.3, 51.6], ['17', 365, 640, 535, 720, 76.2, 70.2], ['16', 365, 720, 535, 815, 86.3, 80.7],
  ['15', 365, 815, 515, 925, 88.0, 81.5], ['12B', 515, 790, 585, 925, 52.4, 48.2], ['12A', 585, 770, 665, 925, 70.4, 64.4], ['12', 665, 720, 750, 900, 98.9, 90.4],
  ['11', 750, 720, 860, 860, 108.3, 98.6], ['24', 665, 390, 745, 550, 71.2, 67.0], ['25', 745, 390, 825, 550, 73.0, 69.3], ['26', 665, 550, 825, 690, 91.8, 84.9],
  ['27', 905, 560, 985, 650, 55.5, 50.7], ['01', 985, 305, 1065, 530, 103.1, 94.8], ['02', 1065, 305, 1135, 480, 64.2, 57.5], ['03', 1135, 305, 1245, 480, 103.5, 96.7],
  ['03A', 1065, 480, 1245, 560, 70.8, 65.0], ['05', 1110, 560, 1245, 610, 57.2, 51.2], ['06', 1110, 640, 1245, 770, 89.5, 83.1], ['07', 1135, 770, 1245, 925, 88.2, 80.8],
  ['08', 1065, 790, 1135, 925, 49.7, 45.8], ['09', 985, 770, 1065, 925, 73.4, 66.3], ['10', 890, 720, 985, 925, 102.7, 94.4],
];
const mapBox = (src, dst, [x0, y0, x1, y1]) => {
  const fx = (x) => dst[0] + ((x - src[0]) / (src[2] - src[0])) * (dst[2] - dst[0]);
  const fy = (y) => dst[1] + ((y - src[1]) / (src[3] - src[1])) * (dst[3] - dst[1]);
  return [fx(x0), fy(y0), fx(x1), fy(y1)];
};
const m2 = ([x0, y0, x1, y1]) => (x1 - x0) * (y1 - y0) * PX_TO_M * PX_TO_M;
// Tầng 2 (theo bản vẽ "Mặt bằng tầng 2", quy về toạ độ thân tháp): cánh trái + giữa là thương mại, cánh phải là căn hộ,
// sân giữa hai cánh là sàn hồ bơi ngoài trời
const F2 = [
  ['TM-A', [440, 340, 628, 1135], 'shop'], ['TM-B', [810, 635, 1265, 848], 'shop'], ['TM-C', [628, 905, 1265, 1135], 'shop'],
];
const F2_APTS = { '03': [55.8, 50.3, 12.4, 9.3], '03A': [33.7, 30.2, 10.9, 8.1], '05': [94.5, 85.4, 16.4, 12.1], '06': [58.4, 52.6], '07': [58.4, 52.6], '08': [58.4, 52.6], '09': [38.2, 32.9], 10: [70.1, 63.2, 24.7, 22.6], 11: [33.7, 30.2, 16.1, 14.1], 12: [53.6, 49.1, 19.2, 17.4] };
export const POOL_DECK = [810, 340, 1265, 635];
export const POOL = [850, 420, 1225, 560];
export const SHOP_FLOORS = ['01', '02'];
export const SHOPS = [
  ...F1.map(([k, ...r]) => { const px = mapBox(F1_SRC, POD_PX, r.slice(0, 4)); return { slot: 'S' + k, label: k, floor: '01', px, rect: rectM(px), tim: r[4], tt: r[5], type: 'Shop', shop: true }; }),
  ...F2.map(([k, px, kind]) => ({ slot: k, label: k === 'CH' ? 'Căn hộ' : k, floor: '02', px, rect: rectM(px), tim: +m2(px).toFixed(1), tt: +(m2(px) * 0.92).toFixed(1), type: kind === 'shop' ? 'Shop' : '2PN', shop: kind === 'shop', apt: kind === 'apt' })),
  // Tầng 2 cánh phải: 10 căn hộ có sân vườn (theo bảng mặt bằng tầng 2)
  ...Object.entries(F2_APTS).map(([k, [tim, tt, bt, btt]]) => { const sl = SLOTS_RAW.find((x) => x[0] === k); const px = sl.slice(1, 5); return { slot: k, label: k, floor: '02', px, rect: rectM(px), fit: rectM(FIT_RECTS[k] || px), tim, tt, garden: bt ? { tim: bt, tt: btt } : null, type: unitType(tt), apt: true }; }),
];

export function unitType(tt) {
  if (tt < 35) return 'Studio';
  if (tt < 45) return '1PN';
  if (tt < 50) return '1PN+';
  if (tt < 62) return '2PN';
  if (tt < 75) return '2PN+';
  return '3PN';
}
export const TYPE_COLORS = { Shop: '#8e6cc9', Studio: '#7fb3c8', '1PN': '#6aa0b8', '1PN+': '#b07a5c', '2PN': '#3d8a3d', '2PN+': '#f2b134', '3PN': '#ef6b4a' };

export const SLOT_LIST = SLOTS_RAW.map(([slot, x0, y0, x1, y1, tim, tt]) => ({ slot, rect: rectM([x0, y0, x1, y1]), fit: rectM(FIT_RECTS[slot] || [x0, y0, x1, y1]), tim, tt, type: unitType(tt) }));

/** Mặt bằng chi tiết mặc định cho từng vị trí (theo các căn mẫu đã dựng; vị trí chưa có ảnh mặt bằng thì để trống) */
export const DEFAULT_UNIT = {
  // Theo bản vẽ từng loại căn (ô đỏ trên sơ đồ định vị của mỗi bản vẽ)
  24: '3pn', '05': '3pn', 26: '2pn-b', '03': '2pn-b', 19: '2pn-a', 10: '2pn-a',
  // căn 27 / 02: Studio 5,315 × 6,82 m; căn 28 / 01: 1PN 4,65 × 8,08 m (ô đỏ trên sơ đồ bản vẽ 1PN)
  27: 'studio', '02': 'studio', 28: '1pn', '01': '1pn',
  25: 'studio', '03A': 'studio', 18: 'studio', 11: 'studio', 20: 'studio-b', '09': 'studio-b',
  23: '1pn-plus-b', 22: '1pn-plus-b', 21: '1pn-plus-b', '06': '1pn-plus-b', '07': '1pn-plus-b', '08': '1pn-plus-b',
  17: '1pn-plus-c', 12: '1pn-plus-c',
  29: '2pn-c', 32: '2pn-c', 30: '2pn-1wc', 31: '2pn-1wc', 16: '2pn-1wc', 15: '2pn-1wc', '12B': '2pn-1wc', '12A': '2pn-1wc',
};
/** Vị trí đang ghép tạm (mặt bằng chưa đúng căn thật) */
export const PROVISIONAL = new Set();

export const STATUS = {
  available: { name: 'Còn trống', color: '#22a06b' },
  hold: { name: 'Giữ chỗ', color: '#e2b203' },
  deposit: { name: 'Đã đặt cọc', color: '#f97316' },
  sold: { name: 'Đã bán', color: '#dc2626' },
  locked: { name: 'Không mở bán', color: '#8590a2' },
};

/** Danh sách tầng ở (bỏ số 4 → 3A, 13 → 12A theo thông lệ) */
/** Tầng có sân vườn riêng bao quanh (tầng 3A → 7) */
export const GARDEN_FLOORS = new Set(['03', '03A', '05', '06', '07']);

// Diện tích sân vườn / ban công [tim, thông thủy] theo bảng mặt bằng tầng 3, 3A, 5, 6 (tầng 7 lấy như tầng 6).
// Căn 06–09 không có sân vườn; các căn giữa 01, 02, 27–32 chỉ có ở tầng 3.
const BC = (o) => Object.fromEntries(Object.entries(o).map(([k, v]) => [k, v]));
const SIDE_3A = { 24: [56.9, 47.6], 25: [10.9, 8.0], 26: [12.4, 9.3], '03': [12.4, 9.3], '03A': [10.9, 8.0], '05': [16.4, 12.4], 20: [12.2, 9.8], 19: [60.1, 51.5], 10: [24.7, 20.0], 18: [16.1, 13.0], 11: [16.1, 13.0], 15: [21.4, 18.1], '12B': [21.4, 18.1] };
export const GARDEN_AREA = {
  '03': BC({ ...SIDE_3A, '03A': [10.9, 8.1], 23: [18.0, 14.8], 22: [18.0, 14.8], 21: [18.0, 14.8], 18: [16.1, 12.9], 11: [16.1, 12.9], 17: [19.2, 15.9], 12: [19.2, 15.9], 16: [29.9, 26.1], '12A': [29.9, 26.1],
    27: [6.2, 5.0], '02': [6.2, 5.0], 28: [7.6, 6.2], '01': [7.6, 6.2], 30: [74.5, 69.0], 31: [74.5, 69.0], 29: [30.3, 27.3], 32: [30.3, 27.3] }),
  '03A': BC({ ...SIDE_3A, 23: [13.5, 10.3], 22: [13.5, 10.3], 21: [13.5, 10.3], 17: [19.2, 15.9], 12: [19.2, 15.9], 16: [25.4, 21.6], '12A': [25.4, 21.6] }),
  '05': BC({ ...SIDE_3A, 24: [56.1, 47.0], 23: [9.7, 6.9], 22: [9.7, 6.9], 21: [9.7, 6.9], 20: [11.5, 9.0], 17: [18.9, 15.6], 12: [18.9, 15.6], 16: [21.5, 18.2], '12A': [21.5, 18.2] }),
  '06': BC({ ...SIDE_3A, 24: [51.6, 42.5], 23: [9.7, 6.9], 22: [9.7, 6.9], 21: [9.7, 6.9], 20: [6.3, 4.3], 19: [59.4, 50.8], 17: [14.0, 10.7], 12: [14.0, 10.7], 16: [21.5, 18.2], '12A': [21.5, 18.2] }),
};
GARDEN_AREA['07'] = GARDEN_AREA['06'];
GARDEN_AREA['02'] = Object.fromEntries(Object.entries(F2_APTS).filter(([, v]) => v[2]).map(([k, v]) => [k, [v[2], v[3]]]));
/** Diện tích sân vườn của căn (null nếu không có) */
export function gardenOf(floor, slot) { const a = GARDEN_AREA[floor]?.[slot]; return a ? { tim: a[0], tt: a[1] } : null; }
/**
 * Chỉnh dáng sân vườn riêng theo vị trí khi khác căn mẫu (đối chiếu bản vẽ tầng):
 * căn 05 chỉ có 1 dải BC phía trước bo góc tòa (không ôm chữ L như căn 24).
 */
export const GARDEN_SHAPE = { '05': { wrap: null, round: 'start' }, 27: { bevel: 'endIn' }, '02': { bevel: 'endIn' }, 28: { span: [0, 2.4], bevel: 'start' }, '01': { span: [0, 2.4], bevel: 'start' } };
/** Căn mẫu sân vườn tương ứng với căn gốc */
export const GARDEN_UNIT = { '1pn-plus-b': 'sv-1pn-plus', '2pn-1wc': 'sv-2pn-1wc', '2pn-b': 'sv-2pn-2wc', '3pn': 'sv-3pn', studio: 'sv-studio', 'studio-b': 'sv-studio-b', '1pn': 'sv-1pn', '1pn-plus-c': 'sv-1pn-plus-l', '2pn-c': 'sv-2pn-c', '2pn-a': 'sv-2pn-a' };

export function residentialFloors(top) {
  const out = [];
  for (let n = 3; out.length < top; n++) {
    if (n === 4) out.push('03A');
    else if (n === 13) out.push('12A');
    else out.push(String(n).padStart(2, '0'));
  }
  return out;
}

function rand(seed) { let s = seed >>> 0; return () => ((s = (s * 1664525 + 1013904223) >>> 0) / 4294967296); }

/** Dữ liệu mẫu (trạng thái, giá) để minh hoạ – người dùng sửa trực tiếp trên tòa nhà */
export function sampleBuilding() {
  const b = { name: 'Tòa F2', code: 'F2', floors: 22, floorHeight: 3.3, podiumFloors: 2, podiumHeight: 4.8, pricePerM2: 45, units: {}, layouts: {}, sample: true };
  const r = rand(2026);
  residentialFloors(b.floors).forEach((fl, fi) => {
    for (const s of SLOT_LIST) {
      const x = r();
      const status = fi > 17 ? (x < 0.6 ? 'locked' : 'available') : x < 0.42 ? 'sold' : x < 0.55 ? 'deposit' : x < 0.63 ? 'hold' : 'available';
      b.units[`${fl}-${s.slot}`] = { status };
    }
  });
  for (const s of SHOPS) if (s.shop || s.apt) { const x = r(); b.units[`${s.floor}-${s.slot}`] = { status: x < 0.35 ? 'sold' : x < 0.45 ? 'deposit' : 'available' }; }
  return b;
}

export function unitCode(b, floor, slot) { return `${b.code}-${floor}-${String(slot).replace(/^S/, '')}`; }

/** Giá ước tính (tỷ đồng): đơn giá × diện tích thông thủy, tầng cao +0,6%/tầng, căn góc +4% */
export function unitPrice(b, floorIndex, s) {
  if (s.shop || s.apt) { const u = b.units[`${s.floor}-${s.slot}`]; return u?.price || Math.round(s.tt * (s.apt ? b.pricePerM2 * 0.97 : s.floor === '01' ? 110 : 70)) / 1000; }
  const u = b.units[`${residentialFloors(b.floors)[floorIndex]}-${s.slot}`];
  if (u?.price) return u.price;
  const corner = ['24', '05', '19', '10'].includes(s.slot) ? 1.04 : 1;
  const tt = areaOf(residentialFloors(b.floors)[floorIndex], s).tt;
  return Math.round(tt * b.pricePerM2 * (1 + floorIndex * 0.006) * corner) / 1000;
}
