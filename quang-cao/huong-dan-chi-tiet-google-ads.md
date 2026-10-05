# Hướng dẫn chi tiết chạy Google Ads – Tòa F2 Sun FourS Tower

**Trang đích:** https://www.sun-fours-tower.com/toa-f2-ads
**Tài khoản Google Ads:** AW-872503827 (thẻ đã gắn sẵn trên cả 7 trang)

> Cách đọc: làm lần lượt **Phần 0 → Phần 6** trong ngày đầu, khoảng 1–2 giờ. **Phần 7–9** là việc theo dõi hằng ngày và hằng tuần.
> Mọi chữ trong `khung xám` đều dán thẳng vào Google Ads được.

---

## Phần 0 – Kiểm tra trước khi chạy (5 phút)

| # | Việc | Cách kiểm tra |
|---|---|---|
| 1 | Trang Ads đã xuất bản bản mới | Mở trang Ads trên điện thoại, bấm chat, gõ "bảo hành mấy năm". Chat trả lời "tối thiểu 60 tháng" là đúng bản mới. |
| 2 | Báo khách về Telegram chạy | Tự để lại số thử ở form trên trang. Trong 1 phút Telegram phải báo "🔥 KHÁCH MỚI ĐỂ LẠI SỐ". |
| 3 | Có người trực | Chạy quảng cáo **7h–22h**. Khách để số thì **gọi lại trong 5–15 phút**, vì gọi chậm sẽ mất khách. |
| 4 | Thanh toán | Google Ads → **Thanh toán** → đã có thẻ hoặc đã nạp tiền. |

---

## Phần 1 – Tạo chuyển đổi (BẮT BUỘC, nếu không Google không biết quảng cáo nào ra khách)

### 1.1 Tạo 3 hành động chuyển đổi
1. Vào **ads.google.com**. Bấm biểu tượng **Mục tiêu** (hình cúp) ở cột trái, chọn **Chuyển đổi**, rồi **Tóm tắt**.
2. Bấm **+ Tạo hành động chuyển đổi**, chọn **Trang web**.
3. Ô "Miền": nhập `sun-fours-tower.com`, bấm **Quét**.
4. Kéo xuống cuối, chọn **"+ Thêm hành động chuyển đổi theo cách thủ công"**.
5. Tạo **hành động 1**:
   - Danh mục mục tiêu: **Gửi biểu mẫu khách hàng tiềm năng**
   - Tên: `Lead – để lại số (form + chat)`
   - Giá trị: **Dùng cùng một giá trị**, nhập `500000` ₫
   - Số lượt: **Một** (mỗi lượt nhấp chỉ tính 1 lead)
   - Khoảng thời gian chuyển đổi: **30 ngày**
   - Bấm **Xong**
6. Tạo **hành động 2**:
   - Danh mục: **Liên hệ** (hoặc **Cuộc gọi điện thoại**, chọn loại "Lượt nhấp vào số điện thoại trên trang web")
   - Tên: `Bấm gọi`
   - Giá trị: `200000`
   - Số lượt: **Một**
7. Tạo **hành động 3**:
   - Danh mục: **Liên hệ**
   - Tên: `Bấm Zalo`
   - Giá trị: `150000`
   - Số lượt: **Một**
8. Bấm **Lưu và tiếp tục**. Ở màn hình cài thẻ, chọn **"Sử dụng Google Tag"**, rồi **"Tự cài đặt"**. Mở phần **"Đoạn mã sự kiện"** của từng hành động, sẽ thấy dòng:
   ```
   'send_to': 'AW-872503827/AbC1dEfGhIjK'
   ```
   👉 Chép phần **sau dấu "/"** của cả 3 hành động, gửi Claude theo mẫu:
   ```
   lead: AbC1dEfGhIjK
   call: XyZ...
   zalo: ...
   ```
   Claude dán vào cả 7 trang. Anh chỉ cần **Xuất bản**.

### 1.2 Đặt "Lead" là mục tiêu chính
- Ở **Mục tiêu**, chọn **Chuyển đổi**, rồi **Tóm tắt**. Hành động **Lead** để là **Hành động chính**.
- **Bấm gọi** và **Bấm Zalo**: bấm vào từng cái, sửa **"Mục tiêu tối ưu hóa hành động"** thành **Phụ**.
- Lý do: Google sẽ tối ưu để ra **số điện thoại thật**, không chỉ lượt bấm.

### 1.3 Bật chuyển đổi nâng cao (tăng độ chính xác 5–15%)
- Ở **Mục tiêu**, chọn **Cài đặt**, rồi **Chuyển đổi nâng cao cho web**. Bật lên, phương thức chọn **Google tag**, đồng ý điều khoản.
- Trang đã gửi sẵn số điện thoại khách; Google tự mã hóa trước khi gửi.

### 1.4 Kiểm tra chuyển đổi hoạt động (sau khi Claude dán nhãn và anh Xuất bản)
1. Mở **tagassistant.google.com** trên máy tính, bấm **Add domain**, nhập trang Ads, bấm **Connect**.
2. Trên trang vừa mở: bấm nút gọi, rồi tự để lại số thử ở form.
3. Trong Tag Assistant phải thấy sự kiện **conversion** với `AW-872503827/...`.
4. Sau **24–48 giờ**, trong **Chuyển đổi**, cột "Trạng thái" chuyển thành **"Đang ghi nhận chuyển đổi"**.

---

## Phần 2 – Cài đặt tài khoản (làm 1 lần)

1. **Tự động gắn thẻ:** **Quản trị** (bánh răng) → **Cài đặt tài khoản** → **Tự động gắn thẻ** → **bật**. Nhờ đó mã gclid tự về CRM và Telegram báo "Nguồn: Google Ads".
2. **Tắt tự động áp dụng đề xuất:** **Đề xuất** → **Tự động áp dụng** → tab **Quảng cáo và thành phần** và tab **Từ khóa và nhắm mục tiêu** → **bỏ chọn tất cả**.
   ⚠️ Rất quan trọng: không tắt thì Google sẽ tự thêm từ khóa rộng, tự đổi giá thầu, làm tốn tiền.
3. **Thu thập dữ liệu đối tượng** (để tiếp thị lại ở Phần 8): **Công cụ** → **Trình quản lý đối tượng** → **Nguồn dữ liệu của bạn** → **Google tag** → bật **thu thập dữ liệu đối tượng**.

---

## Phần 3 – Tạo chiến dịch Tìm kiếm (từng màn hình)

1. **Chiến dịch** → **+** → **Chiến dịch mới**.
2. Mục tiêu: **Khách hàng tiềm năng**. Ở mục "Mục tiêu chuyển đổi", chỉ giữ **Gửi biểu mẫu khách hàng tiềm năng**.
3. Loại chiến dịch: **Tìm kiếm**. Cách đạt mục tiêu: tích **Lượt truy cập trang web**, nhập `https://www.sun-fours-tower.com/toa-f2-ads`.
4. Tên chiến dịch: `SEARCH – Tòa F2 – Lead`.
5. **Đặt giá thầu:**
   - Trọng tâm: **Lượt nhấp**. Tích **"Đặt giới hạn giá thầu CPC tối đa"**, nhập `20000` ₫.
   - *(Sau khi có 15–30 lead mới chuyển sang Chuyển đổi, xem Phần 7.)*
6. **Cài đặt chiến dịch:**
   - Mạng: **bỏ tích** cả "Mạng tìm kiếm của đối tác" và "Mạng hiển thị".
   - **Vị trí:** chọn "Nhập vị trí khác", rồi thêm `Đà Nẵng`, `Hà Nội`, `Thành phố Hồ Chí Minh`.
   - Mở **Tùy chọn vị trí**, chọn **"Sự hiện diện: Người ở hoặc thường xuyên ở các vị trí bạn nhắm đến"**. Không chọn "quan tâm đến", vì sẽ ra khách ở nước ngoài, tốn tiền.
   - Ngôn ngữ: **Tiếng Việt** (thêm **Tiếng Anh** nếu muốn bắt khách để máy bằng tiếng Anh).
   - Phân khúc đối tượng: bỏ qua.
   - **Ngày kết thúc:** không đặt.
   - **Lịch quảng cáo:** Thứ 2 → Chủ nhật, **07:00 – 22:00**.
   - **Mở rộng URL cuối cùng** (nếu có): **tắt**.
7. **Từ khóa và quảng cáo:** tạo nhóm 1 trước (xem Phần 4–5), các nhóm khác thêm sau.
8. **Ngân sách:** chọn **Đặt ngân sách tùy chỉnh**, nhập `700000` ₫/ngày (khoảng 21 triệu/tháng; xem bảng ngân sách ở Phần 7).
9. **Xem lại**, rồi **Xuất bản chiến dịch**.

---

## Phần 4 – Nhóm quảng cáo và từ khóa

**Nguyên tắc:** dùng **đối sánh cụm từ** `"..."` và **chính xác** `[...]`. **Không dùng đối sánh rộng** lúc đầu, vì rất dễ ra người tìm thuê nhà, tìm việc.

| Nhóm | Tên nhóm | Ý định khách | Giá thầu tối đa gợi ý |
|---|---|---|---|
| 1 | `Thuong hieu – FourS Tower` | Đã biết dự án, nóng nhất | 15.000 ₫ |
| 2 | `Sun Group Da Nang` | Tin thương hiệu Sun | 20.000 ₫ |
| 3 | `Mua can ho Da Nang – vay` | Đang tìm mua, quan tâm vay | 20.000 ₫ |
| 4 | `Dau tu Da Nang` | Nhà đầu tư | 20.000 ₫ |

**Nhóm 1 – Thương hiệu**
```
[sun fours tower]
[fours tower]
"fours tower đà nẵng"
"four s tower"
"tòa f2 fours tower"
"căn hộ fours tower"
"giá fours tower"
"sun riverpolis"
"căn hộ sun riverpolis"
```

**Nhóm 2 – Sun Group Đà Nẵng**
```
"căn hộ sun group đà nẵng"
"chung cư sun group đà nẵng"
"căn hộ sun đà nẵng"
"dự án sun group đà nẵng"
"sun property đà nẵng"
```

**Nhóm 3 – Mua căn hộ, vay vốn**
```
"mua căn hộ đà nẵng"
"căn hộ đà nẵng trả góp"
"chung cư đà nẵng vay ngân hàng"
"căn hộ gần biển đà nẵng"
"căn hộ ngũ hành sơn"
"chung cư cao cấp đà nẵng"
"căn hộ đà nẵng 2 tỷ"
"căn hộ đà nẵng 3 tỷ"
```

**Nhóm 4 – Đầu tư**
```
"đầu tư căn hộ đà nẵng"
"mua căn hộ đầu tư đà nẵng"
"căn hộ đà nẵng sinh lời"
"bất động sản đà nẵng đầu tư"
```

### Từ khóa phủ định (thêm ở cấp chiến dịch)
Vào **Từ khóa**, chọn **Từ khóa phủ định**, rồi **+**, chọn **Thêm từ khóa phủ định vào chiến dịch**, dán:
```
thuê
cho thuê
theo ngày
theo tháng
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
lừa đảo
review
hình ảnh
vinhomes
novaland
```
> "vinhomes", "novaland" là tên dự án khác. Nếu anh muốn giành khách đang xem dự án khác thì bỏ 2 từ này, rồi làm một nhóm riêng với ngân sách nhỏ.

---

## Phần 5 – Mẫu quảng cáo

Mỗi nhóm tạo **2 quảng cáo** (Google tự thử bản nào tốt hơn). **Độ mạnh quảng cáo** phải đạt **"Tốt"** hoặc **"Xuất sắc"**.

**URL cuối cùng:** `https://www.sun-fours-tower.com/toa-f2-ads`
**Đường dẫn hiển thị:** `toa-f2` / `uu-dai`

### Quảng cáo A – dùng cho cả 4 nhóm

**15 tiêu đề** (đều ≤ 30 ký tự)
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
- **Ghim** "Sun FourS Tower Đà Nẵng" vào **vị trí 1** (bấm biểu tượng ghim cạnh tiêu đề).
- Với **nhóm 3**, ghim thêm "Vay 70% – Lãi Suất 0% 24 Tháng" vào **vị trí 2**.

**4 mô tả** (đều ≤ 90 ký tự)
```
Tòa F2 Sun FourS Tower: vay 70%, hỗ trợ lãi suất 0% 24 tháng. Cọc chỉ 100 triệu.
607 căn đủ điều kiện bán (VB 17239/SXD-QLN), Techcombank bảo lãnh. Xem hồ sơ ngay.
Chiết khấu cộng dồn tới 19% khi thanh toán sớm trước 25/10/2026. Nhận giá từng căn.
Cách biển ~2 km, 10 phút ra sân bay. Căn sân vườn riêng tầng 2–7, số lượng có hạn.
```

### Quảng cáo B – nhấn vào pháp lý và an toàn (cho khách kỹ tính)
Dùng 15 tiêu đề như trên, **đổi 4 mô tả** thành:
```
Pháp lý rõ: VB 17239/SXD-QLN đủ điều kiện bán, sổ đỏ CP 912579. Hồ sơ gửi qua Zalo.
Techcombank cam kết bảo lãnh cho người mua. HĐMB theo mẫu đã đăng ký Sở Công Thương.
Hỏi gì cũng có trả lời kèm văn bản căn cứ – 59 câu hỏi đáp, trợ lý trả lời 24/7.
Căn hộ Sun Group cách biển 2 km. Vay 70%, chỉ 25% vốn đến khi nhận nhà 05/2028.
```

---

## Phần 6 – Thành phần quảng cáo (tiện ích): tăng tỷ lệ nhấp 10–20%

Vào **Quảng cáo**, chọn **Thành phần**, rồi **+**.

**1. Đường liên kết trang web** (thêm ít nhất 4):

| Văn bản liên kết | Dòng mô tả 1 | Dòng mô tả 2 | URL |
|---|---|---|---|
| `Giỏ hàng căn trống` | `Lọc theo loại căn, giá, view` | `Cập nhật hằng ngày` | `https://www.sun-fours-tower.com/gio-hang` |
| `Hồ sơ pháp lý` | `Đủ điều kiện bán, sổ đỏ` | `Techcombank bảo lãnh` | `https://www.sun-fours-tower.com/phap-ly` |
| `Tính vốn vay 70%` | `Lịch thanh toán theo ngày` | `So sánh 5 phương án` | `https://www.sun-fours-tower.com/bang-tinh-f2` |
| `Hỏi đáp 59 câu` | `Trả lời kèm văn bản căn cứ` | `Trợ lý trả lời 24/7` | `https://www.sun-fours-tower.com/hoi-dap` |

**2. Chú thích** (mỗi dòng ≤ 25 ký tự):
```
Cọc chỉ 100 triệu
Miễn phí quản lý 2 năm
Techcombank bảo lãnh
Lãi suất 0% 24 tháng
Cách biển 2 km
Căn sân vườn riêng
```

**3. Đoạn nội dung có cấu trúc:** tiêu đề **"Loại"**, nhập: `Studio`, `1PN`, `1PN+`, `2PN`, `3PN`, `Căn sân vườn`.

**4. Cuộc gọi:** số `0904 567 009`, lịch **07:00–22:00**.

**5. Hình ảnh:** tải lên 4–6 ảnh phối cảnh dự án (ảnh vuông 1:1 và ảnh ngang 1.91:1). Không chèn chữ lên ảnh.

---

## Phần 7 – Ngân sách và giá thầu theo giai đoạn

| Giai đoạn | Thời gian | Ngân sách/ngày | Chiến lược giá thầu | Mục tiêu |
|---|---|---|---|---|
| **Thu thập dữ liệu** | Ngày 1–14 | 500.000 – 700.000 ₫ | Tối đa hóa lượt nhấp, giới hạn CPC 20.000 ₫ | Có 15–30 lead, lọc từ khóa rác |
| **Tối ưu** | Khi đạt ≥ 15 lead/30 ngày | Giữ nguyên | **Tối đa hóa lượt chuyển đổi** (không đặt CPA) | Google tự tìm người dễ để số |
| **Mở rộng** | Khi đạt ≥ 30 lead/30 ngày | Tăng 20%/tuần | Tối đa hóa chuyển đổi + **CPA mục tiêu** = CPA thực tế × 1,1 | Tăng số lead, giữ chi phí |

> ⚠️ Chi phí mỗi lượt nhấp (CPC) và mỗi lead (CPL) ở bảng dưới chỉ là **ước tính tham khảo** cho căn hộ tại Đà Nẵng. Số thật phụ thuộc mức độ cạnh tranh, cần xem sau 7 ngày chạy.
> - CPC tham khảo: **8.000 – 25.000 ₫**
> - Nếu trang chuyển đổi khoảng 5%, CPL khoảng **200.000 – 500.000 ₫**/số điện thoại

**Quy tắc khi đổi chiến lược:** mỗi lần đổi chờ ít nhất **7 ngày** mới đánh giá. Không đổi liên tục, vì Google cần thời gian học.

---

## Phần 8 – Tiếp thị lại: bám theo khách đã vào trang mà chưa để số

1. **Công cụ** → **Trình quản lý đối tượng** → **Phân khúc của bạn** → **+**, chọn **Khách truy cập trang web**.
   - Tên: `Khach vao trang Ads – 30 ngay`
   - Trang truy cập: **URL chứa** `toa-f2-ads`
   - Thời hạn thành viên: **30 ngày**
2. Khi đối tượng có **≥ 1.000 người** (thường sau 1–3 tuần), tạo chiến dịch **Demand Gen** (hoặc **Hiển thị**) chỉ nhắm đối tượng này.
   - Ngân sách: 100.000 – 200.000 ₫/ngày
   - Nội dung: "Còn 19% chiết khấu đến 25/10 – Nhận bảng giá qua Zalo"
3. Loại trừ người đã để số: tạo thêm đối tượng **"Đã chuyển đổi"** rồi đặt làm **loại trừ**.

---

## Phần 9 – Lịch theo dõi và tối ưu

### Mỗi ngày (10 phút)
- [ ] **Từ khóa** → **Cụm từ tìm kiếm**: cụm nào không liên quan (thuê, việc làm, dự án khác…) thì tích chọn, rồi **Thêm làm từ khóa phủ định**.
- [ ] Đọc lead trên **Telegram**: nội dung chat cho biết khách hỏi gì. Gọi lại trong 15 phút.
- [ ] Xem ngân sách có bị **"Bị giới hạn bởi ngân sách"** sớm trong ngày không. Nếu có, tăng ngân sách hoặc hạ giá thầu.

### Mỗi tuần
- [ ] **Từ khóa:** từ khóa tiêu > 1.000.000 ₫ mà **0 lead** thì **tạm dừng**. Từ khóa có lead với CPL tốt thì tăng giá thầu 10–20%.
- [ ] **Quảng cáo:** quảng cáo A hay B có tỷ lệ chuyển đổi cao hơn? Bản yếu thì thay 3–4 tiêu đề mới.
- [ ] **Thiết bị:** nếu điện thoại ra lead rẻ hơn hẳn, tăng giá thầu điện thoại +15%.
- [ ] **Giờ:** xem **Lịch quảng cáo**, giờ nào ra lead thì tăng +15%, giờ không ra thì giảm −30%.
- [ ] **Vị trí:** Hà Nội / TP.HCM / Đà Nẵng, nơi nào CPL tốt thì tăng giá thầu.
- [ ] **Điểm chất lượng** (thêm cột "Điểm chất lượng" trong Từ khóa): từ khóa < 5 điểm thì viết thêm tiêu đề chứa đúng từ khóa đó.

### Chỉ số cần đạt

| Chỉ số | Tốt | Cần sửa nếu |
|---|---|---|
| CTR nhóm Thương hiệu | > 10% | < 5% |
| CTR các nhóm khác | > 4% | < 2% |
| Tỷ lệ chuyển đổi trang | > 5% | < 2% → báo Claude xem lại trang |
| Điểm chất lượng | ≥ 7 | ≤ 4 |
| Tỷ lệ hiển thị bị mất do ngân sách | < 20% | > 40% |

---

## Phần 10 – Lỗi hay gặp và chính sách

1. **Hết ưu đãi 25/10/2026:** ngày 25/10 **phải sửa** tiêu đề "Chiết Khấu Tới 19%" và mô tả có "trước 25/10/2026". Google từ chối quảng cáo có nội dung không còn đúng với trang, và khách thấy sai sẽ mất niềm tin. Báo Claude cập nhật trang cùng lúc.
2. **Không hứa lợi nhuận:** không viết "lãi chắc chắn", "cam kết sinh lời", "x2 tài sản", vì Google dễ từ chối và vi phạm quy định quảng cáo BĐS.
3. **"Lãi suất 0%"** phải đi kèm điều kiện trên trang (vay 70%, tối đa 24 tháng, ngân hàng chỉ định). Trang đã ghi đủ.
4. **Quảng cáo "Bị từ chối" hoặc "Hạn chế":** bấm vào trạng thái để xem lý do, sửa đúng chữ vi phạm rồi gửi lại. Không tạo lại quảng cáo mới.
5. **Không thấy chuyển đổi sau 48 giờ:** kiểm tra lại Phần 1.4, hoặc nhắn Claude kiểm tra mã trên trang.
6. **Nhiều lead rác** (số sai, không nghe máy):
   - Thêm từ khóa phủ định.
   - Bỏ vị trí "quan tâm đến".
   - Cân nhắc chuyển mục tiêu tối ưu sang chỉ **Lead** (bỏ bấm gọi, bấm Zalo khỏi mục tiêu chính).

---

## Phần 11 – Nâng cao (khi đã có trên 50 lead)

- **Nhập chuyển đổi ngoại tuyến:** CRM đã lưu **gclid** của từng khách đến từ Google Ads. Khi khách **đi xem nhà mẫu** hoặc **đặt cọc**, tải danh sách gclid kèm ngày lên **Mục tiêu** → **Chuyển đổi** → **Tải lên**. Google sẽ học cách tìm **khách đặt cọc thật**, không chỉ người để số. Đây là cách tối ưu hiệu quả nhất cho BĐS.
- **Chiến dịch Performance Max:** chỉ thử khi chiến dịch Tìm kiếm đã ổn định, có ≥ 30 lead/tháng. Bắt đầu với 30% ngân sách.

---

## Tóm tắt lịch làm việc

| Ngày | Việc |
|---|---|
| **Ngày 0** | Phần 0 → 6. **Gửi Claude 3 nhãn chuyển đổi.** Xuất bản trang. Kiểm tra bằng Tag Assistant. |
| **Ngày 1–7** | Mỗi ngày lọc cụm từ tìm kiếm, thêm phủ định. Gọi lead trong 15 phút. |
| **Ngày 7** | Tạm dừng từ khóa tốn tiền mà không có lead. Xem quảng cáo A/B. |
| **Ngày 14** | Đủ 15 lead thì chuyển sang **Tối đa hóa lượt chuyển đổi**. Tạo đối tượng tiếp thị lại. |
| **Ngày 21–30** | Đặt CPA mục tiêu. Tăng ngân sách 20%/tuần cho nhóm hiệu quả. Chạy tiếp thị lại. |
| **25/10/2026** | Sửa quảng cáo và trang theo chính sách mới. |
