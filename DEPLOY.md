# Hướng dẫn deploy lên server (VPS Ubuntu 22.04/24.04)

Cần: 1 VPS (1 CPU / 1GB RAM là đủ), 1 tên miền (vd `crm.tenmiencuaban.com`) đã trỏ bản ghi **A** về IP của VPS.

## 1. Cài Node 22 và tải code
```bash
ssh root@IP_VPS
curl -fsSL https://deb.nodesource.com/setup_22.x | bash - && apt install -y nodejs git
git clone https://github.com/hiephoangmt-debug/hoang-hiep-crm.git /opt/crm
cd /opt/crm && git checkout claude/modest-rubin-wul27c   # hoặc main sau khi merge
node test.js                                              # phải in "OK"
```

## 2. Chạy nền bằng systemd
```bash
cat > /etc/systemd/system/crm.service <<'UNIT'
[Unit]
Description=CRM Hoang Hiep
After=network.target

[Service]
WorkingDirectory=/opt/crm
Environment=PORT=3000
Environment=ADMIN_PASSWORD=DOI_MAT_KHAU_MANH_O_DAY
Environment=DATA_DIR=/var/lib/crm
ExecStart=/usr/bin/node server.js
Restart=always
User=www-data
StateDirectory=crm

[Install]
WantedBy=multi-user.target
UNIT
systemctl daemon-reload && systemctl enable --now crm
systemctl status crm --no-pager
```

## 3. HTTPS bằng Caddy (tự cấp chứng chỉ)
```bash
apt install -y caddy
cat > /etc/caddy/Caddyfile <<'EOF2'
crm.tenmiencuaban.com {
    reverse_proxy 127.0.0.1:3000
}
EOF2
systemctl reload caddy
```
Mở `https://crm.tenmiencuaban.com` và đăng nhập. Mở cổng 80/443 trên firewall (`ufw allow 80,443/tcp`), **không** mở cổng 3000.

## 4. Gắn vào website
Tab **Website & mã nhúng** → thêm website → copy đoạn `<script>` dán vào `<head>` landing page. Mã nhúng dùng đúng tên miền CRM nên bắt buộc phải có HTTPS (nếu landing chạy HTTPS).

## Sao lưu & cập nhật
```bash
# sao lưu hằng ngày
echo '0 3 * * * root sqlite3 /var/lib/crm/crm.db ".backup /root/crm-$(date +\%F).db"' > /etc/cron.d/crm-backup   # apt install sqlite3
# cập nhật code
cd /opt/crm && git pull && systemctl restart crm
```

## Gỡ lỗi
`journalctl -u crm -f` xem log. Không vào được web: kiểm tra DNS đã trỏ đúng IP và `systemctl status caddy`.
