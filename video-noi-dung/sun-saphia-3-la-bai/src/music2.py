"""Driving trailer-style underscore.
usage: python music2.py DURATION "cut1,cut2,..." CLIMAX_START CALM_START out.wav
"""
import sys, wave
import numpy as np

SR = 44100
dur = float(sys.argv[1]); cuts = [float(x) for x in sys.argv[2].split(",") if x]
climax, calm = float(sys.argv[3]), float(sys.argv[4]); out = sys.argv[5]
N = int(dur * SR) + 2 * SR
t = np.arange(N) / SR
rng = np.random.default_rng(11)
BPM = 128; beat = 60 / BPM; s16 = beat / 4
note = lambda m: 440 * 2 ** ((m - 69) / 12)

# Am - F - C - G | Am - F - Dm - E  (1 bar each)
prog = [[57, 60, 64], [53, 57, 60], [48, 52, 55], [55, 59, 62], [57, 60, 64], [53, 57, 60], [50, 53, 57], [52, 56, 59]]
bar = 4 * beat
def chord_at(x): return prog[int(x / bar) % len(prog)]

# energy: 0.55 at start -> 1 at climax, keeps 1 until calm, 0.45 after
energy = np.clip(0.55 + 0.45 * t / max(climax, 1), 0, 1)
energy[t >= calm] = 0.45
k = SR // 2
energy = np.convolve(energy, np.ones(k) / k, mode="same")

def place(buf, sig, at, gain=1.0):
    s0 = int(at * SR)
    if s0 < 0 or s0 >= N: return
    e = min(N, s0 + len(sig)); buf[s0:e] += gain * sig[: e - s0]

def saw(f, L, harm=8):
    x = np.arange(L) / SR; y = np.zeros(L)
    for h in range(1, harm + 1): y += np.sin(2 * np.pi * f * h * x) / h
    return y

mix = np.zeros(N)
# ---- kick (every beat; double-time 8ths during climax)
L = int(0.30 * SR); x = np.arange(L) / SR
KICK = np.sin(2 * np.pi * (48 + 130 * np.exp(-x * 35)) * x) * np.exp(-x * 9)
KICK += 0.4 * rng.standard_normal(L) * np.exp(-x * 120)
kick = np.zeros(N); duck = np.ones(N)
tt = 0.0
while tt < dur:
    if tt > 0.4:
        place(kick, KICK, tt)
        s0 = int(tt * SR); e = min(N, s0 + int(0.18 * SR))
        duck[s0:e] = np.minimum(duck[s0:e], 0.35 + 0.65 * np.linspace(0, 1, e - s0) ** 0.6)
    tt += beat / 2 if climax <= tt < calm else beat
mix += 0.55 * kick

# ---- snare/clap on 2 & 4 (from 4s, not in calm)
L = int(0.25 * SR); x = np.arange(L) / SR
SN = rng.standard_normal(L) * np.exp(-x * 22) + 0.5 * np.sin(2 * np.pi * 190 * x) * np.exp(-x * 30)
for i in range(int(dur / beat) + 1):
    tb = i * beat
    if tb > 4 and tb < calm and i % 4 in (1, 3): place(mix, SN, tb, 0.22)

# ---- snare rolls into every cut (last bar, accelerating)
for c in cuts + [climax]:
    n = 12
    for j in range(n):
        tr = c - beat * 2 * (1 - j / n) ** 1.3
        place(mix, SN, tr, 0.06 + 0.16 * j / n)

# ---- hi-hats 16ths
L = int(0.035 * SR); x = np.arange(L) / SR
HH = np.diff(np.concatenate([[0], rng.standard_normal(L)])) * np.exp(-x * 110)
hats = np.zeros(N)
for i in range(int(dur / s16) + 1):
    th = i * s16
    if th > 1.0: place(hats, HH, th, 1.0 if i % 2 == 0 else 0.6)
mix += 0.09 * hats * np.where(t < calm, 1.0, 0.5)

# ---- bass ostinato 16ths (root, root, octave, root)
bass = np.zeros(N)
L = int(s16 * SR)
for i in range(int(dur / s16) + 1):
    tb = i * s16
    r = chord_at(tb)[0] - 24
    m = r + (12 if i % 4 == 2 else 0)
    x = np.arange(L) / SR
    sig = saw(note(m), L, 6) * np.exp(-x * 14)
    place(bass, sig, tb)
mix += 0.20 * bass * duck * energy

# ---- staccato strings 8ths (chord stabs)
strs = np.zeros(N)
L = int(beat / 2 * SR * 0.8)
x = np.arange(L) / SR
env = np.minimum(1, x / 0.01) * np.exp(-x * 9)
for i in range(int(dur / (beat / 2)) + 1):
    ts = i * beat / 2
    ch = chord_at(ts)
    sig = sum(saw(note(m + d), L, 5) for m in ch for d in (-0.07, 0.07)) * env
    place(strs, sig, ts, 1.0 if i % 2 == 0 else 0.7)
strs /= np.max(np.abs(strs)) + 1e-9
mix += 0.16 * strs * duck * energy

# ---- sustained low pad (glue)
pad = np.zeros(N)
for i in range(int(dur / bar) + 2):
    L = int(bar * SR * 1.05); x = np.arange(L) / SR
    sig = sum(np.sin(2 * np.pi * note(m - 12) * x) for m in chord_at(i * bar)) * np.minimum(1, x / 0.3) * np.minimum(1, (bar * 1.05 - x) / 0.2)
    place(pad, sig, i * bar)
pad /= np.max(np.abs(pad)) + 1e-9
mix += 0.10 * pad * np.where(t >= calm, 1.8, 1.0)

# ---- braam/impact on cuts
L = int(2.2 * SR); x = np.arange(L) / SR
BOOM = np.sin(2 * np.pi * (36 + 50 * np.exp(-x * 7)) * x) * np.exp(-x * 2)
BRAAM = saw(note(33), L, 10) * np.exp(-x * 1.6) * np.minimum(1, x / 0.02)
for c in cuts: place(mix, BOOM, c, 0.55); place(mix, BRAAM, c, 0.10)
place(mix, BRAAM, climax, 0.22); place(mix, BOOM, climax, 0.8)

# ---- risers before climax and calm
for e0 in (climax, calm):
    a, b = int((e0 - 3.5) * SR), int(e0 * SR); x = np.linspace(0, 1, b - a)
    f = 200 + 2200 * x ** 2
    mix[a:b] += (0.10 * rng.standard_normal(b - a) + 0.06 * np.sin(2 * np.pi * np.cumsum(f) / SR)) * x ** 2

# ---- end
fade = np.minimum(1, t / 0.6) * np.clip((dur - t) / 2.5, 0, 1)
mix = np.tanh(mix * 1.6) * fade
mix = mix[: int(dur * SR)]; mix /= np.max(np.abs(mix)) + 1e-9; mix *= 0.92
d = int(0.010 * SR)
st = np.stack([mix, np.concatenate([np.zeros(d), mix[:-d]])], 1)
with wave.open(out, "wb") as w:
    w.setnchannels(2); w.setsampwidth(2); w.setframerate(SR)
    w.writeframes((st * 32767).astype(np.int16).tobytes())
print("wrote", out)
