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
    d.rectangle((0, 0, W, 150), fill=NAVY + (235,))
    d.text((60, 52), "SUN SAPHIA RESIDENCE", font=font("b", 40), fill=WH)
    d.text((W - 60, 58), "Zalo 0904 567 009", font=font("sb", 34), fill=OR, anchor="ra")
    if lines:
        fl = font("xb", 76 if big else 64); P = 70
        wl = [l for t in lines for l in wrap(d, t, fl, W - 2 * P - 40)]
        lh = 92 if big else 80
        boxh = len(wl) * lh + 70 + (80 if tag else 0)
        y0 = int(H * 0.66) - boxh // 2 if not big else (H - boxh) // 2
        d.rounded_rectangle((P - 20, y0, W - P + 20, y0 + boxh), radius=36, fill=NAVY + (225,))
        y = y0 + 35
        if tag:
            ft = font("b", 34); tw = d.textlength(tag, font=ft)
            d.rounded_rectangle((P + 10, y, P + 10 + tw + 44, y + 58), radius=29, fill=OR); d.text((P + 32, y + 11), tag, font=ft, fill=WH); y += 80
        for l in wl: d.text((P + 10, y), l, font=fl, fill=WH); y += lh
    d.text((W // 2, H - 70), "TATILAND – đại lý phân phối chính thức · Ảnh phối cảnh minh họa", font=font("m", 28), fill=WH, anchor="mm", stroke_width=2, stroke_fill=(0, 0, 0))
    o.save(out)

def endcard(out, lines):
    im = Image.new("RGB", (W, H), NAVY); d = ImageDraw.Draw(im)
    y = 560
    d.text((W // 2, 420), "SUN SAPHIA RESIDENCE", font=font("b", 54), fill=WH, anchor="mm")
    d.text((W // 2, 490), "Trước mặt là Biển · Sau lưng là Sông · Bên cạnh là Núi", font=font("m", 32), fill=MUT, anchor="mm")
    for i, (t, f, c) in enumerate(lines):
        d.text((W // 2, y + 60), t, font=f, fill=c, anchor="mm"); y += 130
    d.rounded_rectangle((140, y + 60, W - 140, y + 210), radius=75, fill=OR)
    d.text((W // 2, y + 135), "Zalo 0904 567 009", font=font("xb", 70), fill=WH, anchor="mm")
    d.text((W // 2, y + 300), "Hoàng Hiệp – TATILAND, đại lý phân phối chính thức", font=font("sb", 34), fill=WH, anchor="mm")
    d.text((W // 2, y + 360), "sun-saphia-residence.com", font=font("m", 34), fill=MUT, anchor="mm")
    im.save(out)

def run(cmd): subprocess.run(cmd, check=True, stdout=subprocess.DEVNULL, stderr=subprocess.PIPE)

def main(cfg_path, out):
    cfg = json.load(open(cfg_path)); base = os.path.dirname(os.path.abspath(cfg_path))
    tmp = tempfile.mkdtemp(); segs = []
    for i, s in enumerate(cfg["scenes"]):
        bg, ov, seg = f"{tmp}/bg{i}.jpg", f"{tmp}/ov{i}.png", f"{tmp}/s{i}.mp4"
        background(os.path.join(base, s["img"]), bg); overlay(s.get("tag"), s.get("lines", []), ov, s.get("big", False))
        n = int(s["dur"] * FPS); zin = i % 2 == 0
        z = f"min(1+0.12*on/{n},1.12)" if zin else f"max(1.12-0.12*on/{n},1)"
        vf = (f"[0:v]scale={int(W*1.25)}:{int(H*1.25)},zoompan=z='{z}':x='iw/2-(iw/zoom/2)':y='ih/2-(ih/zoom/2)':d={n}:s={W}x{H}:fps={FPS}[b];"
              f"[b][1:v]overlay=0:0,fade=t=in:st=0:d=0.3,fade=t=out:st={s['dur']-0.3}:d=0.3,format=yuv420p[v]")
        run(["ffmpeg", "-y", "-loop", "1", "-i", bg, "-i", ov, "-filter_complex", vf, "-map", "[v]", "-t", str(s["dur"]), "-r", str(FPS), "-c:v", "libx264", "-preset", "veryfast", "-crf", "20", seg])
        segs.append(seg)
    e = cfg.get("end")
    if e:
        ec, seg = f"{tmp}/end.jpg", f"{tmp}/end.mp4"
        endcard(ec, [(t, font("xb" if j == 0 else "sb", 64 if j == 0 else 44), WH if j == 0 else MUT) for j, t in enumerate(e["lines"])])
        run(["ffmpeg", "-y", "-loop", "1", "-i", ec, "-vf", f"fade=t=in:st=0:d=0.3,format=yuv420p", "-t", str(e["dur"]), "-r", str(FPS), "-c:v", "libx264", "-preset", "veryfast", "-crf", "20", seg])
        segs.append(seg)
    lst = f"{tmp}/list.txt"; open(lst, "w").write("".join(f"file '{p}'\n" for p in segs))
    silent = f"{tmp}/v.mp4"; run(["ffmpeg", "-y", "-f", "concat", "-safe", "0", "-i", lst, "-c", "copy", silent])
    total = sum(s["dur"] for s in cfg["scenes"]) + (e["dur"] if e else 0)
    voice = os.path.join(base, cfg["voice"]); music = os.path.join(base, cfg["music"])
    af = (f"[1:a]adelay=400|400,volume=1.6[vo];[2:a]volume=0.16,aloop=loop=-1:size=2e9,atrim=0:{total},afade=t=out:st={total-1.5}:d=1.5[mu];"
          f"[vo][mu]amix=inputs=2:duration=longest:normalize=0,atrim=0:{total}[a]")
    run(["ffmpeg", "-y", "-i", silent, "-i", voice, "-i", music, "-filter_complex", af, "-map", "0:v", "-map", "[a]", "-c:v", "copy", "-c:a", "aac", "-b:a", "160k", "-movflags", "+faststart", out])
    print(out, total)

if __name__ == "__main__": main(sys.argv[1], sys.argv[2])
