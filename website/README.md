# Website FPT City Đà Nẵng (fpt-city.com)

Website tĩnh, chuẩn SEO, gồm các trang:

| Trang | URL |
|---|---|
| Trang chủ FPT City | `/` |
| Đất nền FPT City (tổng quan) | `/dat-nen-fpt-city/` |
| Phân khu V1 … V6 | `/dat-nen-fpt-city/phan-khu-v1/` … |
| Căn hộ FPT Plaza (so sánh) | `/can-ho-fpt-plaza/` |
| FPT Plaza 1 … 5 | `/fpt-plaza-1/` … `/fpt-plaza-5/` |

Mỗi trang có title/description/keywords riêng, canonical, Open Graph, schema JSON-LD
(BreadcrumbList, FAQPage, Place/ApartmentComplex), sitemap.xml, robots.txt và liên kết nội bộ.

## Cấu hình (bắt buộc trước khi chạy thật)

1. **Link Google Drive**: `src/data.mjs` → `site.drive` (mặc định). Mỗi phân khu / tòa Plaza
   có thể có link riêng: thêm `drive: "https://drive.google.com/..."` vào object tương ứng.
2. **Hotline, Zalo, email, popup, đếm ngược**: khối `CONFIG` đầu file `public/assets/js/main.js`.
   `offerEndsAt` chỉ điền khi có hạn ưu đãi thật (để trống = ẩn đồng hồ).
3. **Lưu khách hàng**: cài [Hoàng Hiệp CRM](../crm/README.md) rồi dán URL `/exec` vào `CONFIG.leadEndpoint`.
   Khách vào CRM (tab `CRM_LEADS`) và vẫn ghi vào tab dự án theo định dạng cũ.

## Chat tư vấn & nút liên hệ

- Cụm nút cố định bên phải (máy tính và điện thoại): **Chat tư vấn**, **Zalo**, **Gọi**. Điện thoại có thêm thanh "Nhận bảng giá" ở đáy.
- Chat (`public/assets/js/chat.js`) trả lời tự động từ `public/assets/chat-kb.json` (sinh khi build từ `src/data.mjs`
  và mặt bằng FPT Plaza 4) – tra mã căn (VD `N-12.12`), mở layout căn, xin SĐT và gửi về CRM.
- AI tuỳ chọn qua CRM: xem mục *Chat AI* trong `crm/README.md`. Tắt AI: `CONFIG.chatAI = false`. Tắt lời chào tự hiện: `chatTeaserSeconds: 0`.
- Mở chat từ link bất kỳ: thêm `#chat` vào cuối URL.

## Kết nối hoanghiepmt.com (hoặc website/landing page khác) với CRM

- fpt-city.com đã liên kết về **hoanghiepmt.com** (menu, chân trang, schema `RealEstateAgent`) – cấu hình ở `site.agent` trong `src/data.mjs`.
- Để khách điền form trên hoanghiepmt.com cũng vào **Hoàng Hiệp CRM**, dán đoạn sau trước `</body>` của site đó
  (WordPress: plugin *Insert Headers and Footers* / LadiPage: *Cài đặt › Mã HTML/JS trước thẻ đóng body*):

```html
<script src="https://cdn.jsdelivr.net/gh/hiephoangmt-debug/hoang-hiep-crm@684f357465a7344acda91141a2bd7cf5c959d040/website/public/assets/js/hh-connect.js"
        data-endpoint="https://script.google.com/macros/s/XXXX/exec"
        data-project="hoanghiepmt.com"
        data-buttons="true" data-hotline="0904567009" data-zalo="0904567009" defer></script>
```

  - Tự nhận mọi form có ô số điện thoại (Contact Form 7, LadiPage, form tự viết…), gửi bản sao về CRM, **không chặn form gốc**.
  - Giữ utm/gclid của lượt truy cập đầu; chống gửi trùng 10 phút; bỏ qua form có `data-hh-ignore`.
  - Gán dự án riêng cho một form: thêm `data-hh-project="FPT Plaza 4"` vào thẻ `<form>`.
  - `data-buttons="true"`: hiện nút Gọi/Zalo cố định bên phải (bỏ đi nếu site đã có nút).

## Widget Chat · Zalo · Gọi cho LadiPage và mọi website

`public/assets/js/fc-widget.js` (sinh bởi `node src/build-widget.mjs` sau `build.mjs`) tạo cụm nút ở **góc dưới bên phải**:
💬 Chat tự động, Zalo, 📞 Gọi. Nằm trong Shadow DOM nên CSS của trang không làm hỏng; tự nhận dự án theo URL
(`/fpt-plaza-4`, `/phan-khu-v5`…), có sẵn kho kiến thức, tra mã căn, gửi SĐT về CRM, nút "Nhận giá" cuộn tới form
và điền mã căn vào ô `name="unit"`. Một dòng cho mọi trang (kể cả hoanghiepmt.com):

```html
<script src="https://cdn.jsdelivr.net/gh/hiephoangmt-debug/hoang-hiep-crm@684f357465a7344acda91141a2bd7cf5c959d040/website/public/assets/js/fc-widget.js"
        data-endpoint="LINK_/exec_CỦA_CRM" defer></script>
```

Tuỳ chọn: `data-hotline`, `data-zalo`, `data-project`, `data-drive`, `data-ai="false"`, `data-teaser="0"`.
Các trang LadiPage dựng bằng `build-ladipage.mjs` đã có sẵn thẻ này (chưa có `data-endpoint`): thêm link `/exec` vào
*Cài đặt trang › Mã tuỳ chỉnh › trước `</body>`* bằng cùng thẻ; script nạp hai lần vẫn chỉ chạy một cụm và nhận endpoint mới.
Sau khi sửa code, build lại, commit rồi thay mã commit trong đường dẫn CDN.

## Build & xem thử

```bash
npm run build      # sinh HTML vào public/
npm run preview    # build + chạy http://localhost:8080
```

Thêm phân khu (V7, V8…) hoặc tòa mới: thêm object vào `zones` / `plazas` trong `src/data.mjs`
rồi build lại – menu, footer, sitemap, liên kết nội bộ tự cập nhật.

## Triển khai

Upload thư mục `public/` lên hosting (Netlify, Vercel, Cloudflare Pages, cPanel…) và trỏ domain
`fpt-city.com` vào gốc. Sau đó khai báo `https://fpt-city.com/sitemap.xml` trong Google Search Console.

## Lưu ý nội dung

Số liệu tổng hợp từ báo chí và các nguồn thị trường; FPT Plaza 5 và đặc điểm từng phân khu
là thông tin **dự kiến / tham khảo** – cập nhật trong `src/data.mjs` khi chủ đầu tư công bố.

## Bộ trang LadiPage (fpt-city.com bản kéo-thả)

`node src/build-ladipage.mjs` dựng 14 trang HTML tuân thủ luật LadiPage (tabs, form, FAQ) vào `ladipage/`
cùng `manifest.json` (đường dẫn gợi ý từng trang). Nội dung lấy từ `src/data.mjs` và `src/fpt-plaza-4-units.mjs`;
CTA/ngữ điệu chỉnh trong `HOOKS` của `src/build-ladipage.mjs`.
Công cụ chỉ tạo/cập nhật trang; **xuất bản và gắn tên miền làm trong trình soạn thảo LadiPage**.
