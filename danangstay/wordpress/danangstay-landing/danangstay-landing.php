<?php
/**
 * Plugin Name: DanangStay Landing
 * Description: Landing page đặt phòng DanangStay (Việt / English / 한국어). Lưu yêu cầu đặt phòng ngay trong WordPress, báo khách mới qua email và Telegram.
 * Version: 1.0.0
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * Author: DanangStay
 * Text Domain: danangstay
 */

if (!defined('ABSPATH')) {
    exit;
}

define('DSL_OPT', 'dsl_settings');
define('DSL_CPT', 'ds_lead');
define('DSL_STATUSES', ['Mới', 'Đã liên hệ', 'Đã báo giá', 'Đã chốt', 'Hủy']);

/* ------------------------------------------------------------------ */
/* Cài đặt                                                             */
/* ------------------------------------------------------------------ */

function dsl_fields()
{
    return [
        'mode'           => ['Hiển thị landing ở', 'select', ['page' => 'Một đường dẫn riêng (ví dụ /dat-phong/)', 'home' => 'Trang chủ của website']],
        'slug'           => ['Đường dẫn riêng', 'text', 'Ví dụ: dat-phong → tenmien.vn/dat-phong/'],
        'phone'          => ['Hotline', 'text', 'Ví dụ: 0905123456'],
        'zalo'           => ['Zalo', 'text', 'Số Zalo hoặc link Zalo OA (https://zalo.me/...)'],
        'whatsapp'       => ['WhatsApp', 'text', 'Số dạng quốc tế, không dấu +. Ví dụ: 84905123456'],
        'kakao'          => ['KakaoTalk', 'text', 'Link Open Chat / Channel, ví dụ https://open.kakao.com/o/xxxx'],
        'email'          => ['Email hiển thị', 'text', 'Ví dụ: booking@danangstay.com.vn'],
        'facebook'       => ['Fanpage Facebook', 'text', 'https://facebook.com/...'],
        'tiktok'         => ['TikTok', 'text', 'https://tiktok.com/@...'],
        'seo_title'      => ['Tiêu đề SEO (tiếng Việt)', 'text', 'Để trống dùng mặc định. Nên 50–60 ký tự, có "khách sạn Đà Nẵng"'],
        'seo_desc'       => ['Mô tả SEO (tiếng Việt)', 'textarea', 'Để trống dùng mặc định. Nên 140–160 ký tự'],
        'address'        => ['Địa chỉ văn phòng', 'text', 'Ví dụ: 12 Hồ Nghinh, Phước Mỹ, Sơn Trà, Đà Nẵng (hiện trong dữ liệu Google)'],
        'blog_url'       => ['Trang Cẩm nang / Blog', 'text', 'Ví dụ: https://danangstay.com.vn/blog/ (để trống thì ẩn)'],
        'notify_email'   => ['Email nhận báo khách mới', 'text', 'Có thể nhiều email, cách nhau bằng dấu phẩy'],
        'telegram_token' => ['Telegram bot token', 'text', 'Không bắt buộc. Tạo bot qua @BotFather'],
        'telegram_chat'  => ['Telegram chat id', 'text', 'Không bắt buộc'],
        'sheet_webhook'  => ['Google Sheet webhook', 'text', 'Không bắt buộc. Link Web App từ google_sheet.gs'],
        'head_code'      => ['Mã gắn vào <head>', 'textarea', 'Google Analytics, Facebook Pixel, Google Ads… (không bắt buộc)'],
    ];
}

function dsl_opts()
{
    $admin = get_option('admin_email');
    return wp_parse_args(get_option(DSL_OPT, []), [
        'mode' => 'page', 'slug' => 'dat-phong', 'phone' => '', 'zalo' => '', 'whatsapp' => '', 'kakao' => '',
        'email' => $admin, 'facebook' => '', 'tiktok' => '', 'blog_url' => '', 'notify_email' => $admin,
        'telegram_token' => '', 'telegram_chat' => '', 'sheet_webhook' => '', 'head_code' => '',
        'seo_title' => '', 'seo_desc' => '', 'address' => '',
    ]);
}

add_action('admin_init', function () {
    register_setting('dsl_group', DSL_OPT, ['sanitize_callback' => 'dsl_sanitize']);
});

function dsl_sanitize($in)
{
    $out = [];
    foreach (dsl_fields() as $k => $f) {
        $v = isset($in[$k]) ? $in[$k] : '';
        if ($k === 'seo_desc') {
            $out[$k] = sanitize_textarea_field($v);
        } elseif ($k === 'head_code') {
            $out[$k] = current_user_can('unfiltered_html') ? $v : wp_kses_post($v);
        } elseif (in_array($k, ['kakao', 'facebook', 'tiktok', 'blog_url', 'sheet_webhook'], true)) {
            $out[$k] = esc_url_raw(trim($v));
        } elseif ($k === 'zalo') {
            $v = trim($v);
            $out[$k] = preg_match('#^https?://#', $v) ? esc_url_raw($v) : preg_replace('/[^0-9]/', '', $v);
        } elseif ($k === 'slug') {
            $out[$k] = sanitize_title($v) ?: 'dat-phong';
        } elseif ($k === 'mode') {
            $out[$k] = $v === 'home' ? 'home' : 'page';
        } else {
            $out[$k] = sanitize_text_field($v);
        }
    }
    return $out;
}

add_action('admin_menu', function () {
    add_options_page('DanangStay', 'DanangStay', 'manage_options', 'danangstay', 'dsl_settings_page');
});

add_filter('plugin_action_links_' . plugin_basename(__FILE__), function ($links) {
    array_unshift($links, '<a href="' . esc_url(admin_url('options-general.php?page=danangstay')) . '">Cài đặt</a>');
    return $links;
});

function dsl_landing_url()
{
    $o = dsl_opts();
    return $o['mode'] === 'home' ? home_url('/') : home_url('/' . $o['slug'] . '/');
}

function dsl_settings_page()
{
    $o = dsl_opts();
    echo '<div class="wrap"><h1>DanangStay – Cài đặt landing page</h1>';
    echo '<p>Landing page đang chạy tại: <a href="' . esc_url(dsl_landing_url()) . '" target="_blank"><strong>' . esc_html(dsl_landing_url()) . '</strong></a></p>';
    echo '<form method="post" action="options.php">';
    settings_fields('dsl_group');
    echo '<table class="form-table" role="presentation">';
    foreach (dsl_fields() as $k => $f) {
        list($label, $type, $help) = $f;
        $name = DSL_OPT . '[' . $k . ']';
        echo '<tr><th scope="row"><label for="dsl_' . esc_attr($k) . '">' . esc_html($label) . '</label></th><td>';
        if ($type === 'select') {
            echo '<select id="dsl_' . esc_attr($k) . '" name="' . esc_attr($name) . '">';
            foreach ($help as $val => $txt) {
                echo '<option value="' . esc_attr($val) . '"' . selected($o[$k], $val, false) . '>' . esc_html($txt) . '</option>';
            }
            echo '</select>';
        } elseif ($type === 'textarea') {
            echo '<textarea id="dsl_' . esc_attr($k) . '" name="' . esc_attr($name) . '" rows="5" class="large-text code">' . esc_textarea($o[$k]) . '</textarea><p class="description">' . esc_html($help) . '</p>';
        } else {
            echo '<input id="dsl_' . esc_attr($k) . '" name="' . esc_attr($name) . '" type="text" class="regular-text" value="' . esc_attr($o[$k]) . '"><p class="description">' . esc_html($help) . '</p>';
        }
        echo '</td></tr>';
    }
    echo '</table>';
    submit_button('Lưu cài đặt');
    echo '</form></div>';
}

/* ------------------------------------------------------------------ */
/* Hiển thị landing page                                               */
/* ------------------------------------------------------------------ */

function dsl_request_path()
{
    $path = trim((string) wp_parse_url(isset($_SERVER['REQUEST_URI']) ? wp_unslash($_SERVER['REQUEST_URI']) : '', PHP_URL_PATH), '/');
    $base = trim((string) wp_parse_url(home_url('/'), PHP_URL_PATH), '/');
    if ($base !== '' && strpos($path, $base) === 0) {
        $path = trim(substr($path, strlen($base)), '/');
    }
    return rawurldecode($path);
}

add_action('template_redirect', function () {
    $o = dsl_opts();
    $hit = ($o['mode'] === 'home' && (is_front_page() || dsl_request_path() === ''))
        || ($o['mode'] === 'page' && dsl_request_path() === $o['slug']);
    if (!$hit || is_admin()) {
        return;
    }
    dsl_render();
    exit;
}, 1);

function dsl_seo_texts($lang)
{
    $o = dsl_opts();
    $t = [
        'vi' => [
            'title' => $o['seo_title'] ?: 'DanangStay – Đặt phòng khách sạn, căn hộ view biển Đà Nẵng',
            'desc'  => $o['seo_desc'] ?: 'Đặt phòng khách sạn, căn hộ view biển Đà Nẵng: Mỹ Khê, Mân Thái, Sơn Trà. Báo giá trong 15 phút, giá trực tiếp, hỗ trợ 24/7 tiếng Việt, English, 한국어.',
            'locale' => 'vi_VN',
        ],
        'en' => [
            'title' => 'DanangStay – Da Nang Hotel & Sea-View Apartment Booking',
            'desc'  => 'Book hotels and sea-view apartments in Da Nang – My Khe, Man Thai, Son Tra. Local team, quote in 15 minutes, 24/7 support in English, Korean and Vietnamese.',
            'locale' => 'en_US',
        ],
        'ko' => [
            'title' => 'DanangStay – 다낭 호텔·오션뷰 숙소 예약',
            'desc'  => '다낭 호텔·오션뷰 아파트 예약 – 미케 비치, 만타이, 선짜. 현지 팀이 15분 안에 견적, 한국어 24시간 상담.',
            'locale' => 'ko_KR',
        ],
    ];
    return $t[$lang];
}

function dsl_lang_url($lang)
{
    return $lang === 'vi' ? dsl_landing_url() : add_query_arg('lang', $lang, dsl_landing_url());
}

function dsl_render()
{
    $o = dsl_opts();
    $lang = isset($_GET['lang']) ? sanitize_key(wp_unslash($_GET['lang'])) : 'vi'; // phpcs:ignore WordPress.Security.NonceVerification
    if (!in_array($lang, ['vi', 'en', 'ko'], true)) {
        $lang = 'vi';
    }
    $seo = dsl_seo_texts($lang);
    $html = file_get_contents(__DIR__ . '/landing/index.html');
    $base = plugins_url('landing/', __FILE__);
    $html = str_replace(['src="logo/', 'href="logo/', 'content="logo/'], ['src="' . $base . 'logo/', 'href="' . $base . 'logo/', 'content="' . $base . 'logo/'], $html);

    // Tiêu đề, mô tả, ngôn ngữ theo từng bản (Google đọc đúng ngay từ máy chủ)
    $html = str_replace('<html lang="vi">', '<html lang="' . $lang . '">', $html);
    $html = preg_replace('#<title>.*?</title>#s', '<title>' . esc_html($seo['title']) . '</title>', $html, 1);
    $html = preg_replace('#<meta name="description" content="[^"]*">#', '<meta name="description" content="' . esc_attr($seo['desc']) . '">', $html, 1);
    $html = preg_replace('#<meta property="og:title" content="[^"]*">#', '<meta property="og:title" content="' . esc_attr($seo['title']) . '">', $html, 1);
    $html = preg_replace('#<meta property="og:description" content="[^"]*">#', '<meta property="og:description" content="' . esc_attr($seo['desc']) . '">', $html, 1);
    $html = str_replace('<meta property="og:locale" content="vi_VN">', '<meta property="og:locale" content="' . $seo['locale'] . '">', $html);

    $head = '<meta property="og:url" content="' . esc_url(dsl_lang_url($lang)) . '">' . "\n"
        . '<link rel="canonical" href="' . esc_url(dsl_lang_url($lang)) . '">' . "\n";
    foreach (['vi', 'en', 'ko'] as $l) {
        $head .= '<link rel="alternate" hreflang="' . $l . '" href="' . esc_url(dsl_lang_url($l)) . '">' . "\n";
    }
    $head .= '<link rel="alternate" hreflang="x-default" href="' . esc_url(dsl_lang_url('vi')) . '">' . "\n";

    $org = [
        '@context' => 'https://schema.org', '@type' => 'TravelAgency', 'name' => 'DanangStay',
        'url' => dsl_landing_url(), 'logo' => $base . 'logo/emblem.png', 'image' => $base . 'logo/emblem.png',
        'priceRange' => '₫₫', 'availableLanguage' => ['vi', 'en', 'ko'],
        'areaServed' => ['@type' => 'City', 'name' => 'Da Nang'],
        'address' => array_filter(['@type' => 'PostalAddress', 'streetAddress' => $o['address'], 'addressLocality' => 'Đà Nẵng', 'addressCountry' => 'VN']),
    ];
    if ($o['phone']) {
        $org['telephone'] = $o['phone'];
    }
    if ($o['email']) {
        $org['email'] = $o['email'];
    }
    $same = array_values(array_filter([$o['facebook'], $o['tiktok']]));
    if ($same) {
        $org['sameAs'] = $same;
    }
    $head .= '<script type="application/ld+json" id="ds-org">' . wp_json_encode($org, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
    $html = str_replace('<link rel="icon"', $head . '<link rel="icon"', $html);

    $cfg = [
        'phone' => $o['phone'], 'zalo' => $o['zalo'], 'whatsapp' => $o['whatsapp'], 'kakao' => $o['kakao'],
        'email' => $o['email'], 'facebook' => $o['facebook'], 'tiktok' => $o['tiktok'],
        'blogUrl' => $o['blog_url'], 'leadEndpoint' => rest_url('danangstay/v1/lead'),
        'sheetWebhook' => $o['sheet_webhook'],
    ];
    $html = str_replace('<!--DS_CONFIG-->', '<script>window.DS_CONFIG=' . wp_json_encode($cfg) . ';</script>', $html);
    if ($o['head_code']) {
        $html = str_replace('</head>', $o['head_code'] . "\n</head>", $html);
    }

    status_header(200);
    header('Content-Type: text/html; charset=utf-8');
    echo $html; // phpcs:ignore WordPress.Security.EscapeOutput -- trang tĩnh của plugin
}

// Đưa landing page (3 ngôn ngữ) vào sitemap của WordPress: /wp-sitemap.xml
add_action('init', function () {
    if (!function_exists('wp_register_sitemap_provider') || !class_exists('WP_Sitemaps_Provider')) {
        return;
    }
    if (!class_exists('DSL_Sitemap')) {
        class DSL_Sitemap extends WP_Sitemaps_Provider
        {
            public function __construct()
            {
                $this->name = 'danangstay';
                $this->object_type = 'danangstay';
            }
            public function get_url_list($page_num, $object_subtype = '')
            {
                return array_map(function ($l) {
                    return ['loc' => dsl_lang_url($l)];
                }, ['vi', 'en', 'ko']);
            }
            public function get_max_num_pages($object_subtype = '')
            {
                return 1;
            }
        }
    }
    wp_register_sitemap_provider('danangstay', new DSL_Sitemap());
});

/* ------------------------------------------------------------------ */
/* Lưu yêu cầu đặt phòng                                               */
/* ------------------------------------------------------------------ */

add_action('init', function () {
    register_post_type(DSL_CPT, [
        'labels' => [
            'name' => 'Yêu cầu đặt phòng', 'singular_name' => 'Yêu cầu đặt phòng',
            'menu_name' => 'Đặt phòng', 'all_items' => 'Tất cả yêu cầu', 'edit_item' => 'Chi tiết yêu cầu',
            'search_items' => 'Tìm yêu cầu', 'not_found' => 'Chưa có yêu cầu nào',
        ],
        'public' => false, 'show_ui' => true, 'show_in_menu' => true, 'menu_icon' => 'dashicons-palmtree',
        'menu_position' => 25, 'supports' => ['title'], 'capability_type' => 'post',
        'capabilities' => ['create_posts' => 'do_not_allow'], 'map_meta_cap' => true,
    ]);
});

add_action('rest_api_init', function () {
    register_rest_route('danangstay/v1', '/lead', [
        'methods' => 'POST', 'callback' => 'dsl_save_lead', 'permission_callback' => '__return_true',
    ]);
});

function dsl_lead_keys()
{
    return [
        'name' => 'Họ tên', 'phone' => 'Điện thoại', 'via' => 'Liên hệ qua', 'checkin' => 'Nhận phòng',
        'checkout' => 'Trả phòng', 'nights' => 'Số đêm', 'guests' => 'Số khách', 'rooms' => 'Số phòng',
        'budget' => 'Ngân sách', 'msg' => 'Yêu cầu', 'lang' => 'Ngôn ngữ', 'source' => 'Nguồn',
        'utm' => 'UTM', 'page' => 'Trang',
    ];
}

function dsl_save_lead(WP_REST_Request $r)
{
    $d = $r->get_json_params();
    if (!is_array($d)) {
        $d = json_decode($r->get_body(), true) ?: [];
    }
    if (!empty($d['website'])) { // bẫy spam
        return ['ok' => true];
    }
    $phone = preg_replace('/[^0-9]/', '', (string) ($d['phone'] ?? ''));
    if (strlen($phone) < 6 || trim((string) ($d['name'] ?? '')) === '') {
        return new WP_Error('invalid', 'Thiếu tên hoặc số điện thoại', ['status' => 400]);
    }
    // Giới hạn 5 yêu cầu / 10 phút / IP
    $ip = isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR'])) : '';
    $rk = 'dsl_rl_' . md5($ip);
    $n = (int) get_transient($rk);
    if ($n >= 5) {
        return new WP_Error('rate_limited', 'Too many requests', ['status' => 429]);
    }
    set_transient($rk, $n + 1, 10 * MINUTE_IN_SECONDS);

    $c = [];
    foreach (array_keys(dsl_lead_keys()) as $k) {
        $v = mb_substr((string) ($d[$k] ?? ''), 0, $k === 'msg' ? 1000 : 300);
        $c[$k] = $k === 'msg' ? sanitize_textarea_field($v) : sanitize_text_field($v);
    }
    $id = wp_insert_post([
        'post_type' => DSL_CPT, 'post_status' => 'publish',
        'post_title' => $c['name'] . ' – ' . $c['phone'],
    ], true);
    if (is_wp_error($id)) {
        return new WP_Error('save_failed', 'Không lưu được', ['status' => 500]);
    }
    foreach ($c as $k => $v) {
        update_post_meta($id, '_ds_' . $k, $v);
    }
    update_post_meta($id, '_ds_status', 'Mới');

    dsl_notify($id, $c);
    return ['ok' => true];
}

function dsl_notify($id, $c)
{
    $o = dsl_opts();
    $text = '🆕 DanangStay – ' . ($c['source'] ?: 'Khách đặt phòng') . "\n"
        . '👤 ' . $c['name'] . ' · ' . $c['phone'] . ' (' . $c['via'] . ', ' . $c['lang'] . ")\n"
        . '📅 ' . $c['checkin'] . ' → ' . $c['checkout'] . ' (' . $c['nights'] . " đêm)\n"
        . '👥 ' . $c['guests'] . ' khách · ' . $c['rooms'] . ' phòng · 💰 ' . $c['budget']
        . ($c['msg'] ? "\n📝 " . $c['msg'] : '')
        . "\n🔗 " . admin_url('post.php?post=' . $id . '&action=edit');

    if ($o['notify_email']) {
        $to = array_filter(array_map('sanitize_email', explode(',', $o['notify_email'])));
        if ($to) {
            wp_mail($to, 'Khách mới DanangStay: ' . $c['name'] . ' – ' . $c['phone'], $text);
        }
    }
    if ($o['telegram_token'] && $o['telegram_chat']) {
        wp_remote_post('https://api.telegram.org/bot' . rawurlencode($o['telegram_token']) . '/sendMessage', [
            'timeout' => 5, 'blocking' => false,
            'body' => ['chat_id' => $o['telegram_chat'], 'text' => $text],
        ]);
    }
}

/* ------------------------------------------------------------------ */
/* Quản lý yêu cầu trong trang quản trị                                */
/* ------------------------------------------------------------------ */

add_filter('manage_' . DSL_CPT . '_posts_columns', function () {
    return [
        'cb' => '<input type="checkbox">', 'title' => 'Khách', 'ds_status' => 'Trạng thái',
        'ds_dates' => 'Ngày ở', 'ds_guests' => 'Khách / Phòng', 'ds_budget' => 'Ngân sách',
        'ds_via' => 'Liên hệ qua', 'ds_lang' => 'Ngôn ngữ', 'date' => 'Gửi lúc',
    ];
});

add_action('manage_' . DSL_CPT . '_posts_custom_column', function ($col, $id) {
    $m = function ($k) use ($id) {
        return get_post_meta($id, '_ds_' . $k, true);
    };
    switch ($col) {
        case 'ds_status':
            $s = $m('status') ?: 'Mới';
            $color = ['Mới' => '#d63638', 'Đã liên hệ' => '#dba617', 'Đã báo giá' => '#2271b1', 'Đã chốt' => '#00a32a', 'Hủy' => '#787c82'];
            echo '<strong style="color:' . esc_attr($color[$s] ?? '#000') . '">' . esc_html($s) . '</strong>';
            break;
        case 'ds_dates':
            echo esc_html($m('checkin') . ' → ' . $m('checkout') . ' (' . $m('nights') . ' đêm)');
            break;
        case 'ds_guests':
            echo esc_html($m('guests') . ' / ' . $m('rooms'));
            break;
        case 'ds_budget':
            echo esc_html($m('budget'));
            break;
        case 'ds_via':
            echo esc_html($m('via'));
            break;
        case 'ds_lang':
            echo esc_html(strtoupper($m('lang')));
            break;
    }
}, 10, 2);

add_action('add_meta_boxes_' . DSL_CPT, function () {
    add_meta_box('dsl_detail', 'Thông tin yêu cầu', function ($post) {
        wp_nonce_field('dsl_save_status', 'dsl_nonce');
        $s = get_post_meta($post->ID, '_ds_status', true) ?: 'Mới';
        echo '<p><label><strong>Trạng thái:</strong> <select name="dsl_status">';
        foreach (DSL_STATUSES as $st) {
            echo '<option' . selected($s, $st, false) . '>' . esc_html($st) . '</option>';
        }
        echo '</select></label></p><table class="widefat striped"><tbody>';
        foreach (dsl_lead_keys() as $k => $label) {
            $v = get_post_meta($post->ID, '_ds_' . $k, true);
            if ($k === 'phone') {
                $digits = preg_replace('/[^0-9]/', '', $v);
                $v = esc_html($v) . ' · <a href="tel:' . esc_attr($digits) . '">Gọi</a> · <a href="https://zalo.me/' . esc_attr($digits) . '" target="_blank">Zalo</a>';
                echo '<tr><th style="width:140px">' . esc_html($label) . '</th><td>' . $v . '</td></tr>'; // phpcs:ignore
                continue;
            }
            echo '<tr><th style="width:140px">' . esc_html($label) . '</th><td>' . nl2br(esc_html($v)) . '</td></tr>';
        }
        echo '</tbody></table>';
    }, DSL_CPT, 'normal', 'high');
});

add_action('save_post_' . DSL_CPT, function ($id) {
    if (!isset($_POST['dsl_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['dsl_nonce'])), 'dsl_save_status')) {
        return;
    }
    if (!current_user_can('edit_post', $id)) {
        return;
    }
    $s = isset($_POST['dsl_status']) ? sanitize_text_field(wp_unslash($_POST['dsl_status'])) : '';
    if (in_array($s, DSL_STATUSES, true)) {
        update_post_meta($id, '_ds_status', $s);
    }
});

// Xuất CSV (mở được bằng Excel / Google Sheet)
add_action('restrict_manage_posts', function ($type) {
    if ($type === DSL_CPT) {
        $url = wp_nonce_url(admin_url('admin-post.php?action=dsl_export'), 'dsl_export');
        echo '<a href="' . esc_url($url) . '" class="button" style="margin-left:6px">Xuất Excel (CSV)</a>';
    }
});

add_action('admin_post_dsl_export', function () {
    if (!current_user_can('edit_posts') || !check_admin_referer('dsl_export')) {
        wp_die('Không có quyền');
    }
    $keys = dsl_lead_keys();
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=danangstay-dat-phong-' . gmdate('Y-m-d') . '.csv');
    $out = fopen('php://output', 'w');
    fwrite($out, "\xEF\xBB\xBF"); // để Excel hiển thị đúng tiếng Việt
    fputcsv($out, array_merge(['Gửi lúc', 'Trạng thái'], array_values($keys)));
    $q = new WP_Query(['post_type' => DSL_CPT, 'posts_per_page' => -1, 'post_status' => 'any', 'orderby' => 'date', 'order' => 'DESC', 'fields' => 'ids']);
    foreach ($q->posts as $id) {
        $row = [get_the_date('Y-m-d H:i', $id), get_post_meta($id, '_ds_status', true)];
        foreach (array_keys($keys) as $k) {
            $v = (string) get_post_meta($id, '_ds_' . $k, true);
            $row[] = preg_match('/^[=+\-@]/', $v) ? "'" . $v : $v;
        }
        fputcsv($out, $row);
    }
    fclose($out);
    exit;
});
