/* Dựng dòng thời gian từ các cảnh: video đầy đủ, trailer, hoặc từng cảnh riêng. */
(function () {
  'use strict';

  var IMG_SECONDS = 3;      // thời lượng mặc định cho một ảnh
  var INTRO_SECONDS = 4;    // thời gian hiện khung giới thiệu dự án ở đầu video
  var END_SECONDS = 4.2;    // thời lượng khung kêu gọi liên hệ ở cuối

  function words(t) { return (t || '').trim().split(/\s+/).filter(Boolean).length; }

  /** Thời gian đọc ước tính (giây), không giới hạn trên. */
  function readSeconds(text) {
    var n = words(text);
    return n ? n / 3.2 + 0.8 : 0;
  }

  var PACE = 'auto';

  /** Tốc độ phát của clip theo cài đặt nhịp (tự động / nhanh / giữ nguyên). */
  function speedOf(m) {
    if (!m || !m.isVideo || PACE === 'off') return 1;
    var sp = m.speed || 1;
    if (PACE === 'fast') sp = Math.max(sp, 1) * 1.1;
    return Math.max(0.85, Math.min(1.4, sp));
  }

  /** Độ dài nguồn (giây trong video gốc). */
  function srcLenOf(m, autoTrim) {
    if (!m.isVideo) return IMG_SECONDS;
    if (m.fixed) return Math.max(0.2, m.trimOut - m.trimIn);
    var a = autoTrim ? (m.trimIn || 0) : 0;
    var full = m.dur || (isFinite(m.el.duration) ? m.el.duration : 0) || 4;
    var b = autoTrim && m.trimOut ? m.trimOut : full;
    return Math.max(0.5, b - a);
  }

  /** Độ dài trên video thành phẩm (đã tính tốc độ phát). */
  function naturalLen(m, autoTrim) {
    if (!m.isVideo) return IMG_SECONDS;
    return srcLenOf(m, autoTrim) / speedOf(m);
  }

  function srcIn(m, autoTrim) { return m.isVideo && (autoTrim || m.fixed) ? (m.trimIn || 0) : 0; }

  /** Chia lời thoại thành từng chữ, rải đều theo các khoảng đang nói (chữ dài được nhiều thời gian hơn). */
  function distributeWords(text, ranges) {
    var ws = (text || '').replace(/[“”"]/g, '').split(/\s+/).filter(Boolean);
    var total = 0;
    ranges.forEach(function (r) { total += Math.max(0, r[1] - r[0]); });
    if (!ws.length || total <= 0) return [];
    var weights = ws.map(function (w) { return w.length + 3 + (/[.,!?…]$/.test(w) ? 4 : 0); });
    var sum = weights.reduce(function (a, b) { return a + b; }, 0);
    function at(pos) { // vị trí 0..total → thời điểm trên dòng thời gian
      for (var i = 0; i < ranges.length; i++) {
        var len = ranges[i][1] - ranges[i][0];
        if (pos <= len || i === ranges.length - 1) return ranges[i][0] + Math.min(pos, len);
        pos -= len;
      }
      return 0;
    }
    var acc = 0;
    return ws.map(function (w, i) {
      var a = acc / sum * total;
      acc += weights[i];
      return { w: w, t0: at(a), t1: at(acc / sum * total) };
    });
  }

  var MONEY = /\d|tỷ|triệu|%|m²|m2/i;

  /** Thời điểm từng chữ của một cảnh: lấy từ nhận dạng giọng nói nếu có, không thì rải đều lời thoại. */
  function sceneWords(scene, speech, ranges) {
    var have = speech.length && speech.every(function (x) { return x.m.words && x.m.words.length; });
    if (!have) return distributeWords(scene.text, ranges);
    var out = [];
    speech.forEach(function (x) {
      x.m.words.forEach(function (w) {
        var sp = x.speed || 1;
        if (w.t0 < x.srcIn - 0.05 || w.t0 >= x.srcIn + x.len * sp) return;
        out.push({ w: w.w, t0: x.start + Math.max(0, (w.t0 - x.srcIn) / sp), t1: x.start + Math.min(x.len, (w.t1 - x.srcIn) / sp) });
      });
    });
    return out;
  }

  function kenBurns(i) {
    var seed = (i * 9301 + 49297) % 233280 / 233280;
    var zoomIn = i % 2 === 0;
    return {
      s0: zoomIn ? 1.0 : 1.16, s1: zoomIn ? 1.16 : 1.0,
      x0: (seed - 0.5) * 1.2, x1: (0.5 - seed) * 1.2,
      y0: zoomIn ? -0.3 : 0.3, y1: zoomIn ? 0.3 : -0.3
    };
  }

  /** Bỏ phần đánh số "CẢNH 2 –" và biểu tượng ở tên cảnh. */
  function cleanTitle(t) {
    return (t || '').replace(/^[^\wÀ-ỹ]*/u, '').replace(/^cảnh\s*\d+\s*[–\-:.]\s*/iu, '').trim();
  }

  function firstSentence(text, maxWords) {
    var s = (text || '').replace(/\s+/g, ' ').trim();
    var m = s.match(/^.+?[.?!…](\s|$)/);
    s = (m ? m[0] : s).trim();
    var w = s.split(' ');
    if (w.length > maxWords) s = w.slice(0, maxWords).join(' ') + '…';
    return s;
  }

  function headline(scene) {
    if (scene.bigText && scene.bigText.length) return scene.bigText[0];
    var t = cleanTitle(scene.title);
    if (t) return t.toUpperCase();
    return firstSentence(scene.text, 7);
  }

  /** Zoom đẩy xen kẽ cho các đoạn cắt nhảy của cùng một video. */
  function zoomOf(m) { return m.segIndex % 2 ? 1.14 : 1.0; }

  function lastMedia(scenes) {
    for (var i = scenes.length - 1; i >= 0; i--) {
      var m = scenes[i].media;
      if (m && m.length) return m[m.length - 1];
    }
    return null;
  }

  function firstMedia(scenes) {
    for (var i = 0; i < scenes.length; i++) if (scenes[i].media && scenes[i].media.length) return scenes[i].media[0];
    return null;
  }

  /** Độ dài cảnh và cách chia các cảnh quay bên trong. */
  function planScene(scene, opts) {
    var media = scene.media || [];
    var voice = opts.voiceMode === 'record' && scene.voice ? scene.voice.buffer : null;
    var isTalk = function (m) { return m.isVideo && m.keepAudio && m.hasAudio; };
    var talking = opts.voiceMode === 'clip' && media.some(isTalk);
    var nat = media.map(function (m) { return naturalLen(m, opts.autoTrim); });
    var D, shares;
    // Clip nói + phối cảnh/flycam: tiếng nói chạy liên tục, phối cảnh phủ lên từng đoạn
    var cover = talking && !voice && !scene.durOverride && scene.layout !== 'seq' && media.some(function (m) { return !isTalk(m); });
    if (cover) {
      var base = media.filter(isTalk), broll = media.filter(function (m) { return !isTalk(m); });
      var baseLen = base.map(function (m) { return naturalLen(m, opts.autoTrim); });
      D = baseLen.reduce(function (a, b) { return a + b; }, 0);
      return { D: D, voice: null, talking: true, cover: true, base: base, baseLen: baseLen, broll: broll };
    }
    if (scene.durOverride) D = scene.durOverride;
    else if (voice) D = voice.duration + 0.5;
    else if (talking) D = nat.reduce(function (a, b) { return a + b; }, 0);
    else if (!media.length && opts.hasTalk) {
      // Video có người nói nhưng cảnh này không có hình: rút thành thẻ chữ ngắn, không kéo dài theo lời thoại
      D = Math.min(5, Math.max(3, (scene.bigText || []).length * 1.2 + 1.6));
      return { D: D, shares: [], voice: null, talking: false, card: true };
    }
    else {
      D = Math.max(readSeconds(scene.text), (scene.bigText || []).length * 1.1 + 1.8, media.length * 2.2, 2.5);
    }
    if (talking && !scene.durOverride && !voice) shares = nat;
    else if (media.length) {
      // Chia theo tỉ lệ độ dài gốc để clip dài được nhiều thời gian hơn
      var sum = nat.reduce(function (a, b) { return a + b; }, 0);
      shares = nat.map(function (n) { return D * n / sum; });
    } else shares = [];
    return { D: D, shares: shares, voice: voice, talking: talking };
  }

  function addEnd(tl, project, t) {
    var m = lastMedia(project.scenes);
    tl.items.push({ start: t, duration: END_SECONDS, el: m ? m.el : null, isVideo: m ? m.isVideo : false,
      srcIn: m ? srcIn(m, project.settings.autoTrim) : 0, srcLen: m ? srcLenOf(m, project.settings.autoTrim) : 1,
      audio: false, trans: 'scene', kb: kenBurns(0), blur: true });
    tl.overlays.push({ start: t, duration: END_SECONDS, kind: 'end' });
    if (project.settings.sfx) tl.sfx.push({ type: 'ting', at: t + 0.65, freq: 1046.5 });
    return t + END_SECONDS;
  }

  /** Video đầy đủ (hoặc chỉ một số cảnh). */
  function buildFull(project, only) {
    var s = project.settings;
    PACE = s.pace || 'auto';
    var opts = {
      voiceMode: project.voiceMode, autoTrim: s.autoTrim,
      hasTalk: project.voiceMode === 'clip' && project.scenes.some(function (sc) {
        return (sc.media || []).some(function (m) { return m.isVideo && m.keepAudio && m.hasAudio; });
      })
    };
    var tl = { items: [], covers: [], overlays: [], voices: [], sfx: [], kind: 'full', total: 0 };
    var t = 0, n = 0;
    project.scenes.forEach(function (scene, si) {
      if (only != null && only !== si) return;
      var p = planScene(scene, opts);
      var withIntro = s.introCard && n === 0 && only == null;
      if (withIntro && p.D < INTRO_SECONDS + 1.5 && !scene.durOverride) p.D = INTRO_SECONDS + 1.5;
      var media = scene.media || [];
      var speech = [];
      if (!media.length) {
        tl.items.push({ start: t, duration: p.D, el: null, isVideo: false, srcIn: 0, srcLen: 1, audio: false,
          trans: n ? 'scene' : 'none', kb: kenBurns(si) });
      } else if (p.cover) {
        var tb = t;
        p.base.forEach(function (m, mi) {
          var jump = mi > 0 && m.group && m.group === p.base[mi - 1].group;
          var it = { start: tb, duration: p.baseLen[mi], el: m.el, isVideo: true, srcIn: srcIn(m, s.autoTrim),
            srcLen: srcLenOf(m, s.autoTrim), speed: speedOf(m), audio: true, gain: m.voiceGain || 1, hidden: !!m.audioOnly,
            trans: mi === 0 ? (n ? 'scene' : 'none') : (jump ? 'jump' : 'cut'), kb: kenBurns(si), zoom: m.group ? zoomOf(m) : 1 };
          tl.items.push(it);
          speech.push({ start: tb, len: p.baseLen[mi], srcIn: it.srcIn, m: m, speed: it.speed });
          if (jump && it.zoom > 1 && s.sfx && !m.audioOnly) tl.sfx.push({ type: 'swish', at: tb - 0.04 });
          tb += p.baseLen[mi];
        });
        // Mở đầu và kết thúc cảnh bằng mặt người nói; phần giữa xen phối cảnh/flycam
        // Clip "chỉ lấy tiếng": phối cảnh/flycam phủ kín toàn bộ cảnh
        var fill = p.base.every(function (m) { return m.audioOnly; });
        var head = fill ? 0 : Math.min(2.2, p.D * 0.2), tail = fill ? 0 : Math.min(1.6, p.D * 0.15);
        if (withIntro && !fill) head = Math.max(head, Math.min(INTRO_SECONDS, p.D * 0.4));
        var mid = p.D - head - tail, seg = mid / p.broll.length;
        p.broll.forEach(function (m, bi) {
          var len = fill ? seg : Math.max(1.2, Math.min(seg * 0.72, m.isVideo ? Math.max(1.2, naturalLen(m, s.autoTrim)) : 5));
          len = Math.min(len, seg);
          if (len < 0.6) return;
          tl.covers.push({ start: t + head + bi * seg + (seg - len) / 2, duration: len, el: m.el, isVideo: m.isVideo,
            srcIn: srcIn(m, s.autoTrim), srcLen: srcLenOf(m, s.autoTrim), audio: false, kb: kenBurns(si * 7 + bi + 1) });
        });
      } else {
        var tt = t;
        var scale = p.D / p.shares.reduce(function (a, b) { return a + b; }, 0);
        media.forEach(function (m, mi) {
          var d = p.shares[mi] * scale;
          var jump = mi > 0 && m.group && m.group === media[mi - 1].group;
          var it = { start: tt, duration: d, el: m.el, isVideo: m.isVideo, srcIn: srcIn(m, s.autoTrim),
            srcLen: srcLenOf(m, s.autoTrim), speed: speedOf(m), audio: p.talking && m.isVideo && m.keepAudio && m.hasAudio,
            gain: m.voiceGain || 1, hidden: !!(m.audioOnly && p.talking && m.keepAudio),
            trans: mi === 0 ? (n ? 'scene' : 'none') : (jump ? 'jump' : 'cut'), kb: kenBurns(si * 7 + mi), zoom: m.group ? zoomOf(m) : 1 };
          tl.items.push(it);
          if (it.audio) speech.push({ start: tt, len: d, srcIn: it.srcIn, m: m, speed: it.speed });
          if (jump && it.zoom > 1 && s.sfx) tl.sfx.push({ type: 'swish', at: tt - 0.04 });
          tt += d;
        });
      }
      // Thời điểm từng chữ cho phụ đề kiểu TikTok
      var ranges = speech.length ? speech.map(function (x) { return [x.start, x.start + x.len]; }) :
        p.voice ? [[t + 0.15, t + 0.15 + p.voice.duration]] :
        [[t + (withIntro ? INTRO_SECONDS : 0) + 0.2, t + p.D - 0.3]];
      var words = sceneWords(scene, speech, ranges);
      if (p.card) { words = []; }
      tl.overlays.push({ start: t, duration: p.D, kind: 'scene', text: p.card ? '' : scene.text,
        bigText: p.card && !(scene.bigText || []).length ? [firstSentence(scene.text, 7) || headline(scene)] : (scene.bigText || []),
        intro: withIntro, caption: scene.showTitle ? cleanTitle(scene.title) : '', words: words });
      if (s.sfx && s.subtitles && (s.subStyle || 'kinetic') === 'kinetic') {
        kineticStacks(words).forEach(function (st) {
          if (st.big.length) tl.sfx.push({ type: /\d|tỷ|triệu/i.test(st.big.map(function (w) { return w.w; }).join(' ')) ? 'ching' : 'slam', at: st.bigAt });
        });
      } else if (s.sfx && s.subStyle !== 'box' && s.subtitles) {
        var lastChing = -9;
        words.forEach(function (w, wi) {
          var next = words[wi + 1] ? words[wi + 1].w : '';
          if (/\d/.test(w.w) && MONEY.test(w.w + ' ' + next) && w.t0 - lastChing > 2.5) {
            tl.sfx.push({ type: /tỷ|triệu|đ/i.test(w.w + ' ' + next) ? 'ching' : 'pop', at: w.t0 });
            lastChing = w.t0;
          }
        });
      }
      if (p.voice) tl.voices.push({ buffer: p.voice, at: t + 0.15 });
      if (s.sfx) {
        if (n === 0) tl.sfx.push({ type: 'boom', at: 0.05 });
        if (withIntro && project.info.gia) tl.sfx.push({ type: 'ting', at: 1.15 });
        if (n > 0) tl.sfx.push({ type: 'whoosh', at: t - 0.6 });
        var bt0 = withIntro ? INTRO_SECONDS : 0;
        (scene.bigText || []).forEach(function (_, li) {
          tl.sfx.push({ type: s.textFx === 'marker' ? 'swipe' : 'pop', at: t + bt0 + 0.25 + li * 0.5 });
        });
      }
      t += p.D;
      n++;
    });
    if (!n) {
      // Chưa có cảnh nào: hiện khung giới thiệu để xem trước thông tin
      tl.items.push({ start: 0, duration: INTRO_SECONDS + 1, el: null, isVideo: false, srcIn: 0, srcLen: 1, audio: false, trans: 'none', kb: kenBurns(0) });
      tl.overlays.push({ start: 0, duration: INTRO_SECONDS + 1, kind: 'scene', intro: true, bigText: [] });
      t = INTRO_SECONDS + 1;
    }
    if (n && (s.endStyle || 'pill') === 'pill' && s.endCard) {
      tl.pill = { start: Math.max(0, t - 3.5), end: t };
      if (s.sfx) tl.sfx.push({ type: 'ting', at: Math.max(0, t - 3.5) + 0.1, freq: 1046.5 });
    } else if (s.endCard && n) {
      if (s.sfx) { tl.sfx.push({ type: 'riser', at: t - 1.6, dur: 1.5 }); tl.sfx.push({ type: 'whoosh', at: t - 0.6 }); }
      t = addEnd(tl, project, t);
    }
    tl.total = Math.max(t, 0.5);
    return tl;
  }

  /** Trailer: cắt nhanh 1,7 giây mỗi cảnh, chữ to, nhạc sôi động, không lời. */
  function buildTrailer(project) {
    var s = project.settings;
    PACE = s.pace || 'auto';
    var tl = { items: [], covers: [], overlays: [], voices: [], sfx: [], kind: 'trailer', total: 0 };
    var t = 0;
    var SHOT = 1.7;
    var first = firstMedia(project.scenes);
    var hook = project.scenes[0] ? firstSentence(project.scenes[0].text, 12) : '';
    if (!hook) hook = (project.info.ten || project.info.loai || '').toUpperCase();
    function push(m, d, trans, ov, idx) {
      tl.items.push({ start: t, duration: d, el: m ? m.el : null, isVideo: m ? m.isVideo : false,
        srcIn: m ? srcIn(m, s.autoTrim) + (m.isVideo ? srcLenOf(m, s.autoTrim) * 0.3 : 0) : 0,
        srcLen: m ? Math.max(0.5, srcLenOf(m, s.autoTrim) * 0.7) : 1, audio: false, trans: trans, kb: kenBurns(idx) });
      ov.start = t;
      ov.duration = d;
      tl.overlays.push(ov);
      if (s.sfx && t > 0) tl.sfx.push({ type: 'whoosh', at: t - 0.35 });
      t += d;
    }
    push(first, 2.8, 'none', { kind: 'hook', bigText: [hook] }, 0);
    if (s.sfx) tl.sfx.push({ type: 'boom', at: 0.05 });
    project.scenes.forEach(function (scene, si) {
      if (si === 0 && project.scenes.length > 1) return; // cảnh mở đầu đã dùng làm câu hook
      // Ưu tiên phối cảnh/flycam (không phải clip đang nói), rồi tới clip video
      var rank = function (m) { return (m.isVideo && m.keepAudio && m.hasAudio ? 0 : 2) + (m.isVideo ? 1 : 0); };
      var media = (scene.media || []).slice().sort(function (a, b) { return rank(b) - rank(a); });
      if (!media.length && !(scene.bigText || []).length) return;
      push(media[0] || null, SHOT, 'cut', { kind: 'scene', bigText: [headline(scene)], fast: true }, si + 1);
      if (s.sfx) tl.sfx.push({ type: 'pop', at: t - SHOT + 0.1 });
    });
    t = addEnd(tl, project, t);
    tl.total = t;
    return tl;
  }

  /* ---------- Chữ động xếp tầng (kiểu video mẫu) ---------- */

  var PARTICLE = /^(nhé|nha|ạ|à|ơi|luôn|đâu|đó|nào|thôi|nhỉ|vậy|rồi)[.,!?…]*$/i;
  var ACCENT = /^(hot|nhất|trở thành|chỉ|ngay|đặc biệt|siêu|cực|top|duy nhất)$/i;
  var CONNECT = /^(mà|nhưng|thì|và|nếu|để|vì|nên|còn|hay|hoặc|khi)$/i;
  // Từ ghép hay gặp: giữ nguyên cụm khi chọn từ khoá (VD: "biệt thự", "lâu dài")
  var COMPOUND = ('biệt thự|căn hộ|nhà phố|đất nền|shop house|dự án|chủ đầu tư|đầu tư|sở hữu|lâu dài|tài sản|thịnh vượng|không nên|bỏ lỡ|anh chị|' +
    'lúc này|đẳng cấp|sang trọng|tinh hoa|tôn quý|tiện ích|vị trí|pháp lý|thanh toán|nhận nhà|hồ bơi|ban công|phòng khách|phòng ngủ|' +
    'sân vườn|view biển|mặt tiền|giao điểm|cộng đồng|đô thị|tâm điểm|cư dân|trở thành|sinh lời|cho thuê|giá trị|tăng giá|hiếm có|duy nhất|' +
    'chính sách|ưu đãi|chiết khấu|hỗ trợ|lãi suất|quỹ căn|liên hệ|nhanh tay|số lượng|giới hạn|đặc biệt|tuyệt vời|hoàn hảo|đáng sống|nghỉ dưỡng|' +
    'an cư|bàn giao|sổ hồng|sổ đỏ|bất động sản|đà nẵng|hà nội|sài gòn|hồ chí minh|blanca city|sun group|hòa xuân|nam đà nẵng').split('|');

  function bare(w) { return w.w.replace(/[.,!?…:;“”"]/g, '').toLowerCase(); }

  /** Gom các chữ thành cụm (từ ghép đi liền nhau). */
  function units(ws) {
    var out = [];
    for (var i = 0; i < ws.length;) {
      var took = 1;
      for (var n = 3; n >= 2; n--) {
        if (i + n > ws.length) continue;
        var joined = ws.slice(i, i + n).map(bare).join(' ');
        if (COMPOUND.indexOf(joined) !== -1) { took = n; break; }
      }
      out.push(ws.slice(i, i + took));
      i += took;
    }
    return out;
  }

  /**
   * Gom chữ đã nói thành từng "tầng chữ": chữ dẫn nhỏ + từ khoá rất to (+ chữ đuôi nhỏ).
   * VD: "biệt thự / BIỂN", "sở hữu / LÂU DÀI", "mà anh chị / KHÔNG NÊN / bỏ lỡ!".
   */
  function kineticStacks(words) {
    if (!words || !words.length) return [];
    if (words._stacks) return words._stacks;
    var uAll = units(words), groups = [], cur = [], cnt = 0;
    var txt = function (u) { return u.map(bare).join(' '); };
    // Số chữ còn lại tới hết câu (tính từ mỗi cụm)
    var toEnd = [], acc = 0;
    for (var k = uAll.length - 1; k >= 0; k--) {
      var uu = uAll[k], nx = uAll[k + 1];
      if (!nx || /[.,!?…:;]$/.test(uu[uu.length - 1].w) || nx[0].t0 - uu[uu.length - 1].t1 > 0.5) acc = 0;
      acc += uu.length;
      toEnd[k] = acc;
    }
    uAll.forEach(function (u, ui) {
      var lastU = cur[cur.length - 1], last = lastU ? lastU[lastU.length - 1] : null;
      var brk = cur.length && (cnt + u.length > 8 || /[.,!?…:;]$/.test(last.w) || u[0].t0 - last.t1 > 0.5 ||
        (cnt >= 2 && CONNECT.test(txt(u))) || (cnt >= 3 && cnt + u.length > 4 && toEnd[ui] > 4));
      if (brk) { groups.push(cur); cur = []; cnt = 0; }
      cur.push(u);
      cnt += u.length;
    });
    if (cur.length) groups.push(cur);
    // Gộp cụm quá ngắn (người nói nhanh) để mỗi tầng chữ đứng đủ lâu cho người xem kịp đọc
    var merged = [];
    groups.forEach(function (g) {
      var prev = merged[merged.length - 1];
      if (prev) {
        var pw = [].concat.apply([], prev), gw = [].concat.apply([], g);
        var short = pw[pw.length - 1].t1 - pw[0].t0 < 0.9;
        var endSentence = /[.!?…]$/.test(pw[pw.length - 1].w);
        if (short && !endSentence && pw.length + gw.length <= 8) { prev.push.apply(prev, g); return; }
      }
      merged.push(g.slice());
    });
    groups = merged;
    var out = groups.map(function (us, gi) {
      us = us.slice();
      us.forEach(function (u) { var acc = ACCENT.test(txt(u)); u.forEach(function (w) { w.accent = acc; }); });
      var trail = [];
      // Chữ đệm cuối (nhé, nha…) để nhỏ ở dòng đuôi
      while (us.length > 1 && us[us.length - 1].length === 1 && PARTICLE.test(us[us.length - 1][0].w)) trail = us.pop().concat(trail);
      // Câu cảm thán: cụm cuối làm đuôi, cụm kế cuối làm từ khoá ("KHÔNG NÊN / bỏ lỡ!")
      if (us.length >= 3 && /!$/.test(us[us.length - 1][us[us.length - 1].length - 1].w) && us[us.length - 1].length === 2) trail = us.pop().concat(trail);
      var bigIdx = us.length - 1;
      // Có con số thì lấy số (+ đơn vị) làm từ khoá
      for (var i = 0; i < us.length; i++) if (/\d/.test(us[i][0].w)) { bigIdx = i; break; }
      var big = us[bigIdx].slice();
      if (/\d/.test(big[0].w) && us[bigIdx + 1] && us[bigIdx + 1].length === 1 && /^(tỷ|triệu|tầng|phút|căn|m2|m²|%|năm|km)/i.test(bare(us[bigIdx + 1][0]))) {
        big = big.concat(us[bigIdx + 1]);
        us.splice(bigIdx + 1, 1);
      }
      big.forEach(function (w) { w.accent = false; });
      var lead = [].concat.apply([], us.slice(0, bigIdx));
      trail = [].concat.apply([], us.slice(bigIdx + 1)).concat(trail);
      return { lead: lead, big: big, trail: trail, idx: gi, t0: (lead[0] || big[0]).t0 };
    });
    // Chữ hiện sớm hơn tiếng nói một chút để mắt kịp theo lời
    var LEAD = 0.15;
    out.forEach(function (st) { st.t0 -= LEAD; });
    out.forEach(function (st, i) {
      var all = st.lead.concat(st.big, st.trail);
      var next = out[i + 1];
      st.bigAt = (st.big.length ? st.big[0].t0 : st.t0) - LEAD;
      st.lead0 = LEAD;
      st.t1 = next ? Math.min(next.t0, Math.max(all[all.length - 1].t1 + 0.9, st.t0 + 1)) : all[all.length - 1].t1 + 0.8;
    });
    words._stacks = out;
    return out;
  }

  window.BdsTimeline = {
    kineticStacks: kineticStacks,
    IMG_SECONDS: IMG_SECONDS, INTRO_SECONDS: INTRO_SECONDS, END_SECONDS: END_SECONDS,
    readSeconds: readSeconds, cleanTitle: cleanTitle, headline: headline, distributeWords: distributeWords,
    buildFull: buildFull, buildTrailer: buildTrailer,
    buildScene: function (project, i) { return buildFull(project, i); }
  };
})();
