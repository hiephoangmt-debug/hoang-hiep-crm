#!/usr/bin/env bash
UA="Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0 Safari/537.36"
for u in "https://dulieu.nguoiquansat.vn/lai-suat" "https://24hmoney.vn/lai-suat-gui-ngan-hang" "https://webgia.com/lai-suat/"; do
  echo "=================== $u"
  curl -sSL -m 30 -A "$UA" -o /tmp/p.html "$u" || continue
  python3 - <<'PY'
import re,html
t=open('/tmp/p.html',encoding='utf-8',errors='ignore').read()
def clean(x): return re.sub(r'\s+',' ',html.unescape(re.sub(r'<[^>]+>',' ',x))).strip()
tables=re.findall(r'<table.*?</table>',t,flags=re.S)
for ti,tb in enumerate(tables):
    rows=re.findall(r'<tr.*?</tr>',tb,flags=re.S)
    # context before table (heading / tab labels)
    pos=t.find(tb); ctx=clean(t[max(0,pos-1500):pos])[-300:]
    print(f'--- TABLE {ti}: {len(rows)} rows | before: ...{ctx}')
    for r in rows[:4]+rows[-2:]:
        cells=[clean(c) for c in re.findall(r'<t[hd][^>]*>(.*?)</t[hd]>',r,flags=re.S)]
        print('   ',cells)
for kw in ['Cập nhật','cập nhật lúc','Tại quầy','Online','tại quầy','online']:
    for m in list(re.finditer(kw,t))[:3]:
        print(f'[{kw}]',clean(t[max(0,m.start()-200):m.start()+200])[:300])
PY
done
