"""Tạo xlsx + pptx giả lập đúng cấu trúc file thật để test."""
import sys, openpyxl
from pptx import Presentation
from pptx.util import Inches

out = sys.argv[1]
wb = openpyxl.Workbook(); ws = wb.active
ws.append(["Tên Sàn"]); ws.append(["Chi phí dự tính"]); ws.append([]); ws.append(["Thời gian", "Ngân sách Inhouse"])
r = [""] * 52; r[1] = "Facebook"; r[12] = "Tiktok"; r[23] = "Zalo"; r[34] = "Google"; r[45] = "Sự kiện"; ws.append(r)
metrics = ["ID tài khoản", "Chi phí thực chạy", "Chi phí thực chạy (+gồm phí nền tảng)", "Lead \n(lead thực tế nhận)", "",
           "Impressions\n(hiển thị)", "Reach\n(tiếp cận)", "Frequency \n(tần suất)", "Lượt nhấp", "CTR", "CPM", "Lượt xem"]
h = [""] + metrics[:4] + metrics[5:] + [""] * 0
h = [""] + metrics + [""] * 3
h = h[:13]; ws.append(h + metrics[:11] + metrics[:11] + metrics[:11])
ws.append(["05/10 - 11/10", "1091790822198238", "546,419", "583,384", 6, "", "97,231", "13,510", 1.43, 0, 0, "40,445.52"])
ws.append(["", "Phan Hạnh 391127499725110", "1,108,866", "1,218,866", 9, "", "135,430", "7,380", 1.45, 0, 0, "150,252.85"])
ws.append(["12/10 - 18/10"])
ws.append(["TỔNG"])
wb.save(out + "/data.xlsx")

prs = Presentation(); prs.slide_width, prs.slide_height = Inches(13.33), Inches(7.5)
def slide(texts, table=None):
    s = prs.slides.add_slide(prs.slide_layouts[6])
    for i, t in enumerate(texts):
        s.shapes.add_textbox(Inches(.5), Inches(.3 + i * .5), Inches(8), Inches(.4)).text_frame.text = t
    if table:
        t = s.shapes.add_table(2, len(table), Inches(.5), Inches(3), Inches(12), Inches(1)).table
        for j, c in enumerate(table): t.cell(0, j).text = c
s0 = ["REVIEW CHIẾN DỊCH CASAMIA BALANCA HOI AN-TATI INVEST ĐỢT 1", "Thời gian triển khai: 15/09 - 27/09/2026"]
slide(s0 + ["NGÂN SÁCH TỔNG CÁC KÊNH TRIỂN KHAI", "Facebook:", "Tiktok:", "Zalo:", "Google:"])
slide(s0 + ["TUẦN 1", ".......10.2026 - .....10.2026"], ["Nền tảng", "ID tài khoản", "Ngân sách thực chạy", "DEAL", "MQL ( Khách hàng quan tâm )", "SQL ( Khách hàng tiềm năng)", "LEAD", "Chi phí thực chạy ( + gồm phí nền tảng)"])
slide(s0 + ["BÁO CÁO TỔNG SÀN COLLECTION:"], ["Nền tảng", "ID tài khoản", "Ngân sách thực chạy", "Chi phí thực chạy ( + gồm phí nền tảng)", "LEAD", "MQL ( Khách hàng quan tâm )", "SQL ( Khách hàng tiềm năng)", "DEAL"])
slide(s0 + ["FACEBOOK ADS:", "*Demo: Lưu ý chụp đầy đủ thông tin"])
slide(s0 + ["Hóa đơn:", "FACEBOOK", "*Lưu ý cho capture Facebook ads"])
prs.save(out + "/mau.pptx")
