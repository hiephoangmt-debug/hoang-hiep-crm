<?php
/**
 * Bảng tính căn: đọc file của chủ đầu tư (bảng hàng và/hoặc phiếu tính giá – .xlsx, .xls, .csv, Google Sheets), lưu sẵn dạng JSON,
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
		'code'       => '/ma can|can so|^can( ho)?$|^ma$|^can ho so|^so can|^ma sp|ma san pham|^unit|^lo$|^ma lo|^so lo|^ma nha/',
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

/** Ô là số (giá trị gốc của Excel)? */
function hh_units_is_num( $v ) {
	return '' !== $v && is_numeric( $v );
}

/** Số ngày Excel (VD 46295) → "30/09/2026". */
function hh_units_xl_date( $v ) {
	$n = (float) $v;
	return $n > 36000 && $n < 80000 ? gmdate( 'd/m/Y', (int) round( ( $n - 25569 ) * 86400 ) ) : '';
}

/** Chữ hoa → chữ thường đầu câu, giữ các viết tắt quen thuộc. */
function hh_units_sentence( $s ) {
	$s = trim( preg_replace( '/\s+/u', ' ', str_replace( '_', '–', (string) $s ) ) );
	if ( '' === $s || mb_strtoupper( $s ) !== $s ) {
		return $s;
	}
	$s = preg_replace( '/(?<![\p{L}])ko(?![\p{L}])/u', 'không', mb_strtolower( $s ) );
	$s = preg_replace( '/^(nhanh|sớm)/u', 'thanh toán $1', $s );
	$s = preg_replace_callback(
		'/(?<![\p{L}])(tcbg|vat|kpbt|hđmb|hđthnv|ttđc|csbh|tts|ttn|gcn|tbbg|nh|kh|cđt|stu|\d*br)(?![\p{L}])/u',
		static fn( $m ) => mb_strtoupper( $m[1] ),
		$s
	);
	return mb_strtoupper( mb_substr( $s, 0, 1 ) ) . mb_substr( $s, 1 );
}

/** Dòng → [chỉ số => ô] chỉ gồm các ô có nội dung. */
function hh_units_cells( $row ) {
	return array_filter( array_map( 'trim', (array) $row ), 'strlen' );
}

/* -------------------------------------------------------------------------
 * Trang tính dạng bảng hàng (mỗi dòng 1 căn)
 * ---------------------------------------------------------------------- */

function hh_units_parse_table( $rows ) {
	$head = null;
	foreach ( array_slice( $rows, 0, 15, true ) as $i => $r ) {
		$roles = array_filter( array_map( 'hh_units_role', $r ) );
		if ( in_array( 'code', $roles, true ) || count( $roles ) >= 3 ) {
			$head = $i;
			break;
		}
	}
	if ( null === $head ) {
		return null;
	}
	$cols     = array();
	$variants = array();
	foreach ( $rows[ $head ] as $i => $h ) {
		$h = trim( preg_replace( '/\s+/u', ' ', (string) $h ) );
		if ( '' === $h ) {
			continue;
		}
		$role = hh_units_role( $h );
		if ( 'price' === $role ) {
			$key              = substr( sanitize_title( remove_accents( preg_replace( '/^(gia|giá)\s*/iu', '', $h ) ) ) ?: 'gia', 0, 20 );
			$variants[ $key ] = $h;
			$role             = 'price:' . $key;
		}
		if ( 'skip' !== $role && in_array( $role, array_column( $cols, 'role' ), true ) && 0 !== strpos( $role, 'price:' ) ) {
			$role = ''; // Cột trùng vai trò: giữ làm thông tin thêm.
		}
		$cols[ $i ] = array( 'label' => $h, 'role' => $role );
	}
	if ( ! $cols ) {
		return null;
	}
	if ( ! array_filter( $cols, static fn( $c ) => 'code' === $c['role'] ) ) {
		$cols[ array_key_first( $cols ) ]['role'] = 'code'; // Không có cột "Mã căn": dùng cột đầu tiên.
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
			} elseif ( 'area' === $c['role'] && hh_units_is_num( $v ) ) {
				$u['area'] = rtrim( rtrim( number_format( (float) $v, 2, ',', '.' ), '0' ), ',' );
			} elseif ( $c['role'] ) {
				$u[ $c['role'] ] = $v;
			} elseif ( '' !== $v ) {
				$u['extra'][ $c['label'] ] = $v;
			}
		}
		$u['code'] = preg_replace( '/\s+/', '', (string) ( $u['code'] ?? '' ) );
		// Bỏ dòng trống, dòng chỉ có số thứ tự, dòng tổng.
		if ( '' === $u['code'] || ( hh_units_is_num( $u['code'] ) && ! array_filter( $u['prices'] ) && empty( $u['base'] ) ) || preg_match( '/^(tong|cong)/', hh_units_norm( $u['code'] ) ) ) {
			continue;
		}
		if ( ! array_filter( $u['prices'] ) && ! empty( $u['base'] ) ) {
			$u['prices']['tong'] = $u['base'] + ( $u['vat'] ?? 0 ) + ( $u['kpbt'] ?? 0 );
			$variants           += array( 'tong' => 'Tổng giá' );
		}
		$units[] = $u;
	}
	return $units ? array( 'variants' => $variants ?: array( 'tong' => 'Giá bán' ), 'cols' => array_values( $cols ), 'units' => $units ) : null;
}

/* -------------------------------------------------------------------------
 * Trang tính dạng "phiếu tính giá" của chủ đầu tư
 * (1 căn mẫu + chiết khấu + 1 hoặc nhiều tiến độ thanh toán)
 * ---------------------------------------------------------------------- */

function hh_units_is_slip( $rows ) {
	foreach ( array_slice( $rows, 0, 120 ) as $r ) {
		foreach ( hh_units_cells( $r ) as $v ) {
			if ( preg_match( '/phieu tinh gia|tien do thanh toan/', hh_units_norm( $v ) ) ) {
				return true;
			}
		}
	}
	return false;
}

/** Dòng tiêu đề của một bảng tiến độ thanh toán? Trả về chỉ số cột chứa chữ "tiến độ thanh toán" hoặc null. */
function hh_units_sched_head( $rows, $i ) {
	$cells = hh_units_cells( $rows[ $i ] ?? array() );
	$col   = null;
	$other = false;
	foreach ( $cells as $c => $v ) {
		$n = hh_units_norm( $v );
		if ( null === $col && preg_match( '/tien do thanh toan/', $n ) ) {
			$col = $c;
		} elseif ( preg_match( '/thoi han|% thanh toan|so tien|gia tri thanh toan|tien do chuan|ty le/', $n ) ) {
			$other = true;
		}
	}
	return null !== $col && $other ? $col : null;
}

function hh_units_parse_slip( $sheet_name, $rows ) {
	$policy = '';
	$sub    = '';
	foreach ( array_slice( $rows, 0, 6 ) as $r ) {
		foreach ( hh_units_cells( $r ) as $v ) {
			$n = hh_units_norm( $v );
			if ( preg_match( '/chinh sach ban hang/', $n ) ) {
				$policy = trim( preg_replace( '/^.*?(chính sách bán hàng|chinh sach ban hang)\s*(số|so)?\s*:?\s*/iu', '', $v ) );
			} elseif ( preg_match( '/^\s*(CSBH[^\-–]*?)\s*[-–]\s*(.+)$/u', $v, $m ) ) {
				$policy = trim( $m[1] );
				$sub    = trim( $m[2] );
			}
		}
	}
	$sub = trim( preg_replace( '/(?<![\p{L}])[IVX]+(?:\.\d+)+\.?\s*/u', '', $sub ), " -–\t" );

	// 1. Thông tin căn mẫu và các dòng giá (đến bảng tiến độ / thanh toán sớm đầu tiên).
	$sample = array( 'extra' => array() );
	$price  = array( 'list' => 0, 'pre' => 0, 'total' => 0, 'vat' => null, 'kpbt' => null );
	$labels = array();
	$disc   = array();
	$valcol = null;
	$stop   = count( $rows );
	foreach ( $rows as $i => $r ) {
		if ( null !== hh_units_sched_head( $rows, $i ) ) {
			$stop = $i;
			break;
		}
		$cells = hh_units_cells( $r );
		$lc    = null;
		foreach ( $cells as $c => $v ) {
			if ( $c <= 2 && ! hh_units_is_num( $v ) && mb_strlen( $v ) > 1 ) {
				$lc = $c;
				break;
			}
		}
		if ( null === $lc ) {
			continue;
		}
		$raw = trim( preg_replace( '/\s+/u', ' ', preg_replace( '/^\d+[.)]\s*/', '', $cells[ $lc ] ) ) );
		$l   = hh_units_norm( $raw );
		if ( preg_match( '/thanh toan som/', $l ) && preg_match( '/^[ivx]+\./', hh_units_norm( $cells[ $lc ] ) ) ) {
			$stop = $i;
			break;
		}
		$after = array_filter( $cells, static fn( $c ) => $c > $lc, ARRAY_FILTER_USE_KEY );
		$first = $after ? reset( $after ) : '';
		$fn    = hh_units_norm( $first );

		// Thông tin căn.
		if ( preg_match( '/^(ma can|ma nha|ma san pham|ma lo|can so)/', $l ) && '' !== $first ) {
			$sample['code'] = preg_replace( '/\s+/', '', $first );
			continue;
		}
		if ( preg_match( '/^(toa|block|phan khu)( nha)?:?$/', $l ) && '' !== $first ) {
			$sample['tower'] = $first;
			continue;
		}
		if ( preg_match( '/^tang:?$/', $l ) && '' !== $first ) {
			$sample['floor'] = $first;
			continue;
		}
		if ( preg_match( '/^loai (hinh|can|san pham|nha)/', $l ) && '' !== $first ) {
			$sample['type'] = $first;
			continue;
		}
		if ( preg_match( '/dien tich/', $l ) && hh_units_is_num( $first ) ) {
			$area = rtrim( rtrim( number_format( (float) $first, 2, ',', '.' ), '0' ), ',' );
			if ( empty( $sample['area'] ) && ! preg_match( '/^tong dien tich|san xay dung/', $l ) ) {
				$sample['area'] = $area;
			} else {
				$sample['extra'][ preg_replace( '/\s*\(m2\)/i', '', $raw ) ] = $area . ' m²';
			}
			continue;
		}
		if ( preg_match( '/hinh thuc (nhan|nhân)? ?ban giao|hinh thuc ban giao/', $l ) && '' !== $first ) {
			$sample['extra']['Hình thức bàn giao'] = $first;
			continue;
		}

		// Các dòng giá.
		$nums = array();
		foreach ( $after as $c => $v ) {
			if ( hh_units_is_num( $v ) && ( null === $valcol || $c <= $valcol ) ) {
				$nums[ $c ] = (float) $v;
			}
		}
		if ( ! $nums ) {
			continue;
		}
		$big = array_filter( $nums, static fn( $x ) => abs( $x ) >= 1000 );
		$amt = null;
		if ( null !== $valcol ) {
			$amt = $nums[ $valcol ] ?? null;
		} elseif ( $big ) {
			$amt = end( $big );
		}
		$rates = array_filter( $nums, static fn( $x ) => abs( $x ) > 0 && abs( $x ) < 1 );
		$rate  = $rates ? abs( (float) reset( $rates ) ) : null;

		$is_pre = preg_match( '/chua (gom |bao gom )?(vat|thue)/', $l );
		if ( ! $price['list'] && $big && ( preg_match( '/niem yet/', $l ) || ( preg_match( '/truoc chiet khau/', $l ) && ! $is_pre ) ) ) {
			$valcol          = array_key_last( $big );
			$price['list']   = (float) end( $big );
			$labels['list']  = $raw;
			continue;
		}
		if ( ! $price['list'] ) {
			continue;
		}
		if ( $is_pre && preg_match( '/truoc chiet khau/', $l ) ) {
			$price['pre']   = (float) $amt;
			$labels['pre']  = $raw;
		} elseif ( $is_pre && preg_match( '/sau chiet khau/', $l ) ) {
			$labels['net'] = $raw;
		} elseif ( preg_match( '/sau chiet khau|tong gia tri khach hang|phai thanh toan/', $l ) ) {
			$price['total']  = (float) $amt;
			$labels['total'] = $raw;
		} elseif ( preg_match( '/^(thue )?vat|thue gtgt/', $l ) ) {
			$price['vat']  = $rate;
			$labels['vat'] = $raw;
		} elseif ( preg_match( '/kinh phi bao tri|kpbt|phi bao tri/', $l ) ) {
			$price['kpbt']  = $rate;
			$labels['kpbt'] = $raw;
		} elseif ( preg_match( '/chiet khau|qua tang|giam gia|uu dai|chinh sach tai chinh|ho tro/', $l ) ) {
			$amount = abs( (float) $amt );
			if ( ! $amount && ! $rate ) {
				continue;
			}
			$base_label = trim( preg_replace( '/\s*\([^)]*\/[^)]*\)/u', '', $raw ) ); // Bỏ phần lựa chọn "(Vay / Không vay)".
			$bl         = hh_units_norm( $base_label );
			$qual       = '';
			foreach ( $after as $c => $v ) {
				$vn = hh_units_norm( $v );
				if ( $c >= ( $valcol ?? PHP_INT_MAX ) || hh_units_is_num( $v ) || preg_match( '/^(co thoi han|duoc ap dung|khong duoc ap dung|hdthnv|hdmb|ttdc|vnd|check|ap dung)$/', $vn ) || false !== strpos( $bl, $vn ) ) {
					continue;
				}
				preg_match_all( '/\d+/', $vn, $dg );
				if ( $dg[0] && ! array_filter( $dg[0], static fn( $x ) => false === strpos( $bl, $x ) ) ) {
					continue; // VD "TTS 95%" khi nhãn đã ghi "thanh toán sớm 95%".
				}
				$qual = $v;
				break;
			}
			$label  = $base_label . ( $qual ? ' – ' . $qual : '' );
			$disc[] = array(
				'label'  => $label,
				'rate'   => $rate,
				'amount' => $amount,
				'opt'    => (bool) ( preg_match( '/than thiet|tin cay|gioi thieu|nhan vien|cbnv|khach hang cu|tri an/', $l ) || null === $rate ),
				'def'    => ! preg_match( '/than thiet|tin cay|gioi thieu|nhan vien|cbnv|khach hang cu|tri an/', $l ),
			);
		}
	}
	if ( ! $price['list'] ) {
		return null;
	}
	$sample['list'] = $price['list'];

	// Kiểu tính: chiết khấu trên giá chưa VAT & KPBT ("pre") hay trên tổng giá gồm VAT ("gross").
	$mode  = $price['pre'] && null !== $price['vat'] ? 'pre' : 'gross';
	$ratio = 'pre' === $mode ? $price['pre'] / $price['list'] : 1;
	if ( 'pre' === $mode && abs( $ratio - 1 / ( 1 + $price['vat'] + (float) $price['kpbt'] ) ) < 1e-6 ) {
		$ratio = 1 / ( 1 + $price['vat'] + (float) $price['kpbt'] ); // Phiếu làm tròn giá chưa VAT: dùng tỷ lệ đúng.
	}
	$base0 = $price['list'] * $ratio;
	$run   = $base0;
	foreach ( $disc as $k => $d ) {
		if ( null !== $d['rate'] ) {
			$disc[ $k ]['seq'] = abs( $d['amount'] - $d['rate'] * $run ) <= abs( $d['amount'] - $d['rate'] * $base0 );
			if ( ! $d['amount'] ) {
				$disc[ $k ]['amount'] = round( $d['rate'] * $run );
			}
		}
		$run -= $disc[ $k ]['amount'];
	}
	$calc_total = 'pre' === $mode ? $run * ( 1 + (float) $price['vat'] + (float) $price['kpbt'] ) : $run;
	$total      = $price['total'] ?: $calc_total;

	// Bảng cọc theo loại căn (VD: STU 100 triệu, 3BR 150 triệu) nằm bên phải phiếu.
	$dep_types = array();
	foreach ( array_slice( $rows, 0, $stop ) as $r ) {
		foreach ( $r as $c => $v ) {
			$v = trim( (string) $v );
			$n = trim( (string) ( $r[ $c + 1 ] ?? '' ) );
			if ( null !== $valcol && $c > $valcol && '' !== $v && ! hh_units_is_num( $v ) && mb_strlen( $v ) <= 8 && hh_units_is_num( $n ) && (float) $n >= 1e7 && (float) $n < 2e10 ) {
				$dep_types[ strtoupper( $v ) ] = (float) $n;
			}
		}
	}
	if ( count( $dep_types ) < 2 ) {
		$dep_types = array();
	}

	// 2. Các bảng tiến độ thanh toán.
	$blocks = array();
	$n_rows = count( $rows );
	for ( $i = $stop; $i < $n_rows; $i++ ) {
		$lc = hh_units_sched_head( $rows, $i );
		if ( null === $lc ) {
			continue;
		}
		$head  = hh_units_cells( $rows[ $i ] );
		$title = trim( preg_replace( '/^.*?ti[ếe]n đ[ộo] thanh to[áa]n\s*/iu', '', preg_replace( '/^[IVX]+\.\s*/u', '', $head[ $lc ] ) ) );
		$roles = array();
		$subs  = array( $head );
		$next  = hh_units_cells( $rows[ $i + 1 ] ?? array() );
		$has_sub = false;
		foreach ( $next as $v ) {
			if ( preg_match( '/khach hang thanh toan|ngan hang giai ngan/', hh_units_norm( $v ) ) ) {
				$has_sub = true;
			}
		}
		if ( $has_sub ) {
			$subs[] = $next;
		}
		foreach ( $subs as $cells ) {
			foreach ( $cells as $c => $v ) {
				if ( $c === $lc && $cells === $head ) {
					continue;
				}
				$n = hh_units_norm( $v );
				if ( preg_match( '/^cong$|ghi chu|dong som|^lai /', $n ) ) {
					$roles[ $c ] = 'stop';
				} elseif ( preg_match( '/% thanh toan|^ty le/', $n ) ) {
					$roles[ $c ] = 'pct';
				} elseif ( preg_match( '/thoi han|tien do chuan|ngay thanh toan|thoi diem/', $n ) ) {
					$roles[ $c ] = 'date';
				} elseif ( preg_match( '/ngan hang giai ngan/', $n ) ) {
					$roles[ $c ] = 'bank';
				} elseif ( preg_match( '/so tien|khach hang thanh toan|gia tri thanh toan/', $n ) ) {
					$roles[ $c ] = 'amt';
				}
			}
		}
		$amt_col  = array_search( 'amt', $roles, true );
		$bank_col = array_search( 'bank', $roles, true );
		$pct_col  = array_search( 'pct', $roles, true );
		$date_col = array_search( 'date', $roles, true );
		if ( false === $amt_col ) {
			continue;
		}
		$items = array();
		for ( $j = $i + ( $has_sub ? 2 : 1 ); $j < $n_rows; $j++ ) {
			if ( null !== hh_units_sched_head( $rows, $j ) ) {
				break;
			}
			$r     = $rows[ $j ];
			$cells = hh_units_cells( $r );
			if ( ! $cells ) {
				continue;
			}
			$label = trim( (string) ( $r[ $lc ] ?? '' ) );
			$first = hh_units_norm( reset( $cells ) );
			if ( preg_match( '/^(tong cong|tong gia tri|tong so tien|lap bieu|quy kh|ten chu tai khoan|luu y)/', $first ) || preg_match( '/^[ivx]+\.\s/', $first ) ) {
				break;
			}
			$pc = false !== $pct_col ? trim( (string) ( $r[ $pct_col ] ?? '' ) ) : '';
			if ( '' === $label && '' !== $pc && ! hh_units_is_num( $pc ) ) {
				$label = $pc;
				$pc    = '';
			}
			if ( '' === $label ) {
				continue;
			}
			$a     = trim( (string) ( $r[ $amt_col ] ?? '' ) );
			$b     = false !== $bank_col ? trim( (string) ( $r[ $bank_col ] ?? '' ) ) : '';
			$d     = false !== $date_col ? trim( (string) ( $r[ $date_col ] ?? '' ) ) : '';
			$lines = array_values( array_filter( array_map( 'trim', preg_split( '/\R/u', $label ) ) ) );
			$name  = $lines[0];
			$when  = hh_units_is_num( $d ) ? hh_units_xl_date( $d ) : $d;
			$ln    = hh_units_norm( $label );
			if ( ! hh_units_is_num( $a ) && ! hh_units_is_num( $b ) ) {
				// Mốc (ký HĐMB, nhận bàn giao…) – không có số tiền.
				$items[] = array( 'label' => preg_replace( '/\s+/u', ' ', $label ), 'when' => $when, 'milestone' => true );
				continue;
			}
			if ( count( $lines ) > 1 ) {
				$rest = implode( ' ', array_slice( $lines, 1 ) );
				if ( preg_match( '/^(ngay|theo|du kien|thang)/', hh_units_norm( $rest ) ) ) {
					$when = $rest;
				} else {
					$name .= ( substr_count( $name, '(' ) > substr_count( $name, ')' ) ? ' ' : ' – ' ) . $rest;
				}
			}
			$pct = null;
			if ( hh_units_is_num( $pc ) && (float) $pc > 0 && (float) $pc <= 1 ) {
				$pct = (float) $pc * 100;
			} elseif ( preg_match( '/(\d+(?:[.,]\d+)?)\s*%/u', $lines[0], $m ) ) {
				$pct = (float) str_replace( ',', '.', $m[1] );
			}
			if ( '' !== $pc && ! hh_units_is_num( $pc ) && ! preg_match( '/^(dat coc|du kien)$/', hh_units_norm( $pc ) ) ) {
				$name .= ' – ' . $pc;
			}
			$items[] = array(
				'label'   => preg_replace( '/\s+/u', ' ', $name ),
				'when'    => preg_replace( '/\s+/u', ' ', (string) $when ),
				'party'   => ( ! hh_units_is_num( $a ) && hh_units_is_num( $b ) ) || preg_match( '/ngan hang giai ngan/', $ln ) ? 'nh' : 'kh',
				'deposit' => (bool) preg_match( '/dat coc/', $ln . ' ' . hh_units_norm( $pc ) ),
				'value'   => abs( (float) ( hh_units_is_num( $a ) ? $a : $b ) ),
				'pct'     => $pct,
			);
		}
		$pays = array_filter( $items, static fn( $it ) => empty( $it['milestone'] ) );
		if ( ! $pays ) {
			continue;
		}
		$sum      = array_sum( array_column( $pays, 'value' ) );
		$by_value = $total > 0 && abs( $sum - $total ) <= $total * 0.005;
		$pct_sum  = array_sum( array_map( static fn( $it ) => $it['deposit'] ? 0 : (float) $it['pct'], $pays ) );
		if ( ! $by_value && abs( $pct_sum - 100 ) > 1 ) {
			continue; // Không đủ dữ liệu để tính lại.
		}
		$name = $title ? hh_units_sentence( $title ) : '';
		if ( '' === $name || preg_match( '/^\(?\s*\)?$/', $name ) ) {
			$name = $sub ?: $sheet_name;
		}
		$blocks[] = array( 'name' => $name, 'items' => $items, 'by_value' => $by_value );
	}

	// Tiền cọc: lấy từ bảng có số tiền thật.
	$deposit = 0;
	foreach ( $blocks as $b ) {
		foreach ( $b['items'] as $it ) {
			if ( $b['by_value'] && ! empty( $it['deposit'] ) && $it['value'] ) {
				$deposit = $deposit ?: $it['value'];
			}
		}
	}

	$scope = '';
	if ( ! empty( $sample['code'] ) && preg_match( '/^[A-Za-z]{1,4}$/', trim( $sheet_name ) ) && 0 === stripos( $sample['code'], trim( $sheet_name ) ) ) {
		$scope = strtoupper( trim( $sheet_name ) );
	}

	$plans = array();
	foreach ( $blocks as $b ) {
		$rows_out  = array();
		$dep_share = 0;
		foreach ( $b['items'] as $it ) {
			if ( ! empty( $it['milestone'] ) ) {
				$rows_out[] = $it;
				continue;
			}
			$share = $b['by_value'] ? $it['value'] / $total : ( $it['deposit'] ? 0 : (float) $it['pct'] / 100 );
			if ( $it['deposit'] ) {
				$dep_share = $b['by_value'] ? $share : 0;
			}
			$rows_out[] = array(
				'label'   => $it['label'],
				'when'    => $it['when'],
				'party'   => $it['party'],
				'deposit' => $it['deposit'],
				'share'   => $share,
				'pct'     => $it['deposit'] ? null : $it['pct'],
			);
		}
		$loan    = array_sum( array_map( static fn( $x ) => empty( $x['milestone'] ) && 'nh' === $x['party'] ? $x['share'] : 0, $rows_out ) );
		$scope_names = array( 'SL' => 'Song lập', 'BT' => 'Biệt thự', 'DL' => 'Đơn lập', 'SH' => 'Shophouse', 'LK' => 'Liền kề', 'NP' => 'Nhà phố', 'TM' => 'Thương mại', 'CH' => 'Căn hộ' );
		$plans[]     = array(
			'kind'      => 'slip',
			'name'      => preg_replace( array( '/^TTS(?![\p{L}])/u', '/^TTN(?![\p{L}])/u' ), array( 'Thanh toán sớm', 'Thanh toán nhanh' ), $b['name'] ),
			'group'     => $scope ? ( isset( $scope_names[ $scope ] ) ? $scope_names[ $scope ] . ' (' . $scope . ')' : $scope ) : ( $policy ?: $sheet_name ),
			'sheet'     => $sheet_name,
			'policy'    => $policy,
			'scope'     => $scope,
			'mode'      => $mode,
			'ratio'     => $ratio,
			'vat'       => (float) $price['vat'],
			'kpbt'      => (float) $price['kpbt'],
			'labels'    => $labels,
			'discounts' => $disc,
			'deposit'   => $deposit,
			'dep_types' => $dep_types,
			'dep_share' => $dep_share,
			'rows'      => $rows_out,
			'disc'      => 0,
			'loan'      => round( $loan * 100, 2 ),
			'sample'    => array(
				'code'  => $sample['code'] ?? '',
				'type'  => $sample['type'] ?? '',
				'list'  => $price['list'],
				'total' => $total,
			),
			'check'     => $total > 0 ? abs( $calc_total - $total ) / $total : 1,
		);
	}
	$sample['prices'] = array( 'gia' => (int) round( $price['list'] ) );
	$sample['code']   = $sample['code'] ?? '';
	return array( 'plans' => $plans, 'sample' => $sample );
}

/* -------------------------------------------------------------------------
 * Đọc nguồn của dự án và lưu JSON
 * ---------------------------------------------------------------------- */

/** File đính kèm của dự án (một hoặc nhiều, cách nhau dấu phẩy). */
function hh_units_files( $post_id ) {
	return array_values( array_filter( array_map( 'absint', explode( ',', (string) get_post_meta( $post_id, 'hh_p_units_file', true ) ) ) ) );
}

/** Đọc toàn bộ nguồn của dự án. Trả về array( số căn, số phương án ) hoặc WP_Error. */
function hh_units_refresh( $post_id ) {
	$files = hh_units_files( $post_id );
	$sheet = (string) get_post_meta( $post_id, 'hh_p_units_sheet', true );
	if ( ! $files && ! $sheet ) {
		delete_post_meta( $post_id, '_hh_units' );
		return array( 0, 0 );
	}
	$books = array();
	foreach ( $files as $fid ) {
		$path = (string) get_attached_file( $fid );
		if ( ! $path || ! file_exists( $path ) ) {
			return new WP_Error( 'file', 'Không tìm thấy file ' . wp_basename( $path ?: '#' . $fid ) . '.' );
		}
		$wb = hh_units_read_workbook( $path );
		if ( is_wp_error( $wb ) ) {
			return new WP_Error( 'file', wp_basename( $path ) . ': ' . $wb->get_error_message() );
		}
		$books[] = array( wp_basename( $path ), $wb );
	}
	if ( $sheet ) {
		$res = wp_remote_get( hh_units_sheet_csv_url( $sheet ), array( 'timeout' => 20 ) );
		if ( is_wp_error( $res ) || 200 !== wp_remote_retrieve_response_code( $res ) ) {
			return new WP_Error( 'sheet', 'Không tải được Google Sheets – kiểm tra link và quyền chia sẻ "Bất kỳ ai có đường liên kết".' );
		}
		$books[] = array( 'Google Sheets', array( array( 'name' => 'Google Sheets', 'hidden' => false, 'rows' => hh_units_parse_csv( wp_remote_retrieve_body( $res ) ) ) ) );
	}

	$variants = array();
	$cols     = array();
	$units    = array();
	$plans    = array();
	$samples  = array();
	$sources  = array();
	foreach ( $books as list( $fname, $wb ) ) {
		foreach ( $wb as $s ) {
			if ( ! array_filter( array_map( 'hh_units_cells', $s['rows'] ) ) ) {
				continue;
			}
			if ( hh_units_is_slip( $s['rows'] ) ) {
				$slip = hh_units_parse_slip( $s['name'], $s['rows'] );
				if ( $slip && $slip['plans'] ) {
					foreach ( $slip['plans'] as $p ) {
						$key = substr( sanitize_title( remove_accents( ( $p['scope'] ? $p['scope'] . ' ' : '' ) . $p['name'] ) ), 0, 40 ) ?: 'pa';
						$k   = $key;
						for ( $n = 2; isset( $plans[ $k ] ); $n++ ) {
							$k = $key . '-' . $n;
						}
						$plans[ $k ] = $p;
					}
					$samples[] = $slip['sample'];
					$sources[] = $fname . ' › ' . $s['name'] . ': ' . count( $slip['plans'] ) . ' phương án';
				}
				continue;
			}
			$table = hh_units_parse_table( $s['rows'] );
			if ( $table ) {
				$variants += $table['variants'];
				$cols      = $cols ?: $table['cols'];
				$units     = array_merge( $units, $table['units'] );
				$sources[] = $fname . ' › ' . $s['name'] . ': ' . count( $table['units'] ) . ' căn';
			}
		}
	}
	if ( ! $units && ! $plans ) {
		return new WP_Error( 'empty', 'Không tìm thấy danh sách căn (cột Mã căn, Diện tích, Giá…) hay phiếu tính giá (giá niêm yết, chiết khấu, tiến độ thanh toán) trong file.' );
	}
	update_post_meta(
		$post_id,
		'_hh_units',
		wp_slash(
			wp_json_encode(
				array(
					'variants' => $variants ?: ( $units ? array( 'tong' => 'Giá bán' ) : array() ),
					'cols'     => $cols,
					'units'    => $units,
					'plans'    => $plans,
					'samples'  => $samples,
					'sources'  => $sources,
					'at'       => time(),
				),
				JSON_UNESCAPED_UNICODE
			)
		)
	);
	return array( count( $units ), count( $plans ) );
}

/** Đọc lại sau khi lưu dự án (sau khi các ô đã được ghi – ưu tiên 20). */
add_action( 'save_post_du-an', 'hh_units_on_save', 20, 2 );
function hh_units_on_save( $post_id, $post ) {
	if ( wp_is_post_revision( $post_id ) || ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! isset( $_POST['hh_meta_nonce'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		return;
	}
	$result = hh_units_refresh( $post_id );
	if ( is_wp_error( $result ) ) {
		set_transient( 'hh_units_msg_' . get_current_user_id(), array( 'error', 'Bảng tính căn: ' . $result->get_error_message() ), 60 );
	} elseif ( array_sum( $result ) ) {
		$data = hh_units_data( $post_id );
		$warn = hh_units_warnings( $data );
		set_transient(
			'hh_units_msg_' . get_current_user_id(),
			array(
				$warn ? 'warning' : 'success',
				sprintf( 'Bảng tính căn: đã đọc %s. Chi tiết: %s.%s Xem trang: %s', hh_units_summary( $data ), implode( '; ', $data['sources'] ?? array() ), $warn ? ' Lưu ý: tổng tiền tính lại chưa khớp phiếu mẫu ở phương án ' . implode( ', ', array_unique( $warn ) ) . ' – kiểm tra lại trên trang.' : '', hh_units_url( $post_id ) ),
			),
			60
		);
	}
}

/** Phương án tính lại chưa khớp tổng tiền của phiếu mẫu. */
function hh_units_warnings( $data ) {
	$warn = array();
	foreach ( (array) ( $data['plans'] ?? array() ) as $p ) {
		if ( ( $p['check'] ?? 0 ) > 0.002 ) {
			$warn[] = $p['name'];
		}
	}
	return array_unique( $warn );
}

/** Ô trạng thái + nút "Đọc file" trong tab Bảng tính căn (trình soạn thảo khối không hiện thông báo sau khi lưu). */
add_action( 'hh_meta_panel_end', 'hh_units_admin_panel', 10, 2 );
function hh_units_admin_panel( $group_id, $post ) {
	if ( 'bang-tinh' !== $group_id ) {
		return;
	}
	printf(
		'<div class="hh-units-read" data-post="%d" data-nonce="%s"><p><button type="button" class="button button-primary hh-units-read__go">Đọc file &amp; tạo trang bảng tính</button> <span class="hh-units-read__hint">Chọn file ở trên rồi bấm nút này – không cần chờ bấm Cập nhật.</span></p><div class="hh-units-read__out">%s</div></div>',
		(int) $post->ID,
		esc_attr( wp_create_nonce( 'hh_units_read' ) ),
		hh_units_admin_status( $post->ID ) // phpcs:ignore WordPress.Security.EscapeOutput -- đã escape bên trong.
	);
}

function hh_units_admin_status( $post_id ) {
	$data = hh_units_data( $post_id );
	if ( ! $data ) {
		return '<p class="hh-units-read__empty">Chưa kết nối bảng tính: chưa đọc được file nào cho dự án này.</p>';
	}
	$out  = sprintf( '<p class="hh-units-read__ok"><strong>Đã kết nối:</strong> %s – đọc lúc %s.</p>', esc_html( hh_units_summary( $data ) ), esc_html( wp_date( 'H:i d/m/Y', (int) $data['at'] ) ) );
	$out .= '<ul class="hh-units-read__list">';
	foreach ( (array) ( $data['sources'] ?? array() ) as $src ) {
		$out .= '<li>' . esc_html( $src ) . '</li>';
	}
	$out .= '</ul>';
	$warn = hh_units_warnings( $data );
	if ( $warn ) {
		$out .= '<p class="hh-units-read__warn">Lưu ý: tổng tiền tính lại chưa khớp phiếu mẫu ở phương án ' . esc_html( implode( ', ', $warn ) ) . ' – kiểm tra lại trên trang.</p>';
	}
	if ( 'publish' === get_post_status( $post_id ) ) {
		$out .= sprintf( '<p><a class="button" href="%s" target="_blank" rel="noopener">Mở trang bảng tính →</a> <code>%s</code></p>', esc_url( hh_units_url( $post_id ) ), esc_html( hh_units_url( $post_id ) ) );
	} else {
		$out .= '<p>Dự án chưa đăng (Xuất bản) nên trang bảng tính chưa xem được ngoài web.</p>';
	}
	return $out;
}

add_action( 'wp_ajax_hh_units_read', 'hh_units_ajax_read' );
function hh_units_ajax_read() {
	check_ajax_referer( 'hh_units_read' );
	$post_id = absint( $_POST['post_id'] ?? 0 );
	if ( ! $post_id || 'du-an' !== get_post_type( $post_id ) || ! current_user_can( 'edit_post', $post_id ) ) {
		wp_send_json_error( array( 'html' => '<p class="hh-units-read__err">Không có quyền sửa dự án này.</p>' ) );
	}
	$files = implode( ',', array_filter( array_map( 'absint', explode( ',', sanitize_text_field( wp_unslash( $_POST['files'] ?? '' ) ) ) ) ) );
	$sheet = esc_url_raw( trim( wp_unslash( $_POST['sheet'] ?? '' ) ) );
	foreach ( array( 'hh_p_units_file' => $files, 'hh_p_units_sheet' => $sheet ) as $key => $val ) {
		if ( '' === $val ) {
			delete_post_meta( $post_id, $key );
		} else {
			update_post_meta( $post_id, $key, $val );
		}
	}
	$result = hh_units_refresh( $post_id );
	if ( is_wp_error( $result ) ) {
		wp_send_json_error( array( 'html' => '<p class="hh-units-read__err"><strong>Chưa đọc được:</strong> ' . esc_html( $result->get_error_message() ) . '</p>' ) );
	}
	wp_send_json_success( array( 'html' => hh_units_admin_status( $post_id ) ) );
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
	return is_array( $data ) && ( ! empty( $data['units'] ) || ! empty( $data['plans'] ) ) ? $data : null;
}

/** "120 căn · 5 phương án thanh toán". */
function hh_units_summary( $data ) {
	$bits = array();
	if ( ! empty( $data['units'] ) ) {
		$bits[] = count( $data['units'] ) . ' căn';
	}
	if ( ! empty( $data['plans'] ) ) {
		$bits[] = count( $data['plans'] ) . ' phương án thanh toán';
	}
	return implode( ' · ', $bits );
}

/** Phương án thanh toán: từ phiếu tính giá trong file, cộng bảng "Phương án thanh toán" nhập tay; không có thì dùng "Lịch thanh toán" của dự án. */
function hh_units_plans( $post_id ) {
	$data  = hh_units_data( $post_id );
	$plans = (array) ( $data['plans'] ?? array() );
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

/** Phương án áp dụng được cho căn (phiếu riêng theo loại sản phẩm, VD sheet "SL" chỉ cho căn SL…). */
function hh_units_plan_fits( $plan, $unit ) {
	return empty( $plan['scope'] ) || empty( $unit['code'] ) || 0 === stripos( $unit['code'], $plan['scope'] );
}

/** "3%" / "2,5%". */
function hh_units_pct( $v ) {
	return rtrim( rtrim( number_format( (float) $v, 2, ',', '' ), '0' ), ',' ) . '%';
}

/** Khoản vay & trả góp theo thông số vay của dự án. */
function hh_units_loan( $post_id, $amount, $total ) {
	$rate  = '' !== hh_meta( 'hh_p_loan_rate_float', $post_id ) ? (float) hh_meta( 'hh_p_loan_rate_float', $post_id ) : 10;
	$years = '' !== hh_meta( 'hh_p_loan_years', $post_id ) ? (float) hh_meta( 'hh_p_loan_years', $post_id ) : 20;
	$grace = (int) hh_meta( 'hh_p_loan_grace', $post_id );
	$n     = max( 1, (int) round( $years * 12 ) - $grace );
	$r     = $rate / 100 / 12;
	$month = $r > 0 ? $amount * $r / ( 1 - pow( 1 + $r, -$n ) ) : $amount / $n;
	return array(
		'amount' => (int) $amount,
		'equity' => (int) ( $total - $amount ),
		'pct'    => $total ? round( $amount / $total * 100, 1 ) : 0,
		'rate'   => $rate,
		'years'  => $years,
		'grace'  => $grace,
		'zero'   => (int) hh_meta( 'hh_p_loan_zero_months', $post_id ),
		'bank'   => hh_meta( 'hh_p_loan_bank', $post_id ),
		'month'  => (int) round( $month ),
	);
}

/**
 * Tính giá, chiết khấu, lịch thanh toán, khoản vay cho 1 căn.
 * $on: danh sách chỉ số chiết khấu tuỳ chọn được bật (null = theo mặc định của phiếu).
 * Lịch thanh toán: mảng array( label, when, pct, amount, party, milestone ).
 */
function hh_units_compute( $post_id, $unit, $variant, $plan, $on = null ) {
	$price = (int) ( $unit['prices'][ $variant ] ?? ( $unit['prices'] ? reset( $unit['prices'] ) : 0 ) );
	if ( 'slip' === ( $plan['kind'] ?? '' ) ) {
		return hh_units_compute_slip( $post_id, $unit, $price, $plan, $on );
	}
	$vat_rate  = '' !== hh_meta( 'hh_p_vat', $post_id ) ? (float) hh_meta( 'hh_p_vat', $post_id ) : 10;
	$kpbt_rate = '' !== hh_meta( 'hh_p_kpbt', $post_id ) ? (float) hh_meta( 'hh_p_kpbt', $post_id ) : 2;
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
			$lines[] = array( 'Chiết khấu ' . hh_units_pct( $plan['disc'] ) . ' (' . $plan['name'] . ')', -$disc );
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
			$lines[] = array( 'Chiết khấu ' . hh_units_pct( $plan['disc'] ) . ' (' . $plan['name'] . ')', -$disc );
		}
	}

	// Lịch thanh toán tính trên tổng giá trị trừ KPBT (KPBT thường nộp khi nhận nhà).
	$payable  = $total - $kpbt;
	$schedule = array();
	foreach ( $plan['steps'] as list( $label, $pct ) ) {
		$schedule[] = array( $label, '', $pct, (int) round( $payable * $pct / 100 ), 'kh', false );
	}
	if ( $kpbt && $schedule ) {
		$schedule[] = array( 'Kinh phí bảo trì (khi nhận nhà)', '', null, $kpbt, 'kh', false );
	}
	$loan = $plan['loan'] > 0 ? hh_units_loan( $post_id, (int) round( $payable * $plan['loan'] / 100 ), $total ) : null;
	return array( 'lines' => $lines, 'total' => $total, 'schedule' => $schedule, 'loan' => $loan, 'options' => array() );
}

/** Tính theo phiếu tính giá của chủ đầu tư: cùng thứ tự chiết khấu, thuế, phí và tỷ lệ từng đợt như phiếu mẫu. */
function hh_units_compute_slip( $post_id, $unit, $price, $plan, $on = null ) {
	$lb    = $plan['labels'];
	$base0 = $price * $plan['ratio'];
	$run   = $base0;
	$lines = array( array( $lb['list'] ?? 'Giá niêm yết', $price ) );
	if ( 'pre' === $plan['mode'] ) {
		$lines[] = array( $lb['pre'] ?? 'Giá chưa VAT & KPBT', (int) round( $base0 ) );
	}
	$options = array();
	foreach ( $plan['discounts'] as $k => $d ) {
		$active = ! $d['opt'] || ( null === $on ? $d['def'] : in_array( $k, (array) $on, true ) );
		if ( $d['opt'] ) {
			$options[ $k ] = array( 'label' => $d['label'] . ( null !== $d['rate'] ? ' (' . hh_units_pct( $d['rate'] * 100 ) . ')' : ' (' . hh_units_vnd( $d['amount'] ) . ')' ), 'on' => $active );
		}
		if ( ! $active ) {
			continue;
		}
		$amount  = null !== $d['rate'] ? round( $d['rate'] * ( ! empty( $d['seq'] ) ? $run : $base0 ) ) : $d['amount'];
		$run    -= $amount;
		$lines[] = array( $d['label'] . ( null !== $d['rate'] ? ' (' . hh_units_pct( $d['rate'] * 100 ) . ')' : '' ), -(int) $amount );
	}
	if ( 'pre' === $plan['mode'] ) {
		$vat     = round( $run * $plan['vat'] );
		$kpbt    = round( $run * $plan['kpbt'] );
		$lines[] = array( $lb['net'] ?? 'Giá sau chiết khấu chưa VAT & KPBT', (int) round( $run ) );
		$lines[] = array( ( $lb['vat'] ?? 'Thuế VAT' ) . ' ' . hh_units_pct( $plan['vat'] * 100 ), (int) $vat );
		if ( $plan['kpbt'] ) {
			$lines[] = array( ( $lb['kpbt'] ?? 'Kinh phí bảo trì' ) . ' ' . hh_units_pct( $plan['kpbt'] * 100 ), (int) $kpbt );
		}
		$total = (int) round( $run + $vat + $kpbt );
	} else {
		$total = (int) round( $run );
	}

	// Tiền cọc cố định (theo loại căn nếu phiếu có bảng cọc); đợt ngay sau trừ phần cọc.
	$type    = strtoupper( preg_replace( '/\s+/', '', (string) ( $unit['type'] ?? '' ) ) );
	$deposit = $plan['dep_types'][ $type ] ?? $plan['deposit'];
	$sched   = array();
	$carry   = 0;
	foreach ( $plan['rows'] as $r ) {
		if ( ! empty( $r['milestone'] ) ) {
			$sched[] = array( $r['label'], $r['when'], null, null, '', true );
			continue;
		}
		if ( $r['deposit'] ) {
			$amount = $deposit ?: $r['share'] * $total;
			$carry  = $plan['dep_share'] * $total - $amount;
		} else {
			$amount = $r['share'] * $total + $carry;
			$carry  = 0;
		}
		$sched[] = array( $r['label'], $r['when'], $r['pct'] ?? null, (int) round( $amount ), $r['party'], false );
	}
	// Làm tròn: đợt cuối nhận phần chênh để tổng khớp.
	$sum = array_sum( array_map( static fn( $s ) => (int) $s[3], $sched ) );
	for ( $i = count( $sched ) - 1; $i >= 0; $i-- ) {
		if ( ! $sched[ $i ][5] ) {
			$sched[ $i ][3] += $total - $sum;
			break;
		}
	}
	$bank_rows = array_filter( $sched, static fn( $s ) => 'nh' === $s[4] );
	$bank      = array_sum( array_map( static fn( $s ) => (int) $s[3], $bank_rows ) );
	$loan      = $bank ? hh_units_loan( $post_id, $bank, $total ) : null;
	if ( $loan && ! in_array( null, array_column( $bank_rows, 2 ), true ) ) {
		$loan['pct'] = array_sum( array_column( $bank_rows, 2 ) ); // Tỷ lệ vay ghi trên phiếu (VD 70% giá trị HĐMB).
	}
	return array(
		'lines'    => $lines,
		'total'    => $total,
		'schedule' => $sched,
		'loan'     => $loan,
		'options'  => $options,
	);
}

/** 3.250.000.000 đ → "3,25 tỷ"; dưới 1 tỷ → "850 triệu". */
function hh_units_vnd( $v, $exact = false ) {
	if ( $exact ) {
		return ( $v < 0 ? '−' : '' ) . number_format( abs( (float) $v ), 0, ',', '.' ) . ' đ';
	}
	$a = abs( $v );
	$s = $a >= 1e9 ? rtrim( rtrim( number_format( $a / 1e9, 2, ',', '.' ), '0' ), ',' ) . ' tỷ' : number_format( $a / 1e6, 0, ',', '.' ) . ' triệu';
	return ( $v < 0 ? '−' : '' ) . $s;
}
