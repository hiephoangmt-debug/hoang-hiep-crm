// Dữ liệu dựng sẵn các căn mẫu từ ảnh mặt bằng bán hàng (toạ độ = pixel trên ảnh gốc 1414×2000).
// - dims: kích thước tổng ghi trên bản vẽ (m) để lấy tỉ lệ
// - remove: điểm gần các vệt nhận nhầm là tường (mép bàn bếp, ghế, cánh cửa…)
// - cut: [x1,y1,x2,y2] khoét bỏ một đoạn tường (lối thông không có cửa)
// - walls: tường bổ sung [x1,y1,x2,y2]; doors/slides/windows: [x,y,rộng(m)] đặt lên tường gần nhất
// - labels: chữ trên bản vẽ → tên phòng; furniture: [loại, x, y, góc, {w,d}]
export const UNIT_SPECS = [
  {
    id: '1pn-plus', name: '1 Phòng ngủ +', type: '1PN+', image: 9, dims: [9.63, 6.545], style: 'warm',
    remove: [], cut: [[860, 822, 1088, 822]],
    walls: [[855, 700, 855, 826], [1090, 620, 1090, 826]],
    removeOpenings: [[975, 822]],
    doors: [[855, 762, 0.85, 'v'], [1090, 765, 0.75, 'v']], slides: [], windows: [],
    removeWalls: [[425, 1075]], extraSlides: [[[432, 832, 432, 1152], 2.4]],
    extraWindows: [[[262, 832, 262, 1150], 2.9, { sill: 0.05, height: 1.05 }]],
    labels: [['Phòng ngủ 1', 360, 610], ['Phòng đa năng', 980, 720], ['WC', 1140, 700], ['Phòng khách', 630, 905], ['Bếp + ăn', 1050, 970], ['Lô gia', 355, 945]],
    furniture: [
      ['bed', 560, 615, 0, { nightstands: true }], ['rug', 560, 650, 0, { w: 2.3, d: 1.8 }], ['wardrobe', 830, 600, 90, { w: 1.9 }],
      ['tvStand', 580, 800, 180, { w: 1.6 }], ['plant', 330, 750],
      ['bedSingle', 975, 560, 270, { w: 1.0, d: 2.0 }], ['desk', 900, 680, 270, { w: 1.0, d: 0.5 }], ['plant', 1050, 650],
      ['shower', 1160, 560, 0, { w: 1.0, d: 0.9 }], ['toilet', 1228, 680, 90], ['vanity', 1232, 765, 90, { w: 0.7 }],
      ['rug', 580, 1000, 0, { w: 2.4, d: 1.8 }], ['sofa', 600, 1118, 180, { w: 2.2 }], ['roundTable', 610, 995], ['armchair', 500, 935, 300],
      ['tvStand', 600, 845, 0, { w: 1.8 }],
      ['diningTable', 870, 1080, 90, { w: 1.5, d: 0.8 }], ['chair', 815, 1040, 270], ['chair', 815, 1120, 270], ['chair', 928, 1040, 90], ['chair', 928, 1120, 90],
      ['kitchen', 1150, 852, 0, { w: 1.8 }], ['kitchen', 1245, 960, 90, { w: 1.2 }], ['fridge', 1035, 852, 0],
      ['washer', 350, 1112, 180], ['plant', 330, 870],
    ],
  },
  {
    id: '1pn', name: '1 Phòng ngủ', type: '1PN', image: 10, dims: [4.65, 8.08], style: 'warm',
    remove: [], cut: [], removeWalls: [[430, 192]],
    walls: [[705, 715, 800, 715], [845, 735, 845, 905], [560, 395, 700, 395]],
    extraWindows: [[[335, 212, 562, 212], 2.0, { sill: 0.1, height: 1.1 }]],
    extraSlides: [[[335, 395, 470, 395], 1.3]],
    doors: [[752, 715, 0.85, 'h'], [845, 790, 0.75, 'v']], slides: [], windows: [], removeOpenings: [[741, 225]],
    labels: [['Lô gia', 490, 310], ['Phòng ngủ', 860, 610], ['Phòng khách', 580, 710], ['WC', 915, 865], ['Bếp + ăn', 530, 1010]],
    furniture: [
      ['washer', 600, 335, 0], ['plant', 385, 285],
      ['sofa', 612, 560, 90, { w: 2.2 }], ['rug', 515, 560, 0, { w: 1.8, d: 2.3 }], ['roundTable', 505, 555], ['armchair', 420, 480, 300], ['tvStand', 350, 590, 270, { w: 1.4 }],
      ['diningTable', 405, 812, 0, { w: 1.4, d: 0.8 }], ['chair', 370, 722, 0], ['chair', 440, 722, 0], ['chair', 370, 902, 180], ['chair', 440, 902, 180],
      ['kitchen', 352, 1000, 270, { w: 1.2 }], ['kitchen', 455, 1127, 180, { w: 2.1 }], ['fridge', 622, 1122, 180],
      ['bed', 905, 440, 90, { nightstands: true }], ['wardrobe', 925, 680, 180, { w: 1.9 }], ['tvStand', 722, 430, 270, { w: 1.6, d: 0.4 }], ['plant', 742, 292],
      ['vanity', 1005, 782, 90, { w: 0.6 }], ['toilet', 1003, 880, 90], ['shower', 915, 1000, 0, { w: 0.9, d: 0.9 }],
    ],
  },
  {
    id: '2pn-a', name: '2 Phòng ngủ (căn góc)', type: '2PN', image: 11, dims: [8.995, 9.895], style: 'warm',
    remove: [[350, 980], [380, 905]], cut: [], walls: [[598, 690, 598, 812], [305, 1290, 472, 1290]], removeWalls: [],
    extraWindows: [[[1072, 822, 1072, 1118], 2.7, { sill: 0.05, height: 1.05 }]],
    doors: [[598, 752, 0.85, 'v'], [712, 690, 0.7, 'h'], [495, 735, 0.7, 'v'], [390, 1290, 0.95, 'h']], slides: [[915, 965, 2.2, 'v']], windows: [], removeOpenings: [[915, 930]],
    labels: [['Phòng ngủ 1', 453, 603], ['WC 2', 670, 560], ['Phòng ngủ 2', 888, 705], ['WC 1', 425, 783], ['Phòng khách', 784, 882], ['Bếp + ăn', 490, 986], ['Lô gia', 998, 929]],
    furniture: [
      ['bedSingle', 397, 487, 270, { w: 1.6, nightstands: true }], ['wardrobe', 400, 660, 180, { w: 1.8 }], ['plant', 560, 440],
      ['shower', 672, 470, 0, { w: 0.9, d: 0.95 }], ['toilet', 628, 575, 270], ['vanity', 630, 650, 270, { w: 0.6 }],
      ['bed', 835, 545, 270, { nightstands: true }], ['rug', 910, 560, 0, { w: 2.2, d: 2.1 }], ['wardrobe', 952, 782, 180, { w: 2.0 }], ['desk', 1035, 640, 90, { w: 1.1, d: 0.45 }], ['plant', 828, 782],
      ['shower', 335, 760, 0, { w: 0.6, d: 0.9 }], ['vanity', 400, 722, 0, { w: 0.6 }], ['toilet', 465, 815, 90],
      ['kitchen', 332, 985, 270, { w: 2.4 }], ['fridge', 460, 895, 0],
      ['diningTable', 570, 1070, 90, { w: 1.5, d: 0.8 }], ['chair', 507, 1040, 270], ['chair', 507, 1100, 270], ['chair', 633, 1040, 90], ['chair', 633, 1100, 90],
      ['rug', 800, 985, 0, { w: 2.3, d: 1.6 }], ['sofa', 795, 1090, 180, { w: 2.2 }], ['roundTable', 805, 965], ['armchair', 707, 925, 300], ['tvStand', 800, 832, 0, { w: 1.6 }],
      ['washer', 995, 1085, 180], ['plant', 1020, 860],
    ],
  },
  {
    id: '2pn-b', name: '2 Phòng ngủ 2 WC', type: '2PN', image: 12, dims: [10.42, 8.09], style: 'warm',
    remove: [[410, 423], [660, 983], [787, 915], [600, 989], [1133, 840]], cut: [], removeWalls: [], outside: [[600, 1120]],
    walls: [[644, 600, 644, 702], [1030, 907, 1205, 907]], extraWindows: [[[176, 712, 176, 1000], 2.6, { sill: 0.05, height: 1.05 }]],
    doors: [[585, 700, 0.85, 'h'], [680, 700, 0.7, 'h'], [857, 707, 0.85, 'h'], [1036, 957, 0.75, 'v'], [935, 1002, 0.95, 'h']],
    slides: [[322, 875, 2.0, 'v']], windows: [], removeOpenings: [[322, 819]],
    rename: { 'Phòng khách, bếp + ăn & wc 01': 'Phòng khách & bếp + ăn' },
    labels: [['Phòng ngủ 1', 430, 672], ['WC 02', 708, 576], ['Phòng ngủ 2', 1047, 690], ['Phòng khách', 477, 770], ['Bếp + ăn', 968, 847], ['WC 01', 1085, 1043], ['Lô gia', 267, 833]],
    furniture: [
      ['bed', 435, 520, 0, { nightstands: true }], ['rug', 430, 545, 0, { w: 2.4, d: 1.9 }], ['wardrobe', 620, 510, 90, { w: 1.9 }], ['tvStand', 428, 688, 180, { w: 1.6, d: 0.4 }], ['plant', 222, 668],
      ['shower', 715, 462, 0, { w: 0.9, d: 0.9 }], ['toilet', 772, 560, 90], ['vanity', 786, 640, 90, { w: 0.6 }],
      ['bed', 1048, 515, 0, { nightstands: true }], ['rug', 1050, 555, 0, { w: 2.2, d: 1.9 }], ['wardrobe', 857, 510, 270, { w: 1.9 }],
      ['rug', 490, 890, 0, { w: 2.3, d: 1.6 }], ['sofa', 490, 978, 180, { w: 2.2 }], ['roundTable', 490, 860], ['armchair', 565, 815, 30], ['tvStand', 470, 735, 0, { w: 1.6 }],
      ['diningTable', 735, 960, 90, { w: 1.5, d: 0.8 }], ['chair', 690, 935, 270], ['chair', 690, 990, 270], ['chair', 785, 935, 90], ['chair', 785, 990, 90],
      ['kitchen', 1112, 755, 0, { w: 1.8 }], ['kitchen', 1172, 848, 90, { w: 1.1 }], ['fridge', 980, 760, 0],
      ['vanity', 1172, 965, 90, { w: 0.6 }], ['toilet', 1177, 1060, 90], ['shower', 1092, 1150, 0, { w: 0.9, d: 0.9 }],
      ['washer', 255, 975, 180], ['plant', 230, 752],
    ],
  },
  {
    id: '3pn', name: '3 Phòng ngủ', type: '3PN', image: 13, dims: [11.52, 9.9], style: 'warm',
    remove: [[600, 805]], cut: [], removeWalls: [],
    walls: [[816, 712, 905, 712], [450, 805, 490, 805], [1095, 818, 1095, 925]],
    extraWindows: [[[1212, 832, 1212, 1108], 2.5, { sill: 0.05, height: 1.05 }]],
    doors: [[470, 860, 0.85, 'v'], [850, 706, 0.8, 'h'], [905, 755, 0.85, 'v'], [338, 907, 0.7, 'h'], [452, 1110, 0.7, 'v'], [530, 1278, 0.95, 'h']],
    slides: [[1095, 965, 2.2, 'v']], windows: [], removeOpenings: [],
    rename: { 'Bếp, phòng khách & lô gia': 'Phòng khách & bếp' },
    labels: [['Phòng ngủ 3', 355, 695], ['Phòng ngủ 2', 780, 628], ['Phòng ngủ 1', 1043, 713], ['Bếp', 592, 660], ['Phòng khách', 902, 867], ['WC 01', 396, 958], ['WC 02', 394, 1112], ['Lô gia', 568, 512], ['Lô gia', 1155, 958]],
    furniture: [
      ['bed', 330, 555, 270, { nightstands: true }], ['wardrobe', 328, 755, 0, { w: 1.9 }],
      ['kitchen', 515, 678, 270, { w: 2.7 }], ['fridge', 672, 757, 90], ['wardrobe', 728, 757, 90, { w: 0.95, d: 0.4 }], ['washer', 550, 447, 0], ['plant', 620, 600],
      ['bed', 752, 525, 270, { w: 1.6, nightstands: true }], ['wardrobe', 730, 678, 180, { w: 1.4 }],
      ['bed', 1018, 572, 270, { nightstands: true }], ['wardrobe', 1088, 775, 180, { w: 1.65 }], ['desk', 1168, 650, 90, { w: 1.2, d: 0.45 }], ['plant', 1155, 565],
      ['rug', 928, 985, 0, { w: 2.8, d: 1.9 }], ['sofa', 960, 1075, 180, { w: 2.2 }], ['sofa', 800, 985, 270, { w: 1.4 }], ['coffeeTable', 920, 988, 0, { w: 1.0, d: 0.55 }],
      ['tvStand', 972, 823, 0, { w: 1.5 }], ['floorLamp', 805, 1082], ['plant', 1040, 862],
      ['diningTable', 670, 1043, 90, { w: 1.6, d: 0.9 }], ['chair', 615, 985, 270], ['chair', 615, 1043, 270], ['chair', 615, 1100, 270], ['chair', 728, 985, 90], ['chair', 728, 1043, 90], ['chair', 728, 1100, 90],
      ['shower', 268, 980, 0, { w: 0.9, d: 0.9 }], ['vanity', 352, 1020, 180, { w: 0.6 }], ['toilet', 422, 990, 90],
      ['toilet', 312, 1105, 270], ['vanity', 415, 1078, 0, { w: 0.6 }], ['shower', 282, 1195, 0, { w: 0.9, d: 0.9 }],
      ['plant', 1165, 1080], ['plant', 1160, 850],
    ],
  },
];

// Căn dựng tay theo ảnh render có kích thước (đơn vị mét; x ngang, y từ hành lang ra mặt tiền)
const W = (ax, ay, bx, by, t = 0.12) => ({ a: [ax, ay], b: [bx, by], t });
UNIT_SPECS.push(
  {
    // Bản vẽ STUDIO 5315×6820: lô gia góc trái trên, ngủ + khách liền nhau, bếp dọc tường trái, WC dưới phải
    id: 'studio', name: 'Studio', type: 'Studio', dims: [5.315, 6.82], style: 'warm', manual: true,
    walls: [
      W(0, 0, 5.315, 0, 0.2), W(5.315, 0, 5.315, 6.82, 0.2), W(5.315, 6.82, 0, 6.82, 0.2), W(0, 6.82, 0, 0, 0.2),
      W(1.96, 0, 1.96, 3.02, 0.15), W(0, 3.02, 1.96, 3.02), W(2.17, 5.05, 5.315, 5.05), W(2.17, 5.05, 2.17, 6.82),
    ],
    openings: [
      [0, 'window', 1.05, 1.6, { sill: 0.05, height: 1.05 }], [0, 'window', 3.29, 1.8, { sill: 0.5, height: 1.8 }],
      [5, 'door', 1.44, 0.8], [7, 'door', 5.56, 0.7], [2, 'door', 1.43, 0.95],
    ],
    rooms: [
      ['Lô gia', 'darkTile', [[0, 0], [1.96, 0], [1.96, 3.02], [0, 3.02]]],
      ['Phòng ngủ & khách', 'herringboneLight', [[1.96, 0], [5.315, 0], [5.315, 5.05], [1.96, 5.05]]],
      ['Bếp', 'herringboneLight', [[0, 3.02], [1.96, 3.02], [1.96, 5.05], [2.17, 5.05], [2.17, 6.82], [0, 6.82]]],
      ['WC', 'tile', [[2.17, 5.05], [5.315, 5.05], [5.315, 6.82], [2.17, 6.82]]],
    ],
    furniture: [
      ['washer', 0.58, 2.0, 270], ['plant', 1.49, 0.62],
      ['bed', 3.93, 1.78, 90, { w: 1.6, nightstands: true }], ['rug', 3.55, 1.78, 0, { w: 1.8, d: 2.2 }], ['plant', 2.36, 0.69],
      ['wardrobe', 4.8, 4.14, 90, { w: 1.7, d: 0.55 }],
      ['sofa', 3.53, 4.62, 180, { w: 1.9, d: 0.8 }], ['roundTable', 3.45, 3.66, 0, { w: 0.7, d: 0.7 }], ['armchair', 2.65, 3.45, 300, { w: 0.75, d: 0.75 }],
      ['kitchen', 0.5, 4.0, 270, { w: 1.9 }], ['fridge', 0.52, 5.4, 270], ['plant', 0.5, 6.35],
      ['vanity', 2.69, 6.4, 180, { w: 0.7 }], ['toilet', 3.45, 6.4, 180], ['shower', 4.4, 6.2, 0, { w: 0.85, d: 1.1 }],
    ],
  },
  {
    // Bản vẽ STUDIO 4275×10150 (vị trí 20 / 09): lô gia trên, ngủ – khách giữa, WC dưới trái, bếp dọc tường phải
    id: 'studio-b', name: 'Studio dài', type: 'Studio', dims: [4.275, 10.15], style: 'warm', manual: true,
    walls: [
      W(0, 0, 4.275, 0, 0.2), W(4.275, 0, 4.275, 10.15, 0.2), W(4.275, 10.15, 0, 10.15, 0.2), W(0, 10.15, 0, 0, 0.2),
      W(0, 1.84, 4.275, 1.84, 0.15), W(0, 7.11, 1.94, 7.11), W(1.94, 7.11, 1.94, 10.15),
    ],
    openings: [
      [0, 'window', 2.18, 3.5, { sill: 0.05, height: 1.05 }], [4, 'slide', 2.74, 1.5], [4, 'window', 1.0, 1.2, { sill: 0.9, height: 1.4 }],
      [6, 'door', 7.67, 0.7], [2, 'door', 2.5, 0.95],
    ],
    rooms: [
      ['Lô gia', 'darkTile', [[0, 0], [4.275, 0], [4.275, 1.84], [0, 1.84]]],
      ['Phòng ngủ & khách', 'herringboneLight', [[0, 1.84], [4.275, 1.84], [4.275, 7.11], [0, 7.11]]],
      ['Bếp + ăn', 'herringboneLight', [[1.94, 7.11], [4.275, 7.11], [4.275, 10.15], [1.94, 10.15]]],
      ['WC', 'tile', [[0, 7.11], [1.94, 7.11], [1.94, 10.15], [0, 10.15]]],
    ],
    furniture: [
      ['washer', 0.6, 1.0, 270], ['plant', 3.63, 0.84],
      ['bed', 1.43, 3.54, 270, { w: 1.6, nightstands: true }], ['rug', 1.75, 3.54, 0, { w: 1.8, d: 2.2 }], ['tvStand', 3.84, 3.5, 90, { w: 1.5, d: 0.4 }], ['plant', 3.78, 2.45],
      ['wardrobe', 1.38, 5.22, 180, { w: 2.1, d: 0.55 }],
      ['sofa', 0.6, 6.3, 270, { w: 1.5, d: 0.8 }], ['roundTable', 1.68, 6.24, 0, { w: 0.7, d: 0.7 }], ['armchair', 2.5, 5.93, 330, { w: 0.75, d: 0.75 }], ['plant', 3.75, 6.25],
      ['fridge', 3.7, 7.0, 90], ['kitchen', 3.75, 8.65, 90, { w: 2.4 }],
      ['vanity', 0.5, 7.67, 270, { w: 0.7 }], ['toilet', 0.48, 8.4, 270], ['shower', 1.3, 9.45, 0, { w: 0.9, d: 0.9 }],
    ],
  },
  {
    // Bản vẽ 1 PHÒNG NGỦ + 6300×10150 (vị trí 21–23 / 06–08): lô gia trên trái, phòng ngủ trên phải, phòng đa năng, WC dưới phải
    id: '1pn-plus-b', name: '1 PN+ (6,3 × 10,15)', type: '1PN+', dims: [6.3, 10.15], style: 'warm', manual: true,
    walls: [
      W(0, 0, 6.3, 0, 0.2), W(6.3, 0, 6.3, 10.15, 0.2), W(6.3, 10.15, 0, 10.15, 0.2), W(0, 10.15, 0, 0, 0.2),
      W(0, 1.97, 3.2, 1.97, 0.15), W(3.2, 0, 3.2, 5.3), W(3.2, 5.3, 6.3, 5.3), W(3.94, 7.26, 6.3, 7.26), W(3.94, 7.26, 3.94, 10.15),
    ],
    openings: [
      [0, 'window', 1.68, 2.7, { sill: 0.05, height: 1.05 }], [0, 'window', 4.46, 1.8, { sill: 0.5, height: 1.8 }],
      [4, 'door', 2.4, 0.9], [4, 'window', 0.9, 1.2, { sill: 0.9, height: 1.4 }],
      [6, 'door', 3.72, 0.8], [8, 'door', 8.33, 0.7], [2, 'door', 3.16, 0.95],
    ],
    rooms: [
      ['Lô gia', 'darkTile', [[0, 0], [3.2, 0], [3.2, 1.97], [0, 1.97]]],
      ['Phòng ngủ', 'herringboneLight', [[3.2, 0], [6.3, 0], [6.3, 5.3], [3.2, 5.3]]],
      ['Phòng đa năng', 'marble', [[3.94, 5.3], [6.3, 5.3], [6.3, 7.26], [3.94, 7.26]]],
      ['Phòng khách & bếp + ăn', 'marble', [[0, 1.97], [3.2, 1.97], [3.2, 5.3], [3.94, 5.3], [3.94, 10.15], [0, 10.15]]],
      ['WC', 'tile', [[3.94, 7.26], [6.3, 7.26], [6.3, 10.15], [3.94, 10.15]]],
    ],
    furniture: [
      ['washer', 0.62, 1.1, 270], ['plant', 2.76, 0.8],
      ['bed', 4.95, 2.15, 90, { w: 1.6, nightstands: true }], ['rug', 4.6, 2.15, 0, { w: 1.8, d: 2.3 }], ['desk', 5.95, 3.98, 90, { w: 1.2, d: 0.45 }],
      ['wardrobe', 5.13, 4.98, 180, { w: 1.8, d: 0.55 }], ['plant', 3.6, 0.75],
      ['bedSingle', 5.75, 6.25, 0, { w: 0.95, d: 1.9 }], ['desk', 4.5, 5.6, 0, { w: 0.9, d: 0.45 }], ['officeChair', 4.5, 6.1, 180], ['plant', 4.4, 7.0],
      ['sofa', 0.6, 3.37, 270, { w: 2.2, d: 0.85 }], ['rug', 1.6, 3.4, 0, { w: 1.9, d: 2.4 }], ['roundTable', 1.76, 3.41, 0, { w: 0.7, d: 0.7 }],
      ['armchair', 2.2, 2.6, 210, { w: 0.75, d: 0.75 }], ['tvStand', 3.0, 3.45, 90, { w: 1.6, d: 0.4 }],
      ['diningTable', 0.94, 5.93, 0, { w: 1.3, d: 0.8 }], ['chair', 0.62, 5.25, 0], ['chair', 1.26, 5.25, 0], ['chair', 0.62, 6.62, 180], ['chair', 1.26, 6.62, 180],
      ['fridge', 0.5, 7.25, 270], ['kitchen', 0.45, 8.6, 270, { w: 1.4 }], ['kitchen', 1.55, 9.75, 180, { w: 1.6 }],
      ['vanity', 4.41, 7.62, 0, { w: 0.7 }], ['shower', 5.6, 7.95, 0, { w: 0.9, d: 1.0 }], ['toilet', 5.95, 9.4, 90],
    ],
  },
  {
    // Bản vẽ 1 PHÒNG NGỦ + (2 PN 1 WC) 6300×11520 – các căn giữa 29–32, 16, 15, 12B, 12A
    id: '2pn-1wc', name: '1 PN+ (2 PN 1 WC)', type: '1PN+', dims: [6.3, 11.52], style: 'warm', manual: true,
    walls: [
      W(0, 0, 6.3, 0, 0.2), W(6.3, 0, 6.3, 11.52, 0.2), W(6.3, 11.52, 0, 11.52, 0.2), W(0, 11.52, 0, 0, 0.2),
      W(0, 1.5, 6.3, 1.5, 0.15), W(3.2, 1.5, 3.2, 8.6), W(0, 5.77, 3.2, 5.77), W(0, 8.6, 3.2, 8.6), W(2.35, 8.6, 2.35, 11.52), W(0, 10.1, 2.35, 10.1, 0.1),
    ],
    openings: [
      [0, 'window', 3.15, 5.6, { sill: 0.05, height: 1.05 }],
      [4, 'door', 2.65, 0.8], [4, 'window', 1.2, 1.4, { sill: 0.9, height: 1.4 }], [4, 'slide', 4.7, 2.2],
      [5, 'door', 5.2, 0.8], [5, 'slide', 7.4, 1.6], [8, 'door', 9.6, 0.7], [9, 'door', 1.75, 0.65], [2, 'door', 3.8, 0.95],
    ],
    rooms: [
      ['Lô gia', 'darkTile', [[0, 0], [6.3, 0], [6.3, 1.5], [0, 1.5]]],
      ['Phòng ngủ', 'herringboneLight', [[0, 1.5], [3.2, 1.5], [3.2, 5.77], [0, 5.77]]],
      ['Phòng đa năng', 'herringboneLight', [[0, 5.77], [3.2, 5.77], [3.2, 8.6], [0, 8.6]]],
      ['Phòng khách & bếp + ăn', 'marble', [[3.2, 1.5], [6.3, 1.5], [6.3, 11.52], [2.35, 11.52], [2.35, 8.6], [3.2, 8.6]]],
      ['WC', 'tile', [[0, 8.6], [2.35, 8.6], [2.35, 11.52], [0, 11.52]]],
    ],
    furniture: [
      ['washer', 0.62, 0.7, 270], ['plant', 5.6, 0.7],
      ['bed', 1.35, 3.35, 270, { w: 1.6, nightstands: true }], ['rug', 1.7, 3.35, 0, { w: 1.8, d: 2.3 }], ['wardrobe', 1.18, 5.4, 180, { w: 1.8, d: 0.55 }],
      ['bed', 1.86, 6.85, 0, { w: 1.6, nightstands: true }], ['tvStand', 1.74, 8.4, 180, { w: 1.6, d: 0.35 }], ['plant', 0.45, 8.2], ['plant', 2.9, 8.2],
      ['sofa', 3.7, 3.65, 270, { w: 2.2, d: 0.85 }], ['rug', 4.6, 3.67, 0, { w: 1.9, d: 2.6 }], ['roundTable', 4.7, 3.69, 0, { w: 0.7, d: 0.7 }],
      ['armchair', 5.2, 4.45, 135, { w: 0.75, d: 0.75 }], ['tvStand', 5.88, 3.67, 90, { w: 1.6, d: 0.4 }], ['plant', 5.75, 2.1], ['plant', 5.8, 4.85],
      ['diningTable', 5.4, 6.95, 0, { w: 1.3, d: 0.85 }], ['chair', 5.1, 6.25, 0], ['chair', 5.7, 6.25, 0], ['chair', 5.1, 7.65, 180], ['chair', 5.7, 7.65, 180],
      ['wardrobe', 2.75, 8.9, 0, { w: 0.8, d: 0.55 }],
      ['fridge', 5.73, 8.9, 90], ['kitchen', 5.75, 10.0, 90, { w: 1.4 }], ['kitchen', 5.1, 11.2, 180, { w: 1.6 }],
      ['shower', 0.75, 9.3, 0, { w: 0.9, d: 1.1 }], ['vanity', 1.75, 8.95, 0, { w: 0.8 }], ['toilet', 1.0, 10.75, 270], ['plant', 2.6, 11.1],
    ],
  },
);

// Căn sân vườn tầng 3 (trên mái khối đế): dùng mặt bằng căn gốc + sân vườn phía mặt tiền; ảnh 2D là phối cảnh chủ đầu tư
UNIT_SPECS.push(
  { id: 'sv-1pn-plus', name: 'Sân vườn · 1 PN+', type: '1PN+', garden: { base: '1pn-plus-b', area: 10.3 } },
  { id: 'sv-2pn-1wc', name: 'Sân vườn · 2 PN 1 WC', type: '1PN+', garden: { base: '2pn-1wc', area: 18.2 } },
  { id: 'sv-2pn-2wc', name: 'Sân vườn · 2 PN 2 WC', type: '2PN', garden: { base: '2pn-b', area: 9.3 } },
  { id: 'sv-studio', name: 'Sân vườn · Studio', type: 'Studio', garden: { base: 'studio', area: 8.0 } },
  { id: 'sv-studio-b', name: 'Sân vườn · Studio dài', type: 'Studio', garden: { base: 'studio-b', area: 9.8 } },
  { id: 'sv-1pn', name: 'Sân vườn · 1 PN', type: '1PN', garden: { base: '1pn', area: 5.0 } },
  { id: 'sv-1pn-plus-l', name: 'Sân vườn · 1 PN+ (9,6 m)', type: '1PN+', garden: { base: '1pn-plus', area: 15.9 } },
  { id: 'sv-2pn-a', name: 'Sân vườn · 2 PN góc', type: '2PN', garden: { base: '2pn-a', area: 20.0 } },
  { id: 'sv-3pn', name: 'Sân vườn · 3 PN', type: '3PN', garden: { base: '3pn', area: 47.6, wrap: 'top' } },
);
