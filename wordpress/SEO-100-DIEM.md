# Viết bài đạt điểm Rank Math tối đa (anh Hiệp 15/11/2026)

Mọi bài mới (lịch Sun Saphia, bản tin hạ tầng, Sở Xây dựng, bài viết tay) phải qua bộ chấm trước khi xuất:

```
php wordpress/scripts/kiem-tra-seo-bai.php <file data-bai-viet-…php> [--slug=slug-bai]
```

Bộ chấm trả mã lỗi nếu còn bài trượt. Sửa bài, chấm lại tới khi mọi bài hiện ✓ rồi mới xuất, commit.

## Bộ quy tắc khi viết

| Nhóm Rank Math | Quy tắc |
|---|---|
| Từ khoá chính | Cụm 3 – 6 từ, **chưa dùng ở bài nào khác** (bộ chấm tự dò trong các file data). |
| URL | Slug chứa đủ các chữ của từ khoá (không dấu); `https://hiephoangmt.com/<slug>/` ≤ 75 ký tự, tức slug ≤ 49 ký tự. |
| Tiêu đề SEO | ≤ 60 ký tự; **từ khoá ở nửa đầu** (tốt nhất đứng đầu); có **con số** (năm 2026, số liệu). |
| Mô tả SEO | 120 – 160 ký tự, chứa nguyên văn từ khoá. |
| Mở bài | Từ khoá nguyên văn trong câu đầu tiên (10% đầu bài). |
| Độ dài | **≥ 800 từ** tính cả Điểm chính và Hỏi đáp (Rank Math cần ≥ 600; dài hơn được điểm cao hơn). |
| Mật độ | Từ khoá xuất hiện nguyên văn **1 – 2,5%** số từ: bài 800 từ cần khoảng 8 – 12 lần, rải đều; dùng thêm trong Hỏi đáp. |
| Tiêu đề phụ | Ít nhất 1 thẻ H2 chứa nguyên văn từ khoá (VD "Sân golf gần Sun Saphia Residence: chọn sân nào?"). |
| Ảnh | Ít nhất 1 ảnh trong bài (`<!--hh-img:img/…|Chú thích-->`) có **chú thích chứa từ khoá** (chú thích thành alt ảnh). |
| Liên kết | ≥ 2 liên kết nội bộ (trang dự án, bài đã đăng trước) và ≥ 1 liên kết ngoài tới nguồn uy tín (cổng .gov.vn, báo lớn) – web tự để dofollow. |
| Đoạn văn | Mỗi đoạn ≤ 120 từ (tốt nhất 40 – 80 từ). |
| Mục lục | Web có plugin mục lục – bài nên có ≥ 3 thẻ H2. |

## Web tự lo phần còn lại

Khi bài lên web, `seo-bai-viet.php` tự: đưa từ khoá vào tiêu đề / mô tả nếu thiếu, khung "Điểm chính về {từ khoá}", mục "Đọc thêm về {từ khoá}" (liên kết nội bộ + H2 có từ khoá), alt ảnh có từ khoá, tách đoạn văn dài, bỏ nofollow với nguồn uy tín.

## Ghi chú theo bảng chấm thật của anh Hiệp (15/11/2026)

- Rank Math tiếng Việt chỉ chấm 2 mục "Khả năng đọc tiêu đề": **từ khoá ở đầu tiêu đề SEO** và **có con số** – không chấm "power word" / "cảm xúc", nên **100/100 làm được**.
- Mật độ = số lần từ khoá (cả từ khoá phụ) / tổng số từ × 100. Bài 508 từ, 5 lần → 0,98% là **trượt** – cần ≥ 1%.
- Độ dài URL tính **cả** `https://hiephoangmt.com/` (24 ký tự) + slug + `/` → slug ≤ 50 ký tự.
- "Từ khoá trong nội dung" phải khớp **nguyên văn** cụm từ khoá (VD từ khoá "khách du lịch Đà Nẵng 2026" mà bài chỉ viết "khách du lịch Đà Nẵng 9 tháng 2026" là trượt).
