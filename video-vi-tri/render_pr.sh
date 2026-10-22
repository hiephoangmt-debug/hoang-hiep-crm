#!/bin/bash
# Xuất video PR có giọng đọc: 2 nửa hình song song, lớp Hoàng Hiệp, rồi trộn giọng + hiệu ứng.
set -e
cd "$(dirname "$0")"
export MAIN=explainer.html QS=cfg=ex_pr.js
node render.mjs video out4/a.mp4 0 2400 > out4/a.log 2>&1 &
node render.mjs video out4/b.mp4 2400 4815 > out4/b.log 2>&1 &
wait
FRAMES=4815 PAGE=brand_pr.html node render_sig.mjs mov out4/brand.mov > out4/brand.log 2>&1
printf "file 'a.mp4'\nfile 'b.mp4'\n" > out4/list.txt
ffmpeg -y -loglevel error -f concat -safe 0 -i out4/list.txt -c copy out4/silent.mp4
# giọng: trễ 0,3 s, lọc ồn thấp, nén nhẹ; hiệu ứng nhỏ hơn giọng
ffmpeg -y -loglevel error -i out4/silent.mp4 -i out4/brand.mov -i vo/pr.mp3 -i out/pr_sfx.wav -filter_complex \
 "[0:v][1:v]overlay=0:0:format=auto,format=yuv420p[v];\
  [2:a]adelay=300|300,highpass=f=70,acompressor=threshold=-20dB:ratio=3:attack=5:release=120,aformat=channel_layouts=stereo,volume=1.0[vo];\
  [3:a]volume=0.55[fx];[vo][fx]amix=inputs=2:duration=longest:normalize=0,loudnorm=I=-14:TP=-1.5:LRA=11[a]" \
 -map "[v]" -map "[a]" -c:v libx264 -preset slow -crf 18 -c:a aac -b:a 192k -t 160.5 -movflags +faststart out4/Sun_Saphia_PR_HoangHiep.mp4
ffmpeg -y -loglevel error -i out4/Sun_Saphia_PR_HoangHiep.mp4 -c:v libx264 -preset slow -crf 24 -maxrate 6M -bufsize 12M -pix_fmt yuv420p -c:a copy -movflags +faststart out4/Sun_Saphia_PR_HoangHiep_nhe.mp4
ls -la out4/*.mp4
