"""Ảnh thẻ tin tự vẽ (3:2) cho 17 tin bán khách sạn / tòa căn hộ – khách sạn ven biển Đà Nẵng (14/11/2026).
Tông kem – nâu – vàng kim (anh Hiệp chọn 14/11/2026): nền kem, chữ nâu, giá chữ vàng kim chuyển sắc, chân nâu."""
import sys, os
from PIL import Image, ImageDraw, ImageFont, ImageFilter
OUT = sys.argv[1]
FD = os.path.join(os.path.dirname(os.path.abspath(__file__)), 'fonts')
XB, SB, MD = FD + '/BeVietnamPro-ExtraBold.ttf', FD + '/BeVietnamPro-SemiBold.ttf', FD + '/BeVietnamPro-Medium.ttf'
f = lambda p, s: ImageFont.truetype(p, s)
CREAM, CREAM2, BROWN, DARK, CARAMEL, TAUPE = (246, 241, 231), (235, 226, 209), (83, 37, 22), (65, 34, 32), (138, 75, 28), (150, 122, 104)
GOLDS = [(150, 98, 24), (201, 146, 52), (246, 210, 98), (214, 160, 60), (160, 104, 26)]
CARDS = [
 [
  "ks-1411-01-goc-9-tang-bien-son-thuy-45-phong",
  "KHÁCH SẠN · NGŨ HÀNH SƠN",
  "Khu biển Sơn Thủy",
  "9 tầng · 45 phòng",
  [
   "Căn góc, đất 343 m², ngang 16 m",
   "9 tầng, 45 phòng",
   "Khu biển Sơn Thủy – Ngũ Hành Sơn"
  ],
  "68 tỷ",
  "Thương lượng · đất 343 m² · ngang 16 m",
  9,
  False
 ],
 [
  "ks-1411-02-can-ho-11-tang-ho-xuan-huong-45-phong-75",
  "TÒA CĂN HỘ – KHÁCH SẠN · NGŨ HÀNH SƠN",
  "Đường Hồ Xuân Hương",
  "11 tầng · 45 phòng",
  [
   "11 tầng, 45 phòng",
   "Mặt tiền Hồ Xuân Hương, gần biển Mỹ Khê",
   "Đất 200 m², ngang 10 m"
  ],
  "75 tỷ",
  "Thương lượng · đất 200 m² · ngang 10 m",
  11,
  False
 ],
 [
  "ks-1411-03-can-ho-11-tang-duong-dinh-nghe-37-phong",
  "TÒA CĂN HỘ – KHÁCH SẠN · SƠN TRÀ",
  "Đường Dương Đình Nghệ",
  "11 tầng · 37 phòng",
  [
   "11 tầng, 37 phòng",
   "Dương Đình Nghệ – phố khách sạn gần biển Phạm Văn Đồng",
   "Đất 180 m², ngang 10 m"
  ],
  "86 tỷ",
  "Thương lượng · đất 180 m² · ngang 10 m",
  11,
  False
 ],
 [
  "ks-1411-04-12-tang-2-mat-tien-bien-pham-van-dong-60",
  "KHÁCH SẠN · SƠN TRÀ",
  "Khu biển Phạm Văn Đồng",
  "12 tầng · 60 phòng",
  [
   "2 mặt tiền, khu biển Phạm Văn Đồng",
   "12 tầng, 60 phòng",
   "Đất 235 m², ngang 15 m"
  ],
  "105 tỷ",
  "Thương lượng · đất 235 m² · ngang 15 m",
  12,
  False
 ],
 [
  "ks-1411-05-12-tang-mat-tien-ho-nghinh-50-phong",
  "KHÁCH SẠN · SƠN TRÀ",
  "Đường Hồ Nghinh",
  "12 tầng · 50 phòng",
  [
   "Mặt tiền Hồ Nghinh – trục khách sạn sát biển",
   "12 tầng, 50 phòng",
   "Đất 200 m², ngang 10 m"
  ],
  "115 tỷ",
  "Thương lượng · đất 200 m² · ngang 10 m",
  12,
  False
 ],
 [
  "ks-1411-06-10-tang-mat-tien-ho-xuan-huong-56-phong",
  "KHÁCH SẠN · NGŨ HÀNH SƠN",
  "Đường Hồ Xuân Hương",
  "10 tầng · 56 phòng",
  [
   "Mặt tiền Hồ Xuân Hương",
   "10 tầng, 56 phòng",
   "Đất 381 m², ngang 9 m"
  ],
  "115 tỷ",
  "Thương lượng · đất 381 m² · ngang 9 m",
  10,
  False
 ],
 [
  "ks-1411-07-3-sao-11-tang-an-thuong-29-37-phong",
  "KHÁCH SẠN 3* · NGŨ HÀNH SƠN",
  "Đường An Thượng 29",
  "11 tầng · 37 phòng",
  [
   "3 sao, khu phố Tây An Thượng",
   "11 tầng, 37 phòng",
   "Đất 296 m², ngang 15 m"
  ],
  "120 tỷ",
  "Thương lượng · đất 296 m² · ngang 15 m",
  11,
  False
 ],
 [
  "ks-1411-08-12-tang-mat-tien-phan-ton-42-phong",
  "KHÁCH SẠN · SƠN TRÀ",
  "Đường Phan Tôn",
  "12 tầng · 42 phòng",
  [
   "Mặt tiền Phan Tôn, gần biển",
   "12 tầng, 42 phòng",
   "Đất 207 m², ngang 12,5 m"
  ],
  "120 tỷ",
  "Thương lượng · đất 207 m² · ngang 12,5 m",
  12,
  False
 ],
 [
  "ks-1411-09-can-ho-11-tang-ho-xuan-huong-61-phong-12",
  "TÒA CĂN HỘ – KHÁCH SẠN · NGŨ HÀNH SƠN",
  "Đường Hồ Xuân Hương",
  "11 tầng · 61 phòng",
  [
   "11 tầng, 61 phòng",
   "Đất lớn 443 m², ngang 13 m",
   "Có thể cải tạo lên chuẩn 4 sao"
  ],
  "126 tỷ",
  "Thương lượng · đất 443 m² · ngang 13 m",
  11,
  False
 ],
 [
  "ks-1411-10-3-sao-16-tang-ho-nghinh-68-phong",
  "KHÁCH SẠN 3* · SƠN TRÀ",
  "Đường Hồ Nghinh",
  "16 tầng · 68 phòng",
  [
   "3 sao 16 tầng, 68 phòng",
   "Đường Hồ Nghinh, sát biển Phạm Văn Đồng",
   "Đất 252 m², ngang 10 m"
  ],
  "128 tỷ",
  "Thương lượng · đất 252 m² · ngang 10 m",
  16,
  False
 ],
 [
  "ks-1411-11-3-sao-12-tang-tran-bach-dang-57-phong",
  "KHÁCH SẠN 3* · NGŨ HÀNH SƠN",
  "Đường Trần Bạch Đằng",
  "12 tầng · 57 phòng",
  [
   "3 sao 12 tầng, 57 phòng",
   "Trần Bạch Đằng – khu An Thượng, gần biển Mỹ Khê",
   "Đất 162 m², ngang 9 m"
  ],
  "128 tỷ",
  "Thương lượng · đất 162 m² · ngang 9 m",
  12,
  False
 ],
 [
  "ks-1411-12-4-sao-16-tang-pham-van-dong-74-phong",
  "KHÁCH SẠN 4* · SƠN TRÀ",
  "Đường Phạm Văn Đồng",
  "16 tầng · 74 phòng",
  [
   "4 sao 16 tầng, 74 phòng",
   "Trục Phạm Văn Đồng – cầu Sông Hàn ra biển",
   "Đất 345 m², ngang 14 m"
  ],
  "160 tỷ",
  "Thương lượng · đất 345 m² · ngang 14 m",
  16,
  False
 ],
 [
  "ks-1411-13-3-sao-12-tang-vo-van-kiet-53-phong",
  "KHÁCH SẠN 3* · SƠN TRÀ",
  "Đường Võ Văn Kiệt",
  "12 tầng · 53 phòng",
  [
   "3 sao 12 tầng, 53 phòng",
   "Trục Võ Văn Kiệt ra biển Mỹ Khê",
   "Đất 268 m², ngang 13,5 m"
  ],
  "170 tỷ",
  "Thương lượng · đất 268 m² · ngang 13,5 m",
  12,
  False
 ],
 [
  "ks-1411-14-3-sao-12-tang-duong-dinh-nghe-56-phong",
  "KHÁCH SẠN 3* · SƠN TRÀ",
  "Đường Dương Đình Nghệ",
  "12 tầng · 56 phòng",
  [
   "3 sao 12 tầng: 50 phòng + 6 căn hộ",
   "Đất lớn 368 m², ngang 18 m",
   "Dương Đình Nghệ – gần biển Phạm Văn Đồng"
  ],
  "165 tỷ",
  "Thương lượng · đất 368 m² · ngang 18 m",
  12,
  False
 ],
 [
  "ks-1411-15-12-tang-pho-di-bo-tran-bach-dang-50-phon",
  "KHÁCH SẠN · NGŨ HÀNH SƠN",
  "Phố đi bộ Trần Bạch Đằng",
  "12 tầng · 50 phòng",
  [
   "Mặt tiền phố đi bộ Trần Bạch Đằng",
   "12 tầng, 50 phòng",
   "Đất 180 m², ngang 10 m"
  ],
  "150 tỷ",
  "Thương lượng · đất 180 m² · ngang 10 m",
  12,
  False
 ],
 [
  "ks-1411-16-goc-3-sao-12-tang-ha-bong-66-phong",
  "KHÁCH SẠN 3* · SƠN TRÀ",
  "Đường Hà Bổng",
  "12 tầng · 66 phòng",
  [
   "Căn góc, đất 302 m², ngang 18,8 m",
   "3 sao 12 tầng, 66 phòng",
   "Hà Bổng – sát biển Mỹ Khê"
  ],
  "200 tỷ",
  "Thương lượng · đất 302 m² · ngang 18,8 m",
  12,
  False
 ],
 [
  "ks-1411-17-4-sao-12-tang-bien-pham-van-dong-84-phon",
  "KHÁCH SẠN 4* · SƠN TRÀ",
  "Khu biển Phạm Văn Đồng",
  "12 tầng · 84 phòng",
  [
   "4 sao 12 tầng, 84 phòng",
   "Đất lớn 610 m², ngang 30 m",
   "Khu biển Phạm Văn Đồng"
  ],
  "250 tỷ",
  "Thương lượng · đất 610 m² · ngang 30 m",
  12,
  False
 ]
]
def gold_text(im, xy, txt, font):
    W, H = im.size
    mask = Image.new('L', (W, H), 0)
    ImageDraw.Draw(mask).text(xy, txt, font=font, fill=255)
    x0, y0, x1, y1 = mask.getbbox()
    grad = Image.new('RGB', (W, H))
    gd = ImageDraw.Draw(grad)
    for y in range(y0, y1 + 1):
        t = (y - y0) / max(1, y1 - y0)
        seg = t * (len(GOLDS) - 1)
        i = min(int(seg), len(GOLDS) - 2)
        u = seg - i
        gd.line([x0, y, x1, y], fill=tuple(int(GOLDS[i][k] * (1 - u) + GOLDS[i + 1][k] * u) for k in range(3)))
    sh = mask.filter(ImageFilter.GaussianBlur(4)).point(lambda v: int(v * 0.35))
    im.paste((120, 70, 20), (3, 4), sh) if False else None
    shadow = Image.new('RGB', (W, H), (150, 110, 60))
    im.paste(shadow, (0, 0), Image.eval(mask.filter(ImageFilter.GaussianBlur(5)), lambda v: int(v * 0.3)).transform((W, H), Image.AFFINE, (1, 0, -3, 0, 1, -4)))
    im.paste(grad, (0, 0), mask)

for name, area, street, head, rows, gia, note, floors, pool in CARDS:
    rows = [r.split(' – ')[0] for r in rows if 'tầng' not in r] or rows
    rows = [r if len(r) <= 34 else r[:33].rsplit(' ', 1)[0] for r in rows][:3]
    W, H = 1500, 1000
    im = Image.new('RGB', (W, H), CREAM)
    dr = ImageDraw.Draw(im)
    for y in range(H):  # nền kem chuyển nhẹ
        t = y / H
        dr.line([0, y, W, y], fill=tuple(int(CREAM[k] * (1 - t) + CREAM2[k] * t) for k in range(3)))
    # Tòa nhà minh họa: thân kem trắng, cửa nâu, điểm vàng, chân là bãi cát + biển nhạt.
    bx, bw, base = 1060, 300, 840
    fh = min(44, int(620 / floors))
    top = base - floors * fh
    dr.rectangle([900, base, 1500, base + 34], fill=(225, 210, 180))
    dr.rectangle([900, base + 34, 1500, base + 60], fill=(190, 205, 200))
    dr.rectangle([bx + 8, top + 8, bx + bw + 8, base], fill=(215, 200, 175))
    dr.rectangle([bx, top, bx + bw, base], fill=(255, 252, 245), outline=(200, 180, 150), width=2)
    dr.rectangle([bx - 12, top - 16, bx + bw + 12, top], fill=BROWN)
    for r in range(floors):
        for c in range(4):
            y0 = top + 8 + r * fh
            dr.rectangle([bx + 22 + c * 68, y0, bx + 68 + c * 68, y0 + fh - 14], fill=(214, 168, 80) if (r * 4 + c) % 5 == 2 else (120, 84, 60))
    # Chữ (chừa góc trái trên cho nhãn "Bán" của thẻ tin).
    dr.text((250, 56), area, font=f(SB, 28), fill=CARAMEL)
    dr.text((80, 120), street, font=f(XB, 70 if len(street) < 20 else 58), fill=DARK)
    dr.text((80, 225), head, font=f(SB, 46), fill=CARAMEL)
    y = 315
    for t in rows:
        dr.ellipse([84, y + 14, 100, y + 30], fill=(201, 146, 52))
        dr.text((118, y), t, font=f(MD, 38), fill=DARK)
        y += 62
    gold_text(im, (76, 520), gia, f(XB, 130))
    dr = ImageDraw.Draw(im)
    dr.rectangle([82, 700, 300, 705], fill=BROWN)
    dr.text((80, 728), note, font=f(MD, 32), fill=TAUPE)
    dr.rectangle([0, 900, W, H], fill=BROWN)
    t = 'HOÀNG HIỆP  ·  Zalo 0904 567 009  ·  hiephoangmt.com'
    dr.text(((W - dr.textlength(t, font=f(SB, 36))) / 2, 928), t, font=f(SB, 36), fill=(246, 222, 160))
    im.save(os.path.join(OUT, name + '.jpg'), quality=88, optimize=True, progressive=True)
print('ok', len(CARDS))
