var STATUSES = ['Mới', 'Đã liên hệ', 'Quan tâm', 'Hẹn xem', 'Chốt', 'Mất'];
function crmUpdateLead(k, phone, f) {
  requireUi_(k);
  f = f || {};
  if (f.status !== undefined && STATUSES.indexOf(f.status) < 0) throw new Error('Trạng thái không hợp lệ');
  return withLock_(function () {
    var x = findLead_(phone), sh = x.sh, r = x.row;
    if (f.name !== undefined) sh.getRange(r, 3).setValue(str_(f.name, 120));
    if (f.status !== undefined) sh.getRange(r, 19).setValue(f.status);
    if (f.assignee !== undefined) sh.getRange(r, 20).setValue(str_(f.assignee, 80));
    if (f.value !== undefined) sh.getRange(r, 21).setValue(Math.max(0, Number(f.value) || 0));
    if (f.note !== undefined) sh.getRange(r, 22).setValue(str_(f.note, 2000));
    return { ok: true };
  });
}

function crmClickDone(k, row, vid, done, note) {
  requireUi_(k);
  return withLock_(function () {
    var sh = ss_().getSheetByName(S_CLICKS);
    row = Number(row);
    if (!sh || row < 2 || String(sh.getRange(row, 2).getValue()) !== String(vid)) throw new Error('Dòng đã thay đổi, hãy tải lại');
    sh.getRange(row, 9).setValue(done === true);
    if (note !== undefined) sh.getRange(row, 10).setValue(str_(note, 300));
    return { ok: true };
  });
}

function crmEvents(k, vid) {
  requireUi_(k);
  vid = String(vid || '');
  if (!vid) return [];
  var sh = ss_().getSheetByName(S_EVENTS), n = sh.getLastRow();
  if (n < 2) return [];
  var rows = sh.getRange(2, 1, n - 1, 8).getValues(), out = [];
  for (var i = rows.length - 1; i >= 0 && out.length < 100; i--) {
    var r = rows[i];
    if (String(r[1]) === vid) out.push({ at: iso_(r[0]), site: String(r[2]), type: String(r[3]), channel: String(r[4]), url: String(r[5]), source: String(r[6]), campaign: String(r[7]) });
  }
  return out;
}

function doPost(e) {
  try {
    var b = parseBody_(e);
    var site = findSite_(b.key);
    if (!site) return json_({ error: 'Mã website không hợp lệ' });
    var action = b.action || (b.type === 'pageview' || b.type === 'click' ? 'track' : 'lead');
    if (action === 'track') return json_(handleTrack_(b, site));
    return json_(handleLead_(b, site));
  } catch (err) {
    return json_({ error: String(err && err.message || err) });
  }
}

function json_(o) {
  return ContentService.createTextOutput(JSON.stringify(o)).setMimeType(ContentService.MimeType.JSON);
}

function parseBody_(e) {
  var b = {};
  var raw = e && e.postData && e.postData.contents;
  if (raw) { try { b = JSON.parse(raw); } catch (x) { b = {}; } }
  var p = (e && e.parameter) || {};
  for (var k in p) if (b[k] === undefined) b[k] = p[k];   // form-encoded (webhook) hoặc ?key=...
  return b;
}

function str_(v, max) {
  v = v == null ? '' : String(v).slice(0, max || 300);
  return /^[=+\-@]/.test(v) ? "'" + v : v;               // chống chèn công thức
}

function normPhone_(p) {
  var d = String(p || '').replace(/[^\d+]/g, '');
  if (d.indexOf('+84') === 0) d = '0' + d.slice(3);
  else if (d.indexOf('84') === 0 && d.length >= 11) d = '0' + d.slice(2);
  d = d.replace(/\D/g, '');
  return d.length >= 9 && d.length <= 11 ? d : '';
}

function ss_() { return SpreadsheetApp.getActiveSpreadsheet(); }

// key -> tên website, lấy từ tab Website (cột A tên, C mã), cache 60 giây
function findSite_(key) {
  key = String(key || '').trim();
  if (key.length < 8) return null;
  var cache = CacheService.getScriptCache(), map = null;
  try { map = JSON.parse(cache.get('sites') || 'null'); } catch (x) {}
  if (!map) {
    map = {};
    var sh = ss_().getSheetByName(S_SITES), n = sh.getLastRow();
    if (n > 1) sh.getRange(2, 1, n - 1, 3).getValues().forEach(function (r) {
      var k = String(r[2]).trim(); if (k.length >= 8 && r[0]) map[k] = String(r[0]);
    });
    try { cache.put('sites', JSON.stringify(map), 60); } catch (x) {}
  }
  return map[key] ? { key: key, name: map[key] } : null;
}

