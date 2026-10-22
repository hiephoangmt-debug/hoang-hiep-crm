#!/usr/bin/env bash
UA="Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0 Safari/537.36"
urls=(
 "https://techcombank.com/thong-tin/blog/lai-suat-vay-ngan-hang"
 "https://topi.vn/so-sanh-lai-suat-vay-ngan-hang.html"
 "https://vn247.vn/bai-viet/lai-suat-ngan-hang-2026-so-sanh"
 "https://www.vaynao.com/vay/mua-nha"
 "https://smartland.vn/lai-suat-vay-mua-nha-2026/"
 "https://smecredit.vn/lai-suat-vay-doanh-nghiep/"
 "https://24hmoney.vn/lai-suat-vay"
 "https://webgia.com/lai-suat-vay-ngan-hang/"
 "https://muanha.cuthongthai.vn/blog/lai-suat-vay-mua-nha-2026-su-that-bat-ngo-ma-ban-phai-biet"
)
for u in "${urls[@]}"; do
  echo "=================== $u"
  curl -sSL -m 25 -A "$UA" -o /tmp/p.html -w "HTTP %{http_code} size %{size_download}\n" "$u" || { echo CURL FAIL; continue; }
  python3 - <<'PY'
import re,html
t=open('/tmp/p.html',encoding='utf-8',errors='ignore').read()
def clean(x): return re.sub(r'\s+',' ',html.unescape(re.sub(r'<[^>]+>',' ',x))).strip()
print('title:', clean((re.findall(r'<title>(.*?)</title>',t,flags=re.S) or [''])[0])[:120])
m=re.search(r'(?i)(cập nhật|updated)[^<]{0,60}\d{1,2}/\d{1,2}/\d{4}',t); print('upd:', clean(m.group(0)) if m else '-')
tables=re.findall(r'<table.*?</table>',t,flags=re.S)
print('tables', len(tables))
for ti,tb in enumerate(tables[:6]):
    rows=re.findall(r'<tr.*?</tr>',tb,flags=re.S)
    pos=t.find(tb); ctx=clean(t[max(0,pos-800):pos])[-150:]
    print(f'--- TABLE {ti}: {len(rows)} rows | before: ...{ctx}')
    for r in rows[:4]+rows[-1:]:
        print('   ',[clean(c)[:35] for c in re.findall(r'<t[hd][^>]*>(.*?)</t[hd]>',r,flags=re.S)])
PY
done
