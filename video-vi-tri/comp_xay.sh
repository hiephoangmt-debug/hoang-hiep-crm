#!/bin/bash
# Dựng lại lớp chữ + 2 lớp thương hiệu rồi ghép 2 bản video xây dựng (Hoàng Hiệp, TATILAND).
set -e
cd "$(dirname "$0")"
FRAMES=1230 PAGE=xay.html node render_sig.mjs mov out5/text.mov &
FRAMES=1230 PAGE=brand_xay.html node render_sig.mjs mov out5/brand.mov &
FRAMES=1230 PAGE=brand_tati_xay.html node render_sig.mjs mov out5/brand_tati.mov &
wait
for v in "brand:HoangHiep_v3" "brand_tati:TATILAND_v2"; do
  B=${v%%:*}; N=${v##*:}
  ffmpeg -y -loglevel error -loop 1 -framerate 30 -i out5/bg.png -i ../build/out/photo.mp4 -i out5/text.mov -i out5/$B.mov -i vo/bgm.mp3 -i out5/sfx.wav -filter_complex \
   "[0:v][1:v]overlay=0:400:shortest=1[a];[a][2:v]overlay=0:0[b];[b][3:v]overlay=0:0,format=yuv420p[v];[4:a]atrim=0:41,afade=t=in:d=0.6,afade=t=out:st=38:d=3,volume=0.9[m];[5:a]apad[s];[m][s]amix=inputs=2:duration=first:normalize=0,loudnorm=I=-14:TP=-1.5[au]" \
   -map "[v]" -map "[au]" -t 41 -c:v libx264 -preset slow -crf 18 -c:a aac -b:a 192k -movflags +faststart out5/Sun_Saphia_XayDung_$N.mp4
done
ffmpeg -y -loglevel error -i out5/Sun_Saphia_XayDung_TATILAND_v2.mp4 -i out5/Sun_Saphia_XayDung_HoangHiep_v3.mp4 -filter_complex "[0:v]trim=end_frame=1,scale=360:-1[a];[1:v]trim=end_frame=1,scale=360:-1[b];[a][b]hstack" -frames:v 1 out5/first.jpg
ls -la out5/*_v2.mp4 out5/*_v3.mp4
