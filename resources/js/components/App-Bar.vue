<template>
    <v-app-bar dense>
        <v-app-bar-nav-icon
            class="mx-2"
            contain
            max-height="40"
            max-width="40"
        ></v-app-bar-nav-icon>
        <router-link to="/">
            <v-app-bar-title>
                hwGO
            </v-app-bar-title>
        </router-link>
        <v-spacer></v-spacer>

        <v-col cols="1">

        </v-col>
        <v-col cols="2">
            <v-select :items="instances"
                      :value="{'id': parseInt(this.$store.state.instance.instance)}"
                      hide-details="auto"
                      item-text="name"
                      item-value="id"
                      @input="changedInstance">

            </v-select>
        </v-col>
        <div v-if="loggedIn">
            <router-link to="/servers">
                <v-btn class=" white--text"

                       elevation="0"
                >
                    Servers
                    <v-icon
                        right
                    >
                        mdi-server
                    </v-icon>
                </v-btn>
            </router-link>
        </div>
        <div v-if="!loggedIn">
            <router-link to="/login">

                <v-btn class=" white--text" elevation="0">
                    Login
                    <v-icon right>mdi-login-variant</v-icon>
                </v-btn>
            </router-link>
        </div>
        <div v-else>
            <router-link to="/logout">
                <v-btn class=" white--text" elevation="0">
                    Logout
                    <v-icon right>mdi-logout-variant</v-icon>
                </v-btn>
            </router-link>
        </div>
    </v-app-bar>
</template>
<script>
import {mapGetters} from "vuex";
import {mapActions} from "vuex";

export default {
    el: '#app',
    computed: {
        ...mapGetters([
            'instance',
            'instances',
            'loggedIn'
        ])
    },
    data() {
        return {
            authenticated: '',
        }
    },
    methods: {
        changedInstance(event) {
            this.$store.dispatch('setInstance', event);
        }
    }
}
</script>
