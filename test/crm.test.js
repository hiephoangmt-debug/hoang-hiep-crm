import test from 'node:test';
import assert from 'node:assert/strict';
import http from 'node:http';
import { openDb, getSettings } from '../src/db.js';
import { normalizePhone, mapLeadPayload, ingestLead } from '../src/leads.js';
import { buildAgenda, defaultNextFollowUp, matchCustomersForProject } from '../src/reminders.js';
import { suggestFor, fillTemplate } from '../src/scripts.js';
import { createApp } from '../src/server.js';

test('chuẩn hoá số điện thoại VN', () => {
  assert.equal(normalizePhone('+84 912 345 678'), '0912345678');
  assert.equal(normalizePhone('84912345678'), '0912345678');
  assert.equal(normalizePhone('0912.345.678'), '0912345678');
  assert.equal(normalizePhone('912345678'), '0912345678');
  assert.equal(normalizePhone('12345'), '');
});

test('nhận diện tên trường tiếng Việt / LadiPage', () => {
  const lead = mapLeadPayload({
    'Họ và tên': 'Nguyễn Văn A', 'Số điện thoại': '0987 654 321', 'Nhu cầu': 'Căn 2PN',
    url_page: 'https://hoanggiaminh.com/du-an-x?utm_source=facebook&utm_campaign=t10', 'Dự án': 'Dự án X', 'Ngân sách': '3-4 tỷ',
  });
  assert.equal(lead.name, 'Nguyễn Văn A');
  assert.equal(lead.phone_norm, '0987654321');
  assert.equal(lead.message, 'Căn 2PN');
  assert.equal(lead.project, 'Dự án X');
  assert.equal(lead.utm_source, 'facebook');
  assert.equal(lead.utm_campaign, 't10');
});

test('ingest: tạo khách mới, gộp khi đăng ký lại', () => {
  const db = openDb(':memory:');
  const a = ingestLead(db, { name: 'Chị Lan', phone: '0912345678', url: 'https://www.hiephoangmt.com/can-ho', message: 'Cần căn 2PN' });
  assert.equal(a.isNew, true);
  assert.equal(a.inquiry.source, 'hiephoangmt.com');
  assert.equal(a.customer.status, 'moi');
  assert.ok(a.customer.next_follow_up_at);

  const b = ingestLead(db, { ho_ten: 'Lan', sdt: '+84912345678', link: 'https://landing.ladipage.net/abc' });
  assert.equal(b.isNew, false);
  assert.equal(b.customer.id, a.customer.id);
  assert.equal(db.prepare('SELECT COUNT(*) n FROM inquiries').get().n, 2);
  assert.throws(() => ingestLead(db, { name: 'Không số' }), /Thiếu/);
});

test('agenda: lead mới, hẹn gọi lại, lâu không liên lạc', () => {
  const db = openDb(':memory:');
  const s = getSettings(db);
  const { customer } = ingestLead(db, { name: 'A', phone: '0900000001', url: 'https://x.com' });
  let ag = buildAgenda(db, s);
  assert.equal(ag.new_leads.length, 1);

  // khách cũ đã lâu không liên hệ, không có lịch hẹn
  const old = new Date(Date.now() - 40 * 86400000).toISOString();
  db.prepare(`INSERT INTO customers (name, phone, status, temperature, last_contact_at, created_at, updated_at)
    VALUES ('B', '0900000002', 'dang_cham_soc', 'lanh', ?, ?, ?)`).run(old, old, old);
  // sau khi gọi, lead mới không còn trong danh sách gọi ngay
  db.prepare(`INSERT INTO activities (customer_id, type, outcome, created_at) VALUES (?, 'call', 'nghe_may', ?)`).run(customer.id, new Date().toISOString());
  ag = buildAgenda(db, s);
  assert.equal(ag.new_leads.length, 0);
  assert.equal(ag.follow_ups.length, 1); // lịch gọi lúc đăng ký vẫn đến hạn
  assert.equal(ag.rewarm.length, 1);
  assert.equal(ag.rewarm[0].name, 'B');
});

test('lịch gọi lại mặc định theo kết quả', () => {
  const s = getSettings(openDb(':memory:'));
  const morning = new Date(2026, 9, 12, 9, 0);
  assert.equal(new Date(defaultNextFollowUp('khong_nghe', 'am', s, morning)).getHours(), 19);
  const d = new Date(defaultNextFollowUp(null, 'am', s, morning));
  assert.equal(Math.round((d - morning) / 86400000), 7);
  assert.equal(defaultNextFollowUp('sai_so', 'am', s, morning), null);
});

test('lọc khách phù hợp dự án mới', () => {
  const db = openDb(':memory:');
  const now = new Date().toISOString();
  const ins = db.prepare(`INSERT INTO customers (name, phone, need_type, need_area, budget_min, budget_max, notify_new_projects, created_at, updated_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)`);
  ins.run('Hợp', '0900000011', 'can_ho', 'Thủ Đức', 3, 4, 1, now, now);
  ins.run('Khác loại', '0900000012', 'dat_nen', 'Thủ Đức', 3, 4, 1, now, now);
  ins.run('Không nhận tin', '0900000013', 'can_ho', 'Thủ Đức', 3, 4, 0, now, now);
  ins.run('Ngân sách thấp', '0900000014', 'can_ho', 'Thủ Đức', 1, 1.2, 1, now, now);
  const m = matchCustomersForProject(db, { id: 1, type: 'can_ho', area: 'TP Thủ Đức', price_from: 3.5, price_to: 5 });
  assert.equal(m[0].name, 'Hợp');
  assert.ok(!m.find((x) => x.name === 'Khác loại'));
  assert.ok(!m.find((x) => x.name === 'Không nhận tin'));
  assert.ok(m.find((x) => x.name === 'Hợp').reasons.includes('vừa ngân sách'));
});

test('kịch bản điền tên khách và trang đăng ký', () => {
  const s = { sales_name: 'Hiệp', company: 'Hoàng Gia Minh' };
  const out = suggestFor({ id: 1, name: 'Trần Thị Mai', salutation: 'chị', status: 'moi' }, s, {
    inquiry: { source: 'hoanggiaminh.com', page_url: 'https://hoanggiaminh.com/x', project: 'Dự án X', created_at: new Date().toISOString() },
  });
  assert.ok(out.length >= 3);
  assert.equal(out[0].group, 'goi_dau');
  assert.ok(!out.some((x) => x.text.includes('{')));
  assert.ok(out.some((x) => x.text.includes('Mai')));
  assert.equal(fillTemplate('{xung} khoẻ không?', { xung: 'anh' }), 'Anh khoẻ không?');
});

test('API: webhook + đăng nhập + chi tiết khách', async () => {
  const db = openDb(':memory:');
  const app = createApp({ db, password: 'pw', secret: 'secret', webhookKey: 'k123' });
  const server = http.createServer(app).listen(0);
  const base = `http://127.0.0.1:${server.address().port}`;
  try {
    let r = await fetch(`${base}/api/hook/lead?key=sai`, { method: 'POST', body: '{"phone":"0911111111"}' });
    assert.equal(r.status, 401);
    // LadiPage gửi form-urlencoded
    r = await fetch(`${base}/api/hook/lead?key=k123&source=ladipage-du-an-x`, {
      method: 'POST', headers: { 'content-type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams({ name: 'Anh Nam', phone: '0911111111', url_page: 'https://duanx.ladi.me/' }).toString(),
    });
    assert.equal(r.status, 200);
    // tracker.js gửi text/plain JSON
    r = await fetch(`${base}/api/hook/lead?key=k123`, { method: 'POST', headers: { 'content-type': 'text/plain' }, body: JSON.stringify({ 'your-name': 'Nam', 'your-phone': '0911 111 111', url: 'https://hiephoangmt.com/lien-he' }) });
    assert.equal((await r.json()).is_new, false);

    assert.equal((await fetch(`${base}/api/customers`)).status, 401);
    r = await fetch(`${base}/api/login`, { method: 'POST', body: JSON.stringify({ password: 'pw' }) });
    const cookie = r.headers.get('set-cookie').split(';')[0];
    const list = await (await fetch(`${base}/api/customers`, { headers: { cookie } })).json();
    assert.equal(list.total, 1);
    const id = list.rows[0].id;
    const detail = await (await fetch(`${base}/api/customers/${id}`, { headers: { cookie } })).json();
    assert.deepEqual(detail.inquiries.map((i) => i.source).sort(), ['hiephoangmt.com', 'ladipage-du-an-x']);

    r = await fetch(`${base}/api/customers/${id}/activities`, { method: 'POST', headers: { cookie }, body: JSON.stringify({ type: 'call', outcome: 'quan_tam', content: 'Muốn xem nhà mẫu' }) });
    const after = await r.json();
    assert.equal(after.customer.status, 'dang_cham_soc');
    assert.ok(after.customer.last_contact_at);

    const settings = await (await fetch(`${base}/api/settings`, { headers: { cookie } })).json();
    assert.equal(settings.session_secret, undefined);
    assert.equal(settings.webhook_key, 'k123');
  } finally {
    server.close();
  }
});

test('nhận diện trường không chuẩn (Contact Form 7, form tự đặt tên)', () => {
  const a = mapLeadPayload({ 'your-name': 'Bảo', 'your-tel': '0938 777 666', 'your-email': 'b@x.vn' });
  assert.equal(a.phone_norm, '0938777666');
  assert.equal(a.email, 'b@x.vn');
  const b = mapLeadPayload({ field_1: 'Bảo', field_2: '0938.777.666', field_3: 'Cần căn 3PN', form_name: 'dang-ky' });
  assert.equal(b.phone_norm, '0938777666');
  assert.equal(b.form_name, 'dang-ky');
  assert.ok(!('field_2' in b.extras));
});
