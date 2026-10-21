#!/usr/bin/env bash
# Video 2: dựng lại video TATILAND (53,7 s) theo config2.js, nhạc nền + hiệu ứng âm thanh tự tổng hợp.
cd "$(dirname "$0")"
mkdir -p out2/parts
TOTAL=1610; STEP=150
for ((s=0; s<TOTAL; s+=STEP)); do
  e=$((s+STEP)); [ $e -gt $TOTAL ] && e=$TOTAL
  f=$(printf "out2/parts/p_%04d.mp4" $s)
  [ -s "$f" ] && continue
  for try in 1 2 3; do
    QS="aa=0&cfg=config2.js" node render.mjs video "$f.tmp.mp4" $s $e && mv "$f.tmp.mp4" "$f" && break
    echo "đoạn $s lỗi, thử lại ($try)"
  done
  [ -s "$f" ] || { echo "đoạn $s thất bại"; exit 1; }
done
ls out2/parts/p_*.mp4 | sed "s/^out2\/parts\//file '/; s/$/'/" > out2/parts/list.txt
ffmpeg -y -loglevel error -f concat -safe 0 -i out2/parts/list.txt -c copy out2/video_silent.mp4
MUSIC_BG=0 MUSIC_BOOM=0.12 MUSIC_CFG=config2.js MUSIC_DUR=53.667 MUSIC_CUTS="[150, 454, 650, 900, 1130, 1300]" MUSIC_END=1478 MUSIC_START_HIT=8 python3 music.py out2/music2.wav
[ -s out2/brand.mov ] || PAGE=brand2.html node render_sig.mjs mov out2/brand.mov
ffmpeg -y -loglevel error -i out2/video_silent.mp4 -i out2/brand.mov -i out2/music2.wav \
  -filter_complex "[0:v][1:v]overlay=0:0:format=auto,format=yuv420p[v]" \
  -map "[v]" -map 2:a -c:v libx264 -preset slow -crf 17 -c:a aac -b:a 192k -shortest -movflags +faststart out2/video_final.mp4
echo "XONG out2/video_final.mp4"
