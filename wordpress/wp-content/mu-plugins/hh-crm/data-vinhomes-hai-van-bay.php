<?php
/**
 * Dự án Vinhomes Hải Vân Bay (Làng Vân) – tổng hợp từ nguồn công khai 10/2026.
 * Thông số chính (quy mô, vốn, khởi công, ra mắt) lấy từ báo chí; giá, quỹ căn, chính sách
 * lấy từ các trang phân phối – là số liệu THAM KHẢO, cần đối chiếu bảng giá chính thức từng đợt.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_project_dataset', 'hh_dataset_hai_van_bay' );
function hh_dataset_hai_van_bay( $projects ) {
	$projects[] = array(
		'slug'    => 'vinhomes-hai-van-bay',
		'title'   => 'Vinhomes Hải Vân Bay (Làng Vân) Đà Nẵng',
		'type'    => array( 'to-hop', 'biet-thu', 'shophouse' ),
		'area'    => 'lien-chieu',
		'hot'     => true,
		'excerpt' => 'Vinhomes Hải Vân Bay (Làng Vân) là đô thị nghỉ dưỡng 512 ha tại vịnh Nam Chơn, chân đèo Hải Vân, Liên Chiểu, Đà Nẵng. 4 phân khu Bạch Vân, Vịnh Mây, Đảo Ngọc, Tinh Vân với khoảng 5.928 căn thấp tầng; giá tham khảo từ 5,2 tỷ, phần lớn sở hữu lâu dài.',
		'content' => hh_hai_van_bay_content(),
		'meta'    => array(
			'hh_p_status'      => 'dang-mo-ban',
			'hh_p_name'        => 'Vinhomes Hải Vân Bay (tên pháp lý: Khu phức hợp du lịch và đô thị nghỉ dưỡng Làng Vân)',
			'hh_p_developer'   => 'Công ty CP Vinpearl (Tập đoàn Vingroup) – phát triển, phân phối: Vinhomes',
			'hh_p_type'        => 'Đô thị nghỉ dưỡng: liền kề, shophouse, biệt thự song lập, biệt thự đơn lập; khối cao tầng (dự kiến)',
			'hh_p_address'     => 'Vịnh Nam Chơn, chân đèo Hải Vân, phường Hòa Hiệp Bắc (cũ), Liên Chiểu, Đà Nẵng',
			'hh_p_scale'       => '512,2 ha (506,9 ha đất, 5,3 ha mặt nước)',
			'hh_p_units'       => 'Khoảng 5.928 sản phẩm thấp tầng; dân số dự kiến khoảng 19.000 người',
			'hh_p_unit_area'   => 'Liền kề 63 – 100 m² · Song lập 140 – 207 m² · Đơn lập 200 – 400 m²',
			'hh_p_price_from'  => '5200',
			'hh_p_price_m2'    => 'Liền kề từ khoảng 82 triệu/m² đất (tham khảo)',
			'hh_p_legal'       => 'Chủ trương đầu tư điều chỉnh ngày 20/11/2024 (512 ha, gần 44.000 tỷ đồng, thực hiện 5 năm)',
			'hh_p_ownership'   => 'Hơn 90% sản phẩm thấp tầng trên đất ở đô thị: sở hữu lâu dài; condotel, khách sạn, shop khối đế: 50 năm',
			'hh_p_start'       => '22/6/2025',
			'hh_p_handover'    => 'Giai đoạn 1 (Bạch Vân): từ 2027 (dự kiến)',
			'hh_p_highlights'  => "Quy mô 512 ha, tổng vốn khoảng 44.000 – 45.000 tỷ đồng, chủ đầu tư Vinpearl (Vingroup)\nVịnh Nam Chơn kín gió dưới chân đèo Hải Vân – cửa ngõ phía Bắc Đà Nẵng\n4 phân khu theo phong cách quốc tế: Bạch Vân (Hồng Kông), Vịnh Mây (Malibu), Đảo Ngọc (Costa Smeralda – Ý), Tinh Vân (Nhật Bản)\nHơn 90% sản phẩm thấp tầng sở hữu lâu dài – hiếm có ở bất động sản ven biển\nHệ tiện ích Vingroup: VinWonders khoảng 24,8 ha, Vincom, Vinschool, Vinmec, bến du thuyền (theo quy hoạch)\nThanh toán giãn 15 – 18 tháng, hỗ trợ vay 70%, hỗ trợ lãi suất 24 – 36 tháng (theo từng đợt)",
			'hh_p_zones'       => "Bạch Vân (giai đoạn 1, khoảng 112 ha) | Liền kề, shophouse, biệt thự song lập, đơn lập; khối cao tầng (dự kiến) | Khoảng 2.500 căn thấp tầng | Đang mở bán từ 4/2026\nĐảo Ngọc (đảo nhân tạo giữa vịnh) | Biệt thự song lập, đơn lập | Khoảng 2.376 căn thấp tầng | Giá dự kiến\nVịnh Mây (sườn đèo Hải Vân) | Biệt thự, nhà phố nghỉ dưỡng | – | Chưa mở bán\nTinh Vân (phong cách Nhật Bản) | Thấp tầng | – | Chưa mở bán",

			'hh_p_location_desc'  => "Vinhomes Hải Vân Bay nằm tại Làng Vân, vịnh Nam Chơn, ngay dưới chân đèo Hải Vân thuộc phường Hòa Hiệp Bắc (cũ), Liên Chiểu – cửa ngõ phía Bắc Đà Nẵng. Vịnh được núi bao bọc ba mặt, bãi biển Làng Vân hoang sơ và kín gió.\nDự án gắn với các trục giao thông chính của miền Trung: Quốc lộ 1A, hầm Hải Vân, cao tốc La Sơn – Túy Loan, đường sắt Bắc – Nam và khu vực cảng Liên Chiểu.",
			'hh_p_connections'    => "Ngay chân đèo | Đèo Hải Vân, hầm Hải Vân\nKết nối trực tiếp | Quốc lộ 1A\nKết nối | Cao tốc La Sơn – Túy Loan\nLân cận | Cảng Liên Chiểu, đường sắt Bắc – Nam",
			'hh_p_amenities_in'   => "Tổ hợp công viên VinWonders khoảng 24,8 ha (theo quy hoạch)\nTrung tâm thương mại Vincom\nTrường liên cấp Vinschool\nBệnh viện quốc tế Vinmec\nBến du thuyền\nBãi biển Làng Vân, bể bơi vô cực hướng biển\nCông viên nước, công viên chủ đề\nKhách sạn, khu nghỉ dưỡng Vinpearl\nSpa, gym, khu thể thao\nPhố shophouse thương mại – dịch vụ",
			'hh_p_amenities_out'  => "Đèo Hải Vân – cung đường di sản\nBiển Nam Ô, Xuân Thiều\nĐại học Bách khoa, Đại học Sư phạm Đà Nẵng\nKhu công nghệ cao Đà Nẵng",

			'hh_p_design_desc'    => "Liền kề cao 4 tầng, mật độ xây dựng khoảng 80%, đất 63 – 100 m². Biệt thự đơn lập cao 4 tầng, mật độ xây dựng 35 – 50%, đất 200 – 400 m². Kiến trúc mỗi phân khu theo một phong cách riêng: Bạch Vân lấy cảm hứng vịnh Victoria (Hồng Kông), Đảo Ngọc theo bờ biển Costa Smeralda (Ý), Vịnh Mây theo Malibu (Mỹ), Tinh Vân theo phong cách Nhật Bản.",
			'hh_p_nha-pho_desc'   => 'Phân khu Bạch Vân có khoảng 2.500 căn thấp tầng, trong đó hơn 400 shophouse dọc các trục thương mại. Liền kề 4 tầng, mật độ xây dựng khoảng 80%. Giá dưới đây là khoảng giá tham khảo theo diện tích đất, chênh lệch theo vị trí, hướng và phương án thanh toán.',
			'hh_p_nha-pho_table'  => "Liền kề Bạch Vân | 63 m² | 4 tầng | 5,2 – 6,3 tỷ\nLiền kề Bạch Vân | 70 m² | 4 tầng | 5,9 – 6,6 tỷ\nLiền kề Bạch Vân | 72 m² | 4 tầng | 6,1 – 9,4 tỷ\nLiền kề Bạch Vân | 75 m² | 4 tầng | 7,4 – 9,8 tỷ\nLiền kề Bạch Vân | 80 m² | 4 tầng | 8,1 – 8,5 tỷ\nLiền kề Bạch Vân | 100 m² | 4 tầng | 9,8 – 10,4 tỷ",
			'hh_p_villa_desc'     => 'Biệt thự song lập là dòng sản phẩm mở bán đầu tiên ở Bạch Vân; Đảo Ngọc là phân khu biệt thự trên đảo nhân tạo giữa vịnh. Biệt thự đơn lập cao 4 tầng, mật độ xây dựng 35 – 50%. Giá Đảo Ngọc là giá dự kiến.',
			'hh_p_villa_table'    => "Song lập Bạch Vân | 140 m² | – | 9,9 – 15,3 tỷ\nSong lập Bạch Vân | 144 m² | – | 15,7 – 15,8 tỷ\nSong lập Bạch Vân | 144,9 – 146,1 m² | – | 14,3 – 14,5 tỷ\nSong lập Bạch Vân | 160 m² | – | 13,7 – 16,8 tỷ\nSong lập Đảo Ngọc | 197,2 – 206,8 m² | – | 14,9 – 15,6 tỷ (dự kiến)\nĐơn lập | 200 – 400 m² | MĐXD 35 – 50%, 4 tầng | 15 – 50 tỷ (dự kiến)",

			'hh_p_price_table'    => "Liền kề Bạch Vân | 63 – 100 m² | 5,2 – 10,4 tỷ | Khoảng 82 triệu/m² đất trở lên\nShophouse Bạch Vân | Theo vị trí | Liên hệ | Hơn 400 căn dọc trục thương mại\nBiệt thự song lập Bạch Vân | 140 – 160 m² | 9,9 – 16,8 tỷ | Dòng mở bán đầu tiên\nBiệt thự song lập Đảo Ngọc | 197 – 207 m² | 14,9 – 15,6 tỷ | Giá dự kiến\nBiệt thự đơn lập | 200 – 400 m² | 15 – 50 tỷ | Giá dự kiến\nCăn hộ cao tầng | – | Chưa công bố | Khối cao tầng dự kiến tại Bạch Vân",
			'hh_p_policy'         => "Thanh toán theo tiến độ, dòng tiền chia nhỏ trong 15 – 18 tháng\nThanh toán nhanh: chiết khấu khoảng 5 – 8%; thanh toán sớm 95% bằng vốn tự có: chiết khấu khoảng 8 – 10%\nHỗ trợ vay đến 70% giá trị\nHỗ trợ lãi suất 0% khoảng 24 tháng (shophouse, liền kề) và 36 tháng (biệt thự song lập, đơn lập)\nSau thời gian hỗ trợ: lãi suất cố định tối đa khoảng 6%/năm trong 5 năm (theo chương trình từng đợt)\nVốn tự có từ khoảng 30%",
			'hh_p_loan'           => 'Ngân hàng hỗ trợ cho vay đến 70% giá trị căn. Chủ đầu tư hỗ trợ lãi suất 0% trong 24 tháng (shophouse, liền kề) hoặc 36 tháng (biệt thự); sau đó lãi suất cố định tối đa khoảng 6%/năm trong 5 năm. Điều kiện cụ thể thay đổi theo từng đợt mở bán – liên hệ để nhận chính sách mới nhất.',

			'hh_p_calc_price'        => '6100',
			'hh_p_loan_ratio'        => '70',
			'hh_p_loan_years'        => '20',
			'hh_p_loan_zero_months'  => '24',
			'hh_p_loan_rate_promo'   => '6',
			'hh_p_loan_promo_months' => '60',
			'hh_p_loan_rate_float'   => '10',
			'hh_p_custom_table'      => "Giá căn liền kề 72 m² (ví dụ) | 6,1 tỷ | Mức thấp của khoảng giá 6,1 – 9,4 tỷ\nVốn tự có 30% | 1,83 tỷ | Thanh toán theo tiến độ 15 – 18 tháng\nNgân hàng cho vay 70% | 4,27 tỷ | Giải ngân theo tiến độ\n24 tháng đầu | 0 đồng tiền lãi | Chủ đầu tư hỗ trợ lãi suất 0%\nTừ tháng 25, lãi tối đa 6%/năm | khoảng 21,4 triệu/tháng | Tiền lãi, chưa gồm gốc\nThanh toán sớm 95%, chiết khấu 8 – 10% | tiết kiệm khoảng 0,49 – 0,61 tỷ | Tính trên giá 6,1 tỷ",
			'hh_p_cashflow_note'     => 'Ví dụ với căn liền kề 72 m² giá 6,1 tỷ: khách chuẩn bị khoảng 1,83 tỷ (30%), phần còn lại vay ngân hàng và được hỗ trợ lãi 0% trong 24 tháng đầu – gần như không phát sinh tiền lãi trong thời gian xây dựng. Từ tháng thứ 25, tiền lãi khoảng 21,4 triệu/tháng nếu lãi suất 6%/năm (chưa tính trả gốc). Khách có sẵn vốn nên so sánh phương án thanh toán sớm 95% với chiết khấu 8 – 10% (tiết kiệm khoảng 490 – 610 triệu). Bảng tính bên dưới cho phép thay giá căn, tỷ lệ vay và lãi suất để xem số tiền trả hằng tháng.',

			'hh_p_progress'       => "20/11/2024 | Thủ tướng Chính phủ điều chỉnh chủ trương đầu tư: 512 ha, gần 44.000 tỷ đồng, thực hiện 5 năm\n22/6/2025 | Khởi công Khu phức hợp du lịch và đô thị nghỉ dưỡng Làng Vân\n20/4/2026 | Vinhomes chính thức ra mắt Vinhomes Hải Vân Bay, mở bán phân khu Bạch Vân\nQuý 4/2026 | Hoàn thiện thô khoảng 345 căn đầu tiên tại Bạch Vân (dự kiến)\nTừ 2027 | Bàn giao giai đoạn 1, đưa các hạng mục đầu tiên vào vận hành (dự kiến)",

			'hh_p_faq'            => "Vinhomes Hải Vân Bay ở đâu? | Dự án nằm tại vịnh Nam Chơn (Làng Vân), dưới chân đèo Hải Vân, phường Hòa Hiệp Bắc (cũ), Liên Chiểu, Đà Nẵng.\nVinhomes Hải Vân Bay và Vinhomes Làng Vân có phải là một? | Đúng. Tên pháp lý là Khu phức hợp du lịch và đô thị nghỉ dưỡng Làng Vân do Vinpearl làm chủ đầu tư; tên thương mại khi Vinhomes ra mắt (20/4/2026) là Vinhomes Hải Vân Bay.\nGiá Vinhomes Hải Vân Bay bao nhiêu? | Theo các đơn vị phân phối, liền kề Bạch Vân khoảng 5,2 – 10,4 tỷ; biệt thự song lập Bạch Vân 9,9 – 16,8 tỷ; Đảo Ngọc dự kiến 14,9 – 44 tỷ. Giá thay đổi theo đợt mở bán – liên hệ để nhận bảng giá chính thức.\nVinhomes Hải Vân Bay có sổ đỏ lâu dài không? | Hơn 90% sản phẩm thấp tầng nằm trên đất ở đô thị nên được sở hữu lâu dài; condotel, khách sạn, shop khối đế trên đất thương mại – dịch vụ có thời hạn 50 năm.\nVinhomes Hải Vân Bay có mấy phân khu? | 4 phân khu: Bạch Vân (mở bán đầu tiên), Vịnh Mây, Đảo Ngọc và Tinh Vân, với khoảng 5.928 căn thấp tầng.\nMua Vinhomes Hải Vân Bay cần bao nhiêu vốn? | Khoảng 30% giá trị căn; ngân hàng cho vay đến 70%, chủ đầu tư hỗ trợ lãi suất 0% trong 24 – 36 tháng tùy loại sản phẩm (theo chính sách từng đợt).\nKhi nào Vinhomes Hải Vân Bay bàn giao? | Dự kiến hoàn thiện thô khoảng 345 căn đầu tiên tại Bạch Vân trong quý 4/2026 và bàn giao giai đoạn 1 từ năm 2027.",

			'rank_math_title'         => 'Vinhomes Hải Vân Bay (Làng Vân): Bảng giá, quỹ căn, chính sách 2026',
			'rank_math_description'   => 'Vinhomes Hải Vân Bay (Làng Vân) 512 ha chân đèo Hải Vân, Đà Nẵng: 4 phân khu, bảng giá quỹ căn liền kề, song lập, đơn lập từ 5,2 tỷ, chính sách vay 70%, sổ đỏ lâu dài.',
			'rank_math_focus_keyword' => 'vinhomes hải vân bay,vinhomes làng vân,giá vinhomes hải vân bay',
		),
		'sources' => array(
			'https://tuoitre.vn/vinpearl-khoi-cong-du-an-44-000-ti-dong-duoi-chan-deo-hai-van-2025062308042255.htm',
			'https://reatimes.vn/vinpearl-khoi-cong-khu-phuc-hop-du-lich-va-do-thi-nghi-duong-lang-van-202250622121821043.htm',
			'https://vnexpress.net/vinhomes-ra-mat-du-an-vinhomes-hai-van-bay-5064704.html',
			'https://tuoitre.vn/ra-mat-vinhomes-hai-van-bay-bieu-tuong-do-thi-vinh-bien-toan-cau-20260420130000161.htm',
			'https://cafef.vn/ra-mat-vinhomes-hai-van-bay-bieu-tuong-do-thi-vinh-bien-toan-cau-188260420212319734.chn',
			'https://tienphong.vn/so-do-lau-dai-gia-tri-thuc-tao-loi-the-khong-doi-thu-cho-do-thi-vinh-bien-vinhomes-hai-van-bay-post1831206.tpo',
			'https://dantri.com.vn/bat-dong-san/giai-phap-tai-chinh-giup-vinhomes-hai-van-bay-chinh-phuc-khach-hang-tre-20260523092655905.htm',
			'https://market.vinhomes.vn/blog/gia-ban-vinhomes-hai-van-bay',
			'https://market.vinhomes.vn/blog/biet-thu-song-lap-vinhomes-hai-van-bay-5-ly-do-nen-dau-tu-2026',
			'https://adongland.vn/phan-khu-vinhomes-hai-van-bay/',
		),
	);
	return $projects;
}

/** Bài giới thiệu chi tiết (phần "Giới thiệu" của trang dự án). */
function hh_hai_van_bay_content() {
	return <<<'HTML'
<p><strong>Vinhomes Hải Vân Bay</strong> (tên pháp lý: <em>Khu phức hợp du lịch và đô thị nghỉ dưỡng Làng Vân</em>, thường gọi <strong>Vinhomes Làng Vân</strong>) là đại đô thị nghỉ dưỡng 512,2 ha của Tập đoàn Vingroup tại vịnh Nam Chơn, dưới chân đèo Hải Vân, Đà Nẵng. Dự án do Công ty CP Vinpearl làm chủ đầu tư với tổng vốn khoảng 44.000 – 45.000 tỷ đồng, khởi công ngày 22/6/2025 và được Vinhomes chính thức ra mắt ngày 20/4/2026.</p>

<h2>Tổng quan Vinhomes Hải Vân Bay</h2>
<ul>
<li><strong>Vị trí:</strong> vịnh Nam Chơn (Làng Vân), phường Hòa Hiệp Bắc (cũ), Liên Chiểu, Đà Nẵng.</li>
<li><strong>Quy mô:</strong> 512,2 ha, gồm 506,9 ha đất và 5,3 ha mặt nước; dân số dự kiến khoảng 19.000 người.</li>
<li><strong>Sản phẩm:</strong> khoảng 5.928 căn thấp tầng – liền kề, shophouse, biệt thự song lập, biệt thự đơn lập; khối cao tầng dự kiến tại phân khu Bạch Vân.</li>
<li><strong>Pháp lý:</strong> chủ trương đầu tư điều chỉnh ngày 20/11/2024; hơn 90% sản phẩm thấp tầng sở hữu lâu dài.</li>
<li><strong>Giá tham khảo:</strong> từ khoảng 5,2 tỷ đồng/căn (liền kề Bạch Vân).</li>
</ul>

<h2>Vị trí vịnh Nam Chơn – cửa ngõ phía Bắc Đà Nẵng</h2>
<p>Vịnh Nam Chơn được núi Hải Vân bao bọc ba mặt, bãi biển Làng Vân kín gió và còn hoang sơ – một trong số ít quỹ đất ven biển quy mô lớn còn lại của Đà Nẵng. Dự án kết nối Quốc lộ 1A, hầm Hải Vân, cao tốc La Sơn – Túy Loan, đường sắt Bắc – Nam và khu vực cảng Liên Chiểu, thuận tiện đi trung tâm Đà Nẵng, Huế và các khu công nghiệp phía Tây Bắc thành phố.</p>

<h2>4 phân khu Vinhomes Hải Vân Bay</h2>
<h3>Bạch Vân – phân khu mở bán đầu tiên</h3>
<p>Rộng khoảng 112 ha ở cửa ngõ dự án, lấy cảm hứng từ vịnh Victoria (Hồng Kông). Bạch Vân có khoảng 2.500 căn thấp tầng (liền kề, hơn 400 shophouse, biệt thự song lập và đơn lập) cùng khối cao tầng dự kiến.</p>
<h3>Đảo Ngọc – biệt thự trên đảo giữa vịnh</h3>
<p>Đảo nhân tạo mang phong cách bờ biển Costa Smeralda (Ý), được quy hoạch làm trung tâm giải trí – văn hóa của dự án, với khoảng 2.376 căn thấp tầng, chủ yếu biệt thự song lập và đơn lập.</p>
<h3>Vịnh Mây và Tinh Vân</h3>
<p>Vịnh Mây nằm trên sườn đèo Hải Vân, lấy cảm hứng từ Malibu (Mỹ); Tinh Vân theo phong cách Nhật Bản. Hai phân khu này chưa mở bán.</p>

<h2>Bảng giá và quỹ căn tham khảo</h2>
<p>Giá dưới đây tổng hợp từ các đơn vị phân phối trong năm 2026, dùng để tham khảo. Giá thực tế phụ thuộc vị trí, hướng, đợt mở bán và phương án thanh toán.</p>
<table>
<thead><tr><th>Sản phẩm</th><th>Diện tích đất</th><th>Giá tham khảo</th></tr></thead>
<tbody>
<tr><td>Liền kề Bạch Vân (4 tầng)</td><td>63 – 100 m²</td><td>5,2 – 10,4 tỷ</td></tr>
<tr><td>Biệt thự song lập Bạch Vân</td><td>140 – 160 m²</td><td>9,9 – 16,8 tỷ</td></tr>
<tr><td>Biệt thự song lập Đảo Ngọc</td><td>197 – 207 m²</td><td>14,9 – 15,6 tỷ (dự kiến)</td></tr>
<tr><td>Biệt thự đơn lập (4 tầng)</td><td>200 – 400 m²</td><td>15 – 50 tỷ (dự kiến)</td></tr>
</tbody>
</table>
<p>Bảng chi tiết theo từng diện tích nằm ở mục <a href="#san-pham">Loại sản phẩm</a>; phương án vốn – vay ở mục <a href="#chinh-sach">Chính sách</a>.</p>

<h2>Chính sách bán hàng</h2>
<ul>
<li>Thanh toán theo tiến độ, chia nhỏ trong 15 – 18 tháng; vốn tự có từ khoảng 30%.</li>
<li>Ngân hàng cho vay đến 70%; hỗ trợ lãi suất 0% khoảng 24 tháng (liền kề, shophouse) hoặc 36 tháng (biệt thự).</li>
<li>Thanh toán nhanh chiết khấu khoảng 5 – 8%; thanh toán sớm 95% chiết khấu khoảng 8 – 10%.</li>
</ul>
<p>Chính sách thay đổi theo từng đợt. Liên hệ Hoàng Hiệp để nhận bảng giá, quỹ căn và chính sách mới nhất.</p>

<h2>Pháp lý: sổ đỏ lâu dài</h2>
<p>Phần lớn quỹ đất được quy hoạch là đất ở đô thị nên các sản phẩm thấp tầng (liền kề, shophouse, biệt thự) được sở hữu lâu dài – lợi thế lớn so với nhiều dự án ven biển chỉ có thời hạn 50 năm. Condotel, khách sạn và shop khối đế nằm trên đất thương mại – dịch vụ có thời hạn 50 năm.</p>

<h2>Tiến độ</h2>
<p>Dự án khởi công ngày 22/6/2025, ra mắt ngày 20/4/2026 với phân khu Bạch Vân. Theo kế hoạch, khoảng 345 căn đầu tiên tại Bạch Vân hoàn thiện thô trong quý 4/2026; giai đoạn 1 dự kiến bàn giao từ năm 2027.</p>

<h2>Nhận định của Hoàng Hiệp</h2>
<p>Vinhomes Hải Vân Bay mở rộng thị trường bất động sản nghỉ dưỡng Đà Nẵng về phía Bắc với lợi thế hiếm: quy mô lớn, vịnh biển riêng, pháp lý sở hữu lâu dài và hệ sinh thái Vingroup. Liền kề Bạch Vân phù hợp khách muốn vốn ban đầu thấp (từ khoảng 1,6 – 1,9 tỷ vốn tự có), biệt thự Đảo Ngọc hướng đến khách tài chính mạnh, giữ tài sản dài hạn. Trước khi xuống tiền, nên so sánh vị trí từng căn với tiến độ hạ tầng, tính kỹ dòng tiền sau thời gian hỗ trợ lãi và đối chiếu bảng giá chính thức từng đợt.</p>
<p>Xem thêm: <a href="/loai-du-an/to-hop/">các tổ hợp dự án tại Đà Nẵng</a> · <a href="/mua-ban/lien-chieu/">nhà đất bán Liên Chiểu</a> · <a href="/lien-he/">liên hệ tư vấn</a>.</p>
HTML;
}
