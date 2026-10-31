import sys, json, gzip
import numpy as np
from PIL import Image, ImageDraw
S = '/tmp/claude-0/-home-user-hoang-hiep-crm/a6a2328e-835a-5cf8-85bd-3dca724fc4bb/scratchpad/'
M = np.array(json.load(open(S + 'casa/affine.json')))  # plan px -> zoom px
N_, W_ = 15.889, 108.366; SC = 60000; K = 0.9613
Z = 2  # phóng
x0, y0, x1, y1 = 250, 200, 860, 720
plan = Image.open('/root/.claude/uploads/a6a2328e-835a-5cf8-85bd-3dca724fc4bb/ac5bd11a-image.jpg').convert('RGB')
Mf = np.r_[M.T, [[0, 0, 1]]]
T = np.array([[Z, 0, -x0 * Z], [0, Z, -y0 * Z], [0, 0, 1]]) @ Mf
Ti = np.linalg.inv(T)
size = ((x1 - x0) * Z, (y1 - y0) * Z)
im = plan.transform(size, Image.AFFINE, tuple(Ti[:2].flatten()), resample=Image.BILINEAR)
d = ImageDraw.Draw(im)
def p(lat, lon): return (((lon - W_) * SC * K - x0) * Z, ((N_ - lat) * SC - y0) * Z)
for name, col, wd in [('water', (0, 255, 255), 2), ('roads', (255, 0, 0), 1)]:
    for e in json.load(gzip.open(f'danang-data/raw/{name}.json.gz'))['elements']:
        gs = [e['geometry']] if 'geometry' in e else [m['geometry'] for m in e.get('members', []) if 'geometry' in m]
        for g in gs:
            g = [q for q in g if q]
            if len(g) < 2 or not any(15.876 < q['lat'] < 15.888 and 108.369 < q['lon'] < 108.382 for q in g): continue
            d.line([p(q['lat'], q['lon']) for q in g], fill=col, width=wd)
im.save(S + 'casa-check.jpg', quality=85); print(im.size)
