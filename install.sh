#!/usr/bin/env bash
# Cài đặt / cập nhật CRM Hoàng Hiệp trên VPS Ubuntu/Debian (chạy bằng root).
#   bash <(curl -fsSL https://raw.githubusercontent.com/hiephoangmt-debug/hoang-hiep-crm/BRANCH/install.sh)
# Có thể truyền sẵn: CRM_DOMAIN=crm.abc.com CRM_PASSWORD=xxx CRM_BRANCH=main
set -euo pipefail
[ "$(id -u)" = 0 ] || { echo "Hãy chạy bằng root (sudo -i)"; exit 1; }

REPO="https://github.com/hiephoangmt-debug/hoang-hiep-crm.git"
BRANCH="${CRM_BRANCH:-claude/modest-rubin-wul27c}"
DIR=/opt/crm; ENVFILE=/etc/crm.env

if [ -f "$ENVFILE" ]; then
  echo "▶ Đã cài trước đó → chỉ cập nhật code"
  UPDATE=1
else
  UPDATE=0
  DOMAIN="${CRM_DOMAIN:-}"
  [ -n "$DOMAIN" ] || read -rp "Tên miền dành cho CRM (vd crm.abc.com, đã trỏ A về IP VPS; bỏ trống = chạy bằng IP, không HTTPS): " DOMAIN
  PASS="${CRM_PASSWORD:-}"
  [ -n "$PASS" ] || read -rsp "Đặt mật khẩu đăng nhập CRM (bỏ trống = tự tạo): " PASS; echo
  [ -n "$PASS" ] || PASS="$(head -c 12 /dev/urandom | base64 | tr -dc 'A-Za-z0-9' | head -c 14)"
fi

echo "▶ Cài Node 22, git"
if ! command -v node >/dev/null || [ "$(node -p 'process.versions.node.split(".")[0]')" -lt 22 ]; then
  curl -fsSL https://deb.nodesource.com/setup_22.x | bash -
  apt-get install -y nodejs
fi
apt-get install -y git sqlite3 curl >/dev/null

echo "▶ Tải code ($BRANCH)"
if [ -d "$DIR/.git" ]; then git -C "$DIR" fetch origin "$BRANCH" && git -C "$DIR" checkout -q "$BRANCH" && git -C "$DIR" reset -q --hard "origin/$BRANCH"
else git clone -q -b "$BRANCH" "$REPO" "$DIR"; fi
(cd "$DIR" && node test.js 2>&1 | grep -q OK) || { echo "✖ Test không đạt, dừng lại"; exit 1; }

if [ "$UPDATE" = 0 ]; then
  PORT=3000; [ -n "$DOMAIN" ] && HOSTBIND=127.0.0.1 || HOSTBIND=0.0.0.0
  umask 077; printf 'PORT=%s\nHOST=%s\nADMIN_PASSWORD=%s\nDATA_DIR=/var/lib/crm\n' "$PORT" "$HOSTBIND" "$PASS" > "$ENVFILE"; umask 022
  cat > /etc/systemd/system/crm.service <<UNIT
[Unit]
Description=CRM Hoang Hiep
After=network.target
[Service]
WorkingDirectory=$DIR
EnvironmentFile=$ENVFILE
ExecStart=/usr/bin/env node server.js
Restart=always
User=www-data
StateDirectory=crm
[Install]
WantedBy=multi-user.target
UNIT
  systemctl daemon-reload; systemctl enable crm >/dev/null

  if [ -n "$DOMAIN" ]; then
    echo "▶ Cài Caddy (HTTPS tự động)"
    apt-get install -y caddy >/dev/null
    printf '%s {\n    reverse_proxy 127.0.0.1:%s\n}\n' "$DOMAIN" "$PORT" > /etc/caddy/Caddyfile
    systemctl reload caddy || systemctl restart caddy
    command -v ufw >/dev/null && ufw allow 80,443/tcp >/dev/null || true
  else
    command -v ufw >/dev/null && ufw allow 3000/tcp >/dev/null || true
  fi
  echo '0 3 * * * root sqlite3 /var/lib/crm/crm.db ".backup /var/lib/crm/backup-$(date +\%u).db"' > /etc/cron.d/crm-backup
fi

systemctl restart crm; sleep 1
systemctl is-active --quiet crm || { journalctl -u crm -n 20 --no-pager; exit 1; }

echo; echo "✅ XONG"
if [ "$UPDATE" = 0 ]; then
  [ -n "$DOMAIN" ] && echo "Địa chỉ : https://$DOMAIN" || echo "Địa chỉ : http://$(curl -fsS https://api.ipify.org || echo IP_VPS):3000"
  echo "Mật khẩu: $PASS   (lưu lại! xem lại bằng: grep ADMIN_PASSWORD $ENVFILE)"
fi
