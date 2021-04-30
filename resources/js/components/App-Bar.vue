<template>
    <v-app-bar>
        <router-link to="/">
            <v-app-bar-title v-if="currentInstance">
                    <v-img max-height="64" max-width="64" :src="currentInstance.image"></v-img>
            </v-app-bar-title>
        </router-link>
        <router-link to="/">
        <div class="pa-6">
            hwGO <span v-if="currentInstance">// {{currentInstance.name}}</span>
        </div>
        </router-link>
        <v-spacer></v-spacer>


        <div v-if="loggedIn" v-show="$vuetify.breakpoint.mdAndUp">
            <router-link to="/teams">
                <v-btn elevation="0"
                >
                    Teams
                    <v-icon
                        right
                    >
                        mdi-account-group
                    </v-icon>
                </v-btn>
            </router-link>
        </div>
        <div v-if="loggedIn" v-show="$vuetify.breakpoint.mdAndUp">
            <router-link to="/servers">
                <v-btn elevation="0"
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

        <div v-if="!loggedIn" v-show="$vuetify.breakpoint.mdAndUp">
            <router-link to="/login">
                <v-btn small elevation="0">
                    Login
                    <v-icon right>mdi-login-variant</v-icon>
                </v-btn>
            </router-link>
        </div>
        <div v-else v-show="$vuetify.breakpoint.mdAndUp">
            <router-link to="/logout">
                <v-btn  elevation="0">
                    Logout
                    <v-icon right>mdi-logout-variant</v-icon>
                </v-btn>
            </router-link>
        </div>
        <v-menu min-width="200">
            <template v-slot:activator="{ on, attrs }">
                <v-btn  v-show="$vuetify.breakpoint.smAndDown"
                    v-bind="attrs"
                    v-on="on"
                    dark
                    icon
                >
                    <v-icon>mdi-dots-vertical</v-icon>
                </v-btn>
            </template>

            <v-list>
                <router-link v-if="loggedIn" to="/teams">
                    <v-list-item link>
                        <v-list-item-content>
                            Teams
                        </v-list-item-content>
                        <v-list-item-icon>
                            <v-icon>mdi-account-group</v-icon>
                        </v-list-item-icon>
                    </v-list-item>
                </router-link>
                <v-divider></v-divider>
                <router-link v-if="loggedIn" to="/servers">
                    <v-list-item link>
                        <v-list-item-content>
                            Servers
                        </v-list-item-content>
                        <v-list-item-icon>
                            <v-icon>mdi-server</v-icon>
                        </v-list-item-icon>
                    </v-list-item>
                </router-link>
                <v-divider></v-divider>
                <router-link v-if="loggedIn" to="/logout">
                    <v-list-item link>
                        <v-list-item-content>
                            Logout
                        </v-list-item-content>
                        <v-list-item-icon>
                            <v-icon>mdi-logout-variant</v-icon>
                        </v-list-item-icon>
                    </v-list-item>
                </router-link>
                <router-link v-else to="/login">
                    <v-list-item link>
                        <v-list-item-title>
                            <v-list-item-content>
                                Login
                            </v-list-item-content>
                            <v-list-item-icon>
                                <v-icon>mdi-login-variant</v-icon>
                            </v-list-item-icon>
                        </v-list-item-title>
                    </v-list-item>
                </router-link>
            </v-list>
        </v-menu>
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
            'currentInstance',
            'loggedIn'
        ])
    },
    data() {
        return {
            authenticated: '',
        }
    },
}
</script>
