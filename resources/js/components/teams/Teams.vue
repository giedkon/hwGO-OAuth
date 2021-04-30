<template>
    <v-container>
        <v-card :loading="loadingTeams" elevation="4" outlined>
            <v-card-title>
                <v-img :src="currentInstance.image_small" contain max-height="32" max-width="64">
                </v-img>
                {{ currentInstance.name }} Teams (x{{allTeams.length}})
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
                            Add new team
                            <v-icon dark right>
                                mdi-account-group
                            </v-icon>
                        </v-btn>

                    </v-col>
                </v-row>

                <v-data-table :footer-props="{'items-per-page-options':[32, 64, 128, 256, -1]}"
                              :loading="loadingTeams" :headers="headers" :items="allTeams" class="elevation-2 pt-4" disable-filtering
                              light>

                    <template v-slot:item.flag="{item}">
                        <v-img :src="'storage/flags/'+item.flag+'.svg'" height="30" width="50"></v-img>
                    </template>
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
            </v-card-text>
        </v-card>
        <TeamForm v-model="showFormDialog" v-bind:team="selected" v-bind:countries="countries"></TeamForm>
    </v-container>
</template>

<script>
import {mapGetters} from "vuex";
import {errorHandler} from "../../helpers/error_to_alert";
import TeamForm from "../dialogs/TeamForm";
import {countries} from "../utility/countries"

export default {
    name: "Teams.vue",
    components: {TeamForm},
    computed: {
        ...mapGetters([
            'instance',
            'currentInstance',
            'allTeams'
        ])
    },
    data() {
        return {
            countries: countries,
            showFormDialog: false,
            error: "",
            selected: null,
            loadingTeams: true,
            headers: [
                {text: "", align: "logo", value: "logo"},
                {text: "Country", value: "flag", sortable: true},
                {text: "Team Name", align: "start", value: "name", sortable: true},
                {text: "Team Tag", value: "tag", sortable: true},
                {text: "Actions", align: "center", value: "actions", sortable: false},
            ],
        }
    },
    methods: {
        fetchTeams() {
            this.loadingTeams = true;
            this.$store.dispatch('fetchTeams', {instance_id: this.instance}).then(response => {
                this.loadingTeams = false;
            }).catch(error => {
                console.log(error);
                this.error = errorHandler.alertError(error);
            });
        },
    },
    created() {
        this.fetchTeams();
    }
}
</script>
