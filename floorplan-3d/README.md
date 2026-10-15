# Nhà 3D – Mặt bằng 2D → 3D chân thực

Ứng dụng web vẽ / nhập mặt bằng 2D và dựng ngay thành căn hộ 3D sinh động: nội thất, ánh sáng theo giờ, bóng đổ, rèm cửa, đèn LED hắt, đi bộ trong nhà, render ảnh như thật, view ngoài cửa sổ từ ảnh 360° và **bóc tách – dự toán chi phí**.

## Chạy thử

```bash
cd floorplan-3d
npm install
npm run dev        # mở http://localhost:5173
npm run build      # bản tĩnh trong dist/ (upload lên hosting bất kỳ)
```

## Tính năng

**Mặt bằng 2D**
- Vẽ tường liên tiếp, phòng chữ nhật / đa giác (tự tạo tường bao), cửa đi, cửa sổ, cửa kính lùa.
- Bắt điểm đầu tường, khoá góc 45°, đường gióng, hiện kích thước, kéo tường kéo theo khớp nối.
- 26+ món nội thất kéo thả, tự áp lưng vào tường, xoay, nhân bản, đổi kích thước.
- **Từ ảnh mặt bằng**: tải ảnh/bản scan → hiệu chỉnh tỉ lệ → *Tự nhận diện tường + cửa* (Otsu + phép mở hình thái + tách nét ngang/dọc) → *Tự tạo phòng*.
- Hoàn tác/làm lại, lưu/mở file JSON, tự lưu vào trình duyệt.

**3D**
- Đồng bộ trực tiếp khi sửa 2D; hiệu ứng “dựng nhà”; góc nhìn cao cắt ngang như ảnh phối cảnh; mặt cắt tường màu than.
- Nắng & bóng đổ theo giờ trong ngày, ban đêm tự bật đèn, LED hắt viền trần, rèm 2 lớp, len chân tường, vách lam gỗ.
- **7 phong cách có sẵn**: Hiện đại sang trọng, Scandinavian, Indochine, Japandi, Tân cổ điển, Industrial, Tối giản – đổi màu tường, gỗ, vải, rèm và vật liệu sàn theo loại phòng.
- **Tuỳ chỉnh màu**: tường, gỗ, gỗ đậm/cửa, sofa, ghế, chăn ga, điểm nhấn, tủ bếp, mặt đá, kim loại, rèm, thảm; đổi màu riêng từng món đồ; 14 vật liệu sàn (gỗ xương cá, óc chó, marble, gạch bông…).
- **🚶 Đi bộ trong nhà** (WASD + chuột), cửa tự mở khi lại gần, nhấp để mở/đóng cửa.
- **📸 Render ảnh thật**: path tracing (three-gpu-pathtracer) – ánh sáng, phản xạ, bóng mềm như ảnh chụp; đứng yên camera để ảnh mịn dần.
- **View ngoài cửa sổ / lô-gia**: tải ảnh 360° (tỉ lệ 2:1) hoặc ảnh thường chụp từ đúng tầng căn hộ, chỉnh hướng; khai báo tầng để ẩn sân cỏ.
- Xuất ảnh PNG, xuất mô hình GLB (Blender, SketchUp, web).

**💰 Bóc tách & dự toán**
- Khối lượng tự động: sàn theo vật liệu (+5% hao hụt), sơn tường đã trừ cửa, trần thạch cao (thường/chống ẩm), len chân tường, đèn, LED, cửa chính/cửa phòng/cửa WC, cửa sổ, cửa lùa, rèm, vách lam, nội thất theo từng phòng.
- Đơn giá tham khảo sửa trực tiếp, hệ số phong cách, dự phòng %, VAT %, xuất Excel (CSV), in/PDF.

## Cấu trúc mã

| File | Vai trò |
| --- | --- |
| `src/model.js` | Dữ liệu mặt bằng, mẫu căn hộ, lịch sử hoàn tác, lưu tự động |
| `src/editor2d.js` | Trình vẽ 2D trên canvas |
| `src/builder.js` | Chuyển mặt bằng → cảnh Three.js |
| `src/viewer3d.js` | Trình xem 3D, ánh sáng, đi bộ, path tracing, view 360° |
| `src/furniture.js` | Thư viện nội thất (mô hình 3D + ký hiệu 2D) |
| `src/styles.js` | Phong cách & bảng màu |
| `src/textures.js` | Vân vật liệu sinh bằng canvas |
| `src/detect.js`, `src/autorooms.js` | Nhận diện tường từ ảnh, tự tạo phòng |
| `src/estimate.js` | Bóc tách khối lượng & dự toán |

## Đưa lên web (GitHub Pages)

Repo đã có sẵn workflow `.github/workflows/deploy-floorplan-3d.yml`: mỗi lần thay đổi trong `floorplan-3d/` được merge vào `main`, GitHub tự build và đăng lên Pages.

1. Vào repo trên GitHub → **Settings** → **Pages**.
2. Mục **Build and deployment → Source** chọn **GitHub Actions**.
3. Merge workflow vào `main` (hoặc vào tab **Actions** → *Deploy Nhà 3D lên GitHub Pages* → **Run workflow**).
4. Chờ 1–2 phút, địa chỉ trang hiện ở **Settings → Pages** và trong lần chạy workflow, dạng `https://<tài-khoản>.github.io/<tên-repo>/`.

Lưu ý: repo riêng tư chỉ dùng được Pages với gói GitHub Pro/Team/Enterprise; với gói miễn phí cần để repo công khai, hoặc đưa thư mục `dist/` lên Netlify / Vercel / Cloudflare Pages (kéo thả thư mục `dist` sau khi chạy `npm run build`).
