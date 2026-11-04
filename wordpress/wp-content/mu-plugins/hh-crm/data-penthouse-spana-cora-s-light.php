<?php
/**
 * Penthouse Spana – Cora – S-Light (Sun Group, Sun NeO City): thông tin từ bộ layout penthouse chủ đầu tư gửi đại lý
 * (anh Hiệp chuyển 04/11/2026; bản vẽ A0 trên Drive): tầng penthouse, tòa, loại căn, gợi ý duplex tầng lửng.
 * Chưa ghi diện tích từng căn vì chưa xem được bản vẽ rõ; không ghi mã căn. Ảnh bìa bài tin tự vẽ.
 */

defined( 'ABSPATH' ) || exit;

/** Mô tả penthouse mới cho trang dự án. */
function hh_penthouse_sun_neo_meta() {
	$dot = ' Thuộc đợt mở bán penthouse – shophouse khối đế giới hạn của Sun Property (từ 8/2026). Nhận layout từng căn, giá và chính sách: Zalo Hoàng Hiệp 0904 567 009.';
	return array(
		'spana-tower'   => array(
			'hh_p_penthouse_desc' => 'Penthouse nằm ở tầng 22 – tầng trên cùng của hai tòa S1, S2, gồm các căn 1PN+, 2PN và 3PN, tầm nhìn thoáng ra sông Cẩm Lệ và cầu Hòa Xuân. Chủ đầu tư có sẵn gợi ý thiết kế duplex: làm thêm tầng lửng trong căn để tăng diện tích sử dụng, có mặt bằng tầng chính và tầng lửng riêng.' . $dot,
			'hh_p_duplex_desc'    => 'Căn penthouse tầng 22 (tòa S1, S2) có gợi ý thiết kế duplex của chủ đầu tư – bố trí thêm tầng lửng, áp dụng cho căn 1PN+, 2PN và 3PN. Liên hệ để nhận mặt bằng tầng chính và tầng lửng từng căn.',
		),
		'cora-tower'    => array(
			'hh_p_penthouse_desc' => 'Penthouse nằm ở tầng 25 – tầng trên cùng của hai tòa A1, A2, gồm căn 1PN, 2PN và 2PN+1, tầm nhìn sông – núi – biển. Chủ đầu tư có gợi ý thiết kế duplex làm thêm tầng lửng (mặt bằng tầng chính và tầng lửng riêng).' . $dot,
			'hh_p_duplex_desc'    => 'Căn penthouse tầng 25 (tòa A1, A2) có gợi ý thiết kế duplex của chủ đầu tư – bố trí thêm tầng lửng. Liên hệ để nhận mặt bằng tầng chính và tầng lửng từng căn.',
		),
		's-light-tower' => array(
			'hh_p_penthouse_desc' => 'Penthouse nằm ở tầng 22 – tầng trên cùng của hai tòa SL1, SL2, nơi giao ba dòng sông: tầm nhìn sông Hàn, sông Cẩm Lệ và sông Đô Tỏa.' . $dot,
		),
	);
}

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$new = hh_penthouse_sun_neo_meta();
		foreach ( $projects as $i => $p ) {
			$slug = $p['slug'] ?? '';
			if ( ! isset( $new[ $slug ] ) ) {
				continue;
			}
			foreach ( $new[ $slug ] as $key => $value ) {
				$old = (string) ( $p['meta'][ $key ] ?? '' );
				// Mô tả chung chung cũ (chưa sửa tay) → thay bằng mô tả mới.
				$olds = array_filter( array( $old, 'Có căn Penthouse trên các tầng cao – liên hệ để nhận danh sách căn.', 'Có căn penthouse trên các tầng cao – liên hệ để nhận danh sách căn.', 'Có dòng Penthouse – liên hệ để nhận danh sách căn.' ), static fn( $v ) => '' !== $v && $v !== $value );
				if ( $olds ) {
					$projects[ $i ]['fix_meta'][ $key ] = array_values( array_unique( array_merge( (array) ( $p['fix_meta'][ $key ] ?? array() ), $olds ) ) );
				}
				$projects[ $i ]['meta'][ $key ] = $value;
			}
		}
		return $projects;
	},
	60
);

add_filter( 'hh_news_posts', 'hh_posts_penthouse_spana_cora_s_light' );
function hh_posts_penthouse_spana_cora_s_light( $posts ) {
	$posts[] = array(
		'slug'          => 'penthouse-spana-cora-s-light-sun-neo-city',
		'title'         => 'Penthouse Spana, Cora, S-Light: tầng đỉnh giới hạn của Sun Group tại Hòa Xuân',
		'excerpt'       => 'Sun Property giới thiệu dòng penthouse tầng trên cùng của ba dự án Spana Tower (tầng 22), Cora Tower (tầng 25) và S-Light Tower (tầng 22) tại Sun NeO City, Đà Nẵng – số căn ít, tầm nhìn sông thoáng nhất, có gợi ý thiết kế duplex tầng lửng.',
		'keyword'       => 'penthouse Spana Cora S-Light',
		'project'       => 'spana-tower',
		'category'      => 'Dự án',
		'date'          => '2026-11-04 17:00:00',
		'image'         => 'plugin:img/tin-tuc/penthouse-spana-cora-s-light.jpg',
		'image_alt'     => 'Penthouse tầng đỉnh Spana Tower, Cora Tower, S-Light Tower – Sun Group Đà Nẵng',
		'image_caption' => 'Penthouse ba dự án Spana, Cora, S-Light (Hoàng Hiệp tổng hợp).',
		'content'       => <<<'HTML'
<p>Sun Property vừa gửi bộ layout <strong>penthouse</strong> của ba dự án căn hộ tại khu đô thị Sun NeO City (Hòa Xuân, Đà Nẵng): <a href="/du-an/spana-tower/">Spana Tower</a>, <a href="/du-an/cora-tower/">Cora Tower</a> và <a href="/du-an/s-light-tower/">S-Light Tower</a>. Điểm chung: penthouse nằm ở <strong>tầng trên cùng</strong> mỗi tòa, số căn rất ít, tầm nhìn thoáng nhất dự án – dòng sản phẩm thuộc đợt mở bán penthouse và shophouse khối đế giới hạn Sun Property công bố từ tháng 8/2026.</p>
<!--hh-featured-->

<h2>Penthouse ba dự án khác nhau thế nào?</h2>
<table>
<thead><tr><th>Dự án</th><th>Tầng penthouse</th><th>Loại căn</th><th>Điểm nhấn</th></tr></thead>
<tbody>
<tr><td>Spana Tower</td><td>Tầng 22, tòa S1 và S2</td><td>1PN+, 2PN, 3PN</td><td>Chân cầu Hòa Xuân, ven sông Cẩm Lệ; có gợi ý duplex tầng lửng</td></tr>
<tr><td>Cora Tower</td><td>Tầng 25, tòa A1 và A2</td><td>1PN, 2PN, 2PN+1</td><td>Giao lộ Nguyễn Phước Lan – 29/3, trung tâm Sun NeO City; có gợi ý duplex tầng lửng</td></tr>
<tr><td>S-Light Tower</td><td>Tầng 22, tòa SL1 và SL2</td><td>Theo layout tầng 22</td><td>Ngã ba sông Hàn – Cẩm Lệ – Đô Tỏa</td></tr>
</tbody>
</table>

<h2>Gợi ý duplex: thêm tầng lửng trong căn</h2>
<p>Với Spana và Cora, chủ đầu tư đưa kèm bản <strong>gợi ý thiết kế duplex</strong>: mỗi căn penthouse có mặt bằng tầng chính và mặt bằng tầng lửng riêng. Làm thêm tầng lửng giúp tăng diện tích sử dụng – tách khu ngủ với khu sinh hoạt, hoặc thêm phòng làm việc, phòng cho thuê. Diện tích tầng lửng, chiều cao thông thủy và điều kiện thi công từng căn cần xem bản vẽ và quy định của chủ đầu tư trước khi chọn căn.</p>

<h2>Penthouse hợp với ai?</h2>
<ul>
<li><strong>Người mua để ở lâu dài</strong> muốn tầm nhìn sông thoáng, ít bị che chắn, ít căn chung tầng.</li>
<li><strong>Người đầu tư dài hạn</strong>: số lượng căn tầng đỉnh có hạn, khó tạo nguồn cung mới cùng vị trí.</li>
<li><strong>Gia đình cần thêm không gian</strong> nhờ phương án duplex tầng lửng.</li>
</ul>
<p>Lưu ý: penthouse thường có giá cao hơn căn tầng điển hình cùng loại; nên so tổng giá, diện tích sử dụng thực tế (gồm tầng lửng nếu làm) và tiến độ thanh toán trước khi quyết định. Xem thêm <a href="/du-an/spana-tower/">tiến độ Spana Tower tháng 11/2026</a>.</p>
<p>Nhận layout từng căn penthouse Spana, Cora, S-Light, giá và chính sách mới nhất: nhắn Zalo Hoàng Hiệp 0904 567 009.</p>
<p class="src">Nguồn: bộ layout penthouse của chủ đầu tư (11/2026); thông báo mở bán penthouse – shophouse khối đế giới hạn của Sun Property (8/2026). Thông tin tham khảo, thông số chính thức theo văn bản ký kết.</p>
HTML,
		'seo'           => array(
			'seo_title' => 'Penthouse Spana, Cora, S-Light – tầng đỉnh Sun NeO City',
			'desc'      => 'Penthouse tầng đỉnh Spana Tower (tầng 22), Cora Tower (tầng 25), S-Light Tower (tầng 22) của Sun Group tại Hòa Xuân, Đà Nẵng: loại căn, gợi ý duplex tầng lửng.',
			'points'    => array(
				'Spana Tower: penthouse tầng 22 tòa S1, S2 – căn 1PN+, 2PN, 3PN, có gợi ý duplex tầng lửng.',
				'Cora Tower: penthouse tầng 25 tòa A1, A2 – căn 1PN, 2PN, 2PN+1, có gợi ý duplex tầng lửng.',
				'S-Light Tower: penthouse tầng 22 tòa SL1, SL2 – view sông Hàn, Cẩm Lệ, Đô Tỏa.',
				'Thuộc đợt mở bán penthouse – shophouse khối đế giới hạn của Sun Property (từ 8/2026).',
			),
			'faq'       => array(
				array( 'Penthouse Spana Tower nằm ở tầng mấy?', 'Tầng 22 – tầng trên cùng của hai tòa S1, S2, gồm căn 1PN+, 2PN và 3PN.' ),
				array( 'Penthouse Cora Tower nằm ở tầng mấy?', 'Tầng 25 – tầng trên cùng của hai tòa A1, A2, gồm căn 1PN, 2PN và 2PN+1.' ),
				array( 'Penthouse S-Light Tower nằm ở tầng mấy?', 'Tầng 22 của hai tòa SL1, SL2, tầm nhìn sông Hàn, sông Cẩm Lệ và sông Đô Tỏa.' ),
				array( 'Gợi ý duplex penthouse là gì?', 'Chủ đầu tư đưa phương án làm thêm tầng lửng trong căn penthouse (Spana, Cora), có mặt bằng tầng chính và tầng lửng riêng để tăng diện tích sử dụng.' ),
			),
		),
		'sources'       => array( 'https://dantri.com.vn/bat-dong-san/sun-property-ra-mat-dong-penthouse-shophouse-khoi-de-gioi-han-tai-nam-trung-tam-da-nang-20260811094649419.htm' ),
	);
	return $posts;
}

// Mặt bằng penthouse (bản vẽ chủ đầu tư A0 trên Drive, 18 – 25 MB): dùng link ảnh thu nhỏ của Drive (rộng 2400 px)
// để web tải được (web chỉ nhận ảnh dưới 15 MB). Nối thêm vào danh sách ảnh hiện có của từng dự án.
add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$th   = static fn( $id, $alt, $title ) => "https://drive.google.com/thumbnail?id=$id&sz=w2400 | $alt (bản vẽ chủ đầu tư, tham khảo) | mặt bằng | $title";
		$add  = array(
			'spana-tower'   => array(
				$th( '1qPj0247yqcTbqWJJzAApyt4GUx_thdC6', 'Mặt bằng tầng 22 penthouse tòa S1 Spana Tower', 'S1 – Tầng 22 penthouse' ),
				$th( '13uXwUJELljXRJ5rXiX8NafJkYqGLiCPp', 'Gợi ý duplex penthouse tầng 22 tòa S1 Spana Tower – tầng chính', 'S1 – Penthouse duplex (tầng chính)' ),
				$th( '11OpvLwoMa5K2aVsSPTPdEsWPP8RT7N2h', 'Gợi ý duplex penthouse tầng 22 tòa S1 Spana Tower – tầng lửng', 'S1 – Penthouse duplex (tầng lửng)' ),
				$th( '1mvKILKKt-adN4eF2qleZgh5viCkBENkV', 'Mặt bằng tầng 22 penthouse tòa S2 Spana Tower', 'S2 – Tầng 22 penthouse' ),
				$th( '1zPlfUs3Bk_Oi6SCJf3r1SoSYDapKltHw', 'Gợi ý duplex penthouse tầng 22 tòa S2 Spana Tower – tầng chính', 'S2 – Penthouse duplex (tầng chính)' ),
				$th( '1KErVLcN7UGT-ZvxGYDPDMc4PUbKy8tsE', 'Gợi ý duplex penthouse tầng 22 tòa S2 Spana Tower – tầng lửng', 'S2 – Penthouse duplex (tầng lửng)' ),
			),
			'cora-tower'    => array(
				$th( '1DeZ_Zj9gp4LwldG-D97NEifbYqsouZJr', 'Mặt bằng tầng 25 penthouse tòa A1 Cora Tower', 'A1 – Tầng 25 penthouse' ),
				$th( '1MHwHaNY9eY-QrZM33JxWpPYS6QysYAMB', 'Gợi ý duplex penthouse tầng 25 tòa A1 Cora Tower – tầng chính', 'A1 – Penthouse duplex (tầng chính)' ),
				$th( '1TsE0z3Lhnr-hvP3f0wLyfpJr_03U7c2z', 'Gợi ý duplex penthouse tầng 25 tòa A1 Cora Tower – tầng lửng', 'A1 – Penthouse duplex (tầng lửng)' ),
				$th( '18QrJj4Yg7I5J9f73O1gfmkxZJklUtXjY', 'Mặt bằng tầng 25 penthouse tòa A2 Cora Tower', 'A2 – Tầng 25 penthouse' ),
				$th( '1ssew8F9oc0R39HMtEOAy6kzVATW9G7mB', 'Gợi ý duplex penthouse tầng 25 tòa A2 Cora Tower – tầng chính', 'A2 – Penthouse duplex (tầng chính)' ),
				$th( '1NP04DODlPP10hu3oL6fDHVfc__XSrWGB', 'Gợi ý duplex penthouse tầng 25 tòa A2 Cora Tower – tầng lửng', 'A2 – Penthouse duplex (tầng lửng)' ),
			),
			's-light-tower' => array(
				$th( '1Uh4cy2bMQRx3PmVLFqAGJVvIcppD-0li', 'Mặt bằng tầng 22 penthouse tòa SL1, SL2 S-Light Tower – view sông Hàn, Cẩm Lệ, Đô Tỏa', 'Tầng 22 penthouse (SL1, SL2)' ),
			),
		);
		foreach ( $projects as $i => $p ) {
			$slug = $p['slug'] ?? '';
			if ( empty( $add[ $slug ] ) ) {
				continue;
			}
			$cur = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			if ( false !== strpos( $cur, 'drive.google.com/thumbnail' ) ) {
				continue;
			}
			$projects[ $i ]['meta']['hh_p_image_links'] = trim( $cur . "\n" . implode( "\n", $add[ $slug ] ) );
			if ( '' !== $cur ) {
				$projects[ $i ]['fix_meta']['hh_p_image_links'] = array_merge( (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() ), array( $cur ) );
			}
		}
		return $projects;
	},
	66 // Sau ảnh shophouse Spana (65).
);
