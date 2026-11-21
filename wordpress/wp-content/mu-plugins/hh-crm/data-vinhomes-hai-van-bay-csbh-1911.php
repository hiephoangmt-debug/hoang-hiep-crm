<?php
/**
 * Vinhomes Hải Vân Bay – chính sách bán hàng áp dụng từ 19/11/2026 (ảnh CSBH chủ đầu tư anh Hiệp gửi 21/11/2026:
 * Bạch Vân · Vịnh Mây · Đảo Ngọc). Chỉ lấy thông tin, không dùng ảnh.
 * Thay chính sách 10/2026 (khóa trần 6%…) trên trang tổng và 3 phân khu đang bán. Chỉ thay ô còn đúng bản web đã nhập
 * (fix_meta) – ô anh đã tự sửa trong quản trị giữ nguyên. Chạy sau các file Hải Vân Bay (40, 45, 50).
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_project_dataset', 'hh_dataset_hai_van_bay_csbh_1911', 60 );
function hh_dataset_hai_van_bay_csbh_1911( $projects ) {
	$chung = "Áp dụng từ 19/11/2026 cho Bạch Vân, Vịnh Mây, Đảo Ngọc\nThanh toán sớm: ưu đãi 7,5%\nVoucher Vinhomes: thanh toán tối đa 30% giá trị bất động sản – áp dụng voucher chậm nhất ngày 31/12/2026; mỗi voucher áp dụng 01 căn, hạn chế chuyển nhượng 03 tháng từ ngày dùng voucher\nƯu đãi VinClub: 0,5% – 0,7% – 0,9% tùy hạng thành viên";
	$bach_van = "Bạch Vân (nhà thô, xây ngay) – về ở sớm ưu đãi 10%: ưu đãi vào giá HĐMB khi ký hợp đồng, hoàn tiền khi đủ điều kiện về ở sớm (theo danh sách căn thuộc chương trình)";
	$dao_ngoc = "Đảo Ngọc (nhà hoàn thiện) – cam kết tiền thuê 7%/năm trong 3 năm (căn thuộc chương trình nhận cam kết tiền thuê)\nĐảo Ngọc – riêng 223 căn theo danh sách, chọn 1 trong 2: nhận cam kết tiền thuê 7%/năm trong 3 năm (bàn giao lại nhà cho chủ đầu tư) HOẶC về ở sớm ưu đãi 10% trên giá HĐMB trước VAT và kinh phí bảo trì (không nhận cam kết tiền thuê; cam kết về ở trong 3 tháng kể từ ngày nhận nhà)";
	$vay = "Vay PA1 – lãi suất cố định: vay theo giá gốc tới 70% giá trị căn (sản phẩm giãn xây vay tới 80% tiền đất và thương mại, không vượt 70% tổng giá trị); khách trả 3%/năm (18 tháng), 4,5% (24 tháng), 6% (30 tháng), 7,5% (36 tháng), 8,5% (48 tháng), 9% (60 tháng)\nVay PA2 – hỗ trợ lãi suất 0%, cộng thêm vào giá gốc: vay 70% giá trị căn +3,5% (18 tháng), +8% (24 tháng), +13,5% (30 tháng), +19,5% (36 tháng); vay 80% tiền đất và thương mại (chỉ sản phẩm giãn xây) +5,5%, +10,5%, +17,5%, +25%\nNhà giãn xây: chính sách tính trên giá trị quyền sử dụng đất và thương mại, chưa gồm tiền xây dựng\nCăn hoàn thiện nội thất vay ngân hàng chỉ áp dụng PA1\nHạn mức vay, thời gian hỗ trợ và chi phí cộng thêm theo xét duyệt ngân hàng; áp dụng theo điều kiện và danh sách căn tại CSBH của chủ đầu tư";
	$loan = 'Chọn 1 trong 2 phương án (CSBH từ 19/11/2026): PA1 lãi suất cố định – vay tới 70% giá trị căn, khách trả 3%/năm nếu hỗ trợ 18 tháng, 4,5% (24 tháng), 6% (30 tháng), 7,5% (36 tháng), 8,5% (48 tháng), 9% (60 tháng); PA2 hỗ trợ lãi suất 0% với chi phí cộng thêm vào giá gốc (vay 70%: +3,5% cho 18 tháng đến +19,5% cho 36 tháng). Sản phẩm giãn xây vay tới 80% tiền đất và thương mại. Căn hoàn thiện nội thất chỉ áp dụng PA1. Hạn mức theo xét duyệt ngân hàng.';
	$note  = 'Theo chính sách bán hàng Vinhomes Hải Vân Bay áp dụng từ 19/11/2026 – điều kiện và danh sách căn theo CSBH chủ đầu tư, liên hệ Hoàng Hiệp để nhận phiếu tính giá.';

	$upd = array(
		'vinhomes-hai-van-bay'          => array(
			'hh_p_offer_title' => 'Thanh toán sớm ưu đãi 7,5% – voucher tới 30% – Đảo Ngọc cam kết thuê 7%/năm',
			'hh_p_offer_note'  => $note,
			'hh_p_offer_stats' => "7,5% | Ưu đãi thanh toán sớm\n30% | Voucher thanh toán tối đa (đến 31/12/2026)\n10% | Ưu đãi về ở sớm (Bạch Vân, Đảo Ngọc)\n7%/năm | Cam kết thuê 3 năm (Đảo Ngọc)",
			'hh_p_policy'      => "$chung\n$bach_van\n$dao_ngoc\n$vay",
			'hh_p_loan'        => $loan,
			'hh_p_loan_ratio'  => '70',
			'rank_math_title'  => 'Vinhomes Hải Vân Bay (Làng Vân): Bảng giá & CSBH T11/2026',
		),
		'vinhomes-hai-van-bay-bach-van' => array(
			'hh_p_offer_title' => 'Về ở sớm ưu đãi 10% – thanh toán sớm 7,5%',
			'hh_p_offer_note'  => $note,
			'hh_p_offer_stats' => "10% | Ưu đãi về ở sớm (nhà thô, xây ngay)\n7,5% | Ưu đãi thanh toán sớm\n30% | Voucher thanh toán tối đa\n70% | Vay ngân hàng",
			'hh_p_policy'      => "$chung\n$bach_van\n$vay",
			'hh_p_loan'        => $loan,
		),
		'vinhomes-hai-van-bay-vinh-may' => array(
			'hh_p_offer_title' => 'Thanh toán sớm ưu đãi 7,5% – voucher tới 30%',
			'hh_p_offer_note'  => $note,
			'hh_p_offer_stats' => "7,5% | Ưu đãi thanh toán sớm\n30% | Voucher thanh toán tối đa\n0,9% | Ưu đãi VinClub tối đa\n70% | Vay ngân hàng",
			'hh_p_policy'      => "$chung\n$vay",
			'hh_p_loan'        => $loan,
		),
		'vinhomes-hai-van-bay-dao-ngoc' => array(
			'hh_p_offer_title' => 'Cam kết thuê 7%/năm trong 3 năm hoặc về ở sớm ưu đãi 10%',
			'hh_p_offer_note'  => $note,
			'hh_p_offer_stats' => "7%/năm | Cam kết tiền thuê 3 năm\n10% | Về ở sớm (223 căn, chọn 1 trong 2)\n7,5% | Ưu đãi thanh toán sớm\n30% | Voucher thanh toán tối đa",
			'hh_p_policy'      => "$chung\n$dao_ngoc\n$vay",
			'hh_p_loan'        => $loan,
		),
	);

	foreach ( $projects as $i => $p ) {
		$slug = $p['slug'] ?? '';
		if ( ! isset( $upd[ $slug ] ) ) {
			continue;
		}
		foreach ( $upd[ $slug ] as $k => $v ) {
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
}
