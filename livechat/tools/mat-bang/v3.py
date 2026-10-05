import cv2, numpy as np, json
im=cv2.imread('ref2.jpg')[:,:,::-1].astype(int); H,W,_=im.shape
yy,xx=np.mgrid[0:H,0:W]
def near(c,t): return (np.sqrt(((im-np.array(c))**2).sum(-1))<t).astype(np.uint8)*255
S=0.45
def path(m,eps,minA,hole=True):
    cs,hier=cv2.findContours(m,cv2.RETR_CCOMP if hole else cv2.RETR_EXTERNAL,cv2.CHAIN_APPROX_NONE)
    d=[]
    for c in cs:
        if abs(cv2.contourArea(c))<minA: continue
        a=cv2.approxPolyDP(c,eps,True)[:,0]
        if len(a)<3: continue
        d.append('M'+' L'.join(f'{x*S:.1f} {y*S:.1f}' for x,y in a)+'Z')
    return ' '.join(d)
def spath(m,sig,eps,minA,hole=True):
    m=cv2.GaussianBlur(m,(0,0),sig); m=(m>127).astype(np.uint8)*255
    cs,_=cv2.findContours(m,cv2.RETR_CCOMP if hole else cv2.RETR_EXTERNAL,cv2.CHAIN_APPROX_NONE)
    d=[]
    for c in cs:
        if abs(cv2.contourArea(c))<minA: continue
        P=cv2.approxPolyDP(c,eps,True)[:,0].astype(float)*S
        n=len(P)
        if n<3: continue
        s=f'M{P[0][0]:.1f} {P[0][1]:.1f}'
        for k in range(n):
            p0,p1,p2,p3=P[(k-1)%n],P[k],P[(k+1)%n],P[(k+2)%n]
            c1=p1+(p2-p0)/6; c2=p2-(p3-p1)/6
            s+=f' C{c1[0]:.1f} {c1[1]:.1f} {c2[0]:.1f} {c2[1]:.1f} {p2[0]:.1f} {p2[1]:.1f}'
        d.append(s+'Z')
    return ' '.join(d)
legend=((xx>440)&(xx<1380)&(yy>1300))|((xx>1760)&(yy<330))|(yy>1420)   # bảng chú thích, la bàn
out=[]
# ---- khu đất (nền cỏ) ----
green=near((119,155,83),48)|near((70,141,75),40)|near((150,180,100),40)
lots_all=np.zeros((H,W),np.uint8)
C={'SL':((250,201,110),30),'LK1':((246,157,117),28),'LK2':((245,113,126),32),'LKY':((251,250,108),32),'LK5':((190,232,120),36),
   'BTp':((247,213,209),18),'BTs':((244,177,169),22),'BTv':((236,141,238),32),'BTl':((236,187,239),22),'BTc':((60,180,240),48)}
masks={k:near(c,t) for k,(c,t) in C.items()}
for m in masks.values(): lots_all|=m
road=near((174,176,170),16); water=near((75,117,116),32)|near((60,100,105),28); lake=near((114,181,174),28)
site=(green|lots_all|road|water|lake); site[legend]=0
site[(xx<200)]=0
site=cv2.morphologyEx(site,cv2.MORPH_CLOSE,np.ones((41,41),np.uint8)); site=cv2.morphologyEx(site,cv2.MORPH_OPEN,np.ones((25,25),np.uint8))
import roads3
vp=np.array(roads3.R['vcc'][0],np.int32)
vm=np.zeros((H,W),np.uint8); cv2.fillPoly(vm,[np.vstack([vp,[[0,H],[0,0],[vp[0][0],0]]])],255)
cv2.polylines(vm,[vp],False,255,roads3.R['vcc'][1]+6)
site[vm>0]=0; site[(yy>1130)&(xx<600)]=0
n,lab,st,_=cv2.connectedComponentsWithStats(site); big=1+np.argmax(st[1:,4]); site=((lab==big)*255).astype(np.uint8)
from sitepoly import SITE
site=np.zeros((H,W),np.uint8); cv2.fillPoly(site,[np.array(SITE,np.int32)],255)
out.append(f'<path d="{spath(site,3,3,5000,False)}" fill="#c6e3ba" stroke="#a9cf9c" stroke-width="1.2"/>')
x0,y0,w0,h0=cv2.boundingRect(site); json.dump([x0*S,y0*S,w0*S,h0*S],open('bbox.json','w'))
# ---- rừng dừa ----
forest=near((70,141,75),36)&site; forest[xx<1500]=0
forest=cv2.morphologyEx(forest,cv2.MORPH_CLOSE,cv2.getStructuringElement(cv2.MORPH_ELLIPSE,(121,121))); forest&=site; forest=cv2.morphologyEx(forest,cv2.MORPH_OPEN,np.ones((21,21),np.uint8))
out.append(f'<path d="{spath(forest,7,7,15000,False)}" fill="#7fb47a"/>')
# ---- nước ----
w=(water|lake)&site; w[legend]=0
w=cv2.morphologyEx(w,cv2.MORPH_CLOSE,np.ones((13,13),np.uint8)); w=cv2.morphologyEx(w,cv2.MORPH_OPEN,np.ones((7,7),np.uint8))
cv2.circle(w,(1172,722),125,0,-1); w=cv2.GaussianBlur(w,(0,0),2.5); w=(w>128).astype(np.uint8)*255
WATER_IDX=len(out); out.append(None)
lk=lake&site; lk=cv2.morphologyEx(lk,cv2.MORPH_CLOSE,np.ones((15,15),np.uint8)); lk=cv2.morphologyEx(lk,cv2.MORPH_OPEN,np.ones((7,7),np.uint8))
cs,_=cv2.findContours(lk,cv2.RETR_EXTERNAL,cv2.CHAIN_APPROX_NONE); c=max(cs,key=cv2.contourArea); (lx,ly),lr=cv2.minEnclosingCircle(c); lx,ly,lr=1172,722,74
out.append(f'<circle cx="{lx*S:.1f}" cy="{ly*S:.1f}" r="{lr*S*.95:.1f}" fill="#c3eef2" stroke="#fff" stroke-width="2"/><circle cx="{lx*S:.1f}" cy="{ly*S:.1f}" r="{lr*S*.95+7:.1f}" fill="none" stroke="#dfe6dc" stroke-width="6"/>')
print('lake',lx,ly,lr)
# ---- lô đất ----
PAL={'ph':'#c8197a','pv':'#f07fb4','lk':'#a7865f','fs':'#0b2a5b','ws':'#4f78b0'}
BOX=[]; groups={k:[] for k in PAL}; dividers=[]; cents={k:[] for k in PAL}; LOTS=np.zeros((H,W),np.uint8)
for k,m in masks.items():
    m=m.copy(); m[legend]=0; m&=site
    mm=cv2.morphologyEx(m,cv2.MORPH_CLOSE,np.ones((7,7),np.uint8)); mm=cv2.morphologyEx(mm,cv2.MORPH_OPEN,np.ones((5,5),np.uint8))
    cs0,_=cv2.findContours(mm,cv2.RETR_EXTERNAL,cv2.CHAIN_APPROX_NONE)
    for c0 in cs0:
        if cv2.contourArea(c0)<700: continue
        one=np.zeros((H,W),np.uint8); cv2.drawContours(one,[c0],-1,255,-1)
        x,y,w_,h_=cv2.boundingRect(c0); pad=20
        sub=one[max(0,y-pad):y+h_+pad, max(0,x-pad):x+w_+pad]
        sub=cv2.morphologyEx(sub,cv2.MORPH_CLOSE,cv2.getStructuringElement(cv2.MORPH_ELLIPSE,(17,17)))
        sub=cv2.GaussianBlur(sub,(0,0),2); sub=(sub>128).astype(np.uint8)*255
        one[max(0,y-pad):y+h_+pad, max(0,x-pad):x+w_+pad]=sub
        cs1,_=cv2.findContours(one,cv2.RETR_EXTERNAL,cv2.CHAIN_APPROX_NONE)
        c=max(cs1,key=cv2.contourArea); A=cv2.contourArea(c)
        M=cv2.moments(c); cx,cy=M['m10']/M['m00'],M['m01']/M['m00']
        if k=='SL' and 900<cx<1120 and 850<cy<1130: continue
        if k=='SL': g='ph' if cx<840 else 'pv'
        elif k.startswith('LK'):
            if cx>1150: continue
            g='lk'
        else: g='fs' if cy<790 else 'ws'
        (rx,ry),(rw,rh),ang=cv2.minAreaRect(c)
        if rw<rh: rw,rh,ang=rh,rw,ang+90
        hull=cv2.convexHull(c); fill=cv2.contourArea(hull)/(rw*rh)
        # số lô: đếm vạch sáng cắt ngang trục dài
        blk=np.zeros((H,W),np.uint8); cv2.drawContours(blk,[c],-1,255,-1)
        if fill>0.88:
            BOX.append([g,rx,ry,rw,rh,ang])
        else:
            a2=cv2.approxPolyDP(c,2.5,True)[:,0]; cv2.fillPoly(LOTS,[a2.astype(np.int32)],255)
            groups[g].append('M'+' L'.join(f'{x*S:.1f} {y*S:.1f}' for x,y in a2)+'Z')
        cents[g].append((cx*S,cy*S,A))
# ---- chuẩn hoá dãy: cùng góc, cùng bề dày, thẳng hàng ----
def unit(a): r=np.radians(a); return np.array([np.cos(r),np.sin(r)])
for B in BOX: B[5]=B[5]%180
for g in PAL:
    bs=[B for B in BOX if B[0]==g]
    # gom các dãy song song (lệch góc <5°) -> dùng chung một góc
    done=set()
    for i,b in enumerate(bs):
        if i in done: continue
        fam=[j for j,c in enumerate(bs) if j not in done and min(abs(c[5]-b[5]),180-abs(c[5]-b[5]))<5]
        angs=[bs[j][5] if abs(bs[j][5]-b[5])<90 else bs[j][5]+(180 if bs[j][5]<b[5] else -180) for j in fam]
        A0=float(np.median(angs))
        for j in fam: bs[j][5]=A0; done.add(j)
    # gom các khối cùng hàng (cùng góc, lệch ngang < 0.6 bề dày) -> cùng tim, cùng bề dày
    done=set()
    for i,b in enumerate(bs):
        if i in done: continue
        u=unit(b[5]); n=np.array([-u[1],u[0]])
        row=[j for j,c in enumerate(bs) if j not in done and c[5]==b[5] and abs(np.dot([c[1]-b[1],c[2]-b[2]],n))<0.6*b[4]]
        off=float(np.median([np.dot([bs[j][1],bs[j][2]],n) for j in row])); hh=float(np.median([bs[j][4] for j in row]))
        for j in row:
            c=bs[j]; along=np.dot([c[1],c[2]],u); p=along*u+off*n; c[1],c[2],c[4]=p[0],p[1],hh; done.add(j)
for g,rx,ry,rw,rh,ang in BOX:
    box=cv2.boxPoints(((rx,ry),(rw-1,rh-1),ang)); cv2.fillPoly(LOTS,[box.astype(np.int32)],255)
    groups[g].append('M'+' L'.join(f'{x*S:.1f} {y*S:.1f}' for x,y in box)+'Z')
    ux,uy=np.cos(np.radians(ang)),np.sin(np.radians(ang)); vx,vy=-uy,ux
    unitW={'ph':17,'pv':17,'lk':16,'fs':21,'ws':21}[g]; kU=max(2,round(rw/unitW))
    for j in range(1,kU):
        t=-rw/2+rw*j/kU; px,py=rx+ux*t,ry+uy*t
        x1,y1=px+vx*(rh/2-1),py+vy*(rh/2-1); x2,y2=px-vx*(rh/2-1),py-vy*(rh/2-1)
        dividers.append(f'M{x1*S:.1f} {y1*S:.1f} L{x2*S:.1f} {y2*S:.1f}')
band=[(963,862),(972,930),(1000,995),(1050,1048),(1110,1088),(1165,1113)]; BW=60
pts=np.array(band,float); seg=np.diff(pts,axis=0); L=np.hypot(*seg.T); cum=np.r_[0,np.cumsum(L)]
def at(t):
    i=min(np.searchsorted(cum,t,side='right')-1,len(L)-1); f=(t-cum[i])/L[i]; p=pts[i]+seg[i]*f; d=seg[i]/L[i]; return p,np.array([-d[1],d[0]])
N=60; left=[];right=[]
for t in np.linspace(0,cum[-1],N):
    p,nrm=at(t); left.append(p+nrm*BW/2); right.append(p-nrm*BW/2)
poly=np.array(left+right[::-1]); cv2.fillPoly(LOTS,[poly.astype(np.int32)],255)
groups['pv'].append('M'+' L'.join(f'{x*S:.1f} {y*S:.1f}' for x,y in poly)+'Z')
nU=round(cum[-1]/17)
for j in range(1,nU):
    p,nrm=at(cum[-1]*j/nU); a1=p+nrm*(BW/2-1); a2=p-nrm*(BW/2-1)
    dividers.append(f'M{a1[0]*S:.1f} {a1[1]*S:.1f} L{a2[0]*S:.1f} {a2[1]*S:.1f}')
cents['pv'].append((1050*S,1000*S,BW*cum[-1]))
WM=w.copy(); WM[cv2.dilate(LOTS,cv2.getStructuringElement(cv2.MORPH_ELLIPSE,(19,19)))>0]=0
out[WATER_IDX]=f'<path d="{spath(WM,4,4,1500)}" fill="#9fd6ec" fill-rule="evenodd"/>'
# ---- đường (vẽ tay theo tim đường, bề rộng đều) ----
import roads3
rm=np.zeros((H,W),np.uint8)
from snaproads import snap
Lb=LOTS>0
def smooth_d(P):
    P=[(x*S,y*S) for x,y in P]
    if len(P)<3: return 'M'+' L'.join(f'{x:.1f} {y:.1f}' for x,y in P)
    d=f'M{P[0][0]:.1f} {P[0][1]:.1f}'
    for k in range(len(P)-1):
        p0=P[max(k-1,0)];p1=P[k];p2=P[k+1];p3=P[min(k+2,len(P)-1)]
        c1=(p1[0]+(p2[0]-p0[0])/6,p1[1]+(p2[1]-p0[1])/6); c2=(p2[0]-(p3[0]-p1[0])/6,p2[1]-(p3[1]-p1[1])/6)
        d+=f' C{c1[0]:.1f} {c1[1]:.1f} {c2[0]:.1f} {c2[1]:.1f} {p2[0]:.1f} {p2[1]:.1f}'
    return d
curb=[];top=[]; RD={}
for k,(pts,wd) in roads3.R.items():
    if k=='vcc': continue
    cl,ws,segs=snap(pts,wd,Lb)
    if k=='ring': segs=[tuple(p) for p in pts]; ws=np.full(len(pts),wd*.8)
    cls={'blvd':30,'ring':30,'sl5':30,'hotel':30,'entry':30,'west':22,'east':22,'r12':22,'r34':22,'lk2e':20,'lk2s':20}
    RD[k]=[list(map(list,segs)),float(cls.get(k,17))]
def fitline(Q):
    Q=np.array(Q,float); vx,vy,x0,y0=cv2.fitLine(Q.astype(np.float32),cv2.DIST_L2,0,.01,.01).ravel()
    u=np.array([vx,vy]); c=np.array([x0,y0]); t=(Q-c)@u
    return [list(c+u*t.min()), list(c+u*t.max())] if (Q[-1]-Q[0])@u>0 else [list(c+u*t.max()), list(c+u*t.min())]
STRAIGHT=['entry','blvd','west','east','r12','r34','lk2e','lk2s','t7','t8','t9','t11','t12','t13','t14']
for k in STRAIGHT:
    if k in RD: RD[k][0]=fitline(RD[k][0])
# đường vòng: đoạn cong đầu + đoạn thẳng chéo; SL5: đoạn cong đầu + thẳng tới cuối
P=RD['ring'][0]; i0=[i for i,p in enumerate(P) if p[0]>=1060][0]; RD['ring'][0]=P[:i0]+fitline(P[i0:])
P=RD['sl5'][0]; i0=[i for i,p in enumerate(P) if p[0]>=1140][0]; RD['sl5'][0]=P[:i0]+fitline(P[i0:])
def dense(P):
    P=np.array(P,float); o=[]
    for a,b in zip(P[:-1],P[1:]):
        n=int(np.hypot(*(b-a))//3)+1; o+= [a+(b-a)*t for t in np.linspace(0,1,n)]
    return np.array(o)
# nối đầu mút vào tim tuyến gần nhất (ngã ba khớp, không lòi đầu)
for k,(P,w) in RD.items():
    for e in (0,-1):
        p=np.array(P[e]); best=None
        for k2,(P2,w2) in RD.items():
            if k2==k: continue
            D=dense(P2); dd=np.hypot(*(D-p).T); i2=dd.argmin()
            if dd[i2]<max(w2,w)*1.2 and (best is None or dd[i2]<best[0]): best=(dd[i2],D[i2])
        if best is not None: P[e]=list(best[1])
for k,(P,w) in RD.items():
    d=smooth_d(P)
    curb.append(f'<path d="{d}" stroke-width="{w*S+2.4:.1f}"/>'); top.append(f'<path d="{d}" stroke-width="{w*S:.1f}"/>')
def csample(P,step):
    P=np.array(P,float); out=[]
    for k in range(len(P)-1):
        p0,p1,p2,p3=P[max(k-1,0)],P[k],P[k+1],P[min(k+2,len(P)-1)]
        c1=p1+(p2-p0)/6; c2=p2-(p3-p1)/6
        for t in np.linspace(0,1,40,endpoint=False):
            out.append((1-t)**3*p1+3*(1-t)**2*t*c1+3*(1-t)*t*t*c2+t**3*p2)
    out.append(P[-1]); out=np.array(out)
    L=np.r_[0,np.cumsum(np.hypot(*np.diff(out,axis=0).T))]
    ts=np.arange(step/2,L[-1],step); idx=np.searchsorted(L,ts)
    idx=np.clip(idx,1,len(out)-1); pts=out[idx]; tg=out[idx]-out[idx-1]; tg/=np.linalg.norm(tg,axis=1,keepdims=True)+1e-9
    return pts,np.c_[-tg[:,1],tg[:,0]]
RR=np.zeros((H,W),np.uint8)
for k,(P,w) in RD.items(): cv2.polylines(RR,[csample(P,3)[0].astype(np.int32)],False,255,int(w)+8)
bad=(cv2.dilate(LOTS,np.ones((13,13),np.uint8))>0)|(RR>0)|(WM>0)|(site==0)
trees=[]
for k in ('blvd','ring','sl5','hotel','east','west'):
    P,w=RD[k]; pts,nr=csample(P,24)
    for s in (1,-1):
        for p,n_ in zip(pts,nr):
            q=p+n_*s*(w/2+9); x,y=int(q[0]),int(q[1])
            if 0<=x<W and 0<=y<H and not bad[y,x]: trees.append(f'<circle cx="{q[0]*S:.1f}" cy="{q[1]*S:.1f}" r="2.6"/>')
TREE_SVG='<g fill="#7fb06f" stroke="#5f9152" stroke-width=".6">'+''.join(trees)+'</g>'
ROAD_SVG=('<g fill="none" stroke="#b9d7ad" stroke-linecap="round" stroke-linejoin="round">'+''.join(curb)+'</g>'
          '<g fill="none" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round">'+''.join(top)+'</g>')
vp=roads3.R['vcc'][0]
VCC_D='M'+' L'.join(f'{x*S:.1f} {y*S:.1f}' for x,y in vp)
for g,ps in groups.items():
    out.append(f'<path class="lot-{g}" d="{" ".join(ps)}" fill="{PAL[g]}"/>')
out.append(f'<path d="{" ".join(dividers)}" stroke="#ffffff" stroke-width=".9" opacity=".9"/>')
out.append(ROAD_SVG); out.append(TREE_SVG); open('v3.txt','w').write('\n'.join(out)); open('vcc.txt','w').write(VCC_D)
json.dump({g:[sum(x*a for x,y,a in v)/sum(a for *_,a in v), sum(y*a for x,y,a in v)/sum(a for *_,a in v)] for g,v in cents.items() if v},open('cents.json','w'))
print({g:len(v) for g,v in groups.items()}, 'KB',len('\n'.join(out))//1024, json.load(open('bbox.json')))
