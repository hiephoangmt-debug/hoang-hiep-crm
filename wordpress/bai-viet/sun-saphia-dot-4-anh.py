"""Ảnh đại diện loạt bài Sun Saphia đợt 4 (06/11 – 12/11/2026): đồ hoạ tự vẽ nền navy + nhãn liên hệ (scripts/dong-dau-anh.py)."""
import sys, math, importlib.util
from PIL import Image, ImageDraw, ImageFont
O = sys.argv[1]
spec = importlib.util.spec_from_file_location('dd', __file__.rsplit('/', 2)[0] + '/scripts/dong-dau-anh.py'); dd = importlib.util.module_from_spec(spec); spec.loader.exec_module(dd)
F = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'; FB = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
f = lambda s, b=False: ImageFont.truetype(FB if b else F, s)
NAVY = (11, 26, 42); GOLD = '#e8b04a'; W, H = 1200, 675
CARDS = [
 ('thanh-toan-sun-saphia-residence', 'PHÁP LÝ · THANH TOÁN', 'Mua Sun Saphia Residence trả tiền thế nào?', 'Mốc thanh toán nhà ở hình thành trong tương lai – Luật KDBĐS 2023', [('≤ 5%', 'đặt cọc, khi dự án đủ điều kiện bán'), ('≤ 30%', 'thanh toán lần đầu (gồm cọc)'), ('≤ 70%', 'tổng tiền trước khi bàn giao'), ('≤ 95%', 'khi chưa có giấy chứng nhận')]),
 ('su-kien-ban-hang-sun-saphia-residence', 'KINH NGHIỆM · MỞ BÁN', 'Sự kiện bán hàng Sun Saphia Residence', 'Dự kiến 28/11/2026 – 7 việc nên chuẩn bị trước', [('3 căn', 'chọn sẵn theo thứ tự ưu tiên'), ('+ VAT + 2%', 'tính tổng tiền, không chỉ giá căn'), ('Hồ sơ vay', 'VietinBank, BIDV, NCB'), ('Giá trần', 'đặt mức tối đa cho mình')]),
 ('ho-tro-lai-suat-sun-saphia-residence', 'KINH NGHIỆM · VAY MUA', 'Hỗ trợ lãi suất 24 tháng', 'Ví dụ vay 1,5 tỷ mua Sun Saphia Residence – số liệu minh hoạ', [('~327 tr', 'lãi 24 tháng ở 10,9%/năm'), ('15,4 tr', 'trả góp/tháng nếu lãi 10,9%'), ('17,6 tr', 'trả góp/tháng nếu lãi 13%'), ('19,8 tr', 'trả góp/tháng nếu lãi 15%')]),
 ('tiet-kiem-hay-studio-sun-saphia', 'THỊ TRƯỜNG · SO SÁNH', 'Gửi tiết kiệm hay mua studio cho thuê?', 'Cùng khoảng 3,19 tỷ – lãi suất cuối 10/2026, minh hoạ', [('5,4 – 6,7%', 'tiết kiệm 12 tháng tại quầy'), ('172 – 214 tr', 'tiền lãi mỗi năm'), ('3,5 – 5,5%', 'lợi suất ròng cho thuê'), ('112 – 176 tr', 'thu nhập cho thuê mỗi năm')]),
 ('can-ho-ven-bien-hoi-muoi-sun-saphia', 'KINH NGHIỆM · CĂN HỘ BIỂN', 'Căn hộ ven biển: hơi muối và mùa bão', 'Chọn nội thất, kiểm tra khi nhận nhà, bảo trì định kỳ', [('Hơi muối', 'gỉ kim loại, dàn nóng'), ('Độ ẩm', 'thấm, mốc góc khuất'), ('Tháng 9 – 12', 'mùa mưa bão Đà Nẵng'), ('Gioăng cửa', 'kiểm tra trước mùa mưa')]),
 ('chuyen-nhuong-hop-dong-sun-saphia', 'PHÁP LÝ · BÁN LẠI', 'Bán lại trước khi nhận nhà', 'Chuyển nhượng hợp đồng mua bán Sun Saphia Residence', [('Hợp đồng', 'đã ký với chủ đầu tư'), ('Trước sổ', 'chưa nộp hồ sơ cấp giấy'), ('Xác nhận', 'chủ đầu tư ký văn bản'), ('2%', 'thuế TNCN trên giá chuyển nhượng')]),
 ('dai-bien-truong-sa-sun-saphia', 'THỊ TRƯỜNG · KHU VỰC', 'Dải biển Trường Sa – Ngũ Hành Sơn', 'Resort, khách sạn quốc tế và vị trí Sun Saphia Residence', [('Resort', 'nhiều thương hiệu quốc tế'), ('Sơn Thủy', 'bãi tắm, công viên ven biển'), ('500 m', 'tới ga LRT 09 (dự kiến)'), ('Dự án mới', 'nghỉ dưỡng giữa Fusion – Naman')]),
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
