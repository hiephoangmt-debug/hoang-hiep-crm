# Live chat trực tiếp – Casamia Balanca

Chat thời gian thực giữa khách xem website dự án và tư vấn viên. Tông màu: xanh navy, trắng, cam.

- **Widget nhúng** (`public/widget.js`): nút chat nổi, nút Zalo và gọi hotline, câu hỏi nhanh, form để lại họ tên/SĐT khi không có tư vấn viên trực tuyến. Giao diện mobile toàn màn hình.
- **Trang tư vấn viên** (`/agent.html`): danh sách hội thoại theo thời gian thực, số tin chưa đọc, âm báo và thông báo trình duyệt, trạng thái (Mới / Đã liên hệ / Đã đóng), ghi chú khách hàng, nút gọi/Zalo, xuất lead ra CSV.
- **Tự nhận số điện thoại** trong tin nhắn của khách và lưu vào thông tin lead.
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
AGENT_PASSWORD=matkhau-cua-ban HOTLINE=09xxxxxxxx ZALO=09xxxxxxxx npm start
```

- Trang demo: http://localhost:3000/
- Trang tư vấn viên: http://localhost:3000/agent.html

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
| `ALLOWED_ORIGINS` | Domain được phép nhúng, cách nhau dấu phẩy |

Dữ liệu hội thoại lưu ở `data/conversations.json`. Khi triển khai (VPS, Render, Railway...) cần chạy HTTPS và giữ lại thư mục `data/`.
