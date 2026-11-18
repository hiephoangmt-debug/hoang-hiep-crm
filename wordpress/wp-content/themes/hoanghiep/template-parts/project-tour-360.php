<?php
/**
 * Trang dự án: tham quan 360° (tour của chủ đầu tư) nhúng ngay trong trang – không hiện nút / link sang trang khác.
 * Dữ liệu: ô "Link tour 360°" (hh_p_tour_360) và ảnh xem trước "hh_p_tour_360_poster" (plugin:img/… hoặc link ảnh).
 * Tour chỉ tải khi khách bấm (trang nhẹ).
 */

defined( 'ABSPATH' ) || exit;

$src = (string) hh_meta( 'hh_p_tour_360' );
if ( '' === $src ) {
	return;
}
$title  = get_the_title();
$poster = (string) hh_meta( 'hh_p_tour_360_poster' );
if ( 0 === strpos( $poster, 'plugin:' ) ) {
	$poster = defined( 'HH_CRM_URL' ) && defined( 'HH_CRM_DIR' ) && is_file( HH_CRM_DIR . substr( $poster, 7 ) ) ? HH_CRM_URL . substr( $poster, 7 ) : '';
}
if ( '' === $poster ) {
	$poster = (string) get_the_post_thumbnail_url( null, 'large' ); // Chưa có ảnh xem trước riêng: dùng ảnh đại diện dự án.
}
$tours = array( array( $src, 'Tour 360° số 1' ) );
foreach ( preg_split( '/\r\n|\r|\n/', (string) hh_meta( 'hh_p_tour_360_more' ) ) as $line ) {
	$parts = array_map( 'trim', explode( '|', $line, 3 ) );
	if ( preg_match( '#^https://[^\s|]+$#', $parts[0] ) ) {
		$tours[] = array( $parts[0], '' !== ( $parts[1] ?? '' ) ? $parts[1] : 'Tour 360° số ' . ( count( $tours ) + 1 ) );
	}
}
?>
<section class="block" id="xem-360">
	<h2 class="block__title">Tham quan 360° <?php echo esc_html( $title ); ?></h2>
	<p class="prose">Xoay, phóng to để xem toàn cảnh dự án, căn hộ và tiện ích ngay trên điện thoại. Cần xem thực tế hoặc nhận thông tin căn cụ thể, liên hệ Hoàng Hiệp – 0904 567 009.</p>
	<?php if ( count( $tours ) > 1 ) : ?>
		<div class="tour360__tabs" role="tablist" aria-label="Chọn tour 360°">
			<?php foreach ( $tours as $n => $t ) : ?>
				<button type="button" role="tab" class="tour360__tab<?php echo 0 === $n ? ' is-active' : ''; ?>" aria-selected="<?php echo 0 === $n ? 'true' : 'false'; ?>" data-src="<?php echo esc_url( $t[0] ); ?>"><?php echo esc_html( $t[1] ); ?></button>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<div class="tour4d tour360<?php echo $poster ? ' has-poster' : ''; ?>" data-src="<?php echo esc_url( $src ); ?>">
		<?php if ( $poster ) : ?>
			<img class="tour4d__poster" src="<?php echo esc_url( $poster ); ?>" alt="<?php echo esc_attr( 'Tham quan 360° ' . $title . ' – bấm để xem' ); ?>" width="1200" height="750" loading="lazy" decoding="async">
			<span class="tour4d__badge">360°</span>
		<?php endif; ?>
		<button type="button" class="tour4d__play">
			<span class="tour4d__icon" aria-hidden="true">▶</span>
			<span><strong>Bấm để tham quan 360°</strong><small>Xoay, phóng to, xem từng góc</small></span>
		</button>
	</div>
</section>
