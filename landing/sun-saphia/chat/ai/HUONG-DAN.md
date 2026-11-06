# Bật trợ lý AI (Claude) cho chatbot Sun Saphia

Chatbot vẫn chạy như cũ cho tới khi gắn đường dẫn AI. Khi AI lỗi, chậm quá 12 giây, hết hạn mức
hoặc hết tiền, chatbot tự trả lời theo từ khóa như trước – khách không bị bỏ dở.
Xin số, gửi Telegram / CRM / email giữ nguyên.

## Bước 1 – Tạo khóa API (khoảng 3 phút)
1. Vào https://console.anthropic.com → đăng ký / đăng nhập.
2. **Billing** → nạp tiền (5–10 USD là đủ dùng lâu với Claude Haiku 5.5).
3. **API Keys** → **Create Key** → đặt tên `sun-saphia-chat` → sao chép khóa (bắt đầu bằng `sk-ant-`).
   Không gửi khóa này qua chat, Zalo hay email.
4. Nên đặt **Limits → Monthly spend limit** khoảng 20 USD để chắc chắn không bị tính quá.

## Bước 2 – Tạo Apps Script (khoảng 5 phút)
1. Vào https://script.google.com → **Dự án mới**, đặt tên `Sun Saphia AI`.
2. Xóa nội dung mẫu, dán toàn bộ tệp `claude-proxy.gs` (cùng thư mục này) → **Lưu**.
3. Bánh răng **Cài đặt dự án** → kéo xuống **Thuộc tính tập lệnh** → **Thêm thuộc tính**:
   - Thuộc tính: `ANTHROPIC_API_KEY`
   - Giá trị: dán khóa `sk-ant-...` → **Lưu**.
4. Quay lại trình soạn thảo, chọn hàm `thu` → **Chạy** → cấp quyền khi được hỏi.
   Mở **Nhật ký thực thi**: thấy `{"ok":true,"text":"Dạ ..."}` là chạy được.

## Bước 3 – Triển khai
1. **Triển khai → Tùy chọn triển khai mới** → biểu tượng bánh răng chọn **Ứng dụng web**.
2. Thực thi dưới dạng: **Tôi**. Ai có quyền truy cập: **Bất kỳ ai**.
3. **Triển khai** → sao chép **URL ứng dụng web** (dạng `https://script.google.com/macros/s/.../exec`).
4. Gửi URL đó để gắn vào chatbot (URL này không phải mật khẩu, gửi qua chat được).

## Chi phí và giới hạn
- Mô hình: Claude Haiku 5.5 (rẻ nhất của Anthropic), ước khoảng 5–7 USD cho 3.000 câu hỏi/tháng.
- Mỗi khách tối đa 30 câu AI / 6 tiếng; cả website tối đa 3.000 câu / ngày (sửa `PER_SESSION`, `PER_DAY` trong script).
- AI chỉ trả lời theo thông tin dự án đã duyệt (`kb-ai.txt`), không tự đưa giá ngoài bảng, không hứa lợi nhuận.

## Khi sửa câu trả lời của chatbot
1. Sửa `KB` trong `hhc-chat.js` (và 2 bản trong `pages/`).
2. Chạy `node kb-export.js` → commit + push `kb-ai.txt`.
3. Apps Script tự lấy bản mới sau tối đa 6 tiếng; muốn ngay thì chạy hàm `lamMoiKienThuc`.
