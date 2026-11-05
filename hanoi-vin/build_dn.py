"""Bản đồ dự án Đà Nẵng – Hội An: ranh giới OSM + dự án đang bán (thông tin từ landing page) -> du-an-da-nang.geojson"""
import json, math, os, sys
H = os.path.dirname(os.path.abspath(__file__))
E = {(x['type'], x['id']): x for x in json.load(open(os.path.join(H, 'raw/dn-projects.json')))['elements']}
E.update({(x['type'], x['id']): x for x in json.load(open(os.path.join(H, 'raw/vin.json')))['elements'] if False})
casa = json.load(open(sys.argv[1]))['site']
def ring(t, i): x = E[(t, i)]; return [[p['lon'], p['lat']] for p in x['geometry']]
P = [  # tên, khu vực, nhóm ('ban' = đang phân phối), hình (('osm',t,id) | [[lon,lat]...] | (lat,lon) điểm), thông tin
 dict(name='Lô đất 4 mặt tiền Hoàng Sa', area='Thọ Quang, Sơn Trà', grp='ban', shape=[[108.2498741, 16.0901963], [108.249988, 16.090422], [108.249792, 16.0904882], [108.2496928, 16.0902628]],
      price='190 tỷ (thương lượng)', scale='583,6 m², ngang 27,6 m · tặng GPXD + thiết kế KS 5★ 22 tầng, 94 phòng', headline='View trực diện biển, 4 mặt tiền',
      url='https://hiephoangmt-debug.github.io/hoang-hiep-crm/lo-dat-hoang-sa/', d3='https://hiephoangmt-debug.github.io/hoang-hiep-crm/lo-dat-hoang-sa/'),
 dict(name='Sun Saphia Residence', area='Võ Nguyên Giáp – Nguyễn Đức Thuận – Trường Sa, Ngũ Hành Sơn', grp='ban', shape=(16.0213, 108.257659),
      price='Studio từ ~1,8 tỷ (dự kiến)', scale='Tháp 30 tầng ~114 m, 782 căn', headline='Căn hộ mặt biển đầu tiên của Sun Group tại Đà Nẵng', url='https://www.sun-saphia-residence.com'),
 dict(name='Da Nang Downtown – tháp 408 m', area='Khu Công viên Châu Á cũ, Hải Châu', grp='ban', shape=('osm', 'way', 667422708),
      price='Tham khảo ~60–100 triệu/m² (chưa chính thức)', scale='76,92 ha · tháp 69 tầng ~408 m', headline='Siêu đô thị 80.000 tỷ bên sông Hàn – Sun Group', url='https://www.sun-danangdowntown.com',
      d3='https://hiephoangmt-debug.github.io/hoang-hiep-crm/da-nang-3d/?go=du-an'),
 dict(name='Sun Galaxy Complex', area='Đường Chương Dương, bờ Đông sông Hàn', grp='ban', shape=(16.0490, 108.2345),
      price='Tham khảo 60–148 triệu/m² (chưa chính thức)', scale='Tháp 47 tầng ~183 m', headline='Tháp Accor & Moon Gate bên sông Hàn (vị trí ước lượng)', url='https://www.sun-danangdowntown.com/sun-galaxy-complex'),
 dict(name='Cora Tower', area='Vòng xoay 29/3 – Nguyễn Phước Lan, Hòa Xuân', grp='ban', shape=(16.01877, 108.23043),
      price='1PN+ tầng 15 từ ~3,1 tỷ', scale='2 tòa 25 tầng, ~1.342 căn', headline='Sun Neo City – bên sông, ngay vòng xoay 29/3', url='https://www.cora-tower.com'),
 dict(name='Vinhomes Hải Vân Bay', area='Làng Vân, Hòa Hiệp Bắc, Liên Chiểu', grp='ban', shape=('osm', 'way', 1467747044),
      price='Liền kề từ ~6 tỷ; đơn lập từ ~16–17 tỷ', scale='512 ha · 4 phân khu (ranh trên bản đồ mới là một phần)', headline='Đô thị nghỉ dưỡng biển – Núi, Rừng, Biển, Vịnh', url='https://www.giohangvinhaivanbay.com'),
 dict(name='Casamia Balanca Hội An', area='Võ Chí Công, Hội An Đông', grp='ban', shape=[[lo, la] for la, lo in casa],
      price='Park Home từ ~10,4 tỷ (sau chiết khấu)', scale='31,1 ha · 363 nhà vườn & biệt thự', headline='Biệt thự compound bên sông Cổ Cò', url='https://www.casamia-balanca.com.vn',
      d3='https://hiephoangmt-debug.github.io/hoang-hiep-crm/da-nang-3d/?go=casamia'),
 dict(name='Times Square Đà Nẵng', area='Võ Nguyên Giáp, Sơn Trà', grp='ban', shape=('osm', 'way', 1243633331), scale='2 tháp CT1–CT2', headline='Căn hộ mặt biển Mỹ Khê', url='https://www.timesquare-danang.com'),
 dict(name='Masteri Rivera Đà Nẵng', area='Ven sông Hàn, Hải Châu', grp='ban', shape=('osm', 'way', 1372231112), url='https://www.masteri-riveradanang.com'),
 dict(name='FPT City – FPT Plaza 1·2·3·4', area='KĐT FPT City, Ngũ Hành Sơn', grp='ban', shape=('osm', 'way', 1273496835), scale='KĐT >181 ha · căn hộ FPT Plaza', headline='Đã bàn giao, có sổ', url='https://www.fpt-city.com'),
 dict(name='The Legend Đà Nẵng', area='Hải Châu', grp='khac', shape=('osm', 'way', 1243671483)),
 dict(name='Hiyori Garden Tower', area='Sơn Trà', grp='khac', shape=('osm', 'way', 1546877394)),
 dict(name='Euro Village', area='Sơn Trà', grp='khac', shape=('osm', 'way', 885802848)),
 dict(name='Premier Village Resort', area='Sơn Trà', grp='khac', shape=('osm', 'way', 164333097)),
 dict(name='Newport Diamonds', area='Ngũ Hành Sơn', grp='khac', shape=('osm', 'way', 1542826008)),
 dict(name='Hoiana', area='Duy Xuyên – Hội An', grp='khac', shape=('osm', 'way', 1563742217)),
]
def area_ha(r):
    lat0 = sum(p[1] for p in r) / len(r); kx = 111320 * math.cos(math.radians(lat0)); ky = 110540
    return abs(sum(r[i][0] * kx * r[i - 1][1] * ky - r[i - 1][0] * kx * r[i][1] * ky for i in range(len(r)))) / 2 / 1e4
F = []
for d in P:
    s = d.pop('shape')
    if isinstance(s, tuple) and s[0] == 'osm': s = ring(s[1], s[2])
    if isinstance(s, tuple): g = {'type': 'Point', 'coordinates': [s[1], s[0]]}
    else:
        s = [[round(x, 6), round(y, 6)] for x, y in s]
        if s[0] != s[-1]: s.append(s[0])
        g = {'type': 'Polygon', 'coordinates': [s]}; d['ha'] = round(area_ha(s), 2)
    F.append({'type': 'Feature', 'properties': d, 'geometry': g})
out = sys.argv[2]
json.dump({'type': 'FeatureCollection', 'features': F}, open(out, 'w'), ensure_ascii=False, separators=(',', ':'))
print(len(F), os.path.getsize(out) // 1024, 'KB')
