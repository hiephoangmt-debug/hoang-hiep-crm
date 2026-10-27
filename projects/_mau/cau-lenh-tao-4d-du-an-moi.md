# Câu lệnh tạo bộ 4D + chọn căn cho dự án mới

Copy toàn bộ phần dưới, thay các chỗ **[ngoặc vuông]**, gửi kèm tài liệu (mặt bằng từng tầng, phối cảnh, vị trí).

---

Làm cho dự án **[TÊN DỰ ÁN]** ở **[địa chỉ / góc đường, thành phố]** bộ công cụ giống Sun Saphia Residence trong repo này (`projects/sun-saphia/4d`, `chon-can`, `xem`, `bao-ve`, `crm`). Đặt code ở `projects/[ten-du-an]/`.

**Tài liệu gửi kèm:**
- Mặt bằng từng tầng của CĐT: [tầng 1–2 tiện ích, tầng điển hình X–Y, các tầng khác biệt, tầng mái] (zip / ảnh).
- Phối cảnh tổng thể và phối cảnh đỉnh tháp.
- Bảng diện tích từng căn (thông thủy / tim tường / ban công), loại căn.
- Vị trí trên bản đồ: [link Google Maps hoặc toạ độ], hướng mặt chính: [biển / sông / đường …].

**1. Mô hình 4D (Three.js)**
- Dựng tháp theo đúng đường bao mặt bằng CĐT (kích thước mét, góc bo), số tầng, chiều cao tầng, khối đế, đỉnh tháp, vật liệu/màu theo phối cảnh.
- Cảnh xung quanh: đường, biển/sông, công viên, công trình lân cận ước lượng (không ghi tên dự án cạnh tranh).
- Nắng theo giờ (4D), view thật từ từng tầng/căn (5D), nút: Tổng quan, Lại gần, View từ căn, Tự xoay, Mặt bằng tầng, Đỉnh tháp.
- "Mặt bằng tầng": cắt ngang tòa nhà ở tầng chọn, phủ mặt bằng vẽ lại (màu theo loại căn, nội thất, mã căn, diện tích, chú thích); mỗi tầng khác biệt có mặt bằng riêng; bấm căn hiện thẻ căn + "Mặt bằng & 3D căn" + "View từ căn này".

**2. Công cụ chọn căn**
- Mặt bằng từng tầng vẽ lại SVG theo tỷ lệ, đúng chiều từng căn (đối chiếu bản vẽ CĐT từng căn: vị trí phòng ngủ, phòng khách, WC, cửa vào, góc bo), sân vườn/ban công có tường rào.
- Bấm căn: căn sáng, căn khác mờ; mặt bằng căn 2D có kích thước; phối cảnh 3D căn (nội thất, nắng theo giờ, đứng trong căn), nền tầng tối để căn nổi bật; tải ảnh có chữ chìm.
- Nút "3D cả tầng": dựng cả tầng dạng cắt ngang như ảnh minh họa, bấm căn mở chi tiết.
- Lọc theo view và loại căn; thanh trượt tầng đúng tên tầng của CĐT.

**3. Trang "Xem dự án" (1 link duy nhất)**
- Gộp 3 tab: Mô hình 4D · Chọn căn · 3D cả tầng.
- Đăng nhập 1 lần bằng email đã được cấp trong tab "Quyền xem" của CRM (nhớ trên máy), mã nội bộ của tôi vào thẳng.
- Chạy mượt trên iPhone (không tràn khung, chỉ giữ tab đang xem).

**4. Gắn vào web và CRM**
- File nhúng cho LadiPage (tải khi cuộn tới), chữ chìm tên web + số điện thoại chống chụp/copy.
- Cập nhật CRM: link cho CRM Sale, Apps Script (QuyenXem.gs) nếu cần, trang SEO/Ads nếu có.
- Mỗi lần sửa: commit + push, đưa tôi link mới cho CRM, LadiPage và dòng mã "Trước </body>".

**Quy tắc bắt buộc**
- Chỉ dùng số [0904567009]; không dùng "đầu tiên / nhất / duy nhất"; không hứa lợi nhuận; không nhận cọc / giữ chỗ; không tạo khan hiếm giả; ghi nguồn; không nêu tên dự án cạnh tranh.
- Ảnh có chữ chìm số điện thoại; ghi rõ "minh họa, thông số theo CĐT".
- Tôi dùng điện thoại: trả lời ngắn, tiếng Việt, đưa link bấm được.
- Làm từng phần, gửi ảnh chụp để tôi kiểm tra trước khi làm tiếp.

---

**Gợi ý gửi theo thứ tự:** (1) tài liệu + câu lệnh trên → (2) kiểm tra mô hình tòa nhà → (3) kiểm tra mặt bằng từng tầng/từng căn → (4) 3D căn, 3D cả tầng → (5) trang Xem dự án, gắn web, CRM.
