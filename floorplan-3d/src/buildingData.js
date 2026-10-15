// Dữ liệu tòa F2: vị trí 32 căn trên mặt bằng tầng điển hình (đo từ bản vẽ tầng 3/5,
// đơn vị pixel ảnh 2000×1414) và diện tích tim tường / thông thủy theo bảng của chủ đầu tư.
export const PX_TO_M = 0.0515;

// [mã vị trí, x0, y0, x1, y1, tim (m²), thông thủy (m²)]
const SLOTS = [
  ['24', 440, 330, 600, 545, 94.3, 87.0], ['25', 600, 330, 700, 470, 33.7, 30.4], ['26', 700, 330, 820, 525, 65.5, 59.6],
  ['23', 440, 545, 630, 660, 58.1, 53.5], ['22', 440, 660, 630, 778, 58.1, 53.5], ['21', 440, 778, 630, 900, 58.1, 53.5],
  ['20', 440, 900, 630, 975, 37.8, 33.7], ['19', 440, 975, 600, 1140, 70.1, 64.0], ['18', 600, 1005, 700, 1140, 33.7, 30.4],
  ['17', 700, 975, 820, 1140, 52.4, 48.4], ['27', 665, 530, 820, 620, 36.8, 32.6], ['28', 665, 620, 820, 740, 46.5, 41.8],
  ['29', 820, 630, 940, 850, 61.6, 55.8], ['30', 940, 630, 1055, 850, 67.0, 60.8], ['31', 1055, 630, 1175, 850, 67.0, 60.8],
  ['32', 1175, 630, 1290, 850, 61.6, 55.8], ['16', 820, 885, 940, 1100, 66.3, 61.6], ['15', 940, 885, 1055, 1100, 66.1, 61.1],
  ['12B', 1055, 885, 1175, 1100, 66.1, 61.1], ['12A', 1175, 885, 1290, 1100, 66.3, 61.6],
  ['03', 1290, 330, 1410, 525, 65.5, 59.6], ['03A', 1410, 330, 1510, 470, 33.7, 30.4], ['05', 1510, 330, 1670, 545, 94.5, 86.3],
  ['02', 1290, 530, 1445, 620, 36.8, 32.6], ['01', 1290, 620, 1445, 740, 46.5, 41.8],
  ['06', 1480, 545, 1670, 660, 58.4, 53.0], ['07', 1480, 660, 1670, 778, 58.4, 53.0], ['08', 1480, 778, 1670, 900, 58.4, 53.0],
  ['09', 1480, 900, 1670, 975, 38.2, 33.2], ['10', 1510, 975, 1670, 1140, 70.1, 63.7], ['11', 1410, 1005, 1510, 1140, 33.7, 30.4],
  ['12', 1290, 975, 1410, 1140, 55.4, 51.0],
];
// Lõi thang & hành lang (không bán)
export const CORES = [
  [665, 740, 820, 850], [665, 900, 820, 975], [1290, 740, 1445, 850], [1290, 900, 1445, 975],
  [630, 470, 665, 1005], [665, 850, 1445, 885], [1445, 470, 1480, 1005], [600, 470, 700, 530], [1410, 470, 1510, 530],
];
// Khối đế thương mại (tầng 1–2)
export const PODIUM = [440, 330, 1670, 1140];

const CX = (440 + 1670) / 2, CY = (330 + 1140) / 2;
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

export const SLOT_LIST = SLOTS.map(([slot, x0, y0, x1, y1, tim, tt]) => ({ slot, rect: rectM([x0, y0, x1, y1]), tim, tt, type: unitType(tt) }));

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
  return Math.round(s.tt * b.pricePerM2 * (1 + floorIndex * 0.006) * corner) / 1000;
}
