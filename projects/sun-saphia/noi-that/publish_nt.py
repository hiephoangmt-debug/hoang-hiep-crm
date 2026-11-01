"""Đóng dấu ảnh render (rAll/<tên>/<góc>.png) → images/noi-that/sp-<tên>-<góc>.webp (+ bản CRM sạch), rồi ghi danh sách vào chọn căn (NT-DATA).
Căn chưa render lại giữ nguyên ảnh đã đăng."""
import json, os, re, subprocess
S = os.path.dirname(os.path.abspath(__file__)); R = '/home/user/hoang-hiep-crm/projects/sun-saphia'
C = json.load(open(S + '/ccl2.json')); OUT = R + '/images/noi-that'; OUTC = R + '/images/noi-that-crm'; os.makedirs(OUTC, exist_ok=True)
def lay(name):
    k, uid = name.split('-', 1); parts = C['u30'][uid] if k == '30' else C['u'][uid]
    return max(parts, key=lambda p: C['spec'][p[0]]['W'] * C['spec'][p[0]]['D'])[0]
CAP = {'living': 'Phòng khách', 'living2': 'Nhìn từ lô-gia vào', 'bed': 'Phòng ngủ', 'plus': 'Phòng +1', 'garden': 'Sân vườn riêng', 'top': 'Mặt bằng 3D'}
ORDER = ['garden', 'living', 'living2', 'bed', 'plus', 'top']
p = R + '/chon-can/chon-can.html'; s = open(p, encoding='utf-8').read()
m = re.search(r'/\*NT-DATA\*/(.*?)/\*/NT-DATA\*/', s, re.S); old = m.group(1)
PUB = set(re.findall(r"'([0-9A-Z]+-[0-9A-Z]+)':\{img", old)) | set(re.findall(r'"([0-9A-Z]+-[0-9A-Z]+)":\{"img"', old))   # các căn đã đăng
NEW = set(os.listdir(S + '/rAll')); nt = {}
for name in sorted(NEW | PUB):
    d = S + '/rAll/' + name; L = lay(name); items = []
    for shot in ORDER:
        f = d + '/' + shot + '.png'; cap = CAP[shot]
        if shot == 'plus' and L.startswith('2PN'): cap = 'Phòng ngủ 2'
        if shot == 'living2' and L.startswith('STU'): cap = 'Nhìn về bếp & cửa vào'
        if shot == 'top' and name.startswith('G'): cap = 'Mặt bằng 3D có sân vườn'
        fn = 'sp-%s-%s.webp' % (name.lower(), shot)
        if not os.path.exists(f) or os.path.getsize(f) < 20000:   # chưa render lại: giữ ảnh đã đăng
            if os.path.exists(OUTC + '/' + fn): items.append([fn, cap])
            continue
        if shot == 'top':
            src = d + '/top_ban.png'; subprocess.run(['python3', S + '/compose_top.py', d, name, src], check=True)
            srcc = d + '/top_ban_crm.png'; subprocess.run(['python3', S + '/compose_top.py', d, name, srcc], check=True, env=dict(os.environ, CRM='1'))
        else: src = srcc = f
        dst, dc = OUT + '/' + fn, OUTC + '/' + fn
        if shot == 'top' or not os.path.exists(dst) or os.path.getmtime(dst) < os.path.getmtime(f):
            subprocess.run(['python3', S + '/wmk2.py', src, dst, 'Nội thất minh họa, thông số theo CĐT'], check=True)
        if shot == 'top' or not os.path.exists(dc) or os.path.getmtime(dc) < os.path.getmtime(f):
            subprocess.run(['python3', S + '/wmk_crm.py', srcc, dc, 'Nội thất minh họa, thông số theo CĐT'], check=True)
        items.append([fn, cap])
    if items: nt[name] = {'img': items}
_k = re.search(r"'30-10':\{.*?vid:'[^']*'\}", old); keep = _k.group(0) if _k else None   # căn 3010 giữ bộ ảnh + video cũ
if '30-10' in nt and len(nt['30-10']['img']) >= 5 and '30-10' in NEW: nt['30-10']['vid'] = 'sp3010-lux-video-9x16.mp4'; keep = None
else: nt.pop('30-10', None)
body = json.dumps(nt, ensure_ascii=False, separators=(',', ':'))[1:-1]
data = '{' + ((keep + (',' if body else '')) if keep else '') + body + '}'
s = s[:m.start(1)] + data + s[m.end(1):]; open(p, 'w', encoding='utf-8').write(s)
print(len(nt) + (1 if keep else 0), 'căn', sum(len(v['img']) for v in nt.values()), 'ảnh')
