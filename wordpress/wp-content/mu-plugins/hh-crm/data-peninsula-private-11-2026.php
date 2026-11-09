<?php
/**
 * Peninsula Private Đà Nẵng – cập nhật 09/11/2026 từ bộ tài liệu anh Hiệp gửi:
 * 10 phối cảnh, 15 mặt bằng tầng (đã xóa logo đơn vị phân phối), 8 ảnh tiến độ thực tế 10/2026 (đã cắt dải trên có logo),
 * pháp lý theo Quyết định 1476/QĐ-UBND ngày 15/7/2026 của UBND phường Hòa Cường (điều chỉnh QH chi tiết 1/500).
 * Sửa: bỏ tên đơn vị phân phối khỏi mô tả, điểm nổi bật, tiến độ, bài giới thiệu; sửa ô sở hữu cho đúng văn bản quy hoạch
 * (căn hộ dịch vụ, khách sạn kết hợp thương mại dịch vụ – không có tính chất ở).
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$slug = 'peninsula-private-da-nang';
		$im   = static fn( $f, $alt, $where, $title = '' ) => "plugin:img/peninsula-private/peninsula-private-$f.jpg | $alt | $where" . ( $title ? " | $title" : '' );
		$imgs = array(
			$im( 'phoi-canh-toa-thap-hoang-hon', 'Peninsula Private Đà Nẵng lúc hoàng hôn (phối cảnh chủ đầu tư)', 'đại diện' ),
			$im( 'phoi-canh-sanh-va-khoi-de', 'Sảnh và khối đế thương mại Peninsula Private (phối cảnh)', 'thư viện' ),
			$im( 'phoi-canh-toa-thap-ve-dem', 'Tòa tháp Peninsula Private về đêm (phối cảnh)', 'thư viện' ),
			$im( 'phoi-canh-toan-canh-song-han', 'Peninsula Private nhìn từ trên cao, hướng sông Hàn (phối cảnh)', 'tổng thể' ),
			$im( 'phoi-canh-toa-thap-tren-cao', 'Tòa tháp và hồ bơi vô cực tầng thượng nhìn từ trên cao (phối cảnh)', 'thư viện' ),
			$im( 'phoi-canh-mat-ben-toa-thap', 'Mặt bên tòa tháp Peninsula Private (phối cảnh)', 'thư viện' ),
			$im( 'phoi-canh-toa-thap-goc-thap', 'Tòa tháp nhìn từ dưới lên (phối cảnh)', 'thư viện' ),
			$im( 'phoi-canh-toa-thap-anh-chieu', 'Tòa tháp dưới nắng chiều (phối cảnh)', 'thư viện' ),
			$im( 'phoi-canh-toa-thap-nhin-len', 'Khối đế và tòa tháp nhìn từ đường Doãn Khuê (phối cảnh)', 'thư viện' ),
			$im( 'phoi-canh-toa-thap-ban-ngay', 'Peninsula Private ban ngày (phối cảnh)', 'thư viện' ),
			$im( 'mat-bang-tang-ham', 'Mặt bằng 3 tầng hầm Peninsula Private', 'mặt bằng', 'Tầng hầm' ),
			$im( 'mat-bang-tang-1', 'Mặt bằng tầng 1: sảnh, thương mại dịch vụ, sân vườn', 'mặt bằng', 'Tầng 1' ),
			$im( 'mat-bang-tang-2', 'Mặt bằng tầng 2', 'mặt bằng', 'Tầng 2' ),
			$im( 'mat-bang-tang-3', 'Mặt bằng tầng 3', 'mặt bằng', 'Tầng 3' ),
			$im( 'mat-bang-tang-5-tien-ich', 'Mặt bằng tầng 5: hồ bơi người lớn 301 m², bể trẻ em, jacuzzi, gym – spa – yoga 585 m², cafe', 'mặt bằng', 'Tầng 5' ),
			$im( 'mat-bang-tang-6', 'Mặt bằng căn hộ tầng 6: Deluxe Studio, Premier Suite 1PN, Executive Residence 2PN', 'mặt bằng', 'Tầng 6' ),
			$im( 'mat-bang-tang-7-20', 'Mặt bằng căn hộ tầng 7 – 20', 'mặt bằng', 'Tầng 7 – 20' ),
			$im( 'mat-bang-tang-12a', 'Mặt bằng căn hộ tầng 12A', 'mặt bằng', 'Tầng 12A' ),
			$im( 'mat-bang-tang-21-tien-ich', 'Mặt bằng tầng 21: tiện ích, vườn trên cao', 'mặt bằng', 'Tầng 21' ),
			$im( 'mat-bang-tang-22-29', 'Mặt bằng căn hộ tầng 22 – 29', 'mặt bằng', 'Tầng 22 – 29' ),
			$im( 'mat-bang-tang-28', 'Mặt bằng căn hộ tầng 28', 'mặt bằng', 'Tầng 28' ),
			$im( 'mat-bang-tang-30-37', 'Mặt bằng căn hộ tầng 30 – 37', 'mặt bằng', 'Tầng 30 – 37' ),
			$im( 'mat-bang-tang-38', 'Mặt bằng tầng 38: Signature Sky Villa', 'mặt bằng', 'Tầng 38' ),
			$im( 'mat-bang-tang-39', 'Mặt bằng tầng 39: Signature Sky Villa', 'mặt bằng', 'Tầng 39' ),
			$im( 'mat-bang-tang-40-tien-ich', 'Mặt bằng tầng 40: hồ bơi vô cực, Sky Bar, Sky Garden', 'mặt bằng', 'Tầng 40' ),
			$im( 'tien-do-10-2026-cong-truong', 'Ảnh thực tế tháng 10/2026: công trường Peninsula Private', 'tiến độ', 'Thực tế 10/2026' ),
			$im( 'tien-do-10-2026-may-khoan-coc', 'Ảnh thực tế tháng 10/2026: thi công cọc, cốt thép móng', 'tiến độ', 'Thực tế 10/2026' ),
			$im( 'tien-do-10-2026-thep-mong', 'Ảnh thực tế tháng 10/2026: tập kết thép thi công móng', 'tiến độ', 'Thực tế 10/2026' ),
			$im( 'tien-do-10-2026-buoc-thep', 'Ảnh thực tế tháng 10/2026: công nhân buộc thép', 'tiến độ', 'Thực tế 10/2026' ),
			$im( 'tien-do-10-2026-cong-truong-nhin-sun-wheel', 'Ảnh thực tế tháng 10/2026: công trường, phía sau là vòng quay Sun Wheel', 'tiến độ', 'Thực tế 10/2026' ),
			$im( 'tien-do-10-2026-thi-cong-mong', 'Ảnh thực tế tháng 10/2026: thi công lồng thép móng', 'tiến độ', 'Thực tế 10/2026' ),
			$im( 'tien-do-10-2026-may-thi-cong', 'Ảnh thực tế tháng 10/2026: máy thi công trên công trường', 'tiến độ', 'Thực tế 10/2026' ),
			$im( 'tien-do-10-2026-cong-truong-goc-khac', 'Ảnh thực tế tháng 10/2026: góc khác của công trường', 'tiến độ', 'Thực tế 10/2026' ),
		);
		$new = array(
			'hh_p_ownership'  => 'Sở hữu có thời hạn 50 năm – căn hộ dịch vụ trên đất thương mại dịch vụ (theo Quyết định 1476/QĐ-UBND ngày 15/7/2026: căn hộ dịch vụ, khách sạn kết hợp thương mại dịch vụ, không có tính chất ở)',
			'hh_p_scale'      => 'Khu đất 4.587 m²; đất xây dựng công trình 2.397,6 m²',
			'hh_p_density'    => '52,27% (điều chỉnh quy hoạch 7/2026)',
			'hh_p_floors'     => '40 tầng nổi và tum, 3 tầng hầm',
			'hh_p_legal'      => "Quyết định 1476/QĐ-UBND ngày 15/7/2026 của UBND phường Hòa Cường phê duyệt điều chỉnh quy hoạch chi tiết 1/500 (Lô A – Khu phức hợp căn hộ dịch vụ Peninsula Private): hệ số sử dụng đất 12,1 lần, mật độ xây dựng 52,27%, 40 tầng + tum, 3 tầng hầm\nChức năng: căn hộ dịch vụ, khách sạn kết hợp thương mại dịch vụ – không có tính chất ở, căn hộ lưu trú cho thuê\nĐã có quyết định chủ trương đầu tư (2017), quy hoạch chi tiết 1/500 Khu đô thị phức hợp Halla Jade Residence và giấy chứng nhận quyền sử dụng đất của chủ đầu tư",
			'hh_p_highlights' => "Tòa tháp cao khoảng 149,9 m, 40 tầng nổi tại phường Hòa Cường\nGần LOTTE Mart, view sông Hàn – biển Đông và Đà Nẵng Downtown\nTầng 5: hồ bơi người lớn 301 m², bể trẻ em, jacuzzi, gym – spa – yoga 585 m²\nTầng 40: hồ bơi vô cực, Sky Bar, Sky Garden\nKhởi công 8/2025, tháng 10/2026 đang thi công móng",
			'hh_p_progress'   => "2/8/2025 | Khởi công, động thổ\n15/7/2026 | Duyệt điều chỉnh quy hoạch chi tiết 1/500 (QĐ 1476/QĐ-UBND)\n8/2026 | Mở bán, nhận booking\n10/2026 | Thi công cọc và móng",
			'hh_p_policy'     => 'Theo thông tin bán hàng 8/2026: booking 50 triệu áp dụng cho 158 suất đầu tiên từ 01/8/2026, miễn phí quản lý 2 năm; ngân hàng hỗ trợ vay đến 70% giá trị căn hộ, có gói 0% lãi suất trong 24 tháng. Chính sách thay đổi theo từng đợt – hỏi Hoàng Hiệp chính sách hiện hành.',
		);
		$excerpt = 'Peninsula Private Đà Nẵng – tòa căn hộ dịch vụ sở hữu 50 năm, cao khoảng 150 m tại Vũ Duy Thanh – Doãn Khuê, phường Hòa Cường: 3 hầm, 40 tầng nổi, 624 căn studio đến 3PN và Sky Villa, giá từ khoảng 65 triệu/m², đang thi công móng (10/2026).';
		foreach ( $projects as $i => $p ) {
			if ( $slug !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			foreach ( $new as $k => $v ) {
				$cur = (string) ( $p['meta'][ $k ] ?? ( function_exists( 'hh_project_enrichment' ) ? ( hh_project_enrichment()[ $slug ]['meta'][ $k ] ?? '' ) : '' ) );
				if ( '' !== $cur && $cur !== $v ) {
					$p['fix_meta'][ $k ]   = (array) ( $p['fix_meta'][ $k ] ?? array() );
					$p['fix_meta'][ $k ][] = $cur;
				}
				if ( 'hh_p_ownership' === $k ) { // Bản 2.20.226 đã nhập (chưa ghi 50 năm).
					$p['fix_meta'][ $k ]   = (array) ( $p['fix_meta'][ $k ] ?? array() );
					$p['fix_meta'][ $k ][] = 'Theo Quyết định 1476/QĐ-UBND (15/7/2026), công trình là căn hộ dịch vụ, khách sạn kết hợp thương mại dịch vụ trên đất quy hoạch "Thương mại dịch vụ" – không có tính chất ở (chỉ lưu trú, không cư trú). Thời hạn sở hữu theo giấy chứng nhận và hợp đồng mua bán – hỏi Hoàng Hiệp để đối chiếu trước khi mua.';
				}
				$p['meta'][ $k ] = $v;
			}
			$p['fix_excerpt'] = array_values( array_filter( array( (string) ( $p['excerpt'] ?? '' ), 'Peninsula Private Đà Nẵng – tòa căn hộ dịch vụ cao khoảng 150 m tại Vũ Duy Thanh – Doãn Khuê, phường Hòa Cường: 3 hầm, 40 tầng nổi, 624 căn studio đến 3PN và Sky Villa, giá từ khoảng 65 triệu/m², đang thi công móng (10/2026).' ) ) ); // Bản gốc và bản 2.20.226.
			$p['excerpt'] = $excerpt;
			$old = (string) ( $p['content'] ?? '' );
			$fix = preg_replace( '/Ngày 9\/7\/2026, Đất Xanh Miền Trung trở thành đơn vị phân phối chính thức\.\s*/u', '', $old );
			$fix = str_replace( 'Căn hộ sở hữu lâu dài; thời điểm bàn giao chưa được công bố chính thức.', 'Ngày 15/7/2026, UBND phường Hòa Cường duyệt điều chỉnh quy hoạch chi tiết 1/500: công trình là căn hộ dịch vụ, khách sạn kết hợp thương mại dịch vụ (không có tính chất ở); tháng 10/2026 đang thi công cọc và móng. Thời điểm bàn giao chưa được công bố chính thức.', $fix );
			$fix = preg_replace( '/,?\s*(do )?Đất Xanh Miền Trung (là đơn vị )?phân phối( chính thức)?/u', '', $fix );
			if ( $fix !== $old ) {
				$p['fix_content'] = array_merge( (array) ( $p['fix_content'] ?? array() ), array( $old ) );
				$p['content']     = $fix;
			}
			$p['sources'] = array_values( array_filter( (array) ( $p['sources'] ?? array() ), static fn( $u ) => false === stripos( (string) $u, 'dat-xanh' ) ) );
			$cur = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			if ( '' !== $cur ) {
				$p['fix_meta']['hh_p_image_links']   = (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() );
				$p['fix_meta']['hh_p_image_links'][] = $cur;
			}
			$p['meta']['hh_p_image_links'] = trim( $cur . "\n" . implode( "\n", $imgs ) );
			$projects[ $i ] = $p;
		}
		return $projects;
	},
	70
);
