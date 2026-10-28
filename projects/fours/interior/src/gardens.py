"""Chia vùng sân vườn (màu xanh nhạt trên bản vẽ CĐT) cho từng căn: lan nhãn căn ra vùng sân, cắt theo nét chia sân. Ra json: mã căn → danh sách đa giác (px ảnh)."""
import sys, json, subprocess, numpy as np
from PIL import Image, ImageDraw, ImageFilter
CC='/tmp/claude-0/-home-user-hoang-hiep-crm/04904dc5-f0d4-5f74-b258-32836a553812/scratchpad/plans/cc'
sys.path.insert(0,'/nonexistent')
def label(mask):
    H,W=mask.shape; r=subprocess.run([CC,str(W),str(H)],input=mask.astype(np.uint8).tobytes(),capture_output=True,check=True)
    return np.frombuffer(r.stdout,dtype=np.int32).reshape(H,W)
img,outj,dst=sys.argv[1],sys.argv[2],sys.argv[3]
im=np.asarray(Image.open(img).convert('RGB')).astype(int); H,W,_=im.shape
d=json.load(open(outj))
g=np.abs(im-np.array((216,236,167))).sum(2)<70          # nền cỏ
lines=im.sum(2)<450                                      # nét chia sân (đậm/xám)
garden=g.copy()
# nhãn căn
U=Image.new('I',(W,H),0); dr=ImageDraw.Draw(U)
codes=[u['code'] for u in d['units']]
for i,u in enumerate(d['units']): dr.polygon([tuple(p) for p in u['polyPx']],fill=i+1)
lab=np.asarray(U).astype(np.int32)
# nhãn căn nới ra lô gia / tường (không phải cỏ) ~1,6 m để chạm tới ô sân
ext=lab.copy(); nong=~g
for it in range(40):
    for dy,dx in((1,0),(-1,0),(0,1),(0,-1)):
        sh=np.roll(ext,(dy,dx),(0,1)); m=(ext==0)&nong&(sh>0); ext[m]=sh[m]
L0=label(g); cnt0=np.bincount(L0.ravel()); cnt0[0]=0
cur=np.zeros_like(lab)
A2=0.0406**2
job=json.load(open(sys.argv[4])) if len(sys.argv)>4 else {'data':{}}
target={c:(job['data'].get(c,{}).get('san') or 0) for c in codes}
got={c:0.0 for c in codes}
UB=[np.array(u['polyPx']) for u in d['units']]
cells=[]
for k in np.nonzero(cnt0>800)[0]:
    C=L0==k
    er=np.asarray(Image.fromarray((C*255).astype(np.uint8)).filter(ImageFilter.MinFilter(3)))>127
    if cnt0[k]/max(1,(C&~er).sum())<6: continue      # bỏ dải viền mảnh (đường cong mép sàn)
    yy,xx=np.nonzero(C); x0,y0,x1,y1=max(0,xx.min()-20),max(0,yy.min()-20),xx.max()+21,yy.max()+21
    sub=C[y0:y1,x0:x1]; dl=np.asarray(Image.fromarray((sub*255).astype(np.uint8)).filter(ImageFilter.MaxFilter(9)))>127
    ring=dl&~sub; ls=ext[y0:y1,x0:x1][ring]; ls=ls[ls>0]
    v,c=(np.unique(ls,return_counts=True) if len(ls) else (np.array([],int),np.array([],int)))
    cand={int(a):int(b) for a,b in zip(v,c)}
    for i2,P in enumerate(UB):
        gx=max(0,max(P[:,0].min(),xx.min())-min(P[:,0].max(),xx.max())); gy=max(0,max(P[:,1].min(),yy.min())-min(P[:,1].max(),yy.max()))
        if max(gx,gy)<110 and min(gx,gy)==0: cand.setdefault(i2+1,0)
    cells.append((k,C,cnt0[k]*A2,cand,(x0,y0,x1,y1),sub,ring))
# ô lớn chạm mạnh 2 căn: chia theo khoảng cách
for k,C,area,cand,bx,sub,ring in sorted(cells,key=lambda t:-t[2]):
    if not cand: continue
    cs=sorted(cand.items(),key=lambda q:-q[1])
    if area>25 and len(cs)>1 and cs[1][1]>.35*cs[0][1]:
        x0,y0,x1,y1=bx; lc=np.zeros(sub.shape,np.int32); E=ext[y0:y1,x0:x1]
        for vv,_ in cs[:2]: lc[ring&(E==vv)]=vv
        for it in range(600):
            ch=False
            for dy,dx in((1,0),(-1,0),(0,1),(0,-1)):
                sh=np.roll(lc,(dy,dx),(0,1)); m=(lc==0)&sub&(sh>0)
                if m.any(): lc[m]=sh[m]; ch=True
            if not ch: break
        cur[y0:y1,x0:x1][sub]=lc[sub]
        for vv,_ in cs[:2]: got[codes[vv-1]]+=(lc[sub]==vv).sum()*A2
        continue
    # chọn căn còn thiếu diện tích sân (theo CĐT) khớp nhất; hoà thì căn tiếp giáp dài nhất
    def score(q):
        c=codes[q[0]-1]; deficit=target[c]-got[c]
        return (min(deficit,area)-max(0,area-deficit)*.5 if target[c] else -area*2) + q[1]*1e-4
    w=max(cs,key=score)[0]; cur[C]=w; got[codes[w-1]]+=area
print('so với CĐT:',{c:(round(got[c],1),target[c]) for c in codes if target[c] or got[c]},file=sys.stderr)
res={}
from collections import defaultdict
for i,c in enumerate(codes):
    M=(cur==i+1)&garden
    M=np.asarray(Image.fromarray((M*255).astype(np.uint8)).filter(ImageFilter.MaxFilter(5)).filter(ImageFilter.MinFilter(5)))>127
    if M.sum()<2000: continue
    L=label(M); cnt=np.bincount(L.ravel()); cnt[0]=0
    polys=[]
    for k in np.nonzero(cnt>1500)[0]:
        yy,xx=np.nonzero(L==k)
        polys.append({'px':int(cnt[k]),'mask_bb':[int(xx.min()),int(yy.min()),int(xx.max())+1,int(yy.max())+1]})
        np.save(f'{dst}/g_{c}_{k}.npy',(L==k)[yy.min():yy.max()+1,xx.min():xx.max()+1])
        polys[-1]['k']=int(k)
    res[c]=polys
json.dump(res,open(dst+'/gardens.json','w'))
for c,v in res.items(): print(c,[round(p['px']*0.0406**2,1) for p in v])
