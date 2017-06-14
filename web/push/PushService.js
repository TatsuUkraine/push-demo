var firebase = require('firebase');
var NotificationService = require('./NotificationService');
var PushService = function PushService () {
    var config = {
        apiKey: "",
        projectId: "",
        messagingSenderId: ""
    };
    firebase.initializeApp(config);
    this._messaging = firebase.messaging();
    this.bindOnMessage();
    this.bindOnAction();
};

PushService.prototype._registration = null;
PushService.prototype._messaging = null;
PushService.prototype.requestPermission = function () {
    var self = this;
    return new Promise(function (resolve, reject) {
        switch (window.Notification.permission) {
            case 'granted':
                resolve();
                break;
            case 'denied':
                reject({
                    message: 'Permission denied'
                });
                break;
            default:
                self._messaging.requestPermission().then(resolve, reject);
                break;
        }
    });
};
PushService.prototype.initialize = function () {
    var self = this;
    return new Promise(function (resolve, reject) {
        self.requestPermission()
            .then(function () {
                window.navigator.serviceWorker
                    .register('sw_push.js', {scope: 'firebase-cloud-messaging-push-scope'})
                    .then(function (registration) {
                        self._registration = registration;
                        self._messaging.useServiceWorker(registration);
                        resolve(registration);
                    });
            })
            .catch(reject);
    });
};

PushService.prototype.getRegistration = function () {
    var self = this;
    return new Promise(function (resolve, reject) {
        if (self._registration) {
            resolve(self._registration);
        } else {
            window.navigator.serviceWorker
                .getRegistration('firebase-cloud-messaging-push-scope')
                .then(function (registration) {
                    if (registration) {
                        resolve(registration);
                    } else {
                        reject();
                    }
                });
        }
    });
};

PushService.prototype.unregisterSW = function (registration) {
    registration.unregister();

    //very dirty hook, don't use it please, please don't
    this._messaging.registrationToUse_ = undefined;
};
PushService.prototype.unregister = function () {
    var self = this;
    return new Promise(function (resolve, reject) {
        self.getRegistration().then(function (registration) {
            self._messaging.getToken().then(function (token) {
                if (token) {
                    self._messaging.deleteToken(token).then(function () {
                        self.unregisterSW(registration);
                        resolve();
                    });
                } else {
                    self.unregisterSW(registration);
                    resolve();
                }
            });
        }).catch(function () {
            console.log('Nothing to unregister');
            resolve();
        });
    });
};

PushService.prototype.getToken = function () {
    return this._messaging.getToken();
};

PushService.prototype.bindOnAction = function () {

};

PushService.prototype.bindOnMessage = function () {
    var self = this;
    this._messaging.onMessage(function (notification) {
        self.getRegistration().then(function (registration) {
            NotificationService.showNotification(registration, notification.data);
        });
    });
};

module.exports = new PushService();
