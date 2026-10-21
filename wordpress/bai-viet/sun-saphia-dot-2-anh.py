"""Ảnh đại diện loạt bài Sun Saphia đợt 2 (22 – 29/10/2026): đồ hoạ tự vẽ nền navy + nhãn liên hệ (scripts/dong-dau-anh.py)."""
import sys, math, importlib.util
from PIL import Image, ImageDraw, ImageFont
O = sys.argv[1]
spec = importlib.util.spec_from_file_location('dd', __file__.rsplit('/', 2)[0] + '/scripts/dong-dau-anh.py'); dd = importlib.util.module_from_spec(spec); spec.loader.exec_module(dd)
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'; FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
NAVY = (11, 26, 42); GOLD = '#e8b04a'; W, H = 1200, 675
CARDS = [
 ('gia-sun-saphia-residence', 'GIÁ THAM KHẢO · 10/2026', 'Giá Sun Saphia Residence', 'Ước tính tổng tiền theo loại căn (từ giá tin rao)', [('64,5 – 83 tr', 'mỗi m² trên tin rao'), ('1,9 – 2,6 tỷ', 'studio 30 – 31 m²'), ('3,2 – 4,2 tỷ', '1PN+1 50 – 51 m²'), ('3,9 – 5,8 tỷ', '2PN 60 – 70 m²')]),
 ('mat-bang-sun-saphia-residence', 'MẶT BẰNG · LOẠI CĂN', 'Mặt bằng Sun Saphia Residence', '782 căn trong tòa 30 tầng – chọn căn theo mục đích', [('513', 'studio 30 – 31 m²'), ('108', 'căn 1PN+1 50 – 51 m²'), ('149', 'căn 2PN 60 – 70 m²'), ('~66%', 'là studio')]),
 ('vi-tri-sun-saphia-residence', 'VỊ TRÍ · NGŨ HÀNH SƠN', 'Sun Saphia Residence ở đâu?', 'Đường Trường Sa, bãi tắm Sơn Thủy', [('Trường Sa', 'mặt đường ven biển'), ('2,45 ha', 'công viên phía trước'), ('~4 km', 'tới Sun Galaxy, Downtown'), ('Sơn Thủy', 'giữa Mỹ Khê – Non Nước')]),
 ('phap-ly-sun-saphia-residence', 'PHÁP LÝ · KINH NGHIỆM', 'Pháp lý Sun Saphia Residence', 'Sở hữu bao lâu, giữ chỗ cần kiểm tra gì', [('50 năm?', 'chờ văn bản chính thức'), ('≤ 5%', 'đặt cọc khi đủ điều kiện'), ('Hoàn lại', 'ghi rõ trên phiếu giữ chỗ'), ('6 giấy tờ', 'cần hỏi chủ đầu tư')]),
 ('dau-tu-sun-saphia-residence', 'ĐẦU TƯ · GIẢ ĐỊNH MINH HOẠ', 'Đầu tư Sun Saphia cho thuê', '3 kịch bản dòng tiền một căn studio', [('2,2 tỷ', 'giá studio giả định'), ('3,5 – 5,5%', 'lợi suất ròng/năm'), ('77 – 121 tr', 'lợi nhuận/năm'), ('110 tr', 'lãi nếu vay 50%, 10%/năm')]),
 ('co-nen-mua-sun-saphia-residence', 'ĐÁNH GIÁ DỰ ÁN', 'Có nên mua Sun Saphia Residence?', 'Ưu điểm và điểm cần cân nhắc trước khi giữ chỗ', [('6', 'ưu điểm'), ('4', 'điểm cần cân nhắc'), ('Sát biển', 'khu Sơn Thủy'), ('11/2028', 'bàn giao dự kiến')]),
 ('tien-do-sun-saphia-residence', 'TIẾN ĐỘ · 10/2026', 'Tiến độ Sun Saphia Residence', 'Giữ chỗ – mở bán – xây dựng – bàn giao', [('Đang', 'nhận giữ chỗ'), ('Chưa', 'công bố bảng giá'), ('2025 – 2027', 'công viên Sơn Thủy'), ('11/2028', 'bàn giao dự kiến')]),
 ('sun-saphia-khac-khu-do-thi-saphia', 'PHÂN BIỆT DỰ ÁN', 'Sun Saphia hay KĐT Saphia?', 'Hai dự án khác nhau cùng ở Ngũ Hành Sơn', [('Căn hộ', 'Sun Saphia Residence'), ('Đất nền', 'Khu đô thị Saphia'), ('Sun Group', 'chủ đầu tư Sun Saphia'), ('30 tầng', '782 căn hộ')]),
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
