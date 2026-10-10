// Ghép widget độc lập: node src/build-widget.mjs  (chạy sau build.mjs để có chat-kb.json)
import { readFileSync, writeFileSync } from "node:fs";
import { dirname, join } from "node:path";
import { fileURLToPath } from "node:url";
import { plazas } from "./data.mjs";

const HERE = dirname(fileURLToPath(import.meta.url));
const PUB = join(HERE, "..", "public", "assets");
const read = (p) => readFileSync(p, "utf8");
const IMG = "https://raw.githubusercontent.com/hiephoangmt-debug/hoang-hiep-crm/5051b81aefcfec407044094b96b5dfc7fdd47de8/website/public/assets/img/";
const kb = JSON.parse(read(join(PUB, "chat-kb.json")));
const drives = Object.fromEntries(plazas.filter((p) => p.drive).map((p) => [p.name, p.drive]));
const HTML = `
<div class="floating" aria-label="Liên hệ nhanh">
  <button type="button" class="fab fab-chat" data-chat-open aria-label="Chat tư vấn tự động" aria-expanded="false" aria-controls="chatbox">
    <svg width="26" height="26" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M12 3C6.5 3 2 6.6 2 11c0 2.4 1.3 4.5 3.4 6l-.9 3.6c-.1.4.3.7.7.5L9.3 19c.9.2 1.8.3 2.7.3 5.5 0 10-3.6 10-8.1S17.5 3 12 3Zm-4 9.3a1.3 1.3 0 1 1 0-2.6 1.3 1.3 0 0 1 0 2.6Zm4 0a1.3 1.3 0 1 1 0-2.6 1.3 1.3 0 0 1 0 2.6Zm4 0a1.3 1.3 0 1 1 0-2.6 1.3 1.3 0 0 1 0 2.6Z"/></svg>
    <span class="fab-badge" data-chat-badge>1</span><span class="fab-label">Chat tư vấn 24/7</span>
  </button>
  <a href="#" class="fab fab-zalo" data-zalo-link target="_blank" rel="noopener" aria-label="Chat Zalo">Zalo<span class="fab-label">Nhắn Zalo</span></a>
  <a href="tel:" class="fab fab-call" data-hotline-link aria-label="Gọi hotline">📞<span class="fab-label" data-hotline></span></a>
</div>
<div class="chat-teaser" data-chat-teaser hidden><button type="button" class="chat-teaser-x" aria-label="Ẩn" data-teaser-close>×</button><span data-chat-open>👋 Bạn cần bảng giá hay mặt bằng căn hộ? Hỏi mình nhé!</span></div>
<section class="chatbox" id="chatbox" role="dialog" aria-label="Chat tư vấn tự động" hidden>
  <header class="chat-head"><span class="chat-ava" aria-hidden="true">🤖</span><div><b>Trợ lý FPT City</b><small><i class="dot"></i>Trả lời tự động ngay lập tức</small></div><button type="button" class="chat-x" data-chat-close aria-label="Đóng chat">×</button></header>
  <div class="chat-log" data-chat-log aria-live="polite"></div>
  <div class="chat-chips" data-chat-chips></div>
  <form class="chat-form" data-chat-form autocomplete="off"><input name="q" maxlength="400" placeholder="Nhập câu hỏi hoặc mã căn (VD: N-12.12)…" aria-label="Nội dung chat"><button type="submit" aria-label="Gửi">➤</button></form>
  <p class="chat-note">Trợ lý tự động · Thông tin tham khảo, giá chính xác do chuyên viên gửi</p>
</section>`;
let out = read(join(HERE, "widget.template.js"));
out = out.replace("/*__KB__*/null", () => JSON.stringify(kb));
out = out.replace("/*__DRIVES__*/{}", () => JSON.stringify(drives));
out = out.replace('/*__IMG__*/""', () => JSON.stringify(IMG));
out = out.replace('/*__CSS__*/""', () => JSON.stringify(read(join(HERE, "widget.css"))));
out = out.replace('/*__HTML__*/""', () => JSON.stringify(HTML));
out = out.replace("/*__CHAT__*/", () => read(join(PUB, "js", "chat.js")));
writeFileSync(join(PUB, "js", "fc-widget.js"), out);
console.log(`fc-widget.js ${(out.length / 1024).toFixed(0)} KB`);
