# Trang /tinh-dong-tien: bảng tính dòng tiền cho thuê theo loại căn (cho thuê ngày / tháng)
from parts import *
from blocks import tbl, cta_block, related

CSS = '''
.tdt{display:grid;grid-template-columns:1.05fr .95fr;gap:22px;align-items:start}
.tdt .col{display:flex;flex-direction:column;gap:18px}
@media(min-width:901px){.tdt .res-col{position:sticky;top:90px}}
@media(max-width:900px){.tdt{grid-template-columns:1fr}}
.tc{background:#fff;border-radius:20px;padding:20px 20px 18px;box-shadow:var(--sh);border:1px solid var(--ln)}
.tc h2{font:800 18px/1.3 "Be Vietnam Pro",Arial,sans-serif;color:var(--nvd);margin:0 0 14px}
.seg{display:grid;gap:6px;background:var(--pp);border-radius:14px;padding:5px;margin-bottom:10px}
.seg.s3{grid-template-columns:repeat(3,1fr)}.seg.s2{grid-template-columns:repeat(2,1fr)}
.seg button{border:0;background:transparent;border-radius:11px;padding:10px 6px;font:600 15px/1.25 "Be Vietnam Pro",Arial,sans-serif;color:var(--mut);cursor:pointer}
.seg button small{display:block;font-size:12px;font-weight:500}
.seg button[aria-pressed=true]{background:#fff;color:var(--nvd);box-shadow:0 4px 12px -6px rgba(11,36,71,.35)}
.tc .hint{font-size:13px;color:var(--mut);margin:6px 0 0;text-align:left}
.sl{margin:4px 0 16px}
.sl .lb{display:flex;justify-content:space-between;gap:12px;font-size:14px;color:var(--ink);margin-bottom:8px}
.sl .lb b{color:var(--nvd);white-space:nowrap}
.sl input[type=range]{width:100%;height:28px;accent-color:var(--or)}
.res{background:linear-gradient(160deg,#FFF1E6,#FFE3CF);border:1px solid #F6C9A6}
.big{display:flex;align-items:baseline;gap:8px;flex-wrap:wrap;margin:2px 0 14px}
.big b{font:500 40px/1 Fahkwang,serif;color:var(--or)}
.big span{font-size:14px;font-weight:700;color:var(--nvd)}
.rows div{display:flex;justify-content:space-between;padding:9px 0;border-bottom:1px solid rgba(233,97,24,.18);font-size:15px}
.rows div b{color:var(--ink)}
.rows .neg b{color:#B23A1E}.rows .pos b{color:#1E7A43}
.buy{margin-top:14px}
.buy label{display:block;font-size:14px;color:var(--ink);margin-bottom:6px}
.buy .in{display:flex;align-items:center;gap:8px}
.buy input{flex:1;font:600 17px "Be Vietnam Pro",Arial,sans-serif;padding:12px 14px;border:2px solid var(--nvd);border-radius:12px;background:#fff;color:var(--ink);width:100%}
.buy .in span{color:var(--mut)}
.yield{margin:12px 0 0;font-size:15px;color:var(--ink);text-align:left!important}
.yield b{color:#1E7A43}
.res .btn{width:100%;margin-top:14px}
.why4{display:grid;grid-template-columns:1fr 1fr;gap:10px}
.why4 div{background:var(--pp);border-radius:14px;padding:12px 14px}
.why4 b{display:block;color:var(--nvd);font-size:17px}
.why4 span{font-size:13px;color:var(--mut)}
.tc .tw{box-shadow:none;border:1px solid var(--ln)}
.tc table.tbl{min-width:0;font-size:14px}
.zl-big{display:block;text-align:center;background:var(--nvd);color:#fff;text-decoration:none;font-weight:800;padding:15px;border-radius:14px}
'''

def page_body():
    units = [('studio', 'Studio', '30–31 m²'), ('1pn', '1PN+', '50–51 m²'), ('2pn', '2PN', '60–70 m²')]
    seg_u = ''.join('<button type="button" data-u="%s" aria-pressed="%s">%s<small>%s</small></button>' % (k, 'true' if i == 0 else 'false', n, a)
                    for i, (k, n, a) in enumerate(units))
    month = tbl(['Căn hộ cho thuê tháng', 'Giá/tháng'], [
        ['Panoma – Studio', '18–20 triệu'], ['Panoma – 1PN / 2PN', '24 / 35 triệu'], ['Filmore – 1PN / 2PN', '27 / 45 triệu'],
        ['Hilton – 2PN', '35 triệu'], ['Hiyori – 2PN', '25 triệu'], ['Sam Tower – 1PN / 2PN', '15 / 23 triệu'], ['Mornachy – 1PN / 2PN / 3PN', '14 / 20 / 35 triệu']])
    night = tbl(['Phòng view biển thuê ngày (mùa thấp điểm)', 'Giá/đêm'], [['Studio view biển', '2,2–2,9 triệu'], ['1BR+ view biển', '3,4–3,7 triệu']])
    left = (
        '<div class="col">'
        '<div class="tc o1"><h2>1. Chọn loại căn</h2><div class="seg s3" id="segU">' + seg_u + '</div>'
        '<div class="seg s2" id="segM"><button type="button" data-m="d" aria-pressed="true">Cho thuê ngày</button><button type="button" data-m="m" aria-pressed="false">Cho thuê tháng</button></div>'
        '<p class="hint" id="mHint"></p></div>'
        '<div class="tc o2"><h2>2. Giả định (chỉnh được)</h2>'
        '<div class="sl"><div class="lb"><span id="lbP">Giá thuê mỗi đêm</span><b id="oP"></b></div><input type="range" id="iP"></div>'
        '<div class="sl"><div class="lb"><span id="lbO">Tỷ lệ lấp đầy (số đêm có khách)</span><b id="oO"></b></div><input type="range" id="iO"></div>'
        '<div class="sl"><div class="lb"><span>Chi phí vận hành, quản lý</span><b id="oC"></b></div><input type="range" id="iC" min="5" max="50" step="1"></div>'
        '<p class="hint" id="cHint"></p></div>'
        '<div class="tc o4"><h2>Giá thuê khu vực để đối chiếu</h2>' + month + '<div style="height:12px"></div>' + night +
        '<p class="hint">Đối chiếu từ Wyndham Soleil, Saha Casa, Radisson Đà Nẵng và tin cho thuê các tòa ven sông Hàn (tài liệu Kick-off 23/10/2026).</p></div>'
        '</div>')
    right = (
        '<div class="col res-col">'
        '<div class="tc res o3"><h2>3. Kết quả ước tính</h2><div class="big"><b id="rM">–</b><span>/ tháng tiền về túi</span></div>'
        '<div class="rows"><div><span>Doanh thu mỗi năm</span><b id="rR">–</b></div><div class="neg"><span>Chi phí vận hành</span><b id="rC">–</b></div>'
        '<div class="pos"><span>Lợi nhuận mỗi năm</span><b id="rN">–</b></div></div>'
        '<div class="buy"><label for="iB">Giá mua căn (tỷ) – mặc định theo giá tham khảo chủ đầu tư dùng tại Kick-off; nhập lại khi có bảng giá</label><div class="in"><input id="iB" type="number" inputmode="decimal" min="0.5" max="50" step="0.1" value="3"><span>tỷ</span></div></div>'
        '<p class="yield" id="rY"></p>'
        '<button type="button" class="btn" id="sendRes" data-pop data-interest="Tính dòng tiền">Gửi tôi bảng tính chi tiết căn này</button></div>'
        '<div class="tc o5"><h2>Vì sao Saphia dễ cho thuê</h2><div class="why4">'
        '<div><b>Bãi biển</b><span>ngay trước dự án, chuỗi 3 công viên bãi tắm</span></div><div><b>500 m</b><span>tới ga LRT 09 (quy hoạch sân bay – Hội An)</span></div>'
        '<div><b>15,86 triệu</b><span>lượt khách tới Đà Nẵng 9 tháng 2026 (+29,6%)</span></div><div><b>Sun Group</b><span>thương hiệu giúp căn hộ dễ được khách chọn; khách sạn Sun Group miền Trung lấp đầy 81,3%</span></div>'
        '</div></div>'
        '<a class="zl-big o6" href="' + ZALO + '" target="_blank" rel="noopener">Chat Zalo ' + TEL_S + '</a>'
        '<p class="note o7"><b>Lưu ý:</b> đây là bảng tính tham khảo theo giả định, không phải cam kết lợi nhuận. Kết quả thực tế phụ thuộc giá mua, mùa du lịch, cách vận hành và chi phí thực tế. '
        'Sun Saphia Residence chưa công bố giá bán chính thức; giá thuê đối chiếu lấy từ tài liệu sự kiện Kick-off tháng 10/2026.</p>'
        '</div>')
    js = '''<script>(function(){
var U={studio:{d:[2.5,1,5,0.1],m:[19,10,35,1],n:'Studio'},'1pn':{d:[3.5,1.5,7,0.1],m:[25,12,45,1],n:'1PN+'},'2pn':{d:[4.5,2,9,0.1],m:[35,18,60,1],n:'2PN'}};
var u='studio',m='d',$=function(i){return document.getElementById(i)};
var st={d:{p:null,o:60,c:35},m:{p:null,o:11,c:10}};
function fm(v){return Math.round(v).toLocaleString('vi-VN')}
function setRange(el,a){el.min=a[1];el.max=a[2];el.step=a[3];}
function load(){var a=U[u][m];setRange($('iP'),a);$('iP').value=(st[m].p&&st[m].u===u)?st[m].p:a[0];
 if(m=='d'){$('iO').min=30;$('iO').max=90;$('iO').step=1;$('lbP').textContent='Giá thuê mỗi đêm';$('lbO').textContent='Tỷ lệ lấp đầy (số đêm có khách)';
  $('mHint').textContent='Cho thuê ngày kiểu Airbnb, khách du lịch. Doanh thu cao hơn nhưng cần đơn vị vận hành.';$('cHint').textContent='Gồm phí vận hành, dọn phòng, nền tảng đặt phòng, điện nước, phí quản lý.';}
 else{$('iO').min=6;$('iO').max=12;$('iO').step=1;$('lbP').textContent='Giá thuê mỗi tháng';$('lbO').textContent='Số tháng có khách trong năm';
  $('mHint').textContent='Cho thuê tháng cho chuyên gia, nhân sự resort, gia đình. Ổn định, ít công vận hành.';$('cHint').textContent='Gồm phí quản lý tòa nhà, môi giới, bảo trì.';}
 if(u=='2pn')$('mHint').textContent+=(m=='d'?' Giá thuê đêm 2PN là giả định (chưa có số liệu đối chiếu), anh/chị chỉnh theo ý mình.':'');
 $('iO').value=st[m].o;$('iC').value=st[m].c;calc();}
function calc(){var p=+$('iP').value,o=+$('iO').value,c=+$('iC').value,rev;
 if(m=='d'){rev=p*365*o/100;$('oP').textContent=String(p).replace('.',',')+' triệu';$('oO').textContent=o+'% (~'+Math.round(365*o/100)+' đêm)';}
 else{rev=p*o;$('oP').textContent=fm(p)+' triệu';$('oO').textContent=o+' tháng';}
 $('oC').textContent=c+'% doanh thu';var cost=rev*c/100,net=rev-cost;
 $('rM').textContent='~'+fm(net/12)+' triệu';$('rR').textContent=fm(rev)+' triệu';$('rC').textContent='−'+fm(cost)+' triệu';$('rN').textContent=fm(net)+' triệu';
 var b=parseFloat(String($('iB').value).replace(',','.'))||0,y=b>0?net/(b*1000)*100:0;
 $('rY').innerHTML=b>0?'Lợi nhuận mỗi năm ≈ <b>'+y.toFixed(1).replace('.',',')+'%</b> số tiền mua căn · hoàn vốn sau khoảng <b>'+(net>0?(b*1000/net).toFixed(1).replace('.',','):'–')+' năm</b> (chưa tính tăng giá căn hộ).':'Nhập giá mua để xem tỷ lệ lợi nhuận.';
 $('sendRes').setAttribute('data-interest','Tính dòng tiền – '+U[u].n+' · '+(m=='d'?'thuê ngày '+String(p).replace('.',',')+' tr/đêm, lấp đầy '+o+'%':'thuê tháng '+p+' tr, '+o+' tháng')+' · giá mua '+b+' tỷ · ~'+fm(net/12)+' tr/tháng');
 st[m].p=p;st[m].u=u;st[m].o=o;st[m].c=c;}
function pick(g,attr,cb){[].forEach.call(document.querySelectorAll('#'+g+' button'),function(x){x.addEventListener('click',function(){
 [].forEach.call(document.querySelectorAll('#'+g+' button'),function(y){y.setAttribute('aria-pressed',y===x?'true':'false')});cb(x.getAttribute(attr));});});}
pick('segU','data-u',function(v){u=v;st.d.p=null;st.m.p=null;$('iB').value={studio:'3','1pn':'4.5','2pn':''}[v];load();});pick('segM','data-m',function(v){m=v;load();});
['iP','iO','iC'].forEach(function(i){$(i).addEventListener('input',calc)});$('iB').addEventListener('input',calc);load();})();</script>'''
    return '<div class="tdt">' + left + right + '</div>' + js
