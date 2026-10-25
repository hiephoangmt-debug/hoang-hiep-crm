/* Content tuần Sun Saphia Residence (25/10 – 1/11/2026) – đồng bộ với bài Facebook Page / TikTok / YouTube.
 * Quản lý bấm “✨ Nạp content Sun Saphia” ở tab Content tuần → CRM tạo sẵn các tuần dưới đây (lưu chung bộ sưu tập events, kind: 'content').
 * Bài không gắn link; {ten} {sdt} được thay bằng tên + số điện thoại của sale đang xem khi Copy bài / Tải ảnh.
 * “ảnh: N” = ảnh thứ N trong SAPHIA_LIB (file trong bh-img/su-kien/). */
export const SAPHIA_LIB = [
  ['bh-img/su-kien/saphia-thap-hoang-hon.jpg', 'Saphia – tháp bên biển, hoàng hôn'],       // 1
  ['bh-img/su-kien/saphia-thap-tren-cao.jpg', 'Saphia – tháp nhìn từ trên cao'],           // 2
  ['bh-img/su-kien/saphia-thap-dem.jpg', 'Saphia – tháp về đêm'],                          // 3
  ['bh-img/su-kien/saphia-ho-boi.jpg', 'Saphia – hồ bơi view biển'],                       // 4
  ['bh-img/su-kien/saphia-ba-duong-xuong-bien.jpg', 'Saphia – 3 đường xuống biển'],        // 5
  ['bh-img/su-kien/saphia-khach-du-lich.jpg', 'Khách du lịch trên biển Đà Nẵng'],          // 6
  ['bh-img/su-kien/saphia-can-2br.jpg', 'Saphia – mặt bằng căn 2BR'],                      // 7
  ['bh-img/su-kien/saphia-layout-tang.jpg', 'Saphia – layout tầng 3A–28'],                 // 8
  ['bh-img/su-kien/saphia-gcn-dau-tu.jpg', 'Saphia – GCN đăng ký đầu tư'],                 // 9
  ['bh-img/su-kien/saphia-the-thao-bien.jpg', 'Thể thao biển: kayak, SUP, jetski'],        // 10
  ['bh-img/su-kien/saphia-gia-dinh.jpg', 'Gia đình vui chơi trên biển'],                   // 11
  ['bh-img/su-kien/saphia-do-thi.jpg', 'Đô thị trung tâm mới Đà Nẵng'],                    // 12
  ['bh-img/su-kien/saphia-truc-bien.jpg', 'Trục biển Võ Nguyên Giáp – Trường Sa'],         // 13
  ['bh-img/su-kien/saphia-apsara.jpg', 'Cảm hứng vũ nữ Apsara'],                           // 14
  ['bh-img/su-kien/saphia-sup.jpg', 'Chèo SUP đón bình minh'],                             // 15
  ['bh-img/su-kien/saphia-ban-tre.jpg', 'Nhóm bạn trẻ trên biển'],                         // 16
  ['bh-img/su-kien/saphia-studio.jpg', 'Saphia – mặt bằng căn Studio'],                    // 17
  ['bh-img/su-kien/saphia-cong-vien-bien.jpg', 'Công viên ven biển trước dự án'],          // 18
  ['bh-img/su-kien/saphia-kick-off.jpg', 'Kick-off Sun Saphia 23/10/2026'],                // 19
  ['bh-img/su-kien/saphia-gym.jpg', 'Saphia – Gym & Yoga'],                                // 20
  ['bh-img/su-kien/saphia-can-1br.jpg', 'Saphia – mặt bằng căn 1BR+'],                     // 21
  ['bh-img/su-kien/saphia-lrt.jpg', 'Tuyến LRT sân bay – Hội An'],                         // 22
  ['bh-img/su-kien/saphia-nghi-duong.jpg', 'Nghỉ dưỡng bên biển']                          // 23
];

const COMMON = {
  tagline: 'Sun Saphia Residence · Đà Nẵng',
  kicker: 'CĂN HỘ MẶT BIỂN ĐẦU TIÊN CỦA SUN GROUP',
  place: 'Sun Saphia Residence · Võ Nguyên Giáp – Trường Sa',
  highlights: '~400 m | ra bãi tắm Sơn Thủy\n30 tầng | cao 114 m\n50 năm | từ 17/09/2026',
  hashtags: '#SunSaphiaResidence #CanHoMatBienDaNang #SunGroup #BatDongSanDaNang',
  note: 'Đồng bộ với bài Page / TikTok / YouTube cùng giờ. Copy bài + tải ảnh có tên, SĐT của bạn.'
};

const W1 = `25/10 15h: 🌊 Sun Group làm căn hộ cao tầng ngay mặt biển Đà Nẵng – lần đầu tiên
tiêu đề: Căn hộ mặt biển | đầu tiên của Sun Group
ảnh: 1
điểm nhấn: 30 tầng | cao 114 m
câu: Sun Saphia Residence – căn hộ cao tầng mặt biển đầu tiên của Sun Group tại Đà Nẵng.
nút: Nhận bảng giá
Sun Saphia Residence là dự án căn hộ mặt biển đầu tiên của Sun Group tại Đà Nẵng, do Sun Property phát triển.
🏢 Giao lộ Võ Nguyên Giáp – Trường Sa, phường Ngũ Hành Sơn
🏢 1 tòa tháp 30 tầng, cao 114 m, 2 tầng hầm
🏠 782 căn: Studio 30 m² · 1BR+ 50 m² · 2BR 60–70 m², trần cao 3,5 m
🏖 Khoảng 400 m ra bãi tắm Sơn Thủy
📜 Thời hạn 50 năm từ 17/09/2026 · Vietcombank, BIDV, NCB hỗ trợ vay
🗓 Dự kiến mở bán cuối 11/2026 · bàn giao 11/2028
Trước mặt là Biển · Sau lưng là Sông · Bên cạnh là Núi.
👉 Nhận bảng giá gốc · Zalo {sdt} · {ten}

25/10 19h: 🗺 Vị trí Sun Saphia Residence – trung điểm Đà Nẵng – Hội An
tiêu đề: Ra biển Sơn Thủy | chỉ khoảng 400 m
ảnh: 5
điểm nhấn: ~400 m | ra bãi tắm Sơn Thủy
câu: Ngay giao lộ Võ Nguyên Giáp – Trường Sa, trên cung đường tỷ đô Đà Nẵng – Hội An.
nút: Xem vị trí thực tế
Sun Saphia Residence nằm ngay giao lộ Võ Nguyên Giáp – Nguyễn Đức Thuận – Trường Sa, phường Ngũ Hành Sơn.
🏖 ~400 m ra bãi tắm Sơn Thủy qua công viên ven biển
🚆 ~500 m tới ga LRT 09 (quy hoạch tuyến sân bay – Hội An)
🏙 4 km tới Galaxy – Đà Nẵng Downtown
✈️ 10–15 phút ra sân bay · ~30 phút tới Hội An
🌳 Ngay trước dự án: công viên công cộng ~2,45 ha (QĐ 2958/QĐ-UBND)
Muốn xem thực tế? Em gọi video Zalo đi từ dự án ra biển cho anh/chị xem – miễn phí.
👉 Xem vị trí thực tế · Zalo {sdt} · {ten}`;

const W2 = `26/10: 🏠 Mặt bằng Sun Saphia Residence – Studio 30 m² ở có chật không?
tiêu đề: Studio 30 m² | trần cao 3,5 m
ảnh: 17
điểm nhấn: 3,5 m | trần cao mọi căn
câu: 3 loại căn diện tích gọn – vốn vào vừa sức, dễ ở, dễ cho thuê.
nút: Nhận mặt bằng
🔹 Studio 30–31 m² (3,8 × 9 m) – 513 căn: logia, giường + sofa, bếp chữ L, WC tách khu tắm
🔹 1BR+ 50–51 m² (6,2 × 9 m) – 108 căn: 1 phòng ngủ + phòng đa năng
🔹 2BR 60–70 m² (7,25 × 9,9 m) – 133 căn: có căn góc bo tròn
Căn hộ từ tầng 3A đến 28, mặt bằng tối ưu view biển Mỹ Khê, bàn giao hoàn thiện cơ bản.
Căn view biển đẹp có hạn trên mỗi tầng – nhắn em để nhận layout tầng và căn còn trống.
👉 Nhận mặt bằng từng tầng · Zalo {sdt} · {ten}

26/10 15h: 💰 Cho thuê căn hộ mặt biển Đà Nẵng thu về bao nhiêu?
tiêu đề: Cho thuê căn hộ mặt biển | thu về bao nhiêu?
ảnh: 4
điểm nhấn: 81,3% | lấp đầy KS Sun Group miền Trung
câu: Bài toán minh họa chủ đầu tư trình bày tại Kick-off 23/10/2026 (giá giả định).
nút: Tính dòng tiền
Bài toán minh họa của chủ đầu tư (giá giả định, chưa phải giá bán):
🔹 Studio 30 m² · 3 tỷ · 2,5 triệu/đêm · lấp đầy 60% → thực nhận ~351 triệu/năm (~11,7%)
🔹 1BR 50 m² · 4,5 tỷ · 3,5 triệu/đêm · lấp đầy 60% → thực nhận ~492 triệu/năm (~10,9%)
🏨 Khách sạn Sun Group miền Trung lấp đầy 81,3% năm 2026 (từ 70,65% năm 2025)
👥 Khách thuê: nhân sự chuỗi resort, khách Airbnb ngắn ngày, khách du lịch
⚠️ Không phải cam kết lợi nhuận – kết quả thực tế tùy giá mua, mùa vụ, cách vận hành.
👉 Tính dòng tiền theo căn · Zalo {sdt} · {ten}

26/10 19h: 🌄 Gần 20 năm ở Đà Nẵng – vì sao giờ Sun Group mới làm căn hộ mặt biển?
tiêu đề: Từ núi, qua sông | ra biển Đà Nẵng
ảnh: 2
điểm nhấn: ~20 năm | Sun Group ở Đà Nẵng
câu: Mảnh ghép còn thiếu của Sun Group tại Đà Nẵng: căn hộ cao tầng ngay mặt biển.
nút: Nhận thông tin
⛰ Núi: Sun World Ba Na Hills, Cầu Vàng
🏝 Resort & biệt thự biển: InterContinental, Premier Village
🌉 Sông Hàn: Sun Cosmo, Sun Ponte, Sun Symphony
🏙 Nam trung tâm: Sun Galaxy Complex, FourS Tower
🌊 Mặt biển: Sun Saphia Residence – tòa 30 tầng trên trục Võ Nguyên Giáp – Trường Sa
Trước mặt biển Mỹ Khê, sau lưng sông Hàn, bên cạnh Ngũ Hành Sơn.
👉 Nhận thông tin dự án · Zalo {sdt} · {ten}

27/10: 📜 Pháp lý Sun Saphia Residence – 3 điều cần biết trước khi xuống tiền
tiêu đề: Pháp lý rõ ràng | 3 điều cần biết
ảnh: 9
điểm nhấn: 50 năm | từ 17/09/2026
câu: Giấy chứng nhận đăng ký đầu tư, hai mốc thời hạn và Nghị quyết 278.
nút: Nhận bản sao pháp lý
1️⃣ GCN đăng ký đầu tư mã dự án 2572746483, Sở Tài chính TP Đà Nẵng cấp lần đầu 17/09/2026
2️⃣ Hai mốc thời hạn: 50 năm thời hạn dự án (đến 09/2076) · 100 năm niên hạn công trình cấp I
3️⃣ Nghị quyết 278/NQ-CP (18/9/2026): thời hạn chung cư xác định theo niên hạn công trình – giá trị căn hộ 50 năm đang được định hình lại
🏦 Vietcombank · BIDV · NCB hỗ trợ vay
👉 Nhận bản sao pháp lý · Zalo {sdt} · {ten}

27/10 15h: 💡 Giá Sun Saphia Residence bao nhiêu?
tiêu đề: Giá Sun Saphia | dự kiến công bố cuối 11
ảnh: 3
điểm nhấn: 11/2026 | dự kiến công bố giá
câu: Chủ đầu tư chưa công bố giá – đây là mặt bằng giá căn hộ ven biển Đà Nẵng để tham khảo.
nút: Nhận bảng giá
Giá chào bán tham khảo các dự án ven biển khác (trình bày tại Kick-off 23/10/2026):
🔹 Studio: 5,2 – 10,5 tỷ
🔹 1BR: 7,7 – 11,5 tỷ
🔹 2BR: 17,4 – 21,7 tỷ
(Đây là giá các dự án khác, không phải giá Sun Saphia Residence.)
✅ Đợt đầu: chính sách giá tốt nhất · chọn căn đẹp trước · chủ đầu tư hỗ trợ lãi suất
👉 Nhận bảng giá gốc · Zalo {sdt} · {ten}

27/10 19h: 🛡 Đặt chỗ Sun Saphia Residence thế nào cho an toàn?
tiêu đề: Đặt chỗ an toàn | đúng quy trình chủ đầu tư
ảnh: 3
điểm nhấn: 100% | hoàn tiền nếu không mua
câu: Dự án do Sun Property phát triển, phân phối qua đại lý chính thức được chủ đầu tư chứng nhận.
nút: Đăng ký nhận thông tin
✅ Bảng giá, chính sách bán hàng gốc từ chủ đầu tư
✅ Giữ chỗ, ký hợp đồng đúng quy trình
✅ Tiền đặt chỗ nộp vào tài khoản công ty/chủ đầu tư – không qua tài khoản cá nhân
💳 Đặt chỗ 50 triệu, hoàn 100% nếu không mua
🗓 Mở bán dự kiến cuối 11/2026
👉 Đăng ký nhận thông tin · Zalo {sdt} · {ten}

28/10: 🖼 Căn hộ Sun Saphia Residence view gì? 4 hướng – 4 khung tranh
tiêu đề: 4 hướng view | 4 khung tranh Đà Nẵng
ảnh: 1
điểm nhấn: 4 hướng | biển · núi · sông · phố
câu: Từ tầng cao, nhìn cùng lúc sông – núi – biển Đà Nẵng.
nút: Chọn căn đúng hướng
🌊 Hướng Biển: Mỹ Khê – Sơn Thủy ngay ngoài ban công
⛰ Hướng Núi: Ngũ Hành Sơn như tranh treo cửa sổ
🌅 Hướng Sông Hàn: hoàng hôn mỗi chiều
🌃 Hướng Đô thị: Đà Nẵng lên đèn trước mắt
Căn từ tầng 3A–28, trần 3,5 m, logia kính lớn – căn view đẹp cũng là căn cho thuê được giá nhất.
👉 Chọn căn đúng hướng · Zalo {sdt} · {ten}

28/10 15h: 🤔 Căn hộ 50 năm hết hạn thì sao? Có mất nhà không?
tiêu đề: Căn hộ 50 năm | hết hạn thì sao?
ảnh: 9
điểm nhấn: 100 năm | niên hạn công trình
câu: Đừng nhầm 2 mốc: 50 năm thời hạn dự án và 100 năm niên hạn công trình.
nút: Nhận giải thích
📌 50 năm – thời hạn dự án (đất), từ 17/09/2026 đến 09/2076
📌 100 năm – niên hạn công trình cấp I
🔹 Hết 50 năm: Luật Đất đai 2024 cho phép xem xét gia hạn nếu sử dụng đúng mục đích
🔹 Hết niên hạn: Luật Nhà ở 2023 – tòa nhà được kiểm định; còn an toàn thì ở tiếp, không an toàn thì cải tạo, xây lại, chủ sở hữu được bồi thường/tái định cư/căn mới
Luật hiện hành không quy định tự động mất quyền sở hữu. (Giải thích chung, không thay thế tư vấn pháp lý.)
👉 Hỏi thêm về pháp lý · Zalo {sdt} · {ten}

28/10 19h: 🏊 Tiện ích Sun Saphia Residence – sống như đi nghỉ dưỡng mỗi ngày
tiêu đề: Sống như đi nghỉ dưỡng | mỗi ngày
ảnh: 4
điểm nhấn: Tầng 3 | hồ bơi view biển
câu: Hệ tiện ích “may đo” nghỉ dưỡng: Wellness – Healthy – Waterfront.
nút: Nhận brochure
🧘 Wellness: hồ bơi tầng 3 view biển, phòng yoga
💪 Healthy: gym, pilates; nhà trẻ, shop khối đế ngay trong tòa nhà
🌊 Waterfront: kayak, SUP, dù lượn, jetski ngay bãi biển trước nhà
Xung quanh đủ tiện ích sống: trường học, siêu thị, bệnh viện. (Ảnh tiện ích là minh họa.)
👉 Nhận brochure dự án · Zalo {sdt} · {ten}

29/10: ✈️ Du lịch Đà Nẵng tăng gần 30% – căn hộ mặt biển được gì?
tiêu đề: Du lịch Đà Nẵng | tăng gần 30%
ảnh: 6
điểm nhấn: 15,86 tr | lượt khách 9 tháng 2026
câu: Khách đến Đà Nẵng vì biển – và ngày càng ưu tiên chỗ ở phía biển.
nút: Tính dòng tiền
👥 15,86 triệu lượt khách 9 tháng đầu 2026 (+29,6%)
🌏 7,69 triệu khách quốc tế (+28,9%)
💵 52.945 tỷ đồng doanh thu du lịch (+26,2%)
🏨 Khách sạn Sun Group miền Trung lấp đầy 81,3%
Studio view biển cho thuê ~2,2–2,9 triệu/đêm, 1BR+ ~3,4–3,7 triệu/đêm (ngoài mùa cao điểm).
👉 Tính dòng tiền cho thuê · Zalo {sdt} · {ten}

29/10 15h: 🔑 4 cách cho thuê căn hộ Đà Nẵng – chọn cách nào hợp với mình?
tiêu đề: 4 cách cho thuê | chọn cách hợp với mình
ảnh: 16
điểm nhấn: 4 cách | cho thuê căn hộ
câu: Không có cách “tốt nhất” cho mọi người – chọn theo thời gian và mong muốn của mình.
nút: So sánh dòng tiền
1️⃣ Ngắn ngày – tự vận hành: studio view biển ~2,2–2,9 triệu/đêm, dòng tiền cao nhất, tốn công nhất
2️⃣ Ngắn ngày – giao đơn vị vận hành: phí thường 15–30% doanh thu, hợp người ở xa
3️⃣ Theo tháng (3–6 tháng): studio khu vực ~18–20 triệu/tháng, đều, ít công sức
4️⃣ Dài hạn (từ 1 năm): đều nhất, thấp nhất – hợp người muốn “để đó” an tâm
💡 Cao điểm (tháng 4–8, Tết, pháo hoa) cho thuê theo đêm; mùa mưa chuyển sang thuê tháng.
👉 So sánh dòng tiền Studio / 1BR+ · Zalo {sdt} · {ten}

29/10 19h: 💃 Vũ điệu Di sản – tòa tháp lấy cảm hứng từ vũ nữ Apsara
tiêu đề: Vũ điệu Di sản | cảm hứng Apsara Chăm Pa
ảnh: 14
điểm nhấn: 114 m | biểu tượng mới bên biển
câu: Kiến trúc chắt lọc tinh thần điêu khắc Chăm Pa, thể hiện bằng ngôn ngữ đương đại.
nút: Nhận brochure
🏢 Khối tháp thẳng 30 tầng, cao 114 m
🌊 Mặt dài hướng biển Mỹ Khê – tối ưu tầm view
💠 Mặt đứng kính xanh nhạt
✨ Ban công và trụ màu đồng
Biểu tượng mới của Sun Group bên biển Đà Nẵng. (Phối cảnh minh họa.)
👉 Nhận brochure dự án · Zalo {sdt} · {ten}

30/10: 🛣 3 dự án hạ tầng “mở đường” cho trục biển Võ Nguyên Giáp – Trường Sa
tiêu đề: 3 dự án hạ tầng | trên trục biển
ảnh: 13
điểm nhấn: 2.633 tỷ | mở rộng trục biển
câu: Giá trị bất động sản đi theo hạ tầng – quanh Sun Saphia Residence đang có 3 dự án lớn.
nút: Xem vị trí
1️⃣ Mở rộng đường Võ Nguyên Giáp – Trường Sa – Lạc Long Quân: tổng mức đầu tư dự kiến 2.633 tỷ
2️⃣ Ga LRT 09 cách ~500 m: tuyến sân bay – Hội An, giai đoạn 1 dự kiến khởi công 2/2027
3️⃣ Khu thương mại tự do Đà Nẵng (QĐ 1142/QĐ-TTg): Galaxy – Downtown cách 4 km
➕ Công viên ~2,45 ha ngay trước dự án
(Các mốc là kế hoạch dự kiến, có thể thay đổi.)
👉 Xem vị trí thực tế · Zalo {sdt} · {ten}

30/10 15h: 🏦 Vay mua căn hộ Sun Saphia Residence – trả bao nhiêu mỗi tháng?
tiêu đề: Vay mua căn hộ | trả bao nhiêu mỗi tháng?
ảnh: 8
điểm nhấn: ~12,5 tr | mỗi tháng (ví dụ)
câu: Vietcombank · BIDV · NCB hỗ trợ cho vay, hỗ trợ lãi suất theo chính sách khi mở bán.
nút: Tính phương án vay
🧮 Ví dụ giả định: căn 3 tỷ · vay 50% = 1,5 tỷ · lãi 8%/năm · 20 năm
→ Trả đều gốc + lãi khoảng 12,5 triệu/tháng · vốn tự có 1,5 tỷ
📂 Hồ sơ vay: CCCD, cư trú, hôn nhân · chứng minh thu nhập · HĐ mua bán/đặt cọc
(Giá 3 tỷ là giá minh họa, chưa phải giá bán. Con số thực tế theo hồ sơ và chính sách từng ngân hàng.)
👉 Tính phương án vay theo căn · Zalo {sdt} · {ten}

30/10 19h: 🏖 Ai sẽ là chủ nhân căn hộ mặt biển Sun Saphia? Anh/chị thuộc nhóm nào?
tiêu đề: Chủ nhân tương lai | anh/chị thuộc nhóm nào?
ảnh: 11
điểm nhấn: 3 loại căn | cho từng nhóm khách
câu: Studio, 1BR+, 2BR – mỗi nhóm khách một lựa chọn phù hợp.
nút: Gợi ý căn phù hợp
🏄 Người trẻ tự do – làm việc từ đâu cũng được, sao không cạnh biển Đà Nẵng?
🏆 Người thành đạt – second home cho cả gia đình, thương hiệu Sun Group
🌅 Người nghỉ hưu sớm – sống chậm sớm, biển trước nhà
👴 Người lớn tuổi – về với biển, về với sức khỏe
👉 Nhắn nhóm của anh/chị – em gợi ý căn · Zalo {sdt} · {ten}

31/10: 📐 Mặt bằng tầng Sun Saphia Residence – 28 căn mỗi tầng bố trí ra sao?
tiêu đề: 28 căn mỗi tầng | bố trí ra sao?
ảnh: 8
điểm nhấn: 28 căn | mỗi tầng 3A–28
câu: Dãy Studio ở giữa, 1BR+ và 2BR hai đầu, căn góc bo tròn hai mặt thoáng.
nút: Nhận mặt bằng
🔹 Studio – 19 căn/tầng, dãy giữa, hướng biển và hướng thành phố
🔹 1BR+1 – 4 căn/tầng ở hai đầu hành lang
🔹 2BR – 5 căn/tầng, có căn góc bo tròn hai mặt thoáng
🔹 Lõi thang giữa tòa · trần 3,5 m · logia kính lớn
💡 Căn nhìn thẳng biển, tầng cao thường cho thuê giá cao và kín lịch hơn.
👉 Nhận mặt bằng từng tầng · Zalo {sdt} · {ten}

31/10 15h: 🧾 Cho thuê căn hộ có phải đóng thuế không? 5 khoản cần tính trước
tiêu đề: Cho thuê căn hộ | thuế và chi phí cần tính
ảnh: 20
điểm nhấn: ~10% | thuế khi doanh thu >100 tr/năm
câu: Nhìn giá thuê theo đêm thôi chưa đủ – tính đủ chi phí trước khi mua để cho thuê.
nút: Tư vấn cho thuê
1️⃣ Thuế: doanh thu trên 100 triệu/năm nộp ~10% (5% GTGT + 5% TNCN, Thông tư 40/2021/TT-BTC); dưới 100 triệu/năm không phải nộp
2️⃣ Chi phí vận hành: quản lý, dọn phòng, điện nước, hoa hồng Airbnb/Booking
3️⃣ Nội thất: căn bàn giao hoàn thiện cơ bản – dự trù trước khi cho thuê
4️⃣ Mùa vụ: mùa mưa (~tháng 9–12) lấp đầy thấp hơn
5️⃣ Quy định: nội quy tòa nhà, khai báo tạm trú cho khách
👉 Tư vấn cho thuê · Zalo {sdt} · {ten}

31/10 19h: 🏖 Từ Sun Saphia Residence ra biển mất bao lâu?
tiêu đề: 3 lối xuống biển | ngay trước khu Saphia
ảnh: 18
điểm nhấn: ~400 m | ra bãi tắm Sơn Thủy
câu: Băng qua đường là tới bãi cát – chuỗi 3 công viên bãi tắm ngay trước thềm nhà.
nút: Xem biển thực tế
🛤 3 đường xuống biển ngay trước khu Saphia
1️⃣ Bãi tắm Sơn Thủy – sát khu Saphia
2️⃣ Công viên bãi tắm đối diện – ngay trước dự án
3️⃣ Công viên bãi tắm Huyền Trân Công Chúa – gần Ngũ Hành Sơn
🌅 Sáng chèo SUP đón bình minh, chiều kayak, tối dạo công viên ven biển.
👉 Gọi video xem biển thực tế · Zalo {sdt} · {ten}

1/11: 🏙 Đà Nẵng mới ~3 triệu dân – ai đang đổ về và cần chỗ ở?
tiêu đề: Đà Nẵng mới | ~3 triệu dân
ảnh: 12
điểm nhấn: ~3 tr | dân sau sáp nhập
câu: Ba dòng người – một điểm đến – một nhu cầu: chỗ ở gần biển, gần trung tâm.
nút: Nhận thông tin
🌏 Khách quốc tế: 6,88 triệu lượt 8 tháng đầu 2026 (+26,3%); chuyên gia, giáo viên ngoại ngữ ở lại dài hạn
🚚 Di cư trong nước: 15–16 nghìn người/năm “đổi phố lấy biển”
🏛 Sáp nhập Quảng Nam: quy mô ~3 triệu dân từ 1/7/2025
Nguồn khách thuê bền vững cho căn hộ mặt biển Đà Nẵng.
👉 Nhận thông tin dự án · Zalo {sdt} · {ten}

1/11 15h: 👨‍👩‍👧 Gia đình nên chọn căn 1BR+ hay 2BR tại Sun Saphia Residence?
tiêu đề: 1BR+ hay 2BR | gia đình nên chọn căn nào?
ảnh: 7
điểm nhấn: 133 căn | 2BR, có căn góc
câu: Căn góc 2BR view biển ít nhất trên mặt bằng – thường được chọn sớm nhất.
nút: Nhận bản vẽ
🔹 1BR+1 · 50–51 m² · 6,2 × 9 m · 108 căn: 1 ngủ + phòng đa năng – hợp gia đình nhỏ, làm việc từ xa
🔹 2BR · 60–70 m² · 7,25 × 9,9 m · 133 căn: 2 ngủ, phòng khách, bếp, căn góc bo tròn – hợp gia đình có con, second home
Trần 3,5 m, bàn giao hoàn thiện cơ bản.
👉 Nhận bản vẽ 1BR+ / 2BR · Zalo {sdt} · {ten}

1/11 19h: 🗓 Còn khoảng 1 tháng đến ngày mở bán Sun Saphia Residence
tiêu đề: Sắp mở bán | các mốc cần nhớ
ảnh: 19
điểm nhấn: Cuối 11 | dự kiến mở bán
câu: Đăng ký sớm để nhận bảng giá gốc và chọn căn đẹp trong đợt đầu.
nút: Đăng ký nhận bảng giá
✅ 17/09/2026 – Cấp GCN đăng ký đầu tư
✅ 17/10/2026 – Ra mắt thông tin dự án
✅ 23/10/2026 – Kick-off “Đón ánh dương – Giao hòa nhịp sống”
⏳ Cuối 11/2026 – Mở bán (dự kiến): công bố bảng giá, chính sách
🚆 2/2027 – Dự kiến khởi công LRT sân bay – Hội An
🔑 11/2028 – Dự kiến bàn giao
(Các mốc là kế hoạch dự kiến, có thể thay đổi theo công bố của chủ đầu tư.)
👉 Đăng ký nhận bảng giá · Zalo {sdt} · {ten}`;

export const SAPHIA_CONTENT = [
  Object.assign({key: 'saphia-2610-w0', name: 'Content Sun Saphia 25/10', startDate: '2026-10-19', posts: W1}, COMMON),
  Object.assign({key: 'saphia-2610-w1', name: 'Content Sun Saphia 26/10 – 1/11', startDate: '2026-10-26', posts: W2}, COMMON)
];
