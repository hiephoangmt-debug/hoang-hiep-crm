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
				'hh_p_featured'     => array( 'type' => 'checkbox', 'label' => 'Dự án HOT (lên banner, trang chủ và mục "Dự án hot mới")', 'half' => true ),
				'hh_p_sold_out'     => array( 'type' => 'checkbox', 'label' => 'Chủ đầu tư đã bán hết (trang dự án chuyển sang mua bán, chuyển nhượng, cho thuê)', 'half' => true, 'help' => 'Dự án "Đã bàn giao" cũng tự hiện mục chuyển nhượng & cho thuê lên đầu trang.' ),
				'hh_p_parent'       => array( 'type' => 'post', 'label' => 'Thuộc tổ hợp / là phân khu của dự án', 'post_type' => 'du-an', 'half' => true, 'help' => 'VD: FPT Plaza 4 thuộc FPT City Đà Nẵng; The Sonata là phân khu của Sun Symphony Residence.' ),
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
				'hh_p_ownership'    => array( 'type' => 'text', 'label' => 'Hình thức sở hữu', 'placeholder' => 'VD: Sở hữu lâu dài / 50 năm (căn hộ dịch vụ)', 'half' => true ),
				'hh_p_start'        => array( 'type' => 'text', 'label' => 'Khởi công', 'placeholder' => 'VD: Quý 2/2025', 'half' => true ),
				'hh_p_handover'     => array( 'type' => 'text', 'label' => 'Bàn giao dự kiến', 'placeholder' => 'VD: Quý 4/2027', 'half' => true ),
				'hh_p_handover_std' => array( 'type' => 'text', 'label' => 'Tiêu chuẩn bàn giao', 'placeholder' => 'VD: Hoàn thiện cơ bản, thiết bị bếp Bosch' ),
				'hh_p_zones'        => array( 'type' => 'table', 'label' => 'Các phân khu (dự án có nhiều khu / nhiều loại sản phẩm)', 'columns' => array( 'Phân khu', 'Loại sản phẩm', 'Quy mô', 'Tình trạng' ), 'placeholder' => "Khu cao tầng (tòa S1–S3) | Căn hộ, shop khối đế | 1.313 căn hộ | Đang bàn giao\nKhu thấp tầng | Nhà phố, biệt thự | 180 nhà phố, 20 biệt thự | Đã bàn giao", 'help' => 'Dự án có cả căn hộ và nhà phố/biệt thự: chọn cả 2 loại ở ô "Loại dự án" bên phải (VD: Căn hộ sở hữu lâu dài + Nhà phố – Shophouse).' ),
				'hh_p_highlights'   => array( 'type' => 'lines', 'label' => 'Điểm nổi bật', 'placeholder' => "Mặt tiền sông Hàn, view cầu Rồng và pháo hoa\nThanh toán 30% nhận nhà\nNgân hàng hỗ trợ vay 70%, ân hạn gốc lãi 24 tháng" ),
			),
		),
		'vi-tri'    => array(
			'title'  => 'Vị trí & liên kết vùng',
			'fields' => array(
				'hh_p_location_desc' => array( 'type' => 'textarea', 'label' => 'Mô tả vị trí', 'placeholder' => 'VD: Dự án nằm ven sông Hàn, ngay trung tâm quận Sơn Trà …' ),
				'hh_p_connections'   => array( 'type' => 'table', 'label' => 'Liên kết vùng', 'help' => 'Để trống sẽ dùng thời gian di chuyển tham khảo theo khu vực của dự án.', 'columns' => array( 'Thời gian / khoảng cách', 'Địa điểm' ), 'placeholder' => "3 phút | Cầu Rồng\n5 phút | Biển Mỹ Khê\n10 phút | Sân bay quốc tế Đà Nẵng\n30 phút | Phố cổ Hội An" ),
				'hh_p_map_coords'    => array( 'type' => 'text', 'label' => 'Tọa độ bản đồ (chính xác nhất)', 'placeholder' => 'VD: 16.0602, 108.2280', 'half' => true, 'help' => 'Mở Google Maps → bấm chuột phải đúng vị trí dự án → bấm dòng số đầu tiên (tọa độ) để sao chép → dán vào đây.' ),
				'hh_p_map_address'   => array( 'type' => 'text', 'label' => 'Hoặc tên / địa chỉ tìm trên Google Maps', 'placeholder' => 'Để trống: tìm theo tên dự án', 'half' => true ),
				'hh_p_location_img'  => array( 'type' => 'image', 'label' => 'Ảnh sơ đồ vị trí', 'half' => true ),
			),
		),
		'tien-ich'  => array(
			'title'  => 'Tiện ích',
			'fields' => array(
				'hh_p_amenities_in'  => array( 'type' => 'lines', 'label' => 'Tiện ích nội khu', 'placeholder' => "Hồ bơi tràn bờ 50m\nPhòng gym, yoga\nVườn BBQ\nKhu vui chơi trẻ em\nAn ninh 24/7, thẻ từ thang máy" ),
				'hh_p_amenities_out' => array( 'type' => 'lines', 'label' => 'Tiện ích ngoại khu', 'placeholder' => "Trường quốc tế – 500m\nBệnh viện Vinmec Đà Nẵng – 2km\nChợ Hàn – 1,5km" ),
				'hh_p_amenities_img' => array( 'type' => 'gallery', 'label' => 'Ảnh tiện ích', 'help' => 'Ảnh đầu tiên hiện lớn, các ảnh sau xếp 2 cột. Tên trên ảnh = Chú thích (hoặc Tiêu đề) của ảnh, VD: "Clubhouse & bể bơi tiêu chuẩn Olympic". Không đặt thì lấy theo thứ tự danh sách tiện ích nội khu.' ),
			),
		),
		'mat-bang'  => array(
			'title'  => 'Mặt bằng & sản phẩm',
			'fields' => array(
				'hh_p_masterplan_img' => array( 'type' => 'image', 'label' => 'Ảnh mặt bằng tổng thể', 'half' => true ),
				'hh_p_design_desc'    => array( 'type' => 'textarea', 'label' => 'Mô tả thiết kế', 'placeholder' => 'VD: Mỗi sàn 10 căn, 4 thang máy, thiết kế đón gió tự nhiên …' ),
				'hh_p_floorplans'     => array( 'type' => 'gallery', 'label' => 'Ảnh mặt bằng tầng', 'help' => 'Đặt tiêu đề mỗi ảnh là tên tầng (VD: Tầng 1, Tầng 8 – 19) – trang dự án hiện thành các tab, bấm ảnh để phóng to.' ),
				'hh_p_unit_layouts'   => array( 'type' => 'gallery', 'label' => 'Ảnh layout từng loại căn', 'help' => 'Đặt tiêu đề ảnh trùng tên loại căn trong bảng "Căn hộ – các loại căn" (VD: Studio, Căn 2PN) hoặc xếp đúng thứ tự bảng.' ),
			),
		),
		'dac-biet'  => array(
			'title'  => 'Loại sản phẩm',
			'intro'  => 'Căn hộ, shop khối đế, penthouse, duplex, biệt thự / villa, nhà phố – shophouse, block đất nền. Website tự hiện các loại có trong dự án (theo "Loại dự án" và "Loại hình"); loại chưa nhập sẽ ghi "Đang cập nhật rổ hàng".',
			'fields' => array_merge(
				array(
					'hh_p_unit_types'     => array( 'type' => 'table', 'label' => 'Căn hộ – các loại căn', 'columns' => array( 'Loại căn', 'Diện tích', 'Phòng ngủ', 'Giá tham khảo' ), 'placeholder' => "Studio | 35 – 40 m² | 1 | 1,8 – 2 tỷ\nCăn 2PN | 65 – 75 m² | 2 | 3,2 – 3,8 tỷ\nCăn 3PN | 95 – 110 m² | 3 | 4,8 – 5,6 tỷ" ),
				),
				hh_special_product_fields()
			),
		),
		'gia-ban'   => array(
			'title'  => 'Giá & chính sách',
			'fields' => array(
				'hh_p_hot_title'     => array( 'type' => 'text', 'label' => 'Tiêu đề giỏ hàng nổi bật', 'placeholder' => 'Giỏ hàng độc quyền – căn giá tốt' ),
				'hh_p_hot_units'     => array( 'type' => 'table', 'label' => 'Giỏ hàng nổi bật (hiện trên trang, giá ghi "Liên hệ")', 'columns' => array( 'Mã căn', 'Phân khu', 'Loại hình', 'Diện tích đất', 'Ghi chú' ), 'placeholder' => "LV7-23 | Vịnh Mây | Liền kề | 105 m² | Thanh toán giãn 24 tháng\nBV12-27 | Bạch Vân | Song lập | 140 m² | Giá tốt nhất dòng song lập", 'help' => 'Chỉ nhập 3 – 6 căn muốn khoe. Không hiện giá: khách bấm "Nhận giá & phiếu tính giá" để để lại số điện thoại.' ),
				'hh_p_price_table'   => array( 'type' => 'table', 'label' => 'Bảng giá', 'columns' => array( 'Sản phẩm', 'Diện tích', 'Giá bán', 'Ghi chú' ), 'placeholder' => "A-12.05 – 2PN | 68 m² | 3,35 tỷ | View sông\nB-08.10 – 3PN | 98 m² | 5,1 tỷ | Căn góc" ),
				'hh_p_payment'       => array( 'type' => 'table', 'label' => 'Lịch thanh toán', 'columns' => array( 'Đợt', 'Thời điểm', 'Tỷ lệ' ), 'placeholder' => "Đợt 1 | Ký thỏa thuận đặt cọc | 10%\nĐợt 2 | Ký HĐMB (30 ngày) | 20%\nĐợt 3 | Nhận bàn giao | 65%\nĐợt 4 | Nhận sổ hồng | 5%" ),
				'hh_p_offer_title'    => array( 'type' => 'text', 'label' => 'Ưu đãi nổi bật (dòng chữ lớn)', 'placeholder' => 'VD: Chiết khấu tới 12% khi thanh toán sớm', 'help' => 'Để trống: lấy dòng đầu của "Chính sách bán hàng & ưu đãi".' ),
				'hh_p_offer_note'     => array( 'type' => 'text', 'label' => 'Ghi chú ưu đãi', 'placeholder' => 'VD: Áp dụng cho khách hàng thanh toán trước ngày 25/10/2026' ),
				'hh_p_offer_start'    => array( 'type' => 'text', 'label' => 'Chính sách áp dụng từ ngày', 'placeholder' => 'VD: 26/09/2026', 'half' => true ),
				'hh_p_offer_deadline' => array( 'type' => 'text', 'label' => 'Hạn ưu đãi (đồng hồ đếm ngược)', 'placeholder' => 'VD: 25/10/2026', 'half' => true, 'help' => 'Hết hạn tự ẩn đồng hồ.' ),
				'hh_p_discount_table' => array( 'type' => 'table', 'label' => 'Bảng chiết khấu theo phương án thanh toán', 'columns' => array( 'Phương án', 'Hạn thanh toán', 'Chiết khấu' ), 'placeholder' => "Thanh toán 95% – nhận nhà khi nghiệm thu | Trước 25/10/2026 | 12%\nThanh toán 70% – còn lại theo tiến độ | Trước 25/10/2026 | 5%" ),
				'hh_p_policy'        => array( 'type' => 'lines', 'label' => 'Chính sách bán hàng & ưu đãi', 'placeholder' => "Chiết khấu 3% khi thanh toán nhanh 50%\nTặng gói nội thất 100 triệu\nMiễn phí quản lý 2 năm" ),
				'hh_p_loan'          => array( 'type' => 'textarea', 'label' => 'Hỗ trợ vay ngân hàng', 'placeholder' => 'VD: Vietcombank, BIDV hỗ trợ vay 70%, ân hạn gốc lãi 18 tháng …' ),
				'hh_p_rental'        => array( 'type' => 'textarea', 'label' => 'Chương trình cho thuê / cam kết lợi nhuận (căn hộ dịch vụ, condotel)', 'placeholder' => 'VD: Cam kết lợi nhuận 8%/năm trong 3 năm đầu, chủ nhà được nghỉ miễn phí 15 đêm/năm …' ),
				'hh_p_pricelist_url' => array( 'type' => 'url', 'label' => 'Link tải bảng giá / brochure (Google Drive, PDF…)', 'placeholder' => 'https://' ),
			),
		),
		'bang-tinh' => array(
			'title'  => 'Bảng tính căn',
			'intro'  => 'Tải lên nguyên file Excel của chủ đầu tư (.xlsx hoặc .xls đời cũ, không cần sửa) → website tự tạo trang /du-an/<dự án>/bang-tinh/. Web tự nhận 2 loại: (1) Phiếu tính giá (mỗi trang tính là 1 phương án: giá niêm yết, chiết khấu, VAT, KPBT, tiến độ thanh toán, vay ngân hàng) → khách nhập giá căn, chọn phương án là ra số tiền từng đợt; (2) Bảng hàng / rổ hàng (mỗi dòng 1 căn: Mã căn, Tòa, Tầng, Loại căn, Diện tích, Giá…, Tình trạng) → khách chọn căn để tính. Có thể chọn nhiều file cùng lúc (VD phiếu tính giá + bảng hàng, hoặc mỗi tòa 1 file). Mỗi lần bấm Cập nhật, web đọc lại file và báo số căn, số phương án đọc được.',
			'fields' => array(
				'hh_p_units_file'  => array( 'type' => 'files', 'label' => 'File của chủ đầu tư: phiếu tính giá / bảng hàng (.xlsx, .xls, .csv – chọn được nhiều file)', 'half' => true ),
				'hh_p_units_sheet' => array( 'type' => 'url', 'label' => 'Hoặc link Google Sheets', 'placeholder' => 'https://docs.google.com/spreadsheets/d/…', 'half' => true, 'help' => 'Chia sẻ: Bất kỳ ai có đường liên kết đều xem được. Mỗi lần bấm Cập nhật dự án, web đọc lại bảng.' ),
				'hh_p_calc_plans'  => array( 'type' => 'table', 'label' => 'Phương án thanh toán', 'columns' => array( 'Mã', 'Tên phương án', 'Chiết khấu (%)', 'Lịch thanh toán (Đợt:%; …)', 'Vay ngân hàng (%)' ), 'placeholder' => "chuan | Thanh toán chuẩn theo tiến độ | 0 | Ký HĐMB:20; 3 tháng:10; 6 tháng:10; Bàn giao:55; Nhận sổ:5 | 0\nv24 | Vay 70%, hỗ trợ lãi 24 tháng | 0 | Ký HĐMB:15; 1 tháng:15; Giải ngân vay:70 | 70\nnhanh | Thanh toán nhanh 95% | 9 | Ký HĐMB:95; Nhận sổ:5 | 0", 'help' => 'Không bắt buộc khi đã tải phiếu tính giá (phương án lấy từ phiếu). Mã ngắn không dấu (dùng trên đường link, VD ?tt=v24). Chiết khấu trừ vào giá chưa VAT nếu file có cột giá chưa VAT, không thì trừ vào tổng giá.' ),
				'hh_p_vat'         => array( 'type' => 'number', 'label' => 'Thuế VAT (%)', 'placeholder' => '10', 'half' => true ),
				'hh_p_kpbt'        => array( 'type' => 'number', 'label' => 'Kinh phí bảo trì (% giá chưa VAT)', 'placeholder' => '2', 'half' => true ),
				'hh_p_units_note'  => array( 'type' => 'textarea', 'label' => 'Ghi chú dưới bảng tính', 'placeholder' => 'VD: Bảng giá áp dụng từ 01/10/2026, có thể thay đổi theo từng đợt.' ),
			),
		),
		'thu-cap'   => array(
			'title'  => 'Chuyển nhượng & cho thuê',
			'intro'  => 'Tin mua bán / cho thuê chọn "Thuộc dự án" là dự án này sẽ tự hiện trên trang dự án, kèm khoảng giá tính từ các tin đang đăng. Các ô dưới đây để ghi giá tham khảo khi chưa có tin.',
			'fields' => array(
				'hh_p_resale_price' => array( 'type' => 'text', 'label' => 'Giá chuyển nhượng tham khảo', 'placeholder' => 'VD: 45 – 55 triệu/m² · 2PN từ 3,2 tỷ', 'half' => true ),
				'hh_p_rent_price'   => array( 'type' => 'text', 'label' => 'Giá thuê tham khảo', 'placeholder' => 'VD: 1PN 9 – 12 triệu/tháng · 2PN 14 – 18 triệu/tháng', 'half' => true ),
				'hh_p_resale_note'  => array( 'type' => 'textarea', 'label' => 'Nhận định thị trường thứ cấp', 'placeholder' => 'VD: Thanh khoản tốt với căn 2PN view sông; khách thuê chủ yếu là chuyên gia nước ngoài, công suất cho thuê 80 – 90% …' ),
			),
		),
		'tai-chinh' => array(
			'title'  => 'Dòng tiền & vay vốn',
			'intro'  => 'Số liệu mặc định cho bảng tính vay và dòng tiền trên trang dự án; khách có thể tự chỉnh khi xem. Nhập số, không cần đơn vị.',
			'fields' => array(
				'hh_p_calc_price'        => array( 'type' => 'number', 'label' => 'Giá căn mẫu để tính (triệu đồng)', 'placeholder' => 'VD: 3350 (để trống = dùng "Giá từ")', 'half' => true ),
				'hh_p_loan_bank'         => array( 'type' => 'text', 'label' => 'Ngân hàng hỗ trợ vay', 'placeholder' => 'VD: Vietcombank, BIDV, VPBank', 'half' => true ),
				'hh_p_loan_ratio'        => array( 'type' => 'number', 'label' => 'Tỷ lệ cho vay tối đa (%)', 'placeholder' => 'VD: 70', 'half' => true ),
				'hh_p_loan_years'        => array( 'type' => 'number', 'label' => 'Thời hạn vay tối đa (năm)', 'placeholder' => 'VD: 25', 'half' => true ),
				'hh_p_loan_rate_promo'   => array( 'type' => 'number', 'label' => 'Lãi suất ưu đãi (%/năm)', 'placeholder' => 'VD: 6,5', 'half' => true ),
				'hh_p_loan_promo_months' => array( 'type' => 'number', 'label' => 'Thời gian ưu đãi lãi (tháng)', 'placeholder' => 'VD: 12', 'half' => true ),
				'hh_p_loan_rate_float'   => array( 'type' => 'number', 'label' => 'Lãi suất thả nổi sau ưu đãi (%/năm)', 'placeholder' => 'VD: 10,5', 'half' => true ),
				'hh_p_loan_grace'        => array( 'type' => 'number', 'label' => 'Ân hạn nợ gốc (tháng)', 'placeholder' => 'VD: 24', 'half' => true ),
				'hh_p_loan_zero_months'  => array( 'type' => 'number', 'label' => 'Chủ đầu tư hỗ trợ lãi 0% (tháng)', 'placeholder' => 'VD: 18', 'half' => true ),
				'hh_p_rent_estimate'     => array( 'type' => 'number', 'label' => 'Giá thuê dự kiến (triệu đồng/tháng)', 'placeholder' => 'VD: 15', 'half' => true ),
				'hh_p_occupancy'         => array( 'type' => 'number', 'label' => 'Tỷ lệ lấp đầy dự kiến (%)', 'placeholder' => 'VD: 85', 'half' => true ),
				'hh_p_rent_cost'         => array( 'type' => 'number', 'label' => 'Chi phí vận hành, quản lý (% tiền thuê)', 'placeholder' => 'VD: 15', 'half' => true ),
				'hh_p_growth'            => array( 'type' => 'number', 'label' => 'Tăng giá dự kiến (%/năm) – để tham khảo', 'placeholder' => 'VD: 6', 'half' => true ),
				'hh_p_cashflow_note'     => array( 'type' => 'textarea', 'label' => 'Phân tích dòng tiền / bài toán đầu tư (viết tự do)', 'placeholder' => 'VD: Với căn 2PN giá 3,35 tỷ, khách chỉ cần chuẩn bị 1 tỷ, phần còn lại ngân hàng giải ngân theo tiến độ, ân hạn gốc 24 tháng, CĐT hỗ trợ lãi 0% đến khi nhận nhà …' ),
				'hh_p_custom_table'      => array( 'type' => 'table', 'label' => 'Bảng tính bổ sung', 'columns' => array( 'Hạng mục', 'Giá trị', 'Ghi chú' ), 'placeholder' => "Giá căn 2PN | 3,35 tỷ | View sông\nVốn tự có 30% | 1,005 tỷ | Thanh toán theo tiến độ\nNgân hàng cho vay 70% | 2,345 tỷ | 25 năm\nTiền thuê dự kiến | 15 triệu/tháng | Full nội thất" ),
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
				'hh_p_image_links' => array( 'type' => 'lines', 'label' => 'Link ảnh (Google Drive hoặc link ảnh) – web tự tải về', 'placeholder' => "https://drive.google.com/file/d/…/view | Phối cảnh tổng thể | đại diện\nhttps://drive.google.com/file/d/…/view | Tổng mặt bằng tiện ích Khu 1 | tiện ích\nhttps://drive.google.com/file/d/…/view | Mặt bằng Vịnh Mây | mặt bằng", 'help' => 'Mỗi dòng: Link | Chú thích ảnh | Mục (thư viện / tiện ích / mặt bằng / đại diện). Link Drive chia sẻ "Bất kỳ ai có đường liên kết", dán link TỪNG FILE (không dán link thư mục). Bấm Cập nhật: web tải ảnh về Thư viện và gắn vào đúng mục; mỗi link chỉ tải 1 lần, mỗi lần tối đa 15 ảnh.' ),
				'hh_p_video'   => array( 'type' => 'url', 'label' => 'Video YouTube', 'placeholder' => 'https://www.youtube.com/watch?v=…' ),
			),
		),
		'hoi-dap'   => array(
			'title'  => 'Hỏi đáp',
			'fields' => array(
				'hh_p_faq' => array( 'type' => 'table', 'label' => 'Câu hỏi thường gặp', 'help' => 'Để trống, website tự tạo câu hỏi từ thông tin dự án (chủ đầu tư, vị trí, pháp lý, bàn giao…).', 'columns' => array( 'Câu hỏi', 'Trả lời' ), 'placeholder' => "Dự án có sổ hồng chưa? | Sổ hồng cấp sau khi nhận nhà khoảng 12 tháng.\nNgười nước ngoài có mua được không? | Được, theo hạn mức 30% số căn mỗi tòa." ),
			),
		),
	);
}

/** Loại sản phẩm (ngoài căn hộ thường): key => label. */
const HH_SPECIAL_PRODUCTS = array(
	'shop'      => 'Shop khối đế',
	'penthouse' => 'Penthouse',
	'duplex'    => 'Duplex',
	'villa'     => 'Biệt thự / Villa',
	'nha-pho'   => 'Nhà phố – Shophouse',
	'dat-nen'   => 'Block đất nền',
);

function hh_special_product_fields() {
	$examples = array(
		'shop'      => array( 'Mặt tiền đường Trần Hưng Đạo, trần cao 5m, phù hợp cà phê, showroom, ngân hàng…', "S-01 | 120 m² | 15 tỷ | Góc 2 mặt tiền\nS-02 | 85 m² | 9,8 tỷ | Mặt sông" ),
		'penthouse' => array( 'Hai tầng trên cùng, hồ bơi riêng, sân vườn trên không, view toàn cảnh sông Hàn…', "PH-01 | 280 m² | 4 | 28 tỷ\nPH-02 | 310 m² | 5 | 32 tỷ" ),
		'duplex'    => array( 'Căn 2 tầng thông nhau, phòng khách trần cao gấp đôi, cầu thang riêng…', "DL-2501 | 160 m² | 3 | 12,5 tỷ\nDL-2503 | 175 m² | 4 | 13,8 tỷ" ),
		'villa'     => array( 'Biệt thự đơn lập, song lập 2–3 tầng, sân vườn, hồ bơi riêng…', "Đơn lập | 300 m² | 3 tầng, DTXD 260 m² | 25 tỷ\nSong lập | 200 m² | 3 tầng, DTXD 210 m² | 16 tỷ" ),
		'nha-pho'   => array( 'Nhà phố 5 tầng, tầng 1 kinh doanh, mặt tiền đường 15m…', "Nhà phố | 100 m² | 5 tầng | 12 tỷ\nShophouse góc | 140 m² | 5 tầng | 18 tỷ" ),
		'dat-nen'   => array( 'Đất nền đã có sổ, hạ tầng hoàn thiện, đường 7,5 – 10,5m…', "Block A (lô A1 – A20) | 100 – 125 m² | Đường 7,5m | 2,8 – 3,5 tỷ\nBlock B (lô góc) | 150 m² | Đường 10,5m | 4,6 tỷ" ),
	);
	$columns = array(
		'shop'      => array( 'Mã căn', 'Diện tích', 'Giá bán', 'Ghi chú' ),
		'penthouse' => array( 'Mã căn', 'Diện tích', 'Phòng ngủ', 'Giá bán' ),
		'duplex'    => array( 'Mã căn', 'Diện tích', 'Phòng ngủ', 'Giá bán' ),
		'villa'     => array( 'Loại / mã căn', 'Diện tích đất', 'Quy cách', 'Giá bán' ),
		'nha-pho'   => array( 'Loại / mã căn', 'Diện tích đất', 'Số tầng', 'Giá bán' ),
		'dat-nen'   => array( 'Block / lô', 'Diện tích', 'Mặt đường', 'Giá bán' ),
	);
	$fields = array();
	foreach ( HH_SPECIAL_PRODUCTS as $key => $label ) {
		$fields[ "hh_p_{$key}_desc" ]    = array( 'type' => 'textarea', 'label' => $label . ' – mô tả', 'placeholder' => 'VD: ' . $examples[ $key ][0] );
		$fields[ "hh_p_{$key}_table" ]   = array( 'type' => 'table', 'label' => $label . ' – danh sách căn', 'columns' => $columns[ $key ], 'placeholder' => $examples[ $key ][1] );
		$fields[ "hh_p_{$key}_gallery" ] = array( 'type' => 'gallery', 'label' => $label . ' – hình ảnh' );
	}
	return $fields;
}

/** Columns of a special product table. */
function hh_special_columns( $key ) {
	return hh_project_schema()['dac-biet']['fields'][ "hh_p_{$key}_table" ]['columns'];
}

/** Tin tức: gắn bài viết với dự án để hiện ở mục "Tin tức" của trang dự án. */
function hh_post_schema() {
	return array(
		'du-an' => array(
			'title'  => 'Dự án liên quan',
			'fields' => array(
				'hh_post_faq'     => array( 'type' => 'table', 'label' => 'Hỏi đáp (giúp Google, ChatGPT trích dẫn)', 'columns' => array( 'Câu hỏi', 'Trả lời ngắn' ), 'placeholder' => "Cầu Hòa Xuân mới khi nào xong? | Dự kiến hoàn thành năm 2029." ),
				'hh_post_project' => array( 'type' => 'post', 'label' => 'Bài viết này nói về dự án', 'post_type' => 'du-an', 'help' => 'Bài sẽ hiện ở mục "Tin tức" của trang dự án (và trang tổ hợp chứa dự án đó). Bài có nhắc tên dự án trong tiêu đề cũng tự được gợi ý.' ),
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
				'hh_price_max'  => array( 'type' => 'number', 'label' => 'Giá đến (triệu) – nếu là khoảng giá', 'placeholder' => 'VD: 6800 → hiện "3,6 – 6,8 tỷ"', 'half' => true ),
				'hh_price_from' => array( 'type' => 'select', 'label' => 'Chữ trước giá', 'half' => true, 'options' => array( '' => 'Không', '1' => 'Từ …', '2' => 'Khoảng …' ) ),
				'hh_negotiable' => array( 'type' => 'checkbox', 'label' => 'Giá còn thương lượng', 'half' => true ),
				'hh_address'    => array( 'type' => 'text', 'label' => 'Địa chỉ', 'placeholder' => 'VD: 123 Võ Nguyên Giáp, Ngũ Hành Sơn, Đà Nẵng' ),
				'hh_project'    => array( 'type' => 'post', 'label' => 'Thuộc dự án', 'post_type' => 'du-an', 'half' => true, 'help' => 'Tin sẽ hiện ở mục "Chuyển nhượng & cho thuê" của trang dự án.' ),
				'hh_featured'   => array( 'type' => 'checkbox', 'label' => 'Tin HOT (xếp đầu mục "hot mới" cuối trang)', 'half' => true ),
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
