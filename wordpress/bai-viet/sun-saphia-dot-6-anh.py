"""Ảnh đại diện loạt bài Sun Saphia đợt 6 (02/11 – 07/11/2026, 15:00): đồ hoạ tự vẽ nền navy + nhãn liên hệ (scripts/dong-dau-anh.py)."""
import sys, math, importlib.util
from PIL import Image, ImageDraw, ImageFont
O = sys.argv[1]
spec = importlib.util.spec_from_file_location('dd', __file__.rsplit('/', 2)[0] + '/scripts/dong-dau-anh.py'); dd = importlib.util.module_from_spec(spec); spec.loader.exec_module(dd)
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'; FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
NAVY = (11, 26, 42); GOLD = '#e8b04a'; W, H = 1200, 675
CARDS = [
 ('cong-vien-bien-truong-sa-sun-saphia', 'HẠ TẦNG · NGŨ HÀNH SƠN', 'Công viên biển 2,45 ha Trường Sa', 'Đất dự án bỏ hoang thành công viên trước Sun Saphia Residence', [('2,45 ha', 'thu hồi từ dự án bỏ hoang'), ('~47 tỷ', 'vốn đầu tư công'), ('2027', 'thực hiện đến'), ('400 m', 'từ Sun Saphia ra bãi Sơn Thủy')]),
 ('gia-phong-khach-san-da-nang-2026', 'THỊ TRƯỜNG · LƯU TRÚ', 'Giá phòng khách sạn ven biển 2026', 'Tham khảo 10/2026 – khu Mỹ Khê, Sơn Thủy, An Thượng', [('3,7 – 3,9 tr', 'resort 5 sao mặt biển/đêm'), ('1,25 – 3,13 tr', '4 sao mặt biển/đêm'), ('88 – 90%', 'lấp đầy 4 – 5 sao quý III'), ('2,2 – 2,9 tr', 'studio Sun Saphia (giả định)')]),
 ('so-sanh-loai-hinh-cho-thue-da-nang', 'KINH NGHIỆM · ĐẦU TƯ', 'Đầu tư cho thuê: chọn loại hình nào?', 'Lợi suất tham khảo 2026 tại Đà Nẵng', [('2 – 3%', 'shophouse mặt tiền'), ('1,4 – 1,8%', 'nhà phố trung tâm'), ('3,6 – 5,5%', 'biệt thự biển'), ('Từ 2,1 tỷ', 'căn lưu trú Sun Saphia')]),
 ('dau-tu-khach-san-da-nang', 'KINH NGHIỆM · KHÁCH SẠN', 'Xây, mua lại hay mua căn lưu trú?', 'Ba con đường sở hữu khách sạn ở Đà Nẵng', [('15 – 30 tỷ', 'xây 3 sao 30 – 50 phòng, chưa đất'), ('~67 tỷ', 'rao mua 3 sao 50 phòng'), ('2 – 3 năm', 'xây mới mới có doanh thu'), ('2,13 – 2,85 tỷ', 'studio Sun Saphia')]),
 ('phi-kenh-dat-phong-cho-thue', 'KINH NGHIỆM · VẬN HÀNH', 'Phí Booking, Agoda, Airbnb', 'Hoa hồng kênh đặt phòng khi cho thuê theo đêm', [('15 – 18%', 'Booking.com'), ('12 – 20%', 'Agoda'), ('3%', 'Airbnb nếu chia phí'), ('~25 tr/năm', 'mỗi 5% phí với 1 studio')]),
 ('cong-trinh-cap-1-sun-saphia', 'PHÁP LÝ · KIẾN THỨC', 'Công trình cấp I là gì?', 'Phân cấp theo Thông tư 06/2021/TT-BXD', [('75 – 200 m', 'chiều cao nhà cấp I'), ('25 – 50 tầng', 'số tầng nhà cấp I'), ('114 m', 'Sun Saphia – 30 tầng'), ('100 năm', 'niên hạn chủ đầu tư công bố')]),
]
for name, tag, title, sub, stats in CARDS:
    base = Image.new('RGBA', (W, H), NAVY + (255,)); ov = Image.new('RGBA', (W, H), (0, 0, 0, 0)); g = ImageDraw.Draw(ov)
    for x in range(0, W, 32): g.line([x, 0, x, H], fill=(255, 255, 255, 14))
    for y in range(0, H, 32): g.line([0, y, W, y], fill=(255, 255, 255, 14))
    for k in range(4):
        g.line([(x, H - 14 - k * 14 + (5 + k * 2) * math.sin(2 * math.pi * (x + k * 61) / (240 + k * 50))) for x in range(0, W + 1, 4)], fill=(120, 190, 235, 70 - k * 14), width=3)
    im = Image.alpha_composite(base, ov).convert('RGB'); d = ImageDraw.Draw(im)
    d.rectangle([0, 0, W, 8], fill=GOLD)
    d.text((56, 44), tag, font=f(22, True), fill=GOLD)
    ts = 54
    while d.textlength(title, font=f(ts, True)) > W - 112: ts -= 2
    d.text((56, 84), title, font=f(ts, True), fill='white')
    d.text((56, 160), sub, font=f(28), fill=(190, 210, 230))
    for i, (big, small) in enumerate(stats):
        x = 56 + i * 272; y = 250
        d.rounded_rectangle([x, y, x + 250, y + 170], 14, fill=(16, 40, 64), outline=GOLD, width=2)
        bs = 40
        while d.textlength(big, font=f(bs, True)) > 220: bs -= 2
        d.text((x + 20, y + 26), big, font=f(bs, True), fill=GOLD)
        words, line, lines = small.split(), '', []
        for w_ in words:
            t = (line + ' ' + w_).strip()
            if d.textlength(t, font=f(19)) > 215: lines.append(line); line = w_
            else: line = t
        lines.append(line)
        for j, l in enumerate(lines[:3]): d.text((x + 20, y + 96 + j * 24), l, font=f(19), fill=(200, 215, 230))
    d.text((56, 470), 'Dự án tham chiếu: Sun Saphia Residence – Trường Sa, Sơn Thủy, Ngũ Hành Sơn', font=f(20), fill=(170, 190, 210))
    p = f'{O}/{name}.jpg'; im.save(p, quality=92)
    print(name, dd.stamp(p, tile=False))
