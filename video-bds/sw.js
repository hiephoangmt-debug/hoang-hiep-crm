/* Lưu sẵn ứng dụng để mở được khi không có mạng. Đổi VERSION mỗi lần cập nhật. */
var VERSION = 'video-bds-v7';
var FILES = [
  './', './index.html', './manifest.webmanifest', './css/styles.css',
  './js/script-gen.js', './js/audio.js', './js/timeline.js', './js/autocut.js', './js/importer.js', './js/beauty.js', './js/renderer.js', './js/demo.js', './js/webm-fix.js', './js/app.js',
  './icons/icon-192.png', './icons/icon-512.png'
];

self.addEventListener('install', function (e) {
  e.waitUntil(caches.open(VERSION).then(function (c) { return c.addAll(FILES); }).then(function () { return self.skipWaiting(); }));
});

self.addEventListener('activate', function (e) {
  e.waitUntil(caches.keys().then(function (keys) {
    return Promise.all(keys.filter(function (k) { return k !== VERSION; }).map(function (k) { return caches.delete(k); }));
  }).then(function () { return self.clients.claim(); }));
});

// Ưu tiên bản mới trên mạng, mất mạng thì dùng bản đã lưu
self.addEventListener('fetch', function (e) {
  if (e.request.method !== 'GET') return;
  e.respondWith(fetch(e.request).then(function (res) {
    if (res.ok && new URL(e.request.url).origin === location.origin) {
      var copy = res.clone();
      caches.open(VERSION).then(function (c) { c.put(e.request, copy); });
    }
    return res;
  }).catch(function () { return caches.match(e.request); }));
});
