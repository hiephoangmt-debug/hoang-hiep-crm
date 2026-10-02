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
