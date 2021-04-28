<template>
    <v-container>
        <v-card :loading="loadingTeams" elevation="4" outlined>
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
                <server-form v-model="showFormDialog" v-bind:server="selected"></server-form>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script>
export default {
    name: "Teams.vue",
    data() {
        return {
            showFormDialog: false,
            error: "",
            selected: null,
            loadingTeams: true,
            headers: [
                {text: "Server Name", align: "start", value: "name", sortable: true},
                {text: "Server IP", value: "server_ip", sortable: true},
                {text: "Server Port", value: "server_port", sortable: true},
                {text: "RCON PASSWORD", value: "password", sortable: false},
                {text: "Actions", align: "center", value: "actions", sortable: false},
            ],
        }
    },
}
</script>
