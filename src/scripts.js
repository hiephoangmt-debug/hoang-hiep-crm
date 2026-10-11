// Thư viện kịch bản: cách mở lời, câu hỏi khai thác, giữ quan hệ.
// Biến: {xung} (anh/chị), {ten}, {toi} (tên sale), {cty}, {trang}, {du_an}, {khu_vuc}, {loai}, {ngay_dk}

export const SCRIPT_GROUPS = {
  goi_dau: 'Cuộc gọi đầu tiên (khách mới từ web)',
  khai_thac: 'Câu hỏi khai thác nhu cầu',
  khong_nghe: 'Khách không nghe máy – tin nhắn Zalo/SMS',
  theo_doi: 'Theo dõi sau khi gửi thông tin',
  ham_nong: 'Hâm nóng khách lâu không liên lạc',
  du_an_moi: 'Mời dự án mới',
  sau_ban: 'Chăm sóc sau bán',
  bat_chuyen: 'Bắt chuyện, giữ quan hệ (không bán hàng)',
  phan_doi: 'Xử lý từ chối',
  dip_le: 'Chúc mừng sinh nhật / dịp lễ',
};

export const SCRIPTS = [
  // --- Cuộc gọi đầu ---
  { group: 'goi_dau', title: 'Mở lời nhắc đúng trang khách đăng ký',
    text: 'Em chào {xung} {ten}, em là {toi} bên {cty}. Em thấy {xung} vừa để lại thông tin trên trang {trang} lúc {ngay_dk} về {du_an}. {xung} đang tìm hiểu để ở hay đầu tư ạ? Em xin 2 phút gửi {xung} thông tin chuẩn nhất nhé.' },
  { group: 'goi_dau', title: 'Mở lời nhẹ nhàng, hỏi giờ tiện',
    text: 'Dạ em chào {xung} {ten}, em {toi} gọi từ {cty} về {du_an} {xung} vừa quan tâm ạ. Không biết giờ này {xung} nói chuyện tiện không, hay em gọi lại lúc nào thuận cho {xung} hơn ạ?' },
  { group: 'goi_dau', title: 'Mở lời bằng giá trị (bảng giá / chính sách)',
    text: 'Em chào {xung} {ten}, em {toi} đây ạ. {xung} vừa đăng ký nhận bảng giá {du_an}, em gửi {xung} qua Zalo số này luôn được không ạ? Đợt này có chính sách chiết khấu/thanh toán giãn khá tốt, em tóm tắt nhanh 3 điểm chính cho {xung} nhé.' },

  // --- Khai thác ---
  { group: 'khai_thac', title: 'Mục đích', text: '{xung} mua để ở cho gia đình hay để đầu tư/cho thuê ạ? Nếu để ở thì nhà mình có mấy người, cần mấy phòng ngủ ạ?' },
  { group: 'khai_thac', title: 'Ngân sách', text: 'Để em lọc đúng căn, {xung} dự tính tài chính khoảng bao nhiêu, và mình có dùng vay ngân hàng không ạ?' },
  { group: 'khai_thac', title: 'Khu vực', text: '{xung} đang ở/làm việc khu nào ạ? Mình ưu tiên gần chỗ làm, trường cho con hay khu đang lên giá ạ?' },
  { group: 'khai_thac', title: 'Thời điểm', text: '{xung} dự định xuống tiền trong khoảng bao lâu ạ – trong tháng này, quý này hay đang tìm hiểu dần ạ?' },
  { group: 'khai_thac', title: 'Người quyết định', text: 'Ngoài {xung} thì còn ai cùng quyết định không ạ? Em sắp xếp buổi xem nhà để cả nhà mình cùng đi cho tiện nhé.' },
  { group: 'khai_thac', title: 'Đã xem gì', text: '{xung} đã đi xem dự án nào chưa ạ? Điều gì làm {xung} chưa ưng ở các chỗ đã xem để em tránh giới thiệu trùng ạ?' },
  { group: 'khai_thac', title: 'Tiêu chí quan trọng nhất', text: 'Nếu chỉ chọn 1 điều quan trọng nhất – giá, vị trí, pháp lý hay tiện ích – thì {xung} chọn điều gì ạ?' },

  // --- Không nghe máy ---
  { group: 'khong_nghe', title: 'Zalo sau cuộc gọi nhỡ',
    text: 'Em chào {xung} {ten}, em là {toi} – {cty}. Em vừa gọi về thông tin {du_an} {xung} đăng ký trên {trang} nhưng chưa liên lạc được. Em gửi trước tài liệu tham khảo, {xung} tiện giờ nào nhắn em gọi lại nhé ạ!' },
  { group: 'khong_nghe', title: 'Nhắn lần 2 (ngắn gọn)',
    text: 'Dạ {xung} {ten} ơi, em {toi} đây ạ. Bảng giá {du_an} đợt này sắp điều chỉnh, {xung} cần em giữ căn hoặc gửi thông tin chi tiết thì nhắn em 1 chữ "OK" là được ạ.' },

  // --- Theo dõi ---
  { group: 'theo_doi', title: 'Hỏi cảm nhận tài liệu',
    text: 'Em chào {xung} {ten}, hôm trước em gửi {xung} thông tin {du_an}, {xung} xem qua thấy phần nào ưng nhất ạ? Có điểm nào {xung} còn băn khoăn em giải thích thêm nhé.' },
  { group: 'theo_doi', title: 'Mời xem nhà mẫu / thực tế',
    text: '{xung} {ten} ơi, cuối tuần này bên em có buổi tham quan nhà mẫu {du_an}, có xe đưa đón. {xung} sắp xếp được sáng thứ 7 hay chủ nhật để em đăng ký chỗ ạ?' },

  // --- Hâm nóng ---
  { group: 'ham_nong', title: 'Cập nhật thị trường',
    text: 'Em chào {xung} {ten}, lâu rồi em chưa hỏi thăm {xung}. Khu {khu_vuc} dạo này có vài thông tin mới về hạ tầng và giá, em nghĩ {xung} sẽ quan tâm. Em gửi {xung} bản tóm tắt ngắn nhé?' },
  { group: 'ham_nong', title: 'Hỏi nhu cầu còn không',
    text: 'Dạ {xung} {ten}, em {toi} đây ạ. Hồi trước {xung} có tìm {loai} khu {khu_vuc}, không biết hiện mình đã chọn được chưa hay vẫn đang tìm ạ? Em đang có vài căn đúng tầm đó.' },
  { group: 'ham_nong', title: 'Lãi suất / chính sách ngân hàng',
    text: '{xung} {ten} ơi, ngân hàng vừa có gói vay ưu đãi lãi suất mới cho người mua nhà. Nếu {xung} vẫn có kế hoạch mua {loai}, em tính giúp {xung} số tiền trả hàng tháng cụ thể nhé?' },

  // --- Dự án mới ---
  { group: 'du_an_moi', title: 'Báo trước dự án sắp mở bán',
    text: 'Em chào {xung} {ten}! Em nhớ {xung} có quan tâm {loai} khu {khu_vuc}. Sắp tới có dự án {du_an} mở bán, giá và vị trí khá hợp với nhu cầu {xung} nói lần trước. Em gửi {xung} thông tin sớm để mình có lợi thế chọn căn đẹp nhé?' },
  { group: 'du_an_moi', title: 'Mời sự kiện mở bán',
    text: '{xung} {ten} ơi, {du_an} có sự kiện giới thiệu sắp tới, khách tham dự được ưu tiên chọn căn và chiết khấu riêng. Em giữ cho {xung} 1–2 suất được không ạ?' },

  // --- Sau bán ---
  { group: 'sau_ban', title: 'Hỏi thăm sau mua',
    text: 'Em chào {xung} {ten}, mọi thủ tục căn nhà của mình ổn cả chứ ạ? Có việc gì cần hỗ trợ về giấy tờ, bàn giao hay cho thuê {xung} cứ gọi em nhé.' },
  { group: 'sau_ban', title: 'Xin giới thiệu',
    text: '{xung} {ten} ơi, cảm ơn {xung} đã tin tưởng em. Nếu bạn bè, người thân {xung} cũng đang tìm nhà, {xung} giới thiệu giúp em nhé, em sẽ chăm sóc chu đáo như với {xung} ạ.' },

  // --- Bắt chuyện, giữ quan hệ ---
  { group: 'bat_chuyen', title: 'Hỏi thăm gia đình', text: 'Dạo này {xung} và gia đình khoẻ không ạ? Các bé nhà mình đi học có vui không {xung}?' },
  { group: 'bat_chuyen', title: 'Hỏi thăm công việc', text: 'Công việc của {xung} dạo này bận không ạ? Cuối năm chắc nhiều việc lắm {xung} nhỉ.' },
  { group: 'bat_chuyen', title: 'Chia sẻ hữu ích', text: 'Em vừa đọc được bài về kinh nghiệm kiểm tra pháp lý khi mua nhà, thấy hay nên gửi {xung} tham khảo ạ – không phải quảng cáo đâu ạ 😄' },
  { group: 'bat_chuyen', title: 'Hỏi ý kiến (khách thích được tôn trọng)', text: '{xung} {ten} ơi, em muốn hỏi ý kiến {xung} chút: theo {xung} khu {khu_vuc} giờ người ta quan tâm nhất điều gì ạ? {xung} ở lâu nên chắc hiểu rõ hơn em.' },
  { group: 'bat_chuyen', title: 'Thời tiết / mùa', text: 'Mấy hôm nay trời chuyển mùa, {xung} giữ sức khoẻ nhé ạ. Em chỉ nhắn hỏi thăm {xung} thôi ạ!' },

  // --- Xử lý từ chối ---
  { group: 'phan_doi', title: '"Để anh/chị suy nghĩ thêm"',
    text: 'Dạ vâng, quyết định lớn nên mình cân nhắc kỹ là đúng ạ. Để {xung} dễ suy nghĩ hơn, {xung} cho em biết điều mình còn băn khoăn nhất là giá, vị trí hay pháp lý ạ? Em gửi thêm thông tin đúng phần đó.' },
  { group: 'phan_doi', title: '"Giá cao quá"',
    text: 'Dạ em hiểu ạ. {xung} đang so sánh với dự án nào để em làm bảng so sánh chi tiết (giá/m², tiện ích, pháp lý, tiến độ thanh toán) cho {xung} dễ nhìn nhé?' },
  { group: 'phan_doi', title: '"Đang chờ thị trường"',
    text: 'Dạ nhiều khách cũng nghĩ vậy ạ. Em xin phép mỗi tháng gửi {xung} 1 bản cập nhật ngắn về giá khu {khu_vuc}, khi nào thấy thời điểm hợp thì {xung} báo em nhé.' },
  { group: 'phan_doi', title: '"Đã có người tư vấn rồi"',
    text: 'Dạ tốt quá ạ. Em không làm phiền nhiều đâu, chỉ xin phép gửi {xung} thêm góc nhìn để so sánh – có thêm thông tin thì {xung} chọn được căn ưng nhất ạ.' },

  // --- Dịp lễ ---
  { group: 'dip_le', title: 'Chúc mừng sinh nhật',
    text: 'Em chúc mừng sinh nhật {xung} {ten}! Chúc {xung} một tuổi mới thật nhiều sức khoẻ, bình an và mọi việc như ý ạ 🎂' },
  { group: 'dip_le', title: 'Chúc dịp lễ',
    text: 'Nhân dịp {dip}, em {toi} kính chúc {xung} {ten} và gia đình thật nhiều sức khoẻ, an khang, vạn sự như ý ạ!' },
];

// Ngày lễ dương lịch + Tết âm lịch (tính sẵn đến 2030)
const SOLAR_HOLIDAYS = [
  ['01-01', 'Năm mới'], ['02-14', 'Lễ Tình nhân'], ['03-08', 'Quốc tế Phụ nữ 8/3'],
  ['04-30', 'Lễ 30/4 – 1/5'], ['06-01', 'Quốc tế Thiếu nhi'], ['09-02', 'Quốc khánh 2/9'],
  ['10-20', 'Phụ nữ Việt Nam 20/10'], ['11-20', 'Nhà giáo Việt Nam 20/11'], ['12-24', 'Giáng sinh'],
];
const LUNAR_NEW_YEAR = ['2026-02-17', '2027-02-06', '2028-01-26', '2029-02-13', '2030-02-03'];
const MID_AUTUMN = ['2026-09-25', '2027-09-15', '2028-10-03', '2029-09-22', '2030-09-12'];

export function localDate(d = new Date()) {
  const y = d.getFullYear();
  const m = String(d.getMonth() + 1).padStart(2, '0');
  const day = String(d.getDate()).padStart(2, '0');
  return `${y}-${m}-${day}`;
}

export function upcomingHolidays(from = new Date(), days = 5) {
  const out = [];
  for (let i = 0; i <= days; i++) {
    const d = new Date(from.getFullYear(), from.getMonth(), from.getDate() + i);
    const iso = localDate(d);
    for (const [md, name] of SOLAR_HOLIDAYS) if (iso.slice(5) === md) out.push({ date: iso, name, inDays: i });
    if (LUNAR_NEW_YEAR.includes(iso)) out.push({ date: iso, name: 'Tết Nguyên Đán', inDays: i });
    if (MID_AUTUMN.includes(iso)) out.push({ date: iso, name: 'Tết Trung thu', inDays: i });
  }
  return out;
}

const NEED_TYPE_LABEL = { can_ho: 'căn hộ', dat_nen: 'đất nền', nha_pho: 'nhà phố', biet_thu: 'biệt thự', shophouse: 'shophouse' };

export function fillTemplate(text, vars) {
  return text.replace(/\{(\w+)\}/g, (_, k) => (vars[k] !== undefined && vars[k] !== '' ? vars[k] : `[${k}]`))
    // viết hoa chữ đầu câu nếu bắt đầu bằng {xung}
    .replace(/(^|[.!?]\s+)([a-zà-ỹ])/g, (m, p, c) => p + c.toUpperCase());
}

export function templateVars(customer = {}, settings = {}, extra = {}) {
  const lastInq = extra.inquiry || {};
  const created = lastInq.created_at ? new Date(lastInq.created_at) : null;
  return {
    xung: customer.salutation || 'anh/chị',
    ten: (customer.name || '').trim().split(/\s+/).pop() || '',
    toi: settings.sales_name || '',
    cty: settings.company || '',
    trang: lastInq.page_url ? lastInq.source || lastInq.page_url : lastInq.source || 'website',
    du_an: extra.project || lastInq.project || 'dự án',
    khu_vuc: customer.need_area || 'mình quan tâm',
    loai: NEED_TYPE_LABEL[customer.need_type] || customer.need_type || 'nhà',
    ngay_dk: created ? created.toLocaleString('vi-VN', { hour: '2-digit', minute: '2-digit', day: '2-digit', month: '2-digit' }) : '',
    dip: extra.holiday || 'dịp lễ',
  };
}

function daysBetween(a, b) {
  return Math.floor((b - a) / 86400000);
}

// Chọn nhóm kịch bản phù hợp với tình trạng khách
export function pickGroups(customer, ctx = {}) {
  const now = ctx.now || new Date();
  const groups = [];
  const lastCall = ctx.lastActivity;
  if (customer.status === 'moi' && !ctx.hasContact) groups.push('goi_dau', 'khai_thac');
  if (lastCall && lastCall.outcome === 'khong_nghe') groups.push('khong_nghe');
  if (customer.status === 'da_mua') groups.push('sau_ban', 'bat_chuyen');
  const lastTouch = customer.last_contact_at ? new Date(customer.last_contact_at) : null;
  if (lastTouch && daysBetween(lastTouch, now) >= 21 && customer.status !== 'da_mua') groups.push('ham_nong', 'bat_chuyen');
  if (['dang_cham_soc', 'quan_tam'].includes(customer.status)) groups.push('theo_doi', 'khai_thac', 'phan_doi');
  if (['hen_xem', 'dam_phan'].includes(customer.status)) groups.push('phan_doi', 'theo_doi');
  if (ctx.isBirthday) groups.unshift('dip_le');
  if (!groups.length) groups.push('bat_chuyen', 'ham_nong');
  return [...new Set(groups)];
}

/** Trả về danh sách gợi ý đã điền tên, xoay vòng theo ngày để "lâu lâu" có câu mới. */
export function suggestFor(customer, settings, ctx = {}) {
  const now = ctx.now || new Date();
  const dayIndex = Math.floor(now.getTime() / 86400000) + (customer.id || 0);
  const vars = templateVars(customer, settings, ctx);
  const out = [];
  for (const g of pickGroups(customer, ctx)) {
    const list = SCRIPTS.filter((s) => s.group === g);
    const n = g === 'khai_thac' ? 3 : 2;
    for (let i = 0; i < Math.min(n, list.length); i++) {
      const s = list[(dayIndex + i) % list.length];
      out.push({ group: g, groupLabel: SCRIPT_GROUPS[g], title: s.title, text: fillTemplate(s.text, vars) });
    }
  }
  return out;
}

// Mẹo chăm sóc hiển thị trên trang "Hôm nay", đổi mỗi ngày
export const DAILY_TIPS = [
  'Gọi lead trong 5 phút đầu: khả năng khách nghe máy và nhớ mình cao gấp nhiều lần so với gọi sau 1 tiếng.',
  'Mở lời bằng đúng trang khách đã đăng ký ("anh/chị vừa xem dự án X trên trang Y") – khách sẽ không nghĩ là cuộc gọi rác.',
  'Không nghe máy? Gọi lại khung giờ khác (11h30–13h hoặc 19h–20h30) và nhắn Zalo ngay sau cuộc gọi nhỡ.',
  'Cứ 3 lần liên hệ thì chỉ 1 lần nói chuyện bán hàng, 2 lần còn lại là hỏi thăm hoặc chia sẻ thông tin hữu ích.',
  'Ghi lại chuyện cá nhân (con mấy tuổi, quê ở đâu, sở thích) vào "Ghi chú cá nhân" – lần sau hỏi thăm khách sẽ rất quý.',
  'Kết thúc mỗi cuộc gọi bằng một hẹn cụ thể: "Thứ 5 em gửi bảng giá và gọi lại lúc 8h tối được không ạ?"',
  'Khách nói "để suy nghĩ": hỏi họ băn khoăn nhất điều gì, đừng chỉ chào rồi cúp máy.',
  'Khách đã mua là nguồn giới thiệu tốt nhất – chúc mừng sinh nhật, ngày nhận nhà, và nhờ giới thiệu đúng lúc.',
  'Mỗi khi có dự án mới, vào mục Dự án để lọc khách đúng nhu cầu/ngân sách và gọi mời trước khi mở bán.',
  'Khách lạnh 1–2 tháng chưa phải khách mất: gửi cập nhật thị trường khu vực họ quan tâm để hâm nóng lại.',
];

export function dailyTip(now = new Date()) {
  return DAILY_TIPS[Math.floor(now.getTime() / 86400000) % DAILY_TIPS.length];
}
