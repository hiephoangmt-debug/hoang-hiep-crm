# SEO chuẩn & tốc độ cho DanangStay (WordPress)

## A. Landing page – đã làm sẵn trong plugin
| Hạng mục | Trạng thái |
|---|---|
| Mỗi ngôn ngữ một đường dẫn: `/` (VI), `?lang=en`, `?lang=ko` | ✅ |
| `<title>`, meta description, `<html lang>` đúng ngôn ngữ ngay từ máy chủ | ✅ |
| `canonical` + `hreflang` vi / en / ko / x-default | ✅ |
| Không tự đổi ngôn ngữ theo trình duyệt (Google đọc đúng từng bản), chỉ hiện gợi ý "View in English / 한국어로 보기" | ✅ |
| Dữ liệu có cấu trúc: `TravelAgency` (tên, logo, SĐT, email, địa chỉ, ngôn ngữ, Fanpage) + `FAQPage` | ✅ |
| Open Graph / Twitter card (ảnh logo khi chia sẻ Facebook, Zalo) | ✅ |
| Landing page có trong sitemap `/wp-sitemap.xml` | ✅ (nếu dùng Rank Math: xem mục C) |
| 1 thẻ H1, giao diện điện thoại, nút gọi/Zalo, không tràn ngang | ✅ |
| Tiêu đề/mô tả SEO tiếng Việt sửa được trong **Cài đặt → DanangStay** | ✅ |

## B. Việc cần làm ngay sau khi lên web (≈ 1 giờ)
1. **Cài đặt → Đọc**: BỎ chọn "Ngăn chặn các công cụ tìm kiếm đánh chỉ mục".
2. **Cài đặt → Đường dẫn tĩnh**: chọn **Tên bài viết** (`/ten-bai-viet/`).
3. **Google Search Console** (search.google.com/search-console): thêm `danangstay.com.vn` (xác minh bằng DNS ở iNET), gửi sitemap `https://danangstay.com.vn/wp-sitemap.xml` (hoặc `/sitemap_index.xml` nếu dùng Rank Math).
4. **Bing Webmaster Tools**: nhập từ Search Console (1 cú nhấp).
5. **Google Analytics 4**: dán mã vào ô "Mã gắn vào <head>" trong Cài đặt → DanangStay (plugin đã gửi sự kiện `generate_lead` khi khách gửi form).
6. **Google Business Profile**: tạo hồ sơ "DanangStay" (loại: Đại lý du lịch / Dịch vụ đặt phòng), cùng tên, SĐT, địa chỉ, website với trang web (NAP thống nhất).
7. **Naver Search Advisor** (searchadvisor.naver.com) cho khách Hàn: xác minh site, gửi sitemap.
8. Điền **Địa chỉ văn phòng** trong Cài đặt → DanangStay để dữ liệu doanh nghiệp đầy đủ.

## C. Plugin nên cài (miễn phí)
| Plugin | Để làm gì |
|---|---|
| **Rank Math SEO** | Tiêu đề/mô tả từng bài, sitemap, schema bài viết, gợi ý tối ưu. Khi cài: Rank Math → Sitemap → bật; landing page ở chế độ *Trang chủ* sẽ tự có trong sitemap. Ở chế độ đường dẫn riêng, thêm 3 link landing vào Search Console bằng tay |
| **Polylang** | Blog 3 ngôn ngữ, mỗi bài có bản VI/EN/KO và hreflang tự động |
| **LiteSpeed Cache** (hosting LiteSpeed) hoặc **WP Super Cache** | Tăng tốc – xem mục E |
| **Redirection** | Chuyển hướng 301 khi đổi đường dẫn bài, theo dõi lỗi 404 |

## D. Viết bài chuẩn SEO (mục Cẩm nang)
**Từ khóa mục tiêu** (kiểm tra lượng tìm kiếm bằng Google Keyword Planner / Search Console):
- VI: khách sạn Đà Nẵng gần biển · khách sạn Mân Thái · căn hộ view biển Đà Nẵng · khách sạn Mỹ Khê giá rẻ · homestay Sơn Trà · ăn hải sản Mân Thái · lịch trình Đà Nẵng 3 ngày 2 đêm · Đà Nẵng mùa mưa
- EN: where to stay in Da Nang · Da Nang beach hotel · My Khe beach hotels · Da Nang itinerary · Da Nang long stay apartment
- KO: 다낭 숙소 추천 · 다낭 미케비치 호텔 · 다낭 가족여행 숙소 · 다낭 한달살기 · 다낭 해산물 맛집

**Khung mỗi bài:**
1. Tiêu đề 50–60 ký tự, có từ khóa chính ở đầu. Ví dụ: *"Khách sạn Mân Thái view biển: 7 lựa chọn đáng ở 2026"*.
2. Đường dẫn ngắn, không dấu: `/khach-san-man-thai/`.
3. Mô tả 140–160 ký tự, có lợi ích + lời kêu gọi.
4. Đoạn mở đầu trả lời ngay câu hỏi; H2/H3 rõ ràng; bảng so sánh giá/khoảng cách.
5. Ảnh thật tự chụp, nén WebP, đặt tên file + alt có từ khóa (`khach-san-man-thai-view-bien.webp`).
6. 3–5 liên kết nội bộ (bài liên quan + **landing đặt phòng**), 1–2 liên kết ngoài uy tín.
7. Cuối bài: nút "Nhận báo giá phòng" dẫn về landing.
8. Cập nhật bài cũ mỗi 6 tháng (giá, năm trong tiêu đề).

**Nhịp đăng:** 2–3 bài/tuần tiếng Việt, 1 bài/tuần tiếng Anh hoặc Hàn. Cụm chủ đề: *Lưu trú theo khu* · *Ăn gì* · *Chơi gì* · *Lịch trình* · *Mẹo (thời tiết, di chuyển, tiền)* · *Sự kiện (pháo hoa DIFF, lễ hội)*.

## E. Tốc độ – WordPress nhanh nhất
| Thành phần | Chọn |
|---|---|
| Hosting | Gói **WordPress/LiteSpeed**, máy chủ đặt tại **Việt Nam** (khách nội địa) – hỏi iNET gói có LiteSpeed + NVMe |
| PHP | **8.3** (chọn trong trang quản lý hosting) |
| Cache | **LiteSpeed Cache** (bật Page Cache, CSS/JS minify, ảnh WebP, Lazy load). Hosting không có LiteSpeed → WP Super Cache |
| Giao diện blog | **GeneratePress** hoặc **Kadence** (nhẹ, < 50 KB). Tránh theme "đa năng" nặng |
| Dựng trang | Trình soạn thảo mặc định (Gutenberg) + GenerateBlocks/Kadence Blocks. **Hạn chế Elementor/WPBakery** (làm chậm rõ rệt) |
| CDN | **Cloudflare miễn phí** (trỏ DNS iNET sang Cloudflare) – nhanh hơn cho khách Hàn, Mỹ, chống tấn công |
| Ảnh | Ảnh ≤ 200 KB, rộng ≤ 1600px, WebP |
| Plugin | Giữ ≤ 15 plugin, xóa plugin không dùng |

Landing page DanangStay chạy độc lập (không tải theme), nên vốn đã nhẹ: ~45 KB HTML + logo SVG.

**Mục tiêu đo bằng PageSpeed Insights (pagespeed.web.dev), bản điện thoại:** điểm ≥ 90, LCP < 2,5 giây, CLS < 0,1.
