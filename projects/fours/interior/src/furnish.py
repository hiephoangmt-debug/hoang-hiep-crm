"""Xếp nội thất theo quy tắc cho từng căn (đầu vào: F*.pkl từ build_units.py). Ra: units-<tòa>.js cho interior.js."""
import sys, json, pickle, numpy as np
from PIL import Image, ImageFilter
PK=sys.argv[1]; TOWER=sys.argv[2]; MPP=float(sys.argv[3]); UPBRG=float(sys.argv[4]); OUT=sys.argv[5]; FLOORLBL=sys.argv[6]
D=pickle.load(open(PK,'rb'))
def dil(M,r):
    if r<=0: return M
    return np.asarray(Image.fromarray((M*255).astype(np.uint8)).filter(ImageFilter.MaxFilter(2*r+1)))>127
TYPES={'STU':'Studio','1PN':'1PN','1PN+':'1PN+','2PN':'2PN','3PN':'3PN'}
def furnish(code, R):
    lab_rooms=R['rooms']; H,W=R['H'],R['W']; px=lambda v:int(round(v/MPP)); mm=lambda v:round(v*MPP,3)
    allm=np.zeros((H,W),bool)
    for r in lab_rooms: allm|=r['mask']
    # vai trò phòng
    rooms=sorted(lab_rooms,key=lambda r:-r['A']); liv=rooms[0]; liv['role']='liv'
    beds=[r for r in rooms[1:] if r['A']>=6.5]; small=[r for r in rooms[1:] if r['A']<6.5]
    ty=R['unit']['type']; nb={'STU':0,'1PN':1,'1PN+':1,'2PN':2,'3PN':3}.get(ty,1)
    for i,r in enumerate(beds): r['role']='br1' if i==0 else 'br%d'%(i+1)
    if ty=='1PN+' and len(beds)>=2: beds[-1]['role']='plus'
    wcn=0
    for r in small:
        b=r['bb']; mn=min(b[2]-b[0],b[3]-b[1]); exts=[s for s,v in r['ext'].items() if v>.5]
        if exts and (mn<1.75 or r['A']<2.4) and r['A']<4.2: r['role']='log'
        elif r['A']<1.6: r['role']='kho'
        else: wcn+=1; r['role']='wc%d'%wcn
    # vùng cấm trước cửa: điểm biên phòng giáp phòng khác (không có tường)
    items=[]
    occ=np.zeros((H,W),bool)
    def free(x0,y0,x1,y1,room,clear=None):
        X0,Y0,X1,Y1=px(x0),px(y0),px(x1),px(y1)
        if X0<0 or Y0<0 or X1>W or Y1>H or X1<=X0 or Y1<=Y0: return False
        sub=room['mask'][Y0:Y1,X0:X1]
        if sub.mean()<.93: return False
        if occ[Y0:Y1,X0:X1].any(): return False
        if room['door'][Y0:Y1,X0:X1].mean()>.02: return False
        return True
    def put(t,x0,y0,x1,y1,b=None,room=None,**kw):
        occ[px(y0):px(y1),px(x0):px(x1)]=True
        it={'t':t,'x':round(x0,3),'y':round(y0,3),'w':round(x1-x0,3),'d':round(y1-y0,3)}
        if b: it['b']=b
        it.update(kw); items.append(it); return it
    for r in rooms:
        M=r['mask']; other=allm&~M
        g=M&dil(other,3)   # biên phòng sát phòng khác (qua lỗ cửa)
        r['door']=dil(g,px(0.75))&M
    def edges(r):
        b=r['bb']; return {'T':b[1],'B':b[3],'L':b[0],'R':b[2]}
    def against(room,side,w,d,pos=.5,step=.05):
        """đặt khối w (dọc tường) × d (vuông góc) sát tường 'side'; quét dọc tường quanh vị trí ưu tiên"""
        b=room['bb']
        L=(b[2]-b[0]) if side in 'TB' else (b[3]-b[1]); a0=(b[0] if side in 'TB' else b[1])
        cands=sorted(np.arange(0,max(0.0,L-w)+1e-6,step),key=lambda s:abs((s+w/2)/L-pos))
        for inset in (0.02,0.12,0.25):
            for s in cands:
                a=a0+s
                if side=='T': r=(a,b[1]+inset,a+w,b[1]+inset+d)
                elif side=='B': r=(a,b[3]-inset-d,a+w,b[3]-inset)
                elif side=='L': r=(b[0]+inset,a,b[0]+inset+d,a+w)
                else: r=(b[2]-inset-d,a,b[2]-inset,a+w)
                if free(*r,room): return r
        return None
    OPP={'T':'B','B':'T','L':'R','R':'L'}
    def sides_by_len(room,exclude=()):
        b=room['bb']; s=[('T',b[2]-b[0]),('B',b[2]-b[0]),('L',b[3]-b[1]),('R',b[3]-b[1])]
        return [x for x,_ in sorted(s,key=lambda q:-q[1]) if x not in exclude]
    def extsides(room): return [s for s,v in sorted(room['ext'].items(),key=lambda q:-q[1]) if v>.5]
    def bedroom(room,master):
        ex=extsides(room); b=room['bb']
        sizes=[(1.8,2.05,'1m8'),(1.6,2.05,'1m6'),(1.4,2.0,'1m4'),(1.2,2.0,'1m2')] if master else [(1.6,2.05,'1m6'),(1.4,2.0,'1m4'),(1.2,2.0,'1m2')]
        done=None
        for bw,bl,sz in sizes:
            for side in sides_by_len(room,ex)+ex:
                r=against(room,side,bw+0.9,bl+0.05,.5) or against(room,side,bw,bl+0.05,.5)
                if r:
                    wide=(r[2]-r[0] if side in 'TB' else r[3]-r[1])>bw+.5
                    if side in 'TB': cx=(r[0]+r[2])/2; bed=(cx-bw/2,r[1],cx+bw/2,r[3]) 
                    else: cy=(r[1]+r[3])/2; bed=(r[0],cy-bw/2,r[2],cy+bw/2)
                    bb_={'T':'T','B':'B','L':'L','R':'R'}[side]
                    put('bed',*bed,b=bb_,size=sz)
                    if wide:
                        for sgn in (-1,1):
                            if side in 'TB': n=(bed[0]-.47,bed[1] if side=='T' else bed[3]-.42,bed[0]-.02,(bed[1]+.42) if side=='T' else bed[3]) if sgn<0 else (bed[2]+.02,bed[1] if side=='T' else bed[3]-.42,bed[2]+.47,(bed[1]+.42) if side=='T' else bed[3])
                            else: n=(bed[0] if side=='L' else bed[2]-.42,bed[1]-.47,(bed[0]+.42) if side=='L' else bed[2],bed[1]-.02) if sgn<0 else (bed[0] if side=='L' else bed[2]-.42,bed[3]+.02,(bed[0]+.42) if side=='L' else bed[2],bed[3]+.47)
                            if free(*n,room): put('nightstand',*n,b=side)
                    if master: put('headboard',*( (bed[0]-.5,bed[1],bed[2]+.5,bed[1]+.05) if side=='T' else (bed[0]-.5,bed[3]-.05,bed[2]+.5,bed[3]) if side=='B' else (bed[0],bed[1]-.5,bed[0]+.05,bed[3]+.5) if side=='L' else (bed[2]-.05,bed[1]-.5,bed[2],bed[3]+.5)),deco=1) if False else None
                    done=side; break
            if done: break
        # tủ áo
        for side in [s for s in sides_by_len(room) if s!=done and s not in ex]+[s for s in ex if s!=done]:
            for L in (2.0,1.8,1.6,1.4,1.2,1.0):
                r=against(room,side,L,.6,.0 if side in 'LR' else 1.0)
                if r: put('wardrobe',*r,b=side,glass=True); break
            else: continue
            break
        if master:
            for side in sides_by_len(room):
                r=against(room,side,.9,.45,.8)
                if r: put('dresser',*r,b=side); break
        else:
            for side in sides_by_len(room):
                r=against(room,side,1.0,.55,.85)
                if r: put('desk',*r,b=side); break
    def wc(room):
        b=room['bb']; long_h=(b[2]-b[0])>=(b[3]-b[1])
        ends=['L','R'] if long_h else ['T','B']
        # vách tắm ở đầu xa cửa nhất
        dm=room['door']; yy,xx=np.nonzero(dm)
        if len(xx): dc=(xx.mean()*MPP,yy.mean()*MPP)
        else: dc=((b[0]+b[2])/2,(b[1]+b[3])/2)
        far=max(ends,key=lambda s:abs((b[0] if s=='L' else b[2] if s=='R' else b[1] if s=='T' else b[3])-(dc[0] if s in 'LR' else dc[1])))
        span=(b[3]-b[1]) if long_h else (b[2]-b[0])
        r=against(room,far,min(span-.04,1.2),.9,.5)
        if r: put('shower',*r)
        for side in sides_by_len(room,(far,)):
            r=against(room,side,.42,.55,.4)
            if r: put('toilet',*r,b=side); break
        for side in sides_by_len(room,(far,)):
            r=against(room,side,.8,.48,.7)
            if r: put('vanity',*r,b=side); break
    def logia(room):
        for side in sides_by_len(room):
            r=against(room,side,.6,.6,.0)
            if r: put('washer',*r,b=side); break
        b=room['bb']; put('dryrack',b[0]+.05,b[1]+.05,b[2]-.05,b[3]-.05) if (b[2]-b[0])>.5 and (b[3]-b[1])>.5 else None
        occ[:]=occ  # giàn phơi trên cao không chiếm sàn
    def living(room,studio):
        b=room['bb']; horiz=(b[2]-b[0])>=(b[3]-b[1]); ex=extsides(room)
        endA,endB=('L','R') if horiz else ('T','B')
        # đầu cửa sổ = đầu giáp ngoài, nếu không có thì đầu xa cửa ra vào nhất
        win=[s for s in ex if s in (endA,endB)]
        if win: wend=win[0]
        else:
            dm=room['door']; yy,xx=np.nonzero(dm); c=(xx.mean()*MPP,yy.mean()*MPP) if len(xx) else ((b[0]+b[2])/2,(b[1]+b[3])/2)
            wend=max((endA,endB),key=lambda s:abs((b[0] if s=='L' else b[2] if s=='R' else b[1] if s=='T' else b[3])-(c[0] if s in 'LR' else c[1])))
        kend=OPP[wend]; longs=('T','B') if horiz else ('L','R')
        pos_w=0.0 if wend in 'LT' else 1.0; pos_k=1-pos_w; pos_m=.5
        if studio:
            for side in longs:
                r=against(room,side,2.05,1.65,pos_w) if side in 'LR' else against(room,side,1.65,2.05,pos_w)
                if r:
                    put('bed',*r,b=side,size='1m6'); break
            for side in longs:
                r=against(room,side,1.2,.6,.55)
                if r: put('wardrobe',*r,b=side,glass=True); break
        else:
            sofa=None
            for side in longs:
                r=against(room,side,2.1,.9,pos_w+(.12 if pos_w==0 else -.12))
                if r: sofa=put('sofa',*r,b=side); sside=side; break
            if sofa:
                o=OPP[sside]; ca=((sofa['y']+sofa['d']/2) if sside in 'LR' else (sofa['x']+sofa['w']/2))
                bb_=room['bb']; L=(bb_[3]-bb_[1]) if o in 'LR' else (bb_[2]-bb_[0]); a0=bb_[1] if o in 'LR' else bb_[0]
                r=against(room,o,1.6,.42,(ca-a0)/L)
                if r: put('tvconsole',*r,b=o,tv=True)
                # bàn trà giữa
                if sside in 'LR':
                    cx=(sofa['x']+sofa['w']+ (r[0] if r else sofa['x']+2.2))/2 if sside=='L' else ((r[2] if r else sofa['x']-1.3)+sofa['x'])/2
                    t=(cx-.3,ca-.5,cx+.3,ca+.5)
                else:
                    cy=(sofa['y']+sofa['d']+(r[1] if r else sofa['y']+2.2))/2 if sside=='T' else ((r[3] if r else sofa['y']-1.3)+sofa['y'])/2
                    t=(ca-.5,cy-.3,ca+.5,cy+.3)
                if free(*t,room): put('coffeetable',*t); put('rug',t[0]-.5,t[1]-.5,t[2]+.5,t[3]+.5) if False else None
        # bếp ở đầu gần cửa ra vào: chạy dọc 1 cạnh dài + tủ lạnh
        kit=None
        for side in longs+(kend,):
            for L in (2.4,2.1,1.8,1.5):
                r=against(room,side,L,.6,pos_k)
                if r: kit=put('kitchen',*r,b=side,sink=round(L*.3,2),hob=round(L*.72,2)); break
            if kit: break
        for side in (kend,)+longs:
            r=against(room,side,.75,.72,pos_k)
            if r: put('fridge',*r,b=side); break
        # bàn ăn giữa
        n=2 if studio else 4; tw,td=(.8,.7) if studio else (1.2,.8)
        cx,cy=(b[0]+b[2])/2,(b[1]+b[3])/2
        best=None
        for f in np.linspace(.25,.75,21):
            for g_ in np.linspace(.3,.7,9):
                x=b[0]+(b[2]-b[0])*(g_ if horiz else f); y=b[1]+(b[3]-b[1])*(f if horiz else g_)
                if horiz: x=b[0]+(b[2]-b[0])*f; y=b[1]+(b[3]-b[1])*g_
                r=(x-tw/2,y-td/2-.5,x+tw/2,y+td/2+.5)
                if free(*r,room):
                    sc=abs(f-.5)+abs(g_-.5)
                    if best is None or sc<best[0]: best=(sc,x,y)
        if best:
            _,x,y=best; put('dining',x-tw/2,y-td/2,x+tw/2,y+td/2,chairs=n); occ[px(y-td/2-.5):px(y+td/2+.5),px(x-tw/2):px(x+tw/2)]=True
            items.append({'t':'pendant','x':round(x,3),'y':round(y,3)})
        for side in longs:
            r=against(room,side,.45,.45,pos_w)
            if r: put('plant',*r); break
    for r in rooms:
        role=r.get('role')
        if role=='liv': living(r,ty=='STU')
    for r in rooms:
        role=r.get('role','')
        if role.startswith('br'): bedroom(r,role=='br1' and nb>=1)
        elif role=='plus': bedroom(r,False)
        elif role.startswith('wc'): wc(r)
        elif role=='log': logia(r)
    names={'liv':'Khách + ăn + bếp' if ty!='STU' else 'Studio (ngủ + khách + bếp)','br1':'Phòng ngủ master' if nb>=2 else 'Phòng ngủ','br2':'Phòng ngủ 2','br3':'Phòng ngủ 3','plus':'Phòng đa năng (+)','wc1':'WC','wc2':'WC 2','log':'Lô gia','kho':'Kho'}
    RO=[]
    for r in rooms:
        role=r.get('role','kho'); fl='tile' if role.startswith('wc') or role=='log' else 'wood'
        RO.append({'id':role,'name':names.get(role,''),'poly':r['poly'],'floor':fl,'outdoor':role=='log','ext':[s for s,v in r['ext'].items() if v>.5],'bb':r['bb']})
    u=R['unit']
    return {'code':TOWER+'-xx-'+code,'unitNo':code,'tower':TOWER,'floor':FLOORLBL,'type':u['type'],'tt':u.get('tt'),'tim':u.get('tim'),'upBrg':UPBRG,'wallH':3.0,
            'rooms':RO,'wallRects':R['walls'],'items':items,'auto':True}
U={}
for code,R in D.items():
    try: U[code]=furnish(code,R)
    except Exception as e: print('LỖI',code,e)
js='/* Nội thất tự động Tòa '+TOWER+' (tầng điển hình '+FLOORLBL+') – sinh bởi furnish.py từ bản vẽ CĐT */\nwindow.FS_UNITS=window.FS_UNITS||{};\n'
for code,u in U.items(): js+='window.FS_UNITS['+json.dumps(TOWER+'-'+code)+']='+json.dumps(u,ensure_ascii=False,separators=(',',':'))+';\n'
open(OUT,'w').write(js)
for code,u in U.items(): print(code,u['type'],[r['id'] for r in u['rooms']],len(u['items']),sorted(set(i['t'] for i in u['items'])))
