import assert from 'node:assert/strict';
import os from 'node:os';
import path from 'node:path';
import fs from 'node:fs';
const dir = fs.mkdtempSync(path.join(os.tmpdir(), 'crm-'));
process.env.DATA_DIR = dir; process.env.ADMIN_PASSWORD = 'pw'; 
const { server, normPhone } = await import('./server.js');
await new Promise((r) => server.listen(0, r));
const base = `http://localhost:${server.address().port}`;
let ck = '';
const call = async (m, p, body, raw) => {
  const r = await fetch(base + p, { method: m, headers: { 'Content-Type': raw ? 'text/plain' : 'application/json', cookie: ck }, body: body ? (raw ? body : JSON.stringify(body)) : undefined });
  const sc = r.headers.get('set-cookie'); if (sc) ck = sc.split(';')[0];
  return { status: r.status, json: await r.json().catch(() => null) };
};
assert.equal(normPhone('+84 912 345 678'), '0912345678');
assert.equal((await call('GET', '/api/stats')).status, 401);
assert.equal((await call('POST', '/api/login', { password: 'x' })).status, 401);
assert.equal((await call('POST', '/api/login', { password: 'pw' })).status, 200);
const site = (await call('POST', '/api/sites', { name: 'Landing A', domain: 'a.com' })).json;
// khách xem trang, bấm Zalo, bấm gọi (ẩn danh), sau đó gửi form
const T = (o) => call('POST', '/api/track', JSON.stringify({ key: site.site_key, vid: 'v1', utm_source: 'facebook', utm_campaign: 'sale', ...o }), true);
await T({ type: 'pageview', url: 'https://a.com/' });
await T({ type: 'click', channel: 'zalo' });
await T({ type: 'pageview', vid: 'v2' }); await T({ type: 'click', channel: 'phone', vid: 'v2' });
assert.equal((await call('GET', '/api/anonymous-clicks?days=1')).json.length, 2);
assert.equal((await call('POST', '/api/track', { key: 'bad', type: 'pageview' })).status, 404);
const lr = await call('POST', '/api/lead', JSON.stringify({ key: site.site_key, vid: 'v1', name: 'An', phone: '0912 345 678' }), true);
assert.equal(lr.json.new, true);
assert.equal((await call('POST', '/api/lead', { key: site.site_key, phone: '12' })).status, 400);
assert.equal((await call('GET', '/api/anonymous-clicks?days=1')).json.length, 1); // click của v1 đã gắn vào lead
let leads = (await call('GET', '/api/leads')).json;
assert.equal(leads.length, 1); assert.equal(leads[0].clicked_zalo, 1); assert.equal(leads[0].utm_source, 'facebook'); assert.equal(leads[0].contacted_at, null);
let st = (await call('GET', '/api/stats?days=1')).json;
assert.equal(st.all_time_uncontacted, 1); assert.equal(st.totals.zalo, 1); assert.equal(st.totals.phone, 1); assert.equal(st.totals.leads, 1);
// gửi lại cùng SĐT -> không tạo trùng
assert.equal((await call('POST', '/api/lead', { key: site.site_key, phone: '0912345678' })).json.new, false);
assert.equal((await call('GET', '/api/leads')).json.length, 1);
// ghi nhận đã gọi
await call('POST', `/api/leads/${leads[0].id}/log`, { type: 'call' });
st = (await call('GET', '/api/stats?days=1')).json;
assert.equal(st.all_time_uncontacted, 0);
leads = (await call('GET', '/api/leads?status=uncontacted')).json; assert.equal(leads.length, 0);
const d = (await call('GET', `/api/leads/${(await call('GET', '/api/leads')).json[0].id}`)).json;
assert.ok(d.events.length >= 3 && d.logs.length === 1);
// chiến dịch ads
const cm = await call('POST', '/api/campaigns', { platform: 'facebook', name: 'Sale T10', utm_campaign: 'SALE' });
assert.equal(cm.status, 200);
assert.equal((await call('POST', '/api/campaigns', { platform: 'facebook', name: 'x', utm_campaign: 'sale' })).status, 400); // không phân biệt hoa thường
const today = new Date(Date.now() + 7 * 36e5).toISOString().slice(0, 10);
const imp = await call('POST', '/api/spend/import', { csv: `utm_campaign,day,spend\nsale,${today},300.000,1000,50\nnone,${today},5` });
assert.equal(imp.json.imported, 1);
const lid = (await call('GET', '/api/leads')).json[0].id;
await call('PATCH', `/api/leads/${lid}`, { status: 'won', value: 3000000 });
const rep = (await call('GET', '/api/campaigns?days=1')).json.campaigns[0];
assert.equal(rep.spend, 300000); assert.equal(rep.leads, 1); assert.equal(rep.cpl, 300000); assert.equal(rep.revenue, 3000000); assert.equal(rep.roas, 10); assert.equal(rep.zalo, 1);
console.log('OK – tất cả test đạt'); server.close(); fs.rmSync(dir, { recursive: true });
