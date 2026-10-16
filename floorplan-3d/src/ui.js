// Tiện ích giao diện dùng chung: thông báo, hộp thoại trong trang, tải file
const $ = (s) => document.querySelector(s);

/** Hộp thoại trong trang (thay cho confirm/prompt vốn bị chặn trong khung nhúng) */
export function ask(message, { input = null, inputs = null, ok = 'Đồng ý', cancel = 'Huỷ' } = {}) {
  // inputs: [{ label, value, placeholder }] → trả về mảng giá trị; input: một ô → trả về chuỗi
  const fields = inputs || (input !== null ? [{ label: '', value: input }] : []);
  return new Promise((resolve) => {
    const wrap = document.createElement('div');
    wrap.className = 'modal';
    wrap.innerHTML = `<form class="sheet dialog"><p></p>${fields.map((f, i) => `<label class="askfield"><span></span><input type="text" id="askInput${i}" inputmode="decimal" /></label>`).join('')}
      <div class="btnrow"><button type="button" data-r="cancel">${cancel}</button><button type="submit" class="primary">${ok}</button></div></form>`;
    wrap.querySelector('p').textContent = message;
    const inps = [...wrap.querySelectorAll('input')];
    inps.forEach((inp, i) => { inp.value = fields[i].value ?? ''; inp.placeholder = fields[i].placeholder || ''; inp.previousElementSibling.textContent = fields[i].label; });
    const value = () => (inputs ? inps.map((x) => x.value) : inps.length ? inps[0].value : true);
    const done = (v) => { wrap.remove(); resolve(v); };
    wrap.querySelector('form').onsubmit = (e) => { e.preventDefault(); done(value()); };
    wrap.querySelector('[data-r="cancel"]').onclick = () => done(fields.length ? null : false);
    wrap.onkeydown = (e) => { if (e.key === 'Escape') done(fields.length ? null : false); };
    document.body.appendChild(wrap);
    (inps[0] || wrap.querySelector('[type=submit]')).focus();
    inps[0]?.select();
  });
}


export function toast(msg, ms = 2600) {
  const t = $('#toast');
  t.textContent = msg;
  t.classList.add('show');
  clearTimeout(toast._t);
  toast._t = setTimeout(() => t.classList.remove('show'), ms);
}

export function download(blob, name) {
  const a = document.createElement('a');
  a.href = URL.createObjectURL(blob);
  a.download = name;
  a.click();
  setTimeout(() => URL.revokeObjectURL(a.href), 2000);
}

/** Chế độ xem cho khách (link có ?khach): khoá mọi chức năng chỉnh sửa, ẩn giá / trạng thái / công cụ nội bộ */
export const READONLY = new URLSearchParams(location.search).has('khach');
/** Giữ ?khach khi chuyển trang */
export const linkTo = (page) => (READONLY ? `./${page}?khach` : `./${page}`);
if (READONLY) document.documentElement.classList.add('readonly');

// Sau mỗi lần cập nhật web, tên các file phần mềm đổi: trang đang mở từ trước sẽ không tải được phần
// lazy (vd. "Chụp ảnh như thật") → tự tải lại trang một lần để lấy bản mới
const STALE_KEY = 'floorplan3d.staleReload';
export function isStaleChunkError(err) {
  return /dynamically imported module|Importing a module script failed|error loading dynamically imported module|Failed to fetch/i.test(String(err?.message || err));
}
export function reloadForUpdate() {
  try { if (sessionStorage.getItem(STALE_KEY) && Date.now() - +sessionStorage.getItem(STALE_KEY) < 60000) return false; sessionStorage.setItem(STALE_KEY, String(Date.now())); } catch { /* bỏ qua */ }
  toast('Web vừa được cập nhật bản mới – đang tải lại trang…', 3000);
  setTimeout(() => location.reload(), 900);
  return true;
}
window.addEventListener('vite:preloadError', (e) => { e.preventDefault?.(); reloadForUpdate(); });
window.addEventListener('unhandledrejection', (e) => { if (isStaleChunkError(e.reason)) reloadForUpdate(); });
