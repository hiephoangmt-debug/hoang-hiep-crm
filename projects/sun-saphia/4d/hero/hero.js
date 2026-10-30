/* Chế độ HERO: ẩn thanh điều khiển, nắng theo giờ thực ở Đà Nẵng, tự xoay chậm quanh tòa tháp, chữ chìm số điện thoại vẽ vào ảnh WebGL */
(function(){
  try{ wm.visible=false; }catch(e){}   /* bỏ khối logo + số ở giữa; chống chụp bằng lớp chữ chìm chéo trên trang */
  /* giờ theo hướng nhìn: nhìn ra biển (phía +x) = bình minh ~7h, quay về thành phố = hoàng hôn ~18h, chuyển mượt theo vòng xoay */
  var lastH=-1;
  function tick(){ try{
    var cp=world.worldToLocal(camera.position.clone()), tp=world.worldToLocal(controls.target.clone()), dx=tp.x-cp.x, dz=tp.z-cp.z, L=Math.hypot(dx,dz)||1, c=dx/L;
    var h=12.5-6.2*c; h=Math.max(+hourEl.min,Math.min(+hourEl.max,h)); if(Math.abs(h-lastH)<.04) return; lastH=h;
    hourEl.value=h.toFixed(2); setTime(h); try{ parent.postMessage({ss4dHero:'h',h:h},'*'); }catch(e){} if(typeof refreshEnv==='function') refreshEnv();
    if(hourOut){ var H=Math.floor(h),M=Math.round((h-H)*60); if(M===60){H++;M=0;} hourOut.textContent=(H<10?'0':'')+H+':'+(M<10?'0':'')+M; } }catch(e){} }
  function cam(){ try{
    var m=innerWidth/innerHeight<1.1, t=world.localToWorld(new THREE.Vector3(-47,m?70:60,46));
    var off=new THREE.Vector3(-430,150,-370).multiplyScalar(m?.88:.82);   /* góc đẹp nhất: từ phía Tây Bắc, biển phía sau bên trái, công viên phía trước tòa */
    controls.target.copy(t); camera.position.copy(world.localToWorld(new THREE.Vector3(-47,0,46).add(off).setY((m?70:60)+off.y)));
    controls.enableZoom=false; controls.enablePan=false; controls.autoRotate=true; controls.autoRotateSpeed=.32; controls.update();
    DEF={p:camera.position.clone(),t:controls.target.clone()}; }catch(e){} }
  cam(); tick(); setInterval(tick,250); addEventListener('resize',function(){ setTimeout(cam,50); });
  try{ parent.postMessage({ss4dHero:'ready'},'*'); }catch(e){}
})();
