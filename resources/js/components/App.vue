<template>
    <v-app>
        <AppBar></AppBar>
        <v-container fill-height>
            <router-view></router-view>
        </v-container>
        <AppFooter></AppFooter>
    </v-app>
</template>
<script>
import AppFooter from "./App-Footer";
import AppBar from "./App-Bar";
export default {
    components: {AppBar, AppFooter},
    watch: {
        '$route':{
            handler: (to, from) => {
                document.title = to.meta.title || 'Your Website'
            },
            immediate: true
        }
    },
}
</script>
