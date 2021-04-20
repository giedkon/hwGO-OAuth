<template>
    <v-dialog
        v-model="show"
        width="1000"
    >
        <v-card v-if="server">
            <v-card-title class="headline lighten-2">
                <v-col>
                    {{ server.name }}
                </v-col>
                <v-spacer></v-spacer>
                <v-col align="right" justify="end">
                    <v-btn @click="getServerStatus()" color="primary">
                        Refresh
                        <v-icon>
                            mdi-refresh
                        </v-icon>
                    </v-btn>
                </v-col>
            </v-card-title>
            <v-card-text v-if="status">
                <v-row dense>
                    <v-col>
                        Host name
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
                        Map: {{ status.map }}
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
                <v-data-table v-if="status.players" :headers="playerHeaders" :items="status.players" class="mt-6" light>
                    <template v-slot:item.steamid="{item}">
                        {{item.steamid}}
                        <v-btn v-bind:href="'https://steamid.io/lookup/'+item.steamid" fab x-small color="primary">
                            <v-icon>
                                mdi-steam
                            </v-icon>
                        </v-btn>
                    </template>
                </v-data-table>
            </v-card-text>
            <v-card-text>
                <v-alert v-if="errors" type="error">
                    {{errors}}
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

export default {
    name: "ServerStatus",
    props: {
        value: Boolean,
        server: null,
    },
    watch: {
        server: function () {
            this.getServerStatus();
        },
        deep: true,
    },
    data() {
        return {
            dialog: false,
            status: null,
            errors: "",
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
        getServerStatus() {
            this.status = null;
            axios.post('server/ping', {
                address: this.server.server_ip,
                port: this.server.server_port,
                password: this.server.password,
            }).then(response => {
                this.status = response.data;
                this.errors = null;
            }).catch(error => {
                this.status = null;
                this.errors = errorHandler.alertError(error);
            })
        }
    }
}
</script>
