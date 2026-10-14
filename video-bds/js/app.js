/* Điều khiển giao diện: các bước, ảnh, kịch bản, thu giọng, xem thử, xuất video. */
(function () {
  'use strict';

  var $ = function (id) { return document.getElementById(id); };
  var STEPS = ['Thông tin', 'Ảnh & clip', 'Kịch bản', 'Giọng đọc', 'Nhạc & hiệu ứng', 'Xuất video'];
  var REQUIRED = { loai: 'Loại BĐS', viTri: 'Vị trí', gia: 'Giá', moiGioi: 'Tên môi giới', sdt: 'Số điện thoại' };
  var STORE_KEY = 'video-bds-v1';

  var state = {
    step: 1,
    info: {},
    media: [],
    logo: null,
    lines: [],
    durations: [],
    durationsLocked: false,
    captionsKey: '',
    style: 'chuyen-nghiep',
    variant: 0,
    voice: { mode: 'none', buffer: null, url: '', fit: true, name: '' },
    music: { mood: 'nhe-nhang', buffer: null, name: '', vol: 70 },
    settings: { format: '9:16', theme: 'vang', transition: 'mix', sfx: true, subtitles: true }
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

  /* ---------- Lưu / đọc thông tin đã nhập ---------- */

  function save() {
    try {
      localStorage.setItem(STORE_KEY, JSON.stringify({
        info: state.info, style: state.style, settings: state.settings,
        mood: state.music.mood, vol: state.music.vol, helpSeen: true
      }));
    } catch (e) { /* trình duyệt chặn lưu trữ: bỏ qua */ }
  }

  function load() {
    try {
      var d = JSON.parse(localStorage.getItem(STORE_KEY) || 'null');
      if (!d) return false;
      state.info = d.info || {};
      state.style = d.style || state.style;
      Object.assign(state.settings, d.settings || {});
      state.music.mood = d.mood || state.music.mood;
      state.music.vol = d.vol != null ? d.vol : state.music.vol;
      return !!d.helpSeen;
    } catch (e) { return false; }
  }

  /* ---------- Dự án → bộ dựng hình ---------- */

  function autoDurations() {
    return state.lines.map(function (l, i) {
      var v = state.durations[i];
      return v ? v : window.ScriptGen.readSeconds(l);
    });
  }

  function effectiveDurations() {
    var d = autoDurations();
    var v = state.voice;
    if (v.mode === 'upload' && v.buffer && v.fit && d.length) {
      var target = v.buffer.duration + 1.4;
      var sum = d.reduce(function (a, b) { return a + b; }, 0);
      d = d.map(function (x) { return x * target / sum; });
    }
    return d;
  }

  function project() {
    var locked = state.durationsLocked || (state.voice.mode === 'upload' && state.voice.buffer && state.voice.fit);
    return {
      info: state.info,
      media: state.media,
      logo: state.logo,
      lines: state.lines.length ? state.lines : defaultLines(),
      durations: effectiveDurations(),
      durationsLocked: !!locked,
      settings: state.settings
    };
  }

  function defaultLines() {
    return window.ScriptGen.generate(state.info, state.media.map(function (m) { return m.caption; }), state.style, state.variant);
  }

  function captionsKey() {
    return state.media.map(function (m) { return m.caption; }).join('|');
  }

  function regenerate(silent) {
    var oldLen = state.lines.length;
    state.lines = defaultLines();
    state.captionsKey = captionsKey();
    if (state.lines.length !== oldLen) {
      state.durations = [];
      if (state.voice.mode === 'record' && state.voice.buffer) {
        state.durationsLocked = false;
        state.voice.buffer = null;
        state.voice.url = '';
        if (!silent) toast('Số cảnh đã thay đổi, bạn cần thu lại giọng đọc ở Bước 4.');
      }
    }
    renderScript();
    schedulePreview();
  }

  /* ---------- Thanh bước ---------- */

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
    if (n > state.step) {
      if (state.step <= 1 && n > 1) {
        var miss = missingInfo();
        if (miss.length) {
          toast('Bạn cần điền: ' + miss.map(function (k) { return REQUIRED[k]; }).join(', '));
          miss.forEach(function (k) {
            var el = document.querySelector('[data-info="' + k + '"]');
            if (el) el.style.borderColor = 'var(--danger)';
          });
          if (state.step !== 1) state.step = 1;
          showStep();
          return;
        }
      }
      if (n > 2 && !state.media.length) {
        toast('Hãy thêm ít nhất 1 ảnh hoặc clip ở Bước 2.');
        state.step = 2;
        showStep();
        return;
      }
    }
    state.step = Math.max(1, Math.min(STEPS.length, n));
    if (state.step === 3) {
      if (state.lines.length !== state.media.length + 2) regenerate(true);
      else renderScript();
    }
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
  }

  function setInfo(info) {
    state.info = Object.assign({}, info);
    document.querySelectorAll('[data-info]').forEach(function (el) {
      el.value = state.info[el.dataset.info] || '';
      el.style.borderColor = '';
    });
    save();
  }

  /* ---------- Bước 2: ảnh & clip ---------- */

  function loadFile(f) {
    return new Promise(function (resolve) {
      var url = URL.createObjectURL(f);
      if (f.type.indexOf('video') === 0) {
        var v = document.createElement('video');
        v.muted = true;
        v.playsInline = true;
        v.preload = 'auto';
        v.crossOrigin = 'anonymous';
        v.onloadeddata = function () { resolve({ el: v, caption: '', isVideo: true, url: url, name: f.name }); };
        v.onerror = function () { toast('Không đọc được clip ' + f.name + '. Hãy thử file MP4.'); resolve(null); };
        v.addEventListener('seeked', schedulePreview);
        v.src = url;
      } else if (f.type.indexOf('image') === 0) {
        var img = new Image();
        img.onload = function () { resolve({ el: img, caption: '', isVideo: false, url: url, name: f.name }); };
        img.onerror = function () { toast('Không đọc được ảnh ' + f.name + '. Hãy dùng JPG hoặc PNG.'); resolve(null); };
        img.src = url;
      } else {
        resolve(null);
      }
    });
  }

  function addFiles(files) {
    var list = Array.prototype.slice.call(files || []);
    if (!list.length) return;
    Promise.all(list.map(loadFile)).then(function (items) {
      items.forEach(function (it) { if (it) state.media.push(it); });
      renderMedia();
      schedulePreview();
      toast('Đã thêm ' + items.filter(Boolean).length + ' ảnh/clip. Nhớ ghi tên phòng cho từng ảnh nhé!');
    });
  }

  function renderMedia() {
    var ol = $('mediaList');
    ol.innerHTML = '';
    state.media.forEach(function (m, i) {
      var li = document.createElement('li');
      li.className = 'media-item';
      var thumb = m.isVideo ? '<video class="thumb" muted src="' + m.url + '"></video>' : '<img class="thumb" alt="" src="' + m.url + '">';
      li.innerHTML =
        '<div class="idx">' + (i + 1) + '</div>' + thumb +
        '<div><input list="roomList" placeholder="Tên phòng / khu vực, VD: Phòng khách" value="">' +
        (i === 0 ? '<div class="cover-badge">★ Ảnh bìa (hiện ở đầu video)</div>' : '') +
        (m.isVideo ? '<div class="muted small-text">🎞 Clip ' + (m.el.duration ? Math.round(m.el.duration) + ' giây' : '') + '</div>' : '') +
        '</div>' +
        '<div class="tools">' +
        '<button class="btn" type="button" title="Lên trên" data-a="up">▲</button>' +
        '<button class="btn" type="button" title="Xuống dưới" data-a="down">▼</button>' +
        '<button class="btn" type="button" title="Xoá" data-a="del">🗑</button></div>';
      var input = li.querySelector('input');
      input.value = m.caption;
      input.addEventListener('input', function () {
        m.caption = input.value;
        schedulePreview();
      });
      li.querySelectorAll('[data-a]').forEach(function (b) {
        b.onclick = function () {
          var a = b.dataset.a;
          if (a === 'up' && i > 0) swap(i, i - 1);
          else if (a === 'down' && i < state.media.length - 1) swap(i, i + 1);
          else if (a === 'del') state.media.splice(i, 1);
          renderMedia();
          schedulePreview();
        };
      });
      ol.appendChild(li);
    });
  }

  function swap(a, b) {
    var t = state.media[a];
    state.media[a] = state.media[b];
    state.media[b] = t;
  }

  function bindMedia() {
    var dz = $('dropzone');
    $('mediaInput').addEventListener('change', function (e) { addFiles(e.target.files); e.target.value = ''; });
    ['dragenter', 'dragover'].forEach(function (ev) {
      dz.addEventListener(ev, function (e) { e.preventDefault(); dz.classList.add('over'); });
    });
    ['dragleave', 'drop'].forEach(function (ev) {
      dz.addEventListener(ev, function (e) { e.preventDefault(); dz.classList.remove('over'); });
    });
    dz.addEventListener('drop', function (e) { addFiles(e.dataTransfer.files); });
  }

  /* ---------- Bước 3: kịch bản ---------- */

  function sceneLabel(i) {
    if (i === 0) return 'Mở đầu (ảnh bìa + giá)';
    if (i === state.lines.length - 1) return 'Kết thúc: kêu gọi liên hệ';
    var m = state.media[i - 1];
    return 'Cảnh ' + i + (m && m.caption ? ': ' + m.caption : '');
  }

  function sceneThumb(i) {
    var m = i === 0 ? state.media[0] : (i === state.lines.length - 1 ? null : state.media[i - 1]);
    if (!m || m.isVideo) return '';
    return '<img alt="" src="' + m.url + '">';
  }

  function renderScript() {
    var ol = $('scriptList');
    ol.innerHTML = '';
    var notice = $('scriptNotice');
    if (state.captionsKey && state.captionsKey !== captionsKey()) {
      notice.hidden = false;
      notice.innerHTML = 'Bạn vừa đổi tên phòng hoặc thứ tự ảnh. <button class="btn small" type="button" id="btnRefresh">Cập nhật kịch bản theo ảnh mới</button>';
      $('btnRefresh').onclick = function () { regenerate(); notice.hidden = true; };
    } else if (state.durationsLocked) {
      notice.hidden = false;
      notice.className = 'notice ok';
      notice.textContent = '🎙️ Thời lượng từng cảnh đang khớp theo bản thu giọng của bạn. Nếu sửa câu, hãy thu lại ở Bước 4 cho khớp.';
    } else {
      notice.hidden = true;
      notice.className = 'notice';
    }
    var autos = state.lines.map(function (l) { return window.ScriptGen.readSeconds(l); });
    var eff = effectiveDurations();
    state.lines.forEach(function (line, i) {
      var li = document.createElement('li');
      li.className = 'script-item';
      var locked = state.durationsLocked || (state.voice.mode === 'upload' && state.voice.buffer && state.voice.fit);
      li.innerHTML =
        '<div class="head">' + sceneThumb(i) + '<span class="tag">' + sceneLabel(i) + '</span>' +
        '<span class="dur">⏱ <input type="number" min="1.5" max="20" step="0.5"' + (locked ? ' disabled' : '') + '> giây</span></div>' +
        '<textarea rows="2"></textarea>';
      var ta = li.querySelector('textarea');
      var du = li.querySelector('input');
      ta.value = line;
      du.placeholder = autos[i].toFixed(1);
      du.value = locked ? eff[i].toFixed(1) : (state.durations[i] || '');
      ta.addEventListener('input', function () {
        state.lines[i] = ta.value;
        if (!state.durations[i]) du.placeholder = window.ScriptGen.readSeconds(ta.value).toFixed(1);
        updateTotal();
        schedulePreview();
      });
      du.addEventListener('input', function () {
        var v = parseFloat(du.value);
        state.durations[i] = v >= 1.5 ? Math.min(20, v) : null;
        updateTotal();
        schedulePreview();
      });
      ol.appendChild(li);
    });
    $('styleSelect').value = state.style;
    updateTotal();
  }

  function totalSeconds() {
    try { return window.BdsRender.buildTimeline(project()).total; } catch (e) { return 0; }
  }

  function updateTotal() {
    $('totalDur').textContent = Math.round(totalSeconds());
  }

  var speaking = false;
  function speakScript() {
    var synth = window.speechSynthesis;
    if (!synth) { toast('Trình duyệt này không hỗ trợ đọc thử.'); return; }
    if (speaking) { synth.cancel(); speaking = false; $('btnSpeak').textContent = '🔊 Nghe máy đọc thử'; return; }
    var voices = synth.getVoices();
    var vi = voices.filter(function (v) { return /^vi/i.test(v.lang); })[0];
    if (!vi) toast('Máy chưa có giọng tiếng Việt nên giọng đọc có thể không chuẩn. Dùng Chrome hoặc Edge sẽ tốt hơn.', 4500);
    var u = new SpeechSynthesisUtterance(state.lines.join('. '));
    u.lang = 'vi-VN';
    if (vi) u.voice = vi;
    u.rate = 1;
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
    sel.addEventListener('change', function () { state.style = sel.value; save(); regenerate(); });
    $('btnRegen').onclick = function () { state.variant++; regenerate(); toast('Đã viết lại kịch bản kiểu khác.'); };
    $('btnSpeak').onclick = speakScript;
  }

  /* ---------- Bước 4: giọng đọc ---------- */

  function voiceStatus(msg) {
    var el = $('voiceStatus');
    el.hidden = !msg;
    el.className = 'notice ok';
    el.innerHTML = msg || '';
  }

  function refreshVoiceUI() {
    var mode = state.voice.mode;
    $('voiceRecordBox').hidden = mode !== 'record';
    $('voiceUploadBox').hidden = mode !== 'upload';
    if (mode === 'none') voiceStatus('');
    else if (state.voice.buffer) {
      voiceStatus('✔ Đã có giọng đọc (' + fmtTime(state.voice.buffer.duration) + '). Bấm <b>▶ Xem thử</b> để nghe cùng video.' +
        (state.voice.url ? '<br><audio controls src="' + state.voice.url + '" style="width:100%;margin-top:8px"></audio>' : ''));
    } else voiceStatus('');
  }

  function bindVoice() {
    document.querySelectorAll('input[name=voiceMode]').forEach(function (r) {
      r.addEventListener('change', function () {
        if (!r.checked) return;
        if (state.voice.mode !== r.value) {
          state.voice.buffer = null;
          state.voice.url = '';
          state.durationsLocked = false;
        }
        state.voice.mode = r.value;
        refreshVoiceUI();
        schedulePreview();
      });
    });
    $('voiceInput').addEventListener('change', function (e) {
      var f = e.target.files[0];
      if (!f) return;
      f.arrayBuffer().then(function (ab) { return getAudioCtx().decodeAudioData(ab); }).then(function (buf) {
        state.voice.buffer = buf;
        state.voice.url = URL.createObjectURL(f);
        refreshVoiceUI();
        schedulePreview();
      }).catch(function () { toast('Không đọc được file âm thanh này. Hãy thử MP3 hoặc WAV.'); });
    });
    $('fitToVoice').addEventListener('change', function (e) { state.voice.fit = e.target.checked; schedulePreview(); });
    $('btnOpenPrompter').onclick = Prompter.open;
  }

  var Prompter = (function () {
    var idx = 0, marks = [], recStart = 0, rec = null, stream = null, chunks = [], timer = null;
    var pending = null, recording = false, endAt = 0;

    function show(i) {
      var lines = state.lines;
      $('pCounter').textContent = 'Câu ' + (i + 1) + '/' + lines.length;
      $('pScene').textContent = sceneLabel(i);
      $('pText').textContent = lines[i] || '';
      $('pNext').textContent = lines[i + 1] ? 'Tiếp theo: ' + lines[i + 1] : '';
      $('pNextBtn').textContent = i === lines.length - 1 ? '■ Kết thúc' : 'Câu tiếp ▶';
    }

    function reset() {
      idx = 0;
      marks = [];
      recording = false;
      pending = null;
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
      if (state.lines.length !== state.media.length + 2) regenerate(true);
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
        toast('Trình duyệt không cho dùng micro. Hãy mở bằng Chrome và qua địa chỉ https hoặc file trên máy.', 5000);
        return;
      }
      navigator.mediaDevices.getUserMedia({ audio: { echoCancellation: true, noiseSuppression: true, autoGainControl: true } })
        .then(function (s) {
          stream = s;
          $('pStart').hidden = true;
          var n = 3;
          var cd = $('pCountdown');
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
      if (idx >= state.lines.length - 1) {
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
      var url = URL.createObjectURL(blob);
      $('pAudio').src = url;
      $('pReview').hidden = false;
      $('pText').textContent = '✔ Thu xong! Nghe lại bên dưới.';
      $('pNext').textContent = '';
      blob.arrayBuffer().then(function (ab) { return getAudioCtx().decodeAudioData(ab); }).then(function (buf) {
        var durs = marks.map(function (m, i) {
          var end = i + 1 < marks.length ? marks[i + 1] : endAt + 0.8;
          return Math.max(1.5, end - m);
        });
        pending = { buffer: buf, url: url, durations: durs };
      }).catch(function () { toast('Không xử lý được bản thu, vui lòng thu lại.'); });
    }

    function use() {
      if (!pending) { toast('Đang xử lý bản thu, chờ một chút rồi bấm lại.'); return; }
      state.voice.buffer = pending.buffer;
      state.voice.url = pending.url;
      state.durations = pending.durations;
      state.durationsLocked = true;
      close();
      refreshVoiceUI();
      schedulePreview();
      toast('Đã lưu giọng đọc. Video đã tự khớp theo giọng của bạn!');
    }

    function bind() {
      $('pStart').onclick = start;
      $('pNextBtn').onclick = next;
      $('pRetry').onclick = function () { close(); open(); };
      $('pRetry2').onclick = function () { reset(); };
      $('pUse').onclick = use;
      $('pClose').onclick = close;
      document.addEventListener('keydown', function (e) {
        if ($('prompter').hidden || !recording) return;
        if (e.code === 'Space' || e.code === 'Enter' || e.code === 'ArrowRight') { e.preventDefault(); next(); }
      });
    }

    return { open: open, bind: bind };
  })();

  /* ---------- Bước 5: nhạc & kiểu video ---------- */

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
    var R = window.BdsRender;
    fillSelect('formatSelect', R.FORMATS, state.settings.format, 'label').addEventListener('change', function (e) {
      state.settings.format = e.target.value; save(); schedulePreview();
    });
    fillSelect('themeSelect', R.THEMES, state.settings.theme, 'label').addEventListener('change', function (e) {
      state.settings.theme = e.target.value; save(); schedulePreview();
    });
    fillSelect('transitionSelect', R.TRANSITIONS, state.settings.transition).addEventListener('change', function (e) {
      state.settings.transition = e.target.value; save(); schedulePreview();
    });
    fillSelect('moodSelect', window.BdsAudio.MOODS, state.music.mood).addEventListener('change', function (e) {
      state.music.mood = e.target.value; save();
    });
    $('musicInput').addEventListener('change', function (e) {
      var f = e.target.files[0];
      if (!f) { state.music.buffer = null; return; }
      f.arrayBuffer().then(function (ab) { return getAudioCtx().decodeAudioData(ab); }).then(function (buf) {
        state.music.buffer = buf;
        state.music.name = f.name;
        toast('Đã dùng nhạc: ' + f.name);
      }).catch(function () { toast('Không đọc được file nhạc này.'); });
    });
    var vol = $('musicVol');
    vol.value = state.music.vol;
    $('musicVolLabel').textContent = state.music.vol + '%';
    vol.addEventListener('input', function () {
      state.music.vol = +vol.value;
      $('musicVolLabel').textContent = vol.value + '%';
      save();
    });
    $('sfxToggle').checked = state.settings.sfx;
    $('sfxToggle').addEventListener('change', function (e) { state.settings.sfx = e.target.checked; save(); });
    $('subToggle').checked = state.settings.subtitles;
    $('subToggle').addEventListener('change', function (e) { state.settings.subtitles = e.target.checked; save(); schedulePreview(); });
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
      var r = new window.BdsRender.Renderer(canvas, project());
      var t = Math.min(previewTime, r.timeline.total - 0.01);
      r.syncVideos(t, false);
      r.drawFrame(t);
      $('scrub').value = Math.round(t / r.timeline.total * 1000);
      $('timeLabel').textContent = fmtTime(t) + ' / ' + fmtTime(r.timeline.total);
      if (state.step === 3) updateTotal();
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
      try { r.engine.out.disconnect(); } catch (e) { /* đã ngắt */ }
      r.renderer.timeline.scenes.forEach(function (s) { if (s.isVideo && s.media) s.media.pause(); });
      if (r.recorder && r.recorder.state !== 'inactive') r.recorder.stop();
      $('btnPlay').textContent = '▶ Xem thử';
      if (r.onStop) r.onStop();
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

    function scheduleAudio(engine, renderer, t0) {
      var total = renderer.timeline.total;
      var scenes = renderer.timeline.scenes;
      var TR = window.BdsRender.TR;
      var vol = state.music.vol / 100;
      var voiceRanges = [];
      if (state.voice.mode !== 'none' && state.voice.buffer) {
        engine.playBuffer(state.voice.buffer, t0 + 0.05, engine.voice, { duration: Math.min(state.voice.buffer.duration, total) });
        voiceRanges.push([0, state.voice.buffer.duration]);
      }
      if (state.music.buffer) {
        engine.playBuffer(state.music.buffer, t0, engine.music, { loop: true, duration: total });
        engine.scheduleMusicVolume(t0, total, 0.6 * vol, voiceRanges);
      } else if (state.music.mood !== 'none') {
        engine.scheduleMusic(state.music.mood, t0, total);
        engine.scheduleMusicVolume(t0, total, 1.6 * vol, voiceRanges);
      }
      if (state.settings.sfx) {
        engine.boom(t0 + 0.05);
        if (state.info.gia) engine.ting(t0 + 1.15);
        scenes.forEach(function (s, i) {
          if (i > 0) engine.whoosh(t0 + s.start - TR * 0.85, TR * 1.1);
          if (s.type === 'media' && s.caption) engine.pop(t0 + s.start + 0.15);
          if (s.type === 'outro' && state.info.sdt) engine.ting(t0 + s.start + 0.65, 1046.5);
        });
      }
    }

    function play(opts) {
      opts = opts || {};
      if (running) { stop(); return; }
      if (window.speechSynthesis) window.speechSynthesis.cancel();
      var ctx = getAudioCtx();
      var fontReady = document.fonts && document.fonts.load ?
        Promise.all([document.fonts.load('800 40px "Be Vietnam Pro"'), document.fonts.load('500 40px "Be Vietnam Pro"')]).catch(function () {}) :
        Promise.resolve();
      return Promise.all([ctx.resume(), fontReady]).then(function () {
        var renderer = new window.BdsRender.Renderer(canvas, project());
        var engine = new window.BdsAudio.AudioEngine(ctx);
        engine.out.connect(ctx.destination);
        var total = renderer.timeline.total;
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
            ready.then(function (b) { if (opts.onDone) opts.onDone(b, type); });
          };
        }
        var t0 = ctx.currentTime + 0.25;
        scheduleAudio(engine, renderer, t0);
        renderer.drawFrame(0);
        if (recorder) recorder.start(500);
        running = { renderer: renderer, engine: engine, recorder: recorder, raf: 0, onStop: opts.onStop };
        $('btnPlay').textContent = opts.record ? '⏺ Đang xuất…' : '⏸ Dừng';
        var my = running;
        function frame() {
          if (running !== my) return;
          var t = ctx.currentTime - t0;
          var tt = Math.max(0, t);
          renderer.syncVideos(tt, true);
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
    }

    return { play: play, stop: stop, busy: busy, pickMime: pickMime };
  })();

  function bindPlayer() {
    $('btnPlay').onclick = function () {
      if (exporting) return;
      Player.play();
    };
    $('scrub').addEventListener('input', function (e) {
      if (Player.busy()) return;
      previewTime = e.target.value / 1000 * totalSeconds();
      schedulePreview();
    });
  }

  /* ---------- Bước 6: xuất video ---------- */

  var exporting = false;

  function renderChecklist() {
    var miss = missingInfo();
    var items = [
      [!miss.length, miss.length ? 'Thiếu thông tin: ' + miss.map(function (k) { return REQUIRED[k]; }).join(', ') : 'Thông tin căn nhà đã đủ'],
      [state.media.length > 0, state.media.length + ' ảnh/clip'],
      [state.lines.length > 0, 'Kịch bản ' + state.lines.length + ' cảnh, dài khoảng ' + Math.round(totalSeconds()) + ' giây'],
      [true, state.voice.mode !== 'none' && state.voice.buffer ? 'Có giọng đọc' : 'Không có giọng đọc (chỉ nhạc và phụ đề)'],
      [true, 'Nhạc: ' + (state.music.buffer ? state.music.name : window.BdsAudio.MOODS[state.music.mood])],
      [true, 'Khung hình: ' + window.BdsRender.FORMATS[state.settings.format].label]
    ];
    $('checklist').innerHTML = items.map(function (it) {
      return '<div>' + (it[0] ? '✅' : '⚠️') + ' ' + it[1] + '</div>';
    }).join('');
  }

  function slug(s) {
    return (s || 'video-bds').normalize('NFD').replace(/[̀-ͯ]/g, '').replace(/đ/gi, 'd')
      .toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '') || 'video-bds';
  }

  function doExport() {
    if (exporting) return;
    if (!window.MediaRecorder || !canvas.captureStream) {
      toast('Trình duyệt này chưa hỗ trợ xuất video. Hãy dùng Google Chrome hoặc Microsoft Edge bản mới.', 5000);
      return;
    }
    if (state.lines.length !== state.media.length + 2) regenerate(true);
    if (Player.busy()) Player.stop();
    exporting = true;
    $('btnExport').disabled = true;
    $('exportResult').hidden = true;
    var prog = $('exportProgress');
    prog.hidden = false;
    var bar = prog.querySelector('.bar');
    var label = prog.querySelector('span');
    bar.style.width = '0%';
    label.textContent = 'Đang chuẩn bị…';
    Player.play({
      record: true,
      onProgress: function (p) {
        bar.style.width = Math.round(p * 100) + '%';
        label.textContent = 'Đang xuất video… ' + Math.round(p * 100) + '% (đừng chuyển tab)';
      },
      onStop: function () {
        label.textContent = 'Đang hoàn tất file…';
      },
      onDone: function (blob, type) {
        exporting = false;
        $('btnExport').disabled = false;
        prog.hidden = true;
        var ext = type.indexOf('mp4') !== -1 ? 'mp4' : 'webm';
        var url = URL.createObjectURL(blob);
        $('resultVideo').src = url;
        var a = $('downloadLink');
        a.href = url;
        a.download = slug(state.info.ten || state.info.loai) + '-' + state.settings.format.replace(':', 'x') + '.' + ext;
        $('resultNote').textContent = 'File ' + ext.toUpperCase() + ', ' + (blob.size / 1048576).toFixed(1) + ' MB. ' +
          (ext === 'webm' ? 'Định dạng WebM đăng được lên YouTube, Facebook và TikTok (bản web). Nếu cần MP4, hãy dùng Chrome hoặc Edge bản mới nhất.' :
            'Đăng được ngay lên TikTok, Facebook, YouTube và Zalo.');
        $('exportResult').hidden = false;
        toast('🎉 Xuất video xong! Bấm “Tải video về máy”.', 5000);
      }
    }).catch(function (e) {
      exporting = false;
      $('btnExport').disabled = false;
      prog.hidden = true;
      toast('Có lỗi khi xuất video: ' + (e && e.message ? e.message : e), 6000);
    });
  }

  /* ---------- Hướng dẫn & dữ liệu mẫu ---------- */

  function bindHelp(seen) {
    var m = $('helpModal');
    $('btnHelp').onclick = function () { m.hidden = false; };
    $('helpClose').onclick = $('helpOk').onclick = function () { m.hidden = true; save(); };
    m.addEventListener('click', function (e) { if (e.target === m) m.hidden = true; });
    if (!seen) m.hidden = false;
  }

  function loadDemo() {
    setInfo(window.BdsDemo.INFO);
    window.BdsDemo.makeImages(function (items) {
      state.media = items;
      state.lines = [];
      state.durations = [];
      state.durationsLocked = false;
      renderMedia();
      regenerate(true);
      previewTime = 2.4;
      schedulePreview();
      toast('Đã nạp dữ liệu mẫu! Bấm ▶ Xem thử, hoặc “Tiếp tục” để xem từng bước.', 4500);
    });
  }

  /* ---------- Khởi động ---------- */

  function init() {
    canvas = $('canvas');
    var seen = load();
    renderStepper();
    bindInfo();
    bindMedia();
    bindScript();
    bindVoice();
    Prompter.bind();
    bindSettings();
    bindPlayer();
    bindHelp(seen);
    $('btnDemo').onclick = loadDemo;
    $('btnPrev').onclick = function () { goStep(state.step - 1); };
    $('btnNext').onclick = function () { goStep(state.step + 1); };
    $('btnExport').onclick = doExport;
    showStep();
    schedulePreview();
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(schedulePreview);
    window.addEventListener('beforeunload', function (e) {
      if (exporting) { e.preventDefault(); e.returnValue = ''; }
    });
  }

  // Cho phép kiểm thử tự động truy cập trạng thái
  window.BdsApp = { state: state, goStep: goStep, loadDemo: loadDemo, Player: Player, project: project };

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
  else init();
})();
