// Các phong cách nội thất nổi tiếng: màu tường, vật liệu sàn theo loại phòng, bảng màu đồ đạc, chi tiết trang trí.
export const STYLES = {
  warm: {
    name: 'Ấm áp gỗ sồi', desc: 'Như ảnh phối cảnh mẫu: tường be ốp gỗ, sàn đá trắng phòng khách, gỗ xương cá phòng ngủ, sofa xám, ghế xanh, lam chắn lô-gia',
    wall: '#ecdfcc', cap: '#f1eee9', wallTex: 'panel',
    floors: { bedroom: 'herringboneLight', living: 'marble', kitchen: 'marble', wet: 'tile', outdoor: 'darkTile' },
    palette: { wood: '#c9a47c', woodDark: '#8a6a4e', fabric: '#c8c5c0', fabric2: '#2f4a7a', bedding: '#d9ccb9', accent: '#8a6a4e', cabinet: '#d8c2a2', stone: '#3a3836', metal: '#2b2b2b', curtain: '#f3eee6', drape: '#b9a891', rug1: '#d2c6b3', rug2: '#8f8170', leather: false, slats: true, led: true },
  },
  green: {
    name: 'Gỗ & xanh rêu', desc: 'Kiểu ảnh quảng cáo: gỗ sồi, sofa da bò, ghế và chăn xanh rêu, tường cắt màu than',
    wall: '#f1ebe1', cap: '#2b2c2e',
    floors: { bedroom: 'herringboneLight', living: 'marble', kitchen: 'marble', wet: 'tile', outdoor: 'darkTile' },
    palette: { wood: '#c49a6c', woodDark: '#7a5236', fabric: '#a8653a', fabric2: '#2f5a45', bedding: '#6b7a3a', accent: '#5f6f35', cabinet: '#e8dcc8', stone: '#2e2f31', metal: '#2b2b2b', curtain: '#f6f1e8', drape: '#9aa36b', rug1: '#d9cdb8', rug2: '#9c8a72', leather: true, slats: true, led: false },
  },
  walnut: {
    name: 'Gỗ óc chó sang trọng', desc: 'Sofa khung gỗ óc chó bọc da nâu, bàn trà gỗ burl chảy nhựa đen, ghế bành khung gỗ cong, kệ TV gỗ, sàn đá xám viền đen, rèm xám',
    wall: '#ece8e2', cap: '#2b2c2e',
    floors: { bedroom: 'walnut', living: 'marbleGray', kitchen: 'marbleGray', wet: 'darkTile', outdoor: 'darkTile' },
    palette: { wood: '#7b5236', woodDark: '#4b3020', fabric: '#4e3326', fabric2: '#4e3326', bedding: '#d9cfc2', accent: '#b9875e', cabinet: '#5a3c28', stone: '#2a2928', metal: '#2b2b2b', curtain: '#eceae6', drape: '#8e8a85', rug1: '#cfcfcc', rug2: '#2a2a2c', leather: true, slats: false, led: true, walnut: true },
  },
  luxury: {
    name: 'Hiện đại sang trọng', desc: 'Sàn gỗ xương cá, đá marble trắng, sofa da bò, đèn LED hắt viền',
    wall: '#efe9e1', cap: '#3a3b3e',
    floors: { bedroom: 'herringbone', living: 'marble', kitchen: 'marble', wet: 'darkTile', outdoor: 'darkTile' },
    palette: { wood: '#6b4a33', woodDark: '#3b2a20', fabric: '#8f4f2b', fabric2: '#9a5a32', bedding: '#5c5650', accent: '#3b3b3e', cabinet: '#3d4044', stone: '#ecebe7', metal: '#b08d57', curtain: '#efeae2', drape: '#4a4643', rug1: '#1f1f22', rug2: '#cfc6b8', leather: true, slats: true, led: true },
  },
  scandi: {
    name: 'Scandinavian (Bắc Âu)', desc: 'Trắng sáng, gỗ sồi nhạt, vải xám, tối giản ấm áp',
    wall: '#f7f6f2', cap: '#4a4d52',
    floors: { bedroom: 'oak', living: 'oak', kitchen: 'oak', wet: 'tile', outdoor: 'tile' },
    palette: { wood: '#d8b98f', woodDark: '#a88661', fabric: '#b9bcbf', fabric2: '#d9c9ae', bedding: '#e6e2da', accent: '#7fa3b8', cabinet: '#f2f1ed', stone: '#f4f4f2', metal: '#2b2b2b', curtain: '#ffffff', drape: '#d9d4cb', rug1: '#ece7dd', rug2: '#8a8f94', leather: false, slats: false, led: false },
  },
  indochine: {
    name: 'Indochine (Đông Dương)', desc: 'Gạch bông, gỗ tối màu, xanh rêu – vàng mù tạt',
    wall: '#f3ead8', cap: '#3e3a33',
    floors: { bedroom: 'walnut', living: 'encaustic', kitchen: 'encaustic', wet: 'encaustic', outdoor: 'terracotta' },
    palette: { wood: '#5a3a22', woodDark: '#3a2414', fabric: '#2f5d50', fabric2: '#c99a2e', bedding: '#f2ede2', accent: '#c99a2e', cabinet: '#2f5d50', stone: '#efeae0', metal: '#b08d57', curtain: '#fbf7ef', drape: '#2f5d50', rug1: '#2f5d50', rug2: '#e8dcc2', leather: false, slats: true, led: false },
  },
  japandi: {
    name: 'Japandi', desc: 'Nhật Bản + Bắc Âu: gỗ sáng, be, lam gỗ, mộc mạc',
    wall: '#ece4d8', cap: '#4a4238',
    floors: { bedroom: 'oak', living: 'oak', kitchen: 'oak', wet: 'polished', outdoor: 'polished' },
    palette: { wood: '#c39b6f', woodDark: '#6b5038', fabric: '#d8cbb5', fabric2: '#a8957a', bedding: '#cfc4b2', accent: '#7a6a55', cabinet: '#cdb08a', stone: '#d9d4cc', metal: '#3a3530', curtain: '#f4efe6', drape: '#b8a88f', rug1: '#d6cbb8', rug2: '#9c8b72', leather: false, slats: true, led: true },
  },
  neoclassic: {
    name: 'Tân cổ điển', desc: 'Trắng kem, nhung xanh navy, viền vàng đồng, marble',
    wall: '#f4efe8', cap: '#3b3d44',
    floors: { bedroom: 'herringboneLight', living: 'marble', kitchen: 'marble', wet: 'marble', outdoor: 'marble' },
    palette: { wood: '#efe9df', woodDark: '#c9b79c', fabric: '#2e3f5c', fabric2: '#d9b8a8', bedding: '#efe8de', accent: '#c9a24a', cabinet: '#f3efe7', stone: '#f4f2ee', metal: '#c9a24a', curtain: '#f6f1e8', drape: '#2e3f5c', rug1: '#2e3f5c', rug2: '#e8dfcf', leather: false, slats: false, led: true },
  },
  industrial: {
    name: 'Industrial', desc: 'Bê tông mài, kim loại đen, da nâu, gỗ thô',
    wall: '#b9b6b0', cap: '#26272a',
    floors: { bedroom: 'walnut', living: 'polished', kitchen: 'polished', wet: 'darkTile', outdoor: 'darkTile' },
    palette: { wood: '#6e4a2f', woodDark: '#3a2a1e', fabric: '#7a4a2a', fabric2: '#5b5f63', bedding: '#4b4f54', accent: '#c0602b', cabinet: '#2b2d30', stone: '#3a3c40', metal: '#1e1e1e', curtain: '#d7d3cc', drape: '#3c3f43', rug1: '#3c3f43', rug2: '#a35a32', leather: true, slats: false, led: false },
  },
  minimal: {
    name: 'Tối giản (Minimalism)', desc: 'Trắng – xám, bề mặt trơn, ít chi tiết',
    wall: '#fafafa', cap: '#55585e',
    floors: { bedroom: 'oak', living: 'polished', kitchen: 'polished', wet: 'tile', outdoor: 'polished' },
    palette: { wood: '#e8e4dc', woodDark: '#9a948a', fabric: '#d9d9d6', fabric2: '#bfbfbb', bedding: '#f3f3f1', accent: '#9aa0a6', cabinet: '#fafafa', stone: '#f0f0ee', metal: '#9a9a9a', curtain: '#ffffff', drape: '#e2e2df', rug1: '#e6e6e2', rug2: '#b9b9b5', leather: false, slats: false, led: true },
  },
};

export const PALETTE_FIELDS = [
  ['wall', 'Màu tường'], ['wood', 'Màu gỗ'], ['woodDark', 'Gỗ đậm / cửa'], ['fabric', 'Sofa / vải chính'], ['fabric2', 'Ghế bành'],
  ['bedding', 'Chăn ga'], ['accent', 'Điểm nhấn (gối…)'], ['cabinet', 'Tủ bếp'], ['stone', 'Mặt đá'], ['metal', 'Kim loại / tay nắm'],
  ['curtain', 'Rèm voan'], ['drape', 'Rèm dày'], ['rug1', 'Thảm – nền'], ['rug2', 'Thảm – hoa văn'],
];

/** Phân loại phòng theo tên để gán vật liệu sàn */
export function roomKind(name = '') {
  const n = name.toLowerCase();
  if (/tắm|wc|vệ sinh|toilet|bath/.test(n)) return 'wet';
  if (/lô ?gia|logia|ban công|sân|balcony/.test(n)) return 'outdoor';
  if (/bếp|kitchen/.test(n)) return 'kitchen';
  if (/ngủ|bed|master/.test(n)) return 'bedroom';
  return 'living';
}

/** Bảng màu thực tế = phong cách + tuỳ chỉnh */
export function resolvePalette(settings = {}) {
  const st = STYLES[settings.style] || STYLES.luxury;
  return { wall: st.wall, cap: st.cap, wallTex: st.wallTex || 'plaster', ...st.palette, ...(settings.palette || {}) };
}
