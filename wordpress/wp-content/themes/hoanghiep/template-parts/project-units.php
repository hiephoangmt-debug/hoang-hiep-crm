<?php
/**
 * Các loại căn hộ: danh sách bên trái (tên, diện tích), bên phải là ảnh layout hoặc thẻ thông tin + nút nhận layout.
 * Ảnh lấy từ "Ảnh layout từng loại căn": khớp tiêu đề ảnh với tên loại căn, không khớp thì theo thứ tự.
 */
$rows   = $args['rows'] ?? array();
$title  = get_the_title();
$images = array_values( array_filter( hh_ids( 'hh_p_unit_layouts' ), static fn( $id ) => wp_get_attachment_image_url( $id, 'full' ) ) );
if ( ! $rows ) {
	return;
}
$norm  = static fn( $t ) => preg_replace( '/[^\p{L}\p{N}+]+/u', '', mb_strtolower( (string) $t ) );
$match = array();
foreach ( $rows as $i => $row ) {
	foreach ( $images as $id ) {
		if ( $norm( get_the_title( $id ) ) && ( $norm( get_the_title( $id ) ) === $norm( $row[0] ) || false !== mb_strpos( $norm( $row[0] ), $norm( get_the_title( $id ) ) ) ) ) {
			$match[ $i ] = $id;
			break;
		}
	}
}
if ( ! $match && count( $images ) === count( $rows ) ) {
	$match = $images;
}
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
