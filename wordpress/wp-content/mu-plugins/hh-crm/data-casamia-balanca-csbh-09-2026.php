<?php
/**
 * Casamia Balanca Hội An – chính sách bán hàng áp dụng từ 09/09/2026 (đến khi có CSBH thay thế), anh Hiệp gửi 16/11/2026:
 * 4 phương án Forestside Villa / Park Home × bàn giao thô (nhận nhà 2026) / bàn giao nội thất (nhận nhà 2027),
 * cam kết thuê từ 01/09/2026, tiến độ thanh toán vay / không vay, giá tham khảo Park Home full nội thất.
 * Ảnh: 5 ảnh chính sách của chủ đầu tư (không dùng bảng giá có logo đơn vị phân phối, không ghi mã căn).
 * Chạy sau data-casamia-balanca-anh.php (60).
 */

defined( 'ABSPATH' ) || exit;

function hh_casamia_csbh_0926_meta() {
	return array(
		'hh_p_offer_title'    => 'CSBH từ 09/09/2026: chiết khấu đến 4 tỷ khi nhận bàn giao thô, CĐT thuê lại 50 – 60 triệu/tháng, HTLS 0% 24 tháng',
		'hh_p_offer_deadline' => 'Áp dụng từ 09/09/2026 đến khi có chính sách thay thế',
		'hh_p_policy'         => implode(
			"\n",
			array(
				'Chính sách bán hàng áp dụng từ 09/09/2026 đến khi chủ đầu tư ban hành chính sách thay thế',
				'Đặt cọc 300 triệu đồng/căn; ký hợp đồng mua bán thanh toán 20% (tháng 9/2026)',
				'Forestside Villa bàn giao thô (nhận nhà 2026): chiết khấu 4 tỷ khi chọn bàn giao thô; chủ đầu tư trực tiếp thuê lại 60 triệu/tháng, hợp đồng thuê 3 năm; chiết khấu 2% khi thanh toán sớm 95%',
				'Forestside Villa bàn giao nội thất (nhận nhà 2027): chiết khấu 400 triệu khi nhận gói nội thất cơ bản; ủy thác chủ đầu tư vận hành cho thuê – 45% doanh thu cho thuê thuần, thu nhập tối thiểu 60 triệu/tháng, hợp đồng 5 năm, 10 đêm lưu trú miễn phí/năm (biệt thự đủ điều kiện vận hành); chiết khấu 4% khi thanh toán sớm 95%',
				'Park Home bàn giao thô (nhận nhà 2026): chủ đầu tư trực tiếp thuê lại 50 triệu/tháng, hợp đồng thuê 3 năm; chiết khấu 3,5 tỷ khi nhận bàn giao thô (quỹ căn theo danh sách chủ đầu tư); chiết khấu 5% khi thanh toán sớm 95%',
				'Park Home bàn giao nội thất (nhận nhà 2027): ủy thác chủ đầu tư vận hành – 45% doanh thu cho thuê thuần, thu nhập tối thiểu 50 triệu/tháng, hợp đồng 5 năm, 10 đêm lưu trú miễn phí/năm (quỹ 50 căn); chiết khấu 300 triệu khi nhận gói nội thất cơ bản; chiết khấu 5% khi thanh toán sớm 95%',
				'Forestside Villa: chiết khấu thêm 1% cho khách hàng thân thiết',
				'Miễn phí 2 năm phí quản lý khu đô thị và 1 năm Fitness & Pool tại Clubhouse Casamia',
				'Phương án không vay: khách thanh toán sớm hơn tiến độ được tính lãi suất 11%/năm cho phần thanh toán sớm',
				'Phương án vay: hỗ trợ vay 70%, hỗ trợ lãi suất 0% trong 24 tháng, ân hạn nợ gốc 24 tháng',
				'Cam kết thuê (từ 01/09/2026): biệt thự sân vườn 50 triệu/tháng – 5 năm nếu mua quỹ căn full nội thất của đơn vị khai thác, 3 năm nếu mua thô và tự hoàn thiện nội thất theo tiêu chuẩn chủ đầu tư; biệt thự rừng dừa 60 triệu/tháng – 3 năm kể từ khi bàn giao biệt thự full nội thất theo tiêu chuẩn chủ đầu tư',
			)
		),
		'hh_p_payment'        => implode(
			"\n",
			array(
				'Đặt cọc | 300 triệu/căn | Tất cả phân khu, phương án',
				'Forestside thô 2026 – không vay | 20% T9/26 (ký HĐMB) · 25% T10/26 · 25% T11/26 · 25% T12/26 (bàn giao) · 5% T1/27 (nhận GCN) | Thanh toán sớm tính lãi suất 11%/năm',
				'Forestside thô 2026 – vay | 20% T9/26 (ký HĐMB) · 10% T10/26 · 40% T11/26 · 25% T12/26 (bàn giao) · 5% T1/27 (nhận GCN) | Khách trả 30%, ngân hàng giải ngân từ T11/26',
				'Forestside nội thất 2027 – không vay | 20% T9/26 · 10% T10/26 · 10% T11/26 · 10% T12/26 · 5% mỗi tháng T1 – T4/27 · 25% T6/27 (bàn giao) · 5% nhận GCN | Thanh toán sớm tính lãi suất 11%/năm',
				'Forestside nội thất 2027 – vay | 20% T9/26 · 10% T10/26 · 40% T3/27 · 25% T6/27 (bàn giao) · 5% nhận GCN | Khách trả 30%, ngân hàng giải ngân từ T3/27',
				'Park Home thô 2026 – không vay | 20% T9/26 · 10% T11/26 · 20% T12/26 (bàn giao) · 5% mỗi tháng T1 – T9/27 · 5% T11/27 (nhận GCN) | Thanh toán sớm tính lãi suất 11%/năm',
				'Park Home thô 2026 – vay | 20% T9/26 · 10% T11/26 · 20% T12/26 (bàn giao) · 20% T1/27 · 25% T2/27 · 5% T6/27 (nhận GCN) | Khách trả 30%, ngân hàng giải ngân từ T12/26',
				'Park Home nội thất 2027 – không vay | 20% T9/26 · 10% T11/26 · 5% mỗi tháng T12/26 – T3/27 (bàn giao T3/27) · 10% mỗi tháng T4 – T7/27 · 5% T9/27 · 5% T11/27 (nhận GCN) | Thanh toán sớm tính lãi suất 11%/năm',
				'Park Home nội thất 2027 – vay | 20% T9/26 · 10% T11/26 · 10% T12/26 · 10% T3/27 (bàn giao) · 45% T4/27 · 5% T6/27 (nhận GCN) | Khách trả 30%, ngân hàng giải ngân từ T12/26',
			)
		),
		'hh_p_price_table'    => implode(
			"\n",
			array(
				'Park Home full nội thất | Đất 178 m², sàn 316,09 m² | Chỉ từ 13,86 tỷ (đã VAT) | Liên hệ Hoàng Hiệp nhận bảng giá từng căn',
				'Forestside Villa | Biệt thự rừng dừa | Liên hệ | Chiết khấu 4 tỷ khi nhận bàn giao thô',
			)
		),
	);
}

function hh_casamia_csbh_0926_html() {
	return <<<'HTML'

<h2>Chính sách bán hàng Casamia Balanca từ 09/09/2026</h2>
<p>Chủ đầu tư áp dụng chính sách mới từ 09/09/2026 đến khi có chính sách thay thế. Mỗi phân khu có 2 lựa chọn: <strong>nhận bàn giao thô (nhận nhà 2026)</strong> hoặc <strong>bàn giao nội thất (nhận nhà 2027)</strong>. Đặt cọc 300 triệu/căn, ký hợp đồng mua bán thanh toán 20%.</p>
<table>
<thead><tr><th>Phân khu – phương án</th><th>Ưu đãi chính</th><th>Cho thuê</th></tr></thead>
<tbody>
<tr><td>Forestside Villa – bàn giao thô 2026</td><td>Chiết khấu 4 tỷ; thanh toán sớm 95% chiết khấu 2%; khách thân thiết 1%</td><td>Chủ đầu tư thuê lại 60 triệu/tháng, 3 năm</td></tr>
<tr><td>Forestside Villa – nội thất 2027</td><td>Chiết khấu 400 triệu khi nhận gói nội thất cơ bản; thanh toán sớm 95% chiết khấu 4%; khách thân thiết 1%</td><td>Ủy thác vận hành: 45% doanh thu thuần, tối thiểu 60 triệu/tháng, 5 năm, 10 đêm nghỉ miễn phí/năm</td></tr>
<tr><td>Park Home – bàn giao thô 2026</td><td>Chiết khấu 3,5 tỷ (quỹ căn theo danh sách); thanh toán sớm 95% chiết khấu 5%</td><td>Chủ đầu tư thuê lại 50 triệu/tháng, 3 năm</td></tr>
<tr><td>Park Home – nội thất 2027</td><td>Chiết khấu 300 triệu khi nhận gói nội thất cơ bản; thanh toán sớm 95% chiết khấu 5%</td><td>Ủy thác vận hành (quỹ 50 căn): 45% doanh thu thuần, tối thiểu 50 triệu/tháng, 5 năm, 10 đêm/năm</td></tr>
</tbody>
</table>
<ul>
<li><strong>Không vay:</strong> thanh toán theo tiến độ, phần thanh toán sớm được tính lãi suất 11%/năm.</li>
<li><strong>Vay ngân hàng:</strong> hỗ trợ vay 70%, hỗ trợ lãi suất 0% trong 24 tháng, ân hạn nợ gốc 24 tháng – khách trả 30% (đặt cọc, 20% ký hợp đồng, 10%), phần còn lại ngân hàng giải ngân.</li>
<li><strong>Tất cả phân khu:</strong> miễn phí 2 năm phí quản lý khu đô thị, 1 năm Fitness &amp; Pool tại Clubhouse Casamia.</li>
</ul>
<p><strong>Park Home full nội thất</strong> (đất 178 m², sàn 316,09 m²) giá <strong>chỉ từ 13,86 tỷ</strong> (đã gồm VAT). Bảng giá từng căn, giá theo phương án vay và quỹ căn được chiết khấu 3,5 – 4 tỷ: liên hệ <strong>Hoàng Hiệp 0904 567 009</strong>.</p>
<p><em>Nhận định của Hoàng Hiệp:</em> mức thuê lại 50 – 60 triệu/tháng là cam kết theo chính sách của chủ đầu tư trong 3 – 5 năm, anh chị nên đọc kỹ điều kiện trong hợp đồng thuê / ủy thác (quỹ căn áp dụng, tiêu chuẩn nội thất, thời điểm bắt đầu tính). Khách mua để ở hoặc tự cho thuê có thể cân nhắc phương án bàn giao thô vì chiết khấu lớn (3,5 – 4 tỷ). Chính sách và quỹ căn thay đổi theo từng đợt – liên hệ <strong>Hoàng Hiệp 0904 567 009</strong> để nhận bảng hàng và bảng tính dòng tiền từng căn.</p>
HTML;
}

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		foreach ( $projects as $i => $p ) {
			if ( 'casamia-balanca-hoi-an' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$upd = hh_casamia_csbh_0926_meta();
			// Phân khu: thêm giá Park Home và ưu đãi (chỉ thay khi ô còn giá trị web tự nhập trước đây).
			$zones_old = (string) ( $p['meta']['hh_p_zones'] ?? '' );
			$upd['hh_p_zones'] = str_replace(
				array(
					'Park Home | Nhà phố vườn ven các công viên chủ đề | Theo bảng hàng | Liên hệ nhận bảng hàng',
				),
				array(
					'Park Home | Nhà phố vườn ven các công viên chủ đề – đất 178 m², sàn 316,09 m² | Full nội thất chỉ từ 13,86 tỷ (đã VAT) | CĐT thuê lại 50 triệu/tháng; chiết khấu 3,5 tỷ khi nhận thô',
				),
				$zones_old
			) . "\nForestside Villa | Biệt thự rừng dừa | Theo bảng hàng | CĐT thuê lại 60 triệu/tháng; chiết khấu 4 tỷ khi nhận thô";
			$projects[ $i ]['fix_meta'] = array( 'hh_p_zones' => array( $zones_old ) ) + ( $p['fix_meta'] ?? array() );
			$projects[ $i ]['meta']     = array_merge( $p['meta'], $upd );
			$projects[ $i ]['content']  = ( $p['content'] ?? '' ) . hh_casamia_csbh_0926_html();
			// 5 ảnh chính sách của chủ đầu tư → Thư viện ảnh.
			$links_old = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			$projects[ $i ]['meta']['hh_p_image_links'] = $links_old . "\n" . implode(
				"\n",
				array(
					'plugin:img/casamia-balanca/casamia-balanca-cam-ket-thue-09-2026.jpg | Casamia Balanca – chủ đầu tư cam kết thuê biệt thự sân vườn 50 triệu/tháng, biệt thự rừng dừa 60 triệu/tháng (từ 01/09/2026) | thư viện',
					'plugin:img/casamia-balanca/casamia-balanca-chinh-sach-forestside-ban-giao-tho-2026.jpg | Chính sách bán hàng Casamia Balanca phân khu Forestside Villa – bàn giao thô, nhận nhà 2026 (từ 09/09/2026) | thư viện',
					'plugin:img/casamia-balanca/casamia-balanca-chinh-sach-forestside-noi-that-2027.jpg | Chính sách bán hàng Casamia Balanca phân khu Forestside Villa – bàn giao nội thất, nhận nhà 2027 (từ 09/09/2026) | thư viện',
					'plugin:img/casamia-balanca/casamia-balanca-chinh-sach-park-home-ban-giao-tho-2026.jpg | Chính sách bán hàng Casamia Balanca phân khu Park Home – bàn giao thô, nhận nhà 2026 (từ 09/09/2026) | thư viện',
					'plugin:img/casamia-balanca/casamia-balanca-chinh-sach-park-home-noi-that-2027.jpg | Chính sách bán hàng Casamia Balanca phân khu Park Home – bàn giao nội thất, nhận nhà 2027 (từ 09/09/2026) | thư viện',
				)
			);
			$fm = $projects[ $i ]['fix_meta'];
			$fm['hh_p_image_links'] = array_merge( (array) ( $fm['hh_p_image_links'] ?? array() ), array( $links_old ) );
			$projects[ $i ]['fix_meta'] = $fm;
		}
		return $projects;
	},
	70
);
