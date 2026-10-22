# Tạo public/ex_pr.js: kịch bản hình + phụ đề khớp giọng đọc MiniMax (bản PR, ~158 s).
import json, re, os
OFF = 0.3                      # giọng bắt đầu sau 0,3 s
V = lambda t: round((t + OFF) * 30)
DUR = V(158.21) + 60           # giữ hình 2 s sau câu cuối

# ---- phụ đề: (bắt đầu, kết thúc, câu) theo các đoạn nói đã đo ----
CH = [
 (0.00, 1.05, 'Sun Saphia'), (1.32, 3.30, 'Vì sao Sun Group chọn vị trí này?'),
 (3.79, 10.34, 'Gần biển Sơn Thủy, một tòa tháp 30 tầng với quy mô 782 căn hộ đang thu hút sự chú ý của thị trường.'),
 (10.87, 15.71, 'Trên quỹ đất khoảng 3.720 m², dự án Sun Saphia chỉ cách biển khoảng 400 m.'),
 (16.13, 18.28, 'Vậy điều gì khiến vị trí này đáng chú ý?'),
 (18.77, 21.09, 'Thứ nhất: lợi thế từ vị trí lô góc.'),
 (21.49, 23.04, 'Dự án được ghép từ hai thửa đất.'),
 (23.31, 28.13, 'Thửa 6 rộng 2.399 m², thửa 11 rộng 1.320 m².'),
 (28.59, 30.95, 'Hai thửa đất tạo thành một khu đất góc 3 mặt đường,'),
 (31.21, 33.20, 'ngay giao điểm Võ Nguyên Giáp – Nguyễn Đức Thuận.'),
 (33.52, 37.87, 'Đây là lợi thế về khả năng kết nối, nhận diện và tiếp cận các trục giao thông ven biển.'),
 (38.34, 40.35, 'Thứ hai: lợi thế từ không gian biển.'),
 (40.83, 46.01, 'Chưa đầy 400 m là công viên biển rộng 2,45 ha, được quy hoạch làm không gian biển công cộng.'),
 (46.43, 49.58, 'Với khoảng cách gần biển, cư dân có thể dễ dàng tiếp cận không gian đi bộ,'),
 (49.89, 53.37, 'vui chơi và tận hưởng nhịp sống đặc trưng của khu vực Sơn Thủy, Đà Nẵng.'),
 (53.84, 56.19, 'Thứ ba: cơ cấu căn hộ có gì đặc biệt?'),
 (56.69, 58.14, 'Trong cơ cấu sản phẩm được công bố,'),
 (58.43, 64.33, 'dự án có 513 căn studio, 108 căn 1PN+, 149 căn 2 phòng ngủ.'),
 (64.85, 69.80, 'Đáng chú ý, căn studio chiếm tỷ trọng lớn với khoảng 2/3 số căn trong cơ cấu được nêu.'),
 (70.28, 76.70, 'Đây là dòng sản phẩm hướng đến nhu cầu sống gọn gàng, tối ưu công năng và có thể phù hợp với nhóm khách hàng quan tâm đến việc khai thác cho thuê.'),
 (77.10, 79.44, 'Vì sao căn studio đáng quan tâm tại vị trí này?'),
 (79.92, 81.18, 'Hãy nhìn vào khu vực xung quanh.'),
 (81.49, 87.58, 'Dự án nằm gần các khách sạn và điểm đến du lịch như Crowne Plaza, Hyatt, Marriott và danh thắng Ngũ Hành Sơn.'),
 (88.07, 92.69, 'Vị trí này mang đến khả năng tiếp cận nhóm khách du lịch, khách công tác và những người muốn lưu trú gần biển.'),
 (93.17, 97.47, 'Căn hộ diện tích nhỏ thường có tổng giá trị đầu tư thấp hơn căn lớn cùng dự án.'),
 (97.95, 102.95, 'Tuy nhiên, hiệu quả cho thuê thực tế vẫn phụ thuộc vào giá mua, nhu cầu thị trường,'),
 (103.38, 105.33, 'chi phí vận hành và chính sách khai thác.'),
 (105.83, 108.02, 'Vậy Sun Saphia có gì đáng để tìm hiểu?'),
 (108.51, 110.08, 'Theo Hiệp, có 3 yếu tố nổi bật:'),
 (110.55, 115.92, 'vị trí gần biển, khu đất góc có khả năng kết nối tốt và cơ cấu căn hộ nhỏ gọn hướng đến nhu cầu lưu trú,'),
 (116.42, 117.64, 'cùng thương hiệu Sun Group.'),
 (117.93, 122.23, 'Đây là những điểm đáng quan tâm khi đánh giá dự án trong bức tranh bất động sản ven biển Đà Nẵng.'),
 (122.69, 129.42, 'Tuy nhiên, trước khi quyết định đầu tư, anh chị nên tìm hiểu kỹ thêm về pháp lý, thời hạn sở hữu, giá bán và phương án vận hành cho thuê.'),
 (129.89, 132.77, 'Bởi một căn hộ gần biển có thể tạo lợi thế về vị trí,'),
 (133.14, 138.49, 'nhưng để trở thành một khoản đầu tư hiệu quả thì bài toán giá mua và dòng tiền vẫn là yếu tố quan trọng nhất.'),
 (139.00, 144.46, 'Ở phần 2, Hiệp sẽ phân tích cụ thể hơn về giá bán và khả năng cho thuê tại Sun Saphia,'),
 (144.81, 149.43, 'liệu mức đầu tư bao nhiêu là hợp lý và cần khai thác thế nào để tối ưu dòng tiền.'),
 (149.91, 150.64, 'Mình là Hoàng Hiệp.'),
 (151.34, 153.45, 'Anh chị quan tâm đến bất động sản Đà Nẵng,'),
 (153.81, 158.21, 'liên hệ qua số 0904 567 009.'),
]
MAXC = 40
def syl(s): return max(1, len(s.split()))
KEEP = ['Sun Saphia', 'Sun Group', 'đầu tư', 'giá bán', 'giá mua', 'giá trị', 'khả năng', 'dòng tiền', 'có thể', 'đặc trưng', 'quan tâm',
        'Võ Nguyên Giáp', 'Nguyễn Đức Thuận', 'tầng', 'căn hộ', 'cho thuê', 'thu hút', 'nhu cầu', 'công năng', 'khách hàng', 'du lịch', 'Ngũ Hành Sơn',
        'Crowne Plaza', 'thị trường', 'tỷ trọng', 'quy hoạch', 'công cộng', 'công tác', 'lưu trú', 'phòng ngủ', 'm²', 'ha', 'm.', 'm,']
def split(t0, t1, text):
    # chia câu dài thành các dòng gần bằng nhau, ưu tiên ngắt sau dấu phẩy, không tách cụm từ
    import math, itertools
    words = text.split(); n = math.ceil(len(text) / 44)
    if n <= 1: return [(t0, t1, text)]
    best = None
    for cuts in itertools.combinations(range(1, len(words)), n - 1):
        parts = [words[i:j] for i, j in zip((0,) + cuts, cuts + (len(words),))]
        L = [len(' '.join(x)) for x in parts]
        if max(L) > 46: continue
        sc = max(L) - min(L)
        for c in cuts:
            if words[c - 1].endswith((',', ':', '.')): sc -= 10
            pair = words[c - 1] + ' ' + words[c]
            if any((pair in k) or (k in pair and k not in words[c - 1] and k not in words[c]) for k in KEEP) or words[c] in ('m²', 'ha', 'm.', 'm,', 'tầng', 'căn'): sc += 30
            if words[c - 1].isdigit() or re.match(r'^[\d.,/]+$', words[c - 1]): sc += 20
        if best is None or sc < best[0]: best = (sc, parts)
    lines = best[1]
    tot = sum(len(' '.join(l)) for l in lines); out = []; t = t0
    for l in lines:
        d = (t1 - t0) * len(' '.join(l)) / tot; out.append((t, t + d, ' '.join(l))); t += d
    return out
def em(s):
    s = re.sub(r'(\d[\d.,/]*\s?(m²|m|ha|tầng|căn)?)', r'<em>\1</em>', s)
    return s.replace('Sun Saphia', '<em>Sun Saphia</em>').replace('Hoàng Hiệp', '<em>Hoàng Hiệp</em>')
SUBS = []
for a, b, t in CH:
    for x in split(a, b, t): SUBS.append([round(x[0], 2), round(x[1], 2), em(x[2])])

T = lambda size, s: f'<span class="tag" style="font-size:{size}px">{s}</span>'
G = lambda size, s: f'<span class="ghost" style="font-size:{size}px">{s}</span>'
I = []
def add(**k): I.append(k)
# ===== MỞ ĐẦU =====
add(type='txt', html='<div class="kick">Sun Saphia Residence</div><div class="h2" style="margin-top:18px">Vì sao <em>Sun Group</em><br>chọn vị trí này?</div>', y=250, **{'in': 6}, out=V(3.55), anim='pop')
add(type='img', src='ex/p1.jpg', x=60, y=640, w=960, h=674, **{'in': 14}, out=V(3.55), anim='zoom', kb=[1.0, 1.1])
add(type='img', src='ex/p3.jpg', x=90, y=700, w=900, h=620, **{'in': V(3.6)}, out=V(16.0), anim='up', kb=[1.04, 1.18], pos='50% 30%')
add(type='count', to=30, unit='TẦNG', y=160, size=130, **{'in': V(5.5)}, out=V(10.7), anim='pop', dur=24)
add(type='count', to=782, unit='CĂN HỘ', y=360, size=130, **{'in': V(6.9)}, out=V(10.7), anim='pop', dur=32)
add(type='count', to=3720, unit='m² đất', y=240, size=150, **{'in': V(11.7)}, out=V(16.0), anim='pop', dur=40)
add(type='txt', html=T(40, 'Chỉ cách biển khoảng 400 m'), y=1335, **{'in': V(13.9)}, out=V(16.0), anim='pop')
add(type='txt', html='<div class="kick">Câu hỏi đặt ra</div><div class="h2" style="margin-top:18px">Điều gì khiến<br>vị trí này<br><em>đáng chú ý?</em></div>', y=280, **{'in': V(16.1)}, out=V(18.6), anim='pop')
add(type='img', src='ex/p2.jpg', x=90, y=860, w=900, h=520, **{'in': V(16.3)}, out=V(18.6), anim='up', kb=[1.0, 1.08])
# ===== THỨ NHẤT: LÔ GÓC =====
add(type='txt', html='<div class="kick">01 · Thứ nhất</div><div class="h2" style="margin-top:10px">Lợi thế <em>lô góc</em></div>', y=140, **{'in': V(18.77)}, out=V(38.2))
add(type='img', src='ex/tower3d.jpg', x=90, y=330, w=900, h=900, **{'in': V(19.5)}, out=V(23.2), anim='zoom', kb=[1.0, 1.08], pos='50% 15%')
add(type='img', src='ex/thua6.jpg', x=55, y=330, w=470, h=620, rot=-3, anim='left', **{'in': V(23.3)}, out=V(31.1), cap='Thửa 6<small>2.399 m²</small>')
add(type='img', src='ex/thua11.jpg', x=555, y=360, w=470, h=620, rot=3, anim='right', **{'in': V(25.7)}, out=V(31.1), cap='Thửa 11<small>1.320 m²</small>')
add(type='count', to=3720, unit='m²', y=1010, size=140, **{'in': V(28.6)}, out=V(31.1), anim='pop', sub='Khu đất góc <em>3 mặt đường</em>')
add(type='img', src='ex/map_870.jpg', x=60, y=320, w=960, h=980, **{'in': V(31.2)}, out=V(38.2), anim='zoom', kb=[1.0, 1.06], cap='Giao điểm Võ Nguyên Giáp – Nguyễn Đức Thuận<small>3 mặt đường · hướng biển</small>')
add(type='txt', html=T(38, 'Kết nối') + ' &nbsp;' + T(38, 'Nhận diện') + ' &nbsp;' + T(38, 'Tiếp cận'), y=1325, **{'in': V(34.6)}, out=V(38.2), anim='pop')
# ===== THỨ HAI: KHÔNG GIAN BIỂN =====
add(type='txt', html='<div class="kick">02 · Thứ hai</div><div class="h2" style="margin-top:10px">Lợi thế <em>không gian biển</em></div>', y=140, **{'in': V(38.34)}, out=V(53.7))
add(type='img', src='ex/map_870.jpg', x=60, y=330, w=960, h=1000, **{'in': V(40.5)}, out=V(46.3), anim='up', pos='50% 40%', cap='Công viên biển 2,45 ha<small>Quy hoạch không gian biển công cộng</small>')
add(type='hl', box=True, x=750, y=600, w=200, h=230, **{'in': V(42.6)}, out=V(46.3), anim='pop')
add(type='img', src='ex/p2.jpg', x=60, y=330, w=960, h=760, **{'in': V(46.4)}, out=V(53.7), anim='zoom', kb=[1.0, 1.12])
add(type='txt', html=T(40, 'Đi bộ'), x=90, w=300, y=1140, **{'in': V(48.2)}, out=V(53.7), anim='pop')
add(type='txt', html=T(40, 'Vui chơi'), x=390, w=300, y=1140, **{'in': V(49.9)}, out=V(53.7), anim='pop')
add(type='txt', html=T(40, 'Tận hưởng'), x=690, w=300, y=1140, **{'in': V(50.9)}, out=V(53.7), anim='pop')
# ===== THỨ BA: CƠ CẤU =====
add(type='txt', html='<div class="kick">03 · Thứ ba</div><div class="h2" style="margin-top:10px">Cơ cấu căn hộ<br><em>có gì đặc biệt?</em></div>', y=130, **{'in': V(53.84)}, out=V(77.0))
add(type='img', src='ex/slide.jpg', x=40, y=430, w=1000, h=585, rot=-2, anim='drop', **{'in': V(54.9)}, out=V(58.4), r=16)
add(type='hl', x=405, y=740, w=430, h=96, **{'in': V(56.8)}, out=V(58.4), dur=22)
add(type='bars', x=219, y=380, h=680, **{'in': V(58.4)}, out=V(77.0), delays=[0, 61, 118], items=[
  dict(label='Studio', sub='30–31 m²', value=513, color='#FF7A1A', color2='#E0560A'),
  dict(label='1PN+1', sub='50–51 m²', value=108, color='#FFB547', color2='#E0962A'),
  dict(label='2PN', sub='60–70 m²', value=149, color='#7FB2FF', color2='#3E78C8')])
add(type='progress', pct=66, x=120, y=1110, w=840, **{'in': V(65.6)}, out=V(70.2), label='Studio chiếm khoảng <em>2/3</em> số căn')
add(type='txt', html=T(38, 'Sống gọn gàng') + ' &nbsp;' + T(38, 'Tối ưu công năng'), y=1110, **{'in': V(71.6)}, out=V(77.0), anim='pop')
add(type='txt', html=G(36, 'Phù hợp khai thác cho thuê'), y=1220, **{'in': V(74.6)}, out=V(77.0), anim='pop')
# ===== VÌ SAO STUDIO =====
add(type='txt', html='<div class="kick">Vì sao là studio?</div><div class="h2" style="margin-top:10px">Nhìn vào<br><em>khu vực xung quanh</em></div>', y=130, **{'in': V(77.1)}, out=V(87.9))
add(type='img', src='ex/map_1250.jpg', x=60, y=400, w=960, h=520, **{'in': V(79.9)}, out=V(87.9), anim='up', pos='50% 35%')
add(type='chips', x=170, y=950, w=800, **{'in': V(82.2)}, out=V(87.9), stagger=39, items=[
  dict(icon='hotel', name='Crowne Plaza', dist='~700 m'), dict(icon='hotel', name='Hyatt Regency', dist='~1,1 km'),
  dict(icon='hotel', name='Danang Marriott', dist='~1,8 km'), dict(icon='mountain', name='Ngũ Hành Sơn', dist='~2,1 km')])
add(type='txt', html='<div class="kick">Khách thuê tiềm năng</div><div class="h2" style="margin-top:10px">Ai sẽ <em>lưu trú</em> ở đây?</div>', y=200, **{'in': V(88.07)}, out=V(97.9))
add(type='flow', y=560, **{'in': V(88.2)}, out=V(97.9), gap=60, stagger=66, nodes=[
  dict(icon='user', text='Khách<br>du lịch'), dict(icon='brief', text='Khách<br>công tác'), dict(icon='bed', text='Lưu trú<br>gần biển')])
add(type='txt', html='<div class="p">Căn diện tích nhỏ<br>→ <em>tổng giá trị đầu tư thấp hơn</em></div>', y=1000, **{'in': V(93.3)}, out=V(97.9))
add(type='txt', html='<div class="kick">Tuy nhiên</div><div class="h2" style="margin-top:10px">Hiệu quả cho thuê<br><em>phụ thuộc vào</em></div>', y=180, **{'in': V(97.95)}, out=V(105.6))
add(type='chips', x=210, y=560, w=700, **{'in': V(99.9)}, out=V(105.6), delays=[0, 62, 108, 140], items=[
  dict(icon='money', name='Giá mua', dist=''), dict(icon='chart', name='Nhu cầu thị trường', dist=''),
  dict(icon='gear', name='Chi phí vận hành', dist=''), dict(icon='doc', name='Chính sách khai thác', dist='')])
# ===== 3 YẾU TỐ =====
add(type='txt', html='<div class="kick">Sun Saphia có gì?</div><div class="h2" style="margin-top:10px"><em>3 yếu tố</em> nổi bật</div>', y=140, **{'in': V(105.83)}, out=V(122.5))
add(type='check', x=70, y=400, w=940, **{'in': V(110.4)}, out=V(122.5), delays=[0, 40, 105], items=[
  dict(n='1', title='Vị trí gần biển', sub='Cách biển khoảng <b>400 m</b>'),
  dict(n='2', title='Khu đất góc', sub='Khả năng <b>kết nối tốt</b>'),
  dict(n='3', title='Căn hộ nhỏ gọn', sub='Hướng đến <b>nhu cầu lưu trú</b>')])
add(type='txt', html=T(46, '+ Thương hiệu Sun Group'), y=1000, **{'in': V(116.5)}, out=V(122.5), anim='pop')
add(type='txt', html='<div class="p">Điểm đáng quan tâm của<br>BĐS <em>ven biển Đà Nẵng</em></div>', y=1140, **{'in': V(118.2)}, out=V(122.5))
# ===== TRƯỚC KHI ĐẦU TƯ =====
add(type='txt', html='<div class="kick">Trước khi quyết định đầu tư</div><div class="h2" style="margin-top:10px">Nên <em>tìm hiểu kỹ</em></div>', y=140, **{'in': V(122.69)}, out=V(129.8))
add(type='check', x=150, y=420, w=800, **{'in': V(126.1)}, out=V(129.8), delays=[0, 12, 39, 51], items=[
  dict(n='✓', title='Pháp lý', sub=''), dict(n='✓', title='Thời hạn sở hữu', sub=''),
  dict(n='✓', title='Giá bán', sub=''), dict(n='✓', title='Phương án vận hành cho thuê', sub='')])
add(type='txt', html='<div class="kick">Điều quan trọng nhất</div><div class="h2" style="margin-top:10px">Vị trí là lợi thế,<br>nhưng…</div>', y=140, **{'in': V(129.89)}, out=V(138.9))
add(type='scale', y=440, **{'in': V(130.1)}, out=V(138.9), left='Giá mua', leftSub='& dòng tiền', right='Vị trí', rightSub='lợi thế', tilt=-9, tiltDelay=round((133.9 - 130.1) * 30), anim='pop')
add(type='txt', html='<div class="h3">Bài toán <em>giá mua &amp; dòng tiền</em><br>vẫn là <em>quan trọng nhất</em></div>', y=1020, **{'in': V(135.6)}, out=V(138.9), anim='pop')
# ===== KẾT =====
add(type='txt', html='<div class="kick">Phần 2</div><div class="h2" style="margin-top:10px">Giá bán &amp;<br><em>khả năng cho thuê</em></div>', y=130, **{'in': V(139.0)}, out=V(149.8))
add(type='img', src='ex/p1.jpg', x=60, y=470, w=960, h=640, **{'in': V(139.3)}, out=V(149.8), anim='zoom', kb=[1.0, 1.1])
add(type='txt', html=G(38, 'Mức đầu tư bao nhiêu là hợp lý?'), y=1170, **{'in': V(144.9)}, out=V(149.8), anim='pop')
add(type='txt', html=T(38, 'Tối ưu dòng tiền'), y=1270, **{'in': V(147.6)}, out=V(149.8), anim='pop')
add(type='txt', html='<div class="kick">Tư vấn bất động sản Đà Nẵng</div><div class="h1" style="margin-top:14px">HOÀNG <em>HIỆP</em></div>', y=300, **{'in': V(149.9)}, out=None, anim='pop')
add(type='img', src='ex/p3.jpg', x=190, y=600, w=700, h=470, **{'in': V(150.6)}, out=None, anim='zoom', kb=[1.0, 1.08], pos='50% 30%')
add(type='txt', html=T(70, '0904 567 009'), y=1160, **{'in': V(153.8)}, out=None, anim='pop')

ICONS = {
 'hotel': '<path d="M3 21V5h2v9h7V8h6a3 3 0 0 1 3 3v10h-2v-3H5v3H3zm5-8a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5z" fill="#fff"/>',
 'mountain': '<path d="M2 20l7-12 4 6 3-4 6 10H2z" fill="#fff"/>',
 'user': '<path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10zm-8 10a8 8 0 0 1 16 0H4z" fill="#fff"/>',
 'brief': '<path d="M9 4h6a2 2 0 0 1 2 2v1h4v12H3V7h4V6a2 2 0 0 1 2-2zm0 3h6V6H9v1z" fill="#fff"/>',
 'bed': '<path d="M3 18V6h2v7h6V8h7a3 3 0 0 1 3 3v7h-2v-2H5v2H3zm4-6a2 2 0 1 1 0-4 2 2 0 0 1 0 4z" fill="#fff"/>',
 'money': '<path d="M2 6h20v12H2zm10 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" fill="#fff"/>',
 'chart': '<path d="M3 21V3h2v16h16v2H3zm4-4v-6h3v6H7zm5 0V7h3v10h-3zm5 0v-4h3v4h-3z" fill="#fff"/>',
 'gear': '<path d="M12 8a4 4 0 1 0 0 8 4 4 0 0 0 0-8zm9 5.5v-3l-2.4-.6a7 7 0 0 0-.7-1.6l1.3-2.1-2.1-2.1-2.1 1.3a7 7 0 0 0-1.6-.7L13 2.5h-3l-.6 2.4a7 7 0 0 0-1.6.7L5.7 4.3 3.6 6.4l1.3 2.1a7 7 0 0 0-.7 1.6L2 10.5v3l2.4.6c.2.6.4 1.1.7 1.6l-1.3 2.1 2.1 2.1 2.1-1.3c.5.3 1 .5 1.6.7l.6 2.4h3l.6-2.4c.6-.2 1.1-.4 1.6-.7l2.1 1.3 2.1-2.1-1.3-2.1c.3-.5.5-1 .7-1.6l2.4-.6z" fill="#fff"/>',
 'doc': '<path d="M6 2h9l5 5v15H6V2zm8 1.5V8h4.5L14 3.5zM9 12h8v1.5H9V12zm0 3.5h8V17H9v-1.5z" fill="#fff"/>',
}
def js(v):
    if isinstance(v, dict): return '{ ' + ', '.join(f"{('in' if k == 'in' else k)}: {js(x)}" for k, x in v.items()) + ' }'
    if isinstance(v, list): return '[' + ', '.join(js(x) for x in v) + ']'
    if v is None: return 'null'
    if v is True: return 'true'
    if isinstance(v, str): return "'" + v.replace('\\', '\\\\').replace("'", "\\'") + "'"
    return str(v)
def item(d):  # type đứng đầu, in ngay sau để script âm thanh đọc được
    keys = ['type'] + [k for k in d if k != 'type']
    keys.remove('in'); keys.insert(1, 'in')
    return '    { ' + ', '.join(f"{k}: {js(d[k])}" for k in keys) + ' },'
out = ['// Video giải mã Sun Saphia – bản PR, khớp giọng đọc MiniMax (tạo bởi scripts/gen_pr.py, đừng sửa tay)',
       'window.EX = {', f'  duration: {DUR},', f'  voiceOffset: {OFF},', '  icons: ' + json.dumps(ICONS, ensure_ascii=False) + ',', '  items: [']
out += [item(d) for d in I]
out += ['  ],', '  subs: ' + json.dumps(SUBS, ensure_ascii=False) + ',', '};']
open(os.path.join(os.path.dirname(__file__), '..', 'public', 'ex_pr.js'), 'w').write('\n'.join(out) + '\n')
cuts = sorted(set(V(t) for t in [3.6, 16.1, 18.77, 38.34, 53.84, 77.1, 88.07, 97.95, 105.83, 122.69, 129.89, 139.0, 149.9]))
print('DUR', DUR, DUR / 30, 'subs', len(SUBS), 'max', max(len(re.sub('<[^>]+>', '', s[2])) for s in SUBS))
print('CUTS', json.dumps(cuts))
