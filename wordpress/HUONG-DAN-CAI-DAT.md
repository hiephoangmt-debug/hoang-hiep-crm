# Hướng dẫn đưa website Hoàng Hiệp lên hiephoangmt.com

Làm theo thứ tự. Mỗi bước có **nút bấm cụ thể** trong trang quản trị WordPress. Tổng thời gian khoảng 30–60 phút (chưa tính thời gian chờ tên miền nhận hosting).

Bạn cần 2 file:

| File | Là gì | Cài ở đâu |
|---|---|---|
| `hoang-hiep-crm.zip` | Plugin: dự án, nhà đất, khách hàng, dữ liệu 30 dự án | **Plugin → Cài mới → Tải plugin lên** |
| `hoanghiep.zip` | Giao diện website (navy – trắng – nâu) | **Giao diện → Giao diện → Thêm mới → Tải giao diện lên** |

> Tự tạo lại 2 file: trong thư mục `wordpress/` chạy `./scripts/build-zip.sh`, file nằm ở `wordpress/dist/`.

## PHẦN A – Cài lại trên hiephoangmt.com đang chạy (giao diện Houzez)

Website hiện tại dùng **Houzez + Elementor + Rank Math**. Làm đúng thứ tự dưới đây: tin đã đăng trên Houzez được **chuyển sang** giao diện mới, link cũ **tự chuyển hướng** (giữ thứ hạng Google), giao diện Houzez **vẫn còn** để quay lại bất cứ lúc nào.

### A1. Sao lưu (bắt buộc)

1. Thanh trên cùng → **Bảng tin** → menu trái **Plugin → Cài mới** → ô tìm kiếm gõ `UpdraftPlus` → **Cài đặt** → **Kích hoạt**.
2. **Cài đặt → Sao lưu UpdraftPlus** → **Sao lưu ngay** → tick *cơ sở dữ liệu* và *tệp* → **Sao lưu ngay**. Đợi báo xong.
3. Bấm vào bản sao lưu → tải 5 file về máy (hoặc tab *Cài đặt* → kết nối Google Drive).

> Hosting có **Staging / WP Toolkit / Softaculous → Clone** thì nên tạo bản thử (VD `thu.hiephoangmt.com`), làm A2–A7 trên bản thử, ưng rồi làm lại trên web chính.

### A2. Cài plugin Hoàng Hiệp CRM

**Plugin → Cài mới → Tải plugin lên** (nút trên cùng) → **Chọn tệp** → `hoang-hiep-crm.zip` → **Cài đặt ngay** → **Kích hoạt plugin**.

Menu trái có thêm **Dự án**, **Nhà đất**, **Khách hàng**. Website **chưa thay đổi gì** ở bước này.

### A3. Chuyển tin từ Houzez (làm TRƯỚC khi đổi giao diện)

1. **Công cụ → Chuyển dữ liệu Houzez**.
2. Xem bảng **Xem trước**: từng tin Houzez sẽ thành *Nhà đất – Bán*, *Nhà đất – Cho thuê* hoặc *Dự án* (tin có loại "Dự án"). Cột **Giá gốc → triệu** cho thấy giá sau khi đổi (VD `3.250.000.000 → 3,25 tỷ`).
3. Bấm **Chuyển dữ liệu**. Tin Houzez gốc **không bị xóa**; chạy lại không tạo trùng.

Được chuyển: tiêu đề, nội dung, ảnh đại diện, thư viện ảnh, giá, diện tích, phòng ngủ, WC, địa chỉ, video, tiện ích, khu vực, loại nhà đất, tiêu đề & mô tả Rank Math.

### A4. Đổi sang giao diện Hoàng Hiệp

**Giao diện → Giao diện → Thêm mới → Tải giao diện lên** → `hoanghiep.zip` → **Cài đặt ngay** → **Kích hoạt**.

### A5. Bấm "Cài đặt nhanh"

**Công cụ → Cài đặt nhanh Hoàng Hiệp** → **Cài đặt nhanh**. Website tự: đặt trang chủ, tạo trang còn thiếu (Tin tức, Về Hiệp, Liên hệ – trang cũ cùng tên được dùng lại), tạo **Menu chính** mới và gắn lên đầu trang, tạo loại dự án / khu vực, nhập **30 dự án** Đà Nẵng – Quảng Nam.

Sau đó: **Cài đặt → Đường dẫn tĩnh** → **Lưu thay đổi** (1 lần).

### A6. Kiểm tra

Mở từng link, thấy giao diện navy – trắng là đúng:

- `https://hiephoangmt.com/` · `/du-an/` · `/mua-ban/` · `/cho-thue/` · `/tin-tuc/` · `/lien-he/`
- Một link tin cũ của Houzez (VD `https://hiephoangmt.com/property/ten-tin/`) → phải tự chuyển sang `/nha-dat/ten-tin/`.
- Bài viết "Thông tin thị trường" cũ hiện ở `/tin-tuc/`.

**Muốn quay lại giao diện cũ:** **Giao diện → Giao diện → Houzez → Kích hoạt**. Không mất gì.

### A7. Rank Math (giữ nguyên plugin)

1. **Rank Math SEO → Tiêu đề & Meta → Dự án** → *Loại Schema*: **Không có (None)** → Lưu. Làm tương tự với **Nhà đất**.
2. **Rank Math SEO → Cài đặt Sitemap**: bật **Dự án** và **Nhà đất**; **tắt "Properties"** (tin Houzez cũ, đã chuyển hướng).
3. **Google Search Console → Sơ đồ trang web** → gửi lại `sitemap_index.xml` và thêm `nhadat-sitemap.xml`.

### A8. Hoàn thiện

- **Giao diện → Tùy biến → Hoàng Hiệp – Thương hiệu**: số điện thoại, Zalo, ảnh chân dung, giới thiệu, hành trình nghề nghiệp → **Đăng**.
- **Dự án**: thêm ảnh đại diện, bảng giá, lịch thanh toán cho dự án đang bán (xem Bước 9 bên dưới).
- **Nhà đất**: mở các tin vừa chuyển, chọn **Thuộc dự án** để tin hiện trong trang dự án.
- **Giao diện → Menu**: menu cũ của Houzez vẫn còn, xóa được khi không dùng.

### A9. Dọn dẹp (sau 1–2 tuần chạy ổn)

**Plugin** → **Tắt** các plugin của Houzez (*Houzez Theme – Functionality*, *Houzez Login Register*, *Houzez CRM*… tên tùy bản) và **Elementor** nếu không còn trang nào cần. Link cũ vẫn tự chuyển hướng. Giữ giao diện Houzez thêm một thời gian rồi mới xóa. Sau đó cập nhật WordPress và plugin (biểu tượng ↻ trên thanh quản trị) – nhớ sao lưu trước.

---

## PHẦN B – Cài mới từ đầu (hosting trống)

Chỉ dùng khi chưa có WordPress. Website đã chạy thì làm **Phần A**.

## Bước 1. Mua hosting WordPress

Chọn gói **hosting WordPress** (cPanel hoặc DirectAdmin) của nhà cung cấp tại Việt Nam, ví dụ AZDIGI, Mắt Bão, PA Vietnam, Tenten, iNET… hoặc Hostinger. Yêu cầu tối thiểu:

- PHP **8.1 trở lên** (tối thiểu 7.4), MySQL/MariaDB
- **SSL miễn phí** (Let's Encrypt / AutoSSL) để web chạy `https://`
- Dung lượng 5 GB trở lên (ảnh dự án sẽ nhiều dần)
- Có sẵn **Softaculous** hoặc trình "Cài WordPress 1 click"

Sau khi mua, nhà cung cấp gửi email gồm: link đăng nhập cPanel, tài khoản, **IP hosting** và **2 nameserver** (dạng `ns1.tenhosting.vn`, `ns2.tenhosting.vn`).

## Bước 2. Trỏ tên miền hiephoangmt.com về hosting

Đăng nhập trang quản lý tên miền (nơi bạn đã mua hiephoangmt.com), chọn **một** trong hai cách:

- **Cách A – đổi nameserver (dễ nhất):** mục *Quản lý DNS / Nameserver* → thay bằng 2 nameserver hosting gửi → Lưu.
- **Cách B – giữ nameserver, sửa bản ghi:** mục *Quản lý DNS* → bản ghi **A** tên `@` trỏ về **IP hosting**; bản ghi **A** (hoặc CNAME) tên `www` trỏ về cùng IP (hoặc `hiephoangmt.com`) → Lưu.

Chờ 15 phút đến vài giờ (tối đa 24h). Kiểm tra: mở `hiephoangmt.com`, thấy trang mặc định của hosting là được.

## Bước 3. Bật SSL (https)

cPanel → **SSL/TLS Status** (hoặc *Let's Encrypt SSL*) → chọn `hiephoangmt.com` và `www.hiephoangmt.com` → **Run AutoSSL / Issue**. Đợi vài phút đến khi có ổ khóa xanh.

## Bước 4. Cài WordPress

cPanel → **Softaculous Apps Installer** → **WordPress** → **Install Now**, điền:

| Ô | Điền |
|---|---|
| Choose Protocol | `https://` |
| Choose Domain | `hiephoangmt.com` |
| In Directory | **để trống** (xóa chữ `wp` nếu có) |
| Site Name | `Hoàng Hiệp` |
| Site Description | `Chuyên gia bất động sản tại Đà Nẵng` |
| Admin Username | tên riêng, **không** dùng `admin` (VD: `hiephoang`) |
| Admin Password | mật khẩu mạnh – lưu lại cẩn thận |
| Admin Email | `hiephoangmt@gmail.com` |
| Select Language | **Vietnamese – Tiếng Việt** |

Bấm **Install**. Xong, đăng nhập tại **https://hiephoangmt.com/wp-admin**.

> Hosting không có Softaculous: vào *Trình cài WordPress* của hosting, hoặc nhờ kỹ thuật hosting cài giúp – chỉ cần bản WordPress trắng.

## Bước 5. Cài plugin Hoàng Hiệp CRM (cài TRƯỚC giao diện)

1. Menu trái **Plugin** → **Cài mới** → nút **Tải plugin lên** (trên cùng).
2. **Chọn tệp** → chọn `hoang-hiep-crm.zip` → **Cài đặt ngay**.
3. Bấm **Kích hoạt plugin**.

Menu trái sẽ có thêm **Dự án**, **Nhà đất**, **Khách hàng**.

## Bước 6. Cài giao diện Hoàng Hiệp

1. **Giao diện** → **Giao diện** → **Thêm mới** → **Tải giao diện lên**.
2. **Chọn tệp** → `hoanghiep.zip` → **Cài đặt ngay** → **Kích hoạt**.

> Nếu website hiện "Website đang được cài đặt…": plugin ở Bước 5 chưa được kích hoạt.

## Bước 7. Bấm "Cài đặt nhanh" (1 nút)

Đầu trang quản trị có thông báo xanh **"Website Hoàng Hiệp: … Cài đặt nhanh"** → bấm nút. (Hoặc **Công cụ → Cài đặt nhanh Hoàng Hiệp**.) Bấm nút lớn **Cài đặt nhanh**. Website tự:

- Đặt múi giờ Việt Nam, đường dẫn đẹp (`/du-an/ten-du-an/`)
- Tạo trang **Trang chủ, Tin tức, Về Hiệp, Liên hệ** và đặt trang chủ
- Tạo loại dự án (**Tổ hợp / Cao tầng / Thấp tầng**…), loại nhà đất, khu vực Đà Nẵng – Quảng Nam, chuyên mục tin tức
- Tạo **Menu chính** 3 cấp
- Nhập **30 dự án** Đà Nẵng – Quảng Nam (cũ)

Bấm lại bao nhiêu lần cũng được: không tạo trùng, không ghi đè phần bạn đã sửa.

**Kiểm tra đường dẫn:** **Cài đặt → Đường dẫn tĩnh** → đang chọn **Tên bài viết** → bấm **Lưu thay đổi** một lần. Mở `https://hiephoangmt.com/du-an/` thấy danh sách dự án là đúng.

## Bước 8. Điền thông tin cá nhân, số điện thoại, ảnh

**Giao diện → Tùy biến → Hoàng Hiệp – Thương hiệu**:

- **Thông tin cá nhân:** họ tên, chức danh, slogan, giới thiệu, hành trình nghề nghiệp, ảnh chân dung / avatar, ảnh hoạt động (hội nghị…).
- **Số liệu nổi bật:** 15+ năm kinh nghiệm…
- **Liên hệ & mạng xã hội:** hotline `0904 567 009`, Zalo, email, Facebook, YouTube…
- **Banner trang chủ.**

Bấm **Đăng** (góc trên) để lưu.

## Bước 9. Hoàn thiện dự án

**Dự án → Tất cả dự án** → bấm tên dự án:

1. **Ảnh đại diện** (cột phải, dưới cùng) → *Đặt ảnh đại diện* → tải ảnh phối cảnh (ngang, khoảng 1920×900).
2. Hộp **Thông tin dự án** bên dưới có các tab: Tổng quan · Vị trí & liên kết vùng · Tiện ích · Mặt bằng · **Loại sản phẩm** (căn hộ, shop, penthouse, duplex, villa, nhà phố, block đất nền) · **Giá & chính sách** (bảng giá, lịch thanh toán) · **Chuyển nhượng & cho thuê** · Dòng tiền & vay vốn · Tiến độ · Hình ảnh · Hỏi đáp.
   - Bảng nhập mỗi dòng một hàng, các cột cách nhau bằng dấu `|` (có ví dụ mờ sẵn trong ô).
   - Dự án CĐT đã bán hết: tick **"Chủ đầu tư đã bán hết"** → trang dự án đưa mục **Chuyển nhượng & cho thuê** lên đầu.
3. Tick **Dự án HOT** để lên banner trang chủ.
4. Bấm **Cập nhật**.

> Dữ liệu 30 dự án lấy từ nguồn công khai (lưu ở từng dự án). Giá để trống → hiện "Liên hệ". Hãy kiểm tra lại với chủ đầu tư trước khi tư vấn.

## Bước 10. Đăng tin mua bán / cho thuê

**Nhà đất → Thêm mới**: tiêu đề, mô tả, ảnh đại diện + tab **Thông tin cơ bản** (Bán / Cho thuê, giá theo **triệu**: 3200 = 3,2 tỷ; cho thuê 15 = 15 triệu/tháng), chọn **Thuộc dự án** (tin sẽ hiện trong trang dự án), cột phải chọn **Khu vực** và **Loại nhà đất** → **Đăng**.

## Bước 11. Viết tin tức

**Bài viết → Viết bài mới**: tiêu đề, nội dung (dùng Tiêu đề H2/H3 để tự tạo mục lục), **Ảnh đại diện**, **Chuyên mục**, ô **Tóm tắt** (2 câu – dùng làm mô tả trên Google), khung **Dự án liên quan** (bài hiện trong trang dự án) → **Đăng**.

---

## Bước 12. Plugin SEO và plugin nên cài

Website **đã có sẵn SEO**: tiêu đề, mô tả, Open Graph (Facebook/Zalo), schema dự án – tin nhà đất – hỏi đáp, sitemap, robots.txt, `/llms.txt` cho ChatGPT. Cài thêm plugin SEO để có bảng điều khiển, chấm điểm bài viết và kết nối Google – giao diện **tự nhận ra plugin và tắt phần trùng**.

**Plugin → Cài mới → gõ tên → Cài đặt → Kích hoạt:**

| Plugin | Để làm gì | Ghi chú |
|---|---|---|
| **Rank Math SEO** *(khuyên dùng)* | Chấm điểm SEO từng bài, sitemap, kết nối Google Search Console, chuyển hướng 301 | **Chỉ cài 1 plugin SEO**: Rank Math **hoặc** Yoast SEO, không cài cả hai |
| **Site Kit by Google** | Xem Search Console, Analytics, PageSpeed ngay trong quản trị | Đăng nhập bằng Gmail |
| **LiteSpeed Cache** (hosting LiteSpeed) hoặc **WP Super Cache** | Tăng tốc tải trang – Google ưu tiên web nhanh | Hỏi hosting đang dùng LiteSpeed hay không |
| **Converter for Media** | Đổi ảnh sang WebP, nhẹ hơn 30–50% | |
| **UpdraftPlus** | Sao lưu tự động lên Google Drive | Đặt lịch hằng tuần |
| **Wordfence Security** hoặc **Limit Login Attempts Reloaded** | Chống dò mật khẩu | |
| **WP Mail SMTP** | Đảm bảo email báo khách mới gửi tới Gmail | Chỉ cần nếu không nhận được email |

**Không cần cài:** Elementor / trình dựng trang, plugin form liên hệ, plugin schema riêng – giao diện đã có.

### Cấu hình Rank Math (làm 1 lần)

1. Kích hoạt xong, trình hướng dẫn mở ra → chọn **Easy** → **Start Wizard**.
2. **Your Site:** loại website chọn **Personal Blog** hoặc **Small Business Site**; tên `Hoàng Hiệp`; tải logo/avatar.
3. **Search Console:** bấm kết nối bằng Gmail (hoặc bỏ qua, làm ở Bước 13).
4. **Sitemap:** bật; tick **Bài viết, Trang, Dự án, Nhà đất**.
5. **Optimization:** để mặc định → **Finish**.
6. **Quan trọng – tránh trùng schema:** **Rank Math SEO → Tiêu đề & Meta**:
   - **Dự án** → *Loại Schema* chọn **Không có (None)** → Lưu.
   - **Nhà đất** → *Loại Schema* chọn **Không có (None)** → Lưu.
   - (Bài viết giữ *Article* như mặc định.)
7. Tiêu đề mẫu cho Dự án / Nhà đất: `%title% %sep% %sitename%`.

> Dùng Yoast SEO thay Rank Math: cài và chạy trình hướng dẫn của Yoast là đủ – giao diện tự tắt thẻ meta, Open Graph trùng và chỉ giữ schema dự án / tin nhà đất / hỏi đáp.

## Bước 13. Khai báo với Google, Bing và ChatGPT

1. **Google Search Console** (search.google.com/search-console) → *Thêm thuộc tính* → **Miền** `hiephoangmt.com` → làm theo hướng dẫn thêm bản ghi TXT ở trang quản lý tên miền → *Xác minh*.
2. Search Console → **Sơ đồ trang web** → gửi:
   - Có Rank Math / Yoast: `sitemap_index.xml` **và** `nhadat-sitemap.xml`
   - Không cài plugin SEO: `wp-sitemap.xml`
3. **Bing Webmaster Tools** (bing.com/webmasters) → *Nhập từ Google Search Console* (1 nút). Bing là nguồn tìm kiếm của ChatGPT, Copilot.
4. **Google Business Profile** (business.google.com) → tạo hồ sơ *Hoàng Hiệp – Chuyên gia bất động sản Đà Nẵng*, danh mục *Đại lý bất động sản*, số điện thoại, website → xác minh. Giúp hiện trên Google Maps và tìm kiếm "môi giới bất động sản Đà Nẵng".
5. Kiểm tra:
   - `https://hiephoangmt.com/robots.txt` và `https://hiephoangmt.com/llms.txt` mở được.
   - **search.google.com/test/rich-results** → dán link 1 trang dự án → thấy *Câu hỏi thường gặp*, *Sản phẩm*.
   - **pagespeed.web.dev** → điểm di động ≥ 70 (bật cache + WebP nếu thấp).

## Bước 14. Thói quen để lên top Google

- Mỗi tuần 1–2 bài tin tức **viết riêng** (không sao chép), tiêu đề có tên dự án / khu vực, gắn **Dự án liên quan**.
- Mỗi dự án: đủ ảnh thật, bảng giá, tiến độ cập nhật hằng tháng (Google ưu tiên trang mới cập nhật).
- Tên ảnh trước khi tải lên đặt không dấu, có nghĩa: `sun-symphony-phoi-canh.jpg`.
- Chia sẻ link dự án/bài viết lên Facebook, Zalo, nhóm BĐS Đà Nẵng.

---

## Cập nhật bản mới sau này

Khi có file zip mới: **Plugin → Cài mới → Tải plugin lên** → chọn `hoang-hiep-crm.zip` → WordPress hỏi *"Thay thế bản hiện tại bằng bản tải lên"* → đồng ý. Giao diện làm tương tự ở **Giao diện → Thêm mới → Tải giao diện lên**. Dữ liệu dự án, tin đăng, bài viết **không bị mất**. Sau đó vào **Dự án → Nhập dữ liệu Đà Nẵng** bấm nhập để bổ sung dữ liệu mới (không ghi đè ô đã sửa).

## Xử lý sự cố

| Hiện tượng | Cách xử lý |
|---|---|
| Trang dự án / tin đăng báo **404** | **Cài đặt → Đường dẫn tĩnh → Lưu thay đổi** |
| Website hiện "đang được cài đặt" | Kích hoạt plugin **Hoàng Hiệp CRM** (Bước 5) |
| Báo "vượt quá kích thước tải lên" | Nhờ hosting tăng `upload_max_filesize` lên 64M (2 file zip chỉ khoảng 0,5 MB) |
| Không nhận email khi khách để lại số | Cài **WP Mail SMTP**, đăng nhập Gmail; khách vẫn được lưu ở menu **Khách hàng** |
| Lỗi trắng trang sau khi cài plugin khác | cPanel → File Manager → `wp-content/plugins` → đổi tên thư mục plugin vừa cài |
| Menu không đổi khi sửa | **Giao diện → Menu** → chọn *Menu chính* → sửa → Lưu |

## Cách khác: tự quản VPS bằng Docker

Nếu dùng VPS riêng (không phải hosting cPanel), xem mục **Triển khai** trong `README.md`: `docker compose up -d` rồi `./scripts/setup.sh` – tự cài WordPress, SSL, giao diện, plugin và dữ liệu.
