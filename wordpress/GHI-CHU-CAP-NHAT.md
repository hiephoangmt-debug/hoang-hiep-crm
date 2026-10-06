# Gói cập nhật hiephoangmt.com – 06/10/2026

**File cài:** `hoang-hiep-tron-goi.zip` (giao diện Hoàng Hiệp **2.12.4** + plugin Hoàng Hiệp CRM **2.17.7**)
**Xem trước:** https://claude.ai/artifact/ACKuFhbbb8yj5VoU8Ty9X7 (riêng tư – bấm Chia sẻ nếu muốn gửi người khác)

## Cài đặt từng bước (khoảng 10 phút)

Hình minh hoạ từng bước: thư mục `huong-dan/` (cai-1 … cai-4, interdata-cpanel).

### Bước 1 – Vào cPanel từ trang InterData
1. Đăng nhập trang khách hàng **InterData**.
2. Khung **Quản lý dịch vụ**, dòng *hiephoangmt.com* → bấm **Đăng nhập vào cPanel** (nút trắng).
   Không bấm *Edit with Sitejet Builder* / *Edit Website* – đó là công cụ khác.
3. cPanel mở tab mới → kéo xuống mục **Tệp tin** → bấm **Trình quản lý tập tin**
   (hoặc gõ "tệp" vào ô tìm kiếm trên cùng cPanel).

### Bước 2 – Tải file lên
1. Cột trái bấm **public_html** → **wp-content**. Khung phải thấy `plugins`, `themes`, `uploads` là đúng chỗ.
2. Thanh công cụ bấm **Tải lên** (Upload) → chọn `hoang-hiep-tron-goi.zip` → đợi chạy 100% → đóng trang tải lên.

### Bước 3 – Giải nén
1. Quay lại danh sách (bấm **Tải lại** nếu chưa thấy file) → **chuột phải** vào `hoang-hiep-tron-goi.zip` → **Giải nén** (Extract).
2. Đường dẫn phải là `/public_html/wp-content` → bấm **Giải nén tệp**. Hỏi ghi đè → **đồng ý**.
3. Xong có thể xoá file zip cho gọn.

### Bước 4 – Nhập dữ liệu (trang quản trị WordPress)
1. Vào `hiephoangmt.com/wp-admin` → menu trái **Dự án** → **Nhập dữ liệu Đà Nẵng**.
2. Bấm nút xanh **Nhập / cập nhật dữ liệu** → đợi trang báo đã nhập xong (vài giây).
3. Lần đầu có trang mới (Tòa F2, phân khu Hải Vân Bay): **Cài đặt → Đường dẫn tĩnh** → bấm **Lưu**.

### Bước 5 – Xoá bộ nhớ đệm và kiểm tra
1. Thanh đen trên cùng → rê chuột vào **LiteSpeed Cache** → **Purge All** (hoặc menu trái LiteSpeed Cache → Toolbox → Purge All).
2. Mở web, bấm **Ctrl + Shift + R** (điện thoại: tắt hẳn tab, mở lại).
3. Kiểm tra phiên bản: **Plugin → Plugin đã cài**: Hoàng Hiệp CRM **2.17.7** · **Giao diện**: Hoàng Hiệp **2.12.4**.
4. Xem kết quả:
   - **Tin tức** → nút **Nhịp sống Đà Nẵng** → bài bãi tắm Sơn Thủy.
   - **Casamia Balanca Hội An**: ảnh mới ở mục Tiện ích, Hình ảnh, Tiến độ – web đưa ảnh vào dần trong 15–20 phút; chưa đủ thì đợi thêm rồi Purge All lần nữa.
   - `/du-an/fours-tower-f2-thap-mai/`: 4 con số 19% – 25% – 15% – 70%, ảnh phối cảnh hoàng hôn.

Kẹt ở bước nào: chụp màn hình gửi lại.

Ô / bài anh đã tự sửa trong quản trị **không bị ghi đè** khi nhập dữ liệu.

## Có gì mới

### Đầu trang dự án
- Khung form đầu trang: dòng ưu đãi + 4 con số chính (19% · 25% · 15% · 70%) + "Còn N ngày – hạn …" ngay trên ô họ tên / số điện thoại.
- **Đồng bộ mọi dự án:** dự án chưa nhập "Con số nổi bật" tự lấy 4 con số từ dữ liệu sẵn có – chiết khấu, % vay, số tháng hỗ trợ lãi / giãn thanh toán, giá từ, quy mô, số căn, bàn giao, sở hữu (VD The Camellia: 13% · 70% · 18 tháng · 1,98 tỷ). Dự án ít dữ liệu (dưới 2 con số) giữ danh sách chính sách như cũ.
- Khung mở đầu mục Giới thiệu: 3 điểm nổi bật, "Ưu đãi còn N ngày", nút **Nhận bảng giá & phiếu tính giá** (cam) và **Chat Zalo**.

### Dự án FourS Tower & trang Tòa F2 (dạng landing để chạy quảng cáo)
- Trang mới **FourS Tower F2 – Tháp Mai**: 4 con số chính, vốn tự có theo loại căn (Studio ~405 triệu, 1PN+ ~619 triệu, 2PN ~857 triệu – vay 70%) có nút nhận căn qua Zalo, bảng "Một căn 3 tỷ trả bao nhiêu" 5 phương án, tiến độ Sun Early Key, FAQ, SEO.
- Mục Chính sách gọn: khung ưu đãi có đồng hồ đếm ngược đến 25/10/2026 + 1 nút; bảng chiết khấu cộng dồn (17,2% / 10,6% / 8,3% / 5,9% / 3%), lịch thanh toán, vay ngân hàng nằm trong nút **Xem chi tiết**.
- Số liệu theo phiếu tính giá CĐT – CSBH 4.2 Tòa F2 (từ 26/9/2026). Giá "từ" là giá tham khảo nguồn phân phối; có bảng giá chính thức F2 thì gửi để thay.

### Ảnh mới
- **FourS Tower & Tòa F2:** 5 ảnh phối cảnh (toàn cảnh hoàng hôn làm ảnh đại diện; 4 tháp, trục đường trung tâm, về đêm hướng sông trong Hình ảnh; phố thương mại khối đế trong Tiện ích).
- **Casamia Balanca Hội An:** 44 ảnh – tổng quan, nhà vườn, nội thất, mặt bằng, sự kiện Sound of Balance 25/04/2026, flycam thi công; tiện ích đời sống (hồ bơi, pickleball, chạy bộ, đạp xe, yoga, BBQ, xe điện nội khu); không gian sống (phòng khách, bếp, phòng ăn, phòng ngủ). Ảnh bồn tắm đã bỏ – web đã tải thì tự gỡ.

### Biết khách đến từ dự án nào, nguồn nào (Telegram / email)
- Tiêu đề tin báo có tên dự án: *[Website] Khách mới – Casamia Balanca Hội An: Tên – SĐT*; chat: *KHÁCH MỚI qua chat web – FourS Tower – SĐT*.
- Nội dung thêm: 🏢 Dự án / tin khách đang xem · 📍 Trang khách để lại số (nếu không phải trang dự án) · 🔎 Vào web từ (Quảng cáo Google / Google tìm kiếm / Facebook / Zalo / Cốc Cốc / trực tiếp, kèm tên chiến dịch nếu link quảng cáo có utm_campaign) · 🚪 Trang vào đầu tiên.
- Trong **Khách hàng** → mở từng khách: khung **Nguồn khách**.
- Lọc spam: số không phải số Việt Nam (VD 83656469774) → vẫn lưu, trạng thái *Không tiềm năng*, **không báo** Telegram/email. Số nước ngoài thật cần nhập có dấu + (VD +1…).

### Casamia Balanca – pháp lý theo sổ hồng (06/10/2026)
- Theo giấy chứng nhận lô 16 khu SL3 (cấp 8/2026): **đã có sổ hồng từng lô**, đất ở tại đô thị; sổ đứng tên chủ đầu tư ghi thời hạn đến 18/06/2069.
- Trang dự án: ô Pháp lý, Hình thức sở hữu, Địa chỉ (phường Hội An Đông), Tiến độ (mốc 8/2026), ảnh sổ trong mục Tiến độ. Bỏ chữ "sở hữu lâu dài" ở các bài Casamia.
- Bài *Pháp lý Casamia Balanca*: cập nhật bảng pháp lý, ảnh sổ, hỏi đáp, mô tả Google.

### Tin tức – chuyên mục mới "Nhịp sống Đà Nẵng"
- Bài đầu tiên: *Bãi tắm Sơn Thủy: Đà Nẵng chuẩn bị đầu tư công viên và câu lạc bộ thể thao biển* (~1.000 chữ): bảng thông tin chính, phối cảnh, các bước chuẩn bị đầu tư, ý nghĩa với cư dân – du lịch, tác động bất động sản Ngũ Hành Sơn, 4 câu hỏi đáp, liên kết dự án khu vực; ảnh phối cảnh (nguồn Danang 35K Feet). Đăng 06/10/2026.
- Chuyên mục tự hiện thành nút lọc trên trang Tin tức: `/category/nhip-song-da-nang/`.

### Vinhomes Hải Vân Bay
- Cập nhật 10/2026; 4 trang phân khu Bạch Vân, Vịnh Mây, Đảo Ngọc, Tinh Vân (giá, tiện ích, giỏ hàng 6 căn giá "Liên hệ", FAQ).
- Ô **Link ảnh**: dán link Google Drive từng ảnh, web tự tải ảnh về (chạy ngầm, vài phút). Link phải chia sẻ "Bất kỳ ai có đường liên kết".

### Giao diện
- Màu: **xanh navy + nâu**, **cam** chỉ ở điểm nổi bật (nút gửi thông tin, ưu đãi, con số chính). Đổi bảng màu: Giao diện → Tùy biến → Hoàng Hiệp – Thương hiệu → Bảng màu.
- Nút Gọi / Zalo / Tư vấn ở bên trái, nằm giữa mép màn hình và chữ; cột phải gọn (≈ 1/3 cột chữ).
- Bảng trong bài hiển thị gọn trên điện thoại (không tràn, chữ đều); tiêu đề trên ảnh luôn trắng, rõ.
- Trang dự án tự ẩn phần bài giới thiệu trùng với mục Tổng quan / Vị trí / Bảng giá / Chính sách.

### Chat trực tiếp & Telegram (mới)
- **Chat trên web** (góc phải mọi trang, điện thoại nằm trên thanh Gọi/Zalo): chào theo trang khách đang xem, nút gợi ý (Bảng giá, Vốn tự có, Đặt lịch xem nhà…), trả lời bằng số liệu dự án và xin số Zalo. Khách gõ số điện thoại → tự lưu vào **Khách hàng** kèm nội dung chat + email + Telegram.
- Mặc định trả lời theo **kịch bản** (miễn phí). Dán **API key Claude** ở **Khách hàng → Chat trên web** để trả lời tự nhiên bằng AI (có giới hạn lượt/ngày; lỗi hoặc hết lượt tự quay về kịch bản).
- **Hỏi theo mục đang đọc**: khách dừng ~8 giây ở một mục (Vị trí, Tiện ích, Giỏ hàng, Chính sách, Tiến độ…) → bong bóng hỏi đúng chuyện mục đó kèm 2 nút trả lời nhanh; tối đa 2 lần mỗi lượt truy cập. Popup form "Nhận bảng giá" lùi lại (sau 90 giây, chỉ khi khách chưa chat). Tắt/bật: Khách hàng → Chat trên web.
- **Thông báo Telegram**: **Khách hàng → Thông báo Telegram** – tạo bot ở @BotFather, dán token, nhắn Start cho bot, bấm *Lấy Chat ID* → *Gửi thử*. Mọi khách mới (form + chat) về Telegram ngay.

### Chức năng
- Tìm dự án gõ sai, không dấu vẫn ra (VD "Fous" → FourS Tower), dự án khớp nhất lên đầu.
- Sửa lỗi nghiêm trọng khi bấm Nhập dữ liệu (tải ảnh chuyển sang chạy ngầm); nếu có lỗi khác, trang báo dòng lỗi thay vì trang trắng.

## Ô mới trong quản trị (Dự án → tab Giá & chính sách)

| Ô | Dùng để | Ví dụ nhập |
|---|---|---|
| Con số nổi bật | 4 số lớn trong khung ưu đãi; có nhập thì mục Chính sách tự gọn | `18% \| Chiết khấu cộng dồn tối đa` |
| Bảng chiết khấu (4 cột) | Phương án \| Hạn \| % cộng dồn \| Cách tính | `Thanh toán sớm 95% \| Trước 25/10/2026 \| 17,2% \| EB 3% + 3% + 12%` |
| Vốn tự có theo loại căn | Thẻ vốn tự có + nút Zalo (chèn vào bài: `[hh_von_tu_co]`) | `Studio \| Giá từ ~1,7 tỷ \| ~405 triệu \| Ngân hàng cho vay ~1,13 tỷ` |
| Hạn ưu đãi | Đồng hồ đếm ngược, hết hạn tự ẩn | `25/10/2026` |
| Link ảnh (tab Thư viện) | Ảnh từ Google Drive | `link \| chú thích \| thư viện / tiện ích / mặt bằng / đại diện` |

## Còn chờ anh
- Bảng giá chính thức Tòa F2 (thay giá tham khảo, tính lại vốn tự có).
- Kiểm tra quyền chia sẻ các link ảnh Drive Hải Vân Bay; ảnh riêng cho từng phân khu.
- Chính sách CĐT bản chính thức tháng 10/2026 của Hải Vân Bay.
- Nội dung thật trang Giới thiệu, địa chỉ văn phòng.
