<template>
    <v-toolbar>
        <v-img
            class="mx-2"
            contain
            max-height="40"
            max-width="40"
            src="storage/logo.svg"
        ></v-img>
        <v-spacer></v-spacer>
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
