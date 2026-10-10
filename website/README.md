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
3. **Lưu khách hàng**: cài [Hoàng Hiệp CRM](../crm/README.md) rồi dán URL `/exec` vào `CONFIG.leadEndpoint`.
   Khách vào CRM (tab `CRM_LEADS`) và vẫn ghi vào tab dự án theo định dạng cũ.

## Chat tư vấn & nút liên hệ

- Cụm nút cố định bên phải (máy tính và điện thoại): **Chat tư vấn**, **Zalo**, **Gọi**. Điện thoại có thêm thanh "Nhận bảng giá" ở đáy.
- Chat (`public/assets/js/chat.js`) trả lời tự động từ `public/assets/chat-kb.json` (sinh khi build từ `src/data.mjs`
  và mặt bằng FPT Plaza 4) – tra mã căn (VD `N-12.12`), mở layout căn, xin SĐT và gửi về CRM.
- AI tuỳ chọn qua CRM: xem mục *Chat AI* trong `crm/README.md`. Tắt AI: `CONFIG.chatAI = false`. Tắt lời chào tự hiện: `chatTeaserSeconds: 0`.
- Mở chat từ link bất kỳ: thêm `#chat` vào cuối URL.

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
