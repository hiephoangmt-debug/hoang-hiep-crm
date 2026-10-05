cc=open('chat-common.html').read().rstrip()+'\n'
for n in 'trang-chu toa-f2 bang-tinh-f2 gio-hang phap-ly toa-f2-ads'.split():
    f=f'lp-{n}.html'; t=open(f).read()
    ci=t.index('<style>\n/* ===== Chat tư vấn'); assert t.count('<style>\n/* ===== Chat tư vấn')==1
    t=t[:ci]+cc+t[t.index('</body>'):]; open(f,'w').write(t); print(n, len(t))
