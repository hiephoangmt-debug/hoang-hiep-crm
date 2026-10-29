"""Đóng dấu ảnh render (rAll/<tên>/<góc>.png) → images/noi-that/<tên>-<góc>.webp, rồi ghi danh sách vào chọn căn (NT-DATA)."""
import json, os, re, subprocess
from PIL import Image
S = os.path.dirname(os.path.abspath(__file__)); R = '/home/user/hoang-hiep-crm/projects/sun-saphia'
C = json.load(open(S + '/ccl2.json')); OUT = R + '/images/noi-that'; OUTC = R + '/images/noi-that-crm'; os.makedirs(OUTC, exist_ok=True)
def lay(name):
    k, uid = name.split('-', 1); parts = C['u30'][uid] if k == '30' else C['u'][uid]
    return max(parts, key=lambda p: C['spec'][p[0]]['W'] * C['spec'][p[0]]['D'])[0]
CAP = {'living': 'Phòng khách', 'living2': 'Nhìn từ lô-gia vào', 'bed': 'Phòng ngủ', 'plus': 'Phòng +1', 'garden': 'Sân vườn riêng', 'top': 'Mặt bằng 3D'}
ORDER = ['garden', 'living', 'living2', 'bed', 'plus', 'top']
nt = {}
NEW = set(os.listdir(S + '/rAll')); OLD = set(n for n in os.listdir(S + '/rAll_old') if n.startswith('30-')) if os.path.isdir(S + '/rAll_old') else set()   # tầng 30: dùng tạm ảnh cũ tới khi render lại xong
for name in sorted(NEW | OLD):
    d = S + ('/rAll/' if name in NEW else '/rAll_old/') + name; L = lay(name); items = []
    for shot in ORDER:
        f = d + '/' + shot + '.png'
        if not os.path.exists(f) or os.path.getsize(f) < 20000: continue
        cap = CAP[shot]
        if shot == 'plus' and L.startswith('2PN'): cap = 'Phòng ngủ 2'
        if shot == 'living2' and L.startswith('STU'): cap = 'Nhìn về bếp & cửa vào'
        if shot == 'top' and name.startswith('G'): cap = 'Mặt bằng 3D có sân vườn'
        if shot == 'top':   # mặt bằng 3D kiểu bản vẽ bán hàng: số đo, nhãn loại căn, sơ đồ vị trí
            src = d + '/top_ban.png'; subprocess.run(['python3', S + '/compose_top.py', d, name, src], check=True)
        else: src = f
        fn = ('sp-%s-%s.webp' % (name.lower(), shot))
        dst = OUT + '/' + fn
        if not os.path.exists(dst) or os.path.getmtime(dst) < os.path.getmtime(f) or shot == 'top':
            subprocess.run(['python3', S + '/wmk2.py', src, dst, 'Nội thất luxury minh họa, thông số theo CĐT · 0904567009'], check=True)
        dc = OUTC + '/' + fn   # bản CRM nội bộ: không chữ chìm web, không số điện thoại
        if shot == 'top':
            srcc = d + '/top_ban_crm.png'; subprocess.run(['python3', S + '/compose_top.py', d, name, srcc], check=True, env=dict(os.environ, CRM='1'))
        else: srcc = f
        if not os.path.exists(dc) or os.path.getmtime(dc) < os.path.getmtime(f) or shot == 'top':
            subprocess.run(['python3', S + '/wmk_crm.py', srcc, dc, 'Nội thất minh họa, thông số theo CĐT'], check=True)
        items.append([fn, cap])
    if items: nt[name] = {'img': items}
p = R + '/chon-can/chon-can.html'; s = open(p, encoding='utf-8').read()
m = re.search(r'/\*NT-DATA\*/(.*?)/\*/NT-DATA\*/', s, re.S); old = m.group(1)
_k = re.search(r"'30-10':\{.*?vid:'[^']*'\}", old); keep = _k.group(0) if _k else None     # căn 3010 giữ bộ ảnh + video cũ cho tới khi có bản mới
if '30-10' in nt and len(nt['30-10']['img']) >= 5: nt['30-10']['vid'] = 'sp3010-lux-video-9x16.mp4'; keep = None   # SP3010 bản thoáng mới thay bộ cũ, giữ video
else: nt.pop('30-10', None)
body = json.dumps(nt, ensure_ascii=False, separators=(',', ':'))[1:-1]
data = '{' + ((keep + (',' if body else '')) if keep else '') + body + '}'
s = s[:m.start(1)] + data + s[m.end(1):]; open(p, 'w', encoding='utf-8').write(s)
print(len(nt), 'căn', sum(len(v['img']) for v in nt.values()), 'ảnh')
