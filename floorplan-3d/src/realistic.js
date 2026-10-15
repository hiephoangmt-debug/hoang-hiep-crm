// Chế độ "như thật": nội thất mô hình thật (glTF), ánh sáng môi trường HDRI.
import * as THREE from 'three';
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader.js';
import { EXRLoader } from 'three/examples/jsm/loaders/EXRLoader.js';
import { MeshoptDecoder } from 'three/examples/jsm/libs/meshopt_decoder.module.js';
import { CATALOG_MAP } from './furniture.js';

const BASE = import.meta.env.BASE_URL || './';
// Loại đồ → mô hình; fit: co theo 'width' (giữ tỉ lệ) hoặc 'box' (vừa khít rộng × sâu)
const MODELS = {
  sofa: { file: 'sofa.glb', fit: 'width' },
  armchair: { file: 'armchair.glb', fit: 'width' },
  chair: { file: 'chair.glb', fit: 'width' },
  plant: { file: 'plant.glb', fit: 'height', h: 1.25 },
};
const cache = new Map();
let loader = null;

function load(file) {
  if (!cache.has(file)) {
    loader ||= new GLTFLoader().setMeshoptDecoder(MeshoptDecoder);
    cache.set(file, loader.loadAsync(`${BASE}models/${file}`).then((g) => {
      const root = g.scene;
      root.traverse((o) => {
        if (o.isLight) o.visible = false;
        if (o.isMesh) { o.castShadow = true; o.receiveShadow = true; }
      });
      const box = new THREE.Box3().setFromObject(root);
      return { root, box, size: box.getSize(new THREE.Vector3()), center: box.getCenter(new THREE.Vector3()) };
    }));
  }
  return cache.get(file);
}

/** Thay nội thất khối đơn giản bằng mô hình thật (nếu có) – chạy sau khi dựng cảnh */
export async function upgradeFurniture(built, clippingPlanes = []) {
  const jobs = [];
  for (const g of built.furniture) {
    const item = g.userData.item;
    const spec = item && MODELS[item.type];
    if (!spec) continue;
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
      if (clippingPlanes.length) inst.traverse((o) => { if (o.isMesh) { o.material = o.material.clone(); o.material.clippingPlanes = clippingPlanes; } });
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
