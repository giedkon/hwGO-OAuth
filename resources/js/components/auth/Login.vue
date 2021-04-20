<template>
    <v-container>
        <v-form @submit.prevent="login">
            <v-row>
                <v-spacer md="3" sm="2"></v-spacer>
                <v-col cols="12"  md="6" sm="8">
                    <v-alert v-if="error" dense border="bottom" type="error">
                        {{ error }}
                    </v-alert>
                </v-col>
                <v-spacer md="3" sm="2"></v-spacer>
            </v-row>
            <v-row align-self="center">
                <v-spacer  md="3" sm="2"></v-spacer>
                <v-col cols="12" md="6" sm="8">
                    <v-text-field outlined v-model="form.email" label="Name" placeholder="username">

                    </v-text-field>
                </v-col>
                <v-spacer md="3" sm="2"></v-spacer>
            </v-row>
            <v-row>
                <v-spacer md="3" sm="2"></v-spacer>
                <v-col cols="12" md="6" sm="8">
                    <v-text-field
                        outlined
                        v-model="form.password"
                        :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                        :type="show1 ? 'text' : 'password'"
                        hint="At least 8 characters"
                        label="Password"
                        @click:append="show1 = !show1">
                    </v-text-field>
                </v-col>
                <v-spacer md="3" sm="2"></v-spacer>
            </v-row>
            <v-row>
                <v-spacer md="3" sm="2"></v-spacer>
                <v-col align="right" cols="12" md="6" sm="8">
                    <v-btn type="submit">
                        Sign in
                    </v-btn>
                </v-col>
                <v-spacer md="3" sm="2"></v-spacer>
            </v-row>
        </v-form>
    </v-container>
</template>

<script>
export default {
    name: "Login.vue",
    data() {
        return {
            show1: false,
            message: "",
            form: {
                email: '',
                password: '',
            },
            error: null,
        }
    },
    methods: {
        login() {
            this.$store.dispatch('retrieveToken', {
                username: this.form.email,
                password: this.form.password
            }).then(response => {
                this.$router.push('/');
            }).catch(error => {
                console.log(error);
                this.error = error.response.data;
            });
        }
    }
}
</script>

<style scoped>

</style>
