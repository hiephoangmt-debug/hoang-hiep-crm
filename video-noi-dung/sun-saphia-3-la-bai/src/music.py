"""Synthesize a cinematic news-documentary underscore.
usage: python music.py DURATION "t1,t2,..."(scene starts) CLIMAX_START CALM_START out.wav
"""
import sys, wave
import numpy as np

SR = 44100
dur = float(sys.argv[1])
cuts = [float(x) for x in sys.argv[2].split(",") if x]
climax, calm = float(sys.argv[3]), float(sys.argv[4])
out = sys.argv[5]
N = int(dur * SR) + SR
t = np.arange(N) / SR
rng = np.random.default_rng(7)
BPM = 100
beat = 60 / BPM

# intensity curve 0..1 : rise to climax, hold, drop at calm
inten = np.clip(0.35 + 0.65 * t / max(climax, 1), 0, 1)
inten[t >= calm] = 0.3
inten = np.convolve(inten, np.ones(SR) / SR, mode="same")

def note(m):  # midi -> Hz
    return 440 * 2 ** ((m - 69) / 12)

# progression Am - F - Dm - E (2 bars each, 4 beats/bar)
prog = [[57, 60, 64], [53, 57, 60], [50, 53, 57], [52, 56, 59]]
roots = [45, 41, 38, 40]
bar = 4 * beat
chord_len = 2 * bar

mix = np.zeros(N)

# --- pad
pad = np.zeros(N)
for i in range(int(dur / chord_len) + 2):
    s0 = int(i * chord_len * SR)
    s1 = min(N, int((i + 1) * chord_len * SR) + int(0.5 * SR))
    if s0 >= N:
        break
    seg = t[s0:s1] - t[s0]
    env = np.minimum(1, seg / 0.8) * np.minimum(1, np.maximum(0, (s1 - s0) / SR - seg) / 0.5)
    ch = prog[i % 4]
    v = np.zeros(s1 - s0)
    for m in ch:
        for det in (-0.12, 0.0, 0.12):
            f = note(m + det)
            v += np.sin(2 * np.pi * f * seg) + 0.3 * np.sin(4 * np.pi * f * seg) + 0.12 * np.sin(6 * np.pi * f * seg)
    pad[s0:s1] += v * env
pad /= np.max(np.abs(pad)) + 1e-9
mix += 0.22 * pad

# --- bass pulse (8ths)
bass = np.zeros(N)
step = beat / 2
for k in range(int(dur / step) + 1):
    s0 = int(k * step * SR)
    L = int(step * SR)
    if s0 + L > N:
        break
    seg = np.arange(L) / SR
    r = roots[int(k * step / chord_len) % 4]
    f = note(r)
    env = np.exp(-seg * 9)
    bass[s0:s0 + L] += (np.sin(2 * np.pi * f * seg) + 0.4 * np.sin(4 * np.pi * f * seg)) * env
mix += 0.30 * bass * (0.4 + 0.6 * inten)

# --- hi-hat ticks (16ths), from 4s
hat = np.zeros(N)
step = beat / 4
noise = rng.standard_normal(int(0.04 * SR))
noise = np.diff(np.concatenate([[0], noise]))  # crude highpass
for k in range(int(dur / step) + 1):
    s0 = int(k * step * SR)
    if s0 / SR < 4 or s0 + len(noise) > N:
        continue
    acc = 1.0 if k % 4 == 0 else 0.55
    hat[s0:s0 + len(noise)] += noise * np.exp(-np.arange(len(noise)) / SR * 90) * acc
mix += 0.05 * hat * inten * (t < calm)

# --- kick on beats when intensity high
kick = np.zeros(N)
L = int(0.35 * SR)
seg = np.arange(L) / SR
kshape = np.sin(2 * np.pi * (50 + 90 * np.exp(-seg * 30)) * seg) * np.exp(-seg * 8)
for k in range(int(dur / beat) + 1):
    s0 = int(k * beat * SR)
    if s0 + L > N:
        break
    kick[s0:s0 + L] += kshape
kmask = np.clip((inten - 0.6) / 0.3, 0, 1) * (t < calm)
mix += 0.35 * kick * kmask

# --- piano-ish arpeggio motif
pno = np.zeros(N)
step = beat / 2
L = int(1.2 * SR)
seg = np.arange(L) / SR
for k in range(int(dur / step) + 1):
    s0 = int(k * step * SR)
    if s0 + L > N:
        break
    ch = prog[int(k * step / chord_len) % 4]
    m = ch[[0, 1, 2, 1][k % 4]] + 12
    f = note(m)
    pno[s0:s0 + L] += (np.sin(2 * np.pi * f * seg) + 0.25 * np.sin(4 * np.pi * f * seg)) * np.exp(-seg * 4)
mix += 0.07 * pno * (0.6 + 0.4 * (t >= calm))

# --- impacts at scene cuts
L = int(2.5 * SR)
seg = np.arange(L) / SR
boom = np.sin(2 * np.pi * (38 + 40 * np.exp(-seg * 6)) * seg) * np.exp(-seg * 2.2)
boom += 0.3 * rng.standard_normal(L) * np.exp(-seg * 12)
for c in cuts:
    s0 = int(c * SR)
    if 0 < s0 and s0 + L < N:
        mix[s0:s0 + L] += 0.45 * boom
# riser into climax
rs0, rs1 = int(max(0, climax - 4) * SR), int(climax * SR)
rseg = np.arange(rs1 - rs0) / SR
mix[rs0:rs1] += 0.12 * rng.standard_normal(rs1 - rs0) * (rseg / rseg[-1]) ** 2

# fades + normalize
fade_in = np.minimum(1, t / 1.5)
fade_out = np.clip((dur - t) / 3, 0, 1)
mix *= fade_in * fade_out
mix = np.tanh(mix * 1.2)
mix /= np.max(np.abs(mix)) + 1e-9
mix *= 0.9
mix = mix[: int(dur * SR)]
# simple stereo widening: delay right channel slightly
d = int(0.012 * SR)
right = np.concatenate([np.zeros(d), mix[:-d]])
st = np.stack([mix, right], axis=1)
with wave.open(out, "wb") as w:
    w.setnchannels(2); w.setsampwidth(2); w.setframerate(SR)
    w.writeframes((st * 32767).astype(np.int16).tobytes())
print("wrote", out)
