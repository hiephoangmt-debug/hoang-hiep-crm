import { firebaseConfig, OWNER_EMAIL } from './firebase-config.js';
import { SAPHIA_LIB, SAPHIA_CONTENT } from './content-saphia.js';

const FB = 'https://www.gstatic.com/firebasejs/10.12.2/';
const CONFIGURED = !!(firebaseConfig && firebaseConfig.apiKey && !String(firebaseConfig.apiKey).startsWith('DIEN_'));

const STAGES = [{k:'new',l:'Mới'},{k:'care',l:'Đang chăm sóc'},{k:'visit',l:'Hẹn gặp / xem nhà'},{k:'deposit',l:'Đã booking / cọc'},{k:'contract',l:'Ký HĐMB'},{k:'lost',l:'Ngừng'}];
const OPEN = ['new','care','visit','deposit'];
const ACTS = [{k:'call',l:'Gọi điện / Zalo'},{k:'visit',l:'Mời khách / site tour / xem nhà mẫu'},{k:'event',l:'Đưa khách dự sự kiện'},{k:'deposit',l:'Booking / đặt cọc'},{k:'contract',l:'Ký HĐMB (deal)'},{k:'note',l:'Ghi chú'}];
// Hoạt động truyền thông của sale (không gắn khách) — tính điểm KPI quý.
const WORK = [{k:'video',l:'Video + hashtag'},{k:'post',l:'Bài content / hình ảnh tự tạo + hashtag'},{k:'live',l:'Livestream (Facebook, TikTok…)'}];
const SUN = /\bsun\b|fours|symphony|cosmo|ponte|s-?light/i; // dự án Sun Group (chỉ tiêu 1 giao dịch Sun / tháng)
const EVENT_FINE = 50000; // phạt mỗi sự kiện không có khách, lũy tiến theo số lần liên tiếp
const DEAL_REWARD = 200000; // thưởng từ quỹ đội cho mỗi giao dịch (= khách đặt cọc, mỗi khách 1 lần)
const PLAN_START = '2026-10-05'; // bắt đầu tính thưởng / quỹ đội
// Bảng KPI theo bậc của công ty: deal tính khi Ký HĐMB; Casa = dự án Casamia; giỏ chéo do sale đánh dấu khi ghi nhận deal.
const LEVELS = {
  rookie:{l:'Rookie Sales', salary:'Lương cơ bản 4.800.000 + BHXH', quota:2, pts:{normal:30, casa:60, cross:20}, grades:[
    {min:90, k:'ok', l:'Xuất sắc', act:'Nâng bậc lên Elite Sales', to:'elite'},
    {min:70, k:'run', l:'Giỏi', act:'Giữ bậc'},
    {min:45, k:'warn', l:'Trung bình', act:'Xem xét đề nghị của Quản lý trực tiếp'},
    {min:0, k:'bad', l:'Yếu', act:'Nghỉ việc'}]},
  elite:{l:'Elite Sales', salary:'Lương cơ bản 5.500.000 + BHXH', quota:3, pts:{normal:20, casa:40, cross:15}, grades:[
    {min:90, k:'ok', l:'Xuất sắc', act:'Nâng bậc lên Pro Sales', to:'pro'},
    {min:70, k:'run', l:'Giỏi', act:'Giữ bậc'},
    {min:0, k:'bad', l:'Trung bình', act:'Hạ bậc xuống Rookie Sales, quý tiếp theo đạt Xuất sắc lên lại bậc', to:'rookie'}]},
  pro:{l:'Pro Sales', salary:'Lương cơ bản 5.500.000 + lương hiệu suất 1.500.000 + BHXH', quota:4, pts:{normal:15, casa:30, cross:12}, grades:[
    {min:90, k:'ok', l:'Xuất sắc', act:'Thưởng 20 triệu ngay sau khi đánh giá quý'},
    {min:80, k:'run', l:'Giỏi', act:'Thưởng 15 triệu ngay sau khi đánh giá quý'},
    {min:70, k:'run', l:'Khá', act:'Thưởng 5 triệu ngay sau khi đánh giá quý'},
    {min:0, k:'bad', l:'Trung bình', act:'Hạ bậc xuống Elite Sales, quý tiếp theo đạt Xuất sắc nâng lại bậc', to:'elite'}]},
  // TẠM dùng chỉ tiêu như Pro Sales – thay bằng chỉ tiêu Trưởng phòng khi công ty chốt (lương, deal/quý, điểm, xếp loại).
  tpkd:{l:'Trưởng phòng kinh doanh', salary:'Cấp quản lý – không tính KPI cá nhân, theo dõi KPI của phòng', quota:4, pts:{normal:15, casa:30, cross:12}, grades:[
    {min:90, k:'ok', l:'Xuất sắc', act:'Theo chính sách Trưởng phòng (chờ cập nhật)'},
    {min:70, k:'run', l:'Đạt', act:'Theo chính sách Trưởng phòng (chờ cập nhật)'},
    {min:0, k:'bad', l:'Chưa đạt', act:'Theo chính sách Trưởng phòng (chờ cập nhật)'}]}
};
const CASA = /casa/i;
const SOURCES = ['Website / LadiPage','Facebook Ads','Google / Website','Zalo','Giới thiệu','Sự kiện','Data cũ','Khác'];
const ROLES = [{k:'sale',l:'Sale'},{k:'lead',l:'Trưởng nhóm'},{k:'gd',l:'Giám đốc'},{k:'bh',l:'Admin bảng hàng'},{k:'admin',l:'Quản trị'}];
const isBoss = s => s.role === 'admin' || s.role === 'gd'; // Ban giám đốc: không tính KPI cá nhân trừ khi bật "Tính KPI"
const METRICS = [{k:'calls',l:'Cuộc gọi'},{k:'visits',l:'Mời khách / site tour'},{k:'events',l:'Khách dự sự kiện'},{k:'videos',l:'Video'},{k:'posts',l:'Bài content'},{k:'lives',l:'Livestream'},{k:'sunDeals',l:'GD dự án Sun'},{k:'contracts',l:'Deal (HĐMB)'},{k:'newLeads',l:'Khách mới'},{k:'deposits',l:'Booking / cọc'},{k:'revenue',l:'Doanh số (tỷ)'}];
const PERIODS = [{k:'day',l:'Ngày'},{k:'week',l:'Tuần'},{k:'month',l:'Tháng'},{k:'quarter',l:'Quý'}];
// Chỉ tiêu theo bảng KPI công ty; deal quý lấy theo bậc (Rookie 2, Elite 3, Pro 4). 0 = không đặt chỉ tiêu.
const Z = {calls:0,newLeads:0,visits:0,events:0,videos:0,posts:0,lives:0,sunDeals:0,deposits:0,contracts:0,revenue:0};
// Kế hoạch đội 10/2026: telesale 30 cuộc/ngày, livestream 1 lần/tuần, 1 giao dịch dự án Sun/tháng.
const DEF_T = {
  day:{...Z, calls:30},
  week:{...Z, visits:2, videos:2, posts:3, lives:1},
  month:{...Z, visits:8, videos:8, posts:12, lives:4, sunDeals:1},
  quarter:{...Z, visits:24, videos:24, posts:36, sunDeals:3}
};
const SAMPLE_PROJECTS = [
  {name:'Sun FourS Tower',location:'Đà Nẵng',developer:'Sun Group',type:'Căn hộ',status:'Đang bán',note:'',order:1},
  {name:'Casamia Balanca',location:'Hội An, Đà Nẵng',developer:'',type:'BĐS ở',status:'Đang bán',note:'',order:2},
  {name:'Sun Symphony Residence',location:'Sơn Trà, bờ Đông sông Hàn',developer:'Sun Group',type:'Căn hộ, nhà phố',status:'Đang bán',note:'',order:3},
  {name:'Sun Cosmo Residence',location:'Đà Nẵng',developer:'Sun Group',type:'Căn hộ',status:'Đang bán',note:'',order:4},
  {name:'Sun Ponte Residence',location:'Sơn Trà, cạnh cầu Rồng',developer:'Sun Group',type:'Căn hộ',status:'Đang bán',note:'',order:5},
  {name:'Sun Saphia Residence',location:'Ven biển Đà Nẵng',developer:'Sun Group (Sun Property)',type:'Căn hộ',status:'Sắp mở bán',note:'',order:6}
];
const COLD_DAYS = 7;
// Trợ lý AI: gọi qua cổng Apps Script (mã khoá AI nằm ở đó, không ở trình duyệt).
const CHAT_URL = 'https://script.google.com/macros/s/AKfycbzOsX6tHZmXEDAdVLZY__hrAeCVslIyG2eFpYZ2Q-lEptukacOW6r7VSvlButoyOrZY/exec?action=chat';
// Phải khớp ACCEPT_MINUTES / REPORT_DAYS trong lead-webhook/Code.gs (cổng tự thu hồi và chuyển sale).
const ACCEPT_MIN = 20, REPORT_DAYS = 3, REPORT_STAGES = ['new','care','visit'];
const VIEWS = ['tong-quan','khach-hang','ke-hoach','kpi','doi-sale','du-an','content-tuan','huong-dan','quan-tri','tai-khoan'];
const BH_DEADLINE = '08:30'; // bảng hàng phải cập nhật trước giờ này mỗi ngày

const S = {contents:[], projects:[],staff:[],customers:[],activities:[],tasks:[],kpi:{},scores:{},ann:[],bh:[],bhPriv:[],sold:[],events:[],evReports:[],focus:{}};
const UI = {view:'tong-quan',q:'',fStaff:'',fProj:'',fStage:'open',kp:'month',ko:0,tStaff:'',kmode:'score',qo:0,fTeam:''};
let store = null, ME = null, MANAGER = false, ADMIN = false, BH = false, unsubs = [], installEvt = null; // BH: được cập nhật bảng hàng (Quản trị + Giám đốc)

/* ---------- helpers ---------- */
const $ = s => document.querySelector(s);
const esc = s => String(s ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
const pad = n => String(n).padStart(2,'0');
const ymd = d => d.getFullYear()+'-'+pad(d.getMonth()+1)+'-'+pad(d.getDate());
const pd = s => { const [y,m,d] = String(s).split('-').map(Number); return new Date(y,m-1,d); };
const today = () => ymd(new Date());
const addD = (s,n) => { const d = pd(s); d.setDate(d.getDate()+n); return ymd(d); };
const diffD = (a,b) => Math.round((pd(b)-pd(a))/864e5);
const dm = s => s ? pad(pd(s).getDate())+'/'+pad(pd(s).getMonth()+1) : '—';
const DOW = ['Chủ nhật','Thứ 2','Thứ 3','Thứ 4','Thứ 5','Thứ 6','Thứ 7'];
const fmt = n => (Number(n)||0).toLocaleString('vi-VN',{maximumFractionDigits:2});
const stageL = k => (STAGES.find(x=>x.k===k)||{l:k}).l;
const actL = k => (ACTS.concat(WORK).find(x=>x.k===k)||{l:k}).l;
const phoneKeyOf = p => { let d = String(p || '').replace(/\D/g, ''); if (d.startsWith('84') && d.length >= 11) d = '0' + d.slice(2); return d; };
const zaloUrl = p => { const k = phoneKeyOf(p); return k.length >= 9 ? 'https://zalo.me/' + k : ''; };
const zaloA = (p, label) => { const u = zaloUrl(p); return u ? `<a class="zl" href="${u}" target="_blank" rel="noopener">${label || 'Zalo'}</a>` : ''; };
const nowStamp = () => { const d = new Date(); return pad(d.getDate())+'/'+pad(d.getMonth()+1)+' '+pad(d.getHours())+':'+pad(d.getMinutes()); };
const logAdd = (old, line) => ((old ? old + '\n' : '') + nowStamp() + ' ' + line).slice(-3000);
const minsLeft = c => Math.max(0, Math.ceil(((c.assignDeadline || 0) - Date.now()) / 60000));
const reportDue = c => c.assignStatus === 'accepted' && REPORT_STAGES.includes(c.stage) ? Math.max(c.lastReportAt || 0, c.acceptedAt || 0) + REPORT_DAYS*864e5 : 0;
/* Thông báo dự án: trạng thái đã đọc lưu trên máy từng người. */
const annActive = () => S.ann.filter(a => !a.until || a.until >= today());
const annKey = () => 'crm-ann-read-' + (ME ? ME.email : '');
const annRead = () => { try { return new Set(JSON.parse(localStorage.getItem(annKey()) || '[]')); } catch(e) { return new Set(); } };
const annMarkRead = ids => { const s = annRead(); ids.forEach(i => s.add(i)); try { localStorage.setItem(annKey(), JSON.stringify([...s].slice(-300))); } catch(e) {} };
const annUnread = () => { const r = annRead(); return annActive().filter(a => !r.has(a.id)); };
/* Sự kiện: khách tham dự = hoạt động "event" gắn eventId; phạt lũy tiến theo số sự kiện liên tiếp không có khách. */
const evGuests = (evId, staffId) => S.activities.filter(a => a.type === 'event' && a.eventId === evId && (!staffId || a.staffId === staffId)).length;
const nextEvent = () => S.events.find(e => e.date >= today());
/* Báo cáo khách sự kiện hằng ngày: mỗi sale gửi 1 báo cáo / ngày trước giờ hạn → eventReports/{eventId}_{ngày}_{email}. */
const repEvent = () => S.events.find(e => e.dailyReport && e.date >= today());
const repBy = e => e.reportBy || '17:00';
const evRep = (evId, date, staffId) => S.evReports.find(r => r.eventId === evId && r.date === date && r.staffId === staffId);
const lastRep = (evId, staffId) => S.evReports.filter(r => r.eventId === evId && r.staffId === staffId).sort((a,b) => (b.date||'').localeCompare(a.date||''))[0];
const REP_ST = [{v:'none',l:'Chưa có khách'},{v:'inviting',l:'Đang mời – khách chưa chốt'},{v:'yes',l:'Đã có khách xác nhận đi'}];
const REP_INT = [{v:'hot',l:'Rất quan tâm – có thể chốt tại sự kiện'},{v:'warm',l:'Quan tâm – cần tư vấn thêm'},{v:'cool',l:'Đang cân nhắc'},{v:'unk',l:'Chưa rõ'}];
const repL = (arr, v) => (arr.find(x => x.v === v) || {}).l || '';
function repLine(r){ if (!r) return 'CHƯA BÁO CÁO'; if (r.status === 'none') return 'Chưa có khách' + (r.note ? ' – ' + r.note : '');
  return repL(REP_ST, r.status).split(' – ')[0] + ': ' + (r.guests || '(chưa ghi tên)') + (r.people ? ' – đi ' + r.people + ' người' : '') + (r.interest ? ' – ' + repL(REP_INT, r.interest).split(' – ')[0] : '') + (r.note ? ' – ' + r.note : ''); }
// Ai xem báo cáo của ai: Quản trị + Giám đốc xem cả công ty; Trưởng phòng chỉ xem phòng mình; sale chỉ xem của mình.
const repAll = () => ME.owner || ME.role === 'admin' || ME.role === 'gd';
// Người phải báo cáo khách sự kiện: sale + trưởng phòng (cấp Trưởng phòng không tính KPI nhưng vẫn mời khách và báo cáo).
// Bỏ riêng từng người bằng ô "Không phải báo cáo khách sự kiện" (noEvRep) ở form thành viên.
const NO_EV_REP = ['huỳnh tấn thắng']; // bỏ hẳn khỏi báo cáo khách sự kiện (so theo họ tên, không phân biệt hoa thường)
const skipEvRep = s => s.noEvRep || NO_EV_REP.includes(String(s.name || '').normalize('NFC').trim().toLowerCase().replace(/\s+/g, ' '));
const reporters = () => S.staff.filter(s => s.active !== false && !skipEvRep(s) && (sellers().includes(s) || s.level === 'tpkd' || s.role === 'lead')).sort((a,b)=>(a.name||'').localeCompare(b.name||'','vi'));
const meReporter = () => reporters().some(s => s.id === ME.email);
const repSellers = () => (repAll() ? reporters() : reporters().filter(s => s.id === ME.email || (ME.role === 'lead' && ME.team && s.team === ME.team)))
  .sort((a,b) => (a.team||'').localeCompare(b.team||'','vi') || (a.name||'').localeCompare(b.name||'','vi'));
function repSummary(e, date){ const sl = repSellers(), rs = sl.map(s => ({s, r: evRep(e.id, date, s.id)}));
  const sent = rs.filter(x => x.r).length, has = rs.filter(x => x.r && x.r.status === 'yes').length, ppl = rs.reduce((a,x) => a + (x.r && x.r.status !== 'none' ? Number(x.r.people) || 0 : 0), 0);
  return {rs, sent, has, ppl, n: sl.length}; }
const vnd = n => (Number(n) || 0).toLocaleString('vi-VN') + 'đ';
function eventFines(){
  const t = today(), past = S.events.filter(e => e.date && e.date < t && e.needGuest !== false), res = {};
  visibleSellers().forEach(s => { let streak = 0, total = 0; const hist = [];
    past.forEach(e => { if (evGuests(e.id, s.id) >= (Number(e.minGuests) || 1)) streak = 0; else { streak++; const f = (Number(e.fine) || EVENT_FINE) * streak; total += f; hist.push({e, f, streak}); } });
    res[s.id] = {streak, total, hist, next: EVENT_FINE * (streak + 1)}; });
  return res;
}
/* Thưởng giao dịch: mỗi khách đặt cọc trong khoảng ngày = 1 giao dịch (một khách chỉ tính 1 lần, theo ngày cọc đầu tiên). */
function dealsOf(staffId, from, to){
  const first = {};
  S.activities.filter(a => a.type === 'deposit' && a.date && a.date >= PLAN_START && (!staffId || a.staffId === staffId))
    .forEach(a => { const k = a.customerId || a.id; if (!first[k] || a.date < first[k].date) first[k] = a; });
  return Object.values(first).filter(a => a.date >= from && a.date <= to);
}
function teamFund(){
  const ef = eventFines(), fines = Object.values(ef).reduce((s, x) => s + (x.total || 0), 0);
  const rewards = dealsOf(null, PLAN_START, '9999-12-31').filter(a => visibleSellers().some(s => s.id === a.staffId)).length * DEAL_REWARD;
  return {fines, rewards, balance: fines - rewards};
}
/* Mã căn chạy chung mỗi ngày: sale đăng lúc 9h và 15h (ghi nhận = bài đăng có slot). */
const focusToday = () => S.focus[today()];
const nowHM = () => { const d = new Date(); return pad(d.getHours()) + ':' + pad(d.getMinutes()); };
const SLOTS = [{k:'9h', at:'09:00'}, {k:'15h', at:'15:00'}];
const slotDone = (slot, sid) => S.activities.some(a => a.type === 'post' && a.date === today() && a.slot === slot && a.staffId === sid);
const meSeller = () => sellers().some(s => s.id === ME.email);
const recentSold = (days = 3) => S.sold.filter(x => (x.at || 0) >= Date.now() - days*864e5);
const hhmm = iso => { const d = new Date(iso); return isNaN(d) ? '' : pad(d.getHours()) + ':' + pad(d.getMinutes()); };
/* Tình trạng bảng hàng từng dự án (đọc từ bangHang/p_<dự án>, trang Bảng hàng ghi). */
function bhStatus(){
  const t = today(), now = new Date(), late = pad(now.getHours()) + ':' + pad(now.getMinutes()) >= BH_DEADLINE;
  return S.bh.filter(d => d.id.startsWith('p_')).map(d => { let n = 0; try { n = (JSON.parse(d.json || '{}').listings || []).length; } catch(e) {}
    const up = d.updated ? ymd(new Date(d.updated)) : '';
    return {pid: d.id.slice(2), name: projName(d.id.slice(2)), n, up, upAt: d.updated || '', fresh: up === t, late}; }).filter(x => x.n > 0);
}
const levelKey = id => { const s = byId(S.staff, id); return s && LEVELS[s.level] ? s.level : 'rookie'; };
const roleL = k => (ROLES.find(x=>x.k===k)||{l:k||'Sale'}).l;
const byId = (arr,id) => arr.find(x=>x.id===id);
const staffName = id => { if(!id) return 'Cả đội'; const s = byId(S.staff,id); return (s && s.name) || id; };
const projName = id => (byId(S.projects,id)||{}).name || '—';
// Cấp Trưởng phòng (bậc tpkd) là cấp quản lý: không tính KPI cá nhân (trừ khi bật 'Tính KPI' riêng)
const noKpi = s => s.level === 'tpkd' && !s.isSeller;
const sellers = () => S.staff.filter(s=>s.active!==false && !noKpi(s) && (s.role==='sale' || s.role==='lead' || s.isSeller)).sort((a,b)=>(a.name||'').localeCompare(b.name||'','vi'));
const visibleSellers = () => MANAGER ? sellers() : sellers().filter(s=>s.id===ME.email);
// Phòng kinh doanh (trường "team" của thành viên): lọc & nhóm KPI theo phòng
const teams = () => [...new Set(S.staff.map(s => s.team).filter(Boolean))].sort((a,b) => a.localeCompare(b,'vi'));
const teamOk = s => !UI.fTeam || s.team === UI.fTeam;
const teamSel = () => MANAGER && teams().length ? `<select id="fTeam" aria-label="Lọc theo phòng"><option value="">Tất cả phòng</option>${teams().map(t => `<option value="${esc(t)}" ${UI.fTeam===t?'selected':''}>${esc(t)}</option>`).join('')}</select>` : '';
const byTeam = rows => { if (UI.fTeam || teams().length < 2) return [[UI.fTeam || '', rows]]; const g = new Map(); rows.forEach(r => { const k = r.s.team || (isBoss(r.s) ? 'Ban giám đốc' : 'Chưa xếp phòng'); if (!g.has(k)) g.set(k, []); g.get(k).push(r); }); const ord = k => k === 'Ban giám đốc' ? 0 : k === 'Chưa xếp phòng' ? 2 : 1; return [...g.entries()].sort((a,b) => ord(a[0])-ord(b[0]) || a[0].localeCompare(b[0],'vi')); };
const isMine = x => x.staffId === ME.email;

function toast(msg){ const t=document.createElement('div'); t.className='toast'; t.textContent=msg; document.body.appendChild(t); setTimeout(()=>t.remove(),2800); }
function errMsg(e){
  const c = e && e.code || '';
  if (c.includes('permission-denied')) return 'Bạn không có quyền thao tác này.';
  if (c.includes('quota')) return 'Đã vượt hạn mức gói Firebase, thử lại sau.';
  if (c.includes('unavailable')) return 'Mất kết nối, dữ liệu sẽ đồng bộ khi có mạng.';
  return 'Thao tác không thành công' + (c ? ' ('+c+')' : '') + '.';
}
// Firestore giữ lệnh ghi khi mất mạng và chỉ báo xong khi có mạng lại: không để nút Lưu treo.
async function write(p){
  let late = false;
  const r = await Promise.race([p.then(()=>'ok'), new Promise(res=>setTimeout(()=>res('pending'),4000))]);
  if (r === 'pending') { late = true; p.catch(e=>toast(errMsg(e))); toast('Đã lưu trên máy, sẽ đồng bộ khi có mạng'); }
  return late;
}

/* ---------- stores ---------- */
async function firebaseStore(){
  const [{initializeApp}, A, F] = await Promise.all([import(FB+'firebase-app.js'), import(FB+'firebase-auth.js'), import(FB+'firebase-firestore.js')]);
  const app = initializeApp(firebaseConfig);
  const auth = A.getAuth(app);
  let fs;
  try { fs = F.initializeFirestore(app, {localCache: F.persistentLocalCache({tabManager: F.persistentMultipleTabManager()})}); }
  catch(e){ fs = F.getFirestore(app); }
  return {
    kind:'firebase',
    onAuth: cb => A.onAuthStateChanged(auth, cb),
    // Điện thoại / app cài màn hình chính: chuyển trang (popup hay bị chặn); máy tính: popup
    signInGoogle: () => { const p = new A.GoogleAuthProvider(); p.setCustomParameters({prompt:'select_account'});
      const mobile = matchMedia('(display-mode: standalone)').matches || navigator.standalone || /Android|iPhone|iPad|iPod/i.test(navigator.userAgent);
      return mobile ? A.signInWithRedirect(auth, p) : A.signInWithPopup(auth, p); },
    redirectResult: () => A.getRedirectResult(auth),
    signInEmail: (e,p) => A.signInWithEmailAndPassword(auth, e, p),
    signUpEmail: async (e,p) => { const c = await A.createUserWithEmailAndPassword(auth, e, p); await A.sendEmailVerification(c.user); return c; },
    resendVerify: () => auth.currentUser && A.sendEmailVerification(auth.currentUser),
    resetPw: e => A.sendPasswordResetEmail(auth, e),
    getIdToken: () => auth.currentUser ? auth.currentUser.getIdToken() : Promise.resolve(null),
    reloadUser: async () => { if (auth.currentUser) { await auth.currentUser.reload(); await auth.currentUser.getIdToken(true); } return auth.currentUser; },
    signOut: () => A.signOut(auth),
    watch(col, flt, cb, err, opt){
      const cs = [];
      if (flt) cs.push(F.where(flt[0], flt[1], flt[2]));
      if (opt && opt.orderBy) cs.push(F.orderBy(opt.orderBy, opt.dir||'asc'));
      if (opt && opt.limit) cs.push(F.limit(opt.limit));
      const q = cs.length ? F.query(F.collection(fs,col), ...cs) : F.collection(fs,col);
      return F.onSnapshot(q, s => cb(s.docs.map(d=>({id:d.id, ...d.data()}))), err);
    },
    get: async (col,id) => { const s = await F.getDoc(F.doc(fs,col,id)); return s.exists() ? {id:s.id, ...s.data()} : null; },
    add: (col,d) => F.addDoc(F.collection(fs,col), d),
    set: (col,id,d) => F.setDoc(F.doc(fs,col,id), d),
    update: (col,id,d) => F.updateDoc(F.doc(fs,col,id), d),
    remove: (col,id) => F.deleteDoc(F.doc(fs,col,id))
  };
}
function demoStore(){
  const KEY = 'crm-sale-demo-v1';
  let D = {}; try { D = JSON.parse(localStorage.getItem(KEY)) || {}; } catch(e){}
  const subs = new Set();
  const save = () => { try { localStorage.setItem(KEY, JSON.stringify(D)); } catch(e){} };
  const col = c => D[c] || (D[c] = {});
  const emit = c => subs.forEach(s => { if (s.col === c) s.fire(); });
  const nid = () => Math.random().toString(36).slice(2,10) + Date.now().toString(36);
  return {
    kind:'demo',
    watch(c, flt, cb, err, opt){
      const s = {col:c, fire(){
        let a = Object.entries(col(c)).map(([id,v]) => ({id, ...v}));
        if (flt) a = a.filter(x => flt[1] === '!=' ? x[flt[0]] !== flt[2] && x[flt[0]] !== undefined : x[flt[0]] === flt[2]);
        if (opt && opt.orderBy){ const k = opt.orderBy, d = opt.dir==='desc' ? -1 : 1; a.sort((x,y) => (x[k]>y[k]?1:x[k]<y[k]?-1:0)*d); }
        if (opt && opt.limit) a = a.slice(0, opt.limit);
        cb(a);
      }};
      subs.add(s); setTimeout(() => s.fire()); return () => subs.delete(s);
    },
    get: async (c,i) => col(c)[i] ? {id:i, ...col(c)[i]} : null,
    add: async (c,d) => { col(c)[nid()] = JSON.parse(JSON.stringify(d)); save(); emit(c); },
    set: async (c,i,d) => { col(c)[i] = JSON.parse(JSON.stringify(d)); save(); emit(c); },
    update: async (c,i,d) => { if (!col(c)[i]) throw {code:'not-found'}; Object.assign(col(c)[i], d); save(); emit(c); },
    remove: async (c,i) => { delete col(c)[i]; save(); emit(c); },
    reset(){ D = {}; save(); },
    signOut: async () => {}
  };
}

/* ---------- periods & KPI ---------- */
function range(p, off){
  const n = new Date(), y = n.getFullYear(), m = n.getMonth(), d = n.getDate(); let s, e, label;
  if (p==='day'){ s = new Date(y,m,d+off); e = s; label = DOW[s.getDay()]+', '+pad(s.getDate())+'/'+pad(s.getMonth()+1)+'/'+s.getFullYear(); }
  else if (p==='week'){ const w = (n.getDay()+6)%7; s = new Date(y,m,d-w+7*off); e = new Date(s.getFullYear(),s.getMonth(),s.getDate()+6); label = 'Tuần '+pad(s.getDate())+'/'+pad(s.getMonth()+1)+' – '+pad(e.getDate())+'/'+pad(e.getMonth()+1)+'/'+e.getFullYear(); }
  else if (p==='month'){ s = new Date(y,m+off,1); e = new Date(y,m+off+1,0); label = 'Tháng '+(s.getMonth()+1)+'/'+s.getFullYear(); }
  else { const q = Math.floor(m/3)+off; s = new Date(y,q*3,1); e = new Date(y,q*3+3,0); label = 'Quý '+(Math.floor(s.getMonth()/3)+1)+'/'+s.getFullYear(); }
  return {s:ymd(s), e:ymd(e), label};
}
function actuals(staffId, r){
  const a = {...Z}, sunCust = new Set();
  for (const x of S.activities){
    if (!x.date || x.date < r.s || x.date > r.e) continue;
    if (staffId && x.staffId !== staffId) continue;
    if (x.type === 'deposit' && SUN.test(projName(x.projectId)) && !sunCust.has(x.customerId || x.id)) { sunCust.add(x.customerId || x.id); a.sunDeals++; }
    if (x.type==='call') a.calls++; else if (x.type==='visit') a.visits++; else if (x.type==='event') a.events++;
    else if (x.type==='video') a.videos++; else if (x.type==='post') a.posts++; else if (x.type==='live') a.lives++;
    else if (x.type==='deposit') a.deposits++;
    else if (x.type==='contract'){ a.contracts++; a.revenue += Number(x.amount)||0; }
  }
  for (const c of S.customers) if (c.createdAt && c.createdAt >= r.s && c.createdAt <= r.e && (!staffId || c.staffId === staffId)) a.newLeads++;
  return a;
}
function targets(staffId, p){
  const own = staffId && S.kpi[staffId] && S.kpi[staffId][p];
  const def = (S.kpi.default && S.kpi.default[p]) || DEF_T[p];
  const t = Object.assign({}, DEF_T[p], def, own || {});
  if (p === 'quarter' && staffId && !(own && Number(own.contracts))) t.contracts = LEVELS[levelKey(staffId)].quota;
  return t;
}
/* Điểm KPI quý theo bậc: deal tối đa 60, video + bài tối đa 24 (bài tối đa 18), mời khách tối đa 12, tác phong 4. */
const qKey = r => r.s.slice(0,4) + '-Q' + (Math.floor((Number(r.s.slice(5,7))-1)/3)+1);
function dealKind(x){ if (x.cross) return 'cross'; const p = byId(S.projects, x.projectId); return x.casa || (p && CASA.test(p.name||'')) ? 'casa' : 'normal'; }
function scoreOf(staffId, r){
  const lvk = levelKey(staffId), lv = LEVELS[lvk], d = {normal:0, casa:0, cross:0}; let videos = 0, posts = 0, visits = 0;
  for (const x of S.activities){
    if (x.staffId !== staffId || !x.date || x.date < r.s || x.date > r.e) continue;
    if (x.type === 'contract') d[dealKind(x)]++; else if (x.type === 'video') videos++; else if (x.type === 'post') posts++; else if (x.type === 'visit' || x.type === 'event') visits++;
  }
  const dealPts = Math.min(60, d.normal*lv.pts.normal + d.casa*lv.pts.casa + d.cross*lv.pts.cross);
  const mediaPts = Math.min(24, Math.min(24, videos) + Math.min(18, posts*0.5));
  const visitPts = Math.min(12, visits*0.5);
  const sc = S.scores[qKey(r)+'_'+staffId], disc = sc && sc.discipline !== '' && sc.discipline != null ? Math.min(4, Math.max(0, Number(sc.discipline)||0)) : null;
  const total = Math.round((dealPts + mediaPts + visitPts + (disc||0))*10)/10;
  return {lvk, lv, d, deals:d.normal+d.casa+d.cross, dealPts, videos, posts, mediaPts, visits, visitPts, disc, note: sc && sc.note || '', total, grade: lv.grades.find(g => total >= g.min)};
}
function xsStreak(staffId, off){ let n = 0; for (let o = off; o > off-8; o--){ if (scoreOf(staffId, range('quarter', o)).total >= 90) n++; else break; } return n; }
function teamTargets(p){ const t = {}; METRICS.forEach(m => t[m.k] = 0); visibleSellers().forEach(s => { const x = targets(s.id,p); METRICS.forEach(m => t[m.k] += Number(x[m.k])||0); }); return t; }
function status(a, t, r){
  t = Number(t)||0; if (!t) return {k:'na',l:'Không đặt'};
  if (a >= t) return {k:'ok',l:'Đạt'};
  const td = today();
  if (td > r.e) return {k:'bad',l:'Chưa đạt'};
  if (td < r.s) return {k:'na',l:'Chưa tới'};
  const tot = diffD(r.s,r.e)+1, el = diffD(r.s,td)+1;
  if (tot === 1) return {k:'warn',l:'Chưa đạt'};
  return a >= t*el/tot ? {k:'run',l:'Đúng tiến độ'} : {k:'warn',l:'Chậm tiến độ'};
}
const pct = (a,t) => t ? Math.min(100, Math.round(a/t*100)) : 0;

/* ---------- reminders ---------- */
function reminders(){
  const t = today(), out = [], seen = new Set(), now = Date.now();
  S.customers.filter(c => c.staffId && (c.assignStatus === 'pending' || c.assignStatus === 'declined')).forEach(c => { seen.add(c.id);
    if (c.assignStatus === 'declined') { if (MANAGER) out.push({sev:'warn', tag:'Đang chuyển', title:c.name, sub:staffName(c.staffId)+' trả khách · khách sẽ về mục Chưa giao để anh Hiệp giao lại', kind:'cust', id:c.id}); return; }
    if (isMine(c)) out.push({sev:'bad', tag:'Chờ nhận', title:c.name+(c.phone ? ' · '+c.phone : ''), sub:projName(c.projectId)+(c.budget ? ' · '+c.budget : '')+' · còn '+minsLeft(c)+' phút, quá hạn tự chuyển sale khác', kind:'accept', id:c.id, phone:c.phone});
    else if (MANAGER) out.push({sev:'warn', tag:'Chờ sale nhận', title:c.name, sub:staffName(c.staffId)+' · còn '+minsLeft(c)+' phút', kind:'cust', id:c.id});
  });
  S.customers.filter(c => !seen.has(c.id) && reportDue(c)).forEach(c => { const left = reportDue(c) - now; if (left > 864e5) return; seen.add(c.id);
    out.push({sev:'bad', tag:'Sắp thu hồi', title:c.name, sub:staffName(c.staffId)+' · '+(left > 0 ? 'còn '+Math.ceil(left/36e5)+' giờ' : 'đã quá hạn')+' để cập nhật tình hình, nếu không khách chuyển sale khác', kind:'cust', id:c.id}); });
  if (MANAGER) S.customers.filter(c => !c.staffId && OPEN.includes(c.stage)).forEach(c => { seen.add(c.id);
    out.push({sev:'bad', tag:c.assignStatus === 'expired' ? 'Không ai nhận' : 'Chưa giao', title:c.name+(c.phone ? ' · '+c.phone : ''), sub:(c.createdBy==='web' ? 'Khách từ web' : 'Khách mới')+' · '+projName(c.projectId)+' · ngày '+dm(c.createdAt), kind:'assign', id:c.id}); });
  S.tasks.filter(x => !x.done && x.due && x.due <= t).forEach(x => out.push({sev:x.due<t?'bad':'warn', tag:x.due<t?'Quá hạn':'Hôm nay', title:x.title,
    sub:staffName(x.staffId)+' · hạn '+dm(x.due)+(x.customerId && byId(S.customers,x.customerId) ? ' · KH '+byId(S.customers,x.customerId).name : ''), kind:'task', id:x.id, own:MANAGER||isMine(x)}));
  S.customers.filter(c => OPEN.includes(c.stage) && !seen.has(c.id) && c.nextFollowUp && c.nextFollowUp <= t).forEach(c => { seen.add(c.id);
    out.push({sev:c.nextFollowUp<t?'bad':'warn', tag:'Gọi lại', title:c.name, sub:staffName(c.staffId)+' · '+projName(c.projectId)+' · hẹn '+dm(c.nextFollowUp), kind:'cust', id:c.id}); });
  S.customers.filter(c => OPEN.includes(c.stage) && !seen.has(c.id)).forEach(c => { const last = c.lastContact || c.createdAt; if (!last) return; const n = diffD(last,t);
    if (n >= COLD_DAYS) out.push({sev:'warn', tag:'Khách nguội', title:c.name, sub:staffName(c.staffId)+' · '+n+' ngày chưa liên hệ · '+stageL(c.stage), kind:'cust', id:c.id}); });
  const fc = focusToday();
  if (fc && meSeller()) SLOTS.forEach(sl => { if (nowHM() >= sl.at && !slotDone(sl.k, ME.email)) out.push({sev:'bad', tag:'Mã căn '+sl.k, title:'Chưa đăng mã căn chạy chung '+fc.code, sub:projName(fc.projectId)+' · cả đội cùng đăng lúc '+sl.k, kind:'focus', slot:sl.k}); });
  const ne = nextEvent();
  if (ne && diffD(t, ne.date) <= 7) { const ef = eventFines(), need = Number(ne.minGuests) || 1;
    visibleSellers().forEach(s => { const n = evGuests(ne.id, s.id); if (n < need) out.push({sev: diffD(t, ne.date) <= 2 ? 'bad' : 'warn', tag:'Sự kiện', title:(s.id === ME.email ? 'Bạn' : s.name)+' mới có '+n+'/'+need+' khách dự '+ne.name, sub:DOW[pd(ne.date).getDay()]+' '+dm(ne.date)+' '+(ne.time||'')+' · không đủ khách phạt '+vnd((ef[s.id]||{}).next || EVENT_FINE), kind:'event'}); }); }
  if (meReporter() || meSeller()) evPostToday().forEach(e => evSlotsToday(e).forEach(k => { if (!evPostDone(e.id, ME.email, k)) { const late = nowHM() >= kTime(k);
    if (late || k === evSlotsToday(e).find(z => !evPostDone(e.id, ME.email, z))) out.push({sev: late ? 'bad' : 'warn', tag:'Đăng bài ' + kLab(k), title:(isContent(e) ? 'Đăng bài content ' : 'Đăng bài sự kiện ') + e.name + ' lúc ' + kLab(k), sub:'Mở “' + (isContent(e) ? 'Content tuần' : 'Sự kiện sắp tới') + '” ở Tổng quan → Copy bài + Tải ảnh (có tên, SĐT của bạn)' + (late ? ' · ĐÃ QUÁ ' + kLab(k).toUpperCase() : ''), kind:'evpost'}); } }));
  const re = repEvent();
  if (re) { const late = nowHM() >= repBy(re);
    repSellers().forEach(s => { if (!evRep(re.id, t, s.id)) out.push({sev: late ? 'bad' : 'warn', tag:'Báo cáo SK', title:(s.id === ME.email ? 'Bạn' : s.name)+' chưa báo cáo khách sự kiện hôm nay', sub:re.name+' ('+dm(re.date)+') · hạn '+repBy(re)+' hằng ngày'+(late ? ' · ĐÃ QUÁ HẠN' : ''), kind: s.id === ME.email ? 'evrep' : 'event'}); }); }
  if (BH) bhStatus().filter(b => !b.fresh && b.late).forEach(b => out.push({sev:'warn', tag:'Bảng hàng', title:b.name+' chưa cập nhật hôm nay', sub:'Quá hạn '+BH_DEADLINE+' · lần cuối '+(b.up ? dm(b.up)+' '+hhmm(b.upAt) : '—')+' · '+b.n+' căn', kind:'bh'}));
  const rd = range('day',0), rw = range('week',0);
  visibleSellers().forEach(s => {
    const a = actuals(s.id,rd), tg = targets(s.id,'day');
    const miss = METRICS.filter(m => Number(tg[m.k]) > 0 && a[m.k] < tg[m.k]).map(m => m.l.toLowerCase()+' '+fmt(a[m.k])+'/'+fmt(tg[m.k]));
    if (miss.length) out.push({sev:'info', tag:'KPI ngày', title:s.name+' chưa đạt', sub:miss.join(' · '), kind:'kpi'});
    const aw = actuals(s.id,rw), tw = targets(s.id,'week');
    const slow = METRICS.filter(m => status(aw[m.k],tw[m.k],rw).k === 'warn').map(m => m.l.toLowerCase());
    if (slow.length) out.push({sev:'info', tag:'KPI tuần', title:s.name+' chậm tiến độ', sub:slow.join(', '), kind:'kpi'});
  });
  const ord = {bad:0,warn:1,info:2}; return out.sort((a,b) => ord[a.sev]-ord[b.sev]);
}

/* ---------- gate screens ---------- */
function gate(html){ $('#root').innerHTML = `<div class="gate"><div class="gbox">${html}</div></div>`; }
function showSetup(){
  gate(`<b class="t">CRM Sale Đà Nẵng</b>
    <p>App chưa được nối với Firebase. Làm theo file <b>HUONG-DAN.md</b> để tạo kho dữ liệu và dán cấu hình vào <b>firebase-config.js</b>.</p>
    <p class="muted">Trong lúc chờ, bạn có thể xem thử bằng dữ liệu lưu ngay trên máy này.</p>
    <button class="btn pri block" id="goDemo">Xem thử chế độ demo</button>`);
  $('#goDemo').onclick = () => { store = demoStore(); onSignedIn({email:'demo@crm.local', emailVerified:true, displayName:'Quản lý (demo)', demo:true}); };
}
function showLogin(msg){
  gate(`<b class="t">Đăng nhập CRM</b>
    <p class="muted">Dùng email đã được quản lý thêm vào đội.</p>
    ${msg ? `<div class="banner">${esc(msg)}</div>` : ''}
    ${/Zalo|FBAN|FBAV|FB_IAB|Instagram|Messenger|Line\//i.test(navigator.userAgent) ? '<div class="banner">Bạn đang mở trong Zalo/Facebook – Google không cho đăng nhập ở đây. Bấm ⋯ → <b>Mở bằng trình duyệt</b> (Chrome/Safari) rồi đăng nhập.</div>' : ''}
    <button class="btn pri block" id="gGoogle">Đăng nhập bằng Google</button>
    <hr>
    <form id="gForm">
      <input id="gEmail" type="email" autocomplete="username" placeholder="Email" required>
      <input id="gPw" type="password" autocomplete="current-password" placeholder="Mật khẩu (tối thiểu 6 ký tự)" minlength="6" required>
      <button class="btn block" type="submit" id="gIn">Đăng nhập bằng email</button>
    </form>
    <div class="row" style="justify-content:space-between"><button class="lnk" id="gUp">Tạo tài khoản email</button><button class="lnk" id="gReset">Quên mật khẩu</button></div>`);
  const fail = e => { const c = e && e.code || ''; showLogin(c.includes('popup-closed') ? '' : c.includes('invalid-credential')||c.includes('wrong-password')||c.includes('user-not-found') ? 'Sai email hoặc mật khẩu.' : c.includes('email-already') ? 'Email này đã có tài khoản, hãy đăng nhập.' : c.includes('unauthorized-domain') ? 'Tên miền này chưa được thêm vào Firebase (Authentication → Settings → Authorized domains).' : 'Không đăng nhập được ('+c+').'); };
  $('#gGoogle').onclick = () => store.signInGoogle().catch(fail);
  $('#gForm').onsubmit = e => { e.preventDefault(); store.signInEmail($('#gEmail').value.trim(), $('#gPw').value).catch(fail); };
  $('#gUp').onclick = () => { const em = $('#gEmail').value.trim(), pw = $('#gPw').value; if (!em || pw.length < 6) { toast('Nhập email và mật khẩu từ 6 ký tự rồi bấm lại'); return; } store.signUpEmail(em, pw).catch(fail); };
  $('#gReset').onclick = () => { const em = $('#gEmail').value.trim(); if (!em) { toast('Nhập email trước'); return; } store.resetPw(em).then(() => toast('Đã gửi email đặt lại mật khẩu'), fail); };
}
function showVerify(u){
  gate(`<b class="t">Xác minh email</b><p>Đã gửi thư xác minh tới <b>${esc(u.email)}</b>. Mở thư, bấm vào liên kết, rồi quay lại đây.</p>
    <button class="btn pri block" id="vDone">Tôi đã xác minh</button><button class="btn block" id="vAgain">Gửi lại thư</button><button class="lnk" id="vOut">Đăng xuất</button>`);
  $('#vDone').onclick = async () => { const nu = await store.reloadUser(); if (nu && nu.emailVerified) onSignedIn(nu); else toast('Email chưa được xác minh'); };
  $('#vAgain').onclick = () => store.resendVerify().then(() => toast('Đã gửi lại'), e => toast(errMsg(e)));
  $('#vOut').onclick = () => store.signOut();
}
function showNoAccess(email){
  gate(`<b class="t">Chưa có quyền truy cập</b><p>Tài khoản <b>${esc(email)}</b> chưa có trong danh sách đội hoặc đã bị tạm khoá.</p>
    <p class="muted">Nhờ quản lý thêm đúng email này ở mục <b>Đội sale</b>, sau đó đăng nhập lại.</p>
    <button class="btn pri block" id="nRetry">Thử lại</button><button class="lnk" id="nOut">Đăng xuất / dùng email khác</button>`);
  $('#nRetry').onclick = () => location.reload();
  $('#nOut').onclick = () => store.signOut();
}

/* ---------- session ---------- */
async function onSignedIn(u){
  const email = String(u.email || '').toLowerCase();
  if (!u.emailVerified) { showVerify(u); return; }
  gate(`<b class="t">CRM Sale Đà Nẵng</b><p class="muted">Đang tải dữ liệu…</p>`);
  let member = null;
  try { member = await store.get('members', email); } catch(e) { member = null; }
  const owner = email === String(OWNER_EMAIL).toLowerCase() || u.demo;
  if (!member && owner) {
    member = {name: u.displayName || email.split('@')[0], phone:'', team:'', role:'admin', active:true, isSeller:false};
    try { await write(store.set('members', email, member)); } catch(e) {}
  }
  if (!member || member.active === false) { showNoAccess(email); return; }
  ME = {email, name: member.name, role: member.role || 'sale', team: member.team || '', owner, demo: !!u.demo};
  MANAGER = owner || ['admin', 'gd', 'lead'].includes(ME.role);
  if (ME.role === 'lead' && member.team) UI.fTeam = member.team; // Trưởng phòng mở sẵn phòng của mình
  ADMIN = owner || ME.role === 'admin';
  BH = owner || ['admin', 'gd', 'bh'].includes(ME.role); // 'bh' = Admin bảng hàng: cập nhật hàng, trong CRM chỉ thấy dữ liệu của mình
  document.body.classList.toggle('sale', !MANAGER);
  document.body.classList.toggle('notadm', !ADMIN);
  document.body.classList.toggle('bh', BH); // Admin bảng hàng vẫn thấy mục Quản trị (phần bảng hàng & chính sách)
  shell(); subscribe(); route();
}
function signOutAll(){ unsubs.forEach(f => { try { f(); } catch(e){} }); unsubs = []; ['#aiFab','#aiPanel'].forEach(s => { const el = $(s); if (el) el.remove(); }); AI.log = []; Object.assign(S, {projects:[],staff:[],customers:[],activities:[],tasks:[],kpi:{},scores:{},ann:[],bh:[],bhPriv:[],sold:[],events:[],evReports:[],focus:{}}); ME = null; }
function subscribe(){
  const err = e => toast('Không tải được dữ liệu: ' + errMsg(e));
  const w = (col, flt, fn, opt) => unsubs.push(store.watch(col, flt, a => { fn(a); render(); }, err, opt));
  w('members', null, a => S.staff = a);
  w('projects', null, a => S.projects = a.sort((x,y) => (x.order ?? 99)-(y.order ?? 99) || (x.name||'').localeCompare(y.name||'','vi')));
  w('kpiTargets', null, a => { const k = {}; a.forEach(x => k[x.id] = x); S.kpi = k; });
  w('scores', MANAGER ? null : ['staffId','==',ME.email], a => { const k = {}; a.forEach(x => k[x.id] = x); S.scores = k; });
  w('announcements', null, a => S.ann = a.sort((x,y) => (y.createdAt||0) - (x.createdAt||0)));
  w('bhStatus', ['st','==','sold'], a => S.sold = a.sort((x,y) => (y.at||0) - (x.at||0)));
  w('events', null, a => { a = a.sort((x,y) => (x.date||'').localeCompare(y.date||'')); S.events = a.filter(x => x.kind !== 'content').map(evPreset); S.contents = a.filter(x => x.kind === 'content'); tryRep(); }); // content tuần lưu chung bộ sưu tập events (kind: 'content')
  w('eventReports', repAll() ? null : (ME.role === 'lead' && ME.team) ? ['team','==',ME.team] : ['staffId','==',ME.email], a => S.evReports = a);
  w('focus', null, a => { const k = {}; a.forEach(x => k[x.id] = x); S.focus = k; });
  if (MANAGER || BH) w('bangHang', null, a => S.bh = a);
  if (BH) w('bhPrivate', null, a => S.bhPriv = a); // tên sàn rổ hàng chéo: chỉ Quản trị / Giám đốc / Admin bảng hàng
  if (MANAGER) {
    // khách "Chưa giao" chỉ chủ hệ thống thấy; quản lý khác chỉ tải khách đã giao (luật Firestore chặn phần còn lại)
    w('customers', ME.owner ? null : ['staffId','!=',''], a => S.customers = a);
    w('tasks', null, a => S.tasks = a);
    w('activities', null, a => S.activities = a, {orderBy:'date', dir:'desc', limit:3000});
  } else {
    w('customers', ['staffId','==',ME.email], a => S.customers = a);
    let mine = [], team = [];
    w('tasks', ['staffId','==',ME.email], a => { mine = a; S.tasks = mine.concat(team); });
    w('tasks', ['staffId','==',''], a => { team = a; S.tasks = mine.concat(team); });
    w('activities', ['staffId','==',ME.email], a => S.activities = a);
  }
  setTimeout(dailyNotify, 4000);
}

/* ---------- notifications & install ---------- */
function myAlertCount(){ return reminders().filter(r => r.sev !== 'info' && (r.kind !== 'task' || r.own)).length; }
let lastBadge = -1;
function updateBadge(n){ if (n === lastBadge) return; lastBadge = n; try { if (navigator.setAppBadge) n ? navigator.setAppBadge(n) : navigator.clearAppBadge(); } catch(e){} }
async function dailyNotify(){
  if (!ME || !('Notification' in window) || Notification.permission !== 'granted') return;
  const rems = reminders(), pend = rems.filter(r => r.kind==='accept').length, od = rems.filter(r => r.kind==='task' && r.sev==='bad').length, td = rems.filter(r => r.kind==='task' && r.sev==='warn').length, fu = rems.filter(r => r.tag==='Gọi lại').length, cold = rems.filter(r => r.tag==='Khách nguội').length;
  if (!pend && !od && !td && !fu && !cold) return;
  const key = 'crm-notified-' + today() + (pend ? '-p' + pend : '');
  try { if (localStorage.getItem(key)) return; localStorage.setItem(key, '1'); } catch(e){}
  const parts = []; if (pend) parts.push(pend+' khách mới chờ bạn nhận'); if (od) parts.push(od+' việc quá hạn'); if (td) parts.push(td+' việc hôm nay'); if (fu) parts.push(fu+' khách cần gọi lại'); if (cold) parts.push(cold+' khách nguội');
  try { const reg = await navigator.serviceWorker.ready; reg.showNotification('Nhắc việc hôm nay', {body: parts.join(' · '), icon:'icons/icon-192.png', badge:'icons/icon-192.png', tag:'daily'}); }
  catch(e){ try { new Notification('Nhắc việc hôm nay', {body: parts.join(' · ')}); } catch(_){} }
}
// Khách mới giao cho mình khi đang mở app: báo ngay (một lần cho mỗi khách).
const seenPending = new Set();
async function notifyNewPending(){
  const mine = S.customers.filter(c => c.assignStatus === 'pending' && isMine(c) && !seenPending.has(c.id + c.assignedAt));
  if (!mine.length) return;
  mine.forEach(c => seenPending.add(c.id + c.assignedAt));
  if (!('Notification' in window) || Notification.permission !== 'granted') return;
  const body = mine.map(c => c.name + (c.phone ? ' · ' + c.phone : '')).join('\n') + '\nBấm "Nhận khách" trong ' + ACCEPT_MIN + ' phút';
  try { const reg = await navigator.serviceWorker.ready; reg.showNotification('Khách mới giao cho bạn', {body, icon:'icons/icon-192.png', badge:'icons/icon-192.png', tag:'lead', renotify:true, requireInteraction:true}); } catch(e){}
}
// Thông báo dự án mới (người khác đăng) khi đang mở app: báo một lần.
async function notifyNewAnn(){
  let last = 0; try { last = Number(localStorage.getItem('crm-ann-notified-' + ME.email) || 0); } catch(e) {}
  const fresh = annUnread().filter(a => (a.createdAt || 0) > last && a.by !== ME.email);
  const maxAt = Math.max(last, ...S.ann.map(a => a.createdAt || 0));
  try { localStorage.setItem('crm-ann-notified-' + ME.email, String(maxAt)); } catch(e) {}
  if (!last || !fresh.length || !('Notification' in window) || Notification.permission !== 'granted') return; // lần đầu mở app: không dồn thông báo cũ
  try { const reg = await navigator.serviceWorker.ready; reg.showNotification(fresh.length > 1 ? fresh.length + ' thông báo dự án mới' : 'Thông báo: ' + fresh[0].title, {body: fresh.map(a => (a.projectId ? projName(a.projectId) + ': ' : '') + a.title).join('\n'), icon:'icons/icon-192.png', badge:'icons/icon-192.png', tag:'ann'}); } catch(e) {}
}
// Căn vừa được đánh dấu Đã bán (người khác đánh dấu) khi đang mở app: báo đỏ một lần.
async function notifyNewSold(){
  let last = 0; try { last = Number(localStorage.getItem('crm-sold-notified-' + ME.email) || 0); } catch(e) {}
  const fresh = recentSold(1).filter(x => (x.at || 0) > last && x.by !== ME.email);
  const maxAt = Math.max(last, ...S.sold.map(x => x.at || 0));
  try { localStorage.setItem('crm-sold-notified-' + ME.email, String(maxAt)); } catch(e) {}
  if (!last || !fresh.length) return; // lần đầu mở app: không dồn báo cũ
  toast('🔴 Vừa bán: ' + fresh.map(x => x.code).join(', '));
  if (!('Notification' in window) || Notification.permission !== 'granted') return;
  try { const reg = await navigator.serviceWorker.ready; reg.showNotification('🔴 Căn vừa bán: ' + fresh.map(x => x.code).join(', '), {body: fresh.map(x => x.code + ' · ' + projName(x.project) + ' · ' + (x.byName || '')).join('\n') + '\nKhông chào căn này cho khách nữa.', icon:'icons/icon-192.png', badge:'icons/icon-192.png', tag:'sold', renotify:true}); } catch(e) {}
}
setInterval(() => { if (ME && !(dlg && dlg.open)) render(); }, 30000); // cập nhật đồng hồ "còn x phút"
window.addEventListener('beforeinstallprompt', e => { e.preventDefault(); installEvt = e; render(); });
if ('serviceWorker' in navigator) navigator.serviceWorker.register('sw.js').catch(() => {});
const CRM_VER = 'bản 130'; // đổi mỗi lần cập nhật
// Tự báo có bản mới (iPad / iPhone hay giữ trang cũ): định kỳ đọc lại file trên máy chủ, khác số bản thì hiện thanh bấm để cập nhật
function updWatch(file, re, cur) {
  let shown = false;
  const show = v => { if (shown) return; shown = true; const d = document.createElement('div');
    d.setAttribute('style', 'position:fixed;left:50%;top:10px;transform:translateX(-50%);z-index:9999;background:#2b1a0e;color:#fff;border:2px solid #c9963f;border-radius:99px;padding:9px 18px;font:600 14px/1.3 system-ui,sans-serif;box-shadow:0 6px 20px rgba(0,0,0,.3);cursor:pointer;max-width:92vw;text-align:center');
    d.innerHTML = `🔄 Đã có <b>${v}</b> mới – bấm để cập nhật`;
    d.onclick = async () => { d.textContent = 'Đang cập nhật…'; try { const ks = await caches.keys(); await Promise.all(ks.map(k => caches.delete(k))); } catch (_) {}
      try { const rs = await navigator.serviceWorker.getRegistrations(); await Promise.all(rs.map(r => r.update().catch(() => {}))); } catch (_) {} location.reload(); };
    document.body.appendChild(d); };
  const chk = async () => { if (shown || !navigator.onLine) return; try { const t = await (await fetch(file + '?vchk=' + Date.now(), {cache: 'no-store'})).text(); const m = t.match(re); if (m && m[1] !== cur) show(m[1]); } catch (_) {} };
  setTimeout(chk, 5000); setInterval(chk, 10 * 60e3); document.addEventListener('visibilitychange', () => { if (!document.hidden) chk(); });
}
updWatch('app.js', /const CRM_VER = '([^']+)'/, CRM_VER);

/* ---------- shell & render ---------- */
function shell(){
  $('#root').innerHTML = `<div class="app">
    <nav class="rail" id="nav">
      <div class="brand"><b>CRM Sale Đà Nẵng</b><small>${ME.demo ? 'Chế độ demo' : 'Quản lý đội kinh doanh BĐS'}</small></div>
      <a href="#tong-quan" data-v="tong-quan">Tổng quan <span class="cnt" id="cntRem" hidden></span></a>
      <a href="#khach-hang" data-v="khach-hang">Khách hàng</a>
      <a href="#ke-hoach" data-v="ke-hoach">Kế hoạch &amp; nhắc việc</a>
      <a href="#kpi" data-v="kpi">KPI</a>
      <a href="#doi-sale" data-v="doi-sale" class="m">Đội sale</a>
      <a href="#quan-tri" data-v="quan-tri" class="mb">Quản trị</a>
      <a href="#du-an" data-v="du-an">Dự án</a>
      <a href="bang-hang.html" data-v="bang-hang">Bảng hàng ↗</a>
      <a href="#huong-dan" data-v="huong-dan">📘 Hướng dẫn</a>
      <a href="#tai-khoan" data-v="tai-khoan">Tài khoản</a>
      <div class="me">${esc(ME.name)}<br>${esc(ME.email)} · ${roleL(ME.role)}</div>
    </nav>
    <main id="main"></main></div>`;
  aiMount();
}

/* ---------- trợ lý AI ---------- */
const AI = {log: [], busy: false, left: null};
try { AI.log = JSON.parse(sessionStorage.getItem('crmAiLog') || '[]') || []; } catch(_) {}
const aiSave = () => { try { sessionStorage.setItem('crmAiLog', JSON.stringify(AI.log.slice(-20))); } catch(_) {} };
const AI_WAIT = ['Quân sư đang lật sổ khách… 📒', 'Đang soi KPI từng người 🔍', 'Đang nghĩ câu chốt thật ngọt… 🍯', 'Sắp xong rồi, pha ly cà phê đi ☕'];
const AI_NEXT = ['Soạn tin Zalo gửi khách', 'Kịch bản gọi điện', 'Khách chê đắt thì nói sao?', 'Viết ngắn gọn hơn'];
function aiMount(){
  if ($('#aiFab')) return;
  const sug = MANAGER
    ? ['Tóm tắt tình hình đội hôm nay', 'Ai đang chậm KPI tuần này, thiếu gì?', 'Khách nào sắp bị thu hồi hoặc chưa giao?', 'Xếp hạng điểm KPI quý và ai có nguy cơ hạ bậc', 'So sánh Sun FourS Tower và Casamia Balanca cho khách mua ở']
    : ['Hôm nay tôi cần gọi ai?', 'Tôi còn thiếu gì để đạt KPI quý?', 'Khách nào của tôi đang nguội?', 'Soạn tin Zalo mời khách đi xem nhà mẫu cuối tuần', 'Pháp lý Sun FourS Tower thế nào?', 'Chi phí sau khi nhận nhà Casamia Balanca?'];
  document.body.insertAdjacentHTML('beforeend', `<button id="aiFab" class="ai-fab" type="button" aria-label="Mở trợ lý AI">✦ Quân sư chốt căn</button>
  <section id="aiPanel" class="ai-panel" hidden aria-label="Trợ lý AI">
    <header class="ai-hd"><div><b>Quân sư chốt căn</b><div class="muted">Hỏi gì cũng được, trừ giá vàng ngày mai 😄</div></div><div class="row" style="flex-wrap:nowrap"><button type="button" class="btn sm" id="aiNew">Mới</button><button type="button" class="btn sm" id="aiClose" aria-label="Đóng">✕</button></div></header>
    <div id="aiLog" class="ai-log"></div>
    <div id="aiSug" class="ai-sug">${sug.map(s => `<button type="button" class="ai-chip">${esc(s)}</button>`).join('')}</div>
    <form id="aiForm" class="ai-form"><textarea id="aiIn" rows="2" placeholder="Hỏi về khách, KPI, việc cần làm, soạn tin Zalo…"></textarea><button class="btn pri" id="aiSend" type="submit">Gửi</button></form>
  </section>`);
  $('#aiFab').onclick = () => aiOpen();
  $('#aiClose').onclick = () => { $('#aiPanel').hidden = true; $('#aiFab').hidden = false; };
  $('#aiNew').onclick = () => { AI.log = []; aiSave(); aiDraw(); };
  $('#aiSug').onclick = e => { const b = e.target.closest('.ai-chip'); if (b) aiAsk(b.textContent); };
  $('#aiForm').onsubmit = e => { e.preventDefault(); const v = $('#aiIn').value.trim(); if (v) { $('#aiIn').value = ''; aiAsk(v); } };
  $('#aiIn').onkeydown = e => { if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); $('#aiForm').requestSubmit(); } };
  $('#aiLog').onclick = async e => { const n = e.target.closest('.ai-chip'); if (n) return aiAsk(n.textContent); const b = e.target.closest('[data-copy]'); if (!b) return; const t = AI.log[Number(b.dataset.copy)].content; try { await navigator.clipboard.writeText(t); toast('Đã copy'); } catch(_) { toast('Không copy được, hãy bôi đen để copy'); } };
  aiDraw();
}
function aiOpen(q){ $('#aiPanel').hidden = false; $('#aiFab').hidden = true; if (q) aiAsk(q); else setTimeout(() => $('#aiIn').focus(), 50); }
function aiFmt(t){
  return esc(t).replace(/^\s*#{1,4}\s*(.+)$/gm, '**$1**').replace(/\*\*(.+?)\*\*/g, '<b>$1</b>').split('\n').map(l => /^\s*[-•*]\s+/.test(l) ? '<div class="ai-li">' + l.replace(/^\s*[-•*]\s+/, '') + '</div>' : l ? '<div>' + l + '</div>' : '<div class="ai-gap"></div>').join('');
}
function aiDraw(){
  const log = $('#aiLog'); if (!log) return;
  log.innerHTML = AI.log.length ? AI.log.map((m, i) => `<div class="ai-m ${m.role === 'user' ? 'me' : m.err ? 'err' : 'bot'}">${aiFmt(m.content)}${m.role === 'assistant' && !m.err ? `<button type="button" class="lnkbtn ai-cp" data-copy="${i}">Copy</button>` : ''}</div>`).join('') + (AI.busy ? `<div class="ai-m bot ai-wait" id="aiWait">${AI_WAIT[0]}</div>` : !AI.log[AI.log.length-1].err ? `<div class="ai-next">${AI_NEXT.map(s => `<button type="button" class="ai-chip">${esc(s)}</button>`).join('')}</div>${AI.left != null ? `<div class="ai-left">Hôm nay còn ${AI.left} câu hỏi</div>` : ''}` : '')
    : `<div class="ai-hello">Chào ${esc(ME.name)}! Quân sư đã đọc ${MANAGER ? 'dữ liệu cả đội' : 'khách, việc và KPI của bạn'} trong CRM. Chọn một gợi ý bên dưới hoặc gõ câu hỏi, chốt căn nào Quân sư cũng gánh 💪</div>`;
  clearInterval(AI.tick); if (AI.busy) { let k = 0; AI.tick = setInterval(() => { const w = $('#aiWait'); if (!w) return clearInterval(AI.tick); w.textContent = AI_WAIT[++k % AI_WAIT.length]; }, 1800); }
  $('#aiSug').hidden = AI.log.length > 0;
  $('#aiSend').disabled = AI.busy;
  log.scrollTop = log.scrollHeight;
}
function aiContext(){
  const t = today(), rq = range('quarter',0), rw = range('week',0), rm = range('month',0), lim = (s, n) => String(s || '').slice(0, n);
  // Gọn để tiết kiệm: khách đang chăm sóc + khách chốt/ngừng trong 30 ngày, mỗi khách 3 hoạt động gần nhất.
  const lastActs = id => S.activities.filter(a => a.customerId === id).sort((a,b) => (b.date||'').localeCompare(a.date||'') || (b.ts||0)-(a.ts||0)).slice(0,3).map(a => dm(a.date)+' '+actL(a.type)+(a.amount ? ' '+a.amount+' tỷ' : '')+(a.note ? ': '+lim(a.note,120) : ''));
  const recent = addD(t, -30);
  const cs = S.customers.filter(c => OPEN.includes(c.stage) || (c.lastContact || c.createdAt || '') >= recent)
    .sort((a,b) => (OPEN.includes(b.stage)-OPEN.includes(a.stage)) || (a.nextFollowUp||'9999').localeCompare(b.nextFollowUp||'9999')).slice(0, 250);
  const ctx = {
    homNay: DOW[new Date().getDay()]+' '+dm(t)+'/'+t.slice(0,4), quy: rq.label, tuan: rw.label,
    quyTacKPI: Object.values(LEVELS).map(lv => `${lv.l}: ${lv.quota} deal/quý, ${lv.pts.normal} điểm/deal (Casa ${lv.pts.casa}, giỏ chéo ${lv.pts.cross}, tối đa 60); xếp loại: ${lv.grades.map(g => g.min+'+ '+g.l+' → '+g.act).join('; ')}`).concat(['Mọi bậc: video 1 điểm, bài content 0,5 điểm (tối đa 18), video + bài tối đa 24; mời khách/site tour 0,5 điểm/khách tối đa 12; tác phong tối đa 4 do quản lý chấm. Chỉ tiêu tuần: 2 video, 3 bài, 2 khách; tháng: 8 video, 12 bài, 8 khách.', `Khách giao phải bấm Nhận trong ${ACCEPT_MIN} phút; quá ${REPORT_DAYS} ngày không cập nhật tình hình khách sẽ bị chuyển sale khác.`]),
    sale: visibleSellers().map(s => { const x = scoreOf(s.id, rq), w = actuals(s.id, rw), mo = actuals(s.id, rm);
      return {ten:s.name, email:s.id, nhom:s.team||'', bac:x.lv.l, diemQuy:{tong:x.total, xepLoaiTamTinh:x.grade.l, deal:x.deals+'/'+x.lv.quota+' ('+x.d.normal+' thường, '+x.d.casa+' Casa, '+x.d.cross+' giỏ chéo) = '+x.dealPts+' điểm', video:x.videos, bai:x.posts, diemTruyenThong:x.mediaPts, khachMoiSiteTour:x.visits, diemMoiKhach:x.visitPts, tacPhong:x.disc == null ? 'chưa chấm' : x.disc},
        tuanNay:{video:w.videos, bai:w.posts, moiKhach:w.visits, cuocGoi:w.calls}, thangNay:{video:mo.videos, bai:mo.posts, moiKhach:mo.visits, deal:mo.contracts, doanhSoTy:mo.revenue}}; }),
    duAn: S.projects.map(p => ({ten:p.name, viTri:p.location||'', chuDauTu:p.developer||'', loai:p.type||'', trangThai:p.status||'', ghiChu:lim(p.note,600)})),
    khach: cs.map(c => ({ten:c.name, sdt:c.phone||'', duAn:projName(c.projectId), sale:c.staffId ? staffName(c.staffId) : 'Chưa giao', giaiDoan:stageL(c.stage), nhuCau:c.budget||'', nguon:c.source||'', ngayTao:dm(c.createdAt), lienHeCuoi:dm(c.lastContact), henChamSoc:dm(c.nextFollowUp),
      giaoKhach:{pending:'chờ sale nhận', accepted:'đã nhận', declined:'đang trả về', expired:'không ai nhận', returned:'đã trả về quản lý'}[c.assignStatus] || '', ghiChu:lim(c.note,200), hoatDong:lastActs(c.id)})),
    viecChuaXong: S.tasks.filter(x => !x.done).slice(0,150).map(x => ({viec:lim(x.title,150), nguoiLam:staffName(x.staffId), han:dm(x.due), quaHan:!!(x.due && x.due < t), khach:x.customerId && byId(S.customers,x.customerId) ? byId(S.customers,x.customerId).name : ''})),
    maCanChayChungHomNay: focusToday() ? focusToday().code + ' · ' + projName(focusToday().projectId) + (focusToday().note ? ' · ' + lim(focusToday().note, 300) : '') + ' (đăng lúc 9h và 15h)' : '',
    suKienSapToi: S.events.filter(e => e.date >= t).slice(0, 3).map(e => ({ten:e.name, ngay:dm(e.date)+' '+(e.time||''), diaDiem:e.place||'', toiThieuKhach:Number(e.minGuests)||1, khachDaMoi: visibleSellers().map(s => s.name+': '+evGuests(e.id, s.id)).join(', '), ghiChu:lim(e.note,300)})),
    tienPhatSuKien: (() => { const ef = eventFines(); return visibleSellers().filter(s => (ef[s.id]||{}).total).map(s => s.name+': '+vnd(ef[s.id].total)+' (đang chuỗi '+ef[s.id].streak+' lần không khách)'); })(),
    keHoachDoi: 'Mỗi sale: telesale ≥30 cuộc/ngày; 1 giao dịch dự án Sun/tháng; livestream ≥1 lần/tuần; mỗi sự kiện tối thiểu 1 khách tham dự (không khách phạt 50.000đ, lần liên tiếp sau cộng thêm 50.000đ); 9h và 15h mỗi ngày cả đội cùng đăng mã căn chạy chung. Giao dịch tính khi khách đặt cọc; mỗi giao dịch được thưởng 200.000đ từ quỹ đội.',
    thuongGiaoDich: (() => { const rw = range('week',0); return visibleSellers().map(s => s.name+': tuần này '+dealsOf(s.id, rw.s, rw.e).length+' giao dịch'); })(),
    canVuaBan3Ngay: recentSold().map(x => x.code + ' · ' + projName(x.project) + ' · ' + dm(ymd(new Date(x.at)))),
    thongBaoDuAn: annActive().slice(0,15).map(a => ({ngay:dm(a.date), duAn:a.projectId ? projName(a.projectId) : 'Tất cả dự án', quanTrong:!!a.important, tieuDe:a.title, noiDung:lim(a.body,800)})),
    nhacViecHomNay: reminders().slice(0,80).map(r => r.tag+': '+r.title+' — '+r.sub)
  };
  let s = JSON.stringify(ctx);
  while (s.length > 140000 && ctx.khach.length > 50) { ctx.khach = ctx.khach.slice(0, Math.floor(ctx.khach.length*0.7)); s = JSON.stringify(ctx); }
  return s;
}
if (location.hostname === 'localhost') window.__crmAiContext = () => aiContext(); // chỉ để kiểm tra khi chạy trên máy
async function aiAsk(q){
  if (AI.busy) return;
  AI.log.push({role:'user', content:q}); AI.busy = true; aiDraw();
  try {
    if (store.kind !== 'firebase') throw new Error('Trợ lý AI chỉ chạy khi đăng nhập CRM thật, không chạy ở chế độ demo.');
    const idToken = await store.getIdToken();
    const messages = AI.log.filter(m => !m.err).map(m => ({role:m.role, content:m.content}));
    const r = await fetch(CHAT_URL, {method:'POST', headers:{'Content-Type':'text/plain;charset=utf-8'}, body: JSON.stringify({idToken, messages, context: aiContext()})});
    const j = await r.json();
    if (!j.ok) throw new Error(j.error || 'Trợ lý AI không trả lời được.');
    AI.log.push({role:'assistant', content:j.text}); if (j.left != null) AI.left = j.left;
  } catch(e) {
    AI.log.push({role:'assistant', content: e && e.message && !/Failed to fetch|NetworkError|JSON/i.test(e.message) ? e.message : 'Không kết nối được trợ lý AI. Kiểm tra mạng rồi thử lại.', err:true});
  } finally { AI.busy = false; aiSave(); aiDraw(); }
}
let rq = 0;
function render(){ if (rq || !ME) return; rq = setTimeout(() => { rq = 0; draw(); }, 0); }
function draw(){
  const m = $('#main'); if (!m) return;
  document.querySelectorAll('#nav a').forEach(a => a.classList.toggle('on', a.dataset.v === UI.view));
  const nav = $('#nav'), on = nav && nav.querySelector('a.on');
  if (on && nav.scrollWidth > nav.clientWidth && nav.dataset.v !== UI.view) { nav.dataset.v = UI.view; nav.scrollLeft = Math.max(0, on.offsetLeft - 16); }
  const n = myAlertCount() + annUnread().length; const c = $('#cntRem'); c.hidden = !n; c.textContent = n; updateBadge(n);
  notifyNewPending(); notifyNewAnn(); notifyNewSold();
  const f = {'tong-quan':vDash,'khach-hang':vCust,'ke-hoach':vTasks,'kpi':vKpi,'doi-sale':vStaff,'du-an':vProj,'content-tuan':vContent,'huong-dan':vGuide,'quan-tri':vAdmin,'tai-khoan':vAcc}[UI.view] || vDash;
  const keep = document.activeElement && document.activeElement.id && m.contains(document.activeElement) ? document.activeElement.id : null;
  const sel = keep && document.activeElement.selectionStart;
  m.innerHTML = (ME.demo ? '<div class="banner info">Chế độ demo: dữ liệu chỉ lưu trên trình duyệt này. Nối Firebase để cả đội dùng chung.</div>' : '') + f();
  if (keep) { const el = document.getElementById(keep); if (el) { el.focus(); try { if (sel != null) el.setSelectionRange(sel, sel); } catch(e){} } }
}
function top(h, sub, actions){ return `<div class="top"><div><h1>${h}</h1><div class="sub">${sub||''}</div></div><div class="row">${actions||''}</div></div>`; }

function vDash(){
  const t = today(), rm = range('month',0), tm = teamTargets('month'), am = actuals(MANAGER ? null : ME.email, rm);
  const open = S.customers.filter(c => OPEN.includes(c.stage)).length;
  const overdue = S.tasks.filter(x => !x.done && x.due && x.due < t).length;
  const fu = S.customers.filter(c => OPEN.includes(c.stage) && c.nextFollowUp && c.nextFollowUp <= t).length;
  const rems = reminders();
  let h = top(MANAGER ? 'Tổng quan' : 'Việc của tôi', DOW[new Date().getDay()]+', '+dm(t)+'/'+new Date().getFullYear()+(MANAGER ? ' · '+sellers().length+' sale · '+S.projects.length+' dự án' : ' · '+esc(ME.name)),
    `<button class="btn" data-a="addWork">+ Video / bài đăng</button><button class="btn" data-a="addCust">+ Khách hàng</button><button class="btn pri" data-a="addTask">+ Việc cần làm</button>`);
  const rs = recentSold();
  if (rs.length) h += `<div class="soldbar"><b>🔴 VỪA BÁN (3 ngày)</b>${rs.slice(0,12).map(x => `<span><b>${esc(x.code)}</b> · ${esc(projName(x.project))} · ${esc(x.byName || '')} · ${dm(ymd(new Date(x.at)))} ${hhmm(x.at)}</span>`).join('')}${rs.length > 12 ? `<span>… và ${rs.length-12} căn</span>` : ''}<a class="btn sm" href="bang-hang.html">Xem bảng hàng</a></div>`;
  h += planCards();
  h += evPromo();
  { const cs = contentNow().filter(c => evSlotsToday(c).length); if (cs.length) h += `<div class="panel evp-wrap"><h2>📣 Content hôm nay <a class="btn sm" href="#content-tuan">Cả tuần</a></h2>` + cs.map(evCard).join('') + '</div>'; }
  const anns = annActive(), rdA = annRead(), unA = anns.filter(a => !rdA.has(a.id)).length;
  if (anns.length) h += `<div class="panel ann" style="margin-bottom:16px"><h2>Thông báo dự án <span>${unA ? unA+' chưa đọc' : 'đã đọc hết'}</span>${unA ? '<button class="btn sm" data-a="annReadAll">Đánh dấu đã đọc</button>' : ''}</h2><div class="ann-list">${anns.slice(0,5).map(a => annCard(a, !rdA.has(a.id))).join('')}</div>${anns.length > 5 ? `<div class="muted" style="margin-top:6px">… còn ${anns.length-5} thông báo cũ hơn</div>` : ''}</div>`;
  if (installEvt) h += `<div class="banner info row" style="justify-content:space-between">Cài CRM thành ứng dụng trên máy này để mở nhanh và nhận nhắc việc. <button class="btn sm pri" data-a="install">Cài app</button></div>`;
  h += `<div class="tiles">
   <div class="tile"><div class="l">Khách đang chăm sóc</div><div class="v">${open}</div></div>
   <div class="tile ${fu?'warn':''}"><div class="l">Khách cần gọi hôm nay</div><div class="v">${fu}</div></div>
   <div class="tile ${overdue?'bad':''}"><div class="l">Việc quá hạn</div><div class="v">${overdue}</div></div>
   <div class="tile"><div class="l">Doanh số ${rm.label.toLowerCase()}</div><div class="v">${fmt(am.revenue)} <small>/ ${fmt(tm.revenue)} tỷ</small></div></div></div>`;
  h += `<div class="grid2"><div class="panel"><h2>Nhắc việc hôm nay <span>${rems.length} mục</span></h2>`;
  if (!rems.length) h += `<div class="empty"><b>Không có việc tồn</b>Nhắc việc, khách cần gọi lại và chỉ tiêu KPI chưa đạt sẽ hiện ở đây.</div>`;
  else h += '<div class="rem">' + rems.slice(0,40).map(r => `<div class="ri ${r.sev}"><div class="bar"></div><div><div class="row"><span class="chip c-${r.sev}">${r.tag}</span><span class="t">${esc(r.title)}</span></div><div class="s">${esc(r.sub)}</div></div><div>${r.kind==='task' && r.own ? `<button class="btn sm" data-a="doneTask" data-id="${r.id}">Xong</button>` : r.kind==='cust' ? `<button class="btn sm" data-a="logAct" data-id="${r.id}">Ghi nhận</button>` : r.kind==='assign' ? `<button class="btn sm pri" data-a="editCust" data-id="${r.id}">Giao sale</button>` : r.kind==='bh' ? `<a class="btn sm pri" href="bang-hang.html?tab=bang-gia">Cập nhật</a>` : r.kind==='evrep' ? `<button class="btn sm pri" data-a="evReport">Báo cáo</button>` : r.kind==='focus' ? `<button class="btn sm pri" data-a="focusPost" data-k="${r.slot}">Đã đăng ${r.slot}</button>` : r.kind==='accept' ? `<div class="row" style="flex-wrap:nowrap"><button class="btn sm pri" data-a="acceptLead" data-id="${r.id}">Nhận khách</button><button class="btn sm" data-a="declineLead" data-id="${r.id}">Từ chối</button></div>` : ''}</div></div>`).join('') + (rems.length > 40 ? `<div class="muted">… và ${rems.length-40} mục khác</div>` : '') + '</div>';
  h += `</div><div class="stack"><div class="panel"><h2>KPI ${MANAGER ? 'đội' : 'của tôi'} ${rm.label.toLowerCase()} <a class="btn sm" href="#kpi">Chi tiết</a></h2>`;
  h += METRICS.filter(m => tm[m.k] > 0).map(m => { const st = status(am[m.k], tm[m.k], rm); return `<div class="meter"><span>${m.l}</span><div class="track ${st.k}"><i style="width:${pct(am[m.k],tm[m.k])}%"></i></div><span class="num">${fmt(am[m.k])} / ${fmt(tm[m.k])} <span class="chip c-${st.k}">${st.l}</span></span></div>`; }).join('');
  h += '</div>';
  const rq = range('quarter',0);
  if (MANAGER) {
    h += `<div class="panel"><h2>Điểm KPI ${rq.label.toLowerCase()} <a class="btn sm" href="#kpi">Bảng điểm</a></h2>`;
    const rk = sellers().map(s => ({s, x: scoreOf(s.id, rq)})).sort((a,b) => b.x.total - a.x.total);
    h += rk.length ? '<div class="tw" style="border:0"><table><thead><tr><th>Sale</th><th>Bậc</th><th>Deal</th><th>Điểm</th><th>Tạm xếp loại</th></tr></thead><tbody>' + rk.map(({s,x}) => `<tr><td class="nm">${esc(s.name)}</td><td>${x.lv.l.replace(' Sales','')}</td><td class="num">${x.deals}/${x.lv.quota}</td><td class="num"><b>${fmt(x.total)}</b></td><td><span class="chip c-${x.grade.k}">${x.grade.l}</span></td></tr>`).join('') + '</tbody></table></div>'
      : `<div class="empty"><b>Chưa có sale nào</b>Thêm email từng sale ở mục Đội sale để họ đăng nhập.</div>`;
    h += '</div>';
  } else if (sellers().some(s => s.id === ME.email)) {
    const x = scoreOf(ME.email, rq);
    const mt = (l, a, mx) => `<div class="meter"><span>${l}</span><div class="track"><i style="width:${pct(a,mx)}%"></i></div><span class="num">${fmt(a)} / ${mx}</span></div>`;
    h += `<div class="panel"><h2>Điểm KPI ${rq.label.toLowerCase()} · ${x.lv.l} <a class="btn sm" href="#kpi">Chi tiết</a></h2>
      ${mt('Deal ('+x.deals+'/'+x.lv.quota+')', x.dealPts, 60)}${mt('Video + bài', x.mediaPts, 24)}${mt('Mời khách', x.visitPts, 12)}${mt('Tác phong', x.disc || 0, 4)}
      <div class="row" style="justify-content:space-between;margin-top:8px"><b>Tổng tạm tính: ${fmt(x.total)}/100</b><span class="chip c-${x.grade.k}">${x.grade.l}</span></div><div class="muted" style="font-size:12.5px">${esc(x.grade.act)}</div></div>`;
  }
  return h + '</div></div>';
}

function vCust(){
  const t = today(), q = UI.q.trim().toLowerCase();
  const list = S.customers.filter(c => (!q || (c.name||'').toLowerCase().includes(q) || (c.phone||'').includes(q)) && (!UI.fStaff || (UI.fStaff === '__none' ? !c.staffId : c.staffId === UI.fStaff)) && (!UI.fProj || c.projectId === UI.fProj) && (UI.fStage === 'all' || (UI.fStage === 'open' ? OPEN.includes(c.stage) : c.stage === UI.fStage)));
  list.sort((a,b) => (a.nextFollowUp||'9999').localeCompare(b.nextFollowUp||'9999') || (b.createdAt||'').localeCompare(a.createdAt||''));
  let h = top(MANAGER ? 'Khách hàng' : 'Khách của tôi', S.customers.length+' khách · đang hiển thị '+list.length, `<button class="btn pri" data-a="addCust">+ Thêm khách</button>`);
  h += `<div class="filters"><input type="search" id="fq" placeholder="Tìm tên hoặc số điện thoại" value="${esc(UI.q)}">
   ${MANAGER ? `<select id="fStaff"><option value="">Tất cả sale</option>${ME.owner ? `<option value="__none" ${UI.fStaff==='__none'?'selected':''}>Chưa giao (${S.customers.filter(c => !c.staffId && OPEN.includes(c.stage)).length})</option>` : ''}${sellers().map(s => `<option value="${esc(s.id)}" ${UI.fStaff===s.id?'selected':''}>${esc(s.name)}</option>`).join('')}</select>` : ''}
   <select id="fProj"><option value="">Tất cả dự án</option>${S.projects.map(p => `<option value="${esc(p.id)}" ${UI.fProj===p.id?'selected':''}>${esc(p.name)}</option>`).join('')}</select>
   <select id="fStage"><option value="open" ${UI.fStage==='open'?'selected':''}>Đang theo</option><option value="all" ${UI.fStage==='all'?'selected':''}>Tất cả giai đoạn</option>${STAGES.map(s => `<option value="${s.k}" ${UI.fStage===s.k?'selected':''}>${s.l}</option>`).join('')}</select></div>`;
  if (!list.length) return h + `<div class="tw"><div class="empty"><b>${S.customers.length ? 'Không có khách khớp bộ lọc' : 'Chưa có khách hàng'}</b>${S.customers.length ? 'Đổi bộ lọc để xem thêm.' : 'Bấm “+ Thêm khách” để nhập khách đầu tiên và hẹn ngày chăm sóc.'}</div></div>`;
  h += '<div class="tw"><table><thead><tr><th>Khách hàng</th><th>Dự án</th>'+(MANAGER?'<th>Sale</th>':'')+'<th>Giai đoạn</th><th>Nhu cầu / ngân sách</th><th>Liên hệ cuối</th><th>Hẹn chăm sóc</th><th></th></tr></thead><tbody>';
  h += list.map(c => { const last = c.lastContact || c.createdAt, n = last ? diffD(last,t) : 0;
    const pend = c.assignStatus === 'pending' && c.staffId;
    return `<tr><td><div class="nm">${esc(c.name)}${pend ? ` <span class="chip c-bad">Chờ nhận · ${minsLeft(c)}′</span>` : ''}</div><div class="ph">${esc(c.phone||'')} ${zaloA(c.phone)}${c.source ? ' · '+esc(c.source) : ''}</div></td>
    <td>${esc(projName(c.projectId))}</td>${MANAGER ? `<td>${c.staffId ? esc(staffName(c.staffId)) : '<span class="chip c-bad">Chưa giao</span>'}</td>` : ''}
    <td><span class="chip st-${esc(c.stage)}">${stageL(c.stage)}</span></td>
    <td class="muted">${esc(c.budget||'')}</td>
    <td class="num ${OPEN.includes(c.stage) && n >= COLD_DAYS ? 'late' : ''}">${last ? dm(last)+' <span class="muted">('+n+'n)</span>' : '—'}</td>
    <td class="num ${c.nextFollowUp && c.nextFollowUp < t && OPEN.includes(c.stage) ? 'late' : ''}">${dm(c.nextFollowUp)}</td>
    <td><div class="row" style="flex-wrap:nowrap">${pend && isMine(c) ? `<button class="btn sm pri" data-a="acceptLead" data-id="${c.id}">Nhận khách</button>` : ''}<button class="btn sm" data-a="quickCall" data-id="${c.id}" title="Ghi nhận 1 cuộc gọi hôm nay">+ Gọi</button><button class="btn sm" data-a="logAct" data-id="${c.id}">Ghi nhận</button><button class="btn sm" data-a="editCust" data-id="${c.id}">Mở</button></div></td></tr>`; }).join('');
  return h + '</tbody></table></div>';
}

function vTasks(){
  const t = today(); const list = S.tasks.filter(x => !UI.tStaff || x.staffId === UI.tStaff);
  const od = list.filter(x => !x.done && x.due && x.due < t), td = list.filter(x => !x.done && x.due === t), up = list.filter(x => !x.done && (!x.due || x.due > t)), dn = list.filter(x => x.done).sort((a,b) => (b.doneAt||'').localeCompare(a.doneAt||'')).slice(0,20);
  const sortD = a => a.sort((x,y) => (x.due||'9999').localeCompare(y.due||'9999'));
  let h = top('Kế hoạch & nhắc việc', MANAGER ? 'Giao việc, đặt hạn và theo dõi hoàn thành của từng sale' : 'Việc được giao cho bạn và cho cả đội',
    (MANAGER ? `<select id="tStaff"><option value="">Cả đội</option>${sellers().map(s => `<option value="${esc(s.id)}" ${UI.tStaff===s.id?'selected':''}>${esc(s.name)}</option>`).join('')}</select>` : '') + `<button class="btn pri" data-a="addTask">+ Việc cần làm</button>`);
  if (!list.length) return h + `<div class="tw"><div class="empty"><b>Chưa có kế hoạch nào</b>Thêm việc như “Gọi lại 20 khách data Sun Symphony” hoặc “Dẫn khách xem nhà mẫu thứ 7”, chọn người làm và hạn chót. Việc quá hạn sẽ hiện ở Tổng quan.</div></div>`;
  const pri = {high:'<span class="chip c-bad">Gấp</span>', mid:'', low:'<span class="chip c-na">Thấp</span>'};
  const row = x => { const can = MANAGER || isMine(x); return `<div class="task ${x.done?'done':''}"><input type="checkbox" id="tk_${x.id}" data-a="toggleTask" data-id="${x.id}" ${x.done?'checked':''} ${can?'':'disabled'} aria-label="Hoàn thành"><div><div class="row"><span class="t">${esc(x.title)}</span>${pri[x.priority]||''}</div><div class="muted" style="font-size:12.5px">${esc(staffName(x.staffId))} · hạn ${dm(x.due)}${x.customerId && byId(S.customers,x.customerId) ? ' · KH '+esc(byId(S.customers,x.customerId).name) : ''}${x.note ? ' · '+esc(x.note) : ''}</div></div>${can ? `<button class="btn sm" data-a="editTask" data-id="${x.id}">Sửa</button>` : '<span></span>'}</div>`; };
  const grp = (l,a,c) => a.length ? `<div class="grp ${c||''}">${l} · ${a.length}</div><div class="tasks">${a.map(row).join('')}</div>` : '';
  return h + grp('Quá hạn', sortD(od), 'bad') + grp('Hôm nay', td) + grp('Sắp tới', sortD(up)) + grp('Đã xong gần đây', dn);
}

const kmodeSeg = () => `<div class="seg"><button type="button" data-a="kmode" data-k="score" class="${UI.kmode!=='act'?'on':''}">Bảng điểm quý</button><button type="button" data-a="kmode" data-k="act" class="${UI.kmode==='act'?'on':''}">Chỉ tiêu tuần / tháng</button></div>`;
function vScore(){
  const r = range('quarter', UI.qo), td = today(), ended = td > r.e, running = td >= r.s && !ended;
  let h = top('Bảng điểm KPI '+r.label.toLowerCase(), running ? 'Đang chạy · điểm tạm tính từ hoạt động đã ghi nhận' : ended ? 'Quý đã kết thúc · kết quả đánh giá' : 'Quý chưa bắt đầu',
    kmodeSeg() + teamSel() + `<button class="btn" data-a="qo" data-d="-1" aria-label="Quý trước">◀</button><button class="btn" data-a="qo" data-d="0">Quý này</button><button class="btn" data-a="qo" data-d="1" aria-label="Quý sau">▶</button><button class="btn pri" data-a="addWork">+ Video / bài đăng</button>`);
  const st = visibleSellers().filter(teamOk);
  if (!st.length) return h + `<div class="tw"><div class="empty"><b>${MANAGER ? 'Chưa có sale để chấm điểm' : 'Tài khoản của bạn chưa được tính KPI'}</b>${MANAGER ? 'Thêm thành viên vai trò Sale hoặc Trưởng nhóm ở mục Đội sale và chọn bậc Rookie / Elite / Pro.' : 'Nhờ quản lý bật “Tính KPI” cho tài khoản của bạn.'}</div></div>`;
  const rows = st.map(s => ({s, x: scoreOf(s.id, r)})).sort((a,b) => b.x.total - a.x.total);
  const small = t => `<div class="ph">${t}</div>`;
  h += '<div class="tw"><table><thead><tr><th>Sale</th><th>Deal · /60</th><th>Video + bài · /24</th><th>Mời khách · /12</th><th>Tác phong · /4</th><th>Tổng · /100</th><th>Xếp loại</th></tr></thead><tbody>';
  const scoreRow = ({s, x}) => {
    const dd = [x.d.normal ? x.d.normal+' thường' : '', x.d.casa ? x.d.casa+' Casa' : '', x.d.cross ? x.d.cross+' giỏ chéo' : ''].filter(Boolean).join(' · ') || 'chưa có';
    const disc = x.disc == null ? (MANAGER ? `<button class="btn sm" data-a="scoreDisc" data-id="${esc(s.id)}">Chấm</button>` : '<span class="muted">chưa chấm</span>') : `<b>${fmt(x.disc)}</b>${MANAGER ? ` <button class="btn sm" data-a="scoreDisc" data-id="${esc(s.id)}">Sửa</button>` : ''}`;
    const tk = x.grade.k, apply = ended && ADMIN && x.grade.to && x.grade.to !== x.lvk ? `<button class="btn sm pri" data-a="applyLevel" data-id="${esc(s.id)}" data-k="${x.grade.to}">Áp dụng: ${LEVELS[x.grade.to].l}</button>` : '';
    return `<tr><td><button class="lnkbtn nm" data-a="scoreDetail" data-id="${esc(s.id)}">${esc(s.name)}</button>${small(esc(x.lv.l))}</td>
      <td><b>${fmt(x.dealPts)}</b>${small(x.deals+'/'+x.lv.quota+' deal · '+dd)}</td>
      <td><b>${fmt(x.mediaPts)}</b>${small(x.videos+' video · '+x.posts+' bài')}</td>
      <td><b>${fmt(x.visitPts)}</b>${small(x.visits+' khách')}</td>
      <td>${disc}</td>
      <td><div class="kc"><div class="n"><b>${fmt(x.total)}</b><span> / 100</span></div><div class="track ${tk}"><i style="width:${Math.min(100, x.total)}%"></i></div></div></td>
      <td><span class="chip c-${tk}">${running ? 'Tạm tính: ' : ''}${x.grade.l}</span>${small(esc(x.grade.act))}${apply}</td></tr>`;
  };
  h += byTeam(rows).map(([tm, rs]) => {
    const head = tm && (byTeam(rows).length > 1 || UI.fTeam) ? `<tr class="tot"><td colspan="7"><b>${esc(tm)}</b> · ${rs.length} người · ${rs.reduce((a, r) => a + r.x.deals, 0)} deal · điểm TB ${fmt(rs.reduce((a, r) => a + r.x.total, 0) / rs.length)} · ${rs.filter(r => r.x.total >= 70).length}/${rs.length} người từ 70 điểm</td></tr>` : '';
    return head + rs.map(scoreRow).join('');
  }).join('');
  h += '</tbody></table></div>';
  const notes = [];
  rows.forEach(({s, x}) => {
    if (x.lvk === 'pro') { const k = xsStreak(s.id, UI.qo); if (k >= 2) notes.push(`${esc(s.name)}: ${k} quý liên tiếp Xuất sắc → ${k >= 4 ? 'thưởng chuyến du lịch Thụy Sỹ' : 'thưởng chuyến du lịch Thượng Hải'}`); }
    if (x.lvk === 'pro' && x.d.casa >= 3) notes.push(`${esc(s.name)}: bán ${x.d.casa} căn Casa trong quý → sếp thưởng riêng 1 bộ gậy golf + khoá học`);
  });
  if (notes.length) h += `<div class="panel" style="margin-top:16px"><h2>Thưởng Pro Sales</h2><div class="rem">${notes.map(n => `<div class="ri info"><div class="bar"></div><div class="t">${n}</div><span></span></div>`).join('')}</div><p class="muted" style="margin-top:8px">Thưởng hiện vật, không quy đổi thành tiền mặt.</p></div>`;
  h += `<div class="panel" style="margin-top:16px"><h2>Cách tính điểm</h2><div class="cards">${Object.entries(LEVELS).filter(([k]) => k !== 'tpkd').map(([k, lv]) => `<div class="card"><h3>${lv.l}</h3><div class="meta">${lv.salary}</div>
    <div class="meta">Chỉ tiêu ${lv.quota} deal/quý · ${lv.pts.normal} điểm/deal · Casa ${lv.pts.casa} · giỏ chéo ${lv.pts.cross} (tối đa 60)</div>
    <div class="meta">${lv.grades.map(g => `<b>${g.min}+</b> ${g.l}: ${esc(g.act)}`).join('<br>')}</div></div>`).join('')}</div>
    <p class="muted" style="margin-top:10px">Mọi bậc: video 1 điểm/video (24/quý, 2/tuần), bài content tự tạo 0,5 điểm/bài (36/quý, 3/tuần, tối đa 18), video + bài cộng chung tối đa 24 · mời khách / site tour 0,5 điểm/khách (24/quý, tối đa 12) · tác phong, kỷ luật, training tối đa 4 điểm do quản lý chấm. Deal tính khi ghi nhận “Ký HĐMB”; deal Casa tự nhận theo dự án Casamia, deal giỏ chéo do sale đánh dấu.</p></div>`;
  return h;
}
function vKpi(){
  if (UI.kmode !== 'act') return vScore();
  const r = range(UI.kp, UI.ko);
  let h = top('KPI '+PERIODS.find(p => p.k === UI.kp).l.toLowerCase(), r.label+' · số liệu tự tính từ hoạt động đã ghi nhận',
    kmodeSeg() + `<div class="seg">${PERIODS.map(p => `<button type="button" data-a="kp" data-k="${p.k}" class="${UI.kp===p.k?'on':''}">${p.l}</button>`).join('')}</div>
     <button class="btn" data-a="ko" data-d="-1" aria-label="Kỳ trước">◀</button><button class="btn" data-a="ko" data-d="0">Kỳ này</button><button class="btn" data-a="ko" data-d="1" aria-label="Kỳ sau">▶</button>
     ${teamSel()}<button class="btn m" data-a="editTargets">Đặt chỉ tiêu</button>`);
  h += `<div class="legend">Trạng thái: <span class="chip c-ok">Đạt</span><span class="chip c-run">Đúng tiến độ</span><span class="chip c-warn">Chậm tiến độ / chưa đạt (kỳ đang chạy)</span><span class="chip c-bad">Chưa đạt (kỳ đã kết thúc)</span></div>`;
  const st = visibleSellers().filter(teamOk);
  if (!st.length) return h + `<div class="tw"><div class="empty"><b>${MANAGER ? 'Chưa có sale để tính KPI' : 'Tài khoản của bạn chưa được tính KPI'}</b>${MANAGER ? 'Thêm thành viên vai trò Sale hoặc Trưởng nhóm ở mục Đội sale.' : 'Nhờ quản lý bật “Tính KPI” cho tài khoản của bạn.'}</div></div>`;
  const cell = (a,t) => { const s = status(a,t,r); return `<td><div class="kc" title="${s.l}"><div class="n"><b>${fmt(a)}</b><span> / ${fmt(t)}</span></div><div class="track ${s.k}"><i style="width:${t ? pct(a,t) : 0}%"></i></div></div></td>`; };
  const ended = today() > r.e;
  const rows = st.map(s => { const a = actuals(s.id,r), t = targets(s.id,UI.kp); const set = METRICS.filter(m => Number(t[m.k]) > 0); const ok = set.filter(m => a[m.k] >= t[m.k]).length; const bad = set.filter(m => ['bad','warn'].includes(status(a[m.k],t[m.k],r).k)).length; return {s,a,t,ok,n:set.length,bad}; });
  h += '<div class="tw"><table><thead><tr><th>Sale</th>' + METRICS.map(m => `<th>${m.l}</th>`).join('') + '<th>Kết quả</th></tr></thead><tbody>';
  const actRow = x => `<tr><td><div class="nm">${esc(x.s.name)}</div><div class="ph">${esc([x.s.title, x.s.team].filter(Boolean).join(' · '))}</div></td>${METRICS.map(m => cell(x.a[m.k], Number(x.t[m.k])||0)).join('')}<td><span class="chip ${x.n && x.ok === x.n ? 'c-ok' : x.bad ? (ended ? 'c-bad' : 'c-warn') : 'c-run'}">Đạt ${x.ok}/${x.n}</span></td></tr>`;
  const sumRow = (label, rs) => { const a = {}, t = {}; METRICS.forEach(m => { a[m.k] = rs.reduce((s, x) => s + (Number(x.a[m.k])||0), 0); t[m.k] = rs.reduce((s, x) => s + (Number(x.t[m.k])||0), 0); }); return `<tr class="tot"><td>${esc(label)}</td>${METRICS.map(m => cell(a[m.k], t[m.k])).join('')}<td></td></tr>`; };
  const groups = byTeam(rows);
  h += groups.map(([tm, rs]) => rs.map(actRow).join('') + (MANAGER && tm && rs.length > 1 ? sumRow('Cả ' + tm.replace(/^Phòng/i, 'phòng'), rs) : '')).join('');
  if (MANAGER && rows.length > 1 && groups.length > 1) h += sumRow('Cả đội', rows);
  else if (MANAGER && rows.length > 1 && !groups[0][0]) h += sumRow('Cả đội', rows);
  h += '</tbody></table></div>';
  const fails = rows.filter(x => x.bad);
  h += `<div class="panel" style="margin-top:16px"><h2>Chưa đạt trong kỳ <span>${fails.length} sale</span></h2>` + (fails.length ? '<div class="rem">' + fails.map(x => `<div class="ri ${ended?'bad':'warn'}"><div class="bar"></div><div><div class="t">${esc(x.s.name)}</div><div class="s">${METRICS.filter(m => ['bad','warn'].includes(status(x.a[m.k],x.t[m.k],r).k)).map(m => m.l+' '+fmt(x.a[m.k])+'/'+fmt(x.t[m.k])+' (còn thiếu '+fmt(Math.max(0,x.t[m.k]-x.a[m.k]))+')').join(' · ')}</div></div><span></span></div>`).join('') + '</div>' : '<div class="muted">Tất cả đang đạt hoặc đúng tiến độ.</div>') + '</div>';
  return h;
}

function vStaff(){
  if (!MANAGER) return vDash();
  const rm = range('month',0), t = today();
  let h = top('Đội sale', sellers().length+' người tính KPI · '+S.staff.length+' tài khoản' + (teams().length ? ' · ' + teams().length + ' phòng' : ''), teamSel() + `<button class="btn pri adm" data-a="addStaff">+ Thêm thành viên</button>`);
  h += `<div class="banner info">Mỗi thành viên đăng nhập bằng đúng email được thêm ở đây (Google hoặc email + mật khẩu). Sale chỉ thấy khách và việc của mình; Trưởng nhóm, Giám đốc và Quản trị thấy cả đội. Chỉ Quản trị, Giám đốc và Admin bảng hàng được cập nhật bảng hàng.</div>`;
  const rank = s => s.level === 'tpkd' ? 0 : isBoss(s) ? 2 : 1; // trưởng phòng đứng đầu phòng
  const list = [...S.staff].filter(teamOk).sort((a,b) => (b.active!==false)-(a.active!==false) || rank(a)-rank(b) || (a.name||'').localeCompare(b.name||'','vi'));
  const rq = range('quarter',0);
  const groups = byTeam(list.map(s => ({s}))).map(([tm, rs]) => [tm, rs.map(r => r.s)]);
  return h + groups.map(([tm, ls]) => (tm && (groups.length > 1 || UI.fTeam) ? `<h2 style="margin:18px 0 8px">${esc(tm)} <span class="muted" style="font-size:14px;font-weight:400">${ls.length} người</span></h2>` : '') + '<div class="cards">' + ls.map(s => { const kpi = (!isBoss(s) || s.isSeller) && !noKpi(s); const x = scoreOf(s.id, rq);
    const open = S.customers.filter(c => c.staffId === s.id && OPEN.includes(c.stage)).length; const od = S.tasks.filter(y => y.staffId === s.id && !y.done && y.due && y.due < t).length;
    return `<div class="card"><div class="row" style="justify-content:space-between"><h3>${esc(s.name)}</h3>${s.active===false ? '<span class="chip c-na">Tạm khoá</span>' : kpi ? `<span class="chip c-${x.grade.k}">${x.lv.l} · ${fmt(x.total)} điểm</span>` : '<span class="chip c-na">Không tính KPI</span>'}</div>
    <div class="meta">${esc(s.title || roleL(s.role))}${s.team ? ' · '+esc(s.team) : ''}${s.phone ? ' · '+esc(s.phone) : ''}<br>${esc(s.id)}${kpi ? '<br>'+esc(x.lv.salary) : ''}</div>
    <div class="stats"><div><b>${open}</b>khách đang theo</div><div><b>${x.deals}/${x.lv.quota}</b>deal quý này</div><div><b class="${od?'late':''}">${od}</b>việc quá hạn</div></div>
    <div class="foot"><button class="btn sm" data-a="viewStaffCust" data-id="${esc(s.id)}">Khách</button><button class="btn sm adm" data-a="editStaff" data-id="${esc(s.id)}">Sửa</button></div></div>`; }).join('') + '</div>').join('');
}

/* ---------- Sự kiện sắp tới: ảnh + thông điệp đăng theo từng ngày (Tổng quan) ----------
 * Quản lý nhập ở form sự kiện: ảnh (tải lên hoặc link) + "Thông điệp đăng theo ngày", mỗi đoạn bắt đầu bằng ngày:
 *   14/10: nội dung…   hoặc   D-3: nội dung…   (D-0 = ngày sự kiện). Chưa nhập thì CRM tự gợi ý bài từ 6 ngày trước tới ngày sự kiện. */
const kDate = k => String(k).slice(0, 10), kTime = k => String(k).split('@')[1] || EV_POST_AT, kLab = k => kTime(k).replace(/^0/, '').replace(':00', 'h').replace(':', 'h');
const EV_PROMO_DAYS = 30;

/* ---------- Bộ bài + ảnh cài sẵn cho sự kiện Tòa F2 Sun FourS Tower tại Hà Nội (CN 18/10/2026) ----------
 * Áp dụng tự động cho sự kiện 18/10 (hoặc sự kiện tên "18/10…" đang để ngày 19/10). Quản lý sửa bài trong form và Lưu
 * thì bài của quản lý được dùng thay (postsCustom). */
const EV_PRESET_1810 = {
  name: 'Sự kiện Tòa F2 Sun FourS Tower tại Hà Nội', date: '2026-10-18', time: '9:00 – 11:20',
  place: 'Sun Gallery Tây Hồ View – 58 Quảng Bá, Tây Hồ, Hà Nội', perks: 'Teabreak · Bốc thăm may mắn',
  hashtags: '#SunFourSTower #ToaF2 #ToaMaiF2 #MaiVangRaHaNoi #ThapBonMua #SunGroup #SunGalleryTayHoView #CanHoDaNang #NhaBenBienDaNang',
  highlights: '~700 tr | vốn ban đầu căn 2PN\n0% | lãi 24 tháng · vay 70%\n2 km | ra biển Sơn Thủy',
  posts: "14/10: 🌼 Mai vàng ra Hà Nội – Tòa F2 Sun FourS Tower\ntiêu đề: Mai vàng ra Hà Nội | Tòa F2 – Sun FourS Tower\nảnh: 7\nđiểm nhấn: ~700 tr | vốn ban đầu căn 2PN\ncâu: Hà Nội đang vào thu – Chủ nhật 18/10, Tòa Mai F2 của \"Tháp Bốn Mùa\" Đà Nẵng mang sắc xuân đến Tây Hồ.\nHà Nội đang vào thu – Chủ nhật 18/10, Tòa Mai F2 của \"Tháp Bốn Mùa\" Đà Nẵng mang sắc xuân đến Tây Hồ.\n💰 Chỉ ~700 triệu vốn ban đầu đã sở hữu căn 2PN Tòa F2.\n🌼 Bốn tòa FourS lấy cảm hứng từ tranh tứ bình Mai – Trúc – Cúc – Tùng; F2 là Tòa Mai – mùa xuân.\n📍 Sun Gallery Tây Hồ View · Chủ nhật 18/10 · 9:00\n👉 Giữ chỗ · Zalo {sdt} · {ten}\n\n15/10: 🌸 Hà Nội có đào – Đà Nẵng có mai vàng\ntiêu đề: Hà Nội có đào | Đà Nẵng có mai vàng\nảnh: 9\nđiểm nhấn: 0% | lãi suất 24 tháng\ncâu: Tòa Mai F2 – mùa xuân của tứ bình: bình minh trên tán cây, hoa nở dưới chân tòa mỗi sáng.\nTòa Mai F2 – mùa xuân của tứ bình: bình minh trên tán cây, hoa nở dưới chân tòa mỗi sáng.\n🏦 0% lãi suất trong 24 tháng, ngân hàng hỗ trợ vay đến 70% – có \"mùa xuân\" của riêng mình mà không áp lực dòng tiền.\n🌳 Công viên ven sông ngay trước nhà, hồ bơi bốn mùa trên tầng 2.\n📍 Sun Gallery Tây Hồ View · Chủ nhật 18/10 · 9:00\n👉 Giữ chỗ · Zalo {sdt} · {ten}\n\n16/10: ☀️ Mai vàng nở bên biển – 2 km ra biển Sơn Thủy\ntiêu đề: Mai vàng nở bên biển | 2 km ra biển Sơn Thủy\nảnh: 8 phải\nđiểm nhấn: 2 km | ra biển Sơn Thủy\ncâu: Trời xanh, sông Cổ Cò ngay dưới tầm mắt, biển chỉ cách 2 km – hè cả nhà ra biển, tháng không ở cho thuê.\nTrời xanh, sông Cổ Cò ngay dưới tầm mắt, biển chỉ cách 2 km – hè cả nhà ra biển, tháng không ở cho thuê.\n🏖️ 2 km là xuống biển Sơn Thủy – không cần đặt khách sạn mỗi mùa hè.\n⏳ Còn 2 ngày – số chỗ tại sự kiện có hạn.\n📍 Sun Gallery Tây Hồ View · Chủ nhật 18/10 · 9:00\n👉 Giữ chỗ · Zalo {sdt} · {ten}\n\n17/10: 🍂 Thu Hà Nội gặp xuân Đà Nẵng – Chỉ 1h20 bay\ntiêu đề: Thu Hà Nội gặp xuân Đà Nẵng | Chỉ 1h20 bay\nmẫu: cảm xúc\nảnh: 10\nđiểm nhấn: 1h20 | bay Hà Nội – Đà Nẵng\ncâu: Sáng mai 9:00, mai vàng F2 nở giữa Tây Hồ – tuần làm việc ở Hà Nội, cuối tuần về với phố biển.\nSáng mai 9:00, mai vàng F2 nở giữa Tây Hồ – tuần làm việc ở Hà Nội, cuối tuần về với phố biển.\n✈️ Chỉ 1h20 bay Hà Nội – Đà Nẵng: thứ Sáu tan làm, tối đã ở bên biển.\n🍂 Hà Nội có thu heo may, hoa sữa; Đà Nẵng có Tòa Mai F2 và một mùa xuân đang chờ.\n📍 Sun Gallery Tây Hồ View · Chủ nhật 18/10 · 9:00\n👉 Giữ chỗ · Zalo {sdt} · {ten}\n\n17/10 20h: 🌙 Đêm nay Hà Nội se lạnh – Sáng mai gặp mai vàng F2\ntiêu đề: Đêm nay Hà Nội se lạnh | Sáng mai gặp mai vàng F2\nảnh: 2\nảnh nhỏ: 1\n📍 Địa điểm sự kiện: Sun Gallery Tây Hồ View – 58 Quảng Bá, Tây Hồ, Hà Nội\n🕘 Chủ nhật 18/10 · 9:00 – 11:20\n☕ Teabreak · 🎁 Bốc thăm may mắn\n💰 ~700 triệu vốn ban đầu căn 2PN · 🏦 0% lãi 24 tháng, vay 70% · 🏖️ 2 km ra biển Sơn Thủy\nTối nay nhắn em để em giữ chỗ ngồi và đón anh/chị sáng mai.\n👉 Giữ chỗ · Zalo {sdt} · {ten}\n\n18/10: 🎉 Hôm nay 9:00 – Mai vàng F2 ra thăm Hà Nội\ntiêu đề: Hôm nay 9:00 – Mai vàng F2 | Ra thăm Hà Nội\nảnh: 11\nảnh nhỏ: 1\n📍 Địa điểm sự kiện: Sun Gallery Tây Hồ View – 58 Quảng Bá, Tây Hồ, Hà Nội\n🕘 Hôm nay · 9:00 – 11:20\n☕ Teabreak · 🎁 Bốc thăm may mắn\n💰 ~700 triệu vốn ban đầu căn 2PN · 🏦 0% lãi 24 tháng, vay 70% · 🏖️ 2 km ra biển Sơn Thủy\nEm đang có mặt tại sự kiện – anh/chị đến muộn vẫn kịp.\n👉 Giữ chỗ · Zalo {sdt} · {ten}\n\n18/10 20h: 🙏 Cảm ơn Hà Nội – Mai vàng F2 vẫn chờ anh/chị\nmẫu: cảm xúc\nnhãn: Cảm ơn Hà Nội · 18/10/2026\nnút: Nhận bảng giá\ntiêu đề: Cảm ơn Hà Nội | Mai vàng F2 vẫn chờ anh/chị\nảnh: 7\nđiểm nhấn: 0% | lãi suất 24 tháng\ncâu: Chưa kịp ghé sự kiện? Em gửi bảng giá, mặt bằng và tính dòng tiền riêng cho từng căn ngay tối nay.\nChưa kịp ghé sự kiện? Em gửi bảng giá, mặt bằng và tính dòng tiền riêng cho từng căn ngay tối nay.\n🏦 0% lãi suất trong 24 tháng, vay đến 70% – áp dụng theo chính sách hiện hành của chủ đầu tư.\n🙏 Cảm ơn anh/chị đã ghé Sun Gallery Tây Hồ View sáng nay cùng Tòa Mai F2 – Sun FourS Tower.\n👉 Nhận bảng giá · Zalo {sdt} · {ten}" };
function evPreset(e){
  if (!e || isContent(e) || !['2026-10-18', '2026-10-19'].includes(e.date) || !/18\/10|fours|f2/i.test(e.name || '')) return e;
  const P0 = EV_PRESET_1810, o = Object.assign({}, e, {date: P0.date, _preset: true});
  if (/^\s*\d{1,2}\/\d{1,2}(\/\d{2,4})?\s*$/.test(e.name || '')) o.name = P0.name; // tên chỉ là ngày → đặt tên rõ
  if (!e.postsCustom) { o.posts = P0.posts; o.libImgs = EV_LIB_FOURS; }
  if (!e.time || !/[–-]/.test(e.time)) o.time = P0.time;
  if (!e.place) o.place = P0.place; if (!e.perks) o.perks = P0.perks; if (!e.highlights) o.highlights = P0.highlights; if (!e.hashtags) o.hashtags = P0.hashtags;
  return o;
}
// Tên + SĐT của người đang xem (hồ sơ đội; chưa có SĐT thì lấy số sale tự nhập trên máy này)
const LS = {get: k => { try { return localStorage.getItem(k) || ''; } catch (_) { return ''; } }, set: (k, v) => { try { localStorage.setItem(k, v); } catch (_) {} }};
const myPhone = () => (byId(S.staff, ME.email) || {}).phone || LS.get('crm-phone:' + ME.email);
const myName = () => (byId(S.staff, ME.email) || {}).name || ME.name || '';
const evById = id => byId(S.events, id) || byId(S.contents || [], id);
const isContent = e => e && e.kind === 'content';
const contentNow = () => (S.contents || []).filter(c => (c.startDate || addD(c.date, -6)) <= today() && c.date >= today()); // content của tuần đang chạy // hiện các sự kiện trong 30 ngày tới
function evPosts(e){
  const out = {}, txt = String(e.posts || '').replace(/\r/g, ''); let key = null, buf = [];
  const flush = () => { if (key && buf.join('').trim()) out[key] = buf.join('\n').trim(); buf = []; };
  txt.split('\n').forEach(line => {
    // "17/10:" = bài 9h; "17/10 20h:" / "17/10 20:30:" = bài thêm trong ngày → khoá "2026-10-17@20:00"
    const slot = (h, mi) => { if (!h) return ''; const z = pad(Number(h)) + ':' + pad(Number(mi || 0)); return z === EV_POST_AT ? '' : '@' + z; };
    let m = /^\s*(\d{1,2})\/(\d{1,2})(?:\/\d{2,4})?(?:\s+(\d{1,2})\s*(?:h|:|giờ)\s*(\d{2})?)?\s*[:\-–]\s*(.*)$/iu.exec(line), k = null;
    if (m) { const y = Number(String(e.date).slice(0, 4)), mo = Number(m[2]); const yy = mo > Number(String(e.date).slice(5, 7)) + 1 ? y - 1 : y; k = yy + '-' + pad(mo) + '-' + pad(Number(m[1])) + slot(m[3], m[4]); m = [0, 0, 0, m[5]]; }
    else if ((m = /^\s*D\s*-\s*(\d{1,2})(?:\s+(\d{1,2})\s*(?:h|:|giờ)\s*(\d{2})?)?\s*[:\-–]\s*(.*)$/iu.exec(line))) { k = addD(e.date, -Number(m[1])) + slot(m[2], m[3]); m = [0, 0, 0, m[4]]; }
    let im = /^\s*(?:ảnh|anh|hình|hinh)\s*[:#]?\s*(\d{1,2})\s*(trái|phải|giữa)?\s*$/iu.exec(line), im2 = /^\s*(?:ảnh|anh|hình|hinh)\s*nhỏ\s*[:#]?\s*(\d{1,2})\s*$/iu.exec(line), tt = /^\s*tiêu đề\s*:\s*(.+)$/iu.exec(line);
    if (k) { flush(); key = k; buf = [m[3]]; } else if (im2 && key) out['im2:' + key] = Number(im2[1]); else if (im && key) { out['img:' + key] = Number(im[1]); if (im[2]) out['fx:' + key] = {'trái': 0, 'giữa': .5, 'phải': 1}[im[2].toLowerCase()]; }
    else if (tt && key) out['tt:' + key] = tt[1].trim();
    else if ((tt = /^\s*(điểm nhấn|câu|mẫu|nhãn|nút)\s*:\s*(.+)$/iu.exec(line)) && key) out[{'điểm nhấn': 'hl', 'câu': 'cau', 'mẫu': 'mau', 'nhãn': 'tag', 'nút': 'cta'}[tt[1].toLowerCase()] + ':' + key] = tt[2].trim();
    else if (key) buf.push(line);
  });
  flush(); return out;
}
function evAutoPost(e, day){
  const n = diffD(kDate(day), e.date), me = {name: myName(), phone: myPhone()}, pj = e.projectId ? projName(e.projectId) : '';
  const when = DOW[pd(e.date).getDay()] + ' ' + dm(e.date) + (e.time ? ' lúc ' + e.time : ''), where = e.place ? '\n📍 ' + e.place : '';
  const head = n <= 0 ? '🎉 HÔM NAY – ' + e.name.toUpperCase() : n === 1 ? '⏰ NGÀY MAI – ' + e.name.toUpperCase() : '🔥 CÒN ' + n + ' NGÀY – ' + e.name.toUpperCase();
  const body = [
    'Cơ hội gặp trực tiếp chủ đầu tư, nghe chính sách bán hàng mới nhất và chọn căn đẹp ngay tại sự kiện.',
    'Sự kiện có quà tặng cho khách tham dự, tư vấn 1–1 về giá, tiến độ thanh toán và hỗ trợ vay.',
    'Số ghế có hạn – anh/chị đăng ký sớm để em giữ chỗ và gửi thư mời nhé.',
    'Xem tận mắt sản phẩm, so sánh các căn đang mở bán và nhận ưu đãi chỉ áp dụng trong ngày sự kiện.'][Math.abs(n) % 4];
  const cta = n <= 0 ? 'Anh/chị đến muộn vẫn kịp – nhắn em để được đón tiếp nhé!' : 'Đăng ký tham dự: nhắn Zalo / gọi ' + (me.name || 'em') + (me.phone ? ' – ' + me.phone : '') + '.';
  return head + '\n📅 ' + when + where + (pj ? '\n🏢 Dự án ' + pj : '') + '\n\n' + body + '\n' + cta;
}
// Thông điệp của một ngày: bài quản lý nhập cho ngày đó, không có thì bài gợi ý tự tạo.
// {ten} {sdt} trong bài được thay bằng họ tên / số điện thoại của người đang xem (mỗi sale copy ra bài có số của mình).
// Trình bày bài cho dễ đọc khi đăng: tiêu đề – đoạn mở – các ý – địa điểm/giờ – liên hệ, mỗi nhóm cách 1 dòng; SĐT tách nhóm số.
const evPhone = x => { const d = String(x).replace(/\D/g, ''); return d.length === 10 ? d.replace(/(\d{4})(\d{3})(\d{3})/, '$1 $2 $3') : String(x).trim(); };
function evTidy(txt, e){ const EMO = /^\p{Extended_Pictographic}/u, ls = [];
  String(txt).split('\n').map(x => x.trim()).filter(Boolean).forEach((x, i) => {
    if (i && EMO.test(x) && / · \p{Extended_Pictographic}/u.test(x)) x.split(/ · (?=\p{Extended_Pictographic})/u).forEach(y => ls.push(y)); else ls.push(x); });
  const hasTime = ls.some(x => /^🕘/u.test(x)), out = [];
  // Địa điểm + giờ lấy chuẩn từ thông tin sự kiện: tên nơi, địa chỉ, giờ bắt đầu – kết thúc, thứ, ngày/tháng/năm.
  let locDone = false; const pl = e && String(e.place || '').trim(), [pn, pa] = pl ? pl.split(/\s+[–-]\s+/).concat('') : [];
  const locBlock = () => { if (locDone) return; locDone = true; const [y, mo, d] = e.date.split('-');
    out.push(['loc', '📍 Địa điểm: ' + pn]); if (pa) out.push(['loc', '🏠 Địa chỉ: ' + pa]);
    const tm = String(e.time || '').match(/(\d{1,2})[:h](\d{2})?/), H = tm ? +tm[1] : -1, M = tm ? +(tm[2] || 0) : 0;
    const gio = H < 0 ? '' : (H > 12 ? H - 12 : H) + ' giờ' + (M ? ' ' + String(M).padStart(2, '0') : '') + ' ' + (H < 11 ? 'sáng' : H < 13 ? 'trưa' : H < 18 ? 'chiều' : 'tối') + ', ';
    out.push(['loc', '🕘 Thời gian: ' + gio + DOW[pd(e.date).getDay()] + ' ' + +d + '/' + +mo]); };
  ls.forEach((x, i) => {
    let m = x.match(/^👉\s*([^·]+?)\s*·\s*Zalo\s*([^·]+?)\s*·\s*(.+)$/u);
    if (m) { out.push(['cta', '👉 ' + m[1] + (/giữ chỗ/i.test(m[1]) ? ' tham dự' : '') + ': nhắn Zalo hoặc gọi'], ['cta', '📞 ' + evPhone(m[2]) + ' – ' + m[3]]); return; }
    if (pl && e.date && i && /^(📍|🕘)/u.test(x)) { locBlock(); return; }
    m = !hasTime && x.match(/^📍\s*([^·]+?)\s*·\s*(.+)$/u);
    if (m) { out.push(['loc', '📍 Địa điểm: ' + m[1]], ['loc', '🕘 Thời gian: ' + m[2]]); return; }
    out.push([!i ? 'h' : /^#/.test(x) ? 'tag' : /^(📍|🕘|☕|🎁|📅)/u.test(x) ? 'loc' : /^(👉|📞)/u.test(x) ? 'cta' : EMO.test(x) ? 'pt' : 'txt', x]); });
  return out.map(([k, x], i) => (i && (k !== out[i - 1][0] || k === 'txt') ? '\n' : '') + x).join('\n'); }
function evPostFor(e, day){ const own = evPosts(e), tag = String(e.hashtags || '').trim();
  const fill = x => x.replace(/\{ten\}/gi, myName() || 'em').replace(/\{sdt\}/gi, myPhone() || '(số điện thoại của bạn)');
  const withTags = x => tag && !x.includes(tag.split(/\s+/)[0]) ? x + '\n\n' + tag : x; // hashtag gắn cuối mỗi bài
  return own[day] ? {txt: withTags(evTidy(fill(own[day]), e)), own: true} : {txt: withTags(evAutoPost(e, day)), own: false}; }
function evPostDays(e){ const t = today(), own = Object.keys(evPosts(e)).filter(k => /^\d{4}-\d{2}-\d{2}(@|$)/.test(k)), auto = [];
  if (!own.length && !isContent(e)) for (let d = addD(e.date, -6); d <= e.date; d = addD(d, 1)) auto.push(d); // chưa nhập bài: gợi ý 6 ngày trước sự kiện
  return [...new Set(own.concat(auto))].filter(d => kDate(d) >= t && kDate(d) <= e.date).sort(); }
const EV_MAX_IMG = 5;
const EV_POST_AT = '09:00'; // giờ đăng bài sự kiện mỗi ngày
const evPostDone = (eid, sid, k) => S.activities.some(a => a.type === 'evpost' && a.eventId === eid && a.date === today() && a.staffId === sid && (a.slot || a.date) === (k || today()));
const evSlotsToday = e => evPostDays(e).filter(k => kDate(k) === today()); // các bài của hôm nay (9h, 20h…)
const evPostToday = () => S.events.concat(S.contents || []).filter(e => evSlotsToday(e).length);
// Thư viện ảnh có sẵn trên CRM (file trong bh-img/su-kien/, không tốn dung lượng dữ liệu): chọn ở form sự kiện.
const EV_LIB = [['bh-img/su-kien/tay-ho-view-ban-ngay.jpg','Sun Gallery Tây Hồ View – ban ngày'],['bh-img/su-kien/tay-ho-view-ban-dem.jpg','Tây Hồ View – ban đêm'],
  ['bh-img/su-kien/tay-ho-view-hoang-hon.jpg','Tây Hồ View – hoàng hôn'],['bh-img/su-kien/tay-ho-view-ascott.jpg','Tây Hồ View – Ascott'],['bh-img/su-kien/fours-tower-f2-view-bien.jpg','Tòa F2 FourS – view biển'],['bh-img/su-kien/fours-tower-toan-canh-dem.jpg','FourS Tower – toàn cảnh đêm'],
  ['bh-img/su-kien/fours-hoang-hon-bien.jpg','FourS – hoàng hôn biển'],['bh-img/su-kien/fours-thap-view-bien.jpg','FourS – tháp view biển nắng'],['bh-img/su-kien/fours-binh-minh-vuon-hoa.jpg','FourS – bình minh vườn hoa'],
  ['bh-img/su-kien/fours-chieu-vang-nui.jpg','FourS – chiều vàng, núi'],['bh-img/su-kien/fours-dai-lo-song-han.jpg','FourS – đại lộ, sông Hàn']];
const EV_LIB_FOURS = EV_LIB.map(x => x[0]); // ảnh của sự kiện FourS 18/10
EV_LIB.push(...SAPHIA_LIB); // ảnh Sun Saphia thêm vào cuối → số thứ tự ảnh FourS giữ nguyên
const saphiaMissing = () => SAPHIA_CONTENT.filter(p => !(S.contents || []).some(c => c.seedKey === p.key || (c.startDate === p.startDate && /saphia/i.test(c.name || ''))));
const evLibSel = e => EV_LIB.map(x => x[0]).filter(u => ((e && e.libImgs) || []).includes(u)); // luôn theo thứ tự thư viện → số thứ tự ảnh cố định
const evImgs = e => [].concat(evLibSel(e), e.posters || [], e.poster ? [e.poster] : [], e.posterUrl ? String(e.posterUrl).split(/\s+/).filter(u => /^https:\/\//i.test(u)) : []).filter(Boolean);
// Ảnh của một ngày: dòng "ảnh: 3" trong bài ngày đó (số thứ tự ảnh ở Tổng quan), không có thì xoay vòng mỗi ngày một ảnh.
const evImgFor = (e, day) => { const im = evImgs(e); if (!im.length) return ''; const pick = evPosts(e)['img:' + day]; return pick && im[pick - 1] ? im[pick - 1] : im[Math.abs(diffD(kDate(day), e.date) * 2 + (kTime(day) > '12:00' ? 1 : 0)) % im.length]; };
/* Ảnh đăng của từng sale: ảnh sự kiện + dải phía dưới có tiêu đề bài của ngày đó và tên, số điện thoại người đang xem. */
const EV_BRAND = new Map(); // cache: ảnh|ngày|người → dataURL
const EV_READY = {}; // sự kiện|ngày|ảnh → dataURL đã ghép xong (dùng ngay khi bấm Tải – iPhone cần chia sẻ trong cùng lần chạm)
const IOS_DEV = /iPad|iPhone|iPod/.test(navigator.userAgent) || (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);
const dataBlob = u => { const [h, b] = String(u).split(','), bin = atob(b), a = new Uint8Array(bin.length); for (let i = 0; i < bin.length; i++) a[i] = bin.charCodeAt(i); return new Blob([a], {type: (h.match(/data:([^;]+)/) || [])[1] || 'image/jpeg'}); };
// iPhone/iPad: thẻ <a download> không lưu được ảnh → mở bảng Chia sẻ (Lưu hình ảnh / Zalo…); không được thì hiện ảnh to để nhấn giữ → Lưu vào Ảnh
function evImgView(u, name){ let o = document.getElementById('evImgView'); if (o) o.remove();
  o = document.createElement('div'); o.id = 'evImgView'; o.style.cssText = 'position:fixed;inset:0;z-index:9999;background:rgba(10,8,5,.92);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:12px;padding:16px';
  o.innerHTML = `<img src="${u}" alt="Ảnh bài đăng" style="max-width:100%;max-height:72vh;border-radius:10px;box-shadow:0 8px 30px rgba(0,0,0,.5);-webkit-touch-callout:default"><div style="color:#fff;font-size:15px;text-align:center;line-height:1.5"><b>Nhấn giữ vào ảnh → “Lưu vào Ảnh”</b><br><span style="opacity:.8;font-size:13px">hoặc bấm Chia sẻ → Lưu hình ảnh / gửi Zalo</span></div><div style="display:flex;gap:10px">${navigator.share ? '<button type="button" class="btn pri" id="evIvShare">📤 Chia sẻ / Lưu ảnh</button>' : ''}<button type="button" class="btn" id="evIvClose">Đóng</button></div>`;
  document.body.appendChild(o);
  o.querySelector('#evIvClose').onclick = () => o.remove(); o.onclick = ev => { if (ev.target === o) o.remove(); };
  const sh = o.querySelector('#evIvShare'); if (sh) sh.onclick = () => { const f = new File([dataBlob(u)], name, {type: 'image/jpeg'}); (navigator.canShare && navigator.canShare({files: [f]}) ? navigator.share({files: [f]}) : Promise.reject()).catch(err => { if (!err || err.name !== 'AbortError') toast('Nhấn giữ vào ảnh để lưu'); }); }; }
function evSaveImg(u, name){
  if (!IOS_DEV) { const l = document.createElement('a'); l.href = u; l.download = name; document.body.appendChild(l); l.click(); l.remove(); return; }
  try { const f = new File([dataBlob(u)], name, {type: 'image/jpeg'});
    if (navigator.canShare && navigator.canShare({files: [f]})) { navigator.share({files: [f]}).catch(err => { if (!err || err.name !== 'AbortError') evImgView(u, name); }); return; } } catch (e) {}
  evImgView(u, name); }
function evBrand(e, day, src){
  const name = myName(), phone = myPhone();
  const post = evPostFor(e, day).txt, head = (post.split('\n')[0] || e.name).trim();
  // ảnh ghép: ảnh của ngày + 2 ảnh kế tiếp trong danh sách
  const all = evImgs(e), at = Math.max(0, all.indexOf(src)), srcs = [src].concat(all.length > 1 ? [all[(at + 1) % all.length]] : [], all.length > 2 ? [all[(at + 2) % all.length]] : []).filter((u, k, a) => a.indexOf(u) === k);
  const key = [srcs.map(u => u.slice(0, 60) + u.length).join(','), day, name, phone, post, e.posts || '', e.perks || '', e.highlights || '', e.place || '', e.time || '', evImgs(e).length].join('|');
  if (EV_BRAND.has(key)) return EV_BRAND.get(key);
  const load = u => new Promise((ok, bad) => { const m = new Image(); if (/^https?:/i.test(u) && !u.startsWith(location.origin)) m.crossOrigin = 'anonymous';
    m.onload = () => ok(m); m.onerror = () => bad(new Error('Không tải được ảnh')); m.src = u; });
  const job = (async () => {
    const PO = evPosts(e), all2 = evImgs(e), pick2 = PO['im2:' + day];
    // ảnh nhỏ (nơi tổ chức): dòng "ảnh nhỏ: N" của ngày, mặc định ảnh Sun Gallery ban ngày nếu có, không thì ảnh kế tiếp
    const small = (pick2 && all2[pick2 - 1]) || all2.find(u => /tay-ho-view-ban-ngay/.test(u)) || all2.find(u => u !== src) || '';
    const [hero, inset] = await Promise.all([load(src), small && small !== src ? load(small).catch(() => null) : Promise.resolve(null)]);
    const SER = '"Playfair Display", Georgia, serif', SAN = getComputedStyle(document.body).fontFamily || 'sans-serif';
    try { await Promise.all(['700 70px "Playfair Display"', '800 30px "Be Vietnam Pro"', '600 30px "Be Vietnam Pro"', '500 26px "Be Vietnam Pro"'].map(f => document.fonts.load(f))); } catch (_) {}
    const W = 1080, H = 1350, P = 56, NAVY = '#0c1a3a', ORG = '#f5821f', ORL = '#f7a35c', c = document.createElement('canvas'), x = c.getContext('2d'); c.width = W; c.height = H;
    const rr = (X, Y, w, h, r) => { x.beginPath(); if (x.roundRect) x.roundRect(X, Y, w, h, r); else x.rect(X, Y, w, h); };
    const cover = (im, X, Y, w, h, r, fx = .5) => { x.save(); rr(X, Y, w, h, r); x.clip(); const k = Math.max(w / im.width, h / im.height), iw = im.width * k, ih = im.height * k; x.drawImage(im, X + (w - iw) * fx, Y + (h - ih) / 2, iw, ih); x.restore(); };
    const fit = (t, font, size, max) => { let z = size; do { x.font = font.replace('#', z); z -= 2; } while (x.measureText(t).width > max && z > 20); return x.font; };
    const GOLD = '#f7c948', GOLD2 = '#f5a524';
    // hoa mai 5 cánh
    const mai = (cx, cy, r, rot = 0, a = 1) => { x.save(); x.globalAlpha = a; x.translate(cx, cy); x.rotate(rot);
      for (let i = 0; i < 5; i++) { x.save(); x.rotate(i * Math.PI * 2 / 5); const g2 = x.createRadialGradient(0, -r * .55, r * .1, 0, -r * .55, r * .7); g2.addColorStop(0, '#fde68a'); g2.addColorStop(1, GOLD2);
        x.beginPath(); x.ellipse(0, -r * .55, r * .42, r * .58, 0, 0, Math.PI * 2); x.fillStyle = g2; x.shadowColor = 'rgba(0,0,0,.25)'; x.shadowBlur = r * .25; x.fill(); x.restore(); }
      x.beginPath(); x.arc(0, 0, r * .22, 0, Math.PI * 2); x.fillStyle = '#c2410c'; x.fill();
      x.strokeStyle = '#9a3412'; x.lineWidth = Math.max(1, r * .04); for (let i = 0; i < 10; i++) { const an = i * Math.PI / 5; x.beginPath(); x.moveTo(0, 0); x.lineTo(Math.cos(an) * r * .42, Math.sin(an) * r * .42); x.stroke();
        x.beginPath(); x.arc(Math.cos(an) * r * .44, Math.sin(an) * r * .44, r * .045, 0, Math.PI * 2); x.fillStyle = '#7c2d12'; x.fill(); } x.restore(); };
    // cành mai góc trên phải
    const branch = (ox, oy, sc = 1) => { x.save(); x.translate(ox, oy); x.scale(sc, sc); x.strokeStyle = '#5b3a1e'; x.lineCap = 'round';
      x.lineWidth = 10; x.beginPath(); x.moveTo(140, -20); x.bezierCurveTo(60, 60, -60, 70, -230, 40); x.stroke();
      x.lineWidth = 6; x.beginPath(); x.moveTo(20, 55); x.quadraticCurveTo(-10, 120, -60, 160); x.stroke(); x.beginPath(); x.moveTo(-110, 58); x.quadraticCurveTo(-160, 10, -200, -10); x.stroke();
      [[-230, 40, 30, .2], [-160, 52, 38, .9], [-70, 62, 44, .4], [10, 40, 34, 1.3], [-60, 160, 32, .7], [-200, -10, 24, 1.1], [90, 20, 26, .3], [-20, 118, 22, 1.6]].forEach(([fx, fy, fr, ro]) => mai(fx, fy, fr, ro));
      [[-120, 30, 9], [-25, 95, 8], [55, 70, 7]].forEach(([bx2, by2, br]) => { x.beginPath(); x.arc(bx2, by2, br, 0, Math.PI * 2); x.fillStyle = '#e9a23b'; x.fill(); }); x.restore(); };
    const frame = () => { x.save(); x.strokeStyle = 'rgba(247,201,72,.55)'; x.lineWidth = 2; rr(22, 22, W - 44, H - 44, 26); x.stroke(); x.restore(); };
    const kicker = (t, X, Y) => { x.save(); x.font = `800 24px ${SAN}`; x.fillStyle = GOLD; if ('letterSpacing' in x) x.letterSpacing = '4px'; x.fillText(t, X + 44, Y); x.fillRect(X, Y - 1, 30, 3); x.restore(); };
    const goldText = (t, X, Y, font) => { x.font = font; const w2 = x.measureText(t).width; const gr = x.createLinearGradient(X, Y - 40, X + w2, Y + 40); gr.addColorStop(0, '#fde68a'); gr.addColorStop(.5, GOLD); gr.addColorStop(1, GOLD2); x.fillStyle = gr; x.fillText(t, X, Y); };
    const ctaPill = (t, Y, h) => { const gr = x.createLinearGradient(P, 0, W - P, 0); gr.addColorStop(0, GOLD2); gr.addColorStop(1, '#ea580c'); rr(P, Y, W - P * 2, h, h / 2); x.fillStyle = gr; x.shadowColor = 'rgba(0,0,0,.35)'; x.shadowBlur = 18; x.fill(); x.shadowBlur = 0;
      x.fillStyle = '#fff'; x.textAlign = 'center'; x.font = fit(t, `800 #px ${SAN}`, 38, W - P * 2 - 60); x.fillText(t, W / 2, Y + h / 2 + 2); x.textAlign = 'left'; };
    const nD = diffD(kDate(day), e.date), mau = String(PO['mau:' + day] || '').toLowerCase();
    if (isContent(e) || (mau ? /cảm xúc|cam xuc|life/.test(mau) : nD >= 2)) { // mẫu "cảm xúc": ảnh tràn khung, tiêu đề lớn, tem điểm nhấn
      x.fillStyle = NAVY; x.fillRect(0, 0, W, H); cover(hero, 0, 0, W, 1060, 0, PO['fx:' + day] ?? .5);
      let gg = x.createLinearGradient(0, 0, 0, 240); gg.addColorStop(0, 'rgba(12,26,58,.6)'); gg.addColorStop(1, 'rgba(12,26,58,0)'); x.fillStyle = gg; x.fillRect(0, 0, W, 240);
      gg = x.createLinearGradient(0, 560, 0, 1060); gg.addColorStop(0, 'rgba(12,26,58,0)'); gg.addColorStop(.55, 'rgba(12,26,58,.72)'); gg.addColorStop(1, NAVY); x.fillStyle = gg; x.fillRect(0, 560, W, 500);
      x.textBaseline = 'middle';
      const dd = pd(e.date), tg = PO['tag:' + day] ? PO['tag:' + day].toUpperCase() : isContent(e) ? String(e.tagline || (e.projectId ? projName(e.projectId) : 'Sun FourS Tower · Đà Nẵng')).toUpperCase() : 'THƯ MỜI · ' + DOW[dd.getDay()].toUpperCase() + ' ' + dm(e.date) + '/' + dd.getFullYear();
      x.font = `800 28px ${SAN}`; let w0 = x.measureText(tg).width + 50; rr(P, 48, w0, 58, 29); const tgG = x.createLinearGradient(P, 0, P + w0, 0); tgG.addColorStop(0, GOLD2); tgG.addColorStop(1, '#ea580c'); x.fillStyle = tgG; x.fill(); x.fillStyle = '#fff'; x.fillText(tg, P + 25, 78);
      if (nD >= 1 && !PO['tag:' + day] && !isContent(e)) { const cd2 = nD === 1 ? 'Ngày mai' : 'Còn ' + nD + ' ngày'; x.font = `800 24px ${SAN}`; const cw2 = x.measureText(cd2).width + 36; rr(P, 120, cw2, 48, 24); x.fillStyle = 'rgba(12,26,58,.85)'; x.fill(); x.strokeStyle = GOLD; x.lineWidth = 2; x.stroke(); x.fillStyle = GOLD; x.fillText(cd2, P + 18, 145); }
      // tem tròn điểm nhấn: dòng "điểm nhấn: 0% | lãi 24 tháng" của ngày, không có thì lấy lần lượt ô nổi bật
      const his = String(e.highlights || '').split('\n').map(l => l.split('|').map(z => z.trim())).filter(z => z[0]);
      const hl = PO['hl:' + day] ? PO['hl:' + day].split('|').map(z => z.trim()) : his.length ? his[Math.abs(nD) % his.length] : null;
      if (hl) { const cx = W - P - 140, cy = 340, R = 128; x.save(); x.translate(cx, cy); x.shadowColor = 'rgba(0,0,0,.35)'; x.shadowBlur = 26;
        x.beginPath(); for (let k = 0; k < 5; k++) { const an = -Math.PI / 2 + k * Math.PI * 2 / 5; x.moveTo(0, 0); x.arc(Math.cos(an) * R * .48, Math.sin(an) * R * .48, R * .56, 0, Math.PI * 2); }
        const sg = x.createRadialGradient(0, 0, R * .2, 0, 0, R * 1.05); sg.addColorStop(0, '#fde68a'); sg.addColorStop(.6, GOLD); sg.addColorStop(1, GOLD2); x.fillStyle = sg; x.fill(); x.restore();
        x.textAlign = 'center'; x.fillStyle = '#7c2d12'; x.font = fit(hl[0], `900 #px ${SAN}`, 64, R * 1.5); x.fillText(hl[0], cx, cy - 16);
        const sub = (hl[1] || '').split(/\s+/), mid = Math.ceil(sub.length / 2); x.font = `800 22px ${SAN}`; x.fillStyle = '#7c2d12';
        [sub.slice(0, mid).join(' '), sub.slice(mid).join(' ')].filter(Boolean).forEach((l, k) => x.fillText(l, cx, cy + 34 + k * 26, R * 1.5)); x.textAlign = 'left'; }
      if (!isContent(e) || /mai/i.test(e.kicker || '')) branch(W - 150, 20, 1.05); // cành mai: sự kiện F2, hoặc content có dòng nhỏ chứa “Mai”
      // tiêu đề lớn + câu thông điệp
      const pj2 = e.projectId ? projName(e.projectId) : '', tts = String(PO['tt:' + day] || '').split('|').map(z => z.trim()).filter(Boolean);
      const a1 = tts[0] || 'Căn nhà bên biển Đà Nẵng', a2 = tts[1] || (pj2 && pj2 !== '—' ? pj2 : e.name);
      kicker(String(e.kicker || 'TÒA MAI F2 · THÁP BỐN MÙA').toUpperCase(), P, 760);
      x.shadowColor = 'rgba(0,0,0,.5)'; x.shadowBlur = 20;
      x.fillStyle = '#fff'; x.font = fit(a1, `700 #px ${SER}`, 92, W - P * 2); x.fillText(a1, P, 840);
      goldText(a2, P, 932, fit(a2, `700 #px ${SER}`, 80, W - P * 2)); x.shadowBlur = 0;
      const body = post.split('\n').slice(1).map(l => l.trim()).filter(l => l && !/\{?(sdt|ten)\}?|zalo|gọi|nhắn|đăng ký|giữ chỗ|📅|📍|☕/i.test(l) && !(phone && l.includes(phone)));
      const cau = (PO['cau:' + day] || body[0] || '').replace(/^[•✅\-\s]+/, '');
      if (cau) { x.fillStyle = '#e8edf7'; x.font = `500 30px ${SAN}`; const ws = []; let ln = ''; cau.split(/\s+/).forEach(w => { const z = ln ? ln + ' ' + w : w; if (x.measureText(z).width > W - P * 2 && ln) { ws.push(ln); ln = w; } else ln = z; }); if (ln) ws.push(ln);
        ws.slice(0, 2).forEach((l, i) => x.fillText(i === 1 && ws.length > 2 ? l.replace(/[\s,.;:–-]*$/, '') + '…' : l, P, 1010 + i * 42)); }
      // dòng địa điểm nhỏ + nút liên hệ
      const pl = String(e.place || '').split(/\s+[–-]\s+/)[0], info = isContent(e) ? '📍 ' + (e.place || (e.projectId ? projName(e.projectId) : 'Sun FourS Tower · Nam Đà Nẵng')) : PO['tag:' + day] ? '📍 ' + (pl || e.name) + '  ·  Sun FourS Tower · Đà Nẵng' : '📍 ' + (pl || e.name) + '  ·  ' + DOW[dd.getDay()] + ' ' + dm(e.date) + (e.time ? ' · ' + e.time.split(/\s*[–-]\s*/)[0] : '');
      rr(P, 1112, W - P * 2, 64, 32); x.fillStyle = 'rgba(255,255,255,.07)'; x.fill(); x.strokeStyle = 'rgba(247,201,72,.6)'; x.lineWidth = 2; x.stroke();
      x.fillStyle = GOLD; x.textAlign = 'center'; x.font = fit(info, `700 #px ${SAN}`, 27, W - P * 2 - 40); x.fillText(info, W / 2, 1145);
      const ct = (PO['cta:' + day] || (isContent(e) ? 'Tư vấn' : 'Giữ chỗ')) + ' · Zalo ' + (phone || '…') + (name ? ' · ' + name : '');
      x.textAlign = 'left'; ctaPill(ct, 1200, 88);
      x.fillStyle = 'rgba(255,255,255,.45)'; x.font = `400 18px ${SAN}`; x.textAlign = 'center'; x.fillText(isContent(e) ? 'Hình ảnh minh họa' : 'Hình ảnh minh họa · Số chỗ có hạn', W / 2, 1316); x.textAlign = 'left'; frame();
      return c.toDataURL('image/jpeg', .9);
    }
    x.fillStyle = NAVY; x.fillRect(0, 0, W, H);
    // ảnh lớn + phủ màu dần xuống
    const HH = 780; cover(hero, 0, 0, W, HH, 0, PO['fx:' + day] ?? .5);
    let g = x.createLinearGradient(0, 0, 0, 200); g.addColorStop(0, 'rgba(12,26,58,.55)'); g.addColorStop(1, 'rgba(12,26,58,0)'); x.fillStyle = g; x.fillRect(0, 0, W, 200);
    g = x.createLinearGradient(0, 360, 0, HH); g.addColorStop(0, 'rgba(12,26,58,0)'); g.addColorStop(.6, 'rgba(12,26,58,.78)'); g.addColorStop(1, NAVY); x.fillStyle = g; x.fillRect(0, 360, W, HH - 360);
    x.textBaseline = 'middle';
    // nhãn trên
    const d = pd(e.date), n = diffD(kDate(day), e.date), tag = PO['tag:' + day] ? PO['tag:' + day].toUpperCase() : 'THƯ MỜI · ' + DOW[d.getDay()].toUpperCase() + ' ' + dm(e.date) + '/' + d.getFullYear();
    x.font = `800 30px ${SAN}`; let tw = x.measureText(tag).width + 50; rr(P, 48, tw, 60, 30); x.fillStyle = ORG; x.fill(); x.fillStyle = '#fff'; x.fillText(tag, P + 25, 79);
    const cd = n <= 0 ? 'Hôm nay ' + (e.time || '').split(/\s*[–-]\s*/)[0] : n === 1 ? 'Ngày mai' : 'Còn ' + n + ' ngày'; x.font = `700 26px ${SAN}`; tw = x.measureText(cd).width + 40;
    rr(P, 120, tw, 50, 25); x.fillStyle = 'rgba(12,26,58,.9)'; x.fill(); x.strokeStyle = GOLD; x.lineWidth = 2; x.stroke(); x.fillStyle = GOLD; x.fillText(cd, P + 20, 146); branch(W - 120, 10, .8);
    // tiêu đề 2 dòng của ngày: "tiêu đề: dòng trắng | dòng cam"; chưa có thì lấy tên dự án / sự kiện
    const pj = e.projectId ? projName(e.projectId) : '', tt = String(PO['tt:' + day] || '').split('|').map(z => z.trim()).filter(Boolean);
    const t1 = tt[0] || 'Căn nhà bên biển Đà Nẵng', t2 = tt[1] || (pj && pj !== '—' ? pj : e.name);
    x.shadowColor = 'rgba(0,0,0,.45)'; x.shadowBlur = 16;
    x.fillStyle = '#fff'; x.font = fit(t1, `700 #px ${SER}`, 78, W - P * 2); x.fillText(t1, P, 600);
    goldText(t2, P, 678, fit(t2, `700 #px ${SER}`, 70, W - P * 2)); x.shadowBlur = 0; kicker('TÒA MAI F2 · THÁP BỐN MÙA', P, 532);
    // ô ảnh nơi tổ chức
    const IX = P, IY = 718, IW = 390, IHt = 362;
    const parts = String(e.place || '').split(/\s+[–-]\s+/), venue = parts[0] || e.name, addr = parts.slice(1).join(' – '), city = (addr.split(',').pop() || '').trim();
    if (inset) { cover(inset, IX, IY, IW, IHt, 20); rr(IX, IY, IW, IHt, 20); x.strokeStyle = ORG; x.lineWidth = 4; x.stroke();
      if (city) { const cap = 'Nơi tổ chức tại ' + city; x.font = `600 22px ${SAN}`; const cw = x.measureText(cap).width + 30; rr(IX + 14, IY + IHt - 54, cw, 40, 20); x.fillStyle = 'rgba(12,26,58,.88)'; x.fill(); x.fillStyle = '#fff'; x.fillText(cap, IX + 29, IY + IHt - 34); } }
    // khối địa điểm
    const RX = inset ? IX + IW + 34 : P, RW = W - P - RX; let y = 740;
    x.fillStyle = ORL; x.font = `800 23px ${SAN}`; x.fillText('ĐỊA ĐIỂM SỰ KIỆN', RX, y); y += 66;
    const vw = venue.split(/\s+/), cut = vw.length > 2 ? Math.ceil(vw.length / 2) - (vw.length === 4 ? 0 : 0) : vw.length, v1 = vw.slice(0, Math.min(2, cut)).join(' '), v2 = vw.slice(Math.min(2, cut)).join(' ');
    x.fillStyle = '#fff'; x.font = fit(v1, `700 #px ${SER}`, 60, RW); x.fillText(v1, RX, y); y += 66;
    if (v2) { x.fillStyle = ORL; x.font = fit(v2, `700 #px ${SER}`, 60, RW); x.fillText(v2, RX, y); y += 56; }
    if (addr) { x.fillStyle = '#fff'; x.font = fit(addr, `700 #px ${SAN}`, 29, RW); x.fillText(addr, RX, y); y += 44; }
    const when = DOW[d.getDay()] + ' ' + dm(e.date) + (e.time ? ' · ' + e.time : ''); x.fillStyle = '#d6dcea'; x.font = fit(when, `600 #px ${SAN}`, 28, RW); x.fillText(when, RX, y); y += 40;
    if (e.perks) { x.fillStyle = '#b9c2d8'; x.font = fit(e.perks, `500 #px ${SAN}`, 25, RW); x.fillText(e.perks, RX, y); }
    // 3 ô số liệu
    const hi = String(e.highlights || '').split('\n').map(l => l.split('|').map(z => z.trim())).filter(z => z[0]).slice(0, 3);
    if (hi.length) { const by = 1108, gap = 16, bw = (W - P * 2 - gap * (hi.length - 1)) / hi.length;
      hi.forEach(([v, l], i) => { const bx = P + i * (bw + gap); rr(bx, by, bw, 110, 16); x.fillStyle = 'rgba(255,255,255,.05)'; x.fill(); x.strokeStyle = 'rgba(247,201,72,.55)'; x.lineWidth = 2; x.stroke();
        x.textAlign = 'center'; x.fillStyle = ORL; x.font = `800 44px ${SAN}`; x.fillText(v, bx + bw / 2, by + 42, bw - 20); x.fillStyle = '#d6dcea'; x.font = `500 21px ${SAN}`; x.fillText(l || '', bx + bw / 2, by + 84, bw - 20); x.textAlign = 'left'; }); }
    // nút liên hệ của sale
    const cta = (PO['cta:' + day] || 'Giữ chỗ') + ' · Zalo ' + (phone || '…') + (name ? ' · ' + name : '');
    ctaPill(cta, 1240, 82); frame();
    return c.toDataURL('image/jpeg', .9);
  })();
  job.then(u => { EV_READY[e.id + '|' + day + '|' + src] = u; }, () => {});
  job.catch(() => EV_BRAND.delete(key)); EV_BRAND.set(key, job); return job;
}
// Sau khi vẽ Tổng quan: thay ảnh xem trước bằng ảnh đã gắn tên + SĐT của người đang xem.
function evBrandPreviews(){ document.querySelectorAll('img[data-brand-e]').forEach(img => { const e = evById(img.dataset.brandE); if (!e) return;
  evBrand(e, img.dataset.brandD, img.dataset.brandSrc).then(u => { if (img.isConnected) img.src = u; }, () => {}); }); }
function evPromo(){
  const t = today(), evs = S.events.filter(e => e.date >= t && diffD(t, e.date) <= EV_PROMO_DAYS).slice(0, 3);
  if (!evs.length) return '';
  return `<div class="panel evp-wrap"><h2>🎉 Sự kiện sắp tới <span>ảnh + bài đăng mỗi ngày cho cả đội</span></h2>` + evs.map(evCard).join('') + '</div>' + (setTimeout(evBrandPreviews, 0), '');
}
// Thẻ bài đăng hôm nay của một sự kiện / một content tuần
function evCard(e){ const t = today();
    const n = diffD(t, e.date), days = evPostDays(e), slots = evSlotsToday(e), isDay = slots.length > 0, all = evImgs(e);
    const cur = slots.find(k => kTime(k) >= nowHM()) || slots[slots.length - 1], img = isDay ? evImgFor(e, cur) : ''; // ảnh xem trước: bài sắp tới gần nhất
    const one = k => { const p = evPostFor(e, k), im = evImgFor(e, k), done = evPostDone(e.id, ME.email, k), late = nowHM() >= kTime(k);
      return `<div class="evp-slot"><div class="evp-lab">Bài ${kLab(k)} hôm nay ${dm(t)}${p.own ? '' : ' <span class="muted">(gợi ý tự tạo – quản lý sửa ở form sự kiện)</span>'}</div>
      <pre class="evp-post">${esc(p.txt)}</pre>
      <div class="row evp-9h">${meReporter() || meSeller() ? (done ? `<span class="chip c-ok">✓ Bạn đã đăng bài ${kLab(k)}</span>` : `<span class="chip ${late ? 'c-bad' : 'c-warn'}">${late ? 'Quá ' + kLab(k) + ' – chưa đăng' : 'Đăng lúc ' + kLab(k)}</span><button class="btn sm" data-a="evPostMark" data-id="${esc(e.id)}" data-k="${k}">Đã đăng bài ${kLab(k)}</button>`) : ''}${MANAGER ? `<span class="chip c-info">${reporters().filter(x => evPostDone(e.id, x.id, k)).length}/${reporters().length} người đã đăng bài ${kLab(k)}</span>` : ''}</div>
      <div class="row"><button class="btn sm pri" data-a="evPostCopy" data-id="${esc(e.id)}" data-k="${k}">Copy bài ${kLab(k)}</button>${im ? `<button class="btn sm" data-a="evPosterDl" data-id="${esc(e.id)}" data-k="${all.indexOf(im)}" data-d="${k}">Tải ảnh bài ${kLab(k)} (có tên + SĐT)</button>` : ''}</div></div>`; };
    return `<div class="evp${img ? '' : ' evp-1'}">${img ? `<div class="evp-media"><a class="evp-img" role="button" tabindex="0" style="cursor:pointer" data-a="evPosterDl" data-id="${esc(e.id)}" data-k="${all.indexOf(img)}" data-d="${cur}" title="Tải ảnh có tên và số điện thoại của bạn"><img src="${esc(img)}" alt="Ảnh sự kiện ${esc(e.name)}" data-brand-e="${esc(e.id)}" data-brand-d="${cur}" data-brand-src="${esc(img)}"></a>${slots.length > 1 ? `<div class="muted" style="font-size:12px;margin-top:4px">Ảnh bài ${kLab(cur)}</div>` : ''}<button type="button" class="btn pri evp-dl" data-a="evPosterDl" data-id="${esc(e.id)}" data-k="${all.indexOf(img)}" data-d="${cur}">⬇ Tải ảnh về <small>(có tên + SĐT của bạn)</small></button>${all.length > 1 ? `<details class="evp-alt"><summary>Chọn ảnh khác (${all.length - 1})</summary><div class="evp-thumbs">${all.map((u, i) => u === img ? '' : `<button type="button" class="evp-th" data-a="evPosterDl" data-id="${esc(e.id)}" data-k="${i}" data-d="${cur}" title="Tải ảnh ${i + 1} (có tên + SĐT của bạn)"><img src="${esc(u)}" alt="Ảnh ${i + 1}" loading="lazy"><i>${i + 1}</i></button>`).join('')}</div></details>` : ''}</div>` : ''}
      <div class="evp-body"><div class="row" style="justify-content:space-between"><b class="evp-t">${esc(e.name)}</b>${isContent(e) ? `<span class="chip c-info">Tuần ${dm(e.startDate || addD(e.date, -6))} – ${dm(e.date)}</span>` : `<span class="chip ${n <= 1 ? 'c-bad' : n <= 3 ? 'c-warn' : 'c-info'}">${n === 0 ? 'Hôm nay' : n === 1 ? 'Ngày mai' : 'Còn ' + n + ' ngày'}</span>`}</div>
      <div class="muted">${isContent(e) ? esc([e.projectId ? projName(e.projectId) : '', e.note || ''].filter(Boolean).join(' · ')) : `${DOW[pd(e.date).getDay()]} ${dm(e.date)} ${esc(e.time || '')}${e.place ? ' · ' + esc(e.place) : ''}${e.projectId ? ' · ' + esc(projName(e.projectId)) : ''}`}</div>
      ${!isDay ? `<div class="evp-lab">${days.length ? 'Chuỗi bài bắt đầu đăng lúc ' + kLab(days[0]) + ' ' + DOW[pd(kDate(days[0])).getDay()] + ' ' + dm(kDate(days[0])) + ' – mỗi ngày CRM hiện đúng bài của ngày đó' : (isContent(e) ? 'Hôm nay không có bài content' : 'Hôm nay không có bài đăng')}</div>` : `${slots.length > 1 ? `<div class="chip c-info" style="align-self:flex-start">Hôm nay có ${slots.length} bài: ${slots.map(kLab).join(' · ')}</div>` : ''}
      ${!myPhone() ? `<div class="banner row" style="justify-content:space-between;gap:8px">Bạn chưa có số điện thoại – bài và ảnh sẽ thiếu số của bạn.<span class="row" style="flex-wrap:nowrap"><input id="myPhoneIn" type="tel" placeholder="Số Zalo của bạn" style="width:150px"><button class="btn sm pri" data-a="savePhone">Lưu số</button></span></div>` : ''}
      ${slots.map(one).join('')}${MANAGER ? `<div class="row"><button class="btn sm" data-a="editEvent" data-id="${esc(e.id)}">Sửa ảnh / bài đăng</button></div>` : ''}
      `}${!isDay && MANAGER ? `<div class="row"><button class="btn sm" data-a="editEvent" data-id="${esc(e.id)}">Sửa ảnh / bài đăng</button></div>` : ''}
      ${MANAGER && days.length ? `<details class="evp-more"><summary>Xem trước lịch đăng (${days.length} bài – chỉ quản lý thấy)</summary>${days.map(d => { const q = evPostFor(e, d), di = evImgFor(e, d); return `<div class="evp-day"><div class="row" style="justify-content:space-between"><b>${DOW[pd(kDate(d)).getDay()]} ${dm(kDate(d))} · ${kLab(d)}${kDate(d) === e.date ? ' – ngày sự kiện' : ''}</b><div class="row">${di ? `<button class="btn sm" data-a="evPosterDl" data-id="${esc(e.id)}" data-k="${all.indexOf(di)}" data-d="${d}">Tải ảnh</button>` : ''}<button class="btn sm" data-a="evPostCopy" data-id="${esc(e.id)}" data-k="${d}">Copy bài</button></div></div><pre class="evp-post">${esc(q.txt)}</pre></div>`; }).join('')}</details>` : ''}
      </div></div>`; }

/* Ảnh sự kiện tải lên: thu nhỏ còn ≤1080px, nén JPEG để lưu thẳng trong tài liệu sự kiện (Firestore giới hạn 1 MB/tài liệu). */
function shrinkImage(file, maxLen = 650000){ return new Promise((ok, bad) => { const r = new FileReader(); r.onerror = () => bad(new Error('Không đọc được ảnh'));
  r.onload = () => { const im = new Image(); im.onerror = () => bad(new Error('File không phải ảnh')); im.onload = () => {
    let w = im.width, h = im.height; const k = Math.min(1, (maxLen < 300000 ? 960 : 1080) / Math.max(w, h)); w = Math.round(w * k); h = Math.round(h * k);
    const c = document.createElement('canvas'); c.width = w; c.height = h; c.getContext('2d').drawImage(im, 0, 0, w, h);
    let q = .82, url = c.toDataURL('image/jpeg', q); while (url.length > maxLen && q > .3) { q -= .08; url = c.toDataURL('image/jpeg', q); }
    url.length > maxLen ? bad(new Error('Ảnh quá lớn, chọn ảnh nhỏ hơn')) : ok(url); }; im.src = r.result; }; r.readAsDataURL(file); }); }

/* Thẻ ghim trên Tổng quan: mã căn chạy chung hôm nay + sự kiện sắp tới */
function planCards(){
  let h = '';
  const fc = focusToday(), me = meSeller(), n = sellers().length;
  if (fc || MANAGER) {
    h += `<div class="plancard"><div class="pc-main"><b>📌 Mã căn chạy chung hôm nay</b> ${fc ? `<span class="pc-code">${esc(fc.code)}</span> <span class="muted">${esc(projName(fc.projectId))}</span>${fc.note ? `<div class="muted pc-note">${esc(fc.note)}</div>` : ''}` : '<span class="muted">chưa đặt – quản lý đặt mã căn để cả đội cùng đăng lúc 9h và 15h</span>'}</div><div class="row">`;
    if (fc && me) h += SLOTS.map(sl => slotDone(sl.k, ME.email) ? `<span class="chip c-ok">${sl.k} ✓ đã đăng</span>` : `<button class="btn sm ${nowHM() >= sl.at ? 'pri' : ''}" data-a="focusPost" data-k="${sl.k}">Đã đăng ${sl.k}</button>`).join('');
    if (fc && MANAGER) h += SLOTS.map(sl => `<span class="chip c-info">${sl.k}: ${sellers().filter(s => slotDone(sl.k, s.id)).length}/${n} đã đăng</span>`).join('');
    if (MANAGER) h += `<button class="btn sm" data-a="focusSet">${fc ? 'Đổi mã căn' : 'Đặt mã căn hôm nay'}</button>`;
    h += '</div></div>';
  }
  const rw = range('week', 0);
  if (me) { const d = dealsOf(ME.email, rw.s, rw.e).length; h += `<div class="plancard rw"><div class="pc-main"><b>🎁 Thưởng giao dịch tuần này</b> <span class="muted">· ${vnd(DEAL_REWARD)} / giao dịch (khách đặt cọc) trích từ quỹ đội</span></div><div class="row"><span class="chip ${d ? 'c-ok' : 'c-na'}">${d} giao dịch = ${vnd(d * DEAL_REWARD)}</span></div></div>`; }
  else if (MANAGER) { const d = dealsOf(null, rw.s, rw.e).filter(a => sellers().some(s => s.id === a.staffId)); if (d.length) h += `<div class="plancard rw"><div class="pc-main"><b>🎁 Giao dịch tuần này</b> <span class="muted">· thưởng ${vnd(DEAL_REWARD)}/giao dịch</span></div><div class="row"><span class="chip c-ok">${d.length} giao dịch = ${vnd(d.length * DEAL_REWARD)}</span><a class="btn sm" href="#quan-tri">Quỹ đội</a></div></div>`; }
  const ne = nextEvent();
  if (ne) {
    const need = Number(ne.minGuests) || 1, mine = me ? evGuests(ne.id, ME.email) : 0, ef = eventFines();
    h += `<div class="plancard ev"><div class="pc-main"><b>📅 ${esc(ne.name)}</b> <span class="muted">· ${DOW[pd(ne.date).getDay()]} ${dm(ne.date)} ${esc(ne.time || '')}${ne.place ? ' · ' + esc(ne.place) : ''}</span>
      <div class="muted pc-note">Tối thiểu ${need} khách/người${ne.needGuest !== false ? ` · không đủ khách phạt ${vnd(EVENT_FINE)}, lần liên tiếp sau cộng thêm ${vnd(EVENT_FINE)}` : ''}</div></div><div class="row">`;
    if (me) h += `<span class="chip ${mine >= need ? 'c-ok' : 'c-bad'}">Khách của bạn: ${mine}/${need}</span>${mine < need && ne.needGuest !== false ? `<span class="chip c-warn">Nếu thiếu: phạt ${vnd((ef[ME.email] || {}).next || EVENT_FINE)}</span>` : ''}`;
    if (MANAGER) h += `<span class="chip c-info">${sellers().filter(s => evGuests(ne.id, s.id) >= need).length}/${n} sale đủ khách · tổng ${evGuests(ne.id)} khách</span><a class="btn sm" href="#quan-tri">Chi tiết</a>`;
    h += '</div></div>';
  }
  const re = repEvent();
  if (re) {
    const t = today(), late = nowHM() >= repBy(re), my = meReporter() ? evRep(re.id, t, ME.email) : null;
    h += `<div class="plancard ev"><div class="pc-main"><b>📝 Báo cáo khách sự kiện: ${esc(re.name)}</b> <span class="muted">· ${DOW[pd(re.date).getDay()]} ${dm(re.date)}${re.place ? ' · ' + esc(re.place) : ''}</span>
      <div class="muted pc-note">Mỗi sale và trưởng phòng báo cáo hằng ngày trước ${repBy(re)} (có khách hay chưa, tên khách, đi mấy người, mức quan tâm) · tối thiểu ${Number(re.minGuests) || 1} khách/người</div>${my ? `<div class="pc-note">Hôm nay: ${esc(repLine(my))}</div>` : ''}</div><div class="row">`;
    if (meReporter()) h += `<span class="chip ${my ? 'c-ok' : late ? 'c-bad' : 'c-warn'}">${my ? 'Đã báo cáo ' + hhmm(my.ts) : late ? 'Quá hạn ' + repBy(re) + ' – chưa báo cáo' : 'Chưa báo cáo hôm nay'}</span><button class="btn sm pri" data-a="evReport">${my ? 'Sửa báo cáo' : 'Báo cáo ngay'}</button>`;
    if (MANAGER) { const sm = repSummary(re, t); h += `<span class="chip ${sm.sent >= sm.n ? 'c-ok' : 'c-info'}">${sm.sent}/${sm.n} sale đã báo cáo · ${sm.has} có khách · ${sm.ppl} người</span><a class="btn sm" href="#quan-tri">Chi tiết</a>`; }
    h += '</div></div>';
  }
  return h;
}
function annCard(a, unread){
  return `<button type="button" class="ann-i ${unread ? 'new' : ''} ${a.important ? 'imp' : ''}" data-a="annOpen" data-id="${a.id}">
    <div class="row">${a.important ? '<span class="chip c-bad">Quan trọng</span>' : ''}<span class="chip c-info">${a.projectId ? esc(projName(a.projectId)) : 'Tất cả dự án'}</span>${unread ? '<span class="chip c-warn">Mới</span>' : ''}<span class="muted" style="font-size:12px">${dm(a.date)} · ${esc(a.byName || '')}</span></div>
    <div class="ann-t">${esc(a.title)}</div><div class="ann-b">${esc(a.body)}</div></button>`;
}
/* Bảng hàng theo sàn + chính sách tháng (đọc bangHang/config, p_<dự án>, pol và bhPrivate/sans do trang Bảng hàng ghi) */
const BH_SRC = {cdt:'Hàng CĐT', cty:'Hàng công ty', ngoai:'Sàn ngoài'}, BH_ORD = {cdt:0, cty:1, ngoai:2};
function bhDoc(id){ const d = S.bh.find(x => x.id === id); try { return d ? JSON.parse(d.json || '{}') : {}; } catch(e){ return {}; } }
function bhBySan(){
  const meta = {}, priv = {}; (bhDoc('config').sans || []).forEach(s => meta[s.id] = s);
  S.bhPriv.forEach(d => { if (d.id === 'sans') { try { (JSON.parse(d.json || '{}').sans || []).forEach(s => priv[s.id] = s); } catch(e){} } });
  return bhStatus().map(b => { const cnt = {}; (bhDoc('p_' + b.pid).listings || []).forEach(l => cnt[l.san] = (cnt[l.san] || 0) + 1);
    const sans = Object.keys(cnt).map(id => { const m = meta[id] || {}, p = priv[id] || {}, kind = m.kind || 'ngoai';
      return {id, kind, name: p.name || m.label || BH_SRC[kind], phone: p.phone || '', contact: p.contact || '', n: cnt[id], up: m.updated || ''}; })
      .sort((a, c) => BH_ORD[a.kind] - BH_ORD[c.kind] || c.n - a.n);
    return Object.assign({}, b, {sans, sold: S.sold.filter(x => x.project === b.pid).length}); });
}
function polNow(pid){
  const t = today(), L = (bhDoc('pol')[pid] || []).map(p => Object.assign({st: p.from || (p.month ? p.month + '-01' : '')}, p)).sort((a, c) => c.st.localeCompare(a.st));
  return {cur: L.find(p => p.st <= t) || null, next: L.find(p => p.st > t) || null, n: L.length};
}
function vAdmin(){
  if (!MANAGER && !BH) return vDash();
  const t = today(), bs = bhBySan(), mon = t.slice(0, 7);
  let h = top('Quản trị', MANAGER ? 'Bảng hàng từng sàn, chính sách tháng, thông báo và nhân sự' : 'Bảng hàng từng sàn và chính sách tháng', MANAGER ? `<button class="btn pri" data-a="addAnn">+ Đăng thông báo</button>` : '');
  // 1. Bảng hàng: dự án → từng sàn / nguồn hàng
  h += `<div class="panel"><h2>Bảng hàng các sàn <span>hạn cập nhật ${BH_DEADLINE} mỗi ngày${BH ? '' : ' · tên sàn ngoài chỉ Quản trị / Giám đốc / Admin bảng hàng thấy'}</span></h2>` +
    (bs.length ? '<div class="tw" style="border:0"><table><thead><tr><th>Dự án / sàn</th><th>Nguồn</th><th class="num">Số căn</th><th>Cập nhật</th><th>Tình trạng</th></tr></thead><tbody>' + bs.map(b =>
      `<tr class="bhp"><td class="nm">${esc(b.name)}</td><td class="muted">${b.sans.length} nguồn${b.sold ? ` · <span class="late">${b.sold} đã bán</span>` : ''}</td><td class="num"><b>${b.n}</b></td><td class="num">${b.upAt ? dm(b.up) + ' ' + hhmm(b.upAt) : '—'}</td><td><span class="chip ${b.fresh ? 'c-ok' : b.late ? 'c-bad' : 'c-warn'}">${b.fresh ? 'Đã cập nhật hôm nay' : b.late ? 'Quá hạn ' + BH_DEADLINE : 'Chưa cập nhật'}</span> <a class="btn sm" href="bang-hang.html?tab=bang-gia&p=${encodeURIComponent(b.pid)}">Cập nhật</a></td></tr>` +
      b.sans.map(s => `<tr><td style="padding-left:26px">↳ <b>${esc(s.name)}</b>${s.phone ? `<div class="ph">${esc(s.contact)} ${esc(s.phone)}</div>` : ''}</td><td><span class="chip ${s.kind === 'cdt' ? 'c-ok' : s.kind === 'cty' ? 'c-info' : 'c-na'}">${BH_SRC[s.kind]}</span></td><td class="num">${s.n}</td><td class="num">${s.up ? dm(s.up) : '—'}</td><td>${s.up === t ? '<span class="chip c-ok">Hôm nay</span>' : `<span class="chip ${b.late ? 'c-bad' : 'c-warn'}">Chưa cập nhật hôm nay</span>`}</td></tr>`).join('')).join('') + '</tbody></table></div>'
      : '<div class="empty"><b>Chưa có bảng hàng</b>Mở trang Bảng hàng để nhập bảng giá đầu tiên.</div>') +
    `<div class="row" style="margin-top:12px"><a class="btn pri" href="bang-hang.html?tab=bang-gia">Cập nhật bảng giá</a><a class="btn" href="bang-hang.html">Mở bảng hàng</a>${MANAGER ? '<a class="btn" href="bao-cao-mkt/">Báo cáo marketing tuần</a>' : ''}</div>
    <p class="muted" style="margin-top:8px;font-size:12.5px">Nhập nhầm: trang Bảng hàng → tab Bảng giá các sàn → <b>↶ Quay lại bản trước</b>.</p></div>`;
  // 2. Chính sách & bảng tính tháng từng dự án
  h += `<div class="panel" style="margin-top:16px"><h2>Chính sách tháng ${mon.slice(5)}/${mon.slice(0, 4)} <span>CSBH, file chính sách và bảng tính mới của từng dự án</span></h2>` +
    (S.projects.length ? '<div class="tw" style="border:0"><table><thead><tr><th>Dự án</th><th>Chính sách đang áp dụng</th><th>Hiệu lực</th><th>Tài liệu</th><th></th></tr></thead><tbody>' + S.projects.map(p => { const {cur, next} = polNow(p.id), ok = cur && (cur.month || cur.st.slice(0, 7)) >= mon;
      return `<tr><td class="nm">${esc(p.name)}</td><td>${cur ? `<b>${esc(cur.name || '')}</b>${cur.byName ? `<div class="ph">${esc(cur.byName)} cập nhật ${dm(cur.at)}</div>` : ''}` : '<span class="muted">Chưa có</span>'}${next ? `<div class="ph">Sắp áp dụng: ${esc(next.name || '')} từ ${dm(next.st)}</div>` : ''}</td>
        <td>${cur ? `${dm(cur.st)}${cur.to ? ' – ' + dm(cur.to) : ''} <span class="chip ${ok ? 'c-ok' : 'c-warn'}">${ok ? 'Tháng này' : 'Chưa có CS tháng này'}</span>` : `<span class="chip ${next ? 'c-info' : 'c-warn'}">${next ? 'Chờ hiệu lực' : 'Chưa cập nhật'}</span>`}</td>
        <td>${cur && cur.fileUrl ? `<a class="lnkbtn" target="_blank" rel="noopener" href="${esc(cur.fileUrl)}">📄 Chính sách</a> ` : ''}${cur && cur.calcUrl ? `<a class="lnkbtn" target="_blank" rel="noopener" href="${esc(cur.calcUrl)}">📊 Bảng tính</a>` : ''}</td>
        <td>${BH ? `<a class="btn sm" href="bang-hang.html?tab=bang-tinh&p=${encodeURIComponent(p.id)}">${cur ? 'Cập nhật' : 'Thêm'}</a>` : ''}</td></tr>`; }).join('') + '</tbody></table></div>'
      : '<div class="empty">Chưa có dự án.</div>') + `<p class="muted" style="margin-top:8px;font-size:12.5px">Chính sách tháng mới tự áp dụng từ ngày hiệu lực; bảng tính FourS / S-Light tự tính theo thông số mới. Sale xem ở trang Bảng hàng → Bảng tính; Quân sư cũng đọc được.</p></div>`;
  if (!MANAGER) return h;
  // 3. Thông báo dự án
  h += `<div class="panel" style="margin-top:16px"><h2>Thông báo dự án <span>${S.ann.length} thông báo · ${annActive().length} đang hiển thị</span><button class="btn sm pri" data-a="addAnn">+ Đăng thông báo</button></h2>`;
  h += S.ann.length ? '<div class="tw" style="border:0"><table><thead><tr><th>Ngày</th><th>Tiêu đề</th><th>Dự án</th><th>Hiển thị đến</th><th></th></tr></thead><tbody>' + S.ann.slice(0, 15).map(a => `<tr><td class="num">${dm(a.date)}</td><td>${a.important ? '<span class="chip c-bad">Quan trọng</span> ' : ''}<span class="nm">${esc(a.title)}</span><div class="ph">${esc(a.byName || '')}</div></td><td>${a.projectId ? esc(projName(a.projectId)) : 'Tất cả'}</td><td class="num">${a.until ? `<span class="${a.until < t ? 'muted' : ''}">${dm(a.until)}${a.until < t ? ' (đã ẩn)' : ''}</span>` : 'Luôn hiện'}</td><td><button class="btn sm" data-a="editAnn" data-id="${a.id}">Sửa</button></td></tr>`).join('') + '</tbody></table></div>'
    : `<div class="empty"><b>Chưa có thông báo</b>Đăng CSBH mới, đợt mở bán, thay đổi giá hay lịch sự kiện. Cả đội thấy ngay trên Tổng quan và nhận thông báo trên điện thoại; Quân sư cũng đọc được để tư vấn.</div>`;
  h += '</div>';
  // 4. Nhân sự: thêm / sửa / khoá / xoá (chỉ Quản trị thao tác)
  const rk = {admin:0, gd:1, bh:2, lead:3, sale:4}, st = [...S.staff].sort((a, c) => (c.active !== false) - (a.active !== false) || (rk[a.role] ?? 5) - (rk[c.role] ?? 5) || (a.name || '').localeCompare(c.name || '', 'vi'));
  const cntR = ROLES.map(r => [r.l, S.staff.filter(s => s.active !== false && (s.role || 'sale') === r.k).length]).filter(x => x[1]);
  h += `<div class="panel" style="margin-top:16px"><h2>Nhân sự <span>${S.staff.filter(s => s.active !== false).length} đang làm · ${cntR.map(([l, n]) => n + ' ' + l).join(' · ')}</span><button class="btn sm pri adm" data-a="addStaff">+ Thêm nhân sự</button></h2>
    <div class="tw" style="border:0"><table><thead><tr><th>Họ tên</th><th>Email đăng nhập</th><th>Vai trò</th><th>Phòng</th><th>Trạng thái</th><th></th></tr></thead><tbody>` + st.map(s => `<tr class="${s.active === false ? 'muted' : ''}"><td class="nm">${esc(s.name || '')}<div class="ph">${esc(s.phone || '')}</div></td><td>${esc(s.id)}</td><td><span class="chip ${isBoss(s) ? 'c-info' : s.role === 'bh' ? 'c-warn' : 'c-na'}">${roleL(s.role)}</span></td><td>${esc(s.team || '')}</td><td>${s.active === false ? '<span class="chip c-bad">Đã khoá</span>' : '<span class="chip c-ok">Đang làm</span>'}</td>
      <td style="white-space:nowrap"><button class="btn sm adm" data-a="editStaff" data-id="${esc(s.id)}">Sửa</button>${s.id !== ME.email ? ` <button class="btn sm adm" data-a="toggleStaff" data-id="${esc(s.id)}">${s.active === false ? 'Mở lại' : 'Khoá'}</button>` : ''}</td></tr>`).join('') + `</tbody></table></div>
    <p class="muted" style="margin-top:8px;font-size:12.5px">Thêm nhân sự: điền email → người đó tự đăng nhập bằng Google hoặc "Tạo tài khoản email". <b>Khoá</b> = nghỉ việc (không đăng nhập được, giữ lịch sử khách); xoá hẳn ở nút <b>Sửa → Xoá</b>. Chỉ Quản trị thêm / sửa nhân sự.</p></div>`;
  h += `<div class="panel" style="margin-top:16px"><h2>Quản lý nhanh</h2><div class="qgrid">` + [['#doi-sale','Đội sale','Bậc KPI, nhận khách web'],['#du-an','Dự án','Thông tin, ghi chú giá, CSBH'],['#kpi','Bảng điểm KPI','Chấm tác phong, áp dụng lên / xuống bậc'],['#khach-hang','Khách chưa giao','Giao khách web cho sale']].map(([href,tt,d]) => `<a class="qlink" href="${href}"><b>${tt}</b><span>${d}</span></a>`).join('') +
    `<button type="button" class="qlink" data-a="editTargets"><b>Chỉ tiêu tuần / tháng</b><span>Video, bài, mời khách, deal</span></button></div></div>`;
  // Mã căn chạy chung + sự kiện & tiền phạt
  const fc = focusToday(), sl = sellers(), ef = eventFines();
  h += `<div class="panel" style="margin-top:16px"><h2>Mã căn chạy chung hôm nay <span>cả đội đăng lúc 9h và 15h</span><button class="btn sm pri" data-a="focusSet">${fc ? 'Đổi mã căn' : 'Đặt mã căn'}</button></h2>` +
    (fc ? `<p><span class="pc-code">${esc(fc.code)}</span> ${esc(projName(fc.projectId))}${fc.note ? ' · ' + esc(fc.note) : ''}</p>` + (sl.length ? '<div class="tw" style="border:0"><table><thead><tr><th>Sale</th><th>9h</th><th>15h</th></tr></thead><tbody>' + sl.map(s => `<tr><td class="nm">${esc(s.name)}</td>${SLOTS.map(x => `<td>${slotDone(x.k, s.id) ? '<span class="chip c-ok">Đã đăng</span>' : nowHM() >= x.at ? '<span class="chip c-bad">Chưa đăng</span>' : '<span class="chip c-na">Chưa tới giờ</span>'}</td>`).join('')}</tr>`).join('') + '</tbody></table></div>' : '')
      : '<div class="muted">Chưa đặt mã căn cho hôm nay.</div>') + '</div>';
  h += `<div class="panel" style="margin-top:16px"><h2>Sự kiện & tiền phạt <span>phạt ${vnd(EVENT_FINE)}, lần liên tiếp sau cộng thêm ${vnd(EVENT_FINE)}</span><button class="btn sm pri" data-a="addEvent">+ Tạo sự kiện</button></h2>`;
  h += S.events.length ? '<div class="tw" style="border:0"><table><thead><tr><th>Ngày</th><th>Sự kiện</th><th>Khách</th><th>Sale đủ khách</th><th></th></tr></thead><tbody>' + [...S.events].reverse().slice(0, 12).map(e => { const need = Number(e.minGuests) || 1; return `<tr><td class="num">${dm(e.date)} ${esc(e.time || '')}</td><td><span class="nm">${esc(e.name)}</span><div class="ph">${esc(e.place || '')}${e.date < today() ? ' · đã diễn ra' : ''}</div></td><td class="num">${evGuests(e.id)}</td><td class="num">${sl.filter(s => evGuests(e.id, s.id) >= need).length}/${sl.length}</td><td><button class="btn sm" data-a="editEvent" data-id="${e.id}">Sửa</button></td></tr>`; }).join('') + '</tbody></table></div>'
    : '<div class="empty"><b>Chưa có sự kiện</b>Tạo sự kiện (ví dụ Giới thiệu FourS Tower Tháp F2 – CN 11/10) để sale ghi nhận khách tham dự và hệ thống tự tính phạt.</div>';
  const ne = nextEvent();
  if (ne && sl.length) h += `<h3 style="margin:14px 0 6px;font-size:14px">Khách mời sự kiện sắp tới: ${esc(ne.name)} (${dm(ne.date)})</h3><div class="tw" style="border:0"><table><thead><tr><th>Sale</th><th>Khách đã mời</th><th>Chuỗi không khách</th><th>Nếu thiếu khách lần này</th></tr></thead><tbody>` + sl.map(s => { const g = evGuests(ne.id, s.id), f = ef[s.id] || {}; return `<tr><td class="nm">${esc(s.name)}</td><td><span class="chip ${g >= (Number(ne.minGuests) || 1) ? 'c-ok' : 'c-bad'}">${g}</span></td><td class="num">${f.streak || 0} lần</td><td class="num">${ne.needGuest !== false ? vnd(f.next || EVENT_FINE) : '—'}</td></tr>`; }).join('') + '</tbody></table></div>';
  const re = repEvent();
  if (re && repSellers().length) { const t = today(), sm = repSummary(re, t), late = nowHM() >= repBy(re);
    h += `<h3 style="margin:14px 0 6px;font-size:14px">Báo cáo khách hằng ngày: ${esc(re.name)} (${dm(re.date)}) – ${repAll() ? 'cả công ty' : ME.team ? esc(ME.team) : 'của bạn'} · hôm nay ${dm(t)}, hạn ${repBy(re)} <button class="btn sm" data-a="evReportCopy">Copy tổng hợp gửi Zalo</button> <button class="btn sm" data-a="evRepSheet">Mở Google Sheet</button></h3>
      <div class="row" style="margin-bottom:6px"><span class="chip ${sm.sent >= sm.n ? 'c-ok' : 'c-bad'}">${sm.sent}/${sm.n} sale đã báo cáo</span><span class="chip c-info">${sm.has} sale có khách xác nhận</span><span class="chip c-info">Tổng ${sm.ppl} người dự kiến</span></div>
      <div class="tw" style="border:0"><table><thead><tr><th>Sale</th>${repAll() ? '<th>Phòng</th>' : ''}<th>Hôm nay</th><th>Tình trạng</th><th>Khách (tên)</th><th>Số người</th><th>Mức quan tâm</th><th>Tình hình</th></tr></thead><tbody>` +
      sm.rs.map(({s, r}) => { const p = r || lastRep(re.id, s.id); return `<tr><td class="nm">${esc(s.name)}</td>${repAll() ? `<td>${esc(s.team || '')}</td>` : ''}<td>${r ? `<span class="chip c-ok">${hhmm(r.ts)}</span>` : `<span class="chip ${late ? 'c-bad' : 'c-warn'}">Chưa báo cáo</span>`}</td>` +
        (p ? `<td><span class="chip ${p.status === 'yes' ? 'c-ok' : p.status === 'inviting' ? 'c-warn' : 'c-na'}">${esc(repL(REP_ST, p.status).split(' – ')[0])}</span>${r ? '' : `<div class="ph">báo cáo ngày ${dm(p.date)}</div>`}</td><td>${esc(p.guests || '')}</td><td class="num">${p.status !== 'none' && p.people ? p.people : ''}</td><td>${esc(repL(REP_INT, p.interest).split(' – ')[0])}</td><td>${esc(p.note || '')}</td>` : '<td colspan="5" class="muted">Chưa có báo cáo nào</td>') + '</tr>'; }).join('') + '</tbody></table></div>'; }
  const fined = sl.filter(s => (ef[s.id] || {}).total > 0);
  if (fined.length) h += `<h3 style="margin:14px 0 6px;font-size:14px">Tiền phạt sự kiện (cộng dồn)</h3><div class="tw" style="border:0"><table><thead><tr><th>Sale</th><th>Tổng phạt</th><th>Chi tiết</th></tr></thead><tbody>` + fined.map(s => { const f = ef[s.id]; return `<tr><td class="nm">${esc(s.name)}</td><td class="num late">${vnd(f.total)}</td><td class="ph">${f.hist.map(x => dm(x.e.date) + ' ' + esc(x.e.name) + ': ' + vnd(x.f)).join(' · ')}</td></tr>`; }).join('') + '</tbody></table></div>';
  h += '</div>';
  // Quỹ đội: thu từ phạt sự kiện, chi thưởng giao dịch
  const fund = teamFund(), rwk = range('week', 0), rmo = range('month', 0);
  h += `<div class="panel" style="margin-top:16px"><h2>Quỹ đội <span>thu phạt sự kiện · chi thưởng ${vnd(DEAL_REWARD)}/giao dịch · từ ${dm(PLAN_START)}</span></h2>
    <div class="tiles" style="margin-bottom:12px"><div class="tile"><div class="l">Thu (phạt)</div><div class="v">${vnd(fund.fines)}</div></div><div class="tile"><div class="l">Chi (thưởng)</div><div class="v">${vnd(fund.rewards)}</div></div><div class="tile ${fund.balance < 0 ? 'bad' : ''}"><div class="l">Số dư quỹ</div><div class="v">${vnd(fund.balance)}</div></div></div>` +
    (sl.length ? '<div class="tw" style="border:0"><table><thead><tr><th>Sale</th><th>Giao dịch tuần này</th><th>Thưởng tuần</th><th>Giao dịch tháng</th><th>Thưởng tháng</th></tr></thead><tbody>' + sl.map(s => { const w = dealsOf(s.id, rwk.s, rwk.e).length, m = dealsOf(s.id, rmo.s, rmo.e).length; return `<tr><td class="nm">${esc(s.name)}</td><td class="num">${w}</td><td class="num">${vnd(w * DEAL_REWARD)}</td><td class="num">${m}</td><td class="num">${vnd(m * DEAL_REWARD)}</td></tr>`; }).join('') + '</tbody></table></div>' : '') +
    `<p class="muted" style="margin-top:8px;font-size:12.5px">Giao dịch = khách đặt cọc được ghi nhận trong CRM (hoạt động "Booking / đặt cọc"); một khách chỉ tính 1 lần. Khách ký HĐMB mà chưa ghi nhận cọc thì chưa tính – nhớ ghi nhận cọc trước. Số dư âm nghĩa là thưởng nhiều hơn tiền phạt đã thu – phần chênh do quỹ công ty bù.</p></div>`;
  return h;
}
/* Link 360 của dự án: mỗi dòng "Tên: https://…" hoặc chỉ link → [{l, u}] (chỉ nhận http/https). */
// Link 360 mặc định theo tên dự án (dùng khi dự án chưa tự nhập link ở form Sửa dự án).
const DEF_360 = [
  [/spana/i, 'https://kuula.co/share/hVKVY?logo=1&info=1&fs=1&vr=0&sd=1&thumbs=1'],
  [/\bs[\s-]?light/i, 'https://kuula.co/share/collection/7TqX8?logo=1&info=1&fs=0&vr=0&gyro=0&thumbs=1&keys=0'],
  [/four[\s-]?s/i, 'https://kuula.co/post/LTTwZ?logo=1&info=1&fs=0&vr=0&gyro=0&thumbs=1&keys=0']];
const def360 = name => (DEF_360.find(([re]) => re.test(String(name || ''))) || [])[1] || '';
const p360 = p => (p && (p.link360 || def360(p.name))) || '';
// Mô hình 4D: link mặc định theo tên dự án khi chưa lưu link riêng (giống bang-hang.html DEF_4D)
const DEF_4D = [[/sap+hi?a/i, 'https://crm-sale-danang.netlify.app/4d/sun-saphia-4d.html']];
const def4d = name => (DEF_4D.find(([re]) => re.test(String(name || ''))) || []).slice(1);
function links360(txt){ return String(txt || '').split(/\n+/).map(line => { const m = /(https?:\/\/\S+)/i.exec(line); if (!m) return null;
  const l = line.slice(0, m.index).replace(/[\s:|\-–]+$/, '').trim(); return {l, u: m[1]}; }).filter(Boolean).map((x, i, a) => ({l: x.l || (a.length > 1 ? 'Xem 360 (' + (i + 1) + ')' : 'Xem 360'), u: x.u})); }
/* ---------- Content tuần: kế hoạch bài đăng cả tuần (không gắn sự kiện) ---------- */
function vContent(){
  const t = today(), now = contentNow(), next = (S.contents || []).filter(c => (c.startDate || addD(c.date, -6)) > t), past = (S.contents || []).filter(c => c.date < t).slice(-6).reverse();
  let h = top('Content tuần', 'Bài đăng mỗi ngày cho cả đội – copy bài, tải ảnh có tên + SĐT của bạn, đăng xong bấm “Đã đăng”', MANAGER ? (saphiaMissing().length ? `<button class="btn" data-a="seedSaphiaContent">✨ Nạp content Sun Saphia</button> ` : '') + `<button class="btn pri" data-a="addContent">+ Content tuần</button>` : '');
  // bài đăng của sự kiện đang chạy (vd sự kiện 18/10 có bài 14–18/10) cũng hiện ở đây để sale thấy bài hôm nay
  const evNow = (S.events || []).filter(e => e.date >= t && evPostDays(e).length);
  if (evNow.length) h += `<div class="panel evp-wrap"><h2>🎉 Bài đăng sự kiện <span>${evNow.map(e => esc(e.name || '')).join(' · ')}</span></h2>` + evNow.map(evCard).join('') + '</div>';
  h += now.length ? `<div class="panel evp-wrap">` + now.map(evCard).join('') + '</div>' : evNow.length ? '' : `<div class="tw"><div class="empty"><b>Tuần này chưa có content</b>${MANAGER ? 'Bấm “+ Content tuần” để soạn bài cho từng ngày (9h, 20h…), chọn ảnh – sale sẽ thấy đúng bài của mỗi ngày.' : 'Quản lý chưa soạn content cho tuần này.'}</div></div>`;
  const row = c => `<tr><td class="nm">${esc(c.name || 'Content tuần')}</td><td class="num">${dm(c.startDate || addD(c.date, -6))} – ${dm(c.date)}</td><td class="num">${evPostDays(c).length || Object.keys(evPosts(c)).filter(k => /^\d{4}-\d{2}-\d{2}(@|$)/.test(k)).length} bài</td><td>${MANAGER ? `<button class="btn sm" data-a="editEvent" data-id="${esc(c.id)}">Sửa</button>` : ''}</td></tr>`;
  if (MANAGER && (next.length || past.length)) h += `<div class="panel" style="margin-top:16px"><h2>Các tuần khác</h2><div class="tw" style="border:0"><table><thead><tr><th>Tên</th><th>Tuần</th><th>Số bài</th><th></th></tr></thead><tbody>${next.concat(past).map(row).join('')}</tbody></table></div></div>`;
  return h + (setTimeout(evBrandPreviews, 0), '');
}
function contentForm(c){
  const mon = (() => { const d = pd(today()); d.setDate(d.getDate() - (d.getDay() + 6) % 7 + (d.getDay() === 0 ? 0 : 0)); return ymd(d); })();
  let imgs = c ? [].concat(c.posters || []) : [], lib = evLibSel(c).slice();
  openForm({title: c ? 'Sửa content tuần' : 'Content tuần mới', saveL: c ? 'Lưu' : 'Tạo', data: c || {name: 'Content tuần ' + dm(mon) + ' – ' + dm(addD(mon, 6)), startDate: mon, kicker: 'TÒA MAI F2 · THÁP BỐN MÙA', tagline: 'Sun FourS Tower · Đà Nẵng'},
    fields:[{k:'name',l:'Tên',req:1,full:1},{k:'startDate',l:'Tuần bắt đầu (thứ 2)',t:'date',req:1},{k:'projectId',l:'Dự án',t:'select',o:projOpts(),empty:'—'},
      {k:'tagline',l:'Nhãn trên cùng của ảnh',ph:'Sun FourS Tower · Đà Nẵng'},{k:'kicker',l:'Dòng nhỏ trên tiêu đề',ph:'TÒA MAI F2 · THÁP BỐN MÙA'},
      {k:'place',l:'Dòng 📍 dưới ảnh (vị trí / dự án)',full:1,ph:'Sun FourS Tower · Nam Đà Nẵng'},
      {k:'highlights',l:'Điểm nổi bật (tem trên ảnh) – mỗi dòng “số | mô tả”, ngày nào không ghi “điểm nhấn:” sẽ lấy lần lượt',t:'area'},
      {k:'posts',l:'Bài đăng – mỗi bài bắt đầu bằng ngày (và giờ nếu không phải 9h): “19/10: …”, “19/10 20h: …”. Thêm dòng “tiêu đề: dòng trắng | dòng vàng”, “ảnh: 3 phải”, “điểm nhấn: 0% | lãi suất 24 tháng”, “câu: …”, “nút: …”.',t:'area'},
      {k:'hashtags',l:'Hashtag – tự gắn cuối mỗi bài khi copy',full:1,ph:'#SunFourSTower #ToaF2 #SunGroup'},
      {k:'note',l:'Ghi chú cho đội (hiện dưới tên)',full:1}],
    extra: `<label class="full">Tải ảnh lên (tối đa ${EV_MAX_IMG} ảnh)<input type="file" id="evPosterFile" accept="image/*" multiple></label><div class="full row" id="evPosterBox"></div>
      <div class="full"><div style="font-size:12.5px;color:var(--muted);margin-bottom:4px">Hoặc chọn ảnh có sẵn của CRM (bấm để chọn / bỏ chọn – số thứ tự ảnh theo thư viện)</div><div class="row" id="evLibBox"></div></div>`,
    onOpen: () => { const box = $('#evPosterBox'), show = () => { box.innerHTML = imgs.map((u, i) => `<span style="position:relative;display:inline-block"><img src="${esc(u)}" alt="Ảnh ${i + 1}" style="height:90px;border-radius:8px;display:block"><button type="button" class="btn sm danger" data-del="${i}" style="position:absolute;top:2px;right:2px;padding:0 6px">✕</button></span>`).join('');
        box.querySelectorAll('[data-del]').forEach(b => b.onclick = () => { imgs.splice(Number(b.dataset.del), 1); show(); }); };
      const lb = $('#evLibBox'), showLib = () => { lb.innerHTML = EV_LIB.map(([u, l], i) => `<button type="button" class="evlib ${lib.includes(u) ? 'on' : ''}" data-u="${esc(u)}" title="${esc(l)}"><img src="${esc(u)}" alt="${esc(l)}"><span>${lib.includes(u) ? '✓ ' : ''}${esc(l)}</span></button>`).join('');
        lb.querySelectorAll('[data-u]').forEach(b => b.onclick = () => { const u = b.dataset.u; lib = lib.includes(u) ? lib.filter(x => x !== u) : lib.concat(u); showLib(); }); };
      showLib(); show();
      $('#evPosterFile').onchange = async ev => { const fs = [...ev.target.files].slice(0, EV_MAX_IMG - imgs.length); if (!fs.length) return toast('Tối đa ' + EV_MAX_IMG + ' ảnh – bỏ bớt ảnh cũ trước');
        const per = Math.floor(880000 / Math.min(EV_MAX_IMG, imgs.length + fs.length));
        try { const all = await Promise.all(imgs.map(u => u.startsWith('data:') && u.length > per ? fetch(u).then(r => r.blob()).then(b => shrinkImage(b, per)) : u));
          imgs = all.concat(await Promise.all(fs.map(f => shrinkImage(f, per)))); show(); toast('Đã thêm ' + fs.length + ' ảnh – bấm Lưu để cập nhật'); } catch (err) { toast(err.message); } ev.target.value = ''; }; },
    onSave: async v => { v.kind = 'content'; v.date = addD(v.startDate, 6); v.posters = imgs; v.libImgs = lib; v.dailyReport = false; v.needGuest = false;
      return c ? write(store.update('events', c.id, v)) : write(store.add('events', Object.assign(v, {createdAt: Date.now(), by: ME.email}))); },
    onDelete: c ? () => store.remove('events', c.id) : null});
}
/* ---------- Hướng dẫn cho sale (file trong thư mục huong-dan/) ---------- */
const GUIDES = [
  {icon:'🏖', name:'Bài toán cho thuê – dòng tiền & lợi suất', sub:'Tính cho thuê dài hạn và ngắn ngày (Airbnb, Booking) theo 3 mùa du lịch, căn cứ số liệu thị trường; gửi khách qua Zalo / PDF. Có kịch bản tư vấn và câu hỏi khách hay hỏi.',
   web:'huong-dan/cho-thue.html', pdf:'huong-dan/cho-thue.pdf', open:'bang-hang.html?tab=cho-thue', openL:'Mở Bài toán cho thuê'}
];
function vGuide(){
  return top('Hướng dẫn', 'Tài liệu hướng dẫn sử dụng cho sale') + '<div class="cards">' + GUIDES.map(g => `<div class="card"><h3>${g.icon} ${esc(g.name)}</h3><div class="meta">${esc(g.sub)}</div>
    <div class="row" style="margin-top:10px;flex-wrap:wrap"><a class="btn sm pri" href="${g.web}" target="_blank" rel="noopener">📘 Xem hướng dẫn</a><a class="btn sm" href="${g.pdf}" download>⬇ Tải PDF</a>${g.open ? `<a class="btn sm" href="${g.open}">${esc(g.openL)} ↗</a>` : ''}</div></div>`).join('') + '</div>';
}
function vProj(){
  let h = top('Dự án', S.projects.length+' dự án tại Đà Nẵng', `${MANAGER && !S.projects.some(p => /saphia/i.test(p.name || '')) ? '<button class="btn m" data-a="addSaphia">✨ Thêm Sun Saphia Residence</button> ' : ''}<button class="btn pri m" data-a="addProj">+ Thêm dự án</button>`);
  if (!S.projects.length) return h + `<div class="tw"><div class="empty"><b>Chưa có dự án</b>Thêm các dự án đội đang phân phối để gắn khách vào từng dự án.${MANAGER ? '<div style="margin-top:12px"><button class="btn" data-a="seedProj">Thêm nhanh ' + SAMPLE_PROJECTS.length + ' dự án Đà Nẵng</button></div>' : ''}</div></div>`;
  return h + '<div class="cards">' + S.projects.map(p => { const cs = S.customers.filter(c => c.projectId === p.id);
    return `<div class="card"><div class="row" style="justify-content:space-between"><h3>${esc(p.name)}</h3>${p.status ? `<span class="chip ${p.status==='Đang bán'?'c-ok':'c-na'}">${esc(p.status)}</span>` : ''}</div>
    <div class="meta">${esc([p.location,p.developer,p.type].filter(Boolean).join(' · '))}</div>${p.note ? `<div class="meta">${esc(p.note)}</div>` : ''}
    ${(() => { const ls = links360(p360(p)); return ls.length ? `<div class="row">${ls.map(x => `<a class="btn sm pri" href="${esc(x.u)}" target="_blank" rel="noopener">🌐 ${esc(x.l)}</a>`).join('')}<button class="btn sm" data-a="copy360" data-id="${p.id}">Copy link gửi khách</button></div>` : ''; })()}
    <div class="stats"><div><b>${cs.filter(c => OPEN.includes(c.stage)).length}</b>khách đang theo</div><div><b>${cs.filter(c => c.stage==='deposit').length}</b>đã cọc</div><div><b>${cs.filter(c => c.stage==='contract').length}</b>ký HĐMB</div></div>
    <div class="foot"><button class="btn sm" data-a="viewProjCust" data-id="${p.id}">Khách</button><button class="btn sm m" data-a="editProj" data-id="${p.id}">Sửa</button></div></div>`; }).join('') + '</div>';
}

function vAcc(){
  const np = 'Notification' in window ? Notification.permission : 'unsupported';
  const ios = /iphone|ipad|ipod/i.test(navigator.userAgent), standalone = matchMedia('(display-mode: standalone)').matches || navigator.standalone;
  let h = top('Tài khoản', '');
  h += `<div class="grid2"><div class="stack"><div class="panel"><h2>Thông tin</h2><div class="kv"><span>Họ tên</span><b>${esc(ME.name)}</b><span>Email</span><div>${esc(ME.email)}</div><span>Vai trò</span><div>${roleL(ME.role)}${ME.owner && !ME.demo ? ' · chủ hệ thống' : ''}</div></div>
    <p class="muted" style="font-size:12px;margin:10px 0 0">CRM Sale Đà Nẵng · ${CRM_VER} (25/10/2026)</p>
    <div class="row" style="margin-top:14px"><button class="btn" data-a="signOut">${ME.demo ? 'Thoát demo' : 'Đăng xuất'}</button>${ME.demo ? '<button class="btn danger" data-a="resetDemo">Xoá dữ liệu demo</button>' : ''}</div></div>
    <div class="panel"><h2>Thông báo nhắc việc</h2>
    <p class="muted">Mỗi ngày, lần đầu mở app, bạn nhận một thông báo tóm tắt việc quá hạn, việc hôm nay, khách cần gọi lại và khách nguội. Số việc cần xử lý cũng hiện trên biểu tượng app (Android, Windows, macOS).</p>
    ${np === 'granted' ? '<span class="chip c-ok">Đã bật</span> <button class="btn sm" data-a="testNotify">Gửi thử</button>' : np === 'denied' ? '<span class="chip c-bad">Đã chặn</span><p class="muted" style="margin-top:8px">Mở cài đặt trình duyệt cho trang này và cho phép Thông báo.</p>' : np === 'unsupported' ? `<p class="muted">${ios && !standalone ? 'Trên iPhone, hãy cài app vào màn hình chính trước, rồi mở app từ biểu tượng để bật thông báo.' : 'Trình duyệt này không hỗ trợ thông báo.'}</p>` : '<button class="btn pri" data-a="enableNotify">Bật thông báo</button>'}
    </div></div>
    <div class="panel"><h2>Cài app lên điện thoại / máy tính</h2>
    ${standalone ? '<span class="chip c-ok">Đang chạy dạng app</span>' : installEvt ? '<p>Bấm để cài CRM như một ứng dụng.</p><button class="btn pri" data-a="install">Cài app</button>' : ''}
    <p class="muted" style="margin-top:10px"><b>iPhone / iPad:</b> mở bằng Safari → nút Chia sẻ → “Thêm vào MH chính”.<br><b>Android:</b> Chrome → menu ⋮ → “Cài đặt ứng dụng” hoặc “Thêm vào màn hình chính”.<br><b>Máy tính:</b> Chrome / Edge → biểu tượng cài đặt ở cuối thanh địa chỉ.</p></div></div>`;
  return h;
}

/* ---------- forms ---------- */
const dlg = $('#dlg'), form = $('#dlgForm'); let cur = null;
function opts(list, val, empty){ return (empty != null ? `<option value="">${empty}</option>` : '') + list.map(o => `<option value="${esc(o.v)}" ${String(o.v) === String(val ?? '') ? 'selected' : ''}>${esc(o.l)}</option>`).join(''); }
function field(f, v){
  const id = 'f_'+f.k, cls = f.full ? 'full' : ''; v = v ?? f.def ?? ''; const dis = f.dis ? 'disabled' : '';
  if (f.t === 'select') return `<label class="${cls}">${f.l}<select id="${id}" ${dis}>${opts(f.o, v, f.empty)}</select></label>`;
  if (f.t === 'area') return `<label class="full">${f.l}<textarea id="${id}" ${dis}>${esc(v)}</textarea></label>`;
  if (f.t === 'chk') return `<label class="chk ${cls}"><input type="checkbox" id="${id}" ${v ? 'checked' : ''} ${dis}>${f.l}</label>`;
  return `<label class="${cls}">${f.l}<input id="${id}" type="${f.t||'text'}" ${f.t==='number' ? 'step="any" min="0"' : ''} value="${esc(v)}" ${f.ph ? 'placeholder="'+esc(f.ph)+'"' : ''} ${f.req ? 'required' : ''} ${dis}></label>`;
}
function openForm(o){
  cur = o;
  form.innerHTML = `<div class="dh">${esc(o.title)}</div><div class="db">${o.fields.map(f => field(f, o.data ? o.data[f.k] : undefined)).join('')}${o.extra||''}</div>
  <div class="df"><div class="row" id="dlgLeft">${o.onDelete ? '<button type="button" class="btn danger" id="dlgDel">Xoá</button>' : ''}</div><div class="row"><button type="button" class="btn" id="dlgCancel">Đóng</button><button type="submit" class="btn pri" id="dlgSave">${o.saveL||'Lưu'}</button></div></div>`;
  $('#dlgCancel').onclick = () => dlg.close();
  const d = $('#dlgDel'); if (d) d.onclick = async () => { if (d.dataset.c !== '1') { d.dataset.c = '1'; d.textContent = 'Bấm lần nữa để xoá'; return; } try { await write(o.onDelete()); dlg.close(); toast('Đã xoá'); } catch(e) { toast(errMsg(e)); } };
  if (o.onOpen) o.onOpen();
  if (!dlg.open) dlg.showModal();
}
form.addEventListener('submit', async e => {
  e.preventDefault(); if (!cur) return;
  const v = {}; for (const f of cur.fields) { const el = document.getElementById('f_'+f.k); if (!el) continue; v[f.k] = f.t === 'chk' ? el.checked : f.t === 'number' ? (el.value === '' ? 0 : Number(el.value)) : el.value.trim(); }
  for (const f of cur.fields) if (f.req && !v[f.k]) { toast('Vui lòng nhập: '+f.l); return; }
  const b = $('#dlgSave'); b.disabled = true;
  try { const late = await cur.onSave(v); dlg.close(); if (!late) toast('Đã lưu'); } catch(err) { toast(err && err.msg || errMsg(err)); } finally { b.disabled = false; }
});
const sellerOpts = () => (MANAGER ? sellers() : sellers().filter(s => s.id === ME.email)).map(s => ({v:s.id, l:s.name}));
const projOpts = () => S.projects.map(p => ({v:p.id, l:p.name}));

function custForm(c){
  const hist = c ? S.activities.filter(a => a.customerId === c.id).sort((a,b) => (b.date||'').localeCompare(a.date||'') || (b.ts||0)-(a.ts||0)) : [];
  const staffF = MANAGER ? {k:'staffId', l:'Sale phụ trách', t:'select', o:sellerOpts(), empty: ME.owner ? '— Chưa giao (chỉ anh/chị thấy) —' : null} : {k:'staffId', l:'Sale phụ trách', t:'select', o:[{v:ME.email, l:ME.name}], dis:1};
  openForm({title: c ? c.name : 'Thêm khách hàng', data: c || {stage:'new', nextFollowUp:addD(today(),1), staffId: MANAGER ? (UI.fStaff||'') : ME.email, projectId: UI.fProj||''},
    fields:[{k:'name',l:'Họ tên',req:1},{k:'phone',l:'Số điện thoại',t:'tel'},
      {k:'projectId',l:'Dự án quan tâm',t:'select',o:projOpts(),empty:'— Chọn dự án —'}, staffF,
      {k:'stage',l:'Giai đoạn',t:'select',o:STAGES.map(s => ({v:s.k,l:s.l}))},{k:'source',l:'Nguồn',t:'select',o:SOURCES.map(s => ({v:s,l:s})),empty:'—'},
      {k:'budget',l:'Nhu cầu / ngân sách'},{k:'nextFollowUp',l:'Hẹn chăm sóc tiếp',t:'date'},{k:'note',l:'Ghi chú',t:'area'}],
    extra: (c ? (() => {
      const sale = byId(S.staff, c.staffId), due = reportDue(c);
      const st = c.assignStatus === 'pending' ? `<span class="chip c-bad">Chờ ${esc(staffName(c.staffId))} nhận · còn ${minsLeft(c)} phút</span>` : c.assignStatus === 'declined' ? '<span class="chip c-warn">Đang trả về Chưa giao</span>' : due ? `<span class="chip ${due - Date.now() < 864e5 ? 'c-bad' : 'c-run'}">Cập nhật tình hình trước ${dm(ymd(new Date(due)))} ${pad(new Date(due).getHours())}:${pad(new Date(due).getMinutes())}</span>` : '';
      return `<div class="note row"><button type="button" class="btn sm" data-a="aiCust" data-id="${c.id}">✦ Hỏi AI về khách này</button>${zaloA(c.phone, 'Mở Zalo khách')}${MANAGER && sale && zaloUrl(sale.phone) ? `<button type="button" class="btn sm" data-a="zaloToSale" data-id="${c.id}">Gửi khách qua Zalo cho ${esc(sale.name)}</button>` : ''}${c.staffId && (MANAGER || isMine(c)) && c.assignStatus !== 'declined' && OPEN.includes(c.stage) ? `<button type="button" class="btn sm danger" data-a="giveUp" data-id="${c.id}">Không khả quan · chuyển sale khác</button>` : ''}${st}</div>`;
    })() : '') + (c ? `<div class="hist"><b>Lịch sử chăm sóc (${hist.length})</b>${hist.slice(0,30).map(a => `<div><span class="num muted">${dm(a.date)}</span><span>${actL(a.type)}${a.cross ? ' (giỏ chéo)' : a.type === 'contract' && a.casa ? ' (Casa)' : ''}${a.amount ? ' · '+fmt(a.amount)+' tỷ' : ''}${a.note ? ' — '+esc(a.note) : ''}</span></div>`).join('') || '<div class="muted">Chưa có hoạt động.</div>'}<div class="muted">Tạo ngày ${dm(c.createdAt)}${c.createdBy === 'web' ? ' · đăng ký trên web'+(c.webCount > 1 ? ' ('+c.webCount+' lần)' : '') : ''}${c.page ? ' · '+esc(c.page) : ''}</div>${c.assignLog ? `<div style="display:block;margin-top:6px"><b>Lịch sử giao khách</b>${esc(c.assignLog).split('\n').map(l => `<div class="muted">${l}</div>`).join('')}</div>` : ''}</div>` : ''),
    onSave: async v => {
      if (!MANAGER) v.staffId = ME.email;
      v.phoneKey = phoneKeyOf(v.phone);
      // Quản lý giao / đổi sale: sale mới phải bấm "Nhận khách" trong ACCEPT_MIN phút, quá hạn cổng tự chuyển người khác.
      const prev = c ? (c.staffId || '') : '';
      if (MANAGER && v.staffId !== prev) {
        if (v.staffId) Object.assign(v, {assignStatus:'pending', assignedAt:Date.now(), assignDeadline:Date.now()+ACCEPT_MIN*60000, tried:'', declineReason:'', assignLog: logAdd(c && c.assignLog, 'Quản lý giao → '+staffName(v.staffId))});
        else Object.assign(v, {assignStatus:'', assignDeadline:0});
      }
      if (!c && v.phone) { const dup = S.customers.find(x => x.phone && x.phone.replace(/\D/g,'') === v.phone.replace(/\D/g,'')); if (dup) toast('Lưu ý: số này trùng với khách '+dup.name); }
      return c ? write(store.update('customers', c.id, v)) : write(store.add('customers', Object.assign(v, {createdAt:today(), lastContact:'', createdBy:ME.email, ts:Date.now()})));
    },
    onDelete: c && MANAGER ? () => store.remove('customers', c.id) : null});
}
function actForm(c, preset){
  const evs = S.events.filter(e => e.date >= addD(today(), -14)), ne = nextEvent();
  openForm({title:'Ghi nhận chăm sóc · '+c.name, data:{type:preset||'call', date:today(), nextFollowUp:addD(today(),3), eventId: ne ? ne.id : ''}, saveL:'Ghi nhận',
    fields:[{k:'type',l:'Hoạt động',t:'select',o:ACTS.map(a => ({v:a.k,l:a.l}))},{k:'date',l:'Ngày',t:'date',req:1},
      {k:'eventId',l:'Sự kiện khách tham dự',t:'select',o:evs.map(e => ({v:e.id, l:dm(e.date)+' · '+e.name})),empty:'— Chọn sự kiện —',full:1},
      {k:'amount',l:'Giá trị HĐ (tỷ VND)',t:'number'},{k:'cross',l:'Bán hàng giỏ chéo (sản phẩm ngoài giỏ hàng của đội)',t:'chk',full:1},
      {k:'nextFollowUp',l:'Hẹn chăm sóc tiếp',t:'date'},{k:'note',l:'Nội dung / kết quả',t:'area'}],
    onOpen: () => { const s = $('#f_type'), a = $('#f_amount').closest('label'), x = $('#f_cross').closest('label'), ev = $('#f_eventId').closest('label'); const sync = () => { a.hidden = x.hidden = s.value !== 'contract'; ev.hidden = s.value !== 'event'; }; s.onchange = sync; sync(); },
    onSave: async v => {
      if (!c.staffId) throw {msg:'Khách này chưa giao cho sale nào. Mở khách và chọn sale phụ trách trước.'};
      if (v.type === 'event' && !v.eventId) throw {msg: S.events.length ? 'Chọn sự kiện khách tham dự' : 'Chưa có sự kiện nào – nhờ quản lý tạo sự kiện ở mục Quản trị'};
      const isDeal = v.type === 'contract', p = byId(S.projects, c.projectId);
      const late = await write(store.add('activities', Object.assign({customerId:c.id, staffId:c.staffId, projectId:c.projectId||'', type:v.type, date:v.date, amount: isDeal ? v.amount : 0, cross: isDeal && v.cross, casa: isDeal && !!(p && CASA.test(p.name||'')), note:v.note, by:ME.email, ts:Date.now()}, v.type === 'event' ? {eventId: v.eventId} : {})));
      const nx = {nextFollowUp: v.nextFollowUp, lastReportAt: Date.now()}; if (v.type !== 'note' && (!c.lastContact || v.date >= c.lastContact)) nx.lastContact = v.date;
      if (c.assignStatus === 'pending' && isMine(c)) Object.assign(nx, {assignStatus:'accepted', acceptedAt:Date.now(), assignLog: logAdd(c.assignLog, staffName(ME.email)+' đã nhận')});
      const order = STAGES.map(s => s.k), adv = {call:'care', visit:'visit', deposit:'deposit', contract:'contract'}[v.type];
      if (adv && c.stage !== 'lost' && order.indexOf(adv) > order.indexOf(c.stage)) nx.stage = adv;
      return (await write(store.update('customers', c.id, nx))) || late;
    }});
}
async function quickCall(c){
  if (!c.staffId) { toast('Khách này chưa giao cho sale nào'); return; }
  try {
    const late = await write(store.add('activities', {customerId:c.id, staffId:c.staffId, projectId:c.projectId||'', type:'call', date:today(), amount:0, note:'', by:ME.email, ts:Date.now()}));
    const nx = {lastContact:today(), lastReportAt:Date.now()}; if (c.stage === 'new') nx.stage = 'care';
    if (c.assignStatus === 'pending' && isMine(c)) Object.assign(nx, {assignStatus:'accepted', acceptedAt:Date.now(), assignLog: logAdd(c.assignLog, staffName(ME.email)+' đã nhận')});
    await write(store.update('customers', c.id, nx)); if (!late) toast('Đã ghi 1 cuộc gọi cho '+c.name);
  } catch(e) { toast(errMsg(e)); }
}
function taskForm(x){
  const staffF = MANAGER ? {k:'staffId', l:'Giao cho', t:'select', o:sellerOpts(), empty:'— Cả đội —'} : {k:'staffId', l:'Giao cho', t:'select', o:[{v:ME.email, l:ME.name}], dis:1};
  openForm({title: x ? 'Sửa việc' : 'Việc cần làm', data: x || {due:today(), priority:'mid', staffId: MANAGER ? (UI.tStaff||'') : ME.email},
    fields:[{k:'title',l:'Nội dung việc',req:1,full:1}, staffF, {k:'due',l:'Hạn chót',t:'date',req:1},
      {k:'priority',l:'Mức độ',t:'select',o:[{v:'high',l:'Gấp'},{v:'mid',l:'Bình thường'},{v:'low',l:'Thấp'}]},
      {k:'customerId',l:'Khách liên quan',t:'select',o:S.customers.filter(c => OPEN.includes(c.stage)).map(c => ({v:c.id, l:c.name+(c.phone ? ' · '+c.phone : '')})),empty:'—'},
      {k:'note',l:'Ghi chú',t:'area'},{k:'done',l:'Đã hoàn thành',t:'chk'}],
    onSave: async v => { if (!MANAGER) v.staffId = ME.email; v.doneAt = v.done ? (x && x.doneAt) || today() : '';
      return x ? write(store.update('tasks', x.id, v)) : write(store.add('tasks', Object.assign(v, {createdAt:today(), createdBy:ME.email}))); },
    onDelete: x && (MANAGER || isMine(x)) ? () => store.remove('tasks', x.id) : null});
}
function staffForm(s){
  openForm({title: s ? 'Sửa thành viên' : 'Thêm thành viên', data: s ? Object.assign({email:s.id, level:'rookie', receiveLeads:true}, s) : {active:true, role:'sale', level:'rookie', receiveLeads:true},
    fields:[{k:'email',l:'Email đăng nhập',t:'email',req:1,full:1,dis:!!s},{k:'name',l:'Họ tên',req:1},{k:'phone',l:'Số điện thoại (Zalo)',t:'tel'},
      {k:'team',l:'Phòng'+(teams().length ? ' (đang có: '+esc(teams().join(', '))+')' : ''), ph:'vd Phòng Phan Hạnh'},{k:'title',l:'Chức danh (tùy chọn)', ph:'vd Giám đốc đối ngoại'},{k:'role',l:'Vai trò',t:'select',o:ROLES.map(r => ({v:r.k,l:r.l}))},
      {k:'level',l:'Bậc / cấp (Trưởng phòng: không tính KPI cá nhân)',t:'select',o:Object.entries(LEVELS).map(([k,lv]) => ({v:k,l:lv.l}))},
      {k:'isSeller',l:'Tính KPI cho Giám đốc / Quản trị này (khi cũng đi bán)',t:'chk',full:1},
      {k:'receiveLeads',l:'Nhận khách web (chia vòng tròn tự động)',t:'chk',full:1},{k:'noEvRep',l:'Không phải báo cáo khách sự kiện hằng ngày',t:'chk',full:1},{k:'active',l:'Đang làm việc (bỏ chọn để khoá đăng nhập)',t:'chk',full:1}],
    extra:'<div class="note">Sale và Trưởng nhóm luôn được tính KPI. Sale chỉ thấy dữ liệu của mình; Trưởng nhóm thấy cả đội; Giám đốc thấy cả đội và cập nhật bảng hàng; Admin bảng hàng chỉ cập nhật bảng hàng (không thấy khách của người khác, không tính KPI); Quản trị làm được tất cả, kể cả thêm thành viên.</div>',
    onSave: async v => {
      const email = (s ? s.id : v.email).toLowerCase(); delete v.email;
      if (!/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(email)) throw {msg:'Email không hợp lệ'};
      if (!s && byId(S.staff, email)) throw {msg:'Email này đã có trong đội'};
      if (s && email === ME.email && v.role !== 'admin' && !ME.owner) throw {msg:'Không thể tự hạ quyền Quản trị của chính mình'};
      return write(store.set('members', email, v));
    },
    onDelete: s && s.id !== ME.email ? () => store.remove('members', s.id) : null});
}
const SAPHIA = {name:'Sun Saphia Residence', location:'Ven biển Đà Nẵng', developer:'Sun Group (Sun Property)', type:'Căn hộ', status:'Sắp mở bán', link4d:'https://crm-sale-danang.netlify.app/4d/sun-saphia-4d.html',
  note:'Dự án căn hộ mặt biển đầu tiên của Sun Group tại Đà Nẵng. Khu đất 3.720,1 m²; 30 tầng / 114 m; 2 tầng hầm; 782 căn: Studio 513 căn 30–31 m², 1PN+1 108 căn 50–51 m², 2PN 149 căn 60–70 m². Tiện ích biển: tắm biển, dù lượn, kayak, SUP, mô tô nước. Dự kiến bàn giao 11/2028. Lộ trình: tung tin 17/10/2026 · Kick off 23/10/2026 · Mở bán cuối 11/2026. Chưa có giá & chính sách bán hàng chính thức.'};
function projForm(p, preset){
  const d4 = p ? def4d(p.name) : [];
  openForm({title: p ? 'Sửa dự án' : 'Thêm dự án', data: p ? Object.assign({}, p, {link360: p.link360 || def360(p.name), link4d: (/githack\.com\/.*projects\/sun-saphia\/4d\//.test(p.link4d || '') ? '' : p.link4d) || d4[0] || ''}) : Object.assign({status:'Đang bán'}, preset || {}),
    fields:[{k:'name',l:'Tên dự án',req:1,full:1},{k:'location',l:'Vị trí'},{k:'developer',l:'Chủ đầu tư'},{k:'type',l:'Loại hình'},
      {k:'status',l:'Trạng thái',t:'select',o:['Đang bán','Sắp mở bán','Đã bàn giao','Tạm dừng'].map(x => ({v:x,l:x}))},{k:'note',l:'Ghi chú (giá, CSBH…)',t:'area'},
      {k:'link360',l:'Link 360 / tham quan ảo – mỗi dòng 1 link, có thể ghi tên trước, vd “Tòa F2: https://…”',t:'area'}]
      .concat(BH ? [{k:'link4d',l:'Link mô hình 4D (nhúng)',full:1,ph:'https://… – hiện tab “4D căn hộ” trong Bảng hàng (chỉ xem nội bộ)'}] : []),
    onSave: async v => { if (v.link360 && !links360(v.link360).length) throw {msg: 'Link 360 phải bắt đầu bằng https://'};
      for (const k of ['link4d']) { if (k in v) { v[k] = String(v[k] || '').trim(); if (v[k] && !/^https:\/\//.test(v[k])) throw {msg: 'Link 4D phải bắt đầu bằng https://'}; } } return p ? write(store.update('projects', p.id, v)) : write(store.add('projects', Object.assign(v, {order: S.projects.length+1}))); },
    onDelete: p ? () => store.remove('projects', p.id) : null});
}
function evReportForm(){
  const e = repEvent(); if (!e) return toast('Chưa có sự kiện nào cần báo cáo hằng ngày');
  const t = today(), cur = evRep(e.id, t, ME.email), prev = cur || lastRep(e.id, ME.email);
  openForm({title: 'Báo cáo khách sự kiện · ' + dm(t), saveL: cur ? 'Cập nhật báo cáo' : 'Gửi báo cáo',
    data: prev ? {status: prev.status, guests: prev.guests, people: prev.people, interest: prev.interest, note: cur ? cur.note : ''} : {status: 'none', people: 0, interest: 'unk'},
    fields:[{k:'status',l:e.name + ' (' + dm(e.date) + ') – tình trạng hôm nay',t:'select',o:REP_ST,full:1},
      {k:'guests',l:'Tên khách (nhiều khách cách nhau dấu phẩy)',ph:'vd Anh Minh, chị Lan',full:1},
      {k:'people',l:'Tổng số người đi',t:'number'},{k:'interest',l:'Mức quan tâm',t:'select',o:REP_INT},
      {k:'note',l:'Tình hình hôm nay (đã gọi ai, khách nói gì, vướng gì, cần hỗ trợ gì)',t:'area'}],
    onSave: async v => {
      if (v.status !== 'none' && !v.guests) throw {msg: 'Ghi tên khách đang mời / đã xác nhận'};
      if (v.status === 'yes' && !(v.people > 0)) throw {msg: 'Ghi số người đi'};
      if (v.status === 'none' && !v.note) throw {msg: 'Chưa có khách: ghi ngắn tình hình hôm nay (đã mời ai, vì sao chưa có)'};
      if (v.status === 'none') { v.guests = ''; v.people = 0; v.interest = 'unk'; }
      const late = await write(store.set('eventReports', e.id + '_' + t + '_' + ME.email, Object.assign(v, {eventId: e.id, date: t, staffId: ME.email, team: ME.team || '', ts: Date.now(), late: nowHM() >= repBy(e)})));
      evRepSync().catch(() => {}); // ghi sang Google Sheet trên Drive (chạy nền, lỗi không chặn sale)
      return late; }});
}
/* Đồng bộ báo cáo sang Google Sheet (cổng Apps Script ?action=evrep). Quản lý nhận lại link bảng tính. */
async function evRepSync(){
  if (store.kind !== 'firebase') return null;
  const idToken = await store.getIdToken();
  const r = await fetch(CHAT_URL.replace('action=chat', 'action=evrep'), {method:'POST', headers:{'Content-Type':'text/plain;charset=utf-8'}, body: JSON.stringify({idToken})});
  const j = await r.json(); if (!j.ok) throw new Error(j.error || 'Chưa ghi được vào Google Sheet');
  return j;
}
async function evRepSheet(b){
  const w = window.open('', '_blank'); b.disabled = true; const old = b.textContent; b.textContent = 'Đang mở…';
  try { const j = await evRepSync(); if (j && j.url) { if (w) w.location = j.url; else location.href = j.url; } else { if (w) w.close(); toast(j ? 'Đã ghi vào Google Sheet' : 'Google Sheet chỉ chạy khi đăng nhập CRM thật'); } }
  catch (e) { if (w) w.close(); toast(e.message || 'Chưa mở được Google Sheet'); }
  finally { b.disabled = false; b.textContent = old; }
}
async function evReportCopy(){
  const e = repEvent(); if (!e) return; const t = today(), sm = repSummary(e, t);
  const msg = 'BÁO CÁO KHÁCH SỰ KIỆN ' + e.name.toUpperCase() + ' (' + dm(e.date) + (e.place ? ', ' + e.place : '') + ')\nNgày ' + dm(t) + ' – ' + sm.sent + '/' + sm.n + ' sale đã báo cáo · ' + sm.has + ' sale có khách xác nhận · dự kiến ' + sm.ppl + ' người\n' +
    sm.rs.map(({s, r}, i) => (repAll() && (i === 0 || sm.rs[i-1].s.team !== s.team) ? '— ' + (s.team || 'Chưa xếp phòng') + ' —\n' : '') + (i + 1) + '. ' + s.name + ': ' + repLine(r)).join('\n');
  try { await navigator.clipboard.writeText(msg); toast('Đã copy tổng hợp, dán vào nhóm Zalo'); } catch(_) { toast('Không copy được: ' + msg); }
}
function eventForm(e){
  let imgs = e ? [].concat(e.posters || [], e.poster ? [e.poster] : []) : [], lib = evLibSel(e).slice();
  openForm({title: e ? 'Sửa sự kiện' : 'Tạo sự kiện', saveL: e ? 'Lưu' : 'Tạo', data: e ? Object.assign({reportBy: '17:00'}, e) : {date: addD(today(), 7), time: '9:00', minGuests: 1, fine: EVENT_FINE, needGuest: true, dailyReport: true, reportBy: '17:00'},
    fields:[{k:'name',l:'Tên sự kiện',req:1,full:1},{k:'date',l:'Ngày',t:'date',req:1},{k:'time',l:'Giờ'},{k:'place',l:'Địa điểm',full:1},
      {k:'projectId',l:'Dự án',t:'select',o:projOpts(),empty:'—'},{k:'minGuests',l:'Số khách tối thiểu mỗi sale',t:'number'},
      {k:'fine',l:'Phạt nếu không đủ khách (đ) – lần liên tiếp sau cộng thêm',t:'number'},{k:'needGuest',l:'Tính phạt khi không đủ khách',t:'chk',full:1},{k:'dailyReport',l:'Sale phải báo cáo khách hằng ngày (có khách hay chưa, tên, số người, mức quan tâm)',t:'chk',full:1},{k:'reportBy',l:'Hạn báo cáo mỗi ngày (giờ:phút)',ph:'17:00'},
      {k:'perks',l:'Dòng phụ dưới giờ tổ chức trên ảnh, vd “Teabreak · Bốc thăm may mắn”',full:1},
      {k:'highlights',l:'Điểm nổi bật in trên ảnh – tối đa 3 dòng dạng “số | mô tả”, vd “~700 tr | vốn ban đầu căn 2PN”',t:'area'},
      {k:'hashtags',l:'Hashtag – tự gắn cuối mỗi bài khi copy',full:1,ph:'#SunFourSTower #ToaF2 #SunGroup'},
      {k:'posterUrl',l:'Ảnh sự kiện – dán link ảnh (https://…), hoặc tải ảnh lên ở ô bên dưới',full:1,ph:'https://…/poster.jpg'},
      {k:'posts',l:'Thông điệp đăng theo ngày – mỗi đoạn bắt đầu bằng ngày, vd “14/10: …” hoặc “D-3: …” (D-0 = ngày sự kiện). Để trống: CRM tự gợi ý bài mỗi ngày.',t:'area'},{k:'note',l:'Ghi chú (chương trình, quà tặng, chính sách tại sự kiện…)',t:'area'}],
    extra: `<label class="full">Tải ảnh sự kiện lên (poster, thư mời – tối đa ${EV_MAX_IMG} ảnh, mỗi ngày CRM tự đổi 1 ảnh)<input type="file" id="evPosterFile" accept="image/*" multiple></label><div class="full row" id="evPosterBox"></div>
      <div class="full"><div style="font-size:12.5px;color:var(--muted);margin-bottom:4px">Hoặc chọn ảnh có sẵn của CRM (bấm để chọn / bỏ chọn)</div><div class="row" id="evLibBox"></div></div>`,
    onOpen: () => { const box = $('#evPosterBox'), show = () => { box.innerHTML = imgs.map((u, i) => `<span style="position:relative;display:inline-block"><img src="${esc(u)}" alt="Ảnh ${i + 1}" style="height:90px;border-radius:8px;display:block"><button type="button" class="btn sm danger" data-del="${i}" style="position:absolute;top:2px;right:2px;padding:0 6px">✕</button></span>`).join('');
        box.querySelectorAll('[data-del]').forEach(b => b.onclick = () => { imgs.splice(Number(b.dataset.del), 1); show(); }); };
      const lb = $('#evLibBox'), showLib = () => { lb.innerHTML = EV_LIB.map(([u, l]) => `<button type="button" class="evlib ${lib.includes(u) ? 'on' : ''}" data-u="${esc(u)}" title="${esc(l)}"><img src="${esc(u)}" alt="${esc(l)}"><span>${lib.includes(u) ? '✓ ' : ''}${esc(l)}</span></button>`).join('');
        lb.querySelectorAll('[data-u]').forEach(b => b.onclick = () => { const u = b.dataset.u; lib = lib.includes(u) ? lib.filter(x => x !== u) : lib.concat(u); showLib(); }); };
      showLib();
      show(); $('#evPosterFile').onchange = async ev => { const fs = [...ev.target.files].slice(0, EV_MAX_IMG - imgs.length); if (!fs.length) return toast('Tối đa ' + EV_MAX_IMG + ' ảnh – bỏ bớt ảnh cũ trước');
        const per = Math.floor(880000 / Math.min(EV_MAX_IMG, imgs.length + fs.length)); // cả tài liệu sự kiện phải dưới 1 MB
        try { const all = await Promise.all(imgs.map(u => u.startsWith('data:') && u.length > per ? fetch(u).then(r => r.blob()).then(b => shrinkImage(b, per)) : u));
          imgs = all.concat(await Promise.all(fs.map(f => shrinkImage(f, per)))); show(); toast('Đã thêm ' + fs.length + ' ảnh – bấm Lưu để cập nhật'); } catch (err) { toast(err.message); } ev.target.value = ''; }; },
    onSave: async v => { if (v.posterUrl && !/^https:\/\//i.test(v.posterUrl)) throw {msg: 'Link ảnh phải bắt đầu bằng https://'}; v.posters = imgs; v.poster = ''; v.libImgs = lib; if (e && e._preset) v.postsCustom = v.posts !== EV_PRESET_1810.posts || lib.length !== EV_LIB_FOURS.length; v.minGuests = Math.max(1, Math.round(v.minGuests || 1)); v.fine = v.fine || EVENT_FINE; v.reportBy = /^\d{1,2}:\d{2}$/.test(v.reportBy) ? v.reportBy.padStart(5, '0') : '17:00';
      return e ? write(store.update('events', e.id, v)) : write(store.add('events', Object.assign(v, {createdAt: Date.now(), by: ME.email}))); },
    onDelete: e ? () => store.remove('events', e.id) : null});
}
function focusForm(){
  const cur = focusToday() || {};
  openForm({title:'Mã căn chạy chung', saveL:'Lưu', data:{day: today(), code: cur.code || '', projectId: cur.projectId || (S.projects.find(p => /four\s*s/i.test(p.name || '')) || {}).id || '', note: cur.note || ''},
    fields:[{k:'day',l:'Ngày',t:'date',req:1},{k:'code',l:'Mã căn (ví dụ F2-11-31)',req:1},{k:'projectId',l:'Dự án',t:'select',o:projOpts(),empty:'—'},{k:'note',l:'Gợi ý nội dung (giá, ưu đãi, điểm nhấn căn…)',t:'area'}],
    onSave: async v => { const day = v.day; delete v.day; v.code = v.code.toUpperCase(); return write(store.set('focus', day, Object.assign(v, {by: ME.email, at: Date.now()}))); }});
}
async function focusPost(slot){
  const fc = focusToday(); if (!fc) return;
  if (slotDone(slot, ME.email)) { toast('Bạn đã ghi nhận đăng lúc ' + slot); return; }
  try { const late = await write(store.add('activities', {customerId:'', staffId:ME.email, projectId:fc.projectId || '', type:'post', slot, focusCode:fc.code, date:today(), amount:0, note:'Mã căn chạy chung ' + fc.code + ' (' + slot + ')', by:ME.email, ts:Date.now()}));
    if (!late) toast('Đã ghi nhận đăng mã căn ' + fc.code + ' lúc ' + slot); } catch(e) { toast(errMsg(e)); }
}
function annForm(a){
  openForm({title: a ? 'Sửa thông báo' : 'Đăng thông báo dự án', saveL: a ? 'Lưu' : 'Đăng', data: a || {projectId:'', important:false, until:addD(today(), 14)},
    fields:[{k:'title',l:'Tiêu đề',req:1,full:1},{k:'projectId',l:'Dự án',t:'select',o:projOpts(),empty:'Tất cả dự án'},{k:'until',l:'Hiển thị đến ngày (để trống = luôn hiện)',t:'date'},
      {k:'body',l:'Nội dung: CSBH mới, đợt mở bán, thay đổi giá, lịch sự kiện…',t:'area',req:1},{k:'important',l:'Quan trọng (đánh dấu đỏ)',t:'chk',full:1}],
    extra:'<div class="note">Cả đội thấy ngay trên Tổng quan, nhận thông báo trên điện thoại (nếu đã bật), và Quân sư dùng nội dung này khi tư vấn.</div>',
    onOpen: () => { const b = $('#f_body'); if (b) b.style.minHeight = '160px'; },
    onSave: async v => a ? write(store.update('announcements', a.id, v)) : write(store.add('announcements', Object.assign(v, {date: today(), createdAt: Date.now(), by: ME.email, byName: ME.name}))),
    onDelete: a ? () => store.remove('announcements', a.id) : null});
}
function annView(a){
  if (!a) return;
  annMarkRead([a.id]); render();
  openForm({title: a.title, fields: [], saveL: 'Đóng',
    extra: `<div class="note row">${a.important ? '<span class="chip c-bad">Quan trọng</span>' : ''}<span class="chip c-info">${a.projectId ? esc(projName(a.projectId)) : 'Tất cả dự án'}</span><span>${dm(a.date)} · ${esc(a.byName || '')}${a.until ? ' · hiển thị đến '+dm(a.until) : ''}</span></div>
      <div style="grid-column:1/-1;white-space:pre-wrap;overflow-wrap:anywhere;line-height:1.6">${esc(a.body)}</div>${MANAGER ? `<div style="grid-column:1/-1"><button type="button" class="btn sm" data-a="editAnn" data-id="${a.id}">Sửa thông báo</button></div>` : ''}`,
    onSave: async () => true});
}
function giveUpForm(c){
  if (!c) return;
  openForm({title:'Không khả quan · '+c.name, saveL:'Chuyển sale khác', data:{},
    fields:[{k:'reason',l:'Lý do (khách nói gì, đã làm gì)',t:'area',req:1}],
    extra:`<div class="note">Khách sẽ được chuyển cho sale tiếp theo trong vòng vài phút. ${MANAGER ? '' : 'Bạn sẽ không còn thấy khách này.'}</div>`,
    onSave: async v => {
      await write(store.add('activities', {customerId:c.id, staffId:c.staffId, projectId:c.projectId||'', type:'note', date:today(), amount:0, note:'Không khả quan: '+v.reason, by:ME.email, ts:Date.now()}));
      return write(store.update('customers', c.id, {assignStatus:'declined', assignDeadline:0, declineReason:v.reason.slice(0,200), assignLog: logAdd(c.assignLog, staffName(c.staffId)+' · không khả quan: '+v.reason.slice(0,120))}));
    }});
}
function workForm(){
  const staffF = MANAGER ? {k:'staffId', l:'Của sale', t:'select', o:sellerOpts(), req:1} : {k:'staffId', l:'Của sale', t:'select', o:[{v:ME.email, l:ME.name}], dis:1};
  openForm({title:'Ghi nhận video / bài đăng', data:{type:'video', date:today(), staffId: MANAGER ? (sellers()[0]||{}).id : ME.email}, saveL:'Ghi nhận',
    fields:[{k:'type',l:'Loại',t:'select',o:WORK.map(w => ({v:w.k,l:w.l}))},{k:'date',l:'Ngày đăng',t:'date',req:1}, staffF,
      {k:'link',l:'Link bài / video (Facebook, TikTok, YouTube…)',t:'url',full:1},{k:'note',l:'Hashtag / ghi chú',t:'area'}],
    extra:'<div class="note">Video 1 điểm, bài content tự tạo 0,5 điểm. Dán link để quản lý kiểm tra khi chấm quý.</div>',
    onSave: async v => { if (!MANAGER) v.staffId = ME.email; if (!v.staffId) throw {msg:'Chọn sale'};
      return write(store.add('activities', {customerId:'', staffId:v.staffId, projectId:'', type:v.type, date:v.date, amount:0, link:v.link, note:v.note, by:ME.email, ts:Date.now()})); }});
}
function discForm(id){
  const r = range('quarter', UI.qo), key = qKey(r)+'_'+id, sc = S.scores[key] || {};
  openForm({title:'Tác phong, kỷ luật, training · '+staffName(id), data:{discipline: sc.discipline ?? 4, note: sc.note || ''},
    fields:[{k:'discipline',l:'Điểm '+r.label.toLowerCase()+' (0–4)',t:'number',req:0},{k:'note',l:'Nhận xét',t:'area'}],
    onSave: async v => { const n = Number(v.discipline); if (!(n >= 0 && n <= 4)) throw {msg:'Điểm từ 0 đến 4'};
      return write(store.set('scores', key, {staffId:id, quarter:qKey(r), discipline:n, note:v.note, by:ME.email, ts:Date.now()})); }});
}
function scoreDetail(id){
  const r = range('quarter', UI.qo), x = scoreOf(id, r);
  const list = S.activities.filter(a => a.staffId === id && a.date >= r.s && a.date <= r.e && ['contract','video','post','visit'].includes(a.type)).sort((a,b) => (b.date||'').localeCompare(a.date||''));
  const cust = a => a.customerId && byId(S.customers, a.customerId) ? ' · '+esc(byId(S.customers, a.customerId).name) : '';
  const row = a => `<div><span class="num muted">${dm(a.date)}</span><span>${actL(a.type)}${a.type==='contract' ? ' · '+({normal:'thường',casa:'Casa',cross:'giỏ chéo'}[dealKind(a)])+' · '+esc(projName(a.projectId)) : ''}${cust(a)}${/^https?:\/\//i.test(a.link || '') ? ` · <a href="${esc(a.link)}" target="_blank" rel="noopener">link</a>` : ''}${a.note ? ' — '+esc(a.note) : ''}</span></div>`;
  openForm({title: staffName(id)+' · '+r.label, fields:[], saveL:'Đóng',
    extra:`<div class="hist" style="border:0;padding:0"><b>${x.lv.l} · ${fmt(x.total)}/100 · ${x.grade.l}</b><div class="muted">Deal ${fmt(x.dealPts)} · video + bài ${fmt(x.mediaPts)} · mời khách ${fmt(x.visitPts)} · tác phong ${x.disc == null ? 'chưa chấm' : fmt(x.disc)}${x.note ? ' ('+esc(x.note)+')' : ''}</div>${list.map(row).join('') || '<div class="muted">Chưa có hoạt động tính điểm trong quý.</div>'}</div>`,
    onSave: async () => true});
}
let tgWho = 'default';
function targetForm(){
  const who = tgWho;
  const curT = who === 'default' ? Object.fromEntries(PERIODS.map(p => [p.k, Object.assign({}, DEF_T[p.k], (S.kpi.default||{})[p.k]||{})])) : Object.fromEntries(PERIODS.map(p => [p.k, targets(who, p.k)]));
  const grid = `<div class="tgrid"><table><thead><tr><th>Chỉ tiêu</th>${PERIODS.map(p => `<th>${p.l}</th>`).join('')}</tr></thead><tbody>${METRICS.map(m => `<tr><td>${m.l}</td>${PERIODS.map(p => `<td><input type="number" min="0" step="any" id="t_${p.k}_${m.k}" value="${esc(curT[p.k][m.k])}"></td>`).join('')}</tr>`).join('')}</tbody></table></div>
    <div class="note">Để 0 nếu không tính chỉ tiêu đó. ${who === 'default' ? 'Áp dụng cho mọi sale chưa có chỉ tiêu riêng.' : 'Chỉ tiêu riêng ghi đè chỉ tiêu mặc định.'}</div>`;
  openForm({title:'Đặt chỉ tiêu KPI', data:{who},
    fields:[{k:'who',l:'Áp dụng cho',t:'select',full:1,o:[{v:'default',l:'Mặc định cho mọi sale'}].concat(sellers().map(s => ({v:s.id, l:s.name+(S.kpi[s.id] ? ' (riêng)' : '')})))}],
    extra: grid,
    onOpen: () => { $('#f_who').onchange = e => { tgWho = e.target.value; targetForm(); };
      if (who !== 'default' && S.kpi[who]) { const b = document.createElement('button'); b.type = 'button'; b.className = 'btn'; b.textContent = 'Bỏ chỉ tiêu riêng'; b.onclick = async () => { try { await write(store.remove('kpiTargets', who)); targetForm(); toast('Đã dùng chỉ tiêu mặc định'); } catch(e) { toast(errMsg(e)); } }; $('#dlgLeft').appendChild(b); } },
    onSave: async () => { const d = {}; PERIODS.forEach(p => { d[p.k] = {}; METRICS.forEach(m => { d[p.k][m.k] = Number(document.getElementById('t_'+p.k+'_'+m.k).value) || 0; }); }); return write(store.set('kpiTargets', who, d)); }});
}

/* ---------- events ---------- */
function go(v){ UI.view = VIEWS.includes(v) ? v : 'tong-quan'; try { history.replaceState(null, '', '#'+UI.view); } catch(e){} render(); try { window.scrollTo(0,0); } catch(e){} }
// Link #bao-cao-su-kien: mở thẳng form báo cáo khách sự kiện (chờ đăng nhập + dữ liệu sự kiện về rồi mới mở).
let wantRep = location.hash === '#bao-cao-su-kien';
function tryRep(){ if (!wantRep || !ME || !repEvent()) return; wantRep = false; try { history.replaceState(null, '', '#tong-quan'); } catch(e) {} setTimeout(evReportForm, 700); }
function route(){ const h = location.hash.slice(1); if (h === 'bao-cao-su-kien') wantRep = true; UI.view = VIEWS.includes(h) ? h : 'tong-quan'; render(); tryRep(); }
window.addEventListener('hashchange', route);
document.addEventListener('click', async e => {
  const ln = e.target.closest('a[href^="#"]');
  if (ln && ME) { e.preventDefault(); go(ln.getAttribute('href').slice(1)); return; }
  const b = e.target.closest('[data-a]'); if (!b || b.tagName === 'INPUT' || !ME) return;
  const a = b.dataset.a, id = b.dataset.id;
  if (a === 'addCust') custForm(); else if (a === 'editCust') custForm(byId(S.customers, id));
  else if (a === 'logAct') { const c = byId(S.customers, id); if (c) actForm(c); }
  else if (a === 'quickCall') { const c = byId(S.customers, id); if (c) quickCall(c); }
  else if (a === 'addTask') taskForm(); else if (a === 'editTask') taskForm(byId(S.tasks, id));
  else if (a === 'doneTask') write(store.update('tasks', id, {done:true, doneAt:today()})).then(l => { if (!l) toast('Đã hoàn thành'); }, err => toast(errMsg(err)));
  else if (a === 'addStaff') staffForm(); else if (a === 'editStaff') staffForm(byId(S.staff, id));
  else if (a === 'toggleStaff') { const s = byId(S.staff, id); if (!s || id === ME.email) return; const on = s.active === false;
    if (!on && !b.dataset.sure) { b.dataset.sure = 1; b.textContent = 'Bấm lần nữa để khoá'; setTimeout(() => { delete b.dataset.sure; b.textContent = 'Khoá'; }, 3000); return; }
    write(store.update('members', id, {active: on})).then(l => { if (!l) toast((on ? 'Đã mở lại ' : 'Đã khoá ') + (s.name || id)); }, err => toast(errMsg(err))); }
  else if (a === 'addProj') projForm(); else if (a === 'addSaphia') projForm(null, SAPHIA); else if (a === 'editProj') projForm(byId(S.projects, id));
  else if (a === 'seedProj') { b.disabled = true; try { for (const p of SAMPLE_PROJECTS) await write(store.add('projects', p)); toast('Đã thêm ' + SAMPLE_PROJECTS.length + ' dự án, hãy kiểm tra lại thông tin'); } catch(err) { toast(errMsg(err)); } }
  else if (a === 'viewStaffCust') { UI.fStaff = id; UI.fProj = ''; go('khach-hang'); }
  else if (a === 'viewProjCust') { UI.fProj = id; UI.fStaff = ''; go('khach-hang'); }
  else if (a === 'kp') { UI.kp = b.dataset.k; UI.ko = 0; render(); }
  else if (a === 'ko') { const d = Number(b.dataset.d); UI.ko = d ? UI.ko + d : 0; render(); }
  else if (a === 'editTargets') { tgWho = 'default'; targetForm(); }
  else if (a === 'acceptLead') { const c = byId(S.customers, id); if (!c) return; b.disabled = true;
    write(store.update('customers', id, {assignStatus:'accepted', acceptedAt:Date.now(), lastReportAt:Date.now(), assignLog: logAdd(c.assignLog, staffName(ME.email)+' đã nhận')})).then(l => { if (!l) toast('Đã nhận khách '+c.name+'. Nhớ cập nhật tình hình ít nhất mỗi '+REPORT_DAYS+' ngày'); }, err => { b.disabled = false; toast(errMsg(err)); }); }
  else if (a === 'declineLead') { const c = byId(S.customers, id); if (!c) return; if (b.dataset.c !== '1') { b.dataset.c = '1'; b.textContent = 'Bấm lần nữa để trả khách'; return; }
    write(store.update('customers', id, {assignStatus:'declined', assignDeadline:0, declineReason:'', assignLog: logAdd(c.assignLog, staffName(ME.email)+' từ chối')})).then(l => { if (!l) toast('Đã trả khách – khách về lại quản lý để giao người khác'); }, err => toast(errMsg(err))); }
  else if (a === 'giveUp') giveUpForm(byId(S.customers, id));
  else if (a === 'addEvent') eventForm();
  else if (a === 'evReport') evReportForm();
  else if (a === 'copy360') { const p = byId(S.projects, id), ls = p ? links360(p360(p)) : [];
    const msg = 'Tham quan 360 dự án ' + (p ? p.name : '') + ':\n' + ls.map(x => (ls.length > 1 ? x.l + ': ' : '') + x.u).join('\n');
    navigator.clipboard.writeText(msg).then(() => toast('Đã copy link 360, dán gửi khách qua Zalo'), () => toast(msg)); }
  else if (a === 'evReportCopy') evReportCopy();
  else if (a === 'evRepSheet') evRepSheet(b);
  else if (a === 'editEvent') { const e = evById(id); if (isContent(e)) contentForm(e); else eventForm(e); }
  else if (a === 'addContent') contentForm();
  else if (a === 'seedSaphiaContent') { b.disabled = true; try { const pj = (S.projects.find(p => /saphia/i.test(p.name || '')) || {}).id || '', todo = saphiaMissing();
      for (const p of todo) { const {key, ...v} = p; await write(store.add('events', Object.assign(v, {seedKey: key, kind: 'content', date: addD(v.startDate, 6), projectId: pj, libImgs: SAPHIA_LIB.map(x => x[0]), posters: [], dailyReport: false, needGuest: false, createdAt: Date.now(), by: ME.email}))); }
      toast('Đã nạp ' + todo.length + ' tuần content Sun Saphia'); } catch(err) { toast(errMsg(err)); b.disabled = false; } }
  else if (a === 'savePhone') { const v = ($('#myPhoneIn') || {}).value || '', d = v.replace(/\D/g, ''); if (d.length < 9 || d.length > 12) return toast('Số điện thoại chưa đúng');
    const ph = v.trim(); LS.set('crm-phone:' + ME.email, ph); b.disabled = true;
    try { if (byId(S.staff, ME.email)) await store.update('members', ME.email, {phone: ph}); toast('Đã lưu số ' + ph); } catch (_) { toast('Đã lưu số ' + ph + ' trên máy này'); } render(); }
  else if (a === 'evPostMark') { const e = evById(id), k = b.dataset.k || today(); if (!e || evPostDone(id, ME.email, k)) return; b.disabled = true;
    try { await write(store.add('activities', {customerId:'', staffId:ME.email, projectId:e.projectId || '', type:'evpost', eventId:id, slot:k, date:today(), amount:0, note:'Đăng bài sự kiện ' + e.name + ' (' + kLab(k) + ')', by:ME.email, ts:Date.now()})); toast('Đã ghi nhận đăng bài sự kiện hôm nay'); } catch (err) { b.disabled = false; toast(errMsg(err)); } }
  else if (a === 'evPostCopy') { const e = evById(id); if (e) { const txt = evPostFor(e, b.dataset.k).txt; navigator.clipboard.writeText(txt).then(() => toast('Đã copy bài ' + kLab(b.dataset.k) + ' ngày ' + dm(kDate(b.dataset.k))), () => toast(txt)); } }
  else if (a === 'evPosterDl') { e.preventDefault && e.preventDefault(); const ev = evById(id), im = ev ? evImgs(ev) : [], src = im[Number(b.dataset.k) || 0] || im[0], day = b.dataset.d || today();
    const fname = 'su-kien-' + (ev.date || '') + '-' + String(day).replace('@', '-').replace(':', 'h') + '-' + ((Number(b.dataset.k) || 0) + 1) + '.jpg';
    const ready = src && EV_READY[ev.id + '|' + day + '|' + src];
    if (ready) { evSaveImg(ready, fname); if (!IOS_DEV) toast('Đã tải ảnh có tên + số điện thoại của bạn'); } // ảnh đã ghép sẵn → lưu ngay trong lần chạm (iPhone mở Chia sẻ)
    else if (src) { toast('Đang ghép ảnh có tên + SĐT…'); evBrand(ev, day, src).then(u => { if (IOS_DEV) evImgView(u, fname); else { evSaveImg(u, fname); toast('Đã tải ảnh có tên + số điện thoại của bạn'); } },
      () => { if (IOS_DEV) evImgView(src, fname); else { evSaveImg(src, fname); toast('Ảnh này không gắn được tên – đã tải ảnh gốc'); } }); } }
  else if (a === 'focusSet') focusForm();
  else if (a === 'focusPost') { b.disabled = true; focusPost(b.dataset.k); }
  else if (a === 'addAnn') annForm();
  else if (a === 'editAnn') annForm(byId(S.ann, id));
  else if (a === 'annOpen') annView(byId(S.ann, id));
  else if (a === 'annReadAll') { annMarkRead(annActive().map(x => x.id)); render(); }
  else if (a === 'aiCust') { const c = byId(S.customers, id); if (!c) return; dlg.close(); aiOpen(`Tóm tắt khách ${c.name}${c.phone ? ' (' + c.phone + ')' : ''}: tình hình hiện tại, mức độ tiềm năng và 3 bước nên làm tiếp. Soạn sẵn 1 tin Zalo phù hợp để gửi khách.`); }
  else if (a === 'zaloToSale') { const c = byId(S.customers, id), s = c && byId(S.staff, c.staffId); if (!s) return;
    const msg = `Giao khách: ${c.name} - ${c.phone || ''}${c.projectId ? ' - ' + projName(c.projectId) : ''}${c.budget ? ' - ' + c.budget : ''}. Vào CRM bấm "Nhận khách" trong ${ACCEPT_MIN} phút: ${location.origin}/`;
    try { await navigator.clipboard.writeText(msg); toast('Đã copy nội dung, dán vào Zalo của '+s.name); } catch(_) { toast('Copy nội dung này gửi Zalo: '+msg); }
    window.open(zaloUrl(s.phone), '_blank', 'noopener'); }
  else if (a === 'kmode') { UI.kmode = b.dataset.k; render(); }
  else if (a === 'qo') { const d = Number(b.dataset.d); UI.qo = d ? UI.qo + d : 0; render(); }
  else if (a === 'addWork') workForm();
  else if (a === 'scoreDisc') discForm(id);
  else if (a === 'scoreDetail') scoreDetail(id);
  else if (a === 'applyLevel') { b.disabled = true; write(store.update('members', id, {level: b.dataset.k})).then(l => { if (!l) toast('Đã chuyển '+staffName(id)+' sang '+LEVELS[b.dataset.k].l); }, err => { b.disabled = false; toast(errMsg(err)); }); }
  else if (a === 'install' && installEvt) { installEvt.prompt(); try { await installEvt.userChoice; } catch(_){} installEvt = null; render(); }
  else if (a === 'enableNotify') { try { await Notification.requestPermission(); } catch(_){} render(); if (Notification.permission === 'granted') { try { localStorage.removeItem('crm-notified-'+today()); } catch(_){} dailyNotify(); } }
  else if (a === 'testNotify') { try { const reg = await navigator.serviceWorker.ready; reg.showNotification('CRM Sale Đà Nẵng', {body:'Thông báo đang hoạt động.', icon:'icons/icon-192.png'}); } catch(_) { toast('Không gửi được thông báo trên trình duyệt này'); } }
  else if (a === 'signOut') { signOutAll(); if (store.kind === 'demo') { location.hash = ''; location.reload(); } else store.signOut(); }
  else if (a === 'resetDemo') { if (b.dataset.c !== '1') { b.dataset.c = '1'; b.textContent = 'Bấm lần nữa để xoá hết'; return; } store.reset(); location.reload(); }
});
document.addEventListener('change', e => {
  const t = e.target; if (!ME) return;
  if (t.dataset.a === 'toggleTask') { write(store.update('tasks', t.dataset.id, {done:t.checked, doneAt: t.checked ? today() : ''})).catch(err => { toast(errMsg(err)); render(); }); return; }
  if (t.id === 'fStaff') UI.fStaff = t.value; else if (t.id === 'fProj') UI.fProj = t.value; else if (t.id === 'fStage') UI.fStage = t.value; else if (t.id === 'tStaff') UI.tStaff = t.value; else if (t.id === 'fTeam') UI.fTeam = t.value; else return;
  render();
});
document.addEventListener('input', e => { if (e.target.id === 'fq') { UI.q = e.target.value; render(); } });

/* ---------- boot ---------- */
(async function boot(){
  if (!CONFIGURED || (location.hostname === 'localhost' && /[?&]demo/.test(location.search))) { showSetup(); return; }
  try { store = await firebaseStore(); }
  catch(e) { gate(`<b class="t">Không mở được CRM</b><p>Không tải được Firebase. Kiểm tra kết nối mạng rồi tải lại trang.</p><button class="btn pri block" onclick="location.reload()">Tải lại</button>`); return; }
  store.onAuth(u => { if (u) onSignedIn(u); else { signOutAll(); showLogin(); } });
  // Quay về sau khi đăng nhập Google kiểu chuyển trang: báo lỗi nếu có
  store.redirectResult().catch(e => showLogin('Không đăng nhập được bằng Google (' + (e && e.code || 'lỗi') + '). Thử mở bằng Chrome/Safari hoặc đăng nhập bằng email.'));
})();
