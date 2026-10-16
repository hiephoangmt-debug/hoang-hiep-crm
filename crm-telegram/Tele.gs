/**
 * Tele.gs – CRM Hoàng Hiệp báo khách mới về Telegram.
 *
 * Tệp này chạy riêng, KHÔNG cần sửa Code.gs (cập nhật Code.gs sau này cũng không mất).
 * Cứ mỗi phút xem tab "Khách hàng":
 *   - khách mới từ web (cột "Loại nguồn" = Website)            → báo Telegram
 *   - khách cũ gửi lại form (cột "Số lần gửi form" tăng lên)   → báo Telegram "gửi lại lần N"
 *   - khách nhập tay / nhập Excel, Sheet                        → không báo
 * Tin gửi qua Web App "Báo khách Telegram F2 FourS" đang chạy, nên về đúng bot và nhóm cũ, không cần mã bot.
 *
 * CÀI ĐẶT (1 lần, 2 phút):
 *  1. Mở Sheet "CRM Hoàng Hiệp" → Tiện ích mở rộng → Apps Script.
 *  2. Bấm dấu + cạnh "Tệp" → Tập lệnh → đặt tên Tele → xoá nội dung mẫu, dán toàn bộ tệp này → Lưu.
 *  3. Chọn hàm caiDatBaoTele ở thanh trên → Chạy → cấp quyền (Nâng cao → Đi tới… → Cho phép).
 *     Telegram nhận tin "CRM Hoàng Hiệp đã nối Telegram" là xong.
 *  Không cần Triển khai lại. Muốn tắt: chạy hàm tatBaoTele.
 */
var TELE_WEBAPP = 'https://script.google.com/macros/s/AKfycbwvmG1HMtrQOeUXCuBJ6CHmMb4TcCZ53_n5lwPAt3-6-lG2_fIRX0q25Rv-6LPwVWXZHw/exec?key=sft-tg-4821';
// Trang đã tự báo Telegram trực tiếp (kèm nội dung chat) → CRM không báo lại để khỏi trùng tin.
var TELE_SKIP_PAGE = /sun-fours-tower\.com/i;
var TELE_SHEET = 'Khách hàng', TELE_LOG = 'Báo Telegram';
var TELE_MAX_PER_RUN = 10;

function caiDatBaoTele() {
  tatBaoTele();
  teleSeed_();
  ScriptApp.newTrigger('kiemTraKhachMoi').timeBased().everyMinutes(1).create();
  var r = teleSend_({ yeu_cau: '✅ CRM Hoàng Hiệp đã nối Telegram. Từ giờ khách mới từ web vào CRM sẽ báo về đây (tin thử, không phải khách).', source: 'CRM Hoàng Hiệp' });
  Logger.log(r === 'ok' ? 'Đã bật báo Telegram, kiểm tra mỗi phút.' : 'Đã bật hẹn giờ nhưng gửi tin thử lỗi: ' + r);
}

function tatBaoTele() {
  ScriptApp.getProjectTriggers().forEach(function (t) { if (t.getHandlerFunction() === 'kiemTraKhachMoi') ScriptApp.deleteTrigger(t); });
}

// Chạy tự động mỗi phút
function kiemTraKhachMoi() {
  var lock = LockService.getScriptLock();
  if (!lock.tryLock(5000)) return;
  try {
    if (!PropertiesService.getScriptProperties().getProperty('TELE_READY')) { teleSeed_(); return; }
    var rows = teleRows_(), log = teleLog_(), sent = 0;
    for (var i = 0; i < rows.length && sent < TELE_MAX_PER_RUN; i++) {
      var k = rows[i], seen = log.map[k.phone];
      if (seen === undefined) {                       // dòng mới
        if (k.src !== 'Website' || TELE_SKIP_PAGE.test(k.page)) { teleMark_(log, k.phone, k.count); continue; }
      } else if (k.count <= seen) continue;            // không có gì mới
      if (teleSend_(teleMsg_(k, seen)) === 'ok') { teleMark_(log, k.phone, k.count); sent++; }
    }
  } finally {
    lock.releaseLock();
  }
}

function teleMsg_(k, seen) {
  var again = seen !== undefined || k.count > 1;
  return {
    name: k.name, phone: k.phone,
    interest: [k.project, k.toa ? 'Tòa ' + k.toa : '', k.note].filter(String).join(' · '),
    yeu_cau: again ? '🔁 Khách gửi lại form lần ' + k.count + (k.status ? ' · đang ở trạng thái "' + k.status + '"' : '') + (k.owner ? ' · ' + k.owner + ' phụ trách' : '') : '',
    utm_source: k.utm, utm_campaign: k.camp,
    source: 'CRM · ' + k.site + (k.page ? ' · ' + k.page : ''),
    time: k.at
  };
}

function teleRows_() {
  var sh = SpreadsheetApp.getActiveSpreadsheet().getSheetByName(TELE_SHEET), n = sh.getLastRow();
  if (n < 2) return [];
  var w = Math.min(46, sh.getLastColumn());
  return sh.getRange(2, 1, n - 1, w).getValues().map(function (r) {
    var p = String(r[3] == null ? '' : r[3]).replace(/\D/g, ''); if (p.length === 9) p = '0' + p;
    var at = r[1] instanceof Date ? Utilities.formatDate(r[1], 'Asia/Ho_Chi_Minh', 'HH:mm dd/MM/yyyy') : String(r[1] || '');
    return {
      phone: p, at: at, name: String(r[2] || ''), site: String(r[5] || ''), utm: String(r[6] || ''), camp: String(r[7] || ''),
      count: Number(r[9]) || 1, status: String(r[18] || ''), owner: String(r[19] || ''), note: String(r[21] || '').slice(0, 300),
      src: String(r[39] || ''), page: String(r[40] || ''), project: String(r[41] || ''), toa: String(r[45] || '')
    };
  }).filter(function (k) { return k.phone.length >= 9; });
}

// Tab ẩn "Báo Telegram": SĐT | số lần gửi form đã báo | lúc báo
function teleLog_() {
  var ss = SpreadsheetApp.getActiveSpreadsheet(), sh = ss.getSheetByName(TELE_LOG);
  if (!sh) { sh = ss.insertSheet(TELE_LOG); sh.appendRow(['SĐT', 'Đã báo tới lần gửi', 'Lúc báo']); sh.getRange('A:A').setNumberFormat('@'); sh.hideSheet(); }
  var map = {}, row = {}, n = sh.getLastRow();
  if (n > 1) sh.getRange(2, 1, n - 1, 2).getValues().forEach(function (r, i) {
    var p = String(r[0]).replace(/\D/g, ''); if (p.length === 9) p = '0' + p;
    map[p] = Number(r[1]) || 0; row[p] = i + 2;
  });
  return { sh: sh, map: map, row: row };
}

function teleMark_(log, phone, count) {
  var v = [[phone, count, new Date()]];
  if (log.row[phone]) log.sh.getRange(log.row[phone], 1, 1, 3).setValues(v);
  else { var r = log.sh.getLastRow() + 1; log.sh.getRange(r, 1, 1, 3).setValues(v); log.row[phone] = r; }
  log.map[phone] = count;
}

// Lần đầu: ghi nhận toàn bộ khách đang có là "đã báo" để không gửi dồn hàng trăm tin
function teleSeed_() {
  var rows = teleRows_(), log = teleLog_(), add = [];
  var best = {};
  rows.forEach(function (k) { best[k.phone] = Math.max(best[k.phone] || 0, k.count); });
  Object.keys(best).forEach(function (p) {
    if (log.row[p]) log.sh.getRange(log.row[p], 2).setValue(Math.max(best[p], log.map[p] || 0));
    else add.push([p, best[p], new Date()]);
  });
  if (add.length) log.sh.getRange(log.sh.getLastRow() + 1, 1, add.length, 3).setValues(add);
  PropertiesService.getScriptProperties().setProperty('TELE_READY', '1');
}

function teleSend_(d) {
  try {
    var r = UrlFetchApp.fetch(TELE_WEBAPP, { method: 'post', contentType: 'text/plain;charset=utf-8', payload: JSON.stringify(d), muteHttpExceptions: true, followRedirects: true });
    var t = String(r.getContentText() || '').trim();
    if (t !== 'ok') console.error('Telegram trả về: ' + t.slice(0, 200));
    return t;
  } catch (err) {
    console.error('Gửi Telegram lỗi: ' + err);
    return 'lỗi';
  }
}
