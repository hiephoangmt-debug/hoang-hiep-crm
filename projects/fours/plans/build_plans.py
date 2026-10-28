"""Gom kết quả trích xuất mặt bằng (out_*.json) thành plans-data.js cho mô hình 4D + trang chọn căn.
Toạ độ: mét trên mặt bằng CĐT (x sang phải, y xuống dưới), gốc = góc trên-trái đường bao thân tháp tầng điển hình.
Tỷ lệ mét/điểm ảnh suy ra từ diện tích thông thủy CĐT ghi trên từng căn (trung vị); ảnh gốc giữ nguyên toạ độ điểm ảnh để chồng khít."""
import json, sys, pathlib, numpy as np
SRC=pathlib.Path(sys.argv[1]); HERE=pathlib.Path(__file__).parent
def dp(pts,eps):
    pts=np.array(pts,float); closed=True
    def rec(a,b):
        if b<=a+1: return [a]
        p,q=pts[a],pts[b]; d=q-p; n=np.hypot(*d) or 1
        seg=pts[a+1:b]; dist=np.abs(d[0]*(seg[:,1]-p[1])-d[1]*(seg[:,0]-p[0]))/n; i=int(dist.argmax())
        return rec(a,a+1+i)+rec(a+1+i,b) if dist[i]>eps else [a]
    P=np.vstack([pts,pts[:1]]); pts=P; m=int(np.hypot(*(P-P[0]).T).argmax())
    idx=rec(0,m)+rec(m,len(P)-1); return [[round(float(pts[i][0]),2),round(float(pts[i][1]),2)] for i in idx]
TOW={'F2':{'up':'NE','perband':True,'bands':[('F2_3',['3']),('F2_3A',['3A']),('F2_5',['5']),('F2_6',['6']),('F2_7',['7']),('F2_8',['8','9','10','11','12','12A','15','16','17','18','19'])],'ref':'F2_8'},
     'F1':{'up':'NE','bands':[('F1_2',['2']),('F1_3',['3']),('F1_4',['3A','5','6','7']),('F1_8',['8','9','10','11','12','12A','15','16','17','18','19'])],'ref':'F1_8'},
     'F5':{'up':'NW','bands':[('F5_2',['2']),('F5_3',['3']),('F5_4',['3A','5','6','7']),('F5_8',['8','9','10','11','12','12A','15']),('F5_16',['16']),('F5_17',['17','18','19'])],'ref':'F5_8'}}
IMG={}
out={}
for t,cfg in TOW.items():
    D={k:json.load(open(SRC/f'out_{k}.json')) for k,_ in cfg['bands']}
    # tỷ lệ = trung vị √(thông thủy CĐT / diện tích đường bao căn) trên mọi căn các tầng điển hình
    def area(P): P=np.array(P); return abs(np.dot(P[:,0],np.roll(P[:,1],1))-np.dot(P[:,1],np.roll(P[:,0],1)))/2
    mpp=float(np.median([np.sqrt(u['tt']/area(u['polyPx'])) for k,_ in cfg['bands'] if not k.endswith('_2') for u in D[k]['units']]))
    ref=D[cfg['ref']]; fx=[p[0] for p in ref['footPx']]; fy=[p[1] for p in ref['footPx']]; ox,oy=min(fx),min(fy)
    def m(P,eps=None):
        Q=[[(p[0]-ox)*mpp,(p[1]-oy)*mpp] for p in P]
        return dp(Q,eps) if eps else [[round(a,2),round(b,2)] for a,b in Q]
    T={'up':cfg['up'],'mpp':round(mpp,5),'originPx':[ox,oy],'W':round((max(fx)-ox)*mpp,2),'D':round((max(fy)-oy)*mpp,2),'bands':[]}
    for k,floors in cfg['bands']:
        d=D[k]; name=f"{t}-{k.split('_')[1]}.jpg"; IMG[name]=d['img']
        if cfg.get('perband'):   # mỗi tờ một tỷ lệ: tính riêng, gốc = góc trên-trái đường bao tháp của tờ đó
            mpp=float(np.median([np.sqrt(u['tt']/area(u['polyPx'])) for u in d['units']]))
            fx=[p[0] for p in d['footPx']]; fy=[p[1] for p in d['footPx']]; ox,oy=min(fx),min(fy)
            if k==cfg['ref']: T.update(mpp=round(mpp,5),W=round((max(fx)-ox)*mpp,2),D=round((max(fy)-oy)*mpp,2))
        T['bands'].append({'key':k,'floors':floors,'src':d['img'],
          'foot':m(d['footPx'],.25),'gardens':[m(g,.25) for g in d['gardensPx']],
          'units':[{'code':u['code'],'type':u['type'],'color':u['color'],'tt':u['tt'],**({'tim':u['tim']} if 'tim' in u else {}),**({'san':u['san']} if 'san' in u else {}),
                    'poly':m(u['polyPx'],.12)} for u in d['units']]})
    out[t]=T
js='/* Mặt bằng tầng Tòa F1, F5 – trích từ bản vẽ CĐT (màu căn + tỷ lệ theo diện tích thông thủy). Sinh bởi build_plans.py */\nwindow.FS_PLANS='+json.dumps(out,ensure_ascii=False,separators=(',',':'))+';\n'
(HERE/'plans-data.js').write_text(js,encoding='utf-8')
json.dump(IMG,open(HERE/'img-map.json','w'),indent=1)
for t,T in out.items(): print(t,T['W'],T['D'],T['mpp'],[ (b['key'],len(b['units'])) for b in T['bands']])
print('size',len(js))
