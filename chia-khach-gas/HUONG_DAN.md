# Bot chia khách cho sale (Telegram + Google Sheet)

Chạy miễn phí trên Google Apps Script, không cần máy chủ. Dành cho đội khoảng 10 sale.

## Bot làm gì

1. **Khách mới**: mỗi phút bot xem Sheet "CRM Hoàng Hiệp". Khách mới từ web được giao cho **1 sale**, ưu tiên người đang giữ ít khách nhất.
   - Tin nhắn chỉ hiện số đã che (ví dụ `0905 ••• 456`) và nút **✅ Nhận khách**.
2. **Không bấm Nhận trong 30 phút** → thu hồi, giao cho bạn khác.
3. **Bấm Nhận** → sale mới thấy số đầy đủ, kèm nút Zalo và 6 nút báo cáo:
   Đã gọi · Không nghe máy · Hẹn gặp · Khách nóng · Đã chốt · Không có nhu cầu.
4. **Nhận rồi mà 2 giờ không bấm báo cáo** → thu hồi, giao bạn khác.
5. **3 ngày chưa chuyển đổi** → thu hồi, giao bạn khác.
   - "Chuyển đổi" là khi sale bấm Hẹn gặp, Khách nóng hoặc Đã chốt.
6. **Giờ tính hạn: 7h–21h.** Từ 21h đến 7h sáng hôm sau không tính.
   - Khách vào ban đêm vẫn được giao, nhưng tin gửi im lặng (không reo chuông), hạn bắt đầu tính từ 7h.
7. **Chuyển quá 4 lượt, hoặc không còn sale nào chưa từng giữ khách đó** → bot gửi khách cho quản lý, kèm nút "Chia lại".
8. **21h10 mỗi tối**: quản lý nhận báo cáo từng sale (được giao, đã nhận, đã báo cáo, bị thu hồi, chuyển đổi, đã chốt).

## Luật thêm cho chỉn chu

1. **Nhắc trước khi thu hồi**: phút 20 nhắc "còn 10 phút để nhận"; phút 90 nhắc "còn 30 phút để báo cáo"; ngày thứ 2 nhắc "còn 1 ngày để chuyển đổi". Tin nhắc trả lời ngay dưới tin khách.
2. **Khách cũ quay lại** (gửi form lần nữa) → báo đúng sale đang chăm, không chia cho người khác. Khách đã đóng thì chia lại như khách mới.
3. **Không ôm khách**: ai đang có từ 5 khách chưa nhận/chưa báo cáo thì tạm không giao thêm. Cả đội đều đầy thì khách chờ, có người báo cáo xong là tự giao.
4. **Hay bị thu hồi thì tự tạm dừng**: bị thu hồi 3 lần trong 1 ngày vì không bấm nhận → bot tạm dừng sale đó và báo quản lý (`/mo Tên` để mở lại).
5. **Đóng khách phải có lý do**: bấm "Không có nhu cầu" → sale gõ 1 dòng lý do → quản lý bấm Đồng ý đóng hoặc Chia lại. 2 giờ không gõ lý do thì thu hồi.
6. **Khách nóng không được bỏ quên**: đã Hẹn gặp / Khách nóng thì 2 ngày chưa cập nhật bị nhắc, 7 ngày im lặng thì thu hồi.
7. **Sale nghỉ việc**: quản lý gõ `/xoa Tên` → gỡ khỏi đội, thu hồi và chia lại toàn bộ khách người đó đang giữ; tin cũ bị xoá số.
8. **Xếp hạng tuần**: 8h sáng thứ Hai gửi quản lý xếp hạng 7 ngày (chốt, tỷ lệ chuyển đổi, tỷ lệ nhận đúng hạn, số lần không báo cáo). Gõ `/tuan` để xem bất cứ lúc nào.

Mọi hạn và nhắc chỉ tính trong giờ 7h–21h.

**Giờ hạn ghi rõ trên từng tin.** Ví dụ khách giao lúc 9h00:
- Tin giao: "⏱ Hạn bấm Nhận: **trước 09:30**. Sau thời gian trên sẽ bị thu hồi."
- Bấm Nhận lúc 9h21: "Báo cáo khách này để cập nhật. ⏱ Hạn báo cáo: **trước 11:21**…" kèm hạn chuyển đổi.
- Tin nhắc: "⏰ Báo cáo khách K4 để cập nhật… ⏱ Hạn báo cáo: trước 11:21. Sau thời gian trên sẽ bị thu hồi."
- Lệnh `/khach`: liệt kê từng khách đang giữ kèm giờ hạn.

## Riêng tư

- Mỗi sale chỉ nhận tin riêng với bot, không có nhóm chung nào hiện số.
- Chưa bấm Nhận thì chỉ thấy số đã che.
- **Bị thu hồi thì tin cũ tự sửa, xoá số.** Sale đó không xem lại được.
- **Sale không biết khách bị thu hồi từ ai, cũng không biết khách chuyển cho ai.** Tin giao lượt sau giống hệt khách mới (ghi "Giao lúc", không ghi người giữ trước). Chỉ quản lý thấy lịch sử chuyển.
- Tin của bot bật chế độ chống chuyển tiếp và chống lưu.
  Telegram không chặn được chụp màn hình; bot chỉ ghi lại ai đã nhận và xem số.
- Mọi thao tác (giao, nhận, báo cáo, thu hồi, duyệt sale) ghi vào tab **NhatKy**.
- Chỉ anh và quản lý được mở Sheet. Sale không cần quyền vào Sheet.
- **Lưu ý:** nhóm Telegram đang nhận thông báo khách mới (bot báo khách hiện có) hiện cả số đầy đủ. Nhóm đó chỉ nên có anh và quản lý, không thêm sale vào.

## Cài đặt (1 lần, khoảng 10 phút)

1. **Tạo bot mới**
   - Telegram → tìm `@BotFather` → gõ `/newbot` → đặt tên, ví dụ "Chia khách Sun Saphia".
   - Copy mã bot BotFather gửi.
   - Dùng bot mới, đừng dùng lại bot báo khách đang có.
2. **Quản lý nhắn cho bot**
   - Quản lý mở bot mới, bấm **Start**, nhắn 1 tin bất kỳ.
   - Người nhắn tin này sẽ thành quản lý.
3. **Tạo Sheet**
   - Tạo Google Sheet mới, đặt tên "Chia khách".
   - Vào Tiện ích mở rộng → Apps Script → xoá nội dung mẫu → dán toàn bộ tệp `ChiaKhach.gs` → Lưu.
4. **Dán mã bot**
   - Tìm dòng `var BOT_TOKEN_DAN_VAO_DAY = '…'`, dán mã bot vào giữa hai dấu `'`, rồi Lưu.
5. **Chạy cài đặt**
   - Chọn hàm `caiDat` ở thanh trên → bấm **Chạy** → cấp quyền (Nâng cao → Đi tới… → Cho phép).
   - Quản lý nhận tin "✅ Bot chia khách đã chạy" là xong.
6. **Nối với CRM**
   - Mở tab **CauHinh**, dòng `CRM_SHEET_ID`: dán ID của Sheet "CRM Hoàng Hiệp" (đoạn giữa `/d/` và `/edit` trong link Sheet).
   - Chạy lại hàm `caiDat` một lần nữa.
   - Khách đang có sẵn trong CRM sẽ không bị chia lại; chỉ khách mới từ lúc này mới được chia.
7. **Mời sale**
   - Từng sale mở bot, gõ `/dangky Tên` (ví dụ `/dangky Lan`).
   - Quản lý nhận tin có nút **✅ Duyệt** và bấm duyệt.
8. **Thử**
   - Chạy hàm `themKhachThu` để giao 1 khách giả, rồi kiểm tra bên sale.
   - Thử xong, xoá dòng khách thử trong tab **Khach**.

## Lệnh

| Ai | Lệnh | Việc |
|---|---|---|
| Sale | `/khach` | Xem khách đang giữ |
| Sale | `/nghi` · `/lam` | Tạm dừng / bật lại nhận khách (nghỉ phép, bận) |
| Quản lý | `/sale` | Danh sách đội, mỗi người đang giữ bao nhiêu khách |
| Quản lý | `/baocao` | Báo cáo hôm nay |
| Quản lý | `/tam Tên` · `/mo Tên` | Tạm dừng / mở lại chia cho một sale |
| Quản lý | `/xoa Tên` | Sale nghỉ việc: gỡ khỏi đội, chia lại khách đang giữ |
| Quản lý | `/tuan` | Xếp hạng 7 ngày qua |

## Đổi luật

Sửa ngay trong tab **CauHinh**, không cần sửa code:

| Khoá | Mặc định | Nghĩa |
|---|---|---|
| `HAN_NHAN_PHUT` | 30 | Số phút để bấm Nhận |
| `HAN_BAO_CAO_PHUT` | 120 | Số phút để báo cáo sau khi nhận |
| `HAN_CHUYEN_DOI_NGAY` | 3 | Số ngày để chuyển đổi |
| `GIO_BAT_DAU` · `GIO_KET_THUC` | 7 · 21 | Giờ tính hạn |
| `SO_LUOT_TOI_DA` | 4 | Chuyển quá số lượt này thì giao quản lý |
| `LOC_DU_AN` | trống | Ví dụ `Saphia` = chỉ chia khách Sun Saphia |
| `TOI_DA_CHUA_BAO_CAO` | 5 | Đang giữ từ ngần này khách chưa báo cáo thì tạm không giao thêm |
| `THU_HOI_TU_DUNG` | 3 | Bị thu hồi vì không nhận ngần này lần/ngày thì tự tạm dừng |
| `NONG_NHAC_NGAY` · `NONG_THU_HOI_NGAY` | 2 · 7 | Khách nóng: nhắc / thu hồi khi không cập nhật |
| `NHAC_NHAN_PHUT` · `NHAC_BAO_CAO_PHUT` · `NHAC_CHUYEN_DOI_NGAY` | 20 · 90 · 2 | Lúc gửi tin nhắc |

## Kiểm tra

`node test-mo-phong.js` chạy 49 tình huống trên bản giả lập Google Sheet và Telegram:
- 30 phút, 2 giờ, 3 ngày;
- ban đêm;
- sale khác bấm nhầm khách;
- che số và xoá số khi thu hồi;
- báo cáo, chốt;
- các lệnh.
