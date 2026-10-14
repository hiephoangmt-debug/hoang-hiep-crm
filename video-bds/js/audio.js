/* Âm thanh: nhạc nền tự tạo (không lo bản quyền), hiệu ứng whoosh/ting/boom, giọng đọc, tự giảm nhạc khi có giọng. */
(function () {
  'use strict';

  var MOODS = {
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

  AudioEngine.prototype.scheduleMusic = function (mood, t0, duration) {
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
  AudioEngine.prototype.scheduleMusicVolume = function (t0, duration, base, voiceRanges) {
    var g = this.music.gain;
    var ducked = base * 0.28;
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
