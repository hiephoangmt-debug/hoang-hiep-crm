// Kiểm tra nhanh Crm.html: cú pháp JS và hàm được gọi nhưng chưa được định nghĩa (lỗi dạng "x is not defined").
import fs from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';
const here = path.dirname(fileURLToPath(import.meta.url));
const h = fs.readFileSync(path.join(here, 'Crm.html'), 'utf8');
const s = h.slice(h.indexOf('<script>') + 8, h.lastIndexOf('</script>'));
new Function(s);
const defs = new Set([...s.matchAll(/function\s+([A-Za-z_$][\w$]*)/g)].map((m) => m[1]));
for (const m of s.matchAll(/(?:var|let|const)\s+([A-Za-z_$][\w$]*)/g)) defs.add(m[1]);
for (const m of s.matchAll(/var\s+([^;]*?);/g)) for (const n of m[1].matchAll(/(?:^|,)\s*([A-Za-z_$][\w$]*)\s*=/g)) defs.add(n[1]);
const params = new Set();
for (const m of s.matchAll(/function\s*[\w$]*\s*\(([^)]*)\)/g)) m[1].split(',').forEach((n) => params.add(n.trim()));
const builtin = new Set(['if', 'for', 'while', 'function', 'switch', 'catch', 'return', 'typeof', 'Date', 'Math', 'Object', 'Array', 'String', 'Number', 'JSON', 'Promise', 'Error', 'parseFloat', 'parseInt', 'setTimeout', 'clearTimeout', 'Boolean', 'RegExp', 'isNaN', 'var']);
const calls = new Set([...s.matchAll(/(?<![.\w$\u00C0-\u1EF9])([A-Za-z_$][\w$]*)\s*\(/g)].map((m) => m[1]));
const missing = [...calls].filter((c) => /^[\x00-\x7f]+$/.test(c) && !defs.has(c) && !params.has(c) && !builtin.has(c) && !['CPC', 'CPL', 'CTR', 'xem'].includes(c));
if (missing.length) { console.error('Hàm chưa định nghĩa trong Crm.html: ' + missing.join(', ')); process.exit(1); }
console.log('OK – Crm.html không thiếu hàm');
