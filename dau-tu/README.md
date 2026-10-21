# Thống kê kênh đầu tư

Trang web biểu đồ theo ngày cho các kênh: **vàng SJC & thế giới, bạc, dầu Brent, S&P 500, VN-Index, VN30, HNX, UPCoM, khối ngoại mua/bán ròng,
30 cổ phiếu lớn (đang tăng / đi ngang / giảm), USD/VND, Bitcoin, bất động sản, lãi suất tiết kiệm**.

- Xem trang: `https://hiephoangmt-debug.github.io/hoang-hiep-crm/dau-tu/` (sau khi merge vào `main`).
- Tự cập nhật: workflow **Thống kê đầu tư** chạy mỗi giờ trong phiên (9:15–15:15, thứ 2–6) và 18:30 hằng ngày, lưu số vào `data/` rồi đăng lại trang.
- Lần đầu: vào tab **Actions → Thống kê đầu tư → Run workflow** để lấy ngay ~1–2 năm lịch sử
  (riêng giá SJC chỉ có từ ngày bắt đầu chạy).

## Nhập tay

| File | Cột | Ghi chú |
|---|---|---|
| `data/bds.csv` | `ngay,khu_vuc,gia_m2,ghi_chu` | giá triệu đồng/m², mỗi khu vực một đường |
| `data/lai_suat.csv` | `ngay,ngan_hang,ky_han_thang,lai_suat,ghi_chu` | %/năm; kỳ hạn 12 tháng dùng cho biểu đồ so sánh |

Hai file đang có **số liệu mẫu** – xoá và nhập số thật (sửa trực tiếp trên GitHub được, cả trên điện thoại).
Ngày viết dạng `YYYY-MM-DD`.

## Đổi danh sách cổ phiếu

Sửa `BIG_STOCKS` trong `fetch_prices.py`.

## Nguồn

SJC (giá vàng), Yahoo Finance (vàng thế giới, USD/VND, Bitcoin), DNSE – dự phòng VNDirect (chỉ số, cổ phiếu),
CafeF (khối ngoại), Vietcombank (dự phòng tỷ giá). Nguồn nào lỗi thì bỏ qua, trang ghi chú ở cuối.
