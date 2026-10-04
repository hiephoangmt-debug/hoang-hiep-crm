/*
 * Widget live chat Casamia Balanca.
 * Nhúng vào website / landing page:
 *   <script src="https://TEN-MIEN-CHAT/widget.js" async></script>
 */
(function () {
  if (window.__casamiaChat) return;
  window.__casamiaChat = true;

  var script = document.currentScript || document.querySelector('script[src*="widget.js"]');
  var BASE = new URL(script.src).origin;
  // Tuỳ chọn trên thẻ script: data-contacts="off" ẩn nút Gọi/Zalo nổi (khi trang đã có sẵn),
  // data-mobile-bottom="80" đẩy nút chat lên trên thanh liên hệ cố định của trang trên điện thoại.
  var CONTACTS = script.getAttribute('data-contacts') || 'on'; // on | off | desktop
  var OPTS = { contacts: CONTACTS !== 'off', mobileBottom: parseInt(script.getAttribute('data-mobile-bottom'), 10) || 0 };

  function uuid() {
    if (window.crypto && crypto.randomUUID) return crypto.randomUUID();
    return 'v' + Date.now().toString(36) + Math.random().toString(36).slice(2) + Math.random().toString(36).slice(2);
  }
  function storage(key, val) {
    try {
      if (val === undefined) return localStorage.getItem(key);
      localStorage.setItem(key, val);
    } catch (e) { return null; }
  }
  var visitorId = storage('casamia_chat_id');
  if (!visitorId) { visitorId = uuid(); storage('casamia_chat_id', visitorId); }

  function loadScript(src, cb) {
    if (window.io) return cb();
    var s = document.createElement('script');
    s.src = src; s.onload = cb; document.head.appendChild(s);
  }

  fetch(BASE + '/api/config').then(function (r) { return r.json(); }).then(function (cfg) {
    loadScript(BASE + '/socket.io/socket.io.js', function () { init(cfg); });
  }).catch(function (e) { console.warn('[Casamia chat] Không tải được cấu hình', e); });

  function init(cfg) {
    var P = cfg.project;
    var host = document.createElement('div');
    host.id = 'casamia-chat';
    document.body.appendChild(host);
    var root = host.attachShadow({ mode: 'open' });

    root.innerHTML =
      '<style>' +
      ':host{all:initial;--c:' + P.primaryColor + ';--a:' + P.accentColor + ';font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Arial,sans-serif}' +
      '*{box-sizing:border-box}' +
      '.launcher{position:fixed;right:20px;bottom:20px;z-index:2147483000;display:flex;flex-direction:column;gap:10px;align-items:flex-end}' +
      '.fab{width:60px;height:60px;border-radius:50%;border:3px solid #fff;cursor:pointer;background:var(--c);color:#fff;box-shadow:0 6px 20px rgba(0,0,0,.25);display:flex;align-items:center;justify-content:center;position:relative}' +
      '.fab svg{width:28px;height:28px}' +
      '.fab .dot{position:absolute;top:2px;right:2px;min-width:20px;height:20px;border-radius:10px;background:var(--a);color:#fff;font-size:12px;font-weight:700;display:none;align-items:center;justify-content:center;padding:0 5px}' +
      '.fab.pulse{animation:p 2s infinite}@keyframes p{0%{box-shadow:0 0 0 0 rgba(11,42,91,.5)}70%{box-shadow:0 0 0 16px rgba(11,42,91,0)}100%{box-shadow:0 0 0 0 rgba(11,42,91,0)}}' +
      '.mini{width:48px;height:48px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;text-decoration:none;font-weight:700;font-size:13px;box-shadow:0 4px 14px rgba(0,0,0,.2)}' +
      '.mini.zalo{background:var(--c);border:2px solid #fff}.mini.call{background:var(--a)}.mini svg{width:22px;height:22px}' +
      '.panel{position:fixed;right:20px;bottom:92px;z-index:2147483001;width:370px;max-width:calc(100vw - 32px);height:560px;max-height:calc(100vh - 120px);background:#fff;border-radius:16px;box-shadow:0 12px 40px rgba(0,0,0,.25);display:none;flex-direction:column;overflow:hidden;color:#0f1d33}' +
      '.panel.open{display:flex}' +
      '.head{background:var(--c);color:#fff;padding:14px 16px;display:flex;align-items:center;gap:12px}' +
      '.avatar{width:42px;height:42px;border-radius:50%;background:var(--a);border:2px solid #fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:16px;flex:none;position:relative}' +
      '.avatar i{position:absolute;right:0;bottom:0;width:11px;height:11px;border-radius:50%;border:2px solid var(--c);background:#cbd5e1}.avatar i.on{background:var(--a)}' +
      '.head b{display:block;font-size:15px}.head small{font-size:12px;opacity:.85}' +
      '.close{margin-left:auto;background:none;border:0;color:#fff;font-size:26px;cursor:pointer;line-height:1;padding:0 4px}' +
      '.brand{background:var(--a);color:#fff;font-size:12px;text-align:center;padding:5px;letter-spacing:.5px;font-weight:600}' +
      '.body{flex:1;overflow-y:auto;padding:14px;background:#ffffff;display:flex;flex-direction:column;gap:8px}' +
      '.msg{max-width:82%;padding:9px 12px;border-radius:14px;font-size:14px;line-height:1.45;white-space:pre-wrap;word-wrap:break-word}' +
      '.msg.agent{background:#fff;align-self:flex-start;border-bottom-left-radius:4px;border:1px solid #dbe3ef;border-left:3px solid var(--a)}' +
      '.msg.visitor{background:var(--c);color:#fff;align-self:flex-end;border-bottom-right-radius:4px}' +
      '.msg time{display:block;font-size:10px;opacity:.6;margin-top:3px}' +
      '.zalo-btn{display:block;margin-top:8px;background:var(--a);color:#fff;text-align:center;text-decoration:none;font-weight:700;border-radius:8px;padding:9px 12px;font-size:14px}' +
      '.who{font-size:11px;color:var(--c);margin:10px 4px -4px;font-weight:600}.who.me{align-self:flex-end}.who.agent{align-self:flex-start}' +
      '.peek{position:relative;max-width:260px;background:#fff;color:#0f1d33;border-radius:14px 14px 4px 14px;padding:12px 30px 12px 14px;font-size:14px;line-height:1.45;box-shadow:0 8px 28px rgba(0,0,0,.18);border-left:4px solid var(--a);cursor:pointer;display:none;animation:in .3s ease-out}' +
      '.peek b{display:block;font-size:12px;color:var(--c);margin-bottom:3px}' +
      '.peek .x{position:absolute;top:4px;right:8px;border:0;background:none;font-size:18px;color:#94a3b8;cursor:pointer;line-height:1}' +
      '@keyframes in{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:none}}' +
      '.quick{display:flex;flex-wrap:wrap;gap:6px;padding:4px 0}' +
      '.quick button{border:1px solid var(--a);color:var(--a);background:#fff;border-radius:16px;padding:6px 11px;font-size:13px;cursor:pointer}' +
      '.quick button:hover{background:var(--a);color:#fff}' +
      '.lead{background:#fff;border:2px solid var(--a);border-radius:12px;padding:12px;display:flex;flex-direction:column;gap:8px;align-self:stretch}' +
      '.lead p{margin:0;font-size:13px;font-weight:700;color:var(--c)}' +
      '.lead input{border:1px solid #cbd5e1;border-radius:8px;padding:9px 10px;font-size:14px;outline:none;width:100%}' +
      '.lead input:focus{border-color:var(--c)}' +
      '.lead button{background:var(--a);color:#fff;border:0;border-radius:8px;padding:10px;font-weight:700;cursor:pointer;font-size:14px}' +
      '.lead .err{color:var(--a);font-size:12px;display:none}' +
      '.typing{font-size:12px;color:var(--a);padding:0 16px 4px;height:18px;background:#fff;font-style:italic}' +
      '.foot{display:flex;gap:8px;padding:10px;border-top:1px solid #e1e7f0;background:#fff}' +
      '.foot textarea{flex:1;resize:none;border:1px solid #cbd5e1;border-radius:20px;padding:10px 14px;font:inherit;font-size:14px;height:42px;max-height:100px;outline:none}' +
      '.foot textarea:focus{border-color:var(--c)}' +
      '.foot button{width:42px;height:42px;border-radius:50%;border:0;background:var(--a);color:#fff;cursor:pointer;flex:none;display:flex;align-items:center;justify-content:center}' +
      '.foot button svg{width:20px;height:20px}' +
      (CONTACTS === 'desktop' ? '@media(max-width:960px){.mini{display:none!important}}' : '') +
      (OPTS.mobileBottom ? '@media(max-width:960px){.launcher{bottom:' + OPTS.mobileBottom + 'px}.panel{bottom:' + (OPTS.mobileBottom + 72) + 'px}}' : '') +
      '@media(max-width:480px){.panel{right:0;bottom:0;width:100vw;max-width:100vw;height:100%;max-height:100%;border-radius:0}}' +
      '</style>' +
      '<div class="panel" part="panel">' +
      '  <div class="head"><div class="avatar">' + initials(P.agentName) + '<i></i></div>' +
      '    <div><b></b><small class="status"></small></div><button class="close" aria-label="Đóng">×</button></div>' +
      '  <div class="brand"></div>' +
      '  <div class="body"></div>' +
      '  <div class="typing"></div>' +
      '  <form class="foot"><textarea placeholder="Nhập tin nhắn..." rows="1"></textarea>' +
      '    <button type="submit" aria-label="Gửi"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M2 21l21-9L2 3v7l15 2-15 2z"/></svg></button></form>' +
      '</div>' +
      '<div class="launcher"><div class="peek"><button class="x" aria-label="Ẩn">×</button><b></b><span></span></div>' +
      (P.zalo && OPTS.contacts ? '<a class="mini zalo" target="_blank" rel="noopener" title="Chat Zalo">Zalo</a>' : '') +
      (P.hotline && OPTS.contacts ? '<a class="mini call" title="Gọi hotline"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M6.6 10.8a15.1 15.1 0 006.6 6.6l2.2-2.2a1 1 0 011-.25 11.4 11.4 0 003.6.57 1 1 0 011 1V20a1 1 0 01-1 1A17 17 0 013 4a1 1 0 011-1h3.5a1 1 0 011 1c0 1.25.2 2.45.57 3.57a1 1 0 01-.25 1z"/></svg></a>' : '') +
      '  <button class="fab pulse" aria-label="Mở chat tư vấn"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 3C6.5 3 2 6.6 2 11c0 2.4 1.3 4.6 3.4 6.1L4.5 21l4.2-2.2c1 .3 2.1.4 3.3.4 5.5 0 10-3.6 10-8S17.5 3 12 3z"/></svg><span class="dot"></span></button>' +
      '</div>';

    var $ = function (s) { return root.querySelector(s); };
    var panel = $('.panel'), body = $('.body'), input = $('textarea'), fab = $('.fab'), dot = $('.dot');
    var statusEl = $('.status'), onlineDot = $('.avatar i'), typingEl = $('.typing');
    $('.head b').textContent = P.agentName;
    $('.brand').textContent = 'DỰ ÁN ' + P.name.toUpperCase();
    if ($('.zalo')) $('.zalo').href = 'https://zalo.me/' + P.zalo.replace(/\D/g, '');
    if ($('.call')) $('.call').href = 'tel:' + P.hotline.replace(/[^\d+]/g, '');

    var unread = 0, leadShown = false, hasLead = false, rendered = {}, quickEl = null, typingTimer, lastFrom = null;
    var peek = $('.peek');
    peek.querySelector('b').textContent = P.agentName + ' – Tư vấn viên';
    peek.onclick = function () { toggle(true); };
    peek.querySelector('.x').onclick = function (e) { e.stopPropagation(); peek.style.display = 'none'; };

    function initials(n) { return n.split(/\s+/).map(function (w) { return w[0]; }).slice(-2).join('').toUpperCase(); }
    function fmt(t) { var d = new Date(t); return ('0' + d.getHours()).slice(-2) + ':' + ('0' + d.getMinutes()).slice(-2); }
    function scroll() { body.scrollTop = body.scrollHeight; }

    function setOnline(on) {
      onlineDot.className = on ? 'on' : '';
      statusEl.textContent = on ? 'Đang trực tuyến • trả lời ngay' : P.agentTitle + ' • phản hồi trong ít phút';
    }

    function addMsg(m) {
      if (m.from === 'system') return;
      if (m.id && rendered[m.id]) return;
      if (m.id) rendered[m.id] = true;
      // Tách lượt: đổi người nói thì hiện tên, cách 1 dòng.
      var from = m.from === 'visitor' ? 'me' : 'agent';
      if (from !== lastFrom) {
        var w = document.createElement('div');
        w.className = 'who ' + from;
        w.textContent = from === 'me' ? 'Bạn' : '💼 ' + P.agentName + ' – Tư vấn';
        body.appendChild(w);
        lastFrom = from;
      }
      var el = document.createElement('div');
      el.className = 'msg ' + (m.from === 'visitor' ? 'visitor' : 'agent');
      el.textContent = m.text;
      if (m.action === 'zalo' && P.zalo) {
        var z = document.createElement('a');
        z.className = 'zalo-btn'; z.target = '_blank'; z.rel = 'noopener';
        z.href = 'https://zalo.me/' + P.zalo.replace(/\D/g, '');
        z.textContent = 'Chat Zalo ' + P.zalo;
        el.appendChild(z);
      }
      var t = document.createElement('time'); t.textContent = fmt(m.at || Date.now());
      el.appendChild(t);
      body.appendChild(el);
      if (quickEl) body.appendChild(quickEl);
      scroll();
      if (m.from !== 'visitor' && !panel.classList.contains('open')) {
        unread++; dot.textContent = unread; dot.style.display = 'flex';
        if (m.id) { // tin mới (không phải lịch sử) → bong bóng xem trước
          peek.querySelector('span').textContent = m.text.length > 140 ? m.text.slice(0, 140) + '…' : m.text;
          peek.style.display = 'block';
        }
      }
    }

    function showQuick() {
      quickEl = document.createElement('div');
      quickEl.className = 'quick';
      cfg.quickReplies.forEach(function (label) {
        var b = document.createElement('button');
        b.type = 'button'; b.textContent = label;
        b.onclick = function () { send(label); };
        quickEl.appendChild(b);
      });
      body.appendChild(quickEl);
    }

    function showLeadForm() {
      if (leadShown || hasLead) return;
      leadShown = true;
      var f = document.createElement('form');
      f.className = 'lead';
      f.innerHTML = '<p>Để lại thông tin để nhận tư vấn & bảng giá</p>' +
        '<input name="name" placeholder="Họ và tên" maxlength="100">' +
        '<input name="phone" type="tel" placeholder="Số điện thoại *" required maxlength="20">' +
        '<span class="err"></span><button type="submit">Nhận tư vấn ngay</button>';
      f.onsubmit = function (e) {
        e.preventDefault();
        socket.emit('lead', { name: f.name.value, phone: f.phone.value });
      };
      body.appendChild(f);
      scroll();
    }

    var socket = io(BASE, {
      auth: { visitorId: visitorId, page: location.href, referrer: document.referrer },
      transports: ['websocket', 'polling'],
    });

    socket.on('history', function (h) {
      body.innerHTML = ''; rendered = {}; quickEl = null; lastFrom = null;
      hasLead = !!(h.lead && h.lead.phone);
      setOnline(h.agentsOnline);
      addMsg({ from: 'agent', text: cfg.welcome, at: h.messages[0] ? h.messages[0].at : Date.now() });
      if (!h.messages.length) showQuick();
      h.messages.forEach(function (m) { addMsg({ from: m.from, text: m.text, at: m.at, action: m.action }); rendered[m.id] = true; });
      unread = 0; dot.style.display = 'none'; peek.style.display = 'none';
    });
    socket.on('message', function (m) { typingEl.textContent = ''; addMsg(m); });
    socket.on('agents:online', setOnline);
    socket.on('lead:request', showLeadForm);
    socket.on('lead:saved', function (lead) {
      if (!lead.phone) return;
      hasLead = true;
      var f = body.querySelector('.lead'); if (f) f.remove();
    });
    socket.on('lead:error', function (msg) {
      var e = body.querySelector('.lead .err'); if (e) { e.textContent = msg; e.style.display = 'block'; }
    });
    socket.on('typing', function () {
      typingEl.textContent = P.agentName + ' đang soạn tin...';
      clearTimeout(typingTimer);
      typingTimer = setTimeout(function () { typingEl.textContent = ''; }, 3000);
    });

    function send(text) {
      text = (text || '').trim();
      if (!text) return;
      if (quickEl) { quickEl.remove(); quickEl = null; }
      socket.emit('message', { text: text });
    }

    $('form.foot').onsubmit = function (e) { e.preventDefault(); send(input.value); input.value = ''; };
    input.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); send(input.value); input.value = ''; }
    });
    var lastTyping = 0;
    input.addEventListener('input', function () {
      if (Date.now() - lastTyping > 2000) { lastTyping = Date.now(); socket.emit('typing'); }
    });

    function toggle(open) {
      panel.classList.toggle('open', open);
      fab.classList.remove('pulse');
      if (open) { unread = 0; dot.style.display = 'none'; peek.style.display = 'none'; setTimeout(function () { input.focus(); scroll(); }, 50); }
    }
    fab.onclick = function () { toggle(!panel.classList.contains('open')); };
    $('.close').onclick = function () { toggle(false); };

    // Theo dõi khách đọc trang: dừng lâu ở mục nào thì báo server để chủ động hỏi.
    // Có thể gắn chủ đề cho một khối bằng thuộc tính data-chat-topic="bảng giá".
    if (cfg.proactive && cfg.proactive.topics.length) {
      var PA = cfg.proactive, sentTopics = {}, sentCount = 0, curKey = null, dwell = 0, lastY = window.scrollY;
      var norm = function (s) { return (s || '').toLowerCase().replace(/\s+/g, ' '); };
      var hasKw = function (text, kw) {
        var i = text.indexOf(kw);
        while (i !== -1) {
          var b = text.charAt(i - 1), a = text.charAt(i + kw.length);
          if (!/\p{L}/u.test(b) && !/\p{L}/u.test(a)) return true;
          i = text.indexOf(kw, i + 1);
        }
        return false;
      };
      var topicOf = function (text) {
        var best = null, bestHits = 0;
        PA.topics.forEach(function (t) {
          var hits = t.keywords.filter(function (k) { return hasKw(text, norm(k)); }).length;
          if (hits > bestHits) { best = t.i; bestHits = hits; }
        });
        return best;
      };
      // Khối nội dung đang ở giữa màn hình (hỗ trợ section thường và LadiPage).
      var currentBlock = function () {
        var el = document.elementFromPoint(window.innerWidth / 2, window.innerHeight * 0.45);
        if (!el || el === host) return null;
        var block = el.closest('[data-chat-topic], .ladi-section, section, article');
        if (block && block.getAttribute('data-chat-topic') === 'off') return null;
        if (block && block !== document.body) {
          var heads = Array.prototype.map.call(block.querySelectorAll('h1,h2,h3,h4'), function (h) { return h.textContent; }).join(' ');
          return { el: block, text: norm((block.getAttribute('data-chat-topic') || '') + ' ' + heads + ' ' + (block.innerText || '').slice(0, 400)) };
        }
        var hs = document.querySelectorAll('h1,h2,h3'), cur = null;
        for (var i = 0; i < hs.length; i++) if (hs[i].getBoundingClientRect().top < window.innerHeight * 0.5) cur = hs[i];
        if (!cur) return null;
        var next = cur.nextElementSibling;
        return { el: cur, text: norm(cur.textContent + ' ' + (next ? (next.innerText || '').slice(0, 300) : '')) };
      };
      var timer = setInterval(function () {
        if (sentCount >= PA.maxPerVisit) return clearInterval(timer);
        var ae = document.activeElement;
        var typing = ae && ae !== host && /^(INPUT|SELECT|TEXTAREA)$/.test(ae.tagName);
        if (document.hidden || panel.classList.contains('open') || typing) { dwell = 0; return; }
        var y = window.scrollY, fast = Math.abs(y - lastY) > window.innerHeight * 0.35;
        lastY = y;
        var b = currentBlock();
        var topic = b ? topicOf(b.text) : null;
        if (topic === null || fast || (curKey && curKey.el !== b.el)) { dwell = 0; curKey = topic === null ? null : { el: b.el }; return; }
        curKey = { el: b.el };
        if (++dwell >= PA.dwellSeconds && !sentTopics[topic]) {
          sentTopics[topic] = true; sentCount++; dwell = 0;
          socket.emit('browse', { topic: topic, seconds: PA.dwellSeconds });
        }
      }, 1000);
    }

    // API cho website: window.CasamiaChat.open()
    window.CasamiaChat = { open: function () { toggle(true); }, close: function () { toggle(false); } };
  }
})();
