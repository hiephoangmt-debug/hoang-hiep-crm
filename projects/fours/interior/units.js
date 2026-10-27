/* Dữ liệu căn hộ để dựng nội thất (mét, toạ độ theo mặt bằng tầng CĐT: x sang phải, y xuống dưới; phía trên tờ bản vẽ = hướng 'up').
   F2-03-03: đo trên bản vẽ mặt bằng tầng 3 Tòa F2 (ảnh 6250 px), tỷ lệ 1,667 cm/px suy từ thông thủy 59,6 m². */
window.FS_UNITS = window.FS_UNITS || {};
window.FS_UNITS['F2-03-03'] = {
  code:'F2-03-03', tower:'F2', floor:'3', type:'2PN', tim:65.5, tt:59.6, gardenTT:47.8, gardenTim:41.1, upBrg:37.7,
  wallH:3.0,
  // phòng (thông thủy)
  rooms:[
    {id:'br1', name:'Phòng ngủ master', poly:[[0,0],[2.93,0],[2.93,4.07],[1.8,4.07],[1.8,4.5],[0,4.5]], floor:'wood', label:[1.0,3.05]},
    {id:'wc1', name:'WC master', poly:[[0,4.62],[2.67,4.62],[2.67,6.13],[0,6.13]], floor:'tile', label:[1.75,5.0]},
    {id:'br2', name:'Phòng ngủ 2', poly:[[0,6.25],[1.8,6.25],[1.8,6.75],[2.95,6.75],[2.95,10],[0,10]], floor:'wood', label:[1.0,9.55]},
    {id:'liv', name:'Khách + ăn + bếp', poly:[[3.1,0],[6.08,0],[6.08,8.27],[4.94,8.27],[4.94,10],[3.1,10]], floor:'wood', sub:[{name:'Phòng khách',at:[4.6,3.55]},{name:'Bàn ăn',at:[4.6,6.55]},{name:'Bếp',at:[4.45,9.0]}]},
    {id:'hall', name:'', poly:[[2.93,3.15],[3.1,3.15],[3.1,7.7],[2.93,7.7]], floor:'wood', hide:true},
    {id:'wc2', name:'WC chung', poly:[[5.1,8.47],[7.77,8.47],[7.77,10],[5.1,10]], floor:'tile', label:[6.25,8.85]},
    {id:'log', name:'Lô gia', poly:[[5.02,-1.67],[6.18,-1.67],[6.18,-0.2],[5.02,-0.2]], floor:'tile', outdoor:true, label:[5.6,-2.1]}
  ],
  // vỏ tường ngoài
  env:[[-0.2,-0.2],[6.28,-0.2],[6.28,8.27],[7.97,8.27],[7.97,10.2],[-0.2,10.2]],
  // cửa đi: đoạn tường bị khoét (x0,y0,x1,y1) + cánh mở vào phòng nào
  doors:[
    {r:[2.9,3.25,3.12,4.07], w:'br1'}, {r:[2.64,4.75,3.12,5.55], w:'wc1'}, {r:[2.92,6.8,3.12,7.62], w:'br2'},
    {r:[5.2,8.25,5.95,8.5], w:'wc2'}, {r:[6.05,6.95,6.3,7.95], w:'liv', main:true}
  ],
  // cửa kính / cửa sổ trên tường ngoài: k='door' (kính sát sàn ra sân) hoặc 'win'
  windows:[
    {r:[0.85,-0.22,2.55,0.02], k:'door'}, {r:[3.2,-0.22,4.75,0.02], k:'door'}, {r:[5.1,-0.22,5.95,0.02], k:'door'},
    {r:[-0.22,7.0,0.02,8.6], k:'win'}
  ],
  // sân vườn chữ L ôm góc (theo màu xanh trên bản vẽ) – mép ngoài bo tròn
  garden:{poly:[[-2.82,10.2],[-2.82,0],[-2.6,-1.3],[-1.9,-2.2],[-0.8,-2.58],[5.0,-2.58],[5.0,-0.2],[-0.2,-0.2],[-0.2,10.2]], rail:[[-2.82,10.2],[-2.82,0],[-2.6,-1.3],[-1.9,-2.2],[-0.8,-2.58],[5.0,-2.58]]},
  // nội thất (gói Tiêu chuẩn, phong cách Hiện đại). b = phía tựa tường: 'T','B','L','R'
  items:[
    // Phòng ngủ master
    {t:'bed', x:0, y:0.9, w:2.05, d:1.85, b:'L', size:'1m8'},
    {t:'headboard', x:0, y:0.25, w:0.06, d:3.15},
    {t:'nightstand', x:0.02, y:0.4, w:0.45, d:0.45, b:'L'}, {t:'nightstand', x:0.02, y:2.8, w:0.45, d:0.45, b:'L'},
    {t:'wardrobe', x:0, y:3.92, w:1.8, d:0.58, b:'B', glass:true},
    {t:'tvconsole', x:2.6, y:1.15, w:0.33, d:1.4, b:'R'},
    {t:'dresser', x:2.48, y:0.12, w:0.45, d:0.85, b:'R'},
    // WC master
    {t:'shower', x:0, y:4.62, w:0.95, d:1.51},
    {t:'toilet', x:1.05, y:5.62, w:0.4, d:0.53, b:'B'},
    {t:'vanity', x:1.6, y:5.65, w:0.95, d:0.5, b:'B'},
    // Phòng ngủ 2
    {t:'wardrobe', x:0, y:6.25, w:1.8, d:0.58, b:'T', glass:true},
    {t:'bed', x:0, y:7.3, w:2.05, d:1.65, b:'L', size:'1m6'},
    {t:'nightstand', x:0.02, y:9.0, w:0.45, d:0.45, b:'L'},
    {t:'desk', x:2.0, y:9.45, w:0.95, d:0.55, b:'B'},
    // Khách
    {t:'tvwall', x:3.1, y:0.6, w:0.12, d:2.9},
    {t:'tvconsole', x:3.22, y:1.1, w:0.4, d:1.9, b:'L', tv:true},
    {t:'sofa', x:5.15, y:0.85, w:0.9, d:2.2, b:'R'},
    {t:'coffeetable', x:4.15, y:1.45, w:0.6, d:1.0},
    {t:'rug', x:3.85, y:0.95, w:1.6, d:2.1},
    {t:'plant', x:5.6, y:0.2, w:0.45, d:0.45},
    // Bàn ăn
    {t:'dining', x:4.3, y:4.85, w:1.2, d:0.8, chairs:4},
    {t:'pendant', x:4.9, y:5.25},
    // Bếp chữ L
    {t:'fridge', x:3.1, y:7.35, w:0.75, d:0.72, b:'L'},
    {t:'kitchen', x:3.1, y:8.1, w:0.6, d:1.9, b:'L', sink:0.75},
    {t:'kitchen', x:3.7, y:9.4, w:1.24, d:0.6, b:'B', hob:0.55},
    // WC chung
    {t:'vanity', x:5.2, y:9.5, w:0.85, d:0.5, b:'B'},
    {t:'toilet', x:6.2, y:9.47, w:0.4, d:0.53, b:'B'},
    {t:'shower', x:6.82, y:8.47, w:0.95, d:1.53},
    // Lô gia
    {t:'washer', x:5.08, y:-1.62, w:0.6, d:0.6, b:'T'},
    {t:'dryrack', x:5.08, y:-0.95, w:1.05, d:0.6},
    // Sân vườn
    {t:'stones', pts:[[1.7,-1.4],[0.5,-1.4],[-0.8,-1.5],[-1.5,-0.4],[-1.5,1.0],[-1.5,2.4]]},
    {t:'palm', x:-1.9, y:-1.6}, {t:'palm', x:3.9, y:-1.6}, {t:'palm', x:-1.9, y:5.6}, {t:'palm', x:-1.9, y:9.2},
    {t:'outdoor', x:-2.3, y:3.4, w:1.6, d:1.7},
    {t:'shrubs', x:-2.6, y:6.4, w:0.6, d:2.3}
  ]
};
