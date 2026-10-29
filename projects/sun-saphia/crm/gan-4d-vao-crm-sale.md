# Gắn mô hình 4D vào CRM Sale (crm-sale-danang.netlify.app)

Dán nguyên phần dưới đây cho phiên Claude đang làm CRM Sale.

---

Thêm mô hình 4D dự án vào CRM Sale (trang "Bảng hàng dự án"), không đổi gì khác:

1. **Dữ liệu dự án (Firestore, collection `projects`)**: thêm 2 trường chuỗi, có thể để trống:
   - `link4d`: link mô hình để nhúng trong CRM.
   - `link4dKhach`: link gửi khách (nếu trống thì dùng `link4d`).

   Điền sẵn cho dự án tên **Sun Saphia Residence**:
   - `link4d` = `https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/c0a76e0257b35322d928a692280050f394fbdb7d/projects/sun-saphia/4d/sun-saphia-4d.html?crm`
   - `link4dKhach` = `https://www.sun-saphia-residence.com/#ss4d`
   - (tuỳ chọn) `linkChonCan` = `https://rawcdn.githack.com/hiephoangmt-debug/hoang-hiep-crm/ea174c8b2e86c8540f033101cd8934475033f963/projects/sun-saphia/chon-can/chon-can-app.html?crm` – công cụ chọn căn: mặt bằng từng tầng 2 → 30 (kèm bản vẽ CĐT), mặt bằng từng căn, 3D, tải ảnh có số điện thoại.
   - Mặt bằng tầng đặt trên tòa nhà: thêm `&plan&f=<tầng>` vào cuối `link4d` (ví dụ `...sun-saphia-4d.html?crm&plan&f=18`). `?crm` = bản nội bộ, không có chữ chìm.

2. **Màn sửa dự án (quyền Quản trị / Giám đốc)**: thêm 2 ô nhập "Link mô hình 4D (nhúng)" và "Link 4D gửi khách", lưu vào 2 trường trên.

3. **Trang Bảng hàng dự án**: thêm tab **"4D căn hộ"** cạnh tab "Mặt bằng tầng", chỉ hiện khi dự án đang chọn có `link4d`. Nội dung tab:
   - Khung `<iframe src="{link4d}" title="Mô hình 4D" allow="fullscreen" loading="lazy" style="width:100%;height:min(78vh,640px);min-height:420px;border:0;border-radius:14px">`.
   - Chỉ tạo iframe khi người dùng mở tab (không tải sẵn, cho nhẹ trên điện thoại).
   - Nút **"Mở toàn màn hình"**: mở `link4d` ở tab mới.
   - Nút **"Chép link gửi khách"**: chép `link4dKhach || link4d` vào bộ nhớ tạm, báo "Đã chép link 4D – dán vào Zalo gửi khách". Không có quyền clipboard thì hiện ô cho chép tay.
   - Nút **"Mặt bằng tầng"**: mở `link4d + '&plan&f=18'` (tòa nhà cắt ngang tầng, hiện mặt bằng 28 căn). Nếu có `linkChonCan` thêm nút **"Chọn căn"** mở link đó.
   - Dòng ghi chú nhỏ: "Mô hình minh họa, không phải bản vẽ của chủ đầu tư."

4. Giữ nguyên giao diện và màu hiện có. Chạy test, deploy Netlify, tăng số bản.
