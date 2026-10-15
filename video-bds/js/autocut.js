/* Tự dựng từ một video dài: quét giọng nói, cắt bỏ khoảng ngừng (cắt nhảy), chia cảnh, tạo phụ đề. */
(function () {
  'use strict';

  var WIN = 0.02; // độ phân giải quét âm thanh (giây)

  /** Mức âm lượng theo từng khoảng 20ms (đã trộn các kênh). */
  function envelope(buf) {
    var sr = buf.sampleRate, win = Math.max(1, Math.floor(sr * WIN)), n = Math.floor(buf.length / win);
    var chans = [];
    for (var c = 0; c < buf.numberOfChannels; c++) chans.push(buf.getChannelData(c));
    var rms = new Float32Array(n);
    for (var w = 0; w < n; w++) {
      var sum = 0, cnt = 0;
      for (var ci = 0; ci < chans.length; ci++) {
        var d = chans[ci];
        for (var j = w * win; j < (w + 1) * win; j += 2) { sum += d[j] * d[j]; cnt++; }
      }
      rms[w] = Math.sqrt(sum / cnt);
    }
    return rms;
  }

  /**
   * Tìm các đoạn đang nói.
   * opts.minPause: khoảng ngừng ngắn nhất sẽ bị cắt (giây); opts.pad: giữ lại trước/sau mỗi đoạn.
   */
  function findSpeech(buf, opts) {
    opts = opts || {};
    var minPause = opts.minPause || 0.35, padIn = opts.padIn != null ? opts.padIn : 0.08, padOut = opts.padOut != null ? opts.padOut : 0.14;
    var rms = envelope(buf), n = rms.length;
    var sorted = Array.prototype.slice.call(rms).sort(function (a, b) { return a - b; });
    var floor = sorted[Math.floor(n * 0.15)] || 0, p95 = sorted[Math.floor(n * 0.95)] || 0;
    var thr = Math.max(0.005, floor + (p95 - floor) * (opts.sensitivity || 0.12));
    var runs = [], start = -1;
    for (var i = 0; i <= n; i++) {
      var on = i < n && rms[i] >= thr;
      if (on && start < 0) start = i;
      if (!on && start >= 0) { runs.push([start * WIN, i * WIN]); start = -1; }
    }
    // Nối các đoạn cách nhau ít hơn khoảng ngừng tối thiểu; bỏ tiếng động quá ngắn
    var merged = [];
    runs.forEach(function (r) {
      var last = merged[merged.length - 1];
      if (last && r[0] - last[1] < minPause) last[1] = r[1];
      else merged.push(r.slice());
    });
    merged = merged.filter(function (r) { return r[1] - r[0] >= 0.18; });
    var dur = buf.duration;
    var out = merged.map(function (r) { return [Math.max(0, r[0] - padIn), Math.min(dur, r[1] + padOut)]; });
    // Phần đệm có thể chồng lên nhau: nối lại
    var fin = [];
    out.forEach(function (r) {
      var last = fin[fin.length - 1];
      if (last && r[0] <= last[1]) last[1] = Math.max(last[1], r[1]);
      else fin.push(r);
    });
    // Đếm số tiếng (đỉnh âm lượng) để đo tốc độ nói
    var peaks = 0, lastPeak = -99, speechSec = 0;
    for (var q = 1; q < n - 1; q++) {
      if (rms[q] >= thr) speechSec += WIN;
      if (rms[q] > thr * 1.4 && rms[q] >= rms[q - 1] && rms[q] > rms[q + 1] && (q - lastPeak) * WIN >= 0.12) {
        // Phải là đỉnh rõ (cao hơn vùng xung quanh)
        var lo = Math.min(rms[Math.max(0, q - 4)], rms[Math.min(n - 1, q + 4)]);
        if (rms[q] > lo * 1.25) { peaks++; lastPeak = q; }
      }
    }
    var active = [];
    for (var k = 0; k < n; k++) if (rms[k] >= thr) active.push(rms[k]);
    active.sort(function (a, b) { return a - b; });
    var med = active[Math.floor(active.length / 2)] || p95 || 0.1;
    var rate = speechSec > 1 ? peaks / speechSec : 0; // tiếng / giây
    return { segments: fin, voiceGain: Math.max(0.5, Math.min(4, 0.12 / med)), duration: dur, rate: rate, speed: paceFor(rate) };
  }

  /**
   * Tốc độ phát để giọng nói đạt nhịp vừa nghe (khoảng 5 tiếng/giây kiểu video TikTok).
   * Nói chậm thì tăng tốc (tối đa 1,3 lần, giữ nguyên cao độ giọng), nói quá nhanh thì hãm nhẹ.
   */
  function paceFor(rate) {
    if (!rate) return 1;
    var sp = 5.5 / rate;
    // Chỉ hãm khi nói thật sự quá nhanh (trên 7 tiếng/giây); nói nhanh vừa phải là nhịp TikTok tốt
    if (sp < 1) sp = rate > 7 ? Math.max(0.92, 6.5 / rate) : 1;
    sp = Math.min(1.3, sp);
    return Math.round(sp * 20) / 20;
  }

  /**
   * Gom các đoạn nói thành cảnh: tách cảnh ở chỗ ngừng dài, hoặc khi cảnh đã dài quá maxScene giây.
   */
  function groupScenes(segments, opts) {
    opts = opts || {};
    var longPause = opts.longPause || 0.9, maxScene = opts.maxScene || 14;
    var scenes = [], cur = [], len = 0;
    segments.forEach(function (s, i) {
      var prev = segments[i - 1];
      var gap = prev ? s[0] - prev[1] : 0;
      if (cur.length && (gap >= longPause || len >= maxScene)) { scenes.push(cur); cur = []; len = 0; }
      cur.push(s);
      len += s[1] - s[0];
    });
    if (cur.length) scenes.push(cur);
    return scenes;
  }

  /** Lấy âm thanh 16kHz một kênh (đầu vào cho nhận dạng giọng nói). */
  function to16k(buf, maxSec) {
    var dur = maxSec ? Math.min(buf.duration, maxSec) : buf.duration;
    var ctx = new OfflineAudioContext(1, Math.ceil(dur * 16000), 16000);
    var src = ctx.createBufferSource();
    src.buffer = buf;
    src.connect(ctx.destination);
    src.start();
    return ctx.startRendering().then(function (r) { return r.getChannelData(0); });
  }

  var asrPromise = null;

  function loadModel(onProgress) {
    var progress = function (p) {
      if (onProgress && p.status === 'progress' && p.total) onProgress('Đang tải mô hình nhận dạng giọng nói… ' + Math.round(p.loaded / p.total * 100) + '%');
    };
    return import('https://cdn.jsdelivr.net/npm/@huggingface/transformers@3.0.2').then(function (T) {
      var cpu = function () {
        return T.pipeline('automatic-speech-recognition', 'Xenova/whisper-small', { dtype: 'q8', device: 'wasm', progress_callback: progress });
      };
      if (!navigator.gpu) return cpu();
      // Dùng card đồ hoạ (nhanh hơn nhiều); máy không hỗ trợ thì quay về cách thường
      return navigator.gpu.requestAdapter().then(function (ad) {
        if (!ad) return cpu();
        return T.pipeline('automatic-speech-recognition', 'Xenova/whisper-small', {
          device: 'webgpu', dtype: { encoder_model: 'fp32', decoder_model_merged: 'q4' }, progress_callback: progress
        }).catch(cpu);
      }).catch(cpu);
    });
  }

  /**
   * Nhận dạng giọng nói tiếng Việt ngay trên máy (Whisper). Lần đầu tải mô hình khoảng 250MB rồi lưu lại.
   * opts.maxSec: chỉ nghe ngần ấy giây đầu (chế độ nhanh, đủ để biết clip thuộc cảnh nào).
   * Trả về danh sách chữ { w, t0, t1 } theo thời gian trong video gốc.
   */
  function transcribe(buf, onProgress, opts) {
    opts = opts || {};
    if (!asrPromise) {
      asrPromise = loadModel(onProgress);
      asrPromise.catch(function () { asrPromise = null; });
    }
    var dur = opts.maxSec ? Math.min(buf.duration, opts.maxSec) : buf.duration;
    return Promise.all([asrPromise, to16k(buf, opts.maxSec)]).then(function (r) {
      if (onProgress) onProgress(opts.maxSec ? 'Đang nghe ' + Math.round(dur) + ' giây đầu…' : 'Đang nghe và chép lời (có thể mất vài phút)…');
      return r[0](r[1], { language: 'vietnamese', task: 'transcribe', chunk_length_s: 30, stride_length_s: 5, return_timestamps: true });
    }).then(function (out) {
      var words = [];
      (out.chunks || [{ text: out.text, timestamp: [0, dur] }]).forEach(function (c) {
        var a = c.timestamp[0] || 0, b = c.timestamp[1] != null ? c.timestamp[1] : a + 3;
        words = words.concat(window.BdsTimeline.distributeWords(c.text, [[a, b]]));
      });
      return words;
    });
  }

  /** Gán chữ (theo thời gian video gốc) vào từng đoạn nói. */
  function wordsInRange(words, a, b) {
    return words.filter(function (w) { var m = (w.t0 + w.t1) / 2; return m >= a && m < b; });
  }

  /** Rải lời thoại dán sẵn theo tổng thời gian đang nói (khi không dùng nhận dạng giọng nói). */
  function scriptWords(text, segments) {
    return window.BdsTimeline.distributeWords(text, segments);
  }

  /* ---------- Xếp đoạn nói vào đúng cảnh theo kịch bản ---------- */

  /** Chuẩn hoá chữ tiếng Việt để so sánh (bỏ dấu, chữ thường). */
  function norm(t) {
    return (t || '').toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/đ/g, 'd')
      .replace(/[^a-z0-9%]+/g, ' ').trim();
  }

  function tokens(t) { return norm(t).split(' ').filter(Boolean); }

  function bigrams(tk) {
    var out = [];
    for (var i = 0; i + 1 < tk.length; i++) out.push(tk[i] + ' ' + tk[i + 1]);
    return out;
  }

  /** Mức khớp giữa lời nói (đã nhận dạng) và lời thoại một cảnh; kèm vị trí khớp trong kịch bản. */
  function similarity(spoken, script) {
    var a = tokens(spoken), b = tokens(script);
    if (!a.length || !b.length) return { score: 0, pos: 0, from: 0, to: 0 };
    var bb = bigrams(b), bIdx = {};
    bb.forEach(function (g, i) { (bIdx[g] = bIdx[g] || []).push(i); });
    var uni = {};
    b.forEach(function (w) { uni[w] = 1; });
    var ab = bigrams(a), hitB = 0, hitU = 0, pos = [];
    ab.forEach(function (g) { if (bIdx[g]) { hitB++; pos.push(bIdx[g][0]); } });
    a.forEach(function (w) { if (uni[w]) hitU++; });
    var score = (ab.length ? hitB / ab.length : 0) * 0.65 + (hitU / a.length) * 0.35;
    pos.sort(function (x, y) { return x - y; });
    // Vùng kịch bản được nói tới (bỏ các điểm khớp lẻ ở hai đầu)
    var lo = pos.length ? pos[Math.floor(pos.length * 0.1)] : 0, hi = pos.length ? pos[Math.ceil(pos.length * 0.9) - 1] + 1 : 0;
    return { score: score, pos: pos.length ? pos[Math.floor(pos.length / 2)] : 0, from: lo, to: Math.min(b.length, hi + 1) };
  }

  /** Gom đoạn nói của một clip thành từng câu (ngắt ở chỗ ngừng dài). */
  var FILLER = /^(à|ạ|ừ|ừm|ờ|ơ|ơ|um|uh|ừa|ê|thì|là)$/;

  /**
   * Vấp rồi nói lại ngay trong một hơi ("Có 1,6 tỷ mà… Có 1,6 tỷ mà muốn sở hữu…"):
   * tìm chỗ bắt đầu lặp lại cụm 3 chữ đầu câu, trả về vị trí bắt đầu lần nói sau cùng.
   */
  function restartIndex(ws) {
    var t = ws.map(function (w) { return norm(w.w); });
    var cut = 0;
    for (var k = 1; k + 2 < t.length; k++) {
      for (var j = cut; j <= Math.min(cut + 2, k - 1); j++) {
        if (t[k] && t[k] === t[j] && t[k + 1] === t[j + 1] && t[k + 2] === t[j + 2]) { cut = k; break; }
      }
    }
    return cut;
  }

  /** Gom đoạn nói của một clip thành từng câu (ngắt ở chỗ ngừng dài), bỏ phần vấp trước khi nói lại. */
  function utterances(clip, longPause) {
    var groups = groupScenes(clip.segments, { longPause: longPause || 0.7, maxScene: 30 });
    return groups.map(function (segs) {
      var a = segs[0][0], b = segs[segs.length - 1][1];
      var ws = clip.words ? wordsInRange(clip.words, a, b) : [];
      var cut = restartIndex(ws), restarted = false;
      if (cut > 0) {
        var from = Math.max(a, ws[cut].t0 - 0.12);
        ws = ws.slice(cut);
        segs = segs.filter(function (sg) { return sg[1] > from; }).map(function (sg) { return [Math.max(sg[0], from), sg[1]]; });
        a = from;
        restarted = true;
      }
      var fillers = ws.filter(function (w) { return FILLER.test(norm(w.w)); }).length;
      return { clip: clip, segs: segs, start: a, end: b, text: ws.map(function (w) { return w.w; }).join(' '), fillers: fillers, restarted: restarted };
    });
  }

  /**
   * Gán từng câu nói vào cảnh khớp nhất. Câu không khớp cảnh nào (nói hỏng, nói ngoài lề) bị bỏ.
   * Nhiều lần nói cùng một ý (quay liền, nói lại nhiều lần): giữ lần nói HAY NHẤT —
   * đủ câu nhất, đúng kịch bản nhất, ít "à, ừm" nhất; ngang nhau thì lấy lần sau.
   */
  function matchUtterances(utts, scenes) {
    var result = scenes.map(function () { return []; });
    var dropped = [];
    utts.forEach(function (u, ui) {
      u.order = ui;
      var best = -1, bs = null;
      scenes.forEach(function (sc, si) {
        var sim = similarity(u.text, sc.text + ' ' + (sc.bigText || []).join(' '));
        if (!bs || sim.score > bs.score) { bs = sim; best = si; }
      });
      if (bs && bs.score >= 0.3 && tokens(u.text).length >= 2) { u.sim = bs; u.scene = best; result[best].push(u); }
      else { u._bs = bs; dropped.push(u); }
    });
    // Câu nghe chưa rõ (khớp kịch bản ít) nhưng đủ dài: giữ lại, gắn vào cảnh của câu đứng trước trong cùng clip
    dropped = dropped.filter(function (u) {
      // Giữ: câu từ 5 chữ (kể cả nói thêm ngoài kịch bản), hoặc câu 4 chữ có khớp kịch bản một phần.
      // Bỏ: câu rất ngắn ("ok quay lại", "3 2 1"…)
      var nTok = tokens(u.text).length;
      if (!u._bs || !(nTok >= 5 || (nTok >= 4 && u._bs.score >= 0.12))) return true;
      var nb = null;
      for (var k = u.order - 1; k >= 0 && !nb; k--) if (utts[k].clip === u.clip && utts[k].sim) nb = utts[k];
      for (var k2 = u.order + 1; k2 < utts.length && !nb; k2++) if (utts[k2].clip === u.clip && utts[k2].sim) nb = utts[k2];
      if (!nb) return true;
      u.sim = { score: u._bs.score, pos: nb.sim.pos + 0.01 * (u.order - nb.order), from: nb.sim.to, to: nb.sim.to };
      u.scene = nb.scene;
      u.loose = true;
      result[nb.scene].push(u);
      return false;
    });
    var overlaps = function (u, v) {
      var ov = Math.min(u.sim.to, v.sim.to) - Math.max(u.sim.from, v.sim.from);
      var span = Math.max(1, Math.min(u.sim.to - u.sim.from, v.sim.to - v.sim.from));
      return ov / span > 0.5;
    };
    var nUtt = Math.max(1, utts.length);
    result = result.map(function (list) {
      // Gom các lần nói cùng một ý thành nhóm, mỗi nhóm giữ một lần hay nhất
      var groups = [];
      list.forEach(function (u) {
        var g = groups.filter(function (gr) { return gr.some(function (v) { return overlaps(u, v); }); })[0];
        if (g) g.push(u); else groups.push([u]);
      });
      var keep = groups.map(function (g) {
        if (g.length === 1) return g[0];
        var lo = Math.min.apply(null, g.map(function (u) { return u.sim.from; }));
        var hi = Math.max.apply(null, g.map(function (u) { return u.sim.to; }));
        var score = function (u) {
          var cover = (u.sim.to - u.sim.from) / Math.max(1, hi - lo);
          var words = Math.max(1, tokens(u.text).length);
          return u.sim.score * 0.45 + cover * 0.4 - (u.fillers || 0) / words * 0.5 + (u.order / nUtt) * 0.08;
        };
        return g.slice().sort(function (x, y) { return score(y) - score(x); })[0];
      });
      list.forEach(function (u) { if (keep.indexOf(u) === -1) { u.retake = true; dropped.push(u); } });
      return keep.sort(function (x, y) { return x.sim.pos - y.sim.pos || x.order - y.order; });
    });
    return { scenes: result, dropped: dropped };
  }

  /** Ghép ảnh/flycam vào cảnh theo tên file (VD: "ho-boi.jpg" → cảnh Tiện ích nhắc tới hồ bơi). */
  function matchBroll(name, scenes) {
    var tk = tokens(name.replace(/\.[a-z0-9]+$/i, '')).filter(function (w) { return w.length >= 2 && !/^(img|vid|dsc|mov|mp4|jpg|png|canh|video|clip|quay|anh|hinh|file|final|ban|cut|\d+)$/.test(w); });
    var best = -1, bs = 0;
    scenes.forEach(function (sc, si) {
      var hay = ' ' + norm([sc.title, sc.text, sc.shotNote, (sc.bigText || []).join(' ')].join(' ')) + ' ';
      var sc1 = 0;
      tk.forEach(function (w, i) {
        if (hay.indexOf(' ' + w + ' ') !== -1) sc1 += 1;
        if (tk[i + 1] && hay.indexOf(' ' + w + ' ' + tk[i + 1] + ' ') !== -1) sc1 += 2;
      });
      if (sc1 > bs) { bs = sc1; best = si; }
    });
    return best;
  }

  /** Lấy các chữ gốc (giữ dấu, giữ số) của kịch bản ứng với vùng [from, to) theo chỉ số chữ đã chuẩn hoá. */
  function scriptSpan(text, from, to) {
    var words = (text || '').replace(/[“”"]/g, '').split(/\s+/).filter(Boolean), out = [], k = 0;
    words.forEach(function (w) {
      var n = tokens(w).length;
      if (n && k + n > from && k < to) out.push(w);
      k += n;
    });
    return out.join(' ');
  }

  window.BdsAutoCut = {
    scriptSpan: scriptSpan,
    findSpeech: findSpeech, paceFor: paceFor, groupScenes: groupScenes, transcribe: transcribe,
    wordsInRange: wordsInRange, scriptWords: scriptWords,
    norm: norm, tokens: tokens, similarity: similarity, utterances: utterances,
    matchUtterances: matchUtterances, matchBroll: matchBroll
  };
})();
