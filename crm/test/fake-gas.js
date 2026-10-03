/*
 * Giả lập tối thiểu các dịch vụ Google Apps Script để chạy Code.gs ngoài Google
 * (test bằng Node và bản xem thử giao diện trong trình duyệt). Không dùng khi chạy thật.
 */
(function (root) {
  function FakeRange(sheet, r, c, nr, nc) {
    this.getValues = function () {
      var out = [];
      for (var i = 0; i < nr; i++) {
        var row = sheet._rows[r - 1 + i] || [];
        var o = [];
        for (var j = 0; j < nc; j++) o.push(row[c - 1 + j] === undefined ? '' : row[c - 1 + j]);
        out.push(o);
      }
      return out;
    };
    this.setValues = function (vals) {
      for (var i = 0; i < vals.length; i++) {
        var idx = r - 1 + i;
        sheet._rows[idx] = sheet._rows[idx] || [];
        for (var j = 0; j < vals[i].length; j++) sheet._rows[idx][c - 1 + j] = vals[i][j];
      }
      return this;
    };
    this.setNumberFormat = function () { return this; };
  }

  function FakeSheet(name) {
    this._name = name;
    this._rows = [];
    this.getName = function () { return name; };
    this.getLastRow = function () { return this._rows.length; };
    this.getMaxRows = function () { return 1000; };
    this._maxCols = 26;
    this.getLastColumn = function () {
      return this._rows.reduce(function (m, row) {
        for (var j = row.length; j > 0; j--) if (row[j - 1] !== '' && row[j - 1] !== undefined) return Math.max(m, j);
        return m;
      }, 0);
    };
    this.getMaxColumns = function () { return this._maxCols; };
    this.insertColumnsAfter = function (after, n) { this._maxCols += n; };
    this.getRange = function (r, c, nr, nc) { return new FakeRange(this, r, c, nr || 1, nc || 1); };
    this.appendRow = function (row) { this._rows.push(row.slice()); };
    this.deleteRow = function (r) { this._rows.splice(r - 1, 1); };
    this.setFrozenRows = function () {};
    this.clear = function () { this._rows = []; return this; };
    this.getSheetId = function () { return 12345; };
    this.autoResizeColumns = function () {};
  }

  var sheets = {};
  var spreadsheet = {
    getSheetByName: function (n) { return sheets[n] || null; },
    insertSheet: function (n) { sheets[n] = new FakeSheet(n); return sheets[n]; },
    getUrl: function () { return 'https://docs.google.com/spreadsheets/d/DEMO'; },
    _sheets: sheets
  };

  var props = {};
  var cache = {};
  var sentMail = [];
  var events = [];
  var fakeToday = null;
  var drive = { folders: {}, files: {} };

  function pad(n) { return (n < 10 ? '0' : '') + n; }
  function sha(str) { // không phải mã hóa thật – chỉ để test
    var h = 2166136261;
    for (var i = 0; i < str.length; i++) { h ^= str.charCodeAt(i); h = Math.imul(h, 16777619) >>> 0; }
    return [h & 255, (h >> 8) & 255, (h >> 16) & 255, (h >> 24) & 255];
  }

  var api = {
    SpreadsheetApp: { getActive: function () { return spreadsheet; } },
    PropertiesService: {
      getScriptProperties: function () {
        return {
          getProperty: function (k) { return props[k] === undefined ? null : props[k]; },
          setProperty: function (k, v) { props[k] = String(v); }
        };
      }
    },
    CacheService: {
      getScriptCache: function () {
        return {
          get: function (k) { return cache[k] === undefined ? null : cache[k]; },
          put: function (k, v) { cache[k] = String(v); },
          remove: function (k) { delete cache[k]; }
        };
      }
    },
    Utilities: {
      DigestAlgorithm: { SHA_256: 'sha256' },
      Charset: { UTF_8: 'utf8' },
      computeDigest: function (alg, s) { return sha(s); },
      base64Encode: function (b) { return b && b.__b64 !== undefined ? b.__b64 : b.join('.'); },
      base64Decode: function (s) { return { __b64: s }; },
      newBlob: function (bytes, type, name) {
        return { getBytes: function () { return bytes; }, getContentType: function () { return type; }, getName: function () { return name; } };
      },
      getUuid: function () {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function () { return (Math.random() * 16 | 0).toString(16); });
      },
      formatDate: function (d, tz, fmt) {
        if (fakeToday && d.__now) {
          return fmt === 'yyyy-MM-dd' ? fakeToday : fakeToday + ' 09:00';
        }
        // Giờ Việt Nam = UTC+7
        var v = new Date(d.getTime() + 7 * 3600000);
        var s = v.getUTCFullYear() + '-' + pad(v.getUTCMonth() + 1) + '-' + pad(v.getUTCDate());
        return fmt === 'yyyy-MM-dd' ? s : s + ' ' + pad(v.getUTCHours()) + ':' + pad(v.getUTCMinutes());
      }
    },
    LockService: { getScriptLock: function () { return { waitLock: function () {}, releaseLock: function () {} }; } },
    Session: { getEffectiveUser: function () { return { getEmail: function () { return 'owner@example.com'; } }; } },
    MailApp: { sendEmail: function (to, subject, body) { sentMail.push({ to: to, subject: subject, body: body }); } },
    CalendarApp: {
      getDefaultCalendar: function () {
        return {
          createAllDayEvent: function (title, start, end, opts) {
            var ev = { id: 'ev' + (events.length + 1), title: title, start: start, end: end, opts: opts };
            events.push(ev);
            return { getId: function () { return ev.id; }, addPopupReminder: function () {} };
          }
        };
      }
    },
    ScriptApp: {
      getService: function () { return { getUrl: function () { return 'https://script.google.com/macros/s/DEMO/exec'; } }; },
      getProjectTriggers: function () { return []; },
      deleteTrigger: function () {},
      newTrigger: function () {
        var b = { timeBased: function () { return b; }, everyDays: function () { return b; }, atHour: function () { return b; },
          inTimezone: function () { return b; }, create: function () { return {}; } };
        return b;
      }
    },
    ContentService: {
      MimeType: { JSON: 'json' },
      createTextOutput: function (s) { return { content: s, setMimeType: function () { return this; } }; }
    },
    DriveApp: (function () {
      var n = 0;
      function folder(name) {
        var f = { id: 'fo' + (++n), name: name, children: [] };
        drive.folders[f.id] = f;
        return {
          getId: function () { return f.id; },
          getFoldersByName: function (nm) {
            var hits = f.children.filter(function (c) { return drive.folders[c].name === nm; });
            return { hasNext: function () { return hits.length > 0; }, next: function () { return wrapFolder(hits.shift()); } };
          },
          createFolder: function (nm) { var c = folder(nm); wraps[c.getId()] = c; f.children.push(c.getId()); return c; },
          createFile: function (blob) {
            var id = 'fi' + (++n);
            drive.files[id] = { blob: blob, folder: f.id, trashed: false };
            return { getId: function () { return id; } };
          }
        };
      }
      var wraps = {};
      function wrapFolder(id) { return wraps[id]; }
      return {
        createFolder: function (name) { var w = folder(name); wraps[w.getId()] = w; return w; },
        getFolderById: function (id) { if (!wraps[id]) throw new Error('no folder'); return wraps[id]; },
        getFileById: function (id) {
          var f = drive.files[id];
          if (!f) throw new Error('no file');
          return { getBlob: function () { return f.blob; }, setTrashed: function (v) { f.trashed = v; } };
        }
      };
    })(),
    HtmlService: {},
    Logger: { log: function () {} },
    __fake: {
      setToday: function (s) { fakeToday = s; },
      sentMail: sentMail,
      drive: drive,
      events: events,
      props: props,
      sheets: sheets
    }
  };

  // Đánh dấu new Date() "bây giờ" để formatDate trả về ngày giả lập.
  var RealDate = Date;
  function PatchedDate() {
    if (!(this instanceof PatchedDate)) return RealDate.apply(null, arguments);
    var args = Array.prototype.slice.call(arguments);
    var d = args.length ? new (Function.prototype.bind.apply(RealDate, [null].concat(args)))() : new RealDate();
    if (!args.length) d.__now = true;
    return d;
  }
  PatchedDate.UTC = RealDate.UTC;
  PatchedDate.now = RealDate.now;
  PatchedDate.parse = RealDate.parse;
  PatchedDate.prototype = RealDate.prototype;
  api.Date = PatchedDate;

  root.FakeGAS = api;
})(typeof globalThis !== 'undefined' ? globalThis : this);
