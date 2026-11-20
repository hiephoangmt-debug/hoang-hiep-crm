# Kiểm tra độ dài: tiêu đề ≤30, mô tả ≤90, đường dẫn hiển thị ≤15 (Google Ads RSA)
C={
'CHUNG (thương hiệu)':{
 'H':['Casamia Balanca Hội An','Phố Cổ, Biển Và Sông Cạnh Nhà','Biệt Thự Compound Bên Sông','Cạnh Rừng Dừa Bảy Mẫu','10 Phút Ra Phố Cổ Hội An','Gần Biển An Bàng, Cửa Đại','Nhà Đã Xây, Xem Tận Nơi','Chỉ 363 Căn Compound','Sổ Hồng Lâu Dài','Nhận Bảng Giá Qua Zalo','Ưu Đãi Tháng {Tháng}','Đặt Lịch Xem Nhà Mẫu','Kênh Sông Dẫn Vào Tận Khu','Tập Đoàn Đạt Phương','CĐT Thuê Lại Theo Chính Sách'],
 'D':['10 phút ra phố cổ, gần biển An Bàng, Cửa Đại. Sông Cổ Cò dẫn vào tận trong khu.','Khu compound 363 căn cao ráo, hạ tầng đồng bộ, nhà đã xây hiện hữu. Xem tận nơi.','Sổ hồng lâu dài. Vay tới 70%, hỗ trợ lãi theo chính sách CĐT. Zalo 0904 567 009.','CĐT thuê lại theo chính sách cho căn đủ điều kiện. Nhận bảng giá từng căn.'],
 'P':['nha-vuon','hoi-an']},
'A – HÀ NỘI / TỈNH XA (?kv=hn)':{
 'H':['Biệt Thự Hội An Có Sổ Hồng','Phố Cổ, Biển, Sông Cạnh Nhà','Ở Xa Vẫn Yên Tâm Sở Hữu','Nhà Đã Xây, Không Phải Chờ','Casamia Balanca Hội An','Tập Đoàn Đạt Phương','CĐT Vận Hành Khi Bạn Ở Xa','Miễn Phí Quản Lý 2 Năm','Sổ Lâu Dài, Để Lại Con Cháu','Xem Dự Án Qua Video Call','Đón Tại Sân Bay Đà Nẵng','1h20 Bay Từ Hà Nội','CĐT Thuê Lại Theo Chính Sách','Nhận Mẫu Hợp Đồng Đọc Trước','Chỉ 363 Căn Compound'],
 'D':['10 phút ra phố cổ, gần biển An Bàng. Khu compound bên sông, nhà đã xây hiện hữu.','Sổ hồng lâu dài, để lại cho con cháu. Chủ đầu tư Đạt Phương vận hành khi bạn ở xa.','CĐT thuê lại theo chính sách cho căn đủ điều kiện. Miễn phí quản lý 2 năm.','Ở Hà Nội vẫn xem được: video call nhà mẫu, nhận mẫu hợp đồng thuê lại đọc trước.'],
 'P':['o-xa','video-call']},
'B – HỘI AN / ĐÀ NẴNG (?kv=dn)':{
 'H':['Casamia Balanca Hội An','Đến Xem Tận Mắt Trong Ngày','Nhà Đã Xây, Nhận Nhà Sớm','Khu Compound Có Ban Quản Lý','Trường Mầm Non Trong Khu','10 Phút Ra Phố Cổ','Xem Ngay Mùa Mưa','Cao Độ Nền Theo Quy Hoạch','Hạ Tầng Ngầm Đồng Bộ','So Sánh Giá Với Đất Quanh','Cạnh Rừng Dừa Bảy Mẫu','Có Cổng, Có An Ninh','Sổ Hồng Lâu Dài','Hẹn Tại Nhà Mẫu Cuối Tuần','Đón Tận Nhà Đi Xem'],
 'D':['Nhà xây sẵn, sổ hồng, hạ tầng ngầm, có ban quản lý. Hẹn nhà mẫu hoặc đón tận nhà.','Mưa vẫn đi xem: xem cao độ nền và hạ tầng thực tế sau mưa. Gọi 0904 567 009.','Trường mầm non trong khu, công viên, sân pickleball đã có. 10 phút ra phố cổ.','Nhận bảng so sánh giá/m² với đất quanh khu để tự đánh giá trước khi đi xem.'],
 'P':['xem-thuc-te','hoi-an']},
}
bad=0
for k,v in C.items():
    print('\n#',k)
    for t in v['H']:
        n=len(t); bad+=n>30; print(f"  H {n:2d}{' !!' if n>30 else '   '} {t}")
    for t in v['D']:
        n=len(t); bad+=n>90; print(f"  D {n:2d}{' !!' if n>90 else '   '} {t}")
    for t in v['P']: bad+=len(t)>15
print('\nQUÁ DÀI:',bad)
