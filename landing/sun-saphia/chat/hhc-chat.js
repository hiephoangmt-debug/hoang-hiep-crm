/* Sun Saphia Residence – Trợ lý trả lời nhanh của anh Hoàng Hiệp.
 * Một tệp dùng chung cho 3 trang LadiPage: chat tự động + gửi khách về Telegram, CRM Hoàng Hiệp, email.
 * Gắn: dán nguyên tệp vào một thẻ script ngay trước thẻ đóng body.
 * Chỉ dùng thông tin dự án đã được duyệt bên dưới (KB); không nêu giá, không hứa lợi nhuận.
 */
(function () {
  if (window.__hhc) return; window.__hhc = 1;

  /* ---------- Cấu hình ---------- */
  var TG = 'https://script.google.com/macros/s/AKfycbwvmG1HMtrQOeUXCuBJ6CHmMb4TcCZ53_n5lwPAt3-6-lG2_fIRX0q25Rv-6LPwVWXZHw/exec?key=sft-tg-4821';
  var CRM = 'https://script.google.com/macros/s/AKfycbyChbG-uvItjVlRk7JgLrwpUS6Cgah4nIA6BWHuEwgbXBqSlvAPJNSdZdp6pQ91d_rN/exec?key=kGYgRtNhbHZr';
  var MAIL = 'https://formsubmit.co/ajax/hiephoangmt@gmail.com';
  var PROJECT = 'Sun Saphia Residence';
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
    postMail(Object.assign({_subject: 'Khách Sun Saphia: ' + (d.name || 'chưa rõ tên') + ' - ' + ph, _template: 'table', _captcha: 'false'}, d));
    try { if (window.gtag) gtag('event', 'generate_lead', {event_label: d.interest || ''}); } catch (e) {}
    try { if (window.gtag && window.HHC_ADS_SEND_TO) gtag('event', 'conversion', {send_to: window.HHC_ADS_SEND_TO}); } catch (e) {}  // Google Ads: Sun Saphia – Gửi form
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
  var EVT_ON = Date.now() < Date.parse('2026-11-01T11:30:00+07:00');
  var KB = [
    {id: 'chao', k: ['chao', 'xin chao', 'hello', 'hi', 'alo', 'co ai khong', 'anh oi', 'chi oi', 'em oi'],
      a: ['Dạ em chào Anh/Chị ạ. Anh/Chị đang quan tâm Sun Saphia để ở, nghỉ dưỡng hay cho thuê ạ?', 'Dạ em đây ạ. Anh/Chị muốn xem giá, vị trí hay loại căn trước ạ?'], c: ['Vị trí dự án', 'Loại căn hộ']},
    {id: 'gia', k: ['gia', 'bang gia', 'bao nhieu tien', 'gia ban', 'gia ca', 'muc gia', 'tong gia', 'gia studio', 'gia can', 'bao nhieu 1 m2', 'tren m2', 'bao nhieu ty', 'gia bao nhieu', 'bao nhieu mot can', 'bao nhieu 1 can'],
      a: ['Dạ chủ đầu tư chưa công bố giá nên em chưa báo con số nào ạ, nhưng em nghĩ giá cũng sẽ hợp lý để Anh/Chị đầu tư thôi ạ.\nHiện mình đặt chỗ 50 triệu, hoàn lại 100% nếu không mua, để được ưu tiên chọn căn đẹp trước khi mở bán.\nAnh/Chị đang nghiêng về Studio, 1BR+ hay 2BR ạ?', 'Dạ bảng giá chủ đầu tư chưa công bố ạ, giá sẽ tuỳ tầng, hướng và tầm nhìn. Em nghĩ mức giá cũng sẽ hợp lý để Anh/Chị đầu tư ạ.\nAnh/Chị cho em biết dòng căn quan tâm, có giá em gửi đúng căn đó trước nhé?'],
      c: ['Studio', '2BR'], ask: 'Anh/Chị để lại số Zalo, chủ đầu tư công bố là em gửi bảng giá ngay ạ.', strong: 1, topic: 'Giá bán'},
    {id: 'dat', k: ['dat qua', 'mac qua', 'cao qua', 'dat the', 'dat vay', 'dat lam', 'chat qua', 'sao dat', 'gia cao', 'khong du tien', 'it tien', 'von it', 'von nho'],
      a: ['Dạ em hiểu ạ, số tiền lớn thì mình cân nhắc kỹ là đúng. Saphia chưa công bố giá nên con số Anh/Chị nghe được có thể chưa đúng ạ.\nNếu so đúng phân khúc căn hộ mặt biển Đà Nẵng đang bán (số liệu Kick-off): Studio The Soleil khoảng 5,2–5,5 tỷ, Nobu 6,3–6,4 tỷ, Futa 9,1–10,5 tỷ. So với căn trong phố thì chưa công bằng ạ.', 'Dạ chi phí là chuyện cần tính kỹ ạ. Mua căn hộ không phải bỏ hết một lần: thường đóng giãn theo tiến độ khoảng 2 năm tới bàn giao, hoặc tự bỏ khoảng 25% rồi vay ngân hàng. Studio 30–31 m² là dòng vốn vào nhẹ nhất.\nTầm ngân sách Anh/Chị thấy thoải mái là bao nhiêu ạ, để em xem căn nào vừa nhất?'],
      c: ['Studio', 'Cho thuê'], ask: 'Anh/Chị cho em xin số Zalo, có giá em tính sẵn theo ngân sách của mình ạ.', topic: 'Lo về giá / ngân sách'},
    {id: 'sukien', k: ['su kien', 'ra mat', 'hilton', 'thu moi', 'dang ky tham du', 'tham du', 'event', 'agenda', 'chuong trinh su kien', 'boc tham', 'anh duong', 'giu thu moi'],
      a: EVT_ON ? ['Dạ sự kiện ra mắt "Chạm nhịp Ánh Dương – Bừng sáng vị thế" diễn ra 9:00 Chủ nhật 01/11/2026 tại khách sạn Hilton Đà Nẵng (50 Bạch Đằng) ạ.\nĐây là lần đầu chủ đầu tư giới thiệu đầy đủ dự án, và từ 10:18 chính thức nhận booking – ai có mặt thường được tư vấn chọn căn trước. Cuối chương trình còn bốc thăm may mắn nữa ạ.\nAnh/Chị có muốn em giữ cho mình một thư mời không ạ?', 'Dạ Chủ nhật 01/11 này, 9:00, Sun Property ra mắt Sun Saphia tại Hilton Đà Nẵng ạ. Có một khung em nghĩ Anh/Chị sẽ quan tâm: 10:18 – 11:00 chính thức nhận booking và tư vấn chuyên sâu, căn view biển đẹp thường được chọn ngay trong buổi này.\nThư mời có số lượng, Anh/Chị muốn em đăng ký trước cho mình không ạ?'] : ['Dạ sự kiện ra mắt Sun Saphia đã diễn ra sáng 01/11/2026 tại Hilton Đà Nẵng và chủ đầu tư đã chính thức nhận booking ạ. Anh Hiệp đang giữ bản tổng hợp thông tin công bố hôm đó và danh sách căn còn trống.'],
      c: ['Không đi được', 'Booking thế nào'], ask: 'Anh/Chị để lại Zalo, em gửi bản tổng hợp sự kiện và căn còn trống ạ.', hk: 'skmoi', topic: 'Sự kiện ra mắt 01/11'},
    {id: 'skno', k: ['khong di duoc', 'khong tham du', 'khong den duoc', 'khong toi duoc', 'khong ra duoc', 'khong ranh', 'khong co thoi gian', 'chu nhat ban', 'hom do ban', 'ngay do ban', 'ban hom do', 'khong o da nang', 'khong kip', 'khong thich su kien', 'ngai di', 'ngai dong', 'khong muon di', 'chac khong di', 'chu nhat minh ban', 'chu nhat ban roi', 'cuoi tuan ban', 'hom do co viec', 'co viec roi', 'ban viec', 'khong sap xep duoc', 'vang mat', 'khong di', 'o xa khong di'],
      a: ['Dạ không sao ạ, nhiều khách ở xa hay bận cũng như Anh/Chị. Không đến được vẫn không thiệt đâu ạ: ngay chiều 01/11 anh Hiệp gửi riêng cho mình trọn bộ thông tin công bố tại sự kiện (chính sách, mặt bằng, căn còn trống).', 'Dạ em hiểu ạ, không phải ai cũng sắp xếp được đúng ngày đó. Anh/Chị không cần có mặt vẫn giữ được ưu tiên: em ghi tên mình vào danh sách nhận thông tin ngay sau sự kiện, căn view đẹp còn trống anh Hiệp báo trước để mình cân nhắc, không phải chen ở hội trường ạ.'],
      c: ['Booking thế nào', 'Giá bán'], ask: 'Anh/Chị để lại số Zalo, chiều 01/11 em gửi Anh/Chị bản tóm tắt sự kiện trước tiên ạ.', strong: 1, topic: 'Không dự được sự kiện – nhận tin sau'},
    {id: 'mbtang', k: ['mat bang tang', 'moi tang', 'may can mot tang', 'bao nhieu can mot tang', 'tang 30', 'tang cao nhat', 'tang tren cung', 'tang 29', 'tang 2', 'tang 3', 'ban cong lon', 'san vuon', 'can co ban cong', 'layout tang', 'tang dien hinh', '1br'],
      a: ['Dạ tòa Saphia có 5 kiểu tầng ạ: tầng 2 (12 căn, cùng tầng hồ bơi và Gym + Yoga), tầng 3 (28 căn, nhiều căn ban công lớn tới 53–84 m²), tầng 3A–28 (25 tầng, 28 căn/tầng), tầng 29 (26 căn, có vườn trên mái) và tầng 30 (16 căn lớn, có dòng 1BR 63–74 m² chỉ tầng này có).\nAnh/Chị thích tầng thấp có ban công rộng hay tầng cao nhìn xa ạ?', 'Dạ điểm hiếm em hay gợi ý: tầng 3 có Studio ban công 53,71 m² và 2BR ban công 84,29 m², còn tầng 30 chỉ 16 căn, rộng nhất là 2BR 83,97 m². Mặt bằng từng tầng có trên trang Mặt bằng ạ.\nAnh/Chị đang nghiêng về tầng nào để em lọc căn ạ?'],
      c: ['Loại căn hộ', 'Giá bán'], ask: 'Anh/Chị để lại Zalo, em gửi mặt bằng tầng Anh/Chị quan tâm kèm căn còn trống ạ.', topic: 'Mặt bằng tầng'},
    {id: 'vitri', k: ['vi tri', 'o dau', 'dia chi', 'cho nao', 'duong nao', 'khu nao', 'nam o', 'ban do', 'map', 'toa lac', 'phuong nao', 'quan nao'],
      a: ['Dạ dự án ở giao lộ Võ Nguyên Giáp – Trường Sa – Nguyễn Đức Thuận, mặt tiền trục đường biển; ra biển Sơn Thủy – Mỹ Khê khoảng 400 m, ở giữa là công viên ạ.\nAnh/Chị đang ở Đà Nẵng hay ở xa ạ? Anh/Chị nhớ chỗ nào nhất: sân bay, cầu Rồng, Ngũ Hành Sơn hay Hội An, để em chỉ theo đó cho dễ hình dung?', 'Dạ Sun Saphia nằm góc Võ Nguyên Giáp – Trường Sa – Nguyễn Đức Thuận, mặt tiền trục đường biển, ngay dải resort Furama, Hyatt, Sheraton; qua công viên khoảng 400 m là tới bãi biển Sơn Thủy – Mỹ Khê ạ.\nAnh/Chị biết chỗ nào ở Đà Nẵng nhất, sân bay hay cầu Rồng, để em chỉ đường theo đó ạ?'],
      c: ['Từ sân bay', 'Từ cầu Rồng', 'Đi Hội An'], ask: 'Anh/Chị để lại Zalo, em gửi bản đồ và video vị trí thực tế ạ.', topic: 'Vị trí'},
    {id: 'sanbay', k: ['san bay', 'tu san bay', 'xuong may bay', 'ha canh', 'nha ga san bay', 'san bay da nang'],
      a: ['Dạ từ sân bay Đà Nẵng chạy khoảng 15–20 phút là tới Saphia ạ (khoảng 8 km, tuỳ giờ). Đi ra đường biển rồi xuôi về phía Hội An, dự án nằm ngay bãi tắm Sơn Thủy, gần resort Furama và Hyatt.'],
      c: ['Từ cầu Rồng', 'Đi Hội An'], topic: 'Vị trí'},
    {id: 'caurong', k: ['cau rong', 'cau song han', 'song han', 'cho han', 'trung tam', 'xa trung tam', 'gan trung tam', 'asia park', 'sun world', 'cau tran thi ly', 'tran thi ly', 'downtown da nang'],
      a: ['Dạ từ cầu Rồng chạy thẳng ra biển rồi xuôi về phía Hội An khoảng 15 phút là tới ạ (khoảng 6 km). Cách cầu Trần Thị Lý, Sun World Asia Park khoảng 4 km, chợ Hàn khoảng 7 km.\nĐủ gần để vào phố, đủ xa để yên tĩnh, biển ngay trước nhà ạ.'],
      c: ['Từ sân bay', 'Đi Hội An'], topic: 'Vị trí'},
    {id: 'hoian', k: ['hoi an', 'pho co', 'di hoi an', 'ba na', 'di ngu hanh son', 'toi ngu hanh son'],
      a: ['Dạ Saphia nằm đúng chỗ đường biển Võ Nguyên Giáp nối sang đường Trường Sa đi Hội An ạ: cách Ngũ Hành Sơn khoảng 3 km (~5 phút), phố cổ Hội An khoảng 25 km (~30 phút) theo đường biển, Bà Nà khoảng 35 km.'],
      c: ['Từ sân bay', 'Từ cầu Rồng'], topic: 'Vị trí'},
    {id: 'oxa', k: ['o xa', 'ngoai bac', 'ha noi', 'sai gon', 'tp hcm', 'ho chi minh', 'chua den da nang', 'chua toi da nang', 'chua ra da nang', 'chua di da nang', 'chua biet da nang', 'khong biet da nang', 'nuoc ngoai'],
      a: ['Dạ Anh/Chị hình dung thế này ạ: bay Hà Nội hoặc TP.HCM ra Đà Nẵng khoảng 1 tiếng 20 phút, xuống máy bay chạy 15–20 phút là tới. Dự án nằm trên con đường biển đẹp nhất Đà Nẵng nối từ trung tâm về Hội An, ngay đoạn có các resort 5 sao; trước mặt là biển, nhìn ngang là núi Ngũ Hành Sơn.'],
      c: ['Từ sân bay', 'Đi Hội An'], ask: 'Anh/Chị để lại Zalo, em gửi video và vị trí trên Google Maps để mình xem trước ạ.', topic: 'Vị trí'},
    {id: 'bien', k: ['bien', 'cach bien', 'xa bien', 'gan bien', 'ra bien', 'toi bien', 'den bien', 'di bien', 'bao xa', 'bao nhieu m', 'bao nhieu met', 'may m', 'may met', 'bao nhieu km', 'di bo', 'may phut', 'sat bien', 'mat bien', 'view bien', 'nhin bien', 'bai tam', 'tam bien', 'bai bien', 'my khe', 'son thuy'],
      a: ['Dạ từ dự án ra biển khoảng 400 m ạ, ở giữa là công viên ven biển, đi bộ vài phút là tới bãi Sơn Thủy – Mỹ Khê.\nCăn hướng Đông nhìn ra biển, tầng càng cao càng thoáng.', 'Dạ khoảng 400 m thôi ạ: băng qua công viên ven biển là tới bãi tắm Sơn Thủy – Mỹ Khê.\nTầng cao hướng Đông nhìn ra biển rất thoáng.'],
      c: ['Loại căn hộ', 'Vị trí dự án'], ask: 'Anh/Chị để lại Zalo, em gửi danh sách căn hướng biển khi có ạ.', topic: 'View biển'},
    {id: 'hatang', k: ['ha tang', 'quy hoach', 'xung quanh', 'gan do co gi', 'quanh du an', 'du an xung quanh', 'ket noi', 'galaxy', 'downtown', 'thap 69', '69 tang', 'tiem nang tang gia', 'dong luc tang gia'],
      a: ['Dạ quanh Sun Saphia đang có 4 quy hoạch lớn, em tóm tắt nhanh ạ:\n① Công viên công cộng 2,45 ha ngay trước dự án – đã phê duyệt (QĐ 2958/QĐ-UBND, hơn 47 tỷ).\n② Mở rộng trục biển Võ Nguyên Giáp – Trường Sa – Lạc Long Quân, vốn dự kiến 2.633 tỷ – thành phố xếp vào nhóm ưu tiên “luồng xanh”.\n③ Đường sắt đô thị sân bay – Hội An, ga cách dự án khoảng 500 m – đang ở bước đề xuất, nhà đầu tư dự kiến khởi công 2/2027.\n④ Công viên văn hóa lịch sử Ngũ Hành Sơn khoảng 92 ha, cách khoảng 2,5 km.\nCó sơ đồ và link nguồn từng dự án tại sun-saphia-residence.com/quy-hoach ạ.', 'Dạ điểm hay của khu này là hạ tầng bao quanh ạ: phía trước là công viên 2,45 ha đã duyệt, mặt tiền là trục biển sắp mở rộng (2.633 tỷ), cách 500 m là ga tàu điện đi sân bay – Hội An (đang đề xuất), và 2,5 km là công viên Ngũ Hành Sơn 92 ha.\nAnh/Chị xem sơ đồ đầy đủ ở sun-saphia-residence.com/quy-hoach nhé.'],
      c: ['Công viên trước dự án', 'Đường sắt đô thị'], ask: 'Anh/Chị để lại Zalo, em gửi sơ đồ quy hoạch bản nét và link nguồn từng dự án ạ.', strong: 1, topic: 'Quy hoạch quanh dự án'},
    {id: 'congvien', k: ['cong vien', 'hon ngoc a chau', 'huyen tran', 'chuoi bai tam', 'bai tam rieng', 'truoc du an', 'truoc mat la gi', 'phia truoc', 'dat trong', 'bai dat', 'khu dat truoc', 'chan view', 'xay chan', 'bi chan', 'co ai xay truoc'],
      a: ['Dạ ngay đối diện dự án, bên kia đường Trường Sa, là công viên công cộng ạ. Thành phố thu hồi khoảng 2,45 ha đất bỏ hoang của dự án Hòn Ngọc Á Châu, UBND TP đã phê duyệt dự án theo Quyết định 2958/QĐ-UBND, vốn ngân sách hơn 47 tỷ đồng, thực hiện 2025–2027.\nTheo bản vẽ phương án: 24.488 m², rộng khoảng 88 m, dài khoảng 272 m chạy thẳng từ đường Trường Sa ra biển – có quảng trường biển, thảm cỏ dã ngoại, khu vui chơi thiếu nhi, sân tập, bãi đỗ xe.\nNên khoảng trước mặt Saphia là không gian xanh công cộng, không phải tòa cao tầng chắn view ạ.', 'Dạ Anh/Chị yên tâm phần này ạ: khu đất trước Saphia đã được quy hoạch làm công viên công cộng 2,45 ha (QĐ 2958/QĐ-UBND, hơn 47 tỷ đồng), từ đường Trường Sa thẳng ra biển. Cả nhà băng qua công viên là tới bãi tắm, view biển giữ thoáng.\nBên cạnh còn dự án CLB thể thao biển & bãi tắm Sơn Thủy khoảng 3,1 ha đã có hồ sơ khảo sát được phê duyệt.\nBản vẽ và hồ sơ em để ở sun-saphia-residence.com/quy-hoach ạ.'],
      c: ['Mở rộng đường biển', 'Hướng view'], ask: 'Anh/Chị để lại Zalo, em gửi bản vẽ công viên và ảnh hồ sơ thực tế ạ.', strong: 1, topic: 'Công viên trước dự án'},
    {id: 'view', k: ['view', 'huong view', 'huong nhin', 'nhin ra', 'view song', 'song han', 'view nui', 'ngu hanh son', 'huong song', 'huong nui', 'nhin song', 'nhin nui', 'tam nhin', 'hoang hon', 'can goc'],
      a: ['Dạ Sun Saphia nhìn ra 4 hướng ạ: phía trước là biển Mỹ Khê – Sơn Thủy; bên trái là hướng trung tâm thành phố, dọc biển Mỹ Khê; bên phải là hướng Hội An, Ngũ Hành Sơn; phía sau (ngược hướng biển) là hướng sân bay, Hòa Xuân, sông Hàn. Căn góc nhìn được 2 hướng. Trên trang có mặt bằng tầng để Anh/Chị bấm chọn căn theo hướng ạ.'],
      c: ['Loại căn hộ', 'Hạ tầng xung quanh'], ask: 'Anh/Chị thích hướng biển, núi hay sông ạ? Để lại Zalo, em lọc căn đúng hướng khi có bảng hàng.', topic: 'Hướng view'},
    {id: 'thietke', k: ['thiet ke', 'kien truc', 'apsara', 'cham pa', 'champa', 'phong cach', 'ngoai that', 'mat dung', 'y tuong'],
      a: ['Dạ kiến trúc lấy cảm hứng "Vũ điệu Di sản" ạ: từ nghệ thuật điêu khắc Chăm Pa và hình tượng vũ nữ Apsara, tái hiện bằng ngôn ngữ đương đại. Chủ đầu tư muốn đây là một biểu tượng mới của Sun Group bên biển Đà Nẵng.'],
      c: ['Hướng view', 'Loại căn hộ'], ask: 'Anh/Chị để lại Zalo, em gửi phối cảnh dự án ạ.', topic: 'Thiết kế'},
    {id: 'thethao', k: ['kayak', 'sup', 'jetski', 'jet ski', 'luot van', 'the thao bien', 'choi bien', 'hoat dong bien', 'waterfront'],
      a: ['Dạ ngay trước dự án là biển phẳng, hợp chèo kayak, SUP đón bình minh và jetski ạ. Cùng chuỗi 3 công viên bãi tắm (Sơn Thủy, công viên đối diện dự án, Huyền Trân Công Chúa), sống ở đây là sống gắn với biển mỗi ngày.'],
      c: ['Tiện ích', 'Căn Studio'], ask: 'Anh/Chị để lại Zalo, em gửi video bãi biển trước dự án ạ.', topic: 'Thể thao biển'},
    {id: 'daily', k: ['dai ly', 'tatiland', 'tati land', 'tati', 'phan phoi', 'chinh thuc khong', 'ben nao ban', 'cong ty nao ban', 'mua o dau', 'f1', 'moi gioi'],
      a: ['Dạ anh Hiệp là Giám đốc kinh doanh TATILAND (Công ty CP Đầu tư Địa ốc TATI) ạ. TATILAND được Sun Property chứng nhận là đại lý phân phối chính thức dự án Sun Saphia Residence ngày 23/10/2026, nên bảng giá, chính sách và hợp đồng đều theo đúng quy trình chủ đầu tư.'],
      c: ['Giá bán', 'Pháp lý'], ask: 'Anh/Chị để lại Zalo, em gửi ảnh chứng nhận đại lý và bảng giá gốc khi công bố ạ.', strong: 1, topic: 'Đại lý chính thức'},
    {id: 'quymo', k: ['quy mo', 'bao nhieu tang', 'may tang', 'cao bao nhieu', 'bao nhieu can', 'may can', 'dien tich dat', 'tang ham', 'ham xe', 'dau xe', 'cho de xe'],
      a: ['Dạ dự án trên khu đất 3.720,1 m², gồm 30 tầng nổi và 2 tầng hầm, cao khoảng 114 m, tổng 782 căn ạ. Theo công bố tại Kick-off: Studio 513 căn, 1BR+ 108 căn, 2BR 133 căn; trần căn hộ cao 3,5 m; căn hộ bố trí từ tầng 3A đến 28.'], c: ['Loại căn hộ', 'Bàn giao'], topic: 'Quy mô'},
    {id: 'mbstudio', k: ['studio', 'can studio', 'mat bang studio', 'ban ve studio', 'studio co gi', 'studio rong', 'studio bo tri', 'studio may phong'],
      a: ['Dạ căn Studio bố trí gọn mà đủ ạ: logia ngoài cùng có chỗ máy giặt, phòng ngủ liền phòng khách trong một không gian mở, bếp chữ L có chỗ ăn, WC tách khu tắm đứng. Diện tích 30–31 m² (kích thước 3,8 × 9 m), trần cao 3,5 m.\nCăn này hợp cho thuê theo đêm, khách cặp đôi hay khách công tác ạ.', 'Dạ Studio 30–31 m² có logia (chỗ máy giặt), giường đôi và sofa chung một không gian, bếp chữ L, WC tách khu tắm đứng ạ. Trần cao 3,5 m.\nStudio có 513 căn, khoảng 2/3 dự án, dễ cho thuê nhất ạ.'],
      c: ['Cho thuê', 'Căn 1PN+'], ask: 'Anh/Chị để lại Zalo, em gửi bản vẽ Studio rõ nét kèm vị trí căn trên tầng ạ.', topic: 'Mặt bằng Studio'},
    {id: 'mb1pn', k: ['1pn+', '1br+', '1pn', '1br', '1 phong ngu', 'can 1pn', 'phong da nang', 'da nang phong', '1 ngu', 'mot phong ngu', 'can 1pn+'],
      a: ['Dạ căn 1PN+ có 2 kiểu ạ:\n• 1 phòng ngủ + phòng đa năng: phòng ngủ có bàn làm việc, thêm phòng đa năng kê giường đơn cho con hoặc làm phòng làm việc.\n• 2 phòng ngủ 1 vệ sinh: phòng đa năng kê được giường đôi thành phòng ngủ thứ hai, logia rộng hết chiều ngang căn.\nDòng 1BR+1 50–51 m² (6,2 × 9 m), 108 căn; cả hai đều có phòng khách, bếp với bàn ăn 4 ghế ạ.', 'Dạ 1PN+ là căn 1 phòng ngủ có thêm phòng đa năng ạ. Kiểu thường thì phòng đa năng làm phòng làm việc hoặc kê giường đơn; kiểu lớn thì kê được giường đôi, thành căn 2 phòng ngủ 1 vệ sinh.\nAnh/Chị ở mấy người để em gợi ý kiểu hợp ạ?'],
      c: ['Căn 2 phòng ngủ', 'Để ở'], ask: 'Anh/Chị để lại Zalo, em gửi bản vẽ 2 kiểu 1PN+ để mình so sánh ạ.', topic: 'Mặt bằng 1PN+'},
    {id: 'mb2pn', k: ['2 phong ngu', '2pn', '2br', '2 br', '2 ngu', 'hai phong ngu', 'can 2 phong', '2 phong ngu 1 ve sinh', '2pn 1wc', 'can rong', 'can lon', 'gia dinh 4', '4 nguoi', '3 nguoi'],
      a: ['Dạ cần 2 phòng ngủ thì Anh/Chị có 2 lựa chọn ạ:\n• Căn 1PN+ kiểu 2 phòng ngủ 1 vệ sinh: phòng đa năng kê được giường đôi, logia rộng hết ngang căn.\n• Dòng 2BR 60–70 m² (133 căn, kích thước 7,25 × 9,9 m), rộng hơn.\nGia đình 3–4 người ở đều thoải mái ạ.', 'Dạ có căn 1PN+ dạng 2 phòng ngủ 1 vệ sinh và dòng 2BR 60–70 m² (133 căn) ạ. Kiểu 1PN+ 2 phòng ngủ gọn hơn, 2BR rộng hơn cho gia đình có ông bà.\nAnh/Chị mua để ở hay cho thuê ạ?'],
      c: ['Để ở', 'Cho thuê'], ask: 'Anh/Chị để lại Zalo, em gửi bản vẽ căn 2 phòng ngủ và vị trí trên tầng ạ.', topic: 'Mặt bằng 2 phòng ngủ'},
    {id: 'loaican', k: ['loai can', 'dong can', 'can ho', 'studio', '1br', '1 br', '1pn', '1 phong ngu', '2br', '2 br', '2pn', '2 phong ngu', 'phong ngu', 'dien tich', 'm2', 'mat bang', 'rong bao nhieu', 'can nao'],
      a: ['Dạ có 3 dòng: Studio 30–31 m² (513 căn), 1BR+ 50–51 m² (108 căn; 1 phòng ngủ + phòng đa năng, có kiểu 2 phòng ngủ 1 vệ sinh) và 2BR 60–70 m² (133 căn) ạ. Trần cao 3,5 m, bàn giao hoàn thiện cơ bản.\nAnh/Chị mua để ở, nghỉ dưỡng hay cho thuê ạ?', 'Dạ dự án gồm Studio 30–31 m², 1BR+ 50–51 m² và 2BR 60–70 m²; Studio nhiều nhất, khoảng 2/3 dự án.\nAnh/Chị định ở hay cho thuê để em gợi ý dòng hợp ạ?'],
      c: ['Căn Studio', 'Căn 1PN+', 'Căn 2 phòng ngủ'], ask: 'Anh/Chị để lại Zalo, em gửi bản vẽ từng dòng căn ạ.', topic: 'Loại căn'},
    {id: 'o', k: ['de o', 'o lau dai', 'gia dinh', 'ca nha', 'cho con', 'bo me', 'nghi duong', 've huu', 'nha thu hai'],
      a: ['Dạ để gia đình ở hoặc nghỉ dưỡng thì 2BR 60–70 m² rộng rãi nhất; toà có hồ bơi tầng 3 và nhà trẻ ngay trong toà ạ.', 'Dạ nếu ở cùng gia đình, Anh/Chị xem dòng 2BR 60–70 m² trước ạ; ngay trong toà có nhà trẻ, hồ bơi tầng 3 và shop khối đế.'],
      c: ['Tiện ích', 'Bàn giao'], ask: 'Anh/Chị để lại Zalo, em gửi mặt bằng 2BR khi có ạ.', topic: 'Mua để ở / nghỉ dưỡng'},
    {id: 'chothue', k: ['cho thue', 'thue', 'dong tien', 'loi nhuan', 'sinh loi', 'loi suat', 'kinh doanh', 'airbnb', 'gia thue', 'thu nhap', 'co loi', 'cong suat', 'khai thac', 'lap day', 'crown', 'khach thue', 'occ', 'gia thue dem', 'bao nhieu phan tram', 'ty suat'],
      a: ['Dạ tại Kick-off, chủ đầu tư nêu 3 nhóm khách thuê chính ạ:\n• Nhân sự chuỗi resort ven biển (có cả người nước ngoài làm tại Crown): thuê trung hạn, ổn định.\n• Khách thuê ngắn ngày kiểu Airbnb: Đà Nẵng đông khách, lấp đầy cao.\n• Khách du lịch ưu tiên căn phía biển.\nGiá thuê theo đêm hiện tại (ngoài cao điểm): studio view biển 2,2–2,9 triệu, 1BR+ 3,4–3,7 triệu. Khách sạn Sun Group miền Trung lấp đầy 81,3% năm 2026.\nBài toán tham khảo tại Kick-off: studio giả định 3 tỷ, 2,5 tr/đêm, lấp đầy 60% → lợi nhuận ~351 tr/năm (~11,7%); 1BR giả định 4,5 tỷ, 3,5 tr/đêm → ~492 tr/năm (~10,9%).\nĐây là số liệu thị trường, em không cam kết giá thuê hay lợi nhuận ạ.'],
      c: ['Studio', 'Thị trường du lịch'], ask: 'Anh/Chị để lại Zalo, em gửi bảng tính dòng tiền để mình tự kiểm tra ạ.', topic: 'Cho thuê / dòng tiền'},
    {id: 'thitruong', k: ['du lich', 'khach du lich', 'khach quoc te', 'thi truong', 'tang truong', 'tiem nang', 'tang gia', 'len gia', 'thanh khoan', 'di dan', 'dan so', 'sap nhap', 'nguon cung', 'so sanh', 'du an khac', 'nobu', 'soleil', 'futa', 'newtown'],
      a: ['Dạ Đà Nẵng đang hội tụ 3 dòng di dân ạ: 6,88 triệu lượt khách quốc tế 8 tháng đầu 2026 (+26,3%); 15–16 nghìn người nhập cư mỗi năm; quy mô dân số mới khoảng 3 triệu sau sáp nhập Quảng Nam.\nCăn hộ mặt biển thì nguồn cung rất hữu hạn; giá bán một số dự án ven biển: Soleil studio 5,2–5,5 tỷ, Nobu studio 6,3–6,4 tỷ, Futa studio 9,1–10,5 tỷ. Giá Sun Saphia chờ chủ đầu tư công bố ạ.\nEm không dám hứa tăng giá, Anh/Chị cân nhắc theo khả năng tài chính của mình ạ.'],
      c: ['Cho thuê', 'Giá bán'], ask: 'Anh/Chị để lại Zalo, em gửi bảng so sánh giá các dự án mặt biển ạ.', topic: 'Thị trường'},
    {id: 'dautu', k: ['dau tu', 'an chenh', 'luot song', 'ban lai', 'chuyen nhuong', 'dau tu co loi', 'co nen dau tu', 'dau tu the nao', 'dau tu sao', 'phan tich dau tu', 'nen mua khong', 'co nen mua', 'mua dau tu', 'dau tu duoc khong'],
      a: ['Dạ căn hộ mặt biển có 3 nguồn lợi Anh/Chị có thể tính ạ:\n• Dòng tiền cho thuê: khách du lịch, chuyên gia, nhân sự chuỗi resort ven biển.\n• Hạ tầng xung quanh đang làm: mở rộng Võ Nguyên Giáp – Trường Sa, ga LRT, công viên bãi tắm.\n• Đòn bẩy: tự bỏ khoảng 25%, phần còn lại vay; giai đoạn xây thường được hỗ trợ lãi suất (chờ chính sách chính thức).\nRủi ro cần tính: lãi suất thả nổi sau ưu đãi, mùa thấp điểm ít khách, nên dự phòng vài tháng tiền góp. Em không cam kết lợi nhuận ạ.'],
      c: ['Cho thuê', 'Studio'], ask: 'Anh/Chị để lại Zalo, em gửi số liệu thị trường và bảng tính tham khảo ạ.', topic: 'Đầu tư'},
    {id: 'tienich', k: ['tien ich', 'ho boi', 'be boi', 'yoga', 'wellness', 'spa', 'pilates', 'phong tap', 'nha tre', 'shop', 'khoi de', 'gym', 'sieu thi', 'truong hoc'],
      a: ['Dạ chủ đầu tư gọi là hệ tiện ích "may đo" nghỉ dưỡng ạ: khu wellness với bể bơi view biển; khu Gym & Yoga tầng 2 có pilates; cùng nhà trẻ, shop khối đế ngay trong toà. Ra biển có kayak, SUP, jetski. Rất tiện cho gia đình và khách thuê.'], c: ['Loại căn hộ', 'Vị trí dự án'], ask: 'Anh/Chị để lại Zalo, em gửi phối cảnh tiện ích khi có ạ.', topic: 'Tiện ích'},
    {id: 'bangiao', k: ['ban giao', 'khi nao ban giao', 'bao gio ban giao', 'khi nao xong', 'bao gio xong', 'tien do', 'hoan thanh', 'xay xong', 'khoi cong', 'nam nao', 'bao gio co nha'],
      a: ['Dạ bàn giao dự kiến tháng 11/2028, tiêu chuẩn hoàn thiện cơ bản ạ; mốc chính xác ghi trong hợp đồng mua bán khi ký.'], c: ['Pháp lý', 'Loại căn hộ'], topic: 'Bàn giao'},
    {id: 'cdt', k: ['chu dau tu', 'sun group', 'sun property', 'ai xay', 'cong ty nao', 'thuong hieu', 'cua ai'],
      a: ['Dạ theo tài liệu giới thiệu dự án, Sun Saphia do Sun Property (thuộc Sun Group) phát triển ạ.'], c: ['Pháp lý', 'Quy mô dự án'], topic: 'Chủ đầu tư'},
    {id: 'phaply', k: ['phap ly', 'so hong', 'so do', 'giay to', 'giay chung nhan', 'giay phep', 'nguoi nuoc ngoai', 'viet kieu', 'dang ky dau tu', '100 nam', 'nien han', 'phap ly the nao', 'du an co giay'],
      a: ['Dạ pháp lý Saphia rõ ràng ạ: dự án đã có Giấy chứng nhận đăng ký đầu tư mã 2572746483 do Sở Tài chính TP Đà Nẵng cấp (lần đầu 17/09/2026), toà nhà là công trình cấp I, niên hạn sử dụng 100 năm; chủ đầu tư Sun Property – thành viên Sun Group; mua qua đại lý phân phối chính thức.\nPhần thời hạn và quyền lợi khi ký hợp đồng, anh Hiệp giải thích kỹ kèm văn bản để mình xem tận mắt ạ.'],
      c: ['Vay ngân hàng', 'Bàn giao'], ask: 'Anh/Chị để lại số Zalo, em gửi bản chụp GCN đầu tư và anh Hiệp gọi giải thích ngắn gọn ạ.', strong: 1, topic: 'Pháp lý'},
    {id: 'conlai', k: ['con lai bao nhieu nam', 'con bao nhieu nam', 'con may nam', 'tinh tu khi nao', 'tinh tu nam nao', 'tinh tu luc nao', 'bat dau tinh', 'het han nam nao', 'den nam nao', 'nam 2076', 'du an khac 50 nam', 'so voi du an khac', 'thoi han con', 'con duoc bao lau', 'da chay', 'mua lai con'],
      a: ['Dạ đây là điểm lợi lớn của Saphia ạ. Cùng là 50 năm nhưng quan trọng là còn lại bao nhiêu năm:\n\n• Saphia: thời hạn 50 năm tính từ 17/09/2026 theo Giấy chứng nhận đăng ký đầu tư – vừa mới bắt đầu, kéo dài tới 09/2076. Nhận nhà 11/2028 vẫn còn khoảng 48 năm.\n• Nhiều dự án 50 năm khác tính từ năm giao đất, ví dụ giao đất 2012 thì hết hạn 2062 – nhận nhà hay mua lại bây giờ chỉ còn khoảng 34–38 năm.\n\nCòn nhiều năm hơn thì giữ giá tốt hơn, vay ngân hàng dễ hơn, thêm nhiều năm cho thuê, và sau 5–7 năm bán lại người mua sau vẫn còn trên 40 năm ạ.\nPhần so sánh này anh Hiệp có bảng cụ thể, gửi riêng cho mình xem nhé.'],
      c: ['Vay ngân hàng', 'Cho thuê'], ask: 'Anh/Chị để lại số Zalo, em gửi bản chụp giấy chứng nhận đăng ký đầu tư có ghi ngày 17/09/2026 ạ.', strong: 1, topic: 'Pháp lý – thời hạn còn lại'},
    {id: 'lau50', k: ['lau dai', 'so huu lau dai', 'co lau dai', 'khong phai lau dai', 'khong lau dai', 'sao khong lau dai', 'thich lau dai', 'muon lau dai', '50 nam', 'chi 50 nam', 'co 50 nam', '50 nam thoi', '50 nam ngan', 'ngan qua', 'ngai 50 nam', 'so 50 nam', 'thoi han', 'so huu bao lau', 'so huu may nam', 'bao nhieu nam', 'may nam', 'so huu'],
      a: ['Dạ em hiểu băn khoăn này ạ, nhiều khách cũng hỏi em y như vậy. Em nói thật: Saphia không phải sở hữu lâu dài, thời hạn dự án ghi trong GCN đầu tư là 50 năm. Nhưng có 3 điều khách nghe xong thường yên tâm:\n1️⃣ Thời hạn tính từ 17/09/2026 – vừa mới bắt đầu, nên còn dài hơn nhiều dự án đã cấp từ lâu.\n2️⃣ Toà nhà là công trình cấp I, niên hạn 100 năm; luật hiện hành không quy định tự động mất quyền sở hữu khi hết niên hạn.\n3️⃣ Luật Đất đai 2024 cho phép xem xét gia hạn khi hết thời hạn nếu sử dụng đúng mục đích.\nPhần này nghe anh Hiệp giải thích trực tiếp kèm văn bản sẽ rõ hơn đọc chữ ạ.', 'Dạ câu này rất đáng hỏi ạ. Nhiều dự án căn hộ ven biển Đà Nẵng cũng có thời hạn như Saphia (50 năm theo GCN đầu tư), điểm khác là đồng hồ của Saphia vừa mới bắt đầu từ 09/2026, toà nhà cấp I niên hạn 100 năm, và Nghị quyết 278/NQ-CP (9/2026) đang làm rõ thời hạn chung cư theo niên hạn công trình.\nMỗi khách một mục đích (ở, nghỉ dưỡng, cho thuê) nên anh Hiệp thường giải thích riêng, kèm văn bản để mình tự đối chiếu ạ.'],
      c: ['Hết hạn thì sao', 'Cho thuê'], ask: 'Anh/Chị để lại số, anh Hiệp gọi 5 phút giải thích kèm văn bản cho mình ạ.', strong: 1, topic: 'Pháp lý – thời hạn (sale giải thích)'},
    {id: 'hethan', k: ['het 50 nam', 'het han', 'sau 50 nam', '50 nam thi sao', '50 nam xong', 'het nien han', 'nien han 100', 'pha do', 'xay lai', 'gia han', 'het thoi han', 'mat nha', 'thu hoi lai', 'het han thi sao'],
      a: ['Dạ câu này rất đáng hỏi ạ, em trả lời theo đúng luật để Anh/Chị yên tâm nhé. Saphia có 2 mốc khác nhau:\n\n1️⃣ 50 năm là thời hạn dự án (thời hạn sử dụng đất), tính từ 17/09/2026 theo Giấy chứng nhận đăng ký đầu tư. Luật Đất đai 2024 (Luật số 31/2024/QH15) cho phép người sử dụng đất có thời hạn được xem xét gia hạn khi hết hạn, nếu sử dụng đúng mục đích và chấp hành tốt pháp luật.\n\n2️⃣ 100 năm là niên hạn toà nhà (công trình cấp I). Theo Luật Nhà ở 2023 (Luật số 27/2023/QH15):\n• Điều 58: thời hạn sử dụng chung cư xác định theo hồ sơ thiết kế và kết luận kiểm định thực tế; hết niên hạn thì cơ quan có thẩm quyền tổ chức kiểm định chất lượng.\n• Còn an toàn thì tiếp tục sử dụng theo kết luận kiểm định.\n• Điều 59: chỉ khi không còn bảo đảm an toàn mới thuộc diện phá dỡ để cải tạo, xây lại; chủ sở hữu được bồi thường, tái định cư hoặc nhận căn hộ mới theo phương án được duyệt.\n👉 Luật hiện hành không quy định tự động mất quyền sở hữu khi hết niên hạn ạ.\n\nNói vui một chút: 50 năm là hơn 2 thế hệ ở và cho thuê, mà đất sát biển trung tâm Đà Nẵng gần như không còn quỹ lâu dài nữa. Quyền lợi chi tiết sẽ ghi trong Hợp đồng mua bán; khi có hợp đồng mẫu, anh Hiệp gửi Anh/Chị đọc kỹ điều khoản này trước khi quyết định. Anh/Chị để lại số Zalo, em gửi luôn bản tóm tắt pháp lý nhé?'],
      c: ['Cho thuê', 'Thị trường du lịch'], ask: 'Anh/Chị để lại số Zalo, anh Hiệp gửi văn bản và giải thích trực tiếp cho mình ạ.', strong: 1, topic: 'Pháp lý – hết hạn'},
    {id: 'luadao', k: ['lua dao', 'bi lua', 'lua khong', 'lua dao khong', 'uy tin khong', 'tin duoc khong', 'co that khong', 'that khong', 'scam', 'mat tien', 'an cap', 'gia mao', 'co chac khong', 'tin sao duoc'],
      a: ['Dạ Anh/Chị cẩn thận là rất đúng ạ. Đăng ký ở đây chỉ để nhận thông tin, không thu bất kỳ khoản tiền nào.\nKhi mở bán, mọi giao dịch theo hợp đồng và văn bản chính thức của chủ đầu tư.', 'Dạ em hiểu ạ. Trang chỉ nhận đăng ký thông tin, không thu tiền; Anh/Chị cứ gọi thẳng anh Hiệp ' + SO + ' để hỏi kỹ trước.'],
      c: ['Pháp lý', 'Gặp anh Hiệp'], topic: 'Lo ngại uy tín'},
    {id: 'coc', k: ['dat coc', 'coc', 'giu cho', 'booking', 'dat cho', 'giu can', 'chuyen khoan', 'tra truoc'],
      a: ['Dạ hiện mình đặt chỗ (booking) 50 triệu/căn, hoàn lại 100% nếu không mua ạ. Đặt chỗ được ưu tiên chọn căn đẹp, và từ sự kiện ra mắt 01/11/2026 chủ đầu tư chính thức nhận booking; căn view đẹp em thấy cũng nhiều khách hỏi lắm ạ.\nTiền đặt chỗ chuyển theo hướng dẫn của đại lý phân phối chính thức, em không nhận tiền qua khung chat; đăng ký trên trang không thu khoản nào ạ.'],
      c: ['Giá bán', 'Pháp lý'], ask: 'Anh/Chị để lại số Zalo, anh Hiệp gọi hướng dẫn đặt chỗ đúng quy trình ạ.', strong: 1, topic: 'Booking / đặt cọc'},
    {id: 'moban', k: ['mo ban', 'khi nao mo ban', 'bao gio mo ban', 'ngay mo ban', 'dang ban', 'ban chua', 'da ban', 'ra hang', 'bao gio ban', 'con can khong', 'het can chua', 'con khong', 'nhan booking khi nao'],
      a: EVT_ON ? ['Dạ Sun Saphia chính thức ra mắt và nhận booking tại sự kiện 9:00 Chủ nhật 01/11/2026 ở Hilton Đà Nẵng ạ. Hiện chưa mở bán đại trà, nên đây đúng là lúc danh sách ưu tiên được xếp chỗ chọn căn.\nAnh/Chị có muốn em giữ thư mời tham dự cho mình không ạ?', 'Dạ chỉ còn một mốc rất gần thôi ạ: Chủ nhật 01/11/2026, chủ đầu tư ra mắt tại Hilton Đà Nẵng, 10:18 bắt đầu nhận booking. Căn view biển tầng cao thường được chọn nhanh nhất trong buổi đầu.\nAnh/Chị muốn em đăng ký thư mời cho mình không ạ?'] : ['Dạ Sun Saphia đã ra mắt và nhận booking từ 01/11/2026 ạ. Căn đẹp đang được chọn dần, anh Hiệp cập nhật danh sách căn còn trống mỗi ngày.'],
      c: ['Không đi được', 'Booking thế nào'], ask: 'Anh/Chị để lại Zalo, em gửi danh sách căn còn trống và chính sách mới nhất ạ.', strong: 1, hk: 'skmoi', topic: 'Thời điểm mở bán'},
    {id: 'vay', k: ['vay ngan hang', 'vay von', 'cho vay', 'vay duoc', 'vay bao nhieu', 'vay tien', 'duoc vay', 'ngan hang', 'lai suat', 'tra gop', 'chiet khau', 'uu dai', 'khuyen mai', 'ho tro', 'von vay', 'don bay'],
      a: ['Dạ ngân hàng hỗ trợ dự án là Vietcombank, BIDV và NCB ạ. Cách nhiều nhà đầu tư hay làm: tự bỏ khoảng 25%, phần còn lại vay; cứ mỗi 1 tỷ giá căn thì mình bỏ khoảng 250 triệu, ngân hàng cho vay khoảng 750 triệu.\nDự án Sun Group thường có hỗ trợ lãi suất và ân hạn gốc tới bàn giao; tỷ lệ vay và mức hỗ trợ cụ thể chờ chính sách bán hàng chính thức ạ.'],
      c: ['Giá bán', 'Studio'], ask: 'Anh/Chị để lại Zalo, có chính sách em gửi bảng tính ngay ạ.', strong: 1, topic: 'Thanh toán / vay'},
    {id: 'thanhtoan', k: ['tien do thanh toan', 'thanh toan', 'thanh toan the nao', 'dong tien the nao', 'dong may dot', 'may dot', 'chia dot', 'tung dot', 'tra tien the nao', 'tra may lan', 'phuong thuc thanh toan', 'thanh toan som', 'dong theo tien do', 'gom tien'],
      a: ['Dạ tiến độ thanh toán chủ đầu tư sẽ công bố tại sự kiện ra mắt 01/11/2026 ạ. Căn hộ thường xây khoảng 2 năm, Saphia dự kiến bàn giao 11/2028, nên mình không phải gom đủ tiền ngay mà đóng dần theo toà nhà lên tới đâu.\nThường có 3 cách: đóng theo tiến độ, tự bỏ khoảng 25% rồi vay ngân hàng, hoặc thanh toán sớm để được chiết khấu. Hiện chỉ cần đặt chỗ 50 triệu, hoàn lại 100% nếu không mua.'],
      c: ['Vay ngân hàng', 'Studio'], ask: 'Anh/Chị để lại Zalo, có chính sách em gửi đúng phương án mình chọn ạ.', strong: 1, topic: 'Thanh toán / vay'},
    {id: 'xem', k: ['xem nha', 'nha mau', 'tham quan', 'xem thuc te', 'di xem', 'qua xem', 'ra xem', 'hen gap', 'gap mat', 'van phong'],
      a: ['Dạ Anh/Chị ra Đà Nẵng thì anh Hiệp hẹn đưa đi xem thực tế vị trí ạ. Anh/Chị dự kiến đi lúc nào ạ?'], c: ['Gặp anh Hiệp', 'Vị trí dự án'], ask: 'Anh/Chị để lại số, anh Hiệp gọi hẹn lịch ạ.', strong: 1, topic: 'Hẹn xem dự án'},
    {id: 'suynghi', k: ['suy nghi', 'de xem', 'can nhac', 'tham khao', 'chua chac', 'chua can', 'de sau', 'tu tu', 'ban voi vo', 'ban voi chong', 'hoi y kien'],
      a: ['Dạ Anh/Chị cứ thong thả cân nhắc ạ, mua nhà là việc lớn. Em gửi tài liệu để cả nhà cùng xem, không làm phiền đâu ạ.', 'Dạ không vội đâu ạ. Khi nào có giá và mặt bằng em chỉ gửi một lần để Anh/Chị so sánh.'],
      c: ['Vị trí dự án', 'Loại căn hộ'], ask: 'Nếu tiện Anh/Chị để lại Zalo, em gửi tài liệu để mình xem dần ạ.', topic: 'Còn cân nhắc'},
    {id: 'ban', k: ['ban lam', 'ban qua', 'luc khac', 'de luc khac', 'khi khac', 'chut nua', 'toi ban', 'minh ban', 'dang hop', 'dang lai xe'],
      a: ['Dạ em không làm mất thời gian của Anh/Chị ạ. Anh/Chị để lại số Zalo, em gửi gọn tài liệu để lúc rảnh mình xem.', 'Dạ vâng ạ. Anh/Chị cứ để số Zalo, em gửi tài liệu gọn, lúc nào rảnh mình xem nhé.'], c: [], topic: 'Đang bận'},
    {id: 'bot', k: ['bot', 'robot', 'may tra loi', 'tu dong', 'nguoi that khong', 'phai nguoi khong', 'ai dang chat', 'ai tra loi', 'ban la ai', 'em la ai', 'chatbot', 'tra loi tu dong', 'la may', 'phai may'],
      a: ['Dạ em là trợ lý trả lời nhanh của anh Hoàng Hiệp, không phải người thật ạ. Câu nào cần chính xác, em chuyển anh Hiệp gọi lại cho Anh/Chị.', 'Dạ đúng rồi ạ, em là trợ lý trả lời nhanh của anh Hoàng Hiệp. Anh/Chị muốn nói chuyện với anh Hiệp thì gọi ' + SO + ' hoặc để số, anh gọi lại.'],
      c: ['Gặp anh Hiệp', 'Giá bán'], topic: 'Hỏi có phải máy'},
    {id: 'nguoi', k: ['nguoi that', 'gap nguoi', 'noi chuyen voi nguoi', 'gap anh hiep', 'anh hiep', 'goi cho toi', 'goi lai', 'goi cho minh', 'nhan vien', 'tu van vien', 'chuyen vien', 'nguoi tu van', 'gap anh', 'gap truc tiep'],
      a: ['Dạ em báo anh Hiệp ngay ạ. Anh/Chị gọi trực tiếp ' + SO + ', hoặc để lại số, anh Hiệp gọi lại cho mình.'], c: [], human: 1, topic: 'Muốn gặp người thật'},
    {id: 'zalo', k: ['zalo', 'nhan zalo', 'so zalo', 'so dien thoai', 'hotline', 'lien he', 'so may'],
      a: ['Dạ Anh/Chị nhắn Zalo ' + SO + ' (anh Hoàng Hiệp) ạ, hoặc gõ số của mình vào đây, anh Hiệp chủ động liên hệ.'], c: [], topic: 'Xin liên hệ'},
    {id: 'tuchoi', k: ['khong de so', 'khong cho so', 'khong muon de', 'khong can goi', 'dung goi', 'khong de lai', 'khong muon cho', 'thoi khoi', 'khong can dau'],
      a: ['Dạ không sao ạ, em không xin số nữa đâu. Anh/Chị cứ hỏi thoải mái; khi nào cần bảng giá hay căn còn trống, mình chỉ cần nhắn Zalo ' + SO + ' là anh Hiệp gửi ngay ạ.'], c: ['Vị trí dự án', 'Loại căn hộ'], refuse: 1},
    {id: 'trucbien', k: ['mo rong', 'rong them', 'mo rong duong', 'mo rong duong bien', 'mo rong vo nguyen giap', 'mo rong truong sa', 'nang cap duong', 'lac long quan', 'truc bien', 'duong ven bien', 'luong xanh', '2633', '2.633', 'duong co rong', 'ket xe', 'mat tien duong'],
      a: ['Dạ Saphia nằm mặt tiền trục biển Võ Nguyên Giáp – Trường Sa ạ. Thành phố đưa dự án mở rộng tuyến Võ Nguyên Giáp – Trường Sa – Lạc Long Quân vào nhóm dự án đầu tư công ưu tiên “luồng xanh”, vốn dự kiến khoảng 2.633 tỷ đồng (Tuổi Trẻ, 10/2026).\nĐây là trục nối trung tâm Đà Nẵng với Hội An, mở rộng xong thì đi lại nhanh hơn và mặt tiền biển càng có giá. Mặt cắt và thời gian khởi công thành phố chưa công bố, em sẽ cập nhật ngay khi có ạ.'],
      c: ['Đường sắt đô thị', 'Công viên trước dự án'], ask: 'Anh/Chị để lại Zalo, em gửi bài báo và cập nhật tiến độ mở rộng đường ạ.', topic: 'Mở rộng trục biển'},
    {id: 'duongsat', k: ['lrt', 'ga lrt', 'nha ga', 'ga tau', 'tau dien', 'duong sat', 'duong sat do thi', 'duong sat tren cao', 'tren cao', 'metro', 'thaco', 'dai quang minh', 'chu lai', 'tau di hoi an', 'tau ra san bay'],
      a: ['Dạ tuyến đường sắt đô thị Đà Nẵng dài khoảng 103 km từ sân bay Đà Nẵng tới sân bay Chu Lai, tổng mức khoảng 265.972 tỷ đồng ạ. Giai đoạn 1 dài 30,2 km, 14 ga, nối sân bay với Hội An và đi qua khu Ngũ Hành Sơn; theo tài liệu Kick-off, ga LRT 09 cách Saphia khoảng 500 m.\nEm nói rõ để Anh/Chị cân nhắc: dự án đang ở bước nhà đầu tư (Đại Quang Minh – THACO) đề xuất PPP, dự kiến khởi công 2/2027, chờ thành phố phê duyệt. Nếu thành hiện thực thì từ Saphia đi sân bay hay Hội An đều rất tiện, khách thuê cũng thích ạ.', 'Dạ có ạ: quy hoạch có ga đường sắt đô thị cách dự án khoảng 500 m, tuyến sân bay – Hội An (giai đoạn 1: 30,2 km, 14 ga). Hiện nhà đầu tư THACO đang đề xuất, dự kiến khởi công 2/2027 – em xem đây là điểm cộng tương lai, chưa phải điều chắc chắn ạ. Sơ đồ hướng tuyến ở sun-saphia-residence.com/quy-hoach.'],
      c: ['Công viên Ngũ Hành Sơn', 'Cho thuê'], ask: 'Anh/Chị để lại Zalo, em cập nhật khi tuyến đường sắt được phê duyệt ạ.', topic: 'Đường sắt đô thị'},
    {id: 'nhs', k: ['ngu hanh son', 'nui ngu hanh son', 'cong vien ngu hanh son', 'cong vien van hoa', 'danh thang', 'non nuoc', 'thuy son', 'bao thap', 'bao thien', 'vuon thien', 'chua non nuoc', 'nui da'],
      a: ['Dạ Ngũ Hành Sơn cách Saphia khoảng 2,5 km ạ. Danh thắng quốc gia đặc biệt này đã có quy hoạch bảo quản, tu bổ được Thủ tướng phê duyệt (QĐ 822/QĐ-TTg, 2023). Thành phố đang làm Công viên văn hóa lịch sử Ngũ Hành Sơn khoảng 92 ha, đang giải phóng mặt bằng; các hạng mục như vườn thiền, vườn tượng, bảo tháp Báo Thiên cao 58 m dự kiến 2026–2028.\nTừ tầng cao của Saphia, căn hướng Nam nhìn được cả dáng Ngũ Hành Sơn ạ.'],
      c: ['Hướng view', 'Quy hoạch quanh dự án'], ask: 'Anh/Chị để lại Zalo, em gửi danh sách căn nhìn về Ngũ Hành Sơn ạ.', topic: 'Công viên Ngũ Hành Sơn'},
    {id: 'qhchac', k: ['quy hoach treo', 'du an treo', 'co lam that', 'co lam khong', 'bao gio lam', 'khi nao lam', 'chac chan khong', 'chi la quy hoach', 'tren giay', 'noi cho hay'],
      a: ['Dạ Anh/Chị hỏi rất đúng ạ, em nói rõ từng cái:\n• Công viên 2,45 ha trước dự án: đã có quyết định phê duyệt dự án (2958/QĐ-UBND), vốn ngân sách – chắc chắn nhất.\n• Mở rộng trục biển 2.633 tỷ: thành phố đưa vào nhóm ưu tiên, đang chuẩn bị đầu tư.\n• Đường sắt đô thị: đang ở bước đề xuất, chưa phê duyệt.\n• Công viên Ngũ Hành Sơn: đang giải phóng mặt bằng.\nEm chỉ tư vấn trên cái đã có văn bản, phần còn lại xem như điểm cộng tương lai. Link nguồn từng dự án em để ở sun-saphia-residence.com/quy-hoach ạ.'],
      c: ['Pháp lý', 'Công viên trước dự án'], ask: 'Anh/Chị để lại Zalo, em gửi link văn bản, bài báo của từng dự án để mình tự kiểm chứng ạ.', strong: 1, topic: 'Quy hoạch – độ chắc chắn'},
    {id: 'camon', k: ['cam on', 'ok', 'hieu roi', 'duoc roi', 'vang', 'da biet', 'tot qua', 'hay qua'],
      a: ['Dạ em cảm ơn Anh/Chị ạ. Anh/Chị cần thêm gì cứ nhắn em nhé.', 'Dạ vâng ạ, có gì Anh/Chị cứ hỏi tiếp, em trả lời ngay.'], c: []}
  ];
  /* Sau khi trả lời: mở câu chuyện tiếp theo, dẫn dần tới mời để số/Zalo ('lead') */
  var HOOK = {
    thanhtoan: [['Anh/Chị thích đóng giãn theo tiến độ, dùng vốn vay, hay thanh toán sớm lấy chiết khấu ạ?', '']],
    hethan: [['Anh/Chị có muốn em gửi bản chụp GCN đầu tư để mình đọc kỹ không ạ?', 'lead']],
    lau50: [['Anh/Chị có muốn xem căn hộ mặt biển cho thuê được bao nhiêu mỗi tháng không ạ?', 'chothue']],
    oxa: [['Lần tới ra Đà Nẵng Anh/Chị có muốn anh Hiệp dẫn đi xem thực tế khu đất không ạ?', 'xem']],
    hoian: [['Anh/Chị có muốn xem hạ tầng đang làm quanh dự án như ga LRT, mở rộng đường biển không ạ?', 'hatang']],
    hatang: [['Anh/Chị có muốn xem bản vẽ công viên ngay trước dự án không ạ?', 'congvien'], ['Anh/Chị có muốn em gửi sơ đồ quy hoạch bản nét qua Zalo không ạ?', 'lead']],
    congvien: [['Anh/Chị có muốn biết trục đường biển trước dự án sắp mở rộng thế nào không ạ?', 'trucbien'], ['Anh/Chị có muốn biết căn nào nhìn thẳng ra công viên – biển không ạ?', 'bien']],
    trucbien: [['Anh/Chị có muốn nghe thêm về ga đường sắt đô thị cách dự án 500 m không ạ?', 'duongsat']],
    duongsat: [['Anh/Chị có muốn em gửi sơ đồ 4 quy hoạch quanh dự án qua Zalo không ạ?', 'lead']],
    nhs: [['Anh/Chị có muốn em lọc giúp các căn nhìn về Ngũ Hành Sơn không ạ?', 'lead']],
    qhchac: [['Anh/Chị có muốn em gửi link văn bản, bài báo từng dự án qua Zalo không ạ?', 'lead']],
    caurong: [['Anh/Chị có muốn biết căn nào nhìn được cả sông Hàn với Ngũ Hành Sơn không ạ?', 'view']],
    sanbay: [['Anh/Chị có muốn biết căn nào nhìn thẳng ra biển không ạ?', 'bien']],
    dat: [['Anh/Chị có muốn em tính thử tiền thuê về mỗi tháng so với tiền góp ngân hàng không ạ?', 'lead'], ['Anh/Chị có muốn em so sánh nhanh Studio và 1BR+ cho dễ chọn không ạ?', 'loaican']],
    vitri: [['Anh/Chị có muốn biết căn nào nhìn thẳng ra biển không ạ?', 'bien'], ['Anh/Chị có muốn xem tiện ích ngay trong toà không ạ?', 'tienich']],
    bien: [['Anh/Chị có muốn em gửi danh sách căn hướng biển ngay khi có không ạ?', 'lead']],
    quymo: [['Anh/Chị có muốn xem 3 dòng căn trong toà không ạ?', 'loaican']],
    o: [['Anh/Chị có muốn biết thời gian bàn giao để tính kế hoạch chuyển về không ạ?', 'bangiao']],
    chothue: [['Anh/Chị có muốn em gửi bảng tính dòng tiền tham khảo cho Studio không ạ?', 'lead']],
    thitruong: [['Anh/Chị có muốn xem giá thuê studio thực tế quanh Mỹ Khê không ạ?', 'chothue']],
    dautu: [['Anh/Chị có muốn em gửi bảng tính tiền thuê so với tiền góp ngân hàng không ạ?', 'lead'], ['Anh/Chị có muốn xem số liệu giá thuê quanh Mỹ Khê không ạ?', 'chothue']],
    tienich: [['Anh/Chị có muốn biết dòng căn nào hợp gia đình có con nhỏ không ạ?', 'o']],
    bangiao: [['Anh/Chị có muốn biết thêm phần pháp lý của dự án không ạ?', 'phaply']],
    cdt: [['Anh/Chị có muốn biết quy mô toà nhà không ạ?', 'quymo']],
    phaply: [['Anh/Chị có muốn em gửi bản chụp giấy chứng nhận đăng ký đầu tư qua Zalo không ạ?', 'lead']],
    luadao: [['Anh/Chị có muốn anh Hiệp gọi lại để trao đổi trực tiếp cho yên tâm không ạ?', 'lead']],
    coc: [['Anh/Chị đang nhắm Studio, 1BR+ hay 2BR để em ghi ưu tiên đúng dòng căn ạ?', 'loaican'], ['Anh/Chị có muốn anh Hiệp gọi hướng dẫn đặt chỗ không ạ?', 'lead']],
    moban: [['Anh/Chị có muốn nằm trong danh sách được báo đầu tiên không ạ?', 'lead']],
    skno: [['Anh/Chị đang quan tâm Studio, 1BR+ hay 2BR để em lọc sẵn căn còn trống sau sự kiện ạ?', 'loaican']],
    vay: [['Anh/Chị dự kiến chuẩn bị vốn khoảng bao nhiêu để em tính trước giúp mình ạ?', ''], ['Anh/Chị có muốn em gửi bảng tính tiền thuê so với tiền góp ngân hàng không ạ?', 'lead']],
    suynghi: [['Trong lúc cân nhắc, Anh/Chị muốn xem trước vị trí hay loại căn ạ?', '']],
    bot: [['Anh/Chị có muốn em chuyển anh Hiệp gọi lại cho mình không ạ?', 'lead']],
    tuchoi: [['Anh/Chị đang quan tâm vị trí hay loại căn hơn ạ?', '']],
    camon: [['Anh/Chị có muốn nhận bảng giá qua Zalo khi chủ đầu tư công bố không ạ?', 'lead']],
    zalo: [['', '']]
  };
  var AFF = / (co|muon|vang|ok|duoc|uh|u|um|dong y|gui|gui di|gui em|gui anh|gui chi|nhe|yes|chac chan|tat nhien|duoc a|co a|muon a) /;
  var NEG = / (khong|thoi|chua|de sau|khong can|khoi|no) /;
  var ALIAS = {'Hết hạn thì sao': 'het han thi sao', 'Không đi được': 'khong di duoc', 'Booking thế nào': 'booking', 'Đăng ký tham dự thế nào?': 'dang ky tham du', 'Không đi được thì sao?': 'khong di duoc', 'Studio': 'studio', '2BR': '2br', 'Để ở': 'de o', 'Cho thuê': 'cho thue', 'Tiện ích': 'tien ich', 'Bàn giao': 'ban giao', 'Pháp lý': 'phap ly', 'Chủ đầu tư': 'chu dau tu',
    'Vị trí dự án': 'vi tri', 'Loại căn hộ': 'loai can', 'Cách biển bao xa': 'cach bien', 'Giá bán': 'gia ban', 'Quy mô dự án': 'quy mo', 'Thị trường du lịch': 'du lich', 'Gặp anh Hiệp': 'gap anh hiep', 'Mở rộng đường biển': 'mo rong duong bien', 'Đường sắt đô thị': 'duong sat do thi', 'Công viên Ngũ Hành Sơn': 'cong vien ngu hanh son', 'Quy hoạch quanh dự án': 'quy hoach', 'Công viên trước dự án': 'cong vien', 'Hạ tầng xung quanh': 'ha tang'};

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
    + '.hhc-h b{display:block;font-size:15px;line-height:1.3}.hhc-h small{display:block;font-size:12px;color:#A9BCD8;line-height:1.35}'
    + '.hhc-x{margin-left:auto;background:none;border:0;color:#fff;font-size:26px;line-height:1;cursor:pointer;padding:0 4px}'
    + '.hhc-log{flex:1;overflow-y:auto;padding:12px;display:flex;flex-direction:column;gap:8px;-webkit-overflow-scrolling:touch}'
    + '.hhc-m{max-width:86%;padding:10px 13px;border-radius:15px;font-size:15px;line-height:1.5;white-space:pre-line;word-wrap:break-word;text-align:left}'
    + '.hhc-bot{background:#fff;border:1px solid #D7DFEC;border-bottom-left-radius:4px;align-self:flex-start}'
    + '.hhc-me{background:#F26B1D;color:#fff;border-bottom-right-radius:4px;align-self:flex-end}'
    + '.hhc-t{font-size:13px;color:#5B6B7E;align-self:flex-start;padding-left:4px}'
    + '.hhc-c{display:flex;flex-wrap:wrap;gap:6px}.hhc-c button{background:#fff;border:1.5px solid #1E4D8C;color:#1E4D8C;border-radius:999px;padding:6px 12px;font-size:13.5px;font-weight:600;cursor:pointer;font-family:inherit}'
    + '.hhc-c button:hover{background:#1E4D8C;color:#fff}'
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
    box.innerHTML = '<div class="hhc-h"><span class="hhc-av">HH</span><div><b>Trợ lý trả lời nhanh</b><small>của anh Hoàng Hiệp · Sun Saphia Residence</small></div><button class="hhc-x" type="button" aria-label="Đóng">×</button></div>'
      + '<div class="hhc-log"></div>'
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
    /* Một lời mời nhẹ sau 25 giây, mỗi phiên một lần */
    nudge = el('div', 'hhc-n', '<button type="button" aria-label="Ẩn">×</button>Anh/Chị cần <b>vị trí, loại căn</b> hay nhận bảng giá khi công bố? Em trả lời nhanh ạ.');
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
      say('Dạ em chào Anh/Chị, em là trợ lý trả lời nhanh của anh Hoàng Hiệp về Sun Saphia Residence ạ.\nAnh/Chị đang quan tâm để ở, nghỉ dưỡng hay cho thuê ạ?' + (nn ? '\n(Giờ này ' + nn + '; em vẫn trả lời nhanh thông tin dự án.)' : ''), ['Vị trí dự án', 'Loại căn hộ']);
    }
    setTimeout(function () { try { inp.focus({preventScroll: true}); } catch (e) {} }, 250);
  }
  window.hhcOpen = open;

  /* ---------- Khách dừng lâu ở một phần trang: hỏi khéo, gợi 2 câu hỏi đúng phần đó ---------- */
  var DWELL = 7000, NUDGE_MAX = 3, NUDGE_GAP = 35000;
  var SECT = [
    {k: ['thu moi', 'su kien ra mat', 'anh duong'], t: 'Anh/Chị đang xem thư mời ra mắt 01/11 ạ? Khách hay hỏi em:', q: ['Đăng ký tham dự thế nào?', 'Không đi được thì sao?']},
    {k: ['vi tri', 'toa do', 'trung diem'], t: 'Anh/Chị đang xem vị trí ạ? Nhiều khách hỏi em mấy câu này:', q: ['Từ sân bay tới dự án bao xa?', 'Dự án cách biển bao xa?']},
    {k: ['tam nhin', 'huong view', 'khung tranh'], t: 'Mỗi hướng một khung cảnh đó ạ. Anh/Chị muốn biết thêm:', q: ['Mỗi hướng nhìn ra gì?', 'Tầng cao có thấy sông Hàn không?']},
    {k: ['co cau', 'layout', 'mat bang', '782 can'], t: 'Anh/Chị đang chọn loại căn ạ? Em gợi ý nhanh:', q: ['Có những loại căn nào?', 'Studio rộng bao nhiêu m2?']},
    {k: ['phap ly', 'giay to'], t: 'Phần pháp lý nhiều khách hỏi kỹ lắm ạ:', q: ['Dự án có giấy tờ gì?', 'Mua qua đại lý nào chính thức?']},
    {k: ['tien ich'], t: 'Anh/Chị đang xem tiện ích ạ? Khách hay hỏi:', q: ['Trong toà có hồ bơi, gym không?', 'Gần trường học, bệnh viện không?']},
    {k: ['cho thue', 'dong tien', 'khai thac', 'gia thue', 'khach thue', 'nguon cau', 'chon loai can'], t: 'Phần cho thuê này em tính giúp được ạ:', q: ['Cho thuê được bao nhiêu một tháng?', 'Dùng vốn vay có ổn không?']},
    {k: ['vay ngan hang'], t: 'Anh/Chị định dùng vốn vay ạ? Em giải thích nhanh:', q: ['Vay ngân hàng được bao nhiêu?', 'Tiến độ thanh toán thế nào?']},
    {k: ['tinh trang gia', 'so sanh', 'gia tung can', 'gia can ho'], t: 'Giá chưa công bố, nhưng em trả lời được mấy câu này ạ:', q: ['Khi nào có giá chính thức?', 'Booking bao nhiêu, có hoàn không?']},
    {k: ['tien do', 'moc thoi gian'], t: 'Anh/Chị đang xem các mốc thời gian ạ:', q: ['Khi nào mở bán?', 'Tiến độ thanh toán thế nào?']},
    {k: ['thoi diem', 'mua som', 'dang ky som', 'khan hiem', 'gia tri'], t: 'Nhiều khách đang giữ chỗ sớm ạ. Anh/Chị muốn biết:', q: ['Booking bao nhiêu, có hoàn không?', 'Đầu tư có lời không?']},
    {k: ['dai ly', 'mua o dau'], t: 'Anh/Chị muốn mua đúng kênh chính thức ạ? Em giải thích:', q: ['Mua qua đại lý nào chính thức?', 'Booking bao nhiêu, có hoàn không?']},
    {k: ['chan dung', 'chu nhan', 'ho la ai'], t: 'Anh/Chị thuộc nhóm nào ạ? Em gợi ý đúng căn:', q: ['Mua để ở nghỉ dưỡng có hợp không?', 'Cho thuê được bao nhiêu một tháng?']},
    {k: ['thong tin tong quan', 'tong quan'], t: 'Anh/Chị cần em tóm tắt nhanh gì không ạ?', q: ['Giá dự kiến bao nhiêu?', 'Khi nào mở bán?']}
  ];
  var asked = {}, idleT = null, idleN = 0, nudge2, dwellT = null, nudgeN = 0, lastNudge = 0, loadAt = Date.now();
  function openWith(q) {
    nudge2 && nudge2.classList.remove('on'); nudge && nudge.classList.remove('on'); box.classList.add('on');
    if (!started) { started = true; say('Dạ em chào Anh/Chị, em là trợ lý trả lời nhanh của anh Hoàng Hiệp về Sun Saphia Residence ạ.'); }
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
  var IDLE_Q = ['Sự kiện ra mắt 01/11 ở đâu?', 'Không đi được thì sao?', 'Booking bao nhiêu, có hoàn không?', 'Khi nào mở bán?', 'Cho thuê được bao nhiêu một tháng?', 'Từ sân bay tới dự án bao xa?', 'Vay ngân hàng được bao nhiêu?', 'Có những loại căn nào?'];
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
  function urgent(why) { notifyOnce('human', {thong_bao: 'Khách trên trang Sun Saphia ' + why, yeu_cau: '⚠️ KHÁCH MUỐN NÓI CHUYỆN VỚI NGƯỜI THẬT – vào hỗ trợ ngay', cau_hoi: lastQ}); }
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
    if (!phone && turn >= 2) notifyOnce('chat', {thong_bao: 'Khách đang chat trên trang Sun Saphia (chưa để số)'});

    /* 3. Văng tục */
    if (isBad(n)) { urgent('đang bức xúc'); miss = 0; say(pick(['Dạ em xin lỗi nếu em trả lời chưa đúng ý Anh/Chị ạ. Em đã báo anh Hiệp, Anh/Chị gọi ' + SO + ' để anh hỗ trợ trực tiếp nhé.', 'Dạ em thành thật xin lỗi Anh/Chị ạ. Em chuyển anh Hiệp liên hệ mình ngay, hoặc Anh/Chị gọi thẳng ' + SO + '.'])); return; }

    /* 4. Khách trả lời ngắn "có/không" cho câu gợi mở vừa rồi */
    var words = n.trim().split(' ').length, hk = lastHook; lastHook = null;
    if (hk === 'skmoi' && words <= 7 && (NEG.test(n) || / (ban|ban roi|ban lam|khong ranh|xa qua|o xa|de sau|lan sau|chac khong) /.test(n))) { for (var y = 0; y < KB.length; y++) if (KB[y].id === 'skno') { respond(KB[y]); return; } }
    if (hk === 'skmoi' && words <= 5 && AFF.test(n) && !NEG.test(n)) { addTopic('Đăng ký thư mời sự kiện 01/11'); lastAsk = turn; lastHook = 'lead';
      say(phone ? 'Dạ em đã ghi tên Anh/Chị vào danh sách thư mời ạ, anh Hiệp sẽ gọi xác nhận và gửi định vị Hilton qua Zalo.' : pick(['Dạ tuyệt quá ạ! Anh/Chị cho em xin tên và số Zalo, em đăng ký thư mời và gửi định vị Hilton cho mình ngay ạ.', 'Dạ vâng ạ, em giữ một suất cho mình. Anh/Chị gõ tên và số Zalo ở ô bên dưới giúp em nhé, anh Hiệp sẽ gửi thư mời điện tử.'])); return; }
    if (hk && words <= 4 && AFF.test(n) && !NEG.test(n)) {
      if (hk === 'lead') { say(pick(['Dạ Anh/Chị gõ số Zalo vào ô bên dưới giúp em, em chuyển anh Hiệp gửi ngay ạ.', 'Dạ vâng ạ, Anh/Chị cho em xin số Zalo ở ô bên dưới, anh Hiệp gửi trong ít phút ạ.'])); return; }
      for (var x = 0; x < KB.length; x++) if (KB[x].id === hk) { respond(KB[x]); return; }
    }
    if (hk && words <= 3 && NEG.test(n)) {
      if (hk === 'lead') lastAsk = turn;
      say(pick(['Dạ vâng ạ, Anh/Chị cần thông tin gì cứ hỏi em nhé.', 'Dạ không sao ạ. Anh/Chị muốn tìm hiểu thêm phần nào ạ?']), ['Vị trí dự án', 'Loại căn hộ']); return;
    }
    if (!hk && words <= 2 && AFF.test(n) && !NEG.test(n)) { say(pick(['Dạ vâng ạ. Anh/Chị muốn em gửi thêm phần nào: vị trí, loại căn hay bảng giá khi công bố ạ?', 'Dạ em đây ạ. Anh/Chị cần em nói thêm về vị trí, loại căn hay tiện ích ạ?']), ['Loại căn hộ', 'Giá bán']); return; }
    if (!hk && words <= 2 && NEG.test(n)) { say('Dạ vâng ạ, Anh/Chị cần thông tin gì cứ hỏi em nhé.', ['Vị trí dự án', 'Loại căn hộ']); return; }
    /* 5. Tìm ý */
    var best = null, score = 0;
    KB.forEach(function (it) { var sc = 0; it.k.forEach(function (k) { if (has(n, k)) sc += k.length + 2; }); if (sc > score) { score = sc; best = it; } });
    if (!best || score < 3) {
      miss++;
      if (miss >= 2) { miss = 0; say('Dạ câu này em xin chuyển anh Hiệp trả lời cho chính xác ạ. Anh/Chị nhắn Zalo ' + SO + ' hoặc để lại số, anh Hiệp phản hồi ngay.', []); return; }
      say(pick(['Dạ em chưa rõ ý Anh/Chị lắm ạ. Anh/Chị đang muốn hỏi về vị trí, loại căn hay giá ạ?', 'Dạ Anh/Chị nói rõ hơn giúp em một chút được không ạ, ví dụ "cách biển bao xa" hay "có mấy loại căn"?']), ['Vị trí dự án', 'Loại căn hộ']);
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
    if (best.ask && !(best.hk && EVT_ON) && !phone && !refused && turn - lastAsk >= 3 && (best.strong || turn >= 2)) { lastAsk = turn; txt += '\n' + best.ask; asked = true; }
    /* Chưa hỏi lại khách thì mở tiếp câu chuyện thứ hai */
    else if (!/\?\s*$/.test(txt) && HOOK[best.id]) {
      var hs = HOOK[best.id].filter(function (h) { return h[0] && (h[1] !== 'lead' || (!phone && !refused && turn - lastAsk >= 2)); });
      if (hs.length) { var h = pick(hs); txt += '\n' + h[0]; lastHook = h[1] || null; if (h[1] === 'lead') lastAsk = turn; }
    }
    if (asked) lastHook = 'lead';
    else if (best.hk && /\?\s*$/.test(txt)) lastHook = best.hk;
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
