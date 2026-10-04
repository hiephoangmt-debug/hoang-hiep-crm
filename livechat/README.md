# Live chat trực tiếp – Casamia Balanca

Chat thời gian thực giữa khách xem website dự án và tư vấn viên. Tông màu: xanh navy, trắng, cam.

- **Widget nhúng** (`public/widget.js`): nút chat nổi, nút Zalo và gọi hotline, câu hỏi nhanh, form để lại họ tên/SĐT khi không có tư vấn viên trực tuyến. Giao diện mobile toàn màn hình.
- **Trang tư vấn viên** (`/agent.html`): danh sách hội thoại theo thời gian thực, số tin chưa đọc, âm báo và thông báo trình duyệt, trạng thái (Mới / Đã liên hệ / Đã đóng), ghi chú khách hàng, nút gọi/Zalo, xuất lead ra CSV.
- **Tự nhận số điện thoại** trong tin nhắn của khách và lưu vào thông tin lead.
- **Thông báo Telegram**: báo khách mới / có SĐT, trả lời khách ngay trong Telegram.
- **Webhook lead** (tuỳ chọn): đẩy lead mới sang Google Sheet / LadiPage / n8n...

## Kịch bản phản hồi 4 bước

Mọi câu trả lời (tự động lẫn mẫu câu cho tư vấn viên) đi theo trình tự:

1. **Dạ ghi nhận**: xác nhận nhu cầu của khách ("Dạ em ghi nhận anh/chị đang quan tâm…").
2. **Đưa phương án**: gợi ý hướng giải quyết, các lựa chọn phù hợp.
3. **Dẫn dắt xin thông tin**: hỏi ngân sách, nhu cầu, tên và số điện thoại.
4. **Chuyển Zalo**: mời kết bạn Zalo, tin nhắn có kèm nút **Chat Zalo**.

Cách hoạt động:

- Khách bấm nút hỏi nhanh: tự trả lời bước 1 → 2 → 3, sau đó hiện form để lại SĐT.
- Khách tự gõ câu hỏi khi chưa có tư vấn viên trực tuyến: nhận diện chủ đề theo từ khoá (giá, mặt bằng, vị trí, pháp lý, tham quan, vay) và trả lời theo kịch bản.
- Khách đã để lại SĐT: cảm ơn và chuyển sang bước 4 (chuyển Zalo).
- Trang tư vấn viên có thanh mẫu câu theo từng bước: bấm vào để chèn vào ô chat (sửa được trước khi gửi). Nút **4. Chuyển Zalo** gửi ngay tin mời Zalo kèm nút bấm.

Nội dung kịch bản nằm trong `config.js` (`intents`, `cannedReplies`, `zaloTransfer`, `leadThanks`, `fallback`). Phần "phương án" đang viết chung, bạn nên bổ sung số liệu thực tế của dự án.

## Chạy

```bash
cd livechat
npm install
cp .env.example .env   # rồi mở .env điền mật khẩu, hotline, Zalo, Telegram
npm start
```

- Trang demo: http://localhost:3000/
- Trang tư vấn viên: http://localhost:3000/agent.html

## Chủ động hỏi khi khách đọc chậm

Widget theo dõi khách cuộn trang. Khách lướt nhanh thì không làm gì; khách **dừng đọc ở một mục khoảng 8 giây** (bảng giá, mặt bằng, vị trí, pháp lý, vay…) thì bot chủ động hỏi đúng mục đó. Câu hỏi hiện thành bong bóng cạnh nút chat, đồng thời Telegram báo *"👀 Khách đang đọc kỹ: Bảng giá"*.

- Nhận diện mục theo tiêu đề và nội dung (hỗ trợ `section` thường và LadiPage). Muốn chỉ định rõ thì thêm thuộc tính `data-chat-topic="bảng giá"` vào khối đó.
- Tối đa 2 lần hỏi mỗi khách, và không chen ngang khi khách hoặc tư vấn viên vừa nhắn trong 45 giây.
- Chỉnh câu hỏi và từ khoá trong `intents[].browse`, chỉnh thời gian trong `proactive` (`config.js`).

## Thông báo & trả lời qua Telegram

Khi có khách nhắn, điện thoại báo ngay qua Telegram, kể cả khi bạn không mở trang tư vấn viên:

- 🔔 **Khách mới vào chat**: kèm câu hỏi đầu tiên và trang khách đang xem.
- 💬 **Tin nhắn mới**: cùng một khách nhắn liên tục thì gộp, tối đa 1 thông báo/phút.
- 🔥 **Có số điện thoại khách**: kèm số để bấm gọi lại.
- 👀 **Khách đang đọc kỹ một mục**: kèm câu bot đã chủ động hỏi.

Mỗi thông báo kèm đoạn hội thoại gần nhất, tách từng lượt **🙋 KHÁCH / 💼 TƯ VẤN / 🤖 TƯ VẤN (tự động)**, mỗi lượt cách nhau 1 dòng.

**Trả lời khách ngay trong Telegram:** bấm giữ tin thông báo → **Reply** → gõ câu trả lời. Khách nhận được ngay trên khung chat website. Gõ `/zalo` (dạng Reply) để gửi lời mời Zalo kèm nút bấm. Khi bạn trả lời, các tin tự động còn đang chờ gửi sẽ bị huỷ để không nói chen.

### Cài đặt (khoảng 5 phút)

1. **Tạo bot:** mở Telegram, tìm **@BotFather** (có dấu tích xanh) → bấm **Start** → gõ `/newbot`.
   - Đặt tên hiển thị, ví dụ `Casamia Balanca Chat`.
   - Đặt username kết thúc bằng `bot`, ví dụ `casamia_hiep_bot`.
   - BotFather gửi lại **token** dạng `123456789:AAH...`. Giữ bí mật token này.
2. **Dán token vào file `.env`:** sao chép `.env.example` thành `.env`, điền `TELEGRAM_BOT_TOKEN=123456789:AAH...` rồi chạy lại server (`npm start`). Nếu dùng Render/Railway thì dán vào mục **Environment Variables** trên trang quản lý.
3. **Lấy chat ID:** mở bot vừa tạo, bấm **Start** và gửi tin bất kỳ. Bot trả lời *"Chat ID của bạn là: 5xxxxxxx"*.
4. **Điền chat ID vào `.env`** (`TELEGRAM_CHAT_ID=5xxxxxxx`) rồi chạy lại server. Gửi `/start` cho bot, thấy *"✅ Đã kết nối"* là xong.

**Cả nhóm sale cùng nhận:** tạo nhóm Telegram, thêm bot vào nhóm. Vào @BotFather → `/mybots` → chọn bot → **Bot Settings → Group Privacy → Turn off** (để bot đọc được tin Reply trong nhóm). Gửi một tin trong nhóm để lấy chat ID của nhóm (số âm, ví dụ `-100123...`). Nhiều người nhận riêng thì ghi các ID cách nhau dấu phẩy: `TELEGRAM_CHAT_ID=5111,5222`.

## Nhúng vào website / LadiPage

Dán vào trước `</body>` (hoặc phần HTML/Javascript của LadiPage):

```html
<script src="https://TEN-MIEN-CHAT/widget.js" async></script>
```

Mở chat từ nút bất kỳ: `onclick="CasamiaChat.open()"`.

## Cấu hình

Sửa `config.js` (lời chào, kịch bản 4 bước, mẫu câu, màu sắc) hoặc dùng biến môi trường:

| Biến | Ý nghĩa |
|---|---|
| `PORT` | Cổng chạy server (mặc định 3000) |
| `AGENT_PASSWORD` | Mật khẩu trang tư vấn viên – **bắt buộc đổi** |
| `HOTLINE`, `ZALO` | Số hotline và Zalo hiển thị trên widget |
| `LEAD_WEBHOOK_URL` | URL nhận lead (JSON POST) khi khách để lại SĐT |
| `TELEGRAM_BOT_TOKEN` | Token bot Telegram (từ @BotFather) |
| `TELEGRAM_CHAT_ID` | Chat ID nhận thông báo, cách nhau dấu phẩy |
| `PUBLIC_URL` | Địa chỉ server chat, dùng cho link "Mở hội thoại" |
| `ALLOWED_ORIGINS` | Domain được phép nhúng, cách nhau dấu phẩy |

Dữ liệu hội thoại lưu ở `data/conversations.json`. Khi triển khai (VPS, Render, Railway...) cần chạy HTTPS và giữ lại thư mục `data/`.
