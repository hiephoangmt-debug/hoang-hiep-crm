/* SS-GATE: link riêng (mở trực tiếp, không qua website) phải nhập mã truy cập do Hoàng Hiệp cấp (tab "Quyền xem" trong CRM).
   Trên website (nhúng) hoặc link có &pub=1 thì xem tự do (có chữ chìm). */
(function(){
  var Q=location.search||'', embedded=/^about:/.test(location.href);
  if(embedded||/[?&]pub=1/.test(Q)) return;
  var API='https://script.google.com/macros/s/AKfycbyChbG-uvItjVlRk7JgLrwpUS6Cgah4nIA6BWHuEwgbXBqSlvAPJNSdZdp6pQ91d_rN/exec', SITE='kGYgRtNhbHZr';
  var css='#ssGate{position:fixed;inset:0;z-index:2147483647;background:linear-gradient(160deg,#0A2540,#12355c);display:flex;align-items:center;justify-content:center;font-family:"Be Vietnam Pro",Arial,sans-serif;padding:16px}'
   +'#ssGate .bx{background:#fff;border-radius:16px;max-width:360px;width:100%;padding:22px 20px;text-align:center;box-shadow:0 18px 40px rgba(0,0,0,.35);border-top:5px solid #FF6A2B}'
   +'#ssGate .lg{width:54px;height:54px;border-radius:14px;margin:0 auto 10px;background:linear-gradient(135deg,#FF8A3D,#FF6A2B);color:#fff;font:800 22px Georgia,serif;display:flex;align-items:center;justify-content:center}'
   +'#ssGate h3{margin:0 0 4px;color:#0A2540;font-size:18px}#ssGate p{margin:0 0 12px;color:#41505f;font-size:13.5px;line-height:1.45}'
   +'#ssGate input{width:100%;box-sizing:border-box;border:1.5px solid #c9d3dd;border-radius:10px;padding:11px 12px;font-size:16px;text-align:center;letter-spacing:.08em}'
   +'#ssGate button{margin-top:10px;width:100%;border:0;border-radius:10px;padding:12px;background:#FF6A2B;color:#fff;font:800 15px inherit;cursor:pointer}'
   +'#ssGate .m{min-height:18px;margin-top:8px;font-size:13px;color:#d63b2f;font-weight:700}#ssGate a{color:#0A2540;font-weight:800;text-decoration:none}';
  var st=document.createElement('style'); st.textContent=css; (document.head||document.documentElement).appendChild(st);
  var ov=document.createElement('div'); ov.id='ssGate';
  ov.innerHTML='<div class="bx"><div class="lg">SR</div><h3>Link nội bộ Sun Saphia Residence</h3><p>Nhập mã truy cập được cấp riêng cho bạn để xem mô hình 4D, mặt bằng và chọn căn.</p>'
   +'<input id="ssGateIn" autocomplete="off" autocapitalize="off" placeholder="Mã truy cập"><button type="button" id="ssGateBt">Vào xem</button><div class="m" id="ssGateMsg"></div>'
   +'<p style="margin:10px 0 0">Chưa có mã? Liên hệ <a href="tel:0904567009">0904 567 009</a> · <a href="https://zalo.me/0904567009">Zalo</a></p></div>';
  function mount(){ if(!document.getElementById('ssGate')) (document.body||document.documentElement).appendChild(ov); }
  if(document.body) mount(); else document.addEventListener('DOMContentLoaded',mount); mount();
  function msg(t){ var m=ov.querySelector('#ssGateMsg'); if(m) m.textContent=t; }
  function check(code){
    if(!code) return; msg('Đang kiểm tra…');
    var cb='ssg'+Date.now()+Math.floor(Math.random()*1e4), s=document.createElement('script'), done=false;
    window[cb]=function(r){ done=true; try{delete window[cb];}catch(e){} if(s.parentNode) s.parentNode.removeChild(s);
      if(r&&r.access===true){ try{localStorage.setItem('ssKey',code);}catch(e){} window.SS_KEY=code; window.SS_USER=r.name||''; ov.remove(); }
      else { try{localStorage.removeItem('ssKey');}catch(e){} msg(r&&r.reason==='expired'?'Mã đã hết hạn.':r&&r.reason==='locked'?'Mã đã bị khóa.':'Mã không đúng.'); } };
    s.src=API+'?cb='+cb+'&key='+SITE+'&action=access&code='+encodeURIComponent(code)+'&page='+encodeURIComponent((location.pathname.split('/').pop()||'')+(/[?&]crm/.test(Q)?' (crm)':''));
    s.onerror=function(){ if(!done) msg('Không kiểm tra được mã, thử lại sau.'); };
    setTimeout(function(){ if(!done) msg('Mạng chậm, bấm Vào xem để thử lại.'); },15000);
    document.head.appendChild(s);
  }
  (function(){ var bt=ov.querySelector('#ssGateBt'), inp=ov.querySelector('#ssGateIn');
    if(bt) bt.onclick=function(){ check(String(inp.value||'').trim()); };
    if(inp) inp.onkeydown=function(e){ if(e.key==='Enter') check(String(inp.value||'').trim()); }; })();
  var k=(/[?&]k=([^&#]+)/.exec(Q)||[])[1]; if(k) k=decodeURIComponent(k); else { try{ k=localStorage.getItem('ssKey'); }catch(e){} }
  if(k) check(k);
})();
