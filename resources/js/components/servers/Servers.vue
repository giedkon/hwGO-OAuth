<template>
    <v-container>
        <v-card elevation="4" outlined :loading="loadingServers">
            <v-card-title>
                srcds Server Management
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
            <v-row class="py-6 px-3">
                <v-col lg="9" md="6">

                </v-col>
                <v-col align="right" class="pa-0" justify="end">
                    <v-btn
                        color="primary"
                        elevation="2"
                        large
                        @click.stop="showFormDialog=true; selected=null"
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
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                                v-bind="attrs"
                                v-on="on"
                                color="primary"
                                elevation="0"
                                fab
                                x-small
                                @click.stop="showStatusDialog=true; selected=item"
                            >
                                <v-icon dark small>
                                    mdi-information-outline
                                </v-icon>
                            </v-btn>
                        </template>
                        <span>Server Status</span>
                    </v-tooltip>
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                                v-bind="attrs"
                                v-on="on"
                                color="primary"
                                elevation="0"
                                fab
                                x-small
                                @click.stop="showFormDialog=true; selected=item"
                            >
                                <v-icon dark small>
                                    mdi-network-outline
                                </v-icon>
                            </v-btn>
                        </template>
                        <span>Edit Server</span>
                    </v-tooltip>
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                                v-bind="attrs"
                                v-on="on"
                                color="error"
                                elevation="0"
                                fab
                                x-small
                                @click.stop="removeServer(item)"
                            >
                                <v-icon dark small>
                                    mdi-minus-network
                                </v-icon>
                            </v-btn>
                        </template>
                        <span>Remove Server</span>
                    </v-tooltip>
                </template>
            </v-data-table>
            <server-status v-model="showStatusDialog" v-bind:server="selected"></server-status>
            <server-form v-model="showFormDialog" v-bind:server="selected"></server-form>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script>
import {errorHandler} from "../../helpers/error_to_alert";
import ServerStatus from "../dialogs/ServerStatus";
import CopyToClipBoardButton from "../utility/CopyToClipBoardButton";
import ServerForm from "../dialogs/ServerForm";

export default {
    name: "Servers.vue",
    components: {ServerForm, CopyToClipBoardButton, ServerStatus},
    computed: {
        allServers() {
            return this.$store.state.servers
        }
    },
    data() {
        return {
            showStatusDialog: false,
            showFormDialog: false,
            error: "",
            selected: null,
            loadingServers: true,
            headers: [
                {text: "Server Name", align: "start", value: "name", sortable: true},
                {text: "Server IP", value: "server_ip", sortable: true},
                {text: "Server Port", value: "server_port", sortable: true},
                {text: "RCON PASSWORD", value: "password", sortable: false},
                {text: "Actions", align: "center", value: "actions", sortable: false},
            ],
        }
    },
    methods: {
        fetchServers() {
            this.loadingServers = true;
            this.$store.dispatch('fetchServers', {}).then(response => {
                this.loadingServers = false;
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
