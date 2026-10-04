<?php
/**
 * Khung mở đầu mục Giới thiệu: ưu đãi + con số chính + nút nhận bảng giá / Zalo – khách thấy ngay, để lại thông tin ngay.
 * Dữ liệu: Ưu đãi nổi bật, Con số nổi bật, Hạn ưu đãi (tab Giá & chính sách); không có thì lấy 3 điểm nổi bật.
 */
$title    = get_the_title();
// Con số nổi bật đã hiện ở khung form đầu trang → ở đây dùng 3 điểm nổi bật (không lặp lại).
$stats    = array();
$offer    = '';
$points   = array_slice( hh_lines( 'hh_p_highlights' ), 0, 3 );
$deadline = hh_parse_vn_date( hh_meta( 'hh_p_offer_deadline' ) );
$days     = $deadline && $deadline > time() ? max( 1, (int) floor( ( $deadline - time() ) / DAY_IN_SECONDS ) ) : 0;
if ( ! $stats && ! $offer && ! $points ) {
	return;
}
$zalo = 'https://zalo.me/' . hoanghiep_tel( hoanghiep_opt( 'hh_zalo' ) );
?>
<div class="hook">
	<div class="hook__head">
		<?php if ( $days ) : ?><span class="hook__tag">Ưu đãi còn <?php echo esc_html( (string) $days ); ?> ngày</span><?php endif; ?>
		<p class="hook__title"><?php echo wp_kses( preg_replace( '/(\d+(?:[.,]\d+)?\s?%)/u', '<em>$1</em>', esc_html( $offer ?: 'Bảng giá, chính sách & căn đẹp ' . $title . ' – cập nhật hôm nay' ) ), array( 'em' => array() ) ); ?></p>
	</div>
	<?php if ( $stats ) : ?>
		<ul class="hook__stats">
			<?php foreach ( $stats as list( $num, $label ) ) : ?>
				<li><b><?php echo esc_html( $num ); ?></b><span><?php echo esc_html( $label ); ?></span></li>
			<?php endforeach; ?>
		</ul>
	<?php elseif ( $points ) : ?>
		<?php hh_check_list( $points, 'check-list hook__points' ); ?>
	<?php endif; ?>
	<div class="hook__actions">
		<a class="btn btn--cta" href="#lien-he" data-need="Nhận bảng giá dự án" data-msg="<?php echo esc_attr( 'Gửi tôi bảng giá, chính sách và phiếu tính giá ' . $title . '.' ); ?>">Nhận bảng giá &amp; phiếu tính giá</a>
		<a class="btn btn--ghost" href="<?php echo esc_url( $zalo ); ?>" target="_blank" rel="noopener">Chat Zalo <?php echo esc_html( hoanghiep_opt( 'hh_phone' ) ); ?></a>
	</div>
	<p class="hook__note">Gửi trong 5 phút qua Zalo · miễn phí, không ràng buộc</p>
</div>
