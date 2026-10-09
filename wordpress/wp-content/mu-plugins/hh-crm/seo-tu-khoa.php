<?php
/**
 * Bản đồ từ khoá: mỗi từ khoá chỉ nhắm 1 URL (tránh trang dự án và bài viết "ăn" từ khoá của nhau).
 * - Trang dự án /du-an/{slug}/ giữ "giá {Tên}", "bảng giá {Tên}" (rankmath.php tự điền).
 * - Bài viết dùng từ khoá dài, đúng ý định bài: chính sách bán hàng, mặt bằng, có nên mua, giá chuyển nhượng, cho thuê…
 * Nút "Dự án → Nhập dữ liệu Đà Nẵng" ghi từ khoá chính, tiêu đề SEO (≤ 60 ký tự), mô tả (140–155 ký tự) vào Rank Math;
 * ô anh đã tự sửa trong Rank Math giữ nguyên. Bảng đầy đủ: wordpress/SEO-TU-KHOA.md.
 */

defined( 'ABSPATH' ) || exit;

/** slug bài => [ từ khoá chính, tiêu đề SEO, mô tả SEO ]. */
function hh_seo_keyword_map() {
	return array(
		// Hạ tầng & quy hoạch.
		'toan-canh-ha-tang-da-nang-2026-tac-dong-bat-dong-san' => array( 'hạ tầng Đà Nẵng 2026', 'Hạ tầng Đà Nẵng 2026: công trình trọng điểm và tác động BĐS', 'Hạ tầng Đà Nẵng 2026: cảng Liên Chiểu, trung tâm tài chính, cầu Hòa Xuân, nhà ga T2, Quốc lộ 14D và các khu vực bất động sản được hưởng lợi rõ nhất.' ),
		'cang-lien-chieu-khu-thuong-mai-tu-do-bat-dong-san-lien-chieu' => array( 'cảng Liên Chiểu', 'Cảng Liên Chiểu, khu thương mại tự do và BĐS Liên Chiểu', 'Cảng Liên Chiểu đã xong hạ tầng dùng chung, khu thương mại tự do Đà Nẵng khoảng 1.881 ha: tác động đến căn hộ, đất nền khu Liên Chiểu – Hải Vân.' ),
		'trung-tam-tai-chinh-quoc-te-da-nang-tac-dong-bat-dong-san' => array( 'trung tâm tài chính quốc tế Đà Nẵng', 'Trung tâm tài chính quốc tế Đà Nẵng: vị trí, tác động BĐS', 'Trung tâm tài chính quốc tế Đà Nẵng khai trương 9/1/2026, khoảng 300 ha: vị trí Võ Văn Kiệt, Thuận Phước, khu lấn biển và căn hộ được hưởng lợi.' ),
		'cum-nut-giao-cau-hoa-xuan-bat-dong-san-nam-da-nang' => array( 'cầu Hòa Xuân', 'Cầu Hòa Xuân khởi công: nút giao 1.378 tỷ, BĐS Nam Đà Nẵng', 'Cầu Hòa Xuân: cụm nút giao hơn 1.378 tỷ đồng đã khởi công 25/8/2026, thêm cầu mới và 2 hầm chui; tác động đến căn hộ, đất nền Hòa Xuân, Nam Hòa Xuân.' ),
		'duong-ven-bien-129-vo-chi-cong-bat-dong-san-ven-bien-hoi-an' => array( 'đường ven biển Võ Chí Công', 'Đường ven biển Võ Chí Công 6 làn và BĐS ven biển Hội An', 'Đường ven biển Võ Chí Công (đường 129) dài 26,5 km mở rộng 6 làn, nối Cửa Đại – Chu Lai: bất động sản nghỉ dưỡng Hội An, Nam Hội An hưởng lợi.' ),
		'mo-rong-nha-ga-t2-san-bay-da-nang-bat-dong-san-cho-thue' => array( 'nhà ga T2 sân bay Đà Nẵng', 'Nhà ga T2 sân bay Đà Nẵng mở rộng: cơ hội căn hộ cho thuê', 'Nhà ga T2 sân bay Đà Nẵng mở rộng gần 1.500 tỷ đồng, nâng công suất lên 6 triệu khách/năm: động lực lớn cho căn hộ cho thuê và căn hộ dịch vụ.' ),
		'ga-duong-sat-toc-do-cao-da-nang-hoa-son-bat-dong-san-hoa-vang' => array( 'ga đường sắt tốc độ cao Đà Nẵng', 'Ga đường sắt tốc độ cao Đà Nẵng ở Hòa Sơn và BĐS Hòa Vang', 'Ga đường sắt tốc độ cao Đà Nẵng dự kiến đặt ở Hòa Sơn (Hòa Vang), khai thác từ năm 2035: cơ hội và lưu ý cho người mua bất động sản phía Tây.' ),
		'hop-nhat-da-nang-quang-nam-bat-dong-san-vung-giap-ranh' => array( 'hợp nhất Đà Nẵng Quảng Nam', 'Hợp nhất Đà Nẵng Quảng Nam: BĐS vùng giáp ranh ra sao', 'Hợp nhất Đà Nẵng Quảng Nam từ 1/7/2025: bất động sản vùng giáp ranh Điện Ngọc, Hòa Xuân, Ngũ Hành Sơn, Hội An thay đổi ra sao, dự án nào hưởng lợi.' ),
		'bang-gia-dat-da-nang-sua-doi-2026' => array( 'bảng giá đất Đà Nẵng', 'Bảng giá đất Đà Nẵng sửa đổi 2026: điểm mới cần biết', 'Bảng giá đất Đà Nẵng sửa đổi tại kỳ họp HĐND 6/10/2026: bổ sung giá tuyến đường chưa có giá, thửa nhiều vị trí tính bình quân gia quyền. Ảnh hưởng gì?' ),
		'duong-tranh-nam-hai-van-6-lan-bat-dong-san-lien-chieu' => array( 'đường tránh Nam Hải Vân', 'Đường tránh Nam Hải Vân 6 làn hơn 1.951 tỷ và BĐS Liên Chiểu', 'Đường tránh Nam Hải Vân mở rộng 6 làn, 5,36 km từ Hòa Liên đến đường nối cảng Liên Chiểu, hơn 1.951 tỷ đồng, làm 2025 – 2029. Tác động BĐS Liên Chiểu.' ),
		'tin-ha-tang-da-nang-thang-10-2026' => array( 'tin hạ tầng Đà Nẵng', 'Tin hạ tầng Đà Nẵng tháng 10/2026: công trình và BĐS', 'Tin hạ tầng Đà Nẵng tháng 10/2026: cầu Hòa Xuân đã khởi công, Quốc lộ 14D thi công, vành đai phía Bắc Quảng Nam, đường tránh Nam Hải Vân và tác động BĐS.' ),
		'da-nang-de-xuat-xay-cau-moi-qua-song-han' => array( 'cầu mới qua sông Hàn', 'Cầu mới qua sông Hàn: Đà Nẵng đề xuất khởi công trước 2030', 'Cầu mới qua sông Hàn được Sở Xây dựng Đà Nẵng đề xuất, phấn đấu khởi công trước năm 2030 để giảm tải 5 trục Đông – Tây. Điều đã xác nhận, điều còn chờ.' ),
		'cong-vien-cau-lac-bo-the-thao-bien-bai-tam-son-thuy' => array( 'bãi tắm Sơn Thủy', 'Bãi tắm Sơn Thủy: công viên, CLB thể thao biển Ngũ Hành Sơn', 'Bãi tắm Sơn Thủy (Ngũ Hành Sơn): Đà Nẵng chuẩn bị đầu tư công viên, câu lạc bộ thể thao biển – phối cảnh, các bước tiếp theo, tác động bất động sản.' ),

		// Về Hoàng Hiệp, kinh nghiệm.
		'du-an-hoang-hiep-bat-dong-san-dang-tu-van-2026' => array( 'Hoàng Hiệp bất động sản', 'Hoàng Hiệp bất động sản: dự án đang tư vấn 2026', 'Hoàng Hiệp bất động sản: danh sách dự án đang tư vấn tại Đà Nẵng 2026 theo khu vực, loại hình, giá tham khảo. Gọi 0904 567 009 nhận bảng giá mới.' ),
		'quy-trinh-mua-can-ho-hoang-hiep-da-nang' => array( 'quy trình mua căn hộ Đà Nẵng', 'Quy trình mua căn hộ Đà Nẵng 6 bước cùng Hoàng Hiệp', 'Quy trình mua căn hộ Đà Nẵng 6 bước cùng Hoàng Hiệp: tư vấn nhu cầu, chọn dự án, kiểm tra pháp lý, đặt cọc, vay ngân hàng và nhận bàn giao nhà.' ),
		'chon-moi-gioi-bat-dong-san-da-nang-8-cau-hoi' => array( 'môi giới bất động sản Đà Nẵng', 'Môi giới bất động sản Đà Nẵng: 8 câu nên hỏi trước', 'Môi giới bất động sản Đà Nẵng: 8 câu hỏi về pháp lý, giá, phí, hậu mãi giúp bạn chọn người tư vấn an toàn. Gọi 0904 567 009 để hỏi trực tiếp.' ),
		'thi-truong-bat-dong-san-da-nang-2026' => array( 'thị trường bất động sản Đà Nẵng 2026', 'Thị trường bất động sản Đà Nẵng 2026: giá, nguồn cung', 'Thị trường bất động sản Đà Nẵng 2026: giá căn hộ sơ cấp khoảng 83 triệu/m², giao dịch quý 2 tăng 54%, đất nền chậm lại – xu hướng và lời khuyên.' ),
		'ky-gui-can-ho-da-nang-ban-cho-thue' => array( 'ký gửi căn hộ Đà Nẵng', 'Ký gửi căn hộ Đà Nẵng: quy trình, giấy tờ, phí', 'Ký gửi căn hộ Đà Nẵng để bán hoặc cho thuê: quy trình 5 bước, giấy tờ cần chuẩn bị, cách định giá sát thị trường. Gọi 0904 567 009 để ký gửi.' ),
		'can-ho-da-nang-2026-du-an-dang-mo-ban' => array( 'căn hộ Đà Nẵng đang mở bán', 'Căn hộ Đà Nẵng đang mở bán 2026: dự án, giá, bàn giao', 'Căn hộ Đà Nẵng đang mở bán 2026: danh sách dự án theo khu vực, giá tham khảo, thời điểm bàn giao, chính sách. Gọi Hoàng Hiệp nhận bảng giá mới.' ),
		'can-ho-view-song-han-du-an-va-gia' => array( 'căn hộ view sông Hàn', 'Căn hộ view sông Hàn: dự án và giá tham khảo 2026', 'Căn hộ view sông Hàn hai bờ Sơn Trà, Hải Châu: danh sách dự án, giá tham khảo, tình trạng bàn giao. Gọi Hoàng Hiệp để chọn căn có view đẹp nhất.' ),
		'can-ho-view-bien-da-nang-my-khe' => array( 'căn hộ view biển Đà Nẵng', 'Căn hộ view biển Đà Nẵng: dự án Mỹ Khê và giá 2026', 'Căn hộ view biển Đà Nẵng dọc Mỹ Khê, Trường Sa: danh sách dự án, loại hình, giá tham khảo 2026. Gọi Hoàng Hiệp nhận căn view biển trực diện.' ),
		'mua-can-ho-da-nang-2-ty-3-ty' => array( 'mua căn hộ Đà Nẵng 2 tỷ', 'Mua căn hộ Đà Nẵng 2 tỷ – 3 tỷ: chọn dự án nào?', 'Mua căn hộ Đà Nẵng 2 tỷ – 3 tỷ: 10 dự án có căn trong tầm giá ở FPT City, Hòa Xuân, Sơn Trà. Gọi Hoàng Hiệp nhận danh sách căn thật đang bán.' ),
		'kinh-nghiem-mua-can-ho-da-nang' => array( 'kinh nghiệm mua căn hộ Đà Nẵng', 'Kinh nghiệm mua căn hộ Đà Nẵng: 10 điều cần kiểm tra', 'Kinh nghiệm mua căn hộ Đà Nẵng: 10 điều cần kiểm tra về pháp lý, bảo lãnh, thanh toán, sở hữu và giá. Gọi Hoàng Hiệp để rà soát hồ sơ miễn phí.' ),
		'vay-mua-can-ho-da-nang-2026-lai-suat' => array( 'vay mua căn hộ Đà Nẵng', 'Vay mua căn hộ Đà Nẵng 2026: lãi suất, ân hạn nợ gốc', 'Vay mua căn hộ Đà Nẵng 2026: lãi suất ưu đãi các ngân hàng, chính sách ân hạn của dự án, ví dụ số tiền trả hằng tháng. Gọi Hoàng Hiệp tính phương án.' ),
		'gia-thue-can-ho-da-nang-moi-thang' => array( 'giá thuê căn hộ Đà Nẵng', 'Giá thuê căn hộ Đà Nẵng: bao nhiêu mỗi tháng?', 'Giá thuê căn hộ Đà Nẵng theo 12 dự án: studio đến 3PN, ven sông, ven biển, FPT City; cách tính tỷ suất cho thuê. Gọi Hoàng Hiệp để được tư vấn.' ),
		'can-ho-so-huu-lau-dai-hay-can-ho-dich-vu-50-nam' => array( 'căn hộ sở hữu lâu dài Đà Nẵng', 'Căn hộ sở hữu lâu dài Đà Nẵng hay căn hộ dịch vụ 50 năm?', 'Căn hộ sở hữu lâu dài Đà Nẵng và căn hộ dịch vụ 50 năm khác nhau thế nào: loại đất, thời hạn, vay ngân hàng, cho thuê. Gọi Hoàng Hiệp đối chiếu.' ),
		'penthouse-da-nang-du-an-va-gia' => array( 'penthouse Đà Nẵng', 'Penthouse Đà Nẵng: dự án và giá tham khảo 2026', 'Penthouse Đà Nẵng ven sông Hàn, biển Mỹ Khê: The Legend, The Filmore, The Meridian, Nobu, Times Square – diện tích, giá tham khảo. Gọi Hoàng Hiệp.' ),
		'shop-khoi-de-da-nang-co-nen-dau-tu' => array( 'shop khối đế Đà Nẵng', 'Shop khối đế Đà Nẵng: có nên đầu tư, dự án nào?', 'Shop khối đế Đà Nẵng: giá tham khảo Sun Symphony, Sun Ponte, Peninsula, Times Square; ưu nhược điểm và rủi ro. Gọi Hoàng Hiệp nhận danh sách shop.' ),
		'biet-thu-ven-bien-da-nang-hoi-an-bang-gia' => array( 'biệt thự ven biển Đà Nẵng', 'Biệt thự ven biển Đà Nẵng: bảng giá theo dự án 2026', 'Biệt thự ven biển Đà Nẵng – Hội An 2026: giá tham khảo Furama Villas, The Ocean Villas, Newtown Legend, Vinhomes Hải Vân Bay. Gọi Hoàng Hiệp xem căn.' ),
		'gia-dat-ven-bien-da-nang-vo-nguyen-giap-hoang-sa' => array( 'giá đất ven biển Đà Nẵng', 'Giá đất ven biển Đà Nẵng 2026: Võ Nguyên Giáp, Hoàng Sa', 'Giá đất ven biển Đà Nẵng 2026 theo tuyến: Võ Nguyên Giáp, Hoàng Sa, Trường Sa, Võ Văn Kiệt, Nguyễn Tất Thành. Gọi Hoàng Hiệp nhận lô đang bán.' ),
		'ban-khach-san-da-nang-ven-bien-gia-cong-suat' => array( 'bán khách sạn Đà Nẵng', 'Bán khách sạn Đà Nẵng ven biển: giá và công suất 2026', 'Bán khách sạn Đà Nẵng ven biển 2026: giá theo khu Võ Nguyên Giáp, An Thượng, Hồ Nghinh, Hội An; công suất 85 – 88%. Gọi Hoàng Hiệp xem hồ sơ.' ),
		'bat-dong-san-son-tra-2026' => array( 'bất động sản Sơn Trà', 'Bất động sản Sơn Trà 2026: dự án và giá tham khảo', 'Bất động sản Sơn Trà 2026: căn hộ ven sông Hàn, căn hộ biển Mỹ Khê, đất, khách sạn Võ Nguyên Giáp – giá bán và giá thuê tham khảo. Gọi Hoàng Hiệp.' ),
		'bat-dong-san-hai-chau-2026' => array( 'bất động sản Hải Châu', 'Bất động sản Hải Châu 2026: dự án và giá căn hộ', 'Bất động sản Hải Châu 2026: The Filmore, Danang Landmark, Masteri, The Meridian, Vista Residence – giá bán, giá thuê tham khảo. Gọi Hoàng Hiệp tư vấn.' ),
		'bat-dong-san-ngu-hanh-son-2026' => array( 'bất động sản Ngũ Hành Sơn', 'Bất động sản Ngũ Hành Sơn 2026: dự án và giá', 'Bất động sản Ngũ Hành Sơn 2026: căn hộ Newtown Diamond, Sun Cosmo, FPT City, đất nền Võ Chí Công, biệt thự Trường Sa – giá tham khảo. Gọi Hoàng Hiệp.' ),
		'bat-dong-san-lien-chieu-cang-lien-chieu' => array( 'bất động sản Liên Chiểu', 'Bất động sản Liên Chiểu 2026: cảng Liên Chiểu tác động gì', 'Bất động sản Liên Chiểu 2026: tác động của cảng Liên Chiểu, khu thương mại tự do; dự án Vinhomes Hải Vân Bay, The Ori Garden, giá đất tham khảo.' ),
		'dau-tu-bat-dong-san-da-nang-nen-chon-loai-hinh-nao' => array( 'đầu tư bất động sản Đà Nẵng', 'Đầu tư bất động sản Đà Nẵng: nên chọn loại hình nào?', 'Đầu tư bất động sản Đà Nẵng: so sánh căn hộ, căn hộ dịch vụ, biệt thự, đất nền, shop khối đế theo vốn, dòng tiền và rủi ro. Gọi Hoàng Hiệp tư vấn.' ),
		'mua-can-ho-chuyen-nhuong-da-nang-quy-trinh-giay-to' => array( 'quy trình mua căn hộ chuyển nhượng', 'Quy trình mua căn hộ chuyển nhượng ở Đà Nẵng, giấy tờ', 'Quy trình mua căn hộ chuyển nhượng ở Đà Nẵng: căn có sổ và căn chuyển nhượng hợp đồng, 6 bước, giấy tờ, checklist kiểm tra căn trước khi đặt cọc.' ),
		'thue-phi-mua-ban-nha-dat-da-nang-2026' => array( 'thuế phí mua bán nhà đất', 'Thuế phí mua bán nhà đất Đà Nẵng 2026: ai phải trả?', 'Thuế phí mua bán nhà đất 2026: thuế thu nhập cá nhân 2%, lệ phí trước bạ 0,5%, phí công chứng, ai trả, ví dụ căn hộ 4 tỷ. Gọi Hoàng Hiệp ước tính.' ),
		'cho-thue-can-ho-da-nang-hop-dong-thue-tam-tru' => array( 'cho thuê căn hộ Đà Nẵng', 'Cho thuê căn hộ Đà Nẵng: hợp đồng, thuế, tạm trú', 'Cho thuê căn hộ Đà Nẵng 2026: mẫu hợp đồng thuê, ngưỡng doanh thu 1 tỷ/năm không chịu thuế, khai báo tạm trú cho khách nước ngoài. Gọi Hoàng Hiệp.' ),
		'thue-can-ho-bien-my-khe-gia-theo-du-an' => array( 'thuê căn hộ biển Mỹ Khê', 'Thuê căn hộ biển Mỹ Khê: giá thuê theo dự án 2026', 'Thuê căn hộ biển Mỹ Khê 2026: Times Square 25 – 40 triệu, Wyndham Soleil, Hiyori Garden 2PN 15 – 25 triệu/tháng (tham khảo). Gọi Hoàng Hiệp xem căn.' ),
		'gia-chuyen-nhuong-can-ho-da-nang-2026-theo-du-an' => array( 'giá chuyển nhượng căn hộ Đà Nẵng', 'Giá chuyển nhượng căn hộ Đà Nẵng 2026 theo từng dự án', 'Giá chuyển nhượng căn hộ Đà Nẵng 10/2026 theo 15 dự án: The Ori Garden, FPT Plaza, Sun Cosmo, Sun Ponte, Peninsula, Filmore. Gọi Hoàng Hiệp nhận căn.' ),
		'so-sanh-villa-ven-bien-da-nang-co-so' => array( 'villa ven biển Đà Nẵng có sổ', 'Villa ven biển Đà Nẵng có sổ: so sánh 4 dự án 2026', 'Villa ven biển Đà Nẵng có sổ: so sánh Furama Villas, Fusion, Premier Village, Hyatt Regency về vị trí, quy mô, giá tham khảo 10/2026 và pháp lý.' ),
		'kiem-tra-phap-ly-quy-hoach-nha-dat-da-nang' => array( 'kiểm tra quy hoạch Đà Nẵng', 'Kiểm tra quy hoạch Đà Nẵng và pháp lý trước khi mua', 'Kiểm tra quy hoạch Đà Nẵng và pháp lý nhà đất: tra cứu cổng thông tin Sở Xây dựng, sổ, thế chấp, tranh chấp, hồ sơ dự án. Gọi Hoàng Hiệp hỗ trợ.' ),
		'hop-dong-dat-coc-mua-nha-rui-ro-phong-tranh' => array( 'hợp đồng đặt cọc mua nhà', 'Hợp đồng đặt cọc mua nhà: rủi ro và cách phòng tránh', 'Hợp đồng đặt cọc mua nhà đất: Điều 328 Bộ luật Dân sự, phạt cọc, 6 rủi ro thường gặp, điều khoản cần có và cách phòng tránh. Gọi Hoàng Hiệp.' ),

		// Bài gắn với dự án: từ khoá dài, trang dự án giữ "giá / bảng giá {Tên}".
		'fours-tower-da-nang-tong-quan-4-thap-bon-mua' => array( 'tổng quan FourS Tower', 'Tổng quan FourS Tower Đà Nẵng: 4 tháp Bốn Mùa', 'Tổng quan FourS Tower Đà Nẵng: 4 tháp Mai, Trúc, Cúc, Tùng 20 tầng, khoảng 2.291 căn Studio – 3PN sở hữu lâu dài. Gọi 0904 567 009 nhận tài liệu.' ),
		'gia-fours-tower-2026' => array( 'giá căn hộ FourS Tower theo loại căn', 'Giá căn hộ FourS Tower theo loại căn 2026', 'Giá căn hộ FourS Tower theo loại căn 2026: Studio từ khoảng 1,7 tỷ, 2PN từ khoảng 3,6 tỷ (tham khảo). Gọi 0904 567 009 nhận bảng giá chính thức.' ),
		'mat-bang-fours-tower-studio-3pn' => array( 'mặt bằng FourS Tower', 'Mặt bằng FourS Tower: layout Studio đến 3PN', 'Mặt bằng FourS Tower: Studio khoảng 34,7 m², 2PN 58 m², 3PN 102,8 m², phân tích layout và cách chọn căn. Gọi 0904 567 009 nhận mặt bằng từng tầng.' ),
		'chinh-sach-fours-tower-thanh-toan-vay-ngan-hang' => array( 'chính sách bán hàng FourS Tower', 'Chính sách bán hàng FourS Tower: thanh toán, vay vốn', 'Chính sách bán hàng FourS Tower: thanh toán 70% nhận nhà, Early Bird 5%, hỗ trợ vay 70% lãi 0% có thời hạn. Gọi 0904 567 009 nhận chính sách mới.' ),
		'fours-tower-f2-thap-mai-mua-xuan' => array( 'FourS Tower F2 Tháp Mai', 'FourS Tower F2 Tháp Mai: khác gì 3 tháp còn lại?', 'FourS Tower F2 Tháp Mai (Mùa Xuân) ra mắt 26/9 với 1.369 lượt đặt chỗ, định hướng an cư đa thế hệ. So sánh với 3 tháp còn lại, gọi nhận bảng giá F2.' ),
		'co-nen-mua-can-ho-fours-tower' => array( 'có nên mua FourS Tower', 'Có nên mua FourS Tower? Ưu – nhược điểm 2026', 'Có nên mua FourS Tower? Phân tích vị trí, giá tham khảo, ưu – nhược điểm và ai nên mua, ai nên cân nhắc. Gọi Hoàng Hiệp 0904 567 009 nhận bảng giá.' ),
		'so-sanh-fours-tower-spana-tower-s-light-tower' => array( 'so sánh FourS Tower, Spana Tower, S-Light Tower', 'So sánh FourS Tower, Spana Tower, S-Light Tower', 'So sánh FourS Tower, Spana Tower, S-Light Tower của Sun Group: vị trí, quy mô, thời điểm bàn giao, giá tham khảo. Gọi Hoàng Hiệp để chọn dự án hợp.' ),
		'sun-riverpolis-khu-do-thi-ven-song-hoa-quy' => array( 'khu đô thị Sun Riverpolis', 'Khu đô thị Sun Riverpolis ven sông Hòa Quý có gì?', 'Khu đô thị Sun Riverpolis của Sun Group tại Hòa Quý: vị trí, quy mô, các phân khu FourS Tower và đất nền Đầm Sen. Gọi Hoàng Hiệp nhận thông tin mới.' ),
		'dat-nen-dam-sen-sun-riverpolis-gia-phap-ly' => array( 'pháp lý đất nền Đầm Sen', 'Pháp lý đất nền Đầm Sen Sun Riverpolis và giá lô', 'Pháp lý đất nền Đầm Sen Sun Riverpolis: khoảng 900 lô 100 – 150 m², sổ đỏ lâu dài theo đơn vị phân phối, giá tham khảo từ 4,8 tỷ. Gọi Hoàng Hiệp.' ),
		'bat-dong-san-nam-da-nang-ha-tang-hoa-xuan-hoa-quy-2026' => array( 'bất động sản Nam Đà Nẵng', 'Bất động sản Nam Đà Nẵng 2026: hạ tầng và giá', 'Bất động sản Nam Đà Nẵng 2026: cụm nút giao cầu Hòa Xuân, giá căn hộ, đất nền Hòa Xuân – Hòa Quý và các dự án đáng chú ý. Gọi Hoàng Hiệp tư vấn.' ),
		'casamia-balanca-hoi-an-tong-quan-du-an' => array( 'tổng quan Casamia Balanca', 'Tổng quan Casamia Balanca Hội An: khu đô thị 31,1 ha', 'Tổng quan Casamia Balanca Hội An: khu đô thị sinh thái 31,1 ha của Đạt Phương bên sông Cổ Cò, biệt thự ven sông, đã có sổ hồng từng lô (8/2026).' ),
		'gia-biet-thu-casamia-balanca-2026' => array( 'giá biệt thự Casamia Balanca theo dòng sản phẩm', 'Giá biệt thự Casamia Balanca theo dòng sản phẩm 2026', 'Giá biệt thự Casamia Balanca theo dòng sản phẩm 2026: khoảng 10 – 20 tỷ/căn, Forestside từ 16 tỷ, cách tính tổng chi phí. Gọi Hoàng Hiệp nhận giá.' ),
		'chinh-sach-ban-hang-casamia-balanca' => array( 'chính sách bán hàng Casamia Balanca', 'Chính sách bán hàng Casamia Balanca 2026', 'Chính sách bán hàng Casamia Balanca 2026: cọc 100 triệu, ký hợp đồng 30%, chiết khấu khi không vay, hỗ trợ vay 70%. Gọi Hoàng Hiệp nhận bản mới nhất.' ),
		'cho-thue-biet-thu-casamia-balanca-dong-tien' => array( 'cho thuê Casamia Balanca', 'Cho thuê Casamia Balanca: giá thuê và dòng tiền', 'Cho thuê Casamia Balanca: giá thuê villa khu Cẩm Thanh, công thức ước tính dòng tiền, lưu ý gói cam kết thuê. Gọi Hoàng Hiệp 0904 567 009 nhận bảng tính.' ),
		'phap-ly-so-hong-casamia-balanca' => array( 'pháp lý Casamia Balanca', 'Pháp lý Casamia Balanca: sổ hồng và thời hạn trên sổ', 'Pháp lý Casamia Balanca: đã cấp sổ hồng các lô tháng 8/2026, đất ở đô thị, thời hạn ghi trên sổ, checklist hồ sơ khi mua. Gọi Hoàng Hiệp 0904 567 009.' ),
		'dau-tu-biet-thu-casamia-balanca-bai-toan-dong-tien' => array( 'đầu tư biệt thự Casamia Balanca', 'Đầu tư biệt thự Casamia Balanca: 3 kịch bản dòng tiền', 'Đầu tư biệt thự Casamia Balanca: 3 kịch bản trả đủ, vay 50 – 70%, chia doanh thu; công suất 40/55/70%, điểm hòa vốn. Gọi Hoàng Hiệp nhận file tính.' ),
		'casamia-balanca-so-sanh-biet-thu-hoi-an' => array( 'có nên mua Casamia Balanca', 'Có nên mua Casamia Balanca? So sánh biệt thự Hội An', 'Có nên mua Casamia Balanca? So sánh vị trí, pháp lý, giá với Hoiana Beach Villas, Vinpearl Nam Hội An, The Ocean Villas. Gọi Hoàng Hiệp 0904 567 009.' ),
		'spana-tower-hoa-xuan-gia-mat-bang' => array( 'mặt bằng Spana Tower', 'Mặt bằng Spana Tower Hòa Xuân và giá tham khảo', 'Mặt bằng Spana Tower Hòa Xuân của Sun Group: 2 tòa 22 tầng, khoảng 1.281 căn, giá tham khảo từ 1,9 tỷ, tiến độ xây dựng. Gọi Hoàng Hiệp nhận bảng giá.' ),
		's-light-tower-mo-ban-2026' => array( 'S-Light Tower mở bán', 'S-Light Tower mở bán 2026: đợt mới, loại căn', 'S-Light Tower mở bán 2026: dự án Sun Property ở Hòa Xuân, 2 tháp 22 tầng, gần 800 căn 33,3 – 95,1 m², đợt mở bán mới. Gọi Hoàng Hiệp nhận thông tin.' ),
		'cora-tower-sun-neo-city' => array( 'mặt bằng Cora Tower', 'Mặt bằng Cora Tower Sun NeO City: 28 căn/tầng', 'Mặt bằng Cora Tower ở giao lộ Nguyễn Phước Lan – 29/3, trung tâm Sun NeO City: 28 căn/tầng, Studio – 3PN, dự kiến bàn giao 7/2027. Gọi Hoàng Hiệp.' ),
		'sun-symphony-da-nang-gia-chuyen-nhuong-cho-thue' => array( 'giá chuyển nhượng Sun Symphony', 'Giá chuyển nhượng Sun Symphony và giá cho thuê 2026', 'Giá chuyển nhượng Sun Symphony Đà Nẵng từ khoảng 3,2 tỷ, cho thuê 1PN – 2PN khoảng 12 – 25 triệu/tháng (tham khảo). Gọi Hoàng Hiệp nhận căn thật.' ),
		'so-sanh-can-ho-ven-song-han-sun-symphony-sun-ponte-peninsula' => array( 'so sánh căn hộ ven sông Hàn', 'So sánh căn hộ ven sông Hàn: Sun Symphony, Sun Ponte', 'So sánh căn hộ ven sông Hàn Sun Symphony, Sun Ponte, Peninsula: quy mô, giá chuyển nhượng, giá thuê, bàn giao. Gọi Hoàng Hiệp để chọn căn phù hợp.' ),
		'masteri-da-nang-gia-tien-do-ban-giao' => array( 'tiến độ Masteri Đà Nẵng', 'Tiến độ Masteri Đà Nẵng: bàn giao 2026, giá bán', 'Tiến độ Masteri Đà Nẵng (Masteri Rivera Danang): 2 tháp 39 tầng, cất nóc 12/2025, bàn giao quý III – IV/2026, giá từ khoảng 4,13 tỷ. Gọi Hoàng Hiệp.' ),
		'the-meridian-da-nang-co-nen-mua' => array( 'có nên mua The Meridian Đà Nẵng', 'Có nên mua The Meridian Đà Nẵng? Giá và rủi ro', 'Có nên mua The Meridian Đà Nẵng: 518 căn ven sông Hàn, khoảng 70 – 95 triệu/m², bàn giao dự kiến 2027 – ưu điểm, rủi ro, tư vấn chọn căn phù hợp.' ),
		'nobu-da-nang-can-ho-hang-hieu' => array( 'căn hộ hàng hiệu Nobu Đà Nẵng', 'Căn hộ hàng hiệu Nobu Đà Nẵng ven biển Mỹ Khê', 'Căn hộ hàng hiệu Nobu Đà Nẵng: tháp 43 tầng, 264 căn hộ và 186 phòng khách sạn bên biển Mỹ Khê, khoảng 145 – 205 triệu/m². Gọi Hoàng Hiệp nhận giá.' ),
		'danang-landmark-can-ho-canh-cau-rong' => array( 'căn hộ Danang Landmark cạnh cầu Rồng', 'Căn hộ Danang Landmark cạnh cầu Rồng: có gì?', 'Căn hộ Danang Landmark cạnh cầu Rồng: tháp đôi 39 và 31 tầng, 454 căn, đủ điều kiện kinh doanh 3/2026, khoảng 94 – 130 triệu/m². Gọi Hoàng Hiệp.' ),
		'm-riverside-da-nang-gia-chinh-sach' => array( 'chính sách bán hàng M Riverside', 'Chính sách bán hàng M Riverside Đà Nẵng 2026', 'Chính sách bán hàng M Riverside Đà Nẵng 2026: 312 căn ven sông Hàn, khoảng 104 – 136 triệu/m², chiết khấu tới khoảng 26%. Gọi Hoàng Hiệp nhận bản mới.' ),
		'newtown-diamond-3-toa-va-newtown-legend' => array( 'các tòa Newtown Diamond', 'Các tòa Newtown Diamond và Newtown Legend Đà Nẵng', 'Các tòa Newtown Diamond: The Ruby, The Sapphire, The Diamond (1.733 căn) và Newtown Legend 60 căn thấp tầng – giá tham khảo 2026. Gọi Hoàng Hiệp.' ),
		'vinhomes-hai-van-bay-cap-nhat-2026' => array( 'phân khu Vinhomes Hải Vân Bay', 'Phân khu Vinhomes Hải Vân Bay: cập nhật 10/2026', 'Phân khu Vinhomes Hải Vân Bay cập nhật 10/2026: Bạch Vân, Đảo Ngọc, Vịnh Mây, Tinh Vân; liền kề từ khoảng 5,2 tỷ, tiến độ. Gọi Hoàng Hiệp nhận giá.' ),
		'sun-cosmo-residence-gia-chuyen-nhuong-cho-thue' => array( 'giá chuyển nhượng Sun Cosmo Residence', 'Giá chuyển nhượng Sun Cosmo Residence, cho thuê 2026', 'Giá chuyển nhượng Sun Cosmo Residence: khoảng 650 căn, 65 – 95 triệu/m², cho thuê 2PN 30 – 35 triệu/tháng (tham khảo 10/2026). Gọi Hoàng Hiệp.' ),
		'sun-ponte-residence-gia-chuyen-nhuong-cho-thue' => array( 'giá chuyển nhượng Sun Ponte Residence', 'Giá chuyển nhượng Sun Ponte Residence, cho thuê 2026', 'Giá chuyển nhượng Sun Ponte Residence cạnh cầu Rồng: 495 căn, 70 – 112 triệu/m², cho thuê 2PN 32 – 40 triệu/tháng (tham khảo 10/2026). Gọi Hoàng Hiệp.' ),
		'peninsula-da-nang-gia-chuyen-nhuong-cho-thue' => array( 'giá chuyển nhượng Peninsula Đà Nẵng', 'Giá chuyển nhượng Peninsula Đà Nẵng, cho thuê 2026', 'Giá chuyển nhượng Peninsula Đà Nẵng: khoảng 941 căn ven sông Hàn, 50 – 83 triệu/m², cho thuê 2PN 23 – 30 triệu/tháng (tham khảo 10/2026). Gọi Hiệp.' ),
		'hiyori-garden-tower-hiyori-aqua-tower-da-nang' => array( 'Hiyori Garden Tower và Hiyori Aqua Tower', 'Hiyori Garden Tower và Hiyori Aqua Tower: giá 2026', 'Hiyori Garden Tower và Hiyori Aqua Tower Đà Nẵng: 2PN Garden 5 – 6,7 tỷ, thuê 15 – 25 triệu; Aqua Tower 202 căn, 2PN khoảng 4,5 tỷ (tham khảo).' ),
		'the-filmore-da-nang-gia-chuyen-nhuong-cho-thue' => array( 'giá chuyển nhượng The Filmore', 'Giá chuyển nhượng The Filmore Đà Nẵng, cho thuê 2026', 'Giá chuyển nhượng The Filmore Đà Nẵng: 206 căn hạng sang ven sông Hàn, 1PN 4,5 – 7,6 tỷ, cho thuê 2PN 35 – 40 triệu/tháng (tham khảo 10/2026).' ),
		'biet-thu-vinpearl-da-nang-hoi-an-gia-chuyen-nhuong' => array( 'giá chuyển nhượng biệt thự Vinpearl Đà Nẵng', 'Giá chuyển nhượng biệt thự Vinpearl Đà Nẵng 2026', 'Giá chuyển nhượng biệt thự Vinpearl Đà Nẵng – Hội An 2026: Vinpearl Luxury, Vinpearl 2, Nam Hội An – sổ đỏ, chương trình cho thuê. Gọi Hoàng Hiệp.' ),
		'naman-residences-shilla-monogram-villa-nghi-duong' => array( 'biệt thự Naman Residences', 'Biệt thự Naman Residences và Shilla Monogram', 'Biệt thự Naman Residences: 34 căn trên đường Trường Sa, giá mở bán từ khoảng 10,9 tỷ; Shilla Monogram resort 5 sao Điện Ngọc. Gọi Hoàng Hiệp nhận giá.' ),
		'shantira-hoi-an-biet-thu-can-ho-gia-tham-khao' => array( 'giá chuyển nhượng Shantira Hội An', 'Giá chuyển nhượng Shantira Hội An: biệt thự, căn hộ', 'Giá chuyển nhượng Shantira Hội An (Wyndham Shantira): biệt thự LegaSea, căn hộ du lịch, giá gốc, giá bán lại, cho thuê 10/2026. Gọi Hoàng Hiệp nhận giá.' ),
		'capital-square-da-nang-cac-toa-loai-can-gia' => array( 'các tòa Capital Square Đà Nẵng', 'Các tòa Capital Square Đà Nẵng: loại căn, mã tòa', 'Các tòa Capital Square Đà Nẵng: 14 tòa, 3.391 căn ven sông Hàn, mã tòa The King, The Queen, MAT, LAT; giá 1PN – 3PN tham khảo 10/2026. Gọi Hiệp.' ),
		'dat-nen-hoa-xuan-2026-gia-theo-khu' => array( 'giá đất nền Hòa Xuân 2026', 'Giá đất nền Hòa Xuân 2026 theo từng khu', 'Giá đất nền Hòa Xuân 2026 theo từng khu: Cồn Dầu, Euro Village 2, Nam Hòa Xuân, đất ven sông; tác động cầu Hòa Xuân. Gọi Hoàng Hiệp nhận lô đang bán.' ),
		'bat-dong-san-cam-le-2026' => array( 'bất động sản Cẩm Lệ', 'Bất động sản Cẩm Lệ 2026: căn hộ, đất nền, giá', 'Bất động sản Cẩm Lệ 2026: căn hộ Cora, Spana, S-Light Tower, đất nền Cồn Dầu, Euro Village 2, giá tham khảo và hạ tầng cầu Hòa Xuân. Gọi Hoàng Hiệp.' ),
		'bat-dong-san-hoi-an-2026-sau-hop-nhat' => array( 'bất động sản Hội An', 'Bất động sản Hội An 2026 sau hợp nhất Đà Nẵng', 'Bất động sản Hội An 2026 sau hợp nhất: phường mới, giá tham khảo biệt thự Casamia, Shantira, villa, khách sạn An Bàng và lưu ý pháp lý. Gọi Hiệp.' ),
	);
}

/** Áp bản đồ từ khoá khi nhập bài; giữ giá trị cũ để web nhận ra ô do web tự điền (được phép đổi). */
add_filter(
	'hh_news_items',
	static function ( $items ) {
		$map     = hh_seo_keyword_map();
		$seo_all = function_exists( 'hh_news_seo' ) ? hh_news_seo() : array();
		foreach ( $items as $i => $n ) {
			if ( empty( $map[ $n['slug'] ] ) ) {
				continue;
			}
			list( $kw, $title, $desc ) = $map[ $n['slug'] ];
			$seo  = $n['seo'] ?? ( $seo_all[ $n['slug'] ] ?? array() );
			$old  = (array) ( $n['old_meta'] ?? array() );
			$prev = array(
				'rank_math_focus_keyword' => $n['keyword'] ?? '',
				'rank_math_title'         => $seo['seo_title'] ?? '',
				'rank_math_description'   => $seo['desc'] ?? '',
			);
			foreach ( $prev as $key => $value ) {
				if ( '' !== $value ) {
					$old[ $key ] = array_merge( (array) ( $old[ $key ] ?? array() ), array( $value ) );
				}
			}
			$seo['seo_title']       = $title;
			$seo['desc']            = $desc;
			$items[ $i ]['keyword'] = $kw;
			$items[ $i ]['seo']     = $seo;
			$items[ $i ]['old_meta'] = $old;
		}
		return $items;
	}
);

/** Tiêu đề SEO dự án do web nhập trước đây dài quá 60 ký tự → bản rút gọn (chỉ đổi khi anh chưa sửa tay). */
add_filter(
	'hh_project_dataset',
	static function ( $projects ) {
		$fix = array(
			'vinhomes-hai-van-bay-bach-van' => 'Phân khu Bạch Vân Vinhomes Hải Vân Bay: Giá & giỏ hàng T10/2026',
			'vinhomes-hai-van-bay-vinh-may' => 'Phân khu Vịnh Mây Vinhomes Hải Vân Bay: Giá biệt thự T10/2026',
			'vinhomes-hai-van-bay-dao-ngoc' => 'Phân khu Đảo Ngọc Vinhomes Hải Vân Bay: Giá & giỏ hàng T10/2026',
			'vinhomes-hai-van-bay-tinh-van' => 'Phân khu Tinh Vân Vinhomes Hải Vân Bay (Khu 4): Thông tin mới',
		);
		foreach ( $projects as $i => $p ) {
			$slug = $p['slug'] ?? '';
			if ( isset( $fix[ $slug ] ) && ! empty( $p['meta']['rank_math_title'] ) ) {
				$projects[ $i ]['fix_meta']                    = (array) ( $p['fix_meta'] ?? array() );
				$projects[ $i ]['fix_meta']['rank_math_title'] = $fix[ $slug ]; // Giá trị cũ → thay bằng meta mới.
			}
		}
		return $projects;
	},
	999
);

/** Tên ngắn của dự án (VD "FourS Tower") – dùng cho anchor "bảng giá {Tên}". */
function hh_seo_project_short_name( $project_id ) {
	$post = get_post( $project_id );
	if ( ! $post ) {
		return '';
	}
	$kw = function_exists( 'hh_rm_project_keywords' ) ? hh_rm_project_keywords( $post ) : '';
	foreach ( explode( ',', $kw ) as $k ) {
		if ( 0 === strpos( $k, 'bảng giá ' ) ) {
			return trim( substr( $k, strlen( 'bảng giá ' ) ) );
		}
	}
	return trim( preg_replace( '/\s*\([^)]*\)/u', '', get_the_title( $post ) ) );
}

/**
 * Mỗi bài gắn dự án: 1 liên kết về trang dự án với anchor đúng từ khoá "bảng giá {Tên}" (thêm khi hiển thị,
 * không sửa nội dung đã lưu). Bỏ qua nếu bài đã có liên kết anchor đó.
 */
add_filter(
	'the_content',
	static function ( $html ) {
		if ( ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() ) {
			return $html;
		}
		$pid = (int) get_post_meta( get_the_ID(), 'hh_post_project', true );
		if ( ! $pid || 'publish' !== get_post_status( $pid ) || 'du-an' !== get_post_type( $pid ) ) {
			return $html;
		}
		$name   = hh_seo_project_short_name( $pid );
		$name   = preg_match( '/^(Đất|Biệt|Căn|Khu|Nhà|Shophouse)\s/u', $name ) ? mb_strtolower( mb_substr( $name, 0, 1 ) ) . mb_substr( $name, 1 ) : $name; // "bảng giá đất nền Đầm Sen".
		$anchor = 'bảng giá ' . $name;
		if ( '' === $name || false !== mb_stripos( wp_strip_all_tags( $html ), $anchor ) && false !== strpos( $html, wp_make_link_relative( get_permalink( $pid ) ) ) ) {
			return $html;
		}
		$box = sprintf(
			'<p class="hh-project-link">📋 Xem <a href="%s">%s</a> mới nhất, chính sách và giỏ hàng đang bán trên trang dự án.</p>',
			esc_url( get_permalink( $pid ) ),
			esc_html( $anchor )
		);
		// Chèn sau đoạn văn thứ 2 để Google và người đọc thấy sớm.
		$pos = 0;
		for ( $k = 0; $k < 2; $k++ ) {
			$found = strpos( $html, '</p>', $pos );
			if ( false === $found ) {
				return $html . $box;
			}
			$pos = $found + 4;
		}
		return substr( $html, 0, $pos ) . $box . substr( $html, $pos );
	},
	12
);
