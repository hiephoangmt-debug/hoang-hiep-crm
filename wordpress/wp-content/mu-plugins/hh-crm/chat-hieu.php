<?php
/**
 * Chat (chế độ kịch bản) hiểu ý khách hơn, không chỉ bắt từ khoá:
 * - Chuẩn hoá tiếng lóng, viết tắt, gõ kéo dài chữ ("ko", "dc", "bn", "wa", "đẹp quáaaa"…).
 * - Hiểu câu trả lời ngắn nối theo câu hỏi trước của chat ("để ở", "cho thuê", "gần biển", "3 tỷ", "ok", "chưa"…).
 * - Tra cứu câu hỏi đáp (FAQ) của mọi dự án, bài viết trên web theo nghĩa gần nhất, không cần khách gõ đúng câu.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Chuẩn hoá câu khách gõ (đã viết thường, bỏ dấu): viết tắt, tiếng lóng → từ đầy đủ.
 */
function hh_chat_norm( $t ) {
	$t = preg_replace( '/([a-z])\1{2,}/', '$1', (string) $t ); // quaaaa → qua
	$t = preg_replace( '/[!?.,;:~]+/', ' $0 ', $t );
	$t = preg_replace( '/\b([1-5])\s*(phong ngu|p\.?n|ngu)\b/', '$1pn', $t ); // "2 phòng ngủ", "2 PN" → 2pn
	$map = array(
		'ko' => 'khong', 'k' => 'khong', 'hok' => 'khong', 'hong' => 'khong', 'hem' => 'khong', 'kh' => 'khong', 'khg' => 'khong', 'kg' => 'khong', 'kô' => 'khong', 'khum' => 'khong', 'hk' => 'khong',
		'dc' => 'duoc', 'dk' => 'duoc', 'đc' => 'duoc', 'dươc' => 'duoc',
		'j' => 'gi', 'ji' => 'gi',
		'bn' => 'bao nhieu', 'bnh' => 'bao nhieu', 'bnhieu' => 'bao nhieu', 'nhiu' => 'nhieu', 'baonhieu' => 'bao nhieu',
		'ntn' => 'nhu the nao', 
		'mk' => 'minh', 'mik' => 'minh', 'mjk' => 'minh', 'mjnh' => 'minh',
		'wa' => 'qua', 'qa' => 'qua',
		'z' => 'vay', 'v' => 'vay', 'vay' => 'vay', 'dzay' => 'vay', 'zay' => 'vay',
		'r' => 'roi', 'ruj' => 'roi', 'rui' => 'roi',
		'ti' => 'ty', 'tỉ' => 'ty',
		'cc' => 'chung cu', 'bds' => 'bat dong san', 'bđs' => 'bat dong san',
		'sdt' => 'so dien thoai', 'sđt' => 'so dien thoai', 'zl' => 'zalo', 'zalô' => 'zalo',
		'dn' => 'da nang', 'đn' => 'da nang', 'danang' => 'da nang', 'tp' => 'thanh pho',
		'nc' => 'nuoc', 'ng' => 'nguoi', 'vs' => 'voi', 'ns' => 'noi', 'nhg' => 'nhung', 'trc' => 'truoc', 'ms' => 'moi', 'lm' => 'lam', 'bt' => 'biet',
		'thik' => 'thich', 'thjk' => 'thich', 'mun' => 'muon', 'mog' => 'mong', 'iu' => 'yeu',
		'ak' => 'a', 'ah' => 'a', 'uk' => 'u', 'uh' => 'u', 'um' => 'u', 'uhm' => 'u', 'ừ' => 'u', 'ukm' => 'u',
		'oke' => 'ok', 'oki' => 'ok', 'okie' => 'ok', 'okela' => 'ok', 'okay' => 'ok', 'oce' => 'ok',
		'ib' => 'nhan tin', 'inbox' => 'nhan tin', 'pm' => 'nhan tin',
		'tks' => 'cam on', 'thank' => 'cam on', 'thanks' => 'cam on', 'camon' => 'cam on', 'cmon' => 'cam on',
		'cn' => 'chu nhat', 't7' => 'thu 7',
		'pn' => 'pn', 'wc' => 'wc',
	);
	$t = preg_replace_callback(
		'/(?<![a-z0-9])[a-zđôư0-9]+(?![a-z0-9])/u',
		static fn( $m ) => $map[ $m[0] ] ?? $m[0],
		$t
	);
	return trim( preg_replace( '/\s+/', ' ', $t ) );
}

/** Từ hư và từ chung chung (không chỉ ra dự án, khu nào) – bỏ khi so câu hỏi. */
function hh_chat_stop() {
	static $s = null;
	if ( null === $s ) {
		$s = array_flip( explode( ' ', 'a e anh chi em minh toi tui ban oi nhe nha la co khong cua va voi thi ma cho hoi xin vay the nao gi sao duoc roi nay do kia day o dang da se can muon biet u ok di chu nua lam qua rat cac nhung mot nhieu it hay hoac neu khi ve tren duoi trong ngoai ra vao den tu bang theo nhu de ai cai con chiec ad shop ha ho nhi chua bao gio luc may nam thang ngay hien nay bay du an can ho chung cu dat nen biet thu nha pho shophouse villa nha khu do thi da nang quang nam hoi an tp thanh pho lo dat mua ban phong tang toa block huong dan thong tin tu van tim hieu cho biet ti chut xiu' ) );
	}
	return $s;
}

/** Ý hỏi trong câu (khi nào, bàn giao, pháp lý, giá, vị trí…). Trả về [ý hỏi, câu đã bỏ các cụm chỉ ý hỏi]. */
function hh_chat_concepts( $t ) {
	$c = array(
		'khinao'   => 'bao gio|khi nao|luc nao|may gio|thoi gian|tien do (xay|thi cong|du an)?|nam nao|thang nao|den khi|bao lau (nua|thi)|khoi cong|hoan thanh',
		'bangiao'  => 'ban giao|giao nha|nhan nha|xay xong|hoan thien|vao o',
		'phaply'   => 'so hong|so do|\bso\b(?! huu)|phap ly|giay to|giay chung nhan|giay phep|quy hoach|tranh chap|cong chung',
		'sohuu'    => 'so huu|lau dai|\d+ nam|bao lau|thoi han|may nam|nguoi nuoc ngoai|viet kieu',
		'gia'      => 'gia|bao nhieu tien|may ty|bao nhieu ty|\bty\b|\btrieu\b|tien|re hon|dat hon|bang gia',
		'vitri'    => 'o dau|vi tri|dia chi|nam o|nam tren|cach|gan|duong nao|ket noi|xa (trung tam|bien|san bay)',
		'vay'      => 'vay|ngan hang|tra gop|lai suat|thanh toan|von tu co|dong tien|ho tro lai',
		'tienich'  => 'tien ich|ho boi|gym|truong hoc|benh vien|sieu thi|cong vien|an ninh',
		'loaican'  => 'loai (can|san pham|nha)|dien tich|bao nhieu m|\bm2\b|may phong|phong ngu|\bpn\b|mat bang|thiet ke|layout|san pham gi',
		'chudautu' => 'chu dau tu|\bcdt\b|cua ai|ai lam|tap doan|don vi (phat trien|thi cong)',
		'chothue'  => 'cho thue|thu nhap|loi nhuan|sinh loi|loi suat|lai (bao nhieu|khong)|khai thac',
		'quymo'    => 'quy mo|bao nhieu (can|lo|tang|toa|ha)|may toa|may tang|tong dien tich|mat do',
		'kiemtra'  => 'kiem tra|luu y|can (biet|chu y)|rui ro|co nen|nen mua|an toan',
	);
	$found = array();
	foreach ( $c as $k => $re ) {
		if ( preg_match( '/' . $re . '/', $t ) ) {
			$found[ $k ] = 1;
			$t = preg_replace( '/' . $re . '/', ' ', $t );
		}
	}
	return array( $found, $t );
}

/** Từ có nghĩa (chỉ đối tượng: tên dự án, đường, khu…) sau khi bỏ từ hư và cụm chỉ ý hỏi. */
function hh_chat_entities( $t ) {
	$st  = hh_chat_stop();
	$out = array();
	foreach ( explode( ' ', preg_replace( '/[^a-z0-9 ]/', ' ', $t ) ) as $x ) {
		if ( strlen( $x ) > 1 && ! isset( $st[ $x ] ) ) {
			$out[ $x ] = 1;
		}
	}
	return $out;
}

/** Kho câu hỏi đáp (FAQ) của dự án, bài viết đang đăng; lưu tạm 6 giờ. */
function hh_chat_faq_index() {
	$idx = get_transient( 'hh_chat_faq2' );
	if ( is_array( $idx ) ) {
		return $idx;
	}
	$idx = array( 'rows' => array(), 'df' => array(), 'n' => 0 );
	$add = static function ( $id, $raw, $kind ) use ( &$idx ) {
		$title = hh_chat_norm( mb_strtolower( remove_accents( get_the_title( $id ) ) ) );
		foreach ( preg_split( '/\r\n|\n/', (string) $raw ) as $line ) {
			$p = array_map( 'trim', explode( '|', $line, 2 ) );
			if ( count( $p ) < 2 || '' === $p[0] || '' === $p[1] ) {
				continue;
			}
			list( $con, $rest ) = hh_chat_concepts( hh_chat_norm( mb_strtolower( remove_accents( $p[0] ) ) ) );
			$ent = hh_chat_entities( $rest );
			// Dự án: tên dự án cũng là đối tượng của câu hỏi. Bài viết: chỉ lấy từ trong câu hỏi.
			$all = 'du-an' === $kind ? $ent + hh_chat_entities( hh_chat_concepts( $title )[1] ) : $ent;
			foreach ( array_keys( $all ) as $k ) {
				$idx['df'][ $k ] = ( $idx['df'][ $k ] ?? 0 ) + 1;
			}
			$idx['rows'][] = array( 'id' => (int) $id, 'kind' => $kind, 'q' => $p[0], 'a' => $p[1], 'c' => array_keys( $con ), 'e' => array_keys( $all ) );
			++$idx['n'];
		}
	};
	foreach ( get_posts( array( 'post_type' => 'du-an', 'post_status' => 'publish', 'numberposts' => 300, 'fields' => 'ids' ) ) as $id ) {
		$add( $id, get_post_meta( $id, 'hh_p_faq', true ), 'du-an' );
	}
	foreach ( get_posts( array( 'post_type' => 'post', 'post_status' => 'publish', 'numberposts' => 200, 'fields' => 'ids' ) ) as $id ) {
		$add( $id, get_post_meta( $id, 'hh_post_faq', true ), 'post' );
	}
	set_transient( 'hh_chat_faq2', $idx, 6 * HOUR_IN_SECONDS );
	return $idx;
}
add_action(
	'save_post',
	static function ( $id, $post ) {
		if ( in_array( $post->post_type, array( 'du-an', 'post' ), true ) ) {
			delete_transient( 'hh_chat_faq2' );
		}
	},
	10,
	2
);

/**
 * Câu hỏi đáp có sẵn trên web khớp ý khách nhất: cùng ý hỏi (khi nào, pháp lý, giá…) và cùng đối tượng
 * (mọi tên riêng khách nhắc phải có trong câu hỏi / tên dự án). Khách không nhắc tên gì → chỉ tìm ở dự án đang xem.
 *
 * @return array|null
 */
function hh_chat_faq_match( $t, $page = 0 ) {
	$idx = hh_chat_faq_index();
	list( $cu, $rest ) = hh_chat_concepts( $t );
	$eu = hh_chat_entities( $rest );
	if ( ! $idx['rows'] || ( ! $cu && count( $eu ) < 2 ) ) {
		return null;
	}
	$idf  = static fn( $k ) => log( 1 + $idx['n'] / ( 1 + ( $idx['df'][ $k ] ?? 0 ) ) );
	$best = null;
	foreach ( $idx['rows'] as $r ) {
		$here = (int) $page && $r['id'] === (int) $page;
		if ( ! $eu && ! $here ) {
			continue;
		}
		$ci = array_intersect( $r['c'], array_keys( $cu ) );
		if ( $cu && ! $ci ) {
			continue;
		}
		$ei = array_intersect( $r['e'], array_keys( $eu ) );
		// Tên riêng khách nhắc mà câu hỏi mẫu không có → nói về chuyện khác.
		if ( $eu && count( $ei ) < max( 1, ceil( 0.75 * count( $eu ) ) ) ) {
			continue;
		}
		// Ngoài dự án đang xem: phải trùng từ "hiếm" (tên dự án, tên đường…), không chỉ "biển", "sông".
		if ( ! $here && array_sum( array_map( $idf, $ei ) ) < 4 ) {
			continue;
		}
		$s = 3 * count( $ci ) - 0.7 * count( array_diff( $r['c'], array_keys( $cu ) ) ) + ( $here ? 2 : 0 );
		foreach ( $ei as $k ) {
			$s += $idf( $k );
		}
		if ( ! $best || $s > $best['score'] ) {
			$best          = $r;
			$best['score'] = $s;
		}
	}
	return $best && $best['score'] >= 2.5 ? $best : null;
}

/**
 * Câu trả lời ngắn nối theo câu chat vừa hỏi ("để ở", "cho thuê", "gần biển", "ok", "chưa"…). '' nếu không phải.
 */
function hh_chat_followup( $t, $prev, $ctx ) {
	if ( mb_strlen( $t ) > 70 ) {
		return '';
	}
	$p      = mb_strtolower( remove_accents( $prev ) );
	$x      = $ctx['x'];
	$X      = 'anh/chị' === $x ? 'Anh/chị' : mb_convert_case( $x, MB_CASE_TITLE );
	$name   = $ctx['name'];
	$budget = $ctx['budget'];
	$lead   = $ctx['has_lead'];
	$zalo   = $lead ? '' : " $X để lại số Zalo, em gửi luôn danh sách kèm hình thực tế nhé.";
	$fmt    = static fn( $v ) => function_exists( 'hh_format_price' ) ? hh_format_price( $v ) : $v . ' triệu';

	// Chat vừa hỏi mục đích mua.
	$purpose = '/^(mua )?(de |cho )?(o|o that|thue|cho thue|dau tu|nghi duong|de danh|kinh doanh|an cu|dong tien)( a| thoi| em| nhe)?$/';
	$loose   = empty( $ctx['need'] ) && ! $budget && preg_match( '/\b(mua )?de o\b|\bo that\b|an cu|mua (de )?(cho thue|dau tu|nghi duong)/', $t );
	if ( preg_match( '/de o hay dau tu|nghi duong, cho thue hay de danh|mua de o hay dau tu|o hay dau tu/', $p ) || preg_match( $purpose, $t ) || $loose ) {
		if ( preg_match( '/\b(o|de o|o that|gia dinh|cho con|vo chong|an cu|song)\b/', $t ) && ! preg_match( '/dau tu|cho thue|kinh doanh/', $t ) ) {
			return "Dạ mua để ở thì em ưu tiên 3 thứ: pháp lý sạch, gần trường – chợ – bệnh viện, và hàng xóm \"văn minh\" 😊\n\n" . ( $budget ? "Với tầm {$fmt( $budget )}, em lọc vài căn hợp rồi gửi $x nhé." : "$X tính tầm tài chính khoảng bao nhiêu, nhà mấy người ở để em lọc đúng căn ạ?" );
		}
		if ( preg_match( '/cho thue|dong tien|thu nhap|kinh doanh|homestay|airbnb/', $t ) ) {
			return "Dạ mua cho thuê thì em nhìn vào \"dòng tiền\" trước, đẹp đâu chưa quan trọng bằng có người thuê đều 😄\n\nCăn hộ gần biển Mỹ Khê, gần sông Hàn cho thuê tốt nhất, khách du lịch và chuyên gia nước ngoài thuê quanh năm. " . ( $budget ? "Tầm {$fmt( $budget )} em có vài căn đang cho thuê sẵn, $x muốn xem bảng tính thu nhập không ạ?" : "$X dự tính vốn khoảng bao nhiêu để em tính thử thu nhập cho thuê ạ?" );
		}
		if ( preg_match( '/dau tu|luot|tang gia|de danh|giu tien|tich san|lau dai/', $t ) ) {
			return "Dạ đầu tư thì em nói thật: giữ trung – dài hạn ở Đà Nẵng an toàn hơn lướt sóng 😊\n\nĐất nền có sổ ở khu hạ tầng đang làm, hoặc căn hộ sở hữu lâu dài gần biển là hai hướng nhiều khách chọn. " . ( $budget ? "Vốn {$fmt( $budget )} thì $x thích đất hay căn hộ hơn ạ?" : "$X dự tính vốn khoảng bao nhiêu, giữ bao lâu ạ?" );
		}
		if ( preg_match( '/nghi duong|nghi he|ve huu|du lich|cuoi tuan/', $t ) ) {
			return "Dạ nghỉ dưỡng thì Đà Nẵng hợp lắm, sáng tắm biển, chiều cà phê, tối ăn hải sản 😄\n\nCăn hộ ven biển có đơn vị vận hành là tiện nhất: lúc $x không ở thì cho thuê, có thêm thu nhập. " . ( $budget ? "Tầm {$fmt( $budget )} em gửi $x vài căn view biển nhé." : "$X tính tầm tài chính khoảng bao nhiêu ạ?" );
		}
	}
	// Chat vừa hỏi gần biển hay sông.
	if ( preg_match( '/gan bien hay gan song/', $p ) ) {
		if ( preg_match( '/bien|my khe|son tra|non nuoc/', $t ) ) {
			return "Dạ gần biển là \"đặc sản\" Đà Nẵng rồi, sáng mở cửa là nghe sóng 🌊\n\nKhu ven biển Mỹ Khê – Sơn Trà – Ngũ Hành Sơn có nhiều căn hộ sở hữu lâu dài, cho thuê tốt. " . ( $budget ? "Tầm {$fmt( $budget )} em lọc vài căn view biển cho $x nhé." : "$X tính tầm tài chính khoảng bao nhiêu để em lọc căn ạ?" );
		}
		if ( preg_match( '/song|song han|trung tam|cau rong/', $t ) ) {
			return "Dạ ven sông Hàn thì tối nào cũng có \"view pháo hoa miễn phí\" mùa lễ hội đó $x 😄\n\nKhu trung tâm tiện đi làm, đi chơi, căn hộ ven sông cũng giữ giá tốt. " . ( $budget ? "Tầm {$fmt( $budget )} em gửi $x vài căn nhé." : "$X tính tầm tài chính khoảng bao nhiêu ạ?" );
		}
	}
	// Chat vừa hỏi lịch đi xem → khách trả lời giờ, ngày.
	if ( preg_match( '/tien ngay nao|buoi sang hay chieu|dat lich|lich (di )?xem/', $p ) ) {
		$call = $lead ? "$name sẽ gọi $x để chốt giờ ạ." : "$X để lại số điện thoại/Zalo, $name gọi chốt giờ và gửi vị trí cho $x nhé.";
		if ( preg_match( '/khuya|nua dem|dem|12h dem|1h sang|2h sang/', $t ) ) {
			return "Dạ khuya thì bảo vệ với nhà mẫu đều đi ngủ hết rồi $x ơi 😄\n\nXem nhà ban ngày mới thấy rõ nắng, hướng gió, đường vào. Nếu ban ngày $x bận, $name xem được buổi tối sớm (trước 21h) hoặc gọi video dẫn $x xem trước. $call";
		}
		if ( preg_match( '/\b(sang|chieu|toi|trua|mai|mot|hom nay|nay|cuoi tuan|thu (2|3|4|5|6|7|hai|ba|tu|nam|sau|bay)|chu nhat|t[2-7]|\d{1,2} ?(h|gio)|ngay \d)/', $t ) ) {
			return "Dạ được ạ, em ghi lịch cho $x 👍 $call";
		}
		if ( preg_match( '/^(luc nao cung duoc|tuy|gi cung duoc|khi nao cung duoc|bat ky)/', $t ) ) {
			return "Dạ vậy để $name xếp giờ đẹp nhất, nắng nhẹ xem nhà là chuẩn 😊 $call";
		}
	}
	// Đồng ý ngắn ("ok", "có", "ừ", "được", "gửi đi").
	if ( preg_match( '/^(ok|co|u|vang|da|duoc|dong y|gui (di|em|anh|chi|minh)?|gui|xem|muon|co a|co chu|ok em|duoc em|nhat tri|chuan)\b/', $t ) && preg_match( '/khong a\?|nhe\.?$|nhe a|a\?$/', $p ) ) {
		return $lead
			? "Dạ vâng, em báo $name gửi ngay cho $x qua Zalo ạ 👍 Có gì $x cứ nhắn em thêm nhé."
			: "Dạ vâng ạ 😊 $X cho em xin số Zalo, $name gửi ngay chi tiết, hình thực tế và bảng giá cho $x nhé.";
	}
	// Từ chối ngắn ("không", "chưa", "thôi").
	if ( preg_match( '/^(khong|chua|thoi|khong can|chua can|de sau|lan sau)\b/', $t ) && preg_match( '/\?|nhe/', $p ) ) {
		return "Dạ không sao đâu $x ạ, cứ thong thả 😊 Khi nào cần xem giá khu nào, $x nhắn em một câu là có liền.";
	}
	return '';
}

/**
 * Câu hỏi chung về mua bán nhà đất (không gắn dự án): người nước ngoài, vay, thủ tục, thuế phí, đặt cọc, chọn khu.
 * Không đưa con số tự đặt; chỗ nào cần số thì hẹn tính theo từng căn. '' nếu không phải.
 */
function hh_chat_general( $t, $ctx ) {
	$x    = $ctx['x'];
	$X    = 'anh/chị' === $x ? 'Anh/chị' : mb_convert_case( $x, MB_CASE_TITLE );
	$name = $ctx['name'];
	$rules = array(
		'/nguoi nuoc ngoai|viet kieu|foreigner|nguoi han|nguoi my|nuoc ngoai (mua|so huu|dung ten)/' => "Dạ có ạ 😊 Theo Luật Nhà ở, người nước ngoài được mua căn hộ trong dự án nhà ở thương mại (không thuộc khu vực hạn chế), mỗi tòa tối đa 30% số căn, sở hữu có thời hạn và được gia hạn; không đứng tên đất nền. Việt kiều có quốc tịch Việt Nam thì mua như người trong nước.\n\nDự án nào còn \"suất\" cho người nước ngoài thì $name kiểm tra giúp $x. $X đang để ý dự án nào ạ?",
		'/lai suat|vay (ngan hang|mua nha|duoc bao nhieu|toi da|may phan tram|bao nhieu)|ho tro vay|an han/' => "Dạ lãi suất thì mỗi ngân hàng, mỗi dự án một kiểu, nhiều dự án còn hỗ trợ lãi suất, ân hạn nợ gốc một thời gian 😊\n\nEm không muốn đọc đại một con số rồi sai với $x. $X cho em biết căn đang nhắm và tầm vốn tự có, $name tính lịch trả nợ từng tháng gửi $x xem nhé?",
		'/thu tuc|sang ten|chuyen nhuong (the nao|ra sao|can gi)|mua ban (the nao|can gi)|quy trinh mua/' => "Dạ thủ tục mua nhà có sổ gồm 4 bước gọn: kiểm tra sổ, quy hoạch → đặt cọc → công chứng hợp đồng → đóng thuế phí và sang tên ở văn phòng đăng ký đất đai. Căn dự án chưa có sổ thì ký hợp đồng mua bán hoặc chuyển nhượng hợp đồng với chủ đầu tư.\n\n$name đi cùng $x từ bước kiểm tra giấy tờ đến lúc cầm sổ. $X đang mua căn có sổ hay căn dự án ạ?",
		'/thue (phi|chuyen nhuong|thu nhap|truoc ba)|phi (sang ten|chuyen nhuong|cong chung|truoc ba)|le phi|ai chiu thue|ai dong thue/' => "Dạ khi sang tên thường có thuế thu nhập cá nhân của bên bán, lệ phí trước bạ của bên mua, phí công chứng và phí đăng ký; hai bên có thể thỏa thuận ai trả phần nào, ghi rõ trong hợp đồng cọc.\n\nMức cụ thể tính theo giá trị từng căn và quy định hiện hành, $name tính sẵn bảng chi phí cho $x trước khi đặt cọc nhé. $X đang xem căn nào ạ?",
		'/dat coc|coc (bao nhieu|may|lieu|truoc)|mat coc|lua coc|bo coc/' => "Dạ đặt cọc là bước \"dễ mất tiền\" nhất nên em dặn kỹ 😊 Xem sổ bản gốc, đúng người đứng tên (cả vợ chồng nếu là tài sản chung), ghi rõ thời hạn công chứng, ai trả thuế phí và phạt cọc nếu bên nào rút.\n\n$name soạn và kiểm tra hợp đồng cọc giúp $x. $X đang chuẩn bị cọc căn nào ạ?",
		'/thu nhap (tu )?cho thue|cho thue (duoc )?(bao nhieu|lai|co lai|loi)|loi suat cho thue|lai cho thue|cho thue (co )?(de|kho)/' => "Dạ theo báo cáo quý 3/2026 của Batdongsan.com.vn, căn hộ cho thuê ở Đà Nẵng lãi khoảng 4,5%/năm trên giá mua; căn gần biển, có đơn vị vận hành thường cho thuê đều hơn.\n\nMỗi căn một con số khác, $name tính bảng thu chi cụ thể cho $x nhé. $X đang để ý căn ở khu nào ạ?",
		'/(dep|tot|ngon|xin) ma (khong|ko) dat|(gia )?re ma (dep|tot|ngon|xin)|vua tui tien|gia mem|gia hat de|ngon bo re/' => "Dạ \"ngon – bổ – rẻ\" thì em săn được, chỉ là phải nhanh tay 😄\n\nThường là căn chủ cần bán gấp, căn tầng thấp, hoặc dự án ở khu mới như Hòa Xuân, Liên Chiểu. $X cho em tầm tiền khoảng bao nhiêu, em lọc ngay ạ?",
		'/khu nao (tot|dep|nen|dang|de|hop)|nen mua (o )?khu nao|o dau (tot|dep|de song)|quan nao (tot|nen)|khu vuc nao (tot|nen)/' => "Dạ mỗi khu một \"tính cách\" $x ạ 😄\n• Hải Châu: trung tâm, đi đâu cũng gần, giá cao.\n• Sơn Trà – Ngũ Hành Sơn ven biển: nghỉ dưỡng, cho thuê tốt.\n• Hòa Xuân, Nam Đà Nẵng: khu mới, hạ tầng đẹp, giá còn dễ thở.\n• Liên Chiểu, Thanh Khê: giá mềm, hợp mua để ở.\n$X mua để ở hay đầu tư, tầm tài chính bao nhiêu để em chọn đúng khu ạ?",
		'/gia (nha|can ho|chung cu|dat) (o )?da nang (bao nhieu|the nao|hien nay|gio)|thi truong (bat dong san |nha dat )?(da nang )?(the nao|sao roi|ra sao|hien nay)/' => "Dạ theo báo cáo quý 3/2026 của Batdongsan.com.vn: chung cư Đà Nẵng đi ngang quanh 67 triệu/m², cho thuê lãi khoảng 4,5%/năm; đất nền điều chỉnh khoảng 7%. Bài phân tích đầy đủ trên web mục Tin tức.\n\n$X đang quan tâm căn hộ hay đất để em gửi giá đúng khu ạ?",
	);
	foreach ( $rules as $re => $reply ) {
		if ( preg_match( $re, $t ) ) {
			return $reply;
		}
	}
	return '';
}
