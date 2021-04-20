<template>

</template>

<script>
export default {
    name: "Logout",
    created() {
        this.$store.dispatch('destroyToken')
            .then(response => {
                this.$router.push('/');
            }).catch(error => {
        });
    }
}
</script>
