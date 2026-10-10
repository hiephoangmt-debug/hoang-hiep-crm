// Giả lập tối thiểu các dịch vụ Apps Script để chạy Code.gs trong Node.
import { readFileSync } from 'node:fs';
import { createHash, randomUUID } from 'node:crypto';
export function loadGas(tabs = {}) {
  const sheets = {}; const mail = []; const events = {}; const props = {}; const cache = {};
  const mkSheet = (name, rows = []) => {
    const data = rows.map(r => r.slice());
    const sh = {
      data, getName: () => name,
      getLastRow: () => data.length, getLastColumn: () => Math.max(1, ...data.map(r => r.length)),
      appendRow: r => data.push(r.map(v => typeof v === 'string' && v.startsWith("'") ? v.slice(1) : v)),
      setFrozenRows() {}, hideColumns() {},
      getRange: (r, c, nr = 1, nc = 1) => ({
        getValues: () => Array.from({ length: nr }, (_, i) => Array.from({ length: nc }, (_, j) => (data[r - 1 + i] || [])[c - 1 + j] ?? '')),
        setValues: vals => vals.forEach((row, i) => row.forEach((v, j) => { data[r - 1 + i] = data[r - 1 + i] || []; data[r - 1 + i][c - 1 + j] = typeof v === 'string' && v.startsWith("'") ? v.slice(1) : v; })),
        setValue: v => { data[r - 1][c - 1] = v; },
        setFontWeight() { return this; }, setBackground() { return this; }, setFontColor() { return this; },
      }),
      deleteRow: r => data.splice(r - 1, 1),
    };
    sheets[name] = sh; return sh;
  };
  Object.entries(tabs).forEach(([n, rows]) => mkSheet(n, rows));
  const pad = n => String(n).padStart(2, '0');
  const g = {
    SpreadsheetApp: { openById: () => ({ getSheetByName: n => sheets[n] || null, insertSheet: n => mkSheet(n), getSheets: () => Object.values(sheets), getUrl: () => 'https://sheet' }) },
    Utilities: {
      formatDate: (d, tz, f) => f === 'yyyy-MM-dd HH:mm:ss' ? `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())} ${pad(d.getHours())}:${pad(d.getMinutes())}:${pad(d.getSeconds())}`
        : f === 'yyyy-MM-dd' ? `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}` : f === 'HH:mm' ? `${pad(d.getHours())}:${pad(d.getMinutes())}` : d.toISOString(),
      computeDigest: (a, s) => [...createHash('sha256').update(s).digest()], base64Encode: b => Buffer.from(b.map(x => x & 255)).toString('base64'),
      getUuid: () => randomUUID(), DigestAlgorithm: { SHA_256: 1 }, Charset: { UTF_8: 1 },
    },
    LockService: { getScriptLock: () => ({ waitLock() {}, releaseLock() {} }) },
    PropertiesService: { getScriptProperties: () => ({ getProperty: k => props[k] ?? null, setProperty: (k, v) => props[k] = v, setProperties: o => Object.assign(props, o) }) },
    CacheService: { getScriptCache: () => ({ get: k => cache[k] ?? null, put: (k, v) => cache[k] = v, remove: k => delete cache[k] }) },
    ContentService: { createTextOutput: s => ({ setMimeType: () => s }), MimeType: { JSON: 1 } },
    MailApp: { sendEmail: (...a) => mail.push(a) },
    Session: { getEffectiveUser: () => ({ getEmail: () => 'owner@example.com' }) },
    ScriptApp: { getService: () => ({ getUrl: () => 'https://crm' }), getProjectTriggers: () => [], deleteTrigger() {},
      newTrigger: () => { const b = { timeBased: () => b, atHour: () => b, nearMinute: () => b, everyDays: () => b, inTimezone: () => b, everyMinutes: () => b, create: () => ({}) }; return b; } },
    CalendarApp: { getDefaultCalendar: () => ({
      getEventById: id => events[id] || null,
      createEvent: (t, s, e) => { const id = 'ev' + Object.keys(events).length; const ev = { id, t, s, getId: () => id, removeAllReminders() {}, addPopupReminder() {}, setTime(a) { ev.s = a; }, setTitle(x) { ev.t = x; }, setDescription() {}, deleteEvent() { delete events[id]; } }; events[id] = ev; return ev; } }) },
    console: { log: (...a) => g.logs.push(a.join(' ')), warn: (...a) => g.logs.push('WARN ' + a.join(' ')) }, logs: [],
  };
  const src = readFileSync(new URL('../Code.gs', import.meta.url), 'utf8');
  const names = [...src.matchAll(/^function (\w+)/gm)].map(m => m[1]).concat(['advise_', 'parseLegacyRow_']);
  const fn = new Function(...Object.keys(g), src + `; return {${[...new Set(names)].join(',')}};`);
  return { api: fn(...Object.values(g)), sheets, mail, events, props, g };
}
