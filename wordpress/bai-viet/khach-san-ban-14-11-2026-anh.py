"""Ảnh thẻ tin tự vẽ (3:2) cho 17 tin bán khách sạn / tòa căn hộ – khách sạn ven biển Đà Nẵng (14/11/2026) – không dùng ảnh tin rao của bên khác."""
import sys, os
from PIL import Image, ImageDraw, ImageFont
OUT = sys.argv[1]
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'
FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
GOLD, CREAM, NAVY, SEA = '#d8b16a', '#f7f1e3', '#0f2240', '#1f6f8b'
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
for name, area, street, head, rows, gia, note, floors, pool in CARDS:
    rows = [r.split(' – ')[0] for r in rows if 'tầng' not in r] or rows
    rows = [r if len(r) <= 34 else r[:33].rsplit(' ', 1)[0] for r in rows][:3]
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
