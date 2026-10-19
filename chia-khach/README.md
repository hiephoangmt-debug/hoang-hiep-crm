# chia-khach – Bot Telegram chia khách cho đội sale

Telegram làm CRM gọn cho khoảng 10 sale: nhận khách từ form LadiPage, chia lần lượt, tự thu hồi, báo cáo tự động, lưu dữ liệu lên Google Drive.

- **Chia và thu hồi:**
  - Không bấm nhận trong 30 phút → thu hồi.
  - Nhận nhưng 2 giờ không báo cáo → thu hồi.
  - 3 ngày chưa xác nhận "khách nóng" → thu hồi.
  - Hạn chỉ tính trong giờ làm việc.
- **Riêng tư:**
  - Nhóm chỉ thấy số đã che.
  - Số đầy đủ xem qua nút "Xem SĐT" (có ghi nhật ký, chặn chuyển tiếp).
- **Google Drive** (`google_drive.gs`):
  - Tab `Khach`: mỗi khách 1 dòng, tự cập nhật.
  - Tab `NhatKy`: nhật ký thao tác.
  - Mỗi ngày 1 file sao lưu JSON trong thư mục `ChiaKhach_SaoLuu`.

Cài đặt: xem **[HUONG_DAN.md](HUONG_DAN.md)**. Chạy: `python3 bot.py` (Python 3.9+, chỉ thư viện chuẩn).
