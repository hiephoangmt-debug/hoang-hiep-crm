#!/bin/bash
# Sau khi 2 đoạn bản đồ xuất xong: ghép cảnh, dựng lớp chữ 2 bản, trộn nhạc → video giới thiệu 60 s.
set -e
cd "$(dirname "$0")"
while kill -0 1783 2>/dev/null || kill -0 1784 2>/dev/null; do sleep 10; done
python3 scripts/build_sp.py
N=$(python3 -c "import json;print(round(json.load(open('public/sp_time.json'))['total']*30))")
FRAMES=$N PAGE='sp_ui.html?brand=hh' node render_sig.mjs mov out7/ui_hh.mov
FRAMES=$N PAGE='sp_ui.html?brand=tati' node render_sig.mjs mov out7/ui_tati.mov
for v in "hh:HoangHiep" "tati:TATILAND"; do
  B=${v%%:*}; NM=${v##*:}
  ffmpeg -y -loglevel error -i out7/base.mp4 -i out7/ui_$B.mov -i out7/music.wav -filter_complex \
   "[0:v][1:v]overlay=0:0,format=yuv420p[v];[2:a]afade=t=out:st=57.5:d=3,loudnorm=I=-14:TP=-1.5[a]" \
   -map "[v]" -map "[a]" -shortest -c:v libx264 -preset slow -crf 18 -c:a aac -b:a 192k -movflags +faststart out7/Sun_Saphia_GioiThieu_$NM.mp4
done
ls -la out7/*.mp4
