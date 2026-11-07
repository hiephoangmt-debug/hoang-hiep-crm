<?php
/**
 * Trang dự án kiểu landing tự động – cùng bố cục, cùng CSS với trang The Poet (assets/css/landing-mau.css),
 * nội dung lấy từ dữ liệu dự án. Mục nào chưa có dữ liệu thì không hiện.
 * Tắt cho một dự án: Dự án → sửa → "Giao diện trang" = "Chuẩn của web" hoặc "Cũ".
 */

defined( 'ABSPATH' ) || exit;

$id     = get_the_ID();
$title  = get_the_title();
$m      = static fn( $k ) => trim( (string) hh_meta( $k, $id ) );
$e      = static fn( $s ) => esc_html( (string) $s );
$url    = static fn( $img, $size = 'large' ) => (string) wp_get_attachment_image_url( $img, $size );
$alt    = static function ( $img ) use ( $title ) {
	$a = trim( (string) get_post_meta( $img, '_wp_attachment_image_alt', true ) );
	return '' !== $a ? $a : ( trim( (string) get_the_title( $img ) ) ?: $title );
};
$cap    = static function ( $img ) use ( $alt ) {
	$c = trim( (string) wp_get_attachment_caption( $img ) );
	$t = trim( (string) get_the_title( $img ) );
	if ( '' !== $c ) {
		return $c;
	}
	return ( '' !== $t && ! preg_match( '/^[\w\-]+$/u', $t ) ) ? $t : $alt( $img );
};
// Đoạn đầu của một ô (trước dấu ; hoặc ( ), gọn cho thẻ thông tin.
$short  = static function ( $s, $max = 70 ) {
	$s = trim( (string) $s );
	if ( mb_strlen( $s ) > $max ) {
		$s = trim( preg_split( '/\s*[;(]\s*|\.\s/u', $s )[0] );
	}
	return mb_strlen( $s ) > $max + 20 ? mb_substr( $s, 0, $max ) . '…' : $s;
};
$card   = static function ( $img, $label = '', $big = false ) use ( $url, $alt, $e ) {
	$full = $url( $img, 'full' );
	if ( ! $full ) {
		return '';
	}
	return sprintf(
		'<a class="card-img" href="%s"><img src="%s" alt="%s" loading="lazy" decoding="async">%s</a>',
		esc_url( $full ),
		esc_url( $url( $img, $big ? 'large' : 'medium_large' ) ?: $full ),
		esc_attr( $alt( $img ) ),
		'' !== $label ? '<span>' . $e( $label ) . '</span>' : ''
	);
};
$phone  = '0904 567 009';
$zalo   = 'https://zalo.me/0904567009';
$resale = function_exists( 'hh_project_is_resale' ) && hh_project_is_resale( $id );
$status = hh_option_label( hh_project_schema(), 'hh_p_status', $m( 'hh_p_status' ) );

// Tên: phần cuối in nghiêng vàng như mẫu ("The Poet <em>Residence</em>").
$name_html = static function ( $t ) use ( $e ) {
	if ( preg_match( '/^(.+?)\s+(Đà Nẵng|Quảng Nam|Hội An)$/u', $t, $x ) ) {
		return $e( $x[1] ) . ' <em>' . $e( $x[2] ) . '</em>';
	}
	$w = preg_split( '/\s+/u', $t );
	if ( count( $w ) < 2 ) {
		return $e( $t );
	}
	$last = array_pop( $w );
	return $e( implode( ' ', $w ) ) . ' <em>' . $e( $last ) . '</em>';
};
$short_name = trim( preg_replace( '/\s+(Đà Nẵng|Quảng Nam|Hội An)$/u', '', preg_replace( '/\s*\([^)]*\)/u', '', $title ) ) );

// Ảnh.
$hero      = (int) get_post_thumbnail_id();
$gallery   = hh_ids( 'hh_p_gallery' );
$img_text  = static fn( $img ) => get_the_title( $img ) . ' ' . get_post_meta( $img, '_wp_attachment_image_alt', true );
$interior  = array_values( array_filter( $gallery, static fn( $img ) => (bool) preg_match( '/căn (hộ )?mẫu|nội thất|sample|showroom/iu', $img_text( $img ) ) ) );
$gallery   = array_values( array_diff( $gallery, $interior, array( $hero ) ) );
$floors    = hh_ids( 'hh_p_floorplans' );
$amen_plan = array_values( array_filter( $floors, static fn( $img ) => (bool) preg_match( '/tiện ích/iu', get_the_title( $img ) ) ) );
$floors    = array_values( array_diff( $floors, $amen_plan ) );
$amen_img  = hh_ids( 'hh_p_amenities_img' );
$master    = hh_ids( 'hh_p_masterplan_img' );
$layouts   = hh_ids( 'hh_p_unit_layouts' );
$progress  = hh_ids( 'hh_p_progress_gallery' );
// Lưới ảnh luôn đủ hàng (không để 1 ảnh lẻ một hàng): cắt về bội số của số cột khi nhiều hơn 1 hàng.
$full_rows = static fn( $ids, $cols, $max ) => array_slice( $ids, 0, count( $ids ) <= $cols ? count( $ids ) : min( $max, count( $ids ) - count( $ids ) % $cols ) );
$loc_img   = hh_ids( 'hh_p_location_img' );
$side_img  = $gallery[0] ?? ( $amen_img[0] ?? 0 );
$over_img  = $gallery[1] ?? ( $gallery[0] ?? ( $master[0] ?? 0 ) );

// Dữ liệu.
$stats     = function_exists( 'hh_project_key_stats' ) ? hh_project_key_stats( $id, 4 )[0] : array();
$amen_in   = hh_lines( 'hh_p_amenities_in' );
$nearby    = hh_project_nearby( $id )[0];
$conn      = hh_project_connections( $id )[0];
$products  = hh_project_products( $id );
$unit_rows = hh_table( 'hh_p_unit_types', 4 );
$price_tbl = hh_table( 'hh_p_price_table', 4 );
$payment   = hh_table( 'hh_p_payment', 3 );
$policy    = hh_lines( 'hh_p_policy' );
$timeline  = hh_project_timeline( $id );
$faq       = hh_project_faq( $id );
$news      = function_exists( 'hh_project_news' ) ? array_slice( (array) hh_project_news( $id, 3 ), 0, 3 ) : array();
$zones     = hh_table( 'hh_p_zones', 4 );
$highl     = hh_lines( 'hh_p_highlights' );
$excerpt   = trim( wp_strip_all_tags( get_the_excerpt() ) );
$content   = trim( (string) get_post_field( 'post_content', $id ) );

// Tổ hợp: dự án mẹ, các dự án con, các dự án cùng tổ hợp – liên kết qua lại.
$parent   = (int) $m( 'hh_p_parent' );
$parent   = $parent && 'publish' === get_post_status( $parent ) ? $parent : 0;
$group_id = $parent ?: $id;
$kids     = get_posts( array( 'post_type' => 'du-an', 'post_status' => 'publish', 'numberposts' => 30, 'meta_key' => 'hh_p_parent', 'meta_value' => $group_id, 'orderby' => 'menu_order title', 'order' => 'ASC' ) );
$family   = $kids ? array_merge( array( get_post( $group_id ) ), $kids ) : array(); // Luôn có thẻ dự án tổng thể (kể cả khi đang xem chính nó) để bố cục cân đối.

// Chữ ngắn.
$sub = $excerpt ?: ( $m( 'hh_p_location_desc' ) ?: '' );
if ( mb_strlen( $sub ) > 300 ) {
	$sub = mb_substr( $sub, 0, mb_strrpos( mb_substr( $sub, 0, 300 ), ' ' ) ) . '…';
}
if ( count( $stats ) < 4 ) {
	foreach ( array( array( 'hh_p_units', 'Quy mô' ), array( 'hh_p_unit_area', 'Diện tích' ), array( 'hh_p_handover', 'Bàn giao' ), array( 'hh_p_ownership', 'Sở hữu' ) ) as list( $k, $lb ) ) {
		if ( count( $stats ) >= 4 ) {
			break;
		}
		if ( $m( $k ) && ! in_array( $lb, wp_list_pluck( $stats, 1 ), true ) ) {
			$stats[] = array( $short( $m( $k ), 22 ), $lb );
		}
	}
}
$facts = array_filter(
	array(
		'Chủ đầu tư'   => wp_strip_all_tags( $m( 'hh_p_developer' ) ),
		'Vị trí'       => $m( 'hh_p_address' ),
		'Loại hình'    => $m( 'hh_p_type' ),
		'Quy mô'       => $m( 'hh_p_scale' ),
		'Sản phẩm'     => $m( 'hh_p_units' ) ?: $m( 'hh_p_unit_area' ),
		'Diện tích'    => $m( 'hh_p_units' ) ? $m( 'hh_p_unit_area' ) : '',
		'Pháp lý'      => $m( 'hh_p_ownership' ) ?: $m( 'hh_p_legal' ),
		'Bàn giao'     => $m( 'hh_p_handover' ),
		'Tổng thầu'    => $m( 'hh_p_builder' ),
		'Thiết kế'     => $m( 'hh_p_designer' ),
		'Vận hành'     => $m( 'hh_p_manager' ),
		'Mật độ'       => $m( 'hh_p_density' ),
		'Giá chuyển nhượng' => $resale ? $m( 'hh_p_resale_price' ) : '',
		'Giá thuê'     => $resale ? $m( 'hh_p_rent_price' ) : '',
		'Tình trạng'   => $status,
	)
);
$facts = array_slice( $facts, 0, 8, true );

// Liên kết vùng → nhóm theo thời gian như mẫu (5 phút, 10 phút…).
$times = array();
foreach ( $conn as list( $t, $place ) ) {
	$t = trim( $t );
	if ( '' === $t || '' === trim( $place ) ) {
		continue;
	}
	$times[ $t ][] = $place;
}
uksort( $times, static fn( $a, $b ) => ( (float) preg_replace( '/[^\d.]/', '', str_replace( ',', '.', $a ) ) ) <=> ( (float) preg_replace( '/[^\d.]/', '', str_replace( ',', '.', $b ) ) ) );
$times = array_slice( $times, 0, 4, true );

// Bản đồ.
// Bản đồ – giống giao diện chuẩn: tọa độ → "tên / địa chỉ trên Google Maps" → tìm theo TÊN dự án (Google nhận diện tốt hơn địa chỉ dài
// kiểu "phường … (cũ)"); tòa / phân khu con chưa có vị trí riêng thì dùng vị trí dự án mẹ.
$map_name = static function ( $t ) {
	$t = trim( preg_replace( '/^Tổ hợp\s+|\s*\([^)]*\)/u', '', html_entity_decode( (string) $t, ENT_QUOTES, 'UTF-8' ) ) );
	return false === mb_stripos( $t, 'Đà Nẵng' ) ? $t . ', Đà Nẵng' : $t;
};
$coords = hh_parse_coords( $m( 'hh_p_map_coords' ) );
$mq     = $m( 'hh_p_map_address' );
if ( ! $coords && '' === $mq && $parent ) {
	$coords = hh_parse_coords( hh_meta( 'hh_p_map_coords', $parent ) );
	$mq     = hh_meta( 'hh_p_map_address', $parent ) ?: ( $coords ? '' : $map_name( get_the_title( $parent ) ) );
}
$mq = $coords ? $coords[0] . ',' . $coords[1] : ( '' !== $mq ? $mq : $map_name( $title ) );

// Loại căn: thẻ căn từ bảng loại căn + ảnh layout.
$units = array();
foreach ( $unit_rows as $i => $r ) {
	$units[] = array( 'img' => $layouts[ $i ] ?? 0, 'name' => $r[0], 'area' => $r[1], 'bed' => $r[2], 'price' => $r[3] );
}
foreach ( array_slice( $layouts, count( $unit_rows ) ) as $img ) {
	$units[] = array( 'img' => $img, 'name' => $cap( $img ), 'area' => '', 'bed' => '', 'price' => '' );
}
$other_products = array_filter( $products, static fn( $p, $k ) => 'can-ho' !== $k && $p['rows'], ARRAY_FILTER_USE_BOTH );

// Mục lục.
$nav = array_filter(
	array(
		'tong-quan'  => 'Tổng quan',
		'to-hop'     => $family ? 'Tổ hợp' : '',
		'vi-tri'     => 'Vị trí',
		'tien-ich'   => ( $amen_in || $amen_img || $amen_plan ) ? 'Tiện ích' : '',
		'xem-4d'     => ( $m( 'hh_p_tour_4d' ) || $m( 'hh_p_tour_360' ) ) ? 'Xem 4D' : '',
		'mat-bang'   => ( $master || $floors ) ? 'Mặt bằng' : '',
		'loai-can'   => ( $units || $other_products ) ? 'Loại căn' : '',
		'noi-that'   => $interior ? 'Nội thất' : '',
		'bang-gia'   => ( $price_tbl || $m( 'hh_p_price_from' ) || $m( 'hh_p_resale_price' ) ) ? 'Giá' : '',
		'thanh-toan' => ( $payment || $policy || $m( 'hh_p_loan' ) ) ? 'Thanh toán' : '',
		'phap-ly'    => ( $m( 'hh_p_legal' ) || $m( 'hh_p_ownership' ) || $timeline[0] ) ? 'Pháp lý' : '',
		'thu-vien'   => count( $gallery ) > 1 ? 'Hình ảnh' : '',
		'hoi-dap'    => $faq ? 'Hỏi đáp' : '',
	)
);
if ( $parent && isset( $nav['to-hop'] ) ) {
	unset( $nav['to-hop'] );
	$nav['to-hop'] = 'Cùng tổ hợp';
}
$brand_top = $short_name;
$brand_sub = trim( preg_replace( '/^.*?,\s*/u', '', (string) $m( 'hh_p_address' ) ) ) ?: 'Đà Nẵng';
if ( mb_strlen( $brand_sub ) > 34 ) {
	$brand_sub = 'Đà Nẵng';
}
$form_opts = $unit_rows ? wp_list_pluck( $unit_rows, 0 ) : array_values( wp_list_pluck( $products, 'label' ) );
?>
<header class="top">
  <div class="container">
    <a class="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Về trang chủ Hoàng Hiệp" title="Về trang chủ"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 11l9-7 9 7"/><path d="M5 10v10h5v-6h4v6h5V10"/></svg></a>
    <a class="brand" href="#top"><b><?php echo $e( mb_strtoupper( mb_strlen( $brand_top ) > 22 ? implode( ' ', array_slice( preg_split( '/\s+/u', $brand_top ), 0, 3 ) ) : $brand_top ) ); ?></b><small><?php echo $e( $brand_sub ); ?></small></a>
    <nav class="nav" aria-label="Mục lục">
      <?php foreach ( $nav as $k => $lb ) : ?><a href="#<?php echo esc_attr( $k ); ?>"><?php echo $e( $lb ); ?></a><?php endforeach; ?>
      <a class="nav-out" href="<?php echo esc_url( home_url( '/' ) ); ?>">← Trang chủ</a><a class="nav-out" href="<?php echo esc_url( home_url( '/du-an/' ) ); ?>">Tất cả dự án</a>
    </nav>
    <a class="btn btn-gold" href="#dang-ky"><?php echo $resale ? 'Nhận danh sách căn' : 'Nhận bảng giá'; ?></a>
  </div>
</header>

<main id="top">
<?php if ( $hero ) : ?>
<!-- HERO -->
<figure class="hero-view" style="--bg:url('<?php echo esc_url( $url( $hero, 'medium' ) ?: $url( $hero, 'full' ) ); ?>')">
  <img src="<?php echo esc_url( $url( $hero, 'full' ) ); ?>" alt="<?php echo esc_attr( $alt( $hero ) ); ?>" fetchpriority="high" decoding="async">
  <figcaption><?php echo $e( $cap( $hero ) ); ?></figcaption>
</figure>
<?php endif; ?>
<section class="hero" aria-labelledby="h1">
  <div class="container">
    <div>
      <?php if ( $status || '1' === $m( 'hh_p_sold_out' ) ) : ?><span class="badge-ok">✔ <?php echo $e( '1' === $m( 'hh_p_sold_out' ) ? 'Đã bán hết từ chủ đầu tư' : $status . ( $m( 'hh_p_handover' ) ? ' · bàn giao ' . hh_lcfirst( $short( $m( 'hh_p_handover' ), 30 ) ) : '' ) ); ?></span><?php endif; ?>
      <?php if ( $parent ) : ?><p style="margin:10px 0 0"><a href="<?php echo esc_url( get_permalink( $parent ) ); ?>" style="color:var(--gold2);font-weight:600;text-decoration:none">Thuộc tổ hợp <?php echo $e( get_the_title( $parent ) ); ?> →</a></p><?php endif; ?>
      <h1 id="h1"><?php echo $name_html( $title ); // phpcs:ignore WordPress.Security.EscapeOutput -- đã escape. ?></h1>
      <?php if ( $sub ) : ?><p class="sub"><?php echo $e( $sub ); ?></p><?php endif; ?>
      <?php if ( $stats ) : ?>
      <div class="chips">
        <?php foreach ( $stats as list( $num, $lb ) ) : ?><div class="chip"><b><?php echo $e( $num ); ?></b><span><?php echo $e( $lb ); ?></span></div><?php endforeach; ?>
      </div>
      <?php endif; ?>
      <div class="acts">
        <a class="btn btn-gold" href="#dang-ky"><?php echo $resale ? 'Nhận danh sách căn đang bán' : 'Nhận bảng giá & căn trống'; ?></a>
        <a class="btn btn-ghost js-zalo" href="<?php echo esc_url( $zalo ); ?>" target="_blank" rel="noopener">Zalo <?php echo $e( $phone ); ?></a>
      </div>
    </div>
    <?php if ( $side_img ) : ?>
    <figure class="hero-img" style="margin:0">
      <img src="<?php echo esc_url( $url( $side_img, 'large' ) ); ?>" alt="<?php echo esc_attr( $alt( $side_img ) ); ?>" decoding="async">
      <figcaption><?php echo $e( $cap( $side_img ) ); ?></figcaption>
    </figure>
    <?php endif; ?>
  </div>
</section>

<!-- TỔNG QUAN -->
<section id="tong-quan" aria-labelledby="h-tq">
  <div class="container">
    <div class="split">
      <div class="rv">
        <span class="eyebrow">Tổng quan dự án</span>
        <h2 class="title" id="h-tq">Tổng quan <em><?php echo $e( $short_name ); ?></em></h2>
        <?php if ( $m( 'hh_p_design_desc' ) || $excerpt ) : ?><p class="lead"><?php echo $e( $short( $m( 'hh_p_design_desc' ) ?: $excerpt, 520 ) ); ?></p><?php endif; ?>
        <?php if ( $highl ) : ?><ul class="list-ok" style="grid-template-columns:1fr;margin-top:14px"><?php foreach ( array_slice( $highl, 0, 5 ) as $h ) : ?><li><?php echo $e( $h ); ?></li><?php endforeach; ?></ul><?php endif; ?>
      </div>
      <?php if ( $over_img ) : ?><img class="rv" src="<?php echo esc_url( $url( $over_img, 'large' ) ); ?>" alt="<?php echo esc_attr( $alt( $over_img ) ); ?>" loading="lazy" decoding="async"><?php endif; ?>
    </div>
    <?php if ( $facts ) : ?>
    <div class="facts rv">
      <?php foreach ( $facts as $lb => $v ) : ?><div class="fact"><small><?php echo $e( $lb ); ?></small><b><?php
      $cdt = 'Chủ đầu tư' === $lb && function_exists( 'hh_cdt_match' ) ? hh_cdt_match( $v ) : array();
      echo $cdt ? '<a href="' . esc_url( hh_cdt_url( $cdt[0] ) ) . '">' . $e( $short( $v ) ) . '</a>' : $e( $short( $v ) ); // phpcs:ignore -- Tên chủ đầu tư có hồ sơ → link sang trang chủ đầu tư.
      ?></b></div><?php endforeach; ?>
    </div>
    <?php endif; ?>
    <?php if ( $zones ) : ?>
    <div class="tbl-wrap"><table class="tbl"><thead><tr><th>Phân khu</th><th>Loại sản phẩm</th><th>Quy mô</th><th>Tình trạng</th></tr></thead><tbody>
      <?php foreach ( $zones as $r ) : ?><tr><?php foreach ( $r as $c ) : ?><td><?php echo $e( $c ); ?></td><?php endforeach; ?></tr><?php endforeach; ?>
    </tbody></table></div>
    <?php endif; ?>
  </div>
</section>

<?php
// Tổ hợp: trang tổng thể hiện ngay sau Tổng quan; trang dự án con dời xuống cuối trang để khách không bị kéo sang khu khác.
$family_html = '';
if ( $family ) :
	ob_start();
	?>
<!-- TỔ HỢP -->
<section id="to-hop" style="background:#fff" aria-labelledby="h-th">
  <div class="container">
    <span class="eyebrow"><?php echo $parent ? 'Xem thêm' : 'Tổ hợp dự án'; ?></span>
    <h2 class="title" id="h-th"><?php echo $parent ? 'Các dự án khác cùng tổ hợp <em>' . $e( get_the_title( $parent ) ) . '</em>' : 'Các dự án trong <em>' . $e( $short_name ) . '</em>'; // phpcs:ignore ?></h2>
    <?php $fn = count( $family ); $fcls = 2 === $fn ? ' kids--2' : ( 0 === $fn % 4 ? ' kids--4' : ( 0 === $fn % 3 || $fn > 4 ? ' kids--3' : ' kids--' . $fn ) ); ?>
    <div class="kids<?php echo esc_attr( $fcls ); ?>">
      <?php foreach ( $family as $p ) : ?>
        <?php $is_cur = (int) $p->ID === $id; $is_par = (int) $p->ID === $parent; ?>
        <a class="kid<?php echo $is_cur ? ' cur' : ''; ?>" href="<?php echo esc_url( get_permalink( $p ) ); ?>"<?php echo $is_cur ? ' aria-current="page"' : ''; ?>>
          <?php if ( has_post_thumbnail( $p ) ) : ?><img src="<?php echo esc_url( (string) get_the_post_thumbnail_url( $p, 'medium_large' ) ); ?>" alt="<?php echo esc_attr( get_the_title( $p ) ); ?>" loading="lazy" decoding="async"><?php
	$family_html = ob_get_clean();
endif;
if ( ! $parent ) {
	echo $family_html; // phpcs:ignore WordPress.Security.EscapeOutput -- đã escape khi dựng.
}
?>
          <div><small><?php echo $is_cur ? 'Đang xem' : ( $is_par ? 'Tổng thể dự án' : $e( $short( hh_meta( 'hh_p_type', $p->ID ) ?: 'Dự án thành phần', 40 ) ) ); ?></small><b><?php echo $e( get_the_title( $p ) ); ?></b><?php if ( hh_meta( 'hh_p_price_from', $p->ID ) ) : ?><span><?php echo $e( hh_project_price( $p->ID ) ); ?> (tham khảo)</span><?php elseif ( hh_meta( 'hh_p_address', $p->ID ) ) : ?><span><?php echo $e( $short( hh_meta( 'hh_p_address', $p->ID ), 60 ) ); ?></span><?php endif; ?><?php if ( ! $is_cur ) : ?><em class="kid-go">Xem dự án →</em><?php endif; ?></div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- VỊ TRÍ -->
<section class="dark" id="vi-tri" aria-labelledby="h-vt">
  <div class="container">
    <span class="eyebrow">Vị trí</span>
    <h2 class="title" id="h-vt">Vị trí <em><?php echo $e( $short_name ); ?></em></h2>
    <?php if ( $m( 'hh_p_location_desc' ) ) : ?><p class="lead"><?php echo nl2br( $e( $m( 'hh_p_location_desc' ) ) ); // phpcs:ignore ?></p><?php elseif ( $m( 'hh_p_address' ) ) : ?><p class="lead"><?php echo $e( $m( 'hh_p_address' ) ); ?></p><?php endif; ?>
    <?php if ( $times ) : ?>
    <div class="times rv">
      <?php foreach ( $times as $t => $places ) : ?>
        <?php $tn = preg_match( '/^([\d,.\s–-]+)\s*(.*)$/u', $t, $x ) ? array( trim( $x[1] ), trim( $x[2] ) ) : array( $t, '' ); ?>
        <div class="time"><b><?php echo $e( $tn[0] ); ?> <small><?php echo $e( $tn[1] ); ?></small></b><ul><?php foreach ( array_slice( $places, 0, 5 ) as $pl ) : ?><li><?php echo $e( $pl ); ?></li><?php endforeach; ?></ul></div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <?php $vb = array_slice( $loc_img, 0, 2 ); // Mặt bằng tổng thể đã có ở mục Mặt bằng – không lặp. ?>
    <?php if ( $vb ) : ?>
    <div class="vband rv"<?php echo 1 === count( $vb ) ? ' style="grid-template-columns:1fr"' : ''; ?>>
      <?php foreach ( $vb as $img ) { echo $card( $img, $cap( $img ), true ); } // phpcs:ignore ?>
    </div>
    <?php endif; ?>
    <div class="locmap rv">
      <iframe title="<?php echo esc_attr( 'Bản đồ vị trí ' . $title ); ?>" src="<?php echo esc_url( 'https://www.google.com/maps?q=' . rawurlencode( $mq ) . '&z=' . ( $coords ? 16 : 15 ) . '&output=embed' ); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
      <div class="adj">
        <h3><?php echo $e( $m( 'hh_p_address' ) ? $short( $m( 'hh_p_address' ), 60 ) : $short_name ); ?></h3>
        <?php if ( $nearby ) : ?><ul><?php foreach ( array_slice( $nearby, 0, 6 ) as $n ) : ?><li><?php echo $e( $n ); ?></li><?php endforeach; ?></ul><?php endif; ?>
        <a href="<?php echo esc_url( 'https://www.google.com/maps/dir/?api=1&destination=' . rawurlencode( $mq ) ); ?>" target="_blank" rel="noopener">📍 Chỉ đường tới dự án ↗</a>
      </div>
    </div>
  </div>
</section>

<?php if ( isset( $nav['tien-ich'] ) ) : ?>
<!-- TIỆN ÍCH -->
<section id="tien-ich" aria-labelledby="h-ti">
  <div class="container">
    <span class="eyebrow">Tiện ích</span>
    <h2 class="title" id="h-ti">Tiện ích <em><?php echo $e( $short_name ); ?></em></h2>
    <?php if ( $amen_plan ) : ?>
      <?php if ( count( $amen_plan ) > 1 ) : ?>
      <div class="tabs" role="tablist">
        <?php foreach ( $amen_plan as $i => $img ) : ?><button class="tab<?php echo 0 === $i ? ' on' : ''; ?>" type="button" data-floor="ti-<?php echo (int) $i; ?>"><?php echo $e( trim( preg_replace( '/^mặt bằng\s*(tiện ích)?\s*/iu', '', $cap( $img ) ) ) ?: 'Mặt bằng ' . ( $i + 1 ) ); ?></button><?php endforeach; ?>
      </div>
      <?php endif; ?>
      <?php foreach ( $amen_plan as $i => $img ) : ?>
      <div class="floor<?php echo 0 === $i ? ' on' : ''; ?>" id="ti-<?php echo (int) $i; ?>"<?php echo count( $amen_plan ) < 2 ? ' style="margin-top:22px"' : ''; ?>>
        <a class="plan" href="<?php echo esc_url( $url( $img, 'full' ) ); ?>"><img src="<?php echo esc_url( $url( $img, 'large' ) ); ?>" alt="<?php echo esc_attr( $alt( $img ) ); ?>" loading="lazy" decoding="async"></a>
        <p class="plan-cap"><?php echo $e( $cap( $img ) ); ?> · bấm để phóng to.</p>
      </div>
      <?php endforeach; ?>
    <?php endif; ?>
    <?php if ( $amen_img ) : ?>
    <div class="grid3" style="margin-top:22px<?php echo count( $amen_img ) < 3 ? ';grid-template-columns:repeat(' . count( $amen_img ) . ',1fr)' : ''; ?>">
      <?php foreach ( $full_rows( $amen_img, 3, 9 ) as $i => $img ) { echo $card( $img, wp_get_attachment_caption( $img ) ?: ( $amen_in[ $i ] ?? $cap( $img ) ) ); } // phpcs:ignore ?>
    </div>
    <?php endif; ?>
    <?php if ( $amen_in ) : ?>
    <ul class="list-ok rv" style="margin-top:24px"><?php foreach ( $amen_in as $a ) : ?><li><?php echo $e( $a ); ?></li><?php endforeach; ?></ul>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<?php if ( isset( $nav['xem-4d'] ) ) : ?>
<!-- XEM 4D / 360 -->
<section class="dark" id="xem-4d" aria-labelledby="h-4d">
  <div class="container">
    <span class="eyebrow">Tham quan trực tuyến</span>
    <h2 class="title" id="h-4d">Xem <em><?php echo $e( $short_name ); ?></em> như đang đứng tại dự án</h2>
    <div class="tours">
      <?php foreach ( array( array( 'hh_p_tour_4d', 'hh_p_tour_poster', 'Xem mô hình 4D' ), array( 'hh_p_tour_360', 'hh_p_tour_360_poster', 'Xem 360°' ) ) as list( $k, $pk, $lb ) ) : ?>
        <?php
        if ( ! $m( $k ) ) {
			continue;
        }
        $poster = $m( $pk );
        $poster = 0 === strpos( $poster, 'plugin:' ) && defined( 'HH_CRM_URL' ) ? HH_CRM_URL . substr( $poster, 7 ) : ( ctype_digit( $poster ) ? $url( (int) $poster, 'large' ) : $poster );
        $poster = $poster ?: ( $hero ? $url( $hero, 'large' ) : '' );
        ?>
        <a class="tour" href="<?php echo esc_url( $m( $k ) ); ?>" target="_blank" rel="noopener" data-tour="<?php echo esc_url( $m( $k ) ); ?>" data-title="<?php echo esc_attr( $lb . ' ' . $short_name ); ?>"><?php if ( $poster ) : ?><img src="<?php echo esc_url( $poster ); ?>" alt="<?php echo esc_attr( $lb . ' ' . $title ); ?>" loading="lazy" decoding="async"><?php endif; ?><span>▶ <?php echo $e( $lb ); ?></span></a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if ( isset( $nav['mat-bang'] ) ) : ?>
<!-- MẶT BẰNG -->
<section id="mat-bang" style="background:#fff" aria-labelledby="h-mb">
  <div class="container">
    <span class="eyebrow">Mặt bằng</span>
    <h2 class="title" id="h-mb">Mặt bằng <em><?php echo $e( $short_name ); ?></em></h2>
    <?php $mp = array_slice( $master, 0, 2 ); // Tổng mặt bằng: khung gọn, 2 ảnh xếp cạnh nhau trên máy tính, bấm để phóng to. ?>
    <?php if ( $mp ) : ?><div class="mp-grid mp-<?php echo count( $mp ); ?>">
    <?php foreach ( $mp as $img ) : ?>
      <figure><a class="plan plan-mp" href="<?php echo esc_url( $url( $img, 'full' ) ); ?>"><img src="<?php echo esc_url( $url( $img, 'large' ) ); ?>" alt="<?php echo esc_attr( $alt( $img ) ); ?>" loading="lazy" decoding="async"><span class="zoom">🔍 Phóng to</span></a>
      <figcaption class="plan-cap"><?php echo $e( $cap( $img ) ); ?></figcaption></figure>
    <?php endforeach; ?>
    </div><?php endif; ?>
    <?php if ( $floors ) : ?>
      <?php
      // Chia theo tòa: "… tòa S1 …" / "S1 · Tầng 3"; ảnh không ghi tòa thuộc tòa của ảnh liền trước. Nhãn gọn: "Tầng 17, 19, 21".
      $names = array_unique( array_filter( array( $title, $short_name, trim( preg_replace( '/^Tổ hợp\s+/u', '', $title ) ), $parent ? get_the_title( $parent ) : '' ) ) );
      $fl    = array();
      $prev  = '';
      foreach ( $floors as $i => $img ) {
          $t   = $cap( $img );
          $toa = preg_match( '/\b(?:tòa|toà|tháp|block|khối)\s+([A-Za-z]{0,3}\d{0,2}[A-Za-z]?)\b/iu', $t, $x ) && '' !== $x[1] ? mb_strtoupper( $x[1] ) : ( preg_match( '/^([A-Z]{1,2}\d{1,2})\s*[·–—-]\s/u', $t, $x ) ? $x[1] : $prev );
          $lb  = $t;
          foreach ( $names as $n ) {
              $lb = str_ireplace( $n, '', $lb );
          }
          $lb  = preg_replace( array( '/\b(?:tòa|toà|tháp|block|khối)\s+[A-Za-z]{0,3}\d{0,2}[A-Za-z]?\b/iu', '/^[A-Z]{1,2}\d{1,2}\s*[·–—-]\s*/u', '/^\s*mặt bằng\s*/iu', '/\s*\(.*?\)\s*/u' ), ' ', $lb );
          $lb  = preg_replace( '/\s*,\s*(?=[^\d\s])\D.*$/u', '', $lb ); // Bỏ phần mô tả sau số tầng: "Tầng 3, mặt sông Hàn" → "Tầng 3".
          $lb  = preg_replace( '/\s+,/u', ',', $lb );
          $lb  = trim( preg_replace( '/\s{2,}/u', ' ', $lb ), " \t·–—-,.:" );
          $lb  = '' === $lb ? 'Mặt bằng ' . ( $i + 1 ) : mb_strtoupper( mb_substr( $lb, 0, 1 ) ) . mb_substr( $lb, 1 );
          $n   = mb_strtolower( $lb );
          $rk  = false !== mb_strpos( $n, 'sơ đồ' ) || false !== mb_strpos( $n, 'tổng' ) ? -5 : ( false !== mb_strpos( $n, 'hầm' ) ? -1 : ( preg_match( '/(\d+)/', $n, $d ) ? (int) $d[1] : 900 ) );
          $rk += false !== mb_strpos( $n, 'penthouse' ) ? 500 : ( false !== mb_strpos( $n, 'mái' ) ? 800 : 0 );
          $fl[] = array( 'img' => $img, 'toa' => $toa, 'lb' => $lb, 'rk' => $rk, 'i' => $i );
          $prev = $toa;
      }
      $toas = array_values( array_unique( array_filter( wp_list_pluck( $fl, 'toa' ) ) ) );
      if ( count( $toas ) < 2 ) {
          $toas = array();
      } else {
          natsort( $toas );
          $toas = array_values( $toas );
          foreach ( $fl as &$f ) {
              $f['toa'] = $f['toa'] ?: $toas[0];
          }
          unset( $f );
      }
      usort( $fl, static fn( $a, $b ) => array( $toas ? array_search( $a['toa'], $toas, true ) : 0, $a['rk'], $a['i'] ) <=> array( $toas ? array_search( $b['toa'], $toas, true ) : 0, $b['rk'], $b['i'] ) );
      $first = $fl[0];
      ?>
      <?php if ( $toas ) : ?>
      <div class="tabs tabs-toa" role="tablist" aria-label="Chọn tòa">
        <?php foreach ( $toas as $t ) : ?><button class="tab-toa<?php echo $t === $first['toa'] ? ' on' : ''; ?>" type="button" data-toa="<?php echo esc_attr( $t ); ?>">Tòa <?php echo $e( $t ); ?> <small><?php echo (int) count( array_filter( $fl, static fn( $f ) => $f['toa'] === $t ) ); ?> mặt bằng</small></button><?php endforeach; ?>
      </div>
      <?php endif; ?>
      <?php if ( count( $fl ) > 1 ) : ?>
      <div class="tabs" role="tablist">
        <?php foreach ( $fl as $f ) : ?><button class="tab<?php echo $f === $first ? ' on' : ''; ?>" type="button" data-floor="mb-<?php echo (int) $f['i']; ?>"<?php echo $toas ? ' data-toa="' . esc_attr( $f['toa'] ) . '"' . ( $f['toa'] !== $first['toa'] ? ' hidden' : '' ) : ''; ?>><?php echo $e( $short( $f['lb'], 30 ) ); ?></button><?php endforeach; ?>
      </div>
      <?php endif; ?>
      <?php foreach ( $fl as $f ) : ?>
      <div class="floor<?php echo $f === $first ? ' on' : ''; ?>" id="mb-<?php echo (int) $f['i']; ?>">
        <a class="plan" href="<?php echo esc_url( $url( $f['img'], 'full' ) ); ?>"><img src="<?php echo esc_url( $url( $f['img'], 'large' ) ); ?>" alt="<?php echo esc_attr( $alt( $f['img'] ) ); ?>" loading="lazy" decoding="async"></a>
        <p class="plan-cap"><?php echo $e( ( $f['toa'] ? 'Tòa ' . $f['toa'] . ' · ' : '' ) . $f['lb'] ); ?> · bấm để phóng to.</p>
      </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<?php if ( isset( $nav['loai-can'] ) ) : ?>
<!-- LOẠI CĂN -->
<section id="loai-can" aria-labelledby="h-lc">
  <div class="container">
    <span class="eyebrow">Loại sản phẩm</span>
    <h2 class="title" id="h-lc">Các loại sản phẩm <em><?php echo $e( $short_name ); ?></em></h2>
    <?php if ( $m( 'hh_p_unit_area' ) ) : ?><p class="lead"><?php echo $e( $m( 'hh_p_unit_area' ) ); ?>. Bấm vào ảnh để xem mặt bằng lớn.</p><?php endif; ?>
    <?php if ( $units ) : ?>
    <div class="units"<?php echo 4 === count( $units ) ? ' style="grid-template-columns:repeat(2,1fr)"' : ( count( $units ) < 3 ? ' style="grid-template-columns:repeat(' . count( $units ) . ',minmax(0,420px))"' : '' ); ?>>
      <?php foreach ( $units as $u ) : ?>
      <article class="unit rv">
        <?php if ( $u['img'] ) : ?><a class="pic" href="<?php echo esc_url( $url( $u['img'], 'full' ) ); ?>"><img src="<?php echo esc_url( $url( $u['img'], 'medium_large' ) ?: $url( $u['img'], 'full' ) ); ?>" alt="<?php echo esc_attr( $alt( $u['img'] ) ); ?>" loading="lazy" decoding="async"></a><?php endif; ?>
        <div class="body">
          <h3><?php echo $e( $u['name'] . ( $u['area'] ? ' · ' . $u['area'] : '' ) ); ?></h3>
          <?php if ( $u['bed'] ) : ?><div class="meta"><span><?php echo $e( is_numeric( $u['bed'] ) ? $u['bed'] . ' phòng ngủ' : $u['bed'] ); ?></span></div><?php endif; ?>
          <?php if ( $u['price'] ) : ?><div class="price"><?php echo $e( $u['price'] ); ?></div><?php endif; ?>
          <a class="btn btn-navy" href="#dang-ky" data-type="<?php echo esc_attr( $u['name'] ); ?>">Nhận giá căn này</a>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <?php foreach ( $other_products as $p ) : ?>
      <h3 style="font-family:'Playfair Display',serif;font-size:24px;margin:28px 0 0"><?php echo $e( $p['label'] ); ?></h3>
      <?php if ( $p['desc'] ) : ?><p class="note" style="font-size:15px"><?php echo $e( $p['desc'] ); ?></p><?php endif; ?>
      <div class="tbl-wrap"><table class="tbl"><thead><tr><?php foreach ( $p['cols'] as $c ) : ?><th><?php echo $e( $c ); ?></th><?php endforeach; ?></tr></thead><tbody>
        <?php foreach ( $p['rows'] as $r ) : ?><tr><?php foreach ( $r as $c ) : ?><td><?php echo $e( $c ); ?></td><?php endforeach; ?></tr><?php endforeach; ?>
      </tbody></table></div>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<?php if ( $interior ) : ?>
<!-- NỘI THẤT CĂN MẪU -->
<section id="noi-that" style="background:#fff" aria-labelledby="h-nt">
  <div class="container">
    <span class="eyebrow">Nội thất căn mẫu</span>
    <h2 class="title" id="h-nt">Căn hộ mẫu <em><?php echo $e( $short_name ); ?></em></h2>
    <p class="lead">Phối cảnh nội thất căn hộ mẫu của chủ đầu tư. Bàn giao thực tế theo tiêu chuẩn của từng loại căn; đồ rời, trang trí trong ảnh chỉ để minh họa.</p>
    <div class="interior">
      <?php foreach ( array_slice( $interior, 0, 9 ) as $i => $img ) { echo $card( $img, $cap( $img ), 0 === $i ); } // phpcs:ignore ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if ( isset( $nav['bang-gia'] ) ) : ?>
<!-- BẢNG GIÁ -->
<section id="bang-gia" aria-labelledby="h-bg">
  <div class="container">
    <span class="eyebrow"><?php echo $resale ? 'Giá chuyển nhượng' : 'Giá bán tham khảo'; ?></span>
    <h2 class="title" id="h-bg"><?php echo $resale ? 'Giá chuyển nhượng <em>' . $e( $short( $m( 'hh_p_resale_price' ) ?: 'theo từng căn', 40 ) ) . '</em>' : ( $m( 'hh_p_price_from' ) ? 'Giá <em>' . $e( mb_strtolower( hh_project_price( $id ) ) ) . '</em>' . ( $m( 'hh_p_price_m2' ) ? ', khoảng ' . $e( $m( 'hh_p_price_m2' ) ) : '' ) : 'Bảng giá <em>' . $e( $short_name ) . '</em>' ); // phpcs:ignore ?></h2>
    <?php if ( $price_tbl ) : ?>
    <?php
    // Ghi chú giống nhau ở mọi dòng → ghi một lần dưới bảng, giá là cột cuối (nổi bật).
    $pt_notes = array_values( array_unique( array_map( static fn( $r ) => trim( (string) ( $r[3] ?? '' ) ), $price_tbl ) ) );
    $pt_one   = 1 === count( $pt_notes ) ? $pt_notes[0] : null;
    ?>
    <div class="tbl-wrap"><table class="tbl">
      <thead><tr><th>Sản phẩm</th><th>Diện tích</th><th>Giá tham khảo</th><?php if ( null === $pt_one ) : ?><th>Ghi chú</th><?php endif; ?></tr></thead>
      <tbody><?php foreach ( $price_tbl as $r ) : ?><tr><td><?php echo $e( $r[0] ?? '' ); ?></td><td class="num"><?php echo $e( $r[1] ?? '' ); ?></td><td class="num gia"><?php echo $e( $r[2] ?? '' ); ?></td><?php if ( null === $pt_one ) : ?><td class="ghi-chu"><?php echo $e( $r[3] ?? '' ); ?></td><?php endif; ?></tr><?php endforeach; ?></tbody>
    </table></div>
    <?php if ( $pt_one ) : ?><p class="note"><?php echo $e( $pt_one ); ?>.</p><?php endif; ?>
    <?php endif; ?>
    <p class="note">Giá tham khảo, chưa trừ chiết khấu; giá và căn còn trống thay đổi theo đợt – để lại số, Hoàng Hiệp gửi bảng giá cập nhật qua Zalo.</p>
  </div>
</section>
<?php endif; ?>

<?php if ( isset( $nav['thanh-toan'] ) ) : ?>
<!-- THANH TOÁN -->
<section id="thanh-toan" style="background:#fff" aria-labelledby="h-tt">
  <div class="container">
    <span class="eyebrow">Chính sách & thanh toán</span>
    <h2 class="title" id="h-tt">Chính sách bán hàng <em><?php echo $e( $short_name ); ?></em></h2>
    <?php if ( $policy ) : ?><ul class="list-ok rv" style="margin-top:20px"><?php foreach ( $policy as $p ) : ?><li><?php echo $e( $p ); ?></li><?php endforeach; ?></ul><?php endif; ?>
    <?php if ( $payment ) : ?>
    <div class="tbl-wrap"><table class="tbl">
      <thead><tr><th>Đợt</th><th>Thời điểm</th><th>Tỷ lệ</th></tr></thead>
      <tbody><?php foreach ( $payment as $r ) : ?><tr><?php foreach ( $r as $c ) : ?><td><?php echo $e( $c ); ?></td><?php endforeach; ?></tr><?php endforeach; ?></tbody>
    </table></div>
    <?php endif; ?>
    <?php
    $loan = array_filter(
		array(
			$m( 'hh_p_loan_ratio' ) ? array( $m( 'hh_p_loan_ratio' ) . ( is_numeric( $m( 'hh_p_loan_ratio' ) ) ? '%' : '' ), 'tỷ lệ vay tối đa' ) : null,
			$m( 'hh_p_loan_zero_months' ) ? array( $m( 'hh_p_loan_zero_months' ) . ' tháng', 'hỗ trợ lãi suất 0%' ) : null,
			$m( 'hh_p_loan_grace' ) ? array( $m( 'hh_p_loan_grace' ) . ( is_numeric( $m( 'hh_p_loan_grace' ) ) ? ' tháng' : '' ), 'ân hạn nợ gốc' ) : null,
			$m( 'hh_p_loan_bank' ) ? array( $short( $m( 'hh_p_loan_bank' ), 24 ), 'ngân hàng cho vay' ) : null,
		)
    );
    ?>
    <?php if ( count( $loan ) >= 2 ) : ?>
    <div class="loan rv"><?php foreach ( $loan as list( $b, $s ) ) : ?><div><b><?php echo $e( $b ); ?></b><span><?php echo $e( $s ); ?></span></div><?php endforeach; ?></div>
    <?php elseif ( $m( 'hh_p_loan' ) ) : ?>
    <div class="std"><b>Hỗ trợ vay ngân hàng</b><br><?php echo nl2br( $e( $m( 'hh_p_loan' ) ) ); // phpcs:ignore ?></div>
    <?php endif; ?>
    <p class="note">Theo chính sách bán hàng chủ đầu tư gần nhất; chính sách thay đổi theo đợt – liên hệ để nhận chính sách đang áp dụng.</p>
  </div>
</section>
<?php endif; ?>

<?php if ( isset( $nav['phap-ly'] ) ) : ?>
<!-- PHÁP LÝ -->
<section id="phap-ly" aria-labelledby="h-pl">
  <div class="container">
    <div class="split" style="align-items:start">
      <div>
        <span class="eyebrow">Pháp lý & tiến độ</span>
        <h2 class="title" id="h-pl">Pháp lý <em><?php echo $e( $short_name ); ?></em></h2>
        <?php if ( $m( 'hh_p_legal' ) || $m( 'hh_p_ownership' ) ) : ?>
        <div class="legal-box rv"><?php if ( $m( 'hh_p_ownership' ) ) : ?><b><?php echo $e( $m( 'hh_p_ownership' ) ); ?></b><br><?php endif; ?><?php echo $e( $m( 'hh_p_legal' ) ); ?></div>
        <?php endif; ?>
        <?php if ( $m( 'hh_p_handover_std' ) ) : ?><div class="std"><b>Tiêu chuẩn bàn giao</b><br><?php echo $e( $m( 'hh_p_handover_std' ) ); ?></div><?php endif; ?>
        <p class="note">Bản sao văn bản pháp lý: nhắn Zalo <?php echo $e( $phone ); ?> để nhận.</p>
        <?php if ( $progress && count( $progress ) < 3 ) : ?>
        <div class="vband rv" style="margin-top:18px;grid-template-columns:<?php echo 1 === count( $progress ) ? '1fr' : '1fr 1fr'; ?>"><?php foreach ( $progress as $img ) { echo $card( $img, $cap( $img ), true ); } // phpcs:ignore ?></div>
        <?php endif; ?>
      </div>
      <?php if ( $timeline[0] ) : ?>
      <ol class="timeline rv">
        <?php $last = count( $timeline[0] ) - 1; foreach ( $timeline[0] as $i => list( $t, $txt ) ) : ?>
          <li<?php echo $i < $last || preg_match( '/^đã/iu', $txt ) ? ' class="ok"' : ''; ?>><b><?php echo $e( $t ); ?></b><span><?php echo $e( $txt ); ?></span></li>
        <?php endforeach; ?>
      </ol>
      <?php endif; ?>
    </div>
    <?php if ( count( $progress ) >= 3 ) : ?>
    <div class="grid3" style="margin-top:26px"><?php foreach ( $full_rows( $progress, 3, 6 ) as $img ) { echo $card( $img, $cap( $img ) ); } // phpcs:ignore ?></div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<?php if ( isset( $nav['thu-vien'] ) ) : ?>
<!-- THƯ VIỆN -->
<section id="thu-vien" style="background:#fff" aria-labelledby="h-tv">
  <div class="container">
    <span class="eyebrow">Thư viện ảnh</span>
    <h2 class="title" id="h-tv"><?php echo $e( $short_name ); ?> <em>qua hình ảnh</em></h2>
    <?php $gn = count( $gallery ) >= 9 ? 9 : ( count( $gallery ) >= 5 ? 5 : count( $gallery ) ); ?>
    <div class="gallery">
      <?php foreach ( array_slice( $gallery, 0, $gn ) as $i => $img ) { echo $card( $img, '', 0 === $i ); } // phpcs:ignore ?>
    </div>
    <p class="note">Ảnh phối cảnh, minh họa của chủ đầu tư; ảnh thực tế có ghi chú riêng.</p>
  </div>
</section>
<?php endif; ?>

<?php if ( $news ) : ?>
<!-- TIN TỨC -->
<section id="tin-tuc" aria-labelledby="h-tt2">
  <div class="container">
    <span class="eyebrow">Tin tức</span>
    <h2 class="title" id="h-tt2">Tin mới về <em><?php echo $e( $short_name ); ?></em></h2>
    <div class="news">
      <?php foreach ( $news as $nid ) : ?>
        <a class="kid" href="<?php echo esc_url( get_permalink( $nid ) ); ?>">
          <?php if ( has_post_thumbnail( $nid ) ) : ?><img src="<?php echo esc_url( (string) get_the_post_thumbnail_url( $nid, 'medium_large' ) ); ?>" alt="" loading="lazy" decoding="async"><?php endif; ?>
          <div><small><?php echo $e( get_the_date( 'd/m/Y', $nid ) ); ?></small><b style="font-size:17px"><?php echo $e( get_the_title( $nid ) ); ?></b></div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- HỎI ĐÁP -->
<section class="faq" id="hoi-dap" style="background:#fff" aria-labelledby="h-hd">
  <div class="container">
    <span class="eyebrow">Hỏi đáp</span>
    <h2 class="title" id="h-hd">Khách hay hỏi về <em><?php echo $e( $short_name ); ?></em></h2>
    <?php if ( $faq ) : ?>
    <?php $half = (int) ceil( count( $faq ) / 2 ); ?>
    <div class="faq-cols">
      <?php foreach ( array( array_slice( $faq, 0, $half ), array_slice( $faq, $half ) ) as $col ) : ?>
      <div><?php foreach ( $col as list( $q, $a ) ) : ?><details><summary><?php echo $e( $q ); ?></summary><p><?php echo $e( $a ); ?></p></details><?php endforeach; ?></div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <?php if ( '' !== $content ) : ?>
    <details class="intro-more"><summary>Đọc giới thiệu đầy đủ về <?php echo $e( $title ); ?></summary><div class="content"><?php echo apply_filters( 'the_content', $content ); // phpcs:ignore WordPress.Security.EscapeOutput -- nội dung bài viết. ?></div></details>
    <?php endif; ?>
  </div>
</section>

<!-- ĐĂNG KÝ – con số ưu đãi + chính sách đang áp dụng + form (07/11/2026) -->
<?php
$cta_pol = array();
foreach ( $policy as $pl ) {
	$pl = trim( preg_replace( '/^[•\-\*\s]+/u', '', $pl ) );
	if ( '' !== $pl && ! preg_match( '/:\s*$/u', $pl ) && mb_strlen( $pl ) < 140 ) {
		$cta_pol[] = $pl;
	}
}
$cta_pol   = array_slice( $cta_pol, 0, 4 );
$cta_title = $m( 'hh_p_offer_title' );
$cta_get   = $resale ? array( 'Danh sách căn đang bán, giá thật', 'Kiểm tra sổ, định giá căn', 'Hẹn xem nhà trong tuần' ) : array( 'Bảng giá từng căn, từng tầng', 'Phiếu tính giá theo phương án thanh toán', 'Căn đẹp còn trống, chính sách mới nhất' );
?>
<section class="cta cta-offer" id="dang-ky" aria-labelledby="h-cta">
  <?php if ( $hero ) : ?><img class="bg" src="<?php echo esc_url( $url( $hero, 'large' ) ); ?>" alt="" loading="lazy" decoding="async"><?php endif; ?>
  <div class="container">
    <div class="rv">
      <span class="eyebrow cta-tag"><?php echo $resale ? 'Giỏ hàng chuyển nhượng' : 'Ưu đãi đang áp dụng'; ?> · cập nhật <?php echo $e( wp_date( 'm/Y' ) ); ?></span>
      <h2 class="title" id="h-cta"><?php echo $cta_title ? $e( $cta_title ) : ( $resale ? 'Danh sách căn đang bán' : 'Bảng giá &amp; chính sách' ); ?> <em style="color:var(--gold2)"><?php echo $e( $short_name ); ?></em></h2>
      <?php if ( $stats ) : ?>
      <div class="cta-stats"><?php foreach ( $stats as list( $num, $lb ) ) : ?><div><b><?php echo $e( $num ); ?></b><span><?php echo $e( $lb ); ?></span></div><?php endforeach; ?></div>
      <?php endif; ?>
      <?php if ( $cta_pol ) : ?>
      <ul class="cta-pol"><?php foreach ( $cta_pol as $pl ) : ?><li><?php echo $e( $pl ); ?></li><?php endforeach; ?></ul>
      <?php else : ?>
      <ul class="cta-pol">
        <?php if ( $resale ) : ?><li>Căn chuyển nhượng, cho thuê mới nhất kèm giá thật</li><li>Định giá, kiểm tra sổ hồng trước khi giao dịch</li><li>Nhận ký gửi bán, cho thuê căn của bạn</li>
        <?php else : ?><li>Chính sách chiết khấu đang áp dụng của chủ đầu tư</li><li>So sánh phương án: thanh toán sớm, giãn tiến độ, vay ngân hàng</li><li>Mặt bằng, pháp lý dự án; hẹn đi xem dự án, nhà mẫu</li><?php endif; ?>
      </ul>
      <?php endif; ?>
      <div class="advisor"><div class="av">H</div><div><b>Hoàng Hiệp</b><span>Tư vấn bất động sản Đà Nẵng · trực tiếp, không qua tổng đài<br>Zalo/Hotline: <a href="<?php echo esc_url( $zalo ); ?>" target="_blank" rel="noopener" class="js-zalo"><?php echo $e( $phone ); ?></a></span></div></div>
    </div>
    <form class="form-card lead-form rv" data-form="<?php echo esc_attr( ( $resale ? 'Nhận danh sách căn ' : 'Nhận bảng giá ' ) . $short_name ); ?>" aria-labelledby="f-title">
      <span class="form-badge">Miễn phí · gửi qua Zalo trong 15 phút</span>
      <h3 id="f-title"><?php echo $e( ( $resale ? 'Nhận danh sách căn ' : 'Nhận bảng giá ' ) . $short_name ); ?></h3>
      <ul class="form-get"><?php foreach ( $cta_get as $g ) : ?><li><?php echo $e( $g ); ?></li><?php endforeach; ?></ul>
      <div class="field"><label for="f-name">Họ và tên</label><input id="f-name" name="name" placeholder="Họ và tên *" autocomplete="name" required></div>
      <div class="field"><label for="f-phone">Số điện thoại</label><input id="f-phone" name="phone" type="tel" inputmode="tel" placeholder="Số Zalo / điện thoại *" autocomplete="tel" required pattern="[0-9 +.]{9,14}"></div>
      <?php if ( $form_opts ) : ?><div class="field"><label for="f-type">Loại sản phẩm quan tâm</label><select id="f-type" name="type"><option value="">Loại sản phẩm quan tâm</option><?php foreach ( array_unique( $form_opts ) as $o ) : ?><option><?php echo $e( $o ); ?></option><?php endforeach; ?></select></div><?php endif; ?>
      <button class="btn btn-gold" type="submit"><?php echo $resale ? 'Nhận danh sách căn qua Zalo' : 'Nhận bảng giá &amp; chính sách qua Zalo'; ?> →</button>
      <p class="form-safe">Thông tin chỉ dùng để Hoàng Hiệp tư vấn, không chia sẻ cho bên khác.</p>
      <div class="ok-msg" role="status">Cảm ơn anh/chị! Hoàng Hiệp sẽ gửi thông tin qua Zalo sớm nhất.</div>
    </form>
  </div>
</section>
<?php if ( $parent ) { echo $family_html; } // phpcs:ignore WordPress.Security.EscapeOutput -- Dự án con: tổ hợp ở cuối trang. ?>
<?php
// Dòng phụ thanh bám đáy: ưu tiên ưu đãi (chiết khấu, giá từ), viết thành câu tự nhiên.
$bar_num = '';
foreach ( $stats as list( $num, $lb ) ) {
	$l = mb_strtolower( $lb );
	if ( false !== strpos( $l, 'chiết khấu' ) ) {
		$bar_num = 'Chiết khấu đến ' . $num;
		break;
	}
	if ( false !== strpos( $l, 'giá' ) && ! $bar_num ) {
		$bar_num = 'Giá từ ' . preg_replace( '/^từ\s*/iu', '', $num );
	}
}
if ( ! $bar_num && $stats ) {
	$l       = mb_strtolower( $stats[0][1] );
	$bar_num = 'số căn' === $l ? $stats[0][0] . ' căn hộ' : $stats[0][1] . ': ' . $stats[0][0];
}
?>
<a class="stick-cta" href="#dang-ky" hidden><span><b><?php echo $e( $short_name ); ?></b><?php if ( $bar_num ) : ?><small><?php echo $e( $bar_num ); ?></small><?php endif; ?></span><em><?php echo $resale ? 'Nhận danh sách căn' : 'Nhận bảng giá'; ?></em></a>
<script>
// Thanh "Nhận bảng giá" bám đáy màn hình: hiện khi đã cuộn qua phần đầu, ẩn khi khung đăng ký đang hiện.
(function(){var bar=document.querySelector('.stick-cta'),cta=document.getElementById('dang-ky');if(!bar||!cta)return;var inCta=false;
if('IntersectionObserver' in window){new IntersectionObserver(function(es){inCta=es[0].isIntersecting;upd();},{threshold:.15}).observe(cta);}
function upd(){bar.hidden=inCta||window.scrollY<window.innerHeight*0.9;}
addEventListener('scroll',upd,{passive:true});upd();})();
</script>
</main>

<footer class="foot">
  <div class="container"><?php echo $e( $title . ( $m( 'hh_p_address' ) ? ' – ' . $m( 'hh_p_address' ) : '' ) ); ?>. Thông tin, hình ảnh tổng hợp từ tài liệu chủ đầu tư, mang tính tham khảo; giá và chính sách có thể thay đổi. Tư vấn: Hoàng Hiệp – <?php echo $e( $phone ); ?>. <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color:var(--gold2)">← Về trang chủ</a> · <a href="<?php echo esc_url( home_url( '/du-an/' ) ); ?>" style="color:var(--gold2)">Xem các dự án khác</a></div>
</footer>

<div class="float"><a class="zl js-zalo" href="<?php echo esc_url( $zalo ); ?>" target="_blank" rel="noopener" aria-label="Nhắn Zalo">Zalo</a><a class="call" href="tel:0904567009" aria-label="Gọi <?php echo esc_attr( $phone ); ?>">Gọi</a></div>
<div class="lb" id="lb" role="dialog" aria-modal="true" aria-label="Xem ảnh"><button type="button" aria-label="Đóng">×</button><img alt=""></div>
<div class="tv" id="tv" role="dialog" aria-modal="true" aria-label="Tham quan trực tuyến" hidden><div class="tv-bar"><b></b><a href="#" target="_blank" rel="noopener">Mở tab mới ↗</a><button type="button" aria-label="Đóng">×</button></div><iframe title="Tham quan trực tuyến" allow="fullscreen; xr-spatial-tracking; gyroscope; accelerometer; autoplay" allowfullscreen loading="lazy"></iframe></div>
<script>
// Xem 4D / 360 ngay trong trang (khung toàn màn hình), không chuyển sang web khác. Nút Quay lại trên điện thoại cũng đóng khung.
(function(){var tv=document.getElementById('tv');if(!tv)return;var fr=tv.querySelector('iframe'),t=tv.querySelector('b'),ext=tv.querySelector('a'),open=false;
function close(back){if(!open)return;open=false;tv.hidden=true;fr.src='about:blank';document.documentElement.style.overflow='';if(back&&history.state&&history.state.hhTour)history.back();}
document.querySelectorAll('a.tour[data-tour]').forEach(function(a){a.addEventListener('click',function(e){e.preventDefault();t.textContent=a.dataset.title||'';ext.href=a.dataset.tour;fr.src=a.dataset.tour;tv.hidden=false;open=true;document.documentElement.style.overflow='hidden';try{history.pushState({hhTour:1},'');}catch(x){}});});
tv.querySelector('button').addEventListener('click',function(){close(true);});
addEventListener('popstate',function(){close(false);});
addEventListener('keydown',function(e){if('Escape'===e.key)close(true);});})();
</script>

<script>
(function(){
  var io='IntersectionObserver' in window?new IntersectionObserver(function(es){es.forEach(function(e){if(e.isIntersecting){e.target.classList.add('in');io.unobserve(e.target);}});},{rootMargin:'0px 0px -8% 0px'}):null;
  document.querySelectorAll('.rv').forEach(function(el){io?io.observe(el):el.classList.add('in');});
  // Tab theo tầng: mỗi nhóm tab chỉ đổi khung trong cùng mục.
  document.querySelectorAll('.tab').forEach(function(b){b.addEventListener('click',function(){
    var sec=b.closest('section');
    sec.querySelectorAll('.tab').forEach(function(x){x.classList.toggle('on',x===b);});
    sec.querySelectorAll('.floor').forEach(function(f){f.classList.toggle('on',f.id===b.dataset.floor);});
  });});
  // Mặt bằng chia theo tòa: chọn tòa → hiện các tầng của tòa đó, mở tầng đầu tiên.
  document.querySelectorAll('.tab-toa').forEach(function(b){b.addEventListener('click',function(){
    var sec=b.closest('section'),first=null;
    sec.querySelectorAll('.tab-toa').forEach(function(x){x.classList.toggle('on',x===b);});
    sec.querySelectorAll('.tab[data-toa]').forEach(function(t){var on=t.dataset.toa===b.dataset.toa;t.hidden=!on;if(on&&!first)first=t;});
    if(first)first.click();
  });});
  var lb=document.getElementById('lb'),li=lb.querySelector('img');
  document.addEventListener('click',function(e){var a=e.target.closest('a.card-img,a.pic,a.plan');if(!a)return;e.preventDefault();li.src=a.getAttribute('href');li.alt=(a.querySelector('img')||{}).alt||'';lb.classList.add('on');});
  lb.addEventListener('click',function(e){if(e.target!==li){lb.classList.remove('on');}});
  document.addEventListener('keydown',function(e){if(e.key==='Escape')lb.classList.remove('on');});
  document.querySelectorAll('[data-type]').forEach(function(a){a.addEventListener('click',function(){var s=document.getElementById('f-type');if(s){for(var i=0;i<s.options.length;i++){if(s.options[i].text===a.dataset.type){s.selectedIndex=i;}}}});});
  document.querySelectorAll('.lead-form').forEach(function(f){f.addEventListener('submit',function(e){e.preventDefault();if(!f.checkValidity()){f.reportValidity();return;}var m=f.querySelector('.ok-msg');if(m)m.style.display='block';f.querySelector('button[type=submit]').disabled=true;});});
  var links=[].slice.call(document.querySelectorAll('.nav a[href^="#"]'));
  var secs=links.map(function(a){return document.querySelector(a.getAttribute('href'));});
  window.addEventListener('scroll',function(){var y=window.scrollY+120,cur=-1;secs.forEach(function(s,i){if(s&&s.offsetTop<=y)cur=i;});links.forEach(function(a,i){a.classList.toggle('on',i===cur);});},{passive:true});
})();
</script>
