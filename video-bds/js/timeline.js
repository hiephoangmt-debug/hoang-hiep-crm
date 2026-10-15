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

  function naturalLen(m, autoTrim) {
    if (!m.isVideo) return IMG_SECONDS;
    if (m.fixed) return Math.max(0.2, m.trimOut - m.trimIn); // đoạn đã cắt sẵn từ video dài
    var a = autoTrim ? (m.trimIn || 0) : 0;
    var full = m.dur || (isFinite(m.el.duration) ? m.el.duration : 0) || 4;
    var b = autoTrim && m.trimOut ? m.trimOut : full;
    return Math.max(0.5, b - a);
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
        if (w.t0 < x.srcIn - 0.05 || w.t0 >= x.srcIn + x.len) return;
        out.push({ w: w.w, t0: x.start + Math.max(0, w.t0 - x.srcIn), t1: x.start + Math.min(x.len, w.t1 - x.srcIn) });
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
      srcIn: m ? srcIn(m, project.settings.autoTrim) : 0, srcLen: m ? naturalLen(m, project.settings.autoTrim) : 1,
      audio: false, trans: 'scene', kb: kenBurns(0), blur: true });
    tl.overlays.push({ start: t, duration: END_SECONDS, kind: 'end' });
    if (project.settings.sfx) tl.sfx.push({ type: 'ting', at: t + 0.65, freq: 1046.5 });
    return t + END_SECONDS;
  }

  /** Video đầy đủ (hoặc chỉ một số cảnh). */
  function buildFull(project, only) {
    var s = project.settings;
    var opts = { voiceMode: project.voiceMode, autoTrim: s.autoTrim };
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
            srcLen: p.baseLen[mi], audio: true, gain: m.voiceGain || 1, hidden: !!m.audioOnly,
            trans: mi === 0 ? (n ? 'scene' : 'none') : (jump ? 'jump' : 'cut'), kb: kenBurns(si), zoom: m.group ? zoomOf(m) : 1 };
          tl.items.push(it);
          speech.push({ start: tb, len: p.baseLen[mi], srcIn: it.srcIn, m: m });
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
            srcIn: srcIn(m, s.autoTrim), srcLen: naturalLen(m, s.autoTrim), audio: false, kb: kenBurns(si * 7 + bi + 1) });
        });
      } else {
        var tt = t;
        var scale = p.D / p.shares.reduce(function (a, b) { return a + b; }, 0);
        media.forEach(function (m, mi) {
          var d = p.shares[mi] * scale;
          var jump = mi > 0 && m.group && m.group === media[mi - 1].group;
          var it = { start: tt, duration: d, el: m.el, isVideo: m.isVideo, srcIn: srcIn(m, s.autoTrim),
            srcLen: naturalLen(m, s.autoTrim), audio: p.talking && m.isVideo && m.keepAudio && m.hasAudio,
            gain: m.voiceGain || 1, hidden: !!(m.audioOnly && p.talking && m.keepAudio),
            trans: mi === 0 ? (n ? 'scene' : 'none') : (jump ? 'jump' : 'cut'), kb: kenBurns(si * 7 + mi), zoom: m.group ? zoomOf(m) : 1 };
          tl.items.push(it);
          if (it.audio) speech.push({ start: tt, len: d, srcIn: it.srcIn, m: m });
          if (jump && it.zoom > 1 && s.sfx) tl.sfx.push({ type: 'swish', at: tt - 0.04 });
          tt += d;
        });
      }
      // Thời điểm từng chữ cho phụ đề kiểu TikTok
      var ranges = speech.length ? speech.map(function (x) { return [x.start, x.start + x.len]; }) :
        p.voice ? [[t + 0.15, t + 0.15 + p.voice.duration]] :
        [[t + (withIntro ? INTRO_SECONDS : 0) + 0.2, t + p.D - 0.3]];
      var words = sceneWords(scene, speech, ranges);
      tl.overlays.push({ start: t, duration: p.D, kind: 'scene', text: scene.text, bigText: scene.bigText || [],
        intro: withIntro, caption: scene.showTitle ? cleanTitle(scene.title) : '', words: words });
      if (s.sfx && s.subStyle !== 'box' && s.subtitles) {
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
    if (s.endCard && n) {
      if (s.sfx) { tl.sfx.push({ type: 'riser', at: t - 1.6, dur: 1.5 }); tl.sfx.push({ type: 'whoosh', at: t - 0.6 }); }
      t = addEnd(tl, project, t);
    }
    tl.total = Math.max(t, 0.5);
    return tl;
  }

  /** Trailer: cắt nhanh 1,7 giây mỗi cảnh, chữ to, nhạc sôi động, không lời. */
  function buildTrailer(project) {
    var s = project.settings;
    var tl = { items: [], covers: [], overlays: [], voices: [], sfx: [], kind: 'trailer', total: 0 };
    var t = 0;
    var SHOT = 1.7;
    var first = firstMedia(project.scenes);
    var hook = project.scenes[0] ? firstSentence(project.scenes[0].text, 12) : '';
    if (!hook) hook = (project.info.ten || project.info.loai || '').toUpperCase();
    function push(m, d, trans, ov, idx) {
      tl.items.push({ start: t, duration: d, el: m ? m.el : null, isVideo: m ? m.isVideo : false,
        srcIn: m ? srcIn(m, s.autoTrim) + (m.isVideo ? naturalLen(m, s.autoTrim) * 0.3 : 0) : 0,
        srcLen: m ? Math.max(0.5, naturalLen(m, s.autoTrim) * 0.7) : 1, audio: false, trans: trans, kb: kenBurns(idx) });
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

  window.BdsTimeline = {
    IMG_SECONDS: IMG_SECONDS, INTRO_SECONDS: INTRO_SECONDS, END_SECONDS: END_SECONDS,
    readSeconds: readSeconds, cleanTitle: cleanTitle, headline: headline, distributeWords: distributeWords,
    buildFull: buildFull, buildTrailer: buildTrailer,
    buildScene: function (project, i) { return buildFull(project, i); }
  };
})();
