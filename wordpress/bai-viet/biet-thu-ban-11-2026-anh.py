"""Ảnh thẻ tin tự vẽ (4:3) cho 11 tin bán biệt thự Đà Nẵng (06/11/2026) – không dùng ảnh tin rao của bên khác."""
import sys, os
from PIL import Image, ImageDraw, ImageFont
OUT = sys.argv[1]
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'
FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
GOLD, CREAM, NAVY, GREEN = '#d8b16a', '#f7f1e3', '#0f2240', '#2f6b4f'
CARDS = [
    # file, nhãn, đường, dòng chính, 3 ý, giá, ghi chú, số tầng (vẽ), hồ bơi
    ('biet-thu-premier-village-vo-nguyen-giap-300m2', 'BIỆT THỰ · MỸ AN · NGŨ HÀNH SƠN', 'Premier Village', '300 m² · 3 tầng · 5 PN', ['Mặt tiền Võ Nguyên Giáp', 'Sát biển Mỹ Khê', 'Hướng Đông, 15 × 20 m'], '42 tỷ', 'Thương lượng · cạnh phố Tây An Thượng', 3, False),
    ('biet-thu-le-manh-trinh-234m2-5-tang', 'BIỆT THỰ · AN HẢI · SƠN TRÀ', 'Đường Lê Mạnh Trinh', '234 m² · 5 tầng · thang máy', ['Cách biển khoảng 200 m', '5 – 7 phòng ngủ', 'Hướng Đông, ngang ~12 m'], '59 tỷ', 'Thương lượng · thiết kế tối giản', 5, False),
    ('biet-thu-le-kim-lang-400m2', 'BIỆT THỰ · CẨM LỆ · ĐÀ NẴNG', 'Đường Lê Kim Lăng', '400 m² · 3 tầng · 6 PN', ['Mặt tiền ngang 20 m', 'Đường 7,5 m, sân ô tô', 'Hoàn thiện cao cấp'], '32 tỷ', 'Thương lượng · đất 20 × 20 m', 3, False),
    ('biet-thu-nam-viet-a-le-huu-khanh-200m2', 'BIỆT THỰ · KĐT NAM VIỆT Á', 'Đường Lê Hữu Khánh', '200 m² · 3 tầng · 7 PN', ['Hồ bơi riêng', 'Đường 7,5 m, hướng Bắc', 'Ở hoặc cho thuê lưu trú'], '33 tỷ', 'Thương lượng · 10 × 20 m', 3, True),
    ('villa-doan-khue-nam-viet-a-272m2', 'VILLA · KĐT NAM VIỆT Á', 'Đường Đoàn Khuê', '272 m² · 4 tầng · 7 PN', ['Mới 100%, sàn ~680 m²', '2 hồ bơi, gym, xông hơi', 'Hướng Đông, 10 × 27 m'], '35,5 tỷ', 'Thương lượng · Khuê Mỹ, Ngũ Hành Sơn', 4, True),
    ('biet-thu-goc-hoa-xuan-anh-duc-182m2', 'BIỆT THỰ GÓC · KĐT HÒA XUÂN', 'Đường Anh Đức', '182 m² · 3 tầng · 4 PN', ['Lô góc 2 mặt tiền', 'Đường 7,5 m', 'Đang có khách thuê'], '17 tỷ', 'Thương lượng · Cẩm Lệ', 3, False),
    ('biet-thu-goc-tran-van-giap-154m2', 'BIỆT THỰ GÓC · HẢI CHÂU', 'Đường Trần Văn Giáp', '154 m² · 4 tầng · 4 PN', ['Lô góc 2 mặt tiền', 'Có thang máy', 'Trung tâm Hải Châu'], '22,5 tỷ', 'Thương lượng · ngang 14 m', 4, False),
    ('villa-pham-nhu-tang-225m2', 'VILLA · THANH KHÊ · ĐÀ NẴNG', 'Đường Phạm Nhữ Tăng', '225 m² · 3 tầng · 3 PN', ['Mới xây, có nội thất', 'Ngang 10 m, đường 7,5 m', 'Hướng Tây Nam'], '22 tỷ', 'Thương lượng · 10 × 23 m', 3, False),
    ('biet-thu-an-xuan-thanh-khe-198m2', 'BIỆT THỰ · THANH KHÊ · ĐÀ NẴNG', 'Đường An Xuân', '198 m² · 3,5 tầng · 4 PN', ['2 mặt tiền', 'Hầm để ô tô', 'Ngang 10 m'], '15,5 tỷ', 'Thương lượng · An Khê', 4, False),
    ('villa-vo-duy-ninh-man-thai-4-tang', 'VILLA · MÂN THÁI · SƠN TRÀ', 'Đường Võ Duy Ninh', '~63 m² · 4 tầng · 4 PN', ['Hồ bơi riêng, xông hơi', 'Cách biển ~200 m', 'Hướng Đông Nam'], '8,95 tỷ', 'Thương lượng · chủ cần bán', 4, True),
    ('villa-mini-tra-lo-hoa-hai-100m2', 'VILLA MINI · HÒA HẢI · NGŨ HÀNH SƠN', 'Đường Trà Lộ', '100 m² · 3 tầng · 3 PN', ['Hồ bơi, full nội thất', 'Cách biển ~400 m', 'Hướng Nam, 5 × 20 m'], '7,5 tỷ', 'Thương lượng · mới 100%', 3, True),
]
for name, area, street, head, rows, gia, note, floors, pool in CARDS:
    W, H = 1600, 1200
    im = Image.new('RGB', (W, H), NAVY)
    dr = ImageDraw.Draw(im)
    # Biệt thự minh họa: khối nhà rộng, số tầng theo tin, mái bằng, cây hai bên, hồ bơi phía trước nếu có.
    bx, bw, base, fh = 1000, 470, 960, 120 if floors <= 3 else 92
    top = base - floors * fh
    dr.rectangle([940, base, 1560, 1020], fill=GREEN)
    for r in range(floors):
        y0 = top + r * fh
        x0 = bx + (40 if r == 0 and floors > 2 else 0)
        dr.rectangle([x0, y0, bx + bw, y0 + fh], fill='#1b3560', outline=NAVY, width=3)
        for c in range(3):
            wx = x0 + 30 + c * ((bw - (x0 - bx) - 60) // 3)
            dr.rectangle([wx, y0 + 22, wx + 100, y0 + fh - 18], fill=GOLD if (r + c) % 3 == 1 else '#2b4a7c')
        dr.rectangle([x0 - 12, y0 + fh - 8, bx + bw + 12, y0 + fh], fill=CREAM)
    dr.rectangle([bx - 20, top - 16, bx + bw + 20, top], fill=GOLD)
    for tx in (965, 1520):
        dr.rectangle([tx - 6, base - 90, tx + 6, base], fill='#5a3d22')
        dr.ellipse([tx - 45, base - 190, tx + 45, base - 80], fill='#3f8a62')
    if pool:
        dr.rounded_rectangle([1040, 975, 1420, 1012], radius=10, fill='#4fb3d1')
    dr.rectangle([60, 1030, W - 60, 1040], fill=GOLD)
    dr.text((80, 70), area, font=f(32, True), fill=GOLD)
    dr.text((80, 120), street, font=f(78 if len(street) < 20 else 64, True), fill=CREAM)
    dr.text((80, 255), head, font=f(54, True), fill=CREAM)
    y = 380
    for t in rows:
        dr.ellipse([84, y + 14, 106, y + 36], fill=GOLD)
        dr.text((130, y), t, font=f(44), fill=CREAM)
        y += 78
    dr.rounded_rectangle([80, 740, 640, 880], radius=26, fill=GOLD)
    dr.text((115, 765), gia, font=f(76, True), fill=NAVY)
    dr.text((80, 915), note, font=f(36), fill=CREAM)
    dr.text((80, 1075), 'Hoàng Hiệp · Zalo 0904 567 009 · hiephoangmt.com', font=f(40, True), fill=GOLD)
    im.save(os.path.join(OUT, name + '-4x3.jpg'), quality=86, optimize=True, progressive=True)
print('ok', len(CARDS))
