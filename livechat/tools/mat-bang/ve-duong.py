import cv2, numpy as np
from skimage.morphology import skeletonize
m=np.load('roadmask.npy')
m=cv2.morphologyEx(m,cv2.MORPH_CLOSE,cv2.getStructuringElement(cv2.MORPH_ELLIPSE,(15,15)))
m=cv2.GaussianBlur(m,(0,0),3); m=(m>90).astype(np.uint8)
dist=cv2.distanceTransform(m,cv2.DIST_L2,5)
sk=skeletonize(m>0).astype(np.uint8)
H,W=sk.shape
# cắt nhánh cụt ngắn
k=np.ones((3,3),np.uint8)
for _ in range(25):
    nb=cv2.filter2D(sk,-1,k,borderType=cv2.BORDER_CONSTANT)-sk
    ends=(sk==1)&(nb==1)
    if not ends.any(): break
    sk[ends]=0
# lần theo đồ thị
nb=cv2.filter2D(sk,-1,k,borderType=cv2.BORDER_CONSTANT)-sk
pts=set(zip(*np.where(sk>0)))
node=set(p for p in pts if nb[p]!=2)
def neigh(p):
    y,x=p
    return [(y+dy,x+dx) for dy in (-1,0,1) for dx in (-1,0,1) if (dy or dx) and (y+dy,x+dx) in pts]
seen=set(); paths=[]
starts=list(node) if node else [next(iter(pts))]
for s in starts:
    for n0 in neigh(s):
        if (s,n0) in seen: continue
        path=[s,n0]; seen.add((s,n0)); seen.add((n0,s)); prev,cur=s,n0
        while cur not in node:
            nx=[q for q in neigh(cur) if q!=prev and (cur,q) not in seen]
            if not nx: break
            q=nx[0]; seen.add((cur,q)); seen.add((q,cur)); path.append(q); prev,cur=cur,q
        paths.append(path)
# vòng kín không có nút
rest=pts-set(p for pa in paths for p in pa)
def chaikin(a,it=3):
    a=np.array(a,float)
    for _ in range(it):
        if len(a)<3: break
        q=0.75*a[:-1]+0.25*a[1:]; r=0.25*a[:-1]+0.75*a[1:]
        b=np.empty((2*len(q),2)); b[0::2]=q; b[1::2]=r
        a=np.vstack([a[0],b,a[-1]])
    return a
S=0.5; out=[]
for pa in paths:
    if len(pa)<12: continue
    a=np.array([(x,y) for y,x in pa],np.float32).reshape(-1,1,2)
    a=cv2.approxPolyDP(a,2.0,False)[:,0]
    w=np.median([dist[y,x] for y,x in pa])*2*S
    w=float(np.clip(w,4.5,9))
    c=chaikin(a,3)
    d='M'+' L'.join(f'{x*S:.1f} {y*S:.1f}' for x,y in c)
    out.append((w,d))
print(len(out),'đoạn đường')
g=['<g class="roads" fill="none" stroke-linecap="round" stroke-linejoin="round">']
g+= [f'<path d="{d}" stroke="#c9d1dd" stroke-width="{w+2.4:.1f}"/>' for w,d in out]
g+= [f'<path d="{d}" stroke="#fbfcfd" stroke-width="{w:.1f}"/>' for w,d in out]
g.append('</g>')
open('roads.txt','w').write('\n'.join(g))
