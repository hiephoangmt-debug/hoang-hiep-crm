# Website Cora Tower – www.cora-tower.com

Website tĩnh, chuẩn SEO (HTML/CSS/JS thuần, không cần build). Upload toàn bộ thư mục này lên **thư mục gốc** của tên miền.

| Trang | URL | Từ khóa chính |
|---|---|---|
| `index.html` | `/` | Cora Tower, Cora Tower Đà Nẵng |
| `khoi-de-shophouse.html` | `/khoi-de-shophouse.html` | shophouse khối đế Cora Tower |
| `penthouse.html` | `/penthouse.html` | penthouse Cora Tower |

## SEO đã có
- Title, meta description và canonical riêng cho từng trang; thẻ Open Graph/Twitter
- Schema JSON-LD: ApartmentComplex, Product, Apartment, BreadcrumbList, FAQPage
- Mỗi trang một H1, cấu trúc H2/H3 rõ ràng, liên kết nội bộ giữa 3 trang
- `sitemap.xml`, `robots.txt`, responsive trên mobile, nút gọi nhanh cố định, chế độ tối

## Cần thay trước khi chạy thật
1. **Hotline/Zalo**: thay `0900000000` / `0900 000 000` trong cả 3 file HTML.
2. **Ảnh OG**: thêm `assets/og-cora-tower.jpg`, `og-shophouse.jpg`, `og-penthouse.jpg` (1200×630).
3. **Form nhận khách**: điền `FORM_ENDPOINT` trong `assets/main.js` (webhook CRM, Google Apps Script…). Khi để trống, form chỉ hiện thông báo cảm ơn và **không lưu** dữ liệu.
4. **Số liệu, giá**: đối chiếu với tài liệu chính thức của chủ đầu tư và cập nhật lại nếu cần.
5. Gửi sitemap lên Google Search Console.
