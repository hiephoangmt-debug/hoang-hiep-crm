"""Ảnh thẻ tin tự vẽ (3:2, khớp ảnh thẻ 720 × 480 của web) cho 8 tin bán khách sạn / tòa căn hộ dịch vụ Đà Nẵng (06/11/2026) – không dùng ảnh tin rao của bên khác."""
import sys, os
from PIL import Image, ImageDraw, ImageFont
OUT = sys.argv[1]
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'
FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
GOLD, CREAM, NAVY, SEA = '#d8b16a', '#f7f1e3', '#0f2240', '#1f6f8b'
CARDS = [
    # file, khu vực, đường, dòng chính, 3 ý, giá, ghi chú, số tầng (vẽ), hồ bơi
    ('khach-san-loseby-son-tra-20-phong', 'KHÁCH SẠN · SƠN TRÀ · ĐÀ NẴNG', 'Đường Loseby', '20 phòng · 115 m²', ['~100 m ra biển Phạm Văn Đồng', 'PCCC đầy đủ, vận hành ngay', 'Sổ hồng'], '25 tỷ', 'Thương lượng · ngang 5 m · đường 7,5 m', 7, False),
    ('khach-san-le-van-quy-son-tra-7-tang', 'KHÁCH SẠN 3* · SƠN TRÀ · ĐÀ NẴNG', 'Đường Lê Văn Quý', '7 tầng · 18 phòng', ['Đang vận hành, có thang máy', 'Cách biển khoảng 700 m', 'Sổ vuông vức'], '18,5 tỷ', 'Thương lượng · 100 m² · đường 7,5 m', 7, False),
    ('khach-san-ha-bong-17-tang-102-phong', 'KHÁCH SẠN 4* · BIỂN MỸ KHÊ', 'Đường Hà Bổng', '17 tầng · 102 phòng', ['Đất 510 m², ngang 23 m', 'Hồ bơi, gym, phòng hội nghị', 'Sàn sử dụng ~7.000 m²'], '230 tỷ', 'Thương lượng · đường 8 m, lề 5 m', 17, True),
    ('khach-san-boutique-do-the-chap-9-tang', 'KHÁCH SẠN BOUTIQUE · SƠN TRÀ', 'Đường Đỗ Thế Chấp', '9 tầng · 18 phòng', ['Hồ bơi vô cực sân thượng', '13 studio có bếp + 5 phòng', 'Đã hoàn công, hướng Đông'], '29 tỷ', 'Thương lượng mạnh · 123,5 m² (5 × 25 m)', 9, True),
    ('khach-san-an-thuong-12-tang-56-phong', 'KHÁCH SẠN 3* · AN THƯỢNG · MỸ KHÊ', 'Khu phố Tây An Thượng', '12 tầng · 56 phòng', ['Cách biển Mỹ Khê ~100 m', 'Hồ bơi tầng thượng, nhà hàng', 'Đất 243 m², sàn 2.670 m²'], '64 tỷ', '1 hầm + 11 tầng nổi · mới xây', 12, True),
    ('toa-can-ho-khach-san-khue-my-dong-27-can', 'TÒA CĂN HỘ – KHÁCH SẠN · NGŨ HÀNH SƠN', 'Khu Khuê Mỹ Đông', '27 căn hộ · 8 tầng', ['Đi biển khoảng 500 m', 'Hồ bơi sân thượng view biển', 'Đất 180 m², sàn 1.650 m²'], '34 tỷ', 'Đang full phòng · gần Hồ Xuân Hương', 8, True),
    ('toa-can-ho-boutique-le-thuoc-8-tang', 'TÒA CĂN HỘ BOUTIQUE · SƠN TRÀ', 'Đường Lê Thước', '8 tầng · 14 căn hộ', ['Cách biển Phạm Văn Đồng ~500 m', 'Hồ bơi, phòng gym', 'Đất 200 m², ngang 17 m'], '38 tỷ', 'Thương lượng · sàn 1.118 m²', 8, True),
    ('toa-can-ho-dich-vu-gan-ho-nghinh-11-phong', 'TÒA CĂN HỘ DỊCH VỤ · SƠN TRÀ', 'Gần biển Phạm Văn Đồng', '7 tầng · 11 phòng', ['Sát công viên Hồ Nghinh', 'Mới 100%, full nội thất', 'Đất 90 m²'], '2x tỷ', 'Giá thỏa thuận · khu du lịch Mỹ Khê', 7, False),
]
for name, area, street, head, rows, gia, note, floors, pool in CARDS:
    W, H = 1500, 1000
    im = Image.new('RGB', (W, H), NAVY)
    dr = ImageDraw.Draw(im)
    # Tòa nhà minh họa bên phải: số tầng theo tin, chân là biển.
    bx, bw, base = 1080, 300, 830
    fh = min(44, int(640 / floors))
    top = base - floors * fh
    dr.rectangle([940, base, 1460, base + 30], fill=SEA)
    for k in range(6):
        dr.arc([950 + k * 84, base - 6, 1016 + k * 84, base + 14], 0, 180, fill='#7cc3d6', width=3)
    dr.rectangle([bx, top, bx + bw, base], fill='#1b3560')
    dr.rectangle([bx - 10, top - 14, bx + bw + 10, top], fill=GOLD)
    for r in range(floors):
        for c in range(4):
            y0 = top + 8 + r * fh
            dr.rectangle([bx + 20 + c * 70, y0, bx + 70 + c * 70, y0 + fh - 14], fill=GOLD if (r * 4 + c) % 5 == 2 else '#2b4a7c')
    if pool:
        dr.rounded_rectangle([bx + 30, top - 34, bx + bw - 30, top - 18], radius=6, fill='#4fb3d1')
    # Chữ: chừa góc trái trên cho nhãn "Bán" của thẻ tin.
    dr.text((260, 58), area, font=f(30, True), fill=GOLD)
    dr.text((80, 140), street, font=f(72 if len(street) < 20 else 60, True), fill=CREAM)
    dr.text((80, 250), head, font=f(50, True), fill=CREAM)
    y = 345
    for t in rows:
        dr.ellipse([84, y + 13, 104, y + 33], fill=GOLD)
        dr.text((124, y), t, font=f(40), fill=CREAM)
        y += 66
    dr.rounded_rectangle([80, 585, 600, 705], radius=24, fill=GOLD)
    dr.text((112, 603), gia, font=f(70, True), fill=NAVY)
    dr.text((80, 735), note, font=f(34), fill=CREAM)
    dr.rectangle([60, 870, W - 60, 879], fill=GOLD)
    dr.text((80, 902), 'Hoàng Hiệp · Zalo 0904 567 009 · hiephoangmt.com', font=f(38, True), fill=GOLD)
    im.save(os.path.join(OUT, name + '.jpg'), quality=86, optimize=True, progressive=True)
print('ok', len(CARDS))
