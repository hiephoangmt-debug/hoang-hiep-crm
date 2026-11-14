"""Reels 9:16 từ flycam thực tế khu vực (quay 17/10/2026).
Dùng: python3 dung.py <thư-mục-clip> <nhạc> <file-ra.mp4> [su-kien|chung]"""
import sys, os, subprocess, tempfile
from PIL import Image, ImageDraw, ImageFont

SRC, MUSIC, OUT = sys.argv[1:4]
MODE = sys.argv[4] if len(sys.argv) > 4 else 'su-kien'
W, H, FPS, XF = 1080, 1920, 30, 0.35
F = '/usr/share/fonts/opentype/inter/'
def font(n, s): return ImageFont.truetype(F + n, s)
OR, WH = (255, 154, 69), (255, 255, 255)

# (clip, giây bắt đầu, độ dài, tâm cắt ngang 0..1 cho clip quay ngang)
SEG = [('0056', 1.5, 4.3, None), ('0005', 1.0, 5.0, .36), ('0007', 3.0, 5.0, .62), ('0050', 2.0, 4.6, None),
       ('0030', 4.0, 4.6, .58), ('0052', 1.0, 4.0, None), ('0026', 5.0, 5.0, .52), ('0060', 2.0, 9.5, None)]

B, R, SB, XB = 'InterDisplay-Black.otf', 'InterDisplay-Bold.otf', 'Inter-SemiBold.otf', 'Inter-ExtraBold.otf'
TXT = [  # (bắt đầu, kết thúc, vị trí, dòng)
    (0.3, 4.0, 'top', [('CĂN HỘ MẶT BIỂN ĐÀ NẴNG', WH, B, 76), ('Sun Saphia Residence · Sun Group', OR, XB, 50)]),
    (4.4, 8.9, 'bottom', [('Ra biển chỉ', WH, R, 60), ('HƠN 300 M', OR, B, 132), ('bãi tắm Sơn Thủy – Mỹ Khê', WH, SB, 48)]),
    (9.2, 13.7, 'top', [('Mặt tiền trục biển', WH, R, 56), ('Võ Nguyên Giáp – Trường Sa', OR, B, 70)]),
    (14.0, 18.3, 'bottom', [('Hạ tầng ven biển liên tục được đầu tư', WH, R, 50), ('Công viên & câu lạc bộ thể thao biển Sơn Thủy', OR, XB, 40)]),
    (18.6, 22.9, 'top', [('Giữa dải resort cao cấp', WH, B, 66), ('ven biển Ngũ Hành Sơn', OR, XB, 48)]),
    (23.2, 26.9, 'bottom', [('Kề danh thắng', WH, R, 56), ('NGŨ HÀNH SƠN', OR, B, 96)]),
    (27.2, 31.6, 'top', [('Khu vực đang chuyển mình từng ngày', WH, R, 54), ('Hình ảnh thực tế · quay tháng 10/2026', OR, XB, 40)]),
    (32.0, 99, 'cta', None),
]

def shade(lay, where, h):
    d = ImageDraw.Draw(lay)
    for y in range(h):
        k = y / (h - 1); a = int(190 * ((1 - k) if where == 'top' else k) ** 1.5)
        yy = y if where == 'top' else H - h + y
        d.line([(0, yy), (W, yy)], fill=(6, 18, 34, a))

def block(lines, where):
    lay = Image.new('RGBA', (W, H), (0, 0, 0, 0)); shade(lay, where, 620)
    d = ImageDraw.Draw(lay); hs = []
    for t, c, fn, sz in lines:
        f = font(fn, sz)
        while d.textlength(t, font=f) > W - 110: sz -= 2; f = font(fn, sz)
        hs.append((t, c, f, sz))
    total = sum(int(s * 1.22) for *_, s in hs)
    y = 170 if where == 'top' else H - 430 - total
    for t, c, f, sz in hs:
        d.text((W // 2 + 3, y + 3), t, font=f, fill=(0, 0, 0, 150), anchor='ma')
        d.text((W // 2, y), t, font=f, fill=c + (255,), anchor='ma'); y += int(sz * 1.22)
    return lay

def cta():
    lay = Image.new('RGBA', (W, H), (0, 0, 0, 0)); shade(lay, 'bottom', 1250); d = ImageDraw.Draw(lay)
    y = 760
    if MODE == 'su-kien':
        rows = [('🎁', None), ('THƯ MỜI SỰ KIỆN', OR, XB, 46), ('9:00 · Chủ nhật 15/11', WH, B, 84),
                ('Sun Gallery Đà Nẵng', WH, R, 58), ('01 Phan Đăng Lưu, Hoà Cường', WH, SB, 42),
                ('Bốc thăm quà Sharp · Philips · Sony', OR, XB, 42)]
    else:
        rows = [('🎁', None), ('SUN SAPHIA RESIDENCE', OR, XB, 46), ('Nhận bảng giá', WH, B, 88),
                ('& danh sách căn view biển', WH, R, 54), ('còn trống theo tầng', WH, SB, 44), ('Tư vấn miễn phí', OR, XB, 42)]
    for r in rows[1:]:
        t, c, fn, sz = r; f = font(fn, sz)
        d.text((W // 2 + 3, y + 3), t, font=f, fill=(0, 0, 0, 160), anchor='ma'); d.text((W // 2, y), t, font=f, fill=c + (255,), anchor='ma')
        y += int(sz * 1.35)
    bw, bh, by = 820, 132, y + 40; bx = (W - bw) // 2
    d.rounded_rectangle((bx - 10, by - 10, bx + bw + 10, by + bh + 10), 76, fill=(255, 154, 69, 80))
    d.rounded_rectangle((bx, by, bx + bw, by + bh), 66, fill=(242, 107, 29, 255))
    d.text((W // 2, by + bh // 2), ('Giữ thư mời · Zalo 0904 567 009' if MODE == 'su-kien' else 'Nhắn Zalo 0904 567 009'),
           font=font(B, 50), fill=WH + (255,), anchor='mm')
    return lay

tmp = tempfile.mkdtemp()
# 1) cắt + đưa về 1080x1920
parts = []
for i, (n, ss, du, cx) in enumerate(SEG):
    src = os.path.join(SRC, n + '.mp4'); o = os.path.join(tmp, 's%d.mp4' % i)
    if cx is None: vf = 'scale=%d:%d:force_original_aspect_ratio=increase,crop=%d:%d' % (W, H, W, H)
    else: vf = 'crop=ih*9/16:ih:(iw-ih*9/16)*%.3f:0,scale=%d:%d' % (cx, W, H)
    vf += ',fps=%d,eq=saturation=1.08:contrast=1.04,format=yuv420p' % FPS
    subprocess.run(['ffmpeg', '-y', '-v', 'error', '-ss', str(ss), '-t', str(du), '-i', src, '-vf', vf, '-an',
                    '-c:v', 'libx264', '-preset', 'veryfast', '-crf', '16', o], check=True)
    parts.append((o, du))
# 2) nối có chuyển cảnh mờ
args, fc, off, last = [], '', 0.0, '0:v'
for o, _ in parts: args += ['-i', o]
for i in range(1, len(parts)):
    off += parts[i - 1][1] - XF; lab = 'x%d' % i
    fc += '[%s][%d:v]xfade=transition=fade:duration=%.2f:offset=%.2f[%s];' % (last, i, XF, off, lab); last = lab
TOTAL = off + parts[-1][1]
base = os.path.join(tmp, 'base.mp4')
subprocess.run(['ffmpeg', '-y', '-v', 'error'] + args + ['-filter_complex', fc.rstrip(';'), '-map', '[%s]' % last,
                '-c:v', 'libx264', '-preset', 'veryfast', '-crf', '16', base], check=True)
# 3) chữ
args, fc, last = ['-i', base], '', '0:v'
for i, (t0, t1, kind, lines) in enumerate(TXT):
    p = os.path.join(tmp, 't%d.png' % i); (cta() if kind == 'cta' else block(lines, kind)).save(p)
    t1 = min(t1, TOTAL); du = t1 - t0
    args += ['-loop', '1', '-t', '%.2f' % du, '-i', p]
    fo = '' if kind == 'cta' else ',fade=t=out:st=%.2f:d=0.3:alpha=1' % (du - 0.3)
    fc += '[%d:v]format=rgba,fade=t=in:st=0:d=0.35:alpha=1%s,setpts=PTS-STARTPTS+%.2f/TB[o%d];' % (i + 1, fo, t0, i)
    fc += '[%s][o%d]overlay=eof_action=pass:enable=\'between(t,%.2f,%.2f)\'[v%d];' % (last, i, t0, t1, i); last = 'v%d' % i
args += ['-i', MUSIC]
af = '[%d:a]atrim=0:%.2f,afade=t=in:d=1,afade=t=out:st=%.2f:d=2.2,volume=0.9[a]' % (len(TXT) + 1, TOTAL, TOTAL - 2.2)
subprocess.run(['ffmpeg', '-y', '-v', 'error'] + args + ['-filter_complex', fc + af, '-map', '[%s]' % last, '-map', '[a]',
                '-t', '%.2f' % TOTAL, '-c:v', 'libx264', '-preset', 'slow', '-crf', '20', '-pix_fmt', 'yuv420p',
                '-c:a', 'aac', '-b:a', '160k', '-movflags', '+faststart', OUT], check=True)
print(OUT, round(TOTAL, 2))
