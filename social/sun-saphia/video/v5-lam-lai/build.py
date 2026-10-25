"""Làm lại video v5 theo nghiên cứu video mẫu: giọng đọc 60s, nhịp khớp lời, phụ đề chữ to, tiếng hiệu ứng,
chữ ký + hotline mới (chỉ "Hoàng Hiệp"), che chữ ký cũ, thẻ cuối kêu gọi bình luận.
Chạy: python3 build.py  (trong thư mục v5-lam-lai)"""
import os, sys, subprocess, math
from PIL import Image, ImageDraw, ImageFilter
HERE = os.path.dirname(os.path.abspath(__file__)); os.chdir(HERE)
sys.path.insert(0, os.path.dirname(HERE))
import render as R
W, H, FPS, DUR = 1080, 1920, 30, 60.0
N = int(DUR * FPS)
NAVY = R.NAVY; OR = (255, 140, 40); WH = (255, 255, 255)
import json
TC = json.load(open("thoi-gian-cau.json"))          # [đầu, cuối] của 17 câu đọc (giây)
def S(i): return TC[i - 1][0]
def E(i): return TC[i - 1][1]
# Mỗi cảnh bắt đầu đúng lúc câu tương ứng bắt đầu
T_TITLE, T_MAP, T_FRONT, T_RES, T_CONN = S(2), S(3), S(5), S(6), S(8)
CLIPS = json.load(open("clips.json"))   # cảnh từ phim chủ đầu tư: [tên, từ, đến]
T_TOWER, T_PLAN, T_POOL, T_STREET, T_KICK, T_END = S(11), S(12), S(13), S(14), S(15), S(16)

# 1) Cắt + đổi tốc độ các đoạn của v5 cho khớp lời đọc: (đầu ra từ, đến, nguồn từ, đến)
SEG = [(0.0, T_TITLE, 51.0, 52.6), (T_TITLE, T_MAP, 2.5, 4.0), (T_MAP, T_FRONT, 4.5, 13.6), (T_FRONT, T_RES, 13.6, 16.5),
       (T_RES, T_CONN, 17.0, 24.2), (T_CONN, T_TOWER, 27.3, 37.3), (T_TOWER, DUR, 38.0, 59.9)]
def base():
    if os.path.exists("base.mp4"): return
    parts, ins = [], []
    for i, (a, b, s, e) in enumerate(SEG):
        n = round((b - a) * FPS); f = (b - a) / (e - s)
        parts.append(f"[0:v]trim={s}:{e},setpts=(PTS-STARTPTS)*{f:.5f},fps={FPS},trim=end_frame={n},setpts=PTS-STARTPTS[v{i}]")
        ins.append(f"[v{i}]")
    fc = ";".join(parts) + ";" + "".join(ins) + f"concat=n={len(SEG)}:v=1:a=0[v]"
    subprocess.run(["ffmpeg", "-v", "error", "-y", "-i", "v5-goc.mp4", "-filter_complex", fc, "-map", "[v]",
                    "-c:v", "libx264", "-preset", "veryfast", "-crf", "14", "base.mp4"], check=True)

# 2) Phụ đề: (từ, đến, các dòng, vị trí y). Chữ trong *...* tô cam.
C, T = 1060, 330   # giữa màn hình / phía trên (khi có bảng số liệu)
def _split(i, w):            # chia câu i theo tỉ lệ số chữ → thời điểm từng ý
    a, b = S(i), E(i); tot = sum(w); out = [a]
    for x in w[:-1]: out.append(out[-1] + (b - a) * x / tot)
    return out
_r = _split(6, [len(x) for x in ["Xung quanh là Furama,", "Crowne Plaza,", "Hyatt Regency,", "Marriott."]])
CAP = [
    (S(1), E(1) + 0.15, ["Lần đầu tiên *Sun Group*", "làm căn hộ *ngay mặt biển*"], C),
    (S(2), E(2) + 0.2, ["Nằm ở *đâu?*"], C),
    (S(3), E(3) + 0.15, ["Giao lộ *Võ Nguyên Giáp*", "Trường Sa · Ngũ Hành Sơn"], C),
    (S(4), E(4) + 0.15, ["Đi bộ *~400 m*", "ra bãi tắm Sơn Thủy"], C),
    (S(5), E(5) + 0.15, ["Công viên biển *2,45 ha*", "ngay trước dự án"], C),
    (_r[0], _r[1], ["Xung quanh: *Furama*"], C),
    (_r[1], _r[2], ["Furama · *Crowne Plaza*"], C),
    (_r[2], _r[3], ["Furama · Crowne Plaza", "*Hyatt Regency*"], C),
    (_r[3], S(7), ["Furama · Crowne Plaza", "Hyatt Regency · *Marriott*"], C),
    (S(7), E(7) + 0.15, ["Chuỗi resort *5 sao*", "biển Đà Nẵng"], C),
    (S(8), E(8) + 0.15, ["Ra sân bay *15 phút*"], C),
    (S(9), E(9) + 0.15, ["Phố cổ Hội An *30 phút*"], C),
    (S(10), E(10) + 0.15, ["Ga đường sắt đô thị", "cách dự án *~500 m*"], C),
    (S(11), E(11) + 0.15, ["*30 tầng* · cao *114 m*"], T),
    (S(12), E(12) + 0.15, ["*782 căn*", "Studio · 1PN+ · 2PN"], T),
    (S(13), E(13) + 0.15, ["Trần cao *3,5 m*", "Hồ bơi tầng 3 *view biển*"], C),
    (S(14), E(14) + 0.15, ["Giấy CN đầu tư *đã cấp*", "Thời hạn *50 năm*"], C),
    (S(15), E(15) + 0.15, ["Mở bán *cuối 11/2026*", "Bàn giao *11/2028*"], C),
]
FC = R.font("xb", 66)
def parts(line):
    out, on = [], False
    for i, p in enumerate(line.split("*")):
        if p: out.append((p, OR if i % 2 else WH))
    return out
_cap_cache = {}
def cap_img(lines):
    k = tuple(lines)
    if k in _cap_cache: return _cap_cache[k]
    d0 = ImageDraw.Draw(Image.new("RGBA", (1, 1)))
    ws = [sum(d0.textlength(t, font=FC) for t, _ in parts(l)) for l in lines]
    bw, lh = int(max(ws)) + 90, 84; bh = lh * len(lines) + 46
    im = Image.new("RGBA", (bw, bh), (0, 0, 0, 0)); d = ImageDraw.Draw(im)
    d.rounded_rectangle((0, 0, bw - 1, bh - 1), radius=30, fill=(8, 20, 44, 215), outline=(255, 140, 40, 150), width=3)
    y = 23
    for l, w in zip(lines, ws):
        x = (bw - w) / 2
        for t, c in parts(l):
            d.text((x, y + lh / 2), t, font=FC, fill=c, anchor="lm", stroke_width=2, stroke_fill=(0, 8, 24)); x += d.textlength(t, font=FC)
        y += lh
    _cap_cache[k] = im; return im
def ease(x): return 1 - (1 - max(0, min(1, x))) ** 3

# 3) Lớp cố định
def bottom_mask():
    g = Image.new("RGBA", (W, H), (0, 0, 0, 0)); d = ImageDraw.Draw(g)
    for y in range(1480, H):
        a = min(255, int(255 * (y - 1480) / 70)); d.line((0, y, W, y), fill=(9, 19, 42, a))
    d.text((W - 24, H - 26), "Dữ liệu bản đồ © OpenStreetMap contributors, Overture Maps", font=R.font("m", 20), fill=(150, 165, 190), anchor="rm")
    return g
def hotline(y0=1462):
    o = Image.new("RGBA", (W, H), (0, 0, 0, 0)); full = R.brand_layer()
    band = full.crop((0, 1742, W, 1832)); o.alpha_composite(band, (0, y0 - 10)); return o
MASK, PILL = bottom_mask(), hotline()

def hero_frame(t):
    if not hasattr(hero_frame, "im"):
        im = Image.open("phoi-canh-bien.jpg").convert("RGB"); hero_frame.im = im
    im = hero_frame.im; k = ease(t / 1.6); s = 1.22 - 0.22 * k      # zoom ra để lộ toàn cảnh
    ch = im.height / s; cw = ch * W / H; cx = 748 - 30 * k; cy = im.height / 2
    fr = im.resize((W, H), Image.LANCZOS, box=(cx - cw / 2, cy - ch / 2, cx + cw / 2, cy + ch / 2)).convert("RGBA")
    return fr

def hero_fit(t0, t):
    if not hasattr(hero_fit, "bg"):
        R.background("phoi-canh-bien.jpg", "hero-fit.jpg"); hero_fit.bg = Image.open("hero-fit.jpg")
    bg = hero_fit.bg; k = (t - t0) / 4.64; s = 1.0 + 0.07 * k
    cw, ch = bg.width / 1.25 / s, bg.height / 1.25 / s
    cx, cy = bg.width / 2, bg.height / 2
    return bg.resize((W, H), Image.LANCZOS, box=(cx - cw / 2, cy - ch / 2, cx + cw / 2, cy + ch / 2)).convert("RGBA")

def img_fit(path, t0, dur, t, zoom=0.07):
    key = "bg_" + path
    if not hasattr(img_fit, key):
        out = path.rsplit(".", 1)[0] + "-fit.jpg"; R.background(path, out); setattr(img_fit, key, Image.open(out))
    bg = getattr(img_fit, key); k = (t - t0) / dur; s = 1.0 + zoom * k
    cw, ch = bg.width / 1.25 / s, bg.height / 1.25 / s
    cx, cy = bg.width / 2, bg.height / 2
    return bg.resize((W, H), Image.LANCZOS, box=(cx - cw / 2, cy - ch / 2, cx + cw / 2, cy + ch / 2)).convert("RGBA")

STATS = [("30", "TẦNG", "Cao 114 m · 2 tầng hầm"), ("782", "CĂN HỘ", "Studio · 1PN+ · 2PN"),
         ("3.720", "M² ĐẤT", "Góc Võ Nguyên Giáp – N.Đ.Thuận"), ("11/2028", "BÀN GIAO", "Dự kiến")]
def stats(fr, dt):
    d = ImageDraw.Draw(fr)
    for i, (big, lab, sub) in enumerate(STATS):
        e = ease((dt - 0.15 - 0.28 * i) / 0.3)
        if e <= 0: continue
        x0 = 70 + (i % 2) * 480; y0 = 1180 + (i // 2) * 200 + int(30 * (1 - e))
        box = Image.new("RGBA", (460, 180), (0, 0, 0, 0)); b = ImageDraw.Draw(box)
        b.rounded_rectangle((0, 0, 459, 179), radius=24, fill=(8, 20, 44, 225), outline=(255, 140, 40, 170), width=3)
        b.text((28, 18), big, font=R.font("xb", 72), fill=OR); b.text((30, 104), lab, font=R.font("b", 30), fill=WH)
        b.text((30, 142), sub, font=R.font("m", 22), fill=(200, 212, 232))
        box.putalpha(box.getchannel("A").point(lambda v: int(v * e)))
        fr.alpha_composite(box, (x0, y0))

def pool_frame(t0, t):
    if not hasattr(pool_frame, "bg"):
        R.background("../../anh-page-2810/ho-boi-hoang-hon.jpg", "pool-bg.jpg"); pool_frame.bg = Image.open("pool-bg.jpg")
    bg = pool_frame.bg; k = (t - t0) / 3.1; s = 1.0 + 0.06 * k
    cw, ch = bg.width / 1.25 / s * 1.25 / 1.25, bg.height / 1.25 / s
    cx, cy = bg.width / 2, bg.height / 2
    return bg.resize((W, H), Image.LANCZOS, box=(cx - cw / 2, cy - ch / 2, cx + cw / 2, cy + ch / 2)).convert("RGBA")

def end_frame(t0, t, src):
    if not hasattr(end_frame, "bg"):
        im = Image.open("phoi-canh-bien.jpg").convert("RGB"); ch = im.height; cw = ch * W / H
        b = im.resize((W, H), Image.LANCZOS, box=(748 - cw / 2, 0, 748 + cw / 2, ch)).filter(ImageFilter.GaussianBlur(14)); end_frame.bg = Image.blend(b, Image.new("RGB", b.size, NAVY), 0.62).convert("RGBA")
    fr = end_frame.bg.copy(); d = ImageDraw.Draw(fr); dt = t - t0
    title = "SUN SAPHIA RESIDENCE"; ft = R.font("xb", 50)
    tw = sum(d.textlength(ch, font=ft) for ch in title) + 6 * (len(title) - 1); x = W / 2 - tw / 2
    for i, ch in enumerate(title):
        e = ease((dt - 0.03 * i) / 0.35)
        if e > 0:
            layer = Image.new("RGBA", (80, 90), (0, 0, 0, 0)); ImageDraw.Draw(layer).text((40, 45), ch, font=ft, fill=WH, anchor="mm")
            layer.putalpha(layer.getchannel("A").point(lambda v: int(v * e)))
            fr.alpha_composite(layer, (int(x + d.textlength(ch, font=ft) / 2 - 40), int(300 - 45 + 26 * (1 - e))))
        x += d.textlength(ch, font=ft) + 6
    d.text((W / 2, 372), "Căn hộ mặt biển đầu tiên của Sun Group tại Đà Nẵng", font=R.font("m", 32), fill=(205, 215, 235), anchor="mm")
    if t >= S(16):
        e = ease((t - S(16)) / 0.35); f1 = R.font("xb", int(70 + 10 * e))
        d.text((W / 2, 610), "Bình luận chữ", font=R.font("b", 62), fill=WH, anchor="mm")
        d.text((W / 2, 760), "“GIÁ”", font=R.font("xb", int(150 * (0.7 + 0.3 * e))), fill=OR, anchor="mm")
    if t >= S(17):
        d.text((W / 2, 900), "Nhận bảng giá gốc qua Zalo", font=R.font("sb", 46), fill=WH, anchor="mm")
        d.text((W / 2, 960), "ngay khi chủ đầu tư công bố", font=R.font("m", 36), fill=(205, 215, 235), anchor="mm")
    pe = ease((dt - 0.4) / 0.4); pw = int((W - 300) * (0.6 + 0.4 * pe)) // 2
    if pe > 0:
        glow = Image.new("RGBA", (W, H), (0, 0, 0, 0)); ImageDraw.Draw(glow).rounded_rectangle((W / 2 - pw - 18, 1022, W / 2 + pw + 18, 1198), radius=88, fill=(255, 140, 40, int(110 * pe)))
        fr.alpha_composite(glow.filter(ImageFilter.GaussianBlur(22)))
        d.rounded_rectangle((W / 2 - pw, 1040, W / 2 + pw, 1180), radius=70, fill=OR)
        d.text((W / 2, 1112), "0904 567 009", font=R.font("xb", int(84 * (0.8 + 0.2 * pe))), fill=WH, anchor="mm")
        ph = ((dt - 1.0) % 1.8) / 0.7                         # vệt sáng lướt qua ô hotline
        if dt > 1.0 and ph < 1:
            sw = Image.new("RGBA", (W, H), (0, 0, 0, 0)); sx = W / 2 - pw - 120 + (2 * pw + 240) * ph
            ImageDraw.Draw(sw).polygon([(sx, 1040), (sx + 60, 1040), (sx + 10, 1180), (sx - 50, 1180)], fill=(255, 255, 255, 120))
            m = Image.new("L", (W, H), 0); ImageDraw.Draw(m).rounded_rectangle((W / 2 - pw, 1040, W / 2 + pw, 1180), radius=70, fill=255)
            sw.putalpha(Image.composite(sw.getchannel("A"), Image.new("L", (W, H), 0), m)); fr.alpha_composite(sw.filter(ImageFilter.GaussianBlur(3)))
    d.text((W / 2, 1220), "Zalo · Hotline · Hoàng Hiệp", font=R.font("sb", 32), fill=(255, 200, 140), anchor="mm")
    idx, a = R.sig_state(int(dt * FPS), [6], 1.0)
    R.draw_sig(fr, idx, a, w=520, cx=540, bottom=1600)
    d.text((W / 2, 1700), "sun-saphia-residence.com", font=R.font("m", 32), fill=(190, 202, 225), anchor="mm")
    return fr

def main():
    base()
    dec = subprocess.Popen(["ffmpeg", "-v", "error", "-i", "base.mp4", "-f", "rawvideo", "-pix_fmt", "rgb24", "-"], stdout=subprocess.PIPE)
    enc = subprocess.Popen(["ffmpeg", "-v", "error", "-y", "-f", "rawvideo", "-pix_fmt", "rgb24", "-s", f"{W}x{H}", "-r", str(FPS), "-i", "-",
                            "-c:v", "libx264", "-preset", "medium", "-crf", "18", "-pix_fmt", "yuv420p", "hinh.mp4"], stdin=subprocess.PIPE)
    writes = [int(0.3 * FPS), int(T_RES * FPS), int(T_POOL * FPS)]
    last = None; readers = {}
    for f in range(N):
        raw = dec.stdout.read(W * H * 3)
        if len(raw) < W * H * 3: raw = last
        last = raw; t = f / FPS
        src = Image.frombytes("RGB", (W, H), raw)
        clip = next((c for c in CLIPS if c[1] <= t < c[2]), None)
        if clip:
            name = clip[0]
            if name not in readers:
                readers[name] = [subprocess.Popen(["ffmpeg", "-v", "error", "-i", name + ".mp4", "-f", "rawvideo", "-pix_fmt", "rgb24", "-"], stdout=subprocess.PIPE, stderr=subprocess.DEVNULL), None]
            r2 = readers[name][0].stdout.read(W * H * 3)
            if len(r2) == W * H * 3: readers[name][1] = r2
            fr = Image.frombytes("RGB", (W, H), readers[name][1]).convert("RGBA")
        elif T_TOWER <= t < T_PLAN: fr = img_fit("slide-thap-ho-boi.jpg", T_TOWER, T_PLAN - T_TOWER, t, 0.10)
        elif T_PLAN <= t < T_POOL: fr = img_fit("slide-mat-bang.jpg", T_PLAN, T_POOL - T_PLAN, t, 0.06); stats(fr, t - T_PLAN)
        elif T_POOL <= t < T_STREET: fr = img_fit("slide-ho-boi.jpg", T_POOL, T_STREET - T_POOL, t, 0.07)
        elif T_STREET <= t < T_KICK: fr = img_fit("pho-truoc-toa.jpg", T_STREET, T_KICK - T_STREET, t)
        elif T_KICK <= t < T_END: fr = img_fit("thap-kickoff.jpg", T_KICK, T_END - T_KICK, t)
        elif t >= T_END: fr = end_frame(T_END, t, src)
        else: fr = src.convert("RGBA")
        if t < T_END:
            if T_TITLE <= t < T_TOWER and not clip: fr.alpha_composite(MASK)
            show_brand = not (T_TOWER <= t < T_POOL)
            if show_brand:
                idx, a = R.sig_state(f, writes, 1.0)
                R.draw_sig(fr, idx, a, w=300, cx=540, bottom=1455)
                fr.alpha_composite(PILL)
            for a0, b0, lines, y in CAP:
                if a0 <= t < b0:
                    im = cap_img(lines); e = ease((t - a0) / 0.22); out = min(1, (b0 - t) / 0.12)
                    s = 0.86 + 0.14 * e
                    im2 = im.resize((max(1, int(im.width * s)), max(1, int(im.height * s))), Image.LANCZOS)
                    if e * out < 1: im2.putalpha(im2.getchannel("A").point(lambda v: int(v * e * out)))
                    fr.alpha_composite(im2, (int(W / 2 - im2.width / 2), int(y - im2.height / 2)))
        enc.stdin.write(fr.convert("RGB").tobytes())
    enc.stdin.close(); enc.wait(); dec.terminate()
    for r in readers.values(): r[0].kill()

    # 4) Âm thanh: giọng đọc + nhạc nền (tự nhỏ khi có lời) + tiếng hiệu ứng
    SFX = [("impact", 0.0), ("whoosh", T_TITLE - 0.2), ("whoosh", T_MAP - 0.2), ("blip", S(4)), ("whoosh", T_FRONT - 0.2),
           ("whoosh", T_RES - 0.2)] + [("blip", x) for x in _r] + [
           ("whoosh", T_CONN - 0.2), ("blip", S(8)), ("blip", S(9)), ("blip", S(10)), ("whoosh", T_TOWER - 0.25), ("impact", T_TOWER),
           ("whoosh", T_PLAN - 0.2)] + [("blip", T_PLAN + 0.15 + 0.28 * i) for i in range(4)] + [
           ("whoosh", T_POOL - 0.2), ("whoosh", T_STREET - 0.2), ("whoosh", T_KICK - 0.2), ("whoosh", T_END - 0.2), ("impact", S(16)), ("blip", S(17))]
    ins = ["-i", "giong-doc.wav", "-i", "../assets/nhac-nen.m4a"]
    fc = ["[2:a]volume=0.55,afade=t=out:st=57.5:d=2.5[m]", "[1:a]asplit=2[vo][sc]", "[m][sc]sidechaincompress=threshold=0.03:ratio=8:attack=20:release=400[md]"]
    mix = ["[vo]", "[md]"]
    for i, (n, t) in enumerate(SFX):
        ins += ["-i", f"sfx/{n}.wav"]; vol = {"impact": 0.9, "whoosh": 0.55, "blip": 0.35, "riser": 0.5}[n]
        fc.append(f"[{i + 3}:a]adelay={int(t * 1000)}|{int(t * 1000)},volume={vol}[s{i}]"); mix.append(f"[s{i}]")
    fc.append("".join(mix) + f"amix=inputs={len(mix)}:normalize=0:duration=first,alimiter=limit=0.95[a]")
    subprocess.run(["ffmpeg", "-v", "error", "-y", "-i", "hinh.mp4"] + ins + ["-filter_complex", ";".join(fc),
                    "-map", "0:v", "-map", "[a]", "-c:v", "copy", "-c:a", "aac", "-b:a", "192k", "-t", str(DUR), "-movflags", "+faststart",
                    "sun-saphia-v5-lam-lai.mp4"], check=True)

if __name__ == "__main__": main()
