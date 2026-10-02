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

SEO / AI search: JSON-LD (`LocalBusiness`, `FAQPage`) được sinh từ chính nội dung trang;
`robots.txt` cho phép bot tìm kiếm của AI (OAI-SearchBot, GPTBot, PerplexityBot...); `llms.txt` tóm tắt doanh nghiệp cho AI.

## CRM Thẻ Tín Dụng

Thư mục `crm/`: CRM trên Google Sheets + Apps Script, gồm nhận khách từ website, sổ giao dịch, nhắc đáo hạn (7→5 ngày trước hạn, có dời ngày nghỉ), gợi ý rút sau ngày sao kê và báo cáo tuần/tháng/năm. Hướng dẫn cài đặt: [`crm/README.md`](crm/README.md).
