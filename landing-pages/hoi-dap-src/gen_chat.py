import json,re,unicodedata,sys
sys.path.insert(0,'hd'); from kb import KB,CATS
def fold(s):
    s=unicodedata.normalize('NFD',s.lower()); s=''.join(c for c in s if unicodedata.category(c)!='Mn').replace('đ','d')
    s=s.replace('gia dinh','giadinh').replace('cong ty','congty')
    return ' '.join(re.sub(r'[^a-z0-9%]+',' ',s).split())
items=[]
for c,i,q,a,k in KB:
    ks=sorted({fold(x) for x in k+[q]} - {''}, key=len)
    items.append({'c':c,'id':i,'q':q,'a':a,'k':[fold(x) for x in k]})
js = ('// Bộ hỏi đáp dùng chung với trang /hoi-dap (sinh tự động từ kb.py)\n'
 'const QA_URL = \'https://www.sun-fours-tower.com/hoi-dap\';\n'
 'const KB = ' + json.dumps(items, ensure_ascii=False, separators=(',',':')) + ';\n'
 "const fold = s => ' ' + String(s).toLowerCase().normalize('NFD').replace(/[\\u0300-\\u036f]/g, '').replace(/đ/g, 'd')\n"
 "  .replace(/gia dinh/g, 'giadinh').replace(/cong ty/g, 'congty').replace(/[^a-z0-9%]+/g, ' ').trim() + ' ';\n"
 "// Chọn câu hỏi khớp nhất: cụm từ nhiều chữ được tính điểm cao hơn\n"
 "const kbFind = v => {\n"
 "  const t = fold(v); let best = null, bs = 0;\n"
 "  KB.forEach(it => { let s = 0; it.k.forEach(k => { if (t.indexOf(' ' + k + ' ') > -1) s += k.split(' ').length; }); if (s > bs) { bs = s; best = it; } });\n"
 "  return bs >= 1 ? best : null;\n"
 "};\n")
s=open('chat-common.html').read()
def sub(old,new):
    global s; assert s.count(old)==1,old[:70]; s=s.replace(old,new)
sub('// Trả lời nhanh khi khách tự gõ câu hỏi\n', js+'\n// Trả lời nhanh khi khách tự gõ câu hỏi\n')
sub("'/gio-hang': 'Giỏ hàng', '/phap-ly': 'Pháp lý'}", "'/gio-hang': 'Giỏ hàng', '/phap-ly': 'Pháp lý', '/hoi-dap': 'Hỏi đáp'}")
sub("""    teaser: 'Chào anh/chị 👋 Anh/chị cần hỏi gì về <b>pháp lý</b> dự án, cứ nhắn em nhé.'}
})""","""    teaser: 'Chào anh/chị 👋 Anh/chị cần hỏi gì về <b>pháp lý</b> dự án, cứ nhắn em nhé.'},
  'Hỏi đáp': {hi: 'Anh/chị có thắc mắc gì về <b>giá, vay, pháp lý, bàn giao</b>… cứ gõ câu hỏi, em trả lời ngay ạ.',
    teaser: 'Chào anh/chị 👋 Chưa thấy câu mình cần? Gõ câu hỏi, em <b>trả lời ngay</b> ạ.'}
})""")
sub("const st = {step: '', goal: '', budget: '', question: '', phone: '', name: '', log: [], started: false, refused: 0};",
    "const st = {step: '', goal: '', budget: '', question: '', phone: '', name: '', log: [], started: false, refused: 0, qn: 0, seen: {}};")
# Trả lời câu hỏi tự do bằng bộ hỏi đáp
old_tail = """  // Câu hỏi tự do: trả lời ngắn nếu có; chỉ mời để số khi khách chưa từ chối
  st.question = st.question ? st.question + ' | ' + v : v;
  const a = answerFaq(v);"""
new_tail = """  // Câu hỏi tự do: trả lời theo bộ hỏi đáp; chỉ thỉnh thoảng mới mời để số, khách từ chối thì thôi
  st.question = st.question ? st.question + ' | ' + v : v;
  const hit = MA_CAN.test(v) ? null : kbFind(v);
  if (hit) { reply(hit); return; }
  const a = answerFaq(v);"""
sub(old_tail,new_tail)
sub("""  if (st.step === 'done') { bot('Em đã ghi lại ạ.""","""  if (st.step === 'done' && !MA_CAN.test(v) && kbFind(v)) { st.question = st.question ? st.question + ' | ' + v : v; reply(kbFind(v)); return; }
  if (st.step === 'done') { bot('Em đã ghi lại ạ.""")
reply_fn = """
// Trả lời 1 câu trong bộ hỏi đáp, gợi ý 2 câu liên quan; mời để số ở câu đầu và mỗi 3 câu (không mời nếu khách đã từ chối / đã để số)
const MA_CAN = /f2[\\s\\-._]*\\d{1,2}[ab]?[\\s\\-._]*\\d{1,2}/i;
const onQA = PATH === '/hoi-dap';
function reply(hit) {
  st.qn++; st.seen[hit.id] = 1;
  bot(hit.a);
  const rel = KB.filter(x => x.c === hit.c && !st.seen[x.id]).slice(0, 2);
  const ask = st.step !== 'done' && !st.refused && (st.qn === 1 || st.qn % 3 === 0);
  const list = rel.map(x => ({t: x.q, fn: () => reply(x)}));
  if (ask) {
    st.step = 'phone';
    bot('Anh/chị cần em gửi <b>căn còn trống + bảng tính giá</b> qua Zalo thì để lại số là được ạ – không thì cứ hỏi tiếp nhé.');
    setInput('Nhập câu hỏi hoặc số Zalo…', false);
    list.push({t: '📱 Để lại số Zalo', pri: true, silent: true, fn: () => { setInput('Nhập số điện thoại / Zalo…', true); inp.focus(); }});
  } else if (st.step !== 'done') { if (st.step === 'phone') st.step = 'chat'; setInput('Nhập câu hỏi của anh/chị…', false); }
  list.push(onQA ? {t: '📖 Xem trong trang', silent: true, fn: () => { const d = document.getElementById(hit.id); if (d) { d.open = true; if (mobile()) close(); d.scrollIntoView({behavior: 'smooth', block: 'center'}); } }}
                 : {t: '📖 Xem tất cả câu hỏi', href: QA_URL + '#' + hit.id});
  choices(list);
}
// Cho trang Hỏi đáp: bấm "Hỏi trợ lý" là mở chat và hỏi luôn
window.sftAsk = q => {
  if (!st.started) { st.started = true; if (ss.get('chat_done')) st.step = 'done'; bot('Chào anh/chị 👋 Em là trợ lý tư vấn <b>Sun FourS Tower</b>.'); }
  open();
  if (q) queue.then(() => { inp.value = q; form.requestSubmit ? form.requestSubmit() : form.dispatchEvent(new Event('submit', {cancelable: true})); });
};
"""
sub("\n// Mở / đóng khung chat\n", reply_fn + "\n// Mở / đóng khung chat\n")
sub("""  'ban-giao': 'bangiao', 'hoi-dap': 'hoidap',""","""  'ban-giao': 'bangiao', 'hoi-dap': 'hoidap', 'hd-tong-quan': 'tongquan', 'hd-vi-tri': 'vitri', 'hd-phap-ly': 'phaply',
  'hd-can-ho': 'matbang', 'hd-gia': 'gia', 'hd-thanh-toan': 'vonit', 'hd-ban-giao': 'bangiao', 'hd-thu-tuc': 'gia',""")
open('chat-common.html','w').write(s)
print('ok', len(js))
