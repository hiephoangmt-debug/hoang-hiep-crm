# DanangStay – Landing page đặt phòng khách sạn Đà Nẵng

Trang một file (`index.html`) cho khách trong và ngoài nước gửi yêu cầu báo giá phòng.

- 3 ngôn ngữ: Tiếng Việt / English / 한국어. Trang tự chọn theo trình duyệt, đổi bằng nút hoặc link `?lang=en`, `?lang=ko`.
- Form báo giá: ngày, số khách, số phòng, ngân sách, kênh liên hệ (Zalo / WhatsApp / KakaoTalk / gọi).
- Nút Zalo, WhatsApp, KakaoTalk, gọi điện nổi trên màn hình; thanh liên hệ dưới đáy trên điện thoại.
- Mục dành cho chủ khách sạn muốn hợp tác vận hành và bán phòng.
- Có sẵn sự kiện `generate_lead` (Google Analytics) và `Lead` (Facebook Pixel) nếu gắn mã.

## Cài đặt
1. Mở `index.html`, sửa khối `CONFIG` ở đầu phần `<script>`: hotline, Zalo, WhatsApp, link KakaoTalk, email, Facebook, TikTok.
2. Nhận khách vào Google Sheet và Telegram: làm theo hướng dẫn trong `google_sheet.gs`, rồi dán link Web App vào `CONFIG.sheetWebhook`.
   Nếu để trống, khi khách bấm gửi, trang sẽ mở Zalo/WhatsApp/Kakao để khách nhắn thẳng.
3. Đăng trang: sau khi merge vào `main`, trang tự lên GitHub Pages tại `/danangstay/`. Hoặc copy `index.html` lên hosting / LadiPage (dán HTML).
