# Khối nội dung dùng lại giữa các trang (số liệu theo tài liệu Kick-off 23/10/2026 của chủ đầu tư)
from parts import *
import re

def tbl(head, rows, cls=''):
    """Bảng; trên điện thoại tự chuyển thành thẻ xếp dọc (nhãn cột lấy từ data-l)."""
    h = ''.join('<th>%s</th>' % x for x in head) if head else ''
    def cell(i, c):
        return ('<td data-l="%s">%s</td>' % (esc(re.sub('<[^>]+>', '', head[i])), c)) if head and i < len(head) else '<td>%s</td>' % c
    return '<div class="tw"><table class="tbl %s%s">%s<tbody>%s</tbody></table></div>' % (
        cls, ' st' if head else '', ('<thead><tr>%s</tr></thead>' % h) if h else '',
        ''.join('<tr>%s</tr>' % ''.join(cell(i, c) for i, c in enumerate(r)) for r in rows))

OVERVIEW = [
    ('Tên dự án', 'Sun Saphia Residence'),
    ('Đơn vị phát triển', 'Sun Property – thành viên Tập đoàn Sun Group'),
    ('Vị trí', 'Giao lộ Võ Nguyên Giáp – Nguyễn Đức Thuận – Trường Sa, khu Saphia, phường Ngũ Hành Sơn, TP Đà Nẵng'),
    ('Diện tích khu đất', '3.720,1 m²'),
    ('Chiều cao', '30 tầng – 114 m · 2 tầng hầm · căn hộ từ tầng 3A đến tầng 28'),
    ('Tổng số căn', '782 căn'),
    ('Cơ cấu sản phẩm', 'Studio 513 căn (30–31 m²) · 1BR+ 108 căn (50–51 m²) · 2BR 133 căn (60–70 m²)'),
    ('Chiều cao căn hộ', '3,5 m'),
    ('Tiêu chuẩn bàn giao', 'Hoàn thiện cơ bản'),
    ('Pháp lý', 'GCN đăng ký đầu tư mã dự án 2572746483, chứng nhận lần đầu 17/09/2026 · thời hạn dự án 50 năm · công trình cấp I, niên hạn 100 năm'),
    ('Ngân hàng hỗ trợ', 'Vietcombank · BIDV · NCB'),
    ('Dự kiến mở bán', 'Cuối tháng 11/2026'),
    ('Dự kiến bàn giao', 'Tháng 11/2028'),
]

def overview():
    return tbl(None, OVERVIEW, 'kv')

UNITS = [
    ('Studio', '30–31 m²', '3,8 × 9 m', '513 căn', 'Logia, giường + sofa không gian mở, bếp chữ L, WC tách khu tắm', 'Người trẻ, cặp đôi, cho thuê theo đêm'),
    ('1BR+1', '50–51 m²', '6,2 × 9 m', '108 căn', '1 phòng ngủ + phòng đa năng (có kiểu 2 phòng ngủ 1 vệ sinh)', 'Gia đình nhỏ, làm việc từ xa'),
    ('2BR', '60–70 m²', '7,25 × 9,9 m', '133 căn', '2 phòng ngủ, phòng khách, bếp; có căn góc bo tròn', 'Gia đình, second home'),
]

def units_table():
    return tbl(['Loại căn', 'Diện tích', 'Kích thước', 'Số lượng', 'Bố trí', 'Phù hợp'], [list(u) for u in UNITS]) + '<p class="src">Ba loại căn đã công bố chi tiết: 754 căn; phần còn lại trong tổng 782 căn theo công bố chính thức của chủ đầu tư.</p>'

def units_drawings():
    return ('<div class="g3 eqi">'
            + fig('can-studio', 'Mặt bằng căn Studio Sun Saphia Residence 30 m², kích thước 3,8 × 9 m', '<b>Studio</b> · 30–31 m² · 3,8 × 9 m', wm=True)
            + fig('can-1br', 'Mặt bằng căn 1BR+1 Sun Saphia Residence 50 m², kích thước 6,2 × 9 m', '<b>1BR+1</b> · 50–51 m² · 6,2 × 9 m', wm=True)
            + fig('can-2br', 'Mặt bằng căn 2BR góc Sun Saphia Residence 60–70 m², kích thước 7,25 × 9,9 m', '<b>2BR</b> · 60–70 m² · 7,25 × 9,9 m', wm=True)
            + '</div>')

PRICES = [
    ('The Soleil Đà Nẵng', '5,2–5,5 tỷ', '7,7–7,8 tỷ', '17,5 tỷ', '–'),
    ('Futa Residence Đà Nẵng', '9,1–10,5 tỷ', '10,3–11,5 tỷ', '17,4–17,6 tỷ', '–'),
    ('Nobu Đà Nẵng', '6,3–6,4 tỷ', '10,5–10,6 tỷ', '21,4–21,7 tỷ', '25,9 tỷ'),
    ('The Newtown Diamond', '–', '5,3–5,6 tỷ (1BR+)', '6,8–8,3 tỷ', '10–14 tỷ'),
]

def price_table():
    return tbl(['Dự án ven biển', 'Studio', '1BR', '2BR', '3BR'], [list(p) for p in PRICES]) + \
        '<p class="src">Giá chào bán tham khảo trình bày tại Kick-off 23/10/2026; không phải giá Sun Saphia Residence.</p>'

RENT_MONTH = [
    ('Sam Tower', '–', '15 tr', '23 tr', '–'),
    ('Hilton', '–', '–', '35 tr', '–'),
    ('Filmore', '–', '27 tr', '45 tr', '–'),
    ('Hiyori', '–', '–', '25 tr', '–'),
    ('Mornachy', '–', '14 tr', '20 tr', '35 tr'),
    ('Panoma', '18–20 tr', '24 tr', '35 tr', '–'),
]

def rent_month_table():
    return tbl(['Căn hộ đang cho thuê', 'Studio', '1PN', '2PN', '3PN'], [list(r) for r in RENT_MONTH]) + \
        '<p class="src">Giá thuê theo tháng các tòa căn hộ ven sông Hàn – trung tâm, khảo sát tin đăng (tài liệu Kick-off 23/10/2026).</p>'

def rent_night():
    return ('<div class="kpi"><div><b>2,2–2,9 tr</b><span>Studio view biển / đêm</span><small>giá trung bình ngoài mùa cao điểm</small></div>'
            '<div><b>3,4–3,7 tr</b><span>1BR+ view biển / đêm</span><small>giá trung bình ngoài mùa cao điểm</small></div>'
            '<div><b>81,3%</b><span>Lấp đầy khách sạn Sun Group miền Trung</span><small>năm 2026, từ 70,65% năm 2025</small></div></div>'
            '<p class="src">Tham chiếu giá thuê: Wyndham Soleil Danang, Saha Casa Boutique Hotel Danang, Radisson Hotel Danang (tài liệu Kick-off).</p>')

def occ_chart():
    data = [('Bắc', 57.3, 62.2), ('Trung', 70.65, 81.3), ('Nam', 62.4, 73.2)]
    bars = ''
    for i, (r, a, b) in enumerate(data):
        x = 50 + i * 110
        bars += ('<rect x="%d" y="%.1f" width="34" height="%.1f" rx="4" fill="#FFAA01"/><rect x="%d" y="%.1f" width="34" height="%.1f" rx="4" fill="#E96118"/>'
                 '<text x="%d" y="%.1f" font-size="11" text-anchor="middle" fill="#2B3650">%s%%</text><text x="%d" y="%.1f" font-size="11" text-anchor="middle" fill="#2B3650" font-weight="700">%s%%</text>'
                 '<text x="%d" y="226" font-size="13" text-anchor="middle" fill="#275286" font-weight="700">%s</text>') % (
            x, 205 - a * 1.8, a * 1.8, x + 38, 205 - b * 1.8, b * 1.8, x + 17, 199 - a * 1.8, str(a).replace('.', ','), x + 55, 199 - b * 1.8,
            str(b).replace('.', ','), x + 36, r)
    return ('<figure class="card fill" style="margin:0;display:flex;flex-direction:column;justify-content:center"><svg viewBox="0 0 380 240" role="img" aria-label="Tỷ lệ lấp đầy khách sạn Sun Group theo vùng: Bắc 57,3%% lên 62,2%%, Trung 70,65%% lên 81,3%%, Nam 62,4%% lên 73,2%% (2025 – 2026)" style="width:100%%;height:auto">'
            '<line x1="40" y1="205" x2="370" y2="205" stroke="#D6DEEA"/>%s'
            '<rect x="230" y="8" width="12" height="12" fill="#FFAA01"/><text x="246" y="18" font-size="12" fill="#2B3650">2025</text>'
            '<rect x="292" y="8" width="12" height="12" fill="#E96118"/><text x="308" y="18" font-size="12" fill="#2B3650">2026</text></svg>'
            '<figcaption class="src" style="background:none">Tỷ lệ lấp đầy (OCC) các khách sạn của Sun Group theo vùng, 2025 – 2026</figcaption></figure>') % bars

def rent_case():
    return tbl(['Bài toán minh họa', 'Studio view biển', '1BR view biển'], [
        ['Diện tích · giá tham khảo', '30 m² · 3 tỷ', '50 m² · 4,5 tỷ'],
        ['Giá thuê · lấp đầy', '2,5 tr/đêm · 60%', '3,5 tr/đêm · 60%'],
        ['Doanh thu', '540 triệu/năm', '756 triệu/năm'],
        ['Lợi nhuận thực nhận (65%)', '351 triệu/năm (~29,3 tr/tháng)', '492 triệu/năm (~41 tr/tháng)'],
        ['Tỷ lệ trên giá tham khảo', '11,7%/năm', '10,9%/năm']]) + \
        '<p class="note">Bài toán chủ đầu tư trình bày tại Kick-off với giá giả định, chưa phải giá bán chính thức. Kết quả thực tế phụ thuộc giá mua, mùa vụ, cách vận hành; không phải cam kết lợi nhuận.</p>'

def migration():
    return ('<div class="g3">'
            '<div class="card"><span class="n">DÒNG KHÁCH QUỐC TẾ</span><h3 class="oc">6,88 triệu lượt</h3><p>8 tháng đầu 2026 (+26,3%). Khách Hàn Quốc, Trung Quốc, Đài Loan, Ấn Độ, châu Âu, châu Mỹ đến vì biển đẹp, ẩm thực, chi phí sống thấp. Chuyên gia công nghệ, tài chính, KOL, giáo viên ngoại ngữ ở lại làm việc dài hạn, hình thành cộng đồng cư dân quốc tế.</p></div>'
            '<div class="card"><span class="n">DÒNG DI CƯ TRONG NƯỚC</span><h3 class="oc">15–16 nghìn người/năm</h3><p>Di cư ròng dương liên tục. Cư dân Hà Nội, TP.HCM "đổi phố lấy biển", tránh ô nhiễm – tắc đường – ngập lụt; người về hưu chọn Đà Nẵng an dưỡng; lao động trẻ miền Trung về tìm việc, cho con ăn học.</p></div>'
            '<div class="card"><span class="n">DÒNG DI CƯ SÁP NHẬP</span><h3 class="oc">~3 triệu dân</h3><p>Quy mô dân số mới sau sáp nhập Quảng Nam (từ 1/7/2025). Cán bộ, doanh nghiệp chuyển về trung tâm hành chính mới; trung lưu đưa con về học trường chất lượng cao; đô thị mở rộng, thêm việc làm và kinh doanh.</p></div>'
            '</div><p class="src">Nguồn: Cục Thống kê &amp; Sở VH-TT-DL TP Đà Nẵng (8 tháng 2026) · Nghị quyết 202/2025/QH15 · Báo Đấu thầu (2024) – theo tài liệu Kick-off.</p>')

def tenants():
    return ('<div class="g3">'
            '<article class="card">' + img('thap-dem-resort', 'Sun Saphia Residence về đêm bên chuỗi resort ven biển', 'r') + '<h3 style="margin-top:12px">Người làm việc chuỗi resort</h3><p class="just">Ở gần nơi làm, sống gần biển. Nhân sự chuỗi resort ven biển, kể cả chuyên gia nước ngoài, có nhu cầu thuê trung hạn, ổn định ngay trên cung đường resort.</p></article>'
            '<article class="card">' + img('thap-tren-cao-ngay', 'Toàn cảnh Sun Saphia Residence nhìn từ trên cao ban ngày', 'r') + '<h3 style="margin-top:12px">Cho thuê ngắn ngày kiểu Airbnb</h3><p class="just">Hình thức đang hút khách, lấp đầy cao, hợp với một Đà Nẵng đang đông khách. Thương hiệu Sun Group giúp căn hộ được quan tâm và cho thuê tốt hơn.</p></article>'
            '<article class="card">' + img('khach-du-lich', 'Nhóm khách du lịch trên bãi biển Đà Nẵng lúc hoàng hôn', 'r') + '<h3 style="margin-top:12px">Khách du lịch</h3><p class="just">Thức dậy cùng biển – đó là lý do họ đến. Khách ngày càng ưu tiên căn hộ phía biển; căn hộ mặt biển luôn là lựa chọn đầu tiên khi tìm chỗ ở.</p></article>'
            '</div>')

def timeline():
    return ('<div class="tl"><div><b>17/09/2026</b>Cấp Giấy chứng nhận đăng ký đầu tư</div>'
            '<div><b>17/10/2026</b>Ra mắt thông tin dự án</div>'
            '<div><b>23/10/2026</b>Kick-off "Đón ánh dương – Giao hòa nhịp sống" tại KOI Resorts &amp; Residence</div>'
            '<div class="hot"><b>Cuối 11/2026</b>Sự kiện mở bán (dự kiến) – công bố bảng giá, chính sách</div>'
            '<div><b>2/2027</b>Dự kiến khởi công đường sắt đô thị sân bay – Hội An (giai đoạn 1)</div>'
            '<div><b>11/2028</b>Dự kiến bàn giao căn hộ</div></div>'
            '<p class="note">Các mốc là kế hoạch dự kiến, có thể thay đổi theo công bố của chủ đầu tư và cơ quan nhà nước.</p>')

_BANKS = None
def banks():
    """Logo 3 ngân hàng nhúng thẳng vào trang (không phụ thuộc tải ảnh ngoài)."""
    global _BANKS
    if _BANKS is None:
        import base64, io
        from PIL import Image
        out = ''
        # Chuẩn hóa: chữ chính của 3 logo cao bằng nhau và cùng nằm trên một đường giữa
        spec = (('nh-1', 'Vietcombank', 74, 116), ('nh-2', 'BIDV', 23, 116), ('nh-3', 'NCB', 12, 65))
        # Cân giữa kích thước chữ và kích thước cả logo (trung bình nhân), đặt cùng một đường giữa
        CW, CH, S0 = 330, 120, 56.0
        for f, alt, y0, y1 in spec:
            im = Image.open(SK_DIR + f + '.webp').convert('RGBA')
            k = S0 / (im.height * (y1 - y0 + 1)) ** 0.5
            im = im.resize((round(im.width * k), round(im.height * k)), Image.LANCZOS)
            cy = ((y0 + y1) / 2 * k + im.height / 2) / 2
            cv = Image.new('RGBA', (CW, CH), (255, 255, 255, 0))
            cv.alpha_composite(im, ((CW - im.width) // 2, round(CH / 2 - cy)))
            buf = io.BytesIO(); cv.save(buf, 'WEBP', quality=90, method=6)
            out += '<img src="data:image/webp;base64,%s" alt="%s" width="%d" height="%d">' % (base64.b64encode(buf.getvalue()).decode(), alt, CW, CH)
        _BANKS = '<div class="banks"><span>NGÂN HÀNG HỖ TRỢ</span><div class="bl">' + out + '</div></div>'
    return _BANKS

def legal_box():
    return ('<div class="g2 eq"><div class="txt">'
            '<h3>Giấy chứng nhận đăng ký đầu tư</h3><p>Mã dự án <b>2572746483</b>, do Sở Tài chính TP Đà Nẵng cấp, chứng nhận lần đầu ngày <b>17/09/2026</b>.</p>'
            '<h3>Thời hạn dự án 50 năm</h3><p>Thời hạn hoạt động dự án 50 năm kể từ ngày 17/09/2026. Công trình cấp I, niên hạn sử dụng 100 năm.</p>'
            '<h3>Ngân hàng hỗ trợ</h3>' + banks() + ''
            '<p class="note" style="margin-top:10px">Tỷ lệ vay, thời gian hỗ trợ lãi suất theo chính sách bán hàng công bố khi mở bán.</p></div>'
            '<div class="g2 gcn" style="gap:12px">%s%s</div></div>') % (
        fig('gcn-dau-tu-2', 'Giấy chứng nhận đăng ký đầu tư dự án Sun Saphia Residence, mã dự án 2572746483 (đã làm mờ)', 'Trang 1 GCN đăng ký đầu tư (làm mờ)'),
        fig('gcn-dau-tu-1', 'Trích GCN đăng ký đầu tư: thời hạn hoạt động dự án 50 năm kể từ ngày cấp (đã làm mờ)', 'Mục thời hạn hoạt động 50 năm'))

def nq278():
    return ('<div class="card"><span class="n">CHÍNH SÁCH MỚI</span><h3 class="oc">Nghị quyết 278/NQ-CP (18/9/2026)</h3>'
            '<ul class="ck"><li>Xác định thời hạn sử dụng chung cư căn cứ theo niên hạn công trình và hồ sơ thiết kế</li>'
            '<li>Làm rõ quyền và nghĩa vụ khi nhà chung cư hết thời hạn sử dụng</li>'
            '<li>Giao cơ quan chức năng bảo đảm quyền lợi người dân, tách bạch quyền sở hữu căn hộ và quyền sử dụng đất</li></ul>'
            '<p><b>Ý nghĩa:</b> giá trị căn hộ 50 năm đang được định hình lại, thu hẹp khoảng cách giữa sản phẩm thương mại dịch vụ 50 năm và căn hộ sở hữu lâu dài.</p></div>')

def why_cards():
    it = [('01', 'Chính sách giá và bán hàng tốt nhất', 'Chính sách bán hàng và chính sách giá tốt nhất từ chủ đầu tư dành cho giai đoạn đầu.'),
          ('02', 'Chọn căn đẹp nhất', 'Sản phẩm có dòng tiền tốt, hữu hạn, vị trí mặt biển trung tâm. Căn đẹp chỉ có ở đợt đầu.'),
          ('03', 'Chủ đầu tư hỗ trợ lãi suất', 'Mức hỗ trợ lãi suất cao nhất đang áp dụng. Cuối 2028 – đầu 2029 (bàn giao), lãi suất kỳ vọng đã hạ và thị trường đã khác.'),
          ('04', 'Dòng tiền tìm đến trước', 'Khi thị trường quay đầu, sản phẩm giá trị thực, dòng tiền tốt, trung tâm, khan hiếm được tìm đến và tăng giá trước tiên.')]
    return ''.join('<div class="card"><span class="n">%s</span><h3 class="oc">%s</h3><p>%s</p></div>' % x for x in it)

def slogan_box(interest):
    return ('<div class="sbox"><div><span>Chi phí <b>tốt nhất</b></span><i>·</i><span>Lựa chọn <b>đẹp nhất</b></span><i>·</i><span>Tăng giá <b>đầu tiên</b></span></div>'
            '<button type="button" class="btn sm" data-pop data-interest="%s">Đăng ký sớm – ưu tiên chọn căn</button></div>') % esc(interest)

def why_now():
    it = [('01', 'Chính sách giá và bán hàng tốt nhất', 'Chính sách bán hàng và chính sách giá tốt nhất từ chủ đầu tư dành cho giai đoạn đầu.'),
          ('02', 'Chọn căn đẹp nhất', 'Sản phẩm có dòng tiền tốt, hữu hạn, vị trí mặt biển trung tâm. Căn đẹp chỉ có ở đợt đầu.'),
          ('03', 'Chủ đầu tư hỗ trợ lãi suất', 'Mức hỗ trợ lãi suất cao nhất đang áp dụng. Cuối 2028 – đầu 2029 (bàn giao), lãi suất kỳ vọng đã hạ và thị trường đã khác.'),
          ('04', 'Dòng tiền tìm đến trước', 'Khi thị trường quay đầu, sản phẩm giá trị thực, dòng tiền tốt, trung tâm, khan hiếm được tìm đến và tăng giá trước tiên.')]
    return ('<div class="why">' + ''.join('<div class="card"><span class="n">%s</span><h3 class="oc">%s</h3><p>%s</p></div>' % x for x in it)
            + '<div class="box"><span>Chi phí <b>tốt nhất</b></span><span>Lựa chọn <b>đẹp nhất</b></span><span>Tăng giá <b>đầu tiên</b></span></div></div>'
            '<p class="note">Chính sách giá, hỗ trợ lãi suất cụ thể theo công bố chính thức của chủ đầu tư khi mở bán.</p>')


IMG3 = RAW + 'fc04110b48e042d4acb3890ea1d46686aea154f0/landing/sun-saphia/v4/img/'
def rimg(name, alt, pos='50% 50%'):
    u = IMG3 + name
    return ('<img src="%s.webp" srcset="%s-900.webp 900w, %s.webp 1600w" sizes="(max-width: 760px) 100vw, 600px" width="1600" height="900" '
            'alt="%s" style="object-position:%s" loading="lazy" decoding="async">') % (u, u, u, alt, pos)

def views(bien_html=None):
    it = [('view-bien', 'Hướng <b>Biển</b>', 'It can be view from your Home.', 'Không cần đi nghỉ dưỡng, biển đã ở ngay ngoài ban công. Trước mặt là biển Mỹ Khê – Sơn Thủy.', 'View biển Mỹ Khê – Sơn Thủy nhìn từ tầng cao Sun Saphia Residence'),
          ('view-nui-ngu-hanh-son', 'Hướng <b>Núi</b> Ngũ Hành Sơn', 'Một bức tranh treo ngay cửa sổ.', 'Nhìn về Ngũ Hành Sơn – biểu tượng của Đà Nẵng, ngày nào cũng ở trong tầm mắt.', 'Sun Saphia Residence bên bờ biển, hướng nhìn về Ngũ Hành Sơn'),
          ('view-song-han', 'Hướng <b>Sông Hàn</b>', 'Hoàng hôn trên sông Hàn, vé xem miễn phí mỗi chiều.', 'Dòng sông thành phố trong một khung nhìn, cùng với biển và núi.', 'Phối cảnh Sun Saphia Residence nhìn về phía sông Hàn và thành phố'),
          ('view-do-thi-dem', 'Hướng <b>Đô thị</b>', 'Đà Nẵng lên đèn, ngay trước mắt bạn.', 'Thành phố rực sáng về đêm, mà tiếng ồn thì ở lại xa hơn.', 'Sun Saphia Residence về đêm, phía sau là đô thị Đà Nẵng lên đèn')]
    return '<div class="vw">' + ''.join('<article>%s<div><h3>%s</h3><q>%s</q><p class="just">%s</p></div></article>' % ((bien_html if (bien_html and a[0] == 'view-bien') else rimg('hero-bien', 'Biển ngay ngoài ban công – căn hộ cao tầng mặt biển Đà Nẵng lúc hoàng hôn (ảnh minh họa)', '62% 55%') if a[0] == 'view-bien' else rimg('bien-dem-ban-cong', 'Ban công căn hộ nhìn ra biển và công viên lên đèn về đêm (ảnh minh họa)') if a[0] == 'view-do-thi-dem' else img(a[0], a[4])), a[1], a[2], a[3]) for a in it) + '</div>'

def personas():
    it = [('kh-tre-tu-do', 'Khách hàng trẻ tự do', 'Làm điều mình thích, ở nơi mình thích.', 'Không gian linh hoạt để làm việc, đam mê, thể thao biển.', 'Căn Studio, 1BR+ nhỏ gọn; bãi biển cho SUP, kayak, jetski; cho thuê bù chi phí.', 'Làm việc từ đâu cũng được, thì sao không từ Đà Nẵng, cạnh biển?'),
          ('kh-thanh-dat', 'Người thành đạt', 'Thành quả xứng đáng, một nơi chọn cho mình.', 'Second home đẳng cấp cho cả gia đình, thương hiệu uy tín.', 'Sản phẩm của Sun Group, tòa 30 tầng, tầm nhìn sông – núi – biển.', 'Phần thưởng cho mình không cần phải ồn ào, chỉ cần đúng chỗ.'),
          ('kh-nghi-duong-som', 'Người nghỉ dưỡng sớm', 'Nghỉ hưu sớm, sống chậm sớm.', 'Một nơi để sống thong thả, không phải chờ đến tuổi già.', 'Biển trước nhà, chuỗi bãi tắm, tiện ích đủ đầy.', 'Anh chị đã làm đủ lâu rồi, giờ là lúc biển làm việc của biển.'),
          ('kh-lon-tuoi', 'Người lớn tuổi', 'Về với biển, về với sức khỏe.', 'Không khí trong lành, không gian đi bộ, tinh thần thư thái.', 'Biển, công viên, tiện ích sống xung quanh: bệnh viện, siêu thị, trường học.', 'Sức khỏe tinh thần là tài sản lớn nhất của tuổi này.')]
    alts = {'kh-tre-tu-do': 'Nhóm bạn trẻ nhảy lên vui đùa trên bãi biển lúc hoàng hôn',
            'kh-thanh-dat': 'Gia đình vui chơi trên bãi biển, minh họa khách hàng người thành đạt',
            'kh-nghi-duong-som': 'Cha và con dạo biển, minh họa người nghỉ dưỡng sớm',
            'kh-lon-tuoi': 'Mọi người vui vẻ bên biển, minh họa khách hàng lớn tuổi về với biển'}
    return '<div class="ps">' + ''.join(
        '<article>%s<div><h3>%s</h3><p class="k">%s</p><dl><dt>Họ tìm</dt><dd>%s</dd><dt>Saphia có</dt><dd>%s</dd></dl><q>%s</q></div></article>' % (
            (rimg('gia-dinh-ban-cong', 'Gia đình quây quần trên ban công căn hộ nhìn ra biển lúc hoàng hôn (ảnh minh họa)', '68% 80%') if a[0] == 'kh-thanh-dat' else rimg('ong-ba-ban-cong', 'Hai ông bà uống trà trên ban công nhìn ra biển Mỹ Khê và bán đảo Sơn Trà (ảnh minh họa)', '92% 50%') if a[0] == 'kh-lon-tuoi' else img(a[0], alts[a[0]])), a[1], a[2], a[3], a[4], a[5]) for a in it) + '</div>'

def values4():
    return ('<div class="g4 k2">'
            '<div class="card"><h3 class="oc">Sức khỏe</h3><p>Biển, gió, không gian sống xanh</p></div>'
            '<div class="card"><h3 class="oc">Tinh thần</h3><p>Tự do, thư thái, về với thiên nhiên</p></div>'
            '<div class="card"><h3 class="oc">Tiện nghi</h3><p>Tiện ích đủ đầy: trường học, siêu thị, bệnh viện</p></div>'
            '<div class="card"><h3 class="oc">Đầu tư</h3><p>Cho thuê tốt, thương hiệu Sun Group</p></div></div>')

def related(cur):
    it = [('/vi-sao-sun-group', 'Vì sao căn hộ mặt biển', 'Vì sao Sun Group chọn mặt biển Đà Nẵng'),
          ('/bang-gia', 'Giá Sun Saphia Residence', 'So sánh giá căn hộ mặt biển, vay ngân hàng'),
          ('/mat-bang', 'Mặt bằng & chọn căn', 'Layout tầng 3A–28, Studio, 1BR+, 2BR'),
          ('/phap-ly', 'Pháp lý & tiến độ', 'GCN đầu tư, thời hạn 50 năm, mốc mở bán'),
          ('/cho-thue', 'Cho thuê & dòng tiền', 'Giá thuê, lấp đầy, nhóm khách thuê'),
          ('/tinh-dong-tien', 'Bảng tính dòng tiền', 'Kéo thanh tính tiền về túi theo căn'),
          ('/', 'Tổng quan dự án', 'Vị trí, tầm nhìn, tiện ích, chân dung khách hàng')]
    it = [x for x in it if x[0] != cur][:4]
    return '<div class="rel">' + ''.join('<a href="%s%s">%s<span>%s</span></a>' % (MAIN, p, t, d) for p, t, d in it) + '</div>'

def cta_block(label, title='Có bảng giá là anh/chị <b>nhận ngay</b>', sub='Căn hộ mặt biển có số lượng giới hạn theo mặt bằng. Người trong danh sách quan tâm nhận thông tin sớm để so sánh, chọn căn kỹ trước ngày mở bán.'):
    return ('<section class="sec" id="dang-ky"><div class="wrap"><div class="cta">%s<div class="g2"><div>'
            '<span class="ey" style="color:var(--yl)">Đăng ký nhận thông tin</span><h2 class="dp">%s</h2>'
            '<p style="margin-top:14px">%s</p><ul class="ck" style="color:#fff"><li>Bảng giá gốc &amp; chính sách thanh toán</li><li>Mặt bằng từng tầng, căn còn trống</li><li>Bảng tính dòng tiền theo căn anh/chị chọn</li></ul>'
            '<div class="cta2"><a class="btn zl" href="%s" target="_blank" rel="noopener"><span class="hm">Nhắn </span>Zalo %s</a><a class="btn call" href="tel:%s">Gọi ngay</a></div>'
            '<div class="trust"><div><b>Đại lý chính thức</b><span>Sun Property chứng nhận 23/10/2026</span></div><div><b>0 đồng</b><span>Không thu tiền giữ chỗ</span></div><div><b>Phản hồi nhanh</b><span>Gửi tài liệu qua Zalo trong ít phút</span></div></div>'
            '</div>%s</div></div></div></section>') % (
        tiles('tr'), title, sub, ZALO, TEL_S, TEL, form('cuoi', label, title='Gửi tôi bảng giá', note='Gửi qua Zalo ngay khi chủ đầu tư công bố. Miễn phí, không ràng buộc.', btn='Gửi tôi bảng giá'))

def hero_stats():
    return ('<div class="stats"><div><b>30 tầng</b><span>114 m · 2 hầm</span></div><div><b>782 căn</b><span>Studio · 1BR+ · 2BR</span></div>'
            '<div><b>~400 m</b><span>ra bãi tắm Sơn Thủy</span></div><div><b>50 năm</b><span>thời hạn dự án</span></div></div>')

def hero_perks():
    return hero_stats() + ('<div class="perk"><b>Đăng ký sớm – nhận trước:</b><span>Bảng giá gốc</span><span>Mặt bằng căn trống</span>'
                           '<span>Chính sách &amp; hỗ trợ lãi suất</span><span>Ưu tiên chọn căn đẹp</span></div>')

def cta_band(title, sub, btn, interest, link=None):
    """Dải kêu gọi giữa trang: nút mở popup đăng ký + Zalo + link sang trang liên quan."""
    lk = ('<a class="lk" href="%s%s">%s →</a>' % (MAIN, link[0], link[1])) if link else ''
    return ('<div class="wrap"><div class="band"><div><b class="bt">%s</b><span>%s</span></div>'
            '<div class="bb"><button type="button" class="btn" data-pop data-interest="%s">%s</button>'
            '<a class="btn zl" href="%s" target="_blank" rel="noopener">Zalo %s</a>%s</div></div></div>') % (
        title, sub, esc(interest), btn, ZALO, TEL_S, lk)

def popup():
    return ('<div id="leadPop" class="lp" role="dialog" aria-modal="true" aria-labelledby="lp-t" hidden><div class="lpb">'
            '<button type="button" class="lpx" aria-label="Đóng">×</button>'
            '<img src="%sthap-bien-hoang-hon-900.webp" alt="" width="900" height="503" loading="lazy">'
            '<div class="lpc"><b class="ey">Ưu tiên người đăng ký sớm</b><h2 id="lp-t" class="dp">Nhận <b>bảng giá gốc</b> &amp; mặt bằng căn đẹp</h2>'
            '<ul class="ck"><li>Gửi qua Zalo ngay khi chủ đầu tư công bố</li><li>Ưu tiên chọn căn view biển trước ngày mở bán</li><li>Không thu tiền giữ chỗ</li></ul>'
            '<form class="hm-form" id="popForm" data-form="Popup">'
            '<input name="name" type="text" autocomplete="name" placeholder="Họ và tên" aria-label="Họ và tên">'
            '<input name="phone" type="tel" inputmode="tel" autocomplete="tel" placeholder="Số điện thoại / Zalo" aria-label="Số điện thoại / Zalo" required>'
            '<button class="btn" type="submit">Nhận thông tin ngay</button></form></div></div></div>'
            '<script>(function(){var p=document.getElementById("leadPop");if(!p)return;var f=document.getElementById("popForm"),base=f.getAttribute("data-form"),shown=false;'
            'function op(it){f.setAttribute("data-form",base+(it?" – "+it:""));p.hidden=false;document.body.classList.add("lp-on");shown=true;'
            'setTimeout(function(){var i=f.querySelector("[name=phone]");if(i&&innerWidth>760)i.focus();},80);}'
            'function cl(){p.hidden=true;document.body.classList.remove("lp-on");}'
            'document.addEventListener("click",function(e){var b=e.target.closest&&e.target.closest("[data-pop]");if(b){e.preventDefault();op(b.getAttribute("data-interest")||"");}'
            'else if(e.target===p||e.target.closest(".lpx"))cl();});document.addEventListener("keydown",function(e){if(e.key==="Escape")cl();});'
            'function once(k){try{if(sessionStorage.getItem(k))return false;sessionStorage.setItem(k,1);}catch(x){}return true;}'
            'setTimeout(function(){if(!shown&&!document.querySelector(".hhc-ok")&&once("ssPopT"))op("tự mở sau 45 giây");},45000);'
            'document.addEventListener("mouseout",function(e){if(!e.relatedTarget&&e.clientY<8&&!shown&&innerWidth>900&&once("ssPopE"))op("sắp rời trang");});'
            '})();</script>') % SK
