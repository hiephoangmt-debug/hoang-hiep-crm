<?php
/**
 * Bài "Chính sách bán hàng" theo THÁNG và theo TỪNG DỰ ÁN (chuyên mục "Chính sách bán hàng", hiện ở trang
 * /chinh-sach-bang-tinh/). Mỗi tháng thêm 1 khối mới cho từng dự án (slug có tháng), không sửa bài tháng cũ.
 * Nội dung lấy từ hh_sun_policy_11_2026() (data-sun-chinh-sach-11-2026.php); phần giải thích từng dự án ($info)
 * chỉ dùng số liệu của chính sách và dữ liệu dự án trên web – không thêm ưu đãi.
 * Không nạp trong plugin – xuất vào wordpress/tu-dong/ bằng scripts/xuat-bai-tu-dong.php để web tự đăng.
 */

defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/data-sun-chinh-sach-11-2026.php';

add_filter( 'hh_news_posts', 'hh_posts_chinh_sach_ban_hang' );
function hh_posts_chinh_sach_ban_hang( $posts ) {
	$pol  = hh_sun_policy_11_2026();
	$cta  = '<p>Nhận phiếu tính giá theo đúng căn, so sánh phương án vay và thanh toán sớm: liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo). Xem chính sách tất cả dự án tại <a href="/chinh-sach-bang-tinh/">Chính sách &amp; bảng tính giá</a>.</p>';
	$tvpl = 'https://thuvienphapluat.vn/cong-dong-dan-luat/quy-dinh-moi-ve-dat-coc-thanh-toan-nha-o-hinh-thanh-trong-tuong-lai-215439.html';
	$list = static function ( $text ) {
		$li = '';
		foreach ( array_filter( array_map( 'trim', explode( "\n", $text ) ) ) as $line ) {
			$li .= '<li>' . htmlspecialchars( $line, ENT_QUOTES ) . '</li>';
		}
		return '<ul>' . $li . '</ul>';
	};
	$items = array(
		array( 'spana-tower', 'Spana Tower', 'spana-tower', 'chinh-sach-spana-tower-11-2026', '2026-11-05 16:30', '<!--hh-img:img/spana-tower/spana-tower-tien-do-11-2026-2-toa-ven-song-cau-hoa-xuan.jpg|Spana Tower thực tế tháng 11/2026 – hai tòa bên sông Cẩm Lệ (ảnh flycam)-->' ),
		array( 'cora-tower', 'Cora Tower', 'cora-tower', 'chinh-sach-cora-tower-11-2026', '2026-11-05 16:45', '' ),
		array( 's-light-tower', 'S-Light Tower', 's-light-tower', 'chinh-sach-s-light-tower-11-2026', '2026-11-05 17:00', '' ),
		array( 'fours-tower-f1-thap-tung', 'FourS Tower F1, F5', 'fours-tower-f1-thap-tung', 'chinh-sach-fours-f1-f5-11-2026', '2026-11-05 17:15', '' ),
		array( 'fours-tower-f2-thap-mai', 'FourS Tower F2', 'fours-tower-f2-thap-mai', 'chinh-sach-fours-f2-11-2026', '2026-11-05 17:30', '' ),
	);
	// Phần riêng từng dự án: giới thiệu, điểm riêng của chính sách, bảng phương án, pháp lý, nguồn, hỏi đáp, mô tả SEO.
	$info = array(
		'spana-tower'              => array(
			'intro'  => 'Spana Tower gồm 2 tòa S1, S2 (22 tầng + tum, 1.237 căn) ngay chân cầu Hòa Xuân, bàn giao dự kiến 30/06/2027.',
			'detail' => '<p>So với các tòa khác ở Sun NeO City, chính sách bán hàng Spana Tower tháng 11/2026 có hai điểm riêng: quà tặng an cư 3% và ưu đãi thêm 1 – 1,5% cho khách đã sở hữu bất động sản Sun theo hạng thành viên. Chiết khấu khi không vay là 5%; mức thanh toán sớm 95% được chiết khấu 6%, mức 70% được chiết khấu 1%, có hạn đến 25/11/2026.</p>
<p>Về tiến độ, khách đặt cọc 100 triệu (căn 3PN 150 triệu) và được giãn thanh toán đến 38 tháng. Spana Tower có mốc bàn giao dự kiến sớm nhất cụm Sun NeO City (30/06/2027), nên người cần nhận nhà để ở hoặc cho thuê sớm nên tính kỹ cùng Sun Early Key – thanh toán đủ 70% là nhận nhà sử dụng.</p>',
			'rows'   => array( array( 'Không vay ngân hàng', 'Chiết khấu thêm 5%' ), array( 'Thanh toán sớm 95% (hạn 25/11)', 'Chiết khấu 6%' ), array( 'Thanh toán sớm 70% (hạn 25/11)', 'Chiết khấu 1%' ), array( 'Vay tối đa 70%', 'Hỗ trợ lãi suất 24 tháng (không muộn hơn 30/6/2028), ân hạn gốc cùng thời gian' ) ),
			'legal'  => 'Theo dữ liệu dự án, Spana Tower đã được Sở Xây dựng xác nhận đủ điều kiện bán nhà ở hình thành trong tương lai (VB 7111/SXD-QLN ngày 05/5/2026), có bảo lãnh VietinBank.',
			'src'    => array( 'https://cafeland.vn/du-an/spana-tower-du-an-can-ho-tai-da-nang-5406.html', 'CafeLand' ),
			'faq'    => array(
				array( 'Chính sách bán hàng Spana Tower tháng 11/2026 có gì?', 'Quà tặng an cư 3%, không vay chiết khấu thêm 5%, thanh toán sớm 95% chiết khấu 6% (hạn 25/11/2026), cọc 100 triệu, giãn tiến độ đến 38 tháng, vay 70% hỗ trợ lãi suất 24 tháng, miễn phí quản lý 1 năm.' ),
				array( 'Đặt cọc Spana Tower bao nhiêu?', 'Theo chính sách bán hàng Spana Tower tháng 11/2026: 100 triệu, căn 3PN 150 triệu.' ),
				array( 'Spana Tower khi nào nhận nhà?', 'Bàn giao dự kiến 30/06/2027; thanh toán đủ 70% là nhận nhà sử dụng (Sun Early Key).' ),
			),
			'desc'   => 'Chính sách bán hàng Spana Tower tháng 11/2026: quà an cư 3%, không vay giảm 5%, thanh toán sớm hạn 25/11, cọc 100 triệu, hỗ trợ lãi suất 24 tháng.',
		),
		'cora-tower'               => array(
			'intro'  => 'Cora Tower gồm hai tòa A1, A2 tại giao lộ Nguyễn Phước Lan – đường 29/3, trung tâm Sun NeO City; căn hộ bàn giao dự kiến 30/07/2027.',
			'detail' => '<p>Chính sách bán hàng Cora Tower tháng 11/2026 tách riêng hai nhóm sản phẩm. Căn hộ A1, A2 áp dụng CSƯĐ 06.1 (từ 21/8/2026) với đặc quyền hoàn thiện nội thất 7%. Shop khối đế A1, A2 áp dụng CSƯĐ 06 (từ 17/8/2026): Early Bird 3% có thời hạn, hỗ trợ nội thất kinh doanh 4%, đặt cọc 300 triệu.</p>
<p>Với căn hộ, mức thanh toán sớm tháng này là 95% chiết khấu 7,5% và 70% chiết khấu 1,5% (hạn 25/11/2026); cọc 100 triệu (3PN 150 triệu, penthouse 300 triệu), giãn tiến độ đến 40 tháng. Shop khối đế có tiến độ chuẩn riêng: cọc, sau đó 15%, mỗi quý 10% đến 70% (nhận nhà 31/10/2027), tiếp theo 5% mỗi 4 tháng và 5% khi nhận sổ.</p>',
			'rows'   => array( array( 'Không vay ngân hàng', 'Chiết khấu thêm 5%' ), array( 'Thanh toán sớm 95% (hạn 25/11)', 'Chiết khấu 7,5%' ), array( 'Thanh toán sớm 70% (hạn 25/11)', 'Chiết khấu 1,5%' ), array( 'Vay tối đa 70%', 'Hỗ trợ lãi suất 24 tháng (không muộn hơn 30/9/2028), ân hạn gốc cùng thời gian' ) ),
			'legal'  => 'Căn hộ Cora Tower sở hữu lâu dài; anh chị nên đề nghị xem văn bản đủ điều kiện bán và thư bảo lãnh áp dụng cho đúng tòa A1 hoặc A2.',
			'src'    => array( 'https://cafeland.vn/du-an/sun-cora-tower-du-an-can-ho-tai-da-nang-4728.html', 'CafeLand' ),
			'faq'    => array(
				array( 'Chính sách bán hàng Cora Tower tháng 11/2026 có gì?', 'Căn hộ A1, A2: hoàn thiện nội thất 7%, không vay chiết khấu thêm 5%, thanh toán sớm 95% chiết khấu 7,5% (hạn 25/11/2026), cọc 100 triệu, giãn tiến độ đến 40 tháng, vay 70% hỗ trợ lãi suất 24 tháng.' ),
				array( 'Shop khối đế Cora Tower đặt cọc bao nhiêu?', 'Theo chính sách bán hàng Cora Tower (CSƯĐ 06), shop khối đế A1, A2 đặt cọc 300 triệu, có Early Bird 3% (có thời hạn) và hỗ trợ nội thất kinh doanh 4%.' ),
				array( 'Cora Tower khi nào nhận nhà?', 'Căn hộ bàn giao dự kiến 30/07/2027; shop khối đế nhận nhà khi thanh toán 70%, dự kiến 31/10/2027.' ),
			),
			'desc'   => 'Chính sách bán hàng Cora Tower tháng 11/2026: nội thất 7%, không vay giảm 5%, thanh toán sớm 95% giảm 7,5% hạn 25/11, shop khối đế cọc 300 triệu.',
		),
		's-light-tower'            => array(
			'intro'  => 'S-Light Tower là cặp tháp 22 tầng, gần 800 căn từ 33,3 đến 95,1 m² tại đường 29/3 giao Nguyễn Đình Thi, Sun NeO City; Sun Property ra mắt dự án tháng 6/2026.',
			'detail' => '<p>Chính sách bán hàng S-Light Tower tháng 11/2026 áp dụng CSBH 01/SL cho căn hộ (từ 9/7/2026) và penthouse (từ 17/8/2026). Điểm khác biệt là ưu đãi khi không lấy bảo lãnh ngân hàng: chiết khấu thêm 1% khi ký hợp đồng mua bán. Early Bird 3% có thời hạn, nên anh chị cần hỏi lại còn áp dụng hay không.</p>
<p>Mức thanh toán sớm tháng này cao nhất trong ba tòa Sun NeO City được tổng hợp: 95% chiết khấu 10%, 70% chiết khấu 3% (hạn 25/11/2026); không vay chiết khấu thêm 3%. Tiền cọc theo loại căn: Studio 100 triệu, 1PN+ 150 triệu, 2PN – 3PN 200 triệu, penthouse 300 triệu; giãn tiến độ đến 48 tháng.</p>
<p>Bảo lãnh ngân hàng là cơ chế bảo vệ người mua nhà ở hình thành trong tương lai. Trước khi chọn khoản chiết khấu 1% khi không lấy bảo lãnh, nên cân nhắc kỹ quyền lợi được bảo vệ nếu việc bàn giao chậm so với hợp đồng.</p>',
			'rows'   => array( array( 'Không vay ngân hàng', 'Chiết khấu thêm 3%' ), array( 'Thanh toán sớm 95% (hạn 25/11)', 'Chiết khấu 10%' ), array( 'Thanh toán sớm 70% (hạn 25/11)', 'Chiết khấu 3%' ), array( 'Không lấy bảo lãnh ngân hàng', 'Chiết khấu thêm 1% khi ký hợp đồng mua bán' ), array( 'Vay tối đa 70%', 'Hỗ trợ lãi suất 24 tháng (không muộn hơn 30/9/2028), ân hạn gốc cùng thời gian' ) ),
			'legal'  => 'Căn hộ S-Light Tower sở hữu lâu dài; mốc bàn giao theo hợp đồng từng căn.',
			'src'    => array( 'https://cafef.vn/sun-property-ra-mat-s-light-tower-tam-diem-vuong-khi-trung-tam-nam-da-nang-188260622082242751.chn', 'CafeF' ),
			'faq'    => array(
				array( 'Chính sách bán hàng S-Light Tower tháng 11/2026 có gì?', 'Thanh toán sớm 95% chiết khấu 10%, 70% chiết khấu 3% (hạn 25/11/2026), không vay chiết khấu thêm 3%, không lấy bảo lãnh chiết khấu thêm 1%, giãn tiến độ đến 48 tháng, vay 70% hỗ trợ lãi suất 24 tháng.' ),
				array( 'Đặt cọc S-Light Tower bao nhiêu?', 'Studio 100 triệu, 1PN+ 150 triệu, 2PN – 3PN 200 triệu, penthouse 300 triệu theo chính sách bán hàng S-Light Tower tháng 11/2026.' ),
				array( 'Có nên nhận chiết khấu 1% khi không lấy bảo lãnh?', 'Cần cân nhắc: bảo lãnh ngân hàng là cơ chế bảo vệ người mua nhà ở hình thành trong tương lai, nhất là khi bàn giao chậm so với hợp đồng.' ),
			),
			'desc'   => 'Chính sách bán hàng S-Light Tower tháng 11/2026: thanh toán sớm 95% giảm 10% hạn 25/11, không vay giảm 3%, cọc từ 100 triệu, giãn tiến độ 48 tháng.',
		),
		'fours-tower-f1-thap-tung' => array(
			'slug'   => 'chinh-sach-ban-hang-fours-tower-f1-f5-11-2026',
			'old'    => 'chinh-sach-ban-hang-fours-tower-f1-f5-thang-11-2026',
			'intro'  => 'Tòa F1 (Tháp Tùng) và F5 (Tháp Cúc) là hai tòa mở bán đầu tiên của FourS Tower từ tháng 3/2026, tại ngã tư Nguyễn Phước Lan – Minh Mạng; mỗi tòa 20 tầng, nhận nhà dự kiến 31/3/2028.',
			'detail' => '<p>Chính sách bán hàng FourS Tower F1, F5 tháng 11/2026 áp dụng CSBH 04/FT cho hợp đồng ký mới từ 8/8/2026, kèm hỗ trợ hoàn thiện nội thất 7%. Không vay được chiết khấu thêm 5%; thanh toán sớm 95% chiết khấu 9%, 70% chiết khấu 2,5% (hạn 25/11/2026). Cọc 100 triệu (3PN 150 triệu), giãn tiến độ đến 45 tháng.</p>
<p>Hai tòa F1 và F5 dùng chung một chính sách, nên khác biệt khi chọn nằm ở loại căn. Theo bảng giá dự kiến, F1 có Studio 30,5 m², 1PN+1 53,8 m² và 2PN khoảng 64 m²; F5 có nhiều căn 1PN+ 45 – 48 m² và căn 3PN khoảng 93 m². Xem thêm <a href="/du-an/fours-tower-f5-thap-cuc/">Tòa F5 – Tháp Cúc</a>.</p>',
			'rows'   => array( array( 'Không vay ngân hàng', 'Chiết khấu thêm 5%' ), array( 'Thanh toán sớm 95% (hạn 25/11)', 'Chiết khấu 9%' ), array( 'Thanh toán sớm 70% (hạn 25/11)', 'Chiết khấu 2,5%' ), array( 'Vay tối đa 70%', 'Hỗ trợ lãi suất 24 tháng (không muộn hơn 31/10/2028), ân hạn gốc cùng thời gian' ) ),
			'legal'  => 'Theo dữ liệu dự án, pháp lý chung 4 tòa FourS Tower: đủ điều kiện bán, sổ từng lô, bảo lãnh Techcombank.',
			'src'    => array( 'https://vnexpress.net/sun-group-ra-mat-khu-can-ho-fours-tower-tai-nam-da-nang-5052323.html', 'VnExpress' ),
			'faq'    => array(
				array( 'Chính sách bán hàng FourS Tower F1, F5 tháng 11/2026 có gì?', 'Hỗ trợ hoàn thiện nội thất 7%, không vay chiết khấu thêm 5%, thanh toán sớm 95% chiết khấu 9% (hạn 25/11/2026), cọc 100 triệu, giãn tiến độ đến 45 tháng, vay 70% hỗ trợ lãi suất 24 tháng.' ),
				array( 'Tòa F1, F5 FourS Tower là tháp nào?', 'F1 là Tháp Tùng (Mùa Đông), F5 là Tháp Cúc (Mùa Thu) – hai trong 4 tháp Mai, Trúc, Cúc, Tùng của FourS Tower.' ),
				array( 'Khi nào nhận nhà F1, F5?', 'Dự kiến 31/3/2028 khi đã thanh toán đủ 70% theo chính sách bán hàng FourS Tower F1, F5 (Sun Early Key).' ),
			),
			'desc'   => 'Chính sách bán hàng FourS Tower F1, F5 tháng 11/2026: nội thất 7%, không vay giảm 5%, thanh toán sớm 95% giảm 9% hạn 25/11, cọc 100 triệu.',
		),
		'fours-tower-f2-thap-mai'  => array(
			'slug'   => 'chinh-sach-ban-hang-fours-tower-f2-11-2026',
			'old'    => 'chinh-sach-ban-hang-fours-tower-f2-thap-mai-thang-11-2026',
			'intro'  => 'Tòa F2 – Tháp Mai (Mùa Xuân) ra mắt ngày 26/9/2026, cao 20 tầng nổi, 2 tầng hầm tại ngã tư Nguyễn Phước Lan – Minh Mạng; bàn giao sử dụng dự kiến 31/5/2028 khi đã thanh toán 70%.',
			'detail' => '<p>Chính sách bán hàng FourS Tower F2 áp dụng CSBH 4.2/FT (từ 26/9/2026). Thay cho hỗ trợ nội thất theo phần trăm, F2 có quà nội thất Nhà Xinh theo loại căn: Studio 35 triệu, 1PN/1PN+ 50 triệu, 2PN 75 triệu, 3PN 100 triệu. Không vay được chiết khấu thêm 3%; miễn phí quản lý 2 năm – dài hơn các tòa khác trong chuyên mục tháng này.</p>
<p>Mức thanh toán sớm tháng 11/2026 của F2 chưa có trong văn bản đã tổng hợp – anh chị liên hệ để cập nhật; mức áp dụng trước 25/10/2026 là 95% chiết khấu 12%, 70% chiết khấu 5%, 50% chiết khấu 2,5%. Cọc 100 triệu (3PN 150 triệu), giãn tiến độ đến 45 tháng; vay tối đa 70%, hỗ trợ lãi suất 24 tháng, không muộn hơn 31/1/2029.</p>',
			'rows'   => array( array( 'Không vay ngân hàng', 'Chiết khấu thêm 3%' ), array( 'Thanh toán sớm', 'Mức tháng 11/2026: liên hệ (trước 25/10: 95% – 12%, 70% – 5%, 50% – 2,5%)' ), array( 'Quà nội thất Nhà Xinh', 'Studio 35 triệu, 1PN/1PN+ 50 triệu, 2PN 75 triệu, 3PN 100 triệu' ), array( 'Vay tối đa 70%', 'Hỗ trợ lãi suất 24 tháng (không muộn hơn 31/1/2029), ân hạn gốc cùng thời gian' ) ),
			'legal'  => 'Theo dữ liệu dự án, pháp lý chung 4 tòa FourS Tower: đủ điều kiện bán, sổ từng lô, bảo lãnh Techcombank.',
			'src'    => array( 'https://vnexpress.net/thap-f2-fours-tower-ghi-nhan-gan-1-400-luot-dat-cho-5125919.html', 'VnExpress' ),
			'faq'    => array(
				array( 'Chính sách bán hàng FourS Tower F2 tháng 11/2026 có gì?', 'Quà nội thất Nhà Xinh 35 – 100 triệu theo loại căn, không vay chiết khấu thêm 3%, cọc 100 triệu, giãn tiến độ đến 45 tháng, vay 70% hỗ trợ lãi suất 24 tháng, miễn phí quản lý 2 năm.' ),
				array( 'Mức thanh toán sớm của FourS Tower F2 tháng 11/2026 là bao nhiêu?', 'Chưa có trong văn bản đã tổng hợp – liên hệ để cập nhật. Mức trước 25/10/2026: 95% chiết khấu 12%, 70% chiết khấu 5%, 50% chiết khấu 2,5%.' ),
				array( 'FourS Tower F2 khi nào nhận nhà?', 'Bàn giao sử dụng dự kiến 31/5/2028 khi đã thanh toán 70% theo chính sách bán hàng FourS Tower F2 (Sun Early Key).' ),
			),
			'desc'   => 'Chính sách bán hàng FourS Tower F2 tháng 11/2026: quà nội thất Nhà Xinh 35 – 100 triệu, không vay giảm 3%, miễn phí quản lý 2 năm, cọc 100 triệu.',
		),
	);
	foreach ( $items as list( $key, $name, $project, $img, $when, $extra ) ) {
		$in   = $info[ $key ];
		$kw   = 'Chính sách bán hàng ' . $name;
		$rows = '';
		foreach ( $in['rows'] as $row ) {
			$rows .= '<tr><td>' . $row[0] . '</td><td>' . $row[1] . '</td></tr>';
		}
		$src  = '<a href="' . $in['src'][0] . '">' . $in['src'][1] . '</a>';
		$post = array(
			'slug'     => $in['slug'] ?? 'chinh-sach-ban-hang-' . $project . '-thang-11-2026',
			'title'    => $kw . ' tháng 11/2026',
			'excerpt'  => $kw . ' áp dụng tháng 11/2026: chiết khấu không vay, thanh toán sớm (hạn 25/11), đặt cọc, giãn tiến độ, hỗ trợ lãi suất, Sun Early Key.',
			'keyword'  => 'chính sách bán hàng ' . $name,
			'project'  => $project,
			'schedule' => $when,
			'category' => 'Chính sách bán hàng',
			'tags'     => array( $name, 'Chính sách bán hàng', 'Sun Group' ),
			'image'    => 'plugin:img/tin-tuc/' . $img . '.jpg',
			'image_alt' => 'Tóm tắt chính sách bán hàng ' . $name . ' tháng 11/2026',
			'content'  => '<p><strong>' . $kw . '</strong> tháng 11/2026 được tổng hợp theo văn bản của chủ đầu tư, áp dụng cho dự án <a href="/du-an/' . $project . '/">' . $name . '</a>. ' . $in['intro'] . ' Mức thanh toán sớm có hạn đến <strong>25/11/2026</strong> và thay đổi theo tháng.</p>
<!--hh-featured-->
<h2>' . $kw . ' tháng 11/2026</h2>
' . $list( $pol[ $key ] ) . '
' . $extra . '
<h2>Điểm riêng của chính sách bán hàng ' . $name . '</h2>
' . $in['detail'] . '
<h2>Cách đọc chính sách bán hàng ' . $name . '</h2>
<ul>
<li><strong>Chiết khấu tính trên giá chưa VAT và phí bảo trì:</strong> khi so sánh, hãy quy các mức chiết khấu về cùng một giá gốc, không tính trên giá đã gồm thuế.</li>
<li><strong>Sun Early Key:</strong> thanh toán đủ 70% là nhận nhà sử dụng; phần còn lại đóng theo tiến độ trong hợp đồng.</li>
<li><strong>Trả trước hạn từng đợt (sớm ít nhất 10 ngày):</strong> được hưởng 8%/năm trên khoản trả trước.</li>
<li><strong>5% cuối:</strong> đóng khi bàn giao, chủ đầu tư trả lãi 8%/năm trên khoản này.</li>
</ul>
<p>Các ưu đãi trong chính sách bán hàng ' . $name . ' có điều kiện và thời hạn riêng, có khoản không áp dụng đồng thời với khoản khác. Trước khi đặt cọc, nên yêu cầu phiếu tính giá ghi rõ từng khoản chiết khấu đã áp dụng cho đúng căn.</p>
<h2>So sánh phương án trong chính sách bán hàng ' . $name . '</h2>
<table>
<thead><tr><th>Phương án</th><th>Ưu đãi tháng 11/2026</th></tr></thead>
<tbody>' . $rows . '</tbody>
</table>
<p>Nguyên tắc chung: nếu có sẵn tiền nhàn rỗi, phương án thanh toán sớm cho chiết khấu cao nhất; nếu muốn giữ vốn, phương án vay 70% kèm hỗ trợ lãi suất giúp giảm áp lực trong giai đoạn xây dựng, nhưng cần tính khả năng trả nợ khi hết thời gian hỗ trợ. Hoàng Hiệp có thể lập bảng so sánh tổng tiền theo từng phương án của chính sách bán hàng ' . $name . ' cho đúng căn anh chị chọn.</p>
<h2>Pháp lý cần đối chiếu khi áp dụng chính sách bán hàng ' . $name . '</h2>
<p>Căn hộ đang bán là nhà ở hình thành trong tương lai. Theo Luật Kinh doanh bất động sản 2023, tiền đặt cọc không quá 5% giá bán, thanh toán lần đầu không quá 30% và tổng thanh toán trước bàn giao không quá 70% giá trị hợp đồng – tóm tắt có trên <a href="' . $tvpl . '">Thư Viện Pháp Luật</a>. ' . $in['legal'] . ' Thông tin tổng quan dự án có thể tham khảo thêm trên ' . $src . '.</p>
<h2>Tính tiền từng đợt</h2>
<p>Để áp dụng chính sách bán hàng ' . $name . ' vào căn cụ thể, dùng <a href="/du-an/' . $project . '/bang-tinh/">bảng tính giá ' . $name . '</a>: nhập giá căn, chọn phương án (không vay, vay ngân hàng, thanh toán sớm) và xem số tiền từng đợt. Chính sách các tháng trước và các dự án khác: <a href="/chinh-sach-bang-tinh/#' . $project . '">Chính sách &amp; bảng tính giá</a>.</p>
' . $cta . '
<p class="src">Nguồn: văn bản chính sách bán hàng ' . $name . ' và phiếu tính giá của chủ đầu tư (11/2026). Thông tin tham khảo, có thể thay đổi theo từng đợt.</p>',
			'seo'      => array(
				'seo_title' => mb_substr( $kw . ' tháng 11/2026', 0, 58 ),
				'desc'      => $in['desc'],
				'points'    => array_merge(
					array( $kw . ' tháng 11/2026 – mức thanh toán sớm có hạn đến 25/11/2026' ),
					array_slice( array_values( array_filter( array_map( 'trim', explode( "\n", $pol[ $key ] ) ) ) ), 0, 3 )
				),
				'faq'       => $in['faq'],
			),
			'sources'  => array( $in['src'][0], $tvpl ),
		);
		if ( ! empty( $in['old'] ) ) {
			$post['old_slug'] = array( $in['old'] );
		}
		$posts[] = $post;
	}
	return $posts;
}
