"""Ảnh đại diện loạt bài Sun Saphia đợt 7 (13/11 – 19/11/2026, 08:00): đồ hoạ tự vẽ nền navy + nhãn liên hệ (scripts/dong-dau-anh.py)."""
import sys, math, importlib.util
from PIL import Image, ImageDraw, ImageFont
O = sys.argv[1]
spec = importlib.util.spec_from_file_location('dd', __file__.rsplit('/', 2)[0] + '/scripts/dong-dau-anh.py'); dd = importlib.util.module_from_spec(spec); spec.loader.exec_module(dd)
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'; FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
NAVY = (11, 26, 42); GOLD = '#e8b04a'; W, H = 1200, 675
CARDS = [
 ('chon-day-can-sun-saphia', 'KINH NGHIỆM · CHỌN CĂN', 'Mặt biển, cánh bên hay phía sau?', 'Studio 30 m² tầng 15 – giá dự kiến chủ đầu tư 28/10/2026', [('2,13 tỷ', 'dãy phía sau'), ('2,37 tỷ', 'cánh bên, +11%'), ('2,85 tỷ', 'dãy mặt biển, +34%'), ('+34%', 'doanh thu cần thêm để hòa tỷ suất')]),
 ('mua-du-lich-da-nang-sun-saphia', 'THỊ TRƯỜNG · LƯU TRÚ', 'Mùa du lịch và lấp đầy phòng', 'Công suất phòng Đà Nẵng theo mùa – tham khảo báo chí 2025 – 2026', [('75 – 80%', 'hè tháng 6 – 8'), ('85 – 98%', 'các đêm pháo hoa DIFF 2026'), ('> 66%', 'bình quân 12 tháng (CoStar)'), ('60%', 'giả định của chủ đầu tư')]),
 ('khach-quoc-te-da-nang-sun-saphia', 'THỊ TRƯỜNG · KHÁCH QUỐC TẾ', 'Ai sẽ thuê căn hộ ven biển?', 'Cơ cấu khách quốc tế đến Đà Nẵng năm 2026', [('20,55%', 'khách Hàn Quốc, 6 tháng'), ('8,6%', 'khách Trung Quốc, 6 tháng'), ('+20,2%', 'khách quốc tế 10 tháng'), ('~1,2 triệu', 'lượt khách Hàn Quốc, 7 tháng')]),
 ('tu-cho-thue-hay-van-hanh-sun-saphia', 'KINH NGHIỆM · VẬN HÀNH', 'Tự cho thuê hay thuê vận hành?', 'Mức chia lợi nhuận và phí thường gặp trên thị trường', [('85/15', 'chủ căn / đơn vị vận hành'), ('15 – 50%', 'phí quản lý tùy hợp đồng'), ('22 – 35%', 'chi phí vận hành khách sạn'), ('12%', 'cam kết từng bị dừng trả')]),
 ('noi-that-studio-sun-saphia', 'KINH NGHIỆM · NỘI THẤT', 'Nội thất studio 30 m² hết bao nhiêu?', 'Báo giá thi công nội thất năm 2026', [('80 – 130 tr', 'gói cơ bản'), ('130 – 180 tr', 'gói tiêu chuẩn'), ('180 – 300 tr', 'gói cao cấp'), ('~30 tr/năm', 'khấu hao gói 150 tr trong 5 năm')]),
 ('san-bay-da-nang-sun-saphia', 'HẠ TẦNG · SÂN BAY', 'Sân bay Đà Nẵng nâng cấp', 'Cải tạo đường cất hạ cánh 17R/35L và quy hoạch đến 2030', [('~1.696 tỷ', 'cải tạo đường băng, đường lăn'), ('2026 – 2028', 'thời gian thực hiện'), ('20 triệu', 'khách/năm theo quy hoạch'), ('15,1 triệu', 'lượt khách năm 2025')]),
 ('can-2pn-sun-saphia', 'SẢN PHẨM · CĂN 2PN', 'Căn 2PN ở góc tòa', 'Sun Saphia Residence – tài liệu chủ đầu tư 10/2026', [('133 căn', 'căn 2PN trong tòa'), ('60 – 70 m²', 'diện tích thông thủy'), ('5 căn/sàn', 'tầng điển hình 3A – 28'), ('3,5 m', 'chiều cao tầng căn hộ')]),
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
