<?php
/**
 * Plugin Name: DanangStay – Tùy chỉnh (màu, menu, SEO)
 * Description: Tông màu theo hiephoangmt.com (navy + cam), sửa thanh menu bị ẩn trên máy tính, sửa SEO (og:locale, hreflang x-default), Việt hóa chữ còn sót trên bản tiếng Việt, ẩn tên đăng nhập quản trị.
 * * Version: 3.7.0
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
                // gộp với nhóm bản dịch đã có (không làm mất ngôn ngữ khác)
                $merged = [];
                foreach ($map as $pid) {
                    $merged = array_merge($merged, (array) pll_get_post_translations($pid));
                }
                pll_save_post_translations(array_merge($merged, $map));
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
    return '<div class="ds-contact' . ($qr ? ' has-qr' : '') . '" translate="no"><div class="ds-contact__in">'
        . '<div class="ds-contact__who">' . $av . '<div><strong>' . esc_html(dst_t('name')) . '</strong><br><span>' . esc_html(dst_t('role')) . '</span></div></div>'
        . '<div class="ds-contact__btns">'
        . '<a class="ds-btn ds-btn--call" href="tel:' . $phone . '">📞 ' . esc_html(dst_t('call')) . ' 0909 669 325</a>'
        . '<a class="ds-btn ds-btn--zalo" href="https://zalo.me/' . $phone . '" target="_blank" rel="noopener">Zalo</a>'
        . '<a class="ds-btn ds-btn--wa" href="https://wa.me/' . $intl . '" target="_blank" rel="noopener">WhatsApp</a>'
        . '<a class="ds-btn ds-btn--fb" href="' . DST_FB . '" target="_blank" rel="noopener">Facebook</a>'
        . '</div><p class="ds-contact__note">' . esc_html(dst_t('hours')) . '</p>' . $qrh . '</div></div>';
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
        $html = preg_replace_callback('#(<a href="[^"]*/flights/">[^<]*</a>)(\s*</li>)?#u', function ($m) use ($url) {
            $link = '<a href="' . esc_url($url) . '">' . esc_html(dst_t('tickets')) . '</a>';
            return !empty($m[2]) ? $m[1] . '</li><li>' . $link . $m[2] : $m[1] . $link;
        }, $html, 3);
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
    $is_hub = strpos($html, 'class="hub-main"') !== false || strpos($html, 'class="ds-services"') !== false;
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
    return str_replace('<body class="', '<body class="ds-svcpage ', $html);
});

add_action('wp_head', function () {
    ?>
<style id="dst-service-css">
/* Hero */
body.ds-svcpage .page-head.ds-hero { padding: 150px 0 56px; background: linear-gradient(135deg, #0b2447 0%, #133a6b 60%, #1e4f8a 100%); color: #fff; position: relative; overflow: hidden; }
body.ds-svcpage .page-head.ds-hero::after { content: ""; position: absolute; right: -120px; bottom: -160px; width: 520px; height: 520px; border-radius: 50%; background: radial-gradient(circle, rgba(255,138,61,.28), rgba(255,138,61,0) 70%); pointer-events: none; }
body.ds-svcpage .ds-hero h1 { color: #fff; font-size: clamp(32px, 4.2vw, 56px); font-weight: 500; line-height: 1.12; max-width: 920px; margin: 14px 0 16px; }
.ds-hero__kicker { display: inline-block; font: 700 12px/1 var(--sans); letter-spacing: .18em; text-transform: uppercase; color: #ffa04d; }
.ds-hero__sub { color: #d6e0ee !important; font-size: 18px !important; max-width: 720px !important; margin: 0 0 24px !important; line-height: 1.6; }
.ds-hero__actions { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 22px; }
.ds-hero__actions .ds-btn { padding: 14px 20px; font-size: 15px; }
.ds-hero__chips { display: flex; flex-wrap: wrap; gap: 8px; }
.ds-hero__chips a { padding: 8px 16px; border: 1px solid rgba(255,255,255,.35); border-radius: 999px; color: #fff; font: 600 13.5px/1 var(--sans); text-decoration: none; }
.ds-hero__chips a:hover { background: #fff; color: var(--sea); }
/* Bỏ chữ cái phóng to đầu bài trên trang dịch vụ */
body.ds-svcpage .prose > p:first-of-type::first-letter { float: none; font-size: inherit; padding: 0; color: inherit; font-family: inherit; }
body.ds-svcpage .prose > p:first-of-type { font-size: 19px; color: var(--ink); }
/* Lưới thẻ & tiêu đề khu vực trải rộng 3 cột */
body.ds-svcpage .prose .ds-tickets, body.ds-svcpage .prose h2.ds-area, body.ds-svcpage .prose .ds-news {
  width: min(1200px, calc(100vw - 2 * var(--gutter))); position: relative; left: 50%; transform: translateX(-50%); max-width: none;
}
body.ds-svcpage .prose .ds-tickets { grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 18px; }
@media (max-width: 1100px) { body.ds-svcpage .prose .ds-tickets { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (max-width: 700px) { body.ds-svcpage .prose .ds-tickets { grid-template-columns: 1fr; } }
body.ds-svcpage .prose h2.ds-area { display: flex; align-items: center; gap: 14px; margin-top: 2.2em; padding-top: 28px; border-top: 1px solid var(--line); scroll-margin-top: 100px; }
body.ds-svcpage .prose h2.ds-area::before { content: ""; width: 10px; height: 34px; border-radius: 4px; background: var(--bronze); }
body.ds-svcpage .prose h2#hoi-an::before { background: #c2410c; }
body.ds-svcpage .prose h2#hue::before { background: #7c3aed; }
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
body.ds-svcpage .prose table td:first-child { font-weight: 600; color: var(--ink); white-space: nowrap; }
@media (max-width: 700px) { body.ds-svcpage .prose table td:first-child { white-space: normal; } body.ds-svcpage .page-head.ds-hero { padding: 120px 0 40px; } }
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
    // Bài gắn thẻ "quy-dinh-moi" (do lịch tin tức tự đăng) hiện lên đầu danh sách
    $nq = new WP_Query(['post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 3, 'no_found_rows' => true, 'ignore_sticky_posts' => true,
        'lang' => dst_lang(), 'date_query' => [['after' => '120 days ago']],
        'tax_query' => [['taxonomy' => 'post_tag', 'field' => 'slug', 'terms' => ['quy-dinh-moi', 'quy-dinh-moi-vi', 'quy-dinh-moi-ko', 'quy-dinh-moi-en', 'new-rules', 'new-rules-ko']]]]);
    $newl = ['vi' => 'Mới', 'ko' => '새 소식'];
    while ($nq->have_posts()) {
        $nq->the_post();
        $out .= '<li class="is-new"><b><em>' . esc_html($newl[dst_lang()] ?? 'New') . '</em> <a href="' . esc_url(get_permalink()) . '">' . esc_html(get_the_title()) . '</a></b><span>' . esc_html(get_the_date('d/m/Y') . ' · ' . wp_trim_words(get_the_excerpt(), 20)) . '</span></li>';
    }
    wp_reset_postdata();
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
    $html = preg_replace('#<a href="[^"]*/stays/"(\s+class="nav__parent")#', '<a href="' . esc_url($url) . '"$1', $html);
    // Thanh liên hệ cố định cho điện thoại trên trang dịch vụ
    if (preg_match('#<body class="[^"]*\bds-svcpage#', $html) && strpos($html, '<nav class="ds-mbar"') === false) {
        $mb = ['vi' => ['Gọi', 'Zalo', 'Gửi yêu cầu'], 'ko' => ['전화', 'Zalo', '문의하기'], 'en' => ['Call', 'Zalo', 'Request']];
        $m = isset($mb[dst_lang()]) ? $mb[dst_lang()] : $mb['en'];
        $bar = '<nav class="ds-mbar" translate="no"><a href="tel:0909669325">📞 ' . $m[0] . '</a><a href="https://zalo.me/0909669325" target="_blank" rel="noopener">💬 ' . $m[1] . '</a><a href="' . esc_url(trailingslashit(dst_lang_home()) . '#reserve') . '">✉️ ' . $m[2] . '</a></nav>';
        $html = str_replace('</body>', $bar . '</body>', $html);
    }
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
.ds-contact { position: relative; container-type: inline-size; padding: 20px !important; }
.ds-contact__in { display: grid; grid-template-columns: minmax(0, 1fr); }
.ds-contact__who strong { white-space: nowrap; }
.ds-contact__btns { display: grid !important; grid-template-columns: 1fr 1fr; gap: 8px !important; }
.ds-contact__btns .ds-btn { justify-content: center; padding: 11px 10px; white-space: nowrap; }
.ds-contact__btns .ds-btn--call { grid-column: 1 / -1; }
.ds-contact__qr { margin: 16px 0 0; padding-top: 14px; border-top: 1px solid rgba(255,255,255,.15); display: flex; gap: 12px; align-items: center; }
.ds-contact__qr img { display: block; width: 84px; height: 84px; border-radius: 10px; background: #fff; padding: 5px; flex: none; }
.ds-contact__qr figcaption { font: 500 13px/1.4 var(--sans); color: #c9d6e6; }
.ds-contact__photo { width: 56px !important; height: 56px !important; border-radius: 50%; object-fit: cover; border: 2px solid rgba(255,255,255,.7); flex: none; margin: 0 !important; }
@container (min-width: 560px) {
  .ds-contact__in { grid-template-columns: minmax(0, 1fr) auto; column-gap: 28px; align-items: start; align-content: center; }
  .ds-contact__in > :not(.ds-contact__qr) { grid-column: 1; }
  .ds-contact__btns { grid-template-columns: auto auto auto; justify-content: start; }
  .ds-contact__btns .ds-btn--call { grid-column: auto; }
  .ds-contact__qr { grid-column: 2; grid-row: 1 / span 3; margin: 0; padding: 0; border: 0; flex-direction: column; align-self: center; text-align: center; }
  .ds-contact__qr img { width: 120px; height: 120px; }
  .ds-contact__qr figcaption { max-width: 130px; text-align: center !important; font-size: 12px; }
}
/* Trang dịch vụ: khoảng cách, nút nổi, hỏi đáp, thanh liên hệ điện thoại */
body.ds-svcpage main > .section:first-of-type, body.ds-svcpage .page-head + .section { padding-top: 56px; }
@media (min-width: 1001px) { body.ds-svcpage .float-cta { display: none !important; } }
body.ds-svcpage .prose details { border: 1px solid var(--line); border-radius: 12px; padding: 14px 18px; margin: 0 0 10px; background: #fff; }
body.ds-svcpage .prose details[open] { border-color: var(--bronze); box-shadow: 0 10px 26px -22px rgba(11,36,71,.6); }
body.ds-svcpage .prose summary { cursor: pointer; font: 600 16.5px/1.4 var(--sans); color: var(--ink); list-style: none; position: relative; padding-right: 28px; }
body.ds-svcpage .prose summary::-webkit-details-marker { display: none; }
body.ds-svcpage .prose summary::after { content: "+"; position: absolute; right: 0; top: -2px; font-size: 22px; color: var(--bronze); }
body.ds-svcpage .prose details[open] summary::after { content: "–"; }
body.ds-svcpage .prose details p { margin: 10px 0 0 !important; font-size: 15.5px !important; }
.ds-mbar { display: none; }
@media (max-width: 1000px) {
  .ds-mbar { display: grid; grid-template-columns: 1fr 1fr 1.3fr; position: fixed; left: 0; right: 0; bottom: 0; z-index: 70; box-shadow: 0 -8px 24px rgba(11,36,71,.22); }
  .ds-mbar a { display: flex; align-items: center; justify-content: center; gap: 6px; padding: 15px 6px calc(15px + env(safe-area-inset-bottom)); font: 700 15px/1 var(--sans); color: #fff !important; text-decoration: none; background: var(--bronze); }
  .ds-mbar a:nth-child(2) { background: #0068ff; } .ds-mbar a:nth-child(3) { background: var(--sea); }
  body.ds-svcpage .float-cta, body.ds-svcpage .callbar { display: none !important; }
  body.ds-svcpage { padding-bottom: 56px; }
  body.ds-svcpage .lang-hint { bottom: 72px; }
  .lang-hint { right: 76px !important; left: 12px !important; }
}
/* ===== Trang chính Dịch vụ (hub) ===== */
body.ds-hub .prose { font-size: 17px; }
body.ds-hub .prose > *:not(.hub-main):not(.hub-more):not(.hub-stats) { max-width: 1200px; }
.hub-stats { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 14px; margin: -96px 0 48px !important; position: relative; z-index: 3; }
.hub-stats > div { background: #fff; border: 1px solid var(--line); border-radius: 14px; padding: 16px 18px; box-shadow: 0 18px 40px -28px rgba(11,36,71,.6); text-align: left; }
.hub-stats b { display: block; font: 700 16px/1.3 var(--sans); color: var(--ink); }
.hub-stats span { display: block; font-size: 13.5px; line-height: 1.45; color: var(--muted); margin-top: 3px; }
body.ds-hub .page-head.ds-hero { padding-bottom: 130px; }
.prose h2.hub-h { font-size: clamp(28px, 3vw, 40px); margin: 1.6em 0 .35em; text-align: left; }
.prose .hub-lead { color: var(--muted); font-size: 17px !important; margin: 0 0 20px !important; text-align: left !important; }
.hub-main { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 18px; }
.hub-card { position: relative; display: flex; flex-direction: column; padding: 26px 24px 24px; border-radius: 18px; color: #fff !important; text-decoration: none !important; overflow: hidden; min-height: 340px; box-shadow: 0 24px 48px -30px rgba(11,36,71,.8); transition: transform .25s, box-shadow .25s; text-align: left; }
.hub-card:hover { transform: translateY(-4px); box-shadow: 0 30px 60px -30px rgba(11,36,71,.85); }
.hub-card--stay { background: linear-gradient(150deg, #0b2447, #1e4f8a); }
.hub-card--fly { background: linear-gradient(150deg, #0e3a5f, #0a7aa8); }
.hub-card--ticket { background: linear-gradient(150deg, #c2410c, #ea580c 55%, #ff8a3d); }
.hub-card::after { content: ""; position: absolute; right: -60px; top: -60px; width: 200px; height: 200px; border-radius: 50%; background: rgba(255,255,255,.08); }
.hub-card .ic { font-size: 40px; line-height: 1; margin-bottom: 14px; }
.hub-card strong { font: 600 28px/1.15 var(--serif); }
.hub-card em { font-style: normal; font-size: 14.5px; opacity: .85; margin: 4px 0 14px; }
.hub-card ul { list-style: none; margin: 0 0 18px !important; padding: 0 !important; display: grid; gap: 8px; flex: 1; }
.hub-card li { margin: 0 !important; padding: 0 0 0 24px !important; position: relative; font-size: 15px !important; line-height: 1.45 !important; color: #fff !important; text-align: left !important; }
.hub-card li::before { content: "✓" !important; position: absolute !important; left: 0; top: 0; width: auto !important; height: auto !important; background: none !important; color: #ffd08a; font-weight: 700; }
.hub-card .btn { align-self: flex-start; background: #fff; color: var(--ink); border-radius: 999px; padding: 11px 18px; font: 700 14px/1 var(--sans); }
.hub-card--ticket .btn { color: #c2410c; }
.hub-more { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 14px; margin-top: 14px; }
.hub-more a { display: flex; gap: 14px; align-items: center; padding: 16px 18px; border: 1px solid var(--line); border-radius: 14px; background: #fff; color: var(--ink) !important; text-decoration: none !important; transition: border-color .2s, transform .2s; text-align: left; }
.hub-more a:hover { border-color: var(--bronze); transform: translateY(-2px); }
.hub-more .ic { font-size: 28px; }
.hub-more strong { display: block; font: 600 16px/1.3 var(--sans); }
.hub-more span:not(.ic) { display: block; font-size: 13.5px; color: var(--muted); line-height: 1.45; margin-top: 2px; }
body.ds-hub .ds-steps { counter-reset: s; }
body.ds-hub .ds-steps li { position: relative; padding-top: 18px; }
body.ds-hub .ds-steps li strong { display: block; font: 600 18px/1.3 var(--serif); margin-bottom: 6px; }
.hub-cta { display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 18px; margin: 40px 0 10px; padding: 26px 28px; border-radius: 18px; background: linear-gradient(120deg, #fff1e8, #ffe3cf); border: 1px solid #ffd3b3; text-align: left; }
.hub-cta strong { display: block; font: 600 22px/1.3 var(--serif); color: var(--ink); }
.hub-cta span { display: block; font-size: 15px; color: var(--ink-2); margin-top: 4px; max-width: 640px; }
.hub-cta__btns { display: flex; flex-wrap: wrap; gap: 10px; }
.hub-why { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 14px; }
.hub-why > div { background: var(--ivory); border-radius: 14px; padding: 20px 18px; text-align: left; }
.hub-why span { font-size: 28px; display: block; margin-bottom: 8px; }
.hub-why strong { display: block; font: 600 17px/1.3 var(--sans); color: var(--ink); margin-bottom: 4px; }
.hub-why p { margin: 0 !important; font-size: 14.5px !important; line-height: 1.5 !important; text-align: left !important; }
.hub-areas { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 12px; }
.hub-areas > div { border: 1px solid var(--line); border-left: 4px solid var(--bronze); border-radius: 10px; padding: 14px 16px; background: #fff; text-align: left; }
.hub-areas strong { display: block; font: 600 16px/1.3 var(--sans); color: var(--ink); }
.hub-areas span { display: block; font-size: 14px; color: var(--muted); margin-top: 2px; line-height: 1.45; }
.hub-info { display: grid; grid-template-columns: minmax(0, 1.2fr) minmax(0, 1fr); gap: 20px; margin: 48px 0 0; align-items: start; }
.hub-info > p:empty { display: none; }
@media (max-width: 1000px) {
  .hub-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); margin-top: -70px !important; }
  .hub-main, .hub-more, .hub-areas { grid-template-columns: 1fr 1fr; }
  .hub-why { grid-template-columns: 1fr 1fr; }
  .hub-info { grid-template-columns: 1fr; }
  .hub-card { min-height: 0; }
}
@media (max-width: 640px) {
  .hub-main, .hub-more, .hub-areas { grid-template-columns: 1fr; }
  .hub-stats { gap: 10px; }
  .hub-stats > div { padding: 12px 14px; }
  .hub-stats b { font-size: 14.5px; } .hub-stats span { font-size: 12.5px; }
  .hub-card { padding: 22px 20px; }
  .hub-card strong { font-size: 24px; }
  .hub-cta { padding: 20px; }
}
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
    if (strpos($html, 'class="hub-main"') !== false || (strpos($html, 'class="ds-services"') !== false && strpos($html, 'class="ds-split"') !== false)) {
        $html = str_replace('<body class="', '<body class="ds-hub ds-svcpage ', $html);
    }
    return $html;
}, 5);

/* ------------------------------------------------------------------ */
/* 11b. Menu xổ xuống DỊCH VỤ: biểu tượng + mô tả, bỏ mục thừa          */
/* ------------------------------------------------------------------ */
add_filter('dst_html', function ($html) {
    $M = [
        'vi' => [['🏨', 'Chỗ ở', 'Khách sạn, căn hộ, villa view biển'], ['✈️', 'Vé máy bay', 'Nội địa & quốc tế đến Đà Nẵng'], ['🎟️', 'Vé tham quan', 'Bà Nà, Núi Thần Tài, Hội An, Huế…']],
        'ko' => [['🏨', '숙소', '오션뷰 호텔·아파트·풀빌라'], ['✈️', '항공권', '다낭행 국내선·국제선'], ['🎟️', '입장권·투어', '바나힐, 탄따이 온천, 호이안, 후에…']],
        'en' => [['🏨', 'Stays', 'Sea-view hotels, apartments, villas'], ['✈️', 'Flights', 'Domestic & international to Da Nang'], ['🎟️', 'Tickets & tours', 'Ba Na Hills, hot springs, Hoi An, Hue…']],
    ];
    $m = isset($M[dst_lang()]) ? $M[dst_lang()] : $M['en'];
    return preg_replace_callback('#<div class="nav__sub">(\s*<a href="([^"]*)/stays/">.*?)</div>#su', function ($x) use ($m) {
        $base = $x[2];
        preg_match('#<a href="([^"]*/flights/)"#', $x[1], $f);
        $tk = dst_tickets_url();
        $items = [[$base . '/stays/', $m[0]], [isset($f[1]) ? $f[1] : $base . '/flights/', $m[1]]];
        if ($tk) {
            $items[] = [$tk, $m[2]];
        }
        $out = '<div class="nav__sub ds-mega">';
        foreach ($items as $it) {
            $out .= '<a href="' . esc_url($it[0]) . '"><span class="mi" aria-hidden="true">' . $it[1][0] . '</span><span class="mt"><b>' . esc_html($it[1][1]) . '</b><small>' . esc_html($it[1][2]) . '</small></span></a>';
        }
        return $out . '</div>';
    }, $html, 1);
}, 30);

add_action('wp_head', function () {
    ?>
<style id="dst-mega-css">
.nav__sub.ds-mega { min-width: 330px; padding: 8px !important; border-radius: 14px; }
.nav__sub.ds-mega a { display: flex !important; align-items: center; gap: 12px; padding: 10px 12px !important; border-radius: 10px; white-space: normal !important; }
.nav__sub.ds-mega a:hover { background: var(--ivory); }
.nav__sub.ds-mega .mi { width: 40px; height: 40px; flex: none; border-radius: 10px; background: #fff1e8; display: grid; place-items: center; font-size: 20px; }
.nav__sub.ds-mega a:nth-child(2) .mi { background: #e6f1fb; }
.nav__sub.ds-mega a:nth-child(3) .mi { background: #fdeee4; }
.nav__sub.ds-mega .mt { display: flex; flex-direction: column; gap: 2px; }
.nav__sub.ds-mega b { font: 600 15px/1.25 var(--sans); color: var(--ink); letter-spacing: 0; text-transform: none; }
.nav__sub.ds-mega small { font: 400 12.5px/1.35 var(--sans); color: var(--muted); letter-spacing: 0; text-transform: none; }
.nav__sub.ds-mega a:hover b { color: var(--bronze); }
body.menu-open .nav__sub.ds-mega { min-width: 0; padding: 0 0 8px 0 !important; }
body.menu-open .nav__sub.ds-mega a { padding: 8px 0 !important; }
body.menu-open .nav__sub.ds-mega .mi { width: 34px; height: 34px; font-size: 17px; }
body.menu-open .nav__sub.ds-mega b { font-size: 16px !important; color: var(--ink) !important; }
</style>
    <?php
}, 105);

/* ------------------------------------------------------------------ */
/* 12. Không tự chèn <p> trên trang dịch vụ (giữ nguyên bố cục thẻ)     */
/* ------------------------------------------------------------------ */
add_filter('the_content', function ($c) {
    if (strpos($c, 'class="hub-main"') !== false || strpos($c, 'class="ds-tickets') !== false || strpos($c, 'class="ds-split"') !== false) {
        remove_filter('the_content', 'wpautop');
        remove_filter('the_content', 'shortcode_unautop');
    }
    return $c;
}, 1);

/* ------------------------------------------------------------------ */
/* 13. Nút Zalo + khung chat cạnh phải (toàn site)                      */
/* ------------------------------------------------------------------ */
add_action('wp_footer', function () {
    $l = dst_lang();
    $T = [
        'vi' => ['Vân Trần', 'Tư vấn DanangStay · thường trả lời trong vài phút', 'Xin chào 👋 Bạn cần tìm phòng, vé máy bay hay vé tham quan ở Đà Nẵng? Nhắn Zalo hoặc để lại số điện thoại, mình gọi lại ngay nhé!', 'Chat Zalo', 'WhatsApp', 'Gọi', 'Hoặc để lại thông tin', 'Tên của bạn', 'Số điện thoại / Zalo', 'Bạn cần gì?', ['Đặt phòng', 'Vé máy bay', 'Vé tham quan', 'Xe đưa đón', 'Tour', 'Trọn gói'], 'Ngày đi, số người… (không bắt buộc)', 'Gửi', 'Cảm ơn bạn! Vân Trần sẽ liên hệ sớm.', 'Chưa gửi được, bạn nhắn Zalo giúp mình nhé.', 'Chat với chúng tôi', 'Đóng'],
        'ko' => ['Vân Trần', 'DanangStay 상담 · 보통 몇 분 안에 답변', '안녕하세요 👋 다낭 숙소, 항공권, 입장권이 필요하신가요? 카카오톡·Zalo로 메시지 주시거나 연락처를 남겨 주세요!', 'Zalo 채팅', 'WhatsApp', '전화', '또는 연락처 남기기', '이름', '전화번호 / 카카오톡 ID', '필요한 서비스', ['숙소', '항공권', '입장권', '픽업', '투어', '패키지'], '날짜, 인원… (선택)', '보내기', '감사합니다! 곧 연락드리겠습니다.', '전송에 실패했습니다. Zalo로 메시지 주세요.', '채팅 상담', '닫기'],
        'en' => ['Vân Trần', 'DanangStay concierge · usually replies in minutes', 'Hi 👋 Looking for a room, flights or attraction tickets in Da Nang? Message us on WhatsApp or Zalo, or leave your number and we will get back to you!', 'Chat on Zalo', 'WhatsApp', 'Call', 'Or leave your details', 'Your name', 'Phone / WhatsApp', 'What do you need?', ['Room', 'Flights', 'Tickets', 'Transfer', 'Tour', 'Package'], 'Dates, guests… (optional)', 'Send', 'Thank you! We will contact you shortly.', 'Could not send — please message us on WhatsApp or Zalo.', 'Chat with us', 'Close'],
    ];
    $t = isset($T[$l]) ? $T[$l] : $T['en'];
    $avatar = (string) get_option('dst_contact_avatar', '');
    $av = $avatar ? '<img src="' . esc_url($avatar) . '" alt="" width="44" height="44">' : '<span>VT</span>';
    $opts = '';
    foreach ($t[10] as $o) {
        $opts .= '<option>' . esc_html($o) . '</option>';
    }
    $endpoint = esc_url(rest_url('danangstay/v1/lead'));
    ?>
<div class="dsw" translate="no" data-endpoint="<?php echo $endpoint; ?>" data-lang="<?php echo esc_attr($l); ?>" data-ok="<?php echo esc_attr($t[13]); ?>" data-err="<?php echo esc_attr($t[14]); ?>">
  <div class="dsw__panel" role="dialog" aria-label="<?php echo esc_attr($t[15]); ?>" hidden>
    <div class="dsw__head"><div class="dsw__av"><?php echo $av; // phpcs:ignore ?></div><div><strong><?php echo esc_html($t[0]); ?></strong><span><?php echo esc_html($t[1]); ?></span></div><button type="button" class="dsw__x" aria-label="<?php echo esc_attr($t[16]); ?>">×</button></div>
    <div class="dsw__body">
      <p class="dsw__msg"><?php echo esc_html($t[2]); ?></p>
      <div class="dsw__btns"><a href="https://zalo.me/0909669325" target="_blank" rel="noopener" class="z">💬 <?php echo esc_html($t[3]); ?></a><a href="https://wa.me/84909669325" target="_blank" rel="noopener" class="w">🟢 <?php echo esc_html($t[4]); ?></a><a href="tel:0909669325" class="c">📞 <?php echo esc_html($t[5]); ?></a></div>
      <form class="dsw__form" novalidate>
        <p class="dsw__or"><?php echo esc_html($t[6]); ?></p>
        <input name="name" placeholder="<?php echo esc_attr($t[7]); ?>" autocomplete="name" required>
        <input name="phone" type="tel" placeholder="<?php echo esc_attr($t[8]); ?>" autocomplete="tel" inputmode="tel" required>
        <select name="need" aria-label="<?php echo esc_attr($t[9]); ?>"><?php echo $opts; // phpcs:ignore ?></select>
        <textarea name="msg" rows="2" placeholder="<?php echo esc_attr($t[11]); ?>"></textarea>
        <input name="website" class="dsw__hp" tabindex="-1" autocomplete="off">
        <button type="submit"><?php echo esc_html($t[12]); ?></button>
        <p class="dsw__status" aria-live="polite"></p>
      </form>
    </div>
  </div>
  <a class="dsw__zalo" href="https://zalo.me/0909669325" target="_blank" rel="noopener" aria-label="Zalo">Zalo</a>
  <button type="button" class="dsw__open" aria-label="<?php echo esc_attr($t[15]); ?>"><span class="dsw__dot"></span>💬</button>
</div>
<script id="dst-chat">
(function () {
  var w = document.querySelector('.dsw'); if (!w) return;
  var p = w.querySelector('.dsw__panel'), f = w.querySelector('.dsw__form'), st = w.querySelector('.dsw__status');
  function toggle(open) { p.hidden = !open; w.classList.toggle('is-open', open); try { sessionStorage.setItem('dswSeen', '1'); } catch (e) {} }
  w.querySelector('.dsw__open').addEventListener('click', function () { toggle(p.hidden); });
  w.querySelector('.dsw__x').addEventListener('click', function () { toggle(false); });
  try { if (!sessionStorage.getItem('dswSeen')) w.classList.add('is-new'); } catch (e) {}
  f.addEventListener('submit', function (e) {
    e.preventDefault();
    if (f.website.value) return;
    var name = f.name.value.trim(), phone = f.phone.value.trim();
    if (!name || phone.replace(/\D/g, '').length < 6) { f.reportValidity && f.reportValidity(); return; }
    var btn = f.querySelector('button'); btn.disabled = true;
    fetch(w.dataset.endpoint, { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({
      name: name, phone: phone, via: 'Chat web', msg: (f.need.value + (f.msg.value.trim() ? ' – ' + f.msg.value.trim() : '')),
      lang: w.dataset.lang, source: 'Khung chat web: ' + f.need.value, page: location.href.split('?')[0] }) })
    .then(function (r) { if (!r.ok) throw 0; st.textContent = w.dataset.ok; f.reset(); if (window.gtag) gtag('event', 'generate_lead', { method: 'chat' }); if (window.fbq) fbq('track', 'Lead'); })
    .catch(function () { st.textContent = w.dataset.err; })
    .then(function () { btn.disabled = false; });
  });
})();
</script>
    <?php
}, 120);

add_action('wp_head', function () {
    ?>
<style id="dst-chat-css">
.dsw { position: fixed; right: 18px; bottom: 96px; z-index: 80; display: flex; flex-direction: column; align-items: flex-end; gap: 10px; font-family: var(--sans); }
.dsw__zalo, .dsw__open { width: 56px; height: 56px; border-radius: 50%; display: grid; place-items: center; border: 0; cursor: pointer; box-shadow: 0 10px 24px -8px rgba(11,36,71,.55); text-decoration: none; }
.dsw__zalo { background: #0068ff; color: #fff !important; font: 800 13px/1 var(--sans); }
.dsw__open { background: var(--bronze); color: #fff; font-size: 24px; position: relative; }
.dsw.is-open .dsw__open { background: var(--sea); }
.dsw__dot { position: absolute; top: 4px; right: 4px; width: 12px; height: 12px; border-radius: 50%; background: #22c55e; border: 2px solid #fff; display: none; }
.dsw.is-new .dsw__dot { display: block; animation: dswPulse 1.8s infinite; }
@keyframes dswPulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.25); } }
.dsw__zalo:hover, .dsw__open:hover { transform: translateY(-2px); }
.dsw__panel { width: min(360px, calc(100vw - 32px)); background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 30px 60px -20px rgba(11,36,71,.55); border: 1px solid var(--line); }
.dsw__panel[hidden] { display: none; }
.dsw__head { display: flex; align-items: center; gap: 12px; padding: 14px 16px; background: linear-gradient(135deg, #0b2447, #1e4f8a); color: #fff; }
.dsw__head strong { display: block; font-size: 16px; }
.dsw__head span { display: block; font-size: 12px; color: #c9d6e6; }
.dsw__av { width: 44px; height: 44px; border-radius: 50%; overflow: hidden; flex: none; background: var(--bronze); display: grid; place-items: center; font-weight: 700; }
.dsw__av img { width: 100%; height: 100%; object-fit: cover; }
.dsw__x { margin-left: auto; background: none; border: 0; color: #fff; font-size: 26px; line-height: 1; cursor: pointer; opacity: .8; }
.dsw__body { padding: 14px 16px 16px; max-height: min(70vh, 520px); overflow-y: auto; }
.dsw__msg { background: var(--ivory); border-radius: 4px 14px 14px 14px; padding: 10px 12px; margin: 0 0 12px; font-size: 14.5px; line-height: 1.5; color: var(--ink-2); }
.dsw__btns { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px; margin-bottom: 12px; }
.dsw__btns a { display: flex; align-items: center; justify-content: center; padding: 10px 6px; border-radius: 10px; color: #fff !important; font: 700 13px/1.2 var(--sans); text-decoration: none; text-align: center; }
.dsw__btns .z { background: #0068ff; } .dsw__btns .w { background: #25d366; } .dsw__btns .c { background: var(--bronze); }
.dsw__or { margin: 0 0 8px; font-size: 12.5px; color: var(--muted); text-transform: uppercase; letter-spacing: .08em; font-weight: 600; }
.dsw__form { display: grid; gap: 8px; }
.dsw__form input, .dsw__form select, .dsw__form textarea { width: 100%; border: 1px solid var(--line); border-radius: 10px; padding: 10px 12px; font: 400 14.5px/1.4 var(--sans); color: var(--ink); background: #fff; box-sizing: border-box; }
.dsw__form input:focus, .dsw__form select:focus, .dsw__form textarea:focus { outline: 2px solid #ffb27a; border-color: var(--bronze); }
.dsw__form button { border: 0; border-radius: 10px; padding: 12px; background: var(--sea); color: #fff; font: 700 15px/1 var(--sans); cursor: pointer; }
.dsw__form button:disabled { opacity: .6; }
.dsw__hp { position: absolute; left: -9999px; }
.dsw__status { margin: 2px 0 0; font-size: 13.5px; color: #16803c; }
@media (max-width: 1000px) {
  .dsw { right: 12px; bottom: 84px; }
  body.ds-svcpage .dsw { bottom: 72px; }
  body.ds-svcpage .dsw__zalo { display: none; }
  .dsw__zalo, .dsw__open { width: 50px; height: 50px; }
}
body.menu-open .dsw { display: none; }
/* Thẻ dịch vụ lớn: chữ trắng */
.hub-card strong, .hub-card em, .hub-card li { color: #fff !important; }
@media (max-width: 640px) { body.ds-hub .page-head.ds-hero { padding-bottom: 96px; } }
</style>
    <?php
}, 104);

/* ------------------------------------------------------------------ */
/* 14. Trang Chỗ ở: hero 2 cột + khu vực, lịch mùa, kinh nghiệm, hỏi đáp */
/* ------------------------------------------------------------------ */
function dst_stays_text()
{
    $T = [
        'vi' => [
            'kicker' => 'Dịch vụ · Chỗ ở', 'cta1' => 'Nhận báo giá phòng', 'cta2' => 'Nhắn Zalo',
            'why' => 'Vì sao đặt phòng qua DanangStay?', 'whys' => ['Người địa phương đã tận mắt xem phòng', 'Gợi ý đúng khu theo lịch trình của bạn', 'Báo giá cuối, điều kiện hủy rõ ràng', 'Hỗ trợ đổi phòng, gia hạn trong chuyến đi'],
            'reply' => 'Thường trả lời trong vài phút',
            'areas_t' => 'Nên ở khu nào?', 'areas_p' => 'Mỗi khu một không khí — chọn theo việc bạn định làm nhiều nhất.',
            'lbl' => ['Phù hợp', 'Điểm cộng', 'Lưu ý'],
            'areas' => [
                ['Mỹ Khê – An Thượng', 'Lần đầu đến, cặp đôi, nhóm bạn', 'Sát biển đẹp nhất thành phố, nhiều quán ăn, cà phê, phố đi bộ An Thượng', 'Mùa hè và cuối tuần đông, giá cao hơn vào cao điểm'],
                ['Mân Thái – Sơn Trà', 'Gia đình, người thích yên tĩnh', 'Biển êm, làng chài, hải sản tươi, gần bán đảo Sơn Trà và chùa Linh Ứng', 'Ít quán bar, xa Hội An hơn các khu phía nam'],
                ['Trung tâm – sông Hàn', 'Công tác, đi sân bay, xem pháo hoa', 'Cách sân bay ~10 phút, gần cầu Rồng, chợ Hàn, nhiều lựa chọn giá', 'Không sát biển; dịp pháo hoa, năm mới phòng view sông kín sớm'],
                ['Ngũ Hành Sơn – Non Nước', 'Nghỉ dưỡng resort, tuần trăng mật', 'Resort ven biển rộng, yên tĩnh, đi Hội An chỉ ~25 phút', 'Xa trung tâm, cần xe khi đi ăn chơi tối'],
                ['Hội An', 'Yêu phố cổ, làng quê, ẩm thực', 'Buổi tối đèn lồng, homestay, villa giữa ruộng, biển An Bàng', 'Mùa mưa lớn có thể ngập vài tuyến phố sát sông Hoài'],
                ['Bà Nà – Hòa Vang', 'Muốn ngắm Cầu Vàng lúc vắng', 'Ngủ trên núi hoặc gần ga cáp treo để lên sớm, gần suối khoáng Núi Thần Tài', 'Xa biển và trung tâm, trên núi lạnh hơn'],
            ],
            'season_t' => 'Lịch mùa trong năm', 'season_p' => 'Tham khảo để chọn ngày được giá tốt — giá thực tế còn tùy từng khách sạn.',
            'lv' => ['Cao điểm', 'Trung bình', 'Thấp điểm'],
            'months' => ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
            'notes' => ['Tết Nguyên đán', 'Tết, lễ hội', 'Xuân mát', 'Lễ 30/4', 'Hè bắt đầu', 'Pháo hoa DIFF', 'Hè cao điểm', 'Hè cao điểm', 'Cuối hè', 'Mùa mưa', 'Mùa mưa', 'Giáng sinh – năm mới'],
            'tips_t' => 'Kinh nghiệm đặt phòng ở Đà Nẵng',
            'tips' => [
                ['📅', 'Đặt sớm dịp cao điểm', 'Tết, 30/4, hè và đêm 31/12 nên đặt trước 1–2 tháng; phòng view biển, view sông hết sớm nhất.'],
                ['🌅', 'Chọn hướng phòng', 'Phòng hướng biển phía đông đón bình minh; phòng view sông Hàn đẹp về đêm và dịp pháo hoa.'],
                ['🏢', 'Tầng cao, view thoáng', 'Hỏi rõ tầng và hướng nhìn — “view biển” có thể chỉ nhìn được một góc.'],
                ['🧒', 'Đi cùng trẻ nhỏ', 'Ưu tiên khách sạn có hồ bơi, gần bãi tắm có cứu hộ, phòng gia đình hoặc căn hộ có bếp.'],
                ['🧳', 'Ở dài ngày', 'Từ 7 đêm nên cân nhắc căn hộ: có bếp, máy giặt, thường có giá tốt hơn theo tuần, tháng.'],
                ['💳', 'Đặt cọc & hủy phòng', 'Đọc kỹ điều kiện cọc, hủy, hoàn trước khi chuyển khoản; dịp lễ thường không hoàn.'],
                ['🚕', 'Đưa đón sân bay', 'Sân bay chỉ cách trung tâm ~3 km; đặt xe đón trước nếu đến đêm khuya hoặc đi đoàn đông.'],
                ['🌧️', 'Mùa mưa', 'Tháng 10–12 giá mềm hơn; chọn khu gần trung tâm, có hồ bơi trong nhà hoặc spa cho ngày mưa.'],
            ],
            'faq_t' => 'Hỏi đáp về đặt phòng',
            'faq' => [
                ['Giá trên trang là giá cuối chưa?', 'Đó là mức tham khảo theo loại chỗ ở. Gửi ngày đi và số người, chúng tôi báo giá cuối của từng khách sạn trong vài giờ.'],
                ['Đặt qua DanangStay có đắt hơn ứng dụng không?', 'Thường bằng hoặc tốt hơn vì làm việc trực tiếp với khách sạn; nếu thấy giá rẻ hơn ở nơi khác, gửi để chúng tôi kiểm tra.'],
                ['Có nhận đặt cho đoàn đông người không?', 'Có — đoàn từ 10 phòng, team building, hội nghị đều có giá đoàn kèm xe đưa đón.'],
                ['Thanh toán thế nào?', 'Chuyển khoản ngân hàng Việt Nam hoặc thanh toán tại khách sạn tùy nơi; luôn có xác nhận đặt phòng trước ngày đến.'],
            ],
        ],
        'ko' => [
            'kicker' => '서비스 · 숙소', 'cta1' => '숙소 견적 받기', 'cta2' => 'Zalo 문의',
            'why' => 'DanangStay에서 예약하는 이유', 'whys' => ['현지인이 직접 확인한 숙소', '일정에 맞는 지역 추천', '최종 가격·취소 조건 명확', '여행 중 객실 변경·연장 지원'],
            'reply' => '보통 몇 분 안에 답변',
            'areas_t' => '어느 지역에 묵을까?', 'areas_p' => '지역마다 분위기가 다릅니다. 가장 많이 할 일에 맞춰 고르세요.',
            'lbl' => ['추천 대상', '장점', '참고'],
            'areas' => [
                ['미케 – 안트엉', '첫 방문, 커플, 친구', '시내에서 가장 아름다운 해변, 식당·카페·안트엉 거리', '여름·주말 붐빔, 성수기 가격 상승'],
                ['만타이 – 선짜', '가족, 조용한 여행', '잔잔한 바다, 어촌, 신선한 해산물, 선짜 반도·린응사 근처', '바가 적고 호이안과 거리가 있음'],
                ['시내 – 한강', '출장, 공항 이동, 불꽃 관람', '공항까지 약 10분, 용다리·한시장 근처, 다양한 가격대', '해변과 떨어짐, 불꽃축제·연말 리버뷰 조기 마감'],
                ['응우하인선 – 논느억', '리조트 휴양, 신혼여행', '넓은 해변 리조트, 조용함, 호이안까지 약 25분', '시내와 멀어 저녁 외출 시 차량 필요'],
                ['호이안', '구시가지·시골·음식 애호가', '저녁 등불, 홈스테이, 논밭 풀빌라, 안방 해변', '우기 폭우 시 강변 거리 침수 가능'],
                ['바나힐 – 호아방', '한적한 골든브릿지를 원하면', '산 위 또는 케이블카역 근처 숙박으로 이른 입장, 탄따이 온천 근처', '바다·시내와 멀고 산 위는 쌀쌀함'],
            ],
            'season_t' => '연중 시즌 달력', 'season_p' => '좋은 가격의 날짜를 고르는 참고용입니다. 실제 요금은 호텔마다 다릅니다.',
            'lv' => ['성수기', '보통', '비수기'],
            'months' => ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            'notes' => ['설 연휴', '설·축제', '선선한 봄', '4/30 연휴', '여름 시작', '불꽃축제', '여름 성수기', '여름 성수기', '늦여름', '우기', '우기', '크리스마스·연말'],
            'tips_t' => '다낭 숙소 예약 팁',
            'tips' => [
                ['📅', '성수기는 일찍', '설, 4/30, 여름, 12/31은 1–2개월 전 예약 추천. 오션뷰·리버뷰가 가장 먼저 마감됩니다.'],
                ['🌅', '방향 선택', '동쪽 바다 방향은 일출, 한강 뷰는 야경과 불꽃이 아름답습니다.'],
                ['🏢', '고층·시야', '층수와 방향을 꼭 확인하세요. ‘오션뷰’가 일부만 보일 수도 있습니다.'],
                ['🧒', '아이와 함께', '수영장, 안전요원 있는 해변 근처, 패밀리룸이나 주방 있는 아파트 추천.'],
                ['🧳', '장기 숙박', '7박 이상이면 주방·세탁기 있는 아파트가 주·월 단위로 더 저렴한 경우가 많습니다.'],
                ['💳', '예약금·취소', '송금 전 예약금·취소·환불 조건 확인. 연휴에는 환불 불가가 많습니다.'],
                ['🚕', '공항 픽업', '공항은 시내에서 약 3km. 심야 도착이나 단체라면 픽업을 미리 예약하세요.'],
                ['🌧️', '우기', '10–12월은 가격이 부드럽습니다. 실내 수영장·스파가 있는 시내 근처 숙소 추천.'],
            ],
            'faq_t' => '숙소 예약 Q&A',
            'faq' => [
                ['페이지 가격이 최종 가격인가요?', '숙소 유형별 참고 가격입니다. 날짜와 인원을 보내 주시면 몇 시간 안에 호텔별 최종 견적을 드립니다.'],
                ['앱보다 비싸지 않나요?', '호텔과 직접 거래해 보통 같거나 더 저렴합니다. 더 싼 곳이 있으면 보내 주세요.'],
                ['단체 예약도 되나요?', '네 — 10객실 이상 단체, 팀빌딩, 행사 모두 차량 포함 단체 요금이 있습니다.'],
                ['결제는 어떻게 하나요?', '베트남 계좌이체 또는 숙소에 따라 현장 결제. 도착 전 예약 확인서를 드립니다.'],
            ],
        ],
        'en' => [
            'kicker' => 'Services · Stays', 'cta1' => 'Get a room quote', 'cta2' => 'Chat on Zalo',
            'why' => 'Why book stays with DanangStay?', 'whys' => ['Rooms seen in person by locals', 'The right area for your plans', 'Final prices and clear cancellation terms', 'Help with changes and extensions during your trip'],
            'reply' => 'Usually replies in minutes',
            'areas_t' => 'Where should you stay?', 'areas_p' => 'Each area has its own feel — choose by what you will do most.',
            'lbl' => ['Good for', 'Pluses', 'Keep in mind'],
            'areas' => [
                ['My Khe – An Thuong', 'First visits, couples, friends', "The city's best beach, plenty of restaurants, cafés and the An Thuong walking streets", 'Busy in summer and at weekends; higher prices in peak season'],
                ['Man Thai – Son Tra', 'Families, quiet stays', 'Calm sea, a fishing village, fresh seafood, close to Son Tra and Linh Ung pagoda', 'Few bars; further from Hoi An than the southern areas'],
                ['Centre – Han River', 'Business, airport runs, fireworks', '~10 min to the airport, near the Dragon Bridge and Han Market, every budget', 'Not on the beach; river-view rooms sell out early for fireworks and New Year'],
                ['Ngu Hanh Son – Non Nuoc', 'Resort holidays, honeymoons', 'Spacious, quiet beach resorts, ~25 min to Hoi An', 'Far from the centre; you need a car for evenings out'],
                ['Hoi An', 'Old-town, village and food lovers', 'Lantern-lit evenings, homestays, villas among rice fields, An Bang beach', 'Heavy rain can flood some streets by the Hoai River'],
                ['Ba Na – Hoa Vang', 'An empty Golden Bridge at dawn', 'Stay on the mountain or near the cable car for an early start, close to Than Tai hot springs', 'Far from the beach and city; cooler up the mountain'],
            ],
            'season_t' => 'Seasons through the year', 'season_p' => 'A guide to finding good-value dates — actual prices vary by hotel.',
            'lv' => ['Peak', 'Shoulder', 'Low'],
            'months' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'notes' => ['Lunar New Year', 'Tet, festivals', 'Mild spring', '30 April holiday', 'Summer starts', 'DIFF fireworks', 'Summer peak', 'Summer peak', 'Late summer', 'Rainy season', 'Rainy season', 'Christmas – New Year'],
            'tips_t' => 'Tips for booking a stay in Da Nang',
            'tips' => [
                ['📅', 'Book early for peaks', 'Tet, 30 April, summer and 31 December: book 1–2 months ahead; sea and river views go first.'],
                ['🌅', 'Pick the view', 'East-facing sea views get the sunrise; Han River views shine at night and during fireworks.'],
                ['🏢', 'High floors', 'Ask for the floor and exact view — “sea view” can mean a partial glimpse.'],
                ['🧒', 'With kids', 'Choose a pool, a lifeguarded beach nearby, family rooms or an apartment with a kitchen.'],
                ['🧳', 'Long stays', 'For 7+ nights consider an apartment with a kitchen and washer — often cheaper weekly or monthly.'],
                ['💳', 'Deposits & cancellations', 'Read deposit, cancellation and refund terms before paying; holiday bookings are often non-refundable.'],
                ['🚕', 'Airport transfers', 'The airport is ~3 km from the centre; pre-book a pickup for late arrivals or big groups.'],
                ['🌧️', 'Rainy season', 'October–December is cheaper; stay near the centre with an indoor pool or spa for rainy days.'],
            ],
            'faq_t' => 'Stay booking FAQ',
            'faq' => [
                ['Are the prices shown final?', 'They are typical ranges by type. Send your dates and guests and we quote each hotel within hours.'],
                ['Is it more expensive than booking apps?', 'Usually the same or better, as we work directly with hotels. Found it cheaper elsewhere? Send it to us.'],
                ['Do you handle groups?', 'Yes — 10+ rooms, team building and events, with group rates and transfers.'],
                ['How do I pay?', 'Vietnamese bank transfer or pay at the hotel depending on the property; you get a confirmation before arrival.'],
            ],
        ],
    ];
    $l = dst_lang();
    return isset($T[$l]) ? $T[$l] : $T['en'];
}

add_filter('dst_html', function ($html) {
    if (strpos($html, '<header class="page-head page-head--stays">') === false) {
        return $html;
    }
    $t = dst_stays_text();
    $avatar = (string) get_option('dst_contact_avatar', '');
    // Hero 2 cột
    $html = preg_replace_callback('#<header class="page-head page-head--stays">\s*<div class="wrap">(.*?)</div>\s*</header>#s', function ($m) use ($t, $avatar) {
        $inner = preg_replace('#<span class="kicker">.*?</span>#s', '<span class="ds-hero__kicker">' . esc_html($t['kicker']) . '</span>', $m[1], 1);
        $why = '';
        foreach ($t['whys'] as $w) {
            $why .= '<li>' . esc_html($w) . '</li>';
        }
        $chips = '';
        foreach ($t['areas'] as $i => $a) {
            if ($i < 4) {
                $chips .= '<a href="#khu-vuc">' . esc_html($a[0]) . '</a>';
            }
        }
        $card = '<aside class="st-card"><strong>' . esc_html($t['why']) . '</strong><ul>' . $why . '</ul>'
            . '<div class="st-card__who">' . ($avatar ? '<img src="' . esc_url($avatar) . '" alt="Vân Trần" width="44" height="44">' : '') . '<div><b>Vân Trần · 0909 669 325</b><span>' . esc_html($t['reply']) . '</span></div></div></aside>';
        return '<header class="page-head page-head--stays ds-hero st-hero"><div class="wrap st-hero__grid"><div>' . $inner
            . '<div class="ds-hero__actions"><a class="ds-btn ds-btn--call" href="#reserve">📩 ' . esc_html($t['cta1']) . '</a><a class="ds-btn ds-btn--zalo" href="https://zalo.me/0909669325" target="_blank" rel="noopener">💬 ' . esc_html($t['cta2']) . '</a></div>'
            . '<nav class="ds-hero__chips">' . $chips . '</nav></div>' . $card . '</div></header>';
    }, $html, 1);

    // Phần nội dung thêm, chèn sau bảng giá tham khảo
    $L = $t['lbl'];
    $areas = '';
    foreach ($t['areas'] as $a) {
        $areas .= '<article class="st-area"><h3>' . esc_html($a[0]) . '</h3><dl><dt>👥 ' . esc_html($L[0]) . '</dt><dd>' . esc_html($a[1]) . '</dd><dt>👍 ' . esc_html($L[1]) . '</dt><dd>' . esc_html($a[2]) . '</dd><dt>⚠️ ' . esc_html($L[2]) . '</dt><dd>' . esc_html($a[3]) . '</dd></dl></article>';
    }
    $lvl = [0, 0, 1, 0, 1, 0, 0, 0, 1, 2, 2, 0];
    $cls = ['hi', 'mid', 'lo'];
    $months = '';
    foreach ($t['months'] as $i => $mo) {
        $months .= '<div class="st-m st-m--' . $cls[$lvl[$i]] . '"><b>' . esc_html($mo) . '</b><span>' . esc_html($t['notes'][$i]) . '</span></div>';
    }
    $legend = '<div class="st-legend"><span class="hi">' . esc_html($t['lv'][0]) . '</span><span class="mid">' . esc_html($t['lv'][1]) . '</span><span class="lo">' . esc_html($t['lv'][2]) . '</span></div>';
    $tips = '';
    foreach ($t['tips'] as $p) {
        $tips .= '<div class="st-tip"><span>' . $p[0] . '</span><strong>' . esc_html($p[1]) . '</strong><p>' . esc_html($p[2]) . '</p></div>';
    }
    $faq = '';
    foreach ($t['faq'] as $i => $q) {
        $faq .= '<details' . ($i === 0 ? ' open' : '') . '><summary>' . esc_html($q[0]) . '</summary><p>' . esc_html($q[1]) . '</p></details>';
    }
    $extra = '<section class="st-extra"><div class="wrap">'
        . '<div class="st-block" id="khu-vuc"><span class="kicker">01</span><h2>' . esc_html($t['areas_t']) . '</h2><p class="st-lead">' . esc_html($t['areas_p']) . '</p><div class="st-areas">' . $areas . '</div></div>'
        . '<div class="st-block"><span class="kicker">02</span><h2>' . esc_html($t['season_t']) . '</h2><p class="st-lead">' . esc_html($t['season_p']) . '</p>' . $legend . '<div class="st-months">' . $months . '</div></div>'
        . '<div class="st-block"><span class="kicker">03</span><h2>' . esc_html($t['tips_t']) . '</h2><div class="st-tips">' . $tips . '</div></div>'
        . '<div class="st-block st-block--faq"><span class="kicker">04</span><h2>' . esc_html($t['faq_t']) . '</h2><div class="st-faq">' . $faq . '</div>' . do_shortcode('[ds_lien_he]') . '</div>'
        . '</div></section>';
    $pos = strpos($html, '<section class="section section--tight">');
    if ($pos !== false) {
        $html = substr($html, 0, $pos) . $extra . substr($html, $pos);
    }
    return str_replace('<body class="', '<body class="ds-stays ', $html);
}, 12);

add_action('wp_head', function () {
    ?>
<style id="dst-stays-css">
body.ds-stays .page-head.st-hero { padding: 140px 0 56px; background: linear-gradient(135deg, #0b2447 0%, #133a6b 60%, #1e4f8a 100%); color: #fff; }
.st-hero__grid { display: grid; grid-template-columns: minmax(0, 1fr) 380px; gap: 48px; align-items: center; }
body.ds-stays .st-hero h1 { color: #fff; font-size: clamp(40px, 5vw, 72px); margin: 12px 0 14px; }
body.ds-stays .st-hero h1 em { color: #ffa04d; }
body.ds-stays .st-hero p { color: #d6e0ee; max-width: 620px; margin: 0 0 22px; }
.st-card { background: #fff; color: var(--ink); border-radius: 18px; padding: 22px 22px 18px; box-shadow: 0 30px 60px -30px rgba(0,0,0,.6); }
.st-card > strong { display: block; font: 600 20px/1.3 var(--serif); margin-bottom: 10px; }
.st-card ul { list-style: none; margin: 0 0 16px; padding: 0; display: grid; gap: 8px; }
.st-card li { position: relative; padding-left: 26px; font-size: 15px; line-height: 1.45; color: var(--ink-2); }
.st-card li::before { content: "✓"; position: absolute; left: 0; top: 0; width: 18px; height: 18px; border-radius: 50%; background: #fff1e8; color: var(--bronze); font: 700 11px/18px var(--sans); text-align: center; }
.st-card__who { display: flex; gap: 12px; align-items: center; padding-top: 14px; border-top: 1px solid var(--line); }
.st-card__who img { width: 44px; height: 44px; border-radius: 50%; object-fit: cover; }
.st-card__who b { display: block; font-size: 14.5px; } .st-card__who span { font-size: 12.5px; color: var(--muted); }
body.ds-stays main > .section { padding-top: 64px; padding-bottom: 32px; }
.st-extra { padding: 8px 0 40px; }
.st-block { margin-top: 64px; }
.st-block h2 { font-size: clamp(30px, 3.4vw, 46px); margin: 6px 0 8px; }
.st-lead { color: var(--muted); margin: 0 0 22px; max-width: 720px; }
.st-areas { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px; }
.st-area { background: #fff; border: 1px solid var(--line); border-top: 4px solid var(--bronze); border-radius: 14px; padding: 18px 20px; box-shadow: 0 14px 34px -28px rgba(11,36,71,.6); }
.st-area h3 { margin: 0 0 10px; font-size: 21px; }
.st-area dl { margin: 0; display: grid; gap: 6px; }
.st-area dt { font: 700 12px/1.3 var(--sans); letter-spacing: .06em; text-transform: uppercase; color: var(--muted); margin-top: 4px; }
.st-area dd { margin: 0; font-size: 14.5px; line-height: 1.5; color: var(--ink-2); }
.st-legend { display: flex; gap: 14px; flex-wrap: wrap; margin-bottom: 12px; font-size: 13.5px; }
.st-legend span::before { content: ""; display: inline-block; width: 12px; height: 12px; border-radius: 3px; margin-right: 6px; vertical-align: -1px; }
.st-legend .hi::before, .st-m--hi { background: #ffe3cf; } .st-legend .mid::before, .st-m--mid { background: #fff4d6; } .st-legend .lo::before, .st-m--lo { background: #dff3e6; }
.st-legend .hi::before { background: var(--bronze); } .st-legend .mid::before { background: #f2b632; } .st-legend .lo::before { background: #22a06b; }
.st-months { display: grid; grid-template-columns: repeat(12, minmax(0, 1fr)); gap: 6px; }
.st-m { border-radius: 10px; padding: 10px 8px; min-height: 86px; }
.st-m b { display: block; font: 700 15px/1.2 var(--sans); color: var(--ink); }
.st-m span { display: block; font-size: 12px; line-height: 1.35; color: var(--ink-2); margin-top: 4px; }
.st-m--hi { border-bottom: 4px solid var(--bronze); } .st-m--mid { border-bottom: 4px solid #f2b632; } .st-m--lo { border-bottom: 4px solid #22a06b; }
.st-tips { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 14px; }
.st-tip { background: var(--ivory); border-radius: 14px; padding: 18px; }
.st-tip span { font-size: 26px; display: block; margin-bottom: 8px; }
.st-tip strong { display: block; font: 600 16px/1.3 var(--sans); color: var(--ink); margin-bottom: 4px; }
.st-tip p { margin: 0; font-size: 14px; line-height: 1.5; color: var(--ink-2); }
.st-block--faq { display: grid; grid-template-columns: minmax(0, 1fr); gap: 0; }
.st-faq details { border: 1px solid var(--line); border-radius: 12px; padding: 14px 18px; margin: 0 0 10px; background: #fff; }
.st-faq details[open] { border-color: var(--bronze); }
.st-faq summary { cursor: pointer; font: 600 16.5px/1.4 var(--sans); color: var(--ink); }
.st-faq p { margin: 10px 0 0; font-size: 15px; color: var(--ink-2); }
@media (max-width: 1100px) { .st-months { grid-template-columns: repeat(6, minmax(0, 1fr)); } .st-tips { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (max-width: 1000px) { .st-hero__grid { grid-template-columns: 1fr; gap: 28px; } .st-areas { grid-template-columns: 1fr 1fr; } body.ds-stays .page-head.st-hero { padding: 120px 0 40px; } }
@media (max-width: 640px) { .st-areas, .st-tips { grid-template-columns: 1fr; } .st-months { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
</style>
    <?php
}, 106);

// ===== 15. Khối "Tin báo chí" của theme → tin DanangStay tự viết lại (có ghi nguồn) =====
add_filter('dst_html', function ($html) {
    if (strpos($html, '<div class="press">') === false) {
        return $html;
    }
    $lang = function_exists('pll_current_language') ? dst_lang() : 'vi';
    $args = ['post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 6, 'ignore_sticky_posts' => true, 'no_found_rows' => true, 'lang' => $lang];
    $term = get_term_by('slug', 'news-' . $lang, 'category') ?: get_term_by('slug', 'news', 'category');
    if ($term) {
        $args['cat'] = $term->term_id;
    }
    $q = new WP_Query($args);
    $L = [
        'vi' => ['Tin du lịch mới', 'DanangStay tổng hợp và viết lại từ báo chí, mỗi bài đều ghi nguồn.'],
        'ko' => ['최신 여행 소식', 'DanangStay가 언론 보도를 정리해 다시 썼으며, 각 글에 출처를 밝힙니다.'],
    ];
    $t = $L[$lang] ?? ['Latest travel news', 'Summarised and rewritten by DanangStay from local press, with sources cited.'];
    $box = '';
    if (is_category()) {
        $q = new WP_Query(['post__in' => [0]]);
    }
    if ($q->have_posts()) {
        $box = '<div class="press press--own"><h3 class="press__title">' . esc_html($t[0]) . '</h3><ul>';
        while ($q->have_posts()) {
            $q->the_post();
            $box .= '<li><a href="' . esc_url(get_permalink()) . '">' . esc_html(get_the_title()) . '</a><small>DanangStay · ' . esc_html(get_the_date('d/m/Y')) . '</small></li>';
        }
        wp_reset_postdata();
        $box .= '</ul><p class="press__note">' . esc_html($t[1]) . '</p></div>';
    }
    return preg_replace('#<div class="press">.*?<p class="press__note">.*?</p>\s*</div>#s', $box, $html, 1);
}, 30);

function dst_side_css()
{
    static $done = false;
    if ($done) {
        return '';
    }
    $done = true;
    return '<style id="dst-art-css">
.ds-art__grid { width: min(1240px, calc(100% - 2 * var(--gutter, 24px))); margin: 0 auto; display: grid; grid-template-columns: minmax(0, 1fr) 340px; gap: 56px; align-items: stretch; }
.ds-art .narrow { width: auto !important; max-width: 780px; margin: 0 !important; }
.ds-art .narrow .prose, .ds-art .narrow > * { width: auto !important; max-width: none; }
.ds-art__stick { position: sticky; top: 100px; }
.ds-art__sticky { height: 100%; display: flex; flex-direction: column; gap: 18px; }
.ds-art__side .ds-contact { margin: 0; }
.ds-art .prose > figure, .ds-art .prose figure.wide, .ds-art figure.wide { width: 100% !important; max-width: 100% !important; margin-left: 0 !important; margin-right: 0 !important; left: auto !important; transform: none !important; }
.ds-art .prose > figure img { width: 100%; height: auto; border-radius: 12px; }
.ds-contact__qr img { width: 84px !important; height: 84px !important; max-width: none !important; }
@container (min-width: 560px) { .ds-contact__qr img { width: 120px !important; height: 120px !important; } }
.ds-contact__qr { width: auto !important; }
.ds-rules li.is-new em { font-style: normal; font-size: 11px; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; background: var(--bronze); color: #fff; border-radius: 4px; padding: 2px 6px; margin-right: 4px; vertical-align: 1px; }
.ds-rules li.is-new a { color: inherit; text-decoration: underline; text-underline-offset: 3px; }
.ds-toc { border: 1px solid var(--line); border-radius: 14px; padding: 16px 18px; background: #fff; font-family: var(--sans); }
.ds-toc b, .ds-side-svc > b { display: block; font: 700 12px/1 var(--sans); letter-spacing: .12em; text-transform: uppercase; color: var(--bronze); margin-bottom: 10px; }
.ds-toc ol { margin: 0; padding: 0; list-style: none; counter-reset: t; max-height: 38vh; overflow: auto; }
.ds-toc li { counter-increment: t; }
.ds-toc a { display: flex; gap: 10px; padding: 6px 0; font-size: 14.5px; line-height: 1.4; color: var(--ink-2); text-decoration: none; border-bottom: 1px dashed var(--line); }
.ds-toc a::before { content: counter(t); flex: none; width: 22px; height: 22px; border-radius: 50%; background: var(--ivory); font-size: 12px; font-weight: 700; display: grid; place-items: center; color: var(--ink); }
.ds-toc a.on, .ds-toc a:hover { color: var(--bronze); }
.ds-side-svc { border-radius: 14px; background: var(--ivory); padding: 16px; font-family: var(--sans); }
.ds-side-svc a { display: flex; gap: 12px; align-items: center; padding: 10px; border-radius: 10px; background: #fff; margin-top: 8px; text-decoration: none; transition: transform .15s, box-shadow .15s; }
.ds-side-svc a:hover { transform: translateX(3px); box-shadow: 0 4px 14px rgba(15,35,64,.1); }
.ds-side-svc a > span { font-size: 22px; width: 40px; height: 40px; border-radius: 10px; background: var(--ivory); display: grid; place-items: center; flex: none; }
.ds-side-svc strong { display: block; font: 600 15px/1.2 var(--sans); color: var(--ink); }
.ds-side-svc small { display: block; font-size: 12.5px; color: var(--ink-2); margin-top: 2px; }
.ds-art__side .ds-news { margin: 0; }
.prose table thead th, .prose thead td { color: #fff !important; padding: 12px 14px !important; }
.prose table td { padding: 11px 14px !important; }
@media (max-width: 1080px) { .ds-art__grid { grid-template-columns: 1fr; gap: 32px; } .ds-art .narrow { max-width: 780px; margin: 0 auto !important; } .ds-art__stick { position: static; } .ds-toc { display: none; } .ds-art__side { max-width: 780px; margin: 0 auto; width: 100%; } }
</style>';
}

function dst_side_html($toc = true, $top = '')
{
    $lang = dst_lang();
    $home = trailingslashit(dst_lang_home());
    $T = [
        'vi' => ['Trong bài này', 'Dịch vụ DanangStay', 'Chỗ ở', 'Khách sạn, căn hộ, villa', 'Vé máy bay', 'Giá tốt, tư vấn hành lý', 'Vé tham quan', 'Bà Nà, Hội An, Huế…', 'Xe & tour', 'Đưa đón sân bay, tour riêng'],
        'ko' => ['목차', 'DanangStay 서비스', '숙소', '호텔·아파트·빌라', '항공권', '좋은 가격, 수하물 안내', '입장권', '바나힐·호이안·후에…', '차량·투어', '공항 픽업, 프라이빗 투어'],
    ];
    $t = $T[$lang] ?? ['In this article', 'DanangStay services', 'Stays', 'Hotels, apartments, villas', 'Flights', 'Good fares, baggage advice', 'Attraction tickets', 'Ba Na, Hoi An, Hue…', 'Cars & tours', 'Airport pickup, private tours'];
    $svc = dst_page_url('dst_services_page') ?: $home;
    $items = [
        ['🏨', $t[2], $t[3], $home . 'stays/'],
        ['✈️', $t[4], $t[5], $home . 'flights/'],
        ['🎟️', $t[6], $t[7], dst_tickets_url() ?: $svc],
        ['🚐', $t[8], $t[9], $svc],
    ];
    $s = '<aside class="ds-art__side"><div class="ds-art__sticky">' . $top;
    if ($toc) {
        $s .= '<nav class="ds-toc" hidden><b>' . esc_html($t[0]) . '</b><ol></ol></nav>';
    }
    $s .= '<div class="ds-side-svc"><b>' . esc_html($t[1]) . '</b>';
    foreach ($items as $i) {
        $s .= '<a href="' . esc_url($i[3]) . '"><span>' . $i[0] . '</span><div><strong>' . esc_html($i[1]) . '</strong><small>' . esc_html($i[2]) . '</small></div></a>';
    }
    $s .= '</div>' . do_shortcode('[ds_tin_moi so="4" kieu="gon"]') . '<div class="ds-art__stick">' . do_shortcode('[ds_lien_he]') . '</div></div></aside>';
    return $s;
}

// ===== 16. Trang bài viết: khung rộng 2 cột + cột bên (liên hệ, mục lục, dịch vụ, tin mới) =====
add_filter('dst_html', function ($html) {
    if (!preg_match('#<body class="[^"]*\bsingle-post\b#', $html) || strpos($html, '<div class="section article-body">') === false || strpos($html, 'ds-art__side') !== false) {
        return $html;
    }
    $s = dst_side_html(true);
    $html = str_replace('<div class="section article-body">', '<div class="section article-body ds-art"><div class="ds-art__grid">', $html);
    $html = preg_replace('#</div>(\s*</div>\s*</article>)#', '</div>' . str_replace(['\\', '$'], ['\\\\', '\\$'], $s) . '</div>$1', $html, 1);
    $css = dst_side_css();
    $js = '<script id="dst-art-js">(function(){var p=document.querySelector(".ds-art .prose"),n=document.querySelector(".ds-toc");if(!p||!n)return;var hs=p.querySelectorAll("h2");if(hs.length<3)return;var ol=n.querySelector("ol"),as=[];hs.forEach(function(h,i){if(!h.id)h.id="muc-"+(i+1);var a=document.createElement("a");a.href="#"+h.id;a.textContent=h.textContent;var li=document.createElement("li");li.appendChild(a);ol.appendChild(li);as.push([h,a]);});n.hidden=false;addEventListener("scroll",function(){var c=null;as.forEach(function(x){if(x[0].getBoundingClientRect().top<140)c=x[1];});as.forEach(function(x){x[1].classList.toggle("on",x[1]===c);});},{passive:true});})();</script>';
    $html = str_replace('</head>', $css . '</head>', $html);
    return str_replace('</body>', $js . '</body>', $html);
}, 40);


// ===== 17. Trang Sự kiện: 2 cột, cột bên (thời tiết, mục theo tháng, liên hệ, tin), nút hỏi phòng/vé mỗi sự kiện =====
add_filter('dst_html', function ($html) {
    if (strpos($html, '<nav class="stay-tabs ev-tabs" id="evTabs">') === false || strpos($html, 'ds-ev__grid') !== false) {
        return $html;
    }
    $lang = dst_lang();
    $T = [
        'vi' => ['Xem nhanh theo tháng', 'sự kiện', 'Hỏi phòng gần đây', 'Hỏi vé & xe', 'Thời tiết 7 ngày tới'],
        'ko' => ['월별 보기', '개 행사', '근처 숙소 문의', '티켓·차량 문의', '7일 날씨'],
    ];
    $t = $T[$lang] ?? ['Jump to month', 'events', 'Ask for a room nearby', 'Tickets & transfers', '7-day weather'];
    // mục lục theo tháng
    $idx = '';
    if (preg_match_all('#<div class="ev-month">\s*<h3 class="ev-month__h">([^<]+)</h3>(.*?)(?=<div class="ev-month">|<aside class="stay-cta ev-cta">|<h2 class="ev-h)#s', $html, $m, PREG_SET_ORDER)) {
        $n = 0;
        foreach ($m as $mm) {
            $n++;
            $html = preg_replace('#<h3 class="ev-month__h">' . preg_quote($mm[1], '#') . '</h3>#', '<h3 class="ev-month__h" id="thang-' . $n . '">' . $mm[1] . '</h3>', $html, 1);
            $idx .= '<a href="#thang-' . $n . '"><b>' . esc_html($mm[1]) . '</b><span>' . substr_count($mm[2], '<article class="ev') . ' ' . esc_html($t[1]) . '</span></a>';
        }
    }
    $top = '<div class="ds-ev-side-w"><b class="ds-side-h">' . esc_html($t[4]) . '</b><div class="ds-weather"></div></div>';
    if ($idx) {
        $top = '<nav class="ds-ev-idx"><b class="ds-side-h">' . esc_html($t[0]) . '</b>' . $idx . '</nav>' . $top;
    }
    $side = dst_side_html(false, $top);
    // nút hành động cho từng sự kiện sắp diễn ra
    $stays = trailingslashit(dst_lang_home()) . 'stays/';
    $btn = '<p class="ds-ev-act"><a href="' . esc_url($stays) . '">🏨 ' . esc_html($t[2]) . '</a><a href="https://zalo.me/0909669325" target="_blank" rel="noopener">🎟️ ' . esc_html($t[3]) . '</a></p>';
    $cut = strpos($html, '<h2 class="ev-h ev-h--past"');
    $head = $cut === false ? $html : substr($html, 0, $cut);
    $tail = $cut === false ? '' : substr($html, $cut);
    $head = preg_replace('#(<article class="ev"[^>]*>.*?)(</div>\s*</article>)#s', '$1' . $btn . '$2', $head);
    $html = $head . $tail;
    // bọc 2 cột
    $html = preg_replace('#<section class="section">\s*<div class="wrap">\s*(<nav class="stay-tabs ev-tabs" id="evTabs">)#', '<section class="section ds-ev"><div class="wrap ds-ev__grid"><div class="ds-ev__main">$1', $html, 1);
    $html = preg_replace('#(</div>\s*</section>\s*<section class="concierge)#', '</div>' . str_replace(['\\', '$'], ['\\\\', '\\$'], $side) . '$1', $html, 1);
    $css = '<style id="dst-ev-css">
.ds-ev__grid { display: grid; grid-template-columns: minmax(0, 1fr) 340px; gap: 48px; align-items: stretch; }
.ds-ev__main { min-width: 0; }
.ds-ev .ds-art__side .ds-contact { margin: 0; }
.ds-side-h { display: block; font: 700 12px/1 var(--sans); letter-spacing: .12em; text-transform: uppercase; color: var(--bronze); margin-bottom: 10px; }
.ds-ev-idx { border: 1px solid var(--line); border-radius: 14px; padding: 16px; background: #fff; font-family: var(--sans); }
.ds-ev-idx a { display: flex; justify-content: space-between; align-items: center; padding: 9px 12px; margin-top: 6px; border-radius: 10px; background: var(--ivory); text-decoration: none; color: var(--ink); }
.ds-ev-idx a:hover { background: var(--sea); color: #fff; }
.ds-ev-idx a b { font-weight: 600; font-size: 15px; } .ds-ev-idx a span { font-size: 12.5px; opacity: .75; }
.ds-ev-side-w .ds-weather { margin: 0; padding: 14px; }
.ds-ev-side-w .ds-weather__head { display: none; }
.ds-ev-side-w .ds-weather__days { grid-template-columns: 1fr !important; grid-auto-flow: row !important; grid-auto-columns: auto !important; gap: 6px; overflow: visible; }
.ds-ev-side-w .ds-weather__day { display: grid; grid-template-columns: 1.3fr auto 1fr 1fr; align-items: center; gap: 6px; text-align: left; padding: 8px 10px; }
.ds-ev-side-w .ds-weather__day * { margin: 0 !important; }
.ds-ev-act { display: flex; flex-wrap: wrap; gap: 8px; margin: 12px 0 0 !important; }
.ds-ev-act a { font: 600 13px/1 var(--sans); padding: 8px 12px; border-radius: 999px; border: 1px solid var(--line); background: #fff; color: var(--ink) !important; text-decoration: none; }
.ds-ev-act a:hover { border-color: var(--bronze); color: var(--bronze) !important; }
.ds-ev-month__h, .ev-month__h { scroll-margin-top: 110px; }
@media (max-width: 1080px) { .ds-ev__grid { grid-template-columns: 1fr; } .ds-ev .ds-art__stick { position: static; } }
</style>';
    return str_replace('</head>', dst_side_css() . $css . '</head>', $html);
}, 41);

// ===== 18. Trang Vé tham quan (máy tính): cột trái chọn nhanh 18 điểm, nhảy tới từng điểm =====
add_filter('dst_html', function ($html) {
    if (strpos($html, '<div class="ds-tickets') === false || strpos($html, 'ds-tk__grid') !== false
        || !preg_match('#<section class="section">\s*<div class="narrow prose">#', $html)) {
        return $html;
    }
    $lang = dst_lang();
    $T = ['vi' => ['Chọn điểm tham quan', 'Nhắn Zalo đặt vé', 'Báo giá trong ngày'], 'ko' => ['명소 선택', 'Zalo로 예약 문의', '당일 견적']];
    $t = $T[$lang] ?? ['Choose an attraction', 'Book via WhatsApp/Zalo', 'Same-day quote'];
    // gắn id cho từng điểm, dựng danh sách theo khu vực
    $n = 0;
    $html = preg_replace_callback('#<div class="ds-ticket">#', function () use (&$n) {
        $n++;
        return '<div class="ds-ticket" id="diem-' . $n . '">';
    }, $html);
    if ($n < 3) {
        return $html;
    }
    $nav = '';
    $i = 0;
    if (preg_match_all('#<h2 id="([a-z-]+)" class="ds-area">([^<]+)</h2>(.*?)(?=<h2 |$)#s', $html, $areas, PREG_SET_ORDER)) {
        foreach ($areas as $a) {
            if (!preg_match_all('#<h3>([^<]+)</h3>#', $a[3], $hs)) {
                continue;
            }
            $nav .= '<div class="ds-tk__grp"><a class="ds-tk__area" href="#' . $a[1] . '">' . esc_html(html_entity_decode($a[2])) . ' <small>' . count($hs[1]) . '</small></a><ol>';
            foreach ($hs[1] as $h) {
                $i++;
                if ($i > $n) {
                    break;
                }
                $nav .= '<li><a href="#diem-' . $i . '"><span>' . sprintf('%02d', $i) . '</span>' . $h . '</a></li>';
            }
            $nav .= '</ol></div>';
        }
    }
    if ($nav === '') {
        return $html;
    }
    $side = '<aside class="ds-tk__side"><nav class="ds-tk__nav"><b class="ds-side-h">' . esc_html($t[0]) . '</b>' . $nav
        . '<a class="ds-btn ds-btn--zalo ds-tk__cta" href="https://zalo.me/0909669325" target="_blank" rel="noopener">💬 ' . esc_html($t[1]) . '</a>'
        . '<p class="ds-tk__note">📞 0909 669 325 · ' . esc_html($t[2]) . '</p></nav></aside>';
    $html = preg_replace('#<section class="section">\s*<div class="narrow prose">#', '<section class="section ds-tk"><div class="ds-tk__grid">' . str_replace(['\\', '$'], ['\\\\', '\\$'], $side) . '<div class="narrow prose">', $html, 1);
    $html = preg_replace('#(</div>)(\s*</section>\s*</main>)#', '$1</div>$2', $html, 1);
    $css = '<style id="dst-tk-css">
.ds-tk__grid { width: min(1240px, calc(100% - 2 * var(--gutter, 24px))); margin: 0 auto; display: grid; grid-template-columns: 290px minmax(0, 1fr); gap: 56px; align-items: start; }
.ds-tk .narrow { width: auto !important; max-width: 860px; margin: 0 !important; }
.ds-tk__side { position: sticky; top: 96px; max-height: calc(100vh - 116px); overflow: auto; scrollbar-width: thin; }
.ds-tk__nav { border: 1px solid var(--line); border-radius: 14px; padding: 16px; background: #fff; font-family: var(--sans); }
.ds-side-h { display: block; font: 700 12px/1 var(--sans); letter-spacing: .12em; text-transform: uppercase; color: var(--bronze); margin-bottom: 10px; }
.ds-tk__area { display: flex; justify-content: space-between; align-items: center; margin-top: 12px; padding: 8px 10px; border-radius: 8px; background: var(--sea); color: #fff !important; font: 600 14px/1.2 var(--sans); text-decoration: none; }
.ds-tk__area small { font-size: 12px; opacity: .8; }
.ds-tk__grp ol { list-style: none; margin: 4px 0 0; padding: 0; }
.ds-tk__grp li a { display: flex; gap: 10px; align-items: baseline; padding: 6px 8px; border-radius: 8px; font-size: 14px; line-height: 1.35; color: var(--ink-2); text-decoration: none; }
.ds-tk__grp li a span { font: 700 11.5px/1 var(--sans); color: var(--bronze); flex: none; width: 20px; }
.ds-tk__grp li a:hover, .ds-tk__grp li a.on { background: var(--ivory); color: var(--ink); }
.ds-tk__grp li a.on { font-weight: 600; box-shadow: inset 3px 0 0 var(--bronze); }
.ds-tk__cta { display: flex !important; justify-content: center; margin-top: 14px; }
.ds-tk__note { margin: 8px 0 0 !important; font-size: 12.5px !important; color: var(--muted, #6b7280) !important; text-align: center !important; }
.ds-ticket, .ds-area { scroll-margin-top: 100px; }
.ds-tk .narrow { max-width: none !important; }
body.ds-svcpage .ds-tk .prose .ds-tickets, body.ds-svcpage .ds-tk .prose h2.ds-area, body.ds-svcpage .ds-tk .prose .ds-news { width: auto !important; left: auto !important; transform: none !important; }
body.ds-svcpage .ds-tk .prose .ds-tickets { grid-template-columns: repeat(2, minmax(0, 1fr)); }
@media (max-width: 700px) { body.ds-svcpage .ds-tk .prose .ds-tickets { grid-template-columns: 1fr; } }
.ds-ticket:target { box-shadow: 0 0 0 2px var(--bronze); }
@media (max-width: 1080px) { .ds-tk__grid { grid-template-columns: 1fr; } .ds-tk__side { display: none; } .ds-tk .narrow { margin: 0 auto !important; } }
</style>';
    $js = '<script id="dst-tk-js">(function(){var l=[].slice.call(document.querySelectorAll(".ds-tk__grp li a"));if(!l.length)return;var t=l.map(function(a){return document.querySelector(a.getAttribute("href"));});addEventListener("scroll",function(){var c=-1;t.forEach(function(e,i){if(e&&e.getBoundingClientRect().top<160)c=i;});l.forEach(function(a,i){a.classList.toggle("on",i===c);});if(c>=0){var a=l[c],s=document.querySelector(".ds-tk__side"),r=a.getBoundingClientRect(),q=s.getBoundingClientRect();if(r.top<q.top||r.bottom>q.bottom)s.scrollTop+=r.top-q.top-q.height/2;}},{passive:true});})();</script>';
    $html = str_replace('</head>', $css . '</head>', $html);
    return str_replace('</body>', $js . '</body>', $html);
}, 42);

// ===== 19. Ảnh đại diện (featured image) được ưu tiên: ảnh bìa bài viết + ảnh thẻ bài ở mọi danh sách =====
function dst_swap_img($tag, $id)
{
    $src = get_the_post_thumbnail_url($id, 'full');
    if (!$src) {
        return $tag;
    }
    $alt = trim(strip_tags(get_post_meta(get_post_thumbnail_id($id), '_wp_attachment_image_alt', true))) ?: get_the_title($id);
    $tag = preg_replace('#\ssrcset="[^"]*"#', '', $tag);
    $tag = preg_replace('#\ssizes="[^"]*"#', '', $tag);
    $tag = preg_replace('#\ssrc="[^"]*"#', ' src="' . esc_url($src) . '"', $tag, 1);
    return preg_replace('#\salt="[^"]*"#', ' alt="' . esc_attr($alt) . '"', $tag, 1);
}
add_filter('dst_html', function ($html) {
    // ảnh bìa trang bài
    if (is_singular('post')) {
        $id = get_queried_object_id();
        if (has_post_thumbnail($id)) {
            $html = preg_replace_callback('#(<header class="article-hero">\s*)(<img[^>]*>)#', function ($m) use ($id) {
                return $m[1] . dst_swap_img($m[2], $id);
            }, $html, 1);
        }
    }
    // ảnh trong thẻ link tới bài
    $home = preg_quote(home_url('/'), '#');
    return preg_replace_callback('#<a\s[^>]*href="(' . $home . '[^"\#?]+)"[^>]*>(?:(?!</a>).)*?<img[^>]*>#s', function ($m) {
        static $cache = [];
        $u = $m[1];
        if (!isset($cache[$u])) {
            $cache[$u] = url_to_postid($u);
        }
        $id = $cache[$u];
        if (!$id || get_post_type($id) !== 'post' || !has_post_thumbnail($id)) {
            return $m[0];
        }
        return preg_replace_callback('#<img[^>]*>#', function ($i) use ($id) {
            return dst_swap_img($i[0], $id);
        }, $m[0], 1);
    }, $html);
}, 50);

// ===== 20. "Tin tức" thành mục riêng trên menu chính (bỏ khỏi menu con Khám phá) =====
add_filter('dst_html', function ($html) {
    if (!preg_match('#<nav class="nav" aria-label="[^"]*">.*?</nav>#s', $html, $nm)) {
        return $html;
    }
    $nav = $nm[0];
    if (!preg_match('#<a href="([^"]*/category/news[^"]*)"[^>]*>([^<]+)</a>#', $nav, $nl) || strpos($nav, 'ds-nav-news') !== false) {
        return $html;
    }
    $new = str_replace($nl[0], '', $nav);
    $cur = (is_category() && strpos(get_term_link(get_queried_object()), '/news') !== false) ? ' aria-current="page"' : '';
    $item = '<a href="' . $nl[1] . '" class="ds-nav-news"' . $cur . '>' . $nl[2] . '</a>' . "\n";
    $new = preg_replace('#(<a href="[^"]*/events/"[^>]*>)#', $item . '$1', $new, 1, $cnt);
    if (!$cnt) {
        return $html;
    }
    return str_replace($nav, $new, $html);
}, 60);

// ===== 21. Trang chuyên mục: đầu trang 2 cột (mô tả + khung hỗ trợ), bớt khoảng trắng, khối đọc thêm + quy định =====
add_filter('dst_html', function ($html) {
    if (!is_category() || strpos($html, '<header class="page-head">') === false || strpos($html, 'ds-cat__side') !== false) {
        return $html;
    }
    $lang = dst_lang();
    $term = get_queried_object();
    $base = preg_replace('#-(vi|ko|ja|zh|ru|fr|de)$#', '', $term->slug);
    $D = [
        'vi' => [
            'news' => 'Tin du lịch Đà Nẵng – Hội An – Huế cập nhật mỗi sáng: quy định mới, lễ hội, điểm đến, thời tiết. Mỗi bài được viết lại dễ hiểu và ghi rõ nguồn báo.',
            'plan' => 'Kinh nghiệm lên kế hoạch: lịch trình, chi phí, thời tiết từng tháng, đi lại và mẹo của người Đà Nẵng — để chuyến đi trọn vẹn, không tốn tiền oan.',
            'places' => 'Điểm đến và điểm check-in đẹp ở Đà Nẵng, Hội An, Huế: nên đi giờ nào, mất bao lâu, vé ra sao, chụp ảnh ở đâu.',
            'food' => 'Ăn gì, ở đâu: quán ngon người địa phương hay ăn, hải sản giá rõ ràng, cà phê đẹp và đặc sản mang về.',
            'culture' => 'Con người, phong tục, di sản và lễ hội miền Trung — hiểu để đi chậm và cảm nhận sâu hơn.',
            'h' => ['bài viết', 'Cập nhật', 'Cần đặt phòng, vé hay xe?', 'Nhắn Vân Trần — báo giá trong ngày.', 'Đọc thêm', 'Bài mới ở các chuyên mục khác'],
        ],
        'ko' => [
            'news' => '매일 아침 업데이트되는 다낭·호이안·후에 여행 소식: 새 규정, 축제, 명소, 날씨. 모든 글에 출처를 밝힙니다.',
            'plan' => '일정, 경비, 월별 날씨, 이동, 현지인 팁까지 — 알찬 다낭 여행 준비 가이드.',
            'places' => '다낭·호이안·후에의 명소와 사진 스폿: 추천 시간, 소요 시간, 입장권 정보.',
            'food' => '현지인 맛집, 가격이 분명한 해산물 식당, 예쁜 카페와 기념품.',
            'culture' => '중부 베트남의 사람, 풍습, 유산과 축제.',
            'h' => ['개의 글', '업데이트', '숙소·티켓·차량 예약이 필요하세요?', 'Vân Trần에게 문의 — 당일 견적.', '더 읽기', '다른 카테고리의 새 글'],
        ],
    ];
    $E = [
        'news' => 'Da Nang, Hoi An and Hue travel news updated every morning: new rules, festivals, places and weather — rewritten clearly, sources cited.',
        'plan' => 'Planning guides: itineraries, costs, month-by-month weather, getting around and local tips.',
        'places' => 'The best places and photo spots in Da Nang, Hoi An and Hue — when to go, how long, tickets.',
        'food' => 'Where locals eat, honest seafood spots, beautiful cafés and gifts to take home.',
        'culture' => 'People, customs, heritage and festivals of Central Vietnam.',
        'h' => ['articles', 'Updated', 'Need a room, tickets or a car?', 'Message Vân Trần — same-day quote.', 'Keep reading', 'New in other sections'],
    ];
    $d = $D[$lang] ?? $E;
    $desc = $d[$base] ?? ($E[$base] ?? '');
    $h = $d['h'];
    $last = get_posts(['category' => $term->term_id, 'numberposts' => 1, 'lang' => $lang]);
    $date = $last ? get_the_date('d/m/Y', $last[0]) : '';
    $home = trailingslashit(dst_lang_home());
    $svc = [
        ['🏨', $lang === 'ko' ? '숙소' : ($lang === 'vi' ? 'Chỗ ở' : 'Stays'), $home . 'stays/'],
        ['✈️', $lang === 'ko' ? '항공권' : ($lang === 'vi' ? 'Vé máy bay' : 'Flights'), $home . 'flights/'],
        ['🎟️', $lang === 'ko' ? '입장권' : ($lang === 'vi' ? 'Vé tham quan' : 'Tickets'), dst_tickets_url() ?: $home],
    ];
    $avatar = (string) get_option('dst_contact_avatar', '');
    $side = '<aside class="ds-cat__side"><div class="ds-cat__stats"><div><b>' . (int) $term->count . '</b><span>' . esc_html($h[0]) . '</span></div>'
        . ($date ? '<div><b>' . esc_html($date) . '</b><span>' . esc_html($h[1]) . '</span></div>' : '') . '</div>'
        . '<div class="ds-cat__help">' . ($avatar ? '<img src="' . esc_url($avatar) . '" alt="Vân Trần" width="52" height="52">' : '')
        . '<div><strong>' . esc_html($h[2]) . '</strong><small>' . esc_html($h[3]) . '</small></div></div>'
        . '<div class="ds-cat__btns"><a class="ds-btn ds-btn--zalo" href="https://zalo.me/0909669325" target="_blank" rel="noopener">Zalo</a><a class="ds-btn ds-btn--call" href="tel:0909669325">📞 0909 669 325</a></div>'
        . '<div class="ds-cat__svc">';
    foreach ($svc as $s) {
        $side .= '<a href="' . esc_url($s[2]) . '"><span>' . $s[0] . '</span>' . esc_html($s[1]) . '</a>';
    }
    $side .= '</div></aside>';
    $html = preg_replace('#<header class="page-head">\s*<div class="wrap">(.*?)</div>\s*</header>#s',
        '<header class="page-head ds-cat"><div class="wrap ds-cat__grid"><div class="ds-cat__main">$1</div>' . str_replace(['\\', '$'], ['\\\\', '\\$'], $side) . '</div></header>', $html, 1);
    if ($desc) {
        $html = preg_replace('#(<div class="ds-cat__main">.*?</h1>)#s', '$1<p class="ds-cat__desc">' . str_replace(['\\', '$'], ['\\\\', '\\$'], esc_html($desc)) . '</p>', $html, 1);
    }
    // khối đọc thêm + quy định cuối trang
    $more = '<section class="section ds-cat-more"><div class="wrap ds-cat-more__grid"><div><span class="kicker">' . esc_html($h[4]) . '</span><h2>' . esc_html($h[5]) . '</h2>'
        . do_shortcode('[ds_tin_moi so="6"]') . '</div><div>' . do_shortcode('[ds_quy_dinh]') . '</div></div></section>';
    $html = preg_replace('#(</section>)(\s*<section class="concierge|\s*</main>)#', '$1' . str_replace(['\\', '$'], ['\\\\', '\\$'], $more) . '$2', $html, 1);
    $css = '<style id="dst-cat-css">
.page-head.ds-cat { padding-bottom: 48px; }
.journal { justify-content: flex-start !important; }
.ds-cat__desc { margin-bottom: 18px !important; }
@media (max-width: 760px) { .journal .card--lead { display: block !important; } .journal .card--lead .card__img { margin-bottom: 16px !important; } .journal .card { flex-basis: 100% !important; } }
.ds-cat__grid { display: grid; grid-template-columns: minmax(0, 1fr) 380px; gap: 56px; align-items: center; }
.ds-cat__main h1 { margin-bottom: 10px; }
.ds-cat__desc { max-width: 640px; font-size: 18px; line-height: 1.6; color: var(--ink-2); margin: 6px 0 22px; }
.ds-cat__main .filter { margin-top: 0; }
.ds-cat__side { background: #fff; border: 1px solid var(--line); border-radius: 18px; padding: 20px; box-shadow: 0 18px 40px -24px rgba(11,36,71,.35); font-family: var(--sans); }
.ds-cat__stats { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 16px; }
.ds-cat__stats div { background: var(--ivory); border-radius: 12px; padding: 12px 14px; }
.ds-cat__stats b { display: block; font: 700 22px/1.1 var(--sans); color: var(--ink); }
.ds-cat__stats span { font-size: 12.5px; color: var(--ink-2); }
.ds-cat__help { display: flex; gap: 12px; align-items: center; margin-bottom: 12px; }
.ds-cat__help img { width: 52px; height: 52px; border-radius: 50%; object-fit: cover; flex: none; }
.ds-cat__help strong { display: block; font-size: 15.5px; color: var(--ink); }
.ds-cat__help small { font-size: 13px; color: var(--ink-2); }
.ds-cat__btns { display: grid; grid-template-columns: 1fr 1.6fr; gap: 8px; margin-bottom: 12px; }
.ds-cat__btns .ds-btn { justify-content: center; }
.ds-cat__svc { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; }
.ds-cat__svc a { display: flex; flex-direction: column; align-items: center; gap: 4px; padding: 10px 6px; border-radius: 12px; border: 1px solid var(--line); font-size: 13px; font-weight: 600; color: var(--ink); text-decoration: none; text-align: center; }
.ds-cat__svc a span { font-size: 20px; }
.ds-cat__svc a:hover { border-color: var(--bronze); color: var(--bronze); }
body.archive.category main > .section:not(.ds-cat-more):first-of-type, body.archive.category .page-head + .section { padding-top: 48px; }
.ds-cat-more { background: var(--ivory); }
.ds-cat-more__grid { display: grid; grid-template-columns: minmax(0, 1fr) 380px; gap: 48px; align-items: start; }
.ds-cat-more h2 { margin: 6px 0 18px; }
.ds-cat-more .ds-news { margin: 0; } .ds-cat-more .ds-news > h2 { display: none; }
.ds-cat-more .ds-news__grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
.ds-cat-more .ds-rules { margin: 0; }
@media (max-width: 1000px) { .ds-cat__grid, .ds-cat-more__grid { grid-template-columns: 1fr; gap: 28px; } }
@media (max-width: 640px) { .ds-cat-more .ds-news__grid { grid-template-columns: 1fr; } }
</style>';
    return str_replace('</head>', $css . '</head>', $html);
}, 43);

// ===== 22. Trang chủ: dải dịch vụ dưới ảnh bìa, thời tiết cạnh bản đồ, khối Tin mới · Quy định · Liên hệ =====
add_filter('dst_html', function ($html) {
    if (!preg_match('#<body class="[^"]*\bhome\b#', $html) || strpos($html, 'ds-home-svc') !== false) {
        return $html;
    }
    $lang = dst_lang();
    $T = [
        'vi' => ['Dịch vụ DanangStay', 'Một người địa phương lo trọn chuyến đi', 'Phòng, vé máy bay, vé tham quan, xe và tour — nhắn một lần, báo giá trong ngày.', 'Thời tiết 7 ngày tới', 'Cập nhật', 'Tin mới & quy định cần biết', 'Xem tất cả tin'],
        'ko' => ['DanangStay 서비스', '현지인이 여행 전체를 챙겨 드립니다', '숙소, 항공권, 입장권, 차량·투어 — 한 번 문의로 당일 견적.', '7일 날씨', '업데이트', '최신 소식 & 꼭 알아야 할 규정', '모든 소식 보기'],
    ];
    $t = $T[$lang] ?? ['DanangStay services', 'A local who takes care of the whole trip', 'Rooms, flights, attraction tickets, cars and tours — one message, same-day quote.', '7-day weather', 'Updates', 'Latest news & rules to know', 'All news'];
    $q = function ($s) {
        return str_replace(['\\', '$'], ['\\\\', '\\$'], $s);
    };
    // 1) dải dịch vụ sau ảnh bìa
    $svc = '<section class="section ds-home-svc"><div class="wrap"><div class="ds-home-svc__head"><div><span class="kicker">' . esc_html($t[0]) . '</span><h2>' . esc_html($t[1]) . '</h2></div><p>' . esc_html($t[2]) . '</p></div>'
        . do_shortcode('[ds_dich_vu]') . '</div></section>';
    $html = preg_replace('#(<section class="hero">.*?</section>)#s', '$1' . $q($svc), $html, 1);
    // 2) thời tiết dưới phần chữ cạnh bản đồ
    $html = preg_replace('#(<div class="map-section__text[^"]*">.*?)(</div>\s*<div class="reveal"><figure class="map")#s', '$1<div class="ds-home-w"><b class="ds-side-h">' . $q(esc_html($t[3])) . '</b><div class="ds-weather"></div></div>$2', $html, 1);
    // 3) khối tin mới + quy định + liên hệ trước trích dẫn
    $term = get_term_by('slug', 'news-' . $lang, 'category') ?: get_term_by('slug', 'news', 'category');
    $all = $term ? get_term_link($term) : '';
    $upd = '<section class="section ds-home-upd"><div class="wrap"><div class="ds-home-svc__head"><div><span class="kicker">' . esc_html($t[4]) . '</span><h2>' . esc_html($t[5]) . '</h2></div>'
        . ($all && !is_wp_error($all) ? '<a class="link-arrow" href="' . esc_url($all) . '">' . esc_html($t[6]) . ' →</a>' : '') . '</div>'
        . '<div class="ds-home-upd__grid"><div>' . do_shortcode('[ds_tin_moi so="5"]') . '</div><div>' . do_shortcode('[ds_quy_dinh]') . '</div><div>' . do_shortcode('[ds_lien_he]') . '</div></div></div></section>';
    $html = preg_replace('#(<section class="section quote">)#', $q($upd) . '$1', $html, 1);
    $css = '<style id="dst-home-css">
.ds-home-svc { padding: 64px 0 !important; background: #fff; }
.ds-home-svc__head { display: flex; justify-content: space-between; align-items: end; gap: 32px; margin-bottom: 24px; }
.ds-home-svc__head h2 { margin: 6px 0 0; }
.ds-home-svc__head p { max-width: 440px; margin: 0; color: var(--ink-2); font-size: 16.5px; line-height: 1.6; }
.ds-home-svc .ds-services { margin: 0; }
.ds-home-w { margin-top: 28px; }
.ds-home-w .ds-weather { margin: 0; padding: 14px; }
.ds-home-w .ds-weather__head { display: none; }
.ds-home-w .ds-weather__days { grid-template-columns: repeat(4, minmax(0, 1fr)) !important; }
.ds-home-w .ds-weather__day:nth-child(n+5) { display: none; }
.ds-side-h { display: block; font: 700 12px/1 var(--sans); letter-spacing: .12em; text-transform: uppercase; color: var(--bronze); margin-bottom: 10px; }
.ds-home-upd { background: var(--ivory); padding: 72px 0 !important; }
.ds-home-upd__grid { display: grid; grid-template-columns: minmax(0, 1.3fr) minmax(0, 1fr) minmax(0, .9fr); gap: 24px; align-items: start; }
.ds-home-upd .ds-news { margin: 0; } .ds-home-upd .ds-news > h2 { display: none; }
.ds-home-upd .ds-news__grid { grid-template-columns: 1fr; gap: 10px; }
.ds-home-upd .ds-news__item { padding: 14px 16px; }
.ds-home-upd .ds-news__ex { display: none; }
.ds-home-upd .ds-rules, .ds-home-upd .ds-contact { margin: 0; }
.ds-home-upd .ds-rules ul { max-height: 420px; overflow: auto; }
body.home .section.quote { padding: 64px 0 !important; }
body.home .map-section { align-items: center; }
@media (max-width: 1100px) { .ds-home-upd__grid { grid-template-columns: 1fr 1fr; } .ds-home-upd__grid > :first-child { grid-column: 1 / -1; } }
@media (max-width: 700px) { .ds-home-svc__head { flex-direction: column; align-items: start; } .ds-home-upd__grid, .ds-home-upd .ds-news__grid { grid-template-columns: 1fr; } }
</style>';
    return str_replace('</head>', $css . '</head>', $html);
}, 44);

// ===== 23. Trang chủ: mục "Sắp diễn ra" (lấy từ trang Sự kiện, lưu đệm 6 giờ) =====
function dst_upcoming_events($lang, $n = 4)
{
    $key = "dst_ev2_" . $lang;
    $list = get_transient($key);
    if ($list === false) {
        $list = [];
        $url = trailingslashit(dst_lang_home()) . 'events/';
        $r = wp_remote_get($url, ['timeout' => 15, 'headers' => ['User-Agent' => 'DanangStay-internal']]);
        $body = is_wp_error($r) ? '' : (string) wp_remote_retrieve_body($r);
        $cut = strpos($body, 'ev-h--past');
        if ($cut !== false) {
            $body = substr($body, 0, $cut);
        }
        if (preg_match_all('#<article class="ev" data-city="([a-z]*)">(.*?)</article>#s', $body, $m, PREG_SET_ORDER)) {
            foreach ($m as $e) {
                $g = function ($re) use ($e) {
                    return preg_match($re, $e[2], $x) ? trim(html_entity_decode(wp_strip_all_tags($x[1]))) : '';
                };
                $list[] = [
                    'city' => $e[1],
                    'day' => $g('#<div class="ev__date"><b>([^<]*)</b>#'),
                    'mon' => $g('#<div class="ev__date"><b>[^<]*</b><span>([^<]*)</span>#'),
                    'cityname' => $g('#<span class="ev__city[^"]*">([^<]*)</span>#'),
                    'when' => $g('#</span>([^<]*)</p>#'),
                    'title' => $g('#<h3>(.*?)</h3>#s'),
                    'desc' => $g('#<p class="ev__desc">(.*?)</p>#s'),
                    'venue' => $g('#<p class="ev__venue">(?:<svg.*?</svg>)?(.*?)</p>#s'),
                ];
                if (count($list) >= 8) {
                    break;
                }
            }
        }
        set_transient($key, $list, $list ? 6 * HOUR_IN_SECONDS : 15 * MINUTE_IN_SECONDS);
    }
    return array_slice($list, 0, $n);
}

add_filter('dst_html', function ($html) {
    if (!preg_match('#<body class="[^"]*\bhome\b#', $html) || strpos($html, 'ds-home-ev') !== false) {
        return $html;
    }
    $lang = dst_lang();
    $ev = dst_upcoming_events($lang, 4);
    if (!$ev) {
        return $html;
    }
    $T = ['vi' => ['Lịch sự kiện', 'Sắp diễn ra ở miền Trung', 'Xem lịch đầy đủ', 'Hỏi phòng gần đây'], 'ko' => ['행사 일정', '곧 열리는 중부 행사', '전체 일정 보기', '근처 숙소 문의']];
    $t = $T[$lang] ?? ['Events', 'Coming up in Central Vietnam', 'Full calendar', 'Ask for a room nearby'];
    $home = trailingslashit(dst_lang_home());
    $out = '<section class="section ds-home-ev"><div class="wrap"><div class="ds-home-svc__head"><div><span class="kicker">' . esc_html($t[0]) . '</span><h2>' . esc_html($t[1]) . '</h2></div><a class="link-arrow" href="' . esc_url($home . 'events/') . '">' . esc_html($t[2]) . ' →</a></div><div class="ds-home-ev__grid">';
    foreach ($ev as $e) {
        $out .= '<a class="ds-hev ds-hev--' . esc_attr($e['city']) . '" href="' . esc_url($home . 'events/') . '"><div class="ds-hev__date"><b>' . esc_html($e['day']) . '</b><span>' . esc_html($e['mon']) . '</span></div>'
            . '<div class="ds-hev__body"><span class="ds-hev__city">' . esc_html($e['cityname']) . '</span>'
            . ($e['when'] ? '<small>' . esc_html($e['when']) . '</small>' : '')
            . '<strong>' . esc_html($e['title']) . '</strong>'
            . ($e['desc'] ? '<p>' . esc_html(wp_trim_words($e['desc'], 18)) . '</p>' : '')
            . ($e['venue'] ? '<em>📍 ' . esc_html($e['venue']) . '</em>' : '') . '</div></a>';
    }
    $out .= '</div><p class="ds-home-ev__cta"><a class="ds-btn ds-btn--call" href="' . esc_url($home . 'stays/') . '">🏨 ' . esc_html($t[3]) . '</a><a class="ds-btn ds-btn--zalo" href="https://zalo.me/0909669325" target="_blank" rel="noopener">Zalo 0909 669 325</a></p></div></section>';
    $q = str_replace(['\\', '$'], ['\\\\', '\\$'], $out);
    $html = preg_replace('#(<section class="section ds-home-upd">)#', $q . '$1', $html, 1, $c);
    if (!$c) {
        $html = preg_replace('#(<section class="section quote">)#', $q . '$1', $html, 1);
    }
    $css = '<style id="dst-hev-css">
.ds-home-ev { background: #fff; padding: 72px 0 !important; }
.ds-home-ev__grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 16px; }
.ds-hev { display: flex; gap: 14px; padding: 18px; border: 1px solid var(--line); border-radius: 16px; background: #fff; text-decoration: none !important; color: var(--ink) !important; transition: transform .2s, box-shadow .2s, border-color .2s; border-top: 4px solid var(--sea); }
.ds-hev--hoian { border-top-color: #b5651d; } .ds-hev--hue { border-top-color: #7a4fa3; } .ds-hev--danang { border-top-color: var(--sea); }
.ds-hev:hover { transform: translateY(-3px); box-shadow: 0 18px 34px -24px rgba(11,36,71,.5); border-color: var(--bronze); }
.ds-hev__date { flex: none; width: 56px; text-align: center; }
.ds-hev__date b { display: block; font: 600 34px/1 var(--serif); color: var(--ink); }
.ds-hev__date span { font-size: 12px; letter-spacing: .08em; text-transform: uppercase; color: var(--muted, #6b7280); }
.ds-hev__body { display: flex; flex-direction: column; gap: 4px; min-width: 0; font-family: var(--sans); }
.ds-hev__city { align-self: start; font: 700 11px/1 var(--sans); letter-spacing: .08em; text-transform: uppercase; color: #fff; background: var(--sea); border-radius: 999px; padding: 4px 9px; }
.ds-hev--hoian .ds-hev__city { background: #b5651d; } .ds-hev--hue .ds-hev__city { background: #7a4fa3; }
.ds-hev__body small { font-size: 12.5px; color: var(--muted, #6b7280); }
.ds-hev__body strong { font: 600 17px/1.3 var(--serif); }
.ds-hev__body p { margin: 0; font-size: 13.5px; line-height: 1.5; color: var(--ink-2); }
.ds-hev__body em { font-style: normal; font-size: 12.5px; color: var(--muted, #6b7280); }
.ds-home-ev__cta { display: flex; flex-wrap: wrap; gap: 10px; margin: 20px 0 0; }
@media (max-width: 1100px) { .ds-home-ev__grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (max-width: 640px) { .ds-home-ev__grid { grid-template-columns: 1fr; } }
</style>';
    return str_replace('</head>', $css . '</head>', $html);
}, 45);

// ===== 24. Trang ko/ja/zh/ru/fr/de: dịch các chuỗi theme chỉ có tiếng Anh (sự kiện, chỗ ở, số liệu, thành phố) =====
add_filter('dst_html', function ($html) {
    $l = dst_lang();
    $file = __DIR__ . '/i18n/' . $l . '.php';
    if (!in_array($l, ['ko', 'ja', 'zh', 'ru', 'fr', 'de'], true) || !file_exists($file)) {
        return $html;
    }
    static $map = null;
    if ($map === null) {
        $map = include $file;
        $extra = __DIR__ . '/i18n/' . $l . '.extra.json';
        if (file_exists($extra)) {
            $j = json_decode((string) file_get_contents($extra), true);
            if (is_array($j)) {
                $map = array_merge($j, $map);
            }
        }
    }
    $parts = preg_split('#(<(?:script|style)\b.*?</(?:script|style)>)#s', $html, -1, PREG_SPLIT_DELIM_CAPTURE);
    foreach ($parts as $i => $part) {
        if ($i % 2) {
            continue;
        }
        $parts[$i] = preg_replace_callback('#>([^<>]{2,})<#u', function ($m) use ($map) {
            $raw = $m[1];
            $txt = trim(html_entity_decode($raw, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            if ($txt === '' || !isset($map[$txt])) {
                return $m[0];
            }
            $lead = preg_match('#^\s+#', $raw, $x) ? $x[0] : '';
            $tail = preg_match('#\s+$#', $raw, $y) ? $y[0] : '';
            return '>' . $lead . esc_html($map[$txt]) . $tail . '<';
        }, $part);
    }
    $html = implode('', $parts);
    // thuộc tính placeholder / aria-label / title
    return preg_replace_callback('#\b(placeholder|aria-label|title)="([^"]{2,})"#u', function ($m) use ($map) {
        $txt = html_entity_decode($m[2], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        return isset($map[$txt]) ? $m[1] . '="' . esc_attr($map[$txt]) . '"' : $m[0];
    }, $html);
}, 999);

// ===== 25. Ảnh minh họa trong bài: <figure class="ds-fig"> =====
add_action('wp_head', function () {
    echo '<style id="dst-fig-css">
.prose figure.ds-fig, .entry-content figure.ds-fig { margin: 2em 0 !important; width: 100% !important; max-width: 100% !important; left: auto !important; transform: none !important; }
figure.ds-fig img { display: block; width: 100% !important; height: auto !important; aspect-ratio: 3 / 2; object-fit: cover; border-radius: 14px; box-shadow: 0 18px 40px -28px rgba(11,36,71,.55); background: var(--ivory); }
figure.ds-fig figcaption { margin-top: 10px; font: 400 14px/1.5 var(--sans); color: var(--muted, #6b7280); text-align: left; padding-left: 12px; border-left: 3px solid var(--bronze); }
</style>';
}, 107);

// ===== 26. Ảnh chia sẻ mạng xã hội (og:image / twitter:image) = ảnh đại diện của bài =====
add_filter('dst_html', function ($html) {
    if (!is_singular('post')) {
        return $html;
    }
    $id = get_queried_object_id();
    $src = has_post_thumbnail($id) ? get_the_post_thumbnail_url($id, 'full') : '';
    if (!$src) {
        return $html;
    }
    $u = esc_url($src);
    $html = preg_replace('#<meta property="og:image" content="[^"]*"\s*/?>#', '<meta property="og:image" content="' . $u . '">', $html, -1, $n);
    if (!$n) {
        $html = str_replace('</head>', '<meta property="og:image" content="' . $u . '">' . "\n</head>", $html);
    }
    $html = preg_replace('#<meta name="twitter:image" content="[^"]*"\s*/?>#', '<meta name="twitter:image" content="' . $u . '">', $html, -1, $m);
    if (!$m) {
        $html = str_replace('</head>', '<meta name="twitter:image" content="' . $u . '">' . "\n</head>", $html);
    }
    return $html;
}, 55);

// ===== 27. Logo mới (chữ D đầu rồng) + favicon =====
add_filter('dst_html', function ($html) {
    $a = plugins_url('assets/', __FILE__);
    $img = '<img class="ds-logo" src="' . $a . 'logo-360.webp" srcset="' . $a . 'logo-360.webp 360w, ' . $a . 'logo-720.webp 720w" sizes="(max-width:600px) 150px, 200px" width="360" height="168" alt="DanangStay – Đà Nẵng · Hội An · Huế">';
    $html = preg_replace('#(<a class="brand"[^>]*>)\s*<svg viewBox="0 0 40 40".*?</svg>\s*<span class="brand__word"[^>]*>.*?</span>#s', '$1' . $img, $html);
    $icons = '<link rel="icon" href="' . $a . 'icon-32.png" sizes="32x32" type="image/png">'
        . '<link rel="icon" href="' . $a . 'icon-192.png" sizes="192x192" type="image/png">'
        . '<link rel="apple-touch-icon" href="' . $a . 'icon-180.png">';
    $html = preg_replace('#<link rel="icon"[^>]*>#', '', $html);
    $html = preg_replace('#<link rel="apple-touch-icon"[^>]*>#', '', $html);
    $html = str_replace('</head>', $icons . "\n</head>", $html);
    return $html;
}, 60);
add_action('wp_head', function () {
    echo '<style id="dst-logo-css">
.brand img.ds-logo{display:block;height:66px;width:auto;max-width:none}
footer .brand img.ds-logo,.site-footer .brand img.ds-logo{height:84px}
@media (max-width:600px){.brand img.ds-logo{height:44px}}
</style>';
}, 108);

// ===== 28. Trang Facebook: chân trang, hộp liên hệ, cuối bài, schema sameAs =====
if (!defined('DST_FB')) {
    define('DST_FB', 'https://www.facebook.com/profile.php?id=61596640483357');
}
function dst_fb_label() {
    $l = function_exists('pll_current_language') ? pll_current_language() : 'en';
    $m = ['vi' => ['Theo dõi DanangStay trên Facebook', 'Tin du lịch, sự kiện và ưu đãi Đà Nẵng – Hội An – Huế mỗi ngày.', 'Theo dõi'],
          'ko' => ['페이스북에서 DanangStay 팔로우', '다낭·호이안·후에 여행 소식, 이벤트, 특가를 매일 전해 드려요.', '팔로우'],
          'ja' => ['FacebookでDanangStayをフォロー', 'ダナン・ホイアン・フエの旅行ニュースやイベントを毎日お届け。', 'フォロー'],
          'zh' => ['在 Facebook 关注 DanangStay', '每天分享岘港、会安、顺化的旅游资讯与活动。', '关注'],
          'ru' => ['Подписывайтесь на DanangStay в Facebook', 'Новости, события и предложения Дананга, Хойана и Хюэ каждый день.', 'Подписаться'],
          'fr' => ['Suivez DanangStay sur Facebook', 'Actus, événements et bons plans à Da Nang, Hoi An et Hué chaque jour.', 'Suivre'],
          'de' => ['Folgen Sie DanangStay auf Facebook', 'Täglich Reise-News, Events und Angebote aus Da Nang, Hoi An und Hue.', 'Folgen'],
          'en' => ['Follow DanangStay on Facebook', 'Daily travel news, events and deals from Da Nang, Hoi An and Hue.', 'Follow']];
    return $m[$l] ?? $m['en'];
}
add_filter('the_content', function ($c) {
    if (!is_singular('post') || !in_the_loop() || !is_main_query()) {
        return $c;
    }
    $t = dst_fb_label();
    return $c . '<div class="ds-fbfollow" translate="no"><span class="ds-fbfollow__ic" aria-hidden="true">f</span><div><strong>' . esc_html($t[0]) . '</strong><br><span>' . esc_html($t[1]) . '</span></div><a class="ds-btn ds-btn--fb" href="' . DST_FB . '" target="_blank" rel="noopener">' . esc_html($t[2]) . '</a></div>';
}, 30);
add_filter('dst_html', function ($html) {
    $fb = DST_FB;
    // chân trang: thêm dòng Facebook vào cột Liên hệ + nút dưới đoạn giới thiệu
    $html = preg_replace('#(<div class="footer-top">.*)(</ul>\s*</div>\s*</div>\s*<div class="footer-bottom">)#s', '$1<li><a href="' . $fb . '" target="_blank" rel="noopener">Facebook · DanangStay</a></li>$2', $html, 1);
    $html = preg_replace('#(<div class="footer-top">\s*<div>\s*<a class="brand".*?</a>\s*<p>.*?</p>)#s', '$1<p class="ds-social"><a class="ds-social__fb" href="' . $fb . '" target="_blank" rel="noopener" aria-label="Facebook"><svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><path fill="currentColor" d="M13.5 21v-7.5h2.5l.4-3h-2.9V8.6c0-.9.3-1.5 1.5-1.5h1.5V4.4c-.3 0-1.2-.1-2.2-.1-2.2 0-3.7 1.3-3.7 3.8v2.4H8v3h2.6V21h2.9z"/></svg> Facebook</a></p>', $html, 1);
    // schema: sameAs + logo mới
    $html = str_replace('"@id":"https://danangstay.com.vn/#organization",', '"@id":"https://danangstay.com.vn/#organization","sameAs":["' . str_replace('/', '\/', $fb) . '"],', $html);
    $html = str_replace('https://danangstay.com.vn/wp-content/themes/danangstay-v3/assets/img/logo.png', plugins_url('assets/logo-720.png', __FILE__), $html);
    return $html;
}, 61);
add_action('wp_head', function () {
    echo '<style id="dst-fb-css">
.ds-btn--fb{background:#1877f2}
.ds-social{margin-top:14px!important}
.ds-social__fb{display:inline-flex;align-items:center;gap:8px;padding:9px 14px;border-radius:999px;background:#1877f2;color:#fff!important;font:600 14px/1 var(--sans);text-decoration:none!important}
.ds-fbfollow{display:flex;align-items:center;gap:16px;margin:2em 0;padding:18px 20px;border-radius:12px;background:#eef4ff;border:1px solid #d6e4ff;font-family:var(--sans);text-align:left}
.ds-fbfollow strong{color:#0b2447;font-size:17px}.ds-fbfollow span{color:#41557a;font-size:14px;line-height:1.5}
.ds-fbfollow__ic{flex:none;width:44px;height:44px;border-radius:50%;background:#1877f2;color:#fff!important;font:700 26px/44px Arial,sans-serif!important;text-align:center}
.ds-fbfollow .ds-btn{margin-left:auto;flex:none}
@media (max-width:600px){.ds-fbfollow{flex-wrap:wrap}.ds-fbfollow .ds-btn{margin-left:0}}
</style>';
}, 109);
