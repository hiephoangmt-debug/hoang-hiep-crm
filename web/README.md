# Website SEO – Da Nang Downtown

Site tĩnh (HTML/CSS/JS thuần), deploy thư mục `web/` lên gốc domain.

| Đường dẫn | Trang |
|---|---|
| `/` | Da Nang Downtown (trang trụ cột) |
| `/sun-galaxy-complex/` | Sun Galaxy Complex (trang con, liên kết hai chiều với trang trụ cột) |

## Cần chỉnh trước khi đưa lên
- Liên hệ: hotline 0904 567 009, email hiephoangmt@gmail.com (đã điền ở cả hai trang và JSON-LD). Màu thương hiệu: xanh navy `#0b2a4a`, trắng, cam `#e85d0c` (khai báo trong `assets/site.css`).
- Domain trong `canonical`, `og:url`, JSON-LD, `sitemap.xml`, `robots.txt` (đang dùng `https://www.sun-danangdowntown.com`).
- Ảnh OG 1200×630: `/images/da-nang-downtown-og.jpg`, `/images/sun-galaxy-complex-og.jpg`.
- `CONFIG` ở đầu `assets/site.js`:
  - `LEAD_ENDPOINT`: URL Web App Google Apps Script (mã ở `integrations/google-apps-script/Code.gs`). Lead ghi vào Sheet **DATA CHẠY GOOGLE**, tab **Dowtown** (A thời gian, B tên, C SĐT, D nhu cầu, E link có gclid, L mã form WEB-FORM / WEB-POPUP / WEB-CHAT) gửi tin **Telegram** (cần `TELEGRAM_BOT_TOKEN`, `TELEGRAM_CHAT_ID` trong Thuộc tính tập lệnh) và gửi email báo khách mới. Cùng URL /exec dùng làm "API Webhook" cho form LadiPage, nên trang trên LadiPage cũng báo về Sheet và Telegram.
  - `DOCS_URL`: link thư mục Google Drive chứa bảng giá, mặt bằng, brochure. Khách để lại thông tin xong sẽ thấy nút mở tài liệu.
  - `ZALO_URL`, `HOTLINE`: đang là 0904 567 009.

## Công cụ thu lead
- Form chính, popup "Nhận bộ tài liệu" (mở từ các nút tài liệu và khi rê chuột ra khỏi trang trên máy tính, tối đa 1 lần mỗi phiên).
- Chat tự động: trả lời giá, vị trí, Galaxy, vay, pháp lý, tiến độ, loại căn, tiện ích; xin tên, số điện thoại và kênh nhận tài liệu rồi gửi lead kèm 12 dòng chat gần nhất.
- Nút nổi Zalo, gọi, chat; thanh dưới cùng trên điện thoại: Gọi, Zalo, Nhận bảng giá.
- Công cụ tính khoản vay (ân hạn gốc, hỗ trợ lãi 0% tối đa 30 tháng).
- Sự kiện `generate_lead` đẩy vào `dataLayer` (GTM/GA4) và `fbq('track','Lead')` nếu có Meta Pixel.

## Xem thử
```
cd web && python3 -m http.server 8000
```

## Trang trên LadiPage
- `ladipage/build.py` dựng `ladipage/da-nang-downtown.html` (HTML tĩnh theo luật LadiPage v2) từ `index.html`.
- Trang LadiPage của www.sun-danangdowntown.com dùng file này (form FORM431, FORM438; nút nổi Chat/Gọi/Zalo).
- Ảnh trỏ về repo public trên nhánh `claude/great-tesla-ki0len`, không xóa nhánh khi trang còn dùng.

### Trang LadiPage chế độ basic (giữ nguyên HTML, như Sun FourS Tower)
Dựng bằng `ladipage/build_basic.py` từ `ladipage/basic/*.html`:

| Trang | LadiPage ID | Đường dẫn cần gắn |
|---|---|---|
| Da Nang Downtown (trang chủ) | `6ad9e11192364b00132fb925` | `www.sun-danangdowntown.com` |
| Sun Galaxy Complex | `6ad9e1136b2c75001205ce79` | `www.sun-danangdowntown.com/sun-galaxy-complex` |
| Tháp 408m | `6ad9e11406fc060013e37e43` | `www.sun-danangdowntown.com/thap-408m` |

Trang kéo-thả cũ `68b9064ebe3b5d001262fd88` đang giữ tên miền; gỡ tên miền khỏi trang này trước khi gắn cho trang chủ mới.
