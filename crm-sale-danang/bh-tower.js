/* Khối 3D Tòa F2 dùng cho trang web chỉ căn (can.html) – sinh từ bang-hang.html, sửa ở đó rồi sinh lại */
const esc = s => String(s ?? '').replace(/[&<>"]/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]));
const POS_TYP = {'24':[520,450],'25':[640,410],'26':[750,440],'03':[1330,440],'03A':[1445,410],'05':[1560,450],'27':[740,580],'28':[735,680],'02':[1340,580],'01':[1340,680],'29':[870,745],'30':[985,745],'31':[1100,745],'32':[1210,745],'16':[870,1000],'15':[985,1000],'12B':[1100,1000],'12A':[1210,1000],'23':[530,610],'22':[530,725],'21':[530,835],'20':[530,930],'19':[510,1050],'18':[640,1070],'17':[750,1060],'06':[1545,610],'07':[1545,725],'08':[1545,835],'09':[1545,930],'10':[1570,1050],'11':[1440,1070],'12':[1330,1060]};
const POS_2 = {'03':[1350,410],'03A':[1460,390],'05':[1580,430],'06':[1570,600],'07':[1570,715],'08':[1570,830],'09':[1570,930],'10':[1580,1050],'11':[1460,1070],'12':[1350,1050]};
const fk = f => { const m = String(f).match(/^(\d+)([AB]?)$/); return m ? +m[1] + (m[2] === 'A' ? .3 : m[2] === 'B' ? .6 : 0) : 999; };
const F2_FOOT = [[435,340],[815,340],[815,630],[1265,630],[1265,340],[1645,340],[1645,1135],[435,1135]];
const F2_PODIUM = [[380,280],[1680,280],[1680,1195],[380,1195]];
const F2_BLOCKS = [[440,345,810,1135,70],[1265,345,1640,1135,70],[810,635,1265,1095,0]]; // cánh trái, cánh phải, khối giữa
const F2_GBLOCKS = [[380,285,810,1195,110],[1265,285,1700,1195,110],[810,635,1265,1130,0]]; // tầng 3–7 kèm dải sân vườn
const sideOf = u => ['06','07','08','09','10'].includes(u) ? [1,0] : ['11','12','12A','12B','15','16','17','18'].includes(u) ? [0,1] : ['19','20','21','22','23'].includes(u) ? [-1,0] : [0,-1];
const levelOf = f => ({'3A': 4, '12A': 13, '12B': 14})[f] || parseInt(f, 10) || 1;
const F2_RECT = {'24':[440,345,595,550],'25':[595,345,690,475],'26':[690,345,810,540],'27':[655,540,810,625],'28':[655,625,810,740],
  '23':[440,550,625,667],'22':[440,667,625,783],'21':[440,783,625,900],'20':[440,900,625,975],'19':[440,975,595,1135],'18':[595,1000,690,1135],'17':[690,970,810,1135],
  '29':[815,635,920,850],'30':[920,635,1030,850],'31':[1030,635,1140,850],'32':[1140,635,1245,850],'16':[815,880,920,1095],'15':[920,880,1030,1095],'12B':[1030,880,1140,1095],'12A':[1140,880,1245,1095],
  '03':[1265,345,1385,540],'03A':[1385,345,1455,475],'05':[1455,345,1640,550],'02':[1265,540,1415,625],'01':[1265,625,1415,740],
  '06':[1455,550,1640,667],'07':[1455,667,1640,783],'08':[1455,783,1640,900],'09':[1455,900,1640,975],'10':[1455,975,1640,1135],'11':[1385,1000,1455,1135],'12':[1265,970,1385,1135]};
const F2_GARDEN = [[380,285,810,1195,110],[1265,285,1700,1195,110],[800,1095,1275,1130,0]]; // dải sân vườn tầng 3–7
const F2_SIDES = [ // [pháp tuyến mặt, nhãn view]
  [[0,-1], 'Sông Hàn · biển · pháo hoa DIFF'], [[1,0], 'Ngũ Hành Sơn · CV Đầm Sen'], [[0,1], 'Nội khu · Nam Hòa Xuân'], [[-1,0], 'Sông · Sunneva']];
const svFloor = f => { const n = fk(f); return n >= 3 && n < 8; }, SV_SRC = /tang-(3|3a|5|6|7)-toa-f2/;
function towerSVGraw(u, rotOff = 0, k = .574) {
  const p = POS_TYP[u.u] || POS_2[u.u]; if (!p) return '';
  const n = sideOf(u.u), th = Math.PI / 2 - Math.atan2(n[1], n[0]) + rotOff; // xoay để mặt có căn quay ra phía trước
  const c = Math.cos(th), s = Math.sin(th), A = 15.5, B = A * k, H = 11.5 * Math.sqrt(1 - k * k) / .819, OX = 200, OY = 352 - (k - .574) * 160;
  const rot = (x, y) => { const a = (x - 1040) / 100, b = (y - 737) / 100; return [a * c - b * s, a * s + b * c]; };
  const pr = (x, y, z) => { const [ru, rv] = rot(x, y); return [OX + (ru - rv) * A, OY + (ru + rv) * B - z * H]; };
  const pts = arr => arr.map(q => q.map(v => v.toFixed(1)).join(',')).join(' ');
  const L = levelOf(u.floor);
  let g = '';
  // khối đặc: tường quay ra phía người xem (vẽ từ xa tới gần), vạch từng tầng, dải đỏ ở tầng của căn
  const mixC = (a, b, t) => '#' + [1, 3, 5].map(i => Math.round(parseInt(a.substr(i, 2), 16) * (1 - t) + parseInt(b.substr(i, 2), 16) * t).toString(16).padStart(2, '0')).join(''); // pha màu theo hướng mặt tường
  const solid = (foot, z0, z1, wallFill) => {
    const walls = [];
    foot.forEach((q, i) => { const r = foot[(i + 1) % foot.length], dx = r[0] - q[0], dy = r[1] - q[1], ln = Math.hypot(dx, dy);
      const nx = dy / ln, ny = -dx / ln, rn = [nx * c - ny * s, nx * s + ny * c], facing = rn[0] + rn[1];
      if (facing <= 0.01) return;
      const mid = rot((q[0] + r[0]) / 2, (q[1] + r[1]) / 2); walls.push({q, r, depth: mid[0] + mid[1], shade: Math.min(1, Math.max(0, (rn[0] - rn[1]) / 1.42 + .5))}); });
    walls.sort((a, b) => a.depth - b.depth).forEach(w => {
      g += `<polygon points="${pts([pr(w.q[0], w.q[1], z0), pr(w.r[0], w.r[1], z0), pr(w.r[0], w.r[1], z1), pr(w.q[0], w.q[1], z1)])}" fill="${mixC(wallFill[0], wallFill[1], w.shade)}" stroke="${mixC(wallFill[0], wallFill[1], w.shade)}" stroke-width=".8"/>`; // không kẻ viền dọc: mặt cong ở góc bo liền mạch
      g += `<line x1="${pr(w.q[0], w.q[1], z1)[0].toFixed(1)}" y1="${pr(w.q[0], w.q[1], z1)[1].toFixed(1)}" x2="${pr(w.r[0], w.r[1], z1)[0].toFixed(1)}" y2="${pr(w.r[0], w.r[1], z1)[1].toFixed(1)}" stroke="#93a69c" stroke-width=".7"/><line x1="${pr(w.q[0], w.q[1], z0)[0].toFixed(1)}" y1="${pr(w.q[0], w.q[1], z0)[1].toFixed(1)}" x2="${pr(w.r[0], w.r[1], z0)[0].toFixed(1)}" y2="${pr(w.r[0], w.r[1], z0)[1].toFixed(1)}" stroke="#93a69c" stroke-width=".7"/>`;
      for (let z = z0 + 1; z < z1; z++) g += `<line x1="${pr(w.q[0], w.q[1], z)[0].toFixed(1)}" y1="${pr(w.q[0], w.q[1], z)[1].toFixed(1)}" x2="${pr(w.r[0], w.r[1], z)[0].toFixed(1)}" y2="${pr(w.r[0], w.r[1], z)[1].toFixed(1)}" stroke="#c9d4cf" stroke-width=".45" opacity=".7"/>`;
      if (L > z0 && L <= z1) g += `<polygon points="${pts([pr(w.q[0], w.q[1], L - 1), pr(w.r[0], w.r[1], L - 1), pr(w.r[0], w.r[1], L), pr(w.q[0], w.q[1], L)])}" fill="#d9776c" stroke="#d9776c" stroke-width=".8"/>`;
    });
    g += `<polygon points="${pts(foot.map(q => pr(q[0], q[1], z1)))}" fill="#dfe9e3" stroke="#7d968a" stroke-width=".8"/>`;
  };
  // Tòa F2 dạng chữ H: 2 cánh + khối giữa (theo khung mặt bằng CĐT) – vẽ từng khối hộp từ xa tới gần cho đúng che khuất
  // khung chữ nhật bo góc (r = bán kính bo theo mặt bằng CĐT), xấp xỉ cung bằng các đoạn thẳng
  const box = ([x0, y0, x1, y1, r = 0]) => { if (!r) return [[x0, y0], [x1, y0], [x1, y1], [x0, y1]]; const o = [], N = 6;
    [[x1 - r, y0 + r, -90], [x1 - r, y1 - r, 0], [x0 + r, y1 - r, 90], [x0 + r, y0 + r, 180]].forEach(([cx, cy, a0]) => { for (let i = 0; i <= N; i++) { const a = (a0 + 90 * i / N) * Math.PI / 180; o.push([cx + r * Math.cos(a), cy + r * Math.sin(a)]); } });
    return o; }, dep = ([x0, y0, x1, y1]) => { const m = rot((x0 + x1) / 2, (y0 + y1) / 2); return m[0] + m[1]; };
  solid(box([380, 280, 1700, 1195, 110]), 0, 2, ['#e7ece9', '#d6ddd9']);
  // tầng 3–7: khối rộng hơn (có sân vườn bao quanh, tường xanh lá); tầng 8 trở lên: khối căn hộ tiêu chuẩn
  F2_GBLOCKS.slice().sort((a, b) => dep(a) - dep(b)).forEach(r => solid(box(r), 2, 7, ['#e4f0d6', '#cfe2bd']));
  F2_BLOCKS.slice().sort((a, b) => dep(a) - dep(b)).forEach(r => solid(box(r), 7, 20, ['#f3f6f4', '#dde5e0']));
  // mặt bằng tầng của căn đặt lên mái tòa (phép chiếu affine nên dùng ma trận biến đổi ảnh), cắt theo khối chữ H, khung đỏ là căn
  { const P0 = planOf(u.floor, 'F2'), o0 = pr(0, 0, 20), ex = pr(1, 0, 20), ey = pr(0, 1, 20), cid = 'tp' + Math.random().toString(36).slice(2);
    const img = /mat-bang-tang-.*fours-tower/.test(P0.img) ? P0.img.replace('bh-img/', 'bh-img/sach/') : P0.img, rr = F2_RECT[u.u];
    g += `<defs><clipPath id="${cid}">${F2_BLOCKS.map(r => `<polygon points="${pts(box(r).map(q => pr(q[0], q[1], 20)))}"/>`).join('')}</clipPath></defs>`
      + (TW_ROOF === 'sodo' ? `<g clip-path="url(#${cid})"><polygon points="${pts([[0, 0], [2000, 0], [2000, 1414], [0, 1414]].map(q => pr(q[0], q[1], 20)))}" fill="#f6efe4"/>${Object.keys(F2_RECT).filter(k => k !== u.u).map(k => `<polygon points="${pts(box(F2_RECT[k].map((v, i) => v + (i < 2 ? 7 : -7))).map(q => pr(q[0], q[1], 20)))}" fill="#efe5d6" stroke="#bba98f" stroke-width=".8"/>`).join('')}</g>`
        : `<g clip-path="url(#${cid})"><image href="${img}" x="0" y="0" width="2000" height="1414" preserveAspectRatio="none" opacity=".92" transform="matrix(${(ex[0] - o0[0]).toFixed(4)} ${(ex[1] - o0[1]).toFixed(4)} ${(ey[0] - o0[0]).toFixed(4)} ${(ey[1] - o0[1]).toFixed(4)} ${o0[0].toFixed(2)} ${o0[1].toFixed(2)})"/></g>`)
      + (rr ? `<polygon points="${pts(box(rr).map(q => pr(q[0], q[1], 20)))}" fill="${TW_ROOF === 'sodo' ? '#e53935' : 'rgba(213,0,0,.35)'}" stroke="${TW_ROOF === 'sodo' ? '#8e1b1b' : '#d50000'}" stroke-width="2"/>` : ''); }
  // chấm căn trên mặt tòa
  let fx = p[0], fy = p[1];
  if (['27', '28'].includes(u.u)) fx = 815; else if (['02', '01'].includes(u.u)) fx = 1265;
  else if (['29', '30', '31', '32'].includes(u.u)) fy = 630;
  else if (n[1] === -1) fy = svFloor(u.floor) ? 285 : u.floor === '2' ? 280 : 340; else if (n[0] === 1) fx = svFloor(u.floor) ? 1700 : u.floor === '2' ? 1680 : 1645; else if (n[1] === 1) fy = svFloor(u.floor) ? 1195 : 1135; else if (n[0] === -1) fx = svFloor(u.floor) ? 380 : 435;
  const m = pr(fx, fy, L - .5), m2 = pr(fx + n[0] * 100, fy + n[1] * 100, L - .5), d = [m2[0] - m[0] + 1e-6, m2[1] - m[1]], len = Math.hypot(d[0], d[1]), dx = d[0] / len, dy = d[1] / len;
  const vis = (n[0] * c - n[1] * s) + (n[0] * s + n[1] * c) > 0.05, op = vis ? 1 : .3; // mặt có căn quay ra sau khi xoay: làm mờ chấm & quạt (bị khối nhà che)
  const fan = [m, [m[0] + (dx - dy * .55) * 90, m[1] + (dy + dx * .55) * 90], [m[0] + (dx + dy * .55) * 90, m[1] + (dy - dx * .55) * 90]];
  g += `<polygon points="${pts(fan)}" fill="rgba(240,178,51,.42)" stroke="rgba(214,150,20,.8)" stroke-width=".8" opacity="${op}"/>`;
  g += `<circle cx="${m[0].toFixed(1)}" cy="${m[1].toFixed(1)}" r="7" fill="#c0392b" stroke="#fff" stroke-width="2" opacity="${op}"/>`;
  g += `<text x="${(m[0] + 10).toFixed(1)}" y="${(m[1] - 10).toFixed(1)}" font-size="13" font-weight="700" fill="#c0392b" paint-order="stroke" stroke="#fff" stroke-width="3">${esc(u.code)} · tầng ${esc(u.floor)}</text>`;
  F2_SIDES.forEach(([nn, label]) => { const q = pr(1040 + nn[0] * 820, 737 + nn[1] * 620, 23); const same = nn[0] === n[0] && nn[1] === n[1];
    g += `<text x="${q[0].toFixed(1)}" y="${q[1].toFixed(1)}" font-size="${same ? 11.5 : 10}" text-anchor="middle" fill="${same ? '#8a5a00' : '#6b7a73'}" font-weight="${same ? 700 : 400}" paint-order="stroke" stroke="#fff" stroke-width="3">${same ? '▶ ' : ''}${label}</text>`; });
  return `<svg viewBox="0 0 400 470" role="img" aria-label="Vị trí căn ${esc(u.code)} trên sơ đồ khối Tòa F2" style="width:100%;height:auto;background:linear-gradient(#eef5fb,#fff);border-radius:10px;border:1px solid var(--line)">${g}<text x="10" y="462" font-size="10" fill="#6b7a73">Mái: mặt bằng tầng của căn (khung đỏ) · minh họa, không theo tỉ lệ</text></svg>`;
}
