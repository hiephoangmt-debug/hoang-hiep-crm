// ===== PHẦN 2/3: Xử lý tin nhắn & lead (dán vào file Phan2.gs) =====
// ---------- Từ landing / khung chat ----------
function handleWidget_(b) {
  const v = String(b.v || '');
  if (!ID_RE.test(v)) return { ok: false, error: 'Thiếu mã khách' };
  const cache = CacheService.getScriptCache();
  const hits = Number(cache.get('rl_' + v) || 0);
  if (hits > 40) return { ok: false, error: 'Gửi quá nhiều, thử lại sau' };
  cache.put('rl_' + v, String(hits + 1), 600);

  const type = String(b.type || '');
  const transcript = Array.isArray(b.transcript) ? b.transcript.slice(-8) : [];
  const page = clean_(b.page, 300), utm = clean_(b.utm, 200);

  if (type === 'message') {
    const text = clean_(b.text);
    if (!text) return { ok: false };
    sheet_('Chat').appendRow([now_(), v, 'Khách', text]);
    const key = 'n_' + v;
    if (b.first || !cache.get(key)) {
      cache.put(key, '1', QUIET_MS / 1000);
      notify_(v, (b.first ? '🔔 <b>KHÁCH MỚI VÀO CHAT</b>' : '💬 <b>Tin nhắn mới</b>') + who_(b) + where_(page, utm) + '\n──────────\n\n' + transcript_(transcript, text));
    }
    return { ok: true };
  }

  if (type === 'lead') {
    const phone = clean_(b.phone, 20).replace(/[\s.-]/g, '');
    if (!/^(\+?84|0)\d{9}$/.test(phone)) return { ok: false, error: 'Số điện thoại chưa đúng' };
    const name = clean_(b.name, 100), need = clean_(b.need, 120), form = clean_(b.form, 60);
    sheet_('Lead').appendRow([now_(), name, "'" + phone, need, form, utm, page, v]);
    notify_(v, '🔥 <b>CÓ SỐ ĐIỆN THOẠI KHÁCH</b>\n👤 ' + esc_(name || '(chưa có tên)') + '\n📞 <b>' + esc_(phone) + '</b>' +
      (need ? '\n📝 ' + esc_(need) : '') + (form ? '\n🧾 ' + esc_(form) : '') + where_(page, utm) +
      (transcript.length ? '\n──────────\n\n' + transcript_(transcript) : '') + '\n\nGọi lại ngay: tel:' + esc_(phone));
    return { ok: true };
  }

  if (type === 'browse') {
    notify_(v, '👀 <b>KHÁCH ĐANG ĐỌC KỸ: ' + esc_(clean_(b.topic, 80).toUpperCase()) + '</b>' + where_(page, utm) +
      '\n──────────\n\n🤖 <b>TƯ VẤN (tự động)</b> đã hỏi:\n' + esc_(clean_(b.question, 500)));
    return { ok: true };
  }
  return { ok: false, error: 'Loại không hợp lệ' };
}

function who_(b) { return b.name || b.phone ? '\n👤 ' + esc_(b.name || '') + (b.phone ? ' – ' + esc_(b.phone) : '') : ''; }
function where_(page, utm) { return (utm ? '\n📣 ' + esc_(utm) : '') + (page ? '\n🌐 ' + esc_(page) : ''); }

// Hội thoại gần nhất, tách lượt KHÁCH / TƯ VẤN, mỗi lượt cách 1 dòng
function transcript_(list, extra) {
  const items = list.slice();
  if (extra && !(items.length && items[items.length - 1].text === extra)) items.push({ from: 'visitor', text: extra });
  const LABEL = { visitor: '🙋 <b>KHÁCH</b>', agent: '💼 <b>TƯ VẤN</b>', auto: '🤖 <b>TƯ VẤN (tự động)</b>' };
  const groups = [];
  items.forEach(function (m) {
    const k = m.from === 'visitor' ? 'visitor' : (m.auto ? 'auto' : 'agent');
    const t = String(m.text || '').slice(0, 300);
    const g = groups[groups.length - 1];
    if (g && g.k === k) g.lines.push(t); else groups.push({ k: k, lines: [t] });
  });
  const out = groups.map(function (g) { return LABEL[g.k] + '\n' + g.lines.map(esc_).join('\n'); }).join('\n\n');
  return out.length > 3000 ? '…' + out.slice(-3000) : out;
}

