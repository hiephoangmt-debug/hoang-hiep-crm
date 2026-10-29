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
PARTS = CCL[KEY][UID]                                      # 1 căn có thể ghép nhiều phần (VD 3006 = studio + 1PN+1)
def setpart(pt):
    global LAY, M, SP, _LX, _LY, MIRROR, W, D
    LAY, M = pt[0], pt[1]; SP = CCL['spec'][LAY]; W, D = SP['W'], SP['D']
    _LX, _LY = (-M[1], -M[3]), (-M[0], -M[2]); MIRROR = (_LX[0] * _LY[1] - _LX[1] * _LY[0]) < 0
H = 2.9                                                    # cao trần thông thủy

bpy.ops.wm.read_factory_settings(use_empty=True)
sc = bpy.context.scene
# toạ độ bản vẽ → toạ độ tháp (u: Bắc→Nam, v: từ mặt biển vào trong) theo ma trận căn → Blender (X = Đông, Y = Bắc)
_OY = 0.
def P(x, y): return (_LX[0] * x + _LX[1] * y - M[5], _LY[0] * x + _LY[1] * y - M[4] - _OY)
BX = []
for _pt in PARTS: setpart(_pt); BX += [P(x, y) for x, y in SP['floor']]
_OY = sum(p[1] for p in BX) / len(BX); BX = [(p[0], p[1] - _OY) for p in BX]
X0, X1 = min(p[0] for p in BX), max(p[0] for p in BX); Y0, Y1 = min(p[1] for p in BX), max(p[1] for p in BX)
MAINP = max(PARTS, key=lambda pt: CCL['spec'][pt[0]]['W'] * CCL['spec'][pt[0]]['D'] * max(abs(pt[1][0]), abs(pt[1][1])))
setpart(MAINP)
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

def glass_mat(name='kinh', ior=1.5):
    m = bpy.data.materials.new(name); m.use_nodes = True; nt = m.node_tree; nt.nodes.clear()
    o = nt.nodes.new('ShaderNodeOutputMaterial'); tr = nt.nodes.new('ShaderNodeBsdfTransparent'); tr.inputs['Color'].default_value = (.93, .97, .98, 1)
    gl = nt.nodes.new('ShaderNodeBsdfGlossy'); gl.inputs['Roughness'].default_value = 0
    fr = nt.nodes.new('ShaderNodeFresnel'); fr.inputs['IOR'].default_value = ior
    mx = nt.nodes.new('ShaderNodeMixShader'); nt.links.new(fr.outputs[0], mx.inputs[0]); nt.links.new(tr.outputs[0], mx.inputs[1]); nt.links.new(gl.outputs[0], mx.inputs[2])
    nt.links.new(mx.outputs[0], o.inputs['Surface']); m.blend_method = 'BLEND'; return m

FLOOR = wood_floor()
WALL = mat('tuong', (.96, .94, .9), .9, noise=(40, .08, .02))
EXT = mat('tuong-ngoai', (.9, .88, .84), .9)
CEIL = mat('tran', (.96, .95, .93), .95)
TILE = tile_mat('gach-wc', (.82, .8, .76), (.79, .77, .73), .6)
DECK = tile_mat('gach-ban-cong', (.62, .58, .52), (.58, .54, .48), .6, .6)
GLASS = glass_mat(); RGLASS = glass_mat('kinh-lan-can', 1.08)
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
DOWN = mat('den-am-tran', (1, 1, 1), .5, emit=(1, .9, .78), estr=40)
ART1 = mat('tranh1', (.75, .55, .35), .7, noise=(3, .8, .0)); ART2 = mat('tranh2', (.35, .5, .55), .7, noise=(2.5, .8, .0))
LUX = os.environ.get('STYLE', '') == 'lux'
TOUR = 'tour' in SHOTS                           # video đi tham quan: mở cửa vào, mở cửa kính ra lô-gia, dựng hành lang      # phong cách khách sạn 5–6 sao
BRASS = STEEL
def marble(name, base, vein, tile=(1.2, .6), rough=.06):
    m = bpy.data.materials.new(name); m.use_nodes = True; nt = m.node_tree; b = nt.nodes['Principled BSDF']
    tc = nt.nodes.new('ShaderNodeTexCoord'); br = nt.nodes.new('ShaderNodeTexBrick'); br.offset = .5
    br.inputs['Scale'].default_value = 1 / tile[0]; br.inputs['Brick Width'].default_value = 1; br.inputs['Row Height'].default_value = tile[1] / tile[0]; br.inputs['Mortar Size'].default_value = .0015
    br.inputs['Color1'].default_value = (*base, 1); br.inputs['Color2'].default_value = (*[c * .985 for c in base], 1); br.inputs['Mortar'].default_value = (.7, .68, .64, 1)
    nz = nt.nodes.new('ShaderNodeTexNoise'); nz.inputs['Scale'].default_value = .7; nz.inputs['Detail'].default_value = 15; nz.inputs['Distortion'].default_value = 2.2
    rp = nt.nodes.new('ShaderNodeValToRGB'); el = rp.color_ramp.elements; el[0].position = .492; el[0].color = (1, 1, 1, 1); el[1].position = .5; el[1].color = (*[1 - (1 - c) * .55 for c in vein], 1)
    e3 = el.new(.508); e3.color = (1, 1, 1, 1)
    mx = nt.nodes.new('ShaderNodeMix'); mx.data_type = 'RGBA'; mx.blend_type = 'MULTIPLY'; mx.inputs['Factor'].default_value = 1
    nt.links.new(tc.outputs['Object'], br.inputs['Vector']); nt.links.new(tc.outputs['Object'], nz.inputs['Vector']); nt.links.new(nz.outputs['Fac'], rp.inputs['Fac'])
    nt.links.new(br.outputs['Color'], mx.inputs[6]); nt.links.new(rp.outputs['Color'], mx.inputs[7]); nt.links.new(mx.outputs[2], b.inputs['Base Color'])
    b.inputs['Roughness'].default_value = rough; return m
def velvet(name, col): 
    m = mat(name, col, .75, noise=(150, .2, .06)); b = m.node_tree.nodes['Principled BSDF']
    b.inputs['Sheen Weight'].default_value = .45; b.inputs['Sheen Roughness'].default_value = .4; b.inputs['Sheen Tint'].default_value = (1, 1, 1, 1); return m
def panel_wall(name, col, joint=.6):
    m = bpy.data.materials.new(name); m.use_nodes = True; nt = m.node_tree; b = nt.nodes['Principled BSDF']
    tc = nt.nodes.new('ShaderNodeTexCoord'); sp = nt.nodes.new('ShaderNodeSeparateXYZ'); cb = nt.nodes.new('ShaderNodeCombineXYZ')
    br = nt.nodes.new('ShaderNodeTexBrick'); br.offset = 0; br.inputs['Scale'].default_value = 1 / joint; br.inputs['Brick Width'].default_value = 1; br.inputs['Row Height'].default_value = 20
    br.inputs['Mortar Size'].default_value = .006; br.inputs['Color1'].default_value = (*col, 1); br.inputs['Color2'].default_value = (*[c * .985 for c in col], 1); br.inputs['Mortar'].default_value = (*[c * .62 for c in col], 1)
    nt.links.new(tc.outputs['Object'], sp.inputs[0]); nt.links.new(sp.outputs['X'], cb.inputs['X']); nt.links.new(sp.outputs['Z'], cb.inputs['Y'])
    nt.links.new(cb.outputs[0], br.inputs['Vector']); nt.links.new(br.outputs['Color'], b.inputs['Base Color']); b.inputs['Roughness'].default_value = .7
    bp = nt.nodes.new('ShaderNodeBump'); bp.inputs['Strength'].default_value = .3; nt.links.new(br.outputs['Fac'], bp.inputs['Height']); nt.links.new(bp.outputs['Normal'], b.inputs['Normal'])
    return m
if LUX:
    FLOOR = marble('san-marble', (.93, .91, .88), (.6, .57, .54)); TILE = marble('wc-marble', (.9, .88, .85), (.48, .45, .42), (.6, .6), .1)
    DECK = wood_floor(); WALL = panel_wall('tuong-op-tam', (.72, .64, .55)); EXT = panel_wall('tuong-bao-op-tam', (.8, .75, .68), .9); CEIL = mat('tran-lux', (.97, .96, .94), .95)
    WALNUT = mat('oc-cho-lux', (.19, .1, .055), .3, noise=(25, .35, .02)); OAK = mat('go-lux', (.34, .2, .11), .3, noise=(25, .35, .02))
    BRASS = mat('dong', (.86, .62, .33), .22, 1.)
    FAB = velvet('nhung-xanh-reu', (.025, .085, .07)); FAB2 = velvet('nhung-taupe', (.4, .33, .27)); CHAIRF = velvet('boucle-kem', (.86, .82, .76))
    FAB3 = mat('da-cognac', (.42, .2, .09), .45); LINEN = mat('ga-lux', (.97, .96, .94), .9, noise=(60, .1, .08)); RUG = mat('tham-lux', (.8, .77, .72), 1., noise=(250, .3, .15))
    STONE = marble('da-ban', (.96, .95, .93), (.5, .48, .46), (4, 4), .08); CAB = mat('tu-den', (.06, .06, .065), .35)
    DRAPE = velvet('rem-nhung', (.52, .45, .38)); ART1 = mat('tranh-vang', (.82, .66, .4), .35, .5, noise=(1.8, .9, 0)); ART2 = mat('tranh-xanh', (.2, .3, .3), .5, noise=(1.5, .9, 0))
COVE = mat('led-hat', (1, 1, 1), .5, emit=(1, .76, .5), estr=9)
def torus(cx, cy, cz, R, r, m, parent=None):
    bpy.ops.mesh.primitive_torus_add(major_radius=R, minor_radius=r, major_segments=64, minor_segments=12, location=(cx, cy, cz)); o = bpy.context.object; o.data.materials.append(m)
    if parent: o.parent = parent
    return o

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

box(-20, 0, -110, 40.2, 80, 109.94, EXT, 0, 0, name='than-thap')   # thân tháp phía dưới
for _pt in PARTS:
    setpart(_pt)
    # sàn + trần + vùng WC / ban công
    pts = [P(x, y) for x, y in SP['floor']]
    pad = .25
    _b = [P(x, y) for x, y in SP['floor']]; px0, px1, py0, py1 = min(q[0] for q in _b), max(q[0] for q in _b), min(q[1] for q in _b), max(q[1] for q in _b)
    slab([(px0 - pad, py0 - pad), (px1 + pad, py1 + pad)] * 2, 0, FLOOR, .05)
    slab([(px0 - pad, py0 - pad), (px1 + pad, py1 + pad)] * 2, H + .2, CEIL, .2).name = 'tran'
    for z in SP.get('zones', []):
        a, b = P(z[1], z[2]), P(z[3], z[4])
        slab([(a[0], a[1]), (b[0], a[1]), (b[0], b[1]), (a[0], b[1])], .006, TILE if z[0] == 'wc' else DECK, .007)
    # nền tầng dưới, cạnh sàn ban công

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
                inner = not (min(x0, x1) <= 0 or max(x0, x1) >= W or min(y0, y1) <= 0 or max(y0, y1) >= D) if (x0 == x1 or y0 == y1) else False
                short = (t1 - t0) < .9; ov = .035 if short else 0   # góc kính cong ghép từ nhiều đoạn ngắn: không đố đứng, khung nối liền (hết răng cưa)
                if not (TOUR and inner): piece(t0 - ov, t1 + ov, 0, H - .06, .012, GLASS, 'kinh')
                piece(t0 - ov, t1 + ov, H - .08, .08, .07, ALU); piece(t0 - ov, t1 + ov, 0, .05, .07, ALU)
                n = max(1, round((t1 - t0) / 1.3))
                for j in range(n + 1):
                    if short: break
                    if TOUR and inner and 0 < j < n: continue   # cửa kính lô-gia mở hết
                    t = t0 + (t1 - t0) * j / n; piece(t - .025, t + .025, 0, H, .07, ALU)
                if t1 - t0 > 1.4:   # rèm voan 2 đầu
                    for (r0, r1) in ((t0 + .05, t0 + .55), (t1 - .55, t1 - .05)):
                        for c2 in range(6):
                            t = r0 + (c2 + .5) * (r1 - r0) / 6; cc = a + u * t - Vector((-u.y, u.x)) * (.12 + .03 * (c2 % 2))
                            box(cc.x, cc.y, .03, .1, .025, H - .12, SHEER, ang, 0, name='rem')
            elif k == 'r':
                piece(t0, t1, 0, 1.1, .015, RGLASS, 'lan-can'); piece(t0, t1, 1.08, .05, .06, ALU)
        if LUX and k in ('x', 'w', 'g'):   # gờ trần hắt đèn LED dọc tường (trần giật cấp)
            th = .2 if k == 'x' else (.12 if k == 'w' else .07); nv = Vector((-u.y, u.x))
            for sd in (-1, 1):
                c = (a + b) / 2 + nv * sd * (th / 2 + (.07 if k != 'g' else .2))
                box(c.x, c.y, H - .14, L, .12 if k != 'g' else .38, .07, CEIL, ang, 0, name='go-tran')
                c2 = (a + b) / 2 + nv * sd * (th / 2 + (.13 if k != 'g' else .38)); box(c2.x, c2.y, H - .07, L, .02, .02, COVE, ang, 0, name='led')
        if LUX and k == 'g' and L > 1.4:   # rèm nhung dày 2 đầu
            for (r0, r1) in ((.0, .5), (L - .5, L)):
                for c3 in range(5):
                    t = r0 + (c3 + .5) * (r1 - r0) / 5; cc = a + u * t - Vector((-u.y, u.x)) * (.26 + .035 * (c3 % 2))
                    box(cc.x, cc.y, .02, .11, .04, H - .26, DRAPE, ang, 0, name='rem-day')
        for g in gaps:
            t0, t1 = g[0] * kk, g[1] * kk
            piece(t0, t1, 2.15, H - 2.15, .2 if k == 'x' else .12, EXT if k == 'x' else WALL)
            if k == 'x':   # cửa vào căn: cánh gỗ đóng + khuôn
                if not TOUR: piece(t0, t1, 0, 2.15, .05, WALNUT, 'cua')
                piece(t0, t0 + .05, 0, 2.2, .22, OAK); piece(t1 - .05, t1, 0, 2.2, .22, OAK)
            else:          # cửa phòng: khuôn + cánh mở 90°
                piece(t0, t0 + .04, 0, 2.15, .14, OAK); piece(t1 - .04, t1, 0, 2.15, .14, OAK)
                nrm = Vector((-u.y, u.x)) * (g[2] if len(g) > 2 else 1); hinge = a + u * t0; w_ = t1 - t0 - .08
                c = hinge - u * (w_ / 2 + .02) + nrm * .09; box(c.x, c.y, 0, w_, .04, 2.1, OAK, ang, 0, name='canh-cua')   # cánh mở hết, áp sát tường – không chắn lối đi

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
setpart(MAINP)

# ---------------- sân vườn riêng (tầng 2, 3) theo bản vẽ CĐT: cỏ, tường rào, cây, lối đá, sân lát đá, bàn ghế ----------------
GKEY = os.environ.get('GARD', ''); GD = CCL.get('gard', {}).get(GKEY, {}).get(UID) if GKEY else None
GPTS = []; GCEN = None; GGLASS = None
def TW(u, v): return (-v, -u - _OY)                      # toạ độ tháp → Blender
def pip(x, y, P):
    c = False; j = len(P) - 1
    for i in range(len(P)):
        if (P[i][1] > y) != (P[j][1] > y) and x < (P[j][0] - P[i][0]) * (y - P[i][1]) / (P[j][1] - P[i][1]) + P[i][0]: c = not c
        j = i
    return c
def polyslab(pts, ztop, th, m, name='poly'):
    bm = bmesh.new(); vs = [bm.verts.new((x, y, ztop)) for x, y in pts]; f = bm.faces.new(vs)
    r = bmesh.ops.extrude_face_region(bm, geom=[f]); vv = [e for e in r['geom'] if isinstance(e, bmesh.types.BMVert)]
    bmesh.ops.translate(bm, verts=vv, vec=(0, 0, -th)); bmesh.ops.recalc_face_normals(bm, faces=bm.faces[:])
    me = bpy.data.meshes.new(name); bm.to_mesh(me); o = bpy.data.objects.new(name, me); sc.collection.objects.link(o); o.data.materials.append(m); return o
if GD:
    for q in GD['poly']:
        p_ = TW(q[0], q[1])
        if not GPTS or math.dist(p_, GPTS[-1]) > .02: GPTS.append(p_)
    if math.dist(GPTS[0], GPTS[-1]) < .02: GPTS.pop()
    GRASSM = mat('co', (.2, .36, .12), .95, noise=(60, .5, .25)); FENCE = mat('rao', (.95, .93, .89), .8); FCAP = mat('rao-dinh', (.25, .3, .24), .5)
    STN = mat('da-lat', (.82, .78, .71), .8, noise=(20, .3, .1)); TEAK = mat('go-teak', (.45, .3, .17), .5, noise=(25, .3, .02)); CUSH = mat('nem-ngoai-troi', (.92, .9, .85), .9)
    polyslab(GPTS, -.03, .4, GRASSM, 'san-vuon')
    ux0, ux1, uy0, uy1 = X0 - .45, X1 + .45, Y0 - .45, Y1 + .45
    inU = lambda x, y: ux0 < x < ux1 and uy0 < y < uy1
    for i in range(len(GPTS)):   # tường rào (bỏ các cạnh sát tường căn)
        a_, b_ = Vector(GPTS[i]), Vector(GPTS[(i + 1) % len(GPTS)]); Lr = (b_ - a_).length
        if Lr < .05: continue
        m_ = (a_ + b_) / 2
        if inU(m_.x, m_.y): continue
        ang_ = math.atan2(b_.y - a_.y, b_.x - a_.x)
        box(m_.x, m_.y, 0, Lr + .06, .1, .9, FENCE, ang_, 0, name='rao'); box(m_.x, m_.y, .9, Lr + .06, .16, .06, FCAP, ang_, 0, name='rao')
        t_ = 0.
        while t_ <= Lr: q_ = a_ + (b_ - a_) * (t_ / Lr); box(q_.x, q_.y, 0, .16, .16, 1.05, FCAP, ang_, 0, name='cot-rao'); t_ += 1.8
    gx = [q[0] for q in GPTS]; gy = [q[1] for q in GPTS]
    cells = [(x_, y_) for x_ in [min(gx) + .25 + .5 * i for i in range(int((max(gx) - min(gx)) / .5))] for y_ in [min(gy) + .25 + .5 * j for j in range(int((max(gy) - min(gy)) / .5))] if pip(x_, y_, GPTS) and not inU(x_, y_)]
    if cells:
        cx_ = sum(c[0] for c in cells) / len(cells); cy_ = sum(c[1] for c in cells) / len(cells)
        GCEN = min(cells, key=lambda c: (c[0] - cx_) ** 2 + (c[1] - cy_) ** 2)
        # kính của căn gần sân nhất → điểm bắt đầu lối đi + góc chụp từ trong nhìn ra vườn
        best = None
        for _pt in PARTS:
            setpart(_pt)
            for s in SP['segs']:
                if s[4] in ('g', 'r'):
                    a2, b2 = Vector(P(s[0], s[1])), Vector(P(s[2], s[3])); c2 = (a2 + b2) / 2; dd = math.dist(c2, GCEN)
                    if best is None or dd < best[0]: best = (dd, c2, a2, b2)
        setpart(MAINP)
        if best:
            c2 = best[1]; nv = Vector((-(best[3] - best[2]).y, (best[3] - best[2]).x)).normalized()
            if nv.dot(Vector(GCEN) - c2) < 0: nv = -nv
            GGLASS = (c2, nv)
            st = c2 + nv * .9
            while inU(st.x, st.y) and (st - c2).length < 6: st += nv * .3
            en = Vector(GCEN); Lp = (en - st).length; ang2 = math.atan2(en.y - st.y, en.x - st.x)
            d_ = .3; k_ = 0
            while d_ < Lp - 1.1:
                q_ = st + (en - st) * (d_ / Lp); box(q_.x, q_.y, -.02, .62, .42, .05, STN, ang2 + (random.random() - .5) * .15 if 'random' in dir() else ang2, .01, name='da'); d_ += .72; k_ += 1
            cyl(en.x, en.y, -.02, 1.35, .05, STN, verts=48)
            cyl(en.x, en.y, .7, .4, .04, TEAK); cyl(en.x, en.y, .03, .04, .67, TEAK)
            for sd in (-1, 1):
                ch = Vector((math.cos(ang2 + math.pi / 2), math.sin(ang2 + math.pi / 2))) * .75 * sd + en
                box(ch.x, ch.y, .03, .5, .5, .4, TEAK, ang2, .02); box(ch.x, ch.y, .43, .46, .46, .08, CUSH, ang2, .03)
            cyl(en.x, en.y, .03, .025, 2.3, TEAK); bpy.ops.mesh.primitive_cone_add(radius1=1.25, radius2=.05, depth=.45, vertices=32, location=(en.x, en.y, 2.45)); bpy.context.object.data.materials.append(CUSH)
        import random as _r; _r.seed(5); n_ = 0
        for c in cells[::9]:   # cây bụi + cây nhỏ, tránh lối đi và sân lát
            if GCEN and math.dist(c, GCEN) < 2.0: continue
            if GGLASS and abs((Vector(c) - (GGLASS[0])).cross(Vector(GCEN) - GGLASS[0])) / max(.1, (Vector(GCEN) - GGLASS[0]).length) < .8 and (Vector(c) - GGLASS[0]).dot(Vector(GCEN) - GGLASS[0]) > 0 and math.dist(c, GGLASS[0]) < math.dist(GCEN, GGLASS[0]): continue
            n_ += 1
            if n_ % 3 == 0: cyl(c[0], c[1], 0, .09, 1.6, WALNUT, verts=10); sphere(c[0], c[1], 2.0, .8, LEAF, 1.0)
            else: sphere(c[0], c[1], .25, .45 + _r.random() * .15, LEAF, .7)
    BX += GPTS

if TOUR:   # hành lang chung trước cửa căn (thảm, trần, tường, đèn)
    HL = mat('tham-hanh-lang', (.32, .26, .22), 1., noise=(200, .3, .1)) if LUX else FLOOR
    slab([P(-.6, -2.2), P(W + .6, 0)], 0, HL, .05); slab([P(-.6, -2.2), P(W + .6, 0)], H + .2, CEIL, .2)
    panel((-.6, -2.2), (W + .6, -2.2), 0, H, .2, WALL); panel((-.6, -2.2), (-.6, 0), 0, H, .2, WALL); panel((W + .6, -2.2), (W + .6, 0), 0, H, .2, WALL)
    for xx in (1.0, 3.0, 4.42, 6.0): c = P(xx, -1.1); cyl(c[0], c[1], H - .012, .05, .01, DOWN, verts=16)
    if LUX: panel((-.6, -2.08), (W + .6, -2.08), 0, 2.2, .04, WALNUT)

# ---------------- nội thất theo bản vẽ ----------------
DIRV = {'u': (0, -1), 'd': (0, 1), 'l': (-1, 0), 'r': (1, 0)}
def frame(x, y, face):
    v = DIRV.get(face, (0, 1)); fx, fy = L(*v)                     # hướng mặt trước (Blender)
    e = bpy.data.objects.new('noi-that', None); sc.collection.objects.link(e)
    e.location = (*P(x, y), 0); e.rotation_euler[2] = math.atan2(fy, fx) - math.pi / 2
    if MIRROR: e.scale[0] = -1                                     # căn lật so với bản vẽ mẫu
    return e
for _pt in PARTS:
    setpart(_pt)
    art_i = [0]
    for it in SP['items']:
        k, x, y, w = it[0], it[1], it[2], it[3]; d = it[4] if len(it) > 4 and isinstance(it[4], (int, float)) else w
        face = it[5] if len(it) > 5 and isinstance(it[5], str) else 'd'; ex = it[6] if len(it) > 6 and isinstance(it[6], dict) else (it[5] if len(it) > 5 and isinstance(it[5], dict) else {})
        o = frame(x, y, face); hw, hd = w / 2, d / 2          # trong khung: X = bề ngang, +Y = mặt trước, lưng ở -Y
        if k == 'bed':
            box(0, 0, 0, w + .1, d + .05, .32, WALNUT, parent=o); box(0, .03, .32, w - .02, d - .12, .24, LINEN, bevel=.06, parent=o)
            box(0, d * .14, .5, w + .04, d * .66, .09, LINEN if LUX else FAB, bevel=.04, parent=o); box(0, d * .38, .58, w + .06, .4, .03, FAB if LUX else FAB3, bevel=.01, parent=o)
            box(0, -hd + .03, 0, w + .3, .1, 1.15, FAB2, bevel=.03, parent=o)
            for sd in (-1, 1): box(sd * w * .24, -hd + .32, .52, w * .42, .34, .14, LINEN, bevel=.06, parent=o)
            box(0, .05, -.001, w + .8, d + .1, .012, RUG, 0, 0, parent=o)
            if LUX:   # đầu giường bọc nhung cao + ốp gỗ óc chó nan + đèn tường đồng + đôn cuối giường
                box(0, -hd - .04, 0, w + .9, .1, 1.45, FAB2, bevel=.03, parent=o)
                for i in range(int((w + 2.2) / .06)): box(-(w + 2.2) / 2 + i * .06 + .03, -hd - .12, 0, .035, .04, H, WALNUT, 0, .004, parent=o)
                for sd in (-1, 1): box(sd * (w / 2 + .55), -hd - .07, 1.55, .04, .1, .24, BRASS, 0, .005, parent=o); cyl(sd * (w / 2 + .55), -hd + .02, 1.6, .06, .14, LAMP, parent=o)
            else: e2 = box(0, -hd - .005, 1.45, 1.0, .03, .6, ART1, 0, .005, parent=o)
        elif k == 'ns':
            box(0, 0, 0, w, d, .5, WALNUT if LUX else OAK, parent=o); cyl(0, -.05, .5, .07, .32, BRASS if LUX else WHITE, parent=o); cyl(0, -.05, .82, .14, .2, LAMP, parent=o)
            if LUX: box(0, 0, .5, w + .01, d + .01, .02, STONE, 0, .003, parent=o)
        elif k == 'arm' and LUX: pass   # bỏ ghế bành cho thoáng lối đi
        elif k in ('sofa', 'arm', 'daybed'):
            arms = k != 'daybed'; aw = .16 if arms else 0; FAB_ = FAB
            if LUX and k == 'daybed': FAB = CHAIRF   # giường đơn phòng +1 bọc vải kem cho nhẹ
            box(0, 0, .08, w, d, .32, FAB, parent=o); box(0, -hd + .1, .4, w, .2, .45, FAB, bevel=.05, parent=o)
            if arms:
                for sd in (-1, 1): box(sd * (hw - .08), 0, .4, .16, d, .2, FAB, bevel=.05, parent=o)
            n = 1 if w < 1.2 else (2 if w < 2.2 else 3); cw = (w - 2 * aw) / n
            for i in range(n): box(-hw + aw + cw * (i + .5), .06, .4, cw - .02, d - .28, .13, FAB, bevel=.05, parent=o); box(-hw + aw + cw * (i + .5), -hd + .3, .52, cw - .04, .16, .38, FAB, bevel=.06, parent=o)
            for sd in (-1, 1): box(sd * (hw - aw - .25), -hd + .44, .55, .4, .12, .38, FAB3 if sd < 0 else FAB2, bevel=.05, parent=o)
            for sx_ in (-1, 1):
                for sy_ in (-1, 1): box(sx_ * (hw - .06), sy_ * (hd - .06), 0, .04, .04, .08, BRASS if LUX else WALNUT, 0, 0, parent=o)
            FAB = FAB_
            if k == 'sofa': box(0, .75, -.001, w + .2, 1.5, .012, RUG, 0, 0, parent=o); box(0, -hd - .02, 1.3, 1.2, .03, .75, ART2, 0, .005, parent=o)
        elif k == 'rtab':
            h = ex.get('h', .42); cyl(0, 0, h - .03, hw, .03, STONE if LUX else OAK, parent=o, verts=48); cyl(0, 0, 0, .05, h - .03, BRASS if LUX else BLACK, parent=o); cyl(0, 0, 0, hw * .5, .02, BRASS if LUX else BLACK, parent=o)
        elif k == 'tv':
            box(0, .14, .18, w, d * .6, .36, WALNUT, parent=o); box(0, -hd + .2, 1.0, w * .78, .04, w * .78 * .5625, BLACK, 0, .005, parent=o)
            if LUX and w >= 1.6:   # vách ốp nan gỗ óc chó kịch trần + nẹp đồng (TV phòng khách)
                for i in range(int((w + .8) / .06)): box(-(w + .8) / 2 + i * .06 + .03, -hd + .15, 0, .035, .04, H, WALNUT, 0, .004, parent=o)
                for sd in (-1, 1): box(sd * ((w + .8) / 2 + .01), -hd + .15, 0, .015, .05, H, BRASS, 0, 0, parent=o)
                box(0, hd - .02, .2, w, .01, .015, BRASS, 0, 0, parent=o)
            else: box(0, -hd - .01, .54, w + .2, .025, 1.9, OAK, 0, 0, parent=o)     # mảng ốp gỗ sau TV
        elif k == 'kit':
            box(0, 0, .1, w, d, .78, CAB, .0, .004, parent=o); box(0, 0, 0, w - .02, d - .06, .1, BLACK, 0, 0, parent=o)
            box(0, .01, .88, w + .02, d + .02, .03, STONE, 0, .003, parent=o); box(0, -hd + .01, .91, w, .015, .62, STONE, 0, 0, parent=o)
            if not ex.get('noup'): box(0, -hd + .18, 1.53, w, .35, .72, CAB, 0, .004, parent=o)
            if ex.get('hob') is not None:
                hx = -hw + ex['hob'] * w; box(hx, 0, .91, .58, .5, .006, BLACK, 0, 0, parent=o)
                if not ex.get('noup'): box(hx, -hd + .2, 1.45, .6, .4, .08, STEEL, 0, 0, parent=o)
            if ex.get('sink') is not None:
                sxp = -hw + ex['sink'] * w; box(sxp, .02, .78, .55, .42, .13, STEEL, 0, 0, parent=o); cyl(sxp, -hd + .1, .91, .015, .3, STEEL, parent=o)
            for i in range(max(1, int(w / .6))): box(-hw + (i + .5) * w / max(1, int(w / .6)), hd + .005, .8, .2, .015, .012, BRASS, 0, 0, parent=o)
            if LUX and not ex.get('noup'): box(0, -hd + .01, .91, w, .015, .64, STONE, 0, 0, parent=o); box(0, -hd + .2, 1.5, w, .02, .02, COVE, 0, 0, parent=o)
        elif k == 'fridge':
            box(0, 0, 0, w - .02, d - .02, 1.85, STEEL, parent=o); box(0, hd - .01, .9, .02, .02, .5, BLACK, 0, 0, parent=o)
        elif k == 'wc':
            box(0, .08, 0, .36, .5, .4, CER, bevel=.08, parent=o); box(0, -hd + .1, .35, .4, .18, .4, CER, bevel=.04, parent=o)
        elif k in ('van', 'wash'):
            box(0, 0, .35 if k == 'van' else 0, w, d, .5 if k == 'van' else .85, OAK if k == 'van' else WHITE, parent=o)
            box(0, .02, .85, w * .55, d * .7, .12, CER, bevel=.04, parent=o); box(0, -hd + .02, 1.1, w * .9, .02, .8, GLASS, 0, 0, parent=o)
            box(0, -hd + .03, 1.92, w * .8, .04, .04, LAMP, 0, 0, parent=o)
            if LUX: box(0, 0, .85, w + .01, d + .01, .02, STONE, 0, .003, parent=o); cyl(0, -hd + .08, .87, .012, .28, BRASS, parent=o); box(0, -hd + .015, 1.1, w * .95, .01, .82, LAMP, 0, 0, parent=o)
        elif k == 'ward':
            box(0, 0, 0, w, d, 2.4, OAK, .0, .004, parent=o); n = max(2, round(w / .5))
            for i in range(1, n): box(-hw + w * i / n, hd + .002, .05, .006, .006, 2.3, WALNUT, 0, 0, parent=o)
            for i in range(n): box(-hw + w * (i + .5) / n + (.18 if i % 2 else -.18), hd + .015, 1.0, .02, .025, .35, BRASS, 0, 0, parent=o)
        elif k == 'dtab':
            box(0, 0, .72, w, d, .035, STONE if LUX else OAK, parent=o); [box(sx_ * (hw - .08), sy_ * (hd - .08), 0, .05, .05, .72, BRASS if LUX else BLACK, 0, 0, parent=o) for sx_ in (-1, 1) for sy_ in (-1, 1)]
            cols = [0] if w < 1.1 else [-w / 4, w / 4]
            for sd in (-1, 1):
                for cx_ in cols:
                    box(cx_, sd * (hd + .12), .3, .42, .42, .14, CHAIRF, bevel=.03, parent=o); box(cx_, sd * (hd + .31), .44, .4, .035, .38, OAK, bevel=.01, parent=o)
                    [box(cx_ + ax * .18, sd * (hd + .12) + ay * .18, 0, .025, .025, .3, WALNUT, 0, 0, parent=o) for ax in (-1, 1) for ay in (-1, 1)]
            if LUX:   # đèn chùm vòng đồng 2 tầng
                torus(0, 0, 1.85, .5, .018, BRASS, parent=o); torus(0, 0, 1.85, .5, .008, LAMP, parent=o).location.z = 1.83
                torus(0, 0, 2.0, .32, .015, BRASS, parent=o); torus(0, 0, 2.0, .32, .007, LAMP, parent=o).location.z = 1.98
                for a_ in range(3): cyl(.5 * math.cos(a_ * 2.09), .5 * math.sin(a_ * 2.09), 1.85, .003, H - 1.85, BRASS, parent=o)
            else: cyl(0, 0, 1.75, .22, .18, LAMP, parent=o); cyl(0, 0, 1.93, .006, H - 1.93, BLACK, parent=o)
        elif k == 'desk':
            box(0, 0, .72, w, d, .03, OAK, parent=o); box(-hw + .03, 0, 0, .04, d - .05, .72, BLACK, 0, 0, parent=o); box(hw - .03, 0, 0, .04, d - .05, .72, BLACK, 0, 0, parent=o)
            box(.2, -.05, .75, .5, .3, .02, BLACK, 0, 0, parent=o); box(-.3, -.12, .75, .12, .12, .35, LAMP, 0, .01, parent=o)
        elif k in ('chair', 'stool'):
            box(0, 0, 0, w, d, .46, (CHAIRF if LUX else FAB2) if k == 'chair' else OAK, bevel=.03, parent=o)
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
setpart(MAINP)

# đèn âm trần (lưới ~1,4 m) – vừa thấy đèn, vừa là nguồn sáng
nx_, ny_ = int((X1 - X0) / (2.0 if LUX else 1.4)), int((Y1 - Y0) / (2.0 if LUX else 1.4))
for gx in range(1, nx_ + 1):
    for gy in range(1, ny_ + 1):
        cyl(X0 + gx * (X1 - X0) / (nx_ + 1), Y0 + gy * (Y1 - Y0) / (ny_ + 1), H - .012, .05, .01, DOWN, verts=16)

# ---------------- bên ngoài: biển + dải resort + bãi cát theo khoảng cách thật ----------------
FLOOR_H = float(os.environ.get('FLOOR_H', '108'))   # sàn tầng 30 ≈ 108 m; tầng 18 ≈ 64 m
def ground(y0, y1, m, z=-FLOOR_H, x0=-3000, x1=3000): slab([(x0, y0), (x1, y0), (x1, y1), (x0, y1)], z, m, .5)
SEA = mat('bien', (.03, .22, .3), .05, .0); SAND = mat('cat', (.85, .78, .62), .9); GRASS = mat('dat-resort', (.32, .42, .24), .9, noise=(.05, .5, 0)); ROADM = mat('duong', (.18, .18, .19), .8)
def strip(x0, x1, m, z=-FLOOR_H, y0=-3000, y1=3000): slab([(x0, y0), (x1, y1)] * 2, z, m, .5)
strip(0, 30, GRASS); strip(30, 58, ROADM); strip(58, 330, GRASS); strip(330, 392, SAND); strip(392, 20000, SEA, -FLOOR_H + .2, -20000, 20000); strip(-3000, -40, GRASS)
import random; random.seed(3)
for i in range(160):     # khối resort thấp tầng, cây dừa trên dải đất ven biển
    y = random.uniform(-500, 500); x = random.uniform(70, 320)
    if random.random() < .35: box(x, y, -FLOOR_H, random.uniform(10, 26), random.uniform(8, 16), random.uniform(5, 14), WHITE, 0, 0)
    else: sphere(x, y, -FLOOR_H + random.uniform(6, 11), random.uniform(2.5, 4.5), LEAF, .8)
CITY = mat('nha-pho', (.86, .84, .8), .7)
for i in range(520):     # phố phía Tây, Bắc, Nam (minh họa khối nhà xung quanh)
    x = random.uniform(-1800, 300); y = random.uniform(-1800, 1800)
    if (x > -55 and abs(y) < 70) or x > 20 and abs(y) < 600: continue
    h = random.uniform(8, 26) if random.random() < .9 else random.uniform(40, 110)
    box(x, y, -FLOOR_H, random.uniform(12, 30), random.uniform(12, 30), h, CITY, 0, 0)

# bầu trời + nắng buổi sáng từ phía biển
wd = bpy.data.worlds.new('troi'); sc.world = wd; wd.use_nodes = True; nt = wd.node_tree
sky = nt.nodes.new('ShaderNodeTexSky'); sky.sky_type = 'NISHITA'; sky.sun_elevation = math.radians(32); sky.sun_rotation = math.radians(SUNROT); sky.altitude = 110
sky.air_density = 1.2; sky.dust_density = 1.6
nt.links.new(sky.outputs['Color'], nt.nodes['Background'].inputs['Color']); nt.nodes['Background'].inputs['Strength'].default_value = .35
sun = bpy.data.lights.new('nang', 'SUN'); sun.energy = 3.2; sun.angle = math.radians(1.2); so = bpy.data.objects.new('nang', sun); sc.collection.objects.link(so)
so.rotation_euler = (math.radians(58), 0, math.radians(90))      # nắng sáng từ phía biển (Đông)
# ánh sáng tràn qua cửa kính (portal) cho đỡ nhiễu
OUTN = Vector((0, 0))
for _pt in PARTS:
    setpart(_pt)
    for s in SP['segs']:
        if s[4] in ('g', 'r'):
            a, b = Vector(P(s[0], s[1])), Vector(P(s[2], s[3])); c = (a + b) / 2; Lg = (b - a).length
            ld = bpy.data.lights.new('portal', 'AREA'); ld.shape = 'RECTANGLE'; ld.size = Lg; ld.size_y = H; ld.cycles.is_portal = True
            lo = bpy.data.objects.new('portal', ld); sc.collection.objects.link(lo)
            cen = Vector(((X0 + X1) / 2, (Y0 + Y1) / 2)); nrm = Vector((-(b - a).y, (b - a).x)).normalized()
            if nrm.dot(cen - c) < 0: nrm = -nrm                     # pháp tuyến hướng vào trong căn
            lo.location = (c.x - nrm.x * .1, c.y - nrm.y * .1, H / 2)
            lo.rotation_euler = Vector((-nrm.x, -nrm.y, 0)).to_track_quat('Z', 'X').to_euler()
        if s[4] in ('g', 'r'): OUTN += -nrm * Lg
setpart(MAINP)
if OUTN.length > .01:   # nắng chiếu vào từ phía mặt kính của căn (Đông: sáng, Tây: chiều, Bắc/Nam: trưa)
    OUTN.normalize(); so.rotation_euler = (math.radians(58), 0, math.atan2(OUTN.x, -OUTN.y))
    sky.sun_rotation = math.radians(SUNROT) + math.atan2(OUTN.x, -OUTN.y) - math.pi / 2

# ---------------- render ----------------
sc.render.engine = 'CYCLES'; cy = sc.cycles; cy.device = 'CPU'; cy.samples = SAMPLES; cy.use_denoising = True
try: cy.denoiser = 'OPENIMAGEDENOISE'
except Exception: pass
cy.max_bounces = 8; cy.diffuse_bounces = 4; cy.glossy_bounces = 3; cy.transparent_max_bounces = 12; cy.caustics_reflective = False; cy.caustics_refractive = False
cy.sample_clamp_indirect = 4; cy.light_sampling_threshold = .01
sc.view_settings.view_transform = 'AgX'; sc.view_settings.look = 'AgX - Base Contrast'; sc.view_settings.exposure = float(os.environ.get('EXPO', '1.15'))
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

SHL = {   # điểm đứng / điểm nhìn theo toạ độ bản vẽ từng loại căn
 '1PN+1': {'living': ((4.6, 0.7), (4.6, 9.5)), 'living2': ((4.65, 7.45), (5.1, 0.8)), 'bed': ((2.45, 5.4), (0.7, 8.9)), 'plus': ((4.0, 3.75), (0.3, 2.5))},
 'STU':   {'living': ((2.75, 3.65), (1.4, 9.6)), 'living2': ((1.7, 7.25), (3.1, 1.4))},
 'STUL':  {'living': ((5.8, 1.2), (4.3, 10.5)), 'living2': ((4.0, 9.2), (6.2, 1.2))},
 '2PN':   {'living': ((6.1, 7.0), (0.3, 8.4)), 'living2': ((2.3, 7.1), (6.7, 8.8)), 'bed': ((3.45, 2.6), (0.6, 0.5)), 'plus': ((3.4, 5.75), (0.4, 3.6))},
}
SHL['2PN1'] = SHL['2PN']
SHL['2PN11'] = {'living': ((5.8, 8.6), (0.3, 10.0)), 'living2': ((1.6, 10.5), (6.2, 8.3)), 'bed': ((2.15, 2.35), (-2.0, -0.6)), 'plus': ((1.7, 6.3), (-3.0, 5.6))}
SHL['2PNT'] = {'living': ((7.2, 5.0), (7.2, -1.0)), 'living2': ((7.3, 1.6), (6.0, 7.6)), 'bed': ((2.0, 5.0), (1.0, 0.5)), 'plus': ((3.4, 3.9), (4.8, 0.3))}
SHL['2PN1L'] = dict(SHL['2PN11'], plus=((4.0, 4.6), (0.5, 8.0)))
SHL['1PN+1L'] = SHL['1PN+1']
SH = {k: (v[0], v[1], 15, 1.5, 0.) for k, v in SHL.get(LAY, SHL['1PN+1']).items()}
for s in SHOTS:
    if s == 'top':   # mặt bằng 3D phối cảnh nghiêng từ góc (kiểu bản vẽ bán hàng): bỏ trần, tường để nguyên, nền xám nhạt, kèm số đo
        from bpy_extras.object_utils import world_to_camera_view
        UX0, UX1, UY0, UY1 = X0, X1, Y0, Y1                                   # khung căn (không gồm sân vườn)
        for o in bpy.data.objects:
            if o.type != 'MESH' or not o.data.vertices: continue
            if o.name.startswith(('tran', 'go-tran', 'led', 'rem', 'than-thap')): o.hide_render = True; continue
            zs = [v.co.z for v in o.data.vertices]; z0_, z1_ = min(zs) + o.location.z, max(zs) + o.location.z
            if z1_ < -.5 or (o.parent is None and z0_ > H - .1): o.hide_render = True   # đất/phố dưới thấp, đèn âm trần
        CAPW = mat('mat-cat-trang', (.97, .97, .96), .8)
        CLR = bpy.data.materials.new('kinh-trong'); CLR.use_nodes = True; nt_ = CLR.node_tree; nt_.nodes.clear()   # kính trong, phản chiếu rất nhẹ
        o_ = nt_.nodes.new('ShaderNodeOutputMaterial'); tr_ = nt_.nodes.new('ShaderNodeBsdfTransparent'); tr_.inputs['Color'].default_value = (.93, .97, 1, 1)
        gl_ = nt_.nodes.new('ShaderNodeBsdfGlossy'); gl_.inputs['Roughness'].default_value = .05; gl_.inputs['Color'].default_value = (.85, .9, .95, 1)
        mx_ = nt_.nodes.new('ShaderNodeMixShader'); mx_.inputs[0].default_value = .07; nt_.links.new(tr_.outputs[0], mx_.inputs[1]); nt_.links.new(gl_.outputs[0], mx_.inputs[2]); nt_.links.new(mx_.outputs[0], o_.inputs['Surface'])
        for o in bpy.data.objects:
            if o.type == 'MESH' and o.data.materials and o.data.materials[0] in (GLASS, RGLASS):
                for sl_ in o.material_slots: sl_.link = 'OBJECT'; sl_.material = CLR
        # mặt cắt bên trong: tường trong + tường/kính phía người xem cắt ở 1,3 m; chỉ giữ nguyên tường bao đối diện
        LOWH = float(os.environ.get('TOPCUT', '1.3'))
        _on = Vector((OUTN.x, OUTN.y)) if OUTN.length > .01 else Vector((1, 0))
        _az = math.atan2(_on.y, _on.x) + math.radians(float(os.environ.get('TOPAZ', '-38'))); _hd = Vector((math.cos(_az), math.sin(_az)))
        _c0 = Vector(((min(p[0] for p in BX) + max(p[0] for p in BX)) / 2, (min(p[1] for p in BX) + max(p[1] for p in BX)) / 2))
        _ext = max(abs((Vector(p) - _c0).dot(_hd)) for p in BX)
        for o in list(bpy.data.objects):
            if o.type != 'MESH' or o.hide_render or not o.data.materials or not o.data.vertices: continue
            if o.name.startswith('rem'): o.hide_render = True; continue
            vs_ = [o.matrix_world @ v.co for v in o.data.vertices]; zs_ = [v.z for v in vs_]   # cắt cả đồ vật (tủ, kệ, rèm, đèn thả)
            if max(zs_) <= LOWH + .02 or min(zs_) < -.3: continue
            c_ = Vector((sum(v.x for v in vs_) / len(vs_), sum(v.y for v in vs_) / len(vs_)))
            if o.data.materials[0] in (EXT, GLASS, ALU) and (c_ - _c0).dot(_hd) < -.35 * _ext: continue   # tường bao đối diện: giữ nguyên
            zb = min(zs_)
            if zb > LOWH - .05: o.hide_render = True; continue                                   # lanh tô, khung trên: nằm trên mặt cắt
            o.data = o.data.copy(); mw_ = o.matrix_world.copy(); mi_ = mw_.inverted()
            for v in o.data.vertices:
                w_ = mw_ @ v.co
                if w_.z > LOWH: w_.z = LOWH; v.co = mi_ @ w_
        for o in list(bpy.data.objects):
            if o.type != 'MESH' or o.hide_render or not o.data.materials: continue
            mt_ = o.data.materials[0]
            zs = [v.co.z for v in o.data.vertices]; z0_, z1_ = min(zs) + o.location.z, max(zs) + o.location.z
            if o.parent is None and mt_ in (WALL, EXT) and LOWH - .05 < z1_ < H - .05:       # mặt cắt đỉnh tường đã hạ
                cp = o.copy(); sc.collection.objects.link(cp); cp.scale.z = .015 / max(.01, z1_ - z0_); cp.location.z = z1_ + .005
                cp.material_slots[0].link = 'OBJECT'; cp.material_slots[0].material = CAPW; continue
            if o.parent is None and mt_ in (WALL, EXT) and z1_ > H - .05:                  # mặt cắt đỉnh tường màu trắng
                cp = o.copy(); sc.collection.objects.link(cp); cp.scale.z = .015 / max(.01, z1_ - z0_); cp.location.z = H + .005
                cp.material_slots[0].link = 'OBJECT'; cp.material_slots[0].material = CAPW
        TW_, TH_ = (int(v) for v in os.environ.get('TOPRES', '1080x1350').split('x'))
        sc.render.film_transparent = True; sun.energy = 0
        wd.node_tree.nodes['Background'].inputs['Strength'].default_value = float(os.environ.get('TOPSKY', '.25')); sky.sun_disc = False   # không còn bóng nắng dài
        X0, X1, Y0, Y1 = min(p[0] for p in BX), max(p[0] for p in BX), min(p[1] for p in BX), max(p[1] for p in BX)
        cen = Vector(((X0 + X1) / 2, (Y0 + Y1) / 2, 0))
        # ánh sáng như ảnh bán hàng: đèn lớn dịu phía trên + đèn rọi tường tạo vệt sáng vòm trên tường, tông vàng ấm
        al = bpy.data.lights.new('den-tong', 'AREA'); al.shape = 'RECTANGLE'; al.size = X1 - X0 + 2; al.size_y = Y1 - Y0 + 2
        al.energy = (X1 - X0 + 2) * (Y1 - Y0 + 2) * float(os.environ.get('TOPAREA', '8')); al.color = (1, .93, .84); ao = bpy.data.objects.new('den-tong', al); sc.collection.objects.link(ao); ao.location = (cen.x, cen.y, H + 4)
        nsp = 0
        for o in list(bpy.data.objects):
            if o.type != 'MESH' or o.hide_render or o.parent is not None or not o.data.materials or o.data.materials[0] not in (WALL, EXT) or nsp > 90: continue
            vs = [o.matrix_world @ v.co for v in o.data.vertices]; zs = [v.z for v in vs]
            if max(zs) < H - .05: continue
            ux_ = Vector((math.cos(o.rotation_euler[2]), math.sin(o.rotation_euler[2]))); Lw = max((v.xy - o.location.xy).dot(ux_) for v in vs) * 2
            if Lw < 1.2: continue
            nv_ = Vector((-ux_.y, ux_.x)); n_ = max(1, int(Lw / 1.5))
            for i_ in range(n_):
                t_ = -Lw / 2 + (i_ + .5) * Lw / n_
                for sd in (-1, 1):
                    q_ = o.location.xy + ux_ * t_ + nv_ * sd * .42
                    if not (X0 < q_.x < X1 and Y0 < q_.y < Y1): continue
                    sl = bpy.data.lights.new('roi-tuong', 'SPOT'); sl.energy = float(os.environ.get('TOPSPOT', '130')); sl.spot_size = math.radians(95); sl.spot_blend = .85; sl.color = (1, .82, .62); sl.shadow_soft_size = .05
                    so_ = bpy.data.objects.new('roi-tuong', sl); sc.collection.objects.link(so_); so_.location = (q_.x, q_.y, H - .08); nsp += 1
        # bóng đổ mềm xuống nền (shadow catcher)
        bpy.ops.mesh.primitive_plane_add(size=300, location=(cen.x, cen.y, -.06)); sh_ = bpy.context.object; sh_.is_shadow_catcher = True
        on = Vector((OUTN.x, OUTN.y)) if OUTN.length > .01 else Vector((1, 0))
        az = math.atan2(on.y, on.x) + math.radians(float(os.environ.get('TOPAZ', '-38')))   # đứng phía mặt kính, lệch sang 1 góc
        EL = math.radians(float(os.environ.get('TOPEL', '58'))); dvec = Vector((math.cos(az) * math.cos(EL), math.sin(az) * math.cos(EL), math.sin(EL)))
        cam_d.type = 'PERSP'; cam_d.lens = 45; cam_d.sensor_fit = 'AUTO'; cam_d.shift_x = cam_d.shift_y = 0; cam_d.clip_end = 2000
        sc.render.resolution_x, sc.render.resolution_y = TW_, TH_
        pts = [Vector((x, y, z)) for x in (X0, X1) for y in (Y0, Y1) for z in (0, H)] + [Vector((p[0], p[1], 0)) for p in BX]
        dist = 40.
        for it_ in range(6):   # canh khung: căn chiếm ~82% khung, nằm giữa (chừa chỗ nhãn phía dưới)
            cam.location = cen + Vector((0, 0, H / 2)) + dvec * dist; cam.rotation_euler = (-dvec).to_track_quat('-Z', 'Y').to_euler(); bpy.context.view_layer.update()
            pr = [world_to_camera_view(sc, cam, q) for q in pts]
            mnx, mxx, mny, mxy = min(r.x for r in pr), max(r.x for r in pr), min(r.y for r in pr), max(r.y for r in pr)
            fill = max((mxx - mnx) / .93, (mxy - mny) / .8)
            dist *= fill
            cam_d.shift_x += ((mnx + mxx) / 2 - .5) * (1 if TW_ >= TH_ else TW_ / TH_)
            cam_d.shift_y += ((mny + mxy) / 2 - .55) * (TH_ / TW_ if TW_ >= TH_ else 1)
        sc.view_settings.exposure = float(os.environ.get('TOPEXPO', '-0.3')); sc.view_settings.look = 'AgX - Medium High Contrast'
        bpy.context.view_layer.update()
        def px(q): r = world_to_camera_view(sc, cam, q); return [round(r.x * TW_, 1), round((1 - r.y) * TH_, 1)]
        corners = [Vector((x, y, 0)) for x in (UX0, UX1) for y in (UY0, UY1)]
        near = max(corners, key=lambda q: (q - cen).dot(dvec))                 # góc gần máy ảnh nhất
        dims = []
        for axis in (0, 1):
            far = near.copy(); far[axis] = (UX0 + UX1 - near.x) if axis == 0 else (UY0 + UY1 - near.y)
            off = Vector((0, 0, 0)); oa = 1 - axis; off[oa] = 1.1 * (1 if near[oa] > cen[oa] else -1)
            dims.append([px(near + off), px(far + off), int(round(abs(far[axis] - near[axis]) * 1000 / 10) * 10)])
        json.dump({'dims': dims, 'w': TW_, 'h': TH_}, open(os.path.join(OUT, 'top.json'), 'w'))
        sc.render.filepath = os.path.join(OUT, 'top.png'); bpy.ops.render.render(write_still=True); print('xong top', flush=True)
    elif s == 'garden' and GGLASS:   # từ trong căn nhìn ra sân vườn
        c2, nv = GGLASS; e_ = c2 - nv * 2.6; g_ = Vector(GCEN)
        cam_d.type = 'PERSP'; cam_d.lens = 14; cam_d.shift_y = 0; cam.location = (e_.x, e_.y, 1.35)
        cam.rotation_euler = (math.radians(86), 0, math.atan2(g_.y - e_.y, g_.x - e_.x) - math.pi / 2)
        sc.render.filepath = os.path.join(OUT, 'garden.png'); bpy.ops.render.render(write_still=True); print('xong garden', flush=True)
    elif s in SH:
        e, l, lens, z, sy = SH[s]; shoot(s, e, l, lens, z, sy)

# ---------------- video 9:16: đi từ cửa vào ra ban công rồi quay sang phòng ngủ ----------------
if 'tour' in SHOTS:   # video tham quan liền mạch (đường cong Catmull–Rom, không dừng giật)
    sc.render.resolution_x, sc.render.resolution_y = int(os.environ.get('VW', '432')), int(os.environ.get('VH', '768'))
    sc.view_settings.exposure = float(os.environ.get('EXPO', '1.15')); cam_d.type = 'PERSP'; cam_d.lens = 18; cam_d.shift_y = 0
    K = json.loads(os.environ['TOURK'])            # [[[x,y],[nhìn x,y]], …] theo bản vẽ căn
    FPS = 24; sc.render.fps = FPS; SPD = float(os.environ.get('TSPD', '1.0'))
    def cr(p0, p1, p2, p3, t):
        return tuple(.5 * (2 * p1[i] + (-p0[i] + p2[i]) * t + (2 * p0[i] - 5 * p1[i] + 4 * p2[i] - p3[i]) * t * t + (-p0[i] + 3 * p1[i] - 3 * p2[i] + p3[i]) * t ** 3) for i in range(2))
    E = [P(*k[0]) for k in K]; Lk = [P(*k[1]) for k in K]
    yaws = [math.atan2(Lk[i][1] - E[i][1], Lk[i][0] - E[i][0]) for i in range(len(K))]
    for i in range(1, len(yaws)):
        while yaws[i] - yaws[i - 1] > math.pi: yaws[i] -= 2 * math.pi
        while yaws[i] - yaws[i - 1] < -math.pi: yaws[i] += 2 * math.pi
    nseg = []
    for i in range(len(K) - 1):
        dd = math.dist(E[i], E[i + 1]); da = abs(yaws[i + 1] - yaws[i])
        nseg.append(max(18, int(FPS * max(dd / .9, da / .75) / SPD)))
    f = 1
    for i in range(len(K) - 1):
        for j in range(nseg[i]):
            t = j / nseg[i]; ix = lambda q: max(0, min(len(K) - 1, q))
            e = cr(E[ix(i - 1)], E[i], E[i + 1], E[ix(i + 2)], t)
            yw = cr((yaws[ix(i - 1)], 0), (yaws[i], 0), (yaws[i + 1], 0), (yaws[ix(i + 2)], 0), t)[0]
            cam.location = (e[0], e[1], 1.5); cam.rotation_euler = (math.radians(88), 0, yw - math.pi / 2)
            cam.keyframe_insert('location', frame=f); cam.keyframe_insert('rotation_euler', frame=f); f += 1
    cam.location = (*E[-1], 1.5); cam.rotation_euler = (math.radians(88), 0, yaws[-1] - math.pi / 2)
    for k2 in range(int(FPS * 1.5)): cam.keyframe_insert('location', frame=f); cam.keyframe_insert('rotation_euler', frame=f); f += 1
    for fc in cam.animation_data.action.fcurves:
        for kp in fc.keyframe_points: kp.interpolation = 'LINEAR'
    sc.frame_start, sc.frame_end = 1, f - 1; print('so khung', f - 1, flush=True)
    if os.environ.get('PREV'):   # chụp thử vài khung
        os.makedirs(os.path.join(OUT, 'prev'), exist_ok=True)
        for fr in [int(v) for v in os.environ['PREV'].split(',')]:
            sc.frame_set(fr); sc.render.filepath = os.path.join(OUT, 'prev', 'p%04d.png' % fr); bpy.ops.render.render(write_still=True)
        sys.exit(0)
    if os.environ.get('DRY'): sys.exit(0)
    sc.render.filepath = os.path.join(OUT, 'tour', 'f'); os.makedirs(os.path.join(OUT, 'tour'), exist_ok=True)
    sc.render.use_overwrite = False; sc.render.use_placeholder = True   # chạy lại thì render tiếp các khung còn thiếu
    bpy.ops.render.render(animation=True); print('xong tour', flush=True)

if 'video' in SHOTS:
    sc.render.resolution_x, sc.render.resolution_y = int(os.environ.get('VW', '540')), int(os.environ.get('VH', '960'))
    sc.view_settings.exposure = float(os.environ.get('EXPO', '1.15')); cam_d.type = 'PERSP'; cam_d.lens = 14; cam_d.shift_y = 0
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
