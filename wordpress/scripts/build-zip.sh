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

# Gói cập nhật nhanh (Dự án → Nhập nhanh → chọn .zip, làm được trên điện thoại): chỉ code + ảnh/font thay đổi trong
# PATCH_DAYS ngày gần nhất (mặc định 2) – tệp không có trong gói giữ nguyên trên web, nên gói nhẹ (< 2 MB).
PATCH_DAYS="${PATCH_DAYS:-2}"
mkdir -p dist/tmp/hoang-hiep-crm
cp packaging/hoang-hiep-crm.php dist/tmp/hoang-hiep-crm/
(cd wp-content/mu-plugins && find hh-crm -type f \( -name '*.php' -o -name '*.js' -o -name '*.css' -o -name '*.json' -o -name '*.md' \) -exec cp --parents {} ../../dist/tmp/hoang-hiep-crm/ \;)
(cd wp-content/themes && find hoanghiep -type f \( -name '*.php' -o -name '*.js' -o -name '*.css' -o -name '*.json' -o -name '*.txt' \) -exec cp --parents {} ../../dist/tmp/ \;)
git log --relative --since="${PATCH_DAYS} days ago" --name-only --pretty=format: -- wp-content/mu-plugins/hh-crm wp-content/themes/hoanghiep | sort -u | while read -r f; do
	[ -f "$f" ] || continue
	case "$f" in
		wp-content/mu-plugins/*) (cd wp-content/mu-plugins && cp --parents "${f#wp-content/mu-plugins/}" ../../dist/tmp/hoang-hiep-crm/) ;;
		wp-content/themes/*) (cd wp-content/themes && cp --parents "${f#wp-content/themes/}" ../../dist/tmp/) ;;
	esac
done
(cd dist/tmp && zip -qr ../cap-nhat-nhanh.zip hoang-hiep-crm hoanghiep -x '*.DS_Store')
rm -rf dist/tmp
ls -lh dist
