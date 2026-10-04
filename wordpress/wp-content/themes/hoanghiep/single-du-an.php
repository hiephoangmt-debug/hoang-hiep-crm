<?php
get_header();

while ( have_posts() ) :
	the_post();
	$id         = get_the_ID();
	$status_key = hh_meta( 'hh_p_status' );
	$status     = hh_option_label( hh_project_schema(), 'hh_p_status', $status_key );

	$connections = hh_project_connections();
	$nearby      = hh_project_nearby();
	$products    = hh_project_products();
	$price_table = hh_table( 'hh_p_price_table', 4 );
	$payment     = hh_table( 'hh_p_payment', 3 );
	$timeline    = hh_project_timeline();
	$faq         = hh_project_faq();
	$news        = hh_project_news();
	$gallery     = hh_ids( 'hh_p_gallery' );
	$type        = hh_project_type();
	$title       = get_the_title();
	$resale      = hh_project_is_resale();
	$market      = hh_project_market();
	$units_data  = function_exists( 'hh_units_data' ) ? hh_units_data( get_the_ID() ) : null;
	$has_market  = $resale || $market['ban']['count'] || $market['thue']['count'] || hh_meta( 'hh_p_resale_price' ) || hh_meta( 'hh_p_rent_price' );

	// Mọi trang dự án đều đủ các mục; mục chưa nhập sẽ tự soạn hoặc ghi "đang cập nhật".
	$sections = array(
		'gioi-thieu' => 'Giới thiệu',
		'tong-quan'  => 'Tổng quan',
		'giao-dich'  => $resale ? 'Chuyển nhượng & cho thuê' : '',
		'vi-tri'     => 'Vị trí',
		'lien-ket'   => 'Liên kết vùng',
		'tien-ich'   => 'Tiện ích',
		'mat-bang'   => 'Mặt bằng',
		'gio-hang'   => hh_table( 'hh_p_hot_units', 5 ) ? 'Giỏ hàng' : '',
		'san-pham'   => 'Loại sản phẩm',
		'chinh-sach' => $resale ? 'Giá chuyển nhượng' : 'Chính sách',
		'thu-cap'    => ! $resale && $has_market ? 'Chuyển nhượng & cho thuê' : '',
		'tien-do'    => 'Tiến độ',
		'thu-vien'   => ( $gallery || hh_meta( 'hh_p_video' ) ) ? 'Hình ảnh' : '',
		'tin-tuc'    => 'Tin tức',
		'hoi-dap'    => 'Hỏi đáp',
		'lien-he'    => 'Liên hệ',
	);
	$sections = array_filter( $sections );

	// Kêu gọi để lại thông tin ở từng mục.
	$msg  = static fn( $text ) => $text . ' ' . $title . '.';
	$ctas = $resale ? array(
		'gioi-thieu' => array( 'icon' => 'gift', 'variant' => 'offer', 'title' => 'Tìm căn ' . $title . ' giá tốt', 'text' => 'Hiệp gửi danh sách căn chuyển nhượng, cho thuê đang có kèm giá thật và ảnh thực tế – cập nhật hằng tuần.', 'button' => 'Nhận danh sách căn', 'need' => 'Mua', 'msg' => $msg( 'Gửi tôi danh sách căn đang bán / cho thuê tại' ) ),
		'tong-quan'  => array( 'icon' => 'shield', 'title' => 'Kiểm tra pháp lý trước khi xuống tiền', 'text' => 'Hiệp kiểm tra sổ hồng, tình trạng thế chấp và hợp đồng của căn bạn quan tâm – miễn phí.', 'button' => 'Nhờ kiểm tra pháp lý', 'need' => 'Mua', 'msg' => $msg( 'Nhờ kiểm tra pháp lý căn tôi quan tâm tại' ) ),
		'vi-tri'     => array( 'icon' => 'pin', 'title' => 'Xem căn thực tế cùng Hiệp', 'text' => 'Hẹn lịch xem các căn đang trống vào thời gian bạn rảnh, kể cả cuối tuần.', 'button' => 'Đặt lịch xem căn', 'need' => 'Đặt lịch xem nhà', 'msg' => $msg( 'Tôi muốn hẹn lịch xem căn tại' ) ),
		'tien-ich'   => array( 'icon' => 'building', 'title' => 'Nhận ảnh, video thực tế', 'text' => 'Bộ ảnh và video thực tế căn hộ, hồ bơi, gym, cảnh quan để bạn đánh giá đúng chất lượng sống.', 'button' => 'Nhận ảnh & video', 'need' => 'Mua', 'msg' => $msg( 'Gửi tôi ảnh, video thực tế' ) ),
		'mat-bang'   => array( 'icon' => 'handshake', 'title' => 'Bạn có căn ' . $title . ' cần bán hoặc cho thuê?', 'text' => 'Ký gửi với Hiệp: định giá miễn phí, chụp ảnh, đăng tin và dẫn khách xem tận nơi.', 'button' => 'Ký gửi căn', 'need' => 'Ký gửi bán / cho thuê', 'msg' => $msg( 'Tôi muốn ký gửi căn hộ tại' ) ),
		'san-pham'   => array( 'icon' => 'star', 'title' => 'Báo giá căn đúng nhu cầu', 'text' => 'Cho Hiệp biết diện tích, tầng, hướng và ngân sách – Hiệp lọc 3 – 5 căn phù hợp nhất kèm giá.', 'button' => 'Nhận căn phù hợp', 'need' => 'Mua', 'msg' => $msg( 'Tìm giúp tôi căn phù hợp tại' ) ),
		'chinh-sach' => array( 'icon' => 'gift', 'variant' => 'offer', 'title' => 'Tính khoản vay khi mua căn chuyển nhượng', 'text' => 'Hiệp lập phương án vay ngân hàng, số tiền trả mỗi tháng và thủ tục sang tên phù hợp số vốn của bạn.', 'button' => 'Nhận phương án tài chính', 'need' => 'Tư vấn đầu tư', 'msg' => $msg( 'Tư vấn phương án vay khi mua căn tại' ), 'link' => '#tai-chinh', 'link_text' => 'Hoặc tự tính bằng bảng tính →' ),
		'tien-do'    => array( 'icon' => 'clock', 'title' => 'Báo ngay khi có căn mới', 'text' => 'Căn giá tốt thường được giao dịch trong vài ngày. Để lại số điện thoại, Hiệp báo bạn đầu tiên.', 'button' => 'Đăng ký nhận căn mới', 'need' => 'Mua', 'msg' => $msg( 'Báo tôi khi có căn mới tại' ) ),
		'hoi-dap'    => array( 'icon' => 'phone', 'title' => 'Chưa thấy câu trả lời bạn cần?', 'text' => 'Gọi hoặc nhắn Zalo cho Hiệp – trả lời ngay trong giờ làm việc ' . hoanghiep_opt( 'hh_hours' ) . '.', 'button' => 'Gửi câu hỏi', 'need' => 'Tư vấn đầu tư', 'msg' => $msg( 'Tôi cần hỏi thêm về' ) ),
	) : array(
		'gioi-thieu' => array( 'icon' => 'gift', 'variant' => 'offer', 'title' => 'Giữ chỗ căn đẹp ' . $title . ' trước khi hết', 'text' => 'Hiệp gửi rổ hàng, giá từng căn và chính sách ưu đãi đang áp dụng – miễn phí, không ràng buộc.', 'button' => 'Nhận rổ hàng & ưu đãi', 'need' => 'Nhận bảng giá dự án', 'msg' => $msg( 'Gửi tôi rổ hàng và chính sách ưu đãi' ) ),
		'tong-quan'  => array( 'icon' => 'file', 'title' => 'Nhận trọn bộ hồ sơ ' . $title, 'text' => 'Brochure, mặt bằng, pháp lý và bảng giá chi tiết – gửi qua Zalo chỉ sau vài phút.', 'button' => 'Nhận hồ sơ dự án', 'need' => 'Nhận bảng giá dự án', 'msg' => $msg( 'Gửi tôi brochure, pháp lý và bảng giá' ) ),
		'vi-tri'     => array( 'icon' => 'pin', 'title' => 'Đi xem thực tế cùng Hiệp', 'text' => 'Hẹn lịch xem vị trí, nhà mẫu và căn đang trống vào thời gian bạn rảnh, kể cả cuối tuần.', 'button' => 'Đặt lịch tham quan', 'need' => 'Đặt lịch xem nhà', 'msg' => $msg( 'Tôi muốn đặt lịch tham quan dự án, nhà mẫu' ) ),
		'tien-ich'   => array( 'icon' => 'building', 'title' => 'Xem ảnh, video thực tế tiện ích', 'text' => 'Bộ ảnh và video hồ bơi, gym, cảnh quan, nhà mẫu để bạn đánh giá đúng chất lượng sống.', 'button' => 'Nhận ảnh & video', 'need' => 'Nhận bảng giá dự án', 'msg' => $msg( 'Gửi tôi ảnh, video thực tế tiện ích và nhà mẫu' ) ),
		'mat-bang'   => array( 'icon' => 'star', 'title' => 'Căn đẹp thường hết sớm nhất', 'text' => 'Căn góc, tầng cao, view đẹp được giữ chỗ trước. Để lại số điện thoại để nhận danh sách căn còn trống kèm mặt bằng từng căn.', 'button' => 'Nhận danh sách căn trống', 'need' => 'Nhận bảng giá dự án', 'msg' => $msg( 'Gửi tôi danh sách căn còn trống và mặt bằng' ) ),
		'san-pham'   => array( 'icon' => 'star', 'title' => 'Báo giá căn đúng nhu cầu', 'text' => 'Cho Hiệp biết loại căn, tầng, hướng và ngân sách – Hiệp lọc 3 – 5 căn phù hợp nhất kèm giá và chiết khấu.', 'button' => 'Nhận căn phù hợp', 'need' => 'Nhận bảng giá dự án', 'msg' => $msg( 'Lọc giúp tôi căn phù hợp và báo giá' ) ),
		'chinh-sach' => array( 'icon' => 'gift', 'variant' => 'offer', 'title' => 'Tính dòng tiền riêng cho bạn', 'text' => 'Cho Hiệp biết số vốn hiện có – Hiệp lập phương án thanh toán, chiết khấu và vay ngân hàng tiết kiệm nhất cho bạn.', 'button' => 'Nhận phương án tài chính', 'need' => 'Tư vấn đầu tư', 'msg' => $msg( 'Lập giúp tôi phương án thanh toán và vay ngân hàng' ), 'link' => '#tai-chinh', 'link_text' => 'Hoặc tự tính bằng bảng tính →' ),
		'tien-do'    => array( 'icon' => 'clock', 'title' => 'Nhận ảnh tiến độ mỗi tháng qua Zalo', 'text' => 'Theo dõi công trường mà không cần đến tận nơi – Hiệp gửi ảnh, video thi công mới nhất.', 'button' => 'Đăng ký nhận tiến độ', 'need' => 'Nhận bảng giá dự án', 'msg' => $msg( 'Gửi tôi ảnh tiến độ hằng tháng' ) ),
		'hoi-dap'    => array( 'icon' => 'phone', 'title' => 'Chưa thấy câu trả lời bạn cần?', 'text' => 'Gọi hoặc nhắn Zalo cho Hiệp – trả lời ngay trong giờ làm việc ' . hoanghiep_opt( 'hh_hours' ) . '.', 'button' => 'Gửi câu hỏi', 'need' => 'Tư vấn đầu tư', 'msg' => $msg( 'Tôi cần hỏi thêm về' ) ),
	);

	$key_facts = array_filter(
		array(
			'Giá bán'   => $resale ? '' : ( hh_meta( 'hh_p_price_from' ) ? hh_project_price() : 'Liên hệ' ),
			'Giá chuyển nhượng' => $resale ? ( hh_meta( 'hh_p_resale_price' ) ?: ( $market['ban']['range'] ? hh_ucfirst( $market['ban']['range'] ) : 'Liên hệ' ) ) : '',
			'Đang giao dịch'    => $resale ? $market['ban']['count'] . ' căn bán · ' . $market['thue']['count'] . ' căn thuê' : '',
			'Loại hình' => hh_project_types_label(),
			'Quy mô'    => hh_meta( 'hh_p_scale' ),
			'Sản phẩm'  => hh_meta( 'hh_p_unit_area' ),
			'Bàn giao'  => hh_meta( 'hh_p_handover' ),
			'Pháp lý'   => hh_meta( 'hh_p_legal' ),
		)
	);
	?>
	<section class="project-hero">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'hh-hero', array( 'class' => 'project-hero__bg', 'alt' => '' ) ); ?>
		<?php endif; ?>
		<div class="container project-hero__content">
			<div class="project-hero__main">
			<p class="breadcrumb breadcrumb--light">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a> / <a href="<?php echo esc_url( get_post_type_archive_link( 'du-an' ) ); ?>">Dự án</a>
			</p>
			<?php $parent_id = (int) hh_meta( 'hh_p_parent' ); ?>
			<?php if ( $parent_id && 'publish' === get_post_status( $parent_id ) ) : ?>
				<a class="parent-link" href="<?php echo esc_url( get_permalink( $parent_id ) ); ?>"><?php echo esc_html( hh_parent_label( $parent_id ) ); ?> <strong><?php echo esc_html( get_the_title( $parent_id ) ); ?></strong> <?php echo hh_icon( 'arrow' ); // phpcs:ignore ?></a>
			<?php endif; ?>
			<?php hh_pill( $status, $status_key ); ?>
			<?php if ( '1' === hh_meta( 'hh_p_sold_out' ) ) : ?><span class="pill pill--sold">Đã bán hết</span><?php endif; ?>
			<?php foreach ( get_the_terms( $id, 'loai-du-an' ) ?: array() as $t ) : ?><?php if ( $t->parent ) : ?><a class="pill pill--type" href="<?php echo esc_url( get_term_link( $t ) ); ?>"><?php echo esc_html( $t->name ); ?></a><?php endif; ?><?php endforeach; ?>
			<h1 class="project-hero__title"><?php the_title(); ?></h1>
			<?php if ( hh_meta( 'hh_p_developer' ) ) : ?>
				<p class="project-hero__dev">Chủ đầu tư: <?php echo esc_html( hh_meta( 'hh_p_developer' ) ); ?></p>
			<?php endif; ?>
			<?php if ( hh_meta( 'hh_p_address' ) ) : ?>
				<p class="project-hero__addr"><?php echo hh_icon( 'pin' ); // phpcs:ignore ?> <?php echo esc_html( hh_meta( 'hh_p_address' ) ); ?></p>
			<?php endif; ?>
			<p class="project-hero__updated">Cập nhật: <time datetime="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>"><?php echo esc_html( get_the_modified_date( 'd/m/Y' ) ); ?></time></p>
			<div class="hero__actions">
				<?php if ( $resale ) : ?>
					<a class="btn btn--gold" href="#giao-dich">Xem căn chuyển nhượng &amp; cho thuê</a>
				<?php endif; ?>
				<?php if ( hh_meta( 'hh_p_pricelist_url' ) ) : ?>
					<a class="btn btn--ghost" href="<?php echo esc_url( hh_meta( 'hh_p_pricelist_url' ) ); ?>" target="_blank" rel="noopener"><?php echo hh_icon( 'file' ); // phpcs:ignore ?> Tải brochure</a>
				<?php endif; ?>
			</div>
			</div>
			<aside class="hero-offer">
				<p class="hero-offer__title"><?php echo hh_icon( 'gift' ); // phpcs:ignore ?> <?php echo esc_html( $resale ? 'Căn chuyển nhượng, cho thuê đang có' : 'Ưu đãi & chính sách tháng ' . wp_date( 'm/Y' ) ); ?></p>
				<?php $hero_stats = $resale ? array() : array_slice( hh_table( 'hh_p_offer_stats', 2 ), 0, 4 ); ?>
				<?php if ( $hero_stats ) : ?>
					<?php $hero_dl = hh_parse_vn_date( hh_meta( 'hh_p_offer_deadline' ) ); ?>
					<?php if ( hh_meta( 'hh_p_offer_title' ) ) : ?>
						<p class="hero-offer__headline"><?php echo wp_kses( preg_replace( '/(\d+(?:[.,]\d+)?\s?%)/u', '<em>$1</em>', esc_html( hh_meta( 'hh_p_offer_title' ) ) ), array( 'em' => array() ) ); ?></p>
					<?php endif; ?>
					<ul class="hero-offer__stats">
						<?php foreach ( $hero_stats as list( $num, $label ) ) : ?>
							<li><b><?php echo esc_html( $num ); ?></b><span><?php echo esc_html( $label ); ?></span></li>
						<?php endforeach; ?>
					</ul>
					<?php if ( $hero_dl && $hero_dl > time() ) : ?>
						<p class="hero-offer__deadline"><?php echo hh_icon( 'clock' ); // phpcs:ignore ?> Còn <?php echo esc_html( (string) max( 1, (int) floor( ( $hero_dl - time() ) / DAY_IN_SECONDS ) ) ); ?> ngày – hạn <?php echo esc_html( wp_date( 'd/m/Y', $hero_dl ) ); ?></p>
					<?php endif; ?>
				<?php else : ?>
					<?php hh_check_list( $resale ? array( 'Danh sách căn bán, cho thuê kèm giá thật – cập nhật hằng tuần', 'Định giá miễn phí, kiểm tra sổ hồng trước khi giao dịch', 'Ký gửi bán / cho thuê căn của bạn' ) : hh_project_offer() ); ?>
				<?php endif; ?>
				<?php
				echo hh_lead_form( // phpcs:ignore
					array(
						'ref_id'  => $id,
						'title'   => '',
						'compact' => true,
						'need'    => $resale ? 'Mua' : 'Nhận bảng giá dự án',
						'message' => ( $resale ? 'Gửi tôi danh sách căn đang bán / cho thuê tại ' : 'Gửi tôi bảng giá và chính sách ưu đãi mới nhất ' ) . $title . '. (Form đầu trang)',
						'button'  => $resale ? 'Nhận danh sách căn' : 'Nhận bảng giá & ưu đãi',
					)
				);
				?>
				<?php if ( ! $resale ) : ?>
					<span class="hero-offer__note">Chính sách thay đổi theo từng đợt – đăng ký để nhận bản mới nhất.</span>
				<?php endif; ?>
			</aside>
		</div>
	</section>

	<div class="container">
		<dl class="key-facts">
			<?php foreach ( $key_facts as $label => $value ) : ?>
				<div><dt><?php echo esc_html( $label ); ?></dt><dd><?php echo esc_html( $value ); ?></dd></div>
			<?php endforeach; ?>
		</dl>
	</div>

	<nav class="subnav" aria-label="Mục lục dự án">
		<div class="container subnav__inner">
			<?php foreach ( $sections as $anchor => $label ) : ?>
				<a href="#<?php echo esc_attr( $anchor ); ?>"><?php echo esc_html( $label ); ?></a>
			<?php endforeach; ?>
		</div>
	</nav>

	<div class="container layout">
		<div class="layout__main">

			<section class="block" id="gioi-thieu">
				<h2 class="block__title">Giới thiệu <?php echo esc_html( $title ); ?></h2>
				<?php if ( ! $resale ) : ?>
					<?php get_template_part( 'template-parts/project-hook' ); ?>
				<?php endif; ?>
				<?php if ( has_excerpt() ) : ?>
					<p class="lead"><?php echo esc_html( get_the_excerpt() ); ?></p>
				<?php endif; ?>
				<?php if ( trim( get_the_content() ) && ! hh_is_builder_page() ) : ?>
					<div class="entry-content"><?php the_content(); ?></div>
				<?php else : ?>
					<div class="entry-content">
						<?php foreach ( hh_project_intro() as $para ) : ?>
							<p><?php echo esc_html( $para ); ?></p>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
				<?php if ( hh_lines( 'hh_p_highlights' ) ) : ?>
					<h3 class="block__sub">Điểm nổi bật</h3>
					<?php hh_check_list( hh_lines( 'hh_p_highlights' ), 'check-list check-list--boxed' ); ?>
				<?php endif; ?>
				<?php hh_cta_box( $ctas['gioi-thieu'] ); ?>
			</section>

			<section class="block" id="tong-quan">
				<h2 class="block__title">Tổng quan dự án</h2>
				<?php hh_spec_list( hh_project_specs() ); ?>
				<?php $zones = hh_table( 'hh_p_zones', 4 ); ?>
				<?php if ( $zones ) : ?>
					<h3 class="block__sub">Các phân khu &amp; loại sản phẩm</h3>
					<?php hh_data_table( array( 'Phân khu', 'Loại sản phẩm', 'Quy mô', 'Tình trạng' ), $zones ); ?>
				<?php endif; ?>
				<?php
				$subzones = new WP_Query(
					array(
						'post_type'      => 'du-an',
						'posts_per_page' => 12,
						'post__not_in'   => array( $id ),
						'meta_query'     => array( array( 'key' => 'hh_p_parent', 'value' => $id ) ),
						'orderby'        => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
						'no_found_rows'  => true,
					)
				);
				if ( $subzones->have_posts() ) :
					?>
					<h3 class="block__sub"><?php echo has_term( 'to-hop', 'loai-du-an', $id ) ? 'Dự án thành phần &amp; phân khu' : 'Phân khu có trang thông tin riêng'; ?></h3>
					<div class="grid grid--2">
						<?php
						while ( $subzones->have_posts() ) :
							$subzones->the_post();
							get_template_part( 'template-parts/project-card' );
						endwhile;
						wp_reset_postdata();
						?>
					</div>
				<?php endif; ?>
				<?php hh_cta_box( $ctas['tong-quan'] ); ?>
			</section>

			<?php if ( $resale ) : ?>
				<?php get_template_part( 'template-parts/project-market', null, array( 'id' => 'giao-dich', 'market' => $market, 'resale' => true ) ); ?>
			<?php endif; ?>

			<section class="block" id="vi-tri">
				<h2 class="block__title">Vị trí dự án</h2>
				<?php if ( hh_meta( 'hh_p_address' ) ) : ?>
					<p class="address-line"><?php echo hh_icon( 'pin' ); // phpcs:ignore ?> <strong><?php echo esc_html( hh_meta( 'hh_p_address' ) ); ?></strong></p>
				<?php endif; ?>
				<?php $profile = hh_project_area_profile(); ?>
				<?php if ( hh_meta( 'hh_p_location_desc' ) ) : ?>
					<p class="prose"><?php echo nl2br( esc_html( hh_meta( 'hh_p_location_desc' ) ) ); ?></p>
				<?php elseif ( $profile ) : ?>
					<p class="prose"><?php echo esc_html( $title . ' thuộc khu vực ' . $profile['name'] . '. ' . $profile['desc'] ); ?></p>
				<?php endif; ?>
				<?php hh_gallery( hh_ids( 'hh_p_location_img' ), 'vi-tri', 'gallery-single' ); ?>
				<?php
				// Tìm theo tên dự án (Google Maps nhận diện tốt hơn địa chỉ chung chung) nếu chưa nhập tọa độ / địa chỉ bản đồ.
				$map_name = trim( preg_replace( '/\s*\([^)]*\)/u', '', $title ) );
				$map_name = false === mb_stripos( $map_name, 'Đà Nẵng' ) ? $map_name . ', Đà Nẵng' : $map_name;
				hh_map( hh_meta( 'hh_p_map_address' ) ?: $map_name, hh_meta( 'hh_p_map_coords' ) );
				?>
				<?php hh_cta_box( $ctas['vi-tri'] ); ?>
			</section>

			<section class="block" id="lien-ket">
				<h2 class="block__title">Liên kết vùng</h2>
				<?php if ( $connections[0] ) : ?>
					<ul class="connections">
						<?php foreach ( $connections[0] as list( $time, $place ) ) : ?>
							<li><strong><?php echo esc_html( $time ); ?></strong><span><?php echo esc_html( $place ); ?></span></li>
						<?php endforeach; ?>
					</ul>
					<?php if ( $connections[1] ) : ?>
						<p class="note">Thời gian di chuyển bằng ô tô, tham khảo theo khu vực dự án; thực tế phụ thuộc giờ cao điểm.</p>
					<?php endif; ?>
				<?php else : ?>
					<?php hh_pending( 'Sơ đồ liên kết vùng của dự án đang được cập nhật.' ); ?>
				<?php endif; ?>
			</section>

			<section class="block" id="tien-ich">
				<h2 class="block__title">Tiện ích <?php echo esc_html( $title ); ?></h2>
				<?php $amenities = hh_lines( 'hh_p_amenities_in' ); ?>
				<?php if ( $amenities ) : ?>
					<p class="amenity-lead"><?php echo esc_html( implode( ' · ', array_slice( array_map( static fn( $a ) => preg_replace( '/\s*\(.*\)$/u', '', $a ), $amenities ), 0, 6 ) ) ); ?></p>
				<?php endif; ?>
				<?php get_template_part( 'template-parts/project-amenities', null, array( 'ids' => hh_ids( 'hh_p_amenities_img' ), 'names' => $amenities ) ); ?>
				<div class="two-col">
					<div>
						<h3 class="block__sub">Nội khu</h3>
						<?php if ( hh_lines( 'hh_p_amenities_in' ) ) : ?>
							<?php hh_check_list( hh_lines( 'hh_p_amenities_in' ) ); ?>
						<?php else : ?>
							<?php hh_pending( 'Danh sách tiện ích nội khu đang được cập nhật.', '' ); ?>
						<?php endif; ?>
					</div>
					<div>
						<h3 class="block__sub">Ngoại khu<?php echo $nearby[1] ? ' (khu vực xung quanh)' : ''; ?></h3>
						<?php if ( $nearby[0] ) : ?>
							<?php hh_check_list( $nearby[0] ); ?>
						<?php else : ?>
							<?php hh_pending( 'Tiện ích ngoại khu đang được cập nhật.' ); ?>
						<?php endif; ?>
					</div>
				</div>
				<?php hh_cta_box( $ctas['tien-ich'] ); ?>
			</section>

			<section class="block" id="mat-bang">
				<h2 class="block__title">Mặt bằng</h2>
				<?php $has_plan = hh_ids( 'hh_p_masterplan_img' ) || hh_meta( 'hh_p_design_desc' ) || hh_ids( 'hh_p_floorplans' ); ?>
				<?php hh_gallery( hh_ids( 'hh_p_masterplan_img' ), 'mat-bang-tong', 'gallery-single' ); ?>
				<?php if ( hh_meta( 'hh_p_design_desc' ) ) : ?>
					<p class="prose"><?php echo nl2br( esc_html( hh_meta( 'hh_p_design_desc' ) ) ); ?></p>
				<?php endif; ?>
				<?php if ( hh_ids( 'hh_p_floorplans' ) ) : ?>
					<h3 class="block__sub">Mặt bằng tầng <?php echo esc_html( $title ); ?></h3>
					<?php get_template_part( 'template-parts/project-floors', null, array( 'ids' => hh_ids( 'hh_p_floorplans' ) ) ); ?>
				<?php endif; ?>
				<?php if ( ! $has_plan ) : ?>
					<?php hh_pending( 'Mặt bằng tổng thể và mặt bằng chi tiết từng loại sản phẩm: liên hệ Hiệp để nhận bản PDF đầy đủ.', '' ); ?>
				<?php endif; ?>
				<?php hh_cta_box( $ctas['mat-bang'] ); ?>
			</section>

			<?php get_template_part( 'template-parts/project-hot-units' ); ?>

			<section class="block" id="san-pham">
				<h2 class="block__title">Loại sản phẩm</h2>
				<?php if ( $products ) : ?>
					<?php if ( count( $products ) > 1 ) : ?>
						<div class="ptabs" role="tablist">
							<?php $first = true; foreach ( $products as $key => $p ) : ?>
								<button type="button" role="tab" class="ptabs__tab<?php echo $first ? ' is-active' : ''; ?>" aria-selected="<?php echo $first ? 'true' : 'false'; ?>" data-ptab="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $p['label'] ); ?></button>
							<?php $first = false; endforeach; ?>
						</div>
					<?php endif; ?>
					<?php $first = true; foreach ( $products as $key => $p ) : ?>
						<div class="ptabs__panel<?php echo $first ? ' is-active' : ''; ?>" data-ppanel="<?php echo esc_attr( $key ); ?>">
							<h3 class="block__sub"><?php echo esc_html( $p['label'] ); ?></h3>
							<?php if ( $p['desc'] ) : ?>
								<p class="prose"><?php echo nl2br( esc_html( $p['desc'] ) ); ?></p>
							<?php endif; ?>
							<?php if ( $p['in_zones'] && ! $p['rows'] ) : ?>
								<?php hh_data_table( array( 'Phân khu', 'Loại sản phẩm', 'Quy mô', 'Tình trạng' ), $p['in_zones'] ); ?>
							<?php endif; ?>
							<?php if ( 'can-ho' === $key && count( $p['rows'] ) > 1 ) : ?>
								<?php get_template_part( 'template-parts/project-units', null, array( 'rows' => $p['rows'] ) ); ?>
							<?php else : ?>
								<?php hh_data_table( $p['cols'], $p['rows'] ); ?>
							<?php endif; ?>
							<?php hh_gallery( $p['gallery'], 'san-pham-' . $key ); ?>
							<?php if ( defined( 'HH_SPECIAL_PAGES' ) && isset( HH_SPECIAL_PAGES[ $key ] ) && ! $resale ) : ?>
								<p class="note"><a href="<?php echo esc_url( hh_special_url( $key ) ); ?>">So sánh <?php echo esc_html( hh_lcfirst( $p['label'] ) ); ?> các dự án đang mở bán tại Đà Nẵng →</a></p>
							<?php endif; ?>
							<?php if ( ! $p['rows'] ) : ?>
								<?php hh_pending( $resale ? 'Liên hệ để nhận danh sách ' . hh_lcfirst( $p['label'] ) . ' đang chuyển nhượng, cho thuê trong dự án.' : 'Rổ hàng ' . hh_lcfirst( $p['label'] ) . ' (mã căn, diện tích, giá) đang được cập nhật theo từng đợt mở bán.', $resale ? 'Nhận danh sách căn' : 'Nhận rổ hàng' ); ?>
							<?php endif; ?>
						</div>
					<?php $first = false; endforeach; ?>
				<?php else : ?>
					<?php hh_pending( 'Thông tin các loại sản phẩm đang được cập nhật.', 'Nhận rổ hàng' ); ?>
				<?php endif; ?>
				<?php if ( $units_data ) : ?>
					<p><a class="btn btn--navy" href="<?php echo esc_url( hh_units_url( $id ) ); ?>">Xem bảng giá &amp; tính giá từng căn (<?php echo esc_html( hh_units_summary( $units_data ) ); ?>)</a></p>
				<?php endif; ?>
				<?php hh_cta_box( $ctas['san-pham'] ); ?>
			</section>

			<section class="block" id="chinh-sach">
				<?php if ( $resale ) : ?>
					<h2 class="block__title">Giá chuyển nhượng <?php echo esc_html( $title ); ?></h2>
					<p class="prose"><?php echo esc_html( '1' === hh_meta( 'hh_p_sold_out' ) ? $title . ' đã bán hết từ chủ đầu tư.' : $title . ' đã bàn giao.' ); ?> Giá hiện nay là giá chuyển nhượng giữa các chủ nhà, tùy vị trí, tầng, view và nội thất – xem các căn đang bán ở mục <a href="#giao-dich">Chuyển nhượng &amp; cho thuê</a>.</p>
					<?php if ( $price_table ) : ?>
						<h3 class="block__sub">Bảng giá gốc của chủ đầu tư (tham khảo)</h3>
						<?php hh_data_table( array( 'Sản phẩm', 'Diện tích', 'Giá bán', 'Ghi chú' ), $price_table ); ?>
					<?php endif; ?>
					<?php if ( $payment ) : ?>
						<h3 class="block__sub">Lịch thanh toán gốc</h3>
						<?php hh_data_table( array( 'Đợt', 'Thời điểm', 'Tỷ lệ' ), $payment ); ?>
					<?php endif; ?>
				<?php else : ?>
					<h2 class="block__title">Chính sách <?php echo esc_html( $title ); ?><?php echo hh_parse_vn_date( hh_meta( 'hh_p_offer_start' ) ) ? ' – <span class="block__title-em">áp dụng từ ' . esc_html( wp_date( 'd/m/Y', hh_parse_vn_date( hh_meta( 'hh_p_offer_start' ) ) ) ) . '</span>' : ''; // phpcs:ignore ?></h2>
					<?php $compact = (bool) hh_table( 'hh_p_offer_stats', 2 ); ?>
					<?php get_template_part( 'template-parts/project-offer', null, array( 'part' => $compact ? 'banner' : 'all' ) ); ?>
					<?php if ( $compact ) : ?>
						<details class="policy-more">
							<summary>Xem chi tiết: chiết khấu từng phương án, lịch thanh toán, vay ngân hàng</summary>
							<?php get_template_part( 'template-parts/project-offer', null, array( 'part' => 'discount' ) ); ?>
					<?php endif; ?>
					<?php if ( $units_data ) : ?>
						<a class="units-link" href="<?php echo esc_url( hh_units_url( $id ) ); ?>">
							<strong>Bảng tính căn chi tiết – <?php echo esc_html( hh_units_summary( $units_data ) ); ?></strong>
							<span><?php echo $units_data['units'] ? 'Chọn căn' : 'Nhập giá căn'; ?> → giá sau chiết khấu, lịch thanh toán, khoản vay. Cập nhật <?php echo esc_html( wp_date( 'd/m/Y', (int) $units_data['at'] ) ); ?></span>
						</a>
					<?php endif; ?>
					<h3 class="block__sub">Bảng giá</h3>
					<?php if ( $price_table ) : ?>
						<?php hh_data_table( array( 'Sản phẩm', 'Diện tích', 'Giá bán', 'Ghi chú' ), $price_table ); ?>
					<?php else : ?>
						<?php hh_pending( 'Giá ' . $title . ' thay đổi theo từng đợt mở bán và vị trí căn. Liên hệ để nhận bảng giá mới nhất.', '' ); ?>
					<?php endif; ?>
					<h3 class="block__sub">Lịch thanh toán</h3>
					<?php if ( $payment ) : ?>
						<?php hh_data_table( array( 'Đợt', 'Thời điểm', 'Tỷ lệ' ), $payment ); ?>
					<?php else : ?>
						<?php hh_pending( 'Lịch thanh toán chuẩn và các phương án thanh toán nhanh / vay ngân hàng đang được cập nhật.', '' ); ?>
					<?php endif; ?>
				<?php endif; ?>
				<?php if ( hh_lines( 'hh_p_policy' ) ) : ?>
					<div class="policy">
						<h3 class="block__sub">Chính sách &amp; ưu đãi</h3>
						<?php hh_check_list( hh_lines( 'hh_p_policy' ) ); ?>
					</div>
				<?php endif; ?>
				<?php if ( hh_meta( 'hh_p_loan' ) ) : ?>
					<h3 class="block__sub">Hỗ trợ vay ngân hàng</h3>
					<p class="prose"><?php echo nl2br( esc_html( hh_meta( 'hh_p_loan' ) ) ); ?></p>
				<?php endif; ?>
				<?php if ( hh_meta( 'hh_p_rental' ) ) : ?>
					<div class="policy">
						<h3 class="block__sub">Chương trình cho thuê &amp; lợi nhuận</h3>
						<p class="prose"><?php echo nl2br( esc_html( hh_meta( 'hh_p_rental' ) ) ); ?></p>
					</div>
				<?php endif; ?>
				<?php if ( ! $resale && ! empty( $compact ) ) : ?>
					</details>
				<?php endif; ?>
				<?php if ( hh_meta( 'hh_p_pricelist_url' ) ) : ?>
					<p><a class="btn btn--outline" href="<?php echo esc_url( hh_meta( 'hh_p_pricelist_url' ) ); ?>" target="_blank" rel="noopener"><?php echo hh_icon( 'file' ); // phpcs:ignore ?> Tải bảng giá / brochure</a></p>
				<?php endif; ?>
				<p class="note">Giá và chính sách có thể thay đổi theo từng đợt mở bán. Liên hệ để nhận thông tin mới nhất.</p>
				<?php hh_cta_box( $ctas['chinh-sach'] ); ?>
			</section>

			<?php if ( ! $resale && $has_market ) : ?>
				<?php get_template_part( 'template-parts/project-market', null, array( 'id' => 'thu-cap', 'market' => $market, 'resale' => false ) ); ?>
			<?php endif; ?>

			<section class="block" id="tien-do">
				<h2 class="block__title">Cập nhật tiến độ</h2>
				<?php if ( $timeline[0] ) : ?>
					<ol class="timeline">
						<?php foreach ( $timeline[0] as list( $when, $what ) ) : ?>
							<li><time><?php echo esc_html( $when ); ?></time><span><?php echo esc_html( $what ); ?></span></li>
						<?php endforeach; ?>
					</ol>
				<?php endif; ?>
				<?php hh_gallery( hh_ids( 'hh_p_progress_gallery' ), 'tien-do' ); ?>
				<?php if ( $timeline[1] && ! hh_ids( 'hh_p_progress_gallery' ) ) : ?>
					<?php hh_pending( 'Hình ảnh và báo cáo tiến độ thi công thực tế được cập nhật định kỳ.', '' ); ?>
				<?php endif; ?>
				<?php hh_cta_box( $ctas['tien-do'] ); ?>
			</section>

			<?php if ( isset( $sections['thu-vien'] ) ) : ?>
				<section class="block" id="thu-vien">
					<h2 class="block__title">Hình ảnh &amp; video</h2>
					<?php hh_video( hh_meta( 'hh_p_video' ) ); ?>
					<?php hh_gallery( $gallery, 'thu-vien' ); ?>
				</section>
			<?php endif; ?>

			<section class="block" id="tin-tuc">
				<h2 class="block__title">Tin tức <?php echo esc_html( $title ); ?></h2>
				<?php if ( $news && $news->have_posts() ) : ?>
					<div class="grid grid--2">
						<?php
						while ( $news->have_posts() ) :
							$news->the_post();
							get_template_part( 'template-parts/post-card' );
						endwhile;
						wp_reset_postdata();
						?>
					</div>
				<?php else : ?>
					<?php hh_pending( 'Chưa có bài viết riêng về ' . $title . '. Đăng ký để nhận tin mở bán, bảng giá và tiến độ mới nhất.', 'Đăng ký nhận tin' ); ?>
				<?php endif; ?>
			</section>

			<section class="block" id="hoi-dap">
				<h2 class="block__title">Câu hỏi thường gặp</h2>
				<div class="faq">
					<?php foreach ( $faq as list( $q, $a ) ) : ?>
						<details><summary><?php echo esc_html( $q ); ?></summary><p><?php echo esc_html( $a ); ?></p></details>
					<?php endforeach; ?>
				</div>
				<?php hh_cta_box( $ctas['hoi-dap'] ); ?>
			</section>

			<section class="block contact-block" id="lien-he">
				<div class="contact-block__text">
					<h2 class="block__title">Liên hệ tư vấn <?php echo esc_html( $title ); ?></h2>
					<p>Để lại thông tin, Hiệp sẽ gọi lại và gửi bạn:</p>
					<?php hh_check_list( $resale ? array( 'Danh sách căn chuyển nhượng, cho thuê mới nhất', 'Định giá, kiểm tra pháp lý, sổ hồng từng căn', 'Hỗ trợ vay ngân hàng, thủ tục sang tên', 'Ký gửi bán / cho thuê căn của bạn' ) : array( 'Bảng giá, rổ hàng căn đẹp mới nhất', 'Lịch thanh toán, chính sách chiết khấu, hỗ trợ vay', 'Mặt bằng, brochure, pháp lý dự án', 'Lịch đi xem dự án, nhà mẫu' ) ); ?>
					<p class="contact-block__phone">
						<a class="btn btn--gold" href="tel:<?php echo esc_attr( hoanghiep_tel() ); ?>"><?php echo hh_icon( 'phone' ); // phpcs:ignore ?> <?php echo esc_html( hoanghiep_opt( 'hh_phone' ) ); ?></a>
						<a class="btn btn--zalo" href="https://zalo.me/<?php echo esc_attr( hoanghiep_tel( hoanghiep_opt( 'hh_zalo' ) ) ); ?>" target="_blank" rel="noopener">Chat Zalo</a>
					</p>
				</div>
				<?php
				echo hh_lead_form( // phpcs:ignore
					array(
						'ref_id' => $id,
						'title'  => $resale ? 'Nhận danh sách căn & tư vấn' : 'Nhận bảng giá & chính sách',
						'need'   => $resale ? 'Mua' : 'Nhận bảng giá dự án',
						'button' => $resale ? 'Gửi yêu cầu' : 'Nhận bảng giá',
					)
				);
				?>
			</section>

			<details class="calc-fold" id="tai-chinh">
				<summary><?php echo hh_icon( 'file' ); // phpcs:ignore ?> <span>Bảng tính dòng tiền &amp; vay ngân hàng <?php echo esc_html( $title ); ?></span><em>Bấm để mở</em></summary>
				<div class="calc-fold__body">
					<?php get_template_part( 'template-parts/finance', null, array( 'mode' => 'project' ) ); ?>
				</div>
			</details>
		</div>

		<aside class="layout__side">
			<div class="sticky">
				<?php hh_agent_card( true ); ?>
				<div class="side-box">
					<p class="side-box__title">Nhận ngay về <?php echo esc_html( $title ); ?></p>
					<?php hh_check_list( $resale ? array( 'Căn chuyển nhượng, cho thuê mới nhất', 'Định giá & kiểm tra pháp lý', 'Ký gửi căn của bạn' ) : array( 'Bảng giá & rổ hàng mới nhất', 'Lịch thanh toán, chính sách', 'Mặt bằng, brochure' ) ); ?>
					<a class="btn btn--navy btn--block" href="#lien-he"><?php echo $resale ? 'Nhận danh sách căn' : 'Nhận bảng giá'; ?></a>
				</div>
			</div>
		</aside>
	</div>

	<?php
	// Phía dưới: dự án hot mới – ưu tiên cùng nhóm (cao tầng / thấp tầng), chỉ dự án.
	$group = null;
	if ( $type ) {
		$ancestors = get_ancestors( $type->term_id, 'loai-du-an', 'taxonomy' );
		$group     = $ancestors ? get_term( (int) end( $ancestors ), 'loai-du-an' ) : $type;
	}
	$hot = hh_hot_query( 'du-an', array( 'exclude' => array( $id ), 'limit' => 6, 'type_term' => $group ? $group->term_id : 0 ) );
	if ( $hot->post_count < 3 && $group ) {
		$hot = hh_hot_query( 'du-an', array( 'exclude' => array( $id ), 'limit' => 6 ) );
	}
	if ( $hot->have_posts() ) :
		?>
		<section class="section section--tint">
			<div class="container">
				<?php hh_section_head( 'Dự án', 'Dự án hot mới', $group ? get_term_link( $group ) : get_post_type_archive_link( 'du-an' ) ); ?>
				<div class="grid grid--3">
					<?php
					while ( $hot->have_posts() ) :
						$hot->the_post();
						get_template_part( 'template-parts/project-card' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
		</section>
	<?php endif; ?>
	<div class="lead-pop" id="lead-pop" role="dialog" aria-modal="true" aria-labelledby="lead-pop-title" hidden>
		<div class="lead-pop__box">
			<button type="button" class="lead-pop__close" aria-label="Đóng">&times;</button>
			<p class="lead-pop__eyebrow"><?php echo hh_icon( 'gift' ); // phpcs:ignore ?> <?php echo esc_html( $resale ? 'Căn mới mỗi tuần' : 'Ưu đãi tháng ' . wp_date( 'm/Y' ) ); ?></p>
			<p class="lead-pop__title" id="lead-pop-title"><?php echo esc_html( ( $resale ? 'Nhận danh sách căn ' : 'Nhận bảng giá & ưu đãi ' ) . $title ); ?></p>
			<?php hh_check_list( $resale ? array( 'Căn bán, cho thuê kèm giá thật', 'Định giá, kiểm tra pháp lý miễn phí' ) : array_slice( hh_project_offer(), 0, 2 ) ); ?>
			<?php
			echo hh_lead_form( // phpcs:ignore
				array(
					'ref_id'  => $id,
					'title'   => '',
					'compact' => true,
					'need'    => $resale ? 'Mua' : 'Nhận bảng giá dự án',
					'message' => ( $resale ? 'Gửi tôi danh sách căn đang bán / cho thuê tại ' : 'Gửi tôi bảng giá và chính sách ưu đãi mới nhất ' ) . $title . '. (Popup)',
					'button'  => 'Gửi cho tôi',
				)
			);
			?>
		</div>
	</div>
	<?php
endwhile;

get_footer();
