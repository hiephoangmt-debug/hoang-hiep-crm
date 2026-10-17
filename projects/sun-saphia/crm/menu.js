/* Sun Saphia – nút ☰ ở góc phải thanh đầu: bấm mở danh sách mục, chạm để cuộn tới. */
(function () {
  if (window.__ssMenu) return; window.__ssMenu = 1;
  var ITEMS = [
    ['🏢', 'Tổng quan', /thông tin tổng quan|tòa tháp 30 tầng mặt biển khu saphia/i],
    ['📍', 'Vị trí', /vị trí sun saphia|4 điểm đáng chú ý/i],
    ['🌳', 'Tiện ích', /chuỗi công viên|dải công viên|công viên – bãi tắm/i],
    ['📐', 'Mặt bằng', /mặt bằng và các loại căn|chọn loại căn/i],
    ['📜', 'Chính sách', /tiến độ, pháp lý và chính sách|vào danh sách quan tâm trước ngày|giá bán sun saphia/i],
    ['🧊', '4D căn hộ', '#ss4d', /xoay 3d, xem nắng|kiến trúc, phối cảnh|mô hình 3d/i]
  ];
  var CSS = ''
    + '#ssm-btn{position:fixed;top:9px;right:12px;z-index:100000;width:44px;height:40px;border-radius:11px;border:1.5px solid rgba(255,197,154,.8);background:linear-gradient(145deg,#FF9A3D,#FF6A2B 55%,#E8460F);box-shadow:0 4px 14px rgba(255,106,43,.45);cursor:pointer;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:5px;padding:0}'
    + '#ssm-btn i{display:block;width:20px;height:2.6px;border-radius:2px;background:#fff;transition:.3s}'
    + '#ssm-btn.on i:nth-child(1){transform:translateY(7.6px) rotate(45deg)}#ssm-btn.on i:nth-child(2){opacity:0}#ssm-btn.on i:nth-child(3){transform:translateY(-7.6px) rotate(-45deg)}'
    + '#ssm-ov{position:fixed;inset:0;z-index:99998;background:rgba(6,20,36,.55);opacity:0;pointer-events:none;transition:opacity .3s}'
    + '#ssm-ov.on{opacity:1;pointer-events:auto}'
    + '#ssm-pn{position:fixed;top:0;right:0;bottom:0;z-index:99999;width:min(86vw,330px);background:linear-gradient(170deg,#0A2540,#12355c);color:#fff;transform:translateX(105%);transition:transform .35s cubic-bezier(.2,.8,.2,1);box-shadow:-12px 0 40px rgba(0,0,0,.35);display:flex;flex-direction:column;font-family:"Be Vietnam Pro",Arial,sans-serif}'
    + '#ssm-pn.on{transform:none}'
    + '#ssm-pn .h{padding:18px 18px 12px;border-bottom:1px solid rgba(255,255,255,.12)}'
    + '#ssm-pn .h small{display:block;color:#FFB067;font-size:11.5px;font-weight:800;letter-spacing:.14em;text-transform:uppercase}'
    + '#ssm-pn .h b{display:block;font-size:19px;margin-top:4px}'
    + '#ssm-pn ul{list-style:none;margin:0;padding:8px 10px;overflow:auto;flex:1}'
    + '#ssm-pn li a{display:flex;align-items:center;gap:12px;padding:12px 10px;border-radius:12px;color:#e6eef7;text-decoration:none;font-size:15.5px;font-weight:600;transition:.2s}'
    + '#ssm-pn li a:hover,#ssm-pn li a:active{background:rgba(255,138,61,.16);color:#fff;transform:translateX(4px)}'
    + '#ssm-pn li a span{width:28px;text-align:center;font-size:18px}'
    + '#ssm-pn .f{padding:12px 14px 18px;display:flex;gap:10px;border-top:1px solid rgba(255,255,255,.12)}'
    + '#ssm-pn .f a{flex:1;text-align:center;padding:12px 8px;border-radius:12px;font-weight:800;font-size:14.5px;color:#fff;text-decoration:none}'
    + '#ssm-pn .f .z{background:#0068FF}#ssm-pn .f .c{background:linear-gradient(90deg,#FF5A1F,#FF8A00)}';

  function headings() { return document.querySelectorAll('h1,h2,h3,.ladi-headline'); }
  function find(re) {
    var hs = headings(), last = null;
    for (var i = 0; i < hs.length; i++) { var t = (hs[i].textContent || '').trim(); if (t.length < 160 && re.test(t)) { last = last || hs[i]; } }
    return last;
  }
  function target(it) { if (typeof it[2] === 'string') { var e = document.querySelector(it[2]); return e || find(it[3]); } return find(it[2]); }
  function go(el) {
    var y = el.getBoundingClientRect().top + window.pageYOffset - 70;
    try { window.scrollTo({ top: y, behavior: 'smooth' }); } catch (e) { window.scrollTo(0, y); }
  }
  function build() {
    if (document.getElementById('ssm-btn')) return;
    var st = document.createElement('style'); st.textContent = CSS; document.head.appendChild(st);
    var btn = document.createElement('button'); btn.id = 'ssm-btn'; btn.type = 'button'; btn.setAttribute('aria-label', 'Mở danh mục'); btn.innerHTML = '<i></i><i></i><i></i>';
    var ov = document.createElement('div'); ov.id = 'ssm-ov';
    var pn = document.createElement('nav'); pn.id = 'ssm-pn'; pn.setAttribute('aria-label', 'Danh mục trang');
    var lis = '';
    ITEMS.forEach(function (it, i) { if (target(it)) lis += '<li><a href="#" data-i="' + i + '"><span>' + it[0] + '</span>' + it[1] + '</a></li>'; });
    pn.innerHTML = '<div class="h"><small>Sun Saphia Residence</small><b>Xem nhanh</b></div><ul>' + lis + '</ul>'
      + '<div class="f"><a class="z" href="https://zalo.me/0904567009" target="_blank" rel="noopener">Zalo</a><a class="c" href="tel:0904567009">📞 0904 567 009</a></div>';
    document.body.appendChild(ov); document.body.appendChild(pn); document.body.appendChild(btn);
    function open(v) { btn.classList.toggle('on', v); ov.classList.toggle('on', v); pn.classList.toggle('on', v); }
    btn.onclick = function () { open(!pn.classList.contains('on')); };
    ov.onclick = function () { open(false); };
    pn.querySelectorAll('ul a').forEach(function (a) {
      a.onclick = function (e) { e.preventDefault(); var el = target(ITEMS[+a.getAttribute('data-i')]); open(false); if (el) setTimeout(function () { go(el); }, 250); };
    });
  }
  // chờ các khối chèn thêm (trắc nghiệm…) xuất hiện rồi mới dựng danh mục
  function start() { setTimeout(build, 2500); }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', start); else start();
})();
