<?php
/**
 * Hỏi đáp trang dự án theo đúng cách khách gõ trên Google (gợi ý tìm kiếm Google, 11/2026):
 * đổi câu hỏi tự tạo ("Khi nào Cora Tower Đà Nẵng bàn giao?" → "Cora Tower khi nào bàn giao?"),
 * thêm câu cho cách gõ khác ("Sun Sapphire", "Four S Tower", "The Legend City").
 * Câu trả lời giữ nguyên dữ liệu dự án; câu thêm mới chỉ dùng số liệu đã có trên web.
 *
 * @package HoangHiepCRM
 */

defined( 'ABSPATH' ) || exit;

function hh_faq_cach_go() {
	return array(
		'nobu-da-nang' => array(
			'doi'  => array(
				'/^Chủ đầu tư dự án .+ là ai\?$/u' => 'Nobu Đà Nẵng của ai, chủ đầu tư là ai?',
				'/^.+ nằm ở đâu\?$/u'              => 'Nobu Đà Nẵng ở đâu, địa chỉ ở đâu?',
				'/^Khi nào .+ bàn giao\?$/u'       => 'Nobu Đà Nẵng khi nào bàn giao?',
				'/^Giá bán .+ hiện nay bao nhiêu\?$/u' => 'Nobu Đà Nẵng giá bao nhiêu?',
			),
			'them' => array(
				array( 'Nobu Đà Nẵng bao nhiêu tầng?', 'Tòa tháp cao 43 tầng nổi (khoảng 186 m) và 2 tầng hầm, gồm 264 căn hộ hàng hiệu và khách sạn Nobu khoảng 200 phòng (gồm 18 suite). Tháng 10/2026 kết cấu đã đến tầng 22.' ),
			),
		),
		'the-legend-da-nang' => array(
			'doi'  => array(
				'/^Chủ đầu tư dự án .+ là ai\?$/u' => 'The Legend Đà Nẵng của chủ đầu tư nào?',
				'/^.+ nằm ở đâu\?$/u'              => 'The Legend Đà Nẵng ở đâu, địa chỉ ở đâu?',
				'/^Khi nào .+ bàn giao\?$/u'       => 'The Legend Đà Nẵng khi nào bàn giao?',
				'/^Giá bán .+ hiện nay bao nhiêu\?$/u' => 'The Legend Đà Nẵng giá bao nhiêu?',
			),
			'them' => array(
				array( 'The Legend City và The Legend Đà Nẵng có phải một dự án không?', 'Đúng. The Legend City Danang (Thành phố huyền thoại – Đà Nẵng) là tên đầy đủ của dự án The Legend trên lô A20 Võ Văn Kiệt, ngay đầu cầu Rồng, chủ đầu tư Công ty TNHH MTV VIPICO.' ),
			),
		),
		'symphony-5-sun-symphony-residence' => array(
			'doi'  => array(
				'/^Chủ đầu tư dự án .+ là ai\?$/u' => 'Sun Symphony 5 của chủ đầu tư nào?',
				'/^.+ nằm ở đâu\?$/u'              => 'Sun Symphony 5 ở đâu?',
				'/^Khi nào .+ bàn giao\?$/u'       => 'Sun Symphony 5 khi nào bàn giao?',
				'/^Giá bán .+ hiện nay bao nhiêu\?$/u' => 'Giá Sun Symphony 5 bao nhiêu?',
				'/^Pháp lý và hình thức sở hữu của .+ thế nào\?$/u' => 'Sun Symphony 5 sở hữu bao lâu, pháp lý thế nào?',
			),
		),
		'cora-tower' => array(
			'doi' => array(
				'/^.+ nằm ở đâu\?$/u'                  => 'Cora Tower ở đâu?',
				'/^Khi nào .+ bàn giao\?$/u'           => 'Cora Tower khi nào bàn giao?',
				'/^Giá bán .+ hiện nay bao nhiêu\?$/u' => 'Cora Tower giá bao nhiêu?',
			),
		),
		'spana-tower' => array(
			'doi' => array(
				'/^.+ nằm ở đâu\?$/u'                  => 'Spana Tower ở đâu?',
				'/^Khi nào .+ bàn giao\?$/u'           => 'Spana Tower khi nào bàn giao?',
				'/^Giá bán .+ hiện nay bao nhiêu\?$/u' => 'Spana Tower giá bao nhiêu?',
			),
		),
		's-light-tower' => array(
			'doi' => array(
				'/^.+ nằm ở đâu\?$/u'                  => 'S-Light Tower ở đâu, vị trí thế nào?',
				'/^Khi nào .+ bàn giao\?$/u'           => 'S-Light Tower khi nào bàn giao?',
				'/^Giá bán .+ hiện nay bao nhiêu\?$/u' => 'S-Light Tower giá bao nhiêu?',
			),
		),
		'capital-square-da-nang' => array(
			'doi' => array(
				'/^Chủ đầu tư dự án .+ là ai\?$/u' => 'Capital Square Đà Nẵng chủ đầu tư là ai?',
				'/^.+ nằm ở đâu\?$/u'              => 'Capital Square Đà Nẵng ở đâu?',
				'/^Khi nào .+ bàn giao\?$/u'       => 'Capital Square Đà Nẵng khi nào bàn giao?',
				'/^Giá bán .+ hiện nay bao nhiêu\?$/u' => 'Capital Square Đà Nẵng giá bao nhiêu?',
			),
		),
	);
}

add_filter(
	'hh_project_faq',
	static function ( $rows, $post_id ) {
		$cfg = hh_faq_cach_go()[ get_post_field( 'post_name', $post_id ) ] ?? null;
		if ( ! $cfg ) {
			return $rows;
		}
		foreach ( $rows as &$r ) {
			foreach ( $cfg['doi'] ?? array() as $re => $q ) {
				if ( preg_match( $re, (string) $r[0] ) ) {
					$r[0] = $q;
					break;
				}
			}
		}
		unset( $r );
		$have = array_map( static fn( $r ) => mb_strtolower( (string) $r[0] ), $rows );
		foreach ( $cfg['them'] ?? array() as $add ) {
			if ( ! in_array( mb_strtolower( $add[0] ), $have, true ) ) {
				$rows[] = $add;
			}
		}
		return $rows;
	},
	10,
	2
);
