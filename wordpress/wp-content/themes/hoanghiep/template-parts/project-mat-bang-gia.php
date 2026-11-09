<?php
/**
 * Ô "Mặt bằng giá căn hộ Đà Nẵng" trên trang dự án: khoảng giá của dự án và các dự án gần mức giá nhất.
 * Dữ liệu: hh_mat_bang_gia_for() trong plugin (mat-bang-gia.php). Không có dữ liệu → không hiện gì.
 */
if ( ! function_exists( 'hh_mat_bang_gia_for' ) ) {
	return;
}
$mbg = hh_mat_bang_gia_for( get_post_field( 'post_name', get_the_ID() ) );
if ( ! $mbg ) {
	return;
}
list( , $mbg_name, $mbg_lo, $mbg_hi, $mbg_src ) = $mbg['row'];
$mbg_max = max( 150, max( array_map( static fn( $r ) => $r[3], $mbg['near'] ) ) );
?>
<div class="mbg">
	<p class="mbg__tag">Mặt bằng giá căn hộ Đà Nẵng · 11/2026</p>
	<p class="mbg__num"><b><?php echo esc_html( $mbg_lo . ' – ' . $mbg_hi ); ?></b> triệu/m²</p>
	<p class="mbg__src"><?php echo esc_html( $mbg_name . ': ' . $mbg_src ); ?>. Giá tham khảo theo m² thông thủy.</p>
	<p class="mbg__sub">So với các dự án cùng tầm giá</p>
	<ul class="mbg__bars">
		<?php foreach ( $mbg['near'] as $r ) : ?>
			<?php
			$is_me = $r[0] === $mbg['row'][0];
			$left  = round( $r[2] / $mbg_max * 100, 1 );
			$width = max( 1.5, round( ( $r[3] - $r[2] ) / $mbg_max * 100, 1 ) );
			$name  = $r[0] && ! $is_me ? '<a href="' . esc_url( home_url( '/du-an/' . $r[0] . '/' ) ) . '">' . esc_html( $r[1] ) . '</a>' : esc_html( $r[1] );
			?>
			<li class="<?php echo $is_me ? 'is-me' : ''; ?>">
				<span class="mbg__name"><?php echo $name; // phpcs:ignore WordPress.Security.EscapeOutput -- đã escape ở trên. ?></span>
				<span class="mbg__track"><i style="left:<?php echo esc_attr( $left ); ?>%;width:<?php echo esc_attr( $width ); ?>%"></i></span>
				<span class="mbg__val"><?php echo esc_html( $r[2] . ' – ' . $r[3] ); ?></span>
			</li>
		<?php endforeach; ?>
	</ul>
	<p class="mbg__more"><a href="<?php echo esc_url( hh_mat_bang_gia_url() ); ?>">Xem bảng giá 30 dự án căn hộ Đà Nẵng →</a></p>
</div>
