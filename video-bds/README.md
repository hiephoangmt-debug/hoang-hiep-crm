# Làm Video BĐS

Công cụ làm video bất động sản chạy trên trình duyệt: **kịch bản theo cảnh, quay từng đoạn, tự cắt ghép, chữ hiệu ứng, nhạc nền, xuất video đầy đủ, trailer và từng cảnh riêng**.
Ảnh, clip và giọng nói **không bị gửi lên máy chủ**; mọi xử lý chạy ngay trên máy.

## Cách cài và mở

### Cách 1: Dùng ngay trên máy tính (không cần mạng)
1. Tải thư mục `video-bds` về máy (hoặc file ZIP), giải nén.
2. Bấm đúp `index.html` để mở bằng **Google Chrome** hoặc **Microsoft Edge**.

Cách này dùng được mọi tính năng trừ nút “Cài ứng dụng”. Một số máy chặn camera và micro khi mở file trực tiếp; gặp trường hợp đó thì dùng Cách 2.

### Cách 2: Đưa lên web và cài như ứng dụng (khuyên dùng, dùng được cả trên điện thoại)
1. Đưa thư mục `video-bds` lên một địa chỉ **https**, chọn một trong hai:
   - **Netlify Drop** (dễ nhất, miễn phí): vào https://app.netlify.com/drop, kéo thả thư mục `video-bds` vào là có link.
   - **GitHub Pages**: Settings → Pages → chọn nhánh, thư mục gốc; link có dạng `https://<tên>.github.io/<repo>/video-bds/`.
2. Mở link và cài:
   - **Máy tính (Chrome/Edge):** bấm nút **⬇️ Cài ứng dụng** trên cùng, hoặc biểu tượng cài đặt ở cuối thanh địa chỉ.
   - **Android (Chrome):** menu ⋮ → **Cài đặt ứng dụng** (hoặc “Thêm vào màn hình chính”).
   - **iPhone/iPad (Safari):** nút Chia sẻ → **Thêm vào MH chính**.

Sau khi cài, ứng dụng có biểu tượng riêng và mở được cả khi mất mạng.

## 6 bước làm video

| Bước | Việc cần làm |
|---|---|
| 1. Thông tin | Tên dự án, vị trí, giá, tên và số điện thoại. Mở “Thông tin dự án” để điền chủ đầu tư, quy mô, kết nối, tiện ích, chính sách, sự kiện |
| 2. Kịch bản | Ba cách bắt đầu: **Giới thiệu dự án** (tự viết 5–7 cảnh), **Nhập từ Google Sheets** (dán link hoặc copy bảng), **Nhanh từ ảnh**. Mỗi cảnh có lời thoại, chữ lớn trên màn hình, gợi ý cảnh quay |
| 3. Quay và ghép | Mỗi cảnh thêm clip/ảnh hoặc **🎥 Quay cảnh này** bằng camera có chữ nhắc lời. Tự cắt khoảng lặng đầu/cuối, tự cân âm lượng giọng, tự ghép theo thứ tự |
| 4. Giọng đọc | Dùng tiếng nói trong clip (mặc định), thu giọng lồng tiếng theo máy nhắc chữ, hoặc không giọng |
| 5. Hiệu ứng và nhạc | Khung 9:16 / 16:9 / 1:1, màu, hiệu ứng chữ (bật lên, trượt vào, gõ chữ), chuyển cảnh, nhạc nền tự soạn hoặc nhạc riêng |
| 6. Xuất video | **Video đầy đủ**, **Trailer** (cắt nhanh, chữ to, nhạc sôi động), **Từng cảnh riêng** (để đăng Reels/TikTok hằng ngày) |

### 🚀 Làm video tự động (Bước 1, khuyên dùng)
Khung đầu tiên có 3 phần:
1. **🎬 Video quay (người nói)**: các clip sau buổi quay, chưa cần cắt. Kéo thả file, thư mục, file .zip, hoặc dán link thư mục Google Drive.
2. **🏙 Tư liệu dự án**: ảnh phối cảnh, flycam, video dự án, logo, nhạc nền. Kéo thả hoặc dán link thư mục Google Drive dự án.
3. **📝 Kịch bản quay**: dán link Google Sheets/Docs, dán nội dung kịch bản (copy từ Sheets, Word, Zalo), hoặc chọn file Excel/Word/TXT.

Bấm **🚀 Làm video tự động**: phần mềm cắt ghép video quay theo kịch bản, lắp tư liệu dự án vào đoạn chưa quay,
thêm chữ động, hiệu ứng, nhạc, rồi xuất luôn **video đầy đủ + trailer**.

**Tư liệu trên Google Drive?** Chuột phải vào thư mục trên Drive → **Tải xuống** (Google nén thành .zip) rồi kéo thả file .zip vào, không cần giải nén.
Hoặc dán thẳng link thư mục Drive (cần khoá API Google, hướng dẫn trong mục 🔑). Link phải bật chia sẻ “Bất kỳ ai có đường liên kết → Người xem”.

### Phong cách chữ động (giống video mẫu)
Mỗi câu nói hiện thành một “tầng chữ”: chữ dẫn nhỏ hiện dần theo lời nói, **từ khoá rất to tô màu chuyển sắc** (có lúc tô bằng ảnh phối cảnh) đập vào kèm tiếng “bụp”,
chữ nhấn in nghiêng màu đỏ. Tầng chữ đặt xen kẽ trên đầu và ngang thân người nói. Kết thúc bằng nút **LIÊN HỆ NGAY** nhỏ.

### Làm đẹp và nhịp nói
- **Làm đẹp**: sáng da, mịn da (giữ nét mắt, tóc, viền áo), làm nét, cân màu. Chọn mức Nhẹ / Vừa / Mạnh ở Bước 5.
  Phần mềm không chỉnh được dáng mặt, nếp quần áo hay kiểu tóc (việc này cần AI tạo ảnh trên máy chủ).
- **Nhịp nói**: tự đo tốc độ nói; nói chậm thì tăng tốc (tối đa 1,3 lần, giữ nguyên giọng), nói quá nhanh thì hãm nhẹ.

### 🤖 Tự dựng toàn bộ theo kịch bản (Bước 3)
Chỉ cần có kịch bản (Bước 2) và bỏ **tất cả video đã quay + ảnh phối cảnh/flycam** vào khung “Tự dựng toàn bộ”:
1. Quét giọng nói từng clip, **cắt bỏ chỗ ngập ngừng** (chọn mức cắt kỹ / vừa / nhẹ), tự cân âm lượng giọng.
2. **Nghe lời nói** (nhận dạng tiếng Việt ngay trên máy, lần đầu tải mô hình khoảng 250MB) để xếp từng đoạn vào **đúng cảnh** trong kịch bản,
   bỏ đoạn nói hỏng, giữ bản quay lại. Nếu máy không chạy được phần nghe, clip được xếp theo thứ tự tên file.
3. Ảnh/flycam tự vào cảnh theo tên file (VD: `ho-boi.jpg` vào cảnh tiện ích, `ban-do.png` vào cảnh vị trí); còn lại ưu tiên **cảnh chưa quay được**.
4. Cảnh không có người nói thì dùng phối cảnh + phụ đề theo kịch bản; cảnh có người nói thì phối cảnh xen vào giữa lời nói.

Đoạn nào xếp sai, dùng ô **“Chuyển sang cảnh…”** dưới mỗi đoạn để sửa.

### 🎬 Tự dựng từ 1 video (Bước 2)
Không có kịch bản, chỉ có một video dài: phần mềm cắt chỗ ngừng, chia cảnh, tạo phụ đề từ lời thoại dán vào (hoặc tự nghe và chép lời).

### Kiểu TikTok
- **Cắt nhảy + zoom đẩy** xen kẽ ở mỗi chỗ cắt.
- **Phụ đề từng chữ**: chữ to viền đen, chữ đang nói đổi màu, con số luôn nổi bật.
- **Chữ lớn bút dạ quang**: vệt màu chạy qua sau chữ.
- **Âm thanh**: “vút” ở chỗ cắt, “ting ting” khi nhắc tới giá, “quẹt” khi chữ hiện, nhạc vút lên trước khung liên hệ.

### Clip nói + phối cảnh/flycam
Trong một cảnh, clip có **🔊 tiếng gốc** là **clip nói**; ảnh phối cảnh và clip flycam (tắt tiếng) là **hình phủ**.
Phần mềm giữ **tiếng nói chạy liên tục**, mở đầu bằng người nói, xen phối cảnh/flycam ở giữa, kết thúc bằng người nói.
Bấm **🙈 Chỉ lấy tiếng** trên clip nói để ẩn hẳn hình người nói, phối cảnh/flycam sẽ phủ kín cả cảnh.

### Nhập kịch bản từ Google Sheets
Bảng gồm các cột: **Tên cảnh | Lời thoại | Hình ảnh / chữ trên màn hình**.
Ô ở cột thứ ba bắt đầu bằng “Text …” (ví dụ “Text chạy màn hình:”) sẽ thành **chữ lớn hiệu ứng**, mỗi dòng một ý; còn lại là **gợi ý cảnh quay**.
Dán link cần bảng ở chế độ “Bất kỳ ai có đường liên kết đều xem được”; hoặc bôi đen bảng, Ctrl+C rồi dán vào ô nhập.

## Cấu trúc mã

```
video-bds/
├── index.html            Giao diện 6 bước, máy nhắc chữ, camera, hướng dẫn
├── manifest.webmanifest  Thông tin cài ứng dụng (PWA)
├── sw.js                 Lưu sẵn ứng dụng để dùng khi mất mạng
├── icons/                Biểu tượng ứng dụng
├── css/styles.css        Giao diện (điện thoại, chế độ tối)
└── js/
    ├── app.js            Điều khiển các bước, quay, thu âm, xem thử, xuất video
    ├── script-gen.js     Viết kịch bản tự động, đọc bảng Google Sheets
    ├── timeline.js       Dựng dòng thời gian: video đầy đủ, trailer, từng cảnh, phủ phối cảnh, cắt nhảy, phụ đề từng chữ
    ├── autocut.js        Quét giọng nói, cắt chỗ ngừng, đo nhịp nói, nhận dạng lời nói, xếp clip vào đúng cảnh
    ├── importer.js       Đọc thư mục: kịch bản Excel/Word/CSV/TXT/link, video, ảnh, nhạc
    ├── beauty.js         Làm đẹp video (WebGL): sáng da, mịn da, làm nét
    ├── renderer.js       Vẽ khung hình: chuyển cảnh, chữ hiệu ứng, phụ đề, intro/outro
    ├── audio.js          Nhạc nền, hiệu ứng âm thanh, trộn tiếng clip, giảm nhạc khi có giọng
    ├── webm-fix.js       Ghi thời lượng vào file WebM để tua được
    └── demo.js           Dữ liệu mẫu (F2 FourS Tower 7 cảnh, căn hộ từ ảnh)
```

Dựng hình, trộn âm và ghi video dùng Canvas, Web Audio và MediaRecorder của trình duyệt; không cần thư viện ngoài.
