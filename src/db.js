import fs from 'node:fs';
import path from 'node:path';
import crypto from 'node:crypto';
import { DatabaseSync } from 'node:sqlite';

const SCHEMA = `
CREATE TABLE IF NOT EXISTS customers (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name TEXT NOT NULL DEFAULT '',
  salutation TEXT NOT NULL DEFAULT '',          -- anh / chị / cô / chú ...
  phone TEXT UNIQUE,                            -- đã chuẩn hoá 0xxxxxxxxx
  email TEXT,
  zalo TEXT,
  birthday TEXT,                                -- YYYY-MM-DD hoặc --MM-DD
  job TEXT,
  address TEXT,
  status TEXT NOT NULL DEFAULT 'moi',
  temperature TEXT NOT NULL DEFAULT 'am',       -- nong / am / lanh
  need_type TEXT,                               -- căn hộ, đất nền, nhà phố...
  need_purpose TEXT,                            -- o / dau_tu / cho_thue
  need_area TEXT,                               -- khu vực quan tâm
  budget_min REAL,                              -- tỷ đồng
  budget_max REAL,
  need_timeline TEXT,                           -- khi nào mua
  need_note TEXT,
  best_call_time TEXT,                          -- giờ tiện gọi
  notify_new_projects INTEGER NOT NULL DEFAULT 1,
  do_not_call INTEGER NOT NULL DEFAULT 0,
  tags TEXT,
  personal_note TEXT,                           -- gia đình, sở thích... để bắt chuyện
  first_source TEXT,
  first_url TEXT,
  last_inquiry_at TEXT,
  last_contact_at TEXT,
  next_follow_up_at TEXT,
  next_follow_up_note TEXT,
  created_at TEXT NOT NULL,
  updated_at TEXT NOT NULL
);
CREATE INDEX IF NOT EXISTS idx_customers_email ON customers(email);
CREATE INDEX IF NOT EXISTS idx_customers_follow ON customers(next_follow_up_at);

CREATE TABLE IF NOT EXISTS inquiries (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  customer_id INTEGER NOT NULL REFERENCES customers(id) ON DELETE CASCADE,
  source TEXT,                                  -- tên miền / nguồn
  page_url TEXT,
  page_title TEXT,
  referrer TEXT,
  utm_source TEXT, utm_medium TEXT, utm_campaign TEXT, utm_content TEXT, utm_term TEXT,
  gclid TEXT, fbclid TEXT,
  form_name TEXT,
  project TEXT,
  message TEXT,
  ip TEXT,
  user_agent TEXT,
  raw_json TEXT,
  created_at TEXT NOT NULL
);
CREATE INDEX IF NOT EXISTS idx_inquiries_customer ON inquiries(customer_id);
CREATE INDEX IF NOT EXISTS idx_inquiries_created ON inquiries(created_at);

CREATE TABLE IF NOT EXISTS activities (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  customer_id INTEGER NOT NULL REFERENCES customers(id) ON DELETE CASCADE,
  type TEXT NOT NULL,                           -- call / zalo / sms / email / meeting / site_visit / note / system
  outcome TEXT,
  content TEXT,
  created_at TEXT NOT NULL
);
CREATE INDEX IF NOT EXISTS idx_activities_customer ON activities(customer_id);

CREATE TABLE IF NOT EXISTS projects (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name TEXT NOT NULL,
  developer TEXT,
  location TEXT,
  area TEXT,
  type TEXT,
  price_from REAL,
  price_to REAL,
  launch_date TEXT,
  status TEXT NOT NULL DEFAULT 'sap_mo',        -- sap_mo / dang_ban / ngung
  highlights TEXT,
  link TEXT,
  created_at TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS customer_projects (
  customer_id INTEGER NOT NULL REFERENCES customers(id) ON DELETE CASCADE,
  project_id INTEGER NOT NULL REFERENCES projects(id) ON DELETE CASCADE,
  status TEXT NOT NULL DEFAULT 'can_goi',       -- can_goi / da_moi / quan_tam / khong
  updated_at TEXT NOT NULL,
  PRIMARY KEY (customer_id, project_id)
);

CREATE TABLE IF NOT EXISTS settings (
  key TEXT PRIMARY KEY,
  value TEXT
);
`;

export const DEFAULT_SETTINGS = {
  sales_name: 'Hiệp',
  company: 'Hoàng Gia Minh',
  sales_phone: '',
  sla_minutes: '15',
  cadence_nong: '3',
  cadence_am: '7',
  cadence_lanh: '30',
  cadence_da_mua: '60',
};

export function openDb(file) {
  if (file !== ':memory:') fs.mkdirSync(path.dirname(file), { recursive: true });
  const db = new DatabaseSync(file);
  db.exec('PRAGMA journal_mode = WAL; PRAGMA foreign_keys = ON;');
  db.exec(SCHEMA);
  const ins = db.prepare('INSERT OR IGNORE INTO settings(key, value) VALUES (?, ?)');
  for (const [k, v] of Object.entries(DEFAULT_SETTINGS)) ins.run(k, v);
  ins.run('webhook_key', crypto.randomBytes(12).toString('hex'));
  return db;
}

export function getSettings(db) {
  const out = {};
  for (const r of db.prepare('SELECT key, value FROM settings').all()) out[r.key] = r.value;
  return out;
}

export function nowIso() {
  return new Date().toISOString();
}

// Bỏ các prototype null của node:sqlite để JSON hoá gọn
export function plain(row) {
  return row ? { ...row } : row;
}
