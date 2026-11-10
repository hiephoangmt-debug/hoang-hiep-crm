# Làm ảnh phối cảnh "sống": máy đẩy lên đỉnh tháp, mây trôi, vệt sáng chạy dọc đường LED, nắng lóe, mặt đường lấp lánh, ngày → đêm lên đèn.
import cv2, numpy as np, subprocess, sys, math
A = cv2.imread('src.jpg').astype(np.float32); H, W = A.shape[:2]
FG = cv2.imread('fg.png', 0).astype(np.float32) / 255; SKY = 1 - FG
FPS, DUR = 30, 12.0; N = int(FPS * DUR)
yy, xx = np.mgrid[0:H, 0:W].astype(np.float32)
lum = A.mean(2); b, g, r = A[..., 0], A[..., 1], A[..., 2]
sat = (A.max(2) - A.min(2)) / (A.max(2) + 1)
ss = lambda x: (lambda t: t * t * (3 - 2 * t))(min(1, max(0, x)))
# nền trời kéo dài (vá phần sau tòa nhà) để mây trôi không lộ khoảng trống
small = cv2.resize(A, (W // 4, H // 4)); msk = cv2.resize((FG > .3).astype(np.uint8) * 255, (W // 4, H // 4))
msk = cv2.dilate(msk, np.ones((15, 15), np.uint8))
skyplate = cv2.resize(cv2.inpaint(small.astype(np.uint8), msk, 9, cv2.INPAINT_TELEA), (W, H), interpolation=cv2.INTER_CUBIC).astype(np.float32)
skyplate = A * SKY[..., None] + skyplate * FG[..., None]
# đường LED trắng trên mặt tòa nhà
led = ((lum > 205) & (sat < .18) & (cv2.erode((FG > .9).astype(np.uint8), np.ones((9, 9), np.uint8)) > 0) & (yy < 1640) & (yy > 120)).astype(np.float32)
led = cv2.morphologyEx(led, cv2.MORPH_OPEN, np.ones((1, 1), np.uint8))
ledglow = cv2.GaussianBlur(led, (0, 0), 6)
# đèn giữ lại khi trời tối: ô cửa ấm, cửa hàng khối đế, đường LED
warm = np.clip(((r - b) - 12) / 50, 0, 1) * np.clip((lum - 95) / 70, 0, 1) * FG
shop = ((yy > 1640) & (yy < 1830) & (xx > 490) & (xx < 1230)).astype(np.float32) * np.clip((lum - 110) / 90, 0, 1)
keep = np.clip(warm * 1.2 + shop + led, 0, 1); keep = cv2.GaussianBlur(keep, (0, 0), 1.2)
road = np.clip((yy - 1820) / 40, 0, 1)
gy = (yy / (H * .85)).clip(0, 1)[..., None]
NIGHT_SKY = (1 - gy) * np.array([38, 14, 6], np.float32) + gy * np.array([120, 70, 60], np.float32)   # BGR: xanh đêm → tím hồng chân trời
DUSK_SKY = (1 - gy) * np.array([150, 90, 60], np.float32) + gy * np.array([120, 170, 255], np.float32)
rng = np.random.default_rng(4); stars = np.zeros((H, W), np.float32)
for _ in range(220):
    x, y = rng.integers(0, W), rng.integers(0, int(H * .55))
    stars[y, x] = rng.uniform(.4, 1)
stars = cv2.GaussianBlur(stars, (0, 0), .9) * 4 * SKY
SUN = (1490, 1620)
def frame(i):
    t = i / FPS
    # mây trôi sang trái
    dx = -t * 2.6
    sky = cv2.warpAffine(skyplate, np.float32([[1, 0, dx], [0, 1, 0]]), (W, H), borderMode=cv2.BORDER_REFLECT)
    img = sky * SKY[..., None] + A * FG[..., None]
    # mặt đường ướt lấp lánh: lệch dọc rất nhẹ theo sóng
    disp = (np.sin(xx / 23 + t * 3.1) * 1.6 + np.sin(xx / 7 - t * 4.7) * .7) * road
    img = img * (1 - road[..., None]) + cv2.remap(img, xx, yy + disp, cv2.INTER_LINEAR) * road[..., None]
    # pha trời: 0–6 s ngày, 6–9 s hoàng hôn, 9–12 s đêm
    d = ss((t - 5.5) / 3.0); n = ss((t - 7.8) / 2.6)
    if d > 0:
        img = img * (1 + np.array([-.14, -.02, .14], np.float32) * d)
        img = img * (1 - SKY[..., None] * .55 * d) + DUSK_SKY * SKY[..., None] * .55 * d
    if n > 0:
        dark = img * np.array([.30, .22, .20], np.float32)
        lit = img * keep[..., None] * 1.6 + (img * .35) * (1 - keep[..., None])
        night = dark * (1 - keep[..., None]) + np.maximum(dark, lit) * keep[..., None]
        night = night * FG[..., None] + (NIGHT_SKY + stars[..., None] * 255 * (.6 + .4 * math.sin(t * 5))) * SKY[..., None]
        night += cv2.GaussianBlur(night * keep[..., None], (0, 0), 9) * .35 * FG[..., None]   # quầng sáng nhẹ quanh đèn
        img = img * (1 - n) + night * n
    # vệt sáng chạy dọc đường LED từ chân lên đỉnh, lặp mỗi 4 s; ban đêm LED sáng hẳn
    ys = 1700 - ((t % 4.0) / 4.0) * 1700
    band = np.exp(-((yy - ys) / 70) ** 2)
    img += (led * band * 1.0 + ledglow * band * 2.2)[..., None] * np.array([255, 245, 235], np.float32) * .55
    img += (led * .6 + ledglow * 1.6)[..., None] * np.array([255, 240, 220], np.float32) * .35 * n
    # nắng lóe góc phải (ban ngày)
    sun = math.exp(-((t % 6) - 3) ** 2) * .25 + .55
    rr = np.hypot(xx - SUN[0], yy - SUN[1])
    img += (np.exp(-(rr / 260) ** 2) * sun * (1 - d))[..., None] * np.array([120, 200, 255], np.float32) * .55
    # máy quay: đẩy vào và ngẩng dần lên đỉnh tháp
    u = ss(t / DUR); z = 1.0 + .22 * u
    cy = 1080 - 330 * u; cx = 860
    s = 1920 / H * z
    M = np.float32([[s, 0, 540 - cx * s], [0, s, 960 - cy * s]])
    out = cv2.warpAffine(np.clip(img, 0, 255).astype(np.uint8), M, (1080, 1920), flags=cv2.INTER_CUBIC, borderMode=cv2.BORDER_REFLECT)
    return out
if __name__ == '__main__':
    if sys.argv[1] == 'test':
        for i in [0, 90, 200, 280, 359]: cv2.imwrite(f't{i:03d}.jpg', cv2.resize(frame(i), (360, 640)))
        sys.exit()
    ff = subprocess.Popen(['ffmpeg', '-y', '-loglevel', 'error', '-f', 'rawvideo', '-pix_fmt', 'bgr24', '-s', '1080x1920', '-r', str(FPS), '-i', '-',
                           '-c:v', 'libx264', '-preset', 'slow', '-crf', '16', '-pix_fmt', 'yuv420p', sys.argv[1]], stdin=subprocess.PIPE)
    for i in range(N):
        ff.stdin.write(frame(i).tobytes())
        if i % 60 == 0: print(i, flush=True)
    ff.stdin.close(); ff.wait()
