// Chế độ "như thật": nội thất mô hình thật (glTF), ánh sáng môi trường HDRI.
import * as THREE from 'three';
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader.js';
import { EXRLoader } from 'three/examples/jsm/loaders/EXRLoader.js';
import { MeshoptDecoder } from 'three/examples/jsm/libs/meshopt_decoder.module.js';
import { CATALOG_MAP } from './furniture.js';

const BASE = import.meta.env.BASE_URL || './';
// Loại đồ → mô hình; fit: co theo 'width' (giữ tỉ lệ) hoặc 'box' (vừa khít rộng × sâu)
const MODELS = {
  // sofa: dùng sofa văng thẳng dựng sẵn (mô hình sofa cong chiếm nhiều diện tích, không hợp căn hộ)
  armchair: { file: 'armchair.glb', fit: 'width', tint: 'fabric2' },
  chair: { file: 'chair.glb', fit: 'width', tint: 'fabric' },
  // plant: dùng bồn cây vuông dựng sẵn (mô hình chậu đất nung tròn không hợp phong cách)
};
const cache = new Map();
let loader = null;

/** Mô hình nén (KHR_mesh_quantization / meshopt) lưu toạ độ dạng số nguyên chuẩn hoá – bộ render như thật
 *  không giải được và vẽ thành mảng khổng lồ che cả căn → đổi sang số thực */
function dequantize(geo) {
  for (const name of Object.keys(geo.attributes)) {
    const a = geo.attributes[name];
    if (!a.normalized && !a.isInterleavedBufferAttribute && a.array instanceof Float32Array) continue;
    const n = a.itemSize, out = new Float32Array(a.count * n);
    const get = [a.getX, a.getY, a.getZ, a.getW];
    for (let i = 0; i < a.count; i++) for (let c = 0; c < n; c++) out[i * n + c] = get[c].call(a, i);
    geo.setAttribute(name, new THREE.BufferAttribute(out, n));
  }
}

function load(file) {
  if (!cache.has(file)) {
    loader ||= new GLTFLoader().setMeshoptDecoder(MeshoptDecoder);
    cache.set(file, loader.loadAsync(`${BASE}models/${file}`).then((g) => {
      const root = g.scene;
      root.traverse((o) => {
        if (o.isLight) o.visible = false;
        if (o.isMesh) { o.castShadow = true; o.receiveShadow = true; dequantize(o.geometry); }
      });
      const box = new THREE.Box3().setFromObject(root);
      return { root, box, size: box.getSize(new THREE.Vector3()), center: box.getCenter(new THREE.Vector3()) };
    }));
  }
  return cache.get(file);
}

/** Thay nội thất khối đơn giản bằng mô hình thật (nếu có) – chạy sau khi dựng cảnh */
export async function upgradeFurniture(built, clippingPlanes = [], palette = null) {
  const jobs = [];
  for (const g of built.furniture) {
    const item = g.userData.item;
    const spec = item && MODELS[item.type];
    if (!spec) continue;
    if (palette?.walnut && item.type === 'armchair') continue; // kiểu gỗ óc chó: giữ ghế bành khung gỗ cong dựng sẵn
    jobs.push(load(spec.file).then((m) => {
      if (!g.parent) return; // cảnh đã dựng lại
      const def = CATALOG_MAP[item.type];
      const w = item.w ?? def.w, d = item.d ?? def.d;
      const inst = m.root.clone(true);
      let s;
      if (spec.fit === 'height') s = (item.h ?? spec.h) / m.size.y;
      else s = Math.min(w / m.size.x, (d * 1.15) / m.size.z);
      inst.scale.setScalar(s);
      inst.position.set(-m.center.x * s, -m.box.min.y * s, -m.center.z * s);
      const tint = spec.tint && (item.color || palette?.[spec.tint]);
      inst.traverse((o) => {
        if (!o.isMesh || (!clippingPlanes.length && !tint)) return;
        o.material = o.material.clone();
        if (clippingPlanes.length) o.material.clippingPlanes = clippingPlanes;
        // Vải bọc theo bảng màu phong cách (sofa xám, ghế bành xanh…)
        if (tint && /fabric/i.test(o.material.name)) { o.material.color.set(tint); o.material.map = null; o.material.needsUpdate = true; }
      });
      // Ẩn khối đơn giản, giữ đèn (nếu có)
      g.children.forEach((c) => { if (!c.isLight) c.visible = false; });
      inst.userData.realModel = true;
      inst.traverse((o) => { if (o.isMesh) o.userData.furnitureId = item.id; });
      g.add(inst);
    }).catch((err) => console.warn('Không tải được mô hình', spec.file, err)));
  }
  await Promise.all(jobs);
}

let hdrPromise = null;
/** HDRI phòng khách (apartment) làm ánh sáng môi trường – phản chiếu tự nhiên trên sàn, kính, kim loại */
export function loadInteriorHDRI(renderer) {
  hdrPromise ||= import('@pmndrs/assets/hdri/apartment.exr.js').then(({ default: url }) => new EXRLoader().loadAsync(url)).then((tex) => {
    tex.mapping = THREE.EquirectangularReflectionMapping;
    const pm = new THREE.PMREMGenerator(renderer);
    const env = pm.fromEquirectangular(tex).texture;
    pm.dispose();
    return { env, equirect: tex };
  });
  return hdrPromise;
}
