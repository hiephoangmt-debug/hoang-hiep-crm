<?php
/**
 * Mặt bằng tầng dạng tab: mỗi ảnh trong "Ảnh mặt bằng tầng" là một tab (tên tab = tiêu đề ảnh), bấm ảnh để phóng to.
 */
$ids = array_values( array_filter( (array) ( $args['ids'] ?? array() ), static fn( $id ) => wp_get_attachment_image_url( $id, 'full' ) ) );
if ( ! $ids ) {
	return;
}
$label = static function ( $id, $i ) {
	$t = trim( (string) get_the_title( $id ) );
	return ( '' === $t || preg_match( '/^(img|dsc|image|screenshot|mat-bang)?[\s_\-]*[\d_\-]+$/i', $t ) ) ? 'Mặt bằng ' . ( $i + 1 ) : $t;
};
?>
<div class="floors">
	<?php if ( count( $ids ) > 1 ) : ?>
		<div class="ptabs floors__tabs" role="tablist">
			<?php foreach ( $ids as $i => $id ) : ?>
				<button type="button" role="tab" class="ptabs__tab<?php echo 0 === $i ? ' is-active' : ''; ?>" aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>" data-ptab="tang-<?php echo (int) $i; ?>"><?php echo esc_html( $label( $id, $i ) ); ?></button>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<?php foreach ( $ids as $i => $id ) : ?>
		<div class="ptabs__panel floors__panel<?php echo 0 === $i ? ' is-active' : ''; ?>" data-ppanel="tang-<?php echo (int) $i; ?>">
			<a href="<?php echo esc_url( wp_get_attachment_image_url( $id, 'full' ) ); ?>" data-lightbox="mat-bang-tang" aria-label="<?php echo esc_attr( 'Phóng to ' . $label( $id, $i ) ); ?>">
				<?php echo wp_get_attachment_image( $id, 'large', false, array( 'loading' => 'lazy', 'alt' => $label( $id, $i ) . ' ' . get_the_title() ) ); ?>
			</a>
		</div>
	<?php endforeach; ?>
	<p class="floors__hint">Bấm vào ảnh để phóng to, xem mã căn và diện tích từng căn.</p>
</div>
