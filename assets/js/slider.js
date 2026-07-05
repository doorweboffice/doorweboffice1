/* doorweboffice1 hero slider — vanilla, no deps, one-direction infinite loop */
(function () {
	function init( slider ) {
		var track = slider.querySelector( '.dwo-slider-track' );
		if ( ! track ) { return; }
		var n = track.children.length;
		if ( n < 2 ) { return; }
		var cur = 0, timer;

		/* 첫 슬라이드 복제를 끝에 붙여 한방향 루프 구현 */
		var clone = track.children[ 0 ].cloneNode( true );
		clone.setAttribute( 'aria-hidden', 'true' );
		track.appendChild( clone );

		var dots = document.createElement( 'div' );
		dots.className = 'dwo-slider-dots';
		for ( var i = 0; i < n; i++ ) {
			(function ( idx ) {
				var b = document.createElement( 'button' );
				b.type = 'button';
				b.className = 'dwo-slider-dot';
				b.setAttribute( 'aria-label', 'slide ' + ( idx + 1 ) );
				b.addEventListener( 'click', function () { go( idx ); restart(); } );
				dots.appendChild( b );
			})( i );
		}
		slider.appendChild( dots );

		function go( idx ) {
			cur = idx; /* n(복제 슬라이드)까지 허용 */
			track.scrollTo( { left: track.clientWidth * cur, behavior: 'smooth' } );
			paint();
		}
		function paint() {
			for ( var j = 0; j < n; j++ ) {
				dots.children[ j ].classList.toggle( 'is-active', j === cur % n );
			}
		}
		track.addEventListener( 'scroll', function () {
			clearTimeout( track._dwoT );
			track._dwoT = setTimeout( function () {
				var idx = Math.round( track.scrollLeft / track.clientWidth );
				if ( idx >= n ) {
					/* 복제 슬라이드 도착 → 진짜 1번으로 순간이동 (사용자 눈엔 연속) */
					track.scrollTo( { left: 0, behavior: 'auto' } );
					idx = 0;
				}
				cur = idx;
				paint();
			}, 80 );
		} );
		function restart() {
			clearInterval( timer );
			timer = setInterval( function () { go( cur + 1 ); }, 5000 );
		}
		slider.addEventListener( 'pointerenter', function () { clearInterval( timer ); } );
		slider.addEventListener( 'pointerleave', restart );
		paint();
		restart();
	}
	var els = document.querySelectorAll( '.dwo-slider' );
	for ( var k = 0; k < els.length; k++ ) { init( els[ k ] ); }
})();
