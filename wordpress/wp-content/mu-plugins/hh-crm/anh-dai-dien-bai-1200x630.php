<?php
/**
 * Ảnh đại diện mới cho các bài đã đăng (anh Hiệp 13/11/2026): khổ 1200×630 – đúng khung thẻ bài trên web và ảnh xem trước
 * Facebook nên không bị cắt; nền là ảnh phối cảnh / ảnh thực tế của dự án, chữ tiêu đề bên trái (bai-viet/anh-dai-dien-1200x630.py).
 * Ảnh nằm trong kho code (wordpress/tu-dong/bia-bai/<slug>.jpg) – web tự tải về từng ảnh, gói cài không nặng.
 * Chạy dần: mỗi lần mở trang quản trị ~12 giây + nền (WP-Cron) mỗi 2 phút cho tới khi xong. Ảnh cũ vẫn giữ trong Thư viện.
 */

defined( 'ABSPATH' ) || exit;

function hh_bia_bai_slugs() {
	return array(
		'fpt-plaza-3-hoan-thanh-cap-so-hong-100-can-ho',
		'tra-cuu-du-an-ma-dinh-danh-bat-dong-san-thongtinbds-moc-gov-vn',
		'danh-thang-ngu-hanh-son-gan-sun-saphia-residence',
		'mat-bang-can-ho-the-legend-da-nang',
		'phi-quan-ly-sun-saphia-residence-moi-thang-bao-nhieu',
		'mat-bang-can-ho-symphony-5',
		'vsip-vi-tri-so-7-khu-thuong-mai-tu-do-da-nang-3525-ty',
		'dung-ten-mua-sun-saphia-residence-vo-chong-doanh-nghiep',
		'gia-nobu-residences-da-nang-bao-nhieu',
		'nguoi-nuoc-ngoai-viet-kieu-mua-sun-saphia-residence-duoc-khong',
		'gia-the-legend-da-nang-bao-nhieu',
		'tai-dinh-cu-huong-tra-duong-sat-toc-do-cao-hoa-lien-tuy-loan',
		'su-kien-gioi-thieu-sun-saphia-residence-15-11-2026',
		'can-2pn-sun-saphia-residence-60-70m2-o-hay-cho-thue',
		'gia-symphony-5-sun-symphony-residence-bao-nhieu',
		'nang-cap-san-bay-da-nang-1696-ty-sun-saphia-residence',
		'chi-phi-noi-that-studio-30m2-cho-thue-sun-saphia',
		'tu-cho-thue-hay-thue-don-vi-van-hanh-can-ho-sun-saphia',
		'khach-quoc-te-da-nang-2026-han-quoc-trung-quoc-thue-can-ho-sun-saphia',
		'da-nang-cong-bo-quy-hoach-chung-2050-aeon-mall-hoa-xuan-thang-11',
		'mua-du-lich-da-nang-cong-suat-phong-cho-thue-sun-saphia',
		'chon-day-can-sun-saphia-residence-mat-bien-canh-ben-phia-sau',
		'mat-bang-gia-can-ho-da-nang-11-2026',
		'dai-bien-truong-sa-ngu-hanh-son-resort-sun-saphia-residence',
		'da-nang-du-thao-nghi-quyet-tod-quanh-ga-duong-sat',
		'chuyen-nhuong-hop-dong-sun-saphia-residence-truoc-ban-giao',
		'can-ho-ven-bien-hoi-muoi-mua-bao-sun-saphia-residence',
		'gui-tiet-kiem-hay-mua-studio-sun-saphia-residence-cho-thue',
		'ho-tro-lai-suat-24-thang-sun-saphia-residence-tinh-thu',
		'cong-trinh-cap-1-la-gi-nien-han-100-nam-sun-saphia-residence',
		'tai-dinh-cu-duy-xuyen-duong-sat-toc-do-cao-392-ty',
		'chuan-bi-su-kien-ban-hang-sun-saphia-residence-28-11',
		'chinh-sach-ban-hang-du-an-sun-group-da-nang-thang-11-2026',
		'phi-booking-agoda-airbnb-cho-thue-can-ho-sun-saphia',
		'hoiana-beach-villas-7-dong-biet-thu-dien-tich-tien-ich',
		'quy-hoach-chung-do-thi-thang-dien-den-2050',
		'da-nang-chap-thuan-to-hop-25-tang-16-bach-dang-go-du-an-ton-dong',
		'thanh-toan-can-ho-hinh-thanh-tuong-lai-sun-saphia-residence',
		'chinh-sach-ban-hang-fours-tower-f2-thap-mai-thang-11-2026',
		'chinh-sach-ban-hang-fours-tower-f1-f5-thang-11-2026',
		'chinh-sach-ban-hang-s-light-tower-thang-11-2026',
		'chinh-sach-ban-hang-cora-tower-thang-11-2026',
		'chinh-sach-ban-hang-spana-tower-thang-11-2026',
		'sun-saphia-residence-hoi-dap-ban-giao-phi-quan-ly-cho-thue',
		'dau-tu-khach-san-da-nang-xay-moi-mua-lai-hay-mua-can-luu-tru',
		'chinh-sach-fours-tower-f2-17-10-2026-qua-noi-that-nha-xinh',
		'da-nang-an-dinh-thoi-han-khoi-cong-3-khu-do-thi-chu-lai',
		'thi-truong-can-ho-da-nang-quy-3-2026-sun-saphia-residence',
		'chinh-sach-moi-anh-huong-bat-dong-san-da-nang-11-2026',
		'quy-hoach-chung-do-thi-hoa-tien-da-nang-2050',
		'the-camellia-son-tra-tien-do-thang-11-2026',
		'penthouse-spana-cora-s-light-sun-neo-city',
		'dau-tu-cho-thue-da-nang-can-ho-luu-tru-biet-thu-nha-pho-shophouse',
		'cho-thue-ngan-ngay-can-ho-da-nang-phap-ly-thue',
		'gia-phong-khach-san-ven-bien-da-nang-2026-sun-saphia',
		'khach-du-lich-da-nang-2026-nhu-cau-thue-can-ho-ven-bien',
		'cong-vien-bien-truong-sa-2-45-ha-truoc-sun-saphia-residence',
		'vay-mua-sun-saphia-residence-tra-gop-hang-thang',
		'danh-gia-sun-saphia-residence-chi-tiet',
		'chi-phi-mua-can-ho-sun-saphia-residence-ngoai-gia-ban',
		'tien-ich-sun-saphia-residence-noi-khu-xung-quanh',
		'khu-du-lich-sinh-thai-ven-bien-ngu-hanh-son-trien-khai',
		'studio-sun-saphia-residence-30-m2-bo-tri-ai-nen-mua',
		'sun-saphia-residence-va-khu-do-thi-saphia-khac-nhau',
		'phan-luong-giao-thong-cau-hoa-xuan-tu-31-10-2026',
		'tien-do-sun-saphia-residence-mo-ban-ban-giao',
		'kinh-te-dem-bien-my-khe-da-nang-2026',
		'quy-hoach-chung-da-nang-2050-quyet-dinh-2016-qd-ttg',
		'co-nen-mua-sun-saphia-residence-uu-nhuoc-diem',
		'gia-dat-nam-viet-a-da-nang-10-2026',
		'dau-tu-sun-saphia-residence-cho-thue-dong-tien',
		'mua-can-ho-da-nang-tu-ha-noi-tp-hcm-kinh-nghiem',
		'phap-ly-sun-saphia-residence-so-huu-bao-lau',
		'can-ho-ven-bien-my-khe-son-thuy-non-nuoc-so-sanh',
		'sun-saphia-residence-o-dau-vi-tri',
		'giu-cho-booking-can-ho-moi-da-nang-can-biet',
		'mat-bang-can-ho-sun-saphia-residence',
		'du-an-can-ho-sun-group-da-nang-2026',
		'truong-tieu-hoc-cong-lap-khu-do-thi-sinh-thai-hoa-xuan',
		'gia-sun-saphia-residence-bao-nhieu',
		'mat-cat-cao-toc-noi-thi-da-nang-chu-lai-quy-dat-tod',
		'cai-tao-canh-quan-hai-bo-song-han-29-ha',
		'duong-sat-do-thi-san-bay-my-khe-hoi-an-bat-dong-san-huong-loi',
		'mo-rong-duong-vo-nguyen-giap-truong-sa-lac-long-quan-2633-ty',
		'studio-ven-bien-da-nang-gia-mua-gia-thue-2026',
		'cao-toc-noi-thi-da-nang-chu-lai-huong-tuyen-tien-do',
		'ban-khach-san-da-nang-ven-bien-gia-cong-suat',
		'thi-truong-bat-dong-san-da-nang-quy-3-2026',
		'khu-thuong-mai-tu-do-da-nang-ftz6-kita-trung-nam-ba-na',
		'can-ho-view-song-han-du-an-va-gia',
		'tin-quy-hoach-xay-dung-da-nang-6-12-10-2026',
		'gia-dat-ven-bien-da-nang-vo-nguyen-giap-hoang-sa',
		'du-an-nguoi-nuoc-ngoai-duoc-mua-da-nang-2026',
		'gia-nha-dat-da-nang-tuan-5-11-10-2026',
		'hop-dong-dat-coc-mua-nha-rui-ro-phong-tranh',
		'kiem-tra-phap-ly-quy-hoach-nha-dat-da-nang',
		'bat-dong-san-hoi-an-2026-sau-hop-nhat',
		'bat-dong-san-cam-le-2026',
		'dat-nen-hoa-xuan-2026-gia-theo-khu',
		'capital-square-da-nang-cac-toa-loai-can-gia',
		'shantira-hoi-an-biet-thu-can-ho-gia-tham-khao',
		'naman-residences-shilla-monogram-villa-nghi-duong',
		'so-sanh-villa-ven-bien-da-nang-co-so',
		'biet-thu-vinpearl-da-nang-hoi-an-gia-chuyen-nhuong',
		'the-filmore-da-nang-gia-chuyen-nhuong-cho-thue',
		'hiyori-garden-tower-hiyori-aqua-tower-da-nang',
		'peninsula-da-nang-gia-chuyen-nhuong-cho-thue',
		'sun-ponte-residence-gia-chuyen-nhuong-cho-thue',
		'sun-cosmo-residence-gia-chuyen-nhuong-cho-thue',
		'gia-chuyen-nhuong-can-ho-da-nang-2026-theo-du-an',
		'thue-can-ho-bien-my-khe-gia-theo-du-an',
		'cho-thue-can-ho-da-nang-hop-dong-thue-tam-tru',
		'thue-phi-mua-ban-nha-dat-da-nang-2026',
		'mua-can-ho-chuyen-nhuong-da-nang-quy-trinh-giay-to',
		'hai-minh-tower-truong-sa-thoi-han-dat-50-nam',
		'thi-cong-ham-chui-cach-mang-thang-tam-le-thanh-nghi',
		'da-nang-de-xuat-7-du-an-cap-bach-2026-2030',
		'da-nang-de-xuat-xay-cau-moi-qua-song-han',
		'tin-ha-tang-da-nang-thang-10-2026',
		'duong-tranh-nam-hai-van-6-lan-bat-dong-san-lien-chieu',
		'bang-gia-dat-da-nang-sua-doi-2026',
		'cong-vien-cau-lac-bo-the-thao-bien-bai-tam-son-thuy',
		'dau-tu-bat-dong-san-da-nang-nen-chon-loai-hinh-nao',
		'bat-dong-san-lien-chieu-cang-lien-chieu',
		'bat-dong-san-ngu-hanh-son-2026',
		'bat-dong-san-hai-chau-2026',
		'bat-dong-san-son-tra-2026',
		'vinhomes-hai-van-bay-cap-nhat-2026',
		'biet-thu-ven-bien-da-nang-hoi-an-bang-gia',
		'newtown-diamond-3-toa-va-newtown-legend',
		'm-riverside-da-nang-gia-chinh-sach',
		'danang-landmark-can-ho-canh-cau-rong',
		'nobu-da-nang-can-ho-hang-hieu',
		'the-meridian-da-nang-co-nen-mua',
		'masteri-da-nang-gia-tien-do-ban-giao',
		'so-sanh-can-ho-ven-song-han-sun-symphony-sun-ponte-peninsula',
		'sun-symphony-da-nang-gia-chuyen-nhuong-cho-thue',
		'cora-tower-sun-neo-city',
		's-light-tower-mo-ban-2026',
		'spana-tower-hoa-xuan-gia-mat-bang',
		'shop-khoi-de-da-nang-co-nen-dau-tu',
		'penthouse-da-nang-du-an-va-gia',
		'can-ho-so-huu-lau-dai-hay-can-ho-dich-vu-50-nam',
		'gia-thue-can-ho-da-nang-moi-thang',
		'vay-mua-can-ho-da-nang-2026-lai-suat',
		'kinh-nghiem-mua-can-ho-da-nang',
		'mua-can-ho-da-nang-2-ty-3-ty',
		'can-ho-view-bien-da-nang-my-khe',
		'can-ho-da-nang-2026-du-an-dang-mo-ban',
		'phap-ly-so-hong-casamia-balanca',
		'cho-thue-biet-thu-casamia-balanca-dong-tien',
		'chinh-sach-ban-hang-casamia-balanca',
		'gia-biet-thu-casamia-balanca-2026',
		'casamia-balanca-hoi-an-tong-quan-du-an',
		'casamia-balanca-so-sanh-biet-thu-hoi-an',
		'dau-tu-biet-thu-casamia-balanca-bai-toan-dong-tien',
		'bat-dong-san-nam-da-nang-ha-tang-hoa-xuan-hoa-quy-2026',
		'dat-nen-dam-sen-sun-riverpolis-gia-phap-ly',
		'sun-riverpolis-khu-do-thi-ven-song-hoa-quy',
		'so-sanh-fours-tower-spana-tower-s-light-tower',
		'co-nen-mua-can-ho-fours-tower',
		'du-an-hoang-hiep-bat-dong-san-dang-tu-van-2026',
		'fours-tower-f2-thap-mai-mua-xuan',
		'chinh-sach-fours-tower-thanh-toan-vay-ngan-hang',
		'mat-bang-fours-tower-studio-3pn',
		'gia-fours-tower-2026',
		'fours-tower-da-nang-tong-quan-4-thap-bon-mua',
		'ky-gui-can-ho-da-nang-ban-cho-thue',
		'thi-truong-bat-dong-san-da-nang-2026',
		'chon-moi-gioi-bat-dong-san-da-nang-8-cau-hoi',
		'quy-trinh-mua-can-ho-hoang-hiep-da-nang',
		'toan-canh-ha-tang-da-nang-2026-tac-dong-bat-dong-san',
		'cang-lien-chieu-khu-thuong-mai-tu-do-bat-dong-san-lien-chieu',
		'trung-tam-tai-chinh-quoc-te-da-nang-tac-dong-bat-dong-san',
		'cum-nut-giao-cau-hoa-xuan-bat-dong-san-nam-da-nang',
		'duong-ven-bien-129-vo-chi-cong-bat-dong-san-ven-bien-hoi-an',
		'mo-rong-nha-ga-t2-san-bay-da-nang-bat-dong-san-cho-thue',
		'ga-duong-sat-toc-do-cao-da-nang-hoa-son-bat-dong-san-hoa-vang',
		'hop-nhat-da-nang-quang-nam-bat-dong-san-vung-giap-ranh',
	);
}

/** Số bài còn chờ thay ảnh. */
function hh_bia_bai_pending() {
	$done = (array) get_option( 'hh_bia_bai_done', array() );
	return count( array_diff( hh_bia_bai_slugs(), array_keys( $done ) ) );
}

function hh_bia_bai_run( $seconds = 12 ) {
	if ( ! function_exists( 'hh_auto_posts_get' ) || get_transient( 'hh_bia_bai_lock' ) ) {
		return;
	}
	set_transient( 'hh_bia_bai_lock', 1, 60 );
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';
	$done  = (array) get_option( 'hh_bia_bai_done', array() );
	$tries = (array) get_option( 'hh_bia_bai_tries', array() );
	$start = microtime( true );
	foreach ( hh_bia_bai_slugs() as $slug ) {
		if ( isset( $done[ $slug ] ) ) {
			continue;
		}
		if ( microtime( true ) - $start > $seconds ) {
			break;
		}
		$post = get_page_by_path( $slug, OBJECT, 'post' );
		if ( ! $post || 'publish' !== $post->post_status ) {
			$done[ $slug ] = 'skip';
			continue;
		}
		$cur = (int) get_post_thumbnail_id( $post->ID );
		if ( $cur && 'bia-bai:' . $slug === get_post_meta( $cur, '_hh_img_src', true ) ) {
			$done[ $slug ] = $cur;
			continue;
		}
		$body = hh_auto_posts_get( 'bia-bai/' . $slug . '.jpg' );
		if ( is_wp_error( $body ) || strlen( $body ) < 5000 || "\xFF\xD8" !== substr( $body, 0, 2 ) ) {
			$tries[ $slug ] = (int) ( $tries[ $slug ] ?? 0 ) + 1;
			if ( $tries[ $slug ] >= 3 ) {
				$done[ $slug ] = 'failed';
			}
			continue;
		}
		$tmp = wp_tempnam( $slug . '.jpg' );
		if ( ! $tmp || false === file_put_contents( $tmp, $body ) ) { // phpcs:ignore WordPress.WP.AlternativeFunctions
			break;
		}
		$alt = wp_strip_all_tags( get_the_title( $post ) );
		$att = media_handle_sideload( array( 'name' => $slug . '-anh-dai-dien.jpg', 'tmp_name' => $tmp ), $post->ID, $alt );
		if ( is_wp_error( $att ) ) {
			wp_delete_file( $tmp );
			$tries[ $slug ] = (int) ( $tries[ $slug ] ?? 0 ) + 1;
			if ( $tries[ $slug ] >= 3 ) {
				$done[ $slug ] = 'failed';
			}
			continue;
		}
		update_post_meta( $att, '_wp_attachment_image_alt', $alt );
		update_post_meta( $att, '_hh_img_src', 'bia-bai:' . $slug );
		set_post_thumbnail( $post->ID, $att );
		clean_post_cache( $post->ID );
		do_action( 'litespeed_purge_post', $post->ID );
		$done[ $slug ] = $att;
	}
	update_option( 'hh_bia_bai_done', $done, false );
	update_option( 'hh_bia_bai_tries', $tries, false );
	delete_transient( 'hh_bia_bai_lock' );
}

add_action(
	'admin_init',
	static function () {
		if ( wp_doing_ajax() || ! current_user_can( 'upload_files' ) || ! hh_bia_bai_pending() ) {
			return;
		}
		hh_bia_bai_run( 12 );
	},
	40
);
add_action( 'hh_bia_bai_cron', static fn() => hh_bia_bai_run( 20 ) );
add_action(
	'init',
	static function () {
		if ( hh_bia_bai_pending() && ! wp_next_scheduled( 'hh_bia_bai_cron' ) ) {
			wp_schedule_single_event( time() + 120, 'hh_bia_bai_cron' );
		}
	}
);
add_action(
	'admin_notices',
	static function () {
		if ( ! current_user_can( 'upload_files' ) ) {
			return;
		}
		$left = hh_bia_bai_pending();
		$all  = count( hh_bia_bai_slugs() );
		if ( $left ) {
			printf( '<div class="notice notice-info"><p><strong>Ảnh đại diện mới cho bài viết (1200×630):</strong> đã thay %d/%d bài – web đang tự làm tiếp (mỗi lần mở trang quản trị và chạy nền mỗi 2 phút).</p></div>', (int) ( $all - $left ), (int) $all );
		} elseif ( ! get_option( 'hh_bia_bai_notice_off' ) ) {
			$failed = count( array_keys( (array) get_option( 'hh_bia_bai_done', array() ), 'failed', true ) );
			printf( '<div class="notice notice-success is-dismissible"><p><strong>Đã thay xong ảnh đại diện mới cho %d bài viết.</strong>%s Vào LiteSpeed Cache → Purge All để trang chủ, mục tin tức và Facebook nhận ảnh mới.</p></div>', (int) ( $all - $failed ), $failed ? ' ' . (int) $failed . ' bài tải ảnh lỗi (giữ ảnh cũ).' : '' );
			update_option( 'hh_bia_bai_notice_off', 1, false );
		}
	}
);
