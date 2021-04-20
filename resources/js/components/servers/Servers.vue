<template>
    <v-container>

        <v-row class="pa-6">
            <v-col lg="9" md="6">

            </v-col>
            <v-col align="right" class="pa-0" justify="end">
                <v-btn
                    color="primary"
                    elevation="2"
                    large
                >
                    Add new server
                    <v-icon dark>
                        mdi-plus-network
                    </v-icon>
                </v-btn>

            </v-col>
        </v-row>

        <v-data-table :headers="headers" :items="allServers.servers" class="elevation-2 pt-4" disable-filtering
                      light>

            <template v-slot:item.actions="{item}">
                <v-btn
                    color="primary"
                    elevation="0"
                    small
                    @click.stop="showStatusDialog=true; selected=item"
                >
                    Status
                    <v-icon dark>
                        mdi-delete-alert-outline
                    </v-icon>
                </v-btn>
                <v-btn
                    color="primary"
                    elevation="0"
                    small
                    @click.stop="removeServer(item)"
                >
                    Delete
                    <v-icon dark>
                        mdi-delete-alert-outline
                    </v-icon>
                </v-btn>
            </template>
        </v-data-table>
        <server-status v-bind:server="selected" v-model="showStatusDialog"></server-status>
    </v-container>
</template>

<script>
import {errorHandler} from "../../helpers/error_to_alert";
import ServerStatus from "../dialogs/ServerStatus";

export default {
    name: "Servers.vue",
    components: {ServerStatus},
    computed: {
        allServers() {
            return this.$store.state.servers
        }
    },
    data() {
        return {
            showStatusDialog: false,
            error: "",
            selected: null,
            headers: [
                {text: "Server Name", align: "start", value: "name", sortable: true,},
                {text: "Server IP", value: "server_ip", sortable: true},
                {text: "Server Port", value: "server_port", sortable: true},
                {text: "RCON PASSWORD", value: "password", sortable: false},
                {text: "Actions", align: "center", value: "actions", sortable: false},
            ],
        }
    },
    methods: {
        fetchServers() {
            this.$store.dispatch('fetchServers', {}).then(response => {
            }).catch(error => {
                console.log(error);
                this.error = errorHandler.alertError(error);
            });
        },
        removeServer(item) {
            let r = confirm("Are you sure?")
            if (r) {
                this.$store.dispatch('removeServer', {server: item}).then(response => {
                }).catch(error => {
                    console.log(error);
                    this.error = errorHandler.alertError(error);
                });
            }
        },
    },
    created() {
        this.fetchServers();
    }
}
</script>

<style scoped>

</style>
