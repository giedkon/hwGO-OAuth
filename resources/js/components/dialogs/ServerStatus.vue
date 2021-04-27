<template>
    <v-dialog
        v-model="show"
        width="1000"
    >
        <v-card v-if="server" :loading="loadingStatus">
            <v-card-title class="headline lighten-2">
                <v-col>
                    {{ server.name }}
                    <span v-if="status" class="text--primary pa-1">
                        (ONLINE)
                    </span>
                    <span v-else class="text--darken-2 pa-1">
                        (OFFLINE)
                    </span>
                </v-col>
                <v-spacer></v-spacer>
                <v-col align="right" justify="end">
                    <v-btn color="primary" @click="getServerStatus(true)">
                        Refresh
                        <v-icon>
                            mdi-refresh
                        </v-icon>
                    </v-btn>
                </v-col>
            </v-card-title>
            <v-card-text>
                <v-divider></v-divider>
            </v-card-text>
            <v-card-text>
                <v-row dense>
                    <v-col>
                        IP
                    </v-col>
                    <v-col>
                        {{ server.server_ip }}:{{ server.server_port }}
                        <span v-if="status">
                            <span v-if="status.client_password">
                                <CopyToClipBoardButton :icon="'mdi-connection'"
                                                       :label="''"
                                                       v-bind:text="'connect ' + server.server_ip + ':' + server.server_port + '; password ' + status.client_password + ';'"></CopyToClipBoardButton>
                            </span>

                            <span v-else>
                                <CopyToClipBoardButton :icon="'mdi-connection'"
                                                       :label="''"
                                                       v-bind:text="'connect ' + server.server_ip + ':' + server.server_port"></CopyToClipBoardButton>
                            </span>
                        </span>

                    </v-col>
                </v-row>
                <v-row v-if="server.gotv_port" dense>
                    <v-col>
                        GOTV
                    </v-col>
                    <v-col>
                        {{ server.server_ip }}:{{ server.gotv_port }}
                        <span v-if="status">
                            <span v-if="status.gotv_password">
                                <CopyToClipBoardButton :icon="'mdi-connection'"
                                                       :label="''"
                                                       v-bind:text="'connect ' + server.server_ip + ':' + server.server_port + '; password ' + status.gotv_password + ';'"></CopyToClipBoardButton>
                            </span>

                            <span v-else>
                                <CopyToClipBoardButton :icon="'mdi-connection'"
                                                       :label="''"
                                                       v-bind:text="'connect ' + server.server_ip + ':' + server.server_port"></CopyToClipBoardButton>
                            </span>
                        </span>
                    </v-col>
                </v-row>
                <v-row dense>
                    <v-col>
                        RCON Password
                    </v-col>
                    <v-col>
                        {{ server.password }}
                    </v-col>
                </v-row>
                <v-row v-if="status && status.client_password" dense>
                    <v-col>
                        Client Password
                    </v-col>
                    <v-col>
                        {{ status.client_password }}
                    </v-col>
                </v-row>
                <v-row v-if="status && status.gotv_password" dense>
                    <v-col>
                        GOTV Password
                    </v-col>
                    <v-col>
                        {{ status.gotv_password }}
                    </v-col>
                </v-row>
            </v-card-text>

            <v-card-text>
                <v-divider></v-divider>
            </v-card-text>

            <v-card-text v-if="status && status.statusFormatted">
                <v-row dense>
                    <v-col>
                        Host name:
                    </v-col>
                    <v-col>
                        {{ status.hostname }}
                    </v-col>
                </v-row>
                <v-row dense>
                    <v-col>
                        Map
                    </v-col>
                    <v-col>
                        {{ status.map }}
                    </v-col>
                </v-row>
                <v-row v-if="status.gotv" dense>
                    <v-col>
                        GOTV
                    </v-col>
                    <v-col>
                        {{ status.gotv.bot.status }} (Tickrate: {{ status.gotv.bot.tickrate }})
                    </v-col>
                </v-row>
                <v-row v-if="status" dense>
                    <v-col>
                        Bots
                    </v-col>
                    <v-col>
                        {{ status.botAmount }}
                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-text>
                <v-divider></v-divider>
            </v-card-text>
            <v-card-text v-if="status">
                <v-data-table v-if="status.players" :headers="playerHeaders" :items="status.players" class="mt-6" light>
                    <template v-slot:item.steamid="{item}">
                        {{ item.steamid }}
                        <v-btn color="primary" fab v-bind:href="'https://steamid.io/lookup/'+item.steamid" x-small>
                            <v-icon>
                                mdi-steam
                            </v-icon>
                        </v-btn>
                    </template>
                </v-data-table>
            </v-card-text>
            <v-card-text>
                <v-alert v-if="errors" type="error">
                    {{ errors }}
                </v-alert>
            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>

import {errorHandler} from "../../helpers/error_to_alert";
import CopyToClipBoardButton from "../utility/CopyToClipBoardButton";

export default {
    name: "ServerStatus",
    components: {CopyToClipBoardButton},
    props: {
        value: Boolean,
        server: null,
    },
    watch: {
        server: function () {
            this.getServerStatus(true);
        },
        deep: true,
    },
    data() {
        return {
            dialog: false,
            status: null,
            errors: "",
            loadingStatus: true,
            playerHeaders: [
                {text: "#ID", align: "center", value: "id", sortable: true,},
                {text: "Name", value: "name", sortable: true},
                {text: "Steam ID", value: "steamid", sortable: true},
                {text: "Time In Server", value: "timeInServer", sortable: false},
                {text: "Ping", value: "ping", sortable: false},
                {text: "Loss", value: "loss", sortable: false},
                {text: "IP", value: "ip", sortable: false},
            ]
        }
    },
    computed: {
        show: {
            get() {
                return this.value
            },
            set(value) {
                this.$emit('input', value)
            }
        }
    },
    methods: {
        getServerStatus(formatted) {
            this.loadingStatus = true;
            this.errors = '';
            this.status = null;
            axios.post('server/ping', {
                address: this.server.server_ip,
                port: this.server.server_port,
                password: this.server.password,
                formatted: formatted,
            }).then(response => {
                this.loadingStatus = false;
                this.status = response.data;
                this.errors = null;
            }).catch(error => {
                this.loadingStatus = false;
                this.status = null;
                this.errors = errorHandler.alertError(error);
            })
        }
    }
}
</script>
