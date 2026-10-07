<?php
/**
 * Bảng giá thị trường theo dự án (trang Mua bán / Cho thuê): khoảng giá bán lại hoặc giá thuê của từng dự án,
 * tổng hợp từ tin của web và mặt bằng giá tin rao công khai – link sang trang dự án.
 * Args: type (slug hoặc mảng slug loại dự án), deal (ban | thue), area (slug khu vực, tùy chọn), title.
 */
$deal  = $args['deal'] ?? 'ban';
$tax   = array( array( 'taxonomy' => 'loai-du-an', 'field' => 'slug', 'terms' => (array) $args['type'] ) );
if ( ! empty( $args['area'] ) ) {
	$tax[] = array( 'taxonomy' => 'khu-vuc', 'field' => 'slug', 'terms' => $args['area'] );
}
$board = new WP_Query(
	array(
		'post_type'      => 'du-an',
		'posts_per_page' => 60,
		'orderby'        => 'title',
		'order'          => 'ASC',
		'no_found_rows'  => true,
		'tax_query'      => $tax, // phpcs:ignore WordPress.DB.SlowDBQuery
	)
);
$rows   = array();
$latest = 0; // Ngày sửa gần nhất của các dự án trong bảng (ghi "cập nhật" theo dữ liệu thật).
while ( $board->have_posts() ) {
	$board->the_post();
	$market = hh_project_market();
	if ( 'thue' === $deal ) {
		$price = $market['thue']['range'] ? hh_ucfirst( $market['thue']['range'] ) : hh_meta( 'hh_p_rent_price' );
		$kind  = $market['thue']['count'] ? $market['thue']['count'] . ' căn đang cho thuê' : 'Giá thị trường';
	} else {
		$price = $market['ban']['range'] ? hh_ucfirst( $market['ban']['range'] ) : ( hh_meta( 'hh_p_resale_price' ) ?: ( hh_meta( 'hh_p_price_from' ) && ! hh_project_is_resale() ? hh_project_price() : '' ) );
		$kind  = $market['ban']['count'] ? $market['ban']['count'] . ' căn đang bán' : ( hh_meta( 'hh_p_resale_price' ) ? 'Chuyển nhượng' : 'Chủ đầu tư' );
	}
	if ( ! $price ) {
		continue;
	}
	$latest = max( $latest, (int) get_post_modified_time( 'U', true ) );
	$area   = hh_project_area();
	$rows[] = array( get_the_title(), get_permalink(), $area ? $area->name : '', $price, $kind );
}
wp_reset_postdata();
if ( ! $rows ) {
	return;
}
$what        = 'thue' === $deal ? 'cho thuê' : 'bán';
$price_label = 'thue' === $deal ? 'Giá thuê tham khảo' : 'Giá tham khảo';
?>
<section class="block price-board">
	<h2 class="block__title"><?php echo esc_html( $args['title'] ); ?></h2>
	<p class="prose"><?php echo esc_html( 'Mặt bằng giá ' . $what . ' tham khảo theo từng dự án – tổng hợp từ tin đăng trên website, bảng giá chủ đầu tư và tin rao công khai, cập nhật ' . wp_date( 'm/Y', $latest ?: time() ) . '. Bấm tên dự án để xem vị trí, tiện ích và các căn đang giao dịch.' ); ?></p>
	<div class="table-wrap">
		<table class="data-table">
			<thead><tr><th>Dự án</th><th>Khu vực</th><th><?php echo esc_html( $price_label ); ?></th><th>Nguồn</th><th></th></tr></thead>
			<tbody>
				<?php foreach ( $rows as list( $name, $link, $place, $price, $kind ) ) : ?>
					<tr>
						<td><a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $name ); ?></a></td>
						<td data-label="Khu vực"><?php echo esc_html( $place ); ?></td>
						<td data-label="<?php echo esc_attr( $price_label ); ?>"><?php echo esc_html( $price ); ?></td>
						<td data-label="Nguồn"><?php echo esc_html( $kind ); ?></td>
						<td class="data-table__action"><a class="btn btn--outline btn--sm" href="#lien-he" data-need="<?php echo 'thue' === $deal ? 'Thuê' : 'Mua'; ?>" data-msg="<?php echo esc_attr( 'Gửi tôi danh sách căn đang ' . $what . ' tại ' . $name . '.' ); ?>">Nhận căn</a></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<p class="note">Giá chỉ để tham khảo, thay đổi theo tầng, view, nội thất và thời điểm. Liên hệ <?php echo esc_html( hoanghiep_opt( 'hh_phone' ) ); ?> để nhận danh sách căn thật đang <?php echo esc_html( $what ); ?>. Bạn có căn cần <?php echo esc_html( $what ); ?>? <a href="#lien-he" data-need="Ký gửi bán / cho thuê" data-msg="Tôi muốn ký gửi căn hộ.">Ký gửi với Hiệp</a>.</p>
</section>
