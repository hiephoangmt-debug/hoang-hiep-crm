<?php
/**
 * Hình minh họa tiêu chuẩn bàn giao theo khu (phòng khách – phòng ngủ, bếp, phòng tắm, ban công, nhà thông minh).
 * Mỗi khu là một hình vẽ SVG; từng hạng mục trong danh sách được gắn số và đặt chấm số đúng chỗ trên hình
 * (sàn gỗ, cửa kính, tủ bếp, lavabo…). Hạng mục không có vị trí trên hình vẫn có số trong danh sách.
 *
 * @package HoangHiep
 */

defined( 'ABSPATH' ) || exit;

/** Cảnh vẽ và các điểm đặt số: [regex nhận hạng mục, x, y]. Thứ tự điểm = thứ tự ưu tiên khi so khớp. */
function hoanghiep_bg_scenes() {
	$ln = 'stroke="#0e1c33" stroke-width="1.6" stroke-linejoin="round" stroke-linecap="round"';
	return array(
		'khach'   => array(
			'svg'  => '<rect width="320" height="200" fill="#f6f1e9"/>'
				. '<rect x="0" y="0" width="320" height="22" fill="#fff" ' . $ln . '/>'
				. '<circle cx="70" cy="22" r="4" fill="#ffd27a"/><circle cx="250" cy="22" r="4" fill="#ffd27a"/>'
				. '<path d="M62 26l-10 22h36l-10-22z" fill="#fff3d0" opacity=".7"/><path d="M242 26l-10 22h36l-10-22z" fill="#fff3d0" opacity=".7"/>'
				. '<rect x="135" y="22" width="56" height="9" rx="2" fill="#fff" ' . $ln . '/><path d="M141 27h44" ' . $ln . '/>'
				. '<rect x="205" y="44" width="92" height="98" fill="#d9ecf7" ' . $ln . '/><path d="M251 44v98M205 93h92" ' . $ln . '/><path d="M214 56l20-10M262 120l22-12" stroke="#fff" stroke-width="3"/>'
				. '<rect x="24" y="58" width="58" height="104" fill="#e9dcc7" ' . $ln . '/><rect x="70" y="102" width="6" height="16" rx="2" fill="#0e1c33"/>'
				. '<rect x="100" y="122" width="92" height="30" rx="8" fill="#c9d6e8" ' . $ln . '/><rect x="96" y="112" width="100" height="16" rx="7" fill="#dfe7f2" ' . $ln . '/>'
				. '<rect x="0" y="162" width="320" height="38" fill="#d8b98c" ' . $ln . '/><path d="M0 175h320M0 188h320M40 162v13M120 162v13M200 162v13M280 162v13M80 175v13M160 175v13M240 175v13M20 188v12M100 188v12M180 188v12M260 188v12" stroke="#b8945f" stroke-width="1"/>',
			'pins' => array(
				array( '/cửa chính|khóa/u', 52, 92 ),
				array( '/điều hòa|máy lạnh/u', 163, 42 ),
				array( '/kính|low-e|cửa sổ/u', 228, 118 ),
				array( '/trần|đèn/u', 92, 12 ),
				array( '/sàn|gỗ|lát/u', 140, 182 ),
			),
		),
		'bep'     => array(
			'svg'  => '<rect width="320" height="200" fill="#f6f1e9"/>'
				. '<rect x="30" y="26" width="260" height="44" fill="#fff" ' . $ln . '/><path d="M95 26v44M160 26v44M225 26v44" ' . $ln . '/><path d="M88 44v8M102 44v8M218 44v8M232 44v8" ' . $ln . '/>'
				. '<path d="M98 70h44l8 22h-60z" fill="#dfe7f2" ' . $ln . '/>'
				. '<rect x="30" y="108" width="260" height="10" fill="#e7e1d6" ' . $ln . '/><path d="M40 112l8-3M200 113l10-3M250 112l8-2" stroke="#fff" stroke-width="2"/>'
				. '<rect x="92" y="104" width="56" height="5" rx="1.5" fill="#0e1c33"/><circle cx="108" cy="106.5" r="1.5" fill="#f2551d"/><circle cx="132" cy="106.5" r="1.5" fill="#f2551d"/>'
				. '<rect x="182" y="108" width="52" height="7" rx="2" fill="#b9c3cf" ' . $ln . '/>'
				. '<path d="M214 108V90h-10" fill="none" stroke="#0e1c33" stroke-width="3" stroke-linecap="round"/>'
				. '<rect x="30" y="118" width="260" height="58" fill="#fff" ' . $ln . '/><path d="M95 118v58M160 118v58M225 118v58" ' . $ln . '/><path d="M88 134v10M102 134v10M153 134v10M167 134v10M218 134v10M232 134v10" ' . $ln . '/>'
				. '<rect x="0" y="176" width="320" height="24" fill="#d8b98c"/>',
			'pins' => array(
				array( '/tủ/u', 62, 48 ),
				array( '/bếp từ|hút mùi|bếp và|^bếp/u', 120, 84 ),
				array( '/mặt đá|thạch anh/u', 270, 113 ),
				array( '/chậu/u', 190, 130 ),
				array( '/vòi/u', 226, 92 ),
			),
		),
		'tam'     => array(
			'svg'  => '<rect width="320" height="200" fill="#eef4f8"/>'
				. '<path d="M0 20h320M0 40h320M0 60h320M0 80h320M0 100h320M0 120h320M0 140h320M0 160h320M40 0v180M80 0v180M120 0v180M160 0v180M200 0v180M240 0v180M280 0v180" stroke="#d3e0ea" stroke-width="1"/>'
				. '<rect x="0" y="180" width="320" height="20" fill="#c9cfd6"/><path d="M0 190h320M20 180v20M60 180v20M100 180v20M140 180v20M180 180v20M220 180v20M260 180v20M300 180v20" stroke="#aeb6bf"/>'
				. '<rect x="182" y="34" width="34" height="44" rx="6" fill="#fff" ' . $ln . '/><circle cx="199" cy="66" r="3" fill="#f2551d"/>'
				. '<rect x="236" y="30" width="60" height="150" fill="#cfe6f3" fill-opacity=".55" ' . $ln . '/><path d="M246 48l16-10M270 150l18-12" stroke="#fff" stroke-width="3"/><path d="M262 30v-14h18" fill="none" ' . $ln . '/><path d="M274 16h14v6h-14z" fill="#fff" ' . $ln . '/>'
				. '<rect x="112" y="40" width="54" height="52" rx="4" fill="#e6f2fa" ' . $ln . '/><path d="M120 50l14-8" stroke="#fff" stroke-width="3"/>'
				. '<path d="M104 110h70v8a10 10 0 0 1-10 10h-50a10 10 0 0 1-10-10z" fill="#fff" ' . $ln . '/><rect x="110" y="128" width="58" height="34" fill="#e9dcc7" ' . $ln . '/><path d="M139 110v-8h6" fill="none" ' . $ln . '/>'
				. '<path d="M40 112h40v14a20 20 0 0 1-20 20h0a20 20 0 0 1-20-20z" fill="#fff" ' . $ln . '/><rect x="44" y="92" width="32" height="20" rx="3" fill="#fff" ' . $ln . '/><rect x="52" y="146" width="16" height="22" fill="#fff" ' . $ln . '/>',
			'pins' => array(
				array( '/toto|kohler|thiết bị|bồn cầu/u', 60, 128 ),
				array( '/vách kính|vách tắm|tắm đứng|vòi sen/u', 266, 100 ),
				array( '/lavabo|chậu rửa/u', 139, 145 ),
				array( '/gương/u', 139, 66 ),
				array( '/nước nóng|bình nóng/u', 199, 48 ),
				array( '/ốp tường/u', 24, 30 ),
				array( '/chống trơn|gạch sàn|gạch/u', 200, 190 ),
			),
		),
		'bancong' => array(
			'svg'  => '<rect width="320" height="200" fill="#dbeefa"/>'
				. '<path d="M0 104h30v-30h18v30h14v-46h22v46h16v-24h20v24h20v-56h16v56h24v-36h18v36h122v6H0z" fill="#b8cfe0"/>'
				. '<rect x="0" y="0" width="320" height="10" fill="#fff" ' . $ln . '/>'
				. '<rect x="14" y="112" width="196" height="58" fill="#cfe6f3" fill-opacity=".6" ' . $ln . '/><path d="M14 112h196" stroke="#0e1c33" stroke-width="4"/><path d="M28 126l16-10M150 160l20-12" stroke="#fff" stroke-width="3"/><path d="M63 112v58M112 112v58M161 112v58" stroke="#0e1c33" stroke-width="1"/>'
				. '<rect x="226" y="98" width="62" height="72" rx="6" fill="#fff" ' . $ln . '/><circle cx="257" cy="138" r="20" fill="#e6f2fa" ' . $ln . '/><circle cx="257" cy="138" r="13" fill="none" ' . $ln . '/><path d="M232 108h20" ' . $ln . '/>'
				. '<rect x="296" y="110" width="14" height="18" rx="3" fill="#fff" ' . $ln . '/><path d="M301 116v5M305 116v5" ' . $ln . '/><path d="M300 170v-22h10" fill="none" stroke="#5d6b80" stroke-width="3"/>'
				. '<rect x="0" y="170" width="320" height="30" fill="#c9bba5" ' . $ln . '/><path d="M0 185h320M40 170v30M100 170v30M160 170v30M220 170v30M280 170v30" stroke="#ad9d84"/>',
			'pins' => array(
				array( '/lan can/u', 88, 140 ),
				array( '/máy giặt|cấp – thoát|cấp thoát|ổ điện/u', 257, 92 ),
				array( '/chống trượt|gạch/u', 130, 186 ),
			),
		),
		'smart'   => array(
			'svg'  => '<rect width="320" height="200" fill="#f6f1e9"/>'
				. '<rect x="128" y="18" width="64" height="168" rx="12" fill="#0e1c33"/><rect x="134" y="30" width="52" height="140" rx="6" fill="#fff"/>'
				. '<rect x="140" y="40" width="40" height="18" rx="4" fill="#ffe3d6"/><rect x="140" y="64" width="40" height="18" rx="4" fill="#dfe7f2"/><rect x="140" y="88" width="40" height="18" rx="4" fill="#e9f5e7"/><circle cx="148" cy="49" r="3" fill="#f2551d"/><circle cx="148" cy="73" r="3" fill="#3b6fb6"/><circle cx="148" cy="97" r="3" fill="#3f9b52"/>'
				. '<path d="M62 46a16 16 0 1 1 20 15v8H66v-8a16 16 0 0 1-4-15z" fill="#ffe7a8" ' . $ln . '/><path d="M66 74h16" ' . $ln . '/>'
				. '<rect x="226" y="40" width="72" height="24" rx="5" fill="#fff" ' . $ln . '/><path d="M234 56h56M240 72l-4 8M262 72v8M284 72l4 8" ' . $ln . '/>'
				. '<rect x="54" y="128" width="40" height="40" rx="8" fill="#fff" ' . $ln . '/><circle cx="68" cy="146" r="3" fill="#0e1c33"/><circle cx="80" cy="146" r="3" fill="#0e1c33"/>'
				. '<path d="M100 56q14 0 26 12M100 146q14 0 26-12M220 52q-14 0-26 12" fill="none" stroke="#f2551d" stroke-width="1.6" stroke-dasharray="4 4"/>',
			'pins' => array(
				array( '/hệ thống|smart home|ứng dụng|app/u', 160, 136 ),
				array( '/điều khiển|đèn|điều hòa|ổ điện/u', 262, 96 ),
			),
		),
	);
}

/**
 * HTML một thẻ: hình minh họa + danh sách đánh số. $items là các hạng mục (tiếng Việt, trang dịch tự thay chữ).
 *
 * @param string $ic    Khu: khach|bep|tam|bancong|smart|chung.
 * @param array  $items Hạng mục.
 * @return array{svg:string} SVG đã gắn chấm số (số = thứ tự hạng mục trong danh sách).
 */
function hoanghiep_bg_illus( $ic, $items ) {
	$scenes = hoanghiep_bg_scenes();
	if ( ! isset( $scenes[ $ic ] ) ) {
		return array( 'svg' => '' );
	}
	$sc   = $scenes[ $ic ];
	$used = array();
	$pins = '';
	foreach ( array_values( $items ) as $n => $it ) {
		$low = mb_strtolower( (string) $it );
		foreach ( $sc['pins'] as $k => $p ) {
			if ( isset( $used[ $k ] ) || ! preg_match( $p[0], $low ) ) {
				continue;
			}
			$used[ $k ] = true;
			$pins      .= '<g><circle cx="' . (int) $p[1] . '" cy="' . (int) $p[2] . '" r="10" fill="#f2551d" stroke="#fff" stroke-width="2.5"/><text x="' . (int) $p[1] . '" y="' . ( (int) $p[2] + 4 ) . '" text-anchor="middle" font-size="12" font-weight="700" fill="#fff" font-family="Be Vietnam Pro,Arial,sans-serif">' . ( $n + 1 ) . '</text></g>';
			break;
		}
	}
	return array(
		'svg' => '<svg class="std-art" viewBox="0 0 320 200" role="img" aria-hidden="true" preserveAspectRatio="xMidYMid meet">' . $sc['svg'] . $pins . '</svg>',
	);
}

/**
 * Tách đoạn "tiêu chuẩn bàn giao" viết liền (VD "trần thạch cao, sơn…; tủ bếp, mặt đá…; thiết bị vệ sinh…") thành thẻ theo khu
 * dựa vào từ khóa từng hạng mục – anh Hiệp 28/11/2026: mọi dự án có nội thất bàn giao đều hiện hình minh họa, không để đoạn chữ rối.
 *
 * @param string $text Đoạn tiêu chuẩn bàn giao (tiếng Việt).
 * @return array{intro:string,cards:array} cards rỗng khi không đủ 2 khu.
 */
function hoanghiep_std_kw( $text ) {
	$text  = trim( preg_replace( '/\s+/u', ' ', (string) $text ) );
	$intro = '';
	if ( preg_match( '/^([^:;]{12,140}):\s*(.+)$/u', $text, $x ) && ! preg_match( '/^(bếp|phòng|ban công|lô gia|thiết bị|nhà|wc)/iu', $x[1] ) ) {
		$intro = rtrim( $x[1], ' .' );
		$text  = $x[2];
	}
	$text   = rtrim( $text, ' .' );
	$pieces = array();
	$room   = '(khách|ăn|ngủ|bếp|tắm|vệ sinh|wc|lô gia|logia|ban công|phòng)';
	foreach ( preg_split( '/;\s*|\.\s+(?=\p{Lu})/u', $text ) as $clause ) {
		$clause = trim( preg_replace( '/^[^:]{2,30}:\s*/u', '', trim( $clause ) ) ); // Bỏ nhãn ngắn "Bếp:" – khu lấy theo từ khóa.
		$prev   = null;
		foreach ( preg_split( '/,\s+(?![^(]*\))/u', $clause ) as $pc ) {
			$pc = trim( $pc, " .\t" );
			if ( '' === $pc ) {
				continue;
			}
			// Ghép mảnh bị tách sai: "sàn phòng khách, ăn, ngủ gỗ…", "Florim, Porcelanosa, Vietceramic".
			if ( null !== $prev && ( ( preg_match( '/' . $room . '$/u', mb_strtolower( $pieces[ $prev ] ) ) && preg_match( '/^' . $room . '/u', mb_strtolower( $pc ) ) ) || ! preg_match( '/\s/u', $pc ) ) ) {
				$pieces[ $prev ] .= ', ' . $pc;
				continue;
			}
			if ( mb_strlen( $pc ) >= 3 ) {
				$pieces[] = $pc;
				$prev     = count( $pieces ) - 1;
			}
		}
	}
	$rules = array(
		'bep'     => '/tủ bếp|mặt đá|bếp từ|bếp điện|^bếp|hút mùi|chậu rửa bát|chậu bếp|máy rửa bát|tủ trên|bồn rửa|chậu và vòi|chậu inox/u',
		'tam'     => '/vệ sinh|toto|grohe|kohler|inax|american standard|vách tắm|vách kính|cabin|tắm|lavabo|bồn cầu|sen vòi|vòi sen|nóng lạnh|bình nóng|gương|wc/u',
		'bancong' => '/lô gia|logia|ban công|lan can|máy giặt/u',
		'smart'   => '/smart ?home|nhà thông minh|điều khiển từ xa|qua điện thoại|ứng dụng/u',
		'khach'   => '/phòng khách|phòng ngủ|trần|sơn|sàn|gỗ|rèm|điều hòa|điều hoà|máy lạnh|cửa|khóa|khoá|kính|đèn|tường|công tắc|ổ cắm/u',
	);
	$groups = array();
	foreach ( $pieces as $pc ) {
		$low = mb_strtolower( $pc );
		$ic  = 'chung';
		$nr  = preg_match( '/khách|ngủ|\băn\b/u', $low ) + preg_match( '/bếp/u', $low ) + preg_match( '/tắm|vệ sinh|wc/u', $low ) + preg_match( '/lô gia|logia|ban công/u', $low );
		foreach ( $nr >= 2 || preg_match( '/triệu|tỷ/u', $low ) ? array() : $rules as $k => $re ) { // Hạng mục chung cho nhiều phòng (VD "bếp, phòng tắm, lô gia lát gạch") → Hoàn thiện chung.
			if ( preg_match( $re, $low ) ) {
				$ic = $k;
				break;
			}
		}
		$groups[ $ic ][] = function_exists( 'hh_ucfirst' ) ? hh_ucfirst( $pc ) : $pc;
	}
	$labels = array(
		'khach'   => 'Phòng khách, phòng ngủ',
		'bep'     => 'Bếp',
		'tam'     => 'Phòng tắm',
		'bancong' => 'Lô gia, ban công',
		'smart'   => 'Nhà thông minh',
		'chung'   => 'Hoàn thiện chung',
	);
	$cards = array();
	foreach ( $labels as $ic => $lb ) {
		if ( ! empty( $groups[ $ic ] ) ) {
			$cards[] = array( 'lb' => $lb, 'ic' => $ic, 'items' => $groups[ $ic ] );
		}
	}
	if ( count( array_diff( array_keys( $groups ), array( 'chung' ) ) ) < 2 ) {
		$cards = array();
	}
	return array( 'intro' => $intro, 'cards' => $cards );
}
