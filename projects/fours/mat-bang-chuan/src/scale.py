"""Đo tỷ lệ từng tờ: tim 2 tường ngăn căn 1PN+ (6.300 mm) và tim tường mặt ngoài – tường hành lang (10.150 mm), theo kích thước CĐT ghi trên bản 3D căn 1PN+."""
import sys, json, numpy as np
from PIL import Image
Image.MAX_IMAGE_PIXELS=None
def runs(a):
    if len(a)==0: return []
    out=[];s=a[0];p=a[0]
    for v in a[1:]:
        if v!=p+1: out.append((s,p)); s=v
        p=v
    out.append((s,p)); return out
def measure(src,outj,code,Lmm=10150,Wmm=6300):
    im=Image.open(src).convert('RGB'); A=np.asarray(im).astype(np.int16); H,W,_=A.shape; s0=W/2560
    u=[x for x in json.load(open(outj))['units'] if x['code']==code][0]
    P=np.array(u['polyPx'])*s0; x0,y0,x1,y1=P[:,0].min(),P[:,1].min(),P[:,0].max(),P[:,1].max()
    blk=(A.sum(2)<150)
    horiz=(x1-x0)>(y1-y0)
    # chiều ngắn: 2 tường song song cạnh dài
    if horiz:
        band=blk[int(y0-40):int(y1+40),int(x0+(x1-x0)*.3):int(x0+(x1-x0)*.7)]; prof=band.mean(1); off=y0-40
    else:
        band=blk[int(y0+(y1-y0)*.3):int(y0+(y1-y0)*.7),int(x0-40):int(x1+40)]; prof=band.mean(0); off=x0-40
    R=[((a+b)/2+off,b-a+1) for a,b in runs(np.nonzero(prof>0.85)[0]) if b-a+1>=6]
    short=R[-1][0]-R[0][0] if len(R)>=2 else None
    # chiều dài: tường đầu – tường cuối theo phương dài (dải giữa cạnh ngắn)
    if horiz:
        band=blk[int(y0+(y1-y0)*.35):int(y0+(y1-y0)*.65),int(x0-40):int(x1+40)]; prof=band.mean(0); off=x0-40
    else:
        band=blk[int(y0-40):int(y1+40),int(x0+(x1-x0)*.35):int(x0+(x1-x0)*.65)]; prof=band.mean(1); off=y0-40
    R2=[((a+b)/2+off,b-a+1) for a,b in runs(np.nonzero(prof>0.85)[0]) if b-a+1>=6]
    long_=R2[-1][0]-R2[0][0] if len(R2)>=2 else None
    m1=Wmm/1000/short if short else None; m2=Lmm/1000/long_ if long_ else None
    return m1,m2,R,R2
if __name__=='__main__':
    src,outj=sys.argv[1:3]; codes=sys.argv[3].split(',')
    res=[]
    for c in codes:
        m1,m2,R,R2=measure(src,outj,c)
        print(c,'ngắn',m1 and round(m1*100,4),'dài',m2 and round(m2*100,4),[round(r[0]) for r in R],[round(r[0]) for r in R2])
        for m in (m1,m2):
            if m and .012<m<.025: res.append(m)
    print('MPP',round(float(np.median(res)),6))
