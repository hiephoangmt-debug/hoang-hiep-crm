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

// ---------- Từ landing / khung chat ----------
function handleWidget_(b) {
  const v = String(b.v || '');
  if (!ID_RE.test(v)) return { ok: false, error: 'Thiếu mã khách' };
  const cache = CacheService.getScriptCache();
  const hits = Number(cache.get('rl_' + v) || 0);
  if (hits > 40) return { ok: false, error: 'Gửi quá nhiều, thử lại sau' };
  cache.put('rl_' + v, String(hits + 1), 600);

  const type = String(b.type || '');
  const transcript = Array.isArray(b.transcript) ? b.transcript.slice(-8) : [];
  const page = clean_(b.page, 300), utm = clean_(b.utm, 200);

  if (type === 'message') {
    const text = clean_(b.text);
    if (!text) return { ok: false };
    sheet_('Chat').appendRow([now_(), v, 'Khách', text]);
    // Chat AI (AI.gs): trả lời ngay nếu đã cài ANTHROPIC_API_KEY, lỗi thì khung chat dùng kịch bản soạn sẵn
    let ai = null;
    if (b.ai && typeof aiReply_ === 'function') {
      try { ai = aiReply_({ v: v, history: b.history, hasPhone: !!b.phone }); } catch (err) { console.warn(err); }
      if (ai) sheet_('Chat').appendRow([now_(), v, 'Bot AI', ai.text]);
    }
    const key = 'n_' + v;
    if (b.first || !cache.get(key)) {
      cache.put(key, '1', QUIET_MS / 1000);
      const list = transcript.concat(transcript.length && transcript[transcript.length - 1].text === text ? [] : [{ from: 'visitor', text: text }]);
      if (ai) list.push({ from: 'agent', auto: true, ai: true, text: ai.text });
      notify_(v, (b.first ? '🔔 <b>KHÁCH MỚI VÀO CHAT</b>' : '💬 <b>Tin nhắn mới</b>') + who_(b) + where_(page, utm) + '\n──────────\n\n' + transcript_(list));
    }
    return ai ? { ok: true, reply: ai.text, action: ai.action } : { ok: true };
  }

  if (type === 'lead') {
    const phone = clean_(b.phone, 20).replace(/[\s.-]/g, '');
    if (!/^(\+?84|0)\d{9}$/.test(phone)) return { ok: false, error: 'Số điện thoại chưa đúng' };
    const name = clean_(b.name, 100), need = clean_(b.need, 120), form = clean_(b.form, 60);
    sheet_('Lead').appendRow([now_(), name, "'" + phone, need, form, utm, page, v]);
    notify_(v, '🔥 <b>CÓ SỐ ĐIỆN THOẠI KHÁCH</b>\n👤 ' + esc_(name || '(chưa có tên)') + '\n📞 <b>' + esc_(phone) + '</b>' +
      (need ? '\n📝 ' + esc_(need) : '') + (form ? '\n🧾 ' + esc_(form) : '') + where_(page, utm) +
      (transcript.length ? '\n──────────\n\n' + transcript_(transcript) : '') + '\n\nGọi lại ngay: tel:' + esc_(phone));
    return { ok: true };
  }

  if (type === 'browse') {
    notify_(v, '👀 <b>KHÁCH ĐANG ĐỌC KỸ: ' + esc_(clean_(b.topic, 80).toUpperCase()) + '</b>' + where_(page, utm) +
      '\n──────────\n\n🤖 <b>TƯ VẤN (tự động)</b> đã hỏi:\n' + esc_(clean_(b.question, 500)));
    return { ok: true };
  }
  return { ok: false, error: 'Loại không hợp lệ' };
}

function who_(b) { return b.name || b.phone ? '\n👤 ' + esc_(b.name || '') + (b.phone ? ' – ' + esc_(b.phone) : '') : ''; }
function where_(page, utm) { return (utm ? '\n📣 ' + esc_(utm) : '') + (page ? '\n🌐 ' + esc_(page) : ''); }

// Hội thoại gần nhất, tách lượt KHÁCH / TƯ VẤN, mỗi lượt cách 1 dòng
function transcript_(list, extra) {
  const items = list.slice();
  if (extra && !(items.length && items[items.length - 1].text === extra)) items.push({ from: 'visitor', text: extra });
  const LABEL = { visitor: '🙋 <b>KHÁCH</b>', agent: '💼 <b>TƯ VẤN</b>', auto: '🤖 <b>TƯ VẤN (tự động)</b>', ai: '🧠 <b>TRỢ LÝ AI</b>' };
  const groups = [];
  items.forEach(function (m) {
    const k = m.from === 'visitor' ? 'visitor' : (m.ai ? 'ai' : m.auto ? 'auto' : 'agent');
    const t = String(m.text || '').slice(0, 300);
    const g = groups[groups.length - 1];
    if (g && g.k === k) g.lines.push(t); else groups.push({ k: k, lines: [t] });
  });
  const out = groups.map(function (g) { return LABEL[g.k] + '\n' + g.lines.map(esc_).join('\n'); }).join('\n\n');
  return out.length > 3000 ? '…' + out.slice(-3000) : out;
}

// ---------- Telegram ----------
function tg_(method, body) {
  if (!TELEGRAM_BOT_TOKEN) return null;
  const r = UrlFetchApp.fetch('https://api.telegram.org/bot' + TELEGRAM_BOT_TOKEN + '/' + method, {
    method: 'post', contentType: 'application/json', payload: JSON.stringify(body), muteHttpExceptions: true,
  });
  try { return JSON.parse(r.getContentText()); } catch (e) { return null; }
}
function chatIds_() { return String(TELEGRAM_CHAT_ID).split(',').map(function (s) { return s.trim(); }).filter(String); }

function mapSet_(key, v) { sheet_('Map').appendRow([key, v]); }
function mapGet_(key) {
  const f = sheet_('Map').createTextFinder(key).matchEntireCell(true).findNext();
  return f ? String(f.offset(0, 1).getValue()) : '';
}

function notify_(v, html) {
  const hint = '\n<i>↩️ Reply tin này để trả lời khách · gõ /zalo để chuyển Zalo</i>';
  chatIds_().forEach(function (id) {
    const res = tg_('sendMessage', { chat_id: id, text: html + hint, parse_mode: 'HTML', disable_web_page_preview: true });
    if (res && res.ok) mapSet_(id + ':' + res.result.message_id, v);
  });
}

function handleTelegram_(u) {
  const cache = CacheService.getScriptCache();
  if (cache.get('u_' + u.update_id)) return; // bỏ tin lặp
  cache.put('u_' + u.update_id, '1', 21600);
  const msg = u.message;
  if (!msg || !msg.text) return;
  const chatId = String(msg.chat.id);
  if (chatIds_().indexOf(chatId) < 0) {
    tg_('sendMessage', { chat_id: chatId, text: 'Chat ID của bạn là: ' + chatId + '\nĐiền vào TELEGRAM_CHAT_ID trong Apps Script để nhận thông báo.' });
    return;
  }
  if (/^\/start\b/.test(msg.text)) {
    tg_('sendMessage', { chat_id: chatId, text: '✅ Đã kết nối chat Casamia Balanca qua Google. Thông báo khách mới sẽ gửi về đây.' });
    return;
  }
  const v = msg.reply_to_message ? mapGet_(chatId + ':' + msg.reply_to_message.message_id) : '';
  if (!v) {
    tg_('sendMessage', { chat_id: chatId, text: '↩️ Hãy bấm "Reply" vào tin thông báo của khách để trả lời đúng người.', reply_to_message_id: msg.message_id });
    return;
  }
  const isZalo = /^\/zalo\b/i.test(msg.text.trim());
  const text = isZalo ? ZALO_INVITE : clean_(msg.text);
  sheet_('TraLoi').appendRow([Utilities.getUuid(), v, text, Date.now(), isZalo ? 'zalo' : '']);
  sheet_('Chat').appendRow([now_(), v, 'Tư vấn', text]);
  mapSet_(chatId + ':' + msg.message_id, v);
  const ok = tg_('sendMessage', { chat_id: chatId, text: isZalo ? '✅ Đã gửi lời mời Zalo cho khách' : '✅ Đã gửi cho khách (khách nhận trong vài giây)', reply_to_message_id: msg.message_id });
  if (ok && ok.ok) mapSet_(chatId + ':' + ok.result.message_id, v);
}

// ---------- Chạy tay 1 lần sau khi triển khai ----------
function caiDatTelegram() {
  if (!TELEGRAM_BOT_TOKEN) throw new Error('Chưa điền TELEGRAM_BOT_TOKEN');
  if (!/\/exec$/.test(WEB_APP_URL)) throw new Error('Chưa điền WEB_APP_URL (URL ứng dụng web, kết thúc bằng /exec)');
  ['Lead', 'Chat', 'TraLoi', 'Map'].forEach(sheet_);
  const r = tg_('setWebhook', { url: WEB_APP_URL, allowed_updates: ['message'], drop_pending_updates: true });
  Logger.log(JSON.stringify(r));
  if (!r || !r.ok) throw new Error('Đặt webhook lỗi: ' + JSON.stringify(r));
  Logger.log('✅ Xong. Nhắn bất kỳ cho bot để lấy chat ID (nếu chưa có), rồi gửi /start.');
}

// Xem tình trạng kết nối Telegram (khi không nhận được tin trả lời)
function kiemTraTelegram() {
  Logger.log(JSON.stringify(tg_('getWebhookInfo', {})));
}
