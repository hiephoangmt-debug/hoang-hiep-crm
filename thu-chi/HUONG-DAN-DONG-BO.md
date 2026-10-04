# Hướng dẫn đồng bộ dữ liệu Thu Chi (Google Sheets)

Sau khi cài xong, cả nhà mở **cùng một đường link** trên điện thoại và máy tính. Dữ liệu tự đồng bộ: khi lưu và khoảng 30 giây một lần khi đang mở app. Toàn bộ dữ liệu nằm trong Google Sheet của mẹ, có sẵn bảng **"Sổ thu chi"** và **"Tổng hợp tháng"** để xem như Excel.

Thời gian cài: khoảng 10 phút, chỉ làm **một lần**, trên máy tính.

---

## Bước 1 – Tạo Google Sheet
1. Vào <https://sheets.google.com> (đăng nhập Gmail của mẹ) → **Trang tính trống**.
2. Đặt tên, ví dụ: `Thu Chi Mẹ Vân`.

## Bước 2 – Mở Apps Script và dán code
1. Trong Sheet: menu **Tiện ích mở rộng → Apps Script**.
2. Ở file `Code.gs`: xóa hết nội dung cũ, dán toàn bộ nội dung file **`thu-chi/apps-script/Code.gs`**.
3. Sửa dòng:
   ```js
   const MA_BAO_MAT = 'doi-ma-nay-thanh-ma-rieng-cua-nha-minh';
   ```
   thành một mã riêng, dài và khó đoán, ví dụ `'vanmon-2026-ab83kq'`. **Ghi lại mã này**, vì sẽ cần nhập trên mỗi máy.
4. Bấm dấu **＋** cạnh "Tệp" → **HTML** → đặt tên đúng là **`Index`** (không gõ đuôi `.html`).
   Xóa nội dung mặc định, dán toàn bộ nội dung file **`thu-chi/index.html`**.
5. Bấm **💾 Lưu** (Ctrl+S).

## Bước 3 – Chạy cài đặt và cấp quyền
1. Ở thanh trên cùng, chọn hàm **`caiDat`** → bấm **▶ Chạy**.
2. Google hỏi quyền → **Xem xét quyền** → chọn tài khoản của mẹ.
3. Nếu hiện "Google chưa xác minh ứng dụng này": bấm **Nâng cao → Đi tới … (không an toàn)** → **Cho phép**.
   (Đây là script do chính mình tạo, chỉ đọc/ghi Sheet này.)
4. Nhật ký hiện "Đã cài đặt xong" là được.

## Bước 4 – Triển khai thành ứng dụng web
1. Bấm **Triển khai → Tùy chọn triển khai mới**.
2. Bấm ⚙ cạnh "Chọn loại" → **Ứng dụng web**.
3. Điền:
   - **Thực thi với tư cách:** `Tôi`
   - **Người có quyền truy cập:** `Bất kỳ ai`
     (cần chọn mục này để điện thoại mở được mà không phải đăng nhập. Dữ liệu vẫn được bảo vệ bằng mã bảo mật.)
4. Bấm **Triển khai** → sao chép **URL ứng dụng web** (dạng `https://script.google.com/macros/s/…/exec`).

## Bước 5 – Mở app và kết nối
1. Mở URL vừa sao chép bằng trình duyệt.
2. Bấm nút **☁ Chưa đồng bộ** ở góc trên (hoặc vào tab **Cài đặt**).
3. Ô **Địa chỉ đồng bộ** đã được điền sẵn. Nhập **Mã bảo mật** → bấm **Kết nối**.
4. Thấy **☁ Đã đồng bộ hh:mm** là xong. Dữ liệu tháng 8/2026 có sẵn sẽ được đưa lên Sheet.

## Bước 6 – Dùng trên điện thoại (và máy của người khác trong nhà)
1. Gửi URL qua Zalo cho mình hoặc cho người nhà, rồi mở trên điện thoại.
2. Vào **Cài đặt** → nhập **Mã bảo mật** → **Kết nối**.
   Khi app hỏi "Google Sheet đã có … giao dịch", bấm **OK** để dùng dữ liệu trên Sheet.
3. Thêm vào màn hình chính để mở nhanh như một app:
   - **iPhone (Safari):** nút Chia sẻ → **Thêm vào MH chính**.
   - **Android (Chrome):** menu ⋮ → **Thêm vào màn hình chính**.

---

## Câu hỏi thường gặp

**Mất mạng thì sao?**
Vẫn ghi được bình thường, vì dữ liệu luôn được lưu trên máy. Khi có mạng lại, app tự đồng bộ. Trong lúc mất mạng, góc trên hiện "⚠ Mất mạng – sẽ đồng bộ lại".

**Hai người cùng nhập một lúc có mất dữ liệu không?**
Không. App tự gộp dữ liệu: khoản thêm ở máy nào cũng được giữ, khoản xóa ở máy nào cũng bị xóa. Nếu hai máy cùng sửa **một** khoản, bản sửa sau cùng được giữ.

**Sửa trực tiếp trong Google Sheet được không?**
Sheet "Sổ thu chi" và "Tổng hợp tháng" **chỉ để xem**, vì được ghi đè sau mỗi lần đồng bộ. Mọi thay đổi hãy làm trong app. **Không xóa hoặc sửa sheet ẩn `_data`**, vì đó là nơi chứa dữ liệu thật.

**Cập nhật app khi có phiên bản mới?**
Dán nội dung `index.html` mới vào file `Index` trong Apps Script → **Triển khai → Quản lý các bản triển khai** → ✏ → Phiên bản: **Phiên bản mới** → **Triển khai**. URL giữ nguyên.

**Đổi mã bảo mật?**
Sửa `MA_BAO_MAT` → chạy lại `caiDat` → nhập mã mới trên từng máy (Cài đặt → Ngắt kết nối → Kết nối).

**Sao lưu?**
Google Sheet có sẵn lịch sử phiên bản (Tệp → Nhật ký phiên bản). Mẹ cũng có thể bấm **Tải bản sao lưu (.json)** trong tab Cài đặt.

**Báo "Địa chỉ đồng bộ không đúng hoặc chưa cấp quyền 'Bất kỳ ai'"?**
Kiểm tra lại Bước 4: phải chọn **Bất kỳ ai**, và URL phải kết thúc bằng `/exec`.

**Báo "Sai mã bảo mật"?**
Nhập lại đúng mã đã đặt ở Bước 2 (phân biệt chữ hoa, chữ thường).
