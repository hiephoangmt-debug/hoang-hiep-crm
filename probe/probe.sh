#!/usr/bin/env bash
UA="Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0 Safari/537.36"
ORIGIN="https://hiephoangmt-debug.github.io"
NOW=$(date +%s); FROM=$((NOW-400*86400))
urls=(
 "https://services.entrade.com.vn/chart-api/v2/ohlcs/stock?from=$FROM&to=$NOW&symbol=DXG&resolution=1D"
 "https://api-finfo.vndirect.com.vn/v4/stock_prices?sort=date&q=code:DXG&size=5"
 "https://api-finfo.vndirect.com.vn/v4/stocks?q=type:STOCK~status:LISTED&fields=code,companyName,companyNameEng,floor&size=3000"
 "https://iboard-query.ssi.com.vn/stock/exchange/hose"
 "https://iboard-api.ssi.com.vn/statistics/company/ssmi/stock-info?symbol=DXG&page=1&pageSize=5"
 "https://bgapidatafeed.vps.com.vn/getliststockdata/DXG,HPG"
 "https://s.cafef.vn/Ajax/PageNew/DataHistory/PriceHistory.ashx?Symbol=DXG&PageIndex=1&PageSize=5"
 "https://cafef.vn/du-lieu/Ajax/PageNew/DataHistory/GDKhoiNgoai.ashx?Symbol=DXG&PageIndex=1&PageSize=5"
 "https://query1.finance.yahoo.com/v8/finance/chart/DXG.VN?range=1mo&interval=1d"
 "https://api.simplize.vn/api/historical/quote/prices/DXG?type=stock&page=0&size=5"
 "https://apipubaws.tcbs.com.vn/stock-insight/v1/stock/bars-long-term?ticker=DXG&type=stock&resolution=D&countBack=5&to=$NOW"
 "https://apipubaws.tcbs.com.vn/tcanalysis/v1/ticker/DXG/overview"
 "https://trading.vietcap.com.vn/api/price/symbols/getAll"
 "https://api.dnse.com.vn/price-api/stocks"
)
for u in "${urls[@]}"; do
  echo "=================== $u"
  curl -sS -m 25 -A "$UA" -H "Origin: $ORIGIN" -D /tmp/h.txt -o /tmp/b.txt -w "HTTP %{http_code} size %{size_download}\n" "$u" || { echo CURL FAIL; continue; }
  grep -i '^access-control-allow-origin' /tmp/h.txt || echo "(không có Access-Control-Allow-Origin)"
  head -c 300 /tmp/b.txt; echo
done
