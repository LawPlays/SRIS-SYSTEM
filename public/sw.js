const CACHE = "sris-cache-v1";
const urlsToCache = ["/","/register","/css/app.css","/js/app.js"];

self.addEventListener("install", (evt) => {
  evt.waitUntil(caches.open(CACHE).then(cache=>cache.addAll(urlsToCache)));
  self.skipWaiting();
});

self.addEventListener("fetch", (evt) => {
  evt.respondWith(caches.match(evt.request).then(resp => resp || fetch(evt.request)));
});
