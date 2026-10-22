#!/bin/bash
# Trộn lại âm thanh video PR: giọng đọc + nhạc nền (tự hạ khi có giọng) + hiệu ứng.
set -e
cd "$(dirname "$0")"
ffmpeg -y -loglevel error -i out4/silent.mp4 -i out4/brand.mov -i vo/pr.mp3 -i out/pr_sfx.wav -i out4/bgm_loop.wav -filter_complex \
 "[0:v][1:v]overlay=0:0:format=auto,format=yuv420p[v];\
  [2:a]adelay=300|300,highpass=f=70,acompressor=threshold=-20dB:ratio=3:attack=5:release=120,aformat=channel_layouts=stereo,asplit=2[vo][key];\
  [4:a]volume=0.55[bg0];[bg0][key]sidechaincompress=threshold=0.03:ratio=5:attack=40:release=500:makeup=1[bg];\
  [3:a]volume=0.45[fx];[vo][bg][fx]amix=inputs=3:duration=longest:normalize=0,loudnorm=I=-14:TP=-1.5:LRA=11[a]" \
 -map "[v]" -map "[a]" -c:v libx264 -preset slow -crf 18 -c:a aac -b:a 192k -t 160.5 -movflags +faststart out4/Sun_Saphia_PR_HoangHiep.mp4
ffmpeg -y -loglevel error -i out4/Sun_Saphia_PR_HoangHiep.mp4 -c:v libx264 -preset slow -crf 24 -maxrate 6M -bufsize 12M -pix_fmt yuv420p -c:a copy -movflags +faststart out4/Sun_Saphia_PR_HoangHiep_nhe.mp4
ls -la out4/*.mp4
