// VIDEO GIỚI THIỆU – phần đêm 30–38 s (sinh bởi scripts/gen_sp.py, đừng sửa tay)
window.CONFIG = {
  duration: 240, fadeIn: 0, logo: null,
  palette: { sea: '#04101F', land: '#0A1428', green: '#0C1A2A', sand: '#16233A', water: '#06162B', coast: '#2D6FA8', coastLine: '#7FB2FF', roadMinor: '#6B5A50', roadMid: '#C8925E', roadGlow: '#FF9F4A', roadMajor: '#FFD9A8', bldLow: '#152640', bldHigh: '#2B4568', navy800: '#0A1C3A', orange: '#FF7A1A', orange300: '#FFB547', lotB: '#FF9A3C', lotC: '#F06414', park: '#E8EEF8' },
  project: { center: [108.257716, 16.021112], polygon: [[108.257351, 16.021228], [108.257365, 16.021265], [108.257771, 16.021462], [108.2578, 16.02147], [108.257844, 16.02146], [108.257874, 16.021427], [108.258007, 16.021147], [108.258093, 16.020965], [108.257585, 16.020737], [108.257498, 16.020919]], parcels: [], buildingUrl: 'data/saphia.geojson' },
  camera: [
    { f: 0, c: [108.248, 16.023], z: 13.3, p: 45, b: -15 },
    { f: 110, c: [108.256, 15.99], z: 11.75, p: 38, b: -12 },
    { f: 240, c: [108.262, 15.978], z: 11.5, p: 36, b: -10 },
  ],
  events: [
    { type: 'project', in: 0, lotsIn: 0, out: null, rise: [0, 1] },
    { type: 'route', coords: [[108.203, 16.0552], [108.224, 16.045], [108.242, 16.033], [108.253, 16.0215], [108.258, 16.006], [108.27, 15.98], [108.29, 15.942], [108.308, 15.906], [108.3262, 15.877]], dash: true, color: '#5CF2E6', width: 6, glowW: 22, in: 6, dur: 100, out: null, plane: true, icon: 'train' },
    { type: 'poi', name: 'Ga dự kiến', icon: 'train', at: [108.2532, 16.0212], in: 30, out: 112, beam: 80, small: true, showDist: false, sub: '≈ 500 m', dx: -150 },
    { type: 'poi', name: 'Sun Saphia', icon: 'star', at: [108.257716, 16.021112], in: 20, out: null, beam: 150, small: true, showDist: false, sub: '', dx: 150 },
    { type: 'poi', name: 'Sân bay', icon: 'plane', at: [108.203, 16.0552], in: 120, out: null, beam: 90, small: true, showDist: false, sub: '~8 km · 15–20 phút', dx: -110 },
    { type: 'poi', name: 'Cầu Rồng', icon: 'bridge', at: [108.2272, 16.0612], in: 138, out: null, beam: 150, small: true, showDist: false, sub: '~6 km · 15 phút', dx: 60 },
    { type: 'poi', name: 'Ngũ Hành Sơn', icon: 'mountain', at: [108.26382, 16.00292], in: 156, out: null, beam: 70, small: true, showDist: false, sub: '~3 km · 5 phút', dx: 170 },
    { type: 'poi', name: 'Phố cổ Hội An', icon: 'star', at: [108.3262, 15.877], in: 174, out: null, beam: 90, small: true, showDist: false, sub: '~25 km · 30 phút', dx: -80 },
  ],
};
