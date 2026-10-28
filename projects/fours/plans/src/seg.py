"""Tách căn hộ trên ảnh mặt bằng CĐT theo màu loại căn (dùng chương trình cc để gán nhãn vùng)."""
import sys, json, subprocess, numpy as np
from PIL import Image, ImageFilter
CC=sys.argv[0].rsplit('/',1)[0]+'/cc'
COL={'STU':(119,166,182),'1PN':(182,132,109),'1PN+':(64,108,49),'2PN':(252,184,23),'3PN':(240,109,79),'P':(155,130,195)}
def label(mask):
    H,W=mask.shape; r=subprocess.run([CC,str(W),str(H)],input=mask.astype(np.uint8).tobytes(),capture_output=True,check=True)
    return np.frombuffer(r.stdout,dtype=np.int32).reshape(H,W)
def seg(path, tol=40, minpx=9000, close=5):
    im=np.asarray(Image.open(path).convert('RGB')).astype(int); H,W,_=im.shape; out=[]
    names=list(COL)+['_w','_k','_g']; pal=np.array(list(COL.values())+[(255,255,255),(30,30,30),(216,236,167)])
    dist=np.stack([np.abs(im-c).sum(2) for c in pal]); near=dist.argmin(0); dmin=dist.min(0)
    for ti,(t,c) in enumerate(COL.items()):
        m=((near==ti)&(dmin<tol*3)).astype(np.uint8)*255
        g=Image.fromarray(m,'L').filter(ImageFilter.MaxFilter(close)).filter(ImageFilter.MinFilter(close))
        g=g.filter(ImageFilter.MinFilter(3)).filter(ImageFilter.MaxFilter(3))
        L=label(np.asarray(g)>0); cnt=np.bincount(L.ravel())
        for k in np.nonzero(cnt>=minpx)[0]:
            if k==0: continue
            yy,xx=np.nonzero(L==k)
            out.append({'t':t,'px':int(cnt[k]),'bb':[int(xx.min()),int(yy.min()),int(xx.max()),int(yy.max())],'c':[round(float(xx.mean()),1),round(float(yy.mean()),1)]})
    return {'W':W,'H':H,'units':out}
if __name__=='__main__': print(json.dumps(seg(sys.argv[1])))
