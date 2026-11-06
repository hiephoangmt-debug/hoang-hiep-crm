/* Xuất kiến thức chatbot (KB trong hhc-chat.js) ra kb-ai.txt cho trợ lý AI (Claude) đọc.
 * Chạy lại mỗi khi sửa KB:  node kb-export.js   rồi commit + push kb-ai.txt.
 * Apps Script (ai/claude-proxy.gs) tự tải bản mới trên nhánh, giữ trong bộ nhớ đệm 6 tiếng. */
var fs = require('fs'), path = require('path');
var src = fs.readFileSync(path.join(__dirname, 'hhc-chat.js'), 'utf8');
var a = src.indexOf('  var KB = ['), b = src.indexOf('\n  ];\n', a);
if (a < 0 || b < 0) throw new Error('Không tìm thấy KB trong hhc-chat.js');
var KB = new Function('SO', 'EVT_ON', 'TEL', 'ZALO', src.slice(a, b + 6) + '\nreturn KB;')(
  '0904 567 009', false, 'tel:0904567009', 'https://zalo.me/0904567009');
var out = KB.map(function (it) {
  return '## ' + (it.topic || it.id) + '\n' + it.a.map(function (x) { return '- ' + x; }).join('\n');
}).join('\n\n') + '\n';
fs.writeFileSync(path.join(__dirname, 'kb-ai.txt'), out);
console.log(KB.length + ' mục, ' + out.length + ' ký tự → kb-ai.txt');
