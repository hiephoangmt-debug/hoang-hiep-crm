<?php
/**
 * Giỏ hàng nổi bật của dự án: vài căn giá tốt, giá "Liên hệ" – khách để lại số để nhận giá và phiếu tính giá.
 * Dữ liệu: ô "Giỏ hàng nổi bật" (tab Giá & chính sách).
 */
$rows = hh_table( 'hh_p_hot_units', 5 );
if ( ! $rows ) {
	return;
}
$title = get_the_title();
?>
<section class="block hot-units" id="gio-hang">
	<h2 class="block__title"><?php echo esc_html( hh_meta( 'hh_p_hot_title' ) ?: 'Giỏ hàng độc quyền – căn giá tốt' ); ?></h2>
	<p class="prose"><?php echo esc_html( count( $rows ) . ' căn được chọn lọc từ giỏ hàng đang bán của ' . $title . ', cập nhật ' . wp_date( 'd/m/Y', get_the_modified_time( 'U' ) ) . '. Giá và chính sách áp dụng thay đổi theo ngày – để lại số điện thoại để nhận giá, phiếu tính giá và vị trí căn trên mặt bằng.' ); ?></p>
	<div class="hot-units__grid">
		<?php foreach ( $rows as list( $code, $zone, $type, $area, $note ) ) : ?>
			<article class="hot-unit">
				<p class="hot-unit__zone"><?php echo esc_html( $zone ?: $title ); ?></p>
				<h3 class="hot-unit__code"><?php echo esc_html( $code ); ?></h3>
				<ul class="hot-unit__facts">
					<?php if ( $type ) : ?><li><span>Loại hình</span><strong><?php echo esc_html( $type ); ?></strong></li><?php endif; ?>
					<?php if ( $area ) : ?><li><span>Diện tích đất</span><strong><?php echo esc_html( $area ); ?></strong></li><?php endif; ?>
					<li><span>Giá</span><strong class="hot-unit__price">Liên hệ</strong></li>
				</ul>
				<?php if ( $note ) : ?><p class="hot-unit__note"><?php echo esc_html( $note ); ?></p><?php endif; ?>
				<a class="btn btn--gold btn--sm hot-unit__btn" href="#lien-he" data-need="Nhận bảng giá dự án" data-msg="<?php echo esc_attr( 'Gửi tôi giá, phiếu tính giá và vị trí căn ' . $code . ( $zone ? ' (' . $zone . ')' : '' ) . ' – ' . $title . '.' ); ?>">Nhận giá &amp; phiếu tính giá</a>
			</article>
		<?php endforeach; ?>
	</div>
	<?php
	hh_cta_box(
		array(
			'icon'    => 'file',
			'variant' => 'offer',
			'title'   => 'Nhận bảng hàng đầy đủ & chỉ căn trên mặt bằng',
			'text'    => 'Ngoài các căn trên, Hiệp gửi bảng hàng đang mở bán, phiếu tính giá theo từng phương án thanh toán và ảnh chỉ vị trí căn – qua Zalo trong vài phút.',
			'button'  => 'Nhận bảng hàng đầy đủ',
			'need'    => 'Nhận bảng giá dự án',
			'msg'     => 'Gửi tôi bảng hàng đầy đủ, chính sách và chỉ căn ' . $title . '.',
		)
	);
	?>
</section>
