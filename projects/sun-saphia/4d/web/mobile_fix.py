"""Gọn khung 4D trên điện thoại để không che mô hình: thanh tiêu đề 1 dòng, nút chế độ 1 hàng vuốt ngang,
ẩn ghi chú dài, chữ chìm nhạt hơn, nhãn SUN SAPHIA nhỏ và nằm hẳn trên đỉnh tháp.
Chạy lại an toàn nhiều lần: python3 mobile_fix.py [sun-saphia-4d-embed.js]"""
import json, pathlib, sys
f = pathlib.Path(sys.argv[1] if len(sys.argv) > 1 else pathlib.Path(__file__).parent / 'sun-saphia-4d-embed.js')
src = f.read_text(encoding='utf-8')
i = src.index('var DOC = ') + len('var DOC = '); j = src.index(';\n', i)
doc = json.loads(src[i:j].replace('<\\/', '</'))
TAG = '/*ss-mobile-fix*/'
CSS = TAG + ('@media (max-width:600px){'
  '.top{padding-top:calc(6px + env(safe-area-inset-top,0px))!important;padding-bottom:6px!important}'
  '.brand small,.brand p{display:none!important}.brand{gap:8px!important}.brand h1{font-size:15px!important;margin:0!important;white-space:nowrap}'
  '.srb{width:30px!important;height:30px!important;font-size:13px!important}'
  '.contact{font-size:11px!important;line-height:1.25!important}.contact b{font-size:14px!important}'
  '.compass{top:calc(54px + env(safe-area-inset-top,0px))!important;width:32px!important;height:32px!important}'
  '.console{gap:6px!important;padding-top:8px!important;padding-bottom:calc(8px + env(safe-area-inset-bottom,0px))!important}'
  '.modes{flex-wrap:nowrap!important;overflow-x:auto;scrollbar-width:none;-webkit-overflow-scrolling:touch;padding-bottom:2px}.modes::-webkit-scrollbar{display:none}'
  '.modes .chip{flex:0 0 auto;padding:6px 11px!important;font-size:12.5px!important}'
  '.console .sl{gap:6px!important}.console .sl label{font-size:10.5px!important}.console .note{display:none!important}'
  '.lb{font-size:10.5px!important;padding:2px 6px!important}.lb.main{font-size:11.5px!important;padding:3px 8px!important;transform:translate(-50%,-150%)!important}'
  '#ssWm{opacity:.45;background-size:380px 210px!important}#ssWmB{opacity:.6}'
  '}')
if TAG not in doc:
    k = doc.index('</style>'); doc = doc[:k] + CSS + doc[k:]
    src = src[:i] + json.dumps(doc, ensure_ascii=False).replace('</', '<\\/') + src[j:]
    f.write_text(src, encoding='utf-8'); print('patched', f)
else:
    print('already patched', f)
