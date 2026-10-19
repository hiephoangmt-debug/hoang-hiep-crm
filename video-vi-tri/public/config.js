// KỊCH BẢN VIDEO — sửa file này để đổi dự án, chữ, tiện ích, góc camera.
// Tọa độ luôn viết [kinh độ, vĩ độ]. 30 khung hình = 1 giây.
// c = tâm camera, z = độ zoom, p = độ nghiêng, b = góc xoay. hold: true = dừng mềm tại mốc.
const PROJECT_CENTER = [108.2577158, 16.0211116];
const PARK = [[108.259309, 16.01923], [108.261644, 16.020269], [108.261995, 16.01953], [108.25966, 16.01849]]; // công viên biển đầu đường Minh Mạng (88 × 272 m, ~2,45 ha)
const AIRPORT = [108.2030, 16.0552];
const HOIAN = [108.3262, 15.8770];

window.CONFIG = {
  duration: 1800,
  fadeIn: 24,
  logo: { src: 'logo.png', in: 30, out: 1495 },
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
    { f: 0,    c: [108.232, 16.046], z: 12.1, p: 25, b: -8 },
    { f: 150,  c: [108.250, 16.031], z: 14.0, p: 45, b: -20 },
    { f: 270,  c: [108.2594, 16.0216], z: 15.6, p: 55, b: -26 },
    { f: 400,  c: [108.2596, 16.0213], z: 15.85, p: 58, b: -21 },
    { f: 500,  c: [108.2598, 16.0190], z: 14.65, p: 56, b: -12 },
    { f: 700,  c: [108.2602, 16.0178], z: 14.4, p: 58, b: -4 },
    { f: 800,  c: [108.2540, 15.9990], z: 12.7, p: 40, b: 0 },
    { f: 960,  c: [108.2590, 15.9625], z: 11.68, p: 20, b: 3 },
    { f: 1139, c: [108.2595, 15.9640], z: 11.72, p: 23, b: 6, hold: true },
    { f: 1141, c: [108.25785, 16.02125], z: 17.45, p: 66, b: -80, hold: true },
    { f: 1320, c: [108.2577, 16.0212], z: 17.8, p: 70, b: -30 },
    { f: 1500, c: [108.2578, 16.0212], z: 17.55, p: 68, b: 10 },
    { f: 1800, c: [108.2578, 16.0212], z: 17.3, p: 66, b: 30 },
  ],

  events: [
    // ===== Cảnh 1: Mở đầu =====
    { type: 'title', in: 18, out: 135, y: 330, html: `
      <div class="kicker">Bất động sản ven biển</div>
      <div class="h1">VỊ TRÍ<br><em>KIM CƯƠNG</em></div>
      <div class="rule"></div>
      <div class="sub">Sơn Thủy · Ngũ Hành Sơn · Đà Nẵng</div>` },


    // ===== Cảnh 2: Vị trí dự án =====
    { type: 'chip', n: '01', text: 'Mặt tiền biển', sub: 'Vị trí dự án', in: 200, out: 440 },
    { type: 'label', text: 'BIỂN SƠN THỦY', style: 'sea', at: [108.2641, 16.0240], width: 1500, bearing: -26, in: 175, out: 480 },
    { type: 'project', in: 200, lotsIn: 222, out: null, rise: [1170, 1290] },
    { type: 'pin', at: PROJECT_CENTER, in: 240, out: 440 },
    { type: 'label', text: 'SUN SAPHIA RESIDENCE', style: 'brand', at: [108.2584, 16.0197], width: 640, bearing: 64, in: 262, out: 450 },
    { type: 'label', text: 'ĐƯỜNG VÕ NGUYÊN GIÁP', style: 'road', at: [108.2567, 16.0248], width: 480, bearing: -26, in: 300, out: 470 },
    { type: 'label', text: 'ĐƯỜNG LÊ VĂN HIẾN', style: 'road', at: [108.2521, 16.0213], width: 520, bearing: -26, in: 312, out: 470 },
    { type: 'route', from: PROJECT_CENTER, to: [108.26078, 16.02334], bend: 0, in: 325, dur: 28, out: 402 },
    { type: 'dist', from: PROJECT_CENTER, to: [108.26078, 16.02334], at: [108.25905, 16.02455], small: 'ra biển', in: 342, out: 400 },
    { type: 'zone', polygon: PARK, color: '#2FCB8C', in: 300, out: null },
    { type: 'label', text: 'CÔNG VIÊN BIỂN', style: 'road', at: [108.260758, 16.019427], width: 230, bearing: 65.3, in: 320, out: 750 },
    { type: 'poi', name: 'Công viên biển Sơn Thủy', sub: '2,45 ha · quy hoạch mới', icon: 'tree', at: [108.261437, 16.019729], in: 404, out: 472, beam: 150, dx: 90 },

    // ===== Cảnh 3: Tiện ích xung quanh =====
    { type: 'chip', n: '02', text: 'Resort 5 sao bao quanh', sub: 'Tiện ích', in: 490, out: 740 },
    { type: 'poi', name: 'Crowne Plaza', icon: 'hotel', at: [108.25653, 16.02735], in: 520, out: 745, beam: 150 },
    { type: 'poi', name: 'Furama Resort', icon: 'hotel', at: [108.25111, 16.03993], in: 540, out: 745, beam: 200 },
    { type: 'poi', name: 'Hyatt Regency', icon: 'hotel', at: [108.26417, 16.01301], in: 560, out: 745, beam: 330, dx: 90 },
    { type: 'poi', name: 'Marriott Resort', icon: 'hotel', at: [108.2661, 16.00695], in: 580, out: 745, beam: 170, dx: 150 },
    { type: 'poi', name: 'Ngũ Hành Sơn', icon: 'mountain', at: [108.26382, 16.00292], in: 600, out: 745, beam: 280, dx: -190 },

    // ===== Cảnh 4: Kết nối vùng =====
    { type: 'chip', n: '03', text: 'Kết nối liên vùng', sub: 'Giao thông', in: 790, out: 1125 },
    { type: 'poi', name: 'Sân bay Đà Nẵng', icon: 'plane', at: AIRPORT, in: 820, out: 1130, beam: 230 },
    { type: 'route', from: AIRPORT, to: PROJECT_CENTER, bend: .28, in: 845, dur: 75, out: 1130, plane: true },
    { type: 'dist', from: AIRPORT, to: PROJECT_CENTER, at: [108.2205, 16.0285], in: 905, out: 1130 },
    { type: 'poi', name: 'Cầu Rồng', icon: 'city', at: [108.2272, 16.0612], in: 880, out: 1130, beam: 90, dx: 120 },
    { type: 'area', in: 935, out: 1130 },
    { type: 'route', from: PROJECT_CENTER, to: HOIAN, bend: -.18, in: 950, dur: 80, out: 1130, plane: true },
    { type: 'poi', name: 'Phố cổ Hội An', icon: 'star', at: HOIAN, in: 1010, out: 1130, beam: 170 },
    { type: 'dist', from: PROJECT_CENTER, to: HOIAN, at: [108.3065, 15.9560], in: 1025, out: 1130 },
    { type: 'fade', at: 1140, dur: 12 },

    // ===== Cảnh 5: Bay sát dự án =====
    { type: 'chip', n: '04', text: 'Căn hộ view biển', sub: '30 tầng · cao 114 m', in: 1160, out: 1495 },
    { type: 'pin', at: PROJECT_CENTER, in: 1290, out: 1495, lift: 400 },
    { type: 'stats', in: 1300, out: 1495, y: 1150, items: [
      { to: 30, unit: 'Tầng', label: 'Cao 114 m · 2 tầng hầm' },
      { to: 782, unit: 'Căn hộ', label: 'Studio · 1PN+1 · 2PN' },
      { to: 3720, unit: 'm² đất', label: '2 thửa · góc VNG – N.Đ.Thuận' },
      { text: '11/2028', unit: 'Bàn giao', label: 'Dự kiến' },
    ] },

    // ===== Cảnh 6: Kết =====
    { type: 'fade', at: 1500, dur: 12, hold: true },
    { type: 'photo', src: 'phoicanh.jpg', in: 1504, out: null, kicker: 'Phối cảnh dự án', title: 'SUN SAPHIA<br>RESIDENCE', sub: '30 tầng · 782 căn hộ · Bàn giao 11/2028' },
    { type: 'end', in: 1650, html: `
      <div class="logo"><img src="logo.png"></div>
      <div class="name">SUN SAPHIA<br>RESIDENCE</div>
      <div class="tag">Căn hộ view biển Sơn Thủy · Đà Nẵng</div>
      <div class="brand"><img src="tatiland.png"></div>
      <div class="web">sun-saphia-residence.com</div>
      <div class="note">Mô hình 3D mang tính minh họa</div>` },
  ],
};
