"""Ảnh đại diện loạt bài Sun Saphia đợt 8 (12/11 – 15/11/2026): đồ hoạ tự vẽ nền navy + nhãn liên hệ (scripts/dong-dau-anh.py)."""
import sys, math, importlib.util
from PIL import Image, ImageDraw, ImageFont
O = sys.argv[1]
spec = importlib.util.spec_from_file_location('dd', __file__.rsplit('/', 2)[0] + '/scripts/dong-dau-anh.py'); dd = importlib.util.module_from_spec(spec); spec.loader.exec_module(dd)
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'; FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
NAVY = (11, 26, 42); GOLD = '#e8b04a'; W, H = 1200, 675
CARDS = [
 ('nguoi-nuoc-ngoai-mua-sun-saphia', 'PHÁP LÝ · NGƯỜI NƯỚC NGOÀI', 'Người nước ngoài, Việt kiều mua được không?', 'Sun Saphia Residence – căn hộ thương mại dịch vụ, thời hạn 50 năm', [('0 căn', 'bán cho người nước ngoài (theo chủ đầu tư)'), ('30%', 'trần chỉ áp dụng chung cư nhà ở'), ('50 năm', 'thời hạn từ 17/09/2026'), ('Hỏi trước', 'Việt kiều còn quốc tịch Việt Nam')]),
 ('dung-ten-mua-sun-saphia', 'PHÁP LÝ · ĐỨNG TÊN', 'Ai đứng tên hợp đồng?', 'Một người, cả hai vợ chồng hay doanh nghiệp', [('2 bước', 'thỏa thuận nguyên tắc rồi hợp đồng mua bán'), ('Cả hai', 'vợ chồng ghi tên tài sản chung'), ('2%', 'thuế TNCN khi chuyển nhượng hợp đồng'), ('Không', 'nhờ người khác đứng tên hộ')]),
 ('phi-quan-ly-sun-saphia', 'CHI PHÍ · PHÍ QUẢN LÝ', 'Phí quản lý mỗi tháng bao nhiêu?', '15.000 – 20.000 đ/m²/tháng – dự kiến theo chủ đầu tư 04/11/2026', [('450 – 600k', 'studio 30 m²/tháng'), ('750k – 1 tr', '1PN+ 50 m²/tháng'), ('1,05 – 1,4 tr', '2PN 70 m²/tháng'), ('2%', 'kinh phí bảo trì, đóng một lần')]),
 ('ngu-hanh-son-sun-saphia', 'VỊ TRÍ · DANH THẮNG', 'Ngũ Hành Sơn ngay cạnh', 'Di tích quốc gia đặc biệt – số liệu khách năm 2025', [('~2,2 triệu', 'lượt khách năm 2025'), ('> 1,5 triệu', 'lượt khách quốc tế'), ('~3 – 4 km', 'từ dự án (ước tính bản đồ)'), ('15,86 tr', 'khách lưu trú Đà Nẵng 9 tháng 2026')]),
 ('sun-saphia-di-hoi-an', 'VỊ TRÍ · KẾT NỐI', 'Đi Hội An bao xa?', 'Trục ven biển Võ Nguyên Giáp – Trường Sa – Lạc Long Quân', [('~22 – 25 km', 'Sơn Thủy – phố cổ (ước tính)'), ('35 – 45 phút', 'đi taxi, tùy giờ'), ('9 – 14 km', 'tới sân bay Đà Nẵng'), ('1999', 'Hội An là di sản thế giới')]),
 ('cho-thue-dai-han-sun-saphia', 'CHO THUÊ · DÀI HẠN', 'Cho thuê theo tháng có lợi?', 'Giá chào thuê căn hộ nhỏ khu Ngũ Hành Sơn, tra cứu 11/2026', [('4 – 12 tr', 'mỗi tháng (giá chào)'), ('2,7 – 5,9%', 'tỷ suất ước tính, minh họa'), ('~35%', 'chi phí vận hành thuê theo đêm'), ('Theo mùa', 'kết hợp tháng và đêm')]),
 ('tang-cao-tang-thap-sun-saphia', 'KINH NGHIỆM · CHỌN TẦNG', 'Tầng cao hay tầng thấp?', 'Tòa 30 tầng, 114 m – thông tin chủ đầu tư 04/11/2026', [('3A – 28', 'tầng căn hộ điển hình'), ('7 tầng', 'tối đa phía Tây'), ('7 thang', '2 sảnh thang, 28 căn/sàn'), ('6,5 m', 'penthouse tầng 30')]),
 ('mua-de-o-sun-saphia', 'KINH NGHIỆM · MUA ĐỂ Ở', 'Mua để ở được không?', 'Căn hộ thương mại dịch vụ – những điều khác chung cư thường', [('Tạm trú', 'đăng ký được (theo chủ đầu tư)'), ('3,5 m', 'chiều cao tầng sàn – sàn'), ('Trừ bếp', 'bàn giao liền tường'), ('2,45 ha', 'công viên biển trước mặt')]),
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
