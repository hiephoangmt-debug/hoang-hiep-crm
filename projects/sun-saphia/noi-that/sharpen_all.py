"""Làm nét lại toàn bộ ảnh nội thất đang đăng từ ảnh render gốc (rAll + bản chờ render lại ở hold/v5)."""
import os, subprocess
S = os.path.dirname(os.path.abspath(__file__)); R = '/home/user/hoang-hiep-crm/projects/sun-saphia/images'
n = 0
for base in ('rAll', 'hold/v5'):
    for name in os.listdir(S + '/' + base):
        for f in os.listdir(S + '/%s/%s' % (base, name)):
            if not f.endswith('.png') or f.startswith('top'): continue
            shot = f[:-4]; fn = 'sp-%s-%s.webp' % (name.lower(), shot); src = S + '/%s/%s/%s' % (base, name, f)
            if base == 'hold/v5' and os.path.exists(S + '/rAll/%s/%s' % (name, f)): continue
            if not os.path.exists(R + '/noi-that-crm/' + fn): continue
            subprocess.run(['python3', S + '/wmk2.py', src, R + '/noi-that/' + fn, 'Nội thất minh họa, thông số theo CĐT'], check=True)
            subprocess.run(['python3', S + '/wmk_crm.py', src, R + '/noi-that-crm/' + fn, 'Nội thất minh họa, thông số theo CĐT'], check=True); n += 1
print(n, 'ảnh đã làm nét')
