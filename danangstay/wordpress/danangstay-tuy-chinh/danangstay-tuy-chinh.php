<?php
/**
 * Plugin Name: DanangStay – Tùy chỉnh (màu, menu, SEO)
 * Description: Tông màu theo hiephoangmt.com (navy + cam), sửa thanh menu bị ẩn trên máy tính, sửa SEO (og:locale, hreflang x-default), Việt hóa chữ còn sót trên bản tiếng Việt, ẩn tên đăng nhập quản trị.
 * Version: 1.9.1
 * Requires PHP: 7.4
 * Author: DanangStay
 */

if (!defined('ABSPATH')) {
    exit;
}

/* ------------------------------------------------------------------ */
/* 1. Font + màu + sửa menu                                            */
/* ------------------------------------------------------------------ */

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'dst-fonts',
        'https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap',
        [],
        null
    );
}, 20);

add_action('wp_head', function () {
    echo "<style id=\"dst-custom\">\n" . dst_css() . "\n</style>\n";
}, 99);

function dst_css()
{
    return <<<'CSS'
/* Tông màu hiephoangmt.com: navy #0b2447 + cam #ea580c, nền trắng */
:root {
  --ivory: #f3f6fa; --paper: #ffffff; --sand: #e2e7ef;
  --ink: #14223a; --ink-2: #44526a; --muted: #7a869a; --line: #e2e7ef;
  --bronze: #ea580c; --bronze-2: #ff8a3d; --lantern: #c2410c;
  --sea: #0b2447; --sea-2: #133a6b;
  --serif: "Playfair Display", "Noto Serif JP", "Noto Serif KR", "Noto Serif SC", Georgia, "Times New Roman", serif;
  --sans: "Be Vietnam Pro", "Hiragino Sans", "Apple SD Gothic Neo", "Malgun Gothic", "PingFang SC", "Microsoft YaHei", system-ui, -apple-system, "Segoe UI", sans-serif;
}
.brand__word { font-family: var(--serif); }

/* Thanh menu khi cuộn / trang không có ảnh lớn: nền navy, chữ trắng */
.site-header.is-solid, body:not(.has-hero) .site-header {
  background: rgba(11, 36, 71, .97); color: #fff; box-shadow: 0 1px 0 rgba(255,255,255,.08);
}
.site-header .nav a[aria-current] { color: var(--bronze-2); }

/* Nút: cam như hiephoangmt.com */
.header-cta, .site-header.is-solid .header-cta, body:not(.has-hero) .header-cta {
  background: var(--bronze); border-color: var(--bronze); color: #fff;
}
.header-cta:hover, .site-header.is-solid .header-cta:hover, body:not(.has-hero) .header-cta:hover {
  background: var(--lantern); border-color: var(--lantern); color: #fff;
}
.btn--solid:hover { background: var(--lantern); border-color: var(--lantern); }
.float-cta { background: var(--bronze); color: #fff; }
.float-cta:hover { background: var(--lantern); }
.hero__meta .kicker { color: #ffa04d; }

/* Chân trang navy đậm */
.site-footer { background: #071a32; color: #9fb0c6; }
.site-footer h4 { color: var(--bronze-2); }
.footer-top { border-bottom-color: rgba(159,176,198,.18); }
.footer-bottom { color: rgba(159,176,198,.7); }

/* Các khối nền tối (ảnh lớn, khối "Để người địa phương tìm phòng", vé máy bay): navy */
.hero, .article-hero, .concierge, .flight-hero { background: #0b2447; }
.concierge { background: linear-gradient(135deg, #0b2447, #133a6b); }

/* Hộp "Trang này có bản tiếng…" trên điện thoại: không che nút đặt phòng */
@media (max-width: 600px) {
  .lang-hint { left: 16px; right: 16px; transform: none; max-width: none; bottom: 84px; font-size: 13.5px; }
}

/* Menu mở trên điện thoại: nền trắng, chữ đậm */
body.menu-open .site-header, body.nav-compact.menu-open .site-header { background: #fff; color: var(--ink); }

/* Bảng trong bài viết: gọn, dễ đọc; trên điện thoại mỗi dòng thành một thẻ */
.prose table { width: 100%; border-collapse: collapse; margin: 1.6em 0; font-size: 16px; line-height: 1.5; }
.prose th, .prose td { padding: 12px 14px; border-bottom: 1px solid var(--line); text-align: left; vertical-align: top; }
.prose thead th { background: var(--sea); color: #fff; font: 600 12px/1.3 var(--sans); letter-spacing: .08em; text-transform: uppercase; }
.prose tbody tr:nth-child(even) td { background: var(--ivory); }
@media (max-width: 700px) {
  .prose table, .prose tbody, .prose tr, .prose td { display: block; width: 100%; }
  .prose thead { display: none; }
  .prose tr { border: 1px solid var(--line); border-radius: 10px; margin: 0 0 12px; padding: 12px 16px; background: #fff; }
  .prose tbody tr:nth-child(even) td { background: none; }
  .prose td { border: 0; padding: 3px 0; font-size: 15.5px; }
  .prose td:first-child { font-weight: 700; font-size: 17px; color: var(--ink); padding-bottom: 6px; }
  .prose td[data-label]:not(:first-child)::before { content: attr(data-label) ": "; font-weight: 600; color: var(--bronze); }
}

/* Menu ☰ trên máy tính / máy tính bảng: ngăn kéo gọn bên phải thay vì phủ kín màn hình */
@media (min-width: 901px) {
  body.menu-open .nav, body.nav-compact.menu-open .nav {
    left: auto; right: 0; width: min(420px, 100%);
    padding: 28px 32px 48px; border-left: 1px solid var(--line);
    box-shadow: -30px 0 60px -30px rgba(11, 36, 71, .45);
  }
  body.menu-open .nav a, body.nav-compact.menu-open .nav a { font-size: 22px; }
  body.menu-open .nav__sub a { font-size: 15px !important; }
  body.menu-open::after {
    content: ""; position: fixed; inset: 84px 0 0 0; z-index: 48;
    background: rgba(11, 36, 71, .35); pointer-events: none;
  }
}
/* Khi đăng nhập (có thanh quản trị) menu ☰ không bị lệch */
.admin-bar.menu-open .nav, .admin-bar.nav-compact.menu-open .nav { top: 116px; height: calc(100dvh - 116px); }
.admin-bar.menu-open::after { top: 116px; }
@media (max-width: 782px) {
  .admin-bar.menu-open .nav, .admin-bar.nav-compact.menu-open .nav { top: 130px; height: calc(100dvh - 130px); }
}

/* Sửa lỗi thanh menu bị ẩn trên máy tính:
   menu con đang ẩn vẫn chiếm chỗ bên phải nên giao diện tưởng menu bị tràn và chuyển sang nút ☰ */
@media (min-width: 1201px) {
  body:not(.menu-open) .nav__group:not(:hover):not(:focus-within):not(.is-open) > .nav__sub { display: none; }
  body:not(.menu-open) .nav > .nav__group:nth-last-child(-n+2) > .nav__sub { left: auto; right: -18px; }
}
CSS;
}

// Không cho Google Dịch (Chrome) dịch sai tên riêng: "Hue" → "Màu sắc", "Book" → "Sách"…
add_action('wp_footer', function () {
    ?>
<script id="dst-notranslate">
(function () {
  var names = ['Hue', 'Huế', 'Hoi An', 'Hội An', 'Da Nang', 'Đà Nẵng', 'My Khe', 'Mỹ Khê', 'Son Tra', 'Sơn Trà', 'Man Thai', 'Mân Thái', 'Ba Na', 'Ba Na Hills', 'Bà Nà', 'An Thuong', 'An Thượng', 'Hai Van', 'Hải Vân', 'Cu Lao Cham', 'Cù Lao Chàm', 'DanangStay'];
  document.querySelectorAll('.prose table').forEach(function (t) {
    var heads = Array.prototype.map.call(t.querySelectorAll('thead th'), function (th) { return th.textContent.trim(); });
    if (!heads.length) return;
    t.querySelectorAll('tbody tr').forEach(function (tr) {
      Array.prototype.forEach.call(tr.children, function (td, i) { if (heads[i]) td.setAttribute('data-label', heads[i]); });
    });
  });
  document.querySelectorAll('.brand, .brand__word').forEach(function (e) { e.setAttribute('translate', 'no'); });
  document.querySelectorAll('a, button, span, li, h3, h4, strong, em, td, th, label, option').forEach(function (e) {
    if (e.children.length) return;
    var t = (e.textContent || '').trim();
    if (names.indexOf(t) !== -1) e.setAttribute('translate', 'no');
  });
})();
</script>
    <?php
}, 99);

/* ------------------------------------------------------------------ */
/* 2. SEO: og:locale đầy đủ (vi → vi_VN) + hreflang x-default           */
/* ------------------------------------------------------------------ */

add_action('template_redirect', function () {
    if (is_admin() || is_feed() || wp_doing_ajax() || (defined('REST_REQUEST') && REST_REQUEST)) {
        return;
    }
    ob_start('dst_filter_html');
}, 0);

function dst_filter_html($html)
{
    if (!is_string($html) || stripos($html, '<html') === false) {
        return $html;
    }
    $html = apply_filters('dst_html', $html);
    $map = ['vi' => 'vi_VN', 'en' => 'en_US', 'ja' => 'ja_JP', 'ko' => 'ko_KR', 'zh' => 'zh_CN', 'ru' => 'ru_RU', 'fr' => 'fr_FR', 'de' => 'de_DE'];
    $html = preg_replace_callback(
        '#(<meta\s+property="og:locale(?::alternate)?"\s+content=")([a-zA-Z]{2})(")#',
        function ($m) use ($map) {
            $k = strtolower($m[2]);
            return $m[1] . (isset($map[$k]) ? $map[$k] : $m[2]) . $m[3];
        },
        $html
    );
    // Đổi tên mục menu "Đà Nẵng" (gồm cả Hội An, Huế) thành "Khám phá" theo từng ngôn ngữ
    $labels = ['vi' => 'Khám phá', 'en' => 'Explore', 'ko' => '여행 가이드', 'ja' => '観光ガイド', 'zh' => '旅行指南', 'ru' => 'Путеводитель', 'fr' => 'Découvrir', 'de' => 'Entdecken'];
    $lang = preg_match('#<html[^>]*\slang="([a-z]{2})#i', $html, $lm) ? strtolower($lm[1]) : 'en';
    if (isset($labels[$lang])) {
        $html = preg_replace('#(/discover/"\s+class="nav__parent"[^>]*>)[^<]+#u', '${1}' . $labels[$lang], $html);
    }
    if (preg_match('#<html[^>]*\slang="vi#i', $html)) {
        $html = dst_viet_hoa($html);
    }
    if (strpos($html, 'hreflang="x-default"') === false) {
        $html = preg_replace_callback(
            '#<link\s+rel="alternate"\s+(?:href="([^"]+)"\s+hreflang="en"|hreflang="en"\s+href="([^"]+)")\s*/?>#',
            function ($m) {
                $url = $m[1] !== '' ? $m[1] : $m[2];
                return $m[0] . "\n" . '<link rel="alternate" href="' . $url . '" hreflang="x-default" />';
            },
            $html,
            1
        );
    }
    return $html;
}

/**
 * Bản tiếng Việt (/vi/): đổi các chữ còn sót tiếng Anh (địa điểm, "Annual"…) sang tiếng Việt.
 * Chỉ đổi phần chữ hiển thị giữa các thẻ HTML, không đụng link hay code.
 * Cách sửa tận gốc: vào trang quản trị → Sự kiện → mở từng sự kiện bản tiếng Việt và sửa ô địa điểm.
 */
function dst_viet_hoa($html)
{
    $phrases = [
        'Hoai River Square, An Hoi sculpture garden and old-town streets' => 'Quảng trường sông Hoài, vườn tượng An Hội và các tuyến phố cổ',
        'Ariyana Convention Centre, 107 Vo Nguyen Giap' => 'Trung tâm Hội nghị Ariyana, 107 Võ Nguyên Giáp',
        'My Son Sanctuary (towers B and C)' => 'Khu đền tháp Mỹ Sơn (nhóm tháp B và C)',
        'Bach Dang walking street and both banks by the Dragon Bridge' => 'Phố đi bộ Bạch Đằng và hai bờ sông quanh cầu Rồng',
        'East Sea Park (Công viên Biển Đông)' => 'Công viên Biển Đông',
        'Han River, stands on Tran Hung Dao street' => 'Sông Hàn, khán đài trên đường Trần Hưng Đạo',
        'City beaches and coastal roads' => 'Các bãi biển và tuyến đường ven biển',
        'Ngo Mon Square, Imperial City' => 'Quảng trường Ngọ Môn, Hoàng thành Huế',
        'Marble Mountains (Ngu Hanh Son)' => 'Danh thắng Ngũ Hành Sơn',
        'Every 15th of the month' => 'Ngày 15 hằng tháng',
        ' · Annual' => ' · Hằng năm',
    ];
    $exact = [
        'Hoi An Ancient Town' => 'Phố cổ Hội An',
        'Hoi An Ancient Quarter' => 'Khu phố cổ Hội An',
        'East Sea Park' => 'Công viên Biển Đông',
        'Da Nang Museum' => 'Bảo tàng Đà Nẵng',
        'Perfume River, Hue' => 'Sông Hương, Huế',
        'An Hai ward' => 'Phường An Hải',
        'Hue' => 'Huế',
        'Da Nang' => 'Đà Nẵng',
        'Hoi An' => 'Hội An',
        'Phone' => 'Điện thoại',
        'Shanghai' => 'Thượng Hải',
        'Taipei' => 'Đài Bắc',
        'Hong Kong' => 'Hồng Kông',
    ];
    // Chỉ xử lý phần <body>, bỏ qua <script>/<style>
    $parts = preg_split('#(<script\b.*?</script>|<style\b.*?</style>|<head\b.*?</head>)#is', $html, -1, PREG_SPLIT_DELIM_CAPTURE);
    foreach ($parts as $i => $part) {
        if (preg_match('#^<(script|style|head)\b#i', $part)) {
            continue;
        }
        $parts[$i] = preg_replace_callback('#>([^<>]+)<#', function ($m) use ($phrases, $exact) {
            $t = $m[1];
            $trim = trim($t);
            if ($trim === '' || !preg_match('/[A-Za-z]/', $trim)) {
                return $m[0];
            }
            if (isset($exact[$trim])) {
                return '>' . str_replace($trim, $exact[$trim], $t) . '<';
            }
            return '>' . strtr($t, $phrases) . '<';
        }, $part);
    }
    return implode('', $parts);
}

/* ------------------------------------------------------------------ */
/* 3. Bảo mật: không lộ tên đăng nhập, bỏ sitemap thừa                  */
/* ------------------------------------------------------------------ */

// Bỏ sitemap tác giả (lộ tên đăng nhập) và sitemap /dat-phong/ của plugin DanangStay Landing (đang 404)
add_filter('wp_sitemaps_add_provider', function ($provider, $name) {
    return in_array($name, ['users', 'danangstay'], true) ? false : $provider;
}, 10, 2);

// Ẩn danh sách người dùng trong REST API với khách chưa đăng nhập
add_filter('rest_endpoints', function ($endpoints) {
    if (!is_user_logged_in()) {
        foreach (array_keys($endpoints) as $route) {
            if (strpos($route, '/wp/v2/users') === 0) {
                unset($endpoints[$route]);
            }
        }
    }
    return $endpoints;
});

// Trang tác giả (/author/..., ?author=1) chuyển về trang chủ
add_action('template_redirect', function () {
    if (is_author()) {
        wp_safe_redirect(home_url('/'), 301);
        exit;
    }
}, 1);

/* ------------------------------------------------------------------ */
/* 4. Khóa API riêng cho trợ lý (hosting chặn header Authorization)    */
/*    Gửi khóa qua header X-DS-Token; chỉ dùng cho REST API (/wp-json). */
/* ------------------------------------------------------------------ */

function dst_is_rest_request()
{
    $uri = isset($_SERVER['REQUEST_URI']) ? (string) wp_unslash($_SERVER['REQUEST_URI']) : '';
    return strpos($uri, '/wp-json/') !== false || isset($_GET['rest_route']); // phpcs:ignore WordPress.Security.NonceVerification
}

add_filter('determine_current_user', function ($user_id) {
    if ($user_id || empty($_SERVER['HTTP_X_DS_TOKEN']) || !dst_is_rest_request()) {
        return $user_id;
    }
    $hash = (string) get_option('dst_api_key_hash', '');
    $uid  = (int) get_option('dst_api_user', 0);
    if ($hash === '' || $uid <= 0) {
        return $user_id;
    }
    $key = (string) wp_unslash($_SERVER['HTTP_X_DS_TOKEN']);
    if (!hash_equals($hash, hash('sha256', $key))) {
        return $user_id;
    }
    update_option('dst_api_last_used', current_time('mysql'), false);
    return $uid;
}, 30);

add_action('admin_menu', function () {
    add_options_page('DanangStay API', 'DanangStay API', 'manage_options', 'danangstay-api', 'dst_api_page');
});

function dst_api_page()
{
    if (!current_user_can('manage_options')) {
        return;
    }
    $new_key = '';
    if (isset($_POST['dst_action']) && check_admin_referer('dst_api')) {
        if ($_POST['dst_action'] === 'create') {
            $new_key = 'dsk_' . bin2hex(random_bytes(24));
            update_option('dst_api_key_hash', hash('sha256', $new_key), false);
            update_option('dst_api_user', get_current_user_id(), false);
            update_option('dst_api_created', current_time('mysql'), false);
            delete_option('dst_api_last_used');
        } elseif ($_POST['dst_action'] === 'revoke') {
            delete_option('dst_api_key_hash');
            delete_option('dst_api_user');
            delete_option('dst_api_created');
            delete_option('dst_api_last_used');
        }
    }
    $has = (string) get_option('dst_api_key_hash', '') !== '';
    echo '<div class="wrap"><h1>DanangStay API – khóa cho trợ lý</h1>';
    echo '<p>Khóa này cho phép trợ lý (Claude) đăng bài, tải ảnh và cập nhật website qua REST API, với quyền của tài khoản tạo khóa. Thu hồi khóa bất cứ lúc nào.</p>';
    if ($new_key) {
        echo '<div class="notice notice-success"><p><strong>Khóa mới (chỉ hiện một lần — copy ngay):</strong></p>';
        echo '<p><input type="text" readonly class="large-text code" value="' . esc_attr($new_key) . '" onclick="this.select()"></p>';
        echo '<p>Dán khóa này vào ô bảo mật trợ lý gửi (không dán vào khung chat).</p></div>';
    }
    if ($has) {
        $u = get_userdata((int) get_option('dst_api_user'));
        echo '<p>Trạng thái: <strong style="color:#00a32a">Đang bật</strong> · tài khoản: ' . esc_html($u ? $u->user_login : '?')
            . ' · tạo lúc: ' . esc_html((string) get_option('dst_api_created'))
            . ' · dùng lần cuối: ' . esc_html((string) get_option('dst_api_last_used', 'chưa dùng')) . '</p>';
    } else {
        echo '<p>Trạng thái: <strong>Chưa có khóa</strong></p>';
    }
    echo '<form method="post" style="display:inline-block;margin-right:8px">';
    wp_nonce_field('dst_api');
    echo '<input type="hidden" name="dst_action" value="create">';
    submit_button($has ? 'Tạo khóa mới (khóa cũ hết hiệu lực)' : 'Tạo khóa', 'primary', 'submit', false);
    echo '</form>';
    if ($has) {
        echo '<form method="post" style="display:inline-block">';
        wp_nonce_field('dst_api');
        echo '<input type="hidden" name="dst_action" value="revoke">';
        submit_button('Thu hồi khóa', 'delete', 'submit', false);
        echo '</form>';
    }
    echo '</div>';
}

/* ------------------------------------------------------------------ */
/* 5. API cho trợ lý: liên kết bản dịch Polylang, tự cập nhật plugin    */
/* ------------------------------------------------------------------ */

add_action('rest_api_init', function () {
    // Gán ngôn ngữ + liên kết các bản dịch: {"translations":{"vi":188,"ko":189}}
    register_rest_route('danangstay/v1', '/translations', [
        'methods' => 'POST',
        'permission_callback' => function () {
            return current_user_can('edit_others_posts');
        },
        'callback' => function (WP_REST_Request $r) {
            if (!function_exists('pll_save_post_translations') || !function_exists('pll_set_post_language')) {
                return new WP_Error('no_polylang', 'Polylang chưa bật', ['status' => 400]);
            }
            $map = [];
            foreach ((array) $r->get_param('translations') as $lang => $pid) {
                $lang = sanitize_key($lang);
                $pid = (int) $pid;
                if (!$pid || !get_post($pid) || !current_user_can('edit_post', $pid)) {
                    return new WP_Error('bad_post', 'Không sửa được bài ' . $pid, ['status' => 400]);
                }
                $map[$lang] = $pid;
            }
            if (count($map) < 1) {
                return new WP_Error('empty', 'Thiếu translations', ['status' => 400]);
            }
            foreach ($map as $lang => $pid) {
                pll_set_post_language($pid, $lang);
            }
            if (count($map) > 1) {
                pll_save_post_translations($map);
            }
            return ['ok' => true, 'translations' => pll_get_post_translations(reset($map))];
        },
    ]);

    // Tự cập nhật CHÍNH plugin này từ tệp zip gửi lên (field "package")
    register_rest_route('danangstay/v1', '/self-update', [
        'methods' => 'POST',
        'permission_callback' => function () {
            return current_user_can('install_plugins') && current_user_can('update_plugins');
        },
        'callback' => 'dst_self_update',
    ]);
});

function dst_self_update(WP_REST_Request $r)
{
    $files = $r->get_file_params();
    if (empty($files['package']['tmp_name']) || !is_uploaded_file($files['package']['tmp_name'])) {
        return new WP_Error('no_file', 'Thiếu tệp package', ['status' => 400]);
    }
    if (!class_exists('ZipArchive')) {
        return new WP_Error('no_zip', 'Máy chủ thiếu ZipArchive', ['status' => 500]);
    }
    // Chỉ chấp nhận gói của chính plugin này
    $zip = new ZipArchive();
    if ($zip->open($files['package']['tmp_name']) !== true) {
        return new WP_Error('bad_zip', 'Tệp zip lỗi', ['status' => 400]);
    }
    $ok = $zip->locateName('danangstay-tuy-chinh/danangstay-tuy-chinh.php') !== false;
    for ($i = 0; $ok && $i < $zip->numFiles; $i++) {
        $name = $zip->getNameIndex($i);
        if (strpos($name, 'danangstay-tuy-chinh/') !== 0 || strpos($name, '..') !== false) {
            $ok = false;
        }
    }
    $zip->close();
    if (!$ok) {
        return new WP_Error('wrong_package', 'Chỉ nhận gói danangstay-tuy-chinh', ['status' => 400]);
    }

    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
    require_once ABSPATH . 'wp-admin/includes/misc.php';
    require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
    $tmp = wp_tempnam('danangstay-tuy-chinh.zip');
    if (!@copy($files['package']['tmp_name'], $tmp)) {
        return new WP_Error('copy_failed', 'Không chép được tệp tạm', ['status' => 500]);
    }
    $skin = new WP_Ajax_Upgrader_Skin();
    $upgrader = new Plugin_Upgrader($skin);
    $result = $upgrader->install($tmp, ['overwrite_package' => true]);
    @unlink($tmp);
    if (is_wp_error($result) || !$result) {
        $err = is_wp_error($result) ? $result : $skin->get_errors();
        return new WP_Error('install_failed', is_wp_error($err) ? $err->get_error_message() : 'Cài thất bại', ['status' => 500]);
    }
    $file = 'danangstay-tuy-chinh/danangstay-tuy-chinh.php';
    if (!is_plugin_active($file)) {
        activate_plugin($file);
    }
    $data = get_plugin_data(WP_PLUGIN_DIR . '/' . $file, false, false);
    if (function_exists('opcache_reset')) {
        @opcache_reset();
    }
    return ['ok' => true, 'version' => $data['Version']];
}

/* ------------------------------------------------------------------ */
/* 6. Khung dự báo thời tiết 7 ngày: chèn <div class="ds-weather"></div> */
/*    vào bài viết. Dữ liệu Open-Meteo (miễn phí), trình duyệt khách tự tải. */
/* ------------------------------------------------------------------ */

add_action('wp_head', function () {
    ?>
<style id="dst-weather-css">
.ds-weather { margin: 1.8em 0; border: 1px solid var(--line); border-radius: 12px; background: var(--ivory); padding: 20px; font-family: var(--sans); }
.ds-weather__head { display: flex; flex-wrap: wrap; justify-content: space-between; align-items: baseline; gap: 6px 16px; margin-bottom: 14px; }
.ds-weather__title { font: 600 18px/1.3 var(--sans); color: var(--ink); margin: 0; }
.ds-weather__note { font-size: 12.5px; color: var(--muted); }
.ds-weather__tabs { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 14px; }
.ds-weather__tabs button { border: 1px solid var(--line); background: #fff; color: var(--ink); border-radius: 999px; padding: 7px 14px; font: 600 13.5px/1 var(--sans); cursor: pointer; }
.ds-weather__tabs button[aria-selected="true"] { background: var(--sea); border-color: var(--sea); color: #fff; }
.ds-weather__days { display: grid; grid-template-columns: repeat(7, minmax(0, 1fr)); gap: 8px; }
.ds-weather__day { background: #fff; border: 1px solid var(--line); border-radius: 10px; padding: 12px 6px; text-align: center; font-size: 13.5px; color: var(--ink-2); }
.ds-weather__day b { display: block; color: var(--ink); font-size: 13.5px; }
.ds-weather__day .ic { font-size: 26px; line-height: 1.2; margin: 6px 0 2px; }
.ds-weather__day .t { font-weight: 700; color: var(--ink); font-size: 15px; }
.ds-weather__day .t span { font-weight: 500; color: var(--muted); }
.ds-weather__day .r { color: var(--sea-2); font-size: 12.5px; margin-top: 4px; }
.ds-weather__day .d { font-size: 11.5px; color: var(--muted); min-height: 2.6em; }
.ds-weather__err { color: var(--muted); font-size: 14px; }
@media (max-width: 700px) {
  .ds-weather { padding: 16px 14px; }
  .ds-weather__days { grid-template-columns: none; grid-auto-flow: column; grid-auto-columns: 104px; overflow-x: auto; padding-bottom: 6px; scroll-snap-type: x mandatory; }
  .ds-weather__day { scroll-snap-align: start; }
}
</style>
    <?php
}, 100);

add_action('wp_footer', function () {
    ?>
<script id="dst-weather">
(function () {
  var boxes = document.querySelectorAll('.ds-weather');
  if (!boxes.length) return;
  var lang = (document.documentElement.lang || 'en').slice(0, 2);
  var T = {
    vi: { title: 'Dự báo thời tiết 7 ngày tới', note: 'Cập nhật tự động · nguồn Open-Meteo', rain: 'Khả năng mưa', err: 'Chưa tải được dự báo. Vui lòng thử lại sau.', today: 'Hôm nay',
          places: ['Đà Nẵng', 'Hội An', 'Huế', 'Đỉnh Bà Nà'], days: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
          w: { 0: 'Trời quang', 1: 'Ít mây', 2: 'Ít mây', 3: 'Nhiều mây', 45: 'Sương mù', 48: 'Sương mù', 51: 'Mưa phùn', 53: 'Mưa phùn', 55: 'Mưa phùn', 61: 'Mưa nhỏ', 63: 'Mưa vừa', 65: 'Mưa to', 80: 'Mưa rào nhẹ', 81: 'Mưa rào', 82: 'Mưa rào to', 95: 'Dông', 96: 'Dông', 99: 'Dông' } },
    ko: { title: '향후 7일 일기예보', note: '자동 업데이트 · 출처 Open-Meteo', rain: '강수 확률', err: '예보를 불러오지 못했습니다. 잠시 후 다시 시도해 주세요.', today: '오늘',
          places: ['다낭', '호이안', '후에', '바나힐 정상'], days: ['일', '월', '화', '수', '목', '금', '토'],
          w: { 0: '맑음', 1: '구름 조금', 2: '구름 조금', 3: '흐림', 45: '안개', 48: '안개', 51: '이슬비', 53: '이슬비', 55: '이슬비', 61: '약한 비', 63: '비', 65: '강한 비', 80: '약한 소나기', 81: '소나기', 82: '강한 소나기', 95: '뇌우', 96: '뇌우', 99: '뇌우' } },
    en: { title: '7-day weather forecast', note: 'Updated automatically · data by Open-Meteo', rain: 'Chance of rain', err: 'Could not load the forecast. Please try again later.', today: 'Today',
          places: ['Da Nang', 'Hoi An', 'Hue', 'Ba Na summit'], days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
          w: { 0: 'Clear', 1: 'Mostly clear', 2: 'Partly cloudy', 3: 'Cloudy', 45: 'Fog', 48: 'Fog', 51: 'Drizzle', 53: 'Drizzle', 55: 'Drizzle', 61: 'Light rain', 63: 'Rain', 65: 'Heavy rain', 80: 'Light showers', 81: 'Showers', 82: 'Heavy showers', 95: 'Thunderstorm', 96: 'Thunderstorm', 99: 'Thunderstorm' } }
  };
  var L = T[lang] || T.en;
  var LAT = [16.0544, 15.8801, 16.4637, 15.9950], LON = [108.2022, 108.3380, 107.5909, 107.9960];
  function icon(c) {
    if (c === 0) return '☀️'; if (c <= 2) return '🌤️'; if (c === 3) return '☁️'; if (c === 45 || c === 48) return '🌫️';
    if (c >= 51 && c <= 57) return '🌦️'; if (c >= 95) return '⛈️'; return '🌧️';
  }
  function desc(c) { return L.w[c] || L.w[Math.floor(c / 10) * 10 + 1] || ''; }
  var url = 'https://api.open-meteo.com/v1/forecast?latitude=' + LAT.join(',') + '&longitude=' + LON.join(',') +
    '&daily=weather_code,temperature_2m_max,temperature_2m_min,precipitation_probability_max&timezone=Asia%2FHo_Chi_Minh&forecast_days=7';
  function load() {
    try { var c = JSON.parse(sessionStorage.getItem('dsWeather') || 'null'); if (c && Date.now() - c.t < 3600000) return Promise.resolve(c.d); } catch (e) {}
    return fetch(url).then(function (r) { if (!r.ok) throw new Error(r.status); return r.json(); }).then(function (d) {
      d = Array.isArray(d) ? d : [d];
      try { sessionStorage.setItem('dsWeather', JSON.stringify({ t: Date.now(), d: d })); } catch (e) {}
      return d;
    });
  }
  boxes.forEach(function (box) {
    box.setAttribute('translate', 'no');
    box.innerHTML = '<div class="ds-weather__head"><p class="ds-weather__title">⛅ ' + L.title + '</p><span class="ds-weather__note">' + L.note + '</span></div>' +
      '<div class="ds-weather__tabs" role="tablist"></div><div class="ds-weather__days" aria-live="polite"></div>';
    var tabs = box.querySelector('.ds-weather__tabs'), days = box.querySelector('.ds-weather__days');
    load().then(function (data) {
      function show(i) {
        Array.prototype.forEach.call(tabs.children, function (b, j) { b.setAttribute('aria-selected', i === j ? 'true' : 'false'); });
        var d = data[i].daily, html = '';
        for (var k = 0; k < d.time.length; k++) {
          var dt = new Date(d.time[k] + 'T12:00:00'), code = d.weather_code[k], p = d.precipitation_probability_max ? d.precipitation_probability_max[k] : null;
          html += '<div class="ds-weather__day"><b>' + (k === 0 ? L.today : L.days[dt.getDay()]) + ' ' + dt.getDate() + '/' + (dt.getMonth() + 1) + '</b>' +
            '<div class="ic" aria-hidden="true">' + icon(code) + '</div><div class="d">' + desc(code) + '</div>' +
            '<div class="t">' + Math.round(d.temperature_2m_max[k]) + '° <span>' + Math.round(d.temperature_2m_min[k]) + '°</span></div>' +
            (p === null ? '' : '<div class="r" title="' + L.rain + '">💧 ' + p + '%</div>') + '</div>';
        }
        days.innerHTML = html;
      }
      L.places.forEach(function (name, i) {
        if (!data[i]) return;
        var b = document.createElement('button'); b.type = 'button'; b.setAttribute('role', 'tab'); b.textContent = name;
        b.addEventListener('click', function () { show(i); }); tabs.appendChild(b);
      });
      show(0);
    }).catch(function () { days.innerHTML = '<p class="ds-weather__err">' + L.err + '</p>'; });
  });
})();
</script>
    <?php
}, 100);

/* ------------------------------------------------------------------ */
/* 7. IndexNow: tự báo Bing, Naver, Yandex… khi đăng / sửa bài          */
/* ------------------------------------------------------------------ */

function dst_indexnow_key()
{
    $k = (string) get_option('dst_indexnow_key', '');
    if (!preg_match('/^[a-f0-9]{32}$/', $k)) {
        $k = bin2hex(random_bytes(16));
        update_option('dst_indexnow_key', $k, false);
    }
    return $k;
}

// Phục vụ tệp khóa https://danangstay.com.vn/{key}.txt
add_action('init', function () {
    $path = trim((string) wp_parse_url(isset($_SERVER['REQUEST_URI']) ? wp_unslash($_SERVER['REQUEST_URI']) : '', PHP_URL_PATH), '/');
    $key = dst_indexnow_key();
    if ($path === $key . '.txt') {
        status_header(200);
        header('Content-Type: text/plain; charset=utf-8');
        echo $key; // phpcs:ignore
        exit;
    }
}, 0);

function dst_indexnow_submit(array $urls)
{
    $urls = array_values(array_unique(array_filter(array_map('esc_url_raw', $urls))));
    if (!$urls) {
        return new WP_Error('empty', 'Không có URL');
    }
    $host = (string) wp_parse_url(home_url('/'), PHP_URL_HOST);
    $key = dst_indexnow_key();
    $res = wp_remote_post('https://api.indexnow.org/indexnow', [
        'timeout' => 15,
        'headers' => ['Content-Type' => 'application/json; charset=utf-8'],
        'body' => wp_json_encode([
            'host' => $host,
            'key' => $key,
            'keyLocation' => 'https://' . $host . '/' . $key . '.txt',
            'urlList' => array_slice($urls, 0, 10000),
        ]),
    ]);
    $code = is_wp_error($res) ? $res->get_error_message() : wp_remote_retrieve_response_code($res);
    update_option('dst_indexnow_last', ['time' => current_time('mysql'), 'count' => count($urls), 'result' => $code], false);
    return $code;
}

function dst_post_urls($post_id)
{
    $ids = [$post_id];
    if (function_exists('pll_get_post_translations')) {
        $ids = array_merge($ids, array_values(pll_get_post_translations($post_id)));
    }
    $urls = [];
    foreach (array_unique($ids) as $id) {
        if (get_post_status($id) === 'publish') {
            $urls[] = get_permalink($id);
        }
    }
    return $urls;
}

// Đăng mới hoặc sửa bài đã đăng → báo IndexNow (chạy nền sau khi lưu)
add_action('transition_post_status', function ($new, $old, $post) {
    if ($new !== 'publish' || !in_array($post->post_type, ['post', 'page'], true) || wp_is_post_revision($post)) {
        return;
    }
    if (!wp_next_scheduled('dst_indexnow_post', [$post->ID])) {
        wp_schedule_single_event(time() + 30, 'dst_indexnow_post', [$post->ID]);
    }
}, 10, 3);
add_action('dst_indexnow_post', function ($post_id) {
    dst_indexnow_submit(dst_post_urls($post_id));
});

// API cho trợ lý: gửi danh sách URL hoặc toàn bộ bài/trang đã đăng
add_action('rest_api_init', function () {
    register_rest_route('danangstay/v1', '/indexnow', [
        'methods' => 'POST',
        'permission_callback' => function () {
            return current_user_can('edit_others_posts');
        },
        'callback' => function (WP_REST_Request $r) {
            $urls = (array) $r->get_param('urls');
            if ($r->get_param('all')) {
                $ids = get_posts(['post_type' => ['post', 'page'], 'post_status' => 'publish', 'numberposts' => -1, 'fields' => 'ids', 'lang' => '']);
                foreach ($ids as $id) {
                    $urls[] = get_permalink($id);
                }
                $urls[] = home_url('/');
                if (function_exists('pll_languages_list')) {
                    foreach (pll_languages_list() as $l) {
                        $urls[] = pll_home_url($l);
                    }
                }
            }
            $code = dst_indexnow_submit($urls);
            return ['result' => is_wp_error($code) ? $code->get_error_message() : $code, 'count' => count(array_unique($urls)), 'key_url' => home_url('/' . dst_indexnow_key() . '.txt')];
        },
    ]);
});

/* ------------------------------------------------------------------ */
/* 8. Thẻ xác minh Google / Naver / Bing (trợ lý đặt qua API)           */
/* ------------------------------------------------------------------ */

add_action('wp_head', function () {
    $v = (array) get_option('dst_verify', []);
    $names = ['google' => 'google-site-verification', 'naver' => 'naver-site-verification', 'bing' => 'msvalidate.01'];
    foreach ($names as $k => $meta) {
        if (!empty($v[$k])) {
            echo '<meta name="' . esc_attr($meta) . '" content="' . esc_attr($v[$k]) . '" />' . "\n";
        }
    }
}, 1);

add_action('rest_api_init', function () {
    register_rest_route('danangstay/v1', '/verify', [
        'methods' => 'POST',
        'permission_callback' => function () {
            return current_user_can('manage_options');
        },
        'callback' => function (WP_REST_Request $r) {
            $v = (array) get_option('dst_verify', []);
            foreach (['google', 'naver', 'bing'] as $k) {
                $val = $r->get_param($k);
                if ($val !== null) {
                    // Nhận cả nguyên thẻ <meta ... content="..."> hoặc chỉ mã
                    if (preg_match('/content=["\']([^"\']+)/', (string) $val, $m)) {
                        $val = $m[1];
                    }
                    $v[$k] = preg_replace('/[^A-Za-z0-9_\-]/', '', (string) $val);
                }
            }
            update_option('dst_verify', $v, false);
            return ['ok' => true, 'verify' => $v];
        },
    ]);
});

/* ------------------------------------------------------------------ */
/* 9. Vé tham quan, liên hệ Vân Trần, tin mới, lưu ý vé máy bay         */
/* ------------------------------------------------------------------ */

function dst_lang()
{
    if (function_exists('pll_current_language') && pll_current_language()) {
        return pll_current_language();
    }
    return substr(get_locale(), 0, 2);
}

function dst_t($key)
{
    $t = [
        'vi' => ['call' => 'Gọi', 'contact' => 'Liên hệ đặt vé', 'name' => 'Vân Trần', 'role' => 'Tư vấn vé máy bay, vé tham quan & tour', 'news' => 'Tin mới cập nhật', 'more' => 'Xem tất cả', 'tickets' => 'Vé tham quan', 'hours' => 'Trả lời nhanh qua Zalo, 7:00–22:00', 'qr' => 'Quét mã để nhắn Zalo'],
        'ko' => ['call' => '전화', 'contact' => '예약 문의', 'name' => 'Vân Trần', 'role' => '항공권·입장권·투어 상담', 'news' => '최신 소식', 'more' => '전체 보기', 'tickets' => '입장권·투어', 'hours' => '카카오톡·Zalo·WhatsApp 빠른 답변, 7:00–22:00', 'qr' => 'QR 스캔으로 Zalo 문의'],
        'en' => ['call' => 'Call', 'contact' => 'Book with us', 'name' => 'Vân Trần', 'role' => 'Flights, attraction tickets & tours', 'news' => 'Latest updates', 'more' => 'See all', 'tickets' => 'Attraction tickets', 'hours' => 'Fast replies on WhatsApp & Zalo, 7:00–22:00', 'qr' => 'Scan to chat on Zalo'],
    ];
    $l = dst_lang();
    $set = isset($t[$l]) ? $t[$l] : $t['en'];
    return $set[$key];
}

// [ds_lien_he] – hộp liên hệ Vân Trần
add_shortcode('ds_lien_he', function () {
    $phone = '0909669325';
    $intl = '84909669325';
    $avatar = (string) get_option('dst_contact_avatar', '');
    $qr = (string) get_option('dst_contact_qr', '');
    $av = $avatar ? '<img class="ds-contact__photo" src="' . esc_url($avatar) . '" alt="' . esc_attr(dst_t('name')) . '" width="56" height="56" loading="lazy">' : '<span class="ds-contact__avatar" aria-hidden="true">VT</span>';
    $qrh = $qr ? '<figure class="ds-contact__qr"><img src="' . esc_url($qr) . '" alt="QR Zalo ' . esc_attr(dst_t('name')) . '" width="132" height="132" loading="lazy"><figcaption>' . esc_html(dst_t('qr')) . '</figcaption></figure>' : '';
    return '<div class="ds-contact' . ($qr ? ' has-qr' : '') . '" translate="no">'
        . '<div class="ds-contact__who">' . $av . '<div><strong>' . esc_html(dst_t('name')) . '</strong><br><span>' . esc_html(dst_t('role')) . '</span></div></div>'
        . '<div class="ds-contact__btns">'
        . '<a class="ds-btn ds-btn--call" href="tel:' . $phone . '">📞 ' . esc_html(dst_t('call')) . ' 0909 669 325</a>'
        . '<a class="ds-btn ds-btn--zalo" href="https://zalo.me/' . $phone . '" target="_blank" rel="noopener">Zalo</a>'
        . '<a class="ds-btn ds-btn--wa" href="https://wa.me/' . $intl . '" target="_blank" rel="noopener">WhatsApp</a>'
        . '</div><p class="ds-contact__note">' . esc_html(dst_t('hours')) . '</p>' . $qrh . '</div>';
});

// [ds_tin_moi so="6" danh_muc="news"] – bài mới nhất cùng ngôn ngữ
add_shortcode('ds_tin_moi', function ($atts) {
    $a = shortcode_atts(['so' => 6, 'danh_muc' => ''], $atts);
    $args = ['post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => max(1, min(12, (int) $a['so'])), 'ignore_sticky_posts' => true, 'no_found_rows' => true];
    if (function_exists('pll_current_language')) {
        $args['lang'] = dst_lang();
    }
    if ($a['danh_muc'] !== '') {
        $slug = sanitize_title($a['danh_muc']);
        $term = get_term_by('slug', $slug . '-' . dst_lang(), 'category') ?: get_term_by('slug', $slug, 'category');
        if ($term) {
            $args['cat'] = $term->term_id;
        }
    }
    $q = new WP_Query($args);
    if (!$q->have_posts()) {
        return '';
    }
    $out = '<section class="ds-news"><h2>' . esc_html(dst_t('news')) . '</h2><div class="ds-news__grid">';
    while ($q->have_posts()) {
        $q->the_post();
        $cats = get_the_category();
        $out .= '<a class="ds-news__item" href="' . esc_url(get_permalink()) . '">'
            . '<span class="ds-news__meta">' . esc_html(($cats ? $cats[0]->name . ' · ' : '') . get_the_date(dst_lang() === 'vi' ? 'd/m/Y' : (dst_lang() === 'ko' ? 'Y. n. j.' : 'M j, Y'))) . '</span>'
            . '<strong>' . esc_html(get_the_title()) . '</strong>'
            . '<span class="ds-news__ex">' . esc_html(wp_trim_words(get_the_excerpt(), 22)) . '</span></a>';
    }
    wp_reset_postdata();
    return $out . '</div></section>';
});

add_action('wp_head', function () {
    ?>
<style id="dst-blocks-css">
.ds-contact { margin: 1.8em 0; padding: 20px 22px; border-radius: 12px; background: var(--sea); color: #fff; font-family: var(--sans); }
.ds-contact__who { display: flex; align-items: center; gap: 14px; margin-bottom: 14px; }
.ds-contact__who strong { font-size: 18px; color: #fff; }
.ds-contact__who span { color: #c9d6e6; font-size: 14px; }
.ds-contact__avatar { width: 48px; height: 48px; border-radius: 50%; background: var(--bronze); display: grid; place-items: center; font-weight: 700; color: #fff !important; font-size: 16px !important; flex: none; }
.ds-contact__btns { display: flex; flex-wrap: wrap; gap: 10px; }
.ds-btn { display: inline-flex; align-items: center; gap: 6px; padding: 11px 16px; border-radius: 8px; font: 600 14px/1 var(--sans); text-decoration: none !important; color: #fff !important; }
.ds-btn--call { background: var(--bronze); } .ds-btn--zalo { background: #0068ff; } .ds-btn--wa { background: #25d366; }
.ds-contact__note { margin: 12px 0 0 !important; font-size: 13px !important; color: #c9d6e6 !important; }
.ds-tickets { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 14px; margin: 1.2em 0 2em; }
.ds-ticket { border: 1px solid var(--line); border-radius: 12px; padding: 16px 18px; background: #fff; font-family: var(--sans); }
.ds-ticket h3 { margin: 0 0 6px !important; font-size: 19px !important; }
.ds-ticket .where { font-size: 12px; letter-spacing: .08em; text-transform: uppercase; color: var(--bronze); font-weight: 700; }
.ds-ticket p { font-size: 15px !important; margin: 6px 0 !important; line-height: 1.55 !important; }
.ds-ticket .tip { font-size: 14px; color: var(--ink-2); background: var(--ivory); border-radius: 8px; padding: 8px 10px; margin-top: 8px; }
.ds-ticket a.ds-btn { margin-top: 10px; background: var(--bronze); padding: 9px 14px; font-size: 13.5px; }
.ds-contact, .ds-ticket, .ds-news, .ds-weather { text-align: left; }
.ds-contact *, .ds-ticket * { text-align: left !important; }
.ds-contact__who span { line-height: 1.45; display: inline-block; }
.ds-ticket .facts { list-style: none; margin: 10px 0 !important; padding: 0 !important; display: grid; gap: 4px; }
.ds-ticket .facts li { margin: 0 !important; padding: 0 !important; font-size: 14px; line-height: 1.45; color: var(--ink-2); }
.ds-ticket .facts li::before { display: none !important; }
.ds-ticket .facts li { display: grid !important; grid-template-columns: 132px 1fr; gap: 8px; }
.ds-ticket .facts span { color: var(--muted); font-weight: 600; }
.ds-ticket .tip ul { margin: 6px 0 0 !important; padding-left: 18px !important; }
.ds-ticket .tip li { font-size: 14px; line-height: 1.5; margin: 3px 0 !important; }
.ds-ticket .tip strong { display: block; color: var(--ink); }
.ds-ticket { display: flex; flex-direction: column; }
.ds-ticket a.ds-btn { align-self: flex-start; margin-top: auto; }
.ds-ticket .tip { margin-bottom: 12px; }
@media (max-width: 700px) { .ds-ticket .facts li { grid-template-columns: 1fr; gap: 0; margin-bottom: 6px !important; } .ds-ticket .facts span { font-size: 12.5px; letter-spacing: .02em; } }
.ds-news { margin: 2.4em 0 1em; }
.ds-news__grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 14px; }
.ds-news__item { display: flex; flex-direction: column; gap: 6px; padding: 16px 18px; border: 1px solid var(--line); border-radius: 12px; background: #fff; text-decoration: none !important; color: var(--ink) !important; transition: box-shadow .2s, transform .2s; }
.ds-news__item:hover { box-shadow: 0 12px 30px -18px rgba(11,36,71,.5); transform: translateY(-2px); }
.ds-news__item strong { font: 600 16.5px/1.35 var(--sans); }
.ds-news__meta { font-size: 12px; color: var(--bronze); font-weight: 600; letter-spacing: .04em; }
.ds-news__ex { font-size: 14px; color: var(--muted); line-height: 1.5; }
.ds-flight-notes { padding: 64px 0; background: #fff; }
.ds-flight-notes .wrap { max-width: 1040px; }
.ds-flight-notes h2 { margin: 0 0 8px; }
.ds-flight-notes .lead { color: var(--muted); margin: 0 0 24px; }
.ds-flight-notes__grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 14px; }
.ds-flight-notes__grid div { border: 1px solid var(--line); border-radius: 12px; padding: 16px 18px; background: var(--ivory); font-family: var(--sans); }
.ds-flight-notes__grid b { display: block; color: var(--ink); margin-bottom: 6px; font-size: 16px; }
.ds-flight-notes__grid p { margin: 0; font-size: 14.5px; line-height: 1.55; color: var(--ink-2); }
</style>
    <?php
}, 101);

// Trang "Vé tham quan" (id bản tiếng Việt lưu ở option dst_tickets_page)
function dst_tickets_url()
{
    $id = (int) get_option('dst_tickets_page', 0);
    if (!$id) {
        return '';
    }
    if (function_exists('pll_get_post')) {
        $tr = pll_get_post($id, dst_lang());
        if (!$tr) {
            return '';
        }
        $id = $tr;
    }
    return get_post_status($id) === 'publish' ? get_permalink($id) : '';
}

function dst_flight_notes_html()
{
    $l = dst_lang();
    $notes = [
        'vi' => ['Lưu ý khi đặt và đi vé máy bay', 'Những điều nên biết trước chuyến bay đến Đà Nẵng — đội ngũ DanangStay kiểm tra giúp bạn khi đặt vé.', [
            ['Giấy tờ tùy thân', 'Chuyến nội địa: CCCD, hộ chiếu hoặc tài khoản định danh điện tử VNeID mức 2 còn hiệu lực. Chuyến quốc tế: hộ chiếu còn hạn tối thiểu 6 tháng và thị thực nếu cần.'],
            ['Họ tên trên vé', 'Phải trùng khớp với giấy tờ, viết không dấu, đúng thứ tự họ – tên. Sai tên thường phải đổi vé, có phí.'],
            ['Giờ có mặt ở sân bay', 'Nội địa nên đến trước khoảng 90–120 phút, quốc tế trước khoảng 3 giờ. Quầy làm thủ tục thường đóng 40–60 phút trước giờ bay.'],
            ['Hành lý', 'Mỗi hãng, mỗi hạng vé quy định khác nhau về hành lý xách tay và ký gửi. Mua thêm ký gửi khi đặt vé luôn rẻ hơn mua tại sân bay.'],
            ['Pin sạc dự phòng', 'Chỉ mang trong hành lý xách tay, không để trong hành lý ký gửi và không sử dụng trên máy bay theo quy định hiện hành.'],
            ['Mùa cao điểm', 'Tết, dịp lễ 30/4, hè và cuối năm vé tăng nhanh — nên đặt trước 1–2 tháng. Tháng 10–12 là mùa mưa, có thể chậm chuyến; cân nhắc mua bảo hiểm.'],
            ['Đổi, hoàn vé', 'Vé giá rẻ thường không hoàn, đổi có phí. Hỏi rõ điều kiện trước khi thanh toán.'],
            ['Sân bay Đà Nẵng', 'Cách trung tâm khoảng 3 km. Ga T1 cho chuyến nội địa, ga T2 cho chuyến quốc tế. Có Grab, taxi và xe đưa đón đặt trước.'],
        ]],
        'ko' => ['항공권 예약·탑승 시 유의사항', '다낭행 항공편 전에 알아 두면 좋은 내용입니다. 예약할 때 DanangStay가 함께 확인해 드립니다.', [
            ['신분증·여권', '국제선은 잔여 유효기간 6개월 이상의 여권이 필요합니다. 한국 여권은 무비자 최대 45일 체류(최신 규정 확인 필요).'],
            ['항공권 영문 이름', '여권과 철자·순서가 정확히 같아야 합니다. 이름이 틀리면 대부분 유료 변경이 필요합니다.'],
            ['공항 도착 시간', '국제선은 출발 약 3시간 전, 국내선은 약 90–120분 전 도착을 권장합니다. 체크인 카운터는 보통 40–60분 전에 마감됩니다.'],
            ['수하물', '항공사·운임마다 기내·위탁 수하물 규정이 다릅니다. 위탁 수하물은 예약 시 추가하는 것이 공항보다 저렴합니다.'],
            ['보조배터리', '기내 수하물로만 반입하고, 현행 규정상 기내에서 사용하지 마세요.'],
            ['성수기', '설·연휴·여름·연말에는 가격이 빠르게 오르니 1–2개월 전 예약을 추천합니다. 10–12월 우기에는 지연 가능성이 있어 여행자 보험을 권장합니다.'],
            ['변경·환불', '특가 항공권은 대부분 환불 불가, 변경 시 수수료가 있습니다. 결제 전에 조건을 확인하세요.'],
            ['다낭 공항', '시내에서 약 3km. T1은 국내선, T2는 국제선입니다. Grab, 택시, 사전 예약 픽업을 이용할 수 있습니다.'],
        ]],
        'en' => ['Good to know before you fly', 'A few things to check before your flight to Da Nang — we double-check them for you when you book with us.', [
            ['Passport & visa', 'International flights need a passport valid for at least 6 months, plus a visa or e-visa if your nationality requires one.'],
            ['Name on the ticket', 'Must match your passport exactly, in the same order. Name corrections usually cost a fee.'],
            ['Airport arrival', 'About 3 hours before international flights and 90–120 minutes before domestic ones. Check-in desks usually close 40–60 minutes before departure.'],
            ['Baggage', 'Cabin and checked allowances differ by airline and fare. Adding checked bags when booking is cheaper than at the airport.'],
            ['Power banks', 'Carry them in cabin baggage only, never in checked bags, and do not use them on board under current rules.'],
            ['Peak seasons', 'Tet, public holidays, summer and year-end sell out fast — book 1–2 months ahead. October–December is the rainy season and delays can happen; consider travel insurance.'],
            ['Changes & refunds', 'Promo fares are usually non-refundable and changes cost a fee. Check the fare rules before paying.'],
            ['Da Nang Airport (DAD)', 'About 3 km from the city centre. Terminal 1 is domestic, Terminal 2 international. Grab, taxis and pre-booked transfers are available.'],
        ]],
    ];
    $n = isset($notes[$l]) ? $notes[$l] : $notes['en'];
    $html = '<section class="ds-flight-notes"><div class="wrap"><h2>' . esc_html($n[0]) . '</h2><p class="lead">' . esc_html($n[1]) . '</p><div class="ds-flight-notes__grid">';
    foreach ($n[2] as $it) {
        $html .= '<div><b>' . esc_html($it[0]) . '</b><p>' . esc_html($it[1]) . '</p></div>';
    }
    return $html . '</div>' . do_shortcode('[ds_lien_he]') . '</div></section>';
}

// Chèn link "Vé tham quan" vào menu Đặt phòng + mục lưu ý vào trang Vé máy bay
add_filter('dst_html', function ($html) {
    // Menu: bỏ số điện thoại sau "Vé máy bay", đổi "Đặt phòng" (bản tiếng Việt) thành "Dịch vụ"
    $html = preg_replace('#(<a href="[^"]*/flights/"[^>]*>[^<]*?)\s*·\s*0909\s?669\s?325\s*</a>#u', '$1</a>', $html);
    if (dst_lang() === 'vi' || preg_match('#<html[^>]*\slang="vi#i', $html)) {
        $html = preg_replace('#(/stays/"\s+class="nav__parent"[^>]*>)[^<]+#u', '${1}Dịch vụ', $html);
    }
    $url = dst_tickets_url();
    if ($url) {
        $html = preg_replace_callback('#(<a href="[^"]*/flights/">[^<]*</a>)#u', function ($m) use ($url) {
            return $m[1] . '<a href="' . esc_url($url) . '">' . esc_html(dst_t('tickets')) . '</a>';
        }, $html, 2);
    }
    if (preg_match('#<section class="flight-hero"#', $html) && strpos($html, '<section class="ds-flight-notes"') === false) {
        $notes = dst_flight_notes_html();
        $pos = strpos($html, '<h2 class="faq-h"');
        if ($pos !== false) {
            $sec = strrpos(substr($html, 0, $pos), '<section');
            if ($sec !== false) {
                $html = substr($html, 0, $sec) . $notes . substr($html, $sec);
            }
        }
    }
    return $html;
});

// API: lưu cài đặt cho trợ lý {"tickets_page": 123}
add_action('rest_api_init', function () {
    register_rest_route('danangstay/v1', '/options', [
        'methods' => 'POST',
        'permission_callback' => function () {
            return current_user_can('manage_options');
        },
        'callback' => function (WP_REST_Request $r) {
            if ($r->get_param('tickets_page') !== null) {
                update_option('dst_tickets_page', (int) $r->get_param('tickets_page'), false);
            }
            return ['ok' => true, 'tickets_page' => (int) get_option('dst_tickets_page', 0)];
        },
    ]);
});

/* ------------------------------------------------------------------ */
/* 10. Giao diện trang dịch vụ (Vé tham quan): hero, lưới rộng 3 cột    */
/* ------------------------------------------------------------------ */

add_filter('dst_html', function ($html) {
    $is_hub = strpos($html, 'class="ds-services"') !== false;
    if ((strpos($html, 'class="ds-tickets ') === false && !$is_hub) || strpos($html, '<header class="page-head">') === false) {
        return $html;
    }
    $l = dst_lang();
    if ($is_hub) {
        $home = trailingslashit(dst_lang_home());
        $tk = dst_tickets_url();
        $hub = [
            'vi' => ['DanangStay · Dịch vụ du lịch', 'Chỗ ở, vé máy bay, vé tham quan, xe đưa đón và tour ở Đà Nẵng – Hội An – Huế. Một đầu mối, người địa phương tư vấn, báo giá trong ngày.', ['stays/' => 'Chỗ ở', 'flights/' => 'Vé máy bay', 'tk' => 'Vé tham quan'], 'Nhắn Zalo', 'Gọi 0909 669 325'],
            'ko' => ['DanangStay · 여행 서비스', '다낭·호이안·후에 숙소, 항공권, 입장권, 픽업, 투어를 한 곳에서. 현지인 상담, 당일 견적.', ['stays/' => '숙소', 'flights/' => '항공권', 'tk' => '입장권·투어'], 'Zalo 문의', '전화 +84 909 669 325'],
            'en' => ['DanangStay · Travel services', 'Stays, flights, attraction tickets, transfers and tours in Da Nang, Hoi An and Hue — one local contact, same-day quotes.', ['stays/' => 'Stays', 'flights/' => 'Flights', 'tk' => 'Tickets'], 'Message on Zalo', 'Call +84 909 669 325'],
        ];
        $h = isset($hub[$l]) ? $hub[$l] : $hub['en'];
        $chips = '';
        foreach ($h[2] as $k => $name) {
            $u = $k === 'tk' ? $tk : $home . $k;
            if ($u) {
                $chips .= '<a href="' . esc_url($u) . '">' . esc_html($name) . '</a>';
            }
        }
        $html = preg_replace(
            '#<header class="page-head">\s*<div class="wrap">\s*<h1>(.*?)</h1>\s*</div>\s*</header>#s',
            '<header class="page-head ds-hero"><div class="wrap"><span class="ds-hero__kicker">' . esc_html($h[0]) . '</span><h1>$1</h1>'
            . '<p class="ds-hero__sub">' . esc_html($h[1]) . '</p>'
            . '<div class="ds-hero__actions"><a class="ds-btn ds-btn--zalo" href="https://zalo.me/0909669325" target="_blank" rel="noopener">💬 ' . esc_html($h[3]) . '</a>'
            . '<a class="ds-btn ds-btn--call" href="tel:0909669325">📞 ' . esc_html($h[4]) . '</a></div>'
            . '<nav class="ds-hero__chips">' . $chips . '</nav></div></header>',
            $html,
            1
        );
        return $html;
    }
    $tx = [
        'vi' => ['Dịch vụ · Vé tham quan &amp; tour', '18 điểm vui chơi nổi bật ở Đà Nẵng, Hội An, Huế — kinh nghiệm thực tế của người địa phương, báo giá trong ngày, vé điện tử gửi qua Zalo.', ['da-nang' => 'Đà Nẵng', 'hoi-an' => 'Hội An', 'hue' => 'Huế'], 'Nhắn Zalo đặt vé', 'Gọi 0909 669 325'],
        'ko' => ['서비스 · 입장권 &amp; 투어', '다낭·호이안·후에 인기 명소 18곳 — 현지인의 실제 팁, 당일 견적, 카카오톡·Zalo로 전자 티켓 발송.', ['da-nang' => '다낭', 'hoi-an' => '호이안', 'hue' => '후에'], 'Zalo로 예약 문의', '전화 +84 909 669 325'],
        'en' => ['Services · Tickets &amp; tours', '18 top attractions in Da Nang, Hoi An and Hue — local tips, same-day quotes, e-tickets sent via WhatsApp or Zalo.', ['da-nang' => 'Da Nang', 'hoi-an' => 'Hoi An', 'hue' => 'Hue'], 'Message us on Zalo', 'Call +84 909 669 325'],
    ];
    $t = isset($tx[$l]) ? $tx[$l] : $tx['en'];
    $chips = '';
    foreach ($t[2] as $id => $name) {
        $chips .= '<a href="#' . $id . '">' . esc_html($name) . '</a>';
    }
    $html = preg_replace(
        '#<header class="page-head">\s*<div class="wrap">\s*<h1>(.*?)</h1>\s*</div>\s*</header>#s',
        '<header class="page-head ds-hero"><div class="wrap"><span class="ds-hero__kicker">' . $t[0] . '</span><h1>$1</h1>'
        . '<p class="ds-hero__sub">' . esc_html($t[1]) . '</p>'
        . '<div class="ds-hero__actions"><a class="ds-btn ds-btn--zalo" href="https://zalo.me/0909669325" target="_blank" rel="noopener">💬 ' . esc_html($t[3]) . '</a>'
        . '<a class="ds-btn ds-btn--call" href="tel:0909669325">📞 ' . esc_html($t[4]) . '</a></div>'
        . '<nav class="ds-hero__chips" aria-label="Khu vực">' . $chips . '</nav></div></header>',
        $html,
        1
    );
    return str_replace('<body class="', '<body class="ds-service ', $html);
});

add_action('wp_head', function () {
    ?>
<style id="dst-service-css">
/* Hero */
body.ds-service .page-head.ds-hero { padding: 150px 0 56px; background: linear-gradient(135deg, #0b2447 0%, #133a6b 60%, #1e4f8a 100%); color: #fff; position: relative; overflow: hidden; }
body.ds-service .page-head.ds-hero::after { content: ""; position: absolute; right: -120px; bottom: -160px; width: 520px; height: 520px; border-radius: 50%; background: radial-gradient(circle, rgba(255,138,61,.28), rgba(255,138,61,0) 70%); pointer-events: none; }
body.ds-service .ds-hero h1 { color: #fff; font-size: clamp(32px, 4.2vw, 56px); font-weight: 500; line-height: 1.12; max-width: 920px; margin: 14px 0 16px; }
.ds-hero__kicker { display: inline-block; font: 700 12px/1 var(--sans); letter-spacing: .18em; text-transform: uppercase; color: #ffa04d; }
.ds-hero__sub { color: #d6e0ee !important; font-size: 18px !important; max-width: 720px !important; margin: 0 0 24px !important; line-height: 1.6; }
.ds-hero__actions { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 22px; }
.ds-hero__actions .ds-btn { padding: 14px 20px; font-size: 15px; }
.ds-hero__chips { display: flex; flex-wrap: wrap; gap: 8px; }
.ds-hero__chips a { padding: 8px 16px; border: 1px solid rgba(255,255,255,.35); border-radius: 999px; color: #fff; font: 600 13.5px/1 var(--sans); text-decoration: none; }
.ds-hero__chips a:hover { background: #fff; color: var(--sea); }
/* Bỏ chữ cái phóng to đầu bài trên trang dịch vụ */
body.ds-service .prose > p:first-of-type::first-letter { float: none; font-size: inherit; padding: 0; color: inherit; font-family: inherit; }
body.ds-service .prose > p:first-of-type { font-size: 19px; color: var(--ink); }
/* Lưới thẻ & tiêu đề khu vực trải rộng 3 cột */
body.ds-service .prose .ds-tickets, body.ds-service .prose h2.ds-area, body.ds-service .prose .ds-news {
  width: min(1200px, calc(100vw - 2 * var(--gutter))); position: relative; left: 50%; transform: translateX(-50%); max-width: none;
}
body.ds-service .prose .ds-tickets { grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 18px; }
@media (max-width: 1100px) { body.ds-service .prose .ds-tickets { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (max-width: 700px) { body.ds-service .prose .ds-tickets { grid-template-columns: 1fr; } }
body.ds-service .prose h2.ds-area { display: flex; align-items: center; gap: 14px; margin-top: 2.2em; padding-top: 28px; border-top: 1px solid var(--line); scroll-margin-top: 100px; }
body.ds-service .prose h2.ds-area::before { content: ""; width: 10px; height: 34px; border-radius: 4px; background: var(--bronze); }
body.ds-service .prose h2#hoi-an::before { background: #c2410c; }
body.ds-service .prose h2#hue::before { background: #7c3aed; }
/* Thẻ */
.ds-ticket { position: relative; border-top: 4px solid var(--bronze); box-shadow: 0 14px 34px -26px rgba(11,36,71,.55); transition: transform .2s, box-shadow .2s; }
.ds-ticket:hover { transform: translateY(-3px); box-shadow: 0 22px 44px -26px rgba(11,36,71,.6); }
.ds-tickets--ha .ds-ticket { border-top-color: #c2410c; }
.ds-tickets--hue .ds-ticket { border-top-color: #7c3aed; }
.ds-ticket .num { position: absolute; top: 14px; right: 16px; font: 700 13px/1 var(--sans); color: var(--muted); opacity: .6; }
.ds-ticket h3 { font-family: var(--serif) !important; font-size: 22px !important; line-height: 1.25 !important; color: var(--ink); padding-right: 28px; }
.ds-ticket .where { padding-right: 30px; }
/* Hộp liên hệ: căn giữa chữ VT */
.ds-contact__avatar { display: flex !important; align-items: center !important; justify-content: center !important; line-height: 1 !important; text-align: center !important; }
/* Bảng chọn nhanh */
body.ds-service .prose table td:first-child { font-weight: 600; color: var(--ink); white-space: nowrap; }
@media (max-width: 700px) { body.ds-service .prose table td:first-child { white-space: normal; } body.ds-service .page-head.ds-hero { padding: 120px 0 40px; } }
</style>
    <?php
}, 102);

/* ------------------------------------------------------------------ */
/* 11. Trang chính "Dịch vụ": ô dịch vụ, quy định mới, tin mới cột bên  */
/* ------------------------------------------------------------------ */

function dst_page_url($opt)
{
    $id = (int) get_option($opt, 0);
    if (!$id) {
        return '';
    }
    if (function_exists('pll_get_post')) {
        $id = (int) pll_get_post($id, dst_lang());
    }
    return $id && get_post_status($id) === 'publish' ? get_permalink($id) : '';
}

function dst_lang_home()
{
    return function_exists('pll_home_url') ? pll_home_url(dst_lang()) : home_url('/');
}

// [ds_dich_vu] – các ô dịch vụ
add_shortcode('ds_dich_vu', function () {
    $home = trailingslashit(dst_lang_home());
    $tickets = dst_tickets_url() ?: 'https://zalo.me/0909669325';
    $zalo = 'https://zalo.me/0909669325';
    $S = [
        'vi' => [
            ['🏨', 'Chỗ ở', 'Khách sạn, căn hộ, villa view biển ở Mỹ Khê, Mân Thái – Sơn Trà, trung tâm và Hội An. Người địa phương chọn phòng hợp lịch trình và ngân sách.', $home . 'stays/', 'Xem chỗ ở'],
            ['✈️', 'Vé máy bay', 'Vé nội địa và quốc tế đến Đà Nẵng, so sánh nhiều hãng, hỗ trợ hành lý, chỗ ngồi, đổi vé. Có sẵn lưu ý trước chuyến bay.', $home . 'flights/', 'Đặt vé máy bay'],
            ['🎟️', 'Vé tham quan', 'Bà Nà Hills, Núi Thần Tài, Suối Lương, Hòa Phú Thành, Ký Ức Hội An, VinWonders, Mỹ Sơn, Đại Nội Huế — kèm kinh nghiệm từng điểm.', $tickets, 'Xem 18 điểm'],
            ['🚗', 'Xe đưa đón & thuê xe', 'Đón sân bay cầm bảng tên, xe đi Bà Nà, Hội An, Mỹ Sơn, Huế; xe 4–29 chỗ, tài xế đúng giờ, giá báo trước.', $zalo, 'Đặt xe'],
            ['🧭', 'Tour & hướng dẫn viên', 'Tour riêng hoặc ghép: Sơn Trà, Hội An, Mỹ Sơn, Huế, Cù Lao Chàm; hướng dẫn viên tiếng Việt, English, 한국어.', $zalo, 'Hỏi tour'],
            ['🧳', 'Trọn gói chuyến đi', 'Một yêu cầu: vé máy bay + phòng + xe + vé tham quan. Gửi ngày đi và số người, chúng tôi lên lịch trình và báo giá.', $home . '#reserve', 'Gửi yêu cầu'],
        ],
        'ko' => [
            ['🏨', '숙소', '미케, 만타이–선짜, 시내, 호이안의 오션뷰 호텔·아파트·풀빌라. 현지인이 일정과 예산에 맞게 골라 드립니다.', $home . 'stays/', '숙소 보기'],
            ['✈️', '항공권', '다낭행 국내선·국제선, 항공사 비교, 수하물·좌석·변경 지원, 탑승 전 유의사항 안내.', $home . 'flights/', '항공권 예약'],
            ['🎟️', '입장권·투어', '바나힐, 탄따이 온천, 수이르엉, 호아푸타인, 호이안 메모리즈, 빈원더스, 미선, 후에 왕궁 — 명소별 현지 팁.', $tickets, '18곳 보기'],
            ['🚗', '픽업·차량 대절', '네임보드 공항 픽업, 바나힐·호이안·미선·후에 차량, 4–29인승, 시간 엄수, 사전 견적.', $zalo, '차량 예약'],
            ['🧭', '투어·가이드', '선짜, 호이안, 미선, 후에, 참섬 단독·조인 투어, 한국어 가이드.', $zalo, '투어 문의'],
            ['🧳', '여행 패키지', '항공권 + 숙소 + 차량 + 입장권을 한 번에. 날짜와 인원을 보내 주시면 일정과 견적을 드립니다.', $home . '#reserve', '문의하기'],
        ],
        'en' => [
            ['🏨', 'Stays', 'Sea-view hotels, apartments and villas in My Khe, Man Thai – Son Tra, the centre and Hoi An, hand-picked by locals.', $home . 'stays/', 'See stays'],
            ['✈️', 'Flights', 'Domestic and international flights to Da Nang, airline comparison, baggage, seats and changes — plus pre-flight tips.', $home . 'flights/', 'Book flights'],
            ['🎟️', 'Attraction tickets', 'Ba Na Hills, Than Tai hot springs, Suoi Luong, Hoa Phu Thanh, Hoi An Memories, VinWonders, My Son, Hue Citadel — with local tips.', $tickets, 'See 18 places'],
            ['🚗', 'Transfers & car hire', 'Airport pickup with name sign, cars to Ba Na, Hoi An, My Son and Hue; 4–29 seats, punctual drivers, prices agreed upfront.', $zalo, 'Book a car'],
            ['🧭', 'Tours & guides', 'Private or shared tours of Son Tra, Hoi An, My Son, Hue and Cham Islands; English, Korean and Vietnamese guides.', $zalo, 'Ask about tours'],
            ['🧳', 'Trip packages', 'One request for flights + room + transfers + tickets. Send dates and guests and we plan and quote it.', $home . '#reserve', 'Send a request'],
        ],
    ];
    $list = isset($S[dst_lang()]) ? $S[dst_lang()] : $S['en'];
    $out = '<div class="ds-services">';
    foreach ($list as $s) {
        $ext = strpos($s[3], 'zalo.me') !== false ? ' target="_blank" rel="noopener"' : '';
        $out .= '<a class="ds-service" href="' . esc_url($s[3]) . '"' . $ext . '><span class="ic" aria-hidden="true">' . $s[0] . '</span><strong>' . esc_html($s[1]) . '</strong><span class="tx">' . esc_html($s[2]) . '</span><span class="go">' . esc_html($s[4]) . ' →</span></a>';
    }
    return $out . '</div>';
});

// [ds_quy_dinh] – quy định mới cần biết
add_shortcode('ds_quy_dinh', function () {
    $Q = [
        'vi' => ['Quy định mới cần biết', 'Cập nhật 11/2026 · luôn đối chiếu với cơ quan chức năng, hãng bay trước khi đi', [
            ['Miễn thị thực 45 ngày', 'Công dân Hàn Quốc, Nhật Bản và một số nước châu Âu được miễn thị thực tối đa 45 ngày; chính sách hiện có hiệu lực đến 14/3/2028.'],
            ['Thị thực điện tử (e-visa)', 'Cấp cho công dân mọi quốc gia, thời hạn tối đa 90 ngày, nhập cảnh một hoặc nhiều lần; xin trên cổng chính thức của Cục Quản lý xuất nhập cảnh.'],
            ['Bay nội địa bằng VNeID', 'Hành khách Việt Nam có thể dùng tài khoản định danh điện tử VNeID mức 2 thay cho CCCD khi làm thủ tục bay nội địa.'],
            ['Sạc dự phòng trên máy bay', 'Chỉ mang trong hành lý xách tay và không sử dụng trong suốt chuyến bay.'],
            ['Địa giới hành chính mới', 'Từ 1/7/2025, Hội An và tỉnh Quảng Nam cũ thuộc thành phố Đà Nẵng; tên phường, xã trên địa chỉ có thể đã thay đổi, ứng dụng bản đồ có nơi chưa cập nhật.'],
            ['Vé cáp treo Bà Nà', 'Từ năm 2026, vé cáp treo Sun World Bà Nà Hills dùng được tối đa 3 ngày liên tiếp.'],
        ]],
        'ko' => ['꼭 알아야 할 새 규정', '2026년 11월 업데이트 · 출발 전 관계 기관·항공사에서 다시 확인하세요', [
            ['무비자 45일', '한국, 일본 및 일부 유럽 국가 국민은 최대 45일 무비자 체류가 가능하며, 현재 정책은 2028년 3월 14일까지 유효합니다.'],
            ['전자비자 (e-visa)', '모든 국가 국민에게 발급되며 최대 90일, 단수·복수 입국이 가능합니다. 베트남 출입국관리국 공식 사이트에서 신청하세요.'],
            ['보조배터리', '기내 수하물로만 반입하고 비행 중에는 사용할 수 없습니다.'],
            ['새 행정구역', '2025년 7월 1일부터 호이안과 옛 꽝남성이 다낭시에 편입되었습니다. 주소의 동·면 이름이 바뀌었을 수 있고 지도 앱에 반영되지 않은 곳도 있습니다.'],
            ['바나힐 케이블카 티켓', '2026년부터 썬월드 바나힐 케이블카 티켓은 최대 3일 연속 사용할 수 있습니다.'],
        ]],
        'en' => ['New rules worth knowing', 'Updated Nov 2026 · always double-check with the authorities or your airline before travelling', [
            ['45-day visa exemption', 'Citizens of South Korea, Japan and several European countries can stay visa-free for up to 45 days; the current policy runs until 14 March 2028.'],
            ['E-visa', 'Available to citizens of all countries, valid for up to 90 days with single or multiple entry; apply on the official Immigration Department portal.'],
            ['Power banks on board', 'Cabin baggage only, and they may not be used during the flight.'],
            ['New administrative map', 'Since 1 July 2025, Hoi An and the former Quang Nam province are part of Da Nang city; ward names in addresses may have changed and some map apps lag behind.'],
            ['Ba Na Hills cable car', 'From 2026, Sun World Ba Na Hills cable-car tickets can be used for up to 3 consecutive days.'],
        ]],
    ];
    $q = isset($Q[dst_lang()]) ? $Q[dst_lang()] : $Q['en'];
    $out = '<section class="ds-rules"><h3>📌 ' . esc_html($q[0]) . '</h3><p class="ds-rules__note">' . esc_html($q[1]) . '</p><ul>';
    foreach ($q[2] as $r) {
        $out .= '<li><b>' . esc_html($r[0]) . '</b><span>' . esc_html($r[1]) . '</span></li>';
    }
    return $out . '</ul></section>';
});

// Tin mới dạng gọn cho cột bên: [ds_tin_moi so="5" kieu="gon"]
add_filter('do_shortcode_tag', function ($out, $tag, $atts) {
    if ($tag !== 'ds_tin_moi' || empty($atts['kieu']) || $atts['kieu'] !== 'gon' || $out === '') {
        return $out;
    }
    return str_replace('<section class="ds-news">', '<section class="ds-news ds-news--side">', $out);
}, 10, 3);

// Link chữ "DỊCH VỤ / Book / 예약" trên menu → trang chính Dịch vụ, thêm mục "Tổng quan dịch vụ"
add_filter('dst_html', function ($html) {
    $url = dst_page_url('dst_services_page');
    if (!$url) {
        return $html;
    }
    $all = ['vi' => 'Tất cả dịch vụ', 'ko' => '전체 서비스', 'en' => 'All services'];
    $label = isset($all[dst_lang()]) ? $all[dst_lang()] : $all['en'];
    $html = preg_replace('#<a href="[^"]*/stays/"(\s+class="nav__parent")#', '<a href="' . esc_url($url) . '"$1', $html);
    $html = preg_replace_callback('#(<a href="[^"]*/stays/">[^<]*</a>)#u', function ($m) use ($url, $label) {
        return '<a href="' . esc_url($url) . '">' . esc_html($label) . '</a>' . $m[1];
    }, $html, 2);
    // Trang Vé máy bay: thêm quy định mới + tin mới dưới mục lưu ý
    if (strpos($html, '<section class="ds-flight-notes"') !== false && strpos($html, '<section class="ds-rules"') === false) {
        $extra = '<div class="ds-flight-extra">' . do_shortcode('[ds_quy_dinh]') . do_shortcode('[ds_tin_moi so="3"]') . '</div>';
        $html = preg_replace('#(<section class="ds-flight-notes"><div class="wrap">.*?)(</div></section>)#s', '$1' . str_replace(['\\', '$'], ['\\\\', '\$'], $extra) . '$2', $html, 1);
    }
    return $html;
}, 20);

add_action('rest_api_init', function () {
    register_rest_route('danangstay/v1', '/options2', [
        'methods' => 'POST',
        'permission_callback' => function () {
            return current_user_can('manage_options');
        },
        'callback' => function (WP_REST_Request $r) {
            foreach (['services_page'] as $k) {
                if ($r->get_param($k) !== null) {
                    update_option('dst_' . $k, (int) $r->get_param($k), false);
                }
            }
            foreach (['contact_avatar', 'contact_qr'] as $k) {
                if ($r->get_param($k) !== null) {
                    update_option('dst_' . $k, esc_url_raw((string) $r->get_param($k)), false);
                }
            }
            return ['ok' => true, 'services_page' => (int) get_option('dst_services_page', 0), 'contact_avatar' => get_option('dst_contact_avatar', ''), 'contact_qr' => get_option('dst_contact_qr', '')];
        },
    ]);
});

add_action('wp_head', function () {
    ?>
<style id="dst-hub-css">
.ds-services { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px; margin: 1.4em 0 2em; }
@media (max-width: 1000px) { .ds-services { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (max-width: 620px) { .ds-services { grid-template-columns: 1fr; } }
.ds-service { display: flex; flex-direction: column; gap: 8px; padding: 22px; border: 1px solid var(--line); border-radius: 14px; background: #fff; text-decoration: none !important; color: var(--ink) !important; box-shadow: 0 14px 34px -28px rgba(11,36,71,.6); transition: transform .2s, box-shadow .2s, border-color .2s; }
.ds-service:hover { transform: translateY(-3px); border-color: var(--bronze); box-shadow: 0 22px 44px -26px rgba(11,36,71,.55); }
.ds-service .ic { font-size: 30px; line-height: 1; }
.ds-service strong { font: 600 20px/1.25 var(--serif); }
.ds-service .tx { font: 400 14.5px/1.55 var(--sans); color: var(--ink-2); flex: 1; }
.ds-service .go { font: 700 13.5px/1 var(--sans); color: var(--bronze); }
.ds-split { display: grid; grid-template-columns: minmax(0, 1fr) 340px; gap: 40px; align-items: start; }
.ds-split__side { position: sticky; top: 104px; display: grid; gap: 18px; }
@media (max-width: 1000px) { .ds-split { grid-template-columns: 1fr; } .ds-split__side { position: static; } }
.ds-rules { border: 1px solid var(--line); border-radius: 14px; background: var(--ivory); padding: 18px 20px; font-family: var(--sans); text-align: left; }
.ds-rules h3 { margin: 0 0 4px !important; font: 600 18px/1.3 var(--sans) !important; color: var(--ink); }
.ds-rules__note { margin: 0 0 12px !important; font-size: 12.5px !important; color: var(--muted) !important; line-height: 1.45 !important; }
.ds-rules ul { list-style: none; margin: 0 !important; padding: 0 !important; display: grid; gap: 10px; }
.ds-rules li { margin: 0 !important; padding: 0 0 10px !important; border-bottom: 1px dashed var(--line); font-size: 14px; line-height: 1.5; color: var(--ink-2); }
.ds-rules li:last-child { border-bottom: 0; padding-bottom: 0 !important; }
.ds-rules li::before { display: none !important; }
.ds-rules li b { display: block; color: var(--ink); font-size: 14.5px; margin-bottom: 2px; }
.ds-news--side { margin: 0 !important; width: auto !important; left: auto !important; transform: none !important; }
.ds-news--side h2 { font: 600 18px/1.3 var(--sans) !important; margin: 0 0 10px !important; }
.ds-news--side .ds-news__grid { grid-template-columns: 1fr; gap: 10px; }
.ds-news--side .ds-news__item { padding: 12px 14px; }
.ds-news--side .ds-news__item strong { font-size: 15px; }
.ds-news--side .ds-news__ex { display: none; }
.ds-flight-extra { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: 18px; margin-top: 24px; align-items: start; }
.ds-flight-extra .ds-news { margin: 0; }
.ds-flight-extra .ds-news h2 { font-size: 22px; margin: 0 0 10px; }
.ds-flight-extra .ds-news__grid { grid-template-columns: 1fr; }
@media (max-width: 900px) { .ds-flight-extra { grid-template-columns: 1fr; } }
.ds-contact { position: relative; }
.ds-contact.has-qr { display: grid; grid-template-columns: minmax(0, 1fr) auto; column-gap: 20px; }
.ds-contact.has-qr > :not(.ds-contact__qr) { grid-column: 1; }
.ds-contact__qr { grid-column: 2; grid-row: 1 / span 3; margin: 0; text-align: center; align-self: center; }
.ds-contact__qr img { display: block; width: 132px; height: 132px; border-radius: 10px; background: #fff; padding: 6px; }
.ds-contact__qr figcaption { margin-top: 6px; font: 500 11.5px/1.3 var(--sans); color: #c9d6e6; max-width: 132px; }
.ds-contact__photo { width: 56px !important; height: 56px !important; border-radius: 50%; object-fit: cover; border: 2px solid rgba(255,255,255,.7); flex: none; margin: 0 !important; }
.ds-split__side .ds-contact.has-qr { grid-template-columns: 1fr; }
.ds-split__side .ds-contact__qr { grid-column: 1; grid-row: auto; justify-self: start; margin-top: 14px; display: flex; gap: 10px; align-items: center; text-align: left; }
.ds-split__side .ds-contact__qr img { width: 96px; height: 96px; }
@media (max-width: 700px) { .ds-contact.has-qr { grid-template-columns: 1fr; } .ds-contact__qr { display: none; } }
/* Căn trái, không dàn đều chữ trong khối dịch vụ */
.ds-split, .ds-split p, .ds-split li, .ds-steps li, .ds-rules li, .ds-rules span, .ds-service .tx, .ds-ticket p, .ds-ticket li { text-align: left !important; hyphens: manual; }
.ds-split__side > p:empty { display: none; }
.ds-split__side .ds-contact { margin: 0; }
.ds-ticket .tip strong { font: 700 14px/1.4 var(--sans) !important; letter-spacing: .02em; color: var(--ink) !important; text-transform: none; margin-bottom: 4px; }
.ds-steps li strong { display: block; font: 600 18px/1.3 var(--serif); color: var(--ink); margin-bottom: 4px; }
/* Trang Dịch vụ: nội dung rộng */
body.ds-hub .narrow.prose { width: min(1200px, calc(100% - 2 * var(--gutter))); }
body.ds-hub .prose > p:first-of-type::first-letter { float: none; font-size: inherit; padding: 0; color: inherit; font-family: inherit; }
.ds-steps { counter-reset: s; list-style: none; padding: 0 !important; display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 14px; }
.ds-steps li { counter-increment: s; background: #fff; border: 1px solid var(--line); border-radius: 12px; padding: 16px; font-size: 15px !important; line-height: 1.5 !important; margin: 0 !important; }
.ds-steps li::before { content: counter(s, decimal-leading-zero) !important; display: block !important; position: static !important; width: auto !important; height: auto !important; background: none !important; font: 700 22px/1 var(--serif); color: var(--bronze); margin-bottom: 8px; }
@media (max-width: 800px) { .ds-steps { grid-template-columns: 1fr 1fr; } }
</style>
    <?php
}, 103);

// Đánh dấu trang Dịch vụ để dùng bố cục rộng
add_filter('dst_html', function ($html) {
    if (strpos($html, 'class="ds-services"') !== false && strpos($html, 'class="ds-split"') !== false) {
        $html = str_replace('<body class="', '<body class="ds-hub ds-service ', $html);
    }
    return $html;
}, 5);
