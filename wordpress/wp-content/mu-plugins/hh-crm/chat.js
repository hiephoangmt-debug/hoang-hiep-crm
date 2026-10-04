/* Chat trực tiếp trên web – khung chat góc phải, lưu hội thoại trong trình duyệt khách. */
( function () {
	'use strict';
	var C = window.HH_CHAT;
	if ( ! C ) {
		return;
	}
	var KEY = 'hh_chat_v1';
	var state = load();
	var busy = false;

	function load() {
		try {
			var s = JSON.parse( localStorage.getItem( KEY ) || 'null' );
			if ( s && s.conv && Array.isArray( s.msgs ) && Date.now() - ( s.at || 0 ) < 7 * 864e5 ) {
				return s;
			}
		} catch ( e ) {}
		return { conv: Math.random().toString( 36 ).slice( 2 ) + Date.now().toString( 36 ), msgs: [], lead: false, at: Date.now() };
	}
	function save() {
		state.at = Date.now();
		try {
			localStorage.setItem( KEY, JSON.stringify( { conv: state.conv, msgs: state.msgs.slice( -40 ), lead: state.lead, at: state.at } ) );
		} catch ( e ) {}
	}
	function el( tag, cls, text ) {
		var n = document.createElement( tag );
		if ( cls ) {
			n.className = cls;
		}
		if ( text ) {
			n.textContent = text;
		}
		return n;
	}

	// Khung chat.
	var root = el( 'div', 'hhc' );
	root.innerHTML =
		'<button type="button" class="hhc__fab" aria-label="Chat với ' + esc( C.name ) + '">' +
			( C.avatar ? '<img src="' + esc( C.avatar ) + '" alt="">' : '' ) +
			'<span class="hhc__fab-text">Chat tư vấn</span><span class="hhc__dot"></span></button>' +
		'<div class="hhc__bubble" hidden><button type="button" class="hhc__bubble-x" aria-label="Đóng">×</button><p></p></div>' +
		'<section class="hhc__panel" hidden role="dialog" aria-label="Chat tư vấn">' +
			'<header class="hhc__head">' +
				( C.avatar ? '<img src="' + esc( C.avatar ) + '" alt="">' : '' ) +
				'<div><strong>' + esc( C.name ) + '</strong><span><i></i> Đang trực tuyến · trả lời trong vài phút</span></div>' +
				'<button type="button" class="hhc__close" aria-label="Đóng chat">×</button>' +
			'</header>' +
			'<div class="hhc__log" aria-live="polite"></div>' +
			'<div class="hhc__chips"></div>' +
			'<form class="hhc__form"><input type="text" name="m" autocomplete="off" maxlength="800" placeholder="Nhập câu hỏi hoặc số Zalo…" aria-label="Tin nhắn"><button type="submit" aria-label="Gửi">➤</button></form>' +
			'<p class="hhc__foot">Hoặc gọi/Zalo <a href="' + esc( C.zalo ) + '" target="_blank" rel="noopener">' + esc( C.phone ) + '</a></p>' +
		'</section>';
	document.body.appendChild( root );

	var fab = root.querySelector( '.hhc__fab' );
	var panel = root.querySelector( '.hhc__panel' );
	var log = root.querySelector( '.hhc__log' );
	var chips = root.querySelector( '.hhc__chips' );
	var form = root.querySelector( '.hhc__form' );
	var input = form.querySelector( 'input' );
	var bubble = root.querySelector( '.hhc__bubble' );

	function esc( s ) {
		return String( s || '' ).replace( /[&<>"]/g, function ( c ) {
			return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[ c ];
		} );
	}
	function linkify( text ) {
		return esc( text ).replace( /(https?:\/\/[^\s<]+)/g, '<a href="$1" target="_blank" rel="noopener">$1</a>' );
	}
	function addMsg( role, text, store ) {
		var b = el( 'div', 'hhc__msg hhc__msg--' + role );
		b.innerHTML = linkify( text ).replace( /\n/g, '<br>' );
		log.appendChild( b );
		log.scrollTop = log.scrollHeight;
		if ( store ) {
			state.msgs.push( { role: role, text: text } );
			save();
		}
	}
	function renderChips() {
		chips.innerHTML = '';
		if ( state.lead || state.msgs.filter( function ( m ) { return m.role === 'user'; } ).length > 3 ) {
			return;
		}
		( C.chips || [] ).forEach( function ( c ) {
			var b = el( 'button', 'hhc__chip', c );
			b.type = 'button';
			b.addEventListener( 'click', function () {
				if ( /zalo|số/i.test( c ) && ! /bảng giá/i.test( c ) ) {
					input.value = '';
					input.placeholder = 'Nhập số điện thoại/Zalo của anh/chị…';
					input.focus();
					addMsg( 'assistant', 'Anh/chị nhập số điện thoại/Zalo giúp em, ' + C.name + ' sẽ gửi tài liệu và gọi tư vấn trong ít phút ạ.', true );
					return;
				}
				send( c );
			} );
			chips.appendChild( b );
		} );
	}
	function open() {
		panel.hidden = false;
		bubble.hidden = true;
		root.classList.add( 'is-open' );
		if ( ! log.childElementCount ) {
			if ( ! state.msgs.length ) {
				addMsg( 'assistant', C.greet, true );
			} else {
				state.msgs.forEach( function ( m ) { addMsg( m.role, m.text, false ); } );
			}
		}
		renderChips();
		setTimeout( function () { input.focus(); }, 50 );
		try { sessionStorage.setItem( 'hh_chat_seen', '1' ); } catch ( e ) {}
	}
	function close() {
		panel.hidden = true;
		root.classList.remove( 'is-open' );
	}
	function send( text ) {
		text = ( text || '' ).trim();
		if ( ! text || busy ) {
			return;
		}
		addMsg( 'user', text, true );
		chips.innerHTML = '';
		busy = true;
		var typing = el( 'div', 'hhc__msg hhc__msg--assistant hhc__typing' );
		typing.innerHTML = '<i></i><i></i><i></i>';
		log.appendChild( typing );
		log.scrollTop = log.scrollHeight;
		var body = new URLSearchParams();
		body.append( 'action', 'hh_chat' );
		body.append( 'conv', state.conv );
		body.append( 'page', C.page || 0 );
		body.append( 'messages', JSON.stringify( state.msgs.slice( -14 ) ) );
		fetch( C.ajax, { method: 'POST', body: body, credentials: 'same-origin' } )
			.then( function ( r ) { return r.json(); } )
			.then( function ( r ) {
				var d = ( r && r.data ) || {};
				if ( d.lead ) {
					state.lead = true;
				}
				return d.reply || 'Em chưa nhận được câu trả lời, anh/chị gọi/Zalo ' + C.phone + ' giúp em nhé.';
			} )
			.catch( function () {
				return 'Mạng đang chậm, anh/chị nhắn lại giúp em hoặc gọi/Zalo ' + C.phone + ' nhé.';
			} )
			.then( function ( reply ) {
				typing.remove();
				addMsg( 'assistant', reply, true );
				busy = false;
				renderChips();
			} );
	}

	fab.addEventListener( 'click', function () { panel.hidden ? open() : close(); } );
	root.querySelector( '.hhc__close' ).addEventListener( 'click', close );
	bubble.querySelector( 'p' ).addEventListener( 'click', open );
	root.querySelector( '.hhc__bubble-x' ).addEventListener( 'click', function () {
		bubble.hidden = true;
		try { sessionStorage.setItem( 'hh_chat_seen', '1' ); } catch ( e ) {}
	} );
	form.addEventListener( 'submit', function ( e ) {
		e.preventDefault();
		var v = input.value;
		input.value = '';
		send( v );
	} );
	document.addEventListener( 'keydown', function ( e ) {
		if ( 'Escape' === e.key && ! panel.hidden ) {
			close();
		}
	} );
	// Nút "Chat" ở nơi khác trên trang có thể mở khung chat: <a data-hh-chat>.
	document.addEventListener( 'click', function ( e ) {
		var t = e.target.closest && e.target.closest( '[data-hh-chat]' );
		if ( t ) {
			e.preventDefault();
			open();
		}
	} );

	// Bong bóng lời chào sau 25 giây (1 lần mỗi lượt truy cập).
	var seen = false;
	try { seen = !! sessionStorage.getItem( 'hh_chat_seen' ); } catch ( e ) {}
	if ( C.popup && ! seen && ! state.lead ) {
		setTimeout( function () {
			if ( panel.hidden ) {
				bubble.querySelector( 'p' ).textContent = C.greet;
				bubble.hidden = false;
			}
		}, 25000 );
	}
} )();
