"""Ảnh đại diện loạt bài Sun Saphia đợt 9 (16/11 – 18/11/2026): đồ hoạ tự vẽ nền navy + nhãn liên hệ (scripts/dong-dau-anh.py)."""
import sys, math, importlib.util
from PIL import Image, ImageDraw, ImageFont
O = sys.argv[1]
spec = importlib.util.spec_from_file_location('dd', __file__.rsplit('/', 2)[0] + '/scripts/dong-dau-anh.py'); dd = importlib.util.module_from_spec(spec); spec.loader.exec_module(dd)
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'; FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
NAVY = (11, 26, 42); GOLD = '#e8b04a'; W, H = 1200, 675
CARDS = [
 ('khu-thuong-mai-tu-do-sun-saphia', 'THỊ TRƯỜNG · HẠ TẦNG', 'Khu thương mại tự do Đà Nẵng', 'Tiến độ 2026 và tác động tới căn hộ ven biển', [('~1.881 ha', 'quy hoạch tổng thể FTZ'), ('> 15.000 tỷ', '3 doanh nghiệp đăng ký (báo chí)'), ('Vị trí 7', 'có nhà đầu tư 12/11/2026'), ('Gián tiếp', 'khách thuê công tác theo tháng')]),
 ('nhan-ban-giao-sun-saphia', 'KINH NGHIỆM · BÀN GIAO', 'Nhận bàn giao: kiểm tra gì?', 'Sun Saphia Residence – bàn giao liền tường trừ bếp', [('11/2028', 'bàn giao dự kiến'), ('8 hạng mục', 'trần, tường, sàn, cửa, điện, nước...'), ('1 – 2 giờ', 'nên dành để kiểm tra'), ('Biên bản', 'ghi vị trí, ảnh, hạn sửa')]),
 ('lam-viec-tu-xa-sun-saphia', 'CHO THUÊ · LÀM VIỆC TỪ XA', 'Khách làm việc từ xa thuê theo tháng', 'Đà Nẵng hút cộng đồng digital nomad', [('90 ngày', 'e-visa tối đa'), ('1 – 3 tháng', 'thời gian thuê phổ biến'), ('70 – 100 USD', 'coworking/tháng (ước tính)'), ('1PN+', 'phòng phụ làm phòng làm việc')]),
 ('mua-phao-hoa-diff-sun-saphia', 'CHO THUÊ · MÙA LỄ HỘI', 'Mùa pháo hoa DIFF 2026', '30/5 – 11/7/2026 – số liệu Sở VHTTDL và báo chí', [('~2,7 triệu', 'lượt khách lưu trú'), ('+ gần 45%', 'so với kỳ trước'), ('65 – 70%', 'công suất toàn thành phố'), ('95 – 100%', 'trung tâm vào đêm thi')]),
 ('san-golf-gan-sun-saphia', 'VỊ TRÍ · DU LỊCH GOLF', 'Sân golf gần dự án', 'Trục ven biển Võ Nguyên Giáp – Trường Sa – Lạc Long Quân', [('3 sân', 'ven biển phía Nam'), ('Trường Sa', 'cùng trục đường với BRG'), ('Thu – đông', 'mùa khách golf'), ('3 – 5 đêm', 'nhóm 2 – 4 người')]),
 ('bao-hiem-can-ho-sun-saphia', 'KINH NGHIỆM · BẢO HIỂM', 'Bảo hiểm căn hộ cho thuê', 'Cháy nổ bắt buộc, tài sản bên trong, trách nhiệm', [('Từ 5 tầng', 'phải mua cháy nổ bắt buộc'), ('105/2025', 'nghị định sửa đổi, từ 01/07/2025'), ('Nội thất', 'nên mua thêm gói riêng'), ('Bên thứ ba', 'trách nhiệm khi nước tràn')]),
 ('an-uong-quanh-sun-saphia', 'VỊ TRÍ · ẨM THỰC', 'Ăn uống quanh dự án', 'Sơn Thủy – Mỹ An – trung tâm Đà Nẵng', [('Hải sản', 'ven biển Trường Sa'), ('An Thượng', 'phố ẩm thực quốc tế'), ('Chợ', 'Bắc Mỹ An, Chợ Hàn, Chợ Cồn'), ('Chưa có bếp', 'căn bàn giao trừ tủ bếp')]),
 ('ban-lai-sun-saphia-sau-so', 'PHÁP LÝ · BÁN LẠI', 'Bán lại sau khi có sổ', 'Ví dụ studio giá tham khảo 3 tỷ', [('2%', 'thuế TNCN – 60 triệu'), ('0,5%', 'lệ phí trước bạ – 15 triệu'), ('~2,5%', 'tổng chi phí giao dịch'), ('50 năm', 'người mua nhận thời hạn còn lại')]),
 ('nghi-huu-sun-saphia', 'KINH NGHIỆM · NGHỈ HƯU', 'Sống ven biển khi nghỉ hưu', 'Ở theo mùa, cho thuê phần còn lại', [('2,45 ha', 'công viên biển trước mặt'), ('7 thang', 'máy cho tòa 30 tầng'), ('Tạm trú', 'đăng ký được (theo chủ đầu tư)'), ('750k – 1 tr', 'phí quản lý căn 50 m²/tháng')]),
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
