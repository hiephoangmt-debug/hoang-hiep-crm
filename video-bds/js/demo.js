/* Dữ liệu mẫu để người mới bấm thử: tự vẽ ảnh minh hoạ các phòng. */
(function () {
  'use strict';

  var INFO = {
    loai: 'Căn hộ chung cư',
    ten: 'Sunrise Riverside A12',
    viTri: 'Nguyễn Hữu Thọ, Nhà Bè, TP.HCM',
    gia: '3,2 tỷ',
    dienTich: '70m²',
    phongNgu: '2',
    wc: '2',
    huong: 'Đông Nam',
    phapLy: 'Sổ hồng riêng',
    noiBat: 'Full nội thất cao cấp\nHỗ trợ vay ngân hàng 70%',
    moiGioi: 'Hoàng Hiệp',
    sdt: '0909 123 456',
    thuongHieu: 'Hoàng Hiệp Land'
  };

  function sky(ctx, x, y, w, h, top, bottom) {
    var g = ctx.createLinearGradient(0, y, 0, y + h);
    g.addColorStop(0, top);
    g.addColorStop(1, bottom);
    ctx.fillStyle = g;
    ctx.fillRect(x, y, w, h);
  }

  function room(ctx, W, H, wall, floor) {
    sky(ctx, 0, 0, W, H * 0.68, wall[0], wall[1]);
    sky(ctx, 0, H * 0.68, W, H * 0.32, floor[0], floor[1]);
    ctx.strokeStyle = 'rgba(0,0,0,0.08)';
    ctx.lineWidth = 2;
    for (var i = 0; i < 12; i++) {
      ctx.beginPath();
      ctx.moveTo(W / 2 + (i - 6) * 40, H * 0.68);
      ctx.lineTo(W / 2 + (i - 6) * 260, H);
      ctx.stroke();
    }
  }

  function windowView(ctx, x, y, w, h) {
    sky(ctx, x, y, w, h, '#7fc3f4', '#d8efff');
    ctx.fillStyle = 'rgba(70,110,150,0.55)';
    for (var i = 0; i < 6; i++) {
      var bw = w / 8, bh = h * (0.25 + ((i * 37) % 30) / 100);
      ctx.fillRect(x + i * w / 6 + 6, y + h - bh, bw, bh);
    }
    ctx.strokeStyle = '#f5f5f5';
    ctx.lineWidth = 12;
    ctx.strokeRect(x, y, w, h);
    ctx.beginPath();
    ctx.moveTo(x + w / 2, y);
    ctx.lineTo(x + w / 2, y + h);
    ctx.stroke();
  }

  function box(ctx, x, y, w, h, c, r) {
    ctx.fillStyle = c;
    ctx.beginPath();
    if (ctx.roundRect) ctx.roundRect(x, y, w, h, r || 10); else ctx.rect(x, y, w, h);
    ctx.fill();
  }

  var SCENES = [
    { caption: 'Mặt tiền', draw: function (ctx, W, H) {
      sky(ctx, 0, 0, W, H, '#6db6f2', '#fde6c4');
      ctx.fillStyle = '#e9e4da';
      ctx.fillRect(W * 0.25, H * 0.12, W * 0.5, H * 0.78);
      ctx.fillStyle = '#5c86a8';
      for (var r = 0; r < 9; r++) for (var c = 0; c < 5; c++) ctx.fillRect(W * 0.28 + c * W * 0.09, H * 0.16 + r * H * 0.08, W * 0.07, H * 0.055);
      ctx.fillStyle = '#d6d0c4';
      ctx.fillRect(W * 0.05, H * 0.4, W * 0.18, H * 0.5);
      ctx.fillRect(W * 0.77, H * 0.32, W * 0.18, H * 0.58);
      sky(ctx, 0, H * 0.9, W, H * 0.1, '#5a9a4e', '#3d7a36');
    } },
    { caption: 'Phòng khách', draw: function (ctx, W, H) {
      room(ctx, W, H, ['#f3ece2', '#e6dccd'], ['#c9a27a', '#a77e57']);
      windowView(ctx, W * 0.55, H * 0.12, W * 0.36, H * 0.42);
      box(ctx, W * 0.08, H * 0.5, W * 0.46, H * 0.2, '#56657a', 24);
      box(ctx, W * 0.1, H * 0.42, W * 0.42, H * 0.12, '#6b7b91', 20);
      box(ctx, W * 0.2, H * 0.75, W * 0.24, H * 0.06, '#3c2f25', 8);
      box(ctx, W * 0.6, H * 0.6, W * 0.06, H * 0.14, '#2f7a4a', 30);
    } },
    { caption: 'Phòng ngủ', draw: function (ctx, W, H) {
      room(ctx, W, H, ['#e8eef4', '#d6e0ea'], ['#b89a7c', '#97795c']);
      windowView(ctx, W * 0.08, H * 0.14, W * 0.28, H * 0.36);
      box(ctx, W * 0.4, H * 0.3, W * 0.5, H * 0.18, '#7a5b44', 12);
      box(ctx, W * 0.38, H * 0.48, W * 0.54, H * 0.24, '#f7f7f7', 18);
      box(ctx, W * 0.38, H * 0.6, W * 0.54, H * 0.12, '#c7a46a', 12);
      box(ctx, W * 0.45, H * 0.44, W * 0.14, H * 0.07, '#ffffff', 14);
      box(ctx, W * 0.7, H * 0.44, W * 0.14, H * 0.07, '#ffffff', 14);
    } },
    { caption: 'Bếp', draw: function (ctx, W, H) {
      room(ctx, W, H, ['#fbf7f0', '#ece3d5'], ['#8f8f8f', '#6e6e6e']);
      box(ctx, W * 0.05, H * 0.12, W * 0.9, H * 0.16, '#ffffff', 6);
      box(ctx, W * 0.05, H * 0.46, W * 0.9, H * 0.24, '#2f3a48', 6);
      box(ctx, W * 0.05, H * 0.43, W * 0.9, H * 0.04, '#e8e2d8', 4);
      box(ctx, W * 0.3, H * 0.62, W * 0.4, H * 0.18, '#d8c3a5', 10);
      ctx.fillStyle = '#c0c0c0';
      ctx.fillRect(W * 0.62, H * 0.36, W * 0.12, H * 0.07);
    } },
    { caption: 'Ban công', draw: function (ctx, W, H) {
      sky(ctx, 0, 0, W, H * 0.7, '#ffb36b', '#ffe3b8');
      ctx.fillStyle = 'rgba(80,90,130,0.6)';
      for (var i = 0; i < 9; i++) ctx.fillRect(i * W / 9, H * (0.35 + (i % 3) * 0.06), W / 12, H * 0.4);
      ctx.fillStyle = '#4f7fb0';
      ctx.fillRect(0, H * 0.62, W, H * 0.06);
      sky(ctx, 0, H * 0.7, W, H * 0.3, '#9b8b78', '#7a6b59');
      ctx.strokeStyle = '#2b2b2b';
      ctx.lineWidth = 8;
      ctx.beginPath();
      ctx.moveTo(0, H * 0.58);
      ctx.lineTo(W, H * 0.58);
      ctx.stroke();
      for (var j = 0; j < 20; j++) {
        ctx.beginPath();
        ctx.moveTo(j * W / 20, H * 0.58);
        ctx.lineTo(j * W / 20, H * 0.72);
        ctx.stroke();
      }
    } }
  ];

  // Ảnh minh hoạ thêm cho mẫu dự án căn hộ cao tầng
  var EXTRA = {
    tower: function (ctx, W, H) {
      sky(ctx, 0, 0, W, H * 0.75, '#1f3b73', '#f2a65a');
      // Toà tháp chính
      sky(ctx, W * 0.38, H * 0.08, W * 0.24, H * 0.72, '#e8edf3', '#c6d0dc');
      ctx.fillStyle = 'rgba(255,214,120,0.9)';
      for (var r = 0; r < 20; r++) for (var c = 0; c < 4; c++) {
        if ((r * 7 + c * 3) % 5 === 0) continue;
        ctx.fillRect(W * 0.395 + c * W * 0.056, H * 0.1 + r * H * 0.034, W * 0.042, H * 0.022);
      }
      // Các toà bên cạnh
      sky(ctx, W * 0.12, H * 0.28, W * 0.2, H * 0.52, '#d5dce6', '#aeb9c7');
      sky(ctx, W * 0.68, H * 0.22, W * 0.2, H * 0.58, '#d5dce6', '#aeb9c7');
      // Sông
      sky(ctx, 0, H * 0.8, W, H * 0.2, '#2c5d8f', '#173a5e');
      ctx.fillStyle = 'rgba(255,200,120,0.35)';
      for (var k = 0; k < 14; k++) ctx.fillRect(W * 0.4 + ((k * 53) % 300) - 60, H * 0.82 + k * 12, 120 - k * 5, 4);
    },
    pool: function (ctx, W, H) {
      sky(ctx, 0, 0, W, H * 0.45, '#8ccdf7', '#e6f5ff');
      sky(ctx, 0, H * 0.45, W, H * 0.1, '#ece6da', '#ddd4c4');
      sky(ctx, 0, H * 0.55, W, H * 0.45, '#2fb7d6', '#11809f');
      ctx.strokeStyle = 'rgba(255,255,255,0.35)';
      ctx.lineWidth = 4;
      for (var i = 0; i < 9; i++) {
        ctx.beginPath();
        for (var x = 0; x <= W; x += 40) ctx.lineTo(x, H * 0.6 + i * 45 + Math.sin(x / 70 + i) * 8);
        ctx.stroke();
      }
      box(ctx, W * 0.08, H * 0.4, W * 0.12, H * 0.07, '#ffffff', 10);
      box(ctx, W * 0.24, H * 0.4, W * 0.12, H * 0.07, '#ffffff', 10);
      ctx.fillStyle = '#2f7a4a';
      [0.7, 0.82, 0.93].forEach(function (x) {
        ctx.beginPath();
        ctx.arc(W * x, H * 0.3, W * 0.05, 0, Math.PI * 2);
        ctx.fill();
        ctx.fillRect(W * x - 6, H * 0.3, 12, H * 0.16);
      });
    }
  };

  // Bản đồ vị trí minh hoạ
  EXTRA.map = function (ctx, W, H) {
    ctx.fillStyle = '#efe9dc';
    ctx.fillRect(0, 0, W, H);
    ctx.fillStyle = '#cfe6c4';
    box(ctx, W * 0.05, H * 0.08, W * 0.25, H * 0.3, '#cfe6c4', 30);
    box(ctx, W * 0.62, H * 0.6, W * 0.3, H * 0.3, '#cfe6c4', 30);
    // Sông
    ctx.strokeStyle = '#8cc4ee';
    ctx.lineWidth = 90;
    ctx.beginPath();
    ctx.moveTo(W * 0.1, -20);
    ctx.bezierCurveTo(W * 0.35, H * 0.4, W * 0.15, H * 0.7, W * 0.3, H + 20);
    ctx.stroke();
    // Đường
    ctx.strokeStyle = '#ffffff';
    ctx.lineWidth = 34;
    ctx.beginPath(); ctx.moveTo(0, H * 0.55); ctx.lineTo(W, H * 0.45); ctx.stroke();
    ctx.beginPath(); ctx.moveTo(W * 0.58, 0); ctx.lineTo(W * 0.52, H); ctx.stroke();
    ctx.strokeStyle = '#f2c14e';
    ctx.lineWidth = 8;
    ctx.beginPath(); ctx.moveTo(0, H * 0.55); ctx.lineTo(W, H * 0.45); ctx.stroke();
    ctx.beginPath(); ctx.moveTo(W * 0.58, 0); ctx.lineTo(W * 0.52, H); ctx.stroke();
    ctx.fillStyle = '#5b5b5b';
    ctx.font = '600 34px sans-serif';
    ctx.fillText('Minh Mạng', W * 0.7, H * 0.43);
    ctx.save();
    ctx.translate(W * 0.6, H * 0.2);
    ctx.rotate(Math.PI / 2 - 0.06);
    ctx.fillText('Nguyễn Phước Lan', 0, 0);
    ctx.restore();
    // Ghim vị trí
    var px = W * 0.552, py = H * 0.49;
    ctx.fillStyle = '#e5312f';
    ctx.beginPath();
    ctx.arc(px, py - 70, 42, Math.PI, 0);
    ctx.lineTo(px, py);
    ctx.closePath();
    ctx.fill();
    ctx.fillStyle = '#fff';
    ctx.beginPath(); ctx.arc(px, py - 70, 16, 0, Math.PI * 2); ctx.fill();
  };

  var PRESETS = {
    mau: { info: INFO, images: { a: SCENES[0], b: SCENES[1], c: SCENES[2], d: SCENES[3], e: SCENES[4] } },
    f2: {
      // Kịch bản mẫu theo bảng “C Dương” (7 cảnh). Giá và chính sách cần kiểm tra lại với chủ đầu tư.
      info: {
        loai: 'Căn hộ chung cư',
        ten: 'F2 FourS Tower',
        viTri: 'Giao lộ Minh Mạng – Nguyễn Phước Lan, Hòa Xuân, Đà Nẵng',
        gia: 'từ hơn 1,6 tỷ',
        dienTich: '', phongNgu: '', wc: '', huong: '',
        phapLy: 'Sở hữu lâu dài',
        noiBat: '',
        moiGioi: 'Dương',
        sdt: '09xx xxx xxx',
        thuongHieu: '',
        chuDauTu: 'Sun Group',
        sanPham: 'Studio, 1 phòng ngủ+, 2 phòng ngủ, 3 phòng ngủ, Penthouse và shop khối đế',
        quyMo: '20 tầng nổi\n2 tầng hầm\nHơn 580 căn hộ',
        ketNoi: 'Hải Châu 7 phút\nSân bay Đà Nẵng 10 phút\nBiển Sơn Thủy 5 phút',
        tienIch: 'Hồ bơi\nPhòng gym\nSpa\nKid’s Club',
        chinhSach: 'Thanh toán 25% đến khi nhận nhà\nHỗ trợ tài chính và tiến độ thanh toán theo từng giai đoạn',
        suKien: 'Ngày 26/9, F2 FourS Tower chính thức được giới thiệu tại Hotel Royal Lotus Đà Nẵng'
      },
      images: { tower: { caption: 'Phối cảnh', draw: EXTRA.tower }, map: { caption: 'Vị trí', draw: EXTRA.map },
        pool: { caption: 'Hồ bơi', draw: EXTRA.pool }, living: SCENES[1], bedroom: SCENES[2], balcony: SCENES[4] },
      script: [
        { title: 'Cảnh 1 – Hook', images: ['tower'], bigText: [],
          text: 'Có 1,6 tỷ mà muốn sở hữu BĐS tại Đà Nẵng? Nghe có vẻ khó… nhưng chưa chắc đâu!\nKhoan, đừng lướt vội! Vì Dương có một phương án có thể bạn đang tìm.\nĐặc biệt, chỉ thanh toán 25% đến khi nhận nhà!\nXem hết video, Dương sẽ nói rõ 1,6 tỷ có thể mua được gì và bài toán tài chính được tính như thế nào nhé!',
          shotNote: 'Quay cận mặt, nhìn thẳng camera, nói nhanh và có năng lượng.' },
        { title: 'Cảnh 2 – F2 chính là lời giải', images: ['tower', 'map'], bigText: [],
          text: 'Và lời giải cho bài toán 1,6 tỷ mà Dương vừa nói chính là đây!\nSun Group chính thức ra mắt tòa F2, thuộc tổ hợp FourS Tower, với mức giá chỉ từ hơn 1,6 tỷ đồng/căn.\nF2 tọa lạc ngay giao lộ Minh Mạng – Nguyễn Phước Lan, một trong những trục đường lớn tại khu vực Nam Đà Nẵng.',
          shotNote: 'Phối cảnh F2 → Logo Sun Group → Bản đồ vị trí → Cận cảnh tòa F2.' },
        { title: 'Cảnh 3 – Quy mô và sản phẩm', images: ['tower'], bigText: ['20 tầng nổi', '2 tầng hầm', '580+ căn hộ', 'Sở hữu lâu dài'],
          text: 'F2 được quy hoạch với 20 tầng nổi và 2 tầng hầm, cung cấp hơn 580 căn hộ.\nĐặc biệt, sản phẩm khá đa dạng, từ Studio, 1 phòng ngủ+, 2 phòng ngủ, 3 phòng ngủ, đến Penthouse và shop khối đế.\nVà một điểm rất đáng chú ý: căn hộ sở hữu lâu dài.',
          shotNote: 'Text chạy màn hình các con số quy mô trên nền phối cảnh.' },
        { title: 'Cảnh 4 – Vị trí', images: ['map'], bigText: ['Hải Châu 7 phút', 'Sân bay 10 phút', 'Biển Sơn Thủy 5 phút'],
          text: 'Nằm ngay giao lộ Minh Mạng – Nguyễn Phước Lan, F2 FourS Tower sở hữu khả năng kết nối thuận tiện đến nhiều khu vực quan trọng của Đà Nẵng.\nTừ đây, cư dân có thể dễ dàng kết nối về Hải Châu chỉ 7 phút, sân bay Đà Nẵng chỉ 10 phút, bãi tắm biển Sơn Thủy chỉ 5 phút.\nĐặc biệt, khu vực Hòa Xuân đang từng bước hình thành một hệ sinh thái đô thị mới với nhiều dự án, tiện ích và hạ tầng đang được phát triển.',
          shotNote: 'Google Maps → đường Minh Mạng → Nguyễn Phước Lan → các điểm kết nối.' },
        { title: 'Cảnh 5 – Tiện ích', images: ['pool', 'living', 'bedroom'], bigText: [],
          text: 'Không chỉ là một căn hộ để ở, F2 FourS Tower còn hướng đến một không gian sống đầy đủ tiện ích ngay trong nội khu.\nTừ hồ bơi, phòng gym, spa đến Kid’s Club, mọi nhu cầu thư giãn, vận động và vui chơi của gia đình đều được tích hợp ngay tại dự án.',
          shotNote: 'Chuyển cảnh nhanh: Hồ bơi → Gym → Spa → Kid’s Club → Gia đình.' },
        { title: 'Cảnh 6 – Bài toán tài chính', images: [], bigText: ['Từ hơn 1,6 tỷ/căn', '25% đến khi nhận nhà'],
          text: 'Và đây mới là phần mà Dương nghĩ nhiều bạn sẽ quan tâm nhất.\nVới chính sách hiện tại, khách hàng có thể thanh toán 25% đến khi nhận nhà, giúp giảm áp lực vốn ban đầu và chủ động hơn trong kế hoạch tài chính.\nBên cạnh đó là chính sách hỗ trợ tài chính và tiến độ thanh toán theo từng giai đoạn của chủ đầu tư.',
          shotNote: 'Text lớn trên nền màu.' },
        { title: 'Cảnh 7 – Sự kiện 26/9 và kêu gọi', images: ['balcony'], bigText: ['Ra mắt 26/9', 'Hotel Royal Lotus'],
          text: 'Và đặc biệt, ngày 26/9 này, F2 FourS Tower sẽ chính thức được giới thiệu tại Hotel Royal Lotus Đà Nẵng.\nNếu bạn đang quan tâm một căn hộ tại Nam Đà Nẵng, với mức tài chính khoảng 1,6 tỷ, thì đây là thời điểm rất phù hợp để tìm hiểu thông tin và lựa chọn căn.\nLiên hệ ngay Dương, để nhận quỹ căn đẹp sắp đến nha.',
          shotNote: 'Quay cận mặt, mỉm cười, chỉ tay xuống chỗ số điện thoại.' }
      ]
    }
  };

  /** Vẽ ảnh minh hoạ của một mẫu; trả về { khoá: { el, url, caption } } theo đúng thứ tự. */
  function makeImages(key, cb) {
    var defs = (PRESETS[key] || PRESETS.mau).images;
    var keys = Object.keys(defs);
    var out = {};
    var W = 1600, H = 1100;
    var pending = keys.length;
    keys.forEach(function (k) {
      var s = defs[k];
      var c = document.createElement('canvas');
      c.width = W;
      c.height = H;
      var ctx = c.getContext('2d');
      s.draw(ctx, W, H);
      ctx.fillStyle = 'rgba(255,255,255,0.75)';
      ctx.font = '600 40px sans-serif';
      ctx.fillText('ẢNH MẪU', 40, H - 40);
      var img = new Image();
      img.onload = function () {
        out[k] = { el: img, url: img.src, caption: s.caption };
        if (--pending === 0) {
          var ordered = {};
          keys.forEach(function (kk) { ordered[kk] = out[kk]; });
          cb(ordered);
        }
      };
      img.src = c.toDataURL('image/jpeg', 0.88);
    });
  }

  window.BdsDemo = { INFO: INFO, PRESETS: PRESETS, makeImages: makeImages };
})();
