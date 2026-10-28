/* Nhạc nền resort tự sinh bằng WebAudio (không dùng file, không bản quyền):
   hợp âm pad êm + nốt chuông/piano thưa + tiếng sóng rất khẽ. Dùng chung cho trang web và bản xuất thử. */
function SSResort(C, out) {
  var bus = C.createGain(); bus.gain.value = 1;
  var tone = C.createBiquadFilter(); tone.type = 'lowpass'; tone.frequency.value = 3200;
  var dry = C.createGain(); dry.gain.value = 0.55;
  var wet = C.createGain(); wet.gain.value = 0.75;
  var rev = C.createConvolver();
  var len = Math.floor(C.sampleRate * 3.2), ir = C.createBuffer(2, len, C.sampleRate);
  for (var ch = 0; ch < 2; ch++) { var d = ir.getChannelData(ch); for (var i = 0; i < len; i++) d[i] = (Math.random() * 2 - 1) * Math.pow(1 - i / len, 2.6); }
  rev.buffer = ir;
  bus.connect(tone); tone.connect(dry); dry.connect(out); tone.connect(rev); rev.connect(wet); wet.connect(out);

  function hz(m) { return 440 * Math.pow(2, (m - 69) / 12); }
  /* Fmaj9 – Dm9 – Bbmaj9 – C6/9 */
  var CH = [[41, 57, 60, 64, 67], [38, 53, 57, 60, 64], [46, 50, 57, 60, 62], [36, 52, 55, 57, 62]];
  var PENTA = [[77, 79, 81, 84, 86, 88], [74, 77, 79, 81, 84, 86], [74, 77, 81, 82, 84, 86], [76, 79, 81, 84, 86, 88]];

  function pad(m, t, dur, lvl) {
    [-5, 5].forEach(function (cents, k) {
      var o = C.createOscillator(); o.type = k ? 'triangle' : 'sine'; o.frequency.value = hz(m); o.detune.value = cents;
      var g = C.createGain(); g.gain.setValueAtTime(0.0001, t);
      g.gain.linearRampToValueAtTime(lvl, t + 2.6); g.gain.setValueAtTime(lvl, t + dur - 0.5);
      g.gain.linearRampToValueAtTime(0.0001, t + dur + 3);
      o.connect(g); g.connect(bus); o.start(t); o.stop(t + dur + 3.2);
    });
  }
  function bell(m, t, lvl) {
    [[1, 1], [2.0, 0.28], [3.01, 0.08]].forEach(function (h) {
      var o = C.createOscillator(); o.type = 'sine'; o.frequency.value = hz(m) * h[0];
      var g = C.createGain(); g.gain.setValueAtTime(0.0001, t);
      g.gain.linearRampToValueAtTime(lvl * h[1], t + 0.015);
      g.gain.exponentialRampToValueAtTime(0.0001, t + 3.2 / h[0] + 0.8);
      o.connect(g); g.connect(bus); o.start(t); o.stop(t + 4.2);
    });
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
      g.gain.setValueAtTime(0.0001, t); g.gain.exponentialRampToValueAtTime(0.06, t + up); g.gain.exponentialRampToValueAtTime(0.0001, t + up + dn); };
  }
  var wv = waveBed();
  var BAR = 8, idx = 0;
  function schedule(t) {
    var c = CH[idx % 4], p = PENTA[idx % 4];
    pad(c[0] - 12, t, BAR, 0.05);
    for (var i = 1; i < c.length; i++) pad(c[i], t, BAR, 0.022);
    var x = t + 0.6 + Math.random() * 0.6;
    while (x < t + BAR - 0.4) { if (Math.random() < 0.72) bell(p[Math.floor(Math.random() * p.length)], x, 0.07 + Math.random() * 0.04); x += 0.9 + Math.random() * 1.5; }
    wv(t + 1); wv(t + 1 + BAR / 2);
    idx++;
  }
  return { schedule: schedule, BAR: BAR };
}
