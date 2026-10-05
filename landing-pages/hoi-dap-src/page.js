<script>
/* Trang hỏi đáp: tìm câu hỏi (gõ không dấu cũng được), mở câu theo link #, hỏi trợ lý, sao chép link */
(function () {
'use strict';
var fold = function (s) { return String(s).toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g, '').replace(/đ/g, 'd'); };
var q = document.getElementById('hdQ'), none = document.getElementById('hdNone'), count = document.getElementById('hdCount');
var items = [].slice.call(document.querySelectorAll('.qa'));
var groups = [].slice.call(document.querySelectorAll('.hd-group'));
items.forEach(function (d) { d._t = ' ' + fold(d.querySelector('summary').textContent + ' ' + d.querySelector('.qa-a p').textContent).replace(/[^a-z0-9%]+/g, ' ') + ' '; });
var timer, lastLogged = '';
function filter() {
  var v = fold(q.value).replace(/[^a-z0-9%]+/g, ' ').trim(), words = v.split(' ').filter(function (w) { return w.length > 1; }), shown = 0;
  // Ưu tiên khớp nguyên cụm (vd "so do"); không có thì khớp đủ từng chữ
  var phrase = words.length > 1 && items.some(function (d) { return d._t.indexOf(' ' + v + ' ') > -1; });
  items.forEach(function (d) {
    var ok = !words.length || (phrase ? d._t.indexOf(' ' + v + ' ') > -1 : words.every(function (w) { return d._t.indexOf(' ' + w) > -1; }));
    d.hidden = !ok; if (ok) shown++;
    d.open = !!(words.length && ok && shown <= 2);
  });
  groups.forEach(function (s) { s.hidden = !s.querySelector('.qa:not([hidden])'); });
  none.hidden = !(words.length && !shown);
  count.textContent = words.length ? shown + ' kết quả' : items.length + ' câu';
  clearTimeout(timer);
  if (words.length && v !== lastLogged) timer = setTimeout(function () { lastLogged = v; try { if (window.gtag) gtag('event', 'search', {search_term: q.value}); } catch (e) {} }, 1500);
}
q.addEventListener('input', filter);
q.addEventListener('keydown', function (e) { if (e.key === 'Enter') { e.preventDefault(); var f = document.querySelector('.qa:not([hidden])'); if (f && q.value.trim()) { f.open = true; f.scrollIntoView({behavior: 'smooth', block: 'start'}); } else if (window.sftAsk) window.sftAsk(q.value); } });
[].forEach.call(document.querySelectorAll('[data-hq]'), function (b) { b.addEventListener('click', function () { if (window.sftAsk) window.sftAsk(b.dataset.hq); }); });
document.getElementById('hdAskNone').addEventListener('click', function () { if (window.sftAsk) window.sftAsk(q.value); });
var toast = document.createElement('div'); toast.className = 'hd-toast'; document.body.appendChild(toast);
function say(t) { toast.textContent = t; toast.classList.add('on'); setTimeout(function () { toast.classList.remove('on'); }, 1800); }
document.addEventListener('click', function (e) {
  var c = e.target.closest && e.target.closest('.qa-copy');
  if (c) {
    var url = location.href.split('#')[0] + '#' + c.dataset.id;
    try { navigator.clipboard.writeText(url).then(function () { say('Đã sao chép link – gửi cho người thân qua Zalo nhé'); }, function () { say(url); }); } catch (er) { say(url); }
    return;
  }
  var b = e.target.closest && e.target.closest('.ask-more, [data-ask]'); if (!b || !window.sftAsk) return;
  window.sftAsk(b.classList.contains('ask-more') ? b.dataset.q : '');
});
// Mở đúng câu khi vào bằng link #ma-cau (từ chat hoặc link được chia sẻ)
function openHash() { var d = location.hash && document.getElementById(location.hash.slice(1)); if (d && d.tagName === 'DETAILS') { d.open = true; setTimeout(function () { d.scrollIntoView({block: 'start'}); }, 60); } }
addEventListener('hashchange', openHash); openHash();
// Đánh dấu nhóm đang xem
var links = [].slice.call(document.querySelectorAll('.hd-cats a'));
var secs = groups.concat([document.getElementById('van-ban')]);
var onScroll = function () {
  var cur = ''; secs.forEach(function (s) { if (!s.hidden && s.getBoundingClientRect().top < 200) cur = s.id; });
  links.forEach(function (a) {
    var on = a.getAttribute('href') === '#' + cur;
    if (on && !a.classList.contains('on') && matchMedia('(max-width:980px)').matches) a.parentNode.scrollTo({left: a.offsetLeft - 16, behavior: 'smooth'});
    a.classList.toggle('on', on);
  });
};
addEventListener('scroll', onScroll, {passive: true}); onScroll();
})();
</script>
