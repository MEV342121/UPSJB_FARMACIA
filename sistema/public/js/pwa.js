// Registra el Service Worker (solo funciona en localhost o con HTTPS)
if ('serviceWorker' in navigator) {
  window.addEventListener('load', () => {
    navigator.serviceWorker.register('/sw.js').catch((err) => console.error('SW no registrado:', err));
  });
}
