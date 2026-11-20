<?php
/**
 * Peninsula Private Đà Nẵng – tiêu chuẩn vật liệu bàn giao theo bộ ảnh "Chất liệu tinh tuyển" của chủ đầu tư (anh Hiệp gửi 20/11/2026).
 * Dùng 5 phối cảnh nội thất có chú thích (phòng khách, bếp, vệ sinh, ngủ, logia) – thương hiệu chủ đầu tư.
 * KHÔNG dùng ảnh có logo đơn vị phân phối (ảnh "chỉ từ 65 triệu/m²") và ảnh poster linh vật.
 * Chạy sau data-peninsula-private-11-2026.php (70). Chỉ thay khi trên web còn giá trị cũ.
 */

defined( 'ABSPATH' ) || exit;

/** Mục "Tiêu chuẩn bàn giao" trong bài giới thiệu Peninsula Private. */
function hh_peninsula_private_ban_giao_html() {
	return <<<'HTML'

<h2>Tiêu chuẩn bàn giao căn hộ Peninsula Private Đà Nẵng</h2>
<p>Căn hộ Peninsula Private bàn giao hoàn thiện nội thất liền tường. Theo bộ tài liệu "Chất liệu tinh tuyển" của chủ đầu tư, vật liệu và thiết bị từng khu vực như sau (thương hiệu "hoặc tương đương"):</p>
<table>
<thead><tr><th>Khu vực</th><th>Hạng mục bàn giao</th><th>Thương hiệu</th></tr></thead>
<tbody>
<tr><td>Phòng khách</td><td>Trần thạch cao khung xương chìm, sơn hoàn thiện; sàn gạch nung kết vân đá marble (căn từ 70 m²); cửa gỗ chống cháy; khóa điện tử 5 chức năng (vân tay, mật khẩu, thẻ từ, khóa cơ)</td><td>Vĩnh Tường, Dulux/Jotun; Vasta Stone; Woodsland/An Cường; Häfele</td></tr>
<tr><td>Phòng bếp</td><td>Full hệ tủ bếp gỗ; mặt bàn bếp đá nung kết dày 18 mm; bếp từ nhập khẩu; đèn downlight</td><td>An Cường; Vasta Stone; Häfele/Bosch; Panasonic/Philips</td></tr>
<tr><td>Phòng ngủ</td><td>Điều hòa hệ multi âm trần; cửa sổ nhôm kính hộp phủ Low-E 3 lớp; cửa gỗ thông phòng; thiết bị điện</td><td>Mitsubishi/Daikin; Kibing, Cmech; An Cường, phụ kiện Häfele; Schneider</td></tr>
<tr><td>Phòng vệ sinh</td><td>Thiết bị vệ sinh và phụ kiện; bình nóng lạnh; quạt thông gió; cửa nhựa công nghiệp</td><td>Hansgrohe/Grohe/Kohler; Ferroli/Ariston; Mitsubishi/Panasonic; An Cường</td></tr>
<tr><td>Logia</td><td>Cửa nhôm kính trượt ban công; lan can kính; sàn đá nung kết vân đá marble (studio, 1PN: Travertino Sand; 2PN trở lên: Apuan Luxe)</td><td>Kibing/Cmech (nhập khẩu); Đại Dương Kính/Việt Nhật/Hải Long; Vasta Stone</td></tr>
</tbody>
</table>
<p>Hình phối cảnh mang tính minh họa (đồ rời như sofa, bàn ăn, giường không thuộc danh mục bàn giao nếu chủ đầu tư không ghi). Giá tham khảo chỉ từ khoảng 65 triệu/m². Liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> để nhận bảng tiêu chuẩn bàn giao chi tiết theo từng loại căn.</p>
HTML;
}

add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$im   = static fn( $f, $alt, $t ) => "plugin:img/peninsula-private/peninsula-private-ban-giao-$f.jpg | $alt | thư viện | $t";
		$imgs = array(
			$im( 'phong-khach', 'Phòng khách bàn giao Peninsula Private: trần thạch cao khung xương chìm, sàn gạch vân marble, khóa điện tử 5 chức năng (phối cảnh chủ đầu tư)', 'Bàn giao – phòng khách' ),
			$im( 'phong-bep', 'Phòng bếp bàn giao Peninsula Private: full tủ bếp gỗ An Cường, mặt đá nung kết 18 mm, bếp từ nhập khẩu (phối cảnh chủ đầu tư)', 'Bàn giao – phòng bếp' ),
			$im( 'phong-ngu', 'Phòng ngủ bàn giao Peninsula Private: điều hòa multi âm trần, cửa sổ kính hộp Low-E 3 lớp, thiết bị điện Schneider (phối cảnh chủ đầu tư)', 'Bàn giao – phòng ngủ' ),
			$im( 'phong-ve-sinh', 'Phòng vệ sinh bàn giao Peninsula Private: thiết bị Hansgrohe/Grohe/Kohler, bình nóng lạnh, quạt thông gió (phối cảnh chủ đầu tư)', 'Bàn giao – phòng vệ sinh' ),
			$im( 'logia', 'Logia Peninsula Private: cửa nhôm kính trượt, lan can kính, sàn đá nung kết vân marble, view sông Hàn (phối cảnh chủ đầu tư)', 'Bàn giao – logia' ),
		);
		foreach ( $projects as $i => $p ) {
			if ( 'peninsula-private-da-nang' !== ( $p['slug'] ?? '' ) ) {
				continue;
			}
			$std = 'Hoàn thiện nội thất liền tường: sàn gạch/đá nung kết vân marble Vasta Stone, tủ bếp An Cường, bếp từ Häfele/Bosch, điều hòa multi âm trần Mitsubishi/Daikin, thiết bị vệ sinh Hansgrohe/Grohe/Kohler, kính hộp Low-E 3 lớp, khóa điện tử 5 chức năng, thiết bị điện Schneider (hoặc tương đương)';
			$cur = (string) ( $p['meta']['hh_p_handover_std'] ?? '' );
			if ( $cur !== $std ) {
				$p['fix_meta']['hh_p_handover_std'] = array_merge( (array) ( $p['fix_meta']['hh_p_handover_std'] ?? array() ), array_filter( array( $cur ) ) );
				$p['meta']['hh_p_handover_std']     = $std;
			}
			$links = (string) ( $p['meta']['hh_p_image_links'] ?? '' );
			if ( '' !== $links && false === strpos( $links, 'peninsula-private-ban-giao-' ) ) {
				$p['fix_meta']['hh_p_image_links'] = array_merge( (array) ( $p['fix_meta']['hh_p_image_links'] ?? array() ), array( $links ) );
				$p['meta']['hh_p_image_links']     = trim( $links . "\n" . implode( "\n", $imgs ) );
			}
			$c0 = (string) ( $p['content'] ?? '' );
			if ( '' !== $c0 && false === strpos( $c0, 'Tiêu chuẩn bàn giao căn hộ Peninsula Private' ) ) {
				$p['content']     = $c0 . hh_peninsula_private_ban_giao_html();
				$p['fix_content'] = array_merge( (array) ( $p['fix_content'] ?? array() ), array( $c0 ) );
			}
			$projects[ $i ] = $p;
		}
		return $projects;
	},
	80
);
