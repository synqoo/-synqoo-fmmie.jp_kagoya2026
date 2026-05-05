// sw.js

const CACHE_NAME = "my-app-cache-v1";
const URLS_TO_CACHE = [
  "/",                    // ルート
  "/blank.html",          // このページのパス
  "/_include/css/_blanks.css"
  // 必要に応じて、画像や追加のJSもここに列挙
];

self.addEventListener("install", (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      return cache.addAll(URLS_TO_CACHE);
    })
  );
});

// 古いキャッシュの整理
self.addEventListener("activate", (event) => {
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames
          .filter((name) => name !== CACHE_NAME)
          .map((name) => caches.delete(name))
      );
    })
  );
});

// キャッシュ優先のフェッチ戦略（簡易版）
self.addEventListener("fetch", (event) => {
  event.respondWith(
    caches.match(event.request).then((response) => {
      // キャッシュにあればそれを返し、なければネットワークへ
      return response || fetch(event.request);
    })
  );
});
