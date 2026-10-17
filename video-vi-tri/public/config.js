// KỊCH BẢN VIDEO — sửa file này để đổi dự án, chữ, tiện ích, góc camera.
// Tọa độ luôn viết [kinh độ, vĩ độ]. 30 khung hình = 1 giây.
// c = tâm camera, z = độ zoom, p = độ nghiêng, b = góc xoay. hold: true = dừng mềm tại mốc.
const PROJECT_CENTER = [108.25774, 16.02109];
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
    // Lô đất Sun Saphia Residence (4 góc, theo vị trí khoanh trên bản đồ)
    polygon: [[108.25782, 16.02147], [108.25813, 16.02085], [108.25766, 16.02075], [108.25733, 16.02126]],
    // Tòa tháp minh họa: đế 13 m + 34 tầng, kính xanh viền cam đồng
    tower: { podiumH: 13, podiumInset: 4, towerInset: 12, floors: 34, floorH: 3.3, glass: '#2E5F96' },
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
    { f: 1141, c: [108.2579, 16.0213], z: 17.45, p: 66, b: -80, hold: true },
    { f: 1320, c: [108.2578, 16.0212], z: 17.85, p: 70, b: -30 },
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
    { type: 'label', text: 'ĐƯỜNG VÕ NGUYÊN GIÁP', style: 'road', at: [108.2604, 16.0172], width: 600, bearing: -26, in: 300, out: 470 },
    { type: 'label', text: 'ĐƯỜNG LÊ VĂN HIẾN', style: 'road', at: [108.2521, 16.0213], width: 520, bearing: -26, in: 312, out: 470 },
    { type: 'route', from: [108.2581, 16.0212], to: [108.2612, 16.0226], bend: 0, in: 330, dur: 30, out: 470 },
    { type: 'dist', from: PROJECT_CENTER, to: [108.2612, 16.0226], at: [108.2597, 16.0219], small: 'ra biển', in: 350, out: 470 },

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
    { type: 'chip', n: '04', text: 'Căn hộ view biển', sub: 'Mô hình minh họa', in: 1160, out: 1495 },
    { type: 'pin', at: PROJECT_CENTER, in: 1300, out: 1495, lift: 420 },
    { type: 'poi', name: 'Bãi tắm Sơn Thủy', icon: 'beach', at: [108.2612, 16.0226], in: 1330, out: 1495, beam: 130 },
    { type: 'poi', name: 'Crowne Plaza', icon: 'hotel', at: [108.25653, 16.02735], in: 1350, out: 1495, beam: 120 },

    // ===== Cảnh 6: Kết =====
    { type: 'fade', at: 1500, dur: 12, hold: true },
    { type: 'photo', src: 'phoicanh.jpg', in: 1504, out: null, kicker: 'Phối cảnh dự án', title: 'SUN SAPHIA<br>RESIDENCE' },
    { type: 'end', in: 1650, html: `
      <div class="logo"><svg viewBox="0 0 24 24"><path d="M3 21V10l9-7 9 7v11h-6v-6H9v6H3z" fill="#FF7A1A"/></svg></div>
      <div class="name">SUN SAPHIA<br>RESIDENCE</div>
      <div class="tag">Căn hộ view biển Sơn Thủy · Đà Nẵng</div>
      <div class="hot"><small>HOTLINE · HOÀNG HIỆP</small>0904 567 009</div>
      <div class="web">sun-saphia-residence.com</div>
      <div class="note">Mô hình 3D mang tính minh họa</div>` },
  ],
};
