#!/bin/sh
# Tạo index.html (mở trực tiếp / GitHub Pages) từ app.html (bản Claude Artifact)
cd "$(dirname "$0")"
{ echo '<!doctype html><html lang="vi"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover"></head><body>'; cat app.html; echo '</body></html>'; } > index.html
