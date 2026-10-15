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
    var w = s.split(/\s+/);
    if (w[0].length > 1 && w[0] === w[0].toUpperCase()) return s;
    // Tên riêng (VD: "Hải Châu", "Kids Club"): từ thứ hai cũng viết hoa thì giữ nguyên
    if (w[1] && /^\p{Lu}/u.test(w[1])) return s;
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


  /* ---------- Kịch bản nhiều cảnh (giới thiệu dự án) ---------- */

  function splitList(t) {
    return (t || '').split(/\n|;/).map(function (x) { return x.trim().replace(/^[-•*]\s*/, ''); }).filter(Boolean);
  }

  function shortPrice(gia) {
    return (gia || '').replace(/^(giá\s*)?(chỉ\s*)?(từ\s*)?(hơn\s*)?/i, '').trim();
  }

  function city(viTri) {
    var parts = (viTri || '').split(',').map(function (x) { return x.trim(); }).filter(Boolean);
    return parts[parts.length - 1] || viTri || '';
  }

  function joinVi(list) {
    if (list.length <= 1) return list.join('');
    return list.slice(0, -1).join(', ') + ' và ' + list[list.length - 1];
  }

  /**
   * Kịch bản giới thiệu dự án theo cảnh (hook → giải pháp → quy mô → vị trí → tiện ích → tài chính → CTA).
   * Cảnh nào thiếu thông tin thì bỏ qua.
   */
  function generateProject(info) {
    var me = info.moiGioi || 'mình';
    var ten = info.ten || info.loai || 'dự án';
    var gia = info.gia || '';
    var g = shortPrice(gia);
    var tp = city(info.viTri);
    var loai = (info.loai || 'căn hộ').toLowerCase();
    var chinhSach = splitList(info.chinhSach);
    var ketNoi = splitList(info.ketNoi);
    var tienIch = splitList(info.tienIch);
    var quyMo = splitList(info.quyMo);
    var noiBat = splitList(info.noiBat);
    var scenes = [];

    var hook = [];
    hook.push(g ? 'Có ' + g + ' mà muốn sở hữu ' + loai + ' tại ' + tp + '? Nghe có vẻ khó… nhưng chưa chắc đâu!'
      : 'Bạn đang tìm ' + loai + ' tại ' + tp + '? Khoan, đừng lướt vội!');
    if (g) hook.push('Khoan, đừng lướt vội! Vì ' + me + ' có một phương án có thể bạn đang tìm.');
    if (chinhSach[0]) hook.push('Đặc biệt, ' + lowerFirst(chinhSach[0]).replace(/[.!]?$/, '!'));
    hook.push('Xem hết video, ' + me + ' sẽ nói rõ ' + (g ? g + ' có thể mua được gì' : 'mọi thông tin') + ' và bài toán tài chính được tính như thế nào nhé!');
    scenes.push({ title: 'Cảnh 1 – Hook', text: hook.join('\n'), bigText: [],
      shotNote: 'Quay cận mặt, nhìn thẳng camera, nói nhanh và có năng lượng. 3 giây đầu quyết định người xem có ở lại không.' });

    var sol = ['Và lời giải ' + (g ? 'cho bài toán ' + g + ' ' : '') + 'chính là đây!'];
    sol.push((info.chuDauTu ? info.chuDauTu + ' chính thức ra mắt ' : 'Giới thiệu ') + ten + (gia ? ', với mức giá chỉ ' + gia + '.' : '.'));
    if (info.viTri) sol.push(ten + ' tọa lạc tại ' + info.viTri + '.');
    scenes.push({ title: 'Cảnh 2 – ' + ten + ' chính là lời giải', text: sol.join('\n'),
      bigText: [ten].concat(gia ? ['Giá ' + gia] : []),
      shotNote: 'Phối cảnh dự án → logo chủ đầu tư → bản đồ vị trí → cận cảnh toà nhà.' });

    if (quyMo.length || info.sanPham) {
      var qm = [];
      if (quyMo.length) qm.push(ten + ' được quy hoạch với ' + joinVi(quyMo.map(lowerFirst)) + '.');
      if (info.sanPham) qm.push('Sản phẩm đa dạng: ' + lowerFirst(info.sanPham).replace(/[.]?$/, '.'));
      if (info.phapLy) qm.push('Và một điểm rất đáng chú ý: ' + lowerFirst(info.phapLy) + '.');
      scenes.push({ title: 'Cảnh 3 – Quy mô và sản phẩm', text: qm.join('\n'),
        bigText: quyMo.slice(0, 3).concat(info.phapLy ? [info.phapLy] : []),
        shotNote: 'Phối cảnh tổng thể, flycam toà nhà, mặt bằng căn hộ. Chữ chạy màn hình các con số quy mô.' });
    }

    if (ketNoi.length) {
      scenes.push({ title: 'Cảnh 4 – Vị trí', text: [
        'Nằm tại ' + (info.viTri || tp) + ', ' + ten + ' kết nối thuận tiện đến nhiều khu vực quan trọng.',
        'Từ đây, bạn có thể dễ dàng đến ' + joinVi(ketNoi.map(lowerFirst)) + '.'
      ].join('\n'), bigText: ketNoi.slice(0, 4),
        shotNote: 'Google Maps → các trục đường chính → các điểm kết nối. Có thể quay màn hình điện thoại khi mở bản đồ.' });
    }

    var ti = tienIch.length ? tienIch : noiBat;
    if (ti.length) {
      scenes.push({ title: 'Cảnh 5 – Tiện ích', text: [
        'Không chỉ là một nơi để ở, ' + ten + ' còn mang đến không gian sống đầy đủ tiện ích.',
        'Từ ' + joinVi(ti.map(lowerFirst)) + ', mọi nhu cầu thư giãn, vận động và vui chơi của gia đình đều có ngay tại dự án.'
      ].join('\n'), bigText: [],
        shotNote: 'Chuyển cảnh nhanh: ' + ti.slice(0, 5).join(' → ') + ' → gia đình sinh hoạt.' });
    }

    if (chinhSach.length || g) {
      var cs = ['Và đây mới là phần mà ' + me + ' nghĩ nhiều bạn sẽ quan tâm nhất.'];
      chinhSach.forEach(function (c, i) { cs.push((i === 0 ? 'Với chính sách hiện tại, ' : 'Bên cạnh đó, ') + lowerFirst(c).replace(/[.]?$/, '.')); });
      scenes.push({ title: 'Cảnh 6 – Bài toán tài chính', text: cs.join('\n'),
        bigText: (g ? ['Từ ' + g] : []).concat(chinhSach.slice(0, 2)),
        shotNote: 'Chữ lớn trên nền tối, hoặc quay cận mặt giải thích. Có thể chèn ảnh bảng tính dòng tiền.' });
    }

    var cta = [];
    if (info.suKien) cta.push('Và đặc biệt, ' + lowerFirst(info.suKien).replace(/[.]?$/, '.'));
    cta.push('Nếu bạn đang quan tâm ' + loai + ' tại ' + tp + (g ? ', với tài chính khoảng ' + g : '') + ', thì đây là thời điểm rất phù hợp để tìm hiểu và chọn căn.');
    cta.push('Liên hệ ngay ' + me + (info.sdt ? ', số ' + info.sdt : '') + ', để nhận quỹ căn đẹp nha!');
    scenes.push({ title: 'Cảnh ' + (scenes.length + 1) + ' – ' + (info.suKien ? 'Sự kiện và kêu gọi' : 'Kêu gọi liên hệ'), text: cta.join('\n'),
      bigText: info.suKien ? [info.suKien.split(/[,.]/)[0]] : [],
      shotNote: 'Quay cận mặt, mỉm cười, chỉ tay xuống dưới (chỗ số điện thoại sẽ hiện ở cuối video).' });

    scenes.forEach(function (sc, i) { sc.title = sc.title.replace(/^Cảnh \d+/, 'Cảnh ' + (i + 1)); });
    return scenes;
  }

  /* ---------- Nhập kịch bản từ Google Sheets / Excel ---------- */

  /** Đọc bảng dạng TSV (copy từ Google Sheets) hoặc CSV, có hỗ trợ ô nhiều dòng trong dấu ngoặc kép. */
  function parseTable(text) {
    text = (text || '').replace(/\r\n?/g, '\n');
    var delim = text.indexOf('\t') !== -1 ? '\t' : ',';
    var rows = [], row = [], cell = '', q = false;
    for (var i = 0; i < text.length; i++) {
      var c = text[i];
      if (q) {
        if (c === '"') {
          if (text[i + 1] === '"') { cell += '"'; i++; } else q = false;
        } else cell += c;
      } else if (c === '"' && cell === '') {
        q = true;
      } else if (c === delim) {
        row.push(cell); cell = '';
      } else if (c === '\n') {
        row.push(cell); rows.push(row); row = []; cell = '';
      } else cell += c;
    }
    if (cell || row.length) { row.push(cell); rows.push(row); }
    return rows;
  }

  var EMOJI = /[\u{1F000}-\u{1FAFF}\u{2600}-\u{27BF}\u{FE0F}\u{200D}\u{2B50}\u{2B06}\u{2194}-\u{21AA}]/gu;

  function cleanCell(t) {
    return (t || '').replace(EMOJI, '').replace(/[ \t]+\n/g, '\n').replace(/\n{3,}/g, '\n\n').trim();
  }

  function stripQuotes(t) {
    return t.replace(/^["“”]+|["“”]+$/g, '').trim();
  }

  /** Chuyển bảng thành danh sách cảnh: cột A = tên cảnh, cột B = lời thoại, cột C = hình ảnh / chữ trên màn hình. */
  function tableToScenes(rows) {
    var scenes = [];
    // Bỏ các cột trống ở đầu bảng
    var skip = Infinity;
    rows.forEach(function (r) {
      for (var i = 0; i < r.length; i++) if (cleanCell(r[i])) { skip = Math.min(skip, i); break; }
    });
    if (!isFinite(skip)) return scenes;
    rows.forEach(function (r) {
      var cells = r.slice(skip).map(cleanCell);
      var filled = cells.filter(Boolean);
      if (!filled.length) return;
      var title = cells[0] || '', text = cells[1] || '', note = cells[2] || '';
      if (filled.length === 1 && title.length > 80) { text = title; title = ''; }
      // Bỏ dòng tiêu đề bảng
      if (!scenes.length && text.length < 30 && /lời|thoại|nội dung|kịch bản/i.test(text)) return;
      var bigText = [], shotNote = '';
      if (note) {
        var lines = note.split('\n').map(function (x) { return x.trim(); }).filter(Boolean);
        if (/^(text|chữ)/i.test(lines[0])) {
          bigText = lines.slice(1).map(stripQuotes);
          if (!bigText.length) bigText = [lines[0].replace(/^[^:]*:\s*/, '')];
        } else {
          shotNote = note.replace(/^(hình ảnh|cảnh quay|b-roll)\s*:\s*/i, '');
        }
      }
      scenes.push({ title: title || 'Cảnh ' + (scenes.length + 1), text: stripQuotes(text), bigText: bigText, shotNote: shotNote });
    });
    return scenes;
  }

  /** Lấy mã bảng tính từ đường link Google Sheets. */
  function sheetCsvUrl(link) {
    var m = (link || '').match(/\/spreadsheets\/d\/([a-zA-Z0-9_-]+)/);
    if (!m) return '';
    var gid = (link.match(/[#&?]gid=(\d+)/) || [])[1];
    return 'https://docs.google.com/spreadsheets/d/' + m[1] + '/gviz/tq?tqx=out:csv' + (gid ? '&gid=' + gid : '');
  }

  /** Ước lượng thời gian đọc (giây) cho một câu tiếng Việt, khoảng 3 tiếng/giây. */
  function readSeconds(text) {
    var words = (text || '').trim().split(/\s+/).filter(Boolean).length;
    return Math.max(2.5, Math.min(9, words / 3.2 + 0.8));
  }

  window.ScriptGen = {
    STYLES: STYLES, generate: generate, readSeconds: readSeconds,
    generateProject: generateProject, parseTable: parseTable, tableToScenes: tableToScenes, sheetCsvUrl: sheetCsvUrl
  };
})();
