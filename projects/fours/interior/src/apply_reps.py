"""Áp bố trí mẫu cho mọi căn cùng kiểu (lật/xoay theo hình căn), tường + phòng đo từ chính căn đó. Ra units-<tòa>.js"""
import sys, json, pickle, numpy as np
from PIL import Image, ImageDraw
import os; _bu=open(os.path.join(os.path.dirname(os.path.abspath(sys.argv[0])),'build_units.py')).read(); ns2={'np':np}; exec(_bu[_bu.index('def trace'):_bu.index('def rects')],ns2)
TOWER,PK,REPF,MPP,UPBRG,OUT,FLOOR=sys.argv[1],sys.argv[2],sys.argv[3],float(sys.argv[4]),float(sys.argv[5]),sys.argv[6],sys.argv[7]
D=pickle.load(open(PK,'rb')); ns={}; exec(open(REPF).read(),ns); REPS=ns['REPS']
OUTJ=json.load(open(sys.argv[8])); foot=OUTJ['footPx']
# tầng sân vườn: mẫu bố trí lấy từ tầng điển hình (REPPK), sân lấy từ GARDIR, số liệu CĐT từ JOBJ
REPD=pickle.load(open(sys.argv[9],'rb')) if len(sys.argv)>9 else D
GARDIR=sys.argv[10] if len(sys.argv)>10 else None
JOB=json.load(open(sys.argv[11]))['data'] if len(sys.argv)>11 else {}
KEYP=sys.argv[12] if len(sys.argv)>12 else TOWER
IMGF=sys.argv[13] if len(sys.argv)>13 else None
def inpoly(x,y,P):
    c=False; j=len(P)-1
    for i in range(len(P)):
        if ((P[i][1]>y)!=(P[j][1]>y)) and (x<(P[j][0]-P[i][0])*(y-P[i][1])/(P[j][1]-P[i][1])+P[i][0]): c=not c
        j=i
    return c
OPS={'id':lambda u,v:(u,v),'mx':lambda u,v:(1-u,v),'my':lambda u,v:(u,1-v),'r180':lambda u,v:(1-u,1-v),
     'r90':lambda u,v:(1-v,u),'r270':lambda u,v:(v,1-u),'tr':lambda u,v:(v,u),'atr':lambda u,v:(1-v,1-u)}
def bb(P): xs=[p[0] for p in P]; ys=[p[1] for p in P]; return [min(xs),min(ys),max(xs),max(ys)]
def mask(P,b,op,N=64):
    im=Image.new('L',(N,N),0); f=OPS[op]
    Q=[f((p[0]-b[0])/(b[2]-b[0]),(p[1]-b[1])/(b[3]-b[1])) for p in P]
    ImageDraw.Draw(im).polygon([(q[0]*N,q[1]*N) for q in Q],fill=1); return np.asarray(im).astype(bool)
def wallmask(code,b,op,N=96,src=None):
    R=(src or D)[code]; im=Image.new('L',(N,N),0); g=ImageDraw.Draw(im); f=OPS[op]
    for w in R['walls']:
        x0=R['x0']+w[0]/MPP; y0=R['y0']+w[1]/MPP; x1=R['x0']+w[2]/MPP; y1=R['y0']+w[3]/MPP
        a=f((x0-b[0])/(b[2]-b[0]),(y0-b[1])/(b[3]-b[1])); c=f((x1-b[0])/(b[2]-b[0]),(y1-b[1])/(b[3]-b[1]))
        g.rectangle([min(a[0],c[0])*N,min(a[1],c[1])*N,max(a[0],c[0])*N,max(a[1],c[1])*N],fill=1)
    m=np.asarray(im).astype(bool); return m
TOLD=0.06
def best_op(rp,sp,rk=None,sk=None):
    rb,sb=bb(rp),bb(sp); ms=mask(sp,sb,'id'); best=(0,None)
    wsb=wallmask(sk,sb,'id') if sk else None
    for op in OPS:
        swap=op in('r90','r270','tr','atr'); rw,rh=rb[2]-rb[0],rb[3]-rb[1]; sw,sh=sb[2]-sb[0],sb[3]-sb[1]
        if swap: rw,rh=rh,rw
        if abs(rw-sw)>TOLD*sw or abs(rh-sh)>TOLD*sh: continue
        mr=mask(rp,rb,op); iou=(mr&ms).sum()/max(1,(mr|ms).sum())
        if sk:
            from PIL import ImageFilter
            wr=wallmask(rk,rb,op,src=REPD); a=np.asarray(Image.fromarray(wr.astype(np.uint8)*255).filter(ImageFilter.MaxFilter(3)))>0; bw=np.asarray(Image.fromarray(wsb.astype(np.uint8)*255).filter(ImageFilter.MaxFilter(3)))>0
            iou=iou*.4+.6*(a&bw).sum()/max(1,(a|bw).sum())
        if iou>best[0]: best=(iou,op)
    return best
SIDE={'T':(0,-1),'B':(0,1),'L':(-1,0),'R':(1,0)}
def side_map(s,op):
    f=OPS[op]; a=f(.5,.5); b2=f(.5+SIDE[s][0]*.25,.5+SIDE[s][1]*.25); d=(round((b2[0]-a[0])*4),round((b2[1]-a[1])*4))
    return {v:k for k,v in SIDE.items()}[d]
units={c:D[c]['unit'] for c in D}; runits={c:REPD[c]['unit'] for c in REPD}
out={}
for code,R in D.items():
    u=units[code]; cands=[]
    for TOLA,TOLD in ((0.08,0.06),(0.16,0.14),(0.16,0.2)):   # lần 2: nới dung sai cho căn tầng sân vườn bị cắt góc
      if cands: break
      for rk,rep in REPS.items():
          selfk=rep.get('self')
          if selfk:
              if selfk!=code or rep.get('floor')!=FLOOR: continue
              ru=units[code]
          elif rk not in runits or (rep.get('floor') and rep.get('floor')!=FLOOR): continue
          else: ru=runits[rk]
          if ru['type']!=u['type'] or abs(ru['tt']-u['tt'])>TOLA*u['tt']: continue
          iou,op=best_op(ru['polyPx'],u['polyPx'],None if selfk else rk,None if selfk else code) if not selfk else (1.0,'id')
          if op: cands.append((iou,rk,op))
    if not cands: print('!! không có mẫu cho',code,u['type']); continue
    iou,rk,op=max(cands); rep=REPS[rk]; sk=rep.get('self'); RR=D[sk] if sk else REPD[rk]
    rb,sb=bb((units[sk] if sk else runits[rk])['polyPx']),bb(u['polyPx']); f=OPS[op]
    sc=rep.get('s',1); of=rep.get('o',0); ofy=rep.get('oy',0)
    def T(p3):   # điểm ảnh trong ảnh cắt mẫu (×3) → mét trong khung cắt căn này
        gx=RR['x0']+(p3[0]-of)*sc/3; gy=RR['y0']+(p3[1]-ofy)*sc/3
        uu,vv=f((gx-rb[0])/(rb[2]-rb[0]),(gy-rb[1])/(rb[3]-rb[1]))
        sx=sb[0]+uu*(sb[2]-sb[0]); sy=sb[1]+vv*(sb[3]-sb[1])
        return [round((sx-R['x0'])*MPP,3),round((sy-R['y0'])*MPP,3)],(sx,sy)
    def rect(r):
        a,_=T((r[0],r[1])); b_,_=T((r[2],r[3])); return [min(a[0],b_[0]),min(a[1],b_[1]),max(a[0],b_[0]),max(a[1],b_[1])]
    fpx=foot
    rooms=[]
    names={'liv':'Khách + ăn + bếp' if u['type']!='STU' else 'Studio (ngủ + khách + bếp)','br1':'Phòng ngủ master' if u['type'] in('2PN','3PN') else 'Phòng ngủ','br2':'Phòng ngủ 2','br3':'Phòng ngủ 3','plus':'Phòng đa năng (+)','wc1':'WC','wc2':'WC 2','log':'Lô gia'}
    for r in rep['rooms']:
        P=[[r['r'][0],r['r'][1]],[r['r'][2],r['r'][1]],[r['r'][2],r['r'][3]],[r['r'][0],r['r'][3]]] if 'r' in r else r['p']
        Q=[T(p)[0] for p in P]; G=[T(p)[1] for p in P]; b=bb(Q); gb=bb(G)
        ext=[]
        for s,(dx,dy) in SIDE.items():
            pts=[(gb[0]+(gb[2]-gb[0])*t, gb[1] if dy<0 else gb[3]) if s in 'TB' else (gb[0] if dx<0 else gb[2], gb[1]+(gb[3]-gb[1])*t) for t in np.linspace(.15,.85,9)]
            out_n=sum(0 if inpoly(x+dx*14,y+dy*14,fpx) else 1 for x,y in pts)
            if out_n/9>.5: ext.append(s)
        rooms.append({'id':r['id'],'name':names.get(r['id'],''),'poly':Q,'bb':b,'floor':'tile' if r['id'].startswith('wc') or r['id']=='log' else 'wood','outdoor':r['id']=='log','ext':ext})
    items=[]
    for it in rep['items']:
        n={k:v for k,v in it.items() if k not in('r','c','b')}
        if 'r' in it: x0,y0,x1,y1=rect(it['r']); n.update(x=x0,y=y0,w=round(x1-x0,3),d=round(y1-y0,3))
        if 'c' in it: p,_=T(it['c']); n.update(x=p[0],y=p[1])
        if 'b' in it: n['b']=side_map(it['b'],op)
        items.append(n)
    gardens=[]
    if GARDIR:
        GJ=json.load(open(GARDIR+'/gardens.json'))
        upoly=[[(p[0]-R['x0'])*MPP,(p[1]-R['y0'])*MPP] for p in u['polyPx']]
        for gp in GJ.get(code,[]):
            m=np.load(f"{GARDIR}/g_{code}_{gp['k']}.npy"); gx0,gy0=gp['mask_bb'][:2]
            P=ns2['trace'](m); P=ns2['dp'](P,2.5)
            Pm=[[round((p[0]+gx0-R['x0'])*MPP,3),round((p[1]+gy0-R['y0'])*MPP,3)] for p in P]
            # lan can: cạnh sân không giáp nhà (cách căn > 0,5 m)
            def dseg(pt):
                best=9
                for i in range(len(upoly)):
                    a=upoly[i]; b2=upoly[(i+1)%len(upoly)]; dx,dy=b2[0]-a[0],b2[1]-a[1]; t=max(0,min(1,((pt[0]-a[0])*dx+(pt[1]-a[1])*dy)/((dx*dx+dy*dy) or 1)))
                    best=min(best,((pt[0]-a[0]-t*dx)**2+(pt[1]-a[1]-t*dy)**2)**.5)
                return best
            rails=[]; cur_=[]
            for i in range(len(Pm)):
                a=Pm[i]; b2=Pm[(i+1)%len(Pm)]; mid=[(a[0]+b2[0])/2,(a[1]+b2[1])/2]
                if dseg(mid)>.5 and dseg(a)>.3 and dseg(b2)>.3:
                    if not cur_: cur_=[a]
                    cur_.append(b2)
                elif cur_: rails.append(cur_); cur_=[]
            if cur_: rails.append(cur_)
            gardens.append({'poly':Pm,'rails':rails,'area':round(float(m.sum()*MPP*MPP),2)})
        # cây, đá bước, bàn ghế ngoài trời trong sân
        for G in gardens:
            P=G['poly']; xs=[p[0] for p in P]; ys=[p[1] for p in P]
            pts=[]
            for x in np.arange(min(xs)+.3,max(xs)-.3,.25):
                for y in np.arange(min(ys)+.3,max(ys)-.3,.25):
                    if not inpoly(x,y,P): continue
                    dmin=min(min(abs(x-a[0]),abs(y-a[1])) for a in P) if False else 9
                    # khoảng cách tới biên sân
                    for i in range(len(P)):
                        a=P[i]; b2=P[(i+1)%len(P)]; dx,dy=b2[0]-a[0],b2[1]-a[1]; t=max(0,min(1,((x-a[0])*dx+(y-a[1])*dy)/((dx*dx+dy*dy) or 1)))
                        dmin=min(dmin,((x-a[0]-t*dx)**2+(y-a[1]-t*dy)**2)**.5)
                    pts.append((dmin,x,y))
            if not pts: continue
            pts.sort(reverse=True); used=[]
            def far(x,y,r): return all((x-a)**2+(y-b2)**2>r*r for a,b2 in used)
            if pts[0][0]>=.95 and G['area']>8:
                _,x,y=pts[0]; items.append({'t':'outdoor','x':round(x-.8,3),'y':round(y-.85,3),'w':1.6,'d':1.7}); used.append((x,y))
            n=max(1,min(4,int(G['area']/9)))
            for dm,x,y in pts:
                if n<=0: break
                if dm>=.45 and far(x,y,2.2): items.append({'t':'palm','x':round(x,3),'y':round(y,3)}); used.append((x,y)); n-=1
            st=[(x,y) for dm,x,y in pts if dm>=.35 and far(x,y,.9)]
            if len(st)>2: items.append({'t':'stones','pts':[[round(x,2),round(y,2)] for x,y in st[:6:2]]})
    jd=JOB.get(code,{})
    out[code]={'code':TOWER+'-'+code,'unitNo':code,'tower':TOWER,'floor':FLOOR,'type':u['type'],'tt':u.get('tt'),'tim':u.get('tim'),'upBrg':UPBRG,'wallH':3.0,
               'rooms':rooms,'wallRects':R['walls'],'items':items,'auto':True,'gardens':gardens,'gardenTT':jd.get('san'),'tim':jd.get('tim',u.get('tim')),'rep':rk,'op':op,'iou':round(float(iou),3)}
    print(code,u['type'],'mẫu',rk,op,round(float(iou),3))
js='/* Nội thất Tòa '+TOWER+' (tầng '+FLOOR+') – bố trí mẫu theo nội thất CĐT vẽ trên mặt bằng, áp cho căn cùng kiểu (apply_reps.py) */\nwindow.FS_UNITS=window.FS_UNITS||{};\n'
for c,v in out.items(): js+='window.FS_UNITS['+json.dumps(KEYP+'-'+c)+']='+json.dumps(v,ensure_ascii=False,separators=(',',':'))+';\n'
open(OUT,'w').write(js)
