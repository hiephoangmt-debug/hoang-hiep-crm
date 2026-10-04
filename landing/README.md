# Giỏ Hàng Hải Vân Bay – www.giohanghaivanbay.com

- `src/page.html`: file gốc duy nhất cần sửa (nội dung, giỏ hàng `UNITS`, tin tức).
- `src/img/`: ảnh phối cảnh (webp).
- `python3 landing/build.py` → sinh `dist/`:
  - `index.html` → `/` (link chính, đầy đủ)
  - `gio-hang.html` → `/gio-hang`, `chinh-sach.html` → `/chinh-sach`,
    `tinh-gia.html` → `/tinh-gia`, `tin-tuc.html` → `/tin-tuc` (link phụ)
  - `bach-van.html`, `vinh-may.html`, `dao-ngoc.html`, `tinh-van.html` → trang phân khu
    (nội dung, FAQ, ảnh trong `zones.py`)
  - `sitemap.xml`, `robots.txt`, `img/`

Link từng căn: `/gio-hang?can=VM-04`.
