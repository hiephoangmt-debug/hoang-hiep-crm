// Gói hoàn thiện nội thất theo từng loại căn: liệt kê đồ cần cho từng phòng (tính từ mặt bằng thật của căn)
// và đơn giá tham khảo cho 3 hạng gói. Giá: triệu đồng, thị trường Đà Nẵng, đã gồm lắp đặt, chưa gồm VAT.
import { polygonArea } from './geom.js';

export const TIERS = [
  { key: 'basic', name: 'Cơ bản', desc: 'Gỗ MDF chống ẩm phủ melamine, thiết bị thương hiệu phổ thông – đủ ở / cho thuê ngay' },
  { key: 'std', name: 'Tiêu chuẩn', desc: 'Gỗ An Cường MDF lõi xanh phủ acrylic / laminate, thiết bị tầm trung (Samsung, LG, Panasonic, Malloca)' },
  { key: 'lux', name: 'Cao cấp', desc: 'Veneer gỗ óc chó, cánh kính khói, phụ kiện Blum/Hafele, thiết bị nhập khẩu (Bosch, Hafele, Sony)' },
];

// [tên, quy cách cho từng hạng, đơn giá (triệu) cơ bản / tiêu chuẩn / cao cấp]
const P = {
  kitchen: ['Tủ bếp trên + dưới', ['MDF melamine, mặt đá nhân tạo', 'MDF lõi xanh acrylic, mặt đá thạch anh', 'Veneer óc chó, mặt đá nung kết, ray giảm chấn Blum'], [5, 8, 14], 'md'],
  hob: ['Bếp từ đôi', ['Sunhouse / Kangaroo', 'Malloca / Teka', 'Bosch Serie 6 / Hafele'], [5, 11, 26]],
  hood: ['Máy hút mùi', ['Âm tủ 70 cm', 'Kính cong 70 cm', 'Bosch / Hafele âm tủ'], [3, 6, 14]],
  sink: ['Chậu rửa + vòi', ['Inox 2 hố', 'Inox đúc + vòi rút', 'Đá granite + vòi Grohe'], [2, 4, 9]],
  micro: ['Lò vi sóng / lò nướng', ['Lò vi sóng 20 L', 'Lò vi sóng có nướng', 'Lò nướng âm tủ Bosch'], [2, 3.5, 16]],
  fridge: ['Tủ lạnh', ['Inverter 2 cánh ~250 L', 'Inverter ngăn đá dưới ~350 L', 'Side-by-side / 4 cánh ~600 L'], [7, 13, 32]],
  dining: ['Bàn ăn + ghế', ['Mặt gỗ / ghế nệm', 'Mặt đá + ghế bọc da', 'Mặt đá nung kết chân gỗ óc chó'], [4, 9, 24], 'ghế'],
  sofa: ['Sofa', ['Sofa nỉ văng 2 m', 'Sofa da góc L', 'Sofa da Ý / vải bouclé module'], [7, 16, 45]],
  coffee: ['Bàn trà', ['Gỗ MDF', 'Mặt đá tròn', 'Bàn trà đôi đá + óc chó'], [1.5, 4, 11]],
  tvStand: ['Kệ tivi + vách ốp trang trí', ['Kệ treo MDF', 'Kệ + ốp lam gỗ', 'Vách ốp đá / óc chó + kệ treo, đèn LED'], [3, 8, 22]],
  tv: ['Tivi', ['55" 4K', '65" 4K QLED', '75" OLED / Neo QLED'], [9, 17, 42]],
  rug: ['Thảm phòng khách', ['Thảm 1,6 × 2,3 m', 'Thảm lông ngắn 2 × 3 m', 'Thảm dệt tay 2 × 3 m'], [1.2, 3, 9]],
  shoe: ['Tủ giày + tủ đồ cửa vào', ['MDF melamine', 'MDF acrylic, gương', 'Óc chó + kính khói, đèn LED'], [3, 5.5, 11]],
  ac: ['Điều hoà inverter', ['9.000 BTU (Casper / Nagakawa)', '9–12.000 BTU (Daikin / Panasonic)', '12.000 BTU multi (Daikin / Mitsubishi)'], [7.5, 11, 18], 'bộ'],
  bedM: ['Giường 1m8 × 2m', ['MDF melamine', 'Giường bọc nệm đầu giường', 'Óc chó, đầu giường bọc da'], [5, 9, 22]],
  bedS: ['Giường 1m6 × 2m', ['MDF melamine', 'Giường bọc nệm đầu giường', 'Óc chó, đầu giường bọc vải'], [4, 7.5, 17]],
  mattM: ['Nệm 1m8', ['Nệm foam Vạn Thành', 'Nệm lò xo túi Everon / Liên Á', 'Nệm cao su thiên nhiên / Tempur'], [3, 7, 20]],
  mattS: ['Nệm 1m6', ['Nệm foam', 'Nệm lò xo túi', 'Nệm cao su thiên nhiên'], [2.5, 6, 15]],
  wardrobe: ['Tủ áo kịch trần', ['MDF melamine cánh mở', 'MDF acrylic cánh lùa', 'Khung nhôm cánh kính khói, đèn LED'], [4, 6, 10], 'md'],
  nightstand: ['Tab đầu giường', ['MDF', 'Gỗ có ngăn kéo', 'Óc chó + đèn ngủ'], [0.8, 1.6, 4], 'cái'],
  headboard: ['Ốp tường đầu giường', ['Giấy dán tường', 'Ốp nỉ / lam gỗ', 'Ốp da + óc chó, LED hắt'], [1.5, 4, 10]],
  vanityTbl: ['Bàn trang điểm / làm việc', ['MDF', 'MDF + gương đèn', 'Óc chó + gương LED'], [1.5, 3.5, 9]],
  curtain: ['Rèm 2 lớp (voan + cản sáng)', ['Rèm vải', 'Rèm vải chống nắng ray êm', 'Rèm mô tơ điện'], [1.8, 3.5, 9], 'bộ'],
  multi: ['Sofa giường + bàn làm việc', ['Sofa giường nỉ', 'Sofa giường + kệ sách', 'Giường gấp âm tường + bàn'], [5, 9, 22]],
  wcCab: ['Tủ lavabo + gương', ['Tủ nhựa PVC + gương', 'Tủ chống nước + gương đèn', 'Tủ đá + gương LED chống mờ'], [2.5, 5, 13]],
  wcGlass: ['Vách kính tắm', ['Kính cường lực 8 ly', 'Kính 10 ly phụ kiện inox 304', 'Kính 10 ly khung đen, cửa lùa'], [3.5, 5.5, 10]],
  heater: ['Máy nước nóng', ['Ariston 20 L', 'Ariston / Ferroli 30 L', 'Trực tiếp có bơm / Ariston Andris'], [2.5, 4, 7]],
  washer: ['Máy giặt', ['Cửa trên 9 kg', 'Cửa trước 10 kg inverter', 'Máy giặt sấy 12 kg'], [6, 10, 22]],
  rack: ['Giàn phơi thông minh', ['Giàn kéo tay', 'Giàn điều khiển', 'Giàn điện có sấy, đèn UV'], [1.5, 3, 7]],
  outdoor: ['Bàn ghế ngoài trời', ['Bộ bàn ghế nhựa giả mây', 'Bộ mây + nệm chống nước', 'Ghế thư giãn + bàn đá, ô dù'], [3, 8, 22]],
  plants: ['Cây xanh, chậu, đèn sân', ['Chậu cây cơ bản', 'Cây cảnh + đèn sân', 'Tiểu cảnh + tưới tự động'], [3, 7, 18]],
  light: ['Đèn trang trí', ['Đèn LED âm trần', 'Đèn thả bàn ăn + LED hắt', 'Đèn thiết kế + công tắc thông minh'], [2, 5, 14]],
};

const ti = (k) => TIERS.findIndex((t) => t.key === k);

/** Danh sách gói theo phòng của căn + đơn giá theo hạng (giá triệu đồng). */
export function furniturePackage(plan, tier = 'std') {
  const t = Math.max(0, ti(tier));
  const rooms = plan.rooms;
  const fur = plan.furniture || [];
  const inRoom = (f, r) => {
    const ps = r.points; let c = false;
    for (let i = 0, j = ps.length - 1; i < ps.length; j = i++) if ((ps[i].y > f.y) !== (ps[j].y > f.y) && f.x < ((ps[j].x - ps[i].x) * (f.y - ps[i].y)) / (ps[j].y - ps[i].y) + ps[i].x) c = !c;
    return c;
  };
  const item = (k, qty = 1, unit, note) => {
    const [name, spec, price, u] = P[k];
    return { key: k, name, spec: spec[t], qty: +qty.toFixed(1), unit: unit || u || 'bộ', price: price[t], total: +(price[t] * qty).toFixed(1), note };
  };
  const groups = [];
  const beds = rooms.filter((r) => /ngủ/i.test(r.name)).sort((a, b) => polygonArea(b.points) - polygonArea(a.points));
  const wcs = rooms.filter((r) => /wc|tắm/i.test(r.name));
  const multi = rooms.filter((r) => /đa năng/i.test(r.name));
  const living = rooms.find((r) => /khách/i.test(r.name));
  const studio = !beds.length;

  // Bếp: mét dài tủ bếp theo mặt bằng (tủ trên + dưới)
  const md = fur.filter((f) => f.type === 'kitchen').reduce((s, f) => s + (f.w || 1.8), 0) || 2.4;
  const big = beds.length >= 2;
  groups.push({ name: 'Bếp', icon: '🍳', items: [item('kitchen', md), item('hob'), item('hood'), item('sink'), item('micro'), item('fridge')] });

  // Phòng khách + ăn
  const seats = beds.length >= 3 ? 6 : big ? 4 : 2;
  const lv = [item('dining', 1, 'bộ', `${seats} ghế`), item('sofa'), item('coffee'), item('tvStand'), item('tv'), item('rug'), item('shoe'), item('ac', 1, 'bộ', 'phòng khách'), item('curtain', 1, 'bộ'), item('light')];
  if (studio) lv.splice(1, 0, item('bedM', 1, 'cái', 'khu ngủ'), item('mattM', 1, 'cái'), item('wardrobe', fur.find((f) => f.type === 'wardrobe')?.w || 1.6));
  groups.push({ name: studio ? 'Phòng chính (ngủ + khách + ăn)' : 'Phòng khách & ăn', icon: '🛋', items: lv });

  // Phòng ngủ: phòng lớn nhất là phòng ngủ chính (giường 1m8), các phòng còn lại 1m6
  beds.forEach((r, i) => {
    const wd = fur.filter((f) => f.type === 'wardrobe' && inRoom(f, r)).reduce((s, f) => s + (f.w || 1.6), 0) || 1.6;
    groups.push({
      name: `${r.name}${i === 0 && beds.length > 1 ? ' (master)' : ''}`, icon: '🛏',
      items: [item(i === 0 ? 'bedM' : 'bedS', 1, 'cái'), item(i === 0 ? 'mattM' : 'mattS', 1, 'cái'), item('wardrobe', wd), item('nightstand', i === 0 ? 2 : 1), item('headboard'), ...(i === 0 ? [item('vanityTbl')] : []), item('ac'), item('curtain')],
    });
  });
  multi.forEach((r) => groups.push({ name: r.name, icon: '💼', items: [item('multi'), item('curtain')] }));

  // WC: thiết bị vệ sinh (bồn cầu, lavabo, sen) CĐT bàn giao – gói chỉ bổ sung tủ, vách kính, nước nóng
  if (wcs.length) groups.push({ name: `WC (${wcs.length} phòng)`, icon: '🚿', note: 'Bồn cầu, lavabo, sen tắm do chủ đầu tư bàn giao', items: [item('wcCab', wcs.length), item('wcGlass', wcs.length), item('heater', wcs.length)] });

  // Lô gia
  groups.push({ name: 'Lô gia', icon: '🧺', items: [item('washer'), item('rack')] });

  // Ban công sân vườn
  if (rooms.some((r) => /sân vườn/i.test(r.name))) groups.push({ name: 'Ban công sân vườn', icon: '🌳', items: [item('outdoor'), item('plants')] });

  for (const g of groups) g.total = +g.items.reduce((s, x) => s + x.total, 0).toFixed(1);
  const total = +groups.reduce((s, g) => s + g.total, 0).toFixed(1);
  // Nội thất dính tường (đóng tại chỗ): tủ bếp, tủ áo, tủ giày, vách tivi, ốp đầu giường, tủ lavabo
  const BUILT = new Set(['kitchen', 'wardrobe', 'shoe', 'tvStand', 'headboard', 'wcCab', 'wcGlass']);
  const APPL = new Set(['hob', 'hood', 'micro', 'fridge', 'tv', 'ac', 'heater', 'washer']);
  const sum = (pred) => +groups.flatMap((g) => g.items).filter((x) => pred(x.key)).reduce((s, x) => s + x.total, 0).toFixed(1);
  const split = { built: sum((k) => BUILT.has(k)), appliance: sum((k) => APPL.has(k)) };
  split.loose = +(total - split.built - split.appliance).toFixed(1);
  return { tier: TIERS[t], groups, total, split };
}

export const fmtM = (v) => (v >= 1000 ? `${(v / 1000).toLocaleString('vi-VN', { maximumFractionDigits: 2 })} tỷ` : `${v.toLocaleString('vi-VN', { maximumFractionDigits: 1 })} tr`);

/** Bảng báo giá dạng chữ để gửi Zalo / Messenger */
export function packageText(unitName, pk) {
  const L = [`GÓI HOÀN THIỆN NỘI THẤT – ${unitName}`, `Hạng: ${pk.tier.name} (${pk.tier.desc})`, ''];
  for (const g of pk.groups) {
    L.push(`${g.icon} ${g.name.toUpperCase()} – ${fmtM(g.total)}`);
    for (const x of g.items) L.push(`  • ${x.name}${x.note ? ` (${x.note})` : ''}: ${x.spec} – ${x.qty} ${x.unit} – ${fmtM(x.total)}`);
    if (g.note) L.push(`  (${g.note})`);
  }
  L.push('', `Nội thất dính tường: ${fmtM(pk.split.built)} · Thiết bị điện: ${fmtM(pk.split.appliance)} · Đồ rời: ${fmtM(pk.split.loose)}`);
  L.push(`TỔNG GÓI: ${fmtM(pk.total)} (khoảng ${Math.round(pk.total * 1e6).toLocaleString('vi-VN')} đ)`);
  L.push('Giá tham khảo đã gồm lắp đặt, chưa gồm VAT; báo giá chính xác sau khi khảo sát.');
  return L.join('\n');
}
