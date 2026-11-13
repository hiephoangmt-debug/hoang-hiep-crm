<?php
/**
 * Vinhomes Hải Vân Bay – bổ sung 13/11/2026 từ bộ tài liệu dự án anh Hiệp gửi (thư mục Drive "Giới thiệu, thông tin, mặt bằng, hình ảnh"):
 * - Phân khu Đảo Ngọc (Khu 3): 25 phối cảnh chủ đầu tư (tổng thể, biệt thự, Phố đi bộ biển Emerald Boulevard,
 *   Công viên Đảo Ngọc – Pearl Park, Công viên Nắng Biển – Sunlight Park) + Tổng mặt bằng tiện ích Khu Đảo Ngọc.
 * - Trang tổng: Tổng mặt bằng định vị kiến trúc 4 phân khu + 1 phối cảnh tổng thể Đảo Ngọc.
 * - Bạch Vân (Khu 1): phối cảnh facade liền kề mẫu Shanghai.
 * Không dùng: tờ rơi đại lý, file đào tạo nội bộ, ảnh "cảm hứng" (không phải phối cảnh dự án).
 * Ảnh chỉ có dòng ghi chú "hình ảnh minh họa" của chủ đầu tư, không logo đại lý.
 * Ô nào anh đã tự sửa trong quản trị thì giữ nguyên (fix_meta chỉ thay khi còn đúng bản cũ do web nhập).
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_project_dataset', 'hh_dataset_hai_van_bay_2026_11', 50 );
function hh_dataset_hai_van_bay_2026_11( $projects ) {
	$im = static fn( $f, $alt, $where, $title = '' ) => "plugin:img/vinhomes-hai-van-bay/vhvb-$f.jpg | $alt | $where" . ( $title ? " | $title" : '' );

	$add = array(
		'vinhomes-hai-van-bay-dao-ngoc' => array(
			'images'    => array(
				$im( 'tmb-tien-ich-dao-ngoc', 'Tổng mặt bằng tiện ích Khu Đảo Ngọc – Vinhomes Hải Vân Bay: VinWonders Hải Vân, công viên Bách Thảo, Pearl Park, Emerald Boulevard, Sunlight Park (tài liệu chủ đầu tư)', 'mặt bằng', 'TMB tiện ích Khu Đảo Ngọc' ),
				$im( 'dao-ngoc-tong-the-1', 'Phối cảnh tổng thể Khu Đảo Ngọc nhìn về VinWonders Hải Vân và bãi biển (phối cảnh chủ đầu tư)', 'tổng thể' ),
				$im( 'dao-ngoc-tong-the-2', 'Phối cảnh Khu Đảo Ngọc bên vịnh Nam Chơn, chân đèo Hải Vân (phối cảnh chủ đầu tư)', 'tổng thể' ),
				$im( 'dao-ngoc-tong-the-3', 'Toàn cảnh Đảo Ngọc ôm vịnh, nhìn về vịnh Đà Nẵng (phối cảnh chủ đầu tư)', 'thư viện' ),
				$im( 'dao-ngoc-tong-the-4', 'Đảo Ngọc và VinWonders Hải Vân nhìn từ sườn núi (phối cảnh chủ đầu tư)', 'thư viện' ),
				$im( 'biet-thu-dao-ngoc', 'Dãy biệt thự Đảo Ngọc phong cách Địa Trung Hải bên phố đi bộ (phối cảnh chủ đầu tư)', 'thư viện' ),
				$im( 'biet-thu-hidden-valley-1', 'Biệt thự ven đồi Hidden Valley hướng biển lúc hoàng hôn (phối cảnh chủ đầu tư)', 'thư viện' ),
				$im( 'biet-thu-hidden-valley-2', 'Biệt thự ven đồi Hidden Valley tựa núi Hải Vân (phối cảnh chủ đầu tư)', 'thư viện' ),
				$im( 'emerald-park-7', 'Không gian phòng khách biệt thự nhìn ra biển (phối cảnh nội thất minh họa)', 'thư viện' ),
				$im( 'emerald-park-2', 'Phố đi bộ bờ biển Emerald Boulevard dài khoảng 1,3 km với chòi nghỉ ven biển (phối cảnh chủ đầu tư)', 'tiện ích', 'Phố đi bộ biển Emerald Boulevard' ),
				$im( 'emerald-park-5', 'Bãi biển Đảo Ngọc với khu vui chơi trẻ em, dù lượn (phối cảnh chủ đầu tư)', 'tiện ích', 'Bãi biển Đảo Ngọc' ),
				$im( 'emerald-park-1', 'Sàn ngắm hoàng hôn trên phố biển Emerald Boulevard (phối cảnh chủ đầu tư)', 'tiện ích', 'Sàn ngắm hoàng hôn' ),
				$im( 'emerald-park-8', 'Bờ biển và thảm cỏ ven phố đi bộ Emerald Boulevard (phối cảnh chủ đầu tư)', 'tiện ích', 'Bờ biển Emerald' ),
				$im( 'cv-dao-ngoc-tong-the', 'Công viên Đảo Ngọc – Pearl Park (khoảng 0,65 ha) với hồ bơi trung tâm giữa các dãy nhà (phối cảnh chủ đầu tư)', 'tiện ích', 'Công viên Đảo Ngọc – Pearl Park' ),
				$im( 'cv-dao-ngoc-be-boi', 'Bể bơi ngoài trời trong Công viên Đảo Ngọc (phối cảnh chủ đầu tư)', 'tiện ích', 'Bể bơi Pearl Park' ),
				$im( 'cv-dao-ngoc-dai-phun-nuoc', 'Vườn hoa, tượng cổ điển và đài phun nước – Công viên Đảo Ngọc (phối cảnh chủ đầu tư)', 'tiện ích', 'Vườn hoa, đài phun nước' ),
				$im( 'cv-dao-ngoc-logo', 'Tiểu cảnh biểu tượng Đảo Ngọc phát sáng về đêm (phối cảnh chủ đầu tư)', 'tiện ích', 'Biểu tượng Đảo Ngọc' ),
				$im( 'cv-dao-ngoc-vui-choi', 'Sân chơi trẻ em trong Công viên Đảo Ngọc (phối cảnh chủ đầu tư)', 'tiện ích', 'Sân chơi trẻ em' ),
				$im( 'cv-dao-ngoc-vuon-co', 'Vườn cờ – chòi thư giãn cho người lớn tuổi (phối cảnh chủ đầu tư)', 'tiện ích', 'Vườn cờ' ),
				$im( 'cv-nang-bien-2', 'Công viên Nắng Biển – Sunlight Park (khoảng 0,48 ha) với hồ bơi, sân chơi, khu tập luyện (phối cảnh chủ đầu tư)', 'tiện ích', 'Công viên Nắng Biển – Sunlight Park' ),
				$im( 'cv-nang-bien-1', 'Công viên Nắng Biển nhìn từ trên cao giữa khu biệt thự (phối cảnh chủ đầu tư)', 'tiện ích', 'Sunlight Park nhìn từ trên cao' ),
				$im( 'cv-nang-bien-3', 'Hồ bơi gia đình trong Công viên Nắng Biển (phối cảnh chủ đầu tư)', 'tiện ích', 'Hồ bơi Sunlight Park' ),
				$im( 'cv-nang-bien-7', 'Khu vui chơi trẻ em Công viên Nắng Biển (phối cảnh chủ đầu tư)', 'tiện ích', 'Khu vui chơi trẻ em' ),
				$im( 'cv-nang-bien-vuon-thu-gian', 'Vườn thư giãn, xích đu dưới giàn hoa – Công viên Nắng Biển (phối cảnh chủ đầu tư)', 'tiện ích', 'Vườn thư giãn' ),
				$im( 'cv-nang-bien-co-1', 'Khu bàn cờ ngoài trời – Công viên Nắng Biển (phối cảnh chủ đầu tư)', 'tiện ích', 'Khu bàn cờ' ),
				$im( 'cv-nang-bien-vui-choi-1', 'Sân chơi nước cho trẻ em (phối cảnh chủ đầu tư)', 'tiện ích', 'Sân chơi nước' ),
				$im( 'cv-nang-bien-vui-choi-2', 'Góc chơi cho trẻ nhỏ trong công viên nội khu (phối cảnh chủ đầu tư)', 'tiện ích', 'Góc chơi trẻ nhỏ' ),
			),
			'amenities' => "Theo Tổng mặt bằng tiện ích Khu Đảo Ngọc (chủ đầu tư): VinWonders Hải Vân khoảng 24,8 ha – khu vận động thể thao mạo hiểm, công viên nước, khu vui chơi trong nhà\nCông viên Thế giới Bách Thảo – Botanica Park khoảng 8 ha\nCông viên Đảo Ngọc – Pearl Park khoảng 0,65 ha: bãi cỏ, vườn hoa, tượng cổ điển, đài phun nước, vườn kịch, chòi BBQ\nPhố đi bộ bờ biển Emerald Boulevard dài khoảng 1,3 km\nCông viên Nắng Biển – Sunlight Park khoảng 0,48 ha\nResort 5 sao khoảng 4,6 ha; hệ thống trường học",
		),
		'vinhomes-hai-van-bay'          => array(
			'images' => array(
				$im( 'tmb-dinh-vi-kien-truc', 'Tổng mặt bằng định vị kiến trúc 4 phân khu Vinhomes Hải Vân Bay: Bạch Vân (Victoria – Hồng Kông), Vịnh Mây (Malibu Hills – Mỹ), Đảo Ngọc (Costa Smeralda – Ý), Tinh Vân (Nhật Bản) (tài liệu chủ đầu tư)', 'mặt bằng', 'TMB định vị kiến trúc 4 phân khu' ),
				$im( 'tmb-tien-ich-dao-ngoc', 'Tổng mặt bằng tiện ích Khu Đảo Ngọc – Vinhomes Hải Vân Bay (tài liệu chủ đầu tư)', 'mặt bằng', 'TMB tiện ích Khu Đảo Ngọc' ),
				$im( 'dao-ngoc-tong-the-2', 'Vinhomes Hải Vân Bay – Khu Đảo Ngọc bên vịnh Nam Chơn (phối cảnh chủ đầu tư)', 'thư viện' ),
				$im( 'dao-ngoc-tong-the-1', 'Khu Đảo Ngọc và VinWonders Hải Vân (phối cảnh chủ đầu tư)', 'thư viện' ),
			),
		),
		'vinhomes-hai-van-bay-bach-van' => array(
			'images' => array(
				$im( 'facade-lien-ke-bach-van-shanghai', 'Phối cảnh phố liền kề Bạch Vân mẫu kiến trúc Shanghai (phối cảnh chủ đầu tư)', 'thư viện' ),
			),
		),
	);

	foreach ( $projects as $i => $p ) {
		$slug = $p['slug'] ?? '';
		if ( ! isset( $add[ $slug ] ) ) {
			continue;
		}
		$cur = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
		$p['meta']['hh_p_image_links'] = trim( $cur . "\n" . implode( "\n", $add[ $slug ]['images'] ) );
		if ( '' !== $cur ) {
			$p['fix_meta']['hh_p_image_links'] = array_merge( (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() ), array( $cur ) );
		}
		if ( ! empty( $add[ $slug ]['amenities'] ) ) {
			$cur_a = (string) ( $p['meta']['hh_p_amenities_in'] ?? '' );
			if ( false === strpos( $cur_a, 'Pearl Park' ) ) {
				$p['meta']['hh_p_amenities_in'] = trim( $cur_a . "\n" . $add[ $slug ]['amenities'] );
				if ( '' !== $cur_a ) {
					$p['fix_meta']['hh_p_amenities_in'] = array_merge( (array) ( $p['fix_meta']['hh_p_amenities_in'] ?? array() ), array( $cur_a ) );
				}
			}
		}
		$projects[ $i ] = $p;
	}
	return $projects;
}
