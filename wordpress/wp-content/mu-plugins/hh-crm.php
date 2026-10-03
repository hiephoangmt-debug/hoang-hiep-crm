<?php
/**
 * Plugin Name: Hoàng Hiệp CRM
 * Description: Dự án, nhà đất mua bán / cho thuê và khách hàng tiềm năng cho hiephoangmt.com.
 * Version: 2.4.0
 * Author: Hoàng Hiệp
 */

defined( 'ABSPATH' ) || exit;

define( 'HH_CRM_VERSION', '2.4.0' );
define( 'HH_CRM_DIR', __DIR__ . '/hh-crm/' );
define( 'HH_CRM_URL', WPMU_PLUGIN_URL . '/hh-crm/' );

require HH_CRM_DIR . 'fields.php';
require HH_CRM_DIR . 'schemas.php';
require HH_CRM_DIR . 'types.php';
require HH_CRM_DIR . 'project-content.php';
require HH_CRM_DIR . 'leads.php';
require HH_CRM_DIR . 'data-du-an.php';
require HH_CRM_DIR . 'data-du-an-chi-tiet.php';
