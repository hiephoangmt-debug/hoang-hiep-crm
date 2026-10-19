#!/usr/bin/env bash
# Bước cuối: nhạc + hiệu ứng âm thanh, lớp chữ ký/vệt sáng/watermark -> out/video_final.mp4
cd "$(dirname "$0")"
python3 music.py out/music.wav
[ -s out/sig.mov ] || node render_sig.mjs mov out/sig.mov
ffmpeg -y -loglevel error -i out/video_silent.mp4 -i out/sig.mov -i out/music.wav \
  -filter_complex "[0:v][1:v]overlay=0:0:format=auto,format=yuv420p[v]" \
  -map "[v]" -map 2:a -c:v libx264 -preset slow -crf 17 -c:a aac -b:a 192k -shortest -movflags +faststart out/video_final.mp4
echo "XONG out/video_final.mp4"
