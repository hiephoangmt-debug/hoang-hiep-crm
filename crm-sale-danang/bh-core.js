/* Lõi xử lý bảng hàng (dùng chung cho bang-hang.html và tests/bh-core.test.html) – không đụng DOM, không đụng Firestore.
   - Nhận sàn từ chữ (tiêu đề bảng, tên file / thư mục, chữ AI đọc trên ảnh, tin nhắn dán kèm)
   - Chuẩn hoá & tách mã căn
   - So sánh bảng cũ / mới của một sàn (chế độ bổ sung hoặc thay toàn bộ)
   - Gộp sàn cũ về 3 loại nguồn (công ty / chủ đầu tư / rổ chéo), mỗi sàn = một đơn vị */
(function (G) {
  'use strict';
  // bỏ dấu, chữ thường, chỉ giữ chữ số + chữ cái, cách nhau 1 dấu cách
  const fold = s => ' ' + String(s || '').normalize('NFD').replace(/[̀-ͯ]/g, '').replace(/đ/gi, 'd').toLowerCase().replace(/[^a-z0-9]+/g, ' ').trim() + ' ';
  const KIND_VI = {cty: 'Hàng công ty', cdt: 'Hàng chủ đầu tư', ngoai: 'Rổ chéo'};

  // Đơn vị mặc định + tên gọi khác (so khớp không phân biệt hoa thường, dấu)
  const DEFAULT_UNITS = [
    {key: 'tatiland', name: 'TATILAND (kho công ty)', kind: 'cty', aliases: ['tatiland', 'tati land', 'kho cong ty', 'hang cong ty', 'quy cong ty']},
    {key: 'cdt', name: 'Giỏ hàng chủ đầu tư', kind: 'cdt', aliases: ['gio hang chu dau tu', 'gio chu dau tu', 'hang chu dau tu', 'gio hang cdt', 'gio cdt', 'hang cdt', 'quy cdt']},
    {key: 'mayhomes', name: 'Mayhomes Realty', kind: 'ngoai', aliases: ['mayhomes', 'may homes', 'mayhome']},
    {key: 'hungphat', name: 'Hưng Phát Apartment', kind: 'ngoai', aliases: ['hung phat']},
    {key: 'iqi', name: 'IQI Việt Nam', kind: 'ngoai', aliases: ['iqi']},
    {key: 'bautroi', name: 'Bầu Trời Việt Nam', kind: 'ngoai', aliases: ['bau troi', 'bautroi']},
    {key: 'nsl', name: 'NSL', kind: 'ngoai', aliases: ['nsl']},
    {key: 'scd', name: 'SCD Group / Sun Property', kind: 'ngoai', aliases: ['scd', 'sun property', 'sunproperty']},
    {key: 'minhminh', name: 'Minh Minh Group', kind: 'ngoai', aliases: ['minh minh']},
    {key: 'seven', name: 'Seven Realty', kind: 'ngoai', aliases: ['seven realty', '7 realty', 'seven land']},
    {key: 'vhomes', name: 'VHomes', kind: 'ngoai', aliases: ['vhomes', 'v homes', 'vhome']}
  ];
  // Dự án + tên gọi khác (cảnh báo khi bảng nhắc tới dự án khác dự án đang chọn)
  const PROJECT_ALIASES = [
    {re: /four ?s|bon mua/, aliases: ['fours', 'four s', 'bon mua', 'sun fours']},
    {re: /s ?light/, aliases: ['s light', 'slight', 'slight tower']},
    {re: /casamia|balanca/, aliases: ['casamia', 'balanca']},
    {re: /symphony/, aliases: ['symphony']},
    {re: /cosmo/, aliases: ['cosmo']},
    {re: /ponte/, aliases: ['ponte']}
  ];

  const aliasesOf = s => [s.name, s.label].concat(s.aliases || []).filter(Boolean).map(a => fold(a).trim()).filter(a => a.length >= 2);
  // Tìm sàn trong các nguồn chữ, theo thứ tự ưu tiên (tin nhắn dán kèm > tiêu đề bảng > tên file > tên thư mục > chữ trên ảnh).
  // sans: [{id, name, kind, aliases}] – trả về {san, alias, from} hoặc null. Tên dài khớp trước (vd "sun property" trước "sun").
  function matchSan(sources, sans) {
    const list = [];
    sans.forEach(s => aliasesOf(s).forEach(a => list.push({s, a})));
    list.sort((x, y) => y.a.length - x.a.length);
    for (const src of sources) {
      const t = fold(src && src.text); if (t.trim().length < 2) continue;
      for (const {s, a} of list) if (t.includes(' ' + a + ' ')) return {san: s, alias: a, from: src.from || ''};
    }
    return null;
  }
  // Gợi ý khi gõ tìm sàn: khớp đầu từ / chứa chuỗi, tối đa n kết quả
  function searchSans(q, sans, n = 6) {
    const f = fold(q).trim(); if (!f) return [];
    return sans.map(s => { const al = aliasesOf(s); const score = al.some(a => a === f) ? 3 : al.some(a => a.startsWith(f)) ? 2 : al.some(a => a.includes(f)) ? 1 : 0; return {s, score}; })
      .filter(x => x.score).sort((a, b) => b.score - a.score || String(a.s.name).localeCompare(String(b.s.name), 'vi')).slice(0, n).map(x => x.s);
  }
  // Dự án được nhắc tới trong chữ: trả về danh sách {id, name} (projects: [{id, name}])
  function mentionedProjects(text, projects) {
    const t = fold(text), out = [];
    for (const p of projects) {
      const pf = fold(p.name), def = PROJECT_ALIASES.find(d => d.re.test(pf));
      const al = (def ? def.aliases : []).concat([pf.trim()]).map(a => fold(a).trim()).filter(a => a.length >= 3);
      if (al.some(a => t.includes(' ' + a + ' '))) out.push(p);
    }
    return out;
  }

  /* ---------- MÃ CĂN ---------- */
  const normF = f => String(f).toUpperCase().replace(/^0+(?=\d)/, '');
  const normU = u => String(u).toUpperCase().replace(/^(\d)(?!\d)/, '0$1');
  const padF = f => String(f).replace(/^(\d+)/, d => d.padStart(2, '0'));
  const codeOf = (t, f, u) => f === '' ? (t && t !== 'Chung' ? `${t}-${u}` : u) : `${t}-${padF(f)}-${u}`;
  // F2.05.01 = F2-05-01 = F2 05 01 = F2_05_01 = F20501; F212A03A = F2 / 12A / 03A
  function parseCode(s) {
    const raw = String(s || '').toUpperCase().trim();
    let m = raw.match(/^([A-Z]{1,3}\d{0,2}[A-Z]?)[\s\-_.]+(\d{1,2}[AB]?)[\s\-_.]+(\d{1,2}[AB]?)$/);
    if (!m) m = raw.replace(/\s/g, '').match(/^([A-Z]{1,3}\d)(\d{2}[AB]?|\d[AB])(\d{2}[AB]?)$/);
    if (!m) m = raw.replace(/\s/g, '').match(/^([A-Z]{1,2}\d[A-Z])(\d{2})(\d{2}[AB]?)$/); // tòa có chữ cuối, viết liền: S5A0906 = S5A / 09 / 06
    if (!m) return null;
    return {tower: m[1], floor: normF(m[2]), u: normU(m[3])};
  }
  // Mã dính liền (F21120) mà bảng có cột Tòa / Tầng: tách theo cột (Tòa F2, Tầng 11 → căn 20)
  function splitByCols(code, tower, floor) {
    const c = String(code || '').toUpperCase().replace(/[\s\-_.]/g, ''), t = String(tower || '').toUpperCase().trim(), f = String(floor || '').toUpperCase().trim();
    if (!c || !t || !c.startsWith(t)) return null;
    let rest = c.slice(t.length);
    if (f !== '') { const fp = [padF(f), normF(f)].find(x => rest.startsWith(x)); if (!fp) return null; rest = rest.slice(fp.length); }
    if (!rest || !/^\d{1,2}[AB]?$/.test(rest)) return null;
    return {tower: t, floor: f === '' ? '' : normF(f), u: normU(rest)};
  }

  /* ---------- TÀI LIỆU TỪNG CĂN (thư mục Drive mỗi căn: bảng tính + hình chỉ căn) ---------- */
  // Tên thư mục → mã căn: "S5A0906", "S5A-09-06 Nguyễn Văn A", "F2.11.31 (cọc)" …
  function unitFromName(name) {
    const s = String(name || '').toUpperCase().replace(/\(.*?\)/g, ' ').trim();
    const direct = parseCode(s); if (direct) return direct;
    const tok = s.split(/\s+[-–—_]\s+|\s{2,}/)[0].trim(); const a = parseCode(tok); if (a) return a;
    // mã nằm giữa tên: tòa phải có số (F2, S5A, SL1) và đứng đầu một từ – tránh nhầm "NGÀY 01.10"
    const m = s.match(/(?<![A-ZÀ-Ỹ\d])(?:[A-Z]{1,3}\d{1,2}[A-Z]?[\s\-_.]\d{1,2}[AB]?[\s\-_.]\d{1,2}[AB]?|[A-Z]{1,2}\d[A-Z]?\d{3,4}[AB]?)(?![\dA-Z])/);
    return m ? parseCode(m[0]) : null;
  }
  // Loại file: 'ptg' = bảng tính / phiếu tính giá; 'chican' = hình chỉ căn / vị trí / mặt bằng; 'other'
  function classifyDoc(name, mime) {
    const t = fold(name), m = String(mime || '');
    if (/ chi can | vi tri | mat bang | layout | so do /.test(t)) return 'chican';
    if (/ ptg | phieu tinh | bang tinh | tinh gia | bao gia | dong tien /.test(t)) return 'ptg';
    if (/spreadsheet|excel|sheet/.test(m) || /\.(xlsx?|csv)$/i.test(name)) return 'ptg';
    if (/^image\//.test(m) || /\.(jpe?g|png|webp)$/i.test(name)) return 'chican';
    return 'other';
  }

  /* ---------- SO SÁNH BẢNG CŨ / MỚI CỦA MỘT SÀN ----------
     oldRows: căn hiện có của sàn này trong dự án [{tower, floor, u, price, ...}]
     newRows: căn trong bảng vừa đọc; mode: 'merge' (bổ sung / cập nhật) | 'replace' (thay toàn bộ)
     Trả về {added, changed:[{code, old, new}], same, gone:[{code, old}], result: danh sách căn sau khi lưu} */
  function diffTables(oldRows, newRows, mode) {
    const key = l => codeOf(l.tower, l.floor, l.u);
    const om = new Map(oldRows.map(l => [key(l), l])), nm = new Map();
    newRows.forEach(l => { if (l && l.u) nm.set(key(l), l); });
    const added = [], changed = [], same = [], gone = [];
    for (const [k, n] of nm) { const o = om.get(k); if (!o) added.push({code: k, new: n}); else if (Math.round(o.price) !== Math.round(n.price)) changed.push({code: k, old: o, new: n}); else same.push({code: k, old: o, new: n}); }
    for (const [k, o] of om) if (!nm.has(k)) gone.push({code: k, old: o});
    const result = mode === 'replace' ? [...nm.values()] : [...om.entries()].filter(([k]) => !nm.has(k)).map(([, o]) => o).concat([...nm.values()]);
    return {added, changed, same, gone, removed: mode === 'replace' ? gone.length : 0, result};
  }

  /* ---------- GỘP SÀN CŨ ----------
     Sàn cũ có tên kiểu "Giỏ chéo – Bảng hàng F2 (bảng xanh lá)", "Quỹ độc quyền (bảng cam)", "Giỏ hàng F2 – Mai"… là CÁC LẦN CẬP NHẬT,
     không phải sàn riêng. Đoán đơn vị theo tên gọi; không đoán được thì để trống (người dùng chọn). Phần trong ngoặc / sau dấu – là ghi chú.
     sans: sàn cũ [{id, name, kind, updated, contact, phone}], listings: [{san, project, tower, floor, u, price, ...}]
     units: đơn vị đích (mặc định DEFAULT_UNITS); assign: {idSànCũ: keyĐơnVị} người dùng chọn cho dòng không rõ */
  function legacyNote(name) {
    const s = String(name || ''), par = (s.match(/\(([^)]*)\)/g) || []).map(x => x.slice(1, -1).trim());
    const dash = s.replace(/\([^)]*\)/g, '').split(/\s[–—-]\s/).slice(1).map(x => x.trim());
    return par.concat(dash).filter(Boolean).join(' · ');
  }
  function guessUnit(s, units) {
    if (s.kind === 'cty') return units.find(u => u.kind === 'cty') || null;
    if (s.kind === 'cdt') return units.find(u => u.kind === 'cdt') || null;
    const hit = matchSan([{text: s.name, from: 'tên'}, {text: s.contact, from: 'đầu mối'}], units);
    return hit ? hit.san : null;
  }
  function planMerge(sans, listings, units, assign) {
    units = units || DEFAULT_UNITS; assign = assign || {};
    const rows = sans.map(s => {
      const pick = assign[s.id] ? units.find(u => u.key === assign[s.id]) || null : guessUnit(s, units); // assign '__none' = bỏ đoán, để trống
      // ghi chú = phần trong ngoặc / sau dấu –, bỏ đoạn chỉ là tên đơn vị
      const al = pick ? aliasesOf(pick) : [], note = legacyNote(s.name).split(' · ').filter(x => !al.some(a => fold(x).includes(' ' + a + ' '))).join(' · ');
      return {old: s, unit: pick || null, note, n: listings.filter(l => l.san === s.id).length, by: assign[s.id] ? 'chọn tay' : pick ? 'tự nhận' : ''};
    });
    const unresolved = rows.filter(r => !r.unit && r.n > 0);
    const empty = rows.filter(r => !r.unit && r.n === 0);
    // căn sau gộp: cùng đơn vị + dự án + mã căn → giữ giá của lần cập nhật mới nhất, giá khác lưu lại làm xung đột (không mất)
    const sOf = id => sans.find(s => s.id === id) || {}, upd = id => sOf(id).updated || '';
    const map = new Map(), conflicts = [], keep = [];
    for (const l of listings) {
      const r = rows.find(x => x.old.id === l.san);
      if (!r || !r.unit) { keep.push(l); continue; } // chưa rõ đơn vị: giữ nguyên ở sàn cũ, không mất
      const k = r.unit.key + '|' + l.project + '|' + codeOf(l.tower, l.floor, l.u), cur = map.get(k);
      const nl = Object.assign({}, l, {san: 'u_' + r.unit.key, _from: l.san});
      if (!cur) { map.set(k, nl); continue; }
      const newer = upd(nl._from) >= upd(cur._from) ? nl : cur, older = newer === nl ? cur : nl;
      if (Math.round(cur.price) !== Math.round(nl.price)) conflicts.push({unit: r.unit.name, project: l.project, code: codeOf(l.tower, l.floor, l.u), keep: newer.price, keepFrom: sOf(newer._from).name || '', other: older.price, otherFrom: sOf(older._from).name || ''});
      map.set(k, newer);
    }
    const merged = [...map.values()].map(l => { const o = Object.assign({}, l); delete o._from; return o; }).concat(keep);
    // lịch sử cập nhật mỗi đơn vị = các sàn cũ đã gộp vào
    const hist = {};
    rows.filter(r => r.unit).forEach(r => (hist[r.unit.key] = hist[r.unit.key] || []).push({at: r.old.updated || '', note: r.note || r.old.name, n: r.n, from: r.old.name}));
    Object.values(hist).forEach(h => h.sort((a, b) => String(b.at).localeCompare(String(a.at))));
    const usedUnits = units.filter(u => rows.some(r => r.unit && r.unit.key === u.key));
    return {rows, unresolved, empty, merged, conflicts, hist, usedUnits, before: listings.length, after: merged.length};
  }

  G.BHCore = {fold, KIND_VI, DEFAULT_UNITS, matchSan, searchSans, mentionedProjects, parseCode, splitByCols, codeOf, normF, normU, padF, diffTables, legacyNote, planMerge, unitFromName, classifyDoc};
})(typeof window !== 'undefined' ? window : globalThis);
