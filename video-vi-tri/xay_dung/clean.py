# Ảnh "sau hoàn thiện": dọn bãi cỏ dại phía trước tòa nhà thành thảm cỏ cắt gọn + vỉa hè sạch.
import numpy as np, cv2
A = cv2.imread('p1.jpg')[..., ::-1].astype(np.float32)
H, W, _ = A.shape
yy, xx = np.mgrid[0:H, 0:W]
rng = np.random.default_rng(5)
lum = A.mean(2); g = A[..., 1] - np.maximum(A[..., 0], A[..., 2])
# vùng cỏ phía trước (sau đường trước mặt tòa nhà)
reg = np.zeros((H, W), np.float32)
cv2.fillPoly(reg, [np.array([(317, 831), (1215, 831), (1215, 898), (296, 898)], np.int32)], 1)
keep = ((lum < 80) | (g < 8)).astype(np.float32)                 # giữ cây đậm, chòi, lối đi
keep = cv2.dilate(keep, np.ones((3, 3))); keep = cv2.GaussianBlur(keep, (0, 0), 1.2)
m = reg * (1 - keep); m = cv2.GaussianBlur(m, (0, 0), 1.0)
def noise(sc): return cv2.resize(rng.standard_normal((H // sc + 2, W // sc + 2)).astype(np.float32), (W, H), interpolation=cv2.INTER_CUBIC)
# thảm cỏ: xanh đều, vệt máy cắt chéo theo phối cảnh, sáng dần về phía trước
stripe = np.tanh(3 * np.sin((xx - (yy - 831) * 0.55) / 34.0))
lawn = np.array([112, 150, 74], np.float32)[None, None] * (1 + 0.075 * stripe[..., None] + 0.025 * noise(6)[..., None] + 0.02 * rng.standard_normal((H, W, 1)).astype(np.float32))
lawn *= (0.95 + 0.08 * ((yy - 831) / 72).clip(0, 1))[..., None]
# giữ một chút bóng sáng tối gốc cho tự nhiên
shade = cv2.GaussianBlur(lum, (0, 0), 14) / (cv2.GaussianBlur(lum * reg + 1e-3, (0, 0), 60) / (cv2.GaussianBlur(reg, (0, 0), 60) + 1e-3) + 1e-3)
lawn *= np.clip(0.85 + 0.15 * shade, 0.8, 1.15)[..., None]
C = A * (1 - m[..., None]) + lawn * m[..., None]
# vỉa hè sạch giữa đường và thảm cỏ
walk = np.zeros((H, W), np.float32)
cv2.fillPoly(walk, [np.array([(320, 813), (1212, 813), (1213, 832), (317, 832)], np.int32)], 1)
walk *= (1 - (cv2.GaussianBlur((lum < 80).astype(np.float32), (0, 0), 1) * 0.9)); walk = cv2.GaussianBlur(walk, (0, 0), 0.8)
pave = np.array([196, 192, 184], np.float32)[None, None] * (1 + 0.03 * rng.standard_normal((H, W, 1)).astype(np.float32))
pave *= (1 - 0.06 * (((xx - 320) % 22) < 1.5))[..., None]
C = C * (1 - walk[..., None]) + pave * walk[..., None]
cv2.imwrite('after.png', np.clip(C, 0, 255).astype(np.uint8)[..., ::-1])
cv2.imwrite('t/after_front.jpg', np.clip(C, 0, 255).astype(np.uint8)[560:898, :, ::-1])
