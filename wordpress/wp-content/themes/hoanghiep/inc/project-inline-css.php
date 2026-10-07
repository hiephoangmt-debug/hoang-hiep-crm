<?php
/**
 * (Cũ) CSS in thẳng trong trang dự án – nay nằm trong main.css. Giữ hàm rỗng để template cũ gọi không lỗi.
 */

defined( 'ABSPATH' ) || exit;

function hoanghiep_project_inline_css() {
	// Đã gộp vào main.css (tải 1 lần, trình duyệt lưu đệm). main.css có phiên bản theo thời điểm sửa file
	// nên LiteSpeed / trình duyệt luôn lấy bản mới sau khi cập nhật – không cần in CSS thẳng vào trang nữa.
}
