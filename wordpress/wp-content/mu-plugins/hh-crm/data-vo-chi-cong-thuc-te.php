<?php
/**
 * 709 lô đất nền Võ Chí Công – Sun Group: ảnh thực tế anh Hiệp chụp (10/2026), giá rao theo vị trí,
 * chính sách theo tin rao, câu hỏi thường gặp. Chỉ thay ô còn giá trị web nhập lần trước (fix_meta / fix_title).
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$photos = array(
			'01-mat-tien-via-he-cay-xanh' => 'Mặt tiền đại lộ Võ Chí Công: vỉa hè, cây xanh, đèn đường đã hoàn thiện trước dãy lô Sun Group | đại diện',
			'02-dai-lo-vo-chi-cong'       => 'Đại lộ Võ Chí Công nhiều làn xe, dải phân cách cây xanh – một bên là dãy lô đất nền, bên kia là shophouse',
			'03-lo-b2-26-lo-11-15'        => 'Lô B2-26 (lô 11 – 15) đã san nền, cắm mốc ranh, giáp vỉa hè Võ Chí Công',
			'04-lo-b2-26-lo-16-20'        => 'Mốc lô B2-26 lô 16 – 20 mặt tiền Võ Chí Công',
			'05-day-lo-mat-tien'          => 'Dãy lô mặt tiền Võ Chí Công nhìn dọc tuyến, hàng cây trưởng thành',
			'06-lo-b2-25-lo-11-15'        => 'Lô B2-25 (lô 11 – 15), phía sau là khu dân cư hiện hữu Hòa Quý',
			'07-tuong-rao-sun-group'      => 'Tường rào Sun Group dọc đại lộ Võ Chí Công',
			'08-toan-canh-hai-ben-duong'  => 'Toàn cảnh hai bên đại lộ Võ Chí Công đoạn dự án Sun Group',
			'09-truong-mam-non-canh-du-an' => 'Trường mầm non đang hoàn thiện cạnh dãy lô mặt tiền Võ Chí Công',
			'10-lo-mat-tien-canh-truong'  => 'Lô mặt tiền Võ Chí Công đã san nền, cạnh trường mầm non',
			'11-mat-tien-nhin-doc-tuyen'  => 'Vỉa hè rộng, cây xanh và tủ điện hạ thế dọc dãy lô Võ Chí Công',
			'12-shophouse-doi-dien'       => 'Dãy shophouse đối diện bên kia đại lộ Võ Chí Công đang hoàn thiện',
		);
		$lines = array();
		foreach ( $photos as $file => $text ) {
			$parts   = explode( ' | ', $text );
			$where   = $parts[1] ?? 'tiến độ';
			$lines[] = "plugin:img/vo-chi-cong/dat-nen-vo-chi-cong-$file.jpg | {$parts[0]} (ảnh thực tế 10/2026) | $where" . ( 'đại diện' === $where ? '' : ' | Thực tế 10/2026' );
		}
		// Ảnh đại diện cũng đưa vào ảnh thực tế.
		$lines[] = 'plugin:img/vo-chi-cong/dat-nen-vo-chi-cong-01-mat-tien-via-he-cay-xanh.jpg | Mặt tiền đại lộ Võ Chí Công đã hoàn thiện hạ tầng (ảnh thực tế 10/2026) | tiến độ | Thực tế 10/2026';

		foreach ( $projects as $i => $p ) {
			if ( 'dat-nen-vo-chi-cong' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$old_title = $p['title'];
			$p['title']       = '709 lô đất nền Võ Chí Công – Sun Group';
			$p['fix_title']   = array( $old_title );
			$p['fix_excerpt'] = $p['excerpt'];
			$p['excerpt']     = '709 lô đất nền Sun Group mặt tiền và nội khu đại lộ Võ Chí Công (Hòa Quý, Ngũ Hành Sơn, Đà Nẵng), lô 100 – 125 m²; giá rao mặt tiền khoảng 79 – 90 triệu/m², nội khu 44 – 59 triệu/m². Ảnh thực tế 10/2026.';
			$new = array(
				'hh_p_name'          => '709 lô đất nền Võ Chí Công – Sun Group',
				'hh_p_address'       => 'Đại lộ Võ Chí Công, phường Hòa Quý cũ (nay phường Ngũ Hành Sơn), Đà Nẵng – gần cầu Khuê Đông, sông Đô Toả',
				'hh_p_type'          => 'Đất nền phân lô xây tự do (mặt tiền Võ Chí Công và nội khu đường 7,5 m)',
				'hh_p_price_m2'      => 'Mặt tiền khoảng 79 – 90 triệu/m²; nội khu khoảng 44 – 59 triệu/m² (giá rao tham khảo)',
				'hh_p_highlights'    => "Mặt tiền đại lộ Võ Chí Công – trục nối Hòa Quý, khu công nghệ cao, làng Đại học và ven biển\nHạ tầng mặt tiền đã xong: vỉa hè, cây xanh trưởng thành, đèn đường, tủ điện (ảnh thực tế 10/2026)\nLô đã san nền, cắm mốc theo block (B2-25, B2-26…)\nĐất nền phân lô xây tự do, tin rao ghi sổ từng lô\nGần AEON Mall, FPT City, biển Sơn Thủy",
				'hh_p_dat-nen_desc'  => 'Giá rao tham khảo theo vị trí (tổng hợp tin rao 2 – 4/2026, không phải bảng giá chủ đầu tư). Lô góc, lô gần công viên, view sông chưa đủ dữ liệu.',
				'hh_p_dat-nen_table' => "Mặt tiền Võ Chí Công (đường 34 m) | 100 – 125 m² | Ngang 5 m | Khoảng 79 – 90 triệu/m² (lô 100 m² khoảng 7,9 – 9 tỷ)\nNội khu đường 7,5 m (Hoàng Minh Mạng…) | 100 – 125 m² | Đối lưng Võ Chí Công | Khoảng 44 – 59 triệu/m² (lô 100 m² khoảng 4,5 – 5,9 tỷ)\nCặp liền kề nội khu | 230 m² | Ngang 10 m, đường 7,5 m | Khoảng 10 tỷ cả cặp (khoảng 43,5 triệu/m²)",
				'hh_p_progress'      => "3/2026 | Mở bán, nhận giữ chỗ 709 lô (theo tin rao)\n10/2026 | Hạ tầng mặt tiền Võ Chí Công hoàn thiện: vỉa hè, cây xanh, đèn đường; các lô đã san nền, cắm mốc; chưa có nhà xây trên dãy lô (ảnh thực tế Hoàng Hiệp chụp)",
			);
			$fix = array();
			foreach ( $new as $key => $value ) {
				$fix[ $key ] = array( (string) ( $p['meta'][ $key ] ?? '' ) );
			}
			$fix['hh_p_name'][] = $old_title;
			$p['fix_meta'] = $fix;
			$p['meta']     = array_merge(
				$p['meta'],
				$new,
				array(
					'hh_p_image_links' => implode( "\n", $lines ),
					'hh_p_policy'      => "Giữ chỗ khoảng 50 triệu/lô, hoàn lại nếu không mua (theo tin rao)\nNgân hàng hỗ trợ vay khoảng 70% (theo tin rao)\nCó tin ghi chủ đầu tư hỗ trợ thuế thu nhập cá nhân 2% – cần xác nhận trong hợp đồng\nChính sách thay đổi theo đợt – liên hệ để nhận bản mới nhất",
					'hh_p_faq'         => "709 lô đất nền Võ Chí Công nằm ở đâu? | Dọc đại lộ Võ Chí Công đoạn Hòa Quý (nay thuộc phường Ngũ Hành Sơn, Đà Nẵng), gần cầu Khuê Đông và sông Đô Toả, cách AEON Mall, FPT City vài phút.\nGiá đất nền Võ Chí Công Sun Group bao nhiêu? | Theo tin rao 2026: lô mặt tiền Võ Chí Công khoảng 79 – 90 triệu/m² (lô 100 m² khoảng 7,9 – 9 tỷ); lô nội khu đường 7,5 m khoảng 44 – 59 triệu/m² (khoảng 4,5 – 5,9 tỷ). Đây là giá rao tham khảo, chưa phải bảng giá chủ đầu tư.\nHạ tầng hiện nay thế nào? | Ảnh thực tế tháng 10/2026: đại lộ Võ Chí Công, vỉa hè, cây xanh, đèn đường, tủ điện đã hoàn thiện; các lô đã san nền, cắm mốc theo block, chưa có nhà xây trên dãy lô.\nĐất nền Võ Chí Công có sổ chưa? | Tin rao ghi sổ hồng từng lô, sở hữu lâu dài. Trước khi đặt cọc cần xem sổ bản gốc hoặc văn bản của chủ đầu tư về thời điểm ra sổ, và kiểm tra quy hoạch lô.\nMua lô mặt tiền hay nội khu? | Mặt tiền Võ Chí Công hợp kinh doanh, văn phòng, giá cao gần gấp đôi; nội khu đường 7,5 m yên tĩnh, hợp để ở, vốn thấp hơn.",
				)
			);
			$p['content'] = '<p><strong>709 lô đất nền Võ Chí Công</strong> là dự án đất nền phân lô của <strong>Sun Group</strong> dọc đại lộ Võ Chí Công, đoạn Hòa Quý (nay thuộc phường Ngũ Hành Sơn, Đà Nẵng), gần cầu Khuê Đông và sông Đô Toả. Lô phổ biến 100 – 125 m², ngang 5 m, gồm dãy mặt tiền Võ Chí Công và các lô nội khu đường 7,5 m; dự án nhận giữ chỗ từ khoảng tháng 3/2026.</p>
<h2>Hiện trạng thực tế tháng 10/2026</h2>
<p>Hoàng Hiệp đi khảo sát và chụp ảnh tại dự án: đại lộ Võ Chí Công nhiều làn xe, dải phân cách cây xanh; dọc dãy lô đã có vỉa hè, hàng cây trưởng thành, đèn đường và tủ điện hạ thế. Các lô đã được san nền và cắm mốc theo block (ví dụ B2-25, B2-26), chưa có nhà xây trên dãy lô. Đối diện bên kia đường là dãy shophouse đang hoàn thiện; cạnh dự án có trường mầm non đang xây và khu dân cư hiện hữu. Xem ảnh tại mục Tiến độ.</p>
<h2>Giá đất nền Võ Chí Công theo vị trí (tin rao 2026)</h2>
<table><thead><tr><th>Vị trí</th><th>Diện tích</th><th>Giá rao</th><th>Ghi chú</th></tr></thead><tbody>
<tr><td>Mặt tiền Võ Chí Công (đường 34 m)</td><td>100 m²</td><td>khoảng 7,9 – 9 tỷ</td><td>Khoảng 79 – 90 triệu/m²</td></tr>
<tr><td>Nội khu đường 7,5 m (Hoàng Minh Mạng…)</td><td>100 – 113 m²</td><td>khoảng 4,5 – 5,9 tỷ</td><td>Khoảng 44 – 59 triệu/m²</td></tr>
<tr><td>Cặp liền kề nội khu, ngang 10 m</td><td>230 m²</td><td>khoảng 10 tỷ</td><td>Khoảng 43,5 triệu/m²</td></tr>
</tbody></table>
<p>Đây là giá rao tổng hợp từ tin đăng tháng 2 – 4/2026, không phải bảng giá chính thức của chủ đầu tư. Để so sánh, đất tái định cư quanh Võ Chí Công (Bình Kỳ, Lê Đình Chinh, đường 7,5 m) đang rao khoảng 36 – 41 triệu/m² (10/2026).</p>
<h2>Chính sách theo tin rao</h2>
<ul>
<li>Giữ chỗ khoảng 50 triệu/lô, hoàn lại nếu không mua.</li>
<li>Ngân hàng hỗ trợ vay khoảng 70%.</li>
<li>Có tin ghi chủ đầu tư hỗ trợ thuế thu nhập cá nhân 2% – cần xác nhận trong hợp đồng.</li>
</ul>
<h2>Lưu ý khi mua</h2>
<p>Các nguồn ghi tên khu và địa giới chưa thống nhất (Hòa Quý hay Nam Hòa Xuân), chưa có văn bản công bố chính thức về pháp nhân chủ đầu tư từng lô. Trước khi đặt cọc nên xem hợp đồng, sổ hoặc cam kết ra sổ, sơ đồ phân lô và đi xem mốc lô thực tế.</p>
<p>Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận danh sách lô còn trống, sơ đồ phân lô và đi xem đất trực tiếp.</p>';
			$p['sources'] = array_values( array_unique( array_merge( $p['sources'] ?? array(), array(
				'https://homedy.com/ban-dat-nen-du-an-quan-ngu-hanh-son-da-nang/ngoai-giao-hang-cdt-lo-vo-chi-cong-lh-0768468754-es3195631',
				'https://alonhadat.com.vn/chinh-thuc-nhan-dat-cho-709-lo-dat-nen-vo-chi-cong-noi-dai-tu-chu-dau-tu-sun-group-18232835.html',
				'https://batdongsan.com.vn/ban-dat-duong-vo-chi-cong-phuong-hoa-quy-48/ban-709-lo-at-nen-truc-uong-lon-san-so-pr45255391',
				'https://muaban.net/bat-dong-san/ban-dat-quan-ngu-hanh-son-da-nang',
			) ) ) );
			$projects[ $i ] = $p;
		}
		return $projects;
	},
	60
);
