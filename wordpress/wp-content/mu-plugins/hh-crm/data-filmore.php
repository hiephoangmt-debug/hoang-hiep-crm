<?php
/**
 * The Filmore Đà Nẵng (Bạch Đằng – Trần Văn Trứ – Bình Minh 5, Hải Châu): tòa căn hộ 25 tầng, 206 căn, đã hoàn thiện 2025.
 * Tổng hợp từ trang chủ đầu tư, CafeLand và trang phân phối (10/2026). Giá là mức chào bán tham khảo.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_project_dataset', 'hh_dataset_filmore', 20 );
function hh_dataset_filmore( $projects ) {
	$projects[] = array(
		'slug'    => 'the-filmore-da-nang',
		'title'   => 'The Filmore Đà Nẵng',
		'type'    => 'can-ho-so-huu-lau-dai',
		'area'    => 'hai-chau',
		'hot'     => true,
		'excerpt' => 'Tòa căn hộ hạng sang 25 tầng bên sông Hàn tại Bạch Đằng – Trần Văn Trứ – Bình Minh 5 (Hải Châu, Đà Nẵng): 206 căn sở hữu lâu dài, chỉ 9 căn mỗi tầng, đã hoàn thiện và sẵn sàng bàn giao.',
		'meta'    => array(
			'hh_p_status'       => 'dang-ban-giao',
			'hh_p_developer'    => 'Công ty CP Phát triển Bất động sản Filmore (Filmore Real Estate Development)',
			'hh_p_builder'      => 'Tập đoàn Xây dựng Delta',
			'hh_p_manager'      => 'CBRE Việt Nam',
			'hh_p_type'         => 'Căn hộ hạng sang ven sông Hàn, penthouse, căn loft thông tầng',
			'hh_p_address'      => 'Đường Bạch Đằng – Trần Văn Trứ – Bình Minh 5, phường Bình Thuận (cũ), Hải Châu, Đà Nẵng',
			'hh_p_scale'        => 'Khoảng 1.504 m² đất, tổng sàn xây dựng khoảng 22.600 m²',
			'hh_p_density'      => 'Khoảng 55 – 56%',
			'hh_p_blocks'       => '1 tòa',
			'hh_p_floors'       => '25 tầng nổi, 3 tầng hầm',
			'hh_p_units'        => '206 căn hộ (9 căn/tầng điển hình)',
			'hh_p_unit_area'    => '48 – 125 m² (penthouse khoảng 206 m²)',
			'hh_p_price_m2'     => 'Khoảng 130 – 150 triệu/m² (tham khảo)',
			'hh_p_price_from'   => 5500,
			'hh_p_ownership'    => 'Sở hữu lâu dài (người Việt Nam)',
			'hh_p_handover'     => 'Đã hoàn thiện 2025, bàn giao ngay',
			'hh_p_handover_std' => 'Hoàn thiện nội thất cao cấp',
			'hh_p_highlights'   => "Mặt tiền đường Bạch Đằng, view trực diện sông Hàn và cầu Rồng\nChỉ 206 căn, 9 căn mỗi tầng – mật độ cư dân thấp\nTổng thầu Delta, quản lý vận hành CBRE\nĐã hoàn thiện, nhận nhà ở ngay, sổ hồng sở hữu lâu dài",
			'hh_p_design_desc'  => 'Tầng 3 – 24 là tầng căn hộ điển hình, mỗi tầng 9 căn. Cơ cấu: 75 căn 1PN (48,09 – 49,98 m²), 106 căn 2PN (71,18 – 80,54 m²), 12 căn Dual Key (70,27 m²), 9 căn Sky Terrace có sân vườn (48,09 – 80,54 m²), 4 căn Loft 3PN (122,6 m²) và căn penthouse trên tầng cao. Khoảng 300 m² sàn thương mại dịch vụ.',
			'hh_p_unit_types'   => "Căn 1PN (75 căn) | 48,09 – 49,98 m² | 1 | Khoảng 5,5 – 6 tỷ\nCăn 2PN (106 căn) | 71,18 – 80,54 m² | 2 | Khoảng 8,2 – 9,3 tỷ\nDual Key (12 căn) | 70,27 m² | 2 | Liên hệ\nSky Terrace – có sân vườn (9 căn) | 48,09 – 80,54 m² | 1 – 2 | Liên hệ",
			'hh_p_penthouse_desc'  => 'Penthouse trên tầng cao nhất, diện tích khoảng 206 m², tầm nhìn toàn cảnh sông Hàn, cầu Rồng và biển Mỹ Khê; bán trực tiếp từ chủ đầu tư, sẵn sàng bàn giao.',
			'hh_p_penthouse_table' => 'Penthouse | Khoảng 206 m² | – | Từ khoảng 44,9 tỷ',
			'hh_p_duplex_desc'     => '4 căn Loft 3 phòng ngủ thiết kế thông tầng, diện tích 122,6 m², phòng khách trần cao.',
			'hh_p_duplex_table'    => 'Loft 3PN thông tầng (4 căn) | 122,6 m² | 3 | Khoảng 14,2 – 14,5 tỷ',
			'hh_p_location_desc'   => 'The Filmore nằm trên đường Bạch Đằng – trục ven sông Hàn trung tâm Hải Châu, giáp Trần Văn Trứ và Bình Minh 5, gần cầu Rồng và cầu Trần Thị Lý. Từ dự án đi bộ ra công viên APEC, chợ Hàn và phố đi bộ ven sông.',
			'hh_p_connections'     => "1 phút | Sông Hàn, đường Bạch Đằng\n3 phút | Cầu Rồng, công viên APEC\n5 phút | Chợ Hàn, trung tâm hành chính\n7 phút | Bãi biển Mỹ Khê\n10 phút | Sân bay quốc tế Đà Nẵng",
			'hh_p_amenities_in'    => "Sảnh đón tiếp sang trọng\nHồ bơi người lớn và trẻ em, hồ bơi thác nước\nPhòng gym\nPhòng sinh hoạt cộng đồng, thư viện\nPhòng thưởng thức rượu vang và xì gà\nKhu vui chơi trẻ em\nHơn 25 dịch vụ dành cho cư dân, quản lý bởi CBRE",
			'hh_p_amenities_out'   => "Công viên APEC, cầu Rồng\nChợ Hàn, phố đi bộ Bạch Đằng\nBệnh viện, trường học trung tâm Hải Châu\nBãi biển Mỹ Khê",
			'hh_p_progress'        => "2025 | Hoàn thiện tòa nhà\n2026 | Bàn giao, nhận nhà ở ngay",
		),
		'content' => '<p><strong>The Filmore Đà Nẵng</strong> là tòa căn hộ hạng sang trên đường Bạch Đằng (Hải Châu), mặt tiền sông Hàn, do Công ty CP Phát triển Bất động sản Filmore làm chủ đầu tư, Delta thi công và CBRE quản lý vận hành. Tòa nhà cao 25 tầng, 3 tầng hầm với 206 căn hộ sở hữu lâu dài – mỗi tầng chỉ 9 căn.</p>
<h2>Các loại căn hộ The Filmore</h2>
<ul>
<li>75 căn 1 phòng ngủ, 48 – 50 m², giá tham khảo khoảng 5,5 – 6 tỷ.</li>
<li>106 căn 2 phòng ngủ, 71 – 81 m², khoảng 8,2 – 9,3 tỷ.</li>
<li>12 căn Dual Key 70,27 m² – một căn chia hai không gian độc lập, thuận tiện cho thuê.</li>
<li>9 căn Sky Terrace có sân vườn, 4 căn Loft 3 phòng ngủ thông tầng 122,6 m² và căn penthouse khoảng 206 m².</li>
</ul>
<h2>Vì sao The Filmore được quan tâm</h2>
<p>Quỹ đất ven sông Hàn trên đường Bạch Đằng gần như không còn cho dự án căn hộ mới. The Filmore đã hoàn thiện năm 2025, người mua nhận nhà ngay, không phải chờ xây dựng. Mức giá khoảng 130 – 150 triệu/m² thuộc nhóm cao nhất Đà Nẵng, phù hợp khách mua để ở lâu dài hoặc giữ tài sản ở vị trí trung tâm.</p>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận danh sách căn còn trống, bảng giá và chính sách mới nhất.</p>',
		'sources' => array(
			'https://www.filmoredanang.vn/',
			'https://cafeland.vn/du-an/can-ho-the-filmore-da-nang-3101.html',
			'https://hoanggiaminh.com/tin-tuc/chi-tiet-mat-bang-the-filmore-danang-co-gi.html',
			'https://smartland.vn/gia-ban-the-filmore-da-nang/',
			'https://batdongsan.com.vn/ban-can-ho-chung-cu-the-filmore-da-nang-phuong-hoa-cuong-tp-da-nang/duy-nhat-penthouse-mua-truc-tiep-cdt-206m2-gia-tu-45-ty-san-sang-ban-giao-pr45059382',
		),
	);
	return $projects;
}
