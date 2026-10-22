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
  - `LEAD_ENDPOINT`: URL Web App Google Apps Script (mã ở `integrations/google-apps-script/Code.gs`). Lead ghi vào Sheet **Leads – Website Da Nang Downtown** trên Google Drive và gửi email báo khách mới.
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
