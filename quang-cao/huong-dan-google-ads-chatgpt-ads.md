# Hướng dẫn chạy quảng cáo trang Ads Tòa F2

Trang đích: **https://www.sun-fours-tower.com/toa-f2-ads**

Trang đã có sẵn:
- Thẻ Google Ads `AW-872503827`.
- Mã đếm chuyển đổi cho 3 hành động: **gửi form / để lại số trong chat**, **bấm gọi**, **bấm Zalo**.
- Mã đã gắn nhưng **chưa có nhãn chuyển đổi**, nên Google chưa đếm được. Anh làm Bước 1 rồi gửi nhãn cho Claude.

---

## Bước 1 – Tạo 3 chuyển đổi trong Google Ads (làm 1 lần, khoảng 10 phút)

1. Vào **ads.google.com**, chọn **Mục tiêu**, rồi **Chuyển đổi**, rồi **Tóm tắt**. Bấm **+ Tạo hành động chuyển đổi**.
2. Chọn **Trang web**, nhập `https://www.sun-fours-tower.com/toa-f2-ads`, bấm **Quét**.
3. Kéo xuống phần **"Tạo hành động chuyển đổi theo cách thủ công bằng mã"**, bấm **+ Thêm hành động chuyển đổi thủ công**.
4. Tạo lần lượt 3 hành động:

| Tên hành động | Danh mục | Giá trị | Số lần đếm | Ghi chú |
|---|---|---|---|---|
| **Lead – để lại số** | Gửi biểu mẫu khách hàng tiềm năng | Dùng cùng giá trị, ví dụ 500.000 ₫ | **Một** | Đặt làm **Mục tiêu chính** |
| **Bấm gọi** | Cuộc gọi điện thoại | 200.000 ₫ | **Một** | Mục tiêu phụ |
| **Bấm Zalo** | Liên hệ | 150.000 ₫ | **Một** | Mục tiêu phụ |

5. Lưu xong mỗi hành động, chọn **"Sử dụng Google Tag"**, rồi **"Tự cài đặt"**. Google hiện một đoạn mã có dòng:
   `'send_to': 'AW-872503827/AbC1dEfGhIjK'`
   👉 Phần **sau dấu "/"** (ví dụ `AbC1dEfGhIjK`) là **nhãn**. Anh chép 3 nhãn gửi Claude, Claude dán vào cả 7 trang.
6. *(Nên làm)* Trong hành động **Lead**, bật **Chuyển đổi nâng cao**, chọn **Google tag**. Trang đã gửi sẵn số điện thoại khách; Google tự mã hóa số này trước khi gửi, nên vẫn đếm được khi khách đổi thiết bị.

> Đã có nhãn rồi thì anh không phải sửa code. Claude dán nhãn, anh chỉ bấm Xuất bản.

---

## Bước 2 – Tạo chiến dịch Tìm kiếm

- **Loại chiến dịch:** Tìm kiếm. **Mục tiêu:** Khách hàng tiềm năng.
- **Mạng:** Chỉ Google Tìm kiếm. **Bỏ chọn** Mạng hiển thị (Display) và Đối tác tìm kiếm.
- **Vị trí:** Đà Nẵng, Hà Nội, TP. Hồ Chí Minh. Chọn **"Người ở hoặc thường xuyên ở"** các vị trí này.
- **Ngôn ngữ:** Tiếng Việt.
- **Ngân sách gợi ý để bắt đầu:** 500.000 – 1.000.000 ₫/ngày.
- **Đặt giá thầu:**
  - 2 tuần đầu: **Tối đa hóa lượt nhấp**, đặt giới hạn CPC khoảng 15.000 – 25.000 ₫.
  - Khi đã có **khoảng 15–30 lead**: chuyển sang **Tối đa hóa lượt chuyển đổi**.
- **Lịch chạy:** 7h – 22h hằng ngày, để có người trả lời chat và điện thoại.
- **URL cuối cùng:** `https://www.sun-fours-tower.com/toa-f2-ads`. Để **Tự động gắn thẻ** ở trạng thái bật (mặc định). Mã gclid sẽ tự về CRM và Telegram, Telegram báo "Nguồn: Google Ads".

### Nhóm quảng cáo và từ khóa

Gõ từ khóa trong ngoặc kép `"..."` (đối sánh cụm từ) hoặc ngoặc vuông `[...]` (đối sánh chính xác).

**Nhóm 1 – Tên dự án** (giá rẻ nhất, khách nóng nhất)
```
[sun fours tower]
"fours tower"
"four s tower đà nẵng"
"tòa f2 fours tower"
"căn hộ fours tower"
"sun riverpolis"
"căn hộ sun riverpolis"
```

**Nhóm 2 – Căn hộ Sun Group Đà Nẵng**
```
"căn hộ sun group đà nẵng"
"chung cư sun group đà nẵng"
"căn hộ sun đà nẵng"
"dự án sun group đà nẵng"
```

**Nhóm 3 – Mua căn hộ Đà Nẵng, vay vốn**
```
"mua căn hộ đà nẵng"
"căn hộ đà nẵng trả góp"
"chung cư đà nẵng vay ngân hàng"
"căn hộ gần biển đà nẵng"
"căn hộ đà nẵng 2 tỷ"
"căn hộ ngũ hành sơn"
```

**Nhóm 4 – Đầu tư**
```
"đầu tư căn hộ đà nẵng"
"mua căn hộ đầu tư đà nẵng"
"căn hộ đà nẵng sinh lời"
```

### Từ khóa phủ định (thêm ở cấp chiến dịch)
```
thuê
cho thuê theo ngày
homestay
khách sạn
airbnb
phòng trọ
việc làm
tuyển dụng
nhà ở xã hội
cũ
sang nhượng
miễn phí
```

### Mẫu quảng cáo (dùng cho cả 4 nhóm)

**15 dòng tiêu đề** (đã kiểm tra, đều dưới 30 ký tự)
```
Sun FourS Tower Đà Nẵng
Tòa F2 Mở Bán Từ 26/09
Chiết Khấu Tới 19%
Vay 70% – Lãi Suất 0% 24 Tháng
Chỉ 25% Vốn Đến Khi Nhận Nhà
Căn Hộ Sun Group Đà Nẵng
Giá Chỉ Từ 1,9 Tỷ (Gồm VAT)
Cách Biển Sơn Thủy ~2 Km
Căn Sân Vườn Riêng Tới 69m²
607 Căn Đủ Điều Kiện Bán
Techcombank Bảo Lãnh
Miễn Phí Quản Lý 2 Năm
Cọc Chỉ 100 Triệu
Nhận Bảng Giá Qua Zalo
Nhận Nhà Dự Kiến 05/2028
```
👉 Ghim **"Sun FourS Tower Đà Nẵng"** ở vị trí 1.

**4 dòng mô tả** (đều dưới 90 ký tự)
```
Tòa F2 Sun FourS Tower: vay 70%, hỗ trợ lãi suất 0% 24 tháng. Cọc chỉ 100 triệu.
607 căn đủ điều kiện bán (VB 17239/SXD-QLN), Techcombank bảo lãnh. Xem hồ sơ ngay.
Chiết khấu cộng dồn tới 19% khi thanh toán sớm trước 25/10/2026. Nhận giá từng căn.
Cách biển ~2 km, 10 phút ra sân bay. Căn sân vườn riêng tầng 2–7, số lượng có hạn.
```
**Đường dẫn hiển thị:** `toa-f2` / `uu-dai`

### Thành phần bổ sung (tiện ích) – giúp quảng cáo to hơn và tỷ lệ nhấp cao hơn

- **Đường liên kết trang web:**

  | Tên hiển thị | Đường dẫn |
  |---|---|
  | Giỏ hàng căn trống | `https://www.sun-fours-tower.com/gio-hang` |
  | Hồ sơ pháp lý | `https://www.sun-fours-tower.com/phap-ly` |
  | Tính vốn vay 70% | `https://www.sun-fours-tower.com/bang-tinh-f2` |
  | Hỏi đáp 59 câu | `https://www.sun-fours-tower.com/hoi-dap` |

- **Chú thích:** Cọc 100 triệu · Miễn phí quản lý 2 năm · Techcombank bảo lãnh · Lãi suất 0% 24 tháng
- **Cuộc gọi:** 0904 567 009 (bật trong giờ làm việc)
- **Đoạn nội dung có cấu trúc** – chọn tiêu đề "Loại", nhập: Studio, 1PN, 1PN+, 2PN, 3PN, Căn sân vườn

⚠️ **Sau 25/10/2026** phải gỡ "Chiết khấu tới 19%" và mô tả số 3, vì ưu đãi thanh toán sớm đã hết hạn. Google sẽ từ chối quảng cáo nếu nội dung không còn đúng với trang.

---

## Bước 3 – Theo dõi tuần đầu

- **Hằng ngày:** vào **Từ khóa**, rồi **Cụm từ tìm kiếm**. Thấy cụm không liên quan (thuê, việc làm…) thì thêm vào từ khóa phủ định.
- Mỗi lead báo về **Telegram** có dòng "Nguồn: Google Ads" và toàn bộ nội dung chat. Anh gọi lại trong vòng 15 phút.
- **Sau 7 ngày:** từ khóa tốn trên 1 triệu mà chưa có lead nào thì tạm dừng. Nhóm nào có lead thì tăng ngân sách.

---

## ChatGPT Ads (OpenAI Ads)

**Lưu ý trước:** OpenAI Ads mới mở cho một số thị trường. Anh vào **OpenAI Ads Manager** kiểm tra xem tài khoản có chạy được cho người dùng ở Việt Nam không, trước khi nạp tiền.

Các bước nếu chạy được:
1. Tạo tài khoản trong **OpenAI Ads Manager**, rồi lấy **Advertiser API key**.
2. Vào **LadiPage**, chọn **Tài khoản liên kết**, chọn **OpenAI Ads**, dán Advertiser API key để liên kết (làm 1 lần).
3. Nhắn Claude **"đã liên kết OpenAI"**. Claude sẽ:
   - tạo Pixel OpenAI (gửi sự kiện từ máy chủ nên không bị trình chặn quảng cáo làm mất),
   - gắn pixel vào trang Ads, gửi sự kiện `lead_created` khi khách để số.
4. Trong OpenAI Ads Manager:
   - Tạo chiến dịch trỏ về `https://www.sun-fours-tower.com/toa-f2-ads`.
   - Mô tả ngắn gọn theo các ý: căn hộ Sun Group Đà Nẵng, vay 70% lãi suất 0% 24 tháng, cách biển 2 km, pháp lý đủ điều kiện bán.

**Không tốn tiền:** trang **/hoi-dap** (59 câu, có khai báo hỏi – đáp cho máy tìm kiếm) giúp ChatGPT và Google dễ trích câu trả lời về dự án khi người dùng hỏi kiểu "Sun FourS Tower có pháp lý chưa". Nhớ giữ trang này luôn xuất bản.
