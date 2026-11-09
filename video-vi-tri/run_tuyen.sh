#!/bin/bash
# Xuất video hành trình ven biển (45 s): bản đồ 2 nửa song song + lớp chữ + 2 lớp thương hiệu + nhạc nền.
set -e
cd "$(dirname "$0")"
export MAIN=index.html QS="cfg=config3.js&aa=0"
node render.mjs video out6/a.mp4 0 680 > out6/a.log 2>&1 &
node render.mjs video out6/b.mp4 680 1350 > out6/b.log 2>&1 &
wait
printf "file 'a.mp4'\nfile 'b.mp4'\n" > out6/list.txt
ffmpeg -y -loglevel error -f concat -safe 0 -i out6/list.txt -c copy out6/map.mp4
FRAMES=1350 PAGE=tuyen_ui.html node render_sig.mjs mov out6/ui.mov &
FRAMES=1350 PAGE=brand_tuyen.html node render_sig.mjs mov out6/hh.mov &
FRAMES=1350 PAGE=brand_tati_tuyen.html node render_sig.mjs mov out6/tati.mov &
wait
BGM=vo/bgm.mp3
for v in "hh:HoangHiep" "tati:TATILAND"; do
  B=${v%%:*}; N=${v##*:}
  ffmpeg -y -loglevel error -i out6/map.mp4 -i out6/ui.mov -i out6/$B.mov -stream_loop -1 -i $BGM -i out6/sfx.wav -filter_complex \
   "[0:v][1:v]overlay=0:0[a];[a][2:v]overlay=0:0,format=yuv420p[v];[3:a]atrim=0:45,afade=t=in:d=0.6,afade=t=out:st=42:d=3,volume=0.85[m];[4:a]apad[s];[m][s]amix=inputs=2:duration=first:normalize=0,loudnorm=I=-14:TP=-1.5[au]" \
   -map "[v]" -map "[au]" -t 45 -c:v libx264 -preset slow -crf 18 -c:a aac -b:a 192k -movflags +faststart out6/Sun_Saphia_HanhTrinh_HoiAn_$N.mp4
done
ls -la out6/*.mp4
