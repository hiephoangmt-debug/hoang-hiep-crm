# news-telegram – Tin quy hoạch, hạ tầng, BĐS về Telegram

Cứ 30 phút, GitHub Actions quét các nguồn tin và gửi bài **mới** về Telegram:

- Sở Xây dựng Đà Nẵng (sxd.danang.gov.vn), Cổng TTĐT Đà Nẵng, Bộ Xây dựng (moc.gov.vn)
- Google News: Sở Xây dựng Đà Nẵng, quy hoạch / hạ tầng / BĐS Đà Nẵng, Bộ Xây dựng
- VnExpress, CafeF mục Bất động sản

Nguồn nào có `require_keywords: true` thì chỉ lấy bài có từ khoá (quy hoạch, hạ tầng,
giá đất, đấu giá đất, tái định cư, cao tốc, metro, khu đô thị…). Sửa nguồn và từ khoá
trong [`sources.json`](sources.json).

## Cài đặt (1 lần)

1. Telegram: nhắn **@BotFather** → `/newbot` → lấy **token**.
2. Thêm bot vào nhóm/kênh muốn nhận tin (kênh thì đặt bot làm admin), gửi 1 tin bất kỳ,
   rồi mở `https://api.telegram.org/bot<TOKEN>/getUpdates` để lấy `chat.id`
   (nhóm/kênh có dạng `-100…`).
3. GitHub repo → **Settings → Secrets and variables → Actions** → thêm
   `TELEGRAM_BOT_TOKEN` và `TELEGRAM_CHAT_ID`.
4. Tab **Actions → Tin BĐS về Telegram → Run workflow** để chạy thử.

Lần chạy đầu chỉ ghi nhận các bài đang có (không gửi) để khỏi bị dội tin cũ;
từ lần sau mới gửi bài mới. Danh sách bài đã gửi lưu ở `seen.json`.

## Chạy trên máy

```bash
pip install -r requirements.txt
DRY_RUN=1 SEND_ON_FIRST_RUN=1 python scan_news.py   # xem thử, không gửi
TELEGRAM_BOT_TOKEN=... TELEGRAM_CHAT_ID=... python scan_news.py
```

Lưu ý: một số trang `.gov.vn` có thể chặn truy cập từ máy chủ nước ngoài (GitHub
Actions chạy ở Mỹ). Khi đó nguồn đó được bỏ qua và ghi lỗi trong log; tin của Sở
vẫn đến qua các nguồn Google News.

## Đăng bản tin lên website (hiephoangmt.com)

Mỗi tin đã gửi Telegram được lưu vào `digest/YYYY-MM-DD.json`. Workflow **Bản tin lên website**
(`publish_digest.py`) đăng 1 bài/ngày *"Bản tin quy hoạch – hạ tầng Đà Nẵng sáng dd/mm/yyyy"*
vào chuyên mục **Hạ tầng & quy hoạch** (id 121), chia mục *Tin Đà Nẵng* / *Tin cả nước*,
mỗi tin gồm tiêu đề, tên báo, tóm tắt ngắn và link bài gốc.

- 08:20 mỗi sáng (trước 9h): đăng bản tin tổng hợp toàn bộ tin của ngày hôm trước.
- Chạy tay: **Actions → Bản tin lên website → Run workflow** (tích *bản nháp* để thử).

Cài đặt: WordPress → **Người dùng → Hồ sơ → Mật khẩu ứng dụng (Application Passwords)** → tạo
mật khẩu tên `bot-ban-tin`, rồi thêm 2 secret GitHub: `WP_USER` (tên đăng nhập WordPress) và
`WP_APP_PASSWORD` (mật khẩu ứng dụng vừa tạo).

## AI viết bài lên website

Workflow **AI viết bài lên website** (`rewrite_articles.py`) chạy 07:35 mỗi sáng:
lấy tin Đà Nẵng về quy hoạch – xây dựng – hạ tầng – nhà ở của hôm qua/hôm nay, Claude chọn tối đa
3 chủ đề nổi bật (gộp bài trùng, bỏ chủ đề đã viết – lưu ở `rewritten.json`), tra cứu nguồn bằng
web search/fetch rồi viết bài mới 600–900 từ có mục *Nguồn tham khảo*, đăng vào chuyên mục
**Hạ tầng & quy hoạch** và báo link về Telegram.

Cần secret `ANTHROPIC_API_KEY`. Chạy tay: **Actions → AI viết bài lên website → Run workflow**
(chọn số bài, tích *bản nháp* để thử).
