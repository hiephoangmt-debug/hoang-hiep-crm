// ===== PHẦN 1/3: Cấu hình + nhận dữ liệu (dán vào file Phan1.gs) =====
/**
 * CASAMIA BALANCA – Chat & Lead qua Google Sheet + Telegram (miễn phí, không cần server)
 *
 * Cách cài: xem livechat/HUONG-DAN-GOOGLE.md
 *  1. Tạo Google Sheet → Tiện ích mở rộng → Apps Script → dán toàn bộ file này.
 *  2. Điền 3 dòng cấu hình bên dưới.
 *  3. Triển khai → Ứng dụng web (Thực thi: Tôi · Ai có quyền truy cập: Bất kỳ ai) → copy URL /exec.
 *  4. Dán URL đó vào WEB_APP_URL, lưu, chạy hàm caiDatTelegram() một lần.
 *
 * Chat AI (tuỳ chọn): thêm file AI.gs và KienThuc.gs, đặt ANTHROPIC_API_KEY trong Thuộc tính tập lệnh.
 *
 * Sheet tự tạo: Lead (khách để lại số), Chat (tin nhắn), TraLoi (câu trả lời từ Telegram), Map (nội bộ).
 */

// ====== CẤU HÌNH ======
const TELEGRAM_BOT_TOKEN = '';   // token bot từ @BotFather, ví dụ '123456789:AAH...'
const TELEGRAM_CHAT_ID = '';     // chat ID nhận thông báo; nhiều người/nhóm: '5111,-100222'
const WEB_APP_URL = '';          // URL ứng dụng web sau khi Triển khai (kết thúc bằng /exec)

const ZALO = '0904567009';
const ZALO_INVITE = 'Dạ để em gửi anh/chị trọn bộ tài liệu (bảng giá, mặt bằng, chính sách, hình ảnh thực tế) cho tiện xem lại, mình kết bạn Zalo ' + ZALO + ' với em nhé. Anh/chị bấm nút bên dưới là nhận được ngay ạ 👇';
const QUIET_MS = 60 * 1000;      // gộp thông báo: cùng khách nhắn liên tục chỉ báo 1 lần/phút
// ======================

const ID_RE = /^[a-zA-Z0-9-]{16,64}$/;
const HDR = {
  Lead: ['Thời gian', 'Họ tên', 'Số điện thoại', 'Nhu cầu', 'Nguồn (form)', 'Nguồn quảng cáo', 'Trang', 'Mã khách'],
  Chat: ['Thời gian', 'Mã khách', 'Người gửi', 'Nội dung'],
  TraLoi: ['Mã', 'Mã khách', 'Nội dung', 'Thời điểm (ms)', 'Hành động'],
  Map: ['Khoá', 'Mã khách'],
};

function sheet_(name) {
  const ss = SpreadsheetApp.getActive();
  let sh = ss.getSheetByName(name);
  if (!sh) {
    sh = ss.insertSheet(name);
    sh.appendRow(HDR[name]);
    sh.setFrozenRows(1);
    sh.getRange(1, 1, 1, HDR[name].length).setFontWeight('bold').setBackground('#0b2a5b').setFontColor('#ffffff');
  }
  return sh;
}
function json_(o) {
  return ContentService.createTextOutput(JSON.stringify(o)).setMimeType(ContentService.MimeType.JSON);
}
function clean_(s, max) { return String(s == null ? '' : s).trim().slice(0, max || 2000); }
function esc_(s) { return String(s == null ? '' : s).replace(/[&<>]/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;' }[c]; }); }
function now_() { return new Date(); }

// ---------- Nhận dữ liệu ----------
function doGet(e) {
  const p = (e && e.parameter) || {};
  if (p.action === 'replies') {
    const v = String(p.v || ''), after = Number(p.after || 0);
    if (!ID_RE.test(v)) return json_({ ok: false });
    const sh = sheet_('TraLoi');
    const last = sh.getLastRow();
    if (last < 2) return json_({ ok: true, replies: [] });
    const start = Math.max(2, last - 500);
    const rows = sh.getRange(start, 1, last - start + 1, 5).getValues();
    const replies = rows
      .filter(function (r) { return r[1] === v && Number(r[3]) > after; })
      .map(function (r) { return { id: String(r[0]), text: String(r[2]), at: Number(r[3]), action: r[4] || undefined }; });
    return json_({ ok: true, replies: replies });
  }
  return json_({ ok: true, service: 'casamia-chat' });
}

function doPost(e) {
  let body = {};
  try { body = JSON.parse((e && e.postData && e.postData.contents) || '{}'); } catch (err) {}
  if (body.update_id !== undefined) {
    handleTelegram_(body);
    return; // không trả nội dung → Google trả 200 trực tiếp, Telegram không gửi lặp
  }
  return json_(handleWidget_(body));
}

