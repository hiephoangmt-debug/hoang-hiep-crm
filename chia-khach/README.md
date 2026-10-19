# chia-khach – Bot Telegram chia khách cho đội sale (bản nháp)

Trạng thái: **bản nháp, chưa chạy thử với Telegram thật.** Hướng dẫn cài đặt chi tiết sẽ bổ sung sau.

- Nhận khách từ form LadiPage (webhook `POST /lead?key=...`) hoặc quản lý nhập tay (`/them`).
- Chia lần lượt cho từng sale; 30 phút không nhận → thu hồi; nhận mà 2 giờ không báo cáo → thu hồi;
  3 ngày chưa xác nhận "khách nóng" → thu hồi. Hạn chỉ tính trong giờ làm việc (mặc định 7:30–21:30).
- Riêng tư: nhóm chỉ thấy số đã che; số đầy đủ xem qua nút "Xem SĐT" (ghi nhật ký, chặn chuyển tiếp);
  thu hồi thì xoá tin cũ (Telegram chỉ cho xoá tin < 48 giờ).
- Báo cáo mỗi sáng, xếp hạng thứ Hai, xuất CSV (`/xuat`).

Chạy: `python3 bot.py` (Python 3.9+, chỉ thư viện chuẩn).
