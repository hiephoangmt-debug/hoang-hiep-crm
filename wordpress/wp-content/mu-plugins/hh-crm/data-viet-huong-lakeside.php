<?php
/**
 * Việt Hương Lakeside – nhà ở xã hội khu đất chung cư số 5, Khu B – KDC Nam cầu Cẩm Lệ (phường Hòa Xuân).
 * Trang dự án mới 18/11/2026 theo ảnh bảng thông tin công trường anh Hiệp chụp và thông báo của Sở Xây dựng / Cổng TTĐT Đà Nẵng.
 * Giá chỉ ghi giá tạm tính đã công bố (tham khảo). Không ghi tên, số điện thoại cá nhân.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$im = static fn( $f, $alt, $where ) => "plugin:img/hoa-xuan/hoa-xuan-flycam-8-2025-$f.jpg | $alt | $where";

		$projects[] = array(
			'slug'    => 'viet-huong-lakeside-hoa-xuan',
			'title'   => 'Việt Hương Lakeside – nhà ở xã hội Hòa Xuân',
			'type'    => 'can-ho-so-huu-lau-dai',
			'area'    => 'cam-le',
			'excerpt' => 'Việt Hương Lakeside – dự án nhà ở xã hội tại khu đất chung cư số 5, Khu B – KDC Nam cầu Cẩm Lệ (phường Hòa Xuân): 4 khối 14 tầng, 1.306 căn (1.040 căn nhà ở xã hội), căn 36 – 77 m², giá tạm tính khoảng 20,7 triệu/m².',
			'meta'    => array(
				'hh_p_status'       => 'sap-mo-ban',
				'hh_p_developer'    => 'Công ty CP Đầu tư Phát triển Nhà ở Toàn Cầu',
				'hh_p_builder'      => 'Liên danh Tổng công ty 36 – CTCP và Công ty CP Đầu tư và Phát triển Đông Bắc',
				'hh_p_designer'     => 'Tổng công ty Tư vấn Xây dựng Việt Nam – CTCP (VNCC)',
				'hh_p_type'         => 'Nhà ở xã hội (chung cư) kết hợp 1 khối nhà ở thương mại – tên pháp lý: Dự án Nhà ở xã hội tại khu đất chung cư số 5 thuộc Khu B – Khu dân cư Nam cầu Cẩm Lệ',
				'hh_p_address'      => 'Khu đất chung cư số 5, Khu B – Khu dân cư Nam cầu Cẩm Lệ (giữa các đường Nguyễn Kim – Huỳnh Tịnh Của – Lê Trực), phường Hòa Xuân, Đà Nẵng',
				'hh_p_map_address'  => 'Nguyễn Kim, Hòa Xuân, Đà Nẵng',
				'hh_p_scale'        => 'Khu đất 28.942,72 m², diện tích xây dựng 10.418,82 m² (theo bảng thông tin công trường); tổng sàn khoảng 145.000 m²; vốn đầu tư khoảng 1.730 tỷ đồng',
				'hh_p_blocks'       => '4 khối: 3 khối nhà ở xã hội (XH1, XH2, XH3) và 1 khối nhà ở thương mại',
				'hh_p_floors'       => '14 tầng, 1 tầng hầm (công trình cấp I)',
				'hh_p_units'        => '1.306 căn: 1.040 căn nhà ở xã hội (XH1 424, XH2 411, XH3 205) và 266 căn thương mại',
				'hh_p_unit_area'    => 'Khoảng 36 – 77 m² (1PN 36 – 42 m², 2PN khoảng 70 m², 3PN khoảng 77 m²)',
				'hh_p_price_m2'     => 'Giá tạm tính khoảng 20,7 triệu/m² sử dụng (đã gồm VAT, chưa gồm phí bảo trì) – tham khảo, theo thông tin mở bán đợt 1',
				'hh_p_legal'        => "Giấy phép xây dựng số 11111/SXD-GPXD ngày 18/12/2025 của Sở Xây dựng Đà Nẵng\nSở Xây dựng công khai thông tin tiếp nhận hồ sơ mua nhà ở xã hội ngày 16/3/2026 (đợt 1: 849 căn)\nNgười mua phải thuộc đối tượng và đủ điều kiện mua nhà ở xã hội theo Luật Nhà ở 2023",
				'hh_p_ownership'    => 'Nhà ở xã hội: được cấp giấy chứng nhận, hạn chế chuyển nhượng trong thời gian theo quy định của Luật Nhà ở',
				'hh_p_start'        => 'Khởi công 19/12/2025, thời gian thi công 24 tháng (theo bảng thông tin công trường)',
				'hh_p_handover'     => 'Theo bảng công trường thi công 24 tháng từ 12/2025; báo chí ghi bàn giao dự kiến cuối năm 2027 – hỏi Hoàng Hiệp tiến độ mới nhất',
				'hh_p_highlights'   => "Nhà ở xã hội ngay khu Hòa Xuân, gần sông Cẩm Lệ và trung tâm thành phố\n4 khối 14 tầng, 1.306 căn, phía Nam giáp hồ điều tiết và cây xanh công cộng\nGiá tạm tính khoảng 20,7 triệu/m² (đã gồm VAT) – tham khảo\nTổng thầu liên danh Tổng công ty 36 – Đông Bắc, thiết kế VNCC\nĐợt 1 (849 căn) đã nhận hồ sơ 16/4 – 16/5/2026 và bốc thăm 15/10/2026",
				'hh_p_design_desc'  => 'Bốn khối nhà 14 tầng trên 1 tầng hầm: ba khối nhà ở xã hội XH1 (424 căn), XH2 (411 căn), XH3 (205 căn) và một khối nhà ở thương mại (266 căn). Căn hộ 1 phòng ngủ khoảng 36 – 42 m², 2 phòng ngủ khoảng 70 m², 3 phòng ngủ khoảng 77 m².',
				'hh_p_unit_types'   => "Căn 1 phòng ngủ | Khoảng 36 – 42 m² | 1 | Liên hệ\nCăn 2 phòng ngủ | Khoảng 70 m² | 2 | Liên hệ\nCăn 3 phòng ngủ | Khoảng 77 m² | 3 | Liên hệ",
				'hh_p_location_desc' => 'Dự án nằm ở Khu B – Khu dân cư Nam cầu Cẩm Lệ, phường Hòa Xuân: phía Bắc giáp đường Nguyễn Kim, phía Đông giáp đường Huỳnh Tịnh Của, phía Tây giáp đường Lê Trực, phía Nam giáp hồ điều tiết và cây xanh công cộng (tên "Lakeside").',
				'hh_p_connections'  => "Vài phút | Cầu Cẩm Lệ, sông Cẩm Lệ\nVài phút | Trung tâm thương mại Aeon Mall Hòa Xuân (ước tính)\nKhoảng 15 phút | Trung tâm Hải Châu (ước tính)",
				'hh_p_amenities_out' => "Sông Cẩm Lệ, công viên ven sông Hòa Xuân\nAeon Mall Hòa Xuân\nTrường học, chợ khu Hòa Xuân – Cẩm Lệ",
				'hh_p_policy'       => "Đối tượng: người thuộc diện được mua nhà ở xã hội theo Điều 76 Luật Nhà ở 2023 (người thu nhập thấp tại đô thị, công nhân, cán bộ công chức viên chức, lực lượng vũ trang…)\nHồ sơ: đơn đăng ký, giấy xác nhận đối tượng và thu nhập, giấy xác nhận điều kiện nhà ở, giấy tờ nhân thân theo mẫu của Bộ Xây dựng\nĐợt 1: nhận hồ sơ từ 16/4 đến 16/5/2026 (đã kết thúc), bốc thăm 15/10/2026\nĐợt tiếp theo và các căn thương mại: liên hệ Hoàng Hiệp 0904 567 009 để được báo khi có thông báo",
				'hh_p_progress'     => "17/12/2025 | Giao đất cho chủ đầu tư\n18/12/2025 | Cấp giấy phép xây dựng số 11111/SXD-GPXD\n19/12/2025 | Khởi công\n16/3/2026 | Sở Xây dựng công khai thông tin tiếp nhận hồ sơ (đợt 1: 849 căn)\n16/4 – 16/5/2026 | Nhận hồ sơ đăng ký mua\n15/10/2026 | Bốc thăm quyền mua tại UBND phường Hòa Xuân\nCuối 2027 | Dự kiến hoàn thành (theo báo chí)",
				'hh_p_image_links'  => implode(
					"\n",
					array(
						$im( 'toan-canh-ven-song-cam-le', 'Toàn cảnh khu vực Hòa Xuân ven sông Cẩm Lệ – nơi có dự án Việt Hương Lakeside (ảnh flycam thực tế 8/2025)', 'đại diện' ),
						$im( 'song-cam-le-nhin-ve-trung-tam', 'Sông Cẩm Lệ nhìn từ Hòa Xuân về trung tâm Đà Nẵng (ảnh flycam thực tế 8/2025)', 'thư viện' ),
						$im( 'song-cam-le-va-trung-tam-da-nang', 'Khu Hòa Xuân, sông Cẩm Lệ và trung tâm Đà Nẵng (ảnh flycam thực tế 8/2025)', 'thư viện' ),
						$im( 'bo-song-hoa-xuan-asia-park', 'Bờ sông Hòa Xuân nhìn về khu Asia Park (ảnh flycam thực tế 8/2025)', 'thư viện' ),
					)
				),
			),
			'content' => '<p><strong>Việt Hương Lakeside</strong> là tên thương mại của Dự án Nhà ở xã hội tại khu đất chung cư số 5 thuộc Khu B – Khu dân cư Nam cầu Cẩm Lệ, phường Hòa Xuân, do Công ty CP Đầu tư Phát triển Nhà ở Toàn Cầu làm chủ đầu tư. Dự án gồm 4 khối nhà 14 tầng với 1.306 căn hộ, trong đó 1.040 căn nhà ở xã hội và 266 căn thương mại; vốn đầu tư khoảng 1.730 tỷ đồng.</p>
<h2>Thông tin từ bảng công trường</h2>
<ul>
<li>Diện tích khu đất 28.942,72 m², diện tích xây dựng 10.418,82 m², công trình cấp I, 14 tầng, 1 tầng hầm.</li>
<li>Giấy phép xây dựng số 11111/SXD-GPXD ngày 18/12/2025; khởi công ngày 19/12/2025, thời gian thi công 24 tháng.</li>
<li>Thiết kế: Tổng công ty Tư vấn Xây dựng Việt Nam – CTCP; thi công chính: liên danh Tổng công ty 36 – CTCP và Công ty CP Đầu tư và Phát triển Đông Bắc.</li>
</ul>
<h2>Căn hộ và giá tham khảo</h2>
<p>Căn 1 phòng ngủ khoảng 36 – 42 m², 2 phòng ngủ khoảng 70 m², 3 phòng ngủ khoảng 77 m². Giá tạm tính công bố khi mở bán đợt 1 khoảng 20,7 triệu đồng/m² sử dụng, đã gồm VAT, chưa gồm phí bảo trì – giá chính thức theo hợp đồng.</p>
<h2>Ai được mua, hồ sơ thế nào?</h2>
<p>Người mua phải thuộc đối tượng được hưởng chính sách nhà ở xã hội theo Luật Nhà ở 2023 và đáp ứng điều kiện về nhà ở, thu nhập. Đợt 1 (849 căn) đã nhận hồ sơ từ 16/4 đến 16/5/2026 và bốc thăm ngày 15/10/2026. Các đợt tiếp theo, căn dự khuyết và căn thương mại sẽ theo thông báo của chủ đầu tư và Sở Xây dựng.</p>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để được hướng dẫn điều kiện, hồ sơ và báo ngay khi dự án có đợt nhận hồ sơ mới.</p>',
			'sources' => array(
				'https://danang.gov.vn/vi/web/dng/w/cong-khai-thong-tin-tiep-nhan-ho-so-dang-ky-mua-nha-o-xa-hoi-tai-khu-dat-chung-cu-so-5-thuoc-khu-b-khu-dan-cu-nam-cau-cam-le',
				'https://hoaxuan.danang.gov.vn/ve-viec-lay-y-kien-ve-dieu-chinh-quy-hoach-chi-tiet-ty-le-1-500-du-an-nha-o-xa-hoi-tai-khu-dat-chung-cu-so-5-thuoc-khu-b-khu-dan-cu-nam-cau-cam-le/',
				'https://cafeland.vn/du-an/viet-huong-lakeside-du-an-nha-o-xa-hoi-tai-da-nang-5282.html',
				'https://thuviennhadat.vn/phap-luat/thong-tin-mo-ban-nha-o-xa-hoi-viet-huong-lakeside-da-nang-nam-2026-737885.html',
			),
		);
		return $projects;
	},
	20
);

/*
 * 22/11/2026: tiến độ tổng thể phần nhà ở thương mại theo tiến độ chung của dự án (bản 31/10/2026 anh Hiệp gửi).
 * Chỉ lấy mốc thời gian – không đăng file gốc, không tên/số điện thoại người lập. Chỉ thay ô còn đúng bản web đã nhập.
 */
add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$upd = array(
			'hh_p_handover' => 'Dự kiến bàn giao căn hộ 15/12/2027 (theo tiến độ tổng thể của dự án cập nhật 31/10/2026) – hỏi Hoàng Hiệp tiến độ mới nhất',
			'hh_p_progress' => "17/12/2025 | Giao đất cho chủ đầu tư\n18/12/2025 | Cấp giấy phép xây dựng số 11111/SXD-GPXD\n19/12/2025 | Khởi công\n20/01 – 27/4/2026 | Ép cọc đại trà\n16/3/2026 | Sở Xây dựng công khai thông tin tiếp nhận hồ sơ (đợt 1: 849 căn)\n16/4 – 16/5/2026 | Nhận hồ sơ đăng ký mua\n10/4 – 30/10/2026 | Kết cấu phần hầm đến cốt 0.000\n15/10/2026 | Bốc thăm quyền mua tại UBND phường Hòa Xuân\n30/11/2026 – 15/5/2027 | Kết cấu phần thân (kế hoạch)\n12/2026 – 10/2027 | Hoàn thiện kiến trúc, hệ thống điện nước, điều hòa, PCCC (kế hoạch)\n6 – 11/2027 | Mặt dựng, hệ cửa; hạ tầng, cảnh quan (kế hoạch)\n10/10 – 10/12/2027 | Nghiệm thu căn hộ, nghiệm thu hoàn thành dự án (kế hoạch)\n15/12/2027 | Dự kiến bàn giao căn hộ đưa vào sử dụng",
		);
		foreach ( $projects as $i => $p ) {
			if ( 'viet-huong-lakeside-hoa-xuan' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			foreach ( $upd as $k => $v ) {
				$cur = (string) ( $p['meta'][ $k ] ?? '' );
				if ( $cur === $v ) {
					continue;
				}
				if ( '' !== trim( $cur ) ) {
					$p['fix_meta'][ $k ] = array_merge( (array) ( $p['fix_meta'][ $k ] ?? array() ), array( $cur ) );
				}
				$p['meta'][ $k ] = $v;
			}
			$projects[ $i ] = $p;
		}
		return $projects;
	},
	40
);
