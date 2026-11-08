# Video tiến độ xây dựng ngày – đêm (không chữ, không logo)

Dựng từ mô hình 3D `projects/sun-saphia/4d/sun-saphia-4d.html`: tòa tháp mọc từng tầng (móng → khối đế → thân chữ L 30 tầng),
cần cẩu, sàn đang đổ, trời chuyển sáng → chiều → đêm → bình minh; cuối video tòa nhà hoàn thiện, máy quay lượn chậm.

- `scene.js`: cảnh (cài vào trong hàm chính của trang mô hình), `XD.frame(t, opt)` vẽ khung ở giây t.
- `opt.json`: thời lượng, nhịp xây, chu kỳ ngày đêm, góc máy.
- `render.js`: dựng khung JPG bằng Chromium (swiftshader). Cần gói three@0.128 (`THREE_DIR`).

```
THREE_DIR=/duong/dan/three node render.js khung/ 0 1200 1080 1920
ffmpeg -framerate 30 -i khung/f%05d.jpg -c:v libx264 -pix_fmt yuv420p -crf 18 xay-dung-ngay-dem.mp4
```
