"""Ảnh đại diện loạt bài Sun Saphia đợt 3 (30/10 – 05/11/2026): đồ hoạ tự vẽ nền navy + nhãn liên hệ (scripts/dong-dau-anh.py)."""
import sys, math, importlib.util
from PIL import Image, ImageDraw, ImageFont
O = sys.argv[1]
spec = importlib.util.spec_from_file_location('dd', __file__.rsplit('/', 2)[0] + '/scripts/dong-dau-anh.py'); dd = importlib.util.module_from_spec(spec); spec.loader.exec_module(dd)
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'; FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
NAVY = (11, 26, 42); GOLD = '#e8b04a'; W, H = 1200, 675
CARDS = [
 ('studio-sun-saphia-residence', 'SẢN PHẨM · STUDIO', 'Studio Sun Saphia Residence', 'Bố trí, công năng và ai nên mua', [('513/782', 'căn là studio'), ('30 – 31 m²', 'thông thủy, căn góc ~40 m²'), ('3,8 × 9 m', 'mặt tiền × chiều sâu'), ('3,5 m', 'chiều cao tầng')]),
 ('tien-ich-sun-saphia-residence', 'TIỆN ÍCH · TRONG VÀ NGOÀI', 'Tiện ích Sun Saphia Residence', 'Trong tòa 30 tầng và quanh bãi tắm Sơn Thủy', [('Bể bơi', 'view biển, yoga'), ('Gym', 'pilates, thương mại'), ('2,45 ha', 'công viên phía trước'), ('500 m', 'tới ga LRT 09 (dự kiến)')]),
 ('chi-phi-mua-sun-saphia-residence', 'KINH NGHIỆM · CHI PHÍ', 'Chi phí ngoài giá bán', 'Ví dụ studio giá tham khảo 3 tỷ – Sun Saphia Residence', [('VAT 10%', 'tối đa 300 triệu'), ('2%', 'kinh phí bảo trì – 60 triệu'), ('0,5%', 'lệ phí trước bạ – ~15 triệu'), ('~375 tr', 'nếu giá chưa gồm VAT')]),
 ('vay-mua-sun-saphia-residence', 'KINH NGHIỆM · VAY MUA', 'Vay mua Sun Saphia Residence', 'Trả góp mỗi tháng – giả định lãi 10 – 12%/năm', [('1,5 tỷ', 'vay 50% studio 3 tỷ'), ('14,5 – 16,5 tr', 'mỗi tháng, 20 năm'), ('2,7 tỷ', 'vay 60% căn 1PN 4,5 tỷ'), ('3 ngân hàng', 'VietinBank, BIDV, NCB')]),
 ('khach-du-lich-da-nang-9-thang-2026', 'THỊ TRƯỜNG · DU LỊCH', 'Khách du lịch Đà Nẵng 9 tháng 2026', 'Số liệu UBND TP công bố 23/10/2026', [('15,86 tr', 'lượt khách lưu trú (+26,4%)'), ('7,73 tr', 'khách quốc tế (+28,7%)'), ('14,43 tr', 'khách ngủ qua đêm (+29,6%)'), ('52.945 tỷ', 'doanh thu lưu trú, ăn uống')]),
 ('cho-thue-ngan-ngay-sun-saphia-residence', 'PHÁP LÝ · CHO THUÊ', 'Cho thuê ngắn ngày căn hộ', '4 việc cần làm trước khi cho khách thuê theo đêm', [('Công năng', 'dùng đúng hợp đồng'), ('Cơ sở lưu trú', 'đăng ký nếu kinh doanh'), ('Khai báo', 'lưu trú mọi khách'), ('100 tr/năm', 'ngưỡng phải nộp thuế')]),
 ('thi-truong-can-ho-da-nang-quy-3-2026', 'THỊ TRƯỜNG · QUÝ III/2026', 'Căn hộ Đà Nẵng quý III/2026', 'Số liệu DKRA (báo chí trích dẫn)', [('4.385', 'căn sơ cấp, 20 dự án (-14%)'), ('2.099', 'căn tiêu thụ (-25%)'), ('68%', 'tiêu thụ là căn hộ hạng B'), ('500 – 1.000', 'căn mới dự kiến quý IV')]),
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
