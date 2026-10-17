/* Hải Minh – khối tương tác chèn vào trang LadiPage (dán loader trong "Trước </body>"):
   trắc nghiệm 3 câu "Căn nào hợp với anh/chị?" + máy tính dòng tiền minh họa + 5 dòng căn.
   Gửi khách về CRM/Telegram qua window.crmLead (mã CRM đã có trên trang). */
(function () {
  if (window.__hmx) return; window.__hmx = 1;
  var ZALO = 'https://zalo.me/0904567009';

  var css = '#hmx{position:relative;z-index:5;isolation:isolate;display:block;visibility:visible;opacity:1;background:#f4f6fa;padding:34px 0 30px;font-family:inherit;color:#13233d;clear:both}'
    + '#hmx *{box-sizing:border-box}#hmx button,#hmx input{font-family:inherit}#hmx .hx-w{max-width:1140px;margin:0 auto;padding:0 16px}'
    + '#hmx .hx-k{color:#e8571c;font-size:12px;letter-spacing:.14em;font-weight:700;text-transform:uppercase}'
    + '#hmx h2{font-size:24px;line-height:1.25;margin:6px 0 8px;font-weight:800;color:#0f1d33}'
    + '#hmx p{margin:0 0 10px;line-height:1.55;font-size:15px}'
    + '#hmx .hx-g{display:grid;grid-template-columns:1fr 1fr;gap:18px;margin-top:16px}'
    + '#hmx .hx-c{background:#fff;border-radius:14px;padding:20px;box-shadow:0 2px 14px rgba(15,29,51,.08)}'
    + '#hmx h3{font-size:19px;margin:0 0 12px;color:#0f1d33;font-weight:800}'
    + '#hmx .hx-q{margin:0 0 14px}#hmx .hx-q b{display:block;font-size:15px;margin-bottom:8px}'
    + '#hmx .hx-o{display:inline-block;margin:0 6px 8px 0;padding:9px 14px;border:1.5px solid #c9d3e2;border-radius:22px;background:#fff;color:#13233d;font-size:14px;cursor:pointer}'
    + '#hmx .hx-o[aria-pressed="true"]{background:#0f1d33;border-color:#0f1d33;color:#fff}'
    + '#hmx .hx-r{background:#fff4ee;border:1.5px solid #ffc9ad;border-radius:12px;padding:14px;margin:6px 0 12px;font-size:15px;line-height:1.5}'
    + '#hmx .hx-btn{display:block;width:100%;padding:14px 16px;border:0;border-radius:26px;background:#ff6a2b;color:#fff;font-weight:800;font-size:16px;cursor:pointer;text-align:center;text-decoration:none}'
    + '#hmx .hx-btn.hx-z{background:#0068ff;margin-top:8px}#hmx .hx-btn[disabled]{opacity:.45;cursor:default}'
    + '#hmx .hx-sl{margin:0 0 14px}#hmx .hx-sl label{display:flex;justify-content:space-between;font-size:14px;margin-bottom:6px}#hmx .hx-sl output{font-weight:800;color:#0f1d33}'
    + '#hmx input[type=range]{width:100%;accent-color:#ff6a2b}'
    + '#hmx .hx-big{font-size:28px;font-weight:800;color:#e8571c;line-height:1.2}#hmx .hx-sm{font-size:12.5px;color:#5b6a80;line-height:1.5}'
    + '#hmx .hx-f{display:none;margin-top:10px}#hmx .hx-f.hx-on{display:block}'
    + '#hmx .hx-f input{width:100%;padding:12px 14px;border:1.5px solid #c9d3e2;border-radius:10px;font-size:16px;margin-bottom:8px;font-family:inherit}'
    + '#hmx .hx-ok{display:none;background:#e9f7ee;border-radius:10px;padding:12px;font-size:15px;margin-top:8px}'
    + '#hmx .hx-u{display:grid;grid-template-columns:repeat(5,1fr);gap:12px;margin-top:16px}'
    + '#hmx .hx-u div{background:#fff;border-radius:12px;padding:14px;box-shadow:0 2px 10px rgba(15,29,51,.07);font-size:14px;line-height:1.45}'
    + '#hmx .hx-u b{display:block;font-size:17px;color:#0f1d33}#hmx .hx-u i{font-style:normal;color:#e8571c;font-weight:700}'
    + '#hmx .hx-an{display:grid;gap:10px;margin:14px 0}#hmx .hx-ai{display:flex;gap:14px;background:#fff;border-radius:12px;padding:14px 16px;box-shadow:0 2px 10px rgba(15,29,51,.07)}'
    + '#hmx .hx-ai i{flex:0 0 34px;height:34px;border-radius:50%;background:#ff6a2b;color:#fff;font-style:normal;font-weight:800;display:flex;align-items:center;justify-content:center}'
    + '#hmx .hx-ai b{display:block;font-size:16px;color:#0f1d33;margin-bottom:3px}#hmx .hx-ai span{font-size:14.5px;line-height:1.55}'
    + '#hmx .hx-chk{background:#eef3fa;border-left:4px solid #0f1d33;border-radius:10px;padding:12px 16px;margin:4px 0 14px}#hmx .hx-chk b{display:block;margin-bottom:4px}#hmx .hx-chk span{display:block;font-size:13.5px;line-height:1.55;color:#33435a}'
    + '#hmx .hx-cta{max-width:520px}'
    + '#hmx .hx-at{flex:1 1 0;min-width:0}#hmx .hx-av{flex:0 0 300px}#hmx .hx-fig{margin:0}#hmx .hx-fig img{display:block;width:100%;height:170px;object-fit:cover;border-radius:10px}#hmx .hx-fig figcaption{font-size:11.5px;color:#6b7a90;margin-top:4px}'
    + '#hmx .hx-bars{background:#f4f6fa;border-radius:10px;padding:12px}#hmx .hx-br{display:grid;grid-template-columns:92px 1fr auto;gap:8px;align-items:center;margin:5px 0;font-size:13px}#hmx .hx-br div{height:12px;background:#e1e7f0;border-radius:6px;overflow:hidden}#hmx .hx-br i{display:block;height:100%;background:linear-gradient(90deg,#ff8a4c,#ff6a2b);border-radius:6px}#hmx .hx-br em{font-style:normal;font-weight:700;color:#0f1d33;font-size:12.5px}#hmx .hx-bars small{display:block;font-size:11.5px;color:#6b7a90;margin-top:4px}'
    + '@media(max-width:760px){#hmx .hx-ai{flex-wrap:wrap}#hmx .hx-av{flex:1 1 100%}#hmx .hx-fig img{height:190px}}'

    + '@media(max-width:860px){#hmx .hx-g{grid-template-columns:1fr}#hmx .hx-u{grid-template-columns:1fr 1fr}#hmx h2{font-size:21px}}';

  var Q = [
    { id: 'muc', t: 'Anh/chị mua để:', o: ['Nghỉ dưỡng gia đình', 'Cho thuê', 'Cả hai'] },
    { id: 'ns', t: 'Ngân sách dự kiến:', o: ['Dưới 3 tỷ', '3–5 tỷ', 'Trên 5 tỷ'] },
    { id: 'thich', t: 'Anh/chị thích:', o: ['View bình minh trên biển', 'Tầng cao', 'Căn lớn cho cả nhà'] }
  ];

  function esc(s) { return String(s).replace(/[&<>"]/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]; }); }
  function form(id, label) {
    return '<div class="hx-f" id="' + id + '"><input type="text" name="ten" placeholder="Họ tên" autocomplete="name">'
      + '<input type="tel" name="sdt" placeholder="Số điện thoại / Zalo" autocomplete="tel" inputmode="tel">'
      + '<button type="button" class="hx-btn" data-send>' + label + '</button>'
      + '<div class="hx-sm" style="margin-top:6px">Chuyên viên Hoàng Hiệp nhắn Zalo cho anh/chị. Không thu tiền giữ chỗ, đặt cọc.</div>'
      + '<div class="hx-ok">Cảm ơn anh/chị! Chuyên viên Hoàng Hiệp sẽ nhắn Zalo sớm. Cần gấp: <a href="tel:0904567009">0904 567 009</a></div></div>';
  }

  /* ---- Phân tích: vì sao nên tìm hiểu sớm ---- */
  var AN = [
    ['1', 'Quỹ đất mặt biển nội đô có hạn', 'Dải ven biển Võ Nguyên Giáp – Trường Sa đã kín resort, khách sạn; dự án căn hộ mới ngay mặt biển ngày càng ít. Phía trước Hải Minh là công viên biển theo quy hoạch, tầm nhìn ra biển thoáng. Võ Nguyên Giáp – Trường Sa thuộc nhóm tuyến đường có giá đất cao trong bảng giá đất do UBND TP Đà Nẵng ban hành – giá trị vị trí rõ ràng (diễn biến giá trong quá khứ không bảo đảm cho tương lai).'],
    ['2', 'Nhu cầu lưu trú tăng đều', '11 tháng 2025 Đà Nẵng đón 16,5 triệu lượt khách lưu trú (+18,9%), khách quốc tế tăng 26,5%. Khu thương mại tự do và Trung tâm tài chính quốc tế mở thêm dòng khách công tác, chuyên gia ở dài ngày.'],
    ['3', 'Một căn, hai giá trị', 'Gia đình nghỉ dưỡng mỗi năm ngay mặt biển; những ngày không ở có thể cho thuê. Ví dụ minh họa: 1,5 triệu/đêm × 60% công suất × 350 đêm ≈ 315 triệu doanh thu phòng/năm, chưa trừ chi phí – không phải cam kết.'],
    ['4', 'Đi sớm, chọn được căn đẹp', 'Căn nhìn thẳng biển, tầng cao, hướng đón bình minh có số lượng giới hạn theo mặt bằng. Người trong danh sách ưu tiên nhận bảng giá, mặt bằng trước ngày ra mắt (dự kiến 11/2026) để so sánh, chọn căn kỹ.'],
    ['5', 'Kết nối trong 30 phút', 'Sân bay 10–15 phút, phố An Thượng và Ngũ Hành Sơn 5–10 phút, cầu Rồng khoảng 15 phút, phố cổ Hội An khoảng 30 phút – tiện cho cả gia đình lẫn khách thuê.']
  ];
  var IMG = 'https://raw.githubusercontent.com/hiephoangmt-debug/hoang-hiep-crm/4a26b749ab512b23f43f25a3fc4cac507e5850ca/projects/hai-minh-da-nang/landing/';
  function pic(src, alt, cap) { return '<figure class="hx-fig"><img src="' + IMG + src + '" alt="' + alt + '" loading="lazy" width="600" height="400"><figcaption>' + cap + '</figcaption></figure>'; }
  function bars(rows, unit) { var mx = Math.max.apply(null, rows.map(function (r) { return r[1]; }));
    return '<div class="hx-bars">' + rows.map(function (r) { return '<div class="hx-br"><span>' + r[0] + '</span><div><i style="width:' + Math.round(r[1] / mx * 100) + '%"></i></div><em>' + r[2] + '</em></div>'; }).join('') + (unit ? '<small>' + unit + '</small>' : '') + '</div>'; }
  var VIS = [
    pic('images/so-do-vi-tri-hai-minh-rong-v4.webp', 'Sơ đồ vị trí Hải Minh, phía trước là công viên biển Trường Sa', 'Sơ đồ vị trí – không theo tỷ lệ'),
    bars([['Khách lưu trú', 16.5, '16,5 tr lượt · +18,9%'], ['Khách quốc tế', 7, '~7 tr lượt · +26,5%']], '11 tháng 2025 – Cục Thống kê TP Đà Nẵng'),
    pic('illus/phong-ngu-view-bien.webp', 'Tranh minh họa bữa sáng bên cửa kính nhìn ra biển', 'Tranh minh họa, không phải ảnh căn hộ thật'),
    pic('illus/binh-minh-phong-khach.webp', 'Tranh minh họa phòng khách đón bình minh trên biển', 'Tranh minh họa, không phải ảnh căn hộ thật'),
    bars([['An Thượng', 8, '5–10 phút'], ['Ngũ Hành Sơn', 8, '5–10 phút'], ['Sân bay', 13, '10–15 phút'], ['Cầu Rồng', 15, '~15 phút'], ['Hội An', 30, '~30 phút'], ['Mikazuki', 35, '~35 phút'], ['Bà Nà Hills', 45, '~45 phút'], ['Huế', 120, '~2 giờ']], 'Ước tính bằng ô tô, tùy giờ cao điểm')
  ];
  function anHtml() {
    return '<div class="hx-k">Phân tích trước khi xuống tiền</div>'
      + '<h2>Vì sao căn mặt biển Hải Minh đáng cân nhắc ngay từ bây giờ?</h2>'
      + '<div class="hx-an">' + AN.map(function (a, k) { return '<div class="hx-ai"><i>' + a[0] + '</i><div class="hx-at"><b>' + a[1] + '</b><span>' + a[2] + '</span></div><div class="hx-av">' + VIS[k] + '</div></div>'; }).join('') + '</div>'
      + '<div class="hx-chk"><b>Minh bạch – những điều anh/chị nên xem kỹ</b>'
      + '<span>• Đất thương mại dịch vụ, thời hạn 50 năm (17/9/2026 – 16/9/2076); loại hình căn hộ du lịch, không phải chung cư ở lâu dài.</span>'
      + '<span>• Giá, chính sách thanh toán, đơn vị vận hành, tỷ lệ chia doanh thu: chủ đầu tư công bố khi ra mắt – đọc kỹ hợp đồng mẫu trước khi quyết định.</span>'
      + '<span>• Hiện không thu tiền giữ chỗ, đặt cọc; đăng ký chỉ để nhận thông tin sớm.</span></div>'
      + '<div class="hx-cta"><button type="button" class="hx-btn" id="hmx-ago">Gửi tôi bảng giá trước ngày ra mắt</button>' + form('hmx-af', 'Gửi tôi bảng giá trước ngày ra mắt') + '</div>';
  }
  function html() {
    var q = Q.map(function (x) {
      return '<div class="hx-q" data-q="' + x.id + '"><b>' + x.t + '</b>' + x.o.map(function (o) {
        return '<button type="button" class="hx-o" aria-pressed="false">' + o + '</button>'; }).join('') + '</div>';
    }).join('');
    return '<div class="hx-w">' + anHtml() + '<div class="hx-k" style="margin-top:34px">Danh sách ưu tiên trước ngày ra mắt · dự kiến 11/2026</div>'
      + '<h2>5 dòng căn, dòng nào hợp với anh/chị?</h2>'
      + '<p>Trả lời 3 câu để xem gợi ý dòng căn, hoặc tự kéo thử dòng tiền cho thuê. Bảng giá và mặt bằng gửi qua Zalo ngay khi chủ đầu tư công bố.</p>'
      + '<div class="hx-g"><div class="hx-c" id="hmx-quiz"><h3>Căn nào hợp với anh/chị?</h3>' + q
      + '<div class="hx-r" id="hmx-res" hidden></div>'
      + '<button type="button" class="hx-btn" id="hmx-qgo" disabled>Gửi tôi danh sách căn phù hợp</button>' + form('hmx-qf', 'Gửi tôi danh sách căn phù hợp') + '</div>'
      + '<div class="hx-c" id="hmx-calc"><h3>Tính dòng tiền cho thuê (minh họa)</h3>'
      + '<div class="hx-sl"><label>Giá thuê mỗi đêm <output id="hmx-o1"></output></label><input type="range" id="hmx-s1" min="800000" max="4000000" step="50000" value="1500000"></div>'
      + '<div class="hx-sl"><label>Công suất phòng <output id="hmx-o2"></output></label><input type="range" id="hmx-s2" min="30" max="90" step="1" value="60"></div>'
      + '<div class="hx-sl"><label>Số đêm gia đình tự ở mỗi năm <output id="hmx-o3"></output></label><input type="range" id="hmx-s3" min="0" max="60" step="1" value="15"></div>'
      + '<div class="hx-sm">Doanh thu phòng minh họa mỗi năm</div><div class="hx-big" id="hmx-y"></div><div id="hmx-m" style="font-size:15px;margin:2px 0 8px"></div>'
      + '<div class="hx-sm" style="margin-bottom:12px">Chỉ là ví dụ minh họa, không phải cam kết. Chưa trừ phí vận hành, thuế và tỷ lệ chia doanh thu (chủ đầu tư chưa công bố). Giá phòng ven biển trục Võ Nguyên Giáp phổ biến khoảng 1–3 triệu/đêm (giá công khai trên nền tảng đặt phòng).</div>'
      + '<button type="button" class="hx-btn" id="hmx-cgo">Nhận bảng tính chi tiết theo căn thật qua Zalo</button>' + form('hmx-cf', 'Gửi tôi bảng tính chi tiết')
      + '<a class="hx-btn hx-z" href="' + ZALO + '" target="_blank" rel="noopener">Nhắn Zalo 0904 567 009</a></div></div>'
      + '<div class="hx-u">'
      + '<div><b>1PN</b>47,4 m²<br><i>Giá: gửi qua Zalo</i></div>'
      + '<div><b>2PN</b>66,5–68,8 m²<br><i>Giá: gửi qua Zalo</i></div>'
      + '<div><b>2PN+1</b>76,2–76,9 m²<br><i>Giá: gửi qua Zalo</i></div>'
      + '<div><b>3PN</b>78,6–80 m²<br><i>Giá: gửi qua Zalo</i></div>'
      + '<div><b>Dual Key</b>101 m², 2 phần cửa riêng<br><i>Giá: gửi qua Zalo</i></div></div>'
      + '<p class="hx-sm" style="margin-top:10px">Diện tích theo thông tin dự án hiện có; giá, mặt bằng chi tiết và chính sách do chủ đầu tư công bố khi ra mắt.</p></div>';
  }

  function vnd(n) { return n >= 1e9 ? (n / 1e9).toFixed(2).replace('.', ',') + ' tỷ' : Math.round(n / 1e6).toLocaleString('vi-VN') + ' triệu'; }

  function suggest(a) {
    var t, why;
    if (a.thich === 'Căn lớn cho cả nhà') { t = a.muc === 'Nghỉ dưỡng gia đình' ? '3PN (78,6–80 m²)' : 'Dual Key (101 m², 2 phần cửa riêng)'; why = a.muc === 'Nghỉ dưỡng gia đình' ? 'đủ chỗ cho cả nhà' : 'cả nhà ở một phần, phần còn lại có thể cho thuê'; }
    else if (a.muc === 'Cho thuê') { t = '1PN (47,4 m²) hoặc 2PN (66,5–68,8 m²)'; why = 'diện tích gọn, hợp khách du lịch thuê ngắn ngày'; }
    else if (a.muc === 'Cả hai') { t = 'Dual Key (101 m²) hoặc 2PN+1 (76,2–76,9 m²)'; why = 'vừa có chỗ cho gia đình, vừa linh hoạt cho thuê'; }
    else { t = '2PN+1 (76,2–76,9 m²)'; why = 'thêm phòng linh hoạt cho gia đình nghỉ dưỡng'; }
    var pos = a.thich === 'View bình minh trên biển' ? ', ưu tiên căn mặt Đông nhìn về biển (đón bình minh)' : a.thich === 'Tầng cao' ? ', ưu tiên tầng cao' : '';
    return { text: 'Dòng căn gợi ý: <b>' + t + '</b>' + pos + ' – ' + why + '.<br><span class="hx-sm">Ngân sách ' + esc(a.ns.toLowerCase()) + ' sẽ được đối chiếu ngay khi có bảng giá. Gợi ý theo câu trả lời, chưa phải chọn căn cụ thể.</span>', plain: t + pos };
  }

  function phoneOk(p) { p = String(p || '').replace(/[^\d+]/g, '').replace(/^\+?84/, '0'); return /^0\d{9}$/.test(p) ? p : ''; }

  function wireForm(box, msgFn, tag) {
    var btn = box.querySelector('[data-send]');
    btn.onclick = function () {
      var ten = box.querySelector('[name=ten]').value.trim(), sdt = phoneOk(box.querySelector('[name=sdt]').value);
      if (!sdt) { box.querySelector('[name=sdt]').focus(); box.querySelector('[name=sdt]').style.borderColor = '#e8571c'; return; }
      var d = { name: ten || 'Khách web', phone: sdt, message: msgFn(), source: tag };
      try { if (window.crmLead) window.crmLead(d); } catch (e) {}
      try { if (window.gtag) window.gtag('event', 'generate_lead', { method: tag }); } catch (e) {}
      btn.disabled = true; box.querySelector('.hx-ok').style.display = 'block';
    };
  }


  /* ---- Vì sao Đà Nẵng (chèn trước khối trắc nghiệm) ---- */
  var DN = [
    ['🏙️', 'Trung tâm của miền Trung', 'Sau khi hợp nhất với Quảng Nam (7/2025), Đà Nẵng có cả biển, sông, núi và di sản: phố cổ Hội An, Mỹ Sơn, Cù Lao Chàm nay cùng một thành phố.'],
    ['✈️', 'Sân bay ngay trong nội thành', 'Xuống máy bay chỉ khoảng 10–15 phút ô tô là tới Hải Minh, ra biển Mỹ Khê. Thành phố có thêm sân bay Chu Lai ở phía Nam.'],
    ['🌏', 'Bay thẳng tới nhiều nước', 'Đường bay quốc tế trực tiếp tới Hàn Quốc, Nhật Bản, Trung Quốc, Đài Loan, Singapore, Thái Lan, Ấn Độ… và các thành phố lớn trong nước; mạng bay tiếp tục được mở rộng.'],
    ['🚆', 'Giao thông đồng bộ', 'Ga đường sắt Bắc – Nam, cảng Tiên Sa đón tàu du lịch quốc tế, cao tốc kết nối. Đường sắt tốc độ cao Bắc – Nam và đường sắt đô thị đang theo quy hoạch, tiến độ theo Nhà nước.'],
    ['🤝', 'Bình yên, thân thiện', 'Thành phố sạch, trật tự, người dân hiền hòa, mến khách – điều du khách trong và ngoài nước thường nhắc tới khi quay lại Đà Nẵng.'],
    ['🏖️', 'Biển cát mịn, bờ thoải', 'Mỹ Khê – Non Nước có bãi cát trắng mịn, bờ thoải, mùa hè sóng êm; phía sau là sông Hàn, bán đảo Sơn Trà và Ngũ Hành Sơn.'],
    ['🗺️', 'Đi chơi không hết', 'Bà Nà Hills, công viên nước & onsen Mikazuki, Suối Lương – đèo Hải Vân, bán đảo Sơn Trà, Ngũ Hành Sơn, phố cổ Hội An, Mỹ Sơn, Cù Lao Chàm, lễ hội pháo hoa quốc tế; đi tiếp cố đô Huế khoảng 2 giờ. Ở dài ngày vẫn còn chỗ để đi.'],
    ['💰', 'Chi phí sinh hoạt hợp lý', 'Ăn uống, đi lại, dịch vụ ở mức dễ chịu, giá niêm yết rõ ràng – thuận cho khách lưu trú dài ngày và người làm việc từ xa.'],
    ['📈', 'Khách du lịch tăng đều', '11 tháng 2025: 16,5 triệu lượt khách lưu trú (+18,9%), khách quốc tế khoảng 7 triệu (+26,5%) – Cục Thống kê TP Đà Nẵng.'],
    ['🏦', 'Động lực mới', 'Khu thương mại tự do Đà Nẵng (QĐ 1142/QĐ-TTg, 6/2025) và Trung tâm tài chính quốc tế (NQ 222/2025/QH15) mở thêm dòng khách công tác, chuyên gia.']
  ];
  var dnCss = '#hmdn{position:relative;z-index:5;display:block;background:#0f1d33;color:#e6edf6;padding:34px 0 30px;font-family:inherit;clear:both}'
    + '#hmdn *{box-sizing:border-box}#hmdn .hd-w{max-width:1140px;margin:0 auto;padding:0 16px}'
    + '#hmdn .hd-k{color:#ff8a4c;font-size:12px;letter-spacing:.14em;font-weight:700;text-transform:uppercase}'
    + '#hmdn h2{color:#fff;font-size:24px;line-height:1.25;margin:6px 0 8px;font-weight:800}'
    + '#hmdn .hd-p{margin:0 0 16px;font-size:15px;line-height:1.55;color:#c7d3e3}'
    + '#hmdn .hd-g{display:grid;grid-template-columns:repeat(2,1fr);gap:12px}'
    + '#hmdn .hd-c{background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);border-radius:12px;padding:14px 16px;display:flex;gap:12px;align-items:flex-start}'
    + '#hmdn .hd-i{font-size:24px;line-height:1}#hmdn b{display:block;color:#fff;font-size:16px;margin-bottom:4px}'
    + '#hmdn .hd-c span{font-size:14px;line-height:1.5;color:#c7d3e3}#hmdn .hd-s{font-size:12px;color:#8fa1b8;margin-top:12px}'
    + '@media(max-width:760px){#hmdn .hd-g{grid-template-columns:1fr}#hmdn h2{font-size:21px}}';
  function dnHtml() {
    return '<div class="hd-w"><div class="hd-k">Vì sao chọn Đà Nẵng</div>'
      + '<h2>Thành phố đáng sống, đáng đầu tư của miền Trung</h2>'
      + '<p class="hd-p">Hải Minh nằm giữa trục biển Võ Nguyên Giáp – Trường Sa, hưởng trọn những lợi thế của Đà Nẵng:</p>'
      + '<div class="hd-g">' + DN.map(function (d) { return '<div class="hd-c"><div class="hd-i">' + d[0] + '</div><div><b>' + d[1] + '</b><span>' + d[2] + '</span></div></div>'; }).join('') + '</div>'
      + '<div class="hd-s">Thời gian di chuyển là ước tính bằng ô tô. Các dự án hạ tầng theo quy hoạch, tiến độ do Nhà nước quyết định.</div></div>';
  }
  function build() {
    if (document.getElementById('hmx')) return;
    var img = document.querySelector('img[src*="so-do-vi-tri-hai-minh"]');
    var after = document.getElementById('hm4d') || (img && (img.closest('.ladi-section') || img.closest('section')));
    if (!after) { var s = document.querySelectorAll('.ladi-section, section'); after = s.length ? s[Math.min(3, s.length - 1)] : null; }
    if (!after) return;
    var st = document.createElement('style'); st.textContent = css; document.head.appendChild(st);
    var root = document.createElement('div'); root.id = 'hmx'; root.innerHTML = html();
    after.parentNode.insertBefore(root, after.nextSibling);
    var sd = document.createElement('style'); sd.textContent = dnCss; document.head.appendChild(sd);
    var dnEl = document.createElement('div'); dnEl.id = 'hmdn'; dnEl.innerHTML = dnHtml(); root.parentNode.insertBefore(dnEl, root);

    // quiz
    var ans = {};
    root.querySelectorAll('#hmx-quiz .hx-q').forEach(function (q) {
      q.querySelectorAll('.hx-o').forEach(function (b) {
        b.onclick = function () {
          q.querySelectorAll('.hx-o').forEach(function (x) { x.setAttribute('aria-pressed', 'false'); });
          b.setAttribute('aria-pressed', 'true'); ans[q.getAttribute('data-q')] = b.textContent;
          if (ans.muc && ans.ns && ans.thich) { var r = suggest(ans), el = document.getElementById('hmx-res'); el.innerHTML = r.text; el.hidden = false; document.getElementById('hmx-qgo').disabled = false; }
        };
      });
    });
    document.getElementById('hmx-qgo').onclick = function () { this.style.display = 'none'; document.getElementById('hmx-qf').classList.add('hx-on'); document.querySelector('#hmx-qf [name=ten]').focus(); };
    wireForm(document.getElementById('hmx-qf'), function () {
      return '[Trắc nghiệm] Mua để: ' + ans.muc + ' · Ngân sách: ' + ans.ns + ' · Thích: ' + ans.thich + ' → ' + suggest(ans).plain;
    }, 'trac-nghiem');

    // calculator
    var s1 = document.getElementById('hmx-s1'), s2 = document.getElementById('hmx-s2'), s3 = document.getElementById('hmx-s3');
    function calc() {
      var p = +s1.value, occ = +s2.value / 100, own = +s3.value, y = (365 - own) * occ * p;
      document.getElementById('hmx-o1').textContent = (p / 1e6).toLocaleString('vi-VN', { maximumFractionDigits: 2 }) + ' triệu';
      document.getElementById('hmx-o2').textContent = s2.value + '%';
      document.getElementById('hmx-o3').textContent = own + ' đêm';
      document.getElementById('hmx-y').textContent = '≈ ' + vnd(y);
      document.getElementById('hmx-m').textContent = '≈ ' + vnd(y / 12) + ' mỗi tháng · ' + Math.round((365 - own) * occ) + ' đêm cho thuê';
      return { p: p, occ: s2.value, own: own, y: y };
    }
    [s1, s2, s3].forEach(function (s) { s.oninput = calc; }); calc();
    document.getElementById('hmx-cgo').onclick = function () { this.style.display = 'none'; document.getElementById('hmx-cf').classList.add('hx-on'); document.querySelector('#hmx-cf [name=ten]').focus(); };
    document.getElementById('hmx-ago').onclick = function () { this.style.display = 'none'; document.getElementById('hmx-af').classList.add('hx-on'); document.querySelector('#hmx-af [name=ten]').focus(); };
    wireForm(document.getElementById('hmx-af'), function () { return '[Phân tích] Muốn nhận bảng giá trước ngày ra mắt'; }, 'phan-tich');
    wireForm(document.getElementById('hmx-cf'), function () {
      var c = calc(); return '[Dòng tiền] Giá/đêm ' + (c.p / 1e6) + ' triệu · công suất ' + c.occ + '% · tự ở ' + c.own + ' đêm → doanh thu minh họa ≈ ' + vnd(c.y) + '/năm';
    }, 'may-tinh-dong-tien');
  }

  function start() { setTimeout(build, document.getElementById('hm4d') ? 0 : 600); }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', start); else start();
})();
