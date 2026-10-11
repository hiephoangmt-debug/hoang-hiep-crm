# Hoàng Hiệp CRM

CRM quản lý khách hàng bất động sản. Khách để lại thông tin trên web (LadiPage, hiephoangmt.com, hoanggiaminh.com, Google Form…) sẽ tự đổ về đây. CRM ghi lại khách đến từ web nào và link nào, lúc mấy giờ, cần gì; nhắc khi nào phải gọi, gọi đến đâu rồi; báo khi có dự án mới hợp với khách; và gợi ý cách hỏi, cách bắt chuyện để giữ quan hệ.

## Tính năng

| | |
|---|---|
| 📥 **Gom lead tự động** | Webhook cho LadiPage, mã nhúng `tracker.js` cho website WordPress/tự code, Google Form, nhập file CSV. Tự nhận các tên trường tiếng Việt (`Họ tên`, `Số điện thoại`, `sdt`, `Nhu cầu`…). |
| 🌐 **Biết khách đến từ đâu** | Lưu tên miền, **link trang khách điền form**, trang khách vào đầu tiên, số trang đã xem, nguồn Google/Facebook (UTM, gclid, fbclid), thời gian đăng ký. |
| 🔁 **Không trùng khách** | Gộp theo số điện thoại (`+84…`, `84…`, `0…` đều nhận là một). Khách cũ đăng ký lại sẽ được đưa lên đầu danh sách gọi, kèm trang họ vừa xem. |
| 📋 **Việc hôm nay** | Lead mới cần gọi ngay (báo đỏ khi quá X phút), lịch hẹn gọi lại, khách lâu không liên lạc, sinh nhật, ngày lễ, danh sách mời dự án mới. |
| 📞 **Gọi đến đâu rồi** | Ghi từng cuộc gọi/Zalo/gặp mặt kèm kết quả. CRM **tự hẹn ngày gọi lại**: không nghe máy thì gọi lại vào khung giờ khác, khách quan tâm thì 2 ngày sau, khách lạnh thì sau 30 ngày… |
| 🏢 **Có dự án mới thì gọi ai** | Thêm dự án, CRM lọc ra khách hợp loại hình, khu vực, ngân sách và đã đồng ý nhận tin. Bấm một nút là đưa họ vào danh sách gọi mời. |
| 💬 **Gợi ý cách nói** | Hơn 30 kịch bản (cuộc gọi đầu, câu hỏi khai thác nhu cầu, nhắn khi khách không nghe, hâm nóng khách, xử lý từ chối, chăm sóc sau bán, câu bắt chuyện, chúc mừng). Tên khách, trang đăng ký, dự án được điền sẵn. Mỗi ngày đổi câu khác. Có thể bật AI để soạn riêng theo lịch sử từng khách. |
| 🔔 **Báo lead mới** | Thông báo trên trình duyệt, và qua Telegram nếu bật. |
| 📊 **Báo cáo** | Số lead theo website, theo từng link trang, theo chiến dịch quảng cáo (UTM), theo ngày, theo giờ. |
| 📱 **Dùng trên điện thoại** | Có nút Gọi và Zalo ngay trên điện thoại. |

## Chạy thử trên máy

Cần **Node.js 22.13 trở lên**. Ngoài Node ra không phải cài gì thêm vì dữ liệu được lưu bằng SQLite có sẵn trong Node.

```bash
cp .env.example .env      # sửa ADMIN_PASSWORD
npm start                 # mở http://localhost:3000
npm test                  # chạy kiểm thử
```

## Đưa lên mạng

Muốn LadiPage và website gửi được dữ liệu vào thì CRM phải có địa chỉ public (ví dụ `https://crm.hiephoangmt.com`).

**Cách 1: VPS (khuyên dùng).**
```bash
git clone <repo> && cd hoang-hiep-crm
cp .env.example .env && nano .env     # đặt ADMIN_PASSWORD, SESSION_SECRET, PUBLIC_URL
docker build -t hh-crm . && docker run -d --restart=always -p 3000:3000 -v $(pwd)/data:/app/data --env-file .env hh-crm
```
Sau đó trỏ tên miền về VPS và bật HTTPS. Có thể dùng Caddy: `crm.hiephoangmt.com { reverse_proxy localhost:3000 }`.

**Cách 2: Railway, Render, Fly.io.** Deploy thẳng từ repo bằng Dockerfile. Nhớ **gắn ổ đĩa (volume) vào `/app/data`**, nếu không thì mỗi lần deploy lại sẽ mất dữ liệu.

**Sao lưu:** toàn bộ dữ liệu nằm trong một file `data/crm.db`. Copy file này định kỳ là đủ. Ngoài ra có thể bấm *Xuất CSV* ở trang Khách hàng.

## Kết nối nguồn khách

Vào trang **Cài đặt** trong CRM. Ở đó có sẵn URL webhook và mã nhúng để sao chép.

### LadiPage
Mở landing page → **Form** → **Cấu hình dữ liệu / Tích hợp** → thêm **Webhook**, dán URL:
```
https://CRM-CUA-BAN/api/hook/lead?key=WEBHOOK_KEY
```
Muốn đặt tên nguồn riêng cho từng trang thì thêm `&source=ten-du-an` vào cuối URL. Xuất bản lại trang rồi điền thử form.

### hiephoangmt.com, hoanggiaminh.com (WordPress hoặc site tự code)
Dán đoạn mã sau trước `</body>`. Với WordPress, dùng plugin *WPCode* hoặc *Insert Headers and Footers*, chọn phần Footer:
```html
<script src="https://CRM-CUA-BAN/tracker.js" data-key="WEBHOOK_KEY" async></script>
```
Mã này tự bắt mọi form có ô số điện thoại (Contact Form 7, Elementor, Flatsome, form tự viết…) mà **form cũ vẫn chạy bình thường**. Nó ghi lại trang khách điền form, trang khách vào đầu tiên, nguồn quảng cáo và thời gian. Form gửi bằng JavaScript riêng thì gọi `HHCRM.send({ name, phone, message, project })`.

### Google Form, Zapier, Make, công cụ khác
Gửi `POST` (JSON hoặc form) hoặc `GET` có query string tới URL webhook ở trên. Trang Cài đặt có sẵn đoạn Apps Script cho Google Form.

### Dữ liệu cũ
Ở trang **Khách hàng**, bấm **Nhập CSV** và chọn file xuất từ LadiPage, Google Sheets hoặc Excel. Khách trùng số điện thoại sẽ được gộp lại.

## Tuỳ chọn

- **Telegram báo lead mới:** tạo bot qua @BotFather, lấy chat id qua @userinfobot, rồi đặt `TELEGRAM_BOT_TOKEN` và `TELEGRAM_CHAT_ID` trong `.env`.
- **Gợi ý bằng AI (Claude):** đặt `ANTHROPIC_API_KEY` trong `.env` rồi chạy `npm install`. Trang khách hàng sẽ có thêm nút "Gợi ý", soạn câu nói dựa trên trang khách đăng ký, nhu cầu, lịch sử cuộc gọi và ghi chú cá nhân của khách.

## Cách dùng hằng ngày

1. Mỗi sáng mở **Hôm nay** và gọi hết danh sách *Lead mới*, sau đó đến *Hẹn gọi lại*.
2. Gọi xong thì vào khách đó, chọn kết quả và ghi vài dòng. CRM tự hẹn lần gọi sau, bạn cũng có thể tự chọn ngày.
3. Biết thêm chuyện riêng của khách (con mấy tuổi, quê ở đâu, sở thích gì) thì ghi vào **Ghi chú cá nhân** để lần sau có chuyện hỏi thăm.
4. Khi có dự án mới: vào **Dự án**, thêm dự án, chọn khách phù hợp rồi bấm *Thêm vào danh sách gọi*.
5. Mục *Lâu không liên lạc* là những khách cần hỏi thăm. Mở khách ra sẽ có sẵn câu bắt chuyện.

## Cấu trúc mã

```
src/server.js     HTTP server + API
src/leads.js      nhận lead, nhận diện trường, chuẩn hoá SĐT, gộp khách
src/reminders.js  việc hôm nay, lịch gọi lại, lọc khách cho dự án
src/scripts.js    thư viện kịch bản, ngày lễ, mẹo
src/ai.js         gợi ý bằng Claude (tuỳ chọn)
public/           giao diện web + tracker.js
```
