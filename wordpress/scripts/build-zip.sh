#!/usr/bin/env bash
# Đóng gói để cài trên hosting qua trang quản trị WordPress:
#   dist/hoanghiep.zip       → Giao diện → Thêm mới → Tải giao diện lên
#   dist/hoang-hiep-crm.zip  → Plugin → Cài mới → Tải plugin lên
# Chạy từ thư mục wordpress/:  ./scripts/build-zip.sh
set -euo pipefail
cd "$(dirname "$0")/.."

rm -rf dist && mkdir -p dist/tmp/hoang-hiep-crm
cp -r wp-content/themes/hoanghiep dist/tmp/hoanghiep
cp packaging/hoang-hiep-crm.php dist/tmp/hoang-hiep-crm/
cp -r wp-content/mu-plugins/hh-crm dist/tmp/hoang-hiep-crm/hh-crm

(cd dist/tmp && zip -qr ../hoanghiep.zip hoanghiep -x '*.DS_Store' && zip -qr ../hoang-hiep-crm.zip hoang-hiep-crm -x '*.DS_Store')
rm -rf dist/tmp
ls -lh dist
