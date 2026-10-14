/* Vẽ từng khung hình video lên canvas: Ken Burns, chuyển cảnh, khung giá, phụ đề, intro/outro. */
(function () {
  'use strict';

  var FORMATS = {
    '9:16': { w: 1080, h: 1920, label: 'Dọc 9:16 (TikTok, Reels, Shorts)' },
    '16:9': { w: 1920, h: 1080, label: 'Ngang 16:9 (YouTube, Facebook)' },
    '1:1': { w: 1080, h: 1080, label: 'Vuông 1:1 (Facebook, Zalo)' }
  };

  var THEMES = {
    'vang': { label: 'Vàng sang trọng', main: '#E0A526', dark: '#14110B', text: '#FFFFFF' },
    'xanh': { label: 'Xanh hiện đại', main: '#1F8FFF', dark: '#081726', text: '#FFFFFF' },
    'do': { label: 'Đỏ nổi bật', main: '#E5312F', dark: '#1A0909', text: '#FFFFFF' },
    'la': { label: 'Xanh lá tự nhiên', main: '#2DBE73', dark: '#08190F', text: '#FFFFFF' }
  };

  var TRANSITIONS = {
    'fade': 'Mờ dần',
    'slide': 'Trượt ngang',
    'zoom': 'Phóng to',
    'mix': 'Kết hợp ngẫu nhiên'
  };

  var TR = 0.7; // thời gian chuyển cảnh (giây)
  var FONT = '"Be Vietnam Pro", "Segoe UI", Roboto, Arial, sans-serif';

  function clamp(v, a, b) { return Math.max(a, Math.min(b, v)); }
  function easeOut(t) { t = clamp(t, 0, 1); return 1 - Math.pow(1 - t, 3); }
  function easeInOut(t) { t = clamp(t, 0, 1); return t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2; }
  function easeBack(t) {
    t = clamp(t, 0, 1);
    var c1 = 1.70158, c3 = c1 + 1;
    return 1 + c3 * Math.pow(t - 1, 3) + c1 * Math.pow(t - 1, 2);
  }

  function hexA(hex, a) {
    var n = parseInt(hex.slice(1), 16);
    return 'rgba(' + (n >> 16 & 255) + ',' + (n >> 8 & 255) + ',' + (n & 255) + ',' + a + ')';
  }

  function roundRect(ctx, x, y, w, h, r) {
    r = Math.min(r, h / 2, w / 2);
    ctx.beginPath();
    ctx.moveTo(x + r, y);
    ctx.arcTo(x + w, y, x + w, y + h, r);
    ctx.arcTo(x + w, y + h, x, y + h, r);
    ctx.arcTo(x, y + h, x, y, r);
    ctx.arcTo(x, y, x + w, y, r);
    ctx.closePath();
  }

  function wrapText(ctx, text, maxW) {
    var words = (text || '').split(/\s+/).filter(Boolean);
    var lines = [];
    var cur = '';
    words.forEach(function (w) {
      var test = cur ? cur + ' ' + w : w;
      if (ctx.measureText(test).width > maxW && cur) {
        lines.push(cur);
        cur = w;
      } else {
        cur = test;
      }
    });
    if (cur) lines.push(cur);
    return lines;
  }

  function mediaSize(m) {
    if (!m) return { w: 1, h: 1 };
    if (m.videoWidth) return { w: m.videoWidth, h: m.videoHeight };
    return { w: m.naturalWidth || m.width || 1, h: m.naturalHeight || m.height || 1 };
  }

  /** Vẽ ảnh phủ kín khung với tỉ lệ phóng và độ lệch (Ken Burns). */
  function drawCover(ctx, m, W, H, scale, dx, dy) {
    var s = mediaSize(m);
    var base = Math.max(W / s.w, H / s.h) * scale;
    var w = s.w * base, h = s.h * base;
    var x = (W - w) / 2 + dx * (w - W) / 2;
    var y = (H - h) / 2 + dy * (h - H) / 2;
    try { ctx.drawImage(m, x, y, w, h); } catch (e) { /* video chưa sẵn sàng */ }
  }

  /**
   * Dựng dòng thời gian từ dự án.
   * project: { info, media:[{el, caption, isVideo}], lines:[], durations:[], settings }
   */
  function buildTimeline(project) {
    var media = project.media;
    var lines = project.lines;
    var scenes = [];
    var n = media.length;
    for (var i = 0; i < n + 2; i++) {
      var type = i === 0 ? 'intro' : (i === n + 1 ? 'outro' : 'media');
      var m = type === 'intro' ? media[0] : (type === 'outro' ? media[n - 1] : media[i - 1]);
      var dur = project.durations[i] || window.ScriptGen.readSeconds(lines[i]);
      if (type === 'media' && m && m.isVideo && m.el.duration && !project.durationsLocked) {
        dur = Math.max(dur, Math.min(m.el.duration, 12));
      }
      var seed = (i * 9301 + 49297) % 233280 / 233280;
      var zoomIn = i % 2 === 0;
      scenes.push({
        type: type,
        media: m ? m.el : null,
        isVideo: m ? !!m.isVideo : false,
        caption: m && type === 'media' ? m.caption : '',
        text: lines[i] || '',
        duration: dur,
        kb: {
          s0: zoomIn ? 1.0 : 1.18, s1: zoomIn ? 1.18 : 1.0,
          x0: (seed - 0.5) * 1.2, x1: (0.5 - seed) * 1.2,
          y0: zoomIn ? -0.3 : 0.3, y1: zoomIn ? 0.3 : -0.3
        },
        transition: pickTransition(project.settings.transition, i)
      });
    }
    var t = 0;
    scenes.forEach(function (s) { s.start = t; t += s.duration; });
    return { scenes: scenes, total: t };
  }

  function pickTransition(setting, i) {
    if (setting !== 'mix') return setting || 'fade';
    return ['zoom', 'slide', 'fade', 'slide'][i % 4];
  }

  function Renderer(canvas, project) {
    this.canvas = canvas;
    this.ctx = canvas.getContext('2d');
    this.project = project;
    var f = FORMATS[project.settings.format] || FORMATS['9:16'];
    canvas.width = f.w;
    canvas.height = f.h;
    this.W = f.w;
    this.H = f.h;
    this.unit = Math.min(f.w, f.h) / 1080; // tỉ lệ cỡ chữ
    this.theme = THEMES[project.settings.theme] || THEMES.vang;
    this.timeline = buildTimeline(project);
  }

  Renderer.prototype.sceneAt = function (t) {
    var sc = this.timeline.scenes;
    for (var i = 0; i < sc.length; i++) {
      if (t < sc[i].start + sc[i].duration) return i;
    }
    return sc.length - 1;
  };

  /** Đồng bộ clip video với thời gian (chạy, dừng, tua). */
  Renderer.prototype.syncVideos = function (t, playing) {
    var sc = this.timeline.scenes;
    for (var i = 0; i < sc.length; i++) {
      var s = sc[i];
      if (!s.isVideo || !s.media) continue;
      var v = s.media;
      var active = t >= s.start - TR && t < s.start + s.duration;
      var owner = this._videoOwner(v, t);
      if (owner !== i) continue;
      if (active) {
        var local = Math.max(0, t - s.start);
        var target = v.duration ? local % v.duration : local;
        if (!playing) {
          if (Math.abs(v.currentTime - target) > 0.05) v.currentTime = target;
          if (!v.paused) v.pause();
        } else {
          if (v.paused) {
            v.currentTime = target;
            var p = v.play();
            if (p && p.catch) p.catch(function () {});
          } else if (Math.abs(v.currentTime - target) > 0.35) {
            v.currentTime = target;
          }
        }
      } else if (!v.paused) {
        v.pause();
      }
    }
  };

  // Một clip có thể dùng cho intro/outro lẫn cảnh chính; ưu tiên cảnh đang hiển thị.
  Renderer.prototype._videoOwner = function (v, t) {
    var sc = this.timeline.scenes;
    var best = -1;
    for (var i = 0; i < sc.length; i++) {
      if (sc[i].media !== v) continue;
      if (t >= sc[i].start - TR && t < sc[i].start + sc[i].duration) return i;
      if (best === -1) best = i;
    }
    return best;
  };

  Renderer.prototype.drawBackground = function (s, local) {
    var ctx = this.ctx, W = this.W, H = this.H;
    var p = clamp((local + TR) / (s.duration + TR), 0, 1);
    var e = easeInOut(p);
    if (s.media) {
      var scale = s.kb.s0 + (s.kb.s1 - s.kb.s0) * e;
      var dx = s.kb.x0 + (s.kb.x1 - s.kb.x0) * e;
      var dy = s.kb.y0 + (s.kb.y1 - s.kb.y0) * e;
      if (s.isVideo) { scale = 1.02 + 0.04 * e; dx = 0; dy = 0; }
      if (s.type === 'outro') {
        ctx.save();
        ctx.filter = 'blur(' + Math.round(18 * this.unit) + 'px)';
        drawCover(ctx, s.media, W, H, 1.15 + 0.05 * e, 0, 0);
        ctx.restore();
      } else {
        drawCover(ctx, s.media, W, H, scale, dx, dy);
      }
    } else {
      var g = ctx.createLinearGradient(0, 0, W, H);
      g.addColorStop(0, '#1d2433');
      g.addColorStop(1, this.theme.dark);
      ctx.fillStyle = g;
      ctx.fillRect(0, 0, W, H);
    }
  };

  Renderer.prototype.drawScene = function (i, local, alpha) {
    var s = this.timeline.scenes[i];
    var ctx = this.ctx;
    ctx.save();
    ctx.globalAlpha = alpha;
    this.drawBackground(s, local);
    ctx.restore();
  };

  Renderer.prototype.drawOverlay = function (i, local, alpha) {
    var s = this.timeline.scenes[i];
    if (alpha <= 0.01) return;
    var ctx = this.ctx;
    ctx.save();
    ctx.globalAlpha = alpha;
    if (s.type === 'intro') this.drawIntro(s, local);
    else if (s.type === 'outro') this.drawOutro(s, local);
    else this.drawMediaOverlay(s, local);
    ctx.restore();
  };

  Renderer.prototype.drawFrame = function (t) {
    var ctx = this.ctx, W = this.W, H = this.H;
    var sc = this.timeline.scenes;
    t = clamp(t, 0, this.timeline.total - 0.001);
    var i = this.sceneAt(t);
    var s = sc[i];
    var local = t - s.start;
    ctx.fillStyle = '#000';
    ctx.fillRect(0, 0, W, H);

    var next = sc[i + 1];
    var k = next ? (t - (s.start + s.duration - TR)) / TR : -1;
    if (k > 0 && next) {
      var e = easeInOut(k);
      var nLocal = t - next.start; // âm trong lúc chuyển cảnh
      var tr = next.transition;
      if (tr === 'slide') {
        ctx.save();
        ctx.translate(-W * e, 0);
        this.drawScene(i, local, 1);
        ctx.restore();
        ctx.save();
        ctx.translate(W * (1 - e), 0);
        this.drawScene(i + 1, nLocal, 1);
        ctx.restore();
      } else if (tr === 'zoom') {
        ctx.save();
        ctx.translate(W / 2, H / 2);
        ctx.scale(1 + e * 0.35, 1 + e * 0.35);
        ctx.translate(-W / 2, -H / 2);
        this.drawScene(i, local, 1);
        ctx.restore();
        ctx.save();
        ctx.translate(W / 2, H / 2);
        var z = 1.25 - 0.25 * e;
        ctx.scale(z, z);
        ctx.translate(-W / 2, -H / 2);
        this.drawScene(i + 1, nLocal, e);
        ctx.restore();
      } else {
        this.drawScene(i, local, 1);
        this.drawScene(i + 1, nLocal, e);
      }
      // Ánh sáng loé nhẹ giữa chuyển cảnh
      var flash = Math.max(0, 1 - Math.abs(k - 0.5) * 4) * 0.18;
      if (flash > 0) {
        ctx.fillStyle = 'rgba(255,255,255,' + flash + ')';
        ctx.fillRect(0, 0, W, H);
      }
      this.drawShade();
      this.drawOverlay(i, local, 1 - clamp(k * 2, 0, 1));
      this.drawOverlay(i + 1, nLocal + TR, clamp(k * 2 - 1, 0, 1));
    } else {
      this.drawScene(i, local, 1);
      this.drawShade();
      this.drawOverlay(i, local + (i === 0 ? 0 : TR), 1);
    }
    this.drawBrand(t);
    this.drawProgress(t);
  };

  Renderer.prototype.drawShade = function () {
    var ctx = this.ctx, W = this.W, H = this.H;
    var g = ctx.createLinearGradient(0, 0, 0, H);
    g.addColorStop(0, 'rgba(0,0,0,0.45)');
    g.addColorStop(0.18, 'rgba(0,0,0,0)');
    g.addColorStop(0.62, 'rgba(0,0,0,0)');
    g.addColorStop(1, 'rgba(0,0,0,0.7)');
    ctx.fillStyle = g;
    ctx.fillRect(0, 0, W, H);
  };

  Renderer.prototype.drawBrand = function (t) {
    var ctx = this.ctx, u = this.unit, info = this.project.info;
    var logo = this.project.logo;
    var pad = 48 * u;
    var x = pad, y = pad;
    ctx.save();
    ctx.globalAlpha = clamp(t / 0.6, 0, 1);
    if (logo) {
      var s = mediaSize(logo);
      var lh = 90 * u, lw = lh * s.w / s.h;
      if (lw > 320 * u) { lw = 320 * u; lh = lw * s.h / s.w; }
      ctx.drawImage(logo, x, y, lw, lh);
    } else if (info.moiGioi || info.thuongHieu) {
      var label = (info.thuongHieu || info.moiGioi).toUpperCase();
      ctx.font = '700 ' + Math.round(30 * u) + 'px ' + FONT;
      var w = ctx.measureText(label).width + 56 * u;
      roundRect(ctx, x, y, w, 64 * u, 32 * u);
      ctx.fillStyle = 'rgba(0,0,0,0.45)';
      ctx.fill();
      ctx.fillStyle = this.theme.main;
      ctx.beginPath();
      ctx.arc(x + 28 * u, y + 32 * u, 8 * u, 0, Math.PI * 2);
      ctx.fill();
      ctx.fillStyle = '#fff';
      ctx.textBaseline = 'middle';
      ctx.fillText(label, x + 44 * u, y + 33 * u);
    }
    ctx.restore();
  };

  Renderer.prototype.drawProgress = function (t) {
    var ctx = this.ctx;
    var p = clamp(t / this.timeline.total, 0, 1);
    ctx.fillStyle = 'rgba(255,255,255,0.18)';
    ctx.fillRect(0, 0, this.W, 6 * this.unit);
    ctx.fillStyle = this.theme.main;
    ctx.fillRect(0, 0, this.W * p, 6 * this.unit);
  };

  Renderer.prototype.drawPriceTag = function (alpha, y) {
    var ctx = this.ctx, u = this.unit, info = this.project.info;
    if (!info.gia) return;
    ctx.save();
    ctx.globalAlpha *= alpha;
    ctx.font = '800 ' + Math.round(40 * u) + 'px ' + FONT;
    ctx.textBaseline = 'middle';
    var label = info.gia;
    var w = ctx.measureText(label).width + 60 * u;
    var x = this.W - w - 48 * u;
    roundRect(ctx, x, y, w, 76 * u, 16 * u);
    ctx.fillStyle = this.theme.main;
    ctx.fill();
    ctx.fillStyle = '#111';
    ctx.fillText(label, x + 30 * u, y + 40 * u);
    ctx.restore();
  };

  Renderer.prototype.drawSubtitle = function (text, local, duration) {
    if (!text || !this.project.settings.subtitles) return;
    var ctx = this.ctx, W = this.W, H = this.H, u = this.unit;
    var size = Math.round((this.W > this.H ? 46 : 52) * u);
    ctx.font = '700 ' + size + 'px ' + FONT;
    var maxW = W - 140 * u;
    var lines = wrapText(ctx, text, maxW - 60 * u);
    // Chia phụ đề dài thành từng đoạn 2 dòng, đổi đoạn theo thời gian
    // Tối đa 3 dòng một lúc; câu dài thì chia đều để không còn sót một chữ lẻ
    var per = lines.length <= 3 ? 3 : Math.ceil(lines.length / Math.ceil(lines.length / 3));
    var chunks = [];
    for (var i = 0; i < lines.length; i += per) chunks.push(lines.slice(i, i + per));
    var ci = Math.min(chunks.length - 1, Math.floor(clamp(local / duration, 0, 0.999) * chunks.length));
    var chunk = chunks[ci] || [];
    if (!chunk.length) return;
    var lh = size * 1.32;
    var boxH = lh * chunk.length + 40 * u;
    var widest = 0;
    chunk.forEach(function (l) { widest = Math.max(widest, ctx.measureText(l).width); });
    var boxW = widest + 64 * u;
    var x = (W - boxW) / 2;
    var y = H - boxH - (W > H ? 70 : 230) * u;
    var appear = easeOut(local / 0.35);
    ctx.save();
    ctx.globalAlpha *= appear;
    ctx.translate(0, (1 - appear) * 20 * u);
    roundRect(ctx, x, y, boxW, boxH, 18 * u);
    ctx.fillStyle = 'rgba(0,0,0,0.62)';
    ctx.fill();
    ctx.fillStyle = '#fff';
    ctx.textAlign = 'center';
    ctx.textBaseline = 'top';
    chunk.forEach(function (l, j) {
      ctx.fillText(l, W / 2, y + 20 * u + j * lh + 4 * u);
    });
    ctx.restore();
  };

  Renderer.prototype.drawMediaOverlay = function (s, local) {
    var ctx = this.ctx, u = this.unit;
    this.drawPriceTag(1, 48 * u);
    if (s.caption) {
      var a = easeBack(local / 0.5);
      ctx.save();
      ctx.font = '800 ' + Math.round(44 * u) + 'px ' + FONT;
      ctx.textBaseline = 'middle';
      var label = s.caption.toUpperCase();
      var w = ctx.measureText(label).width + 70 * u;
      var x = -w + (48 * u + w) * a;
      var y = this.H * (this.W > this.H ? 0.22 : 0.16);
      roundRect(ctx, x, y, w, 84 * u, 12 * u);
      ctx.fillStyle = 'rgba(255,255,255,0.94)';
      ctx.fill();
      ctx.fillStyle = this.theme.main;
      ctx.fillRect(x, y, 12 * u, 84 * u);
      ctx.fillStyle = '#111';
      ctx.fillText(label, x + 38 * u, y + 44 * u);
      ctx.restore();
    }
    this.drawSubtitle(s.text, local, s.duration + TR);
  };

  Renderer.prototype.drawIntro = function (s, local) {
    var ctx = this.ctx, W = this.W, H = this.H, u = this.unit, info = this.project.info;
    var th = this.theme;
    var land = W > H;
    var cx = land ? 110 * u : 70 * u;
    var maxW = W - cx * 2;
    var baseY = land ? H * 0.42 : H * 0.5;

    // Nền tối phía dưới để chữ rõ
    var g = ctx.createLinearGradient(0, baseY - 200 * u, 0, H);
    g.addColorStop(0, 'rgba(0,0,0,0)');
    g.addColorStop(0.35, hexA(th.dark, 0.75));
    g.addColorStop(1, hexA(th.dark, 0.95));
    ctx.fillStyle = g;
    ctx.fillRect(0, baseY - 200 * u, W, H);

    ctx.textBaseline = 'top';
    ctx.textAlign = 'left';
    var y = baseY;
    // Loại BĐS
    var a1 = easeOut((local - 0.2) / 0.5);
    ctx.save();
    ctx.globalAlpha *= a1;
    ctx.font = '700 ' + Math.round(34 * u) + 'px ' + FONT;
    var tag = (info.loai || 'BẤT ĐỘNG SẢN').toUpperCase();
    var tw = ctx.measureText(tag).width + 48 * u;
    roundRect(ctx, cx - (1 - a1) * 40 * u, y, tw, 62 * u, 31 * u);
    ctx.fillStyle = th.main;
    ctx.fill();
    ctx.fillStyle = '#111';
    ctx.fillText(tag, cx + 24 * u - (1 - a1) * 40 * u, y + 14 * u);
    ctx.restore();
    y += 92 * u;

    // Tên dự án
    var a2 = easeOut((local - 0.45) / 0.6);
    ctx.save();
    ctx.globalAlpha *= a2;
    var titleSize = Math.round((land ? 92 : 96) * u);
    ctx.font = '800 ' + titleSize + 'px ' + FONT;
    var title = info.ten || info.loai || 'Bất động sản';
    var tl = wrapText(ctx, title, maxW).slice(0, 2);
    if (tl.length === 2 && ctx.measureText(tl[1]).width > maxW) tl[1] = tl[1].slice(0, 20) + '…';
    ctx.fillStyle = '#fff';
    ctx.shadowColor = 'rgba(0,0,0,0.5)';
    ctx.shadowBlur = 20 * u;
    tl.forEach(function (l, j) { ctx.fillText(l, cx, y + j * titleSize * 1.12 + (1 - a2) * 30 * u); });
    ctx.restore();
    y += tl.length * titleSize * 1.12 + 18 * u;

    // Vị trí
    if (info.viTri) {
      var a3 = easeOut((local - 0.75) / 0.6);
      ctx.save();
      ctx.globalAlpha *= a3;
      ctx.font = '500 ' + Math.round(40 * u) + 'px ' + FONT;
      ctx.fillStyle = 'rgba(255,255,255,0.9)';
      this.drawPin(cx + 14 * u, y + 22 * u, 16 * u);
      var vl = wrapText(ctx, info.viTri, maxW - 50 * u).slice(0, 2);
      vl.forEach(function (l, j) { ctx.fillText(l, cx + 50 * u, y + j * 52 * u); });
      ctx.restore();
      y += vl.length * 52 * u + 36 * u;
    }

    // Giá — bật lên
    if (info.gia) {
      var a4 = easeBack((local - 1.1) / 0.5);
      if (a4 > 0) {
        ctx.save();
        ctx.font = '900 ' + Math.round(78 * u) + 'px ' + FONT;
        var pl = 'GIÁ: ' + info.gia;
        var pw = ctx.measureText(pl).width + 70 * u;
        ctx.translate(cx, y);
        ctx.scale(a4, a4);
        roundRect(ctx, 0, 0, pw, 118 * u, 20 * u);
        ctx.fillStyle = th.main;
        ctx.shadowColor = hexA(th.main, 0.6);
        ctx.shadowBlur = 40 * u;
        ctx.fill();
        ctx.shadowBlur = 0;
        ctx.fillStyle = '#111';
        ctx.fillText(pl, 35 * u, 18 * u);
        ctx.restore();
      }
      y += 150 * u;
    }

    // Thông số
    var specs = [];
    if (info.dienTich) specs.push(info.dienTich);
    if (info.phongNgu) specs.push(info.phongNgu + ' PN');
    if (info.wc) specs.push(info.wc + ' WC');
    if (info.phapLy) specs.push(info.phapLy);
    ctx.font = '600 ' + Math.round(34 * u) + 'px ' + FONT;
    var sx = cx;
    var sy = y;
    var self = this;
    specs.forEach(function (sp, j) {
      var a = easeOut((local - 1.5 - j * 0.15) / 0.4);
      if (a <= 0) return;
      var w = ctx.measureText(sp).width + 44 * u;
      if (sx + w > W - cx) { sx = cx; sy += 76 * u; }
      ctx.save();
      ctx.globalAlpha *= a;
      roundRect(ctx, sx, sy + (1 - a) * 20 * u, w, 60 * u, 14 * u);
      ctx.fillStyle = 'rgba(255,255,255,0.14)';
      ctx.fill();
      ctx.strokeStyle = hexA(self.theme.main, 0.9);
      ctx.lineWidth = 2 * u;
      ctx.stroke();
      ctx.fillStyle = '#fff';
      ctx.fillText(sp, sx + 22 * u, sy + 13 * u + (1 - a) * 20 * u);
      ctx.restore();
      sx += w + 16 * u;
    });

    // Phụ đề cho câu mở đầu (nằm trên cùng để không đè nội dung)
    if (s.text && this.project.settings.subtitles && local > 0.3) {
      ctx.save();
      ctx.font = '600 ' + Math.round(38 * u) + 'px ' + FONT;
      var hl = wrapText(ctx, s.text, W - 200 * u).slice(0, 3);
      var hh = hl.length * 50 * u + 36 * u;
      var hy = land ? 140 * u : 170 * u;
      ctx.globalAlpha *= easeOut((local - 0.3) / 0.4);
      roundRect(ctx, 70 * u, hy, W - 140 * u, hh, 18 * u);
      ctx.fillStyle = 'rgba(0,0,0,0.55)';
      ctx.fill();
      ctx.fillStyle = '#fff';
      ctx.textAlign = 'center';
      hl.forEach(function (l, j) { ctx.fillText(l, W / 2, hy + 20 * u + j * 50 * u); });
      ctx.restore();
    }
  };

  Renderer.prototype.drawPin = function (x, y, r) {
    var ctx = this.ctx;
    ctx.save();
    ctx.fillStyle = this.theme.main;
    ctx.beginPath();
    ctx.arc(x, y - r * 0.4, r, Math.PI, 0);
    ctx.lineTo(x, y + r * 1.4);
    ctx.closePath();
    ctx.fill();
    ctx.fillStyle = '#111';
    ctx.beginPath();
    ctx.arc(x, y - r * 0.4, r * 0.4, 0, Math.PI * 2);
    ctx.fill();
    ctx.restore();
  };

  Renderer.prototype.drawOutro = function (s, local) {
    var ctx = this.ctx, W = this.W, H = this.H, u = this.unit, info = this.project.info;
    var th = this.theme;
    ctx.fillStyle = hexA(th.dark, 0.72);
    ctx.fillRect(0, 0, W, H);
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    var cy = H * (W > H ? 0.36 : 0.38);

    var a1 = easeOut((local - 0.1) / 0.5);
    ctx.save();
    ctx.globalAlpha *= a1;
    ctx.font = '800 ' + Math.round(56 * u) + 'px ' + FONT;
    ctx.fillStyle = th.main;
    ctx.fillText('LIÊN HỆ XEM NHÀ NGAY', W / 2, cy - (1 - a1) * 30 * u);
    ctx.restore();

    if (info.moiGioi) {
      var a2 = easeOut((local - 0.35) / 0.5);
      ctx.save();
      ctx.globalAlpha *= a2;
      ctx.font = '700 ' + Math.round(60 * u) + 'px ' + FONT;
      ctx.fillStyle = '#fff';
      ctx.fillText(info.moiGioi, W / 2, cy + 110 * u);
      ctx.restore();
    }

    if (info.sdt) {
      var a3 = easeBack((local - 0.6) / 0.5);
      if (a3 > 0) {
        var pulse = 1 + Math.sin(local * 6) * 0.03 * clamp(local - 1.1, 0, 1);
        ctx.save();
        ctx.translate(W / 2, cy + 280 * u);
        ctx.scale(a3 * pulse, a3 * pulse);
        ctx.font = '900 ' + Math.round(96 * u) + 'px ' + FONT;
        var pw = ctx.measureText(info.sdt).width + 180 * u;
        roundRect(ctx, -pw / 2, -82 * u, pw, 164 * u, 82 * u);
        ctx.fillStyle = th.main;
        ctx.shadowColor = hexA(th.main, 0.7);
        ctx.shadowBlur = 50 * u;
        ctx.fill();
        ctx.shadowBlur = 0;
        this.drawPhoneIcon(-pw / 2 + 80 * u, 0, 30 * u);
        ctx.fillStyle = '#111';
        ctx.fillText(info.sdt, 35 * u, 6 * u);
        ctx.restore();
      }
      var a4 = easeOut((local - 1.0) / 0.5);
      ctx.save();
      ctx.globalAlpha *= a4;
      ctx.font = '600 ' + Math.round(40 * u) + 'px ' + FONT;
      ctx.fillStyle = 'rgba(255,255,255,0.85)';
      ctx.fillText('Gọi điện hoặc nhắn Zalo', W / 2, cy + 430 * u);
      ctx.restore();
    }
    if (s.text && this.project.settings.subtitles) this.drawSubtitle(s.text, local, s.duration + TR);
  };

  Renderer.prototype.drawPhoneIcon = function (x, y, r) {
    var ctx = this.ctx;
    ctx.save();
    ctx.fillStyle = '#111';
    ctx.beginPath();
    ctx.arc(x, y, r * 1.3, 0, Math.PI * 2);
    ctx.fill();
    ctx.strokeStyle = this.theme.main;
    ctx.lineWidth = r * 0.42;
    ctx.lineCap = 'round';
    ctx.beginPath();
    ctx.arc(x, y, r * 0.62, Math.PI * 0.62, Math.PI * 1.38);
    ctx.stroke();
    ctx.restore();
  };

  window.BdsRender = {
    FORMATS: FORMATS, THEMES: THEMES, TRANSITIONS: TRANSITIONS, TR: TR,
    Renderer: Renderer, buildTimeline: buildTimeline
  };
})();
