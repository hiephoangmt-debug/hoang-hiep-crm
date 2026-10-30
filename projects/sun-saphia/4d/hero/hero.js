/* Chế độ HERO: ẩn thanh điều khiển, nắng theo giờ thực ở Đà Nẵng, tự xoay chậm quanh tòa tháp, chữ chìm số điện thoại vẽ vào ảnh WebGL */
(function(){
  try{ wm.visible=false; }catch(e){}   /* bỏ khối logo + số ở giữa; chống chụp bằng lớp chữ chìm chéo trên trang */
  /* Ngày đêm chạy TỚI theo chiều tự xoay (góc nhìn tăng dần):
     nhìn ra biển 5h50 mặt trời mọc từ biển → trưa → chiều → hướng thành phố 21h đêm, đèn phố + pháo hoa
     → đêm khuya → rạng sáng → lại nhìn ra biển: mặt trời mọc. Không bao giờ chạy ngược. */
  var lastH=-99;
  function fmt(h){ h=((h%24)+24)%24; var H=Math.floor(h),M=Math.round((h-H)*60); if(M===60){H=(H+1)%24;M=0;} return (H<10?'0':'')+H+':'+(M<10?'0':'')+M; }
  function tick(){ try{
    var cp=world.worldToLocal(camera.position.clone()), tp=world.worldToLocal(controls.target.clone());
    var a=Math.atan2(tp.z-cp.z,tp.x-cp.x), u=(((a/(2*Math.PI))%1)+1)%1;   /* 0 = nhìn thẳng ra biển (+x) */
    var h=u<.5?5.8+(u/.5)*15.2:21+((u-.5)/.5)*8.8; if(h>=24) h-=24;
    if(Math.abs(h-lastH)<.03) return; lastH=h;
    hourEl.value=Math.max(+hourEl.min,Math.min(+hourEl.max,h)).toFixed(2); setTime(h); if(typeof refreshEnv==='function') refreshEnv();
    try{ parent.postMessage({ss4dHero:'h',h:h},'*'); }catch(e){}
    if(hourOut) hourOut.textContent=fmt(h); }catch(e){} }
  function cam(){ try{
    var m=innerWidth/innerHeight<1.1, t=world.localToWorld(new THREE.Vector3(-47,m?70:60,46));
    var off=new THREE.Vector3(-430,150,-370).multiplyScalar(m?.88:.82);   /* góc đẹp nhất: từ phía Tây Bắc, biển phía sau bên trái, công viên phía trước tòa */
    controls.target.copy(t); camera.position.copy(world.localToWorld(new THREE.Vector3(-47,0,46).add(off).setY((m?70:60)+off.y)));
    controls.enableZoom=false; controls.enablePan=false; controls.autoRotate=true; controls.autoRotateSpeed=.32; controls.update();
    DEF={p:camera.position.clone(),t:controls.target.clone()}; }catch(e){} }
  cam(); tick(); setInterval(tick,250); addEventListener('resize',function(){ setTimeout(cam,50); });
  try{ parent.postMessage({ss4dHero:'ready'},'*'); }catch(e){}
})();
