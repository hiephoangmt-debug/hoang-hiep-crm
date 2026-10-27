# Câu lệnh vẽ mặt bằng tầng + view trong căn hộ (nội thất)

Copy phần dưới, thay chỗ **[ngoặc vuông]**, gửi kèm bản vẽ CĐT (mặt bằng từng tầng, mặt bằng từng loại căn có kích thước).

---

Làm cho dự án **[TÊN DỰ ÁN]** (code ở `projects/[ten-du-an]/`) phần **mặt bằng tầng** và **view đứng trong căn** giống Sun Saphia (`projects/sun-saphia/chon-can`, `4d`).

**Tài liệu gửi kèm:** mặt bằng CĐT tầng [2, 3, điển hình X–Y, tầng khác biệt, tầng mái]; bản vẽ từng loại căn [STU, 1PN, 1PN+1, 2PN…] có kích thước; bảng diện tích thông thủy / tim tường từng căn; vị trí trên bản đồ [link Google Maps hoặc toạ độ].

**1. Mặt bằng tầng (SVG, đúng tỷ lệ mét)**
- Vẽ lại đường bao tòa nhà, lõi thang, hành lang, từng căn theo đúng kích thước CĐT; mỗi tầng khác biệt một mặt bằng riêng; thanh trượt tầng dùng đúng tên tầng của CĐT (VD 3A thay 4).
- Mỗi căn: mã căn, loại, diện tích, màu theo loại; đúng chiều căn (đối chiếu bản vẽ từng căn: vị trí phòng ngủ, khách, bếp, WC, cửa vào, ban công, góc bo); căn ghép / căn đặc biệt vẽ riêng.
- Sân vườn, ban công, tường rào, góc bo đúng bản vẽ; hồ bơi, phòng gym, WC chung nếu có.
- Mã hướng view từng căn (VD ENW, WS…) theo vị trí thật; bộ lọc theo view và loại căn.
- Bấm căn: căn sáng, căn khác mờ, nền tối hơn để nổi bật (không đặt nhãn nổi che bản vẽ).

**2. Mặt bằng căn + 3D căn**
- Mặt bằng căn 2D có kích thước, nội thất đặt đúng như bản vẽ CĐT (giường, sofa, bàn ăn, bếp, tủ lạnh, WC, lavabo, tủ áo, bàn làm việc…).
- 3D căn: tường, cửa đi, cửa kính, rèm, nội thất theo đúng mặt bằng; nắng theo giờ; "3D cả tầng" dạng cắt ngang, bấm căn mở chi tiết.

**3. View đứng trong căn (5D, trên mô hình 4D)**
- Dùng chung dữ liệu layout từ công cụ chọn căn (một nguồn), dựng căn thật tại đúng tầng, đúng vị trí, đúng hướng mặt kính.
- Đứng giữa phòng khách nhìn ra cửa kính; không đứng sát tủ lạnh / tường; kéo để nhìn quanh, chạm sàn để đi (dừng trước vật ~0,7 m, mỗi bước ≤ 3 m).
- Trên điện thoại: góc nhìn rộng (~80° ngang), tâm ảnh nằm trong phần màn hình không bị bảng điều khiển che; không cắt mất vật gần (near ≈ 0,1 m khi trong căn).
- Cửa vào căn là cánh cửa đóng; ẩn mảng mặt ngoài / khối tháp chen vào phòng; ẩn hết nhãn khi đứng trong căn; phòng đủ sáng, không xám.
- Ngoài cửa kính là view thật: bờ biển, sông, đường, nhà xung quanh lấy từ OpenStreetMap (tôi cho phép dùng GitHub Actions tải hộ nếu máy bị chặn), xoay đúng góc đường chính đo trên bản đồ, không vẽ trùng đường.
- Muốn ảnh nội thất thật như chụp: dựng thêm ảnh 360° từng loại căn (Blender / D5 Render) rồi gắn vào nút "View từ căn".

**4. Kiểm tra trước khi gửi**
- Chụp màn hình khung điện thoại (390×760) từng căn của tầng đặc biệt + 1 tầng điển hình: nhìn ra kính và quay lưng lại; gửi ảnh để tôi duyệt.
- Không lỗi trang; mở được trên iPhone.
- Commit + push, cập nhật link cho CRM, LadiPage, web; đưa tôi link mới.

**Quy tắc bắt buộc:** chỉ số [0904567009]; không "đầu tiên / nhất / duy nhất"; không hứa lợi nhuận, không nhận cọc / giữ chỗ, không khan hiếm giả; ghi "minh họa, thông số theo CĐT"; ảnh có chữ chìm số điện thoại; trả lời ngắn, tiếng Việt, link bấm được.

---

**Gửi theo thứ tự:** (1) mặt bằng tầng → duyệt → (2) mặt bằng & 3D từng loại căn → duyệt → (3) view trong căn 5D → duyệt → (4) gắn web, CRM.
