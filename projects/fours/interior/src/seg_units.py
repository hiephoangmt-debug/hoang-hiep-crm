"""Tách phòng cho mọi căn của 1 tờ mặt bằng (2560 px). Vào: out_*.json (đường bao căn) + ảnh. Ra: ảnh kiểm tra + json phòng."""
import sys, json, subprocess, numpy as np
from PIL import Image, ImageFilter
sys.path.insert(0,'/nonexistent')
CC='/tmp/claude-0/-home-user-hoang-hiep-crm/04904dc5-f0d4-5f74-b258-32836a553812/scratchpad/plans/cc'
COL={'STU':(119,166,182),'1PN':(182,132,109),'1PN+':(64,108,49),'2PN':(252,184,23),'3PN':(240,109,79)}
def label(mask):
    H,W=mask.shape; r=subprocess.run([CC,str(W),str(H)],input=mask.astype(np.uint8).tobytes(),capture_output=True,check=True)
    return np.frombuffer(r.stdout,dtype=np.int32).reshape(H,W)
def morph(m,ops):
    g=Image.fromarray((m*255).astype(np.uint8),'L')
    for op,k in ops: g=g.filter(ImageFilter.MaxFilter(k) if op=='d' else ImageFilter.MinFilter(k))
    return np.asarray(g)>127
def poly_mask(P,shape,off):
    from PIL import ImageDraw
    im=Image.new('L',(shape[1],shape[0]),0); ImageDraw.Draw(im).polygon([(p[0]-off[0],p[1]-off[1]) for p in P],fill=255); return np.asarray(im)>127
def run(img,out_json,dst,wallk=2,door=15,thr=110):
    d=json.load(open(out_json)); IM=np.asarray(Image.open(img).convert('RGB')).astype(int)
    res={}
    for u in d['units']:
        P=u['polyPx']; xs=[p[0] for p in P]; ys=[p[1] for p in P]; m=40
        x0,y0,x1,y1=int(min(xs))-m,int(min(ys))-m,int(max(xs))+m,int(max(ys))+m
        im=IM[y0:y1,x0:x1]; dark=im.sum(2)<thr
        if wallk==2:
            e=dark&np.roll(dark,-1,1)&np.roll(dark,-1,0)&np.roll(np.roll(dark,-1,0),-1,1)
            wall=e|np.roll(e,1,1)|np.roll(e,1,0)|np.roll(np.roll(e,1,0),1,1)
        else: wall=morph(dark,[('e',wallk),('d',wallk)])
        upm=poly_mask(P,dark.shape,(x0,y0)); upm=morph(upm,[('d',9)])       # vùng căn (nới 4 px ra tường)
        env=upm&~wall
        L=label(env); cnt=np.bincount(L.ravel()); cnt[0]=0; env=L==cnt.argmax()
        # bỏ vụn nét đen (nội thất) khỏi tường
        Lw=label(wall); cw=np.bincount(Lw.ravel()); cw[0]=0; wall=np.isin(Lw,np.nonzero(cw>=30)[0]); env=upm&~wall
        L=label(env); cnt=np.bincount(L.ravel()); cnt[0]=0; env=L==cnt.argmax()
        def grow_labels(dr,minc):
            wl=morph(wall,[('d',2*dr+1)]); core=env&~wl; Lr=label(core); c2=np.bincount(Lr.ravel()); c2[0]=0
            keep=[k for k in np.nonzero(c2>minc)[0]]; lab=np.where(np.isin(Lr,keep),Lr,0)
            for _ in range(dr+4):
                for dy,dx in((1,0),(-1,0),(0,1),(0,-1)):
                    sh=np.roll(lab,(dy,dx),(0,1)); mm=(lab==0)&env&(sh>0); lab[mm]=sh[mm]
            return lab
        lab=grow_labels(door,60); small=grow_labels(8,20); nxt=lab.max()+1
        a_m2=0.0406**2
        for k in [int(k) for k in np.unique(small) if k]:
            C=small==k; n=C.sum()
            if not (1.2/a_m2<n<6.5/a_m2): continue
            ks,cs=np.unique(lab[C],return_counts=True); j=cs.argmax(); host=ks[j]
            if host==0 or cs[j]/n<.85: continue
            if (lab==host).sum()<2.2*n: continue
            lab[C&(lab==host)]=nxt; nxt+=1
        keep=[int(k) for k in np.unique(lab) if k]
        rooms=[]
        for k in keep:
            yy,xx=np.nonzero(lab==k); rooms.append({'px':int(len(yy)),'bb':[int(xx.min())+x0,int(yy.min())+y0,int(xx.max())+x0+1,int(yy.max())+y0+1]})
        res[u['code']]={'box':[x0,y0,x1,y1],'rooms':rooms}
        np.savez_compressed(f"{dst}/{u['code']}.npz",lab=lab,wall=wall,env=env,box=np.array([x0,y0,x1,y1]))
    json.dump(res,open(f"{dst}/rooms.json",'w'))
    return res
if __name__=='__main__':
    r=run(sys.argv[1],sys.argv[2],sys.argv[3])
    for k,v in r.items(): print(k,len(v['rooms']),sorted([round(x['px']*0.0406**2,1) for x in v['rooms']],reverse=True))
