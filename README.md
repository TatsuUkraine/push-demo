push_demo
=========

Install composer and run
```
composer install
```

Create DB that was set during `composer install` command (by default it's push_demo with login and pass 'root')

Run Symfony migrations
```
php bin/console doctrine:migrations:migrate
```

Install npm and run
```
npm install
```

Use grunt tasks to build bundles

List of available Grunt tasks
* webpack:push
* webpack:sw_push
* webpack:sync
* webpack:sw_sync
* webpack:fetch
* webpack:sw_fetch
* webpack:cache
* webpack:sw_cache

To use Push Notifications add your project keys from Firebase in files
* /web/push/PushService.js
* /web/push/sw.js
