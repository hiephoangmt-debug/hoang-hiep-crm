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
const SLOTS = [
  ...LEFT,
  ...LEFT.map(([k, x0, y0, x1, y1]) => [MIRROR[k], MX(x1), y0, MX(x0), y1, ...RIGHT_AREAS[MIRROR[k]]]),
  ...MID,
];
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
export function areaOf(floor, s) {
  const n = parseInt(floor, 10);
  const a = n >= 8 && n <= 19 ? AREAS_8_19[s.slot] : null;
  return a ? { tim: a[0], tt: a[1] } : { tim: s.tim, tt: s.tt };
}

const CX = (440 + 1635) / 2, CY = (340 + 1135) / 2;
const toM = (x, y) => ({ x: (x - CX) * PX_TO_M, y: (y - CY) * PX_TO_M });
export const rectM = ([x0, y0, x1, y1]) => { const a = toM(x0, y0), b = toM(x1, y1); return { x0: a.x, y0: a.y, x1: b.x, y1: b.y }; };

export function unitType(tt) {
  if (tt < 35) return 'Studio';
  if (tt < 45) return '1PN';
  if (tt < 50) return '1PN+';
  if (tt < 62) return '2PN';
  if (tt < 75) return '2PN+';
  return '3PN';
}
export const TYPE_COLORS = { Studio: '#7fb3c8', '1PN': '#6aa0b8', '1PN+': '#b07a5c', '2PN': '#3d8a3d', '2PN+': '#f2b134', '3PN': '#ef6b4a' };

export const SLOT_LIST = SLOTS.map(([slot, x0, y0, x1, y1, tim, tt]) => ({ slot, rect: rectM([x0, y0, x1, y1]), fit: rectM(FIT_RECTS[slot] || [x0, y0, x1, y1]), tim, tt, type: unitType(tt) }));

/** Mặt bằng chi tiết mặc định cho từng vị trí (theo các căn mẫu đã dựng; vị trí chưa có ảnh mặt bằng thì để trống) */
export const DEFAULT_UNIT = { 24: '3pn', '05': '3pn', 26: '1pn-plus', '03': '1pn-plus', 19: '2pn-a', 10: '2pn-a', 27: '1pn', '02': '1pn', 20: '1pn', '09': '1pn' };

export const STATUS = {
  available: { name: 'Còn trống', color: '#22a06b' },
  hold: { name: 'Giữ chỗ', color: '#e2b203' },
  deposit: { name: 'Đã đặt cọc', color: '#f97316' },
  sold: { name: 'Đã bán', color: '#dc2626' },
  locked: { name: 'Không mở bán', color: '#8590a2' },
};

/** Danh sách tầng ở (bỏ số 4 → 3A, 13 → 12A theo thông lệ) */
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
  return b;
}

export function unitCode(b, floor, slot) { return `${b.code}-${floor}-${slot}`; }

/** Giá ước tính (tỷ đồng): đơn giá × diện tích thông thủy, tầng cao +0,6%/tầng, căn góc +4% */
export function unitPrice(b, floorIndex, s) {
  const u = b.units[`${residentialFloors(b.floors)[floorIndex]}-${s.slot}`];
  if (u?.price) return u.price;
  const corner = ['24', '05', '19', '10'].includes(s.slot) ? 1.04 : 1;
  const tt = areaOf(residentialFloors(b.floors)[floorIndex], s).tt;
  return Math.round(tt * b.pricePerM2 * (1 + floorIndex * 0.006) * corner) / 1000;
}
