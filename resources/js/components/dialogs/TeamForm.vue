<template>
    <v-dialog
        v-model="show"
        width="1000"
    >
        <v-card>
            <v-card-title v-if="team" class="headline lighten-2">
                Edit {{ team.name }}
            </v-card-title>
            <v-card-title v-else class="headline lighten-2">
                Create a new team
            </v-card-title>
            <v-card-text>
                <v-alert v-if="errors" style="white-space: pre-line" type="error">{{ errors }}</v-alert>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-text>
                <form class="pt-12">
                    <v-text-field v-model="form.name" label="Team Name" outlined placeholder="Fnatic">

                    </v-text-field>
                    <v-text-field v-model="form.tag"  label="Team Short Name (TAG)" outlined placeholder="FNC">

                    </v-text-field>
                    <v-autocomplete v-model="form.country" :items="countries" item-text="name" item-value="flag"
                                    label="Team Flag" outlined>
                        <template v-slot:item="{item}">
                            <v-list-item ripple>
                                <v-list-item-action>
                                    <v-img :src="'storage/flags/'+item.flag+'.svg'" height="30" width="50"></v-img>
                                </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title>
                                        {{ item.name }}
                                    </v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                            <v-divider class="mt-2"></v-divider>
                        </template>
                    </v-autocomplete>

                    <v-text-field dense label="LOGO" class="pb-6" outlined :value='this.form.image ? this.form.image[0].name : ""' hide-details="auto" readonly>

                    </v-text-field>

                    <v-btn small @click.stop="uploadDialog = true" class="">Upload Image <v-icon dark right>mdi-cloud-upload</v-icon></v-btn>

                    <upload-dialog :dialog.sync="uploadDialog" @filesUploaded="processUpload($event)"></upload-dialog>
                </form>
            </v-card-text>
            <v-card-title v-if="team">
                {{ form.name }} Players
            </v-card-title>
            <v-card-title v-else>
                Players
            </v-card-title>
            <v-card-subtitle>
                Players are saved using <span style="font-weight: bold">steamID64</span>s <br>
                Steam button on the right converts provided string to steamID64 <br>
                Supports: steamID64, steamID32, Vanity url, steamcommunity url
            </v-card-subtitle>
            <v-divider></v-divider>
            <v-card-text>
                <form class="pt-12">

                    <v-subheader class="pl-0">
                        Player Count ({{ playerCount }})
                    </v-subheader>
                    <v-slider
                        v-model="playerCount"
                        max="15"
                        min="5"
                        thumb-label
                    ></v-slider>

                    <v-text-field v-for="index in playerCount" :key="index" v-model="form.players[index-1]"
                                  :hint="playerNames[index-1]" :label="'Player #'+(index)"
                                  :loading="loadingPlayer[index-1]" append-icon="mdi-steam" class="py-2" clearable outlined
                                  persistent-hint
                                  dense
                                  @click:clear="clearPlayer(index-1)"
                                  @click:append="getPlayerName(form.players[index-1], index-1)">
                    </v-text-field>

                </form>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
                <v-btn text
                       @click="show = false">
                    Cancel
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn
                    v-if="team"
                    color="primary"
                    text
                    @click="updateTeam()"
                >
                    Update

                </v-btn>
                <v-btn
                    v-else
                    color="primary"
                    text
                    @click="createTeam()"
                >
                    Create

                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import {errorHandler} from "../../helpers/error_to_alert";
import UploadDialog from "./UploadDialog";
import {mapGetters} from "vuex";

export default {
    name: "TeamForm",
    components: {UploadDialog},
    props: {
        value: Boolean,
        countries: null,
        team: null,
    },
    watch: {
        team: function () {
            if (this.team)
                this.updateForm();
            else {
                this.clearForm();
            }
        },
        deep: true,
    },
    data() {
        return {
            uploadDialog: false,
            errors: '',
            playerCount: 7,
            form: {
                id: null,
                name: '',
                tag: '',
                country: '',
                image: null,
                players: [],
            },
            loadingPlayer: [],
            playerNames: new Array(this.playerCount),
        }
    },
    computed: {
        ...mapGetters([
            'instance'
        ]),
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
        clearForm() {
            this.errors = '';
            this.form.id = null;
            this.form.name = '';
        },
        updateForm() {
            this.errors = '';
            this.form.id = this.team.id;
            this.form.name = this.team.name;
            this.form.tag = this.team.tag;
            this.form.country = this.team.flag;
        },
        createTeam() {
            this.form.instance_id = this.instance;
            this.$store.dispatch('addTeam', this.form)
                .then(response => {
                    this.show = false;
                }).catch(error => {
                this.errors = errorHandler.alertError(error);
            });
        },
        updateTeam() {
            this.$store.dispatch('updateTeam', this.form)
                .then(response => {
                    this.show = false;
                }).catch(error => {
                this.errors = errorHandler.alertError(error);
            });
        },
        processUpload(file) {
            this.form.image = file;
        },
        clearPlayer(index) {
            console.log('asdasdsad')
            this.$set(this.loadingPlayer, index, false);
            this.$set(this.playerNames, index, null);
            this.$set(this.form.players, index, null);

        },
        getPlayerName(id, index) {
            this.$set(this.loadingPlayer, index, true);
            axios.get('steamApi/userInfo', {
                params: {
                    steam_id: id
                }
            }).then(response => {
                console.log(response);
                this.$set(this.form.players, index, response.data.steamid);
                this.$set(this.playerNames, index, "Name: " + response.data.personaname);
                this.$set(this.loadingPlayer, index, false);
            }).catch(error => {
                this.$set(this.playerNames, index, "Player not found.");
                this.$set(this.loadingPlayer, index, false);
            });
        },

    },

}
</script>
