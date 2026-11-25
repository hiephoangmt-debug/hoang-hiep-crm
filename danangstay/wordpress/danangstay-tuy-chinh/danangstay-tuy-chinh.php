<?php
/**
 * Plugin Name: DanangStay – Tùy chỉnh (màu, menu, SEO)
 * Description: Tông màu theo hiephoangmt.com (navy + cam), sửa thanh menu bị ẩn trên máy tính, sửa SEO (og:locale, hreflang x-default), Việt hóa chữ còn sót trên bản tiếng Việt, ẩn tên đăng nhập quản trị.
 * Version: 1.0.4
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
