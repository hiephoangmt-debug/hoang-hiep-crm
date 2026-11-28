import json, math
C = json.load(open('cam.json'))
def ss(x): return x*x*(3-2*x)
def merc(lat, lon, z):
    n = 256 * 2**z; x = (lon + 180) / 360 * n
    y = (1 - math.log(math.tan(math.radians(lat)) + 1/math.cos(math.radians(lat))) / math.pi) / 2 * n
    return x, y
def cam(t):
    K = C['keys']
    if t <= K[0][0]: k = K[0]; return k[1:]
    for a, b in zip(K, K[1:]):
        if a[0] <= t <= b[0]:
            u = ss((t - a[0]) / (b[0] - a[0]) if b[0] > a[0] else 1)
            # interpolate center in mercator (z-independent), zoom linear
            ax, ay = merc(a[1], a[2], 0); bx, by = merc(b[1], b[2], 0)
            # zoom-aware path: weight center by zoom to avoid swing
            x = ax + (bx - ax) * u; y = ay + (by - ay) * u
            z = a[3] + (b[3] - a[3]) * u; r = a[4] + (b[4] - a[4]) * u
            return [x, y, z, r, 'm']
    k = K[-1]; return k[1:]
