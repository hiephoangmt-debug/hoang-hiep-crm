<?php
/**
 * Mặt bằng tầng dạng tab: mỗi ảnh trong "Ảnh mặt bằng tầng" là một tab (tên tab = tiêu đề ảnh), bấm ảnh để phóng to.
 * Tiêu đề dạng "S1 · Tầng 3" hoặc "S1 – Tầng 3" (nhiều tòa) → chọn tòa trước, rồi chọn tầng của tòa đó (xếp tầng thấp → cao).
 */
$ids = array_values( array_filter( (array) ( $args['ids'] ?? array() ), static fn( $img ) => wp_get_attachment_image_url( $img, 'full' ) ) );
if ( ! $ids ) {
	return;
}
$label = static function ( $img, $i ) {
	$t = trim( (string) get_the_title( $img ) );
	return ( '' === $t || preg_match( '/^(img|dsc|image|screenshot|mat-bang)?[\s_\-]*[\d_\-]+$/i', $t ) ) ? 'Mặt bằng ' . ( $i + 1 ) : $t;
};
// Nhóm theo tòa: chỉ khi mọi tiêu đề đều có dạng "Tòa · Tầng" (hoặc "Tòa – Tầng") và có từ 2 tòa trở lên.
$groups = array();
$parts  = array();
$split  = static function ( $t ) {
	if ( preg_match( '/^(.{1,12}?)\s+[·–—-]\s+(.+)$/u', $t, $m ) && ! preg_match( '/^(tầng|tang|hầm|ham|căn|can|layout)\b/iu', $m[1] ) ) {
		return array( trim( $m[1] ), trim( $m[2] ) );
	}
	return null;
};
foreach ( $ids as $i => $img ) {
	$m = $split( $label( $img, $i ) );
	if ( ! $m ) {
		$groups = array();
		break;
	}
	$key            = sanitize_title( $m[0] );
	$groups[ $key ] = $groups[ $key ] ?? array( 'name' => $m[0], 'count' => 0 );
	$parts[ $i ]    = array( $key, $m[1] );
}
if ( count( $groups ) > 1 ) {
	// Thứ tự trong mỗi tòa: tầng thấp → tầng điển hình → penthouse → duplex (tầng chính trước tầng lửng); bỏ tab trùng tên.
	$rank = static function ( $t ) {
		$n = mb_strtolower( $t );
		$r = preg_match( '/(\d+)/', $n, $d ) ? (int) $d[1] : 50;
		if ( false !== strpos( $n, 'hầm' ) ) {
			$r = -10 + $r;
		} elseif ( false !== strpos( $n, 'điển hình' ) ) {
			$r = 40;
		}
		if ( false !== strpos( $n, 'duplex' ) ) {
			$r = 900 + ( false !== strpos( $n, 'lửng' ) ? 1 : 0 );
		} elseif ( false !== strpos( $n, 'penthouse' ) || preg_match( '/\bph\b/', $n ) ) {
			$r += 500;
		}
		return $r;
	};
	$rows = array();
	$seen = array();
	foreach ( $ids as $i => $img ) {
		$sig = $parts[ $i ][0] . '|' . mb_strtolower( $parts[ $i ][1] );
		if ( isset( $seen[ $sig ] ) ) {
			continue;
		}
		$seen[ $sig ] = true;
		$rows[]       = array( $img, $parts[ $i ], $rank( $parts[ $i ][1] ), $i );
	}
	ksort( $groups, SORT_NATURAL );
	$order = array_flip( array_keys( $groups ) );
	usort( $rows, static fn( $a, $b ) => array( $order[ $a[1][0] ], $a[2], $a[3] ) <=> array( $order[ $b[1][0] ], $b[2], $b[3] ) );
	$ids   = array_column( $rows, 0 );
	$parts = array_column( $rows, 1 );
	foreach ( $groups as $k => $g ) {
		$groups[ $k ]['count'] = count( array_filter( $parts, static fn( $p ) => $p[0] === $k ) );
	}
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
