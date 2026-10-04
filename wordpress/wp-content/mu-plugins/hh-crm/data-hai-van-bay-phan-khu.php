<?php
/**
 * 4 phân khu Vinhomes Hải Vân Bay – mỗi phân khu một trang riêng, là phân khu của trang "vinhomes-hai-van-bay":
 * Khu 1 Bạch Vân, Khu 2 Vịnh Mây, Khu 3 Đảo Ngọc, Khu 4 Tinh Vân.
 * Thông số phân khu: báo chí và trang CĐT (market.vinhomes.vn, Dân trí, VnExpress); tiện ích theo TMB tiện ích CĐT cập nhật;
 * khoảng giá theo giỏ hàng đại lý tháng 9–10/2026 (giá gồm VAT) – tham khảo, thay đổi theo đợt.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_project_dataset', 'hh_dataset_hai_van_bay_phan_khu', 45 );
function hh_dataset_hai_van_bay_phan_khu( $projects ) {
	$parent  = 'vinhomes-hai-van-bay';
	$addr    = 'Vịnh Nam Chơn (Làng Vân), chân đèo Hải Vân, phường Hải Vân (trước đây Hòa Hiệp Bắc, Liên Chiểu), TP Đà Nẵng';
	$dev     = 'Công ty CP Vinpearl – Vinhomes phát triển (Tập đoàn Vingroup)';
	$sources = array(
		'https://market.vinhomes.vn/du-an/vinhomes-hai-van-bay',
		'https://vnexpress.net/vinhomes-ra-mat-du-an-vinhomes-hai-van-bay-5064704.html',
		'https://tienphong.vn/vinhomes-hai-van-bay-bung-no-giao-dich-trong-ngay-dau-sieu-chinh-sach-khoa-tran-lai-suat-6nam-trong-5-nam-co-hieu-luc-post1836841.tpo',
	);
	$policy = "Thanh toán giãn xây 18 – 24 tháng: thanh toán phần đất trước, phần xây dựng sau\nNgân hàng cho vay đến 70 – 80% giá trị\nHỗ trợ lãi suất 24 tháng (liền kề, shophouse), 36 tháng (biệt thự) – theo từng đợt\nKhóa trần lãi suất sau thời gian ưu đãi (theo chương trình CĐT)\nLiên hệ để nhận chính sách tháng hiện hành và phiếu tính giá căn cụ thể";

	// Phần chung cuối bài: liên kết về trang tổng + phân khu khác + CTA.
	$tail = static function ( $self ) {
		$zones = array(
			'vinhomes-hai-van-bay-bach-van' => 'Khu 1 Bạch Vân',
			'vinhomes-hai-van-bay-vinh-may' => 'Khu 2 Vịnh Mây',
			'vinhomes-hai-van-bay-dao-ngoc' => 'Khu 3 Đảo Ngọc',
			'vinhomes-hai-van-bay-tinh-van' => 'Khu 4 Tinh Vân',
		);
		$links = array();
		foreach ( $zones as $slug => $name ) {
			if ( $slug !== $self ) {
				$links[] = '<a href="/du-an/' . $slug . '/">' . $name . '</a>';
			}
		}
		return "\n<h2>Các phân khu khác của Vinhomes Hải Vân Bay</h2>\n<p>Xem tổng quan dự án tại trang <a href=\"/du-an/vinhomes-hai-van-bay/\">Vinhomes Hải Vân Bay (Làng Vân)</a> và các phân khu: " . implode( ' · ', $links ) . ".</p>\n<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận bảng hàng đầy đủ, phiếu tính giá theo từng phương án thanh toán, chính sách mới nhất và ảnh chỉ vị trí căn trên mặt bằng.</p>";
	};

	$zone = static function ( $slug, $title, $types, $status, $excerpt, $meta, $content ) use ( $parent, $addr, $dev, $sources, $policy, $tail ) {
		return array(
			'slug'    => $slug,
			'title'   => $title,
			'type'    => $types,
			'area'    => 'lien-chieu',
			'parent'  => $parent,
			'hot'     => 'dang-mo-ban' === $status,
			'order'   => (int) preg_replace( '/\D/', '', strstr( $title, '(Khu' ) ?: '0' ),
			'excerpt' => $excerpt,
			'fix_meta' => array( 'hh_p_connections' => "Ngay chân đèo | Đèo Hải Vân, hầm Hải Vân\nKết nối | Quốc lộ 1A, cao tốc La Sơn – Túy Loan\nLân cận | Cảng Liên Chiểu, đường sắt Bắc – Nam\nKhoảng 20 – 25 phút | Trung tâm Đà Nẵng, sân bay quốc tế" ),
			'meta'    => $meta + array(
				'hh_p_status'     => $status,
				'hh_p_developer'  => $dev,
				'hh_p_address'    => $addr,
				'hh_p_policy'     => $policy,
				'hh_p_loan'       => 'Ngân hàng cho vay đến 70 – 80% giá trị căn, hỗ trợ lãi suất và khóa trần lãi suất theo chương trình từng đợt của chủ đầu tư. Liên hệ để nhận phiếu tính giá theo đúng chính sách hiện hành.',
				'hh_p_connections' => "Ngay chân đèo | Đèo Hải Vân, hầm Hải Vân\nKết nối | Quốc lộ 1A, cao tốc La Sơn – Túy Loan\nLân cận | Cảng Liên Chiểu, đường sắt Bắc – Nam\nKhoảng 20 – 25 phút | Trung tâm Đà Nẵng, sân bay quốc tế\nQua hầm Hải Vân | Lăng Cô, Cố đô Huế\nTrong dự án | Bãi biển Làng Vân, VinWonders Hải Vân",
			),
			'content' => $content . $tail( $slug ),
			'sources' => $sources,
		);
	};

	/* ---------------------------------------------------------------- Khu 1 – Bạch Vân */
	$projects[] = $zone(
		'vinhomes-hai-van-bay-bach-van',
		'Phân khu Bạch Vân – Vinhomes Hải Vân Bay (Khu 1)',
		array( 'biet-thu', 'shophouse' ),
		'dang-mo-ban',
		'Bạch Vân – Khu 1 Vinhomes Hải Vân Bay, khoảng 112 ha phong cách Hong Kong: liền kề, shophouse, biệt thự song lập, đơn lập và 15 tòa cao tầng. Liền kề từ khoảng 5,3 tỷ; bàn giao thô đợt đầu quý 4/2026.',
		array(
			'hh_p_type'       => 'Liền kề, shophouse, biệt thự song lập, biệt thự đơn lập; 15 tòa cao tầng',
			'hh_p_scale'      => 'Khoảng 112 ha (111,98 ha) – cửa ngõ dự án',
			'hh_p_units'      => 'Khoảng 2.524 căn thấp tầng và 15 tòa cao tầng',
			'hh_p_unit_area'  => 'Liền kề 63 – 140 m² · Song lập 140 – 160 m² · Đơn lập 140 – 290 m²',
			'hh_p_price_from' => '5300',
			'hh_p_price_m2'   => 'Liền kề khoảng 67 – 100 triệu/m² đất (tham khảo)',
			'hh_p_ownership'  => 'Sở hữu lâu dài (người Việt Nam)',
			'hh_p_handover'   => 'Khoảng 345 căn thấp tầng bàn giao thô quý 4/2026; cao tầng quý 4/2027 (dự kiến)',
			'hh_p_highlights' => "Phân khu mở bán đầu tiên (20/4/2026), gần cổng chính và Quốc lộ 1A\nPhong cách Hong Kong – trung tâm thương mại, giải trí sôi động nhất dự án\nLifestyle Hub, chợ Hong Kong, làng ẩm thực ven suối, Hồ Ngọc Trai\nBàn giao sớm nhất dự án – thuận lợi ở ngay hoặc cho thuê\nThanh toán giãn xây 18 tháng, vay đến 70 – 80%",
			'hh_p_amenities_in' => "Lifestyle Hub – tổ hợp thể thao & giải trí\nChợ Hong Kong\nLàng ẩm thực ven suối\nHồ Ngọc Trai, hồ cảnh quan\nPhố shophouse thương mại – dịch vụ\nCông viên, sân chơi nội khu",
			'hh_p_location_desc' => 'Bạch Vân nằm ở cửa ngõ phía Nam của Vinhomes Hải Vân Bay, gần Quốc lộ 1A và lối vào hầm Hải Vân – phân khu kết nối thuận tiện nhất về trung tâm Đà Nẵng. Từ Bạch Vân di chuyển nội khu tới Đảo Ngọc, VinWonders Hải Vân và bãi biển Làng Vân.',
			'hh_p_nha-pho_desc'  => 'Liền kề Bạch Vân cao 4 tầng, đất 63 – 140 m², nhiều căn có phương án thanh toán giãn xây 18 tháng. Shophouse dọc các trục thương mại phù hợp kinh doanh dịch vụ. Giá dưới đây là khoảng giá theo giỏ hàng tháng 9–10/2026, đã gồm VAT.',
			'hh_p_nha-pho_table' => "Liền kề | 63 m² | 4 tầng | 5,3 – 6,3 tỷ\nLiền kề | 70 m² | 4 tầng | 5,5 – 7,6 tỷ\nLiền kề | 72 m² | 4 tầng | 6,0 – 9,7 tỷ\nLiền kề | 75 m² | 4 tầng | 6,5 – 10,1 tỷ\nLiền kề | 80 m² | 4 tầng | 8,3 – 9,4 tỷ\nLiền kề | 98 – 108 m² | 4 tầng | 6,6 – 13,4 tỷ\nLiền kề góc | 63 – 161 m² | 4 tầng | 5,6 – 18,4 tỷ",
			'hh_p_villa_desc'    => 'Biệt thự song lập là dòng có đơn giá tốt nhất Bạch Vân (từ khoảng 67 triệu/m² đất); biệt thự đơn lập đất 140 – 290 m², nhiều lựa chọn vị trí.',
			'hh_p_villa_table'   => "Song lập | 140 m² | – | 9,4 – 15,6 tỷ\nSong lập | 150 – 160 m² | – | 15,1 – 17,7 tỷ\nĐơn lập | 140 m² | – | Từ 11,1 tỷ\nĐơn lập | 230 – 290 m² | – | 24,3 – 31,7 tỷ",
			'hh_p_hot_title'     => 'Giỏ hàng Bạch Vân – 6 căn giá tốt',
			'hh_p_hot_units'     => "VU8-18 | Bạch Vân | Liền kề | 98 m² | Thanh toán giãn xây 18 tháng\nTK8-16 | Bạch Vân | Liền kề | 105 m² | Thanh toán giãn xây 18 tháng\nVU8-04 | Bạch Vân | Liền kề góc | 63 m² | Căn góc vốn thấp\nBV12-27 | Bạch Vân | Biệt thự song lập | 140 m² | Đơn giá tốt nhất dòng song lập\nBV15-10 | Bạch Vân | Biệt thự song lập | 140 m² | Song lập giá tốt\nBV6-39 | Bạch Vân | Biệt thự đơn lập | 140 m² | Đơn lập vốn thấp nhất Bạch Vân",
			'hh_p_faq'           => "Phân khu Bạch Vân ở đâu? | Bạch Vân là Khu 1, nằm ở cửa ngõ Vinhomes Hải Vân Bay, gần Quốc lộ 1A và hầm Hải Vân, phường Hải Vân, Đà Nẵng.\nBạch Vân có những loại sản phẩm nào? | Liền kề 4 tầng (63 – 140 m²), shophouse, biệt thự song lập (140 – 160 m²), biệt thự đơn lập (140 – 290 m²) và 15 tòa cao tầng.\nGiá Bạch Vân bao nhiêu? | Theo giỏ hàng tháng 9–10/2026 (gồm VAT, tham khảo): liền kề khoảng 5,3 – 14 tỷ, song lập 9,4 – 17,7 tỷ, đơn lập 11,1 – 31,7 tỷ.\nKhi nào Bạch Vân bàn giao? | Khoảng 345 căn thấp tầng đầu tiên dự kiến bàn giao thô quý 4/2026; khối cao tầng dự kiến quý 4/2027.\nBạch Vân có sổ đỏ lâu dài không? | Có. Sản phẩm thấp tầng Bạch Vân trên đất ở đô thị, sở hữu lâu dài cho người Việt Nam.",
			'rank_math_title'       => 'Phân khu Bạch Vân Vinhomes Hải Vân Bay: Giá & giỏ hàng T10/2026',
			'rank_math_description' => 'Bạch Vân – Khu 1 Vinhomes Hải Vân Bay (112 ha, phong cách Hong Kong): liền kề từ 5,3 tỷ, song lập từ 9,4 tỷ, đơn lập, shophouse. Bàn giao Q4/2026, giãn xây 18 tháng.',
			'rank_math_focus_keyword' => 'bạch vân vinhomes hải vân bay,phân khu bạch vân,giá bạch vân hải vân bay',
		),
		<<<'HTML'
<p><strong>Phân khu Bạch Vân</strong> (Khu 1) là phân khu mở bán đầu tiên của <a href="/du-an/vinhomes-hai-van-bay/">Vinhomes Hải Vân Bay</a>, rộng khoảng 112 ha ở cửa ngõ dự án, lấy cảm hứng từ sự sôi động của Hong Kong. Bạch Vân gồm khoảng 2.524 căn thấp tầng – liền kề, shophouse, biệt thự song lập, đơn lập – và 15 tòa cao tầng. Cập nhật tháng 10/2026.</p>

<h2>Tổng quan phân khu Bạch Vân</h2>
<table>
<tbody>
<tr><td>Vị trí</td><td>Khu 1 – cửa ngõ Vinhomes Hải Vân Bay, gần Quốc lộ 1A, hầm Hải Vân</td></tr>
<tr><td>Diện tích</td><td>Khoảng 112 ha</td></tr>
<tr><td>Phong cách</td><td>Hong Kong – đô thị thương mại, giải trí sôi động</td></tr>
<tr><td>Sản phẩm</td><td>~2.524 căn thấp tầng + 15 tòa cao tầng</td></tr>
<tr><td>Mở bán</td><td>Từ 20/4/2026</td></tr>
<tr><td>Bàn giao</td><td>~345 căn thô quý 4/2026; cao tầng quý 4/2027 (dự kiến)</td></tr>
<tr><td>Pháp lý</td><td>Sở hữu lâu dài (người Việt Nam)</td></tr>
</tbody>
</table>

<h2>Tiện ích Bạch Vân theo TMB điều chỉnh mới nhất</h2>
<ul>
<li><strong>Lifestyle Hub</strong> – tổ hợp thể thao &amp; giải trí.</li>
<li><strong>Chợ Hong Kong</strong> và <strong>làng ẩm thực ven suối</strong> – điểm đến ẩm thực, mua sắm về đêm.</li>
<li><strong>Hồ Ngọc Trai</strong> và hệ hồ cảnh quan.</li>
<li>Phố shophouse thương mại – dịch vụ dọc các trục chính.</li>
</ul>

<h2>Bảng giá Bạch Vân tháng 10/2026 (tham khảo)</h2>
<p>Khoảng giá theo giỏ hàng các đại lý tháng 9–10/2026, đã gồm VAT; giá từng căn phụ thuộc vị trí, hướng và phương án thanh toán.</p>
<table>
<thead><tr><th>Sản phẩm</th><th>Diện tích đất</th><th>Giá tham khảo</th></tr></thead>
<tbody>
<tr><td>Liền kề</td><td>63 m²</td><td>5,3 – 6,3 tỷ</td></tr>
<tr><td>Liền kề</td><td>70 – 75 m²</td><td>5,5 – 10,1 tỷ</td></tr>
<tr><td>Liền kề</td><td>80 m²</td><td>8,3 – 9,4 tỷ</td></tr>
<tr><td>Liền kề góc</td><td>63 – 161 m²</td><td>5,6 – 18,4 tỷ</td></tr>
<tr><td>Biệt thự song lập</td><td>140 – 160 m²</td><td>9,4 – 17,7 tỷ</td></tr>
<tr><td>Biệt thự đơn lập</td><td>140 – 290 m²</td><td>11,1 – 31,7 tỷ</td></tr>
</tbody>
</table>
<p>Xem <a href="#gio-hang">6 căn giá tốt Bạch Vân</a> ngay trên trang – để lại số điện thoại để nhận giá và phiếu tính giá.</p>

<h2>Bạch Vân phù hợp với ai?</h2>
<ul>
<li><strong>Khách cần nhận nhà sớm:</strong> Bạch Vân là phân khu bàn giao đầu tiên của dự án.</li>
<li><strong>Kinh doanh dịch vụ:</strong> shophouse, liền kề gần Lifestyle Hub, chợ Hong Kong, làng ẩm thực.</li>
<li><strong>Vốn khoảng 1,6 – 2 tỷ:</strong> liền kề 63 – 70 m² kết hợp vay ngân hàng và thanh toán giãn xây 18 tháng.</li>
</ul>
HTML
	);

	/* ---------------------------------------------------------------- Khu 2 – Vịnh Mây */
	$projects[] = $zone(
		'vinhomes-hai-van-bay-vinh-may',
		'Phân khu Vịnh Mây – Vinhomes Hải Vân Bay (Khu 2)',
		array( 'biet-thu' ),
		'dang-mo-ban',
		'Vịnh Mây – Khu 2 Vinhomes Hải Vân Bay, khoảng 99,6 ha trên sườn đồi hướng vịnh, phong cách Malibu: 690 sản phẩm (429 biệt thự, 261 liền kề). Liền kề từ khoảng 5,6 tỷ, biệt thự đơn lập từ khoảng 15 tỷ, thanh toán giãn xây 24 tháng.',
		array(
			'hh_p_type'       => 'Biệt thự đơn lập trên đồi, liền kề',
			'hh_p_scale'      => 'Khoảng 99,6 ha, cao độ khoảng 4,8 – 187,5 m, mật độ xây dựng khoảng 19,8%',
			'hh_p_units'      => '690 sản phẩm: 429 biệt thự, 261 liền kề',
			'hh_p_unit_area'  => 'Liền kề 70 – 142 m² · Biệt thự 250 – 382 m² (có lô đến khoảng 420 m²)',
			'hh_p_price_from' => '5600',
			'hh_p_price_m2'   => 'Biệt thự từ khoảng 60 triệu/m² đất; liền kề khoảng 53 – 80 triệu/m² (tham khảo)',
			'hh_p_ownership'  => 'Sở hữu lâu dài (người Việt Nam)',
			'hh_p_handover'   => 'Theo tiến độ từng đợt – liên hệ để nhận lịch bàn giao dự kiến',
			'hh_p_highlights' => "Ra mắt ngày 26/9/2026 – sự kiện \"The Art of Height\"\nBiệt thự trên sườn đồi, tầm nhìn toàn cảnh vịnh Nam Chơn\nMật độ xây dựng thấp khoảng 19,8%, phong cách Malibu\nHải Vân Wellness Hub, Oceania Clubhouse, Palm Park\nThanh toán giãn xây 24 tháng – đơn giá biệt thự thấp nhất dự án",
			'hh_p_amenities_in' => "Hải Vân Wellness Hub – chăm sóc sức khỏe\nOceania Clubhouse\nPalm Park – công viên cọ\nĐường dạo, điểm ngắm vịnh trên đồi\nKết nối nội khu tới bãi biển Làng Vân, Bạch Vân, Đảo Ngọc",
			'hh_p_location_desc' => 'Vịnh Mây trải trên sườn đồi Hải Vân, cao độ khoảng 4,8 – 187,5 m, nhìn xuống toàn cảnh vịnh Nam Chơn. Địa hình đồi giúp nhiều biệt thự có tầm nhìn biển không bị che chắn – điểm khác biệt lớn nhất so với các phân khu đồng bằng.',
			'hh_p_nha-pho_desc'  => 'Liền kề Vịnh Mây đất 70 – 142 m², đơn giá thấp nhất dự án, phần lớn áp dụng thanh toán giãn xây 24 tháng. Giá theo giỏ hàng tháng 9–10/2026, đã gồm VAT.',
			'hh_p_nha-pho_table' => "Liền kề | 70 m² | 4 tầng | 5,6 – 5,8 tỷ\nLiền kề | 75 m² | 4 tầng | 6,1 – 6,4 tỷ\nLiền kề | 80 m² | 4 tầng | 5,6 – 8,8 tỷ\nLiền kề | 105 m² | 4 tầng | 5,6 – 7,6 tỷ\nLiền kề | 134 m² | 4 tầng | Khoảng 10,8 tỷ",
			'hh_p_villa_desc'    => 'Biệt thự đơn lập trên đồi, đất khoảng 220 – 420 m², đơn giá từ khoảng 60 triệu/m² đất – thấp nhất trong các dòng biệt thự của Vinhomes Hải Vân Bay.',
			'hh_p_villa_table'   => "Đơn lập | 220 – 250 m² | – | 15,1 – 17,0 tỷ\nĐơn lập | 260 – 290 m² | – | 17,6 – 20,1 tỷ\nĐơn lập | 300 – 340 m² | – | 18,5 – 23,3 tỷ\nĐơn lập | 370 – 380 m² | – | 23,6 – 26,1 tỷ",
			'hh_p_hot_title'     => 'Giỏ hàng Vịnh Mây – 6 căn giá tốt',
			'hh_p_hot_units'     => "VM-83 | Vịnh Mây | Liền kề | 70 m² | Giãn xây 24 tháng, vốn thấp nhất\nVM-64 | Vịnh Mây | Liền kề | 75 m² | Thanh toán giãn xây 24 tháng\nLV7-23 | Vịnh Mây | Liền kề | 105 m² | Lô rộng, đơn giá rất tốt\nVM4-42 | Vịnh Mây | Biệt thự đơn lập | 283,8 m² | Biệt thự đồi, giãn xây 24 tháng\nVM6-09 | Vịnh Mây | Biệt thự đơn lập | 301,9 m² | Đơn giá tốt, tầm nhìn vịnh\nVM6-22 | Vịnh Mây | Biệt thự đơn lập | 322,8 m² | Lô lớn, đơn giá tốt nhất",
			'hh_p_faq'           => "Phân khu Vịnh Mây ở đâu? | Vịnh Mây là Khu 2 của Vinhomes Hải Vân Bay, nằm trên sườn đồi Hải Vân, nhìn xuống vịnh Nam Chơn, phường Hải Vân, Đà Nẵng.\nVịnh Mây có bao nhiêu sản phẩm? | Khoảng 690 sản phẩm: 429 biệt thự (đất 250 – 382 m²) và 261 liền kề (70 – 142 m²), mật độ xây dựng khoảng 19,8%.\nGiá Vịnh Mây bao nhiêu? | Theo giỏ hàng tháng 9–10/2026 (gồm VAT, tham khảo): liền kề từ khoảng 5,6 tỷ, biệt thự đơn lập khoảng 15 – 26 tỷ.\nVịnh Mây có chính sách thanh toán gì? | Phần lớn sản phẩm áp dụng thanh toán giãn xây 24 tháng; vay đến 70 – 80%, hỗ trợ lãi suất theo từng đợt.\nVịnh Mây ra mắt khi nào? | Vịnh Mây ra mắt ngày 26/9/2026.",
			'rank_math_title'       => 'Phân khu Vịnh Mây Vinhomes Hải Vân Bay: Giá biệt thự T10/2026',
			'rank_math_description' => 'Vịnh Mây – Khu 2 Vinhomes Hải Vân Bay: 690 sản phẩm trên sườn đồi hướng vịnh, phong cách Malibu. Liền kề từ 5,6 tỷ, biệt thự đơn lập từ 15 tỷ, giãn xây 24 tháng.',
			'rank_math_focus_keyword' => 'vịnh mây vinhomes hải vân bay,phân khu vịnh mây,giá vịnh mây hải vân bay',
		),
		<<<'HTML'
<p><strong>Phân khu Vịnh Mây</strong> (Khu 2) của <a href="/du-an/vinhomes-hai-van-bay/">Vinhomes Hải Vân Bay</a> rộng khoảng 99,6 ha, trải trên sườn đồi Hải Vân với cao độ khoảng 4,8 – 187,5 m, lấy cảm hứng từ Malibu (Mỹ). Vịnh Mây có 690 sản phẩm – 429 biệt thự và 261 liền kề – mật độ xây dựng chỉ khoảng 19,8%. Phân khu ra mắt ngày 26/9/2026. Cập nhật tháng 10/2026.</p>

<h2>Tổng quan phân khu Vịnh Mây</h2>
<table>
<tbody>
<tr><td>Vị trí</td><td>Khu 2 – sườn đồi Hải Vân, nhìn toàn cảnh vịnh Nam Chơn</td></tr>
<tr><td>Diện tích</td><td>Khoảng 99,6 ha, cao độ 4,8 – 187,5 m</td></tr>
<tr><td>Phong cách</td><td>Malibu – biệt thự đồi hướng biển</td></tr>
<tr><td>Sản phẩm</td><td>690: 429 biệt thự (250 – 382 m²), 261 liền kề (70 – 142 m²)</td></tr>
<tr><td>Mật độ xây dựng</td><td>Khoảng 19,8%</td></tr>
<tr><td>Ra mắt</td><td>26/9/2026</td></tr>
<tr><td>Thanh toán</td><td>Giãn xây 24 tháng (phần lớn sản phẩm)</td></tr>
</tbody>
</table>

<h2>Tiện ích Vịnh Mây</h2>
<ul>
<li><strong>Hải Vân Wellness Hub</strong> – không gian chăm sóc sức khỏe, thư giãn.</li>
<li><strong>Oceania Clubhouse</strong> – câu lạc bộ cư dân.</li>
<li><strong>Palm Park</strong> – công viên cọ.</li>
<li>Đường dạo, điểm ngắm vịnh trên đồi; kết nối nội khu tới bãi biển Làng Vân và các phân khu khác.</li>
</ul>

<h2>Bảng giá Vịnh Mây tháng 10/2026 (tham khảo)</h2>
<p>Khoảng giá theo giỏ hàng các đại lý tháng 9–10/2026, đã gồm VAT.</p>
<table>
<thead><tr><th>Sản phẩm</th><th>Diện tích đất</th><th>Giá tham khảo</th></tr></thead>
<tbody>
<tr><td>Liền kề</td><td>70 m²</td><td>5,6 – 5,8 tỷ</td></tr>
<tr><td>Liền kề</td><td>75 – 80 m²</td><td>5,6 – 8,8 tỷ</td></tr>
<tr><td>Liền kề</td><td>105 – 134 m²</td><td>5,6 – 10,8 tỷ</td></tr>
<tr><td>Biệt thự đơn lập</td><td>220 – 290 m²</td><td>15,1 – 20,1 tỷ</td></tr>
<tr><td>Biệt thự đơn lập</td><td>300 – 380 m²</td><td>18,5 – 26,1 tỷ</td></tr>
</tbody>
</table>
<p>Xem <a href="#gio-hang">6 căn giá tốt Vịnh Mây</a> ngay trên trang.</p>

<h2>Vì sao nên xem Vịnh Mây?</h2>
<ul>
<li><strong>Tầm nhìn:</strong> địa hình đồi cho nhiều biệt thự tầm nhìn vịnh biển không bị che chắn.</li>
<li><strong>Đơn giá:</strong> biệt thự từ khoảng 60 triệu/m² đất – thấp nhất trong các dòng biệt thự của dự án.</li>
<li><strong>Dòng tiền nhẹ:</strong> thanh toán giãn xây 24 tháng, phần xây dựng thanh toán sau.</li>
<li><strong>Mật độ thấp:</strong> khoảng 19,8%, phù hợp nghỉ dưỡng, an cư riêng tư.</li>
</ul>
HTML
	);

	/* ---------------------------------------------------------------- Khu 3 – Đảo Ngọc */
	$projects[] = $zone(
		'vinhomes-hai-van-bay-dao-ngoc',
		'Phân khu Đảo Ngọc – Vinhomes Hải Vân Bay (Khu 3)',
		array( 'biet-thu', 'shophouse' ),
		'dang-mo-ban',
		'Đảo Ngọc – Khu 3 Vinhomes Hải Vân Bay, khoảng 138,8 ha phong cách Costa Smeralda (Ý), kết nối VinWonders Hải Vân: 2.376 căn thấp tầng gồm liền kề, shophouse, song lập, đơn lập. Liền kề từ khoảng 7,6 tỷ, đơn lập từ khoảng 15,8 tỷ.',
		array(
			'hh_p_type'       => 'Liền kề, liền kề xẻ khe, shophouse, biệt thự song lập, biệt thự đơn lập',
			'hh_p_scale'      => 'Khoảng 138,8 ha – phân khu trung tâm',
			'hh_p_units'      => '2.376 căn thấp tầng: khoảng 1.349 liền kề/shophouse, 1.027 biệt thự',
			'hh_p_unit_area'  => 'Liền kề 60 – 174 m² · Song lập 200 – 221 m² · Đơn lập 197 – 290 m²',
			'hh_p_price_from' => '7600',
			'hh_p_price_m2'   => 'Liền kề khoảng 85 – 130 triệu/m² đất; đơn lập từ khoảng 72 triệu/m² (tham khảo)',
			'hh_p_ownership'  => 'Sở hữu lâu dài (người Việt Nam)',
			'hh_p_handover'   => 'Theo tiến độ từng đợt – liên hệ để nhận lịch bàn giao dự kiến',
			'hh_p_highlights' => "Phân khu trung tâm, kết nối trực tiếp VinWonders Hải Vân (theo quy hoạch điều chỉnh mới nhất)\nPhong cách Costa Smeralda (Ý) – trung tâm giải trí, văn hóa của dự án\nRa mắt 5/5/2026 – gần 1.000 booking trong 72 giờ (theo báo chí)\nCó lựa chọn căn hoàn thiện, phù hợp kinh doanh cho thuê nghỉ dưỡng\nThanh toán giãn xây 18 tháng cho nhiều căn",
			'hh_p_amenities_in' => "VinWonders Hải Vân (theo quy hoạch điều chỉnh mới nhất, dự kiến hoàn thành quý 4/2027)\nPhố đi bộ, phố thương mại ven biển\nQuảng trường, công viên trung tâm\nShophouse kinh doanh dịch vụ du lịch\nKết nối nội khu tới Bạch Vân, Vịnh Mây, bãi biển Làng Vân",
			'hh_p_location_desc' => 'Đảo Ngọc nằm ở trung tâm Vinhomes Hải Vân Bay, kết nối trực tiếp VinWonders Hải Vân theo tổng mặt bằng tiện ích điều chỉnh mới nhất của chủ đầu tư – nơi tập trung lượng khách du lịch lớn nhất dự án.',
			'hh_p_nha-pho_desc'  => 'Liền kề Đảo Ngọc đất 60 – 174 m², gồm liền kề thường, liền kề góc và liền kề xẻ khe; một số căn bàn giao hoàn thiện. Giá theo giỏ hàng tháng 9–10/2026, đã gồm VAT; căn vị trí đặc biệt cao hơn đáng kể.',
			'hh_p_nha-pho_table' => "Liền kề | 70 m² | 4 tầng | Từ khoảng 7,6 tỷ\nLiền kề | 80 m² | 4 tầng | Từ khoảng 8,3 tỷ\nLiền kề | 105 m² | 4 tầng | Từ khoảng 10,6 tỷ\nLiền kề | 120 – 174 m² | 4 tầng | 13,3 – 27,7 tỷ\nLiền kề xẻ khe | 105 – 142 m² | 4 tầng | Từ khoảng 8,9 tỷ\nLiền kề góc | 70 – 126 m² | 4 tầng | 8,8 – 21 tỷ",
			'hh_p_villa_desc'    => 'Biệt thự song lập đất khoảng 200 – 221 m²; biệt thự đơn lập đất 197 – 290 m², giá dao động rộng theo vị trí (mặt biển, mặt hồ, gần VinWonders).',
			'hh_p_villa_table'   => "Song lập | 200 – 205 m² | – | 19,4 – 20,1 tỷ\nĐơn lập | 210 – 260 m² | – | Từ khoảng 15,8 tỷ\nĐơn lập | 270 – 290 m² | – | 21,7 – 22,8 tỷ\nĐơn lập vị trí đặc biệt | 200 – 250 m² | – | Liên hệ",
			'hh_p_hot_title'     => 'Giỏ hàng Đảo Ngọc – 6 căn giá tốt',
			'hh_p_hot_units'     => "AN12-11 | Đảo Ngọc | Liền kề xẻ khe | 105 m² | Đơn giá tốt nhất dòng xẻ khe\nHC3-15 | Đảo Ngọc | Liền kề | 105 m² | Lô rộng, giá tốt\nHC3-30 | Đảo Ngọc | Liền kề góc | 70 m² | Căn góc, giãn xây 18 tháng\nĐLHV-959 | Đảo Ngọc | Biệt thự song lập | 200,3 m² | Song lập giá tốt nhất\nLP-03 | Đảo Ngọc | Biệt thự đơn lập | 218,2 m² | Đơn lập trên đảo, đơn giá tốt\nLP-144 | Đảo Ngọc | Biệt thự đơn lập | 239 m² | Đơn lập lô rộng",
			'hh_p_faq'           => "Phân khu Đảo Ngọc ở đâu? | Đảo Ngọc là Khu 3, phân khu trung tâm của Vinhomes Hải Vân Bay, kết nối trực tiếp VinWonders Hải Vân theo quy hoạch điều chỉnh mới nhất.\nĐảo Ngọc có bao nhiêu căn? | Khoảng 2.376 căn thấp tầng: khoảng 1.349 liền kề/shophouse và 1.027 biệt thự song lập, đơn lập.\nGiá Đảo Ngọc bao nhiêu? | Theo giỏ hàng tháng 9–10/2026 (gồm VAT, tham khảo): liền kề từ khoảng 7,6 tỷ, song lập khoảng 19,4 – 20,1 tỷ, đơn lập từ khoảng 15,8 tỷ.\nĐảo Ngọc có phù hợp cho thuê không? | Đảo Ngọc gần VinWonders Hải Vân – nơi tập trung khách du lịch, phù hợp kinh doanh lưu trú, dịch vụ. Chủ đầu tư có chương trình cam kết thuê cho căn hoàn thiện nội thất (theo từng đợt).\nĐảo Ngọc ra mắt khi nào? | Đảo Ngọc ra mắt ngày 5/5/2026.",
			'rank_math_title'       => 'Phân khu Đảo Ngọc Vinhomes Hải Vân Bay: Giá & giỏ hàng T10/2026',
			'rank_math_description' => 'Đảo Ngọc – Khu 3 Vinhomes Hải Vân Bay (138,8 ha, Costa Smeralda), cạnh VinWonders Hải Vân: 2.376 căn liền kề, shophouse, song lập, đơn lập. Liền kề từ 7,6 tỷ.',
			'rank_math_focus_keyword' => 'đảo ngọc vinhomes hải vân bay,phân khu đảo ngọc,giá đảo ngọc hải vân bay',
		),
		<<<'HTML'
<p><strong>Phân khu Đảo Ngọc</strong> (Khu 3) là phân khu trung tâm của <a href="/du-an/vinhomes-hai-van-bay/">Vinhomes Hải Vân Bay</a>, rộng khoảng 138,8 ha, mang phong cách bờ biển Costa Smeralda (Ý). Theo tổng mặt bằng tiện ích điều chỉnh mới nhất của chủ đầu tư, Đảo Ngọc kết nối trực tiếp <strong>VinWonders Hải Vân</strong>. Phân khu có 2.376 căn thấp tầng, ra mắt ngày 5/5/2026. Cập nhật tháng 10/2026.</p>

<h2>Tổng quan phân khu Đảo Ngọc</h2>
<table>
<tbody>
<tr><td>Vị trí</td><td>Khu 3 – trung tâm dự án, cạnh VinWonders Hải Vân</td></tr>
<tr><td>Diện tích</td><td>Khoảng 138,8 ha</td></tr>
<tr><td>Phong cách</td><td>Costa Smeralda (Ý)</td></tr>
<tr><td>Sản phẩm</td><td>2.376 căn: ~1.349 liền kề/shophouse, ~1.027 biệt thự</td></tr>
<tr><td>Ra mắt</td><td>5/5/2026</td></tr>
<tr><td>Pháp lý</td><td>Sở hữu lâu dài (người Việt Nam)</td></tr>
</tbody>
</table>

<h2>Tiện ích Đảo Ngọc</h2>
<ul>
<li><strong>VinWonders Hải Vân</strong> theo quy hoạch điều chỉnh mới nhất, dự kiến hoàn thành quý 4/2027.</li>
<li>Phố đi bộ, phố thương mại ven biển; quảng trường, công viên trung tâm.</li>
<li>Shophouse phục vụ kinh doanh dịch vụ du lịch.</li>
</ul>

<h2>Bảng giá Đảo Ngọc tháng 10/2026 (tham khảo)</h2>
<p>Khoảng giá theo giỏ hàng các đại lý tháng 9–10/2026, đã gồm VAT. Căn mặt biển, mặt hồ hoặc sát VinWonders có giá cao hơn đáng kể.</p>
<table>
<thead><tr><th>Sản phẩm</th><th>Diện tích đất</th><th>Giá tham khảo</th></tr></thead>
<tbody>
<tr><td>Liền kề</td><td>70 – 80 m²</td><td>Từ 7,6 tỷ</td></tr>
<tr><td>Liền kề</td><td>105 – 174 m²</td><td>Từ 10,6 tỷ</td></tr>
<tr><td>Liền kề xẻ khe</td><td>105 – 142 m²</td><td>Từ 8,9 tỷ</td></tr>
<tr><td>Liền kề góc</td><td>70 – 126 m²</td><td>8,8 – 21 tỷ</td></tr>
<tr><td>Biệt thự song lập</td><td>200 – 205 m²</td><td>19,4 – 20,1 tỷ</td></tr>
<tr><td>Biệt thự đơn lập</td><td>197 – 290 m²</td><td>Từ 15,8 tỷ</td></tr>
</tbody>
</table>
<p>Xem <a href="#gio-hang">6 căn giá tốt Đảo Ngọc</a> ngay trên trang.</p>

<h2>Đảo Ngọc phù hợp với ai?</h2>
<ul>
<li><strong>Đầu tư cho thuê nghỉ dưỡng:</strong> gần VinWonders – lượng khách du lịch lớn quanh năm.</li>
<li><strong>Kinh doanh dịch vụ:</strong> shophouse, liền kề trên các trục thương mại ven biển.</li>
<li><strong>Biệt thự nghỉ dưỡng gia đình:</strong> song lập, đơn lập trên đảo, sở hữu lâu dài.</li>
</ul>
HTML
	);

	/* ---------------------------------------------------------------- Khu 4 – Tinh Vân */
	$projects[] = $zone(
		'vinhomes-hai-van-bay-tinh-van',
		'Phân khu Tinh Vân – Vinhomes Hải Vân Bay (Khu 4)',
		array( 'biet-thu' ),
		'sap-mo-ban',
		'Tinh Vân – Khu 4 Vinhomes Hải Vân Bay, khoảng 161,8 ha phong cách Nhật Bản, phân khu nghỉ dưỡng cao cấp, sở hữu 50 năm. Chưa mở bán – đăng ký để nhận thông tin sớm nhất.',
		array(
			'hh_p_type'       => 'Nghỉ dưỡng cao cấp (thấp tầng)',
			'hh_p_scale'      => 'Khoảng 161,8 ha',
			'hh_p_units'      => 'Chưa công bố',
			'hh_p_ownership'  => '50 năm (đất du lịch)',
			'hh_p_handover'   => 'Chưa công bố',
			'hh_p_highlights' => "Phân khu lớn nhất Vinhomes Hải Vân Bay, khoảng 161,8 ha\nPhong cách Nhật Bản, định hướng nghỉ dưỡng cao cấp\nSở hữu 50 năm (đất du lịch)\nChưa mở bán – đăng ký để được báo khi có thông tin chính thức",
			'hh_p_location_desc' => 'Tinh Vân là phân khu thứ 4 của Vinhomes Hải Vân Bay, quy hoạch nghỉ dưỡng phong cách Nhật Bản trong vịnh Nam Chơn, dưới chân đèo Hải Vân.',
			'hh_p_faq'           => "Phân khu Tinh Vân là gì? | Tinh Vân là Khu 4 của Vinhomes Hải Vân Bay, khoảng 161,8 ha, phong cách Nhật Bản, định hướng nghỉ dưỡng cao cấp.\nTinh Vân đã mở bán chưa? | Chưa. Chủ đầu tư chưa công bố sản phẩm, giá và thời điểm mở bán Tinh Vân.\nTinh Vân sở hữu bao lâu? | Theo thông tin công bố, sản phẩm Tinh Vân trên đất du lịch có thời hạn sở hữu 50 năm.",
			'rank_math_title'       => 'Phân khu Tinh Vân Vinhomes Hải Vân Bay (Khu 4): Thông tin mới',
			'rank_math_description' => 'Tinh Vân – Khu 4 Vinhomes Hải Vân Bay, khoảng 161,8 ha phong cách Nhật Bản, nghỉ dưỡng cao cấp sở hữu 50 năm. Chưa mở bán – đăng ký nhận thông tin sớm.',
			'rank_math_focus_keyword' => 'tinh vân vinhomes hải vân bay,phân khu tinh vân',
		),
		<<<'HTML'
<p><strong>Phân khu Tinh Vân</strong> (Khu 4) là phân khu lớn nhất của <a href="/du-an/vinhomes-hai-van-bay/">Vinhomes Hải Vân Bay</a>, rộng khoảng 161,8 ha, quy hoạch theo phong cách Nhật Bản, định hướng nghỉ dưỡng cao cấp. Sản phẩm Tinh Vân trên đất du lịch có thời hạn sở hữu 50 năm. Tính đến tháng 10/2026, chủ đầu tư <strong>chưa mở bán</strong> phân khu này.</p>

<h2>Thông tin đã công bố</h2>
<table>
<tbody>
<tr><td>Vị trí</td><td>Khu 4 – Vinhomes Hải Vân Bay, vịnh Nam Chơn</td></tr>
<tr><td>Diện tích</td><td>Khoảng 161,8 ha</td></tr>
<tr><td>Phong cách</td><td>Nhật Bản</td></tr>
<tr><td>Thời hạn sở hữu</td><td>50 năm (đất du lịch)</td></tr>
<tr><td>Tình trạng</td><td>Chưa mở bán</td></tr>
</tbody>
</table>

<h2>Trong lúc chờ Tinh Vân</h2>
<p>Nếu anh chị muốn sở hữu lâu dài và nhận nhà sớm hơn, có thể tham khảo <a href="/du-an/vinhomes-hai-van-bay-bach-van/">Bạch Vân</a> (bàn giao đợt đầu quý 4/2026), <a href="/du-an/vinhomes-hai-van-bay-dao-ngoc/">Đảo Ngọc</a> (cạnh VinWonders) hoặc biệt thự đồi <a href="/du-an/vinhomes-hai-van-bay-vinh-may/">Vịnh Mây</a>. Để lại số điện thoại để được báo ngay khi Tinh Vân có thông tin chính thức.</p>
HTML
	);

	return $projects;
}
