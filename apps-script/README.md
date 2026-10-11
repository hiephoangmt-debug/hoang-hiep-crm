# Báo cáo Marketing – bản Google Apps Script (không cần OAuth Client ID)

Chạy bằng chính tài khoản Google của bạn, đọc Drive trực tiếp, lưu PPTX báo cáo vào Drive.

## Cài đặt (một lần, ~2 phút)

1. Mở https://script.google.com → **Dự án mới** (New project). Đặt tên "Báo cáo Marketing".
2. Thay nội dung `Code.gs` bằng file [`Code.gs`](Code.gs).
3. Bấm **+** cạnh *Tệp* → **HTML** → đặt tên `Index` → dán toàn bộ [`Index.html`](Index.html).
4. Bấm **Triển khai › Tùy chọn triển khai mới** (Deploy › New deployment) → loại **Ứng dụng web**:
   - *Thực thi dưới dạng*: **Tôi**
   - *Người có quyền truy cập*: **Chỉ mình tôi** (hoặc người trong tổ chức nếu cần)
5. **Triển khai** → cấp quyền Drive (lần đầu Google báo "chưa xác minh": *Nâng cao › Đi tới …*).
6. Mở link `/exec` nhận được → chọn dự án → **Quét Drive** → **Tạo báo cáo PPTX**.
   Chọn *Xuất ra*: PDF + PPTX / PDF / PPTX. File được tải về máy và lưu vào Drive (thư mục chỉ định, hoặc My Drive).
   Nếu đã triển khai bản cũ: dán lại cả `Code.gs` (có hàm `convertToPdf` mới) và `Index.html`, rồi tạo phiên bản triển khai mới.

Có thể đặt link `/exec` vào trang CRM (`/bao-cao-mkt/`) làm nút truy cập nhanh.

## Cập nhật

`Index.html` được sinh từ `bao-cao-mkt/` (dùng chung code với trang Netlify):

```
python3 apps-script/build.py
```
Dán lại `Index.html` vào dự án Apps Script → **Triển khai › Quản lý triển khai › Chỉnh sửa › Phiên bản mới**.
