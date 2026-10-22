// KỊCH BẢN VIDEO GIẢI MÃ: "782 căn hộ trên 3.720 m² đất – Sun Group đang tính toán gì ở biển Sơn Thủy?"
// 30 khung hình = 1 giây. Vùng y > 1490 dành cho chữ ký + dải hotline Hoàng Hiệp (lớp phủ riêng).
// Số liệu: bảng thông tin tổng quan dự án + 2 thửa đất (thửa 6, thửa 11); khoảng cách đo đường chim bay trên bản đồ.
window.EX = {
  duration: 2550,
  icons: {
    hotel: '<path d="M3 21V5h2v9h7V8h6a3 3 0 0 1 3 3v10h-2v-3H5v3H3zm5-8a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5z" fill="#fff"/>',
    mountain: '<path d="M2 20l7-12 4 6 3-4 6 10H2z" fill="#fff"/>',
    star: '<path d="M12 2l3 7h7l-5.5 4.5L18.5 21 12 16.5 5.5 21l2-7.5L2 9h7z" fill="#fff"/>',
    user: '<path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10zm-8 10a8 8 0 0 1 16 0H4z" fill="#fff"/><path d="M17 3l4 0 0 4" stroke="#FFB547" stroke-width="1.6" fill="none"/>',
    bed: '<path d="M3 18V6h2v7h6V8h7a3 3 0 0 1 3 3v7h-2v-2H5v2H3zm4-6a2 2 0 1 1 0-4 2 2 0 0 1 0 4z" fill="#fff"/>',
    money: '<path d="M2 6h20v12H2zm10 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM5 8v2a2 2 0 0 0 2-2H5zm14 0h-2a2 2 0 0 0 2 2V8zM5 16h2a2 2 0 0 0-2-2v2zm14 0v-2a2 2 0 0 0-2 2h2z" fill="#fff"/>',
  },
  items: [
    // ===== 0–9 s: HOOK =====
    { type: 'count', to: 3720, unit: 'm² đất', y: 150, size: 150, in: 10, out: 270, anim: 'pop', dur: 40 },
    { type: 'count', to: 30, unit: 'TẦNG', y: 345, size: 130, in: 55, out: 270, anim: 'pop', dur: 24 },
    { type: 'count', to: 782, unit: 'CĂN HỘ', y: 520, size: 130, in: 100, out: 270, anim: 'pop', dur: 32 },
    { type: 'img', src: 'ex/p3.jpg', x: 90, y: 740, w: 900, h: 640, in: 20, out: 270, anim: 'zoom', kb: [1.04, 1.16], pos: '50% 30%' },
    { type: 'txt', html: '<span class="tag" style="font-size:40px">Cách biển Sơn Thủy chỉ khoảng 400 m</span>', y: 1330, in: 150, out: 270, anim: 'pop' },
    { type: 'txt', html: '<div class="kick">Câu hỏi đặt ra</div><div class="h2" style="margin-top:18px">Sun Group đang<br><em>tính toán gì</em><br>ở biển Sơn Thủy?</div>', y: 300, in: 282, out: 400, anim: 'pop' },
    { type: 'img', src: 'ex/p2.jpg', x: 90, y: 860, w: 900, h: 540, in: 296, out: 400, anim: 'up', kb: [1.0, 1.1] },

    // ===== 13–25 s: Lô đất =====
    { type: 'txt', html: '<div class="kick">01 · Lô đất</div><div class="h2" style="margin-top:10px">Lô góc <em>3 mặt đường</em></div>', y: 140, in: 404, out: 760 },
    { type: 'img', src: 'ex/thua6.jpg', x: 55, y: 330, w: 470, h: 620, rot: -3, anim: 'left', in: 420, out: 640, cap: 'Thửa 6<small>2.399 m²</small>' },
    { type: 'img', src: 'ex/thua11.jpg', x: 555, y: 360, w: 470, h: 620, rot: 3, anim: 'right', in: 452, out: 640, cap: 'Thửa 11<small>1.320 m²</small>' },
    { type: 'count', to: 3720, unit: 'm²', y: 1010, size: 140, in: 500, out: 640, anim: 'pop', sub: 'Ghép 2 thửa thành <em>1 lô góc</em>' },
    { type: 'img', src: 'ex/map_870.jpg', x: 60, y: 320, w: 960, h: 1150, in: 640, out: 760, anim: 'zoom', kb: [1.0, 1.06], cap: 'Góc Võ Nguyên Giáp – Nguyễn Đức Thuận<small>Lưng hướng biển · 3 mặt đường</small>' },

    // ===== 25–32 s: Công viên biển =====
    { type: 'txt', html: '<div class="kick">Chưa đầy 400 m</div><div class="h2" style="margin-top:10px">Công viên biển <em>2,45 ha</em></div>', y: 140, in: 770, out: 960 },
    { type: 'img', src: 'ex/map_870.jpg', x: 60, y: 330, w: 960, h: 1000, in: 776, out: 960, anim: 'up', pos: '50% 40%' },
    { type: 'hl', box: true, x: 750, y: 600, w: 200, h: 230, in: 820, out: 960, anim: 'pop' },
    { type: 'txt', html: '<div class="p">TP. Đà Nẵng thu hồi đất dự án resort<br>để làm <em>bãi biển công cộng</em> cho người dân</div>', y: 1350, in: 840, out: 960 },

    // ===== 32–48 s: Cơ cấu căn hộ =====
    { type: 'txt', html: '<div class="kick">02 · Con số đáng chú ý</div><div class="h2" style="margin-top:10px">Nhìn kỹ <em>cơ cấu căn hộ</em></div>', y: 140, in: 965, out: 1440 },
    { type: 'img', src: 'ex/slide.jpg', x: 40, y: 380, w: 1000, h: 585, rot: -2, anim: 'drop', in: 980, out: 1140, r: 16 },
    { type: 'hl', x: 405, y: 690, w: 430, h: 96, in: 1015, out: 1140, dur: 22 },
    { type: 'bars', x: 219, y: 330, h: 700, in: 1145, out: 1440, items: [
      { label: 'Studio', sub: '30–31 m²', value: 513, color: '#FF7A1A', color2: '#E0560A' },
      { label: '1PN+1', sub: '50–51 m²', value: 108, color: '#FFB547', color2: '#E0962A' },
      { label: '2PN', sub: '60–70 m²', value: 149, color: '#7FB2FF', color2: '#3E78C8' },
    ] },
    { type: 'progress', pct: 66, x: 120, y: 1080, w: 840, in: 1215, out: 1310, label: 'Cứ <b>3 căn</b> thì có <em>2 căn là STUDIO</em>' },
    { type: 'txt', html: '<div class="h3">513 + 108 + 149 = <em>770</em></div><div class="p" style="margin-top:8px">Tổng công bố 782 → còn <span class="q">12 căn</span> chưa công bố chi tiết</div>', y: 1110, in: 1318, out: 1440, anim: 'pop' },

    // ===== 48–62 s: Vì sao là studio =====
    { type: 'txt', html: '<div class="kick">03 · Vì sao là studio?</div><div class="h2" style="margin-top:10px">Giữa <em>vùng lõi nghỉ dưỡng</em></div>', y: 140, in: 1445, out: 1650 },
    { type: 'img', src: 'ex/map_1250.jpg', x: 60, y: 330, w: 960, h: 640, in: 1460, out: 1650, anim: 'up', pos: '50% 35%' },
    { type: 'chips', x: 150, y: 1010, w: 800, in: 1490, out: 1650, stagger: 14, items: [
      { icon: 'hotel', name: 'Crowne Plaza', dist: '~700 m' },
      { icon: 'hotel', name: 'Hyatt Regency', dist: '~1,1 km' },
      { icon: 'hotel', name: 'Danang Marriott', dist: '~1,8 km' },
      { icon: 'mountain', name: 'Ngũ Hành Sơn', dist: '~2,1 km' },
      { icon: 'star', name: 'Phố cổ Hội An', dist: '~18 km' },
    ] },
    { type: 'txt', html: '<div class="h2">Khách du lịch cần<br><em>chỗ ở ngắn ngày</em></div>', y: 260, in: 1660, out: 1860 },
    { type: 'flow', y: 640, in: 1690, out: 1860, gap: 90, stagger: 24, nodes: [
      { icon: 'user', text: 'Khách<br>du lịch' }, { icon: 'bed', text: 'Căn hộ<br>studio' }, { icon: 'money', text: 'Dòng tiền<br>cho thuê' } ] },
    { type: 'txt', html: '<div class="p">Căn nhỏ, tổng giá trị thấp hơn<br>→ <em>dễ cho thuê nhất</em></div>', y: 1060, in: 1770, out: 1860 },

    // ===== 62–76 s: 3 câu hỏi =====
    { type: 'txt', html: '<div class="kick">04 · Trước khi xuống tiền</div><div class="h2" style="margin-top:10px"><em>3 câu hỏi</em> bắt buộc</div>', y: 140, in: 1865, out: 2280 },
    { type: 'check', x: 70, y: 420, w: 940, in: 1895, out: 2120, stagger: 40, items: [
      { n: '1', title: 'Pháp lý', sub: 'Dự án đã <b>đủ điều kiện mở bán</b> chưa?' },
      { n: '2', title: 'Thời hạn sở hữu', sub: '<b>Lâu dài</b> hay <b>có thời hạn</b>?' },
      { n: '3', title: 'Mật độ', sub: '<b>782 căn</b> trên <b>3.720 m²</b> đất' },
    ] },
    { type: 'scale', y: 400, in: 2125, out: 2280, left: '782', leftSub: 'căn hộ', right: '3.720', rightSub: 'm² đất', tilt: -9, anim: 'pop' },
    { type: 'count', to: 210, unit: 'căn / 1.000 m²', y: 960, size: 120, in: 2175, out: 2280, anim: 'pop', sub: 'Thang máy · chỗ đậu xe · hồ bơi <em>có đủ?</em>' },

    // ===== 76–85 s: Kết =====
    { type: 'txt', html: '<div class="p">Không chỉ là một căn hộ gần biển</div><div class="h2" style="margin-top:10px">Đó là <em>BÀI TOÁN<br>CHO THUÊ</em></div>', y: 140, in: 2288, out: null },
    { type: 'img', src: 'ex/p1.jpg', x: 60, y: 470, w: 960, h: 674, in: 2300, out: null, anim: 'zoom', kb: [1.0, 1.08] },
    { type: 'txt', html: '<span class="tag" style="font-size:36px">Giá mua</span> <span class="tag" style="font-size:36px">Pháp lý</span> <span class="tag" style="font-size:36px">Dòng tiền</span>', y: 1190, in: 2360, out: null, anim: 'pop' },
    { type: 'txt', html: '<span class="ghost" style="font-size:32px">Phần 2: Mổ xẻ giá bán &amp; khả năng cho thuê →</span>', y: 1310, in: 2420, out: null },
  ],
};
