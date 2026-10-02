# hoang-hiep-crm
CRM – Real Estate Sales Management System

## Website: Dịch Vụ Thẻ Tín Dụng Đà Nẵng

Trang tĩnh trong thư mục `the-tin-dung-da-nang/`, tên miền `www.the-tin-dung-da-nang.com`
(file `CNAME`). Deploy tự động lên GitHub Pages bằng `.github/workflows/deploy-pages.yml`
khi push lên `main`.

Cấu hình một lần:
1. GitHub → Settings → Pages → Source: **GitHub Actions**; Custom domain: `www.the-tin-dung-da-nang.com`, bật **Enforce HTTPS**.
2. DNS tại nhà cung cấp tên miền:
   - `CNAME` `www` → `hiephoangmt-debug.github.io`
   - `A` `@` → `185.199.108.153`, `185.199.109.153`, `185.199.110.153`, `185.199.111.153` (để tên miền gốc chuyển về `www`)
