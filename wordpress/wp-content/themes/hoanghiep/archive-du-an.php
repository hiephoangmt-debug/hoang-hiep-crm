<?php
get_header();

$statuses = hh_project_schema()['tong-quan']['fields']['hh_p_status']['options'];
$current  = sanitize_key( (string) get_query_var( 'tt' ) );
$area     = sanitize_title( (string) get_query_var( 'khu-vuc' ) );
$areas    = get_terms( array( 'taxonomy' => 'khu-vuc', 'hide_empty' => false ) );
$types    = hh_project_groups();
$term     = is_tax( 'loai-du-an' ) ? get_queried_object() : null;
$base     = $term ? get_term_link( $term ) : get_post_type_archive_link( 'du-an' );
$title    = $term ? 'Dự án ' . mb_strtolower( $term->name ) . ' Đà Nẵng' : 'Dự án Đà Nẵng';
$group    = $term ? ( $term->parent ? get_term( $term->parent, 'loai-du-an' ) : $term ) : null;
$subtypes = $group ? get_terms( array( 'taxonomy' => 'loai-du-an', 'hide_empty' => false, 'parent' => $group->term_id, 'orderby' => 'term_id' ) ) : array();
?>
<div class="page-head">
	<div class="container">
		<p class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a> / <a href="<?php echo esc_url( get_post_type_archive_link( 'du-an' ) ); ?>">Dự án</a><?php echo $term ? ' / ' . esc_html( $term->name ) : ''; ?></p>
		<h1 class="page-head__title"><?php echo esc_html( $title ); ?></h1>
		<?php if ( $term && $term->description ) : ?>
			<p class="page-head__lead"><?php echo esc_html( $term->description ); ?></p>
		<?php else : ?>
			<p class="page-head__lead">Vị trí, mặt bằng, bảng giá và chính sách bán hàng mới nhất của từng dự án.</p>
		<?php endif; ?>
		<?php if ( $types && ! is_wp_error( $types ) ) : ?>
			<nav class="deal-tabs" aria-label="Loại dự án">
				<a class="<?php echo $term ? '' : 'is-active'; ?>" href="<?php echo esc_url( get_post_type_archive_link( 'du-an' ) ); ?>">Tất cả</a>
				<?php foreach ( $types as $t ) : ?>
					<a class="<?php echo $group && $group->term_id === $t->term_id ? 'is-active' : ''; ?>" href="<?php echo esc_url( get_term_link( $t ) ); ?>"><?php echo esc_html( $t->name ); ?></a>
				<?php endforeach; ?>
			</nav>
		<?php endif; ?>
		<?php if ( $subtypes && ! is_wp_error( $subtypes ) ) : ?>
			<nav class="type-chips type-chips--head" aria-label="Loại <?php echo esc_attr( mb_strtolower( $group->name ) ); ?>">
				<a class="<?php echo $term->term_id === $group->term_id ? 'is-active' : ''; ?>" href="<?php echo esc_url( get_term_link( $group ) ); ?>">Tất cả <?php echo esc_html( mb_strtolower( $group->name ) ); ?></a>
				<?php foreach ( $subtypes as $t ) : ?>
					<a class="<?php echo $term->term_id === $t->term_id ? 'is-active' : ''; ?>" href="<?php echo esc_url( get_term_link( $t ) ); ?>"><?php echo esc_html( $t->name ); ?> <span><?php echo (int) $t->count; ?></span></a>
				<?php endforeach; ?>
			</nav>
		<?php endif; ?>
		<?php if ( defined( 'HH_SPECIAL_PAGES' ) && ( ! $term || in_array( $term->slug, array( 'cao-tang', 'can-ho-so-huu-lau-dai', 'can-ho-dich-vu' ), true ) ) ) : ?>
			<nav class="type-chips type-chips--head" aria-label="Sản phẩm cao tầng">
				<?php foreach ( HH_SPECIAL_PAGES as $k => list( , $name ) ) : ?>
					<a href="<?php echo esc_url( hh_special_url( $k ) ); ?>"><?php echo esc_html( $name ); ?></a>
				<?php endforeach; ?>
			</nav>
		<?php endif; ?>
		<nav class="status-tabs" aria-label="Tình trạng">
			<a class="<?php echo '' === $current ? 'is-active' : ''; ?>" href="<?php echo esc_url( remove_query_arg( 'tt', $base . ( $area ? '?khu-vuc=' . rawurlencode( $area ) : '' ) ) ); ?>">Mọi tình trạng</a>
			<?php foreach ( $statuses as $value => $label ) : ?>
				<a class="<?php echo $current === $value ? 'is-active' : ''; ?>" href="<?php echo esc_url( add_query_arg( 'tt', $value, $base . ( $area ? '?khu-vuc=' . rawurlencode( $area ) : '' ) ) ); ?>"><?php echo esc_html( $label ); ?></a>
			<?php endforeach; ?>
		</nav>
	</div>
</div>

<div class="container section">
	<form class="filter-bar" action="<?php echo esc_url( $base ); ?>" method="get">
		<input type="search" name="tk" value="<?php echo esc_attr( (string) get_query_var( 'tk' ) ); ?>" placeholder="Tên dự án, chủ đầu tư…" aria-label="Từ khóa">
		<?php if ( $areas && ! is_wp_error( $areas ) ) : ?>
			<select name="khu-vuc" aria-label="Khu vực">
				<option value="">Tất cả khu vực</option>
				<?php foreach ( $areas as $t ) : ?>
					<option value="<?php echo esc_attr( $t->slug ); ?>" <?php selected( $area, $t->slug ); ?>><?php echo esc_html( $t->name ); ?></option>
				<?php endforeach; ?>
			</select>
		<?php endif; ?>
		<?php if ( $current ) : ?>
			<input type="hidden" name="tt" value="<?php echo esc_attr( $current ); ?>">
		<?php endif; ?>
		<button class="btn btn--gold" type="submit">Tìm dự án</button>
	</form>

	<?php if ( have_posts() ) : ?>
		<div class="grid grid--3">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/project-card' );
			endwhile;
			?>
		</div>
		<?php the_posts_pagination( array( 'prev_text' => '‹', 'next_text' => '›' ) ); ?>
	<?php else : ?>
		<div class="empty">
			<p><strong>Chưa có dự án phù hợp.</strong></p>
			<p>Liên hệ để nhận thông tin các dự án sắp mở bán.</p>
		</div>
	<?php endif; ?>
</div>

<?php get_template_part( 'template-parts/cta' ); ?>
<?php
get_footer();
