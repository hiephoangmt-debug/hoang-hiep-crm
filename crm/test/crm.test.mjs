// Chạy: node crm/test/crm.test.mjs  (kiểm tra Code.gs với Google Sheet/Calendar/Mail giả lập)
import { loadGas } from './gasmock.mjs';
import assert from 'node:assert/strict';
// Dữ liệu cũ đúng như các dòng thật đã xem trong Sheet
const legacy = {
  'FPT PLAZA 4': [
    ['2025-06-11 20:54:12','Đặng Ngọc Thuỳ Linh','903566065','Căn 2 phòng ngủ','https://www.fpt-city.com/','','','','','','104.28.83.161','FORM2'],
    ['2025-06-11 20:54:39','Đặng Ngọc Thuỳ Linh','903566065','https://www.fpt-city.com/','','','','','','104.28.83.161','FORM3'],
    ['2025-06-15 20:29:52','Nguyen Thanh Hien','nguyenthanhhienfithou@gmail.com','986429362','CĂN 3PN (78.6 - 80 m2)','https://www.fpt-city.com/','','','','','','202.215.44.201','FORM9'],
  ],
  'Legend City': [
    ['2025-04-22 10:53:28','906515732','906515732','CĂN 01 PHÒNG NGỦ','https://www.legend-city-danang.com/?gad_source=1&gclid=x','','','','','','14.167.155.177','FORM407','Phụng: Khách tham khảo '],
    ['2025-04-22 10:54:18','906515732','HUỲNH HUY ','MÃ GIAO DỊCH (MGD_01)','https://www.legend-city-danang.com/?gad_source=1','','','','','','14.167.155.177','FORM408'],
    ['2025-04-28 18:44:48','Trần thị thu huyền','905560606','https://www.legend-city-danang.com/?utm_source=zalo','zalo','zalo','zalo','','','14.191.112.30','FORM416','','Hân'],
  ],
  'peninsula': [['THỜI GIAN','TÊN KHÁCH','SỐ ĐIỆN THOẠI','LOẠI CĂN','LINK WEB','','','','','','IP']],
  'TONG_HOP': [['x','y','z']],
};
const { api, sheets, mail, events, props, g } = loadGas(legacy);

// 1. Cài đặt
api.setupCRM();
const pw = g.logs.find(l => l.includes('Mật khẩu')).match(/CRM: (\w+)/)[1];
assert.ok(props.pw_hash && pw.length === 12);
assert.throws(() => api.login('sai'), /Sai mật khẩu/);
const { token } = api.login(pw);
assert.throws(() => api.bootstrap('bad'), /SESSION_EXPIRED/);

// 2. Nhập data cũ
const rep = api.importLegacyData();
console.log('import:', rep);
assert.deepEqual(rep, { 'FPT PLAZA 4': 2, 'Legend City': 2, 'peninsula': 0 });
let leads = api.bootstrap(token).leads;
const linh = leads.find(l => l.phone === '0903566065');
assert.equal(+linh.count, 2); assert.equal(linh.status, 'Data cũ'); assert.equal(linh.need, 'Căn 2 phòng ngủ');
const hien = leads.find(l => l.phone === '0986429362');
assert.equal(hien.email, 'nguyenthanhhienfithou@gmail.com'); assert.equal(hien.name, 'Nguyen Thanh Hien');
const huy = leads.find(l => l.phone === '0906515732');
assert.equal(huy.name, 'HUỲNH HUY'); assert.match(huy.note, /Phụng/); assert.equal(huy.source, 'google-ads');
const huyen = leads.find(l => l.phone === '0905560606');
assert.equal(huyen.source, 'zalo'); assert.equal(huyen.note, 'Hân');
assert.deepEqual(api.importLegacyData(), { 'FPT PLAZA 4': 0, 'Legend City': 0, 'peninsula': 0 }, 'chạy lại không trùng');

// 3. Khách từ website
api.doPost({ parameter: { name: 'Khách Web', phone: '0905 111 222', project: 'FPT Plaza 5', need: 'Mua để ở', source: 'hero', utm_source: 'google', page: 'https://fpt-city.com/fpt-plaza-5/' } });
api.doPost({ parameter: { name: 'Khách Web', phone: '0905111222', project: 'FPT Plaza 5', source: 'popup' } });
api.doPost({ parameter: { name: 'Bot', phone: '0905111333', project: 'FPT Plaza 5', website: 'x' } });
api.doPost({ parameter: { name: 'Đất', phone: '+84 935 000 111', project: 'Đất nền FPT City V5', need: 'Đầu tư' } });
leads = api.bootstrap(token).leads;
const web = leads.find(l => l.phone === '0905111222');
assert.equal(+web.count, 2); assert.equal(web.status, 'Mới'); assert.equal(web.source, 'google');
assert.equal(web.advice.priority, 1); assert.match(web.advice.action, /Gọi ngay/);
assert.ok(!leads.some(l => l.name === 'Bot'));
assert.equal(leads.find(l => l.phone === '0935000111').need, 'Phân khu V5 · Đầu tư');
assert.equal(sheets['FPT PLAZA 5'].data.length, 3, 'tab dự án: tiêu đề + 2 lần đăng ký');
assert.equal(sheets['FPT PLAZA 5'].data[1][2], '0905111222');
assert.equal(mail.length, 3, 'email: khách mới, đăng ký lại, khách đất nền');

// 4. Cập nhật + lịch hẹn → Calendar
const pad = n => String(n).padStart(2, '0');
const t = new Date(Date.now() + 3600e3); const cbStr = `${t.getFullYear()}-${pad(t.getMonth()+1)}-${pad(t.getDate())} ${pad(t.getHours())}:${pad(t.getMinutes())}:00`;
let upd = api.updateLead(token, web.id, { status: 'Quan tâm', callback: cbStr }, 'Khách cần căn 2PN tầng cao');
assert.ok(upd.eventId && events[upd.eventId], 'tạo sự kiện lịch');
assert.equal(upd.advice.tag, 'Hẹn hôm nay');
assert.throws(() => api.updateLead(token, web.id, { phone: '123' }), /không hợp lệ/);
const hist = api.getHistory(token, web.id);
assert.deepEqual(hist.map(h => h.action), ['Ghi chú', 'Cập nhật', 'Đăng ký lại', 'Tạo khách']);
upd = api.updateLead(token, web.id, { callback: '' });
assert.equal(upd.eventId, ''); assert.equal(Object.keys(events).length, 0, 'xoá lịch → xoá sự kiện');

// 5. Gợi ý theo tình huống
const now = new Date('2026-10-10T09:00:00');
const A = (o) => api.advise_(Object.assign({ status: 'Mới', created: '2026-10-10 08:55:00', updated: '2026-10-10 08:55:00', count: 1 }, o), now);
assert.equal(A({}).priority, 1);
assert.match(A({ created: '2026-10-07 08:00:00', updated: '2026-10-07 08:00:00' }).tag, /Chưa gọi 3 ngày/);
assert.equal(A({ status: 'Quan tâm', updated: '2026-10-05 10:00:00', created: '2026-10-01 10:00:00', callback: '2026-10-20 09:00:00' }).tag, 'Nguội 4 ngày');
assert.equal(A({ status: 'Quan tâm', callback: '2026-10-09 15:00:00' }).tag, 'Quá hạn');
assert.equal(A({ status: 'Quan tâm', updated: '2026-10-10 08:00:00' }).tag, 'Chưa có lịch');
assert.equal(A({ status: 'Data cũ' }).priority, 4);
assert.equal(A({ status: 'Không nhu cầu', callback: '2026-10-09 15:00:00' }).priority, 0);

// 6. Báo cáo ngày & nhắc lịch
mail.length = 0;
api.dailyReport();
assert.equal(mail.length, 1); const m = mail[0][0];
console.log('report subject:', m.subject);
assert.match(m.htmlBody, /Phương án hôm nay|Còn tồn/); assert.match(m.htmlBody, /Ưu tiên 1/);
api.updateLead(token, web.id, { callback: cbStr.replace(/\d\d:\d\d:00$/, `${pad(new Date(Date.now()+10*60e3).getHours())}:${pad(new Date(Date.now()+10*60e3).getMinutes())}:00`) });
mail.length = 0; api.remindCallbacks(); api.remindCallbacks();
assert.equal(mail.length, 1, 'nhắc đúng 1 lần'); assert.match(mail[0][1], /Đến giờ gọi 1 khách/);

// 7. Thêm tay, xoá, đổi mật khẩu
const id = api.createLead(token, { name: 'Gọi đến', phone: '0912345678', project: 'FPT Plaza 4' });
assert.ok(api.bootstrap(token).leads.find(l => l.id === id));
api.deleteLead(token, id);
assert.ok(!api.bootstrap(token).leads.find(l => l.id === id));
assert.throws(() => api.changePassword(token, 'sai', 'matkhaumoi1'), /không đúng/);
api.changePassword(token, pw, 'matkhaumoi1'); assert.ok(api.login('matkhaumoi1').token);
// chặn dò mật khẩu
for (let i = 0; i < 5; i++) { try { api.login('x'); } catch (e) {} }
assert.throws(() => api.login('matkhaumoi1'), /quá 5 lần/);
console.log('ALL CRM TESTS PASSED ✔');
