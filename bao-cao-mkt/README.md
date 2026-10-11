# /bao-cao-mkt/ – Báo cáo Marketing tuần (PPTX)

Trang tĩnh (HTML + JS, không cần server). Dán link Drive → **Quét Drive** → kiểm tra ảnh → **Tạo báo cáo PPTX**.

- Đọc Google Sheet số liệu (tự xuất sang xlsx), PPTX mẫu và ảnh trong các thư mục chứng từ (quét cả thư mục con) bằng Google Drive API, quyền chỉ đọc, ngay trên trình duyệt.
- Điền: số tuần, ngày, tên chiến dịch, thời gian triển khai, ngân sách từng kênh, nhân sự, các bảng số liệu (mỗi ID tài khoản một dòng + dòng TỔNG; DEAL/MQL/SQL = "-"), chèn ảnh vào slide Ads/Hóa đơn của từng kênh.
- Ảnh được phân loại theo tên file/thư mục (`tiktok`, `zalo`, `google`, `hóa đơn`, `hd`, `invoice`…), mặc định Facebook · Ads; chỉnh tay trên lưới ảnh.

## Cài đặt một lần: Google OAuth Client ID

1. https://console.cloud.google.com → tạo project → **APIs & Services › Library** → bật **Google Drive API**.
2. **OAuth consent screen**: External, thêm scope `.../auth/drive.readonly`, thêm email người dùng vào *Test users* (hoặc Publish).
3. **Credentials › Create credentials › OAuth client ID** → loại *Web application* → *Authorized JavaScript origins*: `https://crm-sale-danang.netlify.app` (thêm `http://localhost:8000` nếu chạy thử).
4. Dán Client ID vào `googleClientId` trong `config.js` (hoặc nhập ngay trên trang, trang sẽ nhớ).

Link Drive mặc định cho từng dự án (Casa, Sun) nằm trong `config.js`.

## Chạy thử cục bộ

```
cd bao-cao-mkt && python3 -m http.server 8000   # mở http://localhost:8000
```
