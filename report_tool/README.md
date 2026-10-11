# Công cụ điền báo cáo marketing tuần (PPTX)

```
pip install python-pptx openpyxl
python fill_report.py --template "COLLECTION_BÁO CÁO MARKETING THEO TUẦN.pptx" \
  --data casa.xlsx --week "05/10 - 11/10" \
  --campaign "CASAMIA BALANCA HOI AN-TATI INVEST ĐỢT 1" --period "15/09 - 27/09/2026" \
  --staff "Phan Hạnh" --images ./anh --out bao_cao_casa.pptx
```

- `--data`: tải Google Sheet về `.xlsx`. Cột được nhận theo tên tiêu đề (không theo vị trí), tuần theo nhãn `dd/mm - dd/mm`.
- Bảng có cột DEAL/MQL/SQL (không có trong sheet) được điền `-`.
- Bảng tuần (DEAL đứng trước LEAD) dùng số liệu của `--week`; các bảng còn lại dùng tổng mọi tuần. Mỗi ID tài khoản một dòng, thêm dòng TỔNG.
- Ảnh chứng từ: `<images>/<facebook|tiktok|zalo|google>/<ads|hoadon>/*.png` – chèn vào slide tương ứng (nhận diện theo tiêu đề slide và chữ "Demo"/"Hóa đơn").
- Chạy lại nhiều lần cho Casa và Sun với file xlsx/ảnh riêng.
- Test fixture: `python tests/make_fixtures.py <thư_mục>`.
