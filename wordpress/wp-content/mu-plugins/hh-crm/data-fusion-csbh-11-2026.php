<?php
/**
 * Fusion Resort & Villas Đà Nẵng – chính sách bán hàng chủ đầu tư cho căn biệt thự 4 phòng ngủ cuối cùng (anh Hiệp gửi 06/11/2026).
 * Không ghi mã căn; không dùng ảnh tài liệu có logo đơn vị phân phối khác. Phần "chính sách đặc biệt trước 30/9/2026" đã hết hạn → không đăng.
 * Thông tin dự án theo tài liệu hỏi đáp CĐT 07/5/2026 và bảng giá 10/12/2025.
 * Dự án chuyển từ "đã bán hết" sang "đang mở bán" để hiện mục Giá & chính sách; giá chuyển nhượng vẫn giữ.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$new = array(
			'hh_p_status'       => 'dang-mo-ban',
			'hh_p_sold_out'     => '0',
			'hh_p_offer_title'  => 'Chiết khấu 20% khi thanh toán nhanh – căn biệt thự 4 phòng ngủ cuối cùng',
			'hh_p_offer_note'   => 'Áp dụng cho căn Beach Garden Villa 4 phòng ngủ (đất 753 m²) cuối cùng chủ đầu tư còn bán (chính sách tháng 11/2026, tham khảo – liên hệ để xác nhận trước khi giao dịch).',
			'hh_p_policy'       => "Chiết khấu 20% trên giá bán khi thanh toán nhanh\nTặng trọn gói nội thất tiêu chuẩn 5 sao Fusion (giá trị khoảng 2 tỷ đồng)\nVilla mua để ở: tặng 5 năm phí quản lý\nVilla tham gia cho thuê: sở hữu 40 điểm ở mỗi năm\nVilla tham gia chương trình cho thuê: tặng thêm 30 điểm ở, dùng trong 2 năm\nGiá niêm yết Beach Garden Villa 4PN (đất 753 m², villa 463 m²): khoảng 58,41 tỷ đồng chưa VAT (bảng giá chủ đầu tư 12/2025) – giá sau chiết khấu liên hệ Hoàng Hiệp",
			'hh_p_price_table'  => 'Beach Garden Villa 4 phòng ngủ (căn cuối cùng) | Đất 753 m² · villa 463 m² | Khoảng 58,41 tỷ (chưa VAT, bảng giá CĐT 12/2025) | Chiết khấu 20% khi thanh toán nhanh',
		);
		// Thông tin dự án theo tài liệu hỏi đáp của chủ đầu tư (07/5/2026). Không đăng hồ sơ pháp lý (khách cần thì anh Hiệp gửi).
		$new += array(
			'hh_p_tour_360'        => 'https://fusionresortvillas.com/360/',
			'hh_p_tour_360_poster' => 'plugin:img/fusion/fusion-toan-canh-day-biet-thu-bien.jpg',
			// Mô hình 4D mặt bằng tổng thể (dựng theo mặt bằng CĐT, không mã căn) – lưu trong kho mã projects/fusion/4d/.
			'hh_p_tour_4d'      => 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/1a0770dbe9871c4536b1ba21e37cd0b05e76d909/projects/fusion/4d/fusion-4d.html',
			'hh_p_tour_poster'  => 'plugin:img/fusion/fusion-mo-hinh-4d-xem-truoc.jpg',
			'hh_p_tour_name'    => 'mặt bằng 4D',
			'hh_p_scale'        => '15,75 ha – mật độ xây dựng khoảng 16,7%, khoảng 300 m bờ biển',
			'hh_p_units'        => '85 biệt thự 1 – 6 phòng ngủ (giai đoạn 1: 44 căn, giai đoạn 2: 41 căn) và khách sạn 18 tầng 157 phòng',
			'hh_p_unit_area'    => 'Đất khoảng 370 – 1.718 m², diện tích biệt thự 210 – 1.236 m²',
			'hh_p_manager'      => 'Fusion Hotel Group',
			'hh_p_villa_table'  => "Presidential Villa 6PN – 1 căn | 1.718 m² | Biệt thự 1.236 m² | Liên hệ
Beachfront Villa 5PN – 9 căn | 850 – 950 m² | Biệt thự 725 m², mặt biển | Chuyển nhượng – liên hệ
Premier Villa 3 – 5PN – 14 căn | 641 – 767 m² | Biệt thự 487 – 541 m² | Chuyển nhượng – liên hệ
Beach Garden Residence 3 – 4PN – 11 căn | 750 – 902 m² | Biệt thự 463 m² | Chủ đầu tư còn 1 căn 4PN – khoảng 58,41 tỷ (chưa VAT)
Garden Terrace Villa 2PN – 40 căn | 418 – 513 m² | Biệt thự 302 – 384 m² | Chuyển nhượng – liên hệ
Garden Front Villa 1PN – 10 căn | 370 – 535 m² | Biệt thự 210 m² | Chuyển nhượng – liên hệ",
			'hh_p_amenities_in' => "Hồ bơi chính 1.377 m² (trong nhà và ngoài trời), hồ bơi riêng từng biệt thự 24 – 192 m²
Bãi biển riêng khoảng 300 m
Spa, phòng tập, câu lạc bộ thể thao, sân tennis, sân golf mini
Nhà hàng chính bên hồ bơi (158 chỗ) và Grill House & Bar bên bãi biển
Khu vui chơi trẻ em
An ninh, vận hành, kỹ thuật 24/7; xe buggy nội khu
Bãi đỗ xe 3.653 m² (khoảng 143 ô tô, 200 xe máy)",
			'hh_p_design_desc'  => 'Biệt thự thiết kế hướng biển hoặc vườn riêng, đón ánh sáng và gió tự nhiên. Tầng trệt cao 3,7 m, tầng lầu 3 m (thông thủy 2,7 – 2,9 m); hồ bơi riêng 24 – 192 m² tùy loại; hàng rào cao 2 m, đường nội khu rộng 6 m. Bàn giao kèm nội thất gắn tường và nội thất rời theo chính sách bán hàng; bảo hành 24 tháng. Ngoại thất, cảnh quan giữ đồng bộ, nội thất thay đổi khi chủ đầu tư đồng ý.',
			'hh_p_villa_desc'   => 'Biệt thự 1 – 6 phòng ngủ, mỗi căn có hồ bơi riêng, sân vườn, tường rào; Beach Front và Presidential sát bãi cát, Premier và Beach Garden ở giữa, Garden Terrace và Garden Front quanh hai cụm nội khu. Đất khoảng 370 – 1.718 m². Giá chuyển nhượng theo tin rao 2026 khoảng 32 – 54 tỷ; chủ đầu tư còn 1 căn Beach Garden Villa 4 phòng ngủ.',
			'hh_p_faq'          => "Fusion Resort & Villas Đà Nẵng ở đâu, quy mô bao nhiêu? | Đường Trường Sa, phường Hòa Hải (cũ), Ngũ Hành Sơn, Đà Nẵng; 15,75 ha gồm 85 biệt thự 1 – 6 phòng ngủ và khách sạn 18 tầng 157 phòng, khoảng 300 m bờ biển.\nChủ đầu tư và đơn vị vận hành là ai? | Chủ đầu tư Công ty TNHH Khách sạn và Biệt thự Nam Phát (Lodgis Hospitality Holding); vận hành bởi Fusion Hotel Group.\nMua biệt thự Fusion được sử dụng thế nào? | Ba lựa chọn: tự ở, cho thuê dài hạn từ 6 tháng, hoặc tham gia chương trình cho thuê do Fusion vận hành.\nChương trình cho thuê chia doanh thu ra sao? | Chủ biệt thự nhận 35% doanh thu gộp cho thuê, chi trả theo quý, kèm 40 điểm nghỉ mỗi năm; không cam kết lợi nhuận tối thiểu. Hợp đồng 5 năm, rút ra báo trước 9 tháng.\nChủ biệt thự tham gia cho thuê được ở bao nhiêu đêm? | 40 điểm mỗi năm: thấp điểm 1 điểm/đêm (tối đa 40 đêm), trung gian 1,25 điểm, cao điểm 1,5 điểm, Lễ – Tết 2 điểm; điểm chưa dùng chuyển sang 6 tháng đầu năm sau, miễn phí ăn sáng khi ở bằng điểm.\nPhí quản lý bao nhiêu? | 25.000 đồng/m² diện tích biệt thự (chưa VAT), tăng tối đa 5%/năm từ 2026. Biệt thự tham gia cho thuê không đóng phí quản lý, chỉ đóng kinh phí bảo trì 2%.\nBiệt thự bàn giao có nội thất không? | Có, gồm nội thất gắn tường và nội thất rời theo chính sách bán hàng; tham gia cho thuê cần gói nội thất tiêu chuẩn Fusion. Bảo hành 24 tháng.\nChủ đầu tư còn căn nào? | Còn 1 căn Beach Garden Villa 4 phòng ngủ, đất 753 m², khoảng 58,41 tỷ chưa VAT (bảng giá 12/2025), chiết khấu 20% khi thanh toán nhanh; các căn khác giao dịch chuyển nhượng.\nKhách nước ngoài mua được không? | Khách nước ngoài ký hợp đồng thuê dài hạn, sử dụng đến hết thời hạn và không được chuyển nhượng (Điều 49 Luật Kinh doanh BĐS, hiệu lực 1/8/2024). Liên hệ Hoàng Hiệp để được tư vấn cụ thể.",
			'hh_p_rental'       => "Chủ sở hữu chọn: tự ở, cho thuê dài hạn từ 6 tháng, hoặc tham gia chương trình cho thuê (rental pool) do Fusion vận hành.
Rental pool: chủ nhận 35% doanh thu gộp cho thuê, chi trả theo quý; 40 điểm nghỉ mỗi năm (1 – 2 điểm/đêm tùy mùa), điểm chưa dùng chuyển sang 6 tháng đầu năm sau; giảm 10 – 20% dịch vụ resort.
Không cam kết lợi nhuận tối thiểu. Công suất phòng chủ đầu tư công bố: 50 – 55% (Q2/2024 – Q4/2025), dự kiến 55 – 65% năm tiếp theo.
Hợp đồng cho thuê 5 năm, muốn rút báo trước 9 tháng; tham gia cần mua gói nội thất rời tiêu chuẩn Fusion.
Tham gia cho thuê: không trả phí quản lý, đóng kinh phí bảo trì 2%. Tự ở: phí quản lý 25.000 đồng/m² diện tích biệt thự (chưa VAT), tăng tối đa 5%/năm từ 2026.
Điểm nghỉ theo mùa: Lễ – Tết 2 điểm/đêm (tối đa 20 đêm), cao điểm 1/6 – 31/8: 1,5 điểm (27 đêm), trung gian 1,25 điểm (32 đêm), thấp điểm 4/9 – 30/11: 1 điểm (40 đêm). Đổi điểm ở được loại biệt thự lớn hơn theo bảng quy đổi của resort.
Đặt ở bằng điểm: báo trước 30 ngày mùa cao điểm, 15 ngày mùa trung gian; hủy trước 7 ngày. Miễn phí ăn sáng khi ở bằng điểm.
Thu nhập cho thuê trả 4 đợt/năm: trước 25/4, 25/7, 25/10 và đợt quyết toán theo báo cáo kiểm toán trước 25/1 năm sau.
Ưu đãi chủ biệt thự (bảng dịch vụ 10/2024): giảm 20% ẩm thực (trừ rượu, thuốc lá), giảm 15% liệu trình spa, miễn phí xông hơi – gym – hồ bơi trong nhà 1 giờ/người/ngày; xe điện nội khu 24/24.
Khu biệt thự vận hành từ quý 1/2024, chương trình cho thuê từ tháng 3/2024 (điều khoản theo Chương trình cho thuê chủ đầu tư 12/12/2024).",
		);
		$old = array(
			'hh_p_status'   => array( 'da-ban-giao' ),
			'hh_p_sold_out' => array( '1' ),
			'hh_p_villa_table' => array( 'Biệt thự biển (tin rao) | 486 – 700 m² | – | Khoảng 32 – 54 tỷ' ),
			'hh_p_unit_area'   => array( 'Đất khoảng 486 – 700 m²' ),
			'hh_p_manager'     => array( 'Fusion' ),
			'hh_p_tour_4d'     => array( 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/163efdf439523c99d3e02ec14263ef3ba6ea19a6/projects/fusion/4d/fusion-4d.html', 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/56391180de3c496c5b973203a6df7b01aa4ef00e/projects/fusion/4d/fusion-4d.html', 'https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/c7d2ca2b3870b6605dfa1abafdac17501acd008a/projects/fusion/4d/fusion-4d.html' ),
		);
		foreach ( $projects as $i => $p ) {
			if ( 'fusion-resort-villas-da-nang' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			foreach ( $new as $k => $v ) {
				$cur = (string) ( $p['meta'][ $k ] ?? '' );
				$projects[ $i ]['meta'][ $k ] = $v;
				$fix = array_merge( (array) ( $p['fix_meta'][ $k ] ?? array() ), $old[ $k ] ?? array(), '' !== $cur && $cur !== $v ? array( $cur ) : array() );
				if ( $fix ) {
					$projects[ $i ]['fix_meta'][ $k ] = array_values( array_unique( $fix ) );
				}
			}
			// Mặt bằng tổng thể: thay bản CĐT (có ghi mã căn) bằng sơ đồ vẽ lại theo loại biệt thự.
			$links = (string) ( $projects[ $i ]['meta']['hh_p_image_links'] ?? '' );
			$swap  = preg_replace(
				'#^plugin:img/fusion/fusion-mat-bang-loai-biet-thu\.jpg \|[^\n]*$#m',
				'plugin:img/fusion/fusion-mat-bang-ve-lai.jpg | Sơ đồ mặt bằng tổng thể Fusion Resort & Villas Đà Nẵng theo loại biệt thự 1 – 6 phòng ngủ (vẽ lại minh họa theo mặt bằng chủ đầu tư) | tổng thể',
				$links
			);
			$v158   = $swap; // bản đã lưu ở 2.20.158 (chưa có ảnh trên cao)
			$aerial = 'plugin:img/fusion/fusion-toan-canh-khu-nghi-tren-cao.jpg';
			if ( false === strpos( $swap, $aerial ) ) {
				$swap = rtrim( $swap ) . "\n$aerial | Ảnh chụp từ trên cao Fusion Resort & Villas Đà Nẵng: bãi biển riêng, hồ bơi chính và các dãy biệt thự mái ngói | tổng thể | Toàn cảnh từ trên cao";
			}
			// 2.20.164: anh Hiệp cho hiện mã căn công khai → sơ đồ vẽ lại có ghi mã căn thay bản không mã.
			$v163 = $swap;
			$swap = preg_replace(
				'#^plugin:img/fusion/fusion-mat-bang-ve-lai\.jpg \|[^\n]*$#m',
				'plugin:img/fusion/fusion-mat-bang-ma-can.jpg | Mặt bằng tổng thể Fusion Resort & Villas Đà Nẵng có mã căn, tô màu theo loại biệt thự 1 – 6 phòng ngủ (vẽ lại theo mặt bằng chủ đầu tư) | tổng thể',
				$swap
			);
			if ( $swap !== $links ) {
				$projects[ $i ]['meta']['hh_p_image_links']     = $swap;
				$projects[ $i ]['fix_meta']['hh_p_image_links'] = array_merge( (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() ), array( $links, $v158, $v163 ) );
			}
			$projects[ $i ]['fix_excerpt'] = $p['excerpt'] ?? '';
			$projects[ $i ]['excerpt']     = 'Biệt thự biển Fusion Resort & Villas Đà Nẵng trên trục Trường Sa (Ngũ Hành Sơn): chủ đầu tư còn 1 căn Beach Garden Villa 4 phòng ngủ, đất 753 m², chiết khấu 20% khi thanh toán nhanh, tặng nội thất 5 sao khoảng 2 tỷ; các căn khác giao dịch chuyển nhượng.';
		}
		return $projects;
	},
	65 // Sau hh_dataset_biet_thu_ven_bien (20) và bộ ảnh data-fusion-anh.php (60) để thay đúng bản cũ.
);

// Một lần: gỡ ảnh mặt bằng CĐT cũ (ghi mã căn) khỏi mục Mặt bằng tổng thể – ảnh vẫn còn trong Thư viện.
add_action(
	'admin_init',
	static function () {
		if ( get_option( 'hh_fusion_mb_cu_go' ) || ! current_user_can( 'edit_posts' ) ) {
			return;
		}
		$post = get_page_by_path( 'fusion-resort-villas-da-nang', OBJECT, 'du-an' );
		if ( ! $post ) {
			return;
		}
		$done = (array) get_post_meta( $post->ID, '_hh_img_links', true );
		$old  = (int) ( $done['plugin:img/fusion/fusion-mat-bang-loai-biet-thu.jpg'] ?? 0 );
		if ( $old ) {
			foreach ( array( 'hh_p_masterplan_img', 'hh_p_gallery' ) as $key ) {
				$ids = array_filter( array_map( 'absint', explode( ',', (string) get_post_meta( $post->ID, $key, true ) ) ) );
				if ( in_array( $old, $ids, true ) ) {
					update_post_meta( $post->ID, $key, implode( ',', array_diff( $ids, array( $old ) ) ) );
				}
			}
			if ( (int) get_post_thumbnail_id( $post->ID ) === $old ) {
				delete_post_thumbnail( $post->ID );
			}
		}
		update_option( 'hh_fusion_mb_cu_go', 1, false );
	}
);

// Sơ đồ mặt bằng có mã căn: nếu tải lỗi thì tải lại; đặt đầu mục Mặt bằng tổng thể, gỡ bản vẽ lại không mã.
add_action(
	'init', // Chạy cả khi khách xem trang (ảnh tải xong qua cron) – chỉ đến khi xong một lần.
	static function () {
		if ( get_option( 'hh_fusion_mb_ma_can_ok' ) ) {
			return;
		}
		$post = get_page_by_path( 'fusion-resort-villas-da-nang', OBJECT, 'du-an' );
		if ( ! $post ) {
			return;
		}
		$key  = 'plugin:img/fusion/fusion-mat-bang-ma-can.jpg';
		$done = (array) get_post_meta( $post->ID, '_hh_img_links', true );
		$id   = $done[ $key ] ?? null;
		if ( ! is_int( $id ) ) {
			if ( null !== $id ) {
				unset( $done[ $key ] );
				update_post_meta( $post->ID, '_hh_img_links', $done );
				delete_post_meta( $post->ID, '_hh_img_fail_' . md5( $key ) );
			}
			if ( function_exists( 'hh_img_links_queue' ) ) {
				hh_img_links_queue( $post->ID );
			}
			return; // Chờ tải xong, lần sau xếp thứ tự.
		}
		$ids = array_filter( array_map( 'absint', explode( ',', (string) get_post_meta( $post->ID, 'hh_p_masterplan_img', true ) ) ) );
		$old = (int) ( $done['plugin:img/fusion/fusion-mat-bang-ve-lai.jpg'] ?? 0 ); // bản không mã căn: gỡ khỏi mục (vẫn còn trong Thư viện)
		$ids = array_values( array_unique( array_merge( array( $id ), array_diff( $ids, array( $id, $old ) ) ) ) );
		update_post_meta( $post->ID, 'hh_p_masterplan_img', implode( ',', $ids ) );
		update_option( 'hh_fusion_mb_ma_can_ok', 1, false );
	}
);
