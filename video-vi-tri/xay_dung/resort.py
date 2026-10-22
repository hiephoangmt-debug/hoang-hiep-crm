# Biến bãi cỏ dại giữa đường Võ Nguyên Giáp và bãi biển thành cảnh quan kiểu resort (áp cho cả ảnh trước và sau).
import numpy as np, cv2, math
def resort(img, protect=None, seed=11):
    A = img.astype(np.float32); H, W, _ = A.shape
    rng = np.random.default_rng(seed)
    yy, xx = np.mgrid[0:H, 0:W]
    lum = A.mean(2); g = A[..., 1] - np.maximum(A[..., 0], A[..., 2])
    reg = np.zeros((H, W), np.float32)
    cv2.fillPoly(reg, [np.array([(122, 366), (1222, 366), (1222, 546), (0, 546), (0, 404), (122, 404)], np.int32)], 1)
    wild = ((lum > 70) & (g > -14)).astype(np.float32)                # cỏ dại sáng; cụm cây đậm giữ lại
    wild = cv2.morphologyEx(wild, cv2.MORPH_OPEN, np.ones((2, 2)))
    m = cv2.GaussianBlur(reg * wild, (0, 0), 1.2)
    def noise(sc): return cv2.resize(rng.standard_normal((H // sc + 2, W // sc + 2)).astype(np.float32), (W, H), interpolation=cv2.INTER_CUBIC)
    stripe = np.tanh(3 * np.sin((xx + (yy - 366) * 0.4) / 30.0))
    depth = ((yy - 366) / 180).clip(0, 1)
    lawn = np.array([104, 150, 72], np.float32)[None, None] * (1 + (0.05 + 0.03 * depth[..., None]) * stripe[..., None] + 0.02 * noise(5)[..., None])
    lawn *= (0.93 + 0.1 * depth)[..., None]
    C = A * (1 - m[..., None]) + lawn * m[..., None]
    ov = C.copy()
    SAND = (196, 186, 160); POOL = (70, 200, 215); DECK = (236, 230, 216)
    # lối dạo ven biển + lối đi cong từ đường ra biển
    cv2.line(ov, (122, 371), (1222, 371), SAND, 4, cv2.LINE_AA)
    for x0, x1 in [(260, 330), (980, 935), (1160, 1120)]:
        pts = np.array([(int(x0 + (x1 - x0) * t + 18 * math.sin(t * 3.1)), int(546 - 175 * t)) for t in np.linspace(0, 1, 40)], np.int32)
        cv2.polylines(ov, [pts], False, SAND, 2, cv2.LINE_AA)
    # hồ bơi chữ nhật bo góc, dẹt theo phối cảnh, có sàn và bóng nước
    def rrect(img, x, y, w, h, r, col):
        cv2.rectangle(img, (x + r, y), (x + w - r, y + h), col, -1); cv2.rectangle(img, (x, y + r), (x + w, y + h - r), col, -1)
        for cx, cy in [(x + r, y + r), (x + w - r, y + r), (x + r, y + h - r), (x + w - r, y + h - r)]: cv2.circle(img, (cx, cy), r, col, -1, cv2.LINE_AA)
    for (x, y, w, h) in [(200, 455, 58, 11), (905, 438, 64, 12)]:
        rrect(ov, x - 6, y - 4, w + 12, h + 8, 4, DECK)
        rrect(ov, x, y, w, h, 3, POOL)
        ov[y:y + 3, x + 3:x + w - 3] = ov[y:y + 3, x + 3:x + w - 3] * 0.6 + np.array([40, 120, 140], np.float32) * 0.4
        for i in range(6):
            cx = x + 2 + i * (w // 6); cv2.rectangle(ov, (cx, y + h + 6), (cx + 4, y + h + 7), (250, 250, 250), -1)
    # dù trắng trên bãi cát + hàng dừa ven lối dạo
    for x in range(140, 1220, 46):
        if rng.random() < 0.7: cv2.circle(ov, (x + int(rng.integers(-8, 8)), 362), 3, (250, 248, 240), -1, cv2.LINE_AA)
    def palm(x, y, s):
        cv2.ellipse(ov, (x + 3, y + 1), (int(s * 1.6), max(1, int(s * 0.5))), 0, 0, 360, (60, 80, 45), -1, cv2.LINE_AA)
        cv2.line(ov, (x, y), (x + 1, y - int(3 * s)), (110, 90, 60), 1, cv2.LINE_AA)
        for a in range(0, 360, 60):
            r = math.radians(a + rng.integers(-15, 15))
            cv2.ellipse(ov, (int(x + 1 + math.cos(r) * s), int(y - 3 * s + math.sin(r) * s * 0.6)), (int(s * 1.1), max(1, int(s * 0.45))), a, 0, 360, (46, 96, 44), -1, cv2.LINE_AA)
    for x in range(132, 1222, 30):
        if rng.random() < 0.75: palm(x + int(rng.integers(-8, 8)), 378 + int(rng.integers(-2, 3)), rng.uniform(2.4, 3.6))
    for x in range(140, 1222, 48):
        if rng.random() < 0.7: palm(x + int(rng.integers(-12, 12)), 533 + int(rng.integers(-3, 3)), rng.uniform(3.4, 4.8))
    Rm = cv2.GaussianBlur(reg, (0, 0), 1.0)[..., None]
    C = C * (1 - Rm) + ov * Rm
    if protect is not None: C = C * (1 - protect[..., None]) + A * protect[..., None]
    return np.clip(C, 0, 255).astype(np.uint8)

if __name__ == '__main__':
    B = cv2.imread('before.png')[..., ::-1]; cv2.imwrite('before.png', resort(B)[..., ::-1])
    A2 = cv2.imread('after.png')[..., ::-1]
    prot = np.zeros(A2.shape[:2], np.float32); prot[54:645, 474:826] = 1; prot[636:745, 450:892] = 1
    cv2.imwrite('after.png', resort(A2, prot)[..., ::-1])
    cv2.imwrite('t/resort.jpg', resort(A2, prot)[330:570, :, ::-1])
