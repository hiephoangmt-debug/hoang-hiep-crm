# hoang-hiep-crm
CRM – Real Estate Sales Management System

- `crm/` – **CRM Báo cáo Marketing**: dashboard, nhập số liệu, sale tải ảnh chụp/chứng từ (tự đọc số liệu bằng OCR), tạo và duyệt báo cáo tuần (PDF/PPTX). Chạy trên Google Apps Script – xem [`apps-script/README.md`](apps-script/README.md).
- `bao-cao-mkt/` – tạo báo cáo PPTX/PDF từ Google Sheet + thư mục ảnh trên Drive (trang `/bao-cao-mkt/` trên Netlify, hoặc `?page=baocao` trong Apps Script).
- `apps-script/` – bản triển khai Google Apps Script (`Code.gs`, `Crm.html`, `Index.html`; chạy `python3 apps-script/build.py` sau khi sửa mã nguồn).
