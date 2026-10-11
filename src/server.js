import http from 'node:http';
import fs from 'node:fs';
import path from 'node:path';
import crypto from 'node:crypto';
import { fileURLToPath } from 'node:url';
import { config } from './config.js';
import { openDb, getSettings, nowIso, DEFAULT_SETTINGS } from './db.js';
import { ingestLead, normalizePhone } from './leads.js';
import { buildAgenda, defaultNextFollowUp, matchCustomersForProject, STATUS_LABEL } from './reminders.js';
import { SCRIPTS, SCRIPT_GROUPS, suggestFor, localDate } from './scripts.js';
import { aiSuggest, aiAvailable } from './ai.js';
import { notifyNewLead } from './notify.js';

const here = path.dirname(fileURLToPath(import.meta.url));
const PUBLIC_DIR = path.resolve(here, '..', 'public');

const MIME = {
  '.html': 'text/html; charset=utf-8', '.js': 'application/javascript; charset=utf-8',
  '.css': 'text/css; charset=utf-8', '.svg': 'image/svg+xml', '.png': 'image/png',
  '.ico': 'image/x-icon', '.json': 'application/json', '.webmanifest': 'application/manifest+json',
};

const CUSTOMER_FIELDS = ['name', 'salutation', 'phone', 'email', 'zalo', 'birthday', 'job', 'address', 'status', 'temperature',
  'need_type', 'need_purpose', 'need_area', 'budget_min', 'budget_max', 'need_timeline', 'need_note', 'best_call_time',
  'notify_new_projects', 'do_not_call', 'tags', 'personal_note', 'next_follow_up_at', 'next_follow_up_note'];
const PROJECT_FIELDS = ['name', 'developer', 'location', 'area', 'type', 'price_from', 'price_to', 'launch_date', 'status', 'highlights', 'link'];

class HttpError extends Error {
  constructor(status, message) { super(message); this.status = status; }
}

// ---------- tiện ích HTTP ----------
function send(res, status, body, headers = {}) {
  const isStr = typeof body === 'string' || Buffer.isBuffer(body);
  res.writeHead(status, { 'content-type': isStr ? 'text/plain; charset=utf-8' : 'application/json; charset=utf-8', ...headers });
  res.end(isStr ? body : JSON.stringify(body));
}

async function readBody(req) {
  const chunks = [];
  let size = 0;
  for await (const c of req) {
    size += c.length;
    if (size > 2_000_000) throw new HttpError(413, 'Dữ liệu quá lớn');
    chunks.push(c);
  }
  const raw = Buffer.concat(chunks).toString('utf8');
  if (!raw) return {};
  const type = req.headers['content-type'] || '';
  // Một số công cụ gửi JSON nhưng khai báo sai content-type
  if (type.includes('application/x-www-form-urlencoded') && !/^\s*[[{]/.test(raw)) return Object.fromEntries(new URLSearchParams(raw));
  try {
    return JSON.parse(raw);
  } catch {
    if (raw.includes('=')) return Object.fromEntries(new URLSearchParams(raw));
    throw new HttpError(400, 'Body không hợp lệ');
  }
}

function baseUrl(req) {
  if (config.publicUrl) return config.publicUrl;
  const proto = (req.headers['x-forwarded-proto'] || 'http').split(',')[0];
  return `${proto}://${req.headers['x-forwarded-host'] || req.headers.host}`;
}

function clientIp(req) {
  return (req.headers['x-forwarded-for'] || req.socket.remoteAddress || '').split(',')[0].trim();
}

// ---------- đăng nhập ----------
function sign(value, secret) {
  return crypto.createHmac('sha256', secret).update(value).digest('base64url');
}
function makeSession(secret) {
  const exp = String(Date.now() + 30 * 86400000);
  return `${exp}.${sign(exp, secret)}`;
}
function validSession(token, secret) {
  if (!token) return false;
  const [exp, sig] = token.split('.');
  if (!exp || !sig || Number(exp) < Date.now()) return false;
  const expected = sign(exp, secret);
  return sig.length === expected.length && crypto.timingSafeEqual(Buffer.from(sig), Buffer.from(expected));
}
function getCookie(req, name) {
  const m = (req.headers.cookie || '').match(new RegExp(`(?:^|;\\s*)${name}=([^;]+)`));
  return m ? decodeURIComponent(m[1]) : '';
}
function safeEqual(a, b) {
  const ha = crypto.createHash('sha256').update(String(a)).digest();
  const hb = crypto.createHash('sha256').update(String(b)).digest();
  return crypto.timingSafeEqual(ha, hb);
}

// ---------- ứng dụng ----------
export function createApp({ db, password, secret, webhookKey }) {
  const failedLogins = new Map();
  const settings = () => getSettings(db);
  const hookKey = () => webhookKey || settings().webhook_key;

  const getCustomer = (id) => {
    const c = db.prepare('SELECT * FROM customers WHERE id = ?').get(id);
    if (!c) throw new HttpError(404, 'Không tìm thấy khách hàng');
    return { ...c };
  };

  const cleanCustomerInput = (body) => {
    const out = {};
    for (const f of CUSTOMER_FIELDS) {
      if (!(f in body)) continue;
      let v = body[f];
      if (v === '') v = null;
      if (f === 'phone' && v) {
        v = normalizePhone(v);
        if (!v) throw new HttpError(400, 'Số điện thoại không hợp lệ');
      }
      if (['budget_min', 'budget_max'].includes(f) && v != null) v = Number(v);
      if (['notify_new_projects', 'do_not_call'].includes(f)) v = v ? 1 : 0;
      if (f === 'name' || f === 'salutation') v = v || '';
      if (f === 'status' && !(v in STATUS_LABEL)) throw new HttpError(400, 'Trạng thái không hợp lệ');
      if (f === 'temperature' && !['nong', 'am', 'lanh'].includes(v)) throw new HttpError(400, 'Mức độ không hợp lệ');
      out[f] = v;
    }
    return out;
  };

  const updateRow = (table, id, data) => {
    const keys = Object.keys(data);
    if (!keys.length) return;
    if (table === 'customers') { keys.push('updated_at'); data.updated_at = nowIso(); }
    db.prepare(`UPDATE ${table} SET ${keys.map((k) => `${k} = ?`).join(', ')} WHERE id = ?`)
      .run(...keys.map((k) => data[k]), id);
  };

  const customerDetail = (id) => {
    const customer = getCustomer(id);
    const inquiries = db.prepare('SELECT * FROM inquiries WHERE customer_id = ? ORDER BY created_at DESC').all(id).map((r) => {
      const { raw_json, ...rest } = r;
      return { ...rest, raw: raw_json };
    });
    const activities = db.prepare('SELECT * FROM activities WHERE customer_id = ? ORDER BY created_at DESC, id DESC').all(id).map((r) => ({ ...r }));
    const projects = db.prepare(`SELECT p.id, p.name, p.status AS project_status, cp.status, cp.updated_at
      FROM customer_projects cp JOIN projects p ON p.id = cp.project_id WHERE cp.customer_id = ? ORDER BY cp.updated_at DESC`).all(id).map((r) => ({ ...r }));
    const s = settings();
    const now = new Date();
    const contactActs = activities.filter((a) => a.type !== 'system');
    const suggestions = suggestFor(customer, s, {
      now,
      inquiry: inquiries[0],
      lastActivity: contactActs[0],
      hasContact: contactActs.length > 0,
      isBirthday: customer.birthday && customer.birthday.slice(-5) === localDate(now).slice(5),
      project: projects[0]?.name,
    });
    return { customer, inquiries, activities, projects, suggestions };
  };

  // ---------- định tuyến ----------
  const routes = [];
  const route = (method, pattern, handler, { auth = true } = {}) => {
    const keys = [];
    const re = new RegExp('^' + pattern.replace(/:(\w+)/g, (_, k) => { keys.push(k); return '([^/]+)'; }) + '$');
    routes.push({ method, re, keys, handler, auth });
  };

  const corsHeaders = {
    'access-control-allow-origin': '*',
    'access-control-allow-methods': 'GET, POST, OPTIONS',
    'access-control-allow-headers': 'content-type',
  };

  // Webhook nhận lead (LadiPage, website, Google Sheets, Zapier...)
  const hook = async (req, res, { query }) => {
    let body = req.method === 'POST' ? await readBody(req) : {};
    if (Array.isArray(body)) body = body[0] || {};
    const key = query.get('key') || body.key || req.headers['x-crm-key'];
    if (!key || !safeEqual(key, hookKey())) return send(res, 401, { ok: false, error: 'Sai key' }, corsHeaders);
    const payload = { ...Object.fromEntries([...query].filter(([k]) => !['key', 'source'].includes(k))), ...body };
    const result = ingestLead(db, payload, {
      source: query.get('source') || undefined,
      ip: clientIp(req),
      userAgent: req.headers['user-agent'],
    });
    notifyNewLead(result, baseUrl(req));
    send(res, 200, { ok: true, customer_id: result.customer.id, is_new: result.isNew }, corsHeaders);
  };
  route('POST', '/api/hook/lead', hook, { auth: false });
  route('GET', '/api/hook/lead', hook, { auth: false });

  route('POST', '/api/login', async (req, res) => {
    const ip = clientIp(req);
    const f = failedLogins.get(ip) || { n: 0, t: Date.now() };
    if (Date.now() - f.t > 15 * 60000) { f.n = 0; f.t = Date.now(); }
    if (f.n >= 10) throw new HttpError(429, 'Sai mật khẩu quá nhiều lần, thử lại sau 15 phút');
    const { password: pw } = await readBody(req);
    if (!pw || !safeEqual(pw, password)) {
      f.n++; failedLogins.set(ip, f);
      throw new HttpError(401, 'Sai mật khẩu');
    }
    failedLogins.delete(ip);
    const secure = baseUrl(req).startsWith('https') ? '; Secure' : '';
    send(res, 200, { ok: true }, {
      'set-cookie': `crm_session=${makeSession(secret)}; HttpOnly; SameSite=Lax; Path=/; Max-Age=${30 * 86400}${secure}`,
    });
  }, { auth: false });

  route('POST', '/api/logout', (req, res) => {
    send(res, 200, { ok: true }, { 'set-cookie': 'crm_session=; HttpOnly; SameSite=Lax; Path=/; Max-Age=0' });
  }, { auth: false });

  route('GET', '/api/me', (req, res) => {
    send(res, 200, { ok: validSession(getCookie(req, 'crm_session'), secret) });
  }, { auth: false });

  route('GET', '/api/agenda', (req, res) => send(res, 200, buildAgenda(db, settings())));

  // Kiểm tra lead mới để hiện thông báo trên trình duyệt
  route('GET', '/api/poll', (req, res, { query }) => {
    const since = query.get('since') || new Date(Date.now() - 60000).toISOString();
    const rows = db.prepare(`SELECT i.id, i.customer_id, i.source, i.created_at, c.name, c.phone FROM inquiries i
      JOIN customers c ON c.id = i.customer_id WHERE i.created_at > ? ORDER BY i.created_at DESC LIMIT 20`).all(since);
    send(res, 200, { now: nowIso(), leads: rows.map((r) => ({ ...r })) });
  });

  route('GET', '/api/customers', (req, res, { query }) => {
    const where = [];
    const args = [];
    const q = (query.get('q') || '').trim();
    if (q) {
      const phone = q.replace(/\D/g, '');
      where.push(`(c.name LIKE ? OR c.email LIKE ? OR c.need_note LIKE ? OR c.tags LIKE ?${phone.length >= 3 ? ' OR c.phone LIKE ?' : ''})`);
      args.push(`%${q}%`, `%${q}%`, `%${q}%`, `%${q}%`);
      if (phone.length >= 3) args.push(`%${phone.replace(/^84/, '0')}%`);
    }
    for (const f of ['status', 'temperature', 'need_type']) {
      if (query.get(f)) { where.push(`c.${f} = ?`); args.push(query.get(f)); }
    }
    if (query.get('source')) {
      where.push('EXISTS (SELECT 1 FROM inquiries i WHERE i.customer_id = c.id AND i.source = ?)');
      args.push(query.get('source'));
    }
    const sorts = {
      newest: 'COALESCE(c.last_inquiry_at, c.created_at) DESC',
      follow: 'c.next_follow_up_at IS NULL, c.next_follow_up_at ASC',
      silent: 'COALESCE(c.last_contact_at, c.created_at) ASC',
      name: 'c.name COLLATE NOCASE ASC',
    };
    const order = sorts[query.get('sort')] || sorts.newest;
    const limit = Math.min(Number(query.get('limit')) || 50, 500);
    const offset = Number(query.get('offset')) || 0;
    const whereSql = where.length ? `WHERE ${where.join(' AND ')}` : '';
    const total = db.prepare(`SELECT COUNT(*) AS n FROM customers c ${whereSql}`).get(...args).n;
    const rows = db.prepare(`SELECT c.*,
        (SELECT i.source FROM inquiries i WHERE i.customer_id = c.id ORDER BY i.created_at DESC LIMIT 1) AS last_source,
        (SELECT COUNT(*) FROM inquiries i WHERE i.customer_id = c.id) AS inquiry_count
      FROM customers c ${whereSql} ORDER BY ${order} LIMIT ? OFFSET ?`).all(...args, limit, offset);
    send(res, 200, { total, rows: rows.map((r) => ({ ...r })) });
  });

  route('POST', '/api/customers', async (req, res) => {
    const body = await readBody(req);
    const result = ingestLead(db, { name: body.name, phone: body.phone, email: body.email, message: body.need_note, url: body.page_url },
      { source: body.source || 'Nhập tay' });
    const extra = cleanCustomerInput({ ...body, phone: undefined });
    delete extra.phone;
    updateRow('customers', result.customer.id, extra);
    send(res, 201, { ...customerDetail(result.customer.id), is_new: result.isNew });
  });

  route('GET', '/api/customers/:id', (req, res, { params }) => send(res, 200, customerDetail(Number(params.id))));

  route('PUT', '/api/customers/:id', async (req, res, { params }) => {
    const id = Number(params.id);
    getCustomer(id);
    const data = cleanCustomerInput(await readBody(req));
    if (data.phone) {
      const dup = db.prepare('SELECT id FROM customers WHERE phone = ? AND id <> ?').get(data.phone, id);
      if (dup) throw new HttpError(409, `Số này đã thuộc khách #${dup.id}`);
    }
    updateRow('customers', id, data);
    send(res, 200, customerDetail(id));
  });

  route('DELETE', '/api/customers/:id', (req, res, { params }) => {
    db.prepare('DELETE FROM customers WHERE id = ?').run(Number(params.id));
    send(res, 200, { ok: true });
  });

  // Ghi nhận cuộc gọi / tin nhắn / gặp mặt + đặt lịch gọi lại
  route('POST', '/api/customers/:id/activities', async (req, res, { params }) => {
    const id = Number(params.id);
    const customer = getCustomer(id);
    const body = await readBody(req);
    const type = body.type || 'call';
    const now = new Date();
    db.prepare('INSERT INTO activities (customer_id, type, outcome, content, created_at) VALUES (?, ?, ?, ?, ?)')
      .run(id, type, body.outcome || null, body.content || null, now.toISOString());

    const upd = {};
    const reached = !['khong_nghe', 'thue_bao', 'sai_so'].includes(body.outcome) && type !== 'note';
    if (reached) upd.last_contact_at = now.toISOString();
    if (body.status && body.status in STATUS_LABEL) upd.status = body.status;
    else if (customer.status === 'moi' && reached) upd.status = 'dang_cham_soc';
    if (['nong', 'am', 'lanh'].includes(body.temperature)) upd.temperature = body.temperature;
    if (body.outcome === 'tu_choi' && !upd.temperature) upd.temperature = 'lanh';
    if (body.outcome === 'sai_so') upd.do_not_call = 1;

    if (body.next_follow_up_at === 'none') {
      upd.next_follow_up_at = null; upd.next_follow_up_note = null;
    } else if (body.next_follow_up_at) {
      upd.next_follow_up_at = new Date(body.next_follow_up_at).toISOString();
      upd.next_follow_up_note = body.next_follow_up_note || null;
    } else if (type !== 'note') {
      upd.next_follow_up_at = defaultNextFollowUp(body.outcome, upd.temperature || customer.temperature, settings(), now);
      upd.next_follow_up_note = body.next_follow_up_note || (body.outcome === 'khong_nghe' ? 'Gọi lại (lần trước không nghe máy)' : null);
    }
    updateRow('customers', id, upd);
    send(res, 201, customerDetail(id));
  });

  route('DELETE', '/api/activities/:id', (req, res, { params }) => {
    db.prepare('DELETE FROM activities WHERE id = ?').run(Number(params.id));
    send(res, 200, { ok: true });
  });

  route('POST', '/api/customers/:id/ai-suggest', async (req, res, { params }) => {
    const detail = customerDetail(Number(params.id));
    const { goal } = await readBody(req);
    const text = await aiSuggest({ ...detail, settings: settings(), goal });
    send(res, 200, { text });
  });

  // ---------- dự án ----------
  const cleanProject = (body) => {
    const out = {};
    for (const f of PROJECT_FIELDS) {
      if (!(f in body)) continue;
      let v = body[f] === '' ? null : body[f];
      if (['price_from', 'price_to'].includes(f) && v != null) v = Number(v);
      out[f] = v;
    }
    if ('name' in out && !out.name) throw new HttpError(400, 'Thiếu tên dự án');
    return out;
  };

  route('GET', '/api/projects', (req, res) => {
    const rows = db.prepare(`SELECT p.*,
        (SELECT COUNT(*) FROM customer_projects cp WHERE cp.project_id = p.id AND cp.status = 'can_goi') AS to_call,
        (SELECT COUNT(*) FROM customer_projects cp WHERE cp.project_id = p.id AND cp.status = 'quan_tam') AS interested
      FROM projects p ORDER BY CASE p.status WHEN 'sap_mo' THEN 0 WHEN 'dang_ban' THEN 1 ELSE 2 END, p.launch_date DESC`).all();
    send(res, 200, rows.map((r) => ({ ...r })));
  });

  route('POST', '/api/projects', async (req, res) => {
    const data = cleanProject(await readBody(req));
    if (!data.name) throw new HttpError(400, 'Thiếu tên dự án');
    data.created_at = nowIso();
    const keys = Object.keys(data);
    const r = db.prepare(`INSERT INTO projects (${keys.join(', ')}) VALUES (${keys.map(() => '?').join(', ')})`).run(...keys.map((k) => data[k]));
    send(res, 201, { id: Number(r.lastInsertRowid) });
  });

  const getProject = (id) => {
    const p = db.prepare('SELECT * FROM projects WHERE id = ?').get(id);
    if (!p) throw new HttpError(404, 'Không tìm thấy dự án');
    return { ...p };
  };

  route('GET', '/api/projects/:id', (req, res, { params }) => {
    const project = getProject(Number(params.id));
    send(res, 200, { project, matches: matchCustomersForProject(db, project).map((r) => ({ ...r })) });
  });

  route('PUT', '/api/projects/:id', async (req, res, { params }) => {
    getProject(Number(params.id));
    updateRow('projects', Number(params.id), cleanProject(await readBody(req)));
    send(res, 200, { ok: true });
  });

  route('DELETE', '/api/projects/:id', (req, res, { params }) => {
    db.prepare('DELETE FROM projects WHERE id = ?').run(Number(params.id));
    send(res, 200, { ok: true });
  });

  // Đưa khách vào danh sách cần gọi mời dự án
  route('POST', '/api/projects/:id/invite', async (req, res, { params }) => {
    const project = getProject(Number(params.id));
    const { customer_ids = [] } = await readBody(req);
    const ins = db.prepare(`INSERT INTO customer_projects (customer_id, project_id, status, updated_at) VALUES (?, ?, 'can_goi', ?)
      ON CONFLICT(customer_id, project_id) DO NOTHING`);
    let n = 0;
    for (const cid of customer_ids) n += Number(ins.run(Number(cid), project.id, nowIso()).changes);
    send(res, 200, { added: n });
  });

  const INVITE_LABEL = { can_goi: 'Cần gọi', da_moi: 'Đã mời', quan_tam: 'Quan tâm', khong: 'Không quan tâm' };
  route('PUT', '/api/projects/:id/customers/:cid', async (req, res, { params }) => {
    const project = getProject(Number(params.id));
    const cid = Number(params.cid);
    getCustomer(cid);
    const { status, note } = await readBody(req);
    if (!(status in INVITE_LABEL)) throw new HttpError(400, 'Trạng thái không hợp lệ');
    const now = nowIso();
    db.prepare(`INSERT INTO customer_projects (customer_id, project_id, status, updated_at) VALUES (?, ?, ?, ?)
      ON CONFLICT(customer_id, project_id) DO UPDATE SET status = excluded.status, updated_at = excluded.updated_at`)
      .run(cid, project.id, status, now);
    if (status !== 'can_goi') {
      db.prepare(`INSERT INTO activities (customer_id, type, outcome, content, created_at) VALUES (?, 'call', ?, ?, ?)`)
        .run(cid, status === 'quan_tam' ? 'quan_tam' : null, `Mời dự án ${project.name}: ${INVITE_LABEL[status]}${note ? ` – ${note}` : ''}`, now);
      const upd = { last_contact_at: now };
      if (status === 'quan_tam') { upd.temperature = 'nong'; upd.next_follow_up_at = defaultNextFollowUp('quan_tam', 'nong', settings()); upd.next_follow_up_note = `Gửi thông tin ${project.name}`; }
      updateRow('customers', cid, upd);
    }
    send(res, 200, { ok: true });
  });

  route('GET', '/api/scripts', (req, res) => send(res, 200, { groups: SCRIPT_GROUPS, scripts: SCRIPTS }));

  // ---------- báo cáo ----------
  route('GET', '/api/reports', (req, res, { query }) => {
    const days = Math.min(Number(query.get('days')) || 30, 3650);
    const since = new Date(Date.now() - days * 86400000).toISOString();
    const bySource = db.prepare(`SELECT i.source, COUNT(*) AS inquiries, COUNT(DISTINCT i.customer_id) AS customers,
        COUNT(DISTINCT CASE WHEN c.status = 'da_mua' THEN c.id END) AS won,
        COUNT(DISTINCT CASE WHEN c.status IN ('quan_tam','hen_xem','dam_phan') THEN c.id END) AS hot
      FROM inquiries i JOIN customers c ON c.id = i.customer_id WHERE i.created_at >= ?
      GROUP BY i.source ORDER BY inquiries DESC`).all(since);
    const byPage = db.prepare(`SELECT i.source, i.page_url, COUNT(*) AS inquiries, MAX(i.created_at) AS last_at
      FROM inquiries i WHERE i.created_at >= ? AND i.page_url IS NOT NULL
      GROUP BY i.page_url ORDER BY inquiries DESC LIMIT 50`).all(since);
    const byCampaign = db.prepare(`SELECT COALESCE(i.utm_source,'(không)') AS utm_source, COALESCE(i.utm_campaign,'(không)') AS utm_campaign, COUNT(*) AS inquiries
      FROM inquiries i WHERE i.created_at >= ? AND (i.utm_source IS NOT NULL OR i.utm_campaign IS NOT NULL)
      GROUP BY 1, 2 ORDER BY inquiries DESC LIMIT 30`).all(since);
    const byDay = db.prepare(`SELECT substr(datetime(i.created_at, '+7 hours'), 1, 10) AS day, COUNT(*) AS inquiries
      FROM inquiries i WHERE i.created_at >= ? GROUP BY day ORDER BY day`).all(since);
    const byHour = db.prepare(`SELECT CAST(substr(datetime(i.created_at, '+7 hours'), 12, 2) AS INTEGER) AS hour, COUNT(*) AS inquiries
      FROM inquiries i WHERE i.created_at >= ? GROUP BY hour ORDER BY hour`).all(since);
    const byStatus = db.prepare('SELECT status, COUNT(*) AS n FROM customers GROUP BY status').all();
    const calls = db.prepare(`SELECT COUNT(*) AS n FROM activities WHERE type IN ('call','zalo','sms','meeting','site_visit') AND created_at >= ?`).get(since).n;
    const p = (rows) => rows.map((r) => ({ ...r }));
    send(res, 200, { days, bySource: p(bySource), byPage: p(byPage), byCampaign: p(byCampaign), byDay: p(byDay), byHour: p(byHour), byStatus: p(byStatus), calls });
  });

  // ---------- cài đặt ----------
  route('GET', '/api/settings', async (req, res) => {
    const s = settings();
    delete s.generated_password;
    delete s.session_secret;
    s.webhook_key = hookKey();
    s.base_url = baseUrl(req);
    s.ai_enabled = await aiAvailable();
    s.telegram_enabled = Boolean(config.telegramToken && config.telegramChatId);
    send(res, 200, s);
  });

  route('PUT', '/api/settings', async (req, res) => {
    const body = await readBody(req);
    const up = db.prepare('INSERT INTO settings(key, value) VALUES (?, ?) ON CONFLICT(key) DO UPDATE SET value = excluded.value');
    for (const k of Object.keys(DEFAULT_SETTINGS)) if (k in body) up.run(k, String(body[k] ?? ''));
    if (body.regenerate_webhook_key) up.run('webhook_key', crypto.randomBytes(12).toString('hex'));
    send(res, 200, { ok: true });
  });

  // ---------- nhập / xuất ----------
  route('POST', '/api/import', async (req, res) => {
    const { rows = [], source } = await readBody(req);
    let created = 0, merged = 0;
    const errors = [];
    rows.forEach((row, idx) => {
      try {
        const r = ingestLead(db, row, { source: source || row.source || row['Nguồn'] || 'Nhập file' });
        if (r.isNew) created++; else merged++;
      } catch (e) {
        errors.push(`Dòng ${idx + 2}: ${e.message}`);
      }
    });
    send(res, 200, { created, merged, errors: errors.slice(0, 50) });
  });

  route('GET', '/api/export.csv', (req, res) => {
    const rows = db.prepare(`SELECT c.id, c.name, c.salutation, c.phone, c.email, c.status, c.temperature, c.need_type, c.need_purpose,
        c.need_area, c.budget_min, c.budget_max, c.need_timeline, c.need_note, c.tags, c.birthday, c.first_source, c.first_url,
        c.last_contact_at, c.next_follow_up_at, c.created_at FROM customers c ORDER BY c.id`).all();
    const headers = rows[0] ? Object.keys(rows[0]) : ['id'];
    const esc = (v) => (v == null ? '' : /[",\n]/.test(String(v)) ? `"${String(v).replace(/"/g, '""')}"` : String(v));
    const csv = '﻿' + [headers.join(','), ...rows.map((r) => headers.map((h) => esc(r[h])).join(','))].join('\n');
    send(res, 200, csv, {
      'content-type': 'text/csv; charset=utf-8',
      'content-disposition': `attachment; filename="khach-hang-${localDate()}.csv"`,
    });
  });

  // ---------- xử lý request ----------
  return async function handler(req, res) {
    const url = new URL(req.url, 'http://localhost');
    try {
      if (req.method === 'OPTIONS' && url.pathname.startsWith('/api/hook/')) {
        res.writeHead(204, corsHeaders);
        return res.end();
      }
      if (url.pathname.startsWith('/api/')) {
        for (const r of routes) {
          if (r.method !== req.method) continue;
          const m = url.pathname.match(r.re);
          if (!m) continue;
          if (r.auth && !validSession(getCookie(req, 'crm_session'), secret)) throw new HttpError(401, 'Chưa đăng nhập');
          const params = Object.fromEntries(r.keys.map((k, i) => [k, decodeURIComponent(m[i + 1])]));
          return await r.handler(req, res, { params, query: url.searchParams });
        }
        throw new HttpError(404, 'Không có API này');
      }
      // file tĩnh
      let file = path.normalize(path.join(PUBLIC_DIR, url.pathname === '/' ? 'index.html' : url.pathname));
      if (!file.startsWith(PUBLIC_DIR)) throw new HttpError(403, 'Forbidden');
      if (!fs.existsSync(file) || fs.statSync(file).isDirectory()) file = path.join(PUBLIC_DIR, 'index.html');
      const ext = path.extname(file);
      const headers = { 'content-type': MIME[ext] || 'application/octet-stream', 'cache-control': 'no-cache' };
      if (url.pathname === '/tracker.js') headers['access-control-allow-origin'] = '*';
      res.writeHead(200, headers);
      fs.createReadStream(file).pipe(res);
    } catch (e) {
      const status = e.status || 500;
      if (status === 500) console.error(e);
      const headers = url.pathname.startsWith('/api/hook/') ? corsHeaders : {};
      if (!res.headersSent) send(res, status, { ok: false, error: status === 500 ? 'Lỗi máy chủ' : e.message }, headers);
      else res.end();
    }
  };
}

// ---------- khởi động ----------
const isMain = process.argv[1] && path.resolve(process.argv[1]) === fileURLToPath(import.meta.url);
if (isMain) {
  const db = openDb(config.dbPath);
  let password = config.adminPassword;
  if (!password) {
    const s = getSettings(db);
    password = s.generated_password;
    if (!password) {
      password = crypto.randomBytes(6).toString('base64url');
      db.prepare('INSERT OR REPLACE INTO settings(key, value) VALUES (?, ?)').run('generated_password', password);
    }
    console.warn(`⚠️  Chưa đặt ADMIN_PASSWORD. Mật khẩu tạm: ${password}  (hãy đặt ADMIN_PASSWORD trong file .env)`);
  }
  // Giữ phiên đăng nhập qua các lần khởi động lại
  let secret = config.sessionSecret;
  if (!process.env.SESSION_SECRET) {
    const s = getSettings(db);
    secret = s.session_secret || secret;
    if (!s.session_secret) db.prepare('INSERT INTO settings(key, value) VALUES (?, ?)').run('session_secret', secret);
  }
  const app = createApp({ db, password, secret, webhookKey: config.webhookKey });
  http.createServer(app).listen(config.port, () => {
    console.log(`✅ CRM đang chạy: http://localhost:${config.port}`);
  });
}
