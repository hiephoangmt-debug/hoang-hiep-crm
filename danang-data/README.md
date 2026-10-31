# Đà Nẵng 3D (dữ liệu thật)

- `fetch.py` – tải dữ liệu thô OpenStreetMap (nhà, đường, sông, biển, cầu, địa danh) và địa hình Terrain Tiles về `raw/` (chạy bằng workflow `danang-data.yml`).
- `build.py` – chuyển dữ liệu thô thành dữ liệu gọn cho trang 3D: `python3 danang-data/build.py <thư-mục-đích>`.
- `web/index.html` – trang 3D (three.js). Đặt cạnh các file do `build.py` tạo ra; `bld.bin`, `dem.bin` được đọc dưới dạng base64 (`bld.txt`, `dem.txt`: `base64 -w0 bld.bin > bld.txt`).

Bản đồ © OpenStreetMap contributors (ODbL). Địa hình: Terrain Tiles (Mapzen, AWS Open Data).
