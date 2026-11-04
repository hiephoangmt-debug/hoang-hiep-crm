<?php
/**
 * Meta City Tam Kỳ (Him Lam Meta City) – khu đô thị kiểu mẫu Tây Bắc Tam Kỳ, phường Bàn Thạch (TP Đà Nẵng mới).
 * Nguồn: tài liệu thông tin dự án, danh mục phối cảnh cảnh quan và bản vẽ quy hoạch (QĐ 3856/2023) anh Hiệp gửi 04/11/2026.
 * Giá là giá dự kiến tham khảo của GĐ1. Ảnh quy hoạch đã cắt bỏ khung tên, con dấu, chữ ký.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_project_dataset', 'hh_dataset_meta_city_tam_ky', 20 );
function hh_dataset_meta_city_tam_ky( $projects ) {
	$img   = static fn( $file, $alt, $where, $title = '' ) => "plugin:img/meta-city-tam-ky/meta-city-tam-ky-$file.jpg | $alt | $where" . ( $title ? " | $title" : '' );
	$lines = array(
		$img( 'phoi-canh-tong-the', 'Phối cảnh tổng thể Meta City Tam Kỳ – khu đô thị 76,19 ha ven sông, cửa ngõ phía Bắc Tam Kỳ', 'đại diện' ),
		$img( 'nha-pho-goc-1', 'Phối cảnh nhà phố thương mại Meta City Tam Kỳ (dự kiến) – căn góc', 'thư viện' ),
		$img( 'nha-pho-goc-2', 'Phối cảnh dãy nhà phố thương mại Meta City Tam Kỳ (dự kiến)', 'thư viện' ),
		$img( 'nha-pho-goc-3', 'Phối cảnh nhà phố thương mại Meta City Tam Kỳ (dự kiến) – góc nhìn 3', 'thư viện' ),
		$img( 'khu-ven-kenh', 'Phối cảnh khu ven kênh Meta City Tam Kỳ nhìn từ trên cao', 'thư viện' ),
		$img( 'quy-hoach-1-500', 'Quy hoạch chi tiết 1/500 Khu đô thị kiểu mẫu Tây Bắc Tam Kỳ (Meta City) – điều chỉnh cục bộ theo QĐ 3856/2023', 'tổng thể' ),
		$img( 'canalside-central-square', 'Canalside – Central Square: công viên ven kênh, sân khấu nước Meta City Tam Kỳ', 'tiện ích', 'Canalside – Central Square' ),
		$img( 'cau-di-bo-ven-kenh', 'Cầu đi bộ kết hợp điểm ngắm cảnh ven kênh Meta City Tam Kỳ', 'tiện ích', 'Cầu đi bộ ven kênh' ),
		$img( 'riverside-viva-park', 'Riverside – Viva Park: công viên ven sông Meta City Tam Kỳ', 'tiện ích', 'Riverside – Viva Park' ),
		$img( 'quang-truong-ven-song', 'Quảng trường sự kiện ven sông Meta City Tam Kỳ', 'tiện ích', 'Quảng trường ven sông' ),
		$img( 'zen-garden-ho-canh', 'Oriental Parks – vườn Zen, hồ cảnh Meta City Tam Kỳ', 'tiện ích', 'Vườn Zen, hồ cảnh' ),
		$img( 'cho-ngoi-mai-che', 'Chòi nghỉ mái che bên hồ cảnh Meta City Tam Kỳ', 'tiện ích', 'Chòi nghỉ bên hồ' ),
		$img( 'cong-vien-tu-tren-cao', 'Công viên trung tâm Meta City Tam Kỳ nhìn từ trên cao', 'tiện ích', 'Công viên trung tâm' ),
		$img( 'duong-dao-ho-phun-nuoc', 'Đường dạo kết hợp hồ cảnh phun nước Meta City Tam Kỳ', 'tiện ích', 'Đường dạo, hồ phun nước' ),
		$img( 'quang-truong-dai-phun-nuoc', 'Quảng trường trung tâm, mái đón và đài phun nước Meta City Tam Kỳ', 'tiện ích', 'Quảng trường trung tâm' ),
		$img( 'san-choi-tre-em', 'Sân chơi trẻ em trong công viên Meta City Tam Kỳ', 'tiện ích', 'Sân chơi trẻ em' ),
		$img( 'san-bong-ro', 'Sân bóng rổ đa năng ngoài trời Meta City Tam Kỳ', 'tiện ích', 'Sân bóng rổ' ),
		$img( 'khu-vui-choi-ven-kenh', 'Khu vui chơi trẻ em ven kênh Meta City Tam Kỳ', 'tiện ích', 'Khu vui chơi ven kênh' ),
	);
	$projects[] = array(
		'slug'    => 'meta-city-tam-ky',
		'title'   => 'Meta City Tam Kỳ',
		'type'    => array( 'dat-nen', 'shophouse' ),
		'area'    => 'tam-ky',
		'hot'     => true,
		'excerpt' => 'Khu đô thị 76,19 ha cửa ngõ phía Bắc Tam Kỳ (phường Bàn Thạch, TP Đà Nẵng): 1.753 sản phẩm đất nền, nhà phố thương mại, biệt thự; GĐ1 712 sản phẩm, đất nền 102 – 105 m² dự kiến 2,32 – 3,1 tỷ/lô, ra thị trường từ Q1/2027.',
		'meta'    => array(
			'hh_p_status'        => 'sap-mo-ban',
			'hh_p_name'          => 'Him Lam Meta City (Meta City Tam Kỳ)',
			'hh_p_developer'     => 'Công ty Cổ phần Thương mại Bất động sản Tây Bắc',
			'hh_p_type'          => 'Đất nền, nhà phố thương mại xây thô, biệt thự',
			'hh_p_address'       => 'Phường Bàn Thạch, TP Đà Nẵng (khu vực phường Tân Thạnh, TP Tam Kỳ, Quảng Nam trước đây) – Khu đô thị kiểu mẫu Tây Bắc Tam Kỳ',
			'hh_p_map_address'   => 'Khu đô thị kiểu mẫu Tây Bắc, Tân Thạnh, Tam Kỳ, Quảng Nam',
			'hh_p_scale'         => '76,19 ha',
			'hh_p_units'         => '1.753 sản phẩm; GĐ1 mở bán 712 sản phẩm (479 đất nền, 233 nhà phố thương mại)',
			'hh_p_unit_area'     => 'Phổ biến 102 – 105 m²/lô',
			'hh_p_legal'         => 'Quy hoạch chi tiết 1/500 Khu đô thị kiểu mẫu Tây Bắc TP Tam Kỳ, điều chỉnh cục bộ theo QĐ 3856/2023',
			'hh_p_ownership'     => 'Lâu dài (đất ở đô thị)',
			'hh_p_handover'      => 'Dự kiến ra thị trường từ Q1/2027',
			'hh_p_price_from'    => 2320,
			'hh_p_price_m2'      => 'Khoảng 22 – 30 triệu/m² (đất nền GĐ1, dự kiến, tham khảo)',
			'hh_p_price_table'   => "Đất nền | 102 – 105 m²/lô | 2,32 – 3,1 tỷ/lô | Giá dự kiến GĐ1 (CL10, CL11, CL20), gồm VAT tạm tính, chưa trừ ưu đãi\nNhà phố thương mại xây thô 3,5 tầng | Đất 102 – 105 m²/căn | 5,1 – 5,51 tỷ/căn | Giá dự kiến GĐ1, gồm VAT tạm tính, chưa trừ ưu đãi",
			'hh_p_highlights'    => "Quy mô 76,19 ha, 1.753 sản phẩm – cửa ngõ phía Bắc Tam Kỳ, tiếp giáp quốc lộ\nGĐ1: 479 lô đất nền và 233 nhà phố thương mại xây thô 3,5 tầng\nĐất nền 102 – 105 m² giá dự kiến 2,32 – 3,1 tỷ/lô; nhà phố 5,1 – 5,51 tỷ/căn\nBa cụm cảnh quan: Oriental & Tropical Parks, Riverside – Viva Park, Canalside – Central Square\nGần KCN Tam Thăng, Thuận Yên; kết nối QL1A, cao tốc Đà Nẵng – Quảng Ngãi, biển Tam Thanh",
			'hh_p_location_desc' => 'Meta City Tam Kỳ nằm tại cửa ngõ phía Bắc khu vực Tam Kỳ – khu vực phường Tân Thạnh, TP Tam Kỳ (Quảng Nam) trước đây, nay thuộc phường Bàn Thạch, TP Đà Nẵng. Dự án tiếp giáp quốc lộ, kết nối khu dân cư hiện hữu và các trục giao thông liên vùng; từ đây dễ vào trung tâm Tam Kỳ, các khu công nghiệp Tam Thăng – Thuận Yên và theo hành lang ĐT615 ra biển Tam Thanh, trục ven biển Võ Chí Công.',
			'hh_p_connections'   => "Liền kề | Quốc lộ, khu dân cư hiện hữu\nVài phút | Trung tâm Tam Kỳ: Quảng trường 24/3, Bệnh viện Đa khoa Quảng Nam, Trường Đại học Quảng Nam\nGần | KCN Tam Thăng, KCN Thuận Yên\nQua ĐT615 | Biển Tam Thanh, trục ven biển Võ Chí Công\nQua QL1A, cao tốc | Hội An, Đà Nẵng, Núi Thành, Chu Lai",
			'hh_p_amenities_in'  => "Oriental Parks: vườn Á Đông, vườn Zen, hồ cảnh, chòi nghỉ\nTropical Parks: vườn nhiệt đới, vườn hoa đa sắc, sân bóng rổ, khu thể thao đa năng\nRiverside – Viva Park: công viên ven sông, quảng trường sự kiện, đường dạo, vườn giác quan, khu thể dục\nCanalside – Central Square: công viên ven kênh, cầu đi bộ, sân khấu nước, quảng trường nhỏ\nQuảng trường trung tâm, mái đón và đài phun nước\nSân chơi trẻ em\nĐất trường học, y tế, công trình công cộng, thương mại dịch vụ theo quy hoạch",
			'hh_p_amenities_out' => "Trung tâm Tam Kỳ, Quảng trường 24/3\nBệnh viện Đa khoa Quảng Nam, Trường Đại học Quảng Nam\nKCN Tam Thăng, KCN Thuận Yên\nBiển Tam Thanh, đường ven biển Võ Chí Công",
			'hh_p_design_desc'   => 'Theo quy hoạch chi tiết 1/500 (điều chỉnh cục bộ theo QĐ 3856/2023): khu đất ở chia lô liền kề theo các block bàn cờ, dải biệt thự uốn theo kênh cảnh quan phía Đông, đất thương mại – dịch vụ dọc trục quốc lộ phía Tây, cùng đất giáo dục, y tế, thể dục thể thao và hệ cây xanh – mặt nước xuyên suốt. GĐ1 gồm đất nền và nhà phố thương mại xây thô 3,5 tầng tại các block như CL10, CL11, CL20.',
			'hh_p_capital_note'  => 'Có thể thanh toán theo tiến độ, thanh toán sớm hoặc vay có hỗ trợ lãi suất theo chính sách bán hàng từng đợt.',
			'hh_p_image_links'   => implode( "\n", $lines ),
			'hh_p_faq'           => "Meta City Tam Kỳ ở đâu? | Cửa ngõ phía Bắc Tam Kỳ – khu vực phường Tân Thạnh (TP Tam Kỳ, Quảng Nam) trước đây, nay thuộc phường Bàn Thạch, TP Đà Nẵng; tiếp giáp quốc lộ.\nAi là chủ đầu tư Meta City Tam Kỳ? | Công ty Cổ phần Thương mại Bất động sản Tây Bắc.\nGiá đất nền Meta City Tam Kỳ bao nhiêu? | Giá dự kiến GĐ1: đất nền 102 – 105 m² khoảng 2,32 – 3,1 tỷ/lô; nhà phố thương mại xây thô 3,5 tầng khoảng 5,1 – 5,51 tỷ/căn (gồm VAT tạm tính, chưa trừ ưu đãi). Giá tham khảo, chờ bảng giá chính thức.\nKhi nào Meta City Tam Kỳ mở bán? | Dự kiến ra thị trường từ Q1/2027, GĐ1 gồm 712 sản phẩm (479 đất nền, 233 nhà phố thương mại).",
		),
		'content' => '<p><strong>Meta City Tam Kỳ</strong> (Him Lam Meta City) là khu đô thị quy mô <strong>76,19 ha</strong> với <strong>1.753 sản phẩm</strong> đất nền, nhà phố thương mại và biệt thự tại cửa ngõ phía Bắc Tam Kỳ – khu vực phường Tân Thạnh trước đây, nay thuộc phường Bàn Thạch, TP Đà Nẵng. Chủ đầu tư là Công ty Cổ phần Thương mại Bất động sản Tây Bắc; dự kiến ra thị trường từ <strong>Q1/2027</strong>.</p>
<h2>Giai đoạn 1: 712 sản phẩm</h2>
<p>GĐ1 gồm <strong>479 lô đất nền</strong> và <strong>233 nhà phố thương mại xây thô 3,5 tầng</strong>. Giá dự kiến các sản phẩm diện tích phổ biến tại block CL10, CL11, CL20:</p>
<table><thead><tr><th>Sản phẩm</th><th>Diện tích đất</th><th>Tổng giá dự kiến</th></tr></thead><tbody>
<tr><td>Đất nền</td><td>102 – 105 m²/lô</td><td>2,32 – 3,1 tỷ/lô</td></tr>
<tr><td>Nhà phố thương mại xây thô 3,5 tầng</td><td>102 – 105 m²/căn</td><td>5,1 – 5,51 tỷ/căn</td></tr>
</tbody></table>
<p>Giá áp dụng cho căn điển hình theo phương án thanh toán tiến độ, đã gồm VAT tạm tính, chưa trừ ưu đãi; giá từng sản phẩm phụ thuộc vị trí, diện tích và chính sách từng đợt. Khách có thể chọn thanh toán theo tiến độ, thanh toán sớm hoặc vay có hỗ trợ lãi suất.</p>
<h2>Vị trí và kết nối</h2>
<ul>
<li><strong>Trung tâm Tam Kỳ:</strong> trường học, bệnh viện, dịch vụ hiện hữu; Quảng trường 24/3, Bệnh viện Đa khoa Quảng Nam, Trường Đại học Quảng Nam.</li>
<li><strong>KCN Tam Thăng, Thuận Yên:</strong> nhu cầu nhà ở, kinh doanh của người làm việc tại khu công nghiệp.</li>
<li><strong>Hướng biển:</strong> theo hành lang ĐT615 ra Tam Thăng, biển Tam Thanh và trục ven biển Võ Chí Công.</li>
<li><strong>Liên vùng:</strong> Quốc lộ 1A, cao tốc Đà Nẵng – Quảng Ngãi đi Hội An, Đà Nẵng, Núi Thành, Chu Lai.</li>
</ul>
<h2>Ba cụm cảnh quan</h2>
<ul>
<li><strong>Oriental &amp; Tropical Parks:</strong> vườn Á Đông, vườn Zen, vườn nhiệt đới, hồ cảnh, đài phun nước, sân chơi trẻ em, sân bóng rổ, khu thể thao.</li>
<li><strong>Riverside – Viva Park:</strong> công viên ven sông, quảng trường sự kiện, đường dạo, vườn giác quan, khu thể dục thể thao.</li>
<li><strong>Canalside – Central Square:</strong> công viên ven kênh, cầu đi bộ, sân khấu nước, quảng trường nhỏ và các điểm nghỉ chân.</li>
</ul>
<h2>Phù hợp với ai?</h2>
<p>Người dân Tam Kỳ và khu vực lân cận mua để ở, đổi chỗ ở hoặc mua cho con; hộ kinh doanh cần mặt bằng nhà phố; người làm việc tại các khu công nghiệp; nhà đầu tư tại Quảng Nam cũ, Đà Nẵng và các tỉnh lân cận.</p>
<p>Đăng ký nhận bảng giá chính thức, chính sách và sơ đồ lô GĐ1: Zalo Hoàng Hiệp 0904 567 009.</p>',
		'sources' => array(),
	);
	return $projects;
}
