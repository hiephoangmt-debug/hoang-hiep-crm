// Thẻ thông tin căn hộ khi chạm vào căn trên mặt bằng tầng (ảnh 360°): mã căn, loại, diện tích, hướng view,
// nút xem layout căn (ảnh CĐT) và mở căn trong trang 4D/5D.
const CSS = `
#ssCard { position: fixed; left: 50%; top: max(84px, calc(env(safe-area-inset-top, 0px) + 74px)); transform: translateX(-50%); z-index: 20; width: min(92vw, 360px);
  background: #fff; color: #0a2540; border-radius: 14px; border-top: 4px solid #ff6a2b; box-shadow: 0 10px 30px #0a254047; padding: 12px 14px; font: 13px Inter, system-ui, sans-serif; }
#ssCard h4 { margin: 0 28px 4px 0; font-size: 17px; }
#ssCard .s { color: #41505f; line-height: 1.5; margin-bottom: 10px; }
#ssCard .lay { display: block; width: 100%; max-height: 42vh; object-fit: contain; background: #fff; border: 1px solid #e6e9ee; border-radius: 10px; margin-bottom: 10px; cursor: zoom-in; }
#ssCard .b { display: flex; gap: 6px; flex-wrap: wrap; }
#ssCard .b a, #ssCard .b button { flex: 1; min-width: 130px; border: 0; border-radius: 10px; padding: 9px 8px; font: 700 13px Inter, sans-serif; cursor: pointer; text-align: center; text-decoration: none; }
#ssCard .o { background: #ff6a2b; color: #fff; } #ssCard .n { background: #0a2540; color: #fff; }
#ssCard .x { position: absolute; right: 8px; top: 6px; border: 0; background: none; font-size: 18px; color: #5d6b7a; cursor: pointer; padding: 2px 6px; }
#ssLay { position: fixed; inset: 0; z-index: 30; background: #0a2540d9; display: grid; place-items: center; padding: 16px; }
#ssLay img { max-width: 100%; max-height: 88vh; background: #fff; border-radius: 10px; }
#ssLay button { position: absolute; top: max(12px, env(safe-area-inset-top, 0px)); right: 12px; border: 0; border-radius: 18px; background: #ff6a2b; color: #fff; font: 700 14px Inter, sans-serif; padding: 7px 12px; cursor: pointer; }
`;
const m2 = (x) => String(x).replace('.', ',');
// ảnh layout căn (thư viện mặt bằng) theo loại + diện tích
function layoutKey(u) {
  if (u.floor >= 30) return null;
  if (u.type === 'STU') return 'c-stu-a';
  if (u.type === 'STUL') return 'c-stu-b';
  if (u.type === '1PN') return 'c-1br-plus';
  if (u.type === '2PN') return u.area[0] >= 69 ? 'c-2br-b' : u.area[0] >= 66 ? 'c-2br-a' : 'c-2br-c';
  return null;
}
let card = null;
export function hideUnitCard() { if (card) card.hidden = true; }
/** u: kết quả pickUnit; opt: { layoutDir, link4d, onClose } */
export function showUnitCard(u, opt) {
  if (!card) {
    const st = document.createElement('style'); st.textContent = CSS; document.head.appendChild(st);
    card = document.createElement('div'); card.id = 'ssCard'; document.body.appendChild(card);
  }
  const lk = layoutKey(u), [tt, tim] = u.area || [];
  card.innerHTML = `<button class="x" aria-label="Đóng">✕</button><h4></h4><div class="s"></div><div class="b"></div>`;
  card.querySelector('h4').textContent = `Căn ${u.code} · ${u.name}`;
  card.querySelector('.s').innerHTML = `<b>Thông thủy ${m2(tt)} m²</b> · tim tường ${m2(tim)} m²${u.balcony ? ' · ban công ' + m2(u.balcony) + ' m²' : ''}<br>`;
  card.querySelector('.s').append(`${u.note ? u.note + ' · ' : ''}view ${u.view} · tầng ${u.floor}`);
  const b = card.querySelector('.b');
  const zoom = (src) => { const ov = document.createElement('div'); ov.id = 'ssLay'; ov.innerHTML = '<button>✕ Đóng</button><img alt="">';
    ov.querySelector('img').src = src; ov.querySelector('img').alt = 'Mặt bằng căn ' + u.code;
    ov.onclick = (e) => { if (e.target === ov || e.target.tagName === 'BUTTON') ov.remove(); }; document.body.appendChild(ov); };
  if (lk) {   // mặt bằng căn hiện ngay trong thẻ; chạm để phóng to
    const im = document.createElement('img'); im.className = 'lay'; im.alt = 'Mặt bằng căn ' + u.code; im.src = opt.layoutDir + lk + '.webp';
    im.onclick = () => zoom(im.src); card.querySelector('.s').after(im);
    const bt = document.createElement('button'); bt.className = 'o'; bt.textContent = '🔍 Phóng to mặt bằng'; bt.onclick = () => zoom(im.src); b.appendChild(bt); }
  if (opt.link4d) { const a = document.createElement('a'); a.className = 'n'; a.target = '_blank'; a.rel = 'noopener';
    a.href = opt.link4d + (opt.link4d.includes('?') ? '&' : '?') + 'in=' + encodeURIComponent(u.id); a.textContent = '🎥 Xem căn trong 4D · 5D'; b.appendChild(a); }
  card.querySelector('.x').onclick = () => { card.hidden = true; opt.onClose?.(); };
  card.hidden = false;
}
