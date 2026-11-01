#!/bin/bash
# Chuỗi cập nhật: chọn căn → 4D → chọn căn → xem → CRM/live → SEO/ads. Đọc SHA hiện tại từ file live.
set -e
cd /home/user/hoang-hiep-crm
M="
Co-Authored-By: Claude Opus 5.5 <noreply@anthropic.com>
Claude-Session: https://claude.ai/code/session_01NC2CYpoTfJafqPT1uZGzKB"
L=projects/sun-saphia/live/trang-chu-sun-saphia-residence.html
A0=$(grep -o "hoang-hiep-crm@[0-9a-f]\{40\}/projects/sun-saphia/4d/sun-saphia-4d-embed.js" $L | head -1 | cut -c16-55)
B0=$(grep -o "hoang-hiep-crm@[0-9a-f]\{40\}/projects/sun-saphia/chon-can/chon-can-embed.js" $L | head -1 | cut -c16-55)
X0=$(grep -o "hoang-hiep-crm/[0-9a-f]\{40\}/projects/sun-saphia/xem/xem-du-an.html" projects/hai-minh-da-nang/crm/QuyenXem.gs | head -1 | cut -c16-55)
C0=$(grep -o "hoang-hiep-crm@[0-9a-f]\{40\}" projects/sun-saphia/seo/sun-saphia-residence-seo.html | head -1 | cut -c16-55)
OC1=$(grep -o "hoang-hiep-crm/[0-9a-f]\{40\}/projects/sun-saphia/chon-can/chon-can-app.html" projects/sun-saphia/4d/sun-saphia-4d.html | head -1 | cut -d/ -f2)
echo "cũ A=$A0 B=$B0 X=$X0 C=$C0 CC=$OC1"
git add -A projects/sun-saphia/images projects/sun-saphia/chon-can/chon-can.html projects/sun-saphia/noi-that; git commit -qm "${1:-Nội thất: cập nhật}$M" || true
(cd projects/sun-saphia/chon-can && python3 build-embed.py $A0 >/dev/null); git add -A projects/sun-saphia; git commit -qm "Chọn căn: bản mới$M"; C1=$(git rev-parse HEAD)
sed -i "s#hoang-hiep-crm/$OC1/projects/sun-saphia/chon-can/chon-can-app.html#hoang-hiep-crm/$C1/projects/sun-saphia/chon-can/chon-can-app.html#" projects/sun-saphia/4d/sun-saphia-4d.html
cp projects/sun-saphia/4d/sun-saphia-4d.html projects/hai-minh-da-nang/landing/4d/hai-minh-4d.html
python3 projects/sun-saphia/4d/build-embed.py >/dev/null; python3 projects/hai-minh-da-nang/landing/4d/build-embed.py >/dev/null
git add -A projects; git commit -qm "4D: mở chọn căn bản mới$M"; A=$(git rev-parse HEAD)
(cd projects/sun-saphia/chon-can && python3 build-embed.py $A >/dev/null); git add -A projects/sun-saphia/chon-can; git commit -qm "Chọn căn trỏ mô hình 4D mới$M"; B=$(git rev-parse HEAD)
(cd projects/sun-saphia/xem && python3 build-xem.py $A $B >/dev/null); git add -A projects/sun-saphia/xem; git commit -qm "Xem dự án trỏ bản mới$M"; X=$(git rev-parse HEAD)
F=$(git show --name-only --format= 8a4c9b34); sed -i "s/$A0/$A/g;s/$B0/$B/g;s/$X0/$X/g" $F; git commit -qam "Loader, CRM, 2 trang đang chạy trỏ bản mới$M"; C=$(git rev-parse HEAD)
sed -i "s/$C0/$C/g" projects/sun-saphia/ads/sun-saphia-ads.html projects/sun-saphia/seo/sun-saphia-residence-seo.html; git commit -qam "Trang SEO/thông tin dùng bản mới$M"; D=$(git rev-parse HEAD)
git pull -q --no-rebase origin claude/sweet-knuth-g4n4j5; git push -q origin claude/sweet-knuth-g4n4j5
echo "mới A=$A B=$B X=$X C=$C D=$D"; grep -c "$A" $L projects/sun-saphia/xem/xem-du-an.html; grep -c "$C" projects/sun-saphia/seo/sun-saphia-residence-seo.html
