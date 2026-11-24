# Cài DanangStay lên WordPress (hosting iNET)

## Bước 1 – Cài WordPress trên hosting
1. Đăng nhập trang quản lý hosting iNET (DirectAdmin/cPanel; link và mật khẩu iNET gửi qua email).
2. Tìm mục **WordPress** / **Softaculous** / **Cài đặt ứng dụng** → chọn WordPress → **Install**.
3. Chọn tên miền `danangstay.com.vn`, giao thức **https://**, để trống ô thư mục (cài ở gốc tên miền).
4. Đặt tên site "DanangStay", tài khoản quản trị (đừng dùng tên `admin`), mật khẩu mạnh, ngôn ngữ **Tiếng Việt** → Cài đặt.
5. Bật **SSL miễn phí (Let's Encrypt)** trong trang hosting nếu chưa có ổ khóa https.

## Bước 2 – Cài plugin landing page
1. Vào `danangstay.com.vn/wp-admin` → **Plugin → Cài mới → Tải plugin lên**.
2. Chọn tệp **`danangstay-landing.zip`** (trong thư mục này) → **Cài đặt** → **Kích hoạt**.
3. Vào **Cài đặt → DanangStay**, điền: hotline, Zalo, WhatsApp, link KakaoTalk, email, Fanpage, email nhận báo khách mới.
4. Chọn **"Hiển thị landing ở"**:
   - **Trang chủ của website** – vào `danangstay.com.vn` là thấy landing page (khuyên dùng lúc đầu).
   - **Một đường dẫn riêng** – ví dụ `danangstay.com.vn/dat-phong/`, trang chủ để làm blog.
5. Lưu cài đặt, mở trang để kiểm tra, gửi thử một yêu cầu.

## Bước 3 – Quản lý khách
- Menu **Đặt phòng** (biểu tượng cây dừa): danh sách yêu cầu, ngày ở, số khách, ngân sách, ngôn ngữ.
- Bấm vào từng khách: nút **Gọi** / **Zalo**, đổi trạng thái *Mới → Đã liên hệ → Đã báo giá → Đã chốt / Hủy*.
- Nút **Xuất Excel (CSV)** để tải toàn bộ danh sách.
- Mỗi khách mới được báo qua email. Muốn báo qua Telegram: điền token bot và chat id trong cài đặt.
  Nếu email báo khách không về: cài plugin **WP Mail SMTP**, dùng hộp thư `booking@danangstay.com.vn` iNET tặng.

## Bước 4 – Viết blog (Cẩm nang)
1. **Trang → Thêm mới** "Cẩm nang" (đường dẫn `/cam-nang/`).
2. **Cài đặt → Đọc**: "Trang chủ hiển thị" = trang tĩnh; "Trang bài viết" = Cẩm nang.
3. Trong **Cài đặt → DanangStay**, ô "Trang Cẩm nang / Blog" điền `https://danangstay.com.vn/cam-nang/` → landing page tự hiện nút **Cẩm nang**.
4. Viết bài ở **Bài viết → Viết bài mới**. Plugin nên cài thêm: **Rank Math** (SEO), **Polylang** (bài tiếng Anh/Hàn), **LiteSpeed Cache** (nếu hosting dùng LiteSpeed).

## Cập nhật plugin khi landing page thay đổi
Chạy `./build.sh` để tạo lại `danangstay-landing.zip`, rồi tải lên lại (WordPress hỏi "Thay thế bản hiện tại" → đồng ý; cài đặt và dữ liệu khách vẫn giữ nguyên).
