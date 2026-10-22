#!/usr/bin/env bash
UA="Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0 Safari/537.36"
U="https://sbv.gov.vn/o/headless-delivery/v1.0/content-structures/3450260/structured-contents?pageSize=3&sort=datePublished:desc"
curl -sS -m 30 -A "$UA" -H "Accept: application/json" -o /tmp/s.json -w "HTTP %{http_code} size %{size_download}\n" "$U"
python3 - <<'PY'
import json
t=open('/tmp/s.json',encoding='utf-8',errors='ignore').read()
try:
    d=json.loads(t)
except Exception as e:
    print('not json', t[:500]); raise SystemExit
print('keys', list(d)[:10], 'total', d.get('totalCount'), 'lastPage', d.get('lastPage'))
for it in (d.get('items') or [])[:2]:
    print('--- item', it.get('title'), it.get('datePublished'))
    def walk(fs, pre=''):
        for f in fs:
            v=f.get('contentFieldValue',{})
            print(pre, f.get('name'), '=', str(v.get('data', v))[:80])
            if f.get('nestedContentFields'): walk(f['nestedContentFields'], pre+'   ')
    walk(it.get('contentFields',[]))
PY
