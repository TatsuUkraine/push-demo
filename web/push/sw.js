'use strict';
var firebase = require('firebase/app');
require('firebase/messaging');
var NotificationService = require('./NotificationService');

firebase.initializeApp({
    'messagingSenderId': ''
});

var messaging = firebase.messaging();
var pendingActions = [];

self.addEventListener('message', function(event) {
    if (event.data.event === 'actionBind' && (event.source instanceof WindowClient) && pendingActions.length) {
        for (var i = 0, length = pendingActions.length; i < length; i++) {
            event.source.postMessage(pendingActions[i]);
        }
        pendingActions = [];
    }
});

self.addEventListener('notificationclick', function (event) {
    event.notification.close();

    event.waitUntil(
        self.clients.matchAll({includeUncontrolled: true, type: 'window'})
            .then(function(clientList) {

                for (var i = 0; i < clientList.length; i++) {
                    var client = clientList[i];

                    if ('focus' in client) {
                        return client.focus().then(function (windowClient) {
                            var params = {
                                action: event.action || 'click',
                                data: event.notification.data
                            };
                            windowClient.postMessage(params);
                        });
                    }
                }
                if (clients.openWindow) {
                    pendingActions.push({
                        action: event.action || 'click',
                        data: event.notification.data
                    });

                    return clients.openWindow('/push_notification');
                }
            })
    );
});

messaging.setBackgroundMessageHandler(function(notification) {
    return NotificationService.showNotification(self.registration, notification.data);
});
