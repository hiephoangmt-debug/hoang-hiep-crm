"""Dựng video dọc 1080x1920 từ ảnh + chữ + giọng đọc + nhạc nền.
Dùng: python3 render.py scenes.json out.mp4
scenes.json: {"voice": "voice.mp3", "music": "music.wav", "scenes": [{"img": "...", "tag": "...", "lines": ["..."], "dur": 4.5}, ...], "end": {"dur": 4}}
"""
import json, subprocess, sys, os, tempfile
from PIL import Image, ImageDraw, ImageFont, ImageFilter
W, H, FPS = 1080, 1920, 30
F = "/usr/share/fonts/opentype/inter/"
NAVY = (16, 36, 72); OR = (242, 112, 36); WH = (255, 255, 255); MUT = (200, 212, 232)
def font(w, s): return ImageFont.truetype(F + {"b": "Inter-Bold.otf", "xb": "Inter-ExtraBold.otf", "sb": "Inter-SemiBold.otf", "m": "Inter-Medium.otf"}[w], s)
def wrap(d, t, f, mw):
    out, line = [], ""
    for w in t.split():
        x = (line + " " + w).strip()
        if d.textlength(x, font=f) <= mw: line = x
        else: out.append(line); line = w
    out.append(line); return out

def background(img_path, out):
    """Ảnh nền 1.25x khung để zoom: ảnh dọc thì cắt đầy khung; ảnh ngang thì đặt giữa trên nền mờ."""
    S = 1.25; BW, BH = int(W * S), int(H * S)
    im = Image.open(img_path).convert("RGB")
    r = im.width / im.height
    if r < 0.9:
        sc = max(BW / im.width, BH / im.height); im2 = im.resize((int(im.width * sc), int(im.height * sc)), Image.LANCZOS)
        x, y = (im2.width - BW) // 2, (im2.height - BH) // 2; bg = im2.crop((x, y, x + BW, y + BH))
    else:
        sc = max(BW / im.width, BH / im.height); blur = im.resize((int(im.width * sc), int(im.height * sc))).filter(ImageFilter.GaussianBlur(40))
        x, y = (blur.width - BW) // 2, (blur.height - BH) // 2; bg = blur.crop((x, y, x + BW, y + BH))
        bg = Image.blend(bg, Image.new("RGB", bg.size, NAVY), 0.35)
        fw = BW; fh = int(fw / r); fg = im.resize((fw, fh), Image.LANCZOS)
        bg.paste(fg, (0, int(BH * 0.40) - fh // 2))
    bg.save(out, quality=92)

def overlay(tag, lines, out, big=False):
    o = Image.new("RGBA", (W, H), (0, 0, 0, 0)); d = ImageDraw.Draw(o)
    # thanh thương hiệu trên
    if lines:
        fl = font("xb", 76 if big else 64); P = 70
        wl = [l for t in lines for l in wrap(d, t, fl, W - 2 * P - 40)]
        lh = 92 if big else 80
        boxh = len(wl) * lh + 70 + (80 if tag else 0)
        y0 = int(H * (0.66 if not big else 0.63)) - boxh // 2
        d.rounded_rectangle((P - 20, y0, W - P + 20, y0 + boxh), radius=36, fill=NAVY + (225,))
        y = y0 + 35
        if tag:
            ft = font("b", 34); tw = d.textlength(tag, font=ft)
            d.rounded_rectangle((P + 10, y, P + 10 + tw + 44, y + 58), radius=29, fill=OR); d.text((P + 32, y + 11), tag, font=ft, fill=WH); y += 80
        for l in wl: d.text((P + 10, y), l, font=fl, fill=WH); y += lh
    o.save(out)

LOGO = os.path.join(os.path.dirname(os.path.abspath(__file__)), "assets", "logo-hoang-hiep.png")
BRAND = "Hoàng Hiệp Đà Nẵng"

def paste_logo(img, cx, cy, maxw, maxh):
    """Dán logo (nếu có file assets/logo-hoang-hiep.png), trả về True nếu đã dán."""
    if not os.path.exists(LOGO): return False
    lg = Image.open(LOGO).convert("RGBA"); lg.thumbnail((maxw, maxh), Image.LANCZOS)
    img.paste(lg, (int(cx - lg.width / 2), int(cy - lg.height / 2)), lg); return True

SIG_DIR = os.path.join(os.path.dirname(os.path.abspath(__file__)), "assets", "chu-ky")
_SIG = []
def sig_frames():
    """194 khung chữ ký tay Hoàng Hiệp (nền trong suốt, 330x231) – tách từ video Sun_Saphia_XayDung_HoangHiep_v3."""
    if not _SIG:
        n = len([f for f in os.listdir(SIG_DIR) if f.endswith(".png")])
        _SIG.extend(Image.open(f"{SIG_DIR}/s{i:03d}.png").convert("RGBA") for i in range(n))
    return _SIG

def spaced(d, xy, text, f, fill, spacing, anchor_center=True, **kw):
    w = sum(d.textlength(c, font=f) for c in text) + spacing * (len(text) - 1)
    x = xy[0] - w / 2 if anchor_center else xy[0]
    for c in text:
        d.text((x, xy[1]), c, font=f, fill=fill, anchor="lm", **kw); x += d.textlength(c, font=f) + spacing

def brand_layer():
    """Lớp cố định suốt video: thanh tên dự án, watermark chữ mờ, dải hotline Hoàng Hiệp (giống video Hành trình xây dựng)."""
    o = Image.new("RGBA", (W, H), (0, 0, 0, 0)); d = ImageDraw.Draw(o)
    d.rectangle((0, 0, W, 130), fill=NAVY + (230,))
    spaced(d, (W / 2, 66), "SUN SAPHIA RESIDENCE", font("xb", 38), OR, 6)
    d.text((W - 40, 160), "Ảnh phối cảnh minh họa", font=font("m", 22), fill=(235, 240, 248), anchor="rm", stroke_width=2, stroke_fill=(0, 10, 30))
    # watermark 1 dòng mờ giữa hình
    wm = Image.new("RGBA", (W, H), (0, 0, 0, 0)); dw = ImageDraw.Draw(wm)
    spaced(dw, (W / 2, 960), "HOÀNG HIỆP · 0904 567 009", font("xb", 40), (255, 255, 255, 255), 8, stroke_width=2, stroke_fill=(0, 10, 30, 200))
    a = wm.getchannel("A").point(lambda v: int(v * 0.16)); wm.putalpha(a); o.alpha_composite(wm)
    # dải hotline
    fb, fi = font("xb", 38), font("sb", 26)
    tw = 50 + 14 + d.textlength("0904 567 009", font=fb) + 14 + 16 + d.textlength("Hoàng Hiệp", font=fi) + 26
    x0, y0 = W / 2 - tw / 2, 1752; x1, y1 = x0 + tw, y0 + 70
    d.rounded_rectangle((x0, y0, x1, y1), radius=35, fill=(8, 22, 46, 210), outline=(255, 122, 26, 230), width=2)
    d.ellipse((x0 + 10, y0 + 10, x0 + 60, y0 + 60), fill=(255, 122, 26))
    d.text((x0 + 35, y0 + 36), "\u260e", font=ImageFont.truetype("/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf", 30), fill=WH, anchor="mm")
    x = x0 + 74; d.text((x, y0 + 35), "0904 567 009", font=fb, fill=WH, anchor="lm"); x += d.textlength("0904 567 009", font=fb) + 14
    d.line((x, y0 + 20, x, y0 + 50), fill=(255, 255, 255, 70), width=2); x += 16
    d.text((x, y0 + 36), "Hoàng Hiệp", font=fi, fill=(255, 181, 71), anchor="lm")
    return o

def draw_sig(fr, idx, alpha, w=330, cx=540, bottom=1742):
    """Chữ ký tự viết: bóng tối + quầng cam như bản gốc."""
    if alpha <= 0: return
    sf = sig_frames(); im = sf[max(0, min(len(sf) - 1, idx))]
    h = round(w * im.height / im.width); im = im.resize((w, h), Image.LANCZOS)
    x, y = int(cx - w / 2), int(bottom - h)
    a = im.getchannel("A")
    pad = 30; L = Image.new("RGBA", (w + 2 * pad, h + 2 * pad), (0, 0, 0, 0))
    sh = Image.new("L", L.size, 0); sh.paste(a, (pad, pad + 2)); sh = sh.filter(ImageFilter.GaussianBlur(5)).point(lambda v: int(v * 0.85 * alpha))
    L.alpha_composite(Image.merge("RGBA", (Image.new("L", L.size, 2), Image.new("L", L.size, 8), Image.new("L", L.size, 22), sh)))
    gl = Image.new("L", L.size, 0); gl.paste(a, (pad, pad)); gl = gl.filter(ImageFilter.GaussianBlur(9)).point(lambda v: int(v * 0.5 * alpha))
    L.alpha_composite(Image.merge("RGBA", (Image.new("L", L.size, 255), Image.new("L", L.size, 122), Image.new("L", L.size, 26), gl)))
    top = im.copy(); top.putalpha(a.point(lambda v: int(v * alpha))); L.alpha_composite(top, (pad, pad))
    fr.alpha_composite(L, (x - pad, y - pad))

def sig_state(f, writes, speed=1.0):
    """Trả về (chỉ số khung chữ ký, độ hiện) tại khung f; viết lại ở mỗi mốc trong writes, mờ dần 15 khung trước lần viết sau."""
    k = -1
    for i, t in enumerate(writes):
        if f >= t: k = i
    if k < 0: return 0, 0.0
    t0 = writes[k]; nxt = writes[k + 1] if k + 1 < len(writes) else None
    a = min(1.0, (f - t0 + 1) / 8)
    if nxt is not None: a *= max(0.0, min(1.0, (nxt - f) / 15))
    return int((f - t0) * speed), a

def endcard(out, lines):
    im = Image.new("RGB", (W, H), NAVY); d = ImageDraw.Draw(im)
    y = 560
    d.text((W // 2, 420), "SUN SAPHIA RESIDENCE", font=font("b", 54), fill=WH, anchor="mm")
    d.text((W // 2, 490), "Trước mặt là Biển · Sau lưng là Sông · Bên cạnh là Núi", font=font("m", 32), fill=MUT, anchor="mm")
    for i, (t, f, c) in enumerate(lines):
        d.text((W // 2, y + 60), t, font=f, fill=c, anchor="mm"); y += 130
    d.rounded_rectangle((140, y + 60, W - 140, y + 210), radius=75, fill=OR)
    d.text((W // 2, y + 135), "Zalo 0904 567 009", font=font("xb", 70), fill=WH, anchor="mm")
    paste_logo(im, W // 2, y + 300, 520, 120)
    d.text((W // 2, H - 150), "sun-saphia-residence.com", font=font("m", 34), fill=MUT, anchor="mm")
    im.save(out)
    return y + 640   # đáy chữ ký lớn

def run(cmd): subprocess.run(cmd, check=True, stdout=subprocess.DEVNULL, stderr=subprocess.PIPE)

def smooth_segment(bg_path, ov_path, dur, zoom_in, out, f0, brand, sig, zmax=1.10, static=False):
    """Zoom mượt (toạ độ lẻ, không rung). Ảnh + khung chữ mờ vào/ra; lớp Hoàng Hiệp và chữ ký chạy liền mạch qua các cảnh.
    sig = dict(writes=[...khung toàn video], w, cx, bottom, speed)."""
    bg = Image.open(bg_path).convert("RGB"); ov = Image.open(ov_path) if ov_path else None
    BW, BH = bg.size; n = int(round(dur * FPS)); fd = int(0.3 * FPS)
    p = subprocess.Popen(["ffmpeg", "-y", "-f", "rawvideo", "-pix_fmt", "rgb24", "-s", f"{W}x{H}", "-r", str(FPS), "-i", "-",
                          "-vf", "format=yuv420p", "-c:v", "libx264", "-preset", "veryfast", "-crf", "18", out],
                         stdin=subprocess.PIPE, stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
    black = Image.new("RGBA", (W, H), (0, 0, 0, 255))
    for k in range(n):
        if static: fr = bg.copy().convert("RGBA")
        else:
            t = k / max(n - 1, 1); t = t * t * (3 - 2 * t)
            z = 1 + (zmax - 1) * (t if zoom_in else 1 - t)
            cw, ch = BW / z, BH / z; x0, y0 = (BW - cw) / 2, (BH - ch) / 2
            fr = bg.resize((W, H), Image.BICUBIC, box=(x0, y0, x0 + cw, y0 + ch)).convert("RGBA")
        if ov: fr.alpha_composite(ov)
        fade = min(1.0, (k + 1) / fd, (n - k) / fd) if not static else min(1.0, (k + 1) / fd)
        if fade < 1: fr = Image.blend(black, fr, fade)
        if brand: fr.alpha_composite(brand)
        idx, a = sig_state(f0 + k, sig["writes"], sig.get("speed", 1.0))
        draw_sig(fr, idx, a, sig.get("w", 330), sig.get("cx", 540), sig.get("bottom", 1742))
        p.stdin.write(fr.convert("RGB").tobytes())
    p.stdin.close(); p.wait()
    if p.returncode: raise RuntimeError("ffmpeg lỗi khi dựng " + out)

def main(cfg_path, out):
    cfg = json.load(open(cfg_path)); base = os.path.dirname(os.path.abspath(cfg_path))
    tmp = tempfile.mkdtemp(); segs = []
    brand = brand_layer()
    main_frames = int(round(sum(s["dur"] for s in cfg["scenes"]) * FPS))
    writes = list(range(40, max(main_frames - 200, 41), 510))   # viết lại khoảng mỗi 17 giây
    f0 = 0
    for i, s in enumerate(cfg["scenes"]):
        bg, ov, seg = f"{tmp}/bg{i}.jpg", f"{tmp}/ov{i}.png", f"{tmp}/s{i}.mp4"
        background(os.path.join(base, s["img"]), bg); overlay(s.get("tag"), s.get("lines", []), ov, s.get("big", False))
        smooth_segment(bg, ov, s["dur"], i % 2 == 0, seg, f0, brand, {"writes": writes})
        f0 += int(round(s["dur"] * FPS)); segs.append(seg)
    e = cfg.get("end")
    if e:
        ec, seg = f"{tmp}/end.jpg", f"{tmp}/end.mp4"
        sig_bottom = endcard(ec, [(t, font("xb" if j == 0 else "sb", 64 if j == 0 else 44), WH if j == 0 else MUT) for j, t in enumerate(e["lines"])])
        smooth_segment(ec, None, e["dur"], False, seg, 0, None, {"writes": [6], "w": 560, "bottom": sig_bottom, "speed": 1.5}, static=True)
        segs.append(seg)
    lst = f"{tmp}/list.txt"; open(lst, "w").write("".join(f"file '{p}'\n" for p in segs))
    silent = f"{tmp}/v.mp4"; run(["ffmpeg", "-y", "-f", "concat", "-safe", "0", "-i", lst, "-c", "copy", silent])
    total = sum(s["dur"] for s in cfg["scenes"]) + (e["dur"] if e else 0)
    music = os.path.join(base, cfg["music"])
    if cfg.get("voice"):
        voice = os.path.join(base, cfg["voice"])
        af = (f"[1:a]adelay=400|400,volume=1.6[vo];[2:a]volume=0.16,aloop=loop=-1:size=2e9,atrim=0:{total},afade=t=out:st={total-1.5}:d=1.5[mu];"
              f"[vo][mu]amix=inputs=2:duration=longest:normalize=0,atrim=0:{total}[a]")
        run(["ffmpeg", "-y", "-i", silent, "-i", voice, "-i", music, "-filter_complex", af, "-map", "0:v", "-map", "[a]", "-c:v", "copy", "-c:a", "aac", "-b:a", "160k", "-movflags", "+faststart", out])
    else:   # chưa có giọng đọc: chỉ nhạc nền, to hơn
        af = f"[1:a]volume=0.55,aloop=loop=-1:size=2e9,atrim=0:{total},afade=t=in:st=0:d=0.8,afade=t=out:st={total-2}:d=2[a]"
        run(["ffmpeg", "-y", "-i", silent, "-i", music, "-filter_complex", af, "-map", "0:v", "-map", "[a]", "-c:v", "copy", "-c:a", "aac", "-b:a", "160k", "-movflags", "+faststart", out])
    print(out, total)

if __name__ == "__main__": main(sys.argv[1], sys.argv[2])
