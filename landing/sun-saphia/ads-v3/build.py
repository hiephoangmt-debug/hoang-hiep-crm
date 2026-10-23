# Dựng trang /ads Sun Saphia (bố cục F2) từ src.html
import sys,re
H=sys.argv[1] if len(sys.argv)>1 else 'HASH'
D='/home/user/hoang-hiep-crm/landing/sun-saphia/'
s=open(D+'ads-v3/src.html',encoding='utf8').read()
P=D+'ads-v3/parts/'
css=open(P+'f2.css',encoding='utf8').read(); ev=open(P+'ev.css',encoding='utf8').read()
RAW='https://raw.githubusercontent.com/hiephoangmt-debug/hoang-hiep-crm/'
rep={'{{CSS_F2}}':css,'{{CSS_EV}}':ev,
 '{{IMG3}}':RAW+H+'/landing/sun-saphia/ads-v3/',
 '{{IMG2}}':RAW+'d69a66192973f0a184ad7b402751b7b09e542238/landing/sun-saphia/ads-v2/',
 '{{MAP}}':RAW+'e896904c71c093b1d48a7dc792a5e93f932165cd/landing/sun-saphia/ads-v2/',
 '{{ICON}}':RAW+'d878b1dfa7ea891aa2d00b54f3c8f28ee5c536ee/landing/sun-saphia/ads-v2/',
 '{{SVG_STUDIO}}':open(P+'studio.svg').read(),'{{SVG_1BR}}':open(P+'1br.svg').read(),'{{SVG_2BR}}':open(P+'2br.svg').read(),
 '{{CHON_CAN}}':open(P+'chon-can.html',encoding='utf8').read(),
 '{{CHAT}}':open(D+'chat/hhc-chat.js',encoding='utf8').read()}
for k,v in rep.items():
    s=s.replace(k,v)
left=re.findall(r'\{\{[A-Z0-9_]+\}\}',s); assert not left,left
open(D+'ads-v3/index.html','w',encoding='utf8').write(s); print('ok',len(s))
