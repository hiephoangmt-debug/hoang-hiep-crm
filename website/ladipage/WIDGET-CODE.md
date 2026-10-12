# Gắn nút Chat tự động + Zalo + Gọi vào LadiPage

LadiPage có thể bỏ thẻ <script> khi nhập HTML. Nếu trang đã xuất bản chỉ thấy nút Zalo/Gọi tĩnh (không có ô chat),
dán đoạn mã dưới vào: Trình chỉnh sửa LadiPage › Cài đặt trang › Mã tuỳ chỉnh (Javascript / HTML) › phần "Trước </body>"
(hoặc kéo phần tử "HTML" vào trang và dán vào đó), rồi Lưu và Xuất bản lại.

```html
<script src="https://cdn.jsdelivr.net/gh/hiephoangmt-debug/hoang-hiep-crm@0ba92053f267f50a4df37b411565593195f1905e/website/public/assets/js/fc-widget.js" data-endpoint="" defer></script>
```

Khi có link CRM (/exec), điền vào data-endpoint="..." để chat và form lưu khách về CRM.
