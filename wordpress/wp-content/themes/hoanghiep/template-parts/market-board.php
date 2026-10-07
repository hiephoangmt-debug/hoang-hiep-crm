<?php
/**
 * Bảng giá thị trường theo khu vực (đất lớn, khách sạn ven biển…): khoảng giá tham khảo, không phải tin rao cụ thể.
 * Args: board (title, intro, columns, rows, sources).
 */
$b = $args['board'] ?? null;
if ( ! $b || empty( $b['rows'] ) ) {
	return;
}
?>
<section class="block price-board market-board">
	<h2 class="block__title"><?php echo esc_html( $b['title'] ); ?></h2>
	<?php if ( ! empty( $b['intro'] ) ) : ?>
		<p class="prose"><?php echo esc_html( $b['intro'] ); ?></p>
	<?php endif; ?>
	<div class="table-wrap">
		<table class="data-table">
			<thead><tr><?php foreach ( $b['columns'] as $col ) : ?><th><?php echo esc_html( $col ); ?></th><?php endforeach; ?><th></th></tr></thead>
			<tbody>
				<?php foreach ( $b['rows'] as $row ) : ?>
					<tr>
						<?php foreach ( $row as $i => $cell ) : ?>
							<td data-label="<?php echo esc_attr( $b['columns'][ $i ] ?? '' ); ?>"><?php echo 0 === $i ? '<strong>' . esc_html( $cell ) . '</strong>' : esc_html( $cell ); ?></td>
						<?php endforeach; ?>
						<td class="data-table__action"><a class="btn btn--outline btn--sm" href="#lien-he" data-need="Mua" data-msg="<?php echo esc_attr( 'Gửi tôi danh sách ' . mb_strtolower( $args['what'] ?? 'sản phẩm' ) . ' đang bán khu vực ' . $row[0] . '.' ); ?>">Nhận danh sách</a></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<p class="note">Khoảng giá tổng hợp từ tin rao và báo cáo thị trường công khai – chỉ để tham khảo. Sản phẩm lớn thường giao dịch kín, không đăng công khai: liên hệ <?php echo esc_html( hoanghiep_opt( 'hh_phone' ) ); ?> để nhận danh sách thật đúng tiêu chí. Bạn có tài sản cần bán? <a href="#lien-he" data-need="Ký gửi bán / cho thuê" data-msg="Tôi muốn ký gửi bán tài sản.">Ký gửi với Hiệp</a>.</p>
	<?php if ( ! empty( $b['sources'] ) ) : ?>
		<details class="sources"><summary>Nguồn tham khảo</summary><ul><?php foreach ( $b['sources'] as $u ) : ?><li><a href="<?php echo esc_url( $u ); ?>" rel="nofollow noopener" target="_blank"><?php echo esc_html( wp_parse_url( $u, PHP_URL_HOST ) ); ?></a></li><?php endforeach; ?></ul></details>
	<?php endif; ?>
</section>
