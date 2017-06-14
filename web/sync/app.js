var app = {
    _registrationPromise: null,
    _registration: null,
    getRegistration: function () {
        var self = this;
        if (this._registration) {
            return new Promise(function (resolve, reject) {
                resolve(self._registration);
            });
        } else {
            if (!this._registrationPromise) {
                this._registrationPromise = new Promise(function (resolve, reject) {
                    window.navigator.serviceWorker
                        .register('sw_sync.js', {scope: 'sync-scope'})
                        .then(function (registration) {
                            self._registration = registration;
                            self._registrationPromise = null;
                            resolve(registration);
                        });
                });
            }

            return this._registrationPromise
        }
    }
};

document.querySelector('.request-sync').addEventListener('click', function () {
    app.getRegistration().then(function (registration) {
        console.log('Register Sync "someTagName"');
        registration.sync.register('someTagName');
    });
});