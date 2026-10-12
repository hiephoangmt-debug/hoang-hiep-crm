# Kế hoạch nâng cấp HOÀNG HIỆP CRM (bản cá nhân)

## 1. Kiểm tra dự án thực tế

Repo này (`hoang-hiep-crm`, nhánh `claude/modest-rubin-wul27c`) **không phải Next.js / Supabase**. Hiện có hai bản:

| Bản | Công nghệ | Đang dùng |
|---|---|---|
| Google Sheets + Apps Script | `google/Code.gs`, `google/Crm.html`, dữ liệu trong Google Sheet | **Có**, đang chạy thật, nhận khách từ 14+ website |
| Node server | `server.js`, `public/` | Bản dự phòng, chưa dùng |

Không có thư mục Next.js, Supabase, migration hay bảng PostgreSQL nào trong repo hoặc các nhánh khác cùng repo. Vì vậy phương án trong tài liệu gốc (Next.js + Supabase) **chưa thể triển khai**: thiếu mã nguồn nền, thiếu thông tin dự án Supabase. Theo nguyên tắc "ưu tiên kiến trúc hiện tại, không xây lại không có lý do", các nâng cấp được làm **trên bản Google Sheets đang chạy**. Nếu sau này chuyển sang Supabase, cấu trúc dữ liệu dưới đây là bản đồ để chuyển.

## 2. Đối chiếu với yêu cầu

| Yêu cầu | Tình trạng |
|---|---|
| Kho khách trung tâm, chống trùng theo SĐT | Có (tab Khách hàng, chuẩn hoá SĐT, gửi lại form chỉ tăng "lần gửi") |
| Nguồn khách, chiến dịch (UTM đầu tiên) | Có. Chưa lưu từng lượt lead riêng (chỉ có tab Hoạt động ghi mọi lượt gửi form) |
| Ghi nhận người phụ trách | Có (cột T). **Mới thêm** lịch sử chuyển giao |
| Nhật ký chăm sóc | **Mới thêm** (tab Nhật ký) |
| Nhắc việc, Việc hôm nay | **Mới thêm** (tab "Việc hôm nay" trong giao diện) |
| Hồ sơ nhu cầu và tài chính | **Mới thêm**: ngân sách, mục đích, loại căn, vay, tiềm năng |
| Khách nhiều dự án quan tâm | Chưa. Mỗi khách hiện có 1 dự án đầu tiên + tab Hoạt động lưu các trang đã xem |
| AI trợ lý | Có bản hỏi đáp (tab Hỏi quân sư), cần khoá API. Chưa lưu lịch sử đề xuất |
| Nhập Excel | Chưa (Google Sheets dán trực tiếp vào tab Khách hàng được) |
| Audit log đầy đủ | Chưa. Có nhật ký chăm sóc và chuyển giao |
| Báo cáo nguồn khách | Có cơ bản (Tổng quan, Chiến dịch) |

## 3. Cấu trúc dữ liệu hiện có và mới thêm (Google Sheets)

- `Khách hàng` cột A–V (hiện có) và **W–AB mới**: Hẹn tiếp theo, Ngân sách, Mục đích mua, Loại căn quan tâm, Tiềm năng (tự đánh giá), Vay ngân hàng.
- `Nhật ký` (mới): thời gian, SĐT, tên, người phụ trách, loại, nội dung, kết quả, hẹn tiếp theo. Chỉ thêm dòng, không ghi đè.
- `Chuyển giao` (mới): thời gian, SĐT, tên, từ sale, sang sale, trạng thái lúc chuyển, lý do.
- `Sale` (mới): danh sách sale.
- `Hoạt động`, `Lượt bấm`, `Website` (có cột E Nhóm), `Chiến dịch`: như trước.

## 3b. Cập nhật đợt 2 (ui-13)

- Bảng khách hàng: 23 cột (ẩn/hiện, sắp xếp, lọc kết hợp, phân trang 25 dòng); iPhone dùng thẻ gọn.
- Hồ sơ: SĐT phụ, Zalo, tỉnh/thành, ngày sinh, nghề nghiệp, ngân sách min/max, vốn tự có, khoản vay, thời điểm mua, lý do chưa quyết định (cột AC–AO của tab Khách hàng).
- 12 trạng thái. Đổi trạng thái tự ghi vào Nhật ký, bắt buộc có lý do khi chuyển sang Mất hoặc Tạm dừng.
- Lịch sử chăm sóc không giới hạn (tab Nhật ký, 12 cột), số lần / lần gần nhất / kết quả gần nhất tính từ lịch sử thật.
- Lịch sử xem dự án (tab Xem dự án): nhiều dự án, nhiều lần; gợi ý lịch chăm sóc sau khi xem, người dùng xác nhận.
- Thêm khách thủ công có kiểm tra trùng SĐT (không tự gộp); nhập danh sách dán từ Excel có báo cáo dòng lỗi và dòng trùng.
- AI phân tích khách: đọc hồ sơ, lịch sử chăm sóc, lịch sử xem dự án; có nút Sao chép, Tạo công việc (xác nhận), Đánh dấu đã thực hiện. Không tự gửi tin.
- Việc hôm nay: thêm nhóm "đã xem dự án nhưng chưa theo dõi".

## 3c. Giao diện điện thoại (ui-14)

- Danh sách gọn: tên, số điện thoại, nút Gọi / Zalo, ngày phát sinh, dự án, trạng thái, tương tác gần nhất. Chạm vào khách mở trang chi tiết riêng, có nút "‹ Danh sách".
- Trang chi tiết: tổng quan (liên hệ, nguồn, ngày phát sinh, nhu cầu, tài chính, dự án quan tâm, lịch hẹn tiếp theo, phản hồi gần nhất), đặt lịch nhắc việc, thêm tương tác chăm sóc (lưu thành dòng mới trong tab Nhật ký, không giới hạn), ghi nhận xem dự án, chỉnh sửa thông tin.
- Quay lại danh sách giữ nguyên từ khoá tìm, bộ lọc, trang và vị trí cuộn; tương tác gần nhất trên danh sách cập nhật ngay sau khi thêm.
- Giao diện máy tính giữ nguyên.

Chưa làm: nhiều cơ hội độc lập cho một khách, upload file .xlsx trực tiếp (hiện dán từ Excel), nhắc việc nền tự động, phân quyền theo người dùng.

## 4. Chưa làm, cần quyết định hoặc cấu hình

1. Chuyển sang Next.js + Supabase: cần repo nền hoặc xác nhận tạo mới, và thông tin dự án Supabase.
2. Thông báo nhắc việc tự động (Zalo, email): Apps Script có thể làm bằng trigger theo giờ, chưa bật.
3. Nhiều dự án quan tâm cho một khách, nhập Excel, lưu lịch sử đề xuất AI và duyệt trước khi tạo việc.
4. Tiếp nhận lead trực tiếp từ Facebook/Google Ads (cần quyền API).
5. Phân quyền theo người dùng (hiện bảo vệ bằng khoá trong link).

## 5. Kiểm thử

`node google/test-gas.mjs` chạy `Code.gs` trong môi trường giả lập: ghi khách, chống trùng, khoá truy cập, nhật ký, chuyển giao, hẹn tiếp theo, quân sư AI (giả lập API).
Giao diện được kiểm tra bằng Playwright với dữ liệu giả. Chưa kiểm thử trên Apps Script thật.
