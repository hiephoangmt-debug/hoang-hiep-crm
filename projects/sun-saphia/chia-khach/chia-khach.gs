/**
 * Sun Saphia – CHIA KHÁCH QUA TELEGRAM (Hoàng Hiệp)
 * ---------------------------------------------------------------
 * Trang web gửi khách vào đây (doPost) → gửi nhóm Telegram + chia xoay vòng cho sale.
 * Sale bấm "✅ Nhận khách" trong TIMEOUT_PHUT phút, không bấm / bấm "↪ Bận" → tự chuyển người kế tiếp.
 * Hết người → báo anh Hiệp. Ngoài giờ chia (23h30 – 6h30) → báo nhóm, 6h30 sáng chia tiếp.
 *
 * CÀI ĐẶT (làm 1 lần):
 * 1. script.google.com → Dự án mới → dán toàn bộ file này.
 * 2. ⚙ Cài đặt dự án → Thuộc tính tập lệnh (Script properties), thêm:
 *      BOT_TOKEN      = token bot Telegram (anh tự dán, không gửi cho ai)
 *      GROUP_CHAT_ID  = id nhóm Telegram nhận tổng (vd -1001234567890)
 *      OWNER_CHAT_ID  = id Telegram của anh Hiệp (nhận khách không ai nhận)
 *      SALES          = [{"ten":"Lan","chat_id":"123"},{"ten":"Minh","chat_id":"456"}]
 *      KEY            = một chuỗi bí mật bất kỳ, vd saphia-chia-2211
 *    (Không biết chat_id: chạy hàm caiDat() → nhắn /id cho bot → bot trả số.)
 * 3. Chạy hàm caiDat() một lần (cấp quyền) → tạo Google Sheet lưu khách + trigger mỗi phút.
 * 4. Triển khai → Tùy chọn triển khai mới → Ứng dụng web → Người có quyền truy cập: Bất kỳ ai → Triển khai.
 *    Gửi link /exec cho Claude để gắn vào trang (kèm ?key=KEY).
 */

var CFG = {
  GIO_BAT_DAU: '06:30', // 6h30 sáng bắt đầu chia
  GIO_KET_THUC: '23:30', // 23h30 dừng chia (khách sau giờ này để sáng chia)
  TIMEOUT_PHUT: 30,    // không bấm nhận trong 30 phút → chuyển người khác
  TZ: 'Asia/Ho_Chi_Minh'
};

/* ---------------- Tiện ích ---------------- */
function P(k) { return PropertiesService.getScriptProperties().getProperty(k) || ''; }
function setP(k, v) { PropertiesService.getScriptProperties().setProperty(k, String(v)); }
function sales() { try { return JSON.parse(P('SALES') || '[]'); } catch (e) { return []; } }
function now() { return new Date(); }
function phut(hm) { var a = String(hm).split(':'); return Number(a[0]) * 60 + Number(a[1] || 0); }
function trongGio() { var m = phut(Utilities.formatDate(now(), CFG.TZ, 'H:mm')); return m >= phut(CFG.GIO_BAT_DAU) && m < phut(CFG.GIO_KET_THUC); }
function fmt(d) { return Utilities.formatDate(new Date(d), CFG.TZ, 'HH:mm dd/MM'); }
function esc(s) { return String(s == null ? '' : s).replace(/[<>&]/g, function (c) { return {'<': '&lt;', '>': '&gt;', '&': '&amp;'}[c]; }); }

function tg(method, payload) {
  var r = UrlFetchApp.fetch('https://api.telegram.org/bot' + P('BOT_TOKEN') + '/' + method, {
    method: 'post', contentType: 'application/json', payload: JSON.stringify(payload), muteHttpExceptions: true
  });
  try { return JSON.parse(r.getContentText()); } catch (e) { return {}; }
}
function send(chat, html, buttons) {
  var p = {chat_id: chat, text: html, parse_mode: 'HTML', disable_web_page_preview: true};
  if (buttons) p.reply_markup = {inline_keyboard: buttons};
  return tg('sendMessage', p);
}

/* ---------------- Sheet lưu khách ---------------- */
var COLS = ['id', 'thoi_gian', 'so', 'ten', 'noi_dung', 'trang_thai', 'giao_cho', 'giao_luc', 'da_thu', 'msg_sale', 'raw'];
function sheet() {
  var ss = SpreadsheetApp.openById(P('SHEET_ID'));
  return ss.getSheetByName('Khach') || ss.insertSheet('Khach');
}
function readAll() {
  var sh = sheet(), v = sh.getDataRange().getValues(), out = [];
  for (var i = 1; i < v.length; i++) { var o = {_row: i + 1}; COLS.forEach(function (c, j) { o[c] = v[i][j]; }); out.push(o); }
  return out;
}
function saveRow(o) {
  var sh = sheet(), row = COLS.map(function (c) { return o[c] == null ? '' : o[c]; });
  if (o._row) sh.getRange(o._row, 1, 1, COLS.length).setValues([row]); else { sh.appendRow(row); o._row = sh.getLastRow(); }
}

/* ---------------- Nhận khách từ trang web ---------------- */
function doPost(e) {
  var key = (e && e.parameter && e.parameter.key) || '';
  if (!P('KEY') || key !== P('KEY')) return out_('bad key');
  var d = {};
  try { d = JSON.parse(e.postData.contents); } catch (x) { return out_('bad json'); }

  var lock = LockService.getScriptLock(); lock.waitLock(20000);
  try {
    // Thông báo không có số (khách đang chat, khách cũ đăng ký thêm…) → chỉ báo nhóm
    if (d.thong_bao || !d.phone) {
      send(P('GROUP_CHAT_ID'), 'ℹ️ <b>' + esc(d.thong_bao || 'Thông báo') + '</b>' + (d.phone ? '\n📞 ' + esc(d.phone) : '') + (d.interest ? '\n' + esc(d.interest) : '') + nguon(d));
      return out_('ok');
    }
    // Trùng số trong 30 ngày → báo nhóm, giao lại đúng người cũ
    var all = readAll(), cu = null;
    for (var i = all.length - 1; i >= 0; i--) if (String(all[i].so) === String(d.phone) && now() - new Date(all[i].thoi_gian) < 30 * 864e5) { cu = all[i]; break; }
    if (cu) {
      send(P('GROUP_CHAT_ID'), '🔁 <b>Khách cũ quay lại</b> · ' + esc(d.phone) + '\n' + esc(d.interest || '') + '\n👉 Đang là khách của <b>' + esc(cu.giao_cho || 'chưa giao') + '</b>' + nguon(d));
      var s = sales().filter(function (x) { return x.ten === cu.giao_cho; })[0];
      if (s) send(s.chat_id, '🔁 Khách của bạn quay lại: <b>' + esc(d.phone) + '</b>\n' + esc(d.interest || '') + '\nGọi lại sớm nhé!');
      return out_('ok');
    }

    var o = {id: 'K' + Date.now().toString(36), thoi_gian: now().toISOString(), so: d.phone, ten: d.name || '',
      noi_dung: [d.interest, d.muc_dich, d.tai_chinh].filter(Boolean).join(' · '), trang_thai: '', giao_cho: '', giao_luc: '', da_thu: '', msg_sale: '', raw: JSON.stringify(d).slice(0, 45000)};

    if (d.nghi_rac) {
      o.trang_thai = 'nghi_rac'; saveRow(o);
      send(P('GROUP_CHAT_ID'), '⚠️ <b>Số nghi rác</b> (' + esc(d.nghi_rac) + ') · ' + esc(d.phone) + '\n' + esc(o.noi_dung) + '\nKhông tính lượt chia, ai rảnh gọi thử.' + nguon(d));
      return out_('ok');
    }
    saveRow(o);
    if (trongGio()) giao(o, ''); else {
      o.trang_thai = 'cho_sang'; saveRow(o);
      send(P('GROUP_CHAT_ID'), '🌙 <b>KHÁCH MỚI ngoài giờ</b> · ' + esc(d.phone) + '\n' + esc(o.noi_dung) + '\n⏰ Sẽ chia lúc ' + CFG.GIO_BAT_DAU + ' sáng (anh Hiệp gọi trước nếu cần).' + nguon(d));
      if (P('OWNER_CHAT_ID')) send(P('OWNER_CHAT_ID'), '🌙 Khách ngoài giờ: <b>' + esc(d.phone) + '</b>\n' + esc(o.noi_dung));
    }
  } finally { lock.releaseLock(); }
  return out_('ok');
}
function out_(t) { return ContentService.createTextOutput(t); }
function nguon(d) {
  var n = [d.utm_source, d.utm_campaign, d.utm_content].filter(Boolean).join(' / ');
  return n ? '\n<i>Nguồn: ' + esc(n) + '</i>' : '';
}

/* ---------------- Chia khách ---------------- */
function nextSale(daThu) {
  var list = sales(); if (!list.length) return null;
  var tried = String(daThu || '').split(',').filter(Boolean);
  var idx = Number(P('RR_IDX') || 0);
  for (var k = 0; k < list.length; k++) {
    var s = list[(idx + k) % list.length];
    if (tried.indexOf(s.ten) < 0) { setP('RR_IDX', (idx + k + 1) % list.length); return s; }
  }
  return null;
}
function chiTiet(o) {
  var d = {}; try { d = JSON.parse(o.raw); } catch (e) {}
  return '📞 <b>' + esc(o.so) + '</b>' + (o.ten ? ' · ' + esc(o.ten) : '') + '\n' + esc(o.noi_dung) + nguon(d) + '\n🕐 ' + fmt(o.thoi_gian);
}
function giao(o, lyDo) {
  var s = nextSale(o.da_thu);
  if (!s) {
    o.trang_thai = 'het_nguoi'; saveRow(o);
    send(P('GROUP_CHAT_ID'), '🚨 <b>Chưa ai nhận khách</b> ' + esc(o.so) + ' – chuyển anh Hiệp.');
    if (P('OWNER_CHAT_ID')) send(P('OWNER_CHAT_ID'), '🚨 Không sale nào nhận, anh gọi giúp:\n' + chiTiet(o));
    return;
  }
  o.giao_cho = s.ten; o.giao_luc = now().toISOString(); o.trang_thai = 'cho_nhan';
  o.da_thu = (o.da_thu ? o.da_thu + ',' : '') + s.ten;
  var r = send(s.chat_id, '🔔 <b>KHÁCH MỚI cho bạn</b>' + (lyDo ? ' (' + esc(lyDo) + ')' : '') + '\n' + chiTiet(o) +
    '\n\n⏱ Bấm <b>Nhận khách</b> trong ' + CFG.TIMEOUT_PHUT + ' phút, gọi/Zalo ngay. Không bấm sẽ chuyển người khác.',
    [[{text: '✅ Nhận khách', callback_data: 'nhan:' + o.id}, {text: '↪ Bận, chuyển', callback_data: 'tu:' + o.id}]]);
  o.msg_sale = r && r.result ? s.chat_id + ':' + r.result.message_id : '';
  saveRow(o);
  send(P('GROUP_CHAT_ID'), '🔔 <b>KHÁCH MỚI</b> → 👉 <b>' + esc(s.ten) + '</b> (chờ nhận)' + (lyDo ? ' · ' + esc(lyDo) : '') + '\n' + chiTiet(o));
}
function khoaNut(o, text) {
  if (!o.msg_sale) return;
  var p = String(o.msg_sale).split(':');
  tg('editMessageReplyMarkup', {chat_id: p[0], message_id: Number(p[1]), reply_markup: {inline_keyboard: [[{text: text, callback_data: 'x'}]]}});
}

/* ---------------- Chạy mỗi phút: đọc nút bấm + chuyển khách quá hạn + chia khách ngoài giờ ---------------- */
function moiPhut() {
  var lock = LockService.getScriptLock(); if (!lock.tryLock(30000)) return;
  try {
    docNut();
    var all = readAll();
    all.forEach(function (o) {
      if (o.trang_thai === 'cho_nhan' && now() - new Date(o.giao_luc) > CFG.TIMEOUT_PHUT * 60000) {
        khoaNut(o, '⌛ Quá ' + CFG.TIMEOUT_PHUT + ' phút – đã chuyển người khác');
        var cu = o.giao_cho;
        if (trongGio()) giao(o, cu + ' không nhận sau ' + CFG.TIMEOUT_PHUT + ' phút');
        else { o.trang_thai = 'cho_sang'; saveRow(o); }
      } else if (o.trang_thai === 'cho_sang' && trongGio()) {
        giao(o, 'khách tối qua');
      }
    });
  } finally { lock.releaseLock(); }
}
function docNut() {
  var off = Number(P('TG_OFFSET') || 0);
  var r = tg('getUpdates', {offset: off, timeout: 0, allowed_updates: ['callback_query', 'message']});
  if (!r || !r.ok) return;
  r.result.forEach(function (u) {
    setP('TG_OFFSET', u.update_id + 1);
    if (u.message && /^\/(id|start)/.test(u.message.text || '')) {
      send(u.message.chat.id, 'Chat id của bạn: <code>' + u.message.chat.id + '</code>\nGửi số này cho anh Hiệp để được chia khách.');
      return;
    }
    var q = u.callback_query; if (!q) return;
    var m = String(q.data || '').match(/^(nhan|tu):(.+)$/);
    if (!m) { tg('answerCallbackQuery', {callback_query_id: q.id}); return; }
    var o = readAll().filter(function (x) { return x.id === m[2]; })[0];
    var ai = sales().filter(function (s) { return String(s.chat_id) === String(q.from.id); })[0];
    if (!o || !ai || o.giao_cho !== ai.ten || o.trang_thai !== 'cho_nhan') {
      tg('answerCallbackQuery', {callback_query_id: q.id, text: 'Khách này đã chuyển hoặc đã có người nhận.', show_alert: true});
      return;
    }
    if (m[1] === 'nhan') {
      o.trang_thai = 'da_nhan'; saveRow(o);
      khoaNut(o, '✅ Bạn đã nhận – gọi ngay nhé');
      tg('answerCallbackQuery', {callback_query_id: q.id, text: 'Đã nhận khách ' + o.so});
      send(P('GROUP_CHAT_ID'), '✅ <b>' + esc(ai.ten) + '</b> đã nhận khách ' + esc(o.so) + ' (' + fmt(now()) + ')');
    } else {
      khoaNut(o, '↪ Đã chuyển người khác');
      tg('answerCallbackQuery', {callback_query_id: q.id, text: 'Đã chuyển.'});
      if (trongGio()) giao(o, ai.ten + ' bận'); else { o.trang_thai = 'cho_sang'; saveRow(o); }
    }
  });
}

/* ---------------- Cài đặt 1 lần ---------------- */
function caiDat() {
  if (!P('SHEET_ID')) {
    var ss = SpreadsheetApp.create('Sun Saphia – Chia khách');
    ss.getSheets()[0].setName('Khach').appendRow(COLS);
    setP('SHEET_ID', ss.getId());
  }
  ScriptApp.getProjectTriggers().forEach(function (t) { if (t.getHandlerFunction() === 'moiPhut') ScriptApp.deleteTrigger(t); });
  ScriptApp.newTrigger('moiPhut').timeBased().everyMinutes(1).create();
  tg('deleteWebhook', {}); // bot chia khách dùng chế độ đọc tin mỗi phút
  Logger.log('Xong. Sheet: https://docs.google.com/spreadsheets/d/' + P('SHEET_ID'));
}
/* Gửi thử 1 khách giả để kiểm tra (chạy tay trong trình soạn) */
function thu() {
  doPost({parameter: {key: P('KEY')}, postData: {contents: JSON.stringify({phone: '0900000000', name: 'Khách thử', interest: 'TEST chia khách', utm_source: 'test'})}});
}
