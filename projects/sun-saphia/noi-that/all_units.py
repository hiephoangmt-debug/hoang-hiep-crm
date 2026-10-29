"""Chạy render nội thất luxury cho tất cả căn (bỏ qua ảnh đã có). Thứ tự: tầng 30 → sân vườn tầng 2–3 → tầng điển hình → video tham quan HQ."""
import json, os, subprocess, sys
S = os.path.dirname(os.path.abspath(__file__)); C = json.load(open(S + '/ccl2.json'))
SHOT = {'1PN+1': 'living,living2,bed,plus,top', '2PN': 'living,living2,bed,plus,top', '2PN1': 'living,living2,bed,plus,top', 'STU': 'living,living2,top', 'STUL': 'living,living2,top', '2PN11': 'living,living2,bed,plus,top', '2PNT': 'living,living2,bed,plus,top', '2PN1L': 'living,living2,bed,top', '1PN+1L': 'living,living2,bed,plus,top'}
def main_lay(parts): return max(parts, key=lambda p: C['spec'][p[0]]['W'] * C['spec'][p[0]]['D'] * max(abs(p[1][0]), abs(p[1][1])))[0]
JOBS = []
PRI = ['11', '18', '19']   # căn vừa sửa layout chạy trước
for k in PRI + [k for k in sorted(C['u']) if k not in PRI]: JOBS.append(('u', k, 'T-' + k, SHOT[main_lay(C['u'][k])], {'FLOOR_H': '64'}))
for k in C['u30']:
    JOBS.append(('u30', k, '30-' + k, SHOT[main_lay(C['u30'][k])], {'FLOOR_H': '108'}))
for g, fh in (('T3', '13'), ('T2', '8.6')):
    for k in C['gard'][g]: JOBS.append(('u', k, 'G' + g[1] + '-' + k, 'garden,top', {'FLOOR_H': fh, 'GARD': g}))
for key, uid, name, shots, env in JOBS:
    out = S + '/rAll/' + name; need = [s for s in shots.split(',') if not os.path.exists(out + '/' + s + '.png')]
    if not need: continue
    e = dict(os.environ, STYLE='lux', EXPO='1.25', SUNROT='0', **env)
    print('>>', name, need, flush=True)
    subprocess.run([S + '/bvenv/bin/python', S + '/bl/room.py', S + '/ccl2.json', key, uid, out, ','.join(need), '40', '864x1080'], env=e, stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
print('XONG ANH', flush=True)
subprocess.run(['bash', S + '/tour_hq.sh'])
print('XONG TAT CA', flush=True)
