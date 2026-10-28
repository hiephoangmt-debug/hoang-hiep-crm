/* Dựng nội thất căn hộ Sun FourS Tower từ dữ liệu FS_UNITS (mặt bằng 2D có tên phòng, diện tích, kích thước + 3D xoay được + phối cảnh).
   Phong cách Hiện đại – gói Tiêu chuẩn. Toạ độ: mét, x sang phải, y xuống dưới theo mặt bằng CĐT; 3D: x = x, z = y. */
(function(){
'use strict';
var Q = new URLSearchParams(location.search);
var U = window.FS_UNITS[Q.get('u') || 'F2-03-03'];
var VIEW = Q.get('view') || '3d';
var WH = U.wallH || 3.0;

/* ---------- tiện ích hình học ---------- */
function inPoly(x, y, P){ var c = false; for (var i = 0, j = P.length - 1; i < P.length; j = i++){ if (((P[i][1] > y) !== (P[j][1] > y)) && (x < (P[j][0] - P[i][0]) * (y - P[i][1]) / (P[j][1] - P[i][1]) + P[i][0])) c = !c; } return c; }
function inRect(x, y, r){ return x >= r[0] && x <= r[2] && y >= r[1] && y <= r[3]; }
function area(P){ var a = 0; for (var i = 0, j = P.length - 1; i < P.length; j = i++) a += (P[j][0] + P[i][0]) * (P[j][1] - P[i][1]); return Math.abs(a / 2); }
function bbox(P){ var b = [1e9, 1e9, -1e9, -1e9]; P.forEach(function(p){ b[0] = Math.min(b[0], p[0]); b[1] = Math.min(b[1], p[1]); b[2] = Math.max(b[2], p[0]); b[3] = Math.max(b[3], p[1]); }); return b; }
function vn(n, d){ return n.toFixed(d == null ? 2 : d).replace('.', ','); }

/* ---------- tường: lưới 2,5 cm → khối chữ nhật (vỏ ngoài trừ phòng, trừ cửa đi; cửa sổ/cửa kính xử lý riêng) ---------- */
if (!U.gardens) U.gardens = U.garden ? [{ poly: U.garden.poly, rails: [U.garden.rail] }] : [];
if (!U.env){ var RB = bbox([].concat.apply([], U.rooms.map(function(r){ return r.poly; })).concat([].concat.apply([], U.wallRects.map(function(w){ return [[w[0], w[1]], [w[2], w[3]]]; })))); U.env = [[RB[0], RB[1]], [RB[2], RB[1]], [RB[2], RB[3]], [RB[0], RB[3]]]; U.doors = U.doors || []; U.windows = U.windows || []; }
var G = 0.025, EB = bbox(U.env), NX = Math.round((EB[2] - EB[0]) / G), NY = Math.round((EB[3] - EB[1]) / G);
function cellKind(i, j){
  var x = EB[0] + (i + .5) * G, y = EB[1] + (j + .5) * G;
  if (!inPoly(x, y, U.env)) return 0;
  for (var k = 0; k < U.rooms.length; k++) if (!U.rooms[k].outdoor && inPoly(x, y, U.rooms[k].poly)) return 0;
  for (k = 0; k < U.doors.length; k++) if (inRect(x, y, U.doors[k].r)) return 3;
  for (k = 0; k < U.windows.length; k++) if (inRect(x, y, U.windows[k].r)) return U.windows[k].k === 'door' ? 4 : 5;
  return 1;
}
var grid = [], i, j;
if (!U.wallRects){ for (j = 0; j < NY; j++){ grid.push([]); for (i = 0; i < NX; i++) grid[j].push(cellKind(i, j)); } }
// gộp ô cùng loại thành hình chữ nhật (quét hàng rồi nối dọc)
function rects(kind){
  var used = grid.map(function(r){ return r.map(function(){ return false; }); }), out = [];
  for (var y = 0; y < NY; y++) for (var x = 0; x < NX; x++){
    if (used[y][x] || grid[y][x] !== kind) continue;
    var x2 = x; while (x2 + 1 < NX && !used[y][x2 + 1] && grid[y][x2 + 1] === kind) x2++;
    var y2 = y, ok = true;
    while (ok && y2 + 1 < NY){ for (var k = x; k <= x2; k++) if (used[y2 + 1][k] || grid[y2 + 1][k] !== kind){ ok = false; break; } if (ok) y2++; }
    for (var yy = y; yy <= y2; yy++) for (var xx = x; xx <= x2; xx++) used[yy][xx] = true;
    out.push([EB[0] + x * G, EB[1] + y * G, EB[0] + (x2 + 1) * G, EB[1] + (y2 + 1) * G]);
  }
  return out;
}
var WALLS, DOORS, GLASSD, WINS;
if (U.wallRects){ WALLS = U.wallRects; DOORS = []; WINS = [];
  // kính: cạnh phòng giáp ngoài nhà, phần không có tường
  GLASSD = []; U.rooms.forEach(function(r){ (r.ext || []).forEach(function(sd){ var b = r.bb, hz = sd === 'T' || sd === 'B', a0 = hz ? b[0] : b[1], a1 = hz ? b[2] : b[3], c = sd === 'T' ? b[1] - .1 : sd === 'B' ? b[3] + .1 : sd === 'L' ? b[0] - .1 : b[2] + .1, run = null;
    for (var a = a0 + .05; a <= a1 - .05 + 1e-6; a += .05){ var x = hz ? a : c, y = hz ? c : a, inW = WALLS.some(function(w){ return x >= w[0] - .02 && x <= w[2] + .02 && y >= w[1] - .02 && y <= w[3] + .02; });
      if (!inW){ if (!run) run = [a, a]; else run[1] = a; } else if (run){ if (run[1] - run[0] > .5) GLASSD.push(hz ? [run[0], c - .06, run[1], c + .06] : [c - .06, run[0], c + .06, run[1]]); run = null; } }
    if (run && run[1] - run[0] > .5) GLASSD.push(hz ? [run[0], c - .06, run[1], c + .06] : [c - .06, run[0], c + .06, run[1]]); }); }); }
else { WALLS = rects(1); DOORS = rects(3); GLASSD = rects(4); WINS = rects(5); }

/* ================= MẶT BẰNG 2D (SVG) ================= */
var COLORS = { wood: '#ecdcc2', tile: '#e4e9ec', grass: '#cfe6a8', wall: '#1d2733', furn: '#ffffff', line: '#46505c', soft: '#d9dee4', accent: '#FF6A2B', navy: '#0A2540' };
function plan2d(){
  var NS = 'http://www.w3.org/2000/svg', svg = document.createElementNS(NS, 'svg');
  var all = U.env.concat([].concat.apply([], U.gardens.map(function(g){ return g.poly; }))), b = bbox(all), m = 1.6;
  var vb = [b[0] - m - 0.6, b[1] - m - 2.2, b[2] - b[0] + 2 * m + 0.6, b[3] - b[1] + 2 * m + 3.4];
  svg.setAttribute('viewBox', vb.join(' ')); svg.setAttribute('xmlns', NS);
  svg.style.width = '100%'; svg.style.height = '100%'; svg.style.fontFamily = "'Be Vietnam Pro',Arial,sans-serif";
  function el(n, a, p){ var e = document.createElementNS(NS, n); for (var k in a) e.setAttribute(k, a[k]); (p || svg).appendChild(e); return e; }
  function path(P){ return 'M' + P.map(function(p){ return p[0].toFixed(3) + ' ' + p[1].toFixed(3); }).join('L') + 'Z'; }
  function txt(x, y, s, size, o){ o = o || {}; var t = el('text', Object.assign({ x: x, y: y, 'font-size': size, 'text-anchor': 'middle', fill: COLORS.navy }, o.attr || {})); t.textContent = s; return t; }
  el('rect', { x: vb[0], y: vb[1], width: vb[2], height: vb[3], fill: '#ffffff' });
  var defs = el('defs', {});
  var pt = el('pattern', { id: 'wood', width: .9, height: .16, patternUnits: 'userSpaceOnUse' }, defs);
  el('rect', { width: .9, height: .16, fill: COLORS.wood }, pt); el('path', { d: 'M0 .16H.9M.45 0V.16', stroke: '#d8c4a4', 'stroke-width': .012 }, pt);
  var tl = el('pattern', { id: 'tile', width: .3, height: .3, patternUnits: 'userSpaceOnUse' }, defs);
  el('rect', { width: .3, height: .3, fill: COLORS.tile }, tl); el('path', { d: 'M0 0H.3M0 0V.3', stroke: '#c9d1d7', 'stroke-width': .012 }, tl);
  var gp = el('pattern', { id: 'grass', width: .4, height: .4, patternUnits: 'userSpaceOnUse' }, defs);
  el('rect', { width: .4, height: .4, fill: COLORS.grass }, gp); el('path', { d: 'M.1 .3l.03-.08M.28 .12l.03-.07', stroke: '#9fc276', 'stroke-width': .015 }, gp);
  // sân vườn
  U.gardens.forEach(function(G){ el('path', { d: path(G.poly), fill: 'url(#grass)', stroke: '#8fb465', 'stroke-width': .03 });
    G.rails.forEach(function(R2){ el('path', { d: 'M' + R2.map(function(p){ return p.join(' '); }).join('L'), fill: 'none', stroke: '#5fa3c9', 'stroke-width': .07 }); }); });
  // phòng
  U.rooms.forEach(function(r){ el('path', { d: path(r.poly), fill: r.floor === 'tile' ? 'url(#tile)' : 'url(#wood)' }); });
  // tường, cửa sổ, cửa kính
  WALLS.forEach(function(w){ el('rect', { x: w[0], y: w[1], width: w[2] - w[0], height: w[3] - w[1], fill: COLORS.wall }); });
  WINS.concat(GLASSD).forEach(function(w){ var hz = (w[2] - w[0]) > (w[3] - w[1]);
    el('rect', { x: w[0], y: w[1], width: w[2] - w[0], height: w[3] - w[1], fill: '#ffffff', stroke: COLORS.wall, 'stroke-width': .02 });
    if (hz) el('line', { x1: w[0], x2: w[2], y1: (w[1] + w[3]) / 2, y2: (w[1] + w[3]) / 2, stroke: '#5fa3c9', 'stroke-width': .035 });
    else el('line', { y1: w[1], y2: w[3], x1: (w[0] + w[2]) / 2, x2: (w[0] + w[2]) / 2, stroke: '#5fa3c9', 'stroke-width': .035 }); });
  // cửa đi: cánh + cung mở
  U.doors.forEach(function(d){ var r = d.r, hz = (r[2] - r[0]) > (r[3] - r[1]), room = U.rooms.filter(function(x){ return x.id === d.w; })[0], c = room ? bbox(room.poly) : null;
    var L = hz ? r[2] - r[0] : r[3] - r[1], hx, hy, ex, ey, ax, ay;
    if (hz){ var inY = c && (c[1] + c[3]) / 2 > (r[1] + r[3]) / 2 ? r[3] : r[1], s = inY === r[3] ? 1 : -1; hx = r[0]; hy = inY; ex = r[0]; ey = inY + s * L; ax = r[2]; ay = inY; }
    else { var inX = c && (c[0] + c[2]) / 2 > (r[0] + r[2]) / 2 ? r[2] : r[0], s2 = inX === r[2] ? 1 : -1; hx = inX; hy = r[1]; ex = inX + s2 * L; ey = r[1]; ax = inX; ay = r[3]; }
    el('line', { x1: hx, y1: hy, x2: ex, y2: ey, stroke: COLORS.line, 'stroke-width': .035 });
    el('path', { d: 'M' + ex + ' ' + ey + 'A' + L + ' ' + L + ' 0 0 ' + (hz ? (ey > hy ? 0 : 1) : (ex > hx ? 1 : 0)) + ' ' + ax + ' ' + ay, fill: 'none', stroke: COLORS.line, 'stroke-width': .015, 'stroke-dasharray': '.06 .04' }); });
  // nội thất (ký hiệu nhìn từ trên)
  var S = { stroke: COLORS.line, 'stroke-width': .02 };
  function R(x, y, w, h, f, extra){ return el('rect', Object.assign({ x: x, y: y, width: w, height: h, fill: f || COLORS.furn, rx: .04 }, S, extra || {})); }
  U.items.forEach(function(it){
    var x = it.x, y = it.y, w = it.w, d = it.d, b = it.b;
    switch (it.t){
      case 'bed': { R(x, y, w, d, '#f6f3ee'); var hd = b === 'L' ? [x, y, .1, d] : b === 'R' ? [x + w - .1, y, .1, d] : b === 'T' ? [x, y, w, .1] : [x, y + d - .1, w, .1]; R(hd[0], hd[1], hd[2], hd[3], '#8a8f96');
        var n = it.size === '1m8' || d > 1.7 || w > 1.7 ? 2 : 2; for (var k = 0; k < n; k++){ if (b === 'L' || b === 'R'){ var px = b === 'L' ? x + .15 : x + w - .55, py = y + .1 + k * (d - .2) / n; R(px, py + .03, .4, (d - .2) / n - .06, '#ffffff'); } else { var qx = x + .1 + k * (w - .2) / n, qy = b === 'T' ? y + .15 : y + d - .55; R(qx + .03, qy, (w - .2) / n - .06, .4, '#ffffff'); } }
        var cov = b === 'L' ? [x + .65, y + .03, w - .7, d - .06] : b === 'R' ? [x + .05, y + .03, w - .7, d - .06] : b === 'T' ? [x + .03, y + .65, w - .06, d - .7] : [x + .03, y + .05, w - .06, d - .7]; R(cov[0], cov[1], cov[2], cov[3], '#cfd6dd');
        txt(x + w / 2, y + d / 2 + .12, 'Giường ' + (it.size || ''), .2, { attr: { fill: '#4b5662' } }); break; }
      case 'headboard': R(x, y, w, d, '#8a8f96'); break;
      case 'nightstand': R(x, y, w, d, '#b48a62'); el('circle', { cx: x + w / 2, cy: y + d / 2, r: .1, fill: '#fff2c6', stroke: COLORS.line, 'stroke-width': .015 }); break;
      case 'wardrobe': R(x, y, w, d, '#4a4f55'); for (var k2 = 1; k2 < Math.round(w / .5); k2++){ var lx = x + k2 * w / Math.round(w / .5); el('line', { x1: lx, x2: lx, y1: y, y2: y + d, stroke: '#9aa3ab', 'stroke-width': .015 }); } var vt = d > w, L0 = vt ? d : w, fs0 = Math.min(.17, L0 / 15); txt(x + w / 2, y + d / 2 + .06, L0 > 1.6 ? 'Tủ áo kịch trần · kính khói' : 'Tủ áo', L0 > 1.6 ? fs0 : .15, { attr: { fill: '#ffffff', transform: vt ? 'rotate(90 ' + (x + w / 2) + ' ' + (y + d / 2) + ')' : '' } }); break;
      case 'tvconsole': R(x, y, w, d, '#b48a62'); if (it.tv) txt(x + w / 2 + .02, y + d / 2, 'TV', .18, { attr: { fill: '#4b5662', transform: 'rotate(90 ' + (x + w / 2 + .02) + ' ' + (y + d / 2) + ')' } }); break;
      case 'tvwall': R(x, y, w, d, '#9b7653'); break;
      case 'dresser': R(x, y, w, d, '#b48a62'); el('circle', { cx: x - .22, cy: y + d / 2, r: .16, fill: '#ffffff', stroke: COLORS.line, 'stroke-width': .015 }); break;
      case 'rug': R(x, y, w, d, '#e7e2da', { 'stroke-dasharray': '.05 .04' }); break;
      case 'shower': R(x, y, w, d, '#dfe7ec'); el('line', { x1: x + w, x2: x + w, y1: y, y2: y + d, stroke: '#5fa3c9', 'stroke-width': .04 }); el('path', { d: 'M' + x + ' ' + y + 'L' + (x + w) + ' ' + (y + d) + 'M' + (x + w) + ' ' + y + 'L' + x + ' ' + (y + d), stroke: '#a9b6bf', 'stroke-width': .012 }); break;
      case 'toilet': el('ellipse', { cx: x + w / 2, cy: y + d * .45, rx: w / 2, ry: d * .45, fill: '#ffffff', stroke: COLORS.line, 'stroke-width': .02 }); R(x + .03, y + d - .14, w - .06, .14, '#ffffff'); break;
      case 'vanity': R(x, y, w, d, '#b48a62'); el('ellipse', { cx: x + w / 2, cy: y + d / 2, rx: w * .3, ry: d * .3, fill: '#ffffff', stroke: COLORS.line, 'stroke-width': .015 }); break;
      case 'desk': R(x, y, w, d, '#b48a62'); el('circle', { cx: x + w / 2, cy: y - .25, r: .2, fill: '#ffffff', stroke: COLORS.line, 'stroke-width': .015 }); break;
      case 'sofa': R(x, y, w, d, '#9aa3ad'); it.nolabel = true; var back = b === 'R' ? [x + w - .22, y, .22, d] : b === 'L' ? [x, y, .22, d] : b === 'T' ? [x, y, w, .22] : [x, y + d - .22, w, .22]; R(back[0], back[1], back[2], back[3], '#7d8792');
        for (var k3 = 0; k3 < 3; k3++){ if (b === 'R' || b === 'L') R(b === 'R' ? x + .05 : x + .25, y + .1 + k3 * (d - .2) / 3, w - .3, (d - .2) / 3 - .04, '#b9c1c9'); } break;
      case 'coffeetable': el('ellipse', { cx: x + w / 2, cy: y + d / 2, rx: w / 2, ry: d / 2, fill: '#b48a62', stroke: COLORS.line, 'stroke-width': .02 }); break;
      case 'plant': el('circle', { cx: x + w / 2, cy: y + d / 2, r: w / 2, fill: '#7fae58', stroke: '#4d7a33', 'stroke-width': .02 }); break;
      case 'dining': { R(x, y, w, d, '#b48a62'); var cw = .42; [[x + .12, y - .45], [x + w - .12 - cw, y - .45], [x + .12, y + d + .03], [x + w - .12 - cw, y + d + .03]].forEach(function(c){ R(c[0], c[1], cw, .42, '#e7e2da'); }); txt(x + w / 2, y + d / 2 + .07, 'Bàn ăn 4 ghế', .17, { attr: { fill: '#ffffff' } }); break; }
      case 'pendant': el('circle', { cx: x, cy: y, r: .18, fill: 'none', stroke: COLORS.accent, 'stroke-width': .02, 'stroke-dasharray': '.04 .03' }); break;
      case 'fridge': R(x, y, w, d, '#cfd4d9'); el('line', { x1: x + .05, x2: x + w - .05, y1: y + d / 2, y2: y + d / 2, stroke: COLORS.line, 'stroke-width': .015 }); txt(x + w / 2, y + d / 2 - .08, 'Tủ lạnh', .15, { attr: { fill: '#2f3a46' } }); txt(x + w / 2, y + d / 2 + .2, '2 cánh', .15, { attr: { fill: '#2f3a46' } }); break;
      case 'kitchen': { R(x, y, w, d, '#f3f1ed'); if (it.sink){ var sx = b === 'L' || b === 'R' ? [x + .1, y + it.sink - .25, w - .2, .5] : [x + it.sink - .25, y + .1, .5, d - .2]; R(sx[0], sx[1], sx[2], sx[3], '#d5dde3'); txt(sx[0] + sx[2] / 2, sx[1] + sx[3] / 2 + .05, 'Chậu rửa', .13, {}); }
        if (it.hob){ var hx2 = b === 'L' || b === 'R' ? [x + .05, y + it.hob - .3, w - .1, .6] : [x + it.hob - .3, y + .05, .6, d - .1]; R(hx2[0], hx2[1], hx2[2], hx2[3], '#2c3036'); [[.25, .25], [.75, .25], [.25, .75], [.75, .75]].forEach(function(c){ el('circle', { cx: hx2[0] + hx2[2] * c[0], cy: hx2[1] + hx2[3] * c[1], r: .08, fill: 'none', stroke: '#9aa3ab', 'stroke-width': .015 }); }); }
        break; }
      case 'washer': R(x, y, w, d, '#ffffff'); el('circle', { cx: x + w / 2, cy: y + d / 2, r: .2, fill: '#dbe3ea', stroke: COLORS.line, 'stroke-width': .015 }); break;
      case 'dryrack': for (var k4 = 0; k4 < 5; k4++){ var ly = y + .05 + k4 * (d - .1) / 4; el('line', { x1: x, x2: x + w, y1: ly, y2: ly, stroke: '#8b96a0', 'stroke-width': .015 }); } break;
      case 'stones': it.pts.forEach(function(p){ el('ellipse', { cx: p[0], cy: p[1], rx: .28, ry: .2, fill: '#d6d1c7', stroke: '#a8a196', 'stroke-width': .015 }); }); break;
      case 'palm': el('circle', { cx: x, cy: y, r: .55, fill: '#8cc063', 'fill-opacity': .8, stroke: '#5c8c3c', 'stroke-width': .02 }); for (var a = 0; a < 7; a++){ var an = a * Math.PI * 2 / 7; el('line', { x1: x, y1: y, x2: x + Math.cos(an) * .55, y2: y + Math.sin(an) * .55, stroke: '#5c8c3c', 'stroke-width': .02 }); } break;
      case 'outdoor': el('circle', { cx: x + w / 2, cy: y + d / 2, r: .35, fill: '#e9e4da', stroke: COLORS.line, 'stroke-width': .02 }); R(x + w / 2 - .25, y - .02, .5, .45, '#cbbca3'); R(x + w / 2 - .25, y + d - .43, .5, .45, '#cbbca3'); break;
      case 'shrubs': for (var k5 = 0; k5 < 5; k5++) el('circle', { cx: x + w / 2, cy: y + .25 + k5 * (d - .5) / 4, r: .26, fill: '#79a957', stroke: '#4d7a33', 'stroke-width': .015 }); break;
    }
  });
  // nhãn phòng: tên + diện tích + kích thước
  function labelPt(r){ var b = bbox(r.poly), best = null, bd = -1e9; for (var i2 = 1; i2 < 10; i2++) for (var j2 = 1; j2 < 10; j2++){ var x = b[0] + (b[2] - b[0]) * i2 / 10, y = b[1] + (b[3] - b[1]) * j2 / 10; if (!inPoly(x, y, r.poly)) continue;
      var hit = U.items.some(function(it){ return it.w && x > it.x - .35 && x < it.x + it.w + .35 && y > it.y - .25 && y < it.y + it.d + .25; }); var sc = (hit ? 0 : 10) - Math.hypot(x - (b[0] + b[2]) / 2, y - (b[1] + b[3]) / 2) * .3; if (sc > bd){ bd = sc; best = [x, y]; } } return best || [(b[0] + b[2]) / 2, (b[1] + b[3]) / 2]; }
  function tag(tx, ty, l1, l2, l3, big){ el('rect', { x: tx - (big ? .98 : .66), y: ty - .27, width: big ? 1.96 : 1.32, height: l3 ? .68 : .52, rx: .1, fill: 'rgba(255,255,255,.9)', stroke: 'rgba(10,37,64,.15)', 'stroke-width': .01 });
    txt(tx, ty, l1, big ? .19 : .14, { attr: { 'font-weight': 800 } }); if (l2) txt(tx, ty + .2, l2, big ? .17 : .13, { attr: { fill: COLORS.accent, 'font-weight': 800 } }); if (l3) txt(tx, ty + .36, l3, big ? .14 : .11, { attr: { fill: '#4b5662' } }); }
  U.rooms.forEach(function(r){ if (r.hide) return; var bb = bbox(r.poly), a = area(r.poly), big = Math.min(bb[2] - bb[0], bb[3] - bb[1]) > 2;
    if (r.sub){ r.sub.forEach(function(sb, k){ tag(sb.at[0], sb.at[1], sb.name.toUpperCase(), k === 0 ? 'Khách + ăn + bếp ' + vn(a, 1) + ' m²' : '', k === 0 ? 'ngang ' + vn(bb[2] - bb[0]) + ' m · dài ' + vn(bb[3] - bb[1]) + ' m' : '', k === 0); }); return; }
    var L = r.label || labelPt(r);
    tag(L[0], L[1], r.name.toUpperCase(), vn(a, 1) + ' m²', vn(bb[2] - bb[0]) + ' × ' + vn(bb[3] - bb[1]) + ' m', big); });
  // sân vườn nhãn
  if (U.auto && U.gardens.length){ var GA = U.gardens.slice().sort(function(a, c){ return area(c.poly) - area(a.poly); })[0], gb = bbox(GA.poly), gv = (gb[3] - gb[1]) > (gb[2] - gb[0]) * 1.4, gx = (gb[0] + gb[2]) / 2, gy = (gb[1] + gb[3]) / 2, gbest = -1;
    for (var gi = 1; gi < 20; gi++) for (var gj = 1; gj < 20; gj++){ var qx = gb[0] + (gb[2] - gb[0]) * gi / 20, qy = gb[1] + (gb[3] - gb[1]) * gj / 20; if (!inPoly(qx, qy, GA.poly)) continue; var dd = 9; for (var e = 0; e < GA.poly.length; e++){ var A1 = GA.poly[e], A2 = GA.poly[(e + 1) % GA.poly.length], ex = A2[0] - A1[0], ey = A2[1] - A1[1], tt = Math.max(0, Math.min(1, ((qx - A1[0]) * ex + (qy - A1[1]) * ey) / ((ex * ex + ey * ey) || 1))); dd = Math.min(dd, Math.hypot(qx - A1[0] - tt * ex, qy - A1[1] - tt * ey)); } if (dd > gbest){ gbest = dd; gx = qx; gy = qy; } }
    txt(gx, gy, 'SÂN VƯỜN', .2, { attr: { 'font-weight': 800, transform: gv ? 'rotate(-90 ' + gx + ' ' + gy + ')' : '' } }); if (U.gardenTT) txt(gv ? gx + .28 : gx, gv ? gy : gy + .25, 'TT ' + vn(U.gardenTT, 1) + ' m² (theo CĐT)', .14, { attr: { fill: COLORS.accent, 'font-weight': 800, transform: gv ? 'rotate(-90 ' + (gx + .28) + ' ' + gy + ')' : '' } }); }
  if (U.garden){ txt(-1.55, 7.6, 'SÂN VƯỜN', .2, { attr: { 'font-weight': 800, transform: 'rotate(-90 -1.55 7.6)' } }); txt(-1.25, 7.6, 'TT ' + vn(U.gardenTT, 1) + ' m² (theo CĐT)', .14, { attr: { fill: COLORS.accent, 'font-weight': 800, transform: 'rotate(-90 -1.25 7.6)' } });
  }
  // kích thước tổng
  function dim(x1, y1, x2, y2, off, label){ var hz = Math.abs(y2 - y1) < 1e-6, s = { stroke: COLORS.navy, 'stroke-width': .02 };
    if (hz){ var yy = y1 + off; el('line', Object.assign({ x1: x1, x2: x2, y1: yy, y2: yy }, s)); [x1, x2].forEach(function(xx){ el('line', Object.assign({ x1: xx, x2: xx, y1: yy - .12, y2: yy + .12 }, s)); }); txt((x1 + x2) / 2, yy - .08, label, .18, { attr: { 'font-weight': 700 } }); }
    else { var xx2 = x1 + off; el('line', Object.assign({ x1: xx2, x2: xx2, y1: y1, y2: y2 }, s)); [y1, y2].forEach(function(yv){ el('line', Object.assign({ x1: xx2 - .12, x2: xx2 + .12, y1: yv, y2: yv }, s)); }); txt(xx2 + .08, (y1 + y2) / 2, label, .18, { attr: { 'font-weight': 700, transform: 'rotate(90 ' + (xx2 + .08) + ' ' + ((y1 + y2) / 2) + ')' } }); }
  }
  if (U.auto){ var AB = bbox([].concat.apply([], U.rooms.map(function(r){ return r.poly; }))); dim(AB[0], AB[3] + .15, AB[2], AB[3] + .15, .55, vn(AB[2] - AB[0]) + ' m'); dim(AB[2] + .15, AB[1], AB[2] + .15, AB[3], .55, vn(AB[3] - AB[1]) + ' m'); }
  else { dim(0, 10.2, 6.08, 10.2, .55, vn(6.08) + ' m'); dim(6.28, 0, 6.28, 8.27, 2.15, vn(8.27) + ' m'); dim(7.97, 8.47, 7.97, 10, .4, vn(1.53) + ' m'); dim(0, 10.2, 7.77, 10.2, 1.05, vn(7.77) + ' m'); dim(-0.2, 0, -0.2, 10, -3.35, vn(10) + ' m'); }
  // tiêu đề, la bàn, chú thích
  var tX = vb[0] + .4, tY = vb[1] + .55;
  txt(tX, tY, (U.auto ? 'CĂN SỐ ' + U.unitNo + ' · ' + U.type + ' · TẦNG ' + U.floor + ' · TÒA ' + U.tower : 'CĂN ' + U.code + ' · ' + U.type + ' · TẦNG ' + U.floor + ' · TÒA ' + U.tower), .36, { attr: { 'text-anchor': 'start', 'font-weight': 800 } });
  txt(tX, tY + .42, (U.tim ? 'Tim ' + vn(U.tim, 1) + ' m² · ' : '') + 'Thông thủy ' + vn(U.tt, 1) + ' m²' + (U.gardenTT ? ' · Sân vườn TT ' + vn(U.gardenTT, 1) + ' m²' : '') + ' · Nội thất Hiện đại – gói Tiêu chuẩn', .2, { attr: { 'text-anchor': 'start', fill: '#4b5662' } });
  var cX = vb[0] + vb[2] - .9, cY = vb[1] + .9, ng = el('g', { transform: 'translate(' + cX + ' ' + cY + ') rotate(' + (-U.upBrg) + ')' });
  el('circle', { r: .55, fill: '#fff', stroke: COLORS.navy, 'stroke-width': .03 }, ng); el('path', { d: 'M0 -.45L.17 .05L-.17 .05Z', fill: COLORS.accent }, ng); el('path', { d: 'M0 .45L.17 .05L-.17 .05Z', fill: '#9fb0c2' }, ng);
  txt(cX, cY + .85, 'Bắc', .18, { attr: { 'font-weight': 800 } });
  txt(vb[0] + vb[2] / 2, vb[1] + vb[3] - .35, 'Minh họa · bố trí nội thất tham khảo · thông số theo CĐT, chính thức theo hợp đồng mua bán · Hoàng Hiệp 0904 567 009', .17, { attr: { fill: '#6b7785' } });
  var wm = el('text', { x: vb[0] + vb[2] / 2, y: vb[1] + vb[3] / 2, 'font-size': .7, 'text-anchor': 'middle', fill: 'rgba(10,37,64,.07)', 'font-weight': 800, transform: 'rotate(-30 ' + (vb[0] + vb[2] / 2) + ' ' + (vb[1] + vb[3] / 2) + ')' }); wm.textContent = 'MINH HỌA · 0904 567 009';
  document.getElementById('app').appendChild(svg);
  document.body.classList.add('ready');
}

/* ================= 3D ================= */
function scene3d(){
  var app = document.getElementById('app'), W = innerWidth, H = innerHeight;
  var renderer = new THREE.WebGLRenderer({ antialias: true, preserveDrawingBuffer: true });
  renderer.setPixelRatio(Math.min(devicePixelRatio || 1, 2)); renderer.setSize(W, H);
  renderer.shadowMap.enabled = true; renderer.shadowMap.type = THREE.PCFSoftShadowMap;
  renderer.outputEncoding = THREE.sRGBEncoding; renderer.toneMapping = THREE.ACESFilmicToneMapping; renderer.toneMappingExposure = 1.05;
  app.appendChild(renderer.domElement);
  var scene = new THREE.Scene(); scene.background = new THREE.Color(0xdfe9f2);
  var camera = new THREE.PerspectiveCamera(45, W / H, .05, 400);
  var controls = new THREE.OrbitControls(camera, renderer.domElement); controls.enableDamping = true; controls.maxPolarAngle = Math.PI * .495;
  var cx0 = 2.6, cz0 = 4.0; controls.target.set(cx0, .6, cz0);

  // ánh sáng: trời buổi sáng + nắng + đèn ấm trong nhà
  scene.add(new THREE.HemisphereLight(0xf4f7ff, 0xcab89a, .75));
  var sun = new THREE.DirectionalLight(0xfff1dc, 1.6); sun.position.set(-8, 14, -10); sun.castShadow = true; sun.shadow.mapSize.set(2048, 2048);
  var sc = sun.shadow.camera; sc.left = -9; sc.right = 12; sc.top = 12; sc.bottom = -9; sc.near = 1; sc.far = 50; sun.shadow.bias = -.0004; sun.target.position.set(cx0, 0, cz0); scene.add(sun); scene.add(sun.target);
  function M(c, o){ return new THREE.MeshStandardMaterial(Object.assign({ color: c, roughness: .7, metalness: 0 }, o || {})); }
  // vân gỗ sàn, gạch
  function tex(draw, w, h, rx, ry){ var c = document.createElement('canvas'); c.width = w; c.height = h; draw(c.getContext('2d'), w, h); var t = new THREE.CanvasTexture(c); t.wrapS = t.wrapT = THREE.RepeatWrapping; t.repeat.set(rx, ry); t.encoding = THREE.sRGBEncoding; t.anisotropy = 4; return t; }
  var woodT = tex(function(g, w, h){ g.fillStyle = '#dcc39f'; g.fillRect(0, 0, w, h); for (var r = 0; r < 8; r++){ for (var k = 0; k < 3; k++){ var l = 215 + Math.random() * 18 | 0; g.fillStyle = 'rgb(' + l + ',' + (l - 22) + ',' + (l - 52) + ')'; var off = (r % 2) * w / 6, x0 = (k * w / 3 + off) % w; g.fillRect(x0, r * h / 8, w / 3, h / 8); if (x0 + w / 3 > w) g.fillRect(x0 - w, r * h / 8, w / 3, h / 8); }
      g.strokeStyle = 'rgba(120,90,60,.25)'; g.lineWidth = 2; g.beginPath(); g.moveTo(0, r * h / 8); g.lineTo(w, r * h / 8); g.stroke();
      for (var s = 0; s < 14; s++){ g.strokeStyle = 'rgba(140,105,70,.12)'; g.beginPath(); var yy = r * h / 8 + Math.random() * h / 8; g.moveTo(0, yy); g.bezierCurveTo(w * .3, yy + 3, w * .6, yy - 3, w, yy + 1); g.stroke(); } } }, 512, 512, .5, .5);
  var tileT = tex(function(g, w, h){ g.fillStyle = '#e6e8e8'; g.fillRect(0, 0, w, h); g.strokeStyle = '#c5cacc'; g.lineWidth = 3; for (var k = 0; k <= 4; k++){ g.beginPath(); g.moveTo(k * w / 4, 0); g.lineTo(k * w / 4, h); g.stroke(); g.beginPath(); g.moveTo(0, k * h / 4); g.lineTo(w, k * h / 4); g.stroke(); } }, 256, 256, .8, .8);
  var grassT = tex(function(g, w, h){ g.fillStyle = '#7fae55'; g.fillRect(0, 0, w, h); for (var k = 0; k < 2500; k++){ var l = Math.random(); g.fillStyle = 'rgba(' + (60 + l * 60 | 0) + ',' + (120 + l * 60 | 0) + ',' + (40 + l * 30 | 0) + ',.6)'; g.fillRect(Math.random() * w, Math.random() * h, 2, 5); } }, 256, 256, .5, .5);
  var mat = {
    wood: M(0xffffff, { map: woodT, roughness: .55 }), tile: M(0xffffff, { map: tileT, roughness: .35 }), grass: M(0xffffff, { map: grassT, roughness: 1 }),
    wall: M(0xf1ece4, { roughness: .92 }), white: M(0xffffff, { roughness: .4 }), oak: M(0xc9a27a, { roughness: .55 }), walnut: M(0x6b4a33, { roughness: .5 }),
    fabric: M(0x9aa2ab, { roughness: .95 }), fabricD: M(0x6e7680, { roughness: .95 }), linen: M(0xf2efe9, { roughness: .95 }), beige: M(0xd9cbb5, { roughness: .95 }),
    black: M(0x1d2024, { roughness: .35, metalness: .3 }), steel: M(0xc8ccd0, { roughness: .3, metalness: .7 }), quartz: M(0xf4f2ee, { roughness: .25 }),
    smoke: new THREE.MeshPhysicalMaterial({ color: 0x3b4048, roughness: .1, metalness: .2, transparent: true, opacity: .62 }),
    glass: new THREE.MeshPhysicalMaterial({ color: 0xcfe6f2, roughness: .05, metalness: 0, transparent: true, opacity: .22 }),
    gold: M(0xc9a35a, { roughness: .3, metalness: .8 }), stone: M(0xd9d3c8, { roughness: .9 }), leaf: M(0x4f8a3a, { roughness: .9 }), trunk: M(0x8b7a62, { roughness: .9 }),
    rug: M(0xe2ddd4, { roughness: 1 }), rug2: M(0xb9b1a4, { roughness: 1 }), lampW: new THREE.MeshStandardMaterial({ color: 0xfff3d6, emissive: 0xffe0a8, emissiveIntensity: .9 })
  };
  var root = new THREE.Group(); scene.add(root);
  function box(w, h, d, m, x, y, z, parent){ var o = new THREE.Mesh(new THREE.BoxGeometry(w, h, d), m); o.position.set(x, y, z); o.castShadow = o.receiveShadow = true; (parent || root).add(o); return o; }
  function cyl(r1, r2, h, m, x, y, z, parent, seg){ var o = new THREE.Mesh(new THREE.CylinderGeometry(r1, r2, h, seg || 24), m); o.position.set(x, y, z); o.castShadow = o.receiveShadow = true; (parent || root).add(o); return o; }
  function flatPoly(P, m, y){ var s = new THREE.Shape(); P.forEach(function(p, k){ if (k) s.lineTo(p[0], -p[1]); else s.moveTo(p[0], -p[1]); }); var g = new THREE.ShapeGeometry(s); g.rotateX(-Math.PI / 2);
    var uv = g.attributes.uv, pos = g.attributes.position; for (var k = 0; k < uv.count; k++) uv.setXY(k, pos.getX(k), pos.getZ(k)); var o = new THREE.Mesh(g, m); o.position.y = y || 0; o.receiveShadow = true; root.add(o); return o; }
  // nền xung quanh + sàn tầng
  var ground = new THREE.Mesh(new THREE.PlaneGeometry(80, 80), M(0xd9d6cf, { roughness: 1 })); ground.rotation.x = -Math.PI / 2; ground.position.set(cx0, -.06, cz0); ground.receiveShadow = true; scene.add(ground);
  flatPoly(U.env, M(0xbdb8ae), -.02);
  U.gardens.forEach(function(G){ flatPoly(G.poly, mat.grass, .01); });
  U.rooms.forEach(function(r){ flatPoly(r.poly, r.floor === 'tile' ? mat.tile : mat.wood, .02); });
  // tường + cửa
  WALLS.forEach(function(w){ box(w[2] - w[0], WH, w[3] - w[1], mat.wall, (w[0] + w[2]) / 2, WH / 2, (w[1] + w[3]) / 2); });
  DOORS.forEach(function(w){ box(w[2] - w[0], WH - 2.25, w[3] - w[1], mat.wall, (w[0] + w[2]) / 2, 2.25 + (WH - 2.25) / 2, (w[1] + w[3]) / 2); });
  WINS.forEach(function(w){ var cx = (w[0] + w[2]) / 2, cz = (w[1] + w[3]) / 2, ww = w[2] - w[0], dd = w[3] - w[1];
    box(ww, .9, dd, mat.wall, cx, .45, cz); box(ww, WH - 2.4, dd, mat.wall, cx, 2.4 + (WH - 2.4) / 2, cz); box(ww * (ww < dd ? .25 : 1), 1.5, dd * (ww < dd ? 1 : .25), mat.glass, cx, 1.65, cz); });
  GLASSD.forEach(function(w){ var cx = (w[0] + w[2]) / 2, cz = (w[1] + w[3]) / 2, ww = w[2] - w[0], dd = w[3] - w[1];
    box(ww, WH - 2.4, dd, mat.wall, cx, 2.4 + (WH - 2.4) / 2, cz); box(ww * (ww < dd ? .25 : 1), 2.4, dd * (ww < dd ? 1 : .25), mat.glass, cx, 1.2, cz);
    box(ww < dd ? .05 : ww, 2.4, ww < dd ? dd : .05, mat.black, cx, 1.2, cz).scale.set(ww < dd ? 1 : .02, 1, ww < dd ? .02 : 1); });
  // cánh cửa đi (mở 90°) – gỗ
  U.doors.forEach(function(d){ var r = d.r, hz = (r[2] - r[0]) > (r[3] - r[1]), L = hz ? r[2] - r[0] : r[3] - r[1], room = U.rooms.filter(function(x){ return x.id === d.w; })[0], c = room ? bbox(room.poly) : [0, 0, 0, 0];
    var g = new THREE.Group(); root.add(g); var OPEN = d.main ? 0 : .45; var leaf = box(L - .04, 2.2, .04, d.main ? mat.walnut : mat.oak, (L - .04) / 2, 1.1, 0, g);
    if (hz){ var s = (c[1] + c[3]) / 2 > (r[1] + r[3]) / 2 ? 1 : -1; g.position.set(r[0], 0, s > 0 ? r[3] : r[1]); g.rotation.y = -s * Math.PI / 2 * OPEN; }
    else { var s2 = (c[0] + c[2]) / 2 > (r[0] + r[2]) / 2 ? 1 : -1; g.position.set(s2 > 0 ? r[2] : r[0], 0, r[1]); g.rotation.y = s2 > 0 ? -Math.PI / 2 + Math.PI / 2 * OPEN : -Math.PI / 2 - Math.PI / 2 * OPEN; } });
  // lan can kính sân vườn
  U.gardens.forEach(function(G){ G.rails.forEach(function(Rl){ for (var k = 0; k < Rl.length - 1; k++){ var a = Rl[k], b2 = Rl[k + 1], L2 = Math.hypot(b2[0] - a[0], b2[1] - a[1]), ang = Math.atan2(b2[1] - a[1], b2[0] - a[0]);
      var gp = box(L2, 1.1, .03, mat.glass, (a[0] + b2[0]) / 2, .55, (a[1] + b2[1]) / 2); gp.rotation.y = -ang; gp.castShadow = false;
      var tr = box(L2, .05, .06, mat.steel, (a[0] + b2[0]) / 2, 1.12, (a[1] + b2[1]) / 2); tr.rotation.y = -ang; } }); });

  /* ---- nội thất ---- */
  function holder(it){ var b = it.b || 'T', lw = (b === 'L' || b === 'R') ? it.d : it.w, ld = (b === 'L' || b === 'R') ? it.w : it.d;
    var g = new THREE.Group(); g.position.set(it.x + it.w / 2, 0, it.y + it.d / 2); g.rotation.y = { T: 0, B: Math.PI, L: Math.PI / 2, R: -Math.PI / 2 }[b]; root.add(g); return { g: g, lw: lw, ld: ld }; }
  var lights = [];
  function warm(x, y, z, I, dist){ var l = new THREE.PointLight(0xffd9a0, I, dist || 5, 2); l.position.set(x, y, z); root.add(l); lights.push(l); return l; }
  var B = {
    bed: function(it){ var h = holder(it), g = h.g, lw = h.lw, ld = h.ld; box(lw, .3, ld - .05, mat.oak, 0, .15, .02, g); box(lw - .08, .24, ld - .2, mat.linen, 0, .42, .05, g);
      box(lw + .1, 1.1, .1, mat.fabricD, 0, .55, -ld / 2 + .05, g); var np = 2; for (var k = 0; k < np; k++){ box(lw / np - .12, .14, .4, mat.white, -lw / 2 + (k + .5) * lw / np, .6, -ld / 2 + .38, g); }
      box(lw - .04, .1, ld * .6, mat.beige, 0, .58, ld * .18, g); box(lw + .02, .03, .5, mat.fabric, 0, .64, ld * .32, g); },
    headboard: function(it){ var o = box(it.w, 2.5, it.d, mat.fabricD, it.x + it.w / 2, 1.25, it.y + it.d / 2); for (var k = 0; k < Math.floor(it.d / .3); k++){ box(.02, 2.5, .02, mat.gold, it.x + it.w + .005, 1.25, it.y + .15 + k * .3); } },
    nightstand: function(it){ var h = holder(it), g = h.g; box(h.lw, .5, h.ld, mat.walnut, 0, .25, 0, g); cyl(.06, .08, .3, mat.gold, 0, .65, 0, g); var s = cyl(.14, .18, .2, mat.lampW, 0, .88, 0, g); s.castShadow = false; },
    wardrobe: function(it){ var h = holder(it), g = h.g, lw = h.lw, ld = h.ld, hh = WH - .05; box(lw, hh, ld - .04, mat.walnut, 0, hh / 2, -.02, g);
      var n = Math.max(2, Math.round(lw / .5)); for (var k = 0; k < n; k++){ var p = box(lw / n - .02, hh - .1, .02, mat.smoke, -lw / 2 + (k + .5) * lw / n, hh / 2, ld / 2 - .01, g); p.castShadow = false; box(.015, .5, .03, mat.gold, -lw / 2 + (k + .5) * lw / n + (k % 2 ? -1 : 1) * (lw / n / 2 - .06), 1.1, ld / 2 + .01, g); }
      for (var k2 = 0; k2 < 6; k2++) box(.3, .7, .04, k2 % 2 ? mat.beige : mat.fabric, -lw / 2 + .3 + k2 * (lw - .6) / 5, 1.6, 0, g); },
    tvconsole: function(it){ var h = holder(it), g = h.g; box(h.lw, .42, h.ld, mat.walnut, 0, .3, 0, g); box(h.lw, .02, h.ld, mat.oak, 0, .52, 0, g);
      if (it.tv){ box(Math.min(1.45, h.lw - .2), .82, .05, mat.black, 0, 1.35, -h.ld / 2 + .05, g); } else { box(Math.min(1.0, h.lw - .2), .58, .04, mat.black, 0, 1.25, -h.ld / 2 + .03, g); } },
    tvwall: function(it){ box(it.w, WH - .1, it.d, mat.walnut, it.x + it.w / 2, (WH - .1) / 2, it.y + it.d / 2); for (var k = 0; k < Math.floor(it.d / .12); k++) box(.03, WH - .1, .05, mat.oak, it.x + it.w + .01, (WH - .1) / 2, it.y + .06 + k * .12); },
    dresser: function(it){ var h = holder(it), g = h.g; box(h.lw, .04, h.ld, mat.oak, 0, .75, 0, g); box(h.lw - .05, .14, h.ld - .05, mat.walnut, 0, .66, 0, g);
      [[-1, -1], [1, -1], [-1, 1], [1, 1]].forEach(function(s){ box(.03, .73, .03, mat.gold, s[0] * (h.lw / 2 - .04), .365, s[1] * (h.ld / 2 - .04), g); }); var mi = box(.5, .8, .02, mat.steel, 0, 1.35, -h.ld / 2 + .01, g); cyl(.17, .17, .42, mat.beige, 0, .21, h.ld / 2 + .25, g); },
    rug: function(it){ box(it.w, .012, it.d, mat.rug, it.x + it.w / 2, .03, it.y + it.d / 2).castShadow = false; },
    shower: function(it){ box(it.w - .02, .04, it.d - .02, mat.white, it.x + it.w / 2, .04, it.y + it.d / 2); var gl = box(.02, 2.0, it.d * .8, mat.glass, it.x + it.w, 1.0, it.y + it.d * .6); gl.castShadow = false;
      cyl(.012, .012, 2.1, mat.steel, it.x + .1, 1.05, it.y + it.d / 2); cyl(.11, .11, .02, mat.steel, it.x + .22, 2.1, it.y + it.d / 2); },
    toilet: function(it){ var h = holder(it), g = h.g; box(h.lw * .9, .38, .16, mat.white, 0, .55, -h.ld / 2 + .1, g); var bw = new THREE.Mesh(new THREE.SphereGeometry(.2, 20, 12), mat.white); bw.scale.set(.95, .55, 1.25); bw.position.set(0, .4, .02); bw.castShadow = true; g.add(bw); },
    vanity: function(it){ var h = holder(it), g = h.g; box(h.lw, .42, h.ld, mat.walnut, 0, .62, 0, g); box(h.lw + .02, .04, h.ld + .02, mat.quartz, 0, .85, 0, g);
      var bs = cyl(.2, .16, .12, mat.white, 0, .93, .02, g); cyl(.012, .012, .25, mat.steel, 0, 1.0, -h.ld / 2 + .08, g); box(h.lw * .85, .8, .02, mat.steel, 0, 1.55, -h.ld / 2 + .01, g); box(h.lw * .85, .03, .04, mat.lampW, 0, 1.98, -h.ld / 2 + .03, g); },
    desk: function(it){ var h = holder(it), g = h.g; box(h.lw, .04, h.ld, mat.oak, 0, .74, 0, g); [[-1, -1], [1, -1], [-1, 1], [1, 1]].forEach(function(s){ box(.04, .72, .04, mat.black, s[0] * (h.lw / 2 - .04), .36, s[1] * (h.ld / 2 - .04), g); });
      box(.42, .05, .42, mat.fabric, 0, .46, h.ld / 2 + .25, g); box(.42, .45, .05, mat.fabric, 0, .7, h.ld / 2 + .46, g); cyl(.08, .1, .02, mat.black, 0, .02, h.ld / 2 + .25, g); cyl(.02, .02, .44, mat.black, 0, .24, h.ld / 2 + .25, g);
      cyl(.05, .07, .02, mat.black, h.lw / 2 - .15, .77, -h.ld / 2 + .12, g); cyl(.012, .012, .4, mat.black, h.lw / 2 - .15, .97, -h.ld / 2 + .12, g); },
    sofa: function(it){ var h = holder(it), g = h.g, lw = h.lw, ld = h.ld; box(lw, .2, ld, mat.black, 0, .12, 0, g); box(lw - .3, .2, ld - .25, mat.fabric, 0, .32, .1, g);
      box(lw, .45, .22, mat.fabric, 0, .55, -ld / 2 + .11, g); box(.15, .38, ld, mat.fabric, -lw / 2 + .075, .4, 0, g); box(.15, .38, ld, mat.fabric, lw / 2 - .075, .4, 0, g);
      for (var k = 0; k < 3; k++){ box((lw - .34) / 3 - .02, .14, ld - .3, mat.fabric, -lw / 2 + .17 + (k + .5) * (lw - .34) / 3, .49, .08, g); box(.38, .34, .1, k % 2 ? mat.beige : mat.fabricD, -lw / 2 + .45 + k * (lw - .9) / 2, .72, -ld / 2 + .3, g); } },
    coffeetable: function(it){ var o = cyl(.5, .5, .04, mat.walnut, it.x + it.w / 2, .4, it.y + it.d / 2, root, 40); o.scale.set(it.w, 1, it.d); cyl(.1, .14, .38, mat.black, it.x + it.w / 2, .19, it.y + it.d / 2); cyl(.08, .06, .12, mat.white, it.x + it.w / 2 + .1, .48, it.y + it.d / 2 - .1); },
    plant: function(it){ cyl(.18, .14, .45, mat.stone, it.x + it.w / 2, .22, it.y + it.d / 2); for (var k = 0; k < 7; k++){ var l = new THREE.Mesh(new THREE.SphereGeometry(.18, 8, 6), mat.leaf); l.position.set(it.x + it.w / 2 + Math.cos(k) * .14, .75 + k * .12, it.y + it.d / 2 + Math.sin(k * 1.7) * .14); l.scale.set(1, 1.4, .6); l.castShadow = true; root.add(l); } },
    dining: function(it){ var x = it.x + it.w / 2, z = it.y + it.d / 2; box(it.w, .04, it.d, mat.oak, x, .75, z); [[-1, -1], [1, -1], [-1, 1], [1, 1]].forEach(function(s){ box(.05, .73, .05, mat.black, x + s[0] * (it.w / 2 - .08), .365, z + s[1] * (it.d / 2 - .08)); });
      [[-1, -1], [1, -1], [-1, 1], [1, 1]].forEach(function(s){ var cz = z + s[1] * (it.d / 2 + .22), cx = x + s[0] * it.w / 4; box(.42, .05, .42, mat.beige, cx, .46, cz); box(.42, .42, .04, mat.beige, cx, .72, cz + s[1] * .2); [[-1, -1], [1, -1], [-1, 1], [1, 1]].forEach(function(q){ box(.025, .44, .025, mat.black, cx + q[0] * .18, .22, cz + q[1] * .18); }); });
      cyl(.07, .05, .18, mat.white, x - .2, .86, z); cyl(.07, .05, .14, mat.white, x + .25, .84, z + .05); },
    pendant: function(it){ cyl(.004, .004, 1.1, mat.black, it.x, WH - .55, it.y); var s = cyl(.05, .26, .22, mat.black, it.x, 1.95, it.y); s.castShadow = false; var b = new THREE.Mesh(new THREE.SphereGeometry(.07, 12, 8), mat.lampW); b.position.set(it.x, 1.86, it.y); root.add(b); warm(it.x, 1.8, it.y, .9, 4); },
    fridge: function(it){ var h = holder(it), g = h.g; box(h.lw, 1.85, h.ld, mat.steel, 0, .925, 0, g); box(.01, 1.8, .01, mat.black, 0, .925, h.ld / 2 + .005, g); box(.02, .5, .03, mat.black, -.06, 1.15, h.ld / 2 + .02, g); box(.02, .5, .03, mat.black, .06, 1.15, h.ld / 2 + .02, g); },
    kitchen: function(it){ var h = holder(it), g = h.g, lw = h.lw, ld = h.ld; box(lw, .78, ld - .04, mat.white, 0, .47, .02, g); box(lw, .08, ld - .1, mat.black, 0, .04, .0, g); box(lw + .01, .04, ld, mat.quartz, 0, .88, 0, g);
      for (var k = 0; k < Math.round(lw / .5); k++) box(.01, .7, .01, mat.wall, -lw / 2 + k * lw / Math.round(lw / .5), .47, ld / 2, g);
      box(lw, .7, .35, mat.oak, 0, 1.9, -ld / 2 + .175, g); box(lw, .6, .01, mat.quartz, 0, 1.2, -ld / 2 + .005, g);
      var along = function(off){ return -lw / 2 + off; };
      if (it.sink){ box(.5, .02, .4, mat.steel, along(it.sink), .905, .02, g); cyl(.015, .015, .32, mat.steel, along(it.sink), 1.05, -ld / 2 + .1, g); }
      if (it.hob){ box(.58, .015, .5, mat.black, along(it.hob), .905, .02, g); box(.6, .45, .45, mat.steel, along(it.hob), 1.78, -ld / 2 + .23, g); box(.6, .02, .45, mat.black, along(it.hob), 1.55, -ld / 2 + .23, g); } },
    washer: function(it){ var h = holder(it), g = h.g; box(h.lw, .85, h.ld, mat.white, 0, .425, 0, g); var d = cyl(.2, .2, .03, mat.glass, 0, .45, h.ld / 2 + .01, g); d.rotation.x = Math.PI / 2; var r = cyl(.22, .22, .02, mat.steel, 0, .45, h.ld / 2, g); r.rotation.x = Math.PI / 2; },
    dryrack: function(it){ for (var k = 0; k < 4; k++) cyl(.012, .012, it.w, mat.steel, it.x + it.w / 2, 2.35, it.y + .08 + k * (it.d - .16) / 3).rotation.z = Math.PI / 2;
      ['#e8e2d8', '#9fb7cc', '#ffffff', '#d4c2a8', '#b9c7b0'].forEach(function(c, k){ box(.32, .6, .015, M(new THREE.Color(c).getHex(), { roughness: .95 }), it.x + .15 + k * (it.w - .3) / 4, 2.02, it.y + .08 + (k % 4) * (it.d - .16) / 3); }); },
    stones: function(it){ it.pts.forEach(function(p){ var s = cyl(.3, .3, .05, mat.stone, p[0], .04, p[1], root, 18); s.scale.set(1, 1, .7); }); },
    palm: function(it){ var t = cyl(.06, .09, 3.3, mat.trunk, it.x, 1.65, it.y); for (var k = 0; k < 9; k++){ var f = new THREE.Mesh(new THREE.ConeGeometry(.16, 1.4, 4), mat.leaf); var a = k * Math.PI * 2 / 9; f.position.set(it.x + Math.cos(a) * .55, 3.25, it.y + Math.sin(a) * .55); f.rotation.set(Math.sin(a) * 1.15, 0, -Math.cos(a) * 1.15); f.scale.set(1, 1, .25); f.castShadow = true; root.add(f); } },
    outdoor: function(it){ var x = it.x + it.w / 2, z = it.y + it.d / 2; cyl(.35, .35, .03, mat.stone, x, .72, z); cyl(.03, .03, .7, mat.black, x, .36, z);
      [-1, 1].forEach(function(s){ box(.5, .06, .45, mat.beige, x, .42, z + s * .62); box(.5, .4, .05, mat.beige, x, .65, z + s * .84); [[-1, -1], [1, -1], [-1, 1], [1, 1]].forEach(function(q){ box(.03, .4, .03, mat.walnut, x + q[0] * .22, .2, z + s * .62 + q[1] * .2); }); });
      cyl(.02, .02, 2.3, mat.steel, x, 1.15, z); var u = new THREE.Mesh(new THREE.ConeGeometry(1.1, .45, 16, 1, true), M(0xf2ede4, { side: THREE.DoubleSide })); u.position.set(x, 2.3, z); u.castShadow = true; root.add(u); },
    shrubs: function(it){ for (var k = 0; k < 6; k++){ var s = new THREE.Mesh(new THREE.SphereGeometry(.32, 10, 8), mat.leaf); s.position.set(it.x + it.w / 2, .3, it.y + .25 + k * (it.d - .5) / 5); s.scale.set(1, .85, 1); s.castShadow = true; root.add(s); } }
  };
  U.items.forEach(function(it){ if (B[it.t]) B[it.t](it); });
  // đèn trần (âm trần) – ấm
  U.rooms.forEach(function(r){ if (r.outdoor || r.hide) return; var b = bbox(r.poly); warm((b[0] + b[2]) / 2, WH - .3, (b[1] + b[3]) / 2, r.id === 'liv' ? .7 : .45, 5.5); });
  // ốp gạch tường WC (cạnh có cửa đi thì bỏ)
  var tileW = M(0xffffff, { map: tex(function(g, w, h){ g.fillStyle = '#eceae6'; g.fillRect(0, 0, w, h); g.strokeStyle = '#d3d0ca'; g.lineWidth = 2; g.strokeRect(1, 1, w - 2, h / 2 - 1); g.strokeRect(1, h / 2, w - 2, h / 2 - 1); }, 256, 256, 1, 1), roughness: .3 });
  U.rooms.forEach(function(r){ if (r.floor !== 'tile' || r.outdoor) return; var b = bbox(r.poly), hh = 2.6;
    function door(side){ return U.doors.some(function(d){ var q = d.r; if (side === 'T') return Math.abs(q[3] - b[1]) < .3 && q[2] > b[0] && q[0] < b[2]; if (side === 'B') return Math.abs(q[1] - b[3]) < .3 && q[2] > b[0] && q[0] < b[2]; if (side === 'L') return Math.abs(q[2] - b[0]) < .3 && q[3] > b[1] && q[1] < b[3]; return Math.abs(q[0] - b[2]) < .3 && q[3] > b[1] && q[1] < b[3]; }); }
    if (!door('T')) box(b[2] - b[0], hh, .01, tileW, (b[0] + b[2]) / 2, hh / 2, b[1] + .006).castShadow = false;
    if (!door('B')) box(b[2] - b[0], hh, .01, tileW, (b[0] + b[2]) / 2, hh / 2, b[3] - .006).castShadow = false;
    if (!door('L')) box(.01, hh, b[3] - b[1], tileW, b[0] + .006, hh / 2, (b[1] + b[3]) / 2).castShadow = false;
    if (!door('R')) box(.01, hh, b[3] - b[1], tileW, b[2] - .006, hh / 2, (b[1] + b[3]) / 2).castShadow = false; });
  // tranh treo tường phòng khách, rèm cửa kính
  if (!U.auto){ box(.03, .7, 1.0, M(0x2f4f6b, { roughness: .6 }), 6.06, 1.65, 4.95); box(.035, .62, .92, M(0xd9b98c, { roughness: .8 }), 6.045, 1.65, 4.95); }
  GLASSD.concat(WINS).forEach(function(w){ var ww = w[2] - w[0], dd = w[3] - w[1], hz = ww > dd, n = 2; for (var k = 0; k < n; k++){ var off = (k ? 1 : -1) * ((hz ? ww : dd) / 2 + .12);
      var c = box(hz ? .3 : .06, WH - .15, hz ? .06 : .3, M(0xe9e3d8, { roughness: 1 }), hz ? (w[0] + w[2]) / 2 + off : (w[0] < 0 ? w[2] + .1 : w[0] - .1), (WH - .15) / 2, hz ? (w[1] < 0 ? w[3] + .1 : w[1] - .1) : (w[1] + w[3]) / 2 + off); c.castShadow = false; } });
  // trần nhà (chỉ hiện khi đứng trong phòng)
  var ceil = new THREE.Group(); scene.add(ceil);
  (function(){ var s = new THREE.Shape(); U.env.forEach(function(p, k){ if (k) s.lineTo(p[0], -p[1]); else s.moveTo(p[0], -p[1]); }); var g = new THREE.ShapeGeometry(s); g.rotateX(-Math.PI / 2); var o = new THREE.Mesh(g, M(0xfbfaf8, { side: THREE.DoubleSide, roughness: 1 })); o.position.y = WH; ceil.add(o);
    U.rooms.forEach(function(r){ if (r.outdoor || r.hide) return; var b = bbox(r.poly); for (var x = b[0] + .7; x < b[2] - .3; x += 1.2) for (var z = b[1] + .7; z < b[3] - .3; z += 1.4){ var d = cyl(.05, .05, .01, mat.lampW, x, WH - .006, z, ceil, 12); d.castShadow = false; } }); })();
  ceil.visible = false;

  // điểm nhìn đặt sẵn (mắt người 1,55 m)
  var CAMS = {
    overview: { p: [-4.2, 15.5, 12.8], t: [2.6, 0, 4.0], ceil: false, fov: 42 },
    top: { p: [2.9, 21, 4.4], t: [2.9, 0, 4.3], ceil: false, fov: 40 },
    living: { p: [3.55, 1.55, 4.3], t: [5.0, 1.05, .9], ceil: true, fov: 62 },
    dining: { p: [5.6, 1.55, 3.0], t: [3.7, .95, 8.8], ceil: true, fov: 62 },
    kitchen: { p: [5.5, 1.6, 6.3], t: [3.4, 1.0, 9.5], ceil: true, fov: 62 },
    master: { p: [1.95, 1.65, 3.55], t: [.35, .7, 1.25], ceil: true, fov: 70 },
    br2: { p: [2.3, 1.7, 7.15], t: [.3, .6, 8.9], ceil: true, fov: 70 },
    wc: { p: [2.45, 1.7, 4.8], t: [.6, .9, 5.75], ceil: true, fov: 78 },
    garden: { p: [4.4, 1.65, -2.2], t: [-1.6, .6, 3.5], ceil: false, fov: 60 },
    gardenTop: { p: [-6.5, 7.5, -5.5], t: [1.0, 0, 3.0], ceil: false, fov: 45 }
  };
  var CAPS = { overview: 'Tổng thể căn 2PN · sân vườn', gardenTop: 'Sân vườn riêng ~47,8 m²', garden: 'Sân vườn: cỏ, cau, đá bước, bàn ngoài trời', living: 'Phòng khách', dining: 'Bàn ăn 4 ghế', kitchen: 'Bếp chữ L · tủ lạnh 2 cánh', master: 'Phòng ngủ master · giường 1m8', wc: 'WC master', br2: 'Phòng ngủ 2 · bàn học', top: 'Toàn căn nhìn từ trên' }, NAMES = null;
  if (U.auto){ // điểm nhìn tự sinh theo phòng: đứng ở góc phòng phía trong, nhìn chéo về phía cửa kính
    var AB = bbox([].concat.apply([], U.rooms.map(function(r){ return r.poly; }))), cx = (AB[0] + AB[2]) / 2, cz = (AB[1] + AB[3]) / 2, R0 = Math.max(AB[2] - AB[0], AB[3] - AB[1]);
    CAMS = { overview: { p: [cx - R0 * .75, R0 * 1.45, cz + R0 * 1.15], t: [cx, 0, cz], ceil: false, fov: 42 }, top: { p: [cx, R0 * 2.1, cz + .01], t: [cx, 0, cz], ceil: false, fov: 40 } };
    CAPS = { overview: 'Tổng thể căn ' + U.type, top: 'Toàn căn nhìn từ trên' }; NAMES = { overview: 'Tổng thể', top: 'Nhìn từ trên' };
    U.rooms.forEach(function(r){ if (r.id === 'kho') return; var b = r.bb, ext = (r.ext || [])[0], w = b[2] - b[0], d = b[3] - b[1];
      var dir = ext === 'T' ? [0, -1] : ext === 'B' ? [0, 1] : ext === 'L' ? [-1, 0] : ext === 'R' ? [1, 0] : (w > d ? [1, 0] : [0, 1]);
      // đứng giữa phòng lùi về phía trong 30%, nhìn ra cạnh có cửa kính
      var e = [(b[0] + b[2]) / 2 - dir[0] * w * .3, (b[1] + b[3]) / 2 - dir[1] * d * .3], t = [(b[0] + b[2]) / 2 + dir[0] * w / 2, (b[1] + b[3]) / 2 + dir[1] * d / 2];
      if (!inPoly(e[0], e[1], r.poly)) e = [(b[0] + b[2]) / 2, (b[1] + b[3]) / 2];
      var small = r.id.indexOf('wc') === 0 || r.id === 'log';
      CAMS[r.id] = { p: [e[0], small ? 1.75 : 1.6, e[1]], t: [t[0], .9, t[1]], ceil: !r.outdoor, fov: small ? 80 : 70 }; CAPS[r.id] = r.name; NAMES[r.id] = r.name.replace('Khách + ăn + bếp', 'Khách · bếp').replace('Phòng ngủ', 'Ngủ'); }); }
  function setCam(k){ var c = CAMS[k] || CAMS.overview; camera.position.set(c.p[0], c.p[1], c.p[2]); controls.target.set(c.t[0], c.t[1], c.t[2]); camera.fov = c.fov; camera.updateProjectionMatrix(); ceil.visible = !!c.ceil; controls.update(); }
  setCam(Q.get('cam') || 'overview');
  addEventListener('resize', function(){ W = innerWidth; H = innerHeight; renderer.setSize(W, H); camera.aspect = W / H; camera.updateProjectionMatrix(); });
  // hành trình video 9:16 (t: 0 → 1)
  var PATH = U.auto ? Object.keys(CAMS).filter(function(k){ return k !== 'top'; }).concat(['top']) : ['overview', 'gardenTop', 'garden', 'living', 'dining', 'kitchen', 'master', 'wc', 'br2', 'top'];
  function lerp(a, b, t){ return a + (b - a) * t; }
  window.__frame = function(t){ var n = PATH.length - 1, f = Math.min(n - 1e-6, t * n), k = Math.floor(f), u = f - k; u = u * u * (3 - 2 * u);
    var A = CAMS[PATH[k]], Bc = CAMS[PATH[k + 1]], inside = (u < .5 ? A : Bc).ceil;
    camera.position.set(lerp(A.p[0], Bc.p[0], u), lerp(A.p[1], Bc.p[1], u), lerp(A.p[2], Bc.p[2], u)); controls.target.set(lerp(A.t[0], Bc.t[0], u), lerp(A.t[1], Bc.t[1], u), lerp(A.t[2], Bc.t[2], u));
    camera.fov = lerp(A.fov, Bc.fov, u); camera.updateProjectionMatrix(); ceil.visible = !!(A.ceil && Bc.ceil) || (inside && camera.position.y < 2.6 && (U.auto || camera.position.z > 0)); camera.lookAt(controls.target);
    var lbl = document.getElementById('cap'); if (lbl) lbl.textContent = CAPS[PATH[u < .5 ? k : k + 1]] || '';
    renderer.render(scene, camera); };
  window.__camNames = NAMES; window.__cams = Object.keys(CAMS); window.__setCam = function(k){ setCam(k); renderer.render(scene, camera); };
  var still = Q.has('still');
  (function loop(){ if (!still){ requestAnimationFrame(loop); controls.update(); } renderer.render(scene, camera); })();
  document.body.classList.add('ready');
}

if (VIEW === 'plan') plan2d(); else scene3d();
})();
