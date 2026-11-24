<?php
/**
 * Google Analytics 4 cho hiephoangmt.com (anh Hiệp tạo property 24/11/2026, mã đo lường G-CTXK4CGRLN).
 * Gắn thẻ gtag vào mọi trang (kể cả landing dự án – cùng dùng wp_head), không đo khi đăng nhập quản trị.
 * Sự kiện thêm: generate_lead (form gửi xong, trang quay lại ?lien-he=ok), click_zalo, click_call.
 */
defined( 'ABSPATH' ) || exit;

if ( ! defined( 'HH_GA4_ID' ) ) {
	define( 'HH_GA4_ID', 'G-CTXK4CGRLN' );
}

add_action( 'wp_head', function () {
	if ( ! HH_GA4_ID || is_admin() || is_preview() || ( is_user_logged_in() && current_user_can( 'edit_posts' ) ) ) {
		return;
	}
	$id = esc_js( HH_GA4_ID );
	?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr( HH_GA4_ID ); ?>"></script>
<script>
window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}
gtag('js',new Date());gtag('config','<?php echo $id; // phpcs:ignore ?>');
(function(){
try{var q=new URLSearchParams(location.search);if(q.get('lien-he')==='ok'){gtag('event','generate_lead',{event_label:'form-web',page_path:location.pathname});}}catch(e){}
document.addEventListener('click',function(e){var a=e.target.closest&&e.target.closest('a[href]');if(!a)return;var h=a.getAttribute('href')||'';
if(/zalo\.me/i.test(h)){gtag('event','click_zalo',{link_url:h,page_path:location.pathname});}
else if(/^tel:/i.test(h)){gtag('event','click_call',{page_path:location.pathname});}},true);
})();
</script>
	<?php
}, 2 );
