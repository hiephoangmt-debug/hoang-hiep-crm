# Hoàng Hiệp CRM

CRM cá nhân quản lý khách hàng bất động sản. Dữ liệu nằm trong Google Sheet **DATA CHẠY GOOGLE**
trên Google Drive của bạn; giao diện là web app Google Apps Script (mở trên máy tính & điện thoại).

## Tính năng

- **Việc hôm nay**: danh sách việc xếp theo ưu tiên (🔴 làm ngay · 🟠 trong ngày · 🔵 cần đặt lịch · ⚪ hâm nóng),
  mỗi khách có **gợi ý hành động** + nút Gọi / Zalo / đổi trạng thái / hẹn nhanh.
- **Nhắc lịch không bỏ sót**
  - Hẹn gọi lại → tự tạo sự kiện **Google Calendar**, điện thoại báo trước 10 phút.
  - Email nhắc khi đến giờ gọi (kiểm tra mỗi 15 phút).
  - **Email 7h30 sáng**: kế hoạch & phương án trong ngày, mục *Cố vấn* (dự án/nguồn hiệu quả, cảnh báo khách để quá 24h).
  - **Email 20h30 tối**: tổng kết, việc còn tồn.
- **Khách hàng**: tìm theo tên/SĐT/ghi chú, lọc dự án/trạng thái/thời gian/lịch gọi, lịch sử chăm sóc, xuất CSV.
- **Tổng quan**: khách theo ngày, theo dự án, trạng thái, nguồn, tỷ lệ chuyển đổi theo nguồn.
- **Khách từ website** (fpt-city.com…) vào CRM ngay, báo email; trùng SĐT + dự án thì gộp và tăng "số lần đăng ký".
  Vẫn ghi vào tab dự án theo định dạng cũ để các tab TONG_HOP / UPLOAD_* không bị ảnh hưởng.
- **Nhập data cũ**: gom khách ở các tab CORA TOWER, peninsula, FPT PLAZA 4… vào CRM (trạng thái "Data cũ"),
  giữ ghi chú/tên sale cũ, chạy lại không trùng, **không sửa tab cũ**.

## Cài đặt (khoảng 10 phút)

1. Mở <https://script.google.com> → **Dự án mới**, đặt tên "Hoang Hiep CRM".
2. Tạo các file và dán nội dung tương ứng:
   - `Code.gs` ← [`Code.gs`](Code.gs)
   - **+ › HTML** tên `Index` ← [`Index.html`](Index.html)
   - Cài đặt dự án (⚙) → bật *Hiển thị tệp kê khai "appsscript.json"* → dán [`appsscript.json`](appsscript.json)
3. Chọn hàm **`setupCRM`** → **Chạy** → cấp quyền (Sheet, Gmail, Calendar, trigger).
   Mở **Nhật ký thực thi** để lấy **mật khẩu đăng nhập**. Hàm này cũng cài lịch gửi email 7h30/20h30 và nhắc mỗi 15 phút.
4. (Tuỳ chọn) chạy **`importLegacyData`** để đưa data cũ vào CRM.
5. **Triển khai › Tùy chọn triển khai mới › Ứng dụng web**:
   *Thực thi với tư cách*: **Tôi** · *Người có quyền truy cập*: **Bất kỳ ai** → Triển khai.
6. Copy URL `/exec`:
   - Mở URL đó để vào CRM (lưu ra màn hình điện thoại cho tiện) → đăng nhập → **Đổi mật khẩu**.
   - Dán URL vào `CONFIG.leadEndpoint` trong `website/public/assets/js/main.js` để form web đổ khách về CRM.

> "Bất kỳ ai" là bắt buộc để form website gửi được khách vào; giao diện CRM vẫn được khoá bằng mật khẩu
> (mã hoá, chặn sau 5 lần sai). Dữ liệu chỉ nằm trong Google Sheet của bạn.

Quên mật khẩu: chạy hàm **`resetPassword`** trong Apps Script, xem mật khẩu mới ở Nhật ký thực thi.

Cập nhật code sau này: dán file mới → **Triển khai › Quản lý triển khai › ✏ › Phiên bản mới** (URL giữ nguyên).

## Tuỳ chỉnh (đầu file `Code.gs`)

| Biến | Ý nghĩa |
|---|---|
| `NOTIFY_EMAIL` | Email nhận báo cáo/nhắc (trống = email tài khoản Google cài script) |
| `REPORT_HOURS` | Giờ gửi báo cáo, mặc định `[7, 20]` (gửi lúc ~7h30, ~20h30) – chạy lại `installTriggers` sau khi đổi |
| `CALENDAR_SYNC` | Tạo sự kiện Google Calendar cho lịch hẹn |
| `STALE_DAYS` | Bao nhiêu ngày không chăm sóc thì nhắc, theo trạng thái |
| `WARMUP_PER_DAY` | Số khách data cũ gợi ý hâm nóng mỗi ngày |
| `STATUSES` | Danh sách trạng thái |

## Cấu trúc dữ liệu (tab do CRM tạo)

- `CRM_LEADS` – mỗi dòng 1 khách: ID, ngày tạo, dự án, tên, SĐT, email, nhu cầu, nguồn, chiến dịch, link, IP, form,
  trạng thái, hẹn gọi lại, ghi chú, số lần đăng ký, cập nhật lúc, ID sự kiện lịch.
- `CRM_LOG` – lịch sử chăm sóc (thời gian, lead ID, hành động, nội dung).
- Mật khẩu lưu dạng băm trong *Script Properties*, không nằm trong Sheet.

## Chat AI trên website (tuỳ chọn)

Website có nút **Chat tư vấn 24/7** (cụm nút bên phải). Mặc định chat trả lời tự động từ dữ liệu dự án
(giá → xin SĐT, mặt bằng, tra mã căn FPT Plaza 4, tiến độ, vị trí, pháp lý…) và **khách gõ SĐT trong chat → vào CRM**
(nguồn `WEB-CHAT`, nhu cầu ghi lại câu khách đã hỏi).

Muốn câu hỏi ngoài kịch bản được **AI (Claude)** trả lời:

1. Tạo khoá API tại <https://platform.claude.com> (có tính phí theo lượng dùng).
2. Apps Script › **Cài đặt dự án › Thuộc tính tập lệnh** › thêm `ANTHROPIC_API_KEY` = khoá vừa tạo.
3. **Triển khai › Quản lý triển khai › Phiên bản mới**. Website (với `chatAI: true`) tự dùng AI; bỏ khoá là tắt.

AI chỉ trả lời từ kho kiến thức website sinh ra (`/assets/chat-kb.json`), không bịa giá, luôn mời khách để lại SĐT.
Giới hạn chi phí ở đầu `Code.gs`: `CHAT_PER_SESSION` (30 tin/khách/6 giờ), `CHAT_PER_DAY` (400 tin/ngày).
Model mặc định `CHAT_MODEL = "claude-opus-5-5"`; muốn rẻ hơn có thể đổi sang `"claude-haiku-5-5"`.

## Kiểm thử

```bash
node crm/test/crm.test.mjs
```
