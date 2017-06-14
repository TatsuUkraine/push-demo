var $ = require('jquery');
var PushService = require('./PushService');
var settingsModel = null;

PushService.getRegistration()
    .then(function () {
        document.querySelector('[name=subscribe]').checked = true;
        PushService.initialize().then(function (registration) {
            registration.active.postMessage({event: 'actionBind'});
        });
    })
    .catch(function () {
        document.querySelector('[name=subscribe]').checked = false;
    });


document.querySelector('[name=subscribe]').addEventListener('change', function (e) {
    var checked = e.target.checked;

    if (checked) {
        PushService.initialize().then(function (registration) {
            PushService.getToken().then(function (token) {
                $.ajax({
                    method: 'post',
                    url: '/api/settings',
                    data: {
                        token: token
                    },
                    success: function (response) {
                        settingsModel = response;
                    }
                });
            });
        }).catch(function (e) {
            console.log(e);
        });
    } else {
        PushService.unregister().then(function () {
            $.ajax({
                method: 'delete',
                url: '/api/settings/' + settingsModel.id,
                success: function (response) {
                    settingsModel = null;
                }
            });
        });
    }
});

document.querySelector('.send-push').addEventListener('click', function () {
    $.ajax({
        url: '/api/push/' + settingsModel.id,
        method: 'get',
        success: function (response) {
            console.log(response);
        }
    });
});

window.navigator.serviceWorker.addEventListener('message', function (event) {
    if (event.data.action) {
        alert(event.data.action);
    }
});