# BOT TƯ VẤN BẤT ĐỘNG SẢN – HƯỚNG DẪN

## Bot làm gì
| Ai nhắn | Bot làm gì |
|---|---|
| Khách mới hỏi dự án, CSBH, giá | Tư vấn ngay 24/7, hóm hỉnh, xin SĐT, hẹn xem nhà |
| Khách cũ (có trong `khach_hang_cu.csv` hoặc đã từng chat) | Chào như người quen, nhắc lại nhu cầu cũ |
| Môi giới xin hợp tác, đồng nghiệp, tin rác | **Im lặng**, chuyển tin cho anh/chị |
| Nhóm Zalo | **Luôn bỏ qua** |
| Người trong "danh bạ riêng" (`/rieng`) | **Luôn bỏ qua**, chuyển tin cho anh/chị |
| Khách muốn cọc, đàm phán giá, khiếu nại | Báo khách "chuyên viên gọi ngay", bot tạm dừng 30 phút |

Bot gửi về Zalo của anh/chị: 🆕 khách mới · 🔥 khách nóng · 📅 lịch hẹn · 🤝 gợi ý kết bạn · 🙋 cần xử lý · 🤐 tin bot không trả lời.

Bot là **một tài khoản Zalo riêng** (Zalo Bot), khách nhắn vào đó. **Zalo cá nhân của anh/chị không bị đụng tới.** Nhóm Tati, gia đình, đồng nghiệp vẫn nhắn ở đó và anh/chị tự trả lời. Khách cũ nhắn ở Zalo cá nhân thì dùng lệnh `/soan` (xem bên dưới).

---

## BẮT ĐẦU NHANH – 3 bước, khoảng 15 phút

**Bước 1 – Chuẩn bị 2 thứ (copy để sẵn vào Ghi chú điện thoại):**
- **Token bot Zalo:** vào https://bot.zaloplatforms.com → đăng nhập Zalo → Tạo bot (đặt tên, ví dụ "Hiệp BĐS – Tư vấn dự án") → copy **token**.
- **API key Claude:** vào https://console.anthropic.com → **Billing** nạp tiền (khoảng 5–10 USD dùng được lâu) → **API Keys** → Create key → copy.

**Bước 2 – Cài Python (chỉ 1 lần):** tải ở https://python.org → Download → cài. Máy Windows **nhớ tick ô "Add python.exe to PATH"** ở màn hình đầu tiên.

**Bước 3 – Chạy bot:** mở thư mục bot, **bấm đúp**:
- Windows: `CHAY_BOT_Windows.bat`
- Mac: `CHAY_BOT_Mac.command` (lần đầu: chuột phải → Open)

Cửa sổ đen hiện ra và hỏi token Zalo, rồi API key: **dán vào và bấm Enter**. Bot tự kiểm tra, sai thì báo để dán lại.
Cuối cùng màn hình hiện `/chu 1234` (mỗi lần mã khác) → **dùng Zalo của anh/chị nhắn đúng câu đó cho bot**. Xong! Bot nhận anh/chị là chủ và gửi danh sách lệnh về Zalo.

👉 **Thử ngay:** nhờ người quen nhắn bot "cho em xin CSBH FourS Tower".

⚠️ Để cửa sổ đen **luôn mở**: đóng cửa sổ hoặc tắt máy thì bot dừng. Muốn chạy 24/7 không cần bật máy → xem phần **VPS** bên dưới.

### Cho bot biết về dự án của anh/chị
Cách nhanh nhất: **nhắn ngay trên Zalo cho bot**, không cần mở file (ví dụ dưới đây, thay bằng số thật của anh/chị):
```
/capnhat FourS Tower: căn 2PN 68m2 giá từ 3,2 tỷ, CK 3% khi thanh toán sớm 50%, sở hữu lâu dài, bàn giao Q4/2027
```
Mỗi lần có CSBH, giá, căn mới thì `/capnhat` thêm. Có hiệu lực ngay. Gõ `/xemduan` để xem bot đang biết gì.
Muốn điền bài bản thì mở file `du_an.md` bằng Notepad, thay các chỗ `[điền ...]`. **Bot chỉ nói những gì có trong file này, không tự bịa.**

---

## Các lệnh (nhắn cho bot từ Zalo của anh/chị)

**Soạn trả lời cho khách ở Zalo cá nhân**
```
/soan Hi bạn, mình muốn xin thông tin CSBH FourS Tower
```
Bot trả về 2 phương án (hóm hỉnh / chuyên nghiệp) kèm gợi ý bước tiếp theo, anh/chị copy rồi gửi khách.

**Dịch tin viết tắt**
```
/dich a ơi 2pn view sông tầm 3t5 có k, ck bn, ib e csbh nhé
```
Bot viết lại thành câu đầy đủ và tóm tắt khách muốn gì. Bot đã hiểu sẵn viết tắt BĐS (CSBH, PN, HĐMB, CK, HTLS, SHR, F0/F1, 3t5…) và kiểu nhắn Zalo (k, dc, bn, ntn…). Muốn thêm từ riêng thì ghi vào mục "Từ viết tắt riêng" trong `du_an.md`.

**Chào dự án mới cho đúng khách**
```
/chaohang FourS Tower – đợt mở bán căn 2PN view sông
```
Bot quét toàn bộ khách đã chat với bot và khách cũ trong file Excel, chấm điểm 0–10, rồi soạn tin chào riêng cho từng người.
- `/xem <mã> 1` – xem tin soạn cho khách số 1
- `/gui <mã>` – bot gửi cho những khách đang chat với bot (mỗi chiến dịch chỉ gửi 1 lần)
- Khách chỉ có SĐT: mở `data/chien_dich/<mã>.csv` bằng Excel, copy tin gửi qua Zalo cá nhân

**Kết bạn Zalo cá nhân**
- `/ketban <mã khách hoặc mô tả khách>` – soạn 3 câu lời chào kết bạn riêng cho khách (xem mục Kết bạn bên dưới)

**Cập nhật dự án**
- `/capnhat <nội dung>` – thêm CSBH / giá / căn mới · `/xemduan` – xem thông tin bot đang dùng

**Quản lý**
- `/tl <chat_id> <nội dung>` – trả lời khách qua bot (bot nhường anh/chị 30 phút)
- `/rieng <chat_id> <ghi chú>` – đưa người đó vào danh bạ riêng, bot không bao giờ trả lời
- `/borieng <chat_id>` · `/tat <chat_id>` · `/bat <chat_id>`
- `/khach <chat_id>` – xem hồ sơ và tin gần nhất của khách
- `/nong` – danh sách khách nóng · `/thongke` – số liệu · `/hd` – xem tất cả lệnh

---

## Kết bạn Zalo cá nhân với khách (lời chào chỉn chu, không dùng câu mặc định)

Khách nhắn bot, gọi điện hoặc để lại SĐT trên web nhưng **chưa là bạn Zalo của anh/chị**. Gửi kết bạn kèm lời chào **nhắc đúng điều khách đã hỏi** thì khách nhớ ra ngay, thấy mình chỉn chu, và không nghĩ là tin rác.

> Zalo không cho bot tự gửi kết bạn từ Zalo cá nhân (dùng phần mềm tự động dễ bị khóa nick). Vì vậy bot **soạn sẵn**, còn anh/chị bấm gửi bằng tay, mỗi khách mất khoảng 20 giây.

### Bot tự soạn lời mời cho anh/chị
- **Tự động:** khách vừa để lại SĐT là bot gửi về Zalo của anh/chị tin **🤝 Gợi ý KẾT BẠN**, kèm SĐT và **3 câu lời chào, mỗi câu là 1 tin riêng**.
- **Khi cần:** nhắn bot
  - `/ketban web_abc123`: dùng mã khách có trong thông báo, bot đọc lại cuộc chat để soạn.
  - `/ketban Chị Lan 0905xxxxxx, gọi hỏi căn 2PN FourS view sông, muốn xem nhà mẫu cuối tuần`: dùng cho khách gọi điện hoặc gặp trực tiếp.

### Các bước gửi kết bạn trên điện thoại
1. Trong Zalo bot gửi về: **nhấn giữ** câu lời chào anh/chị thích → **Sao chép**.
2. Mở **Zalo cá nhân** → tab **Danh bạ** → bấm biểu tượng **người có dấu +** (góc trên bên phải).
3. Gõ **SĐT của khách** → bấm **Tìm**. Kiểm tra lại tên và ảnh đại diện cho đúng người.
4. Bấm **Kết bạn**. Ô lời chào hiện sẵn câu mặc định *"Xin chào, mình là …"*: **xóa hết**, nhấn giữ → **Dán** câu vừa sao chép.
5. Bấm **Gửi yêu cầu** (hoặc **Kết bạn**).
6. **Lưu tên khách dễ tìm:** mở trang cá nhân của khách → **⋯** → **Đổi tên gợi nhớ**, ví dụ `FourS – C.Lan 2PN`.
7. **Ngay sau khi gửi, nhắn luôn 1 tin** (Zalo cho nhắn người lạ). Bot có soạn sẵn tin "💬 Khi khách đồng ý kết bạn, nhắn tiếp". Gửi kèm CSBH, ảnh hoặc video căn khách hỏi. Khách thấy có thông tin hữu ích nên thường đồng ý kết bạn nhanh hơn.

Khách nhắn Zalo cá nhân của anh/chị khi chưa kết bạn (hiện chữ **"Người lạ"**): trả lời khách trước (dùng `/soan`), rồi bấm **Kết bạn** ở đầu khung chat và dán lời chào như bước 4.

### Mẫu lời chào dùng ngay (dưới 150 ký tự, sửa chỗ [ ])
| Tình huống | Lời chào |
|---|---|
| Khách hỏi CSBH qua bot | Em Hiệp – [đơn vị] đây ạ. Anh/chị vừa hỏi CSBH [dự án], em kết bạn để gửi bảng giá và ảnh căn thực tế cho tiện xem nha |
| Vừa gọi điện xong | Em Hiệp vừa nói chuyện với anh/chị về căn 2PN [dự án] ạ. Em kết bạn để gửi mặt bằng và CSBH như đã hẹn nha |
| Khách để SĐT trên web | Em Hiệp – [đơn vị], anh/chị vừa để lại SĐT trên web [dự án] ạ. Em kết bạn để gửi CSBH, bảng giá chi tiết nha |
| Khách cũ đổi số / mất kết nối | Em Hiệp – người tư vấn căn [mã căn] cho anh/chị hồi [tháng/năm] ạ. Em kết bạn lại để tiện báo tiến độ, sổ hồng nha |

**Nên:** xưng tên + đơn vị, nhắc đúng dự án hoặc căn khách hỏi, nói rõ kết bạn để gửi gì.
**Tránh:** "Kết bạn với mình nhé", "Mình là môi giới BĐS", gửi giá ngay trong lời chào, gửi lại nhiều lần khi khách chưa đồng ý.
⚠️ Mỗi ngày đừng gửi kết bạn quá nhiều người lạ một lúc: Zalo dễ tạm khóa chức năng kết bạn. Ưu tiên khách 🔥 nóng trước.

---

## Đưa danh sách khách cũ vào
Mở `khach_hang_cu.csv` bằng Excel, xóa 2 dòng mẫu, dán danh sách khách theo đúng tên cột:
`ten, sdt, zalo_chat_id, ngan_sach, khu_vuc, loai_hinh, so_phong_ngu, muc_dich, da_mua, quan_tam, ghi_chu`

Lưu lại bằng **File → Save As → CSV UTF-8**. Cột `zalo_chat_id` để trống cũng được: khi khách nhắn bot và đưa SĐT, bot tự nhận ra là khách cũ.

---

## Gắn khung chat lên LadiPage
1. Bot phải chạy trên một máy có **địa chỉ HTTPS** (xem phần VPS bên dưới).
2. Mở file `.env` (bot tự tạo sau lần chạy đầu) bằng Notepad: `WEB_PORT=8080`, `ALLOWED_ORIGIN=https://tenmien-ladipage-cua-ban.com`
3. Mở `chat-widget.html`, sửa `BOT_URL`, `ZALO_LINK`, `TITLE`.
4. Trong LadiPage: thêm phần tử **HTML** → dán toàn bộ nội dung `chat-widget.html` → xuất bản.

Khách chat trên web cũng có hồ sơ, lịch hẹn và thông báo như khách Zalo. Anh/chị trả lời khách web bằng `/tl web_xxx ...` (mã có sẵn trong thông báo).

## Đổ dữ liệu về Google Sheet (tùy chọn)
Làm theo hướng dẫn ở đầu file `google_sheet.gs`, rồi mở `.env` dán link Web App vào `SHEET_WEBHOOK_URL`. Bot tự ghi 2 trang: **KhachHang** (hồ sơ khách, tự cập nhật) và **LichHen**.

---

## Chạy 24/7 trên VPS (khuyên dùng)
Thuê VPS Ubuntu rẻ nhất (khoảng 100–150 nghìn/tháng là đủ), rồi:
```
sudo apt update && sudo apt install -y python3
# chép thư mục bot lên VPS (WinSCP / FileZilla), vào thư mục rồi chạy thử (bot hỏi token, key như trên máy tính):
python3 bot.py
```
Cho bot tự chạy lại khi VPS khởi động: tạo file `/etc/systemd/system/bdsbot.service`
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
Sau đó chạy `sudo systemctl enable --now bdsbot` và xem log bằng `journalctl -u bdsbot -f`.

**Có HTTPS cho khung chat LadiPage mà không cần tự cài chứng chỉ:** dùng Cloudflare Tunnel (miễn phí). Trỏ tên miền phụ, ví dụ `bot.tenmien.com`, về `http://localhost:8080`.

---

## Lưu ý quan trọng
- **Bot nói hay hay dở phụ thuộc vào `du_an.md`.** CSBH mới thì cập nhật ngay, sửa xong có hiệu lực luôn.
- Bot không bao giờ tự nhận cọc, đưa số tài khoản hay cam kết lợi nhuận.
- Chiến dịch chào hàng: nên chào **đúng người, ít mà chất**. Gửi ồ ạt dễ bị khách chặn và Zalo hạn chế bot.
- Dữ liệu khách nằm trong thư mục `data/`, nhớ sao lưu định kỳ.
- Chi phí API: mỗi tin trả lời khoảng vài chục đến vài trăm đồng, tùy độ dài hội thoại.

## Gặp lỗi thường gặp
| Hiện tượng | Cách xử lý |
|---|---|
| Bấm đúp file .bat, cửa sổ hiện rồi tắt / báo "python is not recognized" | Cài lại Python, **tick "Add python.exe to PATH"** |
| "Tài khoản Claude chưa nạp tiền" | console.anthropic.com → Billing → nạp tiền |
| "Token chưa đúng" | Vào bot.zaloplatforms.com copy lại token, đừng copy thừa dấu cách |
| Muốn đổi token / key | Mở `.env` bằng Notepad sửa, hoặc xóa file `.env` rồi chạy lại để bot hỏi lại |
| Bot trả lời "để em kiểm tra" nhiều quá | Thông tin dự án còn thiếu → `/capnhat` thêm |
| Muốn đổi Zalo nhận thông báo | Mở `.env`, xóa số sau `ADMIN_CHAT_ID=`, chạy lại và nhắn `/chu <mã mới>` |
