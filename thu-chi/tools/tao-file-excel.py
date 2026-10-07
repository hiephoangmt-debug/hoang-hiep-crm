import os
from datetime import date
from openpyxl import Workbook
from openpyxl.styles import Font, PatternFill, Alignment, Border, Side
from openpyxl.worksheet.datavalidation import DataValidation
from openpyxl.chart import BarChart, Reference
from openpyxl.formatting.rule import CellIsRule
from openpyxl.workbook.properties import CalcProperties

N = int(os.environ.get('N', 2000))          # số dòng sổ giao dịch có công thức
OUT = os.environ.get('OUT', '/home/user/hoang-hiep-crm/thu-chi/Thu-Chi-Ke-Hoach-Me-Van.xlsx')
NC, NF, NL, ND, NA = 30, 40, 40, 15, 10    # số dòng: danh mục, chi phí cố định, khoản lớn, khoản nợ, tài khoản

F = 'Arial'
def font(**k): return Font(name=F, **k)
HL = PatternFill('solid', fgColor='FFF36B')
INP = PatternFill('solid', fgColor='FFFF00')
SOFT = PatternFill('solid', fgColor='F2F2F2')
RED, BLUE, GREEN, GREY = 'C00000', '0000FF', '1A7F4B', '808080'
thin = Side(style='thin', color='BFBFBF'); B = Border(top=thin, bottom=thin, left=thin, right=thin)
MONEY = '#,##0;[Red](#,##0);-'

def header(ws, row, cols, start=1):
    for j, h in enumerate(cols, start):
        c = ws.cell(row, j, h); c.font = font(bold=True); c.fill = HL; c.border = B
        c.alignment = Alignment(horizontal='center', vertical='center', wrap_text=True)
def title(ws, text, sub=None):
    ws['A1'] = text; ws['A1'].font = font(bold=True, size=15, color=RED)
    if sub: ws['A2'] = sub; ws['A2'].font = font(italic=True, color=GREY)
def inp(c, fmt=None):
    c.fill = INP; c.font = font(color=BLUE); c.border = B
    if fmt: c.number_format = fmt
def frm(c, fmt=MONEY, bold=False, color=None):
    c.font = font(bold=bold, color=color); c.border = B
    if fmt: c.number_format = fmt
def widths(ws, ws_w):
    for col, w in ws_w.items(): ws.column_dimensions[col].width = w

# ---------------- dữ liệu mẫu (từ bảng THU CHI THÁNG 8/2026) ----------------
cats = [('Lương & hoa hồng','Thu',None),('Thu khác / hoàn phí','Thu',None),
 ('Ăn uống & đi chợ','Chi',1000000),('Lãi vay căn hộ FPT','Chi',None),('Đóng tiền căn hộ (theo đợt)','Chi',None),
 ('Bảo hiểm (BHXH)','Chi',None),('Con cái (Mon)','Chi',500000),('Xăng xe & gửi xe','Chi',300000),
 ('Điện, nước, điện thoại','Chi',None),('Mua sắm cá nhân','Chi',2000000),('Đồ gia dụng & trả góp','Chi',1000000),
 ('Hiếu hỉ, sinh nhật, cúng lễ','Chi',2000000),('Giao lưu, ăn nhậu','Chi',1000000),('Thuốc & sức khỏe','Chi',500000),
 ('Công việc & marketing','Chi',1500000),('Chi khác','Chi',1000000)]
fixed = [('Lương ck + hoa hồng','Thu','Lương & hoa hồng',54000000,5,''),
 ('Lương vk + lãi làm thẻ','Thu','Lương & hoa hồng',40851000,5,'Số tháng 8/2026, có thể thay đổi'),
 ('Chợ + gas','Chi','Ăn uống & đi chợ',3000000,5,''),('Ăn','Chi','Ăn uống & đi chợ',3556000,5,''),
 ('Lãi căn hộ FPT','Chi','Lãi vay căn hộ FPT',8014000,5,'Tiền lãi – không trừ vào nợ gốc'),
 ('BHXH','Chi','Bảo hiểm (BHXH)',1540000,5,''),('Học Mon','Chi','Con cái (Mon)',1505000,5,''),
 ('Sữa Mon','Chi','Con cái (Mon)',562000,5,''),('Card điện thoại','Chi','Điện, nước, điện thoại',240000,5,''),
 ('Điện','Chi','Điện, nước, điện thoại',1714000,5,''),('Xăng ô tô + xe máy','Chi','Xăng xe & gửi xe',493000,5,''),
 ('Bãi xe','Chi','Xăng xe & gửi xe',800000,5,''),('Góp tủ lạnh','Chi','Đồ gia dụng & trả góp',500000,16,'Kỳ T2 đã đóng 16/08/2026')]
DEBT_FPT, DEBT_VAY, DEBT_TL = 'Căn hộ FPT (đóng theo đợt)', 'Vay ngân hàng căn hộ FPT', 'Góp tủ lạnh'
debts = [(DEBT_FPT,'FPT',None,None,None,None,'Đợt 3 đã đóng 83,056,000 (12/08/2026). Điền tổng giá trị còn phải đóng.'),
 (DEBT_VAY,'Ngân hàng',None,None,8014000,5,'Lãi 8,014,000/tháng (T8/2026). Điền số nợ gốc & tiền gốc trả mỗi tháng.'),
 (DEBT_TL,'Cửa hàng',None,500000,None,16,'Đã đóng kỳ T2 (16/08/2026). Điền tổng tiền góp.')]
tx = [(5,'Cố định','Lương & hoa hồng','Lương ck + hoa hồng',54000000,None,None),(5,'Cố định','Lương & hoa hồng','Lương vk + lãi làm thẻ + vé máy bay',40851000,None,None),
 (5,'Cố định','Ăn uống & đi chợ','Chợ + gas',None,3000000,None),(5,'Cố định','Lãi vay căn hộ FPT','Lãi căn hộ FPT T8',None,8014000,None),
 (5,'Cố định','Bảo hiểm (BHXH)','BHXH T8',None,1540000,None),(5,'Cố định','Con cái (Mon)','Học Mon',None,1505000,None),
 (5,'Cố định','Con cái (Mon)','Sữa Mon',None,562000,None),(5,'Cố định','Ăn uống & đi chợ','Ăn',None,3556000,None),
 (5,'Cố định','Điện, nước, điện thoại','Card',None,240000,None),(5,'Cố định','Xăng xe & gửi xe','Xăng ô tô + xe máy',None,493000,None),
 (5,'Cố định','Điện, nước, điện thoại','Điện',None,1714000,None),(5,'Cố định','Xăng xe & gửi xe','Bãi xe T8',None,800000,None),
 (5,'Phát sinh','Giao lưu, ăn nhậu','Nhậu Thùy + A Phụng',None,1168000,None),(5,'Phát sinh','Mua sắm cá nhân','Đồ ck + đồ Mon + đồ vk',None,3277000,None),
 (5,'Phát sinh','Hiếu hỉ, sinh nhật, cúng lễ','Cúng + chùa + Đám ma ông Đen + đồ cúng',None,947000,None),(5,'Phát sinh','Công việc & marketing','Dán kính + cpn vp',None,743000,None),
 (5,'Phát sinh','Hiếu hỉ, sinh nhật, cúng lễ','SN Sơ Ri + SN vk + đi núi thần tài',None,7612000,None),(5,'Phát sinh','Mua sắm cá nhân','Vỏ máy ảnh, ốp ipad',None,405000,None),
 (12,'Phát sinh','Đóng tiền căn hộ (theo đợt)','Đóng tiền FPT đợt 3',None,83056000,DEBT_FPT),(12,'Phát sinh','Thu khác / hoàn phí','Hoàn phí thường niên VIB',1299000,None,None),
 (16,'Phát sinh','Đồ gia dụng & trả góp','Góp tủ lạnh T2',None,500000,DEBT_TL),(16,'Phát sinh','Mua sắm cá nhân','Kem cn, son, kem dưỡng',None,800000,None),
 (16,'Phát sinh','Thuốc & sức khỏe','Thuốc',None,231000,None),(16,'Phát sinh','Đồ gia dụng & trả góp','Ra gối mền',None,2779000,None),
 (31,'Phát sinh','Công việc & marketing','Mkt ck',None,1000000,None)]
accounts = ['Tiền mặt','Tài khoản ngân hàng (ck)','Tài khoản ngân hàng (vk)','Ví điện tử (Momo, ZaloPay…)','Sổ tiết kiệm']

wb = Workbook()
names = ['Tổng quan','Kế hoạch tháng','Sổ giao dịch','Chi phí cố định','Khoản lớn sắp tới','Khoản nợ','Tiền & tài khoản','Thống kê tháng','Danh mục','Hướng dẫn']
wb.active.title = names[0]
for n in names[1:]: wb.create_sheet(n)
TQ, KH, SO, CD, KL, NO, TK, TKE, DM, HD = (wb[n] for n in names)
q = lambda n: "'" + n + "'"
SOq, CDq, KLq, NOq, TKq, DMq, TQq, KHq = (q(n) for n in ['Sổ giao dịch','Chi phí cố định','Khoản lớn sắp tới','Khoản nợ','Tiền & tài khoản','Danh mục','Tổng quan','Kế hoạch tháng'])
R = lambda col: f"{SOq}!${col}$2:${col}${N+1}"
S_DATE, S_GROUP, S_CAT, S_THU, S_CHI, S_DEBT, S_KEY = R('A'), R('B'), R('C'), R('E'), R('F'), R('G'), R('I')

# ================= Danh mục =================
title(DM, 'DANH MỤC & DỰ PHÒNG CHI PHÁT SINH', 'Ô vàng: người dùng sửa. Dự phòng phát sinh = số tiền để dành mỗi tháng cho các khoản không cố định (mình đặt tạm, sửa tùy ý).')
header(DM, 4, ['Danh mục','Loại (Thu/Chi)','Dự phòng chi phát sinh / tháng'])
for i in range(NC):
    r = 5 + i
    if i < len(cats):
        DM.cell(r,1,cats[i][0]); DM.cell(r,2,cats[i][1]); DM.cell(r,3,cats[i][2])
    for j in (1,2,3): inp(DM.cell(r,j), MONEY if j == 3 else None)
widths(DM, {'A':32,'B':15,'C':22})
dv = DataValidation(type='list', formula1='"Thu,Chi"', allow_blank=True); DM.add_data_validation(dv); dv.add(f'B5:B{NC+4}')
DM.freeze_panes = 'A5'
CAT_LIST = f"{DMq}!$A$5:$A${NC+4}"

# ================= Khoản nợ (tên dùng cho dropdown sổ giao dịch) =================
DEBT_LIST = f"{NOq}!$A$5:$A${ND+4}"

# ================= Sổ giao dịch =================

header(SO, 1, ['Ngày','Nhóm','Danh mục','Diễn giải','Thu','Chi','Trả nợ cho khoản','Ghi chú','Tháng (tự tính)'])
for i, (d, g, c, desc, thu, chi, debt) in enumerate(tx):
    r = i + 2
    SO.cell(r,1,date(2026,8,d)); SO.cell(r,2,g); SO.cell(r,3,c); SO.cell(r,4,desc); SO.cell(r,5,thu); SO.cell(r,6,chi); SO.cell(r,7,debt)
for r in range(2, N + 2):
    SO.cell(r,1).number_format = 'dd/mm/yyyy'
    for j in range(1, 9): SO.cell(r,j).font = font(color=BLUE)
    SO.cell(r,5).number_format = MONEY; SO.cell(r,6).number_format = MONEY
    SO.cell(r,9, f'=IF(A{r}="","",YEAR(A{r})*100+MONTH(A{r}))').font = font(color=GREY)
widths(SO, {'A':12,'B':11,'C':28,'D':42,'E':14,'F':14,'G':26,'H':22,'I':10})
SO.freeze_panes = 'A2'; SO.auto_filter.ref = f'A1:I{N+1}'
for rng, f1 in ((f'B2:B{N+1}', '"Cố định,Phát sinh"'), (f'C2:C{N+1}', '=' + CAT_LIST), (f'G2:G{N+1}', '=' + DEBT_LIST)):
    v = DataValidation(type='list', formula1=f1, allow_blank=True); SO.add_data_validation(v); v.add(rng)

# ================= Tổng quan: chọn tháng =================
title(TQ, 'TỔNG QUAN TÀI CHÍNH GIA ĐÌNH – MẸ VÂN')
TQ['A3'] = 'Xem tháng (để trống = tháng hiện tại):'; TQ['A3'].font = font(bold=True)
TQ['B3'] = 'Tháng'; TQ['D3'] = 'Năm'
inp(TQ['C3'], '0'); inp(TQ['E3'], '0')
TQ['G3'] = '=IF(OR(C3="",E3=""),YEAR(TODAY())*100+MONTH(TODAY()),E3*100+C3)'   # mã tháng này
TQ['H3'] = '=IF(MOD(G3,100)=12,(INT(G3/100)+1)*100+1,G3+1)'                   # mã tháng tới
for a in ('G3','H3'): TQ[a].font = font(color='FFFFFF'); TQ[a].number_format = '0'
KEY, NKEY = f"{TQq}!$G$3", f"{TQq}!$H$3"
LBL = lambda k: f'"T"&MOD({k},100)&"/"&INT({k}/100)'

# ================= Chi phí cố định =================
title(CD, 'CHI PHÍ & THU NHẬP CỐ ĐỊNH HẰNG THÁNG', 'Các khoản lặp lại mỗi tháng – dùng để lập kế hoạch tháng này & tháng tới. Cột "Đang áp dụng" = Không để tạm bỏ.')
header(CD, 4, ['Khoản','Loại (Thu/Chi)','Danh mục','Số tiền / tháng','Ngày trong tháng','Đang áp dụng','Đã ghi sổ tháng này?','Ghi chú'])
for i in range(NF):
    r = 5 + i
    if i < len(fixed):
        n_, k_, c_, a_, d_, note = fixed[i]
        for j, v_ in enumerate([n_, k_, c_, a_, d_, 'Có', None, note], 1):
            if v_ is not None: CD.cell(r, j, v_)
    for j in (1,2,3,4,5,6,8): inp(CD.cell(r,j), MONEY if j == 4 else ('0' if j == 5 else None))
    # đã ghi sổ: có giao dịch cùng danh mục trong tháng này với số tiền tương ứng (gợi ý)
    CD.cell(r,7, f'=IF(A{r}="","",IF(COUNTIFS({S_KEY},{KEY},{S_CAT},C{r})>0,"Có GD danh mục này","Chưa"))')
    frm(CD.cell(r,7), None, color=GREY)
r_tot = 5 + NF
CD.cell(r_tot, 1, 'TỔNG THU CỐ ĐỊNH / THÁNG').font = font(bold=True)
CD.cell(r_tot, 4, f'=SUMIFS(D5:D{r_tot-1},B5:B{r_tot-1},"Thu",F5:F{r_tot-1},"Có")'); frm(CD.cell(r_tot,4), bold=True, color=GREEN)
CD.cell(r_tot+1, 1, 'TỔNG CHI CỐ ĐỊNH / THÁNG').font = font(bold=True)
CD.cell(r_tot+1, 4, f'=SUMIFS(D5:D{r_tot-1},B5:B{r_tot-1},"Chi",F5:F{r_tot-1},"Có")'); frm(CD.cell(r_tot+1,4), bold=True, color=RED)
CD.cell(r_tot+2, 1, 'CÒN LẠI SAU CHI CỐ ĐỊNH').font = font(bold=True)
CD.cell(r_tot+2, 4, f'=D{r_tot}-D{r_tot+1}'); frm(CD.cell(r_tot+2,4), bold=True)
for rr in range(r_tot, r_tot+3):
    for j in range(1, 9): CD.cell(rr, j).fill = HL
FIX_THU, FIX_CHI = f"{CDq}!$D${r_tot}", f"{CDq}!$D${r_tot+1}"
for rng, f1 in ((f'B5:B{4+NF}', '"Thu,Chi"'), (f'C5:C{4+NF}', '=' + CAT_LIST), (f'F5:F{4+NF}', '"Có,Không"')):
    v = DataValidation(type='list', formula1=f1, allow_blank=True); CD.add_data_validation(v); v.add(rng)
widths(CD, {'A':30,'B':12,'C':28,'D':16,'E':10,'F':11,'G':18,'H':34})
CD.freeze_panes = 'A5'
CD_CAT, CD_AMT, CD_TYPE, CD_ON = (f"{CDq}!${c}$5:${c}${4+NF}" for c in 'CDBF')

# ================= Khoản lớn sắp tới =================
title(KL, 'KHOẢN THU / CHI LỚN SẮP TỚI (một lần, không lặp lại)', 'Ví dụ: đóng tiền căn hộ theo đợt, học phí kỳ mới, đám cưới, sửa xe… Ghi ngày dự kiến để tự đưa vào kế hoạch đúng tháng.')
header(KL, 4, ['Ngày dự kiến','Khoản','Loại (Thu/Chi)','Danh mục','Số tiền dự kiến','Trạng thái','Tháng (tự tính)','Ghi chú'])
KL.cell(5,2,'Đóng tiền FPT đợt 4'); KL.cell(5,3,'Chi'); KL.cell(5,4,'Đóng tiền căn hộ (theo đợt)'); KL.cell(5,6,'Chưa chi')
KL.cell(5,8,'Điền ngày & số tiền theo lịch thanh toán FPT (đợt 3: 83,056,000 ngày 12/08/2026)')
for i in range(NL):
    r = 5 + i
    for j in (1,2,3,4,5,6,8): inp(KL.cell(r,j), 'dd/mm/yyyy' if j == 1 else (MONEY if j == 5 else None))
    KL.cell(r,7, f'=IF(A{r}="","",YEAR(A{r})*100+MONTH(A{r}))'); frm(KL.cell(r,7), '0', color=GREY)
for rng, f1 in ((f'C5:C{4+NL}', '"Thu,Chi"'), (f'D5:D{4+NL}', '=' + CAT_LIST), (f'F5:F{4+NL}', '"Chưa chi,Đã chi,Hủy"')):
    v = DataValidation(type='list', formula1=f1, allow_blank=True); KL.add_data_validation(v); v.add(rng)
widths(KL, {'A':13,'B':30,'C':10,'D':28,'E':16,'F':11,'G':10,'H':50})
KL.freeze_panes = 'A5'
KL_CAT, KL_AMT, KL_TYPE, KL_ST, KL_KEY = (f"{KLq}!${c}$5:${c}${4+NL}" for c in 'DECFG')

# ================= Khoản nợ =================
title(NO, 'CÁC KHOẢN NỢ / TRẢ GÓP', 'Ô vàng: điền số nợ gốc, tiền gốc trả mỗi tháng. "Đã trả" tự cộng từ Sổ giao dịch (các dòng có chọn cột "Trả nợ cho khoản").')
header(NO, 4, ['Khoản nợ','Chủ nợ','Tổng nợ gốc ban đầu','Trả gốc mỗi tháng','Lãi mỗi tháng','Ngày trả hằng tháng',
               'Đã trả gốc (từ sổ)','Còn nợ','Số tháng còn','Dự kiến trả xong','Trả tháng đang xem','Ghi chú'])
for i in range(ND):
    r = 5 + i
    if i < len(debts):
        for j, v_ in enumerate(debts[i], 1):
            col = [1,2,3,4,5,6,12][j-1]
            if v_ is not None: NO.cell(r, col, v_)
    for j in (1,2,3,4,5,6,12): inp(NO.cell(r,j), MONEY if j in (3,4,5) else ('0' if j == 6 else None))
    NO.cell(r,7, f'=IF(A{r}="","",SUMIFS({S_CHI},{S_DEBT},A{r}))')
    NO.cell(r,8, f'=IF(OR(A{r}="",C{r}=""),"",C{r}-G{r})')
    NO.cell(r,9, f'=IF(OR(H{r}="",D{r}="",D{r}=0),"",ROUNDUP(H{r}/D{r},0))')
    NO.cell(r,10, f'=IF(I{r}="","",IF(I{r}<=0,"Đã xong",DATE(YEAR(TODAY()),MONTH(TODAY())+I{r},1)))')
    NO.cell(r,11, f'=IF(A{r}="","",SUMIFS({S_CHI},{S_DEBT},A{r},{S_KEY},{KEY}))')
    for j, fm in ((7,MONEY),(8,MONEY),(9,'0'),(10,'mm/yyyy'),(11,MONEY)): frm(NO.cell(r,j), fm)
rt = 5 + ND
NO.cell(rt,1,'TỔNG').font = font(bold=True)
for j, col in ((3,'C'),(4,'D'),(5,'E'),(7,'G'),(8,'H'),(11,'K')):
    NO.cell(rt, j, f'=SUM({col}5:{col}{rt-1})'); frm(NO.cell(rt,j), bold=True)
for j in range(1, 13): NO.cell(rt, j).fill = HL
NO.cell(rt+2,1,'Tổng phải trả mỗi tháng (gốc + lãi)').font = font(bold=True)
NO.cell(rt+2,4, f'=D{rt}+E{rt}'); frm(NO.cell(rt+2,4), bold=True, color=RED)
NO.cell(rt+3,1,'Lưu ý: chỉ chọn "Trả nợ cho khoản" ở Sổ giao dịch cho tiền trả GỐC (tiền lãi không làm giảm nợ).').font = font(italic=True, color=GREY)
widths(NO, {'A':30,'B':14,'C':17,'D':15,'E':14,'F':10,'G':16,'H':16,'I':10,'J':13,'K':15,'L':60})
NO.freeze_panes = 'A5'
DEBT_LEFT, DEBT_MONTHLY = f"{NOq}!$H${rt}", f"{NOq}!$D${rt+2}"

# ================= Tiền & tài khoản =================
title(TK, 'TIỀN CÒN BAO NHIÊU?', 'Bước 1: ghi số dư từng tài khoản tại 1 ngày (ngày chốt). Bước 2: app tự cộng thu, trừ chi trong Sổ giao dịch SAU ngày đó → ra tiền còn hiện tại.')
TK['A4'] = 'Ngày chốt số dư:'; TK['A4'].font = font(bold=True); inp(TK['B4'], 'dd/mm/yyyy')
TK['C4'] = '← để trống = tính từ đầu sổ giao dịch'; TK['C4'].font = font(italic=True, color=GREY)
header(TK, 6, ['Tài khoản / nơi giữ tiền','Số dư tại ngày chốt','Ghi chú'])
for i in range(NA):
    r = 7 + i
    if i < len(accounts): TK.cell(r,1,accounts[i])
    for j in (1,2,3): inp(TK.cell(r,j), MONEY if j == 2 else None)
ra = 7 + NA
rows_tk = [('Tổng số dư tại ngày chốt', f'=SUM(B7:B{ra-1})'),
 ('+ Thu sau ngày chốt (từ sổ)', f'=IF(B4="",SUM({S_THU}),SUMIFS({S_THU},{S_DATE},">"&B4))'),
 ('− Chi sau ngày chốt (từ sổ)', f'=IF(B4="",SUM({S_CHI}),SUMIFS({S_CHI},{S_DATE},">"&B4))'),
 ('TIỀN CÒN HIỆN TẠI (ước tính)', f'=B{ra}+B{ra+1}-B{ra+2}'),
 ('− Còn nợ (các khoản đã điền số gốc)', f'={DEBT_LEFT}'),
 ('TÀI SẢN RÒNG (tiền còn − nợ)', f'=B{ra+3}-B{ra+4}')]
for k, (l, f_) in enumerate(rows_tk):
    r = ra + k; TK.cell(r,1,l); TK.cell(r,2,f_)
    big = k in (3, 5)
    TK.cell(r,1).font = font(bold=big); frm(TK.cell(r,2), bold=big)
    if big: TK.cell(r,1).fill = HL; TK.cell(r,2).fill = HL
TK.cell(ra+7,1,'Mẹo: mỗi đầu tháng kiểm tra số dư thật trong ngân hàng, nếu lệch thì cập nhật lại ngày chốt & số dư.').font = font(italic=True, color=GREY)
widths(TK, {'A':40,'B':20,'C':40})
BAL_TOTAL = f"{TKq}!$B${ra}"; CASH_NOW = f"{TKq}!$B${ra+3}"; NET_WORTH = f"{TKq}!$B${ra+5}"

# ================= Kế hoạch tháng (theo danh mục) =================
title(KH, 'KẾ HOẠCH THU CHI – THÁNG NÀY & THÁNG TỚI', 'Tháng lấy theo ô chọn ở sheet "Tổng quan". Kế hoạch = Cố định + Dự phòng phát sinh + Khoản lớn trong tháng.')
KH['A3'] = '="Tháng này: "&' + LBL(KEY) + '&"     ·     Tháng tới: "&' + LBL(NKEY); KH['A3'].font = font(bold=True, size=12)
header(KH, 5, ['Danh mục','Loại','Cố định / tháng','Dự phòng phát sinh','Khoản lớn tháng này','KẾ HOẠCH THÁNG NÀY',
               'THỰC TẾ THÁNG NÀY','Còn được chi / còn chờ thu','% đã dùng','Khoản lớn tháng tới','KẾ HOẠCH THÁNG TỚI'])
for i in range(NC):
    r = 6 + i; src = 5 + i
    KH.cell(r,1, f"=IF({DMq}!A{src}=\"\",\"\",{DMq}!A{src})")
    KH.cell(r,2, f"=IF(A{r}=\"\",\"\",{DMq}!B{src})")
    KH.cell(r,3, f'=IF(A{r}="","",SUMIFS({CD_AMT},{CD_CAT},A{r},{CD_ON},"Có",{CD_TYPE},B{r}))')
    KH.cell(r,4, f'=IF(A{r}="","",IF(B{r}="Chi",N({DMq}!C{src}),0))')
    KH.cell(r,5, f'=IF(A{r}="","",SUMIFS({KL_AMT},{KL_CAT},A{r},{KL_KEY},{KEY},{KL_TYPE},B{r},{KL_ST},"<>Hủy"))')
    KH.cell(r,6, f'=IF(A{r}="","",C{r}+D{r}+E{r})')
    KH.cell(r,7, f'=IF(A{r}="","",IF(B{r}="Thu",SUMIFS({S_THU},{S_CAT},A{r},{S_KEY},{KEY}),SUMIFS({S_CHI},{S_CAT},A{r},{S_KEY},{KEY})))')
    KH.cell(r,8, f'=IF(A{r}="","",F{r}-G{r})')
    KH.cell(r,9, f'=IF(OR(A{r}="",N(F{r})=0),"",G{r}/F{r})')
    KH.cell(r,10, f'=IF(A{r}="","",SUMIFS({KL_AMT},{KL_CAT},A{r},{KL_KEY},{NKEY},{KL_TYPE},B{r},{KL_ST},"<>Hủy"))')
    KH.cell(r,11, f'=IF(A{r}="","",C{r}+D{r}+J{r})')
    for j in range(1, 12): frm(KH.cell(r,j), None if j <= 2 else ('0%' if j == 9 else MONEY), bold=(j in (6,7,11)))
rk = 6 + NC
for k, (lbl, typ) in enumerate((('TỔNG THU', 'Thu'), ('TỔNG CHI', 'Chi'))):
    r = rk + k; KH.cell(r,1,lbl)
    for j, col in ((3,'C'),(4,'D'),(5,'E'),(6,'F'),(7,'G'),(8,'H'),(10,'J'),(11,'K')):
        KH.cell(r,j, f'=SUMIFS({col}6:{col}{rk-1},$B$6:$B${rk-1},"{typ}")')
    KH.cell(r,9, f'=IF(F{r}=0,"",G{r}/F{r})')
    for j in range(1, 12):
        frm(KH.cell(r,j), None if j <= 2 else ('0%' if j == 9 else MONEY), bold=True, color=GREEN if typ == 'Thu' else RED); KH.cell(r,j).fill = HL
r = rk + 2; KH.cell(r,1,'DỰ KIẾN TỒN (thu − chi)')
for j, col in ((6,'F'),(7,'G'),(11,'K')):
    KH.cell(r,j, f'={col}{rk}-{col}{rk+1}'); frm(KH.cell(r,j), bold=True)
KH.cell(r,1).font = font(bold=True)
for j in range(1, 12): KH.cell(r,j).fill = HL
KH.conditional_formatting.add(f'I6:I{rk+1}', CellIsRule(operator='greaterThan', formula=['1'], font=Font(name=F, color=RED, bold=True)))
KH.conditional_formatting.add(f'H6:H{rk-1}', CellIsRule(operator='lessThan', formula=['0'], font=Font(name=F, color=RED, bold=True)))
widths(KH, {'A':30,'B':6,'C':15,'D':15,'E':15,'F':17,'G':17,'H':17,'I':9,'J':15,'K':17})
KH.freeze_panes = 'C6'
P_THU, P_CHI, A_THU, A_CHI, N_THU, N_CHI = (f"{KHq}!${c}${rr}" for c, rr in (('F',rk),('F',rk+1),('G',rk),('G',rk+1),('K',rk),('K',rk+1)))
P_BIG_NOW, P_BIG_NEXT = f"{KHq}!$E${rk+1}", f"{KHq}!$J${rk+1}"

# ================= Tổng quan (bảng điều khiển) =================
TQ['A5'] = '="THÁNG NÀY: "&' + LBL('G3'); TQ['A5'].font = font(bold=True, size=13, color=RED)
TQ['D5'] = '="THÁNG TỚI: "&' + LBL('H3'); TQ['D5'].font = font(bold=True, size=13, color=RED)
now_rows = [('Đã thu', f'={A_THU}', GREEN), ('Đã chi', f'={A_CHI}', RED), ('Tồn tháng này (thu − chi)', '=B6-B7', None),
 ('   trong đó chi cố định', f'=SUMIFS({S_CHI},{S_KEY},G3,{S_GROUP},"Cố định")', None),
 ('   trong đó chi phát sinh', '=B7-B9', None),
 ('Kế hoạch thu tháng này', f'={P_THU}', None), ('Kế hoạch chi tháng này', f'={P_CHI}', None),
 ('Còn được chi theo kế hoạch', '=B12-B7', None), ('Còn chờ thu theo kế hoạch', '=MAX(0,B11-B6)', None),
 ('Dự kiến tồn cuối tháng', '=MAX(B6,B11)-MAX(B7,B12)', None)]
for k, (l, f_, col) in enumerate(now_rows):
    r = 6 + k; TQ.cell(r,1,l); TQ.cell(r,2,f_)
    big = k in (2, 9); TQ.cell(r,1).font = font(bold=big); frm(TQ.cell(r,2), bold=big, color=col)
    if big: TQ.cell(r,1).fill = HL; TQ.cell(r,2).fill = HL
next_rows = [('Thu dự kiến', f'={N_THU}', GREEN), ('Chi cố định', f'={FIX_CHI}', None),
 ('Dự phòng chi phát sinh', f'=SUMIFS({DMq}!$C$5:$C${NC+4},{DMq}!$B$5:$B${NC+4},"Chi")', None),
 ('Khoản lớn trong tháng', f'={P_BIG_NEXT}', None), ('Tổng chi dự kiến', f'={N_CHI}', RED),
 ('DỰ KIẾN TỒN THÁNG TỚI', '=E6-E10', None)]
for k, (l, f_, col) in enumerate(next_rows):
    r = 6 + k; TQ.cell(r,4,l); TQ.cell(r,5,f_)
    big = k == 5; TQ.cell(r,4).font = font(bold=big); frm(TQ.cell(r,5), bold=big, color=col)
    if big: TQ.cell(r,4).fill = HL; TQ.cell(r,5).fill = HL
TQ['A17'] = 'TIỀN & NỢ'; TQ['A17'].font = font(bold=True, size=13, color=RED)
money_rows = [('Tiền còn hiện tại (ước tính)', f'={CASH_NOW}'), ('Tổng còn nợ', f'={DEBT_LEFT}'),
 ('Phải trả nợ mỗi tháng (gốc + lãi)', f'={DEBT_MONTHLY}'), ('Tài sản ròng (tiền − nợ)', f'={NET_WORTH}'),
 ('Tiền còn dự kiến cuối tháng tới', '=B18+MAX(0,B11-B6)-MAX(0,B12-B7)+E11')]
for k, (l, f_) in enumerate(money_rows):
    r = 18 + k; TQ.cell(r,1,l); TQ.cell(r,2,f_)
    big = k in (0, 4); TQ.cell(r,1).font = font(bold=big); frm(TQ.cell(r,2), bold=big)
    if big: TQ.cell(r,1).fill = HL; TQ.cell(r,2).fill = HL
TQ['D17'] = 'CẢNH BÁO'; TQ['D17'].font = font(bold=True, size=13, color=RED)
alerts = [f'=IF(B7>B12,"⚠ Đã chi vượt kế hoạch "&TEXT(B7-B12,"#,##0"),"✓ Chi trong kế hoạch")',
 f'=IF(B15<0,"⚠ Dự kiến tháng này âm "&TEXT(-B15,"#,##0"),"✓ Tháng này dự kiến không âm")',
 f'=IF(E11<0,"⚠ Tháng tới dự kiến thiếu "&TEXT(-E11,"#,##0"),"✓ Tháng tới dự kiến đủ tiền")',
 f'=IF({BAL_TOTAL}=0,"→ Chưa nhập số dư tài khoản: vào sheet Tiền & tài khoản","Tiền còn: "&TEXT(B18,"#,##0"))',
 f'=IF(COUNTIFS({KL_KEY},H3,{KL_ST},"Chưa chi")+COUNTIFS({KL_KEY},G3,{KL_ST},"Chưa chi")>0,"→ Có khoản lớn tháng này/tháng tới – xem sheet Khoản lớn","✓ Không có khoản lớn sắp tới")']
for k, f_ in enumerate(alerts):
    c = TQ.cell(18 + k, 4, f_); c.font = font(bold=True)
TQ.merge_cells('D18:F18'); TQ.merge_cells('D19:F19'); TQ.merge_cells('D20:F20'); TQ.merge_cells('D21:F21'); TQ.merge_cells('D22:F22')
widths(TQ, {'A':34,'B':18,'C':8,'D':30,'E':18,'F':18})
TQ['A25'] = 'Ô vàng ở dòng 3: gõ tháng & năm muốn xem (để trống = tự lấy tháng hiện tại). Chi tiết từng danh mục: sheet "Kế hoạch tháng".'
TQ['A25'].font = font(italic=True, color=GREY)

# ================= Thống kê tháng =================
title(TKE, 'THỐNG KÊ THU CHI THEO THÁNG')
TKE['A3'] = 'Năm:'; TKE['A3'].font = font(bold=True); TKE['B3'] = '=INT(' + KEY + '/100)'; frm(TKE['B3'], '0', bold=True)
header(TKE, 5, ['Tháng','Tổng thu','Tổng chi','Chi cố định','Chi phát sinh','Tồn','Tồn lũy kế','Tiết kiệm %','Số GD'])
for m in range(1, 13):
    r = 5 + m; key = f'($B$3*100+{m})'
    TKE.cell(r,1,f'T{m}')
    TKE.cell(r,2,f'=SUMIFS({S_THU},{S_KEY},{key})'); TKE.cell(r,3,f'=SUMIFS({S_CHI},{S_KEY},{key})')
    TKE.cell(r,4,f'=SUMIFS({S_CHI},{S_KEY},{key},{S_GROUP},"Cố định")'); TKE.cell(r,5,f'=C{r}-D{r}')
    TKE.cell(r,6,f'=B{r}-C{r}'); TKE.cell(r,7,f'=F{r}' if m == 1 else f'=G{r-1}+F{r}')
    TKE.cell(r,8,f'=IF(B{r}=0,"",F{r}/B{r})'); TKE.cell(r,9,f'=COUNTIFS({S_KEY},{key})')
    for j in range(1, 10): frm(TKE.cell(r,j), None if j == 1 else ('0%' if j == 8 else ('0' if j == 9 else MONEY)))
r = 18; TKE.cell(r,1,'CẢ NĂM')
for j, col in enumerate('BCDEF', 2): TKE.cell(r,j,f'=SUM({col}6:{col}17)')
TKE.cell(r,7,'=G17'); TKE.cell(r,8,'=IF(B18=0,"",F18/B18)'); TKE.cell(r,9,'=SUM(I6:I17)')
for j in range(1, 10): frm(TKE.cell(r,j), None if j == 1 else ('0%' if j == 8 else ('0' if j == 9 else MONEY)), bold=True); TKE.cell(r,j).fill = HL
widths(TKE, {'A':10,'B':16,'C':16,'D':16,'E':16,'F':16,'G':16,'H':11,'I':8})
ch = BarChart(); ch.type = 'col'; ch.title = 'Thu – Chi theo tháng'; ch.height = 8; ch.width = 22
ch.add_data(Reference(TKE, min_col=2, max_col=3, min_row=5, max_row=17), titles_from_data=True)
ch.set_categories(Reference(TKE, min_col=1, min_row=6, max_row=17)); TKE.add_chart(ch, 'K5')

# ================= Hướng dẫn =================
lines = [('THU CHI GIA ĐÌNH – MẸ VÂN · CÁCH DÙNG', font(bold=True, size=15, color=RED)), ('', None),
 ('MỖI NGÀY', font(bold=True, size=12)),
 ('• Ghi mỗi khoản thu/chi 1 dòng ở "Sổ giao dịch": Ngày, Nhóm (Cố định/Phát sinh), Danh mục, Diễn giải, Thu hoặc Chi.', None),
 ('• Nếu khoản chi là trả GỐC một khoản nợ → chọn tên khoản nợ ở cột "Trả nợ cho khoản" (nợ tự giảm).', None), ('', None),
 ('ĐẦU MỖI THÁNG', font(bold=True, size=12)),
 ('• "Tổng quan": xem tháng này còn được chi bao nhiêu, tháng tới dự kiến đủ hay thiếu tiền, tiền còn, nợ còn.', None),
 ('• "Kế hoạch tháng": kế hoạch & thực tế từng danh mục cho tháng này và tháng tới.', None),
 ('• "Chi phí cố định": các khoản lặp lại hằng tháng (lương, lãi căn hộ, học Mon, điện…). Sửa khi thay đổi.', None),
 ('• "Khoản lớn sắp tới": khoản chi/thu một lần có ngày dự kiến (đóng tiền FPT theo đợt, học phí…).', None),
 ('• "Tiền & tài khoản": ghi số dư thật của từng tài khoản tại 1 ngày chốt → biết tiền còn hiện tại.', None),
 ('• "Khoản nợ": điền tổng nợ gốc & tiền gốc trả mỗi tháng → biết còn nợ bao nhiêu, bao lâu trả xong.', None),
 ('• "Danh mục": thêm danh mục, đặt số dự phòng chi phát sinh mỗi tháng.', None), ('', None),
 ('QUY ƯỚC', font(bold=True, size=12)),
 ('• Ô nền VÀNG chữ XANH: người dùng nhập. Ô còn lại có công thức – không xóa.', None),
 ('• Số tiền nhập số nguyên (vd 3000000) – Excel tự hiện 3,000,000.', None),
 ('• Dữ liệu tháng 8/2026 lấy từ bảng THU CHI THÁNG 8/2026 của gia đình. Các ô nợ gốc, số dư tài khoản, ngày & số tiền FPT đợt 4 để trống vì chưa có số liệu – cần điền.', None),
 ('• Số "Dự phòng chi phát sinh" ở sheet Danh mục là số mình đặt tạm, sửa theo thực tế.', None)]
for i, (t, f_) in enumerate(lines, 1):
    c = HD.cell(i, 1, t); c.font = f_ or font(size=11)
HD.column_dimensions['A'].width = 130

wb.calculation = CalcProperties(fullCalcOnLoad=True)
wb.save(OUT)
print('saved', OUT, wb.sheetnames)
