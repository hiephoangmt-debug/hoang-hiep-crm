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
