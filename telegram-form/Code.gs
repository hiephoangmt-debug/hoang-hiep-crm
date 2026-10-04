/**
 * Báo khách Sun FourS Tower về Telegram.
 *
 * Các trang LadiPage (form đăng ký + chat tư vấn) gửi dữ liệu khách tới Web App này,
 * script chuyển thành tin nhắn Telegram gửi cho Giám đốc kinh doanh.
 *
 * CÀI ĐẶT (làm 1 lần):
 *  1. Dán mã bot (lấy từ @BotFather) vào TELEGRAM_TOKEN bên dưới, bấm Lưu.
 *  2. Mở Telegram, tìm bot vừa tạo, bấm Start và nhắn cho bot 1 tin bất kỳ (vd: "chào").
 *  3. Trong Apps Script chọn hàm layChatId ở thanh trên, bấm Chạy, cấp quyền.
 *     Telegram sẽ nhận tin "Đã kết nối" là xong.
 *  4. Triển khai > Tùy chọn triển khai mới > Ứng dụng web:
 *     Thực thi dưới tên: Tôi · Người có quyền truy cập: Bất kỳ ai > Triển khai.
 *     Gửi link Web App (…/exec) cho người làm trang để gắn vào LadiPage.
 */

const TELEGRAM_TOKEN = 'DÁN_MÃ_BOT_VÀO_ĐÂY';
const KEY = 'sft-tg-4821';   // khóa đơn giản, trùng với ?key= trong link gắn trên trang

function doPost(e) {
  if (!e || !e.parameter || e.parameter.key !== KEY) return out('sai khóa');
  let d = {};
  try { d = JSON.parse(e.postData.contents); } catch (err) { d = e.parameter || {}; }
  if (d._hp) return out('bỏ qua');           // ô bẫy chống bot spam
  if (quaNhieu()) return out('quá nhiều yêu cầu');
  gui(soanTin(d));
  return out('ok');
}

function doGet() { return out('Telegram báo khách Sun FourS Tower đang chạy'); }

// Soạn nội dung tin nhắn
function soanTin(d) {
  const L = [];
  if (d.thong_bao) L.push('💬 <b>KHÁCH ĐANG CHAT</b> (chưa để số)');
  else L.push('🔥 <b>KHÁCH MỚI ĐỂ LẠI SỐ</b>' + (/chat/i.test(d.interest || '') ? ' – qua chat' : ''));
  if (d.phone) {
    const so = String(d.phone).replace(/[^\d]/g, '');
    L.push('📞 <b>' + esc(d.phone) + '</b>' + (d.name ? ' – ' + esc(d.name) : '') + ' · <a href="https://zalo.me/' + so + '">Mở Zalo</a>');
  }
  const TRUONG = [
    ['interest', 'Quan tâm'], ['nhu_cau', 'Nhu cầu'], ['tai_chinh', 'Tài chính'],
    ['ma_can', 'Mã căn'], ['can_quan_tam', 'Căn quan tâm'], ['type', 'Loại căn'],
    ['need', 'Phương án'], ['yeu_cau', 'Yêu cầu'], ['cau_hoi', 'Câu hỏi'], ['bang_tinh', 'Bảng tính']
  ];
  TRUONG.forEach(function (t) { if (d[t[0]]) L.push('• ' + t[1] + ': ' + esc(cat(d[t[0]], 300))); });
  const kenh = d.gclid ? 'Google Ads' : d.fbclid ? 'Facebook' : d.ttclid ? 'TikTok' : '';
  const nguon = [d.utm_source, d.utm_campaign, kenh].filter(function (x) { return x; }).join(' / ');
  if (nguon) L.push('• Nguồn: ' + esc(nguon));
  if (d.source) L.push('• Trang: ' + esc(d.source));
  L.push('🕒 ' + esc(d.time || Utilities.formatDate(new Date(), 'Asia/Ho_Chi_Minh', 'HH:mm dd/MM/yyyy')));
  if (d.hoi_thoai) { L.push(''); L.push('<b>Nội dung chat:</b>'); L.push(esc(cat(d.hoi_thoai, 2000, true))); }
  return L.join('\n');
}

// Gửi tới 1 hoặc nhiều người/nhóm (TELEGRAM_CHAT_ID có thể là "id1,id2")
function gui(text) {
  const chat = PropertiesService.getScriptProperties().getProperty('TELEGRAM_CHAT_ID');
  if (!chat) throw new Error('Chưa có TELEGRAM_CHAT_ID – chạy hàm layChatId trước');
  chat.split(',').forEach(function (id) {
    UrlFetchApp.fetch('https://api.telegram.org/bot' + TELEGRAM_TOKEN + '/sendMessage', {
      method: 'post', contentType: 'application/json', muteHttpExceptions: true,
      payload: JSON.stringify({chat_id: id.trim(), text: text, parse_mode: 'HTML', disable_web_page_preview: true})
    });
  });
}

// Chạy 1 lần sau khi đã nhắn cho bot: lưu chat id của người vừa nhắn và gửi tin thử
function layChatId() {
  const r = JSON.parse(UrlFetchApp.fetch('https://api.telegram.org/bot' + TELEGRAM_TOKEN + '/getUpdates', {muteHttpExceptions: true}).getContentText());
  if (!r.ok) throw new Error('Mã bot chưa đúng: ' + (r.description || ''));
  const tin = (r.result || []).map(function (u) { return u.message || u.channel_post || u.my_chat_member; }).filter(function (m) { return m && m.chat; });
  if (!tin.length) throw new Error('Chưa thấy tin nhắn nào – mở Telegram, bấm Start và nhắn cho bot 1 tin rồi chạy lại');
  const chat = tin[tin.length - 1].chat;
  PropertiesService.getScriptProperties().setProperty('TELEGRAM_CHAT_ID', String(chat.id));
  gui('✅ Đã kết nối! Khách để lại số hoặc đang chat trên trang Sun FourS Tower sẽ báo về đây.');
  Logger.log('Đã lưu chat id: ' + chat.id + ' (' + (chat.title || chat.first_name || '') + ')');
}

// Giới hạn 20 tin/phút để tránh bị spam
function quaNhieu() {
  const c = CacheService.getScriptCache(), n = Number(c.get('dem') || 0);
  if (n >= 20) return true;
  c.put('dem', String(n + 1), 60);
  return false;
}

function cat(s, n, cuoi) { s = String(s); return s.length <= n ? s : (cuoi ? '…' + s.slice(-n) : s.slice(0, n) + '…'); }
function esc(s) { return String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;'); }
function out(s) { return ContentService.createTextOutput(s); }
