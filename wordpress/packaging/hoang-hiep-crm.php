<?php
/**
 * Plugin Name: Hoàng Hiệp CRM
 * Description: Dự án, nhà đất mua bán / cho thuê, khách hàng tiềm năng và dữ liệu dự án Đà Nẵng cho hiephoangmt.com. Dùng kèm giao diện Hoàng Hiệp.
 * Version: 2.5.0
 * Author: Hoàng Hiệp
 * Requires PHP: 7.4
 */

defined( 'ABSPATH' ) || exit;

// Bản mu-plugin (Docker) đã nạp rồi thì bỏ qua.
if ( defined( 'HH_CRM_VERSION' ) ) {
	return;
}

define( 'HH_CRM_VERSION', '2.5.0' );
define( 'HH_CRM_DIR', __DIR__ . '/hh-crm/' );
define( 'HH_CRM_URL', plugin_dir_url( __FILE__ ) . 'hh-crm/' );

require HH_CRM_DIR . 'fields.php';
require HH_CRM_DIR . 'schemas.php';
require HH_CRM_DIR . 'types.php';
require HH_CRM_DIR . 'project-content.php';
require HH_CRM_DIR . 'leads.php';
require HH_CRM_DIR . 'data-du-an.php';
require HH_CRM_DIR . 'data-du-an-chi-tiet.php';
require HH_CRM_DIR . 'setup.php';
require HH_CRM_DIR . 'houzez-import.php';

register_activation_hook( __FILE__, static function () {
	update_option( 'hh_flush_rewrite', 1 );
} );
