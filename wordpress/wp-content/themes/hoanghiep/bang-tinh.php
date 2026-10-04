<?php
/**
 * Trang bảng tính căn của dự án: /du-an/<dự án>/bang-tinh/?can=<mã căn>&bg=<bảng giá>&tt=<phương án>
 * (hoặc ?gia=<giá niêm yết>&loai=<loại căn> khi tính theo phiếu tính giá của chủ đầu tư).
 * Dữ liệu từ file bảng hàng / phiếu tính giá (plugin, units.php).
 */
get_header();
the_post();

// phpcs:disable WordPress.Security.NonceVerification -- form GET công khai, chỉ đọc.
$id       = get_the_ID();
$title    = get_the_title();
$data     = hh_units_data( $id );
$plans    = hh_units_plans( $id );
$variants = $data['variants'] ?? array();
$units    = $data['units'] ?? array();
$is_slip  = static fn( $p ) => 'slip' === ( $p['kind'] ?? '' );
$has_slip = (bool) array_filter( $plans, $is_slip );

$bg   = sanitize_title( (string) ( $_GET['bg'] ?? '' ) );
$tt   = sanitize_title( (string) ( $_GET['tt'] ?? '' ) );
$code = preg_replace( '/\s+/', '', sanitize_text_field( wp_unslash( $_GET['can'] ?? '' ) ) );
$gia  = $has_slip ? hh_units_money( sanitize_text_field( wp_unslash( $_GET['gia'] ?? '' ) ) ) : 0;
$loai = strtoupper( sanitize_text_field( wp_unslash( $_GET['loai'] ?? '' ) ) );
$on   = isset( $_GET['ckf'] ) ? array_map( 'intval', (array) ( $_GET['uu'] ?? array() ) ) : null;
$bg   = isset( $variants[ $bg ] ) ? $bg : (string) array_key_first( $variants );
$sold = static fn( $u ) => (bool) preg_match( '/da ban|đã bán|da coc|đã cọc|lock|sold|giu cho|giữ chỗ/u', hh_units_norm( $u['status'] ?? '' ) );
// phpcs:enable

// Căn được chọn: từ danh sách, hoặc căn theo giá nhập tay / căn mẫu của phiếu tính giá.
$unit = null;
foreach ( $units as $u ) {
	if ( '' !== $code && 0 === strcasecmp( $u['code'], $code ) ) {
		$unit = $u;
		break;
	}
}
$fits = array_filter( $plans, static fn( $p ) => ! $unit || hh_units_plan_fits( $p, $unit ) );
$fits = $fits ?: $plans;
$tt   = isset( $fits[ $tt ] ) ? $tt : (string) array_key_first( $fits );
$plan = $fits[ $tt ];
$mode = $unit ? 'unit' : '';
if ( ! $unit && $is_slip( $plan ) && ( $gia || ! $units ) ) {
	$mode = $gia ? 'custom' : 'sample';
	$unit = array(
		'code'   => 'sample' === $mode ? $plan['sample']['code'] : '',
		'type'   => $loai ?: ( 'sample' === $mode ? $plan['sample']['type'] : '' ),
		'prices' => array( 'gia' => $gia ?: (int) $plan['sample']['list'] ),
		'extra'  => array(),
	);
}
$calc     = $unit ? hh_units_compute( $id, $unit, 'unit' === $mode ? $bg : 'gia', $plan, $on ) : null;
$towers   = array_values( array_unique( array_filter( array_column( $units, 'tower' ) ) ) );
$types    = array_values( array_unique( array_filter( array_column( $units, 'type' ) ) ) );
$states   = array_values( array_unique( array_filter( array_column( $units, 'status' ) ) ) );
$policies = array_values( array_unique( array_filter( array_map( static fn( $p ) => $p['policy'] ?? '', $plans ) ) ) );
$groups   = array();
foreach ( $fits as $k => $p ) {
	$groups[ $p['group'] ?? '' ][ $k ] = $p;
}
$tyy  = static fn( $v ) => rtrim( rtrim( number_format( $v / 1e9, 3, ',', '' ), '0' ), ',' );
$link = static fn( $c ) => hh_units_url( $id, array( 'can' => $c, 'bg' => count( $variants ) > 1 ? $bg : '', 'tt' => count( $plans ) > 1 ? $tt : '' ) ) . '#tinh';
$here = 'unit' === $mode ? $link( $unit['code'] ) : hh_units_url(
	$id,
	array(
		'gia'  => 'custom' === $mode ? $tyy( $gia ) : '',
		'loai' => $loai,
		'tt'   => $tt,
	)
) . '#tinh';
$heading = array(
	'unit'   => 'Căn ' . ( $unit['code'] ?? '' ),
	'custom' => 'Giá niêm yết ' . hh_units_vnd( $gia ),
	'sample' => 'Ví dụ: căn ' . ( $plan['sample']['code'] ?? '' ),
);
?>
<div class="page-head">
	<div class="container">
		<p class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a> / <a href="<?php echo esc_url( get_post_type_archive_link( 'du-an' ) ); ?>">Dự án</a> / <a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( $title ); ?></a> / Bảng tính căn</p>
		<h1 class="page-head__title"><?php echo esc_html( 'Bảng giá & bảng tính căn ' . $title ); ?></h1>
		<p class="page-head__lead">
			<?php if ( $units ) : ?>
				<?php echo esc_html( hh_units_summary( $data ) . ' · cập nhật ' . wp_date( 'd/m/Y', (int) $data['at'] ) . '. Chọn căn để xem giá, chiết khấu, lịch thanh toán và khoản vay chi tiết.' ); ?>
			<?php elseif ( $has_slip ) : ?>
				<?php echo esc_html( 'Tính theo phiếu tính giá của chủ đầu tư' . ( $policies ? ' (' . implode( ', ', $policies ) . ')' : '' ) . ', cập nhật ' . wp_date( 'd/m/Y', (int) $data['at'] ) . '. Nhập giá niêm yết căn bạn quan tâm, chọn phương án thanh toán để xem chiết khấu, giá sau chiết khấu và số tiền từng đợt.' ); ?>
			<?php else : ?>
				Bảng hàng đang được cập nhật theo đợt mở bán. Để lại số điện thoại để nhận bảng giá và bảng tính từng căn.
			<?php endif; ?>
		</p>
	</div>
</div>

<div class="container section units-page">
	<?php if ( ! $data ) : ?>
		<div class="empty">
			<p><strong>Chưa có bảng hàng trực tuyến cho <?php echo esc_html( $title ); ?>.</strong></p>
			<p>Hiệp gửi bạn bảng giá, căn còn trống và bảng tính dòng tiền qua Zalo.</p>
			<a class="btn btn--gold" href="#lien-he" data-need="Nhận bảng giá dự án" data-msg="<?php echo esc_attr( 'Gửi tôi bảng giá và bảng tính căn ' . $title . '.' ); ?>">Nhận bảng giá</a>
		</div>
	<?php else : ?>

		<form class="calc-form" method="get" action="<?php echo esc_url( hh_units_url( $id ) ); ?>#tinh" id="tinh">
			<?php if ( $units ) : ?>
				<label>Chọn căn
					<select name="can" data-autosubmit-field>
						<option value=""><?php echo $has_slip ? '— Chọn mã căn hoặc nhập giá —' : '— Chọn mã căn —'; ?></option>
						<?php foreach ( $units as $u ) : ?>
							<option value="<?php echo esc_attr( $u['code'] ); ?>" <?php selected( 'unit' === $mode ? $unit['code'] : '', $u['code'] ); ?>><?php echo esc_html( $u['code'] . ( ! empty( $u['type'] ) ? ' · ' . $u['type'] : '' ) . ( ! empty( $u['area'] ) ? ' · ' . $u['area'] . ' m²' : '' ) . ( $sold( $u ) ? ' (đã bán)' : '' ) ); ?></option>
						<?php endforeach; ?>
					</select>
				</label>
			<?php endif; ?>
			<?php if ( $has_slip && 'unit' !== $mode ) : ?>
				<label><?php echo $units ? 'Hoặc nhập giá niêm yết (tỷ)' : 'Giá niêm yết căn (tỷ đồng)'; ?>
					<input type="text" inputmode="decimal" name="gia" value="<?php echo 'custom' === $mode ? esc_attr( $tyy( $gia ) ) : ''; ?>" placeholder="<?php echo esc_attr( 'VD: ' . $tyy( (float) ( $plan['sample']['list'] ?? 0 ) ) ); ?>">
				</label>
				<?php if ( ! empty( $plan['dep_types'] ) ) : ?>
					<label>Loại căn
						<select name="loai" data-autosubmit-field>
							<?php foreach ( array_keys( $plan['dep_types'] ) as $t ) : ?>
								<option value="<?php echo esc_attr( $t ); ?>" <?php selected( strtoupper( $unit['type'] ?? '' ), $t ); ?>><?php echo esc_html( $t ); ?></option>
							<?php endforeach; ?>
						</select>
					</label>
				<?php endif; ?>
			<?php endif; ?>
			<?php if ( count( $variants ) > 1 && 'unit' === $mode ) : ?>
				<label>Bảng giá
					<select name="bg" data-autosubmit-field>
						<?php foreach ( $variants as $k => $label ) : ?>
							<option value="<?php echo esc_attr( $k ); ?>" <?php selected( $bg, $k ); ?>><?php echo esc_html( $label ); ?></option>
						<?php endforeach; ?>
					</select>
				</label>
			<?php endif; ?>
			<?php if ( count( $fits ) > 1 ) : ?>
				<label class="calc-form__wide">Phương án thanh toán
					<select name="tt" data-autosubmit-field>
						<?php foreach ( $groups as $g => $list ) : ?>
							<?php if ( count( $groups ) > 1 ) : ?><optgroup label="<?php echo esc_attr( $g ); ?>"><?php endif; ?>
							<?php foreach ( $list as $k => $p ) : ?>
								<option value="<?php echo esc_attr( $k ); ?>" <?php selected( $tt, $k ); ?>><?php echo esc_html( $p['name'] . ( ! empty( $p['disc'] ) ? ' – chiết khấu ' . $p['disc'] . '%' : '' ) ); ?></option>
							<?php endforeach; ?>
							<?php if ( count( $groups ) > 1 ) : ?></optgroup><?php endif; ?>
						<?php endforeach; ?>
					</select>
				</label>
			<?php endif; ?>
			<?php if ( $calc && $calc['options'] ) : ?>
				<fieldset class="calc-form__opts">
					<legend>Ưu đãi theo điều kiện</legend>
					<input type="hidden" name="ckf" value="1">
					<?php foreach ( $calc['options'] as $k => $o ) : ?>
						<label class="calc-form__check"><input type="checkbox" name="uu[]" value="<?php echo (int) $k; ?>" <?php checked( $o['on'] ); ?> data-autosubmit-field> <?php echo esc_html( $o['label'] ); ?></label>
					<?php endforeach; ?>
				</fieldset>
			<?php endif; ?>
			<div class="calc-form__submit"><button class="btn btn--gold" type="submit">Tính giá</button></div>
		</form>

		<?php if ( $unit && $calc ) : ?>
			<section class="calc-result">
				<div class="calc-result__head">
					<div>
						<p class="calc-result__eyebrow"><?php echo esc_html( $title . ( ! empty( $plan['policy'] ) ? ' · ' . $plan['policy'] : '' ) ); ?></p>
						<h2 class="calc-result__code"><?php echo esc_html( $heading[ $mode ] ); ?></h2>
					</div>
					<div class="calc-result__total">
						<span>Tổng giá trị căn hộ</span>
						<strong><?php echo esc_html( hh_units_vnd( $calc['total'] ) ); ?></strong>
						<small><?php echo esc_html( hh_units_vnd( $calc['total'], true ) ); ?></small>
					</div>
				</div>
				<?php if ( 'sample' === $mode ) : ?>
					<p class="calc-result__note">Số liệu theo phiếu tính giá mẫu của chủ đầu tư. Nhập giá niêm yết căn bạn quan tâm ở ô phía trên để tính lại.</p>
				<?php endif; ?>
				<dl class="calc-result__facts">
					<?php
					$facts = array(
						'Tòa'        => $unit['tower'] ?? '',
						'Tầng'       => $unit['floor'] ?? '',
						'Loại căn'   => $unit['type'] ?? '',
						'Diện tích'  => ! empty( $unit['area'] ) ? $unit['area'] . ( preg_match( '/m/u', $unit['area'] ) ? '' : ' m²' ) : '',
						'Hướng'      => $unit['direction'] ?? '',
						'View'       => $unit['view'] ?? '',
						'Đơn giá'    => ! empty( $unit['unit_price'] ) ? hh_units_vnd( $unit['unit_price'] ) . '/m²' : '',
						'Tình trạng' => $unit['status'] ?? '',
						'Phương án'  => $plan['name'],
					) + (array) ( $unit['extra'] ?? array() );
					foreach ( array_filter( $facts, 'strlen' ) as $k => $v ) :
						?>
						<div><dt><?php echo esc_html( $k ); ?></dt><dd><?php echo esc_html( $v ); ?></dd></div>
					<?php endforeach; ?>
				</dl>
				<?php if ( 'unit' === $mode && $sold( $unit ) ) : ?>
					<p class="calc-result__sold">Căn này đã có khách đặt. Hiệp gửi bạn danh sách căn tương tự còn trống.</p>
				<?php endif; ?>

				<div class="calc-result__grid">
					<div>
						<h3 class="block__sub">Giá căn hộ – <?php echo esc_html( $plan['name'] ); ?></h3>
						<div class="table-wrap">
							<table class="data-table calc-table">
								<tbody>
									<?php foreach ( $calc['lines'] as list( $label, $value ) ) : ?>
										<tr><td><?php echo esc_html( $label ); ?></td><td data-label="Số tiền" class="<?php echo $value < 0 ? 'is-minus' : ''; ?>"><?php echo esc_html( hh_units_vnd( $value, true ) ); ?></td></tr>
									<?php endforeach; ?>
									<tr class="calc-table__total"><td>Tổng giá trị</td><td data-label="Số tiền"><?php echo esc_html( hh_units_vnd( $calc['total'], true ) ); ?></td></tr>
								</tbody>
							</table>
						</div>
					</div>
					<?php if ( $calc['schedule'] ) : ?>
						<?php $has_when = (bool) array_filter( array_column( $calc['schedule'], 1 ) ); ?>
						<div>
							<h3 class="block__sub">Lịch thanh toán</h3>
							<div class="table-wrap">
								<table class="data-table calc-table calc-sched">
									<thead><tr><th>Đợt</th><?php echo $has_when ? '<th>Thời hạn</th>' : ''; ?><th>Tỷ lệ</th><th>Số tiền</th></tr></thead>
									<tbody>
										<?php foreach ( $calc['schedule'] as list( $label, $when, $pct, $amount, $party, $milestone ) ) : ?>
											<?php if ( $milestone ) : ?>
												<tr class="calc-sched__milestone"><td colspan="<?php echo $has_when ? 4 : 3; ?>"><?php echo esc_html( $label . ( $when ? ' · ' . $when : '' ) ); ?></td></tr>
											<?php else : ?>
												<tr class="<?php echo 'nh' === $party ? 'is-bank' : ''; ?>">
													<td><?php echo esc_html( $label ); ?><?php echo 'nh' === $party && ! preg_match( '/ngan hang giai ngan/', hh_units_norm( $label ) ) ? ' <span class="calc-sched__bank">Ngân hàng giải ngân</span>' : ''; ?></td>
													<?php if ( $has_when ) : ?><td data-label="Thời hạn"><?php echo esc_html( $when ); ?></td><?php endif; ?>
													<td data-label="Tỷ lệ"><?php echo null === $pct ? '–' : esc_html( hh_units_pct( $pct ) ); ?></td>
													<td data-label="Số tiền"><?php echo esc_html( hh_units_vnd( $amount, true ) ); ?></td>
												</tr>
											<?php endif; ?>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
							<?php if ( $is_slip( $plan ) ) : ?>
								<p class="note">Thời hạn từng đợt theo phiếu tính giá mẫu của chủ đầu tư; ngày thực tế tính theo ngày bạn ký thỏa thuận/hợp đồng.</p>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>

				<?php if ( $calc['loan'] ) : ?>
					<?php $l = $calc['loan']; ?>
					<div class="calc-loan">
						<h3 class="block__sub">Vay ngân hàng <?php echo esc_html( hh_units_pct( $l['pct'] ) ); ?><?php echo $l['bank'] ? ' – ' . esc_html( $l['bank'] ) : ''; ?></h3>
						<dl>
							<div><dt>Khoản vay</dt><dd><?php echo esc_html( hh_units_vnd( $l['amount'] ) ); ?></dd></div>
							<div><dt>Vốn tự có</dt><dd><?php echo esc_html( hh_units_vnd( $l['equity'] ) ); ?></dd></div>
							<?php if ( $l['zero'] ) : ?><div><dt>Hỗ trợ lãi 0%</dt><dd><?php echo (int) $l['zero']; ?> tháng</dd></div><?php endif; ?>
							<?php if ( $l['grace'] ) : ?><div><dt>Ân hạn gốc</dt><dd><?php echo (int) $l['grace']; ?> tháng</dd></div><?php endif; ?>
							<div><dt>Trả góp mỗi tháng*</dt><dd><?php echo esc_html( hh_units_vnd( $l['month'] ) ); ?></dd></div>
						</dl>
						<p class="note">* Gốc + lãi đều hằng tháng, lãi suất tham khảo <?php echo esc_html( $l['rate'] ); ?>%/năm, thời hạn <?php echo esc_html( $l['years'] ); ?> năm<?php echo $l['grace'] ? ', tính sau thời gian ân hạn' : ''; ?>. Lãi suất thực tế theo ngân hàng tại thời điểm vay.</p>
					</div>
				<?php endif; ?>

				<?php $what = 'unit' === $mode ? 'căn ' . $unit['code'] : 'căn giá niêm yết ' . hh_units_vnd( $unit['prices']['gia'] ); ?>
				<div class="calc-result__actions share">
					<a class="btn btn--gold" href="#lien-he" data-need="Nhận bảng giá dự án" data-msg="<?php echo esc_attr( 'Gửi tôi báo giá chính thức ' . $what . ' – ' . $title . ' (' . $plan['name'] . '). ' . preg_replace( '/#tinh$/', '', $here ) ); ?>">Nhận báo giá chính thức</a>
					<a class="btn btn--zalo" href="https://zalo.me/<?php echo esc_attr( hoanghiep_tel( hoanghiep_opt( 'hh_zalo' ) ) ); ?>" target="_blank" rel="noopener">Hỏi qua Zalo</a>
					<button type="button" class="btn btn--outline" onclick="window.print()">In / lưu PDF</button>
					<button type="button" class="btn btn--outline" data-share-copy="<?php echo esc_url( $here ); ?>">Sao chép link</button>
					<span class="share__msg" role="status"></span>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( $units ) : ?>
			<section class="block units-list">
				<h2 class="block__title">Danh sách căn <?php echo esc_html( $title ); ?></h2>
				<div class="units-filter" data-units-filter>
					<input type="search" placeholder="Tìm mã căn…" data-f="q" aria-label="Tìm mã căn">
					<?php foreach ( array( 'tower' => array( 'Tất cả tòa', $towers ), 'type' => array( 'Tất cả loại căn', $types ), 'status' => array( 'Mọi tình trạng', $states ) ) as $f => list( $all, $opts ) ) : ?>
						<?php if ( count( $opts ) > 1 ) : ?>
							<select data-f="<?php echo esc_attr( $f ); ?>" aria-label="<?php echo esc_attr( $all ); ?>">
								<option value=""><?php echo esc_html( $all ); ?></option>
								<?php foreach ( $opts as $o ) : ?>
									<option value="<?php echo esc_attr( $o ); ?>"><?php echo esc_html( $o ); ?></option>
								<?php endforeach; ?>
							</select>
						<?php endif; ?>
					<?php endforeach; ?>
					<span class="units-filter__count" data-count><?php echo count( $units ); ?> căn</span>
				</div>
				<div class="table-wrap">
					<table class="data-table units-table">
						<thead><tr><th>Mã căn</th><?php echo $towers ? '<th>Tòa</th>' : ''; ?><th>Tầng</th><th>Loại căn</th><th>Diện tích</th><th>Hướng / View</th><th><?php echo esc_html( $variants[ $bg ] ?? 'Giá' ); ?></th><th>Tình trạng</th><th></th></tr></thead>
						<tbody>
							<?php foreach ( $units as $u ) : ?>
								<tr class="<?php echo $sold( $u ) ? 'is-sold' : ''; ?><?php echo 'unit' === $mode && $unit['code'] === $u['code'] ? ' is-current' : ''; ?>" data-q="<?php echo esc_attr( strtolower( $u['code'] ) ); ?>" data-tower="<?php echo esc_attr( $u['tower'] ?? '' ); ?>" data-type="<?php echo esc_attr( $u['type'] ?? '' ); ?>" data-status="<?php echo esc_attr( $u['status'] ?? '' ); ?>">
									<td><a href="<?php echo esc_url( $link( $u['code'] ) ); ?>"><?php echo esc_html( $u['code'] ); ?></a></td>
									<?php if ( $towers ) : ?><td data-label="Tòa"><?php echo esc_html( $u['tower'] ?? '' ); ?></td><?php endif; ?>
									<td data-label="Tầng"><?php echo esc_html( $u['floor'] ?? '' ); ?></td>
									<td data-label="Loại căn"><?php echo esc_html( $u['type'] ?? '' ); ?></td>
									<td data-label="Diện tích"><?php echo esc_html( $u['area'] ?? '' ); ?></td>
									<td data-label="Hướng / View"><?php echo esc_html( implode( ' · ', array_filter( array( $u['direction'] ?? '', $u['view'] ?? '' ) ) ) ); ?></td>
									<td data-label="Giá"><?php echo ! empty( $u['prices'][ $bg ] ) ? esc_html( hh_units_vnd( $u['prices'][ $bg ] ) ) : 'Liên hệ'; ?></td>
									<td data-label="Tình trạng"><?php echo esc_html( $u['status'] ?? '' ); ?></td>
									<td class="data-table__action"><a class="btn btn--outline btn--sm" href="<?php echo esc_url( $link( $u['code'] ) ); ?>">Tính giá</a></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</section>
		<?php endif; ?>
		<p class="note"><?php echo esc_html( hh_meta( 'hh_p_units_note' ) ?: 'Bảng giá và chính sách có thể thay đổi theo từng đợt mở bán; số liệu trên trang là tạm tính để tham khảo. Liên hệ để nhận báo giá chính thức và kiểm tra căn còn trống.' ); ?></p>
		<p><a class="link-arrow" href="<?php echo esc_url( get_permalink() ); ?>">Xem tổng quan dự án <?php echo esc_html( $title ); ?> <?php echo hh_icon( 'arrow' ); // phpcs:ignore ?></a></p>
	<?php endif; ?>
</div>

<?php get_template_part( 'template-parts/cta' ); ?>
<?php
get_footer();
