/**
 * Kéo chi phí Google Ads về tab "Chi phí" của Sheet CRM Hoàng Hiệp, mỗi ngày một lần.
 * Dán vào Google Ads: Công cụ > Hành động hàng loạt > Tập lệnh > dấu + > dán > Cho phép > Lưu > Đặt lịch hằng ngày.
 */
var SHEET_ID = '1x9Phjv_inHpa3Jzl1pbDgvKSNtGznPbqjY9SGicNgIM';  // Mã file Sheet CRM (đoạn giữa /d/ và /edit trên thanh địa chỉ)
var TAB = 'Chi phí';
var DAYS = 7;          // Cập nhật lại bao nhiêu ngày gần nhất (Google Ads có thể chỉnh số liệu sau vài ngày)
var RATE = 1;          // Tài khoản tính bằng VNĐ: để 1. Tài khoản tính bằng USD: ví dụ 25000.
var UTM_MAP = {};      // Tuỳ chọn: {'Tên chiến dịch trong Google Ads': 'utm-cua-chien-dich'}. Không khai báo thì tự đặt từ tên chiến dịch.

function slug_(s) {
  return String(s).toLowerCase().replace(/đ/g, 'd').normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
}
function ymd_(d, tz) { return Utilities.formatDate(d, tz, 'yyyy-MM-dd'); }

function main() {
  var tz = AdsApp.currentAccount().getTimeZone(), now = new Date(), from = new Date(now.getTime() - (DAYS - 1) * 86400000);
  var rows = AdsApp.search(
    "SELECT campaign.name, segments.date, metrics.cost_micros, metrics.impressions, metrics.clicks FROM campaign " +
    "WHERE segments.date BETWEEN '" + ymd_(from, tz) + "' AND '" + ymd_(now, tz) + "' AND metrics.impressions > 0");
  var data = [], utms = {};
  while (rows.hasNext()) {
    var r = rows.next(), name = r.campaign.name, utm = UTM_MAP[name] || slug_(name);
    utms[name] = utm;
    data.push({ day: r.segments.date, utm: utm, cost: Math.round(Number(r.metrics.costMicros) / 1e6 * RATE), imp: Number(r.metrics.impressions), clk: Number(r.metrics.clicks) });
  }
  var sh = SpreadsheetApp.openById(SHEET_ID).getSheetByName(TAB);
  if (!sh) throw new Error('Không thấy tab "' + TAB + '" trong Sheet. Kiểm tra SHEET_ID.');
  var ss = sh.getParent(), stz = ss.getSpreadsheetTimeZone(), last = sh.getLastRow(), index = {};
  if (last > 1) {
    sh.getRange(2, 1, last - 1, 2).getValues().forEach(function (v, i) {
      var d = v[0] && typeof v[0].getTime === 'function' ? ymd_(v[0], stz) : String(v[0]).slice(0, 10);
      index[d + '|' + v[1]] = i + 2;
    });
  }
  var added = 0, updated = 0;
  data.forEach(function (x) {
    var p = x.day.split('-'), date = new Date(Number(p[0]), Number(p[1]) - 1, Number(p[2])), key = x.day + '|' + x.utm;
    if (index[key]) { sh.getRange(index[key], 3, 1, 3).setValues([[x.cost, x.imp, x.clk]]); updated++; }
    else { sh.appendRow([date, x.utm, x.cost, x.imp, x.clk]); added++; }
  });
  Logger.log('Đã thêm ' + added + ' dòng, cập nhật ' + updated + ' dòng.');
  Logger.log('Đặt utm_campaign cho từng chiến dịch như sau (dán vào Hậu tố URL cuối cùng: utm_source=google&utm_medium=cpc&utm_campaign=...):');
  for (var n in utms) Logger.log('  ' + n + '  ->  ' + utms[n]);
}
