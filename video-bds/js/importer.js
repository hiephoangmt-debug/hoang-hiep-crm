/* Đọc thư mục dự án: tìm file kịch bản (Excel, Word, CSV, TXT, link Google Sheets), video, ảnh, nhạc. */
(function () {
  'use strict';

  /* ---------- Đọc file ZIP (xlsx, docx là file zip) ---------- */

  function readZip(ab) {
    var dv = new DataView(ab), u8 = new Uint8Array(ab);
    var eocd = -1;
    for (var i = ab.byteLength - 22; i >= Math.max(0, ab.byteLength - 66000); i--) {
      if (dv.getUint32(i, true) === 0x06054b50) { eocd = i; break; }
    }
    if (eocd < 0) throw new Error('Không phải file zip');
    var count = dv.getUint16(eocd + 10, true), off = dv.getUint32(eocd + 16, true);
    var entries = {};
    for (var n = 0; n < count; n++) {
      var method = dv.getUint16(off + 10, true), csize = dv.getUint32(off + 20, true);
      var nlen = dv.getUint16(off + 28, true), xlen = dv.getUint16(off + 30, true), clen = dv.getUint16(off + 32, true);
      var local = dv.getUint32(off + 42, true);
      var name = new TextDecoder().decode(u8.subarray(off + 46, off + 46 + nlen));
      entries[name] = { method: method, csize: csize, local: local };
      off += 46 + nlen + xlen + clen;
    }
    return {
      names: Object.keys(entries),
      text: function (name) {
        var e = entries[name];
        if (!e) return Promise.resolve('');
        var lh = e.local, start = lh + 30 + dv.getUint16(lh + 26, true) + dv.getUint16(lh + 28, true);
        var data = u8.subarray(start, start + e.csize);
        if (e.method === 0) return Promise.resolve(new TextDecoder().decode(data));
        var ds = new Blob([data]).stream().pipeThrough(new DecompressionStream('deflate-raw'));
        return new Response(ds).text();
      }
    };
  }

  function xml(s) { return new DOMParser().parseFromString(s, 'application/xml'); }

  function byTag(node, tag) {
    // Bỏ qua tiền tố namespace (w:, x:)
    var all = node.getElementsByTagName('*'), out = [];
    for (var i = 0; i < all.length; i++) if (all[i].localName === tag) out.push(all[i]);
    return out;
  }

  /** Excel: trả về các dòng của trang tính đầu tiên. */
  function readXlsx(ab) {
    var z = readZip(ab);
    var sheet = z.names.filter(function (n) { return /^xl\/worksheets\/sheet\d+\.xml$/.test(n); }).sort()[0];
    return Promise.all([z.text('xl/sharedStrings.xml'), z.text(sheet)]).then(function (r) {
      var shared = r[0] ? byTag(xml(r[0]), 'si').map(function (si) { return byTag(si, 't').map(function (t) { return t.textContent; }).join(''); }) : [];
      var rows = [];
      byTag(xml(r[1]), 'row').forEach(function (row) {
        var cells = [];
        byTag(row, 'c').forEach(function (c) {
          var ref = c.getAttribute('r') || '';
          var col = 0, letters = ref.replace(/\d+/g, '');
          for (var i = 0; i < letters.length; i++) col = col * 26 + letters.charCodeAt(i) - 64;
          var t = c.getAttribute('t'), v = byTag(c, 'v')[0], val = '';
          if (t === 's' && v) val = shared[+v.textContent] || '';
          else if (t === 'inlineStr') val = byTag(c, 't').map(function (x) { return x.textContent; }).join('');
          else if (v) val = v.textContent;
          cells[Math.max(0, col - 1)] = val;
        });
        for (var k = 0; k < cells.length; k++) if (cells[k] == null) cells[k] = '';
        rows.push(cells);
      });
      return rows;
    });
  }

  /** Word: nếu có bảng nhiều cột thì trả về bảng, không thì trả về văn bản. */
  function readDocx(ab) {
    var z = readZip(ab);
    return z.text('word/document.xml').then(function (s) {
      var doc = xml(s);
      var paraText = function (p) {
        var out = '';
        var all = p.getElementsByTagName('*');
        for (var i = 0; i < all.length; i++) {
          var n = all[i].localName;
          if (n === 't') out += all[i].textContent;
          else if (n === 'br' || n === 'cr') out += '\n';
          else if (n === 'tab') out += ' ';
        }
        return out;
      };
      var tables = byTag(doc, 'tbl');
      if (tables.length) {
        var rows = [];
        tables.forEach(function (tb) {
          byTag(tb, 'tr').forEach(function (tr) {
            rows.push(byTag(tr, 'tc').map(function (tc) { return byTag(tc, 'p').map(paraText).join('\n'); }));
          });
        });
        if (rows.some(function (r) { return r.length >= 2; })) return { rows: rows };
      }
      return { text: byTag(doc, 'p').map(paraText).join('\n') };
    });
  }

  /* ---------- Kịch bản dạng văn bản ---------- */

  var EMOJI = /[\u{1F000}-\u{1FAFF}\u{2600}-\u{27BF}\u{FE0F}\u{200D}\u{2B50}]/gu;

  /**
   * Đọc kịch bản viết tự do:
   *   CẢNH 1 – HOOK            (dòng bắt đầu bằng "Cảnh n" hoặc "#" mở cảnh mới)
   *   Lời thoại …              (các dòng thường là lời thoại)
   *   Hình ảnh: …              (gợi ý cảnh quay)
   *   Text chạy màn hình:      (các dòng ngắn sau đó là chữ lớn)
   * Không có tiêu đề cảnh thì mỗi đoạn văn là một cảnh.
   */
  function textToScenes(text) {
    var lines = (text || '').replace(/\r/g, '').split('\n').map(function (l) { return l.replace(EMOJI, '').trim(); });
    var head = /^(#+\s*)?(cảnh|canh|scene|phân cảnh)\s*\d+\b/i;
    var hasHeads = lines.some(function (l) { return head.test(l) || /^#+\s+\S/.test(l); });
    var scenes = [];
    if (!hasHeads) {
      text.split(/\n\s*\n/).map(function (p) { return p.replace(EMOJI, '').trim(); }).filter(Boolean).forEach(function (p, i) {
        scenes.push({ title: 'Cảnh ' + (i + 1), text: p.replace(/^["“]|["”]$/g, ''), bigText: [], shotNote: '' });
      });
      return scenes;
    }
    var cur = null, mode = 'text';
    lines.forEach(function (l) {
      if (head.test(l) || /^#+\s+\S/.test(l)) {
        cur = { title: l.replace(/^#+\s*/, ''), text: '', bigText: [], shotNote: '' };
        scenes.push(cur);
        mode = 'text';
        return;
      }
      if (!cur) return;
      if (!l) { if (mode === 'big') mode = 'text'; return; }
      var m;
      if ((m = l.match(/^(text[^:]*|chữ[^:]*)\s*:\s*(.*)$/i))) { mode = 'big'; if (m[2]) cur.bigText.push(m[2]); return; }
      if ((m = l.match(/^(hình ảnh|hình|cảnh quay|b-?roll|gợi ý[^:]*|chuyển cảnh[^:]*)\s*:\s*(.*)$/i))) { mode = 'shot'; cur.shotNote += (cur.shotNote ? '\n' : '') + m[2]; return; }
      if ((m = l.match(/^(lời thoại|thoại|voice|lời)\s*:\s*(.*)$/i))) { mode = 'text'; l = m[2]; if (!l) return; }
      if (mode === 'big' && l.length <= 50) { cur.bigText.push(l.replace(/^["“]|["”]$/g, '')); return; }
      if (mode === 'shot') { cur.shotNote += '\n' + l; return; }
      mode = 'text';
      cur.text += (cur.text ? '\n' : '') + l.replace(/^["“]|["”]$/g, '');
    });
    return scenes.filter(function (s) { return s.text || s.bigText.length; });
  }

  /** Tìm giá và số điện thoại trong kịch bản để điền sẵn. */
  function extractInfo(text) {
    var info = {};
    var phone = (text || '').match(/(?:\+84|0)[\s.]?\d{2,3}[\s.]?\d{3}[\s.]?\d{3,4}/);
    if (phone) info.sdt = phone[0].replace(/\s+/g, ' ');
    var price = (text || '').match(/(từ\s*(?:hơn\s*)?)?\d+(?:[,.]\d+)?\s*(tỷ|triệu)(\s*\/\s*(căn|m²|m2|tháng))?/i);
    if (price) info.gia = price[0];
    return info;
  }

  function findLink(text) {
    var m = (text || '').match(/https:\/\/docs\.google\.com\/(spreadsheets|document)\/d\/[a-zA-Z0-9_-]+[^\s"<]*/);
    return m ? m[0] : '';
  }

  /** Lấy kịch bản từ link Google Sheets / Google Docs (cần bật chia sẻ “Bất kỳ ai có đường liên kết”). */
  function fetchLink(link) {
    var G = window.ScriptGen;
    if (/\/spreadsheets\//.test(link)) {
      return fetch(G.sheetCsvUrl(link)).then(function (r) { if (!r.ok) throw new Error(r.status); return r.text(); })
        .then(function (csv) { return { scenes: G.tableToScenes(G.parseTable(csv)), raw: csv }; });
    }
    var id = (link.match(/\/document\/d\/([a-zA-Z0-9_-]+)/) || [])[1];
    return fetch('https://docs.google.com/document/d/' + id + '/export?format=txt').then(function (r) { if (!r.ok) throw new Error(r.status); return r.text(); })
      .then(function (txt) { return { scenes: textToScenes(txt), raw: txt }; });
  }

  var SCRIPT_EXT = /\.(xlsx|docx|csv|tsv|txt|md|url|webloc)$/i;

  /** Đọc một file kịch bản → { scenes, raw }. */
  function readScript(file) {
    var G = window.ScriptGen, name = file.name.toLowerCase();
    if (/\.xlsx$/.test(name)) {
      return file.arrayBuffer().then(readXlsx).then(function (rows) {
        return { scenes: G.tableToScenes(rows), raw: rows.map(function (r) { return r.join(' '); }).join('\n') };
      });
    }
    if (/\.docx$/.test(name)) {
      return file.arrayBuffer().then(readDocx).then(function (d) {
        if (d.rows) return { scenes: G.tableToScenes(d.rows), raw: d.rows.map(function (r) { return r.join(' '); }).join('\n') };
        return { scenes: textToScenes(d.text), raw: d.text };
      });
    }
    return file.text().then(function (txt) {
      var link = findLink(txt);
      // File chỉ chứa link (hoặc file .url/.webloc) → lấy kịch bản từ Google
      if (link && (/\.(url|webloc)$/.test(name) || txt.replace(link, '').trim().length < 40)) return fetchLink(link);
      if (/\.(csv|tsv)$/.test(name) || (txt.indexOf('\t') !== -1 && txt.split('\n')[0].split('\t').length >= 2)) {
        return { scenes: G.tableToScenes(G.parseTable(txt)), raw: txt };
      }
      return { scenes: textToScenes(txt), raw: txt };
    });
  }

  /* ---------- Duyệt thư mục kéo thả ---------- */

  function walkEntry(entry, out) {
    if (entry.isFile) return new Promise(function (res) { entry.file(function (f) { out.push(f); res(); }, function () { res(); }); });
    if (!entry.isDirectory) return Promise.resolve();
    var reader = entry.createReader();
    return new Promise(function (res) {
      var all = [];
      (function more() {
        reader.readEntries(function (batch) {
          if (!batch.length) { Promise.all(all.map(function (e) { return walkEntry(e, out); })).then(res); return; }
          all = all.concat(Array.prototype.slice.call(batch));
          more();
        }, function () { res(); });
      })();
    });
  }

  /** Lấy toàn bộ file từ sự kiện kéo thả (kể cả thư mục con). */
  function filesFromDrop(dt) {
    var items = dt.items ? Array.prototype.slice.call(dt.items) : [];
    var entries = items.map(function (it) { return it.webkitGetAsEntry && it.webkitGetAsEntry(); }).filter(Boolean);
    if (!entries.length) return Promise.resolve(Array.prototype.slice.call(dt.files || []));
    var out = [];
    return Promise.all(entries.map(function (e) { return walkEntry(e, out); })).then(function () {
      out.folder = entries.length === 1 && entries[0].isDirectory ? entries[0].name : '';
      return out;
    });
  }

  /** Phân loại file trong thư mục. */
  function classify(files) {
    var r = { scripts: [], media: [], music: [], other: [] };
    files.forEach(function (f) {
      if (/^\./.test(f.name)) return;
      if (/^(video|image)\//.test(f.type) || /\.(mp4|mov|m4v|webm|jpe?g|png|webp|heic)$/i.test(f.name)) r.media.push(f);
      else if (/^audio\//.test(f.type) || /\.(mp3|m4a|wav|aac|ogg)$/i.test(f.name)) r.music.push(f);
      else if (SCRIPT_EXT.test(f.name)) r.scripts.push(f);
      else r.other.push(f);
    });
    // Ưu tiên file có tên "kịch bản / script / content"
    var pri = function (f) { return /kich.?ban|kịch.?bản|script|content|noi.?dung|nội.?dung/i.test(f.name) ? 0 : (/\.(xlsx|docx|csv)$/i.test(f.name) ? 1 : 2); };
    r.scripts.sort(function (a, b) { return pri(a) - pri(b); });
    return r;
  }

  window.BdsImporter = {
    readScript: readScript, textToScenes: textToScenes, extractInfo: extractInfo, fetchLink: fetchLink, findLink: findLink,
    filesFromDrop: filesFromDrop, classify: classify, readXlsx: readXlsx, readDocx: readDocx
  };
})();
