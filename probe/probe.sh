#!/usr/bin/env bash
UA="Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0 Safari/537.36"
urls=(
 "https://24hmoney.vn/lai-suat-vay-ngan-hang"
 "https://24hmoney.vn/lai-suat-vay-mua-nha"
 "https://dulieu.nguoiquansat.vn/lai-suat-vay"
 "https://webgia.com/lai-suat/vay/"
 "https://webgia.com/lai-suat-vay/"
 "https://vnsignal.vn/vi-mo/lai-suat-vay"
 "https://vnsignal.vn/vi-mo/lai-suat-vay-mua-nha"
 "https://cafef.vn/du-lieu/lai-suat-vay.chn"
 "https://timo.vn/lai-suat-vay-mua-nha/"
 "https://www.homecredit.vn/lai-suat-vay-mua-nha"
)
for u in "${urls[@]}"; do
  echo "=================== $u"
  curl -sSL -m 25 -A "$UA" -o /tmp/p.html -w "HTTP %{http_code} size %{size_download}\n" "$u" || { echo CURL FAIL; continue; }
  python3 - <<'PY'
import re,html
t=open('/tmp/p.html',encoding='utf-8',errors='ignore').read()
def clean(x): return re.sub(r'\s+',' ',html.unescape(re.sub(r'<[^>]+>',' ',x))).strip()
print('title:', clean((re.findall(r'<title>(.*?)</title>',t,flags=re.S) or [''])[0])[:120])
tables=re.findall(r'<table.*?</table>',t,flags=re.S)
for ti,tb in enumerate(tables[:4]):
    rows=re.findall(r'<tr.*?</tr>',tb,flags=re.S)
    pos=t.find(tb); ctx=clean(t[max(0,pos-1200):pos])[-220:]
    print(f'--- TABLE {ti}: {len(rows)} rows | before: ...{ctx}')
    for r in rows[:4]+rows[-1:]:
        print('   ',[clean(c)[:40] for c in re.findall(r'<t[hd][^>]*>(.*?)</t[hd]>',r,flags=re.S)])
PY
done
