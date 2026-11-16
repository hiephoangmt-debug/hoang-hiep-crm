// Sun Saphia 4D sunset-from-the-sea clip: deterministic frames.  node v4dvid.js SCRATCH OUTDIR N [FRAMES]
const { chromium } = require('playwright'); const fs=require('fs');
(async () => { const S=process.argv[2], OUT=process.argv[3], N=+process.argv[4], ONLY=process.argv[5]?process.argv[5].split(',').map(Number):null;
  const R='/home/user/hoang-hiep-crm', W=1080, H=1350; fs.mkdirSync(OUT,{recursive:true});
  const b = await chromium.launch({args:['--use-gl=swiftshader','--enable-webgl','--ignore-gpu-blocklist']});
  const p = await b.newPage({ viewport: { width: W, height: H } }); const errs=[]; p.on('pageerror',e=>errs.push(e.message));
  await p.route(/^https?:\/\/(?!localhost)/, r=>{ const u=r.request().url();
    if(/three(\.min)?\.js|three@/.test(u)&&!/Orbit/.test(u)) return r.fulfill({path:S+'/npm3/package/build/three.min.js',contentType:'application/javascript'});
    if(/OrbitControls/.test(u)) return r.fulfill({path:S+'/npm3/package/examples/js/controls/OrbitControls.js',contentType:'application/javascript'});
    const k=u.indexOf('/projects/'); if(k>0&&/\.(webp|png|jpg)$/.test(u)) return r.fulfill({path:R+u.slice(k).replace(/\?.*$/,'')});
    return r.fulfill({body:'',contentType:'text/plain'}); });
  await p.goto('file://'+R+'/projects/sun-saphia/4d/_vid.html?pub=1'); await p.waitForTimeout(8000);
  await p.addStyleTag({content:'body *:not(canvas){visibility:hidden!important} canvas{visibility:visible!important;position:fixed!important;inset:0!important;width:100vw!important;height:100vh!important}'});
  await p.evaluate(()=>window.dispatchEvent(new Event('resize'))); await p.waitForTimeout(1500);
  // freeze time: the page advances only when we step
  await p.evaluate(()=>__4d.ev(`(function(){ window.__FT=100; window.__PD=0; var pn=performance.now.bind(performance);
    performance.now=function(){ return window.__FT*1000; }; clock.getDelta=function(){ var d=window.__PD; window.__PD=0; clock.elapsedTime=window.__FT; return d; };
    __4d.setTime(17.85);
    skyU.top.value.set(0xc85a12); skyU.hor.value.set(0xffb048); scene.fog.color.set(0xf8b060); skyU.sunCol.value.set(0xfff2c8);
    sun.color.set(0xffa050); sun.intensity=.9; hemi.intensity=.5; sea.receiveShadow=false; seaMat.roughness=.38; seaMat.color.set(0xd8e4f0); boats.forEach(function(b){ b.g.visible=false; if(b.chute) b.chute.visible=false; if(b.ln) b.ln.visible=false; });
    skyMat.fragmentShader='uniform vec3 top,hor,bot,sunCol;uniform vec3 sunDir;varying vec3 vP;void main(){float h=vP.y;vec3 c=h>0.?mix(hor,top,pow(clamp(h,0.,1.),.7)):mix(hor,bot,clamp(-h*6.,0.,1.));float s=max(dot(normalize(vP),normalize(sunDir)),0.);float a=acos(min(s,1.));c+=sunCol*(smoothstep(.040,.034,a)*2.2+exp(-a*a/.0045)*.55+exp(-a/.12)*.35);gl_FragColor=vec4(c,1.);}';
    skyMat.needsUpdate=true;
    var fl=new THREE.DirectionalLight(0xffb878,.75); fl.position.set(2000,300,-800); scene.add(fl); window.__fl=fl; controls.maxPolarAngle=Math.PI; controls.minPolarAngle=0; controls.maxDistance=1e5; controls.minDistance=0; controls.enableDamping=false;
    window.__shot=function(D,Y,cy,fov){ camera.fov=fov; camera.clearViewOffset&&camera.clearViewOffset(); camera.aspect=innerWidth/innerHeight; camera.updateProjectionMatrix();
      __4d.look([-45+D,Y,39],[-45,Y+D*Math.tan(cy*Math.PI/180),39]);
      var el=Math.atan((108-Y)/D), c=Math.cos(world.rotation.y), s=Math.sin(world.rotation.y), sx=-c, sz=s;
      var d=new THREE.Vector3(sx*Math.cos(el),Math.sin(el),sz*Math.cos(el)).normalize(); sun.position.copy(towerWorld).addScaledVector(d,1200); sun.target.position.copy(towerWorld); skyU.sunDir.value.copy(d); __fl.position.copy(camera.position).add(new THREE.Vector3(0,250,0)); __fl.target.position.copy(towerWorld); __fl.target.updateMatrixWorld(); };
    window.onresize=null; })()`));
  await p.evaluate(()=>window.removeEventListener('resize',window.onResize));
  const ease=x=>x*x*(3-2*x);
  const list = ONLY || Array.from({length:N},(_,i)=>i+1);
  for(const f of list){ const t=(f-1)/Math.max(1,N-1);
    const D=1150-130*ease(t), Y=44-4*ease(t);
    await p.evaluate(([f,D,Y])=>{ window.__FT=100+f/24; window.__PD=1/24; window.__shot(D,Y,.6,16); },[f,D,Y]);
    await p.waitForTimeout(450);
    await p.screenshot({path:OUT+'/r'+String(f).padStart(4,'0')+'.png'}); }

  console.log('errs',errs.slice(0,3)); await b.close(); })();
