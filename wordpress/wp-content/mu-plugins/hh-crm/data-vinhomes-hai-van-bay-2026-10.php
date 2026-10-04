<?php
/**
 * Vinhomes Hải Vân Bay – bản cập nhật 10/2026: 4 phân khu (Khu 1 Bạch Vân, Khu 2 Vịnh Mây, Khu 3 Đảo Ngọc, Khu 4 Tinh Vân),
 * tiện ích theo TMB điều chỉnh mới nhất của CĐT, khoảng giá theo giỏ hàng đại lý 9–10/2026 (giá gồm VAT, tham khảo),
 * chính sách 2026, FAQ. Chỉ thay các ô / bài giới thiệu còn đúng bản cũ do web nhập (fix_meta, fix_content, fix_excerpt) –
 * ô nào anh đã tự sửa trong quản trị thì giữ nguyên.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_project_dataset', 'hh_dataset_hai_van_bay_2026_10', 40 );
function hh_dataset_hai_van_bay_2026_10( $projects ) {
	foreach ( $projects as $i => $p ) {
		if ( 'vinhomes-hai-van-bay' !== ( $p['slug'] ?? '' ) ) {
			continue;
		}
		$upd = array(
			'hh_p_address'       => 'Vịnh Nam Chơn (Làng Vân), chân đèo Hải Vân, phường Hải Vân (trước đây phường Hòa Hiệp Bắc, Liên Chiểu), TP Đà Nẵng',
			'hh_p_handover'      => 'Bạch Vân: khoảng 345 căn thấp tầng bàn giao thô quý 4/2026; cao tầng Bạch Vân quý 4/2027; toàn dự án khoảng 2029 (dự kiến)',
			'hh_p_highlights'    => "Quy mô 512 ha, vốn khoảng 44.000 tỷ đồng, chủ đầu tư Vinpearl – Vinhomes phát triển (Vingroup)\nVịnh Nam Chơn tựa núi Hải Vân, ba mặt hướng biển – cửa ngõ phía Bắc Đà Nẵng\n4 phân khu: Bạch Vân (Hong Kong), Vịnh Mây (Malibu), Đảo Ngọc (Costa Smeralda – Ý), Tinh Vân (Nhật Bản)\nHơn 90% sản phẩm thấp tầng sở hữu lâu dài – hiếm có ở bất động sản ven biển\nVinWonders Hải Vân kết nối Đảo Ngọc; Lifestyle Hub, chợ Hong Kong, làng ẩm thực ven suối tại Bạch Vân\nThanh toán giãn xây 18 – 24 tháng, vay đến 70 – 80%, khóa trần lãi suất theo từng đợt",
			'hh_p_zones'         => "Khu 1 – Bạch Vân (khoảng 112 ha, phong cách Hong Kong) | Liền kề, shophouse, biệt thự song lập, đơn lập; 15 tòa cao tầng | Khoảng 2.524 căn thấp tầng | Đang bán từ 20/4/2026\nKhu 2 – Vịnh Mây (khoảng 99,6 ha, phong cách Malibu, trên sườn đồi hướng vịnh) | Biệt thự đơn lập 250 – 382 m², liền kề 70 – 142 m² | 690 sản phẩm (429 biệt thự, 261 liền kề) | Ra mắt 26/9/2026\nKhu 3 – Đảo Ngọc (khoảng 138,8 ha, phong cách Costa Smeralda – Ý) | Liền kề, shophouse, biệt thự song lập, đơn lập | 2.376 căn thấp tầng | Đang bán từ 5/5/2026\nKhu 4 – Tinh Vân (khoảng 161,8 ha, phong cách Nhật Bản) | Nghỉ dưỡng cao cấp, sở hữu 50 năm | – | Chưa mở bán",
			'hh_p_amenities_in'  => "Khu 1 Bạch Vân: Lifestyle Hub – tổ hợp thể thao & giải trí, chợ Hong Kong, làng ẩm thực ven suối, Hồ Ngọc Trai (theo TMB tiện ích CĐT cập nhật)\nKhu 2 Vịnh Mây: Hải Vân Wellness Hub, Oceania Clubhouse, Palm Park\nKhu 3 Đảo Ngọc: VinWonders Hải Vân (theo quy hoạch điều chỉnh mới nhất), phố đi bộ ven biển\nTrung tâm thương mại Vincom\nTrường liên cấp Vinschool, bệnh viện Vinmec (theo quy hoạch)\nKhách sạn, khu nghỉ dưỡng 5 sao\nBãi biển Làng Vân, công viên ven biển\nPhố shophouse thương mại – dịch vụ",
			'hh_p_price_table'   => "Liền kề Bạch Vân (Khu 1) | 63 – 140 m² | Khoảng 5,3 – 14,2 tỷ | Giá gồm VAT, theo giỏ hàng 9–10/2026\nSong lập Bạch Vân | 140 – 160 m² | Khoảng 9,4 – 21,8 tỷ | Đơn giá từ khoảng 67 triệu/m² đất\nĐơn lập Bạch Vân | 140 – 290 m² | Khoảng 11,1 – 31,7 tỷ | Theo vị trí, hướng\nLiền kề Vịnh Mây (Khu 2) | 70 – 142 m² | Từ khoảng 5,6 tỷ | Thanh toán giãn xây 24 tháng\nĐơn lập Vịnh Mây | 223 – 417 m² | Khoảng 15,1 – 47,3 tỷ | Biệt thự đồi hướng vịnh\nLiền kề Đảo Ngọc (Khu 3) | 50 – 174 m² | Từ khoảng 5,5 tỷ | Căn góc khoảng 8,8 – 21,7 tỷ\nSong lập Đảo Ngọc | 200 – 221 m² | Khoảng 19,4 – 20,1 tỷ | Theo giỏ hàng hiện có\nĐơn lập Đảo Ngọc | 197 – 287 m² | Từ khoảng 15,8 tỷ | Lô đặc biệt cao hơn nhiều",
			'hh_p_policy'        => "Thanh toán giãn xây 18 – 24 tháng: thanh toán phần đất trước, phần xây dựng sau (theo dòng sản phẩm)\nNgân hàng cho vay đến 70 – 80% giá trị\nHỗ trợ lãi suất 24 tháng (liền kề, shophouse) và 36 tháng (biệt thự) – theo chính sách từng đợt\nKhóa trần lãi suất sau ưu đãi (chương trình 2026: trần 6%/năm trong 5 năm, đợt 20/4 – 20/7/2026)\nChiết khấu thanh toán sớm và ưu đãi theo tháng – liên hệ nhận chính sách tháng 10/2026 bản chính thức\nĐảo Ngọc: chương trình cam kết thuê cho căn hoàn thiện nội thất (theo CĐT công bố)",
			'hh_p_loan'          => 'Ngân hàng cho vay đến 70 – 80% giá trị căn. Chủ đầu tư hỗ trợ lãi suất 24 tháng (liền kề, shophouse) hoặc 36 tháng (biệt thự) và khóa trần lãi suất trong nhiều năm theo từng chương trình. Gói vay, điều kiện và thời hạn thay đổi theo đợt – liên hệ để nhận phiếu tính giá theo đúng chính sách hiện hành.',
			'hh_p_progress'      => "20/11/2024 | Thủ tướng điều chỉnh chủ trương đầu tư: 512 ha, khoảng 44.000 tỷ đồng\n22/6/2025 | Khởi công Khu phức hợp du lịch và đô thị nghỉ dưỡng Làng Vân\n20/4/2026 | Ra mắt Vinhomes Hải Vân Bay, mở bán Khu 1 Bạch Vân\n5/5/2026 | Ra mắt Khu 3 Đảo Ngọc\n26/9/2026 | Ra mắt Khu 2 Vịnh Mây\nQuý 4/2026 | Khoảng 345 căn thấp tầng Bạch Vân bàn giao thô (dự kiến)\nQuý 4/2027 | VinWonders Hải Vân, cao tầng Bạch Vân hoàn thành (dự kiến)",
			'hh_p_faq'           => "Vinhomes Hải Vân Bay ở đâu? | Tại vịnh Nam Chơn (Làng Vân), chân đèo Hải Vân, phường Hải Vân (trước đây Hòa Hiệp Bắc, Liên Chiểu), cửa ngõ phía Bắc TP Đà Nẵng.\nVinhomes Hải Vân Bay và Vinhomes Làng Vân có phải là một? | Đúng. Tên pháp lý là Khu phức hợp du lịch và đô thị nghỉ dưỡng Làng Vân do Công ty CP Vinpearl làm chủ đầu tư, Vinhomes phát triển; tên thương mại là Vinhomes Hải Vân Bay.\nVinhomes Hải Vân Bay có mấy phân khu? | 4 phân khu: Khu 1 Bạch Vân, Khu 2 Vịnh Mây, Khu 3 Đảo Ngọc và Khu 4 Tinh Vân. Bạch Vân, Đảo Ngọc, Vịnh Mây đang bán; Tinh Vân chưa mở bán.\nGiá Vinhomes Hải Vân Bay bao nhiêu? | Theo giỏ hàng tháng 9–10/2026 (giá gồm VAT, tham khảo): liền kề từ khoảng 5,3 – 5,6 tỷ; song lập Bạch Vân khoảng 9,4 – 21,8 tỷ; đơn lập từ khoảng 11 tỷ, biệt thự Vịnh Mây khoảng 15 – 47 tỷ.\nVinhomes Hải Vân Bay có sổ đỏ lâu dài không? | Hơn 90% sản phẩm thấp tầng nằm trên đất ở đô thị nên được sở hữu lâu dài (người Việt Nam); Tinh Vân và các sản phẩm trên đất du lịch, thương mại có thời hạn 50 năm.\nMua Vinhomes Hải Vân Bay cần bao nhiêu vốn? | Ngân hàng cho vay đến 70 – 80%; với phương án giãn xây 18 – 24 tháng, khách thanh toán phần đất trước, phần xây dựng sau. Liên hệ để nhận phiếu tính giá căn cụ thể.\nVinWonders Hải Vân nằm ở đâu? | Theo quy hoạch điều chỉnh mới nhất của CĐT, VinWonders Hải Vân nằm tại Khu 3 và kết nối trực tiếp phân khu Đảo Ngọc, dự kiến hoàn thành quý 4/2027.\nKhi nào Vinhomes Hải Vân Bay bàn giao? | Khoảng 345 căn thấp tầng Bạch Vân dự kiến bàn giao thô quý 4/2026; cao tầng Bạch Vân quý 4/2027; các phân khu còn lại theo tiến độ từng đợt.",
			'hh_p_hot_title'        => 'Giỏ hàng độc quyền Vinhomes Hải Vân Bay – 6 căn giá tốt',
			'hh_p_hot_units'        => "LV7-23 | Vịnh Mây | Liền kề | 105 m² | Thanh toán giãn xây 24 tháng\nVU8-18 | Bạch Vân | Liền kề | 98 m² | Thanh toán giãn xây 18 tháng\nBV12-27 | Bạch Vân | Biệt thự song lập | 140 m² | Đơn giá tốt nhất dòng song lập\nHC3-30 | Đảo Ngọc | Liền kề góc | 70 m² | Căn góc, thanh toán giãn xây 18 tháng\nLP-03 | Đảo Ngọc | Biệt thự đơn lập | 218,2 m² | Đơn lập trên đảo, đơn giá tốt\nVM6-22 | Vịnh Mây | Biệt thự đơn lập | 322,8 m² | Lô lớn, thanh toán giãn xây 24 tháng",
			'hh_p_image_links'      => "https://drive.google.com/file/d/12OSr5-AcTH--xiQ1h6uJ0SsZsLFkNOih/view | Vinhomes Hải Vân Bay – phối cảnh dự án | đại diện\nhttps://drive.google.com/file/d/16JZh1PJxCVuRjEIyW3p3-6AYIqRzUwV-/view | Vinhomes Hải Vân Bay – hình ảnh dự án | thư viện\nhttps://drive.google.com/file/d/1ypw_JBzZX8Q9D0x52-vfd5GB12Pqr0wF/view | Vinhomes Hải Vân Bay – hình ảnh dự án | thư viện\nhttps://drive.google.com/file/d/1L6gXxOIxw5RemTylNkak7u87Jz6XBI9E/view | Vinhomes Hải Vân Bay – hình ảnh dự án | thư viện\nhttps://drive.google.com/file/d/1tJm-Bo68llJ59MId0aOMpJCNO1UJJLEJ/view | Vinhomes Hải Vân Bay – hình ảnh dự án | thư viện\nhttps://drive.google.com/file/d/1EqZbwe3xGPNM9ElVVk9NGPYcfOxH3u_6/view | Vinhomes Hải Vân Bay – hình ảnh dự án | thư viện\nhttps://drive.google.com/file/d/1Gmw_SfiOcrK05BL5h08F0vCPCG96ipg1/view | Vinhomes Hải Vân Bay – hình ảnh dự án | thư viện\nhttps://drive.google.com/file/d/1edVX1D3TOR-avwYaUKycxTMdcastBHk2/view | Vinhomes Hải Vân Bay – hình ảnh dự án | thư viện\nhttps://drive.google.com/file/d/1hglhMDSB-vmvJU_IZOhYqRI6rIew3n7o/view | Vinhomes Hải Vân Bay – hình ảnh dự án | thư viện\nhttps://drive.google.com/file/d/1VljMi2QviT9kjYLCvQ1slosqGHGXXXQE/view | Vinhomes Hải Vân Bay – hình ảnh dự án | thư viện\nhttps://drive.google.com/file/d/1-20Bdgk5SCzAf6gHl84brZQQfcz2btDs/view | Vinhomes Hải Vân Bay – hình ảnh dự án | thư viện\nhttps://drive.google.com/file/d/1ck2wsf-Pc2RcLb7fYb6v5AcaYMNy75of/view | Vinhomes Hải Vân Bay – hình ảnh dự án | thư viện\nhttps://drive.google.com/file/d/1t7aFTCew2ZW6LD-7IBArgfqQ5a-Rtddb/view | Mặt bằng định vị mẫu kiến trúc Vịnh Mây – Vinhomes Hải Vân Bay | mặt bằng",
			'rank_math_title'       => 'Vinhomes Hải Vân Bay (Làng Vân): Bảng giá & CSBH T10/2026',
			'rank_math_description' => 'Vinhomes Hải Vân Bay (Làng Vân) 512 ha chân đèo Hải Vân, Đà Nẵng: 4 phân khu Bạch Vân, Vịnh Mây, Đảo Ngọc, Tinh Vân. Giỏ hàng liền kề từ 5,3 tỷ, sổ lâu dài, vay 70–80%.',
		);
		$projects[ $i ]['fix_meta']    = array_intersect_key( $p['meta'], $upd ) + ( $p['fix_meta'] ?? array() );
		$projects[ $i ]['meta']        = array_merge( $p['meta'], $upd );
		$projects[ $i ]['fix_excerpt'] = $p['excerpt'];
		$projects[ $i ]['excerpt']     = 'Vinhomes Hải Vân Bay (Làng Vân) – đô thị vịnh biển 512 ha dưới chân đèo Hải Vân, Đà Nẵng. 4 phân khu Bạch Vân, Vịnh Mây, Đảo Ngọc, Tinh Vân; liền kề từ khoảng 5,3 tỷ, biệt thự sở hữu lâu dài, thanh toán giãn xây 18 – 24 tháng.';
		$projects[ $i ]['fix_content'] = $p['content'];
		$projects[ $i ]['content']     = hh_hai_van_bay_content_2026_10();
		$projects[ $i ]['sources']     = array_values(
			array_unique(
				array_merge(
					$p['sources'] ?? array(),
					array(
						'https://market.vinhomes.vn/du-an/vinhomes-hai-van-bay',
						'https://dantri.com.vn/bat-dong-san/vinh-may-vinhomes-hai-van-bay-an-cu-nghi-duong-giua-trien-nui-huong-bien-20260903180944408.htm',
						'https://vnexpress.net/ra-mat-khu-dao-ngoc-du-an-vinhomes-hai-van-bay-5070332.html',
						'https://tienphong.vn/vinhomes-hai-van-bay-bung-no-giao-dich-trong-ngay-dau-sieu-chinh-sach-khoa-tran-lai-suat-6nam-trong-5-nam-co-hieu-luc-post1836841.tpo',
						'https://dantri.com.vn/bat-dong-san/lai-suat-tran-6nam-gian-xay-18-thang-tai-vinhomes-hai-van-bay-hut-nha-dau-tu-20260507113732005.htm',
						'https://cafef.vn/vinhomes-hai-van-bay-hoan-thien-nhieu-can-thap-tang-mo-co-hoi-an-cu-som-188260401114057061.chn',
					)
				)
			)
		);
	}
	return $projects;
}

function hh_hai_van_bay_content_2026_10() {
	return <<<'HTML'
<p><strong>Vinhomes Hải Vân Bay</strong> (còn gọi <strong>Vinhomes Làng Vân</strong>; tên pháp lý: <em>Khu phức hợp du lịch và đô thị nghỉ dưỡng Làng Vân</em>) là đô thị vịnh biển 512 ha của Tập đoàn Vingroup tại vịnh Nam Chơn, dưới chân đèo Hải Vân – cửa ngõ phía Bắc Đà Nẵng. Dự án có 4 phân khu Bạch Vân, Vịnh Mây, Đảo Ngọc, Tinh Vân; hơn 90% sản phẩm thấp tầng sở hữu lâu dài. Thông tin cập nhật tháng 10/2026.</p>

<h2>Thông tin tổng quan Vinhomes Hải Vân Bay</h2>
<table>
<tbody>
<tr><td>Tên thương mại</td><td>Vinhomes Hải Vân Bay (Vinhomes Làng Vân)</td></tr>
<tr><td>Chủ đầu tư</td><td>Công ty CP Vinpearl – Vinhomes phát triển và tổng thầu (Tập đoàn Vingroup)</td></tr>
<tr><td>Vị trí</td><td>Vịnh Nam Chơn, chân đèo Hải Vân, phường Hải Vân (trước đây Hòa Hiệp Bắc, Liên Chiểu), TP Đà Nẵng</td></tr>
<tr><td>Quy mô</td><td>Khoảng 512 ha, vốn đầu tư khoảng 44.000 tỷ đồng</td></tr>
<tr><td>Phân khu</td><td>Khu 1 Bạch Vân · Khu 2 Vịnh Mây · Khu 3 Đảo Ngọc · Khu 4 Tinh Vân</td></tr>
<tr><td>Sản phẩm</td><td>Liền kề, shophouse, biệt thự song lập, biệt thự đơn lập; cao tầng tại Bạch Vân</td></tr>
<tr><td>Pháp lý</td><td>Chủ trương đầu tư điều chỉnh 20/11/2024; hơn 90% thấp tầng sở hữu lâu dài</td></tr>
<tr><td>Tiến độ</td><td>Khởi công 22/6/2025; ra mắt 20/4/2026; bàn giao thô đợt đầu quý 4/2026 (dự kiến)</td></tr>
</tbody>
</table>

<h2>Vị trí: tựa núi Hải Vân, ba mặt hướng biển</h2>
<p>Vịnh Nam Chơn được núi Hải Vân che chắn, kín gió, bãi biển Làng Vân còn hoang sơ – một trong số ít quỹ đất ven biển quy mô lớn còn lại của Đà Nẵng. Dự án kết nối Quốc lộ 1A, hầm Hải Vân, cao tốc La Sơn – Túy Loan và nằm gần khu vực cảng Liên Chiểu – động lực phát triển phía Bắc thành phố.</p>

<h2>4 phân khu Vinhomes Hải Vân Bay</h2>
<table>
<thead><tr><th>Phân khu</th><th>Diện tích</th><th>Phong cách</th><th>Sản phẩm</th><th>Tình trạng</th></tr></thead>
<tbody>
<tr><td>Khu 1 – Bạch Vân</td><td>~112 ha</td><td>Hong Kong</td><td>~2.524 căn thấp tầng + 15 tòa cao tầng</td><td>Đang bán (từ 20/4/2026)</td></tr>
<tr><td>Khu 2 – Vịnh Mây</td><td>~99,6 ha</td><td>Malibu</td><td>690 sản phẩm: 429 biệt thự, 261 liền kề</td><td>Ra mắt 26/9/2026</td></tr>
<tr><td>Khu 3 – Đảo Ngọc</td><td>~138,8 ha</td><td>Costa Smeralda (Ý)</td><td>2.376 căn thấp tầng</td><td>Đang bán (từ 5/5/2026)</td></tr>
<tr><td>Khu 4 – Tinh Vân</td><td>~161,8 ha</td><td>Nhật Bản</td><td>Nghỉ dưỡng cao cấp, sở hữu 50 năm</td><td>Chưa mở bán</td></tr>
</tbody>
</table>
<h3>Khu 1 – Bạch Vân: sôi động kiểu Hong Kong</h3>
<p>Phân khu mở bán đầu tiên, ở cửa ngõ dự án, gồm liền kề, shophouse, biệt thự song lập, đơn lập và khối cao tầng. Theo tổng mặt bằng tiện ích điều chỉnh mới nhất của chủ đầu tư, Bạch Vân có Lifestyle Hub – tổ hợp thể thao &amp; giải trí, chợ Hong Kong, làng ẩm thực ven suối và Hồ Ngọc Trai.</p>
<h3>Khu 2 – Vịnh Mây: biệt thự đồi hướng vịnh</h3>
<p>Vịnh Mây trải trên sườn đồi cao độ khoảng 4,8 – 187,5 m, mật độ xây dựng thấp, gồm 429 biệt thự (đất 250 – 382 m²) và 261 liền kề (70 – 142 m²). Tiện ích nội khu: Hải Vân Wellness Hub, Oceania Clubhouse, Palm Park.</p>
<h3>Khu 3 – Đảo Ngọc: trung tâm giải trí cạnh VinWonders</h3>
<p>Đảo Ngọc là phân khu trung tâm với 2.376 căn thấp tầng, kết nối trực tiếp VinWonders Hải Vân theo quy hoạch điều chỉnh mới nhất. Phù hợp khách đầu tư cho thuê nghỉ dưỡng và kinh doanh dịch vụ.</p>
<h3>Khu 4 – Tinh Vân</h3>
<p>Phân khu nghỉ dưỡng phong cách Nhật Bản, sở hữu 50 năm, chưa mở bán.</p>

<h2>Bảng giá Vinhomes Hải Vân Bay tháng 10/2026 (tham khảo)</h2>
<p>Khoảng giá dưới đây tổng hợp từ giỏ hàng các đại lý phân phối tháng 9–10/2026, giá đã gồm VAT. Giá từng căn phụ thuộc vị trí, hướng, phương án thanh toán và chính sách tại thời điểm đặt cọc.</p>
<table>
<thead><tr><th>Sản phẩm</th><th>Diện tích đất</th><th>Giá tham khảo</th></tr></thead>
<tbody>
<tr><td>Liền kề Bạch Vân</td><td>63 – 140 m²</td><td>5,3 – 14,2 tỷ</td></tr>
<tr><td>Song lập Bạch Vân</td><td>140 – 160 m²</td><td>9,4 – 21,8 tỷ</td></tr>
<tr><td>Đơn lập Bạch Vân</td><td>140 – 290 m²</td><td>11,1 – 31,7 tỷ</td></tr>
<tr><td>Liền kề Vịnh Mây</td><td>70 – 142 m²</td><td>Từ 5,6 tỷ</td></tr>
<tr><td>Biệt thự đơn lập Vịnh Mây</td><td>223 – 417 m²</td><td>15,1 – 47,3 tỷ</td></tr>
<tr><td>Liền kề Đảo Ngọc</td><td>50 – 174 m²</td><td>Từ 5,5 tỷ (căn góc 8,8 – 21,7 tỷ)</td></tr>
<tr><td>Song lập Đảo Ngọc</td><td>200 – 221 m²</td><td>19,4 – 20,1 tỷ</td></tr>
<tr><td>Đơn lập Đảo Ngọc</td><td>197 – 287 m²</td><td>Từ 15,8 tỷ</td></tr>
</tbody>
</table>
<p>Xem <a href="#gio-hang">giỏ hàng độc quyền 6 căn giá tốt</a> ngay trên trang này – để lại số điện thoại để nhận giá, phiếu tính giá và ảnh chỉ vị trí căn trên mặt bằng.</p>

<h2>Chính sách bán hàng 2026</h2>
<ul>
<li><strong>Thanh toán giãn xây 18 – 24 tháng:</strong> thanh toán phần đất trước, phần xây dựng sau – giảm áp lực vốn ban đầu.</li>
<li><strong>Vay đến 70 – 80%</strong> giá trị căn; hỗ trợ lãi suất 24 tháng (liền kề, shophouse), 36 tháng (biệt thự).</li>
<li><strong>Khóa trần lãi suất:</strong> chương trình đợt 20/4 – 20/7/2026 áp trần 6%/năm trong 5 năm sau thời gian ưu đãi.</li>
<li>Chiết khấu thanh toán sớm và ưu đãi theo tháng thay đổi liên tục – liên hệ để nhận chính sách tháng 10/2026 bản chính thức của chủ đầu tư.</li>
</ul>

<h2>Pháp lý: sở hữu lâu dài</h2>
<p>Phần lớn quỹ đất là đất ở đô thị nên liền kề, shophouse, biệt thự được sở hữu lâu dài cho người Việt Nam – lợi thế hiếm so với nhiều dự án ven biển chỉ có thời hạn 50 năm. Phân khu Tinh Vân và các sản phẩm trên đất du lịch, thương mại có thời hạn 50 năm.</p>

<h2>Tiến độ dự án</h2>
<p>Khởi công 22/6/2025; ra mắt Bạch Vân 20/4/2026, Đảo Ngọc 5/5/2026, Vịnh Mây 26/9/2026. Khoảng 345 căn thấp tầng đầu tiên tại Bạch Vân dự kiến bàn giao thô quý 4/2026; VinWonders Hải Vân và cao tầng Bạch Vân dự kiến hoàn thành quý 4/2027.</p>

<h2>Nhận định của Hoàng Hiệp: chọn phân khu nào?</h2>
<ul>
<li><strong>Vốn khoảng 5,3 – 7 tỷ, ưu tiên nhận nhà sớm:</strong> liền kề Bạch Vân – phân khu bàn giao đầu tiên, nhiều tiện ích thương mại.</li>
<li><strong>Muốn biệt thự lô lớn, không gian riêng tư:</strong> Vịnh Mây – biệt thự đồi hướng vịnh, mật độ thấp, thanh toán giãn xây 24 tháng.</li>
<li><strong>Đầu tư cho thuê, kinh doanh nghỉ dưỡng:</strong> Đảo Ngọc – sát VinWonders Hải Vân, lượng khách du lịch ổn định.</li>
</ul>
<p>Xem thêm: <a href="/loai-du-an/to-hop/">các tổ hợp dự án tại Đà Nẵng</a> · <a href="/mua-ban/">nhà đất mua bán Đà Nẵng</a> · <a href="/lien-he/">liên hệ tư vấn</a>.</p>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo) để nhận bảng hàng đầy đủ, phiếu tính giá theo từng phương án thanh toán, chính sách mới nhất và ảnh chỉ căn trên mặt bằng.</p>
HTML;
}
