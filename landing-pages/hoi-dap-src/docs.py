# Văn bản căn cứ cho từng câu trả lời (chỉ dùng văn bản đã công bố trên các trang)
DOCS = {
 'vb17239': ('VB 17239/SXD-QLN', 'Sở Xây dựng TP. Đà Nẵng', '19/09/2026', 'Xác nhận 2.394 căn (Tòa F2: 607 căn) đủ điều kiện bán; giới hạn thu tiền 30/70/95%; yêu cầu giải chấp trước khi ký HĐMB; không bán cho tổ chức, cá nhân nước ngoài.'),
 'gcn': ('GCN QSDĐ CP 912579 (lô A3-10)', 'Giấy chứng nhận quyền sử dụng đất', '12/06/2019', 'Lô đất Tòa F2, 3.910 m², đất ở đô thị; người nhận chuyển quyền được sử dụng đất ổn định lâu dài. Ba lô còn lại: CO 001524, CO 001525, CO 001526.'),
 'tcb': ('Cam kết bảo lãnh Techcombank', 'Ngân hàng TMCP Kỹ Thương Việt Nam', '26/09/2026', 'Cam kết phát hành thư bảo lãnh nghĩa vụ tài chính của chủ đầu tư cho người mua – Thỏa thuận MMD20265226177/TTCBLN/FOURS TOWER.'),
 'tb1738': ('TB 1738/TB-SCT', 'Sở Công Thương TP. Đà Nẵng', '09/04/2026', 'Xác nhận chủ đầu tư đã đăng ký hợp đồng mua bán căn hộ chung cư theo mẫu – gồm cả điều khoản bảo hành.'),
 'qd2755': ('QĐ 2755/QĐ-UBND', 'UBND TP. Đà Nẵng', '24/06/2026', 'Chấp thuận điều chỉnh chủ trương đầu tư, chấp thuận nhà đầu tư Công ty CP Địa Cầu.'),
 'tb151': ('TB khởi công 151/TB-GĐ-APC', 'Thông báo khởi công', '18/07/2026', 'Khởi công 21/07/2026, hoàn thành dự kiến 30/12/2027; quy mô 4 tòa, 2 hầm + 20 tầng nổi.'),
 'pccc': ('CV 518/TĐ-PCCC', 'Thẩm định thiết kế PCCC', '23/07/2026', 'Kết quả thẩm định thiết kế phòng cháy chữa cháy của công trình.'),
 'tb57': ('TB 57A & 57B/2026/TB-DCC', 'Công ty CP Địa Cầu', '01/04/2026', 'Công bố tên thương mại FourS Tower và đơn vị tư vấn, môi giới chỉ định S-Realty Đà Nẵng.'),
 'csbh': ('Chính sách bán hàng CSBH 4.2', 'CSBH 4.2/FT/SPG/09-2026 – Tòa F2', 'áp dụng từ 26/09/2026', 'Giá niêm yết, chiết khấu, tiến độ thanh toán, hỗ trợ lãi suất, miễn phí quản lý, lãi thanh toán trước hạn, Sun Signature, ngày nhận nhà.'),
 'gh': ('Giỏ hàng cập nhật 03/10/2026', 'Đơn vị phân phối', '03/10/2026', 'Danh sách căn đang bán, diện tích, hướng view, giá niêm yết gồm VAT & KPBT.'),
 'mb': ('Mặt bằng tầng & căn hộ Tòa F2', 'Chủ đầu tư phát hành', '', 'Mã căn, diện tích tim tường và thông thủy, vị trí sân vườn, công năng từng tầng.'),
 'hsbh': ('Hồ sơ dự án do chủ đầu tư công bố', 'Sun Property', '', 'Quy mô, tiện ích, tiêu chuẩn vật liệu bàn giao, vị trí và kết nối.'),
 'ev': ('Thư mời sự kiện Tháp F2', 'Sun Property', '11/10/2026', 'Sự kiện Giới thiệu dự án FourS Tower – Tháp F2, 9:00 Chủ nhật 11/10/2026, Novotel Danang Premier Han River, 36 Bạch Đằng.'),
 'luat': ('Luật KDBĐS 2023 & Luật Nhà ở 2023', 'Quốc hội', '', 'Điều 24, 26 Luật Kinh doanh BĐS (điều kiện bán, bảo lãnh); Điều 153 (kinh phí bảo trì), khoản 2 Điều 183 (giải chấp) và quy định bảo hành nhà chung cư tối thiểu 60 tháng của Luật Nhà ở.'),
}
SRC = {
 'su-kien':['ev'], 'chu-dau-tu':['qd2755','tb57'], 'quy-mo':['vb17239','tb151'], 'toa-f2':['vb17239','csbh'], 'thang-may':['mb','hsbh'],
 'cong-nang-tang':['mb'], 'tien-do':['tb151','pccc'],
 'dia-chi':['hsbh'], 'bien':['hsbh'], 'san-bay':['hsbh'], 'xung-quanh':['hsbh'], 'o-xa':['tv'],
 'du-dieu-kien':['vb17239','luat'], 'so-do':['gcn'], 'bao-lanh':['tcb','vb17239'], 'hop-dong-mau':['tb1738'],
 'gioi-han-thu-tien':['vb17239'], 'the-chap':['vb17239','luat'], 'bao-tri':['vb17239','luat'], 'nguoi-nuoc-ngoai':['vb17239'],
 'phap-ly-ky-tinh':['vb17239','gcn','tcb','tb1738','pccc'],
 'loai-can':['mb'], 'san-vuon':['mb'], 'view':['mb','tv'], 'mat-bang':['mb'], 'ban-giao-hoan-thien':['hsbh'], 'gia-dinh':['mb','tv'], 'tien-ich':['hsbh'],
 'gia-ban':['gh'], 'chiet-khau':['csbh'], 'gia-sau-ck':['csbh'], 'gia-da-gom':['csbh','gh'], 'qua-tang':['csbh'], 'han-uu-dai':['csbh'],
 'tien-do-tt':['csbh','vb17239'], 'vay':['csbh'], 'von-25':['csbh'], 'tra-hang-thang':['tv'], 'khong-vay':['csbh'], 'tt-som':['csbh'], 'tu-choi-bao-lanh':['csbh','tv'],
 'bl-la-gi':['luat'], 'bl-pham-vi':['luat'], 'bl-thu':['tcb','luat'], 'bl-vay':['csbh','tv'], 'bl-kiem-tra':['tcb','vb17239','tv'],
 'khi-nao':['csbh'], 'bh-thoi-han':['luat','tb1738'], 'bh-pham-vi':['luat','tb1738'], 'bh-cach':['tb1738','tv'], 'phi-quan-ly':['csbh'], 'cap-so':['vb17239'],
 'nen-dau-tu':['tv'], 'can-dau-tu':['tv'], 'so-sanh':['tv'],
 'giu-can':['csbh'], 'giay-to':['tv'], 'hoan-coc':['tv'], 'moi-gioi':['tb57'], 'gio-hang-con':['gh'],
}
TV = ('Góc tư vấn', 'Ý kiến chuyên viên – không phải nội dung văn bản')
