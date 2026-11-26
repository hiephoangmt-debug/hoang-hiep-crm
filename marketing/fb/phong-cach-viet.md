# Phong cách viết bài Facebook – Hoàng Hiệp (anh Hiệp chốt 05/11/2026)

Yêu cầu của anh: ảnh đẹp chuẩn FB; lời văn **mềm mỏng, nhẹ nhàng, không cứng nhắc, không giống bot** và **chỉn chu** (cập nhật 05/11: "ngôn từ cũng chỉnh chu chút").

> File này là chuẩn mới nhất – ưu tiên hơn mọi tóm tắt phong cách ghi trong các lịch tự động.

## Chỉn chu
- Câu đầy đủ chủ – vị, đúng chính tả, dấu câu chuẩn; viết rõ đơn vị ("tỷ đồng", "ha", "ngày 29/3/2027"), tên đầy đủ ("Khu đô thị", không viết tắt KĐT trong caption).
- Lịch sự, chuyên nghiệp: "anh chị", "Hiệp xin chia sẻ/gợi ý", "vui lòng nhắn Hiệp", "ạ" đặt cuối câu mời. Hạn chế "nha", không dùng "nè", "chill", "thả thính", "hóng", từ lóng.
- Dí dỏm chỉ ở mức một hình ảnh/câu mở tinh tế; phần số liệu và nhận định viết nghiêm túc.
- Cấu trúc thống nhất: câu mở (1–2 câu) → 3–5 gạch đầu dòng 1️⃣2️⃣3️⃣ → "Góc nhìn của Hiệp:" → lời mời → "📲 Inbox/Zalo: 0904 567 009" → ghi chú ảnh → hashtag.

## Viết theo key (anh Hiệp chốt 07/11/2026)
- Mỗi bài chọn **1 từ khoá chính** = `keyword` của bài web gắn link ở bình luận đầu (xem data-bai-viet-*.php hoặc wordpress/tu-dong/bai/*.txt). Bài không có bài web: chọn cụm khách hay tìm, ví dụ "giá Sun Saphia Residence", "căn hộ biển Đà Nẵng".
- Từ khoá chính nằm ở **câu đầu tiên** (càng gần đầu càng tốt), lặp lại tự nhiên 1–2 lần trong thân bài hoặc "Góc nhìn của Hiệp", và là tiêu đề lớn trên ảnh.
- Dùng 2–3 **từ khoá phụ** (`keywords_extra`) làm đầu mục, gạch đầu dòng, ví dụ "Tiêu chuẩn bàn giao Sun Saphia:", "Phí quản lý Sun Saphia:".
- Hashtag đầu tiên là từ khoá chính viết liền (#SunSaphiaResidence), sau đó là #BatDongSanDaNang và khu vực.
- Viết tự nhiên, không nhồi từ khoá, không lặp quá 3 lần, câu vẫn mềm mỏng và chỉn chu như trên.

## Đăng từng bài một (anh Hiệp chốt 07/11/2026)
- Không đẩy nhiều bài cùng lúc. Mỗi bài một giờ riêng; cùng trang cách nhau ≥3 tiếng, giữa 2 trang lệch nhau ≥1 tiếng; bài web cách nhau ≥2 tiếng (trình xuất bài web tự lùi bài trùng giờ).
- Trước khi hẹn luôn getScheduledPosts cả 2 trang để né giờ đã có bài.

## TikTok (anh Hiệp đồng ý 13/11/2026; ĐỔI MẪU 18/11/2026)
- Tài khoản TikTok @hiephoangmt kết nối trong brand Sun (blogId 7637635) → mỗi bài trang Sun và trang Casamia đăng thêm 1 bài TikTok riêng (providers chỉ tiktok, blogId 7637635), giờ = giờ bài FB + 15 phút. TikTok CHỈ đăng nội dung Sun và Casamia (14/11/2026); bài trang Hoàng Hiệp KHÔNG đăng TikTok.
- MẪU MỚI (anh Hiệp 18/11/2026: "2–3 hình: hình thông điệp tò mò, hình 2 số liệu dẫn chứng câu tò mò, số liệu nhiều chút để khách hiểu; thông điệp dưới không cần viết nhiều, chỉ để tò mò và hashtag"):
  - KHÔNG dùng lại ảnh/album FB. Làm bộ 3 ảnh dọc 1080×1920 bằng `python3 wordpress/bai-viet/tiktok-slides.py marketing/tiktok/cau-hinh/<slug>.json <anh-dai-dien.jpg> marketing/tiktok/<slug>` → `<slug>-1.jpg` (câu tò mò), `-2.jpg` (số liệu), `-3.jpg` (ảnh thật + Zalo). Mẫu cấu hình: marketing/tiktok/cau-hinh/so-sanh-biet-thu-hoi-an.json.
  - Ảnh 1 – câu tò mò: "hook" 3 dòng (chữ thường / IN HOA to màu đồng / chữ nghiêng ngắn) + "question" 1 câu hỏi phụ có con số thật. Gợi tò mò bằng một con số hoặc một nghịch lý CÓ THẬT trong nguồn (ví dụ "Cùng là biệt thự Hội An – GẤP 7 LẦN – vì sao?"), không giật tít sai sự thật, không hứa lời.
  - Ảnh 2 – số liệu dẫn chứng: "data_title" + 4–6 dòng "rows" [con số, nhãn, giải thích ngắn ≤ 28 ký tự] trả lời câu tò mò; "note" ghi nguồn và thời điểm. Con số ≤ 12 ký tự, chỉ dùng số có trong nguồn.
  - Ảnh 3 – ảnh thật/phối cảnh đẹp nhất, "photo_caption" 1 câu, "cta" ngắn (ví dụ "Bảng giá: Zalo 0904 567 009").
  - Mở xem cả 3 ảnh trước khi đăng (script báo "TRAN CHU" nếu tràn); chữ quan trọng nằm trong vùng an toàn (không sát mép phải, không ở 1/5 dưới cùng).
  - media = [ảnh 1, ảnh 2, ảnh 3] (raw URL theo mã commit nhánh metricool), photoCoverIndex 0.
- LỜI BÀI TIKTOK: chỉ 1–2 câu ngắn gợi tò mò (có từ khoá chính) + "Vuốt xem số liệu 👉" + 4–5 hashtag có #DaNang. KHÔNG gạch đầu dòng, KHÔNG "Góc nhìn của Hiệp", không viết dài (TikTok gộp xuống dòng thành một đoạn). Ví dụ: "Cùng là biệt thự Hội An, sao giá chênh tới 7 lần? Vuốt xem số liệu 👉 #CasamiaBalanca #BietThuHoiAn #HoiAn #DaNang".
- tiktokData: {"title": "<từ khoá chính ≤ 90 ký tự>", "privacyOption":"PUBLIC_TO_EVERYONE", "commercialContentOwnBrand":true, "commercialContentThirdParty":false, "autoAddMusic":true, "photoCoverIndex":0}; firstCommentText rỗng. Video thì autoAddMusic false.
- Quy tắc pháp lý (mục PHÁP LÝ…) áp dụng cả ảnh TikTok: số cho thuê/giá ghi rõ nguồn ở "note", không cam kết lợi nhuận.

## Trang Casamia Balanca (kết nối 13/11/2026, anh Hiệp chọn 2 bài/ngày)
- Metricool blogId 8074284, chỉ nội dung Casamia Balanca (Đạt Phương, Cẩm Thanh – Hội An); có thể nhắc Casamia Hội An, Casamia Calm khi so sánh.
- 2 bài/ngày: 09:30 và 19:30 (anh Hiệp 18/11/2026: bài dự án sáng 9h, tối 19h; lệch 30 phút với trang Sun). Xoay vòng góc, không lặp trong 7 ngày: tổng quan; tiện ích sống; nội thất; tiến độ thực tế (flycam); pháp lý sổ hồng; loại biệt thự (đơn lập, song lập, shophouse); vị trí – kết nối Hội An, Đà Nẵng; bài toán dòng tiền 5–10 năm; so sánh biệt thự Hội An; sự kiện khách hàng; sống chậm ven sông Cổ Cò.
- Ảnh: hh-crm/img/casamia-balanca/ (45 ảnh: flycam, phối cảnh, lifestyle, nội thất, sự kiện). Không đăng ảnh so-do-mat-bang làm ảnh đầu, không đăng so-hong-lo-sl3 (có mã lô). Album 3–4 ảnh không chữ, hoặc 1 thẻ dọc khi có số liệu.
- Nguồn số liệu: data-du-an.php (slug casamia-balanca-hoi-an), data-bai-viet-casamia-dong-tien.php. Link: https://hiephoangmt.com/du-an/casamia-balanca-hoi-an/ hoặc bài web Casamia.

## Giọng văn
- Như anh Hiệp nhắn cho khách quen: xưng "Hiệp"/"mình", gọi "anh chị", dùng "ạ" lịch sự (hạn chế "nha").
- Câu mở nhẹ nhàng, ấm áp, gần đời thường; dí dỏm vừa phải.
  - VD: "Sun Ponte Residence bên cầu Rồng đã dần hoàn thiện 🌇"
  - VD: "Tin vui cho khu vực Chu Lai – Núi Thành 🌿"
  - VD: "Thị trường căn hộ Đà Nẵng quý III/2026 có một số điểm đáng chú ý, Hiệp xin chia sẻ cùng anh chị 📊"
- 3–5 gạch đầu dòng số 1️⃣2️⃣3️⃣, ngắn, số liệu chính xác theo nguồn.
- "Góc nhìn của Hiệp": 1–2 câu dạng gợi ý, chia sẻ ("anh chị có thể…", "mình cứ thong thả…", "khá đáng để tìm hiểu"). Không ra lệnh, không phán giá.
- Kết bằng lời mời nhẹ, lịch sự: "Anh chị quan tâm …, vui lòng nhắn Hiệp để nhận … tham khảo ạ." + "📲 Inbox/Zalo: 0904 567 009".
- Bình luận đầu: "Thông tin chi tiết …, anh chị tham khảo tại đây ạ 👉 <link>".
- 3–4 hashtag (#BatDongSanDaNang + dự án/khu vực). Emoji 3–5, chọn loại dịu (🌿🌅🌇🌊😊🏡📊🎆).

## Tránh
- Câu ra lệnh, giọng dạy đời: "đừng…", "phải…", "xuống tiền liền", "chốt ngay".
- Chữ mạnh, giật: "lì", "bay", "cháy hàng", "hot hòn họt", "duy nhất", "cơ hội cuối cùng".
- VIẾT HOA cả câu, dấu chấm than dồn dập, hứa "miễn phí", "cam kết lời", "đại lý chính thức".

## Ảnh (anh Hiệp góp ý 05/11: "bài đăng hình không đẹp" – bài FPT Plaza 3 dùng 6 thẻ chữ khung ngang bị Facebook cắt mất chữ)
- Ảnh đầu tiên: khổ DỌC 1080×1350, chứa toàn bộ thông tin chính (tiêu đề, bảng giá/số liệu gọn, ảnh đại diện Hoàng Hiệp). Mẫu: wordpress/bai-viet/fb-fpt-plaza-3-can-co-so-11-2026.py (nhánh wordpress).
- **Ảnh có chữ (thẻ thông tin, bảng giá, chính sách) → đăng MỘT ẢNH DUY NHẤT** (media chỉ 1 URL). Anh Hiệp góp ý 05/11: album 3 ảnh làm Facebook ép ảnh đầu thành cột dọc hẹp (~1:2), cắt mất hai bên ảnh chính sách FourS.
- Bài album (2–4 ảnh) CHỈ gồm ảnh thật / phối cảnh không có chữ quan trọng; ảnh đầu ưu tiên khổ ngang hoặc vuông. Không trộn thẻ chữ vào album.
- KHÔNG dùng nhiều thẻ chữ khung ngang trong một album: Facebook cắt ảnh thành ô vuông, chữ sát mép sẽ mất. Nếu bắt buộc có chữ trên ảnh phụ, đặt chữ trong vùng giữa (cách mép trái/phải ≥ 20% chiều rộng).
- Không dùng ảnh mặt bằng có in mã căn; không đặt mặt bằng làm ảnh đầu.
- Trước khi hẹn: ghép thử album thành lưới như Facebook hiển thị và mở ra xem lại.

## Mẫu thiết kế ảnh (anh Hiệp chọn 14/11/2026: MẪU B – "Sang")
- Thẻ dọc 1080×1350 dùng mẫu B: `python3 wordpress/bai-viet/fb-the-doc-v2.py sang <cau-hinh.json> <anh-dai-dien.jpg> <anh-nen.jpg> marketing/fb/<slug>-b.jpg` (cùng file cấu hình JSON như mẫu cũ; font Be Vietnam Pro + Playfair trong wordpress/bai-viet/fonts/).
- Nền ngà, ảnh bo góc phía trên, tiêu đề chữ có chân, 4 con số vàng đồng, 4 ý chia 2 cột, dòng chốt nền xanh đậm, chân ảnh đại diện.
- Tiêu đề dài quá 2 dòng thì rút gọn; xem ảnh trước khi đăng (script báo "TRAN CHU" nếu chữ tràn).
- Áp dụng cho cả trang Sun, Hoàng Hiệp, Casamia (khi dùng thẻ có số liệu) và bài TikTok. Mẫu cũ fb-the-doc-anh-tren.py không dùng nữa.

## Mẫu POSTER (anh Hiệp duyệt 15/11/2026 – thay mẫu B, dùng cho MỌI ảnh có chữ, Facebook 3 trang và TikTok giống nhau)
- Lệnh: `python3 wordpress/bai-viet/fb-the-doc-v2.py poster <cau-hinh.json> <anh-dai-dien.jpg> <anh-nen.jpg> marketing/fb/<slug>-p.jpg`. TikTok làm bộ 3 ảnh riêng theo mục TikTok (đổi 18/11/2026).
- Bố cục: nền ngà có vệt sáng; trên cùng "HOÀNG HIỆP · BẤT ĐỘNG SẢN ĐÀ NẴNG" + tag; tiêu đề 3 dòng căn giữa; 1 dòng phụ (sub); 3 con số (stats 3 đầu); ảnh tràn nửa dưới, mờ dần đều lên nền; thanh ảnh đại diện + Zalo ở đáy. Không có danh sách ý trên ảnh (đưa vào lời bài).
- Tiêu đề = "headline_poster" trong cấu hình, 3 dòng, ghép lại đọc thành từ khoá chính:
  1. Dòng trên: chữ THƯỜNG có chân, KHÔNG nghiêng (kiểu "plain"), ví dụ "Mặt bằng căn hộ", "Tầng cao hay tầng thấp".
  2. Dòng giữa: chữ NHẤN (tên dự án / ý chính) IN HOA rất to, đậm, màu đồng (kiểu "big"), ví dụ "THE LEGEND", "SUN SAPHIA".
  3. Dòng dưới: chữ nghiêng Great Vibes ngắn (kiểu "script"), lệch phải (dx 160–240) và chạm nhẹ góc dưới chữ to ("over": true), ví dụ "Đà Nẵng", "Residence", "100% căn hộ". Không quá ~16 ký tự để không tràn mép.
  Ví dụ: [{"segs":[["Mặt bằng căn hộ","plain"]]},{"segs":[["THE LEGEND","big"]]},{"segs":[["Đà Nẵng","script"]],"dx":230,"over":true}]
- Xem ảnh trước khi đăng: chữ không tràn mép, dòng nghiêng không đè che chữ to.
- KIỂM TRA DẤU TIẾNG VIỆT trên ảnh (15/11/2026 lỗi "BÂT ĐÔNG SÁN"): chữ in hoa có dấu chồng (Ấ, Ầ, Ẩ, Ộ, Ợ…) phải hiện đủ dấu; xem phóng to phần tiêu đề trước khi hẹn bài.
- CỠ CHỮ MẪU POSTER (anh Hiệp 15/11: chữ phải đọc rõ trên điện thoại): dòng phụ "sub" ≤ 36 ký tự (1 dòng); nhãn dưới con số ≤ 16 ký tự; con số ≤ 9 ký tự. Không để chữ xuống dòng lẻ 1 từ.

## TÔNG NỀN XANH (anh Hiệp chốt 15/11/2026) – mặc định cho MỌI ảnh có chữ, cả 3 trang và TikTok
- Lệnh: `python3 wordpress/bai-viet/fb-the-doc-v2.py poster-xanh <cau-hinh.json> <anh-dai-dien.jpg> <anh-nen.jpg> marketing/fb/<slug>-x.jpg` (bố cục poster ở mục trên, nền xanh trời nhạt – trắng, chữ cam đồng + navy, chữ cỡ lớn).
- Ảnh nền Sun Saphia: ưu tiên flycam thực tế đã chỉnh màu trong marketing/anh-thuc-te/sun-saphia-flycam-17-10-2026/.

## PHÁP LÝ CĂN HỘ TRÊN ĐẤT THƯƠNG MẠI DỊCH VỤ (anh Hiệp 16/11/2026: "sửa lại đầy đủ nhất, theo luật")
Áp dụng cho Sun Saphia Residence, Symphony 5, Peninsula Private, Nobu… và mọi căn hộ/condotel trên đất thương mại dịch vụ:
- KHÔNG viết "để ở được", "câu trả lời là được", "như chung cư". Viết: "có thể dùng để sinh sống, nhưng về pháp lý không phải căn hộ chung cư nhà ở".
- Thời hạn: "thời hạn sử dụng đất của dự án 50 năm từ …" (Luật Đất đai 2024: dự án đầu tư không quá 50 năm); gia hạn = "dự kiến, theo quy định đất đai khi hết hạn", không nói "chắc chắn gia hạn".
- Tạm trú: luôn ghi "theo chủ đầu tư". Thường trú: "do công an phường xem xét, chưa chắc được – nên hỏi trước khi mua và xem mục đích sử dụng trên giấy chứng nhận".
- Bảo lãnh ngân hàng: bắt buộc với nhà ở hình thành trong tương lai; với loại này "nên hỏi chủ đầu tư có bảo lãnh không".
- Cho thuê theo đêm = kinh doanh lưu trú (Luật Du lịch 2017, thông báo lưu trú, thuế) – không viết như việc tự do; cam kết thuê/ủy thác luôn ghi "theo chính sách chủ đầu tư, không phải cam kết của Hiệp".
- Cuối bài có yếu tố pháp lý: "Thông tin tham khảo, không thay thế tư vấn pháp lý".

## LỊCH ĐĂNG (anh Hiệp 18/11/2026: "bài dự án sáng 9h tối 19h; bài Hiệp thông tin mới thì lên luôn lúc đó, đừng đợi, tối thiểu 2 bài/ngày, có thể đợi đủ thì tổng hợp lên, những tin phụ để dưới bình luận")
- TRANG DỰ ÁN (Sun, Casamia): mỗi trang 2 bài/ngày, sáng 9h và tối 19h. Không đăng 2 trang cùng phút: Sun 09:00 / 19:00, Casamia 09:30 / 19:30. TikTok +15 phút: Sun 09:15 / 19:15, Casamia 09:45 / 19:45.
- TRANG HOÀNG HIỆP (anh Hiệp 18/11/2026 sửa lại: "tối đa 2 bài/ngày; tin tức xây dựng báo lên hết thì tổng hợp lại trong ngày, trước 11h, chiều trước 17h"): ĐÚNG 2 bài TỔNG HỢP/ngày lúc 11:00 và 17:00, do lịch "Tổng hợp tin trang Hoàng Hiệp 11h – 17h" (chạy 10:32, 16:32) làm. Bài 11:00 gom tin lên web từ 17:00 hôm trước tới 10:30; bài 17:00 gom tin 10:30 – 16:30. Tin quan trọng nhất làm thân bài + ảnh; tin phụ mỗi tin 1 dòng + link trong BÌNH LUẬN ĐẦU. Không có tin thì lấp nội dung tự chọn. Lịch bản tin hạ tầng / Sở Xây dựng chỉ đăng web, không tự đăng Facebook.
- TUYỂN DỤNG (anh Hiệp 22/11/2026, thay quy định 18/11): tuyển dụng đăng ở trang riêng "Tuyển Sale BĐS Đà Nẵng" (Metricool blogId 8276810). Trang Hoàng Hiệp KHÔNG đăng bài tuyển dụng nữa – chỉ 2 bài tổng hợp/ngày. Thấy bài tuyển dụng trên trang Hoàng Hiệp thì báo anh, không tự xoá. Lịch tự động không đụng tới trang 8276810.
- Bài lịch khác đã hẹn sẵn (tuyển dụng, hạ tầng, Reel) giữ nguyên, tính vào số bài của trang đó; trùng giờ thì dời bài của mình.

## MẪU "NẮNG CAM" (anh Hiệp 20/11/2026: "Saphia đẹp chỉnh lại" – làm mẫu mới theo kiểu bộ ảnh Sun Saphia của chủ đầu tư)
- Công cụ: `python3 wordpress/bai-viet/the-nang-cam.py <cau-hinh.json> <anh-dai-dien.jpg> <out.jpg> [doc|vuong|tiktok]` (doc 1080x1350 cho FB; tiktok 1080x1920). Mẫu cấu hình: marketing/fb/nang-cam/*.json.
- Nền kem – cam nhạt, tiêu đề chữ khối Oswald cực lớn cam → đỏ, nhãn xanh, chữ viết tay tên dự án, ảnh phối cảnh hoà vào nền phía dưới, thanh Hoàng Hiệp + Zalo ở đáy.
- Dùng cho trang Sun khi bài có MỘT thông điệp/con số mạnh (vị trí, số căn, giá từ, tầng cao…). Bài nhiều số liệu vẫn dùng poster nền xanh.
- KHÔNG đưa logo Sun Property / Sun Group / đại lý (BHS…), không chép khẩu hiệu chủ đầu tư ("đầu tiên", "không thể nhân bản", "khan hiếm") khi không có nguồn; số chỉ lấy từ tài liệu chủ đầu tư / bài web, ghi "dự kiến" với giá.

## KIỂM TRA LINK TRƯỚC KHI ĐĂNG (anh Hiệp 20/11/2026 báo lỗi "Page Not Found")
- Bài có trong wordpress/tu-dong/index.json CHƯA CHẮC đã lên web (bài can-ho-hang-hieu-la-gi-nobu-da-nang 20/11 bị 404).
- Mọi link https://hiephoangmt.com/... trong bài/bình luận đầu: `curl -s -o /dev/null -w '%{http_code}' -L <link>` phải ra 200. Không 200 thì không dùng link đó (đổi sang trang dự án /du-an/<slug>/ đã có, hoặc để bài CHỜ).

## CASAMIA: ẢNH THÔNG ĐIỆP ĐẦU (anh Hiệp 21/11/2026: "Casa không có hình thông điệp đầu à")
- Mỗi bài trang Casamia: ảnh 1 = thẻ thông điệp mẫu "nắng cam" (`wordpress/bai-viet/the-nang-cam.py`, khổ doc 1080x1350; mẫu marketing/fb/nang-cam/casamia-*.json), nền là 1 ảnh phối cảnh hợp chủ đề; sau đó 3 ảnh thật/phối cảnh KHÔNG CHỮ (album 4 ảnh). Không lặp ảnh nền thẻ trong album.
- Thông điệp: 1 con số/cụm từ mạnh có nguồn (vd "316 m² sàn sử dụng", "Sống chậm ven sông"), nhãn xanh ngắn, dòng phụ 1 dòng.

## TIKTOK: VÙNG AN TOÀN (anh Hiệp 21/11/2026 báo "bản đăng tiktok bị cắt hình")
- tiktok-slides.py đã dồn mọi chữ vào y 260–1480, x 50–920 (khung 3:4 ở giữa ảnh 1080x1920) để không mất chữ khi TikTok cắt khung hoặc che bởi nút/lời bài. Không đặt chữ ngoài vùng này.

## MÀU ẢNH (anh Hiệp 22/11/2026: khoanh thẻ "Mua chung Sun Saphia" nền xanh – "Lấy màu này")
- Thẻ thông điệp Facebook (Sun, Casamia, Hoàng Hiệp) dùng màu POSTER NỀN XANH (`fb-the-doc-v2.py poster-xanh`): nền xanh trời nhạt, tiêu đề chữ có chân màu cam đất, chữ viết tay cam, số liệu cam. Mẫu "nắng cam" chỉ dùng khi anh Hiệp yêu cầu riêng.
- Casamia: ảnh 1 = thẻ poster nền xanh (thay cho nắng cam ở mục "CASAMIA: ẢNH THÔNG ĐIỆP ĐẦU"), sau đó 3 ảnh không chữ.

## THREADS (anh Hiệp 26/11/2026)
- Tài khoản Threads @hiephoangmt kết nối ở brand Sun (blogId 7637635). Brand Casamia không có Threads/TikTok → bài Threads/TikTok của Casamia cũng đặt ở blogId 7637635.
- Mỗi bài FB trang Sun và Casamia → 1 bài Threads, giờ FB + 5 phút (09:05, 09:35, 19:05, 19:35). providers [{"network":"threads"}], "threadsData":{}.
- Tối đa 500 ký tự (kể cả link): câu mở có từ khoá, 2–3 gạch đầu dòng số liệu có thật, 1 câu gợi ý, link bài web (curl 200), "Zalo Hiệp: 0904 567 009". Tối đa 1 hashtag. Ảnh: 1–2 ảnh đầu của bài FB. Giữ đủ lưu ý pháp lý bắt buộc.
