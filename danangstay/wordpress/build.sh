#!/bin/sh
# Đóng gói plugin WordPress: copy landing page + logo mới nhất vào plugin rồi nén zip.
set -e
cd "$(dirname "$0")"
rm -rf danangstay-landing/landing
mkdir -p danangstay-landing/landing
cp ../index.html danangstay-landing/landing/
cp -r ../logo danangstay-landing/landing/logo
rm -f danangstay-landing/landing/logo/preview.html
rm -f danangstay-landing.zip
zip -qr danangstay-landing.zip danangstay-landing
echo "Đã tạo $(pwd)/danangstay-landing.zip"
