#!/usr/bin/env python3
"""Tạo file âm thanh chuẩn cho từng tiếng (giọng HoaiMy của Microsoft Azure).

Dùng: python3 make_audio.py syllables.txt THƯ_MỤC_RA
Cần biến môi trường AZURE_SPEECH_KEY, AZURE_SPEECH_REGION (bản miễn phí F0 là đủ).
Mỗi lần gọi đọc liền BATCH tiếng, cách nhau khoảng lặng, rồi cắt theo khoảng lặng thành từng file.
Chỉ tạo tiếng còn thiếu, dừng khi hết giờ (chạy lại sẽ làm tiếp). Ghi index.txt = các khoá đã có.
Ghi ra GITHUB_OUTPUT: done=1 khi đủ hết (hoặc không có khoá), changed=1 khi có file mới.
"""
import os, re, subprocess, sys, tempfile, time, urllib.request, urllib.error
from xml.sax.saxutils import escape

VOICE = "vi-VN-HoaiMyNeural"
BATCH = 40
GAP_MS = 700
MIN_INTERVAL = 3.2          # bản miễn phí: tối đa 20 lần gọi mỗi phút
BUDGET_S = int(os.environ.get("BUDGET_S", 45 * 60))


def out(name, val):
    p = os.environ.get("GITHUB_OUTPUT")
    if p:
        with open(p, "a") as f:
            f.write(f"{name}={val}\n")
    print(f"{name}={val}")


def synth(text_items, key, region):
    body = "".join(f"{escape(t)}<break time='{GAP_MS}ms'/>" for t in text_items)
    ssml = (f"<speak version='1.0' xml:lang='vi-VN'><voice name='{VOICE}'>"
            f"<prosody rate='-10%'><break time='300ms'/>{body}</prosody></voice></speak>")
    req = urllib.request.Request(
        f"https://{region}.tts.speech.microsoft.com/cognitiveservices/v1", data=ssml.encode("utf-8"), method="POST",
        headers={"Ocp-Apim-Subscription-Key": key, "Content-Type": "application/ssml+xml",
                 "X-Microsoft-OutputFormat": "audio-24khz-48kbitrate-mono-mp3", "User-Agent": "be-vui-hoc"})
    for attempt in range(6):
        try:
            with urllib.request.urlopen(req, timeout=60) as r:
                return r.read()
        except urllib.error.HTTPError as e:
            if e.code in (429, 500, 502, 503, 504):
                time.sleep(15 * (attempt + 1)); continue
            print("Lỗi gọi Azure:", e.code, e.read()[:200]); raise
        except urllib.error.URLError:
            time.sleep(10 * (attempt + 1))
    raise RuntimeError("Azure không trả lời")


def speech_spans(mp3):
    """Các đoạn có tiếng [(start, end)] dựa vào khoảng lặng."""
    r = subprocess.run(["ffmpeg", "-hide_banner", "-i", mp3, "-af", "silencedetect=n=-40dB:d=0.35", "-f", "null", "-"],
                       capture_output=True, text=True)
    starts = [float(x) for x in re.findall(r"silence_start: ([\d.]+)", r.stderr)]
    ends = [float(x) for x in re.findall(r"silence_end: ([\d.]+)", r.stderr)]
    h, m_, sec = re.search(r"Duration: (\d+):(\d+):([\d.]+)", r.stderr).groups()
    dur = int(h) * 3600 + int(m_) * 60 + float(sec)
    spans, cur = [], 0.0
    for s, e in zip(starts, ends + [dur] * (len(starts) - len(ends))):
        if s - cur > 0.05:
            spans.append((cur, s))
        cur = e
    if dur - cur > 0.05:
        spans.append((cur, dur))
    return [(a, b) for a, b in spans if b - a >= 0.08]   # bỏ đoạn quá ngắn (nhiễu ở cuối file)


def cut(mp3, spans, names, outdir):
    for (s, e), name in zip(spans, names):
        subprocess.run(["ffmpeg", "-hide_banner", "-loglevel", "error", "-y", "-ss", f"{max(0, s - 0.04):.3f}",
                        "-to", f"{e + 0.06:.3f}", "-i", mp3, "-ac", "1", "-b:a", "32k", os.path.join(outdir, name + ".mp3")],
                       check=True)


def main():
    listfile, outdir = sys.argv[1], sys.argv[2]
    os.makedirs(outdir, exist_ok=True)
    items = [l.rstrip("\n").split("\t") for l in open(listfile, encoding="utf-8") if "\t" in l]
    have = {f[:-4] for f in os.listdir(outdir) if f.endswith(".mp3")}
    todo = [(k, s) for k, s in items if k not in have]
    print(f"Tổng {len(items)} tiếng, đã có {len(have)}, còn {len(todo)}")
    key, region = os.environ.get("AZURE_SPEECH_KEY"), os.environ.get("AZURE_SPEECH_REGION")
    changed = False
    if todo and not (key and region):
        print("Chưa có AZURE_SPEECH_KEY / AZURE_SPEECH_REGION trong GitHub Secrets – bỏ qua.")
    t0, last = time.time(), 0.0
    tmp = tempfile.mkdtemp()
    while todo and key and region and time.time() - t0 < BUDGET_S:
        batch, todo = todo[:BATCH], todo[BATCH:]
        time.sleep(max(0, MIN_INTERVAL - (time.time() - last))); last = time.time()
        mp3 = os.path.join(tmp, "b.mp3")
        open(mp3, "wb").write(synth([s for _, s in batch], key, region))
        spans = speech_spans(mp3)
        if len(spans) == len(batch):
            cut(mp3, spans, [k for k, _ in batch], outdir)
        else:  # cắt không khớp: gọi riêng từng tiếng
            print(f"Cắt được {len(spans)}/{len(batch)} đoạn, gọi riêng từng tiếng")
            for k, s in batch:
                time.sleep(max(0, MIN_INTERVAL - (time.time() - last))); last = time.time()
                open(mp3, "wb").write(synth([s], key, region))
                sp = speech_spans(mp3)
                if sp:
                    cut(mp3, [(sp[0][0], sp[-1][1])], [k], outdir)
        changed = True
        print(f"Xong thêm {len(batch)} tiếng, còn {len(todo)}")
    done_keys = sorted(f[:-4] for f in os.listdir(outdir) if f.endswith(".mp3"))
    open(os.path.join(outdir, "index.txt"), "w").write("\n".join(done_keys) + "\n")
    out("changed", "1" if changed else "0")
    out("done", "1" if (not todo or not (key and region)) else "0")


if __name__ == "__main__":
    main()
