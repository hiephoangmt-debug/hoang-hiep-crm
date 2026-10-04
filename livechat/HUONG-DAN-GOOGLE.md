# Chat bot + lead qua Google (miễn phí) → báo về Telegram

Phương án **không cần thuê server**:

- **Khung chat trên landing**: bot tự trả lời ngay trên trình duyệt của khách (chào, nút hỏi nhanh, kịch bản 4 bước, tự hỏi khi khách đọc chậm, xin số, chuyển Zalo).
- **Google Apps Script** (miễn phí) nhận tin nhắn và lead, **lưu vào Google Sheet**, **báo về Telegram**.
- Bạn **Reply tin báo trong Telegram**, khách thấy câu trả lời trong khung chat sau vài giây. Gõ `/zalo` (dạng Reply) để gửi nút Chat Zalo.

So với Render:

| | Google (miễn phí) | Render (khoảng 7,25 USD/tháng) |
|---|---|---|
| Chi phí | 0 đ | khoảng 7,25 USD/tháng |
| Lưu lead | Google Sheet | Trang tư vấn viên + CSV |
| Báo Telegram, trả lời qua Telegram | ✅ | ✅ |
| Trang tư vấn viên `/agent.html` | ❌ (trả lời qua Telegram) | ✅ |
| Tốc độ khách nhận câu trả lời | 4–15 giây | tức thì |

Phù hợp khi mới chạy ads, lượng khách vừa phải (vài trăm khách/ngày vẫn ổn).

---

## Bước 1 – Tạo Google Sheet và dán mã

1. Vào **sheets.google.com**, tạo bảng tính mới, đặt tên `Casamia – Lead & Chat`.
2. Menu **Tiện ích mở rộng → Apps Script**.
3. Xoá hết nội dung có sẵn, dán **toàn bộ** file `livechat/google-apps-script/Code.gs`.
4. Ở đầu file, điền:
   ```js
   const TELEGRAM_BOT_TOKEN = '123456789:AAH...';   // token từ @BotFather
   const TELEGRAM_CHAT_ID = '';                      // để trống, lấy ở bước 3
   const WEB_APP_URL = '';                           // để trống, điền ở bước 2
   ```
5. Bấm 💾 **Lưu**.

## Bước 2 – Triển khai thành ứng dụng web

1. Bấm **Triển khai** (Deploy) → **Tùy chọn triển khai mới** (New deployment).
2. Bấm ⚙️ chọn loại **Ứng dụng web** (Web app).
   - **Thực thi với tư cách**: *Tôi* (email của bạn).
   - **Người có quyền truy cập**: **Bất kỳ ai** (Anyone).
3. Bấm **Triển khai** → **Cấp quyền truy cập** → chọn tài khoản Google.
   - Nếu Google hiện "Google chưa xác minh ứng dụng này": bấm **Nâng cao** → **Đi tới … (không an toàn)** → **Cho phép**. Đây là mã của chính bạn nên an toàn.
4. Copy **URL ứng dụng web** (dạng `https://script.google.com/macros/s/AKfy…/exec`).
5. Dán URL đó vào `WEB_APP_URL` ở đầu file → **Lưu**.

## Bước 3 – Kết nối Telegram

1. Ở thanh công cụ Apps Script, chọn hàm **caiDatTelegram** → bấm ▶ **Chạy**. Nhật ký hiện "✅ Xong".
2. Mở bot trên Telegram, gửi tin bất kỳ. Bot trả lời *"Chat ID của bạn là: 5xxxxxxx"*.
3. Điền số đó vào `TELEGRAM_CHAT_ID` → **Lưu**.
4. **Quan trọng:** mỗi lần sửa mã, phải **Triển khai → Quản lý các bản triển khai → ✏️ Chỉnh sửa → Phiên bản: Phiên bản mới → Triển khai**. URL giữ nguyên, nhưng không làm bước này thì thay đổi chưa có hiệu lực.
5. Gửi `/start` cho bot. Thấy *"✅ Đã kết nối chat Casamia Balanca qua Google"* là xong.

Muốn cả nhóm sale cùng nhận: thêm bot vào nhóm, tắt **Group Privacy** trong @BotFather (`/mybots` → Bot Settings → Group Privacy → Turn off), gửi tin trong nhóm để lấy chat ID của nhóm (số âm). Nhiều nơi nhận thì cách nhau dấu phẩy: `'5111,-100222'`.

## Bước 4 – Xuất landing page gắn với Google

Gửi URL `/exec` cho người hỗ trợ kỹ thuật (hoặc Claude) để xuất file, hoặc tự chạy trong thư mục `livechat`:

```bash
npm run export -- --gas https://script.google.com/macros/s/AKfy…/exec
```

Kết quả là file `livechat/dist/casamia-balanca-landing.html`: 1 file duy nhất, đã nhúng sẵn ảnh, chat bot và kết nối Google.

## Bước 5 – Đưa landing lên mạng (miễn phí)

**Cách dễ nhất: Netlify Drop**

1. Đổi tên file thành `index.html` và để riêng trong một thư mục, ví dụ `casamia`.
2. Vào **app.netlify.com/drop**, tạo tài khoản miễn phí (đăng nhập bằng Google cũng được).
3. Kéo thả thư mục `casamia` vào trang. Vài giây sau bạn có địa chỉ dạng `https://ten-ngau-nhien.netlify.app`.
4. **Site configuration → Change site name** để đổi thành tên dễ nhớ, ví dụ `casamia-balanca-hoian.netlify.app`. Tên miền riêng thêm ở **Domain management**.
5. Muốn cập nhật trang: vào **Deploys**, kéo thả thư mục mới.

Cách khác: đăng file lên hosting bạn đang có, hoặc dán vào LadiPage dạng trang HTML.

## Bước 6 – Kiểm tra

1. Mở landing trên điện thoại, nhắn trong khung chat → Telegram báo **🔔 KHÁCH MỚI VÀO CHAT**.
2. Reply tin đó trên Telegram → câu trả lời hiện trong khung chat sau vài giây.
3. Gửi form với số thử → sheet **Lead** có dòng mới, Telegram báo **🔥 CÓ SỐ ĐIỆN THOẠI KHÁCH**.

## Google Sheet có gì

| Sheet | Nội dung |
|---|---|
| **Lead** | Thời gian, họ tên, số điện thoại, nhu cầu, form nào, **nguồn quảng cáo (UTM)**, trang, mã khách |
| **Chat** | Toàn bộ tin nhắn của khách và câu trả lời của bạn |
| **TraLoi** | Hàng đợi câu trả lời gửi về khung chat (không cần sửa) |
| **Map** | Dữ liệu nội bộ để ghép tin Telegram với khách (không cần sửa) |

Dùng sheet **Lead** để lọc theo `utm_content`, xem mẫu quảng cáo nào ra nhiều số nhất.

## Lỗi thường gặp

| Hiện tượng | Cách xử lý |
|---|---|
| Không nhận thông báo Telegram | Kiểm tra token và chat ID; đã **triển khai phiên bản mới** sau khi sửa mã chưa |
| Reply trên Telegram mà khách không thấy | Chạy hàm **kiemTraTelegram**, xem nhật ký: `url` phải đúng URL `/exec`; nếu sai thì chạy lại **caiDatTelegram** |
| Form báo "Gửi chưa thành công" | Ứng dụng web phải để quyền truy cập **Bất kỳ ai** |
| Bot báo "Hãy bấm Reply…" | Phải **Reply** (vuốt hoặc giữ tin thông báo → Trả lời), không gõ tin mới |
| Muốn đổi số Zalo trong lời mời | Sửa `ZALO` trong `Code.gs`, rồi triển khai phiên bản mới |
