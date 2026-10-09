<?php
/**
 * Trang ngoại ngữ (/en/, /ko/) cho khách nước ngoài: giới thiệu, quy định sở hữu, dự án đang bán, quy trình, form liên hệ.
 */
$code  = $args['lang'] ?? 'en';
$t     = hh_lang_strings( $code );
$tel   = hoanghiep_tel();
$intl  = '+84 ' . ltrim( hoanghiep_opt( 'hh_phone' ), '0' );
$zalo  = 'https://zalo.me/' . hoanghiep_tel( hoanghiep_opt( 'hh_zalo' ) );
$vn    = static fn( $s ) => remove_accents( (string) $s );
$needs = array( 'Mua để ở', 'Đầu tư / cho thuê lại', 'Thuê nhà', 'Khác' );

$projects = new WP_Query(
	array(
		'post_type'      => 'du-an',
		'posts_per_page' => 40,
		'no_found_rows'  => true,
		'meta_query'     => array(
			array( 'key' => 'hh_p_status', 'value' => array( 'dang-mo-ban', 'sap-mo-ban' ), 'compare' => 'IN' ),
			array( 'key' => '_thumbnail_id', 'compare' => 'EXISTS' ),
		),
		'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
	)
);
// Bỏ từng tòa con trùng tên dự án mẹ (Capital Square – Tòa 2.1…); giữ dự án con có tên riêng (Spana Tower). Tối đa 12.
$projects->posts = array_slice(
	array_values(
		array_filter(
			$projects->posts,
			static function ( $p ) {
				$parent = (int) get_post_meta( $p->ID, 'hh_p_parent', true );
				return ! $parent || 0 !== mb_stripos( $p->post_title, trim( preg_replace( '/\s*(Đà Nẵng|Hội An)$/u', '', get_the_title( $parent ) ) ) );
			}
		)
	),
	0,
	12
);
$projects->post_count = count( $projects->posts );
$count_all     = (int) wp_count_posts( 'du-an' )->publish;
$count_selling = count( get_posts( array( 'post_type' => 'du-an', 'posts_per_page' => 300, 'fields' => 'ids', 'meta_key' => 'hh_p_status', 'meta_value' => 'dang-mo-ban' ) ) );
$result        = isset( $_GET['lien-he'] ) ? sanitize_key( $_GET['lien-he'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification

get_header();
?>
<section class="lx-hero">
	<div class="container lx-hero__grid">
		<div>
			<p class="eyebrow eyebrow--light"><?php echo esc_html( $t['eyebrow'] ); ?></p>
			<h1 class="lx-hero__title"><?php echo esc_html( $t['h1'] ); ?></h1>
			<p class="lx-hero__lead"><?php echo esc_html( $t['lead'] ); ?></p>
			<div class="lx-hero__cta">
				<a class="btn btn--zalo" href="<?php echo esc_url( $zalo ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $t['btn_zalo'] ); ?></a>
				<a class="btn btn--cta" href="tel:<?php echo esc_attr( $tel ); ?>"><?php echo hh_icon( 'phone' ); // phpcs:ignore ?> <?php echo esc_html( $t['btn_call'] . ' ' . $intl ); ?></a>
				<a class="btn btn--ghost" href="#contact"><?php echo esc_html( $t['btn_form'] ); ?></a>
			</div>
			<ul class="lx-stats">
				<?php if ( hoanghiep_opt( 'hh_stat1_num' ) ) : ?><li><b><?php echo esc_html( hoanghiep_opt( 'hh_stat1_num' ) ); ?></b><span><?php echo esc_html( $t['stat_years'] ); ?></span></li><?php endif; ?>
				<li><b><?php echo esc_html( $count_all ); ?></b><span><?php echo esc_html( $t['stat_projects'] ); ?></span></li>
				<li><b><?php echo esc_html( $count_selling ); ?></b><span><?php echo esc_html( $t['stat_selling'] ); ?></span></li>
			</ul>
		</div>
		<img class="lx-hero__photo" src="<?php echo esc_url( hoanghiep_photo( 'portrait2' ) ); ?>" alt="<?php echo esc_attr( $vn( hoanghiep_opt( 'hh_person_name' ) ) ); ?>" width="420" height="525" fetchpriority="high">
	</div>
</section>

<div class="container section lx">
	<section class="block" id="ownership">
		<h2 class="block__title"><?php echo esc_html( $t['own_h2'] ); ?></h2>
		<p class="lead"><?php echo esc_html( $t['own_lead'] ); ?></p>
		<div class="lx-cards">
			<?php foreach ( $t['own_items'] as list( $h, $p ) ) : ?>
				<div class="lx-card"><span class="lx-card__icon"><?php echo hh_icon( 'shield' ); // phpcs:ignore ?></span><h3><?php echo esc_html( $h ); ?></h3><p><?php echo esc_html( $p ); ?></p></div>
			<?php endforeach; ?>
		</div>
		<p class="note"><?php echo esc_html( $t['own_note'] ); ?></p>
	</section>

	<section class="block" id="projects">
		<h2 class="block__title"><?php echo esc_html( $t['proj_h2'] ); ?></h2>
		<p class="prose"><?php echo esc_html( $t['proj_lead'] ); ?></p>
		<div class="lx-projects">
			<?php
			while ( $projects->have_posts() ) :
				$projects->the_post();
				$pid   = get_the_ID();
				$area  = get_the_terms( $pid, 'khu-vuc' );
				$types = wp_list_pluck( get_the_terms( $pid, 'loai-du-an' ) ?: array(), 'slug' );
				$type  = '';
				foreach ( $t['types'] as $slug => $label ) {
					if ( in_array( $slug, $types, true ) ) {
						$type = $label;
						break;
					}
				}
				$from  = function_exists( 'hh_px_price_from' ) ? hh_px_price_from( $pid ) : array();
				$min   = $from ? reset( $from )['price'] : (float) get_post_meta( $pid, 'hh_p_price_from', true );
				if ( $min <= 0 && function_exists( 'hh_px_price_from' ) ) {
					// Dự án mẹ chưa có giá: lấy giá thấp nhất của các tòa / phân khu con.
					foreach ( get_posts( array( 'post_type' => 'du-an', 'posts_per_page' => 20, 'fields' => 'ids', 'meta_key' => 'hh_p_parent', 'meta_value' => $pid ) ) as $kid ) {
						$kf = hh_px_price_from( $kid );
						$kp = $kf ? reset( $kf )['price'] : (float) get_post_meta( $kid, 'hh_p_price_from', true );
						$min = $kp > 0 && ( $min <= 0 || $kp < $min ) ? $kp : $min;
					}
				}
				// Bàn giao: chỉ lấy ngày / quý (bỏ phần chú thích tiếng Việt).
				$hraw = (string) get_post_meta( $pid, 'hh_p_handover', true );
				$hand = hh_lang_date( $hraw, $code );
				$soon  = 'sap-mo-ban' === get_post_meta( $pid, 'hh_p_status', true );
				?>
				<article class="lx-project">
					<a class="lx-project__img" href="<?php echo esc_url( hh_translate_url( get_permalink(), $code ) ); ?>" rel="nofollow">
						<?php the_post_thumbnail( 'hh-card', array( 'loading' => 'lazy', 'alt' => hh_lang_name( get_the_title() ) ) ); ?>
						<span class="lx-project__status<?php echo $soon ? ' is-soon' : ''; ?>"><?php echo esc_html( $soon ? $t['soon'] : $t['selling'] ); ?></span>
					</a>
					<div class="lx-project__body">
						<h3 class="lx-project__name"><?php echo esc_html( hh_lang_name( get_the_title() ) ); ?></h3>
						<p class="lx-project__meta"><?php echo esc_html( implode( ' · ', array_filter( array( $type, $area && ! is_wp_error( $area ) ? $vn( $area[0]->name ) : '' ) ) ) ); ?></p>
						<p class="lx-project__price"><?php echo esc_html( $min > 0 ? sprintf( $t['from'], hh_lang_money( $min, $code ) ) : $t['price_ask'] ); ?></p>
						<?php if ( $hand ) : ?><p class="lx-project__hand"><?php echo esc_html( $t['handover'] . ': ' . $hand . ( false !== mb_stripos( $hraw, 'dự kiến' ) ? ' (' . $t['expected'] . ')' : '' ) ); ?></p><?php endif; ?>
						<p class="lx-project__links">
							<a href="<?php echo esc_url( hh_translate_url( get_permalink(), $code ) ); ?>" rel="nofollow"><?php echo esc_html( $t['view_tr'] ); ?> →</a>
							<a href="<?php the_permalink(); ?>" hreflang="vi"><?php echo esc_html( $t['view_vi'] ); ?></a>
						</p>
					</div>
				</article>
				<?php
			endwhile;
			wp_reset_postdata();
			?>
		</div>
		<p><a class="btn btn--outline" href="<?php echo esc_url( get_post_type_archive_link( 'du-an' ) ); ?>" hreflang="vi"><?php echo esc_html( $t['all_projects'] ); ?></a></p>
	</section>

	<section class="block" id="services">
		<h2 class="block__title"><?php echo esc_html( $t['svc_h2'] ); ?></h2>
		<div class="lx-cards lx-cards--4">
			<?php foreach ( $t['svc'] as $i => list( $h, $p ) ) : ?>
				<div class="lx-card"><span class="lx-card__icon"><?php echo hh_icon( array( 'building', 'handshake', 'file', 'check' )[ $i ] ?? 'check' ); // phpcs:ignore ?></span><h3><?php echo esc_html( $h ); ?></h3><p><?php echo esc_html( $p ); ?></p></div>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="block" id="process">
		<h2 class="block__title"><?php echo esc_html( $t['steps_h2'] ); ?></h2>
		<ol class="lx-steps">
			<?php foreach ( $t['steps'] as list( $h, $p ) ) : ?>
				<li><h3><?php echo esc_html( $h ); ?></h3><p><?php echo esc_html( $p ); ?></p></li>
			<?php endforeach; ?>
		</ol>
	</section>

	<section class="block lx-about" id="about">
		<img src="<?php echo esc_url( hoanghiep_photo( 'portrait' ) ); ?>" alt="<?php echo esc_attr( $vn( hoanghiep_opt( 'hh_person_name' ) ) ); ?>" width="320" height="400" loading="lazy">
		<div>
			<h2 class="block__title"><?php echo esc_html( $t['about_h2'] ); ?></h2>
			<?php foreach ( $t['about'] as $para ) : ?><p class="prose"><?php echo esc_html( $para ); ?></p><?php endforeach; ?>
			<p class="lx-slogan">“<?php echo esc_html( $t['slogan'] ); ?>”</p>
		</div>
	</section>

	<section class="block" id="faq">
		<h2 class="block__title"><?php echo esc_html( $t['faq_h2'] ); ?></h2>
		<div class="faq">
			<?php foreach ( $t['faq'] as list( $q, $a ) ) : ?>
				<details class="faq__item"><summary><?php echo esc_html( $q ); ?></summary><p><?php echo esc_html( $a ); ?></p></details>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="block lx-contact" id="contact">
		<div>
			<h2 class="block__title"><?php echo esc_html( $t['form_h2'] ); ?></h2>
			<p class="prose"><?php echo esc_html( $t['form_lead'] ); ?></p>
			<ul class="lx-contact__list">
				<li><?php echo hh_icon( 'phone' ); // phpcs:ignore ?> <a href="tel:<?php echo esc_attr( $tel ); ?>"><?php echo esc_html( $intl ); ?></a> (Zalo)</li>
				<li><?php echo hh_icon( 'mail' ); // phpcs:ignore ?> <a href="mailto:<?php echo esc_attr( hoanghiep_opt( 'hh_email' ) ); ?>"><?php echo esc_html( hoanghiep_opt( 'hh_email' ) ); ?></a></li>
				<li><?php echo hh_icon( 'pin' ); // phpcs:ignore ?> Da Nang, Vietnam</li>
			</ul>
		</div>
		<form class="hh-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" id="lien-he">
			<?php if ( 'ok' === $result ) : ?>
				<p class="hh-form__notice hh-form__notice--ok"><?php echo esc_html( $t['ok'] ); ?></p>
			<?php elseif ( 'loi' === $result ) : ?>
				<p class="hh-form__notice hh-form__notice--error"><?php echo esc_html( $t['err'] ); ?></p>
			<?php endif; ?>
			<input type="hidden" name="action" value="hh_lead">
			<input type="hidden" name="ref_id" value="0">
			<?php wp_nonce_field( 'hh_lead', 'hh_lead_nonce' ); ?>
			<div class="hh-form__hp" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
			<label><?php echo esc_html( $t['f_name'] ); ?><input type="text" name="name" required maxlength="100" autocomplete="name"></label>
			<label><?php echo esc_html( $t['f_phone'] ); ?><input type="tel" name="phone" required pattern="[0-9+ .]{9,15}" maxlength="15" autocomplete="tel" placeholder="+82 … / +1 … / +84 …"></label>
			<label><?php echo esc_html( $t['f_interest'] ); ?>
				<select name="need">
					<?php foreach ( $t['interests'] as $i => $label ) : ?>
						<option value="<?php echo esc_attr( 'Khách nước ngoài (' . strtoupper( $code ) . ') – ' . $needs[ $i ] ); ?>"><?php echo esc_html( $label ); ?></option>
					<?php endforeach; ?>
				</select>
			</label>
			<label><?php echo esc_html( $t['f_msg'] ); ?><textarea name="message" rows="3" maxlength="1000"></textarea></label>
			<button type="submit" class="btn btn--cta btn--block"><?php echo esc_html( $t['f_btn'] ); ?></button>
			<p class="hh-form__note"><?php echo esc_html( $t['f_note'] ); ?></p>
		</form>
	</section>
	<p class="note"><?php echo esc_html( $t['disclaimer'] ); ?></p>
</div>
<?php
get_footer();
