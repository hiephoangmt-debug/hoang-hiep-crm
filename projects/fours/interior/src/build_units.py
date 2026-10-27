"""Sinh dữ liệu nội thất cho mọi căn của 1 tòa (tầng điển hình): phòng, tường (từ ảnh CĐT), kính, nội thất theo quy tắc.
Toạ độ mét gốc = góc trên-trái khung cắt căn; x phải, y xuống theo bản vẽ."""
import sys, json, numpy as np
sys.path.insert(0, sys.argv[0].rsplit('/',1)[0])
TOWER=sys.argv[1]; SEGDIR=sys.argv[2]; OUTJ=sys.argv[3]; MPP=float(sys.argv[4]); UPBRG=float(sys.argv[5]); FOOTJ=sys.argv[6]; DST=sys.argv[7]
seg=json.load(open(SEGDIR+'/rooms.json')); out=json.load(open(OUTJ))
units={u['code']:u for u in out['units']}
foot=np.array(out['footPx'],float)
def trace(M):
    H,W=M.shape; P=np.zeros((H+2,W+2),bool); P[1:-1,1:-1]=M; E=[]
    a=P[1:,:]&~P[:-1,:]; ys,xs=np.nonzero(a); E+=[((x+1,y+1),(x,y+1)) for y,x in zip(ys,xs)]
    a=P[:-1,:]&~P[1:,:]; ys,xs=np.nonzero(a); E+=[((x,y+1),(x+1,y+1)) for y,x in zip(ys,xs)]
    a=P[:,1:]&~P[:,:-1]; ys,xs=np.nonzero(a); E+=[((x+1,y),(x+1,y+1)) for y,x in zip(ys,xs)]
    a=P[:,:-1]&~P[:,1:]; ys,xs=np.nonzero(a); E+=[((x+1,y+1),(x+1,y)) for y,x in zip(ys,xs)]
    from collections import defaultdict
    nx=defaultdict(list)
    for s,e in E: nx[s].append(e)
    used=set(); loops=[]
    for s0 in list(nx):
        for e0 in nx[s0]:
            if (s0,e0) in used: continue
            L=[s0]; s,e=s0,e0
            while (s,e) not in used:
                used.add((s,e)); L.append(e); c=[q for q in nx[e] if (e,q) not in used]
                if not c: break
                s,e=e,c[0]
            loops.append(L)
    L=max(loops,key=len); return [(x-1,y-1) for x,y in L]
def dp(pts,eps):
    pts=np.array(pts,float)
    def rec(a,b):
        if b<=a+1: return [a]
        p,q=pts[a],pts[b]; d=q-p; n=np.hypot(*d) or 1
        seg=pts[a+1:b]; dist=np.abs(d[0]*(seg[:,1]-p[1])-d[1]*(seg[:,0]-p[0]))/n; i=int(dist.argmax())
        return rec(a,a+1+i)+rec(a+1+i,b) if dist[i]>eps else [a]
    m=int(np.hypot(*(pts-pts[0]).T).argmax()); idx=rec(0,m)+rec(m,len(pts)-1); return [pts[i].tolist() for i in idx]
def rects(M):
    """gộp ô True thành hình chữ nhật (quét hàng + nối dọc)"""
    H,W=M.shape; used=np.zeros_like(M); out=[]
    for y in range(H):
        x=0
        while x<W:
            if M[y,x] and not used[y,x]:
                x2=x
                while x2+1<W and M[y,x2+1] and not used[y,x2+1]: x2+=1
                y2=y
                while y2+1<H and M[y2+1,x:x2+1].all() and not used[y2+1,x:x2+1].any(): y2+=1
                used[y:y2+1,x:x2+1]=True; out.append([x,y,x2+1,y2+1]); x=x2+1
            else: x+=1
    return out
def inpoly(x,y,P):
    c=False; n=len(P); j=n-1
    for i in range(n):
        if ((P[i][1]>y)!=(P[j][1]>y)) and (x<(P[j][0]-P[i][0])*(y-P[i][1])/(P[j][1]-P[i][1])+P[i][0]): c=not c
        j=i
    return c
def run_unit(code):
    z=np.load(f'{SEGDIR}/{code}.npz'); lab=z['lab']; wall=z['wall']; env=z['env']; bx=z['box']; x0,y0=int(bx[0]),int(bx[1])
    u=units[code]; m=lambda v: round(float(v)*MPP,3)
    # khung cắt quanh căn → mét (gốc = góc khung)
    H,W=lab.shape
    # tường: chỉ phần sát căn (trong vùng căn nới 0,35 m)
    from PIL import Image, ImageDraw, ImageFilter
    pm=Image.new('L',(W,H),0); ImageDraw.Draw(pm).polygon([(p[0]-x0,p[1]-y0) for p in u['polyPx']],fill=255)
    near=np.asarray(pm.filter(ImageFilter.MaxFilter(17)))>127
    wl=wall&near
    # bỏ nét lẻ quá nhỏ
    W_R=[[m(r[0]),m(r[1]),m(r[2]),m(r[3])] for r in rects(wl)]
    W_R=[r for r in W_R if (r[2]-r[0])*(r[3]-r[1])>0.0004]
    # ngoài nhà: điểm ngoài đường bao tòa
    fpx=[(p[0]-x0,p[1]-y0) for p in foot]
    rooms=[]
    for k in [int(k) for k in np.unique(lab) if k]:
        M=lab==k; A=M.sum()*MPP*MPP
        if A<1.2: continue
        P=dp(trace(M),2.2); yy,xx=np.nonzero(M)
        bb=[m(xx.min()),m(yy.min()),m(xx.max()+1),m(yy.max()+1)]
        # cạnh nào giáp ngoài nhà (quét 0,5 m ra ngoài khung phòng)
        ext={}
        for side in 'TBLR':
            cnt=0; tot=0
            for t in np.linspace(0.15,0.85,9):
                if side in 'TB': px=xx.min()+(xx.max()-xx.min())*t; py=(yy.min()-14) if side=='T' else (yy.max()+14)
                else: py=yy.min()+(yy.max()-yy.min())*t; px=(xx.min()-14) if side=='L' else (xx.max()+14)
                tot+=1; cnt+=0 if inpoly(px,py,fpx) else 1
            ext[side]=cnt/tot
        rooms.append({'k':k,'A':round(A,2),'poly':[[m(p[0]),m(p[1])] for p in P],'bb':bb,'ext':ext,'mask':M})
    rooms.sort(key=lambda r:-r['A'])
    return {'x0':x0,'y0':y0,'W':W,'H':H,'walls':W_R,'rooms':rooms,'unit':u}
res={c:run_unit(c) for c in seg}
import pickle; pickle.dump(res,open(DST,'wb'))
for c,r in res.items(): print(c, r['unit']['type'], [ (x['A'], ''.join(s for s,v in x['ext'].items() if v>.5)) for x in r['rooms']], 'walls',len(r['walls']))
