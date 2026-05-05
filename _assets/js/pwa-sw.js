/* Minimal Service Worker for PWA installability */
self.addEventListener('install', () => {
  self.skipWaiting();
});

self.addEventListener('activate', (event) => {
  event.waitUntil(self.clients.claim());
});

// Pass-through fetch (no caching yet)
self.addEventListener('fetch', () => {});

