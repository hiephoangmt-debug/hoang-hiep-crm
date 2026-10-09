const { test, before, after } = require('node:test');
const assert = require('node:assert');
const fs = require('fs');
const os = require('os');
const path = require('path');

const tmp = fs.mkdtempSync(path.join(os.tmpdir(), 'crm-'));
process.env.DATA_DIR = path.join(tmp, 'data');
process.env.UPLOAD_DIR = path.join(tmp, 'uploads');
const app = require('../server');

let server, base;
before(() => new Promise((r) => { server = app.listen(0, () => { base = `http://127.0.0.1:${server.address().port}`; r(); }); }));
after(() => { server.close(); fs.rmSync(tmp, { recursive: true, force: true }); });

const post = (url, body) => fetch(base + url, { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(body) }).then((r) => r.json());
const PNG = Buffer.from('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==', 'base64');

test('ảnh tải lên được giao cho tất cả nhân viên đang hoạt động', async () => {
  const a = await post('/api/staff', { name: 'An', fbUrl: 'javascript:alert(1)' });
  const b = await post('/api/staff', { name: 'Bình', fbUrl: 'https://facebook.com/binh' });
  assert.strictEqual(a.fbUrl, '');
  assert.strictEqual(b.fbUrl, 'https://facebook.com/binh');
  await fetch(`${base}/api/staff/${b.id}`, { method: 'PATCH', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ active: false }) });

  const fd = new FormData();
  fd.append('images', new Blob([PNG], { type: 'image/png' }), 'a.png');
  fd.append('images', new Blob([PNG], { type: 'image/png' }), 'b.png');
  fd.append('caption', 'Căn hộ view biển');
  const up = await fetch(base + '/api/images', { method: 'POST', body: fd }).then((r) => r.json());
  assert.strictEqual(up.images.length, 2);
  assert.strictEqual(up.staffCount, 1);

  // Nhân viên mới nhận luôn ảnh cũ
  const c = await post('/api/staff', { name: 'Cường' });
  const mine = await fetch(`${base}/api/assignments?staffId=${c.id}`).then((r) => r.json());
  assert.strictEqual(mine.length, 2);

  // Giao toàn bộ: bật lại Bình rồi distribute
  await fetch(`${base}/api/staff/${b.id}`, { method: 'PATCH', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ active: true }) });
  const d = await post('/api/distribute', {});
  assert.strictEqual(d.assigned, 2);
  assert.strictEqual((await post('/api/distribute', {})).assigned, 0);

  // Đánh dấu đã đăng
  const r = await fetch(`${base}/api/assignments/${mine[0].id}`, { method: 'PATCH', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ status: 'posted', postUrl: 'https://fb.com/p/1' }) }).then((x) => x.json());
  assert.strictEqual(r.status, 'posted');
  const stats = await fetch(base + '/api/stats').then((x) => x.json());
  assert.strictEqual(stats.find((s) => s.staffId === c.id).posted, 1);
});

test('từ chối file không phải ảnh', async () => {
  const fd = new FormData();
  fd.append('images', new Blob(['hello'], { type: 'text/plain' }), 'x.txt');
  const res = await fetch(base + '/api/images', { method: 'POST', body: fd });
  assert.strictEqual(res.status, 400);
});
