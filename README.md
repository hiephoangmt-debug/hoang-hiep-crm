# hoang-hiep-crm
CRM – Real Estate Sales Management System

## Kho ảnh AI → Nhân viên đăng Facebook

Trang để tải ảnh tạo bằng AI lên CRM và tự động giao cho **tất cả nhân viên đăng Facebook**.

- **Kho ảnh AI**: kéo thả nhiều ảnh, ghi dự án + caption gợi ý. Ảnh được giao ngay cho mọi nhân viên đang hoạt động. Nút "Giao toàn bộ ảnh cho tất cả nhân viên" để bù ảnh còn thiếu.
- **Tạo ảnh theo mẫu**: dán rổ hàng từ Excel (Mã căn | Tòa | Loại | Tầng | Diện tích | 3 mức giá), tải ảnh phối cảnh AI, logo, layout căn, layout tầng, 3 ảnh thực tế và nhập chính sách. CRM vẽ ảnh bán hàng cho từng căn (thẻ giá, layout, chính sách, ảnh thực tế), tự viết caption, rồi đưa vào kho và giao cho nhân viên.
- **Nhân viên đăng FB**: thêm/xóa nhân viên, bật/tắt nhận ảnh, xem tiến độ đã đăng. Nhân viên mới tự nhận toàn bộ ảnh đang có trong kho.
- **Việc đăng của tôi**: nhân viên chọn tên, tải ảnh, copy caption, bấm "Đã đăng FB" và dán link bài đăng.

### Chạy

```bash
npm install
npm start        # http://localhost:3000
npm test
```

Dữ liệu lưu ở `data/db.json`, ảnh ở `uploads/` (đổi bằng biến môi trường `DATA_DIR`, `UPLOAD_DIR`, `PORT`).
