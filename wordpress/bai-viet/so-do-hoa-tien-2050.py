"""Sơ đồ tự vẽ (không theo tỷ lệ): 4 vùng phát triển đô thị Hòa Tiến đến 2050 – không dùng bản vẽ có chữ chìm, logo trang khác."""
import sys
from PIL import Image, ImageDraw, ImageFont
OUT = sys.argv[1]
W, H = 1600, 1067
im = Image.new('RGB', (W, H), '#f5f7fa')
d = ImageDraw.Draw(im)
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'
FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
NAVY, GREY = '#14284b', '#55607a'
d.text((60, 40), 'ĐÔ THỊ HÒA TIẾN – ĐÀ NẴNG ĐẾN 2050', font=f(26, True), fill='#b8893b')
d.text((60, 78), 'Định hướng 4 vùng phát triển (Tây → Đông)', font=f(48, True), fill=NAVY)
d.text((60, 140), 'Sơ đồ minh hoạ, không theo tỷ lệ · Hoàng Hiệp vẽ theo định hướng quy hoạch chung (tham khảo)', font=f(22), fill=GREY)
zones = [
    ('#7fb77e', 'VÙNG SINH THÁI', 'PHÍA TÂY', ['Đồng Nghệ, Phú Sơn', 'Rừng, hồ Đồng Nghệ', 'Du lịch sinh thái,', 'nghỉ dưỡng mật độ thấp']),
    ('#c9d98a', 'VÙNG CHUYỂN TIẾP', 'TRUNG TÂM', ['Hương Lam, La Châu,', 'An Trạch, La Bông', 'Dân cư hiện hữu,', 'cây xanh, mặt nước']),
    ('#f0b26b', 'VÙNG ĐÔ THỊ', 'PHÍA ĐÔNG', ['Cẩm Nê, Yến Nê,', 'Dương Sơn, Lệ Sơn', 'Khu ở mới, NOXH,', 'thương mại – dịch vụ']),
    ('#a99bd6', 'CÔNG NGHIỆP –', 'LOGISTICS', ['CCN Hòa Tiến 1, 2', '(Phú Sơn Nam)', 'Logistics, kho bãi', 'giáp Vành đai phía Tây']),
]
x0, y0, cw, ch, gap = 60, 230, 350, 400, 20
for i, (c, t1, t2, rows) in enumerate(zones):
    x = x0 + i * (cw + gap)
    d.rounded_rectangle([x, y0, x + cw, y0 + ch], radius=22, fill=c)
    d.text((x + 24, y0 + 26), t1, font=f(28, True), fill=NAVY)
    d.text((x + 24, y0 + 64), t2, font=f(28, True), fill=NAVY)
    for j, r in enumerate(rows):
        d.text((x + 24, y0 + 140 + j * 48), r, font=f(25), fill='#1f2a3d')
# Mũi tên trục Đông – Tây
ay = y0 + ch + 90
d.line([x0, ay, W - 60, ay], fill=NAVY, width=6)
d.polygon([(W - 60, ay), (W - 90, ay - 16), (W - 90, ay + 16)], fill=NAVY)
d.text((x0, ay + 20), 'Trục Đông – Tây: từ rừng núi, bán sơn địa sang đô thị tập trung', font=f(24, True), fill=NAVY)
d.text((x0, ay + 62), 'Trục Bắc – Nam: QL14B · ĐT605 · Vành đai phía Tây · cao tốc Đà Nẵng – Quảng Ngãi (CT.01) · dự kiến ga đường sắt tốc độ cao', font=f(21), fill=GREY)
d.text((x0, H - 60), 'Đô thị loại III, sinh thái – dịch vụ – nông nghiệp · cửa ngõ Tây Nam Đà Nẵng · Hoàng Hiệp 0904 567 009', font=f(22, True), fill='#b8893b')
im.save(OUT, quality=88, optimize=True, progressive=True)
