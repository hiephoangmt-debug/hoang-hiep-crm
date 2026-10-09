<?php
/**
 * Dự án → Nhập bài nhanh: dán "gói bài" (dòng bắt đầu HHBAI1:) do Hoàng Hiệp/Claude soạn → tạo BẢN NHÁP đủ nội dung,
 * ảnh đại diện, tiêu đề/mô tả/từ khoá Rank Math, thẻ, hỏi đáp, nguồn. Không cần tải gói zip lên File Manager.
 *
 * Gói bài = "HHBAI1:" + base64( JSON ). JSON: slug, title, excerpt, keyword, keywords_extra[], category, tags[], content (HTML),
 * seo{seo_title, desc, points[], faq[[hỏi, đáp]]}, sources[], follow_sources, image{name, alt, caption, data (base64)}.
 * Tạo gói: wordpress/scripts/dong-goi-bai.php.
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'admin_menu',
	static function () {
		add_submenu_page( 'edit.php?post_type=du-an', 'Nhập nhanh (bài / dự án)', 'Nhập nhanh (bài / dự án)', 'manage_options', 'hh-nhap-bai-nhanh', 'hh_quick_post_page' );
	}
);

/** Giải mã gói bài → mảng bài, hoặc WP_Error. */
function hh_quick_post_decode( $raw ) {
	$raw = preg_replace( '/\s+/', '', (string) $raw );
	if ( 0 !== strpos( $raw, 'HHBAI1:' ) ) {
		return new WP_Error( 'format', 'Gói bài không đúng – phải bắt đầu bằng HHBAI1: (chép đủ cả dòng trong file).' );
	}
	$json = base64_decode( substr( $raw, 7 ), true ); // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions
	$n    = $json ? json_decode( $json, true ) : null;
	$project = is_array( $n ) && 'du-an' === ( $n['kind'] ?? '' );
	if ( ! is_array( $n ) || empty( $n['slug'] ) || ( ! $project && ( empty( $n['title'] ) || empty( $n['content'] ) ) ) ) {
		return new WP_Error( 'format', 'Gói bài bị thiếu hoặc chép chưa đủ – chép lại toàn bộ nội dung file rồi dán.' );
	}
	$n['slug'] = sanitize_title( $n['slug'] );
	if ( $project ) {
		return $n;
	}
	return $n + array(
		'excerpt'  => '',
		'keyword'  => '',
		'category' => 'Hạ tầng & quy hoạch',
		'project'  => '',
		'seo'      => array(),
	);
}

/** Lưu ảnh base64 trong gói vào Thư viện, gắn làm ảnh đại diện. Trả về ID ảnh hoặc 0. */
function hh_quick_post_image( $post_id, $img ) {
	if ( empty( $img['data'] ) ) {
		return 0;
	}
	$bin = base64_decode( $img['data'], true ); // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions
	if ( ! $bin || strlen( $bin ) > 8 * MB_IN_BYTES ) {
		return 0;
	}
	$info = getimagesizefromstring( $bin );
	$ext  = array( 'image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp' )[ $info['mime'] ?? '' ] ?? '';
	if ( ! $ext ) {
		return 0;
	}
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';
	$name = sanitize_file_name( pathinfo( (string) ( $img['name'] ?? 'anh-bai-viet' ), PATHINFO_FILENAME ) ) . '.' . $ext;
	$tmp  = wp_tempnam( $name );
	if ( ! $tmp || false === file_put_contents( $tmp, $bin ) ) { // phpcs:ignore WordPress.WP.AlternativeFunctions
		return 0;
	}
	$alt = (string) ( $img['alt'] ?? '' );
	$att = media_handle_sideload( array( 'name' => $name, 'tmp_name' => $tmp ), $post_id, $alt );
	if ( is_wp_error( $att ) ) {
		wp_delete_file( $tmp );
		return 0;
	}
	update_post_meta( $att, '_wp_attachment_image_alt', $alt );
	set_post_thumbnail( $post_id, $att );
	return (int) $att;
}

/** Tạo (hoặc cập nhật bản nháp cùng đường dẫn) từ gói bài. Trả về ID bài hoặc WP_Error. */
function hh_quick_post_create( $n ) {
	$old = get_posts( array( 'name' => $n['slug'], 'post_type' => 'post', 'post_status' => array( 'publish', 'future', 'draft', 'pending', 'private' ), 'numberposts' => 1 ) )[0] ?? null;
	if ( $old && 'draft' !== $old->post_status ) {
		return new WP_Error( 'exists', 'Đã có bài đang đăng với đường dẫn /' . $n['slug'] . '/ – không ghi đè. Muốn thay, chuyển bài cũ về Bản nháp rồi dán lại.' );
	}
	$seo     = (array) $n['seo'];
	$content = hh_news_build_content( $n, $seo );
	$cat_id  = hh_news_category( $n['category'] );
	$postarr = array(
		'post_type'     => 'post',
		'post_status'   => 'draft',
		'post_name'     => $n['slug'],
		'post_title'    => $n['title'],
		'post_excerpt'  => $n['excerpt'],
		'post_content'  => $content,
		'post_category' => $cat_id ? array( $cat_id ) : array(),
	);
	if ( $old ) {
		$postarr['ID'] = $old->ID;
	}
	$id = wp_insert_post( wp_slash( $postarr ), true );
	if ( is_wp_error( $id ) ) {
		return $id;
	}
	if ( ! empty( $n['image'] ) && ! has_post_thumbnail( $id ) ) {
		hh_quick_post_image( $id, (array) $n['image'] );
	}
	$img_meta = (array) ( $n['image'] ?? array() );
	$n       += array( 'image_alt' => $img_meta['alt'] ?? $n['title'], 'image_caption' => $img_meta['caption'] ?? '' );
	if ( false !== strpos( $content, '<!--hh-featured-->' ) ) {
		wp_update_post( wp_slash( array( 'ID' => $id, 'post_content' => hh_news_featured_in_content( $content, $id, $n ) ) ) );
	}
	if ( ! empty( $n['tags'] ) ) {
		wp_set_post_tags( $id, (array) $n['tags'], true );
	}
	$meta = array(
		'rank_math_focus_keyword' => implode( ',', array_filter( array_merge( array( $n['keyword'] ), (array) ( $n['keywords_extra'] ?? array() ) ) ) ),
		'rank_math_title'         => $seo['seo_title'] ?? '',
		'rank_math_description'   => $seo['desc'] ?? '',
		'hh_post_faq'             => implode( "\n", array_map( static fn( $f ) => str_replace( '|', '/', $f[0] ) . ' | ' . str_replace( '|', '/', $f[1] ), $seo['faq'] ?? array() ) ),
	);
	if ( $n['project'] ) {
		$project                 = get_page_by_path( $n['project'], OBJECT, 'du-an' );
		$meta['hh_post_project'] = $project ? $project->ID : '';
	}
	foreach ( array_filter( $meta, 'strlen' ) as $key => $value ) {
		update_post_meta( $id, $key, $value );
	}
	update_post_meta( $id, '_hh_news_article', 1 ); // Schema NewsArticle.
	update_post_meta( $id, '_hh_quick_post', current_time( 'mysql' ) );
	return $id;
}

function hh_quick_post_page() {
	$done  = null;
	$proj  = null;
	$error = '';
	if ( isset( $_POST['hh_quick_post'] ) && check_admin_referer( 'hh_quick_post' ) ) {
		$raw  = wp_unslash( $_POST['hh_quick_post'] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		$file = $_FILES['hh_quick_file'] ?? null; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		if ( '' === trim( $raw ) && $file && UPLOAD_ERR_OK === $file['error'] && $file['size'] < 20 * MB_IN_BYTES && is_uploaded_file( $file['tmp_name'] ) ) {
			$raw = (string) file_get_contents( $file['tmp_name'] ); // phpcs:ignore WordPress.WP.AlternativeFunctions -- gói bài .txt chọn từ điện thoại/máy tính.
		}
		$n = hh_quick_post_decode( $raw );
		if ( ! is_wp_error( $n ) && 'du-an' === ( $n['kind'] ?? '' ) ) {
			$proj = hh_quick_project_apply( $n );
			if ( is_wp_error( $proj ) ) {
				$error = $proj->get_error_message();
			}
		} else {
			$done = is_wp_error( $n ) ? $n : hh_quick_post_create( $n );
			if ( is_wp_error( $done ) ) {
				$error = $done->get_error_message();
				$done  = null;
			}
		}
	}
	$undone = null;
	if ( isset( $_POST['hh_quick_undo'] ) && check_admin_referer( 'hh_quick_post' ) ) {
		list( $uid, $utime ) = array_pad( explode( ':', sanitize_text_field( wp_unslash( $_POST['hh_quick_undo'] ) ) ), 2, '' );
		$undone              = hh_quick_project_undo( absint( $uid ), $utime );
	}
	?>
	<div class="wrap">
		<h1>Nhập nhanh (bài tin tức / dự án)</h1>
		<?php if ( $error ) : ?>
			<div class="notice notice-error"><p><?php echo esc_html( $error ); ?></p></div>
		<?php endif; ?>
		<?php if ( $proj && ! is_wp_error( $proj ) ) : ?>
			<?php list( $pid, $pnew, $plist ) = $proj; ?>
			<div class="notice notice-success"><p>
				<?php echo $pnew ? 'Đã tạo dự án (bản nháp): ' : 'Đã cập nhật dự án: '; ?><strong><?php echo esc_html( get_the_title( $pid ) ); ?></strong> –
				<a href="<?php echo esc_url( $pnew ? get_preview_post_link( $pid ) : get_permalink( $pid ) ); ?>" target="_blank">Xem trang</a> ·
				<a href="<?php echo esc_url( get_edit_post_link( $pid ) ); ?>">Mở để sửa<?php echo $pnew ? ' / Đăng' : ''; ?></a>
			</p><p><?php echo $plist ? 'Đã thay: ' . esc_html( implode( ', ', $plist ) ) : 'Không có ô nào thay đổi (dữ liệu trong gói giống trên web).'; ?></p></div>
		<?php endif; ?>
		<?php if ( null !== $undone ) : ?>
			<div class="notice notice-<?php echo $undone ? 'success' : 'error'; ?>"><p><?php echo $undone ? 'Đã hoàn tác – dự án trở về như trước lần cập nhật đó.' : 'Không tìm thấy lần cập nhật để hoàn tác.'; ?></p></div>
		<?php endif; ?>
		<?php if ( $done ) : ?>
			<div class="notice notice-success"><p>
				Đã tạo bản nháp: <strong><?php echo esc_html( get_the_title( $done ) ); ?></strong> –
				<a href="<?php echo esc_url( get_preview_post_link( $done ) ); ?>" target="_blank">Xem trước</a> ·
				<a href="<?php echo esc_url( get_edit_post_link( $done ) ); ?>">Mở để sửa / Đăng</a>
			</p></div>
		<?php endif; ?>
		<p>Nhận <strong>gói bài tin tức</strong> (tạo bản nháp) và <strong>gói dự án</strong> (dự án mới → bản nháp; dự án đã có → chỉ thay các ô có trong gói, có nút Hoàn tác).</p>
		<p><strong>Cách 1 (điện thoại):</strong> tải file gói bài (.txt) nhận qua Claude về máy → bấm <strong>Chọn file</strong> bên dưới → chọn file đó → <strong>Tạo bài</strong>.</p>
		<p><strong>Cách 2 (máy tính):</strong> mở file gói bài → <strong>Ctrl+A</strong>, <strong>Ctrl+C</strong> → dán vào ô dưới → <strong>Tạo bài</strong>.</p>
		<p>Bài được tạo ở trạng thái <strong>Bản nháp</strong>, đủ ảnh đại diện, tiêu đề/mô tả/từ khoá Rank Math, thẻ, hỏi đáp. Xem trước rồi bấm <strong>Đăng</strong>.</p>
		<form method="post" enctype="multipart/form-data">
			<?php wp_nonce_field( 'hh_quick_post' ); ?>
			<p><label><strong>Chọn file gói bài:</strong> <input type="file" name="hh_quick_file" accept=".txt,text/plain"></label></p>
			<p>hoặc dán nội dung gói bài:</p>
			<textarea name="hh_quick_post" rows="8" style="width:100%;font-family:monospace" placeholder="HHBAI1:..."></textarea>
			<p><button class="button button-primary">Tạo bài / Cập nhật dự án</button></p>
		</form>
		<?php $recent = hh_quick_project_recent(); ?>
		<?php if ( $recent ) : ?>
			<h2>Dự án vừa cập nhật nhanh</h2>
			<p>Cập nhật nhầm? Bấm <strong>Hoàn tác</strong> để trả các ô về giá trị trước lần cập nhật đó.</p>
			<form method="post">
				<?php wp_nonce_field( 'hh_quick_post' ); ?>
				<table class="widefat striped"><tbody>
				<?php foreach ( $recent as list( $rid, $rtime ) ) : ?>
					<tr>
						<td><a href="<?php echo esc_url( get_edit_post_link( $rid ) ); ?>"><?php echo esc_html( get_the_title( $rid ) ); ?></a></td>
						<td><?php echo esc_html( wp_date( 'd/m/Y H:i', (int) $rtime ) ); ?></td>
						<td><button class="button" name="hh_quick_undo" value="<?php echo esc_attr( $rid . ':' . $rtime ); ?>" onclick="return confirm('Hoàn tác lần cập nhật này?')">Hoàn tác</button></td>
					</tr>
				<?php endforeach; ?>
				</tbody></table>
			</form>
		<?php endif; ?>
	</div>
	<?php
}
