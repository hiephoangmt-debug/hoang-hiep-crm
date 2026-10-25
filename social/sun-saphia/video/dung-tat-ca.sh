#!/bin/sh
# Dựng toàn bộ video (chạy trong thư mục video/)
for d in v2-vi-tri v3-mat-bang v4-phap-ly v5-dong-tien v6-vi-sao-sun-group v7-tien-ich-bien v8-mo-ban-dat-cho; do
  python3 render.py $d/scenes.json $d/$d.mp4 || exit 1
done
