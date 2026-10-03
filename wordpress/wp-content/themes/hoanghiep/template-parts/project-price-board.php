<?php
/**
 * Bảng giá thị trường theo dự án (VD trang Mua bán biệt thự): khoảng giá chuyển nhượng / giá bán
 * của các dự án cùng loại, link sang trang dự án. Args: type (slug loại dự án), title.
 */
$board = new WP_Query(
	array(
		'post_type'      => 'du-an',
		'posts_per_page' => 40,
		'orderby'        => 'title',
		'order'          => 'ASC',
		'no_found_rows'  => true,
		'tax_query'      => array( array( 'taxonomy' => 'loai-du-an', 'field' => 'slug', 'terms' => $args['type'] ) ),
	)
);
$rows = array();
while ( $board->have_posts() ) {
	$board->the_post();
	$market = hh_project_market();
	$price  = $market['ban']['range'] ? hh_ucfirst( $market['ban']['range'] ) : ( hh_meta( 'hh_p_resale_price' ) ?: ( hh_meta( 'hh_p_price_from' ) ? hh_project_price() : '' ) );
	if ( ! $price ) {
		continue;
	}
	$area   = hh_project_area();
	$rows[] = array( get_the_title(), get_permalink(), $area ? $area->name : '', hh_meta( 'hh_p_unit_area' ) ?: hh_meta( 'hh_p_units' ), $price, hh_project_is_resale() ? 'Chuyển nhượng' : 'Chủ đầu tư' );
}
wp_reset_postdata();
if ( ! $rows ) {
	return;
}
?>
<section class="block price-board">
	<h2 class="block__title"><?php echo esc_html( $args['title'] ); ?></h2>
	<p class="prose">Mặt bằng giá tham khảo theo từng dự án (tổng hợp từ bảng giá chủ đầu tư và tin rao chuyển nhượng công khai). Bấm tên dự án để xem chi tiết, vị trí, tiện ích và danh sách căn đang bán.</p>
	<div class="table-wrap">
		<table class="data-table">
			<thead><tr><th>Dự án</th><th>Khu vực</th><th>Diện tích / quy mô</th><th>Giá tham khảo</th><th>Thị trường</th></tr></thead>
			<tbody>
				<?php foreach ( $rows as list( $name, $link, $place, $size, $price, $kind ) ) : ?>
					<tr><td><a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $name ); ?></a></td><td><?php echo esc_html( $place ); ?></td><td><?php echo esc_html( $size ); ?></td><td><?php echo esc_html( $price ); ?></td><td><?php echo esc_html( $kind ); ?></td></tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<p class="note">Giá chỉ để tham khảo, thay đổi theo vị trí căn, nội thất và thời điểm. Liên hệ <?php echo esc_html( hoanghiep_opt( 'hh_phone' ) ); ?> để nhận danh sách căn thật đang bán.</p>
</section>
