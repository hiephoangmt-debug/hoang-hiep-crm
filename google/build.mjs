// Sinh google/Code.gs: chèn public/track.js vào google/Code.template.gs
import fs from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';
const here = path.dirname(fileURLToPath(import.meta.url));
const tpl = fs.readFileSync(path.join(here, 'Code.template.gs'), 'utf8');
const js = fs.readFileSync(path.join(here, '..', 'public', 'track.js'), 'utf8');
const crm = fs.readFileSync(path.join(here, 'Crm.html'), 'utf8');
fs.writeFileSync(path.join(here, 'Code.gs'), tpl.replace("/*__TRACK_JS__*/''", () => JSON.stringify(js)).replace("/*__CRM_HTML__*/''", () => JSON.stringify(crm)));
console.log('Đã tạo google/Code.gs');
