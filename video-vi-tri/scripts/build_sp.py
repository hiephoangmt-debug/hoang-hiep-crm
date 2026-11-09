# Ghép video giới thiệu Sun Saphia (60 s, 1080×1920): cảnh phim phối cảnh + flycam thật + 2 đoạn bản đồ, chuyển mờ 0,4 s.
import subprocess, json, os
MOV = '/root/.claude/uploads/5a3da34e-4b86-5751-9b08-70632a8c9629/ffbf0bf7-1K5K45GDF_31QAO9.mov'
FLY = '/root/.claude/uploads/5a3da34e-4b86-5751-9b08-70632a8c9629/899dc700-snaptik.vn_7702817009746201863'
X = 0.4   # thời gian chuyển mờ
# (tên, nguồn, giây bắt đầu, độ dài nguồn, độ dài ra, tâm cắt x trên 1280, phóng dần, mục)
SEG = [
  ('s01', FLY, 4.0, 3.2, 3.6, None, 1.35, 'hook'),
  ('s02', MOV, 24.0, 4.0, 4.6, 742, 1.06, 'tower'),
  ('s03', MOV, 56.0, 2.0, 2.2, 790, 1.05, 'tower'),
  ('s04', MOV, 58.0, 1.6, 1.8, 480, 1.04, 'tower'),
  ('s05', MOV, 66.0, 3.0, 3.0, 660, 1.05, 'orbit'),
  ('s06', MOV, 77.4, 2.2, 2.8, 730, 1.05, 'orbit'),
  ('s07', MOV, 84.0, 2.8, 2.8, 640, 1.04, 'orbit'),
  ('s08', FLY, 14.0, 2.0, 2.2, None, 1.08, 'orbit'),
  ('s09', FLY, 16.0, 2.8, 2.8, None, 1.06, 'orbit'),
  ('s10', MOV, 156.0, 1.8, 2.0, 680, 1.05, 'orbit'),
  ('s11', 'out7/map_ht.mp4', 0, 7.0, 7.0, 'map', 1.0, 'infra'),
  ('s12', 'out7/map_ds.mp4', 0, 8.0, 8.0, 'map', 1.0, 'connect'),
  ('s13', MOV, 133.2, 2.6, 3.0, 704, 1.05, 'value'),
  ('s14', MOV, 127.6, 2.2, 3.0, 640, 1.05, 'value'),
  ('s15', MOV, 138.0, 2.4, 3.0, 640, 1.05, 'value'),
  ('s16', MOV, 59.6, 2.0, 3.0, 770, 1.05, 'value'),
  ('s17', MOV, 168.0, 2.2, 2.4, 480, 1.04, 'cta'),
  ('s18', MOV, 172.0, 1.4, 1.6, 770, 1.04, 'cta'),
  ('s19', MOV, 173.5, 5.8, 9.0, 800, 1.10, 'cta'),
]
WARM = 'colorbalance=rs=.06:gs=.01:bs=-.08:rm=.05:bm=-.06:rh=.04:bh=-.05,eq=saturation=1.05:gamma_r=1.02'
def run(c): subprocess.run(c, check=True)
for name, src, ss, sl, ol, cx, zoom, sec in SEG:
    out = f'out7/seg/{name}.mp4'
    if os.path.exists(out): continue
    n = round(ol * 30); sp = ol / sl
    if cx == 'map':
        vf = 'scale=1080:1920,setsar=1'
    else:
        if cx is None:
            base = f'scale=1080:1920:flags=lanczos,{WARM}'
        else:
            x0 = max(0, min(1280 - 405, cx - 202))
            base = f'crop=405:720:{x0}:0,scale=1080:1920:flags=lanczos'
        # phóng dần (đẩy máy) bằng zoompan-free: scale theo thời gian rồi cắt giữa
        z = f"scale='1080*(1+({zoom}-1)*t/{ol})':'1920*(1+({zoom}-1)*t/{ol})':eval=frame:flags=bicubic,crop=1080:1920"
        vf = f"{base},setpts={sp}*(PTS-STARTPTS),framerate=fps=30,{z},cas=strength=0.45,setsar=1,format=yuv420p"
    run(['ffmpeg', '-y', '-loglevel', 'error', '-ss', str(ss), '-t', str(sl + 0.1), '-i', src, '-an', '-vf', vf, '-frames:v', str(n), '-r', '30',
         '-c:v', 'libx264', '-preset', 'medium', '-crf', '15', '-pix_fmt', 'yuv420p', out])
    print('ok', name, flush=True)
# nối bằng xfade
inputs = []; fc = []; t = 0; prev = '[0:v]'; starts = []
for i, s in enumerate(SEG):
    inputs += ['-i', f'out7/seg/{s[0]}.mp4']
    if i == 0: starts.append(0.0); t = s[4]; continue
    off = t - X; starts.append(off)
    fc.append(f'{prev}[{i}:v]xfade=transition=fade:duration={X}:offset={off:.3f}[v{i}]'); prev = f'[v{i}]'; t = off + s[4]
run(['ffmpeg', '-y', '-loglevel', 'error', *inputs, '-filter_complex', ';'.join(fc), '-map', prev, '-r', '30', '-c:v', 'libx264', '-preset', 'slow', '-crf', '16', '-pix_fmt', 'yuv420p', 'out7/base.mp4'])
sec = {}
for s, st in zip(SEG, starts): sec.setdefault(s[7], [st, st + s[4]]); sec[s[7]][1] = st + s[4]
json.dump(dict(total=round(t, 3), sections=sec), open('public/sp_time.json', 'w'), indent=1)
open('public/sp_time.js', 'w').write('window.SPT = ' + json.dumps(dict(total=round(t, 3), sections=sec)) + ';')
print('tổng', round(t, 2), 's'); print(json.dumps(sec))
