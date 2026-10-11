# /bao-cao-mkt/ – Báo cáo Marketing tuần (PPTX)

Trang tĩnh (HTML + JS, không cần server). Dán link Drive → **Quét Drive** → kiểm tra ảnh → **Tạo báo cáo PPTX**.

- Đọc Google Sheet số liệu (tự xuất sang xlsx), PPTX mẫu và ảnh trong các thư mục chứng từ (quét cả thư mục con) bằng Google Drive API, quyền chỉ đọc, ngay trên trình duyệt.
- Điền: số tuần, ngày, tên chiến dịch, thời gian triển khai, ngân sách từng kênh, nhân sự, các bảng số liệu (mỗi ID tài khoản một dòng + dòng TỔNG; DEAL/MQL/SQL = "-"), chèn ảnh vào slide Ads/Hóa đơn của từng kênh.
- Ảnh được phân loại theo tên file/thư mục: kênh (`tiktok`, `zalo`, `google`, mặc định Facebook) và loại slide (`hóa đơn`/`invoice` → Hóa đơn; `quảng cáo`/`đang chạy`/`qc` → QC đang chạy; còn lại → Chiến dịch). Chỉnh tay trên lưới ảnh.

## Cách trang hiểu file mẫu (COLLECTION_BÁO CÁO MARKETING THEO TUẦN.pptx)

| Slide mẫu | Nhận diện | Điền |
|---|---|---|
| Ngân sách tổng / Nhân sự | dòng `Facebook:` `Tiktok:`… , `NHÂN SỰ:` | chi phí (+phí nền tảng) từng kênh, tên nhân sự |
| TUẦN | `TUẦN 1`, `.......10.2026 - …` | số tuần, ngày đầu–cuối tuần |
| Bảng tổng theo kênh | icon kênh trên cột "Nền tảng" (học từ slide phân cách kênh) | mỗi ID tài khoản một dòng + TỔNG; DEAL/MQL/SQL = "-" |
| Bảng chi tiết TikTok/Zalo/Google | tiêu đề `… ADS:` / mục kênh | như trên + Impressions, Reach, Frequency, CTR, CPM… |
| Slide ảnh | khung ảnh demo + ghi chú "Lưu ý"; loại theo nội dung ghi chú | thay ảnh demo bằng ảnh chứng từ, bỏ số 1-2-3-4 và dòng "*Demo"; nhiều ảnh → nhân bản slide |

Tuỳ chọn: phạm vi số liệu (tuần đã chọn / cộng dồn), số ảnh mỗi slide, bỏ kênh không chạy, bỏ slide ảnh mẫu khi không có ảnh.

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
