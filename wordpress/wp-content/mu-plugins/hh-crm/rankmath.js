/* Rank Math đọc thêm nội dung các tab Thông tin dự án khi chấm điểm SEO. */
( function () {
	if ( ! window.wp || ! wp.hooks || ! window.hhRankMath ) {
		return;
	}
	wp.hooks.addFilter( 'rank_math_content', 'hh-crm', function ( content ) {
		return ( content || '' ) + window.hhRankMath.content;
	} );
	let tries = 0;
	const refresh = function () {
		if ( window.rankMathEditor && typeof window.rankMathEditor.refresh === 'function' ) {
			window.rankMathEditor.refresh( 'content' );
		} else if ( tries++ < 20 ) {
			setTimeout( refresh, 500 );
		}
	};
	window.addEventListener( 'load', refresh );
}() );
