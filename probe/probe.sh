#!/usr/bin/env bash
UA="Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0 Safari/537.36"
urls=(
 "https://dulieu.nguoiquansat.vn/lai-suat-lien-ngan-hang"
 "https://dulieu.nguoiquansat.vn/lai-suat"
 "https://24hmoney.vn/lai-suat-lien-ngan-hang"
 "https://vnsignal.vn/vi-mo/lai-suat-lien-ngan-hang"
 "https://cafef.vn/du-lieu/lai-suat-lien-ngan-hang.chn"
 "https://webgia.com/lai-suat/lien-ngan-hang/"
 "https://www.sbv.gov.vn/webcenter/portal/vi/menu/rm/ls/lslnh"
 "https://sbv.gov.vn/vi/lãi-suất-thị-trường-liên-ngân-hàng"
)
for u in "${urls[@]}"; do
  echo "=================== $u"
  curl -sSL -m 25 -A "$UA" -o /tmp/p.html -w "HTTP %{http_code} size %{size_download}\n" "$u" || { echo CURL FAIL; continue; }
  python3 - <<'PY'
import re,html
t=open('/tmp/p.html',encoding='utf-8',errors='ignore').read()
def clean(x): return re.sub(r'\s+',' ',html.unescape(re.sub(r'<[^>]+>',' ',x))).strip()
print('title:', clean((re.findall(r'<title>(.*?)</title>',t,flags=re.S) or [''])[0])[:120])
for m in list(re.finditer(r'(?i)qua đêm|liên ngân hàng|overnight',t))[:3]:
    print('  ctx:', clean(t[max(0,m.start()-300):m.start()+500])[:500])
tables=re.findall(r'<table.*?</table>',t,flags=re.S)
for ti,tb in enumerate(tables[:4]):
    rows=re.findall(r'<tr.*?</tr>',tb,flags=re.S)
    print(f'--- TABLE {ti}: {len(rows)} rows')
    for r in rows[:5]+rows[-1:]:
        print('   ',[clean(c)[:30] for c in re.findall(r'<t[hd][^>]*>(.*?)</t[hd]>',r,flags=re.S)])
for a in sorted(set(re.findall(r'https?://[\w.-]*api[\w./?=&%-]*',t)))[:8]: print('  api?',a)
PY
done
