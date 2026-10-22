# Tạo nền "đất trống" từ ảnh phối cảnh: xóa tháp bằng phản chiếu hai bên, phủ đất công trường.
import numpy as np, cv2
A = cv2.imread('p1.jpg')[..., ::-1].astype(np.float32)
H, W, _ = A.shape
B = A.copy()
x0, x1, y0, y1 = 445, 900, 30, 600
xs = np.arange(x0, x1); wR = ((xs - x0) / (x1 - x0))[None, :, None]
L = A[y0:y1, xs - 330]; R = A[y0:y1, np.clip(xs + 300, 0, W - 1)]   # dịch ngang, tránh lặp toà nhà trắng
wR = np.clip((xs - 642) / 60, 0, 1)[None, :, None]
fill = L * (1 - wR) + R * wR
# viền mềm để không thấy mép
m = np.zeros((H, W), np.float32); m[y0:y1, x0:x1] = 1; m = cv2.GaussianBlur(m, (0, 0), 3)
# bầu trời (trên đường chân trời ~y 236): nội suy mượt giữa hai mép để không lặp logo
ys = slice(y0, 236)
lc = A[ys, x0 - 6:x0 - 1].mean(1, keepdims=True); rc = A[ys, x1 + 1:x1 + 6].mean(1, keepdims=True)
fill[:236 - y0] = lc * (1 - wR) + rc * wR
F = A.copy(); F[y0:y1, x0:x1] = fill
# ghép Poisson cho liền màu với xung quanh
msk = np.zeros((H, W), np.uint8); msk[y0:y1, x0:x1] = 255
Fu = np.clip(F, 0, 255).astype(np.uint8); Au = np.clip(A, 0, 255).astype(np.uint8)
B = cv2.seamlessClone(Fu, Au, msk, ((x0 + x1) // 2, (y0 + y1) // 2), cv2.NORMAL_CLONE).astype(np.float32)
rng = np.random.default_rng(3)
lot = np.zeros((H, W), np.uint8)
cv2.fillPoly(lot, [np.array([(300, 598), (962, 598), (992, 794), (278, 794)], np.int32)], 1)
Ms = cv2.GaussianBlur(lot.astype(np.float32), (0, 0), 1.5)
def noise(sc):
    return cv2.resize(rng.standard_normal((H // sc + 2, W // sc + 2)).astype(np.float32), (W, H), interpolation=cv2.INTER_CUBIC)
yy, xx = np.mgrid[0:H, 0:W]
n = 0.06 * noise(40) + 0.05 * noise(12) + 0.04 * noise(3) + 0.03 * rng.standard_normal((H, W)).astype(np.float32)
dirt = np.array([186, 174, 152], np.float32)[None, None] * (1 + n[..., None])
# vệt xe cơ giới + mảng cỏ dại còn sót
dirt *= (1 - 0.06 * (np.abs(np.sin((xx * 0.9 + yy * 0.45) / 11)) > 0.97))[..., None]
grass = (noise(30) > 1.1).astype(np.float32); grass = cv2.GaussianBlur(grass, (0, 0), 3)[..., None]
dirt = dirt * (1 - 0.6 * grass) + np.array([120, 140, 90], np.float32) * 0.6 * grass * (1 + 0.1 * noise(4)[..., None])
# tối dần về phía xa cho có chiều sâu
dirt *= (0.92 + 0.08 * ((yy - 598) / 196).clip(0, 1))[..., None]
B = B * (1 - Ms[..., None]) + dirt * Ms[..., None]
cv2.imwrite('before.png', np.clip(B, 0, 255).astype(np.uint8)[..., ::-1])
np.save('lotmask.npy', Ms)
