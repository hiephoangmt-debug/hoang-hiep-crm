# Gói cập nhật hiephoangmt.com – 04/10/2026

**File cài:** `hoang-hiep-tron-goi.zip` (giao diện Hoàng Hiệp **2.12.4** + plugin Hoàng Hiệp CRM **2.16.2**)
**Xem trước:** https://claude.ai/artifact/ACKuFhbbb8yj5VoU8Ty9X7 (riêng tư – bấm Chia sẻ nếu muốn gửi người khác)

## Cài đặt (khoảng 5 phút)

1. **File Manager** → mở `public_html/wp-content` (đứng *trong* wp-content).
2. Tải lên `hoang-hiep-tron-goi.zip` → chuột phải → **Extract** vào `/public_html/wp-content` → chọn **ghi đè**.
3. WordPress → **Dự án → Nhập dữ liệu Đà Nẵng** → bấm **Nhập / cập nhật dữ liệu**.
4. **Cài đặt → Đường dẫn tĩnh** → bấm **Lưu** (để trang mới Tòa F2, phân khu Hải Vân Bay chạy được).
5. **LiteSpeed Cache → Purge All**, rồi Ctrl + Shift + R (điện thoại: tắt hẳn tab, mở lại).

**Kiểm tra sau khi cài:** Giao diện hiện 2.12.4 · Plugin hiện 2.16.2 · mở `/du-an/fours-tower-f2-thap-mai/` thấy 4 con số 18% – 25% – 15% – 70%.

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
