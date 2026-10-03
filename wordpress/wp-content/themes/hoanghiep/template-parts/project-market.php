<?php
/**
 * Mua bán – chuyển nhượng & cho thuê trong dự án (thị trường thứ cấp).
 * Args: id (anchor), market (hh_project_market()), resale (bool).
 */
$pid    = get_the_ID();
$title  = get_the_title();
$market = $args['market'];
$resale = ! empty( $args['resale'] );
$tabs   = array(
	'ban'  => array( 'Chuyển nhượng', $market['ban'], hh_meta( 'hh_p_resale_price' ) ),
	'thue' => array( 'Cho thuê', $market['thue'], hh_meta( 'hh_p_rent_price' ) ),
);
?>
<section class="block" id="<?php echo esc_attr( $args['id'] ); ?>">
	<h2 class="block__title"><?php echo esc_html( ( $resale ? 'Mua bán – chuyển nhượng & cho thuê ' : 'Chuyển nhượng & cho thuê ' ) . $title ); ?></h2>
	<?php if ( $resale ) : ?>
		<p class="prose"><?php echo esc_html( ( '1' === hh_meta( 'hh_p_sold_out' ) ? $title . ' đã bán hết từ chủ đầu tư' : $title . ' đã bàn giao' ) . '. Dưới đây là các căn chủ nhà đang chuyển nhượng và cho thuê, Hiệp kiểm tra pháp lý và hỗ trợ thủ tục sang tên.' ); ?></p>
	<?php endif; ?>

	<div class="market">
		<?php foreach ( $tabs as $deal => list( $label, $m, $note ) ) : ?>
			<div class="market__box">
				<p class="market__label"><?php echo esc_html( 'ban' === $deal ? 'Giá chuyển nhượng' : 'Giá thuê' ); ?></p>
				<p class="market__value"><?php echo esc_html( $m['range'] ? hh_ucfirst( $m['range'] ) : ( $note ?: 'Liên hệ' ) ); ?></p>
				<p class="market__meta">
					<?php
					echo esc_html(
						implode(
							' · ',
							array_filter(
								array(
									$m['count'] ? $m['count'] . ( 'ban' === $deal ? ' căn đang bán' : ' căn cho thuê' ) : 'Chưa có tin đăng',
									'ban' === $deal && $m['m2'] ? 'TB ' . $m['m2'] : '',
									$m['range'] && $note ? $note : '',
								)
							)
						)
					);
					?>
				</p>
			</div>
		<?php endforeach; ?>
	</div>
	<?php if ( hh_meta( 'hh_p_resale_note' ) ) : ?>
		<p class="prose"><?php echo nl2br( esc_html( hh_meta( 'hh_p_resale_note' ) ) ); ?></p>
	<?php endif; ?>

	<div class="ptabs" role="tablist">
		<?php $first = true; foreach ( $tabs as $deal => list( $label, $m ) ) : ?>
			<button type="button" role="tab" class="ptabs__tab<?php echo $first ? ' is-active' : ''; ?>" aria-selected="<?php echo $first ? 'true' : 'false'; ?>" data-ptab="<?php echo esc_attr( $deal ); ?>"><?php echo esc_html( $label . ' (' . $m['count'] . ')' ); ?></button>
		<?php $first = false; endforeach; ?>
	</div>
	<?php $first = true; foreach ( $tabs as $deal => list( $label, $m ) ) : ?>
		<div class="ptabs__panel<?php echo $first ? ' is-active' : ''; ?>" data-ppanel="<?php echo esc_attr( $deal ); ?>">
			<?php $q = hh_project_listings( $pid, $deal, 4 ); ?>
			<?php if ( $q && $q->have_posts() ) : ?>
				<div class="grid grid--2">
					<?php
					while ( $q->have_posts() ) :
						$q->the_post();
						get_template_part( 'template-parts/listing-card' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
				<?php if ( $m['count'] > 4 ) : ?>
					<p class="market__more"><a class="btn btn--outline" href="<?php echo esc_url( hh_project_listings_url( $pid, $deal ) ); ?>">Xem tất cả <?php echo (int) $m['count']; ?> căn <?php echo esc_html( 'ban' === $deal ? 'đang bán' : 'cho thuê' ); ?></a></p>
				<?php endif; ?>
			<?php else : ?>
				<?php hh_pending( 'Chưa có căn ' . ( 'ban' === $deal ? 'chuyển nhượng' : 'cho thuê' ) . ' được đăng công khai tại ' . $title . '. Hiệp có giỏ hàng nội bộ cập nhật hằng tuần – để lại số điện thoại để nhận danh sách.', 'ban' === $deal ? 'Nhận căn chuyển nhượng' : 'Nhận căn cho thuê' ); ?>
			<?php endif; ?>
		</div>
	<?php $first = false; endforeach; ?>

	<div class="consign">
		<p><strong>Bạn có căn tại <?php echo esc_html( $title ); ?> cần bán hoặc cho thuê?</strong> Ký gửi với Hiệp: định giá, đăng tin, dẫn khách xem và hỗ trợ thủ tục.</p>
		<a class="btn btn--gold btn--sm" href="#lien-he" data-need="Ký gửi bán / cho thuê">Ký gửi căn hộ</a>
	</div>
</section>
