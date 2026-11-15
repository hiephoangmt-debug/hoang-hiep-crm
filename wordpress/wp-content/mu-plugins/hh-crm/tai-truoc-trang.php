<?php
/**
 * Bấm link mở trang nhanh hơn (anh Hiệp 06/11/2026: "nhấp vào link chuyển hơi lâu").
 * Dùng Speculation Rules có sẵn của WordPress: rê chuột / chạm vào link là trình duyệt dựng sẵn trang.
 * - Khách: prerender, mức "moderate" (trang đã có bộ nhớ đệm LiteSpeed nên nhẹ cho máy chủ).
 * - Đã đăng nhập (quản trị): chỉ tải trước (prefetch), mức "moderate" – trang không qua bộ nhớ đệm nên tránh dựng thừa.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'wp_speculation_rules_configuration',
	static function ( $config ) {
		return is_user_logged_in()
			? array( 'mode' => 'prefetch', 'eagerness' => 'moderate' )
			: array( 'mode' => 'prerender', 'eagerness' => 'moderate' );
	},
	20
);

/**
 * iPhone / Safari chưa hỗ trợ Speculation Rules: chạm vào link là tải trước trang (đánh thức bộ nhớ đệm + kết nối),
 * và bấm link là hiện ngay thanh tải màu cam trên đầu trang – khách biết web đang mở trang, không tưởng bị đơ.
 */
add_action(
	'wp_footer',
	static function () {
		if ( is_admin() ) {
			return;
		}
		?>
<style>#hh-nav-bar{position:fixed;left:0;top:0;height:3px;width:0;background:linear-gradient(90deg,#f2551d,#ff8a3d);z-index:2147483647;box-shadow:0 0 8px rgba(242,85,29,.6);transition:width 8s cubic-bezier(.1,.7,.2,1),opacity .3s;pointer-events:none}#hh-nav-bar.go{width:85%}</style>
<script>
(function(){
	var host=location.host, seen={}, n=0, bar;
	function ok(a){
		if(!a||!a.href||a.target==='_blank'||a.hasAttribute('download'))return false;
		var u;try{u=new URL(a.href);}catch(e){return false;}
		if(u.host!==host||!/^https?:$/.test(u.protocol))return false;
		if(u.pathname===location.pathname&&u.search===location.search)return false;
		if(/\/(wp-admin|wp-login|wp-json|sale)\b|\.(pdf|jpe?g|png|webp|zip|docx?|xlsx?)$/i.test(u.pathname)||/[?&](add-to|action|ml)=/.test(u.search))return false;
		return u;
	}
	function warm(e){
		var a=e.target.closest&&e.target.closest('a'), u=ok(a);
		if(!u||n>=8)return;
		var k=u.pathname+u.search; if(seen[k])return; seen[k]=1; n++;
		if(HTMLScriptElement.supports&&HTMLScriptElement.supports('speculationrules'))return; // Chrome / Android đã có tải trước sẵn.
		try{fetch(u.href,{credentials:'same-origin',priority:'low'}).catch(function(){});}catch(x){}
	}
	addEventListener('touchstart',warm,{passive:true,capture:true});
	addEventListener('mouseover',function(e){clearTimeout(warm.t);warm.t=setTimeout(function(){warm(e);},80);},{passive:true,capture:true});
	addEventListener('click',function(e){
		if(e.defaultPrevented||e.button||e.metaKey||e.ctrlKey||e.shiftKey||e.altKey)return;
		var a=e.target.closest&&e.target.closest('a'), u=ok(a);
		if(!u||(u.hash&&u.pathname===location.pathname))return;
		if(!bar){bar=document.createElement('div');bar.id='hh-nav-bar';document.body.appendChild(bar);}
		bar.style.opacity='1';bar.classList.remove('go');void bar.offsetWidth;bar.classList.add('go');
	});
	addEventListener('pageshow',function(){if(bar){bar.classList.remove('go');bar.style.opacity='0';}});
})();
</script>
		<?php
	},
	99
);
