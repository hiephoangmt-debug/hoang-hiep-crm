// Địa danh nổi tiếng thêm cho ảnh 360° flycam (ngoài các cầu, núi, biển, dự án đã có trên bản đồ).
// Toạ độ gần đúng – sửa lat/lon ở đây nếu nhãn lệch so với ảnh.
// k: dd = địa danh, rs = resort/khách sạn nổi tiếng, ph = phường (nhãn vùng)
window.POI_DATA = [
  { n: 'Khán đài pháo hoa DIFF', lat: 16.0442, lon: 108.2372, k: 'dd' },
  { n: 'Cầu Tình Yêu – Cá chép hóa rồng', lat: 16.0617, lon: 108.2300, k: 'dd' },
  { n: 'Chợ Hàn', lat: 16.0681, lon: 108.2240, k: 'dd' },
  { n: 'Nhà thờ Con Gà', lat: 16.0667, lon: 108.2233, k: 'dd' },
  { n: 'Bảo tàng Điêu khắc Chăm', lat: 16.0604, lon: 108.2234, k: 'dd' },
  { n: 'Công viên Biển Đông', lat: 16.0700, lon: 108.2466, k: 'dd' },
  { n: 'Bãi tắm Sơn Thủy', lat: 16.0228, lon: 108.2622, k: 'dd' },
  { n: 'Làng đá Non Nước', lat: 15.9985, lon: 108.2618, k: 'dd' },
  // cụm resort phía bắc khu đất – vị trí đo trực tiếp trên ảnh flycam 150 m (hướng + góc nhìn xuống), h = độ cao đặt nhãn (m)
  { n: 'Ariyana Beach Resort & Suites', lat: 16.024129, lon: 108.257662, k: 'rs', h: 75 },
  { n: 'TT Hội nghị Ariyana (APEC 2017)', lat: 16.025160, lon: 108.258457, k: 'rs', h: 20 },
  { n: 'Furama Resort Đà Nẵng', lat: 16.027511, lon: 108.255960, k: 'rs', h: 15 },
  { n: 'Pullman Danang Beach Resort', lat: 16.030566, lon: 108.255110, k: 'rs', h: 15 },
  { n: 'Hyatt Regency Danang', lat: 16.0118, lon: 108.2632, k: 'rs' },
  { n: 'Sheraton Grand Danang', lat: 16.0018, lon: 108.2683, k: 'rs' },
  { n: 'Naman Retreat', lat: 15.9718, lon: 108.2838, k: 'rs' },
  { n: 'InterContinental Sun Peninsula', lat: 16.1197, lon: 108.3055, k: 'rs' },
  { n: 'Premier Village Danang', lat: 16.1000, lon: 108.2995, k: 'rs' },
  // phường (sau sắp xếp 2025) – nhãn đặt khoảng giữa phường
  { n: 'P. Ngũ Hành Sơn', lat: 16.0150, lon: 108.2530, k: 'ph' },
  { n: 'P. Hòa Xuân', lat: 16.0090, lon: 108.2250, k: 'ph' },
  { n: 'P. Hòa Cường', lat: 16.0420, lon: 108.2180, k: 'ph' },
  { n: 'P. Hải Châu', lat: 16.0690, lon: 108.2190, k: 'ph' },
  { n: 'P. An Hải', lat: 16.0620, lon: 108.2420, k: 'ph' },
  { n: 'P. Sơn Trà', lat: 16.0880, lon: 108.2420, k: 'ph' },
];
