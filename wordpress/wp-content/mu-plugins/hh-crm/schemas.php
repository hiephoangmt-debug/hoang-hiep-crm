<?php
/**
 * Field schemas for Dự án (projects) and Nhà đất (listings).
 * Thêm / bớt ô nhập liệu chỉ cần sửa mảng trong file này.
 */

defined( 'ABSPATH' ) || exit;

const HH_DIRECTIONS = array(
	''           => '— Chọn hướng —',
	'dong'       => 'Đông',
	'tay'        => 'Tây',
	'nam'        => 'Nam',
	'bac'        => 'Bắc',
	'dong-nam'   => 'Đông Nam',
	'dong-bac'   => 'Đông Bắc',
	'tay-nam'    => 'Tây Nam',
	'tay-bac'    => 'Tây Bắc',
);

function hh_project_schema() {
	return array(
		'tong-quan' => array(
			'title'  => 'Tổng quan',
			'intro'  => 'Thông tin chính hiển thị ở đầu trang dự án. Ô nào để trống sẽ tự ẩn.',
			'fields' => array(
				'hh_p_status'       => array( 'type' => 'select', 'label' => 'Tình trạng', 'half' => true, 'options' => array(
					'sap-mo-ban'    => 'Sắp mở bán',
					'dang-mo-ban'   => 'Đang mở bán',
					'dang-ban-giao' => 'Đang bàn giao',
					'da-ban-giao'   => 'Đã bàn giao',
				) ),
				'hh_p_featured'     => array( 'type' => 'checkbox', 'label' => 'Dự án nổi bật (hiện ở banner & trang chủ)', 'half' => true ),
				'hh_p_name'         => array( 'type' => 'text', 'label' => 'Tên thương mại', 'placeholder' => 'VD: Aurelia Riverside', 'half' => true ),
				'hh_p_type'         => array( 'type' => 'text', 'label' => 'Loại hình', 'placeholder' => 'VD: Căn hộ cao cấp, nhà phố, shophouse', 'half' => true ),
				'hh_p_developer'    => array( 'type' => 'text', 'label' => 'Chủ đầu tư', 'placeholder' => 'VD: Công ty CP Địa ốc ABC', 'half' => true ),
				'hh_p_builder'      => array( 'type' => 'text', 'label' => 'Nhà thầu thi công', 'placeholder' => 'VD: Hòa Bình, Delta…', 'half' => true ),
				'hh_p_manager'      => array( 'type' => 'text', 'label' => 'Đơn vị quản lý vận hành', 'half' => true ),
				'hh_p_designer'     => array( 'type' => 'text', 'label' => 'Đơn vị thiết kế', 'half' => true ),
				'hh_p_address'      => array( 'type' => 'text', 'label' => 'Địa chỉ dự án', 'placeholder' => 'VD: Đường Trần Hưng Đạo, Sơn Trà, Đà Nẵng' ),
				'hh_p_scale'        => array( 'type' => 'text', 'label' => 'Quy mô / Tổng diện tích', 'placeholder' => 'VD: 5,2 ha', 'half' => true ),
				'hh_p_density'      => array( 'type' => 'text', 'label' => 'Mật độ xây dựng', 'placeholder' => 'VD: 28%', 'half' => true ),
				'hh_p_blocks'       => array( 'type' => 'text', 'label' => 'Số tòa / block', 'placeholder' => 'VD: 4 tòa', 'half' => true ),
				'hh_p_floors'       => array( 'type' => 'text', 'label' => 'Số tầng', 'placeholder' => 'VD: 25 tầng + 2 hầm', 'half' => true ),
				'hh_p_units'        => array( 'type' => 'text', 'label' => 'Tổng số sản phẩm', 'placeholder' => 'VD: 1.200 căn', 'half' => true ),
				'hh_p_unit_area'    => array( 'type' => 'text', 'label' => 'Diện tích sản phẩm', 'placeholder' => 'VD: 50 – 120 m²', 'half' => true ),
				'hh_p_price_from'   => array( 'type' => 'number', 'label' => 'Giá từ (triệu đồng)', 'placeholder' => 'VD: 2500 (= 2,5 tỷ)', 'half' => true, 'help' => 'Nhập số, đơn vị triệu. Để trống sẽ hiện "Đang cập nhật".' ),
				'hh_p_price_m2'     => array( 'type' => 'text', 'label' => 'Đơn giá / m²', 'placeholder' => 'VD: 55 – 65 triệu/m²', 'half' => true ),
				'hh_p_legal'        => array( 'type' => 'text', 'label' => 'Pháp lý', 'placeholder' => 'VD: Đã có giấy phép xây dựng, sổ hồng riêng từng căn', 'half' => true ),
				'hh_p_ownership'    => array( 'type' => 'text', 'label' => 'Hình thức sở hữu', 'placeholder' => 'VD: Sở hữu lâu dài', 'half' => true ),
				'hh_p_start'        => array( 'type' => 'text', 'label' => 'Khởi công', 'placeholder' => 'VD: Quý 2/2025', 'half' => true ),
				'hh_p_handover'     => array( 'type' => 'text', 'label' => 'Bàn giao dự kiến', 'placeholder' => 'VD: Quý 4/2027', 'half' => true ),
				'hh_p_handover_std' => array( 'type' => 'text', 'label' => 'Tiêu chuẩn bàn giao', 'placeholder' => 'VD: Hoàn thiện cơ bản, thiết bị bếp Bosch' ),
				'hh_p_highlights'   => array( 'type' => 'lines', 'label' => 'Điểm nổi bật', 'placeholder' => "Mặt tiền sông Hàn, view cầu Rồng và pháo hoa\nThanh toán 30% nhận nhà\nNgân hàng hỗ trợ vay 70%, ân hạn gốc lãi 24 tháng" ),
			),
		),
		'vi-tri'    => array(
			'title'  => 'Vị trí',
			'fields' => array(
				'hh_p_location_desc' => array( 'type' => 'textarea', 'label' => 'Mô tả vị trí', 'placeholder' => 'VD: Dự án nằm ven sông Hàn, ngay trung tâm quận Sơn Trà …' ),
				'hh_p_connections'   => array( 'type' => 'table', 'label' => 'Kết nối vùng', 'columns' => array( 'Thời gian / khoảng cách', 'Địa điểm' ), 'placeholder' => "3 phút | Cầu Rồng\n5 phút | Biển Mỹ Khê\n10 phút | Sân bay quốc tế Đà Nẵng\n30 phút | Phố cổ Hội An" ),
				'hh_p_map_address'   => array( 'type' => 'text', 'label' => 'Địa chỉ trên bản đồ Google', 'placeholder' => 'Để trống sẽ dùng địa chỉ dự án', 'half' => true ),
				'hh_p_location_img'  => array( 'type' => 'image', 'label' => 'Ảnh sơ đồ vị trí', 'half' => true ),
			),
		),
		'tien-ich'  => array(
			'title'  => 'Tiện ích',
			'fields' => array(
				'hh_p_amenities_in'  => array( 'type' => 'lines', 'label' => 'Tiện ích nội khu', 'placeholder' => "Hồ bơi tràn bờ 50m\nPhòng gym, yoga\nVườn BBQ\nKhu vui chơi trẻ em\nAn ninh 24/7, thẻ từ thang máy" ),
				'hh_p_amenities_out' => array( 'type' => 'lines', 'label' => 'Tiện ích ngoại khu', 'placeholder' => "Trường quốc tế – 500m\nBệnh viện Vinmec Đà Nẵng – 2km\nChợ Hàn – 1,5km" ),
				'hh_p_amenities_img' => array( 'type' => 'gallery', 'label' => 'Ảnh tiện ích' ),
			),
		),
		'mat-bang'  => array(
			'title'  => 'Mặt bằng & sản phẩm',
			'fields' => array(
				'hh_p_masterplan_img' => array( 'type' => 'image', 'label' => 'Ảnh mặt bằng tổng thể', 'half' => true ),
				'hh_p_design_desc'    => array( 'type' => 'textarea', 'label' => 'Mô tả thiết kế', 'placeholder' => 'VD: Mỗi sàn 10 căn, 4 thang máy, thiết kế đón gió tự nhiên …' ),
				'hh_p_unit_types'     => array( 'type' => 'table', 'label' => 'Các loại sản phẩm', 'columns' => array( 'Loại sản phẩm', 'Diện tích', 'Phòng ngủ', 'Giá tham khảo' ), 'placeholder' => "Studio | 35 – 40 m² | 1 | 1,8 – 2 tỷ\nCăn 2PN | 65 – 75 m² | 2 | 3,2 – 3,8 tỷ\nCăn 3PN | 95 – 110 m² | 3 | 4,8 – 5,6 tỷ" ),
				'hh_p_floorplans'     => array( 'type' => 'gallery', 'label' => 'Ảnh mặt bằng căn hộ / tầng' ),
			),
		),
		'gia-ban'   => array(
			'title'  => 'Giá & thanh toán',
			'fields' => array(
				'hh_p_price_table'   => array( 'type' => 'table', 'label' => 'Bảng giá', 'columns' => array( 'Sản phẩm', 'Diện tích', 'Giá bán', 'Ghi chú' ), 'placeholder' => "A-12.05 – 2PN | 68 m² | 3,35 tỷ | View sông\nB-08.10 – 3PN | 98 m² | 5,1 tỷ | Căn góc" ),
				'hh_p_payment'       => array( 'type' => 'table', 'label' => 'Tiến độ thanh toán', 'columns' => array( 'Đợt', 'Thời điểm', 'Tỷ lệ' ), 'placeholder' => "Đợt 1 | Ký thỏa thuận đặt cọc | 10%\nĐợt 2 | Ký HĐMB (30 ngày) | 20%\nĐợt 3 | Nhận bàn giao | 65%\nĐợt 4 | Nhận sổ hồng | 5%" ),
				'hh_p_policy'        => array( 'type' => 'lines', 'label' => 'Chính sách bán hàng & ưu đãi', 'placeholder' => "Chiết khấu 3% khi thanh toán nhanh 50%\nTặng gói nội thất 100 triệu\nMiễn phí quản lý 2 năm" ),
				'hh_p_loan'          => array( 'type' => 'textarea', 'label' => 'Hỗ trợ vay ngân hàng', 'placeholder' => 'VD: Vietcombank, BIDV hỗ trợ vay 70%, ân hạn gốc lãi 18 tháng …' ),
				'hh_p_pricelist_url' => array( 'type' => 'url', 'label' => 'Link tải bảng giá / brochure (Google Drive, PDF…)', 'placeholder' => 'https://' ),
			),
		),
		'tien-do'   => array(
			'title'  => 'Tiến độ',
			'fields' => array(
				'hh_p_progress'         => array( 'type' => 'table', 'label' => 'Tiến độ xây dựng', 'columns' => array( 'Thời gian', 'Nội dung' ), 'placeholder' => "03/2025 | Khởi công\n12/2025 | Hoàn thành phần móng\n06/2026 | Cất nóc tòa A" ),
				'hh_p_progress_gallery' => array( 'type' => 'gallery', 'label' => 'Ảnh tiến độ thực tế' ),
			),
		),
		'thu-vien'  => array(
			'title'  => 'Hình ảnh & video',
			'intro'  => 'Ảnh đại diện (bên phải màn hình soạn thảo) dùng làm banner dự án.',
			'fields' => array(
				'hh_p_gallery' => array( 'type' => 'gallery', 'label' => 'Thư viện ảnh dự án' ),
				'hh_p_video'   => array( 'type' => 'url', 'label' => 'Video YouTube', 'placeholder' => 'https://www.youtube.com/watch?v=…' ),
			),
		),
		'hoi-dap'   => array(
			'title'  => 'Hỏi đáp',
			'fields' => array(
				'hh_p_faq' => array( 'type' => 'table', 'label' => 'Câu hỏi thường gặp', 'columns' => array( 'Câu hỏi', 'Trả lời' ), 'placeholder' => "Dự án có sổ hồng chưa? | Sổ hồng cấp sau khi nhận nhà khoảng 12 tháng.\nNgười nước ngoài có mua được không? | Được, theo hạn mức 30% số căn mỗi tòa." ),
			),
		),
	);
}

function hh_listing_schema() {
	return array(
		'co-ban'   => array(
			'title'  => 'Thông tin cơ bản',
			'intro'  => 'Nhập số vào các ô số (không cần đơn vị). Ô nào để trống sẽ tự ẩn.',
			'fields' => array(
				'hh_deal'       => array( 'type' => 'select', 'label' => 'Hình thức', 'half' => true, 'options' => array( 'ban' => 'Bán', 'thue' => 'Cho thuê' ) ),
				'hh_status'     => array( 'type' => 'select', 'label' => 'Tình trạng', 'half' => true, 'options' => array(
					'con-hang'     => 'Còn hàng',
					'dat-coc'      => 'Đã đặt cọc',
					'da-giao-dich' => 'Đã giao dịch',
				) ),
				'hh_price'      => array( 'type' => 'number', 'label' => 'Giá (triệu đồng) – cho thuê: triệu/tháng', 'placeholder' => 'VD: 3200 (= 3,2 tỷ) hoặc 12', 'half' => true, 'help' => 'Để trống sẽ hiện "Thỏa thuận".' ),
				'hh_negotiable' => array( 'type' => 'checkbox', 'label' => 'Giá còn thương lượng', 'half' => true ),
				'hh_address'    => array( 'type' => 'text', 'label' => 'Địa chỉ', 'placeholder' => 'VD: 123 Võ Nguyên Giáp, Ngũ Hành Sơn, Đà Nẵng' ),
				'hh_project'    => array( 'type' => 'post', 'label' => 'Thuộc dự án', 'post_type' => 'du-an', 'half' => true ),
				'hh_featured'   => array( 'type' => 'checkbox', 'label' => 'Tin nổi bật (hiện ở trang chủ)', 'half' => true ),
			),
		),
		'dac-diem'  => array(
			'title'  => 'Diện tích & kết cấu',
			'fields' => array(
				'hh_area'      => array( 'type' => 'number', 'label' => 'Diện tích đất / thông thủy (m²)', 'placeholder' => 'VD: 72', 'half' => true ),
				'hh_area_use'  => array( 'type' => 'number', 'label' => 'Diện tích sử dụng (m²)', 'placeholder' => 'VD: 180', 'half' => true ),
				'hh_width'     => array( 'type' => 'number', 'label' => 'Chiều ngang (m)', 'placeholder' => 'VD: 4,5', 'half' => true ),
				'hh_length'    => array( 'type' => 'number', 'label' => 'Chiều dài (m)', 'placeholder' => 'VD: 16', 'half' => true ),
				'hh_frontage'  => array( 'type' => 'number', 'label' => 'Mặt tiền đường (m)', 'half' => true ),
				'hh_road'      => array( 'type' => 'number', 'label' => 'Đường vào / hẻm rộng (m)', 'half' => true ),
				'hh_direction' => array( 'type' => 'select', 'label' => 'Hướng nhà / cửa chính', 'half' => true, 'options' => HH_DIRECTIONS ),
				'hh_balcony'   => array( 'type' => 'select', 'label' => 'Hướng ban công', 'half' => true, 'options' => HH_DIRECTIONS ),
				'hh_floors'    => array( 'type' => 'number', 'label' => 'Số tầng', 'half' => true ),
				'hh_floor_no'  => array( 'type' => 'text', 'label' => 'Tầng số (căn hộ)', 'placeholder' => 'VD: Tầng 12', 'half' => true ),
				'hh_bedrooms'  => array( 'type' => 'number', 'label' => 'Phòng ngủ', 'half' => true ),
				'hh_bathrooms' => array( 'type' => 'number', 'label' => 'Phòng vệ sinh', 'half' => true ),
				'hh_furniture' => array( 'type' => 'select', 'label' => 'Nội thất', 'half' => true, 'options' => array(
					''          => '— Chọn —',
					'khong'     => 'Nhà trống',
					'co-ban'    => 'Nội thất cơ bản',
					'day-du'    => 'Đầy đủ nội thất',
					'cao-cap'   => 'Nội thất cao cấp',
				) ),
				'hh_legal'     => array( 'type' => 'select', 'label' => 'Pháp lý', 'half' => true, 'options' => array(
					''          => '— Chọn —',
					'so-hong'   => 'Sổ hồng riêng',
					'so-do'     => 'Sổ đỏ',
					'hdmb'      => 'Hợp đồng mua bán',
					'cho-so'    => 'Đang chờ sổ',
					'khac'      => 'Khác',
				) ),
				'hh_year'      => array( 'type' => 'text', 'label' => 'Năm xây dựng / bàn giao', 'half' => true ),
			),
		),
		'thue'      => array(
			'title'  => 'Điều kiện thuê',
			'intro'  => 'Chỉ cần nhập khi hình thức là Cho thuê.',
			'fields' => array(
				'hh_deposit'     => array( 'type' => 'text', 'label' => 'Tiền cọc', 'placeholder' => 'VD: 2 tháng', 'half' => true ),
				'hh_min_term'    => array( 'type' => 'text', 'label' => 'Thời hạn thuê tối thiểu', 'placeholder' => 'VD: 6 tháng', 'half' => true ),
				'hh_service_fee' => array( 'type' => 'text', 'label' => 'Phí quản lý / dịch vụ', 'placeholder' => 'VD: 15.000đ/m²/tháng', 'half' => true ),
				'hh_available'   => array( 'type' => 'text', 'label' => 'Ngày dọn vào', 'placeholder' => 'VD: Ở ngay', 'half' => true ),
				'hh_rent_incl'   => array( 'type' => 'text', 'label' => 'Giá đã bao gồm', 'placeholder' => 'VD: Phí quản lý, internet, dọn phòng 1 lần/tuần' ),
			),
		),
		'noi-bat'   => array(
			'title'  => 'Đặc điểm & tiện ích',
			'fields' => array(
				'hh_features' => array( 'type' => 'lines', 'label' => 'Đặc điểm nổi bật', 'placeholder' => "Căn góc, 2 mặt thoáng\nView sông, đón gió mát\nNội thất mới 100%" ),
				'hh_nearby'   => array( 'type' => 'lines', 'label' => 'Tiện ích xung quanh', 'placeholder' => "Biển Mỹ Khê – 300m\nTrường tiểu học – 500m\nCông viên – 200m" ),
			),
		),
		'media'     => array(
			'title'  => 'Hình ảnh & video',
			'intro'  => 'Ảnh đại diện (bên phải màn hình soạn thảo) là ảnh chính của tin.',
			'fields' => array(
				'hh_gallery'     => array( 'type' => 'gallery', 'label' => 'Ảnh thực tế' ),
				'hh_video'       => array( 'type' => 'url', 'label' => 'Video YouTube', 'placeholder' => 'https://www.youtube.com/watch?v=…' ),
				'hh_map_address' => array( 'type' => 'text', 'label' => 'Địa chỉ trên bản đồ Google', 'placeholder' => 'Để trống sẽ dùng địa chỉ ở tab Thông tin cơ bản' ),
			),
		),
	);
}
