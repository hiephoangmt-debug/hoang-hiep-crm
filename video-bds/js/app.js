/* Điều khiển giao diện: kịch bản theo cảnh, quay và ghép, giọng đọc, xem thử, xuất video đầy đủ / trailer / từng cảnh. */
(function () {
  'use strict';

  var $ = function (id) { return document.getElementById(id); };
  var STEPS = ['Thông tin', 'Kịch bản', 'Quay & ghép', 'Giọng đọc', 'Hiệu ứng & nhạc', 'Xuất video'];
  var REQUIRED = { loai: 'Loại BĐS', viTri: 'Vị trí', gia: 'Giá', moiGioi: 'Tên môi giới', sdt: 'Số điện thoại' };
  var STORE_KEY = 'video-bds-v2';

  var state = {
    step: 1,
    info: {},
    logo: null,
    scenes: [],
    style: 'chuyen-nghiep',
    variant: 0,
    voiceMode: 'clip',
    music: { mood: 'none', buffer: null, name: '', vol: 45 },
    settings: {
      format: '9:16', theme: 'vang', transition: 'mix', textFx: 'marker', subStyle: 'kinetic', beauty: 'vua', pace: 'auto', endStyle: 'pill', sfx: true, subtitles: true,
      grade: 'dien-anh', leak: true, grain: true, vignette: true, pip: true, faceTrack: true, textBehind: true, nameTag: true,
      introCard: true, endCard: true, priceTag: true, autoTrim: true
    },
    previewKind: 'full'
  };

  var audioCtx = null;
  function getAudioCtx() {
    if (!audioCtx) audioCtx = new (window.AudioContext || window.webkitAudioContext)();
    return audioCtx;
  }

  function toast(msg, ms) {
    var t = $('toast');
    t.textContent = msg;
    t.hidden = false;
    clearTimeout(toast._t);
    toast._t = setTimeout(function () { t.hidden = true; }, ms || 3200);
  }

  function fmtTime(s) {
    s = Math.max(0, Math.round(s));
    return Math.floor(s / 60) + ':' + ('0' + s % 60).slice(-2);
  }

  function fmtSec(s) { return (Math.round(s * 10) / 10).toString().replace('.', ','); }

  function esc(s) {
    return String(s == null ? '' : s).replace(/[&<>"]/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]; });
  }

  function newScene(o) {
    o = o || {};
    return {
      title: o.title || '', text: o.text || '', bigText: o.bigText || [], shotNote: o.shotNote || '',
      media: o.media || [], voice: null, durOverride: o.durOverride || null, showTitle: !!o.showTitle, quick: !!o.quick,
      layout: o.layout || 'auto'
    };
  }

  /* ---------- Lưu / đọc (chỉ chữ, không lưu ảnh/clip) ---------- */

  var saveTimer = null;
  function save() {
    clearTimeout(saveTimer);
    saveTimer = setTimeout(function () {
      try {
        localStorage.setItem(STORE_KEY, JSON.stringify({
          info: state.info, style: state.style, settings: state.settings, voiceMode: state.voiceMode,
          mood: state.music.mood, vol: state.music.vol, helpSeen: true, v3: true, v4: true, v5: true, v6: true,
          scenes: state.scenes.map(function (s) {
            return { title: s.title, text: s.text, bigText: s.bigText, shotNote: s.shotNote, durOverride: s.durOverride, showTitle: s.showTitle, quick: s.quick, layout: s.layout };
          })
        }));
      } catch (e) { /* trình duyệt chặn lưu trữ: bỏ qua */ }
    }, 300);
  }

  function load() {
    try {
      var d = JSON.parse(localStorage.getItem(STORE_KEY) || 'null');
      if (!d) return false;
      state.info = d.info || {};
      state.style = d.style || state.style;
      var saved = d.settings || {};
      if (!d.v3) { delete saved.subStyle; delete saved.transition; delete saved.textFx; } // bản cũ: dùng kiểu mới mặc định
      Object.assign(state.settings, saved);
      state.voiceMode = d.voiceMode || state.voiceMode;
      // Bản cũ: bỏ nhạc nền tự tạo, mặc định không nhạc
      state.music.mood = d.v6 && window.BdsAudio.MOODS[d.mood] ? d.mood : 'none';
      state.music.vol = d.v5 && d.vol != null ? d.vol : state.music.vol; // bản cũ: dùng mức nhạc mới nhỏ hơn
      state.scenes = (d.scenes || []).map(newScene);
      return !!d.helpSeen;
    } catch (e) { return false; }
  }

  /* ---------- Dự án → dòng thời gian ---------- */

  function project() {
    return { info: state.info, logo: state.logo, devLogo: state.devLogo, scenes: state.scenes, settings: state.settings, voiceMode: state.voiceMode };
  }

  function timeline(kind, idx) {
    var p = project();
    if (kind === 'trailer') return window.BdsTimeline.buildTrailer(p);
    if (kind === 'scene') return window.BdsTimeline.buildScene(p, idx);
    return window.BdsTimeline.buildFull(p);
  }

  /* ---------- Các bước ---------- */

  function renderStepper() {
    var nav = $('stepper');
    nav.innerHTML = '';
    STEPS.forEach(function (name, i) {
      var b = document.createElement('button');
      b.type = 'button';
      b.innerHTML = '<span class="n">' + (i + 1) + '</span><span class="lbl">' + name + '</span>';
      if (i + 1 === state.step) b.className = 'active';
      else if (i + 1 < state.step) b.className = 'done';
      b.onclick = function () { goStep(i + 1); };
      nav.appendChild(b);
    });
  }

  function missingInfo() {
    return Object.keys(REQUIRED).filter(function (k) { return !String(state.info[k] || '').trim(); });
  }

  function goStep(n) {
    if (n > 1 && state.step === 1) {
      var miss = missingInfo();
      if (miss.length) {
        toast('Bạn cần điền: ' + miss.map(function (k) { return REQUIRED[k]; }).join(', '));
        miss.forEach(function (k) {
          var el = document.querySelector('[data-info="' + k + '"]');
          if (el) el.style.borderColor = 'var(--danger)';
        });
        return;
      }
    }
    if (n > 2 && !state.scenes.length) {
      toast('Hãy tạo kịch bản ở Bước 2 trước nhé.');
      n = 2;
    }
    state.step = Math.max(1, Math.min(STEPS.length, n));
    if (state.step === 2) renderScenes();
    if (state.step === 3) renderShoot();
    if (state.step === 4) refreshVoiceUI();
    if (state.step === 6) renderChecklist();
    showStep();
  }

  function showStep() {
    document.querySelectorAll('.step').forEach(function (s) {
      s.classList.toggle('active', +s.dataset.step === state.step);
    });
    $('btnPrev').style.visibility = state.step === 1 ? 'hidden' : 'visible';
    $('btnNext').style.visibility = state.step === STEPS.length ? 'hidden' : 'visible';
    renderStepper();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  /* ---------- Bước 1: thông tin ---------- */

  function bindInfo() {
    document.querySelectorAll('[data-info]').forEach(function (el) {
      var k = el.dataset.info;
      if (state.info[k] != null) el.value = state.info[k];
      else state.info[k] = el.value;
      el.addEventListener('input', function () {
        state.info[k] = el.value;
        el.style.borderColor = '';
        save();
        schedulePreview();
      });
    });
    $('logoInput').addEventListener('change', function (e) {
      var f = e.target.files[0];
      if (!f) return;
      var img = new Image();
      img.onload = function () { state.logo = img; schedulePreview(); };
      img.src = URL.createObjectURL(f);
    });
    $('devLogoInput').addEventListener('change', function (e) {
      var f = e.target.files[0];
      if (!f) return;
      var img = new Image();
      img.onload = function () { state.devLogo = img; schedulePreview(); toast('Đã thêm logo chủ đầu tư. Logo sẽ hiện khi người nói nhắc tới tên chủ đầu tư.'); };
      img.src = URL.createObjectURL(f);
    });
  }

  function setInfo(info) {
    state.info = Object.assign({}, info);
    document.querySelectorAll('[data-info]').forEach(function (el) {
      el.value = state.info[el.dataset.info] || '';
      el.style.borderColor = '';
    });
    if (info.quyMo || info.ketNoi || info.tienIch || info.chinhSach) $('projectMore').open = true;
    save();
  }

  /* ---------- Ảnh & clip ---------- */

  /** Phân tích âm thanh clip: có tiếng không, và cắt khoảng lặng đầu/cuối. */
  function analyzeAudio(item, blob) {
    item.analyzing = true;
    return blob.arrayBuffer().then(function (ab) { return getAudioCtx().decodeAudioData(ab); }).then(function (buf) {
      var sr = buf.sampleRate, win = Math.max(1, Math.floor(sr * 0.05)), n = Math.floor(buf.length / win);
      var chans = [];
      for (var c = 0; c < buf.numberOfChannels; c++) chans.push(buf.getChannelData(c));
      var rms = new Float32Array(n);
      for (var w = 0; w < n; w++) {
        var sum = 0;
        for (var ci = 0; ci < chans.length; ci++) {
          var d = chans[ci];
          for (var j = w * win; j < (w + 1) * win; j += 4) sum += d[j] * d[j];
        }
        rms[w] = Math.sqrt(sum / (win / 4) / chans.length);
      }
      var sorted = Array.prototype.slice.call(rms).sort(function (a, b) { return a - b; });
      var floor = sorted[Math.floor(n * 0.2)] || 0, p95 = sorted[Math.floor(n * 0.95)] || 0;
      var dur = isFinite(item.el.duration) && item.el.duration ? item.el.duration : buf.duration;
      item.dur = dur;
      item.hasAudio = p95 > 0.01;
      item.trimIn = 0;
      item.trimOut = dur;
      if (item.hasAudio) {
        var thr = Math.max(0.006, floor + (p95 - floor) * 0.15);
        var first = -1, last = -1, active = [];
        for (var k = 0; k < n; k++) if (rms[k] >= thr) { if (first < 0) first = k; last = k; active.push(rms[k]); }
        // Cân âm lượng giọng nói về cùng một mức (giọng nhỏ thì tăng, to thì giảm)
        active.sort(function (x, y) { return x - y; });
        var med = active[Math.floor(active.length / 2)] || p95;
        item.voiceGain = Math.max(0.5, Math.min(4, 0.12 / med));
        if (first >= 0) {
          var a = Math.max(0, first * 0.05 - 0.2), b = Math.min(dur, (last + 1) * 0.05 + 0.35);
          if (b - a > 0.8) { item.trimIn = a; item.trimOut = b; }
        }
      }
      if (item.keepAudio == null) item.keepAudio = item.hasAudio;
    }).catch(function () {
      item.hasAudio = false;
      item.keepAudio = false;
      item.trimIn = 0;
      item.trimOut = item.dur;
    }).then(function () {
      item.analyzing = false;
      if (state.step === 3) renderShoot();
      schedulePreview();
    });
  }

  /** Tạo một ảnh/clip từ file (hoặc blob vừa quay). */
  function createMedia(blob, name, opts) {
    opts = opts || {};
    return new Promise(function (resolve) {
      var url = URL.createObjectURL(blob);
      var type = blob.type || '';
      if (type.indexOf('video') === 0 || /\.(mp4|mov|webm|m4v)$/i.test(name || '')) {
        var v = document.createElement('video');
        v.muted = true;
        v.playsInline = true;
        v.preload = 'auto';
        var item = { el: v, isVideo: true, url: url, name: name, keepAudio: opts.keepAudio, hasAudio: false, trimIn: 0, trimOut: 0, dur: 0 };
        v.onloadedmetadata = function () {
          item.dur = isFinite(v.duration) ? v.duration : (opts.duration || 4);
          item.trimOut = item.dur;
        };
        var settled = false;
        var fail = function () { if (settled) return; settled = true; if (!opts.quiet) toast('Không đọc được clip ' + name + '. Hãy thử file MP4 (H.264).'); resolve(null); };
        // Máy không giải mã được hình (VD: HEVC) thì video không có kích thước khung hình
        v.onloadeddata = function () {
          if (settled) return;
          if (!v.videoWidth) { fail(); return; }
          settled = true;
          resolve(item);
          if (!opts.skipAnalyze) analyzeAudio(item, blob);
        };
        setTimeout(fail, 30000);
        v.onerror = fail;
        v.addEventListener('seeked', schedulePreview);
        v.src = url;
      } else if (type.indexOf('image') === 0 || /\.(jpe?g|png|webp|gif|heic)$/i.test(name || '')) {
        var img = new Image();
        img.onload = function () { resolve({ el: img, isVideo: false, url: url, name: name }); };
        img.onerror = function () { toast('Không đọc được ảnh ' + name + '. Hãy dùng JPG hoặc PNG.'); resolve(null); };
        img.src = url;
      } else {
        resolve(null);
      }
    });
  }

  function addFilesToScene(si, files) {
    var list = Array.prototype.slice.call(files || []);
    if (!list.length) return;
    Promise.all(list.map(function (f) { return createMedia(f, f.name); })).then(function (items) {
      items.forEach(function (it) { if (it) state.scenes[si].media.push(it); });
      renderShoot();
      schedulePreview();
      toast('Đã thêm ' + items.filter(Boolean).length + ' ảnh/clip vào cảnh ' + (si + 1) + '.');
    });
  }

  /* ---------- Bước 2: kịch bản ---------- */

  function confirmReplace() {
    var hasMedia = state.scenes.some(function (s) { return s.media.length; });
    return !state.scenes.length || window.confirm('Thay kịch bản hiện tại bằng kịch bản mới?' + (hasMedia ? ' Ảnh/clip đã thêm sẽ được giữ theo thứ tự cảnh.' : ''));
  }

  function setScenes(scenes, keepMedia) {
    var old = state.scenes;
    state.scenes = scenes.map(newScene);
    if (keepMedia) state.scenes.forEach(function (s, i) { if (old[i] && !s.media.length) s.media = old[i].media; });
    renderScenes();
    save();
    schedulePreview();
  }

  function startProject() {
    if (!confirmReplace()) return;
    setScenes(window.ScriptGen.generateProject(state.info), true);
    toast('Đã viết kịch bản ' + state.scenes.length + ' cảnh. Bạn sửa lại cho đúng giọng của mình nhé!', 4000);
  }

  function importScenes(scenes) {
    if (!scenes.length) { toast('Không đọc được cảnh nào. Kiểm tra lại bảng có cột Cảnh và Lời thoại.', 5000); return; }
    if (!confirmReplace()) return;
    setScenes(scenes, true);
    $('sheetBox').hidden = true;
    toast('Đã nhập ' + scenes.length + ' cảnh từ bảng kịch bản.', 4000);
  }

  function importFromLink() {
    var url = window.ScriptGen.sheetCsvUrl($('sheetLink').value);
    if (!url) { toast('Link chưa đúng. Hãy dán link dạng https://docs.google.com/spreadsheets/d/...'); return; }
    $('btnSheetLink').disabled = true;
    fetch(url).then(function (r) {
      if (!r.ok) throw new Error(r.status);
      return r.text();
    }).then(function (csv) {
      if (/^\s*</.test(csv)) throw new Error('private');
      importScenes(window.ScriptGen.tableToScenes(window.ScriptGen.parseTable(csv)));
    }).catch(function () {
      toast('Không mở được bảng. Hãy bật chia sẻ “Bất kỳ ai có đường liên kết”, hoặc copy bảng rồi dán vào ô bên dưới.', 6000);
    }).then(function () { $('btnSheetLink').disabled = false; });
  }

  /* ---------- Tự dựng từ một video dài ---------- */

  var autoFile = null;

  function autoStatus(t) { $('autoStatus').textContent = t || ''; }

  function pickVideo(e) {
    var f = e.target.files[0];
    e.target.value = '';
    if (!f) return;
    autoFile = f;
    $('autoName').textContent = '🎬 ' + f.name;
    $('autoInfo').textContent = '(' + (f.size / 1048576).toFixed(0) + ' MB)';
    $('autoBox').hidden = false;
    $('sheetBox').hidden = true;
    autoStatus('');
    $('autoBox').scrollIntoView({ behavior: 'smooth', block: 'center' });
  }

  /** Mở thêm một bản của clip để tua sẵn đoạn sau (chỗ cắt không giật). Quá 8 giây thì bỏ qua, vẫn dựng được. */
  function loadExtraVideo(url) {
    return new Promise(function (resolve) {
      var v = document.createElement('video');
      var done = false;
      var finish = function (x) { if (!done) { done = true; resolve(x); } };
      v.muted = true;
      v.playsInline = true;
      v.preload = 'auto';
      v.onloadeddata = function () { finish(v); };
      v.onerror = function () { finish(null); };
      setTimeout(function () { finish(null); }, 8000);
      v.addEventListener('seeked', schedulePreview);
      v.src = url;
    });
  }

  function autoBuild() {
    if (!autoFile) return;
    if (!confirmReplace()) return;
    var f = autoFile;
    var subMode = (document.querySelector('input[name=autoSub]:checked') || {}).value || 'script';
    var minPause = parseFloat($('autoPause').value) || 0.4;
    var maxScene = Math.max(5, parseFloat($('autoMax').value) || 14);
    $('btnAutoGo').disabled = true;
    autoStatus('Đang đọc video…');
    var base, buf, res;
    createMedia(f, f.name, { skipAnalyze: true }).then(function (item) {
      if (!item || !item.isVideo) throw new Error('Không đọc được video này. Hãy thử file MP4.');
      base = item;
      autoStatus('Đang quét giọng nói…');
      return f.arrayBuffer().then(function (ab) { return getAudioCtx().decodeAudioData(ab); });
    }).then(function (b) {
      buf = b;
      res = window.BdsAutoCut.findSpeech(buf, { minPause: minPause });
      if (!res.segments.length) throw new Error('Không tìm thấy giọng nói trong video.');
      // Thẻ video thứ hai để tua sẵn đoạn tiếp theo, chỗ cắt không bị giật
      return loadExtraVideo(base.url);
    }).then(function (twin) {
      var words = [];
      var text = $('autoScript').value.trim();
      if (subMode === 'script' && text) words = window.BdsAutoCut.scriptWords(text, res.segments);
      if (subMode === 'asr') {
        return window.BdsAutoCut.transcribe(buf, autoStatus).then(function (w) { return [twin, w]; }).catch(function () {
          toast('Không chạy được nhận dạng giọng nói trên máy này. Bạn có thể dán lời thoại để làm phụ đề.', 6000);
          return [twin, []];
        });
      }
      return [twin, words];
    }).then(function (r) {
      var twin = r[0], words = r[1];
      var groups = window.BdsAutoCut.groupScenes(res.segments, { maxScene: maxScene });
      var dur = base.dur || buf.duration;
      var group = 'auto' + Date.now();
      var k = 0;
      var scenes = groups.map(function (segs, gi) {
        var media = segs.map(function (sg) {
          var idx = k++;
          return {
            el: idx % 2 && twin ? twin : base.el, isVideo: true, url: base.url, name: f.name,
            keepAudio: true, hasAudio: true, trimIn: sg[0], trimOut: sg[1], dur: dur, fixed: true,
            voiceGain: res.voiceGain, speed: res.speed, group: group, segIndex: idx, words: window.BdsAutoCut.wordsInRange(words, sg[0], sg[1])
          };
        });
        var sceneWords = [];
        media.forEach(function (m) { sceneWords = sceneWords.concat(m.words); });
        return newScene({
          title: 'Đoạn ' + (gi + 1), media: media,
          text: sceneWords.map(function (w) { return w.w; }).join(' '),
          shotNote: 'Thêm ảnh phối cảnh hoặc clip flycam vào đoạn này để xen vào lời nói (tiếng vẫn chạy liên tục).'
        });
      });
      var kept = res.segments.reduce(function (a, sg) { return a + sg[1] - sg[0]; }, 0);
      state.voiceMode = 'clip';
      state.settings.introCard = false;
      $('introToggle').checked = false;
      setScenes(scenes, false);
      refreshVoiceUI();
      $('autoBox').hidden = true;
      toast('✂️ Đã cắt ' + (res.segments.length - 1) + ' chỗ ngừng: ' + fmtTime(dur) + ' → ' + fmtTime(kept) + ', chia ' + scenes.length +
        ' cảnh. Sang Bước 3 để thêm phối cảnh/flycam.', 7000);
    }).catch(function (e) {
      toast(e && e.message ? e.message : 'Có lỗi khi dựng video.', 6000);
    }).then(function () {
      $('btnAutoGo').disabled = false;
      autoStatus('');
    });
  }

  /* ---------- Tự dựng toàn bộ theo kịch bản (nhiều clip + ảnh phối cảnh) ---------- */

  var assembleFiles = [];

  function assembleProgress(p, label) {
    var box = $('assembleProgress');
    box.hidden = p == null;
    if (p == null) return;
    box.querySelector('.bar').style.width = Math.round(p * 100) + '%';
    box.querySelector('span').textContent = label;
  }

  function setAssembleFiles(files) {
    assembleFiles = Array.prototype.slice.call(files || []).filter(function (f) { return /^(video|image)\//.test(f.type) || /\.(mp4|mov|webm|m4v|jpe?g|png|webp)$/i.test(f.name); });
    var v = assembleFiles.filter(function (f) { return /^video|\.(mp4|mov|webm|m4v)$/i.test(f.type || f.name); }).length;
    $('assembleFiles').textContent = assembleFiles.length ? 'Đã chọn ' + v + ' video và ' + (assembleFiles.length - v) + ' ảnh.' : '';
    $('btnAssemble').disabled = !assembleFiles.length;
  }

  function isVideoFile(f) { return /^video\//.test(f.type) || /\.(mp4|mov|webm|m4v)$/i.test(f.name); }

  /** Clip có người nói hay chỉ là cảnh quay (flycam, phối cảnh)? */
  function looksLikeTalk(f, sp) {
    if (/flycam|drone|broll|b-roll|phoi.?canh|toan.?canh|canh.?quay/i.test(window.BdsAutoCut.norm(f.name).replace(/ /g, '-'))) return false;
    if (!sp || !sp.segments.length) return false;
    var cover = sp.segments.reduce(function (a, s2) { return a + s2[1] - s2[0]; }, 0) / sp.duration;
    return sp.segments.length >= 2 || (cover > 0.15 && cover < 0.97);
  }

  function assemble(list, opts) {
    opts = opts || {};
    list = list || assembleFiles;
    if (!list.length) return Promise.resolve(false);
    if (!state.scenes.length) { toast('Hãy tạo kịch bản ở Bước 2 trước (nhập từ Google Sheets hoặc tự viết).', 5000); return Promise.resolve(false); }
    var hasMedia = state.scenes.some(function (sc) { return sc.media.length; });
    if (hasMedia && !opts.force && !window.confirm('Thay toàn bộ ảnh/clip hiện có bằng bản tự dựng?')) return Promise.resolve(false);
    var AC = window.BdsAutoCut;
    var files = list.slice().sort(function (a, b) { return a.name.localeCompare(b.name, undefined, { numeric: true }) || a.lastModified - b.lastModified; });
    var videos = files.filter(isVideoFile), images = files.filter(function (f) { return !isVideoFile(f); });
    var minPause = opts.minPause || parseFloat($('assemblePause').value) || 0.4;
    var useAsr = opts.asr != null ? opts.asr : $('assembleAsr').checked;
    var fastAsr = (opts.asrMode || 'fast') === 'fast';
    var progress = opts.progress || assembleProgress;
    var clips = [], broll = [], failed = [], noAudio = [];
    $('assembleReport').innerHTML = '';
    var steps = videos.length * (useAsr ? 2 : 1) + images.length + 1, done = 0;
    var tick = function (label) { done++; progress(Math.min(1, done / steps), label); };
    $('btnAssemble').disabled = true;
    $('assembleReport').hidden = true;
    progress(0, 'Bắt đầu…');

    // 1. Đọc và quét giọng từng video
    var chain = Promise.resolve();
    videos.forEach(function (f, i) {
      chain = chain.then(function () {
        progress(done / steps, 'Quét giọng nói clip ' + (i + 1) + '/' + videos.length + ': ' + f.name);
        return createMedia(f, f.name, { skipAnalyze: true, quiet: true }).then(function (item) {
          if (!item) { failed.push(f.name); return null; }
          return f.arrayBuffer().then(function (ab) { return getAudioCtx().decodeAudioData(ab); })
            .then(function (buf) { return { item: item, buf: buf, sp: AC.findSpeech(buf, { minPause: minPause }) }; })
            .catch(function () { noAudio.push(f.name); return { item: item, buf: null, sp: null }; });
        }).then(function (r) {
          tick('Đã quét ' + f.name);
          if (!r) return;
          var role = opts.roleOf ? opts.roleOf(f) : null;
          var talkClip = role === 'talk' ? !!(r.sp && r.sp.segments.length) : (role === 'broll' ? false : looksLikeTalk(f, r.sp));
          if (role === 'talk' && !talkClip) noAudio.push(f.name);
          if (role === 'broll') noAudio = noAudio.filter(function (n) { return n !== f.name; }); // tư liệu không cần tiếng
          if (talkClip) clips.push({ file: f, item: r.item, buf: r.buf, segments: r.sp.segments, voiceGain: r.sp.voiceGain, duration: r.sp.duration, speed: r.sp.speed, rate: r.sp.rate });
          else { r.item.keepAudio = false; r.item.hasAudio = false; broll.push({ file: f, item: r.item }); }
        });
      });
    });
    images.forEach(function (f) {
      chain = chain.then(function () {
        return createMedia(f, f.name).then(function (item) { if (item) broll.push({ file: f, item: item }); tick('Đã đọc ảnh ' + f.name); });
      });
    });
    // 2. Nghe và chép lời để biết đoạn nào thuộc cảnh nào
    var asrOk = useAsr;
    chain = chain.then(function () {
      if (!useAsr || !clips.length) return;
      var c2 = Promise.resolve();
      clips.forEach(function (c, i) {
        c2 = c2.then(function () {
          return AC.transcribe(c.buf, function (msg) { progress(done / steps, 'Clip ' + (i + 1) + '/' + clips.length + ': ' + msg); }, { maxSec: fastAsr ? 25 : 0 })
            .then(function (w) { c.words = w; tick('Đã chép lời ' + c.file.name); });
        });
      });
      return c2.catch(function () {
        asrOk = false;
        toast('Không chạy được nhận dạng giọng nói trên máy này, các clip sẽ được xếp theo thứ tự tên file.', 6000);
      });
    });
    // 3. Xếp vào cảnh và dựng
    return chain.then(function () {
      // Mở lần lượt từng clip (không mở cùng lúc để máy không quá tải)
      return clips.reduce(function (p, c, i) {
        return p.then(function () {
          progress(0.98, 'Đang ghép theo kịch bản… (chuẩn bị clip ' + (i + 1) + '/' + clips.length + ')');
          return loadExtraVideo(c.item.url).then(function (tw) { c.twin = tw; });
        });
      }, Promise.resolve());
    }).then(function () {
      var scenes = state.scenes;
      var perScene = scenes.map(function () { return []; });
      var dropped = [];
      if (asrOk && clips.some(function (c) { return c.words && c.words.length; })) {
        var utts = [];
        if (fastAsr) {
          // Nghe nhanh: mỗi clip là một khối, xếp theo lời nói ở 25 giây đầu
          utts = clips.map(function (c) {
            return { clip: c, segs: c.segments, start: c.segments[0][0], end: c.segments[c.segments.length - 1][1],
              text: (c.words || []).map(function (w) { return w.w; }).join(' '), partial: true };
          });
        } else clips.forEach(function (c) { utts = utts.concat(AC.utterances(c, 0.7)); });
        var m = AC.matchUtterances(utts, scenes);
        perScene = m.scenes;
        dropped = m.dropped;
      } else {
        var spoken = scenes.filter(function (sc) { return (sc.text || '').trim(); }).length;
        if (clips.length >= spoken) {
          // Mỗi clip là một cảnh: clip thứ i vào cảnh thứ i (theo tên file)
          clips.forEach(function (c, i) {
            perScene[Math.min(i, scenes.length - 1)].push({ clip: c, segs: c.segments, start: c.segments[0][0], end: c.segments[c.segments.length - 1][1] });
          });
        } else {
          // Ít clip, nhiều cảnh (quay liền mạch): dùng HẾT lời nói, chia lần lượt theo độ dài lời thoại từng cảnh
          var all = [];
          clips.forEach(function (c) { all = all.concat(AC.utterances(c, 0.7)); });
          var durOf = function (u) { return u.segs.reduce(function (a, sg) { return a + sg[1] - sg[0]; }, 0); };
          var totalDur = all.reduce(function (a, u) { return a + durOf(u); }, 0) || 1;
          var weights = scenes.map(function (sc) { return (sc.text || '').trim().split(/\s+/).filter(Boolean).length; });
          var totalW = weights.reduce(function (a, b) { return a + b; }, 0) || 1;
          var cum = 0;
          all.forEach(function (u) {
            var d = durOf(u), frac = (cum + d / 2) / totalDur, acc = 0, k = 0;
            for (; k < scenes.length; k++) { acc += weights[k] / totalW; if (frac <= acc + 1e-9 && weights[k]) break; }
            perScene[Math.min(k, scenes.length - 1)].push(u);
            cum += d;
          });
        }
      }
      var segIdx = 0;
      scenes.forEach(function (sc, si) {
        var media = [];
        perScene[si].forEach(function (u) {
          var c = u.clip;
          var span = u.sim && !u.partial ? AC.scriptSpan(sc.text, u.sim.from, u.sim.to) : '';
          var uw = span ? window.BdsTimeline.distributeWords(span, u.segs) : null;
          u.segs.forEach(function (sg) {
            var idx = segIdx++;
            media.push({
              el: idx % 2 && c.twin ? c.twin : c.item.el, isVideo: true, url: c.item.url, name: c.file.name,
              keepAudio: true, hasAudio: true, trimIn: sg[0], trimOut: sg[1], dur: c.duration, fixed: true,
              voiceGain: c.voiceGain, speed: c.speed, group: 'clip:' + c.file.name, segIndex: idx,
              words: uw ? AC.wordsInRange(uw, sg[0], sg[1]) : null
            });
          });
        });
        sc.media = media;
        sc.voice = null;
        sc.durOverride = null;
      });
      // Ảnh phối cảnh / flycam: theo tên file, còn lại ưu tiên cảnh chưa quay được
      var leftovers = [];
      broll.forEach(function (b) {
        var si = AC.matchBroll(b.file.name, scenes);
        if (si >= 0) scenes[si].media.push(b.item); else leftovers.push(b.item);
      });
      var need = function (sc) { return (sc.media.some(function (m) { return m.fixed; }) ? 10 : 0) + sc.media.filter(function (m) { return !m.fixed; }).length; };
      leftovers.forEach(function (it) {
        var best = scenes.slice().sort(function (a, b) { return need(a) - need(b); })[0];
        best.media.push(it);
      });
      state.voiceMode = 'clip';
      state.settings.subStyle = state.settings.subStyle || 'kinetic';
      if (clips.length) { state.settings.introCard = false; $('introToggle').checked = false; }
      renderShoot();
      renderScenes();
      refreshVoiceUI();
      schedulePreview();
      // 4. Báo cáo
      var lines = scenes.map(function (sc, si) {
        var talk = sc.media.filter(function (m) { return m.fixed; });
        var other = sc.media.length - talk.length;
        var secs = talk.reduce(function (a, m) { return a + m.trimOut - m.trimIn; }, 0);
        var t = 'Cảnh ' + (si + 1) + ' ' + window.BdsTimeline.cleanTitle(sc.title) + ': ';
        if (talk.length) return '<div>✅ ' + esc(t) + talk.length + ' đoạn nói (' + fmtSec(secs) + 's)' + (other ? ' + ' + other + ' phối cảnh/flycam xen vào' : '') + '</div>';
        if (other) return '<div>🏙 ' + esc(t) + 'chưa có cảnh nói, dùng ' + other + ' phối cảnh/flycam + phụ đề theo kịch bản</div>';
        return '<div class="warn">⚠️ ' + esc(t) + 'chưa có hình, sẽ hiện chữ trên nền màu. Thêm ảnh phối cảnh để đẹp hơn.</div>';
      });
      clips.forEach(function (c) {
        var total = c.segments.reduce(function (a, sg) { return a + sg[1] - sg[0]; }, 0), used = 0;
        scenes.forEach(function (sc) { sc.media.forEach(function (m) { if (m.fixed && m.name === c.file.name) used += m.trimOut - m.trimIn; }); });
        lines.push('<div class="muted">🎬 ' + esc(c.file.name) + ': dùng ' + fmtSec(used) + 's / ' + fmtSec(total) + 's lời nói</div>');
      });
      if (failed.length) lines.push('<div class="warn">⚠️ Không mở được ' + failed.length + ' video: ' + esc(failed.join(', ')) +
        '. Thường do video iPhone định dạng HEVC. Cách sửa: dùng Chrome bản mới, hoặc trên iPhone vào Cài đặt → Camera → Định dạng → chọn “Tương thích nhất” rồi quay lại.</div>');
      if (noAudio.length) lines.push('<div class="muted">🔇 Không có tiếng (dùng làm cảnh quay phủ lên): ' + esc(noAudio.filter(function (x, i) { return noAudio.indexOf(x) === i; }).join(', ')) + '. Nếu đây là clip có người nói, hãy đổi sang file MP4.</div>');
      var restarts = 0;
      perScene.forEach(function (l) { l.forEach(function (u) { if (u.restarted) restarts++; }); });
      if (dropped.length || restarts) {
        var retakes = dropped.filter(function (u) { return u.retake; }).length;
        var parts = [];
        if (retakes) parts.push('bỏ ' + retakes + ' lần nói trùng (giữ lần nói hay nhất)');
        if (dropped.length - retakes) parts.push('bỏ ' + (dropped.length - retakes) + ' đoạn nói ngoài kịch bản');
        if (restarts) parts.push('cắt ' + restarts + ' chỗ vấp đầu câu');
        lines.push('<div class="muted">✂️ Đã ' + parts.join(', ') + '.</div>');
      }
      if (!asrOk && clips.length) lines.push('<div class="muted">ℹ️ Clip được xếp theo thứ tự tên file. Kiểm tra lại bên dưới, dùng ô “Chuyển sang cảnh” nếu cần.</div>');
      $('assembleReport').innerHTML = lines.join('');
      $('assembleReport').hidden = false;
      if (!opts.quiet) toast('🤖 Đã dựng xong! Bấm ▶ Xem thử, rồi sang Bước 6 để xuất video.', 6000);
      return true;
    }).catch(function (e) {
      toast('Có lỗi khi tự dựng: ' + (e && e.message ? e.message : e), 6000);
      return false;
    }).then(function (ok) {
      assembleProgress(null);
      $('btnAssemble').disabled = !assembleFiles.length;
      return ok;
    });
  }

  /* ---------- Làm video tự động từ thư mục ---------- */

  var src = { talk: [], asset: [], scriptFile: null, folder: '' };

  function projProgress(p, label) {
    var box = $('projProgress');
    box.hidden = p == null;
    if (p == null) return;
    box.querySelector('.bar').style.width = Math.round(p * 100) + '%';
    box.querySelector('span').textContent = label;
  }

  function describeFiles(files) {
    var c = window.BdsImporter.classify(files);
    var v = c.media.filter(isVideoFile).length;
    var parts = [];
    if (c.zips.length) parts.push('🗜 ' + c.zips.length + ' file .zip (tự mở khi bấm làm video)');
    if (v) parts.push(v + ' video');
    if (c.media.length - v) parts.push((c.media.length - v) + ' ảnh');
    if (c.music.length) parts.push('🎵 ' + esc(c.music[0].name));
    if (c.scripts.length) parts.push('📝 ' + esc(c.scripts[0].name));
    return parts.length ? '✔ ' + parts.join(' · ') : '';
  }

  function setSource(kind, files, folder) {
    files = Array.prototype.slice.call(files || []);
    src[kind] = files;
    if (kind === 'talk') src.folder = folder || (files[0] && files[0].webkitRelativePath ? files[0].webkitRelativePath.split('/')[0] : '');
    $(kind + 'Info').innerHTML = (folder ? '📁 <b>' + esc(folder) + '</b>: ' : '') + describeFiles(files);
    updateProjButton();
  }

  function updateProjButton() {
    $('btnAutoProject').disabled = !src.talk.length && !src.asset.length && !$('talkLink').value.trim() && !$('assetLink').value.trim();
  }

  function jumpTo(n) {
    state.step = n;
    if (n === 3) renderShoot();
    if (n === 6) renderChecklist();
    showStep();
  }

  /** Mở .zip và tải link Drive của một phần (video quay hoặc tư liệu). */
  function gather(files, link, key, label, pre) {
    var I = window.BdsImporter;
    return I.expandZips(files, function (m) { projProgress(0.01, m); }).then(function (list) {
      if (!link.trim()) return list;
      return I.fromDrive(link, key, function (m) { projProgress(0.02, label + ': ' + m); }).then(function (df) { return list.concat(df); }).catch(function (e) {
        list.driveFailed = e.message === 'NEED_KEY' ? 'link Google Drive cần khoá Google (mục 🔑)' : e.message;
        if (e.message === 'NEED_KEY') {
          pre.push('<div class="warn">⚠️ ' + label + ': có link Google Drive nhưng chưa có khoá API. Mở mục “🔑” để làm theo, hoặc tải thư mục về (.zip) rồi kéo thả vào.</div>');
          $('driveKeyBox').open = true;
        } else pre.push('<div class="warn">⚠️ ' + label + ': ' + esc(e.message) + '</div>');
        return list;
      });
    });
  }

  function autoProject() {
    var I = window.BdsImporter;
    if (state.scenes.some(function (sc) { return sc.media.length; }) && !window.confirm('Thay dự án hiện tại bằng dự án mới?')) return;
    $('btnAutoProject').disabled = true;
    $('projReport').hidden = true;
    $('assembleReport').innerHTML = '';
    var key = $('driveKey').value.trim();
    try { if (key) localStorage.setItem('video-bds-gkey', key); } catch (e) { /* bỏ qua */ }
    var pre = [];
    projProgress(0.01, 'Đang chuẩn bị file…');
    var talk, asset;
    gather(src.talk, $('talkLink').value, key, 'Video quay', pre).then(function (t) {
      talk = t;
      return gather(src.asset, $('assetLink').value, key, 'Tư liệu dự án', pre);
    }).then(function (a2) {
      asset = a2;
      var ct = I.classify(talk), ca = I.classify(asset);
      var talkVids = ct.media.filter(isVideoFile);
      // Link tư liệu không tải được: hỏi lại thay vì lặng lẽ làm video không có phối cảnh
      if (asset.driveFailed && !ca.media.length && !window.confirm('⚠️ Không lấy được ảnh phối cảnh / flycam từ link Drive ở ô 2:\n' + asset.driveFailed +
        '.\n\nCách nhanh trên điện thoại: bấm “Chọn file” ở ô 2 → Duyệt → Google Drive → chọn ảnh, video dự án.\n\nBấm OK để vẫn làm video KHÔNG có phối cảnh, Huỷ để thêm tư liệu trước.')) {
        projProgress(null);
        $('projReport').innerHTML = pre.join('');
        $('projReport').hidden = false;
        updateProjButton();
        return;
      }
      // Ảnh lỡ bỏ vào phần video quay thì chuyển sang tư liệu
      var assets = ca.media.concat(ct.media.filter(function (f) { return !isVideoFile(f); }));
      runProject({
        talk: talkVids, assets: assets, music: ca.music.concat(ct.music),
        scripts: ct.scripts.concat(ca.scripts), scriptFile: src.scriptFile, scriptText: $('scriptText').value
      }, pre);
    }).catch(function (e) {
      projProgress(null);
      toast('Có lỗi: ' + (e && e.message ? e.message : e), 6000);
      updateProjButton();
    });
  }

  /** Kịch bản: file đã chọn → nội dung/link dán vào → file kịch bản nằm trong thư mục. */
  function readScriptSources(inp) {
    var I = window.BdsImporter, G = window.ScriptGen;
    var tryFiles = function (list, i) {
      if (i >= list.length) return Promise.resolve(null);
      return I.readScript(list[i]).then(function (r) {
        if (r && r.scenes && r.scenes.length) { r.from = list[i].name; return r; }
        return tryFiles(list, i + 1);
      }).catch(function () { return tryFiles(list, i + 1); });
    };
    var fromText = function () {
      var t = (inp.scriptText || '').trim();
      if (!t) return Promise.resolve(null);
      var link = I.findLink(t);
      if (link && t.replace(link, '').trim().length < 40) return I.fetchLink(link).then(function (r) { r.from = 'link Google'; return r; });
      var sc = t.indexOf('\t') !== -1 ? G.tableToScenes(G.parseTable(t)) : I.textToScenes(t);
      return Promise.resolve(sc.length ? { scenes: sc, raw: t, from: 'nội dung đã dán' } : null);
    };
    return tryFiles(inp.scriptFile ? [inp.scriptFile] : [], 0).then(function (r) { return r || fromText(); })
      .then(function (r) { return r || tryFiles(inp.scripts, 0); });
  }

  function runProject(inp, report) {
    var I = window.BdsImporter;
    projProgress(0.03, 'Đang đọc kịch bản…');
    readScriptSources(inp).catch(function (e) {
      report.push('<div class="warn">⚠️ Không mở được link kịch bản: ' + esc(e && e.message ? e.message : '') +
        ' Cách khác: mở kịch bản, bôi đen và copy (Ctrl+C) rồi dán vào ô Kịch bản quay.</div>');
      return null;
    }).then(function (sc) {
      var info = Object.assign({}, state.info);
      if (sc) {
        var found = I.extractInfo(sc.raw);
        Object.keys(found).forEach(function (k) { if (!String(info[k] || '').trim()) info[k] = found[k]; });
        report.push('<div>📝 Kịch bản: <b>' + esc(sc.from) + '</b>, ' + sc.scenes.length + ' cảnh</div>');
        state.scenes = sc.scenes.map(newScene);
      } else {
        // Không có kịch bản: mỗi video quay là một cảnh
        state.scenes = inp.talk.map(function (f, i) { return newScene({ title: 'Đoạn ' + (i + 1) + ': ' + f.name.replace(/\.[^.]+$/, '') }); });
        if (!state.scenes.length) state.scenes = [newScene({ title: 'Cảnh 1' })];
        report.push('<div class="warn">⚠️ Chưa có kịch bản: mỗi video quay thành một cảnh, chưa có chữ theo lời nói. Thêm kịch bản ở phần 3 để có chữ.</div>');
      }
      if (!String(info.ten || '').trim() && src.folder) info.ten = src.folder;
      setInfo(info);
      renderScenes();
      report.push('<div>🎬 ' + inp.talk.length + ' video quay · 🏙 ' + inp.assets.length + ' tư liệu dự án' + (inp.music.length ? ' · 🎵 ' + esc(inp.music[0].name) : '') + '</div>');
      if (inp.music.length) {
        return inp.music[0].arrayBuffer().then(function (ab) { return getAudioCtx().decodeAudioData(ab); }).then(function (buf) {
          state.music.buffer = buf;
          state.music.name = inp.music[0].name;
          showMusicNow();
        }).catch(function () {});
      }
    }).then(function () {
      // Ảnh tên có chữ "logo" trong tư liệu: dùng làm logo chủ đầu tư, không đưa vào cảnh
      var logos = inp.assets.filter(function (f) { return !isVideoFile(f) && /logo/i.test(f.name); });
      if (logos.length) {
        inp.assets = inp.assets.filter(function (f) { return logos.indexOf(f) === -1; });
        var li = new Image();
        li.onload = function () { state.devLogo = li; schedulePreview(); };
        li.src = URL.createObjectURL(logos[0]);
        report.push('<div>🏷 Logo chủ đầu tư: ' + esc(logos[0].name) + '</div>');
      }
      var media = inp.talk.concat(inp.assets);
      if (!media.length) { report.push('<div class="warn">⚠️ Chưa có video quay hay tư liệu nào.</div>'); return false; }
      var talkSet = inp.talk;
      return assemble(media, {
        force: true, quiet: true, asr: $('projAsrMode').value !== 'off' && state.scenes.some(function (s2) { return s2.text; }),
        asrMode: $('projAsrMode').value,
        minPause: parseFloat($('projPause').value) || 0.25,
        roleOf: function (f) { return talkSet.indexOf(f) !== -1 ? 'talk' : 'broll'; },
        progress: function (p, label) { projProgress(0.05 + p * 0.9, label); }
      });
    }).then(function (ok) {
      projProgress(null);
      var miss = missingInfo();
      if (miss.length) report.push('<div class="warn">⚠️ Còn thiếu: ' + miss.map(function (k) { return REQUIRED[k]; }).join(', ') + ' (điền ở bên dưới để hiện ở cuối video).</div>');
      $('projReport').innerHTML = report.join('') + ($('assembleReport').innerHTML || '');
      $('projReport').hidden = false;
      save();
      schedulePreview();
      if (!ok) return;
      if ($('projExport').checked) {
        $('outFull').checked = true;
        $('outTrailer').checked = true;
        $('outScenes').checked = false;
        jumpTo(6);
        toast('🚀 Đã dựng xong, đang xuất video. Đừng chuyển tab nhé!', 5000);
        doExport();
      } else {
        jumpTo(3);
        toast('🚀 Đã dựng xong! Kiểm tra từng cảnh, bấm ▶ Xem thử, rồi sang Bước 6 để xuất.', 6000);
      }
    }).catch(function (e) {
      projProgress(null);
      toast('Có lỗi: ' + (e && e.message ? e.message : e), 6000);
    }).then(function () { updateProjButton(); });
  }

  function bindAutoProject() {
    var pickKind = 'talk';
    document.querySelectorAll('[data-pick]').forEach(function (b) {
      b.onclick = function (e) {
        e.preventDefault();
        e.stopPropagation();
        var parts = b.dataset.pick.split('-');
        pickKind = parts[0];
        $(parts[1] === 'folder' ? 'pickFolderInput' : 'pickFilesInput').click();
      };
    });
    $('pickFolderInput').onchange = function (e) { setSource(pickKind, e.target.files); e.target.value = ''; };
    $('pickFilesInput').onchange = function (e) { setSource(pickKind, e.target.files); e.target.value = ''; };
    ['talk', 'asset'].forEach(function (kind) {
      var dz = $(kind + 'Drop');
      ['dragenter', 'dragover'].forEach(function (ev) { dz.addEventListener(ev, function (e) { e.preventDefault(); dz.classList.add('over'); }); });
      ['dragleave', 'drop'].forEach(function (ev) { dz.addEventListener(ev, function (e) { e.preventDefault(); dz.classList.remove('over'); }); });
      dz.addEventListener('drop', function (e) {
        window.BdsImporter.filesFromDrop(e.dataTransfer).then(function (files) { setSource(kind, files, files.folder); });
      });
      $(kind + 'Link').oninput = updateProjButton;
    });
    $('btnScriptFile').onclick = function () { $('scriptFileInput').click(); };
    $('scriptFileInput').onchange = function (e) {
      src.scriptFile = e.target.files[0] || null;
      $('scriptInfo').textContent = src.scriptFile ? '✔ ' + src.scriptFile.name : '';
    };
    try { $('driveKey').value = localStorage.getItem('video-bds-gkey') || ''; } catch (e) { /* bỏ qua */ }
    $('btnAutoProject').onclick = autoProject;
  }

  function quickScenes(items) {
    var captions = items.map(function (m) { return m.caption || ''; });
    var lines = window.ScriptGen.generate(state.info, captions, state.style, state.variant);
    var scenes = [newScene({ title: 'Mở đầu', text: lines[0], media: items.length ? [items[0]] : [], quick: true })];
    items.forEach(function (m, i) {
      scenes.push(newScene({ title: m.caption || '', text: lines[i + 1], media: [m], showTitle: true, quick: true }));
    });
    scenes.push(newScene({ title: 'Kêu gọi liên hệ', text: lines[lines.length - 1], media: items.length ? [items[items.length - 1]] : [], quick: true }));
    return scenes;
  }

  function regenerateQuick() {
    var mid = state.scenes.slice(1, -1);
    var lines = window.ScriptGen.generate(state.info, mid.map(function (s) { return s.title; }), state.style, state.variant);
    state.scenes.forEach(function (s, i) {
      if (i === 0) s.text = lines[0];
      else if (i === state.scenes.length - 1) s.text = lines[lines.length - 1];
      else s.text = lines[i];
    });
    renderScenes();
    save();
    schedulePreview();
  }

  function moveScene(i, d) {
    var j = i + d;
    if (j < 0 || j >= state.scenes.length) return;
    var t = state.scenes[i];
    state.scenes[i] = state.scenes[j];
    state.scenes[j] = t;
  }

  function renderScenes() {
    var ol = $('sceneList');
    ol.innerHTML = '';
    $('quickTools').hidden = !state.scenes.some(function (s) { return s.quick; });
    $('styleSelect').value = state.style;
    if (!state.scenes.length) {
      ol.innerHTML = '<li class="empty-media">Chưa có cảnh nào. Chọn một cách bắt đầu ở trên, hoặc bấm “＋ Thêm cảnh”.</li>';
    }
    var tl = window.BdsTimeline.buildFull(project());
    var durs = tl.overlays.filter(function (o) { return o.kind === 'scene'; }).map(function (o) { return o.duration; });
    state.scenes.forEach(function (s, i) {
      var li = document.createElement('li');
      li.className = 'scene-card';
      li.innerHTML =
        '<div class="scene-head"><span class="scene-no">Cảnh ' + (i + 1) + '</span>' +
        '<input data-f="title" placeholder="Tên cảnh, VD: Hook, Vị trí, Tiện ích">' +
        '<div class="tools"><button class="btn" type="button" data-a="up" title="Lên">▲</button>' +
        '<button class="btn" type="button" data-a="down" title="Xuống">▼</button>' +
        '<button class="btn" type="button" data-a="dup" title="Nhân đôi">⧉</button>' +
        '<button class="btn" type="button" data-a="del" title="Xoá">🗑</button></div></div>' +
        '<label>🗣 Lời thoại<textarea data-f="text" rows="4" placeholder="Lời nói trước camera hoặc lời đọc lồng tiếng"></textarea></label>' +
        '<label>🔠 Chữ lớn trên màn hình (mỗi dòng một ý, VD: 20 TẦNG NỔI)<textarea data-f="bigText" rows="2"></textarea></label>' +
        '<label>🎞 Gợi ý cảnh quay<textarea data-f="shotNote" rows="2" placeholder="VD: Phối cảnh → logo chủ đầu tư → bản đồ"></textarea></label>' +
        '<div class="scene-foot">⏱ <input type="number" min="1" max="300" step="0.5" data-f="dur"> giây' +
        '<span>· ' + s.media.length + ' ảnh/clip</span>' +
        '<label class="check"><input type="checkbox" data-f="showTitle"> Hiện tên cảnh trên video</label></div>';
      var get = function (f) { return li.querySelector('[data-f="' + f + '"]'); };
      get('title').value = s.title;
      get('text').value = s.text;
      get('bigText').value = s.bigText.join('\n');
      get('shotNote').value = s.shotNote;
      get('dur').value = s.durOverride || '';
      get('dur').placeholder = fmtSec(durs[i] || 0).replace(',', '.');
      get('showTitle').checked = s.showTitle;
      var changed = function () { save(); schedulePreview(); updateTotal(); };
      get('title').oninput = function (e) { s.title = e.target.value; changed(); };
      get('text').oninput = function (e) { s.text = e.target.value; changed(); };
      get('bigText').oninput = function (e) { s.bigText = e.target.value.split('\n').map(function (x) { return x.trim(); }).filter(Boolean); changed(); };
      get('shotNote').oninput = function (e) { s.shotNote = e.target.value; save(); };
      get('dur').oninput = function (e) { var v = parseFloat(e.target.value); s.durOverride = v >= 1 ? v : null; changed(); };
      get('showTitle').onchange = function (e) { s.showTitle = e.target.checked; changed(); };
      li.querySelectorAll('[data-a]').forEach(function (b) {
        b.onclick = function () {
          var a = b.dataset.a;
          if (a === 'up') moveScene(i, -1);
          else if (a === 'down') moveScene(i, 1);
          else if (a === 'dup') state.scenes.splice(i + 1, 0, newScene(JSON.parse(JSON.stringify({ title: s.title, text: s.text, bigText: s.bigText, shotNote: s.shotNote }))));
          else if (a === 'del' && window.confirm('Xoá cảnh ' + (i + 1) + '?')) state.scenes.splice(i, 1);
          renderScenes();
          save();
          schedulePreview();
        };
      });
      ol.appendChild(li);
    });
    updateTotal();
  }

  function updateTotal() {
    try { $('totalDur').textContent = Math.round(timeline('full').total); } catch (e) { /* chưa có cảnh */ }
  }

  var speaking = false;
  function speakScript() {
    var synth = window.speechSynthesis;
    if (!synth) { toast('Trình duyệt này không hỗ trợ đọc thử.'); return; }
    if (speaking) { synth.cancel(); speaking = false; $('btnSpeak').textContent = '🔊 Nghe máy đọc thử'; return; }
    var vi = synth.getVoices().filter(function (v) { return /^vi/i.test(v.lang); })[0];
    if (!vi) toast('Máy chưa có giọng tiếng Việt nên giọng đọc có thể không chuẩn. Dùng Chrome hoặc Edge sẽ tốt hơn.', 4500);
    var u = new SpeechSynthesisUtterance(state.scenes.map(function (s) { return s.text; }).join('. '));
    u.lang = 'vi-VN';
    if (vi) u.voice = vi;
    u.onend = u.onerror = function () { speaking = false; $('btnSpeak').textContent = '🔊 Nghe máy đọc thử'; };
    speaking = true;
    $('btnSpeak').textContent = '⏹ Dừng đọc';
    synth.speak(u);
  }

  function bindScript() {
    var sel = $('styleSelect');
    Object.keys(window.ScriptGen.STYLES).forEach(function (k) {
      var o = document.createElement('option');
      o.value = k;
      o.textContent = window.ScriptGen.STYLES[k];
      sel.appendChild(o);
    });
    sel.value = state.style;
    sel.onchange = function () { state.style = sel.value; save(); regenerateQuick(); };
    $('btnRegen').onclick = function () { state.variant++; regenerateQuick(); toast('Đã viết lại lời thoại.'); };
    $('btnStartProject').onclick = startProject;
    $('assembleInput').onchange = function (e) { setAssembleFiles(e.target.files); };
    var ad = $('assembleDrop');
    ['dragenter', 'dragover'].forEach(function (ev) { ad.addEventListener(ev, function (e) { e.preventDefault(); ad.classList.add('over'); }); });
    ['dragleave', 'drop'].forEach(function (ev) { ad.addEventListener(ev, function (e) { e.preventDefault(); ad.classList.remove('over'); }); });
    ad.addEventListener('drop', function (e) { setAssembleFiles(e.dataTransfer.files); });
    $('btnAssemble').onclick = function () { assemble(); };
    $('btnStartVideo').onclick = function () { $('videoInput').click(); };
    $('videoInput').onchange = pickVideo;
    $('btnAutoGo').onclick = autoBuild;
    document.querySelectorAll('input[name=autoSub]').forEach(function (r) {
      r.onchange = function () { $('autoScript').hidden = r.value !== 'script' || !r.checked; };
    });
    $('btnStartSheet').onclick = function () { $('sheetBox').hidden = !$('sheetBox').hidden; };
    $('btnSheetLink').onclick = importFromLink;
    $('btnSheetPaste').onclick = function () {
      importScenes(window.ScriptGen.tableToScenes(window.ScriptGen.parseTable($('sheetPaste').value)));
    };
    $('btnStartQuick').onclick = function () { if (confirmReplace()) $('quickInput').click(); };
    $('quickInput').onchange = function (e) {
      var files = Array.prototype.slice.call(e.target.files || []);
      e.target.value = '';
      Promise.all(files.map(function (f) { return createMedia(f, f.name); })).then(function (items) {
        items = items.filter(Boolean);
        setScenes(quickScenes(items), false);
        toast('Đã tạo ' + state.scenes.length + ' cảnh. Ghi tên phòng ở ô tên cảnh rồi bấm “Viết lại lời theo tên cảnh”.', 5000);
      });
    };
    $('btnAddScene').onclick = function () {
      state.scenes.push(newScene({ title: 'Cảnh ' + (state.scenes.length + 1) }));
      renderScenes();
      save();
    };
    $('btnSpeak').onclick = speakScript;
  }

  /* ---------- Bước 3: quay & ghép ---------- */

  function isTalk(m) { return m.isVideo && m.keepAudio && m.hasAudio; }

  /** Cảnh có clip nói và có phối cảnh/flycam để phủ lên. */
  function canCover(s) {
    return state.voiceMode === 'clip' && s.media.some(isTalk) && s.media.some(function (m) { return !isTalk(m); });
  }

  function mediaMeta(m, scene) {
    var role = scene && canCover(scene) && scene.layout !== 'seq' ? (isTalk(m) ? '🗣 <b>Clip nói</b> · ' : '🏙 <b>Phủ lên lời nói</b> · ') : '';
    if (!m.isVideo) return role + '🖼 Ảnh · hiệu ứng zoom';
    if (m.fixed) return role + '✂️ Đoạn <b>' + fmtTime(m.trimIn) + '–' + fmtTime(m.trimOut) + '</b> (' + fmtSec(m.trimOut - m.trimIn) + 's)';
    if (m.analyzing) return '🎞 Clip ' + fmtSec(m.dur || 0) + 's · đang phân tích âm thanh…';
    var used = (m.trimOut || m.dur) - (m.trimIn || 0);
    var cut = (m.dur || 0) - used;
    var s = role + '🎞 Clip <b>' + fmtSec(m.dur || 0) + 's</b>';
    if (state.settings.autoTrim && cut > 0.3) s += ' → dùng <b>' + fmtSec(used) + 's</b> (cắt ' + fmtSec(cut) + 's lặng)';
    if (!m.hasAudio) s += ' · không có tiếng';
    else if (m.voiceGain && Math.abs(m.voiceGain - 1) > 0.15) s += ' · giọng ' + (m.voiceGain > 1 ? 'tăng' : 'giảm') + ' ×' + fmtSec(m.voiceGain);
    return s;
  }

  function renderShoot() {
    var ol = $('shootList');
    ol.innerHTML = '';
    var tl = window.BdsTimeline.buildFull(project());
    var durs = tl.overlays.filter(function (o) { return o.kind === 'scene'; }).map(function (o) { return o.duration; });
    state.scenes.forEach(function (s, si) {
      var li = document.createElement('li');
      li.className = 'scene-card';
      var tiles = s.media.map(function (m, mi) {
        var thumb = m.isVideo ? '<video class="thumb" muted preload="metadata" src="' + m.url + '#t=' + ((m.trimIn || 0) + 0.3).toFixed(2) + '"></video>' : '<img class="thumb" alt="" src="' + m.url + '">';
        var audioBtn = m.isVideo && m.hasAudio ?
          '<button class="btn' + (m.keepAudio ? ' on' : '') + '" type="button" data-a="aud" data-i="' + mi + '" title="Giữ tiếng nói gốc">' + (m.keepAudio ? '🔊 Tiếng gốc' : '🔇 Tắt tiếng') + '</button>' : '';
        var hideBtn = m.isVideo && m.hasAudio && m.keepAudio ?
          '<button class="btn' + (m.audioOnly ? ' on' : '') + '" type="button" data-a="hide" data-i="' + mi + '" title="Chỉ lấy giọng nói, hình thay bằng phối cảnh/flycam">' + (m.audioOnly ? '🙈 Chỉ lấy tiếng' : '👁 Hiện hình') + '</button>' : '';
        return '<div class="media-tile">' + thumb + '<div class="meta">' + mediaMeta(m, s) + '</div><div class="tile-tools">' + audioBtn + hideBtn +
          '<button class="btn" type="button" data-a="left" data-i="' + mi + '" title="Lên trước">◀</button>' +
          '<button class="btn" type="button" data-a="right" data-i="' + mi + '" title="Ra sau">▶</button>' +
          '<button class="btn" type="button" data-a="del" data-i="' + mi + '" title="Xoá">🗑</button>' +
          (!isTalk(m) ? '<button class="btn' + (m.track ? ' on' : '') + '" type="button" data-a="track" data-i="' + mi + '" title="Gắn chữ bám theo điểm">🎯' + (m.track ? ' ' + esc(m.track.text) : '') + '</button>' : '') +
          (state.scenes.length > 1 ? '<select data-move="' + mi + '" title="Chuyển sang cảnh khác"><option value="">Chuyển sang cảnh…</option>' +
            state.scenes.map(function (_, k) { return k === si ? '' : '<option value="' + k + '">Cảnh ' + (k + 1) + '</option>'; }).join('') + '</select>' : '') +
          '</div></div>';
      }).join('');
      li.innerHTML =
        '<div class="scene-head"><span class="scene-no">Cảnh ' + (si + 1) + '</span><b>' + esc(window.BdsTimeline.cleanTitle(s.title) || '(chưa đặt tên)') + '</b>' +
        '<span class="muted small-text" style="margin-left:auto">⏱ ' + fmtSec(durs[si] || 0) + ' giây</span></div>' +
        (s.shotNote ? '<div class="shot-note">📋 <b>Cần quay:</b> ' + esc(s.shotNote) + '</div>' : '') +
        (s.media.length ? '<div class="media-grid">' + tiles + '</div>' :
          '<div class="empty-media">Chưa có ảnh/clip. ' + ((s.bigText || []).length ? 'Cảnh này sẽ hiện chữ lớn trên nền màu.' : 'Cảnh sẽ hiện phụ đề trên nền màu.') + '</div>') +
        (canCover(s) ? '<label class="check cover-opt"><input type="checkbox" data-a="layout"' + (s.layout !== 'seq' ? ' checked' : '') +
          '> 🎬 Xen phối cảnh/flycam lên lời nói (tiếng nói chạy liên tục, hình chuyển sang phối cảnh rồi quay lại người nói)</label>' : '') +
        '<div class="row wrap nomargin"><label class="btn"><input type="file" accept="image/*,video/*" multiple hidden>📁 Thêm ảnh/clip</label>' +
        '<button class="btn accent" type="button" data-a="cam">🎥 Quay cảnh này</button></div>';
      li.querySelector('input[type=file]').onchange = function (e) { addFilesToScene(si, e.target.files); e.target.value = ''; };
      li.querySelectorAll('select[data-move]').forEach(function (sel) {
        sel.onchange = function () {
          if (sel.value === '') return;
          var it = s.media.splice(+sel.dataset.move, 1)[0];
          state.scenes[+sel.value].media.push(it);
          renderShoot();
          schedulePreview();
        };
      });
      li.querySelectorAll('[data-a]').forEach(function (b) {
        b.onclick = function () {
          var a = b.dataset.a, mi = +b.dataset.i, arr = s.media;
          if (a === 'cam') { Camera.open(si); return; }
          if (a === 'layout') { s.layout = b.checked ? 'auto' : 'seq'; save(); renderShoot(); schedulePreview(); return; }
          if (a === 'track') { openTrack(arr[mi]); return; }
          if (a === 'aud') arr[mi].keepAudio = !arr[mi].keepAudio;
          else if (a === 'hide') {
            arr[mi].audioOnly = !arr[mi].audioOnly;
            if (arr[mi].audioOnly && !s.media.some(function (x) { return !isTalk(x); })) toast('Thêm ảnh phối cảnh hoặc clip flycam vào cảnh này để thay cho hình người nói.', 4500);
          }
          else if (a === 'left' && mi > 0) arr.splice(mi - 1, 0, arr.splice(mi, 1)[0]);
          else if (a === 'right' && mi < arr.length - 1) arr.splice(mi + 1, 0, arr.splice(mi, 1)[0]);
          else if (a === 'del') arr.splice(mi, 1);
          renderShoot();
          schedulePreview();
        };
      });
      ol.appendChild(li);
    });
  }

  /* ---------- Quay bằng camera, có chữ nhắc lời ---------- */

  var Camera = (function () {
    var si = 0, stream = null, rec = null, chunks = [], facing = 'user', startAt = 0, timer = null, blob = null, recSecs = 0;

    function pickMime() {
      var types = ['video/mp4;codecs=avc1,mp4a', 'video/mp4', 'video/webm;codecs=vp9,opus', 'video/webm'];
      for (var i = 0; i < types.length; i++) if (window.MediaRecorder && MediaRecorder.isTypeSupported(types[i])) return types[i];
      return '';
    }

    function stopStream() {
      if (stream) stream.getTracks().forEach(function (t) { t.stop(); });
      stream = null;
    }

    function startPreview() {
      stopStream();
      return navigator.mediaDevices.getUserMedia({
        video: { facingMode: facing, width: { ideal: 1080 }, height: { ideal: 1920 } },
        audio: { echoCancellation: true, noiseSuppression: true, autoGainControl: true }
      }).then(function (s) {
        stream = s;
        var v = $('camVideo');
        v.srcObject = s;
        v.classList.toggle('mirror', facing === 'user');
        v.hidden = false;
        $('camReview').hidden = true;
        return v.play();
      });
    }

    function ui(mode) {
      $('camStart').hidden = mode !== 'ready';
      $('camFlip').hidden = mode !== 'ready';
      $('camStop').hidden = mode !== 'rec';
      $('camRec').hidden = mode !== 'rec';
      $('camRetry').hidden = mode !== 'review';
      $('camUse').hidden = mode !== 'review';
      $('camPrompt').hidden = mode === 'review';
    }

    function resetScroll() {
      var t = $('camText');
      t.style.transition = 'none';
      t.style.transform = 'translateY(0)';
    }

    function open(i) {
      if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        toast('Trình duyệt không cho dùng camera. Hãy mở bằng Chrome qua địa chỉ https.', 5000);
        return;
      }
      si = i;
      var s = state.scenes[i];
      $('camTitle').textContent = 'Cảnh ' + (i + 1) + ': ' + (window.BdsTimeline.cleanTitle(s.title) || '');
      $('camText').textContent = s.text || '(Cảnh này chưa có lời thoại)';
      resetScroll();
      $('camModal').hidden = false;
      ui('ready');
      startPreview().catch(function () {
        toast('Chưa được phép dùng camera/micro. Bấm biểu tượng 🔒 trên thanh địa chỉ để cho phép.', 5000);
      });
    }

    function close() {
      if (rec && rec.state !== 'inactive') { rec.onstop = null; rec.stop(); }
      clearInterval(timer);
      stopStream();
      $('camModal').hidden = true;
      $('camReview').removeAttribute('src');
    }

    function start() {
      var n = 3, cd = $('camCount');
      cd.hidden = false;
      cd.textContent = n;
      $('camStart').hidden = true;
      var iv = setInterval(function () {
        n--;
        if (n > 0) { cd.textContent = n; return; }
        clearInterval(iv);
        cd.hidden = true;
        begin();
      }, 1000);
    }

    function begin() {
      chunks = [];
      var mime = pickMime();
      rec = new MediaRecorder(stream, mime ? { mimeType: mime, videoBitsPerSecond: 6000000 } : undefined);
      rec.ondataavailable = function (e) { if (e.data.size) chunks.push(e.data); };
      rec.onstop = finished;
      rec.start(500);
      startAt = performance.now();
      ui('rec');
      timer = setInterval(function () { $('camTime').textContent = fmtTime((performance.now() - startAt) / 1000); }, 250);
      // Cuộn chữ theo tốc độ đọc
      var text = state.scenes[si].text || '';
      var secs = Math.max(4, window.BdsTimeline.readSeconds(text) * 1.15) * 100 / (+$('camSpeed').value || 100);
      var t = $('camText');
      var dist = Math.max(0, t.scrollHeight - 200);
      requestAnimationFrame(function () {
        t.style.transition = 'transform ' + secs + 's linear';
        t.style.transform = 'translateY(-' + dist + 'px)';
      });
    }

    function stop() {
      if (!rec || rec.state === 'inactive') return;
      recSecs = (performance.now() - startAt) / 1000;
      clearInterval(timer);
      rec.stop();
    }

    function finished() {
      var type = (rec.mimeType || 'video/webm').split(';')[0];
      var raw = new Blob(chunks, { type: type });
      var fix = type.indexOf('webm') !== -1 ? window.WebmFix.fixDuration(raw, recSecs) : Promise.resolve(raw);
      fix.then(function (b) {
        blob = b;
        stopStream();
        var rv = $('camReview');
        rv.src = URL.createObjectURL(b);
        rv.hidden = false;
        $('camVideo').hidden = true;
        ui('review');
      });
    }

    function use() {
      if (!blob) return;
      var ext = blob.type.indexOf('mp4') !== -1 ? 'mp4' : 'webm';
      createMedia(blob, 'canh-' + (si + 1) + '-' + Date.now() + '.' + ext, { keepAudio: true, duration: recSecs }).then(function (item) {
        if (item) state.scenes[si].media.push(item);
        close();
        renderShoot();
        schedulePreview();
        toast('Đã thêm đoạn quay vào cảnh ' + (si + 1) + '.');
      });
    }

    function bind() {
      $('camStart').onclick = start;
      $('camStop').onclick = stop;
      $('camClose').onclick = close;
      $('camUse').onclick = use;
      $('camRetry').onclick = function () { blob = null; resetScroll(); ui('ready'); startPreview(); };
      $('camFlip').onclick = function () { facing = facing === 'user' ? 'environment' : 'user'; startPreview().catch(function () {}); };
    }

    return { open: open, bind: bind };
  })();

  /* ---------- Gắn chữ bám theo điểm ---------- */

  var trackMedia = null, trackPt = null;

  function drawTrackFrame(src) {
    var c = $('trackCanvas'), w = src.videoWidth || src.naturalWidth, h = src.videoHeight || src.naturalHeight;
    c.width = Math.min(720, w);
    c.height = Math.round(c.width * h / w);
    var cx = c.getContext('2d');
    cx.drawImage(src, 0, 0, c.width, c.height);
    if (trackPt) {
      cx.fillStyle = '#e0a526';
      cx.strokeStyle = '#fff';
      cx.lineWidth = 3;
      cx.beginPath(); cx.arc(trackPt.x * c.width, trackPt.y * c.height, 10, 0, 6.283); cx.fill(); cx.stroke();
    }
    c._src = src;
  }

  function openTrack(m) {
    trackMedia = m;
    trackPt = m.track ? { x: m.track.x, y: m.track.y } : null;
    $('trackText').value = m.track ? m.track.text : (state.info.ten || '');
    $('trackModal').hidden = false;
    $('trackProgress').hidden = true;
    if (!m.isVideo) { drawTrackFrame(m.el); return; }
    var v = document.createElement('video');
    v.muted = true;
    v.src = m.url;
    v.onloadeddata = function () { v.currentTime = (m.trimIn || 0) + 0.1; };
    v.onseeked = function () { drawTrackFrame(v); };
  }

  function bindTrack() {
    $('trackClose').onclick = function () { $('trackModal').hidden = true; };
    $('trackCanvas').onclick = function (e) {
      var c = $('trackCanvas'), r = c.getBoundingClientRect();
      trackPt = { x: (e.clientX - r.left) / r.width, y: (e.clientY - r.top) / r.height };
      if (c._src) drawTrackFrame(c._src);
    };
    $('trackRemove').onclick = function () {
      if (trackMedia) delete trackMedia.track;
      $('trackModal').hidden = true;
      renderShoot();
      schedulePreview();
    };
    $('trackGo').onclick = function () {
      var m = trackMedia, text = $('trackText').value.trim();
      if (!m || !trackPt) { toast('Chạm vào hình để chọn điểm cần gắn chữ.'); return; }
      if (!text) { toast('Nhập chữ cần hiển thị.'); return; }
      var finish = function (pts) {
        m.track = { text: text, x: trackPt.x, y: trackPt.y, pts: pts };
        $('trackModal').hidden = true;
        renderShoot();
        schedulePreview();
        toast('🎯 Đã gắn chữ “' + text + '”.');
      };
      if (!m.isVideo) { finish(null); return; }
      var prog = $('trackProgress'), bar = prog.querySelector('.bar'), label = prog.querySelector('span');
      prog.hidden = false;
      $('trackGo').disabled = true;
      var t0 = 0, t1 = Math.min(m.dur || m.el.duration || 10, 90);
      window.BdsVision.trackPoint(m.url, t0, t1, trackPt.x, trackPt.y, function (p) {
        bar.style.width = Math.round(p * 100) + '%';
        label.textContent = 'Đang bám theo điểm… ' + Math.round(p * 100) + '%';
      }).then(function (r) { finish(r.pts); }).catch(function (e) {
        toast('Không tracking được: ' + (e && e.message ? e.message : e), 5000);
      }).then(function () { $('trackGo').disabled = false; prog.hidden = true; });
    };
  }

  /* ---------- Bước 4: giọng đọc ---------- */

  function sliceBuffer(buf, from, to) {
    var ctx = getAudioCtx();
    var a = Math.max(0, Math.floor(from * buf.sampleRate)), b = Math.min(buf.length, Math.floor(to * buf.sampleRate));
    var out = ctx.createBuffer(buf.numberOfChannels, Math.max(1, b - a), buf.sampleRate);
    for (var c = 0; c < buf.numberOfChannels; c++) out.copyToChannel(buf.getChannelData(c).subarray(a, b), c);
    return out;
  }

  function bufferToWav(buf) {
    var n = buf.length, sr = buf.sampleRate;
    var data = buf.getChannelData(0);
    var ab = new ArrayBuffer(44 + n * 2), dv = new DataView(ab);
    function str(o, s) { for (var i = 0; i < s.length; i++) dv.setUint8(o + i, s.charCodeAt(i)); }
    str(0, 'RIFF'); dv.setUint32(4, 36 + n * 2, true); str(8, 'WAVE'); str(12, 'fmt ');
    dv.setUint32(16, 16, true); dv.setUint16(20, 1, true); dv.setUint16(22, 1, true);
    dv.setUint32(24, sr, true); dv.setUint32(28, sr * 2, true); dv.setUint16(32, 2, true); dv.setUint16(34, 16, true);
    str(36, 'data'); dv.setUint32(40, n * 2, true);
    for (var i = 0; i < n; i++) dv.setInt16(44 + i * 2, Math.max(-1, Math.min(1, data[i])) * 0x7fff, true);
    return new Blob([ab], { type: 'audio/wav' });
  }

  function refreshVoiceUI() {
    document.querySelectorAll('input[name=voiceMode]').forEach(function (r) { r.checked = r.value === state.voiceMode; });
    $('voiceRecordBox').hidden = state.voiceMode !== 'record';
    var st = $('voiceStatus');
    if (state.voiceMode === 'clip') {
      var n = 0;
      state.scenes.forEach(function (s) { s.media.forEach(function (m) { if (m.isVideo && m.keepAudio && m.hasAudio) n++; }); });
      st.hidden = false;
      st.className = 'notice' + (n ? ' ok' : '');
      st.innerHTML = n ? '✔ Có ' + n + ' clip giữ tiếng nói gốc. Cảnh có clip nói sẽ dài đúng bằng clip (đã cắt khoảng lặng).' :
        'Chưa có clip nào có tiếng. Hãy quay hoặc thêm clip ở Bước 3, hoặc chọn “Thu giọng lồng tiếng”.';
    } else st.hidden = true;
    var list = $('voiceList');
    list.innerHTML = '';
    state.scenes.forEach(function (s, i) {
      if (!s.voice) return;
      var d = document.createElement('div');
      d.innerHTML = '<span>Cảnh ' + (i + 1) + ' · ' + fmtSec(s.voice.buffer.duration) + 's</span><audio controls src="' + s.voice.url + '"></audio>';
      list.appendChild(d);
    });
  }

  function bindVoice() {
    document.querySelectorAll('input[name=voiceMode]').forEach(function (r) {
      r.addEventListener('change', function () {
        if (!r.checked) return;
        state.voiceMode = r.value;
        save();
        refreshVoiceUI();
        schedulePreview();
      });
    });
    $('btnOpenPrompter').onclick = Prompter.open;
  }

  var Prompter = (function () {
    var idx = 0, marks = [], recStart = 0, rec = null, stream = null, chunks = [], timer = null;
    var pending = null, recording = false, endAt = 0;

    function label(i) { return 'Cảnh ' + (i + 1) + (state.scenes[i] && state.scenes[i].title ? ': ' + window.BdsTimeline.cleanTitle(state.scenes[i].title) : ''); }

    function show(i) {
      var sc = state.scenes;
      $('pCounter').textContent = 'Cảnh ' + (i + 1) + '/' + sc.length;
      $('pScene').textContent = label(i);
      $('pText').textContent = (sc[i] && sc[i].text) || '';
      $('pNext').textContent = sc[i + 1] ? 'Tiếp theo: ' + (sc[i + 1].text || '').split('\n')[0] : '';
      $('pNextBtn').textContent = i === sc.length - 1 ? '■ Kết thúc' : 'Cảnh tiếp ▶';
    }

    function reset() {
      idx = 0; marks = []; recording = false; pending = null;
      clearInterval(timer);
      $('pStart').hidden = false;
      $('pNextBtn').hidden = true;
      $('pRetry').hidden = true;
      $('pRec').hidden = true;
      $('pReview').hidden = true;
      $('pCountdown').hidden = true;
      show(0);
    }

    function open() {
      if (!state.scenes.length) { toast('Chưa có kịch bản.'); return; }
      $('prompter').hidden = false;
      reset();
    }

    function stopStream() {
      if (stream) stream.getTracks().forEach(function (t) { t.stop(); });
      stream = null;
    }

    function close() {
      if (rec && rec.state !== 'inactive') { rec.onstop = null; rec.stop(); }
      recording = false;
      stopStream();
      clearInterval(timer);
      $('prompter').hidden = true;
    }

    function start() {
      if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        toast('Trình duyệt không cho dùng micro. Hãy mở bằng Chrome qua địa chỉ https.', 5000);
        return;
      }
      navigator.mediaDevices.getUserMedia({ audio: { echoCancellation: true, noiseSuppression: true, autoGainControl: true } })
        .then(function (s) {
          stream = s;
          $('pStart').hidden = true;
          var n = 3, cd = $('pCountdown');
          cd.hidden = false;
          cd.textContent = n;
          var iv = setInterval(function () {
            n--;
            if (n > 0) { cd.textContent = n; return; }
            clearInterval(iv);
            cd.hidden = true;
            begin();
          }, 1000);
        })
        .catch(function () { toast('Chưa được phép dùng micro. Bấm biểu tượng 🔒 trên thanh địa chỉ để cho phép.', 5000); });
    }

    function begin() {
      chunks = [];
      rec = new MediaRecorder(stream);
      rec.ondataavailable = function (e) { if (e.data.size) chunks.push(e.data); };
      rec.onstop = finished;
      rec.start();
      recStart = performance.now();
      marks = [0];
      idx = 0;
      recording = true;
      show(0);
      $('pNextBtn').hidden = false;
      $('pRetry').hidden = false;
      $('pRec').hidden = false;
      timer = setInterval(function () { $('pTime').textContent = fmtTime((performance.now() - recStart) / 1000); }, 250);
    }

    function next() {
      if (!recording) return;
      var now = (performance.now() - recStart) / 1000;
      if (idx >= state.scenes.length - 1) {
        endAt = now;
        recording = false;
        clearInterval(timer);
        $('pNextBtn').hidden = true;
        $('pRec').hidden = true;
        rec.stop();
        return;
      }
      marks.push(now);
      idx++;
      show(idx);
    }

    function finished() {
      stopStream();
      var blob = new Blob(chunks, { type: rec.mimeType || 'audio/webm' });
      $('pAudio').src = URL.createObjectURL(blob);
      $('pReview').hidden = false;
      $('pText').textContent = '✔ Thu xong! Nghe lại bên dưới.';
      $('pNext').textContent = '';
      blob.arrayBuffer().then(function (ab) { return getAudioCtx().decodeAudioData(ab); }).then(function (buf) {
        pending = marks.map(function (m, i) {
          var end = i + 1 < marks.length ? marks[i + 1] : Math.min(buf.duration, endAt + 0.3);
          return sliceBuffer(buf, m, end);
        });
      }).catch(function () { toast('Không xử lý được bản thu, vui lòng thu lại.'); });
    }

    function use() {
      if (!pending) { toast('Đang xử lý bản thu, chờ một chút rồi bấm lại.'); return; }
      pending.forEach(function (b, i) {
        if (state.scenes[i]) state.scenes[i].voice = { buffer: b, url: URL.createObjectURL(bufferToWav(b)) };
      });
      close();
      refreshVoiceUI();
      schedulePreview();
      toast('Đã lưu giọng đọc cho ' + pending.length + ' cảnh. Video tự khớp theo giọng của bạn!');
    }

    function bind() {
      $('pStart').onclick = start;
      $('pNextBtn').onclick = next;
      $('pRetry').onclick = function () { close(); open(); };
      $('pRetry2').onclick = reset;
      $('pUse').onclick = use;
      $('pClose').onclick = close;
      document.addEventListener('keydown', function (e) {
        if ($('prompter').hidden || !recording) return;
        if (e.code === 'Space' || e.code === 'Enter' || e.code === 'ArrowRight') { e.preventDefault(); next(); }
      });
    }

    return { open: open, bind: bind };
  })();

  /* ---------- Bước 5: hiệu ứng & nhạc ---------- */

  function fillSelect(id, map, value, labelKey) {
    var sel = $(id);
    Object.keys(map).forEach(function (k) {
      var o = document.createElement('option');
      o.value = k;
      o.textContent = labelKey ? map[k][labelKey] : map[k];
      sel.appendChild(o);
    });
    sel.value = value;
    return sel;
  }

  function bindSettings() {
    var R = window.BdsRender, S = state.settings;
    function onSet(key) { return function (e) { S[key] = e.target.type === 'checkbox' ? e.target.checked : e.target.value; save(); schedulePreview(); }; }
    fillSelect('formatSelect', R.FORMATS, S.format, 'label').onchange = onSet('format');
    fillSelect('themeSelect', R.THEMES, S.theme, 'label').onchange = onSet('theme');
    fillSelect('transitionSelect', R.TRANSITIONS, S.transition).onchange = onSet('transition');
    fillSelect('textFxSelect', R.TEXT_FX, S.textFx).onchange = onSet('textFx');
    fillSelect('gradeSelect', R.GRADES, S.grade || 'dien-anh', 'label').onchange = onSet('grade');
    $('subStyleSelect').value = S.subStyle || 'kinetic';
    $('subStyleSelect').onchange = onSet('subStyle');
    var bsel = $('beautySelect');
    Object.keys(window.BdsBeauty.LEVELS).forEach(function (k) {
      var o = document.createElement('option'); o.value = k; o.textContent = window.BdsBeauty.LEVELS[k].label; bsel.appendChild(o);
    });
    bsel.value = S.beauty || 'vua';
    bsel.onchange = onSet('beauty');
    var shift = $('textShift');
    var showShift = function () { var v = +S.textShift || 0; $('textShiftLabel').textContent = (v > 0 ? 'sớm ' : v < 0 ? 'muộn ' : '') + Math.abs(v).toFixed(2).replace('.', ',') + ' giây'; };
    shift.value = S.textShift || 0;
    showShift();
    shift.oninput = function () { S.textShift = +shift.value; showShift(); save(); schedulePreview(); };
    $('paceSelect').value = S.pace || 'auto';
    $('paceSelect').onchange = onSet('pace');
    $('endStyleSelect').value = S.endStyle || 'pill';
    $('endStyleSelect').onchange = onSet('endStyle');
    fillSelect('moodSelect', window.BdsAudio.MOODS, state.music.mood).onchange = function (e) { state.music.mood = e.target.value; save(); };
    [['sfxToggle', 'sfx'], ['emphToggle', 'emphZoom'], ['pipToggle', 'pip'], ['faceToggle', 'faceTrack'], ['behindToggle', 'textBehind'],
      ['nameToggle', 'nameTag'], ['leakToggle', 'leak'], ['vignetteToggle', 'vignette'], ['grainToggle', 'grain'], ['subToggle', 'subtitles'], ['introToggle', 'introCard'], ['endToggle', 'endCard'], ['priceToggle', 'priceTag'], ['autoTrim', 'autoTrim']].forEach(function (p) {
      $(p[0]).checked = S[p[1]] !== false;
      $(p[0]).onchange = function (e) { onSet(p[1])(e); if (p[1] === 'autoTrim') renderShoot(); };
    });
    $('musicInput').onchange = function (e) {
      var f = e.target.files[0];
      if (f) useMusicFile(f);
    };
    $('btnMusicLink').onclick = function () { musicFromLink($('musicLink').value.trim()); };
    $('btnMusicClear').onclick = function () {
      state.music.buffer = null;
      state.music.name = '';
      $('musicInput').value = '';
      showMusicNow();
      toast('Đã quay lại nhạc nền có sẵn.');
    };
    showMusicNow();
    var vol = $('musicVol');
    vol.value = state.music.vol;
    $('musicVolLabel').textContent = state.music.vol + '%';
    vol.oninput = function () {
      state.music.vol = +vol.value;
      $('musicVolLabel').textContent = vol.value + '%';
      save();
    };
  }

  /* ---------- Nhạc của bạn: file hoặc link ---------- */

  function showMusicNow() {
    var on = !!state.music.buffer;
    $('musicNow').hidden = !on;
    if (on) $('musicNowName').textContent = '🎵 Đang dùng: ' + state.music.name + ' (' + Math.round(state.music.buffer.duration) + ' giây)';
  }

  function useMusicFile(f) {
    return f.arrayBuffer().then(function (ab) { return getAudioCtx().decodeAudioData(ab); }).then(function (buf) {
      state.music.buffer = buf;
      state.music.name = f.name;
      showMusicNow();
      toast('Đã dùng nhạc: ' + f.name);
    }).catch(function () { toast('Không đọc được file nhạc này. Hãy dùng file mp3 hoặc m4a.'); });
  }

  function musicFromLink(url) {
    if (!url) { toast('Dán link nhạc vào ô trước đã.'); return; }
    if (/youtube\.com|youtu\.be|tiktok\.com|zingmp3|nhaccuatui|spotify|soundcloud|facebook\.com/i.test(url)) {
      toast('Link YouTube, TikTok, Zing… không tải trực tiếp được. Hãy tải bài về máy rồi chọn file, hoặc để file lên Google Drive và dán link Drive.', 7000);
      return;
    }
    var btn = $('btnMusicLink');
    btn.disabled = true;
    btn.textContent = 'Đang tải…';
    var I = window.BdsImporter, job;
    if (I.driveIds(url).length) {
      var key = ($('driveKey').value || '').trim();
      job = I.fromDrive(url, key).then(function (files) {
        var f = files.filter(function (x) { return /^audio\//.test(x.type) || /\.(mp3|m4a|wav|aac|ogg)$/i.test(x.name); })[0];
        if (!f) throw new Error('Trong link Drive không có file nhạc (mp3, m4a, wav).');
        return f;
      });
    } else {
      job = fetch(url).then(function (r) {
        if (!r.ok) throw new Error('Link lỗi ' + r.status);
        return r.blob();
      }).then(function (b) {
        var name = decodeURIComponent(url.split('?')[0].split('/').pop() || 'nhac') || 'nhac';
        return new File([b], name, { type: b.type });
      }, function (e) {
        if (/Link lỗi/.test(e.message)) throw e;
        throw new Error('Trang này không cho tải nhạc trực tiếp. Hãy tải bài về máy rồi chọn file, hoặc để lên Google Drive và dán link Drive.');
      });
    }
    job.then(useMusicFile).catch(function (e) {
      if (e.message === 'NEED_KEY') {
        toast('Link Google Drive cần “khoá Google” (ở Bước 1, mục link Drive). Hoặc tải bài về máy rồi chọn file.', 7000);
        $('driveKeyBox').open = true;
      } else toast(e.message, 7000);
    }).then(function () {
      btn.disabled = false;
      btn.textContent = 'Lấy nhạc';
    });
  }

  /* ---------- Xem trước & phát ---------- */

  var canvas = null;
  var previewTime = 2.4;
  var previewQueued = false;

  function schedulePreview() {
    if (previewQueued || Player.busy()) return;
    previewQueued = true;
    requestAnimationFrame(function () {
      previewQueued = false;
      if (Player.busy()) return;
      var tl = timeline(state.previewKind);
      var r = new window.BdsRender.Renderer(canvas, tl, project());
      var t = Math.min(previewTime, tl.total - 0.01);
      r.syncVideos(t, false);
      r.drawFrame(t);
      $('scrub').value = Math.round(t / tl.total * 1000);
      $('timeLabel').textContent = fmtTime(t) + ' / ' + fmtTime(tl.total);
    });
  }

  var Player = (function () {
    var running = null;

    function busy() { return !!running; }

    function stop() {
      if (!running) return;
      var r = running;
      running = null;
      cancelAnimationFrame(r.raf);
      r.engine.stopAll();
      r.engine.detachClips();
      try { r.engine.out.disconnect(); } catch (e) { /* đã ngắt */ }
      r.renderer.stopVideos();
      if (r.recorder && r.recorder.state !== 'inactive') r.recorder.stop();
      else if (r.resolve) r.resolve(null);
      $('btnPlay').textContent = '▶ Xem thử';
      schedulePreview();
    }

    function pickMime() {
      var types = [
        // MP4 H.264 đăng được mọi nơi; không có thì dùng WebM thay vì MP4 chứa VP9 (TikTok/Zalo hay từ chối)
        'video/mp4;codecs=avc1.640028,mp4a.40.2', 'video/mp4;codecs=avc1.42E01F,mp4a.40.2',
        'video/mp4;codecs=avc1,mp4a', 'video/mp4;codecs=avc1,opus',
        'video/webm;codecs=vp9,opus', 'video/webm;codecs=vp8,opus', 'video/webm', 'video/mp4'
      ];
      for (var i = 0; i < types.length; i++) {
        if (window.MediaRecorder && MediaRecorder.isTypeSupported(types[i])) return types[i];
      }
      return '';
    }

    function scheduleAudio(engine, tl, t0) {
      var vol = state.music.vol / 100;
      var ranges = [];
      tl.voices.forEach(function (v) {
        engine.playBuffer(v.buffer, t0 + v.at, engine.voice);
        ranges.push([v.at, v.at + v.buffer.duration]);
      });
      var attached = [];
      tl.items.forEach(function (it) {
        if (!it.audio) return;
        ranges.push([it.start, it.start + it.duration]);
        if (attached.indexOf(it.el) === -1) { attached.push(it.el); engine.attachClip(it.el); }
      });
      var mood = state.music.mood;
      if (state.music.buffer) {
        engine.playBuffer(state.music.buffer, t0, engine.music, { loop: true, duration: tl.total });
        engine.scheduleMusicVolume(t0, tl.total, 0.6 * vol, ranges);
      } else if (mood !== 'none') {
        engine.scheduleMusic(mood, t0, tl.total);
        engine.scheduleMusicVolume(t0, tl.total, 1.2 * vol, ranges);
      }
      tl.sfx.forEach(function (s) {
        var at = t0 + Math.max(0, s.at);
        if (s.type === 'whoosh') engine.whoosh(at, 0.75);
        else if (s.type === 'ting') engine.ting(at, s.freq);
        else if (s.type === 'pop') engine.pop(at);
        else if (s.type === 'boom') engine.boom(at);
        else if (s.type === 'swish') engine.swish(at);
        else if (s.type === 'slam') engine.slam(at);
        else if (s.type === 'swipe') engine.swipe(at);
        else if (s.type === 'ching') engine.ching(at);
        else if (s.type === 'riser') engine.riser(at, s.dur);
      });
    }

    /** Phát dòng thời gian; khi record = true thì ghi lại và trả về file video. */
    function play(tl, opts) {
      opts = opts || {};
      if (running) { stop(); return Promise.resolve(null); }
      if (window.speechSynthesis) window.speechSynthesis.cancel();
      var ctx = getAudioCtx();
      var fontReady = document.fonts && document.fonts.load ?
        Promise.all([document.fonts.load('900 40px "Be Vietnam Pro"'), document.fonts.load('700 40px "Be Vietnam Pro"')]).catch(function () {}) :
        Promise.resolve();
      var S = state.settings;
      var needVision = (S.faceTrack !== false || S.textBehind !== false || S.pip !== false) && tl.items.some(function (it) { return it.audio; });
      var visionReady = needVision && window.BdsVision ? Promise.race([window.BdsVision.load(), new Promise(function (r) { setTimeout(r, 12000); })]) : Promise.resolve();
      return Promise.all([ctx.resume(), fontReady, visionReady]).then(function () {
        return new Promise(function (resolve) {
          var renderer = new window.BdsRender.Renderer(canvas, tl, project());
          var engine = new window.BdsAudio.AudioEngine(ctx);
          engine.out.connect(ctx.destination);
          var total = tl.total;
          var recorder = null, chunks = [], mime = '';
          if (opts.record) {
            var dest = ctx.createMediaStreamDestination();
            engine.out.connect(dest);
            var vstream = canvas.captureStream(30);
            var stream = new MediaStream(vstream.getVideoTracks().concat(dest.stream.getAudioTracks()));
            mime = pickMime();
            recorder = new MediaRecorder(stream, mime ? { mimeType: mime, videoBitsPerSecond: 8000000, audioBitsPerSecond: 192000 } : undefined);
            recorder.ondataavailable = function (e) { if (e.data.size) chunks.push(e.data); };
            recorder.onstop = function () {
              var type = recorder.mimeType || mime || 'video/webm';
              var blob = new Blob(chunks, { type: type.split(';')[0] });
              var ready = type.indexOf('webm') !== -1 ? window.WebmFix.fixDuration(blob, total) : Promise.resolve(blob);
              ready.then(function (b) { resolve({ blob: b, type: type }); });
            };
          }
          var t0 = ctx.currentTime + 0.3;
          scheduleAudio(engine, tl, t0);
          renderer.drawFrame(0);
          if (recorder) recorder.start(500);
          running = { renderer: renderer, engine: engine, recorder: recorder, raf: 0, resolve: recorder ? null : resolve };
          $('btnPlay').textContent = opts.record ? '⏺ Đang xuất…' : '⏸ Dừng';
          var my = running;
          var setGain = function (el, v) { engine.setClipGain(el, v); };
          function frame() {
            if (running !== my) return;
            var t = ctx.currentTime - t0;
            var tt = Math.max(0, t);
            renderer.syncVideos(tt, true, setGain);
            renderer.drawFrame(tt);
            $('scrub').value = Math.round(tt / total * 1000);
            $('timeLabel').textContent = fmtTime(tt) + ' / ' + fmtTime(total);
            if (opts.onProgress) opts.onProgress(Math.min(1, tt / total));
            if (t >= total + 0.15) {
              previewTime = 2.4;
              stop();
              return;
            }
            my.raf = requestAnimationFrame(frame);
          }
          my.raf = requestAnimationFrame(frame);
        });
      });
    }

    return { play: play, stop: stop, busy: busy };
  })();

  function bindPlayer() {
    $('btnPlay').onclick = function () {
      if (exporting) return;
      if (Player.busy()) { Player.stop(); return; }
      if (!state.scenes.length) { toast('Chưa có kịch bản. Hãy tạo kịch bản ở Bước 2.'); return; }
      Player.play(timeline(state.previewKind));
    };
    $('scrub').addEventListener('input', function (e) {
      if (Player.busy()) return;
      previewTime = e.target.value / 1000 * timeline(state.previewKind).total;
      schedulePreview();
    });
    document.querySelectorAll('#previewTabs button').forEach(function (b) {
      b.onclick = function () {
        if (Player.busy()) Player.stop();
        state.previewKind = b.dataset.kind;
        document.querySelectorAll('#previewTabs button').forEach(function (x) { x.classList.toggle('active', x === b); });
        previewTime = 1.2;
        schedulePreview();
      };
    });
  }

  /* ---------- Bước 6: xuất video ---------- */

  var exporting = false;

  function renderChecklist() {
    var miss = missingInfo();
    var media = 0, video = 0, empty = 0;
    state.scenes.forEach(function (s) {
      media += s.media.length;
      s.media.forEach(function (m) { if (m.isVideo) video++; });
      if (!s.media.length) empty++;
    });
    var voiced = state.scenes.filter(function (s) { return s.voice; }).length;
    var items = [
      [!miss.length, miss.length ? 'Thiếu thông tin: ' + miss.map(function (k) { return REQUIRED[k]; }).join(', ') : 'Thông tin dự án đã đủ'],
      [state.scenes.length > 0, 'Kịch bản ' + state.scenes.length + ' cảnh'],
      [media > 0, media + ' ảnh/clip (' + video + ' clip)' + (empty ? ' · ' + empty + ' cảnh chưa có hình, sẽ hiện chữ trên nền màu' : '')],
      [true, state.voiceMode === 'record' ? 'Giọng lồng tiếng: ' + voiced + '/' + state.scenes.length + ' cảnh' :
        state.voiceMode === 'clip' ? 'Giọng: tiếng nói trong clip quay' : 'Không có giọng đọc'],
      [true, 'Nhạc: ' + (state.music.buffer ? state.music.name : window.BdsAudio.MOODS[state.music.mood])],
      [true, 'Khung hình: ' + window.BdsRender.FORMATS[state.settings.format].label]
    ];
    $('checklist').innerHTML = items.map(function (it) { return '<div>' + (it[0] ? '✅' : '⚠️') + ' ' + it[1] + '</div>'; }).join('');
    try {
      $('durFull').textContent = '· ' + fmtTime(timeline('full').total);
      $('durTrailer').textContent = '· ' + fmtTime(timeline('trailer').total);
    } catch (e) { /* chưa có cảnh */ }
  }

  function slug(s) {
    return (s || 'video-bds').normalize('NFD').replace(/[̀-ͯ]/g, '').replace(/đ/gi, 'd')
      .toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '') || 'video-bds';
  }

  function addResult(title, res) {
    var ext = res.type.indexOf('mp4') !== -1 ? 'mp4' : 'webm';
    var url = URL.createObjectURL(res.blob);
    var name = slug(state.info.ten || state.info.loai) + '-' + slug(title) + '-' + state.settings.format.replace(':', 'x') + '.' + ext;
    var card = document.createElement('div');
    card.className = 'result-card';
    card.innerHTML = '<b>' + esc(title) + '</b><video controls playsinline src="' + url + '"></video>' +
      '<a class="btn accent" download="' + name + '" href="' + url + '">⬇️ Tải về (' + ext.toUpperCase() + ', ' + (res.blob.size / 1048576).toFixed(1) + ' MB)</a>';
    $('exportResults').appendChild(card);
    return ext;
  }

  function doExport() {
    if (exporting) return;
    if (!window.MediaRecorder || !canvas.captureStream) {
      toast('Trình duyệt này chưa hỗ trợ xuất video. Hãy dùng Google Chrome hoặc Microsoft Edge bản mới.', 5000);
      return;
    }
    if (!state.scenes.length) { toast('Chưa có kịch bản.'); return; }
    var jobs = [];
    if ($('outFull').checked) jobs.push({ title: 'Video đầy đủ', tl: function () { return timeline('full'); } });
    if ($('outTrailer').checked) jobs.push({ title: 'Trailer', tl: function () { return timeline('trailer'); } });
    if ($('outScenes').checked) state.scenes.forEach(function (s, i) {
      jobs.push({ title: 'Cảnh ' + (i + 1) + ' ' + window.BdsTimeline.cleanTitle(s.title), tl: function () { return timeline('scene', i); } });
    });
    if (!jobs.length) { toast('Hãy chọn ít nhất một bản cần xuất.'); return; }
    if (Player.busy()) Player.stop();
    exporting = true;
    $('btnExport').disabled = true;
    $('exportResults').innerHTML = '';
    var prog = $('exportProgress'), bar = prog.querySelector('.bar'), label = prog.querySelector('span');
    prog.hidden = false;
    var lastExt = 'mp4';
    var chain = Promise.resolve();
    jobs.forEach(function (job, ji) {
      chain = chain.then(function () {
        bar.style.width = '0%';
        label.textContent = 'Đang chuẩn bị ' + job.title + '…';
        return Player.play(job.tl(), {
          record: true,
          onProgress: function (p) {
            bar.style.width = Math.round(p * 100) + '%';
            label.textContent = '(' + (ji + 1) + '/' + jobs.length + ') ' + job.title + ': ' + Math.round(p * 100) + '% · đừng chuyển tab';
          }
        }).then(function (res) { if (res) lastExt = addResult(job.title, res); });
      });
    });
    chain.then(function () {
      toast('🎉 Xuất xong ' + jobs.length + ' video! Bấm “Tải về” dưới mỗi video.' +
        (lastExt === 'webm' ? ' (File WebM đăng được YouTube, Facebook, TikTok bản web.)' : ''), 6000);
    }).catch(function (e) {
      toast('Có lỗi khi xuất video: ' + (e && e.message ? e.message : e), 6000);
    }).then(function () {
      exporting = false;
      $('btnExport').disabled = false;
      prog.hidden = true;
    });
  }

  /* ---------- Hướng dẫn & mẫu ---------- */

  function bindHelp(seen) {
    var m = $('helpModal');
    $('btnHelp').onclick = function () { m.hidden = false; };
    $('helpClose').onclick = $('helpOk').onclick = function () { m.hidden = true; save(); };
    m.addEventListener('click', function (e) { if (e.target === m) m.hidden = true; });
    if (!seen) m.hidden = false;
  }

  function loadDemo(key) {
    var preset = window.BdsDemo.PRESETS[key];
    setInfo(preset.info);
    window.BdsDemo.makeImages(key, function (images) {
      if (preset.script) {
        state.scenes = preset.script.map(function (sc) {
          var media = (sc.images || []).map(function (k) { return { el: images[k].el, isVideo: false, url: images[k].url, name: k }; });
          return newScene({ title: sc.title, text: sc.text, bigText: sc.bigText, shotNote: sc.shotNote, media: media });
        });
        state.voiceMode = 'none';
      } else {
        var items = Object.keys(images).map(function (k) { return { el: images[k].el, isVideo: false, url: images[k].url, name: k, caption: images[k].caption }; });
        state.scenes = quickScenes(items);
      }
      state.variant = 0;
      refreshVoiceUI();
      renderScenes();
      save();
      previewTime = 2.4;
      schedulePreview();
      toast('Đã nạp mẫu! Bấm ▶ Xem thử, chuyển qua lại “Video đầy đủ / Trailer”, hoặc bấm “Tiếp tục” để xem từng bước.', 5000);
    });
  }

  /* ---------- Khởi động ---------- */

  function init() {
    canvas = $('canvas');
    var seen = load();
    renderStepper();
    bindInfo();
    bindScript();
    bindVoice();
    Prompter.bind();
    Camera.bind();
    bindSettings();
    bindPlayer();
    bindHelp(seen);
    bindAutoProject();
    bindTrack();
    $('btnDemo').onclick = function () { loadDemo('mau'); };
    $('btnDemoF2').onclick = function () { loadDemo('f2'); };
    $('btnPrev').onclick = function () { goStep(state.step - 1); };
    $('btnNext').onclick = function () { goStep(state.step + 1); };
    $('btnExport').onclick = doExport;
    refreshVoiceUI();
    showStep();
    schedulePreview();
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(schedulePreview);
    // Cài thành ứng dụng (chỉ khi mở qua địa chỉ web https)
    if ('serviceWorker' in navigator && /^https?:$/.test(location.protocol)) {
      navigator.serviceWorker.register('sw.js').catch(function () {});
    }
    var installPrompt = null;
    window.addEventListener('beforeinstallprompt', function (e) {
      e.preventDefault();
      installPrompt = e;
      $('btnInstall').hidden = false;
    });
    $('btnInstall').onclick = function () {
      if (!installPrompt) return;
      installPrompt.prompt();
      installPrompt.userChoice.then(function () { installPrompt = null; $('btnInstall').hidden = true; });
    };
    window.addEventListener('appinstalled', function () { $('btnInstall').hidden = true; toast('Đã cài ứng dụng! Mở từ màn hình chính hoặc menu Start.'); });
    window.addEventListener('beforeunload', function (e) {
      if (exporting) { e.preventDefault(); e.returnValue = ''; }
    });
  }

  // Cho phép kiểm thử tự động truy cập trạng thái
  window.BdsApp = { state: state, goStep: goStep, loadDemo: loadDemo, Player: Player, project: project, timeline: timeline, createMedia: createMedia };

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
  else init();
})();
