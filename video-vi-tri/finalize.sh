#!/usr/bin/env bash
# Ghép lớp chữ ký lên video đã render: out/video.mp4 + out/sig.mov -> out/video_final.mp4
cd "$(dirname "$0")"
[ -s out/sig.mov ] || node render_sig.mjs mov out/sig.mov
ffmpeg -y -loglevel error -i out/video.mp4 -i out/sig.mov -filter_complex "[0:v][1:v]overlay=0:0:format=auto,format=yuv420p[v]" \
  -map "[v]" -map 0:a -c:v libx264 -preset slow -crf 17 -c:a copy -movflags +faststart out/video_final.mp4
echo "XONG out/video_final.mp4"
