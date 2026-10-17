# Tự tổng hợp nhạc nền điện ảnh + hiệu ứng whoosh, khớp với các mốc chuyển cảnh của video.
# Cách dùng: python3 music.py out/music.wav
import sys, wave
import numpy as np

SR = 44100
DUR = 60.0
N = int(SR * DUR)
t = np.arange(N) / SR
rng = np.random.default_rng(3)
FPS = 30
CUTS = [150, 470, 780, 1140, 1500]      # khung hình chuyển cảnh
END = 1650                        # cảnh kết
IMPACTS = [24, END]

def note(n):  # MIDI -> Hz
    return 440.0 * 2 ** ((n - 69) / 12)

def lowpass(x, fc):
    X = np.fft.rfft(x); f = np.fft.rfftfreq(len(x), 1 / SR)
    return np.fft.irfft(X / np.sqrt(1 + (f / fc) ** 4), len(x))

def bandpass(x, lo, hi):
    X = np.fft.rfft(x); f = np.fft.rfftfreq(len(x), 1 / SR)
    return np.fft.irfft(X * ((f > lo) & (f < hi)), len(x))

def env_adsr(n, a, r):
    e = np.ones(n); a = int(a * SR); r = int(r * SR)
    e[:a] = np.linspace(0, 1, a) ** 2; e[n - r:] *= np.linspace(1, 0, r) ** 2
    return e

L = np.zeros(N); R = np.zeros(N)

# 1) Nền pad: Am - F - C - G (mỗi hợp âm 4 giây), sóng răng cưa lệch tông, lọc mềm
chords = [[45, 52, 57, 60, 64], [41, 48, 53, 57, 60], [48, 55, 60, 64, 67], [43, 50, 55, 59, 62]]
seg = 4.0
for i in range(int(DUR / seg) + 1):
    s0 = int(i * seg * SR); n = int((seg + 1.5) * SR)
    if s0 >= N: break
    n = min(n, N - s0); tt = np.arange(n) / SR
    ch = chords[i % 4]
    pad = np.zeros(n)
    for k, m in enumerate(ch):
        for d in (-0.08, 0.0, 0.07):
            f0 = note(m) * 2 ** (d / 12)
            pad += 2 * ((tt * f0 + 0.13 * k + d) % 1) - 1
    pad /= np.sqrt((pad ** 2).mean()) * 4.5        # cân bằng âm lượng giữa các hợp âm
    dly = int(0.014 * SR)                          # độ rộng stereo kiểu Haas
    padL = pad; padR = np.concatenate([np.zeros(dly), pad[:-dly]])
    e = env_adsr(n, 1.4, 1.6)
    L[s0:s0 + n] += padL * e * 0.30; R[s0:s0 + n] += padR * e * 0.30
L = lowpass(L, 1400); R = lowpass(R, 1400)

# 2) Bass trầm theo hợp âm
bass = np.zeros(N)
for i in range(int(DUR / seg) + 1):
    s0 = int(i * seg * SR); n = min(int(seg * SR), N - s0)
    if n <= 0: break
    tt = np.arange(n) / SR
    bass[s0:s0 + n] += np.sin(2 * np.pi * note(chords[i % 4][0] - 12) * tt) * env_adsr(n, .3, .5)
L += bass * 0.16; R += bass * 0.16

# 3) Nhịp tim (kick mềm) từ giây 5 đến cảnh kết, 100 BPM
beat = 60 / 100
kick_n = int(0.45 * SR); kt = np.arange(kick_n) / SR
kick = np.sin(2 * np.pi * (45 + 90 * np.exp(-kt * 30)) * kt) * np.exp(-kt * 9)
tk = 5.0
while tk < END / FPS - 0.5:
    s0 = int(tk * SR); n = min(kick_n, N - s0)
    build = 0.55 + 0.45 * min(1, (tk - 5) / 30)
    L[s0:s0 + n] += kick[:n] * 0.30 * build; R[s0:s0 + n] += kick[:n] * 0.30 * build
    tk += beat

# 4) Lấp lánh: nốt ngũ cung cao, có vang
pent = [69, 72, 74, 76, 79, 81, 84]
tk = 5.0; step = beat / 2; idx = 0
pl_n = int(1.2 * SR); pt = np.arange(pl_n) / SR
while tk < END / FPS:
    if rng.random() < 0.55:
        m = pent[(idx * 3 + int(rng.random() * 3)) % len(pent)]
        tone = (np.sin(2 * np.pi * note(m) * pt) + 0.3 * np.sin(4 * np.pi * note(m) * pt)) * np.exp(-pt * 4)
        s0 = int(tk * SR); n = min(pl_n, N - s0); pan = rng.random()
        L[s0:s0 + n] += tone[:n] * 0.045 * (1 - pan); R[s0:s0 + n] += tone[:n] * 0.045 * pan
    tk += step; idx += 1

# 5) Whoosh trước mỗi lần chuyển cảnh + tiếng "boom" khi hiện chữ
noise = rng.standard_normal(N)
wn_n = int(1.6 * SR); wt = np.arange(wn_n) / SR
for c in CUTS + [END]:
    peak = c / FPS; s0 = int((peak - 1.1) * SR)
    seg_noise = noise[s0:s0 + wn_n].copy()
    # quét dải tần bằng cách trộn 3 băng tần theo thời gian
    b1 = bandpass(seg_noise, 300, 1200); b2 = bandpass(seg_noise, 1200, 4000); b3 = bandpass(seg_noise, 4000, 9000)
    x = wt / 1.1
    e = np.where(x < 1, x ** 3, np.exp(-(wt - 1.1) * 7))
    w = (b1 * (1 - np.clip(x, 0, 1)) + b2 + b3 * np.clip(x, 0, 1) * 0.6) * e
    pan = np.clip(0.5 + 0.45 * np.sin(np.pi * (x - 0.5)), 0, 1)
    L[s0:s0 + wn_n] += w * 0.09 * (1 - pan); R[s0:s0 + wn_n] += w * 0.09 * pan
boom_n = int(2.5 * SR); bt = np.arange(boom_n) / SR
boom = np.sin(2 * np.pi * (38 + 40 * np.exp(-bt * 6)) * bt) * np.exp(-bt * 2.2)
boom += lowpass(rng.standard_normal(boom_n), 900) * np.exp(-bt * 5) * 0.6
for c in IMPACTS:
    s0 = int(c / FPS * SR); n = min(boom_n, N - s0)
    L[s0:s0 + n] += boom[:n] * 0.32; R[s0:s0 + n] += boom[:n] * 0.32

# 6) Vang (reverb) tổng hợp
ir_n = int(2.2 * SR); it = np.arange(ir_n) / SR
irL = rng.standard_normal(ir_n) * np.exp(-it * 2.6); irR = rng.standard_normal(ir_n) * np.exp(-it * 2.6)
irL[0] = irR[0] = 0
irL = lowpass(irL, 5000); irR = lowpass(irR, 5000)
irL[:int(.03*SR)] *= np.linspace(0, 1, int(.03*SR)); irR[:int(.03*SR)] *= np.linspace(0, 1, int(.03*SR))
irL /= np.sqrt((irL ** 2).sum()); irR /= np.sqrt((irR ** 2).sum())
def hp(x, fc):
    X = np.fft.rfft(x); f = np.fft.rfftfreq(len(x), 1 / SR)
    return np.fft.irfft(X * (f > fc), len(x))
def conv(x, h):
    x = hp(x, 250)
    m = len(x) + len(h); nf = 1 << (m - 1).bit_length()
    return np.fft.irfft(np.fft.rfft(x, nf) * np.fft.rfft(h, nf), nf)[:len(x)]
wetL = conv(L, irL) * 0.35; wetR = conv(R, irR) * 0.35
L = L + wetL; R = R + wetR

# 7) Fade in/out, chuẩn hóa
fade = np.ones(N)
fi = int(1.0 * SR); fo = int(3.0 * SR)
fade[:fi] = np.linspace(0, 1, fi); fade[-fo:] = np.linspace(1, 0, fo)
L *= fade; R *= fade
peak = max(np.abs(L).max(), np.abs(R).max())
L = L / peak * 0.89; R = R / peak * 0.89
pcm = (np.stack([L, R], 1) * 32767).astype('<i2')
with wave.open(sys.argv[1] if len(sys.argv) > 1 else 'music.wav', 'wb') as w:
    w.setnchannels(2); w.setsampwidth(2); w.setframerate(SR); w.writeframes(pcm.tobytes())
print('ok')
