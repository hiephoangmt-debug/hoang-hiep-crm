# CRM Thẻ Tín Dụng Đà Nẵng

CRM cho mảng đáo hạn / rút tiền thẻ tín dụng, chạy miễn phí trên **Google Sheets + Apps Script**. Dữ liệu nằm trong Google Drive của bạn.

- **Khách từ website:** form của 2 website gửi thẳng vào CRM (mục *Khách hàng → Liên hệ từ web*), kèm email báo ngay.
- **Sổ giao dịch:** thay sổ tay, gồm Ngày, Dịch vụ, Thẻ, Ngày đáo, Ngày sao kê, Tên, Số tiền, Máy, Phí khách / Phí máy.
  - **Phí của mình = phí khách − phí máy**, CRM tự tính.
  - Gõ số tiền như sổ tay: `8.999` = 8.999.000đ, `110tr` = 110.000.000đ. Phí máy cộng dồn được: `1.36+0.4`.
- **Công nợ C.Trâm (người giữ máy):** mỗi giao dịch tự tính **Tiền hoàn = Số tiền (rút/đáo) − Phí máy**; làm hôm nay thì mai C.Trâm hoàn (ngày hoàn sửa được trong form).
  - C.Trâm chuyển tiền hay **ứng trước** một số tròn (VD ngày làm 500 triệu, ứng trước 300 triệu) thì bấm **+ Ghi tiền**, không cần khớp từng giao dịch. CRM trừ dần vào các khoản cũ nhất.
  - **Số dư** = tổng tiền hoàn − tổng C.Trâm đã chuyển/ứng: dương là C.Trâm còn phải chuyển, âm là C.Trâm đang ứng dư (trừ vào giao dịch sau).
  - **Sổ đối chiếu** theo ngày: làm bao nhiêu, phí máy, tiền hoàn phát sinh, C.Trâm chuyển/ứng, số dư lũy kế. Loại tiền: Ứng trước, Hoàn tiền, Mình trả lại, Điều chỉnh số dư (nhập số dư đầu kỳ).
- **Nhắc lịch:**
  - **Đáo hạn:** nhắc từ **7 đến 5 ngày trước hạn** tháng sau. Hạn rơi vào T7, CN, lễ hoặc Tết thì dời ±1–2 ngày: mặc định dời lên trước, thẻ nào ngân hàng dời ra sau thì khai trong Cài đặt.
  - **Rút tiền:** tư vấn khách rút **ngay sau ngày sao kê** để được miễn lãi tối đa khoảng 55 ngày. Form tính sẵn số ngày miễn lãi, và tháng sau CRM nhắc gọi khách trước 2 ngày.
  - Mỗi sáng 7h CRM gửi email danh sách khách cần báo và tạo sự kiện **Google Calendar** để điện thoại tự báo.
- **Báo cáo:** theo **tuần / tháng / năm**: số giao dịch, số tiền, phí khách, phí máy, phí của mình, khách mới, khách web. Có thêm bảng theo dịch vụ, máy POS, thẻ và top khách. Bấm vào một kỳ để xem từng giao dịch.

## Cài đặt (khoảng 10 phút, làm 1 lần)

1. Vào [sheets.new](https://sheets.new) để tạo Google Sheet mới, đặt tên `CRM Thẻ Tín Dụng`.
2. Trong Sheet chọn **Tiện ích mở rộng → Apps Script**.
3. Trong trình soạn Apps Script:
   - Mở file `Code.gs`, xóa hết rồi dán nội dung [`apps-script/Code.gs`](apps-script/Code.gs).
   - Bấm **+ → HTML**, đặt tên `Index`, dán nội dung [`apps-script/Index.html`](apps-script/Index.html).
   - Vào **Cài đặt dự án** (bánh răng), bật *Hiển thị tệp kê khai "appsscript.json"*, rồi dán nội dung [`apps-script/appsscript.json`](apps-script/appsscript.json).
   - Bấm **Lưu**.
4. Chọn hàm **`setup`** ở thanh trên, bấm **Chạy** và cấp quyền khi Google hỏi: Sheet, gửi email, Calendar, chạy theo lịch.
   Xem **Nhật ký thực thi**: dòng `Mã PIN đăng nhập CRM: ......` là mã PIN của bạn.
5. Bấm **Triển khai → Tùy chọn triển khai mới → Ứng dụng web**:
   - *Thực thi dưới dạng*: **Tôi**
   - *Người có quyền truy cập*: **Bất kỳ ai**
   - Bấm **Triển khai** và chép **URL ứng dụng web** (dạng `https://script.google.com/macros/s/…/exec`).
6. Mở URL đó trên điện thoại, nhập PIN, rồi chọn *Thêm vào màn hình chính* để dùng như một app.

> **Bảo mật:** để website gửi được khách vào, quyền truy cập phải là "Bất kỳ ai". Phần quản lý được bảo vệ bằng mã PIN: sai 5 lần sẽ bị khóa 15 phút, phiên đăng nhập hết hạn sau 6 giờ. Không chia sẻ URL và PIN. Đổi PIN trong mục **Cài đặt**.

### Kết nối 2 website

- **Website `the-tin-dung-da-nang`** (trong repo này): mở `the-tin-dung-da-nang/script.js`, điền URL ở bước 5 vào `var CRM_URL = '';`, rồi cập nhật trang lên LadiPage và xuất bản lại.
- **Website làm bằng LadiPage** (form kéo-thả): chọn form → **Cấu hình → Tích hợp / Webhook (API URL)**, dán URL ở bước 5. CRM tự nhận các trường tên / số điện thoại / dịch vụ / ghi chú (`name`, `phone`, `ho_ten`, `so_dien_thoai`, `service`, `note`, `message`…).
- **Website khác:** gửi `POST` tới URL với JSON `{"name","phone","service","note","source"}` hoặc form-urlencoded.

### Nhập sổ cũ

Vào **Cài đặt → Nhập sổ cũ**, dán từ Excel/Google Sheets, mỗi dòng một giao dịch:

```
Ngày | Dịch vụ | Thẻ | Ngày đáo | Tên | Số tiền | Máy | Phí khách | Phí máy | SĐT | Ghi chú | Ngày sao kê
3/1    ĐH        SC    4          C.Nhi  17.983   VP Phượng 1.7       1.36
3/1    ĐH/Rút    Exim             Chú Ái 110tr    MBV NTĐ   1.6       1.32
```

### Cập nhật phiên bản

Dán lại `Code.gs` / `Index.html`, rồi vào **Triển khai → Quản lý triển khai → ✏️ → Phiên bản: Mới → Triển khai**. URL giữ nguyên.

## Cấu trúc dữ liệu (các sheet)

| Sheet | Nội dung |
|---|---|
| `KhachHang` | id, tên, SĐT, nguồn (website / nhập tay), trạng thái (Mới, Đang tư vấn, Khách quen, Không tiềm năng), ghi chú |
| `LienHe` | mỗi lần khách để lại thông tin trên website |
| `GiaoDich` | sổ giao dịch, kèm tiền phí khách, chi phí máy, phí của mình, tiền hoàn (`tien_hoan`), ngày hoàn, đã nhận / chưa nhận. Cột mới được tự thêm vào cuối khi mở CRM. |
| `DoiSoat` | tiền C.Trâm chuyển / ứng trước / mình trả lại / điều chỉnh (tự tạo khi cập nhật) |
| `NhacLich` | trạng thái nhắc (Đã báo / Ngưng nhắc) và sự kiện Calendar đã tạo |

Có thể xem và lọc trực tiếp trong Google Sheet, nhưng **không đổi tên cột hay thứ tự cột**.

## Phát triển

```bash
node crm/test/server.test.js                 # test backend với Google Sheets giả lập
node crm/test/build-preview.js preview.html  # bản xem thử chạy trong trình duyệt, PIN 123456, dữ liệu mẫu
```
