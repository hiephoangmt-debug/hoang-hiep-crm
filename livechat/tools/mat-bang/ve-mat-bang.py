import cv2, numpy as np, math
im=cv2.imread('ref.png')[:,:,::-1].astype(int)
H,W,_=im.shape
yy,xx=np.mgrid[0:H,0:W]
def near(c,t): return (np.sqrt(((im-np.array(c))**2).sum(-1))<t).astype(np.uint8)*255
S=0.5
def P(pts): return ' '.join(f'{x*S:.1f},{y*S:.1f}' for x,y in pts)
area=((xx>330)&(yy>140)&(yy<1340)).astype(np.uint8); area[(xx<420)&(yy>650)]=0
leftroad=(xx < 370 + (yy-520)*(185/780)) | ((yy<520)&(xx<370))
out=[]
def polys(m,eps,minA,fill,extra=''):
    cs,hier=cv2.findContours(m,cv2.RETR_CCOMP,cv2.CHAIN_APPROX_SIMPLE)
    if hier is None: return
    d=[]
    for i,c in enumerate(cs):
        if abs(cv2.contourArea(c))<minA: continue
        a=cv2.approxPolyDP(c,eps,True)[:,0]
        if len(a)<3: continue
        d.append('M'+' L'.join(f'{x*S:.1f} {y*S:.1f}' for x,y in a)+'Z')
    if d: out.append(f'<path d="{" ".join(d)}" fill="{fill}" fill-rule="evenodd"{extra}/>')
# --- nền khu đất ---
nonwhite=(np.sqrt(((im-255)**2).sum(-1))>40).astype(np.uint8)*255
nonwhite[(xx<330)|(yy<140)|(yy>1340)]=0; nonwhite[(xx<420)&(yy>650)]=0; nonwhite[leftroad]=0
roadV=near((99,102,124),28); roadV[xx>640]=0
site=cv2.morphologyEx(cv2.bitwise_and(nonwhite,255-roadV),cv2.MORPH_CLOSE,np.ones((25,25),np.uint8))
cs,_=cv2.findContours(site,cv2.RETR_EXTERNAL,cv2.CHAIN_APPROX_SIMPLE)
c=max(cs,key=cv2.contourArea); c=cv2.approxPolyDP(c,3,True)[:,0]
out.append(f'<polygon points="{P(c)}" fill="#c4e2b8" stroke="#a9cf9c" stroke-width="1.5"/>')
sitemask=np.zeros((H,W),np.uint8); cv2.fillPoly(sitemask,[c.reshape(-1,1,2)],255)
# --- cây xanh ---
tree=near((92,124,80),36)&sitemask
tree=cv2.morphologyEx(tree,cv2.MORPH_CLOSE,np.ones((13,13),np.uint8)); tree=cv2.morphologyEx(tree,cv2.MORPH_OPEN,np.ones((9,9),np.uint8))
tree=cv2.GaussianBlur(tree,(0,0),5); tree=(tree>140).astype(np.uint8)*255
polys(tree,3,2500,'#aed69f')
forest=tree.copy(); forest[xx<1480]=0
forest=cv2.morphologyEx(forest,cv2.MORPH_CLOSE,np.ones((35,35),np.uint8))
polys(forest,4,20000,'#7fb47a')
# --- đường nội khu (xám) ---
g=im; r,gg,b=g[:,:,0],g[:,:,1],g[:,:,2]
road=(((abs(r-gg)<14)&(b>=gg-4)&(r>95)&(r<190)&(b<205)).astype(np.uint8)*255)&sitemask
pass  # đường nội khu vẽ tay trong final.svg
# --- nước, hồ ---
water=near((40,150,170),70)&sitemask
water=cv2.morphologyEx(water,cv2.MORPH_CLOSE,np.ones((9,9),np.uint8)); water=cv2.morphologyEx(water,cv2.MORPH_OPEN,np.ones((5,5),np.uint8))
polys(water,2,1500,'#9fd6ec')
lake=near((205,235,232),24)&sitemask; lake[(xx<1050)|(xx>1300)|(yy<650)|(yy>880)]=0
lake=cv2.morphologyEx(lake,cv2.MORPH_CLOSE,np.ones((11,11),np.uint8))
polys(lake,2,1500,'#bdebf0')
# --- căn nhà: tách từng căn ---
ph=near((195,27,106),60)
def units(m,color,er,minA,cls):
    m=cv2.morphologyEx(m&sitemask,cv2.MORPH_OPEN,np.ones((3,3),np.uint8))
    e=cv2.erode(m,np.ones((er*2+1,er*2+1),np.uint8))
    n,lab,st,cen=cv2.connectedComponentsWithStats(e)
    ars=sorted([st[i,4] for i in range(1,n) if st[i,4]>=minA]); med=ars[len(ars)//2]
    g=[f'<g class="{cls}" fill="{color}">']; cnt=0
    for i in range(1,n):
        if st[i,4]<max(minA,med*0.3): continue
        ys,xs=np.where(lab==i); pts=np.stack([xs,ys],1).astype(np.float32)
        (cx,cy),(w,h),ang=cv2.minAreaRect(pts)
        w+=2*er+1.2; h+=2*er+1.2
        if w<h: w,h,ang=h,w,ang+90
        k=max(1,round(st[i,4]/med)) if st[i,4]>med*1.7 else 1
        ux,uy=math.cos(math.radians(ang)),math.sin(math.radians(ang))
        # căn dính nhau: chia theo cạnh dài
        for j in range(k):
            t=-w/2+w*(j+.5)/k; px,py=cx+ux*t,cy+uy*t
            box=cv2.boxPoints(((px,py),(w/k-1.6,h-1.2),ang))
            g.append(f'<polygon points="{P(box)}"/>'); cnt+=1
    g.append('</g>'); out.extend(g); return cnt
fs=near((192,193,172),24); fs[(xx<1000)|(yy>760)]=0; fs[(xx<1120)&(yy>640)]=0
ws=near((112,111,91),30); ws[(xx<1120)|(yy<820)]=0
lk=near((138,134,103),26); lk[(xx>1060)|(yy<620)|(yy>1100)]=0; lk[ph>0]=0
pv=near((236,110,165),45)
print('LK',units(lk,'#a7865f',1,60,'u-lk'))
def rows(mask,color,minA,unitLen,close,cls):
    m=cv2.morphologyEx(mask&sitemask,cv2.MORPH_CLOSE,np.ones((close,close),np.uint8))
    m=cv2.morphologyEx(m,cv2.MORPH_OPEN,np.ones((3,3),np.uint8))
    cs,_=cv2.findContours(m,cv2.RETR_EXTERNAL,cv2.CHAIN_APPROX_SIMPLE)
    g=[f'<g class="{cls}" fill="{color}">']; n=0
    for c in cs:
        if cv2.contourArea(c)<minA: continue
        (cx,cy),(w,h),ang=cv2.minAreaRect(c)
        if w<h: w,h,ang=h,w,ang+90
        k=max(1,round(w/unitLen)); ux,uy=math.cos(math.radians(ang)),math.sin(math.radians(ang))
        for j in range(k):
            t=-w/2+w*(j+.5)/k; px,py=cx+ux*t,cy+uy*t
            box=cv2.boxPoints(((px,py),(w/k-1.8,h-1.5),ang))
            g.append(f'<polygon points="{P(box)}"/>'); n+=1
    g.append('</g>'); out.extend(g); return n
print('PH',rows(ph,'#c8197a',800,22,3,'u-ph'))
print('PV',rows(pv,'#f07fb4',800,24,5,'u-pv'))
print('FS',units(fs,'#0b2a5b',1,80,'u-fs'))
print('WS',units(ws,'#4f78b0',1,80,'u-ws'))
open('v2.txt','w').write('\n'.join(out))
print('KB',len('\n'.join(out))//1024)
