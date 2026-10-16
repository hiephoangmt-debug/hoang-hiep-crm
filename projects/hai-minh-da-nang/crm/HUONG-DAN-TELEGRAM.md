# Báo khách Hải Minh về Telegram (qua CRM Hoàng Hiệp)

Trang /ads và trang chính đã gắn mã CRM Hoàng Hiệp. Mã này tự ghi lại:
- form có số điện thoại (form đầu trang, form cuối trang, ô chat tự động khi khách gõ số),
- lượt bấm **Gọi** và **Zalo**.

File `Tele.gs` thêm bước: mỗi khi CRM ghi nhận, gửi luôn tin về Telegram.

## Bước 1 – Tạo bot
1. Telegram → tìm **@BotFather** → gửi `/newbot` → đặt tên (vd. `HaiMinh Lead Bot`) → nhận **token**.
2. Mở bot vừa tạo → bấm **Start** → gửi `hi`.
   (Muốn báo vào nhóm: thêm bot vào nhóm và gửi 1 tin trong nhóm.)

## Bước 2 – Dán vào Apps Script của CRM
1. Mở Google Sheet CRM Hoàng Hiệp → **Tiện ích mở rộng → Apps Script**.
2. Bấm **+ → Tệp lệnh**, đặt tên `Tele`, dán toàn bộ `Tele.gs`.
3. Dán token vào `TELE_TOKEN`. Chọn hàm `layChatId` → **Chạy** → mở **Nhật ký thực thi** → chép số `chat_id` vào `TELE_CHAT_ID`.

## Bước 3 – Thêm 2 dòng vào Code.gs
Trong hàm `handleTrack_`, ngay dưới dòng có `logClick_(b, site, ch)`:
```js
  if (type === 'click') teleClick_(b, site, ch);
```
Trong hàm `handleLead_`, ngay dưới dòng `if (!phone) return { error: 'Số điện thoại không hợp lệ' };`:
```js
  teleLead_(b, site, phone);
```

## Bước 4 – Thử và triển khai
1. Chọn hàm `thuTele` → **Chạy** → Telegram nhận 2 tin mẫu.
2. **Triển khai → Quản lý bản triển khai → ✏️ Sửa → Phiên bản: Phiên bản mới → Triển khai.**
   (Giữ nguyên đường link /exec, không tạo bản triển khai mới, để mã trên trang vẫn chạy.)
3. Vào trang /ads gửi thử form tên "Test Hải Minh" → kiểm tra Sheet CRM và Telegram.
