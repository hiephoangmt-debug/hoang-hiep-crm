<?php
/**
 * Sunneva Island – tên văn bản: Khu đô thị ven sông Hòa Quý – Đồng Nò (đảo Đồng Nò, Hòa Quý cũ, Ngũ Hành Sơn), CTCP Địa Cầu – Sun Group.
 * Nằm trong đợt 4 (11/2024) danh sách dự án người nước ngoài được sở hữu: tối đa 250 / 390 biệt thự.
 * Quy mô, số căn, giá tổng hợp báo chí và trang phân phối (10/2026) – nguồn chưa thống nhất, cần đối chiếu chủ đầu tư.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_project_dataset', 'hh_dataset_sunneva_island', 20 );
function hh_dataset_sunneva_island( $projects ) {
	$projects[] = array(
		'slug'    => 'sunneva-island',
		'title'   => 'Sunneva Island Đà Nẵng',
		'type'    => array( 'biet-thu', 'shophouse' ),
		'area'    => 'ngu-hanh-son',
		'hot'     => true,
		'excerpt' => 'Khu biệt thự đảo Đồng Nò của Sun Group (tên văn bản: Khu đô thị ven sông Hòa Quý – Đồng Nò, CTCP Địa Cầu): khoảng 26 ha, khoảng 390 biệt thự và townhouse kiến trúc Indochine, bốn mặt giáp sông; người nước ngoài được sở hữu tối đa 250 biệt thự.',
		'meta'    => array(
			'hh_p_status'        => 'dang-mo-ban',
			'hh_p_developer'     => 'Công ty Cổ phần Địa Cầu (thành viên Tập đoàn Sun Group)',
			'hh_p_type'          => 'Biệt thự đơn lập, biệt thự song lập, townhouse',
			'hh_p_address'       => 'Đảo Đồng Nò, phường Hòa Quý (cũ), Ngũ Hành Sơn, Đà Nẵng – bốn mặt giáp sông Đô Toả',
			'hh_p_scale'         => 'Khoảng 26 ha (có nguồn ghi 22 ha)',
			'hh_p_units'         => 'Khoảng 390 sản phẩm: khoảng 335 biệt thự đơn lập, song lập và 55 townhouse (các nguồn ghi 387 – 390)',
			'hh_p_ownership'     => 'Sở hữu lâu dài cho người Việt Nam; người nước ngoài sở hữu có thời hạn theo Luật Nhà ở',
			'hh_p_legal'         => 'Người nước ngoài được mua tối đa 250 / 390 biệt thự (đợt 4 – 11/2024)',
			'hh_p_start'         => 'Mở bán từ tháng 6/2022',
			'hh_p_handover'      => 'Kiểm tra theo từng căn',
			'hh_p_highlights'    => "Đảo Đồng Nò bốn mặt giáp sông, chỉ một phần nhỏ diện tích xây nhà – còn lại là cảnh quan, mặt nước\nKhoảng 390 biệt thự và townhouse kiến trúc Indochine, mật độ thấp\nMột trong số ít dự án biệt thự Đà Nẵng cho phép người nước ngoài sở hữu (tối đa 250 căn, đợt 4 – 11/2024)\nChủ đầu tư Sun Group – nằm giữa hệ sinh thái Sun Riverpolis, Sun NeO City phía Nam thành phố",
			'hh_p_zones'         => "Phân khu Habora | Biệt thự song lập, đơn lập | Phía Tây – Bắc đảo, dãy ven sông phía Bắc, các trục Ánh Dương 3 – 17 | Theo đợt mở bán\nPhân khu Centria | Townhouse, biệt thự song lập | Trục giữa đảo, hai dãy townhouse dọc Ánh Dương 1 – 5 | Theo đợt mở bán\nPhân khu Rivera | Biệt thự song lập, đơn lập | Phía Đông đảo, mũi đảo vòng quanh công viên nội khu | Theo đợt mở bán",
			'hh_p_design_desc'   => 'Đảo chia 3 phân khu: Habora (phía Tây – Bắc), Centria (trục giữa, có hai dãy townhouse) và Rivera (phía Đông, mũi đảo là vòng biệt thự đơn lập quanh công viên). Đường nội bộ mang tên Ánh Dương 1 – 17; vành ngoài đảo là công viên ven sông và đường dạo bộ. Hai cầu nối đảo: phía Bắc sang đường Chương D (hướng ra biển), phía Nam sang KĐT Nam Hòa Xuân.',
			'hh_p_amenities_in'  => "Công viên ven sông, đường dạo bộ quanh đảo\nCông viên nội khu ở mũi đảo và giữa phân khu Habora\nKhu thể thao\nKhu phát triển giáo dục\nNhà sinh hoạt cộng đồng, hồ bơi\nCảnh quan tiện ích",
			'hh_p_image_links'   => "plugin:img/sunneva-island/sunneva-island-phoi-canh-biet-thu-song-lap.jpg | Phối cảnh dãy biệt thự Sunneva Island Đà Nẵng | đại diện\nplugin:img/sunneva-island/sunneva-island-phoi-canh-biet-thu-goc.jpg | Phối cảnh biệt thự góc Sunneva Island | thư viện\nplugin:img/sunneva-island/sunneva-island-phoi-canh-biet-thu-xanh.jpg | Phối cảnh mặt tiền biệt thự Sunneva Island phong cách Đông Dương | thư viện\nplugin:img/sunneva-island/sunneva-island-mat-bang-chi-tiet.jpg | Sơ đồ mặt bằng Sunneva Island: phân khu Habora, Centria, Rivera | tổng thể",
			'hh_p_villa_desc'    => 'Biệt thự đơn lập và song lập ven sông, thiết kế Indochine. Giá dưới đây là mặt bằng chào bán các đợt trước theo trang phân phối – chỉ để tham khảo, giá chuyển nhượng hiện tại tùy vị trí, view sông và diện tích đất.',
			'hh_p_villa_table'   => "Biệt thự song lập | – | Ven sông, nội khu | Khoảng 32 – 45 tỷ (tham khảo)\nBiệt thự đơn lập | – | Ven sông, nội khu | Khoảng 35 – 60 tỷ (tham khảo)\nTownhouse | – | Nhà phố thương mại | Từ khoảng 31 tỷ (tham khảo)",
			'hh_p_location_desc' => 'Sunneva Island nằm trên đảo Đồng Nò thuộc phường Hòa Quý (cũ), quận Ngũ Hành Sơn – khu vực sông nước phía Nam Đà Nẵng, liền kề Sun Riverpolis (khu Đầm Sen) và đối diện Sun NeO City Hòa Xuân. Cầu nối đảo sang KĐT Nam Hòa Xuân, gần cầu Minh Mạng; từ đây theo đường Minh Mạng, Nguyễn Phước Lan kết nối về trung tâm, sân bay và biển Non Nước. Từ đảo nhìn về sông Hàn với cầu Tiên Sơn, Trần Thị Lý, cầu Rồng và bán đảo Sơn Trà.',
			'hh_p_connections'   => "Qua cầu | KĐT Nam Hòa Xuân, cầu Minh Mạng (phía Nam); đường Chương D (phía Bắc)\nLiền kề | Sun Riverpolis, khu Đầm Sen\n10 – 15 phút | Biển Non Nước, danh thắng Ngũ Hành Sơn\n15 phút | Trung tâm thành phố, sân bay quốc tế Đà Nẵng\n25 – 30 phút | Phố cổ Hội An",
			'hh_p_faq'           => "Sunneva Island là dự án nào trong văn bản nhà nước? | Trong văn bản của Đà Nẵng, dự án mang tên Khu đô thị ven sông Hòa Quý – Đồng Nò, chủ đầu tư Công ty CP Địa Cầu (Sun Group).\nNgười nước ngoài có mua được Sunneva Island không? | Có. Dự án nằm trong đợt 4 (11/2024) danh sách dự án cho phép người nước ngoài sở hữu, tối đa 250 trên 390 biệt thự. Trước khi đặt cọc cần hỏi chủ đầu tư hạn mức còn lại.\nSunneva Island ở đâu? | Đảo Đồng Nò, phường Hòa Quý (cũ), Ngũ Hành Sơn, Đà Nẵng – bốn mặt giáp sông Đô Toả, cạnh Sun Riverpolis.\nGiá biệt thự Sunneva Island bao nhiêu? | Theo mặt bằng chào bán các đợt trước: song lập khoảng 32 – 45 tỷ, đơn lập khoảng 35 – 60 tỷ (tham khảo). Liên hệ Hoàng Hiệp 0904 567 009 để nhận giỏ hàng mới.",
		),
		// Bản 2.20.19 chỉ có ảnh mặt bằng → thêm ảnh phối cảnh nếu chưa sửa tay.
		'fix_meta' => array(
			'hh_p_address' => 'Đảo Đồng Nò, phường Hòa Quý (cũ), Ngũ Hành Sơn, Đà Nẵng – bốn mặt giáp sông Đô Toả, cầu nối sang KĐT Nam Hòa Xuân và đường Chương D',
			'hh_p_handover' => 'Các nguồn ghi khác nhau (2023 – 2024) – kiểm tra tình trạng thực tế từng căn trước khi giao dịch',
			'hh_p_legal' => 'Có trong danh sách dự án người nước ngoài được sở hữu nhà ở – đợt 4 (11/2024): tối đa 250 / 390 biệt thự. Tên trong văn bản: Khu đô thị ven sông Hòa Quý – Đồng Nò, chủ đầu tư CTCP Địa Cầu',
			'hh_p_location_desc' => 'Sunneva Island nằm trên đảo Đồng Nò thuộc phường Hòa Quý (cũ), quận Ngũ Hành Sơn – khu vực sông nước phía Nam Đà Nẵng, liền kề Sun Riverpolis (khu Đầm Sen) và đối diện Sun NeO City Hòa Xuân. Từ đảo theo đường Minh Mạng, Nguyễn Phước Lan kết nối về trung tâm, sân bay và biển Non Nước.',
			'hh_p_connections' => "Cầu nội đảo | KĐT Nam Hòa Xuân (phía Nam), đường Chương D (phía Bắc)\nLiền kề | Sun Riverpolis, khu Đầm Sen\n10 – 15 phút | Biển Non Nước, danh thắng Ngũ Hành Sơn\n15 phút | Trung tâm thành phố, sân bay quốc tế Đà Nẵng\n25 – 30 phút | Phố cổ Hội An",
			'hh_p_image_links' => array( "plugin:img/sunneva-island/sunneva-island-phoi-canh-biet-thu-song-lap.jpg | Phối cảnh dãy biệt thự Sunneva Island Đà Nẵng | đại diện\nplugin:img/sunneva-island/sunneva-island-phoi-canh-biet-thu-goc.jpg | Phối cảnh biệt thự góc Sunneva Island | thư viện\nplugin:img/sunneva-island/sunneva-island-phoi-canh-biet-thu-xanh.jpg | Phối cảnh mặt tiền biệt thự Sunneva Island phong cách Đông Dương | thư viện\nplugin:img/sunneva-island/sunneva-island-so-do-mat-bang.jpg | Sơ đồ mặt bằng Sunneva Island: phân khu Habora, Centria, Rivera | tổng thể", "plugin:img/sunneva-island/sunneva-island-phoi-canh-biet-thu-song-lap.jpg | Phối cảnh dãy biệt thự Sunneva Island Đà Nẵng | đại diện\nplugin:img/sunneva-island/sunneva-island-phoi-canh-biet-thu-goc.jpg | Phối cảnh biệt thự góc Sunneva Island | thư viện\nplugin:img/sunneva-island/sunneva-island-phoi-canh-biet-thu-xanh.jpg | Phối cảnh mặt tiền biệt thự Sunneva Island phong cách Đông Dương | thư viện\nplugin:img/sunneva-island/sunneva-island-mat-bang-tong-the.jpg | Sơ đồ mặt bằng Sunneva Island: phân khu Habora, Centria, Rivera | tổng thể", "plugin:img/sunneva-island/sunneva-island-phoi-canh-biet-thu-song-lap.jpg | Phối cảnh dãy biệt thự Sunneva Island Đà Nẵng | đại diện\nplugin:img/sunneva-island/sunneva-island-phoi-canh-biet-thu-goc.jpg | Phối cảnh biệt thự góc Sunneva Island | thư viện\nplugin:img/sunneva-island/sunneva-island-mat-bang-tong-the.jpg | Sơ đồ mặt bằng Sunneva Island: phân khu Habora, Centria, Rivera | tổng thể", 'plugin:img/sunneva-island/sunneva-island-mat-bang-tong-the.jpg | Sơ đồ mặt bằng Sunneva Island: phân khu Habora, Centria, Rivera | tổng thể' ),
		),
		'sources' => array(
			'https://cafeland.vn/du-an/sunneva-island-khu-do-thi-sinh-thai-ven-song-tai-da-nang-3409.html',
			'https://reatimes.vn/khu-do-thi-ven-song-hoa-quy-dong-no-da-du-dieu-kien-de-huy-dong-von-202201224000023679.htm',
			'https://baodanang.vn/70-biet-thu-tai-du-an-khu-do-thi-ven-song-hoa-quy-dong-no-duoc-phep-mo-ban-3182458.html',
			'https://sungroupvn.com.vn/biet-thu-sunneva-island/',
			'https://datnenhoaxuan.com/sunneva-island-mon-qua-den-tu-mat-troi',
		),
		'content' => '<p><strong>Sunneva Island</strong> là khu biệt thự đảo của Sun Group trên đảo Đồng Nò, phường Hòa Quý (cũ), Ngũ Hành Sơn, Đà Nẵng. Trong văn bản của thành phố, dự án mang tên <strong>Khu đô thị ven sông Hòa Quý – Đồng Nò</strong>, chủ đầu tư Công ty Cổ phần Địa Cầu – thành viên Sun Group.</p>
<h2>Quy mô và sản phẩm</h2>
<p>Theo các nguồn công khai, dự án rộng khoảng 26 ha, gồm khoảng 390 sản phẩm: biệt thự đơn lập, biệt thự song lập và townhouse theo phong cách Indochine. Đảo chia 3 phân khu: <strong>Habora</strong> (phía Tây – Bắc), <strong>Centria</strong> (trục giữa, có hai dãy townhouse) và <strong>Rivera</strong> (phía Đông, mũi đảo là vòng biệt thự đơn lập quanh công viên). Đảo bốn mặt giáp sông Đô Toả nên phần lớn diện tích dành cho cảnh quan, mặt nước; mật độ xây dựng thấp. Dự án mở bán từ tháng 6/2022.</p>
<h2>Người nước ngoài được mua</h2>
<p>Tháng 11/2024, Đà Nẵng công bố đợt 4 danh sách dự án cho phép tổ chức, cá nhân nước ngoài sở hữu nhà ở. Khu đô thị ven sông Hòa Quý – Đồng Nò được sở hữu tối đa <strong>250 trên 390 biệt thự</strong>. Đây là số tối đa, không phải số căn còn lại – trước khi đặt cọc cần hỏi chủ đầu tư hạn mức còn trống. Xem đầy đủ các dự án tại bài <a href="/du-an-nguoi-nuoc-ngoai-duoc-mua-da-nang-2026/">Dự án người nước ngoài được mua tại Đà Nẵng</a>.</p>
<h2>Cạnh các dự án Sun Group phía Nam Đà Nẵng</h2>
<p>Sunneva Island liền kề <a href="/du-an/sun-riverpolis/">Sun Riverpolis</a> (khu <a href="/du-an/dat-nen-dam-sen-sun-riverpolis/">đất nền Đầm Sen</a>) và đối diện <a href="/du-an/sun-neo-city/">Sun NeO City</a> Hòa Xuân – cụm đô thị ven sông của Sun Group ở phía Nam Đà Nẵng. Từ đảo theo đường Minh Mạng, Nguyễn Phước Lan đi trung tâm, sân bay khoảng 15 phút, biển Non Nước khoảng 10 – 15 phút.</p>
<h2>Giá tham khảo</h2>
<p>Mặt bằng chào bán các đợt trước theo trang phân phối: biệt thự song lập khoảng 32 – 45 tỷ, đơn lập khoảng 35 – 60 tỷ, townhouse từ khoảng 31 tỷ. Giá chuyển nhượng hiện tại thay đổi theo vị trí, view sông và diện tích đất. Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận giỏ hàng và kiểm tra pháp lý từng căn.</p>',
	);
	return $projects;
}

/**
 * Sơ đồ mặt bằng tô lại theo mặt bằng tổng thể (sunneva-island-mat-bang-chi-tiet.jpg) thay các sơ đồ vẽ tay trước:
 * bỏ ảnh cũ khỏi "Ảnh mặt bằng tổng thể" một lần; ảnh mới được tải ngầm như các ảnh khác.
 */
add_action( 'admin_init', 'hh_sunneva_replace_old_plan' );
function hh_sunneva_replace_old_plan() {
	if ( get_option( 'hh_sunneva_plan_v3' ) ) {
		return;
	}
	$post = get_page_by_path( 'sunneva-island', OBJECT, 'du-an' );
	if ( ! $post ) {
		return;
	}
	$done = (array) get_post_meta( $post->ID, '_hh_img_links', true );
	$ids  = array_filter( array_map( 'absint', explode( ',', (string) get_post_meta( $post->ID, 'hh_p_masterplan_img', true ) ) ) );
	foreach ( array( 'sunneva-island-mat-bang-tong-the.jpg', 'sunneva-island-so-do-mat-bang.jpg' ) as $file ) {
		$old = (int) ( $done[ 'plugin:img/sunneva-island/' . $file ] ?? 0 );
		if ( $old ) {
			$ids = array_diff( $ids, array( $old ) );
			wp_delete_attachment( $old, true );
		}
	}
	update_post_meta( $post->ID, 'hh_p_masterplan_img', implode( ',', $ids ) );
	update_option( 'hh_sunneva_plan_v3', 1, false );
}
