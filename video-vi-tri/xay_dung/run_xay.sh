#!/bin/bash
# Xuất video xây dựng 41 s: ảnh động (2 nửa song song) + lớp chữ + lớp Hoàng Hiệp + nhạc nền.
set -e
cd "$(dirname "$0")"
python3 build.py out/p1.mp4 0 615 > out/p1.log 2>&1 &
python3 build.py out/p2.mp4 615 1230 > out/p2.log 2>&1 &
wait
printf "file 'p1.mp4'\nfile 'p2.mp4'\n" > out/list.txt
ffmpeg -y -loglevel error -f concat -safe 0 -i out/list.txt -c copy out/photo.mp4
cd ../vid
PAGE="xay.html?bg=1" node render_sig.mjs png 0 && mv out/sig_0000.png out5/bg.png
FRAMES=1230 PAGE=xay.html node render_sig.mjs mov out5/text.mov
FRAMES=1230 PAGE=brand_xay.html node render_sig.mjs mov out5/brand.mov
ffmpeg -y -loglevel error -loop 1 -framerate 30 -i out5/bg.png -i ../build/out/photo.mp4 -i out5/text.mov -i out5/brand.mov -i vo/bgm.mp3 -i out5/sfx.wav -filter_complex \
 "[0:v][1:v]overlay=0:400:shortest=1[a];[a][2:v]overlay=0:0[b];[b][3:v]overlay=0:0,format=yuv420p[v];[4:a]atrim=0:41,afade=t=in:d=0.6,afade=t=out:st=38:d=3,volume=0.9[m];[5:a]apad[s];[m][s]amix=inputs=2:duration=first:normalize=0,loudnorm=I=-14:TP=-1.5[au]" \
 -map "[v]" -map "[au]" -t 41 -c:v libx264 -preset slow -crf 18 -c:a aac -b:a 192k -movflags +faststart out5/Sun_Saphia_XayDung_HoangHiep_v2.mp4
ffprobe -v error -show_entries format=duration -of csv=p=0 out5/Sun_Saphia_XayDung_HoangHiep_v2.mp4
