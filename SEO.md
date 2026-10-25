# SEO cho Google và ChatGPT – hiephoangmt.com

Code tự đăng bài đã được tối ưu sẵn (xem cuối file). Phần dưới là việc cần làm **1 lần** trên
WordPress và các công cụ của Google/Bing – code không tự làm được.

## 1. Kiểm tra trang có lên Google chưa (miễn phí)

1. Vào **Google Search Console** (search.google.com/search-console) → thêm `hiephoangmt.com`
   (loại *Tên miền*, xác minh bằng bản ghi DNS ở nơi mua tên miền).
2. **Sơ đồ trang web** → gửi `https://hiephoangmt.com/sitemap_index.xml`
   (Rank Math/Yoast) hoặc `https://hiephoangmt.com/wp-sitemap.xml` (WordPress gốc).
3. Sau 2–3 ngày xem **Hiệu suất**: từ khoá, số lần hiển thị, *vị trí trung bình* = thứ hạng.
4. Kiểm tra nhanh trên Google: gõ `site:hiephoangmt.com` – không ra kết quả nào nghĩa là
   Google chưa lập chỉ mục trang.

## 2. ChatGPT tìm thấy trang qua Bing

ChatGPT Search dùng chỉ mục Bing và bot riêng của OpenAI, nên cần:

1. **Bing Webmaster Tools** (bing.com/webmasters) → *Nhập từ Google Search Console* (1 cú bấm).
2. Bật **IndexNow** (Rank Math → Hướng dẫn tức thì / Instant Indexing) để bài mới được báo cho
   Bing ngay khi đăng.
3. Không chặn bot AI trong `robots.txt` (Rank Math → Cài đặt chung → Chỉnh sửa robots.txt):

```
User-agent: *
Disallow: /wp-admin/
Allow: /wp-admin/admin-ajax.php

User-agent: OAI-SearchBot
Allow: /

User-agent: ChatGPT-User
Allow: /

User-agent: GPTBot
Allow: /

User-agent: PerplexityBot
Allow: /

User-agent: Google-Extended
Allow: /

Sitemap: https://hiephoangmt.com/sitemap_index.xml
```

Nếu dùng Cloudflare: tắt *Block AI bots* (Security → Bots), nếu không ChatGPT không đọc được trang.

4. Tải file `llms.txt` (mẫu ở mục 5) lên thư mục gốc web: `https://hiephoangmt.com/llms.txt`.

## 3. WordPress

- Cài **Rank Math SEO** (miễn phí): tự tạo sitemap, schema bài viết (*NewsArticle*), thẻ mô tả
  (lấy từ *Tóm tắt* mà bot đã điền), breadcrumb.
- Rank Math → Titles & Meta → Bài viết: Schema mặc định = **News Article**.
- Cài đặt → Đường dẫn tĩnh: chọn **Tên bài viết** (`/%postname%/`).
- Cài đặt → Đọc: **bỏ tích** "Ngăn chặn công cụ tìm kiếm đánh chỉ mục".
- Tạo trang **Giới thiệu** (tên, kinh nghiệm, ảnh thật, số điện thoại/Zalo, khu vực hoạt động) và
  trang **Liên hệ**. Google và AI ưu tiên nguồn có tác giả rõ ràng (E-E-A-T).
- Tài khoản bot đăng bài: đặt *Tên hiển thị* = tên thật của bạn, điền tiểu sử.

## 4. Ngoài website

- **Google Business Profile** "Hoàng Hiệp – Bất động sản Đà Nẵng", gắn link web: giúp hiện trên
  Google Maps và khi hỏi AI "môi giới BĐS Đà Nẵng".
- Ghi tên, số điện thoại, địa chỉ **giống hệt nhau** trên web, Facebook, Zalo OA, Google.
- Mỗi bài mới: chia sẻ lên Facebook/Zalo – lượt truy cập thật giúp Google lập chỉ mục nhanh hơn.

## 5. Mẫu llms.txt

```
# Hoàng Hiệp – Bất động sản Đà Nẵng

> Tin quy hoạch, hạ tầng, giá đất và dự án bất động sản Đà Nẵng, cập nhật mỗi ngày.
> Tư vấn căn hộ FourS Tower (Sun Riverpolis) và nhà đất Đà Nẵng.

## Chuyên mục
- [Hạ tầng & quy hoạch](https://hiephoangmt.com/category/ha-tang-quy-hoach/): bài phân tích và bản tin quy hoạch – hạ tầng Đà Nẵng hằng ngày

## Liên hệ
- Hotline/Zalo: [điền số]
```

(Sửa lại đường dẫn chuyên mục cho đúng với web.)

## Code đã tối ưu sẵn

- **AI viết bài** (`news-telegram/rewrite_articles.py`): mỗi bài có từ khoá chính trong tiêu đề,
  câu đầu và tiêu đề mục; mở bài trả lời thẳng + danh sách điểm chính (AI hay trích đoạn này);
  ngày tháng cụ thể; mục **Câu hỏi thường gặp**; đường dẫn ngắn không dấu theo từ khoá;
  thẻ (tag); mục **Bài liên quan** trỏ tới bài cũ cùng chủ đề.
- **Bản tin hằng ngày** (`news-telegram/publish_digest.py`): thêm thẻ chủ đề.
- **Trang căn hộ mẫu, bảng hàng, thống kê đầu tư** (GitHub Pages): thêm mô tả, ảnh xem trước khi
  gửi link qua Zalo/Facebook, sitemap; công cụ thiết kế nội bộ được ẩn khỏi Google.
