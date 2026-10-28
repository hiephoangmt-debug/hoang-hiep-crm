#!/usr/bin/env bash
UA="Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0 Safari/537.36"
for u in \
 https://cafef.vn/thi-truong-chung-khoan.rss https://cafef.vn/tai-chinh-ngan-hang.rss https://cafef.vn/bat-dong-san.rss \
 https://cafef.vn/vi-mo-dau-tu.rss https://cafef.vn/thi-truong.rss \
 https://vnexpress.net/rss/kinh-doanh.rss https://vnexpress.net/rss/bat-dong-san.rss \
 https://vietstock.vn/830/chung-khoan/co-phieu.rss https://vietstock.vn/759/hang-hoa/vang-va-kim-loai-quy.rss \
 https://tuoitre.vn/rss/kinh-doanh.rss https://thanhnien.vn/rss/kinh-te.rss https://vneconomy.vn/chung-khoan.rss \
 https://vneconomy.vn/tai-chinh.rss https://www.vietnamplus.vn/rss/kinhte-311.rss ; do
  code=$(curl -sSL -m 20 -A "$UA" -o /tmp/r.xml -w "%{http_code} %{size_download}" "$u" 2>&1)
  n=$(grep -o "<item" /tmp/r.xml 2>/dev/null | wc -l)
  t=$(python3 -c "import re,html;x=open('/tmp/r.xml',errors='ignore').read();m=re.findall(r'<item.*?<title>(?:<!\[CDATA\[)?(.*?)(?:\]\]>)?</title>.*?<pubDate>(.*?)</pubDate>',x,re.S);print(m[0] if m else '-')" 2>/dev/null)
  echo "$u | $code | items $n | $t"
done
