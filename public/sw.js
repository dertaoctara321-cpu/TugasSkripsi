const CACHE_NAME = 'qrwebcafe-pwa-v2';
const urlsToCache = [
    '/',
    '/images/logo.jpeg'
];

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                // Try caching non-critical assets
                return cache.addAll(urlsToCache).catch(err => console.log('Cache addAll failed', err));
            })
    );
});

self.addEventListener('fetch', event => {
    const url = new URL(event.request.url);

    // Always go to network for admin pages, POST requests, and dynamic routes
    // Only cache truly static assets (CSS, JS, images, fonts)
    const isStaticAsset = /\.(css|js|png|jpg|jpeg|gif|svg|ico|woff|woff2|ttf)$/.test(url.pathname);
    const isAdminRoute  = url.pathname.startsWith('/admin');
    const isAuthRoute   = url.pathname.startsWith('/login') || url.pathname.startsWith('/logout');
    const isOrderRoute  = url.pathname.startsWith('/order');
    const isPostRequest = event.request.method !== 'GET';

    // Network-only: admin pages, auth pages, order pages, non-GET
    if (isAdminRoute || isAuthRoute || isOrderRoute || isPostRequest) {
        event.respondWith(fetch(event.request).catch(() => {}));
        return;
    }

    // Cache-first only for static assets
    if (isStaticAsset) {
        event.respondWith(
            caches.match(event.request).then(response => {
                return response || fetch(event.request).then(fetchResponse => {
                    if (!fetchResponse || fetchResponse.status !== 200 || fetchResponse.type !== 'basic') {
                        return fetchResponse;
                    }
                    const responseToCache = fetchResponse.clone();
                    caches.open(CACHE_NAME).then(cache => cache.put(event.request, responseToCache));
                    return fetchResponse;
                });
            })
        );
        return;
    }

    // Everything else: network-first (no caching)
    event.respondWith(fetch(event.request).catch(() => {}));
});

self.addEventListener('activate', event => {
    const cacheAllowlist = [CACHE_NAME];
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cacheName => {
                    if (cacheAllowlist.indexOf(cacheName) === -1) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});
