<template>
    <v-dialog
        v-model="show"
        width="1000"
    >
        <v-card>
            <v-card-title v-if="instance" class="headline lighten-2">
                Edit {{ instance.name }}
            </v-card-title>
            <v-card-title v-else class="headline lighten-2">
                Create a new instance
            </v-card-title>
            <v-card-text>
                <v-alert v-if="errors" style="white-space: pre-line" type="error">{{ errors }}</v-alert>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-text>
                <form class="pt-12">
                    <v-text-field v-model="form.name" dense label="Instance Name" outlined placeholder="Tournament #1">

                    </v-text-field>


                    <v-text-field :value='this.form.image ? this.form.image[0].name : ""' hide-details="auto" readonly>

                        <template v-slot:prepend>
                            <v-btn @click.stop="uploadDialog = true">Upload Image</v-btn>
                        </template>

                    </v-text-field>


                    <upload-dialog :dialog.sync="uploadDialog" @filesUploaded="processUpload($event)"></upload-dialog>

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
                    v-if="instance"
                    color="primary"
                    text
                    @click="updateInstance()"
                >
                    Update

                </v-btn>
                <v-btn
                    v-else
                    color="primary"
                    text
                    @click="createInstance()"
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

export default {
    name: "InstanceForm",
    components: {UploadDialog},
    props: {
        value: Boolean,
        instance: null,
    },
    watch: {
        instance: function () {
            if (this.instance)
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
            form: {
                id: null,
                name: '',
                image: null,
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
            this.form.id = null;
            this.form.name = '';
            this.form.image = '';
        },
        updateForm() {
            this.form.id = this.instance.id;
            this.form.name = this.instance.name;
            this.form.image = this.instance.image;
        },
        processUpload(file) {
            this.form.image = file;
        },
        createInstance() {
            let formData = new FormData();
            formData.append('name', this.form.name);
            formData.append('image', this.form.image[0]);
            console.log(formData);

            this.$store.dispatch('addInstance', formData).then(response => {
                    this.show = false;
                }).catch(error => {
                this.errors = errorHandler.alertError(error);
            });
        },
        updateInstance() {
            let formData = new FormData();
            formData.append('id', this.form.id);
            formData.append('name', this.form.name);
            formData.append('image', this.form.image[0]);
            console.log(formData);

            this.$store.dispatch('updateInstance', formData).then(response => {
                this.show = false;
            }).catch(error => {
                this.errors = errorHandler.alertError(error);
            });
        }
    }
}
</script>
