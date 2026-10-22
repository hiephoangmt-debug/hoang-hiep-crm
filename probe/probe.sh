#!/usr/bin/env bash
UA="Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0 Safari/537.36"
curl -sSL -m 30 -A "$UA" -o /tmp/sbv.html "https://sbv.gov.vn/vi/lãi-suất-thị-trường-liên-ngân-hàng"
curl -sSL -m 30 -A "$UA" -o /tmp/vns.html "https://vnsignal.vn/vi-mo/lai-suat-lien-ngan-hang"
python3 - <<'PY'
import re,html
t=open('/tmp/sbv.html',encoding='utf-8',errors='ignore').read()
print('===== SBV')
for kw in ['laiSuat','thoihan','doanhSo','fetch(','ajax','/o/','api/']:
    for m in list(re.finditer(re.escape(kw),t))[:4]:
        print(f'[{kw}]', t[max(0,m.start()-250):m.start()+250].replace('\n',' ')[:500])
        print()
v=open('/tmp/vns.html',encoding='utf-8',errors='ignore').read()
print('===== VNSIGNAL')
for kw in ['qua đêm','Qua đêm','overnight','"ON"','1 tuần','vnibor','VNIBOR']:
    for m in list(re.finditer(re.escape(kw),v))[:3]:
        print(f'[{kw}]', v[max(0,m.start()-200):m.start()+400].replace('\n',' ')[:600])
        print()
for m in re.findall(r'(\{[^{}]{0,80}"date"[^{}]{0,200}\})', v)[:5]: print('JSON?', m)
print('next_data' , '__NEXT_DATA__' in v, 'next_f', v.count('self.__next_f'))
PY
