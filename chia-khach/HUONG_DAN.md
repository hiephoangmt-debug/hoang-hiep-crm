# Hướng dẫn cài Bot chia khách (Telegram + Google Drive)

Bot làm 4 việc:

1. Nhận khách từ form LadiPage.
2. Chia lần lượt cho sale.
3. Tự thu hồi khi sale chậm.
4. Lưu toàn bộ dữ liệu lên Google Drive của anh.

## 1. Luật chia khách

| Tình huống | Bot làm gì |
|---|---|
| Khách mới vào | Giao cho sale kế tiếp trong danh sách (lần lượt). Sale nhận được tin riêng có nút **Nhận khách / Trả lại**. |
| **30 phút** không bấm Nhận | Thu hồi, xoá tin cũ, giao người kế tiếp |
| Đã nhận nhưng **2 giờ** không báo cáo | Thu hồi, giao người khác |
| **3 ngày** chưa xác nhận **Khách nóng** | Thu hồi, giao người khác |
| Qua **3 lượt** vẫn không ai giữ được | Chuyển về quản lý |
| Khách trùng SĐT trong 30 ngày | Không tạo mới, báo quản lý |

- **Khách nóng** = sale bấm 🔥 và ghi rõ nhu cầu, ít nhất 15 ký tự.
- **Thời hạn chỉ tính trong giờ làm việc**, 7:30–21:30. Ví dụ: khách vào lúc 21:20 thì hạn nhận kéo sang 7:50 sáng hôm sau.
- Mọi con số đều sửa được trong file `.env`.

## 2. Tạo bot Telegram (5 phút)

1. Mở Telegram, tìm **@BotFather** và gõ `/newbot`.
2. Đặt tên, ví dụ `Chia khách Sun Saphia`, và username, ví dụ `chiakhach_hh_bot`.
3. BotFather gửi một **token** dạng `123456:ABC...`. Giữ token bí mật.
4. Gõ `/setjoingroups`, chọn bot và chọn **Enable** để thêm bot vào nhóm được.

## 3. Chạy bot lần đầu và nhận quyền quản lý

1. Cài Python 3.9 trở lên.
2. Mở thư mục `chia-khach` và chạy `python3 bot.py`.
3. Dán token khi được hỏi.
4. Bot in ra một dòng `/quanly 123456`. Nhắn đúng câu đó cho bot, anh sẽ thành **quản lý**.
5. **Thêm sale:**
   1. Từng sale tìm bot và bấm **Start**.
   2. Anh nhận tin "xin tham gia" và bấm **Duyệt**.
   3. Thứ tự duyệt là thứ tự chia. Xem lại bằng `/sale`.
6. **Nhóm chung (không bắt buộc):** tạo nhóm Telegram, thêm bot vào, rồi gõ `/nhom` trong nhóm. Nhóm chỉ thấy tin dạng "Khách #12 (090****222) đã giao cho An" và báo cáo hằng ngày. Số đầy đủ không bao giờ hiện trong nhóm.

## 4. Lưu dữ liệu lên Google Drive

Dữ liệu được lưu ở 3 nơi trên Drive của anh:

- **Google Sheet, tab `Khach`:** mỗi khách 1 dòng, tự cập nhật mỗi phút. Gồm tên, SĐT, nhu cầu, trạng thái, người đang giữ, đã qua tay ai, báo cáo cuối và toàn bộ ghi chú.
- **Google Sheet, tab `NhatKy`:** mọi thao tác (giao, nhận, **ai bấm xem SĐT lúc nào**, báo cáo, thu hồi). Chỉ thêm dòng, không sửa.
- **Thư mục Drive `ChiaKhach_SaoLuu`:** mỗi ngày 1 file sao lưu toàn bộ dữ liệu. Giữ 30 ngày gần nhất. Nếu máy chủ hỏng, chép file mới nhất về `data/du_lieu.json` là chạy tiếp.

Cách cài:

1. Vào Google Drive và tạo **Google Sheet** mới, đặt tên `Chia khach`. **Không chia sẻ cho sale.**
2. Mở **Tiện ích mở rộng → Apps Script**. Xoá hết code mẫu, dán toàn bộ file `google_drive.gs`.
3. Sửa dòng `var SECRET = '...'` thành một chuỗi bí mật dài, ví dụ `hh-2026-xyz-8842`. Bấm **Lưu**.
4. Bấm **Triển khai → Tùy chọn triển khai mới**:
   1. Chọn loại **Ứng dụng web**.
   2. Đặt **Thực thi với tư cách: Tôi** và **Ai có quyền truy cập: Bất kỳ ai**.
   3. Bấm **Triển khai** và cho phép quyền truy cập Drive/Sheet.
5. Copy **URL ứng dụng web** (dạng `https://script.google.com/macros/s/.../exec`).
6. Mở file `.env` cạnh `bot.py` và thêm:
   ```
   SHEET_WEBHOOK_URL=https://script.google.com/macros/s/.../exec
   SHEET_SECRET=hh-2026-xyz-8842
   ```
7. Khởi động lại bot. Màn hình hiện `Lưu Google Drive: đã bật` là xong. Sau khoảng 1 phút, các tab và thư mục tự tạo.

> "Bất kỳ ai" chỉ có nghĩa là bot gọi được vào link. Người ngoài không có `SECRET` thì không ghi hay đọc được gì, vì script từ chối.

## 5. Nối form LadiPage

1. Bot cần một địa chỉ Internet có **HTTPS**. Trên VPS, dùng **Cloudflare Tunnel** (miễn phí), trỏ tên miền phụ, ví dụ `khach.sun-saphia-residence.com`, về `http://localhost:8090`.
2. Trong LadiPage, chọn **form → Cấu hình → Tích hợp → Webhook** và dán:
   ```
   https://khach.sun-saphia-residence.com/lead?key=<LEAD_KEY trong .env>
   ```
3. Bot tự nhận các trường tên, SĐT, nhu cầu, ngân sách và lời nhắn, theo tên trường phổ biến (`name`, `phone`, `sdt`, `nhu_cau`…).
4. Điền thử form. Sale đầu tiên phải nhận được tin trong vài giây.

Không có webhook thì quản lý nhập tay: `/them Tên | 0905xxxxxx | Studio`.

## 6. Chạy 24/7 trên VPS

1. Thuê VPS Ubuntu loại nhỏ nhất (khoảng 100–150 nghìn đồng/tháng).
2. Cài Python: `sudo apt update && sudo apt install -y python3`.
3. Chép thư mục `chia-khach` lên `/root/chia-khach`.
4. Chạy `python3 bot.py` **một lần** để dán token và nhận quyền quản lý. Sau đó bấm Ctrl+C.
5. Tạo file `/etc/systemd/system/chiakhach.service`:
   ```
   [Unit]
   Description=Bot chia khach
   After=network-online.target
   [Service]
   WorkingDirectory=/root/chia-khach
   ExecStart=/usr/bin/python3 /root/chia-khach/bot.py
   Restart=always
   [Install]
   WantedBy=multi-user.target
   ```
6. Bật bot bằng `sudo systemctl enable --now chiakhach`. Xem log bằng `journalctl -u chiakhach -f`.

## 7. Lệnh

**Sale:**

- `/cuatoi`: khách đang giữ và hạn chót.
- `/nghi`, `/dilam`: tạm ngưng nhận khách hoặc nhận lại.
- `/ghichu 12 nội dung`: ghi chú cho khách #12.
- Các nút báo cáo dưới mỗi khách:
  - Quan tâm
  - Không nghe máy
  - Hẹn gọi lại
  - 🔥 Khách nóng
  - Sai số
  - Không nhu cầu

**Quản lý:**

- `/baocao`: báo cáo hôm nay và 7 ngày.
- `/khach`, `/khach 12`: danh sách khách hoặc chi tiết một khách.
- `/sale`: danh sách sale và số thứ tự.
- `/them Tên | SĐT | nhu cầu`: nhập khách tay.
- `/giao 12 3`: giao khách #12 cho sale số 3.
- `/thuhoi 12`, `/dong 12`, `/mo 12`.
- `/tamdung 3`, `/bat 3`, `/xoasale 3`.
- `/xuat`: tải CSV khách và nhật ký.
- `/themquanly`: tạo mã mời thêm quản lý.
- `/nhom`: gõ trong nhóm để bot báo tin vào nhóm.

**Tự động:**

- 8:00 mỗi sáng: báo cáo ngày hôm qua.
- Thứ Hai: xếp hạng tuần (nhiều khách nóng, ít bị thu hồi xếp trên).
- Nhắc sale trước khi hết hạn báo cáo và hạn khách nóng.

## 8. Riêng tư: làm được gì, không làm được gì

**Làm được:**

- Số đầy đủ chỉ người **đang giữ** khách xem được, qua nút **Xem SĐT**. Mỗi lần bấm đều ghi nhật ký.
- Tin có số bị **chặn chuyển tiếp và lưu** (`protect_content`).
- Khi thu hồi, bot xoá tin cũ bên sale và nút Xem SĐT của họ hết tác dụng.
- Google Sheet chỉ anh mở được.

**Không chặn được hoàn toàn:**

- Telegram chỉ cho bot xoá tin **dưới 48 giờ**. Tin cũ hơn còn trong máy sale, nhưng nút trong đó đã vô hiệu.
- Sale vẫn có thể chụp màn hình bằng máy khác hoặc ghi số ra giấy. Bot không ngăn được, nhưng nhật ký cho biết ai đã xem số khách nào và lúc nào, đủ để đối chiếu khi có tranh chấp.

## 9. Lỗi thường gặp

- **Không nhận được khách từ LadiPage:**
  - Kiểm tra link webhook có đúng `key`.
  - Mở `https://khach.../lead` trên trình duyệt.
  - Xem log VPS.
- **Sheet không cập nhật:**
  - `SECRET` trong script và `SHEET_SECRET` trong `.env` phải giống nhau.
  - Mỗi lần sửa script phải **Triển khai → Quản lý triển khai → Sửa → Phiên bản mới**.
- **Sale không nhận được tin:** sale phải bấm **Start** với bot trước. Bot không được nhắn trước cho người chưa Start.
