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

## Landing page chạy ads: biệt thự Hội An có dòng tiền

Trang `public/landing.html` (mở tại `/landing.html`) dùng tông navy – trắng – cam, chạy theo **chính sách bán hàng áp dụng từ 09/09/2026**. Thứ tự trang: **con số hấp dẫn ở đầu để gây tò mò, phần diễn giải chính sách chi tiết ở dưới**.

- **Hero**: "Chủ đầu tư **thuê lại 60 triệu/tháng**" trên nền ảnh phối cảnh. Dải số lớn có ánh sáng chạy qua lại: 60tr/tháng · đặt cọc 300tr · lãi suất 0% 24 tháng · chiết khấu tới 4 tỷ. Form nhận tài liệu ngay bên cạnh.
- **Bạn có biết? / Một ngày ở Casamia Balanca**: số liệu du lịch Hội An 2024 có nguồn, kể chuyện kết bằng tiền thuê về tài khoản.
- **Cam kết thuê** (từ 01/09/2026): biệt thự sân vườn 50tr/tháng × 5 năm (full nội thất M VILLAGE) hoặc 3 năm (thô tự hoàn thiện); biệt thự rừng dừa 60tr/tháng × 3 năm. Kèm **máy tính tiền thuê**: chọn phân khu và phương án để ra số tiền mỗi tháng, mỗi năm và tổng hợp đồng.
- **Vị trí & tiện ích, mặt bằng căn key, sản phẩm** Forestside Villa / Parkhome (ảnh phối cảnh, giá và layout làm mờ để mở khoá).
- **Chính sách chi tiết theo tab**: Forestside / Parkhome × bàn giao thô 2026 / nội thất 2027. Mỗi tab có chiết khấu, chương trình thuê lại hoặc ủy thác, ưu đãi miễn phí, **tiến độ thanh toán vay và không vay**.
- Popup CTA theo ngữ cảnh, thanh Gọi / Zalo / Nhận bảng giá trên điện thoại; form gửi về hệ thống chat và Telegram kèm nhu cầu và UTM.

- **Tiện ích "về ở & cho thuê"**: mỗi tiện ích (rừng dừa, sân hiên ven sông, Clubhouse, phố cổ, biển, CĐT vận hành) nêu rõ 🏡 giá trị khi về ở và 💰 giá trị khi cho thuê, có nút chuyển góc nhìn.
- **Nút Gọi / Zalo** ở màn hình đầu, dưới các form, trong popup, khối chính sách, đặt lịch tham quan và nút nổi trên máy tính; bấm vào được ghi nhận sự kiện `Contact` cho Pixel / Google.

**Chat tự động không cần server:** nếu trang có `window.CASAMIA_CHAT_CONFIG` (file xuất đã nhúng sẵn), khung chat tự chạy kịch bản trên trình duyệt khi không có server hoặc server lỗi: chào khách, nút hỏi nhanh, trả lời 4 bước, hỏi chủ động khi khách đọc chậm, xin số, chuyển Zalo. Ở bản xem thử, lead trong chat chỉ lưu trên máy khách; ở bản thật, lead vẫn được gửi về `/api/lead`.

**Xuất thử 1 file:** `npm run export` tạo `dist/casamia-balanca-landing-xem-thu.html`, nhúng sẵn ảnh, mở trực tiếp không cần server (form chỉ mô phỏng). `npm run export -- https://ten-mien-chat` tạo bản thật, form và khung chat gửi về server đó, dùng để đăng lên hosting hoặc LadiPage (HTML).

Dữ liệu chính sách nằm trong biến `POLICIES`, `BANK`, `PERKS` cuối file `landing.html`. Khi có chính sách mới, sửa tại đó.
Ảnh phối cảnh trong `public/img/` được cắt từ ấn phẩm chính sách bán hàng của dự án.

Trước khi chạy ads:

1. **Ảnh:** chép ảnh dự án vào `public/img/` và điền đường dẫn vào biến `IMAGES` cuối file `landing.html`.
   **Giá:** điền `PRICE_FROM` (ví dụ `'8,7 tỷ'`) để hiện ô "Giá chỉ từ" ở đầu trang. Chỉ điền giá chính thức đã xác nhận.
   **Mặt bằng:** sơ đồ hiện tại là minh hoạ; có mặt bằng chính thức thì thay vào và chỉnh vị trí các điểm 🔥 cho đúng căn key thật.
2. **Mã theo dõi:** dán mã Facebook Pixel / Google tag vào `<head>` (có ghi chú vị trí).
3. **Link quảng cáo:** gắn UTM để biết lead từ chiến dịch nào, ví dụ `https://ten-mien/landing.html?utm_source=facebook&utm_campaign=bietthu-dongtien&utm_content=video1`.

Trang không nêu giá hay tỷ suất cụ thể, và có ghi chú "không phải cam kết lợi nhuận". Khi viết quảng cáo bất động sản nên giữ nguyên tắc này để tránh bị từ chối duyệt.

### Gợi ý nội dung quảng cáo

- **Mẫu 1 – Tò mò:** "Ở Hội An, khách du lịch không thiếu – thứ thiếu là biệt thự nguyên căn đẹp để họ ở lại. 🌴 Casamia Balanca: biệt thự giữa rừng dừa Bảy Mẫu, vài phút ra phố cổ. 👉 Căn nào đang có dòng tiền tốt nhất? Nhận bảng tính miễn phí."
- **Mẫu 2 – Lợi ích kép:** "Một căn biệt thự – 2 giá trị: gia đình nghỉ dưỡng vài tuần mỗi năm, thời gian còn lại cho thuê tạo dòng tiền. Nhận bảng giá + bảng tính dòng tiền theo căn qua Zalo trong 5 phút."
- **Mẫu 3 – Khan hiếm:** "Hội An là đô thị di sản – quỹ đất biệt thự gần phố cổ và biển không nhiều. 363 sản phẩm tại Casamia Balanca, kiến trúc Võ Trọng Nghĩa. Xem căn còn trống 👉"
- **Tiêu đề ngắn:** "Biệt thự Hội An tự làm ra tiền?" · "Căn nào có dòng tiền tốt nhất?" · "Mở khoá bảng tính dòng tiền"

## Bộ ảnh quảng cáo

`ads/out/` có sẵn 5 mẫu × 2 khổ (1080×1080 bài đăng, 1080×1920 Story/Reels): thuê lại 60 triệu/tháng, chiết khấu 4 tỷ, cọc 300 triệu, bản đồ vị trí, gây tò mò 4,4 triệu khách – 363 căn. Lời quảng cáo, tiêu đề, link UTM và gợi ý tệp khách nằm trong `ads/NOI-DUNG-QUANG-CAO.md`.
Sửa mẫu trong `ads/creatives.html`, xuất lại bằng `node ads/render-ads.js` (cần Playwright + Chromium).

Landing page có thêm **bản đồ Google** và nút **Chỉ đường** ở khối Vị trí.

## Nhúng vào website / LadiPage

Dán vào trước `</body>` (hoặc phần HTML/Javascript của LadiPage):

```html
<script src="https://TEN-MIEN-CHAT/widget.js" async></script>
```

Mở chat từ nút bất kỳ: `onclick="CasamiaChat.open()"`.

Tuỳ chọn trên thẻ script: `data-contacts="off"` ẩn nút Gọi/Zalo nổi (khi trang đã có), `data-mobile-bottom="76"` đẩy nút chat lên trên thanh liên hệ cố định của trang trên điện thoại.

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

**Phương án miễn phí qua Google (không cần server):** chat bot chạy trên trình duyệt, lead và tin nhắn lưu vào Google Sheet, báo Telegram, trả lời khách bằng Reply trên Telegram. Xem [HUONG-DAN-GOOGLE.md](HUONG-DAN-GOOGLE.md) và mã `google-apps-script/Code.gs`; xuất landing bằng `npm run export -- --gas <URL /exec>`.

Dữ liệu hội thoại lưu ở `data/conversations.json` (đổi bằng biến `DATA_DIR`). **Đưa lên mạng: xem [HUONG-DAN-RENDER.md](HUONG-DAN-RENDER.md)**. Repo có sẵn `render.yaml` để tạo dịch vụ trên Render chỉ với vài cú bấm.
