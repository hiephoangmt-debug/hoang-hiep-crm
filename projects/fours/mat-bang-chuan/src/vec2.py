"""Vẽ lại mặt bằng tầng ở độ phân giải gốc bản CĐT.
- Tỷ lệ: đo tim tường căn mẫu (kích thước CĐT ghi trên bản 3D căn hộ), không dùng ước lượng diện tích.
- Tường/vách: nét đen đặc dày ≥ 8 cm. Kính: vạch xám ở mép ngoài. Cửa đi: cung 1/4 + cánh (nét mảnh).
- Căn hộ: vùng màu loại căn (đã lấp nét nội thất), giới hạn bởi tường.
Ra: JSON (mét), ảnh vẽ lại, ảnh chồng lên bản gốc."""
import sys, json, subprocess, math, numpy as np
from PIL import Image, ImageFilter, ImageDraw, ImageFont
Image.MAX_IMAGE_PIXELS=None
CC='/tmp/claude-0/-home-user-hoang-hiep-crm/04904dc5-f0d4-5f74-b258-32836a553812/scratchpad/plans/cc'
FB='/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'; FR='/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'
COL={'STU':(119,166,182),'1PN':(182,132,109),'1PN+':(51,126,34),'2PN':(252,184,23),'3PN':(240,109,79),'P':(155,130,195)}
def label(mask):
    H,W=mask.shape; r=subprocess.run([CC,str(W),str(H)],input=mask.astype(np.uint8).tobytes(),capture_output=True,check=True)
    return np.frombuffer(r.stdout,dtype=np.int32).reshape(H,W)
def mf(m,k,op):
    g=Image.fromarray((m*255).astype(np.uint8)); g=g.filter(ImageFilter.MaxFilter(k) if op=='d' else ImageFilter.MinFilter(k)); return np.asarray(g)>127
def big(M,kk,op,f=8):
    H,W=M.shape; sm=np.asarray(Image.fromarray((M*255).astype(np.uint8)).resize((W//f,H//f),Image.BOX))>127
    sm=mf(sm,max(3,(kk//f)|1),op); return np.asarray(Image.fromarray((sm*255).astype(np.uint8)).resize((W,H),Image.NEAREST))>127
def keep_big(M,n):
    L=label(M); c=np.bincount(L.ravel()); c[0]=0; return np.isin(L,np.nonzero(c>=n)[0])
def rects(M):
    H,W=M.shape; used=np.zeros_like(M); out=[]
    for y in range(H):
        xs=np.nonzero(M[y]&~used[y])[0]; i=0
        while i<len(xs):
            x=xs[i]
            if used[y,x]: i+=1; continue
            x2=x
            while x2+1<W and M[y,x2+1] and not used[y,x2+1]: x2+=1
            y2=y
            while y2+1<H and M[y2+1,x:x2+1].all() and not used[y2+1,x:x2+1].any(): y2+=1
            used[y:y2+1,x:x2+1]=True; out.append([int(x),int(y),int(x2+1),int(y2+1)])
            i=np.searchsorted(xs,x2+1)
    return out
def runs(a):
    if len(a)==0: return []
    out=[];s=a[0];p=a[0]
    for v in a[1:]:
        if v!=p+1: out.append((s,p)); s=v
        p=v
    out.append((s,p)); return out
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
    L=max(loops,key=len); return [(x-1,y-1) for x,y in L][:-1]
def dp(pts,eps):
    pts=np.array(pts,float)
    def rec(a,b):
        if b<=a+1: return [a]
        p,q=pts[a],pts[b]; d=q-p; n=np.hypot(*d) or 1
        seg=pts[a+1:b]; dist=np.abs(d[0]*(seg[:,1]-p[1])-d[1]*(seg[:,0]-p[0]))/n; i=int(dist.argmax())
        return rec(a,a+1+i)+rec(a+1+i,b) if dist[i]>eps else [a]
    P=np.vstack([pts,pts[:1]]); pts=P; m=int(np.hypot(*(P-P[0]).T).argmax())
    idx=rec(0,m)+rec(m,len(P)-1); return [pts[i].tolist() for i in idx]
def area(P): P=np.array(P); return abs(np.dot(P[:,0],np.roll(P[:,1],1))-np.dot(P[:,1],np.roll(P[:,0],1)))/2

def measure_scale(A, blk, box, L_mm, W_mm):
    """box: khung căn mẫu (px gốc). Đo khoảng cách tim 2 tường song song theo chiều ngắn (W_mm) và chiều dài (L_mm)."""
    x0,y0,x1,y1=box; pad=40
    sub=blk[y0-pad:y1+pad,x0-pad:x1+pad]
    res={}
    for axis in (0,1):   # 0: tường ngang (đo theo y), 1: tường dọc (đo theo x)
        prof=sub.mean(1-axis) if False else (sub.mean(1) if axis==0 else sub.mean(0))
        cand=[((a+b)/2,b-a+1,prof[a:b+1].mean()) for a,b in runs(np.nonzero(prof>0.45)[0]) if b-a+1>=8]
        res[axis]=cand
    def best(cands,target_px_range):
        best=None
        for i in range(len(cands)):
            for j in range(i+1,len(cands)):
                d=abs(cands[j][0]-cands[i][0])
                if target_px_range[0]<=d<=target_px_range[1]:
                    sc=cands[i][2]+cands[j][2]
                    if best is None or sc>best[0]: best=(sc,d)
        return best
    return res
def run(src,ujson,outj,title,mpp_full,codes_note=''):
    im=Image.open(src).convert('RGB'); A=np.asarray(im).astype(np.int16); H,W,_=A.shape
    U=json.load(open(ujson)); s0=W/2560.
    foot=[(p[0]*s0,p[1]*s0) for p in U['footPx']]
    fm=Image.new('L',(W,H),0); ImageDraw.Draw(fm).polygon(foot,fill=255); tower=np.asarray(fm)>127
    near=big(tower,121,'d')
    mx=A.max(2); mn=A.min(2); lum=A.sum(2)
    black=(lum<240)&((mx-mn)<30)&near
    wall=keep_big(mf(mf(black,5,'e'),5,'d'),200)          # nét ≥5 px (~9 cm)
    gray=((mx-mn)<16)&(lum>360)&(lum<660)&near&~mf(wall,3,'d')
    edge=big(tower,61,'d')&~big(tower,41,'e')
    glass=keep_big(mf(mf(gray&edge,5,'d'),5,'e'),300)
    # cửa đi: CĐT vẽ cung 1/4 (nét mảnh). Bỏ các nét thẳng dài (đồ đạc, khung) → còn lại cung; tâm cung = bản lề.
    Lg=im.convert('L'); bg=np.asarray(Lg.filter(ImageFilter.MaxFilter(9))).astype(np.int16); Lv=np.asarray(Lg).astype(np.int16)
    thin=(Lv<bg*0.62)&(bg>60)&tower&~mf(wall,3,'d')     # nét tối hơn nền xung quanh (mọi màu căn)
    # dò cửa: bản lề ở đầu đoạn tường, cung 1/4 bán kính 0,6–1,3 m quét ra phía hở
    Td=mf(thin,3,'d')
    WRc=rects(wall)
    rr=np.arange(int(0.6/mpp_full),int(1.3/mpp_full)+1)
    ang=np.radians(np.linspace(8,82,24))
    cand=[]
    for (x0,y0,x1,y1) in WRc:
        w=x1-x0; h=y1-y0
        if max(w,h)<10 or min(w,h)<4: continue
        if w>=h: ends=[(x1,1),(x0,-1)]; horiz=True
        else: ends=[(y1,1),(y0,-1)]; horiz=False
        for e,away in ends:
            for side in (-1,1):
                if horiz: hx=e; hy=(y0 if side<0 else y1)
                else: hy=e; hx=(x0 if side<0 else x1)
                best=None
                for r in rr:
                    if horiz: px=hx+away*r*np.cos(ang); py=hy+side*r*np.sin(ang)
                    else: py=hy+away*r*np.cos(ang); px=hx+side*r*np.sin(ang)
                    px=px.astype(int); py=py.astype(int)
                    ok=(px>=0)&(px<W)&(py>=0)&(py<H)
                    if not ok.all(): continue
                    cov=Td[py,px].mean()
                    if best is None or cov>best[0]: best=(cov,r)
                if best and best[0]>=.83:
                    r=best[1]
                    if horiz: closed=(hx+away*r,hy); leaf=(hx,hy+side*r)
                    else: closed=(hx,hy+away*r); leaf=(hx+side*r,hy)
                    cand.append((best[0],hx,hy,r,closed,leaf))
    cand.sort(key=lambda c:-c[0]); doors=[]
    for c in cand:
        if any(np.hypot(c[1]-d['h'][0],c[2]-d['h'][1])<c[3]*.5 or np.hypot((c[1]+c[4][0]+c[5][0])/3-(d['h'][0]+d['closed'][0]+d['leaf'][0])/3,(c[2]+c[4][1]+c[5][1])/3-(d['h'][1]+d['closed'][1]+d['leaf'][1])/3)<c[3]*.6 for d in doors): continue
        doors.append({'h':[float(c[1]),float(c[2])],'leaf':[float(c[5][0]),float(c[5][1])],'closed':[float(c[4][0]),float(c[4][1])],'r':float(c[3])})
    # căn hộ: vùng màu + lấp nét nội thất, giới hạn bằng tường
    units=[]
    for u in U['units']:
        P=[(p[0]*s0,p[1]*s0) for p in u['polyPx']]; xs_=[p[0] for p in P]; ys_=[p[1] for p in P]
        bx0,by0,bx1,by1=int(min(xs_))-30,int(min(ys_))-30,int(max(xs_))+31,int(max(ys_))+31
        sub=A[by0:by1,bx0:bx1]; c=np.array(COL.get(u['color'],(200,200,200)))
        cm=np.abs(sub-c).sum(2)<90
        pm=Image.new('L',(bx1-bx0,by1-by0),0); ImageDraw.Draw(pm).polygon([(p[0]-bx0,p[1]-by0) for p in P],fill=255); pm=np.asarray(pm)>127
        cm=cm&mf(pm,41,'d')
        M=mf(mf(cm,21,'d'),21,'e')&~wall[by0:by1,bx0:bx1]
        L=label(M); cnt=np.bincount(L.ravel()); cnt[0]=0
        if cnt.max()==0: continue
        M=L==cnt.argmax()
        poly=[[ (p[0]+bx0)*mpp_full, (p[1]+by0)*mpp_full] for p in dp(trace(M),3.0)]
        a=float(M.sum()*mpp_full**2)
        ys2,xs2=np.nonzero(M)
        units.append({'code':u['code'],'type':u.get('type'),'color':u['color'],'tt':u.get('tt'),'tim':u.get('tim'),'san':u.get('san'),
                      'poly':[[round(x,3),round(y,3)] for x,y in poly],'area':round(a,2),
                      'w':round((xs2.max()-xs2.min()+1)*mpp_full,2),'h':round((ys2.max()-ys2.min()+1)*mpp_full,2)})
    m=lambda v: round(float(v)*mpp_full,3)
    WR=rects(wall); GR=rects(glass)
    data={'title':title,'src':src.rsplit('/',1)[1],'mpp':mpp_full,'W':m(W),'H':m(H),
          'walls':[[m(a) for a in r] for r in WR],'glass':[[m(a) for a in r] for r in GR],
          'doors':[{k:([m(v[0]),m(v[1])] if isinstance(v,list) else m(v)) for k,v in d.items()} for d in doors],
          'units':units,'foot':[[m(p[0]),m(p[1])] for p in foot]}
    json.dump(data,open(outj,'w'),ensure_ascii=False,separators=(',',':'))
    # ảnh chồng: bản gốc nhạt + nét vẽ lại
    fx,fy=[p[0] for p in foot],[p[1] for p in foot]; cx0,cy0,cx1,cy1=int(min(fx))-150,int(min(fy))-150,int(max(fx))+150,int(max(fy))+150
    base=Image.blend(im,Image.new('RGB',im.size,'white'),.55).crop((cx0,cy0,cx1,cy1))
    d=ImageDraw.Draw(base,'RGBA')
    for r in WR: d.rectangle([r[0]-cx0,r[1]-cy0,r[2]-cx0-1,r[3]-cy0-1],fill=(225,0,45,170))
    for r in GR: d.rectangle([r[0]-cx0,r[1]-cy0,r[2]-cx0-1,r[3]-cy0-1],fill=(0,140,255,220))
    for dd in doors:
        hx,hy=dd['h'][0]-cx0,dd['h'][1]-cy0; rr=dd['r']; L2=(dd['leaf'][0]-cx0,dd['leaf'][1]-cy0); C2=(dd['closed'][0]-cx0,dd['closed'][1]-cy0)
        d.line([(hx,hy),L2],fill=(0,150,0,255),width=6)
        a1=math.degrees(math.atan2(L2[1]-hy,L2[0]-hx)); a2=math.degrees(math.atan2(C2[1]-hy,C2[0]-hx))
        if (a2-a1)%360>180: a1,a2=a2,a1
        d.arc([hx-rr,hy-rr,hx+rr,hy+rr],a1,a2,fill=(0,150,0,255),width=5)
    fU=ImageFont.truetype(FB,30); fS=ImageFont.truetype(FR,22)
    for u in units:
        P=[((x/mpp_full)-cx0,(y/mpp_full)-cy0) for x,y in u['poly']]
        d.line(P+[P[0]],fill=(120,0,200,255),width=3)
        cx=sum(p[0] for p in P)/len(P); cy=sum(p[1] for p in P)/len(P)
        dev=(u['area']/u['tt']-1)*100 if u.get('tt') else 0
        d.rectangle([cx-80,cy-30,cx+80,cy+40],fill=(255,255,255,215))
        d.text((cx-70,cy-28),u['code'],fill=(10,37,64,255),font=fU)
        d.text((cx-70,cy+8),'%.1f/%.1f m²'%(u['area'],u['tt'] or 0),fill=(200,60,0,255) if abs(dev)>4 else (0,110,40,255),font=fS)
    Wb,Hb=base.size; hdr=Image.new('RGB',(Wb,150),'white'); dh=ImageDraw.Draw(hdr)
    dh.text((30,14),title+' · CHỒNG BẢN VẼ LẠI LÊN BẢN GỐC CĐT',fill=(10,37,64),font=ImageFont.truetype(FB,44))
    dh.text((30,74),'Tỷ lệ %.3f cm/điểm ảnh (đo theo tim tường căn mẫu %s) · đỏ = tường/vách · xanh dương = kính · xanh lá = cửa đi · tím = đường bao căn (DT đo/DT CĐT)'%(mpp_full*100,codes_note),fill=(60,70,80),font=ImageFont.truetype(FR,26))
    dh.text((30,112),'Hình minh họa, thông số theo CĐT',fill=(200,60,0),font=ImageFont.truetype(FB,26))
    out=Image.new('RGB',(Wb,Hb+150),'white'); out.paste(hdr,(0,0)); out.paste(base,(0,150))
    out.save(outj.replace('.json','-overlay.jpg'),quality=86)
    # bản vẽ lại sạch
    rd=Image.new('RGB',(Wb,Hb),'white'); d2=ImageDraw.Draw(rd)
    TYPEC={'STU':'#cfe3ea','1PN':'#ecd9cf','1PN+':'#d6e8cb','2PN':'#fde9b8','3PN':'#f9d3c8','P':'#e3dcf2'}
    for u in units:
        P=[((x/mpp_full)-cx0,(y/mpp_full)-cy0) for x,y in u['poly']]; d2.polygon(P,fill=TYPEC.get(u['color'],'#eeeeee'))
    for r in GR: d2.rectangle([r[0]-cx0,r[1]-cy0,r[2]-cx0-1,r[3]-cy0-1],fill=(95,163,201))
    for r in WR: d2.rectangle([r[0]-cx0,r[1]-cy0,r[2]-cx0-1,r[3]-cy0-1],fill=(29,39,51))
    for dd in doors:
        hx,hy=dd['h'][0]-cx0,dd['h'][1]-cy0; rr=dd['r']; L2=(dd['leaf'][0]-cx0,dd['leaf'][1]-cy0); C2=(dd['closed'][0]-cx0,dd['closed'][1]-cy0)
        d2.line([(hx,hy),L2],fill=(70,80,92),width=4)
        a1=math.degrees(math.atan2(L2[1]-hy,L2[0]-hx)); a2=math.degrees(math.atan2(C2[1]-hy,C2[0]-hx))
        if (a2-a1)%360>180: a1,a2=a2,a1
        d2.arc([hx-rr,hy-rr,hx+rr,hy+rr],a1,a2,fill=(120,130,140),width=2)
    for u in units:
        P=[((x/mpp_full)-cx0,(y/mpp_full)-cy0) for x,y in u['poly']]; cx=sum(p[0] for p in P)/len(P); cy=sum(p[1] for p in P)/len(P)
        d2.text((cx-40,cy-20),u['code'],fill=(10,37,64),font=fU)
    rd2=Image.new('RGB',(Wb,Hb+150),'white'); rd2.paste(hdr,(0,0)); rd2.paste(rd,(0,150)); ImageDraw.Draw(rd2).rectangle([0,0,Wb,150],fill='white')
    dh2=ImageDraw.Draw(rd2); dh2.text((30,14),title+' · MẶT BẰNG VẼ LẠI',fill=(10,37,64),font=ImageFont.truetype(FB,44)); dh2.text((30,74),'Hình minh họa, thông số theo CĐT',fill=(200,60,0),font=ImageFont.truetype(FB,26))
    rd2.save(outj.replace('.json','-redraw.png'))
    return data
if __name__=='__main__':
    src,uj,outj,title,mpp,note=sys.argv[1:7]
    d=run(src,uj,outj,title,float(mpp),note)
    ok=sum(1 for u in d['units'] if u.get('tt') and abs(u['area']/u['tt']-1)<=.04)
    print(outj.rsplit('/',1)[1],'walls',len(d['walls']),'glass',len(d['glass']),'doors',len(d['doors']),'units',len(d['units']),'DT khớp ±4%:',ok)
