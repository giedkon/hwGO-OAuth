import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify)

const opts = {
    theme: {
        dark: true,
        themes: {
            dark: {
                primary: '#f1741d',
                secondary: '#b0bec5',
                accent: '#8c9eff',
                error: '#730000',
            },
        },
    },
}

export const vuetify = new Vuetify(opts)


