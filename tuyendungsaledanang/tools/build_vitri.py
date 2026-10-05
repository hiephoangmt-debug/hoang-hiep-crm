"""Sinh 4 trang vị trí từ trang chính (index.html) để dùng chung giao diện."""
import re, os
ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
main = open(os.path.join(ROOT, 'index.html'), encoding='utf-8').read()
IMG = 'https://raw.githubusercontent.com/hiephoangmt-debug/hoang-hiep-crm/tuyen-dung-sale-da-nang/tuyendungsaledanang/img/'
SITE = 'https://www.tuyendungsaledanang.com'
URL = {'nv': SITE + '/tuyen-nhan-vien-kinh-doanh-bds-da-nang', 'cv': SITE + '/tuyen-chuyen-vien-kinh-doanh-bds-da-nang',
       'pro': SITE + '/tuyen-chuyen-gia-kinh-doanh-pro-sales-da-nang', 'tn': SITE + '/tuyen-truong-nhom-truong-phong-kinh-doanh-bds-da-nang', 'sv': SITE + '/tuyen-sale-moi-ra-truong'}

head = main[:main.index('</head>')]
head = re.sub(r'<link rel="canonical"[^>]*>\n?', '', head)
head = re.sub(r'<script type="application/ld\+json">.*?</script>\n?', '', head, flags=re.S)
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
    lst = [('sv', 'Mới ra trường'), ('nv', 'Nhân viên KD'), ('cv', 'Chuyên viên KD'), ('pro', 'Pro Sales'), ('tn', 'Trưởng nhóm'), ('tn', 'Trưởng phòng')]
    hot = ' class="hot"'
    return '\n'.join('        <a%s href="%s">%s</a>' % (hot if k == cur else '', URL[k], t) for k, t in lst)

def ul(items): return '<ul>' + ''.join(f'<li>{i}</li>' for i in items) + '</ul>'

TEAM = sections['doi-ngu']
GAL = re.search(r'<div class="gal">.*?</div>', TEAM, re.S).group(0)
FIGS = re.findall(r'<figure.*?</figure>', GAL, re.S)
TEAM_IMG = FIGS[0].replace('<figure class="big">', '<figure class="big" style="grid-column:1/-1">')
PICS = [f.replace(' class="big"', '') for f in FIGS[1:]]
MKT3 = re.search(r'<section class="sec soft" id="mkt-3-lop">.*?</section>', main, re.S).group(0)
ENV = f"""<section class="sec navy" id="moi-truong">
  <div class="wrap">
    <div class="center">
      <span class="eyebrow">Môi trường làm việc</span>
      <h2 class="h2">Một nơi để bạn <em>lớn lên mỗi ngày</em></h2>
      <p class="lead">Không ai phải đi một mình. Mỗi giao dịch là công sức của cả đội.</p>
    </div>
    <div class="gal">{TEAM_IMG}{''.join(PICS[:4])}</div>
    <p class="slogan">Con người là nền tảng · Gắn kết tạo giá trị</p>
    <div class="envgrid">
      <div><i>🏢</i><b>Văn phòng trung tâm</b><span>23–25 Nguyễn Phước Lan, Đà Nẵng, gần các dự án trọng điểm.</span></div>
      <div><i>☀️</i><b>Họp đầu ngày</b><span>Cập nhật giỏ hàng, chính sách mới, đặt mục tiêu cùng đội.</span></div>
      <div><i>🎓</i><b>Đào tạo liên tục</b><span>Sản phẩm, pháp lý, kỹ năng tư vấn và chốt giao dịch.</span></div>
      <div><i>🤝</i><b>Đồng đội cùng dẫn khách</b><span>Hỗ trợ nhau tư vấn, dẫn khách, cùng chốt deal.</span></div>
      <div><i>🧭</i><b>Quản lý đi cùng bạn</b><span>Quản lý trực tiếp đi thị trường, kèm từng giao dịch.</span></div>
      <div><i>📈</i><b>Đánh giá minh bạch</b><span>Xét lương và cấp bậc mỗi 03 tháng, dựa trên kết quả.</span></div>
    </div>
    <div class="gal">{''.join(PICS[4:])}</div>
  </div>
</section>
"""
EXTRA_CSS = """<style>
.reasons{display:grid;gap:12px;margin-top:20px}
.reasons div{display:grid;grid-template-columns:52px 1fr;column-gap:14px;background:var(--soft);border-radius:14px;padding:14px 16px;align-items:start}
.reasons i{grid-row:span 2;font-style:normal;font-size:26px;width:52px;height:52px;border-radius:14px;background:#fff;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(27,45,107,.08)}
.reasons b{color:var(--navy);font-size:17px;line-height:1.3}
.reasons span{color:var(--muted);font-size:15px}
.envgrid{display:grid;gap:12px;margin-top:28px}
@media(min-width:760px){.envgrid{grid-template-columns:repeat(3,1fr)}}
.envgrid div{background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.15);border-radius:14px;padding:18px}
.envgrid i{font-style:normal;font-size:28px;display:block}
.envgrid b{display:block;font-size:17px;margin-top:6px}
.envgrid span{color:#C9D3EA;font-size:15px}
</style>
"""
import json
def jsonld(p):
    strip = lambda x: re.sub('<[^>]+>', '', x)
    job = {"@context": "https://schema.org", "@type": "JobPosting", "title": p['job_title'],
           "description": '<p>' + strip(p['desc']) + '</p><ul>' + ''.join('<li>' + strip(i) + '</li>' for c in p['panels'] for _, items in c['lists'] for i in items) + '</ul>',
           "datePosted": "2026-10-05", "validThrough": "2026-12-31T23:59", "employmentType": "FULL_TIME",
           "hiringOrganization": {"@type": "Organization", "name": "Tuyển Sale Đà Nẵng", "sameAs": SITE + "/"},
           "jobLocation": {"@type": "Place", "address": {"@type": "PostalAddress", "streetAddress": "23–25 Nguyễn Phước Lan", "addressLocality": "Đà Nẵng", "addressRegion": "Đà Nẵng", "addressCountry": "VN"}},
           "directApply": True, "url": URL[p['key']]}
    if p.get('salary'):
        job["baseSalary"] = {"@type": "MonetaryAmount", "currency": "VND", "value": {"@type": "QuantitativeValue", "minValue": p['salary'][0], "maxValue": p['salary'][1], "unitText": "MONTH"}}
    faq = {"@context": "https://schema.org", "@type": "FAQPage", "mainEntity": [{"@type": "Question", "name": strip(q), "acceptedAnswer": {"@type": "Answer", "text": strip(a)}} for q, a in p['faq']]}
    return ''.join('<script type="application/ld+json">' + json.dumps(x, ensure_ascii=False) + '</script>\n' for x in (job, faq))
def page(p):
    h = head
    h = re.sub(r'<title>.*?</title>', f'<title>{p["title"]}</title>', h, flags=re.S)
    h = re.sub(r'<meta name="description" content="[^"]*">', f'<meta name="description" content="{p["desc"]}">', h)
    h = re.sub(r'<meta property="og:title" content="[^"]*">', f'<meta property="og:title" content="{p["title"]}">', h)
    h = re.sub(r'<meta property="og:description" content="[^"]*">', f'<meta property="og:description" content="{p["desc"]}">', h)
    h += EXTRA_CSS
    BG = {'nv': 'dao-tao', 'cv': 'hop-dau-ngay', 'pro': 'ky-ket-casamia-2', 'tn': 'ra-quan-1', 'sv': 'team-trip-1'}[p['key']]
    h += '<style>.hero-b{background:linear-gradient(180deg,rgba(21,36,90,.72),rgba(21,36,90,.9)),url("' + IMG + BG + '.jpg") center/cover no-repeat #15245A!important}</style>\n'
    h += jsonld(p)
    h += '<link rel="canonical" href="' + URL[p['key']] + '">\n<style>.crumb{font-size:13px;color:#C9D3EA;margin-bottom:12px}.crumb a{color:#FFB98F;text-decoration:none}\n.role-lv{display:inline-block;background:var(--orange);color:#fff;font-weight:800;font-size:13px;padding:3px 12px;border-radius:999px;margin-bottom:10px}\n.panel h4{margin:14px 0 4px;font-size:15px;font-weight:800;color:inherit}</style>\n'
    unit = lambda a: re.sub(r'^([+]?\d[\d–%]*)([A-Za-zĐđ]+)$', r'\1<i>\2</i>', a)
    kp = ''.join('<div><b>%s</b><span>%s</span></div>' % (unit(a), b) for a, b in p['kpis'])
    fields = ''.join(f'''      <label for="{fid}">{lab}</label>
      <select id="{fid}" name="{nm}">{opts(o)}</select>
''' for fid, nm, lab, o in p['selects'])
    hidden = f'      <input type="hidden" name="position" value="{p["position"]}">\n' if p.get('position') else ''
    hero = f'''<section class="hero hero-b" id="top">
  <div class="wrap">
    <div>
      <p class="crumb"><a href="{SITE}/">Tuyển Sale Đà Nẵng</a> › {p["crumb"]}</p>
      <span class="badge"><i class="dot"></i> {p["badge"]}</span>
      <p class="kw">{p["kw"]}</p>
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
    love = f"""<section class="sec" id="vi-sao-thich">
  <div class="wrap">
    <div class="split">
      <img class="illu" src="{IMG}{p['illu'][0]}" alt="{p['illu'][1]}" loading="lazy">
      <div>
        <span class="eyebrow">{p['love_eyebrow']}</span>
        <h2 class="h2" style="font-size:32px">{p['love_h2']}</h2>
        <div class="reasons">""" + ''.join(f'<div><i>{e}</i><b>{h}</b><span>{d}</span></div>' for e, h, d in p['love']) + f"""</div>
        <a class="btn" href="#dang-ky" style="margin-top:22px">{p['cta']}</a>
      </div>
    </div>
  </div>
</section>
"""
    tl = ''.join(f'<div><b>{a}</b><p><strong>{h}</strong>{d}</p></div>' for a, h, d in p['day'])
    phone = f'<img class="illu phone" src="{IMG}lead-moi-ngay.png" alt="Minh hoạ điện thoại Sale nhận lead mới mỗi ngày" loading="lazy">' if p.get('phone') else ''
    day = f"""<section class="sec">
  <div class="wrap">
    <span class="eyebrow">Hình dung trước công việc</span>
    <h2 class="h2">{p['day_h2']}</h2>
    <div class="split tlsplit"><div><div class="tl">{tl}</div>
    <div class="truth"><b>{p['truth'][0]}</b><p>{p['truth'][1]}</p></div></div>{phone}</div>
  </div>
</section>
"""
    order = [hero, love, roles, sections['su-that'] if p.get('su_that') else '', p.get('extra', ''), policy,
             MKT3, ENV, sections['du-an'], journey, day, sections['leader'], final, faq]
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
  desc='Tuyển nhân viên kinh doanh BĐS tại Đà Nẵng, nhận sinh viên mới ra trường, không cần kinh nghiệm. Đào tạo từ đầu, phân bổ lead, marketing hỗ trợ 50–100%, thưởng marketing đến 10tr/GD, HĐLĐ & BHXH.',
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
  cards=[('100%', 'Marketing hỗ trợ 50–100%', 'Giải ngân ngay khi đề xuất, có ngân sách tiếp cận khách.'), ('LEAD', 'Marketing đầu tổng phân lead', 'Người mới cũng có khách thật để tư vấn.'), ('10TR', 'Thưởng marketing đến 10tr/GD', 'Cộng hoa hồng và thưởng nóng mỗi giao dịch.'), ('03', 'Tháng xét lương & cấp bậc', 'Thăng tiến bằng kết quả, không bằng thâm niên.'), ('7–10TR', 'Lên Pro Sales', 'Pro Sales lương 7–10 triệu/tháng, cộng hoa hồng và thưởng.'), ('HĐLĐ', 'Hợp đồng & bảo hiểm', 'BHYT, BHXH đầy đủ, yên tâm làm lâu dài.')],
  steps_h2='Từ người mới <em>đến người dẫn đội</em>',
  steps=[('Bước 1', 'Đào tạo', 'Sản phẩm, tìm khách, tư vấn, xử lý từ chối, chốt giao dịch.'), ('Bước 2', 'Ra trận có người kèm', 'Được phân bổ lead, quản lý và đồng đội cùng dẫn khách.'), ('Sau 03 tháng', 'Xét lương & cấp bậc', 'Kết quả tốt thì tăng lương, lên Chuyên viên.'), ('Tiếp theo', 'Pro Sales / Trưởng nhóm', 'Pro Sales lương 7–10 triệu/tháng, hoặc dẫn dắt đội nhóm.')],
  faq=[('Chưa có kinh nghiệm có ứng tuyển được không?', 'Được. Vị trí Nhân viên kinh doanh không yêu cầu kinh nghiệm, bạn được đào tạo từ đầu.'), ('Sinh viên mới ra trường có được nhận không?', 'Có. Ngành nào cũng được, bạn được đào tạo, có người kèm và được phân bổ lead.'), ('Người mới có khách để tư vấn không?', 'Có. Marketing phân bổ lead cho toàn đội và hỗ trợ chi phí marketing 50–100%.'), ('Thu nhập gồm những gì?', 'Lương, hoa hồng, thưởng marketing đến 10tr/giao dịch và thưởng nóng. Chi tiết trao đổi khi tư vấn 1:1.')] + COMMON_FAQ_END,
  su_that=True, grad=True, timeline=True),
'chuyen-vien': dict(key='cv', position='Chuyên viên kinh doanh BĐS', crumb='Chuyên viên kinh doanh BĐS',
  title='Tuyển Chuyên Viên Kinh Doanh BĐS Đà Nẵng | Tuyển Sale Đà Nẵng',
  desc='Tuyển chuyên viên kinh doanh BĐS tại Đà Nẵng. Marketing hỗ trợ 50–100%, phân bổ lead, thưởng marketing đến 10tr/GD + hoa hồng + thưởng nóng, 03 tháng xét lương, lên Pro Sales lương 7–10 triệu/tháng.',
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
  cards=[('100%', 'Marketing hỗ trợ 50–100%', 'Giải ngân ngay khi đề xuất, chạy quảng cáo không lo vốn.'), ('LEAD', 'Marketing đầu tổng phân lead', 'Có khách đều để tư vấn mỗi ngày.'), ('10TR', 'Thưởng marketing đến 10tr/GD', 'Cộng hoa hồng và thưởng nóng mỗi giao dịch.'), ('03', 'Tháng xét lương & cấp bậc', 'Kèm thưởng đánh giá cấp bậc, không phải chờ cả năm.'), ('7–10TR', 'Đặc biệt: Pro Sales', 'Lương 7–10 triệu/tháng khi đạt Pro Sales, cộng hoa hồng và thưởng.'), ('HĐLĐ', 'Hợp đồng & bảo hiểm', 'BHYT, BHXH đầy đủ, chuyên nghiệp, minh bạch.')],
  steps_h2='Chuyên viên → <em>Pro Sales → Quản lý</em>',
  steps=[('Ngày đầu', 'Nắm sản phẩm', 'Đào tạo dự án, chính sách, bắt nhịp nhanh với kinh nghiệm sẵn có.'), ('Hằng ngày', 'Nhận lead, chốt deal', 'Marketing đầu tổng mạnh, ngân sách hỗ trợ 50–100%.'), ('Mỗi 03 tháng', 'Xét lương & cấp bậc', 'Kết quả tốt thì tăng lương, tăng cấp.'), ('Bước tiếp', 'Pro Sales / Trưởng nhóm', 'Pro Sales lương 7–10 triệu/tháng, hoặc dẫn dắt đội nhóm.')],
  faq=[('Marketing hỗ trợ 50–100% nghĩa là gì?', 'Chi phí marketing được hỗ trợ 50–100% và giải ngân ngay khi đề xuất. Điều kiện cụ thể trao đổi khi tư vấn.'), ('Thưởng marketing tính thế nào?', 'Thưởng marketing đến 10tr/giao dịch, cộng hoa hồng và thưởng nóng.'), ('Pro Sales là gì?', 'Cấp bậc dành cho Sale có kết quả nổi bật, lương 7–10 triệu/tháng, cộng hoa hồng và thưởng theo giao dịch.'), ('Bao lâu được xét tăng lương?', '03 tháng xét tăng lương và cấp bậc, kèm thưởng đánh giá cấp bậc.')] + COMMON_FAQ_END,
  su_that=True, timeline=True),
'pro-sales': dict(key='pro', position='Chuyên gia kinh doanh (Pro Sales)', crumb='Chuyên gia kinh doanh (Pro Sales)',
  title='Tuyển Pro Sales BĐS Đà Nẵng – Lương 7–10 Triệu/Tháng | Tuyển Sale Đà Nẵng',
  desc='Tuyển chuyên gia kinh doanh BĐS (Pro Sales) tại Đà Nẵng: lương 7–10 triệu/tháng, cộng hoa hồng, thưởng marketing đến 10tr/GD, thưởng nóng, marketing hỗ trợ 50–100%.',
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
  cards=[('7–10TR', 'Lương mỗi tháng', 'Lương 7–10 triệu/tháng dành cho Pro Sales.'), ('10TR', 'Thưởng marketing/GD', 'Đến 10tr mỗi giao dịch, cộng hoa hồng và thưởng nóng.'), ('100%', 'Marketing hỗ trợ', 'Hỗ trợ 50–100%, giải ngân ngay khi đề xuất.'), ('LEAD', 'Marketing đầu tổng', 'Phân bổ lead đều cho đội, Pro Sales tập trung chốt.'), ('03', 'Tháng xét cấp bậc', 'Xét tăng lương và cấp bậc, kèm thưởng đánh giá.'), ('HĐLĐ', 'Hợp đồng & bảo hiểm', 'BHYT, BHXH đầy đủ.')],
  steps_h2='Pro Sales → <em>Trưởng nhóm → Trưởng phòng</em>',
  steps=[('Tuần đầu', 'Nắm giỏ hàng', 'Đào tạo sản phẩm, chính sách các dự án đang phân phối.'), ('Hằng ngày', 'Lead & chốt', 'Nhận lead từ marketing đầu tổng, tập trung tư vấn và chốt.'), ('Mỗi 03 tháng', 'Xét cấp bậc', 'Đánh giá kết quả, tăng lương và cấp bậc.'), ('Bước tiếp', 'Dẫn đội', 'Lên Trưởng nhóm, xây đội của riêng bạn.')],
  faq=[('Lương Pro Sales bao nhiêu?', 'Lương 7–10 triệu/tháng, cộng thêm hoa hồng, thưởng marketing đến 10tr/giao dịch và thưởng nóng.'), ('Điều kiện để là Pro Sales?', 'Tiêu chí cụ thể được trao đổi trực tiếp, dựa trên kinh nghiệm và kết quả kinh doanh của bạn.'), ('Tôi đang làm ở nơi khác, thông tin có được bảo mật?', 'Có. Mọi trao đổi đều 1:1 và bảo mật.')] + COMMON_FAQ_END,
  su_that=True, timeline=True),
'truong-nhom': dict(key='tn', position='', crumb='Trưởng nhóm / Trưởng phòng kinh doanh',
  title='Tuyển Trưởng Nhóm, Trưởng Phòng Kinh Doanh BĐS Đà Nẵng – Trưởng Phòng 10–20 Triệu | Tuyển Sale Đà Nẵng',
  desc='Tuyển Trưởng nhóm, Trưởng phòng kinh doanh BĐS tại Đà Nẵng. Trưởng phòng lương 10–20 triệu/tháng. Marketing đầu tổng mạnh, phân bổ lead cho toàn đội, marketing hỗ trợ 50–100%, HĐLĐ & BHXH đầy đủ.',
  badge='Vị trí quản lý · Trưởng nhóm / Trưởng phòng',
  h1='Đừng chỉ bán.<br><em>Hãy dẫn đội.</em>',
  sub='Bạn đã bán giỏi. Bước tiếp theo là xây một đội cùng bán giỏi. Chúng tôi trao sản phẩm, marketing và hệ thống.',
  kpis=[('10–20TR', 'Lương Trưởng phòng'), ('LEAD', 'Phân bổ cho cả đội'), ('100%', 'Hỗ trợ marketing'), ('10TR', 'Thưởng MKT/giao dịch')],
  cta='Ứng tuyển vị trí quản lý →', form_h='Ứng tuyển vị trí quản lý', form_note='Trao đổi 1:1, bảo mật tuyệt đối. <b>Hoàng Hiệp</b> gọi lại.', form_btn='Ứng tuyển ngay →',
  selects=[('pos', 'position', 'Vị trí ứng tuyển', ['Trưởng nhóm kinh doanh', 'Trưởng phòng kinh doanh']), ('team', 'management_experience', 'Bạn đã quản lý đội Sale chưa?', ['Chưa, nhưng muốn thử sức', 'Đã quản lý dưới 5 người', 'Đã quản lý từ 5 người trở lên'])],
  role_eyebrow='Hai vị trí quản lý', role_h2='Trưởng nhóm <em>hay Trưởng phòng?</em>',
  panels=[dict(lv='Cấp 03 · Trưởng nhóm', h='Trưởng nhóm kinh doanh', btn='Ứng tuyển Trưởng nhóm →', lists=[('Công việc', ['Dẫn dắt nhóm Sale, đặt mục tiêu và theo dõi kết quả', 'Kèm cặp, đào tạo nhân viên mới ra giao dịch', 'Cùng đội tư vấn, dẫn khách, chốt giao dịch', 'Lập kế hoạch, tìm giải pháp thúc đẩy kết quả']), ('Phù hợp nếu', ['Đã có kinh nghiệm Sale BĐS và giao dịch thực tế', 'Thích chia sẻ, kèm người, muốn xây đội của riêng mình'])]),
          dict(lv='Cấp 04 · Trưởng phòng · Lương 10–20 triệu', h='Trưởng phòng kinh doanh', btn='Ứng tuyển Trưởng phòng →', lists=[('Công việc', ['Xây dựng, vận hành phòng kinh doanh, quản lý các Trưởng nhóm', 'Hoạch định chiến lược bán hàng, phối hợp marketing triển khai dự án', 'Tuyển dụng, đào tạo, phát triển đội ngũ', 'Chịu trách nhiệm doanh số và hiệu quả của phòng']), ('Phù hợp nếu', ['Đã có kinh nghiệm quản lý đội Sale BĐS', 'Có tư duy chiến lược, muốn phát triển lên cấp Giám đốc'])])],
  pol_eyebrow='Hệ thống phía sau bạn', pol_h2='Quản lý giỏi cần <em>một nền tảng đủ mạnh</em>',
  pol_note='Chế độ chi tiết cho Trưởng nhóm được trao đổi trực tiếp khi tư vấn 1:1.',
  cards=[('10–20TR', 'Lương Trưởng phòng', 'Lương 10–20 triệu/tháng, cộng thu nhập theo kết quả của phòng.'), ('LEAD', 'Marketing đầu tổng mạnh', 'Phân bổ lead cho toàn đội, đội của bạn luôn có khách để tư vấn.'), ('100%', 'Marketing hỗ trợ', 'Ngân sách marketing hỗ trợ 50–100%, giải ngân ngay khi đề xuất.'), ('7–10TR', 'Pro Sales trong đội', 'Sale giỏi của bạn có lương 7–10 triệu/tháng, dễ giữ người, dễ tạo động lực.'), ('10TR', 'Thưởng marketing/GD', 'Cộng hoa hồng và thưởng nóng, động lực cho cả đội.'), ('03', 'Tháng xét cấp bậc', 'Đánh giá định kỳ, lộ trình rõ ràng cho đội ngũ.')],
  steps_h2='Từ dẫn nhóm <em>đến dẫn khối kinh doanh</em>',
  steps=[('Bước 1', 'Nhận đội', 'Nắm sản phẩm, hệ thống, nhận và xây dựng nhân sự.'), ('Hằng ngày', 'Dẫn đội ra trận', 'Đội nhận lead từ marketing đầu tổng, bạn kèm và cùng chốt.'), ('Mỗi 03 tháng', 'Đánh giá cấp bậc', 'Kết quả của đội là thước đo thăng tiến.'), ('Tiếp theo', 'Trưởng phòng → Giám đốc', 'Mở rộng quy mô, dẫn dắt khối kinh doanh.')],
  faq=[('Chưa từng quản lý có ứng tuyển Trưởng nhóm được không?', 'Có thể, nếu bạn có kết quả Sale tốt và muốn dẫn đội. Chúng tôi trao đổi 1:1 để tìm lộ trình phù hợp.'), ('Đội của tôi lấy khách từ đâu?', 'Marketing đầu tổng mạnh, phân bổ lead cho toàn đội, kèm ngân sách marketing hỗ trợ 50–100%.'), ('Thu nhập của quản lý thế nào?', 'Trưởng phòng lương 10–20 triệu/tháng. Chế độ chi tiết cho Trưởng nhóm được trao đổi trực tiếp, tương xứng với quy mô và kết quả của đội.'), ('Thông tin ứng tuyển có được bảo mật?', 'Có. Mọi trao đổi đều 1:1 và bảo mật tuyệt đối.')] + COMMON_FAQ_END,
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
  cards=[('100%', 'Marketing hỗ trợ 50–100%', 'Giải ngân ngay khi đề xuất, không bỏ tiền túi chạy quảng cáo.'), ('LEAD', 'Có khách ngay từ đầu', 'Marketing đầu tổng phân lead cho cả đội, kể cả người mới.'), ('10TR', 'Thưởng marketing đến 10tr/GD', 'Cộng hoa hồng và thưởng nóng mỗi giao dịch.'), ('03', 'Tháng xét lương & cấp bậc', 'Thăng tiến bằng kết quả, không bằng thâm niên.'), ('7–10TR', 'Lên Pro Sales', 'Pro Sales lương 7–10 triệu/tháng, cộng hoa hồng và thưởng.'), ('HĐLĐ', 'Hợp đồng & bảo hiểm', 'BHYT, BHXH đầy đủ ngay từ đầu.')],
  steps_h2='12 tháng đầu sau khi <em>cầm bằng</em>',
  steps=[('Tháng 1', 'Học & ra trận', 'Nắm sản phẩm, đi dự án, nhận lead, có người kèm từng cuộc gọi.'), ('Tháng 2–3', 'Giao dịch đầu tay', 'Chốt deal đầu tiên, nhận hoa hồng cộng thưởng marketing đến 10tr.'), ('Tháng 3', 'Xét lương & cấp bậc', 'Kết quả tốt thì tăng lương, lên cấp.'), ('Tháng 4–12', 'Pro Sales / Trưởng nhóm', 'Pro Sales lương 7–10 triệu/tháng, hoặc dẫn dắt đội của riêng bạn.')],
  faq=[('Không học ngành kinh tế có làm được không?', 'Được. Ngành nào cũng được, kiến thức sản phẩm và kỹ năng bán hàng đều được đào tạo từ đầu.'), ('Sắp tốt nghiệp, chưa có bằng có ứng tuyển được không?', 'Bạn cứ để lại thông tin. Hoàng Hiệp sẽ gọi lại trao đổi trực tiếp về thời gian bắt đầu phù hợp.'), ('Người mới có khách để tư vấn không?', 'Có. Marketing phân bổ lead cho toàn đội và hỗ trợ chi phí marketing 50–100%.'), ('Thu nhập gồm những gì?', 'Lương, hoa hồng, thưởng marketing đến 10tr/giao dịch và thưởng nóng. Chi tiết trao đổi khi tư vấn 1:1.'), ('Nghề Sale có áp lực không?', 'Có. Có ngày gọi nhiều mà chưa có khách. Nhưng bạn có lead sẵn, có người kèm và không phải đi một mình.')] + COMMON_FAQ_END,
  su_that=True, timeline=True)

ROLE = {
'nhan-vien': dict(
  illu=('nv-hanh-trinh.png', 'Hành trình 90 ngày đầu của Nhân viên kinh doanh: đào tạo, có người kèm, giao dịch đầu, xét lương sau 03 tháng'),
  love_eyebrow='Vì sao người mới thích vị trí này', love_h2='Không ai bắt bạn <em>tự bơi.</em>',
  love=[('🎓', 'Học từ con số 0', 'Sản phẩm, pháp lý, tìm khách, chốt giao dịch: được đào tạo bài bản.'),
        ('🧑‍🏫', 'Có người kèm thật', 'Quản lý và đồng đội đi cùng bạn trong những cuộc gọi, những lần dẫn khách đầu tiên.'),
        ('📲', 'Có khách để tư vấn ngay', 'Lead được phân bổ cho cả đội, người mới không phải tự bỏ tiền chạy quảng cáo.'),
        ('🚀', 'Lên cấp nhanh', '03 tháng xét lương và cấp bậc. Làm tốt là lên Chuyên viên, không chờ thâm niên.')],
  day_h2='Một ngày của <em>Nhân viên kinh doanh</em>',
  day=[('08:30', 'Họp đầu ngày', 'Nghe cập nhật giỏ hàng, nhận mục tiêu trong ngày.'), ('09:00', 'Học & luyện kịch bản', 'Ôn sản phẩm, luyện tư vấn cùng quản lý.'), ('10:00', 'Gọi lead được phân bổ', 'Chăm khách, có người kèm khi cần.'), ('13:30', 'Đi dự án', 'Cùng đồng đội đi nhà mẫu, nắm sản phẩm tận nơi.'), ('15:30', 'Dẫn khách cùng đội', 'Quan sát, hỗ trợ, học cách chốt.'), ('17:00', 'Tổng kết', 'Cập nhật CRM, rút kinh nghiệm với quản lý.')],
  truth=('Tháng đầu sẽ có lúc bỡ ngỡ.', 'Đó là bình thường. Bạn được đào tạo, có người kèm và có khách thật để luyện tập. Việc của bạn là học nhanh và không bỏ cuộc.'),
  phone=True),
'chuyen-vien': dict(
  illu=('cv-do-nghe.png', 'Chuyên viên kinh doanh ở trung tâm, xung quanh là lead đều mỗi ngày, ngân sách marketing hỗ trợ 50–100%, giỏ hàng lớn và thưởng marketing đến 10 triệu mỗi giao dịch'),
  love_eyebrow='Vì sao Sale có kinh nghiệm chọn ở đây', love_h2='Kỹ năng bạn đã có. <em>Đồ nghề chúng tôi lo.</em>',
  love=[('📈', 'Ngân sách marketing 50–100%', 'Giải ngân ngay khi đề xuất. Chạy quảng cáo không lo vốn.'),
        ('📲', 'Lead đều mỗi ngày', 'Marketing đầu tổng phân lead cho cả đội, bạn tập trung tư vấn và chốt.'),
        ('🏙️', 'Giỏ hàng dễ tạo niềm tin', 'Dự án Sun Group, Vinhomes, Đạt Phương: khách đã biết tên chủ đầu tư.'),
        ('💰', 'Mỗi giao dịch đáng giá hơn', 'Hoa hồng + thưởng marketing đến 10 triệu + thưởng nóng.')],
  day_h2='Một ngày của <em>Chuyên viên kinh doanh</em>',
  day=[('08:30', 'Họp đầu ngày', 'Giỏ hàng mới, chính sách mới, mục tiêu trong ngày.'), ('09:00', 'Chăm lead & khách cũ', 'Gọi, nhắn Zalo, hẹn lịch xem dự án.'), ('10:30', 'Content cá nhân', 'Đăng bài, livestream, xây thương hiệu cá nhân.'), ('13:30', 'Tư vấn chuyên sâu', 'Gửi bảng tính dòng tiền, so sánh căn, giải đáp pháp lý.'), ('15:00', 'Dẫn khách', 'Đi dự án, nhà mẫu, đàm phán.'), ('17:00', 'Follow-up & chốt', 'Chốt lịch, cập nhật CRM, báo cáo.')],
  truth=('Bạn không cần học lại từ đầu.', 'Bạn cần sản phẩm đủ lớn, nguồn khách đủ đều và chính sách đủ hấp dẫn để kỹ năng ra tiền. Phần đó đã sẵn sàng.'),
  phone=True),
'pro-sales': dict(
  illu=('pro-chan-dung.png', 'Chân dung Pro Sales: lương 7–10 triệu mỗi tháng, chốt deal giá trị lớn, khách đầu tư, lead từ marketing, hình mẫu của đội'),
  love_eyebrow='Vì sao Pro Sales chọn ở đây', love_h2='Bạn bán giỏi. <em>Hãy được trả xứng đáng.</em>',
  love=[('💼', 'Lương 7–10 triệu/tháng', 'Mức sàn đều đặn mỗi tháng, chưa tính hoa hồng và thưởng.'),
        ('🎯', 'Tập trung vào việc chốt', 'Marketing đầu tổng lo lead, bạn dồn sức cho khách giá trị lớn.'),
        ('🏆', 'Khách đầu tư, deal lớn', 'Giỏ hàng dự án trọng điểm tại Đà Nẵng – Hội An.'),
        ('🔒', 'Trao đổi bảo mật', 'Đang làm nơi khác? Mọi trao đổi đều 1:1 và kín đáo.')],
  day_h2='Một ngày của <em>Pro Sales</em>',
  day=[('08:30', 'Họp đầu ngày', 'Nắm giỏ hàng, chính sách, phân bổ lead.'), ('09:30', 'Chăm khách đầu tư', 'Cập nhật cơ hội, gửi phân tích dòng tiền.'), ('11:00', 'Hẹn gặp khách', 'Tư vấn trực tiếp, đàm phán phương án.'), ('14:00', 'Dẫn khách VIP', 'Đi dự án, nhà mẫu, chốt căn.'), ('16:00', 'Chia sẻ cho đội', 'Kèm người mới, chia sẻ kinh nghiệm chốt.'), ('17:30', 'Follow-up', 'Hoàn tất thủ tục, cập nhật CRM.')],
  truth=('Pro Sales là danh hiệu phải giữ.', 'Tiêu chí xét Pro Sales dựa trên kết quả thật và được trao đổi rõ ràng khi tư vấn 1:1. Đạt rồi thì giữ chuẩn để giữ quyền lợi.'),
  phone=True, su_that=False),
'truong-nhom': dict(
  illu=('tn-so-do.png', 'Sơ đồ đội: Trưởng phòng lương 10–20 triệu, các Trưởng nhóm và Sale, Marketing đầu tổng phân lead cho cả đội'),
  love_eyebrow='Vì sao quản lý chọn ở đây', love_h2='Bạn dẫn đội. <em>Hệ thống lo nguồn khách.</em>',
  love=[('💼', 'Trưởng phòng lương 10–20 triệu', 'Lương tháng tương xứng với vai trò xây và vận hành phòng.'),
        ('📲', 'Đội luôn có khách', 'Marketing đầu tổng phân lead cho cả đội, kèm ngân sách hỗ trợ 50–100%.'),
        ('🧲', 'Dễ giữ người giỏi', 'Pro Sales trong đội có lương 7–10 triệu/tháng, tạo động lực ở lại.'),
        ('🪜', 'Lộ trình lên Giám đốc', 'Trưởng nhóm → Trưởng phòng → Giám đốc, thăng tiến bằng kết quả của đội.')],
  day_h2='Một ngày của <em>người dẫn đội</em>',
  day=[('08:00', 'Chuẩn bị', 'Xem số liệu đội, chuẩn bị nội dung họp.'), ('08:30', 'Họp đầu ngày', 'Truyền lửa, phân bổ lead, đặt mục tiêu.'), ('10:00', 'Kèm 1:1', 'Nghe cuộc gọi, sửa kịch bản, gỡ khó cho từng người.'), ('14:00', 'Ra trận cùng đội', 'Cùng dẫn khách, hỗ trợ chốt deal lớn.'), ('16:00', 'Tuyển & đào tạo', 'Phỏng vấn ứng viên, đào tạo người mới.'), ('17:30', 'Tổng kết', 'Đánh giá kết quả, lên kế hoạch ngày mai.')],
  truth=('Làm quản lý là chịu trách nhiệm cho kết quả của người khác.', 'Không dễ. Nhưng khi cả đội cùng chốt được, đó là cảm giác không giao dịch đơn lẻ nào mang lại được.'),
  phone=False, su_that=False),
'moi-ra-truong': dict(
  illu=('sv-hai-con-duong.png', 'Minh hoạ hai con đường sau khi ra trường: lương cứng tăng theo thâm niên và Sale BĐS tăng theo kết quả, 03 tháng xét lương, lên Pro Sales, lên quản lý'),
  love_eyebrow='Vì sao tân cử nhân chọn Sale BĐS', love_h2='Năm đầu đi làm <em>quyết định rất nhiều thứ.</em>',
  love=[('📚', 'Học nghề thật, không học lý thuyết', 'Đào tạo sản phẩm, pháp lý, kỹ năng và áp dụng ngay với khách thật.'),
        ('🧑‍🏫', 'Có người kèm từ ngày đầu', 'Không ai bắt bạn tự bơi. Quản lý và đồng đội đi cùng bạn.'),
        ('💸', 'Thu nhập theo năng lực', 'Lương + hoa hồng + thưởng marketing đến 10 triệu mỗi giao dịch.'),
        ('🗣️', 'Kỹ năng dùng cả đời', 'Giao tiếp, thuyết phục, đàm phán: mang theo ở bất kỳ nghề nào.')],
  day_h2='Một ngày của <em>Sale mới ra trường</em>',
  day=[('08:30', 'Họp đầu ngày', 'Nghe cập nhật, nhận mục tiêu, học từ anh chị đi trước.'), ('09:00', 'Học sản phẩm', 'Đào tạo dự án, luyện kịch bản tư vấn.'), ('10:30', 'Gọi lead', 'Chăm khách được phân bổ, có người kèm khi cần.'), ('13:30', 'Đi dự án', 'Tận mắt xem nhà mẫu, hiểu sản phẩm mình bán.'), ('15:30', 'Dẫn khách cùng đội', 'Học cách tư vấn và chốt từ người có kinh nghiệm.'), ('17:00', 'Tổng kết', 'Ghi lại bài học, cập nhật CRM.')],
  truth=('Sale có áp lực, và chúng tôi nói thẳng điều đó.', 'Có ngày gọi nhiều mà chưa có khách. Nhưng bạn có lead sẵn, có người kèm và có lộ trình rõ ràng. Người chịu khó sẽ lớn rất nhanh.'),
  phone=True),
}
for k, v in ROLE.items():
    PAGES[k].update(v)

SEO = {'nhan-vien': ('Tuyển Nhân Viên Kinh Doanh BĐS Đà Nẵng – Không Cần Kinh Nghiệm', 'Tuyển nhân viên kinh doanh BĐS Đà Nẵng, nhận SV mới ra trường. Đào tạo từ đầu, có lead sẵn, có người kèm, HĐLĐ & BHXH. Ứng tuyển trong 30 giây.', 'Tuyển Nhân viên kinh doanh BĐS Đà Nẵng', 'Nhân viên kinh doanh bất động sản', None), 'chuyen-vien': ('Tuyển Chuyên Viên Kinh Doanh BĐS Đà Nẵng 2026', 'Tuyển chuyên viên kinh doanh BĐS Đà Nẵng: hỗ trợ marketing 100%, lead đều, thưởng marketing đến 10tr/giao dịch, 03 tháng xét lương, lên Pro Sales.', 'Tuyển Chuyên viên kinh doanh BĐS Đà Nẵng', 'Chuyên viên kinh doanh bất động sản', None), 'pro-sales': ('Tuyển Pro Sales BĐS Đà Nẵng – Lương 7–10 Triệu/Tháng', 'Tuyển Pro Sales BĐS Đà Nẵng: lương 7–10 triệu/tháng chưa tính hoa hồng, thưởng marketing đến 10tr/giao dịch, lead từ marketing. Trao đổi 1:1, bảo mật.', 'Tuyển Pro Sales BĐS Đà Nẵng', 'Chuyên gia kinh doanh bất động sản (Pro Sales)', (7000000, 10000000)), 'truong-nhom': ('Tuyển Trưởng Nhóm, Trưởng Phòng Kinh Doanh BĐS Đà Nẵng', 'Tuyển Trưởng nhóm, Trưởng phòng kinh doanh BĐS Đà Nẵng. Trưởng phòng lương 10–20 triệu/tháng, marketing đầu tổng phân lead cho cả đội. Bảo mật 1:1.', 'Tuyển quản lý KD BĐS Đà Nẵng', 'Trưởng phòng kinh doanh bất động sản', (10000000, 20000000)), 'moi-ra-truong': ('Tuyển Sale Mới Ra Trường Đà Nẵng 2026 – Không Cần Kinh Nghiệm', 'Tuyển sinh viên mới ra trường làm Sale BĐS Đà Nẵng. Ngành nào cũng được, đào tạo từ con số 0, có lead sẵn, có người kèm, 03 tháng xét lương.', 'Tuyển Sale mới ra trường Đà Nẵng', 'Nhân viên kinh doanh bất động sản (mới ra trường)', None)}
for k, (t, d, kw, jt, sal) in SEO.items():
    PAGES[k].update(title=t, desc=d, kw=kw, job_title=jt, salary=sal)
os.makedirs(os.path.join(ROOT, 'vi-tri'), exist_ok=True)
for name, p in PAGES.items():
    html = page(p)
    open(os.path.join(ROOT, 'vi-tri', name + '.html'), 'w', encoding='utf-8').write(html)
    print(name, len(html), 'TATI' in html, '20tr' in html.lower())
