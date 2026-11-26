"""Tạo ảnh FB #HiệpChiaSẻ có ảnh minh hoạ thật (1080x1350). Chạy: python3 tools/make_fb_hiep.py"""
import json, os, subprocess
ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
OUT = os.path.join(ROOT, 'social')
POSTS = [
 {"id": "02", "photo": "hop-dau-ngay.jpg", "pos": "center 40%", "tag": "Họp đầu ngày",
  "head": "Đừng xem buổi họp đầu ngày là <em>thủ tục</em>.",
  "sub": "Đó là lúc nắm giỏ hàng và chính sách mới nhất. Ghi chép đủ, khách hỏi gì bạn cũng trả lời chắc được."},
 {"id": "03", "photo": "dao-tao.jpg", "pos": "center 45%", "tag": "3 ngày đầu",
  "head": "3 ngày đầu: <em>quan sát</em>, ghi chép, hỏi người kèm thật&nbsp;nhiều.",
  "sub": "Hiểu đúng ngay từ đầu giúp bạn đỡ phải sửa thói quen sai về&nbsp;sau."},
 {"id": "04", "photo": "hoang-hiep-walk-wide.jpg", "pos": "center 30%", "tag": "Telesale",
  "head": "Nghe lại cuộc gọi của chính mình là cách <em>tiến bộ nhanh&nbsp;nhất</em>.",
  "sub": "Mỗi tối chọn một cuộc, tìm một chỗ cần sửa. Hôm sau sửa đúng chỗ đó."},
 {"id": "05", "photo": "ra-quan-1.jpg", "pos": "center 35%", "tag": "Sức bền",
  "head": "Nghề sale chạy <em>đường dài</em>, không phải chạy nước&nbsp;rút.",
  "sub": "Giữ giờ ăn, giờ ngủ, uống đủ nước khi đi dự án ngoài nắng. Sức khỏe tốt thì giọng nói và năng lượng khi tư vấn mới&nbsp;tốt."},
 {"id": "06", "photo": "team-trip-1.jpg", "pos": "center 40%", "tag": "Không ai tự bơi",
  "head": "Cái khó nhất của người mới là phải <em>tự xoay sở</em> một&nbsp;mình.",
  "sub": "Ở đội của Hiệp, bạn mới có người kèm và được chia data mỗi ngày, không ai phải ngồi chờ&nbsp;khách."},
 {"id": "07", "photo": "ky-ket-casamia-2.jpg", "pos": "center 45%", "tag": "Chọn nơi làm",
  "head": "Chọn <em>đúng nơi làm</em> quan trọng hơn chọn dự&nbsp;án.",
  "sub": "Ở môi trường có đào tạo từ 0 và có người kèm, cái khó tháng đầu sẽ nhẹ đi rất&nbsp;nhiều."},
 {"id": "08", "photo": "doi-23-11/doi-15.jpg", "pos": "center 30%", "tag": "Có người kèm",
  "head": "Đừng ngại sai. Sai khi có <em>người kèm</em> bên cạnh là cách học nhanh&nbsp;nhất.",
  "sub": "Ở đội của Hiệp, bạn mới có người kèm nghe cùng những cuộc gọi đầu tiên. Sai đâu sửa đó, ít rủi ro&nbsp;nhất."},
 {"id": "09", "photo": "doi-23-11/doi-33.jpg", "pos": "center 30%", "tag": "Đều đặn",
  "head": "Chậm mà <em>đều</em> quan trọng hơn nhanh mà bỏ&nbsp;dở.",
  "sub": "Mỗi tối dành vài phút ghi lại hôm nay gọi bao nhiêu khách, học được gì, mai cần sửa gì. Sau 60 ngày bạn sẽ thấy mình tiến bộ&nbsp;rõ."},
 {"id": "10", "photo": "doi-23-11/doi-03.jpg", "pos": "center 45%", "tag": "Ngày 23/11/2026",
  "head": "Một ngày ngoài trời <em>cùng nhau</em> của đội&nbsp;Hiệp.",
  "sub": "Làm việc hết mình, vui chơi hết mình. Muốn vào một đội như thế này? Nhắn Hiệp&nbsp;nhé."}
]
TPL = open(os.path.join(OUT, 'tpl-anh.html'), encoding='utf-8').read()
for p in POSTS:
    h = TPL
    for k, v in p.items():
        h = h.replace('{{%s}}' % k, v)
    f = os.path.join(OUT, f"hiep-chia-se-{p['id']}.html"); open(f, 'w', encoding='utf-8').write(h)
    subprocess.run(['node', '-e', f"""const {{chromium}}=require('playwright');(async()=>{{const b=await chromium.launch();const pg=await b.newPage({{viewport:{{width:1080,height:1350}}}});await pg.goto('file://{f}',{{waitUntil:'networkidle'}});await pg.waitForTimeout(400);await pg.screenshot({{path:'{f[:-5]}.jpg',type:'jpeg',quality:88}});await b.close()}})()"""], check=True)
    print('ok', p['id'])
