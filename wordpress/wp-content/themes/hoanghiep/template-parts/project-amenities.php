<?php
/**
 * Ảnh tiện ích dạng lưới: ảnh đầu lớn, các ảnh sau 2 cột, tên tiện ích nằm trên ảnh, bấm để phóng to.
 * Tên = chú thích ảnh (caption), không có thì tiêu đề ảnh, không có nữa thì tiện ích cùng thứ tự trong danh sách.
 */
$ids   = array_values( array_filter( (array) ( $args['ids'] ?? array() ), static fn( $id ) => wp_get_attachment_image_url( $id, 'full' ) ) );
$names = $args['names'] ?? array();
if ( ! $ids ) {
	return;
}
$label = static function ( $id, $i ) use ( $names ) {
	$cap = trim( (string) wp_get_attachment_caption( $id ) );
	$t   = trim( (string) get_the_title( $id ) );
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
	<?php foreach ( $ids as $i => $id ) : ?>
		<?php $name = $label( $id, $i ); ?>
		<a class="amenity-grid__item<?php echo 0 === $i ? ' amenity-grid__item--wide' : ''; ?>" href="<?php echo esc_url( wp_get_attachment_image_url( $id, 'full' ) ); ?>" data-lightbox="tien-ich">
			<?php echo wp_get_attachment_image( $id, 0 === $i ? 'large' : 'hh-card', false, array( 'loading' => 'lazy', 'alt' => trim( $name . ' ' . get_the_title() ) ) ); ?>
			<?php if ( $name ) : ?>
				<span class="amenity-grid__name"><?php echo esc_html( $name ); ?></span>
			<?php endif; ?>
		</a>
	<?php endforeach; ?>
</div>
