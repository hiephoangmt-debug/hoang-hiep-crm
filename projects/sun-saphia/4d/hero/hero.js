/* Chế độ HERO: ẩn thanh điều khiển, nắng theo giờ thực ở Đà Nẵng, tự xoay chậm quanh tòa tháp, chữ chìm số điện thoại vẽ vào ảnh WebGL */
(function(){
  try{ wm.visible=false; }catch(e){}   /* bỏ khối logo + số ở giữa; chống chụp bằng lớp chữ chìm chéo trên trang */
  function vnHour(){ var d=new Date(); return ((d.getUTCHours()+7)%24)+d.getUTCMinutes()/60; }
  function tick(){ try{ var h=Math.max(+hourEl.min,Math.min(+hourEl.max,vnHour())); hourEl.value=h.toFixed(2); setTime(h); if(typeof refreshEnv==='function') refreshEnv(); if(hourOut){ var H=Math.floor(h),M=Math.round((h-H)*60); hourOut.textContent=(H<10?'0':'')+H+':'+(M<10?'0':'')+M; } }catch(e){} }
  function cam(){ try{
    var m=innerWidth/innerHeight<1.1, t=world.localToWorld(new THREE.Vector3(-47,m?70:60,46));
    var off=new THREE.Vector3(-430,150,-370).multiplyScalar(m?.88:.82);   /* góc đẹp nhất: từ phía Tây Bắc, biển phía sau bên trái, công viên phía trước tòa */
    controls.target.copy(t); camera.position.copy(world.localToWorld(new THREE.Vector3(-47,0,46).add(off).setY((m?70:60)+off.y)));
    controls.enableZoom=false; controls.enablePan=false; controls.autoRotate=true; controls.autoRotateSpeed=.32; controls.update();
    DEF={p:camera.position.clone(),t:controls.target.clone()}; }catch(e){} }
  cam(); tick(); setInterval(tick,60000); addEventListener('resize',function(){ setTimeout(cam,50); });
  try{ parent.postMessage({ss4dHero:'ready'},'*'); }catch(e){}
})();
