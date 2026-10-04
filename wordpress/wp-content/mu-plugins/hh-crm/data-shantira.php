<?php
/**
 * Shantira Beach Resort & Spa Hội An (nay vận hành dưới tên Wyndham Shantira Resort Hội An) –
 * biệt thự Shantira LegaSea và căn hộ du lịch (condotel) ven biển An Bàng, Điện Dương, Điện Bàn
 * (Quảng Nam cũ), tổng hợp báo chí và tin rao công khai (10/2026).
 * Giá chuyển nhượng chỉ để tham khảo – là khoảng giá từ tin rao, không phải bảng giá chủ đầu tư.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_project_dataset', 'hh_dataset_shantira', 20 );
function hh_dataset_shantira( $projects ) {
	$note = 'Khoảng giá tổng hợp từ các tin rao chuyển nhượng công khai (2025 – 2026), chỉ để tham khảo mặt bằng giá. Giá thực tế phụ thuộc vị trí (hàng biệt thự sát biển, tầng và hướng căn hộ), diện tích, nội thất và hợp đồng hợp tác cho thuê với đơn vị vận hành; liên hệ để nhận danh sách căn đang bán thật.';

	$projects[] = array(
		'slug'    => 'shantira-beach-resort-hoi-an',
		'title'   => 'Shantira Beach Resort & Spa Hội An (Wyndham Shantira Resort Hội An)',
		'type'    => array( 'biet-thu', 'can-ho-dich-vu' ),
		'area'    => 'dien-ban',
		'hot'     => false,
		'excerpt' => 'Khu nghỉ dưỡng 8,6 ha sát biển An Bàng (Điện Dương, Điện Bàn): khoảng 70 biệt thự Shantira LegaSea 2 – 3 phòng ngủ có hồ bơi riêng và gần 500 căn hộ du lịch, Wyndham vận hành.',
		'meta'    => array(
			'hh_p_status'        => 'da-ban-giao',
			'hh_p_developer'     => 'Tập đoàn Hoàng Gia Hội An (Hoi An Royal Group / Royal Capital Group)',
			'hh_p_manager'       => 'Wyndham Hotels & Resorts (Wyndham Shantira Resort Hội An, mở cửa 11/11/2022); giai đoạn đầu từng công bố hợp tác Dusit Thani',
			'hh_p_type'          => 'Biệt thự biển, căn hộ du lịch (condotel)',
			'hh_p_address'       => 'Đường Lạc Long Quân, Điện Dương, Điện Bàn (Quảng Nam cũ), nay thuộc TP. Đà Nẵng – sát bãi biển An Bàng, Hội An',
			'hh_p_scale'         => '8,6 ha, hơn 1,5 ha mặt tiền biển; tổng vốn khoảng 1.900 – 2.500 tỷ đồng (các nguồn ghi khác nhau)',
			'hh_p_units'         => 'Khoảng 69 – 70 biệt thự Shantira LegaSea và khoảng 430 – 497 căn hộ du lịch trong 2 tòa hình chữ V (các nguồn ghi khác nhau)',
			'hh_p_unit_area'     => 'Biệt thự đất khoảng 322 – 807 m²; căn hộ studio khoảng 36 – 45 m², 2PN khoảng 52 – 60 m²',
			'hh_p_ownership'     => 'Căn hộ du lịch: 50 năm, gia hạn theo quy định (theo nguồn phân phối); biệt thự cần kiểm tra sổ từng căn',
			'hh_p_highlights'    => "Sát bãi biển An Bàng – một trong những bãi biển đẹp nhất Hội An, cách phố cổ khoảng 5 phút\nKhoảng 70 biệt thự LegaSea 2 tầng, 2 – 3 phòng ngủ, hồ bơi riêng\nCăn hộ thiết kế mở, 100% căn có ban công hướng biển\nVận hành bởi Wyndham Hotels & Resorts từ 11/2022\nCó chương trình hợp tác cho thuê chia sẻ doanh thu với chủ đầu tư",
			'hh_p_villa_desc'    => 'Shantira LegaSea Villas gồm biệt thự 2 và 3 phòng ngủ, cao 2 tầng, thiết kế mở, mỗi căn có hồ bơi riêng; riêng loại 3 phòng ngủ có nguồn ghi 38 căn xếp 5 hàng, 100% view biển. Giá bán gốc theo nguồn phân phối: 2PN đất 348 – 606 m² khoảng 20 – 25 tỷ (chưa VAT), 3PN đất 322 – 807 m² khoảng 22 – 42 tỷ (gồm VAT).',
			'hh_p_villa_table'   => "Biệt thự 2PN (giá gốc) | 348 – 606 m² | 2 phòng ngủ, 2 tầng, hồ bơi riêng | Khoảng 20 – 25 tỷ (chưa VAT)\nBiệt thự 3PN (giá gốc) | 322 – 807 m² | 3 phòng ngủ, 2 tầng, hồ bơi riêng | Khoảng 22 – 42 tỷ (gồm VAT)\nBiệt thự (tin rao) | 292,3 m² | – | Khoảng 21,5 tỷ\nBiệt thự mặt biển (tin rao) | 319 m² | 3 – 4 phòng ngủ | Khoảng 33 tỷ",
			'hh_p_unit_types'    => "Studio | 36 – 45 m² | Studio | Từ khoảng 1,3 tỷ (giá gốc); chuyển nhượng khoảng 1,65 tỷ (tin rao)\nCăn 2PN | 52 – 60 m² | 2 | Từ khoảng 1,8 tỷ (theo nguồn phân phối)",
			'hh_p_resale_price'  => 'Biệt thự khoảng 21,5 – 33 tỷ; căn hộ studio khoảng 1,65 tỷ (tham khảo, tin rao chuyển nhượng)',
			'hh_p_resale_note'   => $note,
			'hh_p_rent_price'    => 'Căn hộ studio khoảng 1,45 – 2,2 triệu/đêm, căn 2PN khoảng 5 – 6,5 triệu/đêm (ngày thường – ngày lễ, tham khảo tin cho thuê)',
			'hh_p_rental'        => 'Theo chính sách bán hàng: chủ căn tham gia hợp tác cho thuê nhận 45% doanh thu thuần (căn hộ), kèm 20 đêm nghỉ miễn phí; với biệt thự LegaSea có nguồn ghi chủ nhận 40% doanh thu thuần, cam kết thu nhập cho thuê không thấp hơn 8%/năm giá trị căn (trước VAT). Người mua chuyển nhượng cần kiểm tra thời hạn và điều khoản hợp đồng còn lại của từng căn.',
			'hh_p_location_desc' => 'Dự án nằm trên đường Lạc Long Quân (trục ven biển Đà Nẵng – Hội An), xã Điện Dương, Điện Bàn – trước thuộc Quảng Nam, nay thuộc TP. Đà Nẵng – liền kề bãi biển An Bàng, gần khu du lịch Le Belhamy, cách phố cổ Hội An khoảng 5 phút di chuyển.',
			'hh_p_connections'   => "Ngay | Bãi biển An Bàng\nKhoảng 5 phút | Phố cổ Hội An\nKhoảng 30 – 40 phút | Trung tâm Đà Nẵng, sân bay quốc tế Đà Nẵng",
			'hh_p_amenities_in'  => "Hồ bơi vô cực, beach bar\nNhà hàng Á – Âu\nSpa, xông hơi khô – ướt, jacuzzi\nPhòng gym\nKhu vui chơi trẻ em trong nhà và ngoài trời, phòng game\nHồ bơi riêng từng biệt thự",
			'hh_p_amenities_out' => "Bãi biển An Bàng\nPhố cổ Hội An\nCù Lao Chàm\nCác resort ven biển Điện Dương – Hà My",
			'hh_p_progress'      => "4/2019 | Khởi công (theo nguồn tổng hợp)\n3/2021 | Hoàn thành xây dựng (theo nguồn tổng hợp)\n11/11/2022 | Mở cửa dưới tên Wyndham Shantira Resort Hội An",
		),
		'content' => '<p><strong>Shantira Beach Resort & Spa Hội An</strong> là khu nghỉ dưỡng ven biển quy mô 8,6 ha trên đường Lạc Long Quân, xã Điện Dương, Điện Bàn (trước thuộc Quảng Nam, nay thuộc TP. Đà Nẵng), liền kề bãi biển An Bàng và chỉ cách phố cổ Hội An khoảng 5 phút. Dự án do Tập đoàn Hoàng Gia Hội An (Hoi An Royal Group, hệ sinh thái Royal Capital Group) phát triển, tổng vốn được các nguồn ghi khoảng 1.900 – 2.500 tỷ đồng. Khu nghỉ dưỡng mở cửa ngày 11/11/2022 dưới tên <strong>Wyndham Shantira Resort Hội An</strong>, do Wyndham Hotels & Resorts vận hành.</p>
<h2>Quy mô và sản phẩm</h2>
<ul>
<li>Khoảng 69 – 70 biệt thự <strong>Shantira LegaSea</strong> 2 – 3 phòng ngủ, cao 2 tầng, thiết kế mở, hồ bơi riêng.</li>
<li>Khoảng 430 – 497 căn hộ du lịch (Shantira LegaSky) trong 2 tòa hình chữ V, 100% căn có ban công hướng biển.</li>
<li>Căn hộ từ studio 36 – 45 m² đến 2 – 3 phòng ngủ; biệt thự đất khoảng 322 – 807 m².</li>
<li>Căn hộ du lịch sở hữu 50 năm, gia hạn theo quy định (theo nguồn phân phối).</li>
</ul>
<h2>Giá bán gốc và chương trình cho thuê</h2>
<p>Theo nguồn phân phối, studio có giá từ khoảng 1,3 tỷ, căn 2 phòng ngủ từ khoảng 1,8 tỷ; biệt thự 2 phòng ngủ khoảng 20 – 25 tỷ (chưa VAT), 3 phòng ngủ khoảng 22 – 42 tỷ (gồm VAT). Chủ căn hộ tham gia hợp tác cho thuê được nhận 45% doanh thu thuần và 20 đêm nghỉ miễn phí; với biệt thự LegaSea, có nguồn ghi tỷ lệ 40% doanh thu thuần kèm cam kết thu nhập tối thiểu 8%/năm giá trị căn (trước VAT).</p>
<h2>Giá chuyển nhượng Shantira Hội An</h2>
<p>Theo tin rao công khai, biệt thự đất khoảng 292 m² được chào khoảng <strong>21,5 tỷ</strong>, biệt thự mặt biển 319 m² khoảng 33 tỷ; căn hộ studio chuyển nhượng khoảng 1,65 tỷ. Giá thuê ngắn ngày tham khảo khoảng 1,45 – 2,2 triệu/đêm cho studio và 5 – 6,5 triệu/đêm cho căn 2 phòng ngủ. Đây là mức tham khảo từ tin rao, không phải bảng giá chủ đầu tư.</p>
<h2>Vì sao được quan tâm</h2>
<p>Vị trí sát bãi biển An Bàng, gần phố cổ di sản, thương hiệu vận hành quốc tế và mức vốn đa dạng – từ căn hộ hơn 1 tỷ đến biệt thự vài chục tỷ – giúp Shantira phù hợp cả khách nghỉ dưỡng lẫn nhà đầu tư dòng tiền cho thuê tại Hội An.</p>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận danh sách căn chuyển nhượng, kiểm tra pháp lý và hợp đồng hợp tác cho thuê trước khi giao dịch.</p>',
		'sources' => array(
			'https://thanhnien.vn/wyndham-hotel-resort-chinh-thuc-van-hanh-shantira-beach-resort-spa-hoi-an-1851060273.htm',
			'https://danangfantasticity.com/en/kham-pha/wyndham-shantira-resort-hoi-an-chinh-thuc-mo-cua-mang-den-trai-nghiem-nghi-duong-thien-nhien-trong-long-di-san-hoi-an',
			'https://thanhnien.vn/cac-gia-tri-dua-biet-thu-bien-shantira-legasea-thanh-tam-diem-tren-cung-duong-di-san-1851060128.htm',
			'https://cafeland.vn/du-an/khu-du-lich-nghi-duong-shantira-beach-resort-and-spa-hoi-an-2502.html',
			'https://batdongsan.com.vn/ban-nha-biet-thu-lien-ke-shantira-beach-resort-spa-hoi-an',
		),
	);

	return $projects;
}
