<?php
/**
 * Khung ưu đãi đầu mục Chính sách: dòng ưu đãi lớn, đồng hồ đếm ngược đến hạn ưu đãi, bảng chiết khấu theo phương án.
 */
$title    = get_the_title();
$headline = hh_meta( 'hh_p_offer_title' ) ?: ( hh_project_offer_lines() ? hh_project_offer_lines()[0] : '' );
$discount = hh_table( 'hh_p_discount_table', 3 );
if ( ! $headline && ! $discount ) {
	return;
}
$deadline = hh_parse_vn_date( hh_meta( 'hh_p_offer_deadline' ) );
$live     = $deadline && $deadline > time();
?>
<?php if ( $headline ) : ?>
	<div class="offer-banner">
		<div class="offer-banner__text">
			<span class="offer-banner__tag"><?php echo $live ? 'Ưu đãi có hạn' : 'Ưu đãi đang áp dụng'; ?></span>
			<p class="offer-banner__title"><?php echo wp_kses( preg_replace( '/(\d+(?:[.,]\d+)?\s?%)/u', '<em>$1</em>', esc_html( $headline ) ), array( 'em' => array() ) ); ?></p>
			<?php if ( hh_meta( 'hh_p_offer_note' ) ) : ?>
				<p class="offer-banner__note"><?php echo esc_html( hh_meta( 'hh_p_offer_note' ) ); ?></p>
			<?php elseif ( ! $live ) : ?>
				<p class="offer-banner__note">Chính sách thay đổi theo từng đợt mở bán – để lại số điện thoại để nhận bản mới nhất.</p>
			<?php endif; ?>
		</div>
		<?php if ( $live ) : ?>
			<div class="countdown" data-deadline="<?php echo esc_attr( (string) $deadline ); ?>" aria-label="<?php echo esc_attr( 'Ưu đãi kết thúc ngày ' . wp_date( 'd/m/Y', $deadline ) ); ?>">
				<div><b data-cd="d">00</b><span>Ngày</span></div>
				<div><b data-cd="h">00</b><span>Giờ</span></div>
				<div><b data-cd="m">00</b><span>Phút</span></div>
				<div><b data-cd="s">00</b><span>Giây</span></div>
			</div>
		<?php else : ?>
			<a class="btn btn--gold" href="#lien-he" data-need="Nhận bảng giá dự án" data-msg="<?php echo esc_attr( 'Gửi tôi chính sách bán hàng mới nhất ' . $title . '.' ); ?>">Nhận chính sách</a>
		<?php endif; ?>
	</div>
<?php endif; ?>
<?php if ( $discount ) : ?>
	<div class="discount">
		<p class="discount__title">Chiết khấu theo phương án thanh toán <?php echo esc_html( $title ); ?></p>
		<div class="table-wrap">
			<table class="data-table discount__table">
				<thead><tr><th>Phương án</th><th>Hạn thanh toán</th><th>Chiết khấu</th></tr></thead>
				<tbody>
					<?php foreach ( $discount as list( $plan, $due, $pct ) ) : ?>
						<tr><td><?php echo esc_html( $plan ); ?></td><td><?php echo esc_html( $due ); ?></td><td><?php echo esc_html( $pct ); ?></td></tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
<?php endif; ?>
