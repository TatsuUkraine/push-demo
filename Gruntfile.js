module.exports = function (grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        webpack: {
            options: {
                watch: true,
                keepalive: true,
                cache: true
            },
            push: {
                context: __dirname + '/web/push',
                entry: './app.js',
                output: {
                    path: __dirname + '/web/bundles',
                    filename: 'push.js'
                }
            },
            sw_push: {
                context: __dirname + '/web/push',
                entry: './sw.js',
                output: {
                    path: __dirname + '/web',
                    filename: 'sw_push.js'
                }
            },


            sync: {
                context: __dirname + '/web/sync',
                entry: './app.js',
                output: {
                    path: __dirname + '/web/bundles',
                    filename: 'sync.js'
                }
            },
            sw_sync: {
                context: __dirname + '/web/sync',
                entry: './sw.js',
                output: {
                    path: __dirname + '/web',
                    filename: 'sw_sync.js'
                }
            },


            fetch: {
                context: __dirname + '/web/fetch',
                entry: './app.js',
                output: {
                    path: __dirname + '/web/bundles',
                    filename: 'fetch.js'
                }
            },
            sw_fetch: {
                context: __dirname + '/web/fetch',
                entry: './sw.js',
                output: {
                    path: __dirname + '/web',
                    filename: 'sw_fetch.js'
                }
            },


            cache: {
                context: __dirname + '/web/cache',
                entry: './app.js',
                output: {
                    path: __dirname + '/web/bundles',
                    filename: 'cache.js'
                }
            },
            sw_cache: {
                context: __dirname + '/web/cache',
                entry: './sw.js',
                output: {
                    path: __dirname + '/web',
                    filename: 'sw_cache.js'
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-webpack');

};