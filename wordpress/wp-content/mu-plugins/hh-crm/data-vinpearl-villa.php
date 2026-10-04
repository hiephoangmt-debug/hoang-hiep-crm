<?php
/**
 * Biệt thự Vinpearl Đà Nẵng (Vinpearl Luxury Đà Nẵng – nay là Danang Marriott Resort & Spa; Vinpearl Resort & Spa Đà Nẵng – giai đoạn 2)
 * và Vinpearl Nam Hội An (Thăng Bình, Quảng Nam cũ), tổng hợp báo chí và tin rao công khai (10/2026).
 * Giá chuyển nhượng chỉ để tham khảo – là khoảng giá từ tin rao, không phải bảng giá chủ đầu tư.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_project_dataset', 'hh_dataset_vinpearl_villa', 20 );
function hh_dataset_vinpearl_villa( $projects ) {
	$note = 'Khoảng giá tổng hợp từ các tin rao chuyển nhượng công khai (2025 – 2026), chỉ để tham khảo mặt bằng giá. Giá thực tế phụ thuộc vị trí (mặt biển, view hồ, sân vườn), diện tích đất, số phòng ngủ và hợp đồng vận hành – thuê lại với Vinpearl; liên hệ để nhận danh sách căn đang bán thật.';

	$projects[] = array(
		'slug'    => 'vinpearl-luxury-da-nang-villa',
		'title'   => 'Biệt thự Vinpearl Luxury Đà Nẵng (Danang Marriott Resort & Spa)',
		'type'    => 'biet-thu',
		'area'    => 'ngu-hanh-son',
		'hot'     => false,
		'excerpt' => '39 biệt thự biển Vinpearl Luxury Đà Nẵng (nay là Danang Marriott Resort & Spa) trên đường Trường Sa, Ngũ Hành Sơn: đất lớn, 2 – 4 phòng ngủ, sổ đỏ lâu dài, giao dịch chuyển nhượng.',
		'meta'    => array(
			'hh_p_status'        => 'da-ban-giao',
			'hh_p_sold_out'      => '1',
			'hh_p_developer'     => 'Công ty CP Vinpearl (Tập đoàn Vingroup)',
			'hh_p_manager'       => 'Marriott International (Danang Marriott Resort & Spa, đổi tên từ Vinpearl Luxury Đà Nẵng từ 9/2022)',
			'hh_p_type'          => 'Biệt thự nghỉ dưỡng ven biển',
			'hh_p_address'       => 'Số 7 Trường Sa, phường Hòa Hải (cũ), Ngũ Hành Sơn, Đà Nẵng – bãi biển Non Nước',
			'hh_p_scale'         => '15,4 ha, tổng vốn hơn 100 triệu USD',
			'hh_p_units'         => '39 biệt thự và 200 phòng khách sạn',
			'hh_p_unit_area'     => 'Đất khoảng 686 – 1.300 m² (nhiều căn trên 1.000 m²)',
			'hh_p_ownership'     => 'Sở hữu lâu dài (sổ đỏ)',
			'hh_p_highlights'    => "Chỉ 39 biệt thự biển trong quần thể 15,4 ha bên bãi biển Non Nước\nĐất lớn, nhiều căn trên 1.000 m², có hồ bơi riêng\nVận hành bởi Marriott International từ 9/2022 (Danang Marriott Resort & Spa)\nSổ đỏ sở hữu lâu dài – hiếm ở phân khúc biệt thự nghỉ dưỡng\nĐã hoàn thiện, đang vận hành, giao dịch trên thị trường thứ cấp",
			'hh_p_villa_desc'    => 'Biệt thự Vinpearl Luxury Đà Nẵng có 2 – 4 phòng ngủ, đa số 2 tầng, hướng biển, đất khoảng 686 – 1.300 m², kiến trúc kết hợp nét Chăm với phong cách Pháp cổ điển và đương đại. Căn đang được rao chuyển nhượng chủ yếu là 4 phòng ngủ đất khoảng 1.000 m².',
			'hh_p_villa_table'   => "Biệt thự 4PN (tin rao) | Khoảng 1.020 m² | 4 phòng ngủ, 2 tầng | Khoảng 40 – 45 tỷ\nBiệt thự 4PN ven nước (tin rao) | 829 m² | 4 phòng ngủ | Khoảng 75 tỷ",
			'hh_p_resale_price'  => 'Khoảng 40 – 45 tỷ (4PN đất khoảng 1.000 m²), có căn rao đến khoảng 75 tỷ (tham khảo, tin rao chuyển nhượng)',
			'hh_p_resale_note'   => $note,
			'hh_p_rental'        => 'Biệt thự nằm trong chương trình vận hành cho thuê của khu nghỉ dưỡng; tin rao nêu thu nhập cho thuê khoảng 3 – 3,4 tỷ/năm, chi trả 6 tháng/lần (tham khảo, cần đối chiếu hợp đồng từng căn).',
			'hh_p_location_desc' => 'Dự án nằm trên đường Trường Sa, trục ven biển Đà Nẵng – Hội An, ngay bãi biển Non Nước, tựa lưng vào danh thắng Ngũ Hành Sơn. Khu vực tập trung nhiều resort 5 sao như Furama, Hyatt Regency, Sheraton Grand.',
			'hh_p_connections'   => "Ngay | Bãi biển Non Nước\n5 phút | Danh thắng Ngũ Hành Sơn\n15 – 20 phút | Trung tâm Đà Nẵng, sân bay quốc tế Đà Nẵng\n25 – 30 phút | Phố cổ Hội An",
			'hh_p_amenities_in'  => "5 hồ bơi ngoài trời\nSpa, trung tâm thể dục\nNhà hàng, bar\nKids Club\nKhu thể thao\nPhòng hội nghị\nXe đưa đón sân bay, y tế 24/7",
			'hh_p_amenities_out' => "Bãi biển Non Nước\nDanh thắng Ngũ Hành Sơn, làng đá Non Nước\nCác sân golf Danang Golf Club, Montgomerie Links\nPhố cổ Hội An",
			'hh_p_progress'      => "11/2009 | Khởi công\n3/7 (sau khoảng 20 tháng thi công) | Khai trương Vinpearl Luxury Đà Nẵng\n9/2022 | Đổi tên Danang Marriott Resort & Spa, Marriott vận hành",
		),
		'content' => '<p><strong>Biệt thự Vinpearl Luxury Đà Nẵng</strong> là 39 căn biệt thự biển thuộc khu nghỉ dưỡng 15,4 ha trên đường Trường Sa (Ngũ Hành Sơn), ngay bãi biển Non Nước. Dự án do Vinpearl (Tập đoàn Vingroup) đầu tư hơn 100 triệu USD, khởi công tháng 11/2009 và khai trương ngày 3/7 sau khoảng 20 tháng thi công – là dự án Vinpearl đầu tiên ngoài Nha Trang. Từ tháng 9/2022, khu nghỉ dưỡng được đổi tên thành <strong>Danang Marriott Resort & Spa</strong> do Marriott International vận hành.</p>
<h2>Quy mô và sản phẩm</h2>
<ul>
<li>200 phòng khách sạn và 39 biệt thự biển 2 – 4 phòng ngủ.</li>
<li>Diện tích đất khoảng 686 – 1.300 m², nhiều căn trên 1.000 m², có hồ bơi riêng.</li>
<li>Kiến trúc kết hợp nét Chăm với phong cách Pháp cổ điển và đương đại.</li>
<li>Khách hàng được cấp sổ đỏ, sở hữu lâu dài.</li>
</ul>
<h2>Giá chuyển nhượng biệt thự Vinpearl Luxury Đà Nẵng</h2>
<p>Chủ đầu tư đã bán hết, giao dịch hiện nay là chuyển nhượng giữa các chủ sở hữu. Theo tin rao công khai, biệt thự 4 phòng ngủ đất khoảng 1.000 m² được chào khoảng <strong>40 – 45 tỷ</strong>, có căn ven nước 829 m² rao khoảng 75 tỷ. Một số tin rao nêu thu nhập cho thuê khoảng 3 – 3,4 tỷ/năm. Đây là mức tham khảo từ tin rao chuyển nhượng; giá thực tế phụ thuộc vị trí, hiện trạng và hợp đồng vận hành từng căn.</p>
<h2>Vì sao được quan tâm</h2>
<p>Số lượng chỉ 39 căn, đất lớn, mặt biển Non Nước, sổ đỏ lâu dài và thương hiệu vận hành quốc tế khiến biệt thự Vinpearl Luxury Đà Nẵng thuộc nhóm tài sản nghỉ dưỡng hiếm tại Đà Nẵng, phù hợp khách giữ tài sản dài hạn kết hợp nghỉ dưỡng và cho thuê.</p>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận danh sách căn đang chuyển nhượng, kiểm tra pháp lý và hợp đồng vận hành trước khi xuống tiền.</p>',
		'sources' => array(
			'https://en.nhandan.vn/vinpearl-luxury-da-nang-inaugurated-post2468.html',
			'https://thesaigontimes.vn/khai-truong-vinpearl-luxury-da-nang/',
			'https://www.hotel.com.au/danang/danang-marriott-resort-and-spa.htm',
			'https://homedy.com/biet-thu-nghi-duong-vinpearl-premium-da-nang-pj39948706',
			'https://batdongsan.com.vn/ban-nha-biet-thu-lien-ke-vinpearl-premium-da-nang',
		),
	);

	$projects[] = array(
		'slug'    => 'vinpearl-resort-spa-da-nang-villa',
		'title'   => 'Biệt thự Vinpearl Resort & Spa Đà Nẵng (Vinpearl Đà Nẵng 2)',
		'type'    => 'biet-thu',
		'area'    => 'ngu-hanh-son',
		'hot'     => false,
		'excerpt' => 'Biệt thự Vinpearl Đà Nẵng giai đoạn 2 (Vinpearl Resort & Spa Đà Nẵng) trên đường Trường Sa: khoảng 122 căn 2 – 4 phòng ngủ, đất 376 – 800 m², giá chuyển nhượng khoảng 10 – 17 tỷ.',
		'meta'    => array(
			'hh_p_status'        => 'da-ban-giao',
			'hh_p_sold_out'      => '1',
			'hh_p_developer'     => 'Công ty CP Vinpearl (Tập đoàn Vingroup)',
			'hh_p_manager'       => 'Vinpearl',
			'hh_p_type'          => 'Biệt thự nghỉ dưỡng ven biển',
			'hh_p_address'       => 'Đường Trường Sa, phường Hòa Hải (cũ), Ngũ Hành Sơn, Đà Nẵng',
			'hh_p_units'         => 'Khoảng 122 biệt thự (có nguồn ghi 102 căn); toàn khu Vinpearl Đà Nẵng 2 giai đoạn khoảng 161 biệt thự',
			'hh_p_unit_area'     => 'Đất khoảng 376 – 800 m²',
			'hh_p_ownership'     => 'Sở hữu lâu dài (sổ đỏ)',
			'hh_p_highlights'    => "Biệt thự view biển và view hồ, 2 – 4 phòng ngủ, có hồ bơi riêng\nNội thất hoàn thiện tiêu chuẩn 5 sao, đang vận hành cho thuê\nChương trình chia sẻ lợi nhuận 85/15 với Vinpearl (theo chính sách mở bán)\nSổ đỏ sở hữu lâu dài\nMức giá chuyển nhượng dễ tiếp cận hơn nhóm biệt thự biển Trường Sa",
			'hh_p_villa_desc'    => 'Giai đoạn 2 gồm khoảng 122 biệt thự view biển và view hồ, đất khoảng 376 – 800 m², 2 – 4 phòng ngủ, giá bán gốc khi mở bán khoảng 700.000 – 1,2 triệu USD/căn. Mẫu phổ biến trên thị trường chuyển nhượng là biệt thự 2 tầng 3 phòng ngủ, có hồ bơi riêng, nội thất đầy đủ.',
			'hh_p_villa_table'   => "Biệt thự 3PN (tin rao) | 450 m² | 3 phòng ngủ | Khoảng 12 tỷ\nBiệt thự 3PN 2 tầng (tin rao) | 500 m² | 3 phòng ngủ | Khoảng 13,8 – 14 tỷ\nBiệt thự (tin rao) | 600 m² | – | Khoảng 15,8 tỷ\nBiệt thự 4PN gần biển (tin rao) | 600 m² | 4 phòng ngủ | Khoảng 17 tỷ",
			'hh_p_resale_price'  => 'Khoảng 10 – 17 tỷ (tham khảo, tin rao chuyển nhượng)',
			'hh_p_resale_note'   => $note,
			'hh_p_rent_price'    => 'Giá phòng villa niêm yết khoảng 6,9 triệu/đêm (2PN) đến 13,6 triệu/đêm (4PN view biển) – tham khảo',
			'hh_p_rental'        => 'Khi mở bán, Vinpearl cam kết lợi nhuận tối thiểu 8%/năm (tính theo USD) hoặc 10%/năm (tính theo VNĐ) trong 10 năm, chủ biệt thự hưởng 85% lợi nhuận cho thuê. Tin rao chuyển nhượng hiện nêu thu nhập khoảng 1,55 tỷ/năm cho căn 3PN 500 m² (tham khảo).',
			'hh_p_location_desc' => 'Khu biệt thự nằm trên đường Trường Sa, cạnh Vinpearl Luxury Đà Nẵng (nay là Danang Marriott Resort & Spa), gần bãi biển Non Nước và danh thắng Ngũ Hành Sơn, trên trục ven biển Đà Nẵng – Hội An.',
			'hh_p_connections'   => "Vài phút | Bãi biển Non Nước\n5 phút | Danh thắng Ngũ Hành Sơn\n15 – 20 phút | Trung tâm Đà Nẵng, sân bay quốc tế Đà Nẵng\n25 – 30 phút | Phố cổ Hội An",
			'hh_p_amenities_in'  => "Hồ bơi riêng từng biệt thự\nHồ bơi chung, nhà hàng, bar\nVincharm Spa\nKids Club, khu thể thao\nXe đưa đón sân bay",
			'hh_p_amenities_out' => "Bãi biển Non Nước\nDanh thắng Ngũ Hành Sơn\nSân golf Danang Golf Club, Montgomerie Links\nPhố cổ Hội An",
			'hh_p_progress'      => "Cuối 10/2015 | Mở bán biệt thự giai đoạn 2\n29/4/2017 | Khai trương, đưa biệt thự vào vận hành (theo nguồn tổng hợp)",
		),
		'content' => '<p><strong>Biệt thự Vinpearl Resort & Spa Đà Nẵng</strong> (thường gọi Vinpearl Đà Nẵng 2, trên các trang rao vặt còn ghi Vinpearl Premium Đà Nẵng) là giai đoạn 2 của quần thể biệt thự Vinpearl trên đường Trường Sa, Ngũ Hành Sơn. Dự án do Vinpearl thuộc Tập đoàn Vingroup đầu tư, mở bán cuối tháng 10/2015 và đưa vào vận hành từ khoảng năm 2017.</p>
<h2>Quy mô và sản phẩm</h2>
<ul>
<li>Khoảng 122 biệt thự view biển và view hồ (có nguồn ghi 102 căn); cả hai giai đoạn Vinpearl Đà Nẵng có khoảng 161 biệt thự.</li>
<li>Đất khoảng 376 – 800 m², 2 – 4 phòng ngủ, hồ bơi riêng, nội thất tiêu chuẩn 5 sao.</li>
<li>Giá bán gốc khi mở bán khoảng 700.000 – 1,2 triệu USD/căn.</li>
<li>Sở hữu lâu dài, cấp sổ đỏ.</li>
</ul>
<h2>Chương trình cho thuê</h2>
<p>Theo chính sách mở bán, Vinpearl cam kết lợi nhuận tối thiểu 8%/năm (tính theo USD) hoặc 10%/năm (tính theo VNĐ) trong 10 năm, tỷ lệ chia lợi nhuận 85% cho chủ biệt thự và 15% cho đơn vị vận hành. Người mua chuyển nhượng cần kiểm tra thời hạn còn lại của hợp đồng thuê từng căn.</p>
<h2>Giá chuyển nhượng biệt thự Vinpearl Đà Nẵng 2</h2>
<p>Theo tin rao công khai, biệt thự 3 phòng ngủ đất 450 – 500 m² được chào khoảng <strong>12 – 14 tỷ</strong>, căn 600 m² khoảng 15,8 – 17 tỷ; mặt bằng chung khoảng 10 – 17 tỷ. Một số tin rao nêu thu nhập cho thuê khoảng 1,55 tỷ/năm với căn 3 phòng ngủ. Đây là giá tham khảo từ tin rao chuyển nhượng, không phải bảng giá chủ đầu tư.</p>
<p>So với biệt thự biển cùng trục Trường Sa, biệt thự Vinpearl Đà Nẵng 2 có mức vốn dễ tiếp cận hơn, phù hợp khách muốn sở hữu lâu dài biệt thự nghỉ dưỡng có sẵn dòng tiền cho thuê.</p>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận danh sách căn chuyển nhượng, đối chiếu sổ đỏ và hợp đồng vận hành trước khi giao dịch.</p>',
		'sources' => array(
			'https://vnexpress.net/mua-biet-thu-vinpearl-resort-amp-villas-duoc-dam-bao-loi-nhuan-3314577.html',
			'https://homedy.com/vinpearl-da-nang-resort-and-villas-pj92249814',
			'https://idautubatdongsan.com/biet-thu-vinpearl-da-nang-resort-villas.html',
			'https://batdongsan.com.vn/ban-nha-biet-thu-lien-ke-duong-truong-sa-phuong-hoa-hai-prj-vinpearl-premium-da-nang/ban-bien-3pn-gia-tot-tai-2-ng-cho-e-loi-nhuan-cuc-cao-net-10-nam-pr43714643',
			'https://bds68.com.vn/ban-nha-biet-thu-du-an/da-nang/ngu-hanh-son/vinpearl-premium-da-nang',
		),
	);

	$projects[] = array(
		'slug'    => 'vinpearl-nam-hoi-an-villa',
		'title'   => 'Biệt thự Vinpearl Nam Hội An (Vinpearl Resort & Golf Nam Hội An)',
		'type'    => 'biet-thu',
		'area'    => 'duy-xuyen',
		'hot'     => false,
		'excerpt' => '132 biệt thự biển Vinpearl Resort & Golf Nam Hội An (Bình Minh – Bình Dương, Thăng Bình), khai trương 28/4/2018; giá chuyển nhượng khoảng 9 – 16 tỷ, có chương trình chia lợi nhuận cho thuê.',
		'meta'    => array(
			'hh_p_status'        => 'da-ban-giao',
			'hh_p_sold_out'      => '1',
			'hh_p_developer'     => 'Công ty CP Vinpearl Nam Hội An (Tập đoàn Vingroup)',
			'hh_p_manager'       => 'Vinpearl',
			'hh_p_type'          => 'Biệt thự nghỉ dưỡng ven biển, sân golf',
			'hh_p_address'       => 'Xã Bình Minh và Bình Dương, huyện Thăng Bình (Quảng Nam cũ), nay thuộc TP. Đà Nẵng – ven biển phía Nam Hội An',
			'hh_p_scale'         => 'Tổ hợp khoảng 200 ha (có nguồn ghi 168,7 ha), vốn khoảng 5.000 tỷ đồng',
			'hh_p_units'         => '132 biệt thự và 429 phòng khách sạn',
			'hh_p_unit_area'     => 'Đất khoảng 380 – 500 m² (phổ biến), có căn mặt biển lớn hơn',
			'hh_p_ownership'     => 'Sở hữu lâu dài theo chính sách mở bán (cần kiểm tra sổ từng căn)',
			'hh_p_highlights'    => "Tổ hợp nghỉ dưỡng Vinpearl gồm khách sạn, biệt thự, sân golf 18 lỗ, công viên chủ đề VinWonders Nam Hội An\nChỉ 132 biệt thự, hoàn thiện nội thất, đang vận hành cho thuê\nChủ biệt thự được 15 đêm nghỉ miễn phí/năm trong hệ thống Vinpearl\nLợi nhuận cho thuê chi trả 6 tháng/lần\nGiá chuyển nhượng thấp hơn nhiều so với giá bán gốc",
			'hh_p_villa_desc'    => 'Biệt thự Vinpearl Nam Hội An gồm các loại 2 – 5 phòng ngủ, view vườn hoặc view biển, hoàn thiện nội thất trong và ngoài. Khi mở bán, giá từ khoảng 16,8 tỷ/căn; hiện căn 3 phòng ngủ đất khoảng 420 m² được rao chuyển nhượng khoảng 9 – 12 tỷ.',
			'hh_p_villa_table'   => "Biệt thự 3PN (tin rao) | 420 m² | 3 phòng ngủ | Khoảng 9 tỷ (bao phí)\nBiệt thự 3PN view biển (tin rao) | 420 m² | 3 phòng ngủ | Khoảng 12 tỷ\nBiệt thự view biển (tin rao) | – | – | Khoảng 10 tỷ (bao phí)\nBiệt thự (tin rao) | 500 m² | – | Khoảng 15,8 tỷ",
			'hh_p_resale_price'  => 'Khoảng 9 – 16 tỷ (tham khảo, tin rao chuyển nhượng); giá bán gốc khi mở bán từ khoảng 16,8 tỷ/căn',
			'hh_p_resale_note'   => $note,
			'hh_p_rent_price'    => 'Liên hệ (giá phòng villa theo bảng giá khách sạn Vinpearl từng mùa)',
			'hh_p_rental'        => 'Chính sách mở bán: Vinpearl cam kết chia lợi nhuận tối thiểu 10%/năm (VNĐ) hoặc 8%/năm (USD) trong 10 năm, chi trả 6 tháng/lần; chủ biệt thự được 15 đêm nghỉ miễn phí/năm trong hệ thống Vinpearl. Tin rao chuyển nhượng hiện nêu lợi nhuận khoảng 1,8 – 2 tỷ/năm (tham khảo).',
			'hh_p_location_desc' => 'Vinpearl Nam Hội An nằm trên dải ven biển xã Bình Minh và Bình Dương (Thăng Bình), phía Nam Hội An, giáp vùng biển Duy Xuyên – nơi có Hoiana Resort & Golf. Trước sáp nhập thuộc Quảng Nam, nay thuộc TP. Đà Nẵng.',
			'hh_p_connections'   => "Ngay | Bãi biển Bình Minh\nCùng tổ hợp | VinWonders Nam Hội An, sân golf 18 lỗ\nKhoảng 30 – 40 phút | Phố cổ Hội An\nKhoảng 45 – 60 phút | Sân bay Đà Nẵng, sân bay Chu Lai",
			'hh_p_amenities_in'  => "Khách sạn 5 sao 429 phòng\nSân golf 18 lỗ\nCông viên chủ đề VinWonders Nam Hội An (tên trước đây Vinpearl Land)\nKhu nông nghiệp công nghệ cao kết hợp du lịch sinh thái\nHồ bơi, spa, nhà hàng, khu thể thao",
			'hh_p_amenities_out' => "Phố cổ Hội An, Cù Lao Chàm\nHoiana Resort & Golf (Duy Xuyên)\nThánh địa Mỹ Sơn",
			'hh_p_progress'      => "28/4/2018 | Khai trương Vinpearl Resort & Golf Nam Hội An",
		),
		'content' => '<p><strong>Biệt thự Vinpearl Nam Hội An</strong> thuộc tổ hợp Vinpearl Resort & Golf Nam Hội An trên dải ven biển xã Bình Minh và Bình Dương (Thăng Bình), phía Nam phố cổ Hội An – trước thuộc Quảng Nam, nay thuộc TP. Đà Nẵng. Tổ hợp do Vinpearl (Tập đoàn Vingroup) đầu tư khoảng 5.000 tỷ đồng trên diện tích khoảng 200 ha và khai trương ngày 28/4/2018.</p>
<h2>Quy mô và sản phẩm</h2>
<ul>
<li>132 biệt thự biển và 429 phòng khách sạn tiêu chuẩn 5 sao.</li>
<li>Sân golf 18 lỗ, công viên chủ đề VinWonders Nam Hội An, khu nông nghiệp công nghệ cao kết hợp du lịch sinh thái.</li>
<li>Biệt thự 2 – 5 phòng ngủ, view vườn hoặc view biển, hoàn thiện nội thất trong và ngoài.</li>
</ul>
<h2>Chương trình cho thuê</h2>
<p>Khi mở bán, Vinpearl công bố chia sẻ lợi nhuận tối thiểu 10%/năm (VNĐ) hoặc 8%/năm (USD) trong 10 năm, chi trả 6 tháng/lần, chủ biệt thự được 15 đêm nghỉ miễn phí mỗi năm trong hệ thống Vinpearl. Giá bán gốc khi đó từ khoảng 16,8 tỷ/căn.</p>
<h2>Giá chuyển nhượng biệt thự Vinpearl Nam Hội An</h2>
<p>Theo tin rao công khai, biệt thự 3 phòng ngủ đất khoảng 420 m² được chào khoảng <strong>9 – 12 tỷ</strong>, căn view biển khoảng 10 tỷ (bao phí), căn đất 500 m² khoảng 15,8 tỷ. Một số tin rao nêu lợi nhuận khoảng 1,8 – 2 tỷ/năm. Mức giá này thấp hơn đáng kể giá bán gốc – đây là giá tham khảo từ tin rao chuyển nhượng, cần kiểm tra pháp lý, thời hạn sử dụng đất và hợp đồng vận hành từng căn.</p>
<p>Với hạ tầng ven biển phía Nam Đà Nẵng mới đang được đầu tư, biệt thự Vinpearl Nam Hội An phù hợp khách muốn sở hữu biệt thự nghỉ dưỡng thương hiệu Vingroup với số vốn thấp hơn khu vực Ngũ Hành Sơn.</p>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận danh sách căn chuyển nhượng, kiểm tra sổ và hợp đồng thuê trước khi giao dịch.</p>',
		'sources' => array(
			'https://dongtayland.vn/du-an/vinpearl-resort-golf-nam-hoi-an/',
			'https://vneconomy.vn/tat-ca-trong-mot-o-vinpearl-nam-hoi-an-resort-villas.htm',
			'https://namhoianvillas.com/chinh-sach-dau-tu-vinpearl-nam-hoi-an/',
			'https://bds68.com.vn/ban-nha-biet-thu-du-an/quang-nam/thang-binh/vinpearl-nam-hoi-an',
			'https://batdongsan.com.vn/ban-nha-biet-thu-lien-ke-vinpearl-nam-hoi-an',
		),
	);

	return $projects;
}
