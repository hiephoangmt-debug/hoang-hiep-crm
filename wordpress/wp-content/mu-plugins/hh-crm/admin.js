( function ( $ ) {
	// Tabs inside the meta box.
	$( document ).on( 'click', '.hh-box__tab', function () {
		const box = $( this ).closest( '.hh-box' );
		const tab = $( this ).data( 'tab' );
		box.find( '.hh-box__tab' ).removeClass( 'is-active' );
		box.find( '.hh-box__panel' ).removeClass( 'is-active' );
		$( this ).addClass( 'is-active' );
		box.find( '.hh-box__panel[data-panel="' + tab + '"]' ).addClass( 'is-active' );
	} );

	// Bảng tính căn: đọc file ngay, không chờ lưu dự án.
	$( document ).on( 'click', '.hh-units-read__go', function ( e ) {
		e.preventDefault();
		const wrap = $( this ).closest( '.hh-units-read' );
		const box = wrap.closest( '.hh-box' );
		const out = wrap.find( '.hh-units-read__out' );
		const btn = $( this ).prop( 'disabled', true );
		out.html( '<p>Đang đọc file…</p>' );
		$.post( window.ajaxurl, {
			action: 'hh_units_read',
			_ajax_nonce: wrap.data( 'nonce' ),
			post_id: wrap.data( 'post' ),
			files: box.find( '#hh_p_units_file' ).val() || '',
			sheet: box.find( '#hh_p_units_sheet' ).val() || '',
		} ).done( function ( res ) {
			out.html( res && res.data && res.data.html ? res.data.html : '<p class="hh-units-read__err">Không đọc được – thử lại.</p>' );
		} ).fail( function () {
			out.html( '<p class="hh-units-read__err">Lỗi kết nối máy chủ – thử lại hoặc bấm Cập nhật dự án.</p>' );
		} ).always( function () {
			btn.prop( 'disabled', false );
		} );
	} );

	// Image / gallery pickers using the WordPress media library.
	function sync( wrap ) {
		const ids = wrap.find( '.hh-media__list li' ).map( function () {
			return $( this ).data( 'id' );
		} ).get();
		wrap.find( 'input[type=hidden]' ).val( ids.join( ',' ) );
	}

	$( document ).on( 'click', '.hh-media__add', function ( e ) {
		e.preventDefault();
		const wrap = $( this ).closest( '.hh-media' );
		const multiple = wrap.data( 'multiple' ) === 1 || wrap.data( 'multiple' ) === '1';
		const isFile = wrap.data( 'type' ) === 'file';
		const frame = wp.media( {
			title: isFile ? 'Chọn file Excel của chủ đầu tư (.xlsx, .xls, .csv)' + ( multiple ? ' – giữ Ctrl/Shift để chọn nhiều' : '' ) : ( multiple ? 'Chọn ảnh (giữ Ctrl/Shift để chọn nhiều)' : 'Chọn ảnh' ),
			button: { text: isFile ? 'Dùng file đã chọn' : 'Dùng ảnh này' },
			library: isFile ? {} : { type: 'image' },
			multiple: multiple ? 'add' : false,
		} );
		frame.on( 'select', function () {
			const list = wrap.find( '.hh-media__list' );
			if ( ! multiple ) {
				list.empty();
			}
			frame.state().get( 'selection' ).each( function ( att ) {
				const a = att.toJSON();
				if ( list.find( 'li[data-id="' + a.id + '"]' ).length ) {
					return;
				}
				if ( isFile ) {
					list.append( $( '<li>' ).attr( 'data-id', a.id ).text( a.filename || a.title ) );
					return;
				}
				const src = a.sizes && a.sizes.thumbnail ? a.sizes.thumbnail.url : a.url;
				list.append( $( '<li>' ).attr( 'data-id', a.id ).append( $( '<img>' ).attr( 'src', src ) ) );
			} );
			sync( wrap );
		} );
		frame.open();
	} );

	$( document ).on( 'click', '.hh-media__clear', function ( e ) {
		e.preventDefault();
		const wrap = $( this ).closest( '.hh-media' );
		wrap.find( '.hh-media__list' ).empty();
		sync( wrap );
	} );

	// Click a thumbnail to remove it.
	$( document ).on( 'click', '.hh-media__list li', function () {
		const wrap = $( this ).closest( '.hh-media' );
		$( this ).remove();
		sync( wrap );
	} );

	$( function () {
		if ( $.fn.sortable ) {
			$( '.hh-media__list' ).sortable( {
				update: function () {
					sync( $( this ).closest( '.hh-media' ) );
				},
			} );
		}
	} );
} )( jQuery );
