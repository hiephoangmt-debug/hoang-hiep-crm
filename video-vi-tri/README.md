# video-vi-tri — Video vị trí dự án BĐS bằng code

Dựng video dọc 1080×1920, 30fps, phong cách "bản đồ bay 3D". Nền xanh navy, chữ trắng, điểm nhấn cam:

1. **Mở đầu**: tiêu đề "VỊ TRÍ KIM CƯƠNG", camera hạ dần xuống bờ biển.
2. **Vị trí dự án**: khối dự án chia lô màu cam, ghim, tên dự án và tên đường nằm trên mặt đất, khoảng cách ra biển.
3. **Tiện ích**: cột sáng và thẻ cho các resort, kèm khoảng cách tính tự động.
4. **Kết nối vùng**: máy bay bay từ sân bay tới dự án, tiếp tục tới Hội An. Ranh giới Hội An phát sáng.
5. **Bay sát dự án**: các lô đất "mọc" lên 3D.
6. **Cảnh kết**: logo, tên dự án, hotline.

Dữ liệu bản đồ lấy từ Overture Maps (nguồn mở, gồm OpenStreetMap), không cần token.

## Chạy

```bash
npm install
npm run setup          # chép thư viện bản đồ + font vào public/
pip install pyarrow shapely numpy
npm run data           # tải dữ liệu bản đồ khu Đà Nẵng – Hội An (~1 phút)
npm run frames 380,660,1000   # chụp thử vài khung hình -> out/frames
npm run video          # xuất video có nhạc -> out/video.mp4 (render từng đoạn 5 giây, bị dừng thì chạy lại sẽ làm tiếp)
```

Render dùng Chromium. Nếu máy không có sẵn, đặt biến `CHROME=/đường/dẫn/chrome`.

## Đổi sang dự án khác: chỉ sửa `public/config.js`

| Muốn đổi | Sửa ở đâu |
|---|---|
| Ranh giới dự án | `project.polygon`: 4 góc `[kinh độ, vĩ độ]` |
| Hướng chia lô | `project.gridBearing`: góc của trục đường chính |
| Đường bay camera | `camera`: mỗi dòng là một mốc (`f` khung hình, `c` tâm, `z` zoom, `p` độ nghiêng, `b` góc xoay) |
| Chữ trên mặt đất | sự kiện `type: 'label'` (`style`: `sea`, `land`, `road`, `brand`) |
| Thẻ tiện ích | `type: 'poi'`. Khoảng cách tự tính từ tâm dự án. `beam` là chiều cao cột sáng, `dx` dời thẻ sang ngang |
| Đường bay máy bay | `type: 'route'` (`bend` là độ cong, `plane: true` để có máy bay) |
| Tên dự án, hotline | `type: 'end'` |
| Màu sắc | `palette` |

Nếu dự án ở khu vực khác, sửa khung tọa độ `W` và `N` trong `scripts/lay_du_lieu.sh` rồi chạy lại `npm run data`.

## Cách hoạt động

- `public/engine.js` dựng bản đồ bằng MapLibre GL. Với mỗi khung hình, nó đặt camera theo đường cong mượt qua các mốc, cập nhật hiệu ứng, chờ bản đồ vẽ xong rồi mới chụp. Nhờ vậy video không giật và không thiếu hình.
- Chữ "nằm trên mặt đất" được vẽ thành ảnh, rồi đặt theo 4 tọa độ góc. Chữ nghiêng theo phối cảnh khi camera bay.
- `render.mjs` mở trang bằng Chromium không giao diện, chụp từng khung hình và chuyển cho ffmpeg ghép thành MP4.
- `music.py` tự tổng hợp nhạc nền (pad, nhịp, whoosh khi chuyển cảnh), khớp với các mốc trong kịch bản.

Lưu ý: khối chia lô là **hình minh họa tự sinh**. Muốn dùng mặt bằng thật, thêm ảnh PNG quy hoạch làm nguồn `image` với 4 tọa độ góc (giống cách vẽ chữ trên mặt đất).
