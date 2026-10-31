# Casamia Balanca Hội An – dựng 3D theo mặt bằng

- Nguồn: sơ đồ mặt bằng 363 lô (31,1 ha) và vị trí trên Google Maps do người dùng cung cấp.
- Khớp toạ độ: mặt bằng được chồng lên OpenStreetMap bằng phép biến đổi affine (`affine.json`, 3 điểm khống chế: lối vào chính trên đường Võ Chí Công, góc tây bắc, góc đông bắc) — sai lệch ước tính 20–40 m.
- `geo.py`: tách màu từng loại lô (SL, LK, BT…) trên ảnh mặt bằng → toạ độ thật, số tầng, kích thước lô → `web/casamia.json`.
- `overlay.py`, `check.py`: ảnh kiểm tra độ khớp mặt bằng với bản đồ.
