
self.addEventListener('activate', function (event) {
    event.waitUntil(
        caches.keys().then(function(keyList) {
            return Promise.all(keyList.map(function(key) {
                return caches.delete(key);
            }));
        })
    );
});

self.addEventListener('message', function (event) {
    if (event.data.event === 'cacheApp') {
        caches.open('v1')
            .then(function (cache) {
                return cache.addAll([
                    '/',
                    '/cache_example',
                    '/fetch_example',
                    '/sync_example',
                    '/bundles/sync.js',
                    '/bundles/fetch.js',
                    '/bundles/cache.js'
                ]);
            })
    }
});

self.addEventListener('fetch', function(event) {
    event.respondWith(
        caches.match(event.request).then(function(response) {
            if (response) {
                console.log('Found ', event.request.url, ' in cache');
                return response;
            }
            console.log('Network request for ', event.request.url);
            return fetch(event.request).then(function(response) {

                // TODO 5 - Respond with custom 404 page

                return caches.open('v1').then(function(cache) {
                    cache.put(event.request.url, response.clone());
                    return response;
                });
            });

            // TODO 4 - Add fetched files to the cache

        }).catch(function () {
            var r=1;
        })
    );
});