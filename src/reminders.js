import { localDate, upcomingHolidays, dailyTip } from './scripts.js';

export const STATUS_LABEL = {
  moi: 'Mới', dang_cham_soc: 'Đang chăm sóc', quan_tam: 'Quan tâm', hen_xem: 'Hẹn xem nhà',
  dam_phan: 'Đàm phán', da_mua: 'Đã mua', ngung: 'Ngừng',
};

const DAY = 86400000;

function endOfToday(now) {
  return new Date(now.getFullYear(), now.getMonth(), now.getDate(), 23, 59, 59, 999);
}

// Lịch gọi lại mặc định theo kết quả cuộc gọi (nếu người dùng không tự chọn)
export function defaultNextFollowUp(outcome, temperature, settings, now = new Date()) {
  const at = (days, hour) => {
    const d = new Date(now.getFullYear(), now.getMonth(), now.getDate() + days, hour, 0, 0);
    return d.toISOString();
  };
  switch (outcome) {
    case 'khong_nghe': {
      // gọi lại khung giờ khác: sáng -> chiều tối, chiều -> sáng hôm sau
      return now.getHours() < 12 ? at(0, 19) : at(1, 9);
    }
    case 'thue_bao': return at(1, 10);
    case 'quan_tam': return at(2, 9);
    case 'hen_xem': return at(1, 9);
    case 'tu_choi': return at(Number(settings.cadence_lanh || 30) * 2, 9);
    case 'sai_so': return null;
    default: {
      const key = `cadence_${temperature || 'am'}`;
      return at(Number(settings[key] || 7), 9);
    }
  }
}

/**
 * Danh sách việc cần làm hôm nay.
 */
export function buildAgenda(db, settings, now = new Date()) {
  const eod = endOfToday(now).toISOString();
  const nowIso = now.toISOString();
  const sla = Number(settings.sla_minutes || 15);

  const cols = `c.id, c.name, c.salutation, c.phone, c.status, c.temperature, c.need_type, c.need_area,
    c.budget_min, c.budget_max, c.last_contact_at, c.next_follow_up_at, c.next_follow_up_note, c.created_at,
    c.first_source, c.do_not_call,
    (SELECT i.source FROM inquiries i WHERE i.customer_id = c.id ORDER BY i.created_at DESC LIMIT 1) AS last_source,
    (SELECT i.page_url FROM inquiries i WHERE i.customer_id = c.id ORDER BY i.created_at DESC LIMIT 1) AS last_url,
    (SELECT i.created_at FROM inquiries i WHERE i.customer_id = c.id ORDER BY i.created_at DESC LIMIT 1) AS last_inquiry_at`;

  // 1. Lead mới chưa ai gọi
  const newLeads = db.prepare(`SELECT ${cols} FROM customers c
    WHERE c.status = 'moi' AND c.do_not_call = 0
      AND NOT EXISTS (SELECT 1 FROM activities a WHERE a.customer_id = c.id AND a.type <> 'system')
    ORDER BY c.created_at DESC`).all().map((r) => {
    const ageMin = Math.floor((now - new Date(r.last_inquiry_at || r.created_at)) / 60000);
    return { ...r, age_minutes: ageMin, over_sla: ageMin > sla };
  });
  const newIds = new Set(newLeads.map((r) => r.id));

  // 2. Lịch hẹn gọi lại đến hạn / quá hạn
  const followUps = db.prepare(`SELECT ${cols} FROM customers c
    WHERE c.next_follow_up_at IS NOT NULL AND c.next_follow_up_at <= ? AND c.do_not_call = 0 AND c.status <> 'ngung'
    ORDER BY c.next_follow_up_at ASC`).all(eod)
    .filter((r) => !newIds.has(r.id))
    .map((r) => ({ ...r, overdue: r.next_follow_up_at < nowIso && localDate(new Date(r.next_follow_up_at)) < localDate(now) }));
  const seen = new Set([...newIds, ...followUps.map((r) => r.id)]);

  // 3. Khách chưa có lịch hẹn và đã quá nhịp chăm sóc (nóng/ấm/lạnh/đã mua)
  const rewarm = [];
  for (const r of db.prepare(`SELECT ${cols} FROM customers c
      WHERE c.do_not_call = 0 AND c.status NOT IN ('ngung', 'moi')
        AND c.next_follow_up_at IS NULL`).all()) {
    if (seen.has(r.id)) continue;
    const cadence = Number(r.status === 'da_mua' ? settings.cadence_da_mua : settings[`cadence_${r.temperature}`]) || 30;
    const last = new Date(r.last_contact_at || r.created_at);
    const days = Math.floor((now - last) / DAY);
    if (days >= cadence) rewarm.push({ ...r, days_silent: days, cadence });
  }
  rewarm.sort((a, b) => b.days_silent - a.days_silent);

  // 4. Sinh nhật trong 3 ngày tới
  const md = [];
  for (let i = 0; i <= 3; i++) {
    const d = new Date(now.getFullYear(), now.getMonth(), now.getDate() + i);
    md.push(localDate(d).slice(5));
  }
  const birthdays = db.prepare(`SELECT id, name, salutation, phone, birthday FROM customers
    WHERE birthday IS NOT NULL AND birthday <> '' AND do_not_call = 0`).all()
    .filter((r) => md.includes(r.birthday.slice(-5)))
    .map((r) => ({ ...r, in_days: md.indexOf(r.birthday.slice(-5)) }))
    .sort((a, b) => a.in_days - b.in_days);

  // 5. Mời dự án mới
  const projectCalls = db.prepare(`SELECT c.id, c.name, c.salutation, c.phone, c.temperature, p.id AS project_id, p.name AS project_name,
      p.status AS project_status, p.launch_date
    FROM customer_projects cp JOIN customers c ON c.id = cp.customer_id JOIN projects p ON p.id = cp.project_id
    WHERE cp.status = 'can_goi' AND p.status <> 'ngung' AND c.do_not_call = 0
    ORDER BY CASE c.temperature WHEN 'nong' THEN 0 WHEN 'am' THEN 1 ELSE 2 END, p.launch_date`).all();

  const holidays = upcomingHolidays(now, 5);
  const warmCount = db.prepare(`SELECT COUNT(*) AS n FROM customers WHERE do_not_call = 0 AND status <> 'ngung' AND temperature IN ('nong','am')`).get().n;

  const plainRows = (rows) => rows.map((r) => ({ ...r }));
  return {
    generated_at: nowIso,
    tip: dailyTip(now),
    sla_minutes: sla,
    new_leads: plainRows(newLeads),
    follow_ups: plainRows(followUps),
    rewarm: plainRows(rewarm.slice(0, 30)),
    rewarm_total: rewarm.length,
    birthdays: plainRows(birthdays),
    project_calls: plainRows(projectCalls),
    holidays: holidays.map((h) => ({ ...h, warm_customers: warmCount })),
  };
}

/** Khách phù hợp với một dự án (loại hình, khu vực, ngân sách) */
export function matchCustomersForProject(db, project) {
  const rows = db.prepare(`SELECT c.*, cp.status AS invite_status FROM customers c
    LEFT JOIN customer_projects cp ON cp.customer_id = c.id AND cp.project_id = ?
    WHERE c.do_not_call = 0 AND c.notify_new_projects = 1 AND c.status <> 'ngung'`).all(project.id);
  const norm = (s) => (s || '').toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g, '').replace(/đ/g, 'd');
  const out = [];
  for (const c of rows) {
    let score = 0;
    const reasons = [];
    if (project.type && c.need_type) {
      if (norm(c.need_type) === norm(project.type)) { score += 3; reasons.push('đúng loại hình'); } else continue;
    }
    if (project.area && c.need_area) {
      const a = norm(project.area), b = norm(c.need_area);
      if (a.includes(b) || b.includes(a)) { score += 2; reasons.push('đúng khu vực'); }
    }
    if (project.price_from != null && (c.budget_max != null || c.budget_min != null)) {
      const max = c.budget_max ?? c.budget_min;
      const min = c.budget_min ?? c.budget_max;
      const pTo = project.price_to ?? project.price_from;
      if (max * 1.15 >= project.price_from && min <= pTo * 1.15) { score += 2; reasons.push('vừa ngân sách'); } else score -= 2;
    }
    if (c.temperature === 'nong') score += 1;
    if (c.status === 'da_mua') reasons.push('khách cũ đã mua');
    if (score < 0) continue;
    out.push({ ...c, score, reasons });
  }
  return out.sort((a, b) => b.score - a.score);
}
