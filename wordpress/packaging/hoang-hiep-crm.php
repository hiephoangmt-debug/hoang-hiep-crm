<?php
/**
 * Plugin Name: Hoàng Hiệp CRM
 * Description: Dự án, nhà đất mua bán / cho thuê, khách hàng tiềm năng và dữ liệu dự án Đà Nẵng cho hiephoangmt.com. Dùng kèm giao diện Hoàng Hiệp.
 * Version: 2.20.18
 * Author: Hoàng Hiệp
 * Requires PHP: 7.4
 */

defined( 'ABSPATH' ) || exit;

// Bản mu-plugin (Docker) đã nạp rồi thì bỏ qua.
if ( defined( 'HH_CRM_VERSION' ) ) {
	return;
}

define( 'HH_CRM_VERSION', '2.20.18' );
define( 'HH_CRM_DIR', __DIR__ . '/hh-crm/' );
define( 'HH_CRM_URL', plugin_dir_url( __FILE__ ) . 'hh-crm/' );

require HH_CRM_DIR . 'fields.php';
require HH_CRM_DIR . 'schemas.php';
require HH_CRM_DIR . 'types.php';
require HH_CRM_DIR . 'project-content.php';
require HH_CRM_DIR . 'units-read.php';
require HH_CRM_DIR . 'units.php';
require HH_CRM_DIR . 'image-links.php';
require HH_CRM_DIR . 'rankmath.php';
require HH_CRM_DIR . 'seo-tu-khoa.php';
require HH_CRM_DIR . 'hub-pages.php';
require HH_CRM_DIR . 'leads.php';
require HH_CRM_DIR . 'nguon-khach.php';
require HH_CRM_DIR . 'chat.php';
require HH_CRM_DIR . 'telegram.php';
require HH_CRM_DIR . 'data-du-an.php';
require HH_CRM_DIR . 'data-du-an-chi-tiet.php';
require HH_CRM_DIR . 'data-vinhomes-hai-van-bay.php';
require HH_CRM_DIR . 'data-vinhomes-hai-van-bay-2026-10.php';
require HH_CRM_DIR . 'data-hai-van-bay-phan-khu.php';
require HH_CRM_DIR . 'data-fours-tower-f2.php';
require HH_CRM_DIR . 'data-fours-f2-mat-bang.php';
require HH_CRM_DIR . 'data-casamia-balanca-anh.php';
require HH_CRM_DIR . 'data-sun-group-da-nang.php';
require HH_CRM_DIR . 'data-sun-solar-csbh04.php';
require HH_CRM_DIR . 'data-biet-thu-ven-bien.php';
require HH_CRM_DIR . 'data-vinpearl-villa.php';
require HH_CRM_DIR . 'data-shantira.php';
require HH_CRM_DIR . 'data-newtown.php';
require HH_CRM_DIR . 'data-capital-square.php';
require HH_CRM_DIR . 'data-filmore.php';
require HH_CRM_DIR . 'data-du-an-moi-a.php';
require HH_CRM_DIR . 'data-du-an-moi-b.php';
require HH_CRM_DIR . 'data-du-an-moi-c.php';
require HH_CRM_DIR . 'data-landmark.php';
require HH_CRM_DIR . 'data-m-riverside.php';
require HH_CRM_DIR . 'data-san-pham-cao-tang.php';
require HH_CRM_DIR . 'data-gia-thi-truong.php';
require HH_CRM_DIR . 'data-tin-nha-dat.php';
require HH_CRM_DIR . 'data-gia-dat-khach-san.php';
require HH_CRM_DIR . 'data-tin-tuc-ha-tang.php';
require HH_CRM_DIR . 'data-bai-viet-tuan-01-02.php';
require HH_CRM_DIR . 'data-bai-viet-tuan-03-04.php';
require HH_CRM_DIR . 'data-bai-viet-tuan-05-06.php';
require HH_CRM_DIR . 'data-bai-viet-tuan-07-08.php';
require HH_CRM_DIR . 'data-bai-viet-tuan-09-10.php';
require HH_CRM_DIR . 'data-bai-viet-tuan-11-12.php';
require HH_CRM_DIR . 'data-bai-viet-tuan-13-14.php';
require HH_CRM_DIR . 'data-tin-nhip-song.php';
require HH_CRM_DIR . 'data-tin-cau-song-han.php';
require HH_CRM_DIR . 'data-tin-thang-10-2026.php';
require HH_CRM_DIR . 'the-tin-tuc.php';
require HH_CRM_DIR . 'cap-nhat-nhanh.php';
require HH_CRM_DIR . 'ngon-ngu.php';
require HH_CRM_DIR . 'nhap-du-an-nhanh.php';
require HH_CRM_DIR . 'nhap-bai-nhanh.php';
require HH_CRM_DIR . 'data-bai-viet-casamia-dong-tien.php';
require HH_CRM_DIR . 'setup.php';
require HH_CRM_DIR . 'houzez-import.php';

register_activation_hook( __FILE__, static function () {
	update_option( 'hh_flush_rewrite', 1 );
} );
