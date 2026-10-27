import numpy as np, json, sys
lab=np.load(sys.argv[1]+'_lab.npy'); wall=np.load(sys.argv[1]+'_wall.npy')
def grow(k):
    yy,xx=np.nonzero(lab==k); x0,x1,y0,y1=xx.min(),xx.max(),yy.min(),yy.max()
    # nới mỗi cạnh tới khi >40% cạnh chạm tường
    def hit(seg): return seg.mean()>0.4
    while x0>0 and not hit(wall[y0:y1+1,x0-1]): x0-=1
    while x1<wall.shape[1]-1 and not hit(wall[y0:y1+1,x1+1]): x1+=1
    while y0>0 and not hit(wall[y0-1,x0:x1+1]): y0-=1
    while y1<wall.shape[0]-1 and not hit(wall[y1+1,x0:x1+1]): y1+=1
    return [int(x0),int(y0),int(x1+1),int(y1+1)]
ks=[int(k) for k in np.unique(lab) if k]
R={k:grow(k) for k in ks}
print(json.dumps(R))
