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
?>
<section class="block" id="xem-360">
	<h2 class="block__title">Tham quan 360° <?php echo esc_html( $title ); ?></h2>
	<p class="prose">Xoay, phóng to để xem toàn cảnh biệt thự, hồ bơi và cảnh quan ngay trên điện thoại. Cần xem thực tế hoặc nhận thông tin căn cụ thể, liên hệ Hoàng Hiệp – 0904 567 009.</p>
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
