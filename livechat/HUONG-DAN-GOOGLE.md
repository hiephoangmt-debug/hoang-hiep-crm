# Chat bot + lead qua Google (miễn phí) → báo về Telegram

Phương án **không cần thuê server**:

- **Khung chat trên landing**: bot tự trả lời ngay trên trình duyệt của khách (chào, nút hỏi nhanh, kịch bản 4 bước, tự hỏi khi khách đọc chậm, xin số, chuyển Zalo).
- **Google Apps Script** (miễn phí) nhận tin nhắn và lead, **lưu vào Google Sheet**, **báo về Telegram**.
- Bạn **Reply tin báo trong Telegram**, khách thấy câu trả lời trong khung chat sau vài giây. Gõ `/zalo` (dạng Reply) để gửi nút Chat Zalo.
- **Chat AI thông minh** (tuỳ chọn, xem Bước 7): khách tự gõ câu hỏi thì AI Claude trả lời ngay theo đúng thông tin dự án và cách nói 4 bước.

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
3. Xoá hết nội dung có sẵn, dán **toàn bộ** file `livechat/google-apps-script/Code.gs` (218 dòng).
   - Nếu báo lỗi *"SyntaxError: Unexpected end of input"* là **mã bị dán thiếu**. Dùng bản chia nhỏ trong thư mục `google-apps-script/chia-nho/`: tạo 3 file bằng nút **＋ → Tập lệnh** (đặt tên `Phan1`, `Phan2`, `Phan3`) rồi dán từng phần vào đúng file. Nhớ xoá mã cũ bị thiếu trong file `Mã.gs`.
   - Kiểm tra: dòng cuối của mỗi phần phải là dấu `}`.
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

## Bước 7 – Bật chat AI thông minh (tuỳ chọn)

Khi bật, câu khách **tự gõ** được AI (Claude của Anthropic) trả lời trong vài giây, dựa trên kiến thức dự án và chính sách mới nhất, theo đúng 4 bước: dạ ghi nhận → đưa phương án → dẫn dắt xin thông tin → chuyển Zalo. Nút hỏi nhanh vẫn dùng kịch bản soạn sẵn (tức thì).

AI được dặn:
- chỉ nói thông tin có trong `ai/kien-thuc.md`;
- **không tự bịa giá, diện tích, căn trống**: những thứ này AI xin số để gửi bảng hàng;
- không dùng chữ "cam kết lợi nhuận";
- nếu khách hỏi "em là người hay máy", AI nói thật mình là trợ lý tự động của anh Hiệp.

**1. Lấy khoá API** (trên **platform.claude.com**)
1. Đăng nhập **https://platform.claude.com/dashboard**.
2. **Nạp tiền:** menu trái **Settings → Billing** (platform.claude.com/settings/billing) → **Buy credits**.
3. **Tạo khoá:** **Settings → API keys** (platform.claude.com/settings/keys) → **Create key**, đặt tên `casamia-chat` → copy khoá (dạng `sk-ant-...`). Khoá chỉ hiện **một lần**, copy ngay.
4. **Giới hạn chi tiêu:** **Settings → Limits** → đặt mức chi tối đa mỗi tháng (ví dụ 20–50 USD) để yên tâm.
5. Theo dõi số câu và chi phí ở **Usage / Cost** trên dashboard.

**2. Dán mã AI vào Apps Script**
1. Trong Apps Script, bấm **＋ → Tập lệnh**, tạo 2 file `AI` và `KienThuc`.
2. Dán nội dung `google-apps-script/AI.gs` và `google-apps-script/KienThuc.gs` vào đúng file.
3. Dán lại `Code.gs` (hoặc `chia-nho/Phan2.gs`) bản mới, vì đã thêm phần gọi AI.

**3. Triển khai lại**

Vào **Triển khai → Quản lý các bản triển khai → ✏️ → Phiên bản: Phiên bản mới → Triển khai**. URL `/exec` giữ nguyên.

**4. Gửi khoá qua Telegram** (sau khi đã triển khai lại)

Mở chat **riêng** với bot (không gửi trong nhóm) và gửi:
```
/aikey sk-ant-...
```
Bot kiểm tra khoá, lưu vào nơi bí mật của Apps Script, **tự xoá tin chứa khoá**, rồi báo *"✅ Đã lưu khoá …abcd, chat AI đã BẬT"*.

Các lệnh khác (dùng được cả trong nhóm):
- `/ai`: xem trạng thái và số câu AI đã trả lời hôm nay.
- `/ai tat`: tắt AI, khung chat dùng kịch bản soạn sẵn.
- `/ai bat`: bật lại.

Cách khác, không qua Telegram: ⚙️ **Cài đặt dự án → Thuộc tính tập lệnh → Thêm thuộc tính** `ANTHROPIC_API_KEY` = khoá.

⚠️ Không dán khoá vào code hay gửi lên GitHub. Lộ khoá thì vào platform.claude.com → **Settings → API keys** xoá khoá đó và tạo khoá mới.

**5. Xuất lại landing**

Chạy lại lệnh ở Bước 4. Bản xuất kèm `--gas` tự bật AI; thêm `--no-ai` nếu muốn tắt.

**Chi phí và an toàn**
- Mỗi câu trả lời tốn một khoản nhỏ theo bảng giá của Anthropic. Lời dặn được lưu đệm (prompt caching) nên các câu sau rẻ hơn.
- Mã tự giới hạn **400 câu/ngày** và **25 câu/khách/ngày**. Đổi bằng `AI_DAILY_LIMIT` và `AI_PER_VISITOR` trong `AI.gs`.
- Mã bật sẵn tính năng **dự phòng phía server** (`fallbacks: "default"`): nếu mô hình chính từ chối một câu, Anthropic tự chạy lại bằng mô hình dự phòng. Nếu vẫn bị từ chối, hoặc AI lỗi, chậm quá 30 giây, chưa có khoá, hay hết hạn mức, khung chat tự quay về kịch bản soạn sẵn. Khách không bao giờ bị bỏ lơ.
- Khi bạn đã Reply khách trong Telegram, AI tự nhường cho bạn trong 10 phút.
- Telegram ghi rõ câu nào do **🧠 TRỢ LÝ AI** trả lời. Sheet `Chat` ghi người gửi là `Bot AI`.

**Sửa kiến thức cho AI** (giá, chính sách mới…)
1. Sửa file `livechat/ai/kien-thuc.md`. Cách nói chuyện nằm ở `ai/prompt.js`.
2. Chạy `npm run build-gas` để tạo lại `KienThuc.gs`.
3. Dán `KienThuc.gs` vào Apps Script và triển khai lại.

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
