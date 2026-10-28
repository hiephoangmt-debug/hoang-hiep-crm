/* Nhạc piano nhẹ nhàng kiểu lounge resort biển, tự sinh bằng WebAudio (không dùng file, không bản quyền):
   tay trái rải hợp âm, tay phải giai điệu thong thả, tiếng sóng khẽ phía dưới. */
function SSResort(C, out) {
  var bus = C.createGain(); bus.gain.value = 0.9;
  var tone = C.createBiquadFilter(); tone.type = 'lowpass'; tone.frequency.value = 4200;
  var dry = C.createGain(); dry.gain.value = 0.7;
  var wet = C.createGain(); wet.gain.value = 0.45;
  var rev = C.createConvolver();
  var len = Math.floor(C.sampleRate * 2.6), ir = C.createBuffer(2, len, C.sampleRate);
  for (var ch = 0; ch < 2; ch++) { var d = ir.getChannelData(ch); for (var i = 0; i < len; i++) d[i] = (Math.random() * 2 - 1) * Math.pow(1 - i / len, 3); }
  rev.buffer = ir;
  bus.connect(tone); tone.connect(dry); dry.connect(out); tone.connect(rev); rev.connect(wet); wet.connect(out);

  function hz(m) { return 440 * Math.pow(2, (m - 69) / 12); }
  var AMP = [1, 0.42, 0.22, 0.12, 0.06, 0.035, 0.02];
  /* tiếng piano: các họa âm hơi lệch (như dây đàn thật), họa âm cao tắt nhanh, 2 dây lệch nhẹ cho ấm */
  function piano(m, t, vel) {
    var f0 = hz(m), dec = 2.2 + (72 - m) * 0.06; if (dec < 1.4) dec = 1.4;
    var lp = C.createBiquadFilter(); lp.type = 'lowpass'; lp.frequency.value = 900 + vel * 3200; lp.connect(bus);
    for (var n = 1; n <= AMP.length; n++) {
      var a = AMP[n - 1] * vel; if (f0 * n > 9000) break;
      [0, 1.6].forEach(function (cents, k) {
        var o = C.createOscillator(); o.type = 'sine';
        o.frequency.value = f0 * n * Math.sqrt(1 + 0.00035 * n * n); o.detune.value = cents;
        var g = C.createGain(), dn = dec / Math.pow(n, 0.7);
        g.gain.setValueAtTime(0.0001, t);
        g.gain.linearRampToValueAtTime(a * (k ? 0.45 : 0.55), t + 0.018);
        g.gain.exponentialRampToValueAtTime(a * 0.25, t + 0.25 * dn);
        g.gain.exponentialRampToValueAtTime(0.0001, t + dn + 0.4);
        o.connect(g); g.connect(lp); o.start(t); o.stop(t + dn + 0.5);
      });
    }
  }
  /* sóng rất khẽ phía dưới */
  function waveBed() {
    var n = C.sampleRate * 3, b = C.createBuffer(1, n, C.sampleRate), d = b.getChannelData(0), b0 = 0, b1 = 0;
    for (var i = 0; i < n; i++) { var w = Math.random() * 2 - 1; b0 = 0.997 * b0 + w * 0.06; b1 = 0.96 * b1 + w * 0.2; d[i] = (b0 + b1 + w * 0.15) * 0.25; }
    var s = C.createBufferSource(); s.buffer = b; s.loop = true;
    var hp = C.createBiquadFilter(); hp.type = 'highpass'; hp.frequency.value = 420;
    var lp = C.createBiquadFilter(); lp.type = 'lowpass'; lp.frequency.value = 1400;
    var g = C.createGain(); g.gain.value = 0.0001;
    s.connect(hp); hp.connect(lp); lp.connect(g); g.connect(out); s.start();
    return function (t) { var up = 2.6 + Math.random(), dn = 4.5 + Math.random() * 1.5;
      g.gain.setValueAtTime(0.0001, t); g.gain.exponentialRampToValueAtTime(0.05, t + up); g.gain.exponentialRampToValueAtTime(0.0001, t + up + dn); };
  }
  var wv = waveBed();

  /* Vòng hợp âm: Cmaj7 – Am7 – Fmaj7 – G6 | Em7 – Am7 – Dm7 – G7sus */
  var PROG = [
    { b: 36, lh: [43, 52, 55, 59], rh: [72, 74, 76, 79, 83] },
    { b: 45, lh: [52, 55, 60, 64], rh: [69, 72, 74, 76, 79] },
    { b: 41, lh: [48, 52, 57, 60], rh: [69, 72, 74, 76, 77] },
    { b: 43, lh: [50, 55, 59, 64], rh: [71, 74, 76, 79, 81] },
    { b: 40, lh: [47, 52, 55, 62], rh: [71, 74, 76, 79, 83] },
    { b: 45, lh: [52, 55, 60, 64], rh: [69, 72, 74, 76, 79] },
    { b: 38, lh: [45, 50, 53, 60], rh: [69, 72, 74, 77, 81] },
    { b: 43, lh: [50, 53, 55, 60], rh: [72, 74, 77, 79, 81] }
  ];
  var BEAT = 0.95, BAR = BEAT * 4, idx = 0, pos = 2;
  function hum(x) { return x + (Math.random() - 0.5) * 0.03; }
  function schedule(t) {
    var c = PROG[idx % PROG.length], phraseEnd = (idx % 4) === 3;
    /* tay trái: bass + rải hợp âm nhẹ */
    piano(c.b, hum(t), 0.26);
    piano(c.lh[0], hum(t + BEAT * 0.5), 0.13);
    piano(c.lh[1], hum(t + BEAT * 1), 0.12);
    piano(c.lh[2], hum(t + BEAT * 1.5), 0.12);
    piano(c.lh[3], hum(t + BEAT * 2), 0.11);
    piano(c.lh[1], hum(t + BEAT * 2.5), 0.1);
    piano(c.lh[2], hum(t + BEAT * 3), 0.1);
    /* đã bỏ tay phải (nốt cao) theo yêu cầu – chỉ giữ rải hợp âm quãng trầm */
    if (idx % 2 === 0) wv(t + 0.5);
    idx++;
  }
  return { schedule: schedule, BAR: BAR };
}
