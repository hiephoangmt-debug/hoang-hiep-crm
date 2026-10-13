/* ---------- Danh sách khách sự kiện (để in & check-in) ----------
 * File thêm vào dự án Apps Script "CRM - Cổng nhận khách" (cùng dự án với file Mã.gs).
 * Mỗi lần đồng bộ báo cáo, bảng tính "CRM - Báo cáo khách sự kiện" có thêm 1 tab "DS <tên sự kiện>" cho từng sự kiện:
 *   - CHỈ gồm những sale đã nhập khách (bỏ hết các báo cáo "Chưa có khách").
 *   - Mỗi sale lấy báo cáo MỚI NHẤT của sự kiện đó (báo cáo hằng ngày không bị lặp khách).
 *   - Có cột CHECK-IN (ô tích + số người thực tế đi cùng) và cột đánh giá; những gì nhập tay ở các cột này
 *     được giữ lại qua các lần đồng bộ sau.
 * Tab "Báo cáo" (nhật ký đầy đủ mọi lần gửi) giữ nguyên như cũ.
 */
const DS_HEAD = ['STT', 'Phòng', 'Sale', 'Tên khách', 'Mức quan tâm', 'Tình trạng', 'SL đăng ký', 'Tình hình / Ghi chú sale', 'Báo cáo gần nhất',
  'CHECK-IN\nĐã đến', 'CHECK-IN\nSố người thực tế\n(đầu khách + người đi cùng)', 'Đánh giá hiệu quả & đề xuất chăm khách', 'Mã'];
const DS_KEEP = [9, 10, 11]; // cột (0-based) nhập tay tại sự kiện: Đã đến, Số người thực tế, Đánh giá
const DS_KEY = 12;           // cột mã (ẩn) = eventId|staffId, dùng để giữ lại dữ liệu check-in

/** Ghi các tab "DS ..." vào bảng tính ss. Gọi từ dongBoBaoCaoSuKien. */
function dongBoDanhSachKhach_(ss) {
  const mem = {}, ev = {};
  listAll_('members').forEach(m => mem[m.id] = m.f);
  listAll_('events').forEach(e => ev[e.id] = e.f);
  const dmy = d => { const p = String(d || '').split('-'); return p.length === 3 ? p[2] + '/' + p[1] + '/' + p[0] : (d || ''); };

  // Báo cáo mới nhất của từng sale cho từng sự kiện.
  const latest = {};
  listAll_('eventReports').map(x => x.f).filter(r => r.eventId && r.date && r.staffId).forEach(r => {
    const k = r.eventId + '|' + r.staffId, o = latest[k];
    if (!o || r.date > o.date || (r.date === o.date && (Number(r.ts) || 0) > (Number(o.ts) || 0))) latest[k] = r;
  });

  const byEvent = {};
  Object.keys(latest).forEach(k => { const r = latest[k]; (byEvent[r.eventId] = byEvent[r.eventId] || []).push(r); });

  Object.keys(byEvent).forEach(eventId => {
    const e = ev[eventId] || {};
    const list = byEvent[eventId]
      .filter(r => r.status !== 'none' && String(r.guests || '').trim())
      .map(r => ({ r: r, m: mem[r.staffId] || {} }))
      .sort((a, b) => (a.r.team || a.m.team || '').localeCompare(b.r.team || b.m.team || '') || (a.m.name || a.r.staffId).localeCompare(b.m.name || b.r.staffId));

    const title = 'DS ' + String(e.name || eventId).replace(/[:\\\/?*\[\]]/g, '-').slice(0, 90);
    let sh = ss.getSheetByName(title);

    // Giữ lại dữ liệu check-in / đánh giá đã nhập tay.
    const kept = {};
    if (sh && sh.getLastRow() >= 4) {
      sh.getRange(4, 1, sh.getLastRow() - 3, DS_HEAD.length).getValues().forEach(v => {
        if (v[DS_KEY]) kept[v[DS_KEY]] = v;
      });
    }
    if (!list.length && !Object.keys(kept).length) return; // sự kiện chưa có khách nào → không tạo tab

    const rows = list.map((x, i) => {
      const r = x.r, key = eventId + '|' + r.staffId, old = kept[key];
      delete kept[key];
      return [i + 1, r.team || x.m.team || '', x.m.name || r.staffId, r.guests || '', EVREP_INT[r.interest] || '', EVREP_ST[r.status] || r.status || '',
        Number(r.people) || '', r.note || '', dmy(r.date), old ? old[9] === true : false, old ? old[10] : '', old ? old[11] : '', key];
    });
    // Khách đã check-in nhưng báo cáo mới nhất của sale không còn khách → vẫn giữ dòng để không mất dữ liệu.
    Object.keys(kept).forEach(key => {
      const v = kept[key];
      if (v[9] === true || v[10] !== '' || v[11] !== '') {
        v[0] = rows.length + 1; v[5] = 'Không còn trong báo cáo mới nhất'; rows.push(v);
      }
    });

    if (!sh) sh = ss.insertSheet(title);
    sh.getRange(1, 1, Math.max(sh.getMaxRows(), 1), Math.max(sh.getMaxColumns(), DS_HEAD.length)).clearDataValidations();
    sh.clear();
    const place = e.place || e.location || e.address || '';
    sh.getRange(1, 1).setValue('DANH SÁCH KHÁCH SỰ KIỆN: ' + (e.name || eventId) + (e.date ? ' – NGÀY ' + dmy(e.date) : '') + (place ? ' – ' + place : ''))
      .setFontWeight('bold').setFontSize(13);
    const n = rows.length, last = 3 + Math.max(n, 1);
    sh.getRange(2, 1, 1, 8).setValues([[
      'Số khách:', n, 'SL đăng ký:', '=SUM(G4:G' + last + ')', 'Đã check-in:', '=COUNTIF(J4:J' + last + ',TRUE)', 'Số người thực tế:', '=SUM(K4:K' + last + ')']])
      .setFontWeight('bold');
    sh.getRange(3, 1, 1, DS_HEAD.length).setValues([DS_HEAD]).setFontWeight('bold').setBackground('#f3e6c8').setWrap(true).setVerticalAlignment('middle');
    if (n) {
      sh.getRange(4, 1, n, DS_HEAD.length).setValues(rows).setVerticalAlignment('top');
      sh.getRange(4, 10, n, 1).insertCheckboxes();
      sh.getRange(4, 8, n, 1).setWrap(true);
      sh.getRange(4, 12, n, 1).setWrap(true);
      sh.getRange(3, 1, n + 1, DS_HEAD.length - 1).setBorder(true, true, true, true, true, true);
    }
    sh.setFrozenRows(3);
    [45, 120, 140, 140, 110, 140, 70, 260, 90, 70, 120, 240].forEach((w, i) => sh.setColumnWidth(i + 1, w));
    sh.hideColumns(DS_KEY + 1);
  });
}
