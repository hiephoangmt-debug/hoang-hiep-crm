<?php
/**
 * Nhà ở xã hội cầu Tiên Sơn – khu đất A2-4, đường Ngũ Hành Sơn và đường dẫn lên cầu Tiên Sơn (phường Ngũ Hành Sơn).
 * Cập nhật 20/11/2026 theo tài liệu anh Hiệp gửi: Quyết định 3128/QĐ-UBND ngày 16/7/2026 giao chủ đầu tư (chỉ lấy thông tin,
 * không đăng ảnh scan văn bản), nội dung quy hoạch tổng mặt bằng, bản đồ quy hoạch phân khu (ô VS4-5 NOXH-2) và phối cảnh dự án.
 * Trang đã tạo từ du-an-tong-hop.json (cùng slug): ô nào còn đúng bản cũ thì thay bằng bản mới; ô anh đã tự sửa thì giữ.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$slug = 'nha-o-xa-hoi-a2-4-ngu-hanh-son';
		$img  = static fn( $f, $alt, $where, $t = '' ) => "plugin:img/noxh-cau-tien-son/noxh-cau-tien-son-$f.jpg | $alt | $where" . ( $t ? " | $t" : '' );

		$projects[] = array(
			'slug'    => $slug,
			'title'   => 'Nhà ở xã hội cầu Tiên Sơn – khu đất A2-4 đường Ngũ Hành Sơn',
			'type'    => array( 'can-ho-so-huu-lau-dai' ),
			'area'    => 'ngu-hanh-son',
			'excerpt' => 'Nhà ở xã hội cầu Tiên Sơn (khu đất A2-4, đường Ngũ Hành Sơn – đường dẫn cầu Tiên Sơn): 2 tháp 31 tầng, 2 tầng hầm, cao 123,1 m, khoảng 731 căn, khu đất 6.970 m²; liên danh A&T – Peninsula – Đông Đô làm chủ đầu tư theo Quyết định 3128/QĐ-UBND ngày 16/7/2026.',
			'meta'    => array(
				'hh_p_status'        => 'sap-mo-ban',
				'hh_p_developer'     => 'Liên danh Công ty CP Đầu tư Phát triển đô thị A&T Đà Nẵng – Công ty TNHH Peninsula Private Đà Nẵng – Công ty CP Đầu tư Phát triển đô thị A&T Bình Dương – Công ty TNHH Đông Đô Peninsula Đà Nẵng',
				'hh_p_type'          => 'Nhà ở xã hội (chung cư) – tên pháp lý: Dự án Nhà ở xã hội tại khu đất A2-4, đường Ngũ Hành Sơn và đường dẫn lên cầu Tiên Sơn',
				'hh_p_address'       => 'Khu đất A2-4, góc đường Ngũ Hành Sơn và đường dẫn lên cầu Tiên Sơn (vòng xoay Ngũ Hành Sơn – Hồ Xuân Hương – Lê Văn Hiến), phường Ngũ Hành Sơn, Đà Nẵng',
				'hh_p_map_address'   => 'Cầu Tiên Sơn, Ngũ Hành Sơn, Đà Nẵng',
				'hh_p_scale'         => 'Khu đất 6.970 m²; tổng diện tích sàn xây dựng 82.945 m²; dân số khoảng 1.412 người; vốn sơ bộ khoảng 1.225 tỷ đồng',
				'hh_p_blocks'        => '2 tháp: tháp A (xây dựng 862 m²) và tháp B (xây dựng 1.440 m²)',
				'hh_p_floors'        => '31 tầng, 2 tầng hầm, cao 123,1 m (tính từ cốt vỉa hè)',
				'hh_p_units'         => 'Khoảng 731 căn theo hồ sơ quy hoạch tổng mặt bằng (175 căn giữ lại cho thuê); báo chí năm 2025 ghi khoảng 831 căn',
				'hh_p_density'       => 'Mật độ xây dựng 33%; hệ số sử dụng đất 9,4 lần; cây xanh 20,4%',
				'hh_p_legal'         => "Chấp thuận chủ trương đầu tư: Quyết định 1942/QĐ-UBND ngày 24/6/2025\nGiao chủ đầu tư: Quyết định 3128/QĐ-UBND ngày 16/7/2026 của UBND TP Đà Nẵng\nĐang lập quy hoạch tổng mặt bằng; chưa nhận hồ sơ đăng ký mua",
				'hh_p_ownership'     => 'Nhà ở xã hội: được cấp giấy chứng nhận, hạn chế chuyển nhượng trong thời gian theo quy định của Luật Nhà ở',
				'hh_p_handover'      => 'Xây dựng và đưa vào vận hành trong 3 năm kể từ khi được giao đất (theo quyết định giao chủ đầu tư)',
				'hh_p_highlights'    => "Nhà ở xã hội ngay chân cầu Tiên Sơn – sang trung tâm Hải Châu chỉ một cây cầu\n2 tháp 31 tầng, cao 123,1 m – một trong những dự án nhà ở xã hội cao nhất Đà Nẵng\nMật độ xây dựng 33%, cây xanh 20,4% khu đất\nChủ đầu tư cùng nhóm A&T – Peninsula (Peninsula Đà Nẵng, Peninsula Private)",
				'hh_p_location_desc' => 'Khu đất A2-4 rộng 6.970 m² nằm ở góc vòng xoay nơi giao nhau giữa đường Ngũ Hành Sơn, đường dẫn lên cầu Tiên Sơn, đường Hồ Xuân Hương và đường Lê Văn Hiến. Ranh giới: phía Đông giáp đường Ngũ Hành Sơn, phía Nam giáp đường dẫn lên cầu Tiên Sơn, phía Tây giáp hành lang tuyến điện, phía Bắc giáp trụ sở công an phường. Trong quy hoạch phân khu Ven sông Hàn và bờ Đông (tỷ lệ 1/2000), khu đất là ô đất nhà ở xã hội NOXH-2.',
				'hh_p_design_desc'   => 'Hai tòa tháp 31 tầng trên 2 tầng hầm, công trình chiếm 2.302 m² (33% khu đất – tháp A 862 m², tháp B 1.440 m²); cây xanh cảnh quan 1.420 m² (20,4%); giao thông nội bộ, sân bãi 3.248 m² (46,6%). Hệ số sử dụng đất 9,4 lần, tổng sàn 82.945 m², khoảng lùi tối thiểu 6 m so với chỉ giới đường đỏ.',
				'hh_p_connections'   => "Ngay chân cầu | Cầu Tiên Sơn sang Hải Châu\nVài phút | Đường Hồ Xuân Hương ra biển Mỹ Khê – Non Nước (ước tính)\nVài phút | Cung thể thao Tiên Sơn bên kia cầu (ước tính)",
				'hh_p_progress'      => "24/6/2025 | Chấp thuận chủ trương đầu tư (Quyết định 1942/QĐ-UBND)\n16/7/2026 | Giao chủ đầu tư cho liên danh A&T – Peninsula – Đông Đô (Quyết định 3128/QĐ-UBND)\n11/2026 | Lập quy hoạch tổng mặt bằng: 2 tháp 31 tầng, khoảng 731 căn",
				'hh_p_policy'        => "Đối tượng: người thuộc diện được mua nhà ở xã hội theo Luật Nhà ở 2023 (người thu nhập thấp tại đô thị, công nhân, cán bộ công chức viên chức, lực lượng vũ trang…)\nChỉ nộp hồ sơ khi Sở Xây dựng và chủ đầu tư công khai thông tin tiếp nhận hồ sơ",
				'hh_p_image_links'   => implode(
					"\n",
					array(
						$img( 'phoi-canh-ven-song', 'Phối cảnh nhà ở xã hội cầu Tiên Sơn – 2 tháp 31 tầng nhìn từ công viên ven sông', 'đại diện', 'Phối cảnh dự án' ),
						$img( 'ban-do-quy-hoach-khu-dat-a2-4', 'Bản đồ quy hoạch: khu đất A2-4 (ô NOXH-2) tại vòng xoay đường Ngũ Hành Sơn – đường dẫn cầu Tiên Sơn – Hồ Xuân Hương – Lê Văn Hiến', 'tổng thể', 'Vị trí khu đất trên bản đồ quy hoạch' ),
					)
				),
			),
			'content' => '<p><strong>Nhà ở xã hội cầu Tiên Sơn</strong> là tên thường gọi của Dự án Nhà ở xã hội tại khu đất A2-4, đường Ngũ Hành Sơn và đường dẫn lên cầu Tiên Sơn, phường Ngũ Hành Sơn. Ngày 16/7/2026, UBND TP Đà Nẵng ban hành Quyết định 3128/QĐ-UBND giao liên danh Công ty CP Đầu tư Phát triển đô thị A&amp;T Đà Nẵng, Công ty TNHH Peninsula Private Đà Nẵng, Công ty CP Đầu tư Phát triển đô thị A&amp;T Bình Dương và Công ty TNHH Đông Đô Peninsula Đà Nẵng làm chủ đầu tư.</p>
<h2>Quy mô theo quy hoạch tổng mặt bằng</h2>
<table>
<thead><tr><th>Hạng mục</th><th>Quy mô</th></tr></thead>
<tbody>
<tr><td>Diện tích khu đất</td><td>6.970 m²</td></tr>
<tr><td>Diện tích xây dựng công trình</td><td>2.302 m² (tháp A 862 m², tháp B 1.440 m²)</td></tr>
<tr><td>Mật độ xây dựng</td><td>33%</td></tr>
<tr><td>Hệ số sử dụng đất</td><td>9,4 lần</td></tr>
<tr><td>Số tầng</td><td>31 tầng, 2 tầng hầm</td></tr>
<tr><td>Chiều cao công trình</td><td>123,1 m (tính từ cốt vỉa hè)</td></tr>
<tr><td>Tổng diện tích sàn</td><td>82.945 m²</td></tr>
<tr><td>Dân số</td><td>Khoảng 1.412 người</td></tr>
<tr><td>Cây xanh cảnh quan</td><td>1.420 m² (20,4%)</td></tr>
<tr><td>Giao thông nội bộ, sân bãi</td><td>3.248 m² (46,6%)</td></tr>
</tbody>
</table>
<p>Theo hồ sơ quy hoạch tổng mặt bằng, dự án có khoảng 731 căn hộ, trong đó chủ đầu tư giữ lại 175 căn để cho thuê. Số căn bán theo cơ chế nhà ở xã hội chính thức sẽ theo văn bản phê duyệt và thông báo của Sở Xây dựng.</p>
<h2>Vị trí</h2>
<p>Khu đất nằm ở góc vòng xoay đường Ngũ Hành Sơn – đường dẫn lên cầu Tiên Sơn – Hồ Xuân Hương – Lê Văn Hiến: phía Đông giáp đường Ngũ Hành Sơn, phía Nam giáp đường dẫn lên cầu Tiên Sơn, phía Tây giáp hành lang tuyến điện, phía Bắc giáp trụ sở công an phường. Từ đây qua cầu Tiên Sơn là tới Hải Châu – hiếm dự án nhà ở xã hội nào gần trung tâm như vậy.</p>
<h2>Pháp lý &amp; tiến độ</h2>
<ul>
<li>24/6/2025: chấp thuận chủ trương đầu tư (Quyết định 1942/QĐ-UBND).</li>
<li>16/7/2026: giao chủ đầu tư (Quyết định 3128/QĐ-UBND).</li>
<li>11/2026: đang lập quy hoạch tổng mặt bằng; xây dựng và đưa vào vận hành trong 3 năm kể từ khi được giao đất.</li>
</ul>
<p>Dự án <strong>chưa nhận hồ sơ đăng ký mua</strong>. Người có nhu cầu nên chuẩn bị trước giấy tờ xác nhận đối tượng, thu nhập, điều kiện nhà ở và chỉ nộp hồ sơ theo thông báo chính thức. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để được báo ngay khi dự án mở nhận hồ sơ.</p>',
			'sources' => array(
				'https://tuoitre.vn/du-an-nha-o-xa-hoi-hon-1225-ti-dong-vua-duoc-da-nang-giao-chu-dau-tu-thuc-hien-100260716175913488.htm',
				'https://cafeland.vn/tin-tuc/doanh-nghiep-nao-thuc-hien-du-an-nha-o-xa-hoi-hon-1225-ty-dong-tai-thanh-pho-da-nang-153347.html',
				'https://baodautu.vn/da-nang-dau-tu-du-an-nha-o-xa-hoi-hon-1225-ty-dong-d314442.html',
			),
		);
		// Ô nào còn đúng bản tạo từ du-an-tong-hop.json thì thay bằng bản mới.
		$new = &$projects[ count( $projects ) - 1 ];
		if ( function_exists( 'hh_du_an_tong_hop' ) ) {
			foreach ( hh_du_an_tong_hop()['projects'] as $j ) {
				if ( $slug !== ( $j['slug'] ?? '' ) ) {
					continue;
				}
				foreach ( (array) ( $j['meta'] ?? array() ) as $k => $v ) {
					if ( '' !== (string) $v && isset( $new['meta'][ $k ] ) && (string) $new['meta'][ $k ] !== (string) $v ) {
						$new['fix_meta'][ $k ][] = (string) $v;
					}
				}
				$new['fix_content'] = array( (string) ( $j['content'] ?? '' ) );
				$new['fix_excerpt'] = (string) ( $j['excerpt'] ?? '' );
				$new['fix_title']   = array( (string) ( $j['title'] ?? '' ) );
			}
		}
		unset( $new );
		return $projects;
	},
	20 // Trước data-du-an-tong-hop.php (30) – bản JSON cùng slug sẽ không tạo trùng.
);
