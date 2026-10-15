// Trang tòa nhà độc lập (toa-nha.html): chỉ tải phần tòa nhà, không tải trình vẽ / trình xem căn hộ.
import { mountBuildingUI } from './buildingUI.js';
import { ask, toast, download } from './ui.js';

const PLAN_KEY = 'floorplan3d.plan.v2';

window.__bview = mountBuildingUI({
  toast, ask, download,
  // Mặt bằng đang dựng gần nhất trong trình dựng căn hộ (cùng trình duyệt)
  getCurrentPlan: () => { try { return JSON.parse(localStorage.getItem(PLAN_KEY) || 'null'); } catch { return null; } },
  openShowcase: (id) => { location.href = './xem-can-ho.html#' + id; },
  // Chuyển sang trình dựng căn hộ và mở căn ở chế độ 3D
  openUnit: (layout, info) => {
    try { localStorage.setItem('floorplan3d.openUnit', JSON.stringify({ layout, info })); } catch { toast('Không lưu được dữ liệu để chuyển trang.'); return; }
    location.href = './index.html';
  },
});
