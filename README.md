# hoang-hiep-crm
CRM – Real Estate Sales Management System

## Thu Chi Gia Đình – Mẹ Vân (`thu-chi/`)

Ứng dụng quản lý thu chi trong tháng (1 file HTML, không cần cài đặt) – mở `thu-chi/index.html` bằng trình duyệt:

- **Tổng quan**: tổng thu / chi / tồn, ngân sách còn lại, dự kiến tồn cuối tháng, chi theo danh mục, cảnh báo vượt ngân sách, khoản sắp đến hạn, xu hướng 6 tháng.
- **Sổ thu chi**: các khoản đã thu/chi trong tháng, lọc theo loại, nhóm (cố định/phát sinh), danh mục, tìm kiếm.
- **Lịch sử**: toàn bộ giao dịch mọi tháng (lọc theo khoảng ngày, danh mục, tìm kiếm) + nhật ký thêm/sửa/xóa trên mọi máy.
- **Tiền & Nợ**: số dư từng tài khoản tại ngày chốt + thu − chi sau đó = tiền còn hiện tại; các khoản nợ / trả góp (nợ gốc, đã trả – tự cộng từ giao dịch gắn "Trả nợ cho khoản", còn nợ, số tháng còn, dự kiến trả xong); tài sản ròng.
- **Thống kê**: 12 tháng trong năm – thu, chi, cố định, phát sinh, tồn, tồn lũy kế, % tiết kiệm, chi theo danh mục từng tháng.
- **Ảnh chụp**: chụp/chọn ảnh bảng thu chi → đọc chữ tiếng Việt ngay trên máy (Tesseract.js), tự tách cột Ngày/Diễn giải/Thu/Chi, đối chiếu dòng TỔNG CỘNG, cho sửa trước khi nhập.
- **Excel**: nhập bằng cách dán từ Excel hoặc chọn file .xlsx/.csv (tự nhận mẫu "THU CHI THÁNG"); xuất Excel theo tháng / năm / bộ lọc.
- **Kế hoạch sắp tới**: khoản cố định hằng tháng + kế hoạch riêng, bấm "Đã chi/Đã thu" để ghi sổ, khoản quá hạn, dự báo tháng sau.
- **Ngân sách**: đặt ngân sách theo danh mục (mặc định hoặc riêng từng tháng), theo dõi % đã dùng.
- **Báo cáo tháng**: giống mẫu Excel (Chi phí cố định / phát sinh / Tổng cộng), xuất CSV, in PDF.
- **Cài đặt**: danh mục, khoản cố định, sao lưu/khôi phục dữ liệu (.json).

File Excel dùng độc lập (kế hoạch tháng này & tháng tới, chi phí cố định, tiền còn, khoản nợ, thống kê): `thu-chi/Thu-Chi-Ke-Hoach-Me-Van.xlsx`.

Dữ liệu lưu trên trình duyệt và **đồng bộ nhiều máy qua Google Sheets** – xem [`thu-chi/HUONG-DAN-DONG-BO.md`](thu-chi/HUONG-DAN-DONG-BO.md). Đã nạp sẵn dữ liệu tháng 8/2026.
