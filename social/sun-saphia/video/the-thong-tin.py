from PIL import Image, ImageDraw, ImageFont
import sys
F="/usr/share/fonts/opentype/inter/"
def f(w,s): return ImageFont.truetype(F+{"b":"Inter-Bold.otf","sb":"Inter-SemiBold.otf","m":"Inter-Medium.otf","r":"Inter-Regular.otf","xb":"Inter-ExtraBold.otf"}[w],s)
NAVY=(16,36,72);NAVY2=(26,52,96);OR=(242,112,36);WH=(255,255,255);MUT=(190,203,225);CREAM=(250,246,238)
def wrap(d,t,font,maxw):
    out=[];line=""
    for w in t.split():
        x=(line+" "+w).strip()
        if d.textlength(x,font=font)<=maxw: line=x
        else: out.append(line);line=w
    out.append(line);return out
def card(path,tag,title,rows,note):
    W,H=1080,1350;im=Image.new("RGB",(W,H),NAVY);d=ImageDraw.Draw(im);P=72
    # header brand
    d.text((P,60),"SUN SAPHIA RESIDENCE",font=f("b",30),fill=WH)
    d.text((W-P,64),"Zalo 0904 567 009",font=f("sb",28),fill=OR,anchor="ra")
    y=150
    tf=f("b",26);tw=d.textlength(tag,font=tf)
    d.rounded_rectangle((P,y,P+tw+40,y+52),radius=26,fill=OR);d.text((P+20,y+12),tag,font=tf,fill=WH)
    y+=90
    ft=f("xb",62)
    for ln in wrap(d,title,ft,W-2*P): d.text((P,y),ln,font=ft,fill=WH);y+=78
    y+=30
    fb=f("xb",44);fs=f("m",30)
    avail=H-200-y; n=len(rows); rh=min(190,avail//n)
    for big,small in rows:
        d.rounded_rectangle((P,y,W-P,y+rh-18),radius=22,fill=NAVY2)
        d.rectangle((P,y,P+10,y+rh-18),fill=OR)
        bl=wrap(d,big,fb,W-2*P-70); sl=wrap(d,small,fs,W-2*P-70)
        th=len(bl)*54+len(sl)*40; yy=y+(rh-18-th)//2
        for l in bl: d.text((P+40,yy),l,font=fb,fill=WH);yy+=54
        for l in sl: d.text((P+40,yy),l,font=fs,fill=MUT);yy+=40
        y+=rh
    fn=f("r",24);yy=H-170
    for l in wrap(d,note,fn,W-2*P): d.text((P,yy),l,font=fn,fill=MUT);yy+=32
    d.line((P,H-80,W-P,H-80),fill=NAVY2,width=2)
    d.text((P,H-62),"Hoàng Hiệp Đà Nẵng · sun-saphia-residence.com",font=f("sb",24),fill=WH)
    im.save(path,quality=90)
D=sys.argv[1]
card(D+"/dong-tien.jpg","BÀI TOÁN MINH HỌA","Cho thuê căn hộ mặt biển Đà Nẵng thu về bao nhiêu?",[
 ("Studio 30 m² · ~351 tr/năm","Giá tham khảo 3 tỷ · 2,5 tr/đêm · lấp đầy 60% · thực nhận 65% (~11,7%/năm)"),
 ("1BR 50 m² · ~492 tr/năm","Giá tham khảo 4,5 tỷ · 3,5 tr/đêm · lấp đầy 60% · thực nhận 65% (~10,9%/năm)"),
 ("81,3% lấp đầy","Khách sạn Sun Group miền Trung năm 2026 (từ 70,65% năm 2025)")],
 "Giá giả định chủ đầu tư trình bày tại Kick-off 23/10/2026, chưa phải giá bán. Không phải cam kết lợi nhuận.")
card(D+"/phap-ly.jpg","PHÁP LÝ","Pháp lý Sun Saphia Residence đã có gì?",[
 ("GCN đầu tư 2572746483","Sở Tài chính TP Đà Nẵng cấp, chứng nhận lần đầu 17/09/2026"),
 ("50 năm thời hạn dự án","Tính từ 17/09/2026, đến 09/2076"),
 ("100 năm niên hạn công trình","Công trình cấp I"),
 ("Nghị quyết 278/NQ-CP","18/9/2026: thời hạn chung cư theo niên hạn công trình"),
 ("Vietcombank · BIDV · NCB","Ngân hàng hỗ trợ cho vay")],
 "Theo tài liệu Kick-off của chủ đầu tư Sun Property. Nội dung giải thích chung, không thay thế tư vấn pháp lý.")
card(D+"/gia.jpg","GIÁ THAM KHẢO","Giá căn hộ mặt biển Đà Nẵng đang chào bán",[
 ("Studio: 5,2 – 10,5 tỷ","The Soleil · Futa Residence · Nobu"),
 ("1BR: 7,7 – 11,5 tỷ","The Soleil · Futa Residence · Nobu"),
 ("2BR: 17,4 – 21,7 tỷ","The Soleil · Futa Residence · Nobu"),
 ("Giá Sun Saphia: cuối 11/2026","Chủ đầu tư chưa công bố – dự kiến công bố khi mở bán")],
 "Giá chào bán các dự án ven biển khác, trình bày tại Kick-off 23/10/2026 – không phải giá Sun Saphia Residence.")
card(D+"/cach-cho-thue.jpg","CHO THUÊ","4 cách cho thuê căn hộ – chọn cách hợp với mình",[
 ("Ngắn ngày – tự vận hành","Studio view biển ~2,2–2,9 tr/đêm · dòng tiền cao nhất, tốn công nhất"),
 ("Ngắn ngày – giao vận hành","Phí quản lý thường 15–30% doanh thu · hợp người ở xa"),
 ("Theo tháng (3–6 tháng)","Studio khu vực ~18–20 tr/tháng · đều, ít công sức"),
 ("Dài hạn (từ 1 năm)","Đều nhất, thấp nhất · muốn \"để đó\" an tâm")],
 "Mức tham khảo thị trường Đà Nẵng. Phương án vận hành chính thức theo công bố của chủ đầu tư khi mở bán.")
card(D+"/vay.jpg","VAY NGÂN HÀNG","Vay mua căn hộ: trả bao nhiêu mỗi tháng?",[
 ("~12,5 triệu/tháng","Ví dụ: căn 3 tỷ · vay 50% (1,5 tỷ) · lãi 8%/năm · 20 năm · trả đều gốc + lãi"),
 ("Vốn tự có 1,5 tỷ","Phần còn lại theo tiến độ thanh toán"),
 ("Vietcombank · BIDV · NCB","Hỗ trợ lãi suất theo chính sách khi mở bán"),
 ("Hồ sơ vay","CCCD, cư trú, hôn nhân · chứng minh thu nhập · HĐ mua bán/đặt cọc")],
 "Số liệu giả định để minh họa; giá 3 tỷ chưa phải giá bán. Con số thực tế theo hồ sơ và chính sách từng ngân hàng.")
card(D+"/thue-chi-phi.jpg","CHO THUÊ","Cho thuê căn hộ: thuế và chi phí cần tính",[
 ("Thuế ~10% doanh thu","Doanh thu trên 100 tr/năm: 5% GTGT + 5% TNCN (TT 40/2021/TT-BTC)"),
 ("Chi phí vận hành","Phí quản lý, dọn phòng, điện nước, hoa hồng Airbnb/Booking"),
 ("Nội thất","Bàn giao hoàn thiện cơ bản – dự trù trước khi cho thuê"),
 ("Mùa vụ & quy định","Mùa mưa (~9–12) lấp đầy thấp hơn · khai báo tạm trú cho khách")],
 "Nội dung tham khảo chung theo quy định hiện hành; nên kiểm tra lại với cơ quan thuế hoặc đơn vị vận hành.")
