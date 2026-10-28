"""Đóng dấu ảnh render (rAll/<tên>/<góc>.png) → images/noi-that/<tên>-<góc>.webp, rồi ghi danh sách vào chọn căn (NT-DATA)."""
import json, os, re, subprocess
from PIL import Image
S = os.path.dirname(os.path.abspath(__file__)); R = '/home/user/hoang-hiep-crm/projects/sun-saphia'
C = json.load(open(S + '/ccl2.json')); OUT = R + '/images/noi-that'
def lay(name):
    k, uid = name.split('-', 1); parts = C['u30'][uid] if k == '30' else C['u'][uid]
    return max(parts, key=lambda p: C['spec'][p[0]]['W'] * C['spec'][p[0]]['D'])[0]
CAP = {'living': 'Phòng khách', 'living2': 'Nhìn từ lô-gia vào', 'bed': 'Phòng ngủ', 'plus': 'Phòng +1', 'garden': 'Sân vườn riêng', 'top': 'Mặt bằng 3D'}
ORDER = ['garden', 'living', 'living2', 'bed', 'plus', 'top']
nt = {}
for name in sorted(os.listdir(S + '/rAll')):
    d = S + '/rAll/' + name; L = lay(name); items = []
    for shot in ORDER:
        f = d + '/' + shot + '.png'
        if not os.path.exists(f) or os.path.getsize(f) < 20000: continue
        cap = CAP[shot]
        if shot == 'plus' and L.startswith('2PN'): cap = 'Phòng ngủ 2'
        if shot == 'living2' and L.startswith('STU'): cap = 'Nhìn về bếp & cửa vào'
        if shot == 'top' and name.startswith('G'): cap = 'Mặt bằng 3D có sân vườn'
        if shot == 'top': src = d + '/top_rot.png'; Image.open(f).rotate(90, expand=True).save(src)   # hướng biển lên trên như mặt bằng tầng
        else: src = f
        fn = ('sp-%s-%s.webp' % (name.lower(), shot))
        dst = OUT + '/' + fn
        if not os.path.exists(dst) or os.path.getmtime(dst) < os.path.getmtime(f):
            subprocess.run(['python3', S + '/wmk2.py', src, dst, 'Nội thất luxury minh họa, thông số theo CĐT · 0904567009'], check=True)
        items.append([fn, cap])
    if items: nt[name] = {'img': items}
p = R + '/chon-can/chon-can.html'; s = open(p, encoding='utf-8').read()
m = re.search(r'/\*NT-DATA\*/(.*?)/\*/NT-DATA\*/', s, re.S); old = m.group(1)
keep = re.search(r"'30-10':\{.*?vid:'[^']*'\}", old).group(0)     # căn 3010 giữ bộ ảnh + video đã duyệt
nt.pop('30-10', None)
data = '{' + keep + (',' if nt else '') + json.dumps(nt, ensure_ascii=False, separators=(',', ':'))[1:-1] + '}'
s = s[:m.start(1)] + data + s[m.end(1):]; open(p, 'w', encoding='utf-8').write(s)
print(len(nt), 'căn', sum(len(v['img']) for v in nt.values()), 'ảnh')
