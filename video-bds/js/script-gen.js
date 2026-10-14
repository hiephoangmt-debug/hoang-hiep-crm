/* Tạo kịch bản video BĐS tự động từ thông tin căn + chú thích ảnh. */
(function () {
  'use strict';

  var STYLES = {
    'chuyen-nghiep': 'Chuyên nghiệp',
    'gan-gui': 'Gần gũi, thân thiện',
    'tiktok': 'Ngắn gọn kiểu TikTok',
    'sang-trong': 'Sang trọng, cao cấp'
  };

  var HOOKS = {
    'chuyen-nghiep': [
      'Giới thiệu {loai} {ten} tại {viTri}, giá chỉ {gia}.',
      'Cơ hội sở hữu {loai} {ten}, vị trí {viTri}, giá {gia}.',
      'Cùng xem chi tiết {loai} {ten} đang được chào bán tại {viTri}.'
    ],
    'gan-gui': [
      'Chào cả nhà! Hôm nay mình dẫn mọi người đi xem {loai} {ten} ở {viTri} nhé.',
      'Cả nhà ơi, {loai} xinh xắn ở {viTri} giá chỉ {gia} đây ạ!',
      'Ai đang tìm {loai} ở {viTri} thì xem ngay căn này nha.'
    ],
    'tiktok': [
      '{gia} có ngay {loai} ở {viTri}? Xem hết nhé!',
      'Đừng lướt! {loai} {dienTich} ở {viTri} chỉ {gia}.',
      'Căn này ở {viTri} mà giá chỉ {gia} thôi!'
    ],
    'sang-trong': [
      'Chào mừng quý khách đến với {tenL}, biểu tượng sống thượng lưu tại {viTri}.',
      '{TenL}: không gian sống đẳng cấp dành cho người tinh tế, tại {viTri}.',
      'Trân trọng giới thiệu {loai} {ten}, tuyệt tác tại {viTri}.'
    ]
  };


  var CTA = {
    'chuyen-nghiep': [
      'Liên hệ {moiGioi}, số {sdt}, để được tư vấn và xem nhà trực tiếp.',
      'Gọi ngay {sdt} gặp {moiGioi} để nhận thông tin chi tiết và lịch xem nhà.'
    ],
    'gan-gui': [
      'Ưng thì gọi hoặc nhắn Zalo cho {moiGioi} số {sdt} nha cả nhà!',
      'Cả nhà cần xem nhà thì alo {moiGioi}, {sdt}, mình dẫn đi tận nơi nhé!'
    ],
    'tiktok': [
      'Gọi ngay {sdt} trước khi hết căn!',
      'Inbox hoặc gọi {sdt} để xem nhà ngay!'
    ],
    'sang-trong': [
      'Kính mời quý khách liên hệ {moiGioi}, {sdt}, để đặt lịch tham quan riêng.',
      'Để trải nghiệm trực tiếp, xin liên hệ {moiGioi} qua số {sdt}.'
    ]
  };

  // Từ khoá trong chú thích ảnh → câu mô tả (mỗi phong cách dùng chung, đổi biến thể theo lượt)
  var ROOMS = [
    { k: ['phòng khách', 'phong khach', 'living'], v: [
      'Phòng khách rộng rãi, đón ánh sáng tự nhiên.',
      'Phòng khách thoáng đãng, nơi cả gia đình quây quần.',
      'Không gian phòng khách hiện đại, sang trọng.'] },
    { k: ['phòng ngủ', 'phong ngu', 'bedroom', 'master'], v: [
      'Phòng ngủ yên tĩnh, riêng tư và ấm cúng.',
      'Phòng ngủ thoáng mát, thiết kế tinh tế.',
      'Phòng ngủ rộng, có cửa sổ lấy sáng tốt.'] },
    { k: ['bếp', 'bep', 'kitchen', 'phòng ăn'], v: [
      'Khu bếp gọn gàng, tiện nghi cho việc nấu nướng.',
      'Bếp và bàn ăn liền mạch, ấm cúng.',
      'Khu bếp hiện đại, đầy đủ công năng.'] },
    { k: ['wc', 'vệ sinh', 've sinh', 'tắm', 'tam', 'toilet', 'bath'], v: [
      'Phòng tắm sạch sẽ, thiết bị hiện đại.',
      'Nhà vệ sinh rộng, thông thoáng.',
      'Phòng tắm được hoàn thiện chỉn chu.'] },
    { k: ['ban công', 'ban cong', 'logia', 'balcony'], v: [
      'Ban công thoáng gió, thư giãn mỗi sáng.',
      'Ban công rộng, đón gió mát cả ngày.',
      'Ban công lý tưởng để thưởng trà ngắm cảnh.'] },
    { k: ['mặt tiền', 'mat tien', 'ngoại thất', 'ngoai that', 'tổng thể', 'toàn cảnh', 'phối cảnh', 'tòa tháp', 'facade'], v: [
      'Ngoại thất bề thế, mặt tiền đẹp.',
      'Toàn cảnh căn nhà hiện đại, nổi bật.',
      'Thiết kế mặt tiền sang trọng, ấn tượng.'] },
    { k: ['sân', 'san', 'vườn', 'vuon', 'garden'], v: [
      'Sân vườn xanh mát, không gian thư giãn.',
      'Khoảng sân rộng, cây xanh mát mắt.',
      'Sân vườn riêng, lý tưởng cho gia đình.'] },
    { k: ['hồ bơi', 'ho boi', 'bể bơi', 'pool'], v: [
      'Hồ bơi tràn bờ, tận hưởng như nghỉ dưỡng.',
      'Hồ bơi trong xanh ngay trong khuôn viên.',
      'Bể bơi rộng, thư giãn mỗi cuối tuần.'] },
    { k: ['tiện ích', 'tien ich', 'gym', 'công viên', 'cong vien', 'sảnh', 'sanh'], v: [
      'Tiện ích nội khu đầy đủ, đáp ứng mọi nhu cầu.',
      'Hệ thống tiện ích hiện đại ngay dưới nhà.',
      'Tiện ích đa dạng cho cả gia đình.'] },
    { k: ['đường', 'duong', 'hẻm', 'hem', 'ngõ', 'ngo', 'vị trí', 'vi tri'], v: [
      'Đường trước nhà rộng, xe hơi vào tận nơi.',
      'Vị trí thuận tiện, kết nối nhanh đến trung tâm.',
      'Giao thông thuận lợi, an ninh tốt.'] },
    { k: ['view', 'cảnh quan', 'tầm nhìn', 'sông', 'biển', 'hồ'], v: [
      'View đẹp, thoáng mát, không bị che chắn.',
      'Tầm nhìn rộng mở, ngắm trọn cảnh quan.',
      'View triệu đô, ngắm cảnh mỗi ngày.'] }
  ];

  // Câu dùng khi ảnh không có chú thích và đã hết điểm nổi bật
  var GENERIC = [
    'Không gian thoáng đãng, sáng sủa.',
    'Mọi chi tiết đều được hoàn thiện chỉn chu.',
    'Khu vực xung quanh an ninh, yên tĩnh.',
    'Sẵn sàng giao dịch, xem nhà bất cứ lúc nào.'
  ];

  function upperFirst(s) { return s ? s.charAt(0).toUpperCase() + s.slice(1) : s; }

  /** Viết hoa đầu câu (sau . ! ?) */
  function sentenceCase(s) {
    return upperFirst(s).replace(/([.!?]\s+)(\S)/g, function (_, p, c) { return p + c.toUpperCase(); });
  }

  function fill(tpl, d) {
    return sentenceCase(tpl.replace(/\{(\w+)\}/g, function (_, key) { return d[key] || ''; })
      .replace(/\s+,/g, ',').replace(/,\s*,/g, ',').replace(/\s{2,}/g, ' ')
      .replace(/\s+\./g, '.').trim());
  }

  /** Câu tổng quan: chỉ nhắc những thông số đã điền. */
  function overview(info, style) {
    var phong = phongText(info);
    var phapLy = lowerFirst(info.phapLy);
    if (style === 'tiktok') {
      return upperFirst([info.dienTich, phong, phapLy].filter(Boolean).join(', ')) + '!';
    }
    var parts = [];
    if (info.dienTich) parts.push('diện tích ' + info.dienTich);
    if (phong) parts.push(phong);
    if (info.huong) parts.push('hướng ' + info.huong);
    if (phapLy) parts.push('pháp lý ' + phapLy);
    var body = parts.join(', ');
    if (style === 'gan-gui') return 'Căn này có ' + body + (phapLy ? ' nên cả nhà yên tâm nha.' : ' nha cả nhà.');
    if (style === 'sang-trong') return upperFirst(body) + ', mọi chi tiết đều được chăm chút.';
    return upperFirst(body) + '.';
  }

  function lowerFirst(s) {
    s = (s || '').trim();
    // Giữ nguyên từ viết tắt như WC, HĐMB
    var first = s.split(/\s/)[0];
    if (first.length > 1 && first === first.toUpperCase()) return s;
    return s.charAt(0).toLowerCase() + s.slice(1);
  }

  function phongText(info) {
    var parts = [];
    if (info.phongNgu) parts.push(info.phongNgu + ' phòng ngủ');
    if (info.wc) parts.push(info.wc + ' WC');
    return parts.join(', ');
  }

  /** Nhóm phòng/khu vực mà câu chữ nhắc tới (-1 nếu không có). */
  function groupOf(text) {
    var c = (text || '').toLowerCase();
    for (var i = 0; i < ROOMS.length; i++) {
      for (var j = 0; j < ROOMS[i].k.length; j++) if (c.indexOf(ROOMS[i].k[j]) !== -1) return i;
    }
    return -1;
  }

  function describeCaption(caption, variant, highlight) {
    var c = (caption || '').toLowerCase();
    for (var i = 0; i < ROOMS.length; i++) {
      for (var j = 0; j < ROOMS[i].k.length; j++) {
        if (c.indexOf(ROOMS[i].k[j]) !== -1) {
          var v = ROOMS[i].v;
          return v[variant % v.length];
        }
      }
    }
    if (highlight) return highlight.charAt(0).toUpperCase() + highlight.slice(1).replace(/\.?$/, '.');
    if (caption) return caption.charAt(0).toUpperCase() + caption.slice(1) + ' được thiết kế hợp lý, tiện nghi.';
    return '';
  }

  /**
   * Tạo kịch bản: trả về mảng câu, mỗi câu ứng với một cảnh.
   * Cảnh 0 = mở đầu, cảnh 1..n = từng ảnh/clip, cảnh cuối = kêu gọi liên hệ.
   */
  function generate(info, captions, style, variant) {
    style = STYLES[style] ? style : 'chuyen-nghiep';
    variant = variant || 0;
    var d = {
      loai: (info.loai || 'căn nhà').toLowerCase(),
      ten: info.ten || '',
      tenL: info.ten || (info.loai || 'căn nhà').toLowerCase(),
      TenL: upperFirst(info.ten || (info.loai || 'căn nhà')),
      viTri: info.viTri || 'vị trí đẹp',
      gia: info.gia || 'giá tốt',
      dienTich: info.dienTich || '',
      moiGioi: info.moiGioi || 'chúng tôi',
      sdt: info.sdt || ''
    };

    var hooks = HOOKS[style];
    var lines = [fill(hooks[variant % hooks.length], d)];

    var highlights = (info.noiBat || '').split(/\n|;/).map(function (s) { return s.trim(); }).filter(Boolean);
    var hi = 0;
    var overviewUsed = false;
    for (var i = 0; i < captions.length; i++) {
      var line = '';
      var known = describeCaption(captions[i], variant + i, null);
      if (i === 0 && !overviewUsed && (info.dienTich || info.phongNgu)) {
        line = overview(info, style);
        overviewUsed = true;
      } else if (captions[i] && known && known.indexOf('được thiết kế hợp lý') === -1) {
        line = known;
      } else if (hi < highlights.length) {
        line = describeCaption('', 0, highlights[hi++]);
      } else {
        line = known || GENERIC[(variant + i) % GENERIC.length];
      }
      if (style === 'tiktok' && i > 0) line = line.split(',')[0].replace(/[.!]?$/, '!');
      lines.push(line);
    }
    // Điểm nổi bật còn lại: ưu tiên ghép vào đúng cảnh có cùng chủ đề (VD: “hồ bơi…” vào cảnh Hồ bơi),
    // không khớp thì rải đều, mỗi cảnh thêm một ý (bỏ qua cảnh tổng quan đầu tiên)
    var left = highlights.slice(hi);
    var end = style === 'tiktok' ? '!' : '.';
    var replaced = {}, appended = {};
    var rr = 0;
    left.forEach(function (h) {
      var sentence = upperFirst(h).replace(/[.!]?$/, end);
      var g = groupOf(h);
      for (var j = 1; j < captions.length && g !== -1; j++) {
        if (!replaced[j + 1] && groupOf(captions[j]) === g) {
          lines[j + 1] = sentence;
          replaced[j + 1] = true;
          return;
        }
      }
      var slots = [];
      for (var k = 2; k < lines.length; k++) if (!replaced[k] && !appended[k]) slots.push(k);
      if (!slots.length) for (var m = 2; m < lines.length; m++) slots.push(m);
      if (!slots.length) slots.push(lines.length - 1);
      var at = slots[rr++ % slots.length];
      lines[at] += ' ' + sentence;
      appended[at] = true;
    });
    var ctas = CTA[style];
    lines.push(fill(ctas[variant % ctas.length], d));
    return lines;
  }

  /** Ước lượng thời gian đọc (giây) cho một câu tiếng Việt, khoảng 3 tiếng/giây. */
  function readSeconds(text) {
    var words = (text || '').trim().split(/\s+/).filter(Boolean).length;
    return Math.max(2.5, Math.min(9, words / 3.2 + 0.8));
  }

  window.ScriptGen = { STYLES: STYLES, generate: generate, readSeconds: readSeconds };
})();
