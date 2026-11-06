"""Ảnh thẻ tin tự vẽ (3:2, khớp ảnh thẻ 720 × 480 của web) cho 12 tin bán biệt thự biển Đà Nẵng (06/11/2026) – không dùng ảnh tin rao của bên khác."""
import sys, os
from PIL import Image, ImageDraw, ImageFont
OUT = sys.argv[1]
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'
FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
GOLD, CREAM, NAVY, GREEN = '#d8b16a', '#f7f1e3', '#0f2240', '#2f6b4f'
CARDS = [
    # file, nhãn, đường, dòng chính, 3 ý, giá, ghi chú, số tầng (vẽ), hồ bơi
    ('biet-thu-bien-tran-bach-dang-an-thuong-300m2', 'BIỆT THỰ BIỂN · AN THƯỢNG · MỸ KHÊ', 'Mặt tiền Trần Bạch Đằng', '300 m² · 5 tầng · 11 PN', ['Sát biển Mỹ Khê', 'Mặt tiền ngang 15 m', 'Phố Tây An Thượng'], '125 tỷ', 'Thương lượng · Ngũ Hành Sơn', 5, False),
    ('villa-bien-nguyen-van-thoai-240m2', 'VILLA BIỂN · AN HẢI · SƠN TRÀ', 'Đường Nguyễn Văn Thoại', '240 m² · 3 tầng · 8 PN', ['~150 m ra biển Mỹ Khê', 'Ở + căn hộ cho thuê', 'Trục du lịch ra biển'], '64,5 tỷ', 'Thương lượng · Sơn Trà', 3, False),
    ('biet-thu-le-manh-trinh-234m2-5-tang', 'BIỆT THỰ BIỂN · AN HẢI · SƠN TRÀ', 'Đường Lê Mạnh Trinh', '234 m² · 5 tầng · thang máy', ['Cách biển khoảng 200 m', '5 – 7 phòng ngủ', 'Hướng Đông, ngang ~12 m'], '59 tỷ', 'Thương lượng · thiết kế tối giản', 5, False),
    ('biet-thu-pham-quang-anh-gan-bien-357m2', 'BIỆT THỰ BIỂN · AN HẢI · SƠN TRÀ', 'Đường Phạm Quang Ảnh', '~360 m² · 3 tầng', ['Gần biển Mỹ Khê', 'Mặt tiền, hướng Đông', 'Khu phố du lịch'], '45 tỷ', 'Thương lượng · Sơn Trà', 3, False),
    ('biet-thu-premier-village-vo-nguyen-giap-300m2', 'BIỆT THỰ BIỂN · MỸ AN · NGŨ HÀNH SƠN', 'Premier Village', '300 m² · 3 tầng · 5 PN', ['Mặt tiền Võ Nguyên Giáp', 'Sát biển Mỹ Khê', 'Hướng Đông, 15 × 20 m'], '42 tỷ', 'Thương lượng · cạnh phố Tây An Thượng', 3, False),
    ('villa-goc-che-lan-vien-110m2', 'VILLA BIỂN · MỸ AN · NGŨ HÀNH SƠN', 'Đường Chế Lan Viên', '~110 m² · 4 tầng · 4 PN', ['1 phút ra biển', 'Lô góc, mới 100%', 'Hồ bơi lớn, hướng Nam'], '20 tỷ', 'Thương lượng · sân thượng', 4, True),
    ('villa-phuoc-truong-5-sat-bien-80m2', 'VILLA BIỂN · PHƯỚC MỸ · SƠN TRÀ', 'Đường Phước Trường 5', '80 m² · 4 tầng · 4 PN', ['Sát biển Phạm Văn Đồng', 'Khu phố du lịch', 'Hướng Đông Bắc, 5 × 16 m'], '18,2 tỷ', 'Thương lượng · Sơn Trà', 4, False),
    ('villa-bien-son-thuy-dong-90m2', 'VILLA BIỂN · NGŨ HÀNH SƠN', 'Đường Sơn Thủy Đông 1', '90 m² · 5 tầng · 5 PN', ['Cách biển khoảng 200 m', 'Xây mới 100%', 'Khu bãi tắm Sơn Thủy'], '16 tỷ', 'Thương lượng · ngang 5,5 m', 5, False),
    ('villa-bien-da-man-dong-135m2', 'VILLA BIỂN · KHUÊ MỸ · NGŨ HÀNH SƠN', 'Đường Đa Mặn Đông 4', '135 m² · 3 tầng · 7 PN', ['3 – 5 phút ra biển Mỹ Khê', 'Có hồ bơi', 'Ở hoặc cho thuê lưu trú'], '11,8 tỷ', 'Thương lượng · Khuê Mỹ', 3, True),
    ('villa-vo-duy-ninh-man-thai-4-tang', 'VILLA BIỂN · MÂN THÁI · SƠN TRÀ', 'Đường Võ Duy Ninh', '~63 m² · 4 tầng · 4 PN', ['Hồ bơi riêng, xông hơi', 'Cách biển ~200 m', 'Hướng Đông Nam'], '8,95 tỷ', 'Thương lượng · chủ cần bán', 4, True),
    ('villa-tran-van-thanh-khue-my-4-tang', 'VILLA BIỂN · KHUÊ MỸ · NGŨ HÀNH SƠN', 'Đường Trần Văn Thành', '50 m² · 4 tầng · 4 PN', ['~400 m ra biển Mỹ Khê', 'Có hồ bơi', 'Ngang 5,5 m'], '8,6 tỷ', 'Thương lượng · cho thuê lưu trú', 4, True),
    ('villa-mini-tra-lo-hoa-hai-100m2', 'VILLA MINI · HÒA HẢI · GẦN BIỂN', 'Đường Trà Lộ', '100 m² · 3 tầng · 3 PN', ['Hồ bơi, full nội thất', 'Cách biển ~400 m', 'Hướng Nam, 5 × 20 m'], '7,5 tỷ', 'Thương lượng · mới 100%', 3, True),
]
for name, area, street, head, rows, gia, note, floors, pool in CARDS:
    W, H = 1500, 1000
    im = Image.new('RGB', (W, H), NAVY)
    dr = ImageDraw.Draw(im)
    # Biệt thự minh họa bên phải: biển phía sau, bãi cát, cây, hồ bơi nếu có.
    bx, bw, base = 960, 440, 820
    fh = 100 if floors <= 3 else (84 if floors == 4 else 70)
    top = base - floors * fh
    dr.rectangle([900, base - 230, 1460, base], fill='#1f6f8b')
    for k in range(6):
        dr.arc([910 + k * 92, base - 222, 980 + k * 92, base - 202], 0, 180, fill='#7cc3d6', width=3)
    dr.rectangle([900, base, 1460, base + 40], fill='#e6d3a3')
    for r in range(floors):
        y0 = top + r * fh
        x0 = bx + (36 if r == 0 and floors > 2 else 0)
        dr.rectangle([x0, y0, bx + bw, y0 + fh], fill='#1b3560', outline=NAVY, width=3)
        for c in range(3):
            wx = x0 + 28 + c * ((bw - (x0 - bx) - 56) // 3)
            dr.rectangle([wx, y0 + 18, wx + 92, y0 + fh - 16], fill=GOLD if (r + c) % 3 == 1 else '#2b4a7c')
        dr.rectangle([x0 - 10, y0 + fh - 7, bx + bw + 10, y0 + fh], fill=CREAM)
    dr.rectangle([bx - 18, top - 14, bx + bw + 18, top], fill=GOLD)
    for tx in (925, 1440):
        dr.rectangle([tx - 6, base - 80, tx + 6, base], fill='#5a3d22')
        dr.ellipse([tx - 40, base - 170, tx + 40, base - 70], fill='#3f8a62')
    if pool:
        dr.rounded_rectangle([1000, base + 8, 1360, base + 32], radius=10, fill='#4fb3d1')
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
