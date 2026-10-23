/**
 * ChatAI.gs – TRẢ LỜI CHAT WEBSITE BẰNG AI cho "CRM Hoàng Hiệp".
 * Dùng chung khoá AI "quân sư" đã cài (menu CRM > Cài khoá quân sư). Không cần khoá mới.
 * Cài: Apps Script → + → Tệp lệnh → tên "ChatAI" → dán file này → Lưu.
 * (Mới) Trong Mã.gs, hàm doGet, ngay dưới dòng  function doGet(e) {  thêm:
 *     if (e && e.parameter && e.parameter.cb) return jsonp_(e.parameter);
 * Rồi trong Mã.gs, hàm doPost, ngay dưới dòng  if (!site) return json_({ error: 'Mã website không hợp lệ' });
 * thêm 1 dòng:
 *     if (b.action === 'chat') return json_(chatAI_(b, site));
 * Lưu → Triển khai → Quản lý bản triển khai → ✏️ → Phiên bản mới → Triển khai.
 */
var CHAT_MODEL = 'claude-haiku-5-5';
var CHAT_MODEL_2 = 'claude-sonnet-5-5';   // dùng khi model nhanh không trả lời

var CHAT_FACTS = [
  'DỰ ÁN: Khu căn hộ du lịch, thương mại dịch vụ Hải Minh (Căn hộ khách sạn / Sun Saphia Residence Đà Nẵng).',
  'Vị trí: Lô A2-1 & A2-2, góc Võ Nguyên Giáp – Trường Sa – Nguyễn Đức Thuận, phường Ngũ Hành Sơn, TP Đà Nẵng. Băng qua đường và công viên là bãi biển Mỹ Khê – Non Nước.',
  'Phía trước: khu đất ven biển được TP quy hoạch làm Công viên công cộng đường Trường Sa (khoảng 2,45 ha, thu hồi từ khu Hòn Ngọc Á Châu, vốn ngân sách hơn 47 tỷ, dự kiến 2025–2027, tiến độ theo thành phố). Quanh khu có chuỗi bãi tắm công cộng: bãi tắm Sơn Thủy (đang hoạt động), công viên biển Trường Sa trước dự án, công viên biển cuối đường Huyền Trân Công Chúa (theo quy hoạch). KHÔNG nói "đối diện Silver Shores". Dọc Võ Nguyên Giáp phía Bắc có chuỗi resort lân cận: Crowne Plaza Danang (Silver Shores), TIA Wellness Resort, Trung tâm Hội nghị Ariyana, Furama Resort Danang, Pullman Danang Beach Resort; phía Nam: Hyatt Regency Danang và bãi tắm Sơn Thủy. Không xếp hạng "nổi tiếng nhất".',
  'Khoảng cách ước tính bằng ô tô: phố An Thượng 5–10 phút; Ngũ Hành Sơn 5–10 phút; cầu Rồng / trung tâm TP khoảng 15 phút; sân bay quốc tế Đà Nẵng 10–15 phút; phố cổ Hội An khoảng 30 phút.',
  'Chủ đầu tư: Công ty TNHH Quản lý và Dịch vụ Hạ tầng Kỹ thuật Miền Trung.',
  'Quy mô: 1 tòa tháp 30 tầng, cao khoảng 114 m, 782 căn hộ du lịch, tổng sàn xây dựng trên 45.000 m², khu đất 3.720 m² (Khu Khách sạn, Condotel và dân cư Saphia). Có khối thương mại dịch vụ.',
  'Loại căn: Studio 30–31 m² (513 căn), 1PN+1 50–51 m² (108 căn), 2PN 60–70 m² (149 căn).',
  'Pháp lý đất: đất thương mại dịch vụ, Nhà nước giao đất có thu tiền sử dụng đất, thời hạn 50 năm (17/9/2026 – 16/9/2076); UBND TP Đà Nẵng ban hành quyết định điều chỉnh thời hạn sử dụng đất (10/2026). Loại hình căn hộ du lịch (condotel), KHÔNG phải chung cư ở lâu dài.',
  'Tình trạng: đang thi công, DỰ KIẾN ra mắt 11/2026. Giá bán, chính sách thanh toán, ngân hàng cho vay, mặt bằng chi tiết, tiện ích, đơn vị vận hành, số đêm chủ căn tự ở, tỷ lệ chia doanh thu, tiến độ bàn giao: CHƯA công bố – chủ đầu tư công bố khi ra mắt.',
  'Kiến trúc theo phối cảnh: tháp thẳng, mặt dài hướng biển, kính xanh nhạt, đường viền sáng chạy dọc, ban công/trụ màu đồng ở hai đầu hồi, đỉnh bậc góc bo; 2 tầng đế mặt kính. Vị trí góc Trường Sa – Nguyễn Đức Thuận; phía Bắc là trung tâm thương mại VV Mall. Trang có mô hình minh họa 3D·4D·5D (xoay, nắng theo giờ, view từ tầng). Website: www.sun-saphia-residence.com.',
  'Giá phòng ven biển trục Võ Nguyên Giáp phổ biến khoảng 1–3 triệu/đêm (giá công khai trên nền tảng đặt phòng). Du lịch Đà Nẵng 11 tháng 2025: 16,5 triệu lượt khách lưu trú (+18,9%), khách quốc tế khoảng 7 triệu (+26,5%) – Cục Thống kê TP Đà Nẵng.',
  'Lợi thế Đà Nẵng: trung tâm miền Trung, sau hợp nhất với Quảng Nam (7/2025) có cả Hội An, Mỹ Sơn, Cù Lao Chàm; sân bay quốc tế ngay nội thành, về Sun Saphia Residence khoảng 10–15 phút, thêm sân bay Chu Lai; bay thẳng tới Hàn Quốc, Nhật Bản, Trung Quốc, Đài Loan, Singapore, Thái Lan, Ấn Độ…; ga đường sắt Bắc–Nam, cảng Tiên Sa đón tàu du lịch, đường sắt tốc độ cao và đường sắt đô thị đang theo quy hoạch (tiến độ theo Nhà nước); thành phố sạch, trật tự, người dân hiền hòa mến khách; biển Mỹ Khê – Non Nước cát mịn bờ thoải; nhiều điểm du lịch (Bà Nà Hills ~45 phút, Mikazuki ~35 phút, Suối Lương – đèo Hải Vân, Sơn Trà, Ngũ Hành Sơn, Hội An ~30 phút, Mỹ Sơn, Cù Lao Chàm, lễ hội pháo hoa; cố đô Huế ~2 giờ), chi phí sinh hoạt hợp lý, hợp lưu trú dài ngày. Không so sánh chê nơi khác, không nói "nhất".',
  'Đà Nẵng: Khu thương mại tự do (QĐ 1142/QĐ-TTg, 6/2025, ~1.881 ha); Trung tâm tài chính quốc tế (NQ 222/2025/QH15).',
  'Hạ tầng (theo quy hoạch, tiến độ do Nhà nước quyết định): đường sắt đô thị tuyến sân bay Đà Nẵng – Hội An giai đoạn 1 ~30,2 km, 14 ga, dự kiến khởi công 2/2027, khai thác ~2032 (Tuổi Trẻ 4/2026); TP đã thống nhất hướng tuyến mở rộng trục ven biển Hoàng Sa – Võ Nguyên Giáp – Trường Sa – Hội An.',
  'Thị trường: giá chào bán tham khảo một số dự án căn hộ mặt biển Đà Nẵng: studio ~4,6–10,5 tỷ, 1PN ~5,4–11,5 tỷ, 2PN ~6,8–21,7 tỷ (tổng hợp thị trường). KHÔNG nêu tên dự án khác, KHÔNG nói đây là giá Sun Saphia Residence.',
  'Giấy chứng nhận cho căn hộ du lịch: theo quy định pháp luật tại thời điểm cấp và hồ sơ dự án – KHÔNG hứa trước.',
  'Chuyển nhượng / bán lại: thực hiện theo hợp đồng mua bán và quy định pháp luật; điều kiện cụ thể nằm trong hợp đồng mẫu khi ra mắt.',
  'Không thu tiền giữ chỗ / đặt cọc ở giai đoạn này; đăng ký nhận thông tin miễn phí.',
  'Liên hệ: chuyên viên Hoàng Hiệp – Hotline/Zalo 0904 567 009 (chỉ dùng số này).'
].join('\n');


var SAPHIA_FACTS = [
  'DỰ ÁN: Sun Saphia Residence – căn hộ mặt biển tại khu Saphia, phường Ngũ Hành Sơn, Đà Nẵng, trên trục biển Võ Nguyên Giáp – Trường Sa, cạnh bãi tắm Sơn Thủy. Theo tài liệu giới thiệu, dự án do Sun Property phát triển.',
  'Quy mô (theo tài liệu giới thiệu): khu đất 3.720,1 m²; 1 tòa 30 tầng ~114 m; 2 tầng hầm; 782 căn. Cơ cấu: Studio 30–31 m² (layout 3,8 × 9,0 m, 513 căn), 1PN+1 50–51 m² (6,2 × 9,0 m, 108 căn), 2PN 60–70 m² (7,25 × 9,9 m, ở các góc tòa, 149 căn). Mặt bằng tầng điển hình 3A–28: thân dọc Trường Sa có dãy căn hướng biển, cánh phía Bắc chạy vào dọc Nguyễn Đức Thuận, đầu phía Nam có 2 căn 2PN nhô ra phía biển; mỗi tầng 28 căn (19 Studio, 4 căn 1PN+1, 5 căn 2PN ở các góc bo cong); Studio có WC vách kính + chỗ máy giặt, ban công và lô gia điều hòa; 1PN+1 có góc +1 và ban công phía phòng khách; 2PN có mặt kính bo cong, 2 WC, phòng giặt, bếp chữ L, lô gia; mỗi tầng có 3 hướng view: biển, sông Hàn, đô thị. Theo phối cảnh, phía trước tòa (hướng Trường Sa) có hồ bơi trên khối đế; danh mục tiện ích chính thức theo công bố của chủ đầu tư.',
  'Dự kiến mở bán cuối tháng 11/2026; dự kiến bàn giao tháng 11/2028 (theo kế hoạch, có thể thay đổi).',
  'Giá bán, chính sách thanh toán, ngân hàng, hỗ trợ lãi suất, pháp lý (loại hình, thời hạn), tiện ích nội khu, đơn vị vận hành: CHƯA công bố – chủ đầu tư công bố khi mở bán.',
  'Vị trí: góc Nguyễn Đức Thuận – Trường Sa (phía Tây đường). Đối diện bên kia Trường Sa là dải đất resort ven biển (Hòn Ngọc Á Châu, đang điều chỉnh quy hoạch). Công viên biển Trường Sa ~2,45 ha (thu hồi phần phía Nam khu Hòn Ngọc Á Châu, vốn ngân sách hơn 47 tỷ, kế hoạch 2025–2027) nằm cuối đường Minh Mạng, chếch phía Nam dự án – KHÔNG nói công viên ở ngay trước mặt. Gần bãi tắm Sơn Thủy (dự án Công viên, CLB thể thao biển và bãi tắm Sơn Thủy, phương án khảo sát phê duyệt QĐ 130 ngày 20/3/2025); công viên cuối đường Huyền Trân Công Chúa theo quy hoạch.',
  'Mô hình minh họa 3D · 4D · 5D (xoay tòa tháp, xem nắng theo giờ, view từ tầng): https://www.sun-saphia-residence.com/#ss4d – khi khách muốn xem mô hình/4D/view căn, gửi đúng link này.',
  'Khoảng cách ước tính bằng ô tô: sân bay 10–15 phút; cầu Rồng – trung tâm ~15 phút; Ngũ Hành Sơn, An Thượng 5–10 phút; Hội An ~30 phút; Bà Nà ~45 phút.',
  'Hạ tầng (theo quy hoạch): đường sắt đô thị sân bay – Hội An dự kiến khởi công 2/2027; mở rộng trục ven biển Võ Nguyên Giáp – Trường Sa. Du lịch Đà Nẵng 11 tháng 2025: 16,5 triệu lượt khách lưu trú.',
  'Giá phòng ven biển trục Võ Nguyên Giáp phổ biến khoảng 1–3 triệu/đêm. Không thu tiền giữ chỗ/đặt cọc ở giai đoạn này.',
  'Liên hệ: chuyên viên Hoàng Hiệp – Hotline/Zalo 0904 567 009. Trang thông tin do chuyên viên tư vấn thực hiện, không phải website chủ đầu tư.'
].join('\n');

var CHAT_RULES = [
  'Bạn là trợ lý tư vấn của chuyên viên Hoàng Hiệp cho dự án Sun Saphia Residence Đà Nẵng, chat trên website.',
  'Xưng "em", gọi khách "anh/chị". Trả lời tiếng Việt, ấm áp, tự nhiên như người thật, NGẮN (2–4 câu, tối đa ~70 từ), không dùng markdown, không gạch đầu dòng dài.',
  'Hiểu cả câu viết tắt, không dấu, sai chính tả (vd "ko"=không, "dc"=được, "bn"=bao nhiêu, "can"=căn).',
  'Chỉ dùng THÔNG TIN DỰ ÁN bên dưới. Điều chưa có hoặc chưa công bố: nói thật là chủ đầu tư sẽ công bố khi ra mắt và đề nghị gửi ngay khi có. Không bịa số liệu.',
  'TUYỆT ĐỐI KHÔNG: hứa/cam kết lợi nhuận, nói "chắc chắn tăng giá", "sở hữu lâu dài", "nhất/đầu tiên/duy nhất", nhận đặt cọc/giữ chỗ, so sánh chê dự án khác, nhắc đến Sun Group. Mọi con số thu nhập phải kèm "chỉ là ví dụ minh họa, không phải cam kết".',
  'Cuối mỗi câu trả lời, hỏi lại 1 câu ngắn khéo léo để hiểu nhu cầu (mục đích mua, số người, tầm tài chính, loại căn, thời gian ra xem), HOẶC mời để lại số Zalo để nhận tài liệu – không ép, không lặp lại lời mời nếu vừa mời ở câu trước.',
  'Nếu khách hỏi giá có tăng không: nói trục Võ Nguyên Giáp – Trường Sa thuộc nhóm tuyến có giá đất cao trong bảng giá đất của TP, quỹ đất mặt biển có hạn, nhu cầu du lịch tăng; nhưng KHÔNG khẳng định giá sẽ tăng, nói rõ quá khứ không bảo đảm tương lai.',
  'Nếu khách hỏi ngoài dự án/bất động sản: trả lời lịch sự 1 câu và lái về dự án.',
  'Nếu khách để lại số điện thoại: cảm ơn và nói chuyên viên sẽ nhắn Zalo sớm.'
].join('\n');

function chatAI_(b, site) {
  var q = String(b.q || '').slice(0, 500).trim();
  if (!q) return { error: 'empty' };
  var key = PropertiesService.getScriptProperties().getProperty('ANTHROPIC_KEY') || '';
  if (!key) return { error: 'nokey' };
  var cache = CacheService.getScriptCache();
  var g = Number(cache.get('chat_g') || 0); if (g >= 40) return { error: 'busy' };
  cache.put('chat_g', String(g + 1), 60);
  var vk = 'chat_v_' + String(b.vid || '').slice(0, 40), v = Number(cache.get(vk) || 0);
  if (v >= 25) return { error: 'limit' };
  cache.put(vk, String(v + 1), 3600);

  var hist = [];
  try { hist = JSON.parse(b.history || '[]'); } catch (e) { hist = []; }
  var msgs = [];
  hist.slice(-8).forEach(function (m) {
    if (!m || !m.t) return;
    var role = m.r === 'me' ? 'user' : 'assistant';
    if (msgs.length && msgs[msgs.length - 1].role === role) msgs[msgs.length - 1].content += '\n' + String(m.t).slice(0, 600);
    else msgs.push({ role: role, content: String(m.t).slice(0, 600) });
  });
  while (msgs.length && msgs[0].role !== 'user') msgs.shift();
  if (msgs.length && msgs[msgs.length - 1].role === 'user') msgs[msgs.length - 1].content += '\n' + q;
  else msgs.push({ role: 'user', content: q });

  var isSaphia = true; // Hải Minh đã đổi tên thành Sun Saphia Residence – dùng chung thông tin
  var rules = isSaphia
    ? CHAT_RULES.replace(/cho dự án Sun Saphia Residence Đà Nẵng/, 'cho dự án Sun Saphia Residence Đà Nẵng').replace(/, nhắc đến Sun Group/, ', nói "đầu tiên", hứa chủ đầu tư chịu lãi suất')
    : CHAT_RULES;
  var system = rules + '\n\nKhách đang đọc phần: ' + String(b.topic || 'không rõ').slice(0, 40)
    + '\n\nTHÔNG TIN DỰ ÁN:\n' + (isSaphia ? SAPHIA_FACTS : CHAT_FACTS);
  var models = [CHAT_MODEL, CHAT_MODEL_2], last = '';
  for (var i = 0; i < models.length; i++) {
    try {
      var res = UrlFetchApp.fetch('https://api.anthropic.com/v1/messages', {
        method: 'post', contentType: 'application/json', muteHttpExceptions: true,
        headers: { 'x-api-key': key, 'anthropic-version': '2023-06-01' },
        payload: JSON.stringify({ model: models[i], max_tokens: 600, system: system, messages: msgs })
      });
      var code = res.getResponseCode(), body = {};
      try { body = JSON.parse(res.getContentText()); } catch (e) {}
      if (code !== 200) { last = 'ai ' + code + ' ' + ((body.error && body.error.message) || ''); continue; }
      var a = (body.content || []).filter(function (x) { return x.type === 'text'; }).map(function (x) { return x.text || ''; }).join('').trim();
      if (!a) { last = 'empty answer (' + (body.stop_reason || '') + ')'; continue; }
      try { if (typeof logChat_ === 'function') logChat_(b, site, q, a); } catch (e) {}
      return { ok: true, a: a };
    } catch (err) { last = String(err && err.message || err); }
  }
  return { error: last };
}

/** Chạy thử trong Apps Script → xem Nhật ký thực thi */
function thuChatAI() {
  Logger.log(JSON.stringify(chatAI_({ q: 'xa trung tâm ko', vid: 'test', topic: 'vi-tri' }, { name: 'Sun Saphia Residence' })));
  Logger.log(JSON.stringify(chatAI_({ q: 'bán có lấy dc căn ko', vid: 'test', topic: 'phap-ly' }, { name: 'Sun Saphia Residence' })));
}

/**
 * Gọi kiểu JSONP (GET + callback) – không bị trình duyệt chặn CORS.
 * Trong Mã.gs, hàm doGet, thêm 1 dòng NGAY SAU dòng  function doGet(e) {
 *     if (e && e.parameter && e.parameter.cb) return jsonp_(e.parameter);
 */
function jsonp_(p) {
  var cb = String(p.cb || '');
  if (!/^[A-Za-z_$][\w$.]{0,60}$/.test(cb)) cb = 'cb';
  var out;
  try {
    var site = findSite_(p.key);
    if (!site) out = { error: 'Mã website không hợp lệ' };
    else if (p.action === 'chat') out = chatAI_(p, site);
    else if (p.action === 'track') out = handleTrack_(p, site);
    else if (p.action === 'lead') out = handleLead_(normLeadBody_(p), site);
    else out = { ok: true, service: 'CRM Hoàng Hiệp' };
  } catch (err) { out = { error: String(err && err.message || err) }; }
  return ContentService.createTextOutput(cb + '(' + JSON.stringify(out) + ');').setMimeType(ContentService.MimeType.JAVASCRIPT);
}
