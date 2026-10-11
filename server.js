// CRM Hoàng Hiệp – server không cần cài thư viện ngoài (Node >= 22.13, dùng node:sqlite)
import http from 'node:http';
import fs from 'node:fs';
import path from 'node:path';
import crypto from 'node:crypto';
import { DatabaseSync } from 'node:sqlite';
import { fileURLToPath } from 'node:url';

const ROOT = path.dirname(fileURLToPath(import.meta.url));
const DATA_DIR = process.env.DATA_DIR || path.join(ROOT, 'data');
const PORT = Number(process.env.PORT || 3000);
const ADMIN_PASSWORD = process.env.ADMIN_PASSWORD || 'admin123';
fs.mkdirSync(DATA_DIR, { recursive: true });

const db = new DatabaseSync(process.env.DB_FILE || path.join(DATA_DIR, 'crm.db'));
db.exec(`
PRAGMA journal_mode=WAL;
CREATE TABLE IF NOT EXISTS sites(
  id INTEGER PRIMARY KEY, name TEXT NOT NULL, domain TEXT DEFAULT '', site_key TEXT UNIQUE NOT NULL, created_at INTEGER NOT NULL);
CREATE TABLE IF NOT EXISTS visitors(
  vid TEXT PRIMARY KEY, site_id INTEGER, lead_id INTEGER, first_seen INTEGER, last_seen INTEGER,
  first_referrer TEXT, utm_source TEXT, utm_medium TEXT, utm_campaign TEXT, utm_content TEXT, utm_term TEXT);
CREATE TABLE IF NOT EXISTS events(
  id INTEGER PRIMARY KEY, site_id INTEGER NOT NULL, vid TEXT, lead_id INTEGER,
  type TEXT NOT NULL,            -- pageview | click | form
  channel TEXT DEFAULT '',       -- zalo | phone | messenger | sms | other
  url TEXT, referrer TEXT, utm_source TEXT, utm_medium TEXT, utm_campaign TEXT, utm_content TEXT, utm_term TEXT,
  ip TEXT, ua TEXT, created_at INTEGER NOT NULL);
CREATE INDEX IF NOT EXISTS ev_site_time ON events(site_id, created_at);
CREATE INDEX IF NOT EXISTS ev_vid ON events(vid);
CREATE INDEX IF NOT EXISTS ev_lead ON events(lead_id);
CREATE TABLE IF NOT EXISTS leads(
  id INTEGER PRIMARY KEY, site_id INTEGER, name TEXT, phone TEXT UNIQUE, email TEXT, message TEXT,
  status TEXT NOT NULL DEFAULT 'new', assignee TEXT DEFAULT '', note TEXT DEFAULT '',
  utm_source TEXT, utm_medium TEXT, utm_campaign TEXT, first_referrer TEXT,
  submits INTEGER NOT NULL DEFAULT 1, contacted_at INTEGER, created_at INTEGER NOT NULL, updated_at INTEGER NOT NULL);
CREATE INDEX IF NOT EXISTS lead_time ON leads(created_at);
CREATE TABLE IF NOT EXISTS contact_logs(
  id INTEGER PRIMARY KEY, lead_id INTEGER NOT NULL, type TEXT NOT NULL, -- call | zalo | sms | note
  note TEXT DEFAULT '', created_by TEXT DEFAULT '', created_at INTEGER NOT NULL);
CREATE INDEX IF NOT EXISTS log_lead ON contact_logs(lead_id);
CREATE TABLE IF NOT EXISTS campaigns(
  id INTEGER PRIMARY KEY, platform TEXT NOT NULL, name TEXT NOT NULL, utm_campaign TEXT NOT NULL UNIQUE COLLATE NOCASE,
  budget_note TEXT DEFAULT '', status TEXT NOT NULL DEFAULT 'active', created_at INTEGER NOT NULL);
CREATE TABLE IF NOT EXISTS ad_spend(
  campaign_id INTEGER NOT NULL, day TEXT NOT NULL, spend REAL NOT NULL DEFAULT 0, impressions INTEGER NOT NULL DEFAULT 0, clicks INTEGER NOT NULL DEFAULT 0,
  PRIMARY KEY(campaign_id, day));
`);
if (!db.prepare("SELECT 1 FROM pragma_table_info('leads') WHERE name='value'").get()) db.exec('ALTER TABLE leads ADD COLUMN value REAL NOT NULL DEFAULT 0');

const now = () => Date.now();
const STATUSES = ['new', 'contacted', 'interested', 'appointment', 'won', 'lost'];
const PLATFORMS = ['facebook', 'google', 'tiktok', 'zalo', 'other'];
const CHANNELS = ['zalo', 'phone', 'messenger', 'sms', 'other'];

// ---------- helpers ----------
const s = (v, max = 500) => (v == null ? '' : String(v).slice(0, max));
export function normPhone(p) {
  let d = String(p || '').replace(/[^\d+]/g, '');
  if (d.startsWith('+84')) d = '0' + d.slice(3);
  else if (d.startsWith('84') && d.length >= 11) d = '0' + d.slice(2);
  d = d.replace(/\D/g, '');
  return d.length >= 9 && d.length <= 11 ? d : '';
}
const newKey = () => crypto.randomBytes(9).toString('base64url');

let secret;
const secretFile = path.join(DATA_DIR, '.secret');
try { secret = fs.readFileSync(secretFile, 'utf8'); } catch { secret = crypto.randomBytes(32).toString('hex'); fs.writeFileSync(secretFile, secret, { mode: 0o600 }); }
const sign = (v) => crypto.createHmac('sha256', secret).update(v).digest('base64url');
const makeSession = () => { const exp = String(now() + 7 * 864e5); return exp + '.' + sign(exp); };
function validSession(tok) {
  const [exp, sig] = String(tok || '').split('.');
  if (!exp || !sig || Number(exp) < now()) return false;
  const a = Buffer.from(sig), b = Buffer.from(sign(exp));
  return a.length === b.length && crypto.timingSafeEqual(a, b);
}
const cookie = (req, name) => (req.headers.cookie || '').split(/;\s*/).map((c) => c.split('=')).find((c) => c[0] === name)?.[1];
const safeEq = (a, b) => { const x = crypto.createHash('sha256').update(a).digest(), y = crypto.createHash('sha256').update(b).digest(); return crypto.timingSafeEqual(x, y); };

const loginFails = new Map();
const rate = new Map(); // ip -> [count, windowStart]
function limited(ip, max = 120) {
  const t = now(), r = rate.get(ip);
  if (!r || t - r[1] > 60000) { rate.set(ip, [1, t]); return false; }
  return ++r[0] > max;
}
setInterval(() => { const t = now(); for (const [k, v] of rate) if (t - v[1] > 60000) rate.delete(k); for (const [k, v] of loginFails) if (t - v[1] > 600000) loginFails.delete(k); }, 60000).unref();

async function readBody(req) {
  const chunks = []; let n = 0;
  for await (const c of req) { n += c.length; if (n > 100_000) throw Object.assign(new Error('too large'), { code: 413 }); chunks.push(c); }
  const raw = Buffer.concat(chunks).toString('utf8');
  if (!raw) return {};
  const ct = req.headers['content-type'] || '';
  try {
    if (ct.includes('application/x-www-form-urlencoded')) return Object.fromEntries(new URLSearchParams(raw));
    return JSON.parse(raw); // sendBeacon gửi text/plain nhưng nội dung vẫn là JSON
  } catch { return Object.fromEntries(new URLSearchParams(raw)); }
}

function send(res, code, body, headers = {}) {
  const isObj = typeof body === 'object' && !Buffer.isBuffer(body);
  res.writeHead(code, { 'Content-Type': isObj ? 'application/json; charset=utf-8' : 'text/plain; charset=utf-8', 'X-Content-Type-Options': 'nosniff', ...headers });
  res.end(isObj ? JSON.stringify(body) : body);
}
const CORS = { 'Access-Control-Allow-Origin': '*', 'Access-Control-Allow-Methods': 'POST, GET, OPTIONS', 'Access-Control-Allow-Headers': 'Content-Type' };
const clientIp = (req) => (req.headers['x-forwarded-for'] || req.socket.remoteAddress || '').split(',')[0].trim();

// ---------- ghi nhận từ website (public) ----------
const siteByKey = (k) => db.prepare('SELECT * FROM sites WHERE site_key=?').get(String(k || ''));

function touchVisitor(site, b, t) {
  const vid = s(b.vid, 64);
  if (!vid) return null;
  const v = db.prepare('SELECT * FROM visitors WHERE vid=?').get(vid);
  if (!v) {
    db.prepare('INSERT INTO visitors(vid,site_id,first_seen,last_seen,first_referrer,utm_source,utm_medium,utm_campaign,utm_content,utm_term) VALUES(?,?,?,?,?,?,?,?,?,?)')
      .run(vid, site.id, t, t, s(b.referrer), s(b.utm_source, 100), s(b.utm_medium, 100), s(b.utm_campaign, 150), s(b.utm_content, 150), s(b.utm_term, 150));
    return { vid, lead_id: null, utm_source: s(b.utm_source, 100), utm_medium: s(b.utm_medium, 100), utm_campaign: s(b.utm_campaign, 150), first_referrer: s(b.referrer) };
  }
  db.prepare('UPDATE visitors SET last_seen=? WHERE vid=?').run(t, vid);
  return { ...v, first_referrer: v.first_referrer };
}

function addEvent(site, b, type, channel, leadId, ip, ua, t) {
  db.prepare('INSERT INTO events(site_id,vid,lead_id,type,channel,url,referrer,utm_source,utm_medium,utm_campaign,utm_content,utm_term,ip,ua,created_at) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)')
    .run(site.id, s(b.vid, 64) || null, leadId, type, channel, s(b.url, 600), s(b.referrer, 600), s(b.utm_source, 100), s(b.utm_medium, 100), s(b.utm_campaign, 150), s(b.utm_content, 150), s(b.utm_term, 150), ip, s(ua, 300), t);
}

function handleTrack(b, ip, ua) {
  const site = siteByKey(b.key);
  if (!site) return { code: 404, body: { error: 'site_key không hợp lệ' } };
  const t = now();
  const type = ['pageview', 'click'].includes(b.type) ? b.type : null;
  if (!type) return { code: 400, body: { error: 'type không hợp lệ' } };
  const v = touchVisitor(site, b, t);
  const channel = type === 'click' ? (CHANNELS.includes(b.channel) ? b.channel : 'other') : '';
  addEvent(site, b, type, channel, v?.lead_id ?? null, ip, ua, t);
  return { code: 200, body: { ok: true } };
}

function handleLead(b, ip, ua) {
  const site = siteByKey(b.key);
  if (!site) return { code: 404, body: { error: 'site_key không hợp lệ' } };
  const phone = normPhone(b.phone);
  if (!phone) return { code: 400, body: { error: 'Số điện thoại không hợp lệ' } };
  const t = now();
  const v = touchVisitor(site, b, t);
  const name = s(b.name, 120), email = s(b.email, 160), message = s(b.message, 1000);
  let lead = db.prepare('SELECT * FROM leads WHERE phone=?').get(phone);
  let isNew = false;
  if (lead) {
    db.prepare('UPDATE leads SET submits=submits+1, updated_at=?, name=COALESCE(NULLIF(name,\'\'),?), email=COALESCE(NULLIF(email,\'\'),?), message=CASE WHEN ?<>\'\' THEN ? ELSE message END WHERE id=?')
      .run(t, name, email, message, message, lead.id);
  } else {
    isNew = true;
    const id = db.prepare('INSERT INTO leads(site_id,name,phone,email,message,utm_source,utm_medium,utm_campaign,first_referrer,created_at,updated_at) VALUES(?,?,?,?,?,?,?,?,?,?,?)')
      .run(site.id, name, phone, email, message, v?.utm_source || s(b.utm_source, 100), v?.utm_medium || s(b.utm_medium, 100), v?.utm_campaign || s(b.utm_campaign, 150), v?.first_referrer || s(b.referrer), t, t).lastInsertRowid;
    lead = { id: Number(id) };
  }
  if (v) {
    db.prepare('UPDATE visitors SET lead_id=? WHERE vid=?').run(lead.id, v.vid);
    db.prepare('UPDATE events SET lead_id=? WHERE vid=? AND lead_id IS NULL').run(lead.id, v.vid); // gắn lại lịch sử click trước đó
  }
  addEvent(site, b, 'form', '', lead.id, ip, ua, t);
  return { code: 200, body: { ok: true, lead_id: lead.id, new: isNew } };
}

// ---------- chiến dịch ads ----------
function campaignReport(q) {
  const { days, since } = sinceOf(q);
  const sinceDay = new Date(since + 7 * 3600e3).toISOString().slice(0, 10);
  const rows = db.prepare(`
    SELECT c.*,
      COALESCE((SELECT SUM(spend) FROM ad_spend a WHERE a.campaign_id=c.id AND a.day>=?2),0) spend,
      COALESCE((SELECT SUM(impressions) FROM ad_spend a WHERE a.campaign_id=c.id AND a.day>=?2),0) impressions,
      COALESCE((SELECT SUM(clicks) FROM ad_spend a WHERE a.campaign_id=c.id AND a.day>=?2),0) ad_clicks,
      (SELECT COUNT(DISTINCT vid) FROM events e WHERE e.type='pageview' AND e.utm_campaign=c.utm_campaign COLLATE NOCASE AND e.created_at>=?1) visitors,
      (SELECT COUNT(*) FROM events e WHERE e.type='click' AND e.channel='zalo' AND e.utm_campaign=c.utm_campaign COLLATE NOCASE AND e.created_at>=?1) zalo,
      (SELECT COUNT(*) FROM events e WHERE e.type='click' AND e.channel='phone' AND e.utm_campaign=c.utm_campaign COLLATE NOCASE AND e.created_at>=?1) phone,
      (SELECT COUNT(*) FROM leads l WHERE l.utm_campaign=c.utm_campaign COLLATE NOCASE AND l.created_at>=?1) leads,
      (SELECT COUNT(*) FROM leads l WHERE l.utm_campaign=c.utm_campaign COLLATE NOCASE AND l.created_at>=?1 AND l.contacted_at IS NULL AND l.status='new') uncontacted,
      (SELECT COUNT(*) FROM leads l WHERE l.utm_campaign=c.utm_campaign COLLATE NOCASE AND l.created_at>=?1 AND l.status='won') won,
      COALESCE((SELECT SUM(value) FROM leads l WHERE l.utm_campaign=c.utm_campaign COLLATE NOCASE AND l.created_at>=?1 AND l.status='won'),0) revenue
    FROM campaigns c ORDER BY spend DESC, leads DESC`).all(since, sinceDay);
  for (const r of rows) {
    r.cpl = r.leads ? Math.round(r.spend / r.leads) : null;
    r.cost_per_action = r.leads + r.zalo + r.phone ? Math.round(r.spend / (r.leads + r.zalo + r.phone)) : null;
    r.cost_per_won = r.won ? Math.round(r.spend / r.won) : null;
    r.roas = r.spend ? +(r.revenue / r.spend).toFixed(2) : null;
  }
  const unmapped = db.prepare(`SELECT COALESCE(NULLIF(utm_source,''),'?') source, utm_campaign, COUNT(*) leads FROM leads
    WHERE created_at>=? AND utm_campaign<>'' AND utm_campaign NOT IN (SELECT utm_campaign FROM campaigns) GROUP BY source, utm_campaign ORDER BY leads DESC LIMIT 20`).all(since);
  return { days, campaigns: rows, unmapped };
}
const validDay = (d) => /^\d{4}-\d{2}-\d{2}$/.test(d) && !isNaN(Date.parse(d));
function upsertSpend(cid, day, spend, impressions, clicks) {
  db.prepare(`INSERT INTO ad_spend(campaign_id,day,spend,impressions,clicks) VALUES(?,?,?,?,?)
    ON CONFLICT(campaign_id,day) DO UPDATE SET spend=excluded.spend, impressions=excluded.impressions, clicks=excluded.clicks`)
    .run(cid, day, Math.max(0, Number(spend) || 0), Math.max(0, parseInt(impressions, 10) || 0), Math.max(0, parseInt(clicks, 10) || 0));
}

// ---------- API quản trị ----------
const dayExpr = "strftime('%Y-%m-%d', created_at/1000 + 25200, 'unixepoch')"; // UTC+7
function sinceOf(q) { const d = Math.min(Math.max(parseInt(q.get('days') || '7', 10) || 7, 1), 365); return { days: d, since: now() - d * 864e5 }; }

function stats(q) {
  const { days, since } = sinceOf(q);
  const sites = db.prepare(`
    SELECT st.id, st.name, st.domain,
      (SELECT COUNT(DISTINCT vid) FROM events e WHERE e.site_id=st.id AND e.type='pageview' AND e.created_at>=?1) visitors,
      (SELECT COUNT(*) FROM events e WHERE e.site_id=st.id AND e.type='click' AND e.channel='zalo' AND e.created_at>=?1) zalo,
      (SELECT COUNT(*) FROM events e WHERE e.site_id=st.id AND e.type='click' AND e.channel='phone' AND e.created_at>=?1) phone,
      (SELECT COUNT(*) FROM events e WHERE e.site_id=st.id AND e.type='click' AND e.channel='messenger' AND e.created_at>=?1) messenger,
      (SELECT COUNT(*) FROM leads l WHERE l.site_id=st.id AND l.created_at>=?1) leads,
      (SELECT COUNT(DISTINCT vid) FROM events e WHERE e.site_id=st.id AND e.type IN ('click','form') AND e.created_at>=?1) engaged,
      (SELECT COUNT(*) FROM leads l WHERE l.site_id=st.id AND l.contacted_at IS NULL AND l.status='new') uncontacted
    FROM sites st ORDER BY leads DESC, visitors DESC`).all(since);
  const daily = db.prepare(`
    SELECT ${dayExpr} day,
      COUNT(DISTINCT CASE WHEN type='pageview' THEN vid END) visitors,
      SUM(type='click' AND channel='zalo') zalo, SUM(type='click' AND channel='phone') phone,
      SUM(type='click' AND channel='messenger') messenger, SUM(type='form') leads
    FROM events WHERE created_at>=? GROUP BY day ORDER BY day`).all(since);
  const utm = db.prepare(`SELECT COALESCE(NULLIF(utm_source,''),'(trực tiếp / không rõ)') source, COALESCE(NULLIF(utm_campaign,''),'') campaign, COUNT(*) leads
    FROM leads WHERE created_at>=? GROUP BY source, campaign ORDER BY leads DESC LIMIT 15`).all(since);
  const contact = db.prepare(`SELECT
      SUM(contacted_at IS NULL AND status='new') uncontacted, SUM(contacted_at IS NOT NULL) contacted, COUNT(*) total,
      AVG(CASE WHEN contacted_at IS NOT NULL THEN (contacted_at-created_at)/60000.0 END) avg_response_min
    FROM leads WHERE created_at>=?`).get(since);
  const anon = db.prepare(`SELECT COUNT(DISTINCT vid) n FROM events WHERE type='click' AND lead_id IS NULL AND created_at>=?`).get(since).n;
  const total = (k) => sites.reduce((a, x) => a + (x[k] || 0), 0);
  return {
    days, sites, daily, utm,
    totals: { visitors: total('visitors'), zalo: total('zalo'), phone: total('phone'), messenger: total('messenger'), leads: total('leads') },
    contact: { uncontacted: contact.uncontacted || 0, contacted: contact.contacted || 0, total: contact.total || 0, avg_response_min: contact.avg_response_min == null ? null : Math.round(contact.avg_response_min) },
    anonymous_clickers: anon,
    all_time_uncontacted: db.prepare("SELECT COUNT(*) n FROM leads WHERE contacted_at IS NULL AND status='new'").get().n,
  };
}

const LEAD_SELECT = `SELECT l.*, st.name site_name, st.domain site_domain,
  (SELECT COUNT(*) FROM events e WHERE e.lead_id=l.id AND e.type='click' AND e.channel='zalo') clicked_zalo,
  (SELECT COUNT(*) FROM events e WHERE e.lead_id=l.id AND e.type='click' AND e.channel='phone') clicked_phone,
  (SELECT COUNT(*) FROM events e WHERE e.lead_id=l.id AND e.type='click' AND e.channel='messenger') clicked_messenger,
  (SELECT COUNT(*) FROM contact_logs c WHERE c.lead_id=l.id AND c.type='call') called,
  (SELECT COUNT(*) FROM contact_logs c WHERE c.lead_id=l.id AND c.type IN ('zalo','sms')) messaged
  FROM leads l LEFT JOIN sites st ON st.id=l.site_id`;

function listLeads(q) {
  const where = [], args = [];
  const status = q.get('status');
  if (status === 'uncontacted') where.push("l.contacted_at IS NULL AND l.status='new'");
  else if (STATUSES.includes(status)) { where.push('l.status=?'); args.push(status); }
  if (q.get('site')) { where.push('l.site_id=?'); args.push(Number(q.get('site'))); }
  if (q.get('days')) { where.push('l.created_at>=?'); args.push(sinceOf(q).since); }
  const text = (q.get('q') || '').trim();
  if (text) { where.push("(l.name LIKE ? OR l.phone LIKE ? OR l.email LIKE ?)"); const like = `%${text.replace(/[%_]/g, '')}%`; args.push(like, like, like); }
  const limit = Math.min(parseInt(q.get('limit') || '200', 10) || 200, 5000);
  return db.prepare(`${LEAD_SELECT} ${where.length ? 'WHERE ' + where.join(' AND ') : ''} ORDER BY (l.contacted_at IS NULL AND l.status='new') DESC, l.created_at DESC LIMIT ?`).all(...args, limit);
}

function leadDetail(id) {
  const lead = db.prepare(`${LEAD_SELECT} WHERE l.id=?`).get(id);
  if (!lead) return null;
  const events = db.prepare(`SELECT e.type, e.channel, e.url, e.referrer, e.utm_source, e.utm_campaign, e.created_at, st.name site_name FROM events e LEFT JOIN sites st ON st.id=e.site_id WHERE e.lead_id=? ORDER BY e.created_at DESC LIMIT 200`).all(id);
  const logs = db.prepare('SELECT * FROM contact_logs WHERE lead_id=? ORDER BY created_at DESC').all(id);
  return { lead, events, logs };
}

function anonymousClicks(q) {
  const { since } = sinceOf(q);
  return db.prepare(`SELECT e.vid, st.name site_name, e.channel, e.url, e.utm_source, e.utm_campaign, e.created_at,
      (SELECT COUNT(*) FROM events x WHERE x.vid=e.vid AND x.type='pageview') pages
    FROM events e LEFT JOIN sites st ON st.id=e.site_id
    WHERE e.type='click' AND e.lead_id IS NULL AND e.created_at>=? ORDER BY e.created_at DESC LIMIT 300`).all(since);
}

const csvCell = (v) => { v = v == null ? '' : String(v); if (/^[=+\-@\t\r]/.test(v)) v = "'" + v; return /[",\n]/.test(v) ? '"' + v.replace(/"/g, '""') + '"' : v; };
function leadsCsv(q) {
  const rows = listLeads(q);
  const head = ['id', 'Ngày', 'Tên', 'SĐT', 'Email', 'Website', 'Nguồn', 'Chiến dịch', 'Trạng thái', 'Đã liên hệ', 'Bấm Zalo', 'Bấm Gọi', 'Phụ trách', 'Ghi chú'];
  const lines = [head.join(',')].concat(rows.map((r) => [r.id, new Date(r.created_at).toISOString(), r.name, r.phone, r.email, r.site_name, r.utm_source, r.utm_campaign, r.status, r.contacted_at ? 'có' : 'chưa', r.clicked_zalo, r.clicked_phone, r.assignee, r.note].map(csvCell).join(',')));
  return '﻿' + lines.join('\n');
}

async function handleAdmin(req, res, url) {
  const m = req.method, p = url.pathname, q = url.searchParams;
  let mt;
  if (m === 'GET' && p === '/api/stats') return send(res, 200, stats(q));
  if (m === 'GET' && p === '/api/leads') return send(res, 200, listLeads(q));
  if (m === 'GET' && p === '/api/leads.csv') return send(res, 200, leadsCsv(q), { 'Content-Type': 'text/csv; charset=utf-8', 'Content-Disposition': 'attachment; filename="khach-hang.csv"' });
  if (m === 'GET' && p === '/api/anonymous-clicks') return send(res, 200, anonymousClicks(q));
  if (m === 'GET' && p === '/api/campaigns') return send(res, 200, campaignReport(q));
  if (m === 'POST' && p === '/api/campaigns') {
    const b = await readBody(req), utm = s(b.utm_campaign, 150).trim();
    if (!s(b.name).trim() || !utm || !PLATFORMS.includes(b.platform)) return send(res, 400, { error: 'Cần nền tảng, tên và mã utm_campaign' });
    if (db.prepare('SELECT 1 FROM campaigns WHERE utm_campaign=?').get(utm)) return send(res, 400, { error: 'Mã utm_campaign đã tồn tại' });
    const id = db.prepare('INSERT INTO campaigns(platform,name,utm_campaign,budget_note,created_at) VALUES(?,?,?,?,?)').run(b.platform, s(b.name, 150).trim(), utm, s(b.budget_note, 200), now()).lastInsertRowid;
    return send(res, 200, { id: Number(id) });
  }
  if ((mt = p.match(/^\/api\/campaigns\/(\d+)$/))) {
    const id = Number(mt[1]);
    if (m === 'DELETE') { db.prepare('DELETE FROM ad_spend WHERE campaign_id=?').run(id); db.prepare('DELETE FROM campaigns WHERE id=?').run(id); return send(res, 200, { ok: true }); }
    if (m === 'PATCH') { const b = await readBody(req); if (b.status && !['active', 'paused'].includes(b.status)) return send(res, 400, { error: 'Trạng thái không hợp lệ' }); db.prepare('UPDATE campaigns SET status=COALESCE(?,status) WHERE id=?').run(b.status ?? null, id); return send(res, 200, { ok: true }); }
  }
  if ((mt = p.match(/^\/api\/campaigns\/(\d+)\/spend$/)) && m === 'POST') {
    const b = await readBody(req), id = Number(mt[1]);
    if (!db.prepare('SELECT 1 FROM campaigns WHERE id=?').get(id)) return send(res, 404, { error: 'Không tìm thấy' });
    if (!validDay(b.day)) return send(res, 400, { error: 'Ngày không hợp lệ (YYYY-MM-DD)' });
    upsertSpend(id, b.day, b.spend, b.impressions, b.clicks);
    return send(res, 200, { ok: true });
  }
  if (m === 'POST' && p === '/api/spend/import') { // CSV: utm_campaign,ngày,chi phí[,hiển thị,click] – dán từ báo cáo FB/Google
    const b = await readBody(req); let ok = 0; const bad = [];
    for (const [i, line] of String(b.csv || '').split(/\r?\n/).entries()) {
      if (!line.trim()) continue;
      const [utm, day, spend, imp, clk] = line.split(/[,;\t]/).map((x) => x.trim());
      const c = db.prepare('SELECT id FROM campaigns WHERE utm_campaign=?').get(utm || '');
      if (!c || !validDay(day) || isNaN(Number(String(spend).replace(/[.,](?=\d{3}\b)/g, '')))) { if (i || validDay(day)) bad.push(i + 1); continue; }
      upsertSpend(c.id, day, String(spend).replace(/[.,](?=\d{3}\b)/g, ''), imp, clk); ok++;
    }
    return send(res, 200, { imported: ok, bad_lines: bad.slice(0, 20) });
  }
  if (m === 'GET' && p === '/api/sites') return send(res, 200, db.prepare('SELECT * FROM sites ORDER BY id').all());
  if (m === 'POST' && p === '/api/sites') {
    const b = await readBody(req);
    if (!s(b.name).trim()) return send(res, 400, { error: 'Thiếu tên website' });
    const key = newKey();
    const id = db.prepare('INSERT INTO sites(name,domain,site_key,created_at) VALUES(?,?,?,?)').run(s(b.name, 100).trim(), s(b.domain, 200).trim(), key, now()).lastInsertRowid;
    return send(res, 200, { id: Number(id), site_key: key });
  }
  if ((mt = p.match(/^\/api\/sites\/(\d+)$/)) && m === 'DELETE') {
    const id = Number(mt[1]);
    if (db.prepare('SELECT COUNT(*) n FROM leads WHERE site_id=?').get(id).n) return send(res, 400, { error: 'Website đã có khách hàng, không thể xoá' });
    db.prepare('DELETE FROM events WHERE site_id=?').run(id); db.prepare('DELETE FROM visitors WHERE site_id=?').run(id); db.prepare('DELETE FROM sites WHERE id=?').run(id);
    return send(res, 200, { ok: true });
  }
  if (m === 'POST' && p === '/api/leads') { // nhập tay (khách gọi tới, khách vãng lai...)
    const b = await readBody(req);
    const phone = normPhone(b.phone);
    if (!phone) return send(res, 400, { error: 'Số điện thoại không hợp lệ' });
    if (db.prepare('SELECT 1 FROM leads WHERE phone=?').get(phone)) return send(res, 400, { error: 'Số điện thoại đã tồn tại' });
    const t = now(), siteId = Number(b.site_id) || db.prepare('SELECT id FROM sites ORDER BY id LIMIT 1').get()?.id || null;
    const id = db.prepare("INSERT INTO leads(site_id,name,phone,email,message,utm_source,created_at,updated_at) VALUES(?,?,?,?,?,'nhập tay',?,?)").run(siteId, s(b.name, 120), phone, s(b.email, 160), s(b.message, 1000), t, t).lastInsertRowid;
    return send(res, 200, { id: Number(id) });
  }
  if ((mt = p.match(/^\/api\/leads\/(\d+)$/))) {
    const id = Number(mt[1]);
    if (m === 'GET') { const d = leadDetail(id); return d ? send(res, 200, d) : send(res, 404, { error: 'Không tìm thấy' }); }
    if (m === 'PATCH') {
      const b = await readBody(req);
      if (!db.prepare('SELECT 1 FROM leads WHERE id=?').get(id)) return send(res, 404, { error: 'Không tìm thấy' });
      if (b.status !== undefined && !STATUSES.includes(b.status)) return send(res, 400, { error: 'Trạng thái không hợp lệ' });
      db.prepare('UPDATE leads SET status=COALESCE(?,status), assignee=COALESCE(?,assignee), note=COALESCE(?,note), name=COALESCE(?,name), value=COALESCE(?,value), updated_at=? WHERE id=?')
        .run(b.status ?? null, b.assignee == null ? null : s(b.assignee, 80), b.note == null ? null : s(b.note, 2000), b.name == null ? null : s(b.name, 120), b.value == null || b.value === '' ? null : Math.max(0, Number(b.value) || 0), now(), id);
      return send(res, 200, { ok: true });
    }
    if (m === 'DELETE') { db.prepare('DELETE FROM contact_logs WHERE lead_id=?').run(id); db.prepare('UPDATE events SET lead_id=NULL WHERE lead_id=?').run(id); db.prepare('UPDATE visitors SET lead_id=NULL WHERE lead_id=?').run(id); db.prepare('DELETE FROM leads WHERE id=?').run(id); return send(res, 200, { ok: true }); }
  }
  if ((mt = p.match(/^\/api\/leads\/(\d+)\/log$/)) && m === 'POST') {
    const id = Number(mt[1]), b = await readBody(req);
    if (!['call', 'zalo', 'sms', 'note'].includes(b.type)) return send(res, 400, { error: 'Loại không hợp lệ' });
    if (!db.prepare('SELECT 1 FROM leads WHERE id=?').get(id)) return send(res, 404, { error: 'Không tìm thấy' });
    const t = now();
    db.prepare('INSERT INTO contact_logs(lead_id,type,note,created_by,created_at) VALUES(?,?,?,?,?)').run(id, b.type, s(b.note, 1000), s(b.by, 80), t);
    if (b.type !== 'note') db.prepare("UPDATE leads SET contacted_at=COALESCE(contacted_at,?), status=CASE WHEN status='new' THEN 'contacted' ELSE status END, updated_at=? WHERE id=?").run(t, t, id);
    return send(res, 200, { ok: true });
  }
  return send(res, 404, { error: 'not found' });
}

// ---------- static ----------
const MIME = { '.html': 'text/html; charset=utf-8', '.js': 'text/javascript; charset=utf-8', '.css': 'text/css', '.svg': 'image/svg+xml', '.ico': 'image/x-icon' };
function serveStatic(res, p) {
  if (p === '/') p = '/index.html';
  const file = path.normalize(path.join(ROOT, 'public', p));
  if (!file.startsWith(path.join(ROOT, 'public') + path.sep) || !fs.existsSync(file) || !fs.statSync(file).isFile()) return send(res, 404, 'Not found');
  const headers = { 'Content-Type': MIME[path.extname(file)] || 'application/octet-stream' };
  if (p === '/track.js') Object.assign(headers, CORS, { 'Cache-Control': 'public, max-age=300' });
  else headers['Cache-Control'] = 'no-cache';
  res.writeHead(200, headers);
  fs.createReadStream(file).pipe(res);
}

export const server = http.createServer(async (req, res) => {
  try {
    const url = new URL(req.url, 'http://x');
    const p = url.pathname, ip = clientIp(req);
    if (req.method === 'OPTIONS') { res.writeHead(204, CORS); return res.end(); }

    // Public: nhận dữ liệu từ website
    if (req.method === 'POST' && (p === '/api/track' || p === '/api/lead')) {
      if (limited(ip, p === '/api/lead' ? 30 : 240)) return send(res, 429, { error: 'Too many requests' }, CORS);
      const b = await readBody(req);
      if (!b.key && url.searchParams.get('key')) b.key = url.searchParams.get('key'); // webhook: /api/lead?key=...
      const r = (p === '/api/track' ? handleTrack : handleLead)(b, ip, req.headers['user-agent']);
      return send(res, r.code, r.body, CORS);
    }
    // Đăng nhập
    if (req.method === 'POST' && p === '/api/login') {
      const f = loginFails.get(ip) || [0, now()];
      if (f[0] >= 8 && now() - f[1] < 600000) return send(res, 429, { error: 'Thử lại sau 10 phút' });
      const b = await readBody(req);
      if (safeEq(String(b.password || ''), ADMIN_PASSWORD)) {
        loginFails.delete(ip);
        return send(res, 200, { ok: true }, { 'Set-Cookie': `crm_session=${makeSession()}; HttpOnly; SameSite=Strict; Path=/; Max-Age=604800${req.headers['x-forwarded-proto'] === 'https' ? '; Secure' : ''}` });
      }
      loginFails.set(ip, [f[0] + 1, f[0] ? f[1] : now()]);
      return send(res, 401, { error: 'Sai mật khẩu' });
    }
    if (req.method === 'POST' && p === '/api/logout') return send(res, 200, { ok: true }, { 'Set-Cookie': 'crm_session=; Path=/; Max-Age=0' });

    if (p.startsWith('/api/')) {
      if (!validSession(cookie(req, 'crm_session'))) return send(res, 401, { error: 'Chưa đăng nhập' });
      // chống CSRF: các thao tác ghi phải cùng origin
      if (req.method !== 'GET' && req.headers.origin && new URL(req.headers.origin).host !== req.headers.host) return send(res, 403, { error: 'Forbidden' });
      return await handleAdmin(req, res, url);
    }
    if (req.method !== 'GET') return send(res, 405, 'Method not allowed');
    return serveStatic(res, p);
  } catch (e) {
    if (e.code === 413) return send(res, 413, { error: 'Payload too large' });
    console.error(e);
    send(res, 500, { error: 'Lỗi máy chủ' });
  }
});

if (process.argv[1] === fileURLToPath(import.meta.url)) {
  server.listen(PORT, process.env.HOST || '0.0.0.0', () => {
    console.log(`CRM chạy tại http://localhost:${PORT}`);
    if (!process.env.ADMIN_PASSWORD) console.warn('⚠ Đang dùng mật khẩu mặc định "admin123" – hãy đặt ADMIN_PASSWORD!');
  });
}
