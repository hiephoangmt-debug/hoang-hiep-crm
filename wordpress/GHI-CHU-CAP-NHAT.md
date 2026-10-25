# Gói cập nhật hiephoangmt.com – 12/10/2026

**File cài:** `hoang-hiep-tron-goi.zip` (giao diện Hoàng Hiệp **2.15.25** + plugin Hoàng Hiệp CRM **2.20.74**) · cập nhật nhanh bằng điện thoại: `cap-nhat-nhanh.zip`
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

## Có gì mới – giao diện 2.15.25: 4D cho xem thử rồi mới hỏi số Zalo

- Khách bấm xem 4D được xem tự do **40 giây**; hết thời gian, khung 4D mờ đi và hiện ô **Nhập số Zalo để xem tiếp**. Nhập xong xem tiếp không giới hạn.
- Nút **Mở 4D toàn màn hình** và **Chọn căn, xem chi tiết** cũng hỏi số Zalo trước (khách đã nhập rồi thì mở thẳng).
- Khách để lại số được lưu vào **Khách hàng** với nhu cầu "Xem 4D, chọn căn".

## Có gì mới – plugin 2.20.74, giao diện 2.15.24: Sun Saphia – xem 4D và chọn căn

- Trang **Sun Saphia Residence** có mục mới **Xem 4D & chọn căn** (thêm vào thanh mục lục "Xem 4D").
- **Mô hình 4D**: khách bấm là xem ngay trên trang (bản công khai, có chữ chìm số điện thoại); có nút mở toàn màn hình. Web tự bỏ tham số nội bộ `crm` (tham số này tắt chữ chìm) và thêm `pub=1`.
- **Chọn căn, xem chi tiết**: khách nhập **số Zalo** (tên không bắt buộc) → lưu vào **Khách hàng** (nhu cầu "Xem chọn căn", gắn dự án Sun Saphia), email báo như form thường → mở công cụ chọn căn. Máy đã nhập rồi thì lần sau mở thẳng.
- Dự án khác muốn dùng: sửa dự án → mục **Hình ảnh & video** → ô **Link mô hình 4D** và **Link công cụ chọn căn**.

## Có gì mới – plugin 2.20.73, giao diện 2.15.23: tự xoá bộ nhớ đệm sau cập nhật; diện tích ghi kiểu Việt

- Cập nhật giao diện/plugin hoặc bấm **Nhập / cập nhật dữ liệu** → web tự xoá bộ nhớ đệm LiteSpeed (cả bản riêng cho điện thoại), khách thấy trang mới ngay.
- Thẻ tin rao và mô tả gửi Google ghi "2.404,4 m²" thay cho "2404.4 m²".

## Có gì mới – plugin 2.20.72, giao diện 2.15.22: chỉnh giao diện điện thoại cho dễ đọc

- **Bảng 2 cột** (VD "Địa chỉ và thông tin nhanh"): sửa lỗi cột nhãn bị bóp còn 1 chữ mỗi dòng; cột nhãn tự co vừa chữ, không chừa trống bên phải.
- **Chữ trên điện thoại** canh trái, không căn đều 2 bên (hết khoảng hở giữa các chữ); không tách chữ giữa từ.
- **Bảng giá 3 – 4 cột** giữ dạng bảng gọn, diện tích và giá không gãy dòng; bảng 5 cột trở lên mới thành thẻ, ô trống bị ẩn.
- **Nam Việt Á**: ảnh nền đầu trang mới (tự vẽ, không chữ, tiêu đề không bị chồng); biểu đồ giá chuyển xuống thư viện ảnh; bảng giá còn 4 cột, ghi chú gộp vào tên đường; bỏ bảng giá lặp lại phía dưới; bỏ nhãn "Biệt thự nghỉ dưỡng"; ô giá đầu trang hiện "Lô ống từ khoảng 7,35 tỷ".
- **Tin đất Hoàng Văn Thái**: bỏ bảng trùng với ô thông tin; bỏ dòng "Pháp lý: Khác"; diện tích ghi kiểu Việt (2.404,4 m²); ẩn phần tính tiền cho thuê với đất nền, mặt bằng kinh doanh. Tin đã đăng tự cập nhật nếu anh chưa sửa tay.
- Ảnh đơn lẻ trong tin hiện đủ khung, không bị cắt; trang dự án ẩn ô "0 căn bán · 0 căn thuê".

Cài: Dự án → Nhập nhanh → tải `cap-nhat-code.zip` → **Nhập dữ liệu Đà Nẵng** → **Nhập / cập nhật dữ liệu** → LiteSpeed **Purge All**.

## Có gì mới – plugin 2.20.71: tin nhà đất riêng lẻ – đất TMDV mặt tiền Hoàng Văn Thái
- Tin mới (Nhà đất → Mặt bằng kinh doanh, tin HOT): chuyển nhượng 2.404,4 m² đất thương mại dịch vụ mặt tiền 42 m đường Hoàng Văn Thái, thuê đất trả tiền một lần đến 20/01/2066, giá 50 tỷ gồm VAT. Không ghi số nhà, không ghi tên/số điện thoại bên bán – địa chỉ cụ thể gửi khi khách liên hệ.
- Thêm cách nhập tin riêng lẻ không thuộc dự án (data-tin-nha-dat-le.php), chạy cùng nút Nhập / cập nhật dữ liệu.

## Có gì mới – plugin 2.20.70: trang Khu đô thị Nam Việt Á
- Trang mới /du-an/khu-do-thi-nam-viet-a/ (KĐT sinh thái Nam cầu Tuyên Sơn, Ngũ Hành Sơn): tổng quan, bảng giá lô ống, đất biệt thự, lô góc theo danh sách Hoàng Hiệp 10/2026 kèm giá/m², biểu đồ giá tự vẽ, hỏi đáp.
- Bài tự đăng "Giá đất Nam Việt Á 10/2026" hẹn 11:00 ngày 27/10.

## Có gì mới – plugin 2.20.69: Sun Saphia Residence theo tài liệu chủ đầu tư 23/10
- Trang Sun Saphia: pháp lý thời hạn 50 năm kể từ 17/09/2026, công trình cấp I niên hạn 100 năm (chuyển loại dự án sang "Căn hộ dịch vụ (50 năm)"); 2PN 133 căn; mặt bằng tầng 3A – 28 (28 căn/sàn); vị trí giao lộ Võ Nguyên Giáp – Nguyễn Đức Thuận – Trường Sa; ga LRT 09 cách 500 m; ngân hàng VietinBank, BIDV, NCB; bài toán cho thuê tham khảo; bảng so sánh giá mới. Thêm 6 ảnh: phối cảnh đêm, mặt bằng tổng thể, mặt bằng tầng, 3 layout căn.
- Các bài Sun Saphia đã đăng (giá, mặt bằng, dự án Sun Group) tự cập nhật số liệu mới; bài chưa đăng (vị trí, pháp lý, đầu tư, có nên mua, tiến độ) đã sửa sẵn.
- Tự đăng bài: cập nhật được cả ảnh đại diện khi bài có ảnh cũ sai số liệu.

## Có gì mới – plugin 2.20.68: form liên hệ chạy được khi bật bộ nhớ đệm LiteSpeed
- Trang lưu đệm giữ mã bảo vệ (nonce) cũ quá 12 – 24 giờ làm form báo lỗi. Nay khách vãng lai gửi được dù mã đã cũ; chống spam bằng ô bẫy, kiểm tra số điện thoại thật và giới hạn 6 lần gửi/giờ mỗi địa chỉ IP. Người đăng nhập vẫn kiểm tra mã như cũ.
- Cài bản này TRƯỚC khi bật LiteSpeed Cache.

## Có gì mới – plugin 2.20.67: cập nhật Đà Nẵng Downtown và Sun Galaxy Complex (23/10/2026)

- **Đà Nẵng Downtown** (`/du-an/da-nang-downtown/`): mô tả ngắn mới, điểm nhấn, phân khu (Sun Galaxy Complex thi công cọc móng, nhận giữ chỗ), tiến độ thêm mốc 7/7/2026 (Accor) và 17/10/2026; thêm bài giới thiệu chi tiết có ảnh và liên kết sang www.sun-danangdowntown.com, /sun-galaxy-complex, /thap-69-tang.
- **Sun Galaxy Complex** (`/du-an/sun-galaxy-complex/`): vận hành Accor – Sofitel, Swissôtel, MGallery; khán đài khoảng 30.000 chỗ (quy hoạch duyệt gần 20.000); Moon Gate có hồ bơi vô cực; 4 tầng hầm, full nội thất 5 sao; tiến độ cọc móng 17/10/2026; bài giới thiệu chi tiết có ảnh, liên kết sang www.sun-galaxy-complex.com.vn.
- Chỉ thay ô nào vẫn là bản cũ do web nhập; ô anh đã tự sửa trong wp-admin giữ nguyên. Bài chi tiết chỉ điền vì hai bài hiện chưa có nội dung.
- Sau khi giải nén: **Dự án → Nhập dữ liệu Đà Nẵng → Nhập / cập nhật dữ liệu**, rồi **LiteSpeed Cache → Purge All**.

## Có gì mới – plugin 2.20.67, giao diện 2.15.21: đưa 105 trang dự án và tin nhà đất vào sitemap
- Sitemap Rank Math trước chỉ có bài viết, trang, chuyên mục – thiếu toàn bộ trang Dự án (/du-an/) và tin Nhà đất (/nha-dat/). Bản này bật hai loại trong sitemap (du-an-sitemap.xml, bat-dong-san-sitemap.xml) để Google tìm và lập chỉ mục.
- Sau khi cài: Rank Math → Sơ đồ trang web kiểm tra có mục "Dự án", "Nhà đất"; gửi lại sitemap_index.xml trong Google Search Console.
- Giao diện: dự án chưa có giá không khai báo kiểu Product trong schema (tránh lỗi "Đoạn trích sản phẩm" trên Search Console).

## Có gì mới – plugin 2.20.66: tự đăng bài đúng phút hẹn
- Web hẹn riêng đúng phút đăng của bài kế tiếp (thay vì chờ lượt kiểm tra mỗi giờ); danh sách bài mới được kiểm tra mỗi 15 phút.
- Trang được LiteSpeed lưu đệm nên lịch hẹn WordPress không chạy theo lượt xem: trình duyệt khách gọi nhẹ wp-cron.php (tối đa 5 phút/lần mỗi khách) để lịch chạy đúng giờ.
- Dự án → Tự đăng bài hiện thêm "Hẹn đăng bài kế tiếp".
- Khuyên dùng thêm Cron Jobs trong cPanel (mỗi phút gọi wp-cron.php) để bài lên đúng giờ cả khi web không có khách.

## Có gì mới – plugin 2.20.65: tự đăng bài cập nhật được bài đã đăng
- Mục Tự đăng bài giờ cập nhật được bài đã đăng khi có bản sửa mới (giữ ngày đăng, đường dẫn, ảnh). Bài anh đã sửa tay thì giữ nguyên, nhật ký ghi "đã được sửa tay".
- Bài cao tốc nội thị 19/10 sẽ tự thêm phần "Cập nhật 22/10: hai mặt cắt điển hình và quỹ đất dọc tuyến"; bài mới về mặt cắt 138 m, quỹ đất, TOD tự đăng 11:00 ngày 22/10.

## Có gì mới – plugin 2.20.64, giao diện 2.15.20: trang tòa C3 Capital Square
- Trang mới **Tòa C3 Capital Square Đà Nẵng** (/du-an/capital-square-toa-c3/): phân tầng 26 tầng (16 shophouse, căn sân vườn tầng 4, penthouse tầng 26), bảng 9 căn tầng điển hình kèm diện tích thông thủy và hướng nhìn, 4 ảnh có nhãn Hoàng Hiệp.
- Trang tổ hợp Capital Square hiện đủ các tòa con (trước giới hạn 12 trang, nay 24).

## Có gì mới – plugin 2.20.63: bỏ nguồn baodangland.vn
- Bỏ liên kết nguồn baodangland.vn ở 3 trang đất nền Điện Ngọc (1A 1B, số 3, số 9) và 2 bài Sun Saphia (giá, pháp lý – bài tự đăng đã cập nhật sẵn).

## Có gì mới – plugin 2.20.62: Hudson Place S4 thêm mặt bằng vị trí và phối cảnh đêm
- Trang Hudson Place S4: thêm mặt bằng vị trí các tòa (Hudson, Broadway, Kings, Queens, Times Place – đã cắt logo đơn vị phân phối) và phối cảnh đêm nhìn từ sông Hàn (tòa S4, C3); ảnh có nhãn Hoàng Hiệp.
- Thêm đoạn mô tả vị trí trong tổ hợp. Chỉ thay nội dung / danh sách ảnh khi anh chưa sửa tay trang này.

## Có gì mới – plugin 2.20.61: tự đăng bài hằng ngày
- Mục mới **Dự án → Tự đăng bài**: mỗi giờ web tự đọc danh sách bài soạn sẵn (thư mục `wordpress/tu-dong/` trong kho code) và đăng bài tới giờ hẹn (8:00 sáng), kèm ảnh, tiêu đề – mô tả – từ khoá Rank Math, hỏi đáp, liên kết về Sun Saphia Residence. Anh không cần tải gói hay dán bài nữa.
- Mỗi lượt tối đa 3 bài; tự xoá bộ nhớ đệm LiteSpeed khi có bài mới. Không ghi đè bài đã đăng hoặc bài anh đã sửa tay.
- Tắt / bật bằng ô "Bật tự đăng bài"; có nút đăng ngay và nhật ký.
- Lưu ý: bài nào có trong danh sách sẽ tự lên mà không qua duyệt – muốn xem trước thì tắt ô này.

## Có gì mới – plugin 2.20.60: loạt bài hằng ngày dẫn về Sun Saphia Residence (đợt 1)

- 7 bài tự đăng lúc 8:00 sáng mỗi ngày từ 20/10 đến 26/10/2026, mỗi bài dẫn link về trang Sun Saphia Residence và các dự án, bài liên quan:
  - 20/10 Studio ven biển Đà Nẵng 2026: giá mua, giá thuê, cách tính dòng tiền
  - 21/10 Mở rộng đường Võ Nguyên Giáp – Trường Sa – Lạc Long Quân 2.633 tỷ
  - 22/10 Đường sắt đô thị sân bay – Mỹ Khê – Hội An
  - 23/10 Các dự án căn hộ Sun Group ở Đà Nẵng 2026
  - 24/10 Giữ chỗ (booking) căn hộ mới khác đặt cọc thế nào
  - 25/10 Căn hộ ven biển: Mỹ Khê, Sơn Thủy hay Non Nước
  - 26/10 Mua căn hộ Đà Nẵng từ xa (Hà Nội, TP.HCM)
- Mỗi bài có ảnh đại diện tự vẽ, từ khoá Rank Math, mô tả, điểm chính, hỏi đáp.
- Trình nhập bài hỗ trợ ô `schedule` (hẹn đúng ngày, mặc định 8:00 giờ Việt Nam).
- Cài: Dự án → Nhập nhanh → tải `cap-nhat-code.zip` → Nhập dữ liệu Đà Nẵng → Nhập / cập nhật dữ liệu (bài vào trạng thái Lên lịch) → LiteSpeed Cache → Purge All.

## Có gì mới – plugin 2.20.59: đóng dấu ảnh thanh lịch hơn

- Bỏ dải đen chân ảnh và dòng chữ đậm giữa ảnh. Thay bằng nhãn nhỏ góc phải dưới (nền navy trong mờ, viền vàng): HOÀNG HIỆP / 0904 567 009 · hiephoangmt.com, kèm chữ chìm mảnh rất mờ lặp chéo khắp ảnh (cắt góc vẫn còn).
- Cài gói này **thay cho** các gói 2.20.56 – 2.20.58: Dự án → Nhập nhanh → tải `cap-nhat-code.zip` → Nhập dữ liệu Đà Nẵng → Nhập / cập nhật dữ liệu → LiteSpeed Cache → Purge All.

## Có gì mới – plugin 2.20.58: đóng dấu chìm số điện thoại, web lên ảnh

- Ảnh Sun Saphia đóng dấu chìm "0904 567 009 · hiephoangmt.com" chạy chéo lặp khắp ảnh, thêm một dòng rõ giữa ảnh và dải chân ảnh – cắt góc nào cũng còn số, khó tẩy.
- Công cụ `scripts/dong-dau-anh.py` để đóng dấu ảnh dự án khác.
- Cài gói này **thay cho** các gói 2.20.56, 2.20.57: Dự án → Nhập nhanh → tải `cap-nhat-code.zip` → Nhập dữ liệu Đà Nẵng → Nhập / cập nhật dữ liệu → LiteSpeed Cache → Purge All.

## Có gì mới – plugin 2.20.57: ảnh Sun Saphia có số điện thoại và web

- 5 ảnh trang Sun Saphia Residence thêm dải chân ảnh "Hoàng Hiệp · 0904 567 009 · hiephoangmt.com".
- Cài gói này **thay cho** gói 2.20.56 (chưa cần cài gói trước): Dự án → Nhập nhanh → tải `cap-nhat-code.zip` → Nhập dữ liệu Đà Nẵng → Nhập / cập nhật dữ liệu → LiteSpeed Cache → Purge All.

## Có gì mới – plugin 2.20.56: trang dự án Sun Saphia Residence

- Trang mới **Sun Saphia Residence Đà Nẵng** (`/du-an/sun-saphia-residence/`), trạng thái Sắp mở bán: tòa 30 tầng (114 m) của Sun Group trên đường Trường Sa, khu Sơn Thủy; 782 căn (513 studio 30 – 31 m², 108 căn 1PN+1, 149 căn 2PN), 2 tầng hầm, đất 3.720,1 m², bàn giao dự kiến 11/2028.
- Nội dung chuẩn SEO: vị trí đối diện công viên bãi tắm Sơn Thủy 2,45 ha (đất thu hồi từ Hòn Ngọc Á Châu, 47 tỷ, 2025 – 2027), mở rộng Võ Nguyên Giáp – Trường Sa – Lạc Long Quân 2.633 tỷ, đường sắt đô thị sân bay – Mỹ Khê – Hội An, bảng so sánh giá căn hộ ven biển (The Soleil, Futa, Nobu, Newtown Diamond – tham khảo), 5 câu hỏi đáp.
- 5 ảnh: phối cảnh ven biển, phối cảnh tòa tháp, poster chủ đầu tư, bản đồ kết nối, sơ đồ vị trí tự vẽ. Không đăng bản vẽ chia lô, hồ sơ khảo sát, ảnh Google Maps, ảnh báo, ảnh stock.
- Cài: Dự án → Nhập nhanh → tải `cap-nhat-code.zip` → Nhập dữ liệu Đà Nẵng → Nhập / cập nhật dữ liệu → LiteSpeed Cache → Purge All.

## Có gì mới – plugin 2.20.55: sửa bản đồ Hudson Place

- Bản đồ trang Hudson Place S4 chỉ nhầm sang FourS Tower (Google đọc "S4" thành "FourS"). Nay trang Hudson Place, trang tổ hợp Capital Square và các trang tòa 2.1 – 2.7, LAT, MAT đều tìm theo địa chỉ cố định "Capital Square, Trần Hưng Đạo, An Hải, Đà Nẵng".
- Muốn ghim đúng tuyệt đối: sửa dự án → ô **Tọa độ bản đồ** → dán tọa độ copy từ Google Maps (bấm chuột phải đúng vị trí tòa).
- Cài: Dự án → Nhập nhanh → tải `cap-nhat-code.zip` → Nhập dữ liệu Đà Nẵng → Nhập / cập nhật dữ liệu → LiteSpeed Cache → Purge All.

## Có gì mới – plugin 2.20.54: trang Hudson Place (tòa S4) – Capital Square 3

- Trang mới **Hudson Place S4 Capital Square Đà Nẵng** (`/du-an/capital-square-hudson-place-s4/`), nằm dưới tổ hợp Capital Square Đà Nẵng, theo tài liệu đào tạo bán hàng tòa S4 ngày 28/9/2026:
  - Thông số: CĐT SIH, 24 tầng, 314 căn 1PN / 2PN / 3PN / 3PN dualkey, bàn giao quý III/2027 bán hoàn thiện, sở hữu lâu dài, vận hành Savills.
  - Mặt bằng tầng 5 – 12, 14 – 24 (15 căn/sàn) và tầng 12A; bảng mã căn với diện tích thông thủy / tim tường; view từng dãy căn.
  - Chính sách: miễn phí quản lý 1 năm, smarthome 100 / 200 / 300 triệu trừ vào giá, ưu đãi 8% / 12% / 18% theo cách thanh toán, vay 70% lãi suất 0% tới 36 tháng (2 phương án), ân hạn gốc 36 tháng.
  - Quy trình mua theo hình thức chuyển nhượng hợp đồng mua bán, khái niệm giá chuyển nhượng / tổng giá bán, tiêu chuẩn bàn giao, 7 câu hỏi đáp (chat tự trả lời được).
  - 17 ảnh: phối cảnh, mặt bằng tổng thể, mặt bằng tầng, layout 3 loại căn, 7 ảnh tiện ích, ảnh thi công 9/2026, tiêu chuẩn bàn giao. Đã cắt bỏ dòng chữ của đơn vị phân phối; không dùng mã QR, trang giới thiệu đơn vị phân phối.
- **Cài (2 gói vì ảnh lớn hơn 4 MB):** Dự án → Nhập nhanh → tải `cap-nhat-code-1.zip`, rồi `cap-nhat-code-2.zip` → Nhập dữ liệu Đà Nẵng → Nhập / cập nhật dữ liệu → LiteSpeed Cache → Purge All.

## Có gì mới – plugin 2.20.53: chat hiểu từ viết tắt, trả lời tự nhiên hơn

- **Hiểu đúng từ viết tắt**, kể cả từ nhiều nghĩa (dịch theo từ đứng cạnh):
  - Nhắn tin: a / c / e (anh / chị / em), ko, k, dc, j, bn, bh, ntn, vk, ck (vợ / chồng), ny, mn, nt, rep, sdt, zl, ib, t7, cn…
  - Nhà đất: cc, ch, MT, MTKD, HXH, SHR, SH, SĐ, CĐT, HĐMB, HĐ cọc, LK, BT (biệt thự), TC (thổ cư), ODT, KĐT, KDC, DT (diện tích) / ĐT (xin đt = điện thoại), CK (chiết khấu khi đi với số, % / chồng khi nói "ck mình"), TT (thanh toán / gần TT = trung tâm), LS, NH, MG, CN 90 (công nhận)…
  - Tiền: 3t5, 3ty5 = 3,5 tỷ; 3 tỏi = 3 tỷ; 500 củ, 500tr = 500 triệu; 2 tỷ rưỡi.
  - Địa danh: ĐN, QN, NHS, ST, HC, TK, LC, CL, HV, ĐB, HX, VNG (Võ Nguyên Giáp), VCC (Võ Chí Công), VVK, NVL, PVĐ…
- **Câu trả lời khéo, không lặp**: hỏi nhu cầu, gợi ý căn, hẹn xem nhà, xin số Zalo, câu chưa rõ ý — mỗi chỗ có 2–3 cách nói, không nói lại câu vừa nói; "Dạ có ạ" chỉ dùng khi khách hỏi có / không.
- Sửa: "Vân" trong "Bạch Vân" bị bỏ khi tra cứu; "giá" khớp nhầm vào "giao"; "vậy" (z) bị hiểu là "vay"; khách nói nhu cầu bị trả lời bằng câu hỏi đáp của bài tin tức.
- Cài: Dự án → Nhập nhanh → tải `cap-nhat-code.zip` → LiteSpeed Cache → Purge All.

## Có gì mới – plugin 2.20.52: chat hiểu giờ hẹn xem nhà, đáp khéo câu trêu

- Chat vừa hỏi "tiện ngày nào, sáng hay chiều" → khách trả lời "chiều mai", "thứ 7", "8h sáng", "lúc nào cũng được"… được ghi nhận và xin số chốt lịch; khách hỏi "khuya dc ko" → đáp vui (khuya nhà mẫu đi ngủ rồi), gợi ý tối sớm trước 21h hoặc xem qua video.
- Khách trêu "gái đi xem dc ko", "có gái xinh không"… → đáp hóm hỉnh, lịch sự rồi kéo về chuyện xem nhà (không nhầm với "con gái", "em gái").
- Cài: Dự án → Nhập nhanh → tải `cap-nhat-code.zip` → LiteSpeed Cache → Purge All.

## Có gì mới – giao diện 2.15.19: trang máy tính cân giữa lại

- Sửa lỗi trên máy tính màn hình rộng: đầu trang, ảnh lớn, ô tìm kiếm và các mục bị dồn sang trái (do lần chuyển nút Gọi / Zalo sang phải). Nay nội dung cân giữa như cũ, nút Gọi / Zalo / chat vẫn ở góc phải dưới.
- Cài: Dự án → Nhập nhanh → tải `cap-nhat-code.zip` → LiteSpeed Cache → Purge All.

## Có gì mới – plugin 2.20.51: nút "Hỏi em nhé", khung chat "Trợ lý của Hoàng Hiệp"

- Nút chat đổi chữ thành **"Hỏi em nhé"** (tiếng Anh "Ask me", tiếng Hàn "물어보세요").
- Đầu khung chat ghi **"Trợ lý của Hoàng Hiệp"**, bỏ ảnh đại diện, thay bằng biểu tượng khung chat.
- Cài: Dự án → Nhập nhanh → tải `cap-nhat-code.zip` → LiteSpeed Cache → Purge All.

## Có gì mới – plugin 2.20.50: nút chat "Hỏi giá nhanh"

- Nút chat góc phải dưới đổi chữ "Chat tư vấn" → **"Hỏi giá nhanh"** (trang tiếng Anh: "Ask for prices", tiếng Hàn: "가격 문의"); bỏ ảnh đại diện, thay bằng biểu tượng khung chat. Điện thoại: nút tròn chỉ có biểu tượng.
- Cài: Dự án → Nhập nhanh → tải `cap-nhat-code.zip` → LiteSpeed Cache → Purge All.

## Có gì mới – plugin 2.20.49: chat hiểu ý khách, không chỉ bắt từ khoá

- **Hiểu cách gõ đời thường**: "ko", "k", "dc", "bn", "bao h", "wa", "z", "2 PN", "2 phòng ngủ", "2 tỷ rưỡi", "3 tỷ 5", gõ kéo dài chữ "quáaaa"…
- **Hiểu câu trả lời ngắn nối theo câu hỏi trước**: chat hỏi "để ở hay đầu tư?" → khách gõ "cho thuê", "đầu tư", "để ở", "nhà 4 người muốn mua để ở"; chat hỏi "gần biển hay sông Hàn?" → "biển"; "ok", "gửi đi", "chưa cần"… đều được đáp đúng ý.
- **Tra hàng trăm câu hỏi đáp có sẵn trên web theo nghĩa**: khách hỏi "bạch vân bao giờ giao nhà z", "đất võ chí công có sổ chưa ad", "casamia sở hữu mấy năm", "sun cosmo chủ đầu tư là ai", "the meridian nằm ở đâu" → trả lời đúng mục của đúng dự án, kèm link. Đang ở trang dự án thì hỏi trống "có sổ chưa", "bao h giao nhà" cũng hiểu.
- **Câu hỏi chung** có câu trả lời: người nước ngoài mua nhà, lãi suất vay, thủ tục sang tên, thuế phí, đặt cọc cần lưu ý gì, nên mua khu nào, thị trường thế nào, cho thuê lãi bao nhiêu, "đẹp mà không đắt"… Không tự đặt con số; chỗ cần số thì hẹn tính theo từng căn.
- **Sửa các lỗi bắt nhầm cũ**: "điện thoại", "diện tích", "Điện Ngọc" từng bị hiểu là chê bot; "2 phòng ngủ" bị hiểu là chửi "ngu"; "bàn giao" bị hiểu là "ăn gì"; "có bao nhiêu" bị hiểu là "có bão"; "ở Mỹ Khê" bị hiểu là "ở Mỹ"; "thu nhập" bị hiểu là gõ thử; "đất vàng" bị hiểu là chê đắt; "công nhận" bị hiểu là "lương công nhân"; "mà không" bị hiểu là hỏi nhà có ma.
- Thêm câu đáp khi khách khen ("hay quá"), hỏi han ("em ăn cơm chưa").
- Cài: Dự án → Nhập nhanh → tải `cap-nhat-code.zip` → LiteSpeed Cache → Purge All.

## Có gì mới – plugin 2.20.48: chat khéo hơn với khách ở xa, khách "xem cho biết"

- Khách nói **ở xa** ("Đà Nẵng xa quá mình tít Hà Nội", "anh ở Sài Gòn không vào được", "chị ở Mỹ"…): trả lời hóm hỉnh, nhắc đúng nơi khách ở, gợi ý xem nhà qua video, gửi pháp lý trước rồi mới bay vào; 3 kiểu câu, không lặp lại câu vừa nói.
- Thêm kiểu câu cho: khách **chỉ xem cho biết / để suy nghĩ thêm**, khách **nghi môi giới ăn chênh**, khách hỏi **có nên mua bây giờ** (dẫn số liệu quý 3/2026).
- Xưng hô đúng hơn: khách gõ "anh ở…", "chị đang…" → gọi anh / chị thay vì anh/chị.
- Cài: Dự án → Nhập nhanh → tải `cap-nhat-code.zip` → LiteSpeed Cache → Purge All (không cần nhập lại dữ liệu).

## Có gì mới – plugin 2.20.47: giỏ hàng 12 khách sạn ven biển
- Bài **"Bán khách sạn Đà Nẵng ven biển"** thêm mục "12 khách sạn 3 – 4 sao ven biển đang chào bán (10/2026)": bảng vị trí, đất, tầng/phòng, doanh thu, giá chào, giá/m² đất, so sánh tỷ lệ doanh thu/giá; đổi tiêu đề, mô tả, tiêu đề SEO; thêm câu hỏi thường gặp. Bài được đưa lên đầu Tin tức (nếu anh chưa sửa tay bài này).
- **Bảng giá khách sạn ven biển** (trang Mua bán → Khách sạn): cập nhật khoảng giá Hồ Nghinh (30 – 125 tỷ), Phạm Văn Đồng (88 – 165 tỷ), thêm 2 dòng Sơn Thủy – An Tư Công Chúa – Hồ Xuân Hương (68 – 115 tỷ) và Phan Tôn – Dương Đình Nghệ – Võ Văn Kiệt (97 – 170 tỷ).
- Cài: Nhập nhanh `cap-nhat-code.zip` → **Nhập dữ liệu Đà Nẵng → Nhập / cập nhật dữ liệu** → LiteSpeed Cache → Purge All.

## Có gì mới – plugin 2.20.46: chat như người thật, nói được tiếng Anh, tiếng Hàn
- **Nhịp nhắn như người:** câu trả lời tách thành 2 – 3 tin ngắn, mỗi tin "đang gõ…" một lúc theo độ dài (không bật ra cả đoạn ngay lập tức).
- Bớt câu khuôn mẫu: lời mở đầu thay đổi ("Dạ", "Vâng ạ", "Dạ có ạ"…), bỏ "em nhận thông tin ạ"; khách xưng "anh" / "chị" thì cả câu gọi đúng "anh" / "chị".
- **Tiếng Anh, tiếng Hàn:** khách nhắn tiếng nào trả lời tiếng đó (tự nhận biết từng tin): chào, đùa, hỏi giá dự án (kèm giá bán lại, giá thuê, link), người nước ngoài mua nhà (30% căn mỗi tòa, sở hữu 50 năm), thuê nhà, xin số. Chat bật cả ở trang /en/, /ko/ với giao diện tiếng Anh, tiếng Hàn.
- Chế độ AI (khi gắn khóa): viết lại hướng dẫn giọng điệu – nhắn như sale thật, câu nghiêm túc thì chuẩn chỉnh có số liệu, câu đùa thì duyên; trả lời đúng ngôn ngữ khách (Anh, Hàn, Trung, Nhật…).
- Cài: Nhập nhanh `cap-nhat-code.zip` → LiteSpeed Cache → Purge All.

## Có gì mới – plugin 2.20.45: chat tự động đối đáp khéo, hóm hỉnh hơn
- Chat đang chạy chế độ kịch bản (chưa gắn khóa AI): thêm nhiều kiểu câu đùa, chọc, chê, trả giá – mỗi kiểu 2 – 3 câu trả lời khác nhau, không lặp lại: bot là ai, tán tỉnh, đẹp trai/xinh, chê bot, xin giảm giá, xin nợ, hết tiền, chê đắt, nhà có ma/phong thủy, vợ chưa cho mua, cười, buồn, thời tiết, ăn gì, vàng hay đất, chào, tạm biệt.
- Câu chen ngang không liên quan nhà đất → đáp vui thay vì hỏi máy móc "quan tâm căn hộ hay đất nền".
- Xưng hô theo khách ("cho anh…" → gọi anh, "chị hỏi…" → gọi chị); sửa lỗi "Dạ Anh/chị" viết hoa.
- Chế độ AI (khi gắn khóa): bổ sung hướng dẫn trả lời đúng ý câu đùa trước rồi mới nối về nhà đất.
- Cài: Nhập nhanh `cap-nhat-code.zip` → LiteSpeed Cache → Purge All.

## Có gì mới – plugin 2.20.44: bổ sung đủ ảnh còn thiếu trên web
- Nguyên nhân thiếu: gói 18 MB vượt giới hạn tải lên của hosting nên ảnh FPT Plaza 3, Võ Chí Công, Đầm Sen, Nam Hội An… chưa lên web.
- Chia thành **7 gói nhỏ** `cap-nhat-code-1.zip` … `cap-nhat-code-7.zip` (mỗi gói ≤ 4,2 MB, gói nào cũng có đủ code mới). Cài lần lượt cả 7 gói bằng Nhập nhanh.
- Nhập dữ liệu giờ **tự thử tải lại** ảnh từng lỗi khi file ảnh đã có.
- Cài: Nhập nhanh 7 gói → **Nhập dữ liệu Đà Nẵng → Nhập / cập nhật dữ liệu** → chờ vài phút cho ảnh tải ngầm → LiteSpeed Cache → Purge All.

## Có gì mới – plugin 2.20.43: Fusion Resort & Villas Đà Nẵng
- Ảnh đại diện toàn cảnh dãy biệt thự bên biển, mặt bằng loại biệt thự (1 – 6 phòng ngủ) làm mặt bằng tổng thể, 11 ảnh thư viện (hồ bơi riêng, sân vườn, cổng, mặt tiền), 2 ảnh tiện ích.
- Điền ô còn trống: mô tả 6 loại biệt thự (Presidential, Beach Front, Premier, Beach Garden, Garden Terrace, Garden Front), tiện ích nội khu – ngoại khu, mô tả biệt thự.
- Không dùng: bản vẽ thi công có logo đơn vị khác và tọa độ mốc ranh; bảng lịch thanh toán (tài liệu ghi "Classified: Internal").
- Cài: Nhập nhanh `cap-nhat-code.zip` → **Nhập dữ liệu Đà Nẵng → Nhập / cập nhật dữ liệu** → LiteSpeed Cache → Purge All.

## Có gì mới – plugin 2.20.42: Đất nền Đầm Sen – Sun Riverpolis (Nam Hòa Xuân)
- Ảnh đại diện: toàn cảnh Nam Hòa Xuân nhìn về sông Cổ Cò, Ngũ Hành Sơn, biển (nếu trang chưa có ảnh).
- 3 mặt bằng (tab): các block mở bán khu công viên Đầm Sen (100 / 125 / 150 m²), phân khu Đầm Sen, khu phía Bắc.
- 6 ảnh tiện ích: đường nội khu, đường chạy bộ, sân tập thể dục ven sông, giàn hoa, đường dạo.
- Điền ô còn trống: mô tả phân khu theo block (B2-111 … B2-157), tiện ích nội khu (công viên ven sông, bến du thuyền, đồi hoa, sân bóng, nhà hàng ven sông, trường học), ngoại khu.
- Không dùng 2 ảnh có logo, chữ chìm của đơn vị phân phối (bản đồ vệ tinh chú thích block và ảnh flycam sân bóng).
- Cài: Nhập nhanh `cap-nhat-code.zip` → **Nhập dữ liệu Đà Nẵng → Nhập / cập nhật dữ liệu** → LiteSpeed Cache → Purge All.

## Có gì mới – plugin 2.20.41: Nam Hội An City – phối cảnh và mặt bằng phân lô
- Ảnh đại diện đổi sang **phối cảnh thật từ trên cao** (thay sơ đồ minh hoạ), thêm phối cảnh có chú thích (khách sạn 5 sao, Fivitel 4 sao, khách sạn thấp tầng, bến du thuyền, thương mại ven sông) và **mặt bằng phân lô** làm mặt bằng tổng thể.
- Mặt bằng đã **che khung logo, số điện thoại của đơn vị phân phối** – chỉ giữ bản vẽ. Không dùng bản có logo lớn giữa ảnh.
- Thêm mục "Mặt bằng phân lô" trong bài và mô tả thiết kế (lô TMDV ven sông TM4, nhà phố CL1 – CL12 trên Trường Giang 1 – 10, công viên trung tâm, clubhouse, khu thể thao). Bài/ô anh tự sửa giữ nguyên.
- Cài: Nhập nhanh `cap-nhat-code.zip` → **Nhập dữ liệu Đà Nẵng → Nhập / cập nhật dữ liệu** → LiteSpeed Cache → Purge All.

## Có gì mới – plugin 2.20.40: mặt bằng 709 lô đất nền Võ Chí Công
- **Mặt bằng tổng thể** (bản màu: mặt tiền Võ Chí Công, liền kề nội khu, villa mặt sông Đô Toả, chung cư, nhà ở hình thành trong tương lai) làm ảnh mặt bằng tổng thể; **bản vẽ quy hoạch** thêm vào tab mặt bằng.
- Thêm mục "Mặt bằng và phân loại sản phẩm" trong bài giới thiệu, mô tả thiết kế, tiện ích nội khu (công viên ven sông, trường học, Nhà sáng tác miền Trung – Tây Nguyên, hồ Bá Tùng, hồ Mân Quang) và ngoại khu. Bài/ô nào anh đã tự sửa thì giữ nguyên.
- Cài: Nhập nhanh `cap-nhat-code.zip` → **Nhập dữ liệu Đà Nẵng → Nhập / cập nhật dữ liệu** → LiteSpeed Cache → Purge All.

## Có gì mới – plugin 2.20.39, giao diện 2.15.18: 709 lô đất nền Võ Chí Công – Sun Group
- Đổi tên trang thành **"709 lô đất nền Võ Chí Công – Sun Group"** (chỉ khi tên trên web vẫn là tên cũ – tên anh tự sửa giữ nguyên).
- **12 ảnh thực tế anh chụp 10/2026** (đã bỏ thông tin vị trí GPS trong ảnh, bỏ ảnh có biển số xe rõ): ảnh mặt tiền làm ảnh đại diện nếu trang chưa có, 11 ảnh vào mục Tiến độ.
- Bài giới thiệu, hiện trạng hạ tầng 10/2026, bảng giá rao theo vị trí (mặt tiền 79 – 90 triệu/m², nội khu 44 – 59 triệu/m²), chính sách theo tin rao, 5 câu hỏi thường gặp.
- Trang **đất nền** không còn chữ dành cho căn hộ ("tầng cao, căn góc", "nhà mẫu", "hồ bơi, gym") – đổi thành lô, mốc lô, sơ đồ phân lô, sổ đỏ.
- Cài: Nhập nhanh `cap-nhat-code.zip` → **Nhập dữ liệu Đà Nẵng → Nhập / cập nhật dữ liệu** → LiteSpeed Cache → Purge All.

## Có gì mới – plugin 2.20.38: FPT Plaza 3 – phối cảnh và mặt bằng tầng
- **3 ảnh phối cảnh** (toàn cảnh từ trên cao làm ảnh đại diện nếu trang chưa có ảnh, mặt tiền, góc thấp) và **10 mặt bằng**: Tầng 1, 2, 4, 5 – 12A, 12B, 14 – 17, 18 – 24, 25, Hầm 1, Hầm 2 – mỗi tầng một tab, bấm để phóng to xem mã căn.
- Điền thêm (ô còn trống): bảng loại căn đọc từ bản vẽ (1PN 42 m², 1PN+1 47 – 51 m², 2PN 55 – 69 m², 2PN+1 73 – 76 m², 3PN 72 – 80 m², 3PN+1 81 – 124 m², căn 2 tầng 88 – 148 m², ki-ốt TMDV 56 – 201 m²), mô tả thiết kế (4 mặt đường, 2 sảnh W – E, 35 – 36 căn/sàn, không có tầng 13).
- Cài: Nhập nhanh `cap-nhat-code.zip` → **Nhập dữ liệu Đà Nẵng → Nhập / cập nhật dữ liệu** (để tải ảnh) → LiteSpeed Cache → Purge All.

## Có gì mới – giao diện 2.15.17
- **Chữ cân đều 2 bên trên toàn trang**: đoạn văn, dòng liệt kê, nội dung bảng thông tin dự án và bảng trong bài. Riêng các thẻ nhỏ cột hẹp (thẻ dự án, tin rao, ô số liệu, chân trang) vẫn canh trái để chữ không bị giãn hở.
- Cài: Nhập nhanh `cap-nhat-code.zip` → LiteSpeed Cache → Purge All.

## Có gì mới – giao diện 2.15.16
- Mọi bảng thông tin dạng "nhãn – nội dung" chia **1/3 nhãn – 2/3 nội dung**: bảng tổng quan dự án, bảng thông tin trong bài viết, và bảng dạng thẻ trên điện thoại (bảng giá, bảng so sánh).
- Cài: Nhập nhanh `cap-nhat-code.zip` → LiteSpeed Cache → Purge All.

## Có gì mới – giao diện 2.15.15
- Bỏ nút tròn "Nhận tư vấn" ở góc phải dưới – chỉ còn Gọi, Zalo và nút chat tự động. Form nhận tư vấn trong trang và trang Liên hệ vẫn giữ nguyên.
- Cài: Nhập nhanh `cap-nhat-code.zip` → LiteSpeed Cache → Purge All.

## Có gì mới – giao diện 2.15.14, plugin 2.20.37: nút liên hệ góc phải, chữ cân đều
- **Nút Gọi / Zalo / Nhận tư vấn** chuyển thành cột nút tròn ở **góc phải dưới**, ngay trên nút chat tự động (cả điện thoại và máy tính). Bỏ thanh 3 nút ngang đáy màn hình điện thoại → nội dung rộng thêm 60px.
- Lời chào của chat hiện bên trái cột nút (không che nút).
- **Chữ cân đều 2 bên** cho đoạn văn trên trang dự án, hộp "đang cập nhật", hộp kêu gọi tư vấn và phần mô tả đầu trang.
- Cài: Nhập nhanh `cap-nhat-code.zip` → LiteSpeed Cache → Purge All.

## Có gì mới – giao diện 2.15.13: gọn hơn trên điện thoại
- **Trang Tin tức:** chuyên mục chỉ hiện mục đang có bài; trên điện thoại xếp thành 1 hàng vuốt ngang (trước dồn 6 hàng, chiếm nửa màn hình). Vào chuyên mục nào thì nút đó tự cuộn vào giữa.
- **Trang dự án – Kết nối:** trên điện thoại gom thành 1 khung, mỗi dòng "thời gian | điểm đến" (trước mỗi mục một thẻ lớn).
- **Chân trang trên điện thoại:** Danh mục và Khu vực chia 2 cột cạnh nhau (trước xếp dọc dài).
- Sửa lỗi nút chuyên mục bị tô đậm sau khi chạm trên điện thoại.
- Cài: Nhập nhanh `cap-nhat-code.zip` → LiteSpeed Cache → Purge All.

## Có gì mới – plugin 2.20.36: Vịnh An Hòa City (mới) + cập nhật Nam Hội An City
- **Vịnh An Hòa City** (trang mới, khu vực mới **Núi Thành**): khu đô thị sinh thái 99,6 ha ven vịnh An Hòa – sông Trường Giang, gần sân bay Chu Lai; đất nền 150 – 160 m² giá rao 2026 khoảng 8 – 11 triệu/m², bảng biệt thự Hoa Sứ, biệt thự Nhật Bản, nhà vườn Mỹ; mục sân bay Chu Lai mở rộng.
- **Nam Hội An City** cập nhật chi tiết: tên pháp lý Khu đô thị Nồi Rang, chủ đầu tư Chu Lai Hội An (FVG) nhận chuyển nhượng 2020, khách sạn Fivitel + resort Fivires (gần 750 tỷ) khởi công 3/9/2025, bảng giá chuyển nhượng 2025 – 2026 (35 – 62 triệu/m²), tiến độ, câu hỏi thường gặp. Chuyển sang "Đã bàn giao" (hiện mục chuyển nhượng – cho thuê). Bỏ dòng "1 tòa căn hộ 30 tầng" vì chưa có nguồn xác nhận. Ô nào anh đã tự sửa thì giữ nguyên.
- Tiêu đề SEO tự động cho nhà phố – shophouse đã bàn giao: "{Tên}: Giá chuyển nhượng {tháng}".
- Cài: Nhập nhanh `cap-nhat-code.zip` → **Nhập dữ liệu Đà Nẵng → Nhập / cập nhật dữ liệu** → LiteSpeed Cache → Purge All.

## Có gì mới – plugin 2.20.35, giao diện 2.15.12: 8 trang dự án đất nền Điện Ngọc
- **8 trang dự án mới** (loại Đất nền, khu vực Điện Bàn), mỗi trang có vị trí, quy mô, bảng giá rao tham khảo 2026, lưu ý pháp lý, câu hỏi thường gặp và liên kết sang các dự án Điện Ngọc khác:
  Khu đô thị 1A 1B · Khu đô thị số 3 · Khu đô thị 7B (Coco Center House, Sentosa City) · Khu đô thị số 9 · Phố chợ Điện Ngọc · Sentosa Riverside (Peaceful Land) · GAIA City · Tropical Palm (Ngọc Dương Riverside mở rộng).
- Ảnh đại diện là đồ hoạ tự vẽ (sơ đồ minh hoạ + thẻ thông tin nhanh), không dùng ảnh của sàn khác.
- Giá là **giá rao tham khảo**, không phải giá giao dịch; các dự án có vướng mắc pháp lý (Sentosa Riverside chậm ra sổ, khu số 9 chậm nghiệm thu) đều ghi rõ lưu ý.
- Tiêu đề SEO tự động cho đất nền đã bàn giao đổi thành "{Tên}: Giá đất, pháp lý {tháng}" (trước là "Bảng giá, chính sách") – chỉ đổi tiêu đề do web tự tạo, tiêu đề anh sửa tay giữ nguyên.
- Chú thích ảnh tổng quan dự án lấy theo mô tả ảnh (alt) thay vì luôn ghi "Phối cảnh".
- Cài: Nhập nhanh `cap-nhat-code.zip` → **Nhập dữ liệu Đà Nẵng → Nhập / cập nhật dữ liệu** (bắt buộc, để tạo 8 trang) → LiteSpeed Cache → Purge All.

## Có gì mới – giao diện 2.15.11, plugin 2.20.34: hoa văn lưới kẻ ô + sóng biển mờ
- **Chân trang web** (nền xanh navy): thêm lưới kẻ ô rất mờ và 3 đường sóng biển mờ sát đáy. Chỉ là CSS, không ảnh hưởng tốc độ.
- **Ảnh bản đồ giá căn hộ sông Hàn**: dải tiêu đề và dải chú thích có lưới kẻ ô mờ, dải dưới có sóng biển mờ, thêm viền vàng ngăn cách với bản đồ.
- Cài: Nhập nhanh `cap-nhat-code.zip` → LiteSpeed Cache → Purge All. Ảnh trong bài cập nhật ngay (cùng đường dẫn), nếu trình duyệt còn ảnh cũ thì Ctrl+F5.

## Có gì mới – plugin 2.20.33, 2.20.32: bảng giá 21 dự án căn hộ view sông Hàn

- 2.20.33: bản đồ trong bài ghi tên + giá từng dự án ngay trên bản đồ (khung nhãn có đường nối về vị trí), nền navy.

- Bài "Căn hộ view sông Hàn" thêm mục bảng giá rao 21 dự án hai bờ (xếp hạng cao → thấp, link sang 9 trang dự án có trên web) và bản đồ vị trí – giá (nền navy). Tiêu đề, mô tả, hỏi đáp cập nhật theo; bài lên đầu Tin tức. Số liệu giá rao: Biggee.vn.

## Có gì mới – plugin 2.20.31: ảnh giá căn hộ ven sông Hàn

- Bài "Căn hộ view sông Hàn" có ảnh đại diện: xếp hạng giá rao 21 dự án hai bờ sông Hàn (số liệu Biggee.vn, tự vẽ lại). Ảnh dọc bản đồ sông Hàn để đăng Zalo: bai-viet/gia-can-ho-song-han-10-2026-zalo.jpg.

## Có gì mới – giao diện 2.15.10: căn đều 2 bên

- Đoạn văn, danh sách trong bài viết, trang dự án, tin rao căn đều 2 bên (bảng, chú thích ảnh vẫn căn trái); tự tách chữ để không hở khoảng trắng trên điện thoại.
- Khung soạn bài trong quản trị dùng cùng kiểu chữ, căn đều như trang xem.

## Có gì mới – plugin 2.20.30: SEO bài giá đất ven biển (Rank Math)

- Mật độ từ khoá "giá đất ven biển Đà Nẵng" từ 0,23% lên khoảng 1,06% (21 lần / khoảng 1.975 chữ): từ khoá nằm trong tiêu đề các mục H2 và câu mở đầu từng tuyến, viết tự nhiên.
- Link nguồn chính thống (Cổng thông tin TP Đà Nẵng, LuatVietnam – Nghị quyết 28/2026) để dofollow; link trang rao vặt vẫn nofollow. Bài mới có thể đặt `follow_domains` cho nguồn nhà nước.

## Có gì mới – plugin 2.20.29: bài cập nhật lên đầu Tin tức

- Bài "Giá đất ven biển Đà Nẵng" đã viết lại được đưa lên đầu mục Tin tức, ngày đăng là ngày cập nhật (đường dẫn giữ nguyên, không mất thứ hạng Google). Chỉ đổi ngày 1 lần.

## Có gì mới – plugin 2.20.28: giá đất ven biển Đà Nẵng chi tiết lô nhỏ, lô lớn

- **Bảng giá đất ven biển, đất lớn xây khách sạn** (trang Mua bán → Đất nền): mỗi trục biển tách 2 dòng **lô nhỏ, vừa** (dưới khoảng 350 m²) và **lô lớn**, kèm tin rao ví dụ: Hoàng Sa, Võ Nguyên Giáp, Trường Sa, Nguyễn Tất Thành (Thanh Khê – Hải Châu và Liên Chiểu), Lạc Long Quân (Điện Bàn – Hội An). Giá rao tháng 10/2026.
- **Bài "Giá đất ven biển Đà Nẵng"** (/gia-dat-ven-bien-da-nang-vo-nguyen-giap-hoang-sa/) viết lại chi tiết: bảng tổng hợp, từng tuyến lô nhỏ / lô lớn, bảng giá nhà nước (Nghị quyết 32/2025 → 28/2026), chọn lô nhỏ hay lô lớn, checklist, 6 câu hỏi đáp; ảnh biểu đồ giá; từ khoá chính "giá đất ven biển Đà Nẵng" + 5 từ khoá phụ (giá đất mặt tiền biển Đà Nẵng, giá đất Võ Nguyên Giáp, Hoàng Sa, Nguyễn Tất Thành, Trường Sa). Bài đã đăng được cập nhật đè (bản cũ còn trong Bản sửa đổi).
- 2 bài liên quan (khách sạn ven biển, bất động sản Liên Chiểu) sửa số cho khớp.
- Chat: hỏi giá đất theo tên đường trả cả lô nhỏ và lô lớn; sau mỗi lần nhập dữ liệu chat đọc lại giá mới ngay.
- Sau khi cài: **Dự án → Nhập dữ liệu Đà Nẵng → Nhập / cập nhật dữ liệu**, rồi LiteSpeed Cache → Purge All.

## Có gì mới – plugin 2.20.27, giao diện 2.15.9: mục "Biệt thự sở hữu lâu dài"

- Menu **Dự án → Thấp tầng** có thêm **Biệt thự sở hữu lâu dài** (đứng đầu, trước Biệt thự nghỉ dưỡng, Đất nền, Nhà phố – Shophouse). Menu đã tạo trên web tự có mục này, không cần sửa tay.
- Tự chuyển một lần:
  - Biệt thự khu đô thị, sổ lâu dài → chỉ ở mục mới: Sunneva Island, Newtown Legend, Euro Village 2, KĐT sinh thái Hòa Xuân, Sun Riverpolis, Đất nền Đầm Sen, Vinhomes Hải Vân Bay Khu 1 – 3, Casamia Calm.
  - Biệt thự resort có sổ lâu dài → ở cả hai mục: Vinpearl Nam Hội An, Vinpearl Resort & Spa Đà Nẵng, Vinpearl Luxury Đà Nẵng, Hoiana Shores, Vinhomes Hải Vân Bay.
  - Sau lần chuyển này bạn tự gắn lại loại cho dự án nào thì web giữ nguyên.
- Trang /en/, /ko/: "Freehold villas" / "영구 소유 빌라". Chat lọc biệt thự gồm cả 2 loại.

## Có gì mới – plugin 2.20.26: nhắc nhập dự án mới

- Cài gói code có dự án mới (VD Sunneva Island) mà chưa bấm "Nhập / cập nhật dữ liệu" → trang quản trị hiện dòng vàng "Có N dự án mới trong bản cập nhật chưa lên web" kèm nút **Nhập dữ liệu ngay**.

## Có gì mới – plugin 2.20.25: chat tự động "hỏi gì cũng biết", biết đùa

- **Kiến thức sẵn có:** chat AI đọc toàn bộ giá dự án trên web (giá bán, giá bán lại, giá thuê, vị trí, pháp lý, link), bảng giá đất lớn theo tuyến đường, giá khách sạn ven biển, 30 bài tin tức và 40 tin rao mới nhất. Tự làm mới khi đăng / sửa dự án, bài, tin rao.
- **Tra cứu web:** khách hỏi điều web chưa có (giá đất một tuyến đường, bảng giá nhà nước, quy hoạch, khách sạn, đường đi, tin mới…) → AI tự tìm trên web, ưu tiên nguồn chính thống, nói rõ nguồn và thời điểm. Tắt / bật ở Khách hàng → Chat trên web → "Tra cứu web".
- **Hóm hỉnh:** khách đùa ("em có người yêu chưa", "đắt quá trời", "bot à") → đáp dí dỏm, lịch sự, rồi khéo đưa về nhu cầu nhà đất. Hỏi về Đà Nẵng (đường, khách sạn, ăn uống, du lịch) cũng trả lời ngắn gọn.
- **Chưa có API key (chế độ kịch bản):** cũng biết đùa lại, tra giá đất / khách sạn theo tên đường trong bảng giá, và trả lời giá + link khi khách gõ tên một dự án bất kỳ.
- Câu cần tra web mất lâu → khung chat hiện "Em đang tra cứu số liệu mới nhất…".
- Chi phí ước tính (có API key, mô hình Opus 5.5): mỗi câu trả lời khoảng 500 – 1.000 đồng; phần kiến thức (khoảng 30.000 token) lưu đệm 1 giờ, mỗi giờ có khách chat tốn thêm khoảng 6.000 đồng để nạp lại; mỗi lần tra web thêm khoảng 250 đồng. Muốn rẻ hơn: chọn Sonnet 5.5 (khoảng một nửa) hoặc tắt "Tra cứu web". Giới hạn lượt / ngày vẫn như cũ.

## Có gì mới – plugin 2.20.20, giao diện 2.15.8: trang dự án Sunneva Island

- 2.20.24: sơ đồ mặt bằng có chữ mờ "hiephoangmt.com" xếp chéo khắp bản đồ; sơ đồ cũ tự gỡ.
- 2.20.23: sơ đồ mặt bằng tô lại theo từng điểm màu của mặt bằng tổng thể – đúng vị trí từng dãy lô, đường, 2 cầu, sông; bỏ chữ, logo bản gốc; sơ đồ cũ tự gỡ.
- 2.20.22: vẽ lại sơ đồ mặt bằng theo đúng bố cục: đảo hướng Tây Bắc – Đông Nam, cầu phía Bắc (chân cầu giữa Habora và Rivera → đường Chương D, hướng biển), cầu phía Nam (góc Habora – Centria → KĐT Nam Hòa Xuân); sơ đồ cũ tự gỡ khỏi trang.
- 2.20.21: thêm ảnh phối cảnh mặt tiền biệt thự (thư viện ảnh).
- 2.20.20: thêm 2 ảnh phối cảnh biệt thự (ảnh đại diện + thư viện), vị trí cạnh cầu Minh Mạng – KĐT Nam Hòa Xuân, rút gọn ô Pháp lý / Bàn giao.

- Trang mới **/du-an/sunneva-island/** – Sunneva Island (tên văn bản: Khu đô thị ven sông Hòa Quý – Đồng Nò, CTCP Địa Cầu – Sun Group): quy mô, 3 phân khu Habora / Centria / Rivera, sơ đồ mặt bằng tự vẽ, tiện ích, giá tham khảo, hỏi đáp, người nước ngoài được mua tối đa 250/390 biệt thự (đợt 4 – 11/2024).
- Bài người nước ngoài và trang /en/, /ko/ có link sang trang Sunneva Island.
- Sau khi cài: **Dự án → Nhập dữ liệu Đà Nẵng → Nhập / cập nhật dữ liệu** để tạo trang (ảnh mặt bằng tải ngầm).

## Có gì mới – giao diện 2.15.7: tên thương mại cho dự án người nước ngoài (/en/, /ko/)

- Danh sách dự án người nước ngoài được mua trên /en/ và /ko/ dùng tên đang bán trên thị trường, kèm tên ghi trong văn bản: Sun Symphony Residence (Olalani Riverside Towers), Sun Cosmo – The Panoma (B4-1, B4-2), Sunneva Island (Hòa Quý – Đồng Nò), The Royal Boutique Hotel & Condo (Tháp ven sông), Đà Nẵng Landmark Tower.
- Sun Symphony, Sun Cosmo có nút "Project details" sang trang dự án; Sun Symphony đánh dấu đang có hàng; bản đồ tìm theo tên thương mại.
- Thêm số tổng căn: Sun Cosmo 203/679, Sunneva 250/390.
- Thêm dòng cảnh báo: Vinhomes Hải Vân Bay không nằm trong danh sách cho người nước ngoài.
- Cài bằng **Dự án → Nhập nhanh** với `cap-nhat-code.zip`, rồi LiteSpeed Cache → Purge All.

## Có gì mới – giao diện 2.15.6: trang /en/, /ko/ có danh sách dự án người nước ngoài được mua + bản đồ

- Mục mới "Projects approved for foreign ownership" / "다낭 외국인 소유 허용 프로젝트": 9 dự án theo các đợt công bố 4 – 7 (11/2024 – 2026), tên gọi theo văn bản, chủ đầu tư, số căn tối đa cho người nước ngoài, nhãn "đang có tin rao bán".
- Bấm "Show on map" / "지도에서 보기" ở từng dự án: bản đồ Google bên cạnh (điện thoại: phía trên) chuyển tới vị trí dự án. Dự án có tọa độ trong trang dự án thì dùng tọa độ đó.
- Dữ liệu sửa ở hàm hh_foreign_projects() trong giao diện/inc/lang-strings.php.

## Có gì mới – giao diện 2.15.5 + plugin 2.20.18: chiết khấu hiện số cộng thẳng

- Bảng chiết khấu theo phương án: cột Tổng chiết khấu hiện tổng cộng thẳng các khoản ở cột "Cách tính" (VD F2: 3% + 3% + 12% = **18%**), dòng nhỏ bên dưới "Thực giảm 17,2% giá niêm yết" (số trừ nối tiếp, khớp phiếu tính giá). Không cần sửa dữ liệu: web tự cộng từ cột Cách tính.
- Dải con số đầu trang ("Chiết khấu tới") cũng dùng số cộng thẳng.
- Sun Solar: tiêu đề ưu đãi và con số nổi bật đổi ~18,8% → **20%** (5% + 5% + 10%) khi bấm Nhập / cập nhật dữ liệu (chỉ thay nếu anh chưa sửa tay).

## Có gì mới – giao diện 2.15.4 + plugin 2.20.17: bản dịch Google sửa địa danh, tên dự án, cụm từ BĐS trong câu

- Địa danh: "cầu sông Hàn" trước bị Google dịch thành 한강대교 (cầu ở Seoul) → nay "다낭 한강교"; thêm cầu Rồng (용다리), biển Mỹ Khê (미케 비치), bán đảo Sơn Trà (선짜 반도), Bà Nà (바나힐), phố cổ Hội An, sân bay Đà Nẵng, pháo hoa DIFF…
- Tên dự án và thương hiệu giữ nguyên chữ Latin (không còn "썬솔라 레지던스"): tên dự án bỏ dấu, Sun Group, Sun Property, VietinBank…
- Cụm từ BĐS trong câu: chủ đầu tư (시행사), sở hữu lâu dài (영구 소유), sổ hồng (핑크북), thông thủy / tim tường (전용면적 / 공급면적), bảo lãnh ngân hàng, hợp đồng mua bán (SPA), chiết khấu, thanh toán sớm, đặt cọc…
- Tiêu đề trang dự án: "Bảng giá, chính sách bán hàng" → 분양가표·분양 정책; "Ưu đãi & chính sách tháng" → 혜택·분양 정책.
- Thêm cụm từ: hàm hh_lang_phrases() trong hh-crm/ngon-ngu.php.

## Có gì mới – giao diện 2.15.3: danh sách dự án trên /en/, /ko/ dễ đọc hơn

- Tên dự án bỏ dấu, bỏ phần tiếng Việt trong ngoặc ("FourS Tower (Tháp Bốn Mùa) Đà Nẵng" → "FourS Tower Da Nang").
- Ngày bàn giao theo kiểu từng nước: "28 April 2027" / "2027년 4월 28일"; quý: "Q1 2027" / "2027년 1분기". Tiếng Hàn dùng "입주(인도)".
- Dự án mẹ chưa có giá thì lấy giá thấp nhất của tòa / phân khu con (VD FourS lấy từ Tòa F2).

## Có gì mới – giao diện 2.15.1 + plugin 2.20.16: bản dịch Google dùng thuật ngữ BĐS chuẩn

- Khi xem trang qua bản dịch Google (EN / KO), khoảng 70 nhãn quan trọng được thay sẵn bằng bản dịch chuẩn trước khi Google dịch: tình trạng (분양 중, 분양 예정, 입주 완료…), loại dự án, menu, mục lục trang dự án, bảng thông tin (시행사 = chủ đầu tư, 총 세대수, 법적 상태…), nút liên hệ, ô tìm kiếm.
- Nút VI · EN · KO không bị Google dịch nhầm nữa (trước đây KO thành "아니요"), hiện đúng ngôn ngữ đang xem; bấm VI về trang gốc.
- Nhãn HOT không bị dịch thành "더운".
- Thêm thuật ngữ: sửa hàm hh_lang_glossary() trong hh-crm/ngon-ngu.php.

## Có gì mới – giao diện 2.15.0 + plugin 2.20.15: trang tiếng Anh /en/ và tiếng Hàn /ko/

- Nút **VI · EN · KO** trên đầu mọi trang.
  - Trang chủ → trang riêng /en/, /ko/ (viết tay, thuật ngữ BĐS chuẩn, có SEO riêng: tiêu đề, mô tả, thẻ lang, hreflang).
  - Các trang tiếng Việt khác (dự án, tin…) → bản dịch tự động của Google (translate.goog), không tạo trang trùng lặp.
- Nội dung /en/, /ko/: giới thiệu Hiệp, quy định người nước ngoài sở hữu nhà (Luật Nhà ở 2023: hạn mức 30% căn/tòa, 50 năm, sổ hồng đứng tên), dự án đang bán (giá từ quy ra tỷ / 억 동), dịch vụ, quy trình 6 bước, hỏi đáp, form liên hệ.
- Khách gửi form ở /en/, /ko/ vào mục Khách hàng với nhu cầu "Khách nước ngoài (EN/KO) – …".
- Trang /en/, /ko/ tự tạo khi cài bản này (Trang → "Da Nang Real Estate for Foreign Buyers", "다낭 부동산 – 외국인 구매 안내"). Không xoá 2 trang này.
- Lần đầu: **Cài đặt → Đường dẫn tĩnh → Lưu** nếu /en/ báo không tìm thấy.

## Có gì mới – giao diện 2.14.2: chọn loại căn không phải cuộn tìm ảnh

- Máy tính: danh sách loại căn dài thì cuộn riêng, khung ảnh layout bám theo màn hình nên bấm căn nào cũng thấy ảnh ngay bên cạnh.
- Điện thoại: bấm loại căn thì trang tự đưa hàng chọn căn + ảnh layout vào màn hình, chip đang chọn nằm giữa.

## Có gì mới – giao diện 2.14.1: thẻ loại căn có hình minh họa

- Mục Layout căn: dự án chưa có ảnh layout thật thì hiện thẻ từng loại căn (Studio, 1PN, 2PN, 3PN, Duplex, Penthouse, Shophouse) với **hình minh họa bố trí phòng tự vẽ** (ghi rõ "Hình minh họa"), diện tích, số phòng ngủ, giá từ (nếu có) và nút "Nhận layout & giá". Có ảnh layout thật thì vẫn hiện như cũ.

## Có gì mới – giao diện 2.14.0 + plugin 2.20.14: bố cục trang dự án mới

- **H1** = tên dự án + "Bảng giá, chính sách bán hàng tháng/năm" (dự án đã bàn giao: "Giá chuyển nhượng, cho thuê"); H2/H3 từng mục đều chứa tên dự án (Tổng quan dự án …, Vị trí …, Tiện ích … nội khu & ngoại khu, Mặt bằng …, Layout căn hộ …, Giá bán & chính sách …, Hồ sơ pháp lý …).
- **Giới thiệu:** dải con số nổi bật tự lấy từ dữ liệu – giá chỉ từ, chiết khấu tới, số căn, số tầng, quy mô, bàn giao.
- **Tổng quan:** ảnh phối cảnh bên cạnh bảng thông tin; ngay dưới là khung **Hồ sơ pháp lý** (trường mới *Hồ sơ pháp lý – mỗi dòng 1 văn bản*; trống thì lấy dòng Pháp lý + hình thức sở hữu) rồi CTA.
- **Vị trí:** ảnh vị trí/mặt bằng tổng thể bên cạnh bản đồ Google, gộp mục Liên kết vùng vào đây, CTA đặt lịch tham quan.
- **Giá & chính sách:** thẻ "giá chỉ từ" theo từng loại căn (Studio, 1PN, 2PN…), thẻ rẻ nhất gắn nhãn *Giá tốt nhất*, nút *Giữ căn này*; tiếp theo banner ưu đãi có đồng hồ đếm ngược. Giá lấy từ Loại căn, Bảng giá hoặc Bảng tính căn – không có giá thì ẩn thẻ.
- Sửa lỗi: sau mục Tiện ích/Mặt bằng, trang dự án có thể lấy nhầm ID ảnh làm ID dự án (thẻ giá, tin liên quan không hiện).
- Spana Tower: văn bản pháp lý chuyển sang mục Hồ sơ pháp lý; Điểm nổi bật viết lại theo vị trí, quy mô, tiện ích.

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
