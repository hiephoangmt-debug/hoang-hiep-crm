<?php
/**
 * Khung ưu đãi đầu mục Chính sách: dòng ưu đãi lớn, đồng hồ đếm ngược đến hạn ưu đãi, bảng chiết khấu theo phương án.
 */
$part     = $args['part'] ?? 'all'; // all | banner | discount
$title    = get_the_title();
$stats    = hh_table( 'hh_p_offer_stats', 2 );
$headline = hh_meta( 'hh_p_offer_title' ) ?: ( hh_project_offer_lines() ? hh_project_offer_lines()[0] : '' );
$discount = hh_table( 'hh_p_discount_table', 4 );
if ( ! $headline && ! $discount ) {
	return;
}
$deadline = hh_parse_vn_date( hh_meta( 'hh_p_offer_deadline' ) );
$live     = $deadline && $deadline > time();
?>
<?php if ( $headline && 'discount' !== $part ) : ?>
	<div class="offer-banner<?php echo $stats ? ' offer-banner--stats' : ''; ?>">
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
		<?php elseif ( ! $stats ) : ?>
			<a class="btn btn--gold" href="#lien-he" data-need="Nhận bảng giá dự án" data-msg="<?php echo esc_attr( 'Gửi tôi chính sách bán hàng mới nhất ' . $title . '.' ); ?>">Nhận chính sách</a>
		<?php endif; ?>
		<?php if ( $stats ) : ?>
			<ul class="offer-stats">
				<?php foreach ( array_slice( $stats, 0, 4 ) as list( $num, $label ) ) : ?>
					<li><b><?php echo esc_html( $num ); ?></b><span><?php echo esc_html( $label ); ?></span></li>
				<?php endforeach; ?>
			</ul>
			<div class="offer-banner__cta">
				<a class="btn btn--gold" href="#lien-he" data-need="Nhận bảng giá dự án" data-msg="<?php echo esc_attr( 'Gửi tôi phiếu tính giá và chính sách mới nhất ' . $title . '. Căn tôi quan tâm: ' ); ?>">Nhận phiếu tính giá căn của bạn</a>
				<?php if ( $live ) : ?><span>Còn <?php echo esc_html( (string) max( 1, (int) floor( ( $deadline - time() ) / DAY_IN_SECONDS ) ) ); ?> ngày hưởng chiết khấu thanh toán sớm</span><?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>
<?php if ( $discount && 'banner' !== $part ) : ?>
	<div class="discount">
		<p class="discount__title">Chiết khấu theo phương án thanh toán <?php echo esc_html( $title ); ?></p>
		<div class="table-wrap">
			<table class="data-table discount__table">
				<thead><tr><th>Phương án</th><th>Tổng chiết khấu</th><th><span class="screen-reader-text">Nhận phiếu tính giá</span></th></tr></thead>
				<tbody>
					<?php foreach ( $discount as list( $plan, $due, $pct, $how ) ) : ?>
						<tr>
							<td>
								<strong class="discount__plan"><?php echo esc_html( $plan ); ?></strong>
								<?php if ( $how ) : ?><span class="discount__how"><?php echo esc_html( $how ); ?></span><?php endif; ?>
							</td>
							<td class="discount__pct" data-label="Tổng chiết khấu">
								<span class="discount__val"><b><?php echo esc_html( $pct ); ?></b>
								<?php if ( $due ) : ?><span class="discount__due"><?php echo hh_icon( 'clock' ); // phpcs:ignore ?> <?php echo esc_html( $due ); ?></span><?php endif; ?></span>
							</td>
							<td class="discount__go data-table__action">
								<a class="btn btn--gold btn--sm" href="#lien-he" data-need="Nhận bảng giá dự án" data-msg="<?php echo esc_attr( 'Gửi tôi phiếu tính giá phương án "' . $plan . '" – ' . $title . '.' ); ?>">Nhận phiếu tính giá</a>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<div class="discount__foot">
			<p><?php echo $live ? 'Còn <strong>' . esc_html( max( 1, (int) floor( ( $deadline - time() ) / DAY_IN_SECONDS ) ) ) . ' ngày</strong> để nhận mức chiết khấu thanh toán sớm. ' : ''; ?>Chiết khấu cộng dồn so với giá niêm yết, tính lần lượt trên giá chưa VAT – áp dụng như nhau cho mọi căn. Gửi mã căn để nhận số tiền chính xác.</p>
			<a class="btn btn--navy" href="#lien-he" data-need="Nhận bảng giá dự án" data-msg="<?php echo esc_attr( 'Tính giúp tôi phương án thanh toán có lợi nhất – ' . $title . '. Căn tôi quan tâm: ' ); ?>">Tính giúp tôi phương án có lợi nhất</a>
		</div>
	</div>
<?php endif; ?>
