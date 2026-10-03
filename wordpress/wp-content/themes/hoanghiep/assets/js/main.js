( function () {
	const $ = ( s, el ) => ( el || document ).querySelector( s );
	const $$ = ( s, el ) => Array.from( ( el || document ).querySelectorAll( s ) );
	const reduceMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	// Mobile menu.
	const toggle = $( '.nav-toggle' );
	const nav = $( '#primary-nav' );
	if ( toggle && nav ) {
		toggle.addEventListener( 'click', () => {
			const open = nav.classList.toggle( 'is-open' );
			toggle.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
		} );
	}

	// Header shadow on scroll.
	const header = $( '.site-header' );
	if ( header ) {
		const onScroll = () => header.classList.toggle( 'is-scrolled', window.scrollY > 10 );
		window.addEventListener( 'scroll', onScroll, { passive: true } );
		onScroll();
	}

	// Hero slider.
	$$( '[data-slider]' ).forEach( ( slider ) => {
		const slides = $$( '.hero__slide', slider );
		const dots = $$( '.hero__dots button', slider );
		if ( slides.length < 2 ) {
			return;
		}
		let i = 0;
		let timer;
		const show = ( n ) => {
			slides[ i ].classList.remove( 'is-active' );
			dots[ i ] && dots[ i ].classList.remove( 'is-active' );
			i = ( n + slides.length ) % slides.length;
			slides[ i ].classList.add( 'is-active' );
			dots[ i ] && dots[ i ].classList.add( 'is-active' );
		};
		const play = () => {
			if ( ! reduceMotion ) {
				clearInterval( timer );
				timer = setInterval( () => show( i + 1 ), 6000 );
			}
		};
		dots.forEach( ( d, n ) => d.addEventListener( 'click', () => { show( n ); play(); } ) );
		play();
	} );

	// Search box tabs: switch target archive.
	$$( '[data-search-box]' ).forEach( ( box ) => {
		const form = $( 'form', box );
		$$( '.search-box__tab', box ).forEach( ( tab ) => {
			tab.addEventListener( 'click', () => {
				$$( '.search-box__tab', box ).forEach( ( t ) => {
					t.classList.toggle( 'is-active', t === tab );
					t.setAttribute( 'aria-selected', t === tab ? 'true' : 'false' );
				} );
				form.action = tab.dataset.action;
				$$( '[data-hide-for]', form ).forEach( ( el ) => {
					const hide = el.dataset.hideFor === tab.dataset.kind;
					el.hidden = hide;
					el.disabled = hide;
				} );
			} );
		} );
		// Don't send empty parameters.
		form.addEventListener( 'submit', () => {
			$$( 'input, select', form ).forEach( ( el ) => {
				if ( ! el.value ) {
					el.disabled = true;
				}
			} );
		} );
	} );

	// Strip empty filters from GET forms, auto-submit sort.
	$$( '.filter-panel, .filter-bar' ).forEach( ( form ) => {
		form.addEventListener( 'submit', () => {
			$$( 'input, select', form ).forEach( ( el ) => {
				if ( ! el.value ) {
					el.disabled = true;
				}
			} );
		} );
	} );
	$$( '[data-autosubmit] select' ).forEach( ( sel ) => sel.addEventListener( 'change', () => sel.form.submit() ) );

	// "Nhận tư vấn" button scrolls to the form on pages that have one.
	const formLink = $( '[data-form-link]' );
	if ( formLink && document.getElementById( 'lien-he' ) ) {
		formLink.setAttribute( 'href', '#lien-he' );
	}

	// Nút "Ký gửi…" chọn sẵn nhu cầu trong form liên hệ.
	$$( '[data-need]' ).forEach( ( btn ) => {
		btn.addEventListener( 'click', () => {
			const sel = document.querySelector( '#lien-he select[name="need"]' );
			if ( sel ) {
				sel.value = btn.dataset.need;
			}
		} );
	} );

	// Tabs inside project page (Shop khối đế · Penthouse · Duplex).
	$$( '.ptabs' ).forEach( ( bar ) => {
		const block = bar.parentElement;
		$$( '.ptabs__tab', bar ).forEach( ( tab ) => {
			tab.addEventListener( 'click', () => {
				$$( '.ptabs__tab', bar ).forEach( ( t ) => {
					t.classList.toggle( 'is-active', t === tab );
					t.setAttribute( 'aria-selected', t === tab ? 'true' : 'false' );
				} );
				$$( '.ptabs__panel', block ).forEach( ( p ) => p.classList.toggle( 'is-active', p.dataset.ppanel === tab.dataset.ptab ) );
			} );
		} );
	} );

	// Bài toán dòng tiền & vay ngân hàng. Amounts are in "triệu đồng".
	const fmtNum = ( n, d ) => n.toLocaleString( 'vi-VN', { maximumFractionDigits: d === undefined ? 1 : d } );
	const money = ( tr ) => {
		if ( ! isFinite( tr ) ) {
			return '—';
		}
		const neg = tr < -0.0005 ? '−' : '';
		const v = Math.abs( tr );
		if ( v < 0.0005 ) {
			return '0 đ';
		}
		return neg + ( v >= 1000 ? fmtNum( v / 1000, 3 ) + ' tỷ' : fmtNum( v, v < 10 ? 2 : 1 ) + ' triệu' );
	};

	/** Monthly schedule. Returns [{m, interest, principal, balanceStart}] */
	function amortize( p ) {
		const n = Math.max( 1, Math.round( p.years * 12 ) );
		const grace = Math.min( Math.max( 0, Math.round( p.grace ) ), n - 1 );
		const rows = [];
		let bal = p.loan;
		for ( let m = 1; m <= n && bal > 1e-9; m++ ) {
			const yearly = m <= p.zero ? 0 : ( m <= p.promoM ? p.promo : p.float );
			const r = yearly / 100 / 12;
			const interest = bal * r;
			let principal = 0;
			if ( m > grace ) {
				const left = n - m + 1;
				if ( p.method === 'deu' ) {
					const pay = r > 0 ? bal * r / ( 1 - Math.pow( 1 + r, -left ) ) : bal / left;
					principal = pay - interest;
				} else {
					principal = p.loan / ( n - grace );
				}
				principal = Math.min( principal, bal );
			}
			rows.push( { m, interest, principal, balanceStart: bal } );
			bal -= principal;
		}
		return rows;
	}

	$$( '[data-finance]' ).forEach( ( box ) => {
		let cfg;
		try {
			cfg = JSON.parse( box.dataset.finance );
		} catch ( e ) {
			return;
		}
		const out = ( k ) => box.querySelector( '[data-out="' + k + '"]' );
		const set = ( k, v ) => { const el = out( k ); if ( el ) { el.textContent = v; } };
		const val = ( name ) => {
			const el = box.querySelector( '[name="' + name + '"]' );
			const v = el ? parseFloat( String( el.value ).replace( ',', '.' ) ) : NaN;
			return isFinite( v ) ? v : 0;
		};

		const run = () => {
			const p = {
				price: val( 'price' ), ratio: Math.min( 100, val( 'ratio' ) ), years: val( 'years' ) || 1,
				promo: val( 'promo' ), promoM: val( 'promoM' ), float: val( 'float' ), grace: val( 'grace' ), zero: val( 'zero' ),
				method: ( box.querySelector( '[name="method"]' ) || {} ).value || 'giam-dan',
			};
			p.loan = p.price * p.ratio / 100;
			const equity = p.price - p.loan;
			const rows = amortize( p );
			const pays = rows.map( ( r ) => r.interest + r.principal );
			const totalInterest = rows.reduce( ( a, r ) => a + r.interest, 0 );
			let maxI = 0;
			pays.forEach( ( v, i ) => { if ( v > pays[ maxI ] + 1e-9 ) { maxI = i; } } );

			set( 'equity', money( equity ) );
			set( 'loan', money( p.loan ) );
			set( 'first', pays.length ? money( pays[ 0 ] ) : '—' );
			set( 'max', pays.length ? money( pays[ maxI ] ) : '—' );
			set( 'maxWhen', pays.length ? 'từ tháng thứ ' + ( maxI + 1 ) : '' );
			set( 'interest', money( totalInterest ) );
			set( 'total', money( p.loan + totalInterest ) );
			const after = Math.max( p.zero, p.promoM, p.grace ) + 1;
			const afterPay = pays[ Math.min( after, pays.length ) - 1 ];
			set( 'summary', p.loan > 0
				? 'Vay ' + money( p.loan ) + ' trong ' + fmtNum( p.years, 0 ) + ' năm. ' +
					( p.zero > 0 ? 'Chủ đầu tư hỗ trợ lãi 0% trong ' + fmtNum( p.zero, 0 ) + ' tháng đầu. ' : '' ) +
					( p.grace > 0 ? 'Ân hạn gốc ' + fmtNum( p.grace, 0 ) + ' tháng. ' : '' ) +
					( afterPay !== undefined ? 'Từ tháng thứ ' + Math.min( after, pays.length ) + ', mỗi tháng trả khoảng ' + money( afterPay ) + '.' : '' )
				: 'Không vay ngân hàng.' );

			// Dòng tiền theo đợt: vốn tự có trả trước, ngân hàng giải ngân phần còn lại.
			const tbody = out( 'schedule' );
			if ( tbody ) {
				let eqLeft = equity;
				let pctTotal = 0;
				let eqTotal = 0;
				let bankTotal = 0;
				tbody.innerHTML = '';
				( cfg.payment || [] ).forEach( ( st ) => {
					const amount = p.price * st.pct / 100;
					const fromEq = Math.min( amount, Math.max( 0, eqLeft ) );
					const fromBank = amount - fromEq;
					eqLeft -= fromEq;
					pctTotal += st.pct;
					eqTotal += fromEq;
					bankTotal += fromBank;
					const tr = document.createElement( 'tr' );
					[ st.stage, st.when, fmtNum( st.pct, 2 ) + '%', money( amount ), fromEq > 0.0001 ? money( fromEq ) : '—', fromBank > 0.0001 ? money( fromBank ) : '—' ].forEach( ( text ) => {
						const td = document.createElement( 'td' );
						td.textContent = text;
						tr.appendChild( td );
					} );
					tbody.appendChild( tr );
				} );
				set( 'pctTotal', fmtNum( pctTotal, 2 ) + '%' );
				set( 'priceTotal', money( p.price * pctTotal / 100 ) );
				set( 'equityTotal', money( eqTotal ) );
				set( 'bankTotal', money( bankTotal ) );
			}

			// Bài toán cho thuê.
			const rent = val( 'rent' );
			const net = rent * val( 'occ' ) / 100 * ( 1 - val( 'cost' ) / 100 );
			set( 'netRent', rent > 0 ? money( net ) : '—' );
			set( 'yield', rent > 0 && p.price > 0 ? fmtNum( net * 12 / p.price * 100, 2 ) + '%' : '—' );
			const cf = net - ( afterPay || 0 );
			const cfEl = out( 'cashflow' );
			if ( cfEl ) {
				cfEl.textContent = rent > 0 ? ( cf >= 0 ? '+' : '' ) + money( cf ) : '—';
				cfEl.classList.toggle( 'is-neg', rent > 0 && cf < 0 );
				cfEl.classList.toggle( 'is-pos', rent > 0 && cf >= 0 );
			}

			// Lịch trả nợ theo năm.
			const amort = out( 'amort' );
			if ( amort ) {
				amort.innerHTML = '';
				for ( let y = 0; y * 12 < rows.length; y++ ) {
					const part = rows.slice( y * 12, y * 12 + 12 );
					const pr = part.reduce( ( a, r ) => a + r.principal, 0 );
					const it = part.reduce( ( a, r ) => a + r.interest, 0 );
					const start = part[ 0 ].balanceStart;
					const tr = document.createElement( 'tr' );
					[ String( y + 1 ), money( start ), money( pr ), money( it ), money( pr + it ), money( ( pr + it ) / part.length ), money( Math.max( 0, start - pr ) ) ].forEach( ( text ) => {
						const td = document.createElement( 'td' );
						td.textContent = text;
						tr.appendChild( td );
					} );
					amort.appendChild( tr );
				}
			}
		};

		box.addEventListener( 'input', run );
		box.addEventListener( 'change', run );
		run();
	} );

	// Chia sẻ bài viết: Zalo dùng menu chia sẻ của điện thoại, máy tính thì sao chép link.
	$$( '.share' ).forEach( ( bar ) => {
		const msg = $( '.share__msg', bar );
		const copy = ( url, note ) => {
			const done = () => { if ( msg ) { msg.textContent = note; } };
			if ( navigator.clipboard ) {
				navigator.clipboard.writeText( url ).then( done, () => window.prompt( 'Sao chép link:', url ) );
			} else {
				window.prompt( 'Sao chép link:', url );
			}
		};
		$$( '[data-share-copy]', bar ).forEach( ( b ) => b.addEventListener( 'click', () => copy( b.dataset.shareCopy, 'Đã sao chép link.' ) ) );
		$$( '[data-share]', bar ).forEach( ( b ) => b.addEventListener( 'click', () => {
			if ( navigator.share ) {
				navigator.share( { title: b.dataset.title, url: b.dataset.share } ).catch( () => {} );
			} else {
				copy( b.dataset.share, 'Đã sao chép link – dán vào Zalo để gửi.' );
			}
		} ) );
	} );

	// Project sub-navigation highlight.
	const subLinks = $$( '.subnav a[href^="#"]:not(.subnav__cta)' );
	if ( subLinks.length && 'IntersectionObserver' in window ) {
		const map = new Map();
		subLinks.forEach( ( a ) => {
			const sec = document.getElementById( a.getAttribute( 'href' ).slice( 1 ) );
			if ( sec ) {
				map.set( sec, a );
			}
		} );
		const io = new IntersectionObserver( ( entries ) => {
			entries.forEach( ( e ) => {
				if ( e.isIntersecting ) {
					subLinks.forEach( ( a ) => a.classList.remove( 'is-active' ) );
					const a = map.get( e.target );
					a.classList.add( 'is-active' );
					a.scrollIntoView( { block: 'nearest', inline: 'center', behavior: reduceMotion ? 'auto' : 'smooth' } );
				}
			} );
		}, { rootMargin: '-35% 0px -60% 0px' } );
		map.forEach( ( a, sec ) => io.observe( sec ) );
	}

	// Lightbox for [data-lightbox] groups.
	const box = $( '.lightbox' );
	if ( box ) {
		const img = $( 'img', box );
		const count = $( '.lightbox__count', box );
		let group = [];
		let idx = 0;
		const render = () => {
			img.src = group[ idx ].href;
			count.textContent = ( idx + 1 ) + ' / ' + group.length;
		};
		const close = () => {
			box.hidden = true;
			document.body.style.overflow = '';
		};
		document.addEventListener( 'click', ( e ) => {
			const a = e.target.closest( 'a[data-lightbox]' );
			if ( ! a ) {
				return;
			}
			e.preventDefault();
			group = $$( 'a[data-lightbox="' + a.dataset.lightbox + '"]' );
			idx = group.indexOf( a );
			render();
			box.hidden = false;
			document.body.style.overflow = 'hidden';
		} );
		$( '.lightbox__close', box ).addEventListener( 'click', close );
		$( '.lightbox__prev', box ).addEventListener( 'click', () => { idx = ( idx - 1 + group.length ) % group.length; render(); } );
		$( '.lightbox__next', box ).addEventListener( 'click', () => { idx = ( idx + 1 ) % group.length; render(); } );
		box.addEventListener( 'click', ( e ) => { if ( e.target === box ) { close(); } } );
		document.addEventListener( 'keydown', ( e ) => {
			if ( box.hidden ) {
				return;
			}
			if ( e.key === 'Escape' ) { close(); }
			if ( e.key === 'ArrowLeft' ) { $( '.lightbox__prev', box ).click(); }
			if ( e.key === 'ArrowRight' ) { $( '.lightbox__next', box ).click(); }
		} );
	}
} )();
