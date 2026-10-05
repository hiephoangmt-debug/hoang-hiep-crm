"""Sinh 4 trang vị trí từ trang chính (index.html) để dùng chung giao diện."""
import re, os
ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
main = open(os.path.join(ROOT, 'index.html'), encoding='utf-8').read()
IMG = 'https://raw.githubusercontent.com/hiephoangmt-debug/hoang-hiep-crm/tuyen-dung-sale-da-nang/tuyendungsaledanang/img/'
SITE = 'https://www.tuyendungsaledanang.com'
URL = {'nv': SITE + '/tuyen-nhan-vien-kinh-doanh-bds-da-nang', 'cv': SITE + '/tuyen-chuyen-vien-kinh-doanh-bds-da-nang',
       'pro': SITE + '/tuyen-chuyen-gia-kinh-doanh-pro-sales-da-nang', 'tn': SITE + '/tuyen-truong-nhom-truong-phong-kinh-doanh-bds-da-nang', 'sv': SITE + '/tuyen-sale-moi-ra-truong'}

head = main[:main.index('</head>')]
header = main[main.index('<header class="top">'):main.index('</header>') + 9]
header = header.replace('<div class="brand">TUYỂN SALE <span>ĐÀ NẴNG</span></div>', f'<a class="brand" href="{SITE}/" style="text-decoration:none">TUYỂN SALE <span>ĐÀ NẴNG</span></a>')
sections = {}
for m in re.finditer(r'<section[^>]*>.*?</section>', main, re.S):
    blk = m.group(0); first = blk[:blk.index('>') + 1]
    idm = re.search(r'id="([^"]+)"', first)
    key = idm.group(1) if idm else None
    if not key:
        if 'class="sec dark"' in first and 'journey' in blk: key = 'journey'
        elif 'tlsplit' in blk: key = 'timeline'
        elif 'class="sec navy"' in first: key = 'team'
        elif 'class="leader"' in blk: key = 'leader'
        elif 'class="ladder"' in blk: key = 'ladder'
    sections[key] = blk
footer = main[main.index('<footer class="foot">'):main.index('</footer>') + 9]
sticky = main[main.index('<div class="sticky">'):main.index('</div>', main.index('<div class="sticky">')) + 6]
tail = '\n</body>\n</html>\n'

def opts(items):
    return '<option value="" disabled selected>-- Chọn --</option>' + ''.join(f'<option>{o}</option>' for o in items)

def chips(cur):
    lst = ([('sv', 'Mới ra trường')] if cur == 'sv' else []) + [('nv', 'Nhân viên KD'), ('cv', 'Chuyên viên KD'), ('pro', 'Pro Sales'), ('tn', 'Trưởng nhóm'), ('tn', 'Trưởng phòng')]
    hot = ' class="hot"'
    return '\n'.join('        <a%s href="%s">%s</a>' % (hot if k == cur else '', URL[k], t) for k, t in lst)

def ul(items): return '<ul>' + ''.join(f'<li>{i}</li>' for i in items) + '</ul>'

def page(p):
    h = head
    h = re.sub(r'<title>.*?</title>', f'<title>{p["title"]}</title>', h, flags=re.S)
    h = re.sub(r'<meta name="description" content="[^"]*">', f'<meta name="description" content="{p["desc"]}">', h)
    h = re.sub(r'<meta property="og:title" content="[^"]*">', f'<meta property="og:title" content="{p["title"]}">', h)
    h = re.sub(r'<meta property="og:description" content="[^"]*">', f'<meta property="og:description" content="{p["desc"]}">', h)
    h += '<link rel="canonical" href="' + URL[p['key']] + '">\n<style>.crumb{font-size:13px;color:#C9D3EA;margin-bottom:12px}.crumb a{color:#FFB98F;text-decoration:none}\n.role-lv{display:inline-block;background:var(--orange);color:#fff;font-weight:800;font-size:13px;padding:3px 12px;border-radius:999px;margin-bottom:10px}\n.panel h4{margin:14px 0 4px;font-size:15px;font-weight:800;color:inherit}</style>\n'
    kp = ''.join(f'<div><b>{a}</b><span>{b}</span></div>' for a, b in p['kpis'])
    fields = ''.join(f'''      <label for="{fid}">{lab}</label>
      <select id="{fid}" name="{nm}">{opts(o)}</select>
''' for fid, nm, lab, o in p['selects'])
    hidden = f'      <input type="hidden" name="position" value="{p["position"]}">\n' if p.get('position') else ''
    hero = f'''<section class="hero" id="top">
  <div class="wrap">
    <div>
      <p class="crumb"><a href="{SITE}/">Tuyển Sale Đà Nẵng</a> › {p["crumb"]}</p>
      <span class="badge"><i class="dot"></i> {p["badge"]}</span>
      <h1>{p["h1"]}</h1>
      <p class="sub">{p["sub"]}</p>
      <div class="kpis">{kp}</div>
      <p class="hiring">Các vị trí đang tuyển:</p>
      <div class="chips">
{chips(p["key"])}
      </div>
      <div class="btns">
        <a class="btn" href="#dang-ky">{p["cta"]}</a>
        <a class="btn btn-ghost" href="#du-an">Xem dự án</a>
      </div>
    </div>
    <form class="form" id="dang-ky" action="#" method="post">
      <h2>{p["form_h"]}</h2>
      <p class="note">{p["form_note"]} Gấp? <a href="tel:0904567009">Gọi 0904 567 009</a></p>
      <label for="name">Họ và tên *</label>
      <input id="name" name="name" type="text" placeholder="Nguyễn Văn A" required>
      <label for="phone">Số điện thoại / Zalo *</label>
      <input id="phone" name="phone" type="tel" placeholder="09xx xxx xxx" required>
{fields}{hidden}      <button class="btn full" type="submit">{p["form_btn"]}</button>
      <p class="trust">✓ Miễn phí &nbsp; ✓ Trao đổi 1:1 &nbsp; ✓ Bảo mật thông tin</p>
    </form>
  </div>
</section>
'''
    roles = f'''<section class="sec" id="cong-viec">
  <div class="wrap">
    <div class="center">
      <span class="eyebrow">{p["role_eyebrow"]}</span>
      <h2 class="h2">{p["role_h2"]}</h2>
    </div>
    <div class="grid2">
''' + ''.join(f'''      <div class="panel {"p1" if i == 0 else "p2"}">
        {f'<span class="role-lv">{c["lv"]}</span>' if c.get("lv") else f'<span class="eyebrow">{c["eyebrow"]}</span>'}
        <h2>{c["h"]}</h2>
        {"".join(f"<h4>{t}</h4>" + ul(items) for t, items in c["lists"])}
        <a class="btn {"btn-navy" if i == 0 else ""} full" href="#dang-ky">{c["btn"]}</a>
      </div>
''' for i, c in enumerate(p['panels'])) + '''    </div>
  </div>
</section>
'''
    cards = ''.join(f'<div class="card"><div class="n">{a}</div><h3>{b}</h3><p>{c}</p></div>' for a, b, c in p['cards'])
    tower = f'''    <div class="split">
      <img class="illu" src="{IMG}thu-nhap-khong-tran.png" alt="Cấu trúc thu nhập: lương 7–10 triệu là sàn, cộng hoa hồng, thưởng marketing đến 10 triệu mỗi giao dịch, thưởng nóng" loading="lazy">
      <div>
        <span class="eyebrow">Thu nhập xếp tầng</span>
        <h3 class="h3">Lương là sàn. <em>Giao dịch là thang máy.</em></h3>
        <ol class="layers">
          <li><b>Lương Pro Sales 7–10 triệu/tháng</b><span>Mức sàn mỗi tháng khi đạt Pro Sales.</span></li>
          <li><b>Hoa hồng</b><span>Tính trên từng giao dịch thành công.</span></li>
          <li><b>Thưởng marketing đến 10 triệu</b><span>Mỗi giao dịch, cộng thẳng vào thu nhập.</span></li>
          <li><b>Thưởng nóng</b><span>Cho deal nhanh, deal lớn.</span></li>
        </ol>
      </div>
    </div>
''' if p.get('tower') else ''
    policy = f'''<section class="sec soft" id="chinh-sach">
  <div class="wrap">
    <div class="center">
      <span class="eyebrow">{p["pol_eyebrow"]}</span>
      <h2 class="h2">{p["pol_h2"]}</h2>
    </div>
{tower}    <div class="grid3">{cards}</div>
    {f'<p class="center" style="margin-top:18px;color:var(--muted);font-size:14px">{p["pol_note"]}</p>' if p.get("pol_note") else ""}
    <div class="cta-row"><a class="btn" href="#dang-ky">{p["cta"]}</a></div>
  </div>
</section>
'''
    steps = ''.join(f'<div><b>{a}</b><h3>{b}</h3><p>{c}</p></div>' for a, b, c in p['steps'])
    journey = f'''<section class="sec dark">
  <div class="wrap">
    <div class="center">
      <span class="eyebrow">Lộ trình của bạn</span>
      <h2 class="h2">{p["steps_h2"]}</h2>
    </div>
    <div class="journey">{steps}</div>
    <p class="note-s center">* Lộ trình mục tiêu để bạn hình dung. Tốc độ thực tế phụ thuộc vào năng lực và kết quả của từng người.</p>
    <div class="cta-row"><a class="btn" href="#dang-ky">{p["cta"]}</a></div>
  </div>
</section>
'''
    faq = '''<section class="sec soft" id="faq">
  <div class="wrap">
    <div class="center">
      <span class="eyebrow">Hỏi thẳng, đáp thẳng</span>
      <h2 class="h2">Câu hỏi <em>thường gặp</em></h2>
    </div>
    <div class="faq">
''' + ''.join(f'      <details><summary>{q}</summary><p>{a}</p></details>\n' for q, a in p['faq']) + '''    </div>
    <div class="cta-row"><a class="btn" href="#dang-ky">Ứng tuyển ngay →</a></div>
  </div>
</section>
'''
    final = sections['ung-tuyen']
    if p.get('position'):
        final = final.replace('      <button class="btn full" type="submit">Gửi hồ sơ ứng tuyển →</button>', hidden + '      <button class="btn full" type="submit">Gửi hồ sơ ứng tuyển →</button>')
    order = [hero, sections['su-that'] if p.get('su_that') else '', roles, p.get('extra', ''), policy,
             sections['moi-ra-truong'] if p.get('grad') else '', sections['du-an'], journey,
             sections['timeline'] if p.get('timeline') else '', sections['team'], sections['leader'], final, faq]
    body = '<body>\n\n' + header + '\n\n' + '\n\n'.join(x for x in order if x) + '\n\n' + footer + '\n\n' + sticky
    html = h + '</head>\n' + body + tail
    html = html.replace('<section class="sec" id="cong-viec">', '<section class="sec" id="cong-viec">', 1)
    return html

COMMON_FAQ_END = [
    ('Có hợp đồng lao động và bảo hiểm không?', 'Có. Hợp đồng lao động, BHYT và BHXH đầy đủ.'),
    ('Có cần nộp CV không?', 'Không bắt buộc. Có CV thì dán link ở form cuối trang hoặc gửi về email <a href="mailto:hiephoangmt@gmail.com">hiephoangmt@gmail.com</a>.'),
    ('Làm việc ở đâu?', 'Văn phòng 23–25 Nguyễn Phước Lan, Đà Nẵng.'),
]
PAGES = {
'nhan-vien': dict(key='nv', position='Nhân viên kinh doanh BĐS', crumb='Nhân viên kinh doanh BĐS',
  title='Tuyển Nhân Viên Kinh Doanh BĐS Đà Nẵng – Nhận SV Mới Ra Trường | Tuyển Sale Đà Nẵng',
  desc='Tuyển nhân viên kinh doanh BĐS tại Đà Nẵng, nhận sinh viên mới ra trường, không cần kinh nghiệm. Đào tạo từ đầu, phân bổ lead, marketing hỗ trợ đến 100%, thưởng marketing đến 10tr/GD, HĐLĐ & BHXH.',
  badge='Không cần kinh nghiệm · Nhận SV mới ra trường',
  h1='Nhân viên kinh doanh BĐS.<br><em>Bắt đầu từ con số 0.</em>',
  sub='Chưa từng bán BĐS? Không sao. Đào tạo bài bản, có lead sẵn, có người kèm từ ngày đầu.',
  kpis=[('100%', 'Hỗ trợ marketing'), ('10TR', 'Thưởng MKT/giao dịch'), ('03', 'Tháng xét lương'), ('HĐLĐ', 'BHYT, BHXH đủ')],
  cta='Ứng tuyển Nhân viên KD →', form_h='Ứng tuyển Nhân viên KD', form_note='30 giây, không cần CV. <b>Hoàng Hiệp</b> gọi lại tư vấn 1:1.', form_btn='Ứng tuyển ngay →',
  selects=[('job', 'job', 'Bạn đang làm gì?', ['Sinh viên mới ra trường', 'Sale ngành khác', 'Công việc văn phòng', 'Khác'])],
  role_eyebrow='Mô tả công việc', role_h2='Bạn sẽ làm gì, <em>và có hợp không?</em>',
  panels=[dict(eyebrow='Công việc', h='Bạn sẽ làm gì?', btn='Tôi làm được →', lists=[('', ['Tìm hiểu sản phẩm các dự án BĐS tại Đà Nẵng', 'Tiếp nhận, chăm sóc khách từ lead được phân bổ và nguồn cá nhân', 'Tư vấn thông tin, chính sách phù hợp nhu cầu khách', 'Dẫn khách tham quan dự án, nhà mẫu', 'Hỗ trợ khách hoàn thiện thủ tục giao dịch'])]),
          dict(eyebrow='Phù hợp với bạn nếu', h='Bạn có khát vọng, <em>chúng tôi dạy phần còn lại.</em>', btn='Giữ chỗ phỏng vấn →', lists=[('', ['Sinh viên mới ra trường, người muốn chuyển nghề sang kinh doanh', 'Thích giao tiếp, chịu khó, muốn thu nhập theo năng lực', 'Sẵn sàng học hỏi, làm việc theo mục tiêu', 'Muốn phát triển lên Chuyên viên, Trưởng nhóm'])])],
  pol_eyebrow='Chính sách dành cho bạn', pol_h2='Con số rõ ràng, <em>không hứa suông</em>', tower=True,
  cards=[('100%', 'Marketing hỗ trợ đến 100%', 'Giải ngân ngay khi đề xuất, có ngân sách tiếp cận khách.'), ('LEAD', 'Marketing đầu tổng phân lead', 'Người mới cũng có khách thật để tư vấn.'), ('10TR', 'Thưởng marketing đến 10tr/GD', 'Cộng hoa hồng và thưởng nóng mỗi giao dịch.'), ('03', 'Tháng xét lương & cấp bậc', 'Thăng tiến bằng kết quả, không bằng thâm niên.'), ('7–10TR', 'Lên Pro Sales', 'Pro Sales lương 7–10 triệu/tháng, cộng hoa hồng và thưởng.'), ('HĐLĐ', 'Hợp đồng & bảo hiểm', 'BHYT, BHXH đầy đủ, yên tâm làm lâu dài.')],
  steps_h2='Từ người mới <em>đến người dẫn đội</em>',
  steps=[('Bước 1', 'Đào tạo', 'Sản phẩm, tìm khách, tư vấn, xử lý từ chối, chốt giao dịch.'), ('Bước 2', 'Ra trận có người kèm', 'Được phân bổ lead, quản lý và đồng đội cùng dẫn khách.'), ('Sau 03 tháng', 'Xét lương & cấp bậc', 'Kết quả tốt thì tăng lương, lên Chuyên viên.'), ('Tiếp theo', 'Pro Sales / Trưởng nhóm', 'Pro Sales lương 7–10 triệu/tháng, hoặc dẫn dắt đội nhóm.')],
  faq=[('Chưa có kinh nghiệm có ứng tuyển được không?', 'Được. Vị trí Nhân viên kinh doanh không yêu cầu kinh nghiệm, bạn được đào tạo từ đầu.'), ('Sinh viên mới ra trường có được nhận không?', 'Có. Ngành nào cũng được, bạn được đào tạo, có người kèm và được phân bổ lead.'), ('Người mới có khách để tư vấn không?', 'Có. Marketing phân bổ lead cho toàn đội và hỗ trợ chi phí marketing đến 100%.'), ('Thu nhập gồm những gì?', 'Lương, hoa hồng, thưởng marketing đến 10tr/giao dịch và thưởng nóng. Chi tiết trao đổi khi tư vấn 1:1.')] + COMMON_FAQ_END,
  su_that=True, grad=True, timeline=True),
'chuyen-vien': dict(key='cv', position='Chuyên viên kinh doanh BĐS', crumb='Chuyên viên kinh doanh BĐS',
  title='Tuyển Chuyên Viên Kinh Doanh BĐS Đà Nẵng | Tuyển Sale Đà Nẵng',
  desc='Tuyển chuyên viên kinh doanh BĐS tại Đà Nẵng. Marketing hỗ trợ đến 100%, phân bổ lead, thưởng marketing đến 10tr/GD + hoa hồng + thưởng nóng, 03 tháng xét lương, lên Pro Sales lương 7–10 triệu/tháng.',
  badge='Có kinh nghiệm Sale là lợi thế',
  h1='Chuyên viên kinh doanh BĐS.<br><em>Kỹ năng của bạn đáng giá hơn.</em>',
  sub='Bạn đã biết tìm khách, tư vấn, chốt. Ở đây có marketing mạnh, lead đều và chính sách đủ hấp dẫn để kỹ năng ra tiền.',
  kpis=[('10TR', 'Thưởng MKT/giao dịch'), ('100%', 'Hỗ trợ marketing'), ('03', 'Tháng xét lương'), ('7–10TR', 'Lương Pro Sales')],
  cta='Ứng tuyển Chuyên viên →', form_h='Ứng tuyển Chuyên viên KD', form_note='30 giây, không cần CV. <b>Hoàng Hiệp</b> gọi lại tư vấn 1:1.', form_btn='Ứng tuyển ngay →',
  selects=[('job', 'job', 'Kinh nghiệm của bạn', ['Sale BĐS', 'Sale ngành khác (ô tô, bảo hiểm, ngân hàng…)', 'Khác'])],
  role_eyebrow='Mô tả công việc', role_h2='Đi nhanh hơn <em>với kinh nghiệm sẵn có</em>',
  panels=[dict(eyebrow='Công việc', h='Mô tả công việc', btn='Tôi làm được →', lists=[('', ['Tư vấn sản phẩm, dự án BĐS tại Đà Nẵng', 'Khai thác, chăm sóc khách từ lead marketing và mạng lưới cá nhân', 'Giới thiệu thông tin, chính sách, phương án phù hợp từng khách', 'Dẫn khách tham quan dự án, nhà mẫu', 'Hỗ trợ khách hoàn thiện quy trình giao dịch'])]),
          dict(eyebrow='Phù hợp với bạn nếu', h='Bạn đã chạm trần? <em>Đổi sân chơi.</em>', btn='Giữ chỗ phỏng vấn →', lists=[('', ['Đã có kinh nghiệm Sale BĐS hoặc Sale ngành khác (ô tô, bảo hiểm, ngân hàng, tài chính…)', 'Muốn sản phẩm lớn hơn, nguồn khách đều hơn, thu nhập cao hơn', 'Làm việc theo mục tiêu, chủ động, kỷ luật', 'Muốn lên Pro Sales hoặc Trưởng nhóm'])])],
  pol_eyebrow='Chính sách Chuyên viên kinh doanh', pol_h2='Con số rõ ràng, <em>không hứa suông</em>', tower=True,
  cards=[('100%', 'Marketing hỗ trợ đến 100%', 'Giải ngân ngay khi đề xuất, chạy quảng cáo không lo vốn.'), ('LEAD', 'Marketing đầu tổng phân lead', 'Có khách đều để tư vấn mỗi ngày.'), ('10TR', 'Thưởng marketing đến 10tr/GD', 'Cộng hoa hồng và thưởng nóng mỗi giao dịch.'), ('03', 'Tháng xét lương & cấp bậc', 'Kèm thưởng đánh giá cấp bậc, không phải chờ cả năm.'), ('7–10TR', 'Đặc biệt: Pro Sales', 'Lương 7–10 triệu/tháng khi đạt Pro Sales, cộng hoa hồng và thưởng.'), ('HĐLĐ', 'Hợp đồng & bảo hiểm', 'BHYT, BHXH đầy đủ, chuyên nghiệp, minh bạch.')],
  steps_h2='Chuyên viên → <em>Pro Sales → Quản lý</em>',
  steps=[('Ngày đầu', 'Nắm sản phẩm', 'Đào tạo dự án, chính sách, bắt nhịp nhanh với kinh nghiệm sẵn có.'), ('Hằng ngày', 'Nhận lead, chốt deal', 'Marketing đầu tổng mạnh, ngân sách hỗ trợ đến 100%.'), ('Mỗi 03 tháng', 'Xét lương & cấp bậc', 'Kết quả tốt thì tăng lương, tăng cấp.'), ('Bước tiếp', 'Pro Sales / Trưởng nhóm', 'Pro Sales lương 7–10 triệu/tháng, hoặc dẫn dắt đội nhóm.')],
  faq=[('Marketing hỗ trợ đến 100% nghĩa là gì?', 'Chi phí marketing được hỗ trợ đến 100% và giải ngân ngay khi đề xuất. Điều kiện cụ thể trao đổi khi tư vấn.'), ('Thưởng marketing tính thế nào?', 'Thưởng marketing đến 10tr/giao dịch, cộng hoa hồng và thưởng nóng.'), ('Pro Sales là gì?', 'Cấp bậc dành cho Sale có kết quả nổi bật, lương 7–10 triệu/tháng, cộng hoa hồng và thưởng theo giao dịch.'), ('Bao lâu được xét tăng lương?', '03 tháng xét tăng lương và cấp bậc, kèm thưởng đánh giá cấp bậc.')] + COMMON_FAQ_END,
  su_that=True, timeline=True),
'pro-sales': dict(key='pro', position='Chuyên gia kinh doanh (Pro Sales)', crumb='Chuyên gia kinh doanh (Pro Sales)',
  title='Tuyển Pro Sales BĐS Đà Nẵng – Lương 7–10 Triệu/Tháng | Tuyển Sale Đà Nẵng',
  desc='Tuyển chuyên gia kinh doanh BĐS (Pro Sales) tại Đà Nẵng: lương 7–10 triệu/tháng, cộng hoa hồng, thưởng marketing đến 10tr/GD, thưởng nóng, marketing hỗ trợ đến 100%.',
  badge='Dành cho Sale bản lĩnh',
  h1='Pro Sales: lương <em class="nw">7–10 triệu</em><br>chưa tính hoa hồng.',
  sub='Bạn đã chứng minh mình bán được hàng. Ở đây Pro Sales có lương tháng, marketing mạnh và thưởng theo từng giao dịch.',
  kpis=[('7–10TR', 'Lương/tháng'), ('10TR', 'Thưởng MKT/giao dịch'), ('100%', 'Hỗ trợ marketing'), ('03', 'Tháng xét cấp bậc')],
  cta='Ứng tuyển Pro Sales →', form_h='Ứng tuyển Pro Sales', form_note='Trao đổi 1:1, bảo mật. <b>Hoàng Hiệp</b> gọi lại trong ngày.', form_btn='Ứng tuyển Pro Sales →',
  selects=[('exp', 'experience', 'Kinh nghiệm Sale BĐS của bạn', ['Dưới 1 năm', '1–2 năm', 'Trên 2 năm', 'Sale ngành khác, thành tích tốt'])],
  role_eyebrow='Vai trò Pro Sales', role_h2='Bạn bán giỏi. <em>Hãy được trả xứng đáng.</em>',
  panels=[dict(eyebrow='Vai trò', h='Vai trò của Pro Sales', btn='Tôi làm được →', lists=[('', ['Tư vấn, chốt giao dịch các dự án BĐS trọng điểm tại Đà Nẵng', 'Chăm sóc nhóm khách đầu tư, khách tiềm năng cao', 'Chủ động khai thác khách từ marketing và mạng lưới cá nhân', 'Chia sẻ kinh nghiệm, làm hình mẫu cho đội ngũ'])]),
          dict(eyebrow='Phù hợp với bạn nếu', h='Bạn tự tin <em>với khách giá trị lớn.</em>', btn='Giữ chỗ phỏng vấn →', lists=[('', ['Đã có kinh nghiệm Sale BĐS và giao dịch thực tế', 'Hoặc Sale ngành khác có thành tích nổi bật', 'Tự tin tư vấn, đàm phán với khách giá trị lớn', 'Muốn thu nhập tương xứng và hướng tới quản lý'])])],
  pol_eyebrow='Chính sách Pro Sales', pol_h2='Thu nhập Pro Sales <em>không chỉ đến từ hoa hồng</em>', tower=True,
  pol_note='Tiêu chí xét Pro Sales cụ thể được trao đổi trực tiếp khi tư vấn 1:1.',
  cards=[('7–10TR', 'Lương mỗi tháng', 'Lương 7–10 triệu/tháng dành cho Pro Sales.'), ('10TR', 'Thưởng marketing/GD', 'Đến 10tr mỗi giao dịch, cộng hoa hồng và thưởng nóng.'), ('100%', 'Marketing hỗ trợ', 'Hỗ trợ đến 100%, giải ngân ngay khi đề xuất.'), ('LEAD', 'Marketing đầu tổng', 'Phân bổ lead đều cho đội, Pro Sales tập trung chốt.'), ('03', 'Tháng xét cấp bậc', 'Xét tăng lương và cấp bậc, kèm thưởng đánh giá.'), ('HĐLĐ', 'Hợp đồng & bảo hiểm', 'BHYT, BHXH đầy đủ.')],
  steps_h2='Pro Sales → <em>Trưởng nhóm → Trưởng phòng</em>',
  steps=[('Tuần đầu', 'Nắm giỏ hàng', 'Đào tạo sản phẩm, chính sách các dự án đang phân phối.'), ('Hằng ngày', 'Lead & chốt', 'Nhận lead từ marketing đầu tổng, tập trung tư vấn và chốt.'), ('Mỗi 03 tháng', 'Xét cấp bậc', 'Đánh giá kết quả, tăng lương và cấp bậc.'), ('Bước tiếp', 'Dẫn đội', 'Lên Trưởng nhóm, xây đội của riêng bạn.')],
  faq=[('Lương Pro Sales bao nhiêu?', 'Lương 7–10 triệu/tháng, cộng thêm hoa hồng, thưởng marketing đến 10tr/giao dịch và thưởng nóng.'), ('Điều kiện để là Pro Sales?', 'Tiêu chí cụ thể được trao đổi trực tiếp, dựa trên kinh nghiệm và kết quả kinh doanh của bạn.'), ('Tôi đang làm ở nơi khác, thông tin có được bảo mật?', 'Có. Mọi trao đổi đều 1:1 và bảo mật.')] + COMMON_FAQ_END,
  su_that=True, timeline=True),
'truong-nhom': dict(key='tn', position='', crumb='Trưởng nhóm / Trưởng phòng kinh doanh',
  title='Tuyển Trưởng Nhóm, Trưởng Phòng Kinh Doanh BĐS Đà Nẵng | Tuyển Sale Đà Nẵng',
  desc='Tuyển Trưởng nhóm, Trưởng phòng kinh doanh BĐS tại Đà Nẵng. Marketing đầu tổng mạnh, phân bổ lead cho toàn đội, marketing hỗ trợ đến 100%, HĐLĐ & BHXH đầy đủ.',
  badge='Vị trí quản lý · Trưởng nhóm / Trưởng phòng',
  h1='Đừng chỉ bán.<br><em>Hãy dẫn đội.</em>',
  sub='Bạn đã bán giỏi. Bước tiếp theo là xây một đội cùng bán giỏi. Chúng tôi trao sản phẩm, marketing và hệ thống.',
  kpis=[('LEAD', 'Phân bổ cho cả đội'), ('100%', 'Hỗ trợ marketing'), ('10TR', 'Thưởng MKT/giao dịch'), ('03', 'Tháng xét cấp bậc')],
  cta='Ứng tuyển vị trí quản lý →', form_h='Ứng tuyển vị trí quản lý', form_note='Trao đổi 1:1, bảo mật tuyệt đối. <b>Hoàng Hiệp</b> gọi lại.', form_btn='Ứng tuyển ngay →',
  selects=[('pos', 'position', 'Vị trí ứng tuyển', ['Trưởng nhóm kinh doanh', 'Trưởng phòng kinh doanh']), ('team', 'management_experience', 'Bạn đã quản lý đội Sale chưa?', ['Chưa, nhưng muốn thử sức', 'Đã quản lý dưới 5 người', 'Đã quản lý từ 5 người trở lên'])],
  role_eyebrow='Hai vị trí quản lý', role_h2='Trưởng nhóm <em>hay Trưởng phòng?</em>',
  panels=[dict(lv='Cấp 03 · Trưởng nhóm', h='Trưởng nhóm kinh doanh', btn='Ứng tuyển Trưởng nhóm →', lists=[('Công việc', ['Dẫn dắt nhóm Sale, đặt mục tiêu và theo dõi kết quả', 'Kèm cặp, đào tạo nhân viên mới ra giao dịch', 'Cùng đội tư vấn, dẫn khách, chốt giao dịch', 'Lập kế hoạch, tìm giải pháp thúc đẩy kết quả']), ('Phù hợp nếu', ['Đã có kinh nghiệm Sale BĐS và giao dịch thực tế', 'Thích chia sẻ, kèm người, muốn xây đội của riêng mình'])]),
          dict(lv='Cấp 04 · Trưởng phòng', h='Trưởng phòng kinh doanh', btn='Ứng tuyển Trưởng phòng →', lists=[('Công việc', ['Xây dựng, vận hành phòng kinh doanh, quản lý các Trưởng nhóm', 'Hoạch định chiến lược bán hàng, phối hợp marketing triển khai dự án', 'Tuyển dụng, đào tạo, phát triển đội ngũ', 'Chịu trách nhiệm doanh số và hiệu quả của phòng']), ('Phù hợp nếu', ['Đã có kinh nghiệm quản lý đội Sale BĐS', 'Có tư duy chiến lược, muốn phát triển lên cấp Giám đốc'])])],
  pol_eyebrow='Hệ thống phía sau bạn', pol_h2='Quản lý giỏi cần <em>một nền tảng đủ mạnh</em>',
  pol_note='Chế độ thu nhập dành riêng cho cấp quản lý được trao đổi trực tiếp khi tư vấn 1:1.',
  cards=[('LEAD', 'Marketing đầu tổng mạnh', 'Phân bổ lead cho toàn đội, đội của bạn luôn có khách để tư vấn.'), ('100%', 'Marketing hỗ trợ', 'Ngân sách marketing hỗ trợ đến 100%, giải ngân ngay khi đề xuất.'), ('7–10TR', 'Pro Sales trong đội', 'Sale giỏi của bạn có lương 7–10 triệu/tháng, dễ giữ người, dễ tạo động lực.'), ('10TR', 'Thưởng marketing/GD', 'Cộng hoa hồng và thưởng nóng, động lực cho cả đội.'), ('03', 'Tháng xét cấp bậc', 'Đánh giá định kỳ, lộ trình rõ ràng cho đội ngũ.'), ('HĐLĐ', 'BHYT & BHXH', 'Đầy đủ, môi trường chuyên nghiệp, ổn định.')],
  steps_h2='Từ dẫn nhóm <em>đến dẫn khối kinh doanh</em>',
  steps=[('Bước 1', 'Nhận đội', 'Nắm sản phẩm, hệ thống, nhận và xây dựng nhân sự.'), ('Hằng ngày', 'Dẫn đội ra trận', 'Đội nhận lead từ marketing đầu tổng, bạn kèm và cùng chốt.'), ('Mỗi 03 tháng', 'Đánh giá cấp bậc', 'Kết quả của đội là thước đo thăng tiến.'), ('Tiếp theo', 'Trưởng phòng → Giám đốc', 'Mở rộng quy mô, dẫn dắt khối kinh doanh.')],
  faq=[('Chưa từng quản lý có ứng tuyển Trưởng nhóm được không?', 'Có thể, nếu bạn có kết quả Sale tốt và muốn dẫn đội. Chúng tôi trao đổi 1:1 để tìm lộ trình phù hợp.'), ('Đội của tôi lấy khách từ đâu?', 'Marketing đầu tổng mạnh, phân bổ lead cho toàn đội, kèm ngân sách marketing hỗ trợ đến 100%.'), ('Thu nhập của quản lý thế nào?', 'Chế độ cho cấp quản lý được trao đổi trực tiếp, tương xứng với quy mô và kết quả của đội.'), ('Thông tin ứng tuyển có được bảo mật?', 'Có. Mọi trao đổi đều 1:1 và bảo mật tuyệt đối.')] + COMMON_FAQ_END,
  su_that=True),
}
COMPARE = """<section class="sec dark" id="so-sanh">
  <div class="wrap">
    <div class="center">
      <span class="eyebrow">Hai con đường sau khi ra trường</span>
      <h2 class="h2">Lương cứng <em>hay thu nhập theo kết quả?</em></h2>
      <p class="lead">Không có con đường nào sai. Chỉ có con đường hợp với bạn hơn.</p>
    </div>
    <div class="grid2">
      <div class="panel p1">
        <span class="eyebrow">Con đường quen thuộc</span>
        <h2>Công việc lương cứng</h2>
        <ul><li>Thu nhập cố định mỗi tháng</li><li>Tăng lương chủ yếu theo thâm niên</li><li>Làm tốt hơn chưa chắc nhận nhiều hơn</li><li>Ổn định, ít áp lực doanh số</li></ul>
      </div>
      <div class="panel p2" style="border:3px solid var(--orange)">
        <span class="eyebrow">Con đường bạn có thể chọn</span>
        <h2>Sale BĐS <em>tại đây</em></h2>
        <ul><li>Lương + hoa hồng + thưởng marketing đến 10tr/giao dịch</li><li>03 tháng xét lương & cấp bậc, không chờ cả năm</li><li>Làm tốt hơn là nhận nhiều hơn, lên Pro Sales 7–10 triệu/tháng</li><li>Có áp lực, nhưng có lead sẵn và người kèm</li></ul>
        <a class="btn full" href="#dang-ky">Tôi chọn con đường này →</a>
      </div>
    </div>
  </div>
</section>
"""
PAGES['moi-ra-truong'] = dict(key='sv', position='Sale mới ra trường', crumb='Tuyển Sale mới ra trường',
  title='Tuyển Sale Mới Ra Trường Đà Nẵng 2026 – Không Cần Kinh Nghiệm | Tuyển Sale Đà Nẵng',
  desc='Tuyển sinh viên mới ra trường làm Sale BĐS tại Đà Nẵng. Ngành nào cũng được, không cần kinh nghiệm. Đào tạo từ con số 0, có lead sẵn, có người kèm, HĐLĐ & BHXH, 03 tháng xét lương.',
  badge='Tuyển Sale mới ra trường · Đà Nẵng 2026',
  h1='Mới ra trường?<br>Chọn nghề <em>không đóng khung thu nhập.</em>',
  sub='Ngành nào cũng được, không cần kinh nghiệm. Đào tạo từ con số 0, có lead sẵn, có người kèm.',
  kpis=[('0', 'Năm kinh nghiệm'), ('100%', 'Hỗ trợ marketing'), ('03', 'Tháng xét lương'), ('7–10TR', 'Lương Pro Sales')],
  cta='Tôi mới ra trường, ứng tuyển →', form_h='Ứng tuyển Sale mới ra trường', form_note='Không cần CV đẹp. <b>Hoàng Hiệp</b> gọi lại nói chuyện 15 phút.', form_btn='Giữ chỗ phỏng vấn →',
  selects=[('grad', 'graduation', 'Bạn tốt nghiệp năm nào?', ['2026', '2025', '2024 trở về trước', 'Sắp tốt nghiệp']), ('major', 'major', 'Ngành học của bạn', ['Kinh tế / Quản trị kinh doanh', 'Marketing / Truyền thông', 'Ngôn ngữ / Du lịch', 'Kỹ thuật / CNTT', 'Ngành khác'])],
  role_eyebrow='Dành riêng cho tân cử nhân', role_h2='Lý lịch trống? <em>Không sao.</em>',
  panels=[dict(eyebrow='Bạn nhận được', h='Không cần biết trước. <em>Chỉ cần học nhanh.</em>', btn='Tôi muốn bắt đầu →', lists=[('', ['Không yêu cầu kinh nghiệm, ngành học nào cũng được', 'Đào tạo từ con số 0: sản phẩm, pháp lý, tìm khách, chốt', 'Có người kèm trong giao dịch đầu tiên', 'Lead được phân bổ, không tự bỏ tiền chạy quảng cáo', 'HĐLĐ, BHYT, BHXH đầy đủ'])]),
          dict(eyebrow='Bạn hợp nếu', h='Bạn có 3 thứ này, <em>phần còn lại chúng tôi dạy.</em>', btn='Giữ chỗ phỏng vấn →', lists=[('', ['Thích nói chuyện, không ngại gặp người lạ', 'Muốn thu nhập theo năng lực, không theo thâm niên', 'Chịu khó: gọi điện, đi dự án, học sản phẩm mỗi ngày'])])],
  extra=COMPARE,
  pol_eyebrow='Chính sách dành cho bạn', pol_h2='Con số rõ ràng, <em>không hứa suông</em>', tower=True,
  cards=[('100%', 'Marketing hỗ trợ đến 100%', 'Giải ngân ngay khi đề xuất, không bỏ tiền túi chạy quảng cáo.'), ('LEAD', 'Có khách ngay từ đầu', 'Marketing đầu tổng phân lead cho cả đội, kể cả người mới.'), ('10TR', 'Thưởng marketing đến 10tr/GD', 'Cộng hoa hồng và thưởng nóng mỗi giao dịch.'), ('03', 'Tháng xét lương & cấp bậc', 'Thăng tiến bằng kết quả, không bằng thâm niên.'), ('7–10TR', 'Lên Pro Sales', 'Pro Sales lương 7–10 triệu/tháng, cộng hoa hồng và thưởng.'), ('HĐLĐ', 'Hợp đồng & bảo hiểm', 'BHYT, BHXH đầy đủ ngay từ đầu.')],
  steps_h2='12 tháng đầu sau khi <em>cầm bằng</em>',
  steps=[('Tháng 1', 'Học & ra trận', 'Nắm sản phẩm, đi dự án, nhận lead, có người kèm từng cuộc gọi.'), ('Tháng 2–3', 'Giao dịch đầu tay', 'Chốt deal đầu tiên, nhận hoa hồng cộng thưởng marketing đến 10tr.'), ('Tháng 3', 'Xét lương & cấp bậc', 'Kết quả tốt thì tăng lương, lên cấp.'), ('Tháng 4–12', 'Pro Sales / Trưởng nhóm', 'Pro Sales lương 7–10 triệu/tháng, hoặc dẫn dắt đội của riêng bạn.')],
  faq=[('Không học ngành kinh tế có làm được không?', 'Được. Ngành nào cũng được, kiến thức sản phẩm và kỹ năng bán hàng đều được đào tạo từ đầu.'), ('Sắp tốt nghiệp, chưa có bằng có ứng tuyển được không?', 'Bạn cứ để lại thông tin. Hoàng Hiệp sẽ gọi lại trao đổi trực tiếp về thời gian bắt đầu phù hợp.'), ('Người mới có khách để tư vấn không?', 'Có. Marketing phân bổ lead cho toàn đội và hỗ trợ chi phí marketing đến 100%.'), ('Thu nhập gồm những gì?', 'Lương, hoa hồng, thưởng marketing đến 10tr/giao dịch và thưởng nóng. Chi tiết trao đổi khi tư vấn 1:1.'), ('Nghề Sale có áp lực không?', 'Có. Có ngày gọi nhiều mà chưa có khách. Nhưng bạn có lead sẵn, có người kèm và không phải đi một mình.')] + COMMON_FAQ_END,
  su_that=True, timeline=True)
os.makedirs(os.path.join(ROOT, 'vi-tri'), exist_ok=True)
for name, p in PAGES.items():
    html = page(p)
    open(os.path.join(ROOT, 'vi-tri', name + '.html'), 'w', encoding='utf-8').write(html)
    print(name, len(html), 'TATI' in html, '20tr' in html.lower())
