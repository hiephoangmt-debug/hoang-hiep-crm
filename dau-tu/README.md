# Thống kê kênh đầu tư

Trang web biểu đồ theo ngày cho các kênh: **vàng SJC & thế giới, bạc, dầu Brent, S&P 500, VN-Index, VN30, HNX, UPCoM, khối ngoại mua/bán ròng,
30 cổ phiếu lớn (đang tăng / đi ngang / giảm), USD/VND, Bitcoin, bất động sản, lãi suất tiết kiệm**.

- Xem trang: `https://hiephoangmt-debug.github.io/hoang-hiep-crm/dau-tu/` (sau khi merge vào `main`).
- Ô **Tra cứu mã**: gõ mã hoặc tên công ty bất kỳ (HOSE, HNX, UPCoM) – trang lấy trực tiếp giá (VNDirect, dự phòng Simplize), giá trong phiên (VPS), khối ngoại (CafeF); danh sách mã do bot lưu mỗi ngày ở `data/ma_ck.json`.
- Tự cập nhật: workflow **Thống kê đầu tư** chạy mỗi giờ trong phiên (9:15–15:15, thứ 2–6) và 18:30 hằng ngày, lưu số vào `data/` rồi đăng lại trang.
- Lần đầu: vào tab **Actions → Thống kê đầu tư → Run workflow** để lấy ngay ~1–2 năm lịch sử
  (riêng giá SJC chỉ có từ ngày bắt đầu chạy).

## Nhập tay

| File | Cột | Ghi chú |
|---|---|---|
| `data/bds.csv` | `ngay,nhom,khu_vuc,gia_m2,gia_min,gia_max,loai_gia,nguon,url,ghi_chu` | giá triệu đồng/m². `nhom`: Căn hộ / Đất nền / Nhà riêng / Nhà mặt phố / Biệt thự. Có số trung bình thì điền `gia_m2`; nguồn chỉ cho khoảng giá thì điền `gia_min`/`gia_max` (để trống `gia_m2`). `loai_gia`: rao bán / sơ cấp / giao dịch / bình quân. `url`: link bài/báo cáo gốc. Chỉ nhập số có trong nguồn, không tự tính. |
| `data/lai_suat.csv` | `ngay,ngan_hang,ky_han_thang,lai_suat,hinh_thuc,ghi_chu` | Dự phòng khi bot không lấy được lãi suất tự động (`data/lai_suat_auto.json`, nguồn 24hMoney / Người Quan Sát) |

BĐS: số theo quý/tháng từ báo cáo Batdongsan.com.vn, DKRA, CBRE, Savills, Avison Young, VARS (mỗi dòng có link nguồn); phần giá rao Chợ Tốt Nhà do bot tự tính mỗi ngày. Lãi suất: bot tự lấy mỗi lần chạy. Cập nhật thêm dòng mới khi có số mới (sửa trực tiếp trên GitHub được, cả trên điện thoại).
Ngày viết dạng `YYYY-MM-DD`; tên khu vực / ngân hàng không dùng dấu phẩy.

| `data/lai_vay.csv` | `ngay,ngan_hang,loai,ky_han,lai_suat,chenh_lech,ghi_chu` | Lãi vay %/năm; `loai` = `Bình quân` (ngày = cuối tháng), `Mua nhà` (ky_han = thời gian cố định, VD `12 tháng`) hoặc `Kinh doanh` (`Ngắn hạn` / `Trung dài hạn`) |

## Đổi danh sách cổ phiếu

Sửa `BIG_STOCKS` trong `fetch_prices.py`.

## Nguồn

SJC – dự phòng PNJ, Bảo Tín Minh Châu, DOJI (giá vàng miếng), Yahoo Finance (vàng thế giới, USD/VND, Bitcoin), DNSE – dự phòng VNDirect (chỉ số, cổ phiếu),
CafeF (khối ngoại), Vietcombank (dự phòng tỷ giá). Nguồn nào lỗi thì bỏ qua, trang ghi chú ở cuối.
