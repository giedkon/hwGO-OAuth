import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify)

const opts = {
    theme: {
        dark: true,
        themes: {
            dark: {
                primary: '#C03221',
                secondary: '#b0bec5',
                accent: '#8c9eff',
                error: '#FFC53A',
            },
        },
    },
}

export const vuetify = new Vuetify(opts)


