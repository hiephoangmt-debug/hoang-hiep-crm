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
			title: isFile ? 'Chọn file bảng hàng (.xlsx, .csv)' : ( multiple ? 'Chọn ảnh (giữ Ctrl/Shift để chọn nhiều)' : 'Chọn ảnh' ),
			button: { text: isFile ? 'Dùng file này' : 'Dùng ảnh này' },
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
