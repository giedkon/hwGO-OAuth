<template>
    <v-toolbar>
        <v-app-bar-nav-icon></v-app-bar-nav-icon>
        <v-toolbar-title>hwGO</v-toolbar-title>
        <v-spacer></v-spacer>
        <div v-if="loggedIn">
            <router-link to="/servers">
                <v-btn elevation="0"

                    class=" white--text"
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

                <v-btn elevation="0" class=" white--text">
                    Login
                    <v-icon right>mdi-login-variant</v-icon>
                </v-btn>
            </router-link>
        </div>
        <div v-else>
            <router-link to="/logout">
                <v-btn elevation="0" class=" white--text">
                    Logout
                    <v-icon right>mdi-logout-variant</v-icon>
                </v-btn>
            </router-link>
        </div>
    </v-toolbar>
</template>
<script>
import {mapGetters} from "vuex";
import {mapActions} from "vuex";

export default {
    el: '#app',
    computed: {
        loggedIn() {
            return this.$store.getters.loggedIn
        }
    },
    data() {
        return {
            authenticated: '',
        }
    },
}
</script>
