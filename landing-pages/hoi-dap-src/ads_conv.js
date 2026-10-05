  gtag('config', 'AW-872503827');
</script>
<script>
/* Chuyển đổi Google Ads: dán NHÃN chuyển đổi (phần sau dấu "/" trong send_to) lấy ở Google Ads > Mục tiêu > Chuyển đổi.
   Để trống = chưa gửi. lead: gửi form / chat để lại số · call: bấm gọi · zalo: bấm Zalo */
var SFT_ADS = {lead: '', call: '', zalo: ''};
(function () {
  var g = window.gtag, done = {};
  function send(k) {
    var label = SFT_ADS[k]; if (!label) return;
    var key = k === 'lead' ? 'lead' + (window.sftPhone || '') : k; if (done[key]) return; done[key] = 1;
    try {
      if (k === 'lead' && window.sftPhone) { var p = String(window.sftPhone).replace(/\D/g, ''); if (p.charAt(0) === '0') p = '84' + p.slice(1); g('set', 'user_data', {phone_number: '+' + p}); }
      g('event', 'conversion', {send_to: 'AW-872503827/' + label});
    } catch (e) {}
  }
  window.gtag = function () {
    g.apply(this, arguments);
    var a = arguments; if (a[0] !== 'event') return;
    if (a[1] === 'generate_lead') send('lead'); else if (a[1] === 'phone_call_click') send('call'); else if (a[1] === 'zalo_click') send('zalo');
  };
  // Lưu số điện thoại khách vừa gửi để Google đối chiếu (chuyển đổi nâng cao, Google tự mã hóa)
  document.addEventListener('submit', function (e) { var i = e.target && e.target.querySelector && e.target.querySelector('[name=phone]'); if (i && i.value) window.sftPhone = i.value; }, true);
})();
