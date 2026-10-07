<?php
/**
 * Trang tổng hợp (hub) cho từ khoá chưa có trang riêng:
 *   /can-ho-sun-group-da-nang/      "căn hộ Sun Group Đà Nẵng"
 *   /biet-thu-hoi-an/               "biệt thự Hội An"
 *   /can-ho-chuyen-nhuong-da-nang/  "căn hộ chuyển nhượng Đà Nẵng"
 *   /dat-nen-hoa-xuan/              "đất nền Hòa Xuân"
 * Mỗi trang: đoạn giới thiệu (≥ 300 chữ), danh sách dự án tự lọc theo dữ liệu, tin nhà đất / bài viết liên quan, hỏi đáp.
 * Giao diện: themes/hoanghiep/hub.php. SEO (tiêu đề, mô tả, canonical, schema, sitemap): themes/hoanghiep/inc/seo.php.
 */

defined( 'ABSPATH' ) || exit;

/** Khóa trang => cấu hình. */
function hh_hub_pages() {
	return array(
		'can-ho-sun-group-da-nang' => array(
			'keyword' => 'căn hộ Sun Group Đà Nẵng',
			'h1'      => 'Căn hộ Sun Group Đà Nẵng',
			'title'   => 'Căn hộ Sun Group Đà Nẵng: dự án, giá, chính sách 2026',
			'desc'    => 'Căn hộ Sun Group Đà Nẵng: FourS Tower, Spana, S-Light, Cora, Sun Symphony, Sun Ponte, Sun Cosmo – vị trí, giá tham khảo, tiến độ. Gọi Hoàng Hiệp.',
			'intro'   => array(
				'Sun Group là một trong những chủ đầu tư có nhiều dự án căn hộ nhất ở Đà Nẵng, trải từ hai bờ sông Hàn đến khu đô thị mới phía Nam thành phố. Trang này gom toàn bộ <strong>căn hộ Sun Group Đà Nẵng</strong> mà Hoàng Hiệp đang theo dõi vào một chỗ, để anh chị so sánh nhanh vị trí, loại căn, tình trạng mở bán và mức giá tham khảo trước khi đi xem thực tế.',
				'Có thể chia các dự án thành hai nhóm. Nhóm ven sông Hàn gồm Sun Symphony Residence, Sun Ponte Residence và Sun Cosmo Residence: đã hoặc đang bàn giao, giao dịch chủ yếu là căn chuyển nhượng và cho thuê, phù hợp người cần ở ngay hoặc muốn có dòng tiền thuê ở khu trung tâm. Nhóm phía Nam – khu Hòa Xuân, Hòa Quý – gồm FourS Tower trong khu đô thị Sun Riverpolis, Spana Tower, S-Light Tower và Cora Tower thuộc Sun NeO City: đang mở bán theo từng đợt, giá vào mềm hơn, có chính sách thanh toán giãn và hỗ trợ vay, hợp với người mua ở lần đầu và nhà đầu tư trung – dài hạn.',
				'Khi chọn căn hộ Sun Group, nên xem bốn điểm: pháp lý (sở hữu lâu dài hay có thời hạn, đã có sổ hay chưa), tiến độ xây dựng và thời điểm bàn giao thực tế, chính sách thanh toán của đợt đang áp dụng, và giá chuyển nhượng của các tòa đã bàn giao gần đó để biết mặt bằng giá khu vực. Mỗi dự án trong danh sách dưới đây đều có trang riêng với bảng giá, mặt bằng, tiến độ và chính sách cập nhật.',
				'Giá trên website là giá tham khảo, thay đổi theo đợt mở bán, tầng, hướng và phương án thanh toán. Để nhận bảng giá chính thức, phiếu tính giá theo căn cụ thể hoặc đặt lịch xem nhà mẫu, anh chị gọi hoặc nhắn Zalo cho Hoàng Hiệp – tư vấn miễn phí, không thu phí người mua.',
			),
			'faq'     => array(
				array( 'Sun Group có những dự án căn hộ nào ở Đà Nẵng?', 'Ven sông Hàn có Sun Symphony Residence, Sun Ponte Residence, Sun Cosmo Residence; phía Nam có FourS Tower (Sun Riverpolis), Spana Tower, S-Light Tower, Cora Tower (Sun NeO City). Danh sách đầy đủ, cập nhật ở bảng trên trang này.' ),
				array( 'Căn hộ Sun Group Đà Nẵng nào đang mở bán?', 'Các dự án phía Nam như FourS Tower, Spana Tower, S-Light Tower, Cora Tower đang mở bán theo đợt; các dự án ven sông Hàn chủ yếu giao dịch chuyển nhượng. Tình trạng từng dự án ghi trên thẻ dự án.' ),
				array( 'Mua căn hộ Sun Group có được vay ngân hàng không?', 'Có. Các đợt mở bán thường có ngân hàng bảo lãnh, hỗ trợ vay một phần giá trị căn và chính sách hỗ trợ lãi suất có thời hạn. Mức cụ thể theo chính sách từng đợt – liên hệ để nhận bản mới nhất.' ),
				array( 'Nên chọn căn hộ Sun Group ven sông Hàn hay phía Nam?', 'Cần ở ngay hoặc cho thuê ở trung tâm: ưu tiên căn chuyển nhượng ven sông Hàn. Vốn vừa phải, chấp nhận chờ bàn giao, muốn thanh toán giãn: các dự án phía Nam phù hợp hơn.' ),
			),
			'posts'   => array( 'so-sanh-fours-tower-spana-tower-s-light-tower', 'co-nen-mua-can-ho-fours-tower', 'so-sanh-can-ho-ven-song-han-sun-symphony-sun-ponte-peninsula', 'bat-dong-san-nam-da-nang-ha-tang-hoa-xuan-hoa-quy-2026', 'spana-tower-hoa-xuan-gia-mat-bang', 'cora-tower-sun-neo-city' ),
		),
		'biet-thu-hoi-an'          => array(
			'keyword' => 'biệt thự Hội An',
			'h1'      => 'Biệt thự Hội An',
			'title'   => 'Biệt thự Hội An: dự án, giá tham khảo, pháp lý 2026',
			'desc'    => 'Biệt thự Hội An và ven biển Nam Hội An – Điện Bàn: Casamia Balanca, Casamia Calm, Hoiana, Shantira, Vinpearl Nam Hội An – giá tham khảo, pháp lý, cho thuê.',
			'intro'   => array(
				'Hội An là thị trường biệt thự nghỉ dưỡng và biệt thự ven sông có tiếng nhất miền Trung: phố cổ là di sản văn hóa thế giới, biển An Bàng – Cửa Đại gần kề, khách du lịch quanh năm. Từ ngày 1/7/2025, khu vực Hội An, Điện Bàn và Duy Xuyên thuộc thành phố Đà Nẵng, nên biệt thự ở đây được hưởng thêm hạ tầng và sức hút của một đô thị lớn. Trang này tổng hợp <strong>biệt thự Hội An</strong> theo từng dự án để anh chị so sánh trước khi đi xem.',
				'Thị trường có thể chia thành ba nhóm. Biệt thự ven sông trong khu đô thị sinh thái – tiêu biểu là các dự án Casamia của Đạt Phương bên sông Cổ Cò – hợp với gia đình muốn ở lâu dài hoặc làm nhà thứ hai, có tiện ích nội khu; Casamia Balanca đã được cấp sổ cho các lô từ tháng 8/2026. Biệt thự biển trong quần thể nghỉ dưỡng phía Nam Hội An như Hoiana, Vinpearl Nam Hội An – thường đi kèm chương trình cho thuê do đơn vị vận hành quản lý. Biệt thự ven biển Điện Bàn – Điện Dương như Shantira, Four Seasons The Nam Hải, Montgomerie Links – phần lớn đã bàn giao, giao dịch chuyển nhượng.',
				'Trước khi xuống tiền, nên kiểm tra kỹ loại đất và thời hạn ghi trên sổ (đất ở hay đất thương mại dịch vụ, lâu dài hay có thời hạn), điều khoản hợp đồng thuê hoặc vận hành nếu mua để cho thuê, chi phí quản lý hằng năm, và tình trạng thực tế của căn (đã bàn giao, đang xây hay mới mở bán). Với căn chuyển nhượng, cần đối chiếu sổ, hợp đồng gốc và xác nhận của chủ đầu tư.',
				'Giá trên trang là giá tham khảo từ chủ đầu tư và thị trường chuyển nhượng công khai, có thể thay đổi. Hoàng Hiệp hỗ trợ đặt lịch xem biệt thự thực tế, gửi bảng giá, tính dòng tiền cho thuê và kiểm tra pháp lý từng căn – liên hệ qua điện thoại hoặc Zalo.',
			),
			'faq'     => array(
				array( 'Biệt thự Hội An nào có sổ riêng từng lô?', 'Một số khu đô thị ven sông như Casamia Balanca đã được cấp giấy chứng nhận cho các lô (tháng 8/2026). Loại đất và thời hạn khác nhau theo dự án – nên kiểm tra trên sổ của đúng căn trước khi ký.' ),
				array( 'Mua biệt thự Hội An để cho thuê có ổn không?', 'Hội An có lượng khách du lịch ổn định nên nhu cầu thuê villa tốt, nhưng doanh thu phụ thuộc vị trí, đơn vị vận hành và mùa du lịch. Nên tính dòng tiền theo kịch bản thận trọng và đọc kỹ hợp đồng vận hành.' ),
				array( 'Biệt thự Hội An giá bao nhiêu?', 'Tuỳ dự án và vị trí: biệt thự ven sông trong khu đô thị thường thấp hơn biệt thự biển trong quần thể nghỉ dưỡng hạng sang. Giá tham khảo từng dự án ghi trên thẻ dự án và trang dự án.' ),
				array( 'Hội An sau hợp nhất thuộc Đà Nẵng có ảnh hưởng gì?', 'Từ 1/7/2025 Hội An thuộc thành phố Đà Nẵng; đơn vị hành chính đổi tên (ví dụ phường Hội An Đông). Khi mua cần kiểm tra địa chỉ mới trên giấy tờ và quy hoạch cập nhật.' ),
			),
			'posts'   => array( 'bat-dong-san-hoi-an-2026-sau-hop-nhat', 'casamia-balanca-so-sanh-biet-thu-hoi-an', 'phap-ly-so-hong-casamia-balanca', 'shantira-hoi-an-biet-thu-can-ho-gia-tham-khao', 'biet-thu-vinpearl-da-nang-hoi-an-gia-chuyen-nhuong', 'duong-ven-bien-129-vo-chi-cong-bat-dong-san-ven-bien-hoi-an' ),
		),
		'can-ho-chuyen-nhuong-da-nang' => array(
			'keyword' => 'căn hộ chuyển nhượng Đà Nẵng',
			'h1'      => 'Căn hộ chuyển nhượng Đà Nẵng',
			'title'   => 'Căn hộ chuyển nhượng Đà Nẵng: dự án, giá, căn đang bán',
			'desc'    => 'Căn hộ chuyển nhượng Đà Nẵng: dự án đã bàn giao, giá tham khảo, tin bán căn có sổ hoặc hợp đồng mua bán, quy trình sang tên. Gọi Hoàng Hiệp nhận căn thật.',
			'intro'   => array(
				'Căn hộ chuyển nhượng là căn đã có chủ, được bán lại – thường ở các dự án đã hoặc đang bàn giao. Ưu điểm lớn nhất là nhìn thấy căn thật, biết rõ tầng, hướng, view, nội thất và có thể ở hoặc cho thuê ngay. Trang này gom các dự án có giao dịch <strong>căn hộ chuyển nhượng Đà Nẵng</strong> và tin bán căn hộ mới nhất trên website, để anh chị so sánh trước khi hẹn xem nhà.',
				'Các khu có nhiều căn chuyển nhượng gồm hai bờ sông Hàn (Sun Symphony, Sun Ponte, Peninsula, The Filmore), ven biển Mỹ Khê – Sơn Trà (Hiyori, các tòa căn hộ biển) và khu Nam thành phố như FPT City. Giá chuyển nhượng phụ thuộc rất nhiều vào tầng, view, tình trạng nội thất và căn đã có sổ hay mới ở dạng hợp đồng mua bán, nên cùng một dự án có thể chênh nhau đáng kể.',
				'Với căn đã có sổ, thủ tục là công chứng hợp đồng chuyển nhượng và sang tên tại văn phòng đăng ký đất đai; với căn chưa có sổ, giao dịch là chuyển nhượng hợp đồng mua bán, cần chủ đầu tư xác nhận. Trong cả hai trường hợp, nên kiểm tra tình trạng thế chấp, công nợ phí quản lý, hiện trạng căn và hợp đồng thuê đang có (nếu căn đang cho thuê), đồng thời tính đủ thuế, phí khi sang tên.',
				'Về ngân sách, căn hộ chuyển nhượng phù hợp cả người mua ở lần đầu lẫn nhà đầu tư cho thuê: có căn studio, 1 phòng ngủ cho người độc thân hoặc cho thuê ngắn hạn, căn 2 – 3 phòng ngủ cho gia đình. Ngoài giá bán, nên hỏi rõ phí quản lý, phí gửi xe, tình trạng nội thất đi kèm và thời điểm bàn giao nhà để tính đúng tổng chi phí.',
				'Tin bán trên website được Hoàng Hiệp kiểm tra thông tin cơ bản trước khi đăng. Anh chị cần căn theo ngân sách, số phòng ngủ hoặc view cụ thể, hãy để lại tiêu chí – Hiệp sẽ lọc 2–3 căn phù hợp nhất, đặt lịch xem và hỗ trợ đàm phán, thủ tục sang tên.',
			),
			'faq'     => array(
				array( 'Mua căn hộ chuyển nhượng Đà Nẵng cần kiểm tra gì?', 'Sổ hoặc hợp đồng mua bán gốc, tình trạng thế chấp, xác nhận của chủ đầu tư (căn chưa có sổ), công nợ phí quản lý, hiện trạng căn và hợp đồng thuê đang có nếu căn đang cho thuê.' ),
				array( 'Căn hộ chuyển nhượng có vay ngân hàng được không?', 'Được, với căn đã có sổ thường dễ hơn vì ngân hàng nhận thế chấp trực tiếp. Căn chưa có sổ tuỳ chính sách ngân hàng liên kết với dự án.' ),
				array( 'Thuế phí khi mua căn hộ chuyển nhượng là bao nhiêu?', 'Thông thường thuế thu nhập cá nhân 2% giá chuyển nhượng (bên bán), lệ phí trước bạ 0,5% (bên mua) cùng phí công chứng; hai bên có thể thỏa thuận khác trong hợp đồng.' ),
				array( 'Dự án nào ở Đà Nẵng có nhiều căn chuyển nhượng?', 'Các dự án đã bàn giao ven sông Hàn, ven biển Mỹ Khê và FPT City. Danh sách dự án và tin bán đang có nằm ngay trên trang này.' ),
			),
			'posts'   => array( 'gia-chuyen-nhuong-can-ho-da-nang-2026-theo-du-an', 'mua-can-ho-chuyen-nhuong-da-nang-quy-trinh-giay-to', 'thue-phi-mua-ban-nha-dat-da-nang-2026', 'sun-symphony-da-nang-gia-chuyen-nhuong-cho-thue', 'peninsula-da-nang-gia-chuyen-nhuong-cho-thue', 'the-filmore-da-nang-gia-chuyen-nhuong-cho-thue' ),
		),
		'dat-nen-hoa-xuan'         => array(
			'keyword' => 'đất nền Hòa Xuân',
			'h1'      => 'Đất nền Hòa Xuân',
			'title'   => 'Đất nền Hòa Xuân: dự án, khu vực, lô đang bán 2026',
			'desc'    => 'Đất nền Hòa Xuân, Nam Đà Nẵng: Cồn Dầu, khu đô thị sinh thái Hòa Xuân, Euro Village 2, đất ven sông Cẩm Lệ – pháp lý, hạ tầng cầu Hòa Xuân, lô đang bán.',
			'intro'   => array(
				'Hòa Xuân (Cẩm Lệ) là khu đất nền được quan tâm nhất phía Nam Đà Nẵng: quỹ đất ven sông Cẩm Lệ còn rộng, hạ tầng đường sá đã hình thành, gần trung tâm thành phố qua cầu Hòa Xuân và cầu Nguyễn Tri Phương. Trang này tổng hợp <strong>đất nền Hòa Xuân</strong> theo từng dự án và tin bán lô mới nhất, giúp anh chị so sánh vị trí, pháp lý và mặt bằng giá.',
				'Các khu chính gồm khu Cồn Dầu, khu đô thị sinh thái Hòa Xuân và các phân khu của Sun Group, khu biệt thự Euro Village 2 cùng dải đất ven sông. Mỗi khu có lợi thế riêng: lô ven sông, mặt tiền đường lớn hay gần tiện ích, trường học. Giá đất chênh nhiều theo bề rộng đường, hướng, vị trí góc và khoảng cách tới sông, nên cần xem từng lô cụ thể thay vì chỉ nhìn giá trung bình.',
				'Hạ tầng là động lực lớn cho khu vực: cụm nút giao cầu Hòa Xuân đang được triển khai, giúp kết nối trung tâm và Nam Hòa Xuân thuận tiện hơn. Tuy vậy, giá trị thật đến khi công trình hoàn thành, vì vậy người mua nên ưu tiên lô có sổ riêng, đúng quy hoạch, đường đã thông và tính thời gian nắm giữ phù hợp với nguồn vốn.',
				'Đất nền Hòa Xuân phù hợp ba nhóm khách: gia đình muốn tự xây nhà ở gần trung tâm nhưng không gian thoáng, người mua để xây nhà cho thuê hoặc kinh doanh nhỏ trên các trục đường lớn, và nhà đầu tư nắm giữ trung – dài hạn theo tiến độ hạ tầng. Mỗi nhóm nên chọn loại lô khác nhau về bề rộng mặt tiền, hướng và vị trí.',
				'Trước khi đặt cọc, nên kiểm tra sổ, quy hoạch chi tiết, chỉ giới xây dựng, tình trạng thế chấp và tranh chấp của lô. Hoàng Hiệp hỗ trợ gửi bảng hàng các lô đang bán, đối chiếu quy hoạch và đi xem thực tế cùng anh chị – liên hệ qua điện thoại hoặc Zalo.',
			),
			'faq'     => array(
				array( 'Đất nền Hòa Xuân thuộc quận nào?', 'Hòa Xuân thuộc khu vực Cẩm Lệ, phía Nam thành phố Đà Nẵng, ven sông Cẩm Lệ – kết nối trung tâm qua cầu Hòa Xuân và cầu Nguyễn Tri Phương.' ),
				array( 'Đất nền Hòa Xuân có sổ chưa?', 'Nhiều lô trong các khu đã hình thành hạ tầng có sổ riêng; một số dự án mới đang hoàn thiện thủ tục. Cần kiểm tra sổ của đúng lô trước khi đặt cọc.' ),
				array( 'Cầu Hòa Xuân ảnh hưởng gì đến giá đất?', 'Cụm nút giao cầu Hòa Xuân giúp lưu thông thuận tiện hơn, là yếu tố hỗ trợ giá trị khu vực về dài hạn; nên mua theo nhu cầu thật và không mua theo tin đồn.' ),
				array( 'Mua đất nền Hòa Xuân cần bao nhiêu vốn?', 'Tuỳ khu và diện tích lô; giá tham khảo từng khu có ở bài giá đất nền Hòa Xuân và trên các tin bán. Liên hệ để nhận bảng hàng theo ngân sách.' ),
			),
			'posts'   => array( 'dat-nen-hoa-xuan-2026-gia-theo-khu', 'cum-nut-giao-cau-hoa-xuan-bat-dong-san-nam-da-nang', 'bat-dong-san-cam-le-2026', 'bat-dong-san-nam-da-nang-ha-tang-hoa-xuan-hoa-quy-2026', 'kiem-tra-phap-ly-quy-hoach-nha-dat-da-nang', 'hop-dong-dat-coc-mua-nha-rui-ro-phong-tranh' ),
		),
	);
}

add_action(
	'init',
	static function () {
		add_rewrite_rule( '^(' . implode( '|', array_map( 'preg_quote', array_keys( hh_hub_pages() ) ) ) . ')/?$', 'index.php?post_type=du-an&hh_hub=$matches[1]', 'top' );
	},
	11
);
add_filter( 'query_vars', static fn( $vars ) => array_merge( $vars, array( 'hh_hub' ) ) );

/** Khóa hub đang xem ('' nếu không phải). */
function hh_hub_key() {
	$key = sanitize_key( (string) get_query_var( 'hh_hub' ) );
	return isset( hh_hub_pages()[ $key ] ) ? $key : '';
}

function hh_hub_url( $key ) {
	return home_url( '/' . $key . '/' );
}

/** Trang hub tự lấy dữ liệu (hh_hub_projects, hh_hub_listings) – truy vấn chính chỉ cần 1 bài để không 404. */
add_action(
	'pre_get_posts',
	static function ( $q ) {
		if ( ! is_admin() && $q->is_main_query() && $q->get( 'hh_hub' ) ) {
			$q->set( 'posts_per_page', 1 );
			$q->set( 'no_found_rows', true );
		}
	},
	5
);

/** Dự án của từng hub (lọc theo chủ đầu tư, loại, khu vực, tình trạng). */
function hh_hub_projects( $key ) {
	static $cache = array();
	if ( isset( $cache[ $key ] ) ) {
		return $cache[ $key ];
	}
	$ids = get_posts( array( 'post_type' => 'du-an', 'posts_per_page' => 300, 'fields' => 'ids', 'orderby' => 'title', 'order' => 'ASC' ) );
	$out = array();
	foreach ( $ids as $id ) {
		$types = wp_list_pluck( get_the_terms( $id, 'loai-du-an' ) ?: array(), 'slug' );
		$areas = wp_list_pluck( get_the_terms( $id, 'khu-vuc' ) ?: array(), 'slug' );
		$dev   = (string) hh_meta( 'hh_p_developer', $id );
		$addr  = (string) hh_meta( 'hh_p_address', $id ) . ' ' . get_the_title( $id );
		$apt   = array_intersect( $types, array( 'can-ho-so-huu-lau-dai', 'can-ho-dich-vu', 'cao-tang' ) ) || hh_is_high_rise( $id );
		$stat  = (string) hh_meta( 'hh_p_status', $id );
		switch ( $key ) {
			case 'can-ho-sun-group-da-nang':
				$ok = $apt && preg_match( '/Sun Group|Sun Property/i', $dev ) && ! wp_get_post_parent_id( $id );
				break;
			case 'biet-thu-hoi-an':
				$ok = in_array( 'biet-thu', $types, true ) && array_intersect( $areas, array( 'hoi-an', 'dien-ban', 'duy-xuyen' ) );
				break;
			case 'can-ho-chuyen-nhuong-da-nang':
				$ok = $apt && ( hh_project_is_resale( $id ) || in_array( $stat, array( 'da-ban-giao', 'dang-ban-giao' ), true ) );
				break;
			case 'dat-nen-hoa-xuan':
				$ok = ( in_array( 'dat-nen', $types, true ) || 'euro-village-2' === get_post_field( 'post_name', $id ) ) && false !== mb_stripos( $addr, 'Hòa Xuân' );
				break;
			default:
				$ok = false;
		}
		if ( $ok ) {
			$out[] = (int) $id;
		}
	}
	return $cache[ $key ] = $out; // phpcs:ignore Squiz.PHP.DisallowMultipleAssignments
}

/** Tin nhà đất mới nhất liên quan (căn hộ bán / đất nền Hòa Xuân). */
function hh_hub_listings( $key, $limit = 6 ) {
	$args = array( 'post_type' => 'bat-dong-san', 'posts_per_page' => $limit, 'fields' => 'ids', 'meta_query' => array( array( 'key' => 'hh_deal', 'value' => 'ban' ) ) );
	if ( 'can-ho-chuyen-nhuong-da-nang' === $key ) {
		$t = get_term_by( 'slug', 'can-ho-chung-cu', 'loai-bds' ) ?: get_term_by( 'slug', 'can-ho', 'loai-bds' );
		if ( ! $t ) {
			return array();
		}
		$args['tax_query'] = array( array( 'taxonomy' => 'loai-bds', 'terms' => $t->term_id, 'include_children' => true ) );
	} elseif ( 'dat-nen-hoa-xuan' === $key ) {
		$t = get_term_by( 'slug', 'dat-nen', 'loai-bds' );
		if ( ! $t ) {
			return array();
		}
		$args['tax_query'] = array( array( 'taxonomy' => 'loai-bds', 'terms' => $t->term_id, 'include_children' => true ) );
		$args['s']         = 'Hòa Xuân';
	} else {
		return array();
	}
	return get_posts( $args );
}

/** Bài viết liên quan đã đăng (bài chưa đến lịch đăng thì bỏ qua). */
function hh_hub_posts( $key ) {
	$out = array();
	foreach ( (array) ( hh_hub_pages()[ $key ]['posts'] ?? array() ) as $slug ) {
		$p = get_page_by_path( $slug, OBJECT, 'post' );
		if ( $p && 'publish' === $p->post_status ) {
			$out[] = $p->ID;
		}
	}
	return $out;
}

/** Ngày cập nhật thật (dự án, tin, bài mới nhất trên trang) – dùng cho sitemap lastmod. */
function hh_hub_lastmod( $key ) {
	$max = 0;
	foreach ( array_merge( hh_hub_projects( $key ), hh_hub_listings( $key ), hh_hub_posts( $key ) ) as $id ) {
		$max = max( $max, (int) get_post_modified_time( 'U', true, $id ) );
	}
	return $max;
}
