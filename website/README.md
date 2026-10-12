# Website Hoàng Gia Minh (bất động sản)

Trang tĩnh (HTML/CSS/JS thuần, không cần build), tối ưu SEO, đặt ở thư mục gốc tên miền `https://hoanggiaminh.com/`.

## Xem thử trên máy
```bash
cd website && python3 -m http.server 8000   # mở http://localhost:8000
```

## Việc cần làm trước khi đưa lên
1. Thay mọi chỗ `[SỐ ĐIỆN THOẠI]`, `[EMAIL]`, `[SỐ NHÀ, ĐƯỜNG]`, `[QUẬN/HUYỆN]`, `[TỈNH/THÀNH PHỐ]`, `[LINK ...]`
   trong `index.html` (cả phần JSON-LD trong `<head>` lẫn phần Liên hệ và nút gọi). Link `tel:` viết liền, ví dụ `tel:0912345678`.
2. 4 tin trong mục "Bất động sản nổi bật" là **tin mẫu**, ảnh là hình minh họa vẽ bằng SVG (`assets/listing-*.svg`, `hero-city.svg`, `about-keys.svg`).
   Thay bằng tin và ảnh thật (WebP/JPG ~1200px, giữ `width`, `height`, `loading="lazy"` và viết `alt` mô tả ảnh).
3. Gắn form "Nhận tư vấn" vào CRM / Google Form / LadiPage (xem chú thích trong `main.js`).
4. Nếu dùng tên miền khác, sửa `hoanggiaminh.com` trong `index.html`, `robots.txt`, `sitemap.xml`.
5. Sau khi chạy: khai báo `sitemap.xml` trên Google Search Console, kiểm tra bằng Rich Results Test và PageSpeed Insights.

## Đã có cho SEO
- `title`/`description` đúng độ dài, `canonical`, `lang="vi"`, Open Graph (ảnh `assets/og-image.png` 1200×630) cho Facebook/Zalo.
- Dữ liệu có cấu trúc schema.org: `RealEstateAgent`, `WebSite`, `FAQPage` (khớp nội dung mục Hỏi đáp).
- Một thẻ H1, H2/H3 theo đúng cấp; HTML ngữ nghĩa (`header`, `nav`, `main`, `section`, `article`, `address`, `footer`).
- `robots.txt`, `sitemap.xml`, `site.webmanifest`, favicon, trang `404.html` (`noindex`).
- Phông chữ Be Vietnam Pro + Playfair Display tự lưu trữ trong `assets/fonts` (giấy phép SIL OFL), có preload.
- Nhẹ: không thư viện JS, không ảnh nặng; responsive, không cuộn ngang trên điện thoại, nút gọi nổi trên di động.
- Hỗ trợ truy cập: link "bỏ qua tới nội dung", nhãn form, trạng thái `aria`, tôn trọng `prefers-reduced-motion`.
