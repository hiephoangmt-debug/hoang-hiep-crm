import { nowIso } from './db.js';

// Bỏ dấu tiếng Việt, viết thường, chỉ giữ chữ + số: "Số điện thoại" -> "sodienthoai"
export function fieldKey(s) {
  return String(s)
    .normalize('NFD')
    .replace(/[̀-ͯ]/g, '')
    .replace(/đ/g, 'd')
    .replace(/Đ/g, 'd')
    .toLowerCase()
    .replace(/[^a-z0-9]/g, '');
}

// Các tên trường hay gặp trên LadiPage, WordPress (CF7, Elementor), Google Form, tự code...
const ALIASES = {
  name: ['name', 'fullname', 'hoten', 'hovaten', 'ten', 'tenkhachhang', 'yourname', 'customername', 'hotenkhachhang', 'quykhach'],
  phone: ['phone', 'sdt', 'sodienthoai', 'dienthoai', 'mobile', 'tel', 'phonenumber', 'yourphone', 'didong', 'sodt', 'hotline'],
  email: ['email', 'mail', 'youremail', 'emailaddress', 'diachiemail'],
  message: ['message', 'note', 'noidung', 'nhucau', 'ghichu', 'content', 'comment', 'loinhan', 'yeucau', 'yourmessage', 'cauhoi', 'tinnhan'],
  page_url: ['url', 'urlpage', 'pageurl', 'link', 'landingpage', 'linkpage', 'sourceurl', 'website', 'trang', 'pagelink', 'href'],
  page_title: ['pagetitle', 'title', 'tieude'],
  project: ['project', 'duan', 'sanpham', 'product', 'tenduan', 'duanquantam'],
  referrer: ['referrer', 'referer', 'ref'],
  form_name: ['formname', 'form', 'formid', 'tenform'],
  ip: ['ip', 'ipaddress', 'clientip'],
  user_agent: ['useragent', 'ua'],
  need_type: ['loaihinh', 'loaibds', 'loaisanpham', 'propertytype'],
  budget: ['ngansach', 'budget', 'taichinh', 'khoanggia', 'mucgia'],
  need_area: ['khuvuc', 'area', 'vitri', 'location'],
  source: ['source', 'nguon', 'site'],
};
const UTM = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term', 'gclid', 'fbclid'];
// firstlanding/firstvisitat/pagesviewed do tracker.js gửi: chỉ giữ trong raw_json
const IGNORE = new Set(['firstlanding', 'firstvisitat', 'pagesviewed', 'key', 'captcha', 'grecaptcharesponse', 'gresponse', 'submit', 'action', 'nonce', 'wpnonce', 'tracking', 'timestamp']);

const LOOKUP = new Map();
for (const [field, list] of Object.entries(ALIASES)) for (const a of list) LOOKUP.set(a, field);
for (const u of UTM) LOOKUP.set(fieldKey(u), u);

// Tên trường không khớp chính xác: "your-tel", "billing_phone", "ho-ten-khach"...
function fuzzyField(k) {
  if (/phone|sodienthoai|dienthoai|sdt|mobile|tel$/.test(k)) return 'phone';
  if (/email|mail$/.test(k)) return 'email';
  if (/hoten|fullname|name$/.test(k) && !/form|page|project|campaign/.test(k)) return 'name';
  if (/message|noidung|nhucau|ghichu|loinhan/.test(k)) return 'message';
  return null;
}

export function normalizePhone(input) {
  if (!input) return '';
  let d = String(input).replace(/[^\d+]/g, '');
  d = d.replace(/^\+/, '');
  if (d.startsWith('0084')) d = d.slice(4);
  else if (d.startsWith('84') && d.length >= 11) d = d.slice(2);
  if (!d.startsWith('0')) d = '0' + d;
  return /^0\d{9,10}$/.test(d) ? d : '';
}

export function domainOf(url) {
  try {
    return new URL(url).hostname.replace(/^www\./, '');
  } catch {
    return '';
  }
}

// Chuyển payload thô (JSON lồng nhau, form...) thành bản ghi chuẩn
export function mapLeadPayload(payload) {
  const flat = {};
  (function walk(obj) {
    for (const [k, v] of Object.entries(obj || {})) {
      if (v && typeof v === 'object' && !Array.isArray(v)) walk(v);
      else flat[k] = Array.isArray(v) ? v.join(', ') : v;
    }
  })(payload);

  const lead = { extras: {} };
  for (const [rawKey, rawVal] of Object.entries(flat)) {
    if (rawVal === undefined || rawVal === null || rawVal === '') continue;
    const val = String(rawVal).trim();
    const k = fieldKey(rawKey);
    if (IGNORE.has(k)) continue;
    const field = LOOKUP.get(k) || fuzzyField(k);
    if (field && !lead[field]) lead[field] = val;
    else if (!field) lead.extras[rawKey] = val;
  }

  // Không có trường SĐT/email rõ ràng: dò theo giá trị (VD: form đặt tên "field_3")
  for (const [k, v] of Object.entries(lead.extras)) {
    if (!lead.phone && normalizePhone(v) && /^[\d\s.+()-]{9,16}$/.test(v)) { lead.phone = v; delete lead.extras[k]; }
    else if (!lead.email && /^[^\s@]+@[^\s@]+\.[a-z]{2,}$/i.test(v)) { lead.email = v; delete lead.extras[k]; }
  }

  // UTM có thể nằm sẵn trong URL trang
  if (lead.page_url) {
    try {
      const u = new URL(lead.page_url);
      for (const p of UTM) if (!lead[p] && u.searchParams.get(p)) lead[p] = u.searchParams.get(p);
    } catch { /* URL không hợp lệ */ }
  }
  lead.phone_norm = normalizePhone(lead.phone);
  lead.email = lead.email ? lead.email.toLowerCase() : '';
  return lead;
}

function parseBudget(text) {
  if (!text) return {};
  const nums = String(text).replace(/,/g, '.').match(/\d+(\.\d+)?/g);
  if (!nums) return {};
  let vals = nums.map(Number);
  // "800 triệu" -> 0.8 tỷ
  if (/tri[eệ]u|tr\b/i.test(text)) vals = vals.map((v) => v / 1000);
  return { budget_min: Math.min(...vals), budget_max: Math.max(...vals) };
}

/**
 * Ghi nhận một lead: tìm khách theo SĐT/email, tạo mới nếu chưa có,
 * lưu lượt đăng ký (inquiry) kèm link web, thời gian, nhu cầu.
 * Trả về { customer, inquiry, isNew }.
 */
export function ingestLead(db, payload, opts = {}) {
  const lead = mapLeadPayload(payload);
  if (!lead.phone_norm && !lead.email) {
    const err = new Error('Thiếu số điện thoại hoặc email');
    err.status = 400;
    throw err;
  }
  const now = opts.now || nowIso();
  const source = opts.source || lead.source || domainOf(lead.page_url) || domainOf(lead.referrer) || 'khac';

  const extrasText = Object.entries(lead.extras).map(([k, v]) => `${k}: ${v}`).join('\n');
  const message = [lead.message, extrasText].filter(Boolean).join('\n');

  let customer = null;
  if (lead.phone_norm) customer = db.prepare('SELECT * FROM customers WHERE phone = ?').get(lead.phone_norm);
  if (!customer && lead.email) customer = db.prepare('SELECT * FROM customers WHERE email = ? ORDER BY id LIMIT 1').get(lead.email);

  const isNew = !customer;
  let customerId;
  if (isNew) {
    const budget = parseBudget(lead.budget);
    const r = db.prepare(`INSERT INTO customers
      (name, phone, email, status, need_type, need_area, budget_min, budget_max, need_note,
       first_source, first_url, last_inquiry_at, next_follow_up_at, next_follow_up_note, created_at, updated_at)
      VALUES (?, ?, ?, 'moi', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)`).run(
      lead.name || '', lead.phone_norm || null, lead.email || null,
      lead.need_type || null, lead.need_area || null, budget.budget_min ?? null, budget.budget_max ?? null,
      lead.message || null, source, lead.page_url || null, now, now,
      'Khách mới từ web – gọi ngay', now, now,
    );
    customerId = Number(r.lastInsertRowid);
  } else {
    customerId = customer.id;
    // Khách cũ quay lại đăng ký: đẩy lên đầu danh sách gọi
    db.prepare(`UPDATE customers SET
        name = CASE WHEN name = '' THEN ? ELSE name END,
        email = COALESCE(email, ?),
        phone = COALESCE(phone, ?),
        temperature = CASE WHEN temperature = 'lanh' THEN 'am' ELSE temperature END,
        status = CASE WHEN status = 'ngung' THEN 'dang_cham_soc' ELSE status END,
        last_inquiry_at = ?, next_follow_up_at = ?, next_follow_up_note = ?, updated_at = ?
      WHERE id = ?`).run(
      lead.name || '', lead.email || null, lead.phone_norm || null,
      now, now, `Khách đăng ký lại trên ${source} – gọi lại ngay`, now, customerId,
    );
  }

  const ir = db.prepare(`INSERT INTO inquiries
    (customer_id, source, page_url, page_title, referrer, utm_source, utm_medium, utm_campaign, utm_content, utm_term,
     gclid, fbclid, form_name, project, message, ip, user_agent, raw_json, created_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)`).run(
    customerId, source, lead.page_url || null, lead.page_title || null, lead.referrer || null,
    lead.utm_source || null, lead.utm_medium || null, lead.utm_campaign || null, lead.utm_content || null, lead.utm_term || null,
    lead.gclid || null, lead.fbclid || null, lead.form_name || null, lead.project || null, message || null,
    lead.ip || opts.ip || null, lead.user_agent || opts.userAgent || null, JSON.stringify(payload), now,
  );

  if (!isNew) {
    db.prepare(`INSERT INTO activities (customer_id, type, content, created_at) VALUES (?, 'system', ?, ?)`)
      .run(customerId, `Khách đăng ký lại trên ${source}${lead.page_url ? ` (${lead.page_url})` : ''}`, now);
  }

  return {
    isNew,
    customer: { ...db.prepare('SELECT * FROM customers WHERE id = ?').get(customerId) },
    inquiry: { ...db.prepare('SELECT * FROM inquiries WHERE id = ?').get(Number(ir.lastInsertRowid)) },
  };
}
