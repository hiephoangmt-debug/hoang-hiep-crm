# Website Cora Tower – www.cora-tower.com

Website tĩnh chuẩn SEO (HTML/CSS/JS thuần). Upload toàn bộ thư mục này lên **thư mục gốc** tên miền.

Các file HTML được sinh từ `tools/cora-tower/build.py` – sửa nội dung, giá, ảnh ở đó rồi chạy:

    python3 tools/cora-tower/build.py

| Trang | Từ khóa chính |
|---|---|
| `index.html` | Cora Tower, giá / mặt bằng Cora Tower, căn hộ 1PN+ |
| `khoi-de-shophouse.html` | shophouse khối đế Cora Tower |
| `penthouse.html` | penthouse / duplex Cora Tower |

## Đã có
- Title, description, canonical, Open Graph; schema RealEstateAgent, ApartmentComplex, Product, Apartment, FAQPage, Breadcrumb; sitemap có ảnh; robots.txt
- Ảnh WebP + JPG 2 kích cỡ, lazy-load, alt có từ khóa
- Nút Gọi / Zalo / Chat luôn đi theo khi cuộn (máy tính: góc phải; điện thoại: thanh dưới cùng)
- Chat tư vấn tự động (`assets/chat.js`): trả lời giá, loại căn, shophouse, duplex, vị trí, pháp lý, thanh toán, bàn giao, đặt lịch…, tự xin và nhận SĐT khách

## Nhận khách hàng về Google Sheet + email (bắt buộc làm)
Hiện `FORM_ENDPOINT` trong `assets/main.js` đang trống nên form và chat **chưa lưu** số khách.
Làm theo hướng dẫn ở đầu file `tools/cora-tower/google-apps-script.gs` (5 phút), dán URL vào `FORM_ENDPOINT`.
Mỗi khách mới sẽ ghi vào Sheet và gửi email tới hiephoangmt@gmail.com.

## Lưu ý nội dung
- Giá 1PN+ tầng 15 lấy từ bảng "rumor giá" – ghi rõ là giá dự kiến, chưa chính thức.
- Bàn giao 30/07/2027 là thông tin thị trường, cần đối chiếu hợp đồng.
