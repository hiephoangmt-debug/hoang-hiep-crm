<?php
/**
 * Ảnh tiện ích dạng lưới: ảnh đầu lớn, các ảnh sau 2 cột, tên tiện ích nằm trên ảnh, bấm để phóng to.
 * Tên = chú thích ảnh (caption), không có thì tiêu đề ảnh, không có nữa thì tiện ích cùng thứ tự trong danh sách.
 */
$ids   = array_values( array_filter( (array) ( $args['ids'] ?? array() ), static fn( $img ) => wp_get_attachment_image_url( $img, 'full' ) ) );
$names = $args['names'] ?? array();
if ( ! $ids ) {
	return;
}
$label = static function ( $img, $i ) use ( $names ) {
	$cap = trim( (string) wp_get_attachment_caption( $img ) );
	$t   = trim( (string) get_the_title( $img ) );
	if ( '' !== $cap ) {
		return $cap;
	}
	// Tiêu đề kiểu tên file (IMG_1234, hotel-facade, z5123…) thì bỏ qua.
	$is_file = preg_match( '/^[\w\-.]+$/u', $t ) && ( preg_match( '/[_\-]/', $t ) || preg_match( '/\d{3,}/', $t ) );
	if ( '' !== $t && ! $is_file ) {
		return $t;
	}
	return $names[ $i ] ?? '';
};
?>
<div class="amenity-grid">
	<?php foreach ( $ids as $i => $img ) : ?>
		<?php $name = $label( $img, $i ); ?>
		<a class="amenity-grid__item<?php echo 0 === $i ? ' amenity-grid__item--wide' : ''; ?>" href="<?php echo esc_url( wp_get_attachment_image_url( $img, 'full' ) ); ?>" data-lightbox="tien-ich">
			<?php echo wp_get_attachment_image( $img, 0 === $i ? 'large' : 'hh-card', false, array( 'loading' => 'lazy', 'alt' => trim( $name . ' ' . get_the_title() ) ) ); ?>
			<?php if ( $name ) : ?>
				<span class="amenity-grid__name"><?php echo esc_html( $name ); ?></span>
			<?php endif; ?>
		</a>
	<?php endforeach; ?>
</div>
