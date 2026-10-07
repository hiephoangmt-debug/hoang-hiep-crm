# Hướng dẫn cài đồng bộ Thu Chi (Google Sheets) – từng bước

Cài **một lần trên máy tính**, mất khoảng 10 phút. Không phải sửa code, chỉ cần dán một lần.

---

## BƯỚC 1 – Lấy đoạn code
1. Trên máy tính, mở link sau bằng Chrome:
   **https://raw.githubusercontent.com/hiephoangmt-debug/hoang-hiep-crm/claude/quirky-knuth-tncnth/thu-chi/apps-script/Code.gs**
2. Trang chỉ có chữ (code). Bấm **Ctrl + A** để chọn hết, rồi **Ctrl + C** để sao chép.
   (Máy Mac: **⌘ + A**, rồi **⌘ + C**.)

## BƯỚC 2 – Tạo Google Sheet
1. Mở tab mới, vào **https://sheets.google.com** và đăng nhập Gmail của mẹ.
2. Bấm **Trang tính trống** (ô có dấu **+** lớn).
3. Bấm chữ "Bảng tính không có tiêu đề" ở góc trái và đặt tên: **Thu Chi Mẹ Vân**.

## BƯỚC 3 – Dán code vào Apps Script
1. Trên thanh menu của Sheet, bấm **Tiện ích mở rộng** → **Apps Script**. Một tab mới mở ra.
2. Trong khung soạn code có sẵn mấy dòng `function myFunction() {...}`:
   - bấm vào khung code;
   - **Ctrl + A** để chọn hết, rồi bấm phím **Delete** để xóa;
   - **Ctrl + V** để dán code đã sao chép ở Bước 1.
3. Bấm biểu tượng **💾 (Lưu dự án)**, hoặc **Ctrl + S**.

## BƯỚC 4 – Triển khai thành ứng dụng web
1. Góc trên bên phải, bấm nút xanh **Triển khai** → **Tùy chọn triển khai mới**.
2. Cạnh chữ "Chọn loại", bấm **⚙ (bánh răng)** → chọn **Ứng dụng web**.
3. Điền như sau:
   - **Mô tả:** Thu chi
   - **Thực thi với tư cách:** **Tôi (email của mẹ)**
   - **Người có quyền truy cập:** **Bất kỳ ai**
4. Bấm **Triển khai**.
5. Google yêu cầu cấp quyền. Bấm **Cấp quyền truy cập** → chọn tài khoản Gmail của mẹ.
   - Nếu hiện **"Google chưa xác minh ứng dụng này"**: bấm **Nâng cao** (chữ nhỏ bên dưới) → **Đi tới Dự án không có tiêu đề (không an toàn)** → **Cho phép**.
     Script này là của chính nhà mình, chỉ đọc và ghi vào Sheet này.
6. Hiện ra **URL ứng dụng web** (bắt đầu bằng `https://script.google.com/macros/s/` và kết thúc bằng `/exec`). Bấm **Sao chép**, rồi **Xong**.

## BƯỚC 5 – Mở app và đặt mã bảo mật
1. Dán URL vừa sao chép vào thanh địa chỉ của Chrome rồi bấm Enter. App Thu Chi hiện ra.
   (Dòng chữ xám phía trên "Ứng dụng này do người dùng Google Apps Script tạo" là bình thường.)
2. Bấm nút **☁ Chưa đồng bộ** ở góc trên.
3. Ô **Địa chỉ đồng bộ** đã được điền sẵn.
4. Ô **Mã bảo mật**: **tự nghĩ một mã** từ 6 ký tự trở lên, ví dụ `vanmon2026`. **Ghi mã này ra giấy.**
   Lần kết nối đầu tiên, mã này trở thành mã của cả nhà.
5. Bấm **Kết nối**. Góc trên đổi thành **☁ Đã đồng bộ hh:mm** là xong.
   Mở lại tab Google Sheet sẽ thấy 2 bảng mới: **Sổ thu chi** và **Tổng hợp tháng**.

## BƯỚC 6 – Cài trên điện thoại (mẹ, bố, người nhà)
1. Gửi **URL ở Bước 4** qua Zalo, rồi bấm mở trên điện thoại.
2. Bấm **☁ Chưa đồng bộ** → nhập **đúng mã bảo mật** ở Bước 5 → **Kết nối**.
3. App hỏi "Google Sheet đã có … giao dịch" → bấm **OK**.
4. Đưa app ra màn hình chính để lần sau mở nhanh:
   - **iPhone:** mở link bằng **Safari** → nút **Chia sẻ** (ô vuông có mũi tên lên) → **Thêm vào MH chính**.
   - **Android:** mở bằng **Chrome** → nút **⋮** → **Thêm vào màn hình chính**.

✅ **Xong!** Từ giờ nhập ở máy nào thì các máy khác cũng tự cập nhật, chậm nhất khoảng 30 giây.

---

## Gặp lỗi?

| Thông báo | Cách xử lý |
|---|---|
| "Địa chỉ đồng bộ không đúng hoặc chưa cấp quyền…" | Làm lại Bước 4, chú ý chọn **Bất kỳ ai**. URL phải kết thúc bằng `/exec`. |
| "Sai mã bảo mật" | Nhập lại đúng mã (phân biệt chữ hoa, chữ thường). |
| Quên mã bảo mật | Vào Apps Script → ô chọn hàm phía trên chọn **xoaMaBaoMat** → bấm **▶ Chạy**. Sau đó Kết nối lại trong app với mã mới; mã mới cần nhập lại trên mọi máy. |
| Trang trắng, không hiện app | Đợi vài giây rồi tải lại trang. Nếu vẫn lỗi, kiểm tra Bước 3 đã bấm **Lưu** chưa, rồi làm lại Bước 4. |
| Sửa code xong nhưng app chưa đổi | **Triển khai → Quản lý các bản triển khai** → ✏ → Phiên bản: **Phiên bản mới** → **Triển khai**. URL giữ nguyên. |

## Lưu ý
- Hai bảng **Sổ thu chi** và **Tổng hợp tháng** trong Google Sheet chỉ để **xem**. Thêm, sửa, xóa hãy làm trong app.
- **Không xóa sheet ẩn `_data`**, vì đó là nơi chứa dữ liệu thật.
- Mất mạng vẫn nhập được, có mạng lại app tự đồng bộ.
- Khi app có bản mới trên GitHub, app trong Sheet tự cập nhật trong vòng 6 giờ, không cần làm gì.

---

## Cập nhật app lên bản mới
App tự lấy bản mới từ GitHub. Muốn có bản mới **ngay** thì làm như sau:
- **Cách nhanh:** mở link app, thêm `?capnhat=1` vào cuối (ví dụ `https://script.google.com/macros/s/…/exec?capnhat=1`) rồi bấm Enter.
  Cách này chỉ dùng được khi Apps Script đã có code mới nhất (xem cách đầy đủ bên dưới).
- **Cách đầy đủ** (làm khi code Apps Script là bản cũ, trước ngày 04/10/2026):
  1. Mở lại link code ở Bước 1, Ctrl+A, Ctrl+C.
  2. Trong Apps Script: bấm vào khung code, Ctrl+A, Ctrl+V, rồi **Ctrl+S**.
  3. **Triển khai → Quản lý các bản triển khai** → bấm ✏ → mục Phiên bản chọn **Phiên bản mới** → **Triển khai**.
  4. Tải lại trang app (trên điện thoại: đóng app rồi mở lại).

Dữ liệu cũ vẫn giữ nguyên. Link app không đổi.

## Nhập dữ liệu các tháng trước
1. Bấm ◀ ở góc trên để lùi về tháng cần nhập (ví dụ Tháng 7/2026).
2. Bấm **📷 Nhập tháng 7/2026**, hoặc vào tab Lịch sử → **⬆ Nhập từ Excel**.
3. Chọn một trong 3 cách:
   - **Dán từ Excel:** bôi đen bảng → Ctrl+C → dán vào ô. Chính xác 100%.
   - **Chọn file Excel:** chọn file .xlsx (có nhiều sheet thì chọn sheet của tháng đó).
   - **📷 Chụp ảnh / 🖼 Chọn ảnh:** app tự đọc chữ, nhưng **phải kiểm tra lại số tiền**. Nếu ảnh có dòng TỔNG CỘNG, app sẽ báo ✓ khi khớp hoặc ⚠ khi lệch.
4. Xem bảng xem trước, sửa chỗ sai, rồi bấm **Nhập**.

Ghi chú:
- Dòng không ghi ngày sẽ lấy theo ô "Tháng". Nếu ảnh có tiêu đề "THU CHI THÁNG x/yyyy", app tự lấy tháng đó.
- Khoản đã có trong app sẽ tự được bỏ chọn, nên nhập lại cũng không bị trùng.

---

## Đăng nhập bằng Gmail (không cần mã bảo mật)
Sau khi cài, người có email trong danh sách chỉ cần đăng nhập Google là dùng được app. Email `hiephoangmt@gmail.com` đã có sẵn trong danh sách. Chủ Google Sheet luôn được phép.

**Làm 1 lần trên máy tính, bằng tài khoản chủ Google Sheet:**
1. **Dán code mới:** mở link code ở Bước 1 → Ctrl+A, Ctrl+C → vào Apps Script, bấm **Mã.gs** → Ctrl+A, Ctrl+V → **Ctrl+S**.
   - Muốn thêm người khác thì sửa danh sách ở đầu code:
     ```js
     const NGUOI_DUNG = [
       'hiephoangmt@gmail.com',
       'email-khac@gmail.com',
     ];
     ```
2. **Đổi cách triển khai:** Triển khai → Quản lý các bản triển khai → ✏, rồi chọn:
   - **Thực thi với tư cách:** `Người dùng truy cập ứng dụng web`
   - **Người có quyền truy cập:** `Bất kỳ ai có Tài khoản Google`
   - **Phiên bản:** `Phiên bản mới` → **Triển khai**
3. **Chia sẻ Google Sheet:** mở Google Sheet "Thu Chi Mẹ Vân" → nút **Chia sẻ** (góc trên phải) → nhập `hiephoangmt@gmail.com` → quyền **Người chỉnh sửa** → **Gửi**.
   Ở chế độ đăng nhập Gmail, mỗi người chỉ đọc/ghi được dữ liệu khi đã được chia sẻ Sheet.

**Người được thêm (ví dụ hiephoangmt@gmail.com):**
1. Mở link app → đăng nhập Gmail nếu Google hỏi.
2. Lần đầu Google hỏi cấp quyền: **Xem xét quyền → chọn Gmail → Nâng cao → Đi tới … (không an toàn) → Cho phép**.
3. Góc trên hiện **☁ Đã đồng bộ · hiephoangmt** là xong. Vào Cài đặt sẽ thấy dòng "✓ Đã đăng nhập Google".

**Lưu ý:**
- Nếu trình duyệt đang đăng nhập **nhiều tài khoản Google** cùng lúc, Google đôi khi nhận nhầm tài khoản. Khi đó mở link bằng cửa sổ chỉ đăng nhập 1 tài khoản, hoặc dùng mã bảo mật.
- Mã bảo mật vẫn dùng được, nhưng ở chế độ này người dùng mã vẫn phải được chia sẻ Sheet.
- Nếu không đổi cách triển khai ở bước 2 (vẫn "Thực thi với tư cách: Tôi"), app vẫn chạy như cũ bằng mã bảo mật.
