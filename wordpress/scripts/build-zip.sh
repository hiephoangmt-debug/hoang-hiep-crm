#!/usr/bin/env bash
# Đóng gói để cài trên hosting qua trang quản trị WordPress:
#   dist/hoanghiep.zip       → Giao diện → Thêm mới → Tải giao diện lên
#   dist/hoang-hiep-crm.zip  → Plugin → Cài mới → Tải plugin lên
#   dist/hoang-hiep-tron-goi.zip → cả 2 trong 1 file: tải vào public_html/wp-content rồi Giải nén (ghi đè themes/ và plugins/)
# Chạy từ thư mục wordpress/:  ./scripts/build-zip.sh
set -euo pipefail
cd "$(dirname "$0")/.."

rm -rf dist && mkdir -p dist/tmp/hoang-hiep-crm
cp -r wp-content/themes/hoanghiep dist/tmp/hoanghiep
cp packaging/hoang-hiep-crm.php dist/tmp/hoang-hiep-crm/
cp -r wp-content/mu-plugins/hh-crm dist/tmp/hoang-hiep-crm/hh-crm

(cd dist/tmp && zip -qr ../hoanghiep.zip hoanghiep -x '*.DS_Store' && zip -qr ../hoang-hiep-crm.zip hoang-hiep-crm -x '*.DS_Store')
mkdir -p dist/tmp/all/themes dist/tmp/all/plugins
mv dist/tmp/hoanghiep dist/tmp/all/themes/ && mv dist/tmp/hoang-hiep-crm dist/tmp/all/plugins/
(cd dist/tmp/all && zip -qr ../../hoang-hiep-tron-goi.zip themes plugins -x '*.DS_Store')
rm -rf dist/tmp
ls -lh dist
