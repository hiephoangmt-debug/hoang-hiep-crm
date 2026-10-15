/* Thị giác máy: nhận diện khuôn mặt (chữ bám theo người), tách người khỏi nền (chữ nằm sau người), tracking một điểm (chữ bám theo toà nhà). */
(function () {
  'use strict';

  var MP = 'https://cdn.jsdelivr.net/npm/@mediapipe/tasks-vision@0.10.14';
  var V = { face: null, seg: null, loading: null, failed: false };
  var stamp = 0;
  function nextTs() { stamp = Math.max(stamp + 1, performance.now()); return stamp; }

  function create(cls, fs, opts) {
    // Ưu tiên card đồ hoạ, không được thì chạy bằng CPU
    opts.baseOptions.delegate = 'GPU';
    return cls.createFromOptions(fs, opts).catch(function () {
      opts.baseOptions.delegate = 'CPU';
      return cls.createFromOptions(fs, opts);
    });
  }

  /** Tải bộ nhận diện (khoảng 5MB, lần đầu). Lỗi thì các hiệu ứng tự tắt, video vẫn xuất bình thường. */
  function load() {
    if (V.loading) return V.loading;
    V.loading = import(MP).then(function (m) {
      return m.FilesetResolver.forVisionTasks(MP + '/wasm').then(function (fs) {
        return Promise.all([
          create(m.FaceDetector, fs, {
            baseOptions: { modelAssetPath: 'https://storage.googleapis.com/mediapipe-models/face_detector/blaze_face_short_range/float16/1/blaze_face_short_range.tflite' },
            runningMode: 'VIDEO', minDetectionConfidence: 0.5
          }),
          create(m.ImageSegmenter, fs, {
            baseOptions: { modelAssetPath: 'https://storage.googleapis.com/mediapipe-models/image_segmenter/selfie_segmenter/float16/latest/selfie_segmenter.tflite' },
            runningMode: 'VIDEO', outputConfidenceMasks: true, outputCategoryMask: false
          })
        ]);
      });
    }).then(function (r) { V.face = r[0]; V.seg = r[1]; return true; })
      .catch(function () { V.failed = true; return false; });
    return V.loading;
  }

  function ready() { return !!(V.face && V.seg); }

  /**
   * Vị trí khuôn mặt trong khung hình video (toạ độ 0..1), đã làm mượt để không giật.
   * Chạy nhận diện tối đa ~12 lần/giây cho mỗi video.
   */
  function face(video) {
    if (!V.face || !video || !video.videoWidth || video.readyState < 2) return video && video._bdsFace || null;
    var now = performance.now();
    if (video._bdsFaceAt && now - video._bdsFaceAt < 80) return video._bdsFace || null;
    video._bdsFaceAt = now;
    try {
      var res = V.face.detectForVideo(video, nextTs());
      var d = res.detections && res.detections[0];
      if (d && d.boundingBox) {
        var b = d.boundingBox, vw = video.videoWidth, vh = video.videoHeight;
        var box = { x: b.originX / vw, y: b.originY / vh, w: b.width / vw, h: b.height / vh };
        var old = video._bdsFace;
        if (old) {
          var k = 0.35;
          box = { x: old.x + (box.x - old.x) * k, y: old.y + (box.y - old.y) * k, w: old.w + (box.w - old.w) * k, h: old.h + (box.h - old.h) * k };
        }
        video._bdsFace = box;
      }
    } catch (e) { /* bỏ qua khung lỗi */ }
    return video._bdsFace || null;
  }

  /** Mặt nạ người (canvas, kênh alpha = người) để vẽ chữ nằm sau người nói. ~15 lần/giây. */
  function personMask(video) {
    if (!V.seg || !video || !video.videoWidth || video.readyState < 2) return video && video._bdsMask || null;
    var now = performance.now();
    if (video._bdsMaskAt && now - video._bdsMaskAt < 66) return video._bdsMask || null;
    video._bdsMaskAt = now;
    try {
      V.seg.segmentForVideo(video, nextTs(), function (res) {
        var masks = res.confidenceMasks || [];
        var mk = masks[masks.length - 1]; // một mặt nạ: là người; hai mặt nạ: cái sau là người
        if (!mk) return;
        var w = mk.width, h = mk.height, data = mk.getAsFloat32Array();
        var c = video._bdsMask || document.createElement('canvas');
        if (c.width !== w || c.height !== h) { c.width = w; c.height = h; }
        var cx = c.getContext('2d'), img = cx.createImageData(w, h);
        for (var i = 0; i < data.length; i++) {
          var a = Math.max(0, Math.min(1, (data[i] - 0.35) / 0.3));
          img.data[i * 4 + 3] = a * 255;
        }
        cx.putImageData(img, 0, 0);
        video._bdsMask = c;
      });
    } catch (e) { /* bỏ qua */ }
    return video._bdsMask || null;
  }

  /* ---------- Tracking một điểm (chữ bám theo toà nhà trong flycam) ---------- */

  function gray(ctx, w, h) {
    var d = ctx.getImageData(0, 0, w, h).data, g = new Float32Array(w * h);
    for (var i = 0; i < w * h; i++) g[i] = d[i * 4] * 0.299 + d[i * 4 + 1] * 0.587 + d[i * 4 + 2] * 0.114;
    return g;
  }

  function seekTo(v, t) {
    return new Promise(function (res) {
      var done = false;
      var fin = function () { if (!done) { done = true; v.removeEventListener('seeked', fin); res(); } };
      v.addEventListener('seeked', fin);
      setTimeout(fin, 1500);
      v.currentTime = t;
    });
  }

  /**
   * Bám theo điểm (x, y) (toạ độ 0..1) từ giây t0 đến t1 của video bằng so khớp mẫu.
   * Trả về { pts: [{ t, x, y }] } theo thời gian trong video gốc.
   */
  function trackPoint(url, t0, t1, x, y, onProgress) {
    var v = document.createElement('video');
    v.muted = true;
    v.preload = 'auto';
    v.src = url;
    return new Promise(function (res, rej) {
      v.onloadeddata = res;
      v.onerror = function () { rej(new Error('Không mở được clip.')); };
    }).then(function () {
      var W = 320, H = Math.round(320 * v.videoHeight / v.videoWidth);
      var c = document.createElement('canvas');
      c.width = W; c.height = H;
      var ctx = c.getContext('2d', { willReadFrequently: true });
      var R = 10, S = 18, step = 1 / 12;
      var px = x * W, py = y * H, tmpl = null, pts = [];
      var t = t0;
      var grab = function (g) {
        var out = new Float32Array((2 * R + 1) * (2 * R + 1)), k = 0;
        for (var yy = -R; yy <= R; yy++) for (var xx = -R; xx <= R; xx++) {
          var X = Math.min(W - 1, Math.max(0, Math.round(px + xx))), Y = Math.min(H - 1, Math.max(0, Math.round(py + yy)));
          out[k++] = g[Y * W + X];
        }
        return out;
      };
      var loop = function () {
        if (t > t1) return Promise.resolve({ pts: pts });
        return seekTo(v, t).then(function () {
          ctx.drawImage(v, 0, 0, W, H);
          var g = gray(ctx, W, H);
          if (!tmpl) tmpl = grab(g);
          else {
            // Tìm vị trí giống mẫu nhất quanh vị trí cũ
            var best = Infinity, bx = px, by = py;
            for (var dy = -S; dy <= S; dy++) for (var dx = -S; dx <= S; dx++) {
              var cx = Math.round(px + dx), cy = Math.round(py + dy);
              if (cx - R < 0 || cy - R < 0 || cx + R >= W || cy + R >= H) continue;
              var sad = 0, k = 0;
              for (var yy = -R; yy <= R && sad < best; yy++) {
                var row = (cy + yy) * W + cx;
                for (var xx = -R; xx <= R; xx++) sad += Math.abs(g[row + xx] - tmpl[k++]);
              }
              if (sad < best) { best = sad; bx = cx; by = cy; }
            }
            px = bx; py = by;
            // Cập nhật mẫu từ từ để theo được khi góc nhìn đổi
            var fresh = grab(g);
            for (var q = 0; q < tmpl.length; q++) tmpl[q] = tmpl[q] * 0.85 + fresh[q] * 0.15;
          }
          pts.push({ t: t, x: px / W, y: py / H });
          if (onProgress) onProgress((t - t0) / Math.max(0.1, t1 - t0));
          t += step;
          return loop();
        });
      };
      return loop();
    }).then(function (r) { v.removeAttribute('src'); return r; });
  }

  /** Vị trí điểm đã tracking tại thời điểm (giây trong video gốc), có nội suy. */
  function pointAt(track, srcT) {
    var p = track.pts;
    if (!p || !p.length) return { x: track.x, y: track.y };
    if (srcT <= p[0].t) return p[0];
    for (var i = 1; i < p.length; i++) {
      if (srcT <= p[i].t) {
        var a = p[i - 1], b = p[i], k = (srcT - a.t) / Math.max(0.001, b.t - a.t);
        return { x: a.x + (b.x - a.x) * k, y: a.y + (b.y - a.y) * k };
      }
    }
    return p[p.length - 1];
  }

  window.BdsVision = { load: load, ready: ready, face: face, personMask: personMask, trackPoint: trackPoint, pointAt: pointAt, failed: function () { return V.failed; } };
})();
