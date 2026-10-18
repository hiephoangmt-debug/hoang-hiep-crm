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

Bot gửi về Zalo của anh/chị: 🆕 khách mới · 🔥 khách nóng · 📅 lịch hẹn · 🙋 cần xử lý · 🤐 tin bot không trả lời.

**Zalo cá nhân của anh/chị không bị đụng tới.** Nhóm Tati, gia đình, đồng nghiệp vẫn nhắn ở đó và anh/chị tự trả lời. Khách cũ nhắn ở Zalo cá nhân thì dùng lệnh `/soan` (xem bên dưới).

---

## Cài đặt lần đầu (khoảng 20 phút)

**1. Tạo bot Zalo.** Vào https://bot.zaloplatforms.com, đăng nhập Zalo, tạo bot (đặt tên, ví dụ "Hiệp BĐS – Tư vấn dự án"), rồi copy **token**.

**2. Lấy API key Claude.** Vào https://console.anthropic.com, nạp tiền (tính theo lượng dùng), vào API Keys, tạo key rồi copy.

**3. Cài Python** 3.9 trở lên từ python.org (máy Windows nhớ tick "Add to PATH"). Không cần cài thêm thư viện nào.

**4. Điền cấu hình.** Đổi tên `.env.example` thành `.env`, mở bằng Notepad, dán token và API key vào.

**5. Điền thông tin dự án** vào `du_an.md`: tên anh/chị, các dự án, giá, CSBH, pháp lý. Có thể copy nguyên văn CSBH vào. **Bot chỉ nói những gì có trong file này.**

**6. Chạy bot:** mở Terminal / CMD trong thư mục bot rồi gõ
```
python3 bot.py
```
(Windows: `python bot.py`)

**7. Nhận thông báo:** dùng Zalo của anh/chị nhắn `/id` cho bot, copy số chat_id vào `ADMIN_CHAT_ID` trong `.env`, tắt bot (Ctrl+C) rồi chạy lại.

**8. Thử ngay:** nhắn bot "cho em xin CSBH FourS Tower" để xem bot trả lời.

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

**Quản lý**
- `/tl <chat_id> <nội dung>` – trả lời khách qua bot (bot nhường anh/chị 30 phút)
- `/rieng <chat_id> <ghi chú>` – đưa người đó vào danh bạ riêng, bot không bao giờ trả lời
- `/borieng <chat_id>` · `/tat <chat_id>` · `/bat <chat_id>`
- `/khach <chat_id>` – xem hồ sơ và tin gần nhất của khách
- `/nong` – danh sách khách nóng · `/thongke` – số liệu · `/hd` – xem tất cả lệnh

---

## Đưa danh sách khách cũ vào
Mở `khach_hang_cu.csv` bằng Excel, xóa 2 dòng mẫu, dán danh sách khách theo đúng tên cột:
`ten, sdt, zalo_chat_id, ngan_sach, khu_vuc, loai_hinh, so_phong_ngu, muc_dich, da_mua, quan_tam, ghi_chu`

Lưu lại bằng **File → Save As → CSV UTF-8**. Cột `zalo_chat_id` để trống cũng được: khi khách nhắn bot và đưa SĐT, bot tự nhận ra là khách cũ.

---

## Gắn khung chat lên LadiPage
1. Bot phải chạy trên một máy có **địa chỉ HTTPS** (xem phần VPS bên dưới).
2. Trong `.env`: `WEB_PORT=8080`, `ALLOWED_ORIGIN=https://tenmien-ladipage-cua-ban.com`
3. Mở `chat-widget.html`, sửa `BOT_URL`, `ZALO_LINK`, `TITLE`.
4. Trong LadiPage: thêm phần tử **HTML** → dán toàn bộ nội dung `chat-widget.html` → xuất bản.

Khách chat trên web cũng có hồ sơ, lịch hẹn và thông báo như khách Zalo. Anh/chị trả lời khách web bằng `/tl web_xxx ...` (mã có sẵn trong thông báo).

## Đổ dữ liệu về Google Sheet (tùy chọn)
Làm theo hướng dẫn ở đầu file `google_sheet.gs`, rồi dán link Web App vào `SHEET_WEBHOOK_URL`. Bot tự ghi 2 trang: **KhachHang** (hồ sơ khách, tự cập nhật) và **LichHen**.

---

## Chạy 24/7 trên VPS (khuyên dùng)
Thuê VPS Ubuntu rẻ nhất (khoảng 100–150 nghìn/tháng là đủ), rồi:
```
sudo apt update && sudo apt install -y python3
# chép thư mục bot lên VPS (WinSCP / FileZilla), vào thư mục rồi chạy thử:
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
