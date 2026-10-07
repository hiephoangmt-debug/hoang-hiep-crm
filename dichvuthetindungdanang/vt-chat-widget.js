(function () {
  if (window.__vtChat) return; window.__vtChat = 1;
  var CRM_URL = 'https://script.google.com/macros/s/AKfycbzJxDXzFGBt0fZi-18p5ZIYFtMJtRSSidJWFyIL0AHC1RezxptJ2ZbAxfgFb_DColkX/exec';
  var PHONE = '0909669325', PHONE_TEXT = '0909 669 325', ZALO = 'https://zalo.me/' + PHONE;
  var FEES = 'Rút tiền: Visa 1,8% · JCB/Mastercard 1,9% · thẻ Sacombank, VPBank 1,9%.<br>Đáo hạn: Visa 1,9% · JCB/Mastercard 2,0% · thẻ Sacombank, VPBank 2,1%.';

  function send(obj) {
    obj.source = location.hostname; obj.page = location.pathname;
    var body = JSON.stringify(obj);
    try {
      var blob = new Blob([body], { type: 'text/plain;charset=utf-8' });
      if (!(navigator.sendBeacon && navigator.sendBeacon(CRM_URL, blob))) {
        fetch(CRM_URL, { method: 'POST', mode: 'no-cors', keepalive: true, headers: { 'Content-Type': 'text/plain;charset=utf-8' }, body: body });
      }
    } catch (e) {}
  }

  /* 1. Báo về CRM khi bấm bất kỳ nút Gọi / Zalo nào trên trang */
  var lastPing = {};
  document.addEventListener('click', function (e) {
    var a = e.target.closest && e.target.closest('a[href^="tel:"], a[href*="zalo.me"], [data-replace-href^="tel:"], [data-replace-href*="zalo.me"]');
    if (!a) return;
    var href = (a.getAttribute('href') || a.getAttribute('data-replace-href') || '').toLowerCase();
    var loai = href.indexOf('tel:') === 0 ? 'goi' : 'zalo', now = Date.now();
    if (lastPing[loai] && now - lastPing[loai] < 60000) return;
    lastPing[loai] = now;
    var text = (a.innerText || a.getAttribute('aria-label') || '').replace(/\s+/g, ' ').trim().slice(0, 40);
    send({ loai: loai, service: 'Nút ' + (loai === 'goi' ? 'Gọi' : 'Zalo') + (text ? ' – ' + text : '') });
  }, true);

  /* 2. Giao diện */
  var css = '#vtw{position:fixed;right:14px;bottom:calc(18px + env(safe-area-inset-bottom,0px));z-index:2147483000;font:15px/1.45 system-ui,-apple-system,"Segoe UI",Roboto,sans-serif;color:#0f1b33}'
  + '#vtw *{box-sizing:border-box}'
  + '#vtw .vt-acts{display:flex;flex-direction:column;gap:12px;align-items:flex-end}'
  + '#vtw .vt-act{position:relative;display:flex;align-items:center;justify-content:center;width:56px;height:56px;border-radius:50%;border:0;cursor:pointer;text-decoration:none;color:#fff;box-shadow:0 6px 18px rgba(0,0,0,.25);animation:vtin .5s ease-out both}'
  + '#vtw .vt-act:nth-child(1){animation-delay:.1s}#vtw .vt-act:nth-child(2){animation-delay:.25s}#vtw .vt-act:nth-child(3){animation-delay:.4s}'
  + '#vtw .vt-act:before{content:"";position:absolute;inset:0;border-radius:50%;border:3px solid currentColor;opacity:.6;animation:vtring 1.8s infinite}'
  + '#vtw .vt-zalo{background:#0068ff;color:#0068ff}#vtw .vt-call{background:#1bb35a;color:#1bb35a}#vtw .vt-chatb{background:#ff7a00;color:#ff7a00}'
  + '#vtw .vt-act svg{width:28px;height:28px;fill:#fff}'
  + '#vtw .vt-lb{position:absolute;right:66px;white-space:nowrap;background:#0b1f44;color:#fff;font-size:13px;font-weight:700;padding:6px 10px;border-radius:10px;box-shadow:0 4px 12px rgba(0,0,0,.2);pointer-events:none;opacity:0;transform:translateX(8px);transition:.2s}'
  + '#vtw .vt-act:hover .vt-lb,#vtw .vt-act:focus-visible .vt-lb{opacity:1;transform:none}'
  + '@keyframes vtin{from{transform:translateX(90px);opacity:0}to{transform:none;opacity:1}}'
  + '@keyframes vtring{0%{transform:scale(1);opacity:.7}100%{transform:scale(1.55);opacity:0}}'
  + '@media (prefers-reduced-motion:reduce){#vtw .vt-act,#vtw .vt-act:before{animation:none}}'
  + '#vtw .vt-tip{position:absolute;right:66px;bottom:8px;background:#fff;border-radius:14px;padding:10px 14px;box-shadow:0 8px 24px rgba(0,0,0,.18);white-space:nowrap;font-weight:600;cursor:pointer;animation:vtin .4s ease-out both}'
  + '#vtw .vt-box{position:fixed;right:84px;bottom:calc(18px + env(safe-area-inset-bottom,0px));width:min(360px,calc(100vw - 32px));max-height:min(560px,calc(100vh - 60px));background:#fff;border-radius:18px;box-shadow:0 18px 50px rgba(0,0,0,.3);display:flex;flex-direction:column;overflow:hidden}'
  + '#vtw .vt-head{background:#0b1f44;color:#fff;padding:12px 14px;display:flex;gap:10px;align-items:center}'
  + '#vtw .vt-av{width:38px;height:38px;border-radius:50%;background:#ff7a00;display:grid;place-items:center;font-weight:800}'
  + '#vtw .vt-head b{display:block}#vtw .vt-head small{opacity:.8}#vtw .vt-x{margin-left:auto;background:none;border:0;color:#fff;font-size:22px;cursor:pointer}'
  + '#vtw .vt-log{flex:1;overflow-y:auto;padding:12px;background:#eef2f9;display:flex;flex-direction:column;gap:8px}'
  + '#vtw .vt-m{max-width:85%;padding:9px 12px;border-radius:14px;background:#fff;align-self:flex-start;border-bottom-left-radius:4px}'
  + '#vtw .vt-m.me{background:#d5e6ff;align-self:flex-end;border-bottom-left-radius:14px;border-bottom-right-radius:4px}'
  + '#vtw .vt-q{display:flex;flex-wrap:wrap;gap:6px}'
  + '#vtw .vt-q button{border:1px solid #ff7a00;background:#fff;color:#c25400;border-radius:16px;padding:6px 11px;font:inherit;font-size:14px;cursor:pointer}'
  + '#vtw .vt-in{display:flex;gap:6px;padding:10px;border-top:1px solid #e3e8f2;background:#fff}'
  + '#vtw .vt-in input{flex:1;min-width:0;border:1px solid #d5dceb;border-radius:10px;padding:10px;font:inherit}'
  + '#vtw .vt-in button{border:0;background:#ff7a00;color:#fff;border-radius:10px;padding:0 14px;font-weight:700;cursor:pointer}'
  + '#vtw [hidden]{display:none!important}'
  + '@media(max-width:700px){#vtw{right:10px;bottom:calc(74px + env(safe-area-inset-bottom,0px))}#vtw .vt-act{width:50px;height:50px}#vtw .vt-lb{display:none}'
  + '#vtw .vt-box{right:16px;left:16px;width:auto;bottom:calc(74px + env(safe-area-inset-bottom,0px));max-height:calc(100vh - 110px)}#vtw.open .vt-acts{display:none}}';
  var st = document.createElement('style'); st.textContent = css;

  var ICON_ZALO = '<svg viewBox="0 0 48 48"><path d="M24 4C12.4 4 3 12.2 3 22.3c0 5.8 3.1 11 8 14.3l-1.5 6.9 7.4-3.9c2.2.6 4.6 1 7.1 1 11.6 0 21-8.2 21-18.3S35.6 4 24 4z"/><text x="24" y="27" text-anchor="middle" font-family="Arial" font-weight="900" font-size="11" fill="#0068ff">Zalo</text></svg>';
  var ICON_CALL = '<svg viewBox="0 0 24 24"><path d="M6.6 10.8a15.1 15.1 0 006.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1A17 17 0 013 4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1z"/></svg>';
  var ICON_CHAT = '<svg viewBox="0 0 24 24"><path d="M12 3C6.5 3 2 6.8 2 11.5c0 2.4 1.2 4.6 3.1 6.1L4.5 21l3.6-1.9c1.2.4 2.5.6 3.9.6 5.5 0 10-3.8 10-8.5S17.5 3 12 3zM7.5 12.8a1.3 1.3 0 110-2.6 1.3 1.3 0 010 2.6zm4.5 0a1.3 1.3 0 110-2.6 1.3 1.3 0 010 2.6zm4.5 0a1.3 1.3 0 110-2.6 1.3 1.3 0 010 2.6z"/></svg>';

  var w = document.createElement('div'); w.id = 'vtw';
  w.innerHTML =
    '<div class="vt-acts">'
    + '<a class="vt-act vt-zalo" href="' + ZALO + '" target="_blank" rel="noopener" aria-label="Chat Zalo ' + PHONE_TEXT + '">' + ICON_ZALO + '<span class="vt-lb">Zalo ' + PHONE_TEXT + '</span></a>'
    + '<a class="vt-act vt-call" href="tel:' + PHONE + '" aria-label="Gọi ' + PHONE_TEXT + '">' + ICON_CALL + '<span class="vt-lb">Gọi ' + PHONE_TEXT + '</span></a>'
    + '<button type="button" class="vt-act vt-chatb" aria-label="Chat tư vấn">' + ICON_CHAT + '<span class="vt-lb">Chat tư vấn – báo phí</span></button>'
    + '</div>'
    + '<div class="vt-tip" hidden>Cần báo phí? Chat ngay 👋</div>'
    + '<div class="vt-box" hidden role="dialog" aria-label="Chat tư vấn Vân Trần">'
    + '<div class="vt-head"><div class="vt-av">VT</div><div><b>Thẻ Tín Dụng Vân Trần</b><small>Thường trả lời trong 5 phút</small></div><button type="button" class="vt-x" aria-label="Đóng">×</button></div>'
    + '<div class="vt-log" aria-live="polite"></div>'
    + '<form class="vt-in" hidden><input type="text" autocomplete="off"><button type="submit">Gửi</button></form>'
    + '</div>';
  /* Gắn vào trang; tự gắn lại nếu trang (LadiPage) vẽ lại body */
  function mount() {
    if (!document.body) return;
    if (!st.isConnected) (document.head || document.documentElement).appendChild(st);
    document.querySelectorAll('#vtw').forEach(function (x) { if (x !== w) x.remove(); }); // bản sao chết
    if (!w.isConnected) document.body.appendChild(w);
  }
  mount();
  document.addEventListener('DOMContentLoaded', mount);
  window.addEventListener('load', function () { mount(); hideOldFloats(); });
  setInterval(mount, 1500);

  /* Ẩn nút Gọi/Zalo nổi cũ của trang (nút nhỏ cố định) để không trùng; giữ thanh liên hệ ngang ở đáy */
  function hideOldFloats() {
    if (!w.isConnected || !w.offsetHeight) return; // chỉ ẩn nút cũ khi nút mới đã hiện
    document.querySelectorAll('a[href^="tel:"], a[href*="zalo.me"], [data-replace-href^="tel:"], [data-replace-href*="zalo.me"]').forEach(function (a) {
      if (w.contains(a)) return;
      for (var el = a; el && el !== document.body; el = el.parentElement) {
        var cs = getComputedStyle(el);
        if (cs.position === 'fixed') {
          var r = el.getBoundingClientRect();
          if (r.width < window.innerWidth * 0.4 && r.left > window.innerWidth * 0.5) el.style.setProperty('display', 'none', 'important');
          break;
        }
      }
    });
  }
  hideOldFloats(); setTimeout(hideOldFloats, 1500); window.addEventListener('resize', hideOldFloats);

  var tip = w.querySelector('.vt-tip'), box = w.querySelector('.vt-box'),
      log = w.querySelector('.vt-log'), form = w.querySelector('.vt-in'), input = form.querySelector('input');

  function closeChat() { box.hidden = true; w.classList.remove('open'); }
  w.querySelector('.vt-chatb').addEventListener('click', function () { box.hidden ? openChat() : closeChat(); });
  w.querySelector('.vt-x').addEventListener('click', closeChat);
  setTimeout(function () { try { if (sessionStorage.getItem('vt-tip')) return; sessionStorage.setItem('vt-tip', 1); } catch (e) {} if (box.hidden) { tip.hidden = false; setTimeout(function () { tip.hidden = true; }, 9000); } }, 8000);
  tip.addEventListener('click', openChat);

  /* 3. Chat tự động */
  var lead = {}, step = '', started = false;
  function say(html, me) { var m = document.createElement('div'); m.className = 'vt-m' + (me ? ' me' : ''); if (me) m.textContent = html; else m.innerHTML = html; log.appendChild(m); log.scrollTop = log.scrollHeight; }
  function bot(html, delay) { setTimeout(function () { say(html); }, delay || 350); }
  function choices(list, cb) {
    setTimeout(function () {
      var q = document.createElement('div'); q.className = 'vt-q';
      list.forEach(function (t) { var b = document.createElement('button'); b.type = 'button'; b.textContent = t; b.onclick = function () { q.remove(); say(t, true); cb(t); }; q.appendChild(b); });
      log.appendChild(q); log.scrollTop = log.scrollHeight;
    }, 450);
  }
  function ask(placeholder, type, nextStep) { step = nextStep; setTimeout(function () { form.hidden = false; input.type = type; input.value = ''; input.placeholder = placeholder; input.focus(); }, 450); }

  function openChat() {
    tip.hidden = true; box.hidden = false; w.classList.add('open');
    if (started) return; started = true;
    bot('Chào anh/chị 👋 Em là <b>Vân Trần</b> – dịch vụ thẻ tín dụng Đà Nẵng. Anh/chị cần hỗ trợ gì ạ?', 100);
    choices(['Rút tiền thẻ tín dụng', 'Đáo hạn thẻ tín dụng', 'Rút ví trả sau', 'Xem bảng phí'], pickService);
  }
  function pickService(t) {
    if (t === 'Xem bảng phí') {
      bot(FEES + '<br><small>Báo phí chính xác trước khi làm, không phát sinh.</small>');
      bot('Anh/chị muốn làm dịch vụ nào ạ?', 900);
      choices(['Rút tiền thẻ tín dụng', 'Đáo hạn thẻ tín dụng', 'Rút ví trả sau'], pickService);
      return;
    }
    lead.service = t;
    bot(t === 'Rút ví trả sau' ? 'Anh/chị dùng ví nào ạ?' : 'Thẻ của anh/chị thuộc ngân hàng nào ạ?');
    choices(t === 'Rút ví trả sau' ? ['MoMo Ví Trả Sau', 'SPayLater', 'Kredivo', 'Home PayLater', 'Khác']
      : ['Vietcombank', 'Techcombank', 'VPBank', 'Sacombank', 'BIDV', 'MB', 'VIB', 'Ngân hàng khác'], function (b) {
      lead.bank = b;
      bot('Dạ, anh/chị cần khoảng bao nhiêu tiền ạ?');
      choices(['Dưới 10 triệu', '10 – 50 triệu', '50 – 100 triệu', 'Trên 100 triệu'], function (a) {
        lead.amount = a;
        bot('Anh/chị cho em xin <b>số điện thoại / Zalo</b> để em báo phí ngay ạ.');
        ask('09xx xxx xxx', 'tel', 'phone');
      });
    });
  }
  form.addEventListener('submit', function (e) {
    e.preventDefault();
    var v = input.value.trim(); if (!v) return;
    if (step === 'phone') {
      var p = v.replace(/[\s.\-]/g, '');
      if (!/^(0|\+84)\d{9,10}$/.test(p)) { say(v, true); bot('Số chưa đúng, anh/chị nhập lại giúp em 10 số nhé.'); input.value = ''; return; }
      say(v, true); lead.phone = p; form.hidden = true;
      bot('Cho em xin tên anh/chị ạ?'); ask('Tên của anh/chị', 'text', 'name'); return;
    }
    if (step === 'name') {
      say(v, true); lead.name = v; form.hidden = true; step = '';
      send({ name: lead.name, phone: lead.phone, service: 'Chat web – ' + lead.service + ' – ' + lead.bank + ' – ' + lead.amount });
      bot('Em đã nhận thông tin ✅ Em sẽ gọi hoặc nhắn Zalo cho anh/chị trong ít phút.');
      bot('Cần gấp anh/chị bấm ngay:<br><a href="tel:' + PHONE + '" style="color:#1b7f3b;font-weight:700">📞 Gọi ' + PHONE_TEXT + '</a> · <a href="' + ZALO + '" target="_blank" rel="noopener" style="color:#0068ff;font-weight:700">Zalo</a>', 900);
    }
  });
})();
