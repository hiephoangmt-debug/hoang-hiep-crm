<?php
/**
 * Khu Sale – Đào tạo & Kiểm tra kiến thức (anh Hiệp 14/11/2026: "đào tạo dễ hiểu nhất, chi tiết nhất, có câu hỏi test,
 * đổi liên tục để sale nắm thêm").
 * - /sale/dao-tao/: 8 bài học nền tảng (viết sẵn) + bài anh tự thêm (Quản trị → Khu Sale → Bài học sale) + học từng dự án.
 * - /sale/kiem-tra/: mỗi lượt 10 câu bốc ngẫu nhiên từ 3 nguồn: câu tự sinh từ dữ liệu dự án trên web (chủ đầu tư, vị trí,
 *   bàn giao, sở hữu, đơn giá, ưu đãi, câu hỏi khách hay hỏi – dữ liệu đổi thì câu hỏi đổi theo), ngân hàng câu kiến thức
 *   chung, câu anh tự thêm (Quản trị → Khu Sale → Câu hỏi kiểm tra). Chấm ngay, giải thích từng câu, lưu kết quả vào Báo cáo.
 * - Tổng quan: "Câu hỏi hôm nay" đổi mỗi ngày.
 * Kiến thức pháp lý theo Luật Nhà ở 2023, Luật Kinh doanh BĐS 2023 (hiệu lực 01/8/2024) – luôn đối chiếu văn bản mới nhất.
 */

defined( 'ABSPATH' ) || exit;

const HH_SALE_LESSON_TYPE = 'hh-bai-hoc';
const HH_SALE_QUESTION_TYPE = 'hh-cau-hoi';

/* =========================================================================
 * Bài học viết sẵn
 * ====================================================================== */

function hh_sale_core_lessons() {
	return array(
		'quy-trinh-cham-soc-khach' => array(
			'Quy trình chăm sóc khách 6 bước',
			'Bắt đầu từ đây',
			<<<HTML
<p><b>Mục tiêu:</b> mỗi khách từ web, Facebook, Zalo đều được gọi nhanh, hỏi đúng nhu cầu và có bước tiếp theo rõ ràng.</p>
<h3>Bước 1 – Gọi trong 15 phút</h3>
<p>Khách để lại số là lúc họ đang quan tâm nhất. Gọi ngay; không nghe máy thì nhắn Zalo: <i>"Em là … bên Hoàng Hiệp, em gửi anh/chị bảng giá dự án … anh/chị tiện nghe máy lúc nào ạ?"</i>. Cập nhật trạng thái ở tab <b>Khách của tôi</b> ngay sau cuộc gọi.</p>
<h3>Bước 2 – Hỏi nhu cầu (5 câu)</h3>
<ol><li>Mua để ở hay đầu tư / cho thuê?</li><li>Ngân sách khoảng bao nhiêu, vay hay trả thẳng?</li><li>Khu vực, loại căn (studio, 1PN, 2PN…)?</li><li>Khi nào cần nhận nhà?</li><li>Ai cùng quyết định (vợ/chồng, bố mẹ)?</li></ol>
<h3>Bước 3 – Gửi đúng 1–2 lựa chọn</h3>
<p>Không gửi cả kho tài liệu. Chọn 1–2 căn hợp nhất, gửi: link trang dự án trên hiephoangmt.com, mặt bằng căn, phiếu tính giá / vốn tự có. Ghi chú lại trong khách.</p>
<h3>Bước 4 – Hẹn xem nhà mẫu / dự án</h3>
<p>Khách đi xem thực tế chốt cao hơn nhiều so với chỉ nhắn tin. Đưa 2 khung giờ cụ thể để khách chọn.</p>
<h3>Bước 5 – Xử lý băn khoăn, chốt giữ chỗ / đặt cọc</h3>
<p>Xem bài "Xử lý từ chối". Chỉ nhận đặt cọc / giữ chỗ theo đúng văn bản của chủ đầu tư; tiền chuyển vào tài khoản chủ đầu tư hoặc đơn vị được chủ đầu tư chỉ định bằng văn bản.</p>
<h3>Bước 6 – Hậu mãi</h3>
<p>Nhắc lịch thanh toán, hỗ trợ ký HĐMB, bàn giao, làm sổ. Khách hài lòng là nguồn giới thiệu tốt nhất.</p>
<p class="note">Quy tắc: không hứa điều không có trong hợp đồng; không nói xấu dự án khác; không gửi tài liệu nội bộ (hoa hồng, hợp đồng mẫu, scan pháp lý) cho khách.</p>
HTML
		),
		'phap-ly-nha-hinh-thanh-trong-tuong-lai' => array(
			'Pháp lý khi bán căn hộ hình thành trong tương lai',
			'Pháp lý',
			<<<HTML
<p>Phần lớn dự án mở bán là <b>nhà ở hình thành trong tương lai</b> (đang xây). Luật Kinh doanh bất động sản 2023 (hiệu lực 01/8/2024) quy định chặt các điểm sau:</p>
<table><tr><th>Nội dung</th><th>Quy định</th></tr>
<tr><td>Điều kiện bán</td><td>Dự án phải có văn bản của Sở Xây dựng thông báo nhà ở đủ điều kiện được bán, cho thuê mua</td></tr>
<tr><td>Đặt cọc</td><td>Chỉ được nhận khi dự án đã đủ điều kiện kinh doanh; tối đa <b>5%</b> giá bán</td></tr>
<tr><td>Thanh toán lần đầu</td><td>Không quá <b>30%</b> giá trị hợp đồng (đã gồm tiền đặt cọc)</td></tr>
<tr><td>Trước khi bàn giao</td><td>Tổng tiền thu không quá <b>70%</b> (doanh nghiệp có vốn đầu tư nước ngoài: không quá 50%)</td></tr>
<tr><td>Trước khi cấp sổ</td><td>Tổng tiền thu không quá <b>95%</b>; 5% còn lại khi bên mua được cấp Giấy chứng nhận</td></tr>
<tr><td>Bảo lãnh ngân hàng</td><td>Chủ đầu tư phải được ngân hàng bảo lãnh nghĩa vụ tài chính với người mua</td></tr>
<tr><td>Công chứng HĐMB</td><td>HĐ mua bán với doanh nghiệp kinh doanh BĐS: công chứng / chứng thực do các bên thỏa thuận</td></tr></table>
<h3>Giấy tờ cần biết</h3>
<ul><li><b>Sổ hồng</b> = Giấy chứng nhận quyền sử dụng đất, quyền sở hữu tài sản gắn liền với đất.</li>
<li><b>Sở hữu lâu dài</b>: căn hộ chung cư trên đất ở (khách Việt Nam). <b>50 năm</b>: thường là căn hộ trên đất thương mại dịch vụ (căn hộ du lịch, căn hộ dịch vụ) – thời hạn theo dự án.</li>
<li>Tra dự án, mã định danh bất động sản: <b>thongtinbds.moc.gov.vn</b> (Bộ Xây dựng).</li></ul>
<p class="note">Khi khách hỏi pháp lý dự án cụ thể: xem mục "Thông tin nhanh" ở trang Học dự án, gửi đúng văn bản chủ đầu tư công bố – không tự suy đoán.</p>
HTML
		),
		'thue-phi-mua-ban' => array(
			'Thuế, phí khi mua căn hộ và khi bán lại',
			'Tài chính',
			<<<HTML
<h3>Mua căn hộ mới từ chủ đầu tư</h3>
<ul><li><b>Giá bán</b> thường đã gồm VAT 10% (VAT không tính trên phần tiền sử dụng đất) – xem phiếu tính giá.</li>
<li><b>Kinh phí bảo trì</b> phần sở hữu chung: <b>2%</b> giá bán (chưa VAT), nộp cho chủ đầu tư rồi bàn giao cho Ban quản trị.</li>
<li><b>Lệ phí trước bạ</b> khi làm sổ: <b>0,5%</b> giá trị tính lệ phí.</li>
<li>Phí quản lý hằng tháng: diện tích thông thủy × đơn giá/m²/tháng (mỗi dự án một mức).</li></ul>
<h3>Bán lại / chuyển nhượng</h3>
<ul><li>Thuế thu nhập cá nhân: <b>2%</b> giá chuyển nhượng (thường bên bán nộp, có thể thỏa thuận).</li>
<li>Bên mua nộp lệ phí trước bạ 0,5%.</li>
<li>Căn chưa có sổ: chuyển nhượng hợp đồng mua bán bằng văn bản, có xác nhận của chủ đầu tư.</li></ul>
<p><b>Mẹo tư vấn:</b> luôn báo khách <b>tổng tiền thực phải trả</b> (giá sau chiết khấu + VAT + 2% bảo trì + phí khác) để khách không bất ngờ.</p>
HTML
		),
		'tinh-von-tu-co-khoan-vay' => array(
			'Tính vốn tự có và tiền trả góp hằng tháng',
			'Tài chính',
			<<<HTML
<h3>Công thức nhanh</h3>
<ul><li><b>Vốn tự có</b> = giá căn × (1 − tỷ lệ vay) + chi phí (bảo trì 2%, phí khác).<br>Ví dụ: căn 3 tỷ, vay 70% → tự có 900 triệu (chưa tính phí).</li>
<li><b>Tiền lãi tháng</b> ≈ dư nợ × lãi suất năm ÷ 12.<br>Ví dụ: vay 2 tỷ, lãi 9%/năm → lãi tháng đầu ≈ 15 triệu.</li>
<li><b>Gốc tháng</b> (trả đều) = số vay ÷ số tháng. Vay 2 tỷ trong 20 năm (240 tháng) → gốc ≈ 8,33 triệu/tháng.</li></ul>
<h3>Thuật ngữ</h3>
<ul><li><b>Ân hạn nợ gốc</b>: trong thời gian này chỉ trả lãi, chưa trả gốc.</li>
<li><b>Hỗ trợ lãi suất 0%</b>: chủ đầu tư trả lãi thay khách trong số tháng cam kết – hết hỗ trợ thì khách trả lãi thả nổi.</li>
<li><b>Lãi thả nổi</b> = lãi cơ sở + biên độ, đổi theo kỳ điều chỉnh của ngân hàng.</li></ul>
<p><b>Cách tư vấn:</b> hỏi thu nhập hằng tháng của khách, đề xuất tỷ lệ vay để tiền trả hằng tháng không quá khoảng 40–50% thu nhập; dùng mục "Chính sách hiện hành" của từng dự án để lấy đúng tỷ lệ vay, số tháng 0% lãi.</p>
HTML
		),
		'khach-nuoc-ngoai-can-ho-tmdv' => array(
			'Khách nước ngoài, Việt kiều và căn hộ thương mại dịch vụ',
			'Pháp lý',
			<<<HTML
<h3>Người nước ngoài mua nhà (Luật Nhà ở 2023)</h3>
<ul><li>Được mua nhà ở thương mại trong dự án (trừ khu vực bảo đảm quốc phòng, an ninh), có thị thực nhập cảnh hợp lệ.</li>
<li>Tối đa <b>30%</b> số căn hộ của một tòa chung cư; nhà riêng lẻ tối đa 250 căn trên một khu vực có số dân tương đương một phường.</li>
<li>Thời hạn sở hữu tối đa <b>50 năm</b> kể từ khi cấp sổ, có thể gia hạn một lần.</li>
<li>Thanh toán qua tài khoản tại ngân hàng được phép hoạt động ở Việt Nam.</li></ul>
<h3>Việt kiều</h3>
<p>Người Việt Nam định cư ở nước ngoài có quốc tịch Việt Nam được quyền sở hữu như người trong nước; nếu không còn quốc tịch Việt Nam thì áp dụng điều kiện như người nước ngoài (trừ trường hợp được nhập cảnh và đủ điều kiện theo Luật Đất đai 2024 – cần kiểm tra hồ sơ cụ thể).</p>
<h3>Căn hộ thương mại dịch vụ (TMDV) / căn hộ du lịch</h3>
<ul><li>Xây trên đất thương mại dịch vụ, không phải đất ở → thời hạn theo dự án (thường 50 năm), không gọi là "chung cư".</li>
<li>Ví dụ trên web: Sun Saphia Residence là căn hộ TMDV và <b>không bán cho người nước ngoài</b>.</li>
<li>Khách nước ngoài: chỉ tư vấn dự án nhà ở thương mại còn quota 30%, xác nhận bằng văn bản của chủ đầu tư.</li></ul>
<p class="note">Khách nước ngoài: dùng trang tiếng Anh (vd /du-an/nobu-da-nang/en/), xác nhận điều kiện mua và thời hạn sở hữu trong HĐMB trước khi nhận cọc.</p>
HTML
		),
		'xu-ly-tu-choi' => array(
			'Xử lý 6 câu từ chối thường gặp',
			'Kỹ năng bán hàng',
			<<<HTML
<p>Nguyên tắc: <b>đồng cảm → hỏi lại → đưa thông tin cụ thể → đề xuất bước nhỏ tiếp theo</b>. Không cãi, không nói xấu dự án khác.</p>
<dl class="faq">
<dt>1. "Giá cao quá"</dt><dd>"Dạ anh/chị đang so với dự án nào ạ?" → so <b>tổng tiền thực</b> sau chiết khấu, phương án thanh toán, pháp lý, vị trí, tiện ích; gửi phiếu tính giá căn cụ thể.</dd>
<dt>2. "Để anh/chị suy nghĩ thêm"</dt><dd>"Anh/chị còn băn khoăn nhất điều gì ạ: giá, vị trí hay pháp lý?" → giải đáp đúng điểm đó, hẹn mốc gọi lại cụ thể.</dd>
<dt>3. "Chưa có đủ tiền"</dt><dd>Tính vốn tự có theo tỷ lệ vay, số tháng hỗ trợ lãi 0%; gợi ý loại căn nhỏ hơn.</dd>
<dt>4. "Sợ dự án chậm tiến độ"</dt><dd>Gửi ảnh tiến độ mới nhất, giới thiệu năng lực chủ đầu tư, bảo lãnh ngân hàng, mốc thanh toán theo tiến độ.</dd>
<dt>5. "Đầu tư có lời không?"</dt><dd>Đưa số liệu giá thuê, giá chuyển nhượng tham khảo; <b>không cam kết lợi nhuận</b> ngoài hợp đồng.</dd>
<dt>6. "Đã có người khác tư vấn rồi"</dt><dd>"Dạ không sao ạ, em gửi thêm bảng so sánh / phiếu tính giá để anh/chị tham khảo, cần gì cứ nhắn em."</dd>
</dl>
HTML
		),
		'marketing-ca-nhan' => array(
			'Marketing cá nhân: Facebook, Zalo, TikTok',
			'Marketing',
			<<<HTML
<h3>Mỗi ngày 3 việc</h3>
<ol><li>Đăng 1 bài giá trị (tin dự án, tiến độ, kinh nghiệm mua) – <b>chia sẻ link bài viết / trang dự án trên hiephoangmt.com</b>.</li>
<li>Đăng 1 story / video ngắn thực tế (công trường, nhà mẫu, view).</li>
<li>Nhắn hỏi thăm 5 khách cũ.</li></ol>
<h3>Công thức bài đăng</h3>
<ul><li>Câu đầu nói ngay lợi ích / con số (giá, vị trí, ưu đãi).</li>
<li>3–5 gạch đầu dòng thông tin rõ nguồn.</li>
<li>Ảnh thật trước, phối cảnh chủ đầu tư sau; ghi rõ ảnh nào là thực tế.</li>
<li>Kết bằng lời mời liên hệ + số điện thoại; link web để ở bình luận đầu.</li></ul>
<h3>Không được đăng</h3>
<ul><li>Hoa hồng, chính sách nội bộ, hợp đồng mẫu, bản scan pháp lý, thông tin / ảnh khách hàng.</li>
<li>Mã căn cụ thể (trừ khi anh Hiệp cho phép), cam kết lợi nhuận, "giá rẻ nhất thị trường".</li>
<li>Ảnh có logo / chữ chìm của đơn vị khác.</li></ul>
<p class="note">Mẫu bài, ảnh: xem tab Tài liệu → nhóm "Mẫu bài đăng".</p>
HTML
		),
		'hoc-mot-du-an' => array(
			'Học một dự án theo 7 phần',
			'Bắt đầu từ đây',
			<<<HTML
<p>Mỗi dự án trong tab <b>Học dự án</b> được trình bày theo đúng thứ tự một buổi tư vấn – học hết 7 phần là đủ tự tin nói chuyện với khách.</p>
<ol>
<li><b>Thị trường</b> – giá khu vực, giá chuyển nhượng / cho thuê, dự án cạnh tranh cùng khu, nhận định của anh Hiệp. Mục tiêu: trả lời được "Giá này đắt hay rẻ so với xung quanh?".</li>
<li><b>Chủ đầu tư</b> – là ai, đã làm gì ở Đà Nẵng, nhà thầu, đơn vị vận hành, điều người mua cần lưu ý. Mục tiêu: tạo niềm tin.</li>
<li><b>Sản phẩm</b> – key (điểm bán hàng), tổng quan, vị trí, liên kết vùng, tiện ích nội – ngoại khu. Mục tiêu: nói được 3 lý do nên mua trong 30 giây.</li>
<li><b>Mặt bằng</b> – mặt bằng tổng thể, tầng, layout căn, cách đọc mặt bằng, căn giá tốt, căn đầu tư tốt. Mục tiêu: chọn đúng căn cho đúng khách.</li>
<li><b>Giá & chính sách</b> – bảng giá tham khảo, ưu đãi, chiết khấu, lịch thanh toán, vốn tự có, vay ngân hàng. Mục tiêu: báo được tổng tiền và số tiền trả hằng tháng.</li>
<li><b>Tiến độ</b> – mốc thi công mới nhất, ảnh công trường.</li>
<li><b>Q&A</b> – câu khách hay hỏi và cách trả lời, lưu ý khi tư vấn.</li>
</ol>
<p>Học xong bấm <b>Kiểm tra dự án này</b> ở cuối trang: câu hỏi lấy từ chính 7 phần trên, đổi mỗi lượt.</p>
HTML
		),
		'doc-mat-bang-chon-can' => array(
			'Đọc mặt bằng và chọn căn giá tốt, đầu tư tốt',
			'Kỹ năng bán hàng',
			'<p>Mặt bằng là "bản đồ" của dự án. Đọc đúng giúp chọn căn hợp nhu cầu và giải thích được vì sao căn này đắt / rẻ hơn căn kia.</p>' . ( function_exists( 'hh_sale_floor_guide' ) ? hh_sale_floor_guide() : '' ) . '<h3>Ghép căn theo nhu cầu khách</h3><table><tr><th>Khách</th><th>Gợi ý</th></tr><tr><td>Gia đình ở lâu dài</td><td>2PN – 3PN, căn góc / hướng mát, tầng trung, gần tiện ích trẻ em</td></tr><tr><td>Đầu tư cho thuê</td><td>Studio, 1PN, view đẹp, tổng tiền thấp, gần biển / trung tâm</td></tr><tr><td>Đầu tư lướt sóng</td><td>Căn có đơn giá thấp nhất cùng loại, chiết khấu thanh toán sớm cao, dự án đang thi công tốt</td></tr><tr><td>Mua để nghỉ dưỡng</td><td>View biển / sông trực diện, tầng cao, căn góc</td></tr></table><p class="note">Mỗi dự án có thêm mục "Đọc mặt bằng dự án này", "Căn giá tốt", "Căn đầu tư tốt" do anh Hiệp cập nhật trong phần Mặt bằng.</p>',
		),
		'dung-khu-sale-va-web' => array(
			'Dùng khu Sale và website hiệu quả',
			'Bắt đầu từ đây',
			<<<HTML
<ul><li><b>Tổng quan</b>: nối Telegram để có khách là điện thoại báo ngay; làm "Câu hỏi hôm nay".</li>
<li><b>Khách của tôi</b>: sau mỗi cuộc gọi đổi trạng thái + ghi chú (đã gọi, hẹn xem nhà, ngân sách…). Báo cáo tính tốc độ gọi lại và tỷ lệ chốt từ đây.</li>
<li><b>Học dự án</b>: đọc "Điểm bán hàng", "Khách hay hỏi", "Lưu ý khi tư vấn" trước khi gọi khách của dự án đó.</li>
<li><b>Tài liệu</b>: file tải về được ghi tên người tải – không chuyển tiếp ra ngoài.</li>
<li><b>Kiểm tra</b>: làm ít nhất 1 lượt mỗi ngày; câu hỏi đổi liên tục theo dữ liệu dự án.</li>
<li>Gửi khách <b>link trang dự án</b> trên hiephoangmt.com thay vì file nặng – khách xem được bảng giá tham khảo, mặt bằng, tiến độ và để lại số, giúp web lên Google tốt hơn.</li></ul>
HTML
		),
	);
}

/* =========================================================================
 * Ngân hàng câu hỏi kiến thức chung
 * Mỗi câu: [câu hỏi, đáp án đúng, [3 đáp án sai], giải thích, slug bài học]
 * ====================================================================== */

function hh_sale_core_questions() {
	$l = 'phap-ly-nha-hinh-thanh-trong-tuong-lai';
	$t = 'thue-phi-mua-ban';
	$v = 'tinh-von-tu-co-khoan-vay';
	$n = 'khach-nuoc-ngoai-can-ho-tmdv';
	$q = 'quy-trinh-cham-soc-khach';
	$x = 'xu-ly-tu-choi';
	$m = 'marketing-ca-nhan';
	return array(
		array( 'Tiền đặt cọc khi mua nhà ở hình thành trong tương lai tối đa bao nhiêu?', '5% giá bán', array( '10% giá bán', '15% giá bán', '30% giá bán' ), 'Luật KDBĐS 2023: đặt cọc tối đa 5% giá bán và chỉ khi dự án đã đủ điều kiện kinh doanh.', $l ),
		array( 'Khi nào chủ đầu tư được nhận tiền đặt cọc căn hộ hình thành trong tương lai?', 'Khi dự án đã đủ điều kiện đưa vào kinh doanh', array( 'Ngay khi có quyết định chủ trương đầu tư', 'Khi đã khởi công móng', 'Bất cứ lúc nào nếu khách đồng ý' ), 'Đặt cọc chỉ được thực hiện khi nhà ở đã đủ điều kiện đưa vào kinh doanh theo Luật KDBĐS 2023.', $l ),
		array( 'Thanh toán lần đầu (đã gồm tiền cọc) tối đa bao nhiêu % giá trị hợp đồng?', '30%', array( '20%', '50%', '70%' ), 'Thanh toán lần đầu không quá 30% giá trị hợp đồng, kể cả tiền đặt cọc.', $l ),
		array( 'Trước khi bàn giao nhà, chủ đầu tư (doanh nghiệp trong nước) được thu tối đa bao nhiêu?', '70% giá trị hợp đồng', array( '50% giá trị hợp đồng', '95% giá trị hợp đồng', '100% giá trị hợp đồng' ), 'Tổng tiền thu trước bàn giao không quá 70%; doanh nghiệp có vốn đầu tư nước ngoài không quá 50%.', $l ),
		array( 'Phần tiền cuối cùng người mua chỉ phải nộp khi được cấp sổ là bao nhiêu?', '5%', array( '2%', '10%', '30%' ), 'Trước khi người mua được cấp Giấy chứng nhận, chủ đầu tư thu không quá 95%; 5% còn lại nộp khi có sổ.', $l ),
		array( 'Văn bản nào xác nhận dự án hình thành trong tương lai được phép bán?', 'Văn bản của Sở Xây dựng thông báo nhà ở đủ điều kiện được bán', array( 'Giấy phép kinh doanh của sàn môi giới', 'Bảng giá chủ đầu tư công bố', 'Quyết định giao việc cho đại lý' ), 'Kiểm tra văn bản thông báo đủ điều kiện bán của Sở Xây dựng trước khi nhận cọc.', $l ),
		array( 'Nhà ở hình thành trong tương lai bắt buộc phải có gì để bảo vệ người mua?', 'Bảo lãnh ngân hàng cho nghĩa vụ tài chính của chủ đầu tư', array( 'Bảo hiểm cháy nổ của người mua', 'Cam kết lợi nhuận', 'Hợp đồng thuê lại' ), 'Chủ đầu tư phải được ngân hàng bảo lãnh nghĩa vụ tài chính đối với người mua.', $l ),
		array( 'Hợp đồng mua bán căn hộ giữa doanh nghiệp kinh doanh BĐS và người mua có bắt buộc công chứng không?', 'Không bắt buộc – do các bên thỏa thuận', array( 'Bắt buộc công chứng', 'Bắt buộc chứng thực tại UBND phường', 'Chỉ bắt buộc với căn trên 3 tỷ' ), 'Luật KDBĐS 2023: hợp đồng có bên là doanh nghiệp kinh doanh BĐS thì công chứng, chứng thực do các bên thỏa thuận.', $l ),
		array( '"Sổ hồng" là tên gọi thông dụng của giấy tờ nào?', 'Giấy chứng nhận quyền sử dụng đất, quyền sở hữu tài sản gắn liền với đất', array( 'Hợp đồng mua bán căn hộ', 'Biên bản bàn giao nhà', 'Giấy phép xây dựng' ), 'Sổ hồng / sổ đỏ hiện nay là Giấy chứng nhận quyền sử dụng đất, quyền sở hữu tài sản gắn liền với đất.', $l ),
		array( 'Tra cứu mã định danh bất động sản, dự án đủ điều kiện bán trên trang nào?', 'thongtinbds.moc.gov.vn', array( 'batdongsan.com.vn', 'dichvucong.gov.vn/nha-dat', 'google.com/maps' ), 'Hệ thống thông tin về nhà ở và thị trường bất động sản của Bộ Xây dựng: thongtinbds.moc.gov.vn.', $l ),
		array( 'Kinh phí bảo trì phần sở hữu chung căn hộ là bao nhiêu?', '2% giá bán (chưa VAT)', array( '0,5% giá bán', '5% giá bán', '10% giá bán' ), 'Kinh phí bảo trì 2% giá bán căn hộ chưa VAT.', $t ),
		array( 'Lệ phí trước bạ khi làm sổ nhà đất là bao nhiêu?', '0,5%', array( '2%', '5%', '10%' ), 'Lệ phí trước bạ nhà, đất: 0,5% giá trị tính lệ phí.', $t ),
		array( 'Thuế thu nhập cá nhân khi bán lại căn hộ tính thế nào?', '2% giá chuyển nhượng', array( '10% tiền lãi', '0,5% giá chuyển nhượng', '5% giá chuyển nhượng' ), 'Thuế TNCN chuyển nhượng BĐS: 2% giá chuyển nhượng.', $t ),
		array( 'Thuế VAT 10% của căn hộ mới có tính trên tiền sử dụng đất không?', 'Không – phần tiền sử dụng đất được trừ khi tính VAT', array( 'Có, tính trên toàn bộ giá', 'Chỉ tính trên tiền sử dụng đất', 'Căn hộ không chịu VAT' ), 'Giá tính VAT không bao gồm tiền sử dụng đất / tiền thuê đất nộp ngân sách.', $t ),
		array( 'Phí quản lý căn hộ hằng tháng thường tính theo công thức nào?', 'Diện tích thông thủy × đơn giá/m²/tháng', array( 'Diện tích tim tường × 2%', 'Giá căn × 0,1%', 'Số phòng ngủ × 500.000 đ' ), 'Phí quản lý = diện tích sử dụng (thông thủy) × đơn giá dự án.', $t ),
		array( 'Diện tích ghi trong hợp đồng mua bán và sổ hồng căn hộ chung cư là diện tích gì?', 'Diện tích thông thủy', array( 'Diện tích tim tường', 'Diện tích sàn xây dựng tòa nhà', 'Diện tích ban công gấp đôi' ), 'Căn hộ chung cư ghi diện tích sử dụng (thông thủy) trong hợp đồng và Giấy chứng nhận.', $t ),
		array( 'Căn 3 tỷ, khách vay 70%. Vốn tự có tối thiểu (chưa tính phí) là bao nhiêu?', '900 triệu', array( '700 triệu', '2,1 tỷ', '1,2 tỷ' ), '3 tỷ × 30% = 900 triệu.', $v ),
		array( 'Vay 2 tỷ, lãi 9%/năm. Tiền lãi tháng đầu khoảng bao nhiêu?', '15 triệu', array( '9 triệu', '18 triệu', '1,5 triệu' ), '2 tỷ × 9% ÷ 12 = 15 triệu.', $v ),
		array( '"Ân hạn nợ gốc" nghĩa là gì?', 'Thời gian chỉ trả lãi, chưa trả gốc', array( 'Không phải trả lãi', 'Ngân hàng xóa nợ gốc', 'Trả gốc gấp đôi' ), 'Trong thời gian ân hạn nợ gốc, khách chỉ trả lãi.', $v ),
		array( 'Chủ đầu tư "hỗ trợ lãi suất 0% 24 tháng" nghĩa là?', 'Chủ đầu tư trả lãi thay khách trong 24 tháng', array( 'Ngân hàng cho vay không lãi suốt thời hạn vay', 'Khách được miễn trả gốc 24 tháng', 'Giá căn giảm 24%' ), 'Hết thời gian hỗ trợ, khách trả lãi theo lãi suất ngân hàng (thường thả nổi).', $v ),
		array( 'Người nước ngoài được sở hữu tối đa bao nhiêu căn hộ trong một tòa chung cư?', '30% số căn của tòa', array( '10% số căn', '50% số căn', 'Không giới hạn' ), 'Luật Nhà ở 2023: người nước ngoài sở hữu không quá 30% số căn hộ của một tòa nhà chung cư.', $n ),
		array( 'Thời hạn sở hữu nhà ở của cá nhân người nước ngoài là bao lâu?', 'Tối đa 50 năm, có thể gia hạn', array( 'Lâu dài như người Việt', '20 năm, không gia hạn', '70 năm' ), 'Cá nhân nước ngoài được sở hữu tối đa 50 năm kể từ ngày cấp Giấy chứng nhận, có thể gia hạn.', $n ),
		array( 'Căn hộ thương mại dịch vụ (TMDV) khác chung cư ở điểm nào?', 'Xây trên đất thương mại dịch vụ, thời hạn theo dự án (thường 50 năm)', array( 'Luôn sở hữu lâu dài', 'Không được cấp sổ', 'Chỉ dành cho người nước ngoài' ), 'Căn hộ TMDV / du lịch xây trên đất thương mại dịch vụ; thời hạn theo dự án.', $n ),
		array( 'Sun Saphia Residence có bán cho người nước ngoài không?', 'Không', array( 'Có, không giới hạn', 'Có, tối đa 30%', 'Chỉ bán cho người nước ngoài' ), 'Sun Saphia Residence là căn hộ TMDV và không bán cho người nước ngoài.', $n ),
		array( 'Khách nước ngoài thanh toán mua nhà thế nào?', 'Qua tài khoản tại ngân hàng được phép hoạt động ở Việt Nam', array( 'Tiền mặt ngoại tệ', 'Chuyển khoản cho cá nhân môi giới', 'Ví điện tử nước ngoài' ), 'Giao dịch mua nhà của người nước ngoài thực hiện qua tổ chức tín dụng tại Việt Nam.', $n ),
		array( 'Căn góc trên mặt bằng thường có ưu điểm gì?', 'Hai mặt thoáng, nhiều ánh sáng, view rộng', array( 'Luôn rẻ nhất tầng', 'Gần thang máy nhất', 'Diện tích thông thủy lớn gấp đôi' ), 'Căn góc có 2 mặt thoáng nên thường giá cao hơn và dễ bán lại, cho thuê.', 'doc-mat-bang-chon-can' ),
		array( 'Ở Đà Nẵng, hướng căn nào thường được ưa chuộng vì mát, đón gió biển?', 'Đông – Đông Nam', array( 'Tây', 'Tây Bắc', 'Hướng nào cũng như nhau' ), 'Hướng Đông – Đông Nam đón gió biển; hướng Tây nắng chiều.', 'doc-mat-bang-chon-can' ),
		array( 'Khách đầu tư cho thuê, nên ưu tiên loại căn nào?', 'Studio, 1PN – tổng tiền thấp, dễ cho thuê', array( 'Penthouse lớn nhất', 'Căn 4PN tầng thấp', 'Căn sát phòng rác cho rẻ' ), 'Căn nhỏ, view đẹp, gần tiện ích cho tỷ suất cho thuê tốt.', 'doc-mat-bang-chon-can' ),
		array( 'Muốn biết căn nào "giá tốt" trong cùng loại, so sánh theo chỉ số nào?', 'Đơn giá/m² cùng loại diện tích (thông thủy)', array( 'Tổng tiền bất kể diện tích', 'Số tầng', 'Màu sắc nội thất' ), 'So đơn giá/m² trên cùng loại diện tích mới công bằng; báo khách cả ưu, nhược điểm.', 'doc-mat-bang-chon-can' ),
		array( 'Căn sát thang máy, phòng rác thường có nhược điểm gì?', 'Dễ ồn, nhiều người qua lại', array( 'Không có cửa sổ', 'Không được cấp sổ', 'Không vay được ngân hàng' ), 'Căn cuối hành lang yên tĩnh hơn – nhắc khách khi chọn căn.', 'doc-mat-bang-chon-can' ),
		array( 'Thứ tự học một dự án trong khu Sale là gì?', 'Thị trường → Chủ đầu tư → Sản phẩm → Mặt bằng → Chính sách → Tiến độ → Q&A', array( 'Chính sách → Q&A → hết', 'Chỉ cần đọc bảng giá', 'Tiến độ → Tài liệu → Thị trường' ), 'Học theo thứ tự một buổi tư vấn, cuối cùng làm bài Kiểm tra dự án này.', 'hoc-mot-du-an' ),
		array( 'Khách mới để lại số trên web, nên gọi trong bao lâu?', 'Trong 15 phút', array( 'Cuối ngày gọi một lượt', 'Sau 24 giờ cho khách suy nghĩ', 'Chờ khách nhắn trước' ), 'Gọi càng nhanh tỷ lệ chốt càng cao – quy chuẩn của đội là 15 phút.', $q ),
		array( 'Câu hỏi nhu cầu nào nên hỏi đầu tiên?', 'Mua để ở hay đầu tư / cho thuê', array( 'Anh/chị làm nghề gì', 'Anh/chị đã xem dự án nào khác', 'Anh/chị có quen ai ở chủ đầu tư' ), 'Mục đích mua quyết định loại căn, vị trí và cách tư vấn.', $q ),
		array( 'Khi khách hỏi, nên gửi bao nhiêu lựa chọn căn?', '1–2 lựa chọn hợp nhất', array( 'Toàn bộ giỏ hàng', 'Không gửi, chờ khách xuống dự án', '10 căn rẻ nhất' ), 'Gửi ít nhưng trúng nhu cầu để khách dễ quyết định.', $q ),
		array( 'Tiền đặt cọc / giữ chỗ của khách phải chuyển vào đâu?', 'Tài khoản chủ đầu tư hoặc đơn vị được chủ đầu tư chỉ định bằng văn bản', array( 'Tài khoản cá nhân của sale', 'Đưa tiền mặt cho sale', 'Tài khoản bất kỳ khách tin tưởng' ), 'Tuyệt đối không nhận tiền cọc vào tài khoản cá nhân.', $q ),
		array( 'Sau mỗi cuộc gọi khách, sale cần làm gì trên khu Sale?', 'Đổi trạng thái và ghi chú chăm sóc', array( 'Xóa khách', 'Không cần làm gì', 'Chuyển khách cho sale khác' ), 'Ghi chú giúp chăm sóc liên tục và tính báo cáo tốc độ gọi lại, tỷ lệ chốt.', $q ),
		array( 'Khách nói "Giá cao quá", câu đầu tiên nên trả lời?', '"Dạ anh/chị đang so với dự án nào ạ?"', array( '"Dự án kia chất lượng kém lắm"', '"Em giảm thêm cho anh/chị 5%"', '"Giá này là rẻ nhất thị trường"' ), 'Hỏi lại để biết khách so với gì, rồi so tổng tiền thực và giá trị.', $x ),
		array( 'Khách hỏi "Đầu tư có lời không?", sale được nói gì?', 'Đưa số liệu giá thuê, giá chuyển nhượng tham khảo, không cam kết lợi nhuận ngoài hợp đồng', array( 'Cam kết lời 20%/năm', 'Hứa mua lại giá cao hơn', 'Nói chắc chắn giá sẽ tăng gấp đôi' ), 'Chỉ cam kết những gì có trong hợp đồng / chính sách chủ đầu tư.', $x ),
		array( 'Thông tin nào KHÔNG được đăng lên mạng xã hội?', 'Hoa hồng, hợp đồng mẫu, bản scan pháp lý, thông tin khách hàng', array( 'Ảnh tiến độ thực tế', 'Giá tham khảo theo loại căn', 'Link trang dự án trên hiephoangmt.com' ), 'Tài liệu nội bộ và thông tin khách tuyệt đối không công khai.', $m ),
		array( 'Bài đăng Facebook nên đặt link web ở đâu?', 'Bình luận đầu tiên', array( 'Không bao giờ đăng link', 'Dòng đầu tiên của bài', 'Trong ảnh' ), 'Facebook giảm hiển thị bài có link trong thân bài – đặt link ở bình luận đầu.', $m ),
		array( 'Ảnh nào nên đặt đầu tiên trong bài đăng dự án?', 'Ảnh thực tế (công trường, flycam, nhà mẫu)', array( 'Ảnh có logo đơn vị khác', 'Ảnh chụp màn hình bảng hoa hồng', 'Ảnh mạng không rõ nguồn' ), 'Ảnh thật tạo tin tưởng; ghi rõ ảnh nào là thực tế, ảnh nào là phối cảnh.', $m ),
	);
}

/* =========================================================================
 * Bài học / câu hỏi anh tự thêm (Quản trị → Khu Sale)
 * ====================================================================== */

add_action(
	'init',
	static function () {
		register_post_type(
			HH_SALE_LESSON_TYPE,
			array(
				'labels'       => array( 'name' => 'Bài học sale', 'singular_name' => 'Bài học sale', 'add_new_item' => 'Thêm bài học', 'edit_item' => 'Sửa bài học', 'all_items' => 'Bài học sale' ),
				'public'       => false,
				'show_ui'      => true,
				'show_in_menu' => 'hh-khu-sale',
				'show_in_rest' => false,
				'supports'     => array( 'title', 'editor', 'page-attributes' ),
			)
		);
		register_post_type(
			HH_SALE_QUESTION_TYPE,
			array(
				'labels'       => array( 'name' => 'Câu hỏi kiểm tra', 'singular_name' => 'Câu hỏi kiểm tra', 'add_new_item' => 'Thêm câu hỏi', 'edit_item' => 'Sửa câu hỏi', 'all_items' => 'Câu hỏi kiểm tra' ),
				'public'       => false,
				'show_ui'      => true,
				'show_in_menu' => 'hh-khu-sale',
				'show_in_rest' => false,
				'supports'     => array( 'title' ),
			)
		);
	}
);

add_action(
	'add_meta_boxes_' . HH_SALE_QUESTION_TYPE,
	static function () {
		add_meta_box(
			'hh_q_box',
			'Đáp án',
			static function ( $post ) {
				wp_nonce_field( 'hh_q_box', 'hh_q_nonce' );
				$pid   = (int) get_post_meta( $post->ID, '_hh_q_project', true );
				$projs = get_posts( array( 'post_type' => 'du-an', 'post_status' => 'publish', 'numberposts' => -1, 'orderby' => 'title', 'order' => 'ASC' ) );
				echo '<p>Tiêu đề bài = câu hỏi. Mỗi dòng 1 đáp án, đặt dấu <code>*</code> trước đáp án đúng (2–6 đáp án, thứ tự tự xáo khi làm bài).</p>';
				echo '<textarea name="hh_q_opts" rows="6" style="width:100%" placeholder="*5% giá bán&#10;10% giá bán&#10;30% giá bán">' . esc_textarea( (string) get_post_meta( $post->ID, '_hh_q_opts', true ) ) . '</textarea>';
				echo '<p><label><b>Giải thích</b> (hiện sau khi chấm)</label><br><textarea name="hh_q_exp" rows="3" style="width:100%">' . esc_textarea( (string) get_post_meta( $post->ID, '_hh_q_exp', true ) ) . '</textarea></p>';
				echo '<p><label><b>Thuộc dự án</b> (tuỳ chọn – câu hiện cả trong bài kiểm tra riêng của dự án)</label><br><select name="hh_q_project"><option value="0">— Kiến thức chung —</option>';
				foreach ( $projs as $p ) {
					printf( '<option value="%d"%s>%s</option>', (int) $p->ID, selected( $pid, $p->ID, false ), esc_html( get_the_title( $p ) ) );
				}
				echo '</select></p>';
			},
			HH_SALE_QUESTION_TYPE,
			'normal',
			'high'
		);
	}
);
add_action(
	'save_post_' . HH_SALE_QUESTION_TYPE,
	static function ( $post_id ) {
		if ( ! isset( $_POST['hh_q_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['hh_q_nonce'] ), 'hh_q_box' ) || ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		update_post_meta( $post_id, '_hh_q_opts', sanitize_textarea_field( wp_unslash( $_POST['hh_q_opts'] ?? '' ) ) );
		update_post_meta( $post_id, '_hh_q_exp', sanitize_textarea_field( wp_unslash( $_POST['hh_q_exp'] ?? '' ) ) );
		update_post_meta( $post_id, '_hh_q_project', absint( $_POST['hh_q_project'] ?? 0 ) );
	}
);

/** Câu hỏi anh tự thêm → cùng dạng [câu, đúng, [sai], giải thích, link, nhóm]. */
function hh_sale_custom_questions( $project_id = 0 ) {
	$out = array();
	foreach ( get_posts( array( 'post_type' => HH_SALE_QUESTION_TYPE, 'post_status' => 'publish', 'numberposts' => -1 ) ) as $q ) {
		$pid = (int) get_post_meta( $q->ID, '_hh_q_project', true );
		if ( $project_id && $pid !== (int) $project_id ) {
			continue;
		}
		$right = '';
		$wrong = array();
		foreach ( preg_split( '/\R/u', (string) get_post_meta( $q->ID, '_hh_q_opts', true ) ) as $line ) {
			$line = trim( $line );
			if ( '' === $line ) {
				continue;
			}
			if ( '*' === $line[0] && '' === $right ) {
				$right = trim( substr( $line, 1 ) );
			} else {
				$wrong[] = ltrim( $line, '* ' );
			}
		}
		if ( '' === $right || ! $wrong ) {
			continue;
		}
		$out[] = array( get_the_title( $q ), $right, array_slice( $wrong, 0, 5 ), (string) get_post_meta( $q->ID, '_hh_q_exp', true ), $pid ? hh_sale_url( 'du-an/' . get_post_field( 'post_name', $pid ) ) : '', $pid ? get_the_title( $pid ) : 'Kiến thức chung' );
	}
	return $out;
}

/* =========================================================================
 * Câu hỏi tự sinh từ dữ liệu dự án (dữ liệu đổi → câu hỏi đổi)
 * ====================================================================== */

function hh_sale_project_facts() {
	static $facts = null;
	if ( null !== $facts ) {
		return $facts;
	}
	$facts = array();
	$ids   = get_posts( array( 'post_type' => 'du-an', 'post_status' => 'publish', 'numberposts' => -1, 'fields' => 'ids' ) );
	foreach ( $ids as $id ) {
		if ( function_exists( 'hh_is_noxh' ) && hh_is_noxh( $id ) ) {
			continue;
		}
		$g   = static fn( $k ) => trim( preg_replace( '/\s+/u', ' ', (string) get_post_meta( $id, $k, true ) ) );
		$cut = static fn( $s, $n = 90 ) => mb_strlen( $s ) > $n ? rtrim( mb_substr( $s, 0, $n ) ) . '…' : $s;
		$f   = array(
			'id'        => $id,
			'title'     => get_the_title( $id ),
			'slug'      => get_post_field( 'post_name', $id ),
			'featured'  => '1' === get_post_meta( $id, 'hh_p_featured', true ),
			'developer' => $cut( $g( 'hh_p_developer' ), 70 ),
			'address'   => $cut( $g( 'hh_p_address' ) ),
			'handover'  => $cut( $g( 'hh_p_handover' ), 60 ),
			'ownership' => $cut( $g( 'hh_p_ownership' ), 70 ),
			'price_m2'  => $cut( $g( 'hh_p_price_m2' ), 60 ),
			'units'     => $cut( $g( 'hh_p_units' ), 60 ),
			'floors'    => $cut( $g( 'hh_p_floors' ), 50 ),
			'offer'     => $cut( $g( 'hh_p_offer_title' ), 100 ),
			'faq'       => function_exists( 'hh_sale_pairs' ) ? hh_sale_pairs( (string) get_post_meta( $id, '_hh_sale_faq', true ) ) : array(),
			'builder'   => $cut( $g( 'hh_p_builder' ), 70 ),
			'conn'      => function_exists( 'hh_project_connections' ) ? array_values( array_filter( hh_project_connections( $id )[0], static fn( $r ) => '' !== $r[0] && '' !== $r[1] ) ) : array(),
			'amen'      => function_exists( 'hh_lines' ) ? array_map( static fn( $x ) => $cut( $x, 80 ), hh_lines( 'hh_p_amenities_in', $id ) ) : array(),
			'types'     => function_exists( 'hh_table' ) ? array_values( array_filter( hh_table( 'hh_p_unit_types', 4, $id ), static fn( $r ) => '' !== $r[0] && '' !== $r[1] ) ) : array(),
			'cdt_faq'   => array(),
		);
		if ( function_exists( 'hh_cdt_match' ) ) {
			foreach ( hh_cdt_match( (string) get_post_meta( $id, 'hh_p_developer', true ) ) as $cs ) {
				foreach ( (array) ( hh_cdt_all()[ $cs ]['faq'] ?? array() ) as $fq ) {
					if ( ! empty( $fq[0] ) && ! empty( $fq[1] ) ) {
						$f['cdt_faq'][] = array( wp_strip_all_tags( $fq[0] ), $cut( wp_strip_all_tags( $fq[1] ), 160 ), hh_cdt_all()[ $cs ]['name'] );
					}
				}
			}
		}
		$facts[ $id ] = $f;
	}
	return $facts;
}

/** Hai giá trị "giống nhau" (một chuỗi nằm trong chuỗi kia sau khi bỏ dấu) – tránh đáp án nhiễu thực ra cũng đúng. */
function hh_sale_same( $a, $b ) {
	$n = static fn( $s ) => trim( preg_replace( '/[^a-z0-9]+/', ' ', strtolower( remove_accents( (string) $s ) ) ) );
	$a = $n( $a );
	$b = $n( $b );
	if ( '' === $a || '' === $b ) {
		return false;
	}
	return $a === $b || false !== strpos( $a, $b ) || false !== strpos( $b, $a );
}

/** Bỏ các đáp án nhiễu trùng nghĩa nhau (giữ cái đầu). */
function hh_sale_distinct( $list ) {
	$out = array();
	foreach ( $list as $v ) {
		$dup = false;
		foreach ( $out as $o ) {
			$dup = $dup || hh_sale_same( $o, $v );
		}
		if ( ! $dup ) {
			$out[] = $v;
		}
	}
	return $out;
}

/** Một câu tự sinh cho dự án $f, loại $kind. Trả về null nếu không đủ dữ liệu / không đủ đáp án nhiễu. */
function hh_sale_gen_question( $f, $kind, $facts ) {
	$link = hh_sale_url( 'du-an/' . $f['slug'] );
	$labels = array(
		'developer' => array( 'Chủ đầu tư của dự án %s là ai?', 'Chủ đầu tư' ),
		'address'   => array( 'Dự án %s nằm ở đâu?', 'Địa chỉ' ),
		'handover'  => array( 'Dự án %s bàn giao dự kiến khi nào?', 'Bàn giao dự kiến' ),
		'ownership' => array( 'Hình thức sở hữu của %s là gì?', 'Hình thức sở hữu' ),
		'price_m2'  => array( 'Đơn giá tham khảo của %s là bao nhiêu?', 'Đơn giá tham khảo' ),
		'units'     => array( 'Dự án %s có tổng bao nhiêu sản phẩm?', 'Tổng sản phẩm' ),
		'floors'    => array( 'Dự án %s cao bao nhiêu tầng?', 'Số tầng' ),
		'offer'     => array( 'Ưu đãi nổi bật hiện tại của %s là gì?', 'Ưu đãi nổi bật' ),
		'builder'   => array( 'Nhà thầu thi công của %s là ai?', 'Nhà thầu thi công' ),
	);
	$pickfrom = static function ( $all, $right, $n = 3 ) {
		$all = array_values( array_unique( array_filter( $all, static fn( $v ) => '' !== $v && ! hh_sale_same( $v, $right ) ) ) );
		shuffle( $all );
		$all = hh_sale_distinct( $all );
		return count( $all ) >= $n ? array_slice( $all, 0, $n ) : null;
	};
	if ( 'conn' === $kind && $f['conn'] ) {
		$r     = $f['conn'][ array_rand( $f['conn'] ) ];
		$other = array();
		foreach ( $facts as $o ) {
			foreach ( $o['conn'] as $x ) {
				$other[] = $x[0];
			}
		}
		$w = $pickfrom( $other, $r[0] );
		return $w ? array( 'Từ ' . $f['title'] . ' đến ' . $r[1] . ' mất khoảng bao lâu / bao xa?', $r[0], $w, 'Liên kết vùng của ' . $f['title'] . ': ' . $r[0] . ' tới ' . $r[1] . '.', $link . '#san-pham', $f['title'] ) : null;
	}
	if ( 'amen' === $kind && count( $f['amen'] ) >= 2 ) {
		$r     = $f['amen'][ array_rand( $f['amen'] ) ];
		$other = array();
		foreach ( $facts as $o ) {
			if ( $o['id'] === $f['id'] ) {
				continue;
			}
			foreach ( $o['amen'] as $x ) {
				$in = false;
				foreach ( $f['amen'] as $mine ) {
					$in = $in || hh_sale_same( $mine, $x );
				}
				if ( ! $in ) {
					$other[] = $x;
				}
			}
		}
		$w = $pickfrom( $other, $r );
		return $w ? array( 'Tiện ích nội khu nào dưới đây CÓ ở ' . $f['title'] . '?', $r, $w, 'Tiện ích nội khu của ' . $f['title'] . ' gồm: ' . implode( '; ', array_slice( $f['amen'], 0, 6 ) ) . '.', $link . '#san-pham', $f['title'] ) : null;
	}
	if ( 'types' === $kind && $f['types'] ) {
		$r     = $f['types'][ array_rand( $f['types'] ) ];
		$other = array();
		foreach ( $facts as $o ) {
			foreach ( $o['types'] as $x ) {
				$other[] = $x[1];
			}
		}
		$w = $pickfrom( $other, $r[1] );
		return $w ? array( 'Loại căn "' . $r[0] . '" của ' . $f['title'] . ' có diện tích khoảng bao nhiêu?', $r[1], $w, $f['title'] . ' – ' . $r[0] . ': ' . $r[1] . ( $r[3] ? ', giá tham khảo ' . $r[3] : '' ) . '.', $link . '#mat-bang', $f['title'] ) : null;
	}
	if ( 'cdt_faq' === $kind && $f['cdt_faq'] ) {
		$r     = $f['cdt_faq'][ array_rand( $f['cdt_faq'] ) ];
		$same  = array();
		$other = array();
		foreach ( $f['cdt_faq'] as $x ) {
			if ( $x[0] !== $r[0] && $x[2] === $r[2] ) {
				$same[] = $x[1];
			}
		}
		foreach ( $facts as $o ) {
			foreach ( $o['cdt_faq'] as $x ) {
				if ( $x[2] !== $r[2] ) {
					$other[] = $x[1];
				}
			}
		}
		shuffle( $same );
		shuffle( $other );
		$w = $pickfrom( array_merge( $same, $other ), $r[1] );
		if ( $w && $same ) {
			$w = array_slice( hh_sale_distinct( array_merge( array_filter( $same, static fn( $v ) => ! hh_sale_same( $v, $r[1] ) ), $w ) ), 0, 3 );
		}
		return $w ? array( 'Khách hỏi về chủ đầu tư ' . $r[2] . ': "' . $r[0] . '" – trả lời đúng là?', $r[1], $w, 'Theo hồ sơ chủ đầu tư ' . $r[2] . ' trên web.', $link . '#chu-dau-tu', 'Chủ đầu tư ' . $r[2] ) : null;
	}
	if ( 'faq' === $kind ) {
		if ( ! $f['faq'] ) {
			return null;
		}
		$pick  = $f['faq'][ array_rand( $f['faq'] ) ];
		$other = array();
		foreach ( $facts as $o ) {
			foreach ( $o['faq'] as $p ) {
				if ( $p[1] && $p[1] !== $pick[1] ) {
					$other[] = $p[1];
				}
			}
		}
		$other = array_values( array_unique( $other ) );
		if ( count( $other ) < 2 || '' === $pick[1] ) {
			return null;
		}
		shuffle( $other );
		return array( 'Khách hỏi về ' . $f['title'] . ': "' . $pick[0] . '" – trả lời đúng là?', $pick[1], array_slice( $other, 0, 3 ), 'Theo mục "Khách hay hỏi – cách trả lời" của ' . $f['title'] . '.', $link, $f['title'] );
	}
	if ( 'reverse' === $kind ) {
		if ( '' === $f['developer'] ) {
			return null;
		}
		$wrong = array();
		foreach ( $facts as $o ) {
			if ( $o['developer'] && ! hh_sale_same( $o['developer'], $f['developer'] ) ) {
				$wrong[ $o['title'] ] = 1;
			}
		}
		$wrong = array_keys( $wrong );
		if ( count( $wrong ) < 3 ) {
			return null;
		}
		shuffle( $wrong );
		return array( 'Dự án nào dưới đây do ' . $f['developer'] . ' làm chủ đầu tư?', $f['title'], array_slice( $wrong, 0, 3 ), $f['title'] . ' – chủ đầu tư: ' . $f['developer'] . '.', $link, $f['title'] );
	}
	if ( ! isset( $labels[ $kind ] ) || '' === $f[ $kind ] ) {
		return null;
	}
	$wrong = array();
	foreach ( $facts as $o ) {
		$v = $o[ $kind ];
		if ( '' !== $v && ! hh_sale_same( $v, $f[ $kind ] ) ) {
			$wrong[ $v ] = 1;
		}
	}
	$wrong = array_keys( $wrong );
	shuffle( $wrong );
	$wrong = hh_sale_distinct( $wrong );
	if ( count( $wrong ) < 3 ) {
		return null;
	}
	$anc = array( 'developer' => '#chu-dau-tu', 'builder' => '#chu-dau-tu', 'price_m2' => '#chinh-sach', 'offer' => '#chinh-sach' );
	return array( sprintf( $labels[ $kind ][0], $f['title'] ), $f[ $kind ], array_slice( $wrong, 0, 3 ), $labels[ $kind ][1] . ' của ' . $f['title'] . ': ' . $f[ $kind ] . '.', $link . ( $anc[ $kind ] ?? '#san-pham' ), $f['title'] );
}

/**
 * Bộ câu cho một lượt kiểm tra: $n câu, trộn câu dự án (ưu tiên dự án trọng điểm) + kiến thức chung + câu tự thêm.
 * $project_id: chỉ hỏi về dự án đó (kèm vài câu chung nếu thiếu).
 */
function hh_sale_build_quiz( $n = 10, $project_id = 0 ) {
	$facts = hh_sale_project_facts();
	$kinds = array( 'developer', 'address', 'handover', 'ownership', 'price_m2', 'units', 'floors', 'offer', 'faq', 'faq', 'reverse', 'builder', 'conn', 'conn', 'amen', 'amen', 'types', 'types', 'cdt_faq' );
	$pool  = array();
	$core  = array();
	foreach ( hh_sale_core_questions() as $q ) {
		$core[] = array( $q[0], $q[1], $q[2], $q[3], hh_sale_url( 'dao-tao/' . $q[4] ), 'Kiến thức chung' );
	}
	$custom = hh_sale_custom_questions( $project_id );
	if ( $project_id && isset( $facts[ $project_id ] ) ) {
		foreach ( $kinds as $k ) {
			$q = hh_sale_gen_question( $facts[ $project_id ], $k, $facts );
			if ( $q ) {
				$pool[ md5( $q[0] ) ] = $q;
			}
		}
		$pool = array_values( $pool );
		$pool = array_merge( $pool, $custom );
		shuffle( $pool );
		if ( count( $pool ) < $n ) {
			shuffle( $core );
			$pool = array_merge( $pool, array_slice( $core, 0, $n - count( $pool ) ) );
		}
		return array_slice( $pool, 0, $n );
	}
	// Chung: khoảng 50% câu dự án, 35% kiến thức chung, phần còn lại câu tự thêm.
	$feat = array_values( array_filter( $facts, static fn( $f ) => $f['featured'] ) );
	$rest = array_values( array_filter( $facts, static fn( $f ) => ! $f['featured'] ) );
	$want = (int) ceil( $n * 0.5 );
	$tries = 0;
	$seen  = array();
	while ( count( $pool ) < $want && $tries++ < 80 && $facts ) {
		$src = ( $feat && mt_rand( 1, 100 ) <= 70 ) ? $feat : ( $rest ?: $feat );
		$f   = $src[ array_rand( $src ) ];
		$q   = hh_sale_gen_question( $f, $kinds[ array_rand( $kinds ) ], $facts );
		if ( $q && ! isset( $seen[ $q[0] ] ) ) {
			$seen[ $q[0] ] = 1;
			$pool[]        = $q;
		}
	}
	shuffle( $custom );
	$pool = array_merge( $pool, array_slice( $custom, 0, max( 1, (int) floor( $n * 0.15 ) ) ) );
	shuffle( $core );
	$pool = array_merge( $pool, array_slice( $core, 0, max( 0, $n - count( $pool ) ) ) );
	shuffle( $pool );
	return array_slice( $pool, 0, $n );
}

/* =========================================================================
 * Trang Đào tạo
 * ====================================================================== */

function hh_sale_view_training( $slug = '' ) {
	$core = hh_sale_core_lessons();
	if ( $slug ) {
		$title = '';
		$body  = '';
		$group = '';
		if ( isset( $core[ $slug ] ) ) {
			list( $title, $group, $body ) = $core[ $slug ];
		} else {
			$p = get_page_by_path( $slug, OBJECT, HH_SALE_LESSON_TYPE );
			if ( $p && 'publish' === $p->post_status ) {
				$title = get_the_title( $p );
				$group = 'Bài của anh Hiệp';
				$body  = apply_filters( 'the_content', $p->post_content ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals
			}
		}
		if ( '' === $title ) {
			echo '<h1>Không tìm thấy bài học</h1><p><a href="' . esc_url( hh_sale_url( 'dao-tao' ) ) . '">← Tất cả bài học</a></p>';
			return 'Đào tạo';
		}
		$done = (array) get_user_meta( get_current_user_id(), 'hh_sale_lessons_read', true );
		if ( ! isset( $done[ $slug ] ) ) {
			$done[ $slug ] = time();
			update_user_meta( get_current_user_id(), 'hh_sale_lessons_read', $done );
		}
		echo '<p style="margin:16px 0 0"><a href="' . esc_url( hh_sale_url( 'dao-tao' ) ) . '">← Tất cả bài học</a></p>';
		echo '<section class="hero" style="padding:20px 22px"><p style="color:#ffb38a;font-weight:700;font-size:13px;letter-spacing:.08em;text-transform:uppercase">' . esc_html( $group ) . '</p><h1 style="margin-top:4px">' . esc_html( $title ) . '</h1>' . ( function_exists( 'hh_sale_slide' ) ? '<div class="acts"><a class="hl" href="' . esc_url( hh_sale_url( 'slide/bai-' . $slug ) ) . '" target="_blank" rel="noopener">▶ Trình chiếu bài này</a></div>' : '' ) . '</section>';
		echo '<div class="box lesson">' . wp_kses_post( $body ) . '</div>';
		echo '<div class="box" style="display:flex;gap:10px;flex-wrap:wrap;align-items:center"><b>Đọc xong?</b> <a class="btn" href="' . esc_url( hh_sale_url( 'kiem-tra' ) ) . '">Làm bài kiểm tra 10 câu</a> <a class="btn g" href="' . esc_url( hh_sale_url( 'dao-tao' ) ) . '">Bài khác</a></div>';
		return $title;
	}
	$done   = (array) get_user_meta( get_current_user_id(), 'hh_sale_lessons_read', true );
	$custom = get_posts( array( 'post_type' => HH_SALE_LESSON_TYPE, 'post_status' => 'publish', 'numberposts' => -1, 'orderby' => 'menu_order title', 'order' => 'ASC' ) );
	$total  = count( $core ) + count( $custom );
	$read   = count( array_intersect( array_keys( $done ), array_merge( array_keys( $core ), wp_list_pluck( $custom, 'post_name' ) ) ) );
	echo '<section class="hero"><h1>Đào tạo sale</h1><p>Đọc lần lượt các bài, mỗi bài 3–5 phút. Đã đọc <b>' . (int) $read . '/' . (int) $total . '</b> bài. Học xong làm <b>Kiểm tra</b> – câu hỏi đổi mỗi lượt và tự cập nhật theo dữ liệu dự án.</p><div class="acts"><a class="hl" href="' . esc_url( hh_sale_url( 'kiem-tra' ) ) . '">Làm bài kiểm tra</a><a href="' . esc_url( hh_sale_url( 'du-an' ) ) . '">Học từng dự án</a></div></section>';
	$groups = array();
	foreach ( $core as $k => $l ) {
		$groups[ $l[1] ][] = array( $k, $l[0], wp_trim_words( wp_strip_all_tags( $l[2] ), 22 ) );
	}
	foreach ( $custom as $p ) {
		$groups['Bài của anh Hiệp'][] = array( $p->post_name, get_the_title( $p ), wp_trim_words( wp_strip_all_tags( $p->post_content ), 22 ) );
	}
	$i = 0;
	foreach ( $groups as $g => $items ) {
		echo '<div class="box"><h2>' . esc_html( $g ) . '</h2><div class="grid">';
		foreach ( $items as $it ) {
			++$i;
			printf(
				'<a class="card" href="%s" style="padding:14px 16px"><b>%d. %s</b><span>%s</span><br>%s</a>',
				esc_url( hh_sale_url( 'dao-tao/' . $it[0] ) ),
				(int) $i,
				esc_html( $it[1] ),
				esc_html( $it[2] ),
				isset( $done[ $it[0] ] ) ? '<span class="pill g">Đã đọc</span>' : '<span class="pill o">Chưa đọc</span>'
			);
		}
		echo '</div></div>';
	}
	echo '<div class="box"><h2>Học từng dự án</h2><p>Mỗi dự án có trang tóm tắt riêng (thông tin, điểm bán hàng, giá, chính sách, câu khách hay hỏi) và nút <b>Kiểm tra dự án này</b>. <a href="' . esc_url( hh_sale_url( 'du-an' ) ) . '">Mở danh sách dự án →</a></p></div>';
	if ( hh_sale_is_admin() ) {
		echo '<p class="note">Quản trị: thêm bài ở <a href="' . esc_url( admin_url( 'edit.php?post_type=' . HH_SALE_LESSON_TYPE ) ) . '">Bài học sale</a>, thêm câu hỏi ở <a href="' . esc_url( admin_url( 'edit.php?post_type=' . HH_SALE_QUESTION_TYPE ) ) . '">Câu hỏi kiểm tra</a>.</p>';
	}
	return 'Đào tạo';
}

/* =========================================================================
 * Kiểm tra: tạo đề, chấm điểm, lưu kết quả
 * ====================================================================== */

function hh_sale_view_quiz() {
	$uid = get_current_user_id();
	// Kết quả vừa chấm.
	$kq = sanitize_key( $_GET['kq'] ?? '' ); // phpcs:ignore WordPress.Security.NonceVerification
	if ( $kq ) {
		$res = get_transient( 'hh_quiz_res_' . $uid . '_' . $kq );
		if ( $res ) {
			$pct = $res['total'] ? (int) round( 100 * $res['score'] / $res['total'] ) : 0;
			$msg = $pct >= 90 ? 'Xuất sắc! Bạn nắm rất chắc.' : ( $pct >= 70 ? 'Khá tốt – xem lại các câu sai bên dưới.' : 'Cần ôn thêm – đọc lại bài học / trang dự án ở link dưới mỗi câu sai.' );
			echo '<section class="hero"><h1>' . (int) $res['score'] . '/' . (int) $res['total'] . ' câu đúng (' . (int) $pct . '%)</h1><p>' . esc_html( $msg ) . '</p><div class="acts"><a class="hl" href="' . esc_url( hh_sale_url( 'kiem-tra' ) . ( $res['project'] ? '?du-an=' . rawurlencode( $res['project'] ) : '' ) ) . '">Làm lượt mới (câu hỏi khác)</a><a href="' . esc_url( hh_sale_url( 'dao-tao' ) ) . '">Ôn bài học</a></div></section>';
			foreach ( $res['items'] as $i => $it ) {
				$ok = $it['ok'];
				echo '<div class="box" style="border-left:4px solid ' . ( $ok ? '#16a34a' : '#dc2626' ) . '"><p style="margin:0 0 6px"><b>' . (int) ( $i + 1 ) . '. ' . esc_html( $it['q'] ) . '</b> <span class="pill">' . esc_html( $it['topic'] ) . '</span></p>';
				echo '<p style="margin:0">' . ( $ok ? '✅ Đúng: ' : '❌ Bạn chọn: <s>' . esc_html( $it['chosen'] ?: '(bỏ trống)' ) . '</s><br>✔️ Đáp án đúng: ' ) . '<b>' . esc_html( $it['right'] ) . '</b></p>';
				if ( $it['exp'] || $it['link'] ) {
					echo '<p class="note" style="margin:6px 0 0">' . esc_html( $it['exp'] ) . ( $it['link'] ? ' <a href="' . esc_url( $it['link'] ) . '">Xem lại →</a>' : '' ) . '</p>';
				}
				echo '</div>';
			}
			return;
		}
	}
	$slug = sanitize_title( wp_unslash( $_GET['du-an'] ?? '' ) ); // phpcs:ignore WordPress.Security.NonceVerification
	$pid  = 0;
	if ( $slug ) {
		$p   = get_page_by_path( $slug, OBJECT, 'du-an' );
		$pid = $p ? $p->ID : 0;
	}
	$qs = hh_sale_build_quiz( 10, $pid );
	if ( ! $qs ) {
		echo '<div class="box"><p class="note">Chưa đủ dữ liệu để tạo đề.</p></div>';
		return;
	}
	$key   = strtolower( wp_generate_password( 12, false ) );
	$store = array( 'project' => $slug, 'items' => array() );
	echo '<section class="hero" style="padding:20px 22px"><h1>' . ( $pid ? 'Kiểm tra: ' . esc_html( get_the_title( $pid ) ) : 'Kiểm tra kiến thức' ) . '</h1><p>10 câu bốc ngẫu nhiên – mỗi lượt một đề khác, câu hỏi dự án tự cập nhật theo dữ liệu mới nhất. Chọn 1 đáp án mỗi câu rồi bấm Nộp bài.</p></section>';
	echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
	wp_nonce_field( 'hh_quiz_' . $key, 'n' );
	echo '<input type="hidden" name="action" value="hh_sale_quiz"><input type="hidden" name="k" value="' . esc_attr( $key ) . '">';
	foreach ( $qs as $i => $q ) {
		$opts = array_merge( array( $q[1] ), array_values( $q[2] ) );
		$opts = array_values( array_unique( $opts ) );
		shuffle( $opts );
		$store['items'][] = array( 'q' => $q[0], 'right' => $q[1], 'opts' => $opts, 'exp' => $q[3], 'link' => $q[4], 'topic' => $q[5] );
		echo '<div class="box"><p style="margin:0 0 10px"><b>' . (int) ( $i + 1 ) . '. ' . esc_html( $q[0] ) . '</b> <span class="pill">' . esc_html( $q[5] ) . '</span></p>';
		foreach ( $opts as $j => $o ) {
			printf( '<label style="display:flex;gap:10px;align-items:flex-start;padding:9px 12px;border:1.5px solid #e3e8ef;border-radius:10px;margin:6px 0;cursor:pointer"><input type="radio" name="a[%d]" value="%d" style="margin-top:4px"> <span>%s</span></label>', (int) $i, (int) $j, esc_html( $o ) );
		}
		echo '</div>';
	}
	echo '<p><button class="btn" style="font-size:16px;padding:12px 26px">Nộp bài</button></p></form>';
	set_transient( 'hh_quiz_' . $uid . '_' . $key, $store, 3 * HOUR_IN_SECONDS );
	echo "<script>document.querySelectorAll('.box label').forEach(function(l){l.querySelector('input').addEventListener('change',function(){l.parentNode.querySelectorAll('label').forEach(function(x){x.style.borderColor='#e3e8ef';x.style.background=''});l.style.borderColor='#f2551d';l.style.background='#fff7f2'})})</script>";
}

add_action(
	'admin_post_hh_sale_quiz',
	static function () {
		$uid = get_current_user_id();
		$key = sanitize_key( $_POST['k'] ?? '' );
		if ( ! hh_sale_can() || ! $key || ! isset( $_POST['n'] ) || ! wp_verify_nonce( sanitize_key( $_POST['n'] ), 'hh_quiz_' . $key ) ) {
			wp_die( 'Phiên làm bài đã hết hạn – mở lại trang Kiểm tra.' );
		}
		$store = get_transient( 'hh_quiz_' . $uid . '_' . $key );
		if ( ! $store ) {
			wp_safe_redirect( hh_sale_url( 'kiem-tra' ) );
			exit;
		}
		delete_transient( 'hh_quiz_' . $uid . '_' . $key );
		$ans   = array_map( 'intval', (array) wp_unslash( $_POST['a'] ?? array() ) );
		$score = 0;
		$items = array();
		$wrong = array();
		foreach ( $store['items'] as $i => $it ) {
			$chosen = isset( $ans[ $i ] ) ? (string) ( $it['opts'][ $ans[ $i ] ] ?? '' ) : '';
			$ok     = '' !== $chosen && $chosen === $it['right'];
			$score += $ok ? 1 : 0;
			if ( ! $ok ) {
				$wrong[] = $it['topic'];
			}
			$items[] = $it + array( 'chosen' => $chosen, 'ok' => $ok );
		}
		$total = count( $store['items'] );
		$log   = array_values( array_filter( (array) get_user_meta( $uid, 'hh_sale_quiz_log', true ) ) );
		$log[] = array( time(), $score, $total, (string) $store['project'], array_slice( array_count_values( $wrong ), 0, 10, true ) );
		update_user_meta( $uid, 'hh_sale_quiz_log', array_slice( $log, -200 ) );
		set_transient( 'hh_quiz_res_' . $uid . '_' . $key, array( 'score' => $score, 'total' => $total, 'items' => $items, 'project' => $store['project'] ), DAY_IN_SECONDS );
		wp_safe_redirect( add_query_arg( 'kq', $key, hh_sale_url( 'kiem-tra' ) ) );
		exit;
	}
);

/** Tóm tắt điểm kiểm tra của 1 sale trong kỳ (cho bảng Báo cáo): "TB 82% · 5 lượt · gần nhất 9/10". */
function hh_sale_quiz_summary( $uid, $from = 0 ) {
	$log = array_values( array_filter( (array) get_user_meta( $uid, 'hh_sale_quiz_log', true ), static fn( $r ) => is_array( $r ) && (int) $r[0] >= (int) $from ) );
	if ( ! $log ) {
		return 'Chưa làm';
	}
	$pct  = array_map( static fn( $r ) => $r[2] ? 100 * $r[1] / $r[2] : 0, $log );
	$last = end( $log );
	return 'TB ' . (int) round( array_sum( $pct ) / count( $pct ) ) . '% · ' . count( $log ) . ' lượt · gần nhất ' . (int) $last[1] . '/' . (int) $last[2];
}

/* =========================================================================
 * Tổng quan: "Câu hỏi hôm nay" (đổi mỗi ngày, mỗi sale một câu khác)
 * ====================================================================== */

function hh_sale_daily_box() {
	$seed = crc32( wp_date( 'Y-m-d' ) . '|' . get_current_user_id() );
	mt_srand( $seed ); // phpcs:ignore WordPress.WP.AlternativeFunctions
	$qs = hh_sale_build_quiz( 1 );
	mt_srand(); // phpcs:ignore WordPress.WP.AlternativeFunctions
	if ( ! $qs ) {
		return;
	}
	$q    = $qs[0];
	$opts = array_values( array_unique( array_merge( array( $q[1] ), $q[2] ) ) );
	usort( $opts, static fn( $a, $b ) => crc32( $a . $seed ) <=> crc32( $b . $seed ) );
	echo '<div class="box" id="hhdq"><h2>Câu hỏi hôm nay</h2><p style="margin:0 0 8px"><b>' . esc_html( $q[0] ) . '</b></p>';
	foreach ( $opts as $o ) {
		printf( '<button type="button" class="dq" data-ok="%d" style="display:block;width:100%%;text-align:left;margin:6px 0;padding:10px 12px;border:1.5px solid #e3e8ef;border-radius:10px;background:#fff;font:inherit;cursor:pointer">%s</button>', $o === $q[1] ? 1 : 0, esc_html( $o ) );
	}
	echo '<p class="note dqx" style="display:none;margin-top:8px">' . esc_html( $q[3] ) . ( $q[4] ? ' <a href="' . esc_url( $q[4] ) . '">Xem lại →</a>' : '' ) . '</p><p style="margin:10px 0 0"><a class="btn s" href="' . esc_url( hh_sale_url( 'kiem-tra' ) ) . '">Làm bài kiểm tra 10 câu</a></p></div>';
	echo "<script>(function(){var b=document.querySelectorAll('#hhdq .dq');b.forEach(function(x){x.addEventListener('click',function(){b.forEach(function(y){y.disabled=true;if(y.dataset.ok==='1'){y.style.borderColor='#16a34a';y.style.background='#e8f7ee'}});if(x.dataset.ok!=='1'){x.style.borderColor='#dc2626';x.style.background='#fdecea'}document.querySelector('#hhdq .dqx').style.display='block'})})})()</script>";
}

/* Nút "Kiểm tra dự án này" trên trang Học dự án. */
add_action(
	'hh_sale_project_bottom',
	static function ( $slug ) {
		echo '<div class="box" style="display:flex;gap:10px;flex-wrap:wrap;align-items:center"><b>Nắm chắc dự án này chưa?</b> <a class="btn" href="' . esc_url( add_query_arg( 'du-an', $slug, hh_sale_url( 'kiem-tra' ) ) ) . '">Kiểm tra dự án này</a></div>';
	}
);
