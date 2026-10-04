<?php
/**
 * Generic field engine: renders tabbed meta boxes from a schema, saves and reads values.
 *
 * Schema shape: [ group_id => [ 'title' => …, 'fields' => [ meta_key => field ] ] ]
 * Field keys: type (text|number|url|textarea|lines|table|select|checkbox|image|gallery|post),
 *             label, placeholder, help, options (select), columns (table), post_type (post), half (bool).
 */

defined( 'ABSPATH' ) || exit;

function hh_render_meta_box( $post, $schema ) {
	wp_nonce_field( 'hh_save_meta', 'hh_meta_nonce' );
	echo '<div class="hh-box">';
	echo '<nav class="hh-box__tabs">';
	$first = true;
	foreach ( $schema as $group_id => $group ) {
		printf(
			'<button type="button" class="hh-box__tab%s" data-tab="%s">%s</button>',
			$first ? ' is-active' : '',
			esc_attr( $group_id ),
			esc_html( $group['title'] )
		);
		$first = false;
	}
	echo '</nav>';

	$first = true;
	foreach ( $schema as $group_id => $group ) {
		printf( '<section class="hh-box__panel%s" data-panel="%s">', $first ? ' is-active' : '', esc_attr( $group_id ) );
		printf( '<h3 class="hh-box__panel-title">%s</h3>', esc_html( $group['title'] ) );
		if ( ! empty( $group['intro'] ) ) {
			printf( '<p class="hh-box__intro">%s</p>', esc_html( $group['intro'] ) );
		}
		echo '<div class="hh-box__grid">';
		foreach ( $group['fields'] as $key => $field ) {
			hh_render_field( $post->ID, $key, $field );
		}
		echo '</div></section>';
		$first = false;
	}
	echo '</div>';
}

function hh_render_field( $post_id, $key, $f ) {
	$type  = $f['type'] ?? 'text';
	$value = get_post_meta( $post_id, $key, true );
	$ph    = $f['placeholder'] ?? '';
	$wide  = in_array( $type, array( 'textarea', 'lines', 'table', 'gallery' ), true ) || empty( $f['half'] );
	$help  = $f['help'] ?? '';

	if ( 'lines' === $type && ! $help ) {
		$help = 'Mỗi dòng một ý.';
	}
	if ( 'table' === $type ) {
		$help = 'Mỗi dòng là một hàng. Các cột cách nhau bằng dấu | theo thứ tự: ' . implode( ' | ', $f['columns'] ) . '.' . ( $help ? ' ' . $help : '' );
	}

	printf( '<div class="hh-field hh-field--%s%s">', esc_attr( $type ), $wide ? ' hh-field--wide' : '' );

	if ( 'checkbox' === $type ) {
		printf(
			'<label class="hh-field__check"><input type="checkbox" name="%1$s" value="1"%2$s> %3$s</label>',
			esc_attr( $key ),
			checked( $value, '1', false ),
			esc_html( $f['label'] )
		);
	} else {
		printf( '<label class="hh-field__label" for="%s">%s</label>', esc_attr( $key ), esc_html( $f['label'] ) );
	}

	switch ( $type ) {
		case 'text':
		case 'url':
		case 'number':
			printf(
				'<input type="%1$s" id="%2$s" name="%2$s" value="%3$s" placeholder="%4$s"%5$s class="widefat">',
				'url' === $type ? 'url' : 'text',
				esc_attr( $key ),
				esc_attr( $value ),
				esc_attr( $ph ),
				'number' === $type ? ' inputmode="decimal"' : ''
			);
			break;

		case 'textarea':
		case 'lines':
		case 'table':
			printf(
				'<textarea id="%1$s" name="%1$s" rows="%2$d" placeholder="%3$s" class="widefat">%4$s</textarea>',
				esc_attr( $key ),
				'textarea' === $type ? 4 : 6,
				esc_attr( $ph ),
				esc_textarea( $value )
			);
			break;

		case 'select':
			printf( '<select id="%1$s" name="%1$s" class="widefat">', esc_attr( $key ) );
			foreach ( $f['options'] as $opt => $label ) {
				printf( '<option value="%s"%s>%s</option>', esc_attr( $opt ), selected( $value, $opt, false ), esc_html( $label ) );
			}
			echo '</select>';
			break;

		case 'post':
			$posts = get_posts(
				array(
					'post_type'   => $f['post_type'],
					'numberposts' => 200,
					'orderby'     => 'title',
					'order'       => 'ASC',
					'post_status' => array( 'publish', 'draft', 'private' ),
				)
			);
			printf( '<select id="%1$s" name="%1$s" class="widefat"><option value="">— Không chọn —</option>', esc_attr( $key ) );
			foreach ( $posts as $p ) {
				printf( '<option value="%d"%s>%s</option>', (int) $p->ID, selected( (int) $value, $p->ID, false ), esc_html( $p->post_title ) );
			}
			echo '</select>';
			break;

		case 'file':
			$fid = absint( $value );
			printf( '<div class="hh-media hh-media--file" data-multiple="0" data-type="file"><input type="hidden" id="%1$s" name="%1$s" value="%2$s"><ul class="hh-media__list">', esc_attr( $key ), $fid ? (int) $fid : '' );
			if ( $fid && get_post( $fid ) ) {
				printf( '<li data-id="%d"><span class="dashicons dashicons-media-spreadsheet"></span> %s</li>', (int) $fid, esc_html( wp_basename( (string) get_attached_file( $fid ) ) ) );
			}
			echo '</ul><button type="button" class="button hh-media__add">Chọn / tải file</button> <button type="button" class="button-link hh-media__clear">Xoá</button></div>';
			break;

		case 'image':
		case 'gallery':
			$ids = array_filter( array_map( 'absint', explode( ',', (string) $value ) ) );
			printf(
				'<div class="hh-media" data-multiple="%s"><input type="hidden" id="%s" name="%s" value="%s"><ul class="hh-media__list">',
				'gallery' === $type ? '1' : '0',
				esc_attr( $key ),
				esc_attr( $key ),
				esc_attr( implode( ',', $ids ) )
			);
			foreach ( $ids as $id ) {
				printf( '<li data-id="%d">%s</li>', (int) $id, wp_get_attachment_image( $id, 'thumbnail' ) );
			}
			printf(
				'</ul><button type="button" class="button hh-media__add">%s</button> <button type="button" class="button-link hh-media__clear">Xoá</button></div>',
				'gallery' === $type ? 'Chọn / thêm ảnh' : 'Chọn ảnh'
			);
			break;
	}

	if ( $help ) {
		printf( '<p class="hh-field__help">%s</p>', esc_html( $help ) );
	}
	echo '</div>';
}

function hh_save_schema( $post_id, $schema ) {
	foreach ( $schema as $group ) {
		foreach ( $group['fields'] as $key => $f ) {
			$type = $f['type'] ?? 'text';
			$raw  = wp_unslash( $_POST[ $key ] ?? '' ); // phpcs:ignore WordPress.Security -- nonce checked by caller, sanitized below.

			switch ( $type ) {
				case 'number':
					$clean = str_replace( array( ' ', ',' ), array( '', '.' ), trim( (string) $raw ) );
					$value = is_numeric( $clean ) ? (string) ( $clean + 0 ) : '';
					break;
				case 'url':
					$value = esc_url_raw( trim( (string) $raw ) );
					break;
				case 'textarea':
				case 'lines':
				case 'table':
					$value = sanitize_textarea_field( (string) $raw );
					break;
				case 'select':
					$value = array_key_exists( (string) $raw, $f['options'] ) ? (string) $raw : (string) array_key_first( $f['options'] );
					break;
				case 'checkbox':
					$value = empty( $raw ) ? '0' : '1';
					break;
				case 'image':
				case 'file':
				case 'post':
					$value = absint( $raw ) ?: '';
					break;
				case 'gallery':
					$value = implode( ',', array_filter( array_map( 'absint', explode( ',', (string) $raw ) ) ) );
					break;
				default:
					$value = sanitize_text_field( (string) $raw );
			}

			if ( '' === $value ) {
				delete_post_meta( $post_id, $key );
			} else {
				update_post_meta( $post_id, $key, $value );
			}
		}
	}
}

add_action( 'admin_enqueue_scripts', 'hh_admin_assets' );
function hh_admin_assets( $hook ) {
	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}
	$screen = get_current_screen();
	if ( ! $screen || ! in_array( $screen->post_type, array( 'du-an', 'bat-dong-san', 'khach-hang', 'post' ), true ) ) {
		return;
	}
	wp_enqueue_media();
	wp_enqueue_style( 'hh-admin', HH_CRM_URL . 'admin.css', array(), HH_CRM_VERSION );
	wp_enqueue_script( 'hh-admin', HH_CRM_URL . 'admin.js', array( 'jquery', 'jquery-ui-sortable' ), HH_CRM_VERSION, true );
}

/* -------------------------------------------------------------------------
 * Read helpers for templates
 * ---------------------------------------------------------------------- */

function hh_meta( $key, $post_id = null ) {
	return (string) get_post_meta( $post_id ?: get_the_ID(), $key, true );
}

/** Non-empty trimmed lines of a "lines" field. */
function hh_lines( $key, $post_id = null ) {
	return array_values( array_filter( array_map( 'trim', preg_split( '/\R/u', hh_meta( $key, $post_id ) ) ), 'strlen' ) );
}

/** Rows of a "table" field, each padded to $cols cells. */
function hh_table( $key, $cols, $post_id = null ) {
	$rows = array();
	foreach ( hh_lines( $key, $post_id ) as $line ) {
		$cells  = array_map( 'trim', explode( '|', $line ) );
		$rows[] = array_pad( array_slice( $cells, 0, $cols ), $cols, '' );
	}
	return $rows;
}

function hh_ids( $key, $post_id = null ) {
	return array_values( array_filter( array_map( 'absint', explode( ',', hh_meta( $key, $post_id ) ) ) ) );
}

/** Label of a select option given its schema. */
function hh_option_label( $schema, $key, $value ) {
	foreach ( $schema as $group ) {
		if ( isset( $group['fields'][ $key ]['options'][ $value ] ) ) {
			return $group['fields'][ $key ]['options'][ $value ];
		}
	}
	return '';
}

/** Format a price given in "triệu đồng". */
function hh_format_price( $trieu, $per_month = false ) {
	if ( '' === $trieu || null === $trieu || (float) $trieu <= 0 ) {
		return 'Thỏa thuận';
	}
	$trieu = (float) $trieu;
	$fmt   = static fn( $n ) => rtrim( rtrim( number_format( $n, 2, ',', '.' ), '0' ), ',' );
	$text  = $trieu >= 1000 ? $fmt( $trieu / 1000 ) . ' tỷ' : $fmt( $trieu ) . ' triệu';
	return $per_month ? $text . '/tháng' : $text;
}

/** Lowercase only the first letter (keeps place names like Đà Nẵng and acronyms like FPT). */
function hh_lcfirst( $text ) {
	$second = mb_substr( $text, 1, 1 );
	if ( '' !== $second && mb_strtoupper( $second ) === $second && mb_strtolower( $second ) !== $second ) {
		return $text;
	}
	return mb_strtolower( mb_substr( $text, 0, 1 ) ) . mb_substr( $text, 1 );
}

/** "từ 2,1 tỷ đến 24,5 tỷ" or "3,35 tỷ" when both ends are equal. */
function hh_price_range( $min, $max, $per_month = false ) {
	if ( abs( (float) $min - (float) $max ) < 0.001 ) {
		return hh_format_price( $min, $per_month );
	}
	return 'từ ' . hh_format_price( $min, $per_month ) . ' đến ' . hh_format_price( $max, $per_month );
}

function hh_youtube_id( $url ) {
	if ( preg_match( '~(?:youtu\.be/|v=|embed/|shorts/)([A-Za-z0-9_-]{11})~', (string) $url, $m ) ) {
		return $m[1];
	}
	return '';
}
