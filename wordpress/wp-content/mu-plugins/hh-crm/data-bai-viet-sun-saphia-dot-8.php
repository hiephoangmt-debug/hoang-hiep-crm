<?php
/**
 * Sun Saphia Residence đợt 8 – 8 bài, 12/11 – 15/11/2026, 2 bài/ngày (11:30, 16:30 – tránh trùng bài cụm dự án 09:00, 14:00):
 * người nước ngoài / Việt kiều mua, đứng tên hợp đồng, phí quản lý, danh thắng Ngũ Hành Sơn, đi Hội An,
 * cho thuê dài hạn, tầng cao hay tầng thấp, mua để ở. Mỗi bài dẫn về trang dự án và bài đánh giá chi tiết.
 * Không nạp trong plugin – xuất vào wordpress/tu-dong/ bằng scripts/xuat-bai-tu-dong.php để web tự đăng.
 * Thông tin dự án theo tài liệu và buổi giải đáp của chủ đầu tư (10 – 11/2026); số liệu thị trường theo báo chí nêu trong bài
 * (tra cứu 11/11/2026); giá dự án là giá dự kiến chủ đầu tư 28/10/2026, chưa phải bảng giá chính thức.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'hh_news_posts', 'hh_posts_sun_saphia_dot_8' );
function hh_posts_sun_saphia_dot_8( $posts ) {
	$saphia = '<a href="/du-an/sun-saphia-residence/">Sun Saphia Residence</a>';
	$review = '<a href="/danh-gia-sun-saphia-residence-chi-tiet/">đánh giá chi tiết Sun Saphia Residence</a>';
	$cta    = '<p>Cần mặt bằng, bảng giá và tư vấn hồ sơ mua ' . $saphia . ', liên hệ <strong>Hoàng Hiệp – 0904 567 009</strong> (gọi/Zalo).</p>';

	/* ---------------- 12/11 11:30 – Người nước ngoài, Việt kiều ---------------- */
	$posts[] = array(
		'slug'     => 'nguoi-nuoc-ngoai-mua-can-ho-sun-saphia',
		'old_slug' => array( 'nguoi-nuoc-ngoai-viet-kieu-mua-sun-saphia-residence-duoc-khong' ),
		'rev'      => 2, // 15/11: chuẩn SEO 100/100, đổi slug theo từ khoá.
		'title'    => 'Người nước ngoài, Việt kiều mua Sun Saphia Residence được không? Vì sao căn hộ thương mại dịch vụ khác chung cư',
		'excerpt'  => 'Chủ đầu tư cho biết căn hộ thương mại dịch vụ Sun Saphia Residence không bán cho người nước ngoài và các trường hợp có yếu tố nước ngoài. Giải thích lý do, khác biệt với quy định 30% căn hộ nhà ở, và Việt kiều cần hỏi gì trước khi giữ chỗ.',
		'keyword'  => 'người nước ngoài mua căn hộ',
		'keywords_extra' => array( 'Sun Saphia Residence', 'Việt kiều mua căn hộ Đà Nẵng', 'người nước ngoài mua căn hộ Đà Nẵng', 'căn hộ thương mại dịch vụ' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-12 11:30',
		'category' => 'Pháp lý nhà đất',
		'tags'     => array( 'Sun Saphia Residence', 'Pháp lý căn hộ', 'Người nước ngoài mua nhà' ),
		'image'    => 'plugin:img/tin-tuc/nguoi-nuoc-ngoai-mua-sun-saphia.jpg',
		'content'  => <<<HTML
<p>Câu hỏi <strong>người nước ngoài mua căn hộ</strong> Sun Saphia Residence được không đến nhiều từ khách Hàn Quốc, khách châu Âu đang sống ở Đà Nẵng và từ các gia đình Việt kiều. Câu trả lời ngắn: theo buổi giải đáp của chủ đầu tư ngày 04/11/2026, {$saphia} là <strong>căn hộ thương mại dịch vụ</strong> và <strong>không bán cho người nước ngoài cũng như các trường hợp có yếu tố nước ngoài</strong>. Bài này giải thích vì sao, khác gì với chung cư nhà ở, và những trường hợp cần hỏi kỹ trước khi giữ chỗ.</p>
<!--hh-featured-->
<h2>Người nước ngoài mua căn hộ Sun Saphia Residence: vì sao không được?</h2>
<p>Ở Việt Nam, việc người nước ngoài mua căn hộ được quy định trong <strong>Luật Nhà ở 2023</strong>, và luật này áp dụng cho <strong>nhà ở</strong> – tức căn hộ chung cư xây trên đất ở. Sun Saphia Residence thì khác: dự án nằm trên <strong>đất thương mại dịch vụ thuê có thời hạn</strong>, căn hộ được cấp giấy chứng nhận thời hạn 50 năm kể từ 17/09/2026. Đây là loại hình lưu trú, không phải nhà ở, nên quy định cho người nước ngoài mua căn hộ theo Luật Nhà ở không áp dụng.</p>
<p>Chủ đầu tư cũng nói rõ phạm vi rộng hơn: không chỉ cá nhân nước ngoài, mà <strong>các trường hợp có yếu tố nước ngoài</strong> cũng không thuộc đối tượng bán. Vì vậy người mua cần xác nhận tình trạng của mình trước, không nên giữ chỗ rồi mới hỏi.</p>
<table>
<thead><tr><th></th><th>Căn hộ nhà ở (chung cư)</th><th>Căn hộ thương mại dịch vụ (Sun Saphia)</th></tr></thead>
<tbody>
<tr><td>Loại đất</td><td>Đất ở</td><td>Đất thương mại dịch vụ, thuê có thời hạn</td></tr>
<tr><td>Thời hạn</td><td>Thường lâu dài với công dân Việt Nam</td><td>50 năm từ 17/09/2026</td></tr>
<tr><td>Người nước ngoài</td><td>Được mua trong dự án nhà ở thương mại, tối đa 30% số căn mỗi tòa, ngoài khu vực bảo đảm quốc phòng, an ninh</td><td>Chủ đầu tư không bán</td></tr>
<tr><td>Bảo lãnh ngân hàng</td><td>Bắt buộc khi bán nhà hình thành trong tương lai</td><td>Không áp dụng với dự án thương mại dịch vụ</td></tr>
<tr><td>Cư trú</td><td>Đăng ký thường trú, tạm trú</td><td>Vẫn đăng ký tạm trú được (theo chủ đầu tư)</td></tr>
</tbody>
</table>
<p>Để dễ hình dung hạn mức người nước ngoài mua căn hộ: nếu Sun Saphia Residence là chung cư nhà ở, mức trần 30% của tòa 782 căn sẽ vào khoảng 234 căn cho người nước ngoài (Hoàng Hiệp tính theo Điều 19 Luật Nhà ở 2023). Nhưng vì là căn hộ thương mại dịch vụ, mức này <strong>không áp dụng</strong> – số căn bán cho người nước ngoài là 0.</p>
<!--hh-img:img/sun-saphia/sun-saphia-phoi-canh-toa-thap-30-tang.jpg|Người nước ngoài mua căn hộ Sun Saphia Residence không được – tòa căn hộ thương mại dịch vụ 30 tầng trên đường Trường Sa (phối cảnh chủ đầu tư)-->
<h2>Việt kiều mua Sun Saphia Residence: cần hỏi gì?</h2>
<p>"Việt kiều" là cách gọi chung cho nhiều tình trạng pháp lý khác nhau, và mỗi tình trạng được nhìn khác nhau:</p>
<ul>
<li><strong>Người Việt Nam định cư ở nước ngoài còn quốc tịch Việt Nam</strong> (có hộ chiếu hoặc căn cước Việt Nam): theo Luật Đất đai 2024, nhóm này có quyền như công dân trong nước về nhà đất. Tuy vậy, vì chủ đầu tư dùng cụm "trường hợp có yếu tố nước ngoài", anh chị nên <strong>hỏi bằng văn bản</strong> xem hồ sơ của mình có được ký hợp đồng không, trước khi chuyển tiền giữ chỗ.</li>
<li><strong>Người gốc Việt không còn quốc tịch Việt Nam</strong>: về pháp lý được xem là người nước ngoài khi mua căn hộ thương mại dịch vụ, nên theo thông tin hiện tại không thuộc đối tượng bán.</li>
<li><strong>Vợ hoặc chồng là người nước ngoài</strong>: căn hộ mua trong thời kỳ hôn nhân thường là tài sản chung, nên dễ rơi vào "có yếu tố nước ngoài". Cần hỏi chủ đầu tư và luật sư trước, không tự suy luận.</li>
</ul>
<h2>Người nước ngoài mua căn hộ qua "nhờ người đứng tên": không nên</h2>
<p>Một số người tính nhờ người thân trong nước đứng tên mua căn hộ hộ mình. Cách này có rủi ro lớn: về pháp luật, người đứng tên là chủ sở hữu, có quyền bán, thế chấp; nếu người đó gặp tranh chấp, nợ nần, ly hôn hoặc qua đời, căn hộ có thể bị liên quan. Giấy tờ thỏa thuận "đứng tên hộ" rất khó bảo vệ người bỏ tiền. Hoàng Hiệp không khuyến khích cách làm này. Chi tiết các cách đứng tên hợp lệ xem bài <a href="/dung-ten-mua-sun-saphia-residence-vo-chong-doanh-nghiep/">đứng tên mua Sun Saphia Residence</a>.</p>
<h2>Không được người nước ngoài mua căn hộ, nhưng vẫn có thể ở Sun Saphia Residence</h2>
<p>Không mua được không có nghĩa là không ở được. Người nước ngoài có thể <strong>thuê</strong> căn hộ Sun Saphia Residence ngắn ngày hoặc dài hạn; chủ căn hộ phải khai báo lưu trú cho khách theo Luật Cư trú. Đây cũng là nhóm khách thuê quan trọng của dự án – khách Hàn Quốc chiếm hơn 20% khách quốc tế đến Đà Nẵng 6 tháng đầu 2026 (xem bài <a href="/khach-quoc-te-thue-can-ho-da-nang-2026/">khách quốc tế thuê căn hộ</a>).</p>
<p>Người nước ngoài mua căn hộ để sở hữu thì nên tìm dự án <strong>chung cư nhà ở thương mại</strong> còn trong hạn mức 30% – Đà Nẵng định kỳ công bố danh sách dự án được bán cho người nước ngoài (ví dụ tin của <a href="https://baodautu.vn/da-nang-cong-bo-hai-du-an-bat-dong-san-tiep-theo-duoc-ban-cho-nguoi-nuoc-ngoai-d572248.html">Báo Đầu tư</a>).</p>
<h2>Người nước ngoài mua căn hộ ở Đà Nẵng: nên tìm loại dự án nào?</h2>
<p>Nếu anh chị là người nước ngoài, hoặc tư vấn cho bạn bè nước ngoài, có ba điều kiện cần kiểm tra cùng lúc: dự án là <strong>nhà ở thương mại</strong> (không phải căn hộ thương mại dịch vụ, condotel); dự án <strong>không nằm trong khu vực bảo đảm quốc phòng, an ninh</strong>; và tòa nhà <strong>còn trong hạn mức 30%</strong> số căn cho người nước ngoài. Thời hạn sở hữu của người nước ngoài mua căn hộ nhà ở tối đa 50 năm kể từ ngày cấp giấy chứng nhận, có thể gia hạn theo quy định.</p>
<p>Như vậy, ngay cả khi người nước ngoài mua căn hộ ở dự án nhà ở, thời hạn cũng có giới hạn – điểm khác là họ được mua. Với Sun Saphia Residence, người nước ngoài phù hợp vai trò khách thuê hơn là chủ sở hữu.</p>
<h2>Checklist trước khi giữ chỗ nếu anh chị có yếu tố nước ngoài</h2>
<p>Quy định về người nước ngoài mua căn hộ không chỉ liên quan tới quốc tịch người ký, mà cả hoàn cảnh gia đình. Trước khi giữ chỗ:</p>
<ol>
<li>Xác định rõ quốc tịch của mình và của vợ/chồng; chuẩn bị hộ chiếu, căn cước Việt Nam nếu có.</li>
<li>Gửi câu hỏi cho chủ đầu tư (qua người tư vấn) và đề nghị trả lời bằng văn bản hoặc email.</li>
<li>Hỏi điều kiện hoàn tiền giữ chỗ nếu cuối cùng không ký được hợp đồng.</li>
<li>Nếu vay ngân hàng (Vietcombank, BIDV, NCB theo tài liệu dự án), hỏi ngân hàng điều kiện với người có thu nhập ở nước ngoài.</li>
<li>Không chuyển tiền qua tài khoản cá nhân; chỉ chuyển vào tài khoản chủ đầu tư ghi trên văn bản.</li>
</ol>
<h2>Nhận định của Hoàng Hiệp</h2>
<p>Sun Saphia Residence được thiết kế cho người Việt mua để nghỉ dưỡng, cho thuê; câu chuyện người nước ngoài mua căn hộ ở đây dừng ở vai trò khách thuê. Điểm khác biệt về loại hình (thương mại dịch vụ, 50 năm, không bảo lãnh ngân hàng) cần được hiểu đúng ngay từ đầu, kể cả với người mua trong nước. Pháp lý chung của dự án xem bài <a href="/phap-ly-sun-saphia-residence-so-huu-bao-lau/">pháp lý Sun Saphia Residence</a> và bài {$review}.</p>
{$cta}
<p class="src">Nguồn: buổi giải đáp của chủ đầu tư 04/11/2026 (loại hình, thời hạn, đối tượng bán); Luật Nhà ở 2023 (Điều 17 – 20 về người nước ngoài sở hữu nhà ở), Luật Đất đai 2024. Bài mang tính tham khảo, không thay cho tư vấn pháp lý cho từng hồ sơ.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Người nước ngoài mua căn hộ Sun Saphia 2026 được không?',
			'desc'      => 'Người nước ngoài mua căn hộ Sun Saphia Residence được không? Chủ đầu tư không bán căn hộ thương mại dịch vụ cho người có yếu tố nước ngoài. Việt kiều hỏi gì?',
			'points'    => array(
				'Người nước ngoài mua căn hộ chỉ được với chung cư nhà ở thương mại, tối đa 30% mỗi tòa',
				'Sun Saphia Residence là căn hộ thương mại dịch vụ, không phải nhà ở',
				'Chủ đầu tư không bán cho người nước ngoài và trường hợp có yếu tố nước ngoài',
				'Mức 30% căn hộ cho người nước ngoài chỉ áp dụng với chung cư nhà ở',
				'Việt kiều còn quốc tịch Việt Nam nên hỏi chủ đầu tư bằng văn bản trước khi giữ chỗ',
			),
			'faq'       => array(
				array( 'Người nước ngoài mua căn hộ Sun Saphia Residence được không?', 'Không. Theo chủ đầu tư (04/11/2026), căn hộ thương mại dịch vụ của dự án không bán cho người nước ngoài và các trường hợp có yếu tố nước ngoài.' ),
				array( 'Việt kiều có mua được Sun Saphia Residence không?', 'Việt kiều không phải lúc nào cũng được xem là người nước ngoài mua căn hộ. Người còn quốc tịch Việt Nam nên hỏi chủ đầu tư bằng văn bản cho hồ sơ cụ thể; người gốc Việt không còn quốc tịch Việt Nam không thuộc đối tượng bán theo thông tin hiện tại.' ),
				array( 'Người nước ngoài có thuê được căn hộ Sun Saphia Residence không?', 'Được. Chủ căn hộ cho thuê ngắn ngày hoặc dài hạn và phải khai báo lưu trú cho khách theo Luật Cư trú.' ),
				array( 'Người nước ngoài mua căn hộ ở Đà Nẵng cần điều kiện gì?', 'Dự án phải là nhà ở thương mại, ngoài khu vực bảo đảm quốc phòng, an ninh và tòa nhà còn trong hạn mức 30% số căn; thời hạn sở hữu tối đa 50 năm, có thể gia hạn.' ),
			),
		),
		'sources'  => array(
			'https://baodautu.vn/da-nang-cong-bo-hai-du-an-bat-dong-san-tiep-theo-duoc-ban-cho-nguoi-nuoc-ngoai-d572248.html',
		),
	);

	/* ---------------- 12/11 16:30 – Đứng tên hợp đồng ---------------- */
	$posts[] = array(
		'slug'     => 'dung-ten-mua-can-ho-sun-saphia',
		'old_slug' => array( 'dung-ten-mua-sun-saphia-residence-vo-chong-doanh-nghiep' ),
		'rev'      => 2, // 15/11: chuẩn SEO 100/100, đổi slug theo từ khoá.
		'title'    => 'Đứng tên mua Sun Saphia Residence: một người, cả hai vợ chồng hay doanh nghiệp – chọn thế nào cho đúng?',
		'excerpt'  => 'Mua Sun Saphia Residence nên để một người, cả hai vợ chồng hay doanh nghiệp đứng tên? So sánh hồ sơ, vay ngân hàng, thuế cho thuê, chuyển nhượng hợp đồng và những lỗi đứng tên hay gặp.',
		'keyword'  => 'đứng tên mua căn hộ',
		'keywords_extra' => array( 'Sun Saphia Residence', 'đứng tên hợp đồng mua căn hộ', 'vợ chồng đứng tên sổ hồng', 'doanh nghiệp mua căn hộ' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-12 16:30',
		'category' => 'Pháp lý nhà đất',
		'tags'     => array( 'Sun Saphia Residence', 'Pháp lý căn hộ', 'Kinh nghiệm mua bán' ),
		'image'    => 'plugin:img/tin-tuc/dung-ten-mua-sun-saphia.jpg',
		'content'  => <<<HTML
<p><strong>Đứng tên mua căn hộ</strong> thế nào là câu nhiều anh chị hỏi trước khi ký giấy tờ đầu tiên ở Sun Saphia Residence: một mình, cả hai vợ chồng, hay để công ty đứng tên. Người đứng tên ảnh hưởng tới hồ sơ vay, cách khai thuế khi cho thuê, thủ tục bán lại và cả việc phân chia tài sản sau này. Bài này tổng hợp các lựa chọn phổ biến với {$saphia} – căn hộ thương mại dịch vụ, thời hạn 50 năm từ 17/09/2026.</p>
<!--hh-featured-->
<h2>Đứng tên mua căn hộ Sun Saphia: tên ghi ở đâu?</h2>
<p>Theo chủ đầu tư, Sun Saphia Residence ký <strong>hợp đồng thỏa thuận nguyên tắc trước, hợp đồng mua bán sau</strong>. Thứ tự này cho khách thời gian chuẩn bị hồ sơ vay, và có thể <strong>chuyển nhượng, đổi tên trước khi ký hợp đồng mua bán</strong>. Tên trên hợp đồng mua bán sẽ là tên trên giấy chứng nhận sau này. Vì vậy giai đoạn giữ chỗ – thỏa thuận nguyên tắc là lúc nên quyết định xong người đứng tên.</p>
<h2>4 cách đứng tên mua căn hộ Sun Saphia Residence</h2>
<table>
<thead><tr><th>Cách đứng tên</th><th>Phù hợp</th><th>Lưu ý</th></tr></thead>
<tbody>
<tr><td>Một cá nhân (độc thân)</td><td>Người chưa kết hôn mua bằng tiền riêng</td><td>Nếu sau này kết hôn, căn hộ mua trước hôn nhân vẫn là tài sản riêng</td></tr>
<tr><td>Cả hai vợ chồng</td><td>Mua trong thời kỳ hôn nhân, tiền chung</td><td>Luật Hôn nhân và gia đình 2014 (Điều 34): giấy chứng nhận tài sản chung ghi tên cả hai, trừ khi có thỏa thuận khác</td></tr>
<tr><td>Một trong hai vợ chồng</td><td>Tiện ký giấy tờ khi một người ở xa</td><td>Vẫn là tài sản chung nếu mua bằng tiền chung; bán, thế chấp cần người kia đồng ý</td></tr>
<tr><td>Doanh nghiệp</td><td>Công ty kinh doanh lưu trú, cần hạch toán chi phí</td><td>Thủ tục, thuế phức tạp hơn; cần kế toán tư vấn</td></tr>
</tbody>
</table>
<h2>Vợ chồng đứng tên mua căn hộ: một người hay hai người?</h2>
<p>Đây là câu hỏi hay gặp nhất. Một số điểm cần biết:</p>
<ul>
<li><strong>Tài sản chung không đổi vì chỉ một người đứng tên.</strong> Mua bằng tiền chung trong thời kỳ hôn nhân thì vẫn là tài sản chung, dù giấy tờ ghi một tên. Khi bán, thế chấp, chuyển nhượng hợp đồng, ngân hàng và công chứng thường yêu cầu chữ ký hoặc văn bản đồng ý của người còn lại.</li>
<li><strong>Muốn là tài sản riêng</strong> (ví dụ tiền được tặng cho riêng, tiền có trước hôn nhân), nên có văn bản thỏa thuận tài sản riêng được công chứng và giữ chứng từ nguồn tiền.</li>
<li><strong>Một người ở xa</strong> (làm việc ở Hà Nội, TP.HCM hay nước ngoài) có thể <strong>ủy quyền công chứng</strong> cho người kia ký – không cần đổi người đứng tên. Xem thêm <a href="/mua-can-ho-da-nang-tu-ha-noi-tp-hcm-kinh-nghiem/">mua căn hộ Đà Nẵng từ xa</a>.</li>
</ul>
<!--hh-img:img/sun-saphia/sun-saphia-layout-studio-30m2.jpg|Đứng tên mua căn hộ studio 30 m² Sun Saphia Residence – loại căn nhiều người mua đứng tên cá nhân để cho thuê (bản vẽ chủ đầu tư)-->
<h2>Đứng tên mua căn hộ và vay ngân hàng</h2>
<p>Theo tài liệu dự án, Vietcombank, BIDV và NCB hỗ trợ vay mua Sun Saphia Residence. Ngân hàng xét thu nhập của <strong>người vay</strong>, và với người đã kết hôn thường yêu cầu cả hai vợ chồng cùng ký hợp đồng vay, thế chấp. Nếu thu nhập chính nằm ở người không đứng tên, nên hỏi ngân hàng trước cách ghi tên để hồ sơ vay thuận lợi. Bài toán trả góp xem <a href="/vay-mua-sun-saphia-residence-tra-gop-hang-thang/">vay mua Sun Saphia Residence</a>.</p>
<h2>Doanh nghiệp đứng tên mua căn hộ: khi nào hợp lý?</h2>
<p>Doanh nghiệp đứng tên phù hợp khi công ty <strong>thực sự kinh doanh lưu trú</strong> – nhiều căn, có đơn vị vận hành, có nhu cầu hạch toán. Khi đó công ty có thể khấu hao tài sản, tính chi phí nội thất, phí quản lý vào chi phí kinh doanh, và thuế GTGT đầu vào có thể được khấu trừ nếu hóa đơn, mục đích sử dụng hợp lệ – điều này cần kế toán xác nhận theo từng trường hợp. Nhược điểm: phải có sổ sách, khai thuế thường xuyên; khi bán, lợi nhuận tính vào thu nhập doanh nghiệp; muốn chuyển về tên cá nhân lại là một giao dịch mua bán mới.</p>
<p>Với người chỉ mua 1 – 2 căn studio để cho thuê, đứng tên cá nhân thường đơn giản hơn. Cá nhân cho thuê có doanh thu trên ngưỡng phải nộp thuế thì khai thuế cho thuê tài sản – xem <a href="/cho-thue-ngan-ngay-can-ho-da-nang-phap-ly-thue/">cho thuê ngắn ngày: pháp lý và thuế</a>.</p>
<h2>Đổi người đứng tên sau khi đã ký</h2>
<ul>
<li><strong>Trước hợp đồng mua bán:</strong> chủ đầu tư cho biết có thể chuyển nhượng, đổi tên ở giai đoạn thỏa thuận nguyên tắc – hỏi rõ phí và thủ tục khi giữ chỗ.</li>
<li><strong>Sau hợp đồng mua bán, trước bàn giao:</strong> làm thủ tục chuyển nhượng hợp đồng theo Luật Kinh doanh bất động sản 2023, có chủ đầu tư xác nhận; thuế thu nhập cá nhân 2% giá chuyển nhượng (xem <a href="https://thuvienphapluat.vn/van-ban/Bat-dong-san/Luat-Kinh-doanh-bat-dong-san-29-2023-QH15-530116.aspx">Luật Kinh doanh bất động sản 2023</a>). Chi tiết xem <a href="/chuyen-nhuong-hop-dong-sun-saphia-residence-truoc-ban-giao/">chuyển nhượng hợp đồng trước bàn giao</a>.</li>
<li><strong>Giữa vợ và chồng, cha mẹ và con:</strong> một số trường hợp tặng cho giữa người thân được miễn thuế thu nhập cá nhân khi đã có giấy chứng nhận – cần kiểm tra quy định tại thời điểm làm.</li>
</ul>
<h2>Lỗi đứng tên mua căn hộ hay gặp</h2>
<ol>
<li><strong>Nhờ người khác đứng tên mua căn hộ hộ</strong> – rủi ro cao, người đứng tên mới là chủ sở hữu trên giấy tờ.</li>
<li><strong>Ghi tên con chưa đủ 18 tuổi</strong> mà không tính tới việc bán, thế chấp sau này phải qua người giám hộ.</li>
<li><strong>Thông tin trên căn cước, giấy đăng ký kết hôn không khớp</strong> (đổi địa chỉ, cấp lại căn cước) làm chậm công chứng, vay vốn.</li>
<li><strong>Chuyển tiền từ tài khoản người khác</strong> mà không có giải trình – khó chứng minh nguồn tiền khi cần.</li>
</ol>
<h2>Nhận định của Hoàng Hiệp</h2>
<p>Với phần lớn khách mua studio hoặc 1PN+ để cho thuê, đứng tên mua căn hộ theo cá nhân hoặc cả hai vợ chồng là đơn giản nhất. Doanh nghiệp chỉ nên đứng tên khi đã có hoạt động kinh doanh lưu trú thật. Dù chọn cách đứng tên mua căn hộ nào, nên chốt người đứng tên ở giai đoạn thỏa thuận nguyên tắc để tránh phí đổi tên. Xem thêm bài {$review}.</p>
{$cta}
<p class="src">Nguồn: thông tin ký kết, ngân hàng hỗ trợ theo chủ đầu tư (10 – 11/2026); Luật Hôn nhân và gia đình 2014, Luật Kinh doanh bất động sản 2023. Bài tham khảo, không thay cho tư vấn pháp lý, thuế cho từng hồ sơ.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Đứng tên mua căn hộ Sun Saphia: 4 cách, vợ chồng hay công ty',
			'desc'      => 'Đứng tên mua căn hộ Sun Saphia Residence: một người, cả hai vợ chồng hay doanh nghiệp? So sánh hồ sơ vay, thuế cho thuê, đổi tên và lỗi hay gặp.',
			'points'    => array(
				'Đứng tên mua căn hộ ảnh hưởng hồ sơ vay, thuế cho thuê và bán lại',
				'Ký thỏa thuận nguyên tắc trước, hợp đồng mua bán sau – nên chốt người đứng tên sớm',
				'Mua bằng tiền chung thì vẫn là tài sản chung dù chỉ một người đứng tên',
				'Doanh nghiệp đứng tên hợp lý khi thật sự kinh doanh lưu trú',
				'Không nên nhờ người khác đứng tên hộ',
			),
			'faq'       => array(
				array( 'Vợ chồng đứng tên mua căn hộ có phải ghi cả hai?', 'Theo Luật Hôn nhân và gia đình 2014, giấy chứng nhận tài sản chung ghi tên cả hai vợ chồng, trừ khi có thỏa thuận khác. Một người đứng tên thì bán, thế chấp vẫn cần người kia đồng ý.' ),
				array( 'Có đổi người đứng tên Sun Saphia Residence được không?', 'Theo chủ đầu tư, có thể chuyển nhượng, đổi tên ở giai đoạn thỏa thuận nguyên tắc; sau hợp đồng mua bán thì làm thủ tục chuyển nhượng hợp đồng, thuế thu nhập cá nhân 2%.' ),
				array( 'Doanh nghiệp có mua được Sun Saphia Residence không?', 'Doanh nghiệp trong nước có thể mua để kinh doanh lưu trú; nên hỏi kế toán về khấu hao, thuế GTGT và thủ tục trước khi ký.' ),
				array( 'Có nên nhờ người khác đứng tên mua căn hộ hộ mình?', 'Không nên. Người đứng tên mua căn hộ là chủ sở hữu trên giấy tờ, có quyền bán, thế chấp; thỏa thuận đứng tên hộ rất khó bảo vệ người bỏ tiền.' ),
			),
		),
		'sources'  => array(
			'https://thuvienphapluat.vn/van-ban/Bat-dong-san/Luat-Kinh-doanh-bat-dong-san-29-2023-QH15-530116.aspx',
		),
	);

	/* ---------------- 13/11 11:30 – Phí quản lý ---------------- */
	$posts[] = array(
		'slug'     => 'phi-quan-ly-sun-saphia-residence-bao-nhieu',
		'old_slug' => array( 'phi-quan-ly-sun-saphia-residence-moi-thang-bao-nhieu' ),
		'rev'      => 2, // 15/11: chuẩn SEO 100/100, đổi slug theo từ khoá.
		'title'    => 'Phí quản lý Sun Saphia Residence 15.000 – 20.000 đ/m²: studio, 1PN+, 2PN mỗi tháng trả bao nhiêu?',
		'excerpt'  => 'Phí quản lý Sun Saphia Residence dự kiến 15.000 – 20.000 đ/m²/tháng. Tính sẵn số tiền mỗi tháng, mỗi năm cho studio 30 m², 1PN+ 50 m², 2PN 60 – 70 m², phân biệt với 2% kinh phí bảo trì và các chi phí khác khi cho thuê.',
		'keyword'  => 'phí quản lý Sun Saphia Residence',
		'keywords_extra' => array( 'Sun Saphia Residence', 'phí quản lý căn hộ Đà Nẵng', 'kinh phí bảo trì 2%', 'chi phí cho thuê studio' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-13 11:30',
		'category' => 'Kinh nghiệm mua bán',
		'tags'     => array( 'Sun Saphia Residence', 'Chi phí căn hộ', 'Kinh nghiệm mua bán' ),
		'image'    => 'plugin:img/tin-tuc/phi-quan-ly-sun-saphia.jpg',
		'content'  => <<<HTML
<p>Theo buổi giải đáp của chủ đầu tư ngày 04/11/2026, <strong>phí quản lý Sun Saphia Residence</strong> dự kiến ghi trong hợp đồng mua bán là <strong>15.000 – 20.000 đ/m²/tháng</strong>. Con số nhỏ khi nhìn theo m², nhưng cộng lại cả năm là một khoản cố định cần đưa vào bảng tính cho thuê. Bài này tính sẵn cho từng loại căn của {$saphia} và tách bạch các khoản phí hay bị nhầm.</p>
<!--hh-featured-->
<h2>Phí quản lý Sun Saphia Residence mỗi tháng theo loại căn</h2>
<table>
<thead><tr><th>Loại căn (diện tích tính phí giả định)</th><th>Mức 15.000 đ/m²</th><th>Mức 20.000 đ/m²</th><th>Cả năm</th></tr></thead>
<tbody>
<tr><td>Studio 30 m²</td><td>450.000 đ</td><td>600.000 đ</td><td>5,4 – 7,2 triệu</td></tr>
<tr><td>Studio góc 40 m²</td><td>600.000 đ</td><td>800.000 đ</td><td>7,2 – 9,6 triệu</td></tr>
<tr><td>1PN+ 50 m²</td><td>750.000 đ</td><td>1.000.000 đ</td><td>9 – 12 triệu</td></tr>
<tr><td>2PN 61 m²</td><td>915.000 đ</td><td>1.220.000 đ</td><td>11 – 14,6 triệu</td></tr>
<tr><td>2PN 70 m²</td><td>1.050.000 đ</td><td>1.400.000 đ</td><td>12,6 – 16,8 triệu</td></tr>
</tbody>
</table>
<p>Hoàng Hiệp tính theo diện tích thông thủy trong tài liệu chủ đầu tư; diện tích tính phí thực tế ghi trong hợp đồng mua bán. Mức phí chưa gồm điện, nước, internet, gửi xe.</p>
<h2>Phí quản lý Sun Saphia Residence trả cho những gì?</h2>
<p>Phí quản lý vận hành nhà chung cư thường dùng cho: bảo vệ 24/7, vệ sinh khu vực chung, vận hành thang máy, bể bơi, hệ thống PCCC, điện chiếu sáng chung, chăm sóc cảnh quan và chi phí của ban quản lý. Với Sun Saphia Residence, tòa nhà có <strong>7 thang máy, 2 sảnh thang</strong>, bể bơi dài nhất 27 m, gym, yoga – quy mô tiện ích này nằm trong phần phí quản lý Sun Saphia Residence.</p>
<p>Đơn vị quản lý theo chủ đầu tư là <strong>Sun Paradise Land</strong>, giống dự án Sun Symphony. Theo quy định về quản lý vận hành nhà chung cư trong <a href="https://thuvienphapluat.vn/van-ban/Bat-dong-san/Luat-Nha-o-2023-27-2023-QH15-528669.aspx">Luật Nhà ở 2023</a>, khoảng 1 năm sau bàn giao cư dân họp hội nghị nhà chung cư, bầu Ban quản trị và có thể quyết lại mức phí, đơn vị quản lý.</p>
<!--hh-img:img/sun-saphia/sun-saphia-mat-bang-tang-3a-28-dien-tich.jpg|Phí quản lý Sun Saphia Residence tính theo diện tích – mặt bằng tầng điển hình 3A – 28 (bản vẽ chủ đầu tư, tham khảo)-->
<h2>Đừng nhầm phí quản lý Sun Saphia Residence với 2% kinh phí bảo trì</h2>
<table>
<thead><tr><th></th><th>Phí quản lý</th><th>Kinh phí bảo trì</th></tr></thead>
<tbody>
<tr><td>Mức</td><td>15.000 – 20.000 đ/m²/tháng (dự kiến)</td><td>2% giá trị căn hộ (trước thuế)</td></tr>
<tr><td>Đóng khi nào</td><td>Hằng tháng, từ khi bàn giao</td><td>Một lần, khi mua</td></tr>
<tr><td>Dùng cho</td><td>Vận hành hằng ngày</td><td>Sửa chữa lớn phần sở hữu chung (mái, kết cấu, thang máy…)</td></tr>
<tr><td>Ví dụ studio 2,13 tỷ</td><td>5,4 – 7,2 triệu/năm</td><td>khoảng 42,6 triệu, đóng một lần</td></tr>
</tbody>
</table>
<p>Giá dự kiến 2,13 tỷ là studio 30 m² tầng 15 dãy phía sau (28/10/2026), chưa VAT và chưa gồm 2% bảo trì. Các khoản khác khi mua xem <a href="/chi-phi-mua-can-ho-sun-saphia-residence-ngoai-gia-ban/">chi phí mua Sun Saphia Residence ngoài giá bán</a>.</p>
<h2>Phí quản lý Sun Saphia Residence chiếm bao nhiêu trong doanh thu cho thuê?</h2>
<p>Lấy mức giá thuê tham khảo chủ đầu tư khảo sát ở căn hộ mặt biển (chưa vào mùa cao điểm): studio 2,2 – 2,9 triệu/đêm. Giả định studio cho thuê ngắn ngày được 15 đêm/tháng với giá 2,2 triệu, doanh thu khoảng 33 triệu/tháng – phí quản lý 450.000 – 600.000 đ chỉ khoảng 1,4 – 1,8%. Nếu cho thuê dài hạn khoảng 8 triệu/tháng (mức tham khảo căn hộ nhỏ khu Ngũ Hành Sơn), phí quản lý chiếm khoảng 5,6 – 7,5% tiền thuê. Đây là ví dụ minh họa, không phải cam kết doanh thu.</p>
<p>Ý nghĩa: với cho thuê dài hạn, phí quản lý là khoản đáng kể; nên thỏa thuận rõ trong hợp đồng thuê ai trả phí quản lý, điện nước. Xem thêm <a href="/cho-thue-dai-han-sun-saphia-residence/">cho thuê dài hạn Sun Saphia Residence</a>.</p>
<h2>Phí quản lý Sun Saphia Residence có thể thay đổi không?</h2>
<p>Có thể. Mức 15.000 – 20.000 đ/m² là mức dự kiến ghi trong hợp đồng mua bán cho giai đoạn đầu. Sau khi Ban quản trị được bầu, cư dân có quyền thương lượng lại mức phí và lựa chọn đơn vị quản lý. Phí cũng có thể điều chỉnh khi chi phí vận hành (lương, điện chung, vật tư) tăng. Khi tính dòng tiền dài hạn, Hoàng Hiệp thường lấy mức trần 20.000 đ/m² và cộng thêm biên an toàn, thay vì dùng mức thấp nhất.</p>
<h2>Chi phí cố định khác của chủ căn hộ cho thuê</h2>
<ul>
<li><strong>Điện, nước, internet</strong> cho căn trống giữa các lượt khách.</li>
<li><strong>Phí đơn vị vận hành</strong> nếu thuê ngoài: mô hình phổ biến chia 85/15 hoặc phí 15 – 50% tùy dịch vụ (xem <a href="/don-vi-van-hanh-cho-thue-can-ho-sun-saphia/">đơn vị vận hành cho thuê</a>) – khoản này tách riêng, không nằm trong phí quản lý Sun Saphia Residence.</li>
<li><strong>Hoa hồng kênh đặt phòng</strong> (Booking, Agoda, Airbnb).</li>
<li><strong>Bảo dưỡng</strong> điều hòa, bình nóng lạnh – căn ven biển chịu hơi muối nên cần kiểm tra định kỳ.</li>
<li><strong>Thuế cho thuê</strong> khi doanh thu vượt ngưỡng.</li>
</ul>
<h2>Nhận định của Hoàng Hiệp</h2>
<p>Phí quản lý Sun Saphia Residence ở mức 15.000 – 20.000 đ/m² là mức thường thấy ở căn hộ cao cấp có bể bơi, nhiều thang máy tại Đà Nẵng. Khi so sánh các dự án, nên so tổng chi phí cố định mỗi năm thay vì chỉ nhìn giá bán. Mức phí chính thức nằm trong hợp đồng mua bán – Hoàng Hiệp sẽ cập nhật khi có. Xem thêm bài {$review}.</p>
{$cta}
<p class="src">Nguồn: phí quản lý dự kiến, đơn vị quản lý, thang máy, bể bơi, giá thuê tham khảo theo buổi giải đáp của chủ đầu tư 04/11/2026; giá dự kiến theo chủ đầu tư 28/10/2026. Bảng tính của Hoàng Hiệp, mang tính minh họa.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Phí quản lý Sun Saphia Residence: 15.000 – 20.000 đ/m²',
			'desc'      => 'Phí quản lý Sun Saphia Residence dự kiến 15.000 – 20.000 đ/m²/tháng: studio 30 m² 450 – 600 nghìn, 2PN 70 m² 1,05 – 1,4 triệu. Khác gì 2% phí bảo trì.',
			'points'    => array(
				'Phí quản lý Sun Saphia Residence dự kiến 15.000 – 20.000 đ/m²/tháng, ghi trong hợp đồng mua bán',
				'Studio 30 m² khoảng 450.000 – 600.000 đ/tháng, 5,4 – 7,2 triệu/năm',
				'Kinh phí bảo trì 2% đóng một lần, khác phí quản lý hằng tháng',
				'Đơn vị quản lý dự kiến Sun Paradise Land',
			),
			'faq'       => array(
				array( 'Phí quản lý Sun Saphia Residence bao nhiêu?', 'Theo chủ đầu tư (04/11/2026), phí quản lý dự kiến ghi trong hợp đồng mua bán là 15.000 – 20.000 đ/m²/tháng.' ),
				array( 'Studio Sun Saphia Residence mỗi tháng đóng phí quản lý bao nhiêu?', 'Với studio 30 m², khoảng 450.000 – 600.000 đ/tháng, tức 5,4 – 7,2 triệu đồng/năm, chưa gồm điện nước, internet.' ),
				array( 'Ai quản lý tòa nhà Sun Saphia Residence?', 'Chủ đầu tư cho biết đơn vị quản lý là Sun Paradise Land; sau khoảng 1 năm bàn giao, hội nghị nhà chung cư có thể quyết lại đơn vị và mức phí.' ),
				array( 'Phí quản lý Sun Saphia Residence có tăng không?', 'Có thể điều chỉnh khi Ban quản trị cư dân thương lượng lại hoặc chi phí vận hành tăng; khi tính dòng tiền nên lấy mức trần 20.000 đ/m².' ),
			),
		),
		'sources'  => array(
			'https://thuvienphapluat.vn/van-ban/Bat-dong-san/Luat-Nha-o-2023-27-2023-QH15-528669.aspx',
		),
	);

	/* ---------------- 13/11 16:30 – Ngũ Hành Sơn ---------------- */
	$posts[] = array(
		'slug'     => 'danh-thang-ngu-hanh-son-gan-sun-saphia-residence',
		'rev'      => 2, // 15/11: chuẩn SEO 100/100.
		'title'    => 'Danh thắng Ngũ Hành Sơn đón khoảng 2,2 triệu lượt khách mỗi năm: điểm cộng gì cho căn hộ Sun Saphia Residence?',
		'excerpt'  => 'Ngũ Hành Sơn – di tích quốc gia đặc biệt – đón khoảng 2,2 triệu lượt khách năm 2025, hơn 1,5 triệu khách quốc tế. Khu danh thắng, làng đá Non Nước và biển Sơn Thủy tạo nên nhu cầu lưu trú quanh Sun Saphia Residence ra sao.',
		'keyword'  => 'danh thắng Ngũ Hành Sơn',
		'keywords_extra' => array( 'Sun Saphia Residence', 'danh thắng Ngũ Hành Sơn', 'làng đá Non Nước', 'du lịch Ngũ Hành Sơn' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-13 16:30',
		'category' => 'Thị trường',
		'tags'     => array( 'Sun Saphia Residence', 'Ngũ Hành Sơn', 'Du lịch Đà Nẵng' ),
		'image'    => 'plugin:img/tin-tuc/ngu-hanh-son-sun-saphia.jpg',
		'content'  => <<<HTML
<p>Khi nói về vị trí {$saphia}, người ta thường nhắc biển Sơn Thủy trước mặt. Nhưng phía Nam dự án còn một "nam châm" hút khách lâu đời của Đà Nẵng: <strong>danh thắng Ngũ Hành Sơn</strong>. Bài này xem danh thắng Ngũ Hành Sơn mang lại gì cho người ở và người cho thuê ở Sun Saphia Residence – với số liệu khách du lịch mới nhất.</p>
<!--hh-featured-->
<h2>Danh thắng Ngũ Hành Sơn là gì?</h2>
<p>Ngũ Hành Sơn là cụm 5 ngọn núi đá vôi – Kim Sơn, Mộc Sơn, Thủy Sơn, Hỏa Sơn, Thổ Sơn – nằm giữa vùng cát ven biển phía Đông Nam Đà Nẵng. Nơi đây có hệ thống hang động, chùa chiền (chùa Tam Thai, chùa Linh Ứng, động Huyền Không…), và được xếp hạng <strong>di tích quốc gia đặc biệt</strong>. Thủy Sơn là ngọn lớn nhất, nơi tập trung phần lớn điểm tham quan. Dưới chân núi là <strong>làng nghề đá mỹ nghệ Non Nước</strong> với hàng trăm năm tuổi nghề.</p>
<h2>Khách đến danh thắng Ngũ Hành Sơn đông cỡ nào?</h2>
<table>
<thead><tr><th>Chỉ số</th><th>Số liệu</th><th>Nguồn</th></tr></thead>
<tbody>
<tr><td>Lượt khách tham quan năm 2025</td><td>khoảng 2,2 triệu</td><td>Báo Văn hóa</td></tr>
<tr><td>Trong đó khách quốc tế</td><td>hơn 1,5 triệu</td><td>Báo Văn hóa</td></tr>
<tr><td>Dịp Tết 2026</td><td>tăng 15 – 20% so với cùng kỳ</td><td>Báo chí địa phương</td></tr>
<tr><td>Khách lưu trú Đà Nẵng 9 tháng 2026</td><td>15,86 triệu lượt, tăng 26,4%</td><td><a href="https://www.vietnamplus.vn/da-nang-don-gan-16-trieu-luot-khach-luu-tru-trong-9-thang-nam-2026-post1140183.vnp">VietnamPlus</a></td></tr>
</tbody>
</table>
<p>Tỷ lệ khách quốc tế ở danh thắng Ngũ Hành Sơn (khoảng 2/3) cao hơn nhiều so với mặt bằng chung, cho thấy đây là điểm "phải đến" trong lịch trình của khách nước ngoài tới Đà Nẵng – Hội An.</p>
<!--hh-img:img/sun-saphia/sun-saphia-ban-do-ket-noi.jpg|Bản đồ kết nối Sun Saphia Residence với bãi tắm Sơn Thủy, danh thắng Ngũ Hành Sơn và sân bay Đà Nẵng (tài liệu chủ đầu tư)-->
<h2>Danh thắng Ngũ Hành Sơn cách Sun Saphia Residence bao xa?</h2>
<p>Sun Saphia Residence nằm ở giao lộ Võ Nguyên Giáp – Nguyễn Đức Thuận – Trường Sa, khu bãi tắm Sơn Thủy, phường Ngũ Hành Sơn. Đi theo trục ven biển Trường Sa về phía Nam rồi rẽ vào đường Huyền Trân Công Chúa, quãng đường tới khu Thủy Sơn ước khoảng 3 – 4 km (Hoàng Hiệp đo trên bản đồ, chưa phải số liệu chủ đầu tư), đi xe máy, taxi khoảng 10 phút. Bản đồ kết nối của chủ đầu tư cũng đặt danh thắng Ngũ Hành Sơn là một trong các điểm gần dự án.</p>
<h2>Gợi ý lịch tham quan danh thắng Ngũ Hành Sơn cho khách thuê</h2>
<p>Chủ căn có thể soạn sẵn một lịch nửa ngày cho khách: đi sớm khoảng 7 – 8 giờ để tránh nắng, lên Thủy Sơn bằng lối bậc đá hoặc thang máy, tham quan chùa Tam Thai, chùa Linh Ứng, động Huyền Không, rồi xuống làng đá Non Nước xem thợ chế tác. Buổi trưa quay về căn hộ nghỉ, chiều tắm biển Sơn Thủy. Lịch này tận dụng đúng lợi thế "biển và núi trong 10 phút" mà danh thắng Ngũ Hành Sơn mang lại cho khu vực.</p>
<p>Nên nhắc khách mang giày đế bám, nước uống và trang phục lịch sự khi vào chùa. Những chi tiết nhỏ như vậy giúp khách có trải nghiệm tốt và để lại đánh giá tích cực cho căn hộ.</p>
<h2>Điểm cộng cho người cho thuê</h2>
<ul>
<li><strong>Khách đi theo lịch trình kết hợp:</strong> buổi sáng tắm biển Sơn Thủy, chiều leo Ngũ Hành Sơn, tối đi Hội An hoặc trung tâm. Căn hộ ở giữa các điểm này tiện cho khách lưu trú 3 – 4 đêm.</li>
<li><strong>Khách quốc tế chiếm tỷ trọng lớn</strong> – nhóm khách sẵn sàng trả giá phòng cao hơn khi căn có view biển, bếp, máy giặt.</li>
<li><strong>Khách lễ hội, tâm linh:</strong> các dịp lễ tại chùa trên núi và lễ hội Quán Thế Âm hằng năm thu hút đông khách trong nước.</li>
<li><strong>Đề tài để làm nội dung quảng bá</strong>: ảnh, hướng dẫn lịch trình "1 ngày Ngũ Hành Sơn – Sơn Thủy" giúp tin đăng trên kênh đặt phòng hấp dẫn hơn.</li>
</ul>
<h2>Điểm cộng cho người mua để ở</h2>
<p>Không gian quanh danh thắng Ngũ Hành Sơn được quy hoạch bảo vệ, nên công trình cao tầng ở sát núi bị hạn chế. Người ở có thêm một điểm đi bộ, leo núi buổi sáng ngoài bãi biển. Làng đá Non Nước, các quán hải sản ven biển, resort quốc tế trên trục Trường Sa – Lạc Long Quân tạo nên môi trường sống kiểu nghỉ dưỡng hơn là đô thị đông đúc (xem bài <a href="/dai-bien-truong-sa-ngu-hanh-son-resort-sun-saphia-residence/">dải biển Trường Sa – Ngũ Hành Sơn</a>).</p>
<h2>Cần cân nhắc</h2>
<ul>
<li><strong>Căn có nhìn được Ngũ Hành Sơn hay không</strong> phụ thuộc hướng căn và tầng. Theo chủ đầu tư, phía Nam dự án quy hoạch 26 – 30 tầng và mặt Nam không có căn nhìn trực diện – cần xem mặt bằng cụ thể khi chọn căn (xem <a href="/chon-can-sun-saphia-residence-day-mat-bien/">chọn dãy căn</a>).</li>
<li><strong>Lượt khách tham quan không đồng nghĩa với khách lưu trú</strong>: nhiều khách đi tour trong ngày từ trung tâm hoặc Hội An. Khi tính lấp đầy nên dùng số khách lưu trú của thành phố và tính theo mùa.</li>
<li><strong>Mùa mưa bão</strong> (khoảng tháng 9 – 12) khách tham quan giảm.</li>
</ul>
<h2>Nhận định của Hoàng Hiệp</h2>
<p>Danh thắng Ngũ Hành Sơn là lợi thế vị trí khó sao chép: di tích quốc gia đặc biệt, đông khách quốc tế, lại không bị lấn át bởi nhà cao tầng. Với Sun Saphia Residence, giá trị này cộng thêm vào biển Sơn Thủy và công viên 2,45 ha phía trước, giúp căn hộ có câu chuyện riêng khi cho thuê. Xem thêm <a href="/sun-saphia-residence-o-dau-vi-tri/">Sun Saphia Residence ở đâu</a> và bài {$review}.</p>
{$cta}
<p class="src">Nguồn: lượt khách Ngũ Hành Sơn năm 2025 theo Báo Văn hóa; khách lưu trú Đà Nẵng 9 tháng 2026 theo VietnamPlus; vị trí, quy hoạch xung quanh theo chủ đầu tư (04/11/2026). Khoảng cách do Hoàng Hiệp ước tính trên bản đồ.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Danh thắng Ngũ Hành Sơn: 2,2 triệu lượt khách năm 2025',
			'desc'      => 'Danh thắng Ngũ Hành Sơn đón khoảng 2,2 triệu lượt khách năm 2025, hơn 1,5 triệu khách quốc tế. Điểm cộng gì cho ở và cho thuê căn hộ Sun Saphia Residence.',
			'points'    => array(
				'Danh thắng Ngũ Hành Sơn là di tích quốc gia đặc biệt, đón khoảng 2,2 triệu lượt khách năm 2025',
				'Hơn 1,5 triệu lượt là khách quốc tế',
				'Từ dự án tới khu Thủy Sơn ước khoảng 3 – 4 km',
				'Mặt Nam dự án không có căn nhìn trực diện – cần xem mặt bằng khi chọn căn',
			),
			'faq'       => array(
				array( 'Sun Saphia Residence cách danh thắng Ngũ Hành Sơn bao xa?', 'Ước khoảng 3 – 4 km theo đường Trường Sa và Huyền Trân Công Chúa (Hoàng Hiệp đo trên bản đồ), khoảng 10 phút đi xe.' ),
				array( 'Danh thắng Ngũ Hành Sơn mỗi năm đón bao nhiêu khách?', 'Theo Báo Văn hóa, năm 2025 danh thắng Ngũ Hành Sơn đón khoảng 2,2 triệu lượt khách, trong đó hơn 1,5 triệu lượt khách quốc tế.' ),
				array( 'Căn hộ Sun Saphia Residence có nhìn thấy Ngũ Hành Sơn không?', 'Tùy hướng căn và tầng. Theo chủ đầu tư, phía Nam dự án quy hoạch 26 – 30 tầng và mặt Nam không có căn nhìn trực diện; cần xem mặt bằng cụ thể.' ),
				array( 'Nên tham quan danh thắng Ngũ Hành Sơn vào giờ nào?', 'Nên đi sớm khoảng 7 – 8 giờ sáng để tránh nắng và đông khách, mang giày đế bám, nước uống và trang phục lịch sự khi vào chùa.' ),
			),
		),
		'sources'  => array(
			'https://www.vietnamplus.vn/da-nang-don-gan-16-trieu-luot-khach-luu-tru-trong-9-thang-nam-2026-post1140183.vnp',
		),
	);

	return hh_posts_sun_saphia_dot_8b( $posts, $saphia, $review, $cta );
}

function hh_posts_sun_saphia_dot_8b( $posts, $saphia, $review, $cta ) {

	/* ---------------- 14/11 11:30 – Đi Hội An ---------------- */
	$posts[] = array(
		'slug'     => 'sun-saphia-residence-di-hoi-an-bao-xa',
		'old_slug' => array( 'tu-sun-saphia-residence-di-hoi-an-bao-xa-lich-trinh' ),
		'rev'      => 2, // 15/11: chuẩn SEO 100/100, đổi slug theo từ khoá.
		'title'    => 'Từ Sun Saphia Residence đi Hội An bao xa? Đường ven biển, xe buýt và lịch trình cho khách thuê',
		'excerpt'  => 'Sun Saphia Residence nằm trên trục ven biển Võ Nguyên Giáp – Trường Sa nối thẳng tới Hội An. Quãng đường, thời gian, xe buýt, các điểm di sản trên đường và vì sao kết nối Hội An quan trọng với căn hộ cho thuê.',
		'keyword'  => 'Sun Saphia Residence đi Hội An',
		'keywords_extra' => array( 'Sun Saphia Residence', 'Đà Nẵng đi Hội An', 'đường ven biển Đà Nẵng Hội An', 'du lịch Hội An' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-14 11:30',
		'category' => 'Thị trường',
		'tags'     => array( 'Sun Saphia Residence', 'Hội An', 'Du lịch Đà Nẵng' ),
		'image'    => 'plugin:img/tin-tuc/sun-saphia-di-hoi-an.jpg',
		'content'  => <<<HTML
<p>Khách du lịch đến Đà Nẵng hầu như đều dành ít nhất một buổi cho phố cổ Hội An. Vì vậy câu hỏi <strong>Sun Saphia Residence đi Hội An</strong> mất bao lâu không chỉ là chuyện đi chơi – nó quyết định căn hộ có hợp với khách lưu trú nhiều ngày hay không. {$saphia} nằm ngay trên trục ven biển nối Đà Nẵng với Hội An, nên đây là một lợi thế đáng phân tích.</p>
<!--hh-featured-->
<h2>Sun Saphia Residence đi Hội An: quãng đường và thời gian</h2>
<table>
<thead><tr><th>Tuyến</th><th>Quãng đường</th><th>Thời gian</th></tr></thead>
<tbody>
<tr><td>Trung tâm Đà Nẵng – phố cổ Hội An (theo đường ven biển)</td><td>khoảng 30 km</td><td>40 – 60 phút</td></tr>
<tr><td>Khu Sơn Thủy (Sun Saphia Residence) – phố cổ Hội An</td><td>ước khoảng 22 – 25 km</td><td>khoảng 35 – 45 phút</td></tr>
<tr><td>Khu Sơn Thủy – sân bay Đà Nẵng</td><td>khoảng 9 – 14 km</td><td>khoảng 20 phút taxi</td></tr>
</tbody>
</table>
<p>Số liệu trung tâm – Hội An và Sơn Thủy – sân bay theo các trang hướng dẫn du lịch, hãng bay; quãng Sơn Thủy – Hội An do Hoàng Hiệp ước tính trên bản đồ, thời gian thực tế phụ thuộc giờ cao điểm.</p>
<h2>Từ Sun Saphia Residence đi Hội An bằng gì?</h2>
<ul>
<li><strong>Taxi, xe công nghệ:</strong> nhanh và tiện nhất cho nhóm 2 – 4 người, đi thẳng đường Trường Sa – Lạc Long Quân.</li>
<li><strong>Xe máy:</strong> phổ biến với khách trẻ, khách Hàn Quốc thuê dài ngày; đường ven biển rộng, nhiều đoạn có dải phân cách.</li>
<li><strong>Xe buýt:</strong> tuyến buýt Đà Nẵng – Hội An chạy dọc trục Võ Nguyên Giáp – Trường Sa, đi ngang khu Sơn Thủy – lựa chọn tiết kiệm cho khách đi một mình.</li>
<li><strong>Tour ghép:</strong> nhiều tour Hội An buổi chiều – tối đón khách tại khách sạn, căn hộ trong khu biển.</li>
</ul>
<!--hh-img:img/sun-saphia/sun-saphia-so-do-vi-tri.jpg|Sun Saphia Residence đi Hội An theo trục ven biển Trường Sa – sơ đồ vị trí dự án (tài liệu chủ đầu tư)-->
<h2>Những gì nằm trên đường từ Sun Saphia Residence đi Hội An</h2>
<ul>
<li><strong>Danh thắng Ngũ Hành Sơn và làng đá Non Nước</strong> – ngay đầu hành trình (xem <a href="/danh-thang-ngu-hanh-son-gan-sun-saphia-residence/">danh thắng Ngũ Hành Sơn</a>).</li>
<li><strong>Dải resort ven biển</strong> trên đường Trường Sa – Lạc Long Quân: nhiều thương hiệu khách sạn quốc tế, sân golf.</li>
<li><strong>Bãi biển An Bàng, Cửa Đại</strong> ở phía Hội An.</li>
<li><strong>Phố cổ Hội An</strong> – di sản văn hóa thế giới UNESCO công nhận năm 1999; xa hơn là <strong>Thánh địa Mỹ Sơn</strong> (di sản thế giới 1999) và <strong>Cù Lao Chàm</strong> (khu dự trữ sinh quyển thế giới 2009).</li>
</ul>
<p>Thông tin điểm đến, lễ hội ở Hội An và Đà Nẵng có thể tra trên cổng du lịch chính thức <a href="https://danangfantasticity.com/">Danang Fantasticity</a>. Từ ngày 01/7/2025, sau sắp xếp đơn vị hành chính, Hội An thuộc thành phố Đà Nẵng mới. Điều này giúp việc quy hoạch, đầu tư hạ tầng ven biển nối hai khu được tính chung một thành phố.</p>
<h2>Hạ tầng sắp tới trên trục Đà Nẵng – Hội An</h2>
<ul>
<li><strong>Mở rộng đường Võ Nguyên Giáp – Trường Sa – Lạc Long Quân</strong>, vốn dự kiến 2.633 tỷ đồng – xem <a href="/mo-rong-duong-vo-nguyen-giap-truong-sa-lac-long-quan-2633-ty/">bài chi tiết</a>.</li>
<li><strong>Đường sắt đô thị sân bay – Mỹ Khê – Hội An</strong>: giai đoạn đầu là tuyến LRT nối sân bay với biển; theo tài liệu chủ đầu tư, ga LRT 09 cách dự án khoảng 500 m – xem <a href="/duong-sat-do-thi-san-bay-my-khe-hoi-an-bat-dong-san-huong-loi/">tiến độ tuyến đường sắt</a>.</li>
</ul>
<p>Các dự án này đang ở bước chuẩn bị đầu tư; tiến độ thực tế có thể thay đổi.</p>
<h2>Lịch trình mẫu: một ngày từ Sun Saphia Residence đi Hội An</h2>
<ul>
<li><strong>Sáng:</strong> tắm biển Sơn Thủy, ăn sáng gần nhà.</li>
<li><strong>Trưa – chiều:</strong> ghé Ngũ Hành Sơn, làng đá Non Nước, rồi theo đường Trường Sa – Lạc Long Quân vào Hội An; có thể dừng biển An Bàng.</li>
<li><strong>Chiều tối:</strong> dạo phố cổ khi lên đèn lồng, ăn tối với cao lầu, cơm gà.</li>
<li><strong>Tối:</strong> quay về căn hộ khoảng 35 – 45 phút taxi.</li>
</ul>
<p>Lịch này cho thấy lợi thế của việc ở khu Sơn Thủy: khách không cần đổi chỗ ở, vẫn đi được cả Đà Nẵng và Hội An trong ngày. Chủ căn có thể in lịch trình Sun Saphia Residence đi Hội An thành tờ hướng dẫn, kèm số điện thoại taxi và giờ xe buýt.</p>
<h2>Vì sao tuyến Sun Saphia Residence đi Hội An quan trọng với căn hộ cho thuê?</h2>
<ol>
<li><strong>Khách ở lâu hơn:</strong> khách muốn đi cả Đà Nẵng và Hội An thường chọn một chỗ ở giữa để khỏi đổi khách sạn – căn hộ khu Sơn Thủy đáp ứng đúng nhu cầu này.</li>
<li><strong>Giá phòng Hội An mùa cao điểm cao</strong>, khách có thể chọn ở biển Đà Nẵng rồi đi Hội An buổi tối.</li>
<li><strong>Tin đăng hấp dẫn hơn:</strong> "35 – 45 phút tới phố cổ, 20 phút tới sân bay" là thông tin khách quốc tế tìm kiếm khi đặt phòng.</li>
</ol>
<h2>Cần cân nhắc</h2>
<ul>
<li>Khách chỉ muốn ở ngay phố cổ sẽ không chọn ở Sun Saphia Residence đi Hội An mỗi ngày; Sun Saphia Residence phục vụ tốt nhóm khách "biển là chính, Hội An là một buổi".</li>
<li>Giờ cao điểm, mùa lễ hội, đường ven biển có thể đông; thời gian nêu trên chỉ là tham khảo.</li>
</ul>
<h2>Nhận định của Hoàng Hiệp</h2>
<p>Nằm giữa sân bay, Ngũ Hành Sơn và Hội An là điểm mạnh vị trí của Sun Saphia Residence so với các dự án sâu trong trung tâm. Khi làm tin đăng cho thuê, nên đưa lịch trình gợi ý Sun Saphia Residence đi Hội An để tăng tỷ lệ khách đặt nhiều đêm. Xem thêm <a href="/sun-saphia-residence-o-dau-vi-tri/">vị trí Sun Saphia Residence</a> và bài {$review}.</p>
{$cta}
<p class="src">Nguồn: quãng đường Đà Nẵng – Hội An, sân bay – Sơn Thủy theo các trang hướng dẫn du lịch, hãng bay (tra cứu 11/11/2026); di sản theo UNESCO; hạ tầng theo báo chí và tài liệu chủ đầu tư. Quãng Sơn Thủy – Hội An do Hoàng Hiệp ước tính.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Sun Saphia Residence đi Hội An: 22 – 25 km, 35 – 45 phút',
			'desc'      => 'Sun Saphia Residence đi Hội An ước 22 – 25 km theo đường ven biển, khoảng 35 – 45 phút; sân bay 9 – 14 km. Xe buýt, lịch trình và lợi thế cho thuê.',
			'points'    => array(
				'Trung tâm Đà Nẵng – Hội An khoảng 30 km, 40 – 60 phút',
				'Sun Saphia Residence đi Hội An ước 22 – 25 km, khoảng 35 – 45 phút',
				'Tuyến buýt Đà Nẵng – Hội An chạy dọc trục Võ Nguyên Giáp – Trường Sa',
				'Từ 01/7/2025 Hội An thuộc thành phố Đà Nẵng',
			),
			'faq'       => array(
				array( 'Từ Sun Saphia Residence đi Hội An mất bao lâu?', 'Ước khoảng 35 – 45 phút đi taxi theo đường ven biển Trường Sa – Lạc Long Quân (quãng đường ước 22 – 25 km), tùy giờ cao điểm.' ),
				array( 'Có xe buýt từ Sun Saphia Residence đi Hội An không?', 'Có tuyến buýt Đà Nẵng – Hội An chạy dọc trục Võ Nguyên Giáp – Trường Sa, đi ngang khu Sơn Thủy.' ),
				array( 'Sun Saphia Residence cách sân bay Đà Nẵng bao xa?', 'Khu biển Sơn Thủy cách sân bay khoảng 9 – 14 km, khoảng 20 phút đi taxi.' ),
				array( 'Nên đi từ Sun Saphia Residence đi Hội An vào giờ nào?', 'Nên đi chiều muộn để dạo phố cổ khi lên đèn và tránh nắng trưa; tránh giờ cao điểm, mùa lễ hội vì đường ven biển có thể đông.' ),
			),
		),
		'sources'  => array(
			'https://danangfantasticity.com/',
		),
	);

	/* ---------------- 14/11 16:30 – Cho thuê dài hạn ---------------- */
	$posts[] = array(
		'slug'     => 'cho-thue-dai-han-sun-saphia-residence',
		'old_slug' => array( 'cho-thue-dai-han-sun-saphia-residence-chuyen-gia-gia-dinh' ),
		'rev'      => 2, // 15/11: chuẩn SEO 100/100, đổi slug theo từ khoá.
		'title'    => 'Cho thuê dài hạn Sun Saphia Residence: giá thuê tháng khu Ngũ Hành Sơn, tỷ suất và so với cho thuê ngắn ngày',
		'excerpt'  => 'Không phải ai cũng muốn vận hành cho thuê theo đêm. Cho thuê dài hạn Sun Saphia Residence: giá thuê căn hộ nhỏ khu Ngũ Hành Sơn khoảng 4 – 12 triệu/tháng, tính thử tỷ suất trên giá dự kiến và so sánh với cho thuê ngắn ngày.',
		'keyword'  => 'thuê dài hạn Sun Saphia Residence',
		'keywords_extra' => array( 'Sun Saphia Residence', 'cho thuê căn hộ dài hạn Đà Nẵng', 'giá thuê studio Ngũ Hành Sơn', 'tỷ suất cho thuê căn hộ' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-14 16:30',
		'category' => 'Kinh nghiệm mua bán',
		'tags'     => array( 'Sun Saphia Residence', 'Cho thuê căn hộ', 'Đầu tư căn hộ' ),
		'image'    => 'plugin:img/tin-tuc/cho-thue-dai-han-sun-saphia.jpg',
		'content'  => <<<HTML
<p>Cho <strong>thuê dài hạn Sun Saphia Residence</strong> là lựa chọn ít được nhắc tới, vì phần lớn bài viết về {$saphia} nói tới cho thuê theo đêm. Nhưng nhiều anh chị ở xa, không có thời gian vận hành, lại hỏi về cho thuê dài hạn Sun Saphia Residence: thuê theo tháng, theo năm cho chuyên gia, người làm việc từ xa, gia đình nhỏ. Bài này dùng giá thuê đang chào trên thị trường khu Ngũ Hành Sơn để tính thử và so sánh hai cách.</p>
<!--hh-featured-->
<h2>Giá thuê tháng khu Ngũ Hành Sơn hiện nay</h2>
<p>Theo các tin chào thuê studio, căn hộ nhỏ khu Ngũ Hành Sơn trên các trang rao vặt (tra cứu 11/11/2026), mức giá phổ biến khoảng <strong>4 – 12 triệu đồng/tháng</strong>. Khoảng giá rộng vì gồm cả phòng studio trong nhà dân, căn hộ dịch vụ và căn hộ cao tầng có bể bơi. Căn hộ mới, view biển, có tiện ích như Sun Saphia Residence nhiều khả năng nằm ở nửa trên của khoảng này – nhưng đây là nhận định, chưa có giá thuê thực tế vì dự án dự kiến bàn giao 11/2028.</p>
<h2>Tính thử tỷ suất cho thuê dài hạn Sun Saphia Residence (studio)</h2>
<table>
<thead><tr><th>Giả định giá thuê</th><th>Thu cả năm</th><th>Trừ phí quản lý (≈ 6,3 triệu/năm)</th><th>Tỷ suất trên 2,13 tỷ</th><th>Tỷ suất trên 2,85 tỷ</th></tr></thead>
<tbody>
<tr><td>7 triệu/tháng</td><td>84 triệu</td><td>≈ 77,7 triệu</td><td>≈ 3,6%</td><td>≈ 2,7%</td></tr>
<tr><td>9 triệu/tháng</td><td>108 triệu</td><td>≈ 101,7 triệu</td><td>≈ 4,8%</td><td>≈ 3,6%</td></tr>
<tr><td>11 triệu/tháng</td><td>132 triệu</td><td>≈ 125,7 triệu</td><td>≈ 5,9%</td><td>≈ 4,4%</td></tr>
</tbody>
</table>
<p>Cách tính của Hoàng Hiệp: giá dự kiến studio 30 m² tầng 15 là 2,13 tỷ (dãy phía sau) và 2,85 tỷ (dãy mặt biển) theo chủ đầu tư 28/10/2026, chưa VAT, 2% bảo trì và nội thất; phí quản lý lấy giữa khoảng 15.000 – 20.000 đ/m² cho 30 m². Nếu cộng các chi phí này vào vốn, tỷ suất thực sẽ thấp hơn bảng trên. Giả định 12 tháng kín khách, chưa trừ thuế cho thuê.</p>
<!--hh-img:img/sun-saphia/sun-saphia-layout-studio-30m2.jpg|Thuê dài hạn Sun Saphia Residence – layout studio 30 m² hợp người đi làm (bản vẽ chủ đầu tư)-->
<h2>Cho thuê dài hạn Sun Saphia Residence so với cho thuê ngắn ngày</h2>
<table>
<thead><tr><th></th><th>Cho thuê dài hạn</th><th>Cho thuê ngắn ngày</th></tr></thead>
<tbody>
<tr><td>Doanh thu</td><td>Ổn định, thấp hơn</td><td>Cao hơn nhưng dao động theo mùa</td></tr>
<tr><td>Giá tham khảo</td><td>4 – 12 triệu/tháng (khu Ngũ Hành Sơn)</td><td>Studio 2,2 – 2,9 triệu/đêm (khảo sát của chủ đầu tư, chưa vào cao điểm)</td></tr>
<tr><td>Chi phí vận hành</td><td>Thấp: tìm khách 1 – 2 lần/năm, khách thường tự trả điện nước</td><td>Khoảng 35% doanh thu theo chủ đầu tư; thêm hoa hồng kênh đặt phòng</td></tr>
<tr><td>Thời gian của chủ nhà</td><td>Ít</td><td>Nhiều, hoặc phải thuê đơn vị vận hành</td></tr>
<tr><td>Hao mòn nội thất</td><td>Ít hơn</td><td>Nhiều hơn</td></tr>
<tr><td>Thủ tục</td><td>Hợp đồng thuê, khai báo tạm trú</td><td>Khai báo lưu trú từng lượt khách, có thể cần đăng ký kinh doanh lưu trú</td></tr>
</tbody>
</table>
<p>Ví dụ đối chiếu: studio cho thuê ngắn ngày 2,2 triệu/đêm, 12 đêm/tháng, doanh thu 26,4 triệu; trừ 35% chi phí còn khoảng 17,2 triệu/tháng – cao hơn nhiều so với 9 triệu cho thuê dài hạn. Nhưng chỉ cần một tháng mùa mưa còn 4 – 5 đêm, con số này giảm mạnh. Cách tính theo mùa xem <a href="/cong-suat-phong-da-nang-mua-du-lich-sun-saphia/">mùa du lịch và lấp đầy</a>.</p>
<h2>Ai sẽ thuê dài hạn Sun Saphia Residence?</h2>
<ul>
<li><strong>Chuyên gia, người nước ngoài làm việc tại Đà Nẵng</strong> – người nước ngoài không mua được Sun Saphia Residence nhưng được thuê (xem <a href="/nguoi-nuoc-ngoai-mua-can-ho-sun-saphia/">bài về người nước ngoài</a>).</li>
<li><strong>Người làm việc từ xa</strong> ở 1 – 3 tháng, thích gần biển (xem <a href="/digital-nomad-da-nang-thue-can-ho-sun-saphia/">digital nomad Đà Nẵng</a>).</li>
<li><strong>Gia đình nhỏ</strong> thuê căn 1PN+ hoặc 2PN trong thời gian chờ nhà riêng.</li>
<li><strong>Nhân sự resort, khách sạn</strong> trên dải Trường Sa – Lạc Long Quân.</li>
</ul>
<h2>Kết hợp thuê dài hạn Sun Saphia Residence và cho thuê theo đêm</h2>
<p>Một cách nhiều chủ nhà ở Đà Nẵng áp dụng: <strong>cho thuê theo tháng vào mùa thấp điểm</strong> (khoảng tháng 9 – 1, mùa mưa) và <strong>theo đêm vào mùa cao điểm</strong> (tháng 4 – 8, dịp pháo hoa). Cách này cần chủ nhà linh hoạt, và hợp đồng thuê tháng nên ghi rõ thời hạn để không vướng mùa cao điểm. Sun Saphia Residence cho chủ căn <strong>tự quyết để ở hay cho thuê</strong>, không bắt buộc ký gửi lại chủ đầu tư, nên có thể chọn được cách này.</p>
<h2>Hợp đồng thuê dài hạn Sun Saphia Residence cần ghi gì?</h2>
<ol>
<li>Ai trả phí quản lý, điện, nước, internet, gửi xe.</li>
<li>Tiền cọc (thường 1 – 2 tháng), kỳ thanh toán.</li>
<li>Danh mục nội thất, tình trạng lúc giao nhận.</li>
<li>Điều kiện chấm dứt sớm, báo trước bao lâu.</li>
<li>Trách nhiệm khai báo tạm trú theo Luật Cư trú.</li>
</ol>
<p>Thu nhập từ cho thuê dài hạn Sun Saphia Residence cũng phải kê khai thuế khi doanh thu vượt ngưỡng; cách tính thuế cho thuê bất động sản 2026 xem <a href="https://thuvienphapluat.vn/phap-luat-doanh-nghiep/bai-viet/cach-tinh-thue-cho-thue-bat-dong-san-moi-nhat-2026-theo-nghi-dinh-141-va-nghi-dinh-68-20777.html">Thư viện Pháp luật</a>.</p>
<h2>Nhận định của Hoàng Hiệp</h2>
<p>Cho thuê dài hạn Sun Saphia Residence cho tỷ suất thấp hơn nhưng ổn định, ít tốn công – hợp người mua ở xa hoặc mua để giữ tài sản. Người muốn tối ưu dòng tiền vẫn nên cho thuê ngắn ngày hoặc kết hợp theo mùa. Đừng dùng các con số trên như cam kết: giá thuê năm 2028 – 2029 còn phụ thuộc nguồn cung căn hộ mới quanh khu biển. Xem thêm <a href="/dau-tu-sun-saphia-residence-cho-thue-dong-tien/">3 kịch bản dòng tiền</a> và bài {$review}.</p>
{$cta}
<p class="src">Nguồn: giá chào thuê căn hộ nhỏ khu Ngũ Hành Sơn trên các trang rao vặt (tra cứu 11/11/2026, giá chào, chưa phải giá giao dịch); giá dự kiến, phí quản lý, giá thuê theo đêm và chi phí vận hành theo chủ đầu tư (28/10 và 04/11/2026). Bảng tính của Hoàng Hiệp, mang tính minh họa.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Thuê dài hạn Sun Saphia Residence: 4 – 12 triệu/tháng',
			'desc'      => 'Cho thuê dài hạn Sun Saphia Residence: giá thuê căn hộ nhỏ khu Ngũ Hành Sơn 4 – 12 triệu/tháng, tỷ suất ước 2,7 – 5,9%, so với cho thuê theo đêm.',
			'points'    => array(
				'Thuê dài hạn Sun Saphia Residence: giá chào thuê căn hộ nhỏ khu Ngũ Hành Sơn khoảng 4 – 12 triệu/tháng',
				'Tỷ suất ước 2,7 – 5,9%/năm tùy giá thuê và dãy căn (minh họa)',
				'Cho thuê ngắn ngày doanh thu cao hơn nhưng dao động theo mùa',
				'Có thể kết hợp: thuê tháng mùa thấp điểm, thuê đêm mùa cao điểm',
			),
			'faq'       => array(
				array( 'Cho thuê dài hạn studio Sun Saphia Residence được bao nhiêu?', 'Chưa có giá thực tế vì dự án dự kiến bàn giao 11/2028. Giá chào thuê căn hộ nhỏ khu Ngũ Hành Sơn hiện khoảng 4 – 12 triệu/tháng để tham khảo.' ),
				array( 'Cho thuê dài hạn Sun Saphia Residence hay ngắn ngày lợi hơn?', 'Ngắn ngày doanh thu cao hơn nhưng tốn chi phí vận hành (khoảng 35% doanh thu theo chủ đầu tư) và dao động theo mùa; dài hạn ổn định, ít công sức.' ),
				array( 'Mua Sun Saphia Residence có bắt buộc ký gửi cho thuê không?', 'Không. Chủ căn hộ tự quyết để ở hay cho thuê dài hạn, tự vận hành hoặc thuê đơn vị bên ngoài.' ),
				array( 'Ai thường thuê dài hạn Sun Saphia Residence?', 'Dự kiến là chuyên gia, người nước ngoài làm việc tại Đà Nẵng, người làm việc từ xa, gia đình nhỏ và nhân sự resort, khách sạn trên dải Trường Sa.' ),
			),
		),
		'sources'  => array(
			'https://thuvienphapluat.vn/phap-luat-doanh-nghiep/bai-viet/cach-tinh-thue-cho-thue-bat-dong-san-moi-nhat-2026-theo-nghi-dinh-141-va-nghi-dinh-68-20777.html',
		),
	);

	/* ---------------- 15/11 11:30 – Tầng cao hay tầng thấp ---------------- */
	$posts[] = array(
		'slug'     => 'tang-cao-hay-tang-thap-sun-saphia-residence-chon-tang-nao',
		'title'    => 'Tầng cao hay tầng thấp Sun Saphia Residence? Cấu trúc 30 tầng, view 4 hướng và 7 thang máy',
		'excerpt'  => 'Sun Saphia Residence cao 30 tầng (114 m): tầng 1 shophouse, tầng 2 tiện ích, tầng 3A – 28 căn hộ điển hình, tầng 29 căn sân vườn, tầng 30 penthouse. Phân tích chọn tầng theo view, quy hoạch xung quanh, gió biển và thang máy.',
		'keyword'  => 'tầng cao hay tầng thấp Sun Saphia Residence',
		'keywords_extra' => array( 'Sun Saphia Residence', 'chọn tầng căn hộ', 'căn hộ tầng cao view biển', 'penthouse Sun Saphia' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-15 11:30',
		'category' => 'Kinh nghiệm mua bán',
		'tags'     => array( 'Sun Saphia Residence', 'Kinh nghiệm chọn căn', 'Căn hộ ven biển' ),
		'image'    => 'plugin:img/tin-tuc/tang-cao-tang-thap-sun-saphia.jpg',
		'content'  => <<<HTML
<p>Sau khi chọn dãy căn (mặt biển, cánh bên hay phía sau), câu hỏi tiếp theo là chọn <strong>tầng cao hay tầng thấp Sun Saphia Residence</strong>. Tòa {$saphia} cao 30 tầng, 114 m, nên khác biệt giữa tầng 5 và tầng 25 khá lớn – về view, gió, thời gian chờ thang và giá. Bài này dựa trên thông tin chủ đầu tư công bố tới 11/2026.</p>
<!--hh-featured-->
<h2>Cấu trúc tòa tháp theo tầng</h2>
<table>
<thead><tr><th>Tầng</th><th>Công năng</th><th>Ghi chú</th></tr></thead>
<tbody>
<tr><td>2 tầng hầm</td><td>Đỗ xe, kỹ thuật</td><td></td></tr>
<tr><td>Tầng 1</td><td>Shophouse, sảnh</td><td>Cao 7 m</td></tr>
<tr><td>Tầng 2</td><td>Tiện ích</td><td>Cao 5,5 m</td></tr>
<tr><td>Tầng 3</td><td>Có căn hộ sân vườn</td><td>Sân vườn trên mái khối đế</td></tr>
<tr><td>Tầng 3A – 28</td><td>Căn hộ điển hình</td><td>28 căn/sàn: 19 studio, 4 căn 1PN+, 5 căn 2PN; chiều cao tầng 3,5 m</td></tr>
<tr><td>Tầng 29</td><td>Có 2 căn kèm sân vườn riêng</td><td></td></tr>
<tr><td>Tầng 30</td><td>Penthouse</td><td>Cao 6,5 m</td></tr>
</tbody>
</table>
<p>Tầng điển hình được đánh số 3A – 28 nên số tầng ghi trên giấy có thể không trùng số tầng đếm thực tế. Khi chọn căn, nên hỏi rõ cao độ sàn của căn đó.</p>
<!--hh-img:img/sun-saphia/sun-saphia-mat-bang-tang-3a-28.jpg|Mặt bằng tầng điển hình 3A – 28 Sun Saphia Residence: 28 căn mỗi sàn (bản vẽ chủ đầu tư)-->
<h2>View theo hướng và quy hoạch xung quanh</h2>
<p>Chọn tầng chỉ có ý nghĩa khi biết trước mặt căn sẽ có gì. Theo chủ đầu tư (04/11/2026):</p>
<table>
<thead><tr><th>Hướng</th><th>Quy hoạch xung quanh</th><th>Ảnh hưởng tới chọn tầng</th></tr></thead>
<tbody>
<tr><td>Đông (biển)</td><td>Resort thấp tầng; công viên, bãi tắm 2,45 ha; phần đất còn lại dự kiến ưu tiên thấp tầng</td><td>Tầng trung đã nhìn biển thoáng; tầng cao nhìn xa hơn về Mỹ Khê – Sơn Trà</td></tr>
<tr><td>Nam</td><td>Quy hoạch 26 – 30 tầng</td><td>Mặt Nam không có căn nhìn trực diện</td></tr>
<tr><td>Tây</td><td>Tối đa 7 tầng</td><td>Từ khoảng tầng 8 trở lên ít bị che phía Tây (sông, đô thị)</td></tr>
<tr><td>Bắc</td><td>Khu sân bay Nước Mặn, chưa có thông tin điều chỉnh</td><td>Quy hoạch có thể thay đổi – cần theo dõi</td></tr>
</tbody>
</table>
<p>Cột cuối là nhận định của Hoàng Hiệp từ quy hoạch chủ đầu tư nêu, không phải cam kết view.</p>
<h2>Ưu nhược điểm tầng thấp (khoảng 3A – 10)</h2>
<ul>
<li><strong>Ưu:</strong> gần khu tiện ích tầng 2, đi thang nhanh, ít chịu gió mạnh; giá thường mềm hơn tầng cao trong cùng dãy (hệ số tầng chính thức chờ bảng giá).</li>
<li><strong>Nhược:</strong> view phía Tây có thể bị công trình tối đa 7 tầng che; gần mặt đường Trường Sa nên nghe tiếng xe nhiều hơn.</li>
</ul>
<h2>Ưu nhược điểm tầng trung (khoảng 11 – 20)</h2>
<ul>
<li><strong>Ưu:</strong> view biển và công viên rõ, đã vượt các công trình thấp tầng xung quanh; giá dự kiến chủ đầu tư công bố đang lấy mốc <strong>tầng 15</strong> (studio 30 m²: 2,13 – 2,85 tỷ tùy dãy).</li>
<li><strong>Nhược:</strong> là nhóm tầng nhiều người chọn nhất nên cạnh tranh cao khi mở bán.</li>
</ul>
<h2>Ưu nhược điểm tầng cao (khoảng 21 – 28) và căn đặc biệt</h2>
<ul>
<li><strong>Ưu:</strong> tầm nhìn xa nhất, riêng tư hơn; căn tầng 29 có sân vườn và penthouse tầng 30 cao 6,5 m là sản phẩm hiếm, hợp người mua giữ tài sản.</li>
<li><strong>Nhược:</strong> gió biển mạnh, hơi muối nhiều hơn – ban công, cửa, điều hòa cần bảo dưỡng kỹ (xem <a href="/can-ho-ven-bien-hoi-muoi-mua-bao-sun-saphia-residence/">căn hộ ven biển và hơi muối</a>); thời gian chờ thang dài hơn giờ cao điểm.</li>
</ul>
<h2>Thang máy: 7 thang cho 28 căn mỗi sàn</h2>
<p>Tòa có <strong>7 thang máy chia 2 sảnh thang</strong>. Chủ đầu tư cho biết số thang tính theo quy chuẩn dân số (căn 25 – 45 m² tính 1 người) và tham khảo tiêu chuẩn CIBSE với thời gian chờ thang 45 – 60 giây. Với căn hộ cho thuê nhiều khách du lịch, giờ trả phòng – nhận phòng có thể đông hơn; tầng cao chịu ảnh hưởng nhiều hơn tầng thấp.</p>
<h2>Tầng cao hay tầng thấp Sun Saphia Residence: chọn theo mục đích</h2>
<table>
<thead><tr><th>Mục đích</th><th>Gợi ý</th></tr></thead>
<tbody>
<tr><td>Cho thuê ngắn ngày, tối ưu vốn</td><td>Tầng trung dãy mặt biển hoặc cánh bên – ảnh view đẹp, giá chưa quá cao</td></tr>
<tr><td>Cho thuê dài hạn</td><td>Tầng thấp – trung, dãy phía sau – vốn thấp, khách thuê tháng ít quan tâm view</td></tr>
<tr><td>Nghỉ dưỡng gia đình, giữ tài sản</td><td>Tầng cao, căn góc 2PN, căn sân vườn tầng 29 hoặc penthouse</td></tr>
</tbody>
</table>
<h2>Nhận định của Hoàng Hiệp</h2>
<p>Giá chênh giữa các tầng sẽ có trong bảng giá chính thức tại sự kiện bán hàng. Trước đó, nên xác định mục đích mua và hướng căn trước, rồi mới chọn tầng – vì với Sun Saphia Residence, hướng (Đông, Tây, Bắc) ảnh hưởng tới view nhiều hơn số tầng. Xem thêm <a href="/chon-day-can-sun-saphia-residence-mat-bien-canh-ben-phia-sau/">chọn dãy căn</a>, <a href="/mat-bang-can-ho-sun-saphia-residence/">mặt bằng Sun Saphia Residence</a> và bài {$review}.</p>
{$cta}
<p class="src">Nguồn: cấu trúc tầng, chiều cao, thang máy, quy hoạch 4 hướng theo buổi giải đáp của chủ đầu tư 04/11/2026; mặt bằng tầng điển hình theo tài liệu chủ đầu tư 10/2026; giá dự kiến 28/10/2026. Gợi ý chọn tầng là nhận định của Hoàng Hiệp.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Tầng cao hay tầng thấp Sun Saphia Residence?',
			'desc'      => 'Tầng cao hay tầng thấp Sun Saphia Residence: tòa 30 tầng 114 m, tầng 3A – 28 điển hình, penthouse tầng 30. Chọn theo view 4 hướng, gió biển, thang máy.',
			'points'    => array(
				'Tòa 30 tầng cao 114 m; tầng 3A – 28 là căn hộ điển hình, 28 căn/sàn',
				'Tầng 29 có 2 căn sân vườn, tầng 30 penthouse cao 6,5 m',
				'Phía Tây tối đa 7 tầng, phía Nam quy hoạch 26 – 30 tầng',
				'7 thang máy, 2 sảnh thang, chờ thang 45 – 60 giây theo chủ đầu tư',
			),
			'faq'       => array(
				array( 'Sun Saphia Residence có bao nhiêu tầng?', '30 tầng, cao 114 m, 2 tầng hầm; tầng 1 shophouse, tầng 2 tiện ích, tầng 3A – 28 căn hộ điển hình, tầng 30 penthouse.' ),
				array( 'Nên chọn tầng nào ở Sun Saphia Residence?', 'Cho thuê ngắn ngày nên cân nhắc tầng trung dãy mặt biển hoặc cánh bên; cho thuê dài hạn chọn tầng thấp – trung dãy phía sau; nghỉ dưỡng, giữ tài sản chọn tầng cao hoặc căn đặc biệt.' ),
				array( 'Sun Saphia Residence có mấy thang máy?', 'Theo chủ đầu tư, 7 thang máy chia 2 sảnh thang cho 28 căn mỗi sàn, thời gian chờ thang tham khảo 45 – 60 giây.' ),
			),
		),
		'sources'  => array(),
	);

	/* ---------------- 15/11 16:30 – Mua để ở ---------------- */
	$posts[] = array(
		'slug'     => 'mua-sun-saphia-residence-de-o-duoc-khong-can-biet',
		'title'    => 'Mua Sun Saphia Residence để ở được không? Tạm trú, bàn giao, chi phí sống và những điều khác chung cư thường',
		'excerpt'  => 'Sun Saphia Residence là căn hộ thương mại dịch vụ, phần lớn là studio cho thuê – vậy mua để ở có hợp không? Tạm trú, tiêu chuẩn bàn giao, tiện ích, chi phí hằng tháng và cuộc sống chung tòa với khách du lịch.',
		'keyword'  => 'mua Sun Saphia Residence để ở',
		'keywords_extra' => array( 'Sun Saphia Residence', 'căn hộ ven biển để ở Đà Nẵng', 'căn hộ thương mại dịch vụ để ở', 'đăng ký tạm trú căn hộ' ),
		'project'  => 'sun-saphia-residence',
		'schedule' => '2026-11-15 16:30',
		'category' => 'Kinh nghiệm mua bán',
		'tags'     => array( 'Sun Saphia Residence', 'Căn hộ ven biển', 'Kinh nghiệm mua bán' ),
		'image'    => 'plugin:img/tin-tuc/mua-de-o-sun-saphia.jpg',
		'content'  => <<<HTML
<p>Với 513 trên 782 căn là studio, {$saphia} thường được nói tới như sản phẩm cho thuê. Nhưng không ít khách hỏi <strong>mua Sun Saphia Residence để ở</strong> có được không – người về hưu muốn sống cạnh biển, gia đình ở Hà Nội, TP.HCM muốn có căn nghỉ dài ngày, hay người trẻ làm việc ở Đà Nẵng. Câu trả lời là được, nhưng có vài khác biệt so với chung cư thường cần biết trước.</p>
<!--hh-featured-->
<h2>Căn hộ thương mại dịch vụ có ở được không?</h2>
<p>Được. Sun Saphia Residence nằm trên đất thương mại dịch vụ, thời hạn 50 năm từ 17/09/2026. Chủ đầu tư cho biết căn hộ thương mại dịch vụ <strong>vẫn đăng ký tạm trú được</strong>. Với nhu cầu đăng ký thường trú (ví dụ chuyển hộ khẩu, xin học cho con theo nơi cư trú), anh chị nên hỏi trước công an phường về điều kiện với loại hình này – không nên giả định giống chung cư nhà ở.</p>
<table>
<thead><tr><th>Khác biệt</th><th>Chung cư nhà ở</th><th>Sun Saphia Residence</th></tr></thead>
<tbody>
<tr><td>Thời hạn</td><td>Thường lâu dài với công dân Việt Nam</td><td>50 năm, chủ đầu tư dự kiến hướng gia hạn khi hết hạn</td></tr>
<tr><td>Cư trú</td><td>Thường trú, tạm trú</td><td>Tạm trú được (theo chủ đầu tư); thường trú cần hỏi cơ quan công an</td></tr>
<tr><td>Hàng xóm</td><td>Chủ yếu cư dân ở lâu dài</td><td>Nhiều khách lưu trú ngắn ngày</td></tr>
<tr><td>Bảo lãnh ngân hàng</td><td>Có khi mua nhà hình thành trong tương lai</td><td>Không áp dụng</td></tr>
</tbody>
</table>
<h2>Mua Sun Saphia Residence để ở nên chọn căn nào?</h2>
<ul>
<li><strong>Studio 30 – 31 m²</strong> (căn góc 40 m²): hợp người độc thân, người về hưu ở một mình, hoặc căn "nghỉ dài ngày" của gia đình ở xa. Mặt tiền 3,8 m, sâu 9 m.</li>
<li><strong>1PN+ khoảng 50 m²</strong>: có thêm phòng đa năng – làm phòng làm việc, phòng cho con nhỏ.</li>
<li><strong>2PN 60 – 70 m²</strong> ở góc tòa: hợp gia đình 3 – 4 người; chỉ 133 căn (xem <a href="/can-2pn-sun-saphia-residence-60-70m2-o-hay-cho-thue/">căn 2PN</a>).</li>
</ul>
<!--hh-img:img/sun-saphia/sun-saphia-layout-2pn-70m2.jpg|Layout căn 2PN 70 m² Sun Saphia Residence – lựa chọn cho gia đình mua để ở (bản vẽ chủ đầu tư)-->
<h2>Bàn giao gì, phải làm thêm gì?</h2>
<p>Theo chủ đầu tư, căn hộ bàn giao <strong>liền tường, trừ tủ bếp, thiết bị bếp và hút mùi</strong>: đã có hoàn thiện trần, tường, sàn, thiết bị vệ sinh, bình nóng lạnh, điều hòa, cửa, khóa, đèn, ổ cắm, PCCC. Người mua để ở cần làm thêm bếp, tủ, giường, rèm. Chiều cao tầng 3,5 m (sàn – sàn) cho phép làm trần thoáng; ban công rộng 1 m, lan can thép mạ kẽm sơn tĩnh điện. Chi phí tham khảo xem <a href="/chi-phi-noi-that-studio-30m2-cho-thue-sun-saphia/">nội thất studio 30 m²</a>.</p>
<h2>Tiện ích cho người ở</h2>
<ul>
<li>Bể bơi view biển (dài nhất 27 m), yoga, gym, pilates; tầng 2 tiện ích cao 5,5 m.</li>
<li>Khối đế thương mại, tầng 1 shophouse cao 7 m.</li>
<li>Ngay trước mặt là công viên, bãi tắm Sơn Thủy 2,45 ha thành phố đang đầu tư (xem <a href="/cong-vien-bien-truong-sa-2-45-ha-truoc-sun-saphia-residence/">công viên biển</a>).</li>
<li>Gần danh thắng Ngũ Hành Sơn, dải resort ven biển và đường đi Hội An (xem <a href="/tu-sun-saphia-residence-di-hoi-an-bao-xa-lich-trinh/">Sun Saphia Residence đi Hội An</a>).</li>
</ul>
<h2>Chi phí sống hằng tháng</h2>
<table>
<thead><tr><th>Khoản</th><th>Studio 30 m²</th><th>2PN 70 m²</th></tr></thead>
<tbody>
<tr><td>Phí quản lý (15.000 – 20.000 đ/m²)</td><td>450.000 – 600.000 đ</td><td>1,05 – 1,4 triệu</td></tr>
<tr><td>Điện, nước, internet, gửi xe</td><td colspan="2">Theo mức dùng thực tế</td></tr>
</tbody>
</table>
<p>Phí quản lý dự kiến theo chủ đầu tư, ghi trong hợp đồng mua bán; chi tiết xem <a href="/phi-quan-ly-sun-saphia-residence-moi-thang-bao-nhieu/">phí quản lý Sun Saphia Residence</a>.</p>
<h2>Sống chung tòa với khách du lịch: cần lưu ý</h2>
<ul>
<li><strong>Ra vào nhiều:</strong> mùa cao điểm có nhiều khách nhận – trả phòng, thang máy và sảnh đông hơn chung cư thường. Tòa có 7 thang máy, 2 sảnh thang.</li>
<li><strong>An ninh, nội quy:</strong> nên hỏi ban quản lý về kiểm soát ra vào, quy định giờ yên tĩnh, khu vực bể bơi.</li>
<li><strong>Chọn vị trí căn:</strong> người ở lâu dài có thể ưu tiên căn xa sảnh thang, căn góc ít người qua lại.</li>
</ul>
<h2>Kết hợp ở và cho thuê</h2>
<p>Chủ căn tự quyết để ở hay cho thuê, không bắt buộc ký gửi. Nhiều gia đình ở xa dùng căn vài tuần mỗi năm, thời gian còn lại cho thuê theo tháng hoặc theo đêm. Xem <a href="/cho-thue-dai-han-sun-saphia-residence-chuyen-gia-gia-dinh/">cho thuê dài hạn</a> và <a href="/tu-cho-thue-hay-thue-don-vi-van-hanh-can-ho-sun-saphia/">tự cho thuê hay thuê vận hành</a>.</p>
<h2>Nhận định của Hoàng Hiệp</h2>
<p>Mua Sun Saphia Residence để ở hợp với người muốn sống kiểu nghỉ dưỡng cạnh biển, chấp nhận thời hạn 50 năm và hàng xóm là khách lưu trú. Người cần thường trú, ổn định cho con đi học lâu dài nên cân nhắc thêm chung cư nhà ở. Xem thêm <a href="/co-nen-mua-sun-saphia-residence-uu-nhuoc-diem/">có nên mua Sun Saphia Residence</a> và bài {$review}.</p>
{$cta}
<p class="src">Nguồn: loại hình, thời hạn, tạm trú, tiêu chuẩn bàn giao, tiện ích, thang máy, phí quản lý theo buổi giải đáp của chủ đầu tư 04/11/2026; cơ cấu căn theo tài liệu chủ đầu tư 10/2026. Nhận định của Hoàng Hiệp, mang tính tham khảo.</p>
HTML
		,
		'seo'      => array(
			'seo_title' => 'Mua Sun Saphia Residence để ở được không?',
			'desc'      => 'Mua Sun Saphia Residence để ở: căn hộ thương mại dịch vụ vẫn đăng ký tạm trú, bàn giao liền tường trừ bếp, phí quản lý 15.000 – 20.000 đ/m². Điều cần biết.',
			'points'    => array(
				'Căn hộ thương mại dịch vụ, thời hạn 50 năm, vẫn đăng ký tạm trú được',
				'Bàn giao liền tường trừ tủ bếp, thiết bị bếp và hút mùi',
				'Bể bơi, gym, yoga, công viên biển 2,45 ha trước mặt',
				'Sống chung tòa với nhiều khách lưu trú ngắn ngày',
			),
			'faq'       => array(
				array( 'Sun Saphia Residence có đăng ký tạm trú được không?', 'Có. Chủ đầu tư cho biết căn hộ thương mại dịch vụ vẫn đăng ký tạm trú được; nhu cầu thường trú nên hỏi trước công an phường.' ),
				array( 'Mua Sun Saphia Residence để ở nên chọn căn nào?', 'Người độc thân, về hưu chọn studio; cần phòng làm việc chọn 1PN+ khoảng 50 m²; gia đình 3 – 4 người chọn 2PN 60 – 70 m² ở góc tòa.' ),
				array( 'Sun Saphia Residence bàn giao có bếp không?', 'Không. Bàn giao liền tường trừ tủ bếp, thiết bị bếp và hút mùi; các hạng mục trần, tường, sàn, vệ sinh, điều hòa, bình nóng lạnh đã hoàn thiện.' ),
			),
		),
		'sources'  => array(),
	);

	return $posts;
}
