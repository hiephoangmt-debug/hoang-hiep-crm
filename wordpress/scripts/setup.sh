#!/usr/bin/env bash
# Cài đặt WordPress lần đầu cho hiephoangmt.com:
# tạo admin, kích hoạt theme Hoàng Hiệp, tạo trang & menu, cấu hình permalink.
# Chạy từ thư mục wordpress/:  ./scripts/setup.sh
set -euo pipefail

cd "$(dirname "$0")/.."

if [[ ! -f .env ]]; then
	echo "Thiếu file .env – hãy chạy: cp .env.example .env và sửa mật khẩu." >&2
	exit 1
fi
set -a; source .env; set +a

wp() { docker compose run --rm wpcli wp "$@"; }

echo "→ Chờ WordPress khởi động…"
for _ in $(seq 1 30); do
	if wp core version >/dev/null 2>&1; then break; fi
	sleep 3
done

if ! wp core is-installed >/dev/null 2>&1; then
	wp core install \
		--url="$SITE_URL" \
		--title="$SITE_TITLE" \
		--admin_user="$WP_ADMIN_USER" \
		--admin_password="$WP_ADMIN_PASSWORD" \
		--admin_email="$WP_ADMIN_EMAIL" \
		--skip-email
fi

wp language core install vi --activate || true
wp option update timezone_string "Asia/Ho_Chi_Minh"
wp option update date_format "d/m/Y"
wp option update blogdescription "Bất động sản Đà Nẵng – dự án, mua bán & cho thuê"
wp theme activate hoanghiep
wp rewrite structure '/%postname%/' --hard

# Xoá nội dung mẫu
wp post delete 1 --force >/dev/null 2>&1 || true
wp post delete 2 --force >/dev/null 2>&1 || true

ensure_page() { # slug title content
	local id
	id=$(wp post list --post_type=page --name="$1" --field=ID --format=ids)
	if [[ -z "$id" ]]; then
		id=$(wp post create --post_type=page --post_status=publish --post_name="$1" --post_title="$2" --post_content="$3" --porcelain)
	fi
	echo "$id"
}

HOME_ID=$(ensure_page trang-chu "Trang chủ" "")
NEWS_ID=$(ensure_page tin-tuc "Tin tức" "")
ensure_page gioi-thieu "Về Hiệp" "" >/dev/null
ensure_page lien-he "Liên hệ" "" >/dev/null

wp option update show_on_front page
wp option update page_on_front "$HOME_ID"
wp option update page_for_posts "$NEWS_ID"

# Loại dự án (Cao tầng / Thấp tầng), loại nhà đất và khu vực Đà Nẵng
# được plugin Hoàng Hiệp CRM tự tạo ở lần chạy đầu tiên.
wp eval 'hh_seed_terms();'

# Chuyên mục tin tức
wp term update category 1 --name="Thị trường Đà Nẵng" --slug=thi-truong-da-nang >/dev/null 2>&1 || true
for term in "Tin dự án" "Kinh nghiệm mua bán" "Pháp lý nhà đất"; do
	wp term create category "$term" >/dev/null 2>&1 || true
done

if ! wp menu list --fields=name --format=csv | grep -q "^Menu chính$"; then
	wp menu create "Menu chính"
	wp menu item add-custom "Menu chính" "Trang chủ" "$SITE_URL/"
	PROJECTS=$(wp menu item add-custom "Menu chính" "Dự án" "$SITE_URL/du-an/" --porcelain)
	HIGH=$(wp menu item add-custom "Menu chính" "Cao tầng" "$SITE_URL/loai-du-an/cao-tang/" --parent-id="$PROJECTS" --porcelain)
	wp menu item add-custom "Menu chính" "Căn hộ sở hữu lâu dài" "$SITE_URL/loai-du-an/can-ho-so-huu-lau-dai/" --parent-id="$HIGH"
	wp menu item add-custom "Menu chính" "Căn hộ dịch vụ (50 năm)" "$SITE_URL/loai-du-an/can-ho-dich-vu/" --parent-id="$HIGH"
	LOW=$(wp menu item add-custom "Menu chính" "Thấp tầng" "$SITE_URL/loai-du-an/thap-tang/" --parent-id="$PROJECTS" --porcelain)
	wp menu item add-custom "Menu chính" "Biệt thự" "$SITE_URL/loai-du-an/biet-thu/" --parent-id="$LOW"
	wp menu item add-custom "Menu chính" "Đất nền" "$SITE_URL/loai-du-an/dat-nen/" --parent-id="$LOW"
	wp menu item add-custom "Menu chính" "Shophouse" "$SITE_URL/loai-du-an/shophouse/" --parent-id="$LOW"
	wp menu item add-custom "Menu chính" "Mua bán" "$SITE_URL/mua-ban/"
	wp menu item add-custom "Menu chính" "Cho thuê" "$SITE_URL/cho-thue/"
	wp menu item add-post "Menu chính" "$NEWS_ID" --title="Tin tức"
	wp menu item add-post "Menu chính" "$(wp post list --post_type=page --name=gioi-thieu --field=ID)"
	wp menu item add-post "Menu chính" "$(wp post list --post_type=page --name=lien-he --field=ID)"
	wp menu location assign "Menu chính" primary
	wp menu location assign "Menu chính" footer
fi

wp rewrite flush --hard
echo "✔ Xong! Truy cập $SITE_URL/wp-admin để quản trị."
