import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import {authModule} from "./authStore"
import {serverModule} from "./serverStore"
import {instanceModule} from "./instanceStore"
import {teamModule} from "./teamStore"

Vue.use(Vuex)
axios.defaults.baseURL = 'http://hwgo.local/api'

export const store = new Vuex.Store({
   modules: {
       auth: authModule,
       instance: instanceModule,
       servers: serverModule,
       teams: teamModule
   }
})
