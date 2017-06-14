module.exports = {
    showNotification: function (registration, options) {
        var title = options.title;

        var params = {};
        for (var key in options) {
            if (key !== 'title') {
                switch (key) {
                    case 'actions':
                        params[key] = JSON.parse(options[key]);
                        break;
                    default:
                        params[key] = options[key];
                        break;
                }
            }
        }

        return registration.showNotification(title, params);
    }
};