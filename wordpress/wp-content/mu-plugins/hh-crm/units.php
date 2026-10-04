<?php
/**
 * Bảng tính căn: đọc file bảng hàng (.xlsx / .csv / Google Sheets) của từng dự án, lưu sẵn dạng JSON,
 * và các phép tính cho trang /du-an/<dự án>/bang-tinh/?can=<mã căn>&bg=<bảng giá>&tt=<phương án>.
 */

defined( 'ABSPATH' ) || exit;

/* -------------------------------------------------------------------------
 * Đường dẫn /du-an/<slug>/bang-tinh/
 * ---------------------------------------------------------------------- */

add_action( 'init', 'hh_units_rewrite', 14 ); // Trước khi types.php làm mới đường dẫn (ưu tiên 15).
function hh_units_rewrite() {
	add_rewrite_rule( '^du-an/([^/]+)/bang-tinh/?$', 'index.php?du-an=$matches[1]&hh_bang_tinh=1', 'top' );
}

add_filter( 'query_vars', static fn( $vars ) => array_merge( $vars, array( 'hh_bang_tinh' ) ) );

function hh_units_url( $post_id, $args = array() ) {
	return add_query_arg( array_filter( $args, 'strlen' ), trailingslashit( get_permalink( $post_id ) ) . 'bang-tinh/' );
}

function hh_is_units_page() {
	return is_singular( 'du-an' ) && get_query_var( 'hh_bang_tinh' );
}

/* -------------------------------------------------------------------------
 * Đọc file
 * ---------------------------------------------------------------------- */

/** Link chia sẻ Google Sheets → link tải CSV. */
function hh_units_sheet_csv_url( $url ) {
	if ( ! preg_match( '#docs\.google\.com/spreadsheets/d/([\w-]+)#', $url, $m ) ) {
		return $url;
	}
	$gid = preg_match( '/[#&?]gid=(\d+)/', $url, $g ) ? $g[1] : '0';
	return 'https://docs.google.com/spreadsheets/d/' . $m[1] . '/export?format=csv&gid=' . $gid;
}

/** CSV text → mảng dòng. Tự nhận dấu phân cách , ; hoặc tab. */
function hh_units_parse_csv( $text ) {
	$text  = preg_replace( '/^\xEF\xBB\xBF/', '', (string) $text );
	if ( ! mb_check_encoding( $text, 'UTF-8' ) ) {
		$text = mb_convert_encoding( $text, 'UTF-8', 'Windows-1258, Windows-1252, ISO-8859-1' );
	}
	$first = strtok( $text, "\n" );
	$delim = ',';
	foreach ( array( ';', "\t" ) as $d ) {
		if ( substr_count( (string) $first, $d ) > substr_count( (string) $first, $delim ) ) {
			$delim = $d;
		}
	}
	$rows = array();
	$fh   = fopen( 'php://temp', 'r+' );
	fwrite( $fh, $text );
	rewind( $fh );
	while ( false !== ( $r = fgetcsv( $fh, 0, $delim, '"', '\\' ) ) ) {
		$rows[] = array_map( 'trim', array_map( 'strval', $r ) );
	}
	fclose( $fh );
	return $rows;
}

/** Cột Excel "AB" → chỉ số 0-based. */
function hh_units_col_index( $ref ) {
	$letters = preg_replace( '/\d+/', '', $ref );
	$n       = 0;
	foreach ( str_split( strtoupper( $letters ) ) as $ch ) {
		$n = $n * 26 + ( ord( $ch ) - 64 );
	}
	return $n - 1;
}

/** Trang tính đầu tiên của file .xlsx → mảng dòng (không cần thư viện ngoài). */
function hh_units_parse_xlsx( $path ) {
	if ( ! class_exists( 'ZipArchive' ) ) {
		return new WP_Error( 'zip', 'Máy chủ thiếu ZipArchive để đọc .xlsx – hãy lưu file dạng .csv hoặc dùng link Google Sheets.' );
	}
	$zip = new ZipArchive();
	if ( true !== $zip->open( $path ) ) {
		return new WP_Error( 'open', 'Không mở được file .xlsx.' );
	}
	$shared = array();
	$xml    = $zip->getFromName( 'xl/sharedStrings.xml' );
	if ( $xml ) {
		$doc = simplexml_load_string( $xml );
		foreach ( $doc->si as $si ) {
			$text = '';
			if ( isset( $si->t ) ) {
				$text = (string) $si->t;
			}
			foreach ( $si->r as $run ) {
				$text .= (string) $run->t;
			}
			$shared[] = $text;
		}
	}
	// Trang tính đầu tiên theo thứ tự trong workbook.
	$sheet = 'xl/worksheets/sheet1.xml';
	$wb    = $zip->getFromName( 'xl/workbook.xml' );
	$rels  = $zip->getFromName( 'xl/_rels/workbook.xml.rels' );
	if ( $wb && $rels && preg_match( '/<sheet[^>]+r:id="([^"]+)"/', $wb, $m ) && preg_match( '/Id="' . preg_quote( $m[1], '/' ) . '"[^>]+Target="([^"]+)"|Target="([^"]+)"[^>]+Id="' . preg_quote( $m[1], '/' ) . '"/', $rels, $t ) ) {
		$target = $t[1] ?: $t[2];
		$sheet  = 'xl/' . ltrim( preg_replace( '#^/?xl/#', '', $target ), '/' );
	}
	$xml = $zip->getFromName( $sheet );
	$zip->close();
	if ( ! $xml ) {
		return new WP_Error( 'sheet', 'Không đọc được trang tính trong file .xlsx.' );
	}
	$doc  = simplexml_load_string( $xml );
	$rows = array();
	foreach ( $doc->sheetData->row as $row ) {
		$cells = array();
		foreach ( $row->c as $c ) {
			$type = (string) $c['t'];
			if ( 's' === $type ) {
				$val = $shared[ (int) $c->v ] ?? '';
			} elseif ( 'inlineStr' === $type ) {
				$val = (string) $c->is->t;
			} else {
				$val = (string) $c->v;
			}
			$cells[ hh_units_col_index( (string) $c['r'] ) ] = trim( $val );
		}
		if ( $cells ) {
			$max  = max( array_keys( $cells ) );
			$line = array();
			for ( $i = 0; $i <= $max; $i++ ) {
				$line[] = $cells[ $i ] ?? '';
			}
			$rows[] = $line;
		}
	}
	return $rows;
}

/** Bỏ dấu, chữ thường – để nhận tên cột. */
function hh_units_norm( $s ) {
	return trim( preg_replace( '/\s+/', ' ', strtolower( remove_accents( (string) $s ) ) ) );
}

/** Nhận vai trò của cột theo tiêu đề. */
function hh_units_role( $header ) {
	$h   = hh_units_norm( $header );
	$map = array(
		'skip'       => '/^(stt|tt|so tt|#|no\.?)$/',
		'status'     => '/tinh trang|trang thai|status/',
		'unit_price' => '/don gia/',
		'base'       => '/chua (gom |bao gom )?vat|truoc vat|chua thue/',
		'price'      => '/^(tong|thanh tien|gia ban|gia tri)/',
		'vat'        => '/^(thue )?vat|^thue gtgt|^tien vat/',
		'kpbt'       => '/kpbt|bao tri/',
		'code'       => '/ma can|can so|^can( ho)?$|^ma$|^can ho so|^so can|^ma sp|ma san pham|^unit/',
		'tower'      => '/^toa|^block|^thap|^phan khu|^khu$/',
		'floor'      => '/^tang/',
		'type'       => '/loai|phong ngu|^pn$|so pn|^type/',
		'area'       => '/dien tich|^dt|thong thuy|tim tuong|m2|m²/',
		'direction'  => '/huong/',
		'view'       => '/view|tam nhin/',
		'price_any'  => '/gia|thanh tien|tong/',
	);
	foreach ( $map as $role => $re ) {
		if ( preg_match( $re, $h ) ) {
			return 'price_any' === $role ? 'price' : $role;
		}
	}
	return '';
}

/** "3.250.000.000", "3,25 tỷ", "3250" (triệu)… → số đồng. */
function hh_units_money( $raw ) {
	$s = hh_units_norm( $raw );
	if ( '' === $s ) {
		return 0;
	}
	$mult = 0;
	if ( preg_match( '/ty/', $s ) ) {
		$mult = 1e9;
	} elseif ( preg_match( '/tr|trieu/', $s ) ) {
		$mult = 1e6;
	}
	$num = preg_replace( '/[^\d.,]/', '', $s );
	if ( '' === $num ) {
		return 0;
	}
	if ( preg_match( '/^\d{1,3}([.,]\d{3})+$/', $num ) ) {
		$num = str_replace( array( '.', ',' ), '', $num ); // Dấu phân cách hàng nghìn.
	} else {
		$num = str_replace( ',', '.', $num );
	}
	$v = (float) $num;
	if ( ! $mult ) {
		$mult = $v >= 1e7 ? 1 : ( $v >= 100 ? 1e6 : 1e9 ); // Đồng / triệu / tỷ.
	}
	return (int) round( $v * $mult );
}

/** Đọc nguồn bảng hàng của dự án và lưu JSON. Trả về số căn hoặc WP_Error. */
function hh_units_refresh( $post_id ) {
	$file  = (int) get_post_meta( $post_id, 'hh_p_units_file', true );
	$sheet = (string) get_post_meta( $post_id, 'hh_p_units_sheet', true );
	if ( ! $file && ! $sheet ) {
		delete_post_meta( $post_id, '_hh_units' );
		return 0;
	}
	if ( $file ) {
		$path = (string) get_attached_file( $file );
		$ext  = strtolower( pathinfo( $path, PATHINFO_EXTENSION ) );
		if ( ! $path || ! file_exists( $path ) ) {
			return new WP_Error( 'file', 'Không tìm thấy file bảng hàng.' );
		}
		$rows = 'xlsx' === $ext ? hh_units_parse_xlsx( $path ) : ( 'csv' === $ext || 'txt' === $ext ? hh_units_parse_csv( file_get_contents( $path ) ) : new WP_Error( 'ext', 'Chỉ đọc được file .xlsx hoặc .csv (file .xls cũ: mở bằng Excel và lưu lại dạng .xlsx).' ) ); // phpcs:ignore
	} else {
		$res = wp_remote_get( hh_units_sheet_csv_url( $sheet ), array( 'timeout' => 20 ) );
		if ( is_wp_error( $res ) || 200 !== wp_remote_retrieve_response_code( $res ) ) {
			return new WP_Error( 'sheet', 'Không tải được Google Sheets – kiểm tra link và quyền chia sẻ "Bất kỳ ai có đường liên kết".' );
		}
		$rows = hh_units_parse_csv( wp_remote_retrieve_body( $res ) );
	}
	if ( is_wp_error( $rows ) ) {
		return $rows;
	}

	// Dòng tiêu đề: dòng đầu tiên có cột mã căn hoặc ≥ 3 cột nhận ra được.
	$head = null;
	foreach ( array_slice( $rows, 0, 15, true ) as $i => $r ) {
		$roles = array_filter( array_map( 'hh_units_role', $r ) );
		if ( in_array( 'code', $roles, true ) || count( $roles ) >= 3 ) {
			$head = $i;
			break;
		}
	}
	if ( null === $head ) {
		return new WP_Error( 'head', 'Không nhận ra dòng tiêu đề. Dòng đầu cần có các cột như: Mã căn, Diện tích, Giá…' );
	}
	$headers  = $rows[ $head ];
	$cols     = array();
	$variants = array();
	foreach ( $headers as $i => $h ) {
		$h = trim( (string) $h );
		if ( '' === $h ) {
			continue;
		}
		$role = hh_units_role( $h );
		if ( 'price' === $role ) {
			$key              = sanitize_title( remove_accents( preg_replace( '/^(gia|giá)\s*/iu', '', $h ) ) ) ?: 'gia';
			$key              = substr( $key, 0, 20 );
			$variants[ $key ] = $h;
			$role             = 'price:' . $key;
		}
		if ( 'skip' !== $role && in_array( $role, array_column( $cols, 'role' ), true ) && 0 !== strpos( $role, 'price:' ) ) {
			$role = ''; // Cột trùng vai trò: giữ làm thông tin thêm.
		}
		$cols[ $i ] = array( 'label' => $h, 'role' => $role );
	}
	if ( ! array_filter( $cols, static fn( $c ) => 'code' === $c['role'] ) ) {
		$first = array_key_first( $cols );
		$cols[ $first ]['role'] = 'code'; // Không có cột "Mã căn": dùng cột đầu tiên.
	}

	$units = array();
	foreach ( array_slice( $rows, $head + 1 ) as $r ) {
		$u = array( 'extra' => array(), 'prices' => array() );
		foreach ( $cols as $i => $c ) {
			$v = trim( (string) ( $r[ $i ] ?? '' ) );
			if ( 0 === strpos( $c['role'], 'price:' ) ) {
				$u['prices'][ substr( $c['role'], 6 ) ] = hh_units_money( $v );
			} elseif ( in_array( $c['role'], array( 'base', 'vat', 'kpbt', 'unit_price' ), true ) ) {
				$u[ $c['role'] ] = hh_units_money( $v );
			} elseif ( 'skip' === $c['role'] ) {
				continue;
			} elseif ( $c['role'] ) {
				$u[ $c['role'] ] = $v;
			} elseif ( '' !== $v ) {
				$u['extra'][ $c['label'] ] = $v;
			}
		}
		if ( empty( $u['code'] ) ) {
			continue;
		}
		$u['code'] = preg_replace( '/\s+/', '', $u['code'] );
		if ( ! array_filter( $u['prices'] ) && ! empty( $u['base'] ) ) {
			$u['prices']['tong'] = $u['base'] + ( $u['vat'] ?? 0 ) + ( $u['kpbt'] ?? 0 );
			$variants           += array( 'tong' => 'Tổng giá' );
		}
		$units[] = $u;
	}
	if ( ! $units ) {
		return new WP_Error( 'empty', 'File không có dòng căn nào có mã căn.' );
	}
	update_post_meta(
		$post_id,
		'_hh_units',
		wp_slash(
			wp_json_encode(
				array(
					'variants' => $variants ?: array( 'tong' => 'Giá bán' ),
					'cols'     => array_values( $cols ),
					'units'    => $units,
					'at'       => time(),
				),
				JSON_UNESCAPED_UNICODE
			)
		)
	);
	return count( $units );
}

/** Đọc lại bảng hàng sau khi lưu dự án (sau khi các ô đã được ghi – ưu tiên 20). */
add_action( 'save_post_du-an', 'hh_units_on_save', 20, 2 );
function hh_units_on_save( $post_id, $post ) {
	if ( wp_is_post_revision( $post_id ) || ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! isset( $_POST['hh_meta_nonce'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		return;
	}
	$result = hh_units_refresh( $post_id );
	if ( is_wp_error( $result ) ) {
		set_transient( 'hh_units_msg_' . get_current_user_id(), array( 'error', 'Bảng tính căn: ' . $result->get_error_message() ), 60 );
	} elseif ( $result ) {
		set_transient( 'hh_units_msg_' . get_current_user_id(), array( 'success', sprintf( 'Bảng tính căn: đã đọc %d căn. Xem trang: %s', $result, hh_units_url( $post_id ) ) ), 60 );
	}
}

add_action( 'admin_notices', 'hh_units_notice' );
function hh_units_notice() {
	$msg = get_transient( 'hh_units_msg_' . get_current_user_id() );
	if ( $msg ) {
		delete_transient( 'hh_units_msg_' . get_current_user_id() );
		printf( '<div class="notice notice-%s is-dismissible"><p>%s</p></div>', esc_attr( $msg[0] ), make_clickable( esc_html( $msg[1] ) ) );
	}
}

/* -------------------------------------------------------------------------
 * Dữ liệu cho trang bảng tính
 * ---------------------------------------------------------------------- */

function hh_units_data( $post_id ) {
	$data = json_decode( (string) get_post_meta( $post_id, '_hh_units', true ), true );
	return is_array( $data ) && ! empty( $data['units'] ) ? $data : null;
}

/** Phương án thanh toán: bảng "Phương án thanh toán"; chưa nhập thì dùng "Lịch thanh toán" của dự án. */
function hh_units_plans( $post_id ) {
	$plans = array();
	foreach ( hh_table( 'hh_p_calc_plans', 5, $post_id ) as list( $code, $name, $disc, $sched, $loan ) ) {
		$steps = array();
		foreach ( preg_split( '/;\s*/', (string) $sched ) as $part ) {
			if ( preg_match( '/^(.*?)[:=]\s*([\d.,]+)\s*%?/u', trim( $part ), $m ) ) {
				$steps[] = array( trim( $m[1] ), (float) str_replace( ',', '.', $m[2] ) );
			}
		}
		$code = sanitize_title( $code ) ?: 'pa' . ( count( $plans ) + 1 );
		$plans[ $code ] = array(
			'name'  => $name ?: $code,
			'disc'  => (float) str_replace( ',', '.', preg_replace( '/[^\d.,]/', '', (string) $disc ) ),
			'steps' => $steps,
			'loan'  => (float) str_replace( ',', '.', preg_replace( '/[^\d.,]/', '', (string) $loan ) ),
		);
	}
	if ( ! $plans ) {
		$steps = array();
		foreach ( hh_table( 'hh_p_payment', 3, $post_id ) as list( $stage, $when, $pct ) ) {
			if ( preg_match( '/([\d.,]+)/', $pct, $m ) ) {
				$steps[] = array( trim( $stage . ( $when ? ' – ' . $when : '' ) ), (float) str_replace( ',', '.', $m[1] ) );
			}
		}
		$plans['chuan'] = array( 'name' => 'Thanh toán theo tiến độ', 'disc' => 0, 'steps' => $steps, 'loan' => 0 );
	}
	return $plans;
}

/** Tính giá, chiết khấu, lịch thanh toán, khoản vay cho 1 căn. */
function hh_units_compute( $post_id, $unit, $variant, $plan ) {
	$vat_rate  = '' !== hh_meta( 'hh_p_vat', $post_id ) ? (float) hh_meta( 'hh_p_vat', $post_id ) : 10;
	$kpbt_rate = '' !== hh_meta( 'hh_p_kpbt', $post_id ) ? (float) hh_meta( 'hh_p_kpbt', $post_id ) : 2;
	$price     = (int) ( $unit['prices'][ $variant ] ?? reset( $unit['prices'] ) ?: 0 );
	$base      = (int) ( $unit['base'] ?? 0 );
	$lines     = array();

	if ( $base ) {
		$vat      = (int) ( $unit['vat'] ?? round( $base * $vat_rate / 100 ) );
		$kpbt     = (int) ( $unit['kpbt'] ?? round( $base * $kpbt_rate / 100 ) );
		$disc     = (int) round( $base * $plan['disc'] / 100 );
		$base_net = $base - $disc;
		$vat_net  = (int) round( $vat * $base_net / max( 1, $base ) );
		$total    = $base_net + $vat_net + $kpbt;
		$lines[]  = array( 'Giá căn hộ chưa VAT, KPBT', $base );
		if ( $disc ) {
			$lines[] = array( 'Chiết khấu ' . rtrim( rtrim( number_format( $plan['disc'], 2, ',', '' ), '0' ), ',' ) . '% (' . $plan['name'] . ')', -$disc );
			$lines[] = array( 'Giá sau chiết khấu chưa VAT', $base_net );
		}
		$lines[] = array( 'Thuế VAT', $vat_net );
		$lines[] = array( 'Kinh phí bảo trì (KPBT)', $kpbt );
	} else {
		$disc    = (int) round( $price * $plan['disc'] / 100 );
		$total   = $price - $disc;
		$kpbt    = 0;
		$lines[] = array( 'Giá bán', $price );
		if ( $disc ) {
			$lines[] = array( 'Chiết khấu ' . rtrim( rtrim( number_format( $plan['disc'], 2, ',', '' ), '0' ), ',' ) . '% (' . $plan['name'] . ')', -$disc );
		}
	}

	// Lịch thanh toán tính trên tổng giá trị trừ KPBT (KPBT thường nộp khi nhận nhà).
	$payable  = $total - $kpbt;
	$schedule = array();
	foreach ( $plan['steps'] as list( $label, $pct ) ) {
		$schedule[] = array( $label, $pct, (int) round( $payable * $pct / 100 ) );
	}
	if ( $kpbt && $schedule ) {
		$schedule[] = array( 'Kinh phí bảo trì (khi nhận nhà)', null, $kpbt );
	}

	$loan = null;
	if ( $plan['loan'] > 0 ) {
		$amount = (int) round( $payable * $plan['loan'] / 100 );
		$rate   = '' !== hh_meta( 'hh_p_loan_rate_float', $post_id ) ? (float) hh_meta( 'hh_p_loan_rate_float', $post_id ) : 10;
		$years  = '' !== hh_meta( 'hh_p_loan_years', $post_id ) ? (float) hh_meta( 'hh_p_loan_years', $post_id ) : 20;
		$grace  = (int) hh_meta( 'hh_p_loan_grace', $post_id );
		$n      = max( 1, (int) round( $years * 12 ) - $grace );
		$r      = $rate / 100 / 12;
		$month  = $r > 0 ? $amount * $r / ( 1 - pow( 1 + $r, -$n ) ) : $amount / $n;
		$loan   = array(
			'amount' => $amount,
			'equity' => $total - $amount,
			'rate'   => $rate,
			'years'  => $years,
			'grace'  => $grace,
			'zero'   => (int) hh_meta( 'hh_p_loan_zero_months', $post_id ),
			'bank'   => hh_meta( 'hh_p_loan_bank', $post_id ),
			'month'  => (int) round( $month ),
		);
	}
	return array( 'lines' => $lines, 'total' => $total, 'schedule' => $schedule, 'loan' => $loan );
}

/** 3.250.000.000 đ → "3,25 tỷ"; dưới 1 tỷ → "850 triệu". */
function hh_units_vnd( $v, $exact = false ) {
	if ( $exact ) {
		return number_format( (float) $v, 0, ',', '.' ) . ' đ';
	}
	$a = abs( $v );
	$s = $a >= 1e9 ? rtrim( rtrim( number_format( $a / 1e9, 2, ',', '.' ), '0' ), ',' ) . ' tỷ' : number_format( $a / 1e6, 0, ',', '.' ) . ' triệu';
	return ( $v < 0 ? '−' : '' ) . $s;
}
