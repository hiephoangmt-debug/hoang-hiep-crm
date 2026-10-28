# Nội thất từng căn (render như thật bằng Blender)

Script `dung-can-blender.py` dựng căn từ đúng dữ liệu layout của công cụ chọn căn (tường, cửa, kính, nội thất theo bản vẽ CĐT, đúng chiều căn thật trên tầng) và render bằng Cycles.

## Chạy
```bash
python3 -m venv bvenv && ./bvenv/bin/pip install bpy==4.2.0      # Blender 4.2 dạng thư viện Python (~0,5 GB)
# ccl.json = biến CCL lấy từ 4d/sun-saphia-4d.html (layout từng căn)
SUNROT=0 ./bvenv/bin/python dung-can-blender.py ccl.json u30 10 out living,living2,bed,plus,top 128 1080x1350
STYLE=lux EXPO=1.1 SUNROT=0 ./bvenv/bin/python dung-can-blender.py ccl.json u30 10 out living,living2,bed,plus,top 128 1080x1350   # luxury khách sạn 5–6 sao
SUNROT=0 VW=432 VH=768 ./bvenv/bin/python dung-can-blender.py ccl.json u30 10 out video 16      # video 9:16
```
- `u30` = tầng 30, `u` = tầng điển hình; `10` = mã căn (SP3010).
- Ảnh: `living` (cửa vào → ban công), `living2` (ban công nhìn vào), `bed`, `plus` (phòng +1), `top` (mặt bằng 3D nhìn từ trên).
- Thời gian: ~7 phút / ảnh 1080×1350 trên 4 nhân CPU.

Ảnh đã gắn chữ chìm 0904567009, ghi "minh họa, thông số theo CĐT": `../images/noi-that/`.
