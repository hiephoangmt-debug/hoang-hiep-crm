# CRM Báo cáo Marketing (Google Apps Script)

Một ứng dụng web chạy bằng tài khoản Google của bạn – không cần máy chủ, không cần OAuth Client ID.

| Trang | Link | Dùng để |
|---|---|---|
| **CRM** (mặc định) | `…/exec` | Tổng quan, nhập số liệu, sale tải ảnh/chứng từ, tạo & duyệt báo cáo, danh mục |
| Báo cáo từ thư mục Drive | `…/exec?page=baocao` | Tạo báo cáo trực tiếp từ Google Sheet + thư mục ảnh có sẵn |

Dữ liệu CRM nằm trong Google Sheet **"CRM Báo cáo Marketing"** (tự tạo ở lần mở đầu, link ở góc trên trang):
`DuAn`, `NhanSu`, `TaiKhoan`, `SoLieu`, `ChungTu`, `BaoCao`.

## Cài đặt (một lần, ~5 phút)

1. Mở https://script.google.com → **Dự án mới** → đặt tên "CRM Báo cáo Marketing".
2. File **Code.gs**: xoá nội dung có sẵn, dán toàn bộ [`Code.gs`](Code.gs).
3. **+ › HTML** → tên `Crm` → dán toàn bộ [`Crm.html`](Crm.html).
4. **+ › HTML** → tên `Index` → dán toàn bộ [`Index.html`](Index.html).
5. 💾 Lưu → **Triển khai › Tùy chọn triển khai mới › Ứng dụng web**:
   - *Thực thi dưới dạng*: **Tôi** (dữ liệu và ảnh lưu vào Drive của bạn)
   - *Người có quyền truy cập*: **Bất kỳ ai có Tài khoản Google** (để các bạn sale dùng được) – hoặc *Chỉ mình tôi* nếu chỉ một người dùng
6. **Triển khai** → cấp quyền (Drive, Sheets, kết nối ngoài). Google báo "chưa xác minh" → *Nâng cao › Đi tới …* (script của chính bạn).
7. Gửi link `/exec` cho các bạn sale; mỗi người lưu vào màn hình chính điện thoại.

> Cập nhật phiên bản: dán lại 3 file → **Triển khai › Quản lý triển khai › ✏️ › Phiên bản mới**. Link giữ nguyên.

## Dùng hằng tuần

**Sale (trên điện thoại):** tab **Ảnh & chứng từ** → chọn tuần, dự án, tên mình → chọn ảnh chụp màn hình / hoá đơn (ảnh hoặc PDF).
Trang tự đọc chữ trong ảnh:
- Ảnh **Trình quản lý quảng cáo** (điện thoại/máy tính) hoặc **Meta Business Suite** → loại *Chiến dịch* + danh sách chiến dịch với **số chi tiêu, lead**; chiến dịch trong tuần được tick sẵn – sửa số nếu đọc sai.
- **Bản xem trước quảng cáo** → *QC đang chạy*; **hoá đơn** (ảnh hoặc PDF) → *Hóa đơn*, gán người theo ID tài khoản in trên hoá đơn.

Bấm **Tải lên Drive**: ảnh lưu vào `Thư mục chứng từ/<Nhân sự>/<Dự án>/<tuần>/`, số chiến dịch đã tick vào bảng số liệu.

**Quản lý:**
- **Nhập số liệu**: xem/sửa từng dòng, thêm tay (kể cả MQL/SQL/DEAL – sẽ điền vào báo cáo), hoặc **Nhập từ Google Sheet của dự án** (thay các dòng nhập từ sheet trước đó của cùng tuần). Nếu một người vừa có số từ sheet/nhập tay vừa có số đọc từ ảnh, chỉ số sheet/nhập tay được tính.
- **Báo cáo**: chọn tuần (và dự án hoặc *Tất cả*) → **Tạo báo cáo** → PDF + PPTX lưu vào "Thư mục lưu báo cáo" của dự án; đổi trạng thái *Nháp → Đã nộp → Đã duyệt*.
- **Tổng quan**: chi phí, lead, CPL theo tuần / nhân sự / dự án / kênh.
- **Danh mục**: dự án (link mẫu PPTX, thư mục chứng từ, thư mục lưu báo cáo, Google Sheet nguồn), nhân sự, tài khoản QC ↔ nhân sự.

## Sửa mã nguồn

`Crm.html` và `Index.html` được sinh từ `crm/` và `bao-cao-mkt/`:

```
python3 apps-script/build.py
```
