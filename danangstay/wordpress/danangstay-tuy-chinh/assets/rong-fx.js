(function(){
if(matchMedia('(prefers-reduced-motion: reduce)').matches)return;
var box=document.querySelector('.site-header .ds-logo2');if(!box)return;
var cv=document.createElement('canvas');cv.className='ds-fxc';cv.setAttribute('aria-hidden','true');box.appendChild(cv);
var ctx=cv.getContext('2d'),dpr=Math.min(2,window.devicePixelRatio||1),W,H,mx,my,P=[],mode=null,mt=0,t0=performance.now();
function size(){var r=cv.getBoundingClientRect();W=r.width;H=r.height;cv.width=W*dpr;cv.height=H*dpr;ctx.setTransform(dpr,0,0,dpr,0,0);
 var b=box.getBoundingClientRect();mx=b.width*0.39-(r.left-b.left);my=b.height*0.46-(r.top-b.top);}
size();addEventListener('resize',size);
var ANG=-12*Math.PI/180,seq=['fire','smoke','mist'],si=0;
function rnd(a,b){return a+Math.random()*(b-a)}
function emit(kind,n,s){for(var i=0;i<n;i++){var a=ANG+rnd(-.1,.1),sp;
 if(kind=='fire'){sp=rnd(2.8,4.4)*s;P.push({k:0,x:mx,y:my,vx:Math.cos(a)*sp,vy:Math.sin(a)*sp,l:0,L:rnd(28,44),r:rnd(3,6)*s});}
 else if(kind=='smoke'){sp=rnd(1.1,2)*s;P.push({k:1,x:mx,y:my,vx:Math.cos(a)*sp,vy:Math.sin(a)*sp,l:0,L:rnd(70,110),r:rnd(4,7)*s,g:rnd(.35,.7)});}
 else{sp=rnd(2.8,3.8)*s;var d=Math.random()<.75,am=a-0.2;P.push({k:d?2:3,x:mx,y:my,vx:Math.cos(am+rnd(-.05,.05))*sp,vy:Math.sin(am)*sp,l:0,L:d?rnd(40,60):rnd(50,80),r:d?rnd(.7,1.6)*s:rnd(5,9)*s});}}}
function frame(now){
 var t=(now-t0)/1000,s=H/150;
 if(!mode&&t>3.5){var c=(t-3.5)%6;if(c<.05){mode=seq[si%3];si++;mt=now;}}
 if(mode){var e=(now-mt)/1000;var dur=mode=='smoke'?1.6:1.3;if(e<dur){emit(mode,mode=='fire'?6:mode=='smoke'?2:9,s)}else mode=null;}
 ctx.clearRect(0,0,W,H);
 for(var i=P.length-1;i>=0;i--){var p=P[i];p.l++;var f=p.l/p.L;if(f>=1){P.splice(i,1);continue}
  if(p.k==0){p.vy-=.01*s;p.vx*=.99;p.x+=p.vx+rnd(-.4,.4);p.y+=p.vy;var r=p.r*(1+f*1.8);
   ctx.globalCompositeOperation='lighter';var g=ctx.createRadialGradient(p.x,p.y,0,p.x,p.y,r);
   var a=(1-f)*.85;g.addColorStop(0,'rgba(255,250,210,'+a+')');g.addColorStop(.35,'rgba(255,190,60,'+a*.9+')');g.addColorStop(.7,'rgba(255,90,20,'+a*.5+')');g.addColorStop(1,'rgba(200,30,0,0)');
   ctx.fillStyle=g;ctx.beginPath();ctx.arc(p.x,p.y,r,0,7);ctx.fill();}
  else if(p.k==1){p.vy-=.005*s;p.vx*=.98;p.vy*=.98;p.x+=p.vx+Math.sin(p.l*.12+i)*.35;p.y+=p.vy;var r=p.r*(1+f*3.2);
   ctx.globalCompositeOperation='source-over';var a=Math.sin(Math.PI*Math.min(1,f*1.3))*.55;var c=Math.round(255*p.g+60);
   var g=ctx.createRadialGradient(p.x,p.y,0,p.x,p.y,r);g.addColorStop(0,'rgba('+c+','+c+','+(c+8)+','+a+')');g.addColorStop(.6,'rgba('+(c-30)+','+(c-28)+','+(c-20)+','+a*.55+')');g.addColorStop(1,'rgba(120,125,135,0)');
   ctx.fillStyle=g;ctx.beginPath();ctx.arc(p.x,p.y,r,0,7);ctx.fill();}
  else if(p.k==2){p.vy+=.04*s;p.vx*=.988;p.x+=p.vx;p.y+=p.vy;ctx.globalCompositeOperation='lighter';ctx.fillStyle='rgba(225,245,255,'+(1-f)*.9+')';ctx.beginPath();ctx.arc(p.x,p.y,p.r,0,7);ctx.fill();}
  else{p.vy+=.015*s;p.vx*=.97;p.x+=p.vx;p.y+=p.vy;var r=p.r*(1+f*2.5);ctx.globalCompositeOperation='lighter';
   var g=ctx.createRadialGradient(p.x,p.y,0,p.x,p.y,r);var a=(1-f)*.22;g.addColorStop(0,'rgba(220,240,255,'+a+')');g.addColorStop(1,'rgba(180,220,255,0)');ctx.fillStyle=g;ctx.beginPath();ctx.arc(p.x,p.y,r,0,7);ctx.fill();}
 }
 ctx.globalCompositeOperation='source-over';requestAnimationFrame(frame);}
requestAnimationFrame(frame);
})();
