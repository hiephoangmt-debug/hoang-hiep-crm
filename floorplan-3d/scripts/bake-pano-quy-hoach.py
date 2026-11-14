# In quy hoạch (công viên QH, làm sạch, resort) vào ảnh 360° theo đúng phối cảnh flycam: viền mờ, khớp tông màu, sương xa.
# Chạy: python3 scripts/bake-pano-quy-hoach.py (cần Pillow, numpy) → public/pano/<ảnh>-qh|sach|resort.jpg
import numpy as np, math
from PIL import Image, ImageFilter
Image.MAX_IMAGE_PIXELS=None
PUB='/home/user/hoang-hiep-crm/floorplan-3d/public/'
MB=PUB+'mat-bang/sun-saphia/'
KX,KZ=106974.8,110600
QH=[[16.0203858,108.2614604],[16.0196534,108.2617818],[16.0186924,108.2594413],[16.0194248,108.2591199]]
STRIP=[[16.0242473,108.2598368],[16.0201026,108.2616558],[16.0191028,108.2592206],[16.0232475,108.2574016]]
CLEAN=[[16.0241631,108.259823],[16.0204594,108.2614484],[16.0194985,108.2591079],[16.0232022,108.2574825]]
PANOS=[('sun-saphia-150m',16.020964444,108.257773967,150.5,343.7),('sun-saphia-120m',16.020978376,108.257753928,119.7,333.4)]
def load(f):
    im=Image.open(f).convert('RGBA'); return np.asarray(im).astype(np.float32)/255
OV={'resort':load(MB+'cong-vien-phia-truoc.webp'),'qh':load(MB+'cong-vien-qh.webp'),'sach':load(MB+'phia-truoc-lam-sach.webp')}
for name,lat0,lon0,alt,head in PANOS:
    src=Image.open(PUB+'pano/'+name+'.jpg').convert('RGB'); W,H=src.size
    base=np.asarray(src).astype(np.float32)/255
    ys=np.arange(H//2+4,H); xs=np.arange(W)
    X,Y=np.meshgrid(xs,ys)
    el=-(Y+0.5-H/2)/H*180; b=head+((X+0.5)/W-0.5)*360
    d=alt/np.tan(np.radians(-el)); E=d*np.sin(np.radians(b)); N=d*np.cos(np.radians(b))
    def paste(img,quad,cur,feather,match=0.55,hz=True):
        C=[np.array([(lo-lon0)*KX,(la-lat0)*KZ]) for la,lo in quad]
        A=C[2]-C[3]; B=C[0]-C[3]; M=np.array([[A[0],B[0]],[A[1],B[1]]]); Mi=np.linalg.inv(M)
        dx=E-C[3][0]; dy=N-C[3][1]
        s=Mi[0,0]*dx+Mi[0,1]*dy; t=Mi[1,0]*dx+Mi[1,1]*dy
        Ls=np.linalg.norm(A); Lt=np.linalg.norm(B)
        m=(s>0)&(s<1)&(t>0)&(t<1)
        if not m.any(): return cur
        h,w=img.shape[:2]
        px=np.clip((s*w).astype(int),0,w-1); py=np.clip(((1-t)*h).astype(int),0,h-1)
        smp=img[py,px]
        fe=np.minimum.reduce([s*Ls,(1-s)*Ls,t*Lt,(1-t)*Lt])
        a=np.clip(fe/feather,0,1)**1.5*smp[...,3]*m
        rgb=smp[...,:3]
        # khớp tông màu ảnh flycam trong vùng
        sel=m&(smp[...,3]>0.5)
        ph=cur[sel]; ov=rgb[sel]
        if len(ph)>100:
            pm,ps=ph.mean(0),ph.std(0)+1e-3; om,os_=ov.mean(0),ov.std(0)+1e-3
            tgt=(rgb-om)/os_*(os_*(1-match)+ps*match)+(om*(1-match)+pm*match)
            g=tgt.mean(-1,keepdims=True); rgb=np.clip(g+(tgt-g)*0.9,0,1)
        if hz:   # sương xa: càng xa càng nhạt về màu khí quyển
            haze=np.clip((d-150)/1500,0,0.35)[...,None]; rgb=rgb*(1-haze)+np.array([0.72,0.78,0.84])*haze
        return cur*(1-a[...,None])+rgb*a[...,None]
    low=base[H//2+4:].copy()
    outs={'qh':paste(OV['qh'],QH,low.copy(),5)}
    outs['sach']=paste(OV['qh'],QH,paste(OV['sach'],CLEAN,low.copy(),10,match=0.2),5)
    outs['resort']=paste(OV['qh'],QH,paste(OV['resort'],STRIP,low.copy(),12),5)
    for k,v in outs.items():
        full=base.copy(); full[H//2+4:]=v
        Image.fromarray((full*255).astype(np.uint8)).save(PUB+f'pano/{name}-{k}.jpg',quality=82,optimize=True,progressive=True)
print('ok')
