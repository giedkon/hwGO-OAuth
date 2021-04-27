<template>
    <v-container>
        <v-card v-if="currentInstance" elevation="4" outlined>
            <v-card-title>
                <v-img :src="currentInstance.image_small" contain max-height="64" max-width="128">
                </v-img>
                <v-select :items="instances"
                          :value="{'id': parseInt(this.$store.state.instance.instance)}"
                          hide-details="auto"
                          item-text="name"
                          item-value="id"
                          @input="changedInstance">

                </v-select>
                <v-spacer></v-spacer>
                <v-btn
                    class="mr-2"
                    color="primary"
                    elevation="0"
                    fab
                    x-small
                    @click.stop="showFormDialog=true; selected=null"
                >
                    <v-icon dark small>
                        mdi-plus
                    </v-icon>
                </v-btn>
                <v-btn
                    class="mr-2"
                    color="primary"
                    elevation="0"
                    fab
                    x-small
                    @click.stop="showFormDialog=true; selected=currentInstance"
                >
                    <v-icon dark small>
                        mdi-pencil-outline
                    </v-icon>
                </v-btn>
                <v-btn
                    color="primary"
                    elevation="0"
                    fab
                    x-small
                    @click.stop="removeInstance(currentInstance)"
                >
                    <v-icon dark small>
                        mdi-close
                    </v-icon>
                </v-btn>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                Currently nothing here, but an instance will hold teams / players / matches
            </v-card-text>
        </v-card>
        <v-card v-else elevation="4" outlined>
            <v-card-title>
                NO INSTANCE SELECTED
                <v-spacer></v-spacer>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                Currently nothing here, but an instance will hold teams / players / matches
            </v-card-text>
        </v-card>
        <instance-form v-model="showFormDialog" :instance="selected"></instance-form>
    </v-container>
</template>

<script>
import {errorHandler} from "../../helpers/error_to_alert";
import {mapGetters} from "vuex";
import InstanceForm from "../dialogs/InstanceForm";

export default {
    name: "Landing",
    components: {InstanceForm},
    computed: {
        ...mapGetters([
            'instance',
            'currentInstance',
            'instances',
        ])
    },
    data() {
        return {
            showFormDialog: false,
            selected: null,
            error: '',
        }
    },
    methods: {
        changedInstance(event) {
            this.$store.dispatch('setInstance', event);
        },
        fetchServers() {
            this.$store.dispatch('fetchInstances', {}).then(response => {
            }).catch(error => {
                console.log(error);
                this.error = errorHandler.alertError(error);
            });
        },
        removeInstance(item) {
            let r = confirm("Are you sure?")
            if (r) {
                this.$store.dispatch('removeInstance', {instance: item}).then(response => {
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
