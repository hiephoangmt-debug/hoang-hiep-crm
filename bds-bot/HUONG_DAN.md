# BOT TƯ VẤN BẤT ĐỘNG SẢN – HƯỚNG DẪN CHI TIẾT

**Mục lục**
1. [Bot làm được gì](#1-bot-làm-được-gì)
2. [Cài đặt lần đầu – 3 bước](#2-cài-đặt-lần-đầu--3-bước-khoảng-15-phút)
3. [Dạy bot về dự án: CSBH, bảng hàng, link, hỏi đáp](#3-dạy-bot-về-dự-án-csbh-bảng-hàng-link-hỏi-đáp)
4. [Độ nhiệt khách – biết gọi ai trước](#4-độ-nhiệt-khách--biết-gọi-ai-trước)
5. [Nuôi dưỡng khách, dẫn đi xem nhà, chốt deal](#5-nuôi-dưỡng-khách-dẫn-đi-xem-nhà-chốt-deal)
6. [Báo tin mới, chào dự án cho đúng khách](#6-báo-tin-mới-chào-dự-án-cho-đúng-khách)
7. [Kết bạn Zalo cá nhân với khách](#7-kết-bạn-zalo-cá-nhân-với-khách)
8. [Khách nhắn Zalo cá nhân: /soan, /dich](#8-khách-nhắn-zalo-cá-nhân-soan-dich)
9. [Một ngày làm việc với bot](#9-một-ngày-làm-việc-với-bot)
10. [Tất cả các lệnh](#10-tất-cả-các-lệnh)
11. [Khung chat LadiPage, Google Sheet, khách cũ](#11-khung-chat-ladipage-google-sheet-khách-cũ)
12. [Chạy 24/7 trên VPS](#12-chạy-247-trên-vps)
13. [Lỗi thường gặp & lưu ý](#13-lỗi-thường-gặp--lưu-ý)

---

## 1. Bot làm được gì

| Ai nhắn | Bot làm gì |
|---|---|
| Khách mới hỏi dự án, CSBH, giá | Tư vấn ngay 24/7, khéo và hóm hỉnh, gợi ý đúng căn còn hàng, xin SĐT, hẹn xem nhà |
| Khách cũ / khách quay lại | Chào như người quen, nhắc lại nhu cầu cũ, báo tin mới liên quan |
| Khách im lặng sau khi hỏi | Tự nhắn chăm sóc sau 1, 3, 7 ngày, mỗi lần đưa 1 thông tin mới có ích |
| Khách đã hẹn xem nhà | Nhắc lịch trước 3 giờ, hôm sau hỏi cảm nhận |
| Môi giới xin hợp tác, đồng nghiệp, tin rác | **Im lặng**, chuyển tin cho anh/chị |
| Nhóm Zalo · người trong "danh bạ riêng" | **Luôn bỏ qua** |
| Khách muốn cọc, giữ căn, đàm phán, khiếu nại | Báo khách "chuyên viên gọi ngay", bot tạm dừng 30 phút để anh/chị xử lý |

Bot gửi về Zalo của anh/chị: 🆕 khách mới · 🔥 khách nóng (kèm điểm và lý do) · 📅 lịch hẹn · ⏰ sắp tới lịch · 🤝 gợi ý kết bạn · 🙋 cần anh/chị xử lý · 💌 đã chăm sóc ai · ☀️ báo cáo buổi sáng.

Bot là **một tài khoản Zalo riêng** (Zalo Bot), khách nhắn vào đó. **Zalo cá nhân của anh/chị không bị đụng tới.**

---

## 2. Cài đặt lần đầu – 3 bước (khoảng 15 phút)

**Bước 1 – Chuẩn bị 2 thứ** (copy để sẵn vào Ghi chú điện thoại):
- **Token bot Zalo:** vào https://bot.zaloplatforms.com → đăng nhập Zalo → **Tạo bot** (đặt tên, ví dụ "Hiệp BĐS – Tư vấn dự án") → copy **token**.
- **API key Claude:** vào https://console.anthropic.com → **Billing** nạp tiền (5–10 USD dùng được lâu) → **API Keys** → **Create key** → copy (bắt đầu bằng `sk-ant-`).

**Bước 2 – Cài Python (chỉ 1 lần):** vào https://python.org → **Downloads** → tải và cài.
Máy Windows: ở màn hình cài đầu tiên **nhớ tick ô "Add python.exe to PATH"**, rồi bấm Install Now.

**Bước 3 – Chạy bot:** giải nén file zip, mở thư mục `bds-bot`, **bấm đúp**:
- Windows: `CHAY_BOT_Windows.bat`
- Mac: `CHAY_BOT_Mac.command` (lần đầu: chuột phải → Open)

Cửa sổ đen hiện ra:
1. Hỏi **token Zalo** → dán (chuột phải hoặc Ctrl+V) → Enter. Bot tự kiểm tra, báo ✔ hoặc ✘.
2. Hỏi **API key Claude** → dán → Enter.
3. Màn hình hiện `/chu 1234` (mỗi lần một mã khác) → **dùng Zalo của anh/chị nhắn đúng câu đó cho bot**.

Xong! Bot nhắn lại "🎉 Xong!" kèm danh sách lệnh.

👉 **Thử ngay:** nhờ người quen nhắn bot "cho em xin CSBH FourS Tower".

⚠️ Bot chỉ chạy khi cửa sổ đen **còn mở**. Muốn chạy 24/7 không cần bật máy → [mục 12](#12-chạy-247-trên-vps).

---

## 3. Dạy bot về dự án: CSBH, bảng hàng, link, hỏi đáp

> **Bot chỉ nói những gì anh/chị đã dạy, không tự bịa giá hay chính sách.** Dạy càng đủ, bot tư vấn càng khéo và chốt càng nhiều. Mọi thay đổi **có hiệu lực ngay**, không cần chạy lại bot.

Có 5 cách dạy bot, đều làm được ngay trên điện thoại:

### 3.1. Chụp ảnh CSBH / bảng giá gửi thẳng cho bot (nhanh nhất)
1. Chụp ảnh tài liệu **thẳng, đủ sáng, không lóa**. Một ảnh cho một trang.
2. Gửi ảnh cho bot. Muốn rõ hơn thì thêm chú thích, ví dụ "CSBH FourS tháng 11".
3. Khoảng 30 giây sau, bot gửi lại phần đã đọc được: tên dự án, thời hạn áp dụng, từng ý chính sách.
4. **Kiểm tra kỹ các con số**, rồi chọn:
   - `/luu`: lưu lại, bot dùng ngay.
   - `/huy`: bỏ.
   - Có chỗ sai: copy đoạn bot gửi, sửa lại, rồi gửi `/capnhat <nội dung đã sửa>`.

Ảnh có **nhiều căn** (bảng hàng) thì bot tự lưu thành bảng hàng (xem 3.3).

### 3.2. Gõ cập nhật nhanh: `/capnhat`
```
/capnhat FourS Tower: từ 01/11 đến 30/11 CK 3% khi thanh toán sớm 50%, HTLS 0% 18 tháng
```
- Mỗi cập nhật được **ghi kèm ngày**. Cập nhật mới hơn sẽ được ưu tiên hơn thông tin cũ.
- **Ghi rõ thời hạn** ("đến 30/11"). Qua hạn là bot tự thôi giới thiệu, còn khi sắp hết hạn bot sẽ nhắc khéo khách về hạn chót.
- `/capnhat`: xem danh sách cập nhật đang dùng, có đánh số.
- `/xoacapnhat 3`: xóa cập nhật số 3 (khi sai hoặc đã hết hạn).
- `/xemduan`: xem toàn bộ những gì bot đang biết.

Mỗi lần sửa, bot tự **sao lưu** bản cũ vào `data/sao_luu_du_an/`, nên lỡ tay vẫn lấy lại được.

### 3.3. Bảng hàng trên Google Sheet (bot luôn biết căn nào còn, căn nào đã bán)
Đây là cách hiệu quả nhất cho bảng hàng: sửa trên điện thoại, bot tự lấy bản mới **10 phút một lần**.

1. Mở Google Sheet, tạo bảng có dòng đầu là tên cột (xem mẫu trong file `bang_hang_mau.csv`):
   `du_an, ma_can, toa, tang, dien_tich, so_pn, huong, view, gia, trang_thai, ghi_chu`
2. Cột **trang_thai** ghi: `còn` / `đã bán` / `đã cọc` / `giữ chỗ`. Bot **chỉ giới thiệu căn "còn"**.
3. Bấm **Chia sẻ** → **Quyền truy cập chung** → chọn **"Bất kỳ ai có đường liên kết"** (quyền Người xem) → **Sao chép liên kết**.
4. Nhắn cho bot:
   ```
   /banghang https://docs.google.com/spreadsheets/d/....
   ```
5. Bot trả lời, ví dụ "Google Sheet 1: 45 căn" là xong. Nếu bot báo ⚠️ chưa đọc được, xem lại bước 3.

Từ giờ, có căn bán hay đổi giá thì anh/chị chỉ cần **sửa trên Sheet**.
- `/banghang`: xem bot đang dùng những bảng hàng nào.
- `/banghang xoa`: bỏ hết các link bảng hàng.
- Có nhiều dự án thì gửi `/banghang <link>` cho từng sheet. Mỗi tab trong cùng một file Sheet có link riêng (có `gid=` ở cuối).

Bot dùng bảng hàng thế nào khi tư vấn:
- Khách nói nhu cầu → bot chọn **2–3 căn hợp nhất**, kèm lý do hợp với chính khách đó.
- Khách hỏi một căn đã bán → bot nói căn đã có khách và gợi ý căn tương tự.
- Bot không gửi nguyên cả bảng hàng. Khách muốn xem đầy đủ thì bot xin SĐT để anh/chị gửi.
- Bot không tạo cảm giác khan hiếm giả.

*Cách khác:* lưu bảng hàng Excel thành **CSV UTF-8** rồi bỏ vào thư mục `bang_hang/`, cạnh file `bot.py`.

### 3.4. Gửi link dự án: `/link`
```
/link https://trangduan.vn/chinh-sach-ban-hang  CSBH chính thức
```
- Bot đọc trang web hoặc **file PDF**, tóm tắt lại để anh/chị duyệt → `/luu`.
- Link được lưu kèm, để bot gửi khách khi khách muốn xem thêm ảnh, video hoặc vị trí.
- Trang chặn bot hoặc phải đăng nhập (ví dụ Facebook): bot **chỉ lưu link**. Muốn bot hiểu nội dung thì chụp màn hình gửi bot.
- Gửi link Google Sheet thì bot tự hiểu là bảng hàng.

Các link cố định (website, video flycam, vị trí nhà mẫu) có thể điền sẵn ở mục **"Link dự án"** trong `du_an.md`.

### 3.5. Hỏi đáp mẫu (Q&A): câu trả lời chuẩn của anh/chị
Với câu khách hay hỏi, anh/chị dạy bot **một lần**, bot trả lời đúng ý mãi mãi:
```
/hoidap Vay ngân hàng được bao nhiêu? => Dạ ngân hàng hỗ trợ vay tới 70%, HTLS 0% 18 tháng, ân hạn gốc 24 tháng ạ
```
- `/hoidap`: xem danh sách. `/xoahoidap 2`: xóa câu số 2.
- **Mẹo:** mỗi lần anh/chị trả lời khách bằng `/tl`, bot gợi ý sẵn lệnh `/hoidap` với đúng câu khách hỏi và câu anh/chị vừa trả lời. Thấy là câu khách hay hỏi thì copy gửi lại cho bot là xong.

### 3.6. File `du_an.md`: thông tin nền (điền 1 lần trên máy tính)
Mở bằng Notepad, thay các chỗ `[điền ...]`: tên anh/chị, đơn vị, hotline, giờ dẫn khách, và từng dự án (vị trí, loại hình, giá, pháp lý, tiến độ, tiện ích, phù hợp với ai). Có thể dán nguyên văn CSBH vào.
Lúc chạy, bot báo còn bao nhiêu chỗ `[điền ...]` chưa điền.

**Thứ tự ưu tiên khi thông tin khác nhau:** bảng hàng (giá từng căn) → cập nhật mới nhất → thông tin nền trong `du_an.md`.

---

## 4. Độ nhiệt khách – biết gọi ai trước

Mỗi khách có **điểm độ nhiệt từ 0 đến 100**, bot tự chấm sau mỗi tin nhắn:

| Điểm | Mức | Nên làm |
|---|---|---|
| **70–100** 🔥 | Nóng | **Gọi ngay trong 15 phút** |
| **40–69** 🌤 | Ấm | Để bot nuôi dưỡng, gửi thêm tài liệu, mời xem nhà cuối tuần |
| **0–39** ❄️ | Lạnh | Để bot chăm sóc nhẹ, chào khi có dự án hoặc chính sách hợp |

**Bot cộng điểm khi khách:**
- hẹn hoặc xin đi xem nhà: +25;
- hỏi giá căn cụ thể, hỏi giữ căn hay thủ tục cọc: +20;
- hỏi thanh toán, vay, chiết khấu chi tiết: +15;
- để lại SĐT: +10;
- có ngân sách rõ: +10;
- muốn mua trong 3 tháng: +10;
- hỏi pháp lý hoặc tiến độ: +5.

**Bot trừ điểm khi khách:**
- chỉ hỏi chung chung: −15;
- chê đắt mà không cân nhắc thêm: −20;
- nói đã mua chỗ khác hoặc không có nhu cầu: −30.

Ngoài ra:
- Khách **im lặng** quá 2 ngày thì mỗi ngày bị trừ 2 điểm. Nhờ vậy danh sách luôn phản ánh đúng ai đang thật sự nóng.
- Khách **có lịch xem nhà sắp tới** thì luôn được ít nhất 80 điểm.

**Xem độ nhiệt:**
- Khi khách vượt mốc 70, bot báo ngay **🔥 KHÁCH NÓNG 82/100**, kèm *lý do* (ví dụ "hỏi giá căn A-12-05") và hồ sơ khách.
- `/nong`: danh sách khách nóng nên gọi ngay.
- `/nhiet`: xếp hạng độ nhiệt tất cả khách, từ cao xuống thấp.
- `/khach <mã>`: xem điểm, lý do, hồ sơ và tin gần nhất của một khách.
- ☀️ **Báo cáo buổi sáng** (gửi trong khoảng 8–11h): lịch hẹn hôm nay và top khách nên gọi.
- Có nối Google Sheet ([mục 11](#11-khung-chat-ladipage-google-sheet-khách-cũ)) thì cột `do_nhiet` tự cập nhật.

---

## 5. Nuôi dưỡng khách, dẫn đi xem nhà, chốt deal

### 5.1. Bot được dạy sẵn quy trình bán hàng
Mỗi tin nhắn, bot chỉ tiến **một bước**, để khách không thấy bị ép:
1. **Kết nối:** trả lời ngay điều khách hỏi, không bắt khách khai thông tin trước.
2. **Hiểu nhu cầu:** mỗi tin chỉ hỏi 1 câu, và là câu **lựa chọn** dễ trả lời ("mình mua để ở hay cho thuê ạ?").
3. **Cho giá trị trước, xin sau:** đưa một thông tin "đáng tiền" (căn hợp nhất, cách thanh toán nhẹ nhất, ưu đãi sắp hết hạn) rồi mới xin SĐT.
4. **Cam kết nhỏ dần:** xem ảnh/video căn → nhận bảng tính dòng tiền → gọi 5 phút → đi xem nhà.
5. **Mời xem nhà bằng 2 lựa chọn:** "chiều thứ 7 hay sáng Chủ nhật tiện cho anh/chị hơn ạ?"
6. **Chốt lịch rõ ràng:** ngày, giờ, địa điểm, SĐT, đi mấy người. Bot xác nhận lại với khách rồi báo 📅 về cho anh/chị.

Bot cũng biết cách xử lý các câu từ chối hay gặp:
- "Đắt quá": chia nhỏ số tiền theo tiến độ, so sánh giá/m², hoặc gợi ý căn vừa túi hơn.
- "Để suy nghĩ": hỏi nhẹ khách còn phân vân điều gì nhất, rồi gửi tài liệu để khách cân nhắc.
- "Hỏi ý vợ/chồng": mời cả nhà cùng đi xem cuối tuần.
- "Đang xem dự án khác": không chê dự án kia, chỉ nêu khác biệt thật.
- "Chờ giá xuống": chia sẻ góc nhìn trung thực, không dọa.

### 5.2. Chăm sóc tự động khách im lặng
Khách hỏi xong rồi im, bot tự nhắn lại **sau 1 ngày, 3 ngày và 7 ngày**, chỉ trong khung **8h–21h**:
- **Lần 1:** nối tiếp câu chuyện cũ, kèm 1 thông tin có ích (căn hợp, cách thanh toán nhẹ) và 1 câu hỏi dễ trả lời.
- **Lần 2:** báo một điều mới (chính sách mới, căn đẹp vừa có), hoặc gỡ đúng điều khách còn băn khoăn.
- **Lần 3:** nhẹ nhàng: "em vẫn giữ thông tin cho anh/chị, khi nào cần cứ nhắn em".

Bot **không nhắn** trong các trường hợp:
- khách đã có lịch hẹn sắp tới;
- khách nói không quan tâm, đã mua chỗ khác hoặc xin đừng nhắn;
- khách nằm trong danh bạ riêng;
- anh/chị đang nói chuyện trực tiếp với khách đó;
- khách im lặng đã hơn 45 ngày.

Khách trả lời lại thì lịch chăm sóc tính lại từ đầu. Mỗi đợt, bot báo 💌 cho anh/chị biết đã nhắn những ai.
- `/chamsoc`: xem tình hình, ai đang chờ được chăm sóc.
- `/chamsoc tat` / `/chamsoc bat`: tắt / bật (nhắc lịch hẹn vẫn chạy).
- Muốn đổi số ngày: mở `.env`, sửa `FOLLOWUP_DAYS=1,3,7`.

### 5.3. Nhắc lịch & sau khi xem nhà
- **Trước giờ hẹn 3 tiếng**, bot nhắn khách: "Dạ em nhắc anh/chị lịch xem … lúc 9:00 hôm nay ạ. Anh/chị cần em gửi định vị không ạ?". Đồng thời báo ⏰ cho anh/chị.
- **Ngày hôm sau**, bot hỏi khách cảm nhận, khách thích điểm gì, còn băn khoăn gì, rồi đề nghị gửi bảng tính cho căn khách thích. Khách chưa đi xem thì bot hỏi khéo có muốn hẹn lại không.

### 5.4. Anh/chị nên làm gì để chốt nhanh
- Có 🔥 hoặc 🙋 thì **gọi ngay**. Khách nóng để quá 1 giờ dễ nguội.
- Trước khi gọi, nhắn `/khach <mã>` để xem khách đã hỏi gì, đang băn khoăn gì (mục `ban_khoan`).
- Cập nhật **bảng hàng và CSBH** thường xuyên. Bot có thông tin mới thì mới chăm sóc khách hay được.
- Khi chính sách mới ra, dùng **`/baokhach`** ([mục 6](#6-báo-tin-mới-chào-dự-án-cho-đúng-khách)).

---

## 6. Báo tin mới, chào dự án cho đúng khách

**Có chính sách mới, giá mới, căn đẹp mới hoặc tin tiến độ: `/baokhach`**
```
/baokhach FourS Tower: từ 01/11 CK 3% khi thanh toán sớm 50%, HTLS 0% 18 tháng
```
Bot làm 3 việc:
- Quét toàn bộ khách, chấm điểm xem ai **cần biết tin này** (đã hỏi dự án này, đang lo về giá hay cách thanh toán…).
- Soạn **tin báo riêng cho từng người**, nói rõ tin mới giúp gì cho chính khách đó.
- Gửi anh/chị danh sách để duyệt.

Sau `/capnhat`, bot cũng gợi ý sẵn lệnh `/baokhach`.

**Có dự án mới: `/chaohang`**
```
/chaohang FourS Tower – đợt mở bán căn 2PN view sông
```
**Sau khi bot soạn xong** (dùng cho cả hai lệnh):
- `/xem <mã> 1`: xem tin soạn cho khách số 1.
- `/gui <mã>`: bot gửi cho khách đang chat với bot. Mỗi chiến dịch chỉ gửi 1 lần.
- Khách chỉ có SĐT: mở `data/chien_dich/<mã>.csv` bằng Excel, copy tin rồi gửi qua Zalo cá nhân.

Nên chào **đúng người, ít mà chất**. Gửi ồ ạt dễ bị khách chặn và Zalo hạn chế bot.

---

## 7. Kết bạn Zalo cá nhân với khách

Zalo không cho bot tự gửi kết bạn từ Zalo cá nhân (dùng phần mềm tự động dễ bị khóa nick). Vì vậy bot **soạn sẵn**, anh/chị bấm gửi bằng tay, mỗi khách khoảng 20 giây.

**Bot soạn lời mời:**
- **Tự động:** khách vừa để lại SĐT là bot gửi tin **🤝 Gợi ý KẾT BẠN**, gồm SĐT và **3 câu lời chào ngắn (dưới 70 ký tự)**, mỗi câu 1 tin riêng.
- **Khi cần:**
  - `/ketban <mã khách>`: bot đọc lại cuộc chat với khách đó để soạn.
  - `/ketban Chị Lan 0905xxxxxx, gọi hỏi 2PN FourS`: dùng cho khách gọi điện hoặc gặp trực tiếp.

**Gửi kết bạn trên điện thoại:**
1. Trong tin bot gửi, **nhấn giữ** câu lời chào → **Sao chép**.
2. Mở Zalo cá nhân → tab **Danh bạ** → biểu tượng **người có dấu +** ở góc trên bên phải.
3. Gõ SĐT khách → **Tìm**, kiểm tra tên và ảnh cho đúng người.
4. Bấm **Kết bạn** → **xóa hết** câu mặc định "Xin chào, mình là…" → **Dán** câu vừa sao chép.
5. Bấm **Gửi yêu cầu**.
6. Đổi tên gợi nhớ cho dễ tìm: trang cá nhân của khách → **⋯** → **Đổi tên gợi nhớ**, ví dụ `FourS – C.Lan 2PN`.
7. **Nhắn luôn 1 tin** kèm CSBH hoặc ảnh căn (bot soạn sẵn tin "💬 Khi khách đồng ý kết bạn, nhắn tiếp").

**Mẫu lời chào** (sửa chỗ [ ]):

| Tình huống | Lời chào |
|---|---|
| Khách hỏi CSBH qua bot | Em Hiệp – [đơn vị], gửi anh/chị CSBH [dự án] vừa hỏi ạ |
| Vừa gọi điện xong | Em Hiệp vừa gọi anh/chị về căn 2PN [dự án], gửi mặt bằng ạ |
| Khách để SĐT trên web | Em Hiệp, gửi anh/chị bảng giá [dự án] từ web ạ |
| Khách cũ đổi số | Em Hiệp – tư vấn căn [mã căn] cho anh/chị, kết bạn lại ạ |

- Ô lời chào vẫn bị cắt: mở `.env`, giảm `FRIEND_MAX_CHARS=70` xuống, ví dụ `50`.
- **Tránh** các câu "Kết bạn với mình nhé", "Mình là môi giới BĐS".
- Mỗi ngày đừng gửi kết bạn quá nhiều người lạ (khoảng 30 lời mời là nhiều rồi). Ưu tiên khách 🔥 trước.

---

## 8. Khách nhắn Zalo cá nhân: /soan, /dich

Khách nhắn vào Zalo cá nhân của anh/chị (bot không thấy những tin này):
- `/soan <dán tin khách>`: bot soạn 2 phương án trả lời (hóm hỉnh / chuyên nghiệp) kèm gợi ý bước tiếp theo, anh/chị copy rồi gửi khách.
- `/dich a ơi 2pn view sông tầm 3t5 có k, ck bn`: bot viết lại thành câu đầy đủ và tóm tắt khách muốn gì.

Bot hiểu sẵn các viết tắt BĐS (CSBH, PN, HĐMB, CK, HTLS, SHR, F0/F1, 3t5…) và kiểu nhắn Zalo (k, dc, bn, ntn…). Từ riêng của sàn mình thì thêm vào mục "Từ viết tắt riêng" trong `du_an.md`.

---

## 9. Một ngày làm việc với bot

| Lúc | Việc |
|---|---|
| **8h sáng** | Đọc ☀️ báo cáo buổi sáng → gọi top khách nóng → xác nhận lịch hẹn hôm nay |
| **Có CSBH / bảng giá mới** | Chụp ảnh gửi bot → kiểm tra → `/luu` → `/baokhach <tin mới>` |
| **Có căn bán / đổi giá** | Sửa ngay trên Google Sheet bảng hàng |
| **Nhận 🔥 hoặc 🙋** | `/khach <mã>` xem nhanh → gọi trong 15 phút |
| **Nhận 🤝** | Gửi kết bạn Zalo cá nhân + tin đầu tiên |
| **Khách hỏi câu bot chưa biết** | Trả lời bằng `/tl` → lưu lại bằng lệnh `/hoidap` bot gợi ý |
| **Cuối tuần** | `/nhiet` xem lại khách ấm, `/thongke` xem số liệu |

---

## 10. Tất cả các lệnh

Nhắn các lệnh này cho bot từ Zalo của anh/chị. Gõ `/hd` để bot gửi danh sách lệnh.

| Nhóm | Lệnh | Tác dụng |
|---|---|---|
| **Dạy bot** | 📸 *gửi ảnh* | Bot đọc CSBH / bảng giá / bảng hàng → `/luu` hoặc `/huy` |
| | `/capnhat <nội dung>` | Thêm CSBH, giá, tiến độ mới · `/capnhat` để xem danh sách |
| | `/xoacapnhat <số>` | Xóa cập nhật sai / hết hạn |
| | `/banghang <link Sheet>` | Dùng bảng hàng Google Sheet · `/banghang` để xem · `/banghang xoa` |
| | `/xoabanghang <tên file>` | Xóa file bảng hàng đã lưu từ ảnh |
| | `/link <link> [ghi chú]` | Bot đọc trang web / PDF → `/luu` |
| | `/hoidap <hỏi> => <đáp>` | Lưu câu trả lời chuẩn · `/hoidap` để xem · `/xoahoidap <số>` |
| | `/xemduan` | Xem tất cả thông tin bot đang biết |
| **Khách** | `/nong` · `/nhiet` | Khách nóng nên gọi · xếp hạng độ nhiệt |
| | `/khach <mã>` | Hồ sơ, độ nhiệt, tin gần nhất của khách |
| | `/tl <mã> <nội dung>` | Trả lời khách qua bot (bot nhường anh/chị 30 phút) |
| | `/tat <mã>` · `/bat <mã>` | Tắt bot với 1 khách trong 24 giờ · bật lại |
| | `/rieng <mã> [ghi chú]` · `/borieng <mã>` | Danh bạ riêng: bot luôn bỏ qua người này |
| **Chăm sóc** | `/chamsoc` · `/chamsoc tat` · `/chamsoc bat` | Chăm sóc khách im lặng |
| | `/baokhach <tin mới>` | Báo tin mới cho đúng khách |
| | `/chaohang <dự án>` | Chào dự án mới cho đúng khách |
| | `/xem <mã CD> <số>` · `/gui <mã CD>` | Xem / gửi tin của chiến dịch |
| **Zalo cá nhân** | `/ketban <mã hoặc mô tả>` | Soạn lời mời kết bạn |
| | `/soan <tin khách>` · `/dich <tin>` | Soạn câu trả lời · dịch tin viết tắt |
| **Khác** | `/thongke` · `/id` · `/hd` | Số liệu · xem chat_id · danh sách lệnh |

---

## 11. Khung chat LadiPage, Google Sheet, khách cũ

**Khung chat trên LadiPage**
1. Bot phải chạy trên máy có **địa chỉ HTTPS** (xem [mục 12](#12-chạy-247-trên-vps)).
2. Mở `.env` bằng Notepad, sửa 2 dòng: `WEB_PORT=8080` và `ALLOWED_ORIGIN=https://tenmien-ladipage-cua-ban.com`.
3. Mở `chat-widget.html`, sửa `BOT_URL`, `ZALO_LINK`, `TITLE`.
4. Trong LadiPage: thêm phần tử **HTML** → dán toàn bộ nội dung `chat-widget.html` → Xuất bản.

Anh/chị trả lời khách web bằng `/tl web_xxx ...` (mã có trong thông báo).

**Đổ dữ liệu khách về Google Sheet:** làm theo hướng dẫn ở đầu file `google_sheet.gs`, rồi dán link Web App vào `SHEET_WEBHOOK_URL` trong `.env`. Bot tự ghi 2 trang:
- **KhachHang:** hồ sơ và độ nhiệt khách, tự cập nhật.
- **LichHen:** các lịch hẹn.

**Danh sách khách cũ:**
1. Mở `khach_hang_cu.csv` bằng Excel, xóa 2 dòng mẫu.
2. Dán khách theo đúng các cột: `ten, sdt, zalo_chat_id, ngan_sach, khu_vuc, loai_hinh, so_phong_ngu, muc_dich, da_mua, quan_tam, ghi_chu`.
3. Lưu bằng **File → Save As → CSV UTF-8**.

Cột `zalo_chat_id` để trống cũng được: khách nhắn bot và đưa SĐT là bot tự nhận ra khách cũ.

---

## 12. Chạy 24/7 trên VPS

1. Thuê VPS Ubuntu rẻ nhất (khoảng 100–150 nghìn/tháng là đủ).
2. Cài Python:
   ```
   sudo apt update && sudo apt install -y python3
   ```
3. Chép thư mục bot lên VPS bằng WinSCP hoặc FileZilla.
4. Vào thư mục bot, chạy thử:
   ```
   python3 bot.py
   ```
   Bot hỏi token và key giống như trên máy tính.
5. Cho bot tự chạy lại khi VPS khởi động: tạo file `/etc/systemd/system/bdsbot.service` với nội dung:
   ```
   [Unit]
   Description=Bot BDS
   After=network-online.target
   [Service]
   WorkingDirectory=/root/bds-bot
   ExecStart=/usr/bin/python3 /root/bds-bot/bot.py
   Restart=always
   [Install]
   WantedBy=multi-user.target
   ```
6. Bật bot: `sudo systemctl enable --now bdsbot`. Xem log: `journalctl -u bdsbot -f`.

**HTTPS cho khung chat mà không cần tự cài chứng chỉ:** dùng Cloudflare Tunnel (miễn phí), trỏ tên miền phụ (ví dụ `bot.tenmien.com`) về `http://localhost:8080`.

---

## 13. Lỗi thường gặp & lưu ý

| Hiện tượng | Cách xử lý |
|---|---|
| Bấm đúp file .bat, cửa sổ hiện rồi tắt / báo "python is not recognized" | Cài lại Python, **tick "Add python.exe to PATH"** |
| "Tài khoản Claude chưa nạp tiền" | console.anthropic.com → Billing → nạp tiền |
| "Token chưa đúng" | Copy lại token, đừng copy thừa dấu cách |
| Bot trả lời "để em kiểm tra" nhiều quá | Thông tin còn thiếu → gửi ảnh CSBH, `/capnhat`, `/hoidap` |
| Bot đọc ảnh sai số | Chụp lại thẳng, rõ hơn, mỗi ảnh 1 trang · hoặc sửa rồi `/capnhat` |
| `/banghang` báo ⚠️ chưa đọc được | Sheet chưa chia sẻ "Bất kỳ ai có đường liên kết" |
| Bot vẫn giới thiệu căn đã bán | Kiểm tra cột `trang_thai` trên Sheet (đợi tối đa 10 phút để bot lấy bản mới) |
| Bot nói chính sách cũ | `/capnhat` để xem danh sách → `/xoacapnhat <số>` xóa mục cũ |
| Không muốn bot nhắn lại khách | `/chamsoc tat`, hoặc `/tat <mã>` cho từng khách |
| Muốn đổi Zalo nhận thông báo | Mở `.env`, xóa số sau `ADMIN_CHAT_ID=`, chạy lại rồi nhắn `/chu <mã mới>` |
| Muốn đổi token / key | Sửa trong `.env`, hoặc xóa file `.env` rồi chạy lại để bot hỏi lại |

**Lưu ý:**
- Bot **không bao giờ** tự nhận cọc, đưa số tài khoản, cam kết lợi nhuận, hay bịa giá.
- Dữ liệu khách nằm trong thư mục `data/`. **Sao lưu định kỳ** (copy cả thư mục ra USB hoặc Google Drive).
- **Không** đưa file `.env`, thư mục `data/` hay danh sách khách thật lên mạng hoặc GitHub.
- Zalo có thể hạn chế bot nếu bot nhắn quá nhiều người không phản hồi. Vì vậy chăm sóc tự động chỉ nhắn tối đa 3 lần, chỉ trong giờ hành chính.
- Chi phí API: mỗi tin trả lời khoảng vài chục đến vài trăm đồng. Đọc ảnh hoặc quét chiến dịch tốn hơn một chút.
