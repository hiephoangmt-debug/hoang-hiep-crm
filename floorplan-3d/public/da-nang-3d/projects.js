// Danh sách dự án hiển thị trên bản đồ Đà Nẵng 3D (nút 🏢 Dự án).
// Toạ độ: lấy từ bản đồ nhúng trên landing page, hoặc ngã tư theo địa chỉ trên OpenStreetMap.
// model (khối 3D minh hoạ theo quy mô công bố): plot [dài, rộng] khu đất (m, dài dọc theo đường gần nhất),
//   podiums [x, z, dài, rộng, cao], towers [x, z, dài, rộng, số tầng, cao tầng, chân đế, số đoạn thu nhỏ, chóp], pools, domes [x, z, bán kính, cao].
// Thêm dự án mới: thêm 1 dòng { name, lat, lon, area, address, developer, scale, price, headline, url }.
window.PROJECTS_DATA = [
  { name: 'Lô đất 4 mặt tiền Hoàng Sa', lat: 16.0903, lon: 108.24985, area: 'Sơn Trà', h: 110, pin: false,
    address: 'Góc Hoàng Sa × Hồ Học Lãm, Thọ Quang, Sơn Trà', scale: '583,6 m², ngang 27,6 m · tặng GPXD KS 5★ 22 tầng, 94 phòng',
    price: '190 tỷ (thương lượng)', headline: 'View trực diện biển, 4 mặt tiền',
    url: 'https://hiephoangmt-debug.github.io/hoang-hiep-crm/lo-dat-hoang-sa/' },
  { name: 'Sun Saphia Residence', lat: 16.0213, lon: 108.257659, area: 'Ngũ Hành Sơn',
    address: 'Giao lộ Võ Nguyên Giáp – Nguyễn Đức Thuận – Trường Sa, P. Ngũ Hành Sơn', developer: 'Sun Group',
    scale: '1 tháp 30 tầng ~114 m, 782 căn (Studio, 1PN+1, 2PN)', price: 'Studio từ ~1,8 tỷ (dự kiến)',
    headline: 'Căn hộ mặt biển đầu tiên của Sun Group tại Đà Nẵng, ~400 m ra bãi tắm Sơn Thủy',
    url: 'https://www.sun-saphia-residence.com',
    // Ảnh 360° flycam (DJI Air 3S) chụp ngay trên khu đất: toạ độ & độ cao lấy từ EXIF/XMP của ảnh gốc,
    // heading = hướng (độ, so với Bắc) của tâm ảnh – căn theo vị trí mặt trời lúc chụp.
    // ranh khu đất (bãi cát đang thi công) đo trên ảnh flycam 150 m chiếu thẳng đứng, ~6500 m²
    site: [[16.0212086, 108.2573346], [16.0213261, 108.2574561], [16.0213804, 108.2576431], [16.0214165, 108.2578301], [16.0213804, 108.2579422], [16.0213442, 108.2579983], [16.0211814, 108.2580918], [16.0210006, 108.2581385], [16.0208017, 108.2581666], [16.0206842, 108.2581666], [16.0204400, 108.2576992], [16.0204581, 108.2576618], [16.0206209, 108.2575870], [16.0208559, 108.2574748], [16.0210549, 108.2573814]],
    // Mặt bằng tầng + layout căn (ảnh chủ đầu tư, đã thu nhỏ): ../mat-bang/sun-saphia/<file>.webp, ảnh nhỏ <file>-nho.webp
    plans: { dir: '../mat-bang/sun-saphia/', groups: [
      ['Mặt bằng tầng', [['t-2', 'Tầng 2 · hồ bơi, tiện ích'], ['t-3', 'Tầng 3'], ['t-3a-28', 'Tầng 3A – 28 (điển hình)'], ['t-25d', 'Tầng 3A – 28 · nội thất'], ['t-29', 'Tầng 29'], ['t-30', 'Tầng 30']]],
      ['Layout căn', [['c-stu-a', 'Studio A · 30 m²'], ['c-stu-b', 'Studio B · 40,03 m²'], ['c-1br-plus', '1PN+ · 51,11 m²'], ['c-2br-c', '2PN C · 61,14 m²'], ['c-2br-a', '2PN A · 67,69 m²'], ['c-2br-b', '2PN B · 70,21 m²']]],
      ['Phối cảnh', [['pc-toa-thap', 'Phối cảnh toà Sun Saphia'], ['pc-bai-tam', 'Phối cảnh quảng trường – bãi tắm (tham khảo)']]],
      ['Layout căn 3D', [['d-stu-01-9000', 'Studio · 30 m² (dài 9,0 m)'], ['d-stu-01-9200', 'Studio · 30 m² (dài 9,2 m)'], ['d-stu-02', 'Studio · 40,03 m²'], ['d-1br-9000', '1PN+ · 48,98 m²'], ['d-1br-9200', '1PN+ · 51,11 m²'], ['d-2br-01', '2PN · 61,14 m²'], ['d-2br-03', '2PN · 67,69 m²'], ['d-2br-02', '2PN · 70,21 m²']]],
    ] },
    // Mặt bằng các tầng đặt lên khu đất trong ảnh 360° (nền trắng đã làm trong suốt), 4 góc khối đế khớp 4 góc hàng rào lô
    // đo trên ảnh flycam nhìn thẳng xuống; "Hướng biển" của bản vẽ quay về hướng 67° (ra đường ven biển).
    // corners: góc trên-trái, trên-phải, dưới-phải, dưới-trái của ảnh; mọi tầng dùng chung khung bản vẽ.
    overlay: { dir: '../mat-bang/sun-saphia/', corners: [[16.0214985, 108.2579234], [16.0206946, 108.2582622], [16.020425, 108.2576817], [16.0212075, 108.2573317]],
      // mỗi ảnh 360° có sai số GPS vài mét -> góc riêng cho từng ảnh, đo theo 4 cạnh hàng rào lô trên chính ảnh đó
      cornersBy: { 'sun-saphia-150m': [[16.0214985, 108.2579234], [16.0206946, 108.2582622], [16.020425, 108.2576817], [16.0212075, 108.2573317]],
        'sun-saphia-120m': [[16.0215385, 108.2579173], [16.0207277, 108.2582674], [16.0204503, 108.2576894], [16.0212217, 108.2573305]] },
      floors: [['t-2', 'Tầng 2 · hồ bơi'], ['t-3', 'Tầng 3'], ['t-3a-28', 'Tầng 3A – 28'], ['t-25d', 'Tầng 3A – 28 · nội thất'], ['t-29', 'Tầng 29'], ['t-30', 'Tầng 30']] },
    // tên đường viết nằm trên mặt đường trong ảnh 360°: a → b là hướng con đường
    roads: [
      { n: 'Đ. Võ Nguyên Giáp', a: [16.0222303, 108.257774], b: [16.0216697, 108.2578488] },
      { n: 'Đ. Trường Sa', a: [16.0209192, 108.2583535], b: [16.0204039, 108.2585966] },
      { n: 'Đ. Nguyễn Đức Thuận', a: [16.0214165, 108.2574468], b: [16.0211272, 108.2567457] },
    ],
    // Vùng quy hoạch phía trước (giữa đường Trường Sa và bãi biển): phủ mặt công viên đã làm sạch cỏ (minh hoạ, vẽ bằng code)
    // + ghi chú; chạm ghi chú mở ảnh phối cảnh. corners: góc phía biển-bắc, biển-nam, đường-nam, đường-bắc (đo trên ảnh flycam).
    zones: [{ name: '🌴 Công viên & bãi tắm Sơn Thủy', note: 'Quy hoạch mới · làm sạch cỏ như phối cảnh', plaza: 0.502,
      img: '../mat-bang/sun-saphia/cong-vien-phia-truoc.webp',   // mặt bằng công viên cắt từ ảnh bán hàng (xoay: phía biển ở trên)
      corners: [[16.0242473, 108.2598368], [16.0201026, 108.2616558], [16.0191028, 108.2592206], [16.0232475, 108.2574016]], gallery: 'Phối cảnh' }],
    pano360: [
      { id: 'sun-saphia-150m', src: '../pano/sun-saphia-150m.jpg', hd: '../pano/sun-saphia-150m-8k.jpg', lat: 16.020964444, lon: 108.257773967, alt: 150.5, heading: 343.7, time: '21/10/2026 08:06' },
      { id: 'sun-saphia-120m', src: '../pano/sun-saphia-120m.jpg', hd: '../pano/sun-saphia-120m-8k.jpg', lat: 16.020978376, lon: 108.257753928, alt: 119.7, heading: 333.4, time: '21/10/2026 08:07' },
    ],
    model: { plot: [62, 60], podiums: [[0, 4, 56, 44, 12]], towers: [[0, 6, 40, 22, 26, 3.4, 12.8, 1]], pools: [[-16, -24, 18, 6]], trees: 16 } },
  { name: 'Da Nang Downtown – tháp 408 m', lat: 16.03866, lon: 108.23323, area: 'Hải Châu', h: 140,
    address: 'Khu Công viên Châu Á cũ (đường 2/9 – Phan Đăng Lưu – bờ sông Hàn), P. Hòa Cường; tháp 408 m ở góc Phan Đăng Lưu – bờ sông', developer: 'Sun Group (Sun Property)',
    scale: '76,92 ha · tháp 69 tầng ~408 m · nhà hát 4.000 chỗ',
    price: 'Tham khảo ~60–100 triệu/m² (chưa có bảng giá chính thức)', headline: 'Siêu đô thị 80.000 tỷ và tòa tháp 408 m bên sông Hàn',
    url: 'https://www.sun-danangdowntown.com',
    // tháp 408 m đặt sát góc Phan Đăng Lưu – Đỗ Pháp Thuận (bờ sông), 2 tháp kèm theo nằm phía Nam Phan Đăng Lưu
    model: { plot: [60, 50], rot: -0.217, search: 0, t408: [0, 0], trees: 0,
      domes: [[-180, -799, 44, 26]],   // nhà hát 4.000 chỗ
      // các tháp khác theo QH 1/500 & phối cảnh (cùng vị trí với Sông Hàn 3D)
      towers: [[-217, 2, 34, 30, 45, 3.4, 0, 1], [-346, -5, 34, 30, 42, 3.4, 0, 1], [-176, -752, 28, 34, 38, 3.4, 0, 1], [-152, -635, 28, 34, 45, 3.4, 0, 1], [-127, -519, 28, 34, 33, 3.4, 0, 1], [-102, -403, 28, 34, 45, 3.4, 0, 1], [-78, -286, 28, 34, 36, 3.4, 0, 1], [-53, -170, 28, 34, 42, 3.4, 0, 1], [-226, -707, 28, 32, 40, 3.4, 0, 1], [-202, -591, 28, 32, 44, 3.4, 0, 1], [-177, -475, 28, 32, 38, 3.4, 0, 1], [-152, -358, 28, 32, 42, 3.4, 0, 1], [-316, -140, 32, 28, 35, 3.4, 0, 1], [-187, -137, 32, 28, 40, 3.4, 0, 1], [-281, -701, 28, 32, 38, 3.4, 0, 1], [-306, -780, 26, 30, 34, 3.4, 0, 1], [-705, -791, 34, 26, 36, 3.4, 0, 1], [-688, -886, 30, 24, 15, 3.4, 0, 1], [-633, -567, 30, 30, 36, 3.4, 0, 1]] } },
  { name: 'Sun Galaxy Complex', lat: 16.04315, lon: 108.2376, area: 'Sơn Trà',
    address: 'Bờ Đông sông Hàn (đường Trần Hưng Đạo), đối diện Da Nang Downtown', developer: 'Sun Group',
    scale: 'Tháp 47 tầng ~183 m, 4 hầm, >210.000 m² sàn · Moon Gate · khán đài DIFF', price: 'Tham khảo 60–148 triệu/m² (chưa chính thức)',
    headline: 'Tháp Moon Gate 47 tầng (Accor) bên sông Hàn, đối diện tháp 408 m', url: 'https://www.sun-danangdowntown.com/sun-galaxy-complex',
    model: { plot: [60, 40], rot: 1.36, search: 0, galaxy: true, towers: [], trees: 0 } },
  // Cụm Sun Neo City – Hòa Xuân: mỗi dự án 2 tháp trên 2 lô đối diện nhau qua đường (đo trên ảnh vệ tinh z18, 11/2026)
  { name: 'Cora Tower', lat: 16.01794, lon: 108.22961, area: 'Hòa Xuân',
    address: 'Vòng xoay 29/3 – Nguyễn Phước Lan, P. Hòa Xuân (2 lô hai bên đường 29/3, phía Tây Nam vòng xoay)', developer: 'Sun Group',
    scale: '2 tòa A1–A2, 25 tầng + tum, 2 hầm, ~1.342 căn · 62 shop khối đế, 48 penthouse', price: '1PN+ tầng 15 từ ~3,1 tỷ',
    headline: 'Biểu tượng sống mới bên sông, ngay vòng xoay 29/3 – Sun Neo City', url: 'https://www.cora-tower.com',
    model: { plot: [160, 80], rot: 0.459, search: 0, podiums: [[-47, 0, 56, 66, 12], [47, 0, 56, 66, 12]],
      towers: [[-47, 0, 24, 50, 25, 3.4, 12, 1], [47, 0, 24, 50, 25, 3.4, 12, 1]], pools: [[-47, 26, 30, 7]], trees: 20 } },
  { name: 'Spana Tower', lat: 16.02318, lon: 108.22441, area: 'Hòa Xuân',
    address: 'Số 02 Nguyễn Phước Lan, chân cầu Hòa Xuân, P. Hòa Xuân (2 lô hai bên đường)', developer: 'Sun Group',
    scale: '2 tòa S1–S2, 22 tầng, ~1.281 căn · 50 shop khối đế, 52 penthouse', price: 'Liên hệ bảng giá mới nhất',
    headline: 'Căn hộ view sông Hàn – Cẩm Lệ ngay chân cầu Hòa Xuân', url: 'https://www.sun-spanatower.com',
    model: { plot: [70, 140], rot: 0.685, search: 0, podiums: [[8, -40, 62, 52, 12], [-8, 40, 62, 52, 12]],
      towers: [[8, -42, 52, 22, 22, 3.3, 12, 1], [-8, 42, 52, 22, 22, 3.3, 12, 1]], trees: 16 } },
  { name: 'S-Light Tower', lat: 16.02453, lon: 108.23446, area: 'Hòa Xuân',
    address: 'Giao lộ Nguyễn Đình Thi – đường 29/3, KĐT Sun Neo City, P. Hòa Xuân (mũi đất 3 sông)', developer: 'Sun Group (Sun Property)',
    scale: '2 tòa SL1–SL2, 22 tầng, 3 hầm, ~792 căn · 38 shop khối đế, 32 penthouse', price: 'Từ ~2,4 tỷ/căn (chưa VAT)',
    headline: 'Cửa ngõ Sun Neo City – view sông Hàn, Cẩm Lệ, Đô Tỏa', url: 'https://www.s-light-tower.com',
    model: { plot: [150, 70], rot: 0.542, search: 0, podiums: [[-39, -3, 60, 60, 12], [39, 3, 60, 60, 12]],
      towers: [[-39, -3, 26, 52, 22, 3.3, 12, 1], [39, 3, 26, 52, 22, 3.3, 12, 1]], pools: [[-39, 24, 26, 6]], trees: 16 } },
  { name: 'FPT City – FPT Plaza 3', lat: 15.98206, lon: 108.25971, area: 'Ngũ Hành Sơn',
    address: 'Đường Hoàng Minh Thắng, KĐT FPT City (phía Nam Đà Nẵng)', developer: 'Công ty CP Đô thị FPT Đà Nẵng',
    scale: 'KĐT >181 ha · FPT Plaza 3: 2 tòa 25 tầng, 837 căn + shophouse', headline: 'Đã bàn giao, có sổ – đất nền & căn hộ FPT Plaza 1–5',
    url: 'https://www.fpt-city.com' },
  { name: 'Times Square Đà Nẵng', lat: 16.0696, lon: 108.2447, area: 'Sơn Trà',
    address: 'Đường Võ Nguyên Giáp, Sơn Trà (vị trí theo bản đồ)', scale: '2 tháp CT1–CT2 cao ~190 m', headline: 'Căn hộ mặt biển Mỹ Khê',
    url: 'https://www.timesquare-danang.com' },
  { name: 'Vinhomes Hải Vân Bay', lat: 16.1619, lon: 108.1428, area: 'Liên Chiểu', h: 120, pin: false,
    address: 'Làng Vân, P. Hòa Hiệp Bắc, Liên Chiểu', developer: 'Vinhomes – Vingroup',
    scale: '512 ha · 5.928 thấp tầng + 241 cao tầng · 4 phân khu', price: 'Liền kề từ ~6 tỷ; đơn lập từ ~16–17 tỷ',
    headline: 'Đô thị nghỉ dưỡng biển 512 ha – Núi, Rừng, Biển, Vịnh', url: 'https://www.giohangvinhaivanbay.com' },
  { name: 'Casamia Balanca Hội An', lat: 15.88064, lon: 108.37549, area: 'Hội An', pin: false,
    address: 'Đường Võ Chí Công, P. Hội An Đông', developer: 'Tập đoàn Đạt Phương',
    scale: '31,1 ha · 363 nhà vườn & biệt thự · mật độ 23,1%', price: 'Park Home từ ~10,4 tỷ (sau chiết khấu)',
    headline: 'Biệt thự compound bên sông Cổ Cò – phố cổ, biển và sông ngay cạnh nhà',
    url: 'https://www.casamia-balanca.com.vn', page3d: 'https://hiephoangmt-debug.github.io/hoang-hiep-crm/biet-thu-bt/' },
];
