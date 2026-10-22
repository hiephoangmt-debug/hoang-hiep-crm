# Bot chia khách cho sale (Telegram + Google Sheet)

Chạy miễn phí trên Google Apps Script, không cần máy chủ. Dành cho đội khoảng 10 sale.

## Bot làm gì

1. **Khách mới**: mỗi phút bot xem Sheet "CRM Hoàng Hiệp". Khách mới từ web được giao cho **1 sale**, ưu tiên người đang giữ ít khách nhất.
   - Tin nhắn chỉ hiện số đã che (ví dụ `0905 ••• 456`) và nút **✅ Nhận khách**.
2. **Không bấm Nhận trong 30 phút** → thu hồi, giao cho bạn khác.
3. **Bấm Nhận** → sale mới thấy số đầy đủ, kèm nút Zalo và 6 nút báo cáo:
   Đã gọi · Không nghe máy · Hẹn gặp · Khách nóng · Đã chốt · Không tiềm năng.
4. **Nhận rồi mà 2 giờ không bấm báo cáo** → thu hồi, giao bạn khác.
5. **3 ngày chưa chuyển đổi** → thu hồi, giao bạn khác.
   - Cần thêm thời gian: trước giờ hạn, gõ `/giahan K4` hoặc bấm nút **⏳ Xin gia hạn 1 ngày** trong tin nhắc. Mỗi khách được 1 lần, bot tự duyệt và báo quản lý. Không xin thì hết hạn tự chuyển.
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
5. **Đóng khách phải có lý do**: bấm "Không tiềm năng" → sale gõ 1 dòng lý do → quản lý bấm Đồng ý đóng hoặc Chia lại. 2 giờ không gõ lý do thì thu hồi.
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

**Bước 1 – Tạo bot Telegram mới**
1. Mở Telegram, tìm **@BotFather**, bấm Start, gõ `/newbot`.
2. Đặt tên hiển thị, ví dụ `Chia khách Sun Saphia`.
3. Đặt tên đăng nhập, phải kết thúc bằng `bot`, ví dụ `chiakhach_saphia_bot`.
4. BotFather trả về một mã dạng `1234567890:AAH...xyz`. Copy mã này, giữ kín, không gửi ai.

Dùng bot mới, đừng dùng lại bot báo khách đang có.

**Bước 2 – Quản lý nhắn cho bot**
1. Người làm quản lý mở bot vừa tạo (bấm link `t.me/tên_bot` BotFather gửi).
2. Bấm **Start** và nhắn 1 tin bất kỳ, ví dụ `chào`.

Người nhắn tin này sẽ là quản lý.

**Bước 3 – Tạo Sheet và dán mã**
1. Mở Google Sheets bằng **đúng tài khoản Google đang giữ Sheet "CRM Hoàng Hiệp"**. Tạo bảng tính mới, đặt tên `Chia khách`.
2. Menu **Tiện ích mở rộng → Apps Script**. Xoá hết chữ có sẵn trong ô soạn.
3. Mở tệp `ChiaKhach.gs`, chọn tất cả, copy, dán vào ô soạn.
4. Tìm 2 dòng gần đầu tệp, thay phần chữ giữa 2 dấu nháy `'...'`:
   - `var BOT_TOKEN_DAN_VAO_DAY = '...'` → dán mã bot ở Bước 1.
   - `var LINK_SHEET_CRM_DAN_VAO_DAY = '...'` → dán link Sheet "CRM Hoàng Hiệp" (copy từ thanh địa chỉ trình duyệt).
5. Bấm biểu tượng 💾 **Lưu**.

**Bước 4 – Chạy cài đặt**
1. Ở thanh trên, ô chọn hàm, chọn **caiDat**, rồi bấm **▶ Chạy**.
2. Google hỏi quyền:
   - bấm **Xem xét quyền**, chọn tài khoản của anh;
   - nếu hiện "Google chưa xác minh ứng dụng này", bấm **Nâng cao → Đi tới … (không an toàn)**;
   - bấm **Cho phép**.

   Đây là mã của chính anh nên an toàn.
3. Xong khi quản lý nhận tin **"✅ Bot chia khách đã chạy"**.
   - Từ giờ bot tự chạy mỗi phút, không cần mở máy.
   - Khách đang có sẵn trong CRM không bị chia lại; chỉ khách mới từ lúc này mới được chia.

Nếu báo lỗi, đọc dòng đỏ:
- "Mã bot chưa đúng" → copy lại mã ở Bước 1.
- "Quản lý mở bot… nhắn 1 tin" → làm lại Bước 2.
- "Không mở được Sheet CRM" → kiểm tra link, và dùng đúng tài khoản Google đang giữ Sheet CRM.

**Bước 5 – Mời sale vào đội**
1. Gửi cho từng sale link bot (`t.me/tên_bot`).
2. Sale bấm Start, gõ `/dangky Tên`, ví dụ `/dangky Lan`.
3. Quản lý nhận tin có nút **✅ Duyệt**, bấm là xong.

**Bước 6 – Thử**
1. Trong Apps Script, chọn hàm **themKhachThu**, bấm **▶ Chạy**.
2. Một sale sẽ nhận "Khách thử" với giờ hạn. Bấm Nhận, thử 1 nút báo cáo.
3. Thử xong: mở tab **Khach**, xoá dòng khách thử.

**Lưu ý riêng tư:** nhóm Telegram đang báo khách mới (bot cũ) hiện cả số đầy đủ. Nhóm đó chỉ nên có anh và quản lý, đừng thêm sale.

## Lệnh

| Ai | Lệnh | Việc |
|---|---|---|
| Sale | `/khach` | Xem khách đang giữ |
| Sale | `/giahan K4` | Xin thêm 1 ngày cho hạn chuyển đổi (1 lần mỗi khách) |
| Sale | `/nghi` · `/lam` | Tạm dừng / bật lại nhận khách (nghỉ phép, bận) |
| Quản lý | `/them 0905123456 Tên - nhu cầu` | Thêm khách bằng tay (khách giới thiệu, Facebook, gọi hotline…), bot chia ngay. Nhiều khách: mỗi khách 1 dòng dưới chữ /them |
| Quản lý | `/themkhac 0905123456 Tên - Downtown` | Thêm khách dự án khác: chia theo vòng riêng, không tính lượt FourS/Saphia |
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
| `LOC_TRANG` | sun-saphia-residence.com/ads | Chỉ chia khách từ trang /ads. Cả tên miền: `sun-saphia-residence.com`. Để trống = mọi trang |
| `TOI_DA_CHUA_BAO_CAO` | 5 | Đang giữ từ ngần này khách chưa báo cáo thì tạm không giao thêm |
| `THU_HOI_TU_DUNG` | 3 | Bị thu hồi vì không nhận ngần này lần/ngày thì tự tạm dừng |
| `NONG_NHAC_NGAY` · `NONG_THU_HOI_NGAY` | 2 · 7 | Khách nóng: nhắc / thu hồi khi không cập nhật |
| `GIA_HAN_NGAY` · `SO_LAN_GIA_HAN` | 1 · 1 | Số ngày được cộng khi xin gia hạn / số lần được xin mỗi khách |
| `NHAC_NHAN_PHUT` · `NHAC_BAO_CAO_PHUT` · `NHAC_CHUYEN_DOI_NGAY` | 20 · 90 · 2 | Lúc gửi tin nhắc |
| `NGUON_KHAC_SHEET_ID` | (trống) | Link hoặc ID Sheet **DATA CHẠY GOOGLE**. Có giá trị thì bot chia luôn khách dự án khác |
| `NGUON_KHAC_TAB` | (trống) | Chỉ đọc các tab này, ví dụ `Dowtown, SPANA TOWER`. Trống = mọi tab dự án (bỏ TONG_HOP, UPLOAD_…, CRM_…, SAN_PHAM) |
| `TOI_DA_CHUA_BAO_CAO_KHAC` | 3 | Data telesale: số khách chưa báo cáo tối đa mỗi sale |
| `NHOM_RIENG` | fours,saphia | Khách có chữ này tính lượt FourS/Saphia; còn lại là dự án khác |

## Dán data telesale cho bot tự chia (tab NhapData)

1. Mở Sheet **Chia khách** → tab **NhapData**.
2. Dán data vào cột A–D: **Tên | SĐT | Dự án | Ghi chú**. Để trống cột E.
3. Khoảng 1 phút sau, bot tự chia. Cột E ghi kết quả: `K12 → Lê Tài 14:02`, `chờ giao`, `Trùng…` hoặc `Số không hợp lệ`.

- Sale nhận như khách thường: bấm Nhận → báo cáo → hạn 30 phút / 2 giờ / 3 ngày, thu hồi như cũ.
- Mỗi sale giữ tối đa `TOI_DA_CHUA_BAO_CAO_KHAC` (mặc định 3) khách data chưa báo cáo. Báo cáo xong 1 khách thì bot giao tiếp 1 số. Dán 200 số cũng không dồn hết một lúc.
- **Không ảnh hưởng FourS / Saphia:** data có vòng xoay riêng, giới hạn riêng. Khách FourS/Saphia vẫn chia ngay và đúng lượt như trước.

## Chia khách dự án khác (không tính lượt FourS / Saphia)

- Bot đọc dòng **mới** trong các tab dự án của Sheet DATA CHẠY GOOGLE (Downtown, Spana, Cora…). Data cũ có sẵn và tab mới thêm sau không bị đổ lại.
- Có **2 vòng xoay riêng**: FourS/Saphia và dự án khác. Sale nhận khách Downtown không bị mất lượt khách Saphia, và ngược lại.
- Tin giao ghi rõ `Quan tâm: Dự án: <tên tab>`. Hạn nhận, báo cáo, thu hồi giống khách Saphia.
- Khách gửi form nhiều lần liền chỉ tính 1 khách. Số đang có người giữ thì báo người đó, không chia trùng.
- Giới hạn "giữ 5 khách chưa báo cáo" tính chung cả 2 nhóm.
- `/them` có dòng `Trang:` là web dự án khác → tự vào nhóm dự án khác. Không ghi trang → nhóm FourS/Saphia.

## Kiểm tra

`node test-mo-phong.js` và `node test-du-an-khac.js` chạy các tình huống trên bản giả lập Google Sheet và Telegram:
- 30 phút, 2 giờ, 3 ngày, gia hạn;
- ban đêm;
- sale khác bấm nhầm khách;
- che số và xoá số khi thu hồi;
- báo cáo, chốt;
- các lệnh.
