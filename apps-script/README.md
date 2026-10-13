# Apps Script – Danh sách khách sự kiện (in & check-in)

File `DanhSachKhachSuKien.gs` thêm vào dự án Apps Script **"CRM - Cổng nhận khách"**.
Sau mỗi lần đồng bộ báo cáo, bảng tính **"CRM - Báo cáo khách sự kiện"** có thêm tab `DS <tên sự kiện>` cho từng sự kiện:

- Chỉ gồm sale **đã nhập khách** – bỏ các báo cáo "Chưa có khách".
- Mỗi sale lấy **báo cáo mới nhất** của sự kiện (không lặp khách theo ngày).
- Cột **CHECK-IN**: ô tích "Đã đến" + "Số người thực tế (đầu khách + người đi cùng)", cột "Đánh giá hiệu quả & đề xuất chăm khách".
  Dữ liệu nhập tay ở các cột này được giữ lại qua các lần đồng bộ.
- Dòng tổng: số khách, SL đăng ký, đã check-in, số người thực tế.

Tab `Báo cáo` (nhật ký đầy đủ mọi lần gửi) giữ nguyên.

## Cài đặt

1. Mở dự án Apps Script "CRM - Cổng nhận khách" → **+ (Thêm tệp) → Tập lệnh**, đặt tên `DanhSachKhachSuKien`, dán nội dung file `DanhSachKhachSuKien.gs`.
2. Trong file `Mã.gs`, hàm `dongBoBaoCaoSuKien`, ngay sau dòng `sh.setFrozenRows(1);` thêm:
   ```js
   try { dongBoDanhSachKhach_(ss); } catch (err) { console.error('ds khach', err); }
   ```
3. Lưu, chạy hàm `taoSheetBaoCao` một lần để tạo các tab ngay.
4. **Triển khai → Quản lý triển khai → Sửa → Phiên bản mới → Triển khai** (để nút gửi báo cáo trên CRM dùng code mới; lịch 5 phút dùng code mới ngay).
