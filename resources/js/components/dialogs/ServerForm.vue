<template>
    <v-dialog
        v-model="show"
        width="1000"
    >
        <v-card>
            <v-card-title v-if="server" class="headline lighten-2">
                    Edit {{server.name}}
            </v-card-title>
            <v-card-title v-else="server" class="headline lighten-2">
                Create a new server
            </v-card-title>
            <v-card-text>
                <v-alert v-if="errors" type="error" style="white-space: pre-line">{{ errors }}</v-alert>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-text>
                <form class="pt-12">
                    <v-text-field v-model="form.name" dense label="Server Name" outlined placeholder="Server #1">

                    </v-text-field>

                    <v-text-field v-model="form.ip" dense label="Server IP" outlined placeholder="127.0.0.1">

                    </v-text-field>

                    <v-text-field v-model="form.port" dense label="Server Port" outlined placeholder="27015">

                    </v-text-field>

                    <v-text-field v-model="form.gotv" dense label="Server GOTV Port" outlined placeholder="27020">

                    </v-text-field>

                    <v-text-field v-model="form.rcon" dense label="RCON Password" outlined placeholder="*************">

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
                    v-if="server"
                    color="primary"
                    text
                    @click="updateServer()"
                >
                    Update

                </v-btn>
                <v-btn
                    v-else
                    color="primary"
                    text
                    @click="createServer()"
                >
                    Create

                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import {errorHandler} from "../../helpers/error_to_alert";

export default {
    name: "ServerForm",
    props: {
        value: Boolean,
        server: null,
    },
    watch: {
        server: function () {
            if(this.server)
                this.updateForm();
            else {
                this.clearForm();
            }
        },
        deep: true,
    },
    data() {
        return {
            errors: '',
            form: {
                id: null,
                name: '',
                ip: '',
                port: '',
                gotv: '',
                rcon: '',
            }
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
        clearForm() {
            this.errors = '',
            this.form.id = null;
            this.form.name = '';
            this.form.ip = '';
            this.form.port = '';
            this.form.gotv = '';
            this.form.rcon = '';
        },
        updateForm() {
            this.errors = '',
            this.form.id = this.server.id;
            this.form.name = this.server.name;
            this.form.ip = this.server.server_ip;
            this.form.port = this.server.server_port;
            this.form.gotv = this.server.gotv_port;
            this.form.rcon = this.server.password;
        },
        createServer() {
            this.$store.dispatch('addServer', this.form)
                .then(response => {
                    this.show = false;
                }).catch(error => {
                   this.errors = errorHandler.alertError(error);
            });
        },
        updateServer() {
            this.$store.dispatch('updateServer', this.form)
                .then(response => {
                    this.show = false;
                }).catch(error => {
                this.errors = errorHandler.alertError(error);
            });
        }
    }
}
</script>
