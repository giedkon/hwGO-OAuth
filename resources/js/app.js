require('./bootstrap');

import Vue from 'vue'
import { router } from './router'
import App from './components/App'
import { vuetify } from "./plugins/vuetify";
import { store } from "./store";



window.eventBus = new Vue()

Vue.config.productionTip = false

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!store.getters.loggedIn) {
            next({
                name: 'login',
            })
        } else {
            next()
        }
    } else if (to.matched.some(record => record.meta.requiresVisitor)) {
        if (store.getters.loggedIn) {
            next({
                name: '/',
            })
        } else {
            next()
        }
    } else {
        next()
    }
})

new Vue({
    el: '#app',
    router,
    vuetify,
    store,
    components: { App },
})
