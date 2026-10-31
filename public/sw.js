// Service Worker for PPDB Online PWA
const CACHE_NAME = 'ppdb-online-v1';
const OFFLINE_URL = '/offline'; // URL that serves the offline Blade view

// Assets to pre‑cache (add more URLs if needed)
const CACHE_ASSETS = [
  '/',
  '/manifest.json',
  OFFLINE_URL,
];

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => cache.addAll(CACHE_ASSETS))
  );
  self.skipWaiting();
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((keys) => {
      return Promise.all(
        keys.filter((key) => key !== CACHE_NAME).map((key) => caches.delete(key))
      );
    })
  );
  self.clients.claim();
});

self.addEventListener('fetch', (event) => {
  // For navigation requests, try network first, fallback to offline page
  if (event.request.mode === 'navigate') {
    event.respondWith(
      fetch(event.request).catch(() => caches.match(OFFLINE_URL))
    );
    return;
  }
  // For other requests, use cache‑first strategy
  event.respondWith(
    caches.match(event.request).then((cached) => cached || fetch(event.request))
  );
});

