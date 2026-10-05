import sys; sys.path.insert(0,'hd')
from docs import DOCS, SRC, TV
DESC = {
 'tong-quan':'Chủ đầu tư, quy mô, tiến độ xây dựng',
 'vi-tri':'Địa chỉ, khoảng cách tới biển, sân bay, tiện ích quanh dự án',
 'phap-ly':'Đủ điều kiện bán, sổ đỏ, bảo lãnh, hợp đồng mẫu – có số văn bản',
 'can-ho':'Loại căn, diện tích, sân vườn, view, tiêu chuẩn bàn giao',
 'gia':'Giá niêm yết, chiết khấu 19%, cách tính giá sau chiết khấu',
 'thanh-toan':'Tiến độ thanh toán, vay 70%, hỗ trợ lãi suất 24 tháng',
 'ban-giao':'Ngày nhận nhà, phí quản lý, cấp sổ hồng',
 'dau-tu':'Cho thuê, chọn căn đầu tư, so sánh',
 'thu-tuc':'Giữ căn, đặt cọc, giấy tờ, người tư vấn',
}
cnt={c:sum(1 for x in KB if x[0]==c) for c,_,_ in CATS}
ndocs=len(DOCS)
def chip(k):
    if k=='tv': return f'<span class="src tv" title="{TV[1]}">💡 {TV[0]}</span>'
    n,org,d,_=DOCS[k]
    return f'<a class="src" href="#vb-{k}" title="{html.escape(org)}{(" · "+d) if d else ""}">📄 {html.escape(n)}</a>'
side=''.join(f'<a href="#hd-{c}"><span class="ic" aria-hidden="true">{ic}</span><span class="nm">{nm}</span><span class="ct">{cnt[c]}</span></a>' for c,nm,ic in CATS)
groups=''; num=0
for c,nm,ic in CATS:
    rows=''
    for cc,i_,q,a,k in KB:
        if cc!=c: continue
        num+=1
        rows+=f'''
      <details class="qa" id="{i_}"><summary><span class="qn">{num:02d}</span><span class="qt">{html.escape(q)}</span><span class="qi" aria-hidden="true"></span></summary>
        <div class="qa-a"><p>{a}</p>
          <div class="qa-src"><span class="lbl">Căn cứ</span>{''.join(chip(x) for x in SRC[i_])}</div>
          <div class="qa-act"><button type="button" class="ask-more" data-q="{html.escape(q)}">💬 Hỏi thêm trợ lý</button><button type="button" class="qa-copy" data-id="{i_}">🔗 Sao chép link câu này</button></div>
        </div>
      </details>'''
    groups+=f'''
<section class="hd-group" id="hd-{c}" aria-labelledby="h-{c}">
  <div class="hd-gh"><span class="ic" aria-hidden="true">{ic}</span><div><h2 id="h-{c}">{nm}</h2><p>{DESC[c]} · {cnt[c]} câu</p></div></div>
  <div class="qa-list">{rows}
  </div>
</section>
'''
doc_cards=''.join(f'''
      <article class="doc" id="vb-{k}"><span class="doc-ic" aria-hidden="true">📄</span><div><h3>{html.escape(n)}</h3><p class="meta">{html.escape(org)}{(" · "+d) if d else ""}</p><p>{html.escape(x)}</p></div></article>''' for k,(n,org,d,x) in DOCS.items())
hot=['Có sổ đỏ không?','Vay được bao nhiêu?','Chiết khấu bao nhiêu?','Khi nào nhận nhà?','Cách biển bao xa?']
main=f'''<main id="main" class="ph hd">
<section class="hd-hero">
  <div class="container">
    <nav class="crumbs" aria-label="Breadcrumb"><ol><li><a href="{U}/">Sun FourS Tower</a></li><li aria-current="page">Hỏi đáp</li></ol></nav>
    <span class="hd-eyebrow">Trung tâm hỏi đáp · Tòa F2</span>
    <h1>Hỏi gì cũng có câu trả lời<br><span>kèm văn bản căn cứ</span></h1>
    <p class="hd-lead">{N} câu khách hay hỏi nhất về giá, vay, pháp lý, bàn giao. Mỗi câu ghi rõ <b>số văn bản, cơ quan ban hành</b> để anh/chị tự đối chiếu – không nói suông.</p>
    <form class="hd-search" role="search" onsubmit="return false"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg><input id="hdQ" type="search" placeholder="Gõ câu hỏi… vd: sổ đỏ, vay 70%, cách biển" aria-label="Tìm câu hỏi" autocomplete="off" enterkeyhint="search"><kbd id="hdCount">{N} câu</kbd></form>
    <p class="hd-hint"><span>Hay hỏi:</span>{''.join(f'<button type="button" data-hq="{h}">{h}</button>' for h in hot)}</p>
    <ul class="hd-stats">
      <li><b>{N}</b><span>câu hỏi – đáp</span></li>
      <li><b>{ndocs}</b><span>văn bản căn cứ</span></li>
      <li><b>607</b><span>căn F2 đủ điều kiện bán</span></li>
      <li><b>24/7</b><span>trợ lý trả lời ngay</span></li>
    </ul>
  </div>
</section>
<div class="hd-trust"><div class="container"><span class="lbl">Trả lời dựa trên</span><a href="#vb-vb17239">VB 17239/SXD-QLN · Sở Xây dựng</a><a href="#vb-gcn">Sổ đỏ CP 912579</a><a href="#vb-tcb">Bảo lãnh Techcombank</a><a href="#vb-tb1738">HĐ mẫu 1738/TB-SCT</a><a href="#vb-csbh">CSBH 4.2</a></div></div>
<div class="hd-wrap container">
  <aside class="hd-side" aria-label="Nhóm câu hỏi">
    <nav class="hd-cats">{side}<a href="#van-ban"><span class="ic" aria-hidden="true">📚</span><span class="nm">Văn bản căn cứ</span><span class="ct">{ndocs}</span></a></nav>
    <div class="hd-sidecard"><b>Cần bản scan văn bản?</b><span>Gửi qua Zalo để anh/chị tự đối chiếu.</span><a class="btn btn-gold" href="#dang-ky">Nhận bản scan</a></div>
  </aside>
  <div class="hd-main">
    <div class="hd-none" id="hdNone" hidden><div><b>Chưa có sẵn câu này</b><span>Trợ lý trả lời ngay, hoặc chuyên viên kiểm tra văn bản và nhắn lại qua Zalo.</span></div><button type="button" class="btn btn-gold" id="hdAskNone">💬 Hỏi trợ lý ngay</button></div>
{groups}
    <section class="hd-docs" id="van-ban" aria-labelledby="h-vb">
      <div class="hd-gh"><span class="ic" aria-hidden="true">📚</span><div><h2 id="h-vb">Văn bản căn cứ</h2><p>Các câu trả lời trên dựa vào những văn bản này. Văn bản gốc và hợp đồng ký kết có giá trị pháp lý.</p></div></div>
      <div class="doc-grid">{doc_cards}
      </div>
      <p class="doc-note">💡 Câu gắn nhãn <b>“Góc tư vấn”</b> là ý kiến của chuyên viên, không phải nội dung văn bản.</p>
    </section>
    <div class="hd-ask"><div><b>Còn thắc mắc chưa có ở đây?</b><span>Nhắn trợ lý – trả lời tự động 24/7, hoặc gọi 0904 567 009.</span></div><button type="button" class="btn btn-gold" data-ask="">💬 Hỏi trợ lý</button></div>
  </div>
</div>
'''
