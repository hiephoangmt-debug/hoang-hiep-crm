/* Sun Spana Tower – Trợ lý trả lời nhanh của anh Hoàng Hiệp.
 * Chat tự động + gửi khách về Telegram, CRM Hoàng Hiệp, email; nút Gọi / Zalo nổi; nhận cả form trên trang (kể cả form LadiPage).
 * Chỉ dùng thông tin dự án đã duyệt trong KB (tài liệu Kick-off 15/08/2025); không nêu giá, không hứa lợi nhuận.
 */
(function () {
  if (window.__hhc) return; window.__hhc = 1;

  /* ---------- Cấu hình ---------- */
  var TG = 'https://script.google.com/macros/s/AKfycbwvmG1HMtrQOeUXCuBJ6CHmMb4TcCZ53_n5lwPAt3-6-lG2_fIRX0q25Rv-6LPwVWXZHw/exec?key=sft-tg-4821';
  var CRM = 'https://script.google.com/macros/s/AKfycbyChbG-uvItjVlRk7JgLrwpUS6Cgah4nIA6BWHuEwgbXBqSlvAPJNSdZdp6pQ91d_rN/exec?key=kGYgRtNhbHZr';
  var MAIL = 'https://formsubmit.co/ajax/hiephoangmt@gmail.com';
  var PROJECT = 'Sun Spana Tower';
  var TEL = 'tel:0904567009', ZALO = 'https://zalo.me/0904567009', SO = '0904 567 009';

  /* ---------- Tiện ích ---------- */
  function sget(k) { try { return sessionStorage.getItem(k); } catch (e) { return null; } }
  function sset(k, v) { try { sessionStorage.setItem(k, v); } catch (e) {} }
  function lget(k) { try { return localStorage.getItem(k); } catch (e) { return null; } }
  function lset(k, v) { try { localStorage.setItem(k, v); } catch (e) {} }
  function pick(a) { return a[Math.floor(Math.random() * a.length)]; }
  function vnNow() { var d = new Date(); return new Date(d.getTime() + (d.getTimezoneOffset() + 420) * 60000); }
  function two(n) { return (n < 10 ? '0' : '') + n; }
  function vnTime() { var d = vnNow(); return two(d.getHours()) + ':' + two(d.getMinutes()) + ' ' + two(d.getDate()) + '/' + two(d.getMonth() + 1) + '/' + d.getFullYear(); }
  function nightNote() { var h = vnNow().getHours(); return h >= 21 ? 'anh Hiệp trả lời từ 8h sáng mai' : h < 8 ? 'anh Hiệp trả lời từ 8h sáng nay' : ''; }

  /* Nguồn quảng cáo: giữ trong phiên để gửi kèm */
  var SRC_KEYS = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term', 'gclid', 'fbclid', 'ttclid'];
  var qs = {}; try { location.search.replace(/^\?/, '').split('&').forEach(function (p) { var i = p.indexOf('='); if (i > 0) qs[decodeURIComponent(p.slice(0, i))] = decodeURIComponent(p.slice(i + 1).replace(/\+/g, ' ')); }); } catch (e) {}
  SRC_KEYS.forEach(function (k) { if (qs[k]) sset('hhc_' + k, qs[k]); });
  function src() { var d = {}; SRC_KEYS.forEach(function (k) { var v = qs[k] || sget('hhc_' + k); if (v) d[k] = v; }); return d; }

  /* Số điện thoại Việt Nam: di động 0[35789]xxxxxxxx hoặc bàn 02xxxxxxxxx */
  function normPhone(p) {
    p = String(p || '').replace(/[^\d+]/g, '');
    if (p.indexOf('+84') === 0) p = '0' + p.slice(3); else if (p.indexOf('84') === 0 && (p.length === 11 || p.length === 12)) p = '0' + p.slice(2);
    return /^0(3|5|7|8|9)\d{8}$/.test(p) || /^02\d{9}$/.test(p) ? p : '';
  }

  /* ---------- Gửi đi (beacon: vẫn tới nơi khi khách đóng trang) ---------- */
  function beacon(u, body) { try { if (navigator.sendBeacon && navigator.sendBeacon(u, body)) return true; } catch (e) {} return false; }
  function postJSON(u, d) {
    var s = JSON.stringify(d);
    if (beacon(u, new Blob([s], {type: 'text/plain;charset=utf-8'}))) return;
    try { fetch(u, {method: 'POST', mode: 'no-cors', keepalive: true, headers: {'Content-Type': 'text/plain;charset=utf-8'}, body: s}).catch(function () {}); } catch (e) {}
  }
  function postMail(d) {
    var p = []; for (var k in d) if (d[k] !== '' && d[k] != null) p.push(encodeURIComponent(k) + '=' + encodeURIComponent(String(d[k])));
    var body = p.join('&');
    try { fetch(MAIL, {method: 'POST', mode: 'no-cors', keepalive: true, headers: {'Content-Type': 'application/x-www-form-urlencoded', 'Accept': 'application/json'}, body: body}).catch(function () {}); }
    catch (e) { beacon(MAIL, new Blob([body], {type: 'application/x-www-form-urlencoded'})); }
  }
  var sentMem = {};
  function wasSent(ph) { return sentMem[ph] || sget('hhc_sent_' + ph) || lget('hhc_sent_' + ph); }
  function markSent(ph) { sentMem[ph] = 1; sset('hhc_sent_' + ph, '1'); lset('hhc_sent_' + ph, String(Date.now())); }

  /* d: {name, phone, interest, cau_hoi, hoi_thoai, ...}. Trả về 'ok' | 'dup' | '' (số sai) */
  function lead(d) {
    d = Object.assign({}, d, src(), {time: vnTime(), source: location.href.split('#')[0].split('?')[0]});
    if (d.thong_bao) { postJSON(TG, d); return 'ok'; }
    var ph = normPhone(d.phone); if (!ph) return '';
    if (wasSent(ph)) return 'dup';
    markSent(ph); d.phone = ph;
    postJSON(TG, d);
    postJSON(CRM, Object.assign({project: PROJECT, url: d.source, message: [d.interest, d.cau_hoi].filter(Boolean).join(' · ').slice(0, 500)}, d));
    postMail(Object.assign({_subject: 'Khách Sun Spana: ' + (d.name || 'chưa rõ tên') + ' - ' + ph, _template: 'table', _captcha: 'false'}, d));
    try { if (window.gtag) gtag('event', 'generate_lead', {event_label: d.interest || ''}); } catch (e) {}
    try { if (window.gtag && window.HHC_ADS_SEND_TO) gtag('event', 'conversion', {send_to: window.HHC_ADS_SEND_TO}); } catch (e) {}  // Google Ads: Sun Spana – Gửi form
    try { if (window.fbq) fbq('track', 'Lead', {content_name: d.interest || ''}); } catch (e) {}
    return 'ok';
  }
  window.hhcLead = lead;

  /* ---------- Hiểu câu hỏi (có dấu, không dấu, viết tắt) ---------- */
  var ABBR = {ko: 'khong', k: 'khong', kh: 'khong', khg: 'khong', hok: 'khong', hong: 'khong', hem: 'khong', dc: 'duoc', dk: 'duoc', bn: 'bao nhieu', bnh: 'bao nhieu', bnhieu: 'bao nhieu',
    cdt: 'chu dau tu', sh: 'so hong', pn: 'phong ngu', ntn: 'nhu the nao', j: 'gi', mk: 'minh', mik: 'minh', vs: 'voi', sdt: 'so dien thoai', dt: 'dien thoai',
    bh: 'bao gio', bgio: 'bao gio', ib: 'nhan tin', dky: 'dang ky', tks: 'cam on', thks: 'cam on', thank: 'cam on', thanks: 'cam on', r: 'roi', ms: 'moi', lm: 'lam',
    tr: 'trieu', ty: 'ty', oke: 'ok', okie: 'ok', okay: 'ok', zl: 'zalo', ad: 'anh', e: 'em', nt: 'nhan tin', ng: 'nguoi', bds: 'bat dong san', tl: 'tra loi', bt: 'binh thuong', mn: 'moi nguoi'};
  function norm(t) {
    var x = String(t || '').toLowerCase().replace(/đ/g, 'd').normalize('NFD').replace(/[̀-ͯ]/g, '').replace(/[^a-z0-9]+/g, ' ').trim();
    return ' ' + x.split(' ').map(function (w) { return ABBR[w] || w; }).join(' ') + ' ';
  }
  var BAD = ['dm', 'dmm', 'dcm', 'dkm', 'dit', 'djt', 'du ma', 'vcl', 'vkl', 'vl', 'cc', 'clm', 'cmm', 'cmn', 'loz', 'buoi', 'deo', 'me may', 'cha may', 'oc cho', 'do ngu', 'ngu vay', 'ngu the', 'ngu nhu', 'lol', 'fuck', 'shit'];
  function has(n, k) { return n.indexOf(' ' + k + ' ') > -1; }
  function isBad(n) { for (var i = 0; i < BAD.length; i++) if (has(n, BAD[i])) return true; return false; }

  /* ---------- Kiến thức & câu trả lời (chỉ dùng thông tin đã duyệt) ---------- */
  var KB = [
    {id: 'chao', k: ['chao', 'xin chao', 'hello', 'hi', 'alo', 'co ai khong', 'anh oi', 'chi oi', 'em oi'],
      a: ['Dạ em chào Anh/Chị ạ. Anh/Chị đang tìm căn Spana Tower để ở, cho thuê hay mua cho con ạ?', 'Dạ em đây ạ. Anh/Chị muốn xem giá, vị trí hay loại căn trước ạ?'], c: ['Vị trí dự án', 'Loại căn hộ']},
    {id: 'gia', k: ['gia', 'bang gia', 'bao nhieu tien', 'gia ban', 'gia ca', 'muc gia', 'tong gia', 'gia studio', 'gia can', 'bao nhieu 1 m2', 'tren m2', 'bao nhieu ty', 'gia bao nhieu', 'bao nhieu mot can', 'bao nhieu 1 can'],
      a: ['Dạ giá Spana Tower thay đổi theo loại căn, tầng, hướng và từng đợt chính sách của chủ đầu tư, nên em không báo con số trong khung chat để tránh sai ạ.\nAnh Hiệp gửi bảng giá đợt hiện tại kèm bảng tính tiền đóng từng đợt qua Zalo cho Anh/Chị.', 'Dạ bảng giá đang áp dụng theo từng đợt của Sun Group ạ. Em gửi Anh/Chị bảng giá đúng đợt, kèm căn còn trống và chính sách hỗ trợ lãi suất 30 tháng.'],
      c: ['Studio', '2BR'], ask: 'Anh/Chị để lại số Zalo, anh Hiệp gửi bảng giá ngay ạ.', strong: 1, topic: 'Giá bán'},
    {id: 'dat', k: ['dat qua', 'mac qua', 'cao qua', 'dat the', 'dat vay', 'dat lam', 'chat qua', 'sao dat', 'gia cao', 'khong du tien', 'it tien', 'von it', 'von nho'],
      a: ['Dạ em hiểu ạ, số tiền lớn thì mình cân nhắc kỹ là đúng. Mua căn hộ không phải bỏ hết một lần: mình đóng theo tiến độ xây dựng, phần còn lại vay ngân hàng và được chủ đầu tư hỗ trợ lãi suất đến 30 tháng.\nStudio và 1BR+ là dòng vốn vào nhẹ nhất. Tầm ngân sách Anh/Chị thấy thoải mái là bao nhiêu ạ?'],
      c: ['Studio', 'Vay ngân hàng'], ask: 'Anh/Chị cho em xin số Zalo, em tính sẵn số tiền đóng từng đợt theo ngân sách của mình ạ.', topic: 'Lo về giá / ngân sách'},
    {id: 'vitri', k: ['vi tri', 'o dau', 'dia chi', 'cho nao', 'duong nao', 'khu nao', 'nam o', 'ban do', 'map', 'toa lac', 'phuong nao', 'quan nao'],
      a: ['Dạ Spana Tower nằm ngay chân cầu Hòa Xuân, giữa đường Nguyễn Phước Lan và Nguyễn Văn Thông, khu đô thị Hòa Xuân, cạnh sông Cẩm Lệ và Euro Village 2 ạ.\nAnh/Chị đang ở Đà Nẵng hay ở xa ạ?', 'Dạ hai tòa S1, S2 đứng hai bên đường dẫn cầu Hòa Xuân, cửa ngõ khu đô thị mới phía nam Đà Nẵng, nhìn ra sông Cẩm Lệ ạ.\nAnh/Chị nhớ chỗ nào ở Đà Nẵng nhất, sân bay hay cầu Rồng, để em chỉ đường theo đó ạ?'],
      c: ['Từ sân bay', 'Từ cầu Rồng', 'Đi Hội An'], ask: 'Anh/Chị để lại Zalo, em gửi bản đồ và video flycam vị trí thực tế ạ.', topic: 'Vị trí'},
    {id: 'sanbay', k: ['san bay', 'tu san bay', 'xuong may bay', 'ha canh', 'nha ga san bay', 'san bay da nang'],
      a: ['Dạ từ sân bay Đà Nẵng tới Spana Tower khoảng 10 phút ạ (theo tài liệu chủ đầu tư, tùy giờ). Căn hướng tây còn nhìn được về phía sân bay và công viên Thanh Niên.'], c: ['Từ cầu Rồng', 'Hướng view'], topic: 'Vị trí'},
    {id: 'caurong', k: ['cau rong', 'cau song han', 'song han', 'cho han', 'trung tam', 'xa trung tam', 'gan trung tam', 'hai chau', 'mega market', 'sieu thi', 'vinmec', 'benh vien'],
      a: ['Dạ khoảng 10 phút tới cầu Rồng và trung tâm Hải Châu; Mega Market khoảng 5–10 phút; gần bệnh viện Vinmec và trường Đại học Kiến trúc ạ.'], c: ['Đi Hội An', 'Tiện ích'], topic: 'Vị trí'},
    {id: 'hoian', k: ['hoi an', 'pho co', 'di hoi an', 'ba na', 'ngu hanh son', 'non nuoc', 'son tra', 'linh ung', 'my son'],
      a: ['Dạ từ dự án: Ngũ Hành Sơn khoảng 5 phút, bán đảo Sơn Trà 20 phút, chùa Linh Ứng và phố cổ Hội An khoảng 25 phút ạ. Dự án nằm trên tuyến đường nối Đà Nẵng với các di sản Hội An, Mỹ Sơn.'], c: ['Vị trí dự án', 'Hướng view'], topic: 'Vị trí'},
    {id: 'oxa', k: ['o xa', 'ngoai bac', 'ha noi', 'sai gon', 'tp hcm', 'ho chi minh', 'chua den da nang', 'chua toi da nang', 'chua ra', 'o nuoc ngoai'],
      a: ['Dạ nhiều khách của anh Hiệp cũng ở xa ạ. Anh Hiệp gửi video flycam công trường, mặt bằng và hồ sơ qua Zalo, khi nào Anh/Chị ra Đà Nẵng thì hẹn đi xem thực tế.'], c: ['Vị trí dự án', 'Pháp lý'], ask: 'Anh/Chị để lại Zalo, em gửi video flycam mới nhất ạ.', topic: 'Khách ở xa'},
    {id: 'bien', k: ['bien', 'cach bien', 'xa bien', 'gan bien', 'ra bien', 'toi bien', 'den bien', 'my khe', 'bao xa'],
      a: ['Dạ ra biển Mỹ Khê khoảng 5–10 phút đi xe ạ. Tầng cao hướng đông nhìn được Đà Nẵng Downtown, ngã ba sông và về phía biển.'], c: ['Hướng view', 'Loại căn hộ'], topic: 'Khoảng cách biển'},
    {id: 'hatang', k: ['ha tang', 'cau hoa xuan', 'nang cap cau', 'quy hoach', 'ngap', 'ngap ung', 'lu', 'kiet', 'hem', 'ngo'],
      a: ['Dạ khu đô thị Hòa Xuân quy hoạch bài bản, không ngập úng, không có ngõ, hẻm, kiệt ạ. Cầu Hòa Xuân được nâng cấp từ quý I/2026.\nKhu này nằm giữa Đà Nẵng và Quảng Nam (cũ), đang được xem là trung tâm mới sau sáp nhập.'], c: ['Tiện ích', 'Vị trí dự án'], topic: 'Hạ tầng'},
    {id: 'view', k: ['view', 'huong view', 'huong nhin', 'nhin ra', 'view song', 'song cam le', 'huong song', 'tang cao', 'tang thap', 'huong nao'],
      a: ['Dạ Spana nhìn nhiều hướng ạ: sông Cẩm Lệ, công viên Thanh Niên, phía sân bay; Đà Nẵng Downtown, ngã ba sông và biển; khu đô thị Hòa Quý, Ngũ Hành Sơn; và hướng tây nam nhìn khu thấp tầng. Căn góc nhìn được hai hướng.'], c: ['Loại căn hộ', 'Giá bán'], ask: 'Anh/Chị để lại Zalo, em gửi ảnh view thực tế theo từng tầng ạ.', topic: 'Hướng view'},
    {id: 'daily', k: ['dai ly', 'tatiland', 'tati land', 'tati', 'phan phoi', 'chinh thuc khong', 'ben nao ban', 'cong ty nao ban', 'mua o dau', 'f1', 'moi gioi'],
      a: ['Dạ anh Hiệp là Giám đốc kinh doanh TATILAND (Công ty CP Đầu tư Địa ốc TATI) – đơn vị phân phối chính thức của Sun Group, nên bảng giá, chính sách và hợp đồng đều theo đúng quy trình chủ đầu tư ạ.'],
      c: ['Giá bán', 'Pháp lý'], ask: 'Anh/Chị để lại Zalo, em gửi bảng giá và chính sách chính thức ạ.', strong: 1, topic: 'Đại lý chính thức'},
    {id: 'quymo', k: ['quy mo', 'bao nhieu tang', 'may tang', 'cao bao nhieu', 'bao nhieu can', 'may can', 'dien tich dat', 'tang ham', 'may toa', 'bao nhieu toa', 's1', 's2'],
      a: ['Dạ Spana Tower trên khu đất 4.165 m², gồm 2 tòa tháp S1 và S2, cao 22 tầng nổi và 2 tầng hầm, tổng 1.281 căn hộ ạ.\nTầng 1 là shophouse khối đế trần 7 m, tầng 2 tiện ích trần 6 m, tầng 3–21 căn hộ trần 3,5 m, tầng 22 penthouse trần 6 m.'], c: ['Loại căn hộ', 'Tiện ích'], topic: 'Quy mô'},
    {id: 'loaican', k: ['loai can', 'dong can', 'can ho', 'studio', '1br', '1br+', '1pn', '1 phong ngu', '2br', '2pn', '2 phong ngu', '3br', '3pn', '3 phong ngu', 'penthouse', 'dien tich', 'bao nhieu m2', 'rong bao nhieu', 'mat bang'],
      a: ['Dạ Spana có Studio, 1BR+, 2BR, 3BR và Penthouse ạ, căn hộ điển hình trần cao 3,5 m.\n• Studio, 1BR+: vốn nhẹ, dễ cho thuê.\n• 2BR, 3BR: hợp gia đình.\n• Penthouse tầng 22: trần 6 m, sân vườn và hồ bơi riêng trên sân thượng.\nDiện tích từng căn theo mặt bằng của chủ đầu tư.'],
      c: ['Giá bán', 'Hướng view'], ask: 'Anh/Chị để lại Zalo, em gửi mặt bằng tầng và căn còn trống ạ.', topic: 'Loại căn'},
    {id: 'o', k: ['de o', 'o lau dai', 'gia dinh', 'ca nha', 'cho con', 'bo me', 'con nho', 'vo chong tre', 'cong chuc', 'can bo'],
      a: ['Dạ Spana rất hợp gia đình trẻ, cán bộ công chức và bố mẹ mua cho con ạ: khu đô thị yên tĩnh, nhiều công viên ven sông, gần trường học, 10 phút vào trung tâm.\n2BR, 3BR là lựa chọn phổ biến cho gia đình.'], c: ['Tiện ích', 'Vay ngân hàng'], ask: 'Anh/Chị để lại Zalo, em gửi mặt bằng căn 2BR, 3BR ạ.', topic: 'Mua để ở'},
    {id: 'chothue', k: ['cho thue', 'thue', 'dong tien', 'loi nhuan', 'sinh loi', 'kinh doanh', 'airbnb', 'gia thue', 'thu nhap'],
      a: ['Dạ Studio và 1BR+ là dòng dễ cho thuê nhất ạ: khách là người trẻ, chuyên gia làm việc tại Đà Nẵng, cần ở gần trung tâm, sân bay mà yên tĩnh. Giá thuê thực tế tùy thời điểm, em không dám hứa con số ạ.'], c: ['Studio', 'Vay ngân hàng'], ask: 'Anh/Chị để lại Zalo, anh Hiệp tính giúp tiền thuê so với tiền góp ngân hàng ạ.', topic: 'Cho thuê'},
    {id: 'dautu', k: ['dau tu', 'an chenh', 'luot song', 'ban lai', 'chuyen nhuong', 'co nen dau tu', 'tiem nang', 'tang gia', 'len gia', 'thi truong'],
      a: ['Dạ Spana là dự án căn hộ cao cấp đầu tiên tại Hòa Xuân, sở hữu lâu dài, ở khu được xem là trung tâm mới sau sáp nhập ạ. Sun Group cũng đang đầu tư công viên Hype Park 50 ha, Marina Park, Sport Park quanh đây.\nEm không hứa tăng giá ạ, Anh/Chị cân nhắc theo khả năng tài chính của mình.'], c: ['Tiện ích', 'Giá bán'], ask: 'Anh/Chị để lại Zalo, anh Hiệp gửi phân tích chi tiết ạ.', topic: 'Đầu tư'},
    {id: 'tienich', k: ['tien ich', 'ho boi', 'be boi', 'gym', 'spa', 'sauna', 'xong hoi', 'phong tap', 'cong vien', 'hype park', 'marina', 'sport park', 'du thuyen', 'nha hang', 'truong hoc', 'shophouse', 'khoi de'],
      a: ['Dạ trong tòa có bể bơi, phòng gym, spa – steam – sauna, phòng sinh hoạt cộng đồng, sảnh lễ tân, shophouse khối đế và 2 tầng hầm ạ.\nQuanh khu đô thị có đại công viên Hype Park 50 ha (6 công viên chủ đề), Sport Park, Marina Park bến du thuyền, nhà hàng view sông 300 chỗ và đường dạo bộ ven sông.'], c: ['Loại căn hộ', 'Giá bán'], topic: 'Tiện ích'},
    {id: 'bangiao', k: ['ban giao', 'khi nao ban giao', 'bao gio ban giao', 'khi nao xong', 'bao gio xong', 'tien do', 'hoan thanh', 'xay den dau', 'cong truong', 'tang may', 'len tang', 'xay toi', 'tien do xay dung', 'noi that', 'tieu chuan ban giao', 'tho'],
      a: ['Dạ theo ảnh flycam cập nhật 11/2026, hai tòa S1, S2 đang thi công phần thân, đã lên khoảng tầng 10 ạ (tháng 9/2025 mới ép cọc). Căn hộ bàn giao hoàn thiện trần, tường, sàn, không gồm thiết bị nội thất. Thời điểm bàn giao ghi trong hợp đồng mua bán.'], c: ['Pháp lý', 'Thanh toán'], ask: 'Anh/Chị để lại Zalo, em gửi video flycam công trường mới nhất ạ.', topic: 'Bàn giao / tiến độ'},
    {id: 'cdt', k: ['chu dau tu', 'sun group', 'sun property', 'ai xay', 'cong ty nao', 'thuong hieu', 'cua ai'],
      a: ['Dạ chủ đầu tư là Tập đoàn Sun Group ạ. Tại Đà Nẵng từ 2023 Sun Group đã triển khai Sun Cosmo, Sun Ponte, Sun Symphony, Sun Costa và Sun Solar Residence.'], c: ['Pháp lý', 'Quy mô dự án'], topic: 'Chủ đầu tư'},
    {id: 'phaply', k: ['phap ly', 'so hong', 'so do', 'giay to', 'giay chung nhan', 'lau dai', 'thoi han', '50 nam', 'so huu', 'giay phep'],
      a: ['Dạ theo tài liệu chủ đầu tư, căn hộ Spana Tower có hình thức sở hữu lâu dài ạ.\nTrước khi ký, Anh/Chị nên xem chủ trương đầu tư, giấy phép xây dựng, văn bản đủ điều kiện bán và bảo lãnh ngân hàng; anh Hiệp gửi bản chụp và giải thích từng điều khoản.'], c: ['Thanh toán', 'Gặp anh Hiệp'], ask: 'Anh/Chị để lại Zalo, em gửi hồ sơ pháp lý ạ.', topic: 'Pháp lý'},
    {id: 'luadao', k: ['lua dao', 'bi lua', 'lua khong', 'lua dao khong', 'uy tin khong', 'tin duoc khong', 'co that khong', 'that khong', 'scam', 'mat tien', 'gia mao', 'co chac khong', 'tin sao duoc'],
      a: ['Dạ Anh/Chị cẩn thận là rất đúng ạ. Đăng ký trên trang chỉ để nhận thông tin, không thu tiền. Mọi giao dịch theo hợp đồng và văn bản chính thức của chủ đầu tư; tiền đặt chỗ (nếu có) chỉ nộp vào tài khoản công ty. Anh/Chị cứ gọi thẳng anh Hiệp ' + SO + ' để hỏi kỹ trước.'],
      c: ['Pháp lý', 'Gặp anh Hiệp'], topic: 'Lo ngại uy tín'},
    {id: 'coc', k: ['dat coc', 'coc', 'giu cho', 'booking', 'dat cho', 'giu can', 'chuyen khoan', 'tra truoc'],
      a: ['Dạ mức đặt chỗ và quy trình giữ căn theo chính sách từng đợt của chủ đầu tư ạ. Tiền chỉ chuyển vào tài khoản công ty theo hướng dẫn chính thức, em không nhận tiền qua khung chat.'],
      c: ['Giá bán', 'Pháp lý'], ask: 'Anh/Chị để lại số Zalo, anh Hiệp gọi hướng dẫn giữ căn đúng quy trình ạ.', strong: 1, topic: 'Booking / đặt cọc'},
    {id: 'moban', k: ['mo ban', 'khi nao mo ban', 'dang ban', 'ban chua', 'da ban', 'ra hang', 'bao gio ban', 'con can khong', 'het can', 'con khong'],
      a: ['Dạ Spana Tower đang bán theo từng đợt ạ. Căn còn trống thay đổi hằng ngày nên anh Hiệp gửi danh sách cập nhật qua Zalo cho chính xác.'], c: ['Giá bán', 'Loại căn hộ'], ask: 'Anh/Chị để lại Zalo, em gửi danh sách căn còn trống ạ.', strong: 1, topic: 'Tình trạng bán'},
    {id: 'vay', k: ['vay ngan hang', 'vay von', 'cho vay', 'vay duoc', 'vay bao nhieu', 'vay tien', 'duoc vay', 'ngan hang', 'lai suat', 'ho tro lai suat', 'an han'],
      a: ['Dạ chủ đầu tư hỗ trợ lãi suất lên đến 30 tháng ạ. Tỷ lệ vay và ngân hàng cụ thể theo chính sách từng đợt; anh Hiệp tính giúp số tiền trả mỗi tháng sau thời gian hỗ trợ.'], c: ['Thanh toán', 'Giá bán'], ask: 'Anh/Chị để lại Zalo, em gửi bảng tính vay theo căn mình chọn ạ.', topic: 'Vay ngân hàng'},
    {id: 'thanhtoan', k: ['tien do thanh toan', 'thanh toan', 'thanh toan the nao', 'dong tien the nao', 'dong may dot', 'may dot', 'chiet khau', 'thanh toan som', 'chinh sach'],
      a: ['Dạ mình đóng theo tiến độ xây dựng, phần còn lại có thể vay ngân hàng với hỗ trợ lãi suất đến 30 tháng; thanh toán sớm có thể có chiết khấu tùy đợt ạ. Tỷ lệ từng đợt theo văn bản chính sách hiện hành.'], c: ['Vay ngân hàng', 'Giá bán'], ask: 'Anh/Chị để lại Zalo, em gửi bảng tính tiền đóng từng đợt ạ.', topic: 'Thanh toán'},
    {id: 'xem', k: ['xem nha', 'nha mau', 'tham quan', 'xem thuc te', 'di xem', 'qua xem', 'ra xem', 'hen gap', 'gap mat', 'van phong'],
      a: ['Dạ Anh/Chị ở Đà Nẵng thì anh Hiệp hẹn đưa đi xem công trường và khu đô thị Hòa Xuân ạ. Anh/Chị dự kiến đi lúc nào ạ?'], c: ['Gặp anh Hiệp', 'Vị trí dự án'], ask: 'Anh/Chị để lại số, anh Hiệp gọi hẹn lịch ạ.', strong: 1, topic: 'Hẹn xem dự án'},
    {id: 'suynghi', k: ['suy nghi', 'de xem', 'can nhac', 'tham khao', 'chua chac', 'chua can', 'de sau', 'tu tu', 'ban voi vo', 'ban voi chong', 'hoi y kien'],
      a: ['Dạ Anh/Chị cứ thong thả cân nhắc ạ, mua nhà là việc lớn. Em gửi tài liệu để cả nhà cùng xem, không làm phiền đâu ạ.'], c: ['Vị trí dự án', 'Loại căn hộ'], ask: 'Nếu tiện Anh/Chị để lại Zalo, em gửi tài liệu để mình xem dần ạ.', topic: 'Còn cân nhắc'},
    {id: 'ban', k: ['ban lam', 'ban qua', 'luc khac', 'de luc khac', 'khi khac', 'chut nua', 'toi ban', 'minh ban', 'dang hop', 'dang lai xe'],
      a: ['Dạ em không làm mất thời gian của Anh/Chị ạ. Anh/Chị để lại số Zalo, em gửi gọn tài liệu để lúc rảnh mình xem.'], c: [], topic: 'Đang bận'},
    {id: 'bot', k: ['bot', 'robot', 'may tra loi', 'tu dong', 'nguoi that khong', 'phai nguoi khong', 'ai dang chat', 'ai tra loi', 'ban la ai', 'em la ai', 'chatbot', 'tra loi tu dong', 'la may', 'phai may'],
      a: ['Dạ em là trợ lý trả lời nhanh của anh Hoàng Hiệp, không phải người thật ạ. Câu nào cần chính xác, em chuyển anh Hiệp gọi lại cho Anh/Chị.'], c: ['Gặp anh Hiệp', 'Giá bán'], topic: 'Hỏi có phải máy'},
    {id: 'nguoi', k: ['nguoi that', 'gap nguoi', 'noi chuyen voi nguoi', 'gap anh hiep', 'anh hiep', 'goi cho toi', 'goi lai', 'goi cho minh', 'nhan vien', 'tu van vien', 'chuyen vien', 'nguoi tu van', 'gap anh', 'gap truc tiep'],
      a: ['Dạ em báo anh Hiệp ngay ạ. Anh/Chị gọi trực tiếp ' + SO + ', hoặc để lại số, anh Hiệp gọi lại cho mình.'], c: [], human: 1, topic: 'Muốn gặp người thật'},
    {id: 'zalo', k: ['zalo', 'nhan zalo', 'so zalo', 'so dien thoai', 'hotline', 'lien he', 'so may'],
      a: ['Dạ Anh/Chị nhắn Zalo ' + SO + ' (anh Hoàng Hiệp) ạ, hoặc gõ số của mình vào đây, anh Hiệp chủ động liên hệ.'], c: [], topic: 'Xin liên hệ'},
    {id: 'tuchoi', k: ['khong de so', 'khong cho so', 'khong muon de', 'khong can goi', 'dung goi', 'khong de lai', 'khong muon cho', 'thoi khoi', 'khong can dau'],
      a: ['Dạ không sao ạ, Anh/Chị cứ hỏi thoải mái, em không xin số nữa đâu ạ.'], c: ['Vị trí dự án', 'Loại căn hộ'], refuse: 1},
    {id: 'camon', k: ['cam on', 'ok', 'hieu roi', 'duoc roi', 'vang', 'da biet', 'tot qua', 'hay qua'],
      a: ['Dạ em cảm ơn Anh/Chị ạ. Anh/Chị cần thêm gì cứ nhắn em nhé.', 'Dạ vâng ạ, có gì Anh/Chị cứ hỏi tiếp, em trả lời ngay.'], c: []}
  ];
  /* Sau khi trả lời: mở câu chuyện tiếp theo, dẫn dần tới mời để số/Zalo ('lead') */
  var HOOK = {
    thanhtoan: [['Anh/Chị thích đóng theo tiến độ, dùng vốn vay hay thanh toán sớm lấy chiết khấu ạ?', '']],
    oxa: [['Lần tới ra Đà Nẵng Anh/Chị có muốn anh Hiệp dẫn đi xem công trường không ạ?', 'xem']],
    hoian: [['Anh/Chị có muốn biết hạ tầng quanh khu Hòa Xuân không ạ?', 'hatang']],
    caurong: [['Anh/Chị có muốn biết căn nào nhìn được sông Cẩm Lệ và Downtown không ạ?', 'view']],
    sanbay: [['Anh/Chị có muốn xem tiện ích trong tòa không ạ?', 'tienich']],
    dat: [['Anh/Chị có muốn em so sánh nhanh Studio và 1BR+ cho dễ chọn không ạ?', 'loaican']],
    vitri: [['Anh/Chị có muốn biết mỗi hướng căn nhìn ra gì không ạ?', 'view'], ['Anh/Chị có muốn xem tiện ích quanh khu đô thị không ạ?', 'tienich']],
    bien: [['Anh/Chị có muốn em gửi ảnh view thực tế theo tầng không ạ?', 'lead']],
    quymo: [['Anh/Chị có muốn xem các loại căn trong tòa không ạ?', 'loaican']],
    o: [['Anh/Chị có muốn biết chính sách vay, hỗ trợ lãi suất không ạ?', 'vay']],
    chothue: [['Anh/Chị có muốn em gửi bảng tính tiền thuê so với tiền góp ngân hàng không ạ?', 'lead']],
    dautu: [['Anh/Chị có muốn biết thêm phần pháp lý sở hữu lâu dài không ạ?', 'phaply']],
    tienich: [['Anh/Chị có muốn biết dòng căn nào hợp gia đình có con nhỏ không ạ?', 'o']],
    bangiao: [['Anh/Chị có muốn biết thêm phần pháp lý của dự án không ạ?', 'phaply']],
    cdt: [['Anh/Chị có muốn biết quy mô tòa nhà không ạ?', 'quymo']],
    phaply: [['Anh/Chị có muốn em gửi hồ sơ pháp lý qua Zalo không ạ?', 'lead']],
    luadao: [['Anh/Chị có muốn anh Hiệp gọi lại để trao đổi trực tiếp cho yên tâm không ạ?', 'lead']],
    coc: [['Anh/Chị đang nhắm Studio, 1BR+, 2BR hay 3BR để em ghi đúng dòng căn ạ?', 'loaican']],
    moban: [['Anh/Chị có muốn nhận danh sách căn trống mỗi tuần không ạ?', 'lead']],
    vay: [['Anh/Chị dự kiến chuẩn bị vốn khoảng bao nhiêu để em tính trước giúp mình ạ?', '']],
    hatang: [['Anh/Chị có muốn xem tiện ích quanh khu đô thị không ạ?', 'tienich']],
    view: [['Anh/Chị có muốn em gửi ảnh view thực tế theo tầng không ạ?', 'lead']],
    loaican: [['Anh/Chị có muốn biết mỗi hướng căn nhìn ra gì không ạ?', 'view']],
    suynghi: [['Trong lúc cân nhắc, Anh/Chị muốn xem trước vị trí hay loại căn ạ?', '']],
    bot: [['Anh/Chị có muốn em chuyển anh Hiệp gọi lại cho mình không ạ?', 'lead']],
    tuchoi: [['Anh/Chị đang quan tâm vị trí hay loại căn hơn ạ?', '']],
    camon: [['Anh/Chị có muốn nhận bảng giá qua Zalo không ạ?', 'lead']],
    zalo: [['', '']]
  };
  var AFF = / (co|muon|vang|ok|duoc|uh|u|um|dong y|gui|gui di|gui em|gui anh|gui chi|nhe|yes|chac chan|tat nhien|duoc a|co a|muon a) /;
  var NEG = / (khong|thoi|chua|de sau|khong can|khoi|no) /;
  var ALIAS = {'Studio': 'studio', '2BR': '2br', 'Để ở': 'de o', 'Cho thuê': 'cho thue', 'Tiện ích': 'tien ich', 'Bàn giao': 'ban giao', 'Pháp lý': 'phap ly', 'Chủ đầu tư': 'chu dau tu',
    'Vị trí dự án': 'vi tri', 'Loại căn hộ': 'loai can', 'Giá bán': 'gia ban', 'Quy mô dự án': 'quy mo', 'Gặp anh Hiệp': 'gap anh hiep', 'Hướng view': 'huong view',
    'Vay ngân hàng': 'vay ngan hang', 'Thanh toán': 'thanh toan', 'Từ sân bay': 'tu san bay', 'Từ cầu Rồng': 'cau rong', 'Đi Hội An': 'di hoi an'};

  /* ---------- Giao diện ---------- */
  /* Ẩn chat cũ nếu trang còn mã cũ (ss-all.js #hmw, chat .cb-*) để không hiện 2 khung chat */
  var CSS = '#hmw,.cb-btn,.cb-box,.cb-nudge{display:none!important}'
    + '.hhc-l{position:fixed;right:16px;bottom:18px;z-index:9001;width:58px;height:58px;border-radius:50%;border:3px solid #fff;background:#0B2545;color:#fff;display:flex;align-items:center;justify-content:center;box-shadow:0 10px 24px rgba(4,24,42,.35);cursor:pointer;padding:0}'
    + '.hhc-l i{position:absolute;top:-3px;right:-3px;width:16px;height:16px;border-radius:50%;background:#3DDC84;border:3px solid #fff}'
    + '.hhc-n{position:fixed;right:84px;bottom:30px;z-index:9001;max-width:250px;background:#fff;color:#0A1F38;border-radius:14px 14px 4px 14px;padding:11px 30px 11px 13px;font-size:14px;line-height:1.45;box-shadow:0 12px 30px rgba(4,24,42,.28);cursor:pointer;display:none;font-family:inherit}'
    + '.hhc-n.on{display:block}.hhc-n button{position:absolute;right:6px;top:4px;border:0;background:none;font-size:18px;color:#5B6B7E;cursor:pointer}'
    + '.hhc-b{position:fixed;right:16px;bottom:16px;z-index:99990;width:370px;max-width:calc(100vw - 24px);height:560px;max-height:calc(100vh - 32px);background:#F6F8FC;border-radius:18px;box-shadow:0 24px 60px rgba(4,24,42,.4);display:none;flex-direction:column;overflow:hidden;font-family:inherit;color:#0A1F38}'
    + '.hhc-b.on{display:flex}'
    + '.hhc-h{background:#0B2545;color:#fff;padding:12px 14px;display:flex;align-items:center;gap:11px}'
    + '.hhc-av{flex:none;width:40px;height:40px;border-radius:50%;background:#F26B1D;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:14px}'
    + '.hhc-h b{display:block;font-size:15px;line-height:1.3}.hhc-h small{display:block;font-size:12px;color:#B9C7DD;line-height:1.35}'
    + '.hhc-x{margin-left:auto;background:none;border:0;color:#fff;font-size:26px;line-height:1;cursor:pointer;padding:0 4px}'
    + '.hhc-log{flex:1;overflow-y:auto;padding:12px;display:flex;flex-direction:column;gap:8px;-webkit-overflow-scrolling:touch}'
    + '.hhc-m{max-width:86%;padding:10px 13px;border-radius:15px;font-size:15px;line-height:1.5;white-space:pre-line;word-wrap:break-word;text-align:left}'
    + '.hhc-bot{background:#fff;border:1px solid #D7DFEC;border-bottom-left-radius:4px;align-self:flex-start}'
    + '.hhc-me{background:#F26B1D;color:#fff;border-bottom-right-radius:4px;align-self:flex-end}'
    + '.hhc-t{font-size:13px;color:#5B6B7E;align-self:flex-start;padding-left:4px}'
    + '.hhc-c{display:flex;flex-wrap:wrap;gap:6px}.hhc-c button{background:#fff;border:1.5px solid #13315C;color:#13315C;border-radius:999px;padding:6px 12px;font-size:13.5px;font-weight:600;cursor:pointer;font-family:inherit}'
    + '.hhc-c button:hover{background:#13315C;color:#fff}'
    + '.hhc-q{display:flex;gap:6px;padding:8px 10px 0;background:#fff;border-top:1px solid #D7DFEC}.hhc-q a{flex:1;text-align:center;text-decoration:none;font-size:13px;font-weight:700;border-radius:10px;padding:7px 4px;color:#fff}'
    + '.hhc-q .z{background:#0068FF}.hhc-q .g{background:#0B2545}'
    + '.hhc-i{display:flex;gap:8px;padding:10px;background:#fff;border-top:1px solid #D7DFEC}.hhc-i input{flex:1;min-width:0;border:1px solid #D7DFEC;border-radius:999px;padding:11px 14px;font-size:16px;font-family:inherit;background:#F6F8FC;color:#0A1F38;-webkit-user-select:text;user-select:text}'
    + '.hhc-i button{background:#F26B1D;color:#fff;border:0;border-radius:999px;padding:0 16px;font-weight:700;cursor:pointer;font-family:inherit;font-size:15px}'
    + '.hhc-n2{position:fixed;right:84px;bottom:30px;z-index:9001;width:290px;max-width:calc(100vw - 24px);background:#fff;color:#0A1F38;border-radius:14px 14px 4px 14px;padding:12px 30px 12px 14px;font-size:14px;line-height:1.45;box-shadow:0 12px 30px rgba(4,24,42,.28);display:none;font-family:inherit;animation:hhcUp .35s ease}'
    + '.hhc-n2.on{display:block}.hhc-n2 p{margin:0 0 8px}.hhc-n2 .hhc-c button{font-size:13px;padding:6px 11px;text-align:left}'
    + '.hhc-n2>.hhc-nx{position:absolute;top:4px;right:6px;border:0;background:none;font-size:20px;line-height:1;color:#6b7a90;cursor:pointer;padding:2px 4px}'
    + '@keyframes hhcUp{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:none}}'
    + '@media (prefers-reduced-motion:reduce){.hhc-n2{animation:none}}'
    + '@media (max-width:600px){.hhc-n2{left:10px;right:66px;width:auto;bottom:84px;border-radius:14px}}'
    + '@media (max-width:600px){.hhc-b{right:0;left:0;bottom:0;width:100%;max-width:100%;height:82vh;max-height:82vh;border-radius:18px 18px 0 0}.hhc-n{right:80px;bottom:96px}}'

    + '.hhc-fl{position:fixed;right:20px;bottom:88px;z-index:9001;display:flex;flex-direction:column;gap:10px}'
    + '.hhc-fl a{width:50px;height:50px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:12px;text-decoration:none;box-shadow:0 8px 20px rgba(4,24,42,.3);border:3px solid #fff}'
    + '.hhc-fl .z{background:#0068FF}.hhc-fl .g{background:#F26B1D;animation:hhcRing 2.4s infinite}'
    + '@keyframes hhcRing{0%,100%{transform:none}10%,30%{transform:rotate(-12deg)}20%,40%{transform:rotate(12deg)}50%{transform:none}}'
    + '.hhc-mb{display:none}'
    + '@media (max-width:600px){.hhc-fl{display:none}.hhc-mb{display:grid;grid-template-columns:1fr 1fr 1fr;position:fixed;left:0;right:0;bottom:0;z-index:9000;background:#fff;box-shadow:0 -6px 20px rgba(0,0,0,.12)}'
    + '.hhc-mb a{display:flex;align-items:center;justify-content:center;gap:6px;padding:14px 4px;font-weight:700;font-size:15px;text-decoration:none;color:#0B2545;font-family:inherit}.hhc-mb .z{background:#0068FF;color:#fff}.hhc-mb .b{background:#F26B1D;color:#FFFFFF}'
    + '.hhc-l{bottom:66px!important}body{padding-bottom:52px}}'
    + '@media (prefers-reduced-motion:reduce){.hhc-fl .g{animation:none}}'
    + '.hhc-ok{margin:10px 0 0;font-weight:600;color:#0B7A43;text-align:left}';

  var box, log, inp, launcher, nudge, started = false;
  function el(tag, cls, html) { var e = document.createElement(tag); if (cls) e.className = cls; if (html != null) e.innerHTML = html; return e; }
  function scrollEnd() { log.scrollTop = log.scrollHeight; }
  function bubble(txt, who) { var d = el('div', 'hhc-m ' + (who === 'me' ? 'hhc-me' : 'hhc-bot')); d.textContent = txt; log.appendChild(d); scrollEnd(); }
  function chips(list) {
    if (!list || !list.length) return;
    var w = el('div', 'hhc-c');
    list.slice(0, 2).forEach(function (c) { var b = el('button'); b.type = 'button'; b.textContent = c; b.onclick = function () { w.remove(); ask(c); }; w.appendChild(b); });
    log.appendChild(w); scrollEnd();
  }
  var outq = [], talking = false;
  /* Hiện "Đang trả lời…" ngắn rồi mới hiện tin; các tin xếp hàng, không chồng lên nhau */
  function say(txt, list) { convo.push('Trợ lý: ' + txt); outq.push([txt, list]); if (!talking) next(); }
  function next() {
    var it = outq.shift(); if (!it) { talking = false; return; } talking = true;
    var t = el('div', 'hhc-t'); t.textContent = 'Đang trả lời…'; log.appendChild(t); scrollEnd();
    setTimeout(function () { t.remove(); bubble(it[0], 'bot'); chips(it[1]); armIdle(); setTimeout(next, 120); }, Math.min(1100, 450 + it[0].length * 3));
  }

  function build() {
    var st = el('style'); st.textContent = CSS; document.head.appendChild(st);
    box = el('div', 'hhc-b'); box.setAttribute('role', 'dialog'); box.setAttribute('aria-label', 'Trợ lý trả lời nhanh của anh Hoàng Hiệp');
    box.innerHTML = '<div class="hhc-h"><span class="hhc-av">HH</span><div><b>Trợ lý trả lời nhanh</b><small>của anh Hoàng Hiệp · Sun Spana Tower</small></div><button class="hhc-x" type="button" aria-label="Đóng">×</button></div>'
      + '<div class="hhc-log"></div>'
      + '<div class="hhc-q"><a class="z" href="' + ZALO + '" target="_blank" rel="noopener">Nhắn Zalo</a><a class="g" href="' + TEL + '">Gọi ' + SO + '</a></div>'
      + '<form class="hhc-i" autocomplete="off"><input type="text" name="hhc_msg" placeholder="Nhập câu hỏi hoặc số điện thoại…" aria-label="Nhập câu hỏi" enterkeyhint="send"><button type="submit">Gửi</button></form>';
    document.body.appendChild(box);
    log = box.querySelector('.hhc-log'); inp = box.querySelector('input');
    box.querySelector('.hhc-x').onclick = function () { box.classList.remove('on'); };
    box.querySelector('.hhc-i').addEventListener('submit', function (e) { e.preventDefault(); e.stopPropagation(); var v = inp.value.trim(); if (!v) return; inp.value = ''; ask(v); });
    /* Nút mở chat: dùng nút sẵn có trên trang (#cb-fab hoặc [data-hhc-open]); không có thì tạo nút tròn góc phải */
    var own = document.querySelectorAll('#cb-fab,[data-hhc-open]');
    if (own.length) { own.forEach(function (b) { b.addEventListener('click', function (e) { e.preventDefault(); e.stopImmediatePropagation(); toggle(); }, true); }); launcher = own[0]; }
    else {
      launcher = el('button', 'hhc-l', '<i></i><svg width="26" height="26" viewBox="0 0 24 24" fill="#fff" aria-hidden="true"><path d="M4 3h16a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H8l-4 4V5a2 2 0 0 1 2-2zm3 6v2h2V9H7zm4 0v2h2V9h-2zm4 0v2h2V9h-2z"/></svg>');
      launcher.type = 'button'; launcher.setAttribute('aria-label', 'Mở trợ lý trả lời nhanh'); launcher.onclick = toggle; document.body.appendChild(launcher);
    }
    /* Nút Gọi / Zalo nổi (máy tính) và thanh liên hệ dưới màn hình (điện thoại) */
    var PH = '<svg width="22" height="22" viewBox="0 0 24 24" fill="#fff" aria-hidden="true"><path d="M6.6 10.8a15.1 15.1 0 0 0 6.6 6.6l2.2-2.2a1 1 0 0 1 1-.25 11.4 11.4 0 0 0 3.6.57 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.45.57 3.57a1 1 0 0 1-.25 1z"/></svg>';
    var fl = el('div', 'hhc-fl', '<a class="z" href="' + ZALO + '" target="_blank" rel="noopener" aria-label="Nhắn Zalo ' + SO + '">Zalo</a><a class="g" href="' + TEL + '" aria-label="Gọi ' + SO + '">' + PH + '</a>');
    document.body.appendChild(fl);
    var mb = el('nav', 'hhc-mb', '<a href="' + TEL + '">Gọi ngay</a><a class="z" href="' + ZALO + '" target="_blank" rel="noopener">Zalo</a><a class="b" href="#" data-hhc-price>Bảng giá</a>');
    mb.setAttribute('aria-label', 'Liên hệ nhanh'); document.body.appendChild(mb);
    mb.querySelector('[data-hhc-price]').onclick = function (e) { e.preventDefault(); var f = document.querySelector('#dang-ky-cuoi,#dang-ky,form input[type=tel]'); if (f) { try { f.scrollIntoView({behavior: 'smooth', block: 'center'}); } catch (x) { f.scrollIntoView(); } } else open(); };
    /* Một lời mời nhẹ sau 25 giây, mỗi phiên một lần */
    nudge = el('div', 'hhc-n', '<button type="button" aria-label="Ẩn">×</button>Anh/Chị cần <b>bảng giá, vị trí, loại căn</b> Spana Tower? Em trả lời nhanh ạ.');
    if (own.length) nudge.style.bottom = '150px';
    document.body.appendChild(nudge);
    nudge.onclick = function (e) { if (e.target.tagName === 'BUTTON') { nudge.classList.remove('on'); return; } nudge.classList.remove('on'); open(); };
    watchDwell();
    if (!sget('hhc_nudged')) setTimeout(function () { if (!box.classList.contains('on') && !sget('hhc_nudged')) { sset('hhc_nudged', '1'); nudge.classList.add('on'); setTimeout(function () { nudge.classList.remove('on'); }, 15000); } }, 25000);
  }
  function toggle() { if (box.classList.contains('on')) box.classList.remove('on'); else open(); }
  function open() {
    nudge && nudge.classList.remove('on'); box.classList.add('on');
    if (!started) {
      started = true; var nn = nightNote();
      say('Dạ em chào Anh/Chị, em là trợ lý trả lời nhanh của anh Hoàng Hiệp về Sun Spana Tower ạ.\nAnh/Chị đang tìm căn để ở, cho thuê hay mua cho con ạ?' + (nn ? '\n(Giờ này ' + nn + '; em vẫn trả lời nhanh thông tin dự án.)' : ''), ['Vị trí dự án', 'Loại căn hộ']);
    }
    setTimeout(function () { try { inp.focus({preventScroll: true}); } catch (e) {} }, 250);
  }
  window.hhcOpen = open;

  /* ---------- Khách dừng lâu ở một phần trang: hỏi khéo, gợi 2 câu hỏi đúng phần đó ---------- */
  var DWELL = 7000, NUDGE_MAX = 3, NUDGE_GAP = 35000;
  var SECT = [
    {k: ['vi tri', 'cua ngo'], t: 'Anh/Chị đang xem vị trí ạ? Nhiều khách hỏi em mấy câu này:', q: ['Từ sân bay tới dự án bao xa?', 'Khu Hòa Xuân có ngập không?']},
    {k: ['diem noi bat', 'vi sao chon'], t: 'Anh/Chị muốn hiểu kỹ hơn điểm nào ạ?', q: ['Khu Hòa Xuân có ngập không?', 'Sở hữu lâu dài hay 50 năm?']},
    {k: ['thiet ke', 'loai can'], t: 'Anh/Chị đang chọn loại căn ạ? Em gợi ý nhanh:', q: ['Có những loại căn nào?', 'Mỗi hướng căn nhìn ra gì?']},
    {k: ['tien ich'], t: 'Anh/Chị đang xem tiện ích ạ? Khách hay hỏi:', q: ['Trong tòa có hồ bơi, gym không?', 'Gần trường học, bệnh viện không?']},
    {k: ['chinh sach'], t: 'Phần chính sách em giải thích nhanh được ạ:', q: ['Vay ngân hàng, hỗ trợ lãi suất thế nào?', 'Tiến độ thanh toán thế nào?']},
    {k: ['phap ly', 'tien do', 'cong truong'], t: 'Phần pháp lý, tiến độ nhiều khách hỏi kỹ lắm ạ:', q: ['Sở hữu lâu dài hay 50 năm?', 'Khi nào bàn giao?']},
    {k: ['tong quan'], t: 'Anh/Chị cần em tóm tắt nhanh gì không ạ?', q: ['Giá bao nhiêu?', 'Còn căn trống không?']}
  ];
  var asked = {}, idleT = null, idleN = 0, nudge2, dwellT = null, nudgeN = 0, lastNudge = 0, loadAt = Date.now();
  function openWith(q) {
    nudge2 && nudge2.classList.remove('on'); nudge && nudge.classList.remove('on'); box.classList.add('on');
    if (!started) { started = true; say('Dạ em chào Anh/Chị, em là trợ lý trả lời nhanh của anh Hoàng Hiệp về Sun Spana Tower ạ.'); }
    ask(q);
  }
  function busy() {
    var a = document.activeElement;
    return box.classList.contains('on') || (a && /INPUT|TEXTAREA|SELECT/.test(a.tagName)) || Date.now() - loadAt < 8000;
  }
  function showNudge(rule) {
    var qs = rule.q.filter(function (q) { return !asked[norm(q)]; }); if (!qs.length) return;
    nudge2.innerHTML = '';
    var x = el('button', 'hhc-nx', '×'); x.type = 'button'; x.setAttribute('aria-label', 'Ẩn'); x.onclick = function () { nudge2.classList.remove('on'); };
    var p = el('p'); p.textContent = rule.t; var w = el('div', 'hhc-c');
    qs.slice(0, 2).forEach(function (q) { var b = el('button'); b.type = 'button'; b.textContent = q; b.onclick = function () { openWith(q); }; w.appendChild(b); });
    nudge2.appendChild(x); nudge2.appendChild(p); nudge2.appendChild(w);
    nudge && nudge.classList.remove('on'); nudge2.classList.add('on');
    nudgeN++; lastNudge = Date.now(); sset('hhc_nudged', '1'); sset('hhc_nn', String(nudgeN));
    clearTimeout(nudge2.hideT); nudge2.hideT = setTimeout(function () { nudge2.classList.remove('on'); }, 14000);
  }
  function ruleFor(sec) {
    if (sec.__hhcRule !== undefined) return sec.__hhcRule;
    var ey = sec.querySelector('.ey'), h = sec.querySelector('h2'), r = null;
    var full = norm((ey ? ey.textContent : '') + ' ' + (h ? h.textContent : ''));
    function find(n) { for (var i = 0; i < SECT.length; i++) for (var j = 0; j < SECT[i].k.length; j++) if (n.indexOf(' ' + SECT[i].k[j] + ' ') > -1) return SECT[i]; return null; }
    if (!/^ (dang ky nhan|tom tat|hoi dap|nhan bang gia|tim hieu them)/.test(norm(ey && ey.textContent.trim() ? ey.textContent : (h ? h.textContent : '')))) r = (ey && find(norm(ey.textContent))) || find(full);
    return (sec.__hhcRule = r);
  }
  function watchDwell() {
    if (!('IntersectionObserver' in window)) return;
    nudge2 = el('div', 'hhc-n2'); nudge2.setAttribute('role', 'status'); document.body.appendChild(nudge2);
    nudgeN = +(sget('hhc_nn') || 0);
    var seen = {}; try { seen = JSON.parse(sget('hhc_secs') || '{}'); } catch (e) {}
    var cur = null, inView = [];
    function track(sec) {
      if (cur === sec) return; cur = sec; clearTimeout(dwellT);
      if (sec) dwellT = setTimeout(function () { fire(sec, ruleFor(sec)); }, DWELL);
    }
    var io = new IntersectionObserver(function (es) {
      es.forEach(function (e) {
        var i = inView.indexOf(e.target);
        if (e.isIntersecting) { if (i < 0) inView.push(e.target); } else if (i > -1) inView.splice(i, 1);
      });
      track(inView.length ? inView[inView.length - 1] : null);
    }, {rootMargin: '-45% 0px -45% 0px'});
    function fire(sec, r) {
      var key = r.t; if (seen[key] || nudgeN >= NUDGE_MAX || Date.now() - lastNudge < NUDGE_GAP) return;
      if (busy()) { dwellT = setTimeout(function () { if (cur === sec) fire(sec, r); }, 4000); return; }
      seen[key] = 1; sset('hhc_secs', JSON.stringify(seen)); showNudge(r);
    }
    document.querySelectorAll('section').forEach(function (sc) { if (ruleFor(sc)) io.observe(sc); });
  }

  /* ---------- Đang chat mà khách im lâu: nhắc nhẹ, gợi thêm câu hỏi (tối đa 2 lần) ---------- */
  var IDLE_Q = ['Giá bao nhiêu?', 'Sở hữu lâu dài hay 50 năm?', 'Vay ngân hàng, hỗ trợ lãi suất thế nào?', 'Từ sân bay tới dự án bao xa?', 'Có những loại căn nào?', 'Còn căn trống không?', 'Khi nào bàn giao?'];
  function armIdle() {
    clearTimeout(idleT);
    if (idleN >= 2 || outq.length) return;
    idleT = setTimeout(function () {
      if (!box.classList.contains('on') || inp.value.trim() || talking) return;
      var qs = IDLE_Q.filter(function (q) { return !asked[norm(q)]; }); if (qs.length < 2) return;
      idleN++;
      say(pick(['Dạ Anh/Chị cứ thong thả xem ạ. Nhiều khách cũng hay hỏi thêm mấy câu này, Anh/Chị bấm là em trả lời liền:', 'Dạ em vẫn ở đây ạ. Anh/Chị còn băn khoăn gì cứ hỏi em, ví dụ:']), qs.slice(0, 2));
    }, 45000);
  }

  /* ---------- Hội thoại ---------- */
  var lastHook = null, convo = [], turn = 0, lastAsk = -9, refused = false, phone = '', name = '', topics = [], miss = 0, told = {}, used = {}, lastQ = '';
  function transcript() { var s = convo.join('\n'); return s.length > 6000 ? '…' + s.slice(-6000) : s; }
  function addTopic(t) { if (t && topics.indexOf(t) < 0) topics.push(t); }
  function variant(it) { var n = it.a.length, i = ((used[it.id] == null ? Math.floor(Math.random() * n) - 1 : used[it.id]) + 1) % n; used[it.id] = i; return it.a[i]; }
  function notifyOnce(kind, d) { if (told[kind] || sget('hhc_told_' + kind)) return; told[kind] = 1; sset('hhc_told_' + kind, '1'); lead(Object.assign({phone: phone, name: name, interest: topics.join(', '), hoi_thoai: transcript()}, d)); }
  function urgent(why) { notifyOnce('human', {thong_bao: 'Khách trên trang Sun Spana ' + why, yeu_cau: '⚠️ KHÁCH MUỐN NÓI CHUYỆN VỚI NGƯỜI THẬT – vào hỗ trợ ngay', cau_hoi: lastQ}); }
  function findName(t) {
    var m = t.match(/(?:tên(?: tôi| em| mình| anh| chị)?(?: là)?|tôi là|mình là|em là|anh là|chị là|ten(?: toi| em| minh)?(?: la)?|toi la|minh la)\s+([A-Za-zÀ-ỹĐđ]+(?:\s+[A-Za-zÀ-ỹĐđ]+){0,3})/i);
    if (!m) return '';
    if (/^(ai|gì|gi|khách|khach|người|nguoi|bot|máy|may|trợ|tro)(\s|$)/i.test(m[1])) return '';
    var n = m[1].replace(/\s+(ạ|a|nhé|nhe|nha|đây|day)$/i, '').trim();
    return n.length >= 2 && n.length <= 40 ? n.replace(/(^|\s)\S/g, function (c) { return c.toUpperCase(); }) : '';
  }
  /* Tìm số điện thoại trong câu: {ok: số} | {bad: true} | null */
  function findPhone(t) {
    var groups = String(t).match(/\+?\d[\d\s.\-]{4,16}\d/g); if (!groups) return null;
    var phoneWord = /(số|so|sđt|sdt|zalo|điện thoại|dien thoai|đt|liên hệ|lien he)\s*[:\-]?\s*(của )?(tôi|toi|em|mình|minh|anh|chị|chi)?\s*(là|la)?\s*[:\-]?\s*\+?\d/i.test(t);
    for (var i = 0; i < groups.length; i++) {
      var g = groups[i], dg = g.replace(/\D/g, ''), p = normPhone(g);
      if (p) return {ok: p};
      if ((dg.length >= 8 && dg.length <= 13) || (dg.length >= 6 && (dg.charAt(0) === '0' || phoneWord))) return {bad: dg};
    }
    return null;
  }
  function sendChatLead() {
    var r = lead({name: name, phone: phone, interest: 'Chat tư vấn' + (topics.length ? ' – ' + topics.join(', ') : ''), cau_hoi: lastQ, hoi_thoai: transcript()});
    return r;
  }

  function ask(q) {
    var raw = String(q).slice(0, 500);
    bubble(raw, 'me'); convo.push('Khách: ' + raw); turn++; clearTimeout(idleT); asked[norm(raw)] = 1;
    var n = norm(ALIAS[raw] || raw);
    var nm = findName(raw); if (nm) name = nm;

    /* 1. Số điện thoại */
    var f = findPhone(raw);
    if (f && f.ok === '0904567009') { say('Dạ ' + SO + ' là số của anh Hoàng Hiệp ạ. Anh/Chị gõ số của mình để anh Hiệp gọi lại nhé.'); return; }
    if (f && f.ok) {
      if (phone === f.ok) { say('Dạ em đã có số ' + f.ok + ' rồi ạ, anh Hiệp sẽ liên hệ mình sớm.'); return; }
      phone = f.ok; var r = sendChatLead(), nn = nightNote();
      say('Dạ em cảm ơn ' + (name ? 'Anh/Chị ' + name : 'Anh/Chị') + ', em đã chuyển số ' + phone + ' cho anh Hiệp ạ.\n' + (nn ? 'Giờ này hơi muộn, ' + nn + ' qua Zalo nhé ạ.' : 'Anh Hiệp sẽ liên hệ qua Zalo trong ít phút ạ.') );
      return;
    }
    if (f && f.bad) { say(pick(['Dạ số ' + f.bad + ' hình như chưa đúng ạ, số di động cần 10 số, ví dụ 0904 567 009. Anh/Chị kiểm tra giúp em nhé.', 'Dạ em chưa nhận được số này ạ, Anh/Chị gõ lại giúp em số 10 chữ số (ví dụ 0904 567 009) nhé.'])); return; }
    lastQ = raw;

    /* 2. Báo "khách đang chat" từ tin thứ 2 khi chưa có số */
    if (!phone && turn >= 2) notifyOnce('chat', {thong_bao: 'Khách đang chat trên trang Sun Spana (chưa để số)'});

    /* 3. Văng tục */
    if (isBad(n)) { urgent('đang bức xúc'); miss = 0; say(pick(['Dạ em xin lỗi nếu em trả lời chưa đúng ý Anh/Chị ạ. Em đã báo anh Hiệp, Anh/Chị gọi ' + SO + ' để anh hỗ trợ trực tiếp nhé.', 'Dạ em thành thật xin lỗi Anh/Chị ạ. Em chuyển anh Hiệp liên hệ mình ngay, hoặc Anh/Chị gọi thẳng ' + SO + '.'])); return; }

    /* 4. Khách trả lời ngắn "có/không" cho câu gợi mở vừa rồi */
    var words = n.trim().split(' ').length, hk = lastHook; lastHook = null;
    if (hk && words <= 4 && AFF.test(n) && !NEG.test(n)) {
      if (hk === 'lead') { say(pick(['Dạ Anh/Chị gõ số Zalo vào ô bên dưới giúp em, em chuyển anh Hiệp gửi ngay ạ.', 'Dạ vâng ạ, Anh/Chị cho em xin số Zalo ở ô bên dưới, anh Hiệp gửi trong ít phút ạ.'])); return; }
      for (var x = 0; x < KB.length; x++) if (KB[x].id === hk) { respond(KB[x]); return; }
    }
    if (hk && words <= 3 && NEG.test(n)) {
      if (hk === 'lead') lastAsk = turn;
      say(pick(['Dạ vâng ạ, Anh/Chị cần thông tin gì cứ hỏi em nhé.', 'Dạ không sao ạ. Anh/Chị muốn tìm hiểu thêm phần nào ạ?']), ['Vị trí dự án', 'Loại căn hộ']); return;
    }
    if (!hk && words <= 2 && AFF.test(n) && !NEG.test(n)) { say(pick(['Dạ vâng ạ. Anh/Chị muốn em gửi thêm phần nào: vị trí, loại căn hay bảng giá ạ?', 'Dạ em đây ạ. Anh/Chị cần em nói thêm về vị trí, loại căn hay tiện ích ạ?']), ['Loại căn hộ', 'Giá bán']); return; }
    if (!hk && words <= 2 && NEG.test(n)) { say('Dạ vâng ạ, Anh/Chị cần thông tin gì cứ hỏi em nhé.', ['Vị trí dự án', 'Loại căn hộ']); return; }
    /* 5. Tìm ý */
    var best = null, score = 0;
    KB.forEach(function (it) { var sc = 0; it.k.forEach(function (k) { if (has(n, k)) sc += k.length + 2; }); if (sc > score) { score = sc; best = it; } });
    if (!best || score < 3) {
      miss++;
      if (miss >= 2) { miss = 0; say('Dạ câu này em xin chuyển anh Hiệp trả lời cho chính xác ạ. Anh/Chị nhắn Zalo ' + SO + ' hoặc để lại số, anh Hiệp phản hồi ngay.', []); return; }
      say(pick(['Dạ em chưa rõ ý Anh/Chị lắm ạ. Anh/Chị đang muốn hỏi về vị trí, loại căn hay giá ạ?', 'Dạ Anh/Chị nói rõ hơn giúp em một chút được không ạ, ví dụ "từ sân bay bao xa" hay "có mấy loại căn"?']), ['Vị trí dự án', 'Loại căn hộ']);
      return;
    }
    respond(best);
  }

  function respond(best) {
    miss = 0; addTopic(best.topic);
    if (best.refuse) refused = true;
    if (best.human) urgent('muốn nói chuyện với người thật');
    var txt = variant(best), asked = false;
    if (best.human) { var nn2 = nightNote(); if (nn2) txt += '\nGiờ này ' + nn2 + ' ạ.'; }
    /* Xin số khéo: đúng chủ đề, cách 3 lượt, khách từ chối thì thôi */
    if (best.ask && !phone && !refused && turn - lastAsk >= 3 && (best.strong || turn >= 2)) { lastAsk = turn; txt += '\n' + best.ask; asked = true; }
    /* Chưa hỏi lại khách thì mở tiếp câu chuyện thứ hai */
    else if (!/\?\s*$/.test(txt) && HOOK[best.id]) {
      var hs = HOOK[best.id].filter(function (h) { return h[0] && (h[1] !== 'lead' || (!phone && !refused && turn - lastAsk >= 2)); });
      if (hs.length) { var h = pick(hs); txt += '\n' + h[0]; lastHook = h[1] || null; if (h[1] === 'lead') lastAsk = turn; }
    }
    if (asked) lastHook = 'lead';
    say(txt, best.c);
  }

  /* ---------- Form trên trang: gửi 3 nơi, không tải lại trang, cảm ơn tại form ---------- */
  var LABEL = {nhu_cau: 'Loại căn', muc_dich: 'Mục đích', ngan_sach: 'Ngân sách', so_thich: 'Thích', loai_can: 'Loại căn', cau_hoi: 'Câu hỏi', so_nguoi: 'Số người'};
  function isLadi(fm) { return !!(fm.closest && fm.closest('.ladi-form')); }
  function toast(t) {
    var d = el('div'); d.textContent = t;
    d.style.cssText = 'position:fixed;left:50%;bottom:90px;transform:translateX(-50%);z-index:99995;max-width:92vw;background:#0B7A43;color:#fff;font-weight:600;font-size:15px;line-height:1.45;padding:12px 18px;border-radius:12px;box-shadow:0 12px 30px rgba(0,0,0,.25);text-align:center';
    document.body.appendChild(d); setTimeout(function () { d.remove(); }, 6000);
  }
  /* Form LadiPage (trang kéo-thả): để LadiPage tự xử lý, chỉ gửi thêm 3 nơi, không chặn */
  function grabLadi(fm) {
    var tel = fm.querySelector('input[type=tel],input[name=phone]'); if (!tel) return;
    var ph = normPhone(tel.value); if (!ph) return;
    var nmEl = fm.querySelector('input[name=name]'), nmv = nmEl ? nmEl.value.trim().slice(0, 60) : '', parts = [];
    fm.querySelectorAll('select,textarea').forEach(function (x) { var v = x.tagName === 'SELECT' ? (x.value && x.options[x.selectedIndex] ? x.options[x.selectedIndex].text : '') : x.value.trim(); if (v) parts.push((LABEL[x.name] || x.name || 'Ghi chú') + ': ' + v); });
    var r = lead({name: nmv, phone: ph, interest: 'Form LadiPage' + (parts.length ? ' · ' + parts.join(' · ') : ''), yeu_cau: parts.join(' · '), hoi_thoai: convo.length ? transcript() : ''});
    if (nmv && !name) name = nmv; phone = phone || ph;
    if (r === 'ok') { var nn = nightNote(); toast('Cảm ơn ' + (nmv || 'Anh/Chị') + '! Anh Hiệp sẽ gửi tài liệu qua Zalo ' + ph + (nn ? ' – ' + nn + '.' : ' trong ít phút.')); }
  }
  document.addEventListener('click', function (e) {
    var t = e.target, fm = t && t.closest && t.closest('.ladi-form'); if (!fm) return;
    if (!t.closest('.ladi-button,button,[type=submit],[id^="BUTTON"]')) return;
    setTimeout(function () { grabLadi(fm); }, 0);
  }, true);
  document.addEventListener('submit', function (e) {
    var fm = e.target; if (!fm || !fm.querySelector || fm.classList.contains('hhc-i')) return;
    if (isLadi(fm)) { grabLadi(fm.closest('.ladi-form')); return; }
    var tel = fm.querySelector('input[type=tel],[name=phone]'); if (!tel) return;
    e.preventDefault(); e.stopImmediatePropagation();
    var ph = normPhone(tel.value), nmEl = fm.querySelector('[name=name]');
    if (!ph) {
      tel.focus();
      if (tel.setCustomValidity) { tel.setCustomValidity('Số điện thoại cần 10 số, ví dụ 0904 567 009'); if (tel.reportValidity) tel.reportValidity(); tel.addEventListener('input', function () { tel.setCustomValidity(''); }, {once: true}); }
      return;
    }
    var parts = [];
    fm.querySelectorAll('select,textarea').forEach(function (x) { var v = x.tagName === 'SELECT' ? (x.value && x.options[x.selectedIndex] ? x.options[x.selectedIndex].text : '') : x.value.trim(); if (v) parts.push((LABEL[x.name] || x.name || 'Ghi chú') + ': ' + v); });
    var btn = fm.querySelector('[type=submit],button'), nmv = nmEl ? nmEl.value.trim().slice(0, 60) : '';
    if (nmv && !name) name = nmv;
    lead({name: nmv, phone: ph, interest: 'Form ' + (fm.getAttribute('data-form') || (btn ? btn.textContent.trim() : 'đăng ký')) + (parts.length ? ' · ' + parts.join(' · ') : ''), yeu_cau: parts.join(' · '), hoi_thoai: convo.length ? transcript() : ''});
    phone = phone || ph;
    if (btn) { btn.disabled = true; btn.textContent = 'Đã gửi ✓'; }
    var ok = fm.querySelector('.hhc-ok') || fm.parentNode.querySelector('.hhc-ok');
    if (!ok) { ok = el('p', 'hhc-ok'); fm.appendChild(ok); }
    var nn = nightNote();
    ok.textContent = 'Cảm ơn ' + (nmv || 'Anh/Chị') + '! Anh Hiệp sẽ gửi tài liệu qua Zalo ' + ph + (nn ? ' – ' + nn + '.' : ' trong ít phút.');
  }, true);

  /* Dự phòng khi khách đóng trang: nếu có số mà chưa gửi được thì gửi nốt */
  window.addEventListener('pagehide', function () { if (phone && !wasSent(phone)) sendChatLead(); });

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', build); else build();
})();

