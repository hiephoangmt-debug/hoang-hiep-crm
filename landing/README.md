# Giỏ Hàng Hải Vân Bay – www.giohangvinhaivanbay.com

- `src/page.html`: file gốc duy nhất cần sửa (nội dung, giỏ hàng `UNITS`, tin tức).
- `src/img/`: ảnh phối cảnh (webp).
- `python3 landing/build.py` → sinh `dist/`:
  - `index.html` → `/` (trang chủ đầy đủ: cuối trang có chính sách, phân tích, tin tức)
  - `gio-hang.html` → `/gio-hang` (bảng hàng + chính sách, phân tích, tính giá, tin tức)
  - `bach-van.html`, `vinh-may.html`, `dao-ngoc.html`, `tinh-van.html` → trang phân khu
    (thông số, tiện ích, giá, mặt bằng, phân tích, FAQ trong `zones.py`; cuối trang có tin tức)
  - `sitemap.xml`, `robots.txt`, `img/`

Link từng căn: `/gio-hang?can=VM-04`.
