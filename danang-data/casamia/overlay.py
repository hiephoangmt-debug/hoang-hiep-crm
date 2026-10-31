import sys, json
import numpy as np
from PIL import Image
# điểm khống chế: (pixel mặt bằng gốc) -> (pixel ảnh zoom OSM)
CP = json.loads(sys.argv[1])
P = np.array([c[0] for c in CP], float); Q = np.array([c[1] for c in CP], float)
A = np.c_[P, np.ones(len(P))]
M, *_ = np.linalg.lstsq(A, Q, rcond=None)  # plan -> zoom (3x2)
print('residual', np.abs(A @ M - Q).max())
S = '/tmp/claude-0/-home-user-hoang-hiep-crm/a6a2328e-835a-5cf8-85bd-3dca724fc4bb/scratchpad/'
base = Image.open(S + 'casa-zoom.png').convert('RGB')
plan = Image.open('/root/.claude/uploads/a6a2328e-835a-5cf8-85bd-3dca724fc4bb/ac5bd11a-image.jpg').convert('RGB')
# PIL cần ánh xạ ngược: zoom -> plan
Mf = np.r_[M.T, [[0, 0, 1]]]; Mi = np.linalg.inv(Mf)
warped = plan.transform(base.size, Image.AFFINE, tuple(Mi[:2].flatten()), resample=Image.BILINEAR)
mask = plan.convert('L').point(lambda v: 255).transform(base.size, Image.AFFINE, tuple(Mi[:2].flatten()))
out = Image.composite(Image.blend(base, warped, 0.55), base, mask)
out.save(S + 'casa-overlay.png')
json.dump(M.tolist(), open(S + 'casa/affine.json', 'w'))
