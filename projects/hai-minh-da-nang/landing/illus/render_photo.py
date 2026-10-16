import sys, numpy as np
from PIL import Image, ImageDraw
from scipy import ndimage as nd

W, H = 1200, 800
Y, X = np.mgrid[0:H, 0:W].astype(np.float32)
SS = 3


def C(*c):
    return np.array(c, np.float32)


def fbm(h, w, cell, octs=5, seed=0, ax=1.0, ay=1.0, pers=0.55):
    r = np.random.default_rng(seed)
    out = np.zeros((h, w), np.float32); amp = 1.0; tot = 0
    for o in range(octs):
        cx = max(cell * ax / 2 ** o, 1.0); cy = max(cell * ay / 2 ** o, 1.0)
        gw = int(w / cx) + 4; gh = int(h / cy) + 4
        g = r.standard_normal((gh, gw)).astype(np.float32)
        a = np.asarray(Image.fromarray(g, 'F').resize((int(gw * cx), int(gh * cy)), Image.BICUBIC))[:h, :w]
        out += a * amp; tot += amp; amp *= pers
    out /= tot
    return (out - out.mean()) / (out.std() + 1e-6)


def mask(fn, blur=0):
    im = Image.new('L', (W * SS, H * SS), 0); fn(ImageDraw.Draw(im), SS)
    m = np.asarray(im.resize((W, H), Image.BOX), np.float32) / 255
    return nd.gaussian_filter(m, blur) if blur else m


def polym(pts, blur=0):
    return mask(lambda d, s: d.polygon([(x * s, y * s) for x, y in pts], fill=255), blur)


def ellm(x0, y0, x1, y1, blur=0):
    return mask(lambda d, s: d.ellipse([x0 * s, y0 * s, x1 * s, y1 * s], fill=255), blur)


def rectm(x0, y0, x1, y1, blur=0):
    return polym([(x0, y0), (x1, y0), (x1, y1), (x0, y1)], blur)


def over(img, col, m):
    m = m[..., None]
    return img * (1 - m) + np.asarray(col, np.float32) * m


def add(img, col, m):
    return img + np.asarray(col, np.float32) * m[..., None]


def blur3(img, s):
    s = s if isinstance(s, tuple) else (s, s)
    return np.stack([nd.gaussian_filter(img[..., i], s) for i in range(3)], -1)


def sstep(e0, e1, x):
    t = np.clip((x - e0) / (e1 - e0), 0, 1)
    return t * t * (3 - 2 * t)


def lum(img):
    return img[..., 0] * .3 + img[..., 1] * .59 + img[..., 2] * .11


def grad_rows(stops):
    ys = [s[0] for s in stops]; cols = np.array([s[1] for s in stops], np.float32)
    g = np.stack([np.interp(np.arange(H), ys, cols[:, i]) for i in range(3)], -1).astype(np.float32)
    return np.repeat(g[:, None, :], W, 1)


def sample(img, yy, xx):
    return np.stack([nd.map_coordinates(img[..., i], [yy, xx], order=1, mode='nearest') for i in range(3)], -1)


def sky(stops, sun=None, glows=(), sun_r=0, sun_core=(1, 1, .95), clouds=None, seed=1):
    img = grad_rows(stops)
    if sun:
        sx, sy = sun; d = np.hypot(X - sx, (Y - sy) * 1.1)
        for sig, col in glows:
            img += C(*col) * np.exp(-d / sig)[..., None]
        if sun_r:
            img = over(img, sun_core, sstep(sun_r + 1.2, sun_r - 1.2, d))
    if clouds:
        c = clouds
        n = fbm(H, W, c['cell'], 6, seed, ax=c.get('ax', 4))
        band = sstep(c['y0'], c['y0'] + 70, Y) * sstep(c['y1'], c['y1'] - 70, Y)
        dens = np.clip((n - c['thr']) * c['k'], 0, 1) * band * c['op']
        gy = np.gradient(nd.gaussian_filter(dens, 4), axis=0)
        w = 0.4 + gy * c.get('gs', 0)
        if sun and c.get('litr'):
            w = w + c.get('pw', 1) * np.exp(-np.hypot(X - sun[0], Y - sun[1]) / c['litr'])
        w = np.clip(w, 0, 1)[..., None]
        ccol = C(*c['dark']) * (1 - w) + C(*c['lit']) * w
        img = over(img, ccol, dens)
    return img


def sea(img, hz, deep, near, seed=3, ax_=.10, ay_=.12, ff=.92, fn=.35, sunx=None, glit=0, suncol=(1, 1, 1), cellw=110):
    tex = nd.gaussian_filter(fbm(1024, 1024, 48, 6, seed, ax=3), 0.7)
    gy, gx = np.gradient(tex)
    gx /= gx.std(); gy /= gy.std()
    hi = fbm(1024, 1024, 10, 3, seed + 7, ax=3)
    rows = H - hz
    dy = (Y[hz:] - hz + 0.8)
    Xs = X[hz:]
    tu = ((Xs - W / 2) * 512 / dy) % 1024
    tv = (409600 / dy) % 1024
    sgx = nd.map_coordinates(gx, [tv, tu], order=1, mode='wrap')
    sgy = nd.map_coordinates(gy, [tv, tu], order=1, mode='wrap')
    shi = nd.map_coordinates(hi, [tv, tu], order=1, mode='wrap')
    fade = sstep(0, 40, dy)
    sgx *= fade; sgy *= fade
    rx = np.clip(Xs + sgx * dy * ax_, 0, W - 1)
    ry = np.clip(hz - dy * 0.95 + sgy * dy * ay_, 0, hz - 1)
    refl = sample(img, ry, rx)
    refl = blur3(refl, (1.5, 2.5))
    t = (dy / rows)[..., None]
    wcol = C(*deep) * (1 - t) + C(*near) * t
    R = (fn + (ff - fn) * np.exp(-dy / (0.22 * rows)))[..., None]
    col = wcol * (1 - R) + refl * R
    col *= (1 + 0.05 * sgy * fade)[..., None]
    if sunx is not None and glit:
        wd = 10 + dy * 0.45
        g = np.exp(-((Xs - sunx) / wd) ** 2) * np.clip(shi - 1.2, 0, None) * glit
        col += C(*suncol) * g[..., None]
    img = img.copy(); img[hz:] = col
    b = blur3(img[hz - 3:hz + 4], (1.2, 0))
    img[hz - 3:hz + 4] = b
    return img


def softclip(x):
    return np.where(x < .8, x, .8 + .2 * (1 - np.exp(-(x - .8) / .2)))


def finish(img, path, bloom=.5, vig=.35, grain=.018, seed=9, warm=(1, 1, 1), lift=0.0):
    b = np.clip(img - .78, 0, None)
    img = img + blur3(b, 6) * bloom * .6 + blur3(b, 35) * bloom
    img = img * C(*warm)
    r = np.hypot((X - W / 2) / W, (Y - H / 2) / H) * 1.7
    img = img * (1 - vig * r ** 2)[..., None]
    img = softclip(np.clip(img, 0, None))
    img = img * (1 - lift) + lift * C(.10, .09, .12)
    img = img + np.random.default_rng(seed).normal(0, grain, (H, W, 1)).astype(np.float32)
    img = np.clip(img, 0, 1) ** (1 / 1.0)
    Image.fromarray((img * 255 + .5).astype(np.uint8)).save(path)


def sphere(img, cx, cy, r, col, light=(-.5, -.6, .62)):
    d2 = ((X - cx) ** 2 + (Y - cy) ** 2) / r ** 2
    m = sstep(1.0, 0.92, d2)
    nz = np.sqrt(np.clip(1 - d2, 0, 1)); nx = (X - cx) / r; ny = (Y - cy) / r
    L = np.array(light); L /= np.linalg.norm(L)
    dif = np.clip(nx * L[0] + ny * L[1] + nz * L[2], 0, 1)
    spec = np.clip(nx * L[0] + ny * L[1] + nz * L[2], 0, 1) ** 40
    c = C(*col) * (0.25 + 0.85 * dif)[..., None] + C(1, 1, 1) * (spec * .6)[..., None]
    return over(img, c, m)


# --------------------------------------------------------------- scene 1
def scene1(path):
    hz = 420; sx, sy = 790, 404
    img = sky([(0, (.15, .19, .33)), (150, (.33, .34, .50)), (280, (.74, .54, .55)), (370, (1.0, .70, .50)), (hz, (1.0, .80, .60))],
              sun=(sx, sy), glows=[(16, (1, .75, .4)), (80, (.65, .36, .14)), (280, (.28, .14, .06))], sun_r=23, sun_core=(1.4, 1.22, .95),
              clouds=dict(cell=110, ax=5, thr=.45, k=1.3, y0=100, y1=360, op=.8, lit=(1.25, .66, .44), dark=(.36, .29, .40), litr=300, pw=1.0, gs=-30), seed=5)
    img = sea(img, hz, (.07, .08, .16), (.10, .09, .16), seed=4, ax_=.08, ay_=.16, ff=.95, fn=.55, sunx=sx, glit=1.2, suncol=(1.5, 1.0, .55))
    outside = img.copy()
    # balcony glass rail outside
    img[588:652] *= C(.80, .84, .90)
    img = over(img, (.04, .035, .04), rectm(0, 580, W, 588))
    img = add(img, (.9, .55, .3), rectm(0, 580, W, 581.2) * .5)
    # interior
    wl, wr, wt, wb = 78, 1122, 36, 652
    win = rectm(wl, wt, wr, wb)
    dwin = np.minimum.reduce([np.abs(X - wl), np.abs(X - wr)])
    wall = C(.10, .075, .062) * (1 + 1.6 * np.exp(-dwin / 70))[..., None]
    room = np.broadcast_to(wall, (H, W, 3)).copy()
    room[:wt] = C(.08, .06, .05) * (1 + .8 * np.exp(-(wt - Y[:wt]) / 20))[..., None]
    # floor
    fl = Y >= wb
    fy = Y - wb
    plank = np.zeros((H, W), np.float32)
    for k in range(-14, 15):
        xb = 600 + k * 120
        xl = 600 + (xb - 600) * (fy / 148) * 0.0 + (600 + k * 22 - 600) * (1 - fy / 148) + (xb - 600) * (fy / 148)
        plank += np.exp(-((X - xl) / 1.2) ** 2)
    wood = C(.15, .095, .065) * (1 + .08 * fbm(H, W, 40, 4, 11, ax=.3))[..., None] * (1 - .35 * np.clip(plank, 0, 1))[..., None]
    room = np.where(fl[..., None], wood, room)
    # floor reflection of the window
    src = img[wb - 148:wb][::-1]
    ref = blur3(src, (6, 2)) * (.32 * np.exp(-np.arange(148) / 90))[:, None, None]
    room[wb:] += ref
    img = room * (1 - win[..., None]) + img * win[..., None]
    # frames
    for x0, x1 in [(wl, wl + 18), (wr - 18, wr), (592, 606)]:
        img = over(img, (.035, .03, .03), rectm(x0, wt, x1, wb))
    img = over(img, (.035, .03, .03), rectm(wl, wt, wr, wt + 16))
    img = over(img, (.05, .04, .035), rectm(wl - 6, wb - 10, wr + 6, wb + 2))
    img = add(img, (1, .62, .34), rectm(606, wt + 16, 607.2, wb - 10) * .55)
    img = add(img, (1, .62, .34), rectm(wl - 6, wb - 10, wr + 6, wb - 8.8) * .5)
    # sun patch on floor & beams
    patch = polym([(700, wb + 2), (880, wb + 2), (1010, 800), (560, 800)], 7) * sstep(800, wb, Y) ** .5
    img = add(img, (1.0, .58, .30), patch * .5)
    beam = polym([(sx - 70, 400), (sx + 70, 400), (1180, 800), (420, 800)], 45)
    img = add(img, (.55, .32, .16), beam * .13 * (1 - win * .6))
    rng = np.random.default_rng(3)
    dust = np.zeros((H, W), np.float32)
    for _ in range(140):
        x, y = rng.uniform(420, 1150), rng.uniform(420, 790)
        if beam[int(y), int(x)] > .25:
            dust[int(y), int(x)] = rng.uniform(.4, 1)
    img = add(img, (1, .8, .55), nd.gaussian_filter(dust, 1.1) * 4)
    # sheer curtains
    lb = blur3(outside, 30); lbl = lum(lb)
    for x0, x1, xb0, xb1, per in [(56, 250, 30, 300, 15), (1000, 1146, 980, 1175, 11)]:
        cm = polym([(x0, 30), (x1, 30), (xb1, 690), (xb0, 690)], 1.5)
        f = .5 + .5 * np.sin((X - x0) / per + 1.8 * np.sin(Y / 110))
        back = np.where(win > .5, .25 + 1.1 * lbl, .18)[..., None]
        ccol = C(.95, .82, .70) * back * (.7 + .45 * f)[..., None]
        img = over(img, ccol, cm * (.55 + .25 * f))
    # foreground: sofa back + side table + cup (slightly out of focus)
    fg = np.zeros((H, W, 3), np.float32); fm = np.zeros((H, W), np.float32)
    pts = [(236, 800)]
    for x in range(240, 965, 5):
        t = ((x - 240) % 362) / 362
        pts.append((x, 642 - 16 * np.sin(np.pi * t) ** .45 + 30 * (1 - sstep(240, 290, x)) + 30 * sstep(915, 965, x)))
    pts += [(968, 800)]
    sm = polym(pts)
    sofa = C(.15, .115, .10) * (1 + .05 * fbm(H, W, 6, 3, 21))[..., None] * (1 + .25 * sstep(700, 630, Y))[..., None]
    seam = np.exp(-((X - 602) / 2.5) ** 2) * sstep(625, 660, Y)
    sofa *= (1 - .45 * seam)[..., None]
    sofa *= (.75 + .35 * np.exp(-np.abs(X - sx) / 500))[..., None]
    rim = np.clip(sm - nd.shift(sm, (3.5, 0), order=1), 0, 1)
    sofa += C(1.1, .66, .36) * (nd.gaussian_filter(rim, 1.3) * 1.6 * np.exp(-np.abs(X - sx) / 380))[..., None]
    fg = over(fg, sofa, sm); fm = np.maximum(fm, sm)
    tm = np.maximum(ellm(110, 650, 236, 668), rectm(168, 660, 178, 800))
    tcol = C(.06, .045, .04) + C(.9, .55, .3) * (np.clip(ellm(110, 650, 236, 668) - ellm(110, 652.5, 236, 670), 0, 1) * .7)[..., None]
    fg = over(fg, tcol, tm); fm = np.maximum(fm, tm)
    cup = np.maximum(polym([(152, 624), (194, 624), (190, 657), (156, 657)]), ellm(152, 619, 194, 629))
    cupc = C(.07, .055, .05) + C(1.1, .7, .4) * (np.clip(cup - nd.shift(cup, (0, 2.5), order=1), 0, 1) * .8)[..., None]
    fg = over(fg, cupc, cup); fm = np.maximum(fm, cup)
    hm = np.maximum(ellm(190, 630, 208, 650) - ellm(194, 634, 204, 646), 0)
    fg = over(fg, C(.07, .055, .05), hm); fm = np.maximum(fm, hm)
    fgb = blur3(fg * fm[..., None], 2.2); fmb = nd.gaussian_filter(fm, 2.2)
    img = img * (1 - fmb[..., None]) + fgb
    # steam (backlit)
    sn = fbm(H, W, 14, 4, 31, ax=.6)
    off = 9 * np.sin((Y - 560) / 16) + 5 * np.sin(Y / 7)
    wid = 5 + (622 - Y) * .14
    steam = np.exp(-((X - 173 - off) / wid) ** 2) * sstep(520, 590, Y) * sstep(624, 612, Y) * np.clip(sn * .6 + .35, 0, 1)
    img = add(img, (1, .86, .72), steam * .38)
    finish(img, path, bloom=.6, vig=.45, warm=(1.04, 1.0, .95))


# --------------------------------------------------------------- scene 2
def scene2(path):
    hz = 318
    img = sky([(0, (.27, .52, .84)), (180, (.50, .72, .93)), (hz, (.84, .91, .97))],
              sun=(1250, -80), glows=[(260, (.45, .40, .28))],
              clouds=dict(cell=70, ax=2.2, thr=.75, k=1.6, y0=40, y1=300, op=.95, lit=(1.08, 1.06, 1.02), dark=(.66, .73, .85), gs=60), seed=8)
    img = sea(img, hz, (.03, .22, .40), (.06, .44, .55), seed=6, ax_=.06, ay_=.10, ff=.75, fn=.12, sunx=1050, glit=.9, suncol=(1.2, 1.15, 1.0))
    # boat
    img = over(img, (.95, .95, .95), polym([(858, 314), (858, 296), (872, 314)]))
    img = over(img, (.2, .22, .26), polym([(852, 315), (878, 315), (875, 318), (855, 318)]))
    img = blur3(img, 1.3)
    outside = img.copy()
    # glass railing outside
    img[488:600] = img[488:600] * C(.90, .95, .97) + .02
    img = over(img, (.80, .82, .84), rectm(0, 482, W, 488))
    for px in [340, 860]:
        img = over(img, (.72, .74, .77), rectm(px, 488, px + 4, 600))
    wl, wr, wt, wb = 120, 1080, 40, 610
    win = rectm(wl, wt, wr, wb)
    dwin = np.minimum(np.abs(X - wl), np.abs(X - wr))
    room = (C(.74, .70, .64) * (1 + .35 * np.exp(-dwin / 120))[..., None])
    room = np.broadcast_to(room, (H, W, 3)).copy()
    room[:wt] = C(.82, .79, .74)
    img = room * (1 - win[..., None]) + img * win[..., None]
    fr = (.92, .91, .89)
    for x0, x1 in [(wl, wl + 14), (wr - 14, wr), (594, 604)]:
        img = over(img, fr, rectm(x0, wt, x1, wb))
    img = over(img, fr, rectm(wl, wt, wr, wt + 12))
    img = over(img, (.70, .68, .66), rectm(594, wt, 596, wb) * .6)
    # sheer curtains
    lbl = lum(blur3(outside, 30))
    for x0, x1, xb0, xb1, per in [(30, 240, 10, 300, 13), (990, 1180, 960, 1200, 12)]:
        edge = 14 * np.sin(Y / 60)
        cm = polym([(x0, 30)] + [(x1 + 14 * np.sin(y / 60), y) for y in range(30, 640, 10)] + [(xb0, 640)], 1.5)
        f = .5 + .5 * np.sin((X - x0) / per + 1.5 * np.sin(Y / 95))
        back = np.where(win > .5, .55 + .55 * lbl, .62)[..., None]
        img = over(img, C(1.0, .98, .95) * back * (.82 + .25 * f)[..., None], cm * (.45 + .3 * f))
    # duvet
    top = 585 + 0.00003 * (X - 600) ** 2
    dm = sstep(top - 1, top + 1, Y)
    hd = np.zeros((H, W), np.float32)
    for a, c, s, A in [(.45, 900, 26, 1), (.55, 1140, 34, -.8), (-.35, 120, 30, .9), (.3, 700, 18, .6), (-.5, -90, 40, -.7)]:
        d = X * np.cos(a) + Y * np.sin(a) * 2.2 - c
        hd += A * np.exp(-d ** 2 / (2 * s * s))
    hd += .08 * fbm(H, W, 140, 2, 41)
    hd *= sstep(top, top + 160, Y)
    gyh, gxh = np.gradient(nd.gaussian_filter(hd, 2))
    shade = np.clip(.93 - gyh * 5 + gxh * 2.5, .72, 1.06)
    duv = C(.97, .95, .92) * shade[..., None]
    duv *= (1 - .06 * sstep(top + 40, top, Y))[..., None]
    sun_p = polym([(560, top.min() + 10), (1000, top.min() + 10), (1160, 800), (620, 800)], 18)
    sun_p *= 1 - polym([(780, 590), (800, 590), (880, 800), (850, 800)], 6)
    duv += C(.12, .10, .06) * sun_p[..., None]
    img = img * (1 - dm[..., None]) + duv * dm[..., None]
    img = add(img, (1, 1, 1), np.exp(-((Y - top) / 1.4) ** 2) * .15)
    # tray shadow + tray
    img *= (1 - .32 * polym([(370, 632), (790, 632), (840, 722), (318, 722)], 12))[..., None]
    tray = polym([(380, 618), (800, 618), (850, 703), (330, 703)])
    grain = 1 + .09 * fbm(H, W, 30, 4, 51, ax=6, ay=.4)
    wood = C(.60, .42, .27) * grain[..., None] * (1 + .12 * sstep(703, 618, Y))[..., None]
    img = over(img, wood, tray)
    img = over(img, C(.40, .27, .17) * grain[..., None], polym([(330, 703), (850, 703), (848, 714), (332, 714)]))
    inner = polym([(392, 624), (790, 624), (834, 697), (344, 697)])
    img = add(img, (-.08, -.06, -.04), np.clip(tray - inner, 0, 1) * .8)
    img = add(img, (.25, .2, .14), np.clip(tray - inner, 0, 1) * sstep(640, 618, Y) * .8)
    # saucer + cup
    img *= (1 - .25 * ellm(436, 655, 545, 690, 6))[..., None]
    sau = ellm(428, 648, 534, 676)
    img = over(img, C(.93, .92, .90) * (1 + .1 * sstep(676, 648, Y))[..., None], sau)
    cx, r = 480, 27
    xn = np.clip((X - cx) / r, -1, 1)
    body = np.maximum(polym([(cx - r, 610), (cx + r, 610), (cx + r - 3, 652), (cx - r + 3, 652)]), ellm(cx - r + 3, 645, cx + r - 3, 659))
    bc = C(.96, .95, .93) * (.62 + .45 * np.cos(xn * 1.4 + .35))[..., None]
    img = over(img, bc, body)
    hm = np.clip(ellm(cx + r - 6, 617, cx + r + 15, 645) - ellm(cx + r - 1, 622, cx + r + 9, 640), 0, 1)
    img = over(img, C(.85, .84, .82), hm)
    img = over(img, (.98, .97, .95), ellm(cx - r, 603, cx + r, 617))
    img = over(img, (.30, .17, .09), ellm(cx - r + 4, 605, cx + r - 4, 615))
    img = add(img, (.6, .45, .3), ellm(cx - 12, 607, cx - 2, 610, 1) * .5)
    # juice glass
    gx0, gx1, gt, gbm = 610, 662, 578, 672
    gl = polym([(gx0, gt), (gx1, gt), (gx1 - 3, gbm), (gx0 + 3, gbm)])
    juice = gl * sstep(593, 595, Y)
    gxn = (X - (gx0 + gx1) / 2) / ((gx1 - gx0) / 2)
    jc = C(1.0, .52, .10) * (.75 + .45 * np.cos(np.clip(gxn, -1, 1) * 1.3))[..., None]
    img *= (1 - .2 * polym([(gx0 + 10, gbm), (gx1 + 20, gbm), (gx1 + 60, gbm + 20), (gx0 + 30, gbm + 20)], 6))[..., None]
    img = over(img, img * .85 + .1, gl)
    img = over(img, jc, juice)
    img = over(img, (1.0, .66, .25), ellm(gx0 + 1, 589, gx1 - 1, 599) * 1.0)
    img = add(img, (1, 1, 1), rectm(gx0 + 7, gt + 4, gx0 + 10, gbm - 8, .8) * .55)
    img = add(img, (1, 1, 1), np.clip(ellm(gx0, gt - 5, gx1, gt + 5) - ellm(gx0 + 2, gt - 3, gx1 - 2, gt + 3), 0, 1) * .5)
    # plate with strawberries
    img *= (1 - .25 * ellm(700, 660, 810, 700, 6))[..., None]
    img = over(img, C(.94, .93, .91), ellm(692, 645, 806, 680))
    img = over(img, C(.86, .85, .83), ellm(706, 650, 792, 675))
    for (x, y, rr) in [(732, 655, 13), (760, 652, 12), (748, 664, 13), (775, 662, 12)]:
        img = sphere(img, x, y, rr, (.78, .07, .09))
        img = over(img, (.2, .45, .12), ellm(x - 5, y - rr - 2, x + 5, y - rr + 4))
    # depth of field: near foreground soft
    k = sstep(712, 800, Y)[..., None]
    img = img * (1 - k) + blur3(img, 7) * k
    finish(img, path, bloom=.55, vig=.22, warm=(1.03, 1.0, .96), grain=.014)


# --------------------------------------------------------------- scene 3
def scene3(path):
    hz = 455; mx, my = 820, 352
    img = sky([(0, (.06, .08, .20)), (150, (.14, .15, .34)), (290, (.40, .32, .52)), (390, (.88, .56, .58)), (430, (.98, .70, .60)), (448, (.62, .56, .66)), (hz, (.50, .48, .62))],
              sun=(mx, my), glows=[(10, (.6, .55, .42)), (70, (.18, .16, .14))], sun_r=13, sun_core=(1.15, 1.08, .92),
              clouds=dict(cell=120, ax=5, thr=.55, k=1.4, y0=120, y1=380, op=.85, lit=(1.25, .62, .46), dark=(.30, .23, .38), gs=-45), seed=12)
    # Son Tra silhouette
    pts = [(0, 455)] + [(x, 455 - 70 * np.exp(-((x - 150) / 150) ** 2) - 40 * np.exp(-((x - 300) / 110) ** 2) - 6 * np.sin(x / 23)) for x in range(0, 470, 6)] + [(470, 455)]
    mnt = polym(pts, .8)
    mcol = C(.30, .25, .38) * (1 + .25 * sstep(380, 455, Y))[..., None]
    img = over(img, mcol, mnt)
    img = sea(img, hz, (.08, .07, .15), (.12, .09, .17), seed=9, ax_=.08, ay_=.15, ff=.93, fn=.55, sunx=mx, glit=.9, suncol=(1.0, .95, .8))
    rng = np.random.default_rng(4)
    pts_l = np.zeros((H, W), np.float32)
    for x in range(10, 450, 9):
        pts_l[int(rng.uniform(446, 454)), x + int(rng.integers(0, 5))] = rng.uniform(.5, 1)
    pts_l[454, 980] = .8; pts_l[454, 1060] = .6
    img = add(img, (1.3, .9, .5), nd.gaussian_filter(pts_l, .8) * 3.5)
    # glass railing
    img[592:] = img[592:] * C(.78, .82, .90) + .015
    streak = polym([(150, 592), (260, 592), (120, 800), (10, 800)], 25) + polym([(900, 592), (960, 592), (900, 800), (840, 800)], 20)
    img = add(img, (.9, .7, .8), streak * .05)
    img = over(img, (.04, .04, .06), rectm(0, 582, W, 592))
    img = add(img, (1, .7, .7), rectm(0, 582, W, 583.3) * .45)
    # table
    tb = ellm(170, 712, 1030, 950)
    tsk = blur3(img[712 - 88:712][::-1], (4, 10))
    tcol = np.broadcast_to(C(.08, .06, .07), (H, W, 3)).copy()
    tcol[712:] += tsk * .22
    img = over(img, tcol, tb)
    img = add(img, (1, .8, .7), np.clip(tb - nd.shift(tb, (2, 0), order=1), 0, 1) * .5)
    # candle
    cxc = 600
    fl_d = np.hypot(X - cxc, (Y - 672) * 1.3)
    img = add(img, (1.0, .55, .22), np.exp(-fl_d / 150) * .22 * tb + np.exp(-fl_d / 260) * .05)
    jar = rectm(578, 650, 622, 724)
    img = over(img, img * .8 + C(.25, .12, .05), jar * .7)
    img = over(img, (.95, .88, .78), rectm(586, 686, 614, 722) * .9)
    img = add(img, (1, .7, .35), rectm(586, 686, 614, 690) * .5)
    flame = np.exp(-((X - cxc) / 3.5) ** 2 - ((Y - 676) / 9) ** 2)
    img = add(img, (1.6, 1.1, .5), flame * 1.2)
    img = add(img, (1, .55, .2), np.exp(-fl_d / 22) * .45)
    img = add(img, (1, .9, .8), np.clip(jar - nd.shift(jar, (0, 2), order=1), 0, 1) * .4)
    # wine glasses
    prof_t = [0, .08, .25, .45, .65, .82, 1]
    prof_w = [5, 26, 42, 47, 44, 40, 36]
    base_img = img.copy()
    for gcx, base in [(440, 742), (765, 748)]:
        bowl_b = base - 92; bowl_t = bowl_b - 150
        ts = np.linspace(0, 1, 40)
        hw = np.interp(ts, prof_t, prof_w)
        ys = bowl_b - ts * (bowl_b - bowl_t)
        bowl = polym([(gcx - w, y) for w, y in zip(hw, ys)] + [(gcx + w, y) for w, y in zip(hw[::-1], ys[::-1])])
        yy = np.clip(Y + (Y - (bowl_t + bowl_b) / 2) * -.25, 0, H - 1)
        xx = np.clip(gcx - (X - gcx) * .6, 0, W - 1)
        refr = sample(base_img, yy, xx)
        gcol = refr * .9 + .02
        img = over(img, gcol, bowl)
        wl_y = bowl_b - .45 * (bowl_b - bowl_t)
        wine = bowl * sstep(wl_y - 1, wl_y + 1, Y)
        lw = lum(refr)
        side = np.exp(-np.abs(X - cxc) / 250) * (1 + .3 * np.sign(cxc - gcx) * (X - gcx) / 40)
        wc = C(.42, .02, .06) * (.18 + 1.1 * lw)[..., None] * (.55 + .6 * sstep(bowl_b, wl_y, Y))[..., None] + C(.8, .12, .08) * (side * .22)[..., None]
        img = over(img, wc, wine)
        sw = np.interp(.45, prof_t, prof_w)
        img = over(img, (.45, .06, .10), np.clip(ellm(gcx - sw, wl_y - 4, gcx + sw, wl_y + 4), 0, 1) * .9)
        img = add(img, (1, .7, .6), np.clip(ellm(gcx - sw, wl_y - 4, gcx + sw, wl_y + 4) - ellm(gcx - sw + 2, wl_y - 2.5, gcx + sw - 2, wl_y + 4.5), 0, 1) * .5)
        edge = np.clip(bowl - nd.binary_erosion(bowl > .5, iterations=2).astype(np.float32), 0, 1)
        img = add(img, (.9, .8, .85), nd.gaussian_filter(edge, .6) * .55)
        img = add(img, (1, .95, .95), polym([(gcx - 30, bowl_t + 30), (gcx - 26, bowl_t + 30), (gcx - 32, bowl_b - 40), (gcx - 35, bowl_b - 40)], 1.2) * .7)
        rim = np.clip(ellm(gcx - 36, bowl_t - 5, gcx + 36, bowl_t + 5) - ellm(gcx - 34.5, bowl_t - 3.5, gcx + 34.5, bowl_t + 3.5), 0, 1)
        img = add(img, (1, .9, .9), rim * .6)
        ccand = 1 if gcx < cxc else -1
        img = add(img, (1.2, .8, .4), ellm(gcx + ccand * 30 - 3, bowl_b - 70, gcx + ccand * 30 + 3, bowl_b - 58, 1.2) * .9)
        stem = rectm(gcx - 2.5, bowl_b - 4, gcx + 2.5, base - 4)
        img = over(img, refr * .7 + .05, stem)
        img = add(img, (1, .9, .85), rectm(gcx - 1.5, bowl_b, gcx - .3, base - 6) * .5)
        foot = ellm(gcx - 38, base - 8, gcx + 38, base + 6)
        img = over(img, base_img * .7 + .03, foot * .8)
        img = add(img, (1, .85, .8), np.clip(foot - ellm(gcx - 36, base - 6, gcx + 36, base + 6), 0, 1) * .6)
    # string-light bokeh (near, out of focus)
    bok = np.zeros((H, W), np.float32)
    ring = np.zeros((H, W), np.float32)
    rng = np.random.default_rng(7)
    for i in range(16):
        x = -40 + i * 86 + rng.uniform(-6, 6)
        t = (x + 40) / 1290
        y = 40 + 120 * 4 * t * (1 - t) * .8 - 30
        r = rng.uniform(17, 27)
        d = np.hypot(X - x, Y - y)
        disk = sstep(r + 1.5, r - 1.5, d)
        bok += disk * rng.uniform(.6, 1)
        ring += disk * sstep(r - 5, r - 1, d)
    img = add(img, (1.0, .70, .36), bok * .55 + ring * .25)
    img = add(img, (1.0, .6, .3), nd.gaussian_filter(bok, 22) * .35)
    finish(img, path, bloom=.65, vig=.45, warm=(1.04, .99, 1.0), grain=.02)


if __name__ == '__main__':
    out = sys.argv[1]
    which = sys.argv[2:] or ['1', '2', '3']
    names = {'1': 'binh-minh-phong-khach', '2': 'phong-ngu-view-bien', '3': 'ban-cong-hoang-hon'}
    for w in which:
        {'1': scene1, '2': scene2, '3': scene3}[w](f'{out}/{names[w]}.png')
        print('ok', w)
