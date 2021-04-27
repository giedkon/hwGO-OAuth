<template>
        <v-btn color="primary" x-small @click.stop.prevent="copyText">
            {{ label }}
            <v-icon small icon>{{icon}}</v-icon>
            <input id="copy_input" :value="text" type="hidden">
            <v-snackbar timeout="1000" :color="tooltipSuccess ? 'primary' : 'error'" v-model="showTooltip">
                {{tooltip}}
            </v-snackbar>
        </v-btn>
</template>
<script>
export default {
    name: "CopyToClipBoardButton",
    props: ['text', 'icon', 'label'],
    data () {
        return {
            tooltip: "",
            tooltipSuccess: false,
            showTooltip: false,
        }
    },
    methods: {
        copyText() {
            let inputText = document.querySelector('#copy_input')
            inputText.setAttribute('type', 'text')
            inputText.select()
            try {
                let successful = document.execCommand('copy');
                this.tooltip = successful ? 'Successfully copied "' + this.text + '"': 'Could not copy "' + this.text + '" to clipboard';
                this.tooltipSuccess = true;
                this.showTooltip = true;
            } catch (err) {
                this.tooltip = 'Oops, unable to copy';
                this.tooltipSuccess = false;
                this.showTooltip = true;
            }

            /* unselect the range */
            inputText.setAttribute('type', 'hidden')
            window.getSelection().removeAllRanges()
        },
    },

}
</script>
