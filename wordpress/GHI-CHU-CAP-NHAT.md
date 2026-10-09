# Gói cập nhật hiephoangmt.com – 09/10/2026

**File cài:** `hoang-hiep-tron-goi.zip` (giao diện Hoàng Hiệp **2.13.2** + plugin Hoàng Hiệp CRM **2.20.13**) · cập nhật nhanh bằng điện thoại: `cap-nhat-nhanh.zip`
**Xem trước:** https://claude.ai/artifact/ACKuFhbbb8yj5VoU8Ty9X7 (riêng tư – bấm Chia sẻ nếu muốn gửi người khác)

## Cài đặt từng bước (khoảng 10 phút)

Hình minh hoạ từng bước: thư mục `huong-dan/` (cai-1 … cai-4, interdata-cpanel).

### Bước 1 – Vào cPanel từ trang InterData
1. Đăng nhập trang khách hàng **InterData**.
2. Khung **Quản lý dịch vụ**, dòng *hiephoangmt.com* → bấm **Đăng nhập vào cPanel** (nút trắng).
   Không bấm *Edit with Sitejet Builder* / *Edit Website* – đó là công cụ khác.
3. cPanel mở tab mới → kéo xuống mục **Tệp tin** → bấm **Trình quản lý tập tin**
   (hoặc gõ "tệp" vào ô tìm kiếm trên cùng cPanel).

### Bước 2 – Tải file lên
1. Cột trái bấm **public_html** → **wp-content**. Khung phải thấy `plugins`, `themes`, `uploads` là đúng chỗ.
2. Thanh công cụ bấm **Tải lên** (Upload) → chọn `hoang-hiep-tron-goi.zip` → đợi chạy 100% → đóng trang tải lên.

### Bước 3 – Giải nén
1. Quay lại danh sách (bấm **Tải lại** nếu chưa thấy file) → **chuột phải** vào `hoang-hiep-tron-goi.zip` → **Giải nén** (Extract).
2. Đường dẫn phải là `/public_html/wp-content` → bấm **Giải nén tệp**. Hỏi ghi đè → **đồng ý**.
3. Xong có thể xoá file zip cho gọn.

### Bước 4 – Nhập dữ liệu (trang quản trị WordPress)
1. Vào `hiephoangmt.com/wp-admin` → menu trái **Dự án** → **Nhập dữ liệu Đà Nẵng**.
2. Bấm nút xanh **Nhập / cập nhật dữ liệu** → đợi trang báo đã nhập xong (vài giây).
3. Lần đầu có trang mới (Tòa F2, phân khu Hải Vân Bay): **Cài đặt → Đường dẫn tĩnh** → bấm **Lưu**.

### Bước 5 – Xoá bộ nhớ đệm và kiểm tra
1. Thanh đen trên cùng → rê chuột vào **LiteSpeed Cache** → **Purge All** (hoặc menu trái LiteSpeed Cache → Toolbox → Purge All).
2. Mở web, bấm **Ctrl + Shift + R** (điện thoại: tắt hẳn tab, mở lại).
3. Kiểm tra phiên bản: **Plugin → Plugin đã cài**: Hoàng Hiệp CRM **2.18.0** · **Giao diện**: Hoàng Hiệp **2.13.0**.
4. Xem kết quả:
   - **Tin tức** → nút **Nhịp sống Đà Nẵng** → bài bãi tắm Sơn Thủy.
   - **Casamia Balanca Hội An**: ảnh mới ở mục Tiện ích, Hình ảnh, Tiến độ – web đưa ảnh vào dần trong 15–20 phút; chưa đủ thì đợi thêm rồi Purge All lần nữa.
   - `/du-an/fours-tower-f2-thap-mai/`: 4 con số 19% – 25% – 15% – 70%, ảnh phối cảnh hoàng hôn.

Kẹt ở bước nào: chụp màn hình gửi lại.

Ô / bài anh đã tự sửa trong quản trị **không bị ghi đè** khi nhập dữ liệu.

## Có gì mới – plugin 2.20.13: nút "Tải ảnh ngay"

- Trang **Dự án → Nhập dữ liệu Đà Nẵng** hiện "Còn N ảnh dự án chờ tải" kèm nút **Tải ảnh ngay** – bấm là web tải liền (trang tự chạy tiếp tới khi xong), không phải chờ tải ngầm (web có LiteSpeed Cache nên tải ngầm rất chậm).

## Có gì mới – plugin 2.20.11 – 2.20.12: hồ sơ pháp lý Spana Tower

- Ô **Pháp lý** ngắn gọn: "Đủ điều kiện bán (Sở Xây dựng 05/5/2026), bảo lãnh VietinBank, không thế chấp".
- **Điểm nổi bật** liệt kê hồ sơ: VB 7111/SXD-QLN (đủ điều kiện bán), cam kết bảo lãnh VietinBank 07/5/2026, sổ đất ở đô thị lô A1-3 / A1-4, VB 6978/SXD-CPXD (thẩm định FS), QĐ 365 (QHCT 1/500), QĐ 206 (chủ trương đầu tư), TB 1737/TB-SCT (đăng ký HĐMB mẫu).
- Không đăng ảnh / số hiệu giấy chứng nhận, hợp đồng bảo lãnh lên web.

## Có gì mới – plugin 2.20.10: pháp lý Spana Tower theo Bảng công khai thông tin của CĐT

- Trang Spana: chủ đầu tư (CTCP Tập đoàn Mặt Trời), lô A1-3 (S1) 4.163 m² / A1-4 (S2) 3.572 m², mật độ 72% / 71%, 22 tầng + tum, cao 85,95 m, **1.237 căn (S1 661, S2 576)**, pháp lý: đất ở đô thị, Sở Xây dựng xác nhận đủ điều kiện bán (VB 7111/SXD-QLN 05/5/2026), bảo lãnh VietinBank, không thế chấp.
- Sửa số căn cũ "khoảng 1.281" → 1.237 ở trang Sun NeO City và các bài viết Spana (chỉ bài chưa sửa tay).

## Có gì mới – plugin 2.20.9: layout căn hộ Spana Tower

- Mục **Các loại căn hộ** của Spana chia theo từng layout (Studio, 1PN+, 2PN ×4, 3PN ×2, shophouse) có mã căn, diện tích thông thủy / tim tường; 5 căn có ảnh layout (3PN S10801, S20801; 2PN S10811, S10816, S10832) – bấm vào để phóng to.
- Link ảnh (image links) nhận thêm mục **layout** → "Ảnh layout từng loại căn".

## Có gì mới – plugin 2.20.8: Spana Tower đủ mặt bằng S2 + tổng thể

- Thêm mặt bằng S2 – Tầng 2 (tiện ích), S2 – Tầng 3 – 7, S2 – Tầng 8 – 21 (tổng 8 tab) và ảnh mặt bằng tổng thể (Tòa S1, S2 hai bên đường dẫn cầu Hòa Xuân, ven sông Cẩm Lệ).

## Có gì mới – plugin 2.20.7: mặt bằng Spana Tower (Tòa S1, S2)

- Trang **Spana Tower** thêm mặt bằng 5 tab: S1 – Tầng 1 (shophouse), S1 – Tầng 2 (tiện ích), S1 – Tầng 3, S1 – Tầng 3A – 21, S2 – Tầng 1 (shophouse).
- Bảng loại căn có diện tích (Studio 31,6 m², 1PN+ 54,2 m², 2PN 62,2 – 75,1 m², 3PN 95,5 – 96,9 m² thông thủy; shophouse 46,5 – 140,4 m²), tiện ích tầng 2 (bể bơi, gym & spa, co-working, cafe, khu trẻ em). Ô anh đã tự sửa giữ nguyên.

## Có gì mới – plugin 2.20.6: ảnh phối cảnh Spana Tower

- Trang **Spana Tower Hòa Xuân** có 5 ảnh phối cảnh chủ đầu tư (ảnh đại diện bên sông – chân cầu Hòa Xuân, 3 ảnh thư viện, 1 ảnh khối đế thương mại). Bấm **Nhập dữ liệu Đà Nẵng**, ảnh tải ngầm vài phút.

## Có gì mới – plugin 2.20.5: mặt bằng Tòa F2 FourS Tower

- Trang **FourS Tower F2 – Tháp Mai** thêm mục mặt bằng 5 tab: Tầng 3A, Tầng 5, Tầng 6, Tầng 7, Tầng 8 – 19 (bấm ảnh để phóng to). Bấm **Nhập dữ liệu Đà Nẵng**, ảnh tải ngầm vài phút.

## Có gì mới – plugin 2.20.4: Sun Solar có sẵn hình + chính sách trong gói

- Bấm **Dự án → Nhập dữ liệu Đà Nẵng** là trang **Sun Solar Residence** tự có: chính sách CSBH04, bảng giá 34 căn, lịch thanh toán, vay vốn, ưu đãi, và 11 ảnh (đại diện, thư viện, tiện ích, mặt bằng tầng 5 / 6 / 8 – 19). Không cần chọn 3 file gói nữa.
- Ảnh được tải ngầm vào Thư viện vài ảnh mỗi lượt – mở vài trang web hoặc chờ vài phút là đủ ảnh.
- Đã nhập 3 file gói Sun Solar bằng Nhập nhanh trước đó thì phần ảnh tự bỏ qua (không bị trùng).

## Có gì mới – plugin 2.20.3: cập nhật web bằng điện thoại (gói cap-nhat-nhanh.zip)

- Ô **Dự án → Nhập nhanh** nhận thêm file **cap-nhat-nhanh.zip**: chép đè code plugin + giao diện lên bản đang chạy (ảnh dự án đã có giữ nguyên). Gói chỉ khoảng 1 MB → tải lên được bằng điện thoại, không cần cPanel.
- Lần đầu vẫn phải cài bản 2.20.3 đầy đủ (Plugin → Cài mới → Tải plugin lên `hoang-hiep-crm.zip` → "Thay thế bản hiện tại", hoặc giải nén gói trọn bộ bằng File Manager). Từ lần sau chỉ cần gói cap-nhat-nhanh.zip.
- Người đóng gói: `bash scripts/build-zip.sh` tạo thêm `dist/cap-nhat-nhanh.zip` (code + ảnh/font đổi trong 2 ngày; đổi bằng `PATCH_DAYS=7`).

## Có gì mới – plugin 2.20.2: ảnh trong gói dự án có tên tầng / chú thích tiện ích

- Ảnh mặt bằng nhập qua Nhập nhanh hiện đúng tên tab (VD "Tầng 8 – 19"); ảnh tiện ích có chú thích. Cài bản này **trước** khi nhập 3 gói Sun Solar.

## Có gì mới – plugin 2.20.1: thêm Sun Solar Residence, Sun Costa Residence

- Thêm 2 dự án Sun Group còn thiếu: **Sun Solar Residence** (9 Lê Duẩn, Hải Châu – 1 tòa 20 tầng, khoảng 256 căn) và **Sun Costa Residence** (Hồ Nghinh – Vương Thừa Vũ, Sơn Trà – 2 tòa 25 tầng, khoảng 640 căn, chủ yếu studio). Giá để "Liên hệ".
- Trang **Căn hộ Sun Group Đà Nẵng** (/can-ho-sun-group-da-nang/) tự có 2 dự án mới, phần giới thiệu và hỏi đáp cập nhật.
- Bấm **Dự án → Nhập dữ liệu Đà Nẵng** để tạo 2 dự án; sau đó thêm ảnh đại diện, bảng giá (có thể gửi qua gói Nhập nhanh).

## Có gì mới – plugin 2.20.0: Nhập nhanh cả DỰ ÁN (tạo mới + cập nhật, có Hoàn tác)

Menu đổi tên: **Dự án → Nhập nhanh (bài / dự án)**. Cùng một ô nhận 3 loại gói:
- **Gói bài tin tức** → tạo bản nháp (như 2.19).
- **Gói dự án mới** (dự án chưa có trên web) → tạo **bản nháp** trang dự án: thông tin, bảng giá, chính sách, tiện ích, ảnh đại diện, thư viện ảnh, mặt bằng… Xem trước rồi Đăng.
- **Gói cập nhật dự án** (dự án đã có) → **chỉ thay các ô có trong gói** (VD bảng giá, chính sách, ưu đãi, ảnh tiến độ); ô khác giữ nguyên. Ảnh thư viện/tiến độ được **thêm vào**, không xoá ảnh cũ.
- Cập nhật nhầm → bảng **"Dự án vừa cập nhật nhanh"** ngay dưới ô nhập, bấm **Hoàn tác** (lưu 5 lần gần nhất mỗi dự án).

## Có gì mới – plugin 2.19.0: Nhập bài nhanh (không cần tải zip cho mỗi bài tin)

Từ nay mỗi bài tin mới: Hoàng Hiệp nhận **1 file gói bài (.txt)** → vào **Dự án → Nhập bài nhanh** → **Chọn file** (làm được trên điện thoại) hoặc mở file, Ctrl+A, Ctrl+C, dán vào ô → **Tạo bài** (2.19.1 thêm nút chọn file).
- Bài tạo ở **Bản nháp**, đủ ảnh đại diện (ảnh nhúng trong gói), tiêu đề/mô tả/từ khoá Rank Math, thẻ, hỏi đáp, nguồn, schema NewsArticle. Xem trước rồi **Đăng**.
- Dán lại gói cùng bài khi bài còn là bản nháp → cập nhật bản nháp. Bài đã đăng thì không bị ghi đè.
- Người soạn tạo gói bằng `php wordpress/scripts/dong-goi-bai.php bai.json anh.jpg > goi-bai.txt`.

## Có gì mới – plugin 2.18.7: bỏ mục chấm "Content AI" của Rank Math

- Mục "Sử dụng Content AI để tối ưu hóa Post" là quảng cáo dịch vụ trả phí của Rank Math, không ảnh hưởng Google → bỏ khỏi bảng chấm điểm.

## Có gì mới – plugin 2.18.6, giao diện 2.13.2: thẻ (tag) cho bài tin hạ tầng

- Nhập dữ liệu gắn thẻ cho 13 bài tin hạ tầng, quy hoạch, nhịp sống (ví dụ: Hạ tầng Đà Nẵng, Cầu Hòa Xuân, Liên Chiểu, Sông Hàn, Hầm chui qua sông Hàn, Bảng giá đất Đà Nẵng…). Thẻ anh tự thêm được giữ nguyên.
- Thẻ hiện cuối bài (#Hạ tầng Đà Nẵng…), bấm vào ra danh sách bài cùng chủ đề. Trang thẻ để noindex (Rank Math mặc định; giao diện cũng noindex trang thẻ dưới 3 bài) để không thành trang mỏng.
- Danh sách thẻ: `hh-crm/the-tin-tuc.php`.

## Có gì mới – plugin 2.18.5: bài cầu sông Hàn thêm từ khoá "hầm chui qua sông Hàn", sửa lỗi Rank Math

- Bài nháp **cầu mới qua sông Hàn**: thêm mục *Hầm chui qua sông Hàn: phương án cũ khác gì cầu mới?* (bảng so sánh) và câu hỏi đáp; từ khoá Rank Math = "cầu mới qua sông Hàn" (chính) + "hầm chui qua sông Hàn" (phụ).
- Sửa 3 lỗi Rank Math: ảnh trong bài có alt chứa từ khoá; liên kết nguồn (báo, cơ quan nhà nước) không còn nofollow; Rank Math nhận mục lục tự động của giao diện.
- Bài vẫn là **Bản nháp**. Nội dung nháp được ghi lại bản mới (bản cũ còn trong Bản sửa đổi).

## Có gì mới – plugin 2.18.4: tin mới đăng ngay, không bị "lên lịch"

- Web đặt múi giờ khác giờ Việt Nam (ví dụ UTC) thì bản trước có thể biến tin mới thành **Đã lên lịch** thay vì đăng. Bản này đăng ngay, và tự đăng các tin đã lỡ lên lịch khi bấm Nhập dữ liệu.
- Nên đặt **Cài đặt → Chung → Múi giờ: Hồ Chí Minh**.

## Có gì mới – plugin 2.18.3: ép cập nhật bài cầu Hòa Xuân, toàn cảnh hạ tầng

- Bài **cầu Hòa Xuân** (đã khởi công 25/8/2026, 2 hầm chui, 730 ngày) và **toàn cảnh hạ tầng 2026** được cập nhật **kể cả khi bài đã bị sửa trên web** (bản 2.18.2 bỏ qua bài đã sửa). Bản cũ vẫn xem/khôi phục được ở **Bản sửa đổi** (Revisions) trong trang sửa bài.
- Chỉ ép 1 lần; về sau anh sửa tay bài này thì giữ nguyên.

## Có gì mới – plugin 2.18.2: tin hạ tầng, thị trường đầu tháng 10/2026 (đăng ngay)

Bấm **Dự án → Nhập dữ liệu Đà Nẵng** là các bài sau được tạo và **đăng ngay** (có ảnh đại diện, tiêu đề/mô tả Rank Math, hỏi đáp, nguồn):
- **Bảng giá đất Đà Nẵng sửa đổi 2026** – `/bang-gia-dat-da-nang-sua-doi-2026/`
- **Đường tránh Nam Hải Vân mở rộng 6 làn hơn 1.951 tỷ** – `/duong-tranh-nam-hai-van-6-lan-bat-dong-san-lien-chieu/`
- **Tin hạ tầng Đà Nẵng tháng 10/2026** – `/tin-ha-tang-da-nang-thang-10-2026/`
- Cập nhật bài **cầu Hòa Xuân**: đã khởi công 25/8/2026, thi công 730 ngày, nhà thầu, 2 hầm chui (chỉ cập nhật nếu anh chưa sửa tay bài này); bài **toàn cảnh hạ tầng 2026** sửa mốc Quốc lộ 14D, thêm đường tránh Nam Hải Vân.

## Có gì mới – plugin 2.18.1: bài "Cầu mới qua sông Hàn" (BẢN NHÁP chờ duyệt)

- Bài **Đà Nẵng đề xuất xây cầu mới qua sông Hàn, khởi công trước năm 2030** (đường dẫn `/da-nang-de-xuat-xay-cau-moi-qua-song-han/`, chuyên mục Hạ tầng & quy hoạch, từ khoá chính "cầu mới qua sông Hàn").
- Bấm **Dự án → Nhập dữ liệu Đà Nẵng** → bài được tạo ở trạng thái **Bản nháp**, KHÔNG tự đăng. Vào **Bài viết → Bản nháp**, mở bài, bấm **Xem trước** để đọc; đồng ý thì bấm **Đăng**.
- Đã có sẵn: tiêu đề SEO, mô tả, từ khoá Rank Math, ảnh đại diện (sơ đồ tự vẽ, không vướng bản quyền), hỏi đáp, nguồn tham khảo, schema NewsArticle.
- Các con số "500 tỷ", "2.300 tỷ" và số nghị quyết riêng cho cây cầu **chưa xác minh được** nên bài không đưa vào như sự thật. Có văn bản chính thức thì báo Hoàng Hiệp để cập nhật.

## Có gì mới – SEO lên top Google (plugin 2.18.0, giao diện 2.13.0)

Bảng từ khoá → URL đầy đủ: **`SEO-TU-KHOA.md`** (cùng thư mục này).

### 1. Mỗi từ khoá chỉ 1 trang (không tự cạnh tranh nhau)
- **Trang dự án** giữ từ khoá "giá {Tên}", "bảng giá {Tên}". Tòa / phân khu con (Capital Square Tòa 2.1, Phân khu Bạch Vân…) có từ khoá riêng, không trùng dự án mẹ.
- **80 bài viết** đổi sang từ khoá dài đúng ý bài: *chính sách bán hàng {Tên}*, *mặt bằng {Tên}*, *có nên mua {Tên}*, *giá chuyển nhượng {Tên}*, *cho thuê {Tên}*… Tiêu đề SEO ≤ 60 ký tự, mô tả 140–155 ký tự, từ khoá đứng đầu.
- Mỗi bài gắn dự án tự có 1 dòng liên kết **"bảng giá {Tên}"** về trang dự án (chèn sau đoạn 2).
- Ô Rank Math anh đã tự sửa tay **giữ nguyên**; chỉ ô do web tự điền mới được thay.

### 2. Tiêu đề & mô tả
- Trang dự án tự có tiêu đề: *"{Tên}: Bảng giá, chính sách {tháng}/{năm} | Hoàng Hiệp"* (≤ 60 ký tự, tự rút gọn). Tháng/năm lấy theo **lần cập nhật dữ liệu dự án thật**, không phải ngày hôm nay.
- Mô tả cắt gọn ~155 ký tự (trước 300). Trang Tin tức, chuyên mục, loại dự án, khu vực có mô tả riêng thay khẩu hiệu web.
- Bỏ chữ "cập nhật {tháng này}" giả: tiêu đề Mua bán / Cho thuê ghi tháng của **tin mới nhất**; bảng giá thị trường, trang /san-pham/ ghi theo ngày sửa dữ liệu thật.

### 3. Trang trùng lặp & canonical (chạy cùng Rank Math)
- **/nha-dat/ → 301 /mua-ban/**; **/loai-nha-dat/{x}/ → 301 /mua-ban/{x}/** (hoặc /cho-thue/{x}/ nếu chỉ có tin thuê), giữ số trang.
- **/khu-vuc/{x}/** nay chỉ hiện **dự án** trong khu vực (tin mua bán / cho thuê ở /mua-ban/{x}/, /cho-thue/{x}/) – hết trùng nội dung, có liên kết qua lại.
- Canonical đúng cho /mua-ban/{x}/, /cho-thue/{x}/, /san-pham/{x}/, trang hub và **trang 2, 3…** (trước đây Rank Math trỏ về /nha-dat/ hoặc trang 1). Tiêu đề trang phân trang có "– Trang 2".
- **/du-an/{slug}/bang-tinh/ → noindex, follow** và bỏ khỏi sitemap. *Lý do:* đây là công cụ tính theo từng căn, phần giá trùng trang dự án; để trang dự án độc quyền từ khoá "bảng giá {Tên}" (Google chỉ xếp 1 trang/từ khoá). "follow" vẫn giúp Google đi theo liên kết.
- Trang /mua-ban/{x}/, /cho-thue/{x}/ **dưới 3 tin → noindex** (tự lập chỉ mục lại khi đủ 3 tin).

### 4. Sitemap & schema
- Sitemap riêng `/nhadat-sitemap.xml` có **lastmod** theo tin / dự án mới nhất, bỏ trang noindex, thêm 4 trang hub. /loai-nha-dat/ bỏ khỏi sitemap.
- Schema dự án có **highPrice** (giá cao nhất đọc từ bảng giá, loại căn, vốn tự có).
- Rank Math: **tác giả bài viết = Hoàng Hiệp (#person)**; bỏ **SearchAction** (Google không còn dùng).

### 5. Tốc độ (Core Web Vitals)
- Font Be Vietnam Pro + Playfair Display **tự host** trên web (không gọi Google Fonts), tải trước 3 file chính.
- CSS in thẳng trong trang (dự án, thẻ thị trường, giỏ hàng nổi bật) **gộp vào main.css** – nhớ **Purge All** sau khi cài.
- Ảnh có width/height; ảnh đầu trang (trang chủ, dự án, tin, bài) **fetchpriority="high"**.
- Khung chat **tải chậm**: chỉ tải khi khách chạm / cuộn / gõ phím hoặc sau 4 giây (bấm nút Chat trước đó vẫn mở ngay).

### 6. Trang hub mới (từ khoá chưa có trang)
| Từ khoá | Trang |
|---|---|
| căn hộ Sun Group Đà Nẵng | /can-ho-sun-group-da-nang/ |
| biệt thự Hội An | /biet-thu-hoi-an/ |
| căn hộ chuyển nhượng Đà Nẵng | /can-ho-chuyen-nhuong-da-nang/ |
| đất nền Hòa Xuân | /dat-nen-hoa-xuan/ |

Mỗi trang: giới thiệu 340–370 chữ, bảng dự án tự lọc theo dữ liệu (thêm dự án mới là tự lên), tin bán mới nhất, bài liên quan, 4 hỏi đáp (có schema FAQ). Bài "giá đất nền Hòa Xuân 2026", "so sánh FourS – Spana – S-Light", "quy trình mua căn hộ chuyển nhượng" đổi từ khoá để không tranh với trang hub.

### Việc anh làm tay sau khi cài (quan trọng)
1. **Nhập / cập nhật dữ liệu** (bước 4) – bắt buộc để ghi từ khoá, tiêu đề, mô tả mới vào Rank Math.
2. **Cài đặt → Đường dẫn tĩnh → Lưu** (để 4 trang hub chạy ngay).
3. **LiteSpeed Cache → Purge All**.
4. Rank Math, Search Console, gửi sitemap, Yêu cầu lập chỉ mục: xem mục **"Việc làm tay trên web thật"** cuối file.

## Có gì mới (các bản trước)

### Đầu trang dự án
- Khung form đầu trang: dòng ưu đãi + 4 con số chính (19% · 25% · 15% · 70%) + "Còn N ngày – hạn …" ngay trên ô họ tên / số điện thoại.
- **Đồng bộ mọi dự án:** dự án chưa nhập "Con số nổi bật" tự lấy 4 con số từ dữ liệu sẵn có – chiết khấu, % vay, số tháng hỗ trợ lãi / giãn thanh toán, giá từ, quy mô, số căn, bàn giao, sở hữu (VD The Camellia: 13% · 70% · 18 tháng · 1,98 tỷ). Dự án ít dữ liệu (dưới 2 con số) giữ danh sách chính sách như cũ.
- Khung mở đầu mục Giới thiệu: 3 điểm nổi bật, "Ưu đãi còn N ngày", nút **Nhận bảng giá & phiếu tính giá** (cam) và **Chat Zalo**.

### Dự án FourS Tower & trang Tòa F2 (dạng landing để chạy quảng cáo)
- Trang mới **FourS Tower F2 – Tháp Mai**: 4 con số chính, vốn tự có theo loại căn (Studio ~405 triệu, 1PN+ ~619 triệu, 2PN ~857 triệu – vay 70%) có nút nhận căn qua Zalo, bảng "Một căn 3 tỷ trả bao nhiêu" 5 phương án, tiến độ Sun Early Key, FAQ, SEO.
- Mục Chính sách gọn: khung ưu đãi có đồng hồ đếm ngược đến 25/10/2026 + 1 nút; bảng chiết khấu cộng dồn (17,2% / 10,6% / 8,3% / 5,9% / 3%), lịch thanh toán, vay ngân hàng nằm trong nút **Xem chi tiết**.
- Số liệu theo phiếu tính giá CĐT – CSBH 4.2 Tòa F2 (từ 26/9/2026). Giá "từ" là giá tham khảo nguồn phân phối; có bảng giá chính thức F2 thì gửi để thay.

### Ảnh mới
- **FourS Tower & Tòa F2:** 5 ảnh phối cảnh (toàn cảnh hoàng hôn làm ảnh đại diện; 4 tháp, trục đường trung tâm, về đêm hướng sông trong Hình ảnh; phố thương mại khối đế trong Tiện ích).
- **Casamia Balanca Hội An:** 44 ảnh – tổng quan, nhà vườn, nội thất, mặt bằng, sự kiện Sound of Balance 25/04/2026, flycam thi công; tiện ích đời sống (hồ bơi, pickleball, chạy bộ, đạp xe, yoga, BBQ, xe điện nội khu); không gian sống (phòng khách, bếp, phòng ăn, phòng ngủ). Ảnh bồn tắm đã bỏ – web đã tải thì tự gỡ.

### Biết khách đến từ dự án nào, nguồn nào (Telegram / email)
- Tiêu đề tin báo có tên dự án: *[Website] Khách mới – Casamia Balanca Hội An: Tên – SĐT*; chat: *KHÁCH MỚI qua chat web – FourS Tower – SĐT*.
- Nội dung thêm: 🏢 Dự án / tin khách đang xem · 📍 Trang khách để lại số (nếu không phải trang dự án) · 🔎 Vào web từ (Quảng cáo Google / Google tìm kiếm / Facebook / Zalo / Cốc Cốc / trực tiếp, kèm tên chiến dịch nếu link quảng cáo có utm_campaign) · 🚪 Trang vào đầu tiên.
- Trong **Khách hàng** → mở từng khách: khung **Nguồn khách**.
- Lọc spam: số không phải số Việt Nam (VD 83656469774) → vẫn lưu, trạng thái *Không tiềm năng*, **không báo** Telegram/email. Số nước ngoài thật cần nhập có dấu + (VD +1…).

### Casamia Balanca – pháp lý theo sổ hồng (06/10/2026)
- Theo giấy chứng nhận lô 16 khu SL3 (cấp 8/2026): **đã có sổ hồng từng lô**, đất ở tại đô thị; sổ đứng tên chủ đầu tư ghi thời hạn đến 18/06/2069.
- Trang dự án: ô Pháp lý, Hình thức sở hữu, Địa chỉ (phường Hội An Đông), Tiến độ (mốc 8/2026), ảnh sổ trong mục Tiến độ. Bỏ chữ "sở hữu lâu dài" ở các bài Casamia.
- Bài *Pháp lý Casamia Balanca*: cập nhật bảng pháp lý, ảnh sổ, hỏi đáp, mô tả Google.

### Tin tức – chuyên mục mới "Nhịp sống Đà Nẵng"
- Bài đầu tiên: *Bãi tắm Sơn Thủy: Đà Nẵng chuẩn bị đầu tư công viên và câu lạc bộ thể thao biển* (~1.000 chữ): bảng thông tin chính, phối cảnh, các bước chuẩn bị đầu tư, ý nghĩa với cư dân – du lịch, tác động bất động sản Ngũ Hành Sơn, 4 câu hỏi đáp, liên kết dự án khu vực; ảnh phối cảnh (nguồn Danang 35K Feet). Đăng 06/10/2026.
- Chuyên mục tự hiện thành nút lọc trên trang Tin tức: `/category/nhip-song-da-nang/`.

### Vinhomes Hải Vân Bay
- Cập nhật 10/2026; 4 trang phân khu Bạch Vân, Vịnh Mây, Đảo Ngọc, Tinh Vân (giá, tiện ích, giỏ hàng 6 căn giá "Liên hệ", FAQ).
- Ô **Link ảnh**: dán link Google Drive từng ảnh, web tự tải ảnh về (chạy ngầm, vài phút). Link phải chia sẻ "Bất kỳ ai có đường liên kết".

### Giao diện
- Màu: **xanh navy + nâu**, **cam** chỉ ở điểm nổi bật (nút gửi thông tin, ưu đãi, con số chính). Đổi bảng màu: Giao diện → Tùy biến → Hoàng Hiệp – Thương hiệu → Bảng màu.
- Nút Gọi / Zalo / Tư vấn ở bên trái, nằm giữa mép màn hình và chữ; cột phải gọn (≈ 1/3 cột chữ).
- Bảng trong bài hiển thị gọn trên điện thoại (không tràn, chữ đều); tiêu đề trên ảnh luôn trắng, rõ.
- Trang dự án tự ẩn phần bài giới thiệu trùng với mục Tổng quan / Vị trí / Bảng giá / Chính sách.

### Chat trực tiếp & Telegram (mới)
- **Chat trên web** (góc phải mọi trang, điện thoại nằm trên thanh Gọi/Zalo): chào theo trang khách đang xem, nút gợi ý (Bảng giá, Vốn tự có, Đặt lịch xem nhà…), trả lời bằng số liệu dự án và xin số Zalo. Khách gõ số điện thoại → tự lưu vào **Khách hàng** kèm nội dung chat + email + Telegram.
- Mặc định trả lời theo **kịch bản** (miễn phí). Dán **API key Claude** ở **Khách hàng → Chat trên web** để trả lời tự nhiên bằng AI (có giới hạn lượt/ngày; lỗi hoặc hết lượt tự quay về kịch bản).
- **Hỏi theo mục đang đọc**: khách dừng ~8 giây ở một mục (Vị trí, Tiện ích, Giỏ hàng, Chính sách, Tiến độ…) → bong bóng hỏi đúng chuyện mục đó kèm 2 nút trả lời nhanh; tối đa 2 lần mỗi lượt truy cập. Popup form "Nhận bảng giá" lùi lại (sau 90 giây, chỉ khi khách chưa chat). Tắt/bật: Khách hàng → Chat trên web.
- **Thông báo Telegram**: **Khách hàng → Thông báo Telegram** – tạo bot ở @BotFather, dán token, nhắn Start cho bot, bấm *Lấy Chat ID* → *Gửi thử*. Mọi khách mới (form + chat) về Telegram ngay.

### Chức năng
- Tìm dự án gõ sai, không dấu vẫn ra (VD "Fous" → FourS Tower), dự án khớp nhất lên đầu.
- Sửa lỗi nghiêm trọng khi bấm Nhập dữ liệu (tải ảnh chuyển sang chạy ngầm); nếu có lỗi khác, trang báo dòng lỗi thay vì trang trắng.

## Ô mới trong quản trị (Dự án → tab Giá & chính sách)

| Ô | Dùng để | Ví dụ nhập |
|---|---|---|
| Con số nổi bật | 4 số lớn trong khung ưu đãi; có nhập thì mục Chính sách tự gọn | `18% \| Chiết khấu cộng dồn tối đa` |
| Bảng chiết khấu (4 cột) | Phương án \| Hạn \| % cộng dồn \| Cách tính | `Thanh toán sớm 95% \| Trước 25/10/2026 \| 17,2% \| EB 3% + 3% + 12%` |
| Vốn tự có theo loại căn | Thẻ vốn tự có + nút Zalo (chèn vào bài: `[hh_von_tu_co]`) | `Studio \| Giá từ ~1,7 tỷ \| ~405 triệu \| Ngân hàng cho vay ~1,13 tỷ` |
| Hạn ưu đãi | Đồng hồ đếm ngược, hết hạn tự ẩn | `25/10/2026` |
| Link ảnh (tab Thư viện) | Ảnh từ Google Drive | `link \| chú thích \| thư viện / tiện ích / mặt bằng / đại diện` |

## Còn chờ anh
- Bảng giá chính thức Tòa F2 (thay giá tham khảo, tính lại vốn tự có).
- Kiểm tra quyền chia sẻ các link ảnh Drive Hải Vân Bay; ảnh riêng cho từng phân khu.
- Chính sách CĐT bản chính thức tháng 10/2026 của Hải Vân Bay.
- Nội dung thật trang Giới thiệu, địa chỉ văn phòng.

## Việc làm tay trên web thật (SEO)

### Rank Math (WordPress → Rank Math SEO)
1. **Bảng điều khiển → Mô-đun**: bật *Sitemap*, *Schema (Rich Snippets)*, *Hình ảnh SEO*; tắt *Breadcrumbs* của Rank Math nếu không dùng (web đã có).
2. **Cài đặt chung → Liên kết**: bật *Chuyển hướng đính kèm*, tắt *Xóa base danh mục* (giữ /category/ để không đổi đường dẫn).
3. **Tiêu đề & Meta → Local SEO**: *Người hoặc tổ chức* = **Người**, Tên = **Hoàng Hiệp**, Logo/ảnh = ảnh chân dung (khớp #person của web).
4. **Tiêu đề & Meta → Loại bài**: *Dự án* và *Nhà đất* – Rich Snippet mặc định **Không có** (web đã tự xuất schema dự án / tin, tránh trùng).
5. **Tiêu đề & Meta → Phân loại**: *Loại nhà đất* (loai-bds) – bật **noindex** (đã 301 sang /mua-ban/…).
6. **Sitemap → Loại bài**: bật Bài viết, Trang, Dự án, Nhà đất; **Phân loại**: bật Danh mục, Loại dự án, Khu vực; tắt Loại nhà đất, Thẻ.
7. Không cài thêm plugin SEO khác (Yoast, AIOSEO…) song song Rank Math.

### Google Search Console (search.google.com/search-console)
1. Thêm tài sản **hiephoangmt.com** (loại *Miền*, xác minh bằng bản ghi TXT tại InterData → Quản lý DNS) hoặc *Tiền tố URL* `https://hiephoangmt.com/` (dán mã vào Rank Math → Cài đặt chung → Công cụ quản trị trang web).
2. **Sơ đồ trang web** → gửi 2 sitemap:
   - `https://hiephoangmt.com/sitemap_index.xml`
   - `https://hiephoangmt.com/nhadat-sitemap.xml`
3. **Kiểm tra URL → Yêu cầu lập chỉ mục** (mỗi ngày khoảng 10 URL) theo thứ tự:
   1. `/can-ho-sun-group-da-nang/`, `/biet-thu-hoi-an/`, `/can-ho-chuyen-nhuong-da-nang/`, `/dat-nen-hoa-xuan/` (trang mới)
   2. `/` , `/du-an/`, `/mua-ban/`, `/cho-thue/`
   3. Trang dự án chính: `/du-an/fours-tower/`, `/du-an/casamia-balanca-hoi-an/`, `/du-an/vinhomes-hai-van-bay/`, `/du-an/sun-riverpolis/`, `/du-an/spana-tower/`, `/du-an/s-light-tower/`, `/du-an/cora-tower/`, `/du-an/capital-square-da-nang/`
   4. Bài đổi từ khoá nhiều nhất: `/gia-fours-tower-2026/`, `/chinh-sach-fours-tower-thanh-toan-vay-ngan-hang/`, `/fours-tower-da-nang-tong-quan-4-thap-bon-mua/`, `/casamia-balanca-hoi-an-tong-quan-du-an/`, `/gia-biet-thu-casamia-balanca-2026/`, `/dat-nen-hoa-xuan-2026-gia-theo-khu/`, `/so-sanh-fours-tower-spana-tower-s-light-tower/`, `/mua-can-ho-chuyen-nhuong-da-nang-quy-trinh-giay-to/`, `/sun-symphony-da-nang-gia-chuyen-nhuong-cho-thue/`, `/the-meridian-da-nang-co-nen-mua/`
4. Sau 2–4 tuần: **Hiệu suất → Truy vấn** – xem từ khoá nào lên trang 1–2 để bổ sung nội dung; **Trang** – kiểm tra "Trùng lặp, Google chọn canonical khác" phải giảm dần.
5. **PageSpeed Insights** (pagespeed.web.dev): kiểm tra `/` và `/du-an/fours-tower/` trên di động (mục tiêu ≥ 70). Nếu LiteSpeed đang bật *Gộp CSS/JS*, *Tải chậm ảnh*: giữ bật; nếu bật *Tối ưu font Google* thì tắt (web đã tự host font).
