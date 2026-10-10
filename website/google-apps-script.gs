/**
 * Lưu khách đăng ký từ website fpt-city.com vào Google Sheet "DATA CHẠY GOOGLE".
 *
 * Ghi đúng định dạng các tab hiện có:
 *   A THỜI GIAN | B TÊN KHÁCH | C SỐ ĐIỆN THOẠI | D LOẠI CĂN / NHU CẦU | E LINK WEB |
 *   F NGUỒN (utm_source/referrer) | G utm_medium | H utm_campaign | I utm_term | J gclid/fbclid |
 *   K IP | L MÃ FORM | M GHI CHÚ SALE (để trống cho sale ghi) | N EMAIL
 *
 * Mỗi dự án một tab:
 *   FPT Plaza 1..5      -> "FPT PLAZA 1" … "FPT PLAZA 5" (FPT PLAZA 4 dùng tab đã có)
 *   Đất nền (V1..V6)    -> "DAT NEN FPT CITY" (phân khu ghi ở cột D)
 *   Trang chủ / tổng hợp -> "FPT CITY"
 * Tab chưa có sẽ tự tạo kèm dòng tiêu đề. Script chỉ THÊM dòng, không sửa/xoá dữ liệu cũ.
 *
 * CÁCH CÀI (5 phút):
 * 1. Mở https://script.google.com > Dự án mới > dán toàn bộ file này > Lưu.
 * 2. Triển khai > Tùy chọn triển khai mới > (bánh răng) Ứng dụng web
 *      Thực thi với tư cách: Tôi      Người có quyền truy cập: Bất kỳ ai
 *    > Triển khai > cấp quyền truy cập Google Sheet.
 * 3. Copy URL kết thúc bằng /exec, dán vào CONFIG.leadEndpoint trong public/assets/js/main.js.
 * (Tùy chọn) NOTIFY_EMAIL: nhận email mỗi khi có khách mới.
 */
const SPREADSHEET_ID = "1yvgJAi4LKDZXiWSa_sS02rlQxvhh-nO-4kJ3GmxzxOE";
const NOTIFY_EMAIL = "";
const HEADER = ["THỜI GIAN", "TÊN KHÁCH", "SỐ ĐIỆN THOẠI", "LOẠI CĂN", "LINK WEB",
  "NGUỒN", "UTM MEDIUM", "UTM CAMPAIGN", "UTM TERM", "GCLID/FBCLID", "IP", "FORM", "GHI CHÚ", "EMAIL"];

function tabFor(project) {
  const p = String(project || "").trim();
  const plaza = p.match(/FPT Plaza\s*(\d)/i);
  if (plaza) return "FPT PLAZA " + plaza[1];
  if (/đất nền/i.test(p)) return "DAT NEN FPT CITY";
  return "FPT CITY";
}

// Chặn chèn công thức vào Sheet và giới hạn độ dài
function clean(v) {
  v = String(v == null ? "" : v).slice(0, 500);
  return /^[=+\-@]/.test(v) ? "'" + v : v;
}

function doPost(e) {
  const p = (e && e.parameter) || {};
  if (p.website) return json({ ok: true }); // bẫy bot (honeypot)
  const phone = String(p.phone || "").replace(/[^\d+]/g, "");
  if (!p.name || phone.length < 9) return json({ ok: false, error: "invalid" });

  const lock = LockService.getScriptLock();
  lock.waitLock(10000);
  try {
    const ss = SpreadsheetApp.openById(SPREADSHEET_ID);
    const name = tabFor(p.project);
    let sheet = ss.getSheetByName(name);
    if (!sheet) {
      sheet = ss.insertSheet(name);
      sheet.appendRow(HEADER);
      sheet.setFrozenRows(1);
    }
    const zone = (p.project || "").match(/\bV\d+\b/);
    const need = [zone ? "Phân khu " + zone[0] : "", p.need].filter(String).join(" · ");
    const time = Utilities.formatDate(new Date(), "Asia/Ho_Chi_Minh", "yyyy-MM-dd HH:mm:ss");
    sheet.appendRow([
      time,
      clean(p.name),
      "'" + phone, // giữ số 0 đầu
      clean(need),
      clean(p.page),
      clean(p.utm_source || p.referrer),
      clean(p.utm_medium),
      clean(p.utm_campaign),
      clean(p.utm_term),
      clean(p.gclid || p.fbclid),
      clean(p.ip),
      clean("WEB-" + String(p.source || "").toUpperCase()),
      "",
      clean(p.email),
    ]);
    if (NOTIFY_EMAIL) {
      MailApp.sendEmail(NOTIFY_EMAIL, "Khách mới " + name + ": " + clean(p.name) + " – " + phone,
        [time, clean(p.name), phone, need, clean(p.email), clean(p.page)].join("\n"));
    }
    return json({ ok: true });
  } finally {
    lock.releaseLock();
  }
}

function json(o) {
  return ContentService.createTextOutput(JSON.stringify(o)).setMimeType(ContentService.MimeType.JSON);
}
