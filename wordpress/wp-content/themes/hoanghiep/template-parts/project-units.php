<?php
/**
 * Các loại căn hộ: danh sách bên trái (tên, diện tích), bên phải là ảnh layout hoặc thẻ thông tin + nút nhận layout.
 * Ảnh lấy từ "Ảnh layout từng loại căn": khớp tiêu đề ảnh với tên loại căn, không khớp thì theo thứ tự.
 */
$rows   = $args['rows'] ?? array();
$title  = get_the_title();
$images = array_values( array_filter( hh_ids( 'hh_p_unit_layouts' ), static fn( $img ) => wp_get_attachment_image_url( $img, 'full' ) ) );
if ( ! $rows ) {
	return;
}
$norm  = static fn( $t ) => preg_replace( '/[^\p{L}\p{N}+]+/u', '', mb_strtolower( (string) $t ) );
$match = array();
foreach ( $rows as $i => $row ) {
	foreach ( $images as $img ) {
		if ( $norm( get_the_title( $img ) ) && ( $norm( get_the_title( $img ) ) === $norm( $row[0] ) || false !== mb_strpos( $norm( $row[0] ), $norm( get_the_title( $img ) ) ) ) ) {
			$match[ $i ] = $img;
			break;
		}
	}
}
if ( ! $match && count( $images ) === count( $rows ) ) {
	$match = $images;
}
if ( ! $match ) :
	// Chưa có ảnh layout: thẻ loại căn gọn (diện tích, phòng ngủ, giá từ) thay cho tab + khung trống.
	$from = function_exists( 'hh_px_price_from' ) ? hh_px_price_from( get_the_ID() ) : array();
	?>
	<div class="ucards">
		<?php foreach ( $rows as $i => list( $name, $area, $beds, $price ) ) : ?>
			<?php
			$group = function_exists( 'hh_px_unit_group' ) ? hh_px_unit_group( $name ) : '';
			$badge = $group ?: ( preg_match( '/\d\s*PN\+?/iu', $name, $m ) ? strtoupper( str_replace( ' ', '', $m[0] ) ) : mb_substr( $name, 0, 10 ) );
			$has_p = $price && ! in_array( mb_strtolower( trim( $price ) ), array( '–', '-', 'liên hệ' ), true );
			$show  = $has_p ? $price : ( isset( $from[ $group ] ) ? 'từ ' . hh_px_money( $from[ $group ]['price'] ) : '' );
			?>
			<?php $plan = function_exists( 'hh_px_plan_svg' ) ? hh_px_plan_svg( $group ) : ''; ?>
			<div class="ucard">
				<div class="ucard__media">
					<?php echo $plan; // phpcs:ignore -- SVG tự sinh, chữ đã escape. ?>
					<span class="ucard__badge"><?php echo esc_html( $badge ); ?></span>
					<?php if ( $plan ) : ?><small class="ucard__hint">Hình minh họa</small><?php endif; ?>
				</div>
				<p class="ucard__name"><?php echo esc_html( $name ); ?></p>
				<ul class="ucard__meta">
					<?php if ( $area && '–' !== $area ) : ?><li><?php echo hh_icon( 'area' ); // phpcs:ignore ?><?php echo esc_html( $area ); ?></li><?php endif; ?>
					<?php if ( $beds && '–' !== $beds ) : ?><li><?php echo hh_icon( 'bed' ); // phpcs:ignore ?><?php echo esc_html( $beds ); ?> phòng ngủ</li><?php elseif ( 'Studio' === $group ) : ?><li><?php echo hh_icon( 'bed' ); // phpcs:ignore ?>Không gian mở</li><?php endif; ?>
				</ul>
				<p class="ucard__price"><small>Giá tham khảo</small><b><?php echo esc_html( $show ?: 'Liên hệ báo giá' ); ?></b></p>
				<a class="ucard__cta" href="#lien-he" data-need="Nhận bảng giá dự án" data-msg="<?php echo esc_attr( 'Gửi tôi layout, danh sách căn trống và giá ' . $name . ' – ' . $title . '.' ); ?>">Nhận layout &amp; giá →</a>
			</div>
		<?php endforeach; ?>
	</div>
	<?php
	return;
endif;
?>
<div class="units">
	<div class="units__list" role="tablist">
		<?php foreach ( $rows as $i => list( $name, $area, $beds, $price ) ) : ?>
			<button type="button" role="tab" class="units__item<?php echo 0 === $i ? ' is-active' : ''; ?>" aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>" data-unit="<?php echo (int) $i; ?>">
				<strong><?php echo esc_html( $name ); ?></strong>
				<span><?php echo esc_html( implode( ' · ', array_filter( array( $area && '–' !== $area ? $area : '', $beds && '–' !== $beds ? $beds . ' PN' : '' ) ) ) ); ?></span>
			</button>
		<?php endforeach; ?>
	</div>
	<div class="units__view">
		<?php foreach ( $rows as $i => list( $name, $area, $beds, $price ) ) : ?>
			<div class="units__panel<?php echo 0 === $i ? ' is-active' : ''; ?>" data-unit-panel="<?php echo (int) $i; ?>">
				<?php if ( isset( $match[ $i ] ) ) : ?>
					<a href="<?php echo esc_url( wp_get_attachment_image_url( $match[ $i ], 'full' ) ); ?>" data-lightbox="layout-can"><?php echo wp_get_attachment_image( $match[ $i ], 'large', false, array( 'loading' => 'lazy', 'alt' => 'Layout ' . $name . ' ' . $title ) ); ?></a>
				<?php endif; ?>
				<div class="units__info">
					<p class="units__name"><?php echo esc_html( $name ); ?></p>
					<dl>
						<?php if ( $area && '–' !== $area ) : ?><div><dt>Diện tích</dt><dd><?php echo esc_html( $area ); ?></dd></div><?php endif; ?>
						<?php if ( $beds && '–' !== $beds ) : ?><div><dt>Phòng ngủ</dt><dd><?php echo esc_html( $beds ); ?></dd></div><?php endif; ?>
						<div><dt>Giá tham khảo</dt><dd class="units__price"><?php echo esc_html( $price && '–' !== $price ? $price : 'Liên hệ' ); ?></dd></div>
					</dl>
					<a class="btn btn--gold btn--sm" href="#lien-he" data-need="Nhận bảng giá dự án" data-msg="<?php echo esc_attr( 'Gửi tôi layout, danh sách căn trống và giá ' . $name . ' – ' . $title . '.' ); ?>"><?php echo isset( $match[ $i ] ) ? 'Nhận giá & căn trống' : 'Nhận layout & giá căn này'; ?></a>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>
