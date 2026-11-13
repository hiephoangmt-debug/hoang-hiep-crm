# Bám tim đường vào khe trống giữa các lô (không đè lô), giữ hình dáng tuyến vẽ tay
import numpy as np,cv2
def snap(pts,w,L,R=40,clear=3):
    segid=[]
    Ld=cv2.dilate(L.astype(np.uint8),np.ones((2*clear+1,2*clear+1),np.uint8))>0
    H,W=L.shape; P=np.array(pts,float); out=[]
    for i in range(len(P)-1):
        a,b=P[i],P[i+1]; d=b-a; n=int(np.hypot(*d)//5)+1
        for s in np.linspace(0,1,n,endpoint=False): out.append(a+d*s); segid.append(i)
    out.append(P[-1]); segid.append(len(P)-2); out=np.array(out); segid=np.array(segid)
    tang=np.gradient(out,axis=0); tang/=np.linalg.norm(tang,axis=1,keepdims=True)+1e-9; nor=np.c_[-tang[:,1],tang[:,0]]
    C=[];Wd=[]
    for p,nv in zip(out,nor):
        ts=np.arange(-R,R+1); q=(p[None]+nv[None]*ts[:,None]).round().astype(int)
        ok=(q[:,0]>=0)&(q[:,0]<W)&(q[:,1]>=0)&(q[:,1]<H)
        free=np.ones(len(ts),bool); free[ok]=~Ld[q[ok,1],q[ok,0]]
        if free[R]: z=R
        else:
            fi=np.nonzero(free)[0]
            if len(fi)==0: C.append(0);Wd.append(w);continue
            z=fi[np.argmin(abs(fi-R))]
        lo=z
        while lo>0 and free[lo-1]: lo-=1
        hi=z
        while hi<len(ts)-1 and free[hi+1]: hi+=1
        lo,hi=ts[lo],ts[hi]; span=hi-lo
        if span>=w: c=min(max(0,lo+w/2),hi-w/2); ww=w
        else: c=(lo+hi)/2; ww=max(span-1,8)
        C.append(c);Wd.append(ww)
    C=np.array(C,float)
    # mỗi đoạn thẳng dịch một lượng cố định (trung vị) -> giữ thẳng
    off=[]
    for i in range(len(P)-1):
        cc=C[segid==i]; off.append(np.median(cc) if len(cc) else 0)
    NP=[]
    for i in range(len(P)):
        segs_i=[j for j in (i-1,i) if 0<=j<len(P)-1]
        sh=[]
        for j in segs_i:
            d=P[j+1]-P[j]; nn=np.array([-d[1],d[0]])/np.hypot(*d); sh.append(nn*off[j])
        NP.append(tuple(P[i]+np.mean(sh,axis=0)))
    Wp=np.pad(np.array(Wd,float),8,mode='edge'); Wd=np.array([Wp[i:i+17].min() for i in range(len(Wd))])
    Wp=np.pad(Wd,6,mode='edge'); Wd=np.convolve(Wp,np.ones(13)/13,'valid')
    return out+nor*C[:,None], Wd, NP
