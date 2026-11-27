// Service Worker de FARM SJB (PWA)
// - Archivos estáticos (css, js, iconos): primero caché, para que carguen rápido y sin internet.
// - Páginas del sistema: SIEMPRE desde el servidor (llevan datos y sesión; no se guardan en caché).
//   Si no hay internet, se muestra /offline.html.
const VERSION = 'farm-sjb-v1';
const PRECACHE = [
  '/offline.html',
  '/css/bootstrap.css',
  '/css/custom.css',
  '/js/bootstrap.bundle.min.js',
  '/js/app.js',
  '/js/chart.umd.min.js',
  '/icons/icon-192.png',
];

self.addEventListener('install', (event) => {
  event.waitUntil(caches.open(VERSION).then((cache) => cache.addAll(PRECACHE)));
  self.skipWaiting();
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((keys) =>
      Promise.all(keys.filter((k) => k !== VERSION).map((k) => caches.delete(k)))
    )
  );
  self.clients.claim();
});

self.addEventListener('fetch', (event) => {
  const req = event.request;
  if (req.method !== 'GET') return; // POST (login, ventas...) siempre va al servidor

  const url = new URL(req.url);
  if (url.origin !== location.origin) return;

  // Páginas: red primero; sin conexión, página offline
  if (req.mode === 'navigate') {
    event.respondWith(fetch(req).catch(() => caches.match('/offline.html')));
    return;
  }

  // Estáticos: caché primero y se actualiza en segundo plano
  if (/^\/(css|js|icons)\//.test(url.pathname)) {
    event.respondWith(
      caches.match(req).then((cached) => {
        const network = fetch(req).then((res) => {
          if (res.ok) caches.open(VERSION).then((c) => c.put(req, res.clone()));
          return res;
        }).catch(() => cached);
        return cached || network;
      })
    );
  }
});
