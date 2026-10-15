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

  var jsonpN = 0;

  /**
   * Đọc Google Sheets bằng JSONP (không bị trình duyệt chặn như khi tải file CSV).
   * Bảng cần bật chia sẻ “Bất kỳ ai có đường liên kết đều xem được”.
   */
  function sheetRows(link) {
    var id = (link.match(/\/spreadsheets\/d\/([a-zA-Z0-9_-]+)/) || [])[1];
    var gid = (link.match(/[#&?]gid=(\d+)/) || [])[1];
    if (!id) return Promise.reject(new Error('Link Google Sheets chưa đúng.'));
    return new Promise(function (resolve, reject) {
      var cb = '__bdsSheet' + (++jsonpN);
      var sc = document.createElement('script');
      var done = function () { delete window[cb]; sc.remove(); clearTimeout(timer); };
      var timer = setTimeout(function () { done(); reject(new Error('Hết thời gian chờ Google Sheets.')); }, 20000);
      window[cb] = function (resp) {
        done();
        if (!resp || resp.status !== 'ok' || !resp.table) {
          reject(new Error('Bảng chưa bật chia sẻ “Bất kỳ ai có đường liên kết đều xem được”.'));
          return;
        }
        resolve(resp.table.rows.map(function (r) {
          return (r.c || []).map(function (c) { return c ? String(c.f != null ? c.f : (c.v != null ? c.v : '')) : ''; });
        }));
      };
      sc.onerror = function () { done(); reject(new Error('Không mở được bảng. Hãy bật chia sẻ “Bất kỳ ai có đường liên kết đều xem được”.')); };
      sc.src = 'https://docs.google.com/spreadsheets/d/' + id + '/gviz/tq?tqx=out:json;responseHandler:' + cb + '&headers=0' + (gid ? '&gid=' + gid : '');
      document.head.appendChild(sc);
    });
  }

  /** Lấy kịch bản từ link Google Sheets / Google Docs (cần bật chia sẻ “Bất kỳ ai có đường liên kết”). */
  function fetchLink(link) {
    var G = window.ScriptGen;
    if (/\/spreadsheets\//.test(link)) {
      return sheetRows(link).then(function (rows) {
        return { scenes: G.tableToScenes(rows), raw: rows.map(function (r) { return r.join(' '); }).join('\n') };
      }).catch(function (e) {
        // Dự phòng: tải CSV trực tiếp
        return fetch(G.sheetCsvUrl(link)).then(function (r) { if (!r.ok) throw e; return r.text(); })
          .then(function (csv) { if (/^\s*</.test(csv)) throw e; return { scenes: G.tableToScenes(G.parseTable(csv)), raw: csv }; })
          .catch(function () { throw e; });
      });
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

  /* ---------- Giải nén file ZIP (VD: thư mục tải từ Google Drive) mà không đọc hết vào bộ nhớ ---------- */

  function unzipFile(zipFile) {
    var size = zipFile.size;
    var tailLen = Math.min(size, 66000);
    return zipFile.slice(size - tailLen).arrayBuffer().then(function (tail) {
      var dv = new DataView(tail), eocd = -1;
      for (var i = tail.byteLength - 22; i >= 0; i--) if (dv.getUint32(i, true) === 0x06054b50) { eocd = i; break; }
      if (eocd < 0) throw new Error('File ZIP bị lỗi.');
      var count = dv.getUint16(eocd + 10, true), cdSize = dv.getUint32(eocd + 12, true), cdOff = dv.getUint32(eocd + 16, true);
      if (cdOff === 0xffffffff) throw new Error('File ZIP quá lớn (trên 4GB). Hãy tải từng phần nhỏ hơn.');
      return zipFile.slice(cdOff, cdOff + cdSize).arrayBuffer().then(function (cd) {
        var d = new DataView(cd), u8 = new Uint8Array(cd), off = 0, list = [];
        for (var n = 0; n < count; n++) {
          var flags = d.getUint16(off + 8, true);
          var method = d.getUint16(off + 10, true), csize = d.getUint32(off + 20, true);
          var nlen = d.getUint16(off + 28, true), xlen = d.getUint16(off + 30, true), clen = d.getUint16(off + 32, true);
          var local = d.getUint32(off + 42, true);
          var raw = u8.subarray(off + 46, off + 46 + nlen);
          var name = (flags & 0x800) ? new TextDecoder().decode(raw) : new TextDecoder().decode(raw);
          if (!/\/$/.test(name)) list.push({ name: name, method: method, csize: csize, local: local });
          off += 46 + nlen + xlen + clen;
        }
        return Promise.all(list.map(function (e) {
          return zipFile.slice(e.local, e.local + 30).arrayBuffer().then(function (h) {
            var hv = new DataView(h);
            var start = e.local + 30 + hv.getUint16(26, true) + hv.getUint16(28, true);
            var part = zipFile.slice(start, start + e.csize);
            var base = e.name.split('/').pop();
            var type = typeOf(base);
            if (e.method === 0) return new File([part], base, { type: type });
            return new Response(part.stream().pipeThrough(new DecompressionStream('deflate-raw'))).blob()
              .then(function (b) { return new File([b], base, { type: type }); });
          });
        }));
      });
    });
  }

  function typeOf(name) {
    var ext = (name.split('.').pop() || '').toLowerCase();
    return { mp4: 'video/mp4', mov: 'video/quicktime', m4v: 'video/mp4', webm: 'video/webm', jpg: 'image/jpeg', jpeg: 'image/jpeg',
      png: 'image/png', webp: 'image/webp', mp3: 'audio/mpeg', m4a: 'audio/mp4', wav: 'audio/wav', csv: 'text/csv', txt: 'text/plain' }[ext] || '';
  }

  /** Thay các file .zip trong danh sách bằng các file bên trong. */
  function expandZips(files, onProgress) {
    var out = [], chain = Promise.resolve();
    files.forEach(function (f) {
      chain = chain.then(function () {
        if (!/\.zip$/i.test(f.name)) { out.push(f); return; }
        if (onProgress) onProgress('Đang mở file nén ' + f.name + '…');
        return unzipFile(f).then(function (inner) { out.push.apply(out, inner.filter(function (x) { return !/^(\.|__MACOSX)/.test(x.name); })); });
      });
    });
    return chain.then(function () { return out; });
  }

  /* ---------- Google Drive (cần khoá API Google, thư mục bật chia sẻ công khai) ---------- */

  function driveIds(text) {
    var out = [];
    (text || '').split(/\s+/).forEach(function (l) {
      var m = l.match(/drive\.google\.com\/drive\/(?:u\/\d+\/)?folders\/([a-zA-Z0-9_-]+)/);
      if (m) { out.push({ kind: 'folder', id: m[1] }); return; }
      m = l.match(/drive\.google\.com\/(?:file\/d\/|open\?id=|uc\?.*id=)([a-zA-Z0-9_-]+)/);
      if (m) out.push({ kind: 'file', id: m[1] });
    });
    return out;
  }

  function driveApi(path, key) {
    return fetch('https://www.googleapis.com/drive/v3/' + path + (path.indexOf('?') === -1 ? '?' : '&') + 'key=' + encodeURIComponent(key) + '&supportsAllDrives=true')
      .then(function (r) {
        if (r.status === 403 || r.status === 404) throw new Error('Google Drive từ chối: hãy bật chia sẻ “Bất kỳ ai có đường liên kết” và kiểm tra khoá API.');
        if (!r.ok) throw new Error('Google Drive lỗi ' + r.status);
        return r;
      });
  }

  function listFolder(id, key, out) {
    out = out || [];
    var q = encodeURIComponent("'" + id + "' in parents and trashed=false");
    return driveApi('files?q=' + q + '&pageSize=1000&includeItemsFromAllDrives=true&fields=files(id,name,mimeType,size)', key)
      .then(function (r) { return r.json(); })
      .then(function (j) {
        var subs = [];
        (j.files || []).forEach(function (f) {
          if (f.mimeType === 'application/vnd.google-apps.folder') subs.push(f.id); else out.push(f);
        });
        return subs.reduce(function (p, sid) { return p.then(function () { return listFolder(sid, key, out); }); }, Promise.resolve()).then(function () { return out; });
      });
  }

  /** Tải các file từ link Google Drive (thư mục hoặc từng file) thành danh sách File. */
  function fromDrive(text, key, onProgress) {
    var ids = driveIds(text);
    if (!ids.length) return Promise.resolve([]);
    if (!key) return Promise.reject(new Error('NEED_KEY'));
    var metas = [];
    return ids.reduce(function (p, it) {
      return p.then(function () {
        if (it.kind === 'folder') return listFolder(it.id, key).then(function (l) { metas = metas.concat(l); });
        return driveApi('files/' + it.id + '?fields=id,name,mimeType,size', key).then(function (r) { return r.json(); }).then(function (m) { metas.push(m); });
      });
    }, Promise.resolve()).then(function () {
      var files = [];
      return metas.reduce(function (p, m, i) {
        return p.then(function () {
          var label = '(' + (i + 1) + '/' + metas.length + ') ' + m.name;
          if (onProgress) onProgress('Đang tải từ Google Drive ' + label + (m.size ? ' · ' + Math.round(m.size / 1048576) + ' MB' : '') + '…');
          var path, name = m.name, type = m.mimeType;
          if (m.mimeType === 'application/vnd.google-apps.spreadsheet') { path = 'files/' + m.id + '/export?mimeType=text/csv'; name += '.csv'; type = 'text/csv'; }
          else if (m.mimeType === 'application/vnd.google-apps.document') { path = 'files/' + m.id + '/export?mimeType=text/plain'; name += '.txt'; type = 'text/plain'; }
          else if (/^application\/vnd\.google-apps/.test(m.mimeType)) return;
          else path = 'files/' + m.id + '?alt=media';
          return driveApi(path, key).then(function (r) { return r.blob(); }).then(function (b) { files.push(new File([b], name, { type: type || b.type })); });
        });
      }, Promise.resolve()).then(function () { return files; });
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
    var r = { scripts: [], media: [], music: [], other: [], zips: [] };
    files.forEach(function (f) {
      if (/^\./.test(f.name)) return;
      if (/\.zip$/i.test(f.name)) { r.zips.push(f); return; }
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
    filesFromDrop: filesFromDrop, classify: classify, readXlsx: readXlsx, readDocx: readDocx,
    sheetRows: sheetRows, unzipFile: unzipFile, expandZips: expandZips, fromDrive: fromDrive, driveIds: driveIds
  };
})();
