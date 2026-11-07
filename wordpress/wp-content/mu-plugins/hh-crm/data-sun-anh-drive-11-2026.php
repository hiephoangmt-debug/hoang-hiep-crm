<?php
/**
 * Ảnh phối cảnh, tổng mặt bằng, mặt bằng tầng, layout căn các dự án Sun (thư mục Drive anh Hiệp gửi 05/11/2026).
 * File gốc trên Drive rất lớn (20 – 115 MB) nên dùng link ảnh thu nhỏ của Drive (rộng 2400 px) – web tải ngầm từng ít một.
 * Nối thêm vào danh sách ảnh hiện có; fix_meta giữ bản trước để web chưa sửa tay được cập nhật.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$th  = static fn( $id, $alt, $where, $title = '' ) => "https://drive.google.com/thumbnail?id=$id&sz=w2400 | $alt | $where" . ( $title ? " | $title" : '' );
		$add = array(
			'cora-tower'          => array(
				$th( '1XdKv4KXXcJ3HI88_AbcGoa5Jkc4gFtJE', 'Phối cảnh tổng thể Cora Tower, Sun NeO City Hòa Xuân, Đà Nẵng', 'đại diện' ),
				$th( '1wnsijH2qgHtzHwhDnYpb6ELxk_aKErVa', 'Cora Tower nhìn từ trên cao – giao lộ Nguyễn Phước Lan, đường 29/3', 'thư viện' ),
				$th( '1v4t7lNiDJAClwLbcoTY1637kgnKRUGsC', 'Phối cảnh tổng thể hai tòa A1, A2 Cora Tower', 'thư viện' ),
				$th( '1_N2N7O05ye13hmy0YD4XPoNPFHB-phCx', 'Phối cảnh Cora Tower ban ngày', 'thư viện' ),
				$th( '1i106jNeYkUW3OX1yM0_aIJEtHejXmwJf', 'Phối cảnh Cora Tower và khu đô thị Sun NeO City', 'thư viện' ),
				$th( '1hgrJZQrBM3-zsKs0Ur7vbLExyKC9E2ml', 'Phối cảnh Cora Tower từ trục đường chính', 'thư viện' ),
				$th( '16CvhXKb-qvrDsD40RjoVaRjVWvjw1uzD', 'Cora Tower về đêm', 'thư viện' ),
				$th( '1uyhMDoIDFjg_AUjEhpYAtSeBVDphfOh_', 'Cora Tower lên đèn, nhìn từ trục đường', 'thư viện' ),
				$th( '1N4JSckshMpbtDzixsDA5FQrXdKMnWJX2', 'Phối cảnh khối đế thương mại Cora Tower nhìn từ tầng thấp', 'tiện ích', 'Khối đế thương mại' ),
				$th( '188ewgzRmNSsx9QMScR6F0AyxtpICdJBz', 'Tổng mặt bằng Cora Tower – hai tòa A1, A2 (bản vẽ chủ đầu tư, tham khảo)', 'tổng thể' ),
				$th( '1rIo5i9AWCyKOgL7m0sCLgQ3tTLb_Vd6h', 'Mặt bằng tầng 1 (shophouse khối đế) tòa A1 Cora Tower', 'mặt bằng', 'A1 · Tầng 1 (shophouse)' ),
				$th( '1J8a0_eS2WO1Ca7ihoXn8uGAV05nlP9ar', 'Mặt bằng tầng 2 tòa A1 Cora Tower', 'mặt bằng', 'A1 · Tầng 2' ),
				$th( '10OB3O4oCU3X9v8U4FWEKS1NX0-Uw5_0m', 'Mặt bằng tầng 3 tòa A1 Cora Tower', 'mặt bằng', 'A1 · Tầng 3' ),
				$th( '1I-DrHdMpNNa_VT6lycFWR8XxOeqx0gL-', 'Mặt bằng tầng điển hình tòa A1 Cora Tower', 'mặt bằng', 'A1 · Tầng điển hình' ),
				$th( '1PWPtlpjeHXGAXaOihAIcnfI3OWaUBmRn', 'Mặt bằng tầng 1 (shophouse khối đế) tòa A2 Cora Tower', 'mặt bằng', 'A2 · Tầng 1 (shophouse)' ),
				$th( '1WqxZlgMc0vjaQ0PHvugs8lJ2ZOM4f6S9', 'Mặt bằng tầng 2 tòa A2 Cora Tower', 'mặt bằng', 'A2 · Tầng 2' ),
				$th( '1ykk6caZcD5UtHyY8q5DU_Ur1NvwP-gqm', 'Mặt bằng tầng 3 tòa A2 Cora Tower (căn hộ sân vườn)', 'mặt bằng', 'A2 · Tầng 3 (căn sân vườn)' ),
				$th( '1SQWmknWQHDgcDTxY7_qnSrGWoO1hba3K', 'Mặt bằng tầng 3A – 24 tòa A2 Cora Tower', 'mặt bằng', 'A2 · Tầng 3A – 24' ),
				$th( '1oulS9J32GRh9HDGp4mcH3_OhQejkCP1s', 'Layout căn Studio Cora Tower', 'layout', 'Studio' ),
				$th( '1jSiPWNw9rNp07uBEWBg-e7WhOoFtUYkd', 'Layout căn 1PN+1 Cora Tower (mẫu 1)', 'layout', '1PN+1 (mẫu 1)' ),
				$th( '1Q_-AGKfXRbR-2U0hX4uf1_U2GFL50j5Q', 'Layout căn 1PN+1 Cora Tower (mẫu 2)', 'layout', '1PN+1 (mẫu 2)' ),
				$th( '12UPCJwFZ3Dql4m0rzc2DydnQizlt0CQz', 'Layout căn 2PN Cora Tower (mẫu 1)', 'layout', '2PN (mẫu 1)' ),
				$th( '1VjpxBSWwf8tkmxMgmPS-_fJXNPGYKYpJ', 'Layout căn 2PN Cora Tower (mẫu 2)', 'layout', '2PN (mẫu 2)' ),
				$th( '1dHUbVH5I3nbEK25qgRoK7Vz1J8VGImXg', 'Layout căn 2PN Cora Tower (mẫu 3)', 'layout', '2PN (mẫu 3)' ),
				$th( '1BQ63S2n2r7sA6le43mKsTp21u50Pv6HG', 'Layout căn 2PN tòa A2 Cora Tower', 'layout', '2PN (tòa A2)' ),
				$th( '1sjByRXmKwwTqQ07Eog-yykM0BoaM_cZo', 'Layout căn 3PN Cora Tower', 'layout', '3PN' ),
			),
			's-light-tower'       => array(
				$th( '1pmrkHhfrD0kH5VaA9tQCT-U23gYmDT8M', 'Phối cảnh tổng thể S-Light Tower, Sun NeO City Hòa Xuân, Đà Nẵng', 'đại diện' ),
				$th( '1qTRfjGsKIbM5fallG7B1yV6aaum8f1XC', 'S-Light Tower nhìn từ trên cao, ngã ba sông Hàn – Cẩm Lệ – Đô Toả', 'thư viện' ),
				$th( '1PzoF4f2-geg_T48jzs58EJhAIQrEJkMI', 'Phối cảnh hai tháp S-Light Tower bên sông', 'thư viện' ),
				$th( '10qqH4Y5xEnLfVj9p24dz9mI1TJBINqTW', 'S-Light Tower về đêm', 'thư viện' ),
				$th( '1r-BGtgMPvI-861zdNQnJEfYDcSnUMvBy', 'S-Light Tower nhìn từ cầu', 'thư viện' ),
				$th( '1p2TYbv0aj7C2xhgNbPEIxTQ47R7gHM0n', 'S-Light Tower và cây cầu bắc qua sông', 'thư viện' ),
				$th( '1E7OZBymRve3bDADFmO70LzQIum9qSkDY', 'S-Light Tower nhìn từ mặt đường', 'thư viện' ),
				$th( '1s5VdMDbBbghG0KIppjfOJSSZBMs8uXTP', 'Sân vườn tầng 10 S-Light Tower', 'tiện ích', 'Sân vườn tầng 10' ),
			),
			'spana-tower'         => array(
				$th( '1WxT7k9l-1KOqPwTkE1p8kQ1oMhDBg7jQ', 'Phối cảnh Spana Tower từ trên cao', 'thư viện' ),
				$th( '1zTNCHw0gH2m4o-ysvHDFED62Plril4jr', 'Phối cảnh Spana Tower và trục đường dẫn cầu Hòa Xuân', 'thư viện' ),
			),
			// Bản vẽ này là mặt bằng phân lô đất nền Cồn Dầu (anh Hiệp xác nhận 07/11/2026) – chuyển từ trang Sun NeO City sang.
			'dat-nen-con-dau-hoa-xuan' => array(
				$th( '1Fj7V4DJyp12BKdgOqKwJRbkFkdH-ccL0', 'Mặt bằng phân lô đất nền Cồn Dầu – Sun NeO City Hòa Xuân (bản vẽ chủ đầu tư, tham khảo)', 'tổng thể' ),
			),
			'dat-nen-vo-chi-cong' => array(
				$th( '1N6zlOPpgHwz6fLhVY5TZtx6DTP8l5hWr', 'Tổng mặt bằng đất nền Võ Chí Công (bản vẽ chủ đầu tư, tham khảo)', 'tổng thể' ),
				$th( '1UX8HCGEMcaN7wkypnvAotwpANyJOE7dQ', 'Bản đồ kết nối khu đất nền Võ Chí Công', 'tiện ích', 'Bản đồ kết nối' ),
			),
		);
		foreach ( $projects as $i => $p ) {
			$slug = $p['slug'] ?? '';
			if ( empty( $add[ $slug ] ) ) {
				continue;
			}
			$cur = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			if ( is_array( $p['meta']['hh_p_image_links'] ?? null ) ) {
				continue; // Dạng danh sách (bản cũ) – không đụng.
			}
			$first = explode( '&', explode( 'id=', $add[ $slug ][0] )[1] )[0];
			if ( false !== strpos( $cur, $first ) ) {
				continue;
			}
			// Có ảnh đại diện mới thì ảnh "đại diện" cũ chuyển thành ảnh thư viện.
			$has_cover = (bool) preg_grep( '/\|\s*đại diện\s*(\||$)/u', $add[ $slug ] );
			$old       = $has_cover ? preg_replace( '/\|\s*đại diện\s*(?=\||$)/mu', '| thư viện', $cur ) : $cur;
			$projects[ $i ]['meta']['hh_p_image_links'] = trim( $old . "\n" . implode( "\n", $add[ $slug ] ) );
			if ( '' !== $cur ) {
				$projects[ $i ]['fix_meta']['hh_p_image_links'] = array_merge( (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() ), array( $cur ) );
			}
		}
		return $projects;
	},
	67 // Sau mặt bằng penthouse (66).
);
