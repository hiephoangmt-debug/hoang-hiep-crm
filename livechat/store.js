// Lưu hội thoại vào file JSON (đủ cho quy mô 1 dự án, không cần database).
const fs = require('fs');
const path = require('path');

// Trên Render: đặt DATA_DIR trỏ tới ổ đĩa lưu trữ (Disk) để không mất dữ liệu khi khởi động lại.
const DATA_DIR = process.env.DATA_DIR || path.join(__dirname, 'data');
const DATA_FILE = path.join(DATA_DIR, 'conversations.json');

let conversations = {};
let saveTimer = null;

function load() {
  try {
    conversations = JSON.parse(fs.readFileSync(DATA_FILE, 'utf8'));
  } catch {
    conversations = {};
  }
}

function save() {
  clearTimeout(saveTimer);
  saveTimer = setTimeout(() => {
    fs.mkdirSync(DATA_DIR, { recursive: true });
    const tmp = DATA_FILE + '.tmp';
    fs.writeFileSync(tmp, JSON.stringify(conversations, null, 2));
    fs.renameSync(tmp, DATA_FILE);
  }, 300);
}

function get(id) {
  return conversations[id];
}

function ensure(id, meta = {}) {
  if (!conversations[id]) {
    conversations[id] = {
      id,
      createdAt: Date.now(),
      updatedAt: Date.now(),
      status: 'new', // new | contacted | closed
      lead: { name: '', phone: '', note: '' },
      page: meta.page || '',
      referrer: meta.referrer || '',
      unread: 0,
      messages: [],
    };
    save();
  }
  return conversations[id];
}

function addMessage(id, msg) {
  const c = conversations[id];
  const m = { id: Date.now().toString(36) + Math.random().toString(36).slice(2, 6), at: Date.now(), ...msg };
  c.messages.push(m);
  c.updatedAt = m.at;
  if (msg.from === 'visitor') c.unread += 1;
  save();
  return m;
}

function update(id, fields) {
  Object.assign(conversations[id], fields);
  save();
  return conversations[id];
}

function summary(c) {
  const last = c.messages[c.messages.length - 1];
  return {
    id: c.id,
    createdAt: c.createdAt,
    updatedAt: c.updatedAt,
    status: c.status,
    lead: c.lead,
    page: c.page,
    unread: c.unread,
    lastMessage: last ? { from: last.from, text: last.text, at: last.at } : null,
  };
}

function list() {
  return Object.values(conversations).map(summary).sort((a, b) => b.updatedAt - a.updatedAt);
}

load();

module.exports = { get, ensure, addMessage, update, summary, list };
