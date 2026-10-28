"""Trích xuất mặt bằng tầng chính xác từ ảnh CĐT: căn hộ (đường bao theo màu), đường bao tòa, sân vườn; quy đổi mét theo diện tích thông thủy."""
import sys, json, subprocess, numpy as np
from PIL import Image, ImageFilter
HERE=sys.argv[0].rsplit('/',1)[0]; CC=HERE+'/cc'
COL={'STU':(119,166,182),'1PN':(182,132,109),'1PN+':(64,108,49),'2PN':(252,184,23),'3PN':(240,109,79),'P':(155,130,195)}
GARDEN=(216,236,167)
def label(mask):
    H,W=mask.shape; r=subprocess.run([CC,str(W),str(H)],input=mask.astype(np.uint8).tobytes(),capture_output=True,check=True)
    return np.frombuffer(r.stdout,dtype=np.int32).reshape(H,W)
def morph(m,ops):
    g=Image.fromarray((m*255).astype(np.uint8),'L')
    for op,k in ops: g=g.filter(ImageFilter.MaxFilter(k) if op=='d' else ImageFilter.MinFilter(k))
    return np.asarray(g)>127
def trace(M):
    """Đường bao ngoài của vùng (theo cạnh điểm ảnh), trả về danh sách đỉnh (x,y) đã đơn giản hoá."""
    H,W=M.shape; P=np.zeros((H+2,W+2),bool); P[1:-1,1:-1]=M
    nxt={}
    # cạnh ngang/dọc giữa trong-ngoài, hướng sao cho vùng nằm bên trái
    ys,xs=np.nonzero(P[1:,:]&~P[:-1,:])   # trên là ngoài, dưới là trong: cạnh tại y (giữa hàng y và y+1) đi từ phải sang trái
    for y,x in zip(ys,xs): nxt[(x,y+1)]=(x-1,y+1) if False else None
    nxt={}
    E=[]
    a=P[1:,:]&~P[:-1,:]; ys,xs=np.nonzero(a)
    for y,x in zip(ys,xs): E.append(((x+1,y+1),(x,y+1)))      # mép trên của ô (x,y+1): đi trái
    a=P[:-1,:]&~P[1:,:]; ys,xs=np.nonzero(a)
    for y,x in zip(ys,xs): E.append(((x,y+1),(x+1,y+1)))      # mép dưới của ô (x,y): đi phải
    a=P[:,1:]&~P[:,:-1]; ys,xs=np.nonzero(a)
    for y,x in zip(ys,xs): E.append(((x+1,y),(x+1,y+1)))      # mép trái của ô (x+1,y): đi xuống
    a=P[:,:-1]&~P[:,1:]; ys,xs=np.nonzero(a)
    for y,x in zip(ys,xs): E.append(((x+1,y+1),(x+1,y)))      # mép phải của ô (x,y): đi lên
    from collections import defaultdict
    out=defaultdict(list)
    for s,e in E: out[s].append(e)
    used=set(); loops=[]
    for s0 in list(out):
        for e0 in out[s0]:
            if (s0,e0) in used: continue
            loop=[s0]; s,e=s0,e0
            while (s,e) not in used:
                used.add((s,e)); loop.append(e)
                cand=[c for c in out[e] if (e,c) not in used]
                if not cand: break
                s,e=e,cand[0]
            loops.append(loop)
    L=max(loops,key=len); L=[(x-1,y-1) for x,y in L][:-1]; i0=min(range(len(L)),key=lambda i:L[i][0]+L[i][1]); L=L[i0:]+L[:i0]+[L[i0]]
    return dp(L,2.0)
def trace_raw(M):
    global dp
    _dp=dp; dp=lambda L,e: L
    try: return trace(M)
    finally: dp=_dp
def dp_closed(L,e): return dp(L,e)
def dp(pts,eps):
    pts=np.array(pts,float)
    def rec(a,b):
        if b<=a+1: return [a]
        p,q=pts[a],pts[b]; d=q-p; n=np.hypot(*d) or 1
        seg=pts[a+1:b]; dist=np.abs(d[0]*(seg[:,1]-p[1])-d[1]*(seg[:,0]-p[0]))/n
        i=int(dist.argmax()); 
        if dist[i]>eps: return rec(a,a+1+i)+rec(a+1+i,b)
        return [a]
    if np.allclose(pts[0],pts[-1]):   # vòng kín: tách tại điểm xa nhất
        m=int(np.hypot(*(pts-pts[0]).T).argmax()); idx=rec(0,m)+rec(m,len(pts)-1)
    else: idx=rec(0,len(pts)-1)
    return [[round(float(pts[i][0]),1),round(float(pts[i][1]),1)] for i in idx]
def run(path, codes, data, tol=40):
    im=np.asarray(Image.open(path).convert('RGB')).astype(int); H,W,_=im.shape; s=W/2000.
    pal=np.array(list(COL.values())+[(255,255,255),(30,30,30),GARDEN,(60,60,60),(95,95,95),(135,135,135),(175,175,175)])
    dist=np.stack([np.abs(im-c).sum(2) for c in pal]); near=dist.argmin(0); dmin=dist.min(0)
    regs=[]
    for ti,t in enumerate(COL):
        m=(near==ti)&(dmin<tol*3); m=morph(m,[('d',5),('e',5),('e',3),('d',3)])
        L=label(m); cnt=np.bincount(L.ravel())
        for k in np.nonzero(cnt>=9000)[0]:
            if k==0: continue
            M=L==k; yy,xx=np.nonzero(M); regs.append({'t':t,'px':int(cnt[k]),'c':(xx.mean()/s,yy.mean()/s),'M':M,'bb':(xx.min(),yy.min(),xx.max(),yy.max())})
    units=[]
    for code,(cx,cy) in codes.items():
        best=min(regs,key=lambda r:np.hypot(r['c'][0]-cx,r['c'][1]-cy)); d=np.hypot(best['c'][0]-cx,best['c'][1]-cy)
        if d>60: print('!! không thấy',code,round(d),file=sys.stderr); continue
        if best.get('code'): print('!! trùng',code,best['code'],file=sys.stderr)
        best['code']=code; units.append(best)
    # tỷ lệ: diện tích thông thủy / số điểm ảnh tô màu (trung vị)
    k=[np.sqrt(data[u['code']]['tt']/u['px']) for u in units if u['code'] in data]
    mpp=float(np.median(k)); dev=[round((x/mpp-1)*100,1) for x in k]
    # đường bao tòa: phần không thông ra ngoài qua vùng sáng (trắng, sân vườn)
    light=(im.min(2)>200)|((near==len(COL)+2)&(dmin<90))
    Lt=label(light); border=set(np.unique(np.concatenate([Lt[0],Lt[-1],Lt[:,0],Lt[:,-1]])))
    ext=np.isin(Lt,list(border-{0}))
    gmask=(near==len(COL)+2)&(dmin<90)
    bld=morph(~ext&~gmask,[('e',9),('d',9)]); Lb=label(bld); cnt=np.bincount(Lb.ravel()); cnt[0]=0; bld=Lb==cnt.argmax()
    # lấp lỗ trong
    Lh=label(~bld); bo=set(np.unique(np.concatenate([Lh[0],Lh[-1],Lh[:,0],Lh[:,-1]])))-{0}; bld=np.isin(Lh,list(bo),invert=True)|bld; bld=~np.isin(Lh,list(bo))
    yy,xx=np.nonzero(bld); x0,y0=xx.min(),yy.min()
    foot=trace(bld)
    # sân vườn (màu xanh nhạt) sát tòa
    g=(near==len(COL)+2)&(dmin<90); g=morph(g,[('d',3),('e',3)]); Lg=label(g); cg=np.bincount(Lg.ravel()); gardens=[]
    near_b=morph(bld,[('d',41)])
    for kk in np.nonzero(cg>4000)[0]:
        if kk==0: continue
        Mg=Lg==kk
        if (Mg&near_b).sum()<200: continue
        gardens.append(trace(Mg))
    def tom(P): return [[round((p[0]-x0)*mpp,2),round((p[1]-y0)*mpp,2)] for p in P]
    out={'img':path.rsplit('/',1)[1],'W':W,'H':H,'mpp':round(mpp,5),'scaleDevPct':dev,'origin':[int(x0),int(y0)],
         'size':[round((xx.max()-x0+1)*mpp,2),round((yy.max()-y0+1)*mpp,2)],'foot':tom(foot),'footPx':foot,'gardens':[tom(G) for G in gardens],'gardensPx':gardens,'units':[]}
    for u in units:
        y0_,x0_=max(0,u['bb'][1]-30),max(0,u['bb'][0]-30); sub=u['M'][y0_:u['bb'][3]+31,x0_:u['bb'][2]+31]
        sub=morph(sub,[('d',17),('e',17)])
        poly=[[p[0]+x0_,p[1]+y0_] for p in dp_closed(trace_raw(sub),5.0)]; d=data.get(u['code'],{})
        out['units'].append({'code':u['code'],'color':u['t'],'px':u['px'],'polyPx':poly,'poly':tom(poly),'areaPx_m2':round(u['px']*mpp*mpp,2),**d})
    return out
if __name__=='__main__':
    job=json.load(open(sys.argv[1])); r=run(job['img'],job['codes'],job['data']); json.dump(r,open(sys.argv[2],'w'),ensure_ascii=False)
    print(sys.argv[2],'units',len(r['units']),'m/px',r['mpp'],'size',r['size'],'gardens',len(r['gardens']),'dev%',r['scaleDevPct'])
