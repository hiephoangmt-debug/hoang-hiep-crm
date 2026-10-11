# CRM bản Google Sheets (không cần server)

File Sheet: **CRM Hoàng Hiệp** trong Google Drive. Mã nhận dữ liệu: `google/Code.gs` (Google Apps Script).

## Cài đặt (khoảng 10 phút)
1. Mở file Google Sheet **CRM Hoàng Hiệp**. Vào tab **Website**, sửa dòng ví dụ: cột A tên website, B tên miền, C mã website (chuỗi bất kỳ từ 8 ký tự, không trùng nhau; hoặc dùng menu CRM > Tạo mã website ngẫu nhiên sau bước 4).
2. Menu **Tiện ích mở rộng (Extensions) > Apps Script**. Xoá mã mặc định, dán toàn bộ nội dung `google/Code.gs`, bấm **Lưu**.
3. **Triển khai (Deploy) > Tùy chọn triển khai mới (New deployment)** > biểu tượng bánh răng > **Ứng dụng web (Web app)**:
   - Thực thi bằng tên (Execute as): **Tôi (Me)**
   - Người có quyền truy cập (Who has access): **Bất kỳ ai (Anyone)**
   - Bấm **Triển khai**, cấp quyền khi Google hỏi (Nâng cao > Đi tới ... > Cho phép). Copy **URL ứng dụng web**.
4. Tải lại trang Sheet. Menu mới **CRM > Xem mã nhúng cho các website** hiện sẵn đoạn `<script>` cho từng website. Dán vào `<head>` của landing page (LadiPage: Cài đặt > Mã tuỳ chỉnh > Head).
5. Thử: mở landing bằng điện thoại, bấm Zalo, bấm gọi, gửi form bằng số của bạn. Tab **Hoạt động** có thêm dòng, tab **Khách hàng** có khách mới, dòng **tô đỏ** và ghi "CHƯA LIÊN HỆ".

Form dựng riêng không bắt được tự động: cấu hình webhook (POST) về `URL_ỨNG_DỤNG_WEB?key=MÃ_WEBSITE`, các trường `name`, `phone`, `email`, `message`.

## Dùng hằng ngày
- **Khách hàng**: dòng đỏ là khách chưa gọi, chưa nhắn. Bấm **Mở Zalo** / **Gọi** để liên hệ, rồi tick **Đã gọi** hoặc **Đã nhắn**: dòng hết đỏ, tự ghi giờ liên hệ và chuyển trạng thái. Cột **Lượt bấm Zalo / Gọi** cho biết khách đó đã bấm gì trước khi để lại số.
- **Tổng quan**: số khách chưa liên hệ, người truy cập, lượt bấm Zalo / Gọi / Messenger, theo từng website. Đổi **Số ngày gần đây** (ô B3) để xem kỳ khác.
- **Chiến dịch** và **Chi phí**: khai báo chiến dịch với mã `utm_campaign`, gắn mã đó vào link quảng cáo (Facebook: `?utm_source=facebook&utm_medium=paid&utm_campaign=MÃ`; Google: `?utm_source=google&utm_medium=cpc&utm_campaign=MÃ`). Mỗi ngày dán chi phí vào tab Chi phí (copy từ báo cáo Facebook/Google). Tab Chiến dịch tự tính giá mỗi khách, doanh thu và ROAS. Doanh thu lấy từ cột **Giá trị chốt** của khách có trạng thái **Chốt**.

## Cập nhật mã
Sửa `Code.gs` rồi **Triển khai > Quản lý bản triển khai > biểu tượng bút > Phiên bản mới > Triển khai**. URL giữ nguyên.

## Giới hạn
- Mỗi lượt xem hoặc bấm là một lần chạy Apps Script (khoảng nửa giây đến một giây) và một dòng trong tab Hoạt động. Google giới hạn số lần chạy mỗi ngày và Sheet tối đa 10 triệu ô. Hợp với vài trăm đến vài nghìn lượt truy cập mỗi ngày. Nhiều hơn thì dùng bản server (README.md).
- Mã website nằm trong mã nhúng nên ai cũng thấy. Người xấu có thể gửi dữ liệu rác nếu biết mã; khi bị vậy hãy đổi mã ở tab Website.
- Không có nút bấm gọi tự ghi "đã gọi" như bản server: bạn tick tay.
