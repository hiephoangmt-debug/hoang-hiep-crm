# Câu lệnh dựng "e-City Đà Nẵng" – bản đồ số 3D kiểu điều hành đô thị

Tài liệu này phân tích 6 ảnh mẫu (e-City TP.HCM) và đưa ra câu lệnh (prompt) để dựng bản tương tự cho Đà Nẵng.
Dán từng câu lệnh vào Claude Code (trong repo `hoang-hiep-crm`), làm lần lượt từ bước 1.

---

## 1. Ảnh mẫu có những gì

| Ảnh | Màn hình | Thành phần chính |
|---|---|---|
| 1 | **Flood Lab – Điều hành ngập 3D** | Mưa rơi, lớp nước dâng theo cao độ nền, cột đỏ cảnh báo tại điểm ngập (tên đường), bảng kịch bản: mưa tích luỹ 0–200 mm, mực triều 1,40–1,80 m (BĐ I–III), độ sâu, thời gian ngập; nút "Dừng mưa", "Zoom tuyến ngập", "Kịch bản xấu nhất"; dòng cảnh báo "Stress test – không phải dự báo" |
| 2 | **Toàn thành phố** | Nhà 3D toàn đô thị, mỗi phường một màu nền, tên phường, toà biểu tượng tô màu nổi bật, thước tỉ lệ, "Lọc bản đồ", mức chi tiết tự giảm khi zoom xa ("khối nhà gần đúng · chi tiết thích nghi") |
| 3, 6 | **Cận cảnh "Vật liệu đô thị"** | Nhà có cửa sổ, mái có bồn nước, cây xanh, đường, nhãn địa danh (Bitexco, Nhà hát, Nguyễn Huệ), cầu dây văng Ba Sơn, sông, công viên; nhãn dự án ("Grand Marina · 4 tháp") |
| 4 | **Trang phường – Hạ tầng** | Tab: Tổng quan / Hạ tầng / Quy hoạch / Giao thông / Công trình / Ngập–rủi ro / Điều hành; 3D cắt theo ranh phường trên nền Copernicus DSM; ghim theo nhóm HC (hành chính), AT (an toàn–PCCC), GT (giao thông), CC (không gian công cộng), TM (chợ–thương mại), KT (hạ tầng kỹ thuật) kèm số lượng; danh sách tìm kiếm; 4 chỉ số: dân số, mật độ, doanh nghiệp, cơ sở y tế–giáo dục |
| 5 | **Trang phường – Tổng quan** | Cả phường là một khối đảo nổi 3D (địa hình + ảnh vệ tinh, vách cắt màu xanh), "Toàn địa bàn / Vùng chính / Cận cảnh", bảng "Bốn twin": Quy hoạch–kiến trúc, Giao thông, Đầu tư–xây dựng, Kiểm soát ngập; "Đánh giá phương án A/B" |

**Nguồn dữ liệu ghi ở chân ảnh:** Copernicus (nền đất DSM), Overture (khối nhà), OpenStreetMap (đường, POI, ranh giới). Đây đều là dữ liệu mở, dùng được cho Đà Nẵng. Bản Sông Hàn 3D hiện tại đã dùng Overture và ảnh vệ tinh, nên làm tiếp được trên nền đó.

---

## 2. Công nghệ đề xuất

- **Khung bản đồ:** MapLibre GL JS (miễn phí) cho bản đồ toàn thành phố: nhà `fill-extrusion`, địa hình `raster-dem`, ranh phường, nhãn, lọc lớp. Dùng three.js (đang dùng ở Sông Hàn 3D / Đà Nẵng 3D) cho cận cảnh và công trình biểu tượng (tháp 408 m, cầu Rồng…), gắn vào MapLibre qua *custom layer*.
- **Dữ liệu tải qua GitHub Actions** (máy dựng không vào mạng trực tiếp được), lưu vào nhánh `claude/danang-data`:
  - Khối nhà: Overture Maps `building` (CLI `overturemaps download --type=building`), ghép chiều cao/số tầng OSM.
  - Nền đất: Copernicus DEM GLO-30 (AWS Open Data `copernicus-dem-30m`) → cắt khung Đà Nẵng → tile Terrarium.
  - Ảnh vệ tinh: Esri World Imagery (đã dùng) hoặc Sentinel-2 cloudless (EOX).
  - Đường, POI, ranh phường: OpenStreetMap qua Overpass (`boundary=administrative`, `admin_level` cấp phường; kiểm tra ranh phường mới sau sáp nhập 1/7/2025, nếu OSM chưa cập nhật thì vẽ tay theo nghị quyết).
  - Dân số / doanh nghiệp: số công bố của Cục Thống kê / UBND TP (nhập tay vào JSON, ghi rõ năm).
  - Ngập: danh sách điểm ngập công bố (báo, Sở Xây dựng), cao độ nền DSM, mực nước sông Hàn tham chiếu.
- **Xuất bản:** GitHub Pages (`floorplan-3d/public/e-city/`), nhúng vào hiephoangmt.com bằng nút 4D hoặc trang "Bản đồ dự án".

---

## 3. Câu lệnh mẫu

### Bước 0 – Câu lệnh tổng (dán đầu tiên)

```
Dựng web app "e-City Đà Nẵng" tại floorplan-3d/public/e-city/ – bản đồ số 3D điều hành đô thị
giống bộ ảnh mẫu e-City TP.HCM (giao diện tối, thanh menu trái: Điều hành, Quy hoạch, Dịch vụ,
Tương lai, Vùng, Khu vực, Tham quan, Phân tích, Dữ liệu; ô tìm kiếm trên cùng; nút Dashboard,
ẩn nhãn, toàn màn hình). Tiếng Việt toàn bộ.
Công nghệ: MapLibre GL JS (bản đồ chính) + three.js custom layer cho công trình biểu tượng.
Dữ liệu mở: Overture (nhà), Copernicus DEM GLO-30 (nền đất), OSM (đường, POI, ranh phường),
Esri World Imagery (ảnh vệ tinh). Tải dữ liệu bằng GitHub Actions trên nhánh claude/danang-data
(máy dựng không vào mạng được), xuất file tĩnh gọn (PMTiles hoặc nhị phân tự định dạng, < 15 MB
cho khu trung tâm).
Chân trang luôn ghi nguồn: "Copernicus · Overture · OpenStreetMap". Chạy tốt trên điện thoại.
Làm theo từng bước tôi gửi sau; bước này chỉ dựng khung giao diện + bản đồ nền + ảnh vệ tinh.
```

### Bước 1 – Toàn thành phố theo phường (ảnh 2)

```
Thêm chế độ "Toàn thành phố" cho e-City Đà Nẵng:
- Khối nhà Overture toàn Đà Nẵng (Hải Châu, Thanh Khê, Sơn Trà, Ngũ Hành Sơn, Liên Chiểu, Cẩm Lệ,
  Hòa Vang ven đô, Hội An), cao theo height/num_floors của Overture/OSM, nhà không có số liệu
  ước lượng theo diện tích (ghi rõ "ước lượng").
- Nền đất Copernicus DSM, phóng đại độ cao x1.5 cho núi Sơn Trà, Ngũ Hành Sơn, Hải Vân.
- Ranh các phường mới (sau sáp nhập 2025) tô nền mỗi phường một màu nhạt, tên phường ở giữa.
- Toà biểu tượng tô màu nổi bật và có nhãn: tháp 408 m Da Nang Downtown, Sun Galaxy, Hiyori,
  Trung tâm Hành chính, Novotel, Hilton, các dự án tôi đang bán (lấy từ da-nang-3d/projects.js).
- Mức chi tiết tự động: zoom xa thì gộp khối, zoom gần hiện cửa sổ; thước tỉ lệ góc trái dưới;
  nút "Lọc bản đồ" bật/tắt lớp: nhà, đường, ranh phường, dự án, POI.
- Dòng trạng thái dưới cùng: "Đà Nẵng · Zoom 15.2 · Khối nhà gần đúng · chi tiết thích nghi".
```

### Bước 2 – Cận cảnh "Vật liệu đô thị" (ảnh 3, 6)

```
Thêm chế độ cận cảnh "Vật liệu đô thị" cho khu trung tâm hai bờ sông Hàn (dùng lại
song-han-3d: bld.bin, sat.jpg, cau.js, thap408.js):
- Mặt nhà có cửa sổ theo tầng (shader), màu tường kem ấm, kính xanh cho cao tầng, mái có bồn nước
  và cục máy lạnh nhỏ, cây xanh từ ảnh vệ tinh, vỉa hè và lòng đường có vạch.
- Nhãn địa danh dạng thẻ tối chữ vàng: Cầu Rồng, Cầu Trần Thị Lý, Cầu Sông Hàn, Bạch Đằng,
  Bảo tàng Chăm, Chợ Hàn, Nhà thờ Con Gà, Trung tâm Hành chính, Da Nang Downtown.
- Cầu dựng 3D đúng trục OSM: cầu Sông Hàn (cầu quay), Rồng, Trần Thị Lý, Nguyễn Văn Trỗi,
  Thuận Phước (dây võng), Tiên Sơn.
- Bảng "Điều khiển cảnh" góc phải: Vật liệu đô thị / Khối trắng / Ban đêm / Giờ trong ngày.
```

### Bước 3 – Trang phường (ảnh 4, 5)

```
Thêm trang "Địa bàn điều hành" cho từng phường Đà Nẵng (bắt đầu: Hải Châu, An Hải, Sơn Trà,
Ngũ Hành Sơn, Hòa Xuân):
- Tiêu đề "Phường X" + mã đơn vị hành chính; tab Tổng quan / Hạ tầng / Quy hoạch / Giao thông /
  Công trình / Ngập–rủi ro / Điều hành.
- Khung 3D cắt đúng ranh phường, nền Copernicus DSM + ảnh vệ tinh, vách cắt màu xanh đậm như
  khối đảo nổi; nút Toàn địa bàn / Vùng chính / Cận cảnh; toạ độ tâm và la bàn góc trên phải.
- Ghim POI từ OSM theo nhóm: HC hành chính, AT an toàn–PCCC, GT giao thông (bến, bãi xe),
  CC không gian công cộng, TM chợ–thương mại, KT hạ tầng kỹ thuật; ô đếm số lượng mỗi nhóm,
  danh sách tìm theo tên, bấm vào thì bay tới.
- 4 chỉ số dưới bản đồ: dân số, mật độ, số doanh nghiệp, cơ sở y tế–giáo dục – lấy từ file
  data/phuong.json do tôi nhập (ghi năm và nguồn; ô nào chưa có số thì để "chưa có dữ liệu").
- Tab Công trình: liệt kê dự án BĐS trong phường (từ projects.js) với giá, quy mô, link trang dự án.
```

### Bước 4 – Flood Lab: mô phỏng ngập (ảnh 1)

```
Thêm "Flood Lab – Điều hành ngập 3D" cho e-City Đà Nẵng:
- Hiệu ứng mưa (hạt mưa xiên), lớp nước phẳng dâng theo mực nước chọn, che những ô có cao độ
  nền DSM thấp hơn mực nước (tính trên GPU từ tile DEM).
- Bảng kịch bản: thanh "Mưa tích luỹ" 0–300 mm, "Mực nước sông Hàn" (mốc báo động I/II/III
  của trạm Cẩm Lệ/Hội An – nhập trong data/ngap.json), "Gió"; nút Dừng mưa, Zoom tuyến ngập,
  Kịch bản xấu nhất; kịch bản mẫu "Lũ lịch sử 2022 (mưa ~900 mm/24h)".
- Cột đỏ cảnh báo tại các điểm ngập công bố ở Đà Nẵng (nhập trong data/ngap.json: tên đường,
  toạ độ, độ sâu đã ghi nhận, thời gian ngập), bấm vào hiện thẻ thông tin.
- Luôn hiện băng đỏ "STRESS TEST · KHÔNG PHẢI DỰ BÁO" và ghi rõ đây là mô phỏng trực quan theo
  cao độ, không phải mô hình thuỷ lực.
```

### Bước 5 – Lớp dự án bất động sản (phục vụ bán hàng)

```
Thêm lớp "Dự án" vào e-City Đà Nẵng: lấy toàn bộ dự án trong da-nang-3d/projects.js và
du-an-da-nang.geojson, vẽ ranh/khối 3D đúng vị trí, tô màu theo trạng thái (đang bán / sắp mở
bán / đã bàn giao), nhãn kiểu "Cora Tower · 2 tháp", bấm vào hiện bảng giá, chính sách, nút gọi
0904 567 009 và Zalo. Thêm nút "Đánh giá phương án A/B" để so sánh 2 dự án cạnh nhau (giá/m²,
khoảng cách tới biển, sông, trung tâm).
```

---

## 4. Lưu ý

- **Ngập chỉ là mô phỏng trực quan.** e-City cũng ghi "Stress test – không phải dự báo". Muốn dự báo thật cần mô hình thuỷ lực và số liệu quan trắc; không nên trình bày cho khách như dự báo.
- **Chiều cao nhà:** Overture/OSM ở Đà Nẵng có rất ít số tầng. Toà nào quan trọng thì nhập tay (tên, số tầng), phần còn lại ghi "ước lượng".
- **Ranh phường mới 2025:** kiểm tra OSM trước khi dùng. Nếu chưa cập nhật thì cần file ranh từ nghị quyết.
- **Dung lượng:** toàn thành phố nên chia tile (PMTiles) để điện thoại mở nhanh. Khu trung tâm như Sông Hàn 3D hiện khoảng 3,4 MB.
- **Bản quyền:** ghi nguồn Copernicus, Overture, OpenStreetMap, Esri ở chân trang.
