// Sinh vân vật liệu bằng canvas (không cần tải ảnh): gỗ, gạch, đá, thảm, bê tông, cỏ, tường sơn.
import * as THREE from 'three';

function rand(seed) {
  let s = seed >>> 0;
  return () => ((s = (s * 1664525 + 1013904223) >>> 0) / 4294967296);
}
function canvas(size) {
  const c = document.createElement('canvas');
  c.width = c.height = size;
  return [c, c.getContext('2d')];
}
function noise(ctx, size, amount, r, alpha = 0.06) {
  const img = ctx.getImageData(0, 0, size, size);
  for (let i = 0; i < img.data.length; i += 4) {
    const n = (r() - 0.5) * amount;
    img.data[i] += n; img.data[i + 1] += n; img.data[i + 2] += n;
  }
  ctx.putImageData(img, 0, 0);
}
const shade = (hex, f) => {
  const c = new THREE.Color(hex);
  c.offsetHSL(0, 0, f);
  return '#' + c.getHexString();
};

const generators = {
  // Sàn gỗ: ván 0.18m, so le — 1 ô vân = 2.4m
  wood: (base = '#a8744a') => {
    const [c, x] = canvas(1024), r = rand(7);
    const size = 2.4, plankW = 0.18, plankL = 1.2, ppm = 1024 / size;
    const rows = Math.round(size / plankW);
    for (let i = 0; i < rows; i++) {
      const off = (i % 3) * 0.4 * ppm;
      for (let j = -1; j < 3; j++) {
        const x0 = j * plankL * ppm + off, y0 = (i * 1024) / rows;
        x.fillStyle = shade(base, (r() - 0.5) * 0.12);
        x.fillRect(x0, y0, plankL * ppm, 1024 / rows);
        x.globalAlpha = 0.18;
        for (let k = 0; k < 14; k++) {
          x.strokeStyle = r() > 0.5 ? shade(base, -0.18) : shade(base, 0.1);
          x.lineWidth = 0.5 + r() * 1.6;
          x.beginPath();
          const yy = y0 + r() * (1024 / rows);
          x.moveTo(x0, yy);
          x.bezierCurveTo(x0 + plankL * ppm * 0.3, yy + (r() - 0.5) * 8, x0 + plankL * ppm * 0.7, yy + (r() - 0.5) * 8, x0 + plankL * ppm, yy);
          x.stroke();
        }
        x.globalAlpha = 1;
        x.fillStyle = 'rgba(40,25,15,0.55)';
        x.fillRect(x0, y0, 2, 1024 / rows);
      }
      x.fillStyle = 'rgba(40,25,15,0.45)';
      x.fillRect(0, (i * 1024) / rows, 1024, 2);
    }
    noise(x, 1024, 14, r);
    return { c, size };
  },
  oak: () => generators.wood('#cfa77a'),
  walnut: () => generators.wood('#6a4630'),
  // Gỗ xương cá: thanh 0.6 x 0.1m, lưới lặp (W,W) & (L,-L) xoay 45° => ô vân vuông L·√2
  herringbone: (base = '#9a6a45') => {
    const [c, x] = canvas(1024), r = rand(31);
    const Lm = 0.6, Wm = 0.1, size = Lm * Math.SQRT2, ppm = 1024 / size, L = Lm * ppm, W = Wm * ppm;
    x.fillStyle = shade(base, -0.25); x.fillRect(0, 0, 1024, 1024);
    x.save();
    x.rotate(-Math.PI / 4);
    const plank = (px, py, w, h) => {
      x.fillStyle = shade(base, (r() - 0.5) * 0.16);
      x.fillRect(px + 0.8, py + 0.8, w - 1.6, h - 1.6);
      x.globalAlpha = 0.15;
      const horiz = w > h;
      for (let k = 0; k < 5; k++) {
        x.strokeStyle = r() > 0.5 ? shade(base, -0.22) : shade(base, 0.12);
        x.lineWidth = 0.6 + r();
        x.beginPath();
        if (horiz) { const yy = py + r() * h; x.moveTo(px, yy); x.lineTo(px + w, yy + (r() - 0.5) * 3); }
        else { const xx = px + r() * w; x.moveTo(xx, py); x.lineTo(xx + (r() - 0.5) * 3, py + h); }
        x.stroke();
      }
      x.globalAlpha = 1;
    };
    for (let j = -8; j <= 8; j++)
      for (let t = -40; t <= 40; t++) {
        const ox = t * W + j * L, oy = t * W - j * L;
        plank(ox, oy, L, W);
        plank(ox, oy + W, W, L);
      }
    x.restore();
    noise(x, 1024, 10, r);
    return { c, size };
  },
  herringboneLight: () => generators.herringbone('#c9a073'),
  darkTile: () => generators.tile('#4a4c50', 0.6, '#2c2d30'),
  // Gạch bông (encaustic) 20x20cm hoạ tiết hoa
  encaustic: () => {
    const [c, x] = canvas(512), r = rand(41);
    const n = 4, s = 512 / n;
    for (let i = 0; i < n; i++) for (let j = 0; j < n; j++) {
      x.save(); x.translate(i * s, j * s);
      x.fillStyle = '#efe7d6'; x.fillRect(0, 0, s, s);
      x.fillStyle = '#2f5d50';
      for (const [cx, cy] of [[0, 0], [s, 0], [0, s], [s, s]]) { x.beginPath(); x.arc(cx, cy, s * 0.32, 0, Math.PI * 2); x.fill(); }
      x.fillStyle = '#c99a2e';
      x.beginPath(); x.moveTo(s / 2, s * 0.18); x.lineTo(s * 0.82, s / 2); x.lineTo(s / 2, s * 0.82); x.lineTo(s * 0.18, s / 2); x.closePath(); x.fill();
      x.fillStyle = '#efe7d6'; x.beginPath(); x.arc(s / 2, s / 2, s * 0.12, 0, Math.PI * 2); x.fill();
      x.fillStyle = '#2f5d50'; x.beginPath(); x.arc(s / 2, s / 2, s * 0.05, 0, Math.PI * 2); x.fill();
      x.strokeStyle = 'rgba(0,0,0,0.25)'; x.lineWidth = 2; x.strokeRect(0, 0, s, s);
      x.restore();
    }
    noise(x, 512, 10, r);
    return { c, size: 0.8 };
  },
  polished: () => {
    const [c, x] = canvas(512), r = rand(51);
    x.fillStyle = '#c4c2bd'; x.fillRect(0, 0, 512, 512);
    for (let i = 0; i < 500; i++) { x.fillStyle = `rgba(${r() > 0.5 ? '255,255,255' : '0,0,0'},${r() * 0.05})`; x.beginPath(); x.arc(r() * 512, r() * 512, 2 + r() * 40, 0, 7); x.fill(); }
    noise(x, 512, 8, r);
    return { c, size: 3 };
  },
  // Vân gỗ xám trung tính để nhuộm theo màu gỗ đã chọn
  woodGrain: () => {
    const [c, x] = canvas(512), r = rand(61);
    x.fillStyle = '#d8d8d8'; x.fillRect(0, 0, 512, 512);
    for (let k = 0; k < 90; k++) {
      x.strokeStyle = `rgba(${r() > 0.5 ? '90,90,90' : '255,255,255'},${0.08 + r() * 0.18})`;
      x.lineWidth = 0.6 + r() * 2.5;
      const y = r() * 512;
      x.beginPath(); x.moveTo(0, y);
      x.bezierCurveTo(170, y + (r() - 0.5) * 30, 340, y + (r() - 0.5) * 30, 512, y + (r() - 0.5) * 10);
      x.stroke();
    }
    noise(x, 512, 8, r);
    return { c, size: 1 };
  },
  fabric: () => {
    const [c, x] = canvas(256), r = rand(71);
    x.fillStyle = '#e6e6e6'; x.fillRect(0, 0, 256, 256);
    for (let i = 0; i < 256; i += 2) { x.fillStyle = `rgba(0,0,0,${0.03 + r() * 0.03})`; x.fillRect(i, 0, 1, 256); x.fillRect(0, i, 256, 1); }
    noise(x, 256, 16, r);
    return { c, size: 0.25 };
  },
  tile: (base = '#e9edf0', tile = 0.6, grout = '#b9c0c5') => {
    const [c, x] = canvas(512), r = rand(3);
    const size = tile * 2, n = 2, s = 512 / n;
    x.fillStyle = grout; x.fillRect(0, 0, 512, 512);
    for (let i = 0; i < n; i++) for (let j = 0; j < n; j++) {
      x.fillStyle = shade(base, (r() - 0.5) * 0.04);
      x.fillRect(i * s + 2, j * s + 2, s - 4, s - 4);
      const g = x.createLinearGradient(i * s, j * s, i * s + s, j * s + s);
      g.addColorStop(0, 'rgba(255,255,255,0.15)'); g.addColorStop(1, 'rgba(0,0,0,0.04)');
      x.fillStyle = g; x.fillRect(i * s + 2, j * s + 2, s - 4, s - 4);
    }
    noise(x, 512, 6, r);
    return { c, size };
  },
  terracotta: () => generators.tile('#c4704f', 0.4, '#e3d6c8'),
  marble: () => {
    const [c, x] = canvas(1024), r = rand(11);
    const size = 1.6;
    x.fillStyle = '#f2f0ec'; x.fillRect(0, 0, 1024, 1024);
    for (let k = 0; k < 26; k++) {
      x.strokeStyle = `rgba(${120 + r() * 40},${120 + r() * 40},${130 + r() * 40},${0.08 + r() * 0.22})`;
      x.lineWidth = 0.6 + r() * 2.5;
      x.beginPath();
      let px = r() * 1024, py = 0;
      x.moveTo(px, py);
      while (py < 1024) { px += (r() - 0.45) * 60; py += 20 + r() * 40; x.lineTo(px, py); }
      x.stroke();
    }
    x.fillStyle = 'rgba(160,160,160,0.6)';
    x.fillRect(0, 511, 1024, 2); x.fillRect(511, 0, 2, 1024); x.fillRect(0, 0, 1024, 1); x.fillRect(0, 0, 1, 1024);
    noise(x, 1024, 5, r);
    return { c, size };
  },
  carpet: () => {
    const [c, x] = canvas(256), r = rand(5);
    x.fillStyle = '#b9ab9a'; x.fillRect(0, 0, 256, 256);
    noise(x, 256, 40, r);
    return { c, size: 0.5 };
  },
  concrete: () => {
    const [c, x] = canvas(512), r = rand(9);
    x.fillStyle = '#a9a9a6'; x.fillRect(0, 0, 512, 512);
    for (let i = 0; i < 300; i++) { x.fillStyle = `rgba(0,0,0,${r() * 0.05})`; x.beginPath(); x.arc(r() * 512, r() * 512, r() * 30, 0, 7); x.fill(); }
    noise(x, 512, 22, r);
    return { c, size: 2 };
  },
  grass: () => {
    const [c, x] = canvas(512), r = rand(13);
    x.fillStyle = '#5d8f3e'; x.fillRect(0, 0, 512, 512);
    for (let i = 0; i < 9000; i++) {
      x.strokeStyle = `hsl(${85 + r() * 30},${40 + r() * 25}%,${25 + r() * 25}%)`;
      x.lineWidth = 1;
      const px = r() * 512, py = r() * 512;
      x.beginPath(); x.moveTo(px, py); x.lineTo(px + (r() - 0.5) * 4, py - 3 - r() * 5); x.stroke();
    }
    return { c, size: 2.5 };
  },
  plaster: () => {
    const [c, x] = canvas(256), r = rand(17);
    x.fillStyle = '#ffffff'; x.fillRect(0, 0, 256, 256);
    noise(x, 256, 10, r);
    return { c, size: 1.5 };
  },
  paving: () => {
    const [c, x] = canvas(512), r = rand(21);
    x.fillStyle = '#8f8a83'; x.fillRect(0, 0, 512, 512);
    const n = 4, s = 512 / n;
    for (let i = 0; i < n; i++) for (let j = 0; j < n; j++) {
      x.fillStyle = shade('#c9c2b8', (r() - 0.5) * 0.08);
      x.fillRect(i * s + 3, j * s + 3, s - 6, s - 6);
    }
    noise(x, 512, 12, r);
    return { c, size: 1.6 };
  },
};

const cache = new Map();
/** Trả về texture lặp; UV của hình học tính theo mét nên repeat = 1/kích thước ô vân */
export function getTexture(name, anisotropy = 8) {
  if (cache.has(name)) return cache.get(name);
  const gen = generators[name] || generators.concrete;
  const { c, size } = gen();
  const t = new THREE.CanvasTexture(c);
  t.wrapS = t.wrapT = THREE.RepeatWrapping;
  t.repeat.set(1 / size, 1 / size);
  t.colorSpace = THREE.SRGBColorSpace;
  t.anisotropy = anisotropy;
  cache.set(name, t);
  return t;
}

const FLOOR_PROPS = {
  wood: { roughness: 0.45 }, oak: { roughness: 0.5 }, tile: { roughness: 0.2 }, marble: { roughness: 0.06, metalness: 0.02 },
  carpet: { roughness: 1 }, walnut: { roughness: 0.4 }, herringbone: { roughness: 0.35 }, herringboneLight: { roughness: 0.4 },
  darkTile: { roughness: 0.3 }, encaustic: { roughness: 0.45 }, polished: { roughness: 0.25, metalness: 0.02 }, concrete: { roughness: 0.85 }, terracotta: { roughness: 0.6 }, grass: { roughness: 1 },
};
const floorMats = new Map();
export function floorMaterial(name) {
  if (!floorMats.has(name)) floorMats.set(name, new THREE.MeshStandardMaterial({ map: getTexture(name), ...(FLOOR_PROPS[name] || {}) }));
  return floorMats.get(name);
}
