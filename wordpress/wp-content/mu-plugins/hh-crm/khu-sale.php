<?php
/**
 * Khu Sale nội bộ (anh Hiệp 14/11/2026 – bước 1, team khoảng 30 người): hiephoangmt.com/sale/
 * - Tài khoản riêng từng sale (vai trò "Sale Hoàng Hiệp"): tạo hàng loạt, khóa / mở, đặt lại mật khẩu trong Quản trị → Khu Sale.
 *   Sale không vào được trang quản trị WordPress, chỉ dùng /sale/.
 * - Học dự án: mỗi dự án 1 trang tóm tắt (thông tin, điểm bán hàng, loại căn – giá tham khảo, chính sách hiện hành, tiến độ,
 *   câu hỏi khách hay hỏi + cách trả lời, lưu ý khi tư vấn, tài liệu). Phần dành riêng cho sale nhập trong khung
 *   "Dành cho sale (nội bộ)" ở trang sửa dự án – không bao giờ hiện trên web công khai.
 * - Kho tài liệu kín: file lưu trong thư mục chặn truy cập trực tiếp, chỉ tải qua /sale/tai/<id>/ khi đã đăng nhập;
 *   mỗi lượt tải được ghi lại (ai, lúc nào); ảnh JPG/PNG tải về được in tên + số của sale tải.
 * - Khách từ web chia vòng lần lượt cho các sale đang hoạt động (bật/tắt được); mỗi sale chỉ thấy khách của mình,
 *   cập nhật trạng thái + ghi chú chăm sóc. Quản trị viên thấy tất cả và đổi người phụ trách được.
 * Mọi trang /sale/ đều không lưu bộ nhớ đệm, không cho Google lập chỉ mục.
 */

defined( 'ABSPATH' ) || exit;

const HH_SALE_ROLE     = 'hh_sale';
const HH_SALE_DOC_DIR  = 'hh-sale-private';
const HH_SALE_DOC_TYPE = 'hh-tai-lieu';
const HH_SALE_GROUPS   = array( 'Bảng giá & chính sách', 'Mặt bằng & sản phẩm', 'Pháp lý', 'Đào tạo dự án', 'Hình ảnh & video', 'Mẫu bài đăng', 'Khác' );

/* =========================================================================
 * Vai trò, quyền, chặn vào quản trị, khóa tài khoản
 * ====================================================================== */

add_action(
	'init',
	static function () {
		if ( '1' !== get_option( 'hh_sale_role_v' ) ) {
			remove_role( HH_SALE_ROLE );
			add_role( HH_SALE_ROLE, 'Sale Hoàng Hiệp', array( 'read' => true, 'hh_sale_portal' => true ) );
			update_option( 'hh_sale_role_v', '1', true );
		}
	},
	5
);

/** Người dùng hiện tại được vào khu sale (sale đang hoạt động hoặc quản trị viên). */
function hh_sale_can() {
	if ( ! is_user_logged_in() ) {
		return false;
	}
	if ( current_user_can( 'manage_options' ) ) {
		return true;
	}
	return current_user_can( 'hh_sale_portal' ) && ! get_user_meta( get_current_user_id(), 'hh_sale_locked', true );
}

function hh_sale_is_admin() {
	return current_user_can( 'manage_options' );
}

function hh_sale_url( $path = '' ) {
	return home_url( '/sale/' . ( $path ? trailingslashit( ltrim( $path, '/' ) ) : '' ) );
}

/** Sale (không phải quản trị viên) không vào trang quản trị WordPress. */
add_action(
	'admin_init',
	static function () {
		if ( wp_doing_ajax() || current_user_can( 'edit_posts' ) || ! current_user_can( 'hh_sale_portal' ) ) {
			return;
		}
		$script = basename( (string) ( $_SERVER['SCRIPT_NAME'] ?? '' ) ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		if ( 'admin-post.php' === $script ) {
			return;
		}
		wp_safe_redirect( hh_sale_url() );
		exit;
	}
);
add_filter( 'show_admin_bar', static fn( $show ) => ( current_user_can( 'hh_sale_portal' ) && ! current_user_can( 'edit_posts' ) ) ? false : $show );
add_filter(
	'login_redirect',
	static function ( $to, $requested, $user ) {
		if ( $user instanceof WP_User && in_array( HH_SALE_ROLE, (array) $user->roles, true ) && ! $user->has_cap( 'edit_posts' ) ) {
			return ( $requested && false !== strpos( $requested, '/sale/' ) ) ? $requested : hh_sale_url();
		}
		return $to;
	},
	20,
	3
);
/** Tài khoản bị khóa: không đăng nhập được. */
add_filter(
	'authenticate',
	static function ( $user ) {
		if ( $user instanceof WP_User && get_user_meta( $user->ID, 'hh_sale_locked', true ) ) {
			return new WP_Error( 'hh_locked', 'Tài khoản đã bị khóa. Liên hệ anh Hiệp – 0904 567 009.' );
		}
		return $user;
	},
	50
);
add_action( 'wp_login', static fn( $login, $user ) => in_array( HH_SALE_ROLE, (array) $user->roles, true ) ? update_user_meta( $user->ID, 'hh_sale_last_login', time() ) : null, 10, 2 );

/* =========================================================================
 * Đường dẫn /sale/…
 * ====================================================================== */

add_action(
	'init',
	static function () {
		add_rewrite_rule( '^sale/?$', 'index.php?hh_sale=home', 'top' );
		add_rewrite_rule( '^sale/(du-an|tai-lieu|khach-hang|bao-cao)/?$', 'index.php?hh_sale=$matches[1]', 'top' );
		add_rewrite_rule( '^sale/du-an/([^/]+)/?$', 'index.php?hh_sale=du-an&hh_sale_id=$matches[1]', 'top' );
		add_rewrite_rule( '^sale/tai/([0-9]+)/?$', 'index.php?hh_sale=tai&hh_sale_id=$matches[1]', 'top' );
		if ( '2' !== get_option( 'hh_sale_rules_v' ) ) {
			update_option( 'hh_sale_rules_v', '2', true );
			flush_rewrite_rules( false );
		}
	},
	20
);
add_filter(
	'query_vars',
	static function ( $v ) {
		$v[] = 'hh_sale';
		$v[] = 'hh_sale_id';
		return $v;
	}
);
add_filter( 'robots_txt', static fn( $txt ) => $txt . "\nDisallow: /sale/\n", 20 );

add_action(
	'template_redirect',
	static function () {
		$view = (string) get_query_var( 'hh_sale' );
		if ( '' === $view ) {
			return;
		}
		nocache_headers();
		do_action( 'litespeed_control_set_nocache', 'khu sale nội bộ' );
		header( 'X-Robots-Tag: noindex, nofollow', true );
		if ( isset( $_GET['ml'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification -- link đăng nhập 1 lần qua email.
			hh_sale_maillink_consume( sanitize_text_field( wp_unslash( $_GET['ml'] ) ) ); // phpcs:ignore WordPress.Security.NonceVerification
		}
		if ( ! hh_sale_can() ) {
			hh_sale_page_login();
			exit;
		}
		$id = sanitize_title( (string) get_query_var( 'hh_sale_id' ) );
		if ( 'tai' === $view ) {
			hh_sale_download( (int) $id );
			exit;
		}
		ob_start();
		$title = 'Tổng quan';
		if ( 'du-an' === $view && $id ) {
			$title = hh_sale_view_project( $id );
		} elseif ( 'du-an' === $view ) {
			$title = 'Học dự án';
			hh_sale_view_projects();
		} elseif ( 'tai-lieu' === $view ) {
			$title = 'Tài liệu';
			hh_sale_view_docs();
		} elseif ( 'bao-cao' === $view ) {
			$title = 'Báo cáo';
			hh_sale_view_report();
		} elseif ( 'khach-hang' === $view ) {
			$title = 'Khách của tôi';
			hh_sale_view_leads();
		} else {
			hh_sale_view_home();
		}
		$body = ob_get_clean();
		hh_sale_layout( $title, $view, $body );
		exit;
	},
	1
);

/* =========================================================================
 * Khung trang
 * ====================================================================== */

function hh_sale_css() {
	return ':root{--n:#0e223a;--n2:#16304f;--o:#f2551d;--o2:#ff8a3d;--bg:#f4f6f9;--line:#e3e8ef;--mut:#5d6b7c}
*{box-sizing:border-box}body{margin:0;font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,sans-serif;background:var(--bg);color:#14223a;font-size:15.5px;line-height:1.6}
a{color:#c2410c}.wrap{max-width:1100px;margin:0 auto;padding:0 16px}
.top{background:var(--n);color:#fff;position:sticky;top:0;z-index:20}.top .wrap{display:flex;align-items:center;gap:14px;min-height:58px;flex-wrap:wrap}
.top b{font-size:16px;letter-spacing:.06em}.top b small{display:block;font-size:10.5px;letter-spacing:.2em;color:#ff9d6b;font-weight:600}
.tabs{display:flex;gap:4px;overflow-x:auto;margin-left:auto;scrollbar-width:none}.tabs::-webkit-scrollbar{display:none}
.tabs a{color:#dbe4ef;text-decoration:none;padding:7px 12px;border-radius:999px;font-size:14px;white-space:nowrap}.tabs a.on,.tabs a:hover{background:rgba(255,255,255,.12);color:#fff}
.who{font-size:13px;color:#b9c6d6}.who a{color:#ffb38a}
h1{font-size:24px;margin:22px 0 6px;line-height:1.25}h2{font-size:18px;margin:0 0 10px}
.box{background:#fff;border:1px solid var(--line);border-radius:12px;padding:18px;margin:14px 0}
.grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:12px}
.card{display:block;background:#fff;border:1px solid var(--line);border-radius:12px;padding:14px 16px;text-decoration:none;color:inherit}.card:hover{border-color:var(--o)}
.card b{display:block;font-size:16px}.card span{font-size:13px;color:var(--mut)}
.pill{display:inline-block;white-space:nowrap;padding:2px 9px;border-radius:999px;font-size:12px;font-weight:600;background:#eef2f7;color:#334}
.pill.o{background:#fff1ea;color:#c2410c}.pill.g{background:#e8f7ee;color:#167a3e}
table{width:100%;border-collapse:collapse;font-size:14.5px}th,td{padding:8px 10px;border-bottom:1px solid var(--line);text-align:left;vertical-align:top}th{background:#f7f9fc;font-weight:600;color:var(--n)}
.kv th{width:32%}.scroll{overflow-x:auto}
ul.l{margin:0;padding-left:20px}ul.l li{margin:4px 0}
.stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(130px,1fr));gap:10px}.stats div{background:#fff;border:1px solid var(--line);border-radius:12px;padding:12px 14px}.stats b{display:block;font-size:24px;color:var(--n)}.stats span{font-size:13px;color:var(--mut)}
.btn{display:inline-block;white-space:nowrap;border:0;border-radius:999px;padding:9px 16px;background:linear-gradient(135deg,var(--o),var(--o2));color:#fff;font:inherit;font-weight:600;text-decoration:none;cursor:pointer}
.btn.s{padding:6px 12px;font-size:13.5px}.btn.g{background:#eef2f7;color:var(--n)}
input,select,textarea{font:inherit;padding:8px 10px;border:1.5px solid #d3dbe6;border-radius:8px;background:#fff;max-width:100%}
.search{width:100%;padding:11px 14px;margin:8px 0 4px}
.faq dt{font-weight:600;margin-top:10px}.faq dd{margin:4px 0 0;color:#334}
.note{font-size:13px;color:var(--mut)}.warn{background:#fff7e6;border-color:#f5d38a}
.lead-row form{display:flex;gap:6px;flex-wrap:wrap;align-items:center}.lead-row textarea{width:100%;min-height:44px}
.log{font-size:13px;color:var(--mut);margin-top:6px}.log p{margin:2px 0}
.hero{position:relative;margin:18px 0 6px;border-radius:18px;overflow:hidden;background:linear-gradient(120deg,#0e223a 0%,#16304f 55%,#1f3d63 100%);color:#fff;padding:26px 24px}
.hero:after{content:"";position:absolute;right:-60px;top:-60px;width:240px;height:240px;border-radius:50%;background:radial-gradient(circle,rgba(255,138,61,.45),rgba(255,138,61,0) 70%)}
.hero h1{margin:0 0 4px;color:#fff;font-size:26px}.hero p{margin:0;color:#c9d6e6;position:relative;z-index:1}.hero .acts{display:flex;gap:8px;flex-wrap:wrap;margin-top:16px;position:relative;z-index:1}
.hero .acts a{background:rgba(255,255,255,.12);color:#fff;text-decoration:none;border-radius:999px;padding:8px 14px;font-size:14px;font-weight:600}.hero .acts a.hl{background:linear-gradient(135deg,var(--o),var(--o2))}
.stats div{position:relative;border-left:4px solid #c9d3df;box-shadow:0 6px 18px -14px rgba(14,34,58,.45)}.stats .s-moi{border-left-color:var(--o)}.stats .s-moi b{color:var(--o)}.stats .s-da-lien-he{border-left-color:#3b82f6}.stats .s-dang-cham-soc{border-left-color:#8b5cf6}.stats .s-chot{border-left-color:#16a34a}.stats .s-chot b{color:#16a34a}.stats .s-huy{border-left-color:#94a3b8}
.box{box-shadow:0 8px 24px -18px rgba(14,34,58,.35)}.box h2{display:flex;align-items:center;gap:8px}.box h2:before{content:"";width:4px;height:18px;border-radius:2px;background:linear-gradient(var(--o),var(--o2))}
.card{padding:0;overflow:hidden;box-shadow:0 8px 22px -18px rgba(14,34,58,.5);transition:transform .15s,box-shadow .15s}.card:hover{transform:translateY(-2px);box-shadow:0 16px 30px -18px rgba(14,34,58,.55)}
.card .ph{display:block;aspect-ratio:16/9;background:#dfe6ee center/cover no-repeat}.card .in{display:block;padding:12px 14px 14px}.card .in b{margin-bottom:2px}
.cover{position:relative;margin:14px 0 6px;border-radius:18px;overflow:hidden;min-height:220px;display:flex;align-items:flex-end;background:#0e223a center/cover no-repeat;color:#fff}
.cover:before{content:"";position:absolute;inset:0;background:linear-gradient(180deg,rgba(14,34,58,.05),rgba(14,34,58,.85))}.cover>div{position:relative;padding:20px 22px}.cover h1{color:#fff;margin:0 0 4px}.cover p{margin:0;color:#dbe4ef;font-size:14px}.cover a{color:#ffb38a}
.ftype{display:inline-grid;place-items:center;min-width:42px;height:42px;border-radius:10px;font-size:11px;font-weight:800;color:#fff;background:#64748b;margin-right:10px;flex:none}.ftype.pdf{background:#dc2626}.ftype.xls{background:#16a34a}.ftype.doc{background:#2563eb}.ftype.ppt{background:#ea580c}.ftype.img{background:#7c3aed}.ftype.lnk{background:#0ea5e9}
.dname{display:flex;align-items:center}
@media (max-width:640px){h1{font-size:21px}.top .wrap{padding:8px 16px}.tabs{order:3;width:100%;margin:0}.kv th{width:40%}td,th{padding:7px 6px}}';
}

function hh_sale_layout( $title, $view, $body ) {
	$u    = wp_get_current_user();
	$tabs = array(
		'home'       => array( 'Tổng quan', hh_sale_url() ),
		'du-an'      => array( 'Học dự án', hh_sale_url( 'du-an' ) ),
		'tai-lieu'   => array( 'Tài liệu', hh_sale_url( 'tai-lieu' ) ),
		'khach-hang' => array( hh_sale_is_admin() ? 'Khách hàng' : 'Khách của tôi', hh_sale_url( 'khach-hang' ) ),
		'bao-cao'    => array( 'Báo cáo', hh_sale_url( 'bao-cao' ) ),
	);
	?><!DOCTYPE html>
<html lang="vi"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="robots" content="noindex,nofollow">
<title><?php echo esc_html( $title ); ?> – Khu Sale Hoàng Hiệp</title><style><?php echo hh_sale_css(); // phpcs:ignore ?></style></head>
<body><header class="top"><div class="wrap"><b>HOÀNG HIỆP<small>KHU SALE NỘI BỘ</small></b>
<nav class="tabs"><?php foreach ( $tabs as $k => $t ) : ?><a class="<?php echo $k === $view ? 'on' : ''; ?>" href="<?php echo esc_url( $t[1] ); ?>"><?php echo esc_html( $t[0] ); ?></a><?php endforeach; ?></nav>
<span class="who"><?php echo esc_html( $u->display_name ); ?> · <?php if ( hh_sale_is_admin() ) : ?><a href="<?php echo esc_url( admin_url( 'admin.php?page=hh-khu-sale' ) ); ?>">Quản trị</a> · <?php endif; ?><a href="<?php echo esc_url( wp_logout_url( hh_sale_url() ) ); ?>">Đăng xuất</a></span></div></header>
<main class="wrap"><?php echo $body; // phpcs:ignore WordPress.Security.EscapeOutput -- đã escape từng phần. ?>
<p class="note" style="margin:30px 0">Tài liệu nội bộ – không chia sẻ ra ngoài, không đăng lên mạng xã hội. Giá, chính sách chỉ để tham khảo; luôn đối chiếu bảng giá / phiếu tính giá mới nhất của chủ đầu tư trước khi báo khách.</p></main>
</body></html>
	<?php
}

function hh_sale_page_login() {
	$redirect = remove_query_arg( array( 'login', 'ml', 'mls' ), home_url( add_query_arg( array() ) ) );
	$err      = isset( $_GET['login'] ) ? 'Sai tài khoản hoặc mật khẩu.' : ''; // phpcs:ignore WordPress.Security.NonceVerification
	$mls      = sanitize_key( $_GET['mls'] ?? '' ); // phpcs:ignore WordPress.Security.NonceVerification
	$mlmsg    = array(
		'sent' => array( 'g', 'Nếu email này có tài khoản, link đăng nhập đã được gửi tới hộp thư (xem cả mục Thư rác / Quảng cáo). Link dùng 1 lần, hết hạn sau 15 phút.' ),
		'bad'  => array( 'r', 'Link đăng nhập không đúng hoặc đã hết hạn. Gửi lại link mới bên dưới.' ),
		'wait' => array( 'r', 'Bạn vừa yêu cầu link – đợi 1 phút rồi thử lại.' ),
	);
	$locked   = is_user_logged_in() && ! hh_sale_can();
	?><!DOCTYPE html>
<html lang="vi"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="robots" content="noindex,nofollow"><title>Đăng nhập – Khu Sale Hoàng Hiệp</title>
<style><?php echo hh_sale_css(); // phpcs:ignore ?>body{display:flex;align-items:center;justify-content:center;min-height:100vh;background:var(--n)}.lg{background:#fff;border-radius:16px;padding:26px 24px;width:100%;max-width:380px;margin:16px}.lg label{display:block;font-size:13.5px;font-weight:600;margin:10px 0 4px}.lg input[type=text],.lg input[type=password]{width:100%;padding:11px 12px}.lg .button{width:100%;margin-top:14px;border:0;border-radius:999px;padding:12px;background:linear-gradient(135deg,var(--o),var(--o2));color:#fff;font:inherit;font-weight:700;cursor:pointer}.lg .login-remember{font-size:13.5px}</style></head>
<body><div class="lg"><h1 style="margin-top:0">Khu Sale Hoàng Hiệp</h1>
	<?php if ( $locked ) : ?>
		<p class="note">Tài khoản này không có quyền vào khu sale hoặc đã bị khóa. Liên hệ anh Hiệp – 0904 567 009.</p><p><a href="<?php echo esc_url( wp_logout_url( hh_sale_url() ) ); ?>">Đăng xuất</a></p>
	<?php else : ?>
		<p class="note">Đăng nhập bằng số điện thoại (hoặc email) và mật khẩu – hoặc nhận link đăng nhập qua email ở cuối trang.</p>
		<?php if ( isset( $mlmsg[ $mls ] ) ) : ?><p style="font-size:14px;padding:10px 12px;border-radius:10px;<?php echo 'g' === $mlmsg[ $mls ][0] ? 'background:#e8f7ee;color:#14532d' : 'background:#fdecea;color:#b42318'; ?>"><?php echo esc_html( $mlmsg[ $mls ][1] ); ?></p><?php elseif ( $err ) : ?><p style="color:#b42318;font-size:14px"><?php echo esc_html( $err ); ?></p><?php endif; ?>
		<?php
		wp_login_form(
			array(
				'redirect'       => $redirect,
				'label_username' => 'Số điện thoại hoặc email',
				'label_password' => 'Mật khẩu',
				'label_remember' => 'Ghi nhớ trên máy này',
				'label_log_in'   => 'Đăng nhập',
			)
		);
		?>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="margin-top:20px;padding-top:16px;border-top:1px solid #e3e8ef">
			<input type="hidden" name="action" value="hh_sale_maillink">
			<label for="hhml" style="margin-top:0">Hoặc nhận link đăng nhập qua email</label>
			<input id="hhml" type="email" name="email" autocomplete="email" required placeholder="email@gmail.com" style="width:100%;padding:11px 12px">
			<button class="button" type="submit" style="background:#0e223a">Gửi link đăng nhập</button>
		</form>
		<p class="note">Không cần nhớ mật khẩu: gõ đúng email của tài khoản, mở hộp thư, bấm link là vào. Quên mật khẩu / chưa có email: nhắn anh Hiệp.</p>
	<?php endif; ?>
</div></body></html>
	<?php
}
/** Đăng nhập sai từ form khu sale: quay lại /sale/ thay vì trang đăng nhập WordPress. */
add_action(
	'wp_login_failed',
	static function () {
		$ref = wp_get_referer();
		if ( $ref && false !== strpos( $ref, '/sale/' ) ) {
			wp_safe_redirect( add_query_arg( 'login', 'failed', remove_query_arg( 'login', $ref ) ) );
			exit;
		}
	}
);

/* =========================================================================
 * Trang: Tổng quan
 * ====================================================================== */

function hh_sale_view_home() {
	$u     = wp_get_current_user();
	$leads = hh_sale_leads_query( hh_sale_is_admin() ? 0 : $u->ID, 200 );
	$count = array_fill_keys( array_keys( HH_LEAD_STATUSES ), 0 );
	foreach ( $leads as $l ) {
		$s = get_post_meta( $l->ID, 'hh_lead_status', true ) ?: 'moi';
		if ( isset( $count[ $s ] ) ) {
			++$count[ $s ];
		}
	}
	$hour = (int) wp_date( 'G' );
	$hi   = $hour < 11 ? 'Chào buổi sáng' : ( $hour < 14 ? 'Chào buổi trưa' : ( $hour < 18 ? 'Chào buổi chiều' : 'Chào buổi tối' ) );
	echo '<section class="hero"><h1>' . esc_html( $hi . ', ' . $u->display_name ) . ' 👋</h1><p>' . ( hh_sale_is_admin() ? 'Bạn đang xem với quyền quản trị – thấy khách của tất cả sale.' : ( $count['moi'] ? 'Bạn có <b>' . (int) $count['moi'] . ' khách mới</b> đang chờ gọi – gọi sớm trong 15 phút để chốt cao hơn.' : 'Chưa có khách mới chờ gọi. Dành thời gian học dự án và chuẩn bị tài liệu nhé.' ) ) . '</p>'
		. '<div class="acts"><a class="hl" href="' . esc_url( hh_sale_url( 'khach-hang' ) ) . '">Khách của tôi</a><a href="' . esc_url( hh_sale_url( 'du-an' ) ) . '">Học dự án</a><a href="' . esc_url( hh_sale_url( 'tai-lieu' ) ) . '">Tài liệu</a></div></section>';
	echo '<div class="stats">';
	foreach ( HH_LEAD_STATUSES as $k => $label ) {
		printf( '<div class="s-%s"><b>%d</b><span>%s</span></div>', esc_attr( $k ), (int) $count[ $k ], esc_html( $label ) );
	}
	echo '</div>';
	if ( ! hh_sale_is_admin() || current_user_can( 'hh_sale_portal' ) ) {
		echo '<div id="tg"></div>';
		hh_sale_tg_box();
	}
	echo '<div class="box"><h2>Khách mới nhất</h2>';
	$recent = array_slice( $leads, 0, 6 );
	if ( ! $recent ) {
		echo '<p class="note">Chưa có khách nào được giao.</p>';
	} else {
		echo '<div class="scroll"><table><tr><th>Khách</th><th>Quan tâm</th><th>Ngày</th><th>Trạng thái</th></tr>';
		foreach ( $recent as $l ) {
			$ref = (int) get_post_meta( $l->ID, 'hh_property_id', true );
			$st  = get_post_meta( $l->ID, 'hh_lead_status', true ) ?: 'moi';
			printf( '<tr><td><b>%s</b><br><a href="tel:%s">%s</a></td><td>%s</td><td>%s</td><td><span class="pill%s">%s</span></td></tr>', esc_html( $l->post_title ), esc_attr( get_post_meta( $l->ID, 'hh_phone', true ) ), esc_html( get_post_meta( $l->ID, 'hh_phone', true ) ), esc_html( $ref ? get_the_title( $ref ) : (string) get_post_meta( $l->ID, 'hh_need', true ) ), esc_html( get_the_date( 'd/m H:i', $l ) ), 'moi' === $st ? ' o' : ( 'chot' === $st ? ' g' : '' ), esc_html( HH_LEAD_STATUSES[ $st ] ?? $st ) );
		}
		echo '</table></div><p><a class="btn s" href="' . esc_url( hh_sale_url( 'khach-hang' ) ) . '">Xem tất cả khách</a></p>';
	}
	echo '</div>';
	// Dự án có chính sách đang chạy.
	$hot = get_posts( array( 'post_type' => 'du-an', 'post_status' => 'publish', 'numberposts' => 12, 'meta_key' => 'hh_p_featured', 'meta_value' => '1', 'orderby' => 'modified' ) ); // phpcs:ignore WordPress.DB.SlowDBQuery
	if ( $hot ) {
		echo '<div class="box"><h2>Dự án trọng điểm</h2><div class="grid">';
		foreach ( $hot as $p ) {
			hh_sale_project_card( $p );
		}
		echo '</div></div>';
	}
}

/* =========================================================================
 * Trang: Học dự án
 * ====================================================================== */

function hh_sale_project_card( $p ) {
	$m    = static fn( $k ) => trim( (string) get_post_meta( $p->ID, $k, true ) );
	$st   = function_exists( 'hh_project_schema' ) ? hh_option_label( hh_project_schema(), 'hh_p_status', $m( 'hh_p_status' ) ) : '';
	$dl   = $m( 'hh_p_offer_deadline' );
	$has  = $m( '_hh_sale_usp' ) || $m( '_hh_sale_faq' );
	$docs = hh_sale_docs_for( $p->ID );
	$thumb = get_the_post_thumbnail_url( $p, 'medium_large' ) ?: get_the_post_thumbnail_url( $p, 'large' );
	printf(
		'<a class="card" href="%s" data-s="%s"><span class="ph"%s></span><span class="in"><b>%s</b><span>%s%s</span><br>%s%s%s</span></a>',
		esc_url( hh_sale_url( 'du-an/' . $p->post_name ) ),
		esc_attr( mb_strtolower( get_the_title( $p ) . ' ' . $m( 'hh_p_developer' ) . ' ' . $m( 'hh_p_address' ) ) ),
		$thumb ? ' style="background-image:url(\'' . esc_url( $thumb ) . '\')"' : '',
		esc_html( get_the_title( $p ) ),
		esc_html( $m( 'hh_p_developer' ) ),
		$m( 'hh_p_price_m2' ) ? ' · ' . esc_html( $m( 'hh_p_price_m2' ) ) : '',
		$st ? '<span class="pill">' . esc_html( $st ) . '</span> ' : '',
		$dl ? '<span class="pill o">Ưu đãi đến ' . esc_html( $dl ) . '</span> ' : '',
		( $has ? '<span class="pill g">Có hướng dẫn sale</span> ' : '' ) . ( $docs ? '<span class="pill">' . count( $docs ) . ' tài liệu</span>' : '' )
	);
}

function hh_sale_view_projects() {
	$all = get_posts( array( 'post_type' => 'du-an', 'post_status' => 'publish', 'numberposts' => -1, 'orderby' => 'title', 'order' => 'ASC' ) );
	usort(
		$all,
		static function ( $a, $b ) {
			$fa = '1' === get_post_meta( $a->ID, 'hh_p_featured', true ) ? 0 : 1;
			$fb = '1' === get_post_meta( $b->ID, 'hh_p_featured', true ) ? 0 : 1;
			return $fa <=> $fb ?: strcmp( $a->post_title, $b->post_title );
		}
	);
	echo '<h1>Học dự án</h1><p class="note">' . count( $all ) . ' dự án – dự án trọng điểm xếp trước. Gõ tên dự án, chủ đầu tư hoặc khu vực để lọc.</p>';
	echo '<input class="search" type="search" placeholder="Tìm dự án…" oninput="var q=this.value.toLowerCase();document.querySelectorAll(\'.card[data-s]\').forEach(function(c){c.style.display=c.dataset.s.indexOf(q)>-1?\'\':\'none\'})">';
	echo '<div class="grid" style="margin-top:12px">';
	foreach ( $all as $p ) {
		hh_sale_project_card( $p );
	}
	echo '</div>';
}

function hh_sale_kv( $rows ) {
	$rows = array_filter( $rows, static fn( $v ) => '' !== trim( (string) $v ) );
	if ( ! $rows ) {
		return;
	}
	echo '<table class="kv">';
	foreach ( $rows as $k => $v ) {
		printf( '<tr><th>%s</th><td>%s</td></tr>', esc_html( $k ), nl2br( esc_html( $v ) ) );
	}
	echo '</table>';
}

function hh_sale_table( $head, $rows ) {
	$rows = array_filter( $rows, static fn( $r ) => '' !== trim( implode( '', $r ) ) );
	if ( ! $rows ) {
		return false;
	}
	echo '<div class="scroll"><table><tr>';
	foreach ( $head as $h ) {
		echo '<th>' . esc_html( $h ) . '</th>';
	}
	echo '</tr>';
	foreach ( $rows as $r ) {
		echo '<tr>';
		foreach ( $r as $c ) {
			echo '<td>' . esc_html( $c ) . '</td>';
		}
		echo '</tr>';
	}
	echo '</table></div>';
	return true;
}

/** Dòng "a | b" → mảng 2 cột. */
function hh_sale_pairs( $text ) {
	$out = array();
	foreach ( preg_split( '/\R/u', (string) $text ) as $line ) {
		$line = trim( $line );
		if ( '' === $line ) {
			continue;
		}
		$p     = array_map( 'trim', explode( '|', $line, 2 ) );
		$out[] = array( $p[0], $p[1] ?? '' );
	}
	return $out;
}

function hh_sale_view_project( $slug ) {
	$p = get_page_by_path( $slug, OBJECT, 'du-an' );
	if ( ! $p || 'publish' !== $p->post_status ) {
		echo '<h1>Không tìm thấy dự án</h1><p><a href="' . esc_url( hh_sale_url( 'du-an' ) ) . '">← Danh sách dự án</a></p>';
		return 'Không tìm thấy';
	}
	$id    = $p->ID;
	$m     = static fn( $k ) => trim( (string) get_post_meta( $id, $k, true ) );
	$lines = static fn( $k ) => function_exists( 'hh_lines' ) ? hh_lines( $k, $id ) : array();
	$tbl   = static fn( $k, $n ) => function_exists( 'hh_table' ) ? hh_table( $k, $n, $id ) : array();
	$st    = function_exists( 'hh_project_schema' ) ? hh_option_label( hh_project_schema(), 'hh_p_status', $m( 'hh_p_status' ) ) : '';
	$title = get_the_title( $p );

	echo '<p style="margin:16px 0 0"><a href="' . esc_url( hh_sale_url( 'du-an' ) ) . '">← Danh sách dự án</a></p>';
	$cov = get_the_post_thumbnail_url( $p, '1536x1536' ) ?: get_the_post_thumbnail_url( $p, 'large' );
	echo '<section class="cover"' . ( $cov ? ' style="background-image:url(\'' . esc_url( $cov ) . '\')"' : '' ) . '><div><h1>' . esc_html( $title ) . '</h1><p>' . ( $st ? '<span class="pill o">' . esc_html( $st ) . '</span> ' : '' ) . ( $m( 'hh_p_developer' ) ? esc_html( $m( 'hh_p_developer' ) ) . ' · ' : '' ) . 'Cập nhật ' . esc_html( get_the_modified_date( 'd/m/Y', $p ) ) . ' · <a href="' . esc_url( get_permalink( $p ) ) . '" target="_blank" rel="noopener">Trang khách xem ↗</a></p></div></section>';

	// 1. Điểm bán hàng.
	$usp = array_filter( array_map( 'trim', preg_split( '/\R/u', $m( '_hh_sale_usp' ) ) ) ) ?: $lines( 'hh_p_highlights' );
	if ( $usp ) {
		echo '<div class="box"><h2>Điểm bán hàng chính</h2><ul class="l">';
		foreach ( $usp as $l ) {
			echo '<li>' . esc_html( $l ) . '</li>';
		}
		echo '</ul>' . ( $m( '_hh_sale_usp' ) ? '' : '<p class="note">(Lấy từ "Điểm nổi bật" của trang dự án – anh Hiệp có thể viết riêng cho sale trong khung "Dành cho sale".)</p>' ) . '</div>';
	}
	// 2. Thông tin nhanh.
	echo '<div class="box"><h2>Thông tin nhanh</h2>';
	hh_sale_kv(
		array(
			'Chủ đầu tư'          => $m( 'hh_p_developer' ),
			'Vị trí'              => $m( 'hh_p_address' ),
			'Loại hình'           => $m( 'hh_p_type' ),
			'Quy mô'              => $m( 'hh_p_scale' ),
			'Số tòa / số tầng'    => trim( $m( 'hh_p_blocks' ) . ( $m( 'hh_p_floors' ) ? ' · ' . $m( 'hh_p_floors' ) : '' ), ' ·' ),
			'Tổng sản phẩm'       => $m( 'hh_p_units' ),
			'Diện tích sản phẩm'  => $m( 'hh_p_unit_area' ),
			'Đơn giá tham khảo'   => $m( 'hh_p_price_m2' ),
			'Pháp lý'             => $m( 'hh_p_legal' ),
			'Hình thức sở hữu'    => $m( 'hh_p_ownership' ),
			'Khởi công'           => $m( 'hh_p_start' ),
			'Bàn giao'            => $m( 'hh_p_handover' ),
			'Tiêu chuẩn bàn giao' => $m( 'hh_p_handover_std' ),
			'Nhà thầu'            => $m( 'hh_p_builder' ),
			'Quản lý vận hành'    => $m( 'hh_p_manager' ),
		)
	);
	echo '</div>';
	// 3. Loại căn & giá.
	ob_start();
	$a = hh_sale_table( array( 'Loại căn', 'Diện tích', 'Phòng ngủ', 'Giá tham khảo' ), $tbl( 'hh_p_unit_types', 4 ) );
	$b = hh_sale_table( array( 'Sản phẩm', 'Diện tích', 'Giá bán', 'Ghi chú' ), $tbl( 'hh_p_price_table', 4 ) );
	$c = $m( 'hh_p_resale_price' ) || $m( 'hh_p_rent_price' );
	if ( $c ) {
		hh_sale_kv( array( 'Giá chuyển nhượng' => $m( 'hh_p_resale_price' ), 'Giá thuê' => $m( 'hh_p_rent_price' ) ) );
	}
	$html = ob_get_clean();
	if ( $a || $b || $c ) {
		echo '<div class="box"><h2>Sản phẩm & giá tham khảo</h2>' . $html . '</div>'; // phpcs:ignore
	}
	// 4. Chính sách hiện hành.
	ob_start();
	hh_sale_kv( array( 'Ưu đãi nổi bật' => $m( 'hh_p_offer_title' ), 'Áp dụng từ' => $m( 'hh_p_offer_start' ), 'Hạn ưu đãi' => $m( 'hh_p_offer_deadline' ), 'Ghi chú' => $m( 'hh_p_offer_note' ) ) );
	$pol = $lines( 'hh_p_policy' );
	if ( $pol ) {
		echo '<ul class="l">';
		foreach ( $pol as $l ) {
			echo '<li>' . esc_html( $l ) . '</li>';
		}
		echo '</ul>';
	}
	hh_sale_table( array( 'Phương án', 'Hạn thanh toán', 'Chiết khấu', 'Cách tính' ), $tbl( 'hh_p_discount_table', 4 ) );
	hh_sale_table( array( 'Đợt', 'Thời điểm', 'Tỷ lệ' ), $tbl( 'hh_p_payment', 3 ) );
	if ( $m( 'hh_p_loan' ) || $m( 'hh_p_loan_bank' ) ) {
		hh_sale_kv( array( 'Hỗ trợ vay' => $m( 'hh_p_loan' ), 'Ngân hàng' => $m( 'hh_p_loan_bank' ), 'Tỷ lệ vay tối đa' => $m( 'hh_p_loan_ratio' ) ? $m( 'hh_p_loan_ratio' ) . '%' : '', 'Hỗ trợ lãi 0%' => $m( 'hh_p_loan_zero_months' ) ? $m( 'hh_p_loan_zero_months' ) . ' tháng' : '' ) );
	}
	if ( $m( 'hh_p_rental' ) ) {
		hh_sale_kv( array( 'Chương trình cho thuê' => $m( 'hh_p_rental' ) ) );
	}
	$html = trim( ob_get_clean() );
	if ( $html ) {
		echo '<div class="box"><h2>Chính sách bán hàng hiện hành</h2>' . $html . '<p class="note">Đối chiếu văn bản chính sách mới nhất của chủ đầu tư trước khi báo khách.</p></div>'; // phpcs:ignore
	}
	// 5. Câu hỏi khách hay hỏi.
	$faq = hh_sale_pairs( $m( '_hh_sale_faq' ) );
	if ( $faq ) {
		echo '<div class="box"><h2>Khách hay hỏi – cách trả lời</h2><dl class="faq">';
		foreach ( $faq as $q ) {
			echo '<dt>' . esc_html( $q[0] ) . '</dt><dd>' . esc_html( $q[1] ) . '</dd>';
		}
		echo '</dl></div>';
	}
	// 6. Lưu ý khi tư vấn.
	if ( $m( '_hh_sale_notes' ) ) {
		echo '<div class="box warn"><h2>Lưu ý khi tư vấn</h2>' . wpautop( esc_html( $m( '_hh_sale_notes' ) ) ) . '</div>'; // phpcs:ignore
	}
	// 7. Tiến độ.
	$prog = array_slice( array_reverse( $tbl( 'hh_p_progress', 2 ) ), 0, 6 );
	if ( $prog ) {
		echo '<div class="box"><h2>Tiến độ mới nhất</h2>';
		hh_sale_table( array( 'Thời gian', 'Nội dung' ), $prog );
		echo '</div>';
	}
	// 8. Tài liệu.
	$docs  = hh_sale_docs_for( $id );
	$links = hh_sale_pairs( $m( '_hh_sale_links' ) );
	if ( $docs || $links || $m( 'hh_p_pricelist_url' ) ) {
		echo '<div class="box"><h2>Tài liệu dự án</h2>';
		hh_sale_docs_list( $docs );
		if ( $links || $m( 'hh_p_pricelist_url' ) ) {
			echo '<ul class="l">';
			foreach ( $links as $l ) {
				$url = $l[1] ?: $l[0];
				printf( '<li><a href="%s" target="_blank" rel="noopener">%s</a></li>', esc_url( $url ), esc_html( $l[1] ? $l[0] : $url ) );
			}
			if ( $m( 'hh_p_pricelist_url' ) ) {
				printf( '<li><a href="%s" target="_blank" rel="noopener">Bảng giá / brochure (link trên trang dự án)</a></li>', esc_url( $m( 'hh_p_pricelist_url' ) ) );
			}
			echo '</ul>';
		}
		echo '</div>';
	}
	return $title;
}

/* =========================================================================
 * Khung "Dành cho sale (nội bộ)" trong trang sửa dự án
 * ====================================================================== */

add_action(
	'add_meta_boxes_du-an',
	static function () {
		add_meta_box(
			'hh_sale_box',
			'Dành cho sale (nội bộ – không hiện trên web)',
			static function ( $post ) {
				wp_nonce_field( 'hh_sale_box', 'hh_sale_box_nonce' );
				$f = array(
					'_hh_sale_usp'   => array( 'Điểm bán hàng chính (mỗi dòng 1 ý)', 'Vị trí mặt biển, 300 m ra bãi tắm…' ),
					'_hh_sale_faq'   => array( 'Khách hay hỏi – cách trả lời (mỗi dòng: Câu hỏi | Trả lời)', "Có sổ hồng không? | Sở hữu lâu dài với khách Việt Nam, cấp sổ sau bàn giao…\nVay được bao nhiêu? | Ngân hàng … cho vay tới 70%…" ),
					'_hh_sale_notes' => array( 'Lưu ý khi tư vấn (điều không được nói, cách xử lý từ chối…)', '' ),
					'_hh_sale_links' => array( 'Link tài liệu nội bộ (mỗi dòng: Tên | link Google Drive…)', 'Bảng hàng tháng 11 | https://drive.google.com/…' ),
				);
				echo '<p class="description">Chỉ sale đã đăng nhập thấy ở trang <a href="' . esc_url( hh_sale_url( 'du-an/' . $post->post_name ) ) . '" target="_blank">Khu Sale → ' . esc_html( get_the_title( $post ) ) . '</a>. Tải file kín (bảng hàng, đào tạo…) ở menu Khu Sale → Tài liệu.</p>';
				foreach ( $f as $k => $d ) {
					printf( '<p><label for="%1$s"><b>%2$s</b></label><br><textarea id="%1$s" name="%1$s" rows="4" style="width:100%%" placeholder="%3$s">%4$s</textarea></p>', esc_attr( $k ), esc_html( $d[0] ), esc_attr( $d[1] ), esc_textarea( (string) get_post_meta( $post->ID, $k, true ) ) );
				}
			},
			'du-an',
			'normal',
			'low'
		);
	}
);
add_action(
	'save_post_du-an',
	static function ( $post_id ) {
		if ( ! isset( $_POST['hh_sale_box_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['hh_sale_box_nonce'] ), 'hh_sale_box' ) || ! current_user_can( 'edit_post', $post_id ) || wp_is_post_revision( $post_id ) ) {
			return;
		}
		foreach ( array( '_hh_sale_usp', '_hh_sale_faq', '_hh_sale_notes', '_hh_sale_links' ) as $k ) {
			update_post_meta( $post_id, $k, sanitize_textarea_field( wp_unslash( $_POST[ $k ] ?? '' ) ) );
		}
	}
);

/* =========================================================================
 * Tài liệu kín
 * ====================================================================== */

add_action(
	'init',
	static function () {
		register_post_type(
			HH_SALE_DOC_TYPE,
			array(
				'labels'          => array( 'name' => 'Tài liệu sale', 'singular_name' => 'Tài liệu sale', 'add_new_item' => 'Thêm tài liệu sale', 'edit_item' => 'Sửa tài liệu sale', 'all_items' => 'Tài liệu sale' ),
				'public'          => false,
				'show_ui'         => true,
				'show_in_menu'    => 'hh-khu-sale',
				'show_in_rest'    => false,
				'supports'        => array( 'title' ),
				'capability_type' => 'post',
				'map_meta_cap'    => true,
			)
		);
	}
);

function hh_sale_doc_dir() {
	$up  = wp_upload_dir();
	$dir = trailingslashit( $up['basedir'] ) . HH_SALE_DOC_DIR . '/';
	if ( ! is_dir( $dir ) ) {
		wp_mkdir_p( $dir );
	}
	if ( ! is_file( $dir . '.htaccess' ) ) {
		file_put_contents( $dir . '.htaccess', "# Tài liệu nội bộ – chỉ tải qua /sale/tai/<id>/\n<IfModule mod_authz_core.c>\nRequire all denied\n</IfModule>\n<IfModule !mod_authz_core.c>\nOrder allow,deny\nDeny from all\n</IfModule>\nOptions -Indexes\n" ); // phpcs:ignore
		file_put_contents( $dir . 'index.php', "<?php // Silence.\n" ); // phpcs:ignore
	}
	return $dir;
}

add_action( 'post_edit_form_tag', static fn( $post ) => ( $post && HH_SALE_DOC_TYPE === $post->post_type ) ? print( ' enctype="multipart/form-data"' ) : null );

add_action(
	'add_meta_boxes_' . HH_SALE_DOC_TYPE,
	static function () {
		add_meta_box(
			'hh_sale_doc',
			'Tài liệu',
			static function ( $post ) {
				wp_nonce_field( 'hh_sale_doc', 'hh_sale_doc_nonce' );
				$pid   = (int) get_post_meta( $post->ID, '_hh_doc_project', true );
				$grp   = (string) get_post_meta( $post->ID, '_hh_doc_group', true );
				$name  = (string) get_post_meta( $post->ID, '_hh_doc_name', true );
				$link  = (string) get_post_meta( $post->ID, '_hh_doc_link', true );
				$projs = get_posts( array( 'post_type' => 'du-an', 'post_status' => 'publish', 'numberposts' => -1, 'orderby' => 'title', 'order' => 'ASC' ) );
				echo '<table class="form-table"><tr><th>Dự án</th><td><select name="hh_doc_project"><option value="0">— Chung (không thuộc dự án) —</option>';
				foreach ( $projs as $p ) {
					printf( '<option value="%d"%s>%s</option>', (int) $p->ID, selected( $pid, $p->ID, false ), esc_html( get_the_title( $p ) ) );
				}
				echo '</select></td></tr><tr><th>Nhóm</th><td><select name="hh_doc_group">';
				foreach ( HH_SALE_GROUPS as $g ) {
					printf( '<option%s>%s</option>', selected( $grp, $g, false ), esc_html( $g ) );
				}
				echo '</select></td></tr><tr><th>File</th><td>';
				if ( $name ) {
					echo '<p>Đang có: <b>' . esc_html( $name ) . '</b> – <a href="' . esc_url( hh_sale_url( 'tai/' . $post->ID ) ) . '" target="_blank">tải thử</a></p>';
				}
				echo '<input type="file" name="hh_doc_file"><p class="description">PDF, Excel, Word, PowerPoint, ảnh, ZIP – tối đa theo giới hạn tải lên của hosting. File lưu trong thư mục kín, không mở được bằng đường link trực tiếp.</p></td></tr>';
				echo '<tr><th>Hoặc link</th><td><input type="url" class="regular-text" name="hh_doc_link" value="' . esc_attr( $link ) . '" placeholder="https://drive.google.com/…"><p class="description">Link Google Drive đã chia sẻ riêng cho team (không để chế độ công khai).</p></td></tr></table>';
				$log = array_slice( array_reverse( (array) get_post_meta( $post->ID, '_hh_doc_log', true ) ), 0, 30 );
				if ( $log ) {
					echo '<h4>Lượt tải gần nhất</h4><ul>';
					foreach ( $log as $r ) {
						$u = get_userdata( (int) ( $r[1] ?? 0 ) );
						printf( '<li>%s – %s</li>', esc_html( wp_date( 'd/m/Y H:i', (int) ( $r[0] ?? 0 ) ) ), esc_html( $u ? $u->display_name . ' (' . $u->user_login . ')' : '?' ) );
					}
					echo '</ul>';
				}
			},
			HH_SALE_DOC_TYPE,
			'normal',
			'high'
		);
	}
);

add_action(
	'save_post_' . HH_SALE_DOC_TYPE,
	static function ( $post_id ) {
		if ( ! isset( $_POST['hh_sale_doc_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['hh_sale_doc_nonce'] ), 'hh_sale_doc' ) || ! current_user_can( 'edit_post', $post_id ) || wp_is_post_revision( $post_id ) ) {
			return;
		}
		update_post_meta( $post_id, '_hh_doc_project', absint( $_POST['hh_doc_project'] ?? 0 ) );
		$g = sanitize_text_field( wp_unslash( $_POST['hh_doc_group'] ?? '' ) );
		update_post_meta( $post_id, '_hh_doc_group', in_array( $g, HH_SALE_GROUPS, true ) ? $g : 'Khác' );
		update_post_meta( $post_id, '_hh_doc_link', esc_url_raw( wp_unslash( $_POST['hh_doc_link'] ?? '' ) ) );
		if ( ! empty( $_FILES['hh_doc_file']['tmp_name'] ) && UPLOAD_ERR_OK === (int) $_FILES['hh_doc_file']['error'] ) {
			$orig = sanitize_file_name( wp_unslash( $_FILES['hh_doc_file']['name'] ) ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
			$type = wp_check_filetype_and_ext( $_FILES['hh_doc_file']['tmp_name'], $orig ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
			$ext  = strtolower( (string) ( $type['ext'] ?: pathinfo( $orig, PATHINFO_EXTENSION ) ) );
			if ( ! in_array( $ext, array( 'pdf', 'xlsx', 'xls', 'csv', 'docx', 'doc', 'pptx', 'ppt', 'jpg', 'jpeg', 'png', 'webp', 'zip', 'mp4', 'txt' ), true ) ) {
				return;
			}
			$dir  = hh_sale_doc_dir();
			$file = wp_generate_password( 20, false ) . '.' . $ext;
			if ( move_uploaded_file( $_FILES['hh_doc_file']['tmp_name'], $dir . $file ) ) { // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
				$old = (string) get_post_meta( $post_id, '_hh_doc_file', true );
				if ( $old && is_file( $dir . basename( $old ) ) ) {
					wp_delete_file( $dir . basename( $old ) );
				}
				update_post_meta( $post_id, '_hh_doc_file', $file );
				update_post_meta( $post_id, '_hh_doc_name', $orig );
				update_post_meta( $post_id, '_hh_doc_mime', (string) ( $type['type'] ?: 'application/octet-stream' ) );
			}
		}
	}
);
add_action(
	'before_delete_post',
	static function ( $post_id ) {
		if ( HH_SALE_DOC_TYPE === get_post_type( $post_id ) ) {
			$f = (string) get_post_meta( $post_id, '_hh_doc_file', true );
			if ( $f && is_file( hh_sale_doc_dir() . basename( $f ) ) ) {
				wp_delete_file( hh_sale_doc_dir() . basename( $f ) );
			}
		}
	}
);
add_filter(
	'manage_' . HH_SALE_DOC_TYPE . '_posts_columns',
	static fn( $c ) => array_slice( $c, 0, 2, true ) + array( 'hh_dp' => 'Dự án', 'hh_dg' => 'Nhóm', 'hh_dl' => 'Lượt tải' ) + $c
);
add_action(
	'manage_' . HH_SALE_DOC_TYPE . '_posts_custom_column',
	static function ( $col, $id ) {
		if ( 'hh_dp' === $col ) {
			$p = (int) get_post_meta( $id, '_hh_doc_project', true );
			echo esc_html( $p ? get_the_title( $p ) : 'Chung' );
		} elseif ( 'hh_dg' === $col ) {
			echo esc_html( (string) get_post_meta( $id, '_hh_doc_group', true ) );
		} elseif ( 'hh_dl' === $col ) {
			echo (int) count( (array) get_post_meta( $id, '_hh_doc_log', true ) );
		}
	},
	10,
	2
);

/** Tài liệu của một dự án (0 = tài liệu chung). */
function hh_sale_docs_for( $project_id = null ) {
	static $all = null;
	if ( null === $all ) {
		$all = get_posts( array( 'post_type' => HH_SALE_DOC_TYPE, 'post_status' => 'publish', 'numberposts' => -1, 'orderby' => 'date', 'order' => 'DESC' ) );
	}
	if ( null === $project_id ) {
		return $all;
	}
	return array_values( array_filter( $all, static fn( $d ) => (int) get_post_meta( $d->ID, '_hh_doc_project', true ) === (int) $project_id ) );
}

function hh_sale_ftype( $name ) {
	$ext = strtolower( pathinfo( $name, PATHINFO_EXTENSION ) );
	$map = array( 'pdf' => 'pdf', 'xlsx' => 'xls', 'xls' => 'xls', 'csv' => 'xls', 'docx' => 'doc', 'doc' => 'doc', 'pptx' => 'ppt', 'ppt' => 'ppt', 'jpg' => 'img', 'jpeg' => 'img', 'png' => 'img', 'webp' => 'img', 'mp4' => 'img' );
	$cls = '' === $name ? 'lnk' : ( $map[ $ext ] ?? '' );
	return '<span class="ftype ' . esc_attr( $cls ) . '">' . esc_html( '' === $name ? 'LINK' : strtoupper( $ext ?: 'FILE' ) ) . '</span>';
}

function hh_sale_docs_list( $docs ) {
	if ( ! $docs ) {
		return;
	}
	echo '<div class="scroll"><table><tr><th>Tài liệu</th><th>Nhóm</th><th>Ngày</th><th></th></tr>';
	foreach ( $docs as $d ) {
		$link = (string) get_post_meta( $d->ID, '_hh_doc_link', true );
		$file = (string) get_post_meta( $d->ID, '_hh_doc_file', true );
		$url  = $file ? hh_sale_url( 'tai/' . $d->ID ) : $link;
		printf(
			'<tr><td><div class="dname">%s<div><b>%s</b>%s</div></div></td><td>%s</td><td>%s</td><td>%s</td></tr>',
			hh_sale_ftype( $file ? (string) get_post_meta( $d->ID, '_hh_doc_name', true ) : '' ),
			esc_html( get_the_title( $d ) ),
			$file ? '<br><span class="note">' . esc_html( (string) get_post_meta( $d->ID, '_hh_doc_name', true ) ) . '</span>' : '',
			esc_html( (string) get_post_meta( $d->ID, '_hh_doc_group', true ) ),
			esc_html( get_the_date( 'd/m/Y', $d ) ),
			$url ? '<a class="btn s" href="' . esc_url( $url ) . '"' . ( $file ? '' : ' target="_blank" rel="noopener"' ) . '>' . ( $file ? 'Tải về' : 'Mở link' ) . '</a>' : ''
		);
	}
	echo '</table></div>';
}

function hh_sale_view_docs() {
	$all = hh_sale_docs_for();
	echo '<h1>Tài liệu</h1><p class="note">Tài liệu nội bộ – mỗi lượt tải đều được ghi lại theo tài khoản; ảnh tải về có in tên người tải. Không gửi file cho người ngoài team.</p>';
	if ( ! $all ) {
		echo '<div class="box"><p class="note">Chưa có tài liệu. ' . ( hh_sale_is_admin() ? '<a href="' . esc_url( admin_url( 'post-new.php?post_type=' . HH_SALE_DOC_TYPE ) ) . '">Thêm tài liệu</a>' : '' ) . '</p></div>';
		return;
	}
	$by = array();
	foreach ( $all as $d ) {
		$by[ (int) get_post_meta( $d->ID, '_hh_doc_project', true ) ][] = $d;
	}
	uksort( $by, static fn( $a, $b ) => ( 0 === $a ? -1 : ( 0 === $b ? 1 : strcmp( get_the_title( $a ), get_the_title( $b ) ) ) ) );
	echo '<input class="search" type="search" placeholder="Tìm tài liệu…" oninput="var q=this.value.toLowerCase();document.querySelectorAll(\'.docgrp\').forEach(function(g){var any=false;g.querySelectorAll(\'tr\').forEach(function(r,i){if(!i)return;var ok=(g.dataset.s+\' \'+r.textContent).toLowerCase().indexOf(q)>-1;r.style.display=ok?\'\':\'none\';any=any||ok});g.style.display=any?\'\':\'none\'})">';
	foreach ( $by as $pid => $docs ) {
		$name = $pid ? get_the_title( $pid ) : 'Tài liệu chung';
		echo '<div class="box docgrp" data-s="' . esc_attr( $name ) . '"><h2>' . esc_html( $name ) . '</h2>';
		hh_sale_docs_list( $docs );
		echo '</div>';
	}
}

/** Tải file kín: ghi lượt tải, ảnh JPG/PNG in tên + số của người tải. */
function hh_sale_download( $id ) {
	$d = get_post( $id );
	if ( ! $d || HH_SALE_DOC_TYPE !== $d->post_type || ( 'publish' !== $d->post_status && ! hh_sale_is_admin() ) ) {
		status_header( 404 );
		echo 'Không tìm thấy tài liệu.';
		return;
	}
	$file = (string) get_post_meta( $id, '_hh_doc_file', true );
	$path = $file ? hh_sale_doc_dir() . basename( $file ) : '';
	if ( ! $path || ! is_file( $path ) ) {
		$link = (string) get_post_meta( $id, '_hh_doc_link', true );
		if ( $link ) {
			wp_redirect( $link ); // phpcs:ignore WordPress.Security.SafeRedirect -- link quản trị viên nhập.
			return;
		}
		status_header( 404 );
		echo 'File không còn.';
		return;
	}
	$u   = wp_get_current_user();
	$log = (array) get_post_meta( $id, '_hh_doc_log', true );
	$log = array_slice( array_values( array_filter( $log ) ), -500 );
	$log[] = array( time(), $u->ID );
	update_post_meta( $id, '_hh_doc_log', $log );

	$name = (string) get_post_meta( $id, '_hh_doc_name', true ) ?: basename( $path );
	$mime = (string) get_post_meta( $id, '_hh_doc_mime', true ) ?: 'application/octet-stream';
	$ext  = strtolower( pathinfo( $path, PATHINFO_EXTENSION ) );
	if ( in_array( $ext, array( 'jpg', 'jpeg', 'png' ), true ) && function_exists( 'imagecreatefromstring' ) ) {
		$img = @imagecreatefromstring( (string) file_get_contents( $path ) ); // phpcs:ignore
		if ( $img ) {
			$w     = imagesx( $img );
			$h     = imagesy( $img );
			$text  = 'Noi bo Hoang Hiep - ' . remove_accents( $u->display_name ) . ' ' . $u->user_login . ' - ' . wp_date( 'd/m/Y H:i' );
			$font  = 5;
			$tw    = imagefontwidth( $font ) * strlen( $text );
			$bg    = imagecolorallocatealpha( $img, 0, 0, 0, 60 );
			$fg    = imagecolorallocate( $img, 255, 255, 255 );
			imagefilledrectangle( $img, 0, $h - 26, min( $w, $tw + 20 ), $h, $bg );
			imagestring( $img, $font, 10, $h - 21, $text, $fg );
			$faint = imagecolorallocatealpha( $img, 255, 255, 255, 105 );
			for ( $y = 40; $y < $h - 40; $y += 160 ) {
				for ( $x = 20; $x < $w; $x += $tw + 120 ) {
					imagestring( $img, $font, $x + ( ( $y / 160 ) % 2 ) * 80, $y, $text, $faint );
				}
			}
			nocache_headers();
			header( 'Content-Type: ' . ( 'png' === $ext ? 'image/png' : 'image/jpeg' ) );
			header( 'Content-Disposition: attachment; filename="' . rawurlencode( $name ) . '"; filename*=UTF-8\'\'' . rawurlencode( $name ) );
			'png' === $ext ? imagepng( $img ) : imagejpeg( $img, null, 90 );
			imagedestroy( $img );
			return;
		}
	}
	while ( ob_get_level() ) {
		ob_end_clean();
	}
	header( 'Content-Type: ' . $mime );
	header( 'Content-Length: ' . filesize( $path ) );
	header( 'Content-Disposition: attachment; filename="' . rawurlencode( $name ) . '"; filename*=UTF-8\'\'' . rawurlencode( $name ) );
	header( 'X-Content-Type-Options: nosniff' );
	readfile( $path ); // phpcs:ignore WordPress.WP.AlternativeFunctions
}

/* =========================================================================
 * Khách hàng: chia cho sale, sale cập nhật trạng thái + ghi chú
 * ====================================================================== */

/** Sale đang hoạt động (không khóa, không tạm ngưng nhận khách). */
function hh_sale_active_users() {
	$users = get_users( array( 'role' => HH_SALE_ROLE, 'orderby' => 'ID', 'order' => 'ASC' ) );
	return array_values( array_filter( $users, static fn( $u ) => ! get_user_meta( $u->ID, 'hh_sale_locked', true ) && ! get_user_meta( $u->ID, 'hh_sale_paused', true ) ) );
}

/** Khách mới từ web (form, chat…): giao vòng lần lượt cho sale đang hoạt động. */
add_action(
	'wp_after_insert_post',
	static function ( $post_id, $post, $update ) {
		if ( $update || 'khach-hang' !== $post->post_type || '1' !== (string) get_option( 'hh_sale_autoassign', '0' ) || get_post_meta( $post_id, 'hh_sale_owner', true ) ) {
			return;
		}
		// Chia sau khi form lưu xong số điện thoại, nhu cầu, cờ spam (các ô này ghi sau lúc tạo bài).
		add_action(
			'shutdown',
			static function () use ( $post_id ) {
				if ( 'khach-hang' !== get_post_type( $post_id ) || get_post_meta( $post_id, 'hh_sale_owner', true ) || get_post_meta( $post_id, 'hh_spam', true ) || 'huy' === get_post_meta( $post_id, 'hh_lead_status', true ) ) {
					return;
				}
				$sales = hh_sale_active_users();
				if ( ! $sales ) {
					return;
				}
				$i = (int) get_option( 'hh_sale_rr', 0 ) % count( $sales );
				update_option( 'hh_sale_rr', $i + 1, false );
				hh_sale_assign( $post_id, $sales[ $i ]->ID, 'Tự chia vòng' );
			},
			5
		);
	},
	30,
	3
);

function hh_sale_assign( $lead_id, $user_id, $how = '' ) {
	$old = (int) get_post_meta( $lead_id, 'hh_sale_owner', true );
	if ( $old === (int) $user_id ) {
		return;
	}
	update_post_meta( $lead_id, 'hh_sale_owner', (int) $user_id );
	update_post_meta( $lead_id, 'hh_sale_assigned_at', time() );
	$u = get_userdata( (int) $user_id );
	hh_sale_log( $lead_id, ( $u ? 'Giao cho ' . $u->display_name : 'Bỏ người phụ trách' ) . ( $how ? ' (' . $how . ')' : '' ) );
	if ( $u && $u->user_email && false === strpos( $u->user_email, '@sale.hiephoangmt.invalid' ) ) {
		$ref = (int) get_post_meta( $lead_id, 'hh_property_id', true );
		wp_mail(
			$u->user_email,
			'[Khu Sale] Khách mới: ' . get_the_title( $lead_id ) . ' – ' . get_post_meta( $lead_id, 'hh_phone', true ),
			"Bạn được giao khách mới:\n\nHọ tên: " . get_the_title( $lead_id ) . "\nĐiện thoại: " . get_post_meta( $lead_id, 'hh_phone', true ) . "\nNhu cầu: " . get_post_meta( $lead_id, 'hh_need', true ) . ( $ref ? "\nQuan tâm: " . get_the_title( $ref ) : '' ) . "\n\nCập nhật trạng thái chăm sóc tại: " . hh_sale_url( 'khach-hang' )
		);
	}
}

function hh_sale_log( $lead_id, $text ) {
	$log   = (array) get_post_meta( $lead_id, 'hh_sale_log', true );
	$log   = array_values( array_filter( $log ) );
	$log[] = array( time(), get_current_user_id(), $text );
	update_post_meta( $lead_id, 'hh_sale_log', array_slice( $log, -60 ) );
}

function hh_sale_leads_query( $owner = 0, $limit = 300, $status = '' ) {
	$args = array(
		'post_type'   => 'khach-hang',
		'post_status' => array( 'private', 'publish', 'draft', 'pending' ),
		'numberposts' => $limit,
		'orderby'     => 'date',
		'order'       => 'DESC',
		'meta_query'  => array(), // phpcs:ignore WordPress.DB.SlowDBQuery
	);
	if ( $owner ) {
		$args['meta_query'][] = array( 'key' => 'hh_sale_owner', 'value' => (int) $owner );
	}
	if ( $status ) {
		$args['meta_query'][] = array( 'key' => 'hh_lead_status', 'value' => $status );
	}
	$args['meta_query'][] = array( 'key' => 'hh_spam', 'compare' => 'NOT EXISTS' );
	return get_posts( $args );
}

function hh_sale_view_leads() {
	$admin  = hh_sale_is_admin();
	$owner  = $admin ? absint( $_GET['sale'] ?? 0 ) : get_current_user_id(); // phpcs:ignore WordPress.Security.NonceVerification
	$status = sanitize_key( $_GET['tt'] ?? '' ); // phpcs:ignore WordPress.Security.NonceVerification
	$leads  = hh_sale_leads_query( $owner, 300, isset( HH_LEAD_STATUSES[ $status ] ) ? $status : '' );
	$sales  = get_users( array( 'role' => HH_SALE_ROLE, 'orderby' => 'display_name' ) );
	echo '<h1>' . ( $admin ? 'Khách hàng' : 'Khách của tôi' ) . '</h1>';
	if ( isset( $_GET['ok'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		echo '<p class="pill g">Đã lưu.</p>';
	}
	echo '<form method="get" style="display:flex;gap:8px;flex-wrap:wrap;margin:8px 0">';
	if ( $admin ) {
		echo '<select name="sale"><option value="0">Tất cả sale</option>';
		foreach ( $sales as $s ) {
			printf( '<option value="%d"%s>%s</option>', (int) $s->ID, selected( $owner, $s->ID, false ), esc_html( $s->display_name ) );
		}
		echo '</select>';
	}
	echo '<select name="tt"><option value="">Mọi trạng thái</option>';
	foreach ( HH_LEAD_STATUSES as $k => $l ) {
		printf( '<option value="%s"%s>%s</option>', esc_attr( $k ), selected( $status, $k, false ), esc_html( $l ) );
	}
	echo '</select><button class="btn s g">Lọc</button></form>';
	if ( ! $leads ) {
		echo '<div class="box"><p class="note">Chưa có khách.</p></div>';
		return;
	}
	foreach ( $leads as $l ) {
		$phone = (string) get_post_meta( $l->ID, 'hh_phone', true );
		$ref   = (int) get_post_meta( $l->ID, 'hh_property_id', true );
		$st    = get_post_meta( $l->ID, 'hh_lead_status', true ) ?: 'moi';
		$own   = (int) get_post_meta( $l->ID, 'hh_sale_owner', true );
		$ou    = $own ? get_userdata( $own ) : null;
		$zalo  = 'https://zalo.me/' . preg_replace( '/^\+?84/', '0', preg_replace( '/[^0-9+]/', '', $phone ) );
		echo '<div class="box lead-row">';
		printf(
			'<p style="margin:0 0 6px"><b style="font-size:17px">%s</b> · <a href="tel:%s">%s</a> · <a href="%s" target="_blank" rel="noopener">Zalo</a> <span class="pill%s">%s</span></p>',
			esc_html( $l->post_title ),
			esc_attr( $phone ),
			esc_html( $phone ),
			esc_url( $zalo ),
			'moi' === $st ? ' o' : ( 'chot' === $st ? ' g' : '' ),
			esc_html( HH_LEAD_STATUSES[ $st ] ?? $st )
		);
		printf(
			'<p class="note" style="margin:0 0 8px">%s%s · %s%s</p>',
			esc_html( (string) get_post_meta( $l->ID, 'hh_need', true ) ),
			$ref ? ' · <a href="' . esc_url( hh_sale_url( 'du-an/' . get_post_field( 'post_name', $ref ) ) ) . '">' . esc_html( get_the_title( $ref ) ) . '</a>' : '',
			esc_html( get_the_date( 'd/m/Y H:i', $l ) ),
			$admin ? ' · Phụ trách: <b>' . esc_html( $ou ? $ou->display_name : 'chưa giao' ) . '</b>' : ''
		);
		if ( trim( $l->post_content ) ) {
			echo '<p style="margin:0 0 8px;font-size:14px;background:#f7f9fc;padding:8px 10px;border-radius:8px">' . nl2br( esc_html( wp_strip_all_tags( $l->post_content ) ) ) . '</p>';
		}
		echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
		wp_nonce_field( 'hh_sale_lead_' . $l->ID, 'n' );
		echo '<input type="hidden" name="action" value="hh_sale_lead"><input type="hidden" name="lead" value="' . (int) $l->ID . '"><select name="status">';
		foreach ( HH_LEAD_STATUSES as $k => $lb ) {
			printf( '<option value="%s"%s>%s</option>', esc_attr( $k ), selected( $st, $k, false ), esc_html( $lb ) );
		}
		echo '</select>';
		if ( $admin ) {
			echo '<select name="owner"><option value="0">— Chưa giao —</option>';
			foreach ( $sales as $s ) {
				printf( '<option value="%d"%s>%s</option>', (int) $s->ID, selected( $own, $s->ID, false ), esc_html( $s->display_name ) );
			}
			echo '</select>';
		}
		echo '<textarea name="note" placeholder="Ghi chú chăm sóc (đã gọi, khách hẹn xem nhà, ngân sách…)"></textarea><button class="btn s">Lưu</button></form>';
		$log = array_slice( array_reverse( array_values( array_filter( (array) get_post_meta( $l->ID, 'hh_sale_log', true ) ) ) ), 0, 5 );
		if ( $log ) {
			echo '<div class="log">';
			foreach ( $log as $r ) {
				$u = get_userdata( (int) ( $r[1] ?? 0 ) );
				printf( '<p>%s · %s: %s</p>', esc_html( wp_date( 'd/m H:i', (int) $r[0] ) ), esc_html( $u ? $u->display_name : 'Hệ thống' ), esc_html( (string) ( $r[2] ?? '' ) ) );
			}
			echo '</div>';
		}
		echo '</div>';
	}
}

add_action(
	'admin_post_hh_sale_lead',
	static function () {
		$id = absint( $_POST['lead'] ?? 0 );
		if ( ! $id || ! hh_sale_can() || ! isset( $_POST['n'] ) || ! wp_verify_nonce( sanitize_key( $_POST['n'] ), 'hh_sale_lead_' . $id ) || 'khach-hang' !== get_post_type( $id ) ) {
			wp_die( 'Không có quyền.' );
		}
		$admin = hh_sale_is_admin();
		if ( ! $admin && (int) get_post_meta( $id, 'hh_sale_owner', true ) !== get_current_user_id() ) {
			wp_die( 'Khách này không do bạn phụ trách.' );
		}
		$st  = sanitize_key( $_POST['status'] ?? '' );
		$old = get_post_meta( $id, 'hh_lead_status', true ) ?: 'moi';
		if ( isset( HH_LEAD_STATUSES[ $st ] ) && $st !== $old ) {
			update_post_meta( $id, 'hh_lead_status', $st );
			hh_sale_log( $id, 'Trạng thái: ' . HH_LEAD_STATUSES[ $st ] );
		}
		$note = sanitize_textarea_field( wp_unslash( $_POST['note'] ?? '' ) );
		if ( '' !== trim( $note ) ) {
			hh_sale_log( $id, mb_substr( $note, 0, 1000 ) );
		}
		if ( ! get_post_meta( $id, 'hh_sale_first_touch', true ) && (int) get_post_meta( $id, 'hh_sale_owner', true ) === get_current_user_id() && ( '' !== trim( $note ) || $st !== $old ) ) {
			update_post_meta( $id, 'hh_sale_first_touch', time() ); // Lần đầu sale xử lý khách (tính thời gian phản hồi).
		}
		if ( 'chot' === $st && 'chot' !== $old ) {
			update_post_meta( $id, 'hh_sale_won_at', time() );
		}
		if ( $admin && isset( $_POST['owner'] ) ) {
			$o = absint( $_POST['owner'] );
			if ( $o !== (int) get_post_meta( $id, 'hh_sale_owner', true ) ) {
				$o ? hh_sale_assign( $id, $o, 'Quản trị giao' ) : ( delete_post_meta( $id, 'hh_sale_owner' ) && hh_sale_log( $id, 'Bỏ người phụ trách' ) );
			}
		}
		wp_safe_redirect( add_query_arg( 'ok', 1, wp_get_referer() ?: hh_sale_url( 'khach-hang' ) ) );
		exit;
	}
);

/* Quản trị → Khách hàng: cột + khung "Sale phụ trách". */
add_filter( 'manage_khach-hang_posts_columns', static fn( $c ) => $c + array( 'hh_sale_owner' => 'Sale phụ trách' ), 20 );
add_action(
	'manage_khach-hang_posts_custom_column',
	static function ( $col, $id ) {
		if ( 'hh_sale_owner' === $col ) {
			$u = get_userdata( (int) get_post_meta( $id, 'hh_sale_owner', true ) );
			echo esc_html( $u ? $u->display_name : '—' );
		}
	},
	10,
	2
);
add_action(
	'add_meta_boxes_khach-hang',
	static function () {
		add_meta_box(
			'hh_sale_owner_box',
			'Sale phụ trách',
			static function ( $post ) {
				wp_nonce_field( 'hh_sale_owner', 'hh_sale_owner_nonce' );
				$cur = (int) get_post_meta( $post->ID, 'hh_sale_owner', true );
				echo '<select name="hh_sale_owner" style="width:100%"><option value="0">— Chưa giao —</option>';
				foreach ( get_users( array( 'role' => HH_SALE_ROLE, 'orderby' => 'display_name' ) ) as $s ) {
					printf( '<option value="%d"%s>%s%s</option>', (int) $s->ID, selected( $cur, $s->ID, false ), esc_html( $s->display_name ), get_user_meta( $s->ID, 'hh_sale_locked', true ) ? ' (đã khóa)' : '' );
				}
				echo '</select>';
				$log = array_slice( array_reverse( array_values( array_filter( (array) get_post_meta( $post->ID, 'hh_sale_log', true ) ) ) ), 0, 15 );
				foreach ( $log as $r ) {
					$u = get_userdata( (int) ( $r[1] ?? 0 ) );
					printf( '<p style="font-size:12px;margin:6px 0 0">%s · %s: %s</p>', esc_html( wp_date( 'd/m H:i', (int) $r[0] ) ), esc_html( $u ? $u->display_name : 'Hệ thống' ), esc_html( (string) ( $r[2] ?? '' ) ) );
				}
			},
			'khach-hang',
			'side',
			'high'
		);
	}
);
add_action(
	'save_post_khach-hang',
	static function ( $post_id ) {
		if ( ! isset( $_POST['hh_sale_owner_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['hh_sale_owner_nonce'] ), 'hh_sale_owner' ) || ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		$o = absint( $_POST['hh_sale_owner'] ?? 0 );
		if ( $o ) {
			hh_sale_assign( $post_id, $o, 'Quản trị giao' );
		} elseif ( get_post_meta( $post_id, 'hh_sale_owner', true ) ) {
			delete_post_meta( $post_id, 'hh_sale_owner' );
			hh_sale_log( $post_id, 'Bỏ người phụ trách' );
		}
	},
	20
);

/* =========================================================================
 * Quản trị → Khu Sale: tài khoản, cài đặt
 * ====================================================================== */

add_action(
	'admin_menu',
	static function () {
		add_menu_page( 'Khu Sale', 'Khu Sale', 'manage_options', 'hh-khu-sale', 'hh_sale_admin_page', 'dashicons-businessperson', 7 );
		add_submenu_page( 'hh-khu-sale', 'Tài khoản sale', 'Tài khoản sale', 'manage_options', 'hh-khu-sale', 'hh_sale_admin_page' );
	}
);

/**
 * Một dòng danh sách sale dán vào: chấp nhận "Họ tên | SĐT | email", dòng copy từ Excel / Google Sheets (cách nhau bằng Tab),
 * dấu phẩy, chấm phẩy, gạch ngang, hoặc chỉ "Họ tên 0905 111 222 email" như tin nhắn Zalo. Trả về [tên, sđt, email] hoặc null.
 */
function hh_sale_parse_line( $line ) {
	$line = trim( preg_replace( '/^\s*(\d{1,3}[.)]\s+|[-•*+]\s+)/u', '', (string) $line ) ); // bỏ số thứ tự "1." / gạch đầu dòng
	if ( '' === $line ) {
		return null;
	}
	$email = '';
	if ( preg_match( '/[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}/', $line, $m ) ) {
		$email = $m[0];
		$line  = str_replace( $m[0], ' ', $line );
	}
	if ( ! preg_match( '/(\+?84|0)[\d .\-]{8,13}\d/', $line, $m ) ) {
		return null;
	}
	$phone = trim( $m[0] );
	$name  = trim( preg_replace( '/[|\t,;:–—\-]+/u', ' ', str_replace( $m[0], ' ', $line ) ) );
	$name  = trim( preg_replace( '/\s+/u', ' ', $name ) );
	if ( '' === $name || preg_match( '/^(h[oọ] t[eê]n|t[eê]n|name)$/iu', $name ) ) {
		return null;
	}
	return array( $name, $phone, $email );
}

/** Số điện thoại → tên đăng nhập (chỉ chữ số, đầu 0). */
function hh_sale_phone_login( $phone ) {
	$d = preg_replace( '/\D/', '', (string) $phone );
	if ( 0 === strpos( $d, '84' ) && strlen( $d ) >= 11 ) {
		$d = '0' . substr( $d, 2 );
	}
	return $d;
}

function hh_sale_new_pass() {
	$chars = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789';
	$p     = '';
	for ( $i = 0; $i < 10; $i++ ) {
		$p .= $chars[ wp_rand( 0, strlen( $chars ) - 1 ) ];
	}
	return $p;
}

add_action(
	'admin_post_hh_sale_admin',
	static function () {
		if ( ! current_user_can( 'manage_options' ) || ! isset( $_POST['n'] ) || ! wp_verify_nonce( sanitize_key( $_POST['n'] ), 'hh_sale_admin' ) ) {
			wp_die( 'Không có quyền.' );
		}
		$do   = sanitize_key( $_POST['do'] ?? '' );
		$out  = array();
		$msgs = array();
		if ( 'create' === $do ) {
			foreach ( preg_split( '/\R/u', (string) wp_unslash( $_POST['list'] ?? '' ) ) as $line ) {
				$p = hh_sale_parse_line( $line );
				if ( ! $p ) {
					continue;
				}
				$name  = sanitize_text_field( $p[0] );
				$login = hh_sale_phone_login( $p[1] );
				if ( strlen( $login ) < 9 ) {
					$msgs[] = 'Bỏ qua "' . $name . '": số điện thoại không hợp lệ.';
					continue;
				}
				if ( username_exists( $login ) ) {
					$msgs[] = 'Bỏ qua "' . $name . '": số ' . $login . ' đã có tài khoản.';
					continue;
				}
				$email = isset( $p[2] ) && is_email( $p[2] ) ? sanitize_email( $p[2] ) : $login . '@sale.hiephoangmt.invalid';
				if ( email_exists( $email ) ) {
					$msgs[] = 'Bỏ qua "' . $name . '": email ' . $email . ' đã dùng cho tài khoản khác.';
					continue;
				}
				$pass = hh_sale_new_pass();
				$uid  = wp_insert_user(
					array(
						'user_login'   => $login,
						'user_pass'    => $pass,
						'user_email'   => $email,
						'display_name' => $name,
						'first_name'   => $name,
						'nickname'     => $name,
						'role'         => HH_SALE_ROLE,
					)
				);
				if ( is_wp_error( $uid ) ) {
					$msgs[] = 'Lỗi tạo "' . $name . '": ' . $uid->get_error_message();
					continue;
				}
				update_user_meta( $uid, 'hh_sale_phone', sanitize_text_field( $p[1] ) );
				$out[] = array( $name, $login, $pass );
			}
		} else {
			$uid = absint( $_POST['uid'] ?? 0 );
			$u   = $uid ? get_userdata( $uid ) : null;
			if ( $u && in_array( HH_SALE_ROLE, (array) $u->roles, true ) ) {
				if ( 'lock' === $do ) {
					update_user_meta( $uid, 'hh_sale_locked', 1 );
					WP_Session_Tokens::get_instance( $uid )->destroy_all();
					$n = 0;
					foreach ( hh_sale_leads_query( $uid, -1 ) as $l ) {
						delete_post_meta( $l->ID, 'hh_sale_owner' );
						hh_sale_log( $l->ID, 'Bỏ người phụ trách (khóa tài khoản ' . $u->display_name . ')' );
						++$n;
					}
					$msgs[] = 'Đã khóa ' . $u->display_name . ' và đăng xuất khỏi mọi máy. ' . $n . ' khách được trả về "chưa giao" để giao người khác.';
				} elseif ( 'unlock' === $do ) {
					delete_user_meta( $uid, 'hh_sale_locked' );
					$msgs[] = 'Đã mở khóa ' . $u->display_name . '.';
				} elseif ( 'pause' === $do ) {
					get_user_meta( $uid, 'hh_sale_paused', true ) ? delete_user_meta( $uid, 'hh_sale_paused' ) : update_user_meta( $uid, 'hh_sale_paused', 1 );
					$msgs[] = $u->display_name . ( get_user_meta( $uid, 'hh_sale_paused', true ) ? ': tạm ngưng nhận khách tự chia.' : ': nhận khách tự chia trở lại.' );
				} elseif ( 'reset' === $do ) {
					$pass = hh_sale_new_pass();
					wp_set_password( $pass, $uid );
					$out[] = array( $u->display_name, $u->user_login, $pass );
				}
			}
		}
		if ( 'settings' === $do ) {
			update_option( 'hh_sale_autoassign', empty( $_POST['auto'] ) ? '0' : '1', false );
			$msgs[] = 'Đã lưu cài đặt.';
		}
		set_transient( 'hh_sale_admin_msg_' . get_current_user_id(), array( $msgs, $out ), 10 * MINUTE_IN_SECONDS );
		wp_safe_redirect( admin_url( 'admin.php?page=hh-khu-sale' ) );
		exit;
	}
);

function hh_sale_admin_page() {
	$flash = get_transient( 'hh_sale_admin_msg_' . get_current_user_id() );
	delete_transient( 'hh_sale_admin_msg_' . get_current_user_id() );
	$users = get_users( array( 'role' => HH_SALE_ROLE, 'orderby' => 'display_name' ) );
	$form  = static function ( $do, $uid, $label, $cls = 'button' ) {
		return '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '" style="display:inline">' . wp_nonce_field( 'hh_sale_admin', 'n', true, false ) . '<input type="hidden" name="action" value="hh_sale_admin"><input type="hidden" name="do" value="' . esc_attr( $do ) . '"><input type="hidden" name="uid" value="' . (int) $uid . '"><button class="' . esc_attr( $cls ) . '"' . ( 'lock' === $do ? ' onclick="return confirm(\'Khóa tài khoản này? Sale bị đăng xuất ngay và khách đang giữ được trả về chưa giao.\')"' : '' ) . '>' . esc_html( $label ) . '</button></form> ';
	};
	echo '<div class="wrap"><h1>Khu Sale – tài khoản</h1>';
	echo '<p>Trang dành cho sale: <a href="' . esc_url( hh_sale_url() ) . '" target="_blank"><b>' . esc_html( hh_sale_url() ) . '</b></a> – sale đăng nhập bằng số điện thoại + mật khẩu. Tài liệu kín: <a href="' . esc_url( admin_url( 'edit.php?post_type=' . HH_SALE_DOC_TYPE ) ) . '">Tài liệu sale</a>. Hướng dẫn riêng cho từng dự án: khung "Dành cho sale (nội bộ)" trong trang sửa dự án.</p>';
	if ( $flash ) {
		foreach ( (array) $flash[0] as $m ) {
			echo '<div class="notice notice-info"><p>' . esc_html( $m ) . '</p></div>';
		}
		if ( ! empty( $flash[1] ) ) {
			$txt = '';
			echo '<div class="notice notice-success"><p><b>Tài khoản / mật khẩu – chỉ hiện 1 lần, hãy gửi riêng cho từng sale qua Zalo:</b></p><table class="widefat striped" style="max-width:860px"><tr><th>Họ tên</th><th>Tên đăng nhập</th><th>Mật khẩu</th><th></th></tr>';
			echo '<style>.hh-cp{cursor:pointer}.hh-cp.ok{background:#16a34a!important;border-color:#16a34a!important;color:#fff!important}</style>';
			foreach ( $flash[1] as $r ) {
				$one  = 'Chào ' . $r[0] . ", đây là tài khoản Khu Sale Hoàng Hiệp của bạn:\n- Trang: " . hh_sale_url() . "\n- Tên đăng nhập: " . $r[1] . "\n- Mật khẩu: " . $r[2] . "\nĐăng nhập xong vào Tổng quan bấm nối Telegram để nhận báo khách mới. Không chia sẻ tài khoản cho người khác.";
				$txt .= $one . "\n\n";
				printf( '<tr><td>%s</td><td><code>%s</code></td><td><code>%s</code></td><td><button type="button" class="button hh-cp" data-t="%s">Sao chép tin nhắn</button></td></tr>', esc_html( $r[0] ), esc_html( $r[1] ), esc_html( $r[2] ), esc_attr( $one ) );
			}
			echo '</table><p><button type="button" class="button button-primary hh-cp" data-t="' . esc_attr( trim( $txt ) ) . '">Sao chép tất cả</button> <span class="description">Bấm "Sao chép tin nhắn" rồi dán vào Zalo của từng sale.</span></p><textarea readonly rows="' . (int) min( 14, count( $flash[1] ) * 6 + 1 ) . '" style="width:100%;max-width:720px" onclick="this.select()">' . esc_textarea( trim( $txt ) ) . '</textarea></div>';
			echo "<script>document.querySelectorAll('.hh-cp').forEach(function(b){b.addEventListener('click',function(){var t=b.dataset.t,l=b.textContent,done=function(){b.classList.add('ok');b.textContent='Đã sao chép ✓';setTimeout(function(){b.classList.remove('ok');b.textContent=l},1800)};if(navigator.clipboard&&window.isSecureContext){navigator.clipboard.writeText(t).then(done)}else{var a=document.createElement('textarea');a.value=t;document.body.appendChild(a);a.select();document.execCommand('copy');a.remove();done()}})})</script>";
		}
	}
	$myp = (string) get_user_meta( get_current_user_id(), 'hh_login_phone', true );
	echo '<div style="background:#fff;border:1px solid #dcdcde;border-left:4px solid #f2551d;padding:10px 14px;max-width:860px;margin:12px 0"><form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">' . wp_nonce_field( 'hh_sale_myphone', 'n', true, false ) . '<input type="hidden" name="action" value="hh_sale_myphone"><b>Tài khoản của anh vào khu sale:</b> đăng nhập bằng số <input type="text" name="phone" value="' . esc_attr( $myp ) . '" placeholder="0904567009" style="width:140px"> + mật khẩu quản trị hiện tại (hoặc tên đăng nhập <code>' . esc_html( wp_get_current_user()->user_login ) . '</code>). <button class="button">Lưu</button></form></div>';
	// Danh sách.
	echo '<h2>Đang có ' . count( $users ) . ' tài khoản</h2><table class="widefat striped"><thead><tr><th>Họ tên</th><th>Đăng nhập</th><th>Khách đang giữ</th><th>Đăng nhập gần nhất</th><th>Báo Telegram</th><th>Trạng thái</th><th></th></tr></thead><tbody>';
	foreach ( $users as $u ) {
		$locked = (bool) get_user_meta( $u->ID, 'hh_sale_locked', true );
		$paused = (bool) get_user_meta( $u->ID, 'hh_sale_paused', true );
		$last   = (int) get_user_meta( $u->ID, 'hh_sale_last_login', true );
		printf(
			'<tr><td><b>%s</b></td><td><code>%s</code></td><td><a href="%s" target="_blank">%d</a></td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>',
			esc_html( $u->display_name ),
			esc_html( $u->user_login ),
			esc_url( add_query_arg( 'sale', $u->ID, hh_sale_url( 'khach-hang' ) ) ),
			count( hh_sale_leads_query( $u->ID, -1 ) ),
			$last ? esc_html( wp_date( 'd/m/Y H:i', $last ) ) : 'Chưa',
			get_user_meta( $u->ID, 'hh_sale_tg_chat', true ) ? '✅ Đã nối' : '<span style="color:#8a6d00">Chưa nối</span>',
			$locked ? '<span style="color:#b42318">Đã khóa</span>' : ( $paused ? 'Tạm ngưng nhận khách' : '<span style="color:#167a3e">Hoạt động</span>' ),
			( $locked ? $form( 'unlock', $u->ID, 'Mở khóa' ) : $form( 'lock', $u->ID, 'Khóa' ) . $form( 'pause', $u->ID, $paused ? 'Nhận khách lại' : 'Tạm ngưng nhận khách' ) ) . $form( 'reset', $u->ID, 'Cấp lại mật khẩu' ) // phpcs:ignore
		);
	}
	echo '</tbody></table>';
	// Tạo hàng loạt.
	echo '<h2 style="margin-top:28px">Tạo tài khoản</h2><form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
	wp_nonce_field( 'hh_sale_admin', 'n' );
	echo '<input type="hidden" name="action" value="hh_sale_admin"><input type="hidden" name="do" value="create"><p>Mỗi dòng 1 người. Dán thẳng được: 2–3 cột <b>Họ tên – Số điện thoại – Email</b> copy từ Excel / Google Sheets, hoặc danh sách gõ trong Zalo kiểu <code>Nguyễn Văn A 0905 111 222</code>, <code>1. Trần Thị B - 0935333444</code>, <code>Lê C | 0914555666 | c@gmail.com</code> (dòng tiêu đề, số thứ tự tự bỏ qua). Tên đăng nhập là số điện thoại; mật khẩu tạo ngẫu nhiên, hiện 1 lần sau khi bấm Tạo. Có email thì sale nhận thư báo khi được giao khách.</p><textarea name="list" rows="10" style="width:100%;max-width:720px" placeholder="Nguyễn Văn A | 0905 111 222&#10;Trần Thị B | 0935 333 444 | b@gmail.com"></textarea><p><button class="button button-primary">Tạo tài khoản</button></p></form>';
	// Cài đặt.
	$auto = '1' === (string) get_option( 'hh_sale_autoassign', '0' );
	echo '<h2 style="margin-top:28px">Chia khách</h2><form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
	wp_nonce_field( 'hh_sale_admin', 'n' );
	echo '<input type="hidden" name="action" value="hh_sale_admin"><input type="hidden" name="do" value="settings"><label><input type="checkbox" name="auto" value="1"' . checked( $auto, true, false ) . '> Tự chia khách mới từ web lần lượt cho các sale đang hoạt động (bỏ qua người bị khóa / tạm ngưng)</label><p class="description">Tắt: khách mới vẫn báo về anh như cũ, anh tự giao trong trang khách hàng hoặc ở <a href="' . esc_url( hh_sale_url( 'khach-hang' ) ) . '" target="_blank">Khu Sale → Khách hàng</a>. Mỗi sale chỉ thấy khách của mình.</p><p><button class="button">Lưu</button></p></form></div>';
}

/* =========================================================================
 * Báo khách mới cho sale qua Telegram (dùng chung bot ở Khách hàng → Thông báo Telegram)
 * Sale bấm link t.me/<bot>?start=<mã riêng> → Start → quay lại trang bấm "Tôi đã bấm Start" là nối xong.
 * ====================================================================== */

function hh_sale_tg_api( $method, $args = array() ) {
	$token = function_exists( 'hh_tg_opt' ) ? hh_tg_opt( 'token' ) : '';
	if ( '' === $token ) {
		return null;
	}
	$res = wp_remote_post( 'https://api.telegram.org/bot' . preg_replace( '/[^A-Za-z0-9:_-]/', '', $token ) . '/' . $method, array( 'timeout' => 12, 'body' => $args ) );
	return is_wp_error( $res ) ? null : json_decode( (string) wp_remote_retrieve_body( $res ), true );
}

function hh_sale_tg_bot() {
	$name = get_transient( 'hh_sale_tg_bot' );
	if ( false === $name ) {
		$d    = hh_sale_tg_api( 'getMe' );
		$name = (string) ( $d['result']['username'] ?? '' );
		set_transient( 'hh_sale_tg_bot', $name, DAY_IN_SECONDS );
	}
	return $name;
}

function hh_sale_tg_send( $user_id, $text ) {
	$chat = (string) get_user_meta( $user_id, 'hh_sale_tg_chat', true );
	if ( '' === $chat ) {
		return false;
	}
	$d = hh_sale_tg_api( 'sendMessage', array( 'chat_id' => $chat, 'text' => mb_substr( $text, 0, 4000 ), 'disable_web_page_preview' => 'true' ) );
	return ! empty( $d['ok'] );
}

/** Gửi Telegram khi sale được giao khách (chạy sau hh_sale_assign). */
add_action(
	'updated_post_meta',
	'hh_sale_tg_on_assign',
	10,
	4
);
add_action(
	'added_post_meta',
	'hh_sale_tg_on_assign',
	10,
	4
);
function hh_sale_tg_on_assign( $mid, $lead_id, $key, $value ) {
	if ( 'hh_sale_owner' !== $key || ! $value || 'khach-hang' !== get_post_type( $lead_id ) ) {
		return;
	}
	$ref  = (int) get_post_meta( $lead_id, 'hh_property_id', true );
	$msg  = (string) get_post_field( 'post_content', $lead_id );
	$text = "🔔 Khách mới được giao cho bạn\n\n👤 " . get_the_title( $lead_id ) . "\n📞 " . get_post_meta( $lead_id, 'hh_phone', true )
		. "\nNhu cầu: " . get_post_meta( $lead_id, 'hh_need', true ) . ( $ref ? "\nQuan tâm: " . get_the_title( $ref ) : '' )
		. ( trim( $msg ) ? "\nLời nhắn: " . mb_substr( wp_strip_all_tags( $msg ), 0, 400 ) : '' )
		. "\n\nGọi khách sớm và cập nhật trạng thái tại: " . hh_sale_url( 'khach-hang' );
	hh_sale_tg_send( (int) $value, $text );
}

function hh_sale_tg_box() {
	$uid  = get_current_user_id();
	$chat = (string) get_user_meta( $uid, 'hh_sale_tg_chat', true );
	$bot  = hh_sale_tg_bot();
	echo '<div class="box"><h2>Báo khách mới qua Telegram</h2>';
	if ( isset( $_GET['tg'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		$m = array( 'ok' => 'Đã kết nối Telegram – từ giờ có khách mới được giao, điện thoại sẽ báo ngay.', 'no' => 'Chưa thấy bạn bấm Start trong Telegram. Bấm nút mở Telegram, nhấn Start rồi thử lại.', 'off' => 'Đã ngắt Telegram.', 'test' => 'Đã gửi tin thử – kiểm tra Telegram.' );
		echo '<p class="pill g">' . esc_html( $m[ sanitize_key( $_GET['tg'] ) ] ?? '' ) . '</p>'; // phpcs:ignore WordPress.Security.NonceVerification
	}
	$form = static fn( $do, $label, $cls = 'btn s' ) => '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '" style="display:inline">' . wp_nonce_field( 'hh_sale_tg', 'n', true, false ) . '<input type="hidden" name="action" value="hh_sale_tg"><input type="hidden" name="do" value="' . esc_attr( $do ) . '"><button class="' . esc_attr( $cls ) . '">' . esc_html( $label ) . '</button></form> ';
	if ( '' === $bot ) {
		echo '<p class="note">Chưa bật bot Telegram của web (anh Hiệp cài ở Quản trị → Khách hàng → Thông báo Telegram). Khách mới vẫn được báo qua email nếu tài khoản có email.</p></div>';
		return;
	}
	if ( $chat ) {
		echo '<p>✅ Đã kết nối – có khách mới được giao, Telegram trên điện thoại sẽ báo ngay.</p>' . $form( 'test', 'Gửi tin thử' ) . $form( 'off', 'Ngắt kết nối', 'btn s g' ); // phpcs:ignore
	} else {
		$code = (string) get_user_meta( $uid, 'hh_sale_tg_code', true );
		if ( '' === $code ) {
			$code = 's' . $uid . wp_generate_password( 10, false );
			update_user_meta( $uid, 'hh_sale_tg_code', $code );
		}
		echo '<p>Làm 1 lần: (1) bấm nút dưới để mở Telegram → nhấn <b>Start</b>; (2) quay lại đây bấm "Tôi đã bấm Start".</p>';
		echo '<a class="btn s" href="' . esc_url( 'https://t.me/' . $bot . '?start=' . $code ) . '" target="_blank" rel="noopener">Mở Telegram</a> ' . $form( 'check', 'Tôi đã bấm Start', 'btn s g' ); // phpcs:ignore
	}
	echo '</div>';
}

add_action(
	'admin_post_hh_sale_tg',
	static function () {
		if ( ! hh_sale_can() || ! isset( $_POST['n'] ) || ! wp_verify_nonce( sanitize_key( $_POST['n'] ), 'hh_sale_tg' ) ) {
			wp_die( 'Không có quyền.' );
		}
		$uid = get_current_user_id();
		$do  = sanitize_key( $_POST['do'] ?? '' );
		$r   = 'no';
		if ( 'check' === $do ) {
			$code = (string) get_user_meta( $uid, 'hh_sale_tg_code', true );
			$d    = hh_sale_tg_api( 'getUpdates', array( 'allowed_updates' => '["message"]' ) );
			foreach ( array_reverse( (array) ( $d['result'] ?? array() ) ) as $up ) {
				$txt = (string) ( $up['message']['text'] ?? '' );
				if ( $code && '/start ' . $code === trim( $txt ) ) {
					update_user_meta( $uid, 'hh_sale_tg_chat', (string) $up['message']['chat']['id'] );
					hh_sale_tg_send( $uid, 'Xin chào ' . wp_get_current_user()->display_name . '! Bạn đã kết nối Khu Sale Hoàng Hiệp – có khách mới được giao, bot sẽ báo ở đây.' );
					$r = 'ok';
					break;
				}
			}
		} elseif ( 'test' === $do ) {
			hh_sale_tg_send( $uid, 'Tin thử từ Khu Sale Hoàng Hiệp ✅' );
			$r = 'test';
		} elseif ( 'off' === $do ) {
			delete_user_meta( $uid, 'hh_sale_tg_chat' );
			$r = 'off';
		}
		wp_safe_redirect( add_query_arg( 'tg', $r, hh_sale_url() ) . '#tg' );
		exit;
	}
);


/* =========================================================================
 * Báo cáo: theo sale, theo ngày, theo dự án, lượt tải tài liệu
 * ====================================================================== */

function hh_sale_fmt_dur( $sec ) {
	if ( $sec <= 0 ) {
		return '—';
	}
	if ( $sec < HOUR_IN_SECONDS ) {
		return max( 1, (int) round( $sec / 60 ) ) . ' phút';
	}
	if ( $sec < DAY_IN_SECONDS ) {
		return round( $sec / HOUR_IN_SECONDS, 1 ) . ' giờ';
	}
	return round( $sec / DAY_IN_SECONDS, 1 ) . ' ngày';
}

function hh_sale_view_report() {
	$admin  = hh_sale_is_admin();
	$period = sanitize_key( $_GET['ky'] ?? '30' ); // phpcs:ignore WordPress.Security.NonceVerification
	$opts   = array( '7' => '7 ngày', '30' => '30 ngày', 'thang' => 'Tháng này', '90' => '90 ngày', 'all' => 'Tất cả' );
	$period = isset( $opts[ $period ] ) ? $period : '30';
	$now    = time();
	$from   = 'all' === $period ? 0 : ( 'thang' === $period ? strtotime( wp_date( 'Y-m-01 00:00:00' ) . ' ' . wp_timezone_string() ) : $now - (int) $period * DAY_IN_SECONDS );
	$args   = array(
		'post_type'   => 'khach-hang',
		'post_status' => array( 'private', 'publish', 'draft', 'pending' ),
		'numberposts' => -1,
		'meta_query'  => array( array( 'key' => 'hh_spam', 'compare' => 'NOT EXISTS' ) ), // phpcs:ignore WordPress.DB.SlowDBQuery
	);
	if ( $from ) {
		$args['date_query'] = array( array( 'after' => gmdate( 'Y-m-d H:i:s', $from ), 'column' => 'post_date_gmt' ) );
	}
	if ( ! $admin ) {
		$args['meta_query'][] = array( 'key' => 'hh_sale_owner', 'value' => get_current_user_id() );
	}
	$leads = get_posts( $args );

	echo '<h1>Báo cáo</h1><form method="get" style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;margin:6px 0 4px"><select name="ky" onchange="this.form.submit()">';
	foreach ( $opts as $k => $l ) {
		printf( '<option value="%s"%s>%s</option>', esc_attr( $k ), selected( $period, $k, false ), esc_html( $l ) );
	}
	echo '</select><span class="note">' . ( $admin ? 'Toàn team' : 'Số liệu của bạn' ) . ' · khách tính theo ngày vào hệ thống</span></form>';

	// Tổng hợp theo sale.
	$rows  = array();
	$tot   = array( 'n' => 0, 'moi' => 0, 'touch' => 0, 'chot' => 0, 'huy' => 0, 'late' => 0, 'rt' => array() );
	$days  = array();
	$projs = array();
	foreach ( $leads as $l ) {
		$o  = (int) get_post_meta( $l->ID, 'hh_sale_owner', true );
		$st = get_post_meta( $l->ID, 'hh_lead_status', true ) ?: 'moi';
		$as = (int) get_post_meta( $l->ID, 'hh_sale_assigned_at', true );
		$ft = (int) get_post_meta( $l->ID, 'hh_sale_first_touch', true );
		if ( ! isset( $rows[ $o ] ) ) {
			$rows[ $o ] = array( 'n' => 0, 'moi' => 0, 'touch' => 0, 'chot' => 0, 'huy' => 0, 'late' => 0, 'rt' => array() );
		}
		foreach ( array( &$rows[ $o ], &$tot ) as &$r ) {
			++$r['n'];
			if ( 'moi' === $st ) {
				++$r['moi'];
				if ( $o && $as && $now - $as > 30 * MINUTE_IN_SECONDS ) {
					++$r['late'];
				}
			} else {
				++$r['touch'];
			}
			if ( 'chot' === $st ) {
				++$r['chot'];
			}
			if ( 'huy' === $st ) {
				++$r['huy'];
			}
			if ( $as && $ft && $ft >= $as ) {
				$r['rt'][] = $ft - $as;
			}
		}
		unset( $r );
		$d          = get_the_date( 'Y-m-d', $l );
		$days[ $d ] = ( $days[ $d ] ?? 0 ) + 1;
		$ref        = (int) get_post_meta( $l->ID, 'hh_property_id', true );
		$key        = $ref ? get_the_title( $ref ) : 'Không rõ dự án';
		if ( ! isset( $projs[ $key ] ) ) {
			$projs[ $key ] = array( 0, 0 );
		}
		++$projs[ $key ][0];
		if ( 'chot' === $st ) {
			++$projs[ $key ][1];
		}
	}
	$avg  = static fn( $a ) => $a ? (int) ( array_sum( $a ) / count( $a ) ) : 0;
	$rate = static fn( $r ) => $r['n'] ? round( 100 * $r['chot'] / $r['n'], 1 ) . '%' : '—';

	echo '<div class="stats" style="margin-top:12px">';
	foreach ( array( array( 'Khách', $tot['n'], '' ), array( 'Chưa gọi', $tot['moi'], 's-moi' ), array( 'Quá 30 phút chưa gọi', $tot['late'], 's-moi' ), array( 'Đã chốt', $tot['chot'], 's-chot' ), array( 'Tỷ lệ chốt', $rate( $tot ), 's-chot' ), array( 'Gọi lại trung bình', hh_sale_fmt_dur( $avg( $tot['rt'] ) ), 's-da-lien-he' ) ) as $c ) {
		printf( '<div class="%s"><b>%s</b><span>%s</span></div>', esc_attr( $c[2] ), esc_html( (string) $c[1] ), esc_html( $c[0] ) );
	}
	echo '</div>';

	// Biểu đồ khách theo ngày (30 ngày gần nhất trong kỳ).
	$span = 'all' === $period ? 30 : min( 31, max( 7, (int) ceil( ( $now - $from ) / DAY_IN_SECONDS ) ) );
	$bars = array();
	for ( $i = $span - 1; $i >= 0; $i-- ) {
		$d          = wp_date( 'Y-m-d', $now - $i * DAY_IN_SECONDS );
		$bars[ $d ] = $days[ $d ] ?? 0;
	}
	$max = max( 1, max( $bars ) );
	echo '<div class="box"><h2>Khách mới theo ngày</h2><div style="display:flex;align-items:flex-end;gap:3px;height:150px;padding-top:10px">';
	foreach ( $bars as $d => $v ) {
		printf( '<div title="%s: %d khách" style="flex:1;min-width:4px;height:%d%%;background:%s;border-radius:4px 4px 0 0;position:relative">%s</div>', esc_attr( wp_date( 'd/m', strtotime( $d ) ) ), (int) $v, max( 2, (int) round( 100 * $v / $max ) ), $v ? 'linear-gradient(var(--o2),var(--o))' : '#e3e8ef', $v ? '<span style="position:absolute;top:-18px;left:50%;transform:translateX(-50%);font-size:11px;color:#5d6b7c">' . (int) $v . '</span>' : '' );
	}
	echo '</div><div style="display:flex;justify-content:space-between;font-size:12px;color:#5d6b7c;margin-top:4px"><span>' . esc_html( wp_date( 'd/m', strtotime( array_key_first( $bars ) ) ) ) . '</span><span>Hôm nay</span></div></div>';

	// Theo sale (quản trị).
	if ( $admin ) {
		$sales = get_users( array( 'role' => HH_SALE_ROLE, 'orderby' => 'display_name' ) );
		$dl    = array();
		foreach ( hh_sale_docs_for() as $doc ) {
			foreach ( (array) get_post_meta( $doc->ID, '_hh_doc_log', true ) as $r ) {
				if ( is_array( $r ) && ( ! $from || (int) $r[0] >= $from ) ) {
					$dl[ (int) $r[1] ] = ( $dl[ (int) $r[1] ] ?? 0 ) + 1;
				}
			}
		}
		echo '<div class="box"><h2>Theo từng sale</h2><div class="scroll"><table><tr><th>Sale</th><th>Khách nhận</th><th>Chưa gọi</th><th>Quá hạn</th><th>Đã xử lý</th><th>Chốt</th><th>Tỷ lệ chốt</th><th>Gọi lại TB</th><th>Tải tài liệu</th><th>Đăng nhập cuối</th></tr>';
		usort( $sales, static fn( $a, $b ) => ( $rows[ $b->ID ]['chot'] ?? 0 ) <=> ( $rows[ $a->ID ]['chot'] ?? 0 ) ?: ( $rows[ $b->ID ]['n'] ?? 0 ) <=> ( $rows[ $a->ID ]['n'] ?? 0 ) );
		foreach ( $sales as $u ) {
			$r    = $rows[ $u->ID ] ?? array( 'n' => 0, 'moi' => 0, 'touch' => 0, 'chot' => 0, 'huy' => 0, 'late' => 0, 'rt' => array() );
			$last = (int) get_user_meta( $u->ID, 'hh_sale_last_login', true );
			printf(
				'<tr><td><a href="%s"><b>%s</b></a>%s</td><td>%d</td><td>%d</td><td>%s</td><td>%d</td><td>%d</td><td>%s</td><td>%s</td><td>%d</td><td>%s</td></tr>',
				esc_url( add_query_arg( 'sale', $u->ID, hh_sale_url( 'khach-hang' ) ) ),
				esc_html( $u->display_name ),
				get_user_meta( $u->ID, 'hh_sale_locked', true ) ? ' <span class="pill">khóa</span>' : '',
				(int) $r['n'],
				(int) $r['moi'],
				$r['late'] ? '<span class="pill o">' . (int) $r['late'] . '</span>' : '0',
				(int) $r['touch'],
				(int) $r['chot'],
				esc_html( $rate( $r ) ),
				esc_html( hh_sale_fmt_dur( $avg( $r['rt'] ) ) ),
				(int) ( $dl[ $u->ID ] ?? 0 ),
				$last ? esc_html( wp_date( 'd/m H:i', $last ) ) : 'Chưa'
			);
		}
		if ( ! empty( $rows[0]['n'] ) ) {
			printf( '<tr><td><b>Chưa giao</b></td><td>%d</td><td>%d</td><td>—</td><td>%d</td><td>%d</td><td>—</td><td>—</td><td>—</td><td></td></tr>', (int) $rows[0]['n'], (int) $rows[0]['moi'], (int) $rows[0]['touch'], (int) $rows[0]['chot'] );
		}
		echo '</table></div><p class="note">Quá hạn: khách ở trạng thái "Mới" hơn 30 phút sau khi giao. Gọi lại TB: từ lúc giao đến lần đầu sale cập nhật trạng thái / ghi chú. Bấm tên sale để xem danh sách khách.</p></div>';
	}

	// Theo dự án.
	if ( $projs ) {
		uasort( $projs, static fn( $a, $b ) => $b[0] <=> $a[0] );
		echo '<div class="box"><h2>Khách theo dự án</h2><div class="scroll"><table><tr><th>Dự án</th><th>Khách</th><th>Chốt</th><th style="width:40%"></th></tr>';
		$pm = max( 1, max( array_column( $projs, 0 ) ) );
		foreach ( array_slice( $projs, 0, 15, true ) as $name => $v ) {
			printf( '<tr><td>%s</td><td>%d</td><td>%d</td><td><div style="height:10px;border-radius:5px;background:linear-gradient(90deg,var(--o),var(--o2));width:%d%%"></div></td></tr>', esc_html( $name ), (int) $v[0], (int) $v[1], max( 3, (int) round( 100 * $v[0] / $pm ) ) );
		}
		echo '</table></div></div>';
	}
}

/* =========================================================================
 * Đăng nhập bằng số điện thoại cho tài khoản quản trị (anh Hiệp 14/11/2026: 0904 567 009)
 * Số lưu ở user meta hh_login_phone; tự gắn số hotline của web cho quản trị viên đầu tiên mở trang quản trị
 * nếu chưa ai dùng số đó. Đổi / bỏ ở Quản trị → Khu Sale.
 * ====================================================================== */

const HH_SALE_OWNER_PHONE = '0904567009';

function hh_sale_user_by_phone( $phone ) {
	$d = hh_sale_phone_login( $phone );
	if ( strlen( $d ) < 9 ) {
		return null;
	}
	$u = get_users( array( 'meta_key' => 'hh_login_phone', 'meta_value' => $d, 'number' => 1 ) ); // phpcs:ignore WordPress.DB.SlowDBQuery
	return $u ? $u[0] : null;
}

add_filter(
	'authenticate',
	static function ( $user, $username, $password ) {
		if ( $user instanceof WP_User || '' === (string) $username || '' === (string) $password ) {
			return $user;
		}
		if ( ! preg_match( '/^\+?[\d .\-]{9,15}$/', trim( (string) $username ) ) || username_exists( $username ) ) {
			return $user;
		}
		$u = hh_sale_user_by_phone( $username );
		return $u ? wp_authenticate_username_password( null, $u->user_login, $password ) : $user;
	},
	15,
	3
);

add_action(
	'admin_init',
	static function () {
		if ( wp_doing_ajax() || ! current_user_can( 'manage_options' ) || get_option( 'hh_owner_phone_set' ) ) {
			return;
		}
		if ( ! hh_sale_user_by_phone( HH_SALE_OWNER_PHONE ) && ! username_exists( HH_SALE_OWNER_PHONE ) ) {
			update_user_meta( get_current_user_id(), 'hh_login_phone', HH_SALE_OWNER_PHONE );
		}
		update_option( 'hh_owner_phone_set', 1, false );
	}
);

add_action(
	'admin_post_hh_sale_myphone',
	static function () {
		if ( ! current_user_can( 'manage_options' ) || ! isset( $_POST['n'] ) || ! wp_verify_nonce( sanitize_key( $_POST['n'] ), 'hh_sale_myphone' ) ) {
			wp_die( 'Không có quyền.' );
		}
		$d   = hh_sale_phone_login( sanitize_text_field( wp_unslash( $_POST['phone'] ?? '' ) ) );
		$own = $d ? hh_sale_user_by_phone( $d ) : null;
		if ( '' === $d ) {
			delete_user_meta( get_current_user_id(), 'hh_login_phone' );
			$msg = 'Đã bỏ đăng nhập bằng số điện thoại.';
		} elseif ( strlen( $d ) < 9 || ( $own && $own->ID !== get_current_user_id() ) || username_exists( $d ) ) {
			$msg = 'Số ' . $d . ' không hợp lệ hoặc đã thuộc tài khoản khác.';
		} else {
			update_user_meta( get_current_user_id(), 'hh_login_phone', $d );
			$msg = 'Đã lưu: đăng nhập bằng số ' . $d . ' + mật khẩu quản trị.';
		}
		set_transient( 'hh_sale_admin_msg_' . get_current_user_id(), array( array( $msg ), array() ), 10 * MINUTE_IN_SECONDS );
		wp_safe_redirect( admin_url( 'admin.php?page=hh-khu-sale' ) );
		exit;
	}
);


/* =========================================================================
 * Đăng nhập bằng link gửi qua email (anh Hiệp 14/11/2026: "gõ đúng email là vào được")
 * Gõ email → web gửi link 1 lần, hết hạn 15 phút → bấm link là đăng nhập. Không lộ email nào có tài khoản;
 * giới hạn 5 lần/giờ mỗi địa chỉ IP và 1 lần/phút mỗi tài khoản. Chỉ tài khoản được vào khu sale (sale chưa khóa, quản trị).
 * ====================================================================== */

function hh_sale_maillink_send( $email ) {
	$u = get_user_by( 'email', $email );
	if ( ! $u || ( ! $u->has_cap( 'manage_options' ) && ( ! $u->has_cap( 'hh_sale_portal' ) || get_user_meta( $u->ID, 'hh_sale_locked', true ) ) ) ) {
		return 'sent';
	}
	if ( (int) get_user_meta( $u->ID, 'hh_sale_ml_at', true ) > time() - MINUTE_IN_SECONDS ) {
		return 'wait';
	}
	$token = wp_generate_password( 40, false );
	update_user_meta( $u->ID, 'hh_sale_ml', array( wp_hash_password( $token ), time() + 15 * MINUTE_IN_SECONDS ) );
	update_user_meta( $u->ID, 'hh_sale_ml_at', time() );
	$link = add_query_arg( 'ml', $u->ID . '.' . $token, hh_sale_url() );
	wp_mail(
		$u->user_email,
		'Link đăng nhập Khu Sale Hoàng Hiệp',
		'Chào ' . $u->display_name . ",\n\nBấm link dưới đây để đăng nhập Khu Sale Hoàng Hiệp (dùng 1 lần, hết hạn sau 15 phút):\n\n" . $link . "\n\nNếu bạn không yêu cầu, hãy bỏ qua email này.\n\nHoàng Hiệp – 0904 567 009"
	);
	return 'sent';
}

add_action( 'admin_post_nopriv_hh_sale_maillink', 'hh_sale_maillink_handle' );
add_action( 'admin_post_hh_sale_maillink', 'hh_sale_maillink_handle' );
function hh_sale_maillink_handle() {
	$ip  = 'hh_sale_ml_ip_' . md5( sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ?? '' ) ) );
	$cnt = (int) get_transient( $ip );
	$r   = 'sent';
	if ( $cnt >= 5 ) {
		$r = 'wait';
	} else {
		set_transient( $ip, $cnt + 1, HOUR_IN_SECONDS );
		$email = sanitize_email( wp_unslash( $_POST['email'] ?? '' ) ); // phpcs:ignore WordPress.Security.NonceVerification -- form công khai, chống lạm dụng bằng giới hạn lượt.
		if ( is_email( $email ) ) {
			$r = hh_sale_maillink_send( $email );
		}
	}
	wp_safe_redirect( add_query_arg( 'mls', $r, hh_sale_url() ) );
	exit;
}

function hh_sale_maillink_consume( $raw ) {
	$parts = explode( '.', $raw, 2 );
	$uid   = (int) ( $parts[0] ?? 0 );
	$token = (string) ( $parts[1] ?? '' );
	$data  = $uid ? (array) get_user_meta( $uid, 'hh_sale_ml', true ) : array();
	$ok    = $token && 2 === count( $data ) && (int) $data[1] >= time() && wp_check_password( $token, (string) $data[0], $uid );
	if ( $uid ) {
		delete_user_meta( $uid, 'hh_sale_ml' ); // Link chỉ dùng 1 lần (kể cả khi sai).
	}
	$u = $ok ? get_userdata( $uid ) : null;
	if ( ! $u || get_user_meta( $uid, 'hh_sale_locked', true ) || ( ! $u->has_cap( 'manage_options' ) && ! $u->has_cap( 'hh_sale_portal' ) ) ) {
		wp_safe_redirect( add_query_arg( 'mls', 'bad', hh_sale_url() ) );
		exit;
	}
	wp_set_current_user( $uid );
	wp_set_auth_cookie( $uid, true, is_ssl() );
	do_action( 'wp_login', $u->user_login, $u );
	wp_safe_redirect( hh_sale_url() );
	exit;
}
