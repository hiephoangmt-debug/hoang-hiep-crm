# Hướng dẫn đưa live chat + landing Casamia Balanca lên Render

Sau khi làm xong, bạn có:

| Địa chỉ | Dùng để |
|---|---|
| `https://<tên-dịch-vụ>.onrender.com/landing.html` | Landing page chạy ads, có chat tự động và form gửi lead |
| `https://<tên-dịch-vụ>.onrender.com/agent.html` | Trang tư vấn viên: xem và trả lời khách, xuất lead CSV |
| Telegram | Báo khách mới, khách để lại số; trả lời khách ngay trong Telegram |

Thời gian khoảng 15–20 phút. Chi phí khoảng **7,25 USD/tháng**: gói Starter 7 USD và ổ đĩa 1 GB 0,25 USD.

---

## Bước 0 – Chuẩn bị

1. **Mật khẩu trang tư vấn viên**: tự đặt, nên dài trên 10 ký tự.
2. **Bot Telegram**: xem mục "Thông báo & trả lời qua Telegram" trong `README.md`. Lấy **token** từ @BotFather. Chat ID có thể lấy sau, ở bước 5.
3. **Thẻ Visa/Mastercard** để thanh toán Render.

## Bước 1 – Gộp code vào nhánh `main`

Mở pull request trên GitHub (`hiephoangmt-debug/hoang-hiep-crm`, pull request #1) → bấm **Merge pull request** → **Confirm merge**.
Render sẽ lấy code từ nhánh `main`. Từ đây, mỗi lần sửa code trên `main`, Render tự cập nhật.

## Bước 2 – Tạo tài khoản Render

1. Vào **render.com** → **Get Started** → chọn **GitHub** để đăng nhập.
2. Cho phép Render truy cập repo **hoang-hiep-crm**: chọn *Only select repositories* rồi chọn repo này.

## Bước 3 – Tạo dịch vụ từ Blueprint

Repo đã có sẵn file `render.yaml`, Render đọc file này và tự điền gần hết cấu hình.

1. Trong Render bấm **New +** → **Blueprint**.
2. Chọn repo **hoang-hiep-crm**, nhánh **main**.
3. Render hiện dịch vụ **casamia-livechat** (Node, Singapore, gói Starter, ổ đĩa 1 GB). Điền các biến được hỏi:
   - `AGENT_PASSWORD`: mật khẩu ở bước 0.
   - `TELEGRAM_BOT_TOKEN`: token bot (có thể để trống, thêm sau).
   - `TELEGRAM_CHAT_ID`: để trống, lấy ở bước 5.
   - `PUBLIC_URL`: để trống, điền ở bước 4.
4. Bấm **Apply**, thêm thẻ thanh toán nếu Render yêu cầu.
5. Đợi 3–5 phút, đến khi trạng thái chuyển sang **Live** (màu xanh).

> `HOTLINE`, `ZALO` (0904 567 009), `DATA_DIR` đã điền sẵn. Muốn đổi thì vào **Environment**.

## Bước 4 – Điền địa chỉ trang

1. Ở đầu trang dịch vụ, Render hiện địa chỉ dạng `https://casamia-livechat.onrender.com` (có thể thêm vài ký tự). Copy địa chỉ này.
2. Vào **Environment** → sửa `PUBLIC_URL` = địa chỉ vừa copy (không có dấu `/` ở cuối) → **Save Changes**. Render tự khởi động lại.

## Bước 5 – Kết nối Telegram

1. Mở bot của bạn trên Telegram, bấm **Start** và gửi tin bất kỳ. Bot trả lời *"Chat ID của bạn là: 5xxxxxxx"*.
2. Render → **Environment** → điền `TELEGRAM_CHAT_ID` = số đó → **Save Changes**.
3. Gửi `/start` cho bot. Thấy *"✅ Đã kết nối live chat Casamia Balanca"* là xong.

Muốn cả nhóm sale cùng nhận: xem hướng dẫn nhóm trong `README.md`, rồi dùng chat ID của nhóm (số âm).

### Bật chat AI thông minh (tuỳ chọn)

Render → **Environment** → thêm `ANTHROPIC_API_KEY` = khoá `sk-ant-...` (lấy ở console.anthropic.com) → **Save Changes**.

Khi chưa có tư vấn viên trực tuyến, câu khách tự gõ sẽ được AI trả lời. Có tư vấn viên đăng nhập thì để người trả lời. Log khởi động hiện *"Chat AI: BẬT"*.

Mặc định giới hạn 400 câu/ngày, đổi bằng `AI_DAILY_LIMIT`. Chi tiết cách AI hoạt động, chi phí và cách sửa kiến thức: xem **Bước 7** trong `HUONG-DAN-GOOGLE.md`.

## Bước 6 – Kiểm tra

1. `https://…onrender.com/healthz` → hiện chữ **ok**.
2. `https://…onrender.com/landing.html` → trang hiện ảnh, số liệu và bản đồ. Kiểm tra **ghim bản đồ đúng vị trí dự án**.
3. Mở trang trên điện thoại, nhắn thử trong chat và để lại số điện thoại.
   - Telegram báo **🔥 CÓ SỐ ĐIỆN THOẠI KHÁCH**.
   - Reply tin đó trên Telegram, khách thấy câu trả lời trong chat.
4. `https://…onrender.com/agent.html` → đăng nhập bằng mật khẩu, thấy hội thoại vừa thử.

## Bước 7 – Chạy ads

- **Link quảng cáo**: `https://…onrender.com/landing.html?utm_source=facebook&utm_campaign=casamia-dongtien&utm_content=thue60`. Đổi `utm_content` theo từng mẫu, xem `ads/NOI-DUNG-QUANG-CAO.md`.
- **Facebook Pixel**: dán mã Pixel vào `<head>` của `livechat/public/landing.html` (có ghi chú vị trí), lưu trên GitHub, Render tự cập nhật. Trang tự gửi sự kiện `Lead` khi khách gửi form và `Contact` khi khách bấm Gọi/Zalo.
- **Nhúng chat vào trang khác** (LadiPage, website): dán dòng sau vào phần HTML/Javascript của trang:
  `<script src="https://…onrender.com/widget.js" async></script>`

## Tên miền riêng (tuỳ chọn, ví dụ `casamia.tenmien.vn`)

1. Render → dịch vụ → **Settings** → **Custom Domains** → **Add** → nhập tên miền.
2. Vào nơi bạn mua tên miền (Mắt Bão, PA, Tenten, Cloudflare…), tạo bản ghi **CNAME** đúng như Render hướng dẫn.
3. Đợi vài phút đến vài giờ, Render tự cấp HTTPS. Sau đó đổi `PUBLIC_URL` sang tên miền mới.

## Cập nhật nội dung sau này

Sửa file trên GitHub (nhánh `main`), Render tự cập nhật trong 2–3 phút:

- **Chính sách, giá**: `livechat/public/landing.html`, phần `POLICIES`, `PRICE_FROM` ở cuối file.
- **Kịch bản chat**: `livechat/config.js`.
- **Ảnh**: thư mục `livechat/public/img/`.

## Phương án miễn phí (chỉ nên dùng để thử)

Trong bước 3, đổi gói sang **Free** và xoá phần ổ đĩa (Disk). Hạn chế:

- Server **ngủ sau 15 phút** không có ai vào; khách đầu tiên phải chờ khoảng **1 phút**. Lúc server ngủ, Telegram không nhận được tin trả lời của bạn.
- **Không lưu được dữ liệu**: hội thoại và lead trên trang tư vấn viên mất mỗi lần server khởi động lại. Thông báo Telegram đã gửi thì vẫn còn trong Telegram.

Khi chạy ads thật, nên dùng gói Starter để không mất khách.

## Lỗi thường gặp

| Hiện tượng | Cách xử lý |
|---|---|
| Build lỗi "Cannot find package.json" | Kiểm tra **Root Directory** là `livechat` (Settings → Build & Deploy) |
| Không đăng nhập được trang tư vấn viên | Kiểm tra `AGENT_PASSWORD` trong Environment, lưu lại rồi thử lại |
| Telegram không báo | Kiểm tra `TELEGRAM_BOT_TOKEN` và `TELEGRAM_CHAT_ID`; xem tab **Logs** có dòng "Telegram: bật" chưa |
| Bot không đọc được tin Reply trong nhóm | @BotFather → `/mybots` → Bot Settings → Group Privacy → **Turn off** |
| Mất hội thoại sau khi cập nhật | Kiểm tra dịch vụ đã gắn **Disk** và `DATA_DIR=/var/data` |
| Chat trên trang khác không kết nối | Nếu đã đặt `ALLOWED_ORIGINS`, thêm tên miền trang đó vào |
