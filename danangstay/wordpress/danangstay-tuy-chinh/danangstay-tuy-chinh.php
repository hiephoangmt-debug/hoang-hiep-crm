<?php
/**
 * Plugin Name: DanangStay – Tùy chỉnh (màu, menu, SEO)
 * Description: Tông màu theo hiephoangmt.com (navy + cam), sửa thanh menu bị ẩn trên máy tính, sửa SEO (og:locale, hreflang x-default), Việt hóa chữ còn sót trên bản tiếng Việt, ẩn tên đăng nhập quản trị.
 * Version: 1.4.0
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
