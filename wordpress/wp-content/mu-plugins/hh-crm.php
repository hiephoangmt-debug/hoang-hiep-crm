<?php
/**
 * Plugin Name: Hoàng Hiệp CRM
 * Description: Dự án, nhà đất mua bán / cho thuê và khách hàng tiềm năng cho hiephoangmt.com.
 * Version: 2.6.0
 * Author: Hoàng Hiệp
 */

defined( 'ABSPATH' ) || exit;

// Bản plugin thường (cài qua Plugin → Tải lên) đã nạp rồi thì bỏ qua.
if ( defined( 'HH_CRM_VERSION' ) ) {
	return;
}

define( 'HH_CRM_VERSION', '2.6.0' );
define( 'HH_CRM_DIR', __DIR__ . '/hh-crm/' );
define( 'HH_CRM_URL', WPMU_PLUGIN_URL . '/hh-crm/' );

require HH_CRM_DIR . 'fields.php';
require HH_CRM_DIR . 'schemas.php';
require HH_CRM_DIR . 'types.php';
require HH_CRM_DIR . 'project-content.php';
require HH_CRM_DIR . 'leads.php';
require HH_CRM_DIR . 'data-du-an.php';
require HH_CRM_DIR . 'data-du-an-chi-tiet.php';
require HH_CRM_DIR . 'data-vinhomes-hai-van-bay.php';
require HH_CRM_DIR . 'data-sun-group-da-nang.php';
require HH_CRM_DIR . 'data-biet-thu-ven-bien.php';
require HH_CRM_DIR . 'data-newtown.php';
require HH_CRM_DIR . 'data-filmore.php';
require HH_CRM_DIR . 'data-du-an-moi-a.php';
require HH_CRM_DIR . 'data-du-an-moi-b.php';
require HH_CRM_DIR . 'data-du-an-moi-c.php';
require HH_CRM_DIR . 'data-landmark.php';
require HH_CRM_DIR . 'data-m-riverside.php';
require HH_CRM_DIR . 'data-san-pham-cao-tang.php';
require HH_CRM_DIR . 'data-tin-tuc-ha-tang.php';
require HH_CRM_DIR . 'setup.php';
require HH_CRM_DIR . 'houzez-import.php';
