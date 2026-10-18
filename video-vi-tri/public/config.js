// KỊCH BẢN VIDEO — sửa file này để đổi dự án, chữ, tiện ích, góc camera.
// Tọa độ luôn viết [kinh độ, vĩ độ]. 30 khung hình = 1 giây.
// c = tâm camera, z = độ zoom, p = độ nghiêng, b = góc xoay. hold: true = dừng mềm tại mốc.
const PROJECT_CENTER = [108.25767, 16.02115];
const PARK = [[108.259488, 16.018852], [108.261798, 16.01988], [108.262141, 16.019157], [108.259832, 16.018128]]; // công viên biển đầu đường Minh Mạng (88 × 272 m, ~2,45 ha)
const AIRPORT = [108.2030, 16.0552];
const HOIAN = [108.3262, 15.8770];

window.CONFIG = {
  duration: 1800,
  fadeIn: 24,
  palette: {
    sea: '#050F24', land: '#0C2042', green: '#0F2B4D', sand: '#1A3358', water: '#071A36', coast: '#7FB2FF',
    roadMinor: '#7F95BA', bldLow: '#16335D', bldHigh: '#2A5288', navy800: '#0A1C3A',
    orange: '#FF7A1A', orange300: '#FFB547', lotB: '#FF9A3C', lotC: '#F06414', park: '#E8EEF8',
  },
  project: {
    center: PROJECT_CENTER,
    // Lô đất chữ L: lưng Võ Nguyên Giáp (Trường Sa), chân Nguyễn Đức Thuận, bụng đường nội bộ (~3.700 m²)
    polygon: [[108.257841, 16.021496], [108.2572142, 16.0211922], [108.2573275, 16.0209539], [108.2575364, 16.0210551], [108.2576536, 16.0208086], [108.2580714, 16.0210111]],
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

    // Dải liên hệ cố định ở cuối màn hình
    { type: 'title', in: 40, out: 1495, y: 1748, html: `<div class="badge"><span class="ph"><svg viewBox="0 0 24 24"><path d="M6.6 10.8a15.1 15.1 0 0 0 6.6 6.6l2.2-2.2a1 1 0 0 1 1-.25 11.4 11.4 0 0 0 3.6.57 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.45.57 3.57a1 1 0 0 1-.25 1z" fill="#fff"/></svg></span><b>0904 567 009</b><i>Hoàng Hiệp</i></div>` },

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
    { type: 'label', text: 'CÔNG VIÊN BIỂN', style: 'road', at: [108.26075, 16.01895], width: 230, bearing: 65.3, in: 320, out: 750 },
    { type: 'poi', name: 'Công viên biển Sơn Thủy', sub: '2,45 ha · quy hoạch mới', icon: 'tree', at: [108.2612, 16.0195], in: 404, out: 472, beam: 150, dx: 90 },

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
      { to: 3720, unit: 'm² đất', label: 'Mặt tiền Võ Nguyên Giáp' },
      { text: '11/2028', unit: 'Bàn giao', label: 'Dự kiến' },
    ] },

    // ===== Cảnh 6: Kết =====
    { type: 'fade', at: 1500, dur: 12, hold: true },
    { type: 'photo', src: 'phoicanh.jpg', in: 1504, out: null, kicker: 'Phối cảnh dự án', title: 'SUN SAPHIA<br>RESIDENCE', sub: '30 tầng · 782 căn hộ · Bàn giao 11/2028' },
    { type: 'end', in: 1650, html: `
      <div class="logo"><svg viewBox="0 0 24 24"><path d="M3 21V10l9-7 9 7v11h-6v-6H9v6H3z" fill="#FF7A1A"/></svg></div>
      <div class="name">SUN SAPHIA<br>RESIDENCE</div>
      <div class="tag">Căn hộ view biển Sơn Thủy · Đà Nẵng</div>
      <div class="hot"><small>HOTLINE · HOÀNG HIỆP</small>0904 567 009</div>
      <div class="web">sun-saphia-residence.com</div>
      <div class="note">Mô hình 3D mang tính minh họa</div>` },
  ],
};
