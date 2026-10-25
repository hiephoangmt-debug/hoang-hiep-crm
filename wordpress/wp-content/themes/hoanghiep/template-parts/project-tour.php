<?php
/**
 * Trang dự án: mô hình 4D (xem tự do, bản công khai có chữ chìm số điện thoại) + nút chọn căn (hỏi số Zalo trước khi mở).
 * Dữ liệu: ô "Link mô hình 4D" (hh_p_tour_4d) và "Link công cụ chọn căn" (hh_p_tour_units) của dự án.
 */

defined( 'ABSPATH' ) || exit;

$id    = get_the_ID();
$title = get_the_title();
$pub   = static function ( $url ) {
	if ( ! $url ) {
		return '';
	}
	// Bỏ tham số nội bộ: crm (tắt chữ chìm), k / e (mã, email người được cấp quyền) → luôn là bản công khai cho khách.
	$url = remove_query_arg( array( 'crm', 'k', 'e', 'pub' ), $url );
	$url = preg_replace( '/\?(?=#|$)/', '', $url );
	return add_query_arg( 'pub', '1', $url );
};
$tour  = $pub( (string) hh_meta( 'hh_p_tour_4d' ) );
$units = $pub( (string) hh_meta( 'hh_p_tour_units' ) );
if ( ! $tour && ! $units ) {
	return;
}
?>
<section class="block" id="xem-4d">
	<h2 class="block__title">Xem 4D &amp; chọn căn <?php echo esc_html( $title ); ?></h2>
	<p class="prose">Xoay mô hình, xem hướng nắng, tầm nhìn từng tầng ngay trên điện thoại. Mô hình dựng lại để minh họa vị trí và hướng nhìn, không phải bản vẽ thiết kế của chủ đầu tư.</p>
	<?php if ( $tour ) : ?>
		<div class="tour4d" data-src="<?php echo esc_url( $tour ); ?>">
			<button type="button" class="tour4d__play">
				<span class="tour4d__icon" aria-hidden="true">▶</span>
				<span><strong>Bấm để xem mô hình 4D</strong><small>Xoay, phóng to, xem hướng nắng</small></span>
			</button>
		</div>
	<?php endif; ?>
	<div class="tour4d__actions">
		<?php if ( $units ) : ?>
			<button type="button" class="btn btn--cta" data-zalo-gate="<?php echo esc_url( $units ); ?>">Chọn căn, xem chi tiết</button>
		<?php endif; ?>
		<?php if ( $tour ) : ?>
			<a class="btn btn--outline" href="<?php echo esc_url( $tour ); ?>" target="_blank" rel="noopener">Mở 4D toàn màn hình</a>
		<?php endif; ?>
	</div>
</section>
<?php if ( $units ) : ?>
	<div class="lead-pop zalo-gate" id="zalo-gate" role="dialog" aria-modal="true" aria-labelledby="zalo-gate-title" hidden>
		<div class="lead-pop__box">
			<button type="button" class="lead-pop__close" aria-label="Đóng">&times;</button>
			<p class="lead-pop__title" id="zalo-gate-title">Nhập số Zalo để xem chi tiết từng căn</p>
			<p class="zalo-gate__sub">Mặt bằng tầng, hướng nhìn, diện tích từng căn <?php echo esc_html( $title ); ?>. Hoàng Hiệp gửi giá căn anh chị chọn qua Zalo.</p>
			<form class="zalo-gate__form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" novalidate>
				<input type="hidden" name="action" value="hh_lead">
				<input type="hidden" name="ajax" value="1">
				<input type="hidden" name="ref_id" value="<?php echo (int) $id; ?>">
				<input type="hidden" name="need" value="Xem chọn căn">
				<input type="hidden" name="message" value="<?php echo esc_attr( 'Khách mở công cụ chọn căn ' . $title . ' – gửi giá căn qua Zalo.' ); ?>">
				<div class="hh-form__hp" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
				<label>Số Zalo *<input type="tel" name="phone" required pattern="[0-9+ .]{9,15}" maxlength="15" autocomplete="tel" inputmode="tel" placeholder="VD: 0905 123 456"></label>
				<label>Tên (không bắt buộc)<input type="text" name="name" maxlength="100" autocomplete="name"></label>
				<p class="zalo-gate__msg" role="alert" hidden></p>
				<button type="submit" class="btn btn--cta btn--block">Xem chi tiết căn</button>
			</form>
		</div>
	</div>
<?php endif; ?>
