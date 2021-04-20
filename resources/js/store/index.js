import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import {authModule} from "./authStore"
import {serverStore} from "./serverStore"

Vue.use(Vuex)
axios.defaults.baseURL = 'http://hwgo.local/api'

export const store = new Vuex.Store({
   modules: {
       auth: authModule,
       servers: serverStore,
   }
})
