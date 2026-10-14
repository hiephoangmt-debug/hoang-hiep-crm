# Làm Video BĐS

Công cụ làm video bất động sản chạy ngay trên trình duyệt: **không cần cài đặt, không cần tài khoản, ảnh và giọng đọc không bị gửi lên máy chủ**.

## Cách mở

1. Tải thư mục `video-bds` về máy.
2. Mở file `index.html` bằng **Google Chrome** hoặc **Microsoft Edge** (bấm đúp chuột).
3. Lần đầu mở sẽ có hướng dẫn; bấm **“✨ Làm thử với dữ liệu mẫu”** để xem ngay một video mẫu.

> Muốn thu giọng bằng micro trên điện thoại hoặc cho nhân viên dùng chung, hãy đưa thư mục lên web có `https`
> (GitHub Pages, Netlify, hoặc hosting của công ty). Không cần máy chủ riêng.

## 6 bước làm video

| Bước | Việc cần làm |
|---|---|
| 1. Thông tin | Loại BĐS, vị trí, giá, diện tích, số phòng, pháp lý, điểm nổi bật, tên và số điện thoại môi giới, logo |
| 2. Ảnh và clip | Chọn hoặc kéo thả ảnh/clip, ghi tên phòng, đổi thứ tự; ảnh đầu tiên là ảnh bìa |
| 3. Kịch bản | **Tự viết kịch bản** theo 4 phong cách: Chuyên nghiệp, Gần gũi, TikTok, Sang trọng. Sửa từng câu, đổi kiểu câu, nghe máy đọc thử |
| 4. Giọng đọc | **Máy nhắc chữ**: chữ to hiện trên màn hình, đọc xong câu nào thì bấm “Câu tiếp” (hoặc phím cách); video tự khớp cảnh theo giọng. Hoặc tải file giọng đọc có sẵn |
| 5. Nhạc và hiệu ứng | Khung 9:16 / 16:9 / 1:1, màu chủ đạo, kiểu chuyển cảnh, nhạc nền tự soạn (không lo bản quyền) hoặc nhạc riêng |
| 6. Xuất video | Bấm “Xuất video” → tải file MP4 (Chrome/Edge mới) hoặc WebM về máy |

## Hiệu ứng có sẵn

- **Hình:** zoom và lia chậm trên ảnh (Ken Burns), chuyển cảnh mờ, trượt, phóng to có loé sáng; intro hiện loại BĐS, tên dự án, vị trí, khung giá bật lên, thông số; nhãn tên phòng trượt vào; khung giá góc màn hình; phụ đề tự chia dòng; outro hiện số điện thoại lớn và “Gọi điện hoặc nhắn Zalo”; thanh tiến trình; logo hoặc thương hiệu.
- **Âm thanh:** tiếng “boom” mở đầu, “whoosh” khi chuyển cảnh, “ting” khi hiện giá và số điện thoại, “pop” khi hiện tên phòng; 3 loại nhạc nền tự soạn (nhẹ nhàng, sôi động, sang trọng); **nhạc tự nhỏ lại khi có giọng đọc**, mở và tắt nhạc từ từ; bộ nén âm giúp âm lượng đều.

## Cấu trúc mã

```
video-bds/
├── index.html         Giao diện 6 bước, máy nhắc chữ, hướng dẫn
├── css/styles.css     Giao diện (hỗ trợ điện thoại và chế độ tối)
└── js/
    ├── app.js         Điều khiển các bước, thu âm, xem thử, xuất video
    ├── script-gen.js  Tự viết kịch bản tiếng Việt
    ├── renderer.js    Vẽ khung hình: hiệu ứng, chữ, intro/outro
    ├── audio.js       Nhạc nền, hiệu ứng âm thanh, giảm nhạc khi có giọng
    ├── webm-fix.js    Ghi thời lượng vào file WebM để tua được
    └── demo.js        Dữ liệu và ảnh mẫu
```

Mọi xử lý (dựng hình, trộn âm, ghi video) chạy trong trình duyệt bằng Canvas, Web Audio và MediaRecorder; không cần thư viện ngoài.
