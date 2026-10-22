# Dựng video "hành trình xây dựng" Sun Saphia từ 1 ảnh phối cảnh: tháp mọc từng tầng, cần cẩu, ngày–đêm.
# Cách dùng: python3 build.py out.mp4 [khung_bắt_đầu khung_kết_thúc]   (in ra build_data.json cho lớp chữ)
import numpy as np, cv2, json, sys, subprocess, math
A = cv2.imread('p1.jpg')[..., ::-1].astype(np.float32)
A2 = cv2.imread('after.png')[..., ::-1].astype(np.float32)   # ảnh hoàn thiện: cỏ phía trước đã dọn
B0 = cv2.imread('before.png')[..., ::-1].astype(np.float32)
H, W, _ = A.shape
FPS, TOTAL = 30, 1230
rng = np.random.default_rng(7)
yy, xx = np.mgrid[0:H, 0:W]
clamp = lambda x, a=0.0, b=1.0: max(a, min(b, x))
ss = lambda x: (lambda t: t * t * (3 - 2 * t))(clamp(x))

# ---------- hình học tòa nhà (toạ độ ảnh gốc 1280×898) ----------
TX0, TX1, TTOP, TBASE = 478, 822, 56, 642          # thân tháp
PX0, PX1, PTOP, PBASE = 452, 890, 638, 742         # khối đế
FL = (TBASE - 78) / 29.0                           # chiều cao 1 tầng (px)
MT = np.zeros((H, W), np.float32); MT[TTOP:TBASE, TX0:TX1] = 1; MT[TTOP:80, 476:825] = 1
MP = np.zeros((H, W), np.float32); MP[PTOP:PBASE, PX0:PX1] = 1
MB = np.maximum(MT, MP)
lum = A.mean(2); sat = (A.max(2) - A.min(2)) / (A.max(2) + 1)
GLASS = ((lum > 35) & (lum < 175) & (sat < 0.28)).astype(np.float32) * MT
# ô cửa sổ: tầng × khoang, bật đèn ngẫu nhiên
ROW = np.clip(((TBASE - yy) / FL).astype(int), 0, 40); COL = np.clip(((xx - TX0) / 21).astype(int), 0, 20)
RANK = rng.random((41, 21)); LIT = RANK < 0.5; FLICK = rng.random((41, 21))
SHOP = np.zeros((H, W), np.float32); SHOP[652:736, PX0 + 8:PX1 - 8] = 1; SHOP *= (lum < 200)

# khung bê tông (tầng đang thi công)
def skeleton():
    S = np.zeros((H, W, 3), np.float32)
    S[:] = (58, 61, 68)
    fy = (TBASE - yy) % FL
    S[fy < 3.5] = (205, 203, 196)                                   # sàn
    col = ((xx - TX0) % 43) < 6
    S[col & (fy >= 3.5)] = (150, 150, 146)                          # cột
    edge = (xx < TX0 + 5) | (xx > TX1 - 6)
    S[edge] = (175, 174, 170)
    py = (PBASE - yy) % 34
    pod = MP > 0
    S[pod & (py < 5)] = (205, 203, 196); S[pod & (py >= 5)] = (62, 64, 70)
    S[pod & (((xx - PX0) % 48) < 7) & (py >= 5)] = (150, 150, 146)
    return S
SK = skeleton()

# ---------- lịch trình ----------
def floors_at(f):          # số tầng thân tháp đã lên (0..30), khối đế riêng
    return 30 * ss((f - 190) / 470)
def podium_at(f): return ss((f - 100) / 90)
def light_at(f):
    """trả về (night, warm): 4 vòng ngày–đêm khi xây, rồi đêm tổng kết và bình minh"""
    def cyc(u):
        n = ss((u - 0.40) / 0.15) * (1 - ss((u - 0.82) / 0.13))
        w = math.exp(-((u - 0.43) / 0.07) ** 2) + 0.8 * math.exp(-((u - 0.9) / 0.06) ** 2)
        return n, w
    if 90 <= f < 690: return cyc(((f - 90) % 150) / 150)
    if 770 <= f < 1130:           # hoàn thiện: 2 vòng ngày–đêm dài, đêm kéo dài để khoe đèn
        u = ((f - 770) % 180) / 180
        n = ss((u - 0.22) / 0.16) * (1 - ss((u - 0.80) / 0.14))
        w = math.exp(-((u - 0.25) / 0.07) ** 2) + 0.8 * math.exp(-((u - 0.88) / 0.06) ** 2)
        return n, w
    return 0.0, 0.0

# ---------- bầu trời ----------
SKY0 = cv2.GaussianBlur((yy < 238).astype(np.float32), (0, 0), 1.2)
gy = (yy / 238.0).clip(0, 1)[..., None]
SUNSET = (1 - gy) * np.array([70, 90, 160], np.float32) + gy * np.array([255, 150, 95], np.float32)
NIGHTS = (1 - gy) * np.array([5, 10, 28], np.float32) + gy * np.array([28, 38, 78], np.float32)
STAR = np.zeros((H, W), np.float32)
for _ in range(260):
    x, y = rng.integers(0, W), rng.integers(0, 225); STAR[y, x] = rng.uniform(.4, 1)
STAR = cv2.GaussianBlur(STAR, (0, 0), 0.7) * 3
STARPH = rng.random((H, W)).astype(np.float32) * 6.28

def glow(img, pts, rad, col, inten):
    if not pts: return
    L = np.zeros((H, W), np.float32)
    for x, y, k in pts:
        if 0 <= x < W and 0 <= y < H: L[int(y), int(x)] += k
    L = cv2.GaussianBlur(L, (0, 0), rad) * (rad * rad * 6.28) * 0.5
    core = cv2.GaussianBlur(L, (0, 0), 0.8)
    img += (np.minimum(L, 1.6)[..., None] * col * inten) + np.minimum(core, 1)[..., None] * 255 * inten * 0.3

LAMPS_BACK = [(x, 553) for x in range(20, 1280, 66) if not (470 < x < 835)]
LAMPS_FRONT = [(x, 792) for x in range(255, 1240, 72)]
LAMPS_LEFT = [(300 - i * 34, 600 + i * 50) for i in range(6)]

def draw_crane(img, f, yF, alpha):
    if alpha <= 0: return
    ov = img.copy()
    mx = 915; base = 735
    top = int(min(560, yF - 70)) if f < 680 else int(yF - 70 - (f - 680) * 6)
    rise = ss((f - 70) / 40); top = int(base - (base - top) * rise)
    Y = (236, 186, 34)
    # thân cẩu dạng giàn
    cv2.line(ov, (mx - 6, base), (mx - 6, top), Y, 2); cv2.line(ov, (mx + 6, base), (mx + 6, top), Y, 2)
    for y in range(base, top, -12): cv2.line(ov, (mx - 6, y), (mx + 6, y - 12), Y, 1)
    if rise > 0.9:
        th = 0.55 * math.sin(f / 45)
        L = int(430 * math.cos(th)); C = int(120 * math.cos(th))
        cv2.line(ov, (mx, top), (mx, top - 26), Y, 3)
        cv2.line(ov, (mx - L, top), (mx + C, top), Y, 3); cv2.line(ov, (mx - L, top + 6), (mx + C, top + 6), Y, 1)
        for x in range(mx - L, mx + C, 14): cv2.line(ov, (x, top), (x + 7, top + 6), Y, 1)
        cv2.line(ov, (mx, top - 26), (mx - L, top), (210, 210, 210), 1); cv2.line(ov, (mx, top - 26), (mx + C, top), (210, 210, 210), 1)
        cv2.rectangle(ov, (mx + C - 26, top + 2), (mx + C, top + 14), (90, 90, 95), -1)
        cv2.rectangle(ov, (mx - 14, top + 4), (mx - 2, top + 16), (245, 245, 240), -1)
        tx = int(mx - L * (0.45 + 0.25 * math.sin(f / 23)))
        hy = int(min(yF - 8, top + 60 + 30 * math.sin(f / 17)))
        cv2.line(ov, (tx, top + 6), (tx, hy), (60, 60, 60), 1)
        cv2.rectangle(ov, (tx - 7, hy), (tx + 7, hy + 6), (150, 110, 70), -1)
    img[:] = img * (1 - alpha) + ov * alpha
    return top

def draw_site(img, a):
    if a <= 0: return
    ov = img.copy()
    BL = (34, 92, 168)
    pts = [(280, 794), (992, 794)]
    cv2.rectangle(ov, (278, 778), (994, 796), BL, -1); cv2.line(ov, (278, 778), (994, 778), (240, 240, 240), 2)
    for x in range(300, 990, 60): cv2.line(ov, (x, 780), (x, 796), (24, 70, 140), 1)
    cv2.fillPoly(ov, [np.array([(278, 796), (300, 598), (306, 598), (286, 796)], np.int32)], BL)
    cv2.fillPoly(ov, [np.array([(992, 796), (962, 598), (968, 598), (999, 796)], np.int32)], BL)
    cv2.line(ov, (300, 598), (962, 598), BL, 3)
    for i, (x, y) in enumerate([(318, 712), (318, 738), (360, 712)]):    # lán trại
        cv2.rectangle(ov, (x, y), (x + 40, y + 22), (235, 235, 230), -1); cv2.rectangle(ov, (x, y), (x + 40, y + 5), (34, 92, 168), -1)
    for x, y in [(930, 760), (370, 770)]:                                 # bãi vật liệu
        cv2.ellipse(ov, (x, y), (22, 9), 0, 180, 360, (150, 140, 125), -1)
    img[:] = img * (1 - a) + ov * a

def frame(f):
    pod = podium_at(f); fl = floors_at(f)
    yP = PBASE - pod * (PBASE - PTOP)
    yF = TBASE - fl / 30 * (TBASE - TTOP) if fl > 0 else TBASE + 1
    lag = FL * 3.2
    gT = min(TBASE, yF + lag) if f < 660 else yF + lag * (1 - ss((f - 660) / 40))
    gP = min(PBASE, yP + 30) if f < 220 else PTOP
    img = B0.copy()
    # khối đế + thân tháp: phần đã lắp kính = ảnh gốc, phần mới đổ = khung bê tông
    built = (MP * (yy >= yP)) + (MT * (yy >= yF)); built = np.minimum(built, 1)
    glassd = (MP * (yy >= gP)) + (MT * (yy >= gT)); glassd = np.minimum(glassd, 1) * built
    skel = built - glassd
    net = ((yy < yF + FL * 2) & (yy >= yF)).astype(np.float32) * MT
    form = ((yy < yF + 4) & (yy >= yF)).astype(np.float32) * MT
    S = SK * (1 - 0.45 * net[..., None]) + np.array([90, 120, 105], np.float32) * 0.45 * net[..., None]
    S = S * (1 - form[..., None]) + np.array([185, 125, 70], np.float32) * form[..., None]
    img = img * (1 - built[..., None]) + (A * glassd[..., None] + S * skel[..., None])
    site_a = ss((f - 40) / 25) * (1 - ss((f - 700) / 30))
    draw_site(img, site_a)
    crane_a = (1 - ss((f - 690) / 25))
    top = draw_crane(img, f, yF, crane_a)
    # hoàn thiện: cảnh quan, hàng cọ hiện dần → trùng ảnh phối cảnh
    k = ss((f - 705) / 50); img = img * (1 - k) + A2 * k
    # ---------- ánh sáng ----------
    n, w = light_at(f)
    bk = np.maximum(built, k * MB)
    SKY = SKY0 * (1 - cv2.GaussianBlur(bk, (0, 0), 0.8))
    if w > 0:
        img = img * (1 + np.array([0.16, -0.02, -0.18], np.float32) * w) * (1 - 0.12 * w)
        img = img * (1 - SKY[..., None] * 0.7 * w) + SUNSET * SKY[..., None] * 0.7 * w
    if n > 0:
        dark = img * np.array([0.20, 0.24, 0.38], np.float32)
        img = img * (1 - n) + dark * n
        img = img * (1 - SKY[..., None] * n) + NIGHTS * SKY[..., None] * n
        tw = 0.6 + 0.4 * np.sin(STARPH + f * 0.25)
        img += (STAR * tw * SKY * n * 255)[..., None] * 0.8
        # đèn cửa sổ ở các tầng đã hoàn thiện (có tầng tắt/bật theo thời gian)
        slot = f // 20
        lit = LIT ^ (FLICK < 0.06 * ((slot * 7919) % 5 == 0))
        if f >= 770: lit = (RANK < 0.12 + 0.55 * n) ^ (FLICK < 0.04 * ((slot * 7919) % 5 == 0))
        Lw = GLASS * lit[ROW, COL] * glassd * (1 - k) + GLASS * lit[ROW, COL] * k
        Lw = cv2.GaussianBlur(Lw, (0, 0), 0.8)
        img += Lw[..., None] * np.array([255, 178, 96], np.float32) * 0.5 * n
        img += cv2.GaussianBlur(Lw, (0, 0), 6)[..., None] * np.array([255, 160, 80], np.float32) * 0.25 * n
        Ls = SHOP * glassd * (1 - k) + SHOP * k
        img += cv2.GaussianBlur(Ls, (0, 0), 1)[..., None] * np.array([255, 195, 120], np.float32) * 0.42 * n
        # đèn đường, xe chạy, đèn công trường, đèn đỏ đỉnh cẩu
        pts = [(x, y, 1) for x, y in LAMPS_BACK + LAMPS_FRONT + LAMPS_LEFT]
        glow(img, pts, 5, np.array([255, 200, 120], np.float32), 0.9 * n)
        cars = []
        for i in range(9):
            x = (f * (4 + i % 3) + i * 157) % 1400 - 60
            if TX0 < x < TX1 and yF < 575: continue
            cars.append((x, 564, 0.8))
        glow(img, cars, 2.5, np.array([255, 245, 220], np.float32), 0.9 * n)
        cars = []
        for i in range(8):
            x = 1340 - (f * (3 + i % 3) + i * 191) % 1400
            if TX0 < x < TX1 and yF < 585: continue
            cars.append((x, 580, 0.7))
        glow(img, cars, 2.5, np.array([255, 60, 40], np.float32), 0.8 * n)
        if 100 < f < 690:
            glow(img, [(TX0 + 20, yF + 6, 2), (TX1 - 20, yF + 6, 2), (650, yP + 4, 1.5)], 14, np.array([230, 240, 255], np.float32), 0.8 * n)
            if top and (f // 15) % 2 == 0: glow(img, [(915, top - 27, 1.5)], 3, np.array([255, 40, 30], np.float32), n * crane_a)
        if f >= 720:
            glow(img, [(650, TTOP - 2, 1)], 4, np.array([255, 40, 30], np.float32), n * (0.6 + 0.4 * ((f // 15) % 2)))
    return np.clip(img, 0, 255).astype(np.uint8), fl, pod, n

if __name__ == '__main__':
    out = sys.argv[1]; f0 = int(sys.argv[2]) if len(sys.argv) > 2 else 0; f1 = int(sys.argv[3]) if len(sys.argv) > 3 else TOTAL
    # khung ảnh trong video dọc: 1080×960 (thu phóng 1,069 rồi cắt giữa theo tòa tháp)
    s = 960 / H; Wd = round(W * s); cx = round(650 * s) - 540
    if out.endswith('.jpg'):
        for f in range(f0, f1, max(1, (f1 - f0) // 12)):
            im = frame(f)[0]; cv2.imwrite(out.replace('.jpg', f'_{f:04d}.jpg'), cv2.resize(im, (Wd, 960))[:, cx:cx + 1080][..., ::-1], [cv2.IMWRITE_JPEG_QUALITY, 88])
        sys.exit()
    ff = subprocess.Popen(['ffmpeg', '-y', '-loglevel', 'error', '-f', 'rawvideo', '-pix_fmt', 'rgb24', '-s', '1080x960', '-r', '30', '-i', '-',
                           '-c:v', 'libx264', '-preset', 'slow', '-crf', '16', '-pix_fmt', 'yuv420p', out], stdin=subprocess.PIPE)
    data = []
    for f in range(f0, f1):
        im, fl, pod, n = frame(f)
        ff.stdin.write(np.ascontiguousarray(cv2.resize(im, (Wd, 960), interpolation=cv2.INTER_CUBIC)[:, cx:cx + 1080]).tobytes())
        data.append([round(fl, 3), round(pod, 3), round(n, 3)])
        if f % 60 == 0: print('frame', f, flush=True)
    ff.stdin.close(); ff.wait()
    json.dump(data, open(out.replace('.mp4', '_data.json'), 'w'))
