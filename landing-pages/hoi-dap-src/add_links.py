import sys; sys.path.insert(0,'hd'); from kb import KB
N=len(KB)
link=f'\n    <p style="text-align:center;margin-top:26px"><a class="btn btn-green" href="https://www.sun-fours-tower.com/hoi-dap">Xem đủ {N} câu hỏi – đáp →</a></p>'
for n in 'trang-chu toa-f2 bang-tinh-f2 gio-hang phap-ly toa-f2-ads'.split():
    f=f'lp-{n}.html'; t=open(f).read()
    if 'sun-fours-tower.com/hoi-dap">Xem đủ' in t: print(n,'skip'); continue
    i=t.index('<section class="faq"'); j=t.index('class="faq-list"',i); k=t.index('</div>',j)+6
    assert t.index('</section>',i)>k
    t=t[:k]+link+t[k:]; open(f,'w').write(t); print(n,'ok')
