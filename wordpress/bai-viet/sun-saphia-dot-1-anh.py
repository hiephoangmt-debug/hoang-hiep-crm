"""Ảnh đại diện loạt bài Sun Saphia đợt 1 (20 – 26/10/2026): đồ hoạ tự vẽ nền navy + nhãn liên hệ (scripts/dong-dau-anh.py)."""
import sys, math, importlib.util
from PIL import Image, ImageDraw, ImageFont
O = sys.argv[1]
spec = importlib.util.spec_from_file_location('dd', __file__.rsplit('/', 2)[0] + '/scripts/dong-dau-anh.py'); dd = importlib.util.module_from_spec(spec); spec.loader.exec_module(dd)
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'; FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
NAVY = (11, 26, 42); GOLD = '#e8b04a'; W, H = 1200, 675
CARDS = [
 ('studio-ven-bien-da-nang-2026', 'THỊ TRƯỜNG · 10/2026', 'Studio ven biển Đà Nẵng', 'Giá mua, giá thuê, cách tính dòng tiền', [('30 – 38 m²', 'diện tích phổ biến'), ('2,3 – 3,7 tỷ', 'giá tham khảo'), ('~4,5%/năm', 'lợi suất cho thuê'), ('513 studio', 'tại Sun Saphia')]),
 ('mo-rong-duong-ven-bien-vo-nguyen-giap-truong-sa', 'HẠ TẦNG · LUỒNG XANH', 'Mở rộng đường ven biển', 'Võ Nguyên Giáp – Trường Sa – Lạc Long Quân', [('2.633 tỷ', 'vốn dự kiến'), ('4 → 6 làn', 'phương án nghiên cứu'), ('15 → 21 m', 'mặt cắt đường'), ('Sơn Thủy', 'khu biển hưởng lợi')]),
 ('duong-sat-do-thi-san-bay-my-khe-hoi-an', 'HẠ TẦNG · ĐƯỜNG SẮT ĐÔ THỊ', 'Sân bay – Mỹ Khê – Hội An', 'Tuyến ưu tiên số 1 của Đà Nẵng', [('17 trục', 'quy hoạch đến 2045'), ('> 204 km', 'tổng chiều dài'), ('> 7 km', 'LRT sân bay – Mỹ Khê'), ('2/2027', 'dự kiến khởi công')]),
 ('du-an-can-ho-sun-group-da-nang-2026', 'DỰ ÁN · 10/2026', 'Căn hộ Sun Group Đà Nẵng', 'Đang bàn giao – đang bán – sắp mở bán', [('3 dự án', 'đang bàn giao'), ('6 dự án', 'đang bán'), ('2 dự án', 'sắp mở bán'), ('782 căn', 'Sun Saphia, 11/2028')]),
 ('giu-cho-booking-can-ho-moi', 'KINH NGHIỆM MUA NHÀ', 'Giữ chỗ khác đặt cọc', 'Booking căn hộ mới: điều cần biết', [('≤ 5%', 'mức cọc tối đa (Luật KDBĐS 2023)'), ('Hoàn lại', 'phải ghi trên phiếu'), ('Công ty', 'tài khoản nhận tiền'), ('6 điều', 'cần kiểm tra')]),
 ('can-ho-ven-bien-my-khe-son-thuy-non-nuoc', 'THỊ TRƯỜNG · KHU VỰC', 'Mỹ Khê, Sơn Thủy hay Non Nước?', 'Chọn khu căn hộ ven biển Đà Nẵng', [('Mỹ Khê', 'sôi động, cho thuê tốt'), ('Sơn Thủy', 'công viên biển 2,45 ha'), ('Non Nước', 'yên tĩnh, gần resort'), ('Sun Saphia', '30 tầng, khu Sơn Thủy')]),
 ('mua-can-ho-da-nang-tu-xa', 'KINH NGHIỆM MUA NHÀ', 'Mua căn hộ Đà Nẵng từ xa', 'Cho khách ở Hà Nội, TP.HCM, nước ngoài', [('Video', 'xem căn trực tiếp'), ('Giấy tờ', 'kiểm tra từ xa'), ('Ủy quyền', 'công chứng ký thay'), ('5 bước', 'mua an toàn')]),
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
