# Tour cuộn: website "đi xuyên căn nhà" khi cuộn trang

Khi khách cuộn trang, camera trượt qua phòng khách, phòng ngủ rồi phòng tắm, giống các website 3D cao cấp.
Cách làm: **render sẵn một đoạn video bay camera, cắt thành ảnh, rồi cho trang web tua ảnh theo cuộn**.
Cách này đẹp như ảnh render và chạy mượt trên mọi điện thoại.

Thư mục này đã có sẵn trang mẫu `index.html` và 120 ảnh giả trong `frames/` để anh xem thử.

---

## Bước 1: Làm video bay camera qua căn hộ

Dùng phần mềm anh hoặc đơn vị thiết kế đang dùng:

| Phần mềm | Cách làm |
|---|---|
| **D5 Render** (dễ nhất) | Chế độ Video, thêm các điểm camera (keyframe) đi từ phòng khách qua phòng ngủ rồi phòng tắm, rồi xuất MP4 |
| **Lumion / Enscape / Twinmotion** | Tương tự: tạo đường camera rồi xuất video |
| **Blender** | Tạo đường cong (Curve), cho camera "Follow Path", sau đó render Animation |
| **Chưa có mô hình** | Quay video thật bằng gimbal trong nhà mẫu, đi chậm và đều |

**Thông số nên dùng:**
- Độ dài 8–15 giây, camera đi **chậm và đều**, không giật, không xoay gắt.
- Khung hình 16:9, độ phân giải 1920×1080 (trang tự cắt vừa màn hình điện thoại).
  Nếu phần lớn khách xem trên điện thoại, nên đặt vật quan trọng ở **giữa khung hình**.
- 24 hoặc 30 hình/giây.
- Ghi lại thời điểm (giây) camera vào từng phòng, ví dụ: phòng khách 0–5 s, phòng ngủ 5–10 s, phòng tắm 10–15 s.

## Bước 2: Cắt video thành ảnh

**Cách A: dùng ffmpeg** (miễn phí, tải tại ffmpeg.org)

```bash
ffmpeg -i tour.mp4 -vf "fps=12,scale=1600:-1" -c:v libwebp -quality 70 -start_number 1 frames/f_%04d.webp
```

- `fps=12` nghĩa là lấy 12 ảnh mỗi giây. Video 12 giây sẽ cho khoảng 144 ảnh, đủ mượt.
  Muốn mượt hơn thì tăng lên 20–24, đổi lại trang tải lâu hơn.
- `scale=1600` là chiều ngang của ảnh. Ảnh rộng 1600 px nét trên điện thoại và nhẹ.
- Tổng dung lượng thư mục `frames/` nên **dưới khoảng 15 MB**.

**Cách B: không cài gì.** Lên ezgif.com, dùng "Video to JPG/PNG", chọn tách khoảng 12 ảnh/giây rồi tải về.
Sau đó đổi tên ảnh thành `f_0001.jpg`, `f_0002.jpg`... và sửa `ext: '.jpg'` ở Bước 3.

Xoá 120 ảnh mẫu cũ trong `frames/`, rồi chép ảnh của anh vào.

## Bước 3: Sửa phần CONFIG trong `index.html`

Mở `index.html` bằng Notepad hoặc VS Code. Chỉ sửa đoạn nằm giữa hai dòng `CHỈ CẦN SỬA PHẦN NÀY`:

```js
count: 144,                // tổng số ảnh trong frames/
rooms: [
  { name:'Phòng khách', text:'Diện tích <b>32 m²</b>...', from:1,  to:60  },
  { name:'Phòng ngủ',   text:'...',                     from:61, to:110 },
  { name:'Phòng tắm',   text:'...',                     from:111,to:144 },
],
```

Cách tính `from` / `to`: **số ảnh = số giây × fps**.
Ví dụ với fps=12, camera vào phòng ngủ ở giây thứ 5, thì phòng ngủ bắt đầu ở ảnh 5 × 12 = 60.

Cũng trong `index.html`, tìm `0900000000` và đổi thành số Zalo hoặc số điện thoại của anh.

## Bước 4: Xem thử trên máy

Trang tải ảnh nên **không mở trực tiếp bằng cách bấm đúp file được**. Cần chạy một máy chủ nhỏ:

```bash
cd tour-cuon
python -m http.server 8000
```

Sau đó mở http://localhost:8000. Hoặc dùng VS Code, cài tiện ích "Live Server" rồi bấm "Go Live".

## Bước 5: Đưa lên mạng

- **Netlify Drop** (nhanh nhất): vào app.netlify.com/drop rồi kéo thả cả thư mục `tour-cuon`. Anh sẽ có link ngay.
- **Trong repo này**: trang nằm ở `floorplan-3d/public/tour-cuon/`. Khi chạy `npm run build`, nó tự có trong `dist/tour-cuon/`.
- **LadiPage**: đưa trang lên Netlify trước, rồi trong LadiPage thêm phần tử HTML/iframe trỏ tới link đó.

---

## Mẹo cho đẹp như video mẫu

1. **Ánh sáng ấm, đèn hắt tường, trần có đèn rọi.** Phần này quyết định khoảng 80% cảm giác sang trọng.
2. Camera đặt **ngang tầm mắt (khoảng 1,5 m)**, ống kính 24–28 mm, di chuyển chậm.
3. Khi đi qua cửa giữa hai phòng, cho camera **rẽ nhẹ** thay vì dừng hẳn. Cảm giác sẽ liền mạch hơn.
4. Mỗi phòng chỉ viết **một dòng chữ ngắn** (diện tích, điểm nổi bật). Đừng nhồi nhiều chữ.
5. Kết thúc tour bằng **view đẹp nhất** (ban công, view biển), ngay trước nút liên hệ.

## Lỗi thường gặp

| Hiện tượng | Cách sửa |
|---|---|
| Màn hình đen | Kiểm tra tên ảnh có đúng `f_0001.webp` không, và đang mở qua `http://` chứ không phải `file://` |
| Cuộn bị giật | Giảm số ảnh (fps nhỏ hơn) hoặc giảm `scale` xuống 1280 |
| Cuộn nhanh quá hoặc chậm quá | Sửa `screensPerRoom` (mặc định 1,6; tăng lên thì cuộn chậm hơn) |
| Chữ hiện sai phòng | Tính lại `from` / `to` theo công thức giây × fps |
