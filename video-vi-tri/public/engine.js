// Bộ dựng video: mỗi khung hình đặt camera + hiệu ứng, chờ bản đồ vẽ xong rồi mới chụp.
(async function () {
  const C = window.CONFIG;
  const P = C.palette;
  const qs = new URLSearchParams(location.search);
  const ui = document.getElementById('ui');

  // ---------- tiện ích toán ----------
  const clamp = (x, a = 0, b = 1) => Math.min(b, Math.max(a, x));
  const lerp = (a, b, t) => a + (b - a) * t;
  const E = {
    inOut: t => (t < .5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2),
    out: t => 1 - Math.pow(1 - t, 3),
    outQuint: t => 1 - Math.pow(1 - t, 5),
    back: t => { const c1 = 1.9, c3 = c1 + 1; return 1 + c3 * Math.pow(t - 1, 3) + c1 * Math.pow(t - 1, 2); },
  };
  // độ hiện 0..1 của một phần tử có thời điểm vào/ra
  const vis = (f, a, b, dIn = 14, dOut = 12) => Math.min(clamp((f - a) / dIn), b == null ? 1 : clamp((b - f) / dOut));
  const prog = (f, a, d) => clamp((f - a) / d);
  const M_PER_DEG_LAT = 110540;
  const mPerDegLng = lat => 111320 * Math.cos(lat * Math.PI / 180);
  const fmtKm = km => (km < 1 ? Math.round(km * 1000 / 10) * 10 + ' m' : km.toFixed(km < 10 ? 1 : 0).replace('.', ',') + ' km');

  // ---------- bản đồ ----------
  const k0 = C.camera[0];
  const map = new maplibregl.Map({
    container: 'map',
    style: { version: 8, sources: {}, layers: [{ id: 'bg', type: 'background', paint: { 'background-color': P.sea } }] },
    center: k0.c, zoom: k0.z, pitch: k0.p, bearing: k0.b,
    interactive: false, fadeDuration: 0, preserveDrawingBuffer: true, attributionControl: false,
    maxPitch: 78, pixelRatio: 1, antialias: (new URLSearchParams(location.search)).get("aa") !== "0",
  });
  await new Promise(r => map.on('load', r));

  const data = n => `data/${n}.geojson`;
  map.addSource('ocean', { type: 'geojson', data: data('ocean') });
  map.addSource('land', { type: 'geojson', data: data('landmass') });
  map.addSource('green', { type: 'geojson', data: data('green') });
  map.addSource('sand', { type: 'geojson', data: data('sand') });
  map.addSource('water', { type: 'geojson', data: data('water') });
  map.addSource('roads', { type: 'geojson', data: data('roads') });
  map.addSource('hoian', { type: 'geojson', data: data('hoian') });

  map.addLayer({ id: 'land', type: 'fill', source: 'land', paint: { 'fill-color': P.land, 'fill-antialias': true } });
  map.addLayer({ id: 'green', type: 'fill', source: 'green', paint: { 'fill-color': P.green, 'fill-opacity': .75 } });
  map.addLayer({ id: 'sand', type: 'fill', source: 'sand', paint: { 'fill-color': P.sand, 'fill-opacity': .9 } });
  map.addLayer({ id: 'water', type: 'fill', source: 'water', paint: { 'fill-color': P.water } });
  map.addLayer({ id: 'coast-glow', type: 'line', source: 'ocean', paint: { 'line-color': P.coast, 'line-width': ['interpolate', ['linear'], ['zoom'], 10, 4, 16, 26], 'line-blur': ['interpolate', ['linear'], ['zoom'], 10, 4, 16, 24], 'line-opacity': .35 } });
  map.addLayer({ id: 'coast', type: 'line', source: 'ocean', paint: { 'line-color': '#DCE8FF', 'line-width': ['interpolate', ['linear'], ['zoom'], 10, .8, 16, 2.4], 'line-opacity': .8 } });

  const roadW = (lo, hi) => ['interpolate', ['exponential', 1.6], ['zoom'], 10, lo, 17, hi];
  map.addLayer({ id: 'roads-minor', type: 'line', source: 'roads', filter: ['<=', ['get', 'r'], 1], minzoom: 12.5,
    layout: { 'line-cap': 'round', 'line-join': 'round' },
    paint: { 'line-color': P.roadMinor, 'line-width': roadW(.3, 5), 'line-opacity': ['interpolate', ['linear'], ['zoom'], 12.5, 0, 13.5, .55] } });
  map.addLayer({ id: 'roads-mid', type: 'line', source: 'roads', filter: ['==', ['get', 'r'], 2],
    layout: { 'line-cap': 'round', 'line-join': 'round' },
    paint: { 'line-color': '#C9D7EE', 'line-width': roadW(.5, 9), 'line-opacity': .7 } });
  map.addLayer({ id: 'roads-major-glow', type: 'line', source: 'roads', filter: ['>=', ['get', 'r'], 3],
    layout: { 'line-cap': 'round', 'line-join': 'round' },
    paint: { 'line-color': '#9CC1FF', 'line-width': roadW(4, 46), 'line-blur': roadW(4, 36), 'line-opacity': .22 } });
  map.addLayer({ id: 'roads-major', type: 'line', source: 'roads', filter: ['>=', ['get', 'r'], 3],
    layout: { 'line-cap': 'round', 'line-join': 'round' },
    paint: { 'line-color': '#FFFFFF', 'line-width': roadW(.9, 14), 'line-opacity': .92 } });

  // Ranh giới Hội An phát sáng
  map.addLayer({ id: 'hoian-fill', type: 'fill', source: 'hoian', paint: { 'fill-color': P.orange, 'fill-opacity': 0 } });
  map.addLayer({ id: 'hoian-glow', type: 'line', source: 'hoian', paint: { 'line-color': P.orange300, 'line-width': 22, 'line-blur': 16, 'line-opacity': 0 } });
  map.addLayer({ id: 'hoian-line', type: 'line', source: 'hoian', paint: { 'line-color': '#FFE2B8', 'line-width': 3, 'line-opacity': 0 } });

  // ---------- Dự án: tự chia lô minh họa theo ranh giới ----------
  const projPoly = turf.polygon([C.project.polygon.concat([C.project.polygon[0]])]);
  const projCenter = C.project.center || turf.centroid(projPoly).geometry.coordinates;
  const lots = buildLots(projPoly, C.project.gridBearing, C.project.grid);
  map.addSource('proj', { type: 'geojson', data: projPoly });
  map.addSource('lots', { type: 'geojson', data: lots });
  map.addLayer({ id: 'proj-fill', type: 'fill', source: 'proj', paint: { 'fill-color': P.navy800, 'fill-opacity': 0 } });
  map.addLayer({ id: 'lots-flat', type: 'fill', source: 'lots', paint: { 'fill-color': ['get', 'col'], 'fill-opacity': 0 } });
  map.addLayer({ id: 'proj-glow', type: 'line', source: 'proj', paint: { 'line-color': P.orange, 'line-width': 30, 'line-blur': 22, 'line-opacity': 0 } });
  map.addLayer({ id: 'proj-line', type: 'line', source: 'proj', layout: { 'line-join': 'round' }, paint: { 'line-color': '#FFFFFF', 'line-width': 4, 'line-opacity': 0, 'line-dasharray': [3, 1.5] } });

  // Tuyến đường bay
  const routes = C.events.filter(e => e.type === 'route');
  routes.forEach((r, i) => {
    r._id = 'route' + i;
    r._line = arc(r.from, r.to, r.bend ?? .25);
    r._len = turf.length(r._line);
    map.addSource(r._id, { type: 'geojson', data: turf.lineString([r.from, r.from]), lineMetrics: true });
    map.addLayer({ id: r._id + '-glow', type: 'line', source: r._id, layout: { 'line-cap': 'round' }, paint: { 'line-color': P.orange, 'line-width': 26, 'line-blur': 18, 'line-opacity': 0 } });
    map.addLayer({ id: r._id, type: 'line', source: r._id, layout: { 'line-cap': 'round' },
      paint: { 'line-width': 7, 'line-opacity': 0, 'line-gradient': ['interpolate', ['linear'], ['line-progress'], 0, 'rgba(255,255,255,0.15)', .55, P.orange300, 1, '#FFFFFF'] } });
  });

  // Tòa nhà 3D (bỏ các tòa nhà nằm trong ranh giới dự án)
  const bldAll = await (await fetch(data('buildings'))).json();
  const [px0, py0, px1, py1] = turf.bbox(projPoly);
  bldAll.features = bldAll.features.filter(ft => {
    const c = ft.geometry.type === 'Polygon' ? ft.geometry.coordinates[0][0] : ft.geometry.coordinates[0][0][0];
    if (c[0] < px0 - .0005 || c[0] > px1 + .0005 || c[1] < py0 - .0005 || c[1] > py1 + .0005) return true;
    return !turf.booleanIntersects(ft, projPoly);
  });
  map.addSource('bld', { type: 'geojson', data: bldAll });
  map.addLayer({ id: 'bld', type: 'fill-extrusion', source: 'bld', minzoom: 13,
    paint: { 'fill-extrusion-color': ['interpolate', ['linear'], ['get', 'h'], 6, P.bldLow, 40, P.bldHigh],
      'fill-extrusion-height': ['get', 'h'], 'fill-extrusion-opacity': .92, 'fill-extrusion-vertical-gradient': true } });
  map.addLayer({ id: 'lots-3d', type: 'fill-extrusion', source: 'lots',
    paint: { 'fill-extrusion-color': ['get', 'col'], 'fill-extrusion-height': 0, 'fill-extrusion-opacity': .95, 'fill-extrusion-vertical-gradient': true } });

  // ---------- Chữ nằm trên mặt đất ----------
  await document.fonts.load('900 100px "Be Vietnam Pro"', 'ĐƯỜNG BIỂN SƠN THỦY Ấậờ');
  await document.fonts.load('800 100px "Be Vietnam Pro"', 'Đường Biển Sơn Thủy Ấậờ');
  await document.fonts.ready;
  const labels = C.events.filter(e => e.type === 'label');
  labels.forEach((l, i) => {
    l._id = 'lbl' + i;
    const img = textImage(l.text, l.style || 'land');
    l._aspect = img.aspect;
    map.addSource(l._id, { type: 'image', url: img.url, coordinates: rect(l.at, l.width, img.aspect, l.bearing, 1) });
    map.addLayer({ id: l._id, type: 'raster', source: l._id, paint: { 'raster-opacity': 0, 'raster-fade-duration': 0, 'raster-resampling': 'linear' } });
  });

  // ---------- Phần tử HTML ----------
  const ICONS = {
    hotel: '<path d="M3 21V5h2v9h7V8h6a3 3 0 0 1 3 3v10h-2v-3H5v3H3zm5-8a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5z" fill="#fff"/>',
    beach: '<path d="M12 3a9 9 0 0 1 9 9h-8v8h3v2H8v-2h3v-8H3a9 9 0 0 1 9-9z" fill="#fff"/>',
    mountain: '<path d="M2 20l7-12 4 6 3-4 6 10H2z" fill="#fff"/>',
    plane: '<path d="M21 16v-2l-8-5V3.5a1.5 1.5 0 0 0-3 0V9l-8 5v2l8-2.5V19l-2 1.5V22l3.5-1 3.5 1v-1.5L13 19v-5.5l8 2.5z" fill="#fff"/>',
    city: '<path d="M3 21V9l6-3v3l6-3v15H3zm14 0V10h4v11h-4zM6 12v2h2v-2H6zm4 0v2h2v-2h-2zm-4 4v2h2v-2H6zm4 0v2h2v-2h-2z" fill="#fff"/>',
    star: '<path d="M12 2l3 7h7l-5.5 4.5L18.5 21 12 16.5 5.5 21l2-7.5L2 9h7z" fill="#fff"/>',
  };
  const el = (html, cls) => { const d = document.createElement('div'); if (cls) d.className = cls; d.innerHTML = html; d.style.opacity = 0; ui.appendChild(d); return d; };

  C.events.forEach(e => {
    if (e.type === 'poi') {
      const sub = e.sub ?? (e.showDist === false ? '' : '≈ ' + fmtKm(turf.distance(projCenter, e.at)));
      e._el = el(`<div class="beam"></div><div class="dot"></div><div class="card"><div class="ico"><svg viewBox="0 0 24 24">${ICONS[e.icon || 'star']}</svg></div><div><div class="t1">${e.name}</div>${sub ? `<div class="t2">${sub}</div>` : ''}</div></div>`, 'poi');
    } else if (e.type === 'pin') {
      e._el = el(`<div class="ring"></div><svg viewBox="0 0 92 120"><defs><linearGradient id="pg" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#FFB547"/><stop offset="1" stop-color="#FF7A1A"/></linearGradient></defs><path d="M46 118C46 118 6 70 6 44a40 40 0 0 1 80 0c0 26-40 74-40 74z" fill="url(#pg)" stroke="#fff" stroke-width="5"/><circle cx="46" cy="44" r="15" fill="#fff"/></svg>`, 'pin');
    } else if (e.type === 'dist') {
      const txt = e.text ?? ('≈ ' + fmtKm(turf.distance(e.from || projCenter, e.to)));
      e._el = el(`<div class="b">${txt}${e.small ? `<small>${e.small}</small>` : ''}</div>`, 'dist');
    } else if (e.type === 'title') {
      e._el = el(e.html, 'title'); e._el.style.top = (e.y ?? 300) + 'px';
    } else if (e.type === 'chip') {
      e._el = el(`<div class="n">${e.n}</div><div class="l">${e.text}<span>${e.sub || ''}</span></div>`, 'chip');
    } else if (e.type === 'route' && e.plane) {
      e._plane = el(`<svg viewBox="0 0 24 24" width="86" height="86">${ICONS.plane}</svg>`); e._plane.id = 'plane';
    } else if (e.type === 'end') {
      const d = document.createElement('div'); d.id = 'end'; d.innerHTML = e.html; document.getElementById('stage').appendChild(d); e._el = d;
    }
  });
  const fadeEl = document.getElementById('fade');

  // ---------- Camera: đường cong Hermite qua các điểm mốc ----------
  const keys = C.camera.map(k => ({ f: k.f, v: [k.c[0], k.c[1], k.z, k.p, k.b], hold: k.hold }));
  for (let i = 1; i < keys.length; i++) { // tránh xoay vòng dài
    let d = keys[i].v[4] - keys[i - 1].v[4];
    while (d > 180) { keys[i].v[4] -= 360; d -= 360; }
    while (d < -180) { keys[i].v[4] += 360; d += 360; }
  }
  const tang = keys.map((k, i) => {
    if (k.hold || i === 0 || i === keys.length - 1) return k.v.map(() => 0);
    const a = keys[i - 1], b = keys[i + 1];
    return k.v.map((_, j) => (b.v[j] - a.v[j]) / (b.f - a.f));
  });
  function camAt(f) {
    if (f <= keys[0].f) return keys[0].v;
    const last = keys[keys.length - 1];
    if (f >= last.f) return last.v;
    let i = 0; while (f >= keys[i + 1].f) i++;
    const a = keys[i], b = keys[i + 1], dt = b.f - a.f;
    const t = (f - a.f) / dt, t2 = t * t, t3 = t2 * t;
    const h00 = 2 * t3 - 3 * t2 + 1, h10 = t3 - 2 * t2 + t, h01 = -2 * t3 + 3 * t2, h11 = t3 - t2;
    return a.v.map((_, j) => h00 * a.v[j] + h10 * dt * tang[i][j] + h01 * b.v[j] + h11 * dt * tang[i + 1][j]);
  }

  // ---------- Hàm dựng 1 khung hình ----------
  const setP = (layer, prop, val) => { const key = layer + '|' + prop, s = JSON.stringify(val); if (setP.c[key] !== s) { setP.c[key] = s; map.setPaintProperty(layer, prop, val); } };
  setP.c = {};

  function apply(f) {
    const v = camAt(f);
    map.jumpTo({ center: [v[0], v[1]], zoom: v[2], pitch: v[3], bearing: v[4] });

    for (const e of C.events) {
      if (e.type === 'label') {
        const o = vis(f, e.in, e.out, 18, 14);
        const s = lerp(.86, 1, E.outQuint(prog(f, e.in, 26)));
        setP(e._id, 'raster-opacity', +o.toFixed(3));
        if (o > 0) map.getSource(e._id).setCoordinates(rect(e.at, e.width, e._aspect, e.bearing, s));
      } else if (e.type === 'project') {
        const o = vis(f, e.in, e.out, 24, 20);
        const lotsIn = E.out(prog(f, e.lotsIn ?? e.in + 10, 30));
        const pulse = .55 + .25 * Math.sin(f / 9);
        setP('proj-fill', 'fill-opacity', +(o * .85).toFixed(3));
        setP('proj-glow', 'line-opacity', +(o * pulse).toFixed(3));
        setP('proj-line', 'line-opacity', +(o * .95).toFixed(3));
        const rise = e.rise ? E.inOut(prog(f, e.rise[0], e.rise[1] - e.rise[0])) : 0;
        setP('lots-flat', 'fill-opacity', +(o * lotsIn * (1 - rise) * .95).toFixed(3));
        setP('lots-3d', 'fill-extrusion-opacity', +(Math.max(.001, o * rise * .95)).toFixed(3));
        setP('lots-3d', 'fill-extrusion-height', ['*', ['get', 'h'], +rise.toFixed(3)]);
      } else if (e.type === 'area') {
        const o = vis(f, e.in, e.out, 20, 16), pulse = .7 + .3 * Math.sin(f / 7);
        setP('hoian-fill', 'fill-opacity', +(o * .16).toFixed(3));
        setP('hoian-glow', 'line-opacity', +(o * pulse * .9).toFixed(3));
        setP('hoian-line', 'line-opacity', +o.toFixed(3));
      } else if (e.type === 'route') {
        const o = vis(f, e.in, e.out, 8, 14), p = E.inOut(prog(f, e.in, e.dur));
        setP(e._id, 'line-opacity', +o.toFixed(3));
        setP(e._id + '-glow', 'line-opacity', +(o * .5).toFixed(3));
        const key = p.toFixed(4);
        if (e._last !== key) { e._last = key; map.getSource(e._id).setData(partial(e, p)); }
      } else if (e.type === 'fade') {
        // xử lý bên dưới
      }
    }
    // độ tối toàn màn hình (chuyển cảnh)
    let fo = 0;
    for (const e of C.events.filter(x => x.type === 'fade')) {
      const t = (f - e.at) / e.dur; // -1..1 quanh e.at
      if (Math.abs(t) < 1) fo = Math.max(fo, 1 - Math.abs(t));
      if (e.hold && f >= e.at) fo = 1;
    }
    if (C.fadeIn) fo = Math.max(fo, 1 - clamp(f / C.fadeIn));
    fadeEl.style.opacity = fo.toFixed(3);
  }

  function overlays(f) {
    for (const e of C.events) {
      if (e.type === 'poi') {
        const o = vis(f, e.in, e.out, 16, 12);
        e._el.style.opacity = o;
        if (o <= 0) continue;
        const pt = map.project(e.at), s = E.back(clamp((f - e.in) / 18));
        const beamH = (e.beam ?? 170) * E.out(clamp((f - e.in) / 22));
        e._el.style.transform = `translate(${pt.x}px, ${pt.y}px)`;
        const beam = e._el.children[0], dot = e._el.children[1], card = e._el.children[2];
        beam.style.top = -beamH + 'px'; beam.style.height = beamH + 'px';
        dot.style.top = '0px';
        // giữ thẻ luôn nằm trong màn hình (lề 36px), có thể lệch ngang bằng dx
        const cw = card.offsetWidth, ch = card.offsetHeight;
        let left = pt.x + (e.dx || 0) - cw / 2;
        left = Math.min(1080 - 36 - cw, Math.max(36, left));
        card.style.position = 'absolute';
        card.style.left = (left - pt.x) + 'px';
        card.style.top = (-beamH - ch + 4) + 'px';
        card.style.transformOrigin = `${(pt.x - left).toFixed(0)}px 100%`;
        card.style.transform = `scale(${s.toFixed(3)})`;
      } else if (e.type === 'pin') {
        const o = vis(f, e.in, e.out, 10, 12);
        e._el.style.opacity = o;
        if (o <= 0) continue;
        const pt = map.project(e.at), t = clamp((f - e.in) / 24);
        const drop = (1 - E.back(t)) * -160, bob = Math.sin(f / 10) * 6 * t;
        e._el.style.transform = `translate(${pt.x}px, ${pt.y}px)`;
        e._el.children[1].style.transform = `translate(-50%, calc(-100% + ${(drop + bob).toFixed(1)}px))`;
        const ring = e._el.children[0], rp = ((f - e.in) % 40) / 40;
        ring.style.transform = `scale(${(1 + rp * 2.4).toFixed(3)})`; ring.style.opacity = (1 - rp).toFixed(3);
      } else if (e.type === 'dist') {
        const o = vis(f, e.in, e.out, 12, 12);
        e._el.style.opacity = o;
        if (o <= 0) continue;
        const pt = map.project(e.at || turf.midpoint(e.from || projCenter, e.to).geometry.coordinates);
        e._el.style.transform = `translate(${pt.x}px, ${pt.y}px) scale(${E.back(clamp((f - e.in) / 16)).toFixed(3)})`;
      } else if (e.type === 'title' || e.type === 'chip') {
        const o = vis(f, e.in, e.out, 18, 14);
        e._el.style.opacity = o;
        const y = (1 - E.outQuint(clamp((f - e.in) / 24))) * 40;
        e._el.style.transform = `translateY(${y.toFixed(1)}px)`;
        const rule = e._el.querySelector('.rule');
        if (rule) rule.style.transform = `scaleX(${E.outQuint(clamp((f - e.in - 6) / 24)).toFixed(3)})`;
      } else if (e.type === 'route' && e._plane) {
        const o = vis(f, e.in + 2, e.out, 6, 12) * (prog(f, e.in, e.dur) < 1 ? 1 : 0.0);
        e._plane.style.opacity = o;
        if (o <= 0) continue;
        const p = E.inOut(prog(f, e.in, e.dur));
        const a = turf.along(e._line, Math.max(0.001, e._len * p)).geometry.coordinates;
        const b = turf.along(e._line, Math.max(0, e._len * p - e._len * .01)).geometry.coordinates;
        const pa = map.project(a), pb = map.project(b);
        const ang = Math.atan2(pa.y - pb.y, pa.x - pb.x) * 180 / Math.PI + 90;
        e._plane.style.transform = `translate(${pa.x}px, ${pa.y}px) rotate(${ang.toFixed(1)}deg)`;
      } else if (e.type === 'end') {
        const o = clamp((f - e.in) / 18);
        e._el.style.opacity = o;
        const items = e._el.children;
        for (let i = 0; i < items.length; i++) {
          const t = E.outQuint(clamp((f - e.in - 8 - i * 6) / 22));
          items[i].style.opacity = t; items[i].style.transform = `translateY(${((1 - t) * 40).toFixed(1)}px)`;
        }
      }
    }
  }

  function waitIdle() {
    return new Promise(res => {
      let done = false;
      const fin = () => { if (!done) { done = true; res(); } };
      map.once('idle', fin);
      setTimeout(fin, 8000);
      map.triggerRepaint();
    });
  }

  window.renderFrame = async f => { apply(f); overlays(f); await waitIdle(); overlays(f); return true; };
  window.TOTAL = C.duration;

  // Xem thử: ?f=120 hoặc ?cam=lng,lat,zoom,pitch,bearing
  if (qs.get('cam')) {
    const [x, y, z, p, b] = qs.get('cam').split(',').map(Number);
    C.camera.length = 0; keys.length = 0;
    map.jumpTo({ center: [x, y], zoom: z, pitch: p, bearing: b });
    window.renderFrame = async () => { await waitIdle(); return true; };
  }
  await waitIdle();
  window.READY = true;

  // ---------- hàm phụ ----------
  function rect(at, widthM, aspect, bearing, s) {
    const w = widthM * s, h = w / aspect, br = bearing * Math.PI / 180;
    const ux = Math.sin(br), uy = Math.cos(br); // hướng chân chữ (đông, bắc)
    const vx = -uy, vy = ux;                     // hướng lên của chữ
    const kx = 1 / mPerDegLng(at[1]), ky = 1 / M_PER_DEG_LAT;
    const pt = (a, b) => [at[0] + (ux * a + vx * b) * kx, at[1] + (uy * a + vy * b) * ky];
    return [pt(-w / 2, h / 2), pt(w / 2, h / 2), pt(w / 2, -h / 2), pt(-w / 2, -h / 2)];
  }

  function textImage(text, style) {
    const S = {
      sea:   { size: 220, weight: 900, fill: '#FFFFFF', stroke: null, glow: 'rgba(140,190,255,.55)', spacing: 26 },
      land:  { size: 150, weight: 800, fill: '#FFFFFF', stroke: '#0B1F3A', sw: 16, glow: 'rgba(0,0,0,.6)', spacing: 6 },
      road:  { size: 130, weight: 800, fill: '#FFFFFF', stroke: '#0B1F3A', sw: 16, glow: 'rgba(0,0,0,.6)', spacing: 10 },
      brand: { size: 210, weight: 900, fill: '#FFFFFF', stroke: '#0B1F3A', sw: 18, glow: 'rgba(255,122,26,1)', spacing: 12 },
    }[style];
    const c = document.createElement('canvas'), x = c.getContext('2d');
    x.font = `${S.weight} ${S.size}px "Be Vietnam Pro"`; x.letterSpacing = S.spacing + 'px';
    const m = x.measureText(text), pad = S.size * .55;
    c.width = Math.ceil(m.width + pad * 2); c.height = Math.ceil(S.size * 1.45 + pad);
    x.font = `${S.weight} ${S.size}px "Be Vietnam Pro"`; x.letterSpacing = S.spacing + 'px';
    x.textAlign = 'center'; x.textBaseline = 'middle'; x.lineJoin = 'round';
    const cx = c.width / 2, cy = c.height / 2 + S.size * .06;
    x.shadowColor = S.glow; x.shadowBlur = S.size * .35;
    if (S.stroke) { x.strokeStyle = S.stroke; x.lineWidth = S.sw * 2; x.strokeText(text, cx, cy); }
    x.shadowBlur = S.stroke ? 0 : S.size * .35;
    x.fillStyle = S.fill; x.fillText(text, cx, cy);
    return { url: c.toDataURL('image/png'), aspect: c.width / c.height };
  }

  function arc(a, b, bend) {
    const kx = mPerDegLng((a[1] + b[1]) / 2), ky = M_PER_DEG_LAT;
    const ax = a[0] * kx, ay = a[1] * ky, bx = b[0] * kx, by = b[1] * ky;
    const mx = (ax + bx) / 2, my = (ay + by) / 2, dx = bx - ax, dy = by - ay;
    const cx = mx - dy * bend, cy = my + dx * bend;
    const pts = [];
    for (let i = 0; i <= 160; i++) {
      const t = i / 160, u = 1 - t;
      pts.push([(u * u * ax + 2 * u * t * cx + t * t * bx) / kx, (u * u * ay + 2 * u * t * cy + t * t * by) / ky]);
    }
    return turf.lineString(pts);
  }
  function partial(r, p) {
    if (p <= 0.001) return turf.lineString([r.from, r.from]);
    return turf.lineSliceAlong(r._line, 0, Math.max(0.0005, r._len * p));
  }

  function buildLots(poly, bearing, g) {
    const pivot = turf.centroid(poly);
    const flat = turf.transformRotate(poly, -bearing, { pivot });
    const [minX, minY, maxX, maxY] = turf.bbox(flat);
    const lat = (minY + maxY) / 2, kx = 1 / mPerDegLng(lat), ky = 1 / M_PER_DEG_LAT;
    const feats = []; let seed = 11;
    const rnd = () => (seed = (seed * 9301 + 49297) % 233280) / 233280;
    const bw = g.blockW, bh = g.blockH, st = g.street;
    let row = 0;
    for (let y = minY + st * ky; y < maxY; y += (bh + st) * ky, row++) {
      let col = 0;
      for (let x = minX + st * kx; x < maxX; x += (bw + st) * kx, col++) {
        const special = g.parks.some(([r, c]) => r === row && c === col);
        const cells = [];
        if (special) cells.push({ x0: x, y0: y, x1: x + bw * kx, y1: y + bh * ky, col: P.park, h: 1.5 });
        else {
          const n = Math.max(2, Math.round(bw / g.lotW));
          for (let r = 0; r < 2; r++) for (let i = 0; i < n; i++) {
            const gap = .8;
            const x0 = x + (i * bw / n + gap / 2) * kx, x1 = x + ((i + 1) * bw / n - gap / 2) * kx;
            const y0 = y + (r * bh / 2 + gap / 2) * ky, y1 = y + ((r + 1) * bh / 2 - gap / 2) * ky;
            const shade = rnd();
            cells.push({ x0, y0, x1, y1, col: shade < .15 ? P.lotB : shade < .3 ? P.lotC : P.orange, h: 7 + Math.round(rnd() * 3) * 3.5 });
          }
        }
        for (const c of cells) {
          const sq = turf.polygon([[[c.x0, c.y0], [c.x1, c.y0], [c.x1, c.y1], [c.x0, c.y1], [c.x0, c.y0]]]);
          const back = turf.transformRotate(sq, bearing, { pivot });
          const cut = turf.intersect(turf.featureCollection([back, poly]));
          if (cut && turf.area(cut) > 25) { cut.properties = { col: c.col, h: c.h }; feats.push(cut); }
        }
      }
    }
    return turf.featureCollection(feats);
  }
})();
