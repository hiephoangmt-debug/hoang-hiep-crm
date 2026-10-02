// Chạy: node crm/test/server.test.js
const fs = require('fs');
const path = require('path');
const vm = require('vm');
const assert = require('assert');

function load() {
  const ctx = { console };
  vm.createContext(ctx);
  vm.runInContext(fs.readFileSync(path.join(__dirname, 'fake-gas.js'), 'utf8'), ctx);
  const fake = ctx.FakeGAS;
  Object.keys(fake).forEach((k) => { if (k !== '__fake') ctx[k] = fake[k]; });
  vm.runInContext(fs.readFileSync(path.join(__dirname, '..', 'apps-script', 'Code.gs'), 'utf8'), ctx);
  return { gas: ctx, fake: fake.__fake };
}

let passed = 0;
function test(name, fn) {
  try { fn(); passed++; console.log('✓', name); } catch (e) { console.error('✗', name, '\n ', e.stack); process.exitCode = 1; }
}

function fresh(today = '2026-01-04') {
  const { gas, fake } = load();
  fake.setToday(today);
  gas.setup();
  fake.props.PIN_HASH = gas.hashPin_('123456');
  const token = gas.login('123456');
  const call = (action, payload) => gas.api(token, action, payload);
  return { gas, fake, call };
}

test('parse helpers match the paper ledger', () => {
  const { gas } = fresh();
  assert.strictEqual(gas.parseAmount_('8.999'), 8999000);
  assert.strictEqual(gas.parseAmount_('110tr'), 110000000);
  assert.strictEqual(gas.parseAmount_('1,5tr'), 1500000);
  assert.strictEqual(gas.parseAmount_('500000'), 500000);
  assert.strictEqual(gas.sumExpr_('1.36+0.4'), 1.76);
  assert.strictEqual(gas.sumExpr_('(0.4+1.36)'), 1.76);
  assert.strictEqual(gas.parseService_('ĐH/Rút'), 'Đáo + Rút');
  assert.strictEqual(gas.parseService_('Rút'), 'Rút tiền');
  assert.strictEqual(gas.parseDateLoose_('3/1', 2026), '2026-01-03');
  assert.strictEqual(gas.normalizePhone_('+84 909 669 325'), '0909669325');
  assert.strictEqual(gas.normalizePhone_(909669325), '0909669325');
});

test('login rejects wrong PIN and locks after 5 failures', () => {
  const { gas } = fresh();
  for (let i = 0; i < 5; i++) assert.throws(() => gas.login('000000'), /không đúng/);
  assert.throws(() => gas.login('123456'), /quá 5 lần/);
  assert.throws(() => gas.api('bad-token', 'bootstrap'), /AUTH/);
});

test('web lead creates customer, dedupes by phone, emails owner, honeypot ignored', () => {
  const { gas, fake, call } = fresh();
  const post = (obj) => JSON.parse(gas.doPost({ postData: { contents: JSON.stringify(obj) }, parameter: {} }).content);
  assert.deepStrictEqual(post({ name: 'Lan', phone: '0905 123 456', service: 'Rút tiền thẻ tín dụng', source: 'https://www.the-tin-dung-da-nang.com/x' }).ok, true);
  // LadiPage-style form-encoded webhook, same phone
  assert.strictEqual(JSON.parse(gas.doPost({ parameter: { ho_ten: 'Lan Nguyễn', so_dien_thoai: '+84905123456', nguon: 'dichvuthetindungdanang.com' } }).content).ok, true);
  assert.strictEqual(post({ name: 'Bot', phone: '0905000000', website: 'spam' }).ok, true);
  assert.strictEqual(post({ name: 'X', phone: '123' }).ok, false);
  const customers = call('listCustomers');
  assert.strictEqual(customers.length, 1);
  assert.strictEqual(customers[0].sdt, '0905123456');
  assert.strictEqual(customers[0].nguon, 'www.the-tin-dung-da-nang.com');
  const leads = call('listLeads');
  assert.strictEqual(leads.length, 2);
  assert.strictEqual(fake.sentMail.length, 2);
  assert.match(fake.sentMail[0].subject, /Khách mới/);
});

test('transaction computes fee, cost, profit and links customer', () => {
  const { call } = fresh();
  const t = call('saveTransaction', { ngay: '2026-01-01', dich_vu: 'Đáo hạn', the: 'FE', ngay_dao: 6, ten_khach: 'Đức',
    so_tien: 8999000, may: 'MB Gas+HV', phi_khach: 1.7, phi_may_text: '1.36+0.4' });
  assert.strictEqual(t.tien_phi, 152983);
  assert.strictEqual(t.phi_may, 1.76);
  assert.strictEqual(t.chi_phi, 158382);
  assert.strictEqual(t.loi_nhuan, 152983 - 158382);
  const again = call('saveTransaction', { ngay: '2026-01-04', dich_vu: 'Rút tiền', the: 'SC', ten_khach: ' đức ', so_tien: 1000000, phi_khach: 1.7, phi_may: 1.36 });
  assert.strictEqual(again.khach_id, t.khach_id, 'same customer matched by name');
  assert.strictEqual(call('listCustomers')[0].trang_thai, 'Khách quen');
  assert.throws(() => call('saveTransaction', { ngay: 'x', so_tien: 1 }), /Ngày/);
  assert.throws(() => call('saveTransaction', { ngay: '2026-01-01', so_tien: 0, ten_khach: 'a' }), /Số tiền/);
});

test('reminder window is 7→5 days before next month due date', () => {
  const { call, gas, fake } = fresh('2026-01-03');
  call('saveTransaction', { ngay: '2026-01-02', dich_vu: 'Đáo hạn', the: 'TP', ngay_dao: 5, ten_khach: 'Thái', sdt: '0905111222', so_tien: 96142000, may: 'Điện T.Minh', phi_khach: 2, phi_may: 1.6 });
  call('saveTransaction', { ngay: '2026-01-03', dich_vu: 'Đáo hạn', the: 'BV', ngay_dao: 15, ten_khach: 'Hằng', so_tien: 39991000, phi_khach: 1.6, phi_may: 0.8 });
  call('saveTransaction', { ngay: '2026-01-29', dich_vu: 'Đáo hạn', the: 'VP', ngay_dao: 2, ten_khach: 'Xoan', so_tien: 7373000, phi_khach: 1.7, phi_may: 1.43 });
  call('saveTransaction', { ngay: '2026-01-03', dich_vu: 'Rút tiền', the: 'SC', ten_khach: 'Chú Ái', so_tien: 8562000, phi_khach: 1.6, phi_may: 1.36 });

  const rem = call('reminders', {});
  const by = Object.fromEntries(rem.map((r) => [r.the, r]));
  assert.strictEqual(rem.length, 3, 'withdrawals are not reminded');
  assert.strictEqual(by.TP.han, '2026-02-05');
  assert.strictEqual(by.TP.nhac_ngay, '2026-01-29');
  assert.strictEqual(by.TP.nhac_han, '2026-01-31');
  assert.strictEqual(by.BV.han, '2026-02-15');
  assert.strictEqual(by.BV.han_thuc, '2026-02-13', '15/2/2026 là Chủ nhật (và Tết) → dời lên Thứ 6 13/2');
  assert.strictEqual(by.BV.nhac_ngay, '2026-02-06');
  assert.match(by.BV.han_doi, /dời lên trước/);
  assert.strictEqual(by.VP.han, '2026-03-02', 'paid 29/1 for the 2/2 cycle → next is 2/3');

  // 30/01: TP is inside its window → email + calendar event spanning 29/1–31/1
  fake.setToday('2026-01-30');
  assert.strictEqual(gas.dailyJob(), 1);
  assert.match(fake.sentMail.at(-1).subject, /1 khách cần báo/);
  assert.match(fake.sentMail.at(-1).body, /\[Đáo hạn\] Thái/);
  const ev = fake.events.find((e) => /Thái/.test(e.title));
  assert.ok(ev, 'calendar event created');
  assert.strictEqual(ev.start.getDate(), 29);
  assert.strictEqual(ev.end.getDate(), 1, 'end is exclusive (1/2)');
  const eventsBefore = fake.events.length;
  gas.dailyJob();
  assert.strictEqual(fake.events.length, eventsBefore, 'no duplicate events');

  // Mark as informed → disappears from today list
  call('markReminder', { key: by.TP.key, han: by.TP.han, trang_thai: 'Đã báo' });
  assert.strictEqual(call('dashboard').remindToday.length, 0);

  // Customer comes back on 4/2 → next reminder moves to March
  call('saveTransaction', { ngay: '2026-02-04', dich_vu: 'Đáo hạn', the: 'tp', ngay_dao: 5, ten_khach: 'Thái', so_tien: 90000000, phi_khach: 2, phi_may: 1.6 });
  const tp = call('reminders', {}).find((r) => r.the.toUpperCase() === 'TP');
  assert.strictEqual(tp.han, '2026-03-05');
  assert.strictEqual(tp.nhac_ngay, '2026-02-26');

  // Stop reminding
  call('markReminder', { key: tp.key, han: '*', trang_thai: 'Ngưng nhắc' });
  assert.ok(!call('reminders', {}).some((r) => r.key === tp.key));
});

test('reports by week / month / year', () => {
  const { call } = fresh('2026-01-20');
  call('saveTransaction', { ngay: '2026-01-01', dich_vu: 'Đáo hạn', the: 'FE', ngay_dao: 6, ten_khach: 'A', so_tien: 10000000, phi_khach: 1.7, phi_may: 1.36, may: 'M1' });
  call('saveTransaction', { ngay: '2026-01-05', dich_vu: 'Rút tiền', the: 'SC', ten_khach: 'B', so_tien: 20000000, phi_khach: 1.7, phi_may: 1.32, may: 'M2' });
  call('saveTransaction', { ngay: '2026-02-10', dich_vu: 'Đáo hạn', the: 'FE', ngay_dao: 6, ten_khach: 'A', so_tien: 5000000, phi_khach: 1.7, phi_may: 1.36, may: 'M1' });
  call('saveTransaction', { ngay: '2025-12-31', dich_vu: 'Đáo hạn', the: 'FE', ngay_dao: 6, ten_khach: 'A', so_tien: 1000000, phi_khach: 2, phi_may: 1, may: 'M1' });

  const w = call('report', { type: 'week', year: 2026, month: 1 });
  assert.strictEqual(w.rows[0].label, 'Tuần 1 (01/01–04/01)'); // 1/1/2026 là Thứ 5
  assert.strictEqual(w.rows[1].label, 'Tuần 2 (05/01–11/01)');
  assert.strictEqual(w.rows.at(-1).to, '2026-01-31');
  assert.strictEqual(w.rows[0].so_tien, 10000000);
  assert.strictEqual(w.rows[1].so_rut, 1);
  assert.strictEqual(w.total.so_gd, 2);
  assert.strictEqual(w.total.loi_nhuan, (170000 - 136000) + (340000 - 264000));

  const m = call('report', { type: 'month', year: 2026 });
  assert.strictEqual(m.rows.length, 12);
  assert.strictEqual(m.rows[1].so_tien, 5000000);
  assert.strictEqual(m.byMachine[0].name, 'M2');
  assert.strictEqual(m.topCustomers.find((c) => c.name === 'A').so_gd, 2);

  const y = call('report', { type: 'year', year: 2026 });
  assert.strictEqual(JSON.stringify(y.rows.map((r) => r.label)), JSON.stringify(['Năm 2025', 'Năm 2026']));
  assert.strictEqual(y.rows[0].so_tien, 1000000);
});

test('import pasted ledger rows', () => {
  const { call } = fresh();
  const text = [
    'Ngày\tDịch vụ\tThẻ\tNgày đáo\tTên\tSố tiền\tMáy\tPhí khách\tPhí máy',
    '1/1\tĐH\tFE\t6\tĐức\t8.999\tMB Gas+HV\t1.7\t1.36+0.4',
    '3/1\tĐH/Rút\tExim\t\tChú Ái\t110tr\tMBV NTĐ\t1.6\t1.32',
    'xx\tĐH\tFE\t5\tLỗi\t1\tM\t1\t1'
  ].join('\n');
  const r = call('importTransactions', { text, year: 2026 });
  assert.strictEqual(r.ok, 2);
  assert.strictEqual(r.errors.length, 1);
  const tx = call('listTransactions', {});
  assert.strictEqual(tx.find((t) => t.the === 'Exim').so_tien, 110000000);
  assert.strictEqual(tx.find((t) => t.the === 'Exim').dich_vu, 'Đáo + Rút');
});

test('settings: reminder window + PIN change', () => {
  const { call, gas } = fresh();
  const s = call('saveSettings', { remindFrom: 7, remindTo: 5, newPin: '654321' });
  assert.strictEqual(s.remindFrom, 7);
  assert.strictEqual(s.remindTo, 5);
  assert.throws(() => call('saveSettings', { remindFrom: 3, remindTo: 5 }), /Khoảng nhắc/);
  assert.ok(gas.login('654321'));
});

test('withdrawal advice: withdraw right after statement date for ~55 interest-free days', () => {
  const { call, fake } = fresh('2026-01-10');
  // Sao kê ngày 20, hạn thanh toán ngày 15 tháng sau
  const before = call('withdrawAdvice', { ngay: '2026-01-18', ngay_sao_ke: 20, ngay_dao: 15 });
  assert.strictEqual(before.sao_ke, '2026-01-20');
  assert.strictEqual(before.han_thanh_toan, '2026-02-13'); // 15/2 rơi vào CN/Tết → 13/2
  assert.strictEqual(before.mien_lai, 27);
  assert.strictEqual(before.ngay_tot_nhat, '2026-01-21');
  assert.strictEqual(before.han_neu_rut_ngay_tot, '2026-03-13'); // 15/3 là CN
  assert.strictEqual(before.mien_lai_toi_da, 52);
  assert.strictEqual(before.nen_doi, true);
  // Không biết ngày đáo → sao kê + 25 ngày
  const noDue = call('withdrawAdvice', { ngay: '2026-01-21', ngay_sao_ke: 20 });
  assert.strictEqual(noDue.sao_ke, '2026-02-20');
  assert.strictEqual(noDue.han_thanh_toan, '2026-03-17');
  assert.strictEqual(noDue.mien_lai, 56);
  assert.strictEqual(noDue.nen_doi, false);

  // Giao dịch rút có ngày sao kê → tháng sau nhắc mời khách rút sau sao kê
  call('saveTransaction', { ngay: '2026-01-21', dich_vu: 'Rút tiền', the: 'SC', ngay_sao_ke: 20, ten_khach: 'A.Thắng', so_tien: 55012000, phi_khach: 1.7, phi_may: 1.36 });
  const r = call('reminders', {}).find((x) => x.loai === 'Rút sau sao kê');
  assert.strictEqual(r.han, '2026-02-21');
  assert.strictEqual(r.nhac_ngay, '2026-02-19');
  fake.setToday('2026-02-20');
  assert.ok(call('dashboard').remindToday.some((x) => x.loai === 'Rút sau sao kê'));
  // Khách không quay lại tháng 2 → tháng 3 gợi ý ngày 21/3
  fake.setToday('2026-03-10');
  assert.strictEqual(call('reminders', {}).find((x) => x.loai === 'Rút sau sao kê').han, '2026-03-21');
});

test('due date on weekend / holiday shifts ±days per bank', () => {
  const { call, gas } = fresh('2026-03-01');
  // Hạn 2/5/2026: Thứ 7, trước đó 1/5 và 30/4 là lễ → dời lên Thứ 4 29/4
  const cal = gas.offDayCalendar_();
  assert.strictEqual(gas.adjustDueDate_('2026-05-02', 'SC', cal).han, '2026-04-29');
  // Thẻ dời ra sau → Thứ 2 4/5
  call('saveSettings', { shiftAfterCards: 'VP, tp' });
  assert.strictEqual(gas.adjustDueDate_('2026-05-02', 'TP').han, '2026-05-04');
  // Tết 2026 (14–22/2) → dời ra sau tới Thứ 2 23/2
  assert.strictEqual(gas.adjustDueDate_('2026-02-17', 'VP').han, '2026-02-23');
  // Ngày thường không đổi
  assert.strictEqual(gas.adjustDueDate_('2026-03-05', 'SC').han, '2026-03-05');
  // Sửa danh sách ngày lễ trong Cài đặt
  const st = call('saveSettings', { holidays: '01/01/2027\n2027-02-08' });
  assert.strictEqual(JSON.stringify(st.holidays), JSON.stringify(['2027-01-01', '2027-02-08']));

  // Nhắc 7→5 ngày tính theo hạn đã dời
  call('saveSettings', { shiftAfterCards: '', holidays: '2026-04-30\n2026-05-01' });
  call('saveTransaction', { ngay: '2026-04-01', dich_vu: 'Đáo hạn', the: 'SC', ngay_dao: 2, ten_khach: 'K', so_tien: 10000000, phi_khach: 1.7, phi_may: 1.36 });
  const r = call('reminders', {})[0];
  assert.strictEqual(r.han, '2026-05-02');
  assert.strictEqual(r.han_thuc, '2026-04-29');
  assert.strictEqual(r.nhac_ngay, '2026-04-22');
  assert.strictEqual(r.nhac_han, '2026-04-24');
});

test('Zalo / call button clicks are logged without creating customers or emails', () => {
  const { gas, fake, call } = fresh('2026-03-02');
  const post = (obj) => JSON.parse(gas.doPost({ postData: { contents: JSON.stringify(obj) }, parameter: {} }).content);
  assert.strictEqual(post({ loai: 'zalo', source: 'www.dichvuthetindungdanang.com', service: 'Nút Zalo đầu trang' }).ok, true);
  assert.strictEqual(post({ loai: 'goi', source: 'https://www.the-tin-dung-da-nang.com/' }).ok, true);
  assert.strictEqual(call('listCustomers').length, 0);
  assert.strictEqual(fake.sentMail.length, 0);
  const leads = call('listLeads');
  assert.strictEqual(JSON.stringify(leads.map((l) => l.trang_thai).sort()), JSON.stringify(['Bấm Zalo', 'Bấm gọi']));
  const d = call('dashboard');
  assert.strictEqual(d.clicksToday.length, 2);
  assert.strictEqual(d.leadsThisMonth, 0);
  assert.strictEqual(d.clicksToday.find((c) => c.trang_thai === 'Bấm gọi').nguon, 'www.the-tin-dung-da-nang.com');
  const rp = call('report', { type: 'month', year: 2026 });
  assert.strictEqual(rp.rows[2].bam_web, 2);
  assert.strictEqual(rp.rows[2].lead_web, 0);
});

console.log(`\n${passed} test(s) passed`);
