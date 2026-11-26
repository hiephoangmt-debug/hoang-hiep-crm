import sys,math
import numpy as np
from PIL import Image
ANG=float(sys.argv[1]); PX,PY=560,520
im=Image.open('goc.png').convert('RGB');A=np.asarray(im).astype(int)
H,W=A.shape[:2];ys,xs=np.mgrid[0:H,0:W]
r,g,b=A[...,0],A[...,1],A[...,2]
nonwhite=(255*3-(r+g+b))>12
warm=(r>g-5)&(r>b+30)
import cv2
cand=(nonwhite&warm&(xs>=862)&(ys<470)).astype(np.uint8)
n,lab,st,_=cv2.connectedComponentsWithStats(cand,8)
keep=[i for i in range(1,n) if st[i,cv2.CC_STAT_LEFT]+st[i,cv2.CC_STAT_WIDTH]>1000 or (st[i,cv2.CC_STAT_LEFT]>940)]
fire=np.isin(lab,keep)|(nonwhite&warm&(xs>=845)&(xs<862)&(ys>=288)&(ys<=328))
head=nonwhite&warm&(xs>=230)&(xs<1000)&(ys<520)&~((xs<450)&(ys>505))&~fire
# lớp
def layer(m):
  L=np.zeros((H,W,4),np.uint8);L[...,:3]=A;L[...,3]=np.where(m,255,0);return Image.fromarray(L,'RGBA')
hl,fl=layer(head),layer(fire)
from PIL import ImageFilter
mk=Image.fromarray(((head|fire)*255).astype(np.uint8)).filter(ImageFilter.MaxFilter(7));mk=np.asarray(mk)>0
mk&=~((ys>=455)&(xs<640))
mk&=~((ys>=520)|((xs<450)&(ys>505)))
base=A.copy();base[mk]=255;base=Image.fromarray(base.astype(np.uint8)).convert('RGBA')
hr=hl.rotate(ANG,resample=Image.BICUBIC,center=(PX,PY))
# vị trí miệng mới (điểm 848,300 xoay theo)
t=math.radians(-ANG);dx,dy=848-PX,300-PY
nx=PX+dx*math.cos(t)-dy*math.sin(t);ny=PY+dx*math.sin(t)+dy*math.cos(t)
base.alpha_composite(hr);base.alpha_composite(fl,(int(nx-848),int(ny-300)))
base.convert('RGB').save(f'xoay_{int(ANG)}.png');print(nx,ny)
