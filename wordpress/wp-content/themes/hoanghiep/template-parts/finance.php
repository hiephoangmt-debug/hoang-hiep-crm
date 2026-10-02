<?php
/**
 * Bài toán dòng tiền & vay ngân hàng (interactive).
 *
 * $args['mode'] = 'project' | 'listing'
 */
$mode    = $args['mode'] ?? 'project';
$id      = get_the_ID();
$num     = static fn( $key, $default ) => '' !== hh_meta( $key ) ? (float) hh_meta( $key ) : $default;
$payment = array();

if ( 'project' === $mode ) {
	foreach ( hh_table( 'hh_p_payment', 3 ) as list( $stage, $when, $ratio ) ) {
		if ( preg_match( '/(\d+(?:[.,]\d+)?)/', $ratio, $m ) ) {
			$payment[] = array( 'stage' => $stage, 'when' => $when, 'pct' => (float) str_replace( ',', '.', $m[1] ) );
		}
	}
	$price = $num( 'hh_p_calc_price', $num( 'hh_p_price_from', 3000 ) );
	$cfg   = array(
		'price'      => $price,
		'ratio'      => $num( 'hh_p_loan_ratio', 70 ),
		'years'      => $num( 'hh_p_loan_years', 20 ),
		'promo'      => $num( 'hh_p_loan_rate_promo', 7 ),
		'promoM'     => $num( 'hh_p_loan_promo_months', 12 ),
		'float'      => $num( 'hh_p_loan_rate_float', 10.5 ),
		'grace'      => $num( 'hh_p_loan_grace', 0 ),
		'zero'       => $num( 'hh_p_loan_zero_months', 0 ),
		'rent'       => $num( 'hh_p_rent_estimate', 0 ),
		'occ'        => $num( 'hh_p_occupancy', 85 ),
		'cost'       => $num( 'hh_p_rent_cost', 10 ),
		'growth'     => $num( 'hh_p_growth', 0 ),
		'payment'    => $payment,
	);
} else {
	$cfg = array(
		'price'   => $num( 'hh_price', 3000 ),
		'ratio'   => 70,
		'years'   => 20,
		'promo'   => 7,
		'promoM'  => 12,
		'float'   => 10.5,
		'grace'   => 0,
		'zero'    => 0,
		'rent'    => 0,
		'occ'     => 90,
		'cost'    => 5,
		'growth'  => 0,
		'payment' => array(),
	);
}

$fields = array(
	array( 'price', 'Giá trị căn (triệu đồng)', 1, 'Giá mua, VD: 3350 = 3,35 tỷ' ),
	array( 'ratio', 'Tỷ lệ vay (%)', 1, '' ),
	array( 'years', 'Thời hạn vay (năm)', 1, '' ),
	array( 'promo', 'Lãi ưu đãi (%/năm)', 0.1, '' ),
	array( 'promoM', 'Thời gian ưu đãi (tháng)', 1, '' ),
	array( 'float', 'Lãi thả nổi (%/năm)', 0.1, '' ),
	array( 'grace', 'Ân hạn gốc (tháng)', 1, '' ),
	array( 'zero', 'CĐT hỗ trợ lãi 0% (tháng)', 1, '' ),
);
$rent_fields = array(
	array( 'rent', 'Giá thuê (triệu/tháng)', 0.5 ),
	array( 'occ', 'Lấp đầy (%)', 1 ),
	array( 'cost', 'Chi phí vận hành (%)', 1 ),
);
?>
<div class="finance" data-finance="<?php echo esc_attr( wp_json_encode( $cfg ) ); ?>">
	<?php if ( 'project' === $mode && ( hh_meta( 'hh_p_loan_bank' ) || hh_meta( 'hh_p_cashflow_note' ) ) ) : ?>
		<div class="finance__intro">
			<?php if ( hh_meta( 'hh_p_loan_bank' ) ) : ?>
				<p><strong>Ngân hàng hỗ trợ:</strong> <?php echo esc_html( hh_meta( 'hh_p_loan_bank' ) ); ?></p>
			<?php endif; ?>
			<?php if ( hh_meta( 'hh_p_cashflow_note' ) ) : ?>
				<p class="prose"><?php echo nl2br( esc_html( hh_meta( 'hh_p_cashflow_note' ) ) ); ?></p>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<div class="finance__grid">
		<form class="finance__inputs" onsubmit="return false">
			<p class="finance__label">Nhập thông số của bạn</p>
			<?php foreach ( $fields as list( $key, $label, $step, $hint ) ) : ?>
				<label>
					<span><?php echo esc_html( $label ); ?></span>
					<input type="number" inputmode="decimal" min="0" step="<?php echo esc_attr( $step ); ?>" name="<?php echo esc_attr( $key ); ?>" id="fin-<?php echo esc_attr( $key . '-' . $id ); ?>" value="<?php echo esc_attr( $cfg[ $key ] ); ?>"<?php echo $hint ? ' title="' . esc_attr( $hint ) . '"' : ''; ?>>
				</label>
			<?php endforeach; ?>
			<label class="finance__wide">
				<span>Cách trả nợ</span>
				<select name="method" id="fin-method-<?php echo (int) $id; ?>">
					<option value="giam-dan">Gốc đều, lãi giảm dần (phổ biến)</option>
					<option value="deu">Trả đều hằng tháng (gốc + lãi)</option>
				</select>
			</label>
		</form>

		<div class="finance__results" aria-live="polite">
			<dl class="finance__cards">
				<div><dt>Vốn tự có cần chuẩn bị</dt><dd data-out="equity">—</dd></div>
				<div><dt>Khoản vay ngân hàng</dt><dd data-out="loan">—</dd></div>
				<div><dt>Trả tháng đầu tiên</dt><dd data-out="first">—</dd></div>
				<div><dt>Trả cao nhất / tháng</dt><dd data-out="max">—</dd><small data-out="maxWhen"></small></div>
				<div><dt>Tổng lãi phải trả</dt><dd data-out="interest">—</dd></div>
				<div><dt>Tổng thanh toán (gốc + lãi)</dt><dd data-out="total">—</dd></div>
			</dl>
			<p class="finance__note" data-out="summary"></p>
		</div>
	</div>

	<?php if ( $cfg['payment'] ) : ?>
		<h3 class="block__sub">Dòng tiền thanh toán theo tiến độ</h3>
		<p class="finance__hint">Vốn tự có được thanh toán ở các đợt đầu, ngân hàng giải ngân phần còn lại (cách làm phổ biến; chính sách từng dự án có thể khác).</p>
		<div class="table-wrap">
			<table class="data-table finance__schedule">
				<thead><tr><th>Đợt</th><th>Thời điểm</th><th>Tỷ lệ</th><th>Số tiền</th><th>Vốn tự có</th><th>Ngân hàng</th></tr></thead>
				<tbody data-out="schedule"></tbody>
				<tfoot><tr><th colspan="2">Tổng</th><th data-out="pctTotal"></th><th data-out="priceTotal"></th><th data-out="equityTotal"></th><th data-out="bankTotal"></th></tr></tfoot>
			</table>
		</div>
	<?php endif; ?>

	<h3 class="block__sub">Bài toán cho thuê</h3>
	<div class="finance__rent">
		<form class="finance__inputs finance__inputs--inline" onsubmit="return false">
			<?php foreach ( $rent_fields as list( $key, $label, $step ) ) : ?>
				<label>
					<span><?php echo esc_html( $label ); ?></span>
					<input type="number" inputmode="decimal" min="0" step="<?php echo esc_attr( $step ); ?>" name="<?php echo esc_attr( $key ); ?>" id="fin-<?php echo esc_attr( $key . '-' . $id ); ?>" value="<?php echo esc_attr( $cfg[ $key ] ?: '' ); ?>" placeholder="0">
				</label>
			<?php endforeach; ?>
		</form>
		<dl class="finance__cards finance__cards--rent">
			<div><dt>Thu nhập thuê ròng / tháng</dt><dd data-out="netRent">—</dd></div>
			<div><dt>Lợi suất cho thuê / năm</dt><dd data-out="yield">—</dd></div>
			<div><dt>Dòng tiền sau trả ngân hàng / tháng</dt><dd data-out="cashflow">—</dd><small>tính theo khoản trả sau ưu đãi</small></div>
		</dl>
	</div>

	<details class="finance__amort">
		<summary>Xem lịch trả nợ theo từng năm</summary>
		<div class="table-wrap">
			<table class="data-table">
				<thead><tr><th>Năm</th><th>Dư nợ đầu năm</th><th>Trả gốc</th><th>Trả lãi</th><th>Tổng trả</th><th>Bình quân/tháng</th><th>Dư nợ cuối năm</th></tr></thead>
				<tbody data-out="amort"></tbody>
			</table>
		</div>
	</details>

	<?php
	$custom = 'project' === $mode ? hh_table( 'hh_p_custom_table', 3 ) : array();
	if ( $custom ) :
		?>
		<h3 class="block__sub">Bảng tính chi tiết</h3>
		<?php hh_data_table( array( 'Hạng mục', 'Giá trị', 'Ghi chú' ), $custom ); ?>
	<?php endif; ?>

	<p class="note">Kết quả chỉ mang tính tham khảo, lãi suất thả nổi có thể thay đổi theo ngân hàng. Liên hệ Hiệp để có bảng tính chính xác cho căn bạn chọn.</p>
</div>
