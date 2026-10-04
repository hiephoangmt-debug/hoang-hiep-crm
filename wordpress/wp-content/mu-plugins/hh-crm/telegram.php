<?php
/**
 * Thông báo khách mới qua Telegram (song song email): form liên hệ, form đầu trang, chat trên web.
 * Cài đặt: Khách hàng → Thông báo Telegram – dán token bot (tạo ở @BotFather), nhắn /start cho bot, bấm "Lấy Chat ID".
 */

defined( 'ABSPATH' ) || exit;

function hh_tg_opt( $key ) {
	$all = (array) get_option( 'hh_telegram', array() );
	return (string) ( $all[ $key ] ?? '' );
}

/** Gửi tin nhắn Telegram tới các Chat ID đã lưu. Trả về true nếu gửi được ít nhất 1 nơi. */
function hh_tg_send( $text ) {
	$token = hh_tg_opt( 'token' );
	$chats = array_filter( array_map( 'trim', preg_split( '/[\s,;]+/', hh_tg_opt( 'chat_ids' ) ) ) );
	if ( '' === $token || ! $chats ) {
		return false;
	}
	$ok = false;
	foreach ( $chats as $chat ) {
		$res = wp_remote_post(
			'https://api.telegram.org/bot' . preg_replace( '/[^A-Za-z0-9:_-]/', '', $token ) . '/sendMessage',
			array(
				'timeout' => 10,
				'body'    => array(
					'chat_id'                  => $chat,
					'text'                     => mb_substr( $text, 0, 4000 ),
					'disable_web_page_preview' => 'true',
				),
			)
		);
		$data = is_wp_error( $res ) ? null : json_decode( (string) wp_remote_retrieve_body( $res ), true );
		if ( ! empty( $data['ok'] ) ) {
			$ok = true;
		} else {
			update_option( 'hh_tg_last_error', ( is_wp_error( $res ) ? $res->get_error_message() : (string) ( $data['description'] ?? 'Lỗi không rõ' ) ) . ' (' . wp_date( 'd/m H:i' ) . ')', false );
		}
	}
	if ( $ok ) {
		delete_option( 'hh_tg_last_error' );
	}
	return $ok;
}

/** Mỗi email báo khách mới cũng gửi sang Telegram. */
add_action(
	'hh_lead_notified',
	static function ( $subject, $body ) {
		hh_tg_send( '🔔 ' . $subject . "\n\n" . $body );
	},
	10,
	2
);

/* -------------------------------------------------------------------------
 * Trang cài đặt
 * ---------------------------------------------------------------------- */

add_action(
	'admin_menu',
	static function () {
		add_submenu_page( 'edit.php?post_type=khach-hang', 'Thông báo Telegram', 'Thông báo Telegram', 'manage_options', 'hh-telegram', 'hh_tg_page' );
	}
);

function hh_tg_page() {
	$notice = '';
	if ( isset( $_POST['hh_tg_action'] ) && check_admin_referer( 'hh_tg' ) ) {
		$opt    = (array) get_option( 'hh_telegram', array() );
		$action = sanitize_key( $_POST['hh_tg_action'] );
		$token  = trim( sanitize_text_field( wp_unslash( $_POST['tg_bot_token'] ?? '' ) ) );
		if ( '-' === $token ) {
			$opt['token'] = '';
		} elseif ( '' !== $token ) {
			// Lấy đúng token dạng 123456789:AA… dù dán cả câu của BotFather hoặc có chữ "bot" phía trước.
			if ( preg_match( '/(\d{6,}:[A-Za-z0-9_-]{30,})/', $token, $m ) ) {
				$opt['token'] = $m[1];
			} else {
				$notice = 'Token chưa đúng định dạng (dạng 123456789:AAH…). Mở BotFather, copy lại nguyên dòng token.';
			}
		}
		$opt['chat_ids'] = sanitize_text_field( wp_unslash( $_POST['chat_ids'] ?? ( $opt['chat_ids'] ?? '' ) ) );

		if ( 'detect' === $action && '' === $notice && ! empty( $opt['token'] ) ) {
			$res  = wp_remote_get( 'https://api.telegram.org/bot' . preg_replace( '/[^A-Za-z0-9:_-]/', '', $opt['token'] ) . '/getUpdates', array( 'timeout' => 10 ) );
			$data = is_wp_error( $res ) ? null : json_decode( (string) wp_remote_retrieve_body( $res ), true );
			$ids  = array();
			foreach ( (array) ( $data['result'] ?? array() ) as $u ) {
				$chat = $u['message']['chat'] ?? ( $u['my_chat_member']['chat'] ?? ( $u['channel_post']['chat'] ?? null ) );
				if ( $chat ) {
					$ids[ (string) $chat['id'] ] = $chat['title'] ?? trim( ( $chat['first_name'] ?? '' ) . ' ' . ( $chat['last_name'] ?? '' ) );
				}
			}
			if ( $ids ) {
				$current         = array_filter( preg_split( '/[\s,;]+/', $opt['chat_ids'] ) );
				$opt['chat_ids'] = implode( ', ', array_unique( array_merge( $current, array_keys( $ids ) ) ) );
				$notice          = 'Đã tìm thấy: ' . implode( ', ', array_map( static fn( $id, $n ) => $n . ' (' . $id . ')', array_keys( $ids ), $ids ) ) . '. Bấm "Gửi thử" để kiểm tra.';
			} elseif ( is_wp_error( $res ) ) {
				$notice = 'Không kết nối được Telegram: ' . $res->get_error_message();
			} elseif ( empty( $data['ok'] ) ) {
				$notice = 'Telegram báo token không đúng (' . ( $data['description'] ?? 'từ chối' ) . '). Dán lại token copy từ BotFather vào ô Token bot rồi bấm Lưu.';
			} else {
				$me     = json_decode( (string) wp_remote_retrieve_body( wp_remote_get( 'https://api.telegram.org/bot' . preg_replace( '/[^A-Za-z0-9:_-]/', '', $opt['token'] ) . '/getMe', array( 'timeout' => 10 ) ) ), true );
				$user   = (string) ( $me['result']['username'] ?? '' );
				$notice = 'Token đúng nhưng bot chưa nhận được tin nhắn nào. ' . ( $user ? 'Mở https://t.me/' . $user . ' (bot @' . $user . ' – không phải BotFather), bấm Start hoặc nhắn "hi", ' : 'Mở bot của anh (không phải BotFather), bấm Start hoặc nhắn "hi", ' ) . 'rồi bấm lại "Lấy Chat ID".';
			}
		}
		update_option( 'hh_telegram', $opt, false );
		if ( 'test' === $action ) {
			$notice = hh_tg_send( "✅ Thử thông báo từ " . home_url() . "\nKhi có khách để lại số trên web, tin nhắn sẽ về đây." ) ? 'Đã gửi tin thử – anh mở Telegram kiểm tra nhé.' : 'Gửi chưa được: ' . get_option( 'hh_tg_last_error', 'thiếu token hoặc Chat ID' );
		} elseif ( 'save' === $action && '' === $notice ) {
			$notice = 'Đã lưu. Giờ mở bot trong Telegram bấm Start, rồi bấm "Lấy Chat ID".';
		}
	}
	$has_token = '' !== hh_tg_opt( 'token' );
	?>
	<div class="wrap">
		<h1>Thông báo khách mới qua Telegram</h1>
		<?php if ( $notice ) : ?><div class="notice notice-info"><p><?php echo esc_html( $notice ); ?></p></div><?php endif; ?>
		<p>Mỗi khi khách để lại số (form liên hệ, form đầu trang, chat trên web), tin nhắn Telegram gửi ngay kèm tên, số, dự án đang xem và nội dung – song song với email.</p>
		<ol>
			<li>Trong Telegram, tìm <strong>@BotFather</strong> → gửi <code>/newbot</code> → đặt tên (VD: <em>Hoang Hiep Web</em>) và username kết thúc bằng <code>bot</code> → BotFather trả về <strong>token</strong>.</li>
			<li>Dán token vào ô bên dưới, bấm <strong>Lưu</strong>.</li>
			<li>Mở bot vừa tạo trong Telegram → bấm <strong>Start</strong>. (Muốn nhận trong nhóm: thêm bot vào nhóm và nhắn 1 tin trong nhóm.)</li>
			<li>Bấm <strong>Lấy Chat ID</strong> → rồi <strong>Gửi thử</strong>.</li>
		</ol>
		<form method="post">
			<?php wp_nonce_field( 'hh_tg' ); ?>
			<table class="form-table">
				<tr><th>Token bot</th><td><input type="text" name="tg_bot_token" class="regular-text code" autocomplete="off" data-lpignore="true" data-1p-ignore spellcheck="false" placeholder="<?php echo $has_token ? 'Đã lưu: …' . esc_attr( substr( hh_tg_opt( 'token' ), -6 ) ) . ' – để trống nếu giữ nguyên' : '123456789:AAH…'; ?>"><p class="description">Nhập <code>-</code> để xoá token.</p></td></tr>
				<tr><th>Chat ID nhận tin</th><td><input type="text" name="chat_ids" class="regular-text" value="<?php echo esc_attr( hh_tg_opt( 'chat_ids' ) ); ?>" placeholder="Tự điền khi bấm Lấy Chat ID"><p class="description">Nhiều nơi nhận: cách nhau bằng dấu phẩy (VD: anh và nhóm sale).</p></td></tr>
			</table>
			<?php if ( get_option( 'hh_tg_last_error' ) ) : ?><p style="color:#b32d2e">Lỗi gần nhất: <?php echo esc_html( get_option( 'hh_tg_last_error' ) ); ?></p><?php endif; ?>
			<p>
				<button class="button button-primary" name="hh_tg_action" value="save">Lưu</button>
				<button class="button" name="hh_tg_action" value="detect">Lấy Chat ID</button>
				<button class="button" name="hh_tg_action" value="test">Gửi thử</button>
			</p>
		</form>
	</div>
	<?php
}
