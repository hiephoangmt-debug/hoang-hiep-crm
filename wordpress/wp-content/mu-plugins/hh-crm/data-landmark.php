<?php
/**
 * Danang Landmark (Danang Landmark Tower) – Bạch Đằng nối dài, cạnh công viên APEC (Hải Châu cũ): tháp đôi Dragon 39 tầng và Phoenix 31 tầng, 454 căn,
 * chủ đầu tư Cosmos Housing, đủ điều kiện kinh doanh từ 03/2026. Tổng hợp báo chí (Báo Đầu tư, Tuổi Trẻ, Báo Đà Nẵng) và trang phân phối (10/2026).
 * Giá là mức chào bán tham khảo – cần đối chiếu bảng giá chủ đầu tư từng đợt.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_project_dataset', 'hh_dataset_landmark', 20 );
function hh_dataset_landmark( $projects ) {
	$projects[] = array(
		'slug'    => 'danang-landmark',
		'title'   => 'Danang Landmark (Đà Nẵng Landmark Tower)',
		'type'    => 'can-ho-so-huu-lau-dai',
		'area'    => 'hai-chau',
		'hot'     => true,
		'excerpt' => 'Tháp đôi căn hộ Danang Landmark ven sông Hàn, cạnh công viên APEC và cầu Rồng: 454 căn sở hữu lâu dài, chuẩn Nhật Bản, do Cosmos Housing phát triển, đủ điều kiện mở bán từ 3/2026.',
		'meta'    => array(
			'hh_p_status'       => 'dang-mo-ban',
			'hh_p_developer'    => 'Công ty CP Cosmos Housing (đối tác hợp tác đầu tư: DIN Capital – mã PDB)',
			'hh_p_builder'      => 'Công ty CP Kỹ thuật Xây dựng DINCO (DINCO E&C)',
			'hh_p_type'         => 'Khu phức hợp trung tâm thương mại – căn hộ cao cấp, penthouse, duplex, căn hộ kết hợp kinh doanh',
			'hh_p_address'      => 'Đường Bạch Đằng nối dài (giáp Bình Minh 4, Trần Văn Trứ), cạnh công viên APEC, phường Hòa Cường, Đà Nẵng (Hải Châu cũ)',
			'hh_p_scale'        => 'Khoảng 3.765 m² đất; tổng vốn đầu tư khoảng 1.600 tỷ đồng',
			'hh_p_blocks'       => '2 tòa tháp đôi: Dragon và Phoenix',
			'hh_p_floors'       => 'Dragon 39 tầng, Phoenix 31 tầng, 2 tầng hầm',
			'hh_p_units'        => '454 căn (446 căn hộ ở và 8 căn hộ kết hợp kinh doanh)',
			'hh_p_unit_area'    => 'Khoảng 56 – 390,5 m²',
			'hh_p_price_m2'     => 'Khoảng 94 – 130 triệu/m² (tham khảo, tùy tầng và hướng view)',
			'hh_p_price_from'   => 5950,
			'hh_p_legal'        => 'Sở Xây dựng Đà Nẵng xác nhận nhà ở hình thành trong tương lai đủ điều kiện kinh doanh (03/03/2026); chủ đầu tư phải giải chấp trước khi ký hợp đồng mua bán',
			'hh_p_ownership'    => 'Sở hữu lâu dài (người Việt Nam); thuộc danh sách dự án được bán cho người nước ngoài',
			'hh_p_start'        => 'Khởi công 14/9/2024',
			'hh_p_handover'     => 'Dự kiến khoảng giữa năm 2027',
			'hh_p_highlights'   => "Mặt tiền đường Bạch Đằng ven sông Hàn, đối diện công viên APEC, cách cầu Rồng chưa đến 100 m\nTháp đôi Dragon 39 tầng và Phoenix 31 tầng – điểm nhấn kiến trúc bờ Tây sông Hàn\nQuản lý vận hành theo tiêu chuẩn Nhật Bản\nĐã đủ điều kiện kinh doanh, được bán cho người nước ngoài",
			'hh_p_design_desc'  => 'Tòa Phoenix (31 tầng) gồm khoảng 197 căn hộ và 2 penthouse; tòa Dragon (39 tầng) gồm khoảng 249 căn hộ và các căn duplex trên tầng 38 – 39. Ngoài ra có 8 căn hộ kết hợp kinh doanh (tổng khoảng 751,58 m² sàn) và khối trung tâm thương mại. Tổng diện tích sàn căn hộ ở khoảng 29.157 m².',
			'hh_p_unit_types'   => "Căn 2PN (view sông Hàn, cầu Rồng) | Khoảng 61 – 68 m² | 2 | Khoảng 5,95 – 6,7 tỷ\nCăn 2PN diện tích lớn | Khoảng 70 – 229 m² | 2 | Liên hệ\nCăn 3PN | Khoảng 167 m² | 3 | Liên hệ",
			'hh_p_shop_desc'    => '8 căn hộ kết hợp kinh doanh ở khối đế, tổng diện tích sàn khoảng 751,58 m², hướng ra các trục Bạch Đằng – Bình Minh 4 – Trần Văn Trứ; giá bán liên hệ.',
			'hh_p_penthouse_desc'  => '2 căn penthouse trên tầng 31 tòa Phoenix, tầm nhìn trực diện sông Hàn và công viên APEC; giá bán liên hệ.',
			'hh_p_duplex_desc'     => 'Các căn duplex thông tầng ở tầng 38 – 39 tòa Dragon (3 căn/tầng), diện tích khoảng 248 – 390,5 m², là nhóm căn lớn nhất dự án; giá bán liên hệ.',
			'hh_p_duplex_table'    => 'Duplex tầng 38 – 39 tòa Dragon | Khoảng 248,5 – 390,5 m² | 3 | Liên hệ',
			'hh_p_location_desc'   => 'Danang Landmark nằm trên đoạn Bạch Đằng nối dài giữa cầu Rồng và cầu Trần Thị Lý, có ba mặt tiền Bạch Đằng – Bình Minh 4 – Trần Văn Trứ, đối diện công viên APEC và quảng trường pháo hoa ven sông Hàn.',
			'hh_p_connections'     => "1 phút | Công viên APEC, sông Hàn\n2 phút | Cầu Rồng\n3 phút | Cầu Trần Thị Lý\n7 phút | Bãi biển Mỹ Khê\n10 phút | Sân bay quốc tế Đà Nẵng",
			'hh_p_amenities_in'    => "Trung tâm thương mại khối đế\nHồ bơi vô cực\nSky bar & lounge, nhà hàng\nGym & Spa, xông hơi Sauna, massage\nPhòng tập golf, đường chạy bộ, đài ngắm cảnh\nNhà trẻ, phòng sinh hoạt cộng đồng\nBãi đỗ xe thông minh",
			'hh_p_amenities_out'   => "Công viên APEC, cầu Rồng, cầu Trần Thị Lý\nKhu vực bắn pháo hoa quốc tế bên sông Hàn\nChợ Hàn, trung tâm hành chính Hải Châu\nBãi biển Mỹ Khê",
			'hh_p_progress'        => "09/2022 | Được cấp chủ trương đầu tư\n14/09/2024 | Khởi công xây dựng\n23/02/2026 | Hoàn thành nghĩa vụ tài chính về đất\n03/03/2026 | Sở Xây dựng xác nhận đủ điều kiện kinh doanh 454 căn\n2027 | Dự kiến bàn giao",
			'hh_p_policy'          => 'Đặt cọc không quá 5% giá bán; thanh toán lần đầu không quá 30% giá trị hợp đồng (gồm tiền cọc), tổng thanh toán trước bàn giao không quá 70% theo Luật Kinh doanh bất động sản 2023.',
		),
		'content' => '<p><strong>Danang Landmark</strong> (Đà Nẵng Landmark Tower) là khu phức hợp trung tâm thương mại – căn hộ trên đường Bạch Đằng nối dài, cạnh công viên APEC và cách cầu Rồng chưa đến 100 m. Dự án do Công ty CP Cosmos Housing làm chủ đầu tư, DIN Capital hợp tác đầu tư, DINCO thi công. Tổng vốn khoảng 1.600 tỷ đồng trên khu đất khoảng 3.765 m².</p>
<h2>Quy mô tháp đôi Dragon – Phoenix</h2>
<p>Dự án gồm hai tòa tháp: Dragon cao 39 tầng và Phoenix cao 31 tầng, chung 2 tầng hầm, tổng cộng 454 căn. Trong đó có 446 căn hộ ở và 8 căn hộ kết hợp kinh doanh ở khối đế.</p>
<ul>
<li>Căn hộ 2 phòng ngủ từ khoảng 56 m², căn 61 – 68 m² được chào bán khoảng 5,95 – 6,7 tỷ (tham khảo).</li>
<li>Căn 3 phòng ngủ diện tích lớn, 2 penthouse ở tầng 31 tòa Phoenix.</li>
<li>Duplex ở tầng 38 – 39 tòa Dragon, rộng tới khoảng 390 m².</li>
</ul>
<h2>Pháp lý và tiến độ</h2>
<p>Ngày 03/3/2026, Sở Xây dựng Đà Nẵng xác nhận nhà ở hình thành trong tương lai tại Danang Landmark đủ điều kiện đưa vào kinh doanh. Dự án được bán cho người nước ngoài. Căn hộ sở hữu lâu dài với người Việt Nam. Dự án khởi công tháng 9/2024 và dự kiến bàn giao năm 2027. Giá dự kiến khoảng 94 – 130 triệu/m², tùy tầng và hướng view.</p>
<h2>Tiện ích chuẩn Nhật Bản</h2>
<p>Bên trong có trung tâm thương mại, hồ bơi vô cực, sky bar, gym & spa, sauna, phòng tập golf, nhà trẻ và bãi đỗ xe thông minh. Tòa nhà được quản lý vận hành theo tiêu chuẩn Nhật Bản. Từ dự án ra sông Hàn, cầu Rồng và khu bắn pháo hoa chỉ mất vài phút.</p>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận bảng giá, chính sách thanh toán và danh sách căn đẹp mới nhất của Danang Landmark.</p>',
		'sources' => array(
			'https://baodautu.vn/danang-landmark-du-dieu-kien-mo-ban-bo-sung-454-can-ho-tai-thi-truong-da-nang-d538777.html',
			'https://tuoitre.vn/nld/da-nang-hai-toa-thap-ben-song-han-duoc-mo-ban-hon-450-can-ho-196260304164928532.htm',
			'https://baodanang.vn/khoi-cong-du-an-da-nang-landmark-tower-3186063.html',
			'https://baodautu.vn/da-nang-cong-bo-hai-du-an-bat-dong-san-tiep-theo-duoc-ban-cho-nguoi-nuoc-ngoai-d572248.html',
			'https://dinco.com.vn/ban-tin-cong-trinh/du-an-khu-phuc-hop-tttm-can-ho-diem-nhan-da-nang-danang-landmark-tower-chinh-thuc-khoi-cong.html?lang=vn',
			'https://phungbds.com/bat-dong-san/danang-landmark-tower/',
		),
	);
	return $projects;
}
