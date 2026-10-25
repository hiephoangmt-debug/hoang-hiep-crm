#!/bin/bash
# CÀI BOT LÊN VPS (Ubuntu/Debian) – chạy: bash /root/bds-bot/cai_vps.sh
# Bot tự chạy 24/7, tự bật lại khi VPS khởi động lại hoặc khi bot lỗi.
set -e
DIR="$(cd "$(dirname "$0")" && pwd)"
echo "== Thư mục bot: $DIR"
if [ ! -f "$DIR/.env" ]; then
  echo "⚠️  Chưa có file .env (token, key). Chép cả thư mục bot từ máy tính lên (gồm .env và data), hoặc chạy:"
  echo "    cd $DIR && python3 bot.py   để nhập token, key và /chu lần đầu, xong bấm Ctrl+C rồi chạy lại script này."
  exit 1
fi
echo "== Đặt giờ Việt Nam (để nhắc lịch, báo cáo sáng đúng giờ)"
timedatectl set-timezone Asia/Ho_Chi_Minh 2>/dev/null || ln -sf /usr/share/zoneinfo/Asia/Ho_Chi_Minh /etc/localtime
if ! command -v python3 >/dev/null; then
  echo "== Cài Python"
  apt-get update -y && apt-get install -y python3
fi
python3 --version
echo "== Bật trang CRM (cổng web)"
ENVF="$DIR/.env"
setkv() { if grep -q "^$1=" "$ENVF"; then sed -i "s|^$1=.*|$1=$2|" "$ENVF"; else printf '\n%s=%s\n' "$1" "$2" >> "$ENVF"; fi; }
PORT=$(grep -E '^WEB_PORT=' "$ENVF" | tail -1 | cut -d= -f2 | tr -d '\r ')
if [ -z "$PORT" ] || [ "$PORT" = "0" ]; then setkv WEB_PORT 8080; PORT=8080; fi
IP=$(curl -s --max-time 5 https://ifconfig.me 2>/dev/null || hostname -I | awk '{print $1}')
if ! grep -qE '^CRM_URL=[^[:space:]]' "$ENVF"; then setkv CRM_URL "http://$IP:$PORT"; fi
if command -v ufw >/dev/null && ufw status 2>/dev/null | grep -q "Status: active"; then ufw allow "$PORT"/tcp >/dev/null; fi
echo "== Tạo dịch vụ bdsbot"
cat > /etc/systemd/system/bdsbot.service <<UNIT
[Unit]
Description=Bot tu van BDS
After=network-online.target
Wants=network-online.target

[Service]
WorkingDirectory=$DIR
ExecStart=$(command -v python3) $DIR/bot.py
Environment=PYTHONUNBUFFERED=1
Restart=always
RestartSec=10

[Install]
WantedBy=multi-user.target
UNIT
systemctl daemon-reload
systemctl enable bdsbot >/dev/null 2>&1
systemctl restart bdsbot
sleep 5
if systemctl is-active --quiet bdsbot; then
  echo ""
  echo "✅ BOT ĐANG CHẠY 24/7 TRÊN VPS. Nhắn /thongke cho bot trên Zalo để kiểm tra."
else
  echo "❌ Bot chưa chạy được. Xem lỗi:"; journalctl -u bdsbot -n 30 --no-pager; exit 1
fi
echo ""
echo "🖥 Trang CRM: nhắn bot /crm trên Zalo để lấy link đăng nhập (http://$IP:$PORT/crm)"
echo ""
echo "Lệnh hay dùng:"
echo "  Xem nhật ký trực tiếp : tail -f $DIR/data/bot.log      (thoát: Ctrl+C)"
echo "  Khởi động lại bot     : systemctl restart bdsbot"
echo "  Tắt bot               : systemctl stop bdsbot"
echo "  Tình trạng bot        : systemctl status bdsbot"
