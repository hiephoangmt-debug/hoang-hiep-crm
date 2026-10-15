/* Âm thanh: nhạc nền tự tạo (không lo bản quyền), hiệu ứng whoosh/ting/boom, giọng đọc, tự giảm nhạc khi có giọng. */
(function () {
  'use strict';

  var MOODS = {
    'dien-anh': 'Điện ảnh: piano + dàn dây + trống (khuyên dùng)',
    'chill': 'Chill nhẹ nhàng: piano lofi',
    'none': 'Không nhạc',
    'nhe-nhang': 'Nhẹ nhàng, ấm áp',
    'soi-dong': 'Sôi động, trẻ trung',
    'sang-trong': 'Sang trọng, cao cấp'
  };

  function midi(n) { return 440 * Math.pow(2, (n - 69) / 12); }

  function noiseBuffer(ctx, seconds) {
    var len = Math.floor(ctx.sampleRate * seconds);
    var buf = ctx.createBuffer(1, len, ctx.sampleRate);
    var data = buf.getChannelData(0);
    for (var i = 0; i < len; i++) data[i] = Math.random() * 2 - 1;
    return buf;
  }

  function reverbImpulse(ctx, seconds, decay) {
    var len = Math.floor(ctx.sampleRate * seconds);
    var buf = ctx.createBuffer(2, len, ctx.sampleRate);
    for (var ch = 0; ch < 2; ch++) {
      var data = buf.getChannelData(ch);
      for (var i = 0; i < len; i++) data[i] = (Math.random() * 2 - 1) * Math.pow(1 - i / len, decay);
    }
    return buf;
  }

  function AudioEngine(ctx) {
    this.ctx = ctx;
    this.master = ctx.createDynamicsCompressor();
    this.master.threshold.value = -14;
    this.master.ratio.value = 4;
    this.master.attack.value = 0.005;
    this.master.release.value = 0.2;
    this.out = ctx.createGain();
    this.out.gain.value = 0.9;
    this.master.connect(this.out);

    this.reverb = ctx.createConvolver();
    this.reverb.buffer = reverbImpulse(ctx, 2.4, 2.5);
    this.reverbGain = ctx.createGain();
    this.reverbGain.gain.value = 0.28;
    this.reverb.connect(this.reverbGain).connect(this.master);

    this.music = ctx.createGain();
    this.music.connect(this.master);
    this.musicBus = ctx.createGain();
    this.musicBus.connect(this.music);
    this.musicBus.connect(this.reverb);

    this.sfx = ctx.createGain();
    this.sfx.gain.value = 0.8;
    this.sfx.connect(this.master);
    this.sfx.connect(this.reverb);

    this.voice = ctx.createGain();
    this.voice.gain.value = 1.0;
    this.voice.connect(this.master);

    this.noise = noiseBuffer(ctx, 2);
    this.sources = [];
  }

  AudioEngine.prototype._track = function (node) { this.sources.push(node); return node; };

  AudioEngine.prototype.stopAll = function () {
    this.sources.forEach(function (s) { try { s.stop(); } catch (e) { /* đã dừng */ } });
    this.sources = [];
  };

  /* ---------- Hiệu ứng âm thanh ---------- */

  AudioEngine.prototype.whoosh = function (t, dur) {
    var ctx = this.ctx;
    dur = dur || 0.6;
    var src = this._track(ctx.createBufferSource());
    src.buffer = this.noise;
    var bp = ctx.createBiquadFilter();
    bp.type = 'bandpass';
    bp.Q.value = 1.2;
    bp.frequency.setValueAtTime(250, t);
    bp.frequency.exponentialRampToValueAtTime(3200, t + dur * 0.7);
    bp.frequency.exponentialRampToValueAtTime(900, t + dur);
    var g = ctx.createGain();
    g.gain.setValueAtTime(0.0001, t);
    g.gain.exponentialRampToValueAtTime(0.55, t + dur * 0.6);
    g.gain.exponentialRampToValueAtTime(0.0001, t + dur);
    var pan = ctx.createStereoPanner ? ctx.createStereoPanner() : null;
    if (pan) {
      pan.pan.setValueAtTime(-0.6, t);
      pan.pan.linearRampToValueAtTime(0.6, t + dur);
      src.connect(bp).connect(g).connect(pan).connect(this.sfx);
    } else {
      src.connect(bp).connect(g).connect(this.sfx);
    }
    src.start(t);
    src.stop(t + dur + 0.05);
  };

  AudioEngine.prototype.ting = function (t, base) {
    var ctx = this.ctx;
    base = base || 1318.5;
    [1, 2.01, 3.02].forEach(function (mult, i) {
      var o = this._track(ctx.createOscillator());
      o.type = 'sine';
      o.frequency.value = base * mult;
      var g = ctx.createGain();
      var peak = [0.32, 0.12, 0.05][i];
      g.gain.setValueAtTime(0.0001, t);
      g.gain.exponentialRampToValueAtTime(peak, t + 0.008);
      g.gain.exponentialRampToValueAtTime(0.0001, t + 1.4 / mult);
      o.connect(g).connect(this.sfx);
      o.start(t);
      o.stop(t + 1.5);
    }, this);
  };

  AudioEngine.prototype.pop = function (t) {
    var ctx = this.ctx;
    var o = this._track(ctx.createOscillator());
    o.type = 'sine';
    o.frequency.setValueAtTime(900, t);
    o.frequency.exponentialRampToValueAtTime(220, t + 0.12);
    var g = ctx.createGain();
    g.gain.setValueAtTime(0.0001, t);
    g.gain.exponentialRampToValueAtTime(0.35, t + 0.01);
    g.gain.exponentialRampToValueAtTime(0.0001, t + 0.15);
    o.connect(g).connect(this.sfx);
    o.start(t);
    o.stop(t + 0.2);
  };

  AudioEngine.prototype.boom = function (t) {
    var ctx = this.ctx;
    var o = this._track(ctx.createOscillator());
    o.type = 'sine';
    o.frequency.setValueAtTime(110, t);
    o.frequency.exponentialRampToValueAtTime(38, t + 0.9);
    var g = ctx.createGain();
    g.gain.setValueAtTime(0.0001, t);
    g.gain.exponentialRampToValueAtTime(0.9, t + 0.02);
    g.gain.exponentialRampToValueAtTime(0.0001, t + 1.3);
    o.connect(g).connect(this.sfx);
    o.start(t);
    o.stop(t + 1.4);

    var n = this._track(ctx.createBufferSource());
    n.buffer = this.noise;
    var lp = ctx.createBiquadFilter();
    lp.type = 'lowpass';
    lp.frequency.setValueAtTime(4000, t);
    lp.frequency.exponentialRampToValueAtTime(200, t + 0.6);
    var ng = ctx.createGain();
    ng.gain.setValueAtTime(0.25, t);
    ng.gain.exponentialRampToValueAtTime(0.0001, t + 0.6);
    n.connect(lp).connect(ng).connect(this.sfx);
    n.start(t);
    n.stop(t + 0.7);
  };

  /** Tiếng "vút" ngắn khi cắt và zoom (kiểu TikTok). */
  AudioEngine.prototype.swish = function (t) {
    var ctx = this.ctx;
    var src = this._track(ctx.createBufferSource());
    src.buffer = this.noise;
    var hp = ctx.createBiquadFilter();
    hp.type = 'bandpass';
    hp.Q.value = 0.8;
    hp.frequency.setValueAtTime(1800, t);
    hp.frequency.exponentialRampToValueAtTime(6000, t + 0.14);
    var g = ctx.createGain();
    g.gain.setValueAtTime(0.0001, t);
    g.gain.exponentialRampToValueAtTime(0.32, t + 0.05);
    g.gain.exponentialRampToValueAtTime(0.0001, t + 0.18);
    src.connect(hp).connect(g).connect(this.sfx);
    src.start(t, Math.random());
    src.stop(t + 0.2);
  };

  /** Tiếng "đập" trầm khi từ khoá to xuất hiện. */
  AudioEngine.prototype.slam = function (t) {
    var ctx = this.ctx;
    var o = this._track(ctx.createOscillator());
    o.type = 'sine';
    o.frequency.setValueAtTime(150, t);
    o.frequency.exponentialRampToValueAtTime(48, t + 0.25);
    var g = ctx.createGain();
    g.gain.setValueAtTime(0.0001, t);
    g.gain.exponentialRampToValueAtTime(0.6, t + 0.01);
    g.gain.exponentialRampToValueAtTime(0.0001, t + 0.4);
    o.connect(g).connect(this.sfx);
    o.start(t);
    o.stop(t + 0.45);
    var n = this._track(ctx.createBufferSource());
    n.buffer = this.noise;
    var bp = ctx.createBiquadFilter();
    bp.type = 'bandpass';
    bp.frequency.value = 2500;
    var ng = ctx.createGain();
    ng.gain.setValueAtTime(0.22, t);
    ng.gain.exponentialRampToValueAtTime(0.0001, t + 0.07);
    n.connect(bp).connect(ng).connect(this.sfx);
    n.start(t, Math.random());
    n.stop(t + 0.1);
  };

  /** Tiếng "quẹt" khi vệt bút dạ quang chạy qua chữ. */
  AudioEngine.prototype.swipe = function (t) {
    var ctx = this.ctx;
    var src = this._track(ctx.createBufferSource());
    src.buffer = this.noise;
    var bp = ctx.createBiquadFilter();
    bp.type = 'bandpass';
    bp.Q.value = 2;
    bp.frequency.setValueAtTime(900, t);
    bp.frequency.exponentialRampToValueAtTime(2600, t + 0.3);
    var g = ctx.createGain();
    g.gain.setValueAtTime(0.0001, t);
    g.gain.exponentialRampToValueAtTime(0.4, t + 0.08);
    g.gain.exponentialRampToValueAtTime(0.0001, t + 0.32);
    src.connect(bp).connect(g).connect(this.sfx);
    src.start(t, Math.random());
    src.stop(t + 0.35);
  };

  /** Tiếng "ting ting" kiểu máy thu tiền khi nhắc tới giá. */
  AudioEngine.prototype.ching = function (t) {
    var ctx = this.ctx;
    [[2093, 0], [2637, 0.09]].forEach(function (p) {
      [1, 2.76, 5.4].forEach(function (mult, i) {
        var o = this._track(ctx.createOscillator());
        o.type = 'sine';
        o.frequency.value = p[0] * mult;
        var g = ctx.createGain();
        var a = t + p[1];
        g.gain.setValueAtTime(0.0001, a);
        g.gain.exponentialRampToValueAtTime([0.22, 0.08, 0.03][i], a + 0.004);
        g.gain.exponentialRampToValueAtTime(0.0001, a + 0.9 / mult);
        o.connect(g).connect(this.sfx);
        o.start(a);
        o.stop(a + 1);
      }, this);
    }, this);
    // tiếng ngăn kéo tiền
    var n = this._track(ctx.createBufferSource());
    n.buffer = this.noise;
    var hp = ctx.createBiquadFilter();
    hp.type = 'highpass';
    hp.frequency.value = 3000;
    var ng = ctx.createGain();
    ng.gain.setValueAtTime(0.18, t);
    ng.gain.exponentialRampToValueAtTime(0.0001, t + 0.06);
    n.connect(hp).connect(ng).connect(this.sfx);
    n.start(t, Math.random());
    n.stop(t + 0.08);
  };

  /** Tiếng nhạc vút lên dồn dập trước khi hiện khung liên hệ. */
  AudioEngine.prototype.riser = function (t, dur) {
    var ctx = this.ctx;
    dur = dur || 1.5;
    var src = this._track(ctx.createBufferSource());
    src.buffer = this.noise;
    src.loop = true;
    var bp = ctx.createBiquadFilter();
    bp.type = 'bandpass';
    bp.Q.value = 3;
    bp.frequency.setValueAtTime(300, t);
    bp.frequency.exponentialRampToValueAtTime(5000, t + dur);
    var g = ctx.createGain();
    g.gain.setValueAtTime(0.0001, t);
    g.gain.exponentialRampToValueAtTime(0.3, t + dur * 0.95);
    g.gain.exponentialRampToValueAtTime(0.0001, t + dur + 0.05);
    src.connect(bp).connect(g).connect(this.sfx);
    src.start(t);
    src.stop(t + dur + 0.1);
    var o = this._track(ctx.createOscillator());
    o.type = 'sawtooth';
    o.frequency.setValueAtTime(110, t);
    o.frequency.exponentialRampToValueAtTime(880, t + dur);
    var lp = ctx.createBiquadFilter();
    lp.type = 'lowpass';
    lp.frequency.value = 1800;
    var og = ctx.createGain();
    og.gain.setValueAtTime(0.0001, t);
    og.gain.exponentialRampToValueAtTime(0.06, t + dur * 0.9);
    og.gain.exponentialRampToValueAtTime(0.0001, t + dur + 0.05);
    o.connect(lp).connect(og).connect(this.sfx);
    o.start(t);
    o.stop(t + dur + 0.1);
  };

  /* ---------- Nhạc nền tự tạo ---------- */

  AudioEngine.prototype._pad = function (notes, t, dur, vol) {
    var ctx = this.ctx;
    var lp = ctx.createBiquadFilter();
    lp.type = 'lowpass';
    lp.frequency.value = 1400;
    var g = ctx.createGain();
    g.gain.setValueAtTime(0.0001, t);
    g.gain.linearRampToValueAtTime(vol, t + Math.min(0.8, dur * 0.3));
    g.gain.setValueAtTime(vol, t + dur - 0.4);
    g.gain.linearRampToValueAtTime(0.0001, t + dur + 0.3);
    lp.connect(g).connect(this.musicBus);
    notes.forEach(function (n) {
      [-7, 7].forEach(function (det) {
        var o = this._track(ctx.createOscillator());
        o.type = 'sawtooth';
        o.frequency.value = midi(n);
        o.detune.value = det;
        o.connect(lp);
        o.start(t);
        o.stop(t + dur + 0.4);
      }, this);
    }, this);
  };

  AudioEngine.prototype._pluck = function (note, t, vol, type, decay) {
    var ctx = this.ctx;
    var o = this._track(ctx.createOscillator());
    o.type = type || 'triangle';
    o.frequency.value = midi(note);
    var g = ctx.createGain();
    g.gain.setValueAtTime(0.0001, t);
    g.gain.exponentialRampToValueAtTime(vol, t + 0.005);
    g.gain.exponentialRampToValueAtTime(0.0001, t + (decay || 0.6));
    o.connect(g).connect(this.musicBus);
    o.start(t);
    o.stop(t + (decay || 0.6) + 0.05);
  };

  AudioEngine.prototype._kick = function (t, vol) {
    var ctx = this.ctx;
    var o = this._track(ctx.createOscillator());
    o.frequency.setValueAtTime(140, t);
    o.frequency.exponentialRampToValueAtTime(45, t + 0.12);
    var g = ctx.createGain();
    g.gain.setValueAtTime(vol, t);
    g.gain.exponentialRampToValueAtTime(0.0001, t + 0.3);
    o.connect(g).connect(this.music);
    o.start(t);
    o.stop(t + 0.32);
  };

  AudioEngine.prototype._hat = function (t, vol) {
    var ctx = this.ctx;
    var n = this._track(ctx.createBufferSource());
    n.buffer = this.noise;
    var hp = ctx.createBiquadFilter();
    hp.type = 'highpass';
    hp.frequency.value = 7000;
    var g = ctx.createGain();
    g.gain.setValueAtTime(vol, t);
    g.gain.exponentialRampToValueAtTime(0.0001, t + 0.05);
    n.connect(hp).connect(g).connect(this.music);
    n.start(t, Math.random());
    n.stop(t + 0.06);
  };

  /* ---------- Nhạc nền mới: piano, dàn dây, bass, trống ---------- */

  /** Tiếng piano: nhiều hoạ âm tắt dần, tiếng búa nhẹ ở đầu. */
  AudioEngine.prototype._piano = function (note, t, vol, len) {
    var ctx = this.ctx, f = midi(note);
    len = len || 2.2;
    var lp = ctx.createBiquadFilter();
    lp.type = 'lowpass';
    lp.frequency.setValueAtTime(Math.min(9000, f * 9), t);
    lp.frequency.exponentialRampToValueAtTime(Math.max(400, f * 2), t + len);
    var g = ctx.createGain();
    g.gain.setValueAtTime(0.0001, t);
    g.gain.exponentialRampToValueAtTime(vol, t + 0.006);
    g.gain.exponentialRampToValueAtTime(vol * 0.35, t + 0.35);
    g.gain.exponentialRampToValueAtTime(0.0001, t + len);
    lp.connect(g).connect(this.musicBus);
    [[1, 1], [2, 0.42], [3, 0.2], [4, 0.1], [5.02, 0.05]].forEach(function (h, i) {
      var o = this._track(ctx.createOscillator());
      o.type = i ? 'sine' : 'triangle';
      o.frequency.value = f * h[0];
      o.detune.value = (i % 2 ? 3 : -3);
      var hg = ctx.createGain();
      hg.gain.value = h[1];
      o.connect(hg).connect(lp);
      o.start(t);
      o.stop(t + len + 0.05);
    }, this);
  };

  /** Dàn dây: sóng răng cưa lệch nhẹ, lọc mềm, vào chậm ra chậm. */
  AudioEngine.prototype._strings = function (notes, t, dur, vol) {
    var ctx = this.ctx;
    var lp = ctx.createBiquadFilter();
    lp.type = 'lowpass';
    lp.frequency.value = 1600;
    lp.Q.value = 0.4;
    var g = ctx.createGain();
    g.gain.setValueAtTime(0.0001, t);
    g.gain.linearRampToValueAtTime(vol, t + Math.min(1.4, dur * 0.4));
    g.gain.setValueAtTime(vol, t + dur - 0.5);
    g.gain.linearRampToValueAtTime(0.0001, t + dur + 0.6);
    lp.connect(g).connect(this.musicBus);
    this._pumpTargets = this._pumpTargets || [];
    this._pumpTargets.push(g);
    notes.forEach(function (n) {
      [-9, 0, 9].forEach(function (det) {
        var o = this._track(ctx.createOscillator());
        o.type = 'sawtooth';
        o.frequency.value = midi(n);
        o.detune.value = det;
        o.connect(lp);
        o.start(t);
        o.stop(t + dur + 0.7);
      }, this);
    }, this);
  };

  AudioEngine.prototype._bass = function (note, t, len, vol) {
    var ctx = this.ctx;
    var o = this._track(ctx.createOscillator());
    o.type = 'sine';
    o.frequency.value = midi(note);
    var o2 = this._track(ctx.createOscillator());
    o2.type = 'triangle';
    o2.frequency.value = midi(note);
    var g = ctx.createGain();
    g.gain.setValueAtTime(0.0001, t);
    g.gain.exponentialRampToValueAtTime(vol, t + 0.02);
    g.gain.exponentialRampToValueAtTime(vol * 0.6, t + len * 0.6);
    g.gain.exponentialRampToValueAtTime(0.0001, t + len);
    var g2 = ctx.createGain();
    g2.gain.value = 0.25;
    o.connect(g);
    o2.connect(g2).connect(g);
    g.connect(this.music);
    o.start(t); o2.start(t);
    o.stop(t + len + 0.05); o2.stop(t + len + 0.05);
  };

  AudioEngine.prototype._snap = function (t, vol) {
    var ctx = this.ctx;
    var n = this._track(ctx.createBufferSource());
    n.buffer = this.noise;
    var bp = ctx.createBiquadFilter();
    bp.type = 'bandpass';
    bp.frequency.value = 1900;
    bp.Q.value = 0.9;
    var g = ctx.createGain();
    g.gain.setValueAtTime(vol, t);
    g.gain.exponentialRampToValueAtTime(0.0001, t + 0.16);
    n.connect(bp).connect(g);
    g.connect(this.music);
    g.connect(this.reverb);
    n.start(t, Math.random());
    n.stop(t + 0.18);
  };

  /** Nhạc nhún theo trống (sidechain): dàn dây nhỏ lại một chút mỗi nhịp trống. */
  AudioEngine.prototype._pump = function (t) {
    (this._pumpTargets || []).forEach(function (g) {
      try {
        var v = g.gain.value || 0.03;
        g.gain.setTargetAtTime(v * 0.55, t, 0.01);
        g.gain.setTargetAtTime(v, t + 0.06, 0.12);
      } catch (e) { /* bỏ qua */ }
    });
  };

  AudioEngine.prototype.scheduleMusic = function (mood, t0, duration) {
    if (!mood || mood === 'none') return;
    if (mood !== 'dien-anh' && mood !== 'chill') { this.scheduleMusicBasic(mood, t0, duration); return; }
    // Vòng hoà âm vi–IV–I–V (giọng Rê trưởng), kiểu nhạc quảng cáo BĐS
    var prog = [[59, 62, 66], [55, 59, 62], [50, 54, 57], [57, 61, 64]]; // Bm G D A
    var roots = [47, 43, 38, 45];
    var cine = mood === 'dien-anh';
    var bpm = cine ? 92 : 82;
    var beat = 60 / bpm, bar = beat * 4, end = t0 + duration;
    var bars = Math.ceil(duration / bar);
    var intro = cine ? 2 : 1; // vài ô nhịp đầu chỉ có piano + dây, rồi trống vào
    for (var b = 0; b < bars; b++) {
      var tb = t0 + b * bar;
      if (tb >= end) break;
      var ch = prog[b % 4], root = roots[b % 4];
      var len = Math.min(bar, end - tb);
      this._strings(ch, tb, len, cine ? 0.028 : 0.018);
      // Piano rải hợp âm: 8 nốt mỗi ô nhịp
      var pat = cine ? [0, 1, 2, 1, 0, 2, 1, 2] : [0, 2, 1, 2, -1, 2, 1, 2];
      for (var k = 0; k < 8; k++) {
        var tk = tb + k * beat / 2 + (cine ? 0 : (k % 2 ? 0.03 : 0)); // chill: hơi lệch nhịp cho mềm
        if (tk >= end - 0.2) break;
        var idx = pat[k];
        var note = idx < 0 ? ch[0] + 12 : ch[idx] + 12;
        this._piano(note, tk, k === 0 ? 0.12 : 0.07, 1.8);
      }
      // Giai điệu nốt cao ở ô nhịp chẵn
      if (cine && b >= intro && b % 2 === 0) this._piano(ch[2] + 24, tb + beat * 2.5, 0.06, 2.4);
      if (b >= intro) {
        this._bass(root, tb, beat * 1.8, 0.3);
        this._bass(root, tb + beat * 2, beat * 1.6, 0.24);
        for (var q = 0; q < 4; q++) {
          var tq = tb + q * beat;
          if (tq >= end) break;
          if (q === 0 || q === 2 || (cine && q === 3 && b % 4 === 3)) { this._kick(tq, cine ? 0.5 : 0.35); this._pump(tq); }
          if (q === 1 || q === 3) this._snap(tq, cine ? 0.18 : 0.12);
          this._hat(tq + beat / 2, cine ? 0.06 : 0.04);
        }
      }
    }
    // Cuối bài: một nốt piano trầm ngân dài
    this._piano(50, Math.max(t0, end - 2.5), 0.12, 3);
  };

  AudioEngine.prototype.scheduleMusicBasic = function (mood, t0, duration) {
    if (!mood || mood === 'none') return;
    var cfg = {
      'nhe-nhang': { bpm: 84, chords: [[60, 64, 67, 71], [57, 60, 64, 67], [53, 57, 60, 64], [55, 59, 62, 67]], drums: false, arp: 'triangle' },
      'soi-dong': { bpm: 118, chords: [[57, 60, 64], [53, 57, 60], [60, 64, 67], [55, 59, 62]], drums: true, arp: 'square' },
      'sang-trong': { bpm: 72, chords: [[62, 65, 69, 72], [55, 59, 62, 65], [60, 64, 67, 71], [57, 60, 64, 67]], drums: false, arp: 'sine' }
    }[mood];
    if (!cfg) return;
    var beat = 60 / cfg.bpm;
    var bar = beat * 4;
    var end = t0 + duration;
    var bars = Math.ceil(duration / bar);
    for (var b = 0; b < bars; b++) {
      var tb = t0 + b * bar;
      if (tb >= end) break;
      var chord = cfg.chords[b % cfg.chords.length];
      var padDur = Math.min(bar, end - tb);
      this._pad(chord, tb, padDur, mood === 'soi-dong' ? 0.035 : 0.05);
      // Bass
      this._pluck(chord[0] - 24, tb, 0.22, 'sine', bar * 0.9);
      if (mood === 'soi-dong') this._pluck(chord[0] - 24, tb + beat * 2.5, 0.16, 'sine', beat);
      // Arpeggio
      var steps = mood === 'soi-dong' ? 8 : 4;
      for (var s = 0; s < steps; s++) {
        var ts = tb + s * (bar / steps);
        if (ts >= end - 0.1) break;
        var note = chord[s % chord.length] + 12;
        if (mood === 'sang-trong' && s % 2 === 1) continue;
        this._pluck(note, ts, mood === 'soi-dong' ? 0.05 : 0.08, cfg.arp,
          mood === 'soi-dong' ? 0.18 : 1.2);
      }
      if (cfg.drums) {
        for (var k = 0; k < 4; k++) {
          var tk = tb + k * beat;
          if (tk >= end) break;
          this._kick(tk, 0.55);
          this._hat(tk + beat / 2, 0.12);
        }
      }
    }
  };

  AudioEngine.prototype.playBuffer = function (buffer, t, dest, opts) {
    opts = opts || {};
    var src = this._track(this.ctx.createBufferSource());
    src.buffer = buffer;
    src.loop = !!opts.loop;
    src.connect(dest);
    src.start(t, opts.offset || 0);
    if (opts.duration) src.stop(t + opts.duration);
    return src;
  };

  /**
   * Lên lịch âm lượng nhạc nền: mở dần ở đầu, giảm khi có giọng đọc, tắt dần ở cuối.
   * voiceRanges: mảng [bắt đầu, kết thúc] (giây, tính từ t0).
   */
  /** Gộp các khoảng có giọng nói chồng lên nhau. */
  function mergeRanges(ranges) {
    var r = (ranges || []).slice().sort(function (a, b) { return a[0] - b[0]; });
    var out = [];
    r.forEach(function (x) {
      var last = out[out.length - 1];
      if (last && x[0] <= last[1] + 0.8) last[1] = Math.max(last[1], x[1]);
      else out.push([x[0], x[1]]);
    });
    return out;
  }

  /**
   * Đưa tiếng gốc của clip video vào bộ trộn (để ghi vào video xuất ra).
   * Mỗi thẻ video chỉ tạo nguồn âm một lần; mỗi lượt phát gắn vào một nút âm lượng mới.
   */
  AudioEngine.prototype.attachClip = function (video) {
    var ctx = this.ctx;
    if (!video._bdsSrc || video._bdsCtx !== ctx) {
      video._bdsSrc = ctx.createMediaElementSource(video);
      video._bdsCtx = ctx;
    }
    video.muted = false;
    var g = ctx.createGain();
    g.gain.value = 0;
    video._bdsSrc.connect(g).connect(this.voice);
    this.clipGains = this.clipGains || [];
    this.clipGains.push({ video: video, gain: g });
    video._bdsGain = g;
  };

  AudioEngine.prototype.setClipGain = function (video, v) {
    var g = video._bdsGain;
    if (!g || g._v === v) return;
    g._v = v;
    g.gain.setTargetAtTime(v, this.ctx.currentTime, 0.03);
  };

  AudioEngine.prototype.detachClips = function () {
    (this.clipGains || []).forEach(function (c) {
      try { c.video._bdsSrc.disconnect(c.gain); } catch (e) { /* đã ngắt */ }
      c.gain.disconnect();
      if (c.video._bdsGain === c.gain) c.video._bdsGain = null;
    });
    this.clipGains = [];
  };

  AudioEngine.prototype.scheduleMusicVolume = function (t0, duration, base, voiceRanges) {
    var g = this.music.gain;
    var ducked = base * 0.17; // có giọng nói thì nhạc hạ sâu để giọng nổi rõ
    voiceRanges = mergeRanges(voiceRanges);
    g.cancelScheduledValues(0);
    g.setValueAtTime(0.0001, t0);
    g.linearRampToValueAtTime(base, t0 + 1.2);
    (voiceRanges || []).forEach(function (r) {
      var a = t0 + Math.max(0.2, r[0] - 0.25);
      var b = t0 + Math.min(duration - 1.6, r[1] + 0.3);
      if (b <= a) return;
      g.setValueAtTime(base, a);
      g.linearRampToValueAtTime(ducked, a + 0.25);
      g.setValueAtTime(ducked, b);
      g.linearRampToValueAtTime(base, b + 0.4);
    });
    g.setValueAtTime(base, t0 + Math.max(0, duration - 1.5));
    g.linearRampToValueAtTime(0.0001, t0 + duration);
  };

  window.BdsAudio = { MOODS: MOODS, AudioEngine: AudioEngine };
})();
