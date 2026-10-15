import { defineConfig } from 'vite';

export default defineConfig({
  base: './',
  resolve: { dedupe: ['three'] },
  optimizeDeps: { exclude: ['three-gpu-pathtracer', 'three-mesh-bvh'] },
  build: {
    chunkSizeWarningLimit: 1600,
    rollupOptions: { input: { main: 'index.html', toaNha: 'toa-nha.html' } },
  },
});
