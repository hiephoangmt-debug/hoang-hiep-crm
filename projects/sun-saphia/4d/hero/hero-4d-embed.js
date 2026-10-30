/* Sun Saphia – hero 4D: mô hình 3D tự xoay chậm, nắng theo giờ thực ở Đà Nẵng, chữ chìm số điện thoại. Sinh tự động bởi build-hero.py */
(function(){
  var box=document.getElementById('h4d'); if(!box||box.__on) return; box.__on=1;
  var SRC=["https://cdn.jsdelivr.net/gh/hiephoangmt-debug/hoang-hiep-crm@5ab8f9bda35debfb47f8e524381cd17a5cb4551c/projects/sun-saphia/4d/sun-saphia-4d.html", "https://raw.githubusercontent.com/hiephoangmt-debug/hoang-hiep-crm/5ab8f9bda35debfb47f8e524381cd17a5cb4551c/projects/sun-saphia/4d/sun-saphia-4d.html"], JS="/* Chế độ HERO: ẩn thanh điều khiển, nắng theo giờ thực ở Đà Nẵng, tự xoay chậm quanh tòa tháp, chữ chìm số điện thoại vẽ vào ảnh WebGL */\n(function(){\n  try{ wm.visible=false; }catch(e){}   /* bỏ khối logo + số ở giữa; chống chụp bằng lớp chữ chìm chéo trên trang */\n  function vnHour(){ var d=new Date(); return ((d.getUTCHours()+7)%24)+d.getUTCMinutes()/60; }\n  function tick(){ try{ var h=Math.max(+hourEl.min,Math.min(+hourEl.max,vnHour())); hourEl.value=h.toFixed(2); setTime(h); if(typeof refreshEnv==='function') refreshEnv(); if(hourOut){ var H=Math.floor(h),M=Math.round((h-H)*60); hourOut.textContent=(H<10?'0':'')+H+':'+(M<10?'0':'')+M; } }catch(e){} }\n  function cam(){ try{\n    var m=innerWidth/innerHeight<1.1, t=world.localToWorld(new THREE.Vector3(-47,m?70:60,46));\n    var off=new THREE.Vector3(-430,150,-370).multiplyScalar(m?.88:.82);   /* góc đẹp nhất: từ phía Tây Bắc, biển phía sau bên trái, công viên phía trước tòa */\n    controls.target.copy(t); camera.position.copy(world.localToWorld(new THREE.Vector3(-47,0,46).add(off).setY((m?70:60)+off.y)));\n    controls.enableZoom=false; controls.enablePan=false; controls.autoRotate=true; controls.autoRotateSpeed=.32; controls.update();\n    DEF={p:camera.position.clone(),t:controls.target.clone()}; }catch(e){} }\n  cam(); tick(); setInterval(tick,60000); addEventListener('resize',function(){ setTimeout(cam,50); });\n  try{ parent.postMessage({ss4dHero:'ready'},'*'); }catch(e){}\n})();\n", CSS="<style id=\"ss-hero\">.top,.console,.note,#viewhint,.viewhint{display:none!important}html,body{background:#cfe3ee!important}<\/style>\n", f=null;
  box.addEventListener('contextmenu',function(e){ e.preventDefault(); });
  addEventListener('message',function(e){ if(e.data&&e.data.ss4dHero==='ready'&&f){ setTimeout(function(){ f.style.opacity=1; box.classList.add('on'); },1200); } });
  function get(k){ return fetch(SRC[k]).then(function(r){ if(!r.ok) throw 0; return r.text(); }).catch(function(){ return k+1<SRC.length?get(k+1):''; }); }
  function go(){ if(!window.fetch) return;
    get(0).then(function(h){ var i=h.lastIndexOf('\nloop();\n})();'); if(i<0) return;
      h=h.slice(0,i)+'\n'+JS+h.slice(i)+CSS;
      f=document.createElement('iframe'); f.title='Mô hình 4D Sun Saphia Residence'; f.setAttribute('aria-hidden','true'); f.tabIndex=-1;
      f.style.cssText='position:absolute;inset:0;width:100%;height:100%;border:0;pointer-events:none;opacity:0;transition:opacity 1.2s ease';
      f.srcdoc=h; box.insertBefore(f,box.firstChild.nextSibling);
      try{ if(window.gtag) gtag('event','hero_4d',{event_label:location.pathname}); }catch(e){} }).catch(function(){});
  }
  if(document.readyState==='complete') setTimeout(go,600); else addEventListener('load',function(){ setTimeout(go,600); });
})();
