<?php
/**
 * Plugin Name: DanangStay – Tùy chỉnh (màu, menu, SEO)
 * Description: Tông màu theo hiephoangmt.com (navy + cam), sửa thanh menu bị ẩn trên máy tính, sửa SEO (og:locale, hreflang x-default), ẩn tên đăng nhập quản trị.
 * Version: 1.0.0
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

/* Sửa lỗi thanh menu bị ẩn trên máy tính:
   menu con đang ẩn vẫn chiếm chỗ bên phải nên giao diện tưởng menu bị tràn và chuyển sang nút ☰ */
@media (min-width: 1201px) {
  .nav__group:not(:hover):not(:focus-within):not(.is-open) > .nav__sub { display: none; }
  .nav > .nav__group:nth-last-child(-n+2) > .nav__sub { left: auto; right: -18px; }
}
CSS;
}

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
    if (strpos($html, 'hreflang="x-default"') === false) {
        $html = preg_replace_callback(
            '#<link\s+rel="alternate"\s+href="([^"]+)"\s+hreflang="en"\s*/?>#',
            function ($m) {
                return $m[0] . "\n" . '<link rel="alternate" href="' . $m[1] . '" hreflang="x-default" />';
            },
            $html,
            1
        );
    }
    return $html;
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
