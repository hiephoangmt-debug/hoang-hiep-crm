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
 *   GiuThe    – lịch sử nhận giữ / trả thẻ của khách (ngày, ghi chú, ảnh lúc giao nhận)
 *   NhatKy    – lịch sử thêm / sửa / xóa giao dịch, tiền C.Trâm, chốt sổ (trước → sau)
 *   HoaDon    – ghép hoá đơn: người A có hoá đơn (điện, nước, MoMo, bảo hiểm…), người B dùng ví trả sau thanh toán,
 *               A chuyển lại cho mình (100% − phí A), mình chuyển cho B (100% − phí A − phí mình); doanh thu = chênh lệch.
 *
 * Công nợ với C.Trâm: mỗi giao dịch phát sinh tiền hoàn = số tiền − phí máy (tien_hoan = so_tien − chi_phi),
 *   đến hạn ngày GD + 1. Tiền C.Trâm chuyển/ứng (sheet DoiSoat) trừ dần vào các khoản cũ nhất trước.
 *   Số dư = tổng tiền hoàn − tổng đã chuyển/ứng: dương = C.Trâm còn phải chuyển, âm = C.Trâm đã ứng dư.
 */

var TZ = 'Asia/Ho_Chi_Minh';

var SHEETS = {
  KhachHang: ['id', 'ten', 'sdt', 'nguon', 'trang_thai', 'ghi_chu', 'tao_luc', 'cap_nhat', 'sdt2'],
  LienHe: ['id', 'thoi_gian', 'ten', 'sdt', 'dich_vu', 'ghi_chu', 'nguon', 'trang_thai', 'khach_id'],
  GiaoDich: ['id', 'ngay', 'dich_vu', 'the', 'ngay_dao', 'ngay_sao_ke', 'khach_id', 'ten_khach', 'sdt', 'so_tien',
    'may', 'phi_khach', 'phi_may', 'phi_may_text', 'tien_phi', 'chi_phi', 'loi_nhuan', 'ghi_chu', 'tao_luc',
    'tien_hoan', 'ngay_hoan', 'hoan_tt', 'hoan_luc'],
  NhacLich: ['key', 'han', 'trang_thai', 'ghi_chu', 'event_id', 'cap_nhat'],
  DoiSoat: ['id', 'ngay', 'loai', 'so_tien', 'ghi_chu', 'tao_luc'],
  TheKhach: ['id', 'khach_id', 'ten_the', 'ngan_hang', 'so_cuoi', 'han_muc', 'ngay_sao_ke', 'ngay_dao', 'ghi_chu', 'tao_luc', 'cap_nhat',
    'chu_the', 'quan_he', 'loai_the', 'giu_the', 'ngay_giu', 'ngay_tra'],
  GiuThe: ['id', 'the_id', 'khach_id', 'hanh_dong', 'ngay', 'ghi_chu', 'tao_luc'],
  HoaDon: ['id', 'ngay', 'loai_hd', 'ma_hd', 'so_tien', 'a_khach_id', 'a_ten', 'a_sdt', 'phi_a', 'b_khach_id', 'b_ten', 'b_sdt', 'vi_b',
    'phi_minh', 'a_chuyen', 'b_nhan', 'doanh_thu', 'b_tt_ngay', 'a_ck_ngay', 'b_ck_ngay', 'huy', 'ghi_chu', 'tao_luc', 'cap_nhat'],
  NhatKy: ['id', 'thoi_gian', 'doi_tuong', 'hanh_dong', 'ref_id', 'ngay', 'mo_ta', 'truoc', 'sau'],
  TaiLieu: ['id', 'khach_id', 'loai', 'the_id', 'file_id', 'ten_file', 'ghi_chu', 'tao_luc'],
  KetSo: ['id', 'ngay', 'tu_ngay', 'so_du_truoc', 'so_gd', 'so_tien', 'chi_phi', 'phat_sinh', 'da_chuyen', 'so_du', 'ghi_chu', 'tao_luc', 'nhap_tay']
};
// Sheet thêm ở bản cập nhật: tự tạo khi cần, không phải chạy lại setup().
var AUTO_SHEETS = ['DoiSoat', 'KetSo', 'TheKhach', 'TaiLieu', 'GiuThe', 'NhatKy', 'HoaDon'];
var BILL_TYPES = ['Hoá đơn điện', 'Hoá đơn nước', 'Nạp ví MoMo', 'Thanh toán bảo hiểm', 'Internet / truyền hình', 'Học phí', 'Khác'];
var PAYLATER_WALLETS = ['MoMo Ví Trả Sau', 'SPayLater (Shopee)', 'Kredivo', 'Home PayLater', 'Fundiin', 'ZaloPay trả sau', 'Khác'];
var DOC_TYPES = ['CCCD mặt trước', 'CCCD mặt sau', 'Ảnh thẻ', 'CCCD chủ thẻ', 'Ảnh giữ / trả thẻ', 'Khác'];
// Loại ảnh lưu nhiều tấm (không thay ảnh cũ).
var MULTI_DOC_TYPES = ['Khác', 'Ảnh giữ / trả thẻ'];
var CARD_BRANDS = ['Visa', 'MasterCard', 'JCB', 'Amex', 'Napas', 'UnionPay', 'Ví trả sau', 'Khác'];
var HOLD_ACTIONS = ['Nhận giữ', 'Trả thẻ'];
// Ảnh gắn với một thẻ cụ thể (mỗi thẻ 1 ảnh mỗi loại).
var CARD_DOC_TYPES = ['Ảnh thẻ', 'CCCD chủ thẻ', 'Ảnh giữ / trả thẻ'];
// Thẻ của chính khách hoặc của người thân / người quen khách mang đến làm.
var CARD_RELATIONS = ['Chính chủ', 'Vợ', 'Chồng', 'Bố', 'Mẹ', 'Con', 'Anh', 'Chị', 'Em', 'Người quen', 'Khác'];

// Cột lưu dạng chữ để Sheets không tự đổi ngày/số (mất số 0 đầu SĐT).
var TEXT_COLUMNS = ['id', 'sdt', 'ngay', 'thoi_gian', 'tao_luc', 'cap_nhat', 'key', 'han', 'khach_id', 'phi_may_text',
  'ngay_hoan', 'hoan_luc', 'tu_ngay', 'so_cuoi', 'file_id', 'the_id', 'sdt2', 'thoi_gian', 'ref_id',
  'ma_hd', 'a_sdt', 'b_sdt', 'a_khach_id', 'b_khach_id', 'b_tt_ngay', 'a_ck_ngay', 'b_ck_ngay'];
// Cột ngày dạng yyyy-MM-dd (nếu Sheets lỡ đổi thành Date thì đọc lại đúng dạng).
var DATE_COLUMNS = ['ngay', 'han', 'ngay_hoan', 'tu_ngay', 'b_tt_ngay', 'a_ck_ngay', 'b_ck_ngay'];
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
    listCustomers: apiListCustomers_,
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
    pasteNotes: apiPasteNotes_,
    refunds: apiRefunds_,
    savePayment: apiSavePayment_,
    deletePayment: apiDeletePayment_,
    previewClose: function (p) { return statementAt_(p.ngay); },
    periodSummary: apiPeriodSummary_,
    auditLog: apiAuditLog_,
    listBills: apiListBills_,
    saveBill: apiSaveBill_,
    deleteBill: apiDeleteBill_,
    congNoDetail: function (p) { return congNoDetail_(p.from, p.to); },
    exportCongNo: apiExportCongNo_,
    listCards: function (p) { return cardsOf_(p.khach_id); },
    holdCard: apiHoldCard_,
    heldCards: apiHeldCards_,
    cardHistory: apiCardHistory_,
    customerDocs: function (p) {
      var tx = readAll_('GiaoDich').filter(function (t) { return t.khach_id === p.khach_id; });
      return { cards: cardsOf_(p.khach_id), docs: readAll_('TaiLieu').filter(function (d) { return d.khach_id === p.khach_id; }),
        history: monthHistory_(tx, 24) };
    },
    saveCard: apiSaveCard_,
    deleteCard: apiDeleteCard_,
    uploadDoc: apiUploadDoc_,
    getDoc: apiGetDoc_,
    deleteDoc: apiDeleteDoc_,
    closeBalance: apiCloseBalance_,
    manualClosing: apiManualClosing_,
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
    cardBrands: CARD_BRANDS,
    billTypes: BILL_TYPES,
    paylaterWallets: PAYLATER_WALLETS,
    cards: distinct('the'),
    machines: distinct('may'),
    customers: readAll_('KhachHang').map(function (c) { return { id: c.id, ten: c.ten, sdt: c.sdt, sdt2: c.sdt2 || '' }; }),
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
  var held = readAll_('TheKhach').filter(function (c) { return c.giu_the === 'Mình giữ'; }).length;
  return {
    money: moneyOverview_(today),
    month: summarize_(tx),
    heldCards: held,
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

/**
 * Tiền theo kỳ cho trang Tổng quan: hôm nay, tuần này (từ thứ 2), tháng này (đến hôm nay),
 * kèm kỳ trước để so sánh (hôm qua, tuần trước cùng số ngày, tháng trước cùng kỳ) và 2 tháng trước trọn tháng.
 */
function moneyOverview_(today) {
  var all = readAll_('GiaoDich');
  var bills = readAll_('HoaDon').map(billCalc_).filter(function (b) { return b.trang_thai === 'Hoàn tất'; });
  function sum(from, to) {
    var s = summarize_(all.filter(function (t) { return t.ngay >= from && t.ngay <= to; }));
    s.from = from; s.to = to;
    var hb = bills.filter(function (b) { return b.ngay >= from && b.ngay <= to; });
    s.hd_so = hb.length;
    s.hd_tien = hb.reduce(function (a, b) { return a + b.so_tien; }, 0);
    s.hd_lai = hb.reduce(function (a, b) { return a + b.doanh_thu; }, 0);
    s.tong_lai = s.loi_nhuan + s.hd_lai;
    return s;
  }
  var p = parseYmd_(today);
  var wd = weekday_(today), weekFrom = addDays_(today, -wd);
  var monthFrom = ymd_(p.y, p.m, 1);
  var months = [0, 1, 2].map(function (k) {
    var m = addMonths_(p.y, p.m, -k);
    var from = ymd_(m.y, m.m, 1), end = ymd_(m.y, m.m, daysInMonth_(m.y, m.m));
    var s = sum(from, k === 0 ? today : end);
    s.thang = m.m; s.nam = m.y; s.den_hom_nay = k === 0;
    // cùng kỳ: từ ngày 1 đến cùng ngày trong tháng (để so công bằng với tháng đang chạy)
    if (k > 0) s.cung_ky = sum(from, ymd_(m.y, m.m, Math.min(p.d, daysInMonth_(m.y, m.m))));
    return s;
  });
  return {
    today: today,
    hom_nay: sum(today, today), hom_qua: sum(addDays_(today, -1), addDays_(today, -1)),
    tuan_nay: sum(weekFrom, today), tuan_truoc: sum(addDays_(weekFrom, -7), addDays_(today, -7)),
    thang_nay: months[0], thang_truoc: months[1], hai_thang_truoc: months[2]
  };
}

/** Danh sách khách kèm tình trạng giữ thẻ: thẻ mình đang giữ / thẻ khách giữ. */
function apiListCustomers_() {
  var byKhach = {}, lastLog = {}, photos = {};
  readAll_('GiuThe').forEach(function (l) { lastLog[l.the_id] = l; });
  readAll_('TaiLieu').forEach(function (d) { if (d.loai === 'Ảnh giữ / trả thẻ') (photos[d.ghi_chu] = photos[d.ghi_chu] || []).push(d.id); });
  readAll_('TheKhach').forEach(function (k) {
    var g = byKhach[k.khach_id] || (byKhach[k.khach_id] = { minh: [], khach: [] });
    var l = lastLog[k.id];
    var item = { the_id: k.id, ten_the: k.ten_the, ngay_giu: k.ngay_giu || '', ngay_tra: k.ngay_tra || '',
      ghi_chu: l ? l.ghi_chu : '', hanh_dong: l ? l.hanh_dong : '', anh: l ? (photos[l.id] || []) : [] };
    if (k.giu_the === 'Mình giữ') g.minh.push(item); else g.khach.push(item);
  });
  return readAll_('KhachHang').map(function (c) {
    var g = byKhach[c.id] || { minh: [], khach: [] };
    c.the_minh_giu = g.minh;
    c.the_khach_giu = g.khach;
    return c;
  });
}

function apiSaveCustomer_(c) {
  return withLock_(function () {
    var now = nowStr_();
    var fields = {
      ten: String(c.ten || '').trim(), sdt: normalizePhone_(c.sdt), sdt2: normalizePhone_(c.sdt2), nguon: String(c.nguon || 'Nhập tay'),
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
  return { driveReady: driveReady_(), driveHelp: DRIVE_HELP, customer: c, transactions: tx, leads: leads, summary: summarize_(tx), cards: cardsOf_(p.id), docs: docs,
    history: monthHistory_(tx, 24) };
}

/**
 * Mốc thời gian theo tháng của một khách (n tháng gần nhất, kể cả tháng chưa làm): mỗi tháng số lần, tổng rút / đáo,
 * từng giao dịch (ngày, thẻ, dịch vụ, số tiền). Kèm lần làm gần nhất (kể cả cũ hơn n tháng).
 */
function monthHistory_(tx, n) {
  var p = parseYmd_(todayStr_());
  var months = [];
  for (var k = 0; k < n; k++) {
    var m = addMonths_(p.y, p.m, -k);
    var from = ymd_(m.y, m.m, 1), to = ymd_(m.y, m.m, daysInMonth_(m.y, m.m));
    var items = tx.filter(function (t) { return t.ngay >= from && t.ngay <= to; }).sort(function (a, b) { return a.ngay < b.ngay ? -1 : 1; });
    var s = summarize_(items);
    months.push({ thang: m.m, nam: m.y, so_gd: s.so_gd, so_tien: s.so_tien, loi_nhuan: s.loi_nhuan,
      rut: items.filter(function (t) { return t.dich_vu !== 'Đáo hạn'; }).reduce(function (a, t) { return a + (Number(t.so_tien) || 0); }, 0),
      dao: items.filter(function (t) { return t.dich_vu === 'Đáo hạn'; }).reduce(function (a, t) { return a + (Number(t.so_tien) || 0); }, 0),
      items: items.map(function (t) { return { id: t.id, ngay: t.ngay, the: t.the, dich_vu: t.dich_vu, so_tien: t.so_tien }; }) });
  }
  var last = tx.slice().sort(byDateDesc_)[0];
  return { months: months, lan_cuoi: last ? { ngay: last.ngay, the: last.the, dich_vu: last.dich_vu, so_tien: last.so_tien } : null, tong_gd: tx.length };
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
      if (t.vao_so === true) obj.hoan_tt = 'Chưa nhận';
      else if (t.vao_so === false) obj.hoan_tt = 'Đã nhận';
      updateObj_('GiaoDich', t.id, obj);
      audit_('Giao dịch', 'Sửa', obj.id, obj.ngay, txText_(obj), old ? txText_(old) : '', txText_(obj));
    } else {
      obj.id = newId_();
      obj.tao_luc = nowStr_();
      obj.hoan_tt = t.vao_so === false ? 'Đã nhận' : 'Chưa nhận';
      appendObj_('GiaoDich', obj);
      audit_('Giao dịch', 'Thêm', obj.id, obj.ngay, txText_(obj), '', txText_(obj));
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
  if (!hit && q.sdt) hit = all.filter(function (c) { return c.sdt === q.sdt || (c.sdt2 && c.sdt2 === q.sdt); })[0];
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
    var ok = deleteObj_('GiaoDich', p.id);
    if (ok && old) audit_('Giao dịch', 'Xóa', old.id, old.ngay, txText_(old), txText_(old), '');
    return ok;
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

/**
 * Dán sổ ghi chú hằng ngày (viết tay trên điện thoại), ví dụ:
 *   2/10: Hoàn 274.806 lãi 1.653
 *   Rút VP a Đức Thắng FPT 13.068/1.9 hoàn 1.6 RR      → Rút tiền · thẻ VP · khách · 13.068.000đ · phí khách 1.9% · phí máy 1.6%
 *   Rút QR FE Hưng SB 2.980/100k hoàn 1.5 RR            → phí khách cố định 100k
 *   (Rút SC Hiếu Đinh HN 1.975.061/5.0 hoàn 2.0 điện Thuỷ lãi 60k RR) → hoá đơn điện của Thuỷ, B = Hiếu Đinh trả bằng ví SC
 *   Hoàn 400 còn 57.053                                  → C.Trâm chuyển 400tr
 * Số trong sổ tính theo nghìn đồng ("13.068" = 13.068.000đ); riêng "Hoàn 400" (không có dấu chấm) = 400 triệu.
 * save = false: chỉ xem trước. save = true: lưu (bỏ qua dòng đã có trong app).
 */
var NOTE_CARD_EXTRA = /^(jcb|visa|master|mastercard|mc|vàng|vang|plat|platinum|signature|bạch|kim|infinite|world)$/i;
var NOTE_BILL_WORD = /(?:^|\s)(điện|nước|bảo hiểm|internet|học phí|momo|hđ|hoá đơn|hóa đơn)\s+(.+?)\s+lãi\b/i;

function noteMoney_(s) { return Math.round(parseNum_(String(s).replace(/\./g, '').replace(',', '.'))); }
function noteThousand_(s) { // "274.806" → 274.806.000; "1.406k" → 1.406.000; "60k" → 60.000
  var t = String(s || '').toLowerCase().replace(/\s/g, '');
  if (/tr$|triệu$/.test(t)) return parseAmount_(t);
  return noteMoney_(t.replace(/k$/, '')) * 1000;
}

function parseNoteLine_(line, ngay) {
  var inner = line.replace(/^\((.*)\)$/, '$1').trim();
  var pm = inner.match(/^(hoàn|ứng|chuyển|ck)\s+([\d.,]+)\s*(tỷ|ty|tr|triệu|k)?\b\.?\s*(?:,?\s*còn(?:\s+hoàn)?\s+([\d.,]+)\s*(?:k|tr)?)?/i);
  if (pm && !/\//.test(inner)) {
    var raw = pm[2].replace(/[.,]+$/, ''), unit = (pm[3] || '').toLowerCase(), amt;
    if (unit === 'tỷ' || unit === 'ty') amt = Math.round(parseNum_(raw.replace(',', '.')) * 1e9);
    else if (unit === 'tr' || unit === 'triệu') amt = Math.round(parseNum_(raw.replace(',', '.')) * 1e6);
    else if (unit === 'k') amt = noteMoney_(raw) * 1000;
    else amt = /[.,]/.test(raw) ? noteMoney_(raw) * 1000 : noteMoney_(raw) * 1e6; // "Hoàn 400" = 400tr
    return { kind: 'pay', ngay: ngay, loai: /^ứng/i.test(pm[1]) ? 'Ứng trước' : 'Hoàn tiền', so_tien: amt,
      con: pm[4] ? noteThousand_(pm[4]) : null, ghi_chu: 'Dán sổ: ' + line };
  }
  var m = inner.match(/^(đh\s*\/\s*rút|đh\s*\+\s*rút|đáo\s*\/\s*rút|đh|đáo hạn|đáo|rút)(\s+qr)?\s+(.+?)\s+([\d.,]+\s*(?:tr|triệu)?)\s*\/\s*([\d.,]+)\s*(k)?\s+hoàn\s+([\d.,+]+)(.*)$/i);
  if (!m) {
    var lai = inner.match(/lãi\s+([\d.,]+\s*k?)/i);
    return { kind: 'skip', lai: lai ? noteThousand_(lai[1]) : 0 };
  }
  var tokens = m[3].split(' '), the = [tokens.shift()];
  while (tokens.length > 1 && NOTE_CARD_EXTRA.test(tokens[0])) the.push(tokens.shift());
  var ten = tokens.join(' ') || the.join(' ');
  var amt2 = /tr|triệu/i.test(m[4]) ? parseAmount_(m[4].replace(/\s/g, '')) : (m[4].split('.').length > 2 ? noteMoney_(m[4]) : parseAmount_(m[4]));
  var feeN = parseNum_(m[5].replace(',', '.')), fixed = !!m[6] || feeN >= 10;
  var phiMay = sumExpr_(m[7]);
  var rest = m[8].trim();
  var o = { ngay: ngay, so_tien: amt2, phi_may_text: String(phiMay), the: the.join(' '), ten_khach: ten,
    dich_vu: parseService_(m[1]), lai_so: 0 };
  if (!(amt2 > 0)) return { kind: 'skip', lai: 0 };
  if (fixed) o.phi_khach = feeN * 1000 / amt2 * 100;
  else o.phi_khach = feeN;
  var bill = rest.match(NOTE_BILL_WORD);
  if (bill && !fixed) {
    var w = bill[1].toLowerCase();
    var loai = w === 'điện' ? 'Hoá đơn điện' : w === 'nước' ? 'Hoá đơn nước' : w === 'bảo hiểm' ? 'Thanh toán bảo hiểm'
      : w === 'internet' ? 'Internet / truyền hình' : w === 'học phí' ? 'Học phí' : w === 'momo' ? 'Nạp ví MoMo' : 'Khác';
    return { kind: 'bill', ngay: ngay, loai_hd: loai, so_tien: amt2, a_ten: bill[2].trim(), phi_a: phiMay,
      phi_minh: round2_(feeN - phiMay), b_ten: ten, vi_b: o.the, done: /\bR+\b/.test(rest), ghi_chu: 'Dán sổ: ' + line };
  }
  var notes = [];
  if (m[2]) notes.push('QR');
  if (fixed) notes.push('phí ' + feeN + 'k');
  var thu = rest.match(/phí\s+([\d.,]+)\s*k?/i);
  if (thu) { notes.push('thu phí ' + thu[1] + 'k'); rest = rest.replace(thu[0], ''); }
  rest = rest.trim();
  if (rest) notes.push(rest);
  o.ghi_chu = notes.join(' · ');
  o.kind = 'tx';
  return o;
}

function apiPasteNotes_(p) {
  var year = Number(p.year) || parseYmd_(todayStr_()).y;
  var lines = String(p.text || '').split(/\r?\n/);
  var cur = '', days = {}, order = [], items = [];
  var allTx = readAll_('GiaoDich'), allPay = readAll_('DoiSoat'), allBill = readAll_('HoaDon');
  function day(d) { if (!days[d]) { days[d] = { ngay: d, hoan_so: null, lai_so: null, hoan: 0, lai: 0, so_gd: 0, tra: 0, con_so: null }; order.push(d); } return days[d]; }
  lines.forEach(function (raw, i) {
    var line = raw.replace(/\s+/g, ' ').trim();
    if (!line) return;
    var h = line.match(/^(\d{1,2}[\/.-]\d{1,2}(?:[\/.-]\d{2,4})?)\s*:\s*(.*)$/);
    if (h) {
      try { cur = parseDateLoose_(h[1], year); } catch (e) { items.push({ dong: i + 1, line: line, kind: 'err', loi: e.message }); return; }
      var d = day(cur), hh = h[2].match(/hoàn\s+([\d.,]+\s*k?)/i), ll = h[2].match(/lãi\s+([\d.,]+\s*k?)/i);
      if (hh) d.hoan_so = noteThousand_(hh[1]);
      if (ll) d.lai_so = noteThousand_(ll[1]);
      return;
    }
    if (!cur) { items.push({ dong: i + 1, line: line, kind: 'err', loi: 'Chưa có dòng ngày (VD "2/10:") ở phía trên' }); return; }
    var it = parseNoteLine_(line, cur);
    it.dong = i + 1; it.line = line;
    var d2 = day(cur);
    if (it.kind === 'tx') {
      var chi = Math.round(it.so_tien * Number(it.phi_may_text) / 100), phi = Math.round(it.so_tien * it.phi_khach / 100);
      it.tien_hoan = it.so_tien - chi; it.lai = phi - chi;
      d2.hoan += it.tien_hoan; d2.lai += it.lai; d2.so_gd++;
      it.da_co = allTx.some(function (t) { return t.ngay === cur && Number(t.so_tien) === it.so_tien && normName_(t.the) === normName_(it.the); });
    } else if (it.kind === 'bill') {
      var b = billCalc_({ so_tien: it.so_tien, phi_a: it.phi_a, phi_minh: it.phi_minh });
      it.lai = b.doanh_thu; d2.lai += it.lai;
      it.da_co = allBill.some(function (x) { return x.ngay === cur && Number(x.so_tien) === it.so_tien; });
    } else if (it.kind === 'pay') {
      d2.tra += it.so_tien; if (it.con != null) d2.con_so = it.con;
      it.da_co = allPay.some(function (x) { return x.ngay === cur && x.loai === it.loai && Number(x.so_tien) === it.so_tien; });
    } else {
      d2.lai += it.lai || 0;
      it.loi = it.lai ? 'Chưa đọc được – lãi ' + fmtMoney_(it.lai) + ' đã cộng vào ô kiểm tra lãi; thêm tay nếu cần' : 'Chưa đọc được dòng này – thêm tay';
    }
    items.push(it);
  });
  var saved = { tx: 0, pay: 0, bill: 0, bo_qua: 0 };
  if (p.save) {
    items.forEach(function (it) {
      if (['tx', 'pay', 'bill'].indexOf(it.kind) < 0) return;
      if (it.da_co) { saved.bo_qua++; return; }
      try {
        if (it.kind === 'tx') {
          apiSaveTransaction_({ ngay: it.ngay, dich_vu: it.dich_vu, the: it.the, ten_khach: it.ten_khach, so_tien: it.so_tien,
            phi_khach: it.phi_khach, phi_may_text: it.phi_may_text, ghi_chu: it.ghi_chu, vao_so: true });
          saved.tx++;
        } else if (it.kind === 'pay') {
          apiSavePayment_({ ngay: it.ngay, loai: it.loai, so_tien: it.so_tien, ghi_chu: it.ghi_chu });
          saved.pay++;
        } else {
          apiSaveBill_({ ngay: it.ngay, loai_hd: it.loai_hd, so_tien: it.so_tien, a_ten: it.a_ten, phi_a: it.phi_a, phi_minh: it.phi_minh,
            b_ten: it.b_ten, vi_b: it.vi_b, b_tt_ngay: it.done ? it.ngay : '', a_ck_ngay: it.done ? it.ngay : '', b_ck_ngay: it.done ? it.ngay : '',
            ghi_chu: it.ghi_chu });
          saved.bill++;
        }
        it.da_luu = true;
      } catch (e) { it.loi = e.message || String(e); }
    });
  }
  return { days: order.map(function (d) { return days[d]; }), items: items, saved: p.save ? saved : null };
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
  // Sổ tính từ lần chốt gần nhất: tồn lúc chốt + những gì phát sinh sau ngày chốt.
  var closings = closings_();
  var last = closings.length ? closings[closings.length - 1] : null;
  var cut = last ? last.ngay : '', opening = last ? Number(last.so_du) || 0 : 0;
  var dues = readAll_('GiaoDich').filter(function (t) { return t.hoan_tt !== 'Đã nhận' && Number(t.tien_hoan) && t.ngay > cut; })
    .sort(function (a, b) { return a.ngay_hoan < b.ngay_hoan ? -1 : a.ngay_hoan > b.ngay_hoan ? 1 : a.ngay < b.ngay ? -1 : a.ngay > b.ngay ? 1 : String(a.tao_luc).localeCompare(String(b.tao_luc)); });
  var pays = readAll_('DoiSoat').filter(function (x) { return x.ngay > cut; }).map(function (x) { x.tien = paymentSign_(x); return x; })
    .sort(function (a, b) { return a.ngay < b.ngay ? -1 : a.ngay > b.ngay ? 1 : String(a.tao_luc).localeCompare(String(b.tao_luc)); });
  var paid = pays.reduce(function (a, x) { return a + x.tien; }, 0);
  var credit = paid + Math.max(0, -opening); // tồn chốt âm (chị ứng dư) cũng dùng để trừ dần

  // Phân bổ tiền đã chuyển vào từng giao dịch, cũ trước (tồn chốt dương là khoản cũ nhất).
  var left = credit, days = {};
  if (opening > 0) {
    dues.unshift({ id: '', ngay: cut, ngay_hoan: cut, dich_vu: 'Công nợ chốt', the: '', ten_khach: 'Tồn chốt ngày ' + fmtDmy_(cut),
      so_tien: opening, chi_phi: 0, phi_may: 0, tien_hoan: opening, la_ton_chot: true });
  }
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
    tong_phai_hoan: tong, tong_da_chuyen: credit, so_du: tong - credit,
    den_han: denHan, den_han_con_thieu: Math.max(0, denHan - credit),
    sap_toi: tong - denHan, // giao dịch hôm nay, hoàn ngày mai
    ung_du: Math.max(0, credit - tong)
  };

  // Sổ đối chiếu theo ngày giao dịch / ngày chuyển tiền, số dư lũy kế.
  var from = p.from || '', to = p.to || '9999-12-31';
  var book = {};
  function row(d) { return book[d] || (book[d] = { ngay: d, so_gd: 0, so_tien: 0, chi_phi: 0, phat_sinh: 0, da_chuyen: 0, payments: [] }); }
  if (last) row(cut);
  dues.forEach(function (t) {
    if (t.la_ton_chot) return;
    var r = row(t.ngay);
    r.so_gd++; r.so_tien += Number(t.so_tien) || 0; r.chi_phi += Number(t.chi_phi) || 0; r.phat_sinh += Number(t.tien_hoan) || 0;
  });
  pays.forEach(function (x) {
    var r = row(x.ngay);
    r.da_chuyen += x.tien;
    r.payments.push({ id: x.id, ngay: x.ngay, loai: x.loai, so_tien: Number(x.so_tien) || 0, tien: x.tien, ghi_chu: x.ghi_chu });
  });
  var bal = 0;
  var ledger = Object.keys(book).sort().map(function (k) {
    var r = book[k];
    if (k === cut) bal = opening;
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
    congNo: congNo_(last),
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
      updateObj_('DoiSoat', x.id, obj); obj.id = x.id;
      audit_('Tiền ' + refundName_(), 'Sửa', obj.id, obj.ngay, payText_(obj), old ? payText_(old) : '', payText_(obj));
      return obj;
    }
    obj.id = newId_();
    obj.tao_luc = nowStr_();
    appendObj_('DoiSoat', obj);
    audit_('Tiền ' + refundName_(), 'Thêm', obj.id, obj.ngay, payText_(obj), '', payText_(obj));
    return obj;
  });
}

function apiDeletePayment_(p) {
  return withLock_(function () {
    var old = readAll_('DoiSoat').filter(function (y) { return y.id === p.id; })[0];
    if (old) assertOpen_(old.ngay);
    var ok = deleteObj_('DoiSoat', p.id);
    if (ok && old) audit_('Tiền ' + refundName_(), 'Xóa', old.id, old.ngay, payText_(old), payText_(old), '');
    return ok;
  });
}

/* Thẻ của khách & ảnh CCCD / thẻ ------------------------------------- */

/** Số liệu giao dịch theo từng thẻ: số lần, tổng rút / đáo, lần gần nhất. */
function cardStats_(cards, tx) {
  var key = {};
  cards.forEach(function (c) { key[c.khach_id + '|' + normName_(c.ten_the)] = c; c.so_gd = 0; c.tong_rut = 0; c.tong_dao = 0; c.lan_cuoi = null; });
  tx.forEach(function (t) {
    var c = key[t.khach_id + '|' + normName_(t.the)];
    if (!c) return;
    var amt = Number(t.so_tien) || 0;
    c.so_gd++;
    if (t.dich_vu === 'Đáo hạn') c.tong_dao += amt; else c.tong_rut += amt;
    if (!c.lan_cuoi || t.ngay >= c.lan_cuoi.ngay) c.lan_cuoi = { ngay: t.ngay, so_tien: amt, dich_vu: t.dich_vu };
  });
  return cards;
}

function cardsOf_(khachId) {
  var docs = readAll_('TaiLieu');
  var lastLog = {};
  readAll_('GiuThe').forEach(function (l) { if (l.khach_id === khachId) lastLog[l.the_id] = l; });
  var tx = readAll_('GiaoDich').filter(function (t) { return t.khach_id === khachId; });
  return cardStats_(readAll_('TheKhach').filter(function (c) { return c.khach_id === khachId; }), tx).map(function (c) {
    var photo = docs.filter(function (d) { return d.the_id === c.id && d.loai === 'Ảnh thẻ'; }).pop();
    var cccd = docs.filter(function (d) { return d.the_id === c.id && d.loai === 'CCCD chủ thẻ'; }).pop();
    c.anh_id = photo ? photo.id : '';
    c.cccd_id = cccd ? cccd.id : '';
    c.quan_he = c.quan_he || 'Chính chủ';
    c.giu_the = c.giu_the || 'Khách giữ';
    var l = lastLog[c.id];
    c.hold_action = l ? l.hanh_dong : ''; c.hold_ngay = l ? l.ngay : ''; c.hold_note = l ? l.ghi_chu : '';
    c.hold_anh = l ? docs.filter(function (d) { return d.loai === 'Ảnh giữ / trả thẻ' && d.ghi_chu === l.id; }).map(function (d) { return d.id; }) : [];
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
    chu_the: String(c.chu_the || '').trim(), quan_he: CARD_RELATIONS.indexOf(c.quan_he) >= 0 ? c.quan_he : 'Chính chủ',
    loai_the: CARD_BRANDS.indexOf(c.loai_the) >= 0 ? c.loai_the : '' };
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

/* Giữ thẻ của khách ------------------------------------------------- */

/** Ghi nhận mình nhận giữ thẻ / trả thẻ cho khách. Trả về dòng lịch sử (dùng id để gắn ảnh lúc giao nhận). */
function apiHoldCard_(p) {
  var hd = HOLD_ACTIONS.indexOf(p.hanh_dong) >= 0 ? p.hanh_dong : '';
  if (!hd) throw new Error('Chọn Nhận giữ hoặc Trả thẻ.');
  var ngay = String(p.ngay || todayStr_());
  if (!/^\d{4}-\d{2}-\d{2}$/.test(ngay)) throw new Error('Ngày không hợp lệ.');
  return withLock_(function () {
    var c = readAll_('TheKhach').filter(function (x) { return x.id === p.the_id; })[0];
    if (!c) throw new Error('Không tìm thấy thẻ.');
    var log = { id: newId_(), the_id: c.id, khach_id: c.khach_id, hanh_dong: hd, ngay: ngay, ghi_chu: String(p.ghi_chu || '').trim(), tao_luc: nowStr_() };
    appendObj_('GiuThe', log);
    var upd = hd === 'Nhận giữ' ? { giu_the: 'Mình giữ', ngay_giu: ngay, ngay_tra: '' } : { giu_the: 'Khách giữ', ngay_tra: ngay };
    upd.cap_nhat = nowStr_();
    updateObj_('TheKhach', c.id, upd);
    return log;
  });
}

function apiCardHistory_(p) {
  var docs = readAll_('TaiLieu').filter(function (d) { return d.the_id === p.the_id && d.loai === 'Ảnh giữ / trả thẻ'; });
  var tx = readAll_('GiaoDich');
  var card = readAll_('TheKhach').filter(function (c) { return c.id === p.the_id; })[0];
  return {
    logs: readAll_('GiuThe').filter(function (l) { return l.the_id === p.the_id; }).map(function (l) {
      l.anh = docs.filter(function (d) { return d.ghi_chu === l.id; }).map(function (d) { return d.id; });
      return l;
    }).reverse(),
    giao_dich: card ? tx.filter(function (t) { return t.khach_id === card.khach_id && normName_(t.the) === normName_(card.ten_the); })
      .sort(byDateDesc_).map(function (t) { return { ngay: t.ngay, dich_vu: t.dich_vu, so_tien: t.so_tien, may: t.may }; }) : []
  };
}

/** Danh sách thẻ mình đang giữ (hoặc khách giữ / tất cả), kèm khách, hạn mức, tổng rút, lần rút gần nhất. */
function apiHeldCards_(p) {
  var mode = p.mode || 'Mình giữ';
  var customers = {};
  readAll_('KhachHang').forEach(function (c) { customers[c.id] = c; });
  var docs = readAll_('TaiLieu');
  var cards = readAll_('TheKhach').map(function (c) { c.giu_the = c.giu_the || 'Khách giữ'; return c; })
    .filter(function (c) { return mode === 'all' || c.giu_the === mode; });
  cardStats_(cards, readAll_('GiaoDich'));
  var today = todayStr_();
  return cards.map(function (c) {
    var k = customers[c.khach_id] || {};
    c.ten_khach = k.ten || ''; c.sdt = k.sdt || '';
    c.so_ngay_giu = c.giu_the === 'Mình giữ' && c.ngay_giu ? diffDays_(today, c.ngay_giu) : '';
    var photo = docs.filter(function (d) { return d.the_id === c.id && d.loai === 'Ảnh thẻ'; }).pop();
    c.anh_id = photo ? photo.id : '';
    c.quan_he = c.quan_he || 'Chính chủ';
    return c;
  }).sort(function (a, b) { return String(a.ngay_giu || '9').localeCompare(String(b.ngay_giu || '9')) || String(a.ten_khach).localeCompare(String(b.ten_khach)); });
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
      return d.khach_id === khach.id && d.loai === loai && MULTI_DOC_TYPES.indexOf(loai) < 0 && (CARD_DOC_TYPES.indexOf(loai) < 0 || d.the_id === p.the_id);
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

/* Ghép hoá đơn – ví trả sau ------------------------------------------- */

/** Tính tiền và trạng thái của một lần ghép hoá đơn. */
function billCalc_(b) {
  var amt = Number(b.so_tien) || 0, pa = Number(b.phi_a) || 0, pm = Number(b.phi_minh) || 0;
  b.so_tien = amt; b.phi_a = pa; b.phi_minh = pm;
  b.a_chuyen = Math.round(amt * (100 - pa) / 100);          // A chuyển lại cho mình
  b.b_nhan = Math.round(amt * (100 - pa - pm) / 100);       // mình chuyển cho B
  b.doanh_thu = b.a_chuyen - b.b_nhan;                      // phí của mình
  b.giam_a = amt - b.a_chuyen;                              // A được giảm
  b.phi_b = amt - b.b_nhan;                                 // B chịu tổng phí
  b.trang_thai = b.huy ? 'Huỷ' : !b.b_ten ? 'Chờ ghép' : !b.b_tt_ngay ? 'Chờ B thanh toán'
    : (b.a_ck_ngay && b.b_ck_ngay) ? 'Hoàn tất' : 'Chờ đối soát';
  return b;
}

function apiListBills_(p) {
  p = p || {};
  var rows = readAll_('HoaDon').map(billCalc_);
  var mode = p.mode || 'open';
  rows = rows.filter(function (b) {
    if (mode === 'open') return b.trang_thai !== 'Hoàn tất' && b.trang_thai !== 'Huỷ';
    if (mode === 'done') return b.trang_thai === 'Hoàn tất' && (!p.from || b.ngay >= p.from) && (!p.to || b.ngay <= p.to);
    if (mode === 'wait') return b.trang_thai === 'Chờ ghép';
    return (!p.from || b.ngay >= p.from) && (!p.to || b.ngay <= p.to);
  }).sort(function (a, b) { return a.ngay < b.ngay ? 1 : a.ngay > b.ngay ? -1 : String(b.tao_luc).localeCompare(String(a.tao_luc)); });
  var all = readAll_('HoaDon').map(billCalc_);
  var t = parseYmd_(todayStr_()), mFrom = ymd_(t.y, t.m, 1);
  function agg(list) { return { so: list.length, tien: list.reduce(function (a, b) { return a + b.so_tien; }, 0), lai: list.reduce(function (a, b) { return a + b.doanh_thu; }, 0) }; }
  return {
    rows: rows,
    stats: {
      cho_ghep: agg(all.filter(function (b) { return b.trang_thai === 'Chờ ghép'; })),
      dang_xu_ly: agg(all.filter(function (b) { return b.trang_thai === 'Chờ B thanh toán' || b.trang_thai === 'Chờ đối soát'; })),
      thang_nay: agg(all.filter(function (b) { return b.trang_thai === 'Hoàn tất' && b.ngay >= mFrom; }))
    }
  };
}

function billText_(b) {
  return fmtDmy_(b.ngay) + ' · ' + b.loai_hd + (b.ma_hd ? ' ' + b.ma_hd : '') + ' · ' + fmtMoney_(b.so_tien) + ' · A: ' + b.a_ten + ' (' + b.phi_a + '%)' +
    (b.b_ten ? ' · B: ' + b.b_ten + (b.vi_b ? ' – ' + b.vi_b : '') : '') + ' · mình ' + b.phi_minh + '% = ' + fmtMoney_(b.doanh_thu) + ' · ' + b.trang_thai;
}

function apiSaveBill_(x) {
  var ngay = String(x.ngay || '');
  if (!/^\d{4}-\d{2}-\d{2}$/.test(ngay)) throw new Error('Ngày không hợp lệ.');
  var amt = Number(x.so_tien);
  if (!(amt > 0)) throw new Error('Số tiền hoá đơn phải lớn hơn 0.');
  var pa = Number(x.phi_a) || 0, pm = Number(x.phi_minh) || 0;
  if (pa < 0 || pm < 0 || pa + pm >= 100) throw new Error('Phí không hợp lệ.');
  if (!String(x.a_ten || '').trim()) throw new Error('Nhập người có hoá đơn (A).');
  function okDate(v) { v = String(v || ''); return /^\d{4}-\d{2}-\d{2}$/.test(v) ? v : ''; }
  return withLock_(function () {
    var a = resolveCustomer_({ khach_id: x.a_khach_id, ten_khach: x.a_ten, sdt: x.a_sdt });
    var hasB = String(x.b_ten || '').trim() || String(x.b_sdt || '').trim();
    var b = hasB ? resolveCustomer_({ khach_id: x.b_khach_id, ten_khach: x.b_ten || x.b_sdt, sdt: x.b_sdt }) : null;
    var obj = {
      ngay: ngay, loai_hd: BILL_TYPES.indexOf(x.loai_hd) >= 0 ? x.loai_hd : (String(x.loai_hd || '').trim() || 'Khác'), ma_hd: String(x.ma_hd || '').trim(),
      so_tien: amt, a_khach_id: a.id, a_ten: a.ten, a_sdt: a.sdt || '', phi_a: pa,
      b_khach_id: b ? b.id : '', b_ten: b ? b.ten : '', b_sdt: b ? (b.sdt || '') : '', vi_b: b ? String(x.vi_b || '').trim() : '',
      phi_minh: pm, b_tt_ngay: b ? okDate(x.b_tt_ngay) : '', a_ck_ngay: okDate(x.a_ck_ngay), b_ck_ngay: b ? okDate(x.b_ck_ngay) : '',
      huy: x.huy ? 'x' : '', ghi_chu: String(x.ghi_chu || '').trim(), cap_nhat: nowStr_()
    };
    billCalc_(obj);
    if (x.id) {
      var old = readAll_('HoaDon').filter(function (r) { return r.id === x.id; })[0];
      updateObj_('HoaDon', x.id, obj); obj.id = x.id;
      audit_('Hoá đơn', 'Sửa', obj.id, ngay, billText_(obj), old ? billText_(billCalc_(old)) : '', billText_(obj));
    } else {
      obj.id = newId_(); obj.tao_luc = obj.cap_nhat;
      appendObj_('HoaDon', obj);
      audit_('Hoá đơn', 'Thêm', obj.id, ngay, billText_(obj), '', billText_(obj));
    }
    return obj;
  });
}

function apiDeleteBill_(p) {
  return withLock_(function () {
    var old = readAll_('HoaDon').filter(function (r) { return r.id === p.id; })[0];
    var ok = deleteObj_('HoaDon', p.id);
    if (ok && old) audit_('Hoá đơn', 'Xóa', old.id, old.ngay, billText_(billCalc_(old)), billText_(old), '');
    return ok;
  });
}

/* Nhật ký thay đổi, bảng chi tiết công nợ ------------------------------ */

function audit_(doiTuong, hanhDong, refId, ngay, moTa, truoc, sau) {
  try {
    appendObj_('NhatKy', { id: newId_(), thoi_gian: nowStr_(), doi_tuong: doiTuong, hanh_dong: hanhDong, ref_id: refId || '',
      ngay: ngay || '', mo_ta: String(moTa || '').slice(0, 500), truoc: String(truoc || '').slice(0, 500), sau: String(sau || '').slice(0, 500) });
  } catch (e) { /* không để nhật ký làm hỏng thao tác chính */ }
}
function txText_(t) {
  return fmtDmy_(t.ngay) + ' · ' + (t.ten_khach || '') + ' · ' + (t.the || '') + ' · ' + (t.dich_vu || '') + ' · ' + fmtMoney_(t.so_tien) +
    ' · phí máy ' + (t.phi_may_text || t.phi_may || 0) + '% · hoàn ' + fmtMoney_(t.tien_hoan) + (t.hoan_tt === 'Đã nhận' ? ' (ngoài sổ)' : '') + (t.may ? ' · máy ' + t.may : '');
}
function payText_(x) {
  return fmtDmy_(x.ngay) + ' · ' + x.loai + ' ' + fmtMoney_(Math.abs(Number(x.so_tien) || 0)) + (x.ghi_chu ? ' · ' + x.ghi_chu : '');
}

function apiAuditLog_(p) {
  var from = p.from || '', to = p.to || '9999-12-31';
  return readAll_('NhatKy').filter(function (r) {
    var d = String(r.thoi_gian).slice(0, 10);
    return d >= from && d <= to && (!p.doi_tuong || String(r.doi_tuong).indexOf(p.doi_tuong) === 0);
  }).reverse().slice(0, Number(p.limit) || 500);
}

/**
 * Bảng chi tiết công nợ C.Trâm kiểu Excel: số dư đầu kỳ, rồi từng dòng theo ngày
 * (tiền ứng / chuyển trước, giao dịch sau), số dư lũy kế sau mỗi dòng; dòng chốt sổ nếu có.
 */
function congNoDetail_(from, to) {
  from = String(from || ''); to = String(to || '9999-12-31');
  var st = periodStatement_(from || '0000-00-00', to);
  var rows = [{ ngay: from || '', loai: 'Số dư đầu kỳ', khach: '', the: '', dich_vu: '', so_tien: '', phi_may: '', chi_phi: '', phat_sinh: '', chuyen: '',
    so_du: st.so_du_truoc, ghi_chu: '' }];
  var tx = readAll_('GiaoDich').filter(function (t) { return t.hoan_tt !== 'Đã nhận' && Number(t.tien_hoan) && t.ngay >= (from || '0000') && t.ngay <= to; });
  var pays = readAll_('DoiSoat').filter(function (x) { return x.ngay >= (from || '0000') && x.ngay <= to; });
  var closings = closings_().filter(function (c) { return c.ngay >= (from || '0000') && c.ngay <= to; });
  var days = {};
  tx.forEach(function (t) { (days[t.ngay] = days[t.ngay] || { tx: [], pay: [] }).tx.push(t); });
  pays.forEach(function (x) { (days[x.ngay] = days[x.ngay] || { tx: [], pay: [] }).pay.push(x); });
  closings.forEach(function (c) { days[c.ngay] = days[c.ngay] || { tx: [], pay: [] }; });
  var bal = st.so_du_truoc;
  var byClose = {};
  closings.forEach(function (c) { byClose[c.ngay] = c; });
  Object.keys(days).sort().forEach(function (d) {
    days[d].pay.sort(function (a, b) { return String(a.tao_luc).localeCompare(String(b.tao_luc)); }).forEach(function (x) {
      var tien = paymentSign_(x);
      bal -= tien;
      rows.push({ ngay: d, loai: x.loai, khach: '', the: '', dich_vu: '', so_tien: '', phi_may: '', chi_phi: '', phat_sinh: '',
        chuyen: tien, so_du: bal, ghi_chu: x.ghi_chu || '', id: x.id, kind: 'pay' });
    });
    days[d].tx.sort(function (a, b) { return String(a.tao_luc).localeCompare(String(b.tao_luc)); }).forEach(function (t) {
      bal += Number(t.tien_hoan) || 0;
      rows.push({ ngay: d, loai: 'Giao dịch', khach: t.ten_khach, the: t.the, dich_vu: t.dich_vu, so_tien: Number(t.so_tien) || 0,
        phi_may: t.phi_may, chi_phi: Number(t.chi_phi) || 0, phat_sinh: Number(t.tien_hoan) || 0, chuyen: '', so_du: bal,
        ghi_chu: [t.may ? 'máy ' + t.may : '', t.ghi_chu].filter(String).join(' · '), id: t.id, kind: 'tx' });
    });
    var c = byClose[d];
    if (c) {
      if (c.nhap_tay) bal = Number(c.so_du) || 0; // số chốt nhập tay thay cho số tính
      rows.push({ ngay: d, loai: c.nhap_tay ? 'Chốt sổ (nhập tay)' : 'Chốt sổ', khach: '', the: '', dich_vu: '', so_tien: '', phi_may: '', chi_phi: '',
        phat_sinh: '', chuyen: '', so_du: Number(c.so_du) || 0, ghi_chu: c.ghi_chu || '', kind: 'close' });
    }
  });
  var tong = { so_tien: 0, chi_phi: 0, phat_sinh: 0, chuyen: 0 };
  rows.forEach(function (r) { ['so_tien', 'chi_phi', 'phat_sinh', 'chuyen'].forEach(function (k) { if (r[k] !== '') tong[k] += Number(r[k]) || 0; }); });
  return { from: from, to: to === '9999-12-31' ? '' : to, rows: rows, tong: tong, so_du_cuoi: rows[rows.length - 1].so_du, refundName: refundName_() };
}

var EXPORT_SHEET = 'Xuất công nợ';

/** Ghi bảng chi tiết công nợ ra một trang tính "Xuất công nợ" để xem / lọc / in như Excel. */
function apiExportCongNo_(p) {
  var d = congNoDetail_(p.from, p.to);
  var ss = SpreadsheetApp.getActive();
  var sh = ss.getSheetByName(EXPORT_SHEET) || ss.insertSheet(EXPORT_SHEET);
  sh.clear();
  var head = ['Ngày', 'Loại', 'Khách', 'Thẻ', 'Dịch vụ', 'Số tiền', 'Phí máy %', 'Phí máy', 'Tiền hoàn (+)', d.refundName + ' chuyển / ứng (−)', 'Số dư', 'Ghi chú'];
  var data = [['Công nợ ' + d.refundName + ' – ' + (d.from ? 'từ ' + fmtDmy_(d.from) : 'từ đầu') + (d.to ? ' đến ' + fmtDmy_(d.to) : ' đến nay') + ' – xuất lúc ' + nowStr_(), '', '', '', '', '', '', '', '', '', '', ''], head];
  d.rows.forEach(function (r) {
    data.push([r.ngay ? fmtDmy_(r.ngay) : '', r.loai, r.khach, r.the, r.dich_vu, r.so_tien, r.phi_may, r.chi_phi, r.phat_sinh, r.chuyen, r.so_du, r.ghi_chu]);
  });
  data.push(['', 'TỔNG', '', '', '', d.tong.so_tien, '', d.tong.chi_phi, d.tong.phat_sinh, d.tong.chuyen, d.so_du_cuoi, '']);
  sh.getRange(1, 1, data.length, head.length).setValues(data);
  try {
    sh.getRange(2, 1, 1, head.length).setFontWeight('bold').setBackground('#e8f0fb');
    sh.getRange(3, 6, data.length - 2, 6).setNumberFormat('#,##0');
    sh.setFrozenRows(2);
    sh.autoResizeColumns(1, head.length);
  } catch (e) { /* định dạng không bắt buộc */ }
  return { url: ss.getUrl() + '#gid=' + sh.getSheetId(), rows: d.rows.length };
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
    // Số dư đầu kỳ = tồn lần chốt gần nhất trước `from` + phát sinh từ sau ngày chốt đến trước `from`.
    var base = closings_().filter(function (c) { return c.ngay < from; }).pop();
    var cut = base ? base.ngay : '';
    opening = base ? Number(base.so_du) || 0 : 0;
    dues.forEach(function (t) { if (t.ngay > cut && t.ngay < from) opening += Number(t.tien_hoan) || 0; });
    pays.forEach(function (x) { if (x.ngay > cut && x.ngay < from) opening -= x.tien; });
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
  // Danh sách giao dịch thuộc Mục 2 (cũ trước) để biết bắt đầu từ giao dịch nào.
  var gd = readAll_('GiaoDich').filter(function (t) { return t.hoan_tt !== 'Đã nhận' && Number(t.tien_hoan) && (!from || t.ngay >= from); })
    .sort(function (a, b) { return a.ngay < b.ngay ? -1 : a.ngay > b.ngay ? 1 : String(a.tao_luc).localeCompare(String(b.tao_luc)); })
    .map(function (t) { return { id: t.id, ngay: t.ngay, ten_khach: t.ten_khach, the: t.the, dich_vu: t.dich_vu, so_tien: t.so_tien, chi_phi: t.chi_phi, tien_hoan: t.tien_hoan }; });
  return {
    chot_ngay: last ? last.ngay : '', ton1: st.so_du_truoc,
    tu_ngay: from || (st.ngay_lam.length ? st.ngay_lam[0].ngay : todayStr_()),
    so_gd: st.so_gd, so_tien: st.so_tien, chi_phi: st.chi_phi, phat_sinh: st.phat_sinh,
    tam_ung: st.payments, tong_tam_ung: st.da_chuyen, ton2: ton2, tong: st.so_du_truoc + ton2, giao_dich: gd
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
    audit_('Chốt sổ', 'Chốt', obj.id, obj.ngay, 'Chốt đến hết ' + fmtDmy_(obj.ngay) + ': tồn ' + fmtMoney_(obj.so_du), '', 'Tồn ' + fmtMoney_(obj.so_du));
    obj.tin_nhan = st.tin_nhan;
    return obj;
  });
}

/**
 * Nhập tay Mục 1: chốt công nợ đến ngày `ngay` với số tiền thực tế (VD từ sổ tay).
 * so_du dương = C.Trâm còn nợ mình, âm = C.Trâm ứng dư. Giao dịch / tiền ứng đến hết ngày đó coi như đã gồm trong số chốt.
 */
function apiManualClosing_(p) {
  var ngay = String(p.ngay || '');
  if (!/^\d{4}-\d{2}-\d{2}$/.test(ngay)) throw new Error('Chọn ngày chốt.');
  if (ngay > todayStr_()) throw new Error('Không chốt cho ngày trong tương lai.');
  var n = Number(p.so_du);
  if (isNaN(n)) throw new Error('Số tiền chốt không hợp lệ.');
  return withLock_(function () {
    var last = lastClosing_();
    if (last && ngay <= last.ngay) throw new Error('Đã chốt đến ngày ' + fmtDmy_(last.ngay) + ', hãy chọn ngày sau đó (hoặc bỏ lần chốt đó trước).');
    var obj = { id: newId_(), ngay: ngay, tu_ngay: '', so_du_truoc: '', so_gd: 0, so_tien: 0, chi_phi: 0, phat_sinh: 0, da_chuyen: 0,
      so_du: n, ghi_chu: String(p.ghi_chu || '').trim(), tao_luc: nowStr_(), nhap_tay: 'x' };
    appendObj_('KetSo', obj);
    audit_('Chốt sổ', 'Nhập tay Mục 1', obj.id, ngay, 'Chốt đến hết ' + fmtDmy_(ngay) + ': tồn ' + fmtMoney_(n) + (obj.ghi_chu ? ' (' + obj.ghi_chu + ')' : ''), '', 'Tồn ' + fmtMoney_(n));
    return obj;
  });
}

/** Chỉ bỏ được lần kết gần nhất (để sửa số liệu rồi kết lại). */
function apiDeleteClosing_(p) {
  return withLock_(function () {
    var last = lastClosing_();
    if (!last || last.id !== p.id) throw new Error('Chỉ bỏ được lần kết số dư gần nhất.');
    var ok = deleteObj_('KetSo', p.id);
    if (ok) audit_('Chốt sổ', 'Bỏ chốt', last.id, last.ngay, 'Bỏ lần chốt đến hết ' + fmtDmy_(last.ngay), 'Tồn ' + fmtMoney_(last.so_du), '');
    return ok;
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
    readAll_('HoaDon').forEach(function (b) { if (b.ngay) years[String(b.ngay).slice(0, 4)] = 1; });
    years[String(year)] = 1;
    Object.keys(years).sort().forEach(function (y) {
      periods.push({ label: 'Năm ' + y, from: y + '-01-01', to: y + '-12-31' });
    });
  }

  function inRange(d, a, b) { return d >= a && d <= b; }
  // Hoá đơn ghép (ví trả sau) đã hoàn tất, tính theo ngày ghép
  var bills = readAll_('HoaDon').map(billCalc_).filter(function (b) { return b.trang_thai === 'Hoàn tất'; });
  function billSum(list, s) {
    s.hd_so = list.length;
    s.hd_tien = list.reduce(function (a, b) { return a + b.so_tien; }, 0);
    s.hd_lai = list.reduce(function (a, b) { return a + b.doanh_thu; }, 0);
    s.tong_lai = (s.loi_nhuan || 0) + s.hd_lai;
    return s;
  }
  function billGroup(list, field) {
    var g = {};
    list.forEach(function (b) { var k = b[field] || '(trống)'; (g[k] = g[k] || []).push(b); });
    return Object.keys(g).map(function (k) { return billSum(g[k], { name: k, loi_nhuan: 0 }); }).sort(function (a, b) { return b.hd_tien - a.hd_tien; });
  }
  var rows = periods.map(function (pr) {
    var t = tx.filter(function (x) { return inRange(x.ngay, pr.from, pr.to); });
    var s = summarize_(t);
    s.label = pr.label; s.from = pr.from; s.to = pr.to;
    s.khach_moi = customers.filter(function (c) { return inRange(String(c.tao_luc).slice(0, 10), pr.from, pr.to); }).length;
    s.lead_web = leads.filter(function (l) { return l.sdt && inRange(String(l.thoi_gian).slice(0, 10), pr.from, pr.to); }).length;
    s.bam_web = leads.filter(function (l) { return !l.sdt && inRange(String(l.thoi_gian).slice(0, 10), pr.from, pr.to); }).length;
    billSum(bills.filter(function (b) { return inRange(b.ngay, pr.from, pr.to); }), s);
    return s;
  });
  var all = { from: periods[0].from, to: periods[periods.length - 1].to };
  var allTx = tx.filter(function (x) { return inRange(x.ngay, all.from, all.to); });
  var total = summarize_(allTx);
  total.khach_moi = rows.reduce(function (a, r) { return a + r.khach_moi; }, 0);
  total.lead_web = rows.reduce(function (a, r) { return a + r.lead_web; }, 0);
  total.bam_web = rows.reduce(function (a, r) { return a + r.bam_web; }, 0);
  var allBills = bills.filter(function (b) { return inRange(b.ngay, all.from, all.to); });
  billSum(allBills, total);
  return {
    type: type, year: year, month: month, rows: rows, total: total,
    byBillType: billGroup(allBills, 'loai_hd'), byWallet: billGroup(allBills, 'vi_b'),
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
    if (o.sdt2 !== undefined && o.sdt2 !== '') o.sdt2 = normalizePhone_(o.sdt2);
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
