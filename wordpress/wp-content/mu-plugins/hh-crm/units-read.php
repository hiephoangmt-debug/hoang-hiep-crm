<?php
/**
 * Đọc file bảng tính của chủ đầu tư thành các trang tính (không cần thư viện ngoài):
 * .xlsx (mọi trang tính), .xls đời cũ (Excel 97–2003, BIFF8) và .csv.
 * Kết quả: mảng [ array( 'name' => tên trang, 'hidden' => bool, 'rows' => mảng dòng chuỗi ) ].
 * Số giữ nguyên dạng số ("13896000000", "0.03"); ngày Excel là số ngày (VD 46295).
 */

defined( 'ABSPATH' ) || exit;

/** Đọc file theo phần mở rộng. */
function hh_units_read_workbook( $path ) {
	$ext = strtolower( pathinfo( $path, PATHINFO_EXTENSION ) );
	if ( 'xlsx' === $ext || 'xlsm' === $ext ) {
		return hh_units_read_xlsx( $path );
	}
	if ( 'xls' === $ext ) {
		return hh_units_read_xls( $path );
	}
	if ( 'csv' === $ext || 'txt' === $ext ) {
		return array( array( 'name' => wp_basename( $path, '.' . $ext ), 'hidden' => false, 'rows' => hh_units_parse_csv( (string) file_get_contents( $path ) ) ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions
	}
	return new WP_Error( 'ext', 'Chỉ đọc được file Excel (.xlsx, .xls) hoặc .csv.' );
}

/** Số thực → chuỗi gọn ("13896000000", "0.03"). */
function hh_units_num_str( $v ) {
	if ( is_float( $v ) && floor( $v ) === $v && abs( $v ) < 1e15 ) {
		return (string) (int) $v;
	}
	return (string) $v;
}

/** Mảng ô [cột => giá trị] → dòng liền mạch. */
function hh_units_pack_row( $cells ) {
	if ( ! $cells ) {
		return array();
	}
	$line = array();
	$max  = max( array_keys( $cells ) );
	for ( $i = 0; $i <= $max; $i++ ) {
		$line[] = isset( $cells[ $i ] ) ? trim( (string) $cells[ $i ] ) : '';
	}
	return $line;
}

/* -------------------------------------------------------------------------
 * .xlsx
 * ---------------------------------------------------------------------- */

function hh_units_read_xlsx( $path ) {
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
			$text = isset( $si->t ) ? (string) $si->t : '';
			foreach ( $si->r as $run ) {
				$text .= (string) $run->t;
			}
			$shared[] = $text;
		}
	}
	$targets = array();
	$rels    = $zip->getFromName( 'xl/_rels/workbook.xml.rels' );
	if ( $rels ) {
		foreach ( simplexml_load_string( $rels )->Relationship as $r ) {
			$targets[ (string) $r['Id'] ] = 'xl/' . ltrim( preg_replace( '#^/?xl/#', '', (string) $r['Target'] ), '/' );
		}
	}
	$sheets = array();
	$wb     = $zip->getFromName( 'xl/workbook.xml' );
	if ( $wb && preg_match_all( '/<sheet\b[^>]*>/', $wb, $tags ) ) {
		foreach ( $tags[0] as $n => $tag ) {
			preg_match( '/\bname="([^"]*)"/', $tag, $nm );
			preg_match( '/\br:id="([^"]*)"/', $tag, $id );
			$sheets[] = array(
				'name'   => html_entity_decode( $nm[1] ?? 'Sheet' . ( $n + 1 ), ENT_QUOTES | ENT_XML1, 'UTF-8' ),
				'hidden' => (bool) preg_match( '/\bstate="(hidden|veryHidden)"/', $tag ),
				'file'   => $targets[ $id[1] ?? '' ] ?? 'xl/worksheets/sheet' . ( $n + 1 ) . '.xml',
			);
		}
	}
	if ( ! $sheets ) {
		$sheets[] = array( 'name' => 'Sheet1', 'hidden' => false, 'file' => 'xl/worksheets/sheet1.xml' );
	}
	$out = array();
	foreach ( $sheets as $s ) {
		$xml = $zip->getFromName( $s['file'] );
		if ( ! $xml ) {
			continue;
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
				$cells[ hh_units_col_index( (string) $c['r'] ) ] = $val;
			}
			$rows[ max( 0, (int) $row['r'] - 1 ) ] = hh_units_pack_row( $cells );
		}
		$out[] = array( 'name' => $s['name'], 'hidden' => $s['hidden'], 'rows' => hh_units_fill_rows( $rows ) );
	}
	$zip->close();
	return $out ?: new WP_Error( 'sheet', 'Không đọc được trang tính trong file .xlsx.' );
}

/** Dòng theo chỉ số (có thể thiếu) → mảng liên tục, giữ đúng số dòng. */
function hh_units_fill_rows( $rows ) {
	if ( ! $rows ) {
		return array();
	}
	$out = array();
	$max = max( array_keys( $rows ) );
	for ( $i = 0; $i <= $max; $i++ ) {
		$out[] = $rows[ $i ] ?? array();
	}
	return $out;
}

/* -------------------------------------------------------------------------
 * .xls (BIFF8 trong file OLE2)
 * ---------------------------------------------------------------------- */

/** Lấy luồng "Workbook" trong file OLE2. */
function hh_units_ole_stream( $data, $want = array( 'Workbook', 'Book' ) ) {
	if ( strlen( $data ) < 512 || "\xD0\xCF\x11\xE0\xA1\xB1\x1A\xE1" !== substr( $data, 0, 8 ) ) {
		return new WP_Error( 'ole', 'File .xls không đúng định dạng Excel 97–2003.' );
	}
	$h        = unpack( 'vshift/vmshift', substr( $data, 30, 4 ) );
	$ssize    = 1 << $h['shift'];
	$msize    = 1 << $h['mshift'];
	$i        = unpack( 'Vnfat/Vdir/Vx/Vcutoff/Vminifat/Vnminifat/Vdifat/Vndifat', substr( $data, 44, 32 ) );
	$sector   = static fn( $n ) => substr( $data, 512 + $n * $ssize, $ssize );
	$fat_secs = array_values( unpack( 'V109', substr( $data, 76, 436 ) ) );
	$next     = $i['difat'];
	for ( $k = 0; $k < $i['ndifat'] && $next < 0xFFFFFFFA; $k++ ) {
		$ids      = array_values( unpack( 'V' . ( $ssize / 4 ), $sector( $next ) ) );
		$next     = array_pop( $ids );
		$fat_secs = array_merge( $fat_secs, $ids );
	}
	$fat = array();
	foreach ( array_slice( $fat_secs, 0, $i['nfat'] ) as $s ) {
		if ( $s < 0xFFFFFFFA ) {
			$fat = array_merge( $fat, array_values( unpack( 'V' . ( $ssize / 4 ), $sector( $s ) ) ) );
		}
	}
	$chain = static function ( $start, $table, $read ) {
		$buf  = '';
		$seen = 0;
		while ( $start < 0xFFFFFFFA && isset( $table[ $start ] ) && $seen++ < 1000000 ) {
			$buf  .= $read( $start );
			$start = $table[ $start ];
		}
		return $buf;
	};
	$dir     = $chain( $i['dir'], $fat, $sector );
	$entries = array();
	for ( $o = 0; $o + 128 <= strlen( $dir ); $o += 128 ) {
		$len = unpack( 'v', substr( $dir, $o + 64, 2 ) )[1];
		$e   = unpack( 'Ctype', substr( $dir, $o + 66, 1 ) ) + unpack( 'Vstart/Vsize', substr( $dir, $o + 116, 8 ) );
		$e['name'] = $len > 2 ? mb_convert_encoding( substr( $dir, $o, $len - 2 ), 'UTF-8', 'UTF-16LE' ) : '';
		$entries[] = $e;
	}
	foreach ( $want as $name ) {
		foreach ( $entries as $e ) {
			if ( 2 !== $e['type'] || 0 !== strcasecmp( $e['name'], $name ) ) {
				continue;
			}
			if ( $e['size'] >= $i['cutoff'] ) {
				return substr( $chain( $e['start'], $fat, $sector ), 0, $e['size'] );
			}
			// Luồng nhỏ nằm trong mini stream của mục gốc.
			$minifat = array();
			$raw     = $chain( $i['minifat'], $fat, $sector );
			if ( $raw ) {
				$minifat = array_values( unpack( 'V' . ( strlen( $raw ) / 4 ), $raw ) );
			}
			$root = $chain( $entries[0]['start'], $fat, $sector );
			$buf  = $chain( $e['start'], $minifat, static fn( $n ) => substr( $root, $n * $msize, $msize ) );
			return substr( $buf, 0, $e['size'] );
		}
	}
	return new WP_Error( 'ole', 'Không tìm thấy dữ liệu bảng tính trong file .xls.' );
}

/** Số RK của Excel → số. */
function hh_units_rk( $rk ) {
	if ( $rk & 2 ) {
		$v = (float) ( $rk >> 2 );
		if ( $rk & 0x80000000 ) {
			$v = (float) ( ( $rk >> 2 ) - ( 1 << 30 ) ); // Số nguyên âm 30 bit.
		}
	} else {
		$v = unpack( 'e', pack( 'V', 0 ) . pack( 'V', $rk & 0xFFFFFFFC ) )[1];
	}
	return $rk & 1 ? $v / 100 : $v;
}

/**
 * Đọc chuỗi Unicode của BIFF8 có thể bị cắt sang bản ghi CONTINUE.
 * $parts: danh sách nội dung bản ghi (bản ghi chính + CONTINUE); $p = array( chỉ số phần, vị trí ).
 */
function hh_units_biff_string( $parts, &$p, $len_bytes = 2 ) {
	$take = static function ( $n ) use ( $parts, &$p ) {
		$out = '';
		while ( $n > 0 && isset( $parts[ $p[0] ] ) ) {
			$chunk = substr( $parts[ $p[0] ], $p[1], $n );
			$out  .= $chunk;
			$p[1] += strlen( $chunk );
			$n    -= strlen( $chunk );
			if ( $n > 0 ) {
				$p = array( $p[0] + 1, 0 );
			}
		}
		return $out;
	};
	if ( isset( $parts[ $p[0] ] ) && $p[1] >= strlen( $parts[ $p[0] ] ) ) {
		$p = array( $p[0] + 1, 0 );
	}
	$cch   = 1 === $len_bytes ? ord( $take( 1 ) ) : unpack( 'v', $take( 2 ) . "\0\0" )[1];
	$flags = ord( $take( 1 ) );
	$runs  = $flags & 0x08 ? unpack( 'v', $take( 2 ) . "\0\0" )[1] : 0;
	$ext   = $flags & 0x04 ? unpack( 'V', $take( 4 ) . "\0\0\0\0" )[1] : 0;
	$wide  = $flags & 0x01;
	$text  = '';
	$left  = $cch;
	while ( $left > 0 && isset( $parts[ $p[0] ] ) ) {
		$avail = strlen( $parts[ $p[0] ] ) - $p[1];
		if ( $avail <= 0 ) {
			// Sang CONTINUE: byte đầu là cờ nén/không nén mới.
			$p    = array( $p[0] + 1, 0 );
			$wide = ord( $take( 1 ) ) & 0x01;
			continue;
		}
		$n     = min( $left, $wide ? intdiv( $avail, 2 ) : $avail );
		$raw   = substr( $parts[ $p[0] ], $p[1], $n * ( $wide ? 2 : 1 ) );
		$p[1] += strlen( $raw );
		$text .= $wide ? mb_convert_encoding( $raw, 'UTF-8', 'UTF-16LE' ) : mb_convert_encoding( $raw, 'UTF-8', 'ISO-8859-1' );
		$left -= $n;
	}
	$take( $runs * 4 + $ext );
	return $text;
}

function hh_units_read_xls( $path ) {
	$wb = hh_units_ole_stream( (string) file_get_contents( $path ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions
	if ( is_wp_error( $wb ) ) {
		return $wb;
	}
	$len = strlen( $wb );
	// Bản ghi: [loại, nội dung, vị trí].
	$recs = array();
	for ( $o = 0; $o + 4 <= $len; ) {
		$h      = unpack( 'vt/vl', substr( $wb, $o, 4 ) );
		$recs[] = array( $h['t'], substr( $wb, $o + 4, $h['l'] ), $o );
		$o     += 4 + $h['l'];
	}
	$sheets = array();
	$sst    = array();
	$count  = count( $recs );
	for ( $k = 0; $k < $count; $k++ ) {
		list( $type, $body ) = $recs[ $k ];
		if ( 0x0085 === $type ) { // BOUNDSHEET.
			$b = unpack( 'Vpos/Cvis/Ckind', substr( $body, 0, 6 ) );
			if ( 0 === $b['kind'] ) {
				$p        = array( 0, 6 );
				$sheets[] = array(
					'pos'    => $b['pos'],
					'hidden' => 0 !== $b['vis'],
					'name'   => hh_units_biff_string( array( $body ), $p, 1 ),
				);
			}
		} elseif ( 0x00FC === $type ) { // SST + CONTINUE.
			$parts = array( $body );
			while ( isset( $recs[ $k + 1 ] ) && 0x003C === $recs[ $k + 1 ][0] ) {
				$parts[] = $recs[ ++$k ][1];
			}
			$total = unpack( 'V', substr( $body, 4, 4 ) )[1];
			$p     = array( 0, 8 );
			for ( $n = 0; $n < $total && isset( $parts[ $p[0] ] ); $n++ ) {
				$sst[] = hh_units_biff_string( $parts, $p );
			}
		} elseif ( 0x000A === $type ) { // EOF của phần workbook.
			break;
		}
	}
	if ( ! $sheets ) {
		return new WP_Error( 'xls', 'Không đọc được trang tính trong file .xls.' );
	}
	$by_pos = array();
	foreach ( $recs as $n => $r ) {
		$by_pos[ $r[2] ] = $n;
	}
	$out = array();
	foreach ( $sheets as $s ) {
		if ( ! isset( $by_pos[ $s['pos'] ] ) ) {
			continue;
		}
		$cells = array();
		$set   = static function ( $r, $c, $v ) use ( &$cells ) {
			$cells[ $r ][ $c ] = $v;
		};
		for ( $k = $by_pos[ $s['pos'] ] + 1; $k < $count; $k++ ) {
			list( $type, $body ) = $recs[ $k ];
			if ( 0x000A === $type ) {
				break;
			}
			if ( strlen( $body ) < 6 && 0x0207 !== $type ) {
				continue;
			}
			$rc = unpack( 'vr/vc', substr( $body, 0, 4 ) );
			switch ( $type ) {
				case 0x00FD: // LABELSST.
					$set( $rc['r'], $rc['c'], $sst[ unpack( 'V', substr( $body, 6, 4 ) )[1] ] ?? '' );
					break;
				case 0x0203: // NUMBER.
					$set( $rc['r'], $rc['c'], hh_units_num_str( unpack( 'e', substr( $body, 6, 8 ) )[1] ) );
					break;
				case 0x027E: // RK.
					$set( $rc['r'], $rc['c'], hh_units_num_str( hh_units_rk( unpack( 'V', substr( $body, 6, 4 ) )[1] ) ) );
					break;
				case 0x00BD: // MULRK.
					$last = unpack( 'v', substr( $body, -2 ) )[1];
					for ( $c = $rc['c'], $o = 4; $c <= $last && $o + 6 <= strlen( $body ) - 2; $c++, $o += 6 ) {
						$set( $rc['r'], $c, hh_units_num_str( hh_units_rk( unpack( 'V', substr( $body, $o + 2, 4 ) )[1] ) ) );
					}
					break;
				case 0x0204: // LABEL.
					$p = array( 0, 6 );
					$set( $rc['r'], $rc['c'], hh_units_biff_string( array( $body ), $p ) );
					break;
				case 0x0205: // BOOLERR.
					if ( 0 === ord( $body[7] ) ) {
						$set( $rc['r'], $rc['c'], ord( $body[6] ) ? 'TRUE' : 'FALSE' );
					}
					break;
				case 0x0006: // FORMULA: lấy giá trị đã tính sẵn.
					$res = substr( $body, 6, 8 );
					if ( "\xFF\xFF" === substr( $res, 6, 2 ) ) {
						$kind = ord( $res[0] );
						if ( 0 === $kind ) {
							// Kết quả chuỗi ở bản ghi STRING ngay sau (có thể cách SHRFMLA/ARRAY).
							for ( $j = $k + 1; $j < $count && $j <= $k + 3; $j++ ) {
								if ( 0x0207 === $recs[ $j ][0] ) {
									$p = array( 0, 0 );
									$set( $rc['r'], $rc['c'], hh_units_biff_string( array( $recs[ $j ][1] ), $p ) );
									break;
								}
							}
						} elseif ( 1 === $kind ) {
							$set( $rc['r'], $rc['c'], ord( $res[2] ) ? 'TRUE' : 'FALSE' );
						}
					} else {
						$set( $rc['r'], $rc['c'], hh_units_num_str( unpack( 'e', $res )[1] ) );
					}
					break;
			}
		}
		$rows = array();
		foreach ( $cells as $r => $line ) {
			$rows[ $r ] = hh_units_pack_row( $line );
		}
		$out[] = array( 'name' => $s['name'], 'hidden' => $s['hidden'], 'rows' => hh_units_fill_rows( $rows ) );
	}
	return $out;
}
