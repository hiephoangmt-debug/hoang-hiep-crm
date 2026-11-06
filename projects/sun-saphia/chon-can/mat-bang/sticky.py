"""Sửa lỗi bảng thông tin căn trượt mất, để lại màn xám:
- Khung chọn căn (iframe) không được tự cuộn bên trong: lăn chuột / vuốt luôn cuộn cả trang,
  nên bảng căn dài (2PN có ảnh nội thất) không bị kéo lên và khung không bị co lại.
- Bảng căn ngắn hơn màn hình thì bám ngay dưới thanh menu khi khách cuộn.
- Khi bấm căn, trang cuộn tới bảng chừa đúng chiều cao thanh menu.
Dùng: python3 sticky.py  (sửa tại chỗ chon-can-embed.js; build.py cũng gọi patch())."""
import json, pathlib

INNER = r'''<style id="ssNoScroll">html,body{overflow:hidden!important;overscroll-behavior:none}</style><script>(function(){
  addEventListener('scroll',function(){ if(window.scrollY||window.scrollX) window.scrollTo(0,0); },{passive:true});
  var VP=null;
  function stick(){ if(!VP||!document.body.classList.contains('picked')) return;
    var rc=document.getElementById('rc'), w=document.querySelector('.wrap'); if(!rc||!w) return;
    var wt=w.getBoundingClientRect().top, y=VP.y-wt, h=rc.offsetHeight, cur=parseFloat(rc.style.top)||0;
    var hi=y+VP.hd+8, lo=y+VP.vh-h-8, t;
    if(h<=VP.vh-VP.hd-16) t=hi; else t=Math.min(Math.max(cur,lo),hi);
    var lim=w.offsetHeight-h-8; if(t>lim) t=lim; if(t<8) t=8;
    if(Math.abs(t-cur)>1) rc.style.top=t+'px'; }
  addEventListener('message',function(e){ var d=e.data; if(d&&d.ssccvp){ VP=d; stick(); } });
  document.addEventListener('click',function(e){ if(e.target.closest&&e.target.closest('#plan .u')) setTimeout(stick,120); });
})();</script>'''

PARENT_OLD = "fit(); window.addEventListener('resize', fit);"
PARENT_NEW = ("fit(); window.addEventListener('resize', fit);\n"
              "    function vp(){ var f=box.querySelector('iframe'); if(!f||!f.contentWindow) return; var hd=document.querySelector('header.top');"
              " try{ f.contentWindow.postMessage({ssccvp:1,y:-box.getBoundingClientRect().top,vh:window.innerHeight,hd:hd?hd.offsetHeight:0},'*'); }catch(x){} }\n"
              "    var vpq=0; function vps(){ if(vpq) return; vpq=1; requestAnimationFrame(function(){ vpq=0; vp(); }); }\n"
              "    window.addEventListener('scroll',vps,{passive:true}); window.addEventListener('resize',vps); setInterval(vp,1000);\n"
              "    window.addEventListener('message',function(e){ var d=e.data; if(d&&d.sscc==='pick'){ vp(); setTimeout(vp,150); setTimeout(vp,700); } });")
SCROLL_OLD = "+d.y-70,behavior:'smooth'"
SCROLL_NEW = "+d.y-((document.querySelector('header.top')||{}).offsetHeight||0)-12,behavior:'smooth'"

def _doc(out):
    i = out.index('var DOC = ') + len('var DOC = ')
    j = out.index(';\n', i)
    return i, j, json.loads(out[i:j].replace('<\\/', '</'))

def patch(out):
    i, j, doc = _doc(out)
    # bỏ bản vá cũ (nếu có) rồi chèn bản mới
    k = doc.find('<script>(function(){\n  var VP=null;')
    if k >= 0:
        doc = doc[:k] + doc[doc.index('</script>', k) + 9:]
    if 'ssNoScroll' not in doc:
        k = doc.rindex('</html>') if '</html>' in doc else len(doc)
        doc = doc[:k] + INNER + doc[k:]
    out = out[:i] + json.dumps(doc, ensure_ascii=False).replace('</', '<\\/') + out[j:]
    if 'ssccvp:1' not in out.split('var DOC = ')[0] + out[out.index(';\n', out.index('var DOC = ')):]:
        assert out.count(PARENT_OLD) == 1
        out = out.replace(PARENT_OLD, PARENT_NEW)
    out = out.replace(SCROLL_OLD, SCROLL_NEW)
    return out

if __name__ == '__main__':
    p = pathlib.Path(__file__).parent / 'chon-can-embed.js'
    p.write_text(patch(p.read_text(encoding='utf-8')), encoding='utf-8')
    print('ok')
