#!/usr/bin/env bash
UA="Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0 Safari/537.36"
urls=(
 "https://webgia.com/lai-suat/"
 "https://24hmoney.vn/lai-suat-gui-ngan-hang"
 "https://dulieu.nguoiquansat.vn/lai-suat"
 "https://vnsignal.vn/vi-mo/lai-suat-ngan-hang"
 "https://thebank.vn/lai-suat-tiet-kiem.html"
 "https://cafef.vn/du-lieu/lai-suat-ngan-hang.chn"
 "https://portal.vietcombank.com.vn/UserControls/TVPortal.TyGia/pListLaiSuat.aspx?CusstomType=1&BacrhID=1&InrateType=&isEn=False&numAfter=2"
 "https://www.vietcombank.com.vn/api/interestrates?branchCode=1"
 "https://www.bidv.com.vn/ServicesBIDV/InterestDetailServlet"
 "https://laisuat.vn/"
 "https://www.vietnambiz.vn/lai-suat-ngan-hang.htm"
 "https://giavang.org/lai-suat/"
)
for u in "${urls[@]}"; do
  echo "=================== $u"
  curl -sSL -m 25 -A "$UA" -o /tmp/p.html -w "HTTP %{http_code} size %{size_download} type %{content_type}\n" "$u" || { echo "CURL FAIL"; continue; }
  python3 - <<'PY'
import re,html
t=open('/tmp/p.html',encoding='utf-8',errors='ignore').read()
txt=re.sub(r'<script.*?</script>|<style.*?</style>','',t,flags=re.S)
txt=html.unescape(re.sub(r'<[^>]+>',' | ',txt)); txt=re.sub(r'(\s*\|\s*)+',' | ',txt); txt=re.sub(r'\s+',' ',txt)
print('TABLES',t.count('<table'),'| JSON-like',t[:1] in '[{')
for kw in ['Vietcombank','VPBank','12 tháng']:
    i=txt.find(kw)
    if i>=0: print(f'[{kw}]', txt[max(0,i-150):i+450]); break
else:
    print(txt[:600])
# api hints
for m in set(re.findall(r'https?://[\w.-]*api[\w./-]*', t))[:15] if False else list(set(re.findall(r'https?://[\w.-]*api[\w./?=&-]*', t)))[:12]:
    print('API?',m)
PY
done
