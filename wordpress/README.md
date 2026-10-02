# Website WordPress – hiephoangmt.com

Website bất động sản **Hoàng Hiệp** chạy WordPress, gồm:

- **Theme `hoanghiep`**: trang chủ (banner, tìm kiếm, BĐS nổi bật, dịch vụ, tin tức, form tư vấn), danh sách và lọc BĐS theo khu vực/loại, trang chi tiết BĐS có form "Đăng ký xem nhà", tin tức, nút gọi điện/Zalo nổi, giao diện mobile.
- **Plugin CRM `mu-plugins/hh-crm.php`** (luôn bật):
  - Loại nội dung **Bất động sản**: giá, diện tích, địa chỉ, số phòng ngủ, pháp lý, trạng thái (Đang bán/Cho thuê/Đã bán) và tuỳ chọn hiển thị nổi bật ở trang chủ; phân loại **Khu vực** và **Loại BĐS**.
  - **Khách hàng**: mỗi lần khách gửi form sẽ tạo một khách hàng (riêng tư, chỉ xem trong quản trị) và gửi email báo về địa chỉ email quản trị. Bạn theo dõi trạng thái Mới → Đã liên hệ → Đang chăm sóc → Đã chốt.
  - Shortcode `[hh_lead_form]` để chèn form vào bất kỳ trang nào.
- **Docker**: WordPress + MariaDB + Caddy (tự cấp và gia hạn HTTPS miễn phí cho tên miền).

## Đưa lên tên miền hiephoangmt.com

### 1. Chuẩn bị máy chủ
Thuê một VPS Linux (Ubuntu 22.04+, từ 1 GB RAM), cài Docker:
```bash
curl -fsSL https://get.docker.com | sh
```

### 2. Trỏ tên miền
Tại nơi quản lý DNS của `hiephoangmt.com`, tạo bản ghi:

| Loại | Tên | Giá trị |
|------|-----|---------|
| A | `@` | IP của VPS |
| A | `www` | IP của VPS |

### 3. Cài đặt
```bash
git clone <repo này> && cd hoang-hiep-crm/wordpress
cp .env.example .env
nano .env                      # đổi toàn bộ mật khẩu
docker compose --profile production up -d
./scripts/setup.sh             # cài WordPress, kích hoạt theme, tạo trang & menu
```
Mở https://hiephoangmt.com/wp-admin và đăng nhập bằng `WP_ADMIN_USER` / `WP_ADMIN_PASSWORD`.

### 4. Sau khi cài
- **Giao diện → Tùy biến → Thông tin liên hệ**: hotline, Zalo, email, địa chỉ, Facebook.
- **Giao diện → Tùy biến → Banner trang chủ**: tiêu đề, mô tả, ảnh nền; tải logo ở mục *Nhận dạng site*.
- **Bất động sản → Thêm mới**: nhập tin, đặt ảnh đại diện, chọn khu vực/loại, tick "Nổi bật" để lên trang chủ.
- **Khách hàng**: xem danh sách khách để lại thông tin.
- Nên cài thêm plugin gửi mail SMTP (ví dụ *WP Mail SMTP*) để email báo khách hàng mới không vào spam, và một plugin sao lưu.

## Chạy thử trên máy
Trong `.env` đặt `SITE_URL=http://localhost:8080`, rồi:
```bash
docker compose up -d
./scripts/setup.sh
```
Truy cập http://localhost:8080 (không cần Caddy).

## Cấu trúc
```
wordpress/
├── docker-compose.yml        # db, wordpress, wpcli (tools), caddy (production)
├── Caddyfile                 # HTTPS + chuyển www → không www
├── .env.example
├── uploads.ini               # giới hạn upload 64 MB
├── scripts/setup.sh          # cài đặt lần đầu bằng WP-CLI
└── wp-content/
    ├── mu-plugins/hh-crm.php # BĐS + khách hàng + form
    └── themes/hoanghiep/     # giao diện
```

Theme và plugin cũng có thể dùng trên hosting WordPress thông thường (cPanel…): tải thư mục `themes/hoanghiep` vào `wp-content/themes/`, `mu-plugins/hh-crm.php` vào `wp-content/mu-plugins/`, rồi kích hoạt theme *Hoàng Hiệp*.
