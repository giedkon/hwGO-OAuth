window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.CancelToken = axios.CancelToken
window.axios.isCancel = axios.isCancel

/*
 * The interceptor here ensures that we check for the token in local storage every time an ajax request is made
 */
window.axios.interceptors.request.use(
    (config) => {
        let token = localStorage.getItem('access_token')

        if (token) {
            config.headers['Authorization'] = `Bearer ${ token }`
        }

        return config
    },

    (error) => {
        return Promise.reject(error)
    }
)

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
