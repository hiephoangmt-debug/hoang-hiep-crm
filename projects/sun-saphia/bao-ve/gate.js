/* SS-GATE: link riêng (mở trực tiếp, không qua website) chỉ người được cấp mới xem được (tab "Quyền xem" trong CRM).
   Người xem nhập EMAIL đã được cấp → hệ thống gửi mã 6 số vào đúng hộp thư → nhập mã → xem (nhớ 30 ngày trên máy đó).
   Chủ / nội bộ có thể nhập mã truy cập riêng. Trên website (nhúng) hoặc &pub=1 thì xem tự do (có chữ chìm). */
(function(){
  var Q=location.search||'', embedded=/^about:/.test(location.href);
  if(embedded||/[?&]pub=1/.test(Q)) return;
  var API='https://script.google.com/macros/s/AKfycbyChbG-uvItjVlRk7JgLrwpUS6Cgah4nIA6BWHuEwgbXBqSlvAPJNSdZdp6pQ91d_rN/exec', SITE='kGYgRtNhbHZr';
  var css='#ssGate{position:fixed;inset:0;z-index:2147483647;background:linear-gradient(160deg,#0A2540,#12355c);display:flex;align-items:center;justify-content:center;font-family:"Be Vietnam Pro",Arial,sans-serif;padding:16px}'
   +'#ssGate .bx{background:#fff;border-radius:16px;max-width:370px;width:100%;padding:22px 20px;text-align:center;box-shadow:0 18px 40px rgba(0,0,0,.35);border-top:5px solid #FF6A2B}'
   +'#ssGate .lg{width:54px;height:54px;border-radius:14px;margin:0 auto 10px;background:linear-gradient(135deg,#FF8A3D,#FF6A2B);color:#fff;font:800 22px Georgia,serif;display:flex;align-items:center;justify-content:center}'
   +'#ssGate h3{margin:0 0 4px;color:#0A2540;font-size:18px}#ssGate p{margin:0 0 12px;color:#41505f;font-size:13.5px;line-height:1.45}'
   +'#ssGate input{width:100%;box-sizing:border-box;border:1.5px solid #c9d3dd;border-radius:10px;padding:11px 12px;font-size:16px;text-align:center}'
   +'#ssGate button{margin-top:10px;width:100%;border:0;border-radius:10px;padding:12px;background:#FF6A2B;color:#fff;font:800 15px inherit;cursor:pointer}'
   +'#ssGate .lnk{background:none;color:#0A2540;font-weight:700;font-size:13px;margin-top:6px;padding:4px;text-decoration:underline}'
   +'#ssGate .m{min-height:18px;margin-top:8px;font-size:13px;color:#d63b2f;font-weight:700}#ssGate .ok{color:#1b8a4a}#ssGate a{color:#0A2540;font-weight:800;text-decoration:none}';
  var st=document.createElement('style'); st.textContent=css; (document.head||document.documentElement).appendChild(st);
  var ov=document.createElement('div'); ov.id='ssGate';
  ov.innerHTML='<div class="bx"><div class="lg">SR</div><h3>Link riêng Sun Saphia Residence</h3><p id="ssGateTx">Nhập email đã được Hoàng Hiệp cấp quyền. Mã xác nhận sẽ gửi vào hộp thư của email đó.</p>'
   +'<input id="ssGateIn" type="email" autocomplete="email" autocapitalize="off" placeholder="Email của bạn"><button type="button" id="ssGateBt">Gửi mã vào email</button>'
   +'<button type="button" class="lnk" id="ssGateBk" style="display:none">← Nhập email khác</button><div class="m" id="ssGateMsg"></div>'
   +'<p style="margin:10px 0 0">Chưa được cấp quyền? Liên hệ <a href="tel:0904567009">0904 567 009</a> · <a href="https://zalo.me/0904567009">Zalo</a></p></div>';
  function mount(){ if(!document.getElementById('ssGate')) (document.body||document.documentElement).appendChild(ov); }
  if(document.body) mount(); else document.addEventListener('DOMContentLoaded',mount); mount();
  var $=function(s){ return ov.querySelector(s); }, step='email', email='';
  function msg(t,ok){ var m=$('#ssGateMsg'); m.textContent=t; m.className='m'+(ok?' ok':''); }
  function call(params,cb){
    var name='ssg'+Date.now()+Math.floor(Math.random()*1e4), s=document.createElement('script'), done=false, q=['cb='+name,'key='+SITE];
    for(var k in params) q.push(k+'='+encodeURIComponent(params[k]));
    window[name]=function(r){ done=true; try{delete window[name];}catch(e){} if(s.parentNode) s.parentNode.removeChild(s); cb(r||{}); };
    s.src=API+'?'+q.join('&'); s.onerror=function(){ if(!done){ done=true; cb({error:1}); } };
    setTimeout(function(){ if(!done){ done=true; cb({error:1}); } },20000);
    document.head.appendChild(s);
  }
  var page=(location.pathname.split('/').pop()||'')+(/[?&]crm/.test(Q)?' (crm)':'');
  function grant(r,store){ if(store){ try{localStorage.setItem('ssKey',store);}catch(e){} } window.SS_KEY=store||window.SS_KEY; window.SS_USER=r.name||''; ov.remove(); }
  function reason(r){ return r.error?'Không kết nối được, thử lại sau.':r.reason==='expired'?'Quyền xem đã hết hạn.':r.reason==='locked'?'Quyền xem đã bị khóa.':r.reason==='otp'?'Mã xác nhận không đúng hoặc đã hết hạn.':r.reason==='email'?'Email không hợp lệ.':'Email / mã này chưa được cấp quyền.'; }
  function toOtp(){ step='otp'; $('#ssGateTx').textContent='Đã gửi mã 6 số tới '+email+'. Mở hộp thư (kể cả mục Spam/Quảng cáo) và nhập mã:'; var i=$('#ssGateIn'); i.value=''; i.type='text'; i.inputMode='numeric'; i.placeholder='Mã 6 số'; $('#ssGateBt').textContent='Xác nhận'; $('#ssGateBk').style.display='block'; i.focus&&i.focus(); }
  function toEmail(){ step='email'; $('#ssGateTx').textContent='Nhập email đã được Hoàng Hiệp cấp quyền. Mã xác nhận sẽ gửi vào hộp thư của email đó.'; var i=$('#ssGateIn'); i.value=email; i.type='email'; i.placeholder='Email của bạn'; $('#ssGateBt').textContent='Gửi mã vào email'; $('#ssGateBk').style.display='none'; msg(''); }
  function go(){
    var v=String($('#ssGateIn').value||'').trim(); if(!v) return;
    if(step==='email'){
      if(v.indexOf('@')<0){ msg('Đang kiểm tra…',1); own(v,function(){ grant({name:'Hoàng Hiệp'},v); },function(){ call({action:'access',code:v,page:page},function(r){ if(r.access===true) grant(r,v); else msg(reason(r)); }); }); return; }  // mã truy cập nội bộ
      email=v.toLowerCase(); msg('Đang gửi mã…',1);
      call({action:'access_req',email:email},function(r){ if(r.sent){ toOtp(); msg(r.wait?'Mã vừa được gửi, vui lòng kiểm tra hộp thư.':'',1); } else msg(reason(r)); });
    } else {
      msg('Đang xác nhận…',1);
      call({action:'access_otp',email:email,otp:v,page:page},function(r){ if(r.access===true&&r.token) grant(r,r.token); else msg(reason(r)); });
    }
  }
  $('#ssGateBt').onclick=go; $('#ssGateIn').onkeydown=function(e){ if(e.key==='Enter') go(); }; $('#ssGateBk').onclick=toEmail;
  var pe=(/[?&]e=([^&#]+)/.exec(Q)||[])[1]; if(pe){ $('#ssGateIn').value=decodeURIComponent(pe); }
  var k=(/[?&]k=([^&#]+)/.exec(Q)||[])[1]; if(k) k=decodeURIComponent(k); else { try{ k=localStorage.getItem('ssKey'); }catch(e){} }
  // mã chủ: kiểm tra ngay trên máy (băm SHA-256), không cần CRM
  function own(c,yes,no){ try{ crypto.subtle.digest('SHA-256',new TextEncoder().encode(c)).then(function(d){ var h=[].map.call(new Uint8Array(d),function(x){return ('0'+x.toString(16)).slice(-2)}).join(''); h==='029a64f4f8d4479b70daca4fcb4fb719cf27ea51878aea2339f4616e3e455146'?yes():no(); },no); }catch(e){ no(); } }
  if(k&&k.indexOf('@')<0) own(k,function(){ grant({name:'Hoàng Hiệp'},k); },function(){ msg('Đang kiểm tra…',1); call({action:'access',code:k,page:page},function(r){ if(r.access===true) grant(r,k); else { try{localStorage.removeItem('ssKey');}catch(e){} msg(r.error?reason(r):''); } }); }); 
})();
