"""Kiểm tra chữ đã viết lại (landing-viet-lai.py): đủ khóa, giữ con số và link, không còn đoạn trùng dài, không có tên Tati.

  python3 landing-kiem-tra.py <goc.json> <moi.json>   → in các khóa có vấn đề; thoát mã 1 nếu có lỗi nặng
"""
import json
import re
import sys

goc, moi = json.load(open(sys.argv[1], encoding='utf-8')), json.load(open(sys.argv[2], encoding='utf-8'))
text = lambda v: re.sub(r'\s+', ' ', re.sub(r'<[^>]+>', ' ', v)).strip()
nums = lambda v: sorted(re.findall(r'\d+(?:[.,]\d+)*', text(v)))
hrefs = lambda v: sorted(re.findall(r'href="([^"]*)"', v))
words = lambda v: re.findall(r'\w+', text(v).lower())

nang, nhe, same_words, total_words = [], [], 0, 0
for k, v in goc.items():
    n = moi.get(k)
    if n is None or not str(n).strip():
        nang.append((k, 'thiếu'))
        continue
    if re.search(r'\bTATI|\bTati', n):
        nang.append((k, 'có tên Tati'))
    if hrefs(v) != hrefs(n):
        nang.append((k, 'link khác: %s → %s' % (hrefs(v), hrefs(n))))
    a, b = nums(v), nums(n)
    if a != b and set(a) - set(b):
        nhe.append((k, 'số khác: thiếu %s' % sorted(set(a) - set(b))))
    w1, w2 = words(v), words(n)
    g1 = {tuple(w1[i:i + 7]) for i in range(len(w1) - 6)}
    g2 = {tuple(w2[i:i + 7]) for i in range(len(w2) - 6)}
    total_words += len(w1)
    if len(w1) >= 12:
        dup = len(g1 & g2) / max(1, len(g1))
        same_words += dup * len(w1)
        if dup > 0.3:
            nhe.append((k, 'còn giống %.0f%%' % (dup * 100)))

for k, m in nang:
    print('LỖI ', k, m)
for k, m in nhe:
    print('XEM ', k, m, '|', text(goc[k])[:70], '→', text(moi.get(k, ''))[:70])
print('Khối: %d · lỗi: %d · cần xem: %d · tỷ lệ chuỗi 7 chữ còn trùng (khối dài): %.1f%%' % (len(goc), len(nang), len(nhe), 100 * same_words / max(1, total_words)))
sys.exit(1 if nang else 0)
