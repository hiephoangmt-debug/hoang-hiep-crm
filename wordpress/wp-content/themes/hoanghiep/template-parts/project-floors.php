<?php
/**
 * Mặt bằng tầng dạng tab: mỗi ảnh trong "Ảnh mặt bằng tầng" là một tab (tên tab = tiêu đề ảnh), bấm ảnh để phóng to.
 * Tiêu đề dạng "S1 · Tầng 3" (nhiều tòa) → chọn tòa trước, rồi chọn tầng của tòa đó.
 */
$ids = array_values( array_filter( (array) ( $args['ids'] ?? array() ), static fn( $img ) => wp_get_attachment_image_url( $img, 'full' ) ) );
if ( ! $ids ) {
	return;
}
$label = static function ( $img, $i ) {
	$t = trim( (string) get_the_title( $img ) );
	return ( '' === $t || preg_match( '/^(img|dsc|image|screenshot|mat-bang)?[\s_\-]*[\d_\-]+$/i', $t ) ) ? 'Mặt bằng ' . ( $i + 1 ) : $t;
};
// Nhóm theo tòa: chỉ khi mọi tiêu đề đều có dạng "Tòa · Tầng" và có từ 2 tòa trở lên.
$groups = array();
$parts  = array();
foreach ( $ids as $i => $img ) {
	if ( ! preg_match( '/^(.{1,24}?)\s+·\s+(.+)$/u', $label( $img, $i ), $m ) ) {
		$groups = array();
		break;
	}
	$key            = sanitize_title( $m[1] );
	$groups[ $key ] = $groups[ $key ] ?? array( 'name' => $m[1], 'count' => 0 );
	++$groups[ $key ]['count'];
	$parts[ $i ] = array( $key, $m[2] );
}
$grouped = count( $groups ) > 1;
$first   = $grouped ? array_key_first( $groups ) : '';
?>
<div class="floors<?php echo $grouped ? ' floors--grouped' : ''; ?>">
	<?php if ( $grouped ) : ?>
		<div class="floors__groups" role="tablist" aria-label="Chọn tòa">
			<?php foreach ( $groups as $key => $g ) : ?>
				<?php $name = preg_match( '/^[A-Z]{1,2}\d+[A-Z]?$/', $g['name'] ) ? 'Tòa ' . $g['name'] : $g['name']; ?>
				<button type="button" role="tab" class="floors__group<?php echo $key === $first ? ' is-active' : ''; ?>" aria-selected="<?php echo $key === $first ? 'true' : 'false'; ?>" data-fgroup="<?php echo esc_attr( $key ); ?>"><strong><?php echo esc_html( $name ); ?></strong><span><?php echo (int) $g['count']; ?> mặt bằng</span></button>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<?php if ( count( $ids ) > 1 ) : ?>
		<div class="ptabs floors__tabs" role="tablist"<?php echo $grouped ? ' aria-label="Chọn tầng"' : ''; ?>>
			<?php
			$shown = false;
			foreach ( $ids as $i => $img ) :
				$grp    = $grouped ? $parts[ $i ][0] : '';
				$text   = $grouped ? $parts[ $i ][1] : $label( $img, $i );
				$hide   = $grouped && $grp !== $first;
				$active = ! $hide && ! $shown;
				$shown  = $shown || $active;
				?>
				<button type="button" role="tab" class="ptabs__tab<?php echo $active ? ' is-active' : ''; ?>" aria-selected="<?php echo $active ? 'true' : 'false'; ?>" data-ptab="tang-<?php echo (int) $i; ?>"<?php echo $grouped ? ' data-fgroup="' . esc_attr( $grp ) . '"' : ''; ?><?php echo $hide ? ' hidden' : ''; ?>><?php echo esc_html( $text ); ?></button>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<?php
	$shown = false;
	foreach ( $ids as $i => $img ) :
		$active = ( ! $grouped || $parts[ $i ][0] === $first ) && ! $shown;
		$shown  = $shown || $active;
		?>
		<div class="ptabs__panel floors__panel<?php echo $active ? ' is-active' : ''; ?>" data-ppanel="tang-<?php echo (int) $i; ?>">
			<a href="<?php echo esc_url( wp_get_attachment_image_url( $img, 'full' ) ); ?>" data-lightbox="mat-bang-tang" aria-label="<?php echo esc_attr( 'Phóng to ' . $label( $img, $i ) ); ?>">
				<?php echo wp_get_attachment_image( $img, 'large', false, array( 'loading' => 'lazy', 'alt' => $label( $img, $i ) . ' ' . get_the_title() ) ); ?>
			</a>
		</div>
	<?php endforeach; ?>
	<p class="floors__hint">Bấm vào ảnh để phóng to, xem mã căn và diện tích từng căn.</p>
</div>
