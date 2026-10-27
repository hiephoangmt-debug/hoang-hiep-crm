"""Tách phòng trong 1 căn từ bản vẽ CĐT: vùng màu căn (đã lấp nét nội thất) chia theo tường đen, cắt tại cửa đi."""
import sys, json, subprocess, numpy as np
from PIL import Image, ImageFilter
Image.MAX_IMAGE_PIXELS=None
CC='/tmp/claude-0/-home-user-hoang-hiep-crm/04904dc5-f0d4-5f74-b258-32836a553812/scratchpad/plans/cc'
COL={'STU':(119,166,182),'1PN':(182,132,109),'1PN+':(64,108,49),'2PN':(252,184,23),'3PN':(240,109,79),'4':(155,135,200)}
def label(mask):
    H,W=mask.shape; r=subprocess.run([CC,str(W),str(H)],input=mask.astype(np.uint8).tobytes(),capture_output=True,check=True)
    return np.frombuffer(r.stdout,dtype=np.int32).reshape(H,W)
def morph(m,ops):
    g=Image.fromarray((m*255).astype(np.uint8),'L')
    for op,k in ops: g=g.filter(ImageFilter.MaxFilter(k) if op=='d' else ImageFilter.MinFilter(k))
    return np.asarray(g)>127
def run(img,box,color,seed,door_px,close_px):
    im=np.asarray(Image.open(img).convert('RGB').crop(box)).astype(int)
    c=np.array(COL[color]); d=np.abs(im-c).sum(2)
    pal=np.array(list(COL.values())+[(255,255,255),(25,25,25),(216,236,167),(120,120,120),(190,190,190)])
    near=np.stack([np.abs(im-p).sum(2) for p in pal]).argmin(0)
    ci=list(COL).index(color)
    fill=(near==ci)
    # vùng căn: thành phần chứa điểm seed sau khi lấp nét mảnh
    dark=im.sum(2)<200
    wall=morph(dark,[('e',close_px),('d',close_px)])       # tường: nét đen dày ≥ close_px (bỏ nét nội thất mảnh)
    env=morph(fill,[('d',61),('e',61)])&~wall              # lấp chỗ giường, tủ (nền trắng) bên trong căn
    L=label(env); unit=L==L[seed[1],seed[0]]
    # tách phòng: nới tường thêm nửa bề rộng cửa để chặn lối cửa đi
    wl=morph(wall,[('d',2*door_px+1)])
    core=unit&~wl; Lr=label(core); cnt=np.bincount(Lr.ravel()); cnt[0]=0
    keep=[k for k in np.nonzero(cnt>300)[0]]
    lab=np.where(np.isin(Lr,keep),Lr,0)
    # lan nhãn trở lại toàn bộ vùng căn
    for _ in range(door_px+4):
        for dy,dx in((1,0),(-1,0),(0,1),(0,-1)):
            sh=np.roll(lab,(dy,dx),(0,1)); m=(lab==0)&unit&(sh>0); lab[m]=sh[m]
    return im,unit,wall,lab,keep
if __name__=='__main__':
    a=json.load(open(sys.argv[1])); im,unit,wall,lab,keep=run(a['img'],a['box'],a['color'],a['seed'],a['door'],a['close'])
    np.save(sys.argv[2]+'_lab.npy',lab); np.save(sys.argv[2]+'_wall.npy',wall); np.save(sys.argv[2]+'_unit.npy',unit)
    out=[]
    for k in keep:
        yy,xx=np.nonzero(lab==k); out.append({'k':int(k),'px':int(len(yy)),'c':[int(xx.mean()),int(yy.mean())],'bb':[int(xx.min()),int(yy.min()),int(xx.max()),int(yy.max())]})
    print(json.dumps({'unitpx':int(unit.sum()),'rooms':out}))
    # ảnh kiểm tra
    rng=np.random.RandomState(3); colors=rng.randint(60,255,(lab.max()+1,3)); colors[0]=255
    vis=colors[lab].astype(np.uint8); vis[wall]=0
    Image.fromarray(vis).save(sys.argv[2]+'_rooms.png')
