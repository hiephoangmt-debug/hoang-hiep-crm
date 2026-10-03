<?php
/**
 * M Riverside Đà Nẵng (số 6 đường 2/9 – Bình Hiên – Đào Tấn, Hải Châu): tòa căn hộ dịch vụ thương mại 25 tầng, 312 căn, mô hình Work – Live – Resort.
 * Tổng hợp từ VnExpress, Dân trí, CafeLand và trang phân phối (10/2026). Giá là mức chào bán tham khảo; pháp lý sở hữu cần đối chiếu hợp đồng chủ đầu tư.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_project_dataset', 'hh_dataset_m_riverside', 20 );
function hh_dataset_m_riverside( $projects ) {
	$projects[] = array(
		'slug'    => 'm-riverside-da-nang',
		'title'   => 'M Riverside Đà Nẵng',
		'type'    => 'can-ho-so-huu-lau-dai',
		'area'    => 'hai-chau',
		'hot'     => true,
		'excerpt' => 'Tòa căn hộ 25 tầng ven sông Hàn tại số 6 đường 2/9 (Hải Châu, Đà Nẵng), đối diện công viên APEC: 312 căn studio – 2PN theo mô hình Work – Live – Resort, giá từ khoảng 3,5 tỷ.',
		'meta'    => array(
			'hh_p_status'       => 'dang-mo-ban',
			'hh_p_developer'    => 'Công ty TNHH Kyoritsu Maintenance Việt Nam, hợp tác cùng CTCP Sao Mai Việt (HNX: UNI)',
			'hh_p_builder'      => 'Central (tổng thầu)',
			'hh_p_manager'      => 'Kyoritsu Maintenance Việt Nam (vận hành); Artelia – tư vấn quản lý dự án, giám sát',
			'hh_p_type'         => 'Căn hộ dịch vụ thương mại ven sông Hàn (studio, 1PN, 2PN), mô hình Work – Live – Resort',
			'hh_p_address'      => 'Số 6 đường 2/9 (ba mặt tiền 2/9 – Bình Hiên – Đào Tấn), phường Hải Châu, Đà Nẵng',
			'hh_p_scale'        => 'Khoảng 1.853 m² đất',
			'hh_p_blocks'       => '1 tòa',
			'hh_p_floors'       => '25 tầng nổi, 3 tầng hầm',
			'hh_p_units'        => '312 căn',
			'hh_p_unit_area'    => 'Khoảng 31,9 – 99,3 m²',
			'hh_p_price_m2'     => 'Khoảng 104 – 136 triệu/m² tùy hướng view (tham khảo)',
			'hh_p_price_from'   => 3500,
			'hh_p_legal'        => 'Giấy phép môi trường (Sở TN&MT Đà Nẵng, 13/11/2023); Giấy phép xây dựng số 18/GPXD (Sở Xây dựng Đà Nẵng, 14/8/2024)',
			'hh_p_ownership'    => 'Chủ đầu tư công bố đất sử dụng lâu dài, sở hữu căn hộ theo quy định loại hình căn hộ dịch vụ thương mại; cấp giấy chứng nhận khi đủ điều kiện (cần đối chiếu hợp đồng)',
			'hh_p_highlights'   => "Ba mặt tiền 2/9 – Bình Hiên – Đào Tấn, đối diện công viên APEC, cách cầu Rồng khoảng 300 m\nView trực diện sông Hàn, gần trung tâm tài chính quốc tế Đà Nẵng\nChủ đầu tư Nhật Bản Kyoritsu Maintenance – kinh nghiệm vận hành khách sạn, lưu trú\nMô hình Work – Live – Resort: co-working, lounge thương gia, hồ bơi vô cực tầng thượng\nTổng thầu Central, tư vấn quản lý dự án Artelia (Pháp)",
			'hh_p_design_desc'  => 'Tòa tháp 25 tầng nổi, 3 tầng hầm với 312 căn: 89 căn studio (31,9 – 45,7 m²), 129 căn 1PN (35,5 – 69,6 m²), 89 căn 2PN (76,8 – 99,3 m²) và 5 căn đặc biệt. Không gian làm việc, sinh sống và nghỉ dưỡng tích hợp trong cùng một tòa nhà.',
			'hh_p_unit_types'   => "Studio (89 căn) | 31,9 – 45,7 m² | – | Khoảng 117 triệu/m² (tham khảo)\nCăn 1PN (129 căn) | 35,5 – 69,6 m² | 1 | Khoảng 126 triệu/m² (tham khảo)\nCăn 2PN (89 căn) | 76,8 – 99,3 m² | 2 | Khoảng 128 triệu/m² (tham khảo)\nCăn đặc biệt (5 căn) | – | – | Liên hệ",
			'hh_p_location_desc' => 'M Riverside nằm tại số 6 đường 2/9, giao điểm ba tuyến 2/9 – Bình Hiên – Đào Tấn, liền kề sông Hàn và đối diện công viên APEC, cách cầu Rồng khoảng 300 m. Từ dự án di chuyển 5 – 10 phút tới khu vực trung tâm tài chính quốc tế Đà Nẵng.',
			'hh_p_connections'  => "1 phút | Công viên APEC, sông Hàn\n2 phút | Cầu Rồng\n5 – 10 phút | Trung tâm tài chính quốc tế Đà Nẵng",
			'hh_p_amenities_in' => "Hồ bơi vô cực tầng thượng hướng sông Hàn\nRooftop lounge, coffee lounge\nKhu lounge thương gia, không gian co-working\nPhòng gym, sauna, khu yoga\nNhà hàng",
			'hh_p_amenities_out' => "Công viên APEC, cầu Rồng\nSông Hàn và tuyến ven sông 2/9\nTrung tâm tài chính quốc tế Đà Nẵng",
			'hh_p_progress'     => "13/11/2023 | Cấp giấy phép môi trường\n14/8/2024 | Cấp giấy phép xây dựng số 18/GPXD\n07/2026 | Khai trương nhà mẫu; thi công hoàn thiện phần hầm\n21/9/2026 | Ra quân tổng đại lý miền Bắc, triển khai bán hàng\nQuý IV/2026 | Dự kiến thi công phần thân",
			'hh_p_policy'       => 'Chiết khấu tới khoảng 26%, miễn phí quản lý 2 năm; thanh toán linh hoạt tới 15 đợt theo tiến độ, thanh toán sớm hưởng chiết khấu cao, ngân hàng hỗ trợ vay tới 70% giá trị căn (theo chính sách từng thời điểm).',
			'hh_p_rental'       => 'Thiết kế phục vụ cả nhu cầu ở lâu dài và cho thuê ngắn hạn; chủ đầu tư Kyoritsu Maintenance có kinh nghiệm vận hành lưu trú, hướng tới khách chuyên gia, doanh nhân và cư dân quốc tế tại Đà Nẵng.',
		),
		'content' => '<p><strong>M Riverside Đà Nẵng</strong> (M Riverside Danang) là tòa căn hộ dịch vụ thương mại 25 tầng, 3 tầng hầm tại số 6 đường 2/9, phường Hải Châu – vị trí ba mặt tiền 2/9, Bình Hiên, Đào Tấn, liền kề sông Hàn và đối diện công viên APEC. Dự án do Kyoritsu Maintenance Việt Nam (Nhật Bản) phát triển cùng Sao Mai Việt (HNX: UNI), tổng thầu Central, tư vấn quản lý dự án Artelia.</p>
<h2>Quy mô và các loại căn hộ</h2>
<p>Trên khu đất khoảng 1.853 m², M Riverside có 312 căn hộ:</p>
<ul>
<li>89 căn studio 31,9 – 45,7 m², khoảng 117 triệu/m² (tham khảo).</li>
<li>129 căn 1 phòng ngủ 35,5 – 69,6 m², khoảng 126 triệu/m².</li>
<li>89 căn 2 phòng ngủ 76,8 – 99,3 m², khoảng 128 triệu/m².</li>
<li>5 căn đặc biệt – liên hệ để nhận thông tin.</li>
</ul>
<p>Giá chào bán tham khảo từ khoảng 3,5 tỷ/căn, dao động khoảng 104 – 136 triệu/m² tùy hướng nhìn thành phố, sông Hàn hay trực diện sông – biển.</p>
<h2>Mô hình Work – Live – Resort</h2>
<p>Tòa nhà tích hợp không gian làm việc (co-working, lounge thương gia), căn hộ để ở và chuỗi tiện ích nghỉ dưỡng: hồ bơi vô cực tầng thượng nhìn sông Hàn, rooftop lounge, gym, sauna, yoga, nhà hàng. Sản phẩm hướng tới chuyên gia, doanh nhân, cư dân quốc tế và nhà đầu tư cho thuê.</p>
<h2>Pháp lý và tiến độ</h2>
<p>Dự án đã có giấy phép môi trường (11/2023) và giấy phép xây dựng số 18/GPXD (8/2024). Chủ đầu tư công bố đất sử dụng lâu dài, căn hộ được cấp giấy chứng nhận khi đủ điều kiện. Tháng 7/2026 khai trương nhà mẫu, phần hầm đang thi công hoàn thiện; tháng 9/2026 dự án chính thức triển khai bán hàng với chiết khấu tới khoảng 26%, thanh toán tới 15 đợt, hỗ trợ vay tới 70%.</p>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận bảng giá chi tiết, căn đẹp theo view và chính sách mới nhất của M Riverside Đà Nẵng.</p>',
		'sources' => array(
			'https://vnexpress.net/m-riverside-da-nang-khai-thac-loi-the-ba-mat-tien-trung-tam-thanh-pho-5088719.html',
			'https://cafeland.vn/du-an/m-riverside-danang-du-an-can-ho-tai-da-nang-5737.html',
			'https://cafeland.vn/tin-tuc/m-riverside-danang-chinh-thuc-ra-quan-tai-mien-bac-155225.html',
			'https://dantri.com.vn/bat-dong-san/m-riverside-danang-tien-phong-ung-dung-mo-hinh-urban-resort-20260622090058293.htm',
			'https://thanhnien.vn/m-riverside-danang-khai-truong-nha-mau-185260702165436263.htm',
			'https://mriversides.vn/',
		),
	);
	return $projects;
}
