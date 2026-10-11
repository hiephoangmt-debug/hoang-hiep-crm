# Hoàng Hiệp CRM

CRM quản lý khách hàng đổ về từ nhiều website / landing page. Biết **khách đến từ web nào, nguồn quảng cáo nào**, họ đã **bấm Zalo / gọi điện / Messenger** chưa, và **mình đã gọi / nhắn lại cho họ chưa**.

Không cần cài thư viện: chỉ cần Node.js ≥ 22.13 (dùng SQLite có sẵn).

## Chạy

```bash
ADMIN_PASSWORD='mat-khau-cua-ban' PORT=3000 node server.js
```
Mở `http://localhost:3000`, đăng nhập. Dữ liệu lưu ở `data/crm.db` (đặt `DATA_DIR` để đổi, nhớ sao lưu). Khi đưa lên internet hãy đặt sau HTTPS (Nginx/Caddy/Cloudflare).

## Cách dùng

1. Tab **Website & mã nhúng** → thêm website → dán đoạn `<script ... data-key="...">` vào `<head>` của landing (LadiPage: Cài đặt → Mã tuỳ chỉnh).
2. Mã nhúng tự động:
   - đếm lượt truy cập, lưu nguồn đầu tiên (utm_*, gclid → google, fbclid → facebook, referrer);
   - ghi nhận **click Zalo** (`zalo.me`), **gọi điện** (`tel:`), **Messenger** (`m.me`), SMS;
   - bắt **form có ô số điện thoại** → tạo khách (trùng SĐT thì gộp, không tạo lại);
   - gắn lịch sử click trước đó của người đó vào hồ sơ khách khi họ gửi form.
3. Nút không phải thẻ `<a>`: thêm `data-crm-click="zalo"` (hoặc `phone`, `messenger`). Form tự dựng: webhook `POST /api/lead?key=SITE_KEY` hoặc gọi `crmLead({name, phone})`.
4. Trong **Khách hàng**, bấm **Zalo / Gọi** ngay trên dòng khách: mở app và tự ghi nhận “đã nhắn / đã gọi”. Khách chưa ai liên hệ hiện nhãn đỏ **⚠ Chưa liên hệ** và luôn nằm trên cùng.
5. **Tổng quan**: số khách chưa liên hệ, thời gian phản hồi trung bình, thống kê theo website, theo ngày, theo nguồn/chiến dịch. **Click chưa có SĐT**: người bấm Zalo/Gọi nhưng chưa để lại số.

6. **Chiến dịch ads** (Facebook / Google / TikTok…): khai báo chiến dịch với mã `utm_campaign`, gắn mã đó vào link quảng cáo (nút "Link" tạo sẵn mẫu, Google dùng `{creative}`/`{keyword}`, Facebook dùng `{{ad.name}}`). CRM tự gom khách, lượt bấm Zalo/Gọi theo chiến dịch. Nhập chi phí bằng nút "+ Chi phí" hoặc dán CSV từ báo cáo FB/Google → ra **CPL, giá/hành động, ROAS**. Khi chốt khách, điền "Giá trị chốt" trong hồ sơ để tính doanh thu. Khách đến từ `utm_campaign` chưa khai báo sẽ được cảnh báo.

Lưu ý: bấm Zalo/Gọi trên web chỉ biết *có người bấm*, không biết tên/SĐT (trừ khi họ gửi form sau đó) – đó là giới hạn của trình duyệt.

## Bản Google Sheets
Không muốn thuê server? Xem `GOOGLE.md`: cùng tính năng theo dõi (web nào, click Zalo/gọi, đã liên hệ chưa, chiến dịch ads) chạy trên Google Sheets + Apps Script, miễn phí.

## Test
```bash
node test.js
node google/test-gas.mjs   # bản Google
```
