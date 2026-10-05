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
site=cv2.GaussianBlur(site,(0,0),4); site=(site>128).astype(np.uint8)*255
out.append(f'<path d="{path(site,2,5000,False)}" fill="#c6e3ba" stroke="#a9cf9c" stroke-width="1.2"/>')
x0,y0,w0,h0=cv2.boundingRect(site); json.dump([x0*S,y0*S,w0*S,h0*S],open('bbox.json','w'))
# ---- rừng dừa ----
forest=near((70,141,75),36)&site; forest[xx<1500]=0
forest=cv2.morphologyEx(forest,cv2.MORPH_CLOSE,np.ones((61,61),np.uint8)); forest=cv2.morphologyEx(forest,cv2.MORPH_OPEN,np.ones((21,21),np.uint8))
out.append(f'<path d="{path(forest,3,15000,False)}" fill="#7fb47a"/>')
# ---- nước ----
w=(water|lake)&site; w[legend]=0
w=cv2.morphologyEx(w,cv2.MORPH_CLOSE,np.ones((13,13),np.uint8)); w=cv2.morphologyEx(w,cv2.MORPH_OPEN,np.ones((7,7),np.uint8))
cv2.circle(w,(1172,722),88,0,-1); w=cv2.GaussianBlur(w,(0,0),2.5); w=(w>128).astype(np.uint8)*255
out.append(f'<path d="{path(w,1.5,1500)}" fill="#9fd6ec" fill-rule="evenodd"/>')
lk=lake&site; lk=cv2.morphologyEx(lk,cv2.MORPH_CLOSE,np.ones((15,15),np.uint8)); lk=cv2.morphologyEx(lk,cv2.MORPH_OPEN,np.ones((7,7),np.uint8))
cs,_=cv2.findContours(lk,cv2.RETR_EXTERNAL,cv2.CHAIN_APPROX_NONE); c=max(cs,key=cv2.contourArea); (lx,ly),lr=cv2.minEnclosingCircle(c); lx,ly,lr=1172,722,74
out.append(f'<circle cx="{lx*S:.1f}" cy="{ly*S:.1f}" r="{lr*S*.95:.1f}" fill="#c3eef2" stroke="#fff" stroke-width="2"/><circle cx="{lx*S:.1f}" cy="{ly*S:.1f}" r="{lr*S*.95+7:.1f}" fill="none" stroke="#dfe6dc" stroke-width="6"/>')
print('lake',lx,ly,lr)
# ---- lô đất ----
PAL={'ph':'#c8197a','pv':'#f07fb4','lk':'#a7865f','fs':'#0b2a5b','ws':'#4f78b0'}
groups={k:[] for k in PAL}; dividers=[]; cents={k:[] for k in PAL}; LOTS=np.zeros((H,W),np.uint8)
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
            box=cv2.boxPoints(((rx,ry),(rw-1,rh-1),ang)); cv2.fillPoly(LOTS,[box.astype(np.int32)],255)
            groups[g].append('M'+' L'.join(f'{x*S:.1f} {y*S:.1f}' for x,y in box)+'Z')
            # đếm lô theo dải sáng dọc trục dài
            ux,uy=np.cos(np.radians(ang)),np.sin(np.radians(ang)); vx,vy=-uy,ux
            prof=[]
            for t in np.linspace(-rw/2+2,rw/2-2,int(rw)):
                vals=[]
                for q in np.linspace(-rh/2+3,rh/2-3,7):
                    px,py=int(rx+ux*t+vx*q),int(ry+uy*t+vy*q)
                    if 0<=px<W and 0<=py<H: vals.append(im[py,px].sum())
                prof.append(np.mean(vals) if vals else 0)
            prof=np.array(prof); thr=np.percentile(prof,90)
            peaks=0; inpk=False
            for v in prof:
                if v>=thr and not inpk: peaks+=1; inpk=True
                elif v<thr: inpk=False
            unitW={'ph':17,'pv':17,'lk':16,'fs':21,'ws':21}[g]
            kU=max(2,round(rw/unitW))
            for j in range(1,kU):
                t=-rw/2+rw*j/kU; px,py=rx+ux*t,ry+uy*t
                x1,y1=px+vx*(rh/2-1),py+vy*(rh/2-1); x2,y2=px-vx*(rh/2-1),py-vy*(rh/2-1)
                dividers.append(f'M{x1*S:.1f} {y1*S:.1f} L{x2*S:.1f} {y2*S:.1f}')
        else:
            a2=cv2.approxPolyDP(c,2.5,True)[:,0]; cv2.fillPoly(LOTS,[a2.astype(np.int32)],255)
            groups[g].append('M'+' L'.join(f'{x*S:.1f} {y*S:.1f}' for x,y in a2)+'Z')
        cents[g].append((cx*S,cy*S,A))
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
# ---- đường (vẽ tay theo tim đường, bề rộng đều) ----
import roads3
rm=np.zeros((H,W),np.uint8)
for k,(pts,wd) in roads3.R.items():
    if k=='vcc': continue
    cv2.polylines(rm,[np.array(pts,np.int32)],False,255,wd,cv2.LINE_AA)
rm=(rm>128).astype(np.uint8)*255
rm[cv2.dilate(LOTS,np.ones((7,7),np.uint8))>0]=0
rm=cv2.morphologyEx(rm,cv2.MORPH_OPEN,np.ones((5,5),np.uint8))
rm=cv2.GaussianBlur(rm,(0,0),1.5); rm=(rm>128).astype(np.uint8)*255
ROAD_SVG=f'<path class="rd" d="{path(rm,1.0,300)}" fill="#ffffff" stroke="#c3ccd8" stroke-width=".9" fill-rule="evenodd"/>'
vp=roads3.R['vcc'][0]
VCC_D='M'+' L'.join(f'{x*S:.1f} {y*S:.1f}' for x,y in vp)
out.append(ROAD_SVG)
for g,ps in groups.items():
    out.append(f'<path class="lot-{g}" d="{" ".join(ps)}" fill="{PAL[g]}"/>')
out.append(f'<path d="{" ".join(dividers)}" stroke="#ffffff" stroke-width=".9" opacity=".9"/>')
open('v3.txt','w').write('\n'.join(out)); open('vcc.txt','w').write(VCC_D)
json.dump({g:[sum(x*a for x,y,a in v)/sum(a for *_,a in v), sum(y*a for x,y,a in v)/sum(a for *_,a in v)] for g,v in cents.items() if v},open('cents.json','w'))
print({g:len(v) for g,v in groups.items()}, 'KB',len('\n'.join(out))//1024, json.load(open('bbox.json')))
