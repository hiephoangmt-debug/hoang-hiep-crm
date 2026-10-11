# Gắn nút Chat tự động + Zalo + Gọi vào LadiPage

LadiPage có thể bỏ thẻ <script> khi nhập HTML. Nếu trang đã xuất bản chỉ thấy nút Zalo/Gọi tĩnh (không có ô chat),
dán đoạn mã dưới vào: Trình chỉnh sửa LadiPage › Cài đặt trang › Mã tuỳ chỉnh (Javascript / HTML) › phần "Trước </body>"
(hoặc kéo phần tử "HTML" vào trang và dán vào đó), rồi Lưu và Xuất bản lại.

```html
<script src="https://cdn.jsdelivr.net/gh/hiephoangmt-debug/hoang-hiep-crm@a7fa3ca2810dce8090a6e56526446f4a93f7817b/website/public/assets/js/fc-widget.js" data-endpoint="" defer></script>
```

Khi có link CRM (/exec), điền vào data-endpoint="..." để chat và form lưu khách về CRM.
