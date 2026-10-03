// Tạo bản xem thử CRM chạy hoàn toàn trong trình duyệt (dữ liệu mẫu, không cần Google).
// Chạy: node crm/test/build-preview.js [file-ra.html]
const fs = require('fs');
const path = require('path');

const root = path.join(__dirname, '..');
const out = process.argv[2] || path.join(__dirname, 'preview.html');
const index = fs.readFileSync(path.join(root, 'apps-script', 'Index.html'), 'utf8');
const fake = fs.readFileSync(path.join(__dirname, 'fake-gas.js'), 'utf8');
const code = fs.readFileSync(path.join(root, 'apps-script', 'Code.gs'), 'utf8');

const shim = `
<script>${fake}</script>
<script>
  (function () { var F = window.FakeGAS; Object.keys(F).forEach(function (k) { if (k !== '__fake' && k !== 'Date') window[k] = F[k]; }); })();
</script>
<script>${code}</script>
<script>
  // Dữ liệu mẫu (tên giả) quanh ngày hôm nay
  setup();
  PropertiesService.getScriptProperties().setProperty('PIN_HASH', hashPin_('123456'));
  (function seed() {
    var t = todayStr_();
    function d(n) { return addDays_(t, n); }
    var token = login('123456');
    function tx(o) { api(token, 'saveTransaction', o); }
    var rows = [
      [-35, 'Đáo hạn', 'TP', 5, 'Anh Minh', '0905111001', 96142000, 'Điện T.Minh', 2.0, '1.6'],
      [-33, 'Đáo hạn', 'BIDV', 12, 'Chị Hoa', '0905111002', 76075000, 'MBV NTĐ', 1.7, '1.32'],
      [-30, 'Rút tiền', 'SC', '', 'Chú Bảy', '0905111003', 30014000, 'MB Gas+HV', 1.7, '1.36', 20],
      [-28, 'Ví trả sau', 'Momo', '', 'Trang', '0905111004', 7383000, 'Bò sữa', 7, '6'],
      [-27, 'Đáo hạn', 'FE', 10, 'Xuân', '', 34986000, 'MB Gas+HV', 1.7, '0.4+1.36'],
      [-24, 'Đáo hạn', 'VP', 8, 'Xuân', '', 7373000, 'VP Phượng', 1.7, '1.43'],
      [-3, 'Đáo hạn', 'TP', 5, 'Anh Minh', '0905111001', 90200000, 'Điện T.Minh', 2.0, '1.6'],
      [-2, 'Đáo + Rút', 'Exim', 9, 'Chú Ái', '0905111005', 110000000, 'MBV NTĐ', 1.6, '1.32', 25],
      [-1, 'Rút tiền', 'TCB', '', 'Sơn', '0905111006', 10002000, 'MBV NTĐ', 1.7, '1.32', 3],
      [0, 'Đáo hạn', 'MSB', 4, 'Chị Chung', '0905111007', 9999000, 'MB Vân', 1.6, '1.36'],
      [0, 'Rút tiền', 'SC', '', 'A.Thắng', '0905111008', 55012000, 'MB Vân', 1.7, '1.36', 1]
    ];
    rows.forEach(function (r) {
      tx({ ngay: d(r[0]), dich_vu: r[1], the: r[2], ngay_dao: r[3], ten_khach: r[4], sdt: r[5], so_tien: r[6],
        may: r[7], phi_khach: r[8], phi_may_text: r[9], ngay_sao_ke: r[10] || '' });
    });
    // Công nợ C.Trâm: hoàn các khoản cũ, hôm nay ứng trước 300tr
    var old = api(token, 'listTransactions', {}).filter(function (t) { return t.ngay < d(-1); });
    api(token, 'savePayment', { ngay: d(-1), loai: 'Hoàn tiền', so_tien: old.reduce(function (a, t) { return a + t.tien_hoan; }, 0), ghi_chu: 'CK VCB' });
    api(token, 'savePayment', { ngay: d(0), loai: 'Ứng trước', so_tien: 30000000, ghi_chu: 'sáng' });
    api(token, 'savePayment', { ngay: d(0), loai: 'Ứng trước', so_tien: 20000000, ghi_chu: 'chiều' });
    // Ghép hoá đơn ví trả sau
    api(token, 'saveBill', { ngay: d(0), loai_hd: 'Hoá đơn điện', ma_hd: 'PE0400123', so_tien: 5000000, a_ten: 'Cô Hạnh (HĐ điện)', a_sdt: '0907333001', phi_a: 3, phi_minh: 2 });
    api(token, 'saveBill', { ngay: d(0), loai_hd: 'Thanh toán bảo hiểm', ma_hd: 'BV-77812', so_tien: 12000000, a_ten: 'Anh Tùng (bảo hiểm)', a_sdt: '0907333002', phi_a: 3, phi_minh: 2,
      b_ten: 'Chị Ngân', b_sdt: '0907333003', vi_b: 'MoMo Ví Trả Sau', b_tt_ngay: d(0) });
    api(token, 'saveBill', { ngay: d(-1), loai_hd: 'Nạp ví MoMo', so_tien: 3000000, a_ten: 'Bé Vy', a_sdt: '0907333004', phi_a: 2.5, phi_minh: 2,
      b_ten: 'Anh Quang', b_sdt: '0907333005', vi_b: 'SPayLater (Shopee)', b_tt_ngay: d(-1), a_ck_ngay: d(-1), b_ck_ngay: d(-1) });
    // Thẻ mình đang giữ
    api(token, 'heldCards', { mode: 'all' }).slice(0, 3).forEach(function (k, i) {
      api(token, 'saveCard', Object.assign({}, k, { loai_the: ['Visa', 'MasterCard', 'JCB'][i], han_muc: [100000000, 80000000, 50000000][i], so_cuoi: ['1234', '5678', '9012'][i] }));
      api(token, 'holdCard', { the_id: k.id, hanh_dong: 'Nhận giữ', ngay: d(-5 + i), ghi_chu: 'giữ để đáo tháng sau' });
    });
    var ret = api(token, 'heldCards', { mode: 'Khách giữ' })[0];
    api(token, 'holdCard', { the_id: ret.id, hanh_dong: 'Nhận giữ', ngay: d(-6), ghi_chu: 'giữ đáo' });
    var lg = api(token, 'holdCard', { the_id: ret.id, hanh_dong: 'Trả thẻ', ngay: d(-1), ghi_chu: 'trả tận tay, khách ký nhận' });
    api(token, 'uploadDoc', { khach_id: ret.khach_id, loai: 'Ảnh giữ / trả thẻ', the_id: ret.id, ghi_chu: lg.id, data: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg==' });
    [['Lan', '0906222001', 'Rút tiền thẻ tín dụng', 'www.the-tin-dung-da-nang.com', 'Cần rút 20tr thẻ VPBank'],
     ['Hùng', '0906222002', 'Đáo hạn thẻ tín dụng', 'dichvuthetindungdanang.com', ''],
     ['Mai', '0906222003', 'Rút tiền ví trả sau', 'www.the-tin-dung-da-nang.com', 'SPayLater 5tr']].forEach(function (l) {
      doPost({ postData: { contents: JSON.stringify({ name: l[0], phone: l[1], service: l[2], source: l[3], note: l[4] }) }, parameter: {} });
    });
  })();
  // google.script.run giả lập (bất đồng bộ như thật)
  window.google = { script: { run: (function make(ok, bad) {
    var target = {};
    return new Proxy(target, {
      get: function (_, name) {
        if (name === 'withSuccessHandler') return function (f) { return make(f, bad); };
        if (name === 'withFailureHandler') return function (f) { return make(ok, f); };
        return function () {
          var args = arguments;
          setTimeout(function () {
            try { var v = window[name].apply(null, args); ok && ok(JSON.parse(JSON.stringify(v === undefined ? null : v))); }
            catch (e) { bad && bad(e); }
          }, 30);
        };
      }
    });
  })() } };
</script>
`;
fs.writeFileSync(out, index.replace('<script>\n(function () {', shim + '\n<script>\n(function () {'));
console.log('Wrote', out);
