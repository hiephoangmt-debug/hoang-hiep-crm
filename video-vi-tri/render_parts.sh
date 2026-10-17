#!/usr/bin/env bash
# Render video theo từng đoạn 150 khung (5 giây). Đoạn nào xong rồi thì bỏ qua -> chạy lại được nếu bị dừng.
cd "$(dirname "$0")"
mkdir -p out/parts
TOTAL=${TOTAL:-1800}; STEP=150
for ((s=0; s<TOTAL; s+=STEP)); do
  e=$((s+STEP)); [ $e -gt $TOTAL ] && e=$TOTAL
  f=$(printf "out/parts/p_%04d.mp4" $s)
  [ -s "$f" ] && continue
  for try in 1 2 3; do
    QS=aa=0 node render.mjs video "$f.tmp.mp4" $s $e && mv "$f.tmp.mp4" "$f" && break
    echo "đoạn $s lỗi, thử lại ($try)"
  done
  [ -s "$f" ] || { echo "đoạn $s thất bại"; exit 1; }
done
ls out/parts/p_*.mp4 | sed "s/^out\/parts\//file '/; s/$/'/" > out/parts/list.txt
ffmpeg -y -loglevel error -f concat -safe 0 -i out/parts/list.txt -c copy out/video_silent.mp4
python3 music.py out/music.wav
ffmpeg -y -loglevel error -i out/video_silent.mp4 -i out/music.wav -c:v copy -c:a aac -b:a 192k -shortest -movflags +faststart out/video.mp4
echo "XONG out/video.mp4"
