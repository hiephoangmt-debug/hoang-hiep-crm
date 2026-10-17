/* Sun Saphia – 2 công cụ tương tác: Trắc nghiệm "Căn nào hợp với anh/chị?" + Máy tính dòng tiền minh họa.
   Chèn vào trang LadiPage qua mã "Trước </body>". Gửi khách về CRM/Telegram qua window.crmLead. */
(function () {
  if (window.__ssx) return; window.__ssx = 1;
  var ZALO = 'https://zalo.me/0904567009';

  var CSS = ''
    + '#ssx{background:#fff;padding:46px 0 40px;font-family:"Be Vietnam Pro",Arial,sans-serif;color:#17283a;clear:both;position:relative}'
    + '#ssx *{box-sizing:border-box}'
    + '#ssx .sx-w{max-width:1120px;margin:0 auto;padding:0 16px}'
    + '#ssx .sx-k{color:#FF5A1F;font-size:12.5px;font-weight:800;letter-spacing:.16em;text-transform:uppercase;text-align:center}'
    + '#ssx h2:after{display:none!important}#ssx h2{padding:0!important;font-size:30px;line-height:1.2;color:#0A2540;text-align:center;margin:8px 0 6px;font-weight:800}'
    + '#ssx .sx-lead{text-align:center;color:#5d6b7a;font-size:16px;margin:0 auto 24px;max-width:720px}'
    + '#ssx .sx-g{display:grid;grid-template-columns:1fr 1fr;gap:18px;align-items:start}'
    + '#ssx .sx-c{background:linear-gradient(160deg,#0A2540,#12355c);color:#dce6f0;border-radius:22px;padding:24px;box-shadow:0 18px 40px rgba(10,37,64,.18);position:relative;overflow:hidden}'
    + '#ssx .sx-c:before{content:"";position:absolute;inset:0;pointer-events:none;background:url("data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 width=%27240%27 height=%2748%27%3E%3Cpath d=%27M0 12 Q30 2 60 12 T120 12 T180 12 T240 12 M0 36 Q30 26 60 36 T120 36 T180 36 T240 36%27 fill=%27none%27 stroke=%27%23ffffff%27 stroke-opacity=%27.07%27 stroke-width=%271.5%27/%3E%3C/svg%3E") 0 0/240px 48px;animation:sxvan 18s linear infinite}'
    + '@keyframes sxvan{to{background-position:240px 48px}}'
    + '#ssx .sx-c>*{position:relative}'
    + '#ssx .sx-c h3{color:#fff;font-size:21px;margin:0 0 4px;font-weight:800}'
    + '#ssx .sx-c .sx-sub{font-size:14px;color:#a9bccf;margin:0 0 16px}'
    + '#ssx .sx-step{font-size:12.5px;color:#FFB067;font-weight:700;letter-spacing:.08em;text-transform:uppercase}'
    + '#ssx .sx-bar{height:6px;border-radius:3px;background:rgba(255,255,255,.12);margin:8px 0 14px;overflow:hidden}'
    + '#ssx .sx-bar i{display:block;height:100%;background:linear-gradient(90deg,#FF5A1F,#FF8A00);transition:width .35s}'
    + '#ssx .sx-q{font-size:18px;font-weight:700;color:#fff;margin:0 0 12px}'
    + '#ssx .sx-opts{display:grid;gap:10px}'
    + '#ssx .sx-o{display:flex;align-items:center;gap:12px;width:100%;text-align:left;font:600 15.5px "Be Vietnam Pro",Arial,sans-serif;color:#fff;background:rgba(255,255,255,.08);border:1.5px solid rgba(255,255,255,.18);border-radius:14px;padding:13px 15px;cursor:pointer;transition:.25s}'
    + '#ssx .sx-o:hover{border-color:#FF8A00;background:rgba(255,138,0,.14);transform:translateX(4px)}'
    + '#ssx .sx-o i{font-style:normal;font-size:20px}'
    + '#ssx .sx-back{background:none;border:0;color:#a9bccf;font:600 13px "Be Vietnam Pro",Arial;cursor:pointer;margin-top:10px;padding:0}'
    + '#ssx .sx-res{background:#fff;color:#17283a;border-radius:16px;padding:16px 18px;margin-bottom:12px}'
    + '#ssx .sx-res b{color:#0A2540}#ssx .sx-res .sx-big{display:block;font-size:19px;color:#FF5A1F;font-weight:800;margin:4px 0 6px}'
    + '#ssx .sx-sm{font-size:12.5px;color:#7a8794;display:block;margin-top:6px;line-height:1.5}'
    + '#ssx .sx-btn{position:relative;overflow:hidden;display:block;width:100%;border:0;cursor:pointer;font:800 16px "Be Vietnam Pro",Arial,sans-serif;color:#fff;text-align:center;text-decoration:none;padding:15px 16px;border-radius:14px;background:linear-gradient(90deg,#FF5A1F,#FF8A00);box-shadow:0 12px 26px rgba(255,90,31,.35);transition:.3s}'
    + '#ssx .sx-btn:hover{transform:translateY(-2px)}'
    + '#ssx .sx-btn:after{content:"";position:absolute;top:0;left:0;width:45%;height:100%;background:linear-gradient(100deg,rgba(255,255,255,0),rgba(255,255,255,.6),rgba(255,255,255,0));transform:translateX(-160%) skewX(-20deg);animation:sxquet 3s ease-in-out infinite}'
    + '@keyframes sxquet{0%{transform:translateX(-160%) skewX(-20deg)}55%,100%{transform:translateX(330%) skewX(-20deg)}}'
    + '#ssx .sx-zl{display:block;text-align:center;color:#9fd0ff;font-size:13.5px;margin-top:9px;text-decoration:none;font-weight:600}'
    + '#ssx .sx-f{display:none;background:#fff;border-radius:16px;padding:16px;margin-top:12px;color:#17283a}'
    + '#ssx .sx-f.on{display:block;animation:sxup .35s both}@keyframes sxup{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:none}}'
    + '#ssx .sx-f label{display:block;font-size:12.5px;font-weight:700;color:#0A2540;margin:8px 0 5px}'
    + '#ssx .sx-f input,#ssx .sx-f textarea{width:100%;padding:12px 13px;font:15.5px "Be Vietnam Pro",Arial,sans-serif;border:1.5px solid #d6dce5;border-radius:11px;background:#f8fafc;color:#17283a}'
    + '#ssx .sx-f textarea{height:74px;resize:vertical;font-size:13.5px;color:#41505f}'
    + '#ssx .sx-f .sx-btn{margin-top:12px}'
    + '#ssx .sx-ok{display:none;margin-top:10px;background:#e9f9ef;color:#17663a;border-radius:10px;padding:10px 12px;font-size:14px;font-weight:600}'
    + '#ssx .sx-sl{margin-bottom:14px}'
    + '#ssx .sx-sl .sx-row{display:flex;justify-content:space-between;align-items:baseline;gap:10px;margin-bottom:6px}'
    + '#ssx .sx-sl span{font-size:14px;color:#c9d6e3}#ssx .sx-sl output{font-weight:800;color:#fff;font-size:17px;white-space:nowrap}'
    + '#ssx input[type=range]{width:100%;accent-color:#FF6A2B;height:28px}'
    + '#ssx .sx-out{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin:6px 0 12px}'
    + '#ssx .sx-out div{background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.16);border-radius:14px;padding:11px 13px;font-size:12.5px;color:#a9bccf;line-height:1.35}'
    + '#ssx .sx-out b{display:block;font-size:19px;color:#fff;font-weight:800}'
    + '#ssx .sx-out .sx-hl{grid-column:span 2;background:#fff;border:0;color:#5d6b7a}'
    + '#ssx .sx-out .sx-hl b{font-size:28px;background:linear-gradient(110deg,#FF5A1F 40%,#FFC08A 50%,#FF5A1F 60%);background-size:200% 100%;-webkit-background-clip:text;background-clip:text;color:transparent;animation:sxkim 2.6s linear infinite}'
    + '@keyframes sxkim{from{background-position:150% 0}to{background-position:-50% 0}}'
    + '#ssx .sx-note{font-size:12px;color:#a9bccf;margin:0 0 12px;line-height:1.5}'
    + '@media(max-width:900px){#ssx .sx-g{grid-template-columns:1fr}#ssx h2{font-size:24px}#ssx .sx-c{padding:20px 16px}}';

  function esc(s) { return String(s).replace(/[&<>"]/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]; }); }
  function phoneOk(p) { p = String(p || '').replace(/[^\d+]/g, '').replace(/^\+?84/, '0'); return /^0\d{9}$/.test(p) ? p : ''; }
  function vnd(m) { // m: triệu đồng
    if (m >= 1000) return (Math.round(m / 100) / 10).toString().replace('.', ',') + ' tỷ';
    return Math.round(m).toLocaleString('vi-VN') + ' triệu';
  }

  var Q = [
    { q: 'Anh/chị mua căn hộ để…', k: 'muc', o: [['🏖️', 'Nghỉ dưỡng gia đình'], ['🔑', 'Cho thuê'], ['⚖️', 'Cả hai']] },
    { q: 'Ngân sách dự kiến của anh/chị?', k: 'ns', o: [['💼', 'Dưới 3 tỷ'], ['💰', '3–5 tỷ'], ['🏦', 'Trên 5 tỷ']] },
    { q: 'Anh/chị thích nhất điều gì?', k: 'thich', o: [['🌅', 'View bình minh trên biển'], ['🏙️', 'Tầng cao'], ['👨‍👩‍👧', 'Căn lớn cho cả nhà']] }
  ];
  var U = { s: 'Studio (30–31 m²)', m: '1PN+1 (50–51 m²)', l: '2PN (60–70 m²)' };

  function suggest(a) {
    var size = a.ns === 'Dưới 3 tỷ' ? 0 : a.ns === '3–5 tỷ' ? 1 : 2, t, why;
    if (a.thich === 'Căn lớn cho cả nhà' || (a.muc === 'Nghỉ dưỡng gia đình' && size === 2)) { t = U.l; why = 'đủ chỗ cho cả nhà nghỉ dưỡng bên biển'; }
    else if (a.muc === 'Cho thuê') { t = size === 0 ? U.s : size === 1 ? U.s + ' hoặc ' + U.m : U.m; why = 'diện tích gọn, hợp khách du lịch thuê ngắn ngày'; }
    else if (a.muc === 'Cả hai') { t = size === 2 ? U.m + ' hoặc ' + U.l : U.m; why = 'có góc linh hoạt cho gia đình, ngày vắng nhà vẫn khai thác được'; }
    else { t = size === 0 ? U.s : U.m; why = 'đủ tiện nghi cho gia đình nhỏ nghỉ dưỡng'; }
    var pos = a.thich === 'View bình minh trên biển' ? ', mặt Đông hướng biển (đón bình minh)' : a.thich === 'Tầng cao' ? ', tầng cao hướng biển' : ', ưu tiên hướng biển';
    return { html: 'Dòng căn phù hợp:<span class="sx-big">' + t + pos + '</span>Vì ' + why + '.', plain: t + pos };
  }

  function quizHtml() {
    return '<div class="sx-c" id="sx-quiz"><h3>Căn nào hợp với anh/chị?</h3><p class="sx-sub">3 câu hỏi · chưa tới 20 giây</p><div id="sx-qb"></div></div>';
  }
  function calcHtml() {
    return '<div class="sx-c" id="sx-calc"><h3>Máy tính dòng tiền minh họa</h3><p class="sx-sub">Kéo thanh trượt để xem thu nhập cho thuê ước tính</p>'
      + sl('gia', 'Giá thuê / đêm', 0.6, 4, 0.1, 1.5) + sl('cs', 'Công suất phòng', 30, 90, 5, 65) + sl('o', 'Số đêm gia đình tự ở / năm', 0, 120, 5, 20)
      + '<div class="sx-out"><div><b id="sx-dem">–</b>đêm cho thuê / năm</div><div><b id="sx-dt">–</b>doanh thu / năm</div>'
      + '<div class="sx-hl"><b id="sx-tn">–</b>thu nhập minh họa / năm · ≈ <span id="sx-th">–</span> / tháng</div></div>'
      + '<p class="sx-note">Chỉ là ví dụ minh họa, <b>không phải cam kết</b>. Giả định chi phí vận hành ~35% (quản lý, dọn phòng, điện nước, phí nền tảng). Giá phòng ven biển trục Võ Nguyên Giáp phổ biến khoảng 1–3 triệu/đêm; thực tế tùy căn, mùa và đơn vị vận hành.</p>'
      + '<button type="button" class="sx-btn" id="sx-cgo">Nhận bảng tính chi tiết theo căn thật qua Zalo</button>'
      + formHtml('sx-cf', 'Gửi bảng tính cho tôi') + '</div>';
  }
  function sl(id, lb, mn, mx, st, v) {
    return '<div class="sx-sl"><div class="sx-row"><span>' + lb + '</span><output id="sx-' + id + 'v"></output></div><input type="range" id="sx-' + id + '" min="' + mn + '" max="' + mx + '" step="' + st + '" value="' + v + '" aria-label="' + lb + '"></div>';
  }
  function formHtml(id, cta) {
    return '<div class="sx-f" id="' + id + '"><label>Họ và tên</label><input name="ten" type="text" placeholder="Anh/chị tên gì ạ?">'
      + '<label>Số điện thoại / Zalo</label><input name="sdt" type="tel" placeholder="09xx xxx xxx">'
      + '<label>Thông tin anh/chị đã chọn</label><textarea name="ghichu" readonly></textarea>'
      + '<button type="button" class="sx-btn" data-send>' + cta + '</button>'
      + '<div class="sx-ok">✔ Đã nhận! Chuyên viên Hoàng Hiệp sẽ nhắn Zalo cho anh/chị sớm.</div></div>';
  }

  function wire(box, tag, msgFn) {
    var btn = box.querySelector('[data-send]');
    btn.onclick = function () {
      var ten = box.querySelector('[name=ten]').value.trim(), sdtEl = box.querySelector('[name=sdt]'), sdt = phoneOk(sdtEl.value);
      if (!sdt) { sdtEl.focus(); sdtEl.style.borderColor = '#e8571c'; return; }
      var d = { name: ten || 'Khách web', phone: sdt, message: msgFn(), source: tag };
      var tries = 0; (function go() { if (window.crmLead) { try { window.crmLead(d); } catch (e) {} } else if (tries++ < 20) setTimeout(go, 300); })();
      try { if (window.gtag) window.gtag('event', 'generate_lead', { method: tag }); } catch (e) {}
      try { if (window.fbq) window.fbq('track', 'Lead', { content_name: tag }); } catch (e) {}
      btn.disabled = true; btn.style.opacity = .6; box.querySelector('.sx-ok').style.display = 'block';
    };
  }

  /* ---- Trắc nghiệm ---- */
  var ans = {}, step = 0;
  function renderQ() {
    var b = document.getElementById('sx-qb');
    if (step < Q.length) {
      var q = Q[step];
      b.innerHTML = '<div class="sx-step">Câu ' + (step + 1) + '/3</div><div class="sx-bar"><i style="width:' + ((step) / 3 * 100 + 8) + '%"></i></div>'
        + '<p class="sx-q">' + q.q + '</p><div class="sx-opts">'
        + q.o.map(function (o) { return '<button type="button" class="sx-o" data-v="' + esc(o[1]) + '"><i>' + o[0] + '</i>' + esc(o[1]) + '</button>'; }).join('') + '</div>'
        + (step ? '<button type="button" class="sx-back">← Quay lại</button>' : '');
      b.querySelectorAll('.sx-o').forEach(function (el) { el.onclick = function () { ans[q.k] = el.getAttribute('data-v'); step++; renderQ(); }; });
      var bk = b.querySelector('.sx-back'); if (bk) bk.onclick = function () { step--; renderQ(); };
      return;
    }
    var r = suggest(ans);
    var sum = 'Mua để: ' + ans.muc + ' · Ngân sách: ' + ans.ns + ' · Thích: ' + ans.thich;
    b.innerHTML = '<div class="sx-step">Kết quả</div><div class="sx-bar"><i style="width:100%"></i></div>'
      + '<div class="sx-res">' + r.html + '<span class="sx-sm">' + esc(sum) + '.<br>Gợi ý theo câu trả lời; căn cụ thể và giá đối chiếu khi chủ đầu tư công bố bảng giá.</span></div>'
      + '<button type="button" class="sx-btn" id="sx-qgo">Gửi tôi danh sách căn phù hợp</button>'
      + '<a class="sx-zl" href="' + ZALO + '" target="_blank" rel="noopener">hoặc nhắn Zalo 0904 567 009</a>'
      + formHtml('sx-qf', 'Gửi tôi danh sách căn phù hợp')
      + '<button type="button" class="sx-back">↺ Làm lại</button>';
    var f = document.getElementById('sx-qf');
    f.querySelector('[name=ghichu]').value = sum + ' · Gợi ý: ' + r.plain;
    document.getElementById('sx-qgo').onclick = function () { this.style.display = 'none'; f.classList.add('on'); f.querySelector('[name=ten]').focus(); };
    b.querySelector('.sx-back:last-child').onclick = function () { ans = {}; step = 0; renderQ(); };
    wire(f, 'trac-nghiem', function () { return 'Trắc nghiệm Sun Saphia – ' + sum + ' · Gợi ý: ' + r.plain; });
    try { if (window.gtag) window.gtag('event', 'quiz_complete'); } catch (e) {}
  }

  /* ---- Máy tính ---- */
  var cv = {};
  function calc() {
    var g = +document.getElementById('sx-gia').value, cs = +document.getElementById('sx-cs').value, o = +document.getElementById('sx-o').value;
    var dem = Math.round((365 - o) * cs / 100), dt = dem * g, tn = dt * 0.65;
    document.getElementById('sx-giav').textContent = g.toFixed(1).replace('.', ',') + ' triệu';
    document.getElementById('sx-csv').textContent = cs + '%';
    document.getElementById('sx-ov').textContent = o + ' đêm';
    document.getElementById('sx-dem').textContent = dem;
    document.getElementById('sx-dt').textContent = vnd(dt);
    document.getElementById('sx-tn').textContent = vnd(tn);
    document.getElementById('sx-th').textContent = vnd(tn / 12);
    cv = { g: g, cs: cs, o: o, dem: dem, dt: dt, tn: tn };
    var f = document.getElementById('sx-cf'); if (f) f.querySelector('[name=ghichu]').value = calcMsg();
  }
  function calcMsg() { return 'Giá thuê ' + String(cv.g).replace('.', ',') + ' triệu/đêm · công suất ' + cv.cs + '% · tự ở ' + cv.o + ' đêm/năm → minh họa ' + vnd(cv.tn) + '/năm'; }

  function anchor() {
    var re = /Mặt bằng và các loại căn|Chọn loại căn|Thông tin tổng quan|Căn hộ ngay mặt biển Đà Nẵng ngày càng hiếm|4 điểm đáng chú ý/i;
    var hs = document.querySelectorAll('h2,.ladi-headline,h3'), i, el;
    for (i = 0; i < hs.length; i++) { if (re.test(hs[i].textContent || '')) { el = hs[i]; break; } }
    var sec = el && (el.closest('.ladi-section') || el.closest('section'));
    if (sec) return sec;
    if (el) { var n = el.nextElementSibling; while (n && !/^H2$/.test(n.tagName)) n = n.nextElementSibling; if (n) return { parentNode: n.parentNode, nextSibling: n }; }
    var s = document.querySelectorAll('.ladi-section, section'); return s.length ? s[Math.min(3, s.length - 1)] : null;
  }

  function build() {
    if (document.getElementById('ssx')) return;
    var a = anchor(); if (!a) return;
    var st = document.createElement('style'); st.textContent = CSS; document.head.appendChild(st);
    var w = document.createElement('div'); w.id = 'ssx';
    w.innerHTML = '<div class="sx-w"><div class="sx-k">Tự trải nghiệm</div><h2>Thử nhanh: căn nào hợp và dòng tiền ra sao?</h2>'
      + '<p class="sx-lead">Trả lời 3 câu để biết dòng căn phù hợp, hoặc kéo thanh trượt để xem thu nhập cho thuê minh họa. Kết quả gửi riêng qua Zalo.</p>'
      + '<div class="sx-g">' + quizHtml() + calcHtml() + '</div></div>';
    a.parentNode.insertBefore(w, a.nextSibling || null);
    renderQ();
    ['sx-gia', 'sx-cs', 'sx-o'].forEach(function (id) { document.getElementById(id).addEventListener('input', calc); });
    calc();
    var cf = document.getElementById('sx-cf');
    document.getElementById('sx-cgo').onclick = function () { this.style.display = 'none'; cf.classList.add('on'); calc(); cf.querySelector('[name=ten]').focus(); };
    wire(cf, 'may-tinh-dong-tien', function () { return 'Máy tính dòng tiền Sun Saphia – ' + calcMsg(); });
  }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', function () { setTimeout(build, 300); });
  else setTimeout(build, 300);
})();
