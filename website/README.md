# Website FPT City Đà Nẵng (fpt-city.com)

Website tĩnh, chuẩn SEO, gồm các trang:

| Trang | URL |
|---|---|
| Trang chủ FPT City | `/` |
| Đất nền FPT City (tổng quan) | `/dat-nen-fpt-city/` |
| Phân khu V1 … V6 | `/dat-nen-fpt-city/phan-khu-v1/` … |
| Căn hộ FPT Plaza (so sánh) | `/can-ho-fpt-plaza/` |
| FPT Plaza 1 … 5 | `/fpt-plaza-1/` … `/fpt-plaza-5/` |

Mỗi trang có title/description/keywords riêng, canonical, Open Graph, schema JSON-LD
(BreadcrumbList, FAQPage, Place/ApartmentComplex), sitemap.xml, robots.txt và liên kết nội bộ.

## Cấu hình (bắt buộc trước khi chạy thật)

1. **Link Google Drive**: `src/data.mjs` → `site.drive` (mặc định). Mỗi phân khu / tòa Plaza
   có thể có link riêng: thêm `drive: "https://drive.google.com/..."` vào object tương ứng.
2. **Hotline, Zalo, email, popup, đếm ngược**: khối `CONFIG` đầu file `public/assets/js/main.js`.
   `offerEndsAt` chỉ điền khi có hạn ưu đãi thật (để trống = ẩn đồng hồ).
3. **Lưu khách hàng vào Google Sheet "DATA CHẠY GOOGLE"**: làm theo hướng dẫn đầu file
   `google-apps-script.gs`, dán URL `/exec` vào `CONFIG.leadEndpoint`. Khách FPT Plaza 4 ghi vào
   tab "FPT PLAZA 4" có sẵn; Plaza 1/2/3/5, "DAT NEN FPT CITY", "FPT CITY" tự tạo tab.

## Build & xem thử

```bash
npm run build      # sinh HTML vào public/
npm run preview    # build + chạy http://localhost:8080
```

Thêm phân khu (V7, V8…) hoặc tòa mới: thêm object vào `zones` / `plazas` trong `src/data.mjs`
rồi build lại – menu, footer, sitemap, liên kết nội bộ tự cập nhật.

## Triển khai

Upload thư mục `public/` lên hosting (Netlify, Vercel, Cloudflare Pages, cPanel…) và trỏ domain
`fpt-city.com` vào gốc. Sau đó khai báo `https://fpt-city.com/sitemap.xml` trong Google Search Console.

## Lưu ý nội dung

Số liệu tổng hợp từ báo chí và các nguồn thị trường; FPT Plaza 5 và đặc điểm từng phân khu
là thông tin **dự kiến / tham khảo** – cập nhật trong `src/data.mjs` khi chủ đầu tư công bố.
