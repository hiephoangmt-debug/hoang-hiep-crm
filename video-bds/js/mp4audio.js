/*
 * Tách riêng tiếng từ file MP4 / MOV mà không đọc cả file video vào bộ nhớ.
 * Video quay dài trên iPhone có thể nặng vài GB: đọc hết để giải mã tiếng sẽ hết bộ nhớ và hỏng.
 * Ở đây chỉ đọc phần mục lục (moov) và các đoạn dữ liệu tiếng, ghép thành một file .m4a nhỏ.
 */
(function () {
  'use strict';

  function readRange(file, a, b) {
    var part = file.slice(a, b);
    return part.arrayBuffer ? part.arrayBuffer() : new Response(part).arrayBuffer();
  }

  function u32(dv, o) { return dv.getUint32(o); }
  function u64(dv, o) { return dv.getUint32(o) * 4294967296 + dv.getUint32(o + 4); }
  function type(dv, o) { return String.fromCharCode(dv.getUint8(o), dv.getUint8(o + 1), dv.getUint8(o + 2), dv.getUint8(o + 3)); }

  /** Duyệt các hộp cấp cao nhất trong file (đọc 16 byte đầu mỗi hộp). */
  function topBoxes(file) {
    var out = [];
    function next(pos) {
      if (pos + 8 > file.size || out.length > 64) return Promise.resolve(out);
      return readRange(file, pos, Math.min(file.size, pos + 16)).then(function (ab) {
        var dv = new DataView(ab);
        var size = u32(dv, 0), t = type(dv, 4), hdr = 8;
        if (size === 1) { size = u64(dv, 8); hdr = 16; }
        else if (size === 0) size = file.size - pos;
        if (size < hdr) return out;
        out.push({ type: t, start: pos, size: size, hdr: hdr });
        return next(pos + size);
      });
    }
    return next(0);
  }

  /** Các hộp con nằm trong [from, to) của một vùng nhớ. */
  function children(dv, from, to) {
    var out = [], p = from;
    while (p + 8 <= to) {
      var size = u32(dv, p), hdr = 8;
      if (size === 1) { size = u64(dv, p + 8); hdr = 16; }
      else if (size === 0) size = to - p;
      if (size < hdr || p + size > to) break;
      out.push({ type: type(dv, p + 4), start: p, size: size, hdr: hdr });
      p += size;
    }
    return out;
  }

  function find(dv, box, path) {
    var cur = box;
    for (var i = 0; i < path.length && cur; i++) {
      var kids = children(dv, cur.start + cur.hdr, cur.start + cur.size);
      cur = kids.filter(function (k) { return k.type === path[i]; })[0];
    }
    return cur || null;
  }

  /**
   * Trả về Blob .m4a chỉ chứa tiếng, hoặc null nếu file không phải MP4/MOV hợp lệ / không có tiếng.
   */
  function extract(file) {
    return topBoxes(file).then(function (boxes) {
      var moovBox = boxes.filter(function (b) { return b.type === 'moov'; })[0];
      var ftypBox = boxes.filter(function (b) { return b.type === 'ftyp'; })[0];
      if (!moovBox || moovBox.size > 200 * 1048576) return null;
      return Promise.all([
        readRange(file, moovBox.start, moovBox.start + moovBox.size),
        ftypBox && ftypBox.size < 4096 ? readRange(file, ftypBox.start, ftypBox.start + ftypBox.size) : null
      ]).then(function (r) { return build(file, r[0], r[1]); });
    });
  }

  function build(file, moovAb, ftypAb) {
    var dv = new DataView(moovAb);
    var moov = { type: 'moov', start: 0, size: moovAb.byteLength, hdr: 8 };
    var kids = children(dv, 8, moovAb.byteLength);
    var mvhd = kids.filter(function (k) { return k.type === 'mvhd'; })[0];
    var trak = kids.filter(function (k) {
      if (k.type !== 'trak') return false;
      var h = find(dv, k, ['mdia', 'hdlr']);
      return h && type(dv, h.start + h.hdr + 8) === 'soun';
    })[0];
    if (!mvhd || !trak) return null;
    if (kids.some(function (k) { return k.type === 'mvex'; })) return null; // file phân mảnh: để giải mã cả file
    var stbl = find(dv, trak, ['mdia', 'minf', 'stbl']);
    if (!stbl) return null;
    var tbl = {};
    children(dv, stbl.start + stbl.hdr, stbl.start + stbl.size).forEach(function (b) { tbl[b.type] = b; });
    var co = tbl.stco || tbl.co64, stsc = tbl.stsc, stsz = tbl.stsz;
    if (!co || !stsc || !stsz) return null;
    var big = co.type === 'co64';

    // Vị trí và độ dài từng khối dữ liệu tiếng
    var nChunks = u32(dv, co.start + co.hdr + 4), offs = [];
    for (var i = 0; i < nChunks; i++) {
      var o = co.start + co.hdr + 8 + i * (big ? 8 : 4);
      offs.push(big ? u64(dv, o) : u32(dv, o));
    }
    var sampleSize = u32(dv, stsz.start + stsz.hdr + 4), nSamples = u32(dv, stsz.start + stsz.hdr + 8);
    var sizeAt = function (s) { return sampleSize || u32(dv, stsz.start + stsz.hdr + 12 + s * 4); };
    var nRuns = u32(dv, stsc.start + stsc.hdr + 4), runs = [];
    for (var r = 0; r < nRuns; r++) {
      var ro = stsc.start + stsc.hdr + 8 + r * 12;
      runs.push({ first: u32(dv, ro), per: u32(dv, ro + 4) });
    }
    if (!runs.length) return null;
    var lens = [], s = 0, ri = 0;
    for (var c = 1; c <= nChunks; c++) {
      while (ri + 1 < runs.length && runs[ri + 1].first <= c) ri++;
      var len = 0;
      for (var k = 0; k < runs[ri].per && s < nSamples; k++, s++) len += sizeAt(s);
      lens.push(len);
    }

    // Hộp moov mới: chỉ giữ mvhd + track tiếng, sửa lại vị trí các khối dữ liệu
    var ftyp = ftypAb ? new Uint8Array(ftypAb) : (function () {
      var f = new Uint8Array(24), fd = new DataView(f.buffer);
      fd.setUint32(0, 24);
      [['ftyp', 4], ['M4A ', 8], ['M4A ', 16], ['isom', 20]].forEach(function (x) {
        for (var j = 0; j < 4; j++) f[x[1] + j] = x[0].charCodeAt(j);
      });
      return f;
    })();
    var mv = new Uint8Array(moovAb, mvhd.start, mvhd.size);
    var tk = new Uint8Array(moovAb.slice(trak.start, trak.start + trak.size));
    if (mvhd.hdr !== 8 || trak.hdr !== 8) return null;
    var moovSize = 8 + mv.length + tk.length;
    var head = new Uint8Array(moovSize), hd = new DataView(head.buffer);
    hd.setUint32(0, moovSize);
    for (var j = 0; j < 4; j++) head[4 + j] = 'moov'.charCodeAt(j);
    head.set(mv, 8);
    head.set(tk, 8 + mv.length);
    var total = lens.reduce(function (a, b) { return a + b; }, 0);
    if (!total || total > 400 * 1048576) return null;
    var base = ftyp.length + moovSize + 8, pos = base;
    var coInHead = 8 + mv.length + (co.start - trak.start) + co.hdr + 8;
    for (var q = 0; q < nChunks; q++) {
      var at = coInHead + q * (big ? 8 : 4);
      if (big) { hd.setUint32(at, Math.floor(pos / 4294967296)); hd.setUint32(at + 4, pos >>> 0); }
      else hd.setUint32(at, pos);
      pos += lens[q];
    }
    var mdatHdr = new Uint8Array(8), md = new DataView(mdatHdr.buffer);
    md.setUint32(0, 8 + total);
    for (var m = 0; m < 4; m++) mdatHdr[4 + m] = 'mdat'.charCodeAt(m);

    // Đọc các khối tiếng (gộp các khối nằm sát nhau để đọc ít lần)
    var ranges = [];
    offs.forEach(function (o, idx) {
      var last = ranges[ranges.length - 1];
      if (last && o === last.b) last.b += lens[idx];
      else ranges.push({ a: o, b: o + lens[idx] });
    });
    var parts = new Array(ranges.length);
    var nextIdx = 0;
    function worker() {
      if (nextIdx >= ranges.length) return Promise.resolve();
      var idx = nextIdx++;
      return readRange(file, ranges[idx].a, ranges[idx].b).then(function (ab) { parts[idx] = ab; return worker(); });
    }
    var workers = [];
    for (var w = 0; w < 8; w++) workers.push(worker());
    return Promise.all(workers).then(function () {
      return new Blob([ftyp, head, mdatHdr].concat(parts), { type: 'audio/mp4' });
    });
  }

  window.BdsMp4Audio = { extract: extract };
})();
