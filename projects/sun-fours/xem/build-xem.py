"""Tạo xem-du-an.html (trang gộp 4D + chọn căn + mặt bằng tầng (Sun FourS), 1 lần đăng nhập).
Dùng: python3 build-xem.py <sha 4D> <sha chọn căn>   (Client ID Google đọc từ google-client-id.txt nếu có)"""
import pathlib, sys
h = pathlib.Path(__file__).parent
gc = (h / 'google-client-id.txt').read_text().strip() if (h / 'google-client-id.txt').exists() else ''
s = (h / 'xem-du-an.src.html').read_text(encoding='utf-8').replace('__A__', sys.argv[1]).replace('__B__', sys.argv[2]).replace('__GCID__', gc)
(h / 'xem-du-an.html').write_text(s, encoding='utf-8')
