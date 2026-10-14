/* File WebM do trình duyệt ghi không có thời lượng (không tua được). Hàm này ghi thêm thời lượng vào file. */
(function () {
  'use strict';

  function readVint(b, i) {
    var first = b[i], len = 1, mask = 0x80;
    while (len <= 8 && !(first & mask)) { len++; mask >>= 1; }
    if (len > 8) return null;
    var v = first & (mask - 1);
    for (var k = 1; k < len; k++) v = v * 256 + b[i + k];
    return { len: len, value: v };
  }

  function writeVint(value, len) {
    var out = new Uint8Array(len);
    for (var k = len - 1; k >= 0; k--) { out[k] = value % 256; value = Math.floor(value / 256); }
    out[0] |= 0x80 >> (len - 1);
    return out;
  }

  function find(b, ids, from, to) {
    for (var i = from; i < to - ids.length; i++) {
      var ok = true;
      for (var k = 0; k < ids.length; k++) if (b[i + k] !== ids[k]) { ok = false; break; }
      if (ok) return i;
    }
    return -1;
  }

  /** Trả về Blob mới có thời lượng; lỗi thì trả lại blob cũ. */
  function fixDuration(blob, seconds) {
    return blob.arrayBuffer().then(function (ab) {
      var b = new Uint8Array(ab);
      var scan = Math.min(b.length, 8192);
      var info = find(b, [0x15, 0x49, 0xA9, 0x66], 0, scan);
      if (info < 0) return blob;
      var sz = readVint(b, info + 4);
      if (!sz) return blob;
      var start = info + 4 + sz.len, end = start + sz.value;
      if (find(b, [0x44, 0x89], start, end) >= 0) return blob; // đã có thời lượng
      var scale = 1000000;
      var ts = find(b, [0x2A, 0xD7, 0xB1], start, end);
      if (ts >= 0) {
        var tsz = readVint(b, ts + 3);
        scale = 0;
        for (var k = 0; k < tsz.value; k++) scale = scale * 256 + b[ts + 3 + tsz.len + k];
      }
      var dur = new Uint8Array(11);
      dur[0] = 0x44; dur[1] = 0x89; dur[2] = 0x88;
      new DataView(dur.buffer).setFloat64(3, seconds * 1e9 / scale);
      var newSize = sz.value + dur.length;
      if (newSize >= Math.pow(2, 7 * sz.len) - 1) return blob;
      var out = new Uint8Array(b.length + dur.length);
      out.set(b.subarray(0, info + 4), 0);
      out.set(writeVint(newSize, sz.len), info + 4);
      out.set(b.subarray(start, end), start);
      out.set(dur, end);
      out.set(b.subarray(end), end + dur.length);
      return new Blob([out], { type: blob.type });
    }).catch(function () { return blob; });
  }

  window.WebmFix = { fixDuration: fixDuration };
})();
