"""Đóng gói app: thu-chi/app-src.html → thu-chi/index.html

Mã JavaScript chính được mã hóa base64 (chỉ ký tự ASCII) rồi giải mã & chạy khi mở trang.
Lý do: Google Apps Script (HtmlService) biến đổi nội dung <script> dài và làm hỏng một số
cú pháp hợp lệ (regex, chuỗi…) → app báo SyntaxError. Base64 thì không bị biến đổi.

Chạy: python3 thu-chi/tools/build.py
"""
import base64, os, re

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
src = open(os.path.join(ROOT, 'app-src.html'), encoding='utf-8').read()

MARK = '<script>\n/* ============ Tiện ích'
start = src.index(MARK)
end = src.index('</script>', start)
code = src[start + len('<script>\n'):end] + '\n//# sourceURL=thu-chi-app.js\n'
b64 = base64.b64encode(code.encode('utf-8')).decode('ascii')
lines = '\n'.join(b64[i:i + 120] for i in range(0, len(b64), 120))
loader = ('<script id="app-code" type="text/plain">\n' + lines + '\n</script>\n'
          '<script>\n'
          '(function () {\n'
          '  var b = document.getElementById("app-code").textContent.replace(/\\s+/g, "");\n'
          '  var bin = atob(b), u = new Uint8Array(bin.length);\n'
          '  for (var i = 0; i < bin.length; i++) u[i] = bin.charCodeAt(i);\n'
          '  var s = document.createElement("script");\n'
          '  s.textContent = new TextDecoder("utf-8").decode(u);\n'
          '  document.body.appendChild(s);\n'
          '})();\n')
out = src[:start] + loader + src[end:]
out = out.replace('<!doctype html>', '<!doctype html>\n<!-- FILE TỰ SINH từ app-src.html bởi tools/build.py – sửa app-src.html rồi chạy lại build -->', 1)
open(os.path.join(ROOT, 'index.html'), 'w', encoding='utf-8').write(out)
print('index.html', len(out), 'bytes; code', len(code), 'chars')
