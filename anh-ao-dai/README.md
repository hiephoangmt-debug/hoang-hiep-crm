# Ảnh Áo Dài Hồng

Trang ghép ảnh theo bố cục áo dài hồng, lụa bay, trăng tròn (dịp 20/10).

Mở `index.html` bằng trình duyệt (cần mạng để tải thư viện nhận diện khuôn mặt từ jsDelivr).

## Cách dùng

1. **Bỏ ảnh vào đây**: chọn một hoặc nhiều ảnh chân dung (hoặc kéo thả vào khung). Mỗi ảnh được tự
   nhận diện khuôn mặt (68 điểm mốc), tự xoay, thu phóng cho mắt, mũi, miệng trùng với ảnh mẫu và tự khớp
   màu da. Kết quả hiện thành danh sách, bấm vào từng ảnh để chỉnh thêm, **Tải tất cả ảnh** để lưu.
2. **Chữ**: 3 mẫu (Elegant Woman, Duyên Dáng Việt, Happy Women's Day), sửa từng dòng, đổi phông
   (Playfair, Bodoni, Cormorant), kiểu chữ (hồng pha lê, hồng đậm, trắng viền hồng, vàng hồng), cỡ, vị trí.
   Mặc định chữ nằm sau đầu như mẫu.
3. **Tóc**: giữ nguyên, ngang vai, dài thẳng, dài uốn sóng; đổi màu, cỡ, độ dài, độ bóng.
4. **Nền**: ảnh mẫu, hoặc cảnh lụa hồng vẽ bằng code kèm ảnh người đã tách nền (PNG).

Ảnh không nhận ra mặt (mờ, nghiêng nhiều, đeo khẩu trang) vẫn nằm trong danh sách để chỉnh tay:
kéo ảnh trên khung, lăn chuột hoặc chụm 2 ngón để phóng to/thu nhỏ.

## Tệp

- `index.html`: toàn bộ giao diện và xử lý (canvas 1492×2000).
- `mau.js`: ảnh mẫu nhúng dạng base64.
- `models.js`: mô hình `tiny_face_detector` và `face_landmark_68` của
  [@vladmandic/face-api](https://github.com/vladmandic/face-api) 1.7.15 (MIT), nhúng sẵn để chạy cả khi mở file trực tiếp.

Ảnh chỉ xử lý trong trình duyệt, không gửi lên máy chủ nào.
