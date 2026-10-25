"""Cắt cảnh từ phim chủ đầu tư (16:9) thành clip dọc 1080x1920 đúng độ dài từng câu."""
import json, subprocess
TC = json.load(open("thoi-gian-cau.json")); S = lambda i: TC[i - 1][0]
CLIPS = [  # tên, từ, đến (đầu ra), nguồn từ, đến, kiểu, tâm x (0-1)
    ("p-mo-dau", 0.0, S(2), 23.5, 28.6, "crop", 0.60),
    ("p-truoc-toa", S(5), S(6), 102.0, 104.2, "punch", 0.5),
    ("p-thap", S(11), S(12), 56.0, 59.5, "crop", 0.48),
    ("p-ho-boi", S(13), S(14), 104.4, 108.3, "punch", 0.5),
    ("p-thap-chieu", S(15), S(16), 155.5, 158.5, "crop", 0.53),
]
import os, sys
only = sys.argv[1:]
for name, a, b, s, e, mode, cx in CLIPS:
    if only and name not in only: continue
    n = round((b - a) * 30) + 2; f = (b - a) / (e - s)
    pre = f"trim={s}:{e},setpts=(PTS-STARTPTS)*{f:.4f},minterpolate=fps=30:mi_mode=mci:mc_mode=aobmc:vsbmc=1"
    if mode == "crop":
        vf = f"{pre},crop=405:720:{int(cx*1280-202)}:0,scale=1080:1920:flags=lanczos,unsharp=5:5:0.6"
        fc = f"[0:v]{vf}[v]"
    else:
        fc = (f"[0:v]{pre},split[a][b];[a]scale=-2:1920,crop=1080:1920,boxblur=28:2,eq=brightness=-0.12[bg];"
              f"[b]scale=1566:-2,crop=1080:ih[fg];[bg][fg]overlay=0:(H-h)/2-150[v]")
    subprocess.run(["ffmpeg", "-v", "error", "-y", "-i", "phim-cdt.mp4", "-filter_complex", fc, "-map", "[v]", "-an",
                    "-frames:v", str(n), "-c:v", "libx264", "-crf", "15", "-preset", "veryfast", f"{name}.mp4"], check=True)
    print(name, round(b - a, 2), n)
json.dump([[c[0], c[1], c[2]] for c in CLIPS], open("clips.json", "w"))
