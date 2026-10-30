/* cầu đường bộ quanh FourS: mặt cầu vồng nhẹ, trụ, lan can, cột đèn 2 bên (tối sáng), dải LED đổi màu dọc 2 mép */
function roadBridge(A,B,W,H,name,hue){ var b=bridgeGrp(A,B), g=b.g, L=b.L, N=24, P=[];
  for(var i=0;i<=N;i++){ var t=i/N; P.push([-L/2+t*L, .4+H*Math.sin(Math.PI*t)]); }
  var dk=M(0x9a9da2,{roughness:.8}), rl=M(0xe8e8e6,{roughness:.5,emissive:0xffffff,emissiveIntensity:0}), pole=M(0x8a9097,{roughness:.5,metalness:.5});
  for(var i=0;i<N;i++){ var a=P[i], c=P[i+1], l=Math.hypot(c[0]-a[0],c[1]-a[1]), ang=Math.atan2(c[1]-a[1],c[0]-a[0]);
    var s=new THREE.Mesh(new THREE.BoxGeometry(l+.3,1.4,W),dk); s.position.set((a[0]+c[0])/2,(a[1]+c[1])/2-.5,0); s.rotation.z=ang; s.castShadow=s.receiveShadow=true; g.add(s);
    [-1,1].forEach(function(sd){ var r=new THREE.Mesh(new THREE.BoxGeometry(l+.3,1.1,.35),rl); r.position.set((a[0]+c[0])/2,(a[1]+c[1])/2+.55,sd*(W/2-.2)); r.rotation.z=ang; g.add(r); }); }
  for(var x=-L/2+30;x<L/2-20;x+=34){ var y=.4+H*Math.sin(Math.PI*(x+L/2)/L); if(y<2.5) continue; var p=new THREE.Mesh(new THREE.BoxGeometry(3,y-.6,W*.6),M(0xa3a6aa)); p.position.set(x,(y-.6)/2,0); g.add(p); }
  var heads=[], hm=new THREE.MeshBasicMaterial({color:0xffe2a8,transparent:true,opacity:0}), gm=new THREE.MeshBasicMaterial({color:0xffc070,transparent:true,opacity:0,depthWrite:false,blending:THREE.AdditiveBlending});
  for(var x=-L/2+6;x<=L/2-6;x+=22){ var y=.4+H*Math.sin(Math.PI*(x+L/2)/L); [-1,1].forEach(function(sd){ var c=new THREE.Mesh(new THREE.CylinderGeometry(.13,.17,8,6),pole); c.position.set(x,y+4,sd*(W/2-.5)); g.add(c);
      var h=new THREE.Mesh(new THREE.SphereGeometry(.7,8,6),hm); h.position.set(x,y+8.1,sd*(W/2-1.6)); g.add(h); }); }
  var led=[-1,1].map(function(sd){ var m=new THREE.MeshBasicMaterial({color:0x66ccff,transparent:true,opacity:0}), pts=[]; P.forEach(function(q){ pts.push(new THREE.Vector3(q[0],q[1]-1.25,sd*(W/2+.05))); });
    var t=new THREE.Mesh(new THREE.TubeGeometry(new THREE.CatmullRomCurve3(pts),48,.28,6,false),m); g.add(t); return m; });
  bridgeFx.push(function(dt,tm,n){ hm.opacity=n; gm.opacity=.35*n; rl.emissiveIntensity=n*.25; led.forEach(function(m,i){ m.color.setHSL((hue+tm*.05+i*.1)%1,1,.6); m.opacity=n; }); });
  return g; }
roadBridge([-2458,-238],[-2583,-474],30,6,'Cầu Trung Lương',.55);   // Quảng Nam (Nguyễn Phước Lan) qua sông, ~268 m
roadBridge([-1566,438],[-1389,432],30,4.5,'Cầu Bờ Quan',.08);        // Minh Mạng, ~177 m
