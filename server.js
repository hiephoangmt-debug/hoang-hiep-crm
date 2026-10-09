// Hoàng Hiệp CRM – Kho ảnh AI & phân phối cho nhân viên đăng Facebook
const express = require('express');
const multer = require('multer');
const fs = require('fs');
const path = require('path');
const crypto = require('crypto');

const DATA_DIR = process.env.DATA_DIR || path.join(__dirname, 'data');
const UPLOAD_DIR = process.env.UPLOAD_DIR || path.join(__dirname, 'uploads');
const DB_FILE = path.join(DATA_DIR, 'db.json');
const MAX_FILE_MB = 15;
const ALLOWED_TYPES = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];

fs.mkdirSync(DATA_DIR, { recursive: true });
fs.mkdirSync(UPLOAD_DIR, { recursive: true });

// ---- Lưu trữ JSON đơn giản ----
function emptyDb() {
  return { staff: [], images: [], assignments: [] };
}

function loadDb() {
  if (!fs.existsSync(DB_FILE)) return emptyDb();
  return { ...emptyDb(), ...JSON.parse(fs.readFileSync(DB_FILE, 'utf8')) };
}

let db = loadDb();

function saveDb() {
  const tmp = DB_FILE + '.tmp';
  fs.writeFileSync(tmp, JSON.stringify(db, null, 2));
  fs.renameSync(tmp, DB_FILE);
}

const newId = () => crypto.randomUUID();
const now = () => new Date().toISOString();

// Giao ảnh cho nhân viên (bỏ qua nếu đã giao rồi)
function assign(imageId, staffId) {
  const exists = db.assignments.some((a) => a.imageId === imageId && a.staffId === staffId);
  if (exists) return 0;
  db.assignments.push({
    id: newId(),
    imageId,
    staffId,
    status: 'pending', // pending | posted
    postUrl: '',
    postedAt: null,
    createdAt: now(),
  });
  return 1;
}

// Chỉ chấp nhận link http(s) để tránh chèn javascript: vào href
function cleanUrl(value) {
  const v = String(value || '').trim();
  return /^https?:\/\//i.test(v) ? v : '';
}

const activeStaff = () => db.staff.filter((s) => s.active);

// ---- Upload ----
const upload = multer({
  storage: multer.diskStorage({
    destination: UPLOAD_DIR,
    filename: (req, file, cb) => {
      const ext = path.extname(file.originalname).toLowerCase() || '.jpg';
      cb(null, `${Date.now()}-${crypto.randomBytes(4).toString('hex')}${ext}`);
    },
  }),
  limits: { fileSize: MAX_FILE_MB * 1024 * 1024, files: 50 },
  fileFilter: (req, file, cb) => {
    if (ALLOWED_TYPES.includes(file.mimetype)) cb(null, true);
    else cb(new Error(`Định dạng không hỗ trợ: ${file.originalname}`));
  },
});

const app = express();
app.use(express.json());
app.use(express.static(path.join(__dirname, 'public')));
app.use('/uploads', express.static(UPLOAD_DIR));

// ---- Nhân viên đăng FB ----
app.get('/api/staff', (req, res) => res.json(db.staff));

app.post('/api/staff', (req, res) => {
  const name = String(req.body.name || '').trim();
  if (!name) return res.status(400).json({ error: 'Thiếu tên nhân viên' });
  const staff = {
    id: newId(),
    name,
    phone: String(req.body.phone || '').trim(),
    fbUrl: cleanUrl(req.body.fbUrl),
    active: true,
    createdAt: now(),
  };
  db.staff.push(staff);
  // Nhân viên mới nhận luôn toàn bộ ảnh đang có trong kho
  if (req.body.assignExisting !== false) {
    db.images.forEach((img) => assign(img.id, staff.id));
  }
  saveDb();
  res.status(201).json(staff);
});

app.patch('/api/staff/:id', (req, res) => {
  const staff = db.staff.find((s) => s.id === req.params.id);
  if (!staff) return res.status(404).json({ error: 'Không tìm thấy nhân viên' });
  for (const key of ['name', 'phone']) {
    if (req.body[key] !== undefined) staff[key] = String(req.body[key]).trim();
  }
  if (req.body.fbUrl !== undefined) staff.fbUrl = cleanUrl(req.body.fbUrl);
  if (req.body.active !== undefined) staff.active = Boolean(req.body.active);
  saveDb();
  res.json(staff);
});

app.delete('/api/staff/:id', (req, res) => {
  const before = db.staff.length;
  db.staff = db.staff.filter((s) => s.id !== req.params.id);
  if (db.staff.length === before) return res.status(404).json({ error: 'Không tìm thấy nhân viên' });
  db.assignments = db.assignments.filter((a) => a.staffId !== req.params.id);
  saveDb();
  res.status(204).end();
});

// ---- Ảnh AI ----
app.get('/api/images', (req, res) => {
  const images = db.images.map((img) => {
    const list = db.assignments.filter((a) => a.imageId === img.id);
    return {
      ...img,
      assignedCount: list.length,
      postedCount: list.filter((a) => a.status === 'posted').length,
    };
  });
  res.json(images.sort((a, b) => b.createdAt.localeCompare(a.createdAt)));
});

app.post('/api/images', (req, res) => {
  upload.array('images')(req, res, (err) => {
    if (err) return res.status(400).json({ error: err.message });
    if (!req.files || !req.files.length) return res.status(400).json({ error: 'Chưa chọn ảnh' });

    const caption = String(req.body.caption || '').trim();
    const project = String(req.body.project || '').trim();
    const distribute = req.body.distribute !== 'false';
    const targets = activeStaff();
    let assigned = 0;

    const created = req.files.map((file) => {
      const img = {
        id: newId(),
        url: `/uploads/${file.filename}`,
        filename: file.filename,
        originalName: file.originalname,
        size: file.size,
        caption,
        project,
        createdAt: now(),
      };
      db.images.push(img);
      if (distribute) targets.forEach((s) => (assigned += assign(img.id, s.id)));
      return img;
    });
    saveDb();
    res.status(201).json({ images: created, assigned, staffCount: distribute ? targets.length : 0 });
  });
});

app.patch('/api/images/:id', (req, res) => {
  const img = db.images.find((i) => i.id === req.params.id);
  if (!img) return res.status(404).json({ error: 'Không tìm thấy ảnh' });
  for (const key of ['caption', 'project']) {
    if (req.body[key] !== undefined) img[key] = String(req.body[key]).trim();
  }
  saveDb();
  res.json(img);
});

app.delete('/api/images/:id', (req, res) => {
  const img = db.images.find((i) => i.id === req.params.id);
  if (!img) return res.status(404).json({ error: 'Không tìm thấy ảnh' });
  db.images = db.images.filter((i) => i.id !== img.id);
  db.assignments = db.assignments.filter((a) => a.imageId !== img.id);
  fs.rm(path.join(UPLOAD_DIR, img.filename), { force: true }, () => {});
  saveDb();
  res.status(204).end();
});

// Giao lại toàn bộ ảnh cho tất cả nhân viên đang hoạt động
app.post('/api/distribute', (req, res) => {
  let assigned = 0;
  const targets = activeStaff();
  db.images.forEach((img) => targets.forEach((s) => (assigned += assign(img.id, s.id))));
  saveDb();
  res.json({ assigned, staffCount: targets.length, imageCount: db.images.length });
});

// ---- Phân công / trạng thái đăng ----
app.get('/api/assignments', (req, res) => {
  let list = db.assignments;
  if (req.query.staffId) list = list.filter((a) => a.staffId === req.query.staffId);
  if (req.query.status) list = list.filter((a) => a.status === req.query.status);
  const images = new Map(db.images.map((i) => [i.id, i]));
  const staff = new Map(db.staff.map((s) => [s.id, s]));
  res.json(
    list
      .map((a) => ({ ...a, image: images.get(a.imageId), staff: staff.get(a.staffId) }))
      .filter((a) => a.image && a.staff)
      .sort((a, b) => b.createdAt.localeCompare(a.createdAt))
  );
});

app.patch('/api/assignments/:id', (req, res) => {
  const a = db.assignments.find((x) => x.id === req.params.id);
  if (!a) return res.status(404).json({ error: 'Không tìm thấy phân công' });
  if (req.body.status === 'posted') {
    a.status = 'posted';
    a.postUrl = cleanUrl(req.body.postUrl);
    a.postedAt = now();
  } else if (req.body.status === 'pending') {
    a.status = 'pending';
    a.postUrl = '';
    a.postedAt = null;
  }
  saveDb();
  res.json(a);
});

app.get('/api/stats', (req, res) => {
  const stats = db.staff.map((s) => {
    const list = db.assignments.filter((a) => a.staffId === s.id);
    const posted = list.filter((a) => a.status === 'posted').length;
    return { staffId: s.id, name: s.name, active: s.active, total: list.length, posted, pending: list.length - posted };
  });
  res.json(stats);
});

const PORT = Number(process.env.PORT) || 3000;
if (require.main === module) {
  app.listen(PORT, () => console.log(`Hoàng Hiệp CRM chạy tại http://localhost:${PORT}`));
}

module.exports = app;
