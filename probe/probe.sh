#!/usr/bin/env bash
UA="Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0 Safari/537.36"
echo "== Chợ Tốt API"
for u in "https://gateway.chotot.com/v1/public/ad-listing?region_v2=3017&cg=1000&limit=20&st=s,k" \
         "https://gateway.chotot.com/v1/public/ad-listing?region_v2=3017&cg=1040&limit=5&st=s" \
         "https://gateway.chotot.com/v2/public/chapy-pro/regions" ; do
  curl -sS -m 20 -A "$UA" -o /tmp/c.json -w "$u -> HTTP %{http_code} %{size_download}\n" "$u"
  python3 - <<'PY'
import json
try: d=json.load(open('/tmp/c.json'))
except Exception as e: print('not json', open('/tmp/c.json',errors='ignore').read()[:200]); raise SystemExit
if 'ads' in d:
    print('total', d.get('total'), 'keys', list(d['ads'][0].keys())[:60] if d['ads'] else '')
    for a in d['ads'][:6]:
        print('  ', {k:a.get(k) for k in ['subject','price','size','area_name','ward_name','category_name','category','list_time','street_name','price_million_per_m2','type']})
else:
    s=json.dumps(d,ensure_ascii=False); i=s.find('Đà Nẵng'); print(s[max(0,i-300):i+200])
PY
done
for u in "https://batdongsan.com.vn/nha-dat-ban-da-nang" "https://homedy.com/ban-nha-dat-da-nang" "https://alonhadat.com.vn/nha-dat/can-ban/nha-dat/da-nang.html" "https://muaban.net/bat-dong-san/ban-nha-dat-da-nang" "https://www.nhatot.com/mua-ban-bat-dong-san-da-nang"; do
  curl -sSL -m 20 -A "$UA" -o /tmp/p.html -w "== $u -> HTTP %{http_code} %{size_download}\n" "$u"
  python3 -c "
import re,html;t=open('/tmp/p.html',errors='ignore').read()
print('title:',re.sub(r'\s+',' ',html.unescape((re.findall(r'<title>(.*?)</title>',t,re.S) or [''])[0]))[:100])
m=re.findall(r'(\d+(?:[.,]\d+)?)\s*(?:tr|triệu)\s*/\s*m', t); print('giá/m² thấy:', m[:8])
print('next_data' , '__NEXT_DATA__' in t)"
done
