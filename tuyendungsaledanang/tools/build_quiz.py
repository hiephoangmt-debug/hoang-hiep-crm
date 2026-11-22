"""Dựng trang thi thử chứng chỉ môi giới BĐS: bai/thi-thu-chung-chi-moi-gioi.html
Ngân hàng câu hỏi: bai-src/quiz-bank.json (mảng {id,cat,topic,q,opts[4],ans,exp,lock_last?}).
Đề xáo trộn ngẫu nhiên mỗi lần làm (thứ tự câu và thứ tự đáp án), chạy hoàn toàn trên trình duyệt.
"""
import html, json, os, re
from collections import Counter

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
S = 'https://www.tuyendungsaledanang.com'
IMG = 'https://raw.githubusercontent.com/hiephoangmt-debug/hoang-hiep-crm/tuyen-dung-sale-da-nang/tuyendungsaledanang/img/'
SLUG = 'thi-thu-chung-chi-moi-gioi'
TODAY, TODAY_VN = '2026-11-22', '22/11/2026'

bank = json.load(open(os.path.join(ROOT, 'bai-src', 'quiz-bank.json'), encoding='utf-8'))
for b in bank:
    assert len(b['opts']) == 4 and 0 <= b['ans'] <= 3, b['id']
N = len(bank)
topics = Counter(b['topic'] for b in bank)
fmt_path = os.path.join(ROOT, 'bai-src', 'quiz-config.json')
CFG = json.load(open(fmt_path, encoding='utf-8')) if os.path.exists(fmt_path) else {}
EXAM_N = CFG.get('exam_questions', 30)
EXAM_MIN = CFG.get('exam_minutes', 30)
PASS = CFG.get('pass_percent', 70)
FORMAT_NOTE = CFG.get('format_note', '')

ref = open(os.path.join(ROOT, 'bai', 'lo-trinh-sale-moi-60-ngay-dau.html'), encoding='utf-8').read()
HEAD_CSS = ref[ref.index('<link href="https://fonts.googleapis.com'):ref.index('</style>')]
CRM = re.search(r'<script src="https://script\.google\.com[^>]*></script>', ref).group(0)
TOPBAR = ref[ref.index('<div class="top">'):ref.index('<header class="hero">')].replace(f'{S}/#dang-ky', f'{S}/ung-tuyen')
TOPBAR = TOPBAR.replace('<a href="#muc-luc">📑 Mục lục</a>', '<a href="#thi">📝 Làm bài</a>')
TAIL = ref[ref.index('<footer'):]
e = lambda x: html.escape(x, quote=True)

title = f'Thi thử chứng chỉ môi giới BĐS 2027: {N} câu trắc nghiệm có đáp án'
desc = (f'Thi thử chứng chỉ môi giới bất động sản online miễn phí: {N} câu trắc nghiệm cập nhật Luật KDBĐS 2023, '
        f'Luật Đất đai 2024. Đề tự đảo mỗi lần làm, có giải thích.')
url = f'{S}/{SLUG}'

# 8 câu mẫu tĩnh (cho Google/ChatGPT đọc được, người dùng xem nhanh)
sample = []
seen = set()
for b in bank:
    if b['topic'] not in seen and len(sample) < 8:
        seen.add(b['topic']); sample.append(b)
sample_html = ''.join(
    f'<details><summary>{e(b["q"])}</summary><p><b>Đáp án:</b> {e(b["opts"][b["ans"]])}</p><p>{e(b.get("exp", ""))}</p></details>'
    for b in sample)
topic_rows = ''.join(f'<tr><td>{e(t)}</td><td>{c}</td></tr>' for t, c in topics.most_common())
faq = [
    ('Thi chứng chỉ môi giới bất động sản có khó không?',
     'Đề chủ yếu là trắc nghiệm về pháp luật đất đai, nhà ở, kinh doanh bất động sản và kỹ năng môi giới. Ôn đều các chuyên đề và luyện nhiều đề là đủ tự tin; trang này cho bạn làm đề mới mỗi lần.'),
    ('Đề thi thử trên trang này có giống đề thi thật không?',
     'Câu hỏi được biên soạn lại theo phạm vi kiến thức của kỳ thi và cập nhật luật đang có hiệu lực. Đây là đề luyện tập, không phải đề thi chính thức; cấu trúc đề thật do cơ quan tổ chức thi công bố.'),
    ('Câu hỏi đã cập nhật Luật Kinh doanh bất động sản 2023 chưa?',
     'Đã cập nhật theo Luật Kinh doanh bất động sản 29/2023/QH15 (hiệu lực 01/8/2024), Luật Đất đai 2024, Luật Nhà ở 2023 và các văn bản hướng dẫn. Câu nào dựa trên luật cũ đã được sửa hoặc loại bỏ.'),
    ('Vì sao mỗi lần làm bài đề lại khác?',
     'Hệ thống rút ngẫu nhiên câu hỏi từ ngân hàng và đảo thứ tự đáp án A, B, C, D. Bạn phải hiểu nội dung chứ không thể nhớ vị trí đáp án.'),
    ('Chưa có chứng chỉ có làm sale bất động sản được không?',
     'Theo Luật KDBĐS 2023, cá nhân hành nghề môi giới phải có chứng chỉ và hành nghề trong doanh nghiệp hoặc sàn. Người mới có thể vào đội, học việc có người kèm và ôn thi chứng chỉ song song.'),
]
faq_html = ''.join(f'<details><summary>{e(q)}</summary><p>{e(a)}</p></details>' for q, a in faq)
ld = [
    {'@context': 'https://schema.org', '@type': 'Article', 'headline': title, 'description': desc, 'image': IMG + 'og-' + SLUG + '.jpg',
     'datePublished': TODAY, 'dateModified': TODAY, 'inLanguage': 'vi',
     'author': {'@type': 'Person', 'name': 'Hoàng Hiệp', 'jobTitle': 'Giám đốc kinh doanh', 'url': S},
     'publisher': {'@type': 'Organization', 'name': 'Tuyển Sale Đà Nẵng', 'url': S}, 'mainEntityOfPage': url},
    {'@context': 'https://schema.org', '@type': 'FAQPage', 'mainEntity': [
        {'@type': 'Question', 'name': q, 'acceptedAnswer': {'@type': 'Answer', 'text': a}} for q, a in faq]},
]
ldj = '\n'.join(f'<script type="application/ld+json">{json.dumps(x, ensure_ascii=False)}</script>' for x in ld)

CSS = '''
#thi{scroll-margin-top:70px}
.qz{background:#fff;border-radius:16px;padding:22px;margin:24px 0;box-shadow:0 2px 10px rgba(11,42,91,.06)}
.qz h2{margin:0 0 6px;color:#1B2D6B}
.modes{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin:14px 0}
@media(max-width:640px){.modes{grid-template-columns:1fr}}
.mode{border:2px solid #d9dfea;border-radius:12px;padding:12px 14px;cursor:pointer;background:#fff;text-align:left;font:inherit;color:#1d2433}
.mode b{display:block;color:#1B2D6B;font-size:16px}.mode small{color:#6b7896}
.mode[aria-pressed=true]{border-color:#f47c20;background:#fff4ea}
.qz select{width:100%;padding:11px 12px;border:1px solid #cfd6e4;border-radius:8px;font:inherit;margin:6px 0 10px;background:#fff}
.qz .row{display:flex;gap:10px;flex-wrap:wrap;align-items:center}
.go{background:#f47c20;color:#fff;border:0;border-radius:10px;padding:14px 20px;font:inherit;font-weight:800;font-size:17px;cursor:pointer}
.ghost{background:#fff;color:#1B2D6B;border:2px solid #1B2D6B;border-radius:10px;padding:12px 16px;font:inherit;font-weight:700;cursor:pointer}
.bar{height:8px;background:#e8ecf4;border-radius:99px;overflow:hidden;margin:6px 0 14px}.bar i{display:block;height:100%;background:#f47c20;width:0}
.meta{display:flex;justify-content:space-between;font-size:14px;color:#6b7896;font-variant-numeric:tabular-nums}
.meta .tm{font-weight:800;color:#1B2D6B}
.qtext{font-size:18px;font-weight:700;margin:8px 0 14px;line-height:1.45}
.qtopic{display:inline-block;font-size:12px;font-weight:700;background:#eef3fc;color:#1B2D6B;padding:2px 10px;border-radius:99px}
.opt{display:flex;gap:10px;width:100%;text-align:left;background:#fff;border:2px solid #d9dfea;border-radius:12px;padding:12px 14px;margin:8px 0;font:inherit;font-size:16px;cursor:pointer;color:#1d2433}
.opt .l{flex:none;width:28px;height:28px;border-radius:50%;background:#eef3fc;color:#1B2D6B;font-weight:800;display:grid;place-items:center}
.opt.sel{border-color:#1B2D6B;background:#eef3fc}
.opt.ok{border-color:#1c8a4a;background:#ecf7ef}.opt.ok .l{background:#1c8a4a;color:#fff}
.opt.no{border-color:#d33;background:#fdeeee}.opt.no .l{background:#d33;color:#fff}
.exp{background:#fff4ea;border-left:4px solid #f47c20;border-radius:8px;padding:10px 14px;font-size:15px;margin-top:10px}
.nav{display:flex;justify-content:space-between;gap:10px;margin-top:16px;flex-wrap:wrap}
.dots{display:flex;flex-wrap:wrap;gap:6px;margin-top:14px}
.dots button{width:34px;height:34px;border-radius:8px;border:1px solid #cfd6e4;background:#fff;font:inherit;font-size:13px;cursor:pointer;font-variant-numeric:tabular-nums}
.dots button.done{background:#1B2D6B;color:#fff;border-color:#1B2D6B}.dots button.cur{outline:2px solid #f47c20}
.score{font-size:44px;font-weight:900;color:#1B2D6B;line-height:1}.score small{font-size:18px;color:#6b7896}
.verdict{display:inline-block;margin:8px 0;padding:4px 12px;border-radius:99px;font-weight:800}
.verdict.pass{background:#ecf7ef;color:#1c6b35}.verdict.fail{background:#fdeeee;color:#a12}
.tp{width:100%;border-collapse:collapse;font-size:15px;margin:12px 0}.tp td{padding:6px 4px;border-bottom:1px solid #eef1f6}.tp td:last-child{text-align:right;font-variant-numeric:tabular-nums}
.rv{border-top:1px solid #e3e8f2;padding:12px 0}.rv p{margin:4px 0}
.rv .you{color:#a12}.rv .right{color:#1c6b35}
.apply-cta{background:#0b2a5b;color:#fff;border-radius:14px;padding:18px;margin-top:18px}
.apply-cta a{display:inline-block;background:#f47c20;color:#fff;text-decoration:none;font-weight:800;padding:12px 18px;border-radius:10px;margin-top:10px}
[hidden]{display:none!important}
'''

JS = r'''
const BANK=__BANK__,EXAM_N=__EXAM_N__,EXAM_MIN=__EXAM_MIN__,PASS=__PASS__;
const $=s=>document.querySelector(s);
const rnd=n=>{const a=new Uint32Array(1);crypto.getRandomValues(a);return a[0]%n};
const shuffle=a=>{a=a.slice();for(let i=a.length-1;i>0;i--){const j=rnd(i+1);[a[i],a[j]]=[a[j],a[i]]}return a};
const esc=s=>String(s).replace(/[&<>"]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]));
let mode='exam',Q=[],cur=0,ans=[],timer=null,left=0,done=false;
document.querySelectorAll('.mode').forEach(b=>b.onclick=()=>{mode=b.dataset.m;document.querySelectorAll('.mode').forEach(x=>x.setAttribute('aria-pressed',x===b));$('#topicRow').hidden=mode!=='topic'});
function build(){
  let pool=BANK;
  if(mode==='topic'){const t=$('#topic').value;pool=BANK.filter(b=>b.topic===t)}
  let n=mode==='exam'?Math.min(EXAM_N,pool.length):mode==='topic'?Math.min(20,pool.length):pool.length;
  return shuffle(pool).slice(0,n).map(b=>{
    let idx=[0,1,2,3];
    idx=b.lock_last?shuffle([0,1,2]).concat([3]):shuffle(idx);
    return {b,order:idx,correct:idx.indexOf(b.ans)};
  });
}
function start(){
  Q=build();cur=0;ans=new Array(Q.length).fill(-1);done=false;
  $('#setup').hidden=true;$('#result').hidden=true;$('#play').hidden=false;
  clearInterval(timer);$('#tm').textContent='';
  if(mode==='exam'){left=EXAM_MIN*60;tick();timer=setInterval(tick,1000)}
  render();$('#thi').scrollIntoView({behavior:'smooth'});
}
function tick(){if(left<=0){clearInterval(timer);finish();return}const m=Math.floor(left/60),s=left%60;$('#tm').textContent='⏱ '+m+':'+String(s).padStart(2,'0');left--}
const study=()=>mode!=='exam';
function render(){
  const q=Q[cur],b=q.b;
  $('#pos').textContent='Câu '+(cur+1)+'/'+Q.length;
  $('#bar').style.width=((ans.filter(a=>a>=0).length)/Q.length*100)+'%';
  $('#qtopic').textContent=b.topic;
  $('#qtext').textContent=b.q;
  const answered=ans[cur]>=0;
  $('#opts').innerHTML=q.order.map((o,i)=>{
    let c='opt';
    if(answered&&study()){if(i===q.correct)c+=' ok';else if(i===ans[cur])c+=' no'}
    else if(i===ans[cur])c+=' sel';
    return '<button class="'+c+'" data-i="'+i+'"><span class="l">'+'ABCD'[i]+'</span><span>'+esc(b.opts[o])+'</span></button>'}).join('');
  document.querySelectorAll('#opts .opt').forEach(x=>x.onclick=()=>{if(study()&&ans[cur]>=0)return;ans[cur]=+x.dataset.i;render();if(!study()&&cur<Q.length-1)setTimeout(()=>{cur++;render()},250)});
  $('#exp').hidden=!(answered&&study());
  if(answered&&study())$('#exp').innerHTML=(ans[cur]===q.correct?'✅ <b>Đúng.</b> ':'❌ <b>Chưa đúng.</b> Đáp án: <b>'+'ABCD'[q.correct]+'</b>. ')+esc(b.exp||'');
  $('#prev').disabled=cur===0;
  $('#next').textContent=cur===Q.length-1?'Nộp bài':'Câu tiếp →';
  $('#dots').innerHTML=Q.map((_,i)=>'<button class="'+(ans[i]>=0?'done ':'')+(i===cur?'cur':'')+'" data-i="'+i+'">'+(i+1)+'</button>').join('');
  document.querySelectorAll('#dots button').forEach(x=>x.onclick=()=>{cur=+x.dataset.i;render()});
}
$('#prev').onclick=()=>{if(cur>0){cur--;render()}};
$('#next').onclick=()=>{if(cur<Q.length-1){cur++;render()}else{const miss=ans.filter(a=>a<0).length;if(miss){$('#confirmSubmit').hidden=false;$('#missN').textContent=miss;return}finish()}};
$('#reallySubmit').onclick=()=>{$('#confirmSubmit').hidden=true;finish()};
$('#keepGoing').onclick=()=>{$('#confirmSubmit').hidden=true;cur=ans.findIndex(a=>a<0);render()};
function finish(){
  if(done)return;done=true;clearInterval(timer);
  const ok=Q.filter((q,i)=>ans[i]===q.correct).length,pct=Math.round(ok/Q.length*100);
  $('#play').hidden=true;$('#confirmSubmit').hidden=true;$('#result').hidden=false;
  $('#sc').innerHTML=ok+'<small>/'+Q.length+' câu · '+pct+'%</small>';
  const v=$('#verdict');v.className='verdict '+(pct>=PASS?'pass':'fail');v.textContent=pct>=PASS?'Đạt mục tiêu '+PASS+'%':'Chưa đạt '+PASS+'% · làm thêm đề mới nhé';
  const by={};Q.forEach((q,i)=>{const t=q.b.topic;by[t]=by[t]||[0,0];by[t][1]++;if(ans[i]===q.correct)by[t][0]++});
  $('#bytopic').innerHTML=Object.entries(by).sort((a,b)=>a[1][0]/a[1][1]-b[1][0]/b[1][1]).map(([t,[a,n]])=>'<tr><td>'+esc(t)+'</td><td>'+a+'/'+n+'</td></tr>').join('');
  const wrong=Q.map((q,i)=>[q,i]).filter(([q,i])=>ans[i]!==q.correct);
  $('#review').innerHTML=wrong.length?wrong.map(([q,i])=>'<div class="rv"><p><b>'+(i+1)+'. '+esc(q.b.q)+'</b></p>'+(ans[i]>=0?'<p class="you">Bạn chọn: '+esc(q.b.opts[q.order[ans[i]]])+'</p>':'<p class="you">Bạn bỏ trống</p>')+'<p class="right">Đáp án đúng: '+esc(q.b.opts[q.b.ans])+'</p><p>'+esc(q.b.exp||'')+'</p></div>').join(''):'<p>🎉 Không sai câu nào. Làm đề mới để thử sức tiếp.</p>';
  try{const k='qz-best',best=+localStorage.getItem(k)||0;if(mode==='exam'&&pct>best)localStorage.setItem(k,pct);$('#best').textContent=Math.max(best,mode==='exam'?pct:0)?'Điểm đề thi thử cao nhất của bạn: '+Math.max(best,mode==='exam'?pct:0)+'%':''}catch(e){}
  $('#thi').scrollIntoView({behavior:'smooth'});
}
$('#start').onclick=start;$('#again').onclick=start;$('#back').onclick=()=>{$('#result').hidden=true;$('#setup').hidden=false};
$('#quit').onclick=()=>{clearInterval(timer);$('#play').hidden=true;$('#setup').hidden=false};
'''
topic_opts = ''.join(f'<option value="{e(t)}">{e(t)} ({c} câu)</option>' for t, c in topics.most_common())
js = (JS.replace('__BANK__', json.dumps(bank, ensure_ascii=False, separators=(',', ':')))
      .replace('__EXAM_N__', str(EXAM_N)).replace('__EXAM_MIN__', str(EXAM_MIN)).replace('__PASS__', str(PASS)))

page = f'''<!doctype html>
<html lang="vi">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="ladipage-rules" content="v2">
<title>{e(title)}</title>
<meta name="description" content="{e(desc)}">
{HEAD_CSS}{CSS}</style>
{CRM}
<meta name="keywords" content="thi thử chứng chỉ môi giới bất động sản, đề thi chứng chỉ môi giới bất động sản, câu hỏi trắc nghiệm môi giới bất động sản, ôn thi chứng chỉ môi giới bất động sản, chứng chỉ môi giới bất động sản đà nẵng">
<meta name="author" content="Hoàng Hiệp">
<meta name="robots" content="index,follow,max-image-preview:large">
<meta property="og:url" content="{url}">
<meta property="og:type" content="article">
<meta property="og:image" content="{IMG}og-{SLUG}.jpg">
<meta property="og:title" content="{e(title)}">
<meta property="og:description" content="{e(desc)}">
<link rel="icon" href="{IMG}favicon-tuyen-sale.png">
<link rel="canonical" href="{url}">
{ldj}
</head>
<body>
{TOPBAR}<header class="hero"><div class="wrap">
<span class="tag">Ôn thi · Cập nhật luật {TODAY_VN}</span>
<h1>Thi thử chứng chỉ môi giới bất động sản: {N} câu, đề tự đảo mỗi lần làm</h1>
<p>Ngân hàng {N} câu trắc nghiệm theo Luật Kinh doanh BĐS 2023, Luật Đất đai 2024, Luật Nhà ở 2023 và kỹ năng môi giới. Mỗi lần bấm "Làm đề", câu hỏi và đáp án A–D được xáo lại, có giải thích từng câu.</p>
<a class="btn" href="#thi">Làm bài ngay</a><a class="btn2" href="{S}/ung-tuyen">Vào đội, có người kèm ôn thi</a>
</div></header>
<main class="wrap">
<section class="qz" id="thi">
<div id="setup">
<h2>Chọn cách làm bài</h2>
<div class="modes">
<button class="mode" data-m="exam" aria-pressed="true"><b>📝 Đề thi thử</b><small>{EXAM_N} câu ngẫu nhiên · {EXAM_MIN} phút · chấm điểm cuối</small></button>
<button class="mode" data-m="topic" aria-pressed="false"><b>🎯 Theo chuyên đề</b><small>20 câu một chuyên đề · xem đáp án ngay</small></button>
<button class="mode" data-m="all" aria-pressed="false"><b>📚 Ôn toàn bộ</b><small>Cả {N} câu, đảo thứ tự · xem đáp án ngay</small></button>
</div>
<div id="topicRow" hidden><label for="topic"><b>Chuyên đề</b></label><select id="topic">{topic_opts}</select></div>
<button class="go" id="start">Làm đề →</button>
<p class="note" style="margin-top:14px">Mỗi lần làm là một đề mới: câu hỏi rút ngẫu nhiên, thứ tự A–D xáo lại. {e(FORMAT_NOTE)}</p>
</div>
<div id="play" hidden>
<div class="meta"><span id="pos"></span><span class="tm" id="tm"></span></div>
<div class="bar"><i id="bar"></i></div>
<span class="qtopic" id="qtopic"></span>
<p class="qtext" id="qtext"></p>
<div id="opts"></div>
<div class="exp" id="exp" hidden></div>
<div class="nav"><button class="ghost" id="prev">← Câu trước</button><button class="go" id="next">Câu tiếp →</button></div>
<div class="exp" id="confirmSubmit" hidden>Bạn còn <b id="missN"></b> câu chưa làm. <button class="ghost" id="keepGoing">Làm tiếp</button> <button class="go" id="reallySubmit">Nộp luôn</button></div>
<div class="dots" id="dots"></div>
<p style="margin-top:14px"><button class="ghost" id="quit">Thoát đề</button></p>
</div>
<div id="result" hidden>
<h2>Kết quả</h2>
<div class="score" id="sc"></div>
<span class="verdict" id="verdict"></span>
<p id="best" style="color:#6b7896;font-size:14px"></p>
<div class="row"><button class="go" id="again">🔀 Làm đề mới (đảo lại)</button><button class="ghost" id="back">Đổi chế độ</button></div>
<h3 class="sub">Điểm theo chuyên đề (yếu nhất trước)</h3>
<table class="tp"><tbody id="bytopic"></tbody></table>
<div class="apply-cta"><b>Ôn thi song song với đi làm thật?</b><br>Vào đội Hiệp: đào tạo từ 0, có người kèm, data phân bổ mỗi ngày, hỗ trợ 50–100% quảng cáo.<br><a href="{S}/ung-tuyen">Gửi hồ sơ 30 giây →</a></div>
<h3 class="sub">Xem lại câu sai</h3>
<div id="review"></div>
</div>
</section>

<section class="card" id="cau-truc">
<h2>Ngân hàng câu hỏi <span>theo chuyên đề</span></h2>
<p class="lead">{N} câu, biên soạn lại theo phạm vi kiến thức kỳ thi chứng chỉ hành nghề môi giới và cập nhật luật đang có hiệu lực. Câu nào dựa trên luật cũ đã được sửa hoặc loại bỏ.</p>
<table><tr><th>Chuyên đề</th><th>Số câu</th></tr>{topic_rows}</table>
<p class="note">Đề trên trang là đề luyện tập, không phải đề thi chính thức. Lịch thi, cấu trúc đề và điểm đạt theo thông báo của cơ quan tổ chức thi. Xem thêm <a href="{S}/chung-chi-moi-gioi-bat-dong-san">Chứng chỉ môi giới BĐS: có bắt buộc không, thi thế nào</a> và <a href="{S}/luat-kinh-doanh-bat-dong-san">Luật Kinh doanh BĐS 2023 cho người mới</a>.</p>
</section>

<section class="card" id="cau-mau">
<h2>Câu hỏi mẫu <span>có đáp án</span></h2>
{sample_html}
</section>

<section class="card faq" id="hoi-dap">
<h2>Câu hỏi <span>thường gặp</span></h2>
{faq_html}
</section>
</main>
<script>{js}</script>
{TAIL}'''
out = os.path.join(ROOT, 'bai', SLUG + '.html')
open(out, 'w', encoding='utf-8').write(page)
print('ok', out, N, 'câu', len(page) // 1024, 'KB', dict(topics))
