// KỊCH BẢN VIDEO 2 (dựng lại video TATILAND 53,7 giây, giữ giọng đọc gốc) — sửa file này để đổi dự án, chữ, tiện ích, góc camera.
// Tọa độ luôn viết [kinh độ, vĩ độ]. 30 khung hình = 1 giây.
// c = tâm camera, z = độ zoom, p = độ nghiêng, b = góc xoay. hold: true = dừng mềm tại mốc.
const PROJECT_CENTER = [108.2577158, 16.0211116];
const PARK = [[108.259309, 16.01923], [108.261644, 16.020269], [108.261995, 16.01953], [108.25966, 16.01849]]; // công viên biển đầu đường Minh Mạng (88 × 272 m, ~2,45 ha)
const AIRPORT = [108.2030, 16.0552];
const HOIAN = [108.3262, 15.8770];
const MYKHE = [108.2478, 16.0605];
const CAURONG = [108.2272, 16.0612];
// trục đường quanh lô đất (lấy từ dữ liệu đường phố)
const VNG = [[108.25679, 16.02422], [108.25724, 16.02325], [108.258, 16.02165], [108.25866, 16.02026], [108.25958, 16.01836]];
const TRUONGSA = [[108.25958, 16.01836], [108.26087, 16.01566], [108.26254, 16.01208]];
const NDT = [[108.25791, 16.02161], [108.25725, 16.02128], [108.25675, 16.02105], [108.25616, 16.02077], [108.25545, 16.02043]];
// tuyến metro Đà Nẵng – Hội An (quy hoạch, vẽ minh họa theo hướng tuyến)
const METRO = [[108.2205, 16.0700], [108.2300, 16.0440], [108.2440, 16.0230], [108.2520, 16.0050], [108.2660, 15.9800], [108.2860, 15.9450], [108.3050, 15.9100], [108.3200, 15.8860]];

window.CONFIG = {
  duration: 1610,
  fadeIn: 24,
  logo: { src: 'logo.png', in: 30, out: 1610 },
  palette: {
    sea: '#050F24', land: '#0C2042', green: '#0F2B4D', sand: '#1A3358', water: '#071A36', coast: '#7FB2FF',
    roadMinor: '#7F95BA', bldLow: '#16335D', bldHigh: '#2A5288', navy800: '#0A1C3A',
    orange: '#FF7A1A', orange300: '#FFB547', lotB: '#FF9A3C', lotC: '#F06414', park: '#E8EEF8',
  },
  project: {
    center: PROJECT_CENTER,
    // 2 thửa: thửa 6 (2.399 m², góc bo) + thửa 11 (1.320 m²) = 3.719 m², góc Võ Nguyên Giáp × Nguyễn Đức Thuận
    polygon: [[108.2573513, 16.0212283], [108.2573647, 16.0212651], [108.2577708, 16.021462], [108.2577851, 16.0214673], [108.2578002, 16.0214697], [108.2578153, 16.0214692], [108.25783, 16.0214658], [108.2578437, 16.0214596], [108.2578559, 16.0214508], [108.2578661, 16.0214398], [108.2578738, 16.021427], [108.258007, 16.0211467], [108.2580933, 16.0209651], [108.2575848, 16.0207368], [108.2574985, 16.0209185]],
    parcels: [[[108.2578738, 16.021427], [108.2578661, 16.0214398], [108.2578559, 16.0214508], [108.2578437, 16.0214596], [108.25783, 16.0214658], [108.2578153, 16.0214692], [108.2578002, 16.0214697], [108.2577851, 16.0214673], [108.2577708, 16.021462], [108.2573647, 16.0212651], [108.2573513, 16.0212283], [108.2574985, 16.0209185], [108.258007, 16.0211467]], [[108.258007, 16.0211467], [108.2574985, 16.0209185], [108.2575848, 16.0207368], [108.2580933, 16.0209651]]],
    // Khối nhà minh họa sinh bởi scripts/saphia.py: tầng 1 cao 7 m, tầng 2 cao 6 m, hồ bơi sàn tầng 3, tháp chữ L 30 tầng / 114 m
    buildingUrl: 'data/saphia.geojson',
  },

  camera: [
    { f: 0,    c: [108.2300, 16.0400], z: 11.6, p: 20, b: 0 },
    { f: 140,  c: [108.2560, 16.0225], z: 14.6, p: 50, b: 40 },
    { f: 260,  c: [108.2595, 16.0195], z: 15.25, p: 58, b: 52 },
    { f: 330,  c: [108.2600, 16.0175], z: 14.9, p: 58, b: 46 },
    { f: 440,  c: [108.2700, 15.9750], z: 11.8, p: 35, b: 15 },
    { f: 452,  c: [108.2700, 15.9760], z: 11.85, p: 36, b: 16, hold: true },
    { f: 456,  c: [108.25785, 16.02125], z: 17.1, p: 66, b: -70, hold: true },
    { f: 620,  c: [108.25780, 16.02120], z: 17.4, p: 68, b: -20 },
    { f: 700,  c: [108.2582, 16.0214], z: 16.2, p: 50, b: 42, hold: true },
    { f: 890,  c: [108.2583, 16.0213], z: 16.3, p: 52, b: 50, hold: true },
    { f: 960,  c: [108.2400, 16.0420], z: 13.15, p: 40, b: 8 },
    { f: 1040, c: [108.2385, 16.0410], z: 13.0, p: 40, b: 5, hold: true },
    { f: 1105, c: [108.2700, 15.9700], z: 11.8, p: 32, b: 10 },
    { f: 1130, c: [108.2700, 15.9720], z: 11.85, p: 33, b: 10 },
    { f: 1200, c: [108.2610, 16.0140], z: 14.0, p: 50, b: -18 },
    { f: 1280, c: [108.2605, 16.0150], z: 14.1, p: 52, b: -14 },
    { f: 1310, c: [108.2584, 16.0208], z: 16.4, p: 62, b: 55, hold: true },
    { f: 1470, c: [108.2580, 16.0211], z: 16.9, p: 64, b: 80 },
    { f: 1610, c: [108.25785, 16.02125], z: 17.2, p: 66, b: 100 },
  ],

  events: [
    // ===== 0–5 s: Mở đầu =====
    { type: 'project', in: 40, lotsIn: 50, out: null, rise: [60, 150] },
    { type: 'title', in: 8, out: 84, y: 300, html: `<div class="kicker">Lần đầu tiên</div><div class="h1">SUN <em>GROUP</em></div><div class="rule"></div><div class="sub">chính thức ra mắt dự án</div>` },
    { type: 'title', in: 92, out: 150, y: 300, html: `<div class="kicker">Tại TP. Đà Nẵng</div><div class="h1">CĂN HỘ<br><em>MẶT BIỂN</em></div><div class="rule"></div>` },
    { type: 'pin', at: PROJECT_CENTER, in: 120, out: 330, lift: 120 },

    // ===== 5–11 s: Biển Sơn Thủy + resort =====
    { type: 'label', text: 'BIỂN SƠN THỦY', style: 'sea', at: [108.2682, 16.0248], width: 1300, bearing: 155, in: 150, out: 420 },
    { type: 'poi', name: 'Hyatt Regency', icon: 'hotel', at: [108.26417, 16.01301], in: 262, out: 335, beam: 120, small: true },
    { type: 'poi', name: 'Danang Marriott', icon: 'hotel', at: [108.2661, 16.00695], in: 280, out: 335, beam: 90, small: true },

    // ===== 11–15 s: Metro Đà Nẵng – Hội An =====
    { type: 'route', coords: METRO, dash: true, color: '#7FD3FF', width: 6, glowW: 18, in: 345, dur: 80, out: 452 },
    { type: 'poi', name: 'Metro Đà Nẵng – Hội An', sub: 'Tuyến quy hoạch', icon: 'train', at: [108.2860, 15.9450], in: 385, out: 452, beam: 70, small: true, dx: 120 },
    { type: 'poi', name: 'Phố cổ Hội An', icon: 'star', at: HOIAN, in: 410, out: 452, beam: 120, small: true },
    { type: 'poi', name: 'Sun Saphia', icon: 'star', at: PROJECT_CENTER, in: 360, out: 452, beam: 90, small: true, showDist: false, sub: '' },
    { type: 'fade', at: 454, dur: 10 },

    // ===== 15–21 s: Câu hỏi đầu tư =====
    { type: 'title', in: 462, out: 545, y: 200, html: `<div class="panel"><div class="kicker">Những điều</div><div class="h2"><em>ĐÁNG QUAN TÂM</em></div></div>` },
    { type: 'title', in: 478, out: 545, y: 1380, html: `<div class="panel"><div class="sub" style="margin-top:0">Không chỉ là</div><div class="h2">một căn hộ <em>gần biển</em></div></div>` },
    { type: 'title', in: 552, out: 640, y: 200, html: `<div class="panel"><div class="h2">VỊ TRÍ <em>NÀY</em></div><div class="sub" style="margin-top:10px">có thể mang lại</div></div>` },
    { type: 'title', in: 570, out: 640, y: 1380, html: `<div class="panel"><div class="h2"><em>LỢI THẾ GÌ</em></div><div class="sub" style="margin-top:10px">cho bài toán đầu tư?</div></div>` },

    // ===== 21–30 s: Lô góc 3 mặt đường =====
    { type: 'chip', n: '01', text: 'Lô góc 3 mặt đường', sub: 'Vị trí', in: 660, out: 890 },
    { type: 'label', text: 'SUN SAPHIA RESIDENCE', style: 'brand', at: [108.2556, 16.0196], width: 520, bearing: 155, in: 680, out: 900 },
    { type: 'route', coords: VNG, solid: true, color: '#FFC23D', width: 9, glowW: 30, in: 720, dur: 40, out: 900 },
    { type: 'route', coords: TRUONGSA, solid: true, color: '#FFC23D', width: 9, glowW: 30, in: 745, dur: 35, out: 900 },
    { type: 'route', coords: NDT, solid: true, color: '#FFC23D', width: 8, glowW: 26, in: 775, dur: 35, out: 900 },
    { type: 'label', text: 'VÕ NGUYÊN GIÁP', style: 'road', at: [108.2575, 16.0236], width: 330, bearing: 155.3, in: 745, out: 900 },
    { type: 'label', text: 'TRƯỜNG SA', style: 'road', at: [108.2612, 16.0151], width: 230, bearing: 155.3, in: 770, out: 900 },
    { type: 'label', text: 'NGUYỄN ĐỨC THUẬN', style: 'road', at: [108.2566, 16.0205], width: 300, bearing: 63.4, in: 800, out: 900 },
    { type: 'zone', polygon: PARK, color: '#2FCB8C', in: 820, out: 900 },
    { type: 'poi', name: 'Công viên biển Sơn Thủy', sub: '2,45 ha · quy hoạch mới', icon: 'tree', at: [108.2612, 16.0195], in: 830, out: 895, beam: 110, small: true, dx: 40 },

    // ===== 30–37 s: Kết nối (thời gian theo giọng đọc) =====
    { type: 'chip', n: '02', text: 'Kết nối trung tâm', sub: 'Thời gian di chuyển', in: 905, out: 1125 },
    { type: 'route', from: PROJECT_CENTER, to: MYKHE, bend: .12, in: 915, dur: 40, out: 1062 },
    { type: 'dist', at: [108.2532, 16.0388], text: '5 phút', in: 945, out: 1062 },
    { type: 'poi', name: 'Biển Mỹ Khê', icon: 'beach', at: MYKHE, in: 950, out: 1062, beam: 90, small: true, showDist: false, sub: '' },
    { type: 'route', from: PROJECT_CENTER, to: CAURONG, bend: -.12, in: 960, dur: 40, out: 1062 },
    { type: 'dist', at: [108.2348, 16.0512], text: '7 phút', in: 990, out: 1062 },
    { type: 'poi', name: 'Cầu Rồng', icon: 'bridge', at: CAURONG, in: 995, out: 1062, beam: 140, small: true, showDist: false, sub: '' },
    { type: 'route', from: PROJECT_CENTER, to: AIRPORT, bend: .22, in: 1005, dur: 45, out: 1062, plane: true },
    { type: 'dist', at: [108.2290, 16.0370], text: '10 phút', in: 1040, out: 1062 },
    { type: 'poi', name: 'Sân bay Đà Nẵng', icon: 'plane', at: AIRPORT, in: 1045, out: 1062, beam: 80, small: true, showDist: false, sub: '' },
    { type: 'route', from: PROJECT_CENTER, to: HOIAN, bend: -.15, in: 1052, dur: 50, out: 1128 },
    { type: 'area', in: 1060, out: 1125 },
    { type: 'dist', at: [108.3055, 15.9580], text: '20 phút', in: 1090, out: 1125 },
    { type: 'poi', name: 'Phố cổ Hội An', icon: 'star', at: HOIAN, in: 1095, out: 1125, beam: 110, small: true, showDist: false, sub: '' },

    // ===== 37–42 s: Chuỗi resort ven biển =====
    { type: 'chip', n: '03', text: 'Chuỗi resort 5 sao', sub: 'Ven biển Non Nước', in: 1135, out: 1290 },
    { type: 'poi', name: 'Furama Resort', icon: 'hotel', at: [108.25111, 16.03993], in: 1160, out: 1285, beam: 90, small: true, showDist: false, sub: '', dx: -150 },
    { type: 'poi', name: 'Crowne Plaza', icon: 'hotel', at: [108.25653, 16.02735], in: 1170, out: 1285, beam: 80, small: true, showDist: false, sub: '', dx: 160 },
    { type: 'poi', name: 'Hyatt Regency', icon: 'hotel', at: [108.26417, 16.01301], in: 1180, out: 1285, beam: 90, small: true, showDist: false, sub: '', dx: -170 },
    { type: 'poi', name: 'Danang Marriott', icon: 'hotel', at: [108.2661, 16.00695], in: 1190, out: 1285, beam: 80, small: true, showDist: false, sub: '', dx: 170 },
    { type: 'poi', name: 'Ngũ Hành Sơn', icon: 'mountain', at: [108.26382, 16.00292], in: 1200, out: 1285, beam: 70, small: true, showDist: false, sub: '', dx: -170 },
    { type: 'poi', name: 'Sheraton Grand', icon: 'hotel', at: [108.2782, 15.98102], in: 1210, out: 1285, beam: 70, small: true, showDist: false, sub: '', dx: 150 },

    // ===== 42–49 s: Du lịch · Nghỉ dưỡng · Lưu trú =====
    { type: 'chip', n: '04', text: 'Khai thác đa dạng', sub: 'Tiềm năng cho thuê', in: 1300, out: 1470 },
    { type: 'poi', name: 'DU LỊCH', sub: 'Biển · Ngũ Hành Sơn · Hội An', icon: 'camera', at: PROJECT_CENTER, in: 1310, out: 1465, beam: 520, dx: -230 },
    { type: 'poi', name: 'NGHỈ DƯỠNG', sub: 'Giữa chuỗi resort 5 sao', icon: 'beach', at: PROJECT_CENTER, in: 1340, out: 1465, beam: 360, dx: 240 },
    { type: 'poi', name: 'LƯU TRÚ', sub: 'Nhu cầu thuê ngắn & dài hạn', icon: 'bed', at: PROJECT_CENTER, in: 1370, out: 1465, beam: 200, dx: -170 },

    // ===== 49–53,7 s: Tiềm năng · 3 yếu tố =====
    { type: 'title', in: 1478, out: null, y: 190, html: `<div class="panel"><div class="kicker">Đánh giá sâu hơn</div><div class="h2"><em>TIỀM NĂNG</em></div><div class="sub" style="margin-top:6px">của vị trí này</div></div>` },
    { type: 'title', in: 1500, out: null, y: 1300, html: `<div style="display:inline-flex;align-items:center;gap:22px"><div class="big3">3</div><div style="text-align:left"><div class="sub" style="margin:0;font-size:38px;font-weight:800">yếu tố quan trọng</div><div class="sub" style="margin:4px 0 0">cần nhìn vào</div></div></div>` },
  ],
};
