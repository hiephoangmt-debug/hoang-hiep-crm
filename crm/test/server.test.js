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

test('refund: amount − machine fee, due next day; C.Trâm lump-sum advances are netted against it', () => {
  const { fake, call } = fresh('2026-10-02');
  // Hôm trước C.Trâm ứng 300 triệu trước khi làm
  call('savePayment', { ngay: '2026-10-02', loai: 'Ứng trước', so_tien: 300000000, ghi_chu: 'ứng trước' });
  let r = call('refunds', {});
  assert.strictEqual(r.summary.so_du, -300000000);
  assert.strictEqual(r.summary.ung_du, 300000000);

  const a = call('saveTransaction', { ngay: '2026-10-02', dich_vu: 'Đáo hạn', ten_khach: 'C.Nhi', the: 'SC', so_tien: 250000000, may: 'VP Phượng', phi_khach: 1.7, phi_may_text: '1.36' });
  const b = call('saveTransaction', { ngay: '2026-10-02', dich_vu: 'Rút tiền', ten_khach: 'A.Hùng', the: 'TP', so_tien: 250000000, may: 'MB Vân', phi_khach: 2, phi_may_text: '1.2+0.3' });
  assert.strictEqual(a.tien_hoan, 250000000 - 3400000);
  assert.strictEqual(a.ngay_hoan, '2026-10-03');
  assert.strictEqual(b.tien_hoan, 250000000 - 3750000);
  const tong = a.tien_hoan + b.tien_hoan; // 492.850.000

  r = call('refunds', {});
  assert.strictEqual(r.summary.tong_phai_hoan, tong);
  assert.strictEqual(r.summary.so_du, tong - 300000000);
  assert.strictEqual(r.summary.den_han_con_thieu, 0, 'not due until tomorrow');
  assert.strictEqual(r.summary.sap_toi, tong);
  // Ứng 300tr trừ vào giao dịch cũ nhất trước
  const day = r.days[0];
  assert.strictEqual(day.ngay_hoan, '2026-10-03');
  assert.strictEqual(day.da_nhan, 300000000);
  assert.strictEqual(day.con_lai, tong - 300000000);
  assert.strictEqual(day.items[0].con_lai, 0);
  assert.strictEqual(day.items[1].da_nhan, 300000000 - a.tien_hoan);
  assert.strictEqual(r.ledger.length, 1);
  assert.strictEqual(r.ledger[0].phat_sinh, tong);
  assert.strictEqual(r.ledger[0].da_chuyen, 300000000);
  assert.strictEqual(r.ledger[0].so_du, tong - 300000000);

  // Hôm sau: đến hạn, còn thiếu → C.Trâm chuyển nốt
  fake.setToday('2026-10-03');
  r = call('refunds', {});
  assert.strictEqual(r.summary.den_han_con_thieu, tong - 300000000);
  assert.strictEqual(call('dashboard').refunds.summary.den_han_con_thieu, tong - 300000000);
  const pay = call('savePayment', { ngay: '2026-10-03', loai: 'Hoàn tiền', so_tien: tong - 300000000 });
  r = call('refunds', {});
  assert.strictEqual(r.summary.so_du, 0);
  assert.strictEqual(r.days.filter((d) => d.con_lai > 0).length, 0);
  assert.strictEqual(r.ledger[1].so_du, 0);

  // Mình trả lại / điều chỉnh / sửa / xóa
  call('savePayment', { ngay: '2026-10-03', loai: 'Mình trả lại', so_tien: 1000000 });
  assert.strictEqual(call('refunds', {}).summary.so_du, 1000000);
  call('savePayment', { id: pay.id, ngay: '2026-10-03', loai: 'Hoàn tiền', so_tien: tong - 300000000 + 1000000 });
  assert.strictEqual(call('refunds', {}).summary.so_du, 0);
  call('savePayment', { ngay: '2026-10-03', loai: 'Điều chỉnh số dư', so_tien: -500000 });
  assert.strictEqual(call('refunds', {}).summary.so_du, 500000);
  assert.throws(() => call('savePayment', { ngay: '2026-10-03', loai: 'Hoàn tiền', so_tien: -5 }), /lớn hơn 0/);
  call('deletePayment', { id: pay.id });
  assert.strictEqual(call('refunds', {}).summary.so_du, tong - 300000000 + 1000000 + 500000);

  // sửa giao dịch, đổi ngày hoàn
  call('saveTransaction', Object.assign({}, a, { ngay_hoan: '2026-10-05' }));
  assert.strictEqual(call('listTransactions', {}).find((x) => x.id === a.id).ngay_hoan, '2026-10-05');
  assert.throws(() => call('saveTransaction', Object.assign({}, a, { ngay_hoan: '2026-10-01' })), /trước ngày giao dịch/);

  const rp = call('report', { type: 'month', year: 2026 });
  assert.strictEqual(rp.rows[9].tien_hoan, tong);
  call('saveSettings', { refundName: 'C.Trâm (máy MB)' });
  assert.strictEqual(call('bootstrap').settings.refundName, 'C.Trâm (máy MB)');
});

test('close balance (kết số dư) as of a date: C.Trâm still owes, message, lock, carry forward', () => {
  const { fake, call } = fresh('2026-10-01');
  // Nợ cũ trước khi dùng CRM
  call('savePayment', { ngay: '2026-09-30', loai: 'Nợ cũ', so_tien: 12000000, ghi_chu: 'sổ tay' });
  call('savePayment', { ngay: '2026-10-01', loai: 'Ứng trước', so_tien: 300000000 });
  const a = call('saveTransaction', { ngay: '2026-10-01', dich_vu: 'Đáo hạn', ten_khach: 'C.Nhi', the: 'SC', so_tien: 500000000, may: 'MB Vân', phi_khach: 1.7, phi_may_text: '1.4' });
  fake.setToday('2026-10-03');
  call('saveTransaction', { ngay: '2026-10-03', dich_vu: 'Rút tiền', ten_khach: 'A.Hùng', the: 'TP', so_tien: 10000000, may: 'MB Vân', phi_khach: 2, phi_may_text: '1.5' });

  const pv = call('previewClose', { ngay: '2026-10-02' });
  assert.strictEqual(pv.tu_ngay, '2026-09-30');
  assert.strictEqual(pv.so_gd, 1);
  assert.strictEqual(pv.phat_sinh, a.tien_hoan); // 493.000.000
  assert.strictEqual(pv.da_chuyen, 300000000 - 12000000);
  assert.strictEqual(pv.so_du, 493000000 - 288000000);
  assert.match(pv.tin_nhan, /Chị Trâm ơi/);
  assert.match(pv.tin_nhan, /chị còn nợ em 205\.000\.000đ/);

  const c1 = call('closeBalance', { ngay: '2026-10-02' });
  assert.strictEqual(c1.so_du, 205000000);
  assert.throws(() => call('closeBalance', { ngay: '2026-10-02' }), /hãy chọn ngày sau/);
  assert.throws(() => call('closeBalance', { ngay: '2026-10-09' }), /tương lai/);
  // Khóa sổ trước ngày kết
  assert.throws(() => call('savePayment', { ngay: '2026-10-01', loai: 'Hoàn tiền', so_tien: 1 }), /Đã kết số dư/);
  assert.throws(() => call('saveTransaction', Object.assign({}, a, { so_tien: 1 })), /Đã kết số dư/);
  assert.throws(() => call('deleteTransaction', { id: a.id }), /Đã kết số dư/);

  // Kỳ sau: mang số dư sang
  call('savePayment', { ngay: '2026-10-03', loai: 'Hoàn tiền', so_tien: 205000000 });
  const pv2 = call('previewClose', { ngay: '2026-10-03' });
  assert.strictEqual(pv2.tu_ngay, '2026-10-03');
  assert.strictEqual(pv2.so_du_truoc, 205000000);
  assert.strictEqual(pv2.so_du, 10000000 - 150000);
  assert.match(pv2.tin_nhan, /Số dư kết ngày 02\/10\/2026: chị còn nợ em 205\.000\.000đ/);
  assert.strictEqual(call('refunds', {}).summary.so_du, pv2.so_du, 'closing agrees with running balance');
  const r = call('refunds', {});
  assert.strictEqual(r.lastClosing.ngay, '2026-10-02');
  // Mục 1 (chốt đến 02/10) + Mục 2 (từ 03/10 đến nay) = tổng công nợ
  assert.strictEqual(r.congNo.chot_ngay, '2026-10-02');
  assert.strictEqual(r.congNo.ton1, 205000000);
  assert.strictEqual(r.congNo.tu_ngay, '2026-10-03');
  assert.strictEqual(r.congNo.phat_sinh, 10000000 - 150000);
  assert.strictEqual(r.congNo.tam_ung.length, 1);
  assert.strictEqual(r.congNo.ton2, 10000000 - 150000 - 205000000);
  assert.strictEqual(r.congNo.tong, r.summary.so_du);
  assert.strictEqual(call('dashboard').refunds.congNo.tong, r.summary.so_du);
  assert.strictEqual(r.ledger.find((x) => x.ngay === '2026-10-02').ket.so_du, 205000000);

  // Bỏ lần kết gần nhất để sửa
  const c2 = call('closeBalance', { ngay: '2026-10-03' });
  assert.throws(() => call('deleteClosing', { id: c1.id }), /gần nhất/);
  call('deleteClosing', { id: c2.id });
  call('deleteClosing', { id: c1.id });
  call('savePayment', { ngay: '2026-10-01', loai: 'Hoàn tiền', so_tien: 1 });
});

test('several advances in one day before transactions, over-advance, and summary from day a to day b', () => {
  const { fake, call } = fresh('2026-10-05');
  // Chị đang nợ 50tr từ trước
  call('savePayment', { ngay: '2026-10-04', loai: 'Nợ cũ', so_tien: 50000000 });
  // Hôm nay chưa làm GD đã nhờ chị ứng 3 lần: tổng 250tr > 50tr chị nợ → chị ứng dư 200tr
  call('savePayment', { ngay: '2026-10-05', loai: 'Ứng trước', so_tien: 100000000, ghi_chu: 'sáng' });
  call('savePayment', { ngay: '2026-10-05', loai: 'Ứng trước', so_tien: 50000000, ghi_chu: 'trưa' });
  call('savePayment', { ngay: '2026-10-05', loai: 'Ứng trước', so_tien: 100000000, ghi_chu: 'chiều' });
  let today = call('periodSummary', { from: '2026-10-05', to: '2026-10-05' });
  assert.strictEqual(today.so_du_truoc, 50000000);
  assert.strictEqual(today.so_lan_chuyen, 3);
  assert.strictEqual(today.da_chuyen, 250000000);
  assert.strictEqual(today.so_du, -200000000);
  assert.match(today.tin_nhan, /tổng kết ngày 05\/10\/2026/);
  assert.match(today.tin_nhan, /Công nợ trước đó: chị còn nợ em 50\.000\.000đ/);
  // Ứng nhiều hơn số nợ: trừ hết nợ, phần dư là ứng dư
  assert.match(today.tin_nhan, /− Ứng trước 100\.000\.000đ \(sáng\) → trừ hết nợ 50\.000\.000đ, dư 50\.000\.000đ \(chị ứng dư\)/);
  assert.match(today.tin_nhan, /− Ứng trước 50\.000\.000đ \(trưa\) → chị ứng dư 100\.000\.000đ/);
  assert.match(today.tin_nhan, /Số dư cuối 05\/10\/2026: chị ứng dư 200\.000\.000đ/);
  assert.strictEqual(today.payments[0].so_du_sau, -50000000);
  // Tối làm GD 300tr → chị lại còn nợ
  const t = call('saveTransaction', { ngay: '2026-10-05', dich_vu: 'Đáo hạn', ten_khach: 'C.Lan', the: 'VCB', so_tien: 300000000, may: 'MB', phi_khach: 1.7, phi_may_text: '1.3' });
  today = call('periodSummary', { from: '2026-10-05', to: '2026-10-05' });
  assert.strictEqual(today.so_du, 50000000 + t.tien_hoan - 250000000);
  assert.strictEqual(today.giao_dich.loi_nhuan, t.loi_nhuan);
  assert.strictEqual(today.giao_dich.tien_phi, t.tien_phi);

  fake.setToday('2026-10-07');
  const u = call('saveTransaction', { ngay: '2026-10-07', dich_vu: 'Rút tiền', ten_khach: 'A.Bình', the: 'TP', so_tien: 20000000, may: 'MB', phi_khach: 2, phi_may_text: '1.5' });
  call('savePayment', { ngay: '2026-10-07', loai: 'Hoàn tiền', so_tien: 40000000 });
  const r = call('periodSummary', { from: '2026-10-05', to: '2026-10-07' });
  assert.strictEqual(r.so_du_truoc, 50000000);
  assert.strictEqual(r.so_gd, 2);
  assert.strictEqual(r.phat_sinh, t.tien_hoan + u.tien_hoan);
  assert.strictEqual(r.da_chuyen, 290000000);
  assert.strictEqual(r.so_du, call('refunds', {}).summary.so_du, 'period end = running balance');
  assert.strictEqual(r.ngay_lam.length, 2);
  assert.strictEqual(r.ngay_lam[1].so_du, r.so_du);
  assert.match(r.tin_nhan, /từ 05\/10\/2026 đến 07\/10\/2026/);
  // Kỳ chỉ ngày 07 thì số dư đầu kỳ = cuối ngày 05
  assert.strictEqual(call('periodSummary', { from: '2026-10-06', to: '2026-10-07' }).so_du_truoc, today.so_du);
  assert.throws(() => call('periodSummary', { from: '2026-10-07', to: '2026-10-05' }), /trước/);
});

test('advance less than the existing debt leaves the rest owed; transactions are added at end of day', () => {
  const { call } = fresh('2026-10-05');
  call('savePayment', { ngay: '2026-10-04', loai: 'Nợ cũ', so_tien: 50000000 });
  call('savePayment', { ngay: '2026-10-05', loai: 'Ứng trước', so_tien: 30000000, ghi_chu: 'sáng' });
  call('saveTransaction', { ngay: '2026-10-05', dich_vu: 'Đáo hạn', ten_khach: 'C.Lan', the: 'VCB', so_tien: 100000000, may: 'MB', phi_khach: 1.7, phi_may_text: '1.3' });
  const st = call('periodSummary', { from: '2026-10-05', to: '2026-10-05' });
  assert.strictEqual(st.payments[0].so_du_sau, 20000000);
  assert.match(st.tin_nhan, /− Ứng trước 30\.000\.000đ \(sáng\) → chị còn nợ 20\.000\.000đ/);
  assert.match(st.tin_nhan, /\+ Kết GD: 1 GD 100\.000\.000đ − phí máy 1\.300\.000đ = 98\.700\.000đ → chị còn nợ 118\.700\.000đ/);
  assert.strictEqual(st.so_du, 118700000);
});

test('customer cards (last 4 digits only) and private CCCD / card photos in Drive', () => {
  const { fake, call } = fresh('2026-10-05');
  const c = call('saveCustomer', { ten: 'Chị Lan', sdt: '0905123456' });
  // Ghi giao dịch với thẻ mới → tự thêm vào thẻ của khách
  call('saveTransaction', { ngay: '2026-10-05', dich_vu: 'Đáo hạn', khach_id: c.id, ten_khach: 'Chị Lan', the: 'SC', ngay_dao: 4, so_tien: 10000000, phi_khach: 1.7, phi_may_text: '1.3' });
  let cards = call('listCards', { khach_id: c.id });
  assert.strictEqual(cards.length, 1);
  // Khách mới ngay trong giao dịch: trả về khach_id + the_id để gắn ảnh chụp lúc làm
  const nt = call('saveTransaction', { ngay: '2026-10-05', dich_vu: 'Rút tiền', ten_khach: 'Khách mới', sdt: '0906000111', the: 'MB', so_tien: 5000000, phi_khach: 2, phi_may_text: '1.5' });
  assert.ok(nt.khach_id && nt.the_id);
  call('uploadDoc', { khach_id: nt.khach_id, loai: 'Ảnh thẻ', the_id: nt.the_id, data: 'data:image/jpeg;base64,QUJD' });
  call('uploadDoc', { khach_id: nt.khach_id, loai: 'CCCD mặt trước', data: 'data:image/jpeg;base64,QUJD' });
  const cd = call('customerDocs', { khach_id: nt.khach_id });
  assert.strictEqual(cd.docs.length, 2);
  assert.ok(cd.cards[0].anh_id);
  assert.strictEqual(cards[0].ten_the, 'SC');
  assert.strictEqual(cards[0].ngay_dao, 4);
  // Nhập thêm thông tin: số thẻ đầy đủ chỉ giữ 4 số cuối
  const card = call('saveCard', { id: cards[0].id, khach_id: c.id, ten_the: 'SC', ngan_hang: 'Standard Chartered', so_cuoi: '4111 1111 1111 1234', han_muc: 50000000, ngay_sao_ke: 10, ngay_dao: 4 });
  assert.strictEqual(card.so_cuoi, '1234');
  assert.throws(() => call('saveCard', { khach_id: c.id, ten_the: 'TP', ngay_dao: 40 }), /1 đến 31/);
  call('saveCard', { khach_id: c.id, ten_the: 'sc', ngan_hang: 'SCB' }); // trùng tên → cập nhật
  assert.strictEqual(call('listCards', { khach_id: c.id }).length, 1);

  // Ảnh CCCD + ảnh thẻ
  const img = 'data:image/jpeg;base64,QUJD';
  assert.throws(() => call('uploadDoc', { khach_id: 'nope', loai: 'CCCD mặt trước', data: img }), /Lưu khách trước/);
  assert.throws(() => call('uploadDoc', { khach_id: c.id, loai: 'CCCD mặt trước', data: 'data:text/html;base64,PGI+' }), /Chỉ nhận ảnh/);
  const front = call('uploadDoc', { khach_id: c.id, loai: 'CCCD mặt trước', data: img });
  call('uploadDoc', { khach_id: c.id, loai: 'CCCD mặt sau', data: img });
  const front2 = call('uploadDoc', { khach_id: c.id, loai: 'CCCD mặt trước', data: 'data:image/png;base64,WFla' }); // chụp lại: thay ảnh cũ
  const ph = call('uploadDoc', { khach_id: c.id, loai: 'Ảnh thẻ', the_id: card.id, the_ten: 'SC', data: img });
  const d = call('customerDetail', { id: c.id });
  assert.strictEqual(d.docs.length, 3);
  assert.strictEqual(d.cards[0].anh_id, ph.id);
  assert.strictEqual(fake.drive.files[front.file_id].trashed, true, 'old front photo trashed');
  assert.strictEqual(call('getDoc', { id: front2.id }).dataUrl, 'data:image/png;base64,WFla');
  // Thư mục riêng của khách
  const folder = fake.drive.folders[fake.drive.files[front2.file_id].folder];
  assert.match(folder.name, /Chị Lan – 0905123456/);
  call('deleteCard', { id: card.id });
  assert.strictEqual(fake.drive.files[ph.file_id].trashed, true);
  call('deleteDoc', { id: front2.id });
  assert.strictEqual(call('customerDetail', { id: c.id }).docs.length, 1);

  // Một khách nhiều thẻ, có thẻ của người thân
  assert.throws(() => call('saveCard', { khach_id: c.id, ten_the: 'VP chồng', quan_he: 'Chồng' }), /nhập tên chủ thẻ/);
  const wife = call('saveCard', { khach_id: c.id, ten_the: 'VP chồng', quan_he: 'Chồng', chu_the: 'Trần Văn Nam', ngay_dao: 15 });
  call('saveCard', { khach_id: c.id, ten_the: 'MSB mẹ', quan_he: 'Mẹ', chu_the: 'Nguyễn Thị Hoa' });
  call('saveCard', { khach_id: c.id, ten_the: 'TCB' });
  const cccd = call('uploadDoc', { khach_id: c.id, loai: 'CCCD chủ thẻ', the_id: wife.id, data: img });
  call('uploadDoc', { khach_id: c.id, loai: 'Ảnh thẻ', the_id: wife.id, data: img });
  cards = call('listCards', { khach_id: c.id });
  assert.strictEqual(cards.length, 3);
  const w = cards.find((k) => k.id === wife.id);
  assert.strictEqual(w.chu_the, 'Trần Văn Nam');
  assert.strictEqual(w.quan_he, 'Chồng');
  assert.strictEqual(w.cccd_id, cccd.id);
  assert.ok(w.anh_id && w.anh_id !== cccd.id);
  assert.strictEqual(cards.find((k) => k.ten_the === 'TCB').quan_he, 'Chính chủ');
  assert.ok(call('bootstrap').cardRelations.includes('Vợ'));
});

test('missing Drive permission gives a clear how-to instead of a raw error', () => {
  const { gas, call } = fresh('2026-10-05');
  const c = call('saveCustomer', { ten: 'Chị Lan', sdt: '0905123456' });
  const deny = () => { throw new Error('Exception: You do not have permission to call DriveApp.createFolder.'); };
  gas.DriveApp = { createFolder: deny, getFolderById: deny, getFileById: deny };
  gas.CacheService.getScriptCache().remove('drive_ok');
  assert.throws(() => call('uploadDoc', { khach_id: c.id, loai: 'CCCD mặt trước', data: 'data:image/jpeg;base64,QUJD' }), /chưa được cấp quyền Google Drive.*setup/);
  const d = call('customerDetail', { id: c.id });
  assert.strictEqual(d.driveReady, false);
  assert.match(gas.setup(), /CHƯA bật được lưu ảnh/);
});

test('refund columns are added to an existing sheet; old rows get computed values', () => {
  const { gas, fake } = load();
  fake.setToday('2026-10-02');
  gas.setup();
  // Sheet cũ: chỉ có 19 cột như bản trước
  const sh = fake.spreadsheet ? fake.spreadsheet.getSheetByName('GiaoDich') : gas.SpreadsheetApp.getActive().getSheetByName('GiaoDich');
  const oldHeaders = gas.SHEETS.GiaoDich.slice(0, 19);
  sh._rows = [oldHeaders.slice()];
  const row = (id, ngay) => oldHeaders.map((h) => ({ id, ngay, dich_vu: 'Đáo hạn', the: 'SC', khach_id: 'k1', ten_khach: 'C.Nhi', so_tien: 1000000, chi_phi: 13600, phi_may: 1.36 }[h] ?? ''));
  sh._rows.push(row('kold1', '2026-09-20'), row('ktoday', '2026-10-02'));
  gas.checkedSheets_ = {};
  fake.props.PIN_HASH = gas.hashPin_('123456');
  const tok = gas.login('123456');
  const tx = gas.api(tok, 'listTransactions', {});
  assert.strictEqual(sh._rows[0].length, gas.SHEETS.GiaoDich.length, 'headers extended');
  assert.strictEqual(sh._rows[0][19], 'tien_hoan');
  const old = tx.find((t) => t.id === 'kold1'), now = tx.find((t) => t.id === 'ktoday');
  assert.strictEqual(old.tien_hoan, 986400);
  assert.strictEqual(old.hoan_tt, 'Đã nhận', 'old ledger rows count as already paid back');
  assert.strictEqual(now.ngay_hoan, '2026-10-03');
  assert.strictEqual(now.hoan_tt, 'Chưa nhận');
  // Sổ công nợ chỉ tính giao dịch chưa tất toán; sheet DoiSoat tự tạo
  const r = gas.api(tok, 'refunds', {});
  assert.strictEqual(r.summary.tong_phai_hoan, 986400);
  assert.ok(gas.SpreadsheetApp.getActive().getSheetByName('DoiSoat'));
});

console.log(`\n${passed} test(s) passed`);
