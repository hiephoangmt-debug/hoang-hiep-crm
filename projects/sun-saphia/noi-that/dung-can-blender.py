"""Dựng căn hộ từ layout chọn căn (CCL) trong Blender + render Cycles.
Dùng: python room.py <ccl.json> <tầng-key u30|u> <mã căn> <out_dir> [shots] [samples] [WxH]"""
import bpy, bmesh, json, math, sys, os
from mathutils import Vector, Euler

A = sys.argv[sys.argv.index('--') + 1:] if '--' in sys.argv else sys.argv[1:]
CCL = json.load(open(A[0])); KEY, UID, OUT = A[1], A[2], A[3]
SHOTS = A[4].split(',') if len(A) > 4 else ['living', 'living2', 'bed', 'plus', 'top']
SAMPLES = int(A[5]) if len(A) > 5 else 96
SUNROT = float(os.environ.get('SUNROT', '0'))
RW, RH = (int(v) for v in (A[6] if len(A) > 6 else '1080x1350').split('x'))
os.makedirs(OUT, exist_ok=True)
part = CCL[KEY][UID][0]; LAY, M = part[0], part[1]; SP = CCL['spec'][LAY]
SX = abs(M[0]) if abs(M[0]) > 0.01 else abs(M[1])        # giãn theo chiều ngang căn (tầng 30)
H = 2.9                                                    # cao trần thông thủy

bpy.ops.wm.read_factory_settings(use_empty=True)
sc = bpy.context.scene
# toạ độ bản vẽ → toạ độ tháp (u: Bắc→Nam, v: từ mặt biển vào trong) theo ma trận căn → Blender (X = Đông, Y = Bắc)
_LX, _LY = (-M[1], -M[3]), (-M[0], -M[2])
_OY = 0.
def P(x, y): return (_LX[0] * x + _LX[1] * y - M[5], _LY[0] * x + _LY[1] * y - M[4] - _OY)
_OY = sum(P(x, y)[1] for x, y in SP['floor']) / len(SP['floor'])
MIRROR = (_LX[0] * _LY[1] - _LX[1] * _LY[0]) < 0
BX = [P(x, y) for x, y in SP['floor']]; X0, X1 = min(p[0] for p in BX), max(p[0] for p in BX); Y0, Y1 = min(p[1] for p in BX), max(p[1] for p in BX)
def L(vx, vy): return (_LX[0] * vx + _LX[1] * vy, _LY[0] * vx + _LY[1] * vy)

# ---------------- vật liệu ----------------
MATS = {}
def mat(name, col, rough=.5, metal=0., spec=.5, emit=None, estr=0., transm=0., alpha=1., noise=None):
    if name in MATS: return MATS[name]
    m = bpy.data.materials.new(name); m.use_nodes = True; nt = m.node_tree; b = nt.nodes['Principled BSDF']
    b.inputs['Base Color'].default_value = (*col, 1); b.inputs['Roughness'].default_value = rough
    b.inputs['Metallic'].default_value = metal
    if emit: b.inputs['Emission Color'].default_value = (*emit, 1); b.inputs['Emission Strength'].default_value = estr
    if transm: b.inputs['Transmission Weight'].default_value = transm
    if noise:   # vân nhẹ cho vải / đá / sơn
        tx = nt.nodes.new('ShaderNodeTexNoise'); tx.inputs['Scale'].default_value = noise[0]; tx.inputs['Detail'].default_value = 8
        mr = nt.nodes.new('ShaderNodeMix'); mr.data_type = 'RGBA'; mr.inputs['Factor'].default_value = noise[1]
        mr.inputs[6].default_value = (*col, 1); mr.inputs[7].default_value = (*[c * .82 for c in col], 1)
        nt.links.new(tx.outputs['Fac'], mr.inputs['Factor']); nt.links.new(mr.outputs[2], b.inputs['Base Color'])
        bm_ = nt.nodes.new('ShaderNodeBump'); bm_.inputs['Strength'].default_value = noise[2] if len(noise) > 2 else .05
        nt.links.new(tx.outputs['Fac'], bm_.inputs['Height']); nt.links.new(bm_.outputs['Normal'], b.inputs['Normal'])
    MATS[name] = m; return m

def wood_floor():
    m = bpy.data.materials.new('san-go'); m.use_nodes = True; nt = m.node_tree; b = nt.nodes['Principled BSDF']
    tc = nt.nodes.new('ShaderNodeTexCoord'); mp = nt.nodes.new('ShaderNodeMapping'); mp.inputs['Scale'].default_value = (1, 1, 1)
    br = nt.nodes.new('ShaderNodeTexBrick'); br.inputs['Scale'].default_value = 1.0
    br.inputs['Brick Width'].default_value = 1.5; br.inputs['Row Height'].default_value = .2; br.inputs['Mortar Size'].default_value = .0025
    br.inputs['Color1'].default_value = (.56, .38, .23, 1); br.inputs['Color2'].default_value = (.47, .31, .18, 1); br.inputs['Mortar'].default_value = (.25, .16, .1, 1)
    br.offset = .37; br.squash = 1
    wv = nt.nodes.new('ShaderNodeTexNoise'); wv.inputs['Scale'].default_value = 3; wv.inputs['Detail'].default_value = 6; mp.inputs['Scale'].default_value = (1, 1, 1)
    mx = nt.nodes.new('ShaderNodeMix'); mx.data_type = 'RGBA'; mx.blend_type = 'MULTIPLY'; mx.inputs['Factor'].default_value = .35
    nt.links.new(tc.outputs['Object'], mp.inputs['Vector']); nt.links.new(mp.outputs['Vector'], br.inputs['Vector']); nt.links.new(mp.outputs['Vector'], wv.inputs['Vector'])
    nt.links.new(br.outputs['Color'], mx.inputs[6]); nt.links.new(wv.outputs['Color'], mx.inputs[7]); nt.links.new(mx.outputs[2], b.inputs['Base Color'])
    b.inputs['Roughness'].default_value = .38
    bp = nt.nodes.new('ShaderNodeBump'); bp.inputs['Strength'].default_value = .15; nt.links.new(br.outputs['Fac'], bp.inputs['Height']); nt.links.new(bp.outputs['Normal'], b.inputs['Normal'])
    return m

def tile_mat(name, c1, c2, size=.6, rough=.25):
    m = bpy.data.materials.new(name); m.use_nodes = True; nt = m.node_tree; b = nt.nodes['Principled BSDF']
    tc = nt.nodes.new('ShaderNodeTexCoord'); br = nt.nodes.new('ShaderNodeTexBrick'); br.offset = 0
    br.inputs['Scale'].default_value = 1 / size; br.inputs['Brick Width'].default_value = 1; br.inputs['Row Height'].default_value = 1; br.inputs['Mortar Size'].default_value = .02
    br.inputs['Color1'].default_value = (*c1, 1); br.inputs['Color2'].default_value = (*c2, 1); br.inputs['Mortar'].default_value = (.7, .7, .68, 1)
    nt.links.new(tc.outputs['Object'], br.inputs['Vector']); nt.links.new(br.outputs['Color'], b.inputs['Base Color']); b.inputs['Roughness'].default_value = rough
    return m

def glass_mat():
    m = bpy.data.materials.new('kinh'); m.use_nodes = True; nt = m.node_tree; nt.nodes.clear()
    o = nt.nodes.new('ShaderNodeOutputMaterial'); tr = nt.nodes.new('ShaderNodeBsdfTransparent'); tr.inputs['Color'].default_value = (.93, .97, .98, 1)
    gl = nt.nodes.new('ShaderNodeBsdfGlossy'); gl.inputs['Roughness'].default_value = 0
    fr = nt.nodes.new('ShaderNodeFresnel'); fr.inputs['IOR'].default_value = 1.5
    mx = nt.nodes.new('ShaderNodeMixShader'); nt.links.new(fr.outputs[0], mx.inputs[0]); nt.links.new(tr.outputs[0], mx.inputs[1]); nt.links.new(gl.outputs[0], mx.inputs[2])
    nt.links.new(mx.outputs[0], o.inputs['Surface']); m.blend_method = 'BLEND'; return m

FLOOR = wood_floor()
WALL = mat('tuong', (.94, .9, .84), .9, noise=(40, .08, .02))
EXT = mat('tuong-ngoai', (.9, .88, .84), .9)
CEIL = mat('tran', (.96, .95, .93), .95)
TILE = tile_mat('gach-wc', (.82, .8, .76), (.79, .77, .73), .6)
DECK = tile_mat('gach-ban-cong', (.62, .58, .52), (.58, .54, .48), .6, .6)
GLASS = glass_mat()
ALU = mat('nhom', (.12, .13, .14), .35, .8)
OAK = mat('go-soi', (.55, .4, .26), .45, noise=(18, .3, .02))
WALNUT = mat('go-oc-cho', (.28, .17, .1), .4, noise=(18, .3, .02))
WHITE = mat('trang', (.92, .92, .9), .3)
CER = mat('su', (.97, .97, .96), .08)
FAB = mat('vai-be', (.72, .67, .6), .95, noise=(120, .25, .08))
FAB2 = mat('vai-xanh', (.2, .32, .36), .95, noise=(120, .25, .08))
CHAIRF = mat('vai-ghe', (.62, .58, .52), .95, noise=(120, .25, .08))
FAB3 = mat('vai-dat-nung', (.62, .32, .2), .95, noise=(120, .25, .08))
LINEN = mat('ga-trang', (.95, .94, .92), .95, noise=(60, .15, .1))
RUG = mat('tham', (.68, .64, .58), 1., noise=(200, .4, .15))
STONE = mat('da-mat-bep', (.9, .89, .87), .18, noise=(8, .35, .0))
CAB = mat('tu-bep', (.88, .86, .82), .4)
STEEL = mat('inox', (.75, .76, .77), .25, .9)
BLACK = mat('den-bong', (.02, .02, .025), .08)
LEAF = mat('la', (.12, .3, .1), .7, noise=(30, .4, .1))
POT = mat('chau', (.78, .74, .68), .8)
SHEER = mat('rem-voan', (.97, .96, .93), 1., transm=.65)
DRAPE = mat('rem-day', (.6, .55, .48), 1., noise=(150, .2, .1))
LAMP = mat('den', (1, .9, .75), .5, emit=(1, .82, .6), estr=6)
DOWN = mat('den-am-tran', (1, 1, 1), .5, emit=(1, .9, .78), estr=25)
ART1 = mat('tranh1', (.75, .55, .35), .7, noise=(3, .8, .0)); ART2 = mat('tranh2', (.35, .5, .55), .7, noise=(2.5, .8, .0))

# ---------------- dựng hình ----------------
def box(cx, cy, z0, sx, sy, sz, m, rot=0., bevel=.012, parent=None, name='o'):
    bpy.ops.mesh.primitive_cube_add(size=1)
    o = bpy.context.object; o.name = name; o.scale = (max(sx, .003), max(sy, .003), max(sz, .003)); o.location = (cx, cy, z0 + sz / 2); o.rotation_euler[2] = rot
    bpy.ops.object.transform_apply(scale=True)
    if bevel and min(sx, sy, sz) > bevel * 2.5:
        bv = o.modifiers.new('bv', 'BEVEL'); bv.width = bevel; bv.segments = 3; bv.limit_method = 'ANGLE'
    o.data.materials.append(m)
    if parent: o.parent = parent
    for p in o.data.polygons: p.use_smooth = True
    return o

def cyl(cx, cy, z0, r, h, m, parent=None, verts=32):
    bpy.ops.mesh.primitive_cylinder_add(radius=r, depth=h, vertices=verts, location=(cx, cy, z0 + h / 2))
    o = bpy.context.object; o.data.materials.append(m)
    if parent: o.parent = parent
    return o

def sphere(cx, cy, cz, r, m, sz=1., parent=None):
    bpy.ops.mesh.primitive_ico_sphere_add(radius=r, subdivisions=3, location=(cx, cy, cz)); o = bpy.context.object
    o.scale[2] = sz; o.data.materials.append(m)
    for p in o.data.polygons: p.use_smooth = True
    if parent: o.parent = parent
    return o

def slab(poly, z, m, th=.02):
    """Tấm phẳng hình chữ nhật (dựng bằng khối hộp): poly = 4 góc, z = mặt trên"""
    xs = [p[0] for p in poly]; ys = [p[1] for p in poly]; t = max(th, .002)
    o = box((min(xs) + max(xs)) / 2, (min(ys) + max(ys)) / 2, z - t, max(xs) - min(xs), max(ys) - min(ys), t, m, 0, 0, name='slab'); return o

# sàn + trần + vùng WC / ban công
W, D = SP['W'], SP['D']
pts = [P(x, y) for x, y in SP['floor']]
pad = .25
slab([(X0 - pad, Y0 - pad), (X1 + pad, Y1 + pad)] * 2, 0, FLOOR, .05)
slab([(X0 - pad, Y0 - pad), (X1 + pad, Y1 + pad)] * 2, H + .2, CEIL, .2).name = 'tran'
for z in SP.get('zones', []):
    a, b = P(z[1], z[2]), P(z[3], z[4])
    slab([(a[0], a[1]), (b[0], a[1]), (b[0], b[1]), (a[0], b[1])], .006, TILE if z[0] == 'wc' else DECK, .007)
# nền tầng dưới, cạnh sàn ban công
box(-20, 0, -110, 40.2, 80, 109.94, EXT, 0, 0, name='than-thap')   # thân tháp phía dưới

def wall_seg(s):
    x0, y0, x1, y1, k = s[0], s[1], s[2], s[3], s[4]; gaps = s[5] if len(s) > 5 else []
    a, b = Vector(P(x0, y0)), Vector(P(x1, y1)); L = (b - a).length; u = (b - a) / L; ang = math.atan2(u.y, u.x)
    Lp = math.hypot(x1 - x0, y1 - y0); kk = L / Lp      # tỷ lệ chiều dài thật / bản vẽ
    cuts = [0]; [cuts.extend([g[0] * kk, g[1] * kk]) for g in gaps]; cuts.append(L)
    def piece(t0, t1, z0, h, th, m, name='tuong'):
        if t1 - t0 < .01: return
        c = a + u * ((t0 + t1) / 2); return box(c.x, c.y, z0, t1 - t0, th, h, m, ang, 0, name=name)
    for i in range(0, len(cuts), 2):
        t0, t1 = cuts[i], cuts[i + 1]
        e0 = .1 if t0 == 0 else 0; e1 = .1 if t1 == L else 0      # chồng mí ở góc tường, không lọt sáng
        if k == 'x': piece(t0 - e0, t1 + e1, 0, H, .2, EXT)
        elif k == 'w': piece(t0 - e0 * .6, t1 + e1 * .6, 0, H, .12, WALL)
        elif k == 'g':
            piece(t0, t1, 0, H - .06, .012, GLASS, 'kinh'); piece(t0, t1, H - .08, .08, .07, ALU); piece(t0, t1, 0, .05, .07, ALU)
            n = max(1, round((t1 - t0) / 1.3))
            for j in range(n + 1): t = t0 + (t1 - t0) * j / n; piece(t - .025, t + .025, 0, H, .07, ALU)
            if t1 - t0 > 1.4:   # rèm voan 2 đầu
                for (r0, r1) in ((t0 + .05, t0 + .55), (t1 - .55, t1 - .05)):
                    for c2 in range(6):
                        t = r0 + (c2 + .5) * (r1 - r0) / 6; cc = a + u * t - Vector((-u.y, u.x)) * (.12 + .03 * (c2 % 2))
                        box(cc.x, cc.y, .03, .1, .025, H - .12, SHEER, ang, 0, name='rem')
        elif k == 'r':
            piece(t0, t1, 0, 1.1, .015, GLASS, 'lan-can'); piece(t0, t1, 1.08, .05, .06, ALU)
    for g in gaps:
        t0, t1 = g[0] * kk, g[1] * kk
        piece(t0, t1, 2.15, H - 2.15, .2 if k == 'x' else .12, EXT if k == 'x' else WALL)
        if k == 'x':   # cửa vào căn: cánh gỗ đóng + khuôn
            piece(t0, t1, 0, 2.15, .05, WALNUT, 'cua'); piece(t0, t0 + .05, 0, 2.2, .22, OAK); piece(t1 - .05, t1, 0, 2.2, .22, OAK)
        else:          # cửa phòng: khuôn + cánh mở 90°
            piece(t0, t0 + .04, 0, 2.15, .14, OAK); piece(t1 - .04, t1, 0, 2.15, .14, OAK)
            nrm = Vector((-u.y, u.x)) * (g[2] if len(g) > 2 else 1); hinge = a + u * t0; w_ = t1 - t0 - .08
            c = hinge + u * .04 + nrm * (w_ / 2); box(c.x, c.y, 0, .04, w_, 2.1, OAK, ang, 0, name='canh-cua')

for s in SP['segs']: wall_seg(s)
for bl in SP.get('blocks', []):
    a, b = P(bl[0], bl[1]), P(bl[2], bl[3]); box((a[0] + b[0]) / 2, (a[1] + b[1]) / 2, 0, abs(b[0] - a[0]), abs(b[1] - a[1]), H, WALL)
def panel(p0, p1, z0, h, th, m):   # tấm thẳng giữa 2 điểm bản vẽ
    a, b = Vector(P(*p0)), Vector(P(*p1)); c = (a + b) / 2; u = b - a
    return box(c.x, c.y, z0, u.length, th, h, m, math.atan2(u.y, u.x), 0)
for s3 in SP.get('shw', []):   # khu tắm đứng: sàn gạch + vách kính
    x0, y0, x1, y1, d = s3[:5]; a, b = P(x0, y0), P(x1, y1)
    slab([a, b] * 2, .021, TILE, .015)
    e = {'r': ((x1, y0), (x1, y1)), 'l': ((x0, y0), (x0, y1)), 'u': ((x0, y0), (x1, y0)), 'd': ((x0, y1), (x1, y1))}[d]
    panel(e[0], e[1], 0, 2.0, .012, GLASS); c = P((x0 + x1) / 2, (y0 + y1) / 2); cyl(c[0], c[1], 2.05, .12, .02, STEEL)

# ---------------- nội thất theo bản vẽ ----------------
DIRV = {'u': (0, -1), 'd': (0, 1), 'l': (-1, 0), 'r': (1, 0)}
def frame(x, y, face):
    v = DIRV.get(face, (0, 1)); fx, fy = L(*v)                     # hướng mặt trước (Blender)
    e = bpy.data.objects.new('noi-that', None); sc.collection.objects.link(e)
    e.location = (*P(x, y), 0); e.rotation_euler[2] = math.atan2(fy, fx) - math.pi / 2
    if MIRROR: e.scale[0] = -1                                     # căn lật so với bản vẽ mẫu
    return e
art_i = [0]
for it in SP['items']:
    k, x, y, w = it[0], it[1], it[2], it[3]; d = it[4] if len(it) > 4 and isinstance(it[4], (int, float)) else w
    face = it[5] if len(it) > 5 and isinstance(it[5], str) else 'd'; ex = it[6] if len(it) > 6 and isinstance(it[6], dict) else (it[5] if len(it) > 5 and isinstance(it[5], dict) else {})
    o = frame(x, y, face); hw, hd = w / 2, d / 2          # trong khung: X = bề ngang, +Y = mặt trước, lưng ở -Y
    if k == 'bed':
        box(0, 0, 0, w + .1, d + .05, .32, WALNUT, parent=o); box(0, .03, .32, w - .02, d - .12, .24, LINEN, bevel=.06, parent=o)
        box(0, d * .14, .5, w + .04, d * .66, .09, FAB, bevel=.04, parent=o); box(0, d * .38, .58, w + .06, .4, .03, FAB3, bevel=.01, parent=o)
        box(0, -hd + .03, 0, w + .3, .1, 1.15, FAB2, bevel=.03, parent=o)
        for sd in (-1, 1): box(sd * w * .24, -hd + .32, .52, w * .42, .34, .14, LINEN, bevel=.06, parent=o)
        box(0, 0, -.001, w + 1.2, d + .4, .012, RUG, 0, 0, parent=o)
        e2 = box(0, -hd - .005, 1.45, 1.0, .03, .6, ART1, 0, .005, parent=o)
    elif k == 'ns':
        box(0, 0, 0, w, d, .5, OAK, parent=o); cyl(0, -.05, .5, .07, .32, WHITE, parent=o); cyl(0, -.05, .82, .14, .2, LAMP, parent=o)
    elif k in ('sofa', 'arm', 'daybed'):
        arms = k != 'daybed'; aw = .16 if arms else 0
        box(0, 0, .08, w, d, .32, FAB, parent=o); box(0, -hd + .1, .4, w, .2, .45, FAB, bevel=.05, parent=o)
        if arms:
            for sd in (-1, 1): box(sd * (hw - .08), 0, .4, .16, d, .2, FAB, bevel=.05, parent=o)
        n = 1 if w < 1.2 else (2 if w < 2.2 else 3); cw = (w - 2 * aw) / n
        for i in range(n): box(-hw + aw + cw * (i + .5), .06, .4, cw - .02, d - .28, .13, FAB, bevel=.05, parent=o); box(-hw + aw + cw * (i + .5), -hd + .3, .52, cw - .04, .16, .38, FAB, bevel=.06, parent=o)
        for sd in (-1, 1): box(sd * (hw - aw - .25), -hd + .44, .55, .4, .12, .38, FAB3 if sd < 0 else FAB2, bevel=.05, parent=o)
        for sx_ in (-1, 1):
            for sy_ in (-1, 1): box(sx_ * (hw - .06), sy_ * (hd - .06), 0, .04, .04, .08, WALNUT, 0, 0, parent=o)
        if k == 'sofa': box(0, .9, -.001, max(w, 2.0) + .2, 1.8, .012, RUG, 0, 0, parent=o); box(0, -hd - .02, 1.3, 1.2, .03, .75, ART2, 0, .005, parent=o)
    elif k == 'rtab':
        h = ex.get('h', .42); cyl(0, 0, h - .03, hw, .03, OAK, parent=o, verts=48); cyl(0, 0, 0, .05, h - .03, BLACK, parent=o); cyl(0, 0, 0, hw * .5, .02, BLACK, parent=o)
    elif k == 'tv':
        box(0, 0, .18, w, d * .9, .36, WALNUT, parent=o); box(0, -hd + .03, 1.0, w * .78, .04, w * .78 * .5625, BLACK, 0, .005, parent=o)
        box(0, -hd - .01, .54, w + .2, .025, 1.9, OAK, 0, 0, parent=o)     # mảng ốp gỗ sau TV
    elif k == 'kit':
        box(0, 0, .1, w, d, .78, CAB, .0, .004, parent=o); box(0, 0, 0, w - .02, d - .06, .1, BLACK, 0, 0, parent=o)
        box(0, .01, .88, w + .02, d + .02, .03, STONE, 0, .003, parent=o); box(0, -hd + .01, .91, w, .015, .62, STONE, 0, 0, parent=o)
        if not ex.get('noup'): box(0, -hd + .18, 1.53, w, .35, .72, CAB, 0, .004, parent=o)
        if ex.get('hob') is not None:
            hx = -hw + ex['hob'] * w; box(hx, 0, .91, .58, .5, .006, BLACK, 0, 0, parent=o)
            if not ex.get('noup'): box(hx, -hd + .2, 1.45, .6, .4, .08, STEEL, 0, 0, parent=o)
        if ex.get('sink') is not None:
            sxp = -hw + ex['sink'] * w; box(sxp, .02, .78, .55, .42, .13, STEEL, 0, 0, parent=o); cyl(sxp, -hd + .1, .91, .015, .3, STEEL, parent=o)
        for i in range(max(1, int(w / .6))): box(-hw + (i + .5) * w / max(1, int(w / .6)), hd + .005, .8, .2, .015, .012, STEEL, 0, 0, parent=o)
    elif k == 'fridge':
        box(0, 0, 0, w - .02, d - .02, 1.85, STEEL, parent=o); box(0, hd - .01, .9, .02, .02, .5, BLACK, 0, 0, parent=o)
    elif k == 'wc':
        box(0, .08, 0, .36, .5, .4, CER, bevel=.08, parent=o); box(0, -hd + .1, .35, .4, .18, .4, CER, bevel=.04, parent=o)
    elif k in ('van', 'wash'):
        box(0, 0, .35 if k == 'van' else 0, w, d, .5 if k == 'van' else .85, OAK if k == 'van' else WHITE, parent=o)
        box(0, .02, .85, w * .55, d * .7, .12, CER, bevel=.04, parent=o); box(0, -hd + .02, 1.1, w * .9, .02, .8, GLASS, 0, 0, parent=o)
        box(0, -hd + .03, 1.92, w * .8, .04, .04, LAMP, 0, 0, parent=o)
    elif k == 'ward':
        box(0, 0, 0, w, d, 2.4, OAK, .0, .004, parent=o); n = max(2, round(w / .5))
        for i in range(1, n): box(-hw + w * i / n, hd + .002, .05, .006, .006, 2.3, WALNUT, 0, 0, parent=o)
        for i in range(n): box(-hw + w * (i + .5) / n + (.18 if i % 2 else -.18), hd + .015, 1.0, .02, .025, .35, STEEL, 0, 0, parent=o)
    elif k == 'dtab':
        box(0, 0, .72, w, d, .035, OAK, parent=o); [box(sx_ * (hw - .08), sy_ * (hd - .08), 0, .05, .05, .72, BLACK, 0, 0, parent=o) for sx_ in (-1, 1) for sy_ in (-1, 1)]
        cols = [0] if w < 1.1 else [-w / 4, w / 4]
        for sd in (-1, 1):
            for cx_ in cols:
                box(cx_, sd * (hd + .22), .3, .44, .44, .16, CHAIRF, bevel=.03, parent=o); box(cx_, sd * (hd + .42), .46, .42, .04, .4, OAK, bevel=.01, parent=o)
                [box(cx_ + ax * .19, sd * (hd + .22) + ay * .19, 0, .03, .03, .3, WALNUT, 0, 0, parent=o) for ax in (-1, 1) for ay in (-1, 1)]
        cyl(0, 0, 1.75, .22, .18, LAMP, parent=o); cyl(0, 0, 1.93, .006, H - 1.93, BLACK, parent=o)
    elif k == 'desk':
        box(0, 0, .72, w, d, .03, OAK, parent=o); box(-hw + .03, 0, 0, .04, d - .05, .72, BLACK, 0, 0, parent=o); box(hw - .03, 0, 0, .04, d - .05, .72, BLACK, 0, 0, parent=o)
        box(.2, -.05, .75, .5, .3, .02, BLACK, 0, 0, parent=o); box(-.3, -.12, .75, .12, .12, .35, LAMP, 0, .01, parent=o)
    elif k in ('chair', 'stool'):
        box(0, 0, 0, w, d, .46, FAB2 if k == 'chair' else OAK, bevel=.03, parent=o)
        if k == 'chair': box(0, -hd + .03, .46, w, .05, .42, FAB2, bevel=.02, parent=o)
    elif k == 'cab':
        box(0, 0, .1, w, d, .55, OAK, .0, .004, parent=o); sphere(-w * .25, 0, .8, .12, LEAF, 1.3, parent=o); cyl(w * .2, 0, .65, .05, .25, WHITE, parent=o)
    elif k == 'plant':
        cyl(0, 0, 0, .17, .42, POT, parent=o)
        for i in range(7): sphere(.12 * math.cos(i * .9), .12 * math.sin(i * .9), .62 + .12 * (i % 3), w * .32, LEAF, 1.4, parent=o)
    elif k == 'ac':
        box(0, 0, 0, w, d, .6, WHITE, parent=o)
    else:
        box(0, 0, 0, w, d, .5, CAB, parent=o)

# đèn âm trần (lưới ~1,4 m) – vừa thấy đèn, vừa là nguồn sáng
nx_, ny_ = int((X1 - X0) / 1.4), int((Y1 - Y0) / 1.4)
for gx in range(1, nx_ + 1):
    for gy in range(1, ny_ + 1):
        cyl(X0 + gx * (X1 - X0) / (nx_ + 1), Y0 + gy * (Y1 - Y0) / (ny_ + 1), H - .012, .05, .01, DOWN, verts=16)

# ---------------- bên ngoài: biển + dải resort + bãi cát theo khoảng cách thật ----------------
FLOOR_H = 108.0                                    # sàn tầng 30 ≈ 108 m
def ground(y0, y1, m, z=-FLOOR_H, x0=-3000, x1=3000): slab([(x0, y0), (x1, y0), (x1, y1), (x0, y1)], z, m, .5)
SEA = mat('bien', (.03, .22, .3), .05, .0); SAND = mat('cat', (.85, .78, .62), .9); GRASS = mat('dat-resort', (.32, .42, .24), .9, noise=(.05, .5, 0)); ROADM = mat('duong', (.18, .18, .19), .8)
def strip(x0, x1, m, z=-FLOOR_H, y0=-3000, y1=3000): slab([(x0, y0), (x1, y1)] * 2, z, m, .5)
strip(0, 30, GRASS); strip(30, 58, ROADM); strip(58, 330, GRASS); strip(330, 392, SAND); strip(392, 20000, SEA, -FLOOR_H + .2, -20000, 20000); strip(-3000, -40, GRASS)
import random; random.seed(3)
for i in range(160):     # khối resort thấp tầng, cây dừa trên dải đất ven biển
    y = random.uniform(-500, 500); x = random.uniform(70, 320)
    if random.random() < .35: box(x, y, -FLOOR_H, random.uniform(10, 26), random.uniform(8, 16), random.uniform(5, 14), WHITE, 0, 0)
    else: sphere(x, y, -FLOOR_H + random.uniform(6, 11), random.uniform(2.5, 4.5), LEAF, .8)

# bầu trời + nắng buổi sáng từ phía biển
wd = bpy.data.worlds.new('troi'); sc.world = wd; wd.use_nodes = True; nt = wd.node_tree
sky = nt.nodes.new('ShaderNodeTexSky'); sky.sky_type = 'NISHITA'; sky.sun_elevation = math.radians(32); sky.sun_rotation = math.radians(SUNROT); sky.altitude = 110
sky.air_density = 1.2; sky.dust_density = 1.6
nt.links.new(sky.outputs['Color'], nt.nodes['Background'].inputs['Color']); nt.nodes['Background'].inputs['Strength'].default_value = .35
sun = bpy.data.lights.new('nang', 'SUN'); sun.energy = 3.2; sun.angle = math.radians(1.2); so = bpy.data.objects.new('nang', sun); sc.collection.objects.link(so)
so.rotation_euler = (math.radians(58), 0, math.radians(90))      # nắng sáng từ phía biển (Đông)
# ánh sáng tràn qua cửa kính (portal) cho đỡ nhiễu
for s in SP['segs']:
    if s[4] in ('g', 'r'):
        a, b = Vector(P(s[0], s[1])), Vector(P(s[2], s[3])); c = (a + b) / 2; Lg = (b - a).length
        ld = bpy.data.lights.new('portal', 'AREA'); ld.shape = 'RECTANGLE'; ld.size = Lg; ld.size_y = H; ld.cycles.is_portal = True
        lo = bpy.data.objects.new('portal', ld); sc.collection.objects.link(lo)
        cen = Vector(((X0 + X1) / 2, (Y0 + Y1) / 2)); nrm = Vector((-(b - a).y, (b - a).x)).normalized()
        if nrm.dot(cen - c) < 0: nrm = -nrm                     # pháp tuyến hướng vào trong căn
        lo.location = (c.x - nrm.x * .1, c.y - nrm.y * .1, H / 2)
        lo.rotation_euler = Vector((-nrm.x, -nrm.y, 0)).to_track_quat('Z', 'X').to_euler()

# ---------------- render ----------------
sc.render.engine = 'CYCLES'; cy = sc.cycles; cy.device = 'CPU'; cy.samples = SAMPLES; cy.use_denoising = True
try: cy.denoiser = 'OPENIMAGEDENOISE'
except Exception: pass
cy.max_bounces = 8; cy.diffuse_bounces = 4; cy.glossy_bounces = 3; cy.transparent_max_bounces = 12; cy.caustics_reflective = False; cy.caustics_refractive = False
cy.sample_clamp_indirect = 4; cy.light_sampling_threshold = .01
sc.view_settings.view_transform = 'AgX'; sc.view_settings.look = 'AgX - Medium High Contrast'; sc.view_settings.exposure = .6
sc.render.resolution_x, sc.render.resolution_y = RW, RH; sc.render.image_settings.file_format = 'PNG'

cam_d = bpy.data.cameras.new('cam'); cam = bpy.data.objects.new('cam', cam_d); sc.collection.objects.link(cam); sc.camera = cam
cam_d.sensor_width = 36; cam_d.clip_start = .05; cam_d.clip_end = 30000
def shoot(name, eye, look, lens=16, z=1.35, shift_y=0., ortho=None):
    if ortho:
        cam_d.type = 'ORTHO'; cam_d.ortho_scale = ortho; cam.location = (*eye, 9); cam.rotation_euler = (0, 0, 0)
    else:
        cam_d.type = 'PERSP'; cam_d.lens = lens; cam_d.shift_y = shift_y
        ex, ey = P(*eye); lx, ly = P(*look); cam.location = (ex, ey, z)
        cam.rotation_euler = (math.radians(90), 0, math.atan2(ly - ey, lx - ex) - math.pi / 2)
    sc.render.filepath = os.path.join(OUT, name + '.png'); bpy.ops.render.render(write_still=True); print('xong', name, flush=True)

SH = {   # điểm đứng / điểm nhìn theo toạ độ bản vẽ căn
 'living':  ((4.25, 1.0), (4.5, 9.5), 14, 1.3, .0),
 'living2': ((4.0, 7.35), (5.6, 1.0), 14, 1.3, .0),
 'bed':     ((2.75, 5.35), (0.5, 8.7), 14, 1.3, .0),
 'plus':    ((1.15, 4.25), (2.7, 1.75), 14, 1.3, .0),
}
for s in SHOTS:
    if s == 'top':
        bpy.data.objects['tran'].hide_render = True   # bỏ trần để nhìn từ trên xuống
        for o in bpy.data.objects:
            if o.type == 'MESH' and o.data.vertices and min(v.co.z for v in o.data.vertices) + o.location.z > H - .1: o.hide_render = True
        if X1 - X0 > Y1 - Y0: sc.render.resolution_x, sc.render.resolution_y = max(RW, RH), round(max(RW, RH) * (Y1 - Y0 + 1) / (X1 - X0 + 1))
        sc.view_settings.exposure = .1
        shoot('top', ((X0 + X1) / 2, (Y0 + Y1) / 2), None, ortho=max(X1 - X0, Y1 - Y0) + 1.0)
    elif s in SH:
        e, l, lens, z, sy = SH[s]; shoot(s, e, l, lens, z, sy)

# ---------------- video 9:16: đi từ cửa vào ra ban công rồi quay sang phòng ngủ ----------------
if 'video' in SHOTS:
    sc.render.resolution_x, sc.render.resolution_y = int(os.environ.get('VW', '540')), int(os.environ.get('VH', '960'))
    sc.view_settings.exposure = .6; cam_d.type = 'PERSP'; cam_d.lens = 14; cam_d.shift_y = 0
    PATH = [((4.3, .9), (4.5, 9.5)), ((4.5, 3.4), (4.6, 9.5)), ((4.6, 5.6), (4.8, 9.5)), ((4.7, 6.3), (6.4, 3.6)), ((4.7, 6.7), (4.6, 9.6))]   # (đứng, nhìn) bản vẽ
    FPS = 24; SEG = int(os.environ.get('SEGF', '36')); sc.render.fps = FPS
    sc.frame_start = 1; sc.frame_end = SEG * (len(PATH) - 1) + 1
    def lerp(a, b, t): return (a[0] + (b[0] - a[0]) * t, a[1] + (b[1] - a[1]) * t)
    prev = None
    for f in range(sc.frame_start, sc.frame_end + 1):
        i = min((f - 1) // SEG, len(PATH) - 2); t = ((f - 1) - i * SEG) / SEG; t = t * t * (3 - 2 * t)
        e = P(*lerp(PATH[i][0], PATH[i + 1][0], t)); l = P(*lerp(PATH[i][1], PATH[i + 1][1], t))
        yaw = math.atan2(l[1] - e[1], l[0] - e[0]) - math.pi / 2
        if prev is not None:
            while yaw - prev > math.pi: yaw -= 2 * math.pi
            while yaw - prev < -math.pi: yaw += 2 * math.pi
        prev = yaw; cam.location = (e[0], e[1], 1.4); cam.rotation_euler = (math.radians(90), 0, yaw)
        cam.keyframe_insert('location', frame=f); cam.keyframe_insert('rotation_euler', frame=f)
    sc.render.filepath = os.path.join(OUT, 'vid', 'f'); os.makedirs(os.path.join(OUT, 'vid'), exist_ok=True)
    bpy.ops.render.render(animation=True); print('xong video', flush=True)
