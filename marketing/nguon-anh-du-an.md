# Nguồn ảnh dự án cho bài Facebook (anh Hiệp gửi 05/11/2026)

Thư mục Google Drive tài liệu bán hàng của các dự án. Đọc bằng công cụ Google Drive
(`search_files` với `parentId = '<id>'`, rồi `download_file_content`).

| Dự án | Slug trên web | Thư mục gốc | Thư mục ảnh đã biết |
|---|---|---|---|
| Sun Costa Residence | sun-costa-residence | 1dM3pbavvbhVBmxCXUzGQhlMMHhIRxtQc | (chưa liệt kê được thư mục con, thử tìm lại) |
| Sun Solar Residence | sun-solar-residence | 1KA_lQuyHIbzUdVQ0KvbwBE5QY4WRTUIm | 3. HÌNH ẢNH 1mQwX2njODrhQpCni8EOsHXJwEg1cy1X_ → 1. PHỐI CẢNH 17eD11hHrsuSh8QVioin-OXXtstzbC8Cj, 2. VỊ TRÍ 1gOTdlgHbMcsx70HhKyVOv0jnpJLMY6He |
| Sun FourS Tower | fours-tower | 1I2Tw0mgkAS_KFWs41XrE2WxhVODlyCRs | (chưa liệt kê được thư mục con, thử tìm lại) |
| Sun Symphony Residence (giai đoạn 5) | sun-symphony-residence | 1gU4kr3ODIvYaN9R8dD8SQiOvb5qU7Bd5 | (chưa liệt kê được thư mục con, thử tìm lại) |
| S-Light Tower | s-light-tower | 1mtO1-elFF35raaWFOUiD-nkLZjgTUpLf | 3. HÌNH ẢNH 1N8WR8tsKi4i9v2FOQ6HwSaiv6AN_6mzy → 1. PHỐI CẢNH 1zDfS3XiEOlpQrY_SekvissRnx0CrA95S |
| Sun Saphia Residence | sun-saphia-residence | 1hIJlJeUbHuyPNzvJmoTs6injPAglGzSO | 3. HÌNH ẢNH 1t0_fb6fDGI48euSfPPUzQ34QDCfpy4ZS (còn: 1. GIỚI THIỆU 1yIPao5LiMZgp5CB8uPiL0-Py51xdIgpA, 4. VIDEO 1VJ2D-tauDWWYiiqgHO4X8IqgpeIQ3MM0) |

## Cách dùng cho bài FB
- Chỉ lấy từ các thư mục HÌNH ẢNH / PHỐI CẢNH / VỊ TRÍ. Không lấy file đào tạo (training), mặt bằng hay bảng giá nội bộ, chính sách bán hàng.
- Mở xem từng ảnh trước khi dùng. Bỏ ảnh có logo hay số điện thoại của đại lý khác, ảnh chỉ có chữ, ảnh mờ.
- Ảnh phối cảnh phải ghi rõ trong caption, VD "📷 Phối cảnh dự án (tài liệu CĐT)", để không ai hiểu là ảnh thực tế.
- Thu nhỏ cạnh dài còn ≤1600 px, lưu `marketing/fb/<slug-bai>-<n>.jpg`, push, rồi dùng link raw GitHub cho Metricool.
