# CRM – Căn hộ dịch vụ Hải Minh Đà Nẵng

Ứng dụng web tĩnh (không cần server) để quản lý dự án căn hộ dịch vụ Hải Minh.

## Tính năng
- **Tổng quan**: tổng số căn, căn trống, tỷ lệ lấp đầy, doanh thu thuê/tháng, pipeline khách hàng.
- **Căn hộ**: thêm/sửa/xoá căn (mã, tầng, loại, diện tích, giá thuê, trạng thái), lọc theo trạng thái.
- **Khách hàng**: quản lý lead (nguồn, căn quan tâm, giai đoạn, ghi chú), tìm kiếm và lọc theo giai đoạn.
- **Thông tin dự án**: địa chỉ, tiện ích, hotline, người phụ trách; xuất/nhập dữ liệu JSON.

## Sử dụng
Mở `index.html` bằng trình duyệt. Dữ liệu lưu trong `localStorage` của trình duyệt —
dùng **Xuất JSON** để sao lưu hoặc chuyển sang máy khác.

## Dữ liệu mẫu
`data.js` chứa dữ liệu **mẫu** (căn hộ, giá, khách hàng giả định). Hãy thay bằng thông tin thực tế
của dự án, hoặc nhập trực tiếp trên giao diện.
