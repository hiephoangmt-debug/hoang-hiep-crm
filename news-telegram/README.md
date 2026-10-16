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
