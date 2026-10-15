/* Vẽ từng khung hình theo dòng thời gian: cảnh quay, chuyển cảnh, chữ hiệu ứng, phụ đề, intro/outro. */
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
    'mix': 'Kết hợp nhiều kiểu (như video mẫu)',
    'split': 'Cắt dải',
    'spin': 'Xoay nghiêng',
    'glitch': 'Nhiễu chấm',
    'fade': 'Mờ dần',
    'slide': 'Trượt ngang',
    'zoom': 'Phóng to'
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

  var TEXT_FX = {
    'marker': 'Bút dạ quang (TikTok)',
    'pop': 'Bật lên',
    'slide': 'Trượt vào',
    'type': 'Gõ từng chữ'
  };

  var CUT = 0.12; // chuyển nhanh giữa các đoạn quay trong cùng một cảnh

  function pickTransition(setting, i) {
    if (setting !== 'mix') return setting || 'fade';
    return ['split', 'zoom', 'spin', 'glitch', 'slide', 'fade'][i % 6];
  }

  /** Chia phụ đề theo câu, mỗi đoạn tối đa 2 dòng; thời gian chia theo số chữ. */
  function subtitleChunks(ctx, text, maxW) {
    var sentences = (text || '').replace(/[“”"]/g, '').split(/\n+|(?<=[.!?…])\s+/).map(function (s) { return s.trim(); }).filter(Boolean);
    var chunks = [];
    sentences.forEach(function (s) {
      var lines = wrapText(ctx, s, maxW);
      for (var i = 0; i < lines.length; i += 2) chunks.push(lines.slice(i, i + 2));
    });
    var total = 0;
    chunks.forEach(function (c) { c.len = c.join(' ').length + 8; total += c.len; });
    var acc = 0;
    chunks.forEach(function (c) { c.from = acc / total; acc += c.len; c.to = acc / total; });
    return chunks;
  }

  function Renderer(canvas, timeline, project) {
    this.canvas = canvas;
    this.ctx = canvas.getContext('2d');
    this.project = project;
    this.timeline = timeline;
    var f = FORMATS[project.settings.format] || FORMATS['9:16'];
    if (canvas.width !== f.w) canvas.width = f.w;
    if (canvas.height !== f.h) canvas.height = f.h;
    this.W = f.w;
    this.H = f.h;
    this.unit = Math.min(f.w, f.h) / 1080;
    this.theme = THEMES[project.settings.theme] || THEMES.vang;
    this._subCache = {};
  }

  function findAt(list, t) {
    for (var i = 0; i < list.length; i++) if (t < list[i].start + list[i].duration) return i;
    return list.length - 1;
  }

  Renderer.prototype.trLen = function (next) {
    if (!next) return 0;
    return next.trans === 'scene' ? TR : (next.trans === 'cut' ? CUT : 0);
  };

  /**
   * Đồng bộ clip video theo thời gian. setGain(el, 0..1) bật/tắt tiếng gốc của clip.
   */
  Renderer.prototype.syncVideos = function (t, playing, setGain) {
    var items = this.timeline.items.concat(this.timeline.covers || []);
    // Mỗi thẻ video: ưu tiên đoạn đang chiếu, sau đó đoạn sắp chiếu (để tua sẵn, tránh giật ở chỗ cắt)
    var owners = new Map();
    for (var i = 0; i < items.length; i++) {
      var it = items[i];
      if (!it.isVideo || !it.el) continue;
      var lead = it.trans === 'jump' ? 0.6 : (it.trans ? Math.max(this.trLen(it), 0.4) : 0.4);
      var rank = t >= it.start && t < it.start + it.duration ? 2 : (t >= it.start - lead && t < it.start ? 1 : 0);
      var cur = owners.get(it.el);
      if (!cur || rank > cur.rank) owners.set(it.el, { item: it, rank: rank });
    }
    owners.forEach(function (o, v) {
      var it = o.item;
      if (setGain) setGain(v, o.rank === 2 && it.audio ? (it.gain || 1) : 0);
      if (o.rank === 0) { if (!v.paused) v.pause(); return; }
      var local = t - it.start;
      if (local < 0) { // sắp chiếu: tua sẵn tới điểm đầu và đứng yên
        if (!v.paused) v.pause();
        if (Math.abs(v.currentTime - it.srcIn) > 0.05 && !v.seeking) v.currentTime = it.srcIn;
        return;
      }
      var sp = it.speed || 1;
      var target = it.srcIn + (it.srcLen > 0 ? (local * sp) % it.srcLen : local * sp);
      if (v.duration) target = Math.min(target, v.duration - 0.05);
      if (v.playbackRate !== sp) { v.preservesPitch = true; v.playbackRate = sp; }
      if (!playing) {
        if (Math.abs(v.currentTime - target) > 0.05) v.currentTime = target;
        if (!v.paused) v.pause();
      } else if (v.paused) {
        if (Math.abs(v.currentTime - target) > 0.08) v.currentTime = target;
        var p = v.play();
        if (p && p.catch) p.catch(function () {});
      } else if (Math.abs(v.currentTime - target) > 0.3) {
        v.currentTime = target;
      }
    });
  };

  Renderer.prototype.stopVideos = function () {
    this.timeline.items.concat(this.timeline.covers || []).forEach(function (it) { if (it.isVideo && it.el && !it.el.paused) it.el.pause(); });
  };

  Renderer.prototype.drawItem = function (it, t, alpha) {
    var ctx = this.ctx, W = this.W, H = this.H;
    ctx.save();
    ctx.globalAlpha = alpha;
    if (it.el && !it.hidden) {
      var p = clamp((t - it.start + TR) / (it.duration + TR), 0, 1);
      var e = easeInOut(p);
      if (it.blur) {
        ctx.filter = 'blur(' + Math.round(18 * this.unit) + 'px)';
        drawCover(ctx, it.el, W, H, 1.15 + 0.05 * e, 0, 0);
      } else if (it.isVideo) {
        // Zoom đẩy ở chỗ cắt nhảy: bật nhanh lên rồi giữ
        var z = it.zoom || 1;
        if (z > 1) z = 1 + (z - 1) * easeOut((t - it.start) / 0.12);
        var lvl = this.project.settings.beauty || 'vua';
        var src = lvl !== 'off' && window.BdsBeauty ? window.BdsBeauty.get().process(it.el, lvl) : it.el;
        drawCover(ctx, src, W, H, z * (1.0 + 0.03 * e), 0, 0);
      } else {
        var k = it.kb;
        drawCover(ctx, it.el, W, H, k.s0 + (k.s1 - k.s0) * e, k.x0 + (k.x1 - k.x0) * e, k.y0 + (k.y1 - k.y0) * e);
      }
    } else {
      // Cảnh chỉ có chữ: nền màu chủ đạo chuyển động nhẹ
      var g = ctx.createLinearGradient(0, 0, W, H);
      g.addColorStop(0, '#1d2433');
      g.addColorStop(1, this.theme.dark);
      ctx.fillStyle = g;
      ctx.fillRect(0, 0, W, H);
      var r = Math.max(W, H) * 0.6;
      var cx = W * (0.3 + 0.4 * Math.sin(t * 0.3)), cy = H * (0.35 + 0.2 * Math.cos(t * 0.25));
      var rg = ctx.createRadialGradient(cx, cy, 0, cx, cy, r);
      rg.addColorStop(0, hexA(this.theme.main, 0.35));
      rg.addColorStop(1, hexA(this.theme.main, 0));
      ctx.fillStyle = rg;
      ctx.fillRect(0, 0, W, H);
    }
    ctx.restore();
  };

  Renderer.prototype.drawBackground = function (t) {
    var ctx = this.ctx, W = this.W, H = this.H;
    var items = this.timeline.items;
    var i = findAt(items, t);
    var it = items[i], next = items[i + 1];
    var tr = this.trLen(next);
    var k = tr ? (t - (it.start + it.duration - tr)) / tr : -1;
    if (k <= 0 || !next) { this.drawItem(it, t, 1); return; }
    var e = easeInOut(k);
    var style = next.trans === 'scene' ? pickTransition(this.project.settings.transition, i) : 'fade';
    if (style === 'slide') {
      ctx.save(); ctx.translate(-W * e, 0); this.drawItem(it, t, 1); ctx.restore();
      ctx.save(); ctx.translate(W * (1 - e), 0); this.drawItem(next, t, 1); ctx.restore();
    } else if (style === 'split') {
      // Hình mới trượt vào theo 4 dải dọc, xen kẽ trên/dưới
      this.drawItem(it, t, 1);
      for (var si = 0; si < 4; si++) {
        var es = easeInOut(clamp((k - si * 0.08) / 0.76, 0, 1));
        ctx.save();
        ctx.beginPath();
        ctx.rect(W * si / 4, 0, W / 4 + 1, H);
        ctx.clip();
        ctx.translate(0, (1 - es) * H * (si % 2 ? 1 : -1));
        this.drawItem(next, t, 1);
        ctx.restore();
      }
    } else if (style === 'spin') {
      ctx.save(); ctx.translate(W / 2, H / 2); ctx.rotate(e * 0.18); ctx.scale(1 + e * 0.3, 1 + e * 0.3); ctx.translate(-W / 2, -H / 2);
      this.drawItem(it, t, 1); ctx.restore();
      ctx.save(); ctx.translate(W / 2, H / 2); ctx.rotate(-(1 - e) * 0.22); var zs = 1.3 - 0.3 * e; ctx.scale(zs, zs); ctx.translate(-W / 2, -H / 2);
      this.drawItem(next, t, e); ctx.restore();
    } else if (style === 'glitch') {
      // Nhiễu: các dải ngang lệch nhau + chấm lưới ở giữa chuyển cảnh
      this.drawItem(k < 0.5 ? it : next, t, 1);
      var seed = Math.floor(k * 14) + 1;
      for (var gb = 0; gb < 9; gb++) {
        var r1 = Math.abs(Math.sin(seed * 12.9898 + gb * 78.233)) % 1, r2 = Math.abs(Math.sin(seed * 4.1414 + gb * 9.71)) % 1;
        var by = r1 * H, bh = H * (0.02 + r2 * 0.07);
        ctx.save(); ctx.beginPath(); ctx.rect(0, by, W, bh); ctx.clip();
        ctx.translate((r2 - 0.5) * W * 0.18, 0);
        this.drawItem(k < 0.5 ? next : it, t, 1);
        ctx.restore();
      }
      var dots = Math.max(0, 1 - Math.abs(k - 0.5) * 3);
      if (dots > 0) {
        var step = 26 * this.unit;
        ctx.fillStyle = 'rgba(0,0,0,' + (0.55 * dots) + ')';
        for (var dy = 0; dy < H; dy += step) for (var dx = 0; dx < W; dx += step) {
          var rr = step * 0.45 * dots * (0.4 + 0.6 * Math.abs(Math.sin(dx * 0.01 + dy * 0.013)));
          ctx.beginPath(); ctx.arc(dx, dy, rr, 0, 6.283); ctx.fill();
        }
      }
    } else if (style === 'zoom') {
      ctx.save(); ctx.translate(W / 2, H / 2); ctx.scale(1 + e * 0.35, 1 + e * 0.35); ctx.translate(-W / 2, -H / 2);
      this.drawItem(it, t, 1); ctx.restore();
      var z = 1.25 - 0.25 * e;
      ctx.save(); ctx.translate(W / 2, H / 2); ctx.scale(z, z); ctx.translate(-W / 2, -H / 2);
      this.drawItem(next, t, e); ctx.restore();
    } else {
      this.drawItem(it, t, 1);
      this.drawItem(next, t, e);
    }
    if (next.trans === 'scene') {
      var flash = Math.max(0, 1 - Math.abs(k - 0.5) * 4) * 0.18;
      if (flash > 0) { ctx.fillStyle = 'rgba(255,255,255,' + flash + ')'; ctx.fillRect(0, 0, W, H); }
    }
  };

  Renderer.prototype.drawFrame = function (t) {
    var ctx = this.ctx;
    t = clamp(t, 0, this.timeline.total - 0.001);
    ctx.fillStyle = '#000';
    ctx.fillRect(0, 0, this.W, this.H);
    this.drawBackground(t);
    this.drawCovers(t);
    this.drawShade();
    var ovs = this.timeline.overlays;
    for (var i = 0; i < ovs.length; i++) {
      var o = ovs[i];
      if (t < o.start - 0.3 || t > o.start + o.duration + 0.3) continue;
      var local = t - o.start;
      var a = clamp(Math.min((local + 0.3) / 0.3, (o.duration - local) / 0.3), 0, 1);
      if (local < 0) a = 0;
      if (a > 0.01) this.drawOverlay(o, local, a);
    }
    if (this.timeline.pill && t >= this.timeline.pill.start) this.drawPill(t - this.timeline.pill.start);
    this.drawBrand(t);
    this.drawProgress(t);
  };

  /** Nút "LIÊN HỆ NGAY" nhỏ ở cuối video (kiểu video mẫu). */
  Renderer.prototype.drawPill = function (local) {
    var ctx = this.ctx, W = this.W, H = this.H, u = this.unit, info = this.project.info;
    var a = easeBack(local / 0.45);
    if (a <= 0) return;
    var pulse = 1 + 0.03 * Math.sin(local * 5) * clamp(local - 0.6, 0, 1);
    ctx.save();
    ctx.font = '800 ' + Math.round(40 * u) + 'px ' + FONT;
    var label = 'LIÊN HỆ NGAY';
    var phone = info.sdt ? '  ' + info.sdt : '';
    var w1 = ctx.measureText(label).width, w2 = phone ? ctx.measureText(phone).width : 0;
    var pw = w1 + w2 + 90 * u, ph = 92 * u;
    var x = W / 2, y = H - (W > H ? 130 : 330) * u;
    ctx.translate(x, y);
    ctx.scale(a * pulse, a * pulse);
    roundRect(ctx, -pw / 2, -ph / 2, pw, ph, ph / 2);
    ctx.fillStyle = 'rgba(15,18,28,0.82)';
    ctx.fill();
    ctx.lineWidth = 3 * u;
    ctx.strokeStyle = 'rgba(255,255,255,0.9)';
    ctx.stroke();
    ctx.textBaseline = 'middle';
    ctx.textAlign = 'left';
    ctx.fillStyle = '#fff';
    ctx.fillText(label, -pw / 2 + 45 * u, 2 * u);
    if (phone) { ctx.fillStyle = this.theme.main; ctx.fillText(phone, -pw / 2 + 45 * u + w1, 2 * u); }
    ctx.restore();
  };

  /** Phối cảnh / flycam phủ lên clip đang nói (tiếng nói vẫn chạy). */
  Renderer.prototype.drawCovers = function (t) {
    var cs = this.timeline.covers || [];
    for (var i = 0; i < cs.length; i++) {
      var c = cs[i];
      if (t < c.start || t > c.start + c.duration) continue;
      var a = clamp(Math.min((t - c.start) / 0.25, (c.start + c.duration - t) / 0.25), 0, 1);
      this.drawItem(c, t, easeInOut(a));
    }
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

  Renderer.prototype.drawOverlay = function (o, local, alpha) {
    var ctx = this.ctx, u = this.unit, s = this.project.settings;
    ctx.save();
    ctx.globalAlpha = alpha;
    if (o.kind === 'end') {
      this.drawOutro(local);
    } else if (o.kind === 'hook') {
      this.drawBigText(o.bigText, local, o.duration, { big: true });
    } else {
      var introEnd = o.intro ? window.BdsTimeline.INTRO_SECONDS : 0;
      if (o.intro && local < introEnd + 0.3) {
        ctx.save();
        ctx.globalAlpha *= clamp((introEnd - local) / 0.4, 0, 1);
        this.drawIntro(local);
        ctx.restore();
      } else if (s.priceTag !== false && this.timeline.kind !== 'trailer') {
        this.drawPriceTag(1, 48 * u);
      }
      if (o.caption) this.drawCaption(o.caption, local);
      var bl = local - introEnd;
      if (o.bigText && o.bigText.length && bl > 0) {
        this.drawBigText(o.bigText, bl, o.duration - introEnd, { fast: o.fast });
      }
      var style = s.subStyle || 'kinetic';
      if (s.subtitles && style === 'kinetic' && o.words && o.words.length) {
        if (!o.intro || local > introEnd) this.drawKinetic(o.words, o.start + local);
      } else if (s.subtitles && style !== 'box' && o.words && o.words.length) {
        if (!o.intro || local > introEnd) this.drawWordCaptions(o.words, o.start + local);
      } else if (o.text && s.subtitles && local > introEnd) {
        this.drawSubtitle(o.text, local - introEnd, o.duration - introEnd);
      }
    }
    ctx.restore();
  };

  Renderer.prototype.drawCaption = function (caption, local) {
    var ctx = this.ctx, u = this.unit;
    var a = easeBack(local / 0.5);
    ctx.save();
    ctx.font = '800 ' + Math.round(44 * u) + 'px ' + FONT;
    ctx.textBaseline = 'middle';
    var label = caption.toUpperCase();
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
  };

  /** Chữ lớn hiệu ứng: từng dòng xuất hiện lần lượt; dòng có con số được tô màu chủ đạo. */
  Renderer.prototype.drawBigText = function (lines, local, duration, opt) {
    opt = opt || {};
    var ctx = this.ctx, W = this.W, H = this.H, u = this.unit;
    var fx = this.project.settings.textFx || 'pop';
    var maxW = W - 150 * u;
    var size = Math.round((opt.big ? 92 : 84) * u);
    ctx.font = '900 ' + size + 'px ' + FONT;
    var rows = [];
    lines.forEach(function (l) { wrapText(ctx, String(l).toUpperCase(), maxW - 70 * u).forEach(function (r, j) { rows.push({ t: r, src: l, first: j === 0 }); }); });
    var widest = 0;
    rows.forEach(function (r) { widest = Math.max(widest, ctx.measureText(r.t).width); });
    if (widest > maxW - 70 * u) size = Math.floor(size * (maxW - 70 * u) / widest);
    size = Math.max(Math.round(40 * u), size);
    ctx.font = '900 ' + size + 'px ' + FONT;
    var bh = size * 1.42, gap = 16 * u;
    var totalH = rows.length * bh + (rows.length - 1) * gap;
    var y0 = (opt.big ? H * 0.5 : H * (W > H ? 0.48 : 0.44)) - totalH / 2;
    var step = opt.fast ? 0.18 : 0.5, delay = opt.fast ? 0.05 : 0.25;
    var li = -1;
    var theme = this.theme;
    rows.forEach(function (r, i) {
      if (r.first) li++;
      var t0 = delay + li * step + (r.first ? 0 : 0.08);
      var p = (local - t0) / (opt.fast ? 0.25 : 0.4);
      if (p <= 0) return;
      var hasNum = /\d/.test(r.src);
      var w = ctx.measureText(r.t).width + 70 * u;
      var x = (W - w) / 2, y = y0 + i * (bh + gap);
      var text = r.t;
      ctx.save();
      if (fx === 'slide') {
        var e = easeOut(p);
        ctx.globalAlpha *= clamp(p * 2, 0, 1);
        ctx.translate((1 - e) * (i % 2 ? W : -W) * 0.6, 0);
      } else if (fx === 'marker') {
        // Vệt bút dạ quang chạy từ trái sang phải, chữ trắng viền đen đổi sang chữ đen trên nền màu
        var mk = easeOut(p * 0.9);
        var fs = size;
        ctx.globalAlpha *= clamp(p * 4, 0, 1);
        ctx.textBaseline = 'middle';
        ctx.textAlign = 'left';
        ctx.font = '900 ' + fs + 'px ' + FONT;
        var tx = x + 35 * u, ty = y + bh / 2 + 3 * u;
        ctx.save();
        ctx.translate(0, (1 - easeOut(p * 2)) * 18 * u);
        ctx.beginPath();
        ctx.moveTo(x, y + bh * 0.12);
        ctx.lineTo(x + w * mk + 18 * u, y + bh * 0.04);
        ctx.lineTo(x + w * mk, y + bh * 0.96);
        ctx.lineTo(x - 8 * u, y + bh * 0.9);
        ctx.closePath();
        ctx.fillStyle = theme.main;
        ctx.fill();
        ctx.lineJoin = 'round';
        ctx.lineWidth = fs * 0.14;
        ctx.strokeStyle = 'rgba(0,0,0,0.85)';
        ctx.strokeText(text, tx, ty);
        ctx.fillStyle = '#fff';
        ctx.fillText(text, tx, ty);
        ctx.save();
        ctx.beginPath();
        ctx.rect(x - 10 * u, y, w * mk + 10 * u, bh);
        ctx.clip();
        ctx.fillStyle = theme.main;
        ctx.fillRect(x - 10 * u, y, w * mk + 10 * u, bh);
        ctx.fillStyle = '#111';
        ctx.fillText(text, tx, ty);
        ctx.restore();
        ctx.restore();
        ctx.restore();
        return;
      } else if (fx === 'type') {
        var n = Math.floor((local - t0) * 30);
        text = r.t.slice(0, Math.max(1, n));
      } else {
        var sc = easeBack(p);
        ctx.translate(W / 2, y + bh / 2);
        ctx.scale(sc, sc);
        ctx.translate(-W / 2, -(y + bh / 2));
        ctx.globalAlpha *= clamp(p * 3, 0, 1);
      }
      roundRect(ctx, x, y, w, bh, 16 * u);
      ctx.fillStyle = hasNum ? theme.main : 'rgba(10,12,18,0.78)';
      ctx.shadowColor = 'rgba(0,0,0,0.35)';
      ctx.shadowBlur = 24 * u;
      ctx.fill();
      ctx.shadowBlur = 0;
      if (!hasNum) { ctx.fillStyle = theme.main; ctx.fillRect(x, y, 10 * u, bh); }
      ctx.fillStyle = hasNum ? '#111' : '#fff';
      ctx.textBaseline = 'middle';
      ctx.textAlign = 'left';
      ctx.fillText(text, x + 35 * u, y + bh / 2 + 3 * u);
      ctx.restore();
    });
  };

  /** Gom chữ thành từng cụm ngắn (tối đa 3 chữ) để hiện kiểu TikTok. */
  function phrasesOf(words) {
    if (words._phr) return words._phr;
    var out = [], cur = [];
    var chars = function (a) { return a.reduce(function (n, w) { return n + w.w.length + 1; }, 0); };
    words.forEach(function (w) {
      var last = cur[cur.length - 1];
      if (cur.length && (cur.length >= 3 || chars(cur) + w.w.length > 16 || /[.,!?…:;]$/.test(last.w) || w.t0 - last.t1 > 0.6)) {
        out.push(cur);
        cur = [];
      }
      cur.push(w);
    });
    if (cur.length) out.push(cur);
    out.forEach(function (ph, i) {
      ph.t0 = ph[0].t0;
      var next = out[i + 1];
      ph.t1 = next ? Math.min(next[0].t0, ph[ph.length - 1].t1 + 0.6) : ph[ph.length - 1].t1 + 0.5;
    });
    words._phr = out;
    return out;
  }

  // Màu chuyển sắc cho từ khoá (giống video mẫu: xanh mint, đỏ đô, xanh navy, hồng tím, vàng)
  var KINETIC_FILLS = [['#bff3e6', '#3e9e8e'], ['#d24a5a', '#5a0f1c'], ['#6f9de8', '#132c66'], ['#f58cc0', '#7b4fd6'], ['#ffe9a6', '#d99a1e']];

  /** Ảnh phối cảnh đầu tiên trong dự án (để tô vào chữ to, như chữ "BIỂN" trong video mẫu). */
  Renderer.prototype.textureImage = function () {
    if (this._tex !== undefined) return this._tex;
    this._tex = null;
    var scenes = this.project.scenes || [];
    for (var i = 0; i < scenes.length && !this._tex; i++) {
      (scenes[i].media || []).forEach(function (m) { if (!this._tex && !m.isVideo && m.el && m.el.naturalWidth) this._tex = m.el; }, this);
    }
    return this._tex;
  };

  /**
   * Chữ động xếp tầng: chữ dẫn nhỏ hiện dần theo lời nói, từ khoá rất to tô màu chuyển sắc đập vào,
   * chữ nhấn in nghiêng màu đỏ. Tầng chữ đặt xen kẽ trên/dưới để không che mặt người nói.
   */
  Renderer.prototype.drawKinetic = function (words, t) {
    // Thanh chỉnh "chữ hiện sớm / muộn" (giây): số dương = chữ hiện sớm hơn
    t += (this.project.settings.textShift || 0);
    var stacks = window.BdsTimeline.kineticStacks(words);
    var st = null;
    for (var i = 0; i < stacks.length; i++) if (t >= stacks[i].t0 - 0.05 && t < stacks[i].t1) { st = stacks[i]; break; }
    if (!st) return;
    var ctx = this.ctx, W = this.W, H = this.H, u = this.unit;
    var land = W > H;
    var maxW = W - 120 * u;
    var smallSize = Math.round((land ? 50 : 60) * u);
    var smallFont = function (w) { return (w.accent ? 'italic 800 ' + Math.round(smallSize * 1.12) : '600 ' + smallSize) + 'px ' + FONT; };
    var label = function (w) { return w.w.replace(/[“”"]/g, ''); };
    var lineW = function (ws) {
      var x = 0;
      ws.forEach(function (w, j) { ctx.font = smallFont(w); x += ctx.measureText(label(w)).width + (j ? smallSize * 0.28 : 0); });
      return x;
    };
    var bigText = st.big.map(label).join(' ').toUpperCase();
    var bigSize = Math.round((land ? 150 : 190) * u);
    ctx.font = '900 ' + bigSize + 'px ' + FONT;
    var bigW = ctx.measureText(bigText).width;
    if (bigW > maxW) { bigSize = Math.floor(bigSize * maxW / bigW); ctx.font = '900 ' + bigSize + 'px ' + FONT; bigW = ctx.measureText(bigText).width; }
    var leadW = st.lead.length ? lineW(st.lead) : 0, trailW = st.trail.length ? lineW(st.trail) : 0;
    var gap = 6 * u;
    var hLead = st.lead.length ? smallSize * 1.25 : 0, hTrail = st.trail.length ? smallSize * 1.25 : 0, hBig = bigSize * 1.02;
    var total = hLead + hBig + hTrail + gap * 2;
    var cy = H * (st.idx % 2 ? (land ? 0.3 : 0.27) : (land ? 0.68 : 0.66));
    var y = cy - total / 2;
    var bigX = (W - bigW) / 2;
    var fade = clamp((st.t1 - t) / 0.12, 0, 1);
    ctx.save();
    ctx.globalAlpha *= fade;
    ctx.textBaseline = 'alphabetic';
    ctx.textAlign = 'left';
    ctx.shadowColor = 'rgba(0,0,0,0.45)';
    ctx.shadowBlur = 14 * u;
    ctx.shadowOffsetY = 3 * u;
    var self = this;
    var drawSmall = function (ws, x, baseY) {
      ws.forEach(function (w, j) {
        var a = clamp((t - w.t0 + 0.15 + 0.05) / 0.15, 0, 1);
        ctx.font = smallFont(w);
        var tw = ctx.measureText(label(w)).width;
        if (a > 0) {
          ctx.save();
          ctx.globalAlpha *= a;
          if (a < 1) ctx.filter = 'blur(' + ((1 - a) * 10 * u).toFixed(1) + 'px)';
          ctx.fillStyle = w.accent ? '#ff4d5e' : '#fff';
          ctx.fillText(label(w), x, baseY + (1 - easeOut(a)) * 14 * u);
          ctx.restore();
        }
        x += tw + smallSize * 0.28;
      });
    };
    // Dòng dẫn: canh trái theo mép trái của từ khoá
    if (st.lead.length) {
      var lx = leadW > bigW ? (W - leadW) / 2 : bigX + 8 * u;
      drawSmall(st.lead, lx, y + smallSize);
      y += hLead + gap;
    }
    // Từ khoá to: đập vào (thu nhỏ từ to xuống) + hiện từng chữ cái
    var ba = clamp((t - st.bigAt + 0.03) / 0.16, 0, 1);
    if (ba > 0) {
      var by = y + bigSize * 0.88;
      var sc = 1 + 0.25 * (1 - easeOut(ba));
      ctx.save();
      ctx.translate(W / 2, by - bigSize * 0.4);
      ctx.scale(sc, sc);
      ctx.translate(-W / 2, -(by - bigSize * 0.4));
      ctx.globalAlpha *= clamp(ba * 2, 0, 1);
      ctx.font = '900 ' + bigSize + 'px ' + FONT;
      var tex = st.idx % 3 === 1 ? self.textureImage() : null;
      var fill;
      if (tex) {
        var off = self._texCanvas || (self._texCanvas = document.createElement('canvas'));
        off.width = Math.ceil(bigW); off.height = Math.ceil(bigSize * 1.1);
        drawCover(off.getContext('2d'), tex, off.width, off.height, 1.2, 0, 0.2);
        fill = ctx.createPattern(off, 'no-repeat');
        if (fill.setTransform) fill.setTransform(new DOMMatrix().translate(bigX, by - bigSize * 0.92));
      } else {
        var pal = KINETIC_FILLS[st.idx % KINETIC_FILLS.length];
        fill = ctx.createLinearGradient(0, by - bigSize * 0.8, 0, by);
        fill.addColorStop(0, pal[0]);
        fill.addColorStop(1, pal[1]);
      }
      ctx.fillStyle = fill;
      // Hiện từng chữ cái
      var chars = Array.from(bigText), cx = bigX;
      chars.forEach(function (ch, ci) {
        var ca = clamp((t - st.bigAt - ci * Math.min(0.02, 0.15 / chars.length) + 0.03) / 0.08, 0, 1);
        var cw = ctx.measureText(ch).width;
        if (ca > 0) {
          ctx.save();
          ctx.globalAlpha *= ca;
          ctx.fillText(ch, cx, by);
          ctx.restore();
        }
        cx += cw;
      });
      ctx.restore();
    }
    y += hBig + gap;
    // Dòng đuôi: canh phải theo mép phải của từ khoá
    if (st.trail.length) {
      var tx = trailW > bigW ? (W - trailW) / 2 : bigX + bigW - trailW - 8 * u;
      drawSmall(st.trail, tx, y + smallSize);
    }
    ctx.restore();
  };

  /** Phụ đề từng chữ kiểu TikTok/CapCut: chữ to viền đen, chữ đang nói đổi màu và bật lên. */
  Renderer.prototype.drawWordCaptions = function (words, t) {
    var phr = phrasesOf(words);
    var ph = null;
    for (var i = 0; i < phr.length; i++) if (t >= phr[i].t0 - 0.05 && t < phr[i].t1) { ph = phr[i]; break; }
    if (!ph) return;
    var ctx = this.ctx, W = this.W, H = this.H, u = this.unit, theme = this.theme;
    var size = Math.round((W > H ? 74 : 88) * u);
    ctx.font = '900 ' + size + 'px ' + FONT;
    var labels = ph.map(function (w) { return w.w.replace(/[“”"]/g, '').toUpperCase(); });
    var space = size * 0.28;
    var widths = labels.map(function (l) { return ctx.measureText(l).width; });
    var total = widths.reduce(function (a, b) { return a + b; }, 0) + space * (labels.length - 1);
    var maxW = W - 120 * u;
    if (total > maxW) {
      size = Math.floor(size * maxW / total);
      ctx.font = '900 ' + size + 'px ' + FONT;
      space = size * 0.28;
      widths = labels.map(function (l) { return ctx.measureText(l).width; });
      total = widths.reduce(function (a, b) { return a + b; }, 0) + space * (labels.length - 1);
    }
    var y = H * (W > H ? 0.8 : 0.68);
    var enter = easeBack((t - ph.t0) / 0.16);
    ctx.save();
    ctx.translate(W / 2, y);
    ctx.scale(0.75 + 0.25 * enter, 0.75 + 0.25 * enter);
    ctx.translate(-W / 2, -y);
    ctx.textBaseline = 'middle';
    ctx.textAlign = 'left';
    ctx.lineJoin = 'round';
    var x = (W - total) / 2;
    ph.forEach(function (w, j) {
      var next = ph[j + 1];
      var on = t >= w.t0 && t < (next ? next.t0 : ph.t1);
      var num = /\d/.test(w.w);
      var pop = on ? 1 + 0.14 * (1 - clamp((t - w.t0) / 0.18, 0, 1)) : 1;
      var cx = x + widths[j] / 2;
      ctx.save();
      ctx.translate(cx, y);
      ctx.scale(pop * (on ? 1.06 : 1), pop * (on ? 1.06 : 1));
      ctx.translate(-cx, -y);
      ctx.lineWidth = size * 0.2;
      ctx.strokeStyle = '#000';
      ctx.strokeText(labels[j], x, y);
      ctx.fillStyle = on ? theme.main : (num ? theme.main : '#fff');
      ctx.fillText(labels[j], x, y);
      ctx.restore();
      x += widths[j] + space;
    });
    ctx.restore();
  };

  Renderer.prototype.drawSubtitle = function (text, local, duration) {
    var ctx = this.ctx, W = this.W, H = this.H, u = this.unit;
    var size = Math.round((W > H ? 44 : 50) * u);
    ctx.font = '700 ' + size + 'px ' + FONT;
    var key = text + '|' + size;
    var chunks = this._subCache[key] || (this._subCache[key] = subtitleChunks(ctx, text, W - 200 * u));
    var p = clamp(local / Math.max(0.5, duration - 0.3), 0, 0.999);
    var chunk = null;
    for (var i = 0; i < chunks.length; i++) if (p >= chunks[i].from && p < chunks[i].to) { chunk = chunks[i]; break; }
    if (!chunk) return;
    var lh = size * 1.32;
    var boxH = lh * chunk.length + 36 * u;
    var widest = 0;
    chunk.forEach(function (l) { widest = Math.max(widest, ctx.measureText(l).width); });
    var boxW = widest + 64 * u;
    var x = (W - boxW) / 2;
    var y = H - boxH - (W > H ? 60 : 220) * u;
    var since = (p - chunk.from) * duration;
    var appear = easeOut(since / 0.25);
    ctx.save();
    ctx.globalAlpha *= appear;
    ctx.translate(0, (1 - appear) * 16 * u);
    roundRect(ctx, x, y, boxW, boxH, 18 * u);
    ctx.fillStyle = 'rgba(0,0,0,0.62)';
    ctx.fill();
    ctx.fillStyle = '#fff';
    ctx.textAlign = 'center';
    ctx.textBaseline = 'top';
    chunk.forEach(function (l, j) { ctx.fillText(l, W / 2, y + 18 * u + j * lh + 4 * u); });
    ctx.restore();
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

  Renderer.prototype.drawIntro = function (local) {
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

  Renderer.prototype.drawOutro = function (local) {
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
    FORMATS: FORMATS, THEMES: THEMES, TRANSITIONS: TRANSITIONS, TEXT_FX: TEXT_FX, TR: TR,
    Renderer: Renderer
  };
})();
