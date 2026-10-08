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
- `LEAD_ENDPOINT` trong `assets/site.js`: URL nhận lead (API CRM, Google Apps Script…). Payload JSON: `name, phone, need, unit_type, source, page, submitted_at`.

## Xem thử
```
cd web && python3 -m http.server 8000
```
