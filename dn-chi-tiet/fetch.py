"""Khu trung tâm sông Hàn: nhà (Overture Maps), ảnh vệ tinh (Esri World Imagery), độ cao (Terrarium) -> dn-chi-tiet/raw/
Chạy trên GitHub Actions."""
import io, json, math, os, subprocess, sys, time, urllib.request
from PIL import Image
OUT = os.path.join(os.path.dirname(__file__), 'raw'); os.makedirs(OUT, exist_ok=True)
S, W, N, E = 16.0365, 108.2140, 16.0665, 108.2420
# 1) nhà Overture (dùng CLI chính thức: tự chọn bản phát hành mới nhất)
subprocess.check_call(['overturemaps', 'download', f'--bbox={W},{S},{E},{N}', '-f', 'geojson', '--type=building', '-o', os.path.join(OUT, 'buildings.geojson')])
print('buildings', os.path.getsize(os.path.join(OUT, 'buildings.geojson')) // 1024, 'KB')
# 2) ảnh vệ tinh z17 ghép thành 1 ảnh
Z = 17
def tx(lon): return (lon + 180) / 360 * 2 ** Z
def ty(lat): return (1 - math.asinh(math.tan(math.radians(lat))) / math.pi) / 2 * 2 ** Z
x0, x1, y0, y1 = int(tx(W)), int(tx(E)), int(ty(N)), int(ty(S))
img = Image.new('RGB', ((x1 - x0 + 1) * 256, (y1 - y0 + 1) * 256))
for x in range(x0, x1 + 1):
    for y in range(y0, y1 + 1):
        for a in range(4):
            try:
                b = urllib.request.urlopen(urllib.request.Request(f'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{Z}/{y}/{x}', headers={'User-Agent': 'hoang-hiep-crm'}), timeout=60).read()
                img.paste(Image.open(io.BytesIO(b)).convert('RGB'), ((x - x0) * 256, (y - y0) * 256)); break
            except Exception as e:
                print('tile', x, y, e); time.sleep(3)
# cắt đúng khung toạ độ
L, T = (tx(W) - x0) * 256, (ty(N) - y0) * 256; R, B = (tx(E) - x0) * 256, (ty(S) - y0) * 256
img = img.crop((round(L), round(T), round(R), round(B)))
img.save(os.path.join(OUT, 'sat.jpg'), quality=82, optimize=True)
json.dump({'bbox': [S, W, N, E], 'z': Z, 'size': img.size}, open(os.path.join(OUT, 'sat.json'), 'w'))
print('sat', img.size)
