/**
 * CRM Thẻ Tín Dụng Đà Nẵng – Google Apps Script backend.
 *
 * Dữ liệu nằm trong Google Sheet chứa script này:
 *   KhachHang – danh sách khách (từ website + nhập tay)
 *   LienHe    – nhật ký khách để lại thông tin trên website
 *   GiaoDich  – sổ giao dịch (đáo hạn / rút tiền / ví trả sau)
 *   NhacLich  – trạng thái nhắc: đáo hạn (7→5 ngày trước hạn) và rút tiền sau ngày sao kê
 *
 *   DoiSoat   – tiền C.Trâm (người giữ máy) chuyển / ứng trước cho mình, không theo từng giao dịch
 *   KetSo     – các lần kết số dư với C.Trâm (sổ trước ngày kết bị khóa)
 *   TheKhach  – thẻ của từng khách (ngân hàng, 4 số cuối, hạn mức, ngày sao kê, ngày đáo, ảnh thẻ)
 *   TaiLieu   – ảnh CCCD / ảnh thẻ; file ảnh nằm riêng tư trong Google Drive của chủ CRM
 *
 * Công nợ với C.Trâm: mỗi giao dịch phát sinh tiền hoàn = số tiền − phí máy (tien_hoan = so_tien − chi_phi),
 *   đến hạn ngày GD + 1. Tiền C.Trâm chuyển/ứng (sheet DoiSoat) trừ dần vào các khoản cũ nhất trước.
 *   Số dư = tổng tiền hoàn − tổng đã chuyển/ứng: dương = C.Trâm còn phải chuyển, âm = C.Trâm đã ứng dư.
 */

var TZ = 'Asia/Ho_Chi_Minh';

var SHEETS = {
  KhachHang: ['id', 'ten', 'sdt', 'nguon', 'trang_thai', 'ghi_chu', 'tao_luc', 'cap_nhat'],
  LienHe: ['id', 'thoi_gian', 'ten', 'sdt', 'dich_vu', 'ghi_chu', 'nguon', 'trang_thai', 'khach_id'],
  GiaoDich: ['id', 'ngay', 'dich_vu', 'the', 'ngay_dao', 'ngay_sao_ke', 'khach_id', 'ten_khach', 'sdt', 'so_tien',
    'may', 'phi_khach', 'phi_may', 'phi_may_text', 'tien_phi', 'chi_phi', 'loi_nhuan', 'ghi_chu', 'tao_luc',
    'tien_hoan', 'ngay_hoan', 'hoan_tt', 'hoan_luc'],
  NhacLich: ['key', 'han', 'trang_thai', 'ghi_chu', 'event_id', 'cap_nhat'],
  DoiSoat: ['id', 'ngay', 'loai', 'so_tien', 'ghi_chu', 'tao_luc'],
  TheKhach: ['id', 'khach_id', 'ten_the', 'ngan_hang', 'so_cuoi', 'han_muc', 'ngay_sao_ke', 'ngay_dao', 'ghi_chu', 'tao_luc', 'cap_nhat',
    'chu_the', 'quan_he'],
  TaiLieu: ['id', 'khach_id', 'loai', 'the_id', 'file_id', 'ten_file', 'ghi_chu', 'tao_luc'],
  KetSo: ['id', 'ngay', 'tu_ngay', 'so_du_truoc', 'so_gd', 'so_tien', 'chi_phi', 'phat_sinh', 'da_chuyen', 'so_du', 'ghi_chu', 'tao_luc']
};
// Sheet thêm ở bản cập nhật: tự tạo khi cần, không phải chạy lại setup().
var AUTO_SHEETS = ['DoiSoat', 'KetSo', 'TheKhach', 'TaiLieu'];
var DOC_TYPES = ['CCCD mặt trước', 'CCCD mặt sau', 'Ảnh thẻ', 'CCCD chủ thẻ', 'Khác'];
// Ảnh gắn với một thẻ cụ thể (mỗi thẻ 1 ảnh mỗi loại).
var CARD_DOC_TYPES = ['Ảnh thẻ', 'CCCD chủ thẻ'];
// Thẻ của chính khách hoặc của người thân / người quen khách mang đến làm.
var CARD_RELATIONS = ['Chính chủ', 'Vợ', 'Chồng', 'Bố', 'Mẹ', 'Con', 'Anh', 'Chị', 'Em', 'Người quen', 'Khác'];

// Cột lưu dạng chữ để Sheets không tự đổi ngày/số (mất số 0 đầu SĐT).
var TEXT_COLUMNS = ['id', 'sdt', 'ngay', 'thoi_gian', 'tao_luc', 'cap_nhat', 'key', 'han', 'khach_id', 'phi_may_text',
  'ngay_hoan', 'hoan_luc', 'tu_ngay', 'so_cuoi', 'file_id', 'the_id'];
// Cột ngày dạng yyyy-MM-dd (nếu Sheets lỡ đổi thành Date thì đọc lại đúng dạng).
var DATE_COLUMNS = ['ngay', 'han', 'ngay_hoan', 'tu_ngay'];
// Kiểu tiền với C.Trâm. "Ứng trước"/"Hoàn tiền" làm giảm nợ; "Mình trả lại"/"Nợ cũ" làm tăng nợ;
// "Điều chỉnh số dư" nhập được số âm (âm = tăng nợ).
var PAYMENT_TYPES = ['Ứng trước', 'Hoàn tiền', 'Mình trả lại', 'Nợ cũ', 'Điều chỉnh số dư'];

var CUSTOMER_STATUSES = ['Mới', 'Đang tư vấn', 'Khách quen', 'Không tiềm năng'];
var SERVICES = ['Đáo hạn', 'Rút tiền', 'Đáo + Rút', 'Ví trả sau'];

// Ngày nghỉ lễ/Tết (ngoài T7, CN). Chỉnh trong Cài đặt khi Nhà nước công bố lịch nghỉ chính thức.
var DEFAULT_HOLIDAYS = [
  '2026-01-01',
  '2026-02-14', '2026-02-15', '2026-02-16', '2026-02-17', '2026-02-18', '2026-02-19', '2026-02-20', '2026-02-21', '2026-02-22',
  '2026-04-27', '2026-04-30', '2026-05-01',
  '2026-09-01', '2026-09-02'
];

/* ------------------------------------------------------------------ */
/* Cài đặt                                                             */
/* ------------------------------------------------------------------ */

/** Chạy 1 lần trong trình soạn Apps Script: tạo sheet, mã PIN, lịch chạy hằng ngày. */
function setup() {
  var ss = SpreadsheetApp.getActive();
  Object.keys(SHEETS).forEach(function (name) {
    var sh = ss.getSheetByName(name) || ss.insertSheet(name);
    var headers = SHEETS[name];
    sh.getRange(1, 1, 1, headers.length).setValues([headers]);
    sh.setFrozenRows(1);
    headers.forEach(function (h, i) {
      if (TEXT_COLUMNS.indexOf(h) >= 0) sh.getRange(2, i + 1, sh.getMaxRows() - 1, 1).setNumberFormat('@');
    });
  });
  var props = PropertiesService.getScriptProperties();
  var pin = null;
  if (!props.getProperty('PIN_HASH')) {
    pin = String(Math.floor(100000 + Math.random() * 900000));
    setPin_(pin);
  }
  if (!props.getProperty('REMIND_FROM')) props.setProperty('REMIND_FROM', '7');
  if (!props.getProperty('REMIND_TO')) props.setProperty('REMIND_TO', '5');
  if (!props.getProperty('GRACE_DAYS')) props.setProperty('GRACE_DAYS', '25');
  if (props.getProperty('HOLIDAYS') === null) props.setProperty('HOLIDAYS', DEFAULT_HOLIDAYS.join('\n'));
  if (props.getProperty('SHIFT_AFTER_CARDS') === null) props.setProperty('SHIFT_AFTER_CARDS', '');
  if (!props.getProperty('OWNER_EMAIL')) props.setProperty('OWNER_EMAIL', Session.getEffectiveUser().getEmail());
  if (!props.getProperty('CALENDAR')) props.setProperty('CALENDAR', 'on');
  if (!props.getProperty('HOAN_NGUOI')) props.setProperty('HOAN_NGUOI', 'C.Trâm');
  installTriggers_();
  // Tạo sẵn thư mục ảnh để Google hỏi luôn quyền Drive khi chạy setup.
  var driveMsg = '';
  try { docRoot_(); driveMsg = ' Đã bật lưu ảnh CCCD / thẻ (Google Drive).'; }
  catch (e) { driveMsg = ' CHƯA bật được lưu ảnh: ' + e.message + ' – kiểm tra file appsscript.json có quyền drive.'; }
  var msg = pin ? 'Mã PIN đăng nhập CRM: ' + pin + ' (đổi trong mục Cài đặt).' : 'Đã có mã PIN, giữ nguyên.';
  msg += driveMsg;
  Logger.log(msg);
  return msg;
}

function installTriggers_() {
  ScriptApp.getProjectTriggers().forEach(function (t) {
    if (t.getHandlerFunction() === 'dailyJob') ScriptApp.deleteTrigger(t);
  });
  ScriptApp.newTrigger('dailyJob').timeBased().everyDays(1).atHour(7).inTimezone(TZ).create();
}

/* ------------------------------------------------------------------ */
/* Web: trang CRM (GET) và nhận khách từ website (POST)                */
/* ------------------------------------------------------------------ */

function doGet(e) {
  if (e && e.parameter && e.parameter.ping) return json_({ ok: true });
  return HtmlService.createHtmlOutputFromFile('Index')
    .setTitle('CRM Thẻ Tín Dụng')
    .addMetaTag('viewport', 'width=device-width, initial-scale=1')
    .setXFrameOptionsMode(HtmlService.XFrameOptionsMode.ALLOWALL);
}

/** Website gửi form về đây (JSON hoặc form-urlencoded, ví dụ webhook của LadiPage). */
function doPost(e) {
  try {
    var data = parseLeadPayload_(e);
    if (data.website) return json_({ ok: true }); // bẫy bot (honeypot)
    if (data.loai === 'zalo' || data.loai === 'goi') return json_({ ok: logClick_(data) });
    var lead = saveLead_(data);
    notifyNewLead_(lead);
    return json_({ ok: true, id: lead.id });
  } catch (err) {
    return json_({ ok: false, error: String(err.message || err) });
  }
}

function parseLeadPayload_(e) {
  var p = {};
  if (e && e.postData && e.postData.contents) {
    try { p = JSON.parse(e.postData.contents); } catch (ignore) { p = {}; }
  }
  var params = (e && e.parameter) || {};
  Object.keys(params).forEach(function (k) { if (p[k] === undefined) p[k] = params[k]; });
  function pick() {
    for (var i = 0; i < arguments.length; i++) {
      var v = p[arguments[i]];
      if (v !== undefined && v !== null && String(v).trim() !== '') return String(v).trim();
    }
    return '';
  }
  return {
    ten: pick('ten', 'name', 'full_name', 'ho_ten', 'fullname'),
    sdt: normalizePhone_(pick('sdt', 'phone', 'so_dien_thoai', 'phone_number', 'tel')),
    dich_vu: pick('dich_vu', 'service', 'dichvu'),
    ghi_chu: pick('ghi_chu', 'note', 'message', 'noi_dung', 'content'),
    nguon: pick('nguon', 'source', 'domain', 'url') || 'website',
    website: pick('website'), // honeypot: người thật để trống
    loai: pick('loai', 'event') // 'zalo' | 'goi' khi khách bấm nút Zalo / Gọi trên web
  };
}

function saveLead_(d) {
  if (!/^0\d{9,10}$/.test(d.sdt)) throw new Error('Số điện thoại không hợp lệ');
  d.ten = d.ten.slice(0, 100);
  d.ghi_chu = d.ghi_chu.slice(0, 1000);
  d.nguon = d.nguon.replace(/^https?:\/\//, '').replace(/\/.*$/, '').slice(0, 100);
  return withLock_(function () {
    var customer = findCustomer_({ sdt: d.sdt });
    var now = nowStr_();
    if (!customer) {
      customer = { id: newId_(), ten: d.ten || d.sdt, sdt: d.sdt, nguon: d.nguon, trang_thai: 'Mới',
        ghi_chu: '', tao_luc: now, cap_nhat: now };
      appendObj_('KhachHang', customer);
    } else {
      updateObj_('KhachHang', customer.id, { cap_nhat: now, ten: customer.ten || d.ten });
    }
    var lead = { id: newId_(), thoi_gian: now, ten: d.ten, sdt: d.sdt, dich_vu: d.dich_vu, ghi_chu: d.ghi_chu,
      nguon: d.nguon, trang_thai: 'Mới', khach_id: customer.id };
    appendObj_('LienHe', lead);
    return lead;
  });
}

/** Khách bấm nút Zalo / Gọi trên web: chưa có SĐT, ghi lại để biết có khách đang liên hệ. */
var CLICK_STATUS = { zalo: 'Bấm Zalo', goi: 'Bấm gọi' };
function logClick_(d) {
  var cache = CacheService.getScriptCache();
  var n = Number(cache.get('clicks_hour') || 0);
  if (n >= 300) return false; // chặn spam
  cache.put('clicks_hour', String(n + 1), 3600);
  var nguon = d.nguon.replace(/^https?:\/\//, '').replace(/\/.*$/, '').slice(0, 100);
  withLock_(function () {
    appendObj_('LienHe', { id: newId_(), thoi_gian: nowStr_(), ten: '', sdt: '', dich_vu: d.dich_vu.slice(0, 100),
      ghi_chu: '', nguon: nguon, trang_thai: CLICK_STATUS[d.loai], khach_id: '' });
  });
  return true;
}

function notifyNewLead_(lead) {
  var email = PropertiesService.getScriptProperties().getProperty('OWNER_EMAIL');
  if (!email) return;
  MailApp.sendEmail(email, '🔔 Khách mới từ ' + lead.nguon + ': ' + (lead.ten || lead.sdt),
    'Tên: ' + lead.ten + '\nSĐT: ' + lead.sdt + '\nDịch vụ: ' + lead.dich_vu +
    '\nGhi chú: ' + lead.ghi_chu + '\nNguồn: ' + lead.nguon + '\nLúc: ' + lead.thoi_gian);
}

/* ------------------------------------------------------------------ */
/* Đăng nhập bằng mã PIN                                               */
/* ------------------------------------------------------------------ */

function login(pin) {
  var cache = CacheService.getScriptCache();
  var fails = Number(cache.get('login_fails') || 0);
  if (fails >= 5) throw new Error('Sai mã PIN quá 5 lần, thử lại sau 15 phút.');
  if (hashPin_(String(pin || '')) !== PropertiesService.getScriptProperties().getProperty('PIN_HASH')) {
    cache.put('login_fails', String(fails + 1), 900);
    throw new Error('Mã PIN không đúng.');
  }
  cache.remove('login_fails');
  var token = Utilities.getUuid();
  cache.put('tok_' + token, '1', 21600);
  return token;
}

function setPin_(pin) {
  if (!/^\d{4,10}$/.test(pin)) throw new Error('Mã PIN gồm 4–10 chữ số.');
  var props = PropertiesService.getScriptProperties();
  if (!props.getProperty('PIN_SALT')) props.setProperty('PIN_SALT', Utilities.getUuid());
  props.setProperty('PIN_HASH', hashPin_(pin));
}

function hashPin_(pin) {
  var salt = PropertiesService.getScriptProperties().getProperty('PIN_SALT') || '';
  var bytes = Utilities.computeDigest(Utilities.DigestAlgorithm.SHA_256, salt + ':' + pin, Utilities.Charset.UTF_8);
  return Utilities.base64Encode(bytes);
}

function checkToken_(token) {
  var cache = CacheService.getScriptCache();
  if (!token || !cache.get('tok_' + token)) throw new Error('AUTH');
  cache.put('tok_' + token, '1', 21600);
}

/* ------------------------------------------------------------------ */
/* API cho giao diện (google.script.run.api)                           */
/* ------------------------------------------------------------------ */

function api(token, action, payload) {
  checkToken_(token);
  payload = payload || {};
  var handlers = {
    bootstrap: apiBootstrap_,
    dashboard: apiDashboard_,
    listCustomers: function () { return readAll_('KhachHang'); },
    saveCustomer: apiSaveCustomer_,
    customerDetail: apiCustomerDetail_,
    listLeads: function () { return readAll_('LienHe').reverse(); },
    updateLead: apiUpdateLead_,
    listTransactions: apiListTransactions_,
    saveTransaction: apiSaveTransaction_,
    deleteTransaction: apiDeleteTransaction_,
    reminders: function (p) { return computeReminders_(p.from, p.to); },
    markReminder: apiMarkReminder_,
    report: apiReport_,
    saveSettings: apiSaveSettings_,
    importTransactions: apiImportTransactions_,
    refunds: apiRefunds_,
    savePayment: apiSavePayment_,
    deletePayment: apiDeletePayment_,
    previewClose: function (p) { return statementAt_(p.ngay); },
    periodSummary: apiPeriodSummary_,
    listCards: function (p) { return cardsOf_(p.khach_id); },
    customerDocs: function (p) {
      return { cards: cardsOf_(p.khach_id), docs: readAll_('TaiLieu').filter(function (d) { return d.khach_id === p.khach_id; }) };
    },
    saveCard: apiSaveCard_,
    deleteCard: apiDeleteCard_,
    uploadDoc: apiUploadDoc_,
    getDoc: apiGetDoc_,
    deleteDoc: apiDeleteDoc_,
    closeBalance: apiCloseBalance_,
    deleteClosing: apiDeleteClosing_,
    withdrawAdvice: function (p) { return withdrawAdvice_(p.ngay || todayStr_(), Number(p.ngay_sao_ke), Number(p.ngay_dao) || 0, p.the); }
  };
  if (!handlers[action]) throw new Error('Không rõ thao tác: ' + action);
  return handlers[action](payload);
}

function apiBootstrap_() {
  var props = PropertiesService.getScriptProperties();
  var tx = readAll_('GiaoDich');
  function distinct(field) {
    var seen = {};
    tx.forEach(function (t) { if (t[field]) seen[t[field]] = (seen[t[field]] || 0) + 1; });
    return Object.keys(seen).sort(function (a, b) { return seen[b] - seen[a]; });
  }
  return {
    today: todayStr_(),
    services: SERVICES,
    customerStatuses: CUSTOMER_STATUSES,
    cardRelations: CARD_RELATIONS,
    cards: distinct('the'),
    machines: distinct('may'),
    customers: readAll_('KhachHang').map(function (c) { return { id: c.id, ten: c.ten, sdt: c.sdt }; }),
    settings: {
      remindFrom: remindWindow_().from,
      remindTo: remindWindow_().to,
      graceDays: graceDays_(),
      holidays: holidayList_(),
      shiftAfterCards: props.getProperty('SHIFT_AFTER_CARDS') || '',
      ownerEmail: props.getProperty('OWNER_EMAIL') || '',
      calendar: props.getProperty('CALENDAR') !== 'off',
      refundName: refundName_(),
      refundPhone: PropertiesService.getScriptProperties().getProperty('HOAN_SDT') || '',
      sheetUrl: SpreadsheetApp.getActive().getUrl(),
      webAppUrl: ScriptApp.getService().getUrl()
    }
  };
}

function apiDashboard_() {
  var today = todayStr_();
  var p = parseYmd_(today);
  var monthFrom = ymd_(p.y, p.m, 1), monthTo = ymd_(p.y, p.m, daysInMonth_(p.y, p.m));
  var tx = readAll_('GiaoDich').filter(function (t) { return t.ngay >= monthFrom && t.ngay <= monthTo; });
  var leads = readAll_('LienHe');
  var rem = computeReminders_(addDays_(today, -30), addDays_(today, 7));
  var refunds = apiRefunds_({ from: today, to: today });
  return {
    month: summarize_(tx),
    refundName: refundName_(),
    refunds: { summary: refunds.summary, days: refunds.days, congNo: refunds.congNo, lastClosing: refunds.lastClosing },
    todayTx: summarize_(tx.filter(function (t) { return t.ngay === today; })),
    newLeads: leads.filter(function (l) { return l.trang_thai === 'Mới'; }).reverse().slice(0, 20),
    clicksToday: leads.filter(function (l) { return !l.sdt && String(l.thoi_gian).slice(0, 10) === today; }).reverse(),
    leadsThisMonth: leads.filter(function (l) { return l.sdt && String(l.thoi_gian).slice(0, 10) >= monthFrom; }).length,
    remindToday: rem.filter(function (r) { return r.nhac_ngay <= today && r.trang_thai === 'Chưa báo'; }),
    remindSoon: rem.filter(function (r) { return r.nhac_ngay > today && r.trang_thai === 'Chưa báo'; })
  };
}

function apiSaveCustomer_(c) {
  return withLock_(function () {
    var now = nowStr_();
    var fields = {
      ten: String(c.ten || '').trim(), sdt: normalizePhone_(c.sdt), nguon: String(c.nguon || 'Nhập tay'),
      trang_thai: CUSTOMER_STATUSES.indexOf(c.trang_thai) >= 0 ? c.trang_thai : 'Mới',
      ghi_chu: String(c.ghi_chu || ''), cap_nhat: now
    };
    if (!fields.ten) throw new Error('Thiếu tên khách.');
    if (c.id) {
      updateObj_('KhachHang', c.id, fields);
      // Đổi tên/SĐT thì cập nhật luôn trên các giao dịch của khách.
      updateWhere_('GiaoDich', function (t) { return t.khach_id === c.id; }, { ten_khach: fields.ten, sdt: fields.sdt });
      return Object.assign({ id: c.id }, fields);
    }
    var obj = Object.assign({ id: newId_(), tao_luc: now }, fields);
    appendObj_('KhachHang', obj);
    return obj;
  });
}

function apiCustomerDetail_(p) {
  var c = readAll_('KhachHang').filter(function (x) { return x.id === p.id; })[0];
  if (!c) throw new Error('Không tìm thấy khách.');
  var tx = readAll_('GiaoDich').filter(function (t) { return t.khach_id === p.id; }).sort(byDateDesc_);
  var leads = readAll_('LienHe').filter(function (l) { return l.khach_id === p.id; }).reverse();
  var docs = readAll_('TaiLieu').filter(function (d) { return d.khach_id === p.id; });
  return { driveReady: driveReady_(), driveHelp: DRIVE_HELP, customer: c, transactions: tx, leads: leads, summary: summarize_(tx), cards: cardsOf_(p.id), docs: docs };
}

function apiUpdateLead_(p) {
  return withLock_(function () {
    updateObj_('LienHe', p.id, { trang_thai: p.trang_thai });
    if (p.khach_id && p.customerStatus) updateObj_('KhachHang', p.khach_id, { trang_thai: p.customerStatus, cap_nhat: nowStr_() });
    return true;
  });
}

function apiListTransactions_(p) {
  return readAll_('GiaoDich').filter(function (t) {
    return (!p.from || t.ngay >= p.from) && (!p.to || t.ngay <= p.to);
  }).sort(byDateDesc_);
}

function apiSaveTransaction_(t) {
  return withLock_(function () {
    var obj = buildTransaction_(t);
    assertOpen_(obj.ngay);
    if (t.id) {
      var old = readAll_('GiaoDich').filter(function (x) { return x.id === t.id; })[0];
      if (old && old.hoan_tt !== 'Đã nhận') assertOpen_(old.ngay);
      obj.id = t.id;
      updateObj_('GiaoDich', t.id, obj);
    } else {
      obj.id = newId_();
      obj.tao_luc = nowStr_();
      obj.hoan_tt = 'Chưa nhận';
      appendObj_('GiaoDich', obj);
    }
    obj.the_id = upsertCardFromTx_(obj) || '';
    return obj;
  });
}

function buildTransaction_(t) {
  var ngay = String(t.ngay || '');
  if (!/^\d{4}-\d{2}-\d{2}$/.test(ngay)) throw new Error('Ngày không hợp lệ.');
  var soTien = Number(t.so_tien);
  if (!(soTien > 0)) throw new Error('Số tiền phải lớn hơn 0.');
  var dichVu = SERVICES.indexOf(t.dich_vu) >= 0 ? t.dich_vu : 'Đáo hạn';
  var ngayDao = t.ngay_dao === '' || t.ngay_dao == null ? '' : Number(t.ngay_dao);
  if (ngayDao !== '' && !(ngayDao >= 1 && ngayDao <= 31)) throw new Error('Ngày đáo phải từ 1 đến 31.');
  var ngaySaoKe = t.ngay_sao_ke === '' || t.ngay_sao_ke == null ? '' : Number(t.ngay_sao_ke);
  if (ngaySaoKe !== '' && !(ngaySaoKe >= 1 && ngaySaoKe <= 31)) throw new Error('Ngày sao kê phải từ 1 đến 31.');
  var phiKhach = Number(t.phi_khach) || 0;
  var phiMay = t.phi_may_text ? sumExpr_(t.phi_may_text) : (Number(t.phi_may) || 0);
  var customer = resolveCustomer_(t);
  var tienPhi = Math.round(soTien * phiKhach / 100);
  var chiPhi = Math.round(soTien * phiMay / 100);
  var ngayHoan = String(t.ngay_hoan || '');
  if (!/^\d{4}-\d{2}-\d{2}$/.test(ngayHoan)) ngayHoan = addDays_(ngay, 1);
  if (ngayHoan < ngay) throw new Error('Ngày hoàn tiền không được trước ngày giao dịch.');
  return {
    ngay: ngay, dich_vu: dichVu, the: String(t.the || '').trim(), ngay_dao: ngayDao, ngay_sao_ke: ngaySaoKe,
    khach_id: customer.id, ten_khach: customer.ten, sdt: customer.sdt,
    so_tien: soTien, may: String(t.may || '').trim(), phi_khach: phiKhach, phi_may: round2_(phiMay),
    phi_may_text: String(t.phi_may_text || phiMay), tien_phi: tienPhi, chi_phi: chiPhi,
    loi_nhuan: tienPhi - chiPhi, ghi_chu: String(t.ghi_chu || ''),
    tien_hoan: soTien - chiPhi, ngay_hoan: ngayHoan
  };
}

/** Tìm khách theo id → SĐT → tên; chưa có thì tạo mới (không cần khóa riêng, gọi trong withLock_). */
function resolveCustomer_(t) {
  var c = findCustomer_({ id: t.khach_id, sdt: normalizePhone_(t.sdt), ten: t.ten_khach });
  var now = nowStr_();
  if (c) {
    var upd = { trang_thai: 'Khách quen', cap_nhat: now };
    var sdt = normalizePhone_(t.sdt);
    if (sdt && !c.sdt) upd.sdt = sdt;
    updateObj_('KhachHang', c.id, upd);
    return Object.assign(c, upd);
  }
  var ten = String(t.ten_khach || '').trim();
  if (!ten) throw new Error('Thiếu tên khách.');
  c = { id: newId_(), ten: ten, sdt: normalizePhone_(t.sdt), nguon: 'Nhập tay', trang_thai: 'Khách quen',
    ghi_chu: '', tao_luc: now, cap_nhat: now };
  appendObj_('KhachHang', c);
  return c;
}

function findCustomer_(q) {
  var all = readAll_('KhachHang');
  var hit = null;
  if (q.id) hit = all.filter(function (c) { return c.id === q.id; })[0];
  if (!hit && q.sdt) hit = all.filter(function (c) { return c.sdt === q.sdt; })[0];
  if (!hit && q.ten) {
    var key = normName_(q.ten);
    hit = all.filter(function (c) { return normName_(c.ten) === key; })[0];
  }
  return hit || null;
}

function apiDeleteTransaction_(p) {
  return withLock_(function () {
    var old = readAll_('GiaoDich').filter(function (x) { return x.id === p.id; })[0];
    if (old && old.hoan_tt !== 'Đã nhận') assertOpen_(old.ngay);
    return deleteObj_('GiaoDich', p.id);
  });
}

function apiMarkReminder_(p) {
  return withLock_(function () {
    var row = { key: p.key, han: p.han, trang_thai: p.trang_thai, ghi_chu: p.ghi_chu || '', cap_nhat: nowStr_() };
    var existing = readAll_('NhacLich').filter(function (r) { return r.key === p.key && r.han === p.han; })[0];
    if (existing) updateWhere_('NhacLich', function (r) { return r.key === p.key && r.han === p.han; }, row);
    else appendObj_('NhacLich', Object.assign({ event_id: '' }, row));
    return true;
  });
}

function apiSaveSettings_(p) {
  var props = PropertiesService.getScriptProperties();
  if (p.newPin) setPin_(String(p.newPin));
  if (p.remindFrom || p.remindTo) {
    var f = Number(p.remindFrom), t = Number(p.remindTo);
    if (!(f >= 1 && f <= 30 && t >= 0 && t <= f)) throw new Error('Khoảng nhắc không hợp lệ (ví dụ: từ 7 đến 5 ngày trước hạn).');
    props.setProperty('REMIND_FROM', String(f));
    props.setProperty('REMIND_TO', String(t));
  }
  if (p.graceDays) {
    var g = Number(p.graceDays);
    if (!(g >= 10 && g <= 30)) throw new Error('Số ngày từ sao kê đến hạn thanh toán: 10–30.');
    props.setProperty('GRACE_DAYS', String(g));
  }
  if (p.holidays !== undefined) {
    var days = String(p.holidays).split(/[\s,;]+/).filter(String).map(function (d) { return parseDateLoose_(d, parseYmd_(todayStr_()).y); });
    props.setProperty('HOLIDAYS', days.sort().join('\n'));
  }
  if (p.shiftAfterCards !== undefined) props.setProperty('SHIFT_AFTER_CARDS', String(p.shiftAfterCards).trim());
  if (p.ownerEmail !== undefined) props.setProperty('OWNER_EMAIL', String(p.ownerEmail).trim());
  if (p.calendar !== undefined) props.setProperty('CALENDAR', p.calendar ? 'on' : 'off');
  if (p.refundName !== undefined) props.setProperty('HOAN_NGUOI', String(p.refundName).trim() || 'C.Trâm');
  if (p.refundPhone !== undefined) props.setProperty('HOAN_SDT', normalizePhone_(p.refundPhone));
  return apiBootstrap_().settings;
}

/**
 * Nhập nhiều giao dịch từ bảng dán (Excel / Google Sheets / CSV, phân cách bằng tab hoặc dấu phẩy).
 * Cột: Ngày | Dịch vụ | Thẻ | Ngày đáo | Tên | Số tiền | Máy | Phí khách | Phí máy | SĐT | Ghi chú | Ngày sao kê
 */
function apiImportTransactions_(p) {
  var lines = String(p.text || '').split(/\r?\n/).filter(function (l) { return l.trim(); });
  var year = Number(p.year) || parseYmd_(todayStr_()).y;
  var ok = 0, errors = [];
  lines.forEach(function (line, i) {
    var cols = line.indexOf('\t') >= 0 ? line.split('\t') : line.split(',');
    cols = cols.map(function (c) { return c.trim(); });
    if (i === 0 && /ng[aà]y/i.test(cols[0]) && !/\d/.test(cols[0])) return; // dòng tiêu đề
    try {
      withLock_(function () {
        var obj = buildTransaction_({
          ngay: parseDateLoose_(cols[0], year), dich_vu: parseService_(cols[1]), the: cols[2],
          ngay_dao: cols[3] ? Number(cols[3]) : '', ten_khach: cols[4], so_tien: parseAmount_(cols[5]),
          may: cols[6], phi_khach: parseNum_(cols[7]), phi_may_text: cols[8], sdt: cols[9], ghi_chu: cols[10],
          ngay_sao_ke: cols[11] ? Number(cols[11]) : ''
        });
        obj.id = newId_();
        obj.tao_luc = nowStr_();
        obj.hoan_tt = obj.ngay_hoan < todayStr_() ? 'Đã nhận' : 'Chưa nhận'; // sổ cũ: coi như đã nhận
        appendObj_('GiaoDich', obj);
      });
      ok++;
    } catch (err) {
      errors.push('Dòng ' + (i + 1) + ': ' + (err.message || err));
    }
  });
  return { ok: ok, errors: errors };
}

/* ------------------------------------------------------------------ */
/* Tiền hoàn: số tiền − phí máy, người giữ máy hoàn lại hôm sau        */
/* ------------------------------------------------------------------ */

function refundName_() { return PropertiesService.getScriptProperties().getProperty('HOAN_NGUOI') || 'C.Trâm'; }

/**
 * Sổ công nợ với C.Trâm.
 *  - Khoản phải hoàn: mỗi giao dịch (trừ giao dịch cũ đã tất toán ngoài sổ: hoan_tt = 'Đã nhận').
 *  - Tiền đã chuyển/ứng: sheet DoiSoat, trừ dần vào khoản đến hạn sớm nhất (FIFO), ứng dư thì để dành cho giao dịch sau.
 * Trả về: tổng hợp (luôn tính trên toàn bộ sổ), các ngày còn thiếu, và sổ đối chiếu theo ngày trong [from, to].
 */
function apiRefunds_(p) {
  var today = todayStr_();
  var dues = readAll_('GiaoDich').filter(function (t) { return t.hoan_tt !== 'Đã nhận' && Number(t.tien_hoan); })
    .sort(function (a, b) { return a.ngay_hoan < b.ngay_hoan ? -1 : a.ngay_hoan > b.ngay_hoan ? 1 : a.ngay < b.ngay ? -1 : a.ngay > b.ngay ? 1 : String(a.tao_luc).localeCompare(String(b.tao_luc)); });
  var pays = readAll_('DoiSoat').map(function (x) { x.tien = paymentSign_(x); return x; })
    .sort(function (a, b) { return a.ngay < b.ngay ? -1 : a.ngay > b.ngay ? 1 : String(a.tao_luc).localeCompare(String(b.tao_luc)); });
  var paid = pays.reduce(function (a, x) { return a + x.tien; }, 0);

  // Phân bổ tiền đã chuyển vào từng giao dịch, cũ trước.
  var left = paid, days = {};
  dues.forEach(function (t) {
    var due = Number(t.tien_hoan) || 0;
    var got = Math.max(0, Math.min(due, left));
    left -= got;
    var d = days[t.ngay_hoan] || (days[t.ngay_hoan] = { ngay_hoan: t.ngay_hoan, so_gd: 0, so_tien: 0, chi_phi: 0, tien_hoan: 0, da_nhan: 0, con_lai: 0, items: [] });
    d.so_gd++;
    d.so_tien += Number(t.so_tien) || 0;
    d.chi_phi += Number(t.chi_phi) || 0;
    d.tien_hoan += due;
    d.da_nhan += got;
    d.con_lai += due - got;
    d.items.push({ id: t.id, ngay: t.ngay, dich_vu: t.dich_vu, the: t.the, ten_khach: t.ten_khach, so_tien: t.so_tien,
      may: t.may, phi_may: t.phi_may, chi_phi: t.chi_phi, tien_hoan: due, da_nhan: got, con_lai: due - got });
  });

  var tong = dues.reduce(function (a, t) { return a + (Number(t.tien_hoan) || 0); }, 0);
  var denHan = dues.filter(function (t) { return t.ngay_hoan <= today; }).reduce(function (a, t) { return a + (Number(t.tien_hoan) || 0); }, 0);
  var summary = {
    tong_phai_hoan: tong, tong_da_chuyen: paid, so_du: tong - paid,
    den_han: denHan, den_han_con_thieu: Math.max(0, denHan - paid),
    sap_toi: tong - denHan, // giao dịch hôm nay, hoàn ngày mai
    ung_du: Math.max(0, paid - tong)
  };

  // Sổ đối chiếu theo ngày giao dịch / ngày chuyển tiền, số dư lũy kế.
  var from = p.from || '', to = p.to || '9999-12-31';
  var book = {};
  function row(d) { return book[d] || (book[d] = { ngay: d, so_gd: 0, so_tien: 0, chi_phi: 0, phat_sinh: 0, da_chuyen: 0, payments: [] }); }
  dues.forEach(function (t) {
    var r = row(t.ngay);
    r.so_gd++; r.so_tien += Number(t.so_tien) || 0; r.chi_phi += Number(t.chi_phi) || 0; r.phat_sinh += Number(t.tien_hoan) || 0;
  });
  pays.forEach(function (x) {
    var r = row(x.ngay);
    r.da_chuyen += x.tien;
    r.payments.push({ id: x.id, ngay: x.ngay, loai: x.loai, so_tien: Number(x.so_tien) || 0, tien: x.tien, ghi_chu: x.ghi_chu });
  });
  var closings = closings_();
  closings.forEach(function (c) { row(c.ngay); });
  var bal = 0;
  var ledger = Object.keys(book).sort().map(function (k) {
    var r = book[k];
    bal += r.phat_sinh - r.da_chuyen;
    r.so_du = bal;
    return r;
  }).filter(function (r) { return r.ngay >= from && r.ngay <= to; });

  var byDate = {};
  closings.forEach(function (c) { byDate[c.ngay] = c; });
  ledger.forEach(function (r) { if (byDate[r.ngay]) r.ket = byDate[r.ngay]; });
  return {
    refundName: refundName_(), today: today, summary: summary, ledger: ledger,
    closings: closings.slice().reverse(), lastClosing: closings.length ? closings[closings.length - 1] : null,
    congNo: congNo_(closings.length ? closings[closings.length - 1] : null),
    days: Object.keys(days).sort().map(function (k) { return days[k]; })
      .filter(function (d) { return d.con_lai > 0 || (d.ngay_hoan >= from && d.ngay_hoan <= to); })
  };
}

function paymentSign_(x) {
  var n = Number(x.so_tien) || 0;
  return x.loai === 'Mình trả lại' || x.loai === 'Nợ cũ' ? -Math.abs(n) : x.loai === 'Điều chỉnh số dư' ? n : Math.abs(n);
}

/** Ghi / sửa một lần C.Trâm chuyển tiền hoặc ứng trước (không gắn với giao dịch nào). */
function apiSavePayment_(x) {
  var ngay = String(x.ngay || '');
  if (!/^\d{4}-\d{2}-\d{2}$/.test(ngay)) throw new Error('Ngày không hợp lệ.');
  var loai = PAYMENT_TYPES.indexOf(x.loai) >= 0 ? x.loai : 'Hoàn tiền';
  var n = Number(x.so_tien);
  if (!n || (loai !== 'Điều chỉnh số dư' && n < 0)) throw new Error('Số tiền phải lớn hơn 0.');
  var obj = { ngay: ngay, loai: loai, so_tien: n, ghi_chu: String(x.ghi_chu || '').trim() };
  return withLock_(function () {
    assertOpen_(ngay);
    if (x.id) {
      var old = readAll_('DoiSoat').filter(function (y) { return y.id === x.id; })[0];
      if (old) assertOpen_(old.ngay);
      updateObj_('DoiSoat', x.id, obj); obj.id = x.id; return obj;
    }
    obj.id = newId_();
    obj.tao_luc = nowStr_();
    appendObj_('DoiSoat', obj);
    return obj;
  });
}

function apiDeletePayment_(p) {
  return withLock_(function () {
    var old = readAll_('DoiSoat').filter(function (y) { return y.id === p.id; })[0];
    if (old) assertOpen_(old.ngay);
    return deleteObj_('DoiSoat', p.id);
  });
}

/* Thẻ của khách & ảnh CCCD / thẻ ------------------------------------- */

function cardsOf_(khachId) {
  var docs = readAll_('TaiLieu');
  return readAll_('TheKhach').filter(function (c) { return c.khach_id === khachId; }).map(function (c) {
    var photo = docs.filter(function (d) { return d.the_id === c.id && d.loai === 'Ảnh thẻ'; }).pop();
    var cccd = docs.filter(function (d) { return d.the_id === c.id && d.loai === 'CCCD chủ thẻ'; }).pop();
    c.anh_id = photo ? photo.id : '';
    c.cccd_id = cccd ? cccd.id : '';
    c.quan_he = c.quan_he || 'Chính chủ';
    return c;
  }).sort(function (a, b) { return String(a.ten_the).localeCompare(String(b.ten_the)); });
}

/** Chỉ giữ 4 số cuối – không lưu số thẻ đầy đủ. */
function last4_(v) { var d = String(v || '').replace(/\D/g, ''); return d ? d.slice(-4) : ''; }
function dayOrBlank_(v, label) {
  if (v === '' || v == null) return '';
  var n = Number(v);
  if (!(n >= 1 && n <= 31)) throw new Error(label + ' phải từ 1 đến 31.');
  return n;
}

function apiSaveCard_(c) {
  if (!c.khach_id) throw new Error('Chưa chọn khách.');
  var ten = String(c.ten_the || '').trim();
  if (!ten) throw new Error('Nhập tên thẻ (VD: SC, TP Visa).');
  var obj = { khach_id: c.khach_id, ten_the: ten, ngan_hang: String(c.ngan_hang || '').trim(), so_cuoi: last4_(c.so_cuoi),
    han_muc: Number(c.han_muc) || '', ngay_sao_ke: dayOrBlank_(c.ngay_sao_ke, 'Ngày sao kê'), ngay_dao: dayOrBlank_(c.ngay_dao, 'Ngày đáo'),
    ghi_chu: String(c.ghi_chu || '').trim(), cap_nhat: nowStr_(),
    chu_the: String(c.chu_the || '').trim(), quan_he: CARD_RELATIONS.indexOf(c.quan_he) >= 0 ? c.quan_he : 'Chính chủ' };
  if (obj.quan_he !== 'Chính chủ' && !obj.chu_the) throw new Error('Thẻ của người thân: nhập tên chủ thẻ.');
  return withLock_(function () {
    if (c.id) { updateObj_('TheKhach', c.id, obj); obj.id = c.id; return obj; }
    var dup = readAll_('TheKhach').filter(function (x) { return x.khach_id === c.khach_id && normName_(x.ten_the) === normName_(ten); })[0];
    if (dup) { updateObj_('TheKhach', dup.id, obj); obj.id = dup.id; return obj; }
    obj.id = newId_(); obj.tao_luc = obj.cap_nhat;
    appendObj_('TheKhach', obj);
    return obj;
  });
}

function apiDeleteCard_(p) {
  return withLock_(function () {
    readAll_('TaiLieu').filter(function (d) { return d.the_id === p.id; }).forEach(function (d) { trashDoc_(d); });
    return deleteObj_('TheKhach', p.id);
  });
}

/** Ghi giao dịch với thẻ mới thì tự thêm vào danh sách thẻ của khách (kèm ngày đáo / sao kê). */
function upsertCardFromTx_(t) {
  if (!t.khach_id || !t.the) return;
  var c = readAll_('TheKhach').filter(function (x) { return x.khach_id === t.khach_id && normName_(x.ten_the) === normName_(t.the); })[0];
  var now = nowStr_();
  if (!c) {
    var id = newId_();
    appendObj_('TheKhach', { id: id, khach_id: t.khach_id, ten_the: t.the, ngan_hang: '', so_cuoi: '', han_muc: '',
      ngay_sao_ke: t.ngay_sao_ke || '', ngay_dao: t.ngay_dao || '', ghi_chu: '', tao_luc: now, cap_nhat: now, chu_the: '', quan_he: 'Chính chủ' });
    return id;
  }
  var upd = {};
  if (t.ngay_dao && !c.ngay_dao) upd.ngay_dao = t.ngay_dao;
  if (t.ngay_sao_ke && !c.ngay_sao_ke) upd.ngay_sao_ke = t.ngay_sao_ke;
  if (Object.keys(upd).length) { upd.cap_nhat = now; updateObj_('TheKhach', c.id, upd); }
  return c.id;
}

var DRIVE_HELP = 'CRM chưa được cấp quyền Google Drive để lưu ảnh. Cách bật: mở Apps Script → dán đủ file appsscript.json mới → ' +
  'chọn hàm setup → bấm Chạy → Cho phép (Allow) → rồi Triển khai "Phiên bản mới".';

function docRoot_() {
  var props = PropertiesService.getScriptProperties();
  var root = null, id = props.getProperty('DOC_FOLDER');
  if (id) { try { root = DriveApp.getFolderById(id); } catch (e) { if (isAuthError_(e)) throw e; root = null; } }
  if (!root) {
    root = DriveApp.createFolder('CRM Thẻ Tín Dụng – Hồ sơ khách (riêng tư)');
    props.setProperty('DOC_FOLDER', root.getId());
  }
  return root;
}
function isAuthError_(e) { return /permission|quyền|authoriz|scope|DriveApp/i.test(String(e && e.message || e)); }
/** Gọi Drive; lỗi do chưa cấp quyền thì báo hướng dẫn dễ hiểu. */
function withDrive_(fn) {
  try { return fn(); } catch (e) { if (isAuthError_(e)) throw new Error(DRIVE_HELP); throw e; }
}
/** Kiểm tra quyền Drive (lưu kết quả 10 phút) để giao diện báo trước. */
function driveReady_() {
  var cache = CacheService.getScriptCache();
  if (cache.get('drive_ok') === '1') return true;
  try { docRoot_(); cache.put('drive_ok', '1', 600); return true; } catch (e) { return false; }
}

/** Thư mục riêng tư trong Drive của chủ CRM: <gốc>/<tên khách – SĐT>. Không chia sẻ cho ai. */
function docFolder_(khach) {
  var root = docRoot_();
  var name = (khach.ten || 'Khách') + (khach.sdt ? ' – ' + khach.sdt : '') + ' (' + khach.id + ')';
  var it = root.getFoldersByName(name);
  return it.hasNext() ? it.next() : root.createFolder(name);
}

var MAX_DOC_BYTES = 6 * 1024 * 1024;

/** Lưu ảnh CCCD / ảnh thẻ (base64 từ điện thoại, đã nén). Ảnh CCCD cùng mặt hoặc ảnh của cùng thẻ: thay ảnh cũ. */
function apiUploadDoc_(p) {
  var khach = readAll_('KhachHang').filter(function (c) { return c.id === p.khach_id; })[0];
  if (!khach) throw new Error('Lưu khách trước rồi mới thêm ảnh.');
  var loai = DOC_TYPES.indexOf(p.loai) >= 0 ? p.loai : 'Khác';
  var m = String(p.data || '').match(/^data:(image\/(?:jpeg|png|webp));base64,(.+)$/);
  if (!m) throw new Error('Chỉ nhận ảnh (JPG, PNG).');
  if (m[2].length * 0.75 > MAX_DOC_BYTES) throw new Error('Ảnh quá lớn (tối đa 6MB).');
  if (CARD_DOC_TYPES.indexOf(loai) >= 0 && !p.the_id) throw new Error('Chưa chọn thẻ.');
  var ext = m[1] === 'image/png' ? '.png' : m[1] === 'image/webp' ? '.webp' : '.jpg';
  var name = loai + (p.the_ten ? ' ' + p.the_ten : '') + ' – ' + nowStr_().replace(/[: ]/g, '-') + ext;
  return withLock_(function () {
    var file = withDrive_(function () { return docFolder_(khach).createFile(Utilities.newBlob(Utilities.base64Decode(m[2]), m[1], name)); });
    readAll_('TaiLieu').filter(function (d) {
      return d.khach_id === khach.id && d.loai === loai && loai !== 'Khác' && (CARD_DOC_TYPES.indexOf(loai) < 0 || d.the_id === p.the_id);
    }).forEach(function (d) { trashDoc_(d); });
    var obj = { id: newId_(), khach_id: khach.id, loai: loai, the_id: p.the_id || '', file_id: file.getId(), ten_file: name,
      ghi_chu: String(p.ghi_chu || ''), tao_luc: nowStr_() };
    appendObj_('TaiLieu', obj);
    return obj;
  });
}

function apiGetDoc_(p) {
  var d = readAll_('TaiLieu').filter(function (x) { return x.id === p.id; })[0];
  if (!d) throw new Error('Không tìm thấy ảnh.');
  var blob = withDrive_(function () { return DriveApp.getFileById(d.file_id).getBlob(); });
  return { id: d.id, loai: d.loai, dataUrl: 'data:' + blob.getContentType() + ';base64,' + Utilities.base64Encode(blob.getBytes()) };
}

function trashDoc_(d) {
  try { DriveApp.getFileById(d.file_id).setTrashed(true); } catch (e) { /* file đã bị xóa tay */ }
  deleteObj_('TaiLieu', d.id);
}

function apiDeleteDoc_(p) {
  return withLock_(function () {
    var d = readAll_('TaiLieu').filter(function (x) { return x.id === p.id; })[0];
    if (d) trashDoc_(d);
    return true;
  });
}

/* Kết số dư ----------------------------------------------------------- */

function closings_() {
  return readAll_('KetSo').sort(function (a, b) { return a.ngay < b.ngay ? -1 : a.ngay > b.ngay ? 1 : 0; });
}
function lastClosing_() { var c = closings_(); return c.length ? c[c.length - 1] : null; }

/** Sổ đã kết đến ngày X thì không được thêm/sửa/xóa giao dịch, tiền chuyển trong khoảng đó. */
function assertOpen_(ngay) {
  var c = lastClosing_();
  if (c && ngay && ngay <= c.ngay) {
    throw new Error('Đã kết số dư với ' + refundName_() + ' đến hết ngày ' + fmtDmy_(c.ngay) +
      '. Muốn sửa số liệu ngày ' + fmtDmy_(ngay) + ' thì vào Công nợ → bỏ lần kết sổ đó trước.');
  }
}

/**
 * Bảng đối chiếu với C.Trâm cho kỳ [from, to]:
 *   số dư đầu kỳ + tiền hoàn phát sinh (giao dịch làm trong kỳ) − tiền C.Trâm chuyển/ứng trong kỳ = số dư cuối kỳ.
 * `opening` bỏ trống thì tự tính từ toàn bộ sổ trước ngày `from`. Dương = C.Trâm còn nợ mình, âm = C.Trâm ứng dư.
 * Kèm tổng kết mọi giao dịch trong kỳ (phí khách, phí máy, phí của mình…).
 */
function periodStatement_(from, to, opening) {
  var allTx = readAll_('GiaoDich');
  var dues = allTx.filter(function (t) { return t.hoan_tt !== 'Đã nhận' && Number(t.tien_hoan); });
  var pays = readAll_('DoiSoat').map(function (x) { x.tien = paymentSign_(x); return x; })
    .sort(function (a, b) { return a.ngay < b.ngay ? -1 : a.ngay > b.ngay ? 1 : String(a.tao_luc).localeCompare(String(b.tao_luc)); });
  if (opening === undefined) {
    opening = 0;
    dues.forEach(function (t) { if (t.ngay < from) opening += Number(t.tien_hoan) || 0; });
    pays.forEach(function (x) { if (x.ngay < from) opening -= x.tien; });
  }
  var st = { tu_ngay: from, ngay: to, so_du_truoc: opening, so_gd: 0, so_tien: 0, chi_phi: 0, phat_sinh: 0, da_chuyen: 0,
    so_lan_chuyen: 0, payments: [], ngay_lam: [] };
  var days = {};
  function day(d) { return days[d] || (days[d] = { ngay: d, so_gd: 0, so_tien: 0, chi_phi: 0, phat_sinh: 0, da_chuyen: 0 }); }
  dues.forEach(function (t) {
    if (t.ngay < from || t.ngay > to) return;
    st.so_gd++;
    st.so_tien += Number(t.so_tien) || 0;
    st.chi_phi += Number(t.chi_phi) || 0;
    st.phat_sinh += Number(t.tien_hoan) || 0;
    var d = day(t.ngay);
    d.so_gd++; d.so_tien += Number(t.so_tien) || 0; d.chi_phi += Number(t.chi_phi) || 0; d.phat_sinh += Number(t.tien_hoan) || 0;
  });
  pays.forEach(function (x) {
    if (x.ngay < from || x.ngay > to) return;
    st.da_chuyen += x.tien;
    st.so_lan_chuyen++;
    day(x.ngay).da_chuyen += x.tien;
    st.payments.push({ id: x.id, ngay: x.ngay, loai: x.loai, tien: x.tien, ghi_chu: x.ghi_chu });
  });
  // Trong ngày: tiền ứng/chuyển trừ vào nợ trước (ứng trước khi kết tiền), cuối ngày mới cộng tiền hoàn của giao dịch.
  var bal = opening, payByDay = {};
  st.payments.forEach(function (x) { (payByDay[x.ngay] = payByDay[x.ngay] || []).push(x); });
  st.ngay_lam = Object.keys(days).sort().map(function (k) {
    var d = days[k];
    d.so_du_dau = bal;
    (payByDay[k] || []).forEach(function (x) { x.so_du_truoc = bal; bal -= x.tien; x.so_du_sau = bal; });
    d.so_du_truoc_gd = bal;
    bal += d.phat_sinh;
    d.so_du = bal;
    return d;
  });
  st.so_du = opening + st.phat_sinh - st.da_chuyen;
  st.giao_dich = summarize_(allTx.filter(function (t) { return t.ngay >= from && t.ngay <= to; }));
  st.giao_dich.tien_hoan = st.giao_dich.tien_hoan || 0;
  st.refundName = refundName_();
  return st;
}

/**
 * Công nợ hiện tại theo 2 mục:
 *   Mục 1 – chốt đến ngày (lần kết gần nhất): tồn.
 *   Mục 2 – từ ngày chốt đến nay: tiền hoàn phát sinh − các lần tạm ứng / chuyển = tồn mục 2.
 *   Tổng công nợ = mục 1 + mục 2 (dương = C.Trâm còn nợ mình, âm = C.Trâm ứng dư).
 */
function congNo_(last) {
  var from = last ? addDays_(last.ngay, 1) : '';
  var st = periodStatement_(from, '9999-12-31', last ? Number(last.so_du) || 0 : 0);
  var ton2 = st.phat_sinh - st.da_chuyen;
  return {
    chot_ngay: last ? last.ngay : '', ton1: st.so_du_truoc,
    tu_ngay: from || (st.ngay_lam.length ? st.ngay_lam[0].ngay : todayStr_()),
    so_gd: st.so_gd, so_tien: st.so_tien, chi_phi: st.chi_phi, phat_sinh: st.phat_sinh,
    tam_ung: st.payments, tong_tam_ung: st.da_chuyen, ton2: ton2, tong: st.so_du_truoc + ton2
  };
}

/** Bảng đối chiếu để kết số dư đến hết ngày `ngay` (kỳ bắt đầu sau lần kết gần nhất). */
function statementAt_(ngay) {
  ngay = String(ngay || todayStr_());
  if (!/^\d{4}-\d{2}-\d{2}$/.test(ngay)) throw new Error('Ngày kết không hợp lệ.');
  var last = lastClosing_();
  if (last && ngay <= last.ngay) throw new Error('Đã kết đến ngày ' + fmtDmy_(last.ngay) + ', hãy chọn ngày sau đó.');
  var st;
  if (last) {
    st = periodStatement_(addDays_(last.ngay, 1), ngay, Number(last.so_du) || 0);
    st.ket_truoc = last.ngay;
  } else {
    st = periodStatement_('', ngay, 0);
    st.ket_truoc = '';
    st.tu_ngay = st.ngay_lam.length ? st.ngay_lam[0].ngay : ngay;
  }
  st.tin_nhan = statementText_(st, 'ket');
  return st;
}

/** Tổng kết từ ngày a đến ngày b (không khóa sổ). */
function apiPeriodSummary_(p) {
  var from = String(p.from || ''), to = String(p.to || '');
  if (!/^\d{4}-\d{2}-\d{2}$/.test(from) || !/^\d{4}-\d{2}-\d{2}$/.test(to)) throw new Error('Chọn đủ từ ngày và đến ngày.');
  if (from > to) throw new Error('"Từ ngày" phải trước "đến ngày".');
  var st = periodStatement_(from, to);
  st.tin_nhan = statementText_(st, 'range');
  return st;
}

/** Diễn giải số dư sau một lần ứng/chuyển: ứng ít hơn nợ → còn nợ; ứng nhiều hơn nợ → trừ hết nợ, phần dư là ứng dư. */
function balanceEffect_(before, after, money) {
  money = money || fmtMoney_;
  if (before > 0 && after < 0) return 'trừ hết nợ ' + money(before) + ', dư ' + money(-after) + ' (chị ứng dư)';
  if (before > 0 && after === 0) return 'trừ hết nợ ' + money(before) + ', hết nợ';
  if (before > 0 && after > 0 && after < before) return 'chị còn nợ ' + money(after);
  return after > 0 ? 'chị còn nợ ' + money(after) : after < 0 ? 'chị ứng dư ' + money(-after) : 'hết nợ';
}

function statementText_(st, mode) {
  var name = st.refundName, ten = name.replace(/^C\.\s*/i, '');
  function no(v) { return v > 0 ? 'chị còn nợ em ' + fmtMoney_(v) : v < 0 ? 'chị ứng dư ' + fmtMoney_(-v) : 'không còn nợ'; }
  var one = st.tu_ngay === st.ngay;
  var lines = [mode === 'ket'
    ? 'Chị ' + ten + ' ơi, em gửi đối chiếu đến hết ngày ' + fmtDmy_(st.ngay) + ':'
    : 'Chị ' + ten + ' ơi, em gửi tổng kết ' + (one ? 'ngày ' + fmtDmy_(st.ngay) : 'từ ' + fmtDmy_(st.tu_ngay) + ' đến ' + fmtDmy_(st.ngay)) + ':'];
  lines.push('• ' + (mode === 'ket' && st.ket_truoc ? 'Số dư kết ngày ' + fmtDmy_(st.ket_truoc) : 'Công nợ trước đó') + ': ' + no(st.so_du_truoc));
  st.ngay_lam.forEach(function (d) {
    var pre = one ? '• ' : '   ';
    if (!one) lines.push('• Ngày ' + fmtDm_(d.ngay) + ':');
    st.payments.filter(function (x) { return x.ngay === d.ngay; }).forEach(function (x) {
      lines.push(pre + (x.tien < 0 ? '+ ' : '− ') + x.loai + ' ' + fmtMoney_(Math.abs(x.tien)) + (x.ghi_chu ? ' (' + x.ghi_chu + ')' : '') +
        ' → ' + balanceEffect_(x.so_du_truoc, x.so_du_sau));
    });
    if (d.so_gd) {
      lines.push(pre + '+ Kết GD: ' + d.so_gd + ' GD ' + fmtMoney_(d.so_tien) + ' − phí máy ' + fmtMoney_(d.chi_phi) + ' = ' + fmtMoney_(d.phat_sinh) +
        ' → ' + (d.so_du > 0 ? 'chị còn nợ ' + fmtMoney_(d.so_du) : d.so_du < 0 ? 'chị còn ứng dư ' + fmtMoney_(-d.so_du) : 'hết nợ'));
    }
  });
  if (!st.ngay_lam.length) lines.push('• Không có giao dịch hay tiền ứng/chuyển.');
  if (!one && st.ngay_lam.length) {
    lines.push('• Cộng: làm ' + st.so_gd + ' GD ' + fmtMoney_(st.so_tien) + ', phí máy ' + fmtMoney_(st.chi_phi) + ', tiền hoàn ' + fmtMoney_(st.phat_sinh) +
      '; chị chuyển/ứng ' + (st.so_lan_chuyen ? st.so_lan_chuyen + ' lần ' : '') + fmtMoney_(st.da_chuyen));
  }
  lines.push('=> ' + (mode === 'ket' ? 'Kết đến hết ' : 'Số dư cuối ') + fmtDmy_(st.ngay) + ': ' + no(st.so_du) + '.');
  return lines.join('\n');
}

function apiCloseBalance_(p) {
  return withLock_(function () {
    var st = statementAt_(p.ngay);
    if (st.ngay > todayStr_()) throw new Error('Không kết số dư cho ngày trong tương lai.');
    var obj = { id: newId_(), ngay: st.ngay, tu_ngay: st.tu_ngay, so_du_truoc: st.so_du_truoc, so_gd: st.so_gd, so_tien: st.so_tien,
      chi_phi: st.chi_phi, phat_sinh: st.phat_sinh, da_chuyen: st.da_chuyen, so_du: st.so_du, ghi_chu: String(p.ghi_chu || '').trim(), tao_luc: nowStr_() };
    appendObj_('KetSo', obj);
    obj.tin_nhan = st.tin_nhan;
    return obj;
  });
}

/** Chỉ bỏ được lần kết gần nhất (để sửa số liệu rồi kết lại). */
function apiDeleteClosing_(p) {
  return withLock_(function () {
    var last = lastClosing_();
    if (!last || last.id !== p.id) throw new Error('Chỉ bỏ được lần kết số dư gần nhất.');
    return deleteObj_('KetSo', p.id);
  });
}

/** Giao dịch cũ (trước khi có mục tiền hoàn) chưa có trạng thái: đã qua ngày hoàn thì coi như đã nhận. */
function normRefundStatus_(t) {
  if (t.hoan_tt) return t.hoan_tt;
  return normDate_(t.ngay_hoan) < todayStr_() ? 'Đã nhận' : 'Chưa nhận';
}

function normDate_(v) { return v instanceof Date ? Utilities.formatDate(v, TZ, 'yyyy-MM-dd') : String(v || ''); }

/* ------------------------------------------------------------------ */
/* Nhắc lịch đáo hạn tháng sau                                         */
/* ------------------------------------------------------------------ */

/** Khoảng nhắc: bắt đầu nhắc trước hạn `from` ngày, phải báo xong trước hạn `to` ngày (mặc định 7 → 5). */
function remindWindow_() {
  var props = PropertiesService.getScriptProperties();
  return { from: Number(props.getProperty('REMIND_FROM') || 7), to: Number(props.getProperty('REMIND_TO') || 5) };
}

/**
 * Mỗi cặp (khách, thẻ) có giao dịch đáo hạn kèm "ngày đáo" là một khách định kỳ.
 * Hạn kỳ này = ngày đáo gần nhất với ngày giao dịch; hạn kỳ sau = +1 tháng.
 * Nhắc từ (hạn − 7 ngày) đến (hạn − 5 ngày). Khi khách làm giao dịch mới, mốc tự chuyển sang tháng tiếp theo.
 * `from`/`to` lọc theo ngày bắt đầu nhắc.
 */
function computeReminders_(from, to) {
  var win = remindWindow_();
  var today = todayStr_();
  var latestDao = {}, latestRut = {};
  readAll_('GiaoDich').forEach(function (t) {
    var key = t.khach_id + '|' + String(t.the).toUpperCase();
    var isRut = t.dich_vu === 'Rút tiền' || t.dich_vu === 'Ví trả sau' || t.dich_vu === 'Đáo + Rút';
    if (t.ngay_dao && t.dich_vu !== 'Rút tiền' && t.dich_vu !== 'Ví trả sau') {
      if (!latestDao[key] || t.ngay > latestDao[key].ngay) latestDao[key] = t;
    }
    if (isRut && t.ngay_sao_ke) {
      if (!latestRut[key] || t.ngay > latestRut[key].ngay) latestRut[key] = t;
    }
  });
  var marks = {};
  readAll_('NhacLich').forEach(function (r) { marks[r.key + '@' + r.han] = r; });
  var customers = {};
  readAll_('KhachHang').forEach(function (c) { customers[c.id] = c; });

  var out = [];
  var cal = offDayCalendar_();
  function push(loai, key, t, han, nhac, nhacHan, adj) {
    if (marks[key + '@*'] && marks[key + '@*'].trang_thai === 'Ngưng nhắc') return;
    if ((from && nhac < from) || (to && nhac > to)) return;
    var mark = marks[key + '@' + han];
    var cust = customers[t.khach_id] || {};
    out.push({
      loai: loai, key: key, han: han, han_thuc: adj ? adj.han : han, han_doi: adj ? adj.ly_do : '',
      nhac_ngay: nhac, nhac_han: nhacHan, gap: today > nhacHan,
      khach_id: t.khach_id, ten: cust.ten || t.ten_khach, sdt: cust.sdt || t.sdt, the: t.the,
      ngay_dao: t.ngay_dao, ngay_sao_ke: t.ngay_sao_ke, so_tien_gan_nhat: t.so_tien, may: t.may, lan_cuoi: t.ngay,
      trang_thai: mark ? mark.trang_thai : 'Chưa báo', qua_han: (adj ? adj.han : han) < today, event_id: mark ? mark.event_id : ''
    });
  }

  // Đáo hạn: nhắc từ (hạn − 7) đến (hạn − 5) ngày.
  Object.keys(latestDao).forEach(function (key) {
    var t = latestDao[key];
    var cur = parseYmd_(nearestDueDate_(t.ngay, Number(t.ngay_dao)));
    var nm = addMonths_(cur.y, cur.m, 1);
    var han = ymd_(nm.y, nm.m, Math.min(Number(t.ngay_dao), daysInMonth_(nm.y, nm.m)));
    var adj = adjustDueDate_(han, t.the, cal);
    push('Đáo hạn', key, t, han, addDays_(adj.han, -win.from), addDays_(adj.han, -win.to), adj);
  });

  // Rút tiền: gợi ý rút ngay sau ngày sao kê kỳ tới (miễn lãi lâu nhất), nhắc trước 2 ngày.
  Object.keys(latestRut).forEach(function (key) {
    var t = latestRut[key];
    // Khách chưa quay lại khi đã qua ngày đẹp thì gợi ý sang kỳ sao kê kế tiếp.
    var fromDay = addDays_(t.ngay, 1) > addDays_(today, -2) ? addDays_(t.ngay, 1) : addDays_(today, -2);
    var best = nextBestWithdrawDate_(fromDay, Number(t.ngay_sao_ke));
    push('Rút sau sao kê', 'R:' + key, t, best, addDays_(best, -2), best);
  });

  out.sort(function (a, b) { return a.nhac_ngay < b.nhac_ngay ? -1 : a.nhac_ngay > b.nhac_ngay ? 1 : 0; });
  return out;
}

function holidayList_() {
  var v = PropertiesService.getScriptProperties().getProperty('HOLIDAYS');
  return (v === null ? DEFAULT_HOLIDAYS.join('\n') : v).split(/\s+/).filter(String);
}

function offDayCalendar_() {
  var set = {};
  holidayList_().forEach(function (d) { set[d] = 1; });
  var after = {};
  String(PropertiesService.getScriptProperties().getProperty('SHIFT_AFTER_CARDS') || '').split(/[\s,;]+/)
    .filter(String).forEach(function (c) { after[c.toUpperCase()] = 1; });
  return { holidays: set, after: after };
}

function isOffDay_(d, cal) { return weekday_(d) >= 5 || !!cal.holidays[d]; }

/**
 * Hạn rơi vào T7/CN/lễ/Tết thì ngân hàng dời ±1–2 ngày. Mặc định dời lên ngày làm việc TRƯỚC (an toàn, không lỡ hạn);
 * thẻ khai trong "SHIFT_AFTER_CARDS" thì dời ra ngày làm việc SAU.
 */
function adjustDueDate_(han, card, cal) {
  cal = cal || offDayCalendar_();
  if (!isOffDay_(han, cal)) return { han: han, ly_do: '' };
  var step = cal.after[String(card || '').toUpperCase()] ? 1 : -1;
  var d = han;
  for (var i = 0; i < 15 && isOffDay_(d, cal); i++) d = addDays_(d, step);
  var why = cal.holidays[han] ? 'ngày lễ/Tết' : (weekday_(han) === 5 ? 'thứ 7' : 'chủ nhật');
  return { han: d, ly_do: 'Hạn ' + fmtDm_(han) + ' rơi vào ' + why + ' → tính ' + fmtDm_(d) + (step < 0 ? ' (dời lên trước)' : ' (dời ra sau)') };
}

function graceDays_() {
  return Number(PropertiesService.getScriptProperties().getProperty('GRACE_DAYS') || 25);
}

/** Ngày sao kê kế tiếp tính từ `fromDate` (kể cả chính ngày đó). */
function nextStatementDate_(fromDate, saoKe) {
  var p = parseYmd_(fromDate);
  for (var off = 0; off < 3; off++) {
    var mm = addMonths_(p.y, p.m, off);
    var d = ymd_(mm.y, mm.m, Math.min(saoKe, daysInMonth_(mm.y, mm.m)));
    if (d >= fromDate) return d;
  }
  return null;
}

/** Ngày rút tốt nhất = ngày ngay sau sao kê, từ `fromDate` trở đi. */
function nextBestWithdrawDate_(fromDate, saoKe) {
  return addDays_(nextStatementDate_(addDays_(fromDate, -1), saoKe), 1);
}

/**
 * Tư vấn rút tiền: giao dịch ngày `ngay` sẽ vào kỳ sao kê nào, hạn thanh toán khi nào, được miễn lãi bao nhiêu ngày.
 * Hạn thanh toán = ngày đáo của thẻ (nếu biết) sau ngày sao kê, không thì sao kê + GRACE_DAYS (mặc định 25),
 * dời theo T7/CN/lễ như adjustDueDate_.
 */
function withdrawAdvice_(ngay, saoKe, ngayDao, card) {
  if (!(saoKe >= 1 && saoKe <= 31)) throw new Error('Cần ngày sao kê (1–31).');
  function dueAfter(stmt) {
    var due = ngayDao >= 1 && ngayDao <= 31 ? nextStatementDate_(addDays_(stmt, 1), ngayDao) : addDays_(stmt, graceDays_());
    return adjustDueDate_(due, card).han;
  }
  var stmt = nextStatementDate_(ngay, saoKe);
  var due = dueAfter(stmt);
  var best = nextBestWithdrawDate_(ngay, saoKe);
  var bestDue = dueAfter(nextStatementDate_(best, saoKe));
  return {
    ngay: ngay, sao_ke: stmt, han_thanh_toan: due, mien_lai: diffDays_(due, ngay) + 1,
    ngay_tot_nhat: best, han_neu_rut_ngay_tot: bestDue, mien_lai_toi_da: diffDays_(bestDue, best) + 1,
    nen_doi: best !== ngay && diffDays_(due, ngay) < 30
  };
}

function nearestDueDate_(dateStr, day) {
  var p = parseYmd_(dateStr);
  var best = null, bestDiff = Infinity;
  [-1, 0, 1].forEach(function (off) {
    var mm = addMonths_(p.y, p.m, off);
    var cand = ymd_(mm.y, mm.m, Math.min(day, daysInMonth_(mm.y, mm.m)));
    var diff = Math.abs(diffDays_(cand, dateStr));
    // Hòa thì ưu tiên hạn phía sau (khách thường đáo trước hạn).
    if (diff < bestDiff || (diff === bestDiff && cand > best)) { best = cand; bestDiff = diff; }
  });
  return best;
}

/** Chạy tự động 7h sáng: gửi email danh sách cần báo, tạo sự kiện Google Calendar cho 7 ngày tới. */
function dailyJob() {
  var props = PropertiesService.getScriptProperties();
  var today = todayStr_();
  var rem = computeReminders_(addDays_(today, -30), addDays_(today, 7));
  var due = rem.filter(function (r) { return r.nhac_ngay <= today && r.trang_thai === 'Chưa báo'; });

  if (props.getProperty('CALENDAR') !== 'off') {
    var cal = CalendarApp.getDefaultCalendar();
    rem.forEach(function (r) {
      if (r.event_id || r.trang_thai !== 'Chưa báo' || r.nhac_han < today) return;
      // Sự kiện cả ngày kéo dài suốt khoảng nhắc (hạn−7 → hạn−5); ngày kết thúc của Calendar không tính.
      var title = r.loai === 'Đáo hạn'
        ? '📞 Báo khách ' + r.ten + ' – đáo ' + r.the + ' ngày ' + fmtDmy_(r.han_thuc)
        : '💵 Mời khách ' + r.ten + ' rút ' + r.the + ' ngày ' + fmtDmy_(r.han) + ' (sau sao kê)';
      var ev = cal.createAllDayEvent(title,
        parseDateObj_(r.nhac_ngay), parseDateObj_(addDays_(r.nhac_han, 1)), {
          description: 'SĐT: ' + (r.sdt || 'chưa có') + '\nThẻ: ' + r.the + '\nHạn: ' + fmtDmy_(r.han_thuc) +
            (r.han_doi ? '\n' + r.han_doi : '') +
            '\nLần trước: ' + fmtDmy_(r.lan_cuoi) + ' – ' + fmtMoney_(r.so_tien_gan_nhat) + ' – máy ' + r.may
        });
      ev.addPopupReminder(0);
      withLock_(function () {
        var exists = readAll_('NhacLich').some(function (x) { return x.key === r.key && x.han === r.han; });
        var row = { key: r.key, han: r.han, trang_thai: 'Chưa báo', ghi_chu: '', event_id: ev.getId(), cap_nhat: nowStr_() };
        if (exists) updateWhere_('NhacLich', function (x) { return x.key === r.key && x.han === r.han; }, { event_id: ev.getId() });
        else appendObj_('NhacLich', row);
      });
    });
  }

  var email = props.getProperty('OWNER_EMAIL');
  if (email && due.length) {
    var body = due.map(function (r, i) {
      return (i + 1) + '. [' + r.loai + '] ' + r.ten + ' – ' + (r.sdt || 'chưa có SĐT') + ' – thẻ ' + r.the +
        (r.loai === 'Đáo hạn' ? ' – hạn ' + fmtDmy_(r.han_thuc) + (r.han_doi ? ' (' + r.han_doi + ')' : '') : ' – ngày rút đẹp ' + fmtDmy_(r.han)) +
        (r.qua_han ? ' (ĐÃ QUA HẠN)' : r.gap ? ' (GẤP – quá ngày phải báo ' + fmtDmy_(r.nhac_han) + ')' : ' – báo trước ' + fmtDmy_(r.nhac_han)) +
        ' – lần trước ' + fmtMoney_(r.so_tien_gan_nhat);
    }).join('\n');
    MailApp.sendEmail(email, '📅 ' + due.length + ' khách cần báo hôm nay (' + fmtDmy_(today) + ')',
      body + '\n\nMở CRM: ' + ScriptApp.getService().getUrl());
  }
  return due.length;
}

/* ------------------------------------------------------------------ */
/* Báo cáo tuần / tháng / năm                                          */
/* ------------------------------------------------------------------ */

function apiReport_(p) {
  var type = p.type || 'month';
  var year = Number(p.year) || parseYmd_(todayStr_()).y;
  var month = Number(p.month) || parseYmd_(todayStr_()).m;
  var tx = readAll_('GiaoDich');
  var customers = readAll_('KhachHang');
  var leads = readAll_('LienHe');
  var periods = [];

  if (type === 'week') {
    var first = ymd_(year, month, 1), last = ymd_(year, month, daysInMonth_(year, month));
    var start = first, n = 1;
    while (start <= last) {
      var end = addDays_(start, 6 - weekday_(start)); // tới Chủ nhật
      if (end > last) end = last;
      periods.push({ label: 'Tuần ' + n + ' (' + fmtDm_(start) + '–' + fmtDm_(end) + ')', from: start, to: end });
      start = addDays_(end, 1);
      n++;
    }
  } else if (type === 'month') {
    for (var m = 1; m <= 12; m++) {
      periods.push({ label: 'Tháng ' + m, from: ymd_(year, m, 1), to: ymd_(year, m, daysInMonth_(year, m)) });
    }
  } else {
    var years = {};
    tx.forEach(function (t) { years[t.ngay.slice(0, 4)] = 1; });
    years[String(year)] = 1;
    Object.keys(years).sort().forEach(function (y) {
      periods.push({ label: 'Năm ' + y, from: y + '-01-01', to: y + '-12-31' });
    });
  }

  function inRange(d, a, b) { return d >= a && d <= b; }
  var rows = periods.map(function (pr) {
    var t = tx.filter(function (x) { return inRange(x.ngay, pr.from, pr.to); });
    var s = summarize_(t);
    s.label = pr.label; s.from = pr.from; s.to = pr.to;
    s.khach_moi = customers.filter(function (c) { return inRange(String(c.tao_luc).slice(0, 10), pr.from, pr.to); }).length;
    s.lead_web = leads.filter(function (l) { return l.sdt && inRange(String(l.thoi_gian).slice(0, 10), pr.from, pr.to); }).length;
    s.bam_web = leads.filter(function (l) { return !l.sdt && inRange(String(l.thoi_gian).slice(0, 10), pr.from, pr.to); }).length;
    return s;
  });
  var all = { from: periods[0].from, to: periods[periods.length - 1].to };
  var allTx = tx.filter(function (x) { return inRange(x.ngay, all.from, all.to); });
  var total = summarize_(allTx);
  total.khach_moi = rows.reduce(function (a, r) { return a + r.khach_moi; }, 0);
  total.lead_web = rows.reduce(function (a, r) { return a + r.lead_web; }, 0);
  total.bam_web = rows.reduce(function (a, r) { return a + r.bam_web; }, 0);
  return {
    type: type, year: year, month: month, rows: rows, total: total,
    byService: groupBy_(allTx, 'dich_vu'), byMachine: groupBy_(allTx, 'may'),
    byCard: groupBy_(allTx, 'the'), topCustomers: groupBy_(allTx, 'ten_khach').slice(0, 10)
  };
}

function summarize_(tx) {
  var s = { so_gd: tx.length, so_dao: 0, so_rut: 0, so_tien: 0, tien_phi: 0, chi_phi: 0, loi_nhuan: 0, tien_hoan: 0, so_khach: 0 };
  var seen = {};
  tx.forEach(function (t) {
    if (t.dich_vu === 'Rút tiền' || t.dich_vu === 'Ví trả sau') s.so_rut++; else s.so_dao++;
    s.so_tien += Number(t.so_tien) || 0;
    s.tien_phi += Number(t.tien_phi) || 0;
    s.chi_phi += Number(t.chi_phi) || 0;
    s.loi_nhuan += Number(t.loi_nhuan) || 0;
    s.tien_hoan += Number(t.tien_hoan) || 0;
    seen[t.khach_id || t.ten_khach] = 1;
  });
  s.so_khach = Object.keys(seen).length;
  return s;
}

function groupBy_(tx, field) {
  var g = {};
  tx.forEach(function (t) {
    var k = t[field] || '(trống)';
    if (!g[k]) g[k] = [];
    g[k].push(t);
  });
  return Object.keys(g).map(function (k) {
    var s = summarize_(g[k]);
    s.name = k;
    return s;
  }).sort(function (a, b) { return b.so_tien - a.so_tien; });
}

/* ------------------------------------------------------------------ */
/* Truy cập Sheet                                                      */
/* ------------------------------------------------------------------ */

var checkedSheets_ = {};

function sheet_(name) {
  var sh = SpreadsheetApp.getActive().getSheetByName(name);
  if (!sh && AUTO_SHEETS.indexOf(name) >= 0) {
    sh = SpreadsheetApp.getActive().insertSheet(name);
    sh.getRange(1, 1, 1, SHEETS[name].length).setValues([SHEETS[name]]);
    sh.setFrozenRows(1);
    SHEETS[name].forEach(function (h, i) {
      if (TEXT_COLUMNS.indexOf(h) >= 0) sh.getRange(2, i + 1, sh.getMaxRows() - 1, 1).setNumberFormat('@');
    });
  }
  if (!sh) throw new Error('Chưa có sheet "' + name + '". Hãy chạy hàm setup() một lần.');
  if (!checkedSheets_[name]) {
    checkedSheets_[name] = true;
    ensureColumns_(sh, SHEETS[name]);
  }
  return sh;
}

/** Bản cập nhật thêm cột mới vào cuối: tự ghi tiêu đề (và định dạng chữ) cho cột còn thiếu. */
function ensureColumns_(sh, headers) {
  var have = sh.getLastColumn();
  if (have >= headers.length) return;
  if (sh.getMaxColumns() < headers.length) sh.insertColumnsAfter(sh.getMaxColumns(), headers.length - sh.getMaxColumns());
  var missing = headers.slice(have);
  sh.getRange(1, have + 1, 1, missing.length).setValues([missing]);
  missing.forEach(function (h, i) {
    if (TEXT_COLUMNS.indexOf(h) >= 0) sh.getRange(2, have + i + 1, Math.max(sh.getMaxRows() - 1, 1), 1).setNumberFormat('@');
  });
}

function readAll_(name) {
  var sh = sheet_(name);
  var last = sh.getLastRow();
  if (last < 2) return [];
  var headers = SHEETS[name];
  return sh.getRange(2, 1, last - 1, headers.length).getValues().map(function (row) {
    var o = {};
    headers.forEach(function (h, i) {
      var v = row[i];
      if (v instanceof Date) v = Utilities.formatDate(v, TZ, DATE_COLUMNS.indexOf(h) >= 0 ? 'yyyy-MM-dd' : 'yyyy-MM-dd HH:mm');
      o[h] = v === null || v === undefined ? '' : v;
    });
    if (o.sdt !== undefined && o.sdt !== '') o.sdt = normalizePhone_(o.sdt);
    if (name === 'GiaoDich' && o.id !== '') fillRefund_(o);
    return o;
  }).filter(function (o) { return o[headers[0]] !== ''; });
}

/** Giao dịch nhập trước khi có cột tiền hoàn: tính lại từ số tiền và phí máy. */
function fillRefund_(t) {
  if (t.tien_hoan === '' && t.so_tien !== '') t.tien_hoan = (Number(t.so_tien) || 0) - (Number(t.chi_phi) || 0);
  if (!t.ngay_hoan && /^\d{4}-\d{2}-\d{2}$/.test(t.ngay)) t.ngay_hoan = addDays_(t.ngay, 1);
  t.hoan_tt = normRefundStatus_(t);
}

function appendObj_(name, obj) {
  var sh = sheet_(name);
  sh.appendRow(SHEETS[name].map(function (h) { return obj[h] === undefined ? '' : obj[h]; }));
}

function findRow_(name, id) {
  var sh = sheet_(name);
  var last = sh.getLastRow();
  if (last < 2) return -1;
  var ids = sh.getRange(2, 1, last - 1, 1).getValues();
  for (var i = 0; i < ids.length; i++) if (String(ids[i][0]) === String(id)) return i + 2;
  return -1;
}

function updateObj_(name, id, fields) {
  var r = findRow_(name, id);
  if (r < 0) throw new Error('Không tìm thấy bản ghi ' + id);
  writeFields_(name, r, fields);
}

function updateWhere_(name, pred, fields) {
  var sh = sheet_(name);
  var headers = SHEETS[name];
  var last = sh.getLastRow();
  if (last < 2) return 0;
  var rows = sh.getRange(2, 1, last - 1, headers.length).getValues();
  var n = 0;
  rows.forEach(function (row, i) {
    var o = {};
    headers.forEach(function (h, j) { o[h] = row[j]; });
    if (pred(o)) { writeFields_(name, i + 2, fields); n++; }
  });
  return n;
}

function writeFields_(name, rowIndex, fields) {
  var sh = sheet_(name);
  var headers = SHEETS[name];
  var range = sh.getRange(rowIndex, 1, 1, headers.length);
  var row = range.getValues()[0];
  headers.forEach(function (h, i) { if (fields[h] !== undefined) row[i] = fields[h]; });
  range.setValues([row]);
}

function deleteObj_(name, id) {
  var r = findRow_(name, id);
  if (r < 0) return false;
  sheet_(name).deleteRow(r);
  return true;
}

function withLock_(fn) {
  var lock = LockService.getScriptLock();
  lock.waitLock(20000);
  try { return fn(); } finally { lock.releaseLock(); }
}

function json_(obj) {
  return ContentService.createTextOutput(JSON.stringify(obj)).setMimeType(ContentService.MimeType.JSON);
}

/* ------------------------------------------------------------------ */
/* Tiện ích ngày / số                                                  */
/* ------------------------------------------------------------------ */

function todayStr_() { return Utilities.formatDate(new Date(), TZ, 'yyyy-MM-dd'); }
function nowStr_() { return Utilities.formatDate(new Date(), TZ, 'yyyy-MM-dd HH:mm'); }
// Tiền tố chữ để Sheets không hiểu nhầm id kiểu "12e345" thành số.
function newId_() { return 'k' + Utilities.getUuid().replace(/-/g, '').slice(0, 11); }
function pad2_(n) { return (n < 10 ? '0' : '') + n; }
function ymd_(y, m, d) { return y + '-' + pad2_(m) + '-' + pad2_(d); }
function parseYmd_(s) { var a = String(s).split('-'); return { y: +a[0], m: +a[1], d: +a[2] }; }
function utc_(s) { var p = parseYmd_(s); return Date.UTC(p.y, p.m - 1, p.d); }
function fromUtc_(ms) { var d = new Date(ms); return ymd_(d.getUTCFullYear(), d.getUTCMonth() + 1, d.getUTCDate()); }
function addDays_(s, n) { return fromUtc_(utc_(s) + n * 86400000); }
function diffDays_(a, b) { return Math.round((utc_(a) - utc_(b)) / 86400000); }
function daysInMonth_(y, m) { return new Date(Date.UTC(y, m, 0)).getUTCDate(); }
function addMonths_(y, m, n) { var t = y * 12 + (m - 1) + n; return { y: Math.floor(t / 12), m: (t % 12) + 1 }; }
function weekday_(s) { return (new Date(utc_(s)).getUTCDay() + 6) % 7; } // 0 = Thứ 2
function fmtDmy_(s) { var p = parseYmd_(s); return pad2_(p.d) + '/' + pad2_(p.m) + '/' + p.y; }
function fmtDm_(s) { var p = parseYmd_(s); return pad2_(p.d) + '/' + pad2_(p.m); }
function parseDateObj_(s) { var p = parseYmd_(s); return new Date(p.y, p.m - 1, p.d); }
function round2_(n) { return Math.round(n * 100) / 100; }
function fmtMoney_(n) { return String(Math.round(Number(n) || 0)).replace(/\B(?=(\d{3})+(?!\d))/g, '.') + 'đ'; }
function byDateDesc_(a, b) { return a.ngay < b.ngay ? 1 : a.ngay > b.ngay ? -1 : String(b.tao_luc).localeCompare(String(a.tao_luc)); }

function normalizePhone_(v) {
  var s = String(v === undefined || v === null ? '' : v).replace(/[^\d+]/g, '');
  if (s.indexOf('+84') === 0) s = '0' + s.slice(3);
  else if (s.indexOf('84') === 0 && s.length === 11) s = '0' + s.slice(2);
  else if (/^\d{9}$/.test(s)) s = '0' + s; // Sheets đã làm mất số 0 đầu
  return s;
}

function normName_(s) { return String(s || '').trim().toLowerCase().replace(/\s+/g, ' '); }

function parseNum_(s) { return Number(String(s || '').replace(',', '.').replace('%', '').trim()) || 0; }

/** "1.36+0.4" → 1.76 (phí máy cộng dồn nhiều khoản như trong sổ). */
function sumExpr_(s) {
  return round2_(String(s).replace(/[()%\s]/g, '').split('+').reduce(function (a, x) { return a + parseNum_(x); }, 0));
}

/** Số tiền như trong sổ: "8.999" = 8.999.000đ, "110tr" = 110.000.000đ, "500000" = 500.000đ. */
function parseAmount_(s) {
  var t = String(s || '').trim().toLowerCase();
  var m = t.match(/^([\d.,]+)\s*(tr|triệu|trieu|m)$/);
  if (m) return Math.round(Number(m[1].replace(',', '.')) * 1e6);
  var n = Number(t.replace(/[.,\s]/g, ''));
  if (!(n > 0)) return 0;
  return n < 100000 ? n * 1000 : n;
}

function parseService_(s) {
  var t = String(s || '').toLowerCase();
  var hasDao = /đh|dh|đáo|dao/.test(t), hasRut = /rút|rut/.test(t);
  if (/ví|vi tra|trả sau/.test(t)) return 'Ví trả sau';
  if (hasDao && hasRut) return 'Đáo + Rút';
  if (hasRut) return 'Rút tiền';
  return 'Đáo hạn';
}

/** "1/1", "03/01/2026", "2026-01-03" → yyyy-mm-dd. */
function parseDateLoose_(s, year) {
  var t = String(s || '').trim();
  if (/^\d{4}-\d{2}-\d{2}$/.test(t)) return t;
  var m = t.match(/^(\d{1,2})[\/.-](\d{1,2})(?:[\/.-](\d{2,4}))?$/);
  if (!m) throw new Error('Ngày "' + t + '" không đọc được');
  var y = m[3] ? (m[3].length === 2 ? 2000 + Number(m[3]) : Number(m[3])) : year;
  return ymd_(y, Number(m[2]), Number(m[1]));
}
